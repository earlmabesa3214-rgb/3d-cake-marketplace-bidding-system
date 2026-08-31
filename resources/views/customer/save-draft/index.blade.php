@extends('layouts.customer')

@section('title', 'Scene Calibration')

@section('content')

@php
    // Slot 0 -> Scene 2 ... Slot 4 -> Scene 6. Scene 1 is the overview.
    $draftSlots = collect($drafts ?? [])->take(5)->values();
@endphp
<style>
html, body {
    height: 100%;
    overflow: hidden;
}
#draftSceneBg {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
    background: #FBF6EC;
    pointer-events: auto;
}
#draftSceneContainer { position: absolute; inset: 0; pointer-events: auto; }

#draftSceneContainer canvas { width: 100% !important; height: 100% !important; display: block; }
#draftSceneLoading {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    transition: opacity 0.5s ease;
    pointer-events: none;
    z-index: 10;
}
#draftSceneLoading.hidden { opacity: 0; }
.draft-scene-spinner {
    width: 34px; height: 34px;
    border: 3px solid rgba(160,100,30,0.15);
    border-top-color: rgba(180,120,40,0.85);
    border-radius: 50%;
    animation: draftSpin 0.85s linear infinite;
}
@keyframes draftSpin { to { transform: rotate(360deg); } }

/* ================= DRAFT OVERLAY PANELS ================= */
.draft-panel {
    position: absolute; inset: 0;
    display: none;
    z-index: 5;
    pointer-events: none;
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
}
.draft-panel.active { display: block; }

/* Scene 1 — overview of everything saved */
.draft-overview {
    overflow: hidden;
    pointer-events: none;
}
.draft-overview-title {
    position: absolute;
    top: 40px; left: 0; right: 0;
    text-align: center;
    font-size: 1.4rem; font-weight: 800;
    color: #3B1F0E;
    margin: 0 0 6px;
    pointer-events: none;
}
.draft-overview-sub {
    position: absolute;
    top: 76px; left: 0; right: 0;
    text-align: center;
    font-size: .82rem; color: #8A7B6C;
    margin: 0;
    pointer-events: none;
}
.draft-overview-grid {
    position: absolute;
    inset: 0;
    pointer-events: none;
}
.draft-overview-thumb {
    position: absolute;
    width: 150px;
    pointer-events: auto;
    transform: translate(-50%, -50%);
    background: rgba(255,255,255,0.72);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(160,100,30,0.15);
    border-radius: 14px;
    padding: 12px;
    text-align: center;
    box-shadow: 0 6px 18px rgba(120,80,30,0.14);
}
.draft-overview-thumb img {
    width: 100%; height: 110px;
    object-fit: contain;
    display: block;
    margin-bottom: 8px;
}
.draft-overview-thumb span {
    font-size: .72rem; font-weight: 700; color: #6B3A1F;
    display: block;
}
.draft-empty-msg {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center; color: #8A7B6C; font-size: .88rem;
    pointer-events: none;
}
.draft-calibrate-btn {
    position: absolute;
    top: 90px; right: 24px;
    pointer-events: auto;
    background: #B85C38; color: #fff;
    border: none; border-radius: 8px;
    padding: 8px 14px; font-size: .78rem; font-weight: 700;
    cursor: pointer; z-index: 9999;
}
.draft-offset-panel {
    display: none;
    position: absolute;
    top: 134px; right: 24px;
    width: 260px;
    pointer-events: auto;
    background: rgba(20,10,5,0.85);
    border-radius: 10px;
    padding: 10px;
    z-index: 9999;
}
.draft-offset-panel textarea {
    width: 100%; height: 160px;
    font-family: monospace; font-size: .72rem;
    background: #1a1a1a; color: #d8c9a8;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 6px; padding: 6px;
    resize: none; margin-bottom: 8px;
}
.draft-offset-panel button {
    width: 100%;
    background: #B85C38; color: #fff;
    border: none; border-radius: 6px;
    padding: 7px; font-size: .74rem; font-weight: 700;
    cursor: pointer;
}
.draft-overview-thumb.calibrating {
    cursor: grab;
    outline: 2px dashed rgba(184,92,56,0.7);
    touch-action: none;
}
.draft-overview-thumb.calibrating:active { cursor: grabbing; }

/* Scenes 2–6 — one detail card per saved draft */
.draft-detail {
    align-items: center;
    justify-content: flex-end;
    padding: 5vh 6vw;
    pointer-events: none;
    display: none;
}
.draft-detail.active { display: flex; }
.draft-detail-card {
    pointer-events: auto;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(160,100,30,0.18);
    border-radius: 20px;
    padding: 20px;
    display: flex;
    gap: 16px;
    max-width: 420px;
    box-shadow: 0 16px 40px rgba(80,50,20,0.28);
}
.draft-detail-img {
    width: 130px; height: 130px;
    object-fit: contain;
    flex-shrink: 0;
}
.draft-detail-info h3 {
    margin: 0 0 8px;
    font-size: 1.02rem; font-weight: 800; color: #3B1F0E;
}
.draft-detail-info ul {
    list-style: none; padding: 0; margin: 0 0 14px;
    font-size: .78rem; color: #6B3A1F; line-height: 1.7;
}
.draft-detail-actions { display: flex; gap: 8px; }
.btn-draft-continue {
    background: #B85C38; color: #fff;
    padding: 9px 16px; border-radius: 9px;
    text-decoration: none; font-size: .78rem; font-weight: 700;
}
.btn-draft-delete {
    background: transparent;
    border: 1.5px solid #C0392B; color: #C0392B;
    padding: 9px 16px; border-radius: 9px;
    font-size: .78rem; font-weight: 700; cursor: pointer;
}
.draft-empty-slot {
    align-items: center; justify-content: center;
}
.draft-empty-slot p {
    pointer-events: auto;
    background: rgba(255,255,255,0.7);
    padding: 14px 22px; border-radius: 12px;
    font-size: .82rem; color: #8A7B6C;
}

/* "Storage full" modal */
.draft-modal-overlay {
    position: fixed; inset: 0; z-index: 999;
    background: rgba(30,15,5,0.55);
    display: flex; align-items: center; justify-content: center;
}
.draft-modal {
    background: #fff; border-radius: 16px;
    padding: 26px 28px; max-width: 360px; text-align: center;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
}
.draft-modal h3 { margin: 0 0 10px; font-size: 1.05rem; color: #3B1F0E; }
.draft-modal p { margin: 0 0 18px; font-size: .84rem; color: #6B3A1F; line-height: 1.6; }
.draft-modal .draft-modal-actions { display: flex; gap: 8px; justify-content: center; }
.draft-modal button, .draft-modal a {
    padding: 9px 18px; border-radius: 9px; font-size: .8rem; font-weight: 700;
    cursor: pointer; text-decoration: none;
}
.draft-modal .btn-modal-close { background: #B85C38; color: #fff; border: none; }
.draft-modal .btn-modal-manage { background: transparent; border: 1.5px solid #B85C38; color: #B85C38; }
</style>

<div id="draftSceneBg">
    <div id="draftSceneContainer"></div>

    {{-- SCENE 1: overview of every saved draft --}}
    <div class="draft-panel draft-overview" id="draftOverview" data-scene="1">
        <div class="draft-overview-title">Your Saved Drafts</div>
           <div class="draft-overview-sub">{{ $draftSlots->count() }} / 5 slots used — scroll to browse each one</div>
        <button type="button" class="draft-calibrate-btn" id="draftCalibrateToggle">Calibrate positions</button>
        <div class="draft-offset-panel" id="draftOffsetPanel">
            <textarea id="draftOffsetOutput" readonly>{}</textarea>
            <button type="button" id="draftOffsetCopy">Copy coordinates</button>
        </div>
        <div class="draft-overview-grid">
            @forelse($draftSlots as $d)
                <div class="draft-overview-thumb">
                    <img src="{{ $d['preview_image'] ?? '' }}" alt="{{ $d['cakeLabel'] ?? 'Saved cake' }}">
                    <span>{{ $d['cakeLabel'] ?? 'Custom Cake' }}</span>
                </div>
            @empty
                <p class="draft-empty-msg">No saved drafts yet — design a cake and hit "Save Draft" to see it here.</p>
            @endforelse
        </div>
    </div>

    {{-- SCENES 2–6: one detail card per slot --}}
    @foreach($draftSlots as $i => $d)
        @php $sceneNum = $i + 2; @endphp
        <div class="draft-panel draft-detail" id="draftDetail{{ $sceneNum }}" data-scene="{{ $sceneNum }}">
            <div class="draft-detail-card">
                <img class="draft-detail-img" src="{{ $d['preview_image'] ?? '' }}" alt="">
                <div class="draft-detail-info">
                    <h3>{{ $d['cakeLabel'] ?? 'Custom Cake' }}</h3>
                    <ul>
                        <li>Shape: {{ $d['shapeLabel'] ?? '—' }}</li>
                        <li>Frosting: {{ is_array($d['frostings'] ?? null) ? implode(' + ', $d['frostings']) : '—' }}</li>
                        <li>Add-ons: {{ is_array($d['addons'] ?? null) ? count($d['addons']) : 0 }}</li>
                        <li>Est. Total: ₱{{ number_format($d['total'] ?? 0) }}</li>
                    </ul>
                    <div class="draft-detail-actions">
                        <a class="btn-draft-continue" href="{{ route('customer.cake-builder.index') }}?resume_draft={{ $d['id'] }}">Continue</a>
                        <form method="POST" action="{{ route('customer.cake-builder.discardDraft') }}" onsubmit="return confirm('Delete this saved cake?');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $d['id'] }}">
                            <button type="submit" class="btn-draft-delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @for($i = $draftSlots->count(); $i < 5; $i++)
        @php $sceneNum = $i + 2; @endphp
        <div class="draft-panel draft-detail draft-empty-slot" id="draftDetail{{ $sceneNum }}" data-scene="{{ $sceneNum }}">
            <p>Empty slot — save a new cake draft to fill this spot.</p>
        </div>
    @endfor

    @if(session('draft_limit_reached'))
        <div class="draft-modal-overlay" id="draftFullModal">
            <div class="draft-modal">
                <h3>Draft Storage Full</h3>
                <p>You can only keep 5 saved drafts at a time. Delete one below to make room for a new cake.</p>
                <div class="draft-modal-actions">
                    <button class="btn-modal-close" onclick="document.getElementById('draftFullModal').style.display='none';">Got it</button>
                    <a class="btn-modal-manage" href="#" onclick="document.getElementById('draftFullModal').style.display='none';goToScene(2);return false;">Manage drafts</a>
                </div>
            </div>
        </div>
    @endif

    <div id="draftSceneLoading">
        <div class="draft-scene-spinner"></div>
    </div>
</div>

<script type="module">
import * as THREE        from '/js/three/three.module.js';
import { OrbitControls } from '/js/three/OrbitControls.js';
import { GLTFLoader }    from '/js/three/GLTFLoader.js';
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}
window.scrollTo(0, 0);

const container = document.getElementById('draftSceneContainer');
const loadingEl = document.getElementById('draftSceneLoading');
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));
renderer.setSize(container.clientWidth, container.clientHeight);
renderer.outputEncoding = THREE.sRGBEncoding;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.05;
renderer.setClearColor(0x000000, 0);
container.appendChild(renderer.domElement);

const scene  = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 100);

// ── Camera controls disabled ──
// Camera movement is fully scripted via SCENES; no user-driven orbit,
// zoom, or pan. OrbitControls is kept only so we can drive
// controls.target / controls.update() for the scripted transitions.
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping  = true;
controls.dampingFactor  = 0.08;
controls.enabled        = false;

scene.add(new THREE.AmbientLight(0xFFF4E0, 0.55));
const keyLight = new THREE.DirectionalLight(0xFFEFD0, 1.1);
keyLight.position.set(3, 6, 4);
scene.add(keyLight);
const fillLight = new THREE.DirectionalLight(0xE8C870, 0.35);
fillLight.position.set(-4, 2, -3);
scene.add(fillLight);
const rimLight = new THREE.PointLight(0xFFDDA0, 0.5, 20);
rimLight.position.set(0, 3, -4);
scene.add(rimLight);

const SCENES = {
    1: { camera: { position: [18.3, 5.15, -4.58],  target: [19.3, 5.08, -4.58]  } },
    2: { camera: { position: [19.38, 5.46, -5.1],   target: [19.97, 5.41, -5.1]  } },
    3: { camera: { position: [19.36, 5.46, -4.61],  target: [19.95, 5.41, -4.62] } },
    4: { camera: { position: [19.37, 5.46, -4.11],  target: [19.96, 5.41, -4.12] } },
    5: { camera: { position: [19.37, 4.62, -4.84],  target: [20.09, 4.56, -4.82] } },
    6: { camera: { position: [19.35, 4.62, -4.32],  target: [20.07, 4.57, -4.3]  } },
};

const overviewThumbs = Array.from(document.querySelectorAll('.draft-overview-thumb'));

let bgModel = null;
let activeScene = 1;
let isTransitioning = false;
let transitionTarget = null;

function updateDraftPanels(num){
    document.querySelectorAll('.draft-panel').forEach(p=>{
        p.classList.toggle('active', parseInt(p.dataset.scene) === num);
    });
}

function goToScene(num, instant = false){
    if (!SCENES[num]) return;
    activeScene = num;
    updateDraftPanels(num);
    const s = SCENES[num];
    if (instant) {
        camera.position.set(...s.camera.position);
        controls.target.set(...s.camera.target);
        controls.update();
        isTransitioning = false;
    } else {
        transitionTarget = {
            position: new THREE.Vector3(...s.camera.position),
            target: new THREE.Vector3(...s.camera.target)
        };
        isTransitioning = true;
    }
}
window.goToScene = goToScene; // used by the "Manage drafts" link in the modal

function project3DToScreen(vec3, cam, cont) {
    const v = vec3.clone().project(cam);
    return {
        x: (v.x * 0.5 + 0.5) * cont.clientWidth,
        y: (-v.y * 0.5 + 0.5) * cont.clientHeight
    };
}
// Calibrated per-slot pixel nudges so each thumbnail sits centered
// on its paper in the Scene 1 overview. Keyed by sceneNum (2–6),
// not by draft ID — so these stay correct even after a slot's
// draft is deleted and replaced with a new one.
const OVERVIEW_OFFSETS = {
    2: { x: 99, y: 89 },   // paper 1
    3: { x: 76, y: 88 },   // paper 2
    4: { x: 39, y: 88 },   // paper 3
    5: { x: 50, y: 25 },   // paper 4
    6: { x: 38, y: 25 },   // paper 5
};

// Cake i (0-indexed) maps to Scene i+2's camera target,
// mirroring the Blade foreach where $sceneNum = $i + 2
function updateOverviewThumbPositions() {
    if (activeScene !== 1) return;
    overviewThumbs.forEach((el, i) => {
        const sceneNum = i + 2;
        const s = SCENES[sceneNum];
        if (!s) return;
        const target = new THREE.Vector3(...s.camera.target);
        const { x, y } = project3DToScreen(target, camera, container);
        const offset = OVERVIEW_OFFSETS[sceneNum] || { x: 0, y: 0 };
        el.style.left = (x + offset.x) + 'px';
        el.style.top = (y + offset.y) + 'px';
    });
}

const urlParams = new URLSearchParams(window.location.search);
const calibrateAllowed = urlParams.get('calibrate') === '1';

let calibrationMode = false;

function refreshOffsetOutput() {
    const out = document.getElementById('draftOffsetOutput');
    if (out) out.value = JSON.stringify(OVERVIEW_OFFSETS, null, 4);
}

function enableThumbDragging() {
    overviewThumbs.forEach((el, i) => {
        const sceneNum = i + 2;
        let dragging = false;

        el.addEventListener('pointerdown', (e) => {
            if (!calibrationMode) return;
            dragging = true;
            el.setPointerCapture(e.pointerId);
        });

        el.addEventListener('pointermove', (e) => {
            if (!calibrationMode || !dragging) return;
            const offset = OVERVIEW_OFFSETS[sceneNum] || (OVERVIEW_OFFSETS[sceneNum] = { x: 0, y: 0 });
            offset.x += e.movementX;
            offset.y += e.movementY;
            refreshOffsetOutput();
        });

        el.addEventListener('pointerup', () => { dragging = false; });
    });
}
enableThumbDragging();

const calibrateBtn = document.getElementById('draftCalibrateToggle');
const offsetPanel   = document.getElementById('draftOffsetPanel');
if (!calibrateAllowed) {
    calibrateBtn.style.display = 'none';
} else {
    calibrateBtn.style.display = 'block';
}
calibrateBtn.addEventListener('click', () => {
    calibrationMode = !calibrationMode;
    calibrateBtn.textContent = calibrationMode ? 'Stop calibrating' : 'Calibrate positions';
    offsetPanel.style.display = calibrationMode ? 'block' : 'none';
    overviewThumbs.forEach(el => el.classList.toggle('calibrating', calibrationMode));
    if (calibrationMode) refreshOffsetOutput();
});

document.getElementById('draftOffsetCopy').addEventListener('click', () => {
    const out = document.getElementById('draftOffsetOutput');
    out.select();
    navigator.clipboard.writeText(out.value).catch(() => document.execCommand('copy'));
});

goToScene(1, true); // page load = scene 1, snap instantly

const gltfLoader = new GLTFLoader();
gltfLoader.load(
    '/models/savedraft.glb',
    (gltf) => {
        bgModel = gltf.scene;
        scene.add(bgModel);

        // Free movement: no distance/angle restrictions. (No camera
        // repositioning here — SCENES coordinates stay in full control.)
        controls.minDistance = 0.01;
        controls.maxDistance = 1000;
        controls.minPolarAngle = 0;
        controls.maxPolarAngle = Math.PI;
        controls.minAzimuthAngle = -Infinity;
        controls.maxAzimuthAngle = Infinity;

        // Re-apply whatever scene is currently active, now that the model
        // exists, in case scroll fired before the model finished loading.
        goToScene(activeScene, true);
        updateOverviewThumbPositions();

        loadingEl.classList.add('hidden');
        setTimeout(() => { loadingEl.style.display = 'none'; }, 300);
    },
    undefined,
    (err) => {
        console.error('Failed to load savedraft.glb', err);
        loadingEl.classList.add('hidden');
        setTimeout(() => { loadingEl.style.display = 'none'; }, 300);
    }
);

// ── Wheel-driven scene switching (one scroll = one scene) ──
const SCROLL_COOLDOWN_MS = 700; // >= the camera lerp settle time in animate()
let scrollLocked = false;

window.addEventListener('wheel', (e) => {
    e.preventDefault();
    if (scrollLocked) return;

    const direction = e.deltaY > 0 ? 1 : -1;
    const nextScene = activeScene + direction;
    if (!SCENES[nextScene]) return;

    scrollLocked = true;
    goToScene(nextScene);
    setTimeout(() => { scrollLocked = false; }, SCROLL_COOLDOWN_MS);
}, { passive: false });

function animate() {
    requestAnimationFrame(animate);
    if (isTransitioning && transitionTarget) {
        camera.position.lerp(transitionTarget.position, 0.08);
        controls.target.lerp(transitionTarget.target, 0.08);
        if (camera.position.distanceTo(transitionTarget.position) < 0.01) {
            isTransitioning = false;
        }
    }
    controls.update();
    updateOverviewThumbPositions();
    renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
    const w = container.clientWidth, h = container.clientHeight;
    renderer.setSize(w, h);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    updateOverviewThumbPositions();
});
</script>

@endsection