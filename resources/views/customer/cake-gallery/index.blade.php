@extends('layouts.customer')
@section('title', 'Cake Studio')
@push('styles')
<link rel="preload" as="fetch" href="/models/cakegallery.glb" crossorigin>
<style>
:root{
    --cg-ink:#1E1309;
    --cg-copper:#D08A4C;
    --cg-copper-glow:#F4C989;
    --cg-cream:#F3E6CE;
    --cg-ease: cubic-bezier(.22,.61,.36,1);
}
html, body{
    margin:0;
    padding:0;
    height:100%;
    overflow:hidden;
    scrollbar-width:none;
    -ms-overflow-style:none;
}
html::-webkit-scrollbar, body::-webkit-scrollbar{
    display:none;
}
.cg-section{
    position:relative;
    overflow:hidden;
    background:#0c0704;
    isolation:isolate;
}
.cg-canvas{ position:absolute; inset:0; width:100%; height:100%; display:block; touch-action:none; }
.cg-vignette{
    position:absolute; inset:0; pointer-events:none; z-index:2;
    background:
        radial-gradient(120% 90% at 50% 100%, rgba(0,0,0,.5), transparent 55%),
        radial-gradient(120% 70% at 50% 0%, rgba(0,0,0,.45), transparent 55%);
}
.cg-hud{
    position:absolute; left:0; right:0; bottom:8%; z-index:3;
    display:flex; flex-direction:column; align-items:center; gap:.6rem;
    pointer-events:none; text-align:center; padding:0 1.5rem;
}
.cg-scene-label{
    font-family:'Fraunces', Georgia, serif; font-weight:600;
    font-size:clamp(1.3rem,2.4vw,1.9rem); color:#fff;
    text-shadow:0 2px 18px rgba(0,0,0,.5);
    opacity:0; transform:translateY(10px);
    transition:opacity .5s var(--cg-ease), transform .5s var(--cg-ease);
}
.cg-scene-label.is-visible{ opacity:1; transform:translateY(0); }
.cg-scroll-hint{
    font-size:.66rem; letter-spacing:.16em; text-transform:uppercase;
    color:rgba(255,255,255,.55); display:flex; flex-direction:column; align-items:center; gap:.4rem;
    transition:opacity .4s var(--cg-ease);
}
.cg-customize-btn{
    pointer-events:auto;
    display:inline-flex; align-items:center; gap:.5rem;
    font-family:'Fraunces', Georgia, serif; font-weight:600;
    font-size:clamp(.85rem,1.3vw,1rem);
    color:#3a2410;
    text-decoration:none;
    padding:.7rem 1.6rem;
    border-radius:100px;
    background:linear-gradient(180deg, var(--cg-copper-glow) 0%, var(--cg-copper) 100%);
    border:none;
    /* layered box-shadow = fake extruded "3D" side + soft ambient shadow */
    box-shadow:
        0 5px 0 0 #9a5d2c,
        0 5px 14px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.5);
    transform:translateY(0);
    transition:transform .15s var(--cg-ease), box-shadow .15s var(--cg-ease), opacity .4s var(--cg-ease);
    opacity:0;
    transform:translateY(6px);
    cursor:pointer;
}
.cg-customize-btn.is-visible{
    opacity:1;
    transform:translateY(0);
}
.cg-customize-btn:hover{
    transform:translateY(2px);
    box-shadow:
        0 3px 0 0 #9a5d2c,
        0 3px 10px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.5);
}
.cg-customize-btn:active{
    transform:translateY(5px);
    box-shadow:
        0 0 0 0 #9a5d2c,
        0 1px 6px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.5);
}
.cg-customize-btn svg{ flex-shrink:0; }
.cg-scroll-hint::after{
    content:''; width:1px; height:28px;
    background:linear-gradient(var(--cg-copper-glow), transparent);
    animation:cgHintFall 1.8s ease-in-out infinite;
}
@keyframes cgHintFall{ 0%{transform:scaleY(0);transform-origin:top;opacity:0;} 40%{opacity:1;} 100%{transform:scaleY(1);transform-origin:top;opacity:0;} }
.cg-dots{
    position:absolute; right:1.6rem; top:50%; transform:translateY(-50%); z-index:4;
    display:flex; flex-direction:column; gap:.85rem;
}
.cg-dot{
    width:8px; height:8px; border-radius:50%; border:none; padding:0; cursor:pointer;
    background:rgba(255,255,255,.28);
    transition:background .3s var(--cg-ease), transform .3s var(--cg-ease);
}
.cg-dot.is-active{ background:var(--cg-copper-glow); transform:scale(1.5); }
@media (max-width:760px){ .cg-dots{ right:.9rem; } }
.cg-loading{
    position:absolute; inset:0; z-index:10; background:#0c0704;
    display:flex; flex-direction:column; align-items:center; justify-content:center; gap:1rem;
    color:rgba(255,255,255,.7); font-size:.78rem; letter-spacing:.08em; text-transform:uppercase;
    transition:opacity .5s var(--cg-ease), visibility 0s .5s;
}
.cg-loading.is-hidden{ opacity:0; visibility:hidden; }
.cg-loading-track{ width:220px; height:2px; background:rgba(255,255,255,.15); border-radius:2px; overflow:hidden; }
.cg-loading-bar{ height:100%; width:0%; background:var(--cg-copper-glow); transition:width .2s linear; }
.cg-debug-badge{
    position:absolute; top:1rem; left:1rem; z-index:20;
    background:rgba(208,138,76,.9); color:#1a0f06; font-size:.68rem; font-weight:800;
    letter-spacing:.05em; text-transform:uppercase; padding:.4rem .8rem; border-radius:100px;
    line-height:1.5;
}
</style>
@endpush

@section('content')
<section class="cg-section" id="cgSection">
    <canvas class="cg-canvas" id="cgCanvas"></canvas>
    <div class="cg-vignette"></div>
    <div class="cg-hud">
        <span class="cg-scene-label" id="cgSceneLabel"></span>
        <a href="#" class="cg-customize-btn" id="cgCustomizeBtn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
            Customize
        </a>
        <span class="cg-scroll-hint" id="cgScrollHint">Scroll to explore</span>
    </div>
    <div class="cg-dots" id="cgDots">
        <button type="button" class="cg-dot is-active" data-i="0" aria-label="Gallery overview"></button>
        <button type="button" class="cg-dot" data-i="1" aria-label="Strawberry cake"></button>
        <button type="button" class="cg-dot" data-i="2" aria-label="Ube cake"></button>
        <button type="button" class="cg-dot" data-i="3" aria-label="Chocolate cake"></button>
        <button type="button" class="cg-dot" data-i="4" aria-label="Themed cake"></button>
        <button type="button" class="cg-dot" data-i="5" aria-label="Red velvet"></button>
    </div>

    <div class="cg-loading" id="cgLoading">
        <div class="cg-loading-track"><div class="cg-loading-bar" id="cgLoadingBar"></div></div>
        <span id="cgLoadingText">Loading the gallery…</span>
    </div>
</section>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script>
(function () {
    "use strict";

    // =====================================================================
    // CAKE GALLERY — rebuilt from scratch around /models/cakegallery.glb.
    //
    // Why hardcoded camera configs instead of measuring the model:
    // the six cakes + stands are joined into a single mesh/object (by
    // design — separating them lags Blender), so there are no individual
    // object names/positions to anchor cameras to at runtime. The numbers
    // in CAKE_SCENES below are a deliberately-composed STARTING POINT per
    // reference image (distinct height/distance/angle per cake, not one
    // generic sweep) — not measured truth. Use DEBUG MODE to dial in the
    // exact final numbers by eye, then paste them back in here.
    //
    // DEBUG MODE: load the page with ?cgdebug=1
    //   - Scroll-hijack is disabled; OrbitControls takes over instead so
    //     you can freely fly around the loaded model.
    //   - Press 1–6 to print that scene's exact { pos, look } to the
    //     console, formatted ready to paste into CAKE_SCENES.
    //   - Frame each cake the way its reference image frames it, press
    //     the matching number, copy the line out of the console.
    // =====================================================================

    var MODEL_URL = "/models/cakegallery.glb"; // confirmed real filename on disk
    var DEBUG = /[?&]cgdebug=1/.test(window.location.search);
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var SCENE_NAMES = [
        "The Gallery",
        "Strawberry Cream",
        "Ube Rosette",
        "Chocolate Fudge",
        "Mango Sponge",
        "Red Velvet"
    ];
    var SCENE_CUSTOMIZE_LINKS = [
        null,
        // Strawberry Cream — heart, Strawberry, Sugar Icing (pink), 4 strawberries
                 "{{ route('customer.cake-builder.index') }}?preset_flavor=Strawberry&preset_shape=Heart&preset_frosting=Sugar%20Icing&preset_icing_color=%23FFCCE0&preset_icing_color_name=Pink&preset_fruit=Strawberry&preset_fruit_positions=0.0499:0.039,-0.0152:-0.0161,-0.0897:0.0416,-0.0072:0.0981&preset_name=Strawberry%20Cream",
        // Ube Rosette — square, Ube, Semi-naked with Full Top rosettes
        "{{ route('customer.cake-builder.index') }}?preset_flavor=Ube&preset_shape=Square&preset_frosting=Rosettes&preset_rosette_placement=Full%20Top&preset_rosette_color=%236B3FA0&preset_rosette_color_name=Purple&preset_name=Ube%20Rosette",
            // Chocolate Fudge — round, Chocolate, Textured Shell Border (chocolate-colored) + Drip + Choco Curls (both)
        "{{ route('customer.cake-builder.index') }}?preset_flavor=Chocolate&preset_shape=Round&preset_frosting=Textured%20Buttercream&preset_icing_color=%232C1810&preset_icing_color_name=Chocolate&preset_drip=1&preset_drip_flavor=Chocolate&preset_choco_curls=both&preset_name=Chocolate%20Fudge",
            // Mango Sponge — round, Mango, Shell Border (mango-yellow), full SpongeBob-themed scene:
        // Patrick's House + Patrick (left), Squidward's House + Squidward (middle), SpongeBob's House + SpongeBob + Gary (right)
        "{{ route('customer.cake-builder.index') }}?preset_flavor=Mango&preset_shape=Round&preset_frosting=Smooth%20Buttercream&preset_icing_color=%23F5C842&preset_icing_color_name=Gold&preset_characters=Patrick%27s%20House,Patrick%20Star,Squidward%27s%20House,Squidward,SpongeBob%27s%20House,SpongeBob,Gary&preset_character_positions=-0.6:-0.15,-0.6:0.2,0:-0.15,0:0.2,0.6:-0.15,0.5:0.15,0.68:0.15&preset_name=Mango%20Sponge",
             // Red Velvet — Number cake "10", Sugar Icing (red), Red Velvet drip, candle #1 on the "1", candle #0 on the "0"
        "{{ route('customer.cake-builder.index') }}?preset_flavor=Red%20Velvet&preset_shape=Number&preset_number_digits=2&preset_number_tens=1&preset_number_units=0&preset_frosting=Sugar%20Icing&preset_icing_color=%23C01010&preset_icing_color_name=Red&preset_drip=1&preset_drip_flavor=Red%20Velvet&preset_candle_numbers=1,0&preset_candle_positions=-0.35:0.48,0.30:0.50&preset_name=Red%20Velvet%20Number%20Cake"
    ];
    // ---------------------------------------------------------------------
    // STARTING CAMERA CONFIGS (placeholders — tune with ?cgdebug=1)
    //
    // These are expressed as fractions of the model's own bounding box
    // rather than absolute numbers, since the model's real-world scale
    // wasn't knowable ahead of time (an offline scene-graph dump of this
    // GLB showed inconsistent unit scale between its FBX-sourced kitchen
    // parts and its native parts). Fractions degrade gracefully even if
    // the exported model is re-scaled later; Three.js resolves the full
    // world transform (translation + rotation + scale) correctly once
    // the model is actually loaded in the browser, which a static file
    // dump cannot do.
    //
    // Each cake gets its own intentional composition:
    //   xFrac  — position along the counter, left(0) to right(1), matching
    //            the reference-image order: heart, ube, chocolate, themed,
    //            red velvet
    //   heightFrac  — camera height as a fraction of model height above center
    //   distFrac    — dolly distance as a fraction of model depth
    //   yawDeg      — slight horizontal offset angle, for a non-square-on look
    //   lookHeightFrac — where on the cake the camera aims (cake-top vs base)
    // ---------------------------------------------------------------------
    var CAKE_SCENES = [
        // Scene 0 — wide establishing shot: pulled back and slightly high,
        // showing the full counter + kitchen backdrop.
        { xFrac: 0.5, heightFrac: 0.55, distFrac: 1.35, yawDeg: 18, lookHeightFrac: 0.05 },

        // Scene 1 — strawberry heart cake: centered, close, eye-level with
        // the piped border so the heart silhouette reads clearly.
        { xFrac: 0.06, heightFrac: 0.10, distFrac: 0.55, yawDeg: -8, lookHeightFrac: 0.15 },

        // Scene 2 — ube rosette cake: flatter/wider cake, so the camera
        // sits a touch higher to look down onto the rosette piping.
        { xFrac: 0.30, heightFrac: 0.22, distFrac: 0.50, yawDeg: 6, lookHeightFrac: 0.30 },

        // Scene 3 — chocolate drip cake: straight-on and slightly lower,
        // to catch the glossy drip along the side.
        { xFrac: 0.52, heightFrac: 0.05, distFrac: 0.55, yawDeg: -4, lookHeightFrac: 0.10 },

        // Scene 4 — SpongeBob themed cake: pulled back a bit further so
        // the toppers (pineapple house, moai tower, figures) stay in frame.
        { xFrac: 0.74, heightFrac: 0.30, distFrac: 0.70, yawDeg: 10, lookHeightFrac: 0.45 },

        // Scene 5 — red velvet number cakes: tight two-shot on both pieces,
        // slightly elevated to read the "1" and "0" shapes together.
        { xFrac: 0.94, heightFrac: 0.18, distFrac: 0.50, yawDeg: -10, lookHeightFrac: 0.20 }
    ];

    // ---------------------------------------------------------------------
    // FINAL, HAND-TUNED CAMERA CONFIGS — captured via ?cgdebug=1, orbiting
    // to match each reference image and pressing 1–6 to log the exact
    // { pos, look } for that framing. These are absolute world coordinates
    // from the actual loaded model, not fractions — no bounding-box guess
    // needed anymore. Re-tune any single scene the same way any time: load
    // ?cgdebug=1, frame it, press that scene's number, paste the new line
    // in below.
    // ---------------------------------------------------------------------
    var FINAL_SCENES = [
        { pos: [3.42, 2.36, 2.49], look: [3.43, 0.19, -2.42] }, // scene 1 — The Gallery
        { pos: [2.24, 1.63, -0.05], look: [2.25, 0.33, -2.48] }, // scene 2 — Strawberry Cake
        { pos: [2.85, 1.63, -0.05], look: [2.85, 0.34, -2.49] }, // scene 3 — Ube Cake
        { pos: [3.42, 1.63, -0.05], look: [3.42, 0.34, -2.48] }, // scene 4 — Chocolate Cake
        { pos: [4.02, 1.63, -0.05], look: [4.02, 0.35, -2.49] }, // scene 5 — Themed Cake
        { pos: [4.60, 1.63, -0.04], look: [4.58, 0.34, -2.49] }  // scene 6 — Red Velvet
    ];

    var SCENES = FINAL_SCENES;
    var canvas = document.getElementById('cgCanvas');
    var section = document.getElementById('cgSection');
    var loading = document.getElementById('cgLoading');
    var loadingBar = document.getElementById('cgLoadingBar');
    var loadingText = document.getElementById('cgLoadingText');
    var sceneLabel = document.getElementById('cgSceneLabel');
    var scrollHint = document.getElementById('cgScrollHint');
    var customizeBtn = document.getElementById('cgCustomizeBtn');
    var dots = Array.prototype.slice.call(document.querySelectorAll('.cg-dot'));

    var webglOK = (function () {
        try {
            var c = document.createElement('canvas');
            return !!(window.WebGLRenderingContext && (c.getContext('webgl') || c.getContext('experimental-webgl')));
        } catch (e) { return false; }
    })();

    if (!webglOK || typeof THREE === 'undefined') {
        loadingText.textContent = "3D preview isn't supported in this browser.";
        loadingBar.style.width = '100%';
        return;
    }

    var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.outputEncoding = THREE.sRGBEncoding;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 0.88;

    var scene = new THREE.Scene();
    scene.background = new THREE.Color(0x0c0704);

     var camera = new THREE.PerspectiveCamera(40, 1, 0.1, 5000);
    camera.position.set(0, 100, 300);

    // ---------------------------------------------------------------------
    // LIGHTING — tune every number here, nowhere else.
    //   intensity: 0 = off, ~1 = neutral, 1.5–2+ = bright
    //   pos: world-space [x, y, z] the light shines from (direction only —
    //        distance doesn't matter for DirectionalLight)
    //   ambientBoost: flat, shadowless brightness added to EVERYTHING —
    //        raise this first if things still look too dark/contrasty
    // ---------------------------------------------------------------------
     var LIGHT_CONFIG = {
        hemi:         { sky: 0xfff3e0, ground: 0x2a1a10, intensity: 0.35 },  // soft sky/ground fill, dialed back
        key:          { color: 0xffc98a, intensity: 1.3, pos: [80, 200, 150] },   // main light, warmer + stronger for contrast
        fill:         { color: 0xffd9ad, intensity: 0.25, pos: [-100, 120, 100] }, // barely-there — lets the key side read, keeps shadow side dark
        rim:          { color: 0xffe9c7, intensity: 0.55, pos: [0, 150, -200] },   // edge glow to separate cakes from the dark background
        ambientBoost: 0.08 // near-zero flat fill — this is what was washing everything out
    };
    // Fallback lighting in case the GLB's own baked lights don't reach
    // every angle evenly across all six compositions.
    scene.add(new THREE.HemisphereLight(LIGHT_CONFIG.hemi.sky, LIGHT_CONFIG.hemi.ground, LIGHT_CONFIG.hemi.intensity));
    scene.add(new THREE.AmbientLight(0xffffff, LIGHT_CONFIG.ambientBoost));

    var keyLight = new THREE.DirectionalLight(LIGHT_CONFIG.key.color, LIGHT_CONFIG.key.intensity);
    keyLight.position.set(LIGHT_CONFIG.key.pos[0], LIGHT_CONFIG.key.pos[1], LIGHT_CONFIG.key.pos[2]);
    scene.add(keyLight);

    var fillLight = new THREE.DirectionalLight(LIGHT_CONFIG.fill.color, LIGHT_CONFIG.fill.intensity);
    fillLight.position.set(LIGHT_CONFIG.fill.pos[0], LIGHT_CONFIG.fill.pos[1], LIGHT_CONFIG.fill.pos[2]);
    scene.add(fillLight);

    var rimLight = new THREE.DirectionalLight(LIGHT_CONFIG.rim.color, LIGHT_CONFIG.rim.intensity);
    rimLight.position.set(LIGHT_CONFIG.rim.pos[0], LIGHT_CONFIG.rim.pos[1], LIGHT_CONFIG.rim.pos[2]);
    scene.add(rimLight);

    // Fits the section to the content column beside the sidebar/header
    // instead of guessing pixel widths. We reset any bleed margins, read
    // the section's natural top/left offset while sitting in normal flow
    // (which already excludes the sidebar, since the section lives in the
    // main content column), then reapply negative margins that cancel out
    // just the immediate wrapper's own padding — never the sidebar/header
    function fitSection() {
        section.style.marginTop = '0px';
        section.style.marginLeft = '0px';
        section.style.marginRight = '0px';
        section.style.marginBottom = '0px';
        section.style.width = '';
        section.style.height = '';

        var parent = section.parentElement;
        var cs = window.getComputedStyle(parent);
        var padLeft = parseFloat(cs.paddingLeft) || 0;
        var padRight = parseFloat(cs.paddingRight) || 0;
        var padTop = parseFloat(cs.paddingTop) || 0;
        var padBottom = parseFloat(cs.paddingBottom) || 0;

        section.style.marginLeft = (-padLeft) + 'px';
        section.style.marginRight = (-padRight) + 'px';
        section.style.marginTop = (-padTop) + 'px';
        section.style.marginBottom = (-padBottom) + 'px';
        section.style.width = 'calc(100% + ' + (padLeft + padRight) + 'px)';

        // Height: distance from the section's own top (after cancelling
        // padTop above) down to the bottom of the viewport.
        var rect = section.getBoundingClientRect();
        section.style.height = Math.max(200, window.innerHeight - rect.top) + 'px';

        resize();
    }

    function resize() {
        var w = section.clientWidth, h = section.clientHeight;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
    }
    fitSection();
    window.addEventListener('resize', fitSection);
    // ---------------------------------------------------------------------
    // LOAD MODEL
    // ---------------------------------------------------------------------
    var modelRoot = null;
    var loader = new THREE.GLTFLoader();
    loader.load(
        MODEL_URL,
        function (gltf) {
            modelRoot = gltf.scene;
            scene.add(modelRoot);

            // Perf safety: this GLB carries a large number of real-time
            // point/spot lights baked in from Blender/Sketchfab source
            // assets. That many live lights can tank frame rate,
            // especially on mobile. Keep only the first handful actually
            // casting light; leave the rest in the graph so nothing
            // visually disappears, just zero their intensity.
            var liveLights = 0;
            var MAX_LIVE_LIGHTS = 8;
            modelRoot.traverse(function (obj) {
                if (obj.isLight) {
                    liveLights++;
                    if (liveLights > MAX_LIVE_LIGHTS) obj.intensity = 0;
                    obj.castShadow = false;
                }
            });

            // SCENES is already set to the hand-tuned FINAL_SCENES above —
            // resolveScenesFromModel() is left in place below (unused, not
            // called) only as a reference/fallback if you ever swap in a
            // very differently-scaled model and need fresh starting
            // fractions to re-tune from via ?cgdebug=1.
            loading.classList.add('is-hidden');
            goToScene(0, true);
            if (DEBUG) initDebugMode();
            animate();
        },
        function (xhr) {
            if (xhr.lengthComputable) {
                var pct = Math.round((xhr.loaded / xhr.total) * 100);
                loadingBar.style.width = pct + '%';
                loadingText.textContent = 'Loading the gallery… ' + pct + '%';
            }
        },
        function (err) {
            console.error('Cake gallery: failed to load ' + MODEL_URL, err);
            loadingText.textContent = "Couldn't load the model — check " + MODEL_URL;
        }
    );

    // ---------------------------------------------------------------------
    // Resolve CAKE_SCENES (fractions) into real world { pos, look } using
    // the ACTUAL loaded model's bounding box — measured live in-browser,
    // so rotation/scale from any nested FBX imports is already resolved
    // correctly by Three.js, unlike a static offline dump.
    // ---------------------------------------------------------------------
    function resolveScenesFromModel() {
        var box = new THREE.Box3().setFromObject(modelRoot);
        var size = box.getSize(new THREE.Vector3());
        var min = box.min, max = box.max;

        SCENES = CAKE_SCENES.map(function (cfg) {
            var targetX = min.x + size.x * cfg.xFrac;
            var camY = min.y + size.y * (0.5 + cfg.heightFrac);
            var lookY = min.y + size.y * cfg.lookHeightFrac;
            var dist = Math.max(size.z, size.x * 0.2) * cfg.distFrac + 1;
            var yaw = cfg.yawDeg * Math.PI / 180;

            var camX = targetX + Math.sin(yaw) * dist;
            var camZ = max.z + Math.cos(yaw) * dist;

            return {
                pos: [camX, camY, camZ],
                look: [targetX, lookY, box.getCenter(new THREE.Vector3()).z]
            };
        });

        // ---------------------------------------------------------------
        // GUARANTEE VISIBLE MOVEMENT BETWEEN EVERY CONSECUTIVE SCENE PAIR
        // (0→1, 1→2, 2→3, 3→4, 4→5).
        //
        // The fractions above are meant to differ enough on their own, but
        // if the model's real bounding box turns out small/flat/oddly
        // proportioned (plausible here, given the joined mesh and the
        // mixed FBX/native unit scale seen in an earlier offline dump of
        // this GLB), two scenes could resolve to nearly the same camera
        // position — which reads as "nothing moved" on scroll even though
        // the transition technically ran. This pass checks the distance
        // between each consecutive pair's camera position and, if it's
        // below a minimum threshold, pushes the later scene's camera
        // further out along its own look-direction so the transition is
        // always a real, visible move.
        // ---------------------------------------------------------------
        var diag = size.length(); // bounding-box diagonal, a scale-agnostic yardstick
        var MIN_MOVE = Math.max(diag * 0.12, 2); // at least 12% of model diagonal
        for (var i = 1; i < SCENES.length; i++) {
            var prevPos = new THREE.Vector3().fromArray(SCENES[i - 1].pos);
            var currPos = new THREE.Vector3().fromArray(SCENES[i].pos);
            var currLook = new THREE.Vector3().fromArray(SCENES[i].look);
            var moved = prevPos.distanceTo(currPos);

            if (moved < MIN_MOVE) {
                var away = currPos.clone().sub(currLook);
                if (away.lengthSq() < 1e-6) away.set(0, 0, 1); // degenerate: pick an arbitrary push direction
                away.normalize().multiplyScalar(MIN_MOVE - moved + 0.5);
                currPos.add(away);
                SCENES[i].pos = currPos.toArray();
            }
        }

        console.log('[cake-gallery] model bounding box:', {
            min: min.toArray(), max: max.toArray(), size: size.toArray()
        });
        console.log('[cake-gallery] resolved SCENES (tune these with ?cgdebug=1):', JSON.stringify(SCENES));
    }

    // ---------------------------------------------------------------------
    // SCENE STATE MACHINE — one scroll = one scene. While a transition is
    // animating, further scroll input is dropped (not queued) so a single
    // accepted scroll always maps to exactly one scene step.
    // ---------------------------------------------------------------------
    var currentScene = 0;
    var isAnimating = false;
    var camPos = new THREE.Vector3().copy(camera.position);
    var camLook = new THREE.Vector3(0, 0, 0);
    var animStart = null;
    var animFrom = { pos: new THREE.Vector3(), look: new THREE.Vector3() };
    var animTo = { pos: new THREE.Vector3(), look: new THREE.Vector3() };
    var ANIM_MS = 1100;

    function easeInOutCubic(t) { return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; }

    function goToScene(idx, instant) {
        idx = Math.max(0, Math.min(SCENES.length - 1, idx));
        var cfg = SCENES[idx];
        if (!cfg || !cfg.pos) return;

        currentScene = idx;
        updateHUD();

        animFrom.pos.copy(camPos);
        animFrom.look.copy(camLook);
        animTo.pos.set(cfg.pos[0], cfg.pos[1], cfg.pos[2]);
        animTo.look.set(cfg.look[0], cfg.look[1], cfg.look[2]);

        if (instant || reduceMotion) {
            camPos.copy(animTo.pos);
            camLook.copy(animTo.look);
            camera.position.copy(camPos);
            camera.lookAt(camLook);
            isAnimating = false;
            animStart = null;
            return;
        }

        isAnimating = true;
        animStart = performance.now();
    }

    function stepScene(direction) {
        if (isAnimating) return; // drop input mid-transition, don't queue it
        var next = currentScene + direction;
        if (next < 0 || next > SCENES.length - 1) return; // boundary: let page scroll normally
        goToScene(next, false);
    }

    function updateHUD() {
        sceneLabel.textContent = String(currentScene + 1).padStart(2, '0') + ' — ' + SCENE_NAMES[currentScene];
        sceneLabel.classList.add('is-visible');
        scrollHint.style.opacity = currentScene === 0 ? '1' : '0';
        dots.forEach(function (d) {
            d.classList.toggle('is-active', parseInt(d.dataset.i, 10) === currentScene);
        });

        var link = SCENE_CUSTOMIZE_LINKS[currentScene];
        if (link) {
            customizeBtn.href = link;
            customizeBtn.classList.add('is-visible');
        } else {
            customizeBtn.classList.remove('is-visible');
            customizeBtn.removeAttribute('href');
        }
    }

    dots.forEach(function (d) {
        d.addEventListener('click', function () {
            if (isAnimating) return;
            goToScene(parseInt(d.dataset.i, 10), false);
        });
    });

    function onWheel(e) {
        if (DEBUG) return; // let OrbitControls handle scroll in debug mode
        e.preventDefault(); // page never scrolls — only the gallery does
        var dir = e.deltaY > 0 ? 1 : -1;
        stepScene(dir);
    }
    section.addEventListener('wheel', onWheel, { passive: false });

    // Touch: swipe up/down counts as one step, same boundary release logic.
    var touchStartY = null;
    function onTouchStart(e) {
        if (DEBUG) { touchStartY = null; return; }
        touchStartY = e.touches[0].clientY;
    }
    function onTouchMove(e) {
        if (touchStartY === null) return;
        e.preventDefault(); // lock native scroll entirely — gallery only
    }
    function onTouchEnd(e) {
        if (touchStartY === null) return;
        var dy = touchStartY - e.changedTouches[0].clientY;
        touchStartY = null;
        if (Math.abs(dy) < 40) return; // ignore tiny/accidental swipes
        stepScene(dy > 0 ? 1 : -1);
    }
    section.addEventListener('touchstart', onTouchStart, { passive: true });
    section.addEventListener('touchmove', onTouchMove, { passive: false });
    section.addEventListener('touchend', onTouchEnd, { passive: true });

    // Keyboard fallback for accessibility — only while the card has focus/
    // hover, so arrow keys don't hijack the whole page's scrolling.
    var pointerOverSection = false;
    section.addEventListener('mouseenter', function () { pointerOverSection = true; });
    section.addEventListener('mouseleave', function () { pointerOverSection = false; });
    window.addEventListener('keydown', function (e) {
        if (DEBUG || !pointerOverSection) return;
        if (e.key === 'ArrowDown' || e.key === 'PageDown') { e.preventDefault(); stepScene(1); }
        else if (e.key === 'ArrowUp' || e.key === 'PageUp') { e.preventDefault(); stepScene(-1); }
    });

    // ---------------------------------------------------------------------
    // DEBUG FLY-THROUGH MODE (?cgdebug=1)
    // Free OrbitControls + press 1–6 to print a ready-to-paste ABSOLUTE
    // config line for that scene number to the console. Paste it directly
    // over the matching CAKE_SCENES-derived entry by hardcoding it into
    // SCENES after resolveScenesFromModel() runs, once you're happy with
    // the framing — that fully decouples that scene from the model's
    // bounding box and locks in your exact chosen shot.
    // ---------------------------------------------------------------------
    var orbitControls = null;
    function initDebugMode() {
        var badge = document.createElement('div');
        badge.className = 'cg-debug-badge';
        badge.textContent = 'DEBUG — drag to orbit, scroll to dolly, press 1–6 to log a scene';
        section.appendChild(badge);

        orbitControls = new THREE.OrbitControls(camera, renderer.domElement);
        orbitControls.target.copy(camLook);
        orbitControls.update();

        window.addEventListener('keydown', function (e) {
            var n = parseInt(e.key, 10);
            if (n >= 1 && n <= 6) {
                var p = camera.position;
                var t = orbitControls.target;
                var line = '{ pos:[' + p.x.toFixed(2) + ', ' + p.y.toFixed(2) + ', ' + p.z.toFixed(2) +
                    '], look:[' + t.x.toFixed(2) + ', ' + t.y.toFixed(2) + ', ' + t.z.toFixed(2) +
                    '] }, // scene ' + n + ' — ' + (SCENE_NAMES[n - 1] || '');
                console.log(line);
            }
        });
    }

    // ---------------------------------------------------------------------
    // RENDER LOOP
    // ---------------------------------------------------------------------
    function animate(now) {
        requestAnimationFrame(animate);

        if (DEBUG) {
            if (orbitControls) orbitControls.update();
            renderer.render(scene, camera);
            return;
        }

        if (isAnimating && animStart !== null) {
            var t = Math.min(1, (now - animStart) / ANIM_MS);
            var e = easeInOutCubic(t);
            camPos.lerpVectors(animFrom.pos, animTo.pos, e);
            camLook.lerpVectors(animFrom.look, animTo.look, e);
            camera.position.copy(camPos);
            camera.lookAt(camLook);

            if (t >= 1) {
                isAnimating = false;
                animStart = null;
            }
        }

        renderer.render(scene, camera);
    }
})();
</script>
@endpush