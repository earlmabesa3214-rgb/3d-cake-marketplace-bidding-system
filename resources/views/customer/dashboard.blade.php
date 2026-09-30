@extends('layouts.customer')
@section('title', 'Dashboard')
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --espresso:       #24150F;
    --choco:          #3A241A;
    --ivory:          #F7F2E9;
    --cream:          #EFE6D7;
    --caramel:        #A96F42;
    --caramel-light:  #C8894A;
    --gold:           #B89452;
    --gold-light:     #D4B06A;
    --burgundy:       #54252C;
    --taupe:          #9A897A;
    --beige:          #D8C8B7;
    --blush:          #E8D3CA;
    --text-dark:      #1C0E08;
    --text-mid:       #5C3D2E;
    --text-muted:     #8C7060;
    --border:         rgba(58,36,26,0.14);
    --border-gold:    rgba(184,148,82,0.28);
}

@keyframes fadeUp   { from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:none} }
@keyframes fadeIn   { from{opacity:0}to{opacity:1} }
@keyframes marquee  { to{transform:translateX(-33.3333%)} }
@keyframes lineDraw { from{transform:scaleX(0)}to{transform:scaleX(1)} }
@keyframes imgReveal{ from{clip-path:inset(0 100% 0 0)}to{clip-path:inset(0 0% 0 0)} }

@media (prefers-reduced-motion: reduce) {
    .ds-reveal,.ds-reveal-img,.ds-line { animation:none!important; opacity:1!important; clip-path:none!important; transform:none!important; }
    .marquee-track { animation:none!important; }
}

.ds, .ds * { font-family:'Plus Jakarta Sans',sans-serif !important; }
.ds { display:flex; flex-direction:column; background:var(--ivory); color:var(--text-dark); margin:-1.8rem; }
.serif { font-family:'DM Serif Display',serif !important; }
@media(max-width:768px){ .ds{margin:-1rem;} }
.ds a { text-decoration:none; color:inherit; }
.ds img { display:block; max-width:100%; }
.ds button { font-family:inherit; cursor:pointer; }

.ds-reveal { opacity:0; animation:fadeUp .75s cubic-bezier(.22,.68,0,1.1) both; }
.ds-reveal.d1 { animation-delay:.08s; }
.ds-reveal.d2 { animation-delay:.18s; }
.ds-reveal.d3 { animation-delay:.28s; }
.ds-reveal.d4 { animation-delay:.38s; }
.ds.js-anim .ds-reveal { animation-play-state:paused; }

/* ── TYPOGRAPHY ── */
.serif { font-family:'DM Serif Display',serif; }
.label-xs {
    font-size:.68rem; font-weight:700; letter-spacing:.2em;
    text-transform:uppercase; color:var(--taupe);
}
.label-gold {
    font-size:.68rem; font-weight:700; letter-spacing:.2em;
    text-transform:uppercase; color:var(--gold);
}

/* ── BUTTONS ── */
.btn-atelier {
    display:inline-flex; align-items:center; gap:.65rem;
    padding:.9rem 2rem;
    background:var(--espresso); color:var(--ivory);
    font-size:.88rem; font-weight:700; letter-spacing:.04em;
    border:none; cursor:pointer;
    transition:background .25s, transform .2s, box-shadow .2s;
    box-shadow:0 8px 28px rgba(36,21,15,.32);
}
.btn-atelier:hover { background:var(--choco); transform:translateY(-2px); box-shadow:0 14px 36px rgba(36,21,15,.4); color:var(--ivory); }
.btn-atelier-outline {
    display:inline-flex; align-items:center; gap:.65rem;
    padding:.85rem 1.9rem;
    background:transparent; color:var(--espresso);
    font-size:.88rem; font-weight:700; letter-spacing:.04em;
    border:1.5px solid var(--espresso); cursor:pointer;
    transition:all .22s;
}
.btn-atelier-outline:hover { background:var(--espresso); color:var(--ivory); transform:translateY(-2px); }
.btn-gold {
    display:inline-flex; align-items:center; gap:.65rem;
    padding:.9rem 2rem;
    background:var(--gold); color:var(--espresso);
    font-size:.88rem; font-weight:800; letter-spacing:.04em;
    border:none; cursor:pointer;
    transition:all .22s;
    box-shadow:0 8px 28px rgba(184,148,82,.35);
}
.btn-gold:hover { background:var(--gold-light); transform:translateY(-2px); box-shadow:0 14px 36px rgba(184,148,82,.45); color:var(--espresso); }

/* ══════════════════════════════════════
   01. HERO
══════════════════════════════════════ */
.hero-atelier {
    position:relative; overflow:hidden;
    min-height:clamp(520px,85vh,700px);
    display:grid; grid-template-columns:minmax(0,1fr) minmax(0,1fr); align-items:stretch;
    background:var(--espresso);
    padding:0;
}
.hero-left {
    position:relative; z-index:3;
    padding:4.5rem 3rem 4.5rem clamp(1.5rem,4vw,4rem);
    display:flex; flex-direction:column; justify-content:center; gap:1.8rem;
}
.hero-atelier-number {
    font-size:clamp(10rem,18vw,18rem);
    font-family:'DM Serif Display',serif;
    font-style:italic;
    line-height:.82;
    color:rgba(255,255,255,.04);
    position:absolute;
    left:2.5rem; bottom:3rem;
    pointer-events:none; user-select:none; z-index:0;
    letter-spacing:-.04em;
}
.hero-eyebrow {
    display:flex; align-items:center; gap:1rem;
}
.hero-eyebrow-line {
    width:36px; height:1px; background:var(--gold);
}
.hero-eyebrow-text {
    font-size:.68rem; font-weight:700; letter-spacing:.22em;
    text-transform:uppercase; color:var(--gold);
}
.hero-heading {
    font-family:'DM Serif Display',serif;
    font-size:clamp(2.3rem,3.6vw,4rem);
    line-height:1;
    color:var(--ivory);
    letter-spacing:-.02em;
}
.hero-heading em { font-style:italic; color:var(--gold); }
.hero-lede {
    font-size:.92rem; line-height:1.6; color:rgba(247,242,233,.58);
    max-width:46ch; font-weight:400;
}
.hero-actions { display:flex; gap:1rem; flex-wrap:wrap; align-items:center; }
.hero-perks {
    display:flex; flex-direction:column; gap:.4rem;
    list-style:none;
}
.hero-perks li {
    display:flex; align-items:center; gap:.75rem;
    font-size:.8rem; font-weight:600; color:rgba(247,242,233,.5);
    letter-spacing:.02em;
}
.hero-perks li::before {
    content:''; width:16px; height:1px; background:var(--gold); flex-shrink:0;
}

/* Hero right — photo composition */
.hero-right {
    position:relative; height:100%; min-height:420px; overflow:hidden;
}
.hero-img-main {
    position:absolute; inset:0;
    width:100%; height:100%;
    object-fit:cover; object-position:center;
    filter:brightness(.72) saturate(.9);
}
.hero-img-overlay {
    position:absolute; inset:0;
    background:linear-gradient(90deg, var(--espresso) 0%, transparent 45%),
               linear-gradient(0deg, var(--espresso) 0%, transparent 30%);
}
.hero-pic2-badge {
    position:absolute; bottom:1.5rem; left:1.5rem; z-index:5;
    width:150px; height:150px;
    border:5px solid var(--espresso);
    box-shadow:0 20px 50px rgba(36,21,15,.6);
    overflow:hidden;
}
.hero-pic2-badge img {
    width:100%; height:100%; object-fit:cover;
    filter:brightness(.88) saturate(.9);
}
.hero-pic2-frame {
    position:absolute; bottom:1.5rem; left:1.5rem; z-index:6;
    width:150px; height:150px;
    border:1px solid rgba(184,148,82,.4);
    pointer-events:none;
    transform:translate(10px,-10px);
}
.hero-badge-atelier {
    position:absolute; bottom:1.5rem; right:1.5rem;
    width:120px; height:120px;
    border:1px solid rgba(184,148,82,.5);
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    text-align:center; gap:.3rem;
    background:rgba(36,21,15,.82);
    backdrop-filter:blur(12px);
    z-index:4;
}
.hero-badge-atelier .badge-main {
    font-family:'DM Serif Display',serif;
    font-size:1.1rem; color:var(--gold); line-height:1.2;
    font-style:italic;
}
.hero-badge-atelier .badge-sub {
    font-size:.58rem; font-weight:700; letter-spacing:.16em;
    text-transform:uppercase; color:rgba(247,242,233,.45);
}
.hero-float-card {
    position:absolute; top:1.5rem; right:1.5rem; z-index:4;
    background:rgba(36,21,15,.78); backdrop-filter:blur(12px);
    border:1px solid var(--border-gold);
    padding:.9rem 1.2rem;
    display:flex; align-items:center; gap:.85rem;
}
.hero-float-icon {
    width:36px; height:36px; background:var(--gold);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.hero-float-label { font-size:.6rem; font-weight:700; letter-spacing:.15em; text-transform:uppercase; color:rgba(247,242,233,.5); }
.hero-float-value { font-size:.86rem; font-weight:700; color:var(--ivory); margin-top:.1rem; }
.hero-line-deco {
    position:absolute; left:0; right:0; bottom:0;
    height:1px; background:linear-gradient(90deg, transparent, var(--border-gold), transparent);
}

/* tablet */
@media(max-width:980px){
    .hero-atelier { grid-template-columns:1fr; min-height:auto; }
    .hero-right { min-height:320px; height:320px; }
    .hero-left { padding:2.5rem 1.5rem; gap:1.2rem; }
    .hero-heading { font-size:clamp(2rem,6vw,3rem); }
    .hero-img-overlay {
        background:linear-gradient(0deg, var(--espresso) 0%, transparent 35%);
    }
}

/* phone */
@media(max-width:600px){
    .hero-left { padding:2rem 1.25rem; }
    .hero-right { min-height:240px; height:240px; }
    .hero-actions { width:100%; }
    .hero-actions a { flex:1 1 100%; justify-content:center; }
    .hero-pic2-badge, .hero-pic2-frame, .hero-badge-atelier { display:none; }
    .hero-float-card { top:1rem; right:1rem; padding:.6rem .9rem; }
    .hero-atelier-number { display:none; }
}

/* stop the negative margin from causing sideways scroll */
/* stop the negative margin from causing sideways scroll */
.ds { overflow-x:hidden; }

/* ══════════════════════════════════════
   02. QUICK ACTIONS
══════════════════════════════════════ */
.qa-strip {
    background:var(--cream);
    border-top:1px solid var(--border);
    border-bottom:1px solid var(--border);
}
.qa-inner {
    max-width:1300px; margin:0 auto;
    display:grid; grid-template-columns:repeat(5,1fr);
}
.qa-item {
    display:flex; flex-direction:column; gap:.55rem;
    padding:2rem 1.8rem;
    border-right:1px solid var(--border);
    transition:background .2s;
    color:var(--text-dark);
    position:relative; overflow:hidden;
}
.qa-item:last-child { border-right:none; }
.qa-item::after {
    content:''; position:absolute; bottom:0; left:0; right:0;
    height:2px; background:var(--gold);
    transform:scaleX(0); transform-origin:left;
    transition:transform .3s cubic-bezier(.22,.68,0,1.1);
}
.qa-item:hover { background:var(--ivory); }
.qa-item:hover::after { transform:scaleX(1); }
.qa-num {
    font-size:.6rem; font-weight:800; letter-spacing:.22em;
    color:var(--gold); font-variant-numeric:tabular-nums;
}
.qa-icon {
    width:28px; height:28px; color:var(--choco);
    transition:transform .2s, color .2s;
}
.qa-item:hover .qa-icon { transform:translateY(-2px); color:var(--caramel); }
.qa-title { font-size:.82rem; font-weight:800; color:var(--text-dark); letter-spacing:.01em; }
.qa-sub { font-size:.72rem; color:var(--text-muted); line-height:1.4; }

@media(max-width:980px){
    .qa-inner { grid-template-columns:repeat(2,1fr); }
    .qa-item { border-right:none; border-bottom:1px solid var(--border); }
    .qa-item:nth-child(2n) { border-left:1px solid var(--border); }
}

/* ══════════════════════════════════════
   03. AT A GLANCE
══════════════════════════════════════ */
.glance-band {
    background:var(--ivory);
    padding:4.5rem 5rem;
}
.glance-inner { max-width:1300px; margin:0 auto; }
.glance-header {
    display:flex; justify-content:space-between; align-items:flex-end;
    margin-bottom:2.5rem; gap:2rem; flex-wrap:wrap;
}
.glance-header h2 {
    font-family:'DM Serif Display',serif;
    font-size:clamp(2rem,3.5vw,3rem);
    line-height:1.06; color:var(--espresso);
}
.glance-grid {
    display:grid; grid-template-columns:repeat(4,1fr);
    border:1px solid var(--border);
}
.glance-cell {
    padding:2.2rem 2rem;
    border-right:1px solid var(--border);
    display:flex; flex-direction:column; gap:.4rem;
    transition:background .2s;
}
.glance-cell:last-child { border-right:none; }
.glance-cell:hover { background:var(--cream); }
.glance-cell-label { font-size:.65rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--taupe); }
.glance-cell-value {
    font-family:'DM Serif Display',serif;
    font-size:3rem; line-height:1; color:var(--espresso);
    letter-spacing:-.02em;
}
.glance-cell-link {
    font-size:.72rem; font-weight:700; color:var(--caramel);
    display:inline-flex; align-items:center; gap:.35rem;
    margin-top:.5rem; letter-spacing:.02em;
}
.glance-cell-link::after { content:'→'; }
@media(max-width:860px){
    .glance-band { padding:3rem 1.5rem; }
    .glance-grid { grid-template-columns:1fr 1fr; }
    .glance-cell:nth-child(2n) { border-right:none; }
    .glance-cell:nth-child(-n+2) { border-bottom:1px solid var(--border); }
}

/* ══════════════════════════════════════
   04. DESIGN → REALITY
══════════════════════════════════════ */
.d2r {
    background:var(--choco);
    padding:6rem 5rem;
    position:relative; overflow:hidden;
}
.d2r::before {
    content:''; position:absolute;
    inset:0; pointer-events:none;
    background:radial-gradient(ellipse 70% 60% at 80% 0%, rgba(184,148,82,.1), transparent 55%);
}
.d2r-inner { max-width:1300px; margin:0 auto; }
.d2r-header { margin-bottom:3.5rem; }
.d2r-header .label-gold { margin-bottom:1rem; display:block; }
.d2r-header h2 {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:clamp(2rem,3.5vw,3rem);
    color:var(--ivory); line-height:1.04; letter-spacing:-.02em;
    white-space:nowrap;
}
.d2r-header h2 em { font-style:italic; color:var(--gold); }
.d2r-header p { color:rgba(247,242,233,.5); margin-top:.9rem; line-height:1.4; max-width:none; font-size:.9rem; white-space:nowrap; }
.d2r-stage {
    display:grid !important; grid-template-columns:1fr 80px 1fr !important; align-items:center !important; gap:0 !important;
}
.d2r-panel { position:relative; overflow:hidden; display:block !important; }
.d2r-panel-img { width:100% !important; aspect-ratio:4/3 !important; object-fit:cover !important; display:block !important; }
.d2r-panel-caption { position:absolute !important; bottom:0 !important; left:0 !important; right:0 !important; padding:1.4rem 1.6rem !important; background:linear-gradient(0deg,rgba(36,21,15,.9) 0%,transparent 100%) !important; display:flex !important; flex-direction:column !important; gap:.25rem !important; }
.d2r-divider { display:flex !important; flex-direction:column !important; align-items:center !important; justify-content:center !important; gap:1rem !important; padding:1rem 0 !important; }
.d2r-divider-line { width:1px !important; height:60px !important; background:var(--border-gold) !important; display:block !important; }
.d2r-arrow { width:48px !important; height:48px !important; border:1px solid var(--border-gold) !important; display:flex !important; align-items:center !important; justify-content:center !important; color:var(--gold) !important; background:rgba(36,21,15,.5) !important; }
.d2r-panel {
    position:relative; overflow:hidden;
}
.d2r-panel-img {
    width:100%; aspect-ratio:4/3;
    object-fit:cover;
    display:block;
}
.d2r-panel-caption {
    position:absolute; bottom:0; left:0; right:0;
    padding:1.4rem 1.6rem;
    background:linear-gradient(0deg, rgba(36,21,15,.9) 0%, transparent 100%);
    display:flex; flex-direction:column; gap:.25rem;
}
.d2r-panel-tag {
    font-size:.58rem; font-weight:800; letter-spacing:.2em; text-transform:uppercase;
}
.d2r-panel-tag.design-tag { color:var(--gold); }
.d2r-panel-tag.real-tag   { color:var(--blush); }
.d2r-panel-name { font-size:1rem; font-weight:700; color:var(--ivory); }
.d2r-divider {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:1rem; padding:1rem 0;
}
.d2r-divider-line { width:1px; height:60px; background:var(--border-gold); }
.d2r-arrow {
    width:48px; height:48px; border:1px solid var(--border-gold);
    display:flex; align-items:center; justify-content:center;
    color:var(--gold);
    background:rgba(36,21,15,.5);
}
@media(max-width:860px){
    .d2r { padding:4rem 1.5rem; }
    .d2r-stage { grid-template-columns:1fr; grid-template-rows:auto auto auto; }
    .d2r-divider { flex-direction:row; padding:0 1rem; }
    .d2r-divider-line { width:60px; height:1px; }
    .d2r-arrow { transform:rotate(90deg); }
}

/* ══════════════════════════════════════
   05. MARQUEE
══════════════════════════════════════ */
.marquee-band {
    background:var(--espresso);
    border-top:1px solid rgba(184,148,82,.2);
    border-bottom:1px solid rgba(184,148,82,.2);
    padding:1.1rem 0; overflow:hidden;
}
.marquee-track { display:flex; width:max-content; animation:marquee 60s linear infinite; }
.marquee-band:hover .marquee-track { animation-play-state:paused; }
.marquee-group { display:flex; align-items:center; flex-shrink:0; }
.marquee-item {
    display:flex; align-items:center;
    font-size:.7rem; font-weight:700; letter-spacing:.22em;
    text-transform:uppercase; color:rgba(247,242,233,.38);
    white-space:nowrap;
}
.marquee-dot {
    width:3px; height:3px; border-radius:50%;
    background:var(--gold); margin:0 2.2rem; flex-shrink:0;
    opacity:.6;
}

/* ══════════════════════════════════════
   06. HOW IT WORKS
══════════════════════════════════════ */
.hiw {
    background:var(--espresso);
    padding:6rem 5rem;
}
.hiw-header .label-xs { color:var(--gold); }
.hiw-header h2 { color:var(--ivory); }
.hiw-grid { border-top:1px solid rgba(184,148,82,.2); border-left:1px solid rgba(184,148,82,.2); }
.hiw-step { border-right:1px solid rgba(184,148,82,.2); border-bottom:m:1px solid rgba(184,148,82,.2); background:transparent; }
.hiw-step:hover { background:rgba(255,255,255,.04); }
.hiw-step-num { color:rgba(247,242,233,.06) !important; }
.hiw-step-icon { background:rgba(184,148,82,.15) !important; color:var(--gold) !important; }
.hiw-step-label { color:var(--gold) !important; display:block !important; margin-bottom:.4rem !important; }
.hiw-step-title { color:var(--ivory) !important; font-size:1rem !important; font-weight:800 !important; }
.hiw-step-desc { color:rgba(247,242,233,.5) !important; font-size:.84rem !important; line-height:1.6 !important; margin-top:.5rem !important; display:block !important; }
.hiw-inner { max-width:1300px; margin:0 auto; }
.hiw-header { margin-bottom:4rem; }
.hiw-header .label-xs { margin-bottom:.9rem; display:block; }
.hiw-header h2 {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:clamp(1.8rem,3vw,2.6rem);
    color:var(--ivory); line-height:1.06;
    white-space:nowrap;
}
.hiw-grid {
    display:grid; grid-template-columns:repeat(4,1fr);
    border-top:1px solid rgba(184,148,82,.2);
    border-left:1px solid rgba(184,148,82,.2);
}
.hiw-step {
    padding:2.4rem 2rem;
    border-right:1px solid rgba(184,148,82,.2);
    border-bottom:1px solid rgba(184,148,82,.2);
    display:flex; flex-direction:column; gap:1.2rem;
    transition:background .2s;
    position:relative;
}
.hiw-step:hover { background:rgba(255,255,255,.04); }
.hiw-step-top {
    display:flex; justify-content:space-between; align-items:flex-start;
}
.hiw-step-num {
    font-family:'DM Serif Display',serif;
    font-size:3.5rem; line-height:1;
    color:rgba(36,21,15,.08); font-style:italic;
    position:absolute; top:1.2rem; right:1.5rem;
    pointer-events:none;
}
.hiw-step-icon {
    width:44px; height:44px;
    background:var(--espresso);
    display:flex; align-items:center; justify-content:center;
    color:var(--gold);
    flex-shrink:0;
}
.hiw-step-body {}
.hiw-step-label { font-size:.6rem; font-weight:800; letter-spacing:.2em; text-transform:uppercase; color:var(--gold); margin-bottom:.4rem; }
.hiw-step-title { font-size:1rem; font-weight:800; color:var(--espresso); line-height:1.2; }
.hiw-step-desc { font-size:.84rem; color:var(--text-muted); line-height:1.6; margin-top:.5rem; }

@media(max-width:980px){
    .hiw { padding:4rem 1.5rem; }
    .hiw-grid { grid-template-columns:1fr 1fr; }
    .hiw-header h2 { white-space:normal; }
}

/* ══════════════════════════════════════
   07. WHY BAKESPHERE
══════════════════════════════════════ */
.why {
    background:var(--ivory);
    padding:6rem 5rem;
    position:relative; overflow:hidden;
}
.why-left .label-gold { color:var(--caramel) !important; display:block !important; margin-bottom:1rem !important; }
.why-left h2 { color:var(--espresso) !important; font-size:clamp(2rem,3.5vw,3.2rem) !important; line-height:1.06 !important; }
.why-left p { color:var(--text-muted) !important; margin-top:1rem !important; line-height:1.7 !important; font-size:.95rem !important; }
.why-row { border-top:1px solid var(--border) !important; display:grid !important; grid-template-columns:50px 1fr !important; gap:1.6rem !important; padding:2rem 0 !important; align-items:start !important; }
.why-row:first-child { border-top:none !important; padding-top:0 !important; }
.why-icon-box { width:50px !important; height:50px !important; border:1px solid var(--border) !important; display:flex !important; align-items:center !important; justify-content:center !important; color:var(--caramel) !important; flex-shrink:0 !important; }
.why-title { font-size:.95rem !important; font-weight:800 !important; color:var(--espresso) !important; }
.why-desc { font-size:.84rem !important; color:var(--text-muted) !important; line-height:1.65 !important; margin-top:.4rem !important; display:block !important; }
.why::after {
    content:''; position:absolute;
    width:500px; height:500px; border-radius:50%;
    border:1px solid rgba(184,148,82,.1);
    right:-180px; bottom:-200px;
    pointer-events:none;
}
.why-inner {
    max-width:1300px; margin:0 auto;
    display:grid; grid-template-columns:0.9fr 1.1fr; gap:6rem; align-items:start;
}
.why-left {}
.why-left .label-gold { display:block; margin-bottom:1rem; }
.why-left h2 {
    font-family:'DM Serif Display',serif;
    font-size:clamp(2rem,3.5vw,3.2rem);
    color:var(--ivory); line-height:1.06; letter-spacing:-.02em;
}
.why-left p {
    color:rgba(247,242,233,.5); margin-top:1rem; line-height:1.7;
    font-size:.95rem; max-width:38ch;
}
.why-right { display:flex; flex-direction:column; }
.why-row {
    display:grid; grid-template-columns:50px 1fr; gap:1.6rem;
    padding:2rem 0;
    border-top:1px solid rgba(184,148,82,.15);
    align-items:start;
}
.why-row:first-child { border-top:none; padding-top:0; }
.why-icon-box {
    width:50px; height:50px;
    border:1px solid rgba(184,148,82,.3);
    display:flex; align-items:center; justify-content:center;
    color:var(--gold); flex-shrink:0;
}
.why-title { font-size:.95rem; font-weight:800; color:var(--ivory); letter-spacing:.01em; }
.why-desc { font-size:.84rem; color:rgba(247,242,233,.5); line-height:1.65; margin-top:.4rem; }

@media(max-width:980px){
    .why { padding:4rem 1.5rem; }
    .why-inner { grid-template-columns:1fr; gap:3rem; }
}

/* ══════════════════════════════════════
   08. SAVED CAKES
══════════════════════════════════════ */
.saved {
    background:var(--choco);
    padding:6rem 5rem;
    border-top:none;
}
.saved-header h2 { color:var(--ivory); }
.saved-header .label-xs { color:var(--gold); }
.saved-grid { border:1px solid rgba(184,148,82,.2); }
.saved-tile { background:rgba(255,255,255,.04); border-right:1px solid rgba(184,148,82,.15); }
.saved-tile:hover { background:rgba(255,255,255,.08); }
.saved-tile-body { border-top:1px solid rgba(184,148,82,.15); }
.saved-tile-name { color:var(--ivory); }
.saved-tile-price { color:var(--gold); }
.saved-inner { max-width:1300px; margin:0 auto; }
.saved-header {
    display:flex; justify-content:space-between; align-items:flex-end;
    margin-bottom:3rem; flex-wrap:wrap; gap:1.5rem;
}
.saved-header h2 {
    font-family:'DM Serif Display',serif;
    font-size:clamp(1.8rem,3vw,2.8rem);
    color:var(--espresso); line-height:1.06;
}
.saved-grid {
    display:flex; gap:0; overflow-x:auto;
    scroll-snap-type:x mandatory;
    scrollbar-width:thin; scrollbar-color:var(--beige) transparent;
    border:1px solid var(--border);
}
.saved-grid::-webkit-scrollbar { height:4px; }
.saved-grid::-webkit-scrollbar-thumb { background:var(--beige); }
.saved-tile {
    flex:0 0 280px; scroll-snap-align:start;
    border-right:1px solid var(--border);
    display:flex; flex-direction:column;
    overflow:hidden;
    transition:background .2s;
    background:var(--ivory);
}
.saved-tile:last-child { border-right:none; }
.saved-tile:hover { background:var(--cream); }
.saved-tile-img {
    width:100%; aspect-ratio:1/1;
    object-fit:cover; display:block;
    transition:transform .5s cubic-bezier(.22,.68,0,1.1);
    filter:brightness(.95) saturate(.9);
}
.saved-tile:hover .saved-tile-img { transform:scale(1.04); }
.saved-tile-body {
    padding:1.2rem 1.4rem 1.4rem;
    border-top:1px solid var(--border);
    flex:1; display:flex; flex-direction:column; gap:.3rem;
}
.saved-tile-name { font-size:.88rem; font-weight:800; color:var(--espresso); }
.saved-tile-price { font-size:.78rem; font-weight:700; color:var(--caramel); letter-spacing:.02em; }

@media(max-width:860px){
    .saved { padding:4rem 1.5rem; }
}

/* ══════════════════════════════════════
   09. FAQ
══════════════════════════════════════ */
.faq-section {
    background:var(--ivory);
    padding:6rem 5rem;
    border-top:1px solid var(--border);
}
.faq-inner {
    max-width:1300px; margin:0 auto;
    display:grid; grid-template-columns:0.85fr 1.15fr; gap:6rem; align-items:start;
}
.faq-left .label-xs { display:block; margin-bottom:1rem; }
.faq-left h2 {
    font-family:'DM Serif Display',serif;
    font-size:clamp(1.8rem,3vw,2.8rem);
    color:var(--espresso); line-height:1.1;
}
.faq-left p { color:var(--text-muted); margin-top:1rem; line-height:1.7; font-size:.92rem; max-width:34ch; }
.faq-list {}
.faq-item {
    border-top:1px solid var(--border);
    padding:1.4rem 0;
}
.faq-item:first-child { border-top:none; padding-top:0; }
.faq-item summary {
    display:flex; justify-content:space-between; align-items:center; gap:1.5rem;
    cursor:pointer; list-style:none;
    font-size:.92rem; font-weight:700; color:var(--espresso);
}
.faq-item summary::-webkit-details-marker { display:none; }
.faq-toggle {
    width:24px; height:24px; border:1px solid var(--border);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; transition:all .2s;
    color:var(--taupe); font-size:1rem; line-height:1;
}
.faq-item[open] .faq-toggle { border-color:var(--gold); color:var(--gold); transform:rotate(45deg); background:transparent; }
.faq-item p { margin-top:.9rem; color:var(--text-muted); font-size:.88rem; line-height:1.7; max-width:58ch; }

@media(max-width:980px){
    .faq-section { padding:4rem 1.5rem; }
    .faq-inner { grid-template-columns:1fr; gap:2.5rem; }
}

/* ══════════════════════════════════════
   10. FINAL CTA
══════════════════════════════════════ */
.cta-final {
    background:var(--espresso);
    padding:7rem 5rem;
    position:relative; overflow:hidden;
}
.cta-final::before {
    content:''; position:absolute; inset:0; pointer-events:none;
    background:
        radial-gradient(ellipse 60% 80% at 0% 100%, rgba(84,37,44,.5), transparent 55%),
        radial-gradient(ellipse 50% 60% at 100% 0%,  rgba(184,148,82,.1), transparent 50%);
}
.cta-final-inner {
    max-width:1300px; margin:0 auto; position:relative; z-index:1;
    display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center;
}
.cta-final-copy .label-gold { display:block; margin-bottom:1.2rem; }
.cta-final-copy h2 {
    font-family:'DM Serif Display',serif;
    font-size:clamp(2.2rem,4vw,4rem);
    color:var(--ivory); line-height:1.04; letter-spacing:-.02em;
}
.cta-final-copy h2 em { font-style:italic; color:var(--gold); }
.cta-final-copy p { color:rgba(247,242,233,.5); margin-top:1rem; line-height:1.7; max-width:44ch; font-size:.95rem; }
.cta-final-actions {
    display:flex; flex-direction:column; align-items:flex-end; gap:2rem;
}
.cta-final-tagline {
    font-family:'DM Serif Display',serif;
    font-size:clamp(1.5rem,3vw,2.4rem);
    color:rgba(247,242,233,.18); font-style:italic;
    text-align:right; line-height:1.2;
}
.cta-final-btn-wrap { display:flex; gap:1rem; flex-wrap:wrap; justify-content:flex-end; }

@media(max-width:860px){
    .cta-final { padding:5rem 1.5rem; }
    .cta-final-inner { grid-template-columns:1fr; gap:2.5rem; }
    .cta-final-actions { align-items:flex-start; }
    .cta-final-tagline { text-align:left; }
    .cta-final-btn-wrap { justify-content:flex-start; }
}
</style>
@endpush
@section('content')
<div class="ds" id="ds-root">

{{-- ══════════════════════════════════════
     01. HERO
══════════════════════════════════════ --}}
<section class="hero-atelier">
    <div class="hero-left ds-reveal">
        <div class="hero-eyebrow">
            <div class="hero-eyebrow-line"></div>
            <span class="hero-eyebrow-text">Welcome back{{ isset($customer) ? ', ' . $customer->first_name : '' }}</span>
        </div>

        <h1 class="hero-heading">
            Design the cake.<br><em>Make it yours.</em>
        </h1>

        <p class="hero-lede">
            Build a cake exactly the way you picture it, then let real bakers bid to bring it to life. See it, customize it, get it — all in one place.
        </p>

        <div class="hero-actions">
            <a href="{{ route('customer.cake-builder.index') }}" class="btn-gold">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Customize Your Cake
            </a>
            <a href="{{ route('customer.cake-builder.index') }}" class="btn-atelier-outline" style="color:var(--ivory);border-color:rgba(247,242,233,.3);">
                Browse Gallery
            </a>
        </div>

        <ul class="hero-perks ds-reveal d1">
            <li>3D cake preview before you order</li>
            <li>Real offers from certified bakers</li>
            <li>Full order tracking from start to delivery</li>
        </ul>
    </div>

    <div class="hero-right">
        <img src="{{ asset('models/pic1.jpg') }}" alt="A finished custom celebration cake from BakeSphere" class="hero-img-main" loading="eager">
        <div class="hero-img-overlay"></div>

        <div class="hero-float-card ds-reveal d2">
            <div class="hero-float-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--espresso)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l1.8 5.6H19l-4.6 3.5 1.8 5.6L12 13.2 7.8 16.7l1.8-5.6L5 7.6h5.2z"/></svg>
            </div>
            <div>
                <div class="hero-float-label">Custom Cake Builder</div>
                <div class="hero-float-value">3D Preview Included</div>
            </div>
        </div>

        <div class="hero-pic2-badge ds-reveal d2">
            <img src="{{ asset('models/pic2.png') }}" alt="Custom cake detail">
        </div>
        <div class="hero-pic2-frame"></div>
        <div class="hero-badge-atelier ds-reveal d3">
            <div class="badge-main">See it.<br>Customize.</div>
            <div class="badge-sub">Get it.</div>
        </div>

        <div class="hero-line-deco"></div>
    </div>
    <div class="hero-atelier-number" aria-hidden="true">BS</div>
</section>


{{-- SECTION DIVIDER --}}
<div style="height:1px;background:linear-gradient(90deg,transparent,rgba(184,148,82,.35),transparent);"></div>

{{-- ══════════════════════════════════════
     04. DESIGN → REALITY
══════════════════════════════════════ --}}
<section class="d2r">
    <div class="d2r-inner">
        <div class="d2r-header ds-reveal">
            <span class="label-gold">From your screen to your table</span>
            <h2>Your design becomes<br><em>a real cake.</em></h2>
            <p>Design your cake in the BakeSphere builder and see exactly how your digital creation becomes a celebration-worthy reality, baked by a skilled local baker.</p>
        </div>
           <div class="d2r-stage ds-reveal d1">
            <div class="d2r-panel">
                <img src="{{ asset('models/pic3.png') }}" alt="3D cake design from the BakeSphere builder" class="d2r-panel-img">
                <div class="d2r-panel-caption">
                    <span class="d2r-panel-tag design-tag">3D Builder Preview</span>
                    <div class="d2r-panel-name">Your digital design</div>
                </div>
            </div>
            <div class="d2r-divider">
                <div class="d2r-divider-line"></div>
                <div class="d2r-arrow">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                </div>
                <div class="d2r-divider-line"></div>
            </div>
            <div class="d2r-panel">
                <img src="{{ asset('models/pic4.png') }}" alt="The real finished cake baked by a BakeSphere baker" class="d2r-panel-img">
                <div class="d2r-panel-caption">
                    <span class="d2r-panel-tag real-tag">Finished Cake</span>
                    <div class="d2r-panel-name">Baked by your chosen baker</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     05. FLAVOR MARQUEE
══════════════════════════════════════ --}}
@php $flavors = ['Vanilla','Chocolate','Red Velvet','Strawberry','Ube','Mocha','Blueberry','Mango','Biscoff','Carrot','Banana']; @endphp
<div class="marquee-band" aria-hidden="true">
    <div class="marquee-track">
        @for($i=0;$i<3;$i++)
        <div class="marquee-group">
            @foreach($flavors as $f)
            <span class="marquee-item">{{ strtoupper($f) }}</span>
            <span class="marquee-dot"></span>
            @endforeach
        </div>
        @endfor
    </div>
</div>

{{-- ══════════════════════════════════════
     06. HOW IT WORKS
══════════════════════════════════════ --}}
<section class="hiw">
    <div class="hiw-inner">
        <div class="hiw-header ds-reveal">
            <span class="label-xs">The Process</span>
            <h2>Your idea becomes a cake in four steps.</h2>
        </div>
        <div class="hiw-grid ds-reveal d1">
            <div class="hiw-step">
                <div class="hiw-step-num" aria-hidden="true">01</div>
                <div class="hiw-step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                <div class="hiw-step-body">
                    <div class="hiw-step-label">Step 01</div>
                    <div class="hiw-step-title">Design</div>
                    <div class="hiw-step-desc">Customize your cake's shape, flavor, frosting, and decorations in the 3D builder.</div>
                </div>
            </div>
            <div class="hiw-step">
                <div class="hiw-step-num" aria-hidden="true">02</div>
                <div class="hiw-step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><path d="M7 7h.01"/></svg>
                </div>
                <div class="hiw-step-body">
                    <div class="hiw-step-label">Step 02</div>
                    <div class="hiw-step-title">Set Your Budget</div>
                    <div class="hiw-step-desc">Tell bakers what you're looking for and the price range you have in mind.</div>
                </div>
            </div>
            <div class="hiw-step">
                <div class="hiw-step-num" aria-hidden="true">03</div>
                <div class="hiw-step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="hiw-step-body">
                    <div class="hiw-step-label">Step 03</div>
                    <div class="hiw-step-title">Receive Offers</div>
                    <div class="hiw-step-desc">Bakers review your request and send you competitive offers to make it.</div>
                </div>
            </div>
            <div class="hiw-step">
                <div class="hiw-step-num" aria-hidden="true">04</div>
                <div class="hiw-step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div class="hiw-step-body">
                    <div class="hiw-step-label">Step 04</div>
                    <div class="hiw-step-title">Order &amp; Enjoy</div>
                    <div class="hiw-step-desc">Choose your baker, track your order, and enjoy your fully custom cake.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     07. WHY BAKESPHERE
══════════════════════════════════════ --}}
<section class="why">
    <div class="why-inner">
        <div class="why-left ds-reveal">
            <span class="label-gold">Why BakeSphere</span>
            <h2>You design it.<br>Bakers compete<br>to make it.</h2>
            <p>Order a cake exactly the way you want it, at a price you get to choose — then watch it come to life.</p>
        </div>
        <div class="why-right ds-reveal d1">
            <div class="why-row">
                <div class="why-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                </div>
                <div>
                    <div class="why-title">See it before you order</div>
                    <p class="why-desc">The 3D builder renders your cake with the exact shape, flavor, and decorations you chose. No surprises — only the cake you designed.</p>
                </div>
            </div>
            <div class="why-row">
                <div class="why-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><path d="M7 7h.01"/></svg>
                </div>
                <div>
                    <div class="why-title">Compare offers from real bakers</div>
                    <p class="why-desc">Set your budget and let bakers send you offers. Choose the one that fits your cake vision and your price — you're always in control.</p>
                </div>
            </div>
            <div class="why-row">
                <div class="why-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <div class="why-title">Follow your order end to end</div>
                    <p class="why-desc">Track every stage — from baker confirmation through preparation and all the way to delivery — from your personal dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     08. SAVED CAKES
══════════════════════════════════════ --}}
@if(!empty($savedCakes))
<section class="saved">
    <div class="saved-inner">
        <div class="saved-header ds-reveal">
            <div>
                <span class="label-xs">Saved for Later</span>
                <h2 class="serif" style="margin-top:.6rem;">Your Cake Collection</h2>
            </div>
            <a href="{{ route('customer.cake-builder.index') }}" class="btn-atelier-outline" style="font-size:.78rem;padding:.65rem 1.4rem;">Browse More</a>
        </div>
        <div class="saved-grid ds-reveal d1">
            @foreach($savedCakes as $cake)
            <div class="saved-tile">
                <img src="{{ $cake->image_url ?? asset('images/cakes/placeholder-cake.jpg') }}" alt="{{ $cake->name }}" class="saved-tile-img" loading="lazy">
                <div class="saved-tile-body">
                    <div class="saved-tile-name">{{ $cake->name }}</div>
                    <div class="saved-tile-price">From ₱{{ number_format($cake->starting_price ?? 0) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


</div>{{-- /ds --}}
@endsection
@push('scripts')
<script>
(function(){
    var root = document.getElementById('ds-root');
    if(!root) return;
    if(window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    root.classList.add('js-anim');
    var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){
                e.target.style.animationPlayState = 'running';
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.ds-reveal').forEach(function(el){ io.observe(el); });
})();
</script>
@endpush