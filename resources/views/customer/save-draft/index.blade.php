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

/* Cake images (thumbnails + detail overlays) stay invisible until the
   savedraft.glb case has actually finished loading, so the case never
   appears empty-then-populated. */
.assets-loading .draft-overview-thumb img,
.assets-loading .draft-detail-img {
    visibility: hidden;
}
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
    width: 130px;
    pointer-events: auto;
    transform: translate(-50%, -50%);
    background: transparent;
    text-align: center;
}
.draft-overview-thumb img {
    width: 100%; height: 100px;
    object-fit: contain;
    object-position: center bottom;
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
    width: 300px;
    pointer-events: auto;
    background: rgba(20,10,5,0.85);
    border-radius: 10px;
    padding: 10px;
    z-index: 9999;
}
.draft-offset-panel textarea {
    width: 100%; height: 320px;
    font-family: monospace; font-size: .70rem;
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
.draft-model-title {
    color: #d8c9a8; font-size: .72rem; font-weight: 700; margin-bottom: 8px;
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
    background: transparent;
    padding: 20px;
    display: flex;
    gap: 16px;
    max-width: 420px;
}
.draft-detail-imgs-layer {
    position: absolute;
    inset: 0;
    z-index: 6;
    pointer-events: none;
    display: none;
}
.draft-detail-img {
    position: absolute;
    width: 340px; height: 340px;
    object-fit: contain;
    object-position: center bottom;
    pointer-events: none;
    transform: translate(-50%, -100%);
}
.draft-detail-img.calibrating {
    pointer-events: auto;
    cursor: grab;
    outline: 2px dashed rgba(184,92,56,0.7);
    touch-action: none;
}
.draft-detail-img.calibrating:active { cursor: grabbing; }
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

<div id="draftSceneBg" class="assets-loading">
    <div id="draftSceneContainer"></div>

    <button type="button" class="draft-calibrate-btn" id="draftCalibrateToggle">Calibrate positions</button>
    <div class="draft-offset-panel" id="draftOffsetPanel">
        <textarea id="draftOffsetOutput" readonly>{}</textarea>
        <button type="button" id="draftOffsetCopy">Copy coordinates</button>
    </div>

    {{-- SCENE 1: overview of every saved draft --}}
    <div class="draft-panel draft-overview" id="draftOverview" data-scene="1">
        <div class="draft-overview-title">Your Saved Drafts</div>
           <div class="draft-overview-sub">{{ $draftSlots->count() }} / 5 slots used — scroll to browse each one</div>
        <div class="draft-overview-grid">
            @forelse($draftSlots as $d)
                             <div class="draft-overview-thumb">
                    <img src="{{ $d['preview_image'] ?? '' }}" alt="{{ $d['cakeLabel'] ?? 'Saved cake' }}">
                </div>
            @empty
                <p class="draft-empty-msg">No saved drafts yet — design a cake and hit "Save Draft" to see it here.</p>
            @endforelse
        </div>
    </div>

    {{-- Persistent layer for scene 2–6 cake images — stays visible across
         every scene since neighboring papers remain in view as you scroll --}}
    <div class="draft-detail-imgs-layer" id="draftDetailImgsLayer">
        @foreach($draftSlots as $i => $d)
            @php $sceneNum = $i + 2; @endphp
            <img class="draft-detail-img" id="draftDetailImg{{ $sceneNum }}" src="{{ $d['preview_image'] ?? '' }}" alt="">
        @endforeach
    </div>

    {{-- SCENES 2–6: one detail card per slot --}}
    @foreach($draftSlots as $i => $d)
        @php $sceneNum = $i + 2; @endphp
        <div class="draft-panel draft-detail" id="draftDetail{{ $sceneNum }}" data-scene="{{ $sceneNum }}">
            <div class="draft-detail-card">
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
                                             <form method="POST" action="{{ route('customer.cake-builder.discardDraft') }}" class="draft-delete-form" data-draft-label="{{ $d['cakeLabel'] ?? 'this cake' }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $d['id'] }}">
                            <button type="button" class="btn-draft-delete draft-delete-trigger">Delete</button>
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
    <div class="draft-modal-overlay" id="draftDeleteConfirmModal" style="display:none;">
        <div class="draft-modal">
            <h3>Delete this cake?</h3>
            <p id="draftDeleteConfirmText">Are you sure you want to delete this saved draft? This can't be undone.</p>
            <div class="draft-modal-actions">
                <button type="button" class="btn-modal-manage" id="draftDeleteCancelBtn">Cancel</button>
                <button type="button" class="btn-modal-close" id="draftDeleteConfirmBtn" style="background:#C0392B;">Delete</button>
            </div>
        </div>
    </div>

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
1: { camera: { position: [-0.94, 14.85, 23.07], target: [-1.13, 8.21, 0.09] } },
    2: { camera: { position: [-3.03, 14.07, 11.41], target: [-3.01, 10.77, -0.63] } },
    3: { camera: { position: [2.5, 14.11, 11.41], target: [2.52, 10.76, -0.62] } },
    4: { camera: { position: [3.28, 10.37, 10.5], target: [3.24, 6.79, 0.5] } },
    5: { camera: { position: [-0.25, 10.31, 10.53], target: [-0.28, 6.73, 0.54] } },
    6: { camera: { position: [-3.75, 10.37, 10.52], target: [-4.03, 6.79, 0.53] } },
};


// Left-drag: orbit · Shift + left-drag: pan · Scroll: zoom
let camDragging = false;
let camPanning  = false;
let lastPointerX = 0, lastPointerY = 0;
const ORBIT_SPEED = 0.006;
const PAN_SPEED    = 0.0015;
const ZOOM_SPEED   = 0.0015;
const MIN_ZOOM_DIST = 0.05;

function orbitCamera(dx, dy) {
    const offset = new THREE.Vector3().subVectors(camera.position, controls.target);
    const spherical = new THREE.Spherical().setFromVector3(offset);
    spherical.theta -= dx * ORBIT_SPEED;
    spherical.phi   -= dy * ORBIT_SPEED;
    spherical.phi = Math.max(0.001, Math.min(Math.PI - 0.001, spherical.phi));
    offset.setFromSpherical(spherical);
    camera.position.copy(controls.target).add(offset);
    camera.lookAt(controls.target);
}

function panCamera(dx, dy) {
    const distance = camera.position.distanceTo(controls.target);
    const panScale = distance * PAN_SPEED;
    const right = new THREE.Vector3();
    const up = new THREE.Vector3();
    camera.matrix.extractBasis(right, up, new THREE.Vector3());
    const move = new THREE.Vector3()
        .addScaledVector(right, -dx * panScale)
        .addScaledVector(up, dy * panScale);
    camera.position.add(move);
    controls.target.add(move);
}
function zoomCamera(deltaY) {
    const offset = new THREE.Vector3().subVectors(camera.position, controls.target);
    const distance = offset.length();
    const newDistance = Math.max(MIN_ZOOM_DIST, distance * (1 + deltaY * ZOOM_SPEED));
    offset.setLength(newDistance);
    camera.position.copy(controls.target).add(offset);
}

// Formats the current camera as a ready-to-paste SCENES[n] line,
// e.g.  1: { camera: { position: [18.3, 5.15, -4.58], target: [19.3, 5.08, -4.58] } },
function formatSceneCameraLine(sceneNum) {
    const p = camera.position.toArray().map(n => +n.toFixed(2));
    const t = controls.target.toArray().map(n => +n.toFixed(2));
    return `${sceneNum}: { camera: { position: [${p.join(', ')}], target: [${t.join(', ')}] } },`;
}


const overviewThumbs = Array.from(document.querySelectorAll('.draft-overview-thumb'));

const DETAIL_IMG_OFFSETS = {
    2: { 2: { x: 73,   y: 93  }, 3: { x: 338,  y: 80  }, 4: { x: 179,  y: 287 }, 5: { x: 109,   y: 259}, 6: { x: 22,   y: 228 } },
    3: { 2: { x: -190, y: 64  }, 3: { x: 37,   y: 100 }, 4: { x: 41,   y: 285 }, 5: { x: -36,  y: 267 }, 6: { x: -156, y: 239 } },
    4: { 2: { x: -175, y: 76  }, 3: { x: 74,   y: 4   }, 4: { x: 26,   y: 172 }, 5: { x: -138, y: 161 }, 6: { x: -156, y: 239 } },
    5: { 2: { x: -175, y: 76  }, 3: { x: 74,   y: 4   }, 4: { x: 208,  y: 163 }, 5: { x: 38,   y: 153 }, 6: { x: -88,  y: 154 } },
    6: { 2: { x: -175, y: 76  }, 3: { x: 74,   y: 4   }, 4: { x: 79,  y: 778 }, 5: { x: 231,  y: 171 }, 6: { x: 60,   y: 171 } },
};
// Only the ACTIVE scene's cake is ever shown. Its screen position is
// projected live, every frame, from that scene's own target through the
// live camera — which, once the transition settles, IS that scene's own
// camera (SCENES[activeScene]). Because only one image is visible at a
// time, there is no cross-scene contamination: Scene 2's projection can
// never affect Scene 3's stored offset or vice versa.
function updateDetailImagePosition() {
    const layer = document.getElementById('draftDetailImgsLayer');
    if (!layer) return;
    if (activeScene === 1) {
        layer.style.display = 'none';
        return;
    }
    layer.style.display = 'block';

    // Offsets are looked up per ACTIVE scene, since the same cake needs a
    // different screen position depending on which camera is currently live.
    const sceneOffsets = DETAIL_IMG_OFFSETS[activeScene] || {};

    for (let sceneNum = 2; sceneNum <= 6; sceneNum++) {
        const img = document.getElementById('draftDetailImg' + sceneNum);
        const s = SCENES[sceneNum];
        if (!img || !s) continue;

        img.style.display = 'block';
        const target = new THREE.Vector3(...s.camera.target);
        const { x, y } = project3DToScreen(target, camera, container);
        const offset = sceneOffsets[sceneNum] || { x: 0, y: 0 };
        img.style.left = (x + offset.x) + 'px';
        img.style.top = (y + offset.y) + 'px';
    }
}
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
const OVERVIEW_OFFSETS = {
    2: {
            "x": 2,
            "y": -45
        },
        3: {
            "x": 50,
            "y": -46
        },
        4: {
            "x": 40,
            "y": 7
        },
        5: {
            "x": 20,
            "y": 4
        },
        6: {
            "x": -1,
            "y": 5
},
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
    if (out) out.value = JSON.stringify({
        OVERVIEW_OFFSETS,
        DETAIL_IMG_OFFSETS,
        CAMERA: {
            position: camera.position.toArray().map(n => +n.toFixed(3)),
            target: controls.target.toArray().map(n => +n.toFixed(3))
        }
    }, null, 4);
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

function enableDetailImgDragging() {
    for (let sceneNum = 2; sceneNum <= 6; sceneNum++) {
        const el = document.getElementById('draftDetailImg' + sceneNum);
        if (!el) continue;
        let dragging = false;

        el.addEventListener('pointerdown', (e) => {
            if (!calibrationMode) return;
            dragging = true;
            el.setPointerCapture(e.pointerId);
            e.preventDefault();
        });

        el.addEventListener('pointermove', (e) => {
            if (!calibrationMode || !dragging) return;
            // Mutates ONLY this (activeScene -> cake) pair. Every other
            // scene/cake combination in DETAIL_IMG_OFFSETS is untouched.
            const sceneOffsets = DETAIL_IMG_OFFSETS[activeScene] || (DETAIL_IMG_OFFSETS[activeScene] = {});
            const offset = sceneOffsets[sceneNum] || (sceneOffsets[sceneNum] = { x: 0, y: 0 });
            offset.x += e.movementX;
            offset.y += e.movementY;
            refreshOffsetOutput();
        });

        el.addEventListener('pointerup', () => { dragging = false; });
    }
}
enableDetailImgDragging();
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
    for (let sceneNum = 2; sceneNum <= 6; sceneNum++) {
        const el = document.getElementById('draftDetailImg' + sceneNum);
        if (el) el.classList.toggle('calibrating', calibrationMode);
    }
    if (calibrationMode) {
        refreshOffsetOutput();
    }
});

document.getElementById('draftOffsetCopy').addEventListener('click', () => {
    const out = document.getElementById('draftOffsetOutput');
    out.select();
    navigator.clipboard.writeText(out.value).catch(() => document.execCommand('copy'));
});

// ── Delete draft confirmation modal ──
let pendingDeleteForm = null;
const deleteModal = document.getElementById('draftDeleteConfirmModal');
const deleteConfirmText = document.getElementById('draftDeleteConfirmText');

document.querySelectorAll('.draft-delete-trigger').forEach(btn => {
    btn.addEventListener('click', () => {
        pendingDeleteForm = btn.closest('.draft-delete-form');
        const label = pendingDeleteForm?.dataset.draftLabel || 'this saved draft';
        deleteConfirmText.textContent = `Are you sure you want to delete "${label}"? This can't be undone.`;
        deleteModal.style.display = 'flex';
    });
});
document.getElementById('draftDeleteCancelBtn').addEventListener('click', () => {
    pendingDeleteForm = null;
    deleteModal.style.display = 'none';
});
document.getElementById('draftDeleteConfirmBtn').addEventListener('click', () => {
    if (pendingDeleteForm) pendingDeleteForm.submit();
    deleteModal.style.display = 'none';
});

goToScene(1, true);
const gltfLoader = new GLTFLoader();
gltfLoader.load(
    '/models/savedraft.glb',
    (gltf) => {
         bgModel = gltf.scene;
        scene.add(bgModel);
            // ── TEMP DEBUG: click-to-identify. Click directly on any cake (or
        // any object) in the viewport and the console prints its full path,
        // world center, and bounding-box size. Click the SAME cake near its
        // TOP and near its BASE if you want to check whether frosting/base
        // are separate meshes. ──
        function getPath(obj){
            const parts = [];
            let n = obj;
            while (n && n !== bgModel) { parts.unshift(n.name || '(unnamed)'); n = n.parent; }
            return parts.join(' > ');
        }
        // Attach to document + capture phase, NOT renderer.domElement — the
        // .draft-overview-thumb <img> overlays sit on top of the canvas with
        // pointer-events:auto and would otherwise swallow the click before
        // it ever reaches the WebGL canvas.
        document.addEventListener('pointerdown', (ev) => {
            const rect = renderer.domElement.getBoundingClientRect();
            // Ignore clicks outside the 3D viewport entirely
            if (ev.clientX < rect.left || ev.clientX > rect.right || ev.clientY < rect.top || ev.clientY > rect.bottom) return;
            const mouse = new THREE.Vector2(
                ((ev.clientX - rect.left) / rect.width) * 2 - 1,
                -((ev.clientY - rect.top) / rect.height) * 2 + 1
            );
            const raycaster = new THREE.Raycaster();
            raycaster.setFromCamera(mouse, camera);
                     const hits = raycaster.intersectObject(bgModel, true);
            if (hits.length === 0) { console.log('[click] no mesh hit at', ev.clientX, ev.clientY); return; }
            console.log('[CLICK] ' + hits.length + ' objects along this ray, nearest first:');
            hits.slice(0, 8).forEach((h, i) => {
                const hit = h.object;
                const box = new THREE.Box3().setFromObject(hit);
                const size = box.getSize(new THREE.Vector3());
                const center = box.getCenter(new THREE.Vector3());
                console.log(
                    '  #' + i + '  dist=' + h.distance.toFixed(2) + '  ' + getPath(hit) +
                    '\n      center=(' + center.x.toFixed(2) + ', ' + center.y.toFixed(2) + ', ' + center.z.toFixed(2) + ')' +
                    '  size=(' + size.x.toFixed(2) + ', ' + size.y.toFixed(2) + ', ' + size.z.toFixed(2) + ')'
                );
            });
        }, true); // capture: true — fires before the overlay <img> can eat it
             console.log('Click-to-identify is active — click any cake in the case to log its mesh info.');

        // ── TEMP DIAGNOSTIC: hide all draft thumbnail <img> overlays to see
        // if the "cakes" are actually 3D geometry underneath, or if they
        // disappear entirely (meaning they're 2D photo overlays only). ──
        window._toggleThumbImages = function(hide){
            document.querySelectorAll('.draft-overview-thumb img').forEach(img => {
                img.style.visibility = hide ? 'hidden' : 'visible';
            });
            console.log(hide ? 'Thumb images HIDDEN — check if cakes are still visible in the case.' : 'Thumb images shown again.');
        };
        console.log('Run window._toggleThumbImages(true) in console to hide thumbnail images and check.');
            controls.minDistance = 0.01;
        controls.maxDistance = 1000;
        controls.minPolarAngle = 0;
        controls.maxPolarAngle = Math.PI;
        controls.minAzimuthAngle = -Infinity;
        controls.maxAzimuthAngle = Infinity;
               goToScene(activeScene, true);
        updateOverviewThumbPositions();
        document.getElementById('draftSceneBg').classList.remove('assets-loading');
        loadingEl.classList.add('hidden');
        setTimeout(() => { loadingEl.style.display = 'none'; }, 300);
    },
    undefined,
    (err) => {
        console.error('Failed to load savedraft.glb', err);
        document.getElementById('draftSceneBg').classList.remove('assets-loading');
        loadingEl.classList.add('hidden');
        setTimeout(() => { loadingEl.style.display = 'none'; }, 300);
    }
);

// ── Wheel-driven scene switching (one scroll = one scene) ──
const SCROLL_COOLDOWN_MS = 700; // >= the camera lerp settle time in animate()
let scrollLocked = false;

window.addEventListener('wheel', (e) => {
    // Camera zoom disabled — GLB position is fixed and locked.
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
    updateDetailImagePosition();
    renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
    const w = container.clientWidth, h = container.clientHeight;
    renderer.setSize(w, h);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
      updateOverviewThumbPositions();
    updateDetailImagePosition();
});
</script>

@endsection