@extends('layouts.customer')
@section('title', 'Dashboard')

@push('styles')
<style>
.sidebar .nav-link { gap: 0.55rem; padding: 0.7rem 0.9rem; }
.sidebar .nav-link .icon { width: 16px; text-align: left; flex-shrink: 0; }

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.studio, .studio * {
    --brown-deep:   #1C0F07;
    --brown-mid:    #3D2416;
    --brown-warm:   #5C3D2E;
    --caramel:      #C8894A;
    --caramel-light:#E8B07A;
    --caramel-pale: #FDDFC0;
    --cream:        #FDF6ED;
    --cream-dark:   #F5EDE0;
    --warm-white:   #FEFAF5;
    --border:       rgba(200,137,74,0.15);
    --text-dark:    #2A160A;
    --text-muted:   #9A7A65;
    --hair: rgba(28,15,7,0.08);
    --hair-strong: rgba(28,15,7,0.14);
    --r-sm: 10px;
    --r-md: 16px;
    --r-lg: 24px;
    --mono: ui-monospace, 'SF Mono', 'JetBrains Mono', Menlo, Consolas, monospace;
    --on-dark-line: rgba(255,255,255,0.14);
    --on-dark-muted: rgba(255,255,255,0.5);
}

@keyframes fadeUp    { from { opacity:0; transform:translateY(18px);} to { opacity:1; transform:none;} }
@keyframes fadeIn    { from { opacity:0; } to { opacity:1; } }
@keyframes softPulse { 0%,100%{opacity:.45;} 50%{opacity:1;} }

.reveal { opacity: 0; animation: fadeUp .7s cubic-bezier(.22,.68,0,1.12) both; }
.reveal.d1 { animation-delay: .04s; }
.reveal.d2 { animation-delay: .12s; }
.reveal.d5 { animation-delay: .28s; }

@media (prefers-reduced-motion: reduce) {
    .reveal, .kicker, .eyebrow { animation-duration: .001s !important; animation-iteration-count: 1 !important; transition: none !important; }
}
.studio { 
    display: flex; 
    flex-direction: column; 
    gap: 0; 
    padding: 0; 
    margin: -1.8rem; 
}
.kicker {
    font-family: var(--mono);
    font-size: 0.62rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--text-muted);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.kicker b { color: var(--caramel); font-weight: 700; }
.kicker.on-dark { color: var(--on-dark-muted); }
.kicker.on-dark b { color: var(--caramel-light); }

.icon { width: 15px; height: 15px; flex-shrink: 0; }
.icon-sm { width: 13px; height: 13px; }

.btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.78rem 1.5rem;
    background: linear-gradient(135deg, var(--caramel) 0%, #D4944F 100%);
    color: white; border-radius: var(--r-sm);
    font-size: 0.82rem; font-weight: 800; text-decoration: none;
    box-shadow: 0 10px 26px rgba(200,137,74,0.38);
    transition: transform 0.2s, box-shadow 0.2s;
    white-space: nowrap; border: none; cursor: pointer;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 14px 34px rgba(200,137,74,0.48); color: white; }

.journey-cta-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    margin-top: 1.4rem;
    padding: 1rem 1.75rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.92rem;
    font-weight: 800;
    color: #fff;
    text-decoration: none;
    white-space: nowrap;
    background: linear-gradient(180deg, var(--caramel-light) 0%, var(--caramel) 55%, #B87538 100%);
    border-radius: 14px;
    border: none;
    cursor: pointer;
    pointer-events: auto;
    transform: translateY(0);
    box-shadow:
        0 1px 0 rgba(255,255,255,0.35) inset,
        0 -3px 0 rgba(0,0,0,0.18) inset,
        0 8px 0 #7A4A22,
        0 8px 18px rgba(0,0,0,0.45);
    transition: transform .12s ease, box-shadow .12s ease;
}
.journey-cta-btn:hover {
    color: #fff;
    transform: translateY(-2px);
    box-shadow:
        0 1px 0 rgba(255,255,255,0.35) inset,
        0 -3px 0 rgba(0,0,0,0.18) inset,
        0 10px 0 #7A4A22,
        0 14px 24px rgba(0,0,0,0.5);
}
.journey-cta-btn:active {
    transform: translateY(6px);
    box-shadow:
        0 1px 0 rgba(255,255,255,0.35) inset,
        0 -3px 0 rgba(0,0,0,0.18) inset,
        0 2px 0 #7A4A22,
        0 4px 10px rgba(0,0,0,0.35);
}
@media (max-width: 900px) {
    .journey-cta-btn { padding: 0.85rem 1.4rem; font-size: 0.85rem; margin-top: 1rem; }
}

.journey-scroll-track {
    position: relative;
}
.journey-pin {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    width: 100%;
    height: 100vh;
    min-height: 640px;
    overflow: hidden;
    background: #1C0F07;
    isolation: isolate;
    touch-action: none;
}
#journeyCanvas {
    position: absolute; inset: 0; width: 100%; height: 100%; display: block; z-index: 0;
}

.journey-scrim {
    position: absolute; inset: 0; z-index: 2; pointer-events: none;
    background: linear-gradient(100deg, rgba(15,8,3,0.5) 0%, rgba(15,8,3,0.18) 38%, rgba(15,8,3,0) 62%);
}
.journey-vignette {
    position: absolute; inset: 0; z-index: 2; pointer-events: none;
    background:
        linear-gradient(180deg, rgba(15,8,3,0.5) 0%, rgba(15,8,3,0) 24%, rgba(15,8,3,0) 68%, rgba(15,8,3,0.55) 100%),
        radial-gradient(ellipse 120% 90% at 50% 50%, transparent 55%, rgba(10,5,2,0.3) 100%);
}
.journey-loader {
    position: absolute; inset: 0; z-index: 6;
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1.6rem;
    background: #1C0F07; transition: opacity 0.5s ease;
}
.journey-loader.is-hidden { opacity: 0; pointer-events: none; }
.journey-loader span { font-family: var(--mono); font-size: 0.66rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.45); }

.journey-skel {
    display: flex; align-items: flex-end; gap: 0.9rem;
    width: min(360px, 70vw);
}
.journey-skel-block {
    position: relative;
    overflow: hidden;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 10px;
}
.journey-skel-block::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(100deg, transparent 30%, rgba(232,176,122,0.22) 50%, transparent 70%);
    background-size: 200% 100%;
    animation: skelShimmer 1.6s ease-in-out infinite;
}
.journey-skel-cabinet { flex: 1; height: 46px; border-radius: 8px 8px 4px 4px; }
.journey-skel-counter { flex: 1.4; height: 14px; align-self: center; border-radius: 999px; }
.journey-skel-stand {
    width: 40px; height: 40px; border-radius: 50%;
    flex: 0 0 auto;
}
.journey-skel-row { display: flex; align-items: flex-end; gap: 0.9rem; width: 100%; }

@keyframes skelShimmer {
    0%   { background-position: -140% 0; }
    100% { background-position: 140% 0; }
}
@media (prefers-reduced-motion: reduce) {
    .journey-skel-block::after { animation: none; }
}

.journey-hud {
    position: absolute; z-index: 10; left: 0; top: 0; right: 0; bottom: 0;
    padding: 2.75rem; max-width: 560px;
    display: flex; flex-direction: column; justify-content: flex-start;
    pointer-events: none;
}
.journey-intro {
    position: absolute; left: 2.75rem; top: 2.75rem; right: 2.75rem; max-width: 460px;
    opacity: 0; transition: opacity .5s ease;
}
.journey-intro.is-visible { opacity: 1; }
.journey-intro h2 {
    font-size: clamp(1.9rem, 3.6vw, 2.6rem); font-weight: 900; letter-spacing: -0.04em;
    color: #fff; line-height: 1.08; margin: 0.85rem 0 0.9rem;
    text-shadow: 0 2px 20px rgba(0,0,0,0.35);
}

.journey-scrollcue {
    position: absolute; left: 50%; bottom: 2.25rem; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
    opacity: 1; transition: opacity .4s ease; z-index: 10; pointer-events: none;
}
.journey-scrollcue.is-hidden { opacity: 0; }
.journey-scrollcue span { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(255,255,255,0.55); }
.journey-scrollcue-line { width: 1px; height: 26px; background: linear-gradient(180deg, rgba(255,255,255,0.7), transparent); animation: softPulse 1.8s ease-in-out infinite; }

.journey-rail {
    position: absolute; z-index: 10; right: 2.5rem; top: 50%; transform: translateY(-50%);
    display: flex; flex-direction: column; gap: 0.9rem; align-items: flex-end;
}
.journey-rail-step { display: flex; align-items: center; gap: 0.6rem; }
.journey-rail-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.28); transition: background .35s ease, transform .35s ease; }
.journey-rail-label { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.4); transition: color .35s ease; }
.journey-rail-step.is-active .journey-rail-dot { background: var(--caramel-light); transform: scale(1.7); }
.journey-rail-step.is-active .journey-rail-label { color: #fff; }

@media (max-width: 900px) {
    .journey-hud, .journey-intro { padding: 0; left: 1.5rem; right: 1.5rem; max-width: 100%; }
    .journey-intro { top: 1.75rem; }
    .journey-rail { display: none; }
    .journey-pin { height: 90vh; min-height: 540px; }
}
@media (max-width: 768px) {
    .studio { margin: -1rem; }
}
.page-end-pad {
    display: none;
}
</style>
@endpush

@section('content')
<div class="studio">


    <div class="journey-scroll-track" id="journeyScrollTrack">
        <div class="journey-pin" id="journeyPin">
            <canvas id="journeyCanvas" aria-label="3D walkthrough of the baking kitchen"></canvas>
            <div class="journey-scrim"></div>
            <div class="journey-vignette"></div>

             <div class="journey-loader" id="journeyLoader">
                <div class="journey-skel">
                    <div class="journey-skel-row">
                        <div class="journey-skel-block journey-skel-cabinet"></div>
                        <div class="journey-skel-block journey-skel-cabinet"></div>
                        <div class="journey-skel-block journey-skel-stand"></div>
                        <div class="journey-skel-block journey-skel-cabinet"></div>
                    </div>
                </div>
                <div class="journey-skel" style="margin-top:-0.4rem;">
                    <div class="journey-skel-block journey-skel-counter"></div>
                </div>
                <span>Loading your kitchen&hellip;</span>
            </div>

            <div class="journey-hud">
                          <div class="journey-intro" id="journeyIntro">
               <span class="kicker on-dark" id="journeyKicker"><b>Welcome</b> &middot; Your cake journey starts here</span>
                    <h2 id="journeyHeading">Welcome to the kitchen.</h2>
                    <a href="{{ route('customer.cake-builder.index') }}" class="journey-cta-btn">
                        <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/><path d="M12 11V7"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
                        Customize your own cake
                    </a>
                </div>
                <div class="journey-scrollcue" id="journeyScrollCue">
                    <span>Scroll to explore</span>
                    <div class="journey-scrollcue-line"></div>
                </div>
            </div>

     <div class="journey-rail" aria-hidden="true">
                <div class="journey-rail-step is-active" data-stage="0">
                    <span class="journey-rail-label">Welcome</span><span class="journey-rail-dot"></span>
                </div>
                <div class="journey-rail-step" data-stage="1">
                    <span class="journey-rail-label">Prep</span><span class="journey-rail-dot"></span>
                </div>
                <div class="journey-rail-step" data-stage="2">
                    <span class="journey-rail-label">Oven</span><span class="journey-rail-dot"></span>
                </div>
                <div class="journey-rail-step" data-stage="3">
                    <span class="journey-rail-label">Finished</span><span class="journey-rail-dot"></span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script type="importmap">
{
  "imports": {
    "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
    "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
  }
}
</script>
<script type="module">

(function syncJourneyPinOffset() {
    const pin = document.getElementById('journeyPin');
    const topbarEl = document.querySelector('.topbar');
    const sidebarEl = document.querySelector('.sidebar');
    if (!pin) return;

    function sync() {
        const topbarH = topbarEl ? topbarEl.offsetHeight : 0;
        // Sidebar is also position:fixed and can slide off-screen on mobile
        // (translateX(-100%)), so read its actual on-screen edge each time
        // rather than assuming a fixed 260px — this keeps the pin's HUD text
        // from being clipped under the sidebar on desktop while staying
        // full-width on mobile.
        const sidebarW = sidebarEl ? Math.max(0, sidebarEl.getBoundingClientRect().right) : 0;

        pin.style.top = topbarH + 'px';
        pin.style.height = `calc(100vh - ${topbarH}px)`;
        pin.style.left = sidebarW + 'px';
        pin.style.width = `calc(100% - ${sidebarW}px)`;
    }

    sync();
    window.addEventListener('resize', sync);
    requestAnimationFrame(sync);
})();


if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) e.target.style.animationPlayState = 'running'; });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
}

/* ══════════════════════════════════════════════════════════════
   THE KITCHEN JOURNEY

   ONE Blender kitchen, loaded once from /models/bakesphere-kitchen.glb.
   ONE Three.js scene. ONE camera. Scrolling scrubs it along a real
   path built from the model's own coordinates.

   These three cluster centers were measured directly from the GLB's
   glTF node graph + accessor bounds (world-space mesh bounding-box
   centers), not guessed:

     PREP   — mixer / bowl / whisk / flour / egg / butter cluster
              measured world center ≈ (1.95, 1.04, -2.60)
     OVEN   — the plain baked cake at the bake counter
              (node "Cylinder.006" / "cake_base_round.007")
              measured world center = (3.74, 1.13, -0.89)
     FINISH — cake stand + finished cake + plate + spatula + box
              (node "cake_base_round.001" cluster)
              measured world center ≈ (4.78, 1.02, -2.61)

   The camera path stands the viewer back from each cluster at human
   eye height (~1.55m, floor at y≈0) and threads a smooth curve
   through all three, plus two shaping waypoints at the 33%/66% marks
   so it arcs through the open floor between the two counter runs
   instead of cutting a straight line through cabinetry.
══════════════════════════════════════════════════════════════ */
async function initKitchenJourney() {
    const track = document.getElementById('journeyScrollTrack');
    const pin = document.getElementById('journeyPin');
    const canvas = document.getElementById('journeyCanvas');
    if (!track || !pin || !canvas || !window.WebGLRenderingContext) return;

    const journeyFallbackTimer = setTimeout(() => {
        const loader = document.getElementById('journeyLoader');
        if (loader && !loader.classList.contains('is-hidden')) {
            loader.querySelector('span').textContent = 'Preview unavailable — your orders are still below';
            loader.querySelector('.journey-loader-ring').style.display = 'none';
        }
    }, 12000);

    let THREE, GLTFLoader;
    try {
        THREE = await import('three');
        ({ GLTFLoader } = await import('three/addons/loaders/GLTFLoader.js'));
    } catch (err) {
        console.warn('Kitchen journey: three.js failed to load.', err);
        return;
    }
    clearTimeout(journeyFallbackTimer);

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = window.matchMedia('(max-width: 760px)').matches;
    const lowPower = isMobile || (navigator.hardwareConcurrency ? navigator.hardwareConcurrency <= 4 : false);

    const renderer = new THREE.WebGLRenderer({ canvas, antialias: !lowPower, alpha: false, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, lowPower ? 1.4 : 1.85));
    renderer.shadowMap.enabled = !lowPower;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.25;

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x1c0f07);
    scene.fog = new THREE.Fog(0x1c0f07, 6, 16);

    const camera = new THREE.PerspectiveCamera(50, 1, 0.05, 60);
// ── KITCHEN LIGHTING ────────────────────────────────────────
const ambient = new THREE.AmbientLight(0xffead6, 1.15);
scene.add(ambient);

// Main overhead light
const key = new THREE.DirectionalLight(0xfff4e5, 2.2);
key.position.set(1, 7, 2);
key.castShadow = !lowPower;

if (!lowPower) {
    key.shadow.mapSize.set(1024, 1024);
    key.shadow.camera.left = -7;
    key.shadow.camera.right = 7;
    key.shadow.camera.top = 7;
    key.shadow.camera.bottom = -7;
    key.shadow.camera.near = 0.5;
    key.shadow.camera.far = 18;
    key.shadow.bias = -0.001;
}

scene.add(key);

// Front fill — brightens the cabinets/counters facing the camera
const frontFill = new THREE.PointLight(0xffead2, 1.8, 12, 1.5);
frontFill.position.set(1.5, 3.5, 2.5);
scene.add(frontFill);

// Left-side fill
const leftFill = new THREE.PointLight(0xffdfc0, 1.4, 10, 1.5);
leftFill.position.set(-2, 3, -1);
scene.add(leftFill);

// Prep area
const prepFill = new THREE.PointLight(0xffd9ad, 1.5, 9, 1.5);
prepFill.position.set(1.5, 2.8, -2.5);
scene.add(prepFill);

// Oven / right side
const ovenFill = new THREE.PointLight(0xffd9ad, 1.5, 9, 1.5);
ovenFill.position.set(5, 3, -1);
scene.add(ovenFill);

// Soft ceiling light
const ceilingFill = new THREE.HemisphereLight(
    0xffead2,
    0x5a3825,
    0.9
);
scene.add(ceilingFill);

    const loaderEl = document.getElementById('journeyLoader');
    const loader = new GLTFLoader();
    let kitchenReady = false;

    loader.load(
        '/models/bakesphere-kitchen.glb',
        (gltf) => {
            const model = gltf.scene;
            model.traverse(o => {
                if (o.isMesh) {
                    o.castShadow = true;
                    o.receiveShadow = true;
                    if (o.material) {
                        const mats = Array.isArray(o.material) ? o.material : [o.material];
                        mats.forEach(m => { if (m.map) m.map.colorSpace = THREE.SRGBColorSpace; });
                    }
                }
            });
            scene.add(model);
            kitchenReady = true;
            loaderEl && loaderEl.classList.add('is-hidden');
            updateOverlay(0, true);
        },
        undefined,
        (err) => {
            console.warn('Kitchen journey: failed to load /models/bakesphere-kitchen.glb', err);
            if (loaderEl) {
                loaderEl.querySelector('span').textContent = 'Preview unavailable — your orders are still below';
                loaderEl.querySelector('.journey-loader-ring').style.display = 'none';
            }
        }
    );
    const EYE_Y = 1.55;

    /* SCENE 1 — WELCOME (estimated, not measured)
       Unlike Prep/Oven/Finish below, this is NOT pulled from measured
       GLB node bounds — there's no dedicated "welcome" object cluster
       to measure. It's derived by pulling the camera back from the
       Prep eye position along roughly the same sightline, raised
       slightly, and re-aimed at the hood / counter run (the visual
       center of the wide establishing shot).

       TUNING GUIDE if the angle looks off:
         eyeWelcome.z  → more positive = pulled back further (wider view)
         eyeWelcome.y  → higher = looking down more into the counters
         eyeWelcome.x  → shifts camera left(-) / right(+)
         lookWelcome.x → pans the aim point left(-) / right(+)
         lookWelcome.z → moves the aim point deeper(-) / closer(+) into the room
    */
    const eyeWelcome  = new THREE.Vector3(2.40, 1.75, 0.80);
    const lookWelcome = new THREE.Vector3(3.30, 1.25, -2.40);

    const eyePrep   = new THREE.Vector3(1.55, EYE_Y, -1.85);
    const lookPrep  = new THREE.Vector3(2.0, 1.05, -2.50);
    
    const eyeMid1   = new THREE.Vector3(2.75, EYE_Y + 0.02, -0.55);
    const lookMid1  = new THREE.Vector3(2.90, 1.10, -1.60);

const eyeOven   = new THREE.Vector3(4.35, EYE_Y, -1.35);
const lookOven  = new THREE.Vector3(5.15, 1.02, -2.65);

const eyeMid2   = new THREE.Vector3(1.15, EYE_Y + 0.02, -0.60);
const lookMid2  = new THREE.Vector3(4.35, 1.08, -1.70);

const eyeFinish = new THREE.Vector3(4.05, EYE_Y - 0.25, -0.15);
const lookFinish = new THREE.Vector3(3.4, 1.24, -0.89);
    function withPhantoms(pts) {
        const first = pts[0].clone().add(pts[0].clone().sub(pts[1]));
        const last = pts[pts.length - 1].clone().add(pts[pts.length - 1].clone().sub(pts[pts.length - 2]));
        return [first, ...pts, last];
    }

    /* ── TWO segments instead of one 5-point spline ──
       A single Catmull-Rom curve through all 5 waypoints let the curve's
       arc length "borrow" travel time between them whenever the legs
       weren't evenly spaced — and they aren't (prep→oven bulges out in z,
       oven→finish bulges back in). That meant progress=0.5 didn't land
       exactly on OVEN and progress=1 didn't land exactly on FINISH; the
       two later stages visually bled into each other.

       Splitting into prep→oven and oven→finish, each explicitly mapped
       to its own start/mid/end, pins exact stops:
         progress 0    = PREP
         progress 0.5  = OVEN     (this image)
         progress 1    = FINISHED
       every time, regardless of the model's geometry. */
    const eyeCurveA  = new THREE.CatmullRomCurve3(withPhantoms([eyePrep, eyeMid1, eyeOven]), false, 'catmullrom', 0.5);
    const lookCurveA = new THREE.CatmullRomCurve3(withPhantoms([lookPrep, lookMid1, lookOven]), false, 'catmullrom', 0.5);
    const eyeCurveB  = new THREE.CatmullRomCurve3(withPhantoms([eyeOven, eyeMid2, eyeFinish]), false, 'catmullrom', 0.5);
    const lookCurveB = new THREE.CatmullRomCurve3(withPhantoms([lookOven, lookMid2, lookFinish]), false, 'catmullrom', 0.5);

    // 3 real points + 1 phantom each side = 5 points = 4 segments.
    // Real points land at u = 1/4 (start), 2/4 (mid waypoint), 3/4 (end).
    // Map local segment progress t (0..1) onto u = 1/4 + t/2 so t=0 is
    // the exact start point and t=1 is the exact end point — no drift.
    function segmentU(t) { return 0.25 + t * 0.5; }
    const currentEye = eyeWelcome.clone();
    const currentLook = lookWelcome.clone();
    const targetEye = eyeWelcome.clone();
    const targetLook = lookWelcome.clone();
    const travelFromEye = eyeWelcome.clone();
    const travelFromLook = lookWelcome.clone();
    const TRAVEL_DURATION_MS = 1300; // how long one scene-to-scene camera move takes
    let travelStartTime = 0;
    let progress = 0;
    let renderedProgress = -1;
    let stageIndex = 0;
    let isAnimating = false;
    const STAGE_PROGRESS = [0, 1 / 3, 2 / 3, 1];
    const STAGE_COOLDOWN_MS = TRAVEL_DURATION_MS + 200; // block new input until the camera move actually finishes
    function goToStage(nextIndex) {
        nextIndex = Math.max(0, Math.min(STAGE_PROGRESS.length - 1, nextIndex));
        if (nextIndex === stageIndex || isAnimating) return;
        stageIndex = nextIndex;
        progress = STAGE_PROGRESS[stageIndex];
        isAnimating = true;
        setTimeout(() => { isAnimating = false; }, STAGE_COOLDOWN_MS);
        if (JOURNEY_DEBUG) console.log('[journey] stage=', stageIndex);
    }
function updateTargetFromProgress() {
    /*
     * Explicit 4-stage camera path:
     *
     * 0.000        = WELCOME
     * 0.333 (1/3)  = PREP
     * 0.667 (2/3)  = OVEN
     * 1.000        = FINISHED
     *
     * This keeps the camera and the stage labels synchronized.
     * smoothstep gives the movement a natural cinematic acceleration
     * and deceleration instead of a robotic linear slide.
     */
    const THIRD = 1 / 3;

    if (progress <= THIRD) {
        const t = progress / THIRD;
        const smoothT = t * t * (3 - 2 * t);

        targetEye.lerpVectors(eyeWelcome, eyePrep, smoothT);
        targetLook.lerpVectors(lookWelcome, lookPrep, smoothT);
    } else if (progress <= THIRD * 2) {
        const t = (progress - THIRD) / THIRD;
        const smoothT = t * t * (3 - 2 * t);

        targetEye.lerpVectors(eyePrep, eyeOven, smoothT);
        targetLook.lerpVectors(lookPrep, lookOven, smoothT);
    } else {
        const t = (progress - THIRD * 2) / THIRD;
        const smoothT = t * t * (3 - 2 * t);

        targetEye.lerpVectors(eyeOven, eyeFinish, smoothT);
        targetLook.lerpVectors(lookOven, lookFinish, smoothT);
    }
}

    const introEl = document.getElementById('journeyIntro');
    const kickerEl = document.getElementById('journeyKicker');
    const headingEl = document.getElementById('journeyHeading');
    const scrollCueEl = document.getElementById('journeyScrollCue');
    const railSteps = document.querySelectorAll('.journey-rail-step');

    const STAGES = [
        { kicker: `<b>Welcome</b> &middot; Your cake journey starts here`, heading: `Welcome to the kitchen.` },
        { kicker: `<b>Preparation</b> &middot; Fresh ingredients, ready to go`, heading: `Freshly prepared, just for you.` },
        { kicker: `<b>Baking</b> &middot; Into the oven it goes`, heading: `Into the oven.` },
        { kicker: `<b>Finished</b> &middot; Made, baked, and ready to enjoy`, heading: `Baked to perfection.` },
    ];
    let activeStage = -1;
    let introVisible = false;

   function stageForProgress(p) {
    // With discrete stage-jump navigation, progress only ever lands
    // exactly on one of the four STAGE_PROGRESS values, so this just
    // finds the closest match instead of relying on drift-prone thresholds.
    let closest = 0;
    let closestDist = Infinity;
    STAGE_PROGRESS.forEach((sp, i) => {
        const d = Math.abs(sp - p);
        if (d < closestDist) { closestDist = d; closest = i; }
    });
    return closest;
}
    function updateOverlay(p, force) {
        const stageIdx = stageForProgress(p);

        if (stageIdx !== activeStage || force) {
            activeStage = stageIdx;
            const s = STAGES[stageIdx];
            kickerEl.innerHTML = s.kicker;
            headingEl.textContent = s.heading;
            railSteps.forEach(el => el.classList.toggle('is-active', Number(el.dataset.stage) === stageIdx));
        }

        if (!introVisible) { introEl.classList.add('is-visible'); introVisible = true; }
        scrollCueEl.classList.toggle('is-hidden', p > 0.03);
    }

    let running = false, rafId = null;
    let lastT = performance.now();

    function frame(now) {
        if (!running) return;
        const dt = Math.min(0.05, (now - lastT) / 1000);
        lastT = now;
        if (kitchenReady) {
            if (progress !== renderedProgress) {
                travelFromEye.copy(currentEye);
                travelFromLook.copy(currentLook);
                updateTargetFromProgress();
                updateOverlay(progress, false);
                renderedProgress = progress;
                travelStartTime = now;
            }

            if (reducedMotion) {
                currentEye.copy(targetEye);
                currentLook.copy(targetLook);
            } else {
                const t = Math.min(1, (now - travelStartTime) / TRAVEL_DURATION_MS);
                const smoothT = t * t * (3 - 2 * t);
                currentEye.lerpVectors(travelFromEye, targetEye, smoothT);
                currentLook.lerpVectors(travelFromLook, targetLook, smoothT);
            }

            camera.position.copy(currentEye);
            camera.lookAt(currentLook);
        }
        renderer.render(scene, camera);
        rafId = requestAnimationFrame(frame);
    }
    function start() { if (!running) { running = true; lastT = performance.now(); rafId = requestAnimationFrame(frame); } }
    function stop() { running = false; if (rafId) cancelAnimationFrame(rafId); }
const JOURNEY_DEBUG = new URLSearchParams(location.search).has('debugJourney');

const WHEEL_THRESHOLD = 12; // ignore tiny trackpad jitter

function onWheel(e) {
    e.preventDefault();
    if (Math.abs(e.deltaY) < WHEEL_THRESHOLD) return;
    goToStage(stageIndex + (e.deltaY > 0 ? 1 : -1));
}

let touchStartY = null;
let touchHandledThisGesture = false;

function onTouchStart(e) {
    touchStartY = e.touches[0].clientY;
    touchHandledThisGesture = false;
}
function onTouchMove(e) {
    e.preventDefault();
    if (touchHandledThisGesture || touchStartY === null) return;
    const dy = touchStartY - e.touches[0].clientY;
    const TOUCH_THRESHOLD = 40;
    if (Math.abs(dy) > TOUCH_THRESHOLD) {
        goToStage(stageIndex + (dy > 0 ? 1 : -1));
        touchHandledThisGesture = true;
    }
}
function onTouchEnd() {
    touchStartY = null;
    touchHandledThisGesture = false;
}

window.addEventListener('wheel', onWheel, { passive: false });
window.addEventListener('touchstart', onTouchStart, { passive: true });
window.addEventListener('touchmove', onTouchMove, { passive: false });
window.addEventListener('touchend', onTouchEnd, { passive: true });

    function resize() {
        const w = pin.clientWidth, h = pin.clientHeight;
        if (!w || !h) return;
        camera.aspect = w / h;
        camera.fov = w / h < 0.9 ? 58 : (w / h < 1.4 ? 53 : 50);
        camera.updateProjectionMatrix();
        renderer.setSize(w, h, false);
    }
    window.addEventListener('resize', resize);
    resize();
    start();
    document.addEventListener('visibilitychange', () => { document.hidden ? stop() : start(); });

    function disposeKitchenJourney() {
        stop();
        window.removeEventListener('resize', resize);
        window.removeEventListener('wheel', onWheel);
        window.removeEventListener('touchstart', onTouchStart);
        window.removeEventListener('touchmove', onTouchMove);
        window.removeEventListener('touchend', onTouchEnd);
        scene.traverse(obj => {
            if (obj.geometry) obj.geometry.dispose();
            if (obj.material) (Array.isArray(obj.material) ? obj.material : [obj.material]).forEach(m => {
                if (m.map) m.map.dispose();
                m.dispose();
            });
        });
        renderer.dispose();
    }
    window.addEventListener('pagehide', disposeKitchenJourney, { once: true });
}

initKitchenJourney();
(function initLibraryFilters() {
    const filterBar = document.getElementById('libFilters');
    const grid = document.getElementById('libGrid');
    const empty = document.getElementById('libEmpty');
    if (!filterBar || !grid) return;
    const buttons = filterBar.querySelectorAll('.lib-filter');
    const cards = grid.querySelectorAll('.lib-card');
    filterBar.addEventListener('click', (e) => {
        const btn = e.target.closest('.lib-filter');
        if (!btn) return;
        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        let visibleCount = 0;
        cards.forEach(card => {
            const match = filter === 'all' || card.dataset.cat === filter;
            card.classList.toggle('is-hidden', !match);
            if (match) visibleCount++;
        });
        empty?.classList.toggle('is-visible', visibleCount === 0);
    });
})();

(function initInspirationTabs() {
    const tabs = document.querySelectorAll('.insp-tab');
    if (!tabs.length) return;
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.insp-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById(tab.dataset.target)?.classList.add('active');
        });
    });
})();
</script>
@endpush