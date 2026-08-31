// inspect-glb.mjs
// Run: node inspect-glb.mjs /path/to/cakegalley.glb
// Requires: npm install @gltf-transform/core @gltf-transform/extensions
//
// Prints every node's name, world position, and (for meshes) a world-space
// bounding box + center — exactly what's needed to pick real camera
// targets for each cake instead of guessed coordinates.

import { NodeIO } from '@gltf-transform/core';
import { ALL_EXTENSIONS } from '@gltf-transform/extensions';

const path = process.argv[2];
if (!path) {
  console.error('Usage: node inspect-glb.mjs /path/to/cakegalley.glb');
  process.exit(1);
}

const io = new NodeIO().registerExtensions(ALL_EXTENSIONS);
const doc = await io.read(path);
const root = doc.getRoot();

function worldMatrix(node) {
  let m = node.getMatrix();
  let parent = node.getParentNode ? node.getParentNode() : null;
  // gltf-transform stores local matrices; walk up manually
  let chain = [node];
  let p = node;
  while (p.listParents) {
    const parents = p.listParents().filter(x => x.propertyType === 'Node');
    if (!parents.length) break;
    p = parents[0];
    chain.unshift(p);
  }
  // Compose local matrices top-down (simple 4x4 mult, translation-focused)
  let acc = [1,0,0,0, 0,1,0,0, 0,0,1,0, 0,0,0,1];
  function mul(a, b) {
    const r = new Array(16).fill(0);
    for (let i = 0; i < 4; i++)
      for (let j = 0; j < 4; j++)
        for (let k = 0; k < 4; k++)
          r[i * 4 + j] += a[i * 4 + k] * b[k * 4 + j];
    return r;
  }
  for (const n of chain) {
    const t = n.getTranslation();
    const s = n.getScale();
    const q = n.getRotation();
    // Build TRS matrix (row-major-ish, good enough for a position readout)
    // For simplicity just accumulate translation (covers the common case
    // where gallery objects aren't deeply rotated/scaled in parents).
    acc = mul(acc, [
      s[0], 0, 0, 0,
      0, s[1], 0, 0,
      0, 0, s[2], 0,
      t[0], t[1], t[2], 1
    ]);
  }
  return [acc[12], acc[13], acc[14]];
}

console.log(`\nScene graph for: ${path}\n${'='.repeat(60)}`);

for (const scene of root.listScenes()) {
  console.log(`\nSCENE: ${scene.getName() || '(unnamed)'}`);
  const walk = (node, depth) => {
    const pos = worldMatrix(node);
    const mesh = node.getMesh();
    const indent = '  '.repeat(depth);
    let extra = '';
    if (mesh) {
      let min = [Infinity,Infinity,Infinity], max = [-Infinity,-Infinity,-Infinity];
      for (const prim of mesh.listPrimitives()) {
        const posAttr = prim.getAttribute('POSITION');
        if (!posAttr) continue;
        const bbMin = posAttr.getMinNormalized ? null : null;
        const arr = posAttr.getArray();
        for (let i = 0; i < arr.length; i += 3) {
          min[0] = Math.min(min[0], arr[i]);
          min[1] = Math.min(min[1], arr[i+1]);
          min[2] = Math.min(min[2], arr[i+2]);
          max[0] = Math.max(max[0], arr[i]);
          max[1] = Math.max(max[1], arr[i+1]);
          max[2] = Math.max(max[2], arr[i+2]);
        }
      }
      const center = [
        (min[0]+max[0])/2 + pos[0],
        (min[1]+max[1])/2 + pos[1],
        (min[2]+max[2])/2 + pos[2]
      ];
      extra = ` [MESH bbox local min=(${min.map(n=>n.toFixed(2))}) max=(${max.map(n=>n.toFixed(2))}) approxWorldCenter=(${center.map(n=>n.toFixed(2))})]`;
    }
    console.log(`${indent}- ${node.getName() || '(unnamed node)'} worldPos≈(${pos.map(n=>n.toFixed(2))})${extra}`);
    for (const child of node.listChildren()) walk(child, depth + 1);
  };
  for (const node of scene.listChildren()) walk(node, 1);
}
console.log('\nDone. Paste this full output back into the chat.\n');
