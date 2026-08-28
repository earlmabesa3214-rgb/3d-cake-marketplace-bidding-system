@extends('layouts.customer')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ══════════════════════════════════════════
   SIDEBAR NAV ALIGNMENT OVERRIDE (from dashboard)
══════════════════════════════════════════ */
.sidebar .nav-link {
    gap: 0.55rem;
    padding: 0.7rem 0.9rem;
}
.sidebar .nav-link .icon {
    width: 16px;
    text-align: left;
    flex-shrink: 0;
}

/* ══════════════════════════════════════════
   RESET & TOKENS
══════════════════════════════════════════ */
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

    /* utility face — for technical / data readouts only, never body copy */
    --mono: ui-monospace, 'SF Mono', 'JetBrains Mono', Menlo, Consolas, monospace;
    --on-dark-line: rgba(255,255,255,0.14);
    --on-dark-muted: rgba(255,255,255,0.5);
}

/* ══════════════════════════════════════════
   MOTION
══════════════════════════════════════════ */
@keyframes fadeUp    { from { opacity:0; transform:translateY(18px);} to { opacity:1; transform:none;} }
@keyframes fadeIn    { from { opacity:0; } to { opacity:1; } }
@keyframes softPulse { 0%,100%{opacity:.45;} 50%{opacity:1;} }
@keyframes spin      { to { transform: rotate(360deg); } }
@keyframes dash      { to { stroke-dashoffset: 0; } }

.reveal { opacity: 0; animation: fadeUp .7s cubic-bezier(.22,.68,0,1.12) both; }
.reveal.d1 { animation-delay: .04s; }
.reveal.d2 { animation-delay: .12s; }
.reveal.d3 { animation-delay: .2s; }
.reveal.d4 { animation-delay: .28s; }
.reveal.d5 { animation-delay: .36s; }

@media (prefers-reduced-motion: reduce) {
    * { animation-duration: .001s !important; animation-iteration-count: 1 !important; transition: none !important; }
}

/* ══════════════════════════════════════════
   ACCESSIBILITY
══════════════════════════════════════════ */
a:focus-visible, button:focus-visible {
    outline: 2px solid var(--caramel);
    outline-offset: 3px;
    border-radius: 4px;
}
.vc-btn:focus-visible, .vp-seg button:focus-visible { outline-offset: 1px; }

/* ══════════════════════════════════════════
   SHARED PRIMITIVES
══════════════════════════════════════════ */
.studio { display: flex; flex-direction: column; gap: 3.25rem; padding-bottom: 2rem; }

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

.eyebrow {
    font-size: 0.66rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--caramel);
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.eyebrow::before { content: ''; width: 14px; height: 1.5px; background: var(--caramel); display: inline-block; }
.eyebrow.on-dark { color: var(--caramel-light); }
.eyebrow.on-dark::before { background: var(--caramel-light); }

.heading-lg { font-size: clamp(1.5rem, 2.6vw, 2rem); font-weight: 900; letter-spacing: -0.03em; color: var(--brown-deep); }

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

.btn-ghost {
    display: inline-flex; align-items: center; gap: 0.45rem;
    padding: 0.78rem 1.3rem; background: transparent;
    border: 1.5px solid var(--hair-strong); color: var(--brown-mid);
    border-radius: var(--r-sm); font-size: 0.82rem; font-weight: 700;
    text-decoration: none; transition: all 0.2s; white-space: nowrap;
}
.btn-ghost:hover { border-color: var(--caramel); color: var(--caramel); }

/* ══════════════════════════════════════════
   § 1 — STUDIO HEADER
══════════════════════════════════════════ */
.studio-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    gap: 2rem; flex-wrap: wrap;
    padding-bottom: 1.5rem; border-bottom: 1px solid var(--hair);
}
.studio-header-left h1 {
    font-size: clamp(1.6rem, 3vw, 2.3rem); font-weight: 900;
    letter-spacing: -0.035em; color: var(--brown-deep); line-height: 1.1;
    margin-top: 0.45rem;
}
.studio-header-left h1 em { font-style: normal; color: var(--caramel); }

.workflow {
    display: flex; align-items: center; gap: 0.5rem;
    margin-top: 0.85rem;
}
.workflow-step {
    font-family: var(--mono); font-size: 0.62rem; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted);
}
.workflow-step.is-current { color: var(--caramel); }
.workflow-arrow { color: var(--hair-strong); }
.workflow-arrow svg { width: 11px; height: 11px; display: block; }

.studio-header-right { display: flex; align-items: center; gap: 1.75rem; flex-wrap: wrap; }

.readout { display: flex; align-items: baseline; gap: 0.4rem; }
.readout b { font-family: var(--mono); font-size: 1.3rem; font-weight: 700; color: var(--brown-deep); letter-spacing: -0.02em; }
.readout span { font-size: 0.64rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); font-weight: 700; }
.readout-divider { width: 1px; height: 26px; background: var(--hair-strong); }

/* ══════════════════════════════════════════
   § 2 — 3D STUDIO VIEWPORT
══════════════════════════════════════════ */
.viewport-section {
    position: relative; min-height: 580px; border-radius: var(--r-lg);
    overflow: hidden; background: var(--brown-deep); isolation: isolate;
}
.viewport-atmosphere {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 60% 50% at 68% 38%, rgba(200,137,74,0.22), transparent 65%),
        radial-gradient(ellipse 40% 60% at 10% 90%, rgba(232,176,122,0.10), transparent 70%),
        linear-gradient(180deg, #1C0F07 0%, #241407 55%, #1C0F07 100%);
}
.viewport-grid {
    position: absolute; inset: 0; z-index: 0; opacity: 0.5;
    background-image:
        linear-gradient(rgba(200,137,74,0.09) 1px, transparent 1px),
        linear-gradient(90deg, rgba(200,137,74,0.09) 1px, transparent 1px);
    background-size: 42px 42px;
    -webkit-mask-image: radial-gradient(ellipse 70% 70% at 62% 45%, black 10%, transparent 72%);
            mask-image: radial-gradient(ellipse 70% 70% at 62% 45%, black 10%, transparent 72%);
}

/* signature element: viewfinder corner brackets, like a CAD / camera viewport */
.viewport-frame { position: absolute; inset: 14px; z-index: 3; pointer-events: none; }
.vf-corner { position: absolute; width: 20px; height: 20px; opacity: 0.55; transition: opacity 0.3s; }
.vf-corner svg { width: 100%; height: 100%; }
.vf-tl { top: 0; left: 0; }
.vf-tr { top: 0; right: 0; transform: scaleX(-1); }
.vf-bl { bottom: 0; left: 0; transform: scaleY(-1); }
.vf-br { bottom: 0; right: 0; transform: scale(-1,-1); }
.viewport-section:hover .vf-corner { opacity: 0.9; }

.viewport-copy { position: relative; z-index: 3; padding: 2.75rem 2.75rem 0; max-width: 380px; }
.viewport-copy .kicker { margin-bottom: 0.9rem; }
.viewport-copy h2 {
    font-size: clamp(1.8rem, 3.4vw, 2.5rem); font-weight: 900; letter-spacing: -0.04em;
    color: #fff; line-height: 1.08; margin-bottom: 0.9rem;
}
.viewport-copy p { font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.65; margin-bottom: 1.4rem; }

.viewport-stage { position: absolute; inset: 0; z-index: 1; }
#cakeCanvas {
    position: absolute; inset: 0; width: 100%; height: 100%;
    display: block; cursor: grab; touch-action: none;
}
#cakeCanvas:active { cursor: grabbing; }

.viewport-loader {
    position: absolute; inset: 0; z-index: 5;
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.8rem;
    background: var(--brown-deep); transition: opacity 0.4s ease;
}
.viewport-loader.is-hidden { opacity: 0; pointer-events: none; }
.viewport-loader-ring {
    width: 30px; height: 30px; border-radius: 50%;
    border: 2.5px solid rgba(255,255,255,0.15);
    border-top-color: var(--caramel-light);
    animation: spin 0.9s linear infinite;
}
.viewport-loader span { font-family: var(--mono); font-size: 0.66rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.45); }

/* technical metadata stack — top right */
.viewport-meta {
    position: absolute; z-index: 3; top: 2rem; right: 2.25rem;
    display: flex; flex-direction: column; gap: 0.65rem; text-align: right;
}
.vm-row { display: flex; flex-direction: column; gap: 0.1rem; }
.vm-label { font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.38); font-weight: 600; }
.vm-value { font-size: 0.72rem; color: rgba(255,255,255,0.88); font-weight: 800; letter-spacing: 0.01em; }
.vm-value.is-live { display: inline-flex; align-items: center; gap: 0.4rem; justify-content: flex-end; }
.vm-dot { width: 6px; height: 6px; border-radius: 50%; background: #7CD489; animation: softPulse 2s ease-in-out infinite; flex-shrink: 0; }

/* live orbit / zoom readout — bottom left, updates with interaction */
.viewport-telemetry {
    position: absolute; z-index: 3; left: 2.75rem; bottom: 1.9rem;
    display: flex; gap: 1.5rem;
}
.vt-item { display: flex; flex-direction: column; gap: 0.15rem; }
.vt-label { font-family: var(--mono); font-size: 0.56rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.35); font-weight: 600; }
.vt-value { font-family: var(--mono); font-size: 0.74rem; color: var(--caramel-light); font-weight: 700; }

/* view-preset segmented control — top left, under the copy on small screens it hides */
.vp-seg {
    position: absolute; z-index: 3; top: 2rem; left: 2.75rem;
    display: none; gap: 2px;
    background: rgba(255,255,255,0.06);
    border: 1px solid var(--on-dark-line);
    border-radius: 8px; padding: 2px;
}
.vp-seg button {
    font-family: var(--mono); font-size: 0.6rem; font-weight: 700; letter-spacing: 0.06em;
    text-transform: uppercase; color: rgba(255,255,255,0.5);
    background: transparent; border: none; border-radius: 6px;
    padding: 0.35rem 0.6rem; cursor: pointer; transition: all 0.15s;
}
.vp-seg button:hover { color: #fff; }
.vp-seg button.active { background: rgba(255,255,255,0.14); color: #fff; }

/* viewport controls pill — bottom right */
.viewport-controls {
    position: absolute; z-index: 4; bottom: 1.5rem; right: 1.5rem;
    display: flex; gap: 0.35rem;
    background: rgba(28,15,7,0.55); border: 1px solid rgba(255,255,255,0.12);
    border-radius: 50px; padding: 0.35rem; backdrop-filter: blur(10px);
}
.vc-btn {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: transparent; border: none; color: rgba(255,255,255,0.7);
    cursor: pointer; transition: all 0.18s; position: relative;
}
.vc-btn:hover { background: rgba(255,255,255,0.12); color: #fff; }
.vc-btn.is-active { background: var(--caramel); color: #fff; }
.vc-btn svg { width: 14px; height: 14px; }

.viewport-cta { position: absolute; z-index: 3; left: 2.75rem; bottom: 1.75rem; }
.viewport-telemetry ~ .viewport-cta,
.viewport-cta { bottom: 1.75rem; }

@media (max-width: 900px) {
    .viewport-section { min-height: 480px; }
    .viewport-copy { padding: 2rem 1.5rem 0; max-width: 100%; }
    .viewport-meta { top: 1.25rem; right: 1.5rem; }
    .viewport-telemetry, .viewport-cta { left: 1.5rem; }
    .vp-seg { display: none !important; }
}
@media (max-width: 560px) {
    .viewport-section { min-height: 420px; }
    .viewport-meta .vm-row:nth-child(n+3) { display: none; }
    .viewport-telemetry { display: none; }
}

/* ══════════════════════════════════════════
   § 3 — DESIGN COMMAND BAR
══════════════════════════════════════════ */
.action-rail { display: flex; align-items: stretch; border-top: 1px solid var(--hair); border-bottom: 1px solid var(--hair); }
.action-item {
    flex: 1; display: flex; align-items: center; gap: 0.9rem;
    padding: 1.1rem 1.4rem; text-decoration: none; color: inherit;
    border-right: 1px solid var(--hair); transition: background 0.2s; position: relative;
}
.action-item:last-child { border-right: none; }
.action-item:hover { background: var(--cream-dark); }
.action-item::before {
    content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
    width: 2px; height: 0; background: var(--caramel); transition: height 0.2s;
}
.action-item:hover::before { height: 60%; }
.action-icon {
    width: 38px; height: 38px; border-radius: 10px; background: var(--cream-dark);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    color: var(--caramel); transition: background 0.2s, color 0.2s;
}
.action-item:hover .action-icon { background: var(--caramel); color: #fff; }
.action-copy .a-title { font-size: 0.82rem; font-weight: 800; color: var(--brown-deep); }
.action-copy .a-sub { font-family: var(--mono); font-size: 0.64rem; color: var(--text-muted); margin-top: 0.2rem; letter-spacing: 0.02em; }

@media (max-width: 760px) {
    .action-rail { flex-direction: column; }
    .action-item { border-right: none; border-bottom: 1px solid var(--hair); }
    .action-item:last-child { border-bottom: none; }
}

/* ══════════════════════════════════════════
   § 4 — DESIGN LIBRARY
══════════════════════════════════════════ */
.section-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
.section-head .heading-lg { margin-top: 0.35rem; }
.section-link {
    font-size: 0.76rem; font-weight: 800; color: var(--caramel); text-decoration: none;
    display: inline-flex; align-items: center; gap: 0.35rem; transition: gap 0.2s;
}
.section-link svg { width: 12px; height: 12px; }
.section-link:hover { gap: 0.55rem; }

.lib-filters { display: flex; align-items: center; gap: 1.4rem; margin-bottom: 1.5rem; flex-wrap: wrap; border-bottom: 1px solid var(--hair); }
.lib-filter {
    background: transparent; border: none; color: var(--text-muted);
    font-size: 0.75rem; font-weight: 700; padding: 0 0 0.85rem; cursor: pointer;
    position: relative; transition: color 0.18s;
}
.lib-filter::after {
    content: ''; position: absolute; left: 0; right: 0; bottom: -1px; height: 2px;
    background: var(--caramel); transform: scaleX(0); transition: transform 0.22s;
}
.lib-filter:hover { color: var(--brown-deep); }
.lib-filter.active { color: var(--brown-deep); }
.lib-filter.active::after { transform: scaleX(1); }

/* spotlight — the featured 3D asset */
.lib-spotlight {
    position: relative; display: grid; grid-template-columns: 1.1fr 1fr;
    min-height: 300px; border-radius: var(--r-lg); overflow: hidden;
    border: 1px solid var(--hair); margin-bottom: 1.25rem;
    text-decoration: none; color: inherit; background: var(--brown-deep);
}
.spotlight-visual { position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.spotlight-visual::after { content: ''; position: absolute; inset: 0; background: linear-gradient(100deg, rgba(28,15,7,0.32) 0%, transparent 45%); }
.spotlight-visual .asset-icon { width: 34%; max-width: 128px; opacity: 0.92; position: relative; z-index: 1; color: rgba(255,255,255,0.92); }
.spotlight-frame { position: absolute; inset: 12px; border: 1px dashed rgba(255,255,255,0.18); border-radius: 12px; z-index: 1; pointer-events: none; }
.spotlight-badge {
    position: absolute; top: 1.25rem; left: 1.25rem; z-index: 2;
    font-family: var(--mono); font-size: 0.58rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    color: #fff; background: rgba(28,15,7,0.5); backdrop-filter: blur(6px);
    padding: 0.32rem 0.7rem; border-radius: 50px; display: inline-flex; align-items: center; gap: 0.4rem;
}
.spotlight-badge .vm-dot { width: 5px; height: 5px; }
.spotlight-body { position: relative; padding: 2rem 2.25rem; display: flex; flex-direction: column; justify-content: center; color: #fff; }
.spotlight-body .kicker.on-dark { margin-bottom: 0.7rem; }
.spotlight-body h3 { font-size: clamp(1.3rem, 2.3vw, 1.65rem); font-weight: 900; letter-spacing: -0.03em; line-height: 1.15; margin-bottom: 0.6rem; }
.spotlight-specs { display: flex; gap: 1.1rem; margin-bottom: 1rem; flex-wrap: wrap; }
.spec-tag { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.05em; text-transform: uppercase; color: rgba(255,255,255,0.5); }
.spec-tag b { color: rgba(255,255,255,0.85); font-weight: 700; }
.spotlight-body p { font-size: 0.82rem; color: rgba(255,255,255,0.55); line-height: 1.65; max-width: 340px; margin-bottom: 1.4rem; }
.spotlight-foot { display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap; }
.spotlight-price { font-size: 1rem; font-weight: 900; color: var(--caramel-light); }
.spotlight-price span { font-size: 0.68rem; font-weight: 600; color: rgba(255,255,255,0.4); }
.spotlight-cta {
    display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.35rem;
    background: linear-gradient(135deg, var(--caramel) 0%, #D4944F 100%); color: #fff;
    border-radius: var(--r-sm); font-size: 0.78rem; font-weight: 800;
    box-shadow: 0 10px 26px rgba(200,137,74,0.35); transition: transform 0.2s;
}
.lib-spotlight:hover .spotlight-cta { transform: translateY(-2px); }

@media (max-width: 760px) {
    .lib-spotlight { grid-template-columns: 1fr; min-height: 0; }
    .spotlight-visual { height: 200px; }
    .spotlight-body { padding: 1.6rem 1.4rem 1.8rem; }
}

/* uniform grid — every card an identical spec-sheet asset */
.lib-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 1rem; }
.lib-card {
    position: relative; display: flex; flex-direction: column; border-radius: var(--r-md);
    overflow: hidden; border: 1px solid var(--hair); text-decoration: none; color: inherit;
    background: var(--warm-white);
    transition: transform 0.25s cubic-bezier(.22,.68,0,1.1), box-shadow 0.25s, border-color 0.25s, opacity 0.2s;
}
.lib-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(44,26,14,0.14); border-color: rgba(200,137,74,0.35); }
.lib-card.is-hidden { display: none; }

.lib-card-visual { position: relative; height: 158px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.lib-card-visual .asset-icon { width: 42%; max-width: 62px; color: rgba(255,255,255,0.9); transition: transform 0.35s ease; }
.lib-card:hover .lib-card-visual .asset-icon { transform: scale(1.08) translateY(-2px); }
.lib-card-tag {
    position: absolute; top: 10px; left: 10px; font-family: var(--mono);
    font-size: 0.56rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
    color: #fff; background: rgba(28,15,7,0.55); backdrop-filter: blur(6px);
    padding: 0.22rem 0.55rem; border-radius: 50px;
}
.lib-card-tag.hot { background: rgba(180,60,30,0.78); }
.lib-card-tag.new { background: rgba(200,137,74,0.88); }

.lib-card-body { flex: 1; display: flex; flex-direction: column; padding: 1rem 1.1rem 1.1rem; border-top: 1px solid var(--hair); }
.lib-card-name { font-size: 0.86rem; font-weight: 800; color: var(--brown-deep); margin-bottom: 0.4rem; }
.lib-card-specs { display: flex; flex-wrap: wrap; gap: 0.3rem 0.55rem; margin-bottom: 0.85rem; }
.lib-card-specs span { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.02em; color: var(--text-muted); text-transform: uppercase; }
.lib-card-specs span:not(:last-child)::after { content: '·'; margin-left: 0.55rem; color: var(--hair-strong); }
.lib-card-foot { margin-top: auto; display: flex; align-items: center; justify-content: space-between; gap: 0.6rem; }
.lib-card-price { font-size: 0.78rem; font-weight: 800; color: var(--caramel); }
.lib-card-price span { font-size: 0.64rem; color: var(--text-muted); font-weight: 600; }
.lib-card-btn {
    display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.7rem; font-weight: 800;
    color: var(--brown-deep); padding: 0.4rem 0.7rem; border-radius: 8px;
    background: var(--cream-dark); transition: background 0.2s, color 0.2s; white-space: nowrap;
}
.lib-card-btn svg { width: 10px; height: 10px; }
.lib-card:hover .lib-card-btn { background: var(--caramel); color: #fff; }

.lib-empty {
    display: none; text-align: center; padding: 2.5rem 1rem; color: var(--text-muted);
    font-size: 0.82rem; border: 1.5px dashed var(--hair-strong); border-radius: var(--r-md);
}
.lib-empty.is-visible { display: block; }

@media (max-width: 560px) {
    .lib-grid { grid-template-columns: repeat(2, 1fr); gap: 0.7rem; }
    .lib-card-visual { height: 120px; }
    .lib-card-visual .asset-icon { max-width: 44px; }
    .lib-card-body { padding: 0.8rem 0.85rem 0.9rem; }
}

/* ══════════════════════════════════════════
   § 5 — INSPIRATION
══════════════════════════════════════════ */
.inspiration-tabs { display: flex; gap: 0.3rem; margin-bottom: 1.4rem; border-bottom: 1px solid var(--hair); overflow-x: auto; scrollbar-width: none; }
.inspiration-tabs::-webkit-scrollbar { display: none; }
.insp-tab {
    background: none; border: none; padding: 0.7rem 1.1rem; font-size: 0.72rem; font-weight: 800;
    letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-muted); cursor: pointer;
    position: relative; white-space: nowrap; transition: color 0.2s;
}
.insp-tab::after { content: ''; position: absolute; left: 0; right: 0; bottom: -1px; height: 2px; background: var(--caramel); transform: scaleX(0); transition: transform 0.25s; }
.insp-tab.active { color: var(--brown-deep); }
.insp-tab.active::after { transform: scaleX(1); }
.insp-tab:hover { color: var(--brown-deep); }

.insp-panel { display: none; }
.insp-panel.active { display: block; animation: fadeIn 0.35s ease both; }

.insp-scroll { display: flex; gap: 0.7rem; overflow-x: auto; padding-bottom: 0.4rem; scrollbar-width: none; }
.insp-scroll::-webkit-scrollbar { display: none; }

.insp-item { flex-shrink: 0; min-width: 168px; text-decoration: none; color: inherit; }
.insp-thumb {
    width: 100%; height: 112px; border-radius: var(--r-sm); background: var(--cream-dark);
    display: flex; align-items: center; justify-content: center; margin-bottom: 0.55rem;
    transition: transform 0.25s; border: 1px solid var(--hair); color: var(--caramel);
}
.insp-thumb svg { width: 34px; height: 34px; }
.insp-item:hover .insp-thumb { transform: translateY(-3px); }
.insp-name { font-size: 0.78rem; font-weight: 800; color: var(--brown-deep); }
.insp-sub { font-family: var(--mono); font-size: 0.63rem; color: var(--text-muted); margin-top: 0.15rem; }

/* ══════════════════════════════════════════
   § 6 — PRODUCTION PIPELINE
══════════════════════════════════════════ */
.production-list { display: flex; flex-direction: column; gap: 1.1rem; }
.prod-row {
    border: 1px solid var(--hair); border-radius: var(--r-md); padding: 1.3rem 1.4rem 1.1rem;
    text-decoration: none; color: inherit; display: block; transition: border-color 0.2s, box-shadow 0.2s;
}
.prod-row:hover { border-color: rgba(200,137,74,0.4); box-shadow: 0 14px 34px rgba(44,26,14,0.08); }
.prod-top { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
.prod-thumb {
    width: 46px; height: 46px; border-radius: 10px; background: var(--cream-dark);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--caramel);
}
.prod-thumb svg { width: 20px; height: 20px; }
.prod-id { font-family: var(--mono); font-size: 0.64rem; font-weight: 700; color: var(--caramel); letter-spacing: 0.04em; }
.prod-name { font-size: 0.9rem; font-weight: 800; color: var(--brown-deep); }
.prod-spacer { flex: 1; }
.prod-date { font-family: var(--mono); font-size: 0.68rem; color: var(--text-muted); font-weight: 600; }
.prod-badge {
    font-family: var(--mono); font-size: 0.58rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
    padding: 0.2rem 0.6rem; border-radius: 50px; border: 1px solid;
}
.prod-badge.cancelled { background:#FDF0EE; color:#8B2A1E; border-color:#FCA5A5; }

.stepper { display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.35rem; align-items: end; }
.step { display: flex; flex-direction: column; gap: 0.5rem; }
.step-bar { height: 4px; border-radius: 4px; background: var(--cream-dark); overflow: hidden; }
.step-bar i { display: block; height: 100%; width: 0%; background: var(--hair-strong); }
.step.is-done .step-bar i { width: 100%; background: var(--caramel-light); }
.step.is-active .step-bar i { width: 100%; background: var(--caramel); }
.step-label { font-family: var(--mono); font-size: 0.58rem; font-weight: 700; letter-spacing: 0.03em; text-transform: uppercase; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.step.is-done .step-label { color: var(--brown-mid); }
.step.is-active .step-label { color: var(--caramel); font-weight: 800; }
.step-status-msg { grid-column: 1 / -1; font-size: 0.74rem; color: var(--brown-mid); font-weight: 700; margin-top: 0.6rem; }
.step-status-msg span { font-family: var(--mono); color: var(--text-muted); font-weight: 500; }

@media (max-width: 620px) {
    .stepper { grid-template-columns: repeat(4, 1fr); grid-auto-flow: column; grid-auto-columns: 62px; overflow-x: auto; padding-bottom: 0.2rem; }
    .step-status-msg { grid-column: 1 / -1; }
}

.production-empty { border: 1.5px dashed var(--hair-strong); border-radius: var(--r-md); padding: 2.75rem 2rem; text-align: center; }
.production-empty .pe-icon { display: flex; align-items: center; justify-content: center; margin: 0 auto 0.9rem; color: var(--caramel); opacity: 0.5; }
.production-empty .pe-icon svg { width: 34px; height: 34px; }
.production-empty p { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.2rem; }

/* ══════════════════════════════════════════
   § 7 — STUDIO STATS
══════════════════════════════════════════ */

.stats-strip { display: flex; align-items: center; gap: 3rem; flex-wrap: wrap; padding: 1.75rem 0; border-top: 1px solid var(--hair); border-bottom: 1px solid var(--hair); }
.stat-block { display: flex; align-items: baseline; gap: 0.6rem; }
.stat-num { font-family: var(--mono); font-size: 2.6rem; font-weight: 700; letter-spacing: -0.02em; color: var(--brown-deep); line-height: 1; }
.stat-lab { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-muted); }
.stat-lab svg { opacity: 0.7; flex-shrink: 0; width: 12px; height: 12px; }
.stats-strip .stat-fill { flex: 1; }
.stats-strip .stat-cta { font-size: 0.76rem; font-weight: 800; color: var(--caramel); text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; }
.stats-strip .stat-cta svg { width: 11px; height: 11px; }

/* ══════════════════════════════════════════
   § 8 — ACCOUNT RAIL
══════════════════════════════════════════ */
.account-rail { display: flex; gap: 0.8rem; flex-wrap: wrap; }
.acc-link {
    display: inline-flex; align-items: center; gap: 0.55rem; padding: 0.65rem 1.05rem;
    border: 1px solid var(--hair); border-radius: 50px; text-decoration: none;
    color: var(--brown-mid); font-size: 0.76rem; font-weight: 700; transition: all 0.2s;
}
.acc-link:hover { border-color: var(--caramel); color: var(--caramel); }
.acc-link svg { width: 14px; height: 14px; }

.page-end-pad { height: 1rem; }
</style>
@endpush

@section('content')
<div class="studio">

    {{-- ══════════════════════════════════════
         § 1  STUDIO HEADER
    ══════════════════════════════════════ --}}
    <div class="studio-header reveal d1">
        <div class="studio-header-left">
          
            <h1><em>Welcome</em> {{ auth()->user()->first_name }} </h1>
            <div class="workflow" aria-hidden="true">
                <span class="workflow-step is-current">Design</span>
                <span class="workflow-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                <span class="workflow-step">Customize</span>
                <span class="workflow-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                <span class="workflow-step">Preview</span>
                <span class="workflow-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                <span class="workflow-step">Order</span>
            </div>
        </div>
        <div class="studio-header-right">
            <div class="readout"><b>{{ $totalRequests }}</b><span>Orders</span></div>
            @if($completedRequests > 0)
                <div class="readout-divider"></div>
                <div class="readout"><b>{{ $completedRequests }}</b><span>Delivered</span></div>
            @endif
          
        </div>
    </div>

    {{-- ══════════════════════════════════════
         § 2  3D STUDIO VIEWPORT
    ══════════════════════════════════════ --}}
    <div class="viewport-section reveal d2" id="viewportSection">
        <div class="viewport-atmosphere"></div>
        <div class="viewport-grid"></div>

        <div class="viewport-stage">
            <canvas id="cakeCanvas" aria-label="Interactive 3D cake preview"></canvas>
        </div>

        <div class="viewport-loader" id="viewportLoader">
            <div class="viewport-loader-ring"></div>
            <span>Loading studio&hellip;</span>
        </div>

        {{-- corner viewfinder brackets --}}
        <div class="viewport-frame">
            <div class="vf-corner vf-tl"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 8V2a1 1 0 0 1 1-1h6" stroke="#E8B07A"/></svg></div>
            <div class="vf-corner vf-tr"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 8V2a1 1 0 0 1 1-1h6" stroke="#E8B07A"/></svg></div>
            <div class="vf-corner vf-bl"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 8V2a1 1 0 0 1 1-1h6" stroke="#E8B07A"/></svg></div>
            <div class="vf-corner vf-br"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 8V2a1 1 0 0 1 1-1h6" stroke="#E8B07A"/></svg></div>
        </div>

        <div class="viewport-copy">
            <h2>Create something<br>worth celebrating.</h2>
        </div>

        {{-- view presets --}}
        <div class="vp-seg" id="vpSeg" role="group" aria-label="Camera view presets">
            <button type="button" data-view="perspective" class="active">Iso</button>
            <button type="button" data-view="front">Front</button>
            <button type="button" data-view="side">Side</button>
            <button type="button" data-view="top">Top</button>
        </div>

        {{-- technical metadata --}}
        <div class="viewport-meta">
            <div class="vm-row"><span class="vm-label">Model</span><span class="vm-value">Signature Tier</span></div>
            <div class="vm-row"><span class="vm-label">Material</span><span class="vm-value">Buttercream &middot; Caramel</span></div>
            <div class="vm-row"><span class="vm-label">Status</span><span class="vm-value is-live"><span class="vm-dot"></span>Ready</span></div>
        </div>

        {{-- live telemetry --}}
        <div class="viewport-telemetry">
            <div class="vt-item"><span class="vt-label">Orbit</span><span class="vt-value" id="vtOrbit">Enabled</span></div>
            <div class="vt-item"><span class="vt-label">Zoom</span><span class="vt-value" id="vtZoom">100%</span></div>
        </div>

        <div class="viewport-cta">
            <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Start Designing
            </a>
        </div>

        <div class="viewport-controls">
            <button type="button" class="vc-btn" id="vcReset" title="Reset camera" aria-label="Reset camera">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 1 3 6.7"/><path d="M3 16v-4h4"/></svg>
            </button>
            <button type="button" class="vc-btn is-active" id="vcAutoRotate" title="Toggle auto-rotate" aria-label="Toggle auto-rotate" aria-pressed="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3.5-7.1"/><path d="M21 3v5h-5"/></svg>
            </button>
            <button type="button" class="vc-btn" id="vcZoomIn" title="Zoom in" aria-label="Zoom in">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
            <button type="button" class="vc-btn" id="vcZoomOut" title="Zoom out" aria-label="Zoom out">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="8" y1="11" x2="14" y2="11"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
            <button type="button" class="vc-btn" id="vcExpand" title="Expand" aria-label="Expand viewport">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         § 6  PRODUCTION PIPELINE
    ══════════════════════════════════════ --}}
    <div class="reveal d5">
        <div class="section-head">
            <div>
  
                <div class="heading-lg">Cake Production</div>
            </div>
            <a href="{{ route('customer.cake-requests.index') }}" class="section-link">All orders <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>

        @if($recentRequests->count())
            <div class="production-list">
                @foreach($recentRequests->take(5) as $req)
                @php
                    $cfg = is_array($req->cake_configuration)
                        ? $req->cake_configuration
                        : (json_decode($req->cake_configuration, true) ?? []);

                    // stage index across REQUEST -> BIDDING -> ACCEPTED -> PAYMENT -> CRAFTING -> READY -> DELIVERED
                    $stageIndex = match($req->status) {
                        'OPEN'                  => 0,
                        'BIDDING'                => 1,
                        'ACCEPTED'                => 2,
                        'WAITING_FOR_PAYMENT'    => 3,
                        'IN_PROGRESS'             => 4,
                        'WAITING_FINAL_PAYMENT'  => 5,
                        'COMPLETED'               => 6,
                        default                   => 0,
                    };
                    $isTerminalCancel = in_array($req->status, ['CANCELLED', 'EXPIRED']);

                    $statusMsg = match($req->status) {
                        'OPEN'                  => 'Waiting for baker bids',
                        'BIDDING'               => 'Bakers are bidding on this request',
                        'ACCEPTED'              => 'Baker confirmed — awaiting start',
                        'WAITING_FOR_PAYMENT'   => 'Downpayment needed to begin crafting',
                        'IN_PROGRESS'           => 'Your cake is being crafted right now',
                        'WAITING_FINAL_PAYMENT' => 'Ready — final balance due',
                        'COMPLETED'             => 'Delivered with love',
                        'CANCELLED'             => 'This order was cancelled',
                        'EXPIRED'               => 'This request expired',
                        default                 => str_replace('_', ' ', $req->status),
                    };

                    $stages = ['Request', 'Bidding', 'Accepted', 'Payment', 'Crafting', 'Ready', 'Delivered'];
                @endphp
                <a href="{{ route('customer.cake-requests.show', $req->id) }}" class="prod-row">
                    <div class="prod-top">
                        <div class="prod-thumb">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="19" rx="8" ry="1.6"/><path d="M5 19v-5c0-.9 3.1-1.6 7-1.6s7 .7 7 1.6v5"/><path d="M5 14c0-.9 3.1-1.6 7-1.6s7 .7 7 1.6"/><path d="M8 12.4V9.3c0-.7 1.8-1.3 4-1.3s4 .6 4 1.3v3.1"/><path d="M11 8V4"/></svg>
                        </div>
                        <div>
                            <div class="prod-id">ORDER #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</div>
                            <div class="prod-name">{{ $cfg['flavor'] ?? 'Custom' }} {{ $cfg['shape'] ?? 'Cake' }}</div>
                        </div>
                        <div class="prod-spacer"></div>
                        @if($isTerminalCancel)
                            <span class="prod-badge cancelled">{{ str_replace('_', ' ', $req->status) }}</span>
                        @endif
                        <div class="prod-date">{{ $req->delivery_date->format('M d, Y') }}</div>
                    </div>

                    @unless($isTerminalCancel)
                    <div class="stepper">
                        @foreach($stages as $i => $label)
                            <div class="step {{ $i < $stageIndex ? 'is-done' : ($i === $stageIndex ? 'is-active' : '') }}">
                                <div class="step-bar"><i></i></div>
                                <div class="step-label">{{ $label }}</div>
                            </div>
                        @endforeach
                        <div class="step-status-msg">{{ $statusMsg }} <span>&middot; stage {{ $stageIndex + 1 }} of 7</span></div>
                    </div>
                    @else
                    <div class="step-status-msg" style="margin-top:0;">{{ $statusMsg }}</div>
                    @endunless
                </a>
                @endforeach
            </div>
        @else
            <div class="production-empty">
                <span class="pe-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="19" rx="8" ry="1.6"/><path d="M5 19v-5c0-.9 3.1-1.6 7-1.6s7 .7 7 1.6v5"/><path d="M5 14c0-.9 3.1-1.6 7-1.6s7 .7 7 1.6"/><path d="M8 12.4V9.3c0-.7 1.8-1.3 4-1.3s4 .6 4 1.3v3.1"/><path d="M11 8V4"/></svg></span>
                <p>No orders yet — your production line starts with your first cake.</p>
                <a href="{{ route('customer.cake-builder.index') }}" class="btn-primary" style="display:inline-flex;">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Start My First Order
                </a>
            </div>
        @endif
    </div>
    <div class="page-end-pad"></div>
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
/* safety net: if the CDN module never loads (offline, blocked, slow),
   stop showing "Loading studio…" forever and fall back gracefully. */
const __viewportFallbackTimer = setTimeout(() => {
    const loader = document.getElementById('viewportLoader');
    if (loader && !loader.classList.contains('is-hidden')) {
        loader.querySelector('span').textContent = '3D preview unavailable — you can still design below';
        loader.querySelector('.viewport-loader-ring').style.display = 'none';
        loader.style.background = 'transparent';
    }
}, 7000);

let THREE, OrbitControls;
try {
    [THREE, { OrbitControls }] = await Promise.all([
        import('three'),
        import('three/addons/controls/OrbitControls.js'),
    ]);
} catch (err) {
    console.warn('3D studio: three.js failed to load, skipping viewport.', err);
}

/* ── scroll-reveal (cheap, no library) ── */
if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) e.target.style.animationPlayState = 'running'; });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
}

/* ── design library filters ── */
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
        empty.classList.toggle('is-visible', visibleCount === 0);
    });
})();

/* ── inspiration tabs ── */
const tabs = document.querySelectorAll('.insp-tab');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.insp-panel').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.target).classList.add('active');
    });
});

/* ── 3D cake studio viewport ── */
(function initCakeStudio() {
    const section = document.getElementById('viewportSection');
    const canvas = document.getElementById('cakeCanvas');
    if (!section || !canvas || !window.WebGLRenderingContext || !THREE || !OrbitControls) return;
    clearTimeout(__viewportFallbackTimer);

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.75));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.outputColorSpace = THREE.SRGBColorSpace;

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(32, 1, 0.1, 50);
    const VIEW_PRESETS = {
        perspective: new THREE.Vector3(3.4, 2.1, 4.6),
        front:       new THREE.Vector3(0, 0.7, 5.6),
        side:        new THREE.Vector3(5.6, 0.7, 0),
        top:         new THREE.Vector3(0.01, 6.2, 0.01),
    };
    const startPos = VIEW_PRESETS.perspective.clone();
    camera.position.copy(startPos);

    /* lighting — warm studio setup, kept cheap */
    scene.add(new THREE.AmbientLight(0xfff1de, 0.55));

    const key = new THREE.DirectionalLight(0xfff4e0, 1.15);
    key.position.set(4, 6, 3);
    key.castShadow = true;
    key.shadow.mapSize.set(512, 512);
    key.shadow.camera.left = -3; key.shadow.camera.right = 3;
    key.shadow.camera.top = 3; key.shadow.camera.bottom = -3;
    key.shadow.radius = 3;
    scene.add(key);

    const fill = new THREE.PointLight(0xc8894a, 0.9, 12);
    fill.position.set(-3, 1.5, -2);
    scene.add(fill);

    const rim = new THREE.PointLight(0xe8b07a, 0.5, 10);
    rim.position.set(0, 1, -4);
    scene.add(rim);

    /* floor: soft matte disc + faint grid ring, no big flat card */
    const floor = new THREE.Mesh(
        new THREE.CircleGeometry(6, 48),
        new THREE.MeshStandardMaterial({ color: 0x241407, roughness: 1, metalness: 0 })
    );
    floor.rotation.x = -Math.PI / 2;
    floor.position.y = -1.05;
    floor.receiveShadow = true;
    scene.add(floor);

    const grid = new THREE.GridHelper(9, 24, 0xc8894a, 0x3d2416);
    grid.position.y = -1.04;
    grid.material.transparent = true;
    grid.material.opacity = 0.18;
    scene.add(grid);

    /* ── procedural cake ── */
    const cake = new THREE.Group();

    const board = new THREE.Mesh(
        new THREE.CylinderGeometry(1.55, 1.55, 0.06, 40),
        new THREE.MeshStandardMaterial({ color: 0xfddfc0, roughness: 0.7 })
    );
    board.position.y = -0.03;
    board.castShadow = true; board.receiveShadow = true;
    cake.add(board);

    const tierDefs = [
        { r: 1.15, h: 0.62, y: 0.34,  color: 0xf5ede0 },
        { r: 0.85, h: 0.55, y: 1.02,  color: 0xe8b07a },
        { r: 0.58, h: 0.46, y: 1.60,  color: 0xc8894a },
    ];
    tierDefs.forEach(t => {
        const mesh = new THREE.Mesh(
            new THREE.CylinderGeometry(t.r, t.r * 1.02, t.h, 40),
            new THREE.MeshStandardMaterial({ color: t.color, roughness: 0.5, metalness: 0.04, envMapIntensity: 0.6 })
        );
        mesh.position.y = t.y;
        mesh.castShadow = true; mesh.receiveShadow = true;
        cake.add(mesh);

        const drip = new THREE.Mesh(
            new THREE.TorusGeometry(t.r * 1.01, 0.035, 10, 40),
            new THREE.MeshStandardMaterial({ color: 0x5c3d2e, roughness: 0.35, metalness: 0.15 })
        );
        drip.rotation.x = Math.PI / 2;
        drip.position.y = t.y + t.h / 2;
        cake.add(drip);
    });

    const topper = new THREE.Mesh(
        new THREE.SphereGeometry(0.12, 24, 24),
        new THREE.MeshStandardMaterial({ color: 0xc8894a, roughness: 0.2, metalness: 0.35 })
    );
    topper.position.y = 1.95;
    topper.castShadow = true;
    cake.add(topper);

    cake.position.y = -0.35;
    scene.add(cake);

    /* controls */
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.target.set(0, 0.55, 0);
    controls.enableDamping = true;
    controls.dampingFactor = 0.08;
    controls.enablePan = false;
    controls.minDistance = 3.2;
    controls.maxDistance = 8.5;
    controls.maxPolarAngle = Math.PI / 2 - 0.05;
    controls.minPolarAngle = 0.05;
    controls.autoRotate = !reducedMotion;
    controls.autoRotateSpeed = 0.7;
    controls.update();

    const startDist = startPos.length();

    /* live telemetry readouts */
    const vtOrbit = document.getElementById('vtOrbit');
    const vtZoom = document.getElementById('vtZoom');
    function updateTelemetry() {
        if (vtOrbit) vtOrbit.textContent = controls.autoRotate ? 'Auto' : 'Manual';
        if (vtZoom) {
            const dist = camera.position.distanceTo(controls.target);
            const pct = Math.round((startDist / Math.max(dist, 0.001)) * 100);
            vtZoom.textContent = Math.max(30, Math.min(260, pct)) + '%';
        }
    }

    let idleTimer = null;
    controls.addEventListener('start', () => {
        controls.autoRotate = false;
        setAutoRotateBtnState(false);
        if (idleTimer) clearTimeout(idleTimer);
    });
    controls.addEventListener('end', () => {
        if (reducedMotion) return;
        idleTimer = setTimeout(() => { controls.autoRotate = true; setAutoRotateBtnState(true); }, 2600);
    });

    /* render-on-demand loop, paused off-screen / hidden tab */
    let needsRender = true;
    let running = false;
    let rafId = null;
    controls.addEventListener('change', () => { needsRender = true; updateTelemetry(); });

    function resize() {
        const w = section.clientWidth, h = section.clientHeight;
        if (!w || !h) return;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h, false);
        needsRender = true;
    }

    const loader = document.getElementById('viewportLoader');
    let firstFrameDone = false;

    function frame() {
        if (!running) return;
        if (controls.autoRotate || controls.enableDamping) { controls.update(); needsRender = true; }
        if (needsRender) {
            renderer.render(scene, camera);
            needsRender = false;
            if (!firstFrameDone) {
                firstFrameDone = true;
                loader?.classList.add('is-hidden');
                updateTelemetry();
            }
        }
        rafId = requestAnimationFrame(frame);
    }
    function start() { if (!running) { running = true; frame(); } }
    function stop() { running = false; if (rafId) cancelAnimationFrame(rafId); }

    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { e.isIntersecting ? start() : stop(); });
    }, { threshold: 0.05 });
    io.observe(section);

    document.addEventListener('visibilitychange', () => {
        document.hidden ? stop() : (section.getBoundingClientRect().top < window.innerHeight && start());
    });

    window.addEventListener('resize', resize);
    resize();
    start();

    /* viewport control buttons */
    document.getElementById('vcReset').addEventListener('click', () => {
        controls.reset();
        camera.position.copy(startPos);
        setViewPresetActive('perspective');
        needsRender = true;
    });

    const autoRotateBtn = document.getElementById('vcAutoRotate');
    function setAutoRotateBtnState(on) {
        if (!autoRotateBtn) return;
        autoRotateBtn.classList.toggle('is-active', on);
        autoRotateBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
    }
    autoRotateBtn?.addEventListener('click', () => {
        controls.autoRotate = !controls.autoRotate;
        setAutoRotateBtnState(controls.autoRotate);
        updateTelemetry();
    });

    function dolly(factor) {
        const dir = new THREE.Vector3().subVectors(camera.position, controls.target);
        const dist = THREE.MathUtils.clamp(dir.length() * factor, controls.minDistance, controls.maxDistance);
        dir.normalize().multiplyScalar(dist);
        camera.position.copy(controls.target).add(dir);
        needsRender = true;
        updateTelemetry();
    }
    document.getElementById('vcZoomIn').addEventListener('click', () => dolly(0.82));
    document.getElementById('vcZoomOut').addEventListener('click', () => dolly(1.22));

    const expandBtn = document.getElementById('vcExpand');
    expandBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            section.requestFullscreen?.();
        } else {
            document.exitFullscreen?.();
        }
    });
    document.addEventListener('fullscreenchange', () => setTimeout(resize, 60));

    /* view presets */
    const vpSeg = document.getElementById('vpSeg');
    function setViewPresetActive(name) {
        vpSeg?.querySelectorAll('button').forEach(b => b.classList.toggle('active', b.dataset.view === name));
    }
    vpSeg?.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const pos = VIEW_PRESETS[btn.dataset.view];
        if (!pos) return;
        controls.autoRotate = false;
        setAutoRotateBtnState(false);
        camera.position.copy(pos);
        controls.target.set(0, 0.55, 0);
        setViewPresetActive(btn.dataset.view);
        needsRender = true;
        updateTelemetry();
    });
})();
</script>
@endpush