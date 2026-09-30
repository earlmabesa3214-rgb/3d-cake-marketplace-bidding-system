@extends('layouts.customer')

@section('title', 'Scene Calibration')

@section('content')

@php
    // Slot 0 -> Scene 2 ... Slot 4 -> Scene 6. Scene 1 is the overview.
    $draftSlots = collect($drafts ?? [])->take(5)->values();
@endphp
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

html, body { height: 100%; overflow: hidden; }

:root{
    --espresso:#24150F;
    --chocolate:#3A241A;
    --ivory:#F7F2E9;
    --cream:#EFE6D7;
    --caramel:#A96F42;
    --gold:#B89452;
    --gold-soft:rgba(184,148,82,.42);
    --gold-hair:rgba(184,148,82,.28);
    --burgundy:#54252C;
    --taupe:#9A897A;
    --beige:#D8C8B7;
    --blush:#E8D3CA;
    --font:'Plus Jakarta Sans', system-ui, sans-serif;
}

/* ============ SHOWROOM SHELL ============ */
#draftSceneBg {
    position: fixed; inset: 0; z-index: 0; overflow: hidden;
    background: radial-gradient(ellipse 140% 90% at 50% -10%, var(--chocolate) 0%, var(--espresso) 70%);
    pointer-events: auto; touch-action: none; overscroll-behavior: none; --u: 1;
    font-family: var(--font);
}
#draftSceneBg *, #draftSceneBg *::before, #draftSceneBg *::after { font-family: var(--font); }

.showroom-glow{ position:absolute; inset:0; z-index:1; pointer-events:none;
    background: radial-gradient(ellipse 50% 40% at 50% 8%, rgba(184,148,82,.16), transparent 70%); }

#draftSceneContainer { position: absolute; inset: 0; z-index: 2; pointer-events: auto; }
#draftSceneContainer canvas { width: 100% !important; height: 100% !important; display: block; }

/* Architectural frame: thin gold hairline inset + square corner brackets */
.showroom-frame{ position:fixed; inset:0; z-index:4; pointer-events:none; }
.showroom-frame::before{ content:''; position:absolute; inset:18px; border:1px solid var(--gold-hair); }
.showroom-frame span{ position:absolute; width:34px; height:34px; border:1px solid var(--gold); }
.showroom-frame span.tl{ top:12px; left:12px; border-right:none; border-bottom:none; }
.showroom-frame span.tr{ top:12px; right:12px; border-left:none; border-bottom:none; }
.showroom-frame span.bl{ bottom:12px; left:12px; border-right:none; border-top:none; }
.showroom-frame span.br{ bottom:12px; right:12px; border-left:none; border-top:none; }

.showroom-vignette{ position:absolute; inset:0; z-index:4; pointer-events:none;
    background: radial-gradient(ellipse at 50% 46%, rgba(0,0,0,0) 36%, rgba(24,12,7,.5) 100%); }

.showroom-brand{
    position:absolute; top:36px; left:48px; z-index:6; pointer-events:none;
    font-size:.64rem; font-weight:600; letter-spacing:.22em; text-transform:uppercase;
    color:var(--beige); opacity:.85;
}
.showroom-brand::after{ content:''; display:block; width:36px; height:1px; background:var(--gold); margin-top:9px; }

/* Loading */
#draftSceneLoading{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    flex-direction:column; gap:16px; z-index:10; pointer-events:none;
    transition: opacity .5s ease; background: var(--espresso);
}
#draftSceneLoading.hidden{ opacity:0; }
.draft-scene-loading-label{ font-size:.68rem; letter-spacing:.24em; text-transform:uppercase; color:var(--gold); font-weight:600; margin:0; }
.draft-scene-spinner{ width:30px; height:30px; border:1px solid rgba(184,148,82,.25); border-top-color:var(--gold); border-radius:50%; animation:draftSpin .9s linear infinite; }
@keyframes draftSpin{ to{ transform:rotate(360deg); } }

/* Cake images stay hidden until the GLB has loaded */
.assets-loading .draft-overview-thumb img,
.assets-loading .draft-detail-img{ visibility:hidden; }

/* ================= PANELS =================
   Panels are revealed only once the camera has SETTLED. While the camera is
   travelling (#draftSceneBg.cam-moving) every overlay is faded out, so the
   overlays never appear to slide around against the stationary GLB. */
.draft-panel{
    position:absolute; inset:0; display:none; z-index:5; pointer-events:none;
    opacity:1; transform:translateY(0);
    transition: opacity .4s ease, transform .4s cubic-bezier(.22,.68,0,1);
}
.draft-panel.active{ display:block; }
#draftSceneBg.cam-moving .draft-panel{ opacity:0; transform:translateY(8px); transition-duration:.18s; }
@media (prefers-reduced-motion: reduce){ .draft-panel{ transition:none; } }

/* ---------- Scene 1 header ---------- */
.showroom-header{
    position:absolute; top:58px; left:50%; width:max-content; max-width:90vw;
    transform:translateX(-50%);
    display:flex; flex-direction:column; align-items:center; text-align:center; pointer-events:none;
}
.showroom-eyebrow{ font-size:.62rem; font-weight:600; letter-spacing:.3em; text-transform:uppercase; color:var(--gold); margin-bottom:12px; }
.showroom-title{
    font-weight:600; font-size:clamp(1.15rem, 2.4vw, 1.85rem); letter-spacing:.26em; text-transform:uppercase;
    color:var(--ivory); margin:0; padding-left:.26em; text-shadow:0 4px 24px rgba(0,0,0,.6);
}
.showroom-rule{ width:54px; height:1px; background:var(--gold); margin:14px 0 12px; }
.showroom-subtitle{ font-size:.8rem; font-weight:500; color:var(--cream); opacity:.82; margin:0; letter-spacing:.03em; text-shadow:0 2px 10px rgba(0,0,0,.6); }

.showroom-slotcount{
    position:absolute; top:34px; right:108px; pointer-events:none;
    font-size:.66rem; font-weight:600; letter-spacing:.18em; text-transform:uppercase; color:var(--ivory);
    background:rgba(36,21,15,.6); border:1px solid var(--gold-soft); padding:8px 16px; backdrop-filter:blur(4px);
}
.showroom-scrollcue{ position:absolute; bottom:44px; left:50%; width:max-content; transform:translateX(-50%); display:flex; flex-direction:column; align-items:center; gap:8px; pointer-events:none; }
.showroom-scrollcue span{ font-size:.6rem; font-weight:600; letter-spacing:.28em; text-transform:uppercase; color:var(--cream); opacity:.75; }
.showroom-scrollcue i{ display:block; width:1px; height:30px; background:linear-gradient(var(--gold), transparent); animation:cueDrift 2.4s ease-in-out infinite; }
@keyframes cueDrift{ 0%,100%{ opacity:.35; transform:scaleY(.7); transform-origin:top; } 50%{ opacity:1; transform:scaleY(1); } }
@media (prefers-reduced-motion: reduce){ .showroom-scrollcue i{ animation:none; } }

/* ---------- Scene 1 cakes: STATIC viewport positions (left/top in %) ---------- */
.draft-overview{ overflow:hidden; }
.draft-overview-grid{ position:absolute; inset:0; pointer-events:none; }
.draft-overview-thumb{ position:absolute; width:calc(130px * var(--u,1)); pointer-events:auto; transform:translate(-50%,-50%); background:transparent; text-align:center; }
.draft-overview-thumb::before{
    content:''; position:absolute; left:50%; bottom:26px; transform:translateX(-50%);
    width:calc(92px * var(--u,1)); height:24px; background:radial-gradient(ellipse, rgba(184,148,82,.32), rgba(184,148,82,0) 72%); filter:blur(3px); pointer-events:none;
}
.draft-overview-thumb img{ position:relative; width:100%; height:calc(100px * var(--u,1)); object-fit:contain; object-position:center bottom; display:block; margin-bottom:8px; filter:drop-shadow(0 10px 14px rgba(0,0,0,.4)); }
.draft-overview-thumb span{
    display:inline-flex; align-items:center; gap:8px;
    font-size:.6rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:var(--ivory);
    background:rgba(36,21,15,.72); border:1px solid var(--gold-soft); padding:5px 10px; backdrop-filter:blur(3px);
}
.draft-overview-thumb span em{ font-style:normal; font-weight:800; color:var(--gold); }
.draft-empty-msg{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center; text-align:center;
    color:var(--cream); font-size:.86rem; font-weight:500; opacity:.8; pointer-events:none; padding:0 24px; letter-spacing:.02em;
}

/* Calibration tools (kept) */
.draft-calibrate-btn{
    position:absolute; top:90px; right:24px; pointer-events:auto; z-index:9999;
    background:var(--gold); color:var(--espresso); border:none; padding:9px 16px;
    font-size:.68rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; cursor:pointer;
}
.draft-offset-panel{
    display:none; position:absolute; top:134px; right:24px; width:300px; pointer-events:auto; z-index:9999;
    background:rgba(36,21,15,.94); border:1px solid var(--gold-soft); padding:10px;
}
.draft-offset-panel textarea{
    width:100%; height:320px; font-size:.68rem; background:#1c100b; color:var(--beige);
    border:1px solid var(--gold-hair); padding:6px; resize:none; margin-bottom:8px;
}
.draft-offset-panel button{ width:100%; background:var(--gold); color:var(--espresso); border:none; padding:8px; font-size:.66rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; cursor:pointer; }
.draft-overview-thumb.calibrating{ cursor:grab; outline:1px dashed var(--gold); touch-action:none; }
.draft-overview-thumb.calibrating:active{ cursor:grabbing; }

/* ---------- Editorial scene rail 01–06 ---------- */
#draftSceneIndicator{
    position:absolute; top:50%; right:38px; transform:translateY(-50%); z-index:7;
    display:flex; flex-direction:column; align-items:flex-end; gap:16px; pointer-events:none;
}
#draftSceneIndicator::before{ content:''; position:absolute; top:4px; bottom:38px; right:-14px; width:1px; background:var(--gold-hair); }
#draftSceneIndicator .scene-num{
    position:relative; display:flex; align-items:center; gap:10px;
    font-size:.62rem; font-weight:600; letter-spacing:.16em; color:var(--taupe); transition:color .4s ease;
}
#draftSceneIndicator .scene-num::before{ content:''; width:0; height:1px; background:var(--gold); transition:width .45s ease; }
#draftSceneIndicator .scene-num::after{ content:''; position:absolute; right:-17px; top:50%; width:7px; height:7px; margin-top:-3.5px; background:var(--espresso); border:1px solid var(--gold-soft); transform:rotate(45deg); transition:all .4s ease; }
#draftSceneIndicator .scene-num.filled{ color:var(--beige); }
#draftSceneIndicator .scene-num.active{ color:var(--gold); font-weight:800; }
#draftSceneIndicator .scene-num.active::before{ width:22px; }
#draftSceneIndicator .scene-num.active::after{ background:var(--gold); border-color:var(--gold); }
#draftSceneIndicator .scene-count{ font-size:.56rem; font-weight:600; letter-spacing:.2em; text-transform:uppercase; color:var(--taupe); margin-top:6px; }

/* ---------- Scenes 2–6: specification sheet ---------- */
.draft-detail{ align-items:flex-end; justify-content:flex-end; padding:5vh 5vw; z-index:7; }
.draft-detail.active{ display:flex; }

.draft-detail-card{
    pointer-events:auto; z-index:8; position:relative; width:300px; margin-bottom:4vh; isolation:isolate;
    background:linear-gradient(170deg, var(--ivory), var(--cream));
    padding:30px 28px 24px; border:1px solid var(--gold); border-radius:2px;
    box-shadow:0 26px 50px rgba(20,10,5,.5);
}
.draft-detail-card::before{ content:''; position:absolute; inset:7px; border:1px solid rgba(169,111,66,.22); pointer-events:none; }
.draft-detail-tag{ display:block; font-size:.58rem; font-weight:700; letter-spacing:.24em; text-transform:uppercase; color:var(--caramel); margin-bottom:10px; }
.draft-detail-info h3{ margin:0 0 18px; font-weight:700; font-size:1.18rem; color:var(--espresso); line-height:1.25; letter-spacing:-.005em; }
.draft-detail-info dl{ margin:0 0 20px; display:grid; grid-template-columns:auto 1fr; }
.draft-detail-info dt, .draft-detail-info dd{ padding:9px 0; border-top:1px solid rgba(58,36,26,.14); }
.draft-detail-info dt{ font-size:.58rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--taupe); align-self:center; padding-right:16px; }
.draft-detail-info dd{ margin:0; font-size:.8rem; font-weight:600; color:var(--espresso); text-align:right; }
.draft-detail-info dd.draft-total{ color:var(--burgundy); font-size:.95rem; font-weight:800; }
.draft-detail-divider{ height:1px; background:var(--gold); opacity:.6; margin:0 0 18px; }
.draft-detail-actions{ display:flex; align-items:center; gap:16px; }
.btn-draft-continue{
    flex:1; text-align:center; text-decoration:none; background:var(--espresso); color:var(--ivory);
    padding:13px 18px; font-size:.64rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase;
    border:1px solid var(--espresso); transition:background .3s ease, color .3s ease;
}
.btn-draft-continue:hover{ background:var(--gold); border-color:var(--gold); color:var(--espresso); }
.btn-draft-delete{
    background:transparent; border:none; color:var(--burgundy); padding:8px 2px; cursor:pointer;
    font-size:.62rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase;
    border-bottom:1px solid rgba(84,37,44,.4); transition:color .2s ease, border-color .2s ease;
}
.btn-draft-delete:hover{ color:var(--espresso); border-color:var(--espresso); }
.btn-draft-continue:focus-visible, .btn-draft-delete:focus-visible, .draft-empty-slot-card:focus-visible{ outline:2px solid var(--gold); outline-offset:3px; }

/* ---------- Scene 2–6 cake images: STATIC positions per scene ---------- */
.draft-detail-imgs-layer{
    position:absolute; inset:0; z-index:6; pointer-events:none; opacity:0;
    transition:opacity .4s ease;
}
.draft-detail-imgs-layer.on{ opacity:1; }
#draftSceneBg.cam-moving .draft-detail-imgs-layer{ opacity:0; transition-duration:.18s; }
.draft-detail-img{
    position:absolute; width:calc(340px * var(--u,1)); height:calc(340px * var(--u,1)); object-fit:contain; object-position:center bottom;
    pointer-events:none; transform:translate(-50%,-100%); filter:drop-shadow(0 18px 22px rgba(0,0,0,.45));
}
.draft-detail-img.calibrating{ pointer-events:auto; cursor:grab; outline:1px dashed var(--gold); touch-action:none; }
.draft-detail-img.calibrating:active{ cursor:grabbing; }

/* Empty slot */
.draft-empty-slot{ align-items:center; justify-content:center; padding:0; }
.draft-empty-slot-card{
    pointer-events:auto; text-align:center; text-decoration:none; display:block;
    background:rgba(36,21,15,.6); border:1px solid var(--gold-soft); padding:32px 38px; backdrop-filter:blur(4px);
    transition:border-color .3s ease, background .3s ease;
}
.draft-empty-slot-card:hover{ border-color:var(--gold); background:rgba(36,21,15,.78); }
.draft-empty-slot-plus{ width:40px; height:40px; margin:0 auto 16px; border:1px solid var(--gold); display:flex; align-items:center; justify-content:center; transform:rotate(45deg); }
.draft-empty-slot-plus svg{ width:16px; height:16px; stroke:var(--gold); transform:rotate(-45deg); }
.draft-empty-slot-card strong{ display:block; font-size:.66rem; font-weight:700; letter-spacing:.22em; text-transform:uppercase; color:var(--ivory); margin-bottom:8px; }
.draft-empty-slot-card em{ display:block; font-style:normal; font-weight:500; font-size:.82rem; color:var(--cream); opacity:.75; }

/* Modals */
.draft-modal-overlay{ position:fixed; inset:0; z-index:999; background:rgba(36,21,15,.72); backdrop-filter:blur(3px); display:flex; align-items:center; justify-content:center; padding:20px; }
.draft-modal{
    background:var(--ivory); padding:32px 32px 28px; max-width:380px; text-align:center;
    border:1px solid var(--gold); border-radius:2px; box-shadow:0 26px 60px rgba(0,0,0,.5); position:relative;
}
.draft-modal::before{ content:''; position:absolute; inset:7px; border:1px solid rgba(169,111,66,.22); pointer-events:none; }
.draft-modal h3{ margin:0 0 12px; font-weight:700; font-size:1.1rem; color:var(--espresso); }
.draft-modal p{ margin:0 0 24px; font-size:.82rem; color:var(--chocolate); line-height:1.65; }
.draft-modal .draft-modal-actions{ display:flex; gap:10px; justify-content:center; }
.draft-modal button, .draft-modal a{
    padding:12px 20px; font-size:.62rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase;
    cursor:pointer; text-decoration:none; border:1px solid transparent; border-radius:2px; transition:background .25s ease, color .25s ease;
}
.draft-modal .btn-modal-close{ background:var(--espresso); color:var(--ivory); }
.draft-modal .btn-modal-close:hover{ background:var(--gold); color:var(--espresso); }
.draft-modal .btn-modal-manage{ background:transparent; border-color:var(--espresso); color:var(--espresso); }
.draft-modal .btn-modal-manage:hover{ background:var(--espresso); color:var(--ivory); }
.draft-modal .btn-modal-danger{ background:var(--burgundy); color:var(--ivory); }
.draft-modal .btn-modal-danger:hover{ background:var(--espresso); }

/* ================= RESPONSIVE =================
   Cake overlays scale with the scene via --u (set from JS), so the
   composition stays aligned with the GLB on every screen size. */
@media (max-width:1024px){
    .draft-detail{ padding:4vh 4vw; }
    .draft-detail-card{ width:262px; padding:26px 22px 20px; }
    .showroom-slotcount{ right:96px; }
    .showroom-title{ letter-spacing:.2em; }
}
@media (max-width:720px){
    .showroom-frame::before{ inset:10px; }
    .showroom-frame span{ width:20px; height:20px; }
    .showroom-frame span.tl{ top:5px; left:5px; } .showroom-frame span.tr{ top:5px; right:5px; }
    .showroom-frame span.bl{ bottom:5px; left:5px; } .showroom-frame span.br{ bottom:5px; right:5px; }
    .showroom-brand{ display:none; }
    .showroom-header{ top:44px; }
    .showroom-eyebrow{ letter-spacing:.2em; margin-bottom:8px; }
    .showroom-title{ font-size:1rem; letter-spacing:.14em; padding-left:.14em; }
    .showroom-rule{ margin:10px 0 8px; }
    .showroom-subtitle{ font-size:.72rem; }
    .showroom-slotcount{ top:14px; right:18px; padding:6px 10px; font-size:.54rem; letter-spacing:.12em; }
    .showroom-scrollcue{ bottom:calc(18px + env(safe-area-inset-bottom, 0px)); }
    .showroom-scrollcue i{ height:20px; }
    .draft-overview-thumb span{ font-size:.5rem; padding:4px 6px; letter-spacing:.04em; }
    .draft-overview-thumb span em{ display:none; }
    #draftSceneIndicator{ right:14px; gap:10px; }
    #draftSceneIndicator .scene-num{ font-size:.54rem; }
    #draftSceneIndicator .scene-num.active::before{ width:14px; }
    #draftSceneIndicator .scene-count{ display:none; }
    .draft-detail{ padding:0 12px calc(14px + env(safe-area-inset-bottom, 0px)); }
    .draft-detail-card{ width:100%; margin-bottom:0; padding:16px 18px 14px; max-height:46vh; overflow:auto; }
    .draft-detail-card::before{ inset:5px; }
    .draft-detail-tag{ margin-bottom:6px; }
    .draft-detail-info h3{ font-size:1rem; margin-bottom:8px; }
    .draft-detail-info dl{ margin-bottom:12px; }
    .draft-detail-info dt, .draft-detail-info dd{ padding:6px 0; }
    .draft-detail-divider{ margin-bottom:12px; }
    .draft-empty-slot-card{ padding:24px 26px; }
    .draft-modal{ padding:26px 22px 22px; }
    .draft-calibrate-btn{ top:64px; right:14px; }
    .draft-offset-panel{ right:14px; width:min(300px, calc(100vw - 28px)); }
}
/* Landscape phones / very short screens */
@media (max-height:520px){
    .showroom-header{ top:26px; }
    .showroom-eyebrow, .showroom-rule, .showroom-subtitle, .showroom-scrollcue, .showroom-brand{ display:none; }
    .showroom-slotcount{ top:14px; }
    .draft-detail{ padding:2vh 3vw; }
    .draft-detail-card{ width:250px; margin-bottom:0; padding:14px 16px; max-height:92vh; overflow:auto; }
    .draft-detail-info h3{ font-size:.92rem; margin-bottom:8px; }
    .draft-detail-info dl{ margin-bottom:10px; }
    .draft-detail-info dt, .draft-detail-info dd{ padding:4px 0; }
    .draft-detail-divider{ margin-bottom:10px; }
    #draftSceneIndicator{ gap:8px; }
    #draftSceneIndicator .scene-count{ display:none; }
}
@media (hover:none){ .btn-draft-continue:hover{ background:var(--espresso); border-color:var(--espresso); color:var(--ivory); } }
</style>

<div id="draftSceneBg" class="assets-loading">
    <div class="showroom-glow"></div>
    <div id="draftSceneContainer"></div>

    <div class="showroom-frame" aria-hidden="true">
        <span class="tl"></span><span class="tr"></span><span class="bl"></span><span class="br"></span>
    </div>
    <div class="showroom-vignette" aria-hidden="true"></div>
    <div class="showroom-brand" aria-hidden="true">BakeSphere Cake Atelier</div>

    <button type="button" class="draft-calibrate-btn" id="draftCalibrateToggle">Calibrate positions</button>
    <div class="draft-offset-panel" id="draftOffsetPanel">
        <textarea id="draftOffsetOutput" readonly>{}</textarea>
        <button type="button" id="draftOffsetCopy">Copy coordinates</button>
    </div>

    {{-- Editorial scene rail 01–06 --}}
    <div id="draftSceneIndicator" aria-hidden="true">
        @for($i = 1; $i <= 6; $i++)
            <span class="scene-num {{ ($i === 1 || ($i - 2) < $draftSlots->count()) ? 'filled' : '' }}" data-scene="{{ $i }}">{{ sprintf('%02d', $i) }}</span>
        @endfor
        <span class="scene-count" id="draftSceneCount">01 / 06</span>
    </div>

    {{-- SCENE 1: overview of every saved draft --}}
    <div class="draft-panel draft-overview" id="draftOverview" data-scene="1">
        <div class="showroom-header">
            <span class="showroom-eyebrow">The Collection</span>
            <h2 class="showroom-title">Your Cake Archive</h2>
            <span class="showroom-rule"></span>
            <p class="showroom-subtitle">Saved creations, ready to continue.</p>
        </div>
        <div class="showroom-slotcount">{{ sprintf('%02d', $draftSlots->count()) }} / 05 saved</div>
        <div class="draft-overview-grid">
            @forelse($draftSlots as $d)
                <div class="draft-overview-thumb">
                    <img src="{{ $d['preview_image'] ?? '' }}" alt="{{ $d['cakeLabel'] ?? 'Saved cake' }}">
                    <span><em>{{ sprintf('%02d', $loop->iteration) }}</em>{{ $d['cakeLabel'] ?? 'Saved cake' }}</span>
                </div>
            @empty
                <p class="draft-empty-msg">No saved drafts yet. Design a cake and save it to see it displayed here.</p>
            @endforelse
        </div>
        <div class="showroom-scrollcue">
            <span>Scroll to explore</span>
            <i></i>
        </div>
    </div>

    {{-- Detail cake images for scenes 2–6. Positioned STATICALLY per scene
         (percent of viewport), applied only once the camera has settled. --}}
    <div class="draft-detail-imgs-layer" id="draftDetailImgsLayer">
        @foreach($draftSlots as $i => $d)
            @php $sceneNum = $i + 2; @endphp
            <img class="draft-detail-img" id="draftDetailImg{{ $sceneNum }}" src="{{ $d['preview_image'] ?? '' }}" alt="">
        @endforeach
    </div>

    {{-- SCENES 2–6: one specification sheet per saved draft --}}
    @foreach($draftSlots as $i => $d)
        @php $sceneNum = $i + 2; @endphp
        <div class="draft-panel draft-detail" id="draftDetail{{ $sceneNum }}" data-scene="{{ $sceneNum }}">
            <div class="draft-detail-card">
                <div class="draft-detail-info">
                    <span class="draft-detail-tag">Saved design {{ sprintf('%02d', $i + 1) }} of {{ sprintf('%02d', $draftSlots->count()) }}</span>
                    <h3>{{ $d['cakeLabel'] ?? 'Custom Cake' }}</h3>
                    <dl>
                        <dt>Shape</dt>
                        <dd>{{ $d['shapeLabel'] ?? '—' }}</dd>
                        <dt>Frosting</dt>
                        <dd>{{ is_array($d['frostings'] ?? null) ? implode(' + ', $d['frostings']) : '—' }}</dd>
                        <dt>Add&#8209;ons</dt>
                        <dd>{{ is_array($d['addons'] ?? null) ? count($d['addons']) : 0 }}</dd>
                        <dt>Est. total</dt>
                        <dd class="draft-total">₱{{ number_format($d['total'] ?? 0) }}</dd>
                    </dl>
                    <div class="draft-detail-divider"></div>
                    <div class="draft-detail-actions">
                        <a class="btn-draft-continue" href="{{ route('customer.cake-builder.index') }}?resume_draft={{ $d['id'] }}">Continue designing</a>
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
            <a href="{{ route('customer.cake-builder.index') }}" class="draft-empty-slot-card">
                <span class="draft-empty-slot-plus"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span>
                <strong>Save a new cake</strong>
                <em>Your next creation belongs here.</em>
            </a>
        </div>
    @endfor

    <div class="draft-modal-overlay" id="draftDeleteConfirmModal" style="display:none;">
        <div class="draft-modal">
            <h3>Delete this cake?</h3>
            <p id="draftDeleteConfirmText">Are you sure you want to delete this saved draft? This can't be undone.</p>
            <div class="draft-modal-actions">
                <button type="button" class="btn-modal-manage" id="draftDeleteCancelBtn">Cancel</button>
                <button type="button" class="btn-modal-danger" id="draftDeleteConfirmBtn">Delete</button>
            </div>
        </div>
    </div>

    @if(session('draft_limit_reached'))
        <div class="draft-modal-overlay" id="draftFullModal">
            <div class="draft-modal">
                <h3>Draft storage full</h3>
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
        <p class="draft-scene-loading-label">Setting the display</p>
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
const sceneBg   = document.getElementById('draftSceneBg');
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

// ── Responsive framing ──
// Static cake positions are stored as % of a REFERENCE frame (the 1535x825
// composition they were calibrated on). On any screen we keep that frame
// fully framed by the camera (widening vertical FOV on tall/narrow screens)
// and map the % positions into the frame's pixel rect. Result: overlays stay
// locked to the GLB on desktop, tablet and phone. Not tied to camera motion.
const BASE_FOV = 45, MAX_FOV = 70;
const REF_H = 825, REF_ASPECT = 1535 / 825, REF_W = REF_H * REF_ASPECT;
const frame = { x: 0, y: 0, w: REF_W, h: REF_H, u: 1 };
function updateFraming() {
    const W = container.clientWidth  || window.innerWidth;
    const H = container.clientHeight || window.innerHeight;
    const aspect = W / H;
    const baseTan = Math.tan(THREE.MathUtils.degToRad(BASE_FOV / 2));
    let vfov = BASE_FOV;
    if (aspect < REF_ASPECT) {
        vfov = Math.min(MAX_FOV, THREE.MathUtils.radToDeg(2 * Math.atan(baseTan * REF_ASPECT / aspect)));
    }
    camera.aspect = aspect;
    camera.fov = vfov;
    camera.updateProjectionMatrix();
    const f = baseTan / Math.tan(THREE.MathUtils.degToRad(vfov / 2));
    frame.h = H * f;
    frame.w = frame.h * REF_ASPECT;
    frame.x = (W - frame.w) / 2;
    frame.y = (H - frame.h) / 2;
    frame.u = Math.min(1.6, Math.max(0.55, frame.h / REF_H));
    sceneBg.style.setProperty('--u', frame.u.toFixed(3));
}
updateFraming();

// ── Camera controls disabled ──
// Camera movement is fully scripted via SCENES. OrbitControls is kept only
// so we can drive controls.target / controls.update() for the transitions.
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

// SCENES = the source of truth for the camera journey. ONLY the camera moves.
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
// Formats the current camera as a ready-to-paste SCENES[n] line.
function formatSceneCameraLine(sceneNum) {
    const p = camera.position.toArray().map(n => +n.toFixed(2));
    const t = controls.target.toArray().map(n => +n.toFixed(2));
    return `${sceneNum}: { camera: { position: [${p.join(', ')}], target: [${t.join(', ')}] } },`;
}

const overviewThumbs = Array.from(document.querySelectorAll('.draft-overview-thumb'));
const detailLayer    = document.getElementById('draftDetailImgsLayer');

let bgModel = null;            // the GLB — never moved, rotated or scaled after load
let activeScene = 1;
let isTransitioning = false;
let transitionTarget = null;

// ─────────────────────────────────────────────────────────────
// STATIC CAKE POSITIONS  (percent of viewport: x = left, y = top)
//
// These are plain numbers. They are NEVER recomputed from the live camera.
// Paste calibrated values from "Copy coordinates" here to lock them in.
// Any entry left empty is seeded ONCE at load (see seedStaticPositions).
// ─────────────────────────────────────────────────────────────
// Scene 1 overview: cake for scene N -> { x, y }
const OVERVIEW_POSITIONS = {
    // 2: { x: 0, y: 0 }, 3: {...}, 4: {...}, 5: {...}, 6: {...}
};
// Scenes 2–6: DETAIL_POSITIONS[activeScene][cakeSceneNum] -> { x, y }
const DETAIL_POSITIONS = {
    // 2: { 2: { x: 0, y: 0 }, 3: {...}, ... }, ...
};

// Legacy calibrated pixel offsets — used ONLY as one-time seeds so the
// existing look is preserved until you paste static percentages above.
const OVERVIEW_OFFSETS = {
    2: { x: 7,  y: -26 },
    3: { x: 55, y: -35 },
    4: { x: 38, y: 17 },
    5: { x: 28, y: 19 },
    6: { x: 2,  y: 16 },
};
const DETAIL_IMG_OFFSETS = {
    2: { 2: { x: 73,   y: 93  }, 3: { x: 338,  y: 80  }, 4: { x: 179,  y: 287 }, 5: { x: 109,  y: 259 }, 6: { x: 22,   y: 228 } },
    3: { 2: { x: -190, y: 64  }, 3: { x: 37,   y: 100 }, 4: { x: 41,   y: 285 }, 5: { x: -36,  y: 267 }, 6: { x: -156, y: 239 } },
    4: { 2: { x: -175, y: 76  }, 3: { x: 74,   y: 4   }, 4: { x: 26,   y: 172 }, 5: { x: -138, y: 161 }, 6: { x: -156, y: 239 } },
    5: { 2: { x: -175, y: 76  }, 3: { x: 74,   y: 4   }, 4: { x: 208,  y: 163 }, 5: { x: 38,   y: 153 }, 6: { x: -88,  y: 154 } },
    6: { 2: { x: -175, y: 76  }, 3: { x: 74,   y: 4   }, 4: { x: 79,   y: 778 }, 5: { x: 231,  y: 171 }, 6: { x: 60,   y: 171 } },
};

// One-time seeding helper. Uses a detached layout camera posed at a scene's
// stored SCENES pose — NOT the live camera — so results never depend on
// where the real camera happens to be mid-transition.
const layoutCam = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
function projectFromScene(poseSceneNum, worldPoint) {
    const s = SCENES[poseSceneNum].camera;
    layoutCam.aspect = REF_ASPECT;
    layoutCam.position.set(...s.position);
    layoutCam.lookAt(new THREE.Vector3(...s.target));
    layoutCam.updateProjectionMatrix();
    layoutCam.updateMatrixWorld(true);
    const v = worldPoint.clone().project(layoutCam);
    return { x: (v.x * 0.5 + 0.5) * REF_W, y: (-v.y * 0.5 + 0.5) * REF_H };
}
const r2 = (n) => Math.round(n * 100) / 100;

function seedStaticPositions() {
    const w = REF_W, h = REF_H;
    for (let n = 2; n <= 6; n++) {
        const cakeAnchor = new THREE.Vector3(...SCENES[n].camera.target);
        if (!OVERVIEW_POSITIONS[n]) {
            const p = projectFromScene(1, cakeAnchor);
            const o = OVERVIEW_OFFSETS[n] || { x: 0, y: 0 };
            OVERVIEW_POSITIONS[n] = { x: r2((p.x + o.x) / w * 100), y: r2((p.y + o.y) / h * 100) };
        }
    }
    for (let a = 2; a <= 6; a++) {
        DETAIL_POSITIONS[a] = DETAIL_POSITIONS[a] || {};
        for (let c = 2; c <= 6; c++) {
            if (DETAIL_POSITIONS[a][c]) continue;
            const p = projectFromScene(a, new THREE.Vector3(...SCENES[c].camera.target));
            const o = (DETAIL_IMG_OFFSETS[a] && DETAIL_IMG_OFFSETS[a][c]) || { x: 0, y: 0 };
            DETAIL_POSITIONS[a][c] = { x: r2((p.x + o.x) / w * 100), y: r2((p.y + o.y) / h * 100) };
        }
    }
}
seedStaticPositions();

// Applied ONLY on load, resize, calibration edits, or scene settle — never per frame.
// The header is centred on the MIDDLE cake stand (Scene 5's cake, labelled 04), using the
// same static % position as that cake, so it stays over the stand at any width.
// >>> ADJUST THE HEADER HERE <<<
// HEADER_NUDGE_X: percent of screen width. Negative = move left, positive = move right.
// (Vertical position: change `top:58px` in the .showroom-header CSS rule.)
const HEADER_NUDGE_X = -2;
function centreHeaderOnMiddleStand() {
    const header = document.querySelector('.showroom-header');
    const mid = OVERVIEW_POSITIONS[5];
    // "Scroll to explore" sits exactly under the middle cake (Blueberry Moist Cake), no nudge.
    const cue = document.querySelector('.showroom-scrollcue');
    if (cue && mid) cue.style.left = (frame.x + mid.x / 100 * frame.w) + 'px';
    if (header && mid) header.style.left = (frame.x + (mid.x + HEADER_NUDGE_X) / 100 * frame.w) + 'px';
}
function applyOverviewPositions() {
    centreHeaderOnMiddleStand();
    overviewThumbs.forEach((el, i) => {
        const p = OVERVIEW_POSITIONS[i + 2];
        if (!p) return;
        el.style.left = (frame.x + p.x / 100 * frame.w) + 'px';
        el.style.top  = (frame.y + p.y / 100 * frame.h) + 'px';
    });
}
function applyDetailPositions() {
    const row = DETAIL_POSITIONS[activeScene] || {};
    for (let c = 2; c <= 6; c++) {
        const img = document.getElementById('draftDetailImg' + c);
        const p = row[c];
        if (!img || !p) continue;
        img.style.left = (frame.x + p.x / 100 * frame.w) + 'px';
        img.style.top  = (frame.y + p.y / 100 * frame.h) + 'px';
    }
}
applyOverviewPositions();

// ── Scene state / UI ──
function updateDraftPanels(num){
    document.querySelectorAll('.draft-panel').forEach(p=>{
        p.classList.toggle('active', parseInt(p.dataset.scene) === num);
    });
    if (detailLayer) detailLayer.classList.toggle('on', num >= 2);
    updateSceneIndicator(num);
}

// Purely visual: keeps the 01–06 rail in sync with the active scene.
function updateSceneIndicator(num){
    const indicator = document.getElementById('draftSceneIndicator');
    if (!indicator) return;
    indicator.querySelectorAll('.scene-num').forEach(el => {
        el.classList.toggle('active', parseInt(el.dataset.scene) === num);
    });
    const countEl = document.getElementById('draftSceneCount');
    if (countEl) countEl.textContent = String(num).padStart(2, '0') + ' / 06';
}

// Camera has arrived: place the (static) detail images for this scene and
// reveal the overlays. Nothing here reads the live camera.
function hideImagesBehindCard() {
    const card = document.querySelector('#draftDetail' + activeScene + ' .draft-detail-card');
    for (let c = 2; c <= 6; c++) {
        const img = document.getElementById('draftDetailImg' + c);
        if (!img) continue;
        img.style.opacity = '';
        if (!card || c === activeScene) continue;
        const a = img.getBoundingClientRect(), b = card.getBoundingClientRect();
        const ox = Math.min(a.right, b.right) - Math.max(a.left, b.left);
        const oy = Math.min(a.bottom, b.bottom) - Math.max(a.top, b.top);
        // Neighbour cake that would be cut off / hidden by the spec card: don't draw it.
        if (ox > 0 && oy > 0) img.style.opacity = '0';
    }
}
function settleScene() {
    applyDetailPositions();
    hideImagesBehindCard();
    sceneBg.classList.remove('cam-moving');
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
        transitionTarget = null;
        settleScene();
    } else {
        transitionTarget = {
            position: new THREE.Vector3(...s.camera.position),
            target: new THREE.Vector3(...s.camera.target),
            fromPos: camera.position.clone(),
            fromTarget: controls.target.clone(),
            t0: performance.now()
        };
        isTransitioning = true;
        sceneBg.classList.add('cam-moving');   // overlays fade out while the camera travels
    }
}
window.goToScene = goToScene; // used by the "Manage drafts" link in the modal

// ── Calibration (edits STATIC positions only) ──
const urlParams = new URLSearchParams(window.location.search);
const calibrateAllowed = urlParams.get('calibrate') === '1';
let calibrationMode = false;

function refreshOffsetOutput() {
    const out = document.getElementById('draftOffsetOutput');
    if (out) out.value = JSON.stringify({
        OVERVIEW_POSITIONS,
        DETAIL_POSITIONS,
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
            const pos = OVERVIEW_POSITIONS[sceneNum] || (OVERVIEW_POSITIONS[sceneNum] = { x: 50, y: 50 });
            pos.x = r2(pos.x + e.movementX / frame.w * 100);
            pos.y = r2(pos.y + e.movementY / frame.h * 100);
            applyOverviewPositions();
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
            // Mutates ONLY this (activeScene -> cake) pair.
            const row = DETAIL_POSITIONS[activeScene] || (DETAIL_POSITIONS[activeScene] = {});
            const pos = row[sceneNum] || (row[sceneNum] = { x: 50, y: 50 });
            pos.x = r2(pos.x + e.movementX / frame.w * 100);
            pos.y = r2(pos.y + e.movementY / frame.h * 100);
            applyDetailPositions();
            refreshOffsetOutput();
        });
        el.addEventListener('pointerup', () => { dragging = false; });
    }
}
enableDetailImgDragging();

const calibrateBtn = document.getElementById('draftCalibrateToggle');
const offsetPanel  = document.getElementById('draftOffsetPanel');
calibrateBtn.style.display = calibrateAllowed ? 'block' : 'none';
calibrateBtn.addEventListener('click', () => {
    calibrationMode = !calibrationMode;
    calibrateBtn.textContent = calibrationMode ? 'Stop calibrating' : 'Calibrate positions';
    offsetPanel.style.display = calibrationMode ? 'block' : 'none';
    overviewThumbs.forEach(el => el.classList.toggle('calibrating', calibrationMode));
    for (let sceneNum = 2; sceneNum <= 6; sceneNum++) {
        const el = document.getElementById('draftDetailImg' + sceneNum);
        if (el) el.classList.toggle('calibrating', calibrationMode);
    }
    if (calibrationMode) refreshOffsetOutput();
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

// ── GLB: loaded once, added once, never transformed afterwards ──
const gltfLoader = new GLTFLoader();
gltfLoader.load(
    '/models/savedraft.glb',
    (gltf) => {
        bgModel = gltf.scene;
        scene.add(bgModel);

        // Debug helpers (click-to-identify meshes, thumbnail toggle) are now
        // only active with ?calibrate=1 so they don't run for normal visitors.
        if (calibrateAllowed) {
            const getPath = (obj) => {
                const parts = [];
                let n = obj;
                while (n && n !== bgModel) { parts.unshift(n.name || '(unnamed)'); n = n.parent; }
                return parts.join(' > ');
            };
            document.addEventListener('pointerdown', (ev) => {
                const rect = renderer.domElement.getBoundingClientRect();
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
                    const box = new THREE.Box3().setFromObject(h.object);
                    const size = box.getSize(new THREE.Vector3());
                    const center = box.getCenter(new THREE.Vector3());
                    console.log('  #' + i + '  dist=' + h.distance.toFixed(2) + '  ' + getPath(h.object) +
                        '\n      center=(' + center.x.toFixed(2) + ', ' + center.y.toFixed(2) + ', ' + center.z.toFixed(2) + ')' +
                        '  size=(' + size.x.toFixed(2) + ', ' + size.y.toFixed(2) + ', ' + size.z.toFixed(2) + ')');
                });
            }, true);
            window._toggleThumbImages = function(hide){
                document.querySelectorAll('.draft-overview-thumb img').forEach(img => {
                    img.style.visibility = hide ? 'hidden' : 'visible';
                });
            };
            console.log('Calibration debug on: click a cake to log mesh info; window._toggleThumbImages(true) hides thumbnails.');
        }

        controls.minDistance = 0.01;
        controls.maxDistance = 1000;
        controls.minPolarAngle = 0;
        controls.maxPolarAngle = Math.PI;
        controls.minAzimuthAngle = -Infinity;
        controls.maxAzimuthAngle = Infinity;
        goToScene(activeScene, true);
        applyOverviewPositions();
        sceneBg.classList.remove('assets-loading');
        loadingEl.classList.add('hidden');
        setTimeout(() => { loadingEl.style.display = 'none'; }, 300);
    },
    undefined,
    (err) => {
        console.error('Failed to load savedraft.glb', err);
        sceneBg.classList.remove('assets-loading');
        loadingEl.classList.add('hidden');
        setTimeout(() => { loadingEl.style.display = 'none'; }, 300);
    }
);

// ── One gesture = one scene (wheel + touch swipe) ──
const TRANSITION_MS = 1000;      // fixed camera travel time (eased)
const SCROLL_COOLDOWN_MS = 1100; // >= TRANSITION_MS
let scrollLocked = false;

function stepScene(direction) {
    if (scrollLocked) return;
    const nextScene = activeScene + direction;
    if (!SCENES[nextScene]) return;
    scrollLocked = true;
    goToScene(nextScene);
    setTimeout(() => { scrollLocked = false; }, SCROLL_COOLDOWN_MS);
}
window.addEventListener('wheel', (e) => {
    e.preventDefault();
    stepScene(e.deltaY > 0 ? 1 : -1);
}, { passive: false });

let touchStartY = null;
window.addEventListener('touchstart', (e) => { touchStartY = e.touches[0].clientY; }, { passive: true });
window.addEventListener('touchend', (e) => {
    if (touchStartY === null) return;
    const dy = touchStartY - e.changedTouches[0].clientY;
    touchStartY = null;
    if (Math.abs(dy) > 50) stepScene(dy > 0 ? 1 : -1);
}, { passive: true });

// ── Render loop: ONLY the camera is animated. No overlay layout work here. ──
function animate() {
    requestAnimationFrame(animate);
    if (isTransitioning && transitionTarget) {
        const k = Math.min(1, (performance.now() - transitionTarget.t0) / TRANSITION_MS);
        const e = k < 0.5 ? 4 * k * k * k : 1 - Math.pow(-2 * k + 2, 3) / 2; // easeInOutCubic
        camera.position.lerpVectors(transitionTarget.fromPos, transitionTarget.position, e);
        controls.target.lerpVectors(transitionTarget.fromTarget, transitionTarget.target, e);
        if (k >= 1) {
            isTransitioning = false;
            transitionTarget = null;
            settleScene();
        }
    }
    controls.update();
    renderer.render(scene, camera);
}
animate();

function handleResize() {
    renderer.setSize(container.clientWidth, container.clientHeight);
    updateFraming();
    applyOverviewPositions();
    applyDetailPositions();
    hideImagesBehindCard();
}
window.addEventListener('resize', handleResize);
window.addEventListener('orientationchange', () => setTimeout(handleResize, 250));
if ('ResizeObserver' in window) new ResizeObserver(handleResize).observe(container);
</script>

@endsection