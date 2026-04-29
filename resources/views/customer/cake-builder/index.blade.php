<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Builder — BakeSphere</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
 :root {
    /* ── Dashboard-matching palette ── */
    --brown-deep:    #3B1F0E;
    --brown-mid:     #6B3A1F;
    --caramel:       #C8894A;
    --caramel-light: #E8B07A;
    --warm-white:    #FDFAF6;
    --cream:         #F5EDE0;

    /* ── Mapped to builder vars ── */
    --bg:        #F5EDE0;
    --surface:   #FDFAF6;
    --border:    #E8D8C4;
    --border-dk: #D4C0A8;
    --text:      #3B1F0E;
    --text-muted:#8A7060;
    --accent:    #C8894A;
    --accent-dk: #A06830;
    --accent-lt: #FEF3E8;
    --gold:      #C49A3C;
    --gold-lt:   #FBF5E6;
    --teal:      #1F7A6C;
    --teal-soft: #E4F2EF;

    --panel-w:   360px;
    --nav-h:     60px;
    --radius:    16px;
    --shadow-sm: 0 1px 4px rgba(59,31,14,0.08);
    --shadow-md: 0 4px 20px rgba(59,31,14,0.12);
    --shadow-lg: 0 8px 40px rgba(59,31,14,0.16);
    --transition: 0.18s cubic-bezier(0.4,0,0.2,1);
--font-display: 'Plus Jakarta Sans', system-ui, sans-serif;
    --font-body:    'Plus Jakarta Sans', system-ui, sans-serif;
    --font-mono:    'Plus Jakarta Sans', system-ui, sans-serif;
}
html, body {
    margin: 0;
    padding: 0;
}
body {
    font-family: var(--font-display);
    background: var(--cream);
    color: var(--text);
    height: 100vh; overflow: hidden;
    display: flex; flex-direction: column;
    margin: 0;
    padding: 0;
}
        #spotBrightnessSlider::-webkit-slider-thumb { -webkit-appearance:none; width:14px; height:14px; border-radius:50%; background:var(--gold); border:2px solid #fff; box-shadow:0 1px 4px rgba(60,30,5,.4); cursor:pointer; }

nav {
    height: var(--nav-h);
    background: linear-gradient(135deg, #3B1F0E 0%, #6B3A1F 100%);
    border-bottom: 1px solid rgba(255,255,255,0.08);
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    padding: 0 15px;
    flex-shrink: 0;
    box-shadow: 0 2px 20px rgba(59,31,14,0.38);
    z-index: 100;
}
        .nav-left { display:flex; align-items:center; gap:16px; }
       .btn-back {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px;
    border: 1.5px solid rgba(255,255,255,0.20);
    border-radius: 10px;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.75);
    font-family: var(--font-body); font-size: .82rem; font-weight: 500;
    cursor: pointer; text-decoration: none;
    transition: all var(--transition);
}
.btn-back:hover {
    border-color: rgba(255,255,255,0.45);
    color: #fff;
    background: rgba(255,255,255,0.16);
}
.nav-divider { width: 1px; height: 22px; background: rgba(255,255,255,0.15); }
.nav-brand {
    font-family: var(--font-display);
    font-size: 1.35rem; font-weight: 700;
    color: #fff;
    text-decoration: none; letter-spacing: -0.01em;
}
.nav-brand em { color: var(--caramel-light); font-style: italic; font-weight: 400; }
 
.nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: flex-end;  /* push buttons to the right */
}

.nav-step {
    display: flex; align-items: center; gap: 5px;
    font-family: var(--font-body); font-size: .78rem; font-weight: 500;
    color: rgba(255,255,255,0.45);
}
.nav-step.active { color: var(--caramel-light); }

.step-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: rgba(255,255,255,0.25);
    flex-shrink: 0;
}
.nav-step.active .step-dot { background: var(--caramel-light); }

.step-line { width: 28px; height: 1px; background: rgba(255,255,255,0.15); flex-shrink: 0; }
.btn-save-draft {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px;
    border: 1.5px solid rgba(255,255,255,0.22);
    border-radius: 10px;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.75);
    font-family: var(--font-body); font-size: .82rem; font-weight: 500;
    cursor: pointer;
    transition: all var(--transition);
}
.btn-save-draft:hover { border-color: var(--caramel-light); color: var(--caramel-light); background: rgba(200,137,74,0.15); }
.btn-save-draft.saved { border-color: #5B9B6A; color: #8DD4A0; background: rgba(91,155,106,0.15); }
 
.btn-proceed {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 20px;
    background: var(--caramel);
    color: #fff;
    border: none; border-radius: 10px;
    font-family: var(--font-body); font-size: .88rem; font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    box-shadow: 0 2px 12px rgba(200,137,74,0.40);
    letter-spacing: 0.01em;
}
.btn-proceed:hover { background: var(--caramel-light); transform: translateY(-1px); }
.nav-center {
    /* remove: position:absolute; left:50%; transform:translateX(-50%); */
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: center;
}   

        /* LAYOUT */
        .builder { display:grid; grid-template-columns:var(--panel-w) 1fr var(--panel-w); flex:1; min-height:0; }

        /* PANELS */
  .panel {
    background: var(--warm-white);
    overflow-y: auto; overflow-x: hidden;
    display: flex; flex-direction: column;
    scrollbar-width: thin;
    scrollbar-color: var(--border-dk) transparent;
}
.panel:first-child { border-right: 1px solid var(--border); }
.panel:last-child  { border-left: 1px solid var(--border); background: var(--cream); }
 
.panel-header {
    padding: 18px 20px 14px;
    position: sticky; top: 0;
    background: var(--warm-white);
    z-index: 10;
    border-bottom: 1px solid var(--border);
}
.panel-title {
    font-family: var(--font-display);
    font-size: 1.15rem; font-weight: 700;
    color: var(--brown-deep);
    display: flex; align-items: center; gap: 8px;
    letter-spacing: -0.01em;
}
.panel-subtitle { font-size: .73rem; color: var(--text-muted); margin-top: 3px; font-family: var(--font-body); }
        .panel::-webkit-scrollbar { width:4px; }
        .panel::-webkit-scrollbar-thumb { background:var(--border-dk); border-radius:4px; }
     
        .panel-body { padding:14px 18px 24px; display:flex; flex-direction:column; gap:18px; }

   .section-label {
    font-size: .66rem;
    text-transform: uppercase; letter-spacing: .16em;
    font-weight: 700; color: var(--brown-mid);
    margin-bottom: 8px;
    display: flex; align-items: center; gap: 8px;
    font-family: var(--font-display);
}
.section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }
.section-req {
    font-size: .6rem; font-weight: 700;
    color: var(--caramel); background: var(--accent-lt);
    border: 1px solid rgba(200,137,74,.25);
    padding: .1rem .4rem; border-radius: 4px;
    margin-left: auto; margin-right: 0;
}
 

        /* FROSTING GUIDE BANNER */
        .frosting-guide { background:linear-gradient(135deg,#F0F7FF 0%,#E8F2FF 100%); border:1.5px solid rgba(48,100,200,.15); border-radius:12px; padding:12px 14px; margin-bottom:10px; }
.frosting-guide-title { font-size:.74rem; font-weight:700; color:#1A3A80; font-family:var(--font-display); display:flex; align-items:center; gap:6px; margin-bottom:10px; }        .frosting-guide-title-icon { font-size:1rem; }
        .frosting-guide-steps { display:flex; flex-direction:column; gap:7px; }
        .frosting-step { display:flex; align-items:flex-start; gap:8px; }
        .frosting-step-num { width:18px; height:18px; border-radius:50%; background:#3064C8; color:#fff; font-size:.6rem; font-weight:700; font-family:var(--font-body); display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
        .frosting-step-body { flex:1; }
 .frosting-step-label { font-size:.70rem; font-weight:700; color:#1A3A80; font-family:var(--font-display); display:block; margin-bottom:1px; }
        .frosting-step-desc { font-size:.65rem; color:#2A50A0; font-family:var(--font-display); line-height:1.5; }
        .frosting-step-desc strong { font-weight:700; }
        .frosting-guide-note { margin-top:9px; padding:7px 10px; background:rgba(196,154,60,.12); border:1px solid rgba(196,154,60,.25); border-radius:8px; font-size:.65rem; color:#6B4C08; font-family:var(--font-body); line-height:1.5; display:flex; align-items:flex-start; gap:6px; }
        .frosting-guide-note-icon { font-size:.85rem; flex-shrink:0; margin-top:1px; }

        /* FROSTING SECTION DIVIDERS */
.frosting-section-label {
    font-size: .62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .14em;
    color: var(--brown-mid);
    padding: .3rem 0 .2rem;
    display: flex; align-items: center; gap: 6px;
    font-family: var(--font-display);
    margin-top: 8px;
}
.frosting-section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }    

        /* SHAPE GRID */
        .shape-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:7px; }
.shape-opt {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 10px 6px;
    cursor: pointer;
    transition: all var(--transition);
    background: var(--warm-white);
    text-align: center;
    box-shadow: var(--shadow-sm);
}
.shape-opt:hover {
    border-color: var(--caramel);
    background: var(--accent-lt);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}
.shape-opt.active {
    border-color: var(--caramel);
    background: var(--accent-lt);
    box-shadow: 0 0 0 3px rgba(200,137,74,0.15);
}
.shape-opt .sh-name { font-size: .68rem; font-weight: 700; color: var(--text); display: block; font-family: var(--font-display); letter-spacing: 0.01em; }
.shape-opt.active .sh-name { color: var(--caramel); }

        /* SIZE SLIDER */
  .size-slider-wrap {
    display: none;
    margin-top: 10px;
    background: var(--cream);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px 13px;
    box-shadow: var(--shadow-sm);
}
.size-slider-wrap.visible { display: block; }
        .size-slider-wrap.visible { display:block; }
        .size-slider-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
   .size-slider-label { font-size:.72rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:.08em; font-family:var(--font-display); }
        .size-slider-val { font-family: var(--font-display); font-size:1.1rem; font-weight:700; color:var(--accent); }
        input[type=range].size-range { -webkit-appearance:none; appearance:none; width:100%; height:4px; background:var(--border); border-radius:2px; outline:none; cursor:pointer; }
        input[type=range].size-range::-webkit-slider-thumb { -webkit-appearance:none; width:18px; height:18px; border-radius:50%; background:var(--accent); border:2.5px solid #fff; box-shadow:0 1px 6px rgba(184,92,56,.35); cursor:pointer; transition:transform var(--transition); }
        input[type=range].size-range::-webkit-slider-thumb:hover { transform:scale(1.15); }
        .size-ticks { display:flex; justify-content:space-between; margin-top:5px; }
        .size-tick { font-size:.61rem; color:var(--text-muted); font-family: var(--font-display); }

        /* NUMBER PICKER */
    .number-picker-wrap {
    display: none;
    margin-top: 10px;
    background: var(--cream);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px 13px;
    box-shadow: var(--shadow-sm);
}
.number-picker-wrap.visible { display: block; }
 
    .number-picker-label { font-size:.72rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:.08em; font-family:var(--font-display); margin-bottom:10px; }
        .digit-mode-toggle { display:flex; gap:0; border:1.5px solid var(--border-dk); border-radius:8px; overflow:hidden; margin-bottom:12px; }
        .digit-mode-btn { flex:1; padding:6px 10px; font-size:.76rem; font-weight:600; font-family:var(--font-display); color:var(--text-muted); background:var(--surface); border:none; cursor:pointer; transition:all var(--transition); text-align:center; }
        .digit-mode-btn + .digit-mode-btn { border-left:1.5px solid var(--border-dk); }
        .digit-mode-btn.active { background:var(--accent); color:#fff; }
        .digit-mode-btn:hover:not(.active) { background:var(--accent-lt); color:var(--accent); }
        .number-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:6px; }
        .num-opt { border:1.5px solid var(--border); border-radius:8px; padding:7px 4px; cursor:pointer; text-align:center; font-family:var(--font-display); font-size:1.1rem; font-weight:700; color:var(--text-muted); background:var(--surface); transition:all var(--transition); }
        .num-opt:hover { border-color:var(--accent); color:var(--accent); background:var(--accent-lt); }
        .num-opt.active { border-color:var(--accent); background:var(--accent); color:#fff; }
        .dual-digit-wrap { display:none; flex-direction:column; gap:10px; }
        .dual-digit-wrap.visible { display:flex; }
        .dual-digit-preview { text-align:center; font-family:var(--font-display); font-size:2.4rem; font-weight:700; color:var(--accent); letter-spacing:.04em; line-height:1; padding:6px 0 2px; }
        .dual-digit-preview span { font-size:.65rem; font-family:var(--font-body); font-weight:500; color:var(--text-muted); display:block; margin-top:2px; text-transform:uppercase; letter-spacing:.1em; }
        .dual-col-label { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--text-muted); margin-bottom:5px; font-family:var(--font-body); }
        .dual-cols { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .num-grid-sm { display:grid; grid-template-columns:repeat(3,1fr); gap:5px; }
        .num-opt-sm { border:1.5px solid var(--border); border-radius:7px; padding:5px 2px; cursor:pointer; text-align:center; font-family:var(--font-display); font-size:.95rem; font-weight:700; color:var(--text-muted); background:var(--surface); transition:all var(--transition); }
        .num-opt-sm:hover { border-color:var(--accent); color:var(--accent); background:var(--accent-lt); }
        .num-opt-sm.active { border-color:var(--accent); background:var(--accent); color:#fff; }

        /* OPTION PILLS */
        .opts { display:flex; flex-wrap:wrap; gap:6px; }
.opt {
    padding: 7px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: .79rem; font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    transition: all var(--transition);
    background: var(--warm-white);
    position: relative; overflow: hidden;
    font-family: var(--font-display);
    box-shadow: var(--shadow-sm);
}
.opt:hover { border-color: var(--caramel); color: var(--caramel); transform: translateY(-1px); }
.opt.active { border-color: var(--caramel); color: #fff; background: var(--caramel); box-shadow: 0 3px 10px rgba(200,137,74,0.35); }
.opt.active span { color: #fff; }
        .opt.active span { color:#fff; }
        .flavor-dot { display:inline-block; width:8px; height:8px; border-radius:50%; flex-shrink:0; }

        /* ADDON GRID */
        .addon-grid { display:grid; grid-template-columns:1fr 1fr; gap:6px; min-width:0; width:100%; }
        .a-icon { font-size:1rem; flex-shrink:0; line-height:1; }
        .a-info { flex:1; min-width:0; overflow:hidden; }
     .a-name { font-size:.73rem; font-weight:700; color:var(--text); display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-family:var(--font-display); }
        .addon-opt.active .a-name { color:var(--accent); }
        .a-price { font-size:.63rem; color:var(--text-muted); display:block; margin-top:1px; font-family:var(--font-display); white-space:nowrap; }
        .addon-check { width:15px; height:15px; border:1.5px solid var(--border-dk); border-radius:4px; flex-shrink:0; display:flex; align-items:center; justify-content:center; transition:all var(--transition); }
        .addon-check svg { width:8px; height:8px; opacity:0; transition:opacity var(--transition); }
        .addon-opt.active .addon-check svg { opacity:1; }
.addon-opt {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 10px 12px;
    cursor: pointer;
    transition: all var(--transition);
    background: var(--warm-white);
    display: flex; align-items: center; gap: 7px;
    min-width: 0; overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.addon-opt:hover {
    border-color: var(--caramel);
    background: var(--accent-lt);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}
.addon-opt.active {
    border-color: var(--caramel);
    background: var(--accent-lt);
    box-shadow: 0 0 0 3px rgba(200,137,74,0.12);
}
.addon-opt.active .a-name { color: var(--caramel); }
.addon-opt.active .addon-check { background: var(--caramel); border-color: var(--caramel); }
.addon-check { width: 16px; height: 16px; border: 1.5px solid var(--border-dk); border-radius: 5px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: all var(--transition); }
 
        /* DRIP FLAVOR SUB-PANEL */
        .drip-flavor-panel { display:none; margin-top:8px; background:var(--bg); border:1.5px solid rgba(31,122,108,.25); border-radius:10px; padding:10px 12px; }
        .drip-flavor-panel.visible { display:block; }
        .drip-flavor-header { font-size:.67rem; font-weight:700; color:var(--teal); text-transform:uppercase; letter-spacing:.1em; margin-bottom:8px; font-family:var(--font-body); display:flex; align-items:center; gap:6px; }
        .drip-flavor-header::after { content:''; flex:1; height:1px; background:rgba(31,122,108,.2); }
        .drip-flavors { display:flex; flex-wrap:wrap; gap:5px; }
        .drip-flavor-opt { padding:5px 10px; border:1.5px solid var(--border); border-radius:7px; font-size:.74rem; font-weight:500; color:var(--text-muted); cursor:pointer; transition:all var(--transition); background:var(--surface); display:flex; align-items:center; gap:5px; font-family:var(--font-body); }
        .drip-flavor-opt:hover { border-color:var(--teal); color:var(--teal); background:var(--teal-soft); }
        .drip-flavor-opt.active { border-color:var(--teal); background:var(--teal); color:#fff; }
        .drip-color-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; border:1px solid rgba(0,0,0,.12); }

.icing-panel { display:none; margin-top:6px; background:var(--cream); border:1px solid var(--border); border-radius:10px; padding:9px 11px; }
        .icing-panel.visible { display:block; }
        .icing-header { font-size:.67rem; font-weight:700; color:#7A5C10; text-transform:uppercase; letter-spacing:.1em; margin-bottom:9px; font-family:var(--font-body); display:flex; align-items:center; gap:6px; }
        .icing-header::after { content:''; flex:1; height:1px; background:rgba(196,154,60,.25); }
        .icing-color-grid { display:grid; grid-template-columns:repeat(6,1fr); gap:6px; margin-bottom:8px; }
        .icing-color-opt { width:100%; aspect-ratio:1; border-radius:8px; border:2.5px solid transparent; cursor:pointer; transition:all var(--transition); position:relative; }
        .icing-color-opt:hover { transform:scale(1.12); }
        .icing-color-opt.active { border-color:#2C1810; box-shadow:0 0 0 2px rgba(44,24,16,.25); transform:scale(1.08); }
        .icing-color-opt.active::after { content:'✓'; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:.6rem; font-weight:700; color:rgba(255,255,255,.95); text-shadow:0 1px 2px rgba(0,0,0,.6); }
        .icing-color-opt.light-color.active::after { color:rgba(0,0,0,.5); text-shadow:none; }
        .icing-color-label { font-size:.66rem; color:#7A5C10; font-family:var(--font-body); text-align:center; margin-top:4px; font-weight:500; }

        /* Sugar Icing active state */
        .frosting-opt[data-val="Sugar Icing"].active { border-color: var(--gold) !important; background: var(--gold-lt) !important; }
        .frosting-opt[data-val="Sugar Icing"].active .a-name { color: #7A5C10 !important; }
        .frosting-opt[data-val="Sugar Icing"].active .addon-check { background: var(--gold) !important; border-color: var(--gold) !important; }

        /* FROSTING COMBO HINT */
        .frosting-combo-hint { display:none; margin-top:8px; padding:8px 11px; background:var(--teal-soft); border:1px solid rgba(31,122,108,.22); border-radius:9px; font-size:.71rem; color:var(--teal); font-family:var(--font-body); line-height:1.5; }
        .frosting-combo-hint.visible { display:flex; align-items:flex-start; gap:7px; }
        .frosting-combo-hint-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .frosting-combo-label { font-weight:600; display:block; }
        .frosting-combo-sub { color:rgba(31,122,108,.75); font-size:.67rem; }

        /* FONDANT */
        .frosting-opt.frosting-locked { opacity:.38; pointer-events:none; filter:grayscale(.6); position:relative; }
        .frosting-opt.frosting-locked::after { content:'🚫'; position:absolute; top:5px; right:6px; font-size:.6rem; opacity:.75; pointer-events:none; }
        .frosting-opt.active[data-val="Fondant Smooth"] { border-color:var(--gold) !important; background:var(--gold-lt) !important; box-shadow:0 0 0 3px rgba(196,154,60,.15); }
        .frosting-opt.active[data-val="Fondant Smooth"] .a-name { color:#7A5C10 !important; }
        .frosting-opt.active[data-val="Fondant Smooth"] .addon-check { background:var(--gold) !important; border-color:var(--gold) !important; }
        .fondant-notice { display:none; margin-top:8px; padding:9px 12px; background:linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%); border:1.5px solid rgba(196,154,60,.35); border-radius:10px; font-size:.71rem; color:#7A5C10; font-family:var(--font-body); line-height:1.55; gap:8px; align-items:flex-start; }
        .fondant-notice.visible { display:flex; }
        .fondant-notice-icon { font-size:1rem; flex-shrink:0; margin-top:1px; }
        .fondant-notice-title { font-weight:700; display:block; margin-bottom:1px; color:#6B4C08; }
        .fondant-notice-sub { color:rgba(122,92,16,.72); font-size:.66rem; }

        /* FROSTING PRICE ROW */
        .price-row.frosting-extra-row { background:rgba(31,122,108,.04); }
        .price-row.frosting-extra-row .pr-label { color:var(--teal); }
        .price-row.frosting-extra-row .pr-val { color:var(--teal); }

        /* ── VIEWER ── */
        .viewer {
            position:relative; display:flex; align-items:center; justify-content:center; overflow:hidden;
            background:
                radial-gradient(ellipse 55% 80% at 82% 0%, rgba(255,210,120,0.72) 0%, rgba(230,170,70,0.30) 35%, transparent 65%),
                radial-gradient(ellipse 70% 60% at 48% 42%, rgba(240,200,140,0.55) 0%, transparent 65%),
                radial-gradient(ellipse 60% 40% at 8% 100%, rgba(80,45,20,0.65) 0%, transparent 55%),
                linear-gradient(168deg, #E8D5B0 0%, #D9C49A 25%, #C8AC7A 55%, #B89560 80%, #A07840 100%);
        }
        #model-container { position:absolute; inset:0; }
        #model-container canvas { width:100% !important; height:100% !important; display:block; }
        .viewer::before {
            content:''; position:absolute; bottom:0; left:0; right:0; height:38%;
            background:linear-gradient(to top, rgba(120,80,30,0.50) 0%, rgba(140,95,40,0.22) 40%, transparent 100%);
            pointer-events:none; z-index:2;
        }
        .viewer::after {
            content:''; position:absolute; inset:0;
            background:
                linear-gradient(135deg, transparent 38%, rgba(255,220,130,0.18) 50%, transparent 62%),
                radial-gradient(ellipse 30% 90% at 88% 20%, rgba(255,230,150,0.25) 0%, transparent 55%);
            pointer-events:none; z-index:2;
        }

        /* FRUIT TRAY */
        .fruit-tray { position:absolute; bottom:14px; left:50%; transform:translateX(-50%); display:none; align-items:center; gap:6px; z-index:30; background:rgba(58,32,10,0.78); backdrop-filter:blur(16px); border:1px solid rgba(210,165,90,0.32); border-radius:18px; padding:7px 14px; box-shadow:0 4px 20px rgba(60,30,8,0.45); pointer-events:all; }
        .fruit-tray.visible { display:flex; }
        .fruit-tray-label { font-size:.6rem; font-weight:700; color:rgba(220,175,100,0.78); text-transform:uppercase; letter-spacing:.1em; font-family:var(--font-body); white-space:nowrap; margin-right:2px; }
        .fruit-draggable { width:38px; height:38px; border-radius:9px; border:1.5px solid rgba(200,150,70,0.32); background:rgba(80,48,16,0.58); cursor:grab; display:flex; align-items:center; justify-content:center; font-size:1.4rem; transition:all var(--transition); user-select:none; -webkit-user-select:none; position:relative; flex-shrink:0; }
        .fruit-draggable:hover { border-color:rgba(220,175,100,0.65); background:rgba(100,62,20,0.78); transform:scale(1.1); }
        .fruit-draggable:active { cursor:grabbing; }
        .fruit-tip { position:absolute; bottom:calc(100% + 5px); left:50%; transform:translateX(-50%); background:#3C2010; color:#F0D090; font-size:.58rem; white-space:nowrap; padding:3px 7px; border-radius:5px; pointer-events:none; opacity:0; transition:opacity .15s; font-family:var(--font-body); }
        .fruit-draggable:hover .fruit-tip { opacity:1; }
        .fruit-tray-sep { width:1px; height:24px; background:rgba(200,150,70,0.24); margin:0 2px; }
        .fruit-clear-btn { padding:5px 10px; border:1.5px solid rgba(180,80,55,0.38); border-radius:8px; background:transparent; color:rgba(220,110,85,0.82); font-size:.68rem; font-weight:600; cursor:pointer; font-family:var(--font-body); transition:all var(--transition); white-space:nowrap; }
        .fruit-clear-btn:hover { border-color:rgba(220,70,50,0.65); color:#E05535; }

        /* FERRERO TRAY */
        .ferrero-tray { position:absolute; bottom:58px; left:50%; transform:translateX(-50%); display:none; align-items:center; gap:6px; z-index:31; background:rgba(38,18,6,0.88); backdrop-filter:blur(16px); border:1px solid rgba(196,154,60,0.40); border-radius:18px; padding:7px 14px; box-shadow:0 4px 20px rgba(30,12,2,0.55); pointer-events:all; }
        .ferrero-tray.visible { display:flex; }
        .ferrero-tray-label { font-size:.6rem; font-weight:700; color:rgba(196,154,60,0.90); text-transform:uppercase; letter-spacing:.1em; font-family:var(--font-body); white-space:nowrap; margin-right:2px; }
        .ferrero-draggable { width:38px; height:38px; border-radius:9px; border:1.5px solid rgba(196,154,60,0.40); background:rgba(60,30,8,0.70); cursor:grab; display:flex; align-items:center; justify-content:center; font-size:1.4rem; transition:all var(--transition); user-select:none; -webkit-user-select:none; position:relative; flex-shrink:0; }
        .ferrero-draggable:hover { border-color:rgba(196,154,60,0.80); background:rgba(80,42,10,0.88); transform:scale(1.1); }
        .ferrero-draggable:active { cursor:grabbing; }
        .ferrero-tip { position:absolute; bottom:calc(100% + 5px); left:50%; transform:translateX(-50%); background:#2A1006; color:#F0D090; font-size:.58rem; white-space:nowrap; padding:3px 7px; border-radius:5px; pointer-events:none; opacity:0; transition:opacity .15s; font-family:var(--font-body); }
        .ferrero-draggable:hover .ferrero-tip { opacity:1; }
        .ferrero-tray-sep { width:1px; height:24px; background:rgba(196,154,60,0.24); margin:0 2px; }
        .ferrero-clear-btn { padding:5px 10px; border:1.5px solid rgba(180,80,55,0.38); border-radius:8px; background:transparent; color:rgba(220,110,85,0.82); font-size:.68rem; font-weight:600; cursor:pointer; font-family:var(--font-body); transition:all var(--transition); white-space:nowrap; }
        .ferrero-clear-btn:hover { border-color:rgba(220,70,50,0.65); color:#E05535; }

        /* KITKAT TRAY — red chocolate */
        .kitkat-tray { position:absolute; bottom:58px; left:50%; transform:translateX(-50%); display:none; align-items:center; gap:6px; z-index:32; background:rgba(80,10,10,0.88); backdrop-filter:blur(16px); border:1px solid rgba(200,50,50,0.40); border-radius:18px; padding:7px 14px; box-shadow:0 4px 20px rgba(50,8,8,0.55); pointer-events:all; }
        .kitkat-tray.visible { display:flex; }
        .kitkat-tray-label { font-size:.6rem; font-weight:700; color:rgba(255,130,110,0.90); text-transform:uppercase; letter-spacing:.1em; font-family:var(--font-body); white-space:nowrap; margin-right:2px; }
        .kitkat-draggable { width:38px; height:38px; border-radius:9px; border:1.5px solid rgba(200,60,40,0.50); background:rgba(100,20,10,0.70); cursor:grab; display:flex; align-items:center; justify-content:center; font-size:1.4rem; transition:all var(--transition); user-select:none; -webkit-user-select:none; position:relative; flex-shrink:0; }
        .kitkat-draggable:hover { border-color:rgba(240,80,60,0.80); background:rgba(130,28,14,0.88); transform:scale(1.1); }
        .kitkat-draggable:active { cursor:grabbing; }
        .kitkat-tip { position:absolute; bottom:calc(100% + 5px); left:50%; transform:translateX(-50%); background:#4A0A08; color:#FFB0A0; font-size:.58rem; white-space:nowrap; padding:3px 7px; border-radius:5px; pointer-events:none; opacity:0; transition:opacity .15s; font-family:var(--font-body); }
        .kitkat-draggable:hover .kitkat-tip { opacity:1; }
        .kitkat-tray-sep { width:1px; height:24px; background:rgba(200,60,40,0.24); margin:0 2px; }
        .kitkat-clear-btn { padding:5px 10px; border:1.5px solid rgba(180,60,40,0.38); border-radius:8px; background:transparent; color:rgba(255,110,90,0.82); font-size:.68rem; font-weight:600; cursor:pointer; font-family:var(--font-body); transition:all var(--transition); white-space:nowrap; }
        .kitkat-clear-btn:hover { border-color:rgba(220,50,30,0.65); color:#E04030; }

        /* OREO TRAY — dark cream */
        .oreo-tray { position:absolute; bottom:58px; left:50%; transform:translateX(-50%); display:none; align-items:center; gap:6px; z-index:33; background:rgba(20,18,24,0.92); backdrop-filter:blur(16px); border:1px solid rgba(230,220,210,0.28); border-radius:18px; padding:7px 14px; box-shadow:0 4px 20px rgba(10,8,14,0.60); pointer-events:all; }
        .oreo-tray.visible { display:flex; }
        .oreo-tray-label { font-size:.6rem; font-weight:700; color:rgba(230,220,200,0.80); text-transform:uppercase; letter-spacing:.1em; font-family:var(--font-body); white-space:nowrap; margin-right:2px; }
        .oreo-draggable { width:38px; height:38px; border-radius:9px; border:1.5px solid rgba(200,190,175,0.28); background:rgba(40,36,48,0.70); cursor:grab; display:flex; align-items:center; justify-content:center; font-size:1.4rem; transition:all var(--transition); user-select:none; -webkit-user-select:none; position:relative; flex-shrink:0; }
        .oreo-draggable:hover { border-color:rgba(220,210,195,0.65); background:rgba(58,52,68,0.88); transform:scale(1.1); }
        .oreo-draggable:active { cursor:grabbing; }
        .oreo-tip { position:absolute; bottom:calc(100% + 5px); left:50%; transform:translateX(-50%); background:#141218; color:#E8E0D0; font-size:.58rem; white-space:nowrap; padding:3px 7px; border-radius:5px; pointer-events:none; opacity:0; transition:opacity .15s; font-family:var(--font-body); }
        .oreo-draggable:hover .oreo-tip { opacity:1; }
        .oreo-tray-sep { width:1px; height:24px; background:rgba(200,190,175,0.20); margin:0 2px; }
        .oreo-clear-btn { padding:5px 10px; border:1.5px solid rgba(180,80,55,0.38); border-radius:8px; background:transparent; color:rgba(220,110,85,0.82); font-size:.68rem; font-weight:600; cursor:pointer; font-family:var(--font-body); transition:all var(--transition); white-space:nowrap; }
        .oreo-clear-btn:hover { border-color:rgba(220,70,50,0.65); color:#E05535; }

        /* ORIENTATION PANEL — shared */
        .orient-panel { display:none; margin-top:8px; background:linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%); border:1.5px solid rgba(196,154,60,.30); border-radius:10px; padding:10px 12px; }
        .orient-panel.visible { display:block; }
        .orient-panel-header { font-size:.67rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; margin-bottom:8px; font-family:var(--font-body); display:flex; align-items:center; gap:6px; color:#7A5C10; }
        .orient-panel-header::after { content:''; flex:1; height:1px; background:rgba(196,154,60,.25); }
        .orient-toggle { display:flex; gap:0; border:1.5px solid rgba(196,154,60,.40); border-radius:8px; overflow:hidden; }
        .orient-btn { flex:1; padding:7px 6px; font-size:.74rem; font-weight:600; font-family:var(--font-body); color:#7A5C10; background:rgba(255,248,230,.6); border:none; cursor:pointer; transition:all var(--transition); text-align:center; display:flex; align-items:center; justify-content:center; gap:5px; }
        .orient-btn + .orient-btn { border-left:1.5px solid rgba(196,154,60,.30); }
        .orient-btn.active { background:var(--gold); color:#fff; }
        .orient-btn:hover:not(.active) { background:rgba(196,154,60,.18); color:#6B4C08; }
        .orient-btn-icon { font-size:.9rem; }
        .orient-hint { margin-top:7px; font-size:.63rem; color:rgba(122,92,16,.72); font-family:var(--font-body); line-height:1.5; }

        /* FRUIT CANVAS */
        #fruitCanvas { position:absolute; inset:0; z-index:25; pointer-events:none; }
        .drop-ring { position:absolute; border:2px dashed rgba(180,120,40,0.65); border-radius:50%; pointer-events:none; z-index:26; display:none; transform:translate(-50%,-50%); animation:ringPulse .7s ease-in-out infinite; }
        @keyframes ringPulse { 0%,100%{opacity:1;transform:translate(-50%,-50%) scale(1);} 50%{opacity:.4;transform:translate(-50%,-50%) scale(1.18);} }
        .ferrero-drop-ring { position:absolute; border:2px dashed rgba(196,154,60,0.80); border-radius:50%; pointer-events:none; z-index:27; display:none; transform:translate(-50%,-50%); animation:ringPulse .7s ease-in-out infinite; }
        .kitkat-drop-ring { position:absolute; border:2px dashed rgba(220,60,40,0.80); border-radius:8px; pointer-events:none; z-index:28; display:none; transform:translate(-50%,-50%); animation:ringPulse .7s ease-in-out infinite; }
        .oreo-drop-ring { position:absolute; border:2px dashed rgba(200,190,175,0.80); border-radius:50%; pointer-events:none; z-index:29; display:none; transform:translate(-50%,-50%); animation:ringPulse .7s ease-in-out infinite; }
        #dragGhost { display:none !important; }
        .viewer.fruit-drag-over { outline:3px dashed rgba(180,120,40,0.45); outline-offset:-4px; }
        .viewer.ferrero-drag-over { outline:3px dashed rgba(196,154,60,0.60); outline-offset:-4px; }
        .viewer.kitkat-drag-over { outline:3px dashed rgba(220,60,40,0.55); outline-offset:-4px; }
        .viewer.oreo-drag-over { outline:3px dashed rgba(200,190,175,0.55); outline-offset:-4px; }
        .viewer.bar-shard-drag-over { outline:3px dashed rgba(160,90,30,0.60); outline-offset:-4px; }

        /* LOADING */
        .model-loading { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px; pointer-events:none; z-index:5; transition:opacity .4s; }
        .model-loading.hidden { opacity:0; }
        .loading-spinner { width:40px; height:40px; border:3px solid rgba(160,100,30,0.20); border-top-color:rgba(180,120,40,0.85); border-radius:50%; animation:spin .8s linear infinite; }
        @keyframes spin { to { transform:rotate(360deg); } }
        .loading-text { font-size:.78rem; color:rgba(120,70,20,0.70); font-family:var(--font-body); }

        /* VIEWER OVERLAYS */
   .viewer-badge {
    position: absolute; top: 14px; left: 14px;
    background: rgba(59,31,14, 0.72);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(232,176,122,0.28);
    border-radius: 12px;
    padding: 9px 14px;
    box-shadow: 0 2px 14px rgba(59,31,14,0.38);
    z-index: 10;
}
.badge-flavor { font-size: .7rem; font-weight: 700; color: var(--caramel-light); text-transform: uppercase; letter-spacing: .08em; font-family: var(--font-display); }
.badge-shape  { font-size: .66rem; color: rgba(232,176,122,0.65); margin-top: 1px; font-family: var(--font-display); }
 
.viewer-hint {
    position: absolute; bottom: 16px; left: 50%;
    transform: translateX(-50%);
    background: rgba(59,31,14,0.65);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(232,176,122,0.22);
    border-radius: 20px;
    padding: 6px 18px;
font-size: .71rem; color: rgba(232,176,122,0.75);
    white-space: nowrap;
    box-shadow: 0 2px 12px rgba(59,31,14,0.35);
    z-index: 10;
    font-family: var(--font-display);
    transition: bottom .2s ease, opacity .3s;
}
 .viewer-controls { position:absolute; top:14px; right:14px; display:flex; flex-direction:column; gap:5px; z-index:10; }

.view-btn {
    width: 32px; height: 32px;
    background: rgba(59,31,14,0.72);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(232,176,122,0.28);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: rgba(232,176,122,0.70);
    transition: all var(--transition);
    box-shadow: 0 2px 8px rgba(59,31,14,0.35);
}
.view-btn:hover { background: rgba(107,58,31,0.88); color: var(--caramel-light); border-color: rgba(232,176,122,0.55); }
 
.model-status {
    position: absolute; bottom: 50px; left: 50%;
    transform: translateX(-50%);
    background: rgba(59,31,14,0.62);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(232,176,122,0.20);
    border-radius: 20px;
    padding: 4px 14px;
    font-size: .66rem; color: rgba(232,176,122,0.70);
    white-space: nowrap; z-index: 10;
    font-family: var(--font-body);
    transition: opacity .3s; pointer-events: none;
}
.model-status.hidden { opacity: 0; }
      
        /* RIGHT PANEL */
    .config-card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.config-card-header {
    padding: 10px 16px;
    border-bottom: 1px solid var(--border);
    font-size: .65rem;
    text-transform: uppercase; letter-spacing: .14em;
    font-weight: 700; color: var(--brown-mid);
    font-family: var(--font-display);
    display: flex; align-items: center; gap: 6px;
    background: var(--cream);
}
 
.price-block {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.price-block-header {
    padding: 10px 16px;
    border-bottom: 1px solid var(--border);
    font-size: .65rem;
    text-transform: uppercase; letter-spacing: .14em;
    font-weight: 700; color: var(--brown-mid);
    font-family: var(--font-display);
    background: var(--cream);
}
 
.price-total-block {
    background: linear-gradient(135deg, var(--brown-deep) 0%, var(--brown-mid) 100%);
    border: none;
    border-radius: 16px;
    padding: 16px 18px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 4px 16px rgba(59,31,14,0.28);
}
.pt-label { font-size: .65rem; text-transform: uppercase; letter-spacing: .14em; font-weight: 700; color: rgba(255,255,255,0.55); font-family: var(--font-display); margin-bottom: 2px; }
.pt-currency { font-size: 1.1rem; font-family: var(--font-display); font-weight: 700; color: var(--caramel-light); }
.pt-number { font-family: var(--font-display); font-size: 2rem; font-weight: 700; color: #fff; font-variant-numeric: tabular-nums; line-height: 1; }
.pt-note { font-size: .62rem; color: rgba(255,255,255,0.45); font-family: var(--font-display); margin-top: 3px; }
 
  
    .cfg-row { display:flex; justify-content:space-between; align-items:flex-start; padding:9px 14px; font-size:.80rem; font-family:var(--font-display); gap:8px; }
        .cfg-row + .cfg-row { border-top:1px solid var(--border); }
        .cfg-key { color:var(--text-muted); font-weight:600; font-size:.72rem; flex-shrink:0; padding-top:1px; font-family:var(--font-display); }
        .cfg-val { font-weight:700; color:var(--text); text-align:right; line-height:1.45; font-size:.78rem; font-family:var(--font-display); }
        .cfg-val.muted { color:var(--border-dk); font-weight:400; font-style:italic; }
        .cfg-chips { display:flex; flex-wrap:wrap; gap:4px; justify-content:flex-end; }
.cfg-chip { padding:2px 8px; border-radius:20px; font-size:.65rem; font-weight:700; font-family:var(--font-display); }.cfg-chip.chip-accent { background: var(--accent-lt); color: var(--caramel); border: 1px solid rgba(200,137,74,.22); }
.cfg-chip.chip-gold   { background: var(--gold-lt); color: #7A5C10; border: 1px solid rgba(196,154,60,.3); }
.cfg-chip.chip-teal   { background: var(--teal-soft); color: var(--teal); border: 1px solid rgba(31,122,108,.22); }
     
     
        .price-rows { padding:2px 0; }
        .price-row { display:flex; justify-content:space-between; align-items:center; padding:8px 14px; font-size:.8rem; font-family:var(--font-body); }
        .price-row + .price-row { border-top:1px solid var(--border); }
        .pr-label { color:var(--text-muted); }
        .pr-val { font-weight:600; color:var(--text); font-family:var(--font-display); font-variant-numeric:tabular-nums; }
        .pr-val.zero { color:var(--border-dk); }.price-row { display:flex; justify-content:space-between; align-items:center; padding:8px 14px; font-size:.8rem; font-family:var(--font-display); }
        .price-row + .price-row { border-top:1px solid var(--border); }
        .pr-label { color:var(--text-muted); font-family:var(--font-display); }
        .pr-val { font-weight:700; color:var(--text); font-family:var(--font-display); font-variant-numeric:tabular-nums; }
        .pr-val.zero { color:var(--border-dk); }
        .price-row.frosting-extra-row { background:rgba(31,122,108,.04); }
        .price-row.frosting-extra-row .pr-label { color:var(--teal); }
        .price-row.frosting-extra-row .pr-val { color:var(--teal); }
.btn-proceed-lg {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--caramel) 0%, var(--caramel-light) 100%);
    color: #fff;
    border: none; border-radius: 12px;
    font-family: var(--font-display); font-size: .9rem; font-weight: 700;
    cursor: pointer;
    transition: all var(--transition);
    box-shadow: 0 4px 16px rgba(200,137,74,0.40);
    display: flex; align-items: center; justify-content: center; gap: 9px;
    letter-spacing: 0.02em;
}
.btn-proceed-lg:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(200,137,74,0.50); }
 
.btn-load-draft {
    width: 100%; padding: 10px;
    background: transparent;
    color: var(--text-muted);
    border: 1.5px solid var(--border-dk);
    border-radius: 12px;
    font-family: var(--font-display); font-size: .82rem; font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    display: flex; align-items: center; justify-content: center; gap: 7px;
}
.btn-load-draft:hover { border-color: var(--caramel); color: var(--caramel); background: var(--accent-lt); }
     
        /* UNIFIED CHOCO TRAY */
        .choco-tray { position:absolute; bottom:14px; left:50%; transform:translateX(-50%); display:none; align-items:center; gap:6px; z-index:31; background:rgba(30,10,4,0.88); backdrop-filter:blur(16px); border:1px solid rgba(180,100,40,0.42); border-radius:18px; padding:7px 14px; box-shadow:0 4px 20px rgba(20,6,2,0.55); pointer-events:all; }
        .choco-tray.visible { display:flex; }
        .choco-tray-label { font-size:.6rem; font-weight:700; color:rgba(210,160,80,0.90); text-transform:uppercase; letter-spacing:.1em; font-family:var(--font-body); white-space:nowrap; margin-right:2px; }
        .choco-tray-sep { width:1px; height:24px; background:rgba(180,100,40,0.28); margin:0 2px; }
        .choco-clear-btn { padding:5px 10px; border:1.5px solid rgba(180,80,55,0.38); border-radius:8px; background:transparent; color:rgba(220,110,85,0.82); font-size:.68rem; font-weight:600; cursor:pointer; font-family:var(--font-body); transition:all var(--transition); white-space:nowrap; }
        .choco-clear-btn:hover { border-color:rgba(220,70,50,0.65); color:#E05535; }
        /* TOAST */
 .toast {
    position: fixed;
    bottom: 26px; left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: linear-gradient(135deg, var(--brown-deep) 0%, var(--brown-mid) 100%);
    color: #fff;
    padding: 10px 22px;
    border-radius: 20px;
font-size: .8rem; font-weight: 600;
    opacity: 0; pointer-events: none;
    transition: all .28s cubic-bezier(.4,0,.2,1);
    z-index: 9999;
    box-shadow: 0 4px 20px rgba(59,31,14,0.40);
    white-space: nowrap;
    font-family: var(--font-display);
    border: 1px solid rgba(255,255,255,0.10);
}
.toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        .toast.show { opacity:1; transform:translateX(-50%) translateY(0); }

.addon-section-lbl {
    font-size: .62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .14em;
    color: var(--brown-mid);
    padding: .4rem 0 .25rem;
    display: flex; align-items: center; gap: 6px;
    font-family: var(--font-display);
}
.addon-section-lbl::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        /* FRUITS DRAG NOTICE */
        .fruits-drag-notice { margin-top:8px; padding:8px 11px; background:linear-gradient(135deg,#E4F2EF 0%,#D4EAE6 100%); border:1px solid rgba(31,122,108,.2); border-radius:9px; font-size:.70rem; color:var(--teal); font-family:var(--font-body); line-height:1.55; align-items:flex-start; gap:7px; }
        .fruits-drag-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .fruits-drag-label { font-weight:700; display:block; margin-bottom:1px; }
        .fruits-drag-sub { color:rgba(31,122,108,.72); font-size:.65rem; }

        /* FERRERO DRAG NOTICE */
        .ferrero-drag-notice { margin-top:8px; padding:8px 11px; background:linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%); border:1px solid rgba(196,154,60,.28); border-radius:9px; font-size:.70rem; color:#7A5C10; font-family:var(--font-body); line-height:1.55; align-items:flex-start; gap:7px; }
        .ferrero-drag-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .ferrero-drag-label { font-weight:700; display:block; margin-bottom:1px; color:#6B4C08; }
        .ferrero-drag-sub { color:rgba(122,92,16,.72); font-size:.65rem; }

        /* KITKAT DRAG NOTICE */
        .kitkat-drag-notice { margin-top:8px; padding:8px 11px; background:linear-gradient(135deg,#FFF0EE 0%,#FFE0DC 100%); border:1px solid rgba(200,60,40,.22); border-radius:9px; font-size:.70rem; color:#8C2010; font-family:var(--font-body); line-height:1.55; align-items:flex-start; gap:7px; }
        .kitkat-drag-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .kitkat-drag-label { font-weight:700; display:block; margin-bottom:1px; color:#7A1A08; }
        .kitkat-drag-sub { color:rgba(140,32,16,.70); font-size:.65rem; }

        /* OREO DRAG NOTICE */
        .oreo-drag-notice { margin-top:8px; padding:8px 11px; background:linear-gradient(135deg,#F4F2F8 0%,#E8E4F0 100%); border:1px solid rgba(80,70,100,.18); border-radius:9px; font-size:.70rem; color:#3A3048; font-family:var(--font-body); line-height:1.55; align-items:flex-start; gap:7px; }
        .oreo-drag-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .oreo-drag-label { font-weight:700; display:block; margin-bottom:1px; color:#2C2438; }
        .oreo-drag-sub { color:rgba(58,48,72,.68); font-size:.65rem; }

        /* BAR SHARD TRAY — dark chocolate */
        .bar-shard-tray { position:absolute; left:50%; transform:translateX(-50%); display:none; align-items:center; gap:6px; z-index:34; background:rgba(30,12,4,0.92); backdrop-filter:blur(16px); border:1px solid rgba(120,60,20,0.50); border-radius:18px; padding:7px 14px; box-shadow:0 4px 20px rgba(20,8,2,0.60); pointer-events:all; }
        .bar-shard-tray.visible { display:flex; }
        .bar-shard-tray-label { font-size:.6rem; font-weight:700; color:rgba(210,150,90,0.90); text-transform:uppercase; letter-spacing:.1em; font-family:var(--font-body); white-space:nowrap; margin-right:2px; }
        .bar-shard-draggable { width:38px; height:38px; border-radius:9px; border:1.5px solid rgba(160,90,30,0.50); background:rgba(60,20,6,0.70); cursor:grab; display:flex; align-items:center; justify-content:center; font-size:1.4rem; transition:all var(--transition); user-select:none; -webkit-user-select:none; position:relative; flex-shrink:0; }
        .bar-shard-draggable:hover { border-color:rgba(200,120,50,0.80); background:rgba(80,28,8,0.88); transform:scale(1.1); }
        .bar-shard-draggable:active { cursor:grabbing; }
        .bar-shard-tip { position:absolute; bottom:calc(100% + 5px); left:50%; transform:translateX(-50%); background:#1E0C04; color:#F0C890; font-size:.58rem; white-space:nowrap; padding:3px 7px; border-radius:5px; pointer-events:none; opacity:0; transition:opacity .15s; font-family:var(--font-body); }
        .bar-shard-draggable:hover .bar-shard-tip { opacity:1; }
        .bar-shard-tray-sep { width:1px; height:24px; background:rgba(160,90,30,0.30); margin:0 2px; }
        .bar-shard-clear-btn { padding:5px 10px; border:1.5px solid rgba(180,60,30,0.38); border-radius:8px; background:transparent; color:rgba(220,110,80,0.82); font-size:.68rem; font-weight:600; cursor:pointer; font-family:var(--font-body); transition:all var(--transition); white-space:nowrap; }
        .bar-shard-clear-btn:hover { border-color:rgba(220,60,30,0.65); color:#E04020; }

/* CANDLE PICKER PANEL */
        .candle-picker-panel { display:none; margin-top:8px; background:linear-gradient(135deg,#FFF8E8 0%,#FFF0CC 100%); border:1.5px solid rgba(196,154,60,.35); border-radius:10px; padding:10px 12px; }
        .candle-picker-panel.visible { display:block; }
        .candle-picker-header { font-size:.67rem; font-weight:700; color:#7A5C10; text-transform:uppercase; letter-spacing:.1em; margin-bottom:8px; font-family:var(--font-body); display:flex; align-items:center; gap:6px; }
        .candle-picker-header::after { content:''; flex:1; height:1px; background:rgba(196,154,60,.25); }
        .candle-num-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:5px; margin-bottom:8px; }
        .candle-num-opt { border:1.5px solid var(--border); border-radius:8px; padding:6px 4px; cursor:pointer; text-align:center; font-family:var(--font-display); font-size:1rem; font-weight:700; color:var(--text-muted); background:var(--surface); transition:all var(--transition); }
        .candle-num-opt:hover { border-color:var(--gold); color:var(--gold); background:var(--gold-lt); }
        .candle-num-opt.active { border-color:var(--gold); background:var(--gold); color:#fff; }
        .candle-active-badge { font-size:.68rem; color:#7A5C10; font-family:var(--font-body); text-align:center; font-weight:500; }
        .candle-drop-ring { position:absolute; border:2px dashed rgba(196,154,60,0.80); border-radius:50%; pointer-events:none; z-index:36; display:none; transform:translate(-50%,-50%); animation:ringPulse .7s ease-in-out infinite; }
        .viewer.candle-drag-over { outline:3px dashed rgba(196,154,60,0.60); outline-offset:-4px; }
        /* CANDLE DRAG NOTICE */
        .candle-drag-notice { margin-top:8px; padding:8px 11px; background:linear-gradient(135deg,#FFF8E8 0%,#FFF0CC 100%); border:1px solid rgba(196,154,60,.28); border-radius:9px; font-size:.70rem; color:#7A5C10; font-family:var(--font-body); line-height:1.55; align-items:flex-start; gap:7px; }
        .candle-drag-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .candle-drag-label { font-weight:700; display:block; margin-bottom:1px; color:#6B4C08; }
        .candle-drag-sub { color:rgba(122,92,16,.72); font-size:.65rem; }

        /* BAR SHARD DRAG NOTICE */
        .bar-shard-drag-notice { margin-top:8px; padding:8px 11px; background:linear-gradient(135deg,#FBF0E6 0%,#F5E0C8 100%); border:1px solid rgba(140,70,20,.22); border-radius:9px; font-size:.70rem; color:#5C2808; font-family:var(--font-body); line-height:1.55; align-items:flex-start; gap:7px; }
        .bar-shard-drag-icon { font-size:.9rem; flex-shrink:0; margin-top:1px; }
        .bar-shard-drag-label { font-weight:700; display:block; margin-bottom:1px; color:#4A1E04; }
        .bar-shard-drag-sub { color:rgba(92,40,8,.68); font-size:.65rem; }
.bar-shard-drop-ring { position:absolute; border:2px dashed rgba(180,100,30,0.80); border-radius:6px; pointer-events:none; z-index:35; display:none; transform:translate(-50%,-50%); animation:ringPulse .7s ease-in-out infinite; }
 /* ── RESPONSIVE ── */

/* Tablet landscape */
@media (max-width: 1200px) {
    :root { --panel-w: 280px; }
}

/* Tablet portrait — drop to 2 columns, hide summary */
@media (max-width: 900px) {
    :root { --panel-w: 240px; }
    .panel:last-child { display: none; }
    .builder { grid-template-columns: var(--panel-w) 1fr; }
    body { overflow: auto; }
}

/* Mobile — full single column stack */
@media (max-width: 768px) {
    :root { --panel-w: 100%; --nav-h: 50px; }

    body { overflow: auto; height: auto; min-height: 100vh; }

    /* Nav */
    nav { padding: 0 12px; gap: 8px; }
    .nav-center { display: none; }
    .btn-save-draft { display: none; }
    .btn-back { padding: 6px 10px; }
    .nav-brand { font-size: 1.1rem; }
    .btn-proceed { padding: 7px 12px; font-size: .8rem; }

    /* Builder: flex column */
    .builder {
        display: flex;
        flex-direction: column;
        height: auto;
        overflow: visible;
    }

  .viewer {
        order: -1;
        width: 100%;
        height: 70vw;        /* taller on mobile */
        min-height: 300px;   /* raised floor */
        max-height: 480px;   /* raised ceiling */
        flex-shrink: 0;
    }

    /* Left panel: full width BELOW viewer */
    .panel:first-child {
        order: 1;
        width: 100%;
        max-height: none;
        overflow-y: visible;
        border-right: none;
        border-top: 2px solid var(--border);
    }

    /* Right panel: hidden (accessible via bottom sheet button) */
    .panel:last-child { display: none !important; }

    /* Viewer overlays: compact */
    .viewer-badge { top: 8px; left: 8px; padding: 5px 9px; }
    .badge-flavor { font-size: .6rem; }
    .badge-shape  { font-size: .56rem; }
    .viewer-controls { top: 8px; right: 8px; }
    .view-btn { width: 28px; height: 28px; }

    #brightnessControl {
        top: 8px !important;
        right: 44px !important;
        padding: 5px 10px !important;
        gap: 6px !important;
    }
    #spotBrightnessSlider { width: 55px !important; }
    #spotBrightnessVal { min-width: 24px; font-size: .6rem !important; }

    .viewer-hint {
        font-size: .6rem;
        padding: 5px 10px;
        bottom: 8px;
        max-width: 90%;
        white-space: normal;
        text-align: center;
    }

    /* Panel content */
    .panel-body  { padding: 12px 14px 100px; gap: 14px; }
    .panel-header { padding: 12px 14px 10px; }

    /* Grids */
    .shape-grid  { grid-template-columns: repeat(3, 1fr); gap: 5px; }
    .addon-grid  { grid-template-columns: 1fr 1fr; gap: 5px; }

    /* Trays: wrap on mobile */
    .fruit-tray,
    .choco-tray {
        max-width: calc(100% - 20px);
        flex-wrap: wrap;
        gap: 5px;
        padding: 6px 10px;
    }

    /* Model status */
    .model-status { bottom: 12px; }
}

/* Very small phones */
@media (max-width: 400px) {
    .addon-grid  { grid-template-columns: 1fr; }
    .shape-grid  { grid-template-columns: repeat(2, 1fr); }
      .viewer { min-height: 260px; height: 75vw; }

    .btn-proceed span { display: none; } /* hide "Request Cake" text on tiny screens */
}
/* ── ROTATION PANEL ── */
.rot-panel { display:none; margin-top:10px; background:var(--warm-white); border:1.5px solid rgba(200,137,74,.35); border-radius:12px; padding:11px 13px; }
.rot-panel.visible { display:block; }
.rot-panel-title { font-size:.68rem; font-weight:700; color:#7A4A1E; margin-bottom:8px; display:flex; align-items:center; gap:5px; font-family:var(--font-display); }
.rot-panel-title svg { flex-shrink:0; }
.rot-preview-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
.rot-emoji-preview { font-size:2rem; line-height:1; transition:transform .18s; display:block; }
.rot-slider-col { flex:1; }
.rot-slider-ends { display:flex; justify-content:space-between; font-size:.63rem; color:var(--text-muted); font-family:var(--font-display); margin-bottom:3px; }
.rot-deg-display { text-align:center; font-size:.82rem; font-weight:700; color:var(--caramel); font-family:var(--font-display); margin-top:3px; }
input[type=range].rot-range { -webkit-appearance:none; appearance:none; width:100%; height:6px; border-radius:3px; background:var(--border); outline:none; cursor:pointer; }
input[type=range].rot-range::-webkit-slider-thumb { -webkit-appearance:none; width:24px; height:24px; border-radius:50%; background:var(--caramel); border:3px solid #fff; box-shadow:0 2px 6px rgba(60,20,5,.28); cursor:pointer; }
.rot-preset-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:5px; margin-bottom:8px; }
.rot-preset-btn { padding:7px 4px; border:1.5px solid rgba(200,137,74,.35); border-radius:9px; background:rgba(200,137,74,.10); color:#7A4A1E; font-size:.70rem; font-weight:700; cursor:pointer; text-align:center; font-family:var(--font-display); transition:all .15s; }
.rot-preset-btn:hover { background:rgba(200,137,74,.25); }
.rot-actions { display:flex; gap:6px; }
.rot-apply-btn { flex:1; padding:9px; background:var(--caramel); border:none; border-radius:10px; color:#fff; font-size:.76rem; font-weight:700; cursor:pointer; font-family:var(--font-display); transition:all .18s; }
.rot-apply-btn:hover { background:var(--caramel-light); }
.rot-reset-btn { padding:9px 11px; background:transparent; border:1.5px solid rgba(200,137,74,.40); border-radius:10px; color:var(--text-muted); font-size:.72rem; font-weight:600; cursor:pointer; font-family:var(--font-display); }
.rot-reset-btn:hover { border-color:var(--caramel); color:var(--caramel); }
/* Gold tint for choco rotation panel */
.rot-panel.rot-gold { border-color:rgba(196,154,60,.40); }
.rot-panel.rot-gold .rot-panel-title { color:#6B4C08; }
.rot-panel.rot-gold input[type=range].rot-range::-webkit-slider-thumb { background:var(--gold); }
.rot-panel.rot-gold .rot-deg-display { color:var(--gold); }
.rot-panel.rot-gold .rot-preset-btn { border-color:rgba(196,154,60,.35); background:rgba(196,154,60,.12); color:#6B4C08; }
.rot-panel.rot-gold .rot-preset-btn:hover { background:rgba(196,154,60,.28); }
.rot-panel.rot-gold .rot-apply-btn { background:var(--gold); }
.rot-panel.rot-gold .rot-apply-btn:hover { background:#D4AA4C; }
.rot-panel.rot-gold .rot-reset-btn { border-color:rgba(196,154,60,.40); }
.rot-panel.rot-gold .rot-reset-btn:hover { border-color:var(--gold); color:var(--gold); }
/* ── PAGE LOAD ANIMATION ── */
@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-28px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(28px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes navReveal {
    from { opacity: 0; transform: translateY(-16px); }
    to   { opacity: 1; transform: translateY(0); }
}

nav {
    animation: navReveal 0.45s cubic-bezier(0.4,0,0.2,1) both;
}
.panel:first-child {
    animation: slideInLeft 0.55s 0.12s cubic-bezier(0.4,0,0.2,1) both;
}
.panel:last-child {
    animation: slideInRight 0.55s 0.18s cubic-bezier(0.4,0,0.2,1) both;
}
.viewer {
    animation: fadeInUp 0.60s 0.08s cubic-bezier(0.4,0,0.2,1) both;
}
    </style>
</head>
<body>

<nav>
    <div class="nav-left">
        <a href="{{ route('customer.dashboard') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back
        </a>
        <div class="nav-divider"></div>
        <a href="{{ route('customer.dashboard') }}" class="nav-brand">Bake<em>Sphere</em></a>
    </div>
    <div class="nav-center">
        <div class="nav-step active"><div class="step-dot"></div>Design</div>
        <div class="step-line"></div>
        <div class="nav-step"><div class="step-dot"></div>Review</div>
        <div class="step-line"></div>
        <div class="nav-step"><div class="step-dot"></div>Submit</div>
    </div>
    <div class="nav-right">
        <button class="btn-save-draft" id="btnSaveDraft">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Draft
        </button>
        <button class="btn-proceed" id="btnProceed">
            Request Cake
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
    </div>
</nav>

<div class="builder">

    {{-- LEFT PANEL --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
                Customize your own Cake
            </div>
            <div class="panel-subtitle">Configure every detail of your cake</div>
        </div>
        <div class="panel-body">

            {{-- SHAPE --}}
            <div>
        <div class="section-label">Cake Shape <span class="section-req">required</span></div>
                <div class="shape-grid" id="opts-shape">
                    <div class="shape-opt active" data-val="Round"><span class="sh-emoji">🎂</span><span class="sh-name">Round</span></div>
                    <div class="shape-opt" data-val="Square"><span class="sh-emoji">🟫</span><span class="sh-name">Square</span></div>
                    <div class="shape-opt" data-val="Heart"><span class="sh-emoji">❤️</span><span class="sh-name">Heart</span></div>
                    <div class="shape-opt" data-val="Number"><span class="sh-emoji">🔢</span><span class="sh-name">Number</span></div>
                </div>

                <div class="section-label" style="margin-top:14px;">Cake Tier <span style="font-size:.6rem;color:var(--text-muted);font-weight:400;margin-left:auto;">optional</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 8px;font-family:var(--font-display);">Leave on <strong>Single</strong> unless you want a stacked cake. Only applies to <strong>Round</strong>.</p>
                <div class="shape-grid" id="opts-tier" style="grid-template-columns:repeat(3,1fr);">
                    <div class="shape-opt active" data-tier="Single"><span class="sh-emoji">🎂</span><span class="sh-name">Single</span></div>
                    <div class="shape-opt" data-tier="Two-tier"><span class="sh-emoji">🎂</span><span class="sh-name">Two-tier</span></div>
                    <div class="shape-opt" data-tier="Three-tier"><span class="sh-emoji">🎂</span><span class="sh-name">Three-tier</span></div>
                </div>
                <div class="size-slider-wrap visible" id="sizeSliderWrap">
                    <div class="size-slider-header">
                     <span class="size-slider-label" id="sizeLabelText">Round Size</span>
                        <span class="size-slider-val"><span id="sizeDisplay">6</span>" Inches</span>
                    </div>
                    <input type="range" class="size-range" id="sizeRange" min="4" max="10" step="1" value="6">
                    <div class="size-ticks">
                        <span class="size-tick">4"</span><span class="size-tick">5"</span><span class="size-tick">6"</span>
                        <span class="size-tick">7"</span><span class="size-tick">8"</span><span class="size-tick">9"</span><span class="size-tick">10"</span>
                    </div>
                </div>
                <div class="number-picker-wrap" id="numberPickerWrap">
                    <div class="number-picker-label">Choose a number</div>
                    <div class="digit-mode-toggle">
                        <button class="digit-mode-btn active" id="btnSingleDigit">Single (0 – 9)</button>
                        <button class="digit-mode-btn" id="btnDualDigit">Double (10 – 99)</button>
                    </div>
                    <div id="singleDigitSection">
                        <div class="number-grid" id="opts-number">
                            <div class="num-opt active" data-val="0">0</div>
                            <div class="num-opt" data-val="1">1</div>
                            <div class="num-opt" data-val="2">2</div>
                            <div class="num-opt" data-val="3">3</div>
                            <div class="num-opt" data-val="4">4</div>
                            <div class="num-opt" data-val="5">5</div>
                            <div class="num-opt" data-val="6">6</div>
                            <div class="num-opt" data-val="7">7</div>
                            <div class="num-opt" data-val="8">8</div>
                            <div class="num-opt" data-val="9">9</div>
                        </div>
                    </div>
                    <div class="dual-digit-wrap" id="dualDigitSection">
                        <div class="dual-digit-preview" id="dualPreview">10<span>Your number cake</span></div>
                        <div class="dual-cols">
                            <div class="dual-col">
                                <div class="dual-col-label">Tens</div>
                                <div class="num-grid-sm" id="opts-tens">
                                    <div class="num-opt-sm active" data-val="1">1</div>
                                    <div class="num-opt-sm" data-val="2">2</div>
                                    <div class="num-opt-sm" data-val="3">3</div>
                                    <div class="num-opt-sm" data-val="4">4</div>
                                    <div class="num-opt-sm" data-val="5">5</div>
                                    <div class="num-opt-sm" data-val="6">6</div>
                                    <div class="num-opt-sm" data-val="7">7</div>
                                    <div class="num-opt-sm" data-val="8">8</div>
                                    <div class="num-opt-sm" data-val="9">9</div>
                                </div>
                            </div>
                            <div class="dual-col">
                                <div class="dual-col-label">Units</div>
                                <div class="num-grid-sm" id="opts-units">
                                    <div class="num-opt-sm active" data-val="0">0</div>
                                    <div class="num-opt-sm" data-val="1">1</div>
                                    <div class="num-opt-sm" data-val="2">2</div>
                                    <div class="num-opt-sm" data-val="3">3</div>
                                    <div class="num-opt-sm" data-val="4">4</div>
                                    <div class="num-opt-sm" data-val="5">5</div>
                                    <div class="num-opt-sm" data-val="6">6</div>
                                    <div class="num-opt-sm" data-val="7">7</div>
                                    <div class="num-opt-sm" data-val="8">8</div>
                                    <div class="num-opt-sm" data-val="9">9</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FLAVOR --}}
            <div>
                <div class="section-label">Flavour <span class="section-req">required</span></div>
                <div class="opts" id="opts-flavor">
                    <div class="opt active" data-val="Vanilla"    data-price="0"> <span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#F2C96A;border:1px solid #E0B040;"></span>Vanilla</span></div>
                    <div class="opt"        data-val="Chocolate"  data-price="80"> <span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#5C2D0E;"></span>Chocolate</span></div>
                    <div class="opt"        data-val="Red Velvet" data-price="100"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#8B1111;"></span>Red Velvet</span></div>
                    <div class="opt"        data-val="Strawberry" data-price="120"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#D94070;"></span>Strawberry</span></div>
                    <div class="opt"        data-val="Ube"        data-price="130"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#6B3FA0;"></span>Ube</span></div>
                    <div class="opt"        data-val="Mocha"      data-price="100"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#4A2810;"></span>Mocha</span></div>
                </div>
            </div>

            {{-- FROSTING --}}
            <div>
    <div class="section-label">Frosting Style <span class="section-req">required</span></div>
                <p style="font-size:.70rem;color:var(--brown-mid);margin:0 0 10px;font-family:var(--font-display);background:var(--accent-lt);border:1px solid rgba(200,137,74,.22);border-radius:8px;padding:7px 11px;">
                    💡 <strong>You only need to choose a base coat.</strong> Texture and special finishes are completely optional.
                </p>
                <div class="frosting-guide">
                    <div class="frosting-guide-title"><span class="frosting-guide-title-icon">🎂</span>How frosting works</div>
                    <div class="frosting-guide-steps">
                        <div class="frosting-step">
                            <div class="frosting-step-num">1</div>
                            <div class="frosting-step-body">
                                <span class="frosting-step-label">Pick a base coat</span>
                                <span class="frosting-step-desc"><strong>Smooth Buttercream</strong> or <strong>Sugar Icing</strong> — alternatives to each other.</span>
                            </div>
                        </div>
                        <div class="frosting-step">
                            <div class="frosting-step-num">2</div>
                            <div class="frosting-step-body">
                                <span class="frosting-step-label">Add Textured on top (optional)</span>
                                <span class="frosting-step-desc"><strong>Textured Buttercream</strong> adds a ridged finish, pairs with either base coat.</span>
                            </div>
                        </div>
                        <div class="frosting-step">
                            <div class="frosting-step-num">3</div>
                            <div class="frosting-step-body">
                                <span class="frosting-step-label">Add special finishes (optional)</span>
                                <span class="frosting-step-desc"><strong>Ganache</strong> and <strong>Semi-naked</strong> can be added alongside any base coat.</span>
                            </div>
                        </div>
                    </div>
           <div class="frosting-guide-note" style="background:rgba(220,50,30,.10);border-color:rgba(220,50,30,.30);">
                        <span class="frosting-guide-note-icon">⚠️</span>
                        <span><strong>Fondant is solo only</strong> — selecting it <strong>disables all other frosting options</strong>. Tap Fondant again to deselect it.</span>
                    </div>
                </div>

                <div class="frosting-section-label">🎨 Base Coat <span style="font-size:.58rem;color:var(--text-muted);font-weight:400;margin-left:4px;">(pick one)</span></div>
                <div class="addon-grid" id="opts-frosting-base">
                    <div class="addon-opt frosting-opt active" data-val="Smooth Buttercream" data-price="0" data-group="base">
                        <div class="a-icon">🎨</div>
                        <div class="a-info"><span class="a-name">Smooth BC</span><span class="a-price">Included</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                    <div class="addon-opt frosting-opt" data-val="Sugar Icing" data-price="150" data-group="base">
                        <div class="a-icon">🍦</div>
                        <div class="a-info"><span class="a-name">Sugar Icing</span><span class="a-price">+₱150 · choose color</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>

                <div class="icing-panel" id="icingPanel">
                    <div class="icing-header">Choose icing color</div>
<div class="icing-color-grid" id="icingColorGrid" style="grid-template-columns:repeat(6,minmax(0,1fr));gap:5px;">                        <div class="icing-color-opt light-color active" data-icing-color="#FFFFFF" data-icing-name="White"    style="background:#FFFFFF;border-color:#D5C8B8;"></div>
                        <div class="icing-color-opt light-color"        data-icing-color="#FFCCE0" data-icing-name="Pink"     style="background:#FFCCE0;"></div>
                        <div class="icing-color-opt light-color"        data-icing-color="#C8E6FF" data-icing-name="Sky Blue" style="background:#C8E6FF;"></div>
                        <div class="icing-color-opt light-color"        data-icing-color="#D4C8FF" data-icing-name="Lavender" style="background:#D4C8FF;"></div>
                        <div class="icing-color-opt"                    data-icing-color="#F5C842" data-icing-name="Gold"     style="background:#F5C842;"></div>
                        <div class="icing-color-opt"                    data-icing-color="#2C1810" data-icing-name="Chocolate" style="background:#2C1810;"></div>
                    </div>
                    <div class="icing-color-label" id="icingColorLabel">White</div>
                </div>

                <div class="frosting-section-label" style="margin-top:10px;">🖌️ Texture Add-on <span style="font-size:.58rem;color:var(--text-muted);font-weight:400;margin-left:4px;">(pairs with any base coat)</span></div>
                <div class="addon-grid" id="opts-frosting-bc">
                    <div class="addon-opt frosting-opt" data-val="Textured Buttercream" data-price="150" data-group="texture">
                        <div class="a-icon">🖌️</div>
                        <div class="a-info"><span class="a-name">Textured</span><span class="a-price">+₱150</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>

                <div class="frosting-section-label" style="margin-top:10px;">✨ Cake type <span style="font-size:.58rem;color:var(--text-muted);font-weight:400;margin-left:4px;">(combinable with any base coat)</span></div>
                <div class="addon-grid" id="opts-frosting-special">
                    <div class="addon-opt frosting-opt" data-val="Fondant Smooth" data-price="350" data-group="special">
                        <div class="a-icon">⬜</div>
                        <div class="a-info"><span class="a-name">Fondant</span><span class="a-price">+₱350 · solo only</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                    <div class="addon-opt frosting-opt" data-val="Chocolate Ganache" data-price="250" data-group="special">
                        <div class="a-icon">🍫</div>
                        <div class="a-info"><span class="a-name">Ganache</span><span class="a-price">+₱250</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                    <div class="addon-opt frosting-opt" data-val="Semi-naked Style" data-price="200" data-group="special">
                        <div class="a-icon">🎂</div>
                        <div class="a-info"><span class="a-name">Semi-naked</span><span class="a-price">+₱200</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>

                <div class="fondant-notice" id="fondantNotice">
                    <span class="fondant-notice-icon">⬜</span>
                    <div>
                        <span class="fondant-notice-title">Fondant selected — solo only</span>
                        <span class="fondant-notice-sub">Fondant replaces all other frosting styles. Tap Fondant again to deselect.</span>
                    </div>
                </div>
                <div class="frosting-combo-hint" id="frostingComboHint">
                    <span class="frosting-combo-hint-icon">✨</span>
                    <div>
                        <span class="frosting-combo-label" id="frostingComboLabel"></span>
                        <span class="frosting-combo-sub">Baker will apply all selected styles to your cake</span>
                    </div>
                </div>
            </div>

            {{-- ADD-ONS --}}
            <div>
                <div class="section-label">Add-ons <span style="font-size:.6rem;color:var(--text-muted);font-weight:400;margin-left:auto;">optional</span></div>

                <div class="addon-section-lbl">💧 Drip</div>
                <div class="addon-grid" style="margin-bottom:6px;">
                    <div class="addon-opt" data-group="drips" data-val="Drip" data-price="180" id="dripToggleBtn">
                        <div class="a-icon">💧</div>
                        <div class="a-info"><span class="a-name">Add Drip</span><span class="a-price">+₱180 · pick flavor</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>
                <div class="drip-flavor-panel" id="dripFlavorPanel">
                    <div class="drip-flavor-header">Choose drip flavor</div>
                    <div class="drip-flavors" id="dripFlavorOpts">
                        <div class="drip-flavor-opt active" data-drip-flavor="Vanilla"         data-drip-color="#E8C040"><span class="drip-color-dot" style="background:#E8C040;"></span>Vanilla</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Chocolate"       data-drip-color="#4A1805"><span class="drip-color-dot" style="background:#4A1805;"></span>Chocolate</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Red Velvet"      data-drip-color="#C01010"><span class="drip-color-dot" style="background:#C01010;"></span>Red Velvet</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Strawberry"      data-drip-color="#E83468"><span class="drip-color-dot" style="background:#E83468;"></span>Strawberry</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Ube"             data-drip-color="#7030B8"><span class="drip-color-dot" style="background:#7030B8;"></span>Ube</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Mocha"           data-drip-color="#704018"><span class="drip-color-dot" style="background:#704018;"></span>Mocha</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Caramel"         data-drip-color="#C47A1A"><span class="drip-color-dot" style="background:#C47A1A;"></span>Caramel</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="White Chocolate" data-drip-color="#F5ECD0"><span class="drip-color-dot" style="background:#F5ECD0;border:1px solid #D5C8B8;"></span>White Choco</div>
                    </div>
                </div>
<div class="addon-section-lbl" style="margin-top:10px;">🍓 Fruits</div>
                <div style="background:var(--accent-lt);border:1px solid rgba(200,137,74,.25);border-radius:12px;padding:10px 12px;">
                    <p style="font-size:.72rem;font-weight:700;color:#7A4A1E;margin:0 0 10px;font-family:var(--font-display);">Tap a fruit to add it — then tap the cake preview to place it</p>
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;" id="opts-fruits">
                <div class="addon-opt fruit-tile" data-group="fruits" data-val="Strawberry" data-price="45" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🍓</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Strawberry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱45/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                  <div class="addon-opt fruit-tile" data-group="fruits" data-val="Blueberry" data-price="25" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🫐</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Blueberry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱25/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                    <div class="addon-opt fruit-tile" data-group="fruits" data-val="Raspberry" data-price="55" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🍇</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Raspberry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱55/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                      <div class="addon-opt fruit-tile" data-group="fruits" data-val="Cherry" data-price="35" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🍒</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Cherry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱35/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                    </div>
                    <div id="fruitsDragNotice" style="display:none;margin-top:9px;padding:7px 10px;background:rgba(200,137,74,.15);border-radius:8px;font-size:.70rem;color:#7A4A1E;font-family:var(--font-display);align-items:center;gap:6px;flex-direction:row;">
                        <span style="font-size:1.1rem;">👆</span>
                        <span><strong>Now tap the cake preview</strong> to place your fruit. Tap a placed fruit to move it.</span>
                    </div>
            
                </div>

<div class="addon-section-lbl" style="margin-top:10px;">🍫 Chocolate Decorations</div>
                <div style="background:var(--gold-lt);border:1px solid rgba(196,154,60,.28);border-radius:12px;padding:10px 12px;">
                    <p style="font-size:.72rem;font-weight:700;color:#6B4C08;margin:0 0 10px;font-family:var(--font-display);">Tap a decoration to add it — then tap the cake preview to place it</p>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;" id="opts-choco">
                   <div class="addon-opt" data-group="choco" data-val="Ferrero-style Ball" data-price="55" id="ferreroToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🟤</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Ferrero</span>
                 <span class="a-price" style="font-size:.60rem;text-align:center;">+₱55/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt" data-group="choco" data-val="Kitkat Sticks" data-price="30" id="kitkatToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🍬</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">KitKat</span>
                 <span class="a-price" style="font-size:.60rem;text-align:center;">+₱30/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
            <div class="addon-opt" data-group="choco" data-val="Oreo Cookie" data-price="20" id="oreoToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">⚫</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Oreo</span>
                         <span class="a-price" style="font-size:.60rem;text-align:center;">+₱20/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                      <div class="addon-opt" data-group="choco" data-val="Chocolate Bar Shard" data-price="40" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🍫</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Bar Shard</span>
                       <span class="a-price" style="font-size:.60rem;text-align:center;">+₱40/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt" data-group="choco" data-val="Chocolate Curls" data-price="45" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🌀</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Choco Curls</span>
                      <span class="a-price" style="font-size:.60rem;text-align:center;">+₱45</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt" data-group="choco" data-val="Chocolate Plaque" data-price="80" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <span style="font-size:1.8rem;line-height:1;">🟫</span>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Choco Plaque</span>
                       <span class="a-price" style="font-size:.60rem;text-align:center;">+₱80</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                    </div>
                    <div id="chocoPlaceNotice" style="display:none;margin-top:9px;padding:7px 10px;background:rgba(196,154,60,.18);border-radius:8px;font-size:.70rem;color:#6B4C08;font-family:var(--font-display);align-items:center;gap:6px;flex-direction:row;">
                        <span style="font-size:1.1rem;">👆</span>
                        <span><strong>Now tap the cake preview</strong> to place it. Tap a placed piece to move it.</span>
                    </div>
                    {{-- CHOCO ROTATION PANEL --}}
                    <div class="rot-panel rot-gold" id="chocoRotPanel">
                        <div class="rot-panel-title">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#C49A3C" stroke-width="2.5" stroke-linecap="round"><path d="M3 12a9 9 0 1 0 9-9"/><path d="M3 3v4h4"/></svg>
                            Rotate: <span id="chocoRotLabel">Ferrero</span>
                        </div>
                        <div class="rot-preview-row">
                            <span class="rot-emoji-preview" id="chocoRotEmoji">🟤</span>
                            <div class="rot-slider-col">
                                <div class="rot-slider-ends"><span>0°</span><span>360°</span></div>
                                <input type="range" class="rot-range" id="chocoRotRange" min="0" max="360" step="5" value="0">
                                <div class="rot-deg-display" id="chocoRotDeg">0°</div>
                            </div>
                        </div>
                        <div class="rot-preset-grid">
                            <button class="rot-preset-btn" data-choco-rot="0">↑ Up</button>
                            <button class="rot-preset-btn" data-choco-rot="90">→ Right</button>
                            <button class="rot-preset-btn" data-choco-rot="180">↓ Down</button>
                            <button class="rot-preset-btn" data-choco-rot="270">← Left</button>
                        </div>
                        <div class="rot-actions">
                            <button class="rot-apply-btn" id="chocoRotApply">✓ Apply to cake</button>
                            <button class="rot-reset-btn" id="chocoRotReset">Reset</button>
                       </div>
                </div>
                </div>

                <div class="ferrero-drag-notice" id="ferreroDragNotice" style="display:none;flex-direction:row;">
                    <span class="ferrero-drag-icon">🟤</span>
                    <div>
                        <span class="ferrero-drag-label">Drag Ferrero Balls onto your cake!</span>
                        <span class="ferrero-drag-sub">Use the golden tray at the bottom of the preview. Click a placed ball to pick it up and move it.</span>
                    </div>
                </div>

                <div class="orient-panel" id="kitkatOrientPanel">
                    <div class="orient-panel-header">🍬 KitKat orientation</div>
                    <div class="orient-toggle">
                        <button class="orient-btn active" id="btnKitkatStanding">
                            <span class="orient-btn-icon">📏</span> Standing
                        </button>
                        <button class="orient-btn" id="btnKitkatLying">
                            <span class="orient-btn-icon">📐</span> Lying Flat
                        </button>
                    </div>
                    <div class="orient-hint">
                        <strong>Standing</strong> — sticks upright like a fence around the cake.<br>
                        <strong>Lying Flat</strong> — placed horizontally on the cake surface.
                    </div>
                </div>
                <div class="kitkat-drag-notice" id="kitkatDragNotice" style="display:none;flex-direction:row;">
                    <span class="kitkat-drag-icon">🍬</span>
                    <div>
                        <span class="kitkat-drag-label">Drag KitKat sticks onto your cake!</span>
                        <span class="kitkat-drag-sub">Use the red tray below the preview. Toggle Standing / Lying above to switch orientation before placing.</span>
                    </div>
                </div>

                <div class="orient-panel" id="oreoOrientPanel">
                    <div class="orient-panel-header">⚫ Oreo orientation</div>
                    <div class="orient-toggle">
                        <button class="orient-btn" id="btnOreoStanding">
                            <span class="orient-btn-icon">🔘</span> Standing
                        </button>
                        <button class="orient-btn active" id="btnOreoLying">
                            <span class="orient-btn-icon">⚫</span> Lying Flat
                        </button>
                    </div>
                    <div class="orient-hint">
                        <strong>Lying Flat</strong> — cookie face-up on the cake (classic look).<br>
                        <strong>Standing</strong> — balanced on its edge like a wheel.
                    </div>
                </div>
                <div class="oreo-drag-notice" id="oreoDragNotice" style="display:none;flex-direction:row;">
                    <span class="oreo-drag-icon">⚫</span>
                    <div>
                        <span class="oreo-drag-label">Drag Oreo cookies onto your cake!</span>
                        <span class="oreo-drag-sub">Use the dark tray below the preview. Toggle Standing / Lying above to switch orientation before placing.</span>
                    </div>
                </div>

                <div class="bar-shard-drag-notice" id="barShardDragNotice" style="display:none;flex-direction:row;">
                    <span class="bar-shard-drag-icon">🍫</span>
                    <div>
                        <span class="bar-shard-drag-label">Drag Chocolate Bar Shards onto your cake!</span>
                        <span class="bar-shard-drag-sub">Use the brown tray below the preview. Click a placed shard to pick it up and move it.</span>
                    </div>
                </div>

                <div class="addon-section-lbl" style="margin-top:10px;">✨ Sprinkles</div>
                <div class="addon-grid" id="opts-sprinkles" style="margin-bottom:10px;">
                    <div class="addon-opt" data-group="sprinkles" data-val="Cylinder Sprinkles" data-price="30"><div class="a-icon">✨</div><div class="a-info"><span class="a-name">Cylinder Mix</span><span class="a-price">+₱30</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="sprinkles" data-val="Sphere Sprinkles"   data-price="30"><div class="a-icon">🔮</div><div class="a-info"><span class="a-name">Pearl Mix</span>   <span class="a-price">+₱30</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                </div>

                <div class="addon-section-lbl">🕯️ Candles &amp; Toppers</div>
                <div class="addon-grid" id="opts-candles" style="margin-bottom:10px;">
                    <div class="addon-opt" data-group="candles" data-val="Number Candles"        data-price="20"> <div class="a-icon">🔢</div><div class="a-info"><span class="a-name">Number Candle</span><span class="a-price">+₱20/pc</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="candles" data-val="Happy Birthday Topper" data-price="60"> <div class="a-icon">🎉</div><div class="a-info"><span class="a-name">HBD Topper</span>  <span class="a-price">+₱60</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="candles" data-val="Name Plaque"            data-price="100"><div class="a-icon">📛</div><div class="a-info"><span class="a-name">Name Plaque</span> <span class="a-price">+₱100</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="candles" data-val="Crown Topper"           data-price="80"><div class="a-icon">👑</div><div class="a-info"><span class="a-name">Crown Topper</span><span class="a-price">+₱80</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="candles" data-val="Heart Topper"           data-price="70"><div class="a-icon">❤️</div><div class="a-info"><span class="a-name">Heart Topper</span><span class="a-price">+₱70</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                </div>

           <div class="candle-picker-panel" id="candlePickerPanel">
                    <div class="candle-picker-header">🕯️ Select candle number to place</div>
                   <div class="candle-num-grid" id="opts-candle-nums">
                        <div class="candle-num-opt" data-candle-num="0">0</div>
                        <div class="candle-num-opt active" data-candle-num="1">1</div>
                        <div class="candle-num-opt" data-candle-num="2">2</div>
                        <div class="candle-num-opt" data-candle-num="3">3</div>
                        <div class="candle-num-opt" data-candle-num="4">4</div>
                        <div class="candle-num-opt" data-candle-num="5">5</div>
                        <div class="candle-num-opt" data-candle-num="6">6</div>
                        <div class="candle-num-opt" data-candle-num="7">7</div>
                        <div class="candle-num-opt" data-candle-num="8">8</div>
                        <div class="candle-num-opt" data-candle-num="9">9</div>
                    </div>
                    <div class="candle-active-badge" id="candleActiveBadge">Selected: Candle #1 — drag to place</div>
                </div>
                <div class="candle-drag-notice" id="candleDragNotice" style="display:none;flex-direction:row;">
                    <span class="candle-drag-icon">🕯️</span>
                    <div>
                        <span class="candle-drag-label">Drag candles onto your cake!</span>
                        <span class="candle-drag-sub">Pick a number above, then drag from the tray at the bottom of the preview. Click a placed candle to move it.</span>
                    </div>
                </div>

                <div class="addon-section-lbl">🌸 Decorative Elements</div>     
                <div class="addon-grid" id="opts-deco">
                    <div class="addon-opt" data-group="deco" data-val="Buttercream Swirls" data-price="75"><div class="a-icon">🌀</div><div class="a-info"><span class="a-name">BC Swirls</span>    <span class="a-price">+₱75</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="deco" data-val="Rosettes"           data-price="100"><div class="a-icon">🌹</div><div class="a-info"><span class="a-name">Rosettes</span>     <span class="a-price">+₱100</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="deco" data-val="Macarons"           data-price="48"> <div class="a-icon">🟡</div><div class="a-info"><span class="a-name">Macarons</span>     <span class="a-price">+₱48/pc</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="deco" data-val="Meringue Drops"     data-price="70"><div class="a-icon">⚪</div><div class="a-info"><span class="a-name">Meringue</span>     <span class="a-price">+₱70</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="deco" data-val="Ribbon Wrap"        data-price="50"> <div class="a-icon">🎀</div><div class="a-info"><span class="a-name">Ribbon Wrap</span>  <span class="a-price">+₱50</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                    <div class="addon-opt" data-group="deco" data-val="Edible Pearls"      data-price="60"><div class="a-icon">🫧</div><div class="a-info"><span class="a-name">Edible Pearls</span><span class="a-price">+₱60</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                </div>
            </div>

        </div>
    </div>

    {{-- CENTER: VIEWER --}}
    <div class="viewer" id="viewerEl">
        <div id="model-container"></div>
        <canvas id="fruitCanvas"></canvas>
        <div class="model-loading" id="modelLoading">
            <div class="loading-spinner"></div>
            <div class="loading-text" id="loadingText">Building 3D preview…</div>
        </div>
        <div class="viewer-badge">
            <div class="badge-flavor" id="badgeFlavor">Vanilla</div>
            <div class="badge-shape"  id="badgeShape">Round 6" · Smooth Buttercream</div>
        </div>
        <div class="viewer-controls">
            <button class="view-btn" id="btnResetView" title="Reset view">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
            </button>
        </div>
        <div id="brightnessControl" style="position:absolute;top:14px;right:54px;z-index:10;background:rgba(55,30,10,0.70);backdrop-filter:blur(18px);border:1px solid rgba(210,165,90,0.28);border-radius:10px;padding:8px 14px;box-shadow:0 2px 8px rgba(60,30,5,0.35);display:flex;align-items:center;gap:10px;">
            <span style="font-size:.65rem;color:rgba(180,130,65,0.85);font-family:var(--font-body);white-space:nowrap;">💡 Brightness</span>
        <input type="range" id="spotBrightnessSlider" min="0" max="100" value="35" step="1"
                style="-webkit-appearance:none;appearance:none;width:90px;height:3px;background:rgba(210,165,90,0.35);border-radius:2px;outline:none;cursor:pointer;">
       <span id="spotBrightnessVal" style="font-size:.65rem;color:rgba(210,165,90,0.85);font-family:var(--font-display);min-width:28px;">35%</span>
        </div>
        <div class="viewer-hint" id="viewerHint">🖱 Drag to rotate &nbsp;·&nbsp; Scroll to zoom</div>
        <div class="model-status hidden" id="modelStatus">Ready</div>

        {{-- FRUIT TRAY --}}
        <div class="fruit-tray" id="fruitTray">
            <span class="fruit-tray-label">Drag:</span>
            <div class="fruit-draggable" data-fruit="Strawberry" data-emoji="🍓" draggable="true" id="trayStrawberry">🍓<span class="fruit-tip">Strawberry</span></div>
            <div class="fruit-draggable" data-fruit="Blueberry"  data-emoji="🫐" draggable="true" id="trayBlueberry">🫐<span class="fruit-tip">Blueberry</span></div>
            <div class="fruit-draggable" data-fruit="Raspberry"  data-emoji="🍇" draggable="true" id="trayRaspberry">🍇<span class="fruit-tip">Raspberry</span></div>
            <div class="fruit-draggable" data-fruit="Cherry"     data-emoji="🍒" draggable="true" id="trayCherry">🍒<span class="fruit-tip">Cherry</span></div>
            <div class="fruit-tray-sep"></div>
            <button class="fruit-clear-btn" id="btnClearFruits">Clear all</button>
        </div>

        {{-- CHOCO DECORATION TRAY --}}
        <div class="choco-tray" id="chocoTray">
            <span class="choco-tray-label">Choco:</span>
            <div class="ferrero-draggable" data-ferrero="Ferrero-style Ball" data-emoji="🟤" draggable="true" id="trayFerrero" style="display:none;">🟤<span class="ferrero-tip">Ferrero</span></div>
            <div class="kitkat-draggable" data-kitkat="Kitkat Sticks" data-emoji="🍬" draggable="true" id="trayKitkat" style="display:none;">🍬<span class="kitkat-tip">KitKat</span></div>
            <div class="oreo-draggable" data-oreo="Oreo Cookie" data-emoji="⚫" draggable="true" id="trayOreo" style="display:none;">⚫<span class="oreo-tip">Oreo</span></div>
            <div class="bar-shard-draggable" data-bar-shard="Chocolate Bar Shard" data-emoji="🍫" draggable="true" id="trayBarShard" style="display:none;">🍫<span class="bar-shard-tip">Bar Shard</span></div>
            <div class="choco-tray-sep" id="chocoTraySep" style="display:none;"></div>
            <span style="font-size:.6rem;color:rgba(255,130,110,.7);font-family:var(--font-body);display:none;" id="kitkatOrientBadge">📏 Standing</span>
            <span style="font-size:.6rem;color:rgba(230,220,200,.7);font-family:var(--font-body);display:none;" id="oreoOrientBadge">⚫ Lying Flat</span>
            <div class="choco-tray-sep" id="chocoTraySep2" style="display:none;"></div>
            <button class="choco-clear-btn" id="btnClearAllChoco" style="display:none;">Clear all</button>
        </div>

{{-- CANDLE TRAY --}}
        <div class="fruit-tray" id="candleTray" style="background:rgba(38,22,4,0.88);border:1px solid rgba(196,154,60,0.45);">
            <span class="fruit-tray-label" style="color:rgba(220,180,80,0.85);">🕯️ Candle:</span>
            <div class="fruit-draggable" id="trayCandle" draggable="true" style="border-color:rgba(196,154,60,0.45);background:rgba(60,35,5,0.70);">🕯️<span class="fruit-tip" id="trayCandleLabel">Candle #1</span></div>
            <div class="fruit-tray-sep" style="background:rgba(196,154,60,0.25);"></div>
            <button class="fruit-clear-btn" id="btnClearCandles">Clear all</button>
        </div>

       <div id="dragGhost" style="display:none;"></div>
        <div class="drop-ring" id="dropRing" style="width:36px;height:36px;"></div>
        <div class="ferrero-drop-ring" id="ferreroDropRing" style="width:40px;height:40px;"></div>
        <div class="kitkat-drop-ring" id="kitkatDropRing" style="width:48px;height:24px;"></div>
        <div class="oreo-drop-ring" id="oreoDropRing" style="width:42px;height:42px;"></div>
<div class="bar-shard-drop-ring" id="barShardDropRing" style="width:48px;height:36px;"></div>
        <div class="candle-drop-ring" id="candleDropRing" style="width:38px;height:38px;"></div>
    </div>

    {{-- RIGHT PANEL: SUMMARY --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                Summary
            </div>
            <div class="panel-subtitle">Your current configuration</div>
        </div>
        <div class="panel-body">
            <div class="config-card">
                <div class="config-card-header">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4"/></svg>
                    Selections
                </div>
                <div class="cfg-row"><span class="cfg-key">Shape</span><span class="cfg-val" id="selShape">Round 6"</span></div>
                <div class="cfg-row"><span class="cfg-key">Flavour</span><span class="cfg-val" id="selFlavor">Vanilla</span></div>
                <div class="cfg-row"><span class="cfg-key">Frosting</span><span class="cfg-val" id="selFrosting">Smooth Buttercream</span></div>
                <div class="cfg-row" id="selIcingRow" style="display:none;"><span class="cfg-key">Icing Color</span><span class="cfg-val" id="selIcingColor">White</span></div>
                <div class="cfg-row" id="selDripRow" style="display:none;"><span class="cfg-key">Drip</span><span class="cfg-val" id="selDrip">—</span></div>
                <div class="cfg-row" id="selFruitsRow" style="display:none;"><span class="cfg-key">Fruits</span><span class="cfg-val" id="selFruits">—</span></div>
                <div class="cfg-row" id="selFerreroRow" style="display:none;"><span class="cfg-key">Ferrero</span><span class="cfg-val" id="selFerrero">—</span></div>
                <div class="cfg-row" id="selKitkatRow" style="display:none;"><span class="cfg-key">KitKat</span><span class="cfg-val" id="selKitkat">—</span></div>
                <div class="cfg-row" id="selOreoRow" style="display:none;"><span class="cfg-key">Oreo</span><span class="cfg-val" id="selOreo">—</span></div>
                <div class="cfg-row" id="selBarShardRow" style="display:none;"><span class="cfg-key">Bar Shard</span><span class="cfg-val" id="selBarShard">—</span></div>
            </div>
            <div class="config-card">
                <div class="config-card-header">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Add-ons
                </div>
                <div style="padding:10px 14px;">
                    <div class="cfg-chips" id="addonsSummary">
                        <span class="cfg-val muted" style="font-size:.73rem;">None selected</span>
                    </div>
                </div>
            </div>
            <div class="price-block">
                <div class="price-block-header">Pricing Breakdown</div>
                <div class="price-rows">
                    <div class="price-row"><span class="pr-label">Base (Shape)</span><span class="pr-val" id="priceBase">₱350</span></div>
                    <div class="price-row frosting-extra-row" id="priceFrostingRow" style="display:none;"><span class="pr-label">Frosting extras</span><span class="pr-val" id="priceFrosting">₱0</span></div>
                    <div class="price-row"><span class="pr-label">Add-ons</span><span class="pr-val zero" id="priceAddons">₱0</span></div>
                </div>
            </div>
            <div class="price-total-block">
                <div>
                    <div class="pt-label">Estimated Total</div>
                    <div class="pt-amount"><span class="pt-currency">₱</span><span class="pt-number" id="priceTotal">350</span></div>
                    <div class="pt-note">Final price confirmed by baker</div>
                </div>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#B85C38" stroke-width="1.5" opacity="0.35"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <button class="btn-proceed-lg" id="btnProceedLg">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Request This Cake
                </button>
                <button class="btn-load-draft" id="btnLoadDraft">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Load Saved Draft
                </button>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>
<form id="proceedForm" method="POST" action="{{ route('customer.cake-builder.saveAndProceed') }}">
    @csrf
    <input type="hidden" name="config" id="configInput">
    <input type="hidden" name="cake_preview" id="cakePreviewInput">
</form>

<script type="module">
import * as THREE        from '/js/three/three.module.js';
import { GLTFLoader }    from '/js/three/GLTFLoader.js';
import { OrbitControls } from '/js/three/OrbitControls.js';

const container = document.getElementById('model-container');
const loadingEl = document.getElementById('modelLoading');
const loadingTx = document.getElementById('loadingText');
const statusEl  = document.getElementById('modelStatus');

const renderer = new THREE.WebGLRenderer({ antialias:true, alpha:true, preserveDrawingBuffer:true });
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.setSize(container.clientWidth, container.clientHeight);
renderer.outputEncoding      = THREE.sRGBEncoding;
renderer.toneMapping         = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.05;
renderer.shadowMap.enabled   = true;
renderer.shadowMap.type      = THREE.PCFSoftShadowMap;
renderer.setClearColor(0x000000, 0); // transparent — let CSS background show
container.appendChild(renderer.domElement);
const scene  = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(36, container.clientWidth / container.clientHeight, 0.01, 100);
camera.position.set(0, 1.8, 8.5);
const controls = new OrbitControls(camera, renderer.domElement);
const pmrem  = new THREE.PMREMGenerator(renderer);
pmrem.compileEquirectangularShader();
(function buildEnv(){
    const W=256, H=128, data=new Uint8Array(W*H*4);
    for(let y=0;y<H;y++) for(let x=0;x<W;x++){
        const nx=(x/W)*2-1, ny=1-(y/H)*2;
        const topWarm=Math.max(0, ny)*0.6;
        const sunX=nx-0.75, sunY=ny-0.55;
        const sun=Math.max(0, 1-Math.sqrt(sunX*sunX*2+sunY*sunY*3)*1.4)*0.9;
        const ambient=0.55;
        const r=Math.min(255, Math.round(200+topWarm*30+sun*55+ambient*25));
        const g=Math.min(255, Math.round(155+topWarm*20+sun*35+ambient*15));
        const b=Math.min(255, Math.round(75 +topWarm*8 +sun*10+ambient*5));
        const i=(y*W+x)*4;
        data[i]=r; data[i+1]=g; data[i+2]=b; data[i+3]=255;
    }
    const tex=new THREE.DataTexture(data,W,H,THREE.RGBAFormat);
    tex.needsUpdate=true;
    scene.environment=pmrem.fromEquirectangular(tex).texture;
    scene.environmentIntensity=0.80;
    tex.dispose(); pmrem.dispose();
})();

// ── 3 SPOTLIGHTS — angled stage-light style ──
// Each light comes from high up and to the side, aimed at the cake center
// like the reference image: left, center, right positions at the top
const STAGE_LIGHTS = [
    { pos: [-3.5, 5.5, 2.0] },   // left
    { pos: [ 0.0, 6.0, 2.5] },   // center
    { pos: [ 3.5, 5.5, 2.0] },   // right
];

let _spotBrightness = 0.35; // 0.0 – 1.0, user-adjustable

const spotLights = STAGE_LIGHTS.map((cfg, i) => {
const spot = new THREE.SpotLight(0xD8E8FF, 1.8 * _spotBrightness);
spot.position.set(...cfg.pos);
spot.angle      = 0.18;
spot.penumbra   = 0.55;
spot.decay      = 2.8;
    spot.castShadow = (i === 1); // only center casts shadow
    if(i === 1){
        spot.shadow.mapSize.set(2048, 2048);
        spot.shadow.camera.near = 0.5;
        spot.shadow.camera.far  = 18;
        spot.shadow.bias        = -0.0003;
        spot.shadow.normalBias  = 0.04;
        spot.shadow.radius      = 6;
    }
    spot.target.position.set(0, -0.2, 0);
    scene.add(spot);
    scene.add(spot.target);
    return spot;
});

const sunLight = spotLights[1]; // center light as legacy ref

window._setSpotBrightness = function(val) {
    _spotBrightness = Math.max(0, Math.min(1, val));
    spotLights.forEach(s => { s.intensity = 1.8 * _spotBrightness; });
};

// ── SOFT AMBIENT FILL ──
const bounceFill = new THREE.PointLight(0xE8C870, 0.8);
bounceFill.position.set(0, -0.8, 0);
scene.add(bounceFill);
const fillLight = new THREE.DirectionalLight(0xF0C878, 0.10);
fillLight.position.set(-5, 5, 3); scene.add(fillLight);
const tableBouce = new THREE.DirectionalLight(0xD4904A, 0.15);
tableBouce.position.set(0, -2, 2); scene.add(tableBouce);
const backWall = new THREE.DirectionalLight(0xE8C870, 0.08);
backWall.position.set(1, 3, -8); scene.add(backWall);
scene.add(new THREE.AmbientLight(0xC89840, 0.20));

const tableMat = new THREE.MeshStandardMaterial({ color: 0x7A6040, roughness: 0.55, metalness: 0.0, envMapIntensity: 0.50 });
const tableTop = new THREE.Mesh(new THREE.PlaneGeometry(22, 22), tableMat);
tableTop.rotation.x=-Math.PI/2; tableTop.position.y=-1.20;
tableTop.receiveShadow=true; scene.add(tableTop);

(function buildTileGrid(){
    const S=512, tileSize=32;
    const tdata=new Uint8Array(S*S*4);
    for(let y=0;y<S;y++) for(let x=0;x<S;x++){
        const tx=x%tileSize, ty=y%tileSize;
        const isGrout=tx<2||ty<2;
        const noise=(Math.sin(x*0.31+y*0.17)*0.5+0.5)*0.08;
        const baseR=isGrout?55:90+Math.round(noise*28);
        const baseG=isGrout?38:62+Math.round(noise*18);
        const baseB=isGrout?20:30+Math.round(noise*10);
        const i=(y*S+x)*4;
        tdata[i]=baseR; tdata[i+1]=baseG; tdata[i+2]=baseB; tdata[i+3]=255;
    }
    const ttex=new THREE.DataTexture(tdata,S,S,THREE.RGBAFormat);
    ttex.needsUpdate=true; ttex.wrapS=ttex.wrapT=THREE.RepeatWrapping;
    ttex.repeat.set(8,8);
    const tileMat=new THREE.MeshStandardMaterial({ map:ttex, roughness:0.48, metalness:0.02, envMapIntensity:0.45 });
    const tileMesh=new THREE.Mesh(new THREE.PlaneGeometry(20,20),tileMat);
    tileMesh.rotation.x=-Math.PI/2; tileMesh.position.y=-1.195;
    tileMesh.receiveShadow=true; scene.add(tileMesh);
})();

const shadowCatcher = new THREE.Mesh(
    new THREE.PlaneGeometry(12,12),
    new THREE.ShadowMaterial({opacity:0.40, transparent:true})
);
shadowCatcher.rotation.x=-Math.PI/2; shadowCatcher.position.y=-1.18;
shadowCatcher.receiveShadow=true; scene.add(shadowCatcher);
// ── VISIBLE SPOTLIGHT FIXTURE ──
// ── VISIBLE SPOTLIGHT FIXTURE ──
(function buildSpotlight(){
// Stage light fixture positions — matches the 3 SpotLight positions above
    const FIXTURE_POSITIONS = [
        [-3.5, 5.5, 2.0],
        [ 0.0, 6.0, 2.5],
        [ 3.5, 5.5, 2.0],
    ];
    // ── Build geometry arrays for the light cone FIRST ──
    const coneH = 4.8, coneR = 1.35, coneSegs = 48, coneRings = 28;
    const positions = [], colors = [], indices = [];

    positions.push(0, 0, 0);
    colors.push(1.0, 0.92, 0.55, 0.72);

    for(let ring = 0; ring < coneRings; ring++){
        const t = (ring + 1) / coneRings;
        const y = -t * coneH;
        const r = t * coneR;
        const alpha = Math.pow(1 - t, 1.8) * 0.55;
        const brightness = 1.0 - t * 0.35;
        for(let seg = 0; seg <= coneSegs; seg++){
            const angle = (seg / coneSegs) * Math.PI * 2;
            positions.push(Math.cos(angle) * r, y, Math.sin(angle) * r);
            colors.push(brightness * 1.0, brightness * 0.90, brightness * 0.50, alpha);
        }
    }
    for(let seg = 0; seg < coneSegs; seg++){
        indices.push(0, 1 + seg, 1 + seg + 1);
    }
    for(let ring = 0; ring < coneRings - 1; ring++){
        const rowStart = 1 + ring * (coneSegs + 1);
        const nextRowStart = rowStart + (coneSegs + 1);
        for(let seg = 0; seg < coneSegs; seg++){
            const a = rowStart + seg, b = rowStart + seg + 1;
            const c = nextRowStart + seg, d = nextRowStart + seg + 1;
            indices.push(a, b, c); indices.push(b, d, c);
        }
    }

    const coneMat = new THREE.MeshBasicMaterial({
        vertexColors: true, transparent: true, opacity: 1.0,
        depthWrite: false, side: THREE.DoubleSide, blending: THREE.AdditiveBlending,
    });
    const haloMat = new THREE.MeshBasicMaterial({
        color: 0xFFDD66, transparent: true, opacity: 0.18,
        depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide,
    });
    const poolMat = new THREE.MeshBasicMaterial({
        color: 0xFFEE88, transparent: true, opacity: 0.10,
        depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide,
    });

    // ── Build one fixture group (reused via clone) ──
    const fixtureGroup = new THREE.Group();

    const housingMat = new THREE.MeshStandardMaterial({ color: 0x1A1A1A, roughness: 0.3, metalness: 0.85, envMapIntensity: 0.9 });
    const housing = new THREE.Mesh(new THREE.CylinderGeometry(0.18, 0.22, 0.32, 32), housingMat);
    housing.castShadow = true; fixtureGroup.add(housing);

    const reflectorMat = new THREE.MeshStandardMaterial({ color: 0xFFEEAA, roughness: 0.05, metalness: 1.0, envMapIntensity: 1.5 });
    const reflectorPts = [];
    for(let i = 0; i <= 14; i++){
        const t = i / 14;
        reflectorPts.push(new THREE.Vector2(0.19 * Math.pow(t, 0.6), -0.14 + t * 0.13));
    }
    fixtureGroup.add(new THREE.Mesh(new THREE.LatheGeometry(reflectorPts, 32), reflectorMat));

    const bulbMat = new THREE.MeshStandardMaterial({
        color: 0xFFEE88, emissive: new THREE.Color(0xFFDD55),
        emissiveIntensity: 3.5, roughness: 0.0, metalness: 0.0, transparent: true, opacity: 0.95
    });
    const bulb = new THREE.Mesh(new THREE.SphereGeometry(0.055, 16, 16), bulbMat);
    bulb.position.y = -0.08; fixtureGroup.add(bulb);

    const rimMat = new THREE.MeshStandardMaterial({ color: 0x2A2A2A, roughness: 0.2, metalness: 0.9 });
    const rim = new THREE.Mesh(new THREE.TorusGeometry(0.22, 0.022, 10, 40), rimMat);
    rim.position.y = -0.16; rim.rotation.x = Math.PI / 2; fixtureGroup.add(rim);

    const armMat = new THREE.MeshStandardMaterial({ color: 0x111111, roughness: 0.4, metalness: 0.8 });
    const arm = new THREE.Mesh(new THREE.CylinderGeometry(0.035, 0.035, 0.55, 12), armMat);
    arm.position.y = 0.44; fixtureGroup.add(arm);

    const mountMat = new THREE.MeshStandardMaterial({ color: 0x0A0A0A, roughness: 0.5, metalness: 0.7 });
    const mount = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.12, 0.06, 24), mountMat);
    mount.position.y = 0.72; fixtureGroup.add(mount);
FIXTURE_POSITIONS.forEach(([fx, fy, fz]) => {
        const clone = fixtureGroup.clone(true);
        clone.position.set(fx, fy, fz);
        // Tilt fixture to point toward cake center
        clone.lookAt(0, -0.2, 0);
        clone.rotateX(-Math.PI / 2); // correct for cylinder orientation
        scene.add(clone);

        // Cone tip starts at fixture, points toward cake
        const target = new THREE.Vector3(0, -0.2, 0);
        const origin = new THREE.Vector3(fx, fy, fz);
        const dir = target.clone().sub(origin).normalize();
        const coneLength = origin.distanceTo(target);

        const coneGeo = new THREE.BufferGeometry();
        const cp = [], cc = [], ci = [];
        const cSegs = 32, cRings = 20;
        const cRadius = coneLength * Math.tan(0.28); // match spot angle

        cp.push(0, 0, 0);
        cc.push(1.0, 0.95, 0.85, 0.65);

        for(let ring = 0; ring < cRings; ring++){
            const t = (ring + 1) / cRings;
            const cy2 = -t * coneLength;
            const cr = t * cRadius;
            const alpha = Math.pow(1 - t, 1.6) * 0.45;
            const bright = 1.0 - t * 0.4;
            for(let seg = 0; seg <= cSegs; seg++){
                const a = (seg / cSegs) * Math.PI * 2;
                cp.push(Math.cos(a) * cr, cy2, Math.sin(a) * cr);
                cc.push(bright, bright * 0.92, bright * 0.78, alpha);
            }
        }
        for(let seg = 0; seg < cSegs; seg++) ci.push(0, 1 + seg, 1 + seg + 1);
        for(let ring = 0; ring < cRings - 1; ring++){
            const rs = 1 + ring * (cSegs + 1), ns = rs + (cSegs + 1);
            for(let seg = 0; seg < cSegs; seg++){
                const a=rs+seg, b=rs+seg+1, c2=ns+seg, d=ns+seg+1;
                ci.push(a,b,c2); ci.push(b,d,c2);
            }
        }

        coneGeo.setAttribute('position', new THREE.Float32BufferAttribute(cp, 3));
        coneGeo.setAttribute('color',    new THREE.Float32BufferAttribute(cc, 4));
        coneGeo.setIndex(ci);
        coneGeo.computeVertexNormals();

        const coneMesh = new THREE.Mesh(coneGeo, coneMat);
        coneMesh.position.set(fx, fy, fz);
        // Orient cone to point from fixture toward cake
        const quaternion = new THREE.Quaternion();
        quaternion.setFromUnitVectors(new THREE.Vector3(0, -1, 0), dir);
        coneMesh.setRotationFromQuaternion(quaternion);
        scene.add(coneMesh);

        const halo = new THREE.Mesh(new THREE.CircleGeometry(0.22, 24), haloMat);
        halo.position.set(fx, fy - 0.05, fz);
        halo.lookAt(fx, fy + 1, fz);
        scene.add(halo);
    });

})();

controls.enableDamping    = true;
controls.dampingFactor    = 0.08;
controls.enablePan        = false;
controls.enableZoom       = true;
controls.zoomSpeed        = 0.8;
controls.rotateSpeed      = 0.6;
controls.autoRotate       = false;
controls.screenSpacePanning = false;
controls.minDistance      = 1.8;
controls.maxDistance      = 10.0;
controls.maxPolarAngle    = Math.PI / 2.1;
controls.target.set(0, -0.30, 0);
controls.saveState();
controls.update();
const clock = new THREE.Clock();
const mixers = [];
// ── Procedural Fire Texture ──
function makeFlameSpriteTex(size = 128) {
    const canvas = document.createElement('canvas');
    canvas.width = size; canvas.height = size;
    const ctx = canvas.getContext('2d');
    const imgData = ctx.createImageData(size, size);
    const d = imgData.data;
    for (let py = 0; py < size; py++) {
        for (let px = 0; px < size; px++) {
            const idx = (py * size + px) * 4;
            const fx = (px / size) - 0.5;
            const fy = py / size; // 0=tip(top), 1=base(bottom)
            // Teardrop half-width: 0 at tip, peak at 60%, narrows at base
            let hw = fy <= 0.60
                ? 0.42 * Math.sin(fy / 0.60 * Math.PI / 2)
                : 0.42 * Math.cos((fy - 0.60) / 0.40 * Math.PI / 2);
            hw = Math.max(hw, 0);
            if (hw < 0.001 || Math.abs(fx) > hw) { d[idx+3] = 0; continue; }
            const nd = Math.abs(fx) / hw;
            const edgeFade = Math.pow(1 - nd, 0.5);
            const heat = edgeFade * (0.15 + (1 - fy) * 0.85);
            let r, g, b;
            if (heat > 0.80) {
                const t = (heat - 0.80) / 0.20;
                r = 255; g = Math.round(220 + t * 35); b = Math.round(100 + t * 155);
            } else if (heat > 0.55) {
                const t = (heat - 0.55) / 0.25;
                r = 255; g = Math.round(140 + t * 80); b = 0;
            } else if (heat > 0.30) {
                const t = (heat - 0.30) / 0.25;
                r = 255; g = Math.round(40 + t * 100); b = 0;
            } else if (heat > 0.12) {
                const t = (heat - 0.12) / 0.18;
                r = Math.round(150 + t * 105); g = Math.round(t * 40); b = 0;
            } else {
                r = Math.round((heat / 0.12) * 150); g = 0; b = 0;
            }
            d[idx] = r; d[idx+1] = g; d[idx+2] = b;
            d[idx+3] = Math.min(255, Math.round(edgeFade * Math.pow(heat, 0.45) * 235));
        }
    }
    ctx.putImageData(imgData, 0, 0);
    return new THREE.CanvasTexture(canvas);
}

const _flameLookVec = new THREE.Vector3();
function buildFlameGroup(height = 0.22) {
    const group = new THREE.Group();
    group.userData.isFlameGroup = true;
    const tex = makeFlameSpriteTex(128);
    // Outer glow layer
    const outerGeo = new THREE.PlaneGeometry(height * 0.58, height);
    const outerMat = new THREE.MeshBasicMaterial({ map: tex, transparent: true, opacity: 0.78, depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide });
    const outer = new THREE.Mesh(outerGeo, outerMat);
    outer.position.y = height * 0.5;
    outer.userData.isFlameLayer = true;

    outer.userData.flickerSeedF = Math.random() * Math.PI * 2;
    group.add(outer);
    // Inner bright core
    const innerGeo = new THREE.PlaneGeometry(height * 0.32, height * 0.75);
    const innerMat = new THREE.MeshBasicMaterial({ map: tex.clone(), transparent: true, opacity: 0.96, depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide });
    innerMat.map.needsUpdate = true;
    const inner = new THREE.Mesh(innerGeo, innerMat);
    inner.position.y = height * 0.44;
    inner.userData.isFlameLayer = true;

    inner.userData.flickerSeedF = Math.random() * Math.PI * 2 + 1.0;
    group.add(inner);
    // Point light
    const fl = new THREE.PointLight(0xFF7722, 1.8, 0.9);
    fl.position.set(0, height * 0.3, 0);
    fl.userData.isFlameLight = true;
    group.add(fl);
    return group;
}
function animate(){
    requestAnimationFrame(animate);
    const delta = clock.getDelta();
// Inside animate(), replace the scene.traverse flame block:
const elapsed = clock.elapsedTime;
scene.traverse(node => {

    if (node.userData && node.userData.isFlameLayer) {
        const seed = node.userData.flickerSeedF || 0;
        const t = elapsed + seed;
        node.scale.x = 1.0 + 0.10 * Math.sin(t * 11.3);
        node.scale.y = 1.0 + 0.06 * Math.sin(t *  7.8 + 1.2);
        node.rotation.z = 0.06 * Math.sin(t * 9.1 + seed);
    }
    if (node.userData && node.userData.isFlameLight) {
        node.intensity = 1.4 + 0.8 * Math.sin(elapsed * 13.2 + node.id)
                             + 0.4 * Math.sin(elapsed * 21.7 + node.id * 2.1);
    }
});

    // ── Procedural flame flicker ──
    scene.traverse(node => {
        if(!node.userData || !node.userData.isFlame) return;
        const t = elapsed + (node.userData.flickerSeed || 0);
        node.scale.y  = 1.0 + 0.18 * Math.sin(t * 13.0) + 0.09 * Math.sin(t * 21.7);
        node.scale.x  = 1.0 + 0.06 * Math.sin(t * 9.3);
        node.rotation.z = 0.07 * Math.sin(t * 8.5);
        node.rotation.x = 0.04 * Math.sin(t * 11.2);
       if(node.material){
            node.material.opacity = 0.80 + 0.18 * Math.sin(t * 10.0);
        }
    });

controls.update(delta);
    renderer.render(scene, camera);
}
animate();

// ── Shape slug map — must match GLB filenames exactly ──
const SHAPE_SLUG = {
    'Round':         'round',
    'Square':        'square',
    'Heart':         'heart',
    'Two-tier Round':'two-tier',
    'Three-tier Round':'three-tier',
};

function getFrostingFileSuffix(arr){
    if(arr.includes('Fondant Smooth')) return 'fondant';
    const s=arr.includes('Smooth Buttercream'), t=arr.includes('Textured Buttercream');
    if(s&&t) return 'smoothandtextured';
    if(t)    return 'textured';
    return 'smooth';
}
function shouldLoadFrostingGLB(arr){ return arr.some(f=>f!=='Sugar Icing'); }
function isFondantOnly(arr){ return arr.includes('Fondant Smooth'); }

const FLAVORS={
    'Vanilla':   {sponge:{hex:'#C8822A',roughness:.82,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#9A5A14',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#EEC840',roughness:.46,metalness:.02,envMapIntensity:.65},top:{hex:'#F8D450',roughness:.36,metalness:.03,envMapIntensity:.72},drip:{hex:'#ECBC28',roughness:.14,metalness:.04}},
    'Chocolate': {sponge:{hex:'#361004',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#200802',roughness:.92,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#5A1E0E',roughness:.38,metalness:.06,envMapIntensity:.70},top:{hex:'#6C2610',roughness:.30,metalness:.08,envMapIntensity:.78},drip:{hex:'#320E06',roughness:.10,metalness:.10}},
    'Red Velvet':{sponge:{hex:'#880E0E',roughness:.84,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#680606',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#F6EEEA',roughness:.36,metalness:.01,envMapIntensity:.70},top:{hex:'#FFF6F2',roughness:.28,metalness:.01,envMapIntensity:.78},drip:{hex:'#BE0E0E',roughness:.14,metalness:.02}},
    'Strawberry':{sponge:{hex:'#CC2454',roughness:.82,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#A4163C',roughness:.86,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#FF4474',roughness:.40,metalness:.01,envMapIntensity:.62},top:{hex:'#FF5680',roughness:.32,metalness:.01,envMapIntensity:.70},drip:{hex:'#DE2454',roughness:.12,metalness:.02}},
    'Ube':       {sponge:{hex:'#481C7C',roughness:.84,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#301260',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#8638C8',roughness:.38,metalness:.04,envMapIntensity:.68},top:{hex:'#9644D6',roughness:.30,metalness:.05,envMapIntensity:.76},drip:{hex:'#5E24AC',roughness:.12,metalness:.05}},
    'Mocha':     {sponge:{hex:'#220E00',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#140600',roughness:.92,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#7A451E',roughness:.38,metalness:.06,envMapIntensity:.66},top:{hex:'#8A4F24',roughness:.30,metalness:.07,envMapIntensity:.74},drip:{hex:'#582C0E',roughness:.12,metalness:.07}},
};
const DRIP_FLAVOR_COLORS={
    'Vanilla':'#ECBC28','Chocolate':'#320E06','Red Velvet':'#BE0E0E',
    'Strawberry':'#DE2454','Ube':'#5E24AC','Mocha':'#582C0E',
    'Caramel':'#D08010','White Chocolate':'#F8EED8',
};
// Fondant colors per flavor — thick matte sugar paste tones
const FONDANT_FLAVOR_COLORS={
    'Vanilla':   '#F5F0DC',
    'Chocolate': '#4A2210',
    'Red Velvet':'#8B1A1A',
    'Strawberry':'#E8607A',
    'Ube':       '#7A3FAA',
    'Mocha':     '#6B3A1E',
};
// Sugar icing colors — richer mid-tone versions
const SUGAR_ICING_COLORS={
    '#FFFFFF':'#F8F6F2',
    '#FFF0C8':'#F5E8B0',
    '#FFCCE0':'#F0A0BC',
    '#C8E6FF':'#90C8F0',
    '#D4C8FF':'#B0A0E8',
    '#C8FFD8':'#90DCA8',
    '#FFD8A8':'#F0B870',
    '#F5C842':'#E8B020',
};
const FROSTING_STYLES={
    'Smooth Buttercream':  {roughness:.42,metalness:.01,envBoost:.12},
    'Textured Buttercream':{roughness:.70,metalness:.00,envBoost:-.04},
    'Fondant Smooth':      {roughness:.18,metalness:.02,envBoost:.28},
    'Chocolate Ganache':   {roughness:.05,metalness:.10,envBoost:.42},
    'Semi-naked Style':    {roughness:.80,metalness:.00,envBoost:-.12,opacity:.68},
    'Sugar Icing':         {roughness:.14,metalness:.02,envBoost:.34},
};

function applyGLBMaterial(group,colorHex,roughness,metalness,opacity,envMapIntensity,emissiveHex='#000'){
    group.traverse(child=>{
        if(!child.isMesh) return;
        child.material=new THREE.MeshStandardMaterial({
            color:new THREE.Color(colorHex), roughness, metalness,
            transparent:opacity<1.0, opacity, envMapIntensity:envMapIntensity??0.6,
            emissive:new THREE.Color(emissiveHex), emissiveIntensity:.05
        });
        child.castShadow=child.receiveShadow=true;
    });
}
function recolorGLB(flavorName,frostingsArr,dripFlavor,icingColorHex){
    const pal=FLAVORS[flavorName]||FLAVORS['Vanilla'];
    const hasTextured=frostingsArr.includes('Textured Buttercream');
    const hasSmooth  =frostingsArr.includes('Smooth Buttercream');
    const styleName  =hasTextured?'Textured Buttercream':hasSmooth?'Smooth Buttercream':(frostingsArr.filter(f=>f!=='Sugar Icing')[0]||'Smooth Buttercream');
    const style      =FROSTING_STYLES[styleName]||FROSTING_STYLES['Smooth Buttercream'];
    const frostEnv   =Math.max(.20,(pal.top.envMapIntensity??0.6)+style.envBoost);
    if(currentBase)  applyGLBMaterial(currentBase,  pal.crust.hex, pal.crust.roughness, pal.crust.metalness??0, 1.0, .45, pal.sponge.emissive??'#000');
    if(currentFrost){
       if(frostingsArr.includes('Fondant Smooth')){
    const fondantHex = FONDANT_FLAVOR_COLORS[flavorName] || '#F5F0DC';
    currentFrost.traverse(child => {
        if(!child.isMesh) return;

        // ── Dispose old material/textures to avoid memory leak ──
        if(child.material){
            if(child.material.map)        child.material.map.dispose();
            if(child.material.normalMap)  child.material.normalMap.dispose();
            if(child.material.roughnessMap) child.material.roughnessMap.dispose();
            child.material.dispose();
        }

        // ── Per-flavor texture profile ──
        const FONDANT_PROFILES = {
            'Vanilla': {
                roughness: 0.25, envMapIntensity: 0.60,
                // Smooth with faint silk-like sheen — very fine grain
                normalStrength: 0.08,
                roughnessVariance: 0.04,
                pattern: 'silk',       // fine horizontal ripple
                emissiveIntensity: 0.05,
            },
            'Chocolate': {
                roughness: 0.38, envMapIntensity: 0.42,
                // Cocoa fondant is slightly matte, faint grainy texture
                normalStrength: 0.18,
                roughnessVariance: 0.12,
                pattern: 'cocoa',      // fine random grain
                emissiveIntensity: 0.03,
            },
            'Red Velvet': {
                roughness: 0.28, envMapIntensity: 0.52,
                // Cream cheese hue — very smooth, slight velvet micro-texture
                normalStrength: 0.12,
                roughnessVariance: 0.06,
                pattern: 'velvet',     // tiny diamond micro-pattern
                emissiveIntensity: 0.06,
            },
            'Strawberry': {
                roughness: 0.22, envMapIntensity: 0.65,
                // Fruit fondant — smooth and slightly glossy, tiny pore pattern
                normalStrength: 0.10,
                roughnessVariance: 0.05,
                pattern: 'pore',       // scattered micro-dots
                emissiveIntensity: 0.07,
            },
            'Ube': {
                roughness: 0.30, envMapIntensity: 0.58,
                // Ube fondant — slightly starchy, subtle swirl pattern
                normalStrength: 0.15,
                roughnessVariance: 0.08,
                pattern: 'swirl',      // soft wave swirls
                emissiveIntensity: 0.05,
            },
            'Mocha': {
                roughness: 0.35, envMapIntensity: 0.45,
                // Coffee fondant — matte with fine espresso grain
                normalStrength: 0.20,
                roughnessVariance: 0.14,
                pattern: 'espresso',   // coarse random grain
                emissiveIntensity: 0.03,
            },
        };

        const profile = FONDANT_PROFILES[flavorName] || FONDANT_PROFILES['Vanilla'];

        // ── Generate procedural normal map on canvas ──
        function makeFondantNormalMap(pattern, size = 256) {
            const canvas = document.createElement('canvas');
            canvas.width = canvas.height = size;
            const ctx = canvas.getContext('2d');
            const imgData = ctx.createImageData(size, size);
            const d = imgData.data;

            for(let y = 0; y < size; y++){
                for(let x = 0; x < size; x++){
                    const i = (y * size + x) * 4;
                    let nx = 128, ny = 128, nz = 255; // flat normal default

                    const fx = x / size, fy = y / size;

                    if(pattern === 'silk'){
                        // Fine horizontal ripple — like stretched sugar sheet
                        const wave = Math.sin(fy * 180 + Math.sin(fx * 40) * 2) * 0.5 + 0.5;
                        const wave2 = Math.sin(fx * 120 + fy * 30) * 0.3;
                        nx = 128 + (wave - 0.5) * 18;
                        ny = 128 + wave2 * 12;
                        nz = 235 + wave * 20;
                    }
                    else if(pattern === 'cocoa'){
                        // Random grain — like cocoa powder mixed in
                        const grain = (
                            Math.sin(x * 7.3 + y * 3.1) *
                            Math.cos(x * 2.9 + y * 8.7) +
                            Math.sin(x * 13.1 + y * 5.3) * 0.4
                        );
                        nx = 128 + grain * 28;
                        ny = 128 + Math.cos(x * 5.1 + y * 9.7) * 22;
                        nz = 220 + Math.abs(grain) * 35;
                    }
                    else if(pattern === 'velvet'){
                        // Diamond micro-pattern — like velvet fabric
                        const dx = Math.abs((x % 16) - 8) / 8;
                        const dy = Math.abs((y % 16) - 8) / 8;
                        const diamond = Math.max(0, 1 - (dx + dy));
                        const noise = Math.sin(x * 11.3 + y * 7.7) * 0.25;
                        nx = 128 + (dx - 0.5) * 24 + noise * 10;
                        ny = 128 + (dy - 0.5) * 24 + noise * 10;
                        nz = 220 + diamond * 35;
                    }
                    else if(pattern === 'pore'){
                        // Scattered micro-pores — like fruit fondant surface
                        const px = x % 24, py = y % 24;
                        const cx2 = 12, cy2 = 12;
                        const dist = Math.sqrt((px-cx2)**2 + (py-cy2)**2);
                        const pore = dist < 5 ? (1 - dist/5) : 0;
                        const noise = Math.sin(x * 17.3 + y * 11.1) * 0.15;
                        nx = 128 + (px - cx2) * pore * 5 + noise * 8;
                        ny = 128 + (py - cy2) * pore * 5 + noise * 8;
                        nz = 230 + (1 - pore) * 25;
                    }
                    else if(pattern === 'swirl'){
                        // Flowing swirl — like ube's starchy character
                        const angle = Math.atan2(fy - 0.5, fx - 0.5);
                        const r = Math.sqrt((fx-0.5)**2 + (fy-0.5)**2);
                        const swirl = Math.sin(angle * 4 + r * 20) * 0.5 +
                                      Math.cos(r * 35 + angle * 2) * 0.3;
                        nx = 128 + swirl * 26;
                        ny = 128 + Math.cos(angle * 3 + r * 18) * 20;
                        nz = 215 + (swirl * 0.5 + 0.5) * 40;
                    }
                    else if(pattern === 'espresso'){
                        // Coarse random grain — like ground coffee texture
                        const g1 = Math.sin(x * 4.7 + y * 9.3) * Math.sin(x * 11.1 - y * 3.7);
                        const g2 = Math.cos(x * 7.3 - y * 5.1) * 0.5;
                        const g3 = Math.sin((x+y) * 6.3) * 0.3;
                        nx = 128 + (g1 + g2) * 32;
                        ny = 128 + (g2 + g3) * 28;
                        nz = 200 + Math.abs(g1) * 55;
                    }

                    d[i]   = Math.max(0, Math.min(255, Math.round(nx)));
                    d[i+1] = Math.max(0, Math.min(255, Math.round(ny)));
                    d[i+2] = Math.max(0, Math.min(255, Math.round(nz)));
                    d[i+3] = 255;
                }
            }
            ctx.putImageData(imgData, 0, 0);
            const tex = new THREE.CanvasTexture(canvas);
            tex.wrapS = tex.wrapT = THREE.RepeatWrapping;
            tex.repeat.set(3, 3);
            return tex;
        }

        // ── Generate roughness variation map ──
        function makeFondantRoughnessMap(variance, size = 256) {
            const canvas = document.createElement('canvas');
            canvas.width = canvas.height = size;
            const ctx = canvas.getContext('2d');
            const imgData = ctx.createImageData(size, size);
            const d = imgData.data;
            const base = Math.round(profile.roughness * 255);

            for(let y = 0; y < size; y++){
                for(let x = 0; x < size; x++){
                    const i = (y * size + x) * 4;
                    const noise = (
                        Math.sin(x * 0.08 + y * 0.05) * 0.5 +
                        Math.sin(x * 0.21 + y * 0.13) * 0.3 +
                        Math.sin(x * 0.41 - y * 0.29) * 0.2
                    ) * variance * 255;
                    const val = Math.max(0, Math.min(255, base + noise));
                    d[i] = d[i+1] = d[i+2] = val;
                    d[i+3] = 255;
                }
            }
            ctx.putImageData(imgData, 0, 0);
            const tex = new THREE.CanvasTexture(canvas);
            tex.wrapS = tex.wrapT = THREE.RepeatWrapping;
            tex.repeat.set(3, 3);
            return tex;
        }

        const normalMap    = makeFondantNormalMap(profile.pattern);
        const roughnessMap = makeFondantRoughnessMap(profile.roughnessVariance);

        child.material = new THREE.MeshStandardMaterial({
            color:             new THREE.Color(fondantHex),
            roughness:         profile.roughness,
            metalness:         0.00,
            envMapIntensity:   profile.envMapIntensity,
            normalMap:         normalMap,
            normalScale:       new THREE.Vector2(profile.normalStrength, profile.normalStrength),
            roughnessMap:      roughnessMap,
            emissive:          new THREE.Color(fondantHex),
            emissiveIntensity: profile.emissiveIntensity,
        });
        child.castShadow    = true;
        child.receiveShadow = true;
    });
} else {
            applyGLBMaterial(currentFrost, pal.frosting.hex, style.roughness, style.metalness, style.opacity??1.0, frostEnv);
        }
    }
    if(currentIcing){
        const icingRich = SUGAR_ICING_COLORS[icingColorHex] || icingColorHex || '#F8F6F2';
        applyGLBMaterial(currentIcing, icingRich, 0.12, 0.02, 1.0, 0.88);
    }
    if(currentDrip)  applyGLBMaterial(currentDrip,  dripFlavor?(DRIP_FLAVOR_COLORS[dripFlavor]||pal.drip.hex):pal.drip.hex, pal.drip.roughness??0.10, pal.drip.metalness??0.05, 1.0, .80);
}

function buildCakePlateStand(cakeRadius){
    const g = new THREE.Group();
    const r = Math.max(1.15, cakeRadius * 1.18);
    const SEGS = 128;
    const plateMat = new THREE.MeshStandardMaterial({ color: 0xF5EEE0, roughness: 0.22, metalness: 0.01, envMapIntensity: 0.75 });
    const baseMat  = new THREE.MeshStandardMaterial({ color: 0xEDE4D0, roughness: 0.28, metalness: 0.01, envMapIntensity: 0.65 });
    const platePts = [];
    for(let i=0;i<=20;i++){const t=i/20;const pr=r*(1-t*t*0.04);const py=0.018*Math.sin(t*Math.PI*0.5);platePts.push(new THREE.Vector2(pr,py));}
    platePts.push(new THREE.Vector2(0,0.018));
    const plateGeo = new THREE.LatheGeometry(platePts, SEGS);
    const plateMesh = new THREE.Mesh(plateGeo, plateMat);
    plateMesh.castShadow=true; plateMesh.receiveShadow=true; g.add(plateMesh);
    const rimGeo = new THREE.TorusGeometry(r*0.97, 0.022, 10, SEGS);
    const rimMesh = new THREE.Mesh(rimGeo, plateMat);
    rimMesh.rotation.x=Math.PI/2; rimMesh.position.y=0.010; rimMesh.castShadow=true; g.add(rimMesh);
    const undersideGeo = new THREE.CylinderGeometry(r*0.98, r*0.97, 0.028, SEGS);
    const undersideMesh = new THREE.Mesh(undersideGeo, baseMat);
    undersideMesh.position.y=-0.014; undersideMesh.castShadow=true; g.add(undersideMesh);
    const pedestalH = 0.20;
    const pedestalPts = [];
    for(let i=0;i<=12;i++){const t=i/12;const curve = 1 - Math.sin(t*Math.PI)*0.22;const pr2 = (0.14 + (1-t)*0.06) * curve;pedestalPts.push(new THREE.Vector2(pr2, -t*pedestalH));}
    const pedestalGeo = new THREE.LatheGeometry(pedestalPts, SEGS);
    const pedestalMesh = new THREE.Mesh(pedestalGeo, baseMat);
    pedestalMesh.castShadow=true; g.add(pedestalMesh);
    const baseR = r * 0.52; const baseH = 0.040;
    const basePts = [];
    basePts.push(new THREE.Vector2(0, 0));
    for(let i=0;i<=16;i++){const t=i/16;const bevel = i < 3 ? baseR*(0.88+t*0.04) : baseR;const by = i < 3 ? (i/3)*0.015 : 0.015 + (t-3/16)*baseH;basePts.push(new THREE.Vector2(bevel, -pedestalH-by));}
    basePts.push(new THREE.Vector2(0, -pedestalH-baseH-0.015));
    const baseGeo = new THREE.LatheGeometry(basePts, SEGS);
    const baseMesh2 = new THREE.Mesh(baseGeo, baseMat);
    baseMesh2.castShadow=true; baseMesh2.receiveShadow=true; g.add(baseMesh2);
    const ringGeo = new THREE.TorusGeometry(0.165, 0.014, 8, SEGS);
    const ringMesh = new THREE.Mesh(ringGeo, plateMat);
    ringMesh.rotation.x=Math.PI/2; ringMesh.position.y=-pedestalH-0.001; ringMesh.castShadow=true; g.add(ringMesh);
    return g;
}

function showStatus(msg){statusEl.textContent=msg;statusEl.classList.remove('hidden');clearTimeout(window._stTimer);window._stTimer=setTimeout(()=>statusEl.classList.add('hidden'),3500);}

const glbCache={};
const sceneRoot=new THREE.Group();
scene.add(sceneRoot);
let loadedKey='', currentBase=null, currentFrost=null, currentDrip=null, currentIcing=null;
let isLoading=false, pendingState=null;
const fruitModels=[];
const ferreroModels=[];
const kitkatModels=[];
const oreoModels=[];
const candleModels=[];

function loadGLB(url){
    return new Promise((resolve,reject)=>{
        if(glbCache[url]){resolve(glbCache[url].clone(true));return;}
        new GLTFLoader().load(url, gltf=>{glbCache[url]=gltf.scene;resolve(gltf.scene.clone(true));},
            xhr=>{if(xhr.total>0)loadingTx.textContent=`Loading… ${Math.round(xhr.loaded/xhr.total*100)}%`;}, reject);
    });
}
function glbHasMesh(group){let f=false;group.traverse(c=>{if(c.isMesh)f=true;});return f;}

// Maps inch size to world-space diameter. 6" = 2.0 (baseline)
function inchesToWorldScale(inches){ return (inches / 6.0) * 2.0; }

function positionGroup(group, inches){
    group.position.set(0,0,0); group.rotation.set(0,0,0); group.scale.set(1,1,1); group.updateMatrixWorld(true);
    const box=new THREE.Box3().setFromObject(group), size=box.getSize(new THREE.Vector3());
    const maxDim=Math.max(size.x,size.y,size.z); if(maxDim<0.0001) return;
    const hSize=Math.max(size.x,size.z);
    const targetDiameter = inchesToWorldScale(inches || 6);
    const scale=hSize>0.0001?targetDiameter/hSize:1.0;
    group.scale.setScalar(scale); group.updateMatrixWorld(true);
    const box2=new THREE.Box3().setFromObject(group), center=box2.getCenter(new THREE.Vector3());
    group.position.set(-center.x,-box2.min.y,-center.z); group.updateMatrixWorld(true);
    const box3=new THREE.Box3().setFromObject(group), midY=(box3.min.y+box3.max.y)*.5;
    group.position.y-=midY;
}
function positionMultiGroup(inches, ...groups){
    groups.forEach(g=>{g.position.set(0,0,0);g.rotation.set(0,0,0);g.scale.set(1,1,1);g.updateMatrixWorld(true);});
    const cb=new THREE.Box3(); groups.forEach(g=>cb.expandByObject(g));
    const cs=cb.getSize(new THREE.Vector3()), hSize=Math.max(cs.x,cs.z);
    const targetDiameter = inchesToWorldScale(inches || 6);
    const scale=hSize>0.0001?targetDiameter/hSize:1.0;
    groups.forEach(g=>{g.scale.set(scale,scale,scale);g.updateMatrixWorld(true);});
    const sb=new THREE.Box3(); groups.forEach(g=>sb.expandByObject(g));
    const ox=-sb.getCenter(new THREE.Vector3()).x, oy=-sb.min.y, oz=-sb.getCenter(new THREE.Vector3()).z;
    groups.forEach(g=>{g.position.set(ox,oy,oz);g.updateMatrixWorld(true);});
    const fb=new THREE.Box3(); groups.forEach(g=>fb.expandByObject(g));
    const midY=(fb.min.y+fb.max.y)*.5;
    groups.forEach(g=>{g.position.y-=midY;});
}
function alignDualDigits(gT,gU,wrapper){
    [gT,gU].forEach(g=>{g.position.set(0,0,0);g.rotation.set(0,0,0);g.scale.set(1,1,1);g.updateMatrixWorld(true);});
    const bT=new THREE.Box3().setFromObject(gT), bU=new THREE.Box3().setFromObject(gU);
    const wT=bT.max.x-bT.min.x, wU=bU.max.x-bU.min.x;
    const gap=(wT+wU)*0.08, totalW=wT+gap+wU, startX=-totalW/2;
    gT.position.x=startX-bT.min.x; gU.position.x=startX+wT+gap-bU.min.x;
    gT.position.y=-bT.min.y; gU.position.y=-bU.min.y;
    gT.position.z=-(bT.min.z+(bT.max.z-bT.min.z)/2);
    gU.position.z=-(bU.min.z+(bU.max.z-bU.min.z)/2);
    wrapper.add(gT); wrapper.add(gU); wrapper.updateMatrixWorld(true);
    positionGroup(wrapper);
}

function clearScene(keepDecorations=false){
    while(sceneRoot.children.length) sceneRoot.remove(sceneRoot.children[0]);
    currentBase=currentFrost=currentDrip=currentIcing=null;
    if(!keepDecorations){
        fruitModels.forEach(m=>scene.remove(m.group));
        fruitModels.length=0;
        ferreroModels.forEach(m=>scene.remove(m.group));
        ferreroModels.length=0;
        kitkatModels.forEach(m=>scene.remove(m.group));
        kitkatModels.length=0;
        oreoModels.forEach(m=>scene.remove(m.group));
        oreoModels.length=0;
        if(typeof barShardModels!=='undefined'){
            barShardModels.forEach(m=>scene.remove(m.group));
            barShardModels.length=0;
        }
        candleModels.forEach(m=>{scene.remove(m.group);if(m.mixer){const mi=mixers.indexOf(m.mixer);if(mi>=0)mixers.splice(mi,1);}});
        candleModels.length=0;
    }
}

function addStandToScene(cakeGroup){
    const TABLE_Y       = -1.18;
    const STAND_BOTTOM  =  0.255;
    const PLATE_TOP_LOCAL = 0.018;
    cakeGroup.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(cakeGroup);
    // Include fondant skin in radius calculation if present
    if(currentFrost && currentFrost !== cakeGroup) box.expandByObject(currentFrost);
    const cakeBottomY = box.min.y;
    const cakeRadius  = (box.max.x - box.min.x) * 0.5;
    const stand = buildCakePlateStand(cakeRadius);
    stand.userData.isStand = true;
    const standOriginY    = TABLE_Y + STAND_BOTTOM;
    const plateTopWorldY  = standOriginY + PLATE_TOP_LOCAL;
    const cx = (box.min.x + box.max.x) * 0.5;
    const cz = (box.min.z + box.max.z) * 0.5;
    stand.position.set(cx, standOriginY, cz);
    sceneRoot.add(stand);
    const lift = plateTopWorldY - cakeBottomY + 0.004;
    cakeGroup.position.y += lift;
    cakeGroup.updateMatrixWorld(true);
    return stand;
}

// ── Show a "no preview" placeholder when GLB fails to load ──
function showNoPreview(shapeName){
    clearScene(true);
    const geo = new THREE.BoxGeometry(0.01,0.01,0.01);
    const mat = new THREE.MeshBasicMaterial({visible:false});
    const dummy = new THREE.Mesh(geo,mat);
    sceneRoot.add(dummy);
    showStatus(`No preview — ${shapeName} GLB not found`);
    sceneRoot.visible=true;
    loadingEl.style.opacity='0';
    setTimeout(()=>{loadingEl.style.display='none';},400);
}

async function updateScene(state){
    const {shape,flavor,frostings,hasDrip,dripFlavor,icingColor}=state;
    const frostingsArr=(frostings&&frostings.length>0)?frostings:['Smooth Buttercream'];
    const isNumber   =(shape==='Number');
    const isSugarIcing=frostingsArr.includes('Sugar Icing');
    const frostSuffix =getFrostingFileSuffix(frostingsArr);
    const needFrostGLB=shouldLoadFrostingGLB(frostingsArr);

    let newKey;
    if(isNumber){
        const numStr=state.numberDigits===2?`${state.numberTens??1}_${state.numberUnits??0}`:`${state.numberChoice??0}`;
        newKey=`num_${numStr}_${flavor}_${needFrostGLB?frostSuffix:'nobc'}_${isSugarIcing?icingColor:'ni'}_${hasDrip?dripFlavor:'nd'}`;
    } else {
        const slug=SHAPE_SLUG[shape]||'round';
        const sizeKey=(shape==='Round')?`_${state.roundSize||6}in`:'';
        newKey=`${slug}${sizeKey}_${needFrostGLB?frostSuffix:'nobc'}_${isSugarIcing?icingColor:'ni'}_${hasDrip?dripFlavor:'nd'}`;
    }

if(loadedKey===newKey&&sceneRoot.children.length>0){
    // Only recolor — meshes are already correctly positioned, do NOT reposition
    recolorGLB(flavor,frostingsArr,dripFlavor,icingColor);
    return;
}
    if(isLoading){pendingState=state;return;}
    isLoading=true; sceneRoot.visible=false;
    loadingEl.style.cssText='display:flex;opacity:1;'; loadingTx.textContent='Building 3D preview…'; statusEl.classList.add('hidden');

    let usedGLB=false;

    if(isNumber){
        clearScene(true);
        try{
            if(state.numberDigits===2){
                const T=state.numberTens??1, U=state.numberUnits??0;
                const [rT,rU]=await Promise.allSettled([loadGLB(`/models/number_${T}.glb`),loadGLB(`/models/number_${U}.glb`)]);
                const gT=rT.status==='fulfilled'&&glbHasMesh(rT.value)?rT.value:null;
                const gU=rU.status==='fulfilled'&&glbHasMesh(rU.value)?rU.value:null;
                if(gT||gU){
                    const baseWrapper=new THREE.Group();
                    if(gT&&gU) alignDualDigits(gT,gU,baseWrapper);
                    else { baseWrapper.add(gT||gU); positionGroup(baseWrapper, 6); }
                    sceneRoot.add(baseWrapper); currentBase=baseWrapper;
                    if(isSugarIcing){
                        const [irT,irU]=await Promise.allSettled([loadGLB(`/models/icing_${T}.glb`),loadGLB(`/models/icing_${U}.glb`)]);
                        const igT=irT.status==='fulfilled'&&glbHasMesh(irT.value)?irT.value:null;
                        const igU=irU.status==='fulfilled'&&glbHasMesh(irU.value)?irU.value:null;
                        if(igT||igU){
                            const icingWrapper=new THREE.Group();
                            if(igT&&igU){
                                [igT,igU].forEach(g=>{g.position.set(0,0,0);g.rotation.set(0,0,0);g.scale.set(1,1,1);g.updateMatrixWorld(true);});
                                const bT2=new THREE.Box3().setFromObject(igT),bU2=new THREE.Box3().setFromObject(igU);
                                const wT2=bT2.max.x-bT2.min.x,wU2=bU2.max.x-bU2.min.x;
                                const gap2=(wT2+wU2)*0.08,totalW2=wT2+gap2+wU2,startX2=-totalW2/2;
                                igT.position.x=startX2-bT2.min.x; igU.position.x=startX2+wT2+gap2-bU2.min.x;
                                igT.position.y=-bT2.min.y; igU.position.y=-bU2.min.y;
                                igT.position.z=-(bT2.min.z+(bT2.max.z-bT2.min.z)/2);
                                igU.position.z=-(bU2.min.z+(bU2.max.z-bU2.min.z)/2);
                                icingWrapper.add(igT); icingWrapper.add(igU);
                            } else { icingWrapper.add(igT||igU); }
                            icingWrapper.scale.copy(baseWrapper.scale);
                            icingWrapper.position.copy(baseWrapper.position);
                            sceneRoot.add(icingWrapper); currentIcing=icingWrapper;
                        }
                    }
                    const yBefore2=baseWrapper.position.y;
                    addStandToScene(baseWrapper);
                    const yDelta2=baseWrapper.position.y-yBefore2;
                    if(yDelta2!==0&&currentIcing){currentIcing.position.y+=yDelta2;currentIcing.updateMatrixWorld(true);}
                    recolorGLB(flavor,frostingsArr,dripFlavor,icingColor);
                    usedGLB=true; showStatus('Loaded ✓');
                }
            } else {
                const N=state.numberChoice??0;
                const baseGLB=await loadGLB(`/models/number_${N}.glb`).catch(()=>null);
                if(baseGLB&&glbHasMesh(baseGLB)){
                    positionGroup(baseGLB, 6);
                    sceneRoot.add(baseGLB); currentBase=baseGLB;
                    if(isSugarIcing){
                        const icingGLB=await loadGLB(`/models/icing_${N}.glb`).catch(()=>null);
                        if(icingGLB&&glbHasMesh(icingGLB)){
                            icingGLB.scale.copy(baseGLB.scale);
                            icingGLB.position.copy(baseGLB.position);
                            icingGLB.rotation.copy(baseGLB.rotation);
                            sceneRoot.add(icingGLB); currentIcing=icingGLB;
                        }
                    }
                    const yBefore3=baseGLB.position.y;
                    addStandToScene(baseGLB);
                    const yDelta3=baseGLB.position.y-yBefore3;
                    if(yDelta3!==0&&currentIcing){currentIcing.position.y+=yDelta3;currentIcing.updateMatrixWorld(true);}
                    recolorGLB(flavor,frostingsArr,dripFlavor,icingColor);
                    usedGLB=true; showStatus('Loaded ✓');
                }
            }
        } catch(e){ console.warn('Number GLB error',e); }
        if(!usedGLB){ showNoPreview('Number'); }
    } else {
        const slug      = SHAPE_SLUG[shape]||'round';
const needFrost = shouldLoadFrostingGLB(frostingsArr);

        const hasFondant= frostingsArr.includes('Fondant Smooth');

        const baseURL  = `/models/base_${slug}.glb`;
        // Fondant skin: fondant_<slug>.glb — available for all cake shapes
        const frostURL = needFrost
    ? (hasFondant ? `/models/fondant_${slug}.glb` : `/models/frosting_${slug}_${frostSuffix}.glb`)
    : null;
        const icingURL = isSugarIcing ? `/models/icing_${slug}.glb` : null;
        const dripURL  = hasDrip      ? `/models/drip_${slug}.glb`  : null;

        const urlList  = [baseURL];
        const idxFrost = needFrost    ? (urlList.push(frostURL)-1) : -1;
        const idxIcing = isSugarIcing ? (urlList.push(icingURL)-1) : -1;
        const idxDrip  = hasDrip      ? (urlList.push(dripURL) -1) : -1;

        const results  = await Promise.allSettled(urlList.map(u=>loadGLB(u)));
     const baseGLB  = results[0]?.status==='fulfilled' ? results[0].value : null;
const frostGLB = idxFrost>=0 && results[idxFrost]?.status==='fulfilled' ? results[idxFrost].value : null;
// If fondant GLB failed to load, log clearly so you know which file is missing
if(hasFondant && !frostGLB) console.error(`[Fondant] Missing: /models/fondant_${slug}.glb — create this file!`);
        const icingGLB = idxIcing>=0 && results[idxIcing]?.status==='fulfilled' ? results[idxIcing].value : null;
        const dripGLB  = idxDrip >=0 && results[idxDrip] ?.status==='fulfilled' ? results[idxDrip].value  : null;

        clearScene(true);

        const toPos = [];
        if(baseGLB  && glbHasMesh(baseGLB))  { currentBase  = baseGLB;  sceneRoot.add(currentBase);  toPos.push(currentBase);  }
        if(frostGLB && glbHasMesh(frostGLB)) { currentFrost = frostGLB; sceneRoot.add(currentFrost); toPos.push(currentFrost); }
        if(icingGLB && glbHasMesh(icingGLB)) { currentIcing = icingGLB; sceneRoot.add(currentIcing); toPos.push(currentIcing); }
        if(dripGLB  && glbHasMesh(dripGLB))  { currentDrip  = dripGLB;  sceneRoot.add(currentDrip);  toPos.push(currentDrip);  }

        if(toPos.length > 0){
            sceneRoot.updateMatrixWorld(true);
            const _inches = (shape==='Round') ? (state.roundSize||6) : 6;

            if(hasFondant && currentBase && currentFrost && glbHasMesh(currentBase) && glbHasMesh(currentFrost)){
                // ── FONDANT: scale base + fondant skin as one matched unit ──
                [currentBase, currentFrost].forEach(g => {
                    g.position.set(0,0,0); g.rotation.set(0,0,0); g.scale.set(1,1,1);
                    g.updateMatrixWorld(true);
                });
                const rawBaseBox  = new THREE.Box3().setFromObject(currentBase);
                const rawBaseDiam = Math.max(
                    rawBaseBox.max.x - rawBaseBox.min.x,
                    rawBaseBox.max.z - rawBaseBox.min.z
                );
                const targetDiam = inchesToWorldScale(_inches);
                const baseScale  = rawBaseDiam > 0.0001 ? targetDiam / rawBaseDiam : 1.0;
                currentBase.scale.setScalar(baseScale);
                currentBase.updateMatrixWorld(true);
                // Fondant skin gets the SAME scale so it aligns perfectly
                currentFrost.scale.setScalar(baseScale);
                currentFrost.updateMatrixWorld(true);
                // Center both on XZ origin
                const bBox   = new THREE.Box3().setFromObject(currentBase);
                const bCX    = (bBox.min.x + bBox.max.x) * 0.5;
                const bCZ    = (bBox.min.z + bBox.max.z) * 0.5;
                currentBase.position.set(-bCX, -bBox.min.y, -bCZ);
                currentBase.updateMatrixWorld(true);
                const fBox   = new THREE.Box3().setFromObject(currentFrost);
                const fCX    = (fBox.min.x + fBox.max.x) * 0.5;
                const fCZ    = (fBox.min.z + fBox.max.z) * 0.5;
                const bBox2  = new THREE.Box3().setFromObject(currentBase);
                currentFrost.position.set(-fCX, bBox2.min.y - fBox.min.y, -fCZ);
                currentFrost.updateMatrixWorld(true);
                // Vertically center the combined assembly
                const combined = new THREE.Box3();
                combined.expandByObject(currentBase);
                combined.expandByObject(currentFrost);
                const midY = (combined.min.y + combined.max.y) * 0.5;
                currentBase.position.y  -= midY;
                currentFrost.position.y -= midY;
                currentBase.updateMatrixWorld(true);
                currentFrost.updateMatrixWorld(true);
             // Add stand aligned to base
                const yBefore = currentBase.position.y;
                addStandToScene(currentBase);
                const yDelta = currentBase.position.y - yBefore;
                if(yDelta !== 0){
                    currentFrost.position.y += yDelta;
                    currentFrost.updateMatrixWorld(true);
                }

                // ── Drip on fondant — load and align same as base ──
                if(dripGLB && glbHasMesh(dripGLB)){
                    currentDrip = dripGLB;
                    currentDrip.scale.setScalar(currentBase.scale.x);
                    currentDrip.position.copy(currentBase.position);
                    currentDrip.updateMatrixWorld(true);
                    sceneRoot.add(currentDrip);
                }
            } else {
                if(toPos.length >= 2) positionMultiGroup(_inches, ...toPos);
                else positionGroup(toPos[0], _inches);
                const yBefore = toPos[0].position.y;
                addStandToScene(toPos[0]);
                const yDelta = toPos[0].position.y - yBefore;
                if(yDelta !== 0) toPos.slice(1).forEach(g=>{ g.position.y+=yDelta; g.updateMatrixWorld(true); });
            }

            recolorGLB(flavor, frostingsArr, dripFlavor, icingColor);
            usedGLB = true; showStatus('Loaded ✓');
        }
        if(!usedGLB){ showNoPreview(shape); }
    }

    loadedKey=newKey; sceneRoot.visible=true;
    loadingEl.style.opacity='0'; setTimeout(()=>{loadingEl.style.display='none';},400);
    isLoading=false;
    requestAnimationFrame(()=>{
        if(typeof window._reprojectAllToppings==='function') window._reprojectAllToppings();
    });
    if(pendingState){const n=pendingState;pendingState=null;updateScene(n);}
}

// ── Shared GLB loader for placed decorations ──
const decoGLBCache={};
function loadDecoGLB(url){return new Promise((resolve,reject)=>{if(decoGLBCache[url]){const c=decoGLBCache[url].clone(true);c.traverse(x=>{if(x.isMesh&&x.material)x.material=x.material.clone();});resolve(c);return;}new GLTFLoader().load(url,gltf=>{decoGLBCache[url]=gltf.scene;const c=gltf.scene.clone(true);c.traverse(x=>{if(x.isMesh&&x.material)x.material=x.material.clone();});resolve(c);},undefined,err=>{console.error('[Deco]',url,err);reject(err);});});}
function getCakeMeshes(){
    const m=[];
    sceneRoot.traverse(c=>{
        if(!c.isMesh) return;
        let node=c,isStand=false;
        while(node){if(node.userData&&node.userData.isStand){isStand=true;break;}node=node.parent;}
        if(!isStand) m.push(c);
    });
    return m;
}
function raycastCakeTop(cx,cy){
    const rect=document.getElementById('viewerEl').getBoundingClientRect();
    const ndc=new THREE.Vector2(((cx-rect.left)/rect.width)*2-1,-((cy-rect.top)/rect.height)*2+1);
    const camRay=new THREE.Raycaster();
    camRay.setFromCamera(ndc,camera);
    const meshes=getCakeMeshes();
    const camHits=camRay.intersectObjects(meshes,false);
    if(camHits.length===0) return null;
    // Use the camera hit point directly — most reliable for perspective views
    return camHits[0].point.clone();
}
function _positionDecoGroup(fg,sp,fh){fg.position.set(sp.x,sp.y,sp.z);}

// ── Fruit system ──
const fruitGLBCache={};
function loadFruitGLB(url){return new Promise((resolve,reject)=>{if(fruitGLBCache[url]){const c=fruitGLBCache[url].clone(true);c.traverse(x=>{if(x.isMesh&&x.material)x.material=x.material.clone();});resolve(c);return;}new GLTFLoader().load(url,gltf=>{fruitGLBCache[url]=gltf.scene;const c=gltf.scene.clone(true);c.traverse(x=>{if(x.isMesh&&x.material)x.material=x.material.clone();});resolve(c);},undefined,err=>{console.error('[Fruit]',url,err);reject(err);});});}
let _draggingFruitIdx=-1;
window.placeFruitOnCake=async function(fruitName,cx,cy,ei){const map={'Strawberry':'/models/Strawberry.glb','Blueberry':'/models/Blueberry.glb','Raspberry':'/models/Raspberry.glb','Cherry':'/models/Cherry.glb'};const url=map[fruitName];if(!url)return -1;try{let fg,fh;if(ei!==undefined&&ei>=0&&fruitModels[ei]){fg=fruitModels[ei].group;const sb=new THREE.Box3().setFromObject(fg);fh=(sb.max.y-sb.min.y)*.5;}else{fg=await loadFruitGLB(url);fg.traverse(c=>{if(c.isMesh){c.castShadow=true;c.receiveShadow=true;}});fg.updateMatrixWorld(true);const rb=new THREE.Box3().setFromObject(fg),maxD=rb.getSize(new THREE.Vector3()).length();
                const fruitSizes={'Strawberry':0.22,'Blueberry':0.12,'Raspberry':0.16,'Cherry':0.20};
                const T=fruitSizes[fruitName]||0.18;
                fg.scale.setScalar(maxD>0.0001?T/maxD:1.0);
              if(fruitName==='Strawberry'||fruitName==='Raspberry'){fg.rotation.x=0;fg.rotation.y=0;}fg.updateMatrixWorld(true);const sb=new THREE.Box3().setFromObject(fg);fh=(sb.max.y-sb.min.y)*.5;}fruitModels.forEach(m=>m.group.visible=false);const hp=raycastCakeTop(cx,cy);fruitModels.forEach(m=>m.group.visible=true);let sp;if(hp){sp=hp;}else{sceneRoot.updateMatrixWorld(true);const cb=new THREE.Box3().setFromObject(sceneRoot),cc=cb.getCenter(new THREE.Vector3());sp=new THREE.Vector3(cc.x,cb.max.y,cc.z);}fg.updateMatrixWorld(true);const _fBox=new THREE.Box3().setFromObject(fg);const _fHeight=_fBox.max.y-_fBox.min.y;const _fOffset=-_fBox.min.y-(_fHeight*0.25);
fg.position.set(sp.x,sp.y+_fOffset,sp.z);if(ei!==undefined&&ei>=0&&fruitModels[ei])return ei;scene.add(fg);const idx=fruitModels.length;fruitModels.push({group:fg,fruit:fruitName,halfH:fh,bottomOffset:_fOffset});
return idx;}catch(err){console.error('[Fruit]',fruitName,err);return -1;}};
window.clearFruitModels=function(){fruitModels.forEach(m=>scene.remove(m.group));fruitModels.length=0;_draggingFruitIdx=-1;};
window.getFruitIndexAtScreen=function(cx,cy){const rect=document.getElementById('viewerEl').getBoundingClientRect(),ndc=new THREE.Vector2(((cx-rect.left)/rect.width)*2-1,-((cy-rect.top)/rect.height)*2+1),rc=new THREE.Raycaster();rc.setFromCamera(ndc,camera);for(let i=fruitModels.length-1;i>=0;i--){const t=[];fruitModels[i].group.traverse(c=>{if(c.isMesh)t.push(c);});if(rc.intersectObjects(t,false).length>0)return i;}return -1;};
window.moveDraggingFruit=function(cx,cy){if(_draggingFruitIdx<0||!fruitModels[_draggingFruitIdx])return;const e=fruitModels[_draggingFruitIdx];fruitModels.forEach(m=>m.group.visible=false);const h=raycastCakeTop(cx,cy);fruitModels.forEach(m=>m.group.visible=true);if(h){e.group.position.set(h.x,h.y+e.bottomOffset,h.z);}};
window.setDraggingFruitIdx=function(idx){_draggingFruitIdx=idx;};
window.getDraggingFruitIdx=function(){return _draggingFruitIdx;};
window.getFruitModels=function(){return fruitModels;};

// ── Ferrero system ──
let _draggingFerreroIdx = -1;
window.placeFerreroOnCake = async function(cx, cy, ei) {
    const url = '/models/ferrero.glb';
    try {
        let fg, fh;
        if (ei !== undefined && ei >= 0 && ferreroModels[ei]) {
            fg = ferreroModels[ei].group;
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        } else {
            fg = await loadFruitGLB(url);
            fg.traverse(c => { if (c.isMesh) { c.castShadow = true; c.receiveShadow = true; } });
            fg.updateMatrixWorld(true);
            const rb = new THREE.Box3().setFromObject(fg);
            const sz = rb.getSize(new THREE.Vector3());
            const maxD = Math.max(sz.x, sz.y, sz.z);
         fg.scale.setScalar(maxD > 0.0001 ? 0.204 / maxD : 1.0);
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        }
        ferreroModels.forEach(m => m.group.visible = false);
        const hp = raycastCakeTop(cx, cy);
        ferreroModels.forEach(m => m.group.visible = true);
        let sp;
        if (hp) { sp = hp; } else {
            sceneRoot.updateMatrixWorld(true);
            const cb = new THREE.Box3().setFromObject(sceneRoot);
            sp = new THREE.Vector3(cb.getCenter(new THREE.Vector3()).x, cb.max.y, cb.getCenter(new THREE.Vector3()).z);
        }
        _positionDecoGroup(fg, sp, fh);
        if (ei !== undefined && ei >= 0 && ferreroModels[ei]) return ei;
        scene.add(fg);
        const idx = ferreroModels.length;
        ferreroModels.push({ group: fg, halfH: fh });
        return idx;
    } catch (err) { console.error('[Ferrero]', err); return -1; }
};
window.clearFerreroModels = function() { ferreroModels.forEach(m => scene.remove(m.group)); ferreroModels.length = 0; _draggingFerreroIdx = -1; };
window.getFerreroIndexAtScreen = function(cx, cy) {
    const rect = document.getElementById('viewerEl').getBoundingClientRect();
    const ndc = new THREE.Vector2(((cx - rect.left) / rect.width) * 2 - 1, -((cy - rect.top) / rect.height) * 2 + 1);
    const rc = new THREE.Raycaster(); rc.setFromCamera(ndc, camera);
    for (let i = ferreroModels.length - 1; i >= 0; i--) {
        const t = []; ferreroModels[i].group.traverse(c => { if (c.isMesh) t.push(c); });
        if (rc.intersectObjects(t, false).length > 0) return i;
    }
    return -1;
};
window.moveDraggingFerrero = function(cx, cy) {
    if (_draggingFerreroIdx < 0 || !ferreroModels[_draggingFerreroIdx]) return;
    const e = ferreroModels[_draggingFerreroIdx];
    ferreroModels.forEach(m => m.group.visible = false);
    const h = raycastCakeTop(cx, cy);
    ferreroModels.forEach(m => m.group.visible = true);
    if (h) _positionDecoGroup(e.group, h, e.halfH);
};
window.setDraggingFerreroIdx = function(idx) { _draggingFerreroIdx = idx; };
window.getDraggingFerreroIdx = function() { return _draggingFerreroIdx; };
window.getFerreroModels = function() { return ferreroModels; };

// ── KitKat system ──
let _draggingKitkatIdx = -1;
function applyKitkatOrientation(fg, orientation, isNew = false) {
    if (isNew) fg.rotation.y = Math.random() * Math.PI * 2;
    if (orientation === 'standing') {
        fg.rotation.x = 0; fg.rotation.z = Math.PI / 2;
    } else {
        fg.rotation.x = -Math.PI / 2; fg.rotation.z = 0;
    }
}
window.placeKitkatOnCake = async function(cx, cy, orientation, ei) {
    const url = '/models/kitkat.glb';
    try {
        let fg, fh;
        if (ei !== undefined && ei >= 0 && kitkatModels[ei]) {
            fg = kitkatModels[ei].group;
            applyKitkatOrientation(fg, orientation);
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        } else {
            fg = await loadDecoGLB(url);
            fg.traverse(c => { if (c.isMesh) { c.castShadow = true; c.receiveShadow = true; } });
            fg.updateMatrixWorld(true);
            const rb = new THREE.Box3().setFromObject(fg);
            const sz = rb.getSize(new THREE.Vector3());
            const maxD = Math.max(sz.x, sz.y, sz.z);
            fg.scale.setScalar(maxD > 0.0001 ? 0.40 / maxD : 1.0);
            applyKitkatOrientation(fg, orientation);
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        }
        kitkatModels.forEach(m => m.group.visible = false);
        const hp = raycastCakeTop(cx, cy);
        kitkatModels.forEach(m => m.group.visible = true);
        let sp;
        if (hp) { sp = hp; } else {
            sceneRoot.updateMatrixWorld(true);
            const cb = new THREE.Box3().setFromObject(sceneRoot);
            const cc = cb.getCenter(new THREE.Vector3());
            sp = new THREE.Vector3(cc.x, cb.max.y, cc.z);
        }
        fg.updateMatrixWorld(true);
        const _kkBox = new THREE.Box3().setFromObject(fg);
        const _kkOffset = -_kkBox.min.y;
        fg.position.set(sp.x, sp.y + _kkOffset, sp.z);
        if (ei !== undefined && ei >= 0 && kitkatModels[ei]) return ei;
        scene.add(fg);
        const idx = kitkatModels.length;
        kitkatModels.push({ group: fg, halfH: fh, orientation, bottomOffset: _kkOffset });
        return idx;
    } catch (err) { console.error('[KitKat]', err); return -1; }
};
window.clearKitkatModels = function() { kitkatModels.forEach(m => scene.remove(m.group)); kitkatModels.length = 0; _draggingKitkatIdx = -1; };
window.getKitkatIndexAtScreen = function(cx, cy) {
    const rect = document.getElementById('viewerEl').getBoundingClientRect();
    const ndc = new THREE.Vector2(((cx - rect.left) / rect.width) * 2 - 1, -((cy - rect.top) / rect.height) * 2 + 1);
    const rc = new THREE.Raycaster(); rc.setFromCamera(ndc, camera);
    for (let i = kitkatModels.length - 1; i >= 0; i--) {
        const t = []; kitkatModels[i].group.traverse(c => { if (c.isMesh) t.push(c); });
        if (rc.intersectObjects(t, false).length > 0) return i;
    }
    return -1;
};
window.moveDraggingKitkat = function(cx, cy) {
    if (_draggingKitkatIdx < 0 || !kitkatModels[_draggingKitkatIdx]) return;
    const e = kitkatModels[_draggingKitkatIdx];
    kitkatModels.forEach(m => m.group.visible = false);
    const h = raycastCakeTop(cx, cy);
    kitkatModels.forEach(m => m.group.visible = true);
    if (h) { e.group.position.set(h.x, h.y + e.bottomOffset, h.z); }
};
window.setDraggingKitkatIdx = function(idx) { _draggingKitkatIdx = idx; };
window.getDraggingKitkatIdx = function() { return _draggingKitkatIdx; };
window.getKitkatModels = function() { return kitkatModels; };
window.updateKitkatOrientations = function(orientation) {
    kitkatModels.forEach(m => {
        m.orientation = orientation;
        applyKitkatOrientation(m.group, orientation);
        m.group.updateMatrixWorld(true);
        const sb = new THREE.Box3().setFromObject(m.group);
        m.halfH = (sb.max.y - sb.min.y) * 0.5;
    });
};

// ── Oreo system ──
let _draggingOreoIdx = -1;
function applyOreoOrientation(fg, orientation, isNew = false) {
    if (isNew) fg.rotation.y = Math.random() * Math.PI * 2;
    if (orientation === 'standing') {
        fg.rotation.x = Math.PI / 2; fg.rotation.z = 0;
    } else {
        fg.rotation.x = 0; fg.rotation.z = 0;
    }
}
window.placeOreoOnCake = async function(cx, cy, orientation, ei) {
    const url = '/models/oreo_cookie.glb';
    try {
        let fg, fh;
        if (ei !== undefined && ei >= 0 && oreoModels[ei]) {
            fg = oreoModels[ei].group;
            applyOreoOrientation(fg, orientation);
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        } else {
            fg = await loadDecoGLB(url);
            fg.traverse(c => { if (c.isMesh) { c.castShadow = true; c.receiveShadow = true; } });
            fg.updateMatrixWorld(true);
            const rb = new THREE.Box3().setFromObject(fg);
            const sz = rb.getSize(new THREE.Vector3());
            const maxD = Math.max(sz.x, sz.y, sz.z);
        fg.scale.setScalar(maxD > 0.0001 ? 0.2275 / maxD : 1.0);
            applyOreoOrientation(fg, orientation, true);
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        }
        oreoModels.forEach(m => m.group.visible = false);
        const hp = raycastCakeTop(cx, cy);
        oreoModels.forEach(m => m.group.visible = true);
        let sp;
        if (hp) { sp = hp; } else {
            sceneRoot.updateMatrixWorld(true);
            const cb = new THREE.Box3().setFromObject(sceneRoot);
            const cc = cb.getCenter(new THREE.Vector3());
            sp = new THREE.Vector3(cc.x, cb.max.y, cc.z);
        }
        fg.updateMatrixWorld(true);
        const _oreoBox = new THREE.Box3().setFromObject(fg);
        const _oreoOffset = -_oreoBox.min.y;
        fg.position.set(sp.x, sp.y + _oreoOffset, sp.z);
        if (ei !== undefined && ei >= 0 && oreoModels[ei]) return ei;
        scene.add(fg);
        const idx = oreoModels.length;
        oreoModels.push({ group: fg, halfH: fh, orientation, bottomOffset: _oreoOffset });
        return idx;
    } catch (err) { console.error('[Oreo]', err); return -1; }
};
window.clearOreoModels = function() { oreoModels.forEach(m => scene.remove(m.group)); oreoModels.length = 0; _draggingOreoIdx = -1; };
window.getOreoIndexAtScreen = function(cx, cy) {
    const rect = document.getElementById('viewerEl').getBoundingClientRect();
    const ndc = new THREE.Vector2(((cx - rect.left) / rect.width) * 2 - 1, -((cy - rect.top) / rect.height) * 2 + 1);
    const rc = new THREE.Raycaster(); rc.setFromCamera(ndc, camera);
    for (let i = oreoModels.length - 1; i >= 0; i--) {
        const t = []; oreoModels[i].group.traverse(c => { if (c.isMesh) t.push(c); });
        if (rc.intersectObjects(t, false).length > 0) return i;
    }
    return -1;
};
window.moveDraggingOreo = function(cx, cy) {
    if (_draggingOreoIdx < 0 || !oreoModels[_draggingOreoIdx]) return;
    const e = oreoModels[_draggingOreoIdx];
    oreoModels.forEach(m => m.group.visible = false);
    const h = raycastCakeTop(cx, cy);
    oreoModels.forEach(m => m.group.visible = true);
    if (h) { e.group.position.set(h.x, h.y + e.bottomOffset, h.z); }
};
window.setDraggingOreoIdx = function(idx) { _draggingOreoIdx = idx; };
window.getDraggingOreoIdx = function() { return _draggingOreoIdx; };
window.getOreoModels = function() { return oreoModels; };
window.updateOreoOrientations = function(orientation) {
    oreoModels.forEach(m => {
        m.orientation = orientation;
        applyOreoOrientation(m.group, orientation);
        m.group.updateMatrixWorld(true);
        const sb = new THREE.Box3().setFromObject(m.group);
        m.halfH = (sb.max.y - sb.min.y) * 0.5;
    });
};

// ── Bar Shard system (procedural mesh — no GLB needed) ──
const barShardModels = [];
let _draggingBarShardIdx = -1;

function buildBarShardMesh() {
    const g = new THREE.Group();
    const barW = 0.15, barD = 0.15, barH = 0.03;
    const barMat = new THREE.MeshStandardMaterial({
        color: new THREE.Color('#3A1A08'), roughness: 0.22, metalness: 0.06, envMapIntensity: 0.90,
    });
    const barGeo = new THREE.BoxGeometry(barW, barH, barD, 2, 1, 2);
    const pos = barGeo.attributes.position;
    for (let i = 0; i < pos.count; i++) {
        if (pos.getY(i) > 0) { pos.setX(i, pos.getX(i) * 0.92); pos.setZ(i, pos.getZ(i) * 0.92); }
    }
    pos.needsUpdate = true; barGeo.computeVertexNormals();
    const barMesh = new THREE.Mesh(barGeo, barMat);
    barMesh.position.y = barH * 0.5; barMesh.castShadow = barMesh.receiveShadow = true; g.add(barMesh);
    const grooveMat = new THREE.MeshStandardMaterial({ color: new THREE.Color('#2A1006'), roughness: 0.35, metalness: 0.04, envMapIntensity: 0.70 });
    const cellGeo = new THREE.BoxGeometry(barW - 0.06, 0.018, barD - 0.06);
    const cellMesh = new THREE.Mesh(cellGeo, grooveMat);
    cellMesh.position.set(0, barH + 0.009, 0); cellMesh.castShadow = true; g.add(cellMesh);
    const glossMat = new THREE.MeshStandardMaterial({ color: new THREE.Color('#6A3018'), roughness: 0.06, metalness: 0.18, envMapIntensity: 1.20, transparent: true, opacity: 0.55 });
    const glossGeo = new THREE.BoxGeometry(barW * 0.28, 0.004, barD * 0.72);
    const glossMesh = new THREE.Mesh(glossGeo, glossMat);
    glossMesh.position.set(-barW * 0.14, barH + 0.013, 0); g.add(glossMesh);
    g.rotation.y = Math.random() * Math.PI * 2;
    g.updateMatrixWorld(true);
    return g;
}

window.placeBarShardOnCake = async function(cx, cy, ei) {
    try {
        let fg, fh;
        if (ei !== undefined && ei >= 0 && barShardModels[ei]) {
            fg = barShardModels[ei].group;
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        } else {
            fg = buildBarShardMesh();
            fg.traverse(c => { if (c.isMesh) { c.castShadow = true; c.receiveShadow = true; } });
            fg.updateMatrixWorld(true);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        }
        barShardModels.forEach(m => m.group.visible = false);
        const hp = raycastCakeTop(cx, cy);
        barShardModels.forEach(m => m.group.visible = true);
        let sp;
        if (hp) { sp = hp; } else {
            sceneRoot.updateMatrixWorld(true);
            const cb = new THREE.Box3().setFromObject(sceneRoot);
            const cc = cb.getCenter(new THREE.Vector3());
            sp = new THREE.Vector3(cc.x, cb.max.y, cc.z);
        }
        const sb = new THREE.Box3().setFromObject(fg);
        const offset = -sb.min.y;
        fg.position.set(sp.x, sp.y + offset, sp.z);
        if (ei !== undefined && ei >= 0 && barShardModels[ei]) return ei;
        scene.add(fg);
        const idx = barShardModels.length;
        barShardModels.push({ group: fg, halfH: fh });
        return idx;
    } catch (err) { console.error('[BarShard]', err); return -1; }
};
window.clearBarShardModels = function() { barShardModels.forEach(m => scene.remove(m.group)); barShardModels.length = 0; _draggingBarShardIdx = -1; };
window.getBarShardIndexAtScreen = function(cx, cy) {
    const rect = document.getElementById('viewerEl').getBoundingClientRect();
    const ndc = new THREE.Vector2(((cx - rect.left) / rect.width) * 2 - 1, -((cy - rect.top) / rect.height) * 2 + 1);
    const rc = new THREE.Raycaster(); rc.setFromCamera(ndc, camera);
    for (let i = barShardModels.length - 1; i >= 0; i--) {
        const t = []; barShardModels[i].group.traverse(c => { if (c.isMesh) t.push(c); });
        if (rc.intersectObjects(t, false).length > 0) return i;
    }
    return -1;
};
window.moveDraggingBarShard = function(cx, cy) {
    if (_draggingBarShardIdx < 0 || !barShardModels[_draggingBarShardIdx]) return;
    const e = barShardModels[_draggingBarShardIdx];
    barShardModels.forEach(m => m.group.visible = false);
    const h = raycastCakeTop(cx, cy);
    barShardModels.forEach(m => m.group.visible = true);
    if (h) _positionDecoGroup(e.group, h, e.halfH);
};
window.setDraggingBarShardIdx = function(idx) { _draggingBarShardIdx = idx; };
window.getDraggingBarShardIdx = function() { return _draggingBarShardIdx; };
window.getBarShardModels = function() { return barShardModels; };

// ── Candle system ──
// NOTE: Do NOT cache+clone animated GLBs — cloning breaks animation track bindings.
// Each candle must be a fresh GLTF load so the mixer's UUID references stay valid.
function loadCandleGLB(url){
    return new Promise((resolve,reject)=>{
        new GLTFLoader().load(url, gltf=>{
            resolve({scene:gltf.scene, animations:gltf.animations});
        }, undefined, reject);
    });
}
let _draggingCandleIdx=-1;
window.placeCandleOnCake=async function(candleNum,cx,cy,ei){
    try{
        let fg,fh,mixer;
        if(ei!==undefined&&ei>=0&&candleModels[ei]){
            fg=candleModels[ei].group;mixer=candleModels[ei].mixer;
            fg.updateMatrixWorld(true);
            const sb=new THREE.Box3().setFromObject(fg);fh=(sb.max.y-sb.min.y)*0.5;
        } else {
            const [candleResult, flameResult] = await Promise.allSettled([
              loadCandleGLB(`/models/candle_${candleNum}.glb`),
                loadCandleGLB('/models/flame.glb'),
            ]);
            const candleData = candleResult.status==='fulfilled' ? candleResult.value : null;
            const flameData  = flameResult.status==='fulfilled'  ? flameResult.value  : null;
            if(!candleData){ console.error('[Candle] Missing: /models/candle_1.glb'); return -1; }

            fg = new THREE.Group();
            const candleScene = candleData.scene;
            fg.add(candleScene);
            candleScene.traverse(c=>{ if(!c.isMesh) return; c.castShadow=true; c.receiveShadow=true; });

            fg.updateMatrixWorld(true);
            const rb=new THREE.Box3().setFromObject(fg),sz=rb.getSize(new THREE.Vector3());
            const maxD=Math.max(sz.x,sz.y,sz.z);
            fg.scale.setScalar(maxD>0.0001?0.45/maxD:1.0);


            fg.updateMatrixWorld(true);
const candleScale = fg.scale.x;
const flameGroup = buildFlameGroup(0.22 / candleScale);
const worldCandleBox = new THREE.Box3().setFromObject(candleScene);
const candleWidth = worldCandleBox.max.x - worldCandleBox.min.x;
// Per-candle wick X offset (fraction of candle width) — tune per GLB
const CANDLE_WICK_OFFSET = {
    1: 0.18,
    4: 0.20,
};
const xShift = (CANDLE_WICK_OFFSET[candleNum] || 0) * candleWidth;
const worldTop = new THREE.Vector3(
    (worldCandleBox.min.x + worldCandleBox.max.x) * 0.5 + xShift,
    worldCandleBox.max.y,
    (worldCandleBox.min.z + worldCandleBox.max.z) * 0.5
);
const localTop = fg.worldToLocal(worldTop.clone());
flameGroup.position.copy(localTop);
fg.add(flameGroup);

// ── Birthday candle colors per number ──
const CANDLE_COLORS = {
    0: '#E83434', // red
    1: '#3478E8', // blue
    2: '#34C85A', // green
    3: '#F5C842', // yellow
    4: '#E834A0', // pink
    5: '#8B34E8', // purple
    6: '#F58C34', // orange
    7: '#34D4E8', // cyan
    8: '#E86834', // coral
    9: '#58E834', // lime
};
const candleColor = CANDLE_COLORS[candleNum] || '#E83434';
candleScene.traverse(child => {
    if (!child.isMesh) return;
    // Skip very dark meshes (wick) by checking existing material color luminance
    let isWick = false;
    if (child.material && child.material.color) {
        const hsl = { h: 0, s: 0, l: 0 };
        child.material.color.getHSL(hsl);
        isWick = hsl.l < 0.12;
    }
    if (!isWick) {
        child.material = new THREE.MeshStandardMaterial({
            color:             new THREE.Color(candleColor),
            emissive:          new THREE.Color(candleColor),
            emissiveIntensity: 0.22,
            roughness:         0.28,
            metalness:         0.0,
            envMapIntensity:   1.2,
        });
    }
    child.castShadow    = true;
    child.receiveShadow = true;
});
            if(candleData.animations&&candleData.animations.length>0){
                const cm=new THREE.AnimationMixer(candleScene);
                candleData.animations.forEach(clip=>cm.clipAction(clip).play());
                mixers.push(cm);
            }
            const sb=new THREE.Box3().setFromObject(fg);fh=(sb.max.y-sb.min.y)*0.5;
        }
        candleModels.forEach(m=>m.group.visible=false);
        const hp=raycastCakeTop(cx,cy);
        candleModels.forEach(m=>m.group.visible=true);
        let sp;
        if(hp){sp=hp;}else{
            sceneRoot.updateMatrixWorld(true);
            const cb=new THREE.Box3().setFromObject(sceneRoot),cc=cb.getCenter(new THREE.Vector3());
            sp=new THREE.Vector3(cc.x,cb.max.y,cc.z);
        }
        fg.updateMatrixWorld(true);
        const _cBox=new THREE.Box3().setFromObject(fg),_cOffset=-_cBox.min.y;
        fg.position.set(sp.x,sp.y+_cOffset,sp.z);
        if(ei!==undefined&&ei>=0&&candleModels[ei])return ei;
        scene.add(fg);
        const idx=candleModels.length;
        candleModels.push({group:fg,halfH:fh,candleNum,bottomOffset:_cOffset,mixer});
        return idx;
    }catch(err){console.error('[Candle]',err);return -1;}
};
window.clearCandleModels=function(){
    candleModels.forEach(m=>{
        scene.remove(m.group);
        if(m.mixer){const mi=mixers.indexOf(m.mixer);if(mi>=0)mixers.splice(mi,1);}
    });
    candleModels.length=0;_draggingCandleIdx=-1;
};
window.getCandleIndexAtScreen=function(cx,cy){
    const rect=document.getElementById('viewerEl').getBoundingClientRect();
    const ndc=new THREE.Vector2(((cx-rect.left)/rect.width)*2-1,-((cy-rect.top)/rect.height)*2+1);
    const rc=new THREE.Raycaster();rc.setFromCamera(ndc,camera);
    for(let i=candleModels.length-1;i>=0;i--){
        const t=[];candleModels[i].group.traverse(c=>{if(c.isMesh)t.push(c);});
        if(rc.intersectObjects(t,false).length>0)return i;
    }
    return -1;
};
window.moveDraggingCandle=function(cx,cy){
    if(_draggingCandleIdx<0||!candleModels[_draggingCandleIdx])return;
    const e=candleModels[_draggingCandleIdx];
    candleModels.forEach(m=>m.group.visible=false);
    const h=raycastCakeTop(cx,cy);
    candleModels.forEach(m=>m.group.visible=true);
    if(h){e.group.position.set(h.x,h.y+e.bottomOffset,h.z);}
};
window.setDraggingCandleIdx=function(idx){_draggingCandleIdx=idx;};
window.getDraggingCandleIdx=function(){return _draggingCandleIdx;};
window.getCandleModels=function(){return candleModels;};

// ── Topping reprojection (normalised coordinates survive cake rescale) ──
function getCakeCenterAndRadius(){
    sceneRoot.updateMatrixWorld(true);
    const box=new THREE.Box3().setFromObject(sceneRoot);
    const cx=(box.min.x+box.max.x)*0.5, cz=(box.min.z+box.max.z)*0.5;
    const r=Math.max((box.max.x-box.min.x),(box.max.z-box.min.z))*0.5;
    return {cx,cz,r:r>0.001?r:1.0};
}
function saveNormalized(models){
    const{cx,cz,r}=getCakeCenterAndRadius();
    models.forEach(m=>{m._normX=(m.group.position.x-cx)/r;m._normZ=(m.group.position.z-cz)/r;});
}
function reprojectModels(models){
    const{cx,cz,r}=getCakeCenterAndRadius();
    models.forEach(m=>{
        if(m._normX===undefined) return;
        const wx=cx+m._normX*r, wz=cz+m._normZ*r;
        const topRay=new THREE.Raycaster(new THREE.Vector3(wx,20,wz),new THREE.Vector3(0,-1,0));
        const meshes=getCakeMeshes();
        const hits=topRay.intersectObjects(meshes,false);
        let wy=m.group.position.y;
        if(hits.length>0){hits.sort((a,b)=>b.point.y-a.point.y);wy=hits[0].point.y;}
        const offset=m.bottomOffset!==undefined?m.bottomOffset:0;
        m.group.position.set(wx, wy+offset, wz);
        m.group.updateMatrixWorld(true);
    });
}
window._saveAllToppingNormals=function(){
    saveNormalized(fruitModels);saveNormalized(ferreroModels);
    saveNormalized(kitkatModels);saveNormalized(oreoModels);saveNormalized(barShardModels);
    saveNormalized(candleModels);
};
window._reprojectAllToppings=function(){
    reprojectModels(fruitModels);reprojectModels(ferreroModels);
    reprojectModels(kitkatModels);reprojectModels(oreoModels);reprojectModels(barShardModels);
    reprojectModels(candleModels);
};

window.updateModel=(state)=>updateScene(state);
window.resetCamera=()=>{camera.position.set(0,1.8,8.5);controls.target.set(0,-0.30,0);controls.reset();};
window._viewerReady=true;
// ── FRUIT ROTATE INLINE PANEL ──
(function(){
    let activeFruitPanelIdx = -1;
    const FRUIT_EMOJI = { Strawberry:'🍓', Blueberry:'🫐', Raspberry:'🍇', Cherry:'🍒' };
    // Rotation axis per fruit — Strawberry/Raspberry use X for placement so we rotate Y instead
  const FRUIT_ROT_AXIS = { Strawberry:'z', Raspberry:'z', Blueberry:'z', Cherry:'z' };

    const panel    = document.getElementById('fruitRotPanel');
    const range    = document.getElementById('fruitRotPanelRange');
    const degLabel = document.getElementById('fruitRotPanelDeg');
    const preview  = document.getElementById('fruitRotPanelPreview');
    const emojiEl  = document.getElementById('fruitRotPanelEmoji');
    const nameEl   = document.getElementById('fruitRotPanelName');

    // Move panel into the viewer, anchored below the brightness control
    const viewer = document.getElementById('viewerEl');
    if(viewer) viewer.appendChild(panel);
    panel.style.cssText = 'display:none;position:absolute;top:58px;right:14px;z-index:50;width:260px;border-radius:14px;overflow:hidden;border:1.5px solid rgba(200,137,74,.30);box-shadow:0 4px 20px rgba(59,31,14,0.35);';

    function getAxis(fruit){ return FRUIT_ROT_AXIS[fruit] || 'z'; }

    function getDeg(m){
        const axis = getAxis(m.fruit);
        return Math.round((m.group.rotation[axis] * 180 / Math.PI + 360) % 360);
    }

    function showPanel(idx){
        activeFruitPanelIdx = idx;
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[idx];
        if(!m) return;
        const em = FRUIT_EMOJI[m.fruit] || '🍓';
        const deg = getDeg(m);
        emojiEl.textContent = em;
        preview.textContent = em;
        nameEl.textContent = m.fruit;
       const degY2 = Math.round((m.group.rotation.y * 180 / Math.PI + 360) % 360);
        range.value = deg;
        degLabel.textContent = deg + '°';
        preview.style.transform = `rotate(${deg}deg)`;
        fruitRangeY.value = degY2;
        fruitDegLabelY.textContent = degY2 + '°';
        panel.style.display = 'block';
        panel.scrollIntoView({behavior:'smooth', block:'nearest'});
    }

    function hidePanel(){
        panel.style.display = 'none';
        activeFruitPanelIdx = -1;
    }

   const fruitRangeY    = document.getElementById('fruitRotPanelRangeY');
    const fruitDegLabelY = document.getElementById('fruitRotPanelDegY');

    range.addEventListener('input', function(){
        const d = parseInt(this.value);
        degLabel.textContent = d + '°';
        preview.style.transform = `rotate(${d}deg)`;
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[activeFruitPanelIdx];
        if(m){ const axis = getAxis(m.fruit); m.group.rotation[axis] = d * Math.PI / 180; }
    });

    fruitRangeY.addEventListener('input', function(){
        const d = parseInt(this.value);
        fruitDegLabelY.textContent = d + '°';
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[activeFruitPanelIdx];
        if(m){ m.group.rotation.y = d * Math.PI / 180; }
    });

    document.querySelectorAll('.fruit-rot-panel-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = parseInt(btn.dataset.deg);
            range.value = d; degLabel.textContent = d + '°';
            preview.style.transform = `rotate(${d}deg)`;
            const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
            const m = models[activeFruitPanelIdx];
            if(m){ const axis = getAxis(m.fruit); m.group.rotation[axis] = d * Math.PI / 180; }
        });
    });

    document.getElementById('fruitRotPanelApply').addEventListener('click', () => {
        const deg = parseInt(range.value);
        const em = emojiEl.textContent;
        showToast(`${em} Rotated ${deg}°`, 1600);
        hidePanel();
    });

document.getElementById('fruitRotPanelReset').addEventListener('click', () => {
        range.value = 0; degLabel.textContent = '0°';
        fruitRangeY.value = 0; fruitDegLabelY.textContent = '0°';
        preview.style.transform = 'rotate(0deg)';
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[activeFruitPanelIdx];
        if(m){ const axis = getAxis(m.fruit); m.group.rotation[axis] = 0; m.group.rotation.y = 0; }
    });

    document.getElementById('fruitRotPanelClose').addEventListener('click', hidePanel);
    document.addEventListener('keydown', e => { if(e.key === 'Escape') hidePanel(); });

    window._showFruitRotatePanel = showPanel;
    window._hideFruitRotatePanel = hidePanel;
    // Keep legacy name working just in case
    window._showFruitRotatePopup = showPanel;
    window._hideFruitRotatePopup = hidePanel;
})();
// ── CHOCO ROTATE INLINE PANEL ──
(function(){
    let activeChocoPanelIdx = -1;
    let activeChocoType = null; // 'ferrero','kitkat','oreo','barshard'

    const CHOCO_EMOJI = { ferrero:'🟤', kitkat:'🍬', oreo:'⚫', barshard:'🍫' };
    const CHOCO_NAME  = { ferrero:'Ferrero', kitkat:'KitKat', oreo:'Oreo', barshard:'Bar Shard' };

    const panel    = document.getElementById('chocoRotInlinePanel');
    const range    = document.getElementById('chocoRotInlineRange');
    const degLabel = document.getElementById('chocoRotInlineDeg');
    const preview  = document.getElementById('chocoRotInlinePreview');
    const emojiEl  = document.getElementById('chocoRotInlineEmoji');
    const nameEl   = document.getElementById('chocoRotInlineName');

    const viewer = document.getElementById('viewerEl');
    if(viewer) viewer.appendChild(panel);
    panel.style.cssText = 'display:none;position:absolute;top:58px;left:14px;z-index:50;width:260px;border-radius:14px;overflow:hidden;border:1.5px solid rgba(196,154,60,.30);box-shadow:0 4px 20px rgba(59,31,14,0.35);';

    function getModels(type){
        if(type==='ferrero') return typeof window.getFerreroModels==='function'?window.getFerreroModels():[];
        if(type==='kitkat')  return typeof window.getKitkatModels ==='function'?window.getKitkatModels() :[];
        if(type==='oreo')    return typeof window.getOreoModels   ==='function'?window.getOreoModels()   :[];
        if(type==='barshard')return typeof window.getBarShardModels==='function'?window.getBarShardModels():[];
        return [];
    }

function getDeg(m){
        return Math.round((m.group.rotation.z * 180 / Math.PI + 360) % 360);
    }
    function getDegY(m){
        return Math.round((m.group.rotation.y * 180 / Math.PI + 360) % 360);
    }

    const rangeY    = document.getElementById('chocoRotInlineRangeY');
    const degLabelY = document.getElementById('chocoRotInlineDegY');

    function showChocoPanel(type, idx){
        activeChocoType = type;
        activeChocoPanelIdx = idx;
        const models = getModels(type);
        const m = models[idx];
        if(!m) return;
        const em = CHOCO_EMOJI[type] || '🍫';
        const deg = getDeg(m);
        const degY = getDegY(m);
        emojiEl.textContent = em;
        preview.textContent = em;
        nameEl.textContent = CHOCO_NAME[type] || type;
        range.value = deg;
        degLabel.textContent = deg + '°';
        preview.style.transform = `rotate(${deg}deg)`;
        rangeY.value = degY;
        degLabelY.textContent = degY + '°';
        panel.style.display = 'block';
    }

    function hideChocoPanel(){
        panel.style.display = 'none';
        activeChocoPanelIdx = -1;
        activeChocoType = null;
    }

range.addEventListener('input', function(){
        const d = parseInt(this.value);
        degLabel.textContent = d + '°';
        preview.style.transform = `rotate(${d}deg)`;
        const models = getModels(activeChocoType);
        const m = models[activeChocoPanelIdx];
        if(m){ m.group.rotation.z = d * Math.PI / 180; }
    });

    rangeY.addEventListener('input', function(){
        const d = parseInt(this.value);
        degLabelY.textContent = d + '°';
        const models = getModels(activeChocoType);
        const m = models[activeChocoPanelIdx];
        if(m){ m.group.rotation.y = d * Math.PI / 180; }
    });

    document.querySelectorAll('.choco-rot-inline-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = parseInt(btn.dataset.deg);
            range.value = d; degLabel.textContent = d + '°';
            preview.style.transform = `rotate(${d}deg)`;
            const models = getModels(activeChocoType);
            const m = models[activeChocoPanelIdx];
            if(m){ m.group.rotation.z = d * Math.PI / 180; }
        });
    });
    document.getElementById('chocoRotInlineApply').addEventListener('click', () => {
        const deg = parseInt(range.value);
        const em = emojiEl.textContent;
        showToast(`${em} Rotated ${deg}°`, 1600);
        hideChocoPanel();
    });
document.getElementById('chocoRotInlineReset').addEventListener('click', () => {
        range.value = 0; degLabel.textContent = '0°';
        rangeY.value = 0; degLabelY.textContent = '0°';
        preview.style.transform = 'rotate(0deg)';
        const models = getModels(activeChocoType);
        const m = models[activeChocoPanelIdx];
        if(m){ m.group.rotation.z = 0; m.group.rotation.y = 0; }
    });
    document.getElementById('chocoRotInlineClose').addEventListener('click', hideChocoPanel);
    document.addEventListener('keydown', e => { if(e.key === 'Escape') hideChocoPanel(); });

    window._showChocoRotatePanel = showChocoPanel;
    window._hideChocoRotatePanel = hideChocoPanel;
})();

window.addEventListener('resize', () => {
    const w = container.clientWidth, h = container.clientHeight;
    renderer.setSize(w, h);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
});

// Fix compressed cake: re-sync size after full layout paint
requestAnimationFrame(() => requestAnimationFrame(() => {
    const w = container.clientWidth, h = container.clientHeight;
    renderer.setSize(w, h);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
}));
</script>

<script>
const FROSTING_PRICES={'Smooth Buttercream':0,'Textured Buttercream':80,'Fondant Smooth':200,'Chocolate Ganache':150,'Semi-naked Style':100,'Sugar Icing':80};
const FONDANT_VAL    ='Fondant Smooth';
const SUGAR_ICING_VAL='Sugar Icing';
const BASE_COAT_VALS =['Smooth Buttercream','Sugar Icing'];
const SHAPE_PRICES   ={'Round':350,'Square':500,'Heart':520,'Two-tier Round':950,'Three-tier Round':1400,'Number':600};
const ROUND_SIZE_PRICES={4:180,5:220,6:280,7:350,8:420,9:500,10:600};
const FRUIT_KEYS=['Strawberry','Blueberry','Raspberry','Cherry'];

const state={
    shape:'Round', tier:'Single', roundSize:6,
    numberDigits:1, numberChoice:0, numberTens:1, numberUnits:0,
    flavor:'Vanilla',
    frostings:new Set(['Smooth Buttercream']),
    addons:new Map(),
    hasDrip:false, dripFlavor:'Vanilla',
    icingColor:'#FFFFFF', icingColorName:'White',
    placedFruits:[],
    placedFerrero:[],
    kitkatOrientation:'standing',
    placedKitkat:[],
    oreoOrientation:'lying',
    placedOreo:[],
    placedBarShard:[],
    placedCandles:[],
};

function showToast(msg,duration=2800){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),duration);}
function allFrostingOpts(){return document.querySelectorAll('.frosting-opt');}

// ── SHAPE ──
document.getElementById('opts-shape').querySelectorAll('[data-val]').forEach(el=>{
    el.addEventListener('click',()=>{
        const prevShape = state.shape;
        const newShape  = el.dataset.val;
        if(newShape === prevShape) return;
        const shapeChanged = newShape !== prevShape;
        document.getElementById('opts-shape').querySelectorAll('[data-val]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
  state.shape = newShape;
        // Reset tier to Single for non-Round shapes
        if(state.shape !== 'Round'){
            state.tier = 'Single';
            document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(x=>x.classList.toggle('active', x.dataset.tier==='Single'));
        }
        // Disable Two/Three-tier buttons when shape is not Round
        document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(x=>{
            const isTiered = x.dataset.tier !== 'Single';
            x.style.opacity = (state.shape !== 'Round' && isTiered) ? '0.35' : '';
            x.style.pointerEvents = (state.shape !== 'Round' && isTiered) ? 'none' : '';
        });
        // Dynamic size label
        const lblMap = {'Round':'Round Size','Square':'Square Size','Heart':'Heart Size','Number':'Number Size'};
        const lbl = document.getElementById('sizeLabelText');
        if(lbl) lbl.textContent = lblMap[state.shape] || 'Cake Size';
        document.getElementById('sizeSliderWrap').classList.toggle('visible', state.shape==='Round');
        document.getElementById('numberPickerWrap').classList.toggle('visible', state.shape==='Number');
        if(shapeChanged){
            if(typeof window.clearFruitModels==='function')   window.clearFruitModels();
            if(typeof window.clearFerreroModels==='function') window.clearFerreroModels();
            if(typeof window.clearKitkatModels==='function')  window.clearKitkatModels();
            if(typeof window.clearOreoModels==='function')    window.clearOreoModels();
            if(typeof window.clearBarShardModels==='function')window.clearBarShardModels();
            state.placedFruits=[];state.placedFerrero=[];state.placedKitkat=[];state.placedOreo=[];state.placedBarShard=[];
           placedFruitRecord.length=0;placedFerreroRecord.length=0;placedKitkatRecord.length=0;placedOreoRecord.length=0;placedBarShardRecord.length=0;placedCandleRecord.length=0;
            attachedFruitIdx=-1;attachedFerreroIdx=-1;attachedKitkatIdx=-1;attachedOreoIdx=-1;attachedBarShardIdx=-1;
            if(typeof window.setDraggingFruitIdx==='function')    window.setDraggingFruitIdx(-1);
            if(typeof window.setDraggingFerreroIdx==='function')  window.setDraggingFerreroIdx(-1);
            if(typeof window.setDraggingKitkatIdx==='function')   window.setDraggingKitkatIdx(-1);
            if(typeof window.setDraggingOreoIdx==='function')     window.setDraggingOreoIdx(-1);
if(typeof window.setDraggingBarShardIdx==='function') window.setDraggingBarShardIdx(-1);
            if(typeof window.clearCandleModels==='function') window.clearCandleModels();
            state.placedCandles=[];
            if(typeof window.setDraggingCandleIdx==='function') window.setDraggingCandleIdx(-1);
            document.getElementById('dragGhost').style.display='none';
            document.getElementById('dropRing').style.display='none';
            document.getElementById('ferreroDropRing').style.display='none';
            document.getElementById('kitkatDropRing').style.display='none';
            document.getElementById('oreoDropRing').style.display='none';
            document.getElementById('barShardDropRing').style.display='none';
            showToast('Shape changed — toppings cleared', 2200);
        }
        redrawFruits();
        updateAll();
    });
});
// ── TIER ──
document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(el=>{
    el.addEventListener('click',()=>{
        if(state.shape !== 'Round' && el.dataset.tier !== 'Single') return;
        document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.tier = el.dataset.tier;
        updateAll();
    });
});

document.getElementById('sizeRange').addEventListener('input',function(){
    if(typeof window._saveAllToppingNormals==='function') window._saveAllToppingNormals();
    state.roundSize=parseInt(this.value);
    document.getElementById('sizeDisplay').textContent=state.roundSize;
    updateAll();
});
function refreshDualPreview(){document.getElementById('dualPreview').childNodes[0].textContent=`${state.numberTens}${state.numberUnits}`;}
document.getElementById('opts-number').querySelectorAll('.num-opt').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-number').querySelectorAll('.num-opt').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.numberChoice=parseInt(el.dataset.val);updateAll();});});
document.getElementById('opts-tens').querySelectorAll('.num-opt-sm').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-tens').querySelectorAll('.num-opt-sm').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.numberTens=parseInt(el.dataset.val);refreshDualPreview();updateAll();});});
document.getElementById('opts-units').querySelectorAll('.num-opt-sm').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-units').querySelectorAll('.num-opt-sm').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.numberUnits=parseInt(el.dataset.val);refreshDualPreview();updateAll();});});
document.getElementById('btnSingleDigit').addEventListener('click',()=>{state.numberDigits=1;document.getElementById('btnSingleDigit').classList.add('active');document.getElementById('btnDualDigit').classList.remove('active');document.getElementById('singleDigitSection').style.display='';document.getElementById('dualDigitSection').classList.remove('visible');updateAll();});
document.getElementById('btnDualDigit').addEventListener('click',()=>{state.numberDigits=2;document.getElementById('btnDualDigit').classList.add('active');document.getElementById('btnSingleDigit').classList.remove('active');document.getElementById('singleDigitSection').style.display='none';document.getElementById('dualDigitSection').classList.add('visible');refreshDualPreview();updateAll();});

// ── FLAVOUR ──
document.getElementById('opts-flavor').querySelectorAll('[data-val]').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-flavor').querySelectorAll('[data-val]').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.flavor=el.dataset.val;updateAll();});});

// ── FROSTING ──
allFrostingOpts().forEach(el=>{
    el.addEventListener('click',()=>{
        if(el.classList.contains('frosting-locked')){showToast('Fondant is solo only — deselect it first');return;}
        const v=el.dataset.val;
        if(v===FONDANT_VAL){
            if(state.frostings.has(FONDANT_VAL)){state.frostings.clear();state.frostings.add('Smooth Buttercream');}
            else{state.frostings.clear();state.frostings.add(FONDANT_VAL);}
        } else if(BASE_COAT_VALS.includes(v)){
            state.frostings.delete(v==='Smooth Buttercream'?'Sugar Icing':'Smooth Buttercream');
            state.frostings.add(v);
        } else {
            if(state.frostings.has(v)) state.frostings.delete(v);
            else state.frostings.add(v);
        }
        syncFrostingUI(); updateAll();
    });
});

function syncFrostingUI(){
    const fondantActive=state.frostings.has(FONDANT_VAL);
    const isSugarIcing =state.frostings.has(SUGAR_ICING_VAL);
    allFrostingOpts().forEach(el=>{
        el.classList.toggle('active',state.frostings.has(el.dataset.val));
        if(fondantActive&&el.dataset.val!==FONDANT_VAL) el.classList.add('frosting-locked');
        else el.classList.remove('frosting-locked');
    });
    document.getElementById('icingPanel').classList.toggle('visible',isSugarIcing&&!fondantActive);
    document.getElementById('fondantNotice').classList.toggle('visible',fondantActive);
    const all=[...state.frostings];
    const hint=document.getElementById('frostingComboHint');
    if(!fondantActive&&all.length>1){hint.classList.add('visible');document.getElementById('frostingComboLabel').textContent=all.join(' + ');}
    else hint.classList.remove('visible');
}

document.getElementById('icingColorGrid').querySelectorAll('.icing-color-opt').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('icingColorGrid').querySelectorAll('.icing-color-opt').forEach(x=>x.classList.remove('active'));
        el.classList.add('active'); state.icingColor=el.dataset.icingColor; state.icingColorName=el.dataset.icingName;
        document.getElementById('icingColorLabel').textContent=el.dataset.icingName;
        updateAll();
    });
});

// ── DRIP ──
document.getElementById('dripToggleBtn').addEventListener('click',()=>{state.hasDrip=!state.hasDrip;document.getElementById('dripToggleBtn').classList.toggle('active',state.hasDrip);document.getElementById('dripFlavorPanel').classList.toggle('visible',state.hasDrip);if(state.hasDrip)state.addons.set('Drip',180);else state.addons.delete('Drip');updateAll();});
document.getElementById('dripFlavorOpts').querySelectorAll('.drip-flavor-opt').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('dripFlavorOpts').querySelectorAll('.drip-flavor-opt').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.dripFlavor=el.dataset.dripFlavor;updateAll();});});
document.getElementById('opts-fruits').querySelectorAll('.addon-opt').forEach(el=>{
    el.addEventListener('click',()=>{const v=el.dataset.val;if(state.addons.has(v)){state.addons.delete(v);el.classList.remove('active');if(typeof window.clearFruitModels==='function')window.clearFruitModels();placedFruitRecord.length=0;state.placedFruits=[];}else{state.addons.set(v,0);}el.classList.toggle('active',state.addons.has(v));updateFruitTray();updateAll();});
});

// ── TRAY STACKING ──
const _trayHeightCache={};
function repositionTrays(){
const order=['fruitTray','chocoTray','candleTray'];
    const BASE=14,GAP=6;
    let currentBottom=BASE;
    order.forEach(id=>{
        const el=document.getElementById(id);if(!el)return;
        if(el.classList.contains('visible')){
            el.style.bottom=currentBottom+'px';
            const h=el.getBoundingClientRect().height;
            if(h>0)_trayHeightCache[id]=h;
            currentBottom+=(_trayHeightCache[id]||54)+GAP;
        } else { el.style.bottom=BASE+'px'; }
    });
    if(!repositionTrays._scheduled){
        repositionTrays._scheduled=true;
        requestAnimationFrame(()=>{requestAnimationFrame(()=>{
            repositionTrays._scheduled=false;
const order2=['fruitTray','chocoTray','candleTray'];
            const BASE2=14,GAP2=6;let cb=BASE2;
            order2.forEach(id=>{
                const el=document.getElementById(id);if(!el)return;
                if(el.classList.contains('visible')){
                    const h=el.getBoundingClientRect().height;if(h>0)_trayHeightCache[id]=h;
                    el.style.bottom=cb+'px';cb+=(_trayHeightCache[id]||54)+GAP2;
                } else { el.style.bottom=BASE2+'px'; }
            });
            const hint=document.getElementById('viewerHint');
            if(hint){let maxBottom=16;order2.forEach(id=>{const el=document.getElementById(id);if(el&&el.classList.contains('visible')){const b=parseInt(el.style.bottom)||14;const h=el.getBoundingClientRect().height||54;maxBottom=Math.max(maxBottom,b+h+8);}});hint.style.bottom=maxBottom+'px';}
        });});
    }
}

function updateFruitTray(){
    const hasFruits=FRUIT_KEYS.some(k=>state.addons.has(k));
    document.getElementById('fruitTray').classList.toggle('visible',hasFruits);
    document.getElementById('fruitsDragNotice').style.display=hasFruits?'flex':'none';
    FRUIT_KEYS.forEach(k=>{const t=document.getElementById('tray'+k);if(t)t.style.display=state.addons.has(k)?'':'none';});
    document.querySelector('.fruit-tray-sep').style.display=hasFruits?'':'none';
    updateViewerHint();repositionTrays();
}

// ── FERRERO TOGGLE ──
document.getElementById('ferreroToggleBtn').addEventListener('click',()=>{
    const v='Ferrero-style Ball';
    if(state.addons.has(v)){state.addons.delete(v);document.getElementById('ferreroToggleBtn').classList.remove('active');if(typeof window.clearFerreroModels==='function')window.clearFerreroModels();state.placedFerrero=[];}
    else{state.addons.set(v,0);document.getElementById('ferreroToggleBtn').classList.add('active');}
    updateFerreroTray();updateAll();
});

// ── KITKAT TOGGLE ──
document.getElementById('kitkatToggleBtn').addEventListener('click',()=>{
    const v='Kitkat Sticks';
    if(state.addons.has(v)){state.addons.delete(v);document.getElementById('kitkatToggleBtn').classList.remove('active');if(typeof window.clearKitkatModels==='function')window.clearKitkatModels();state.placedKitkat=[];}
    else{state.addons.set(v,0);document.getElementById('kitkatToggleBtn').classList.add('active');}
    updateKitkatTray();updateAll();
});

// ── KITKAT ORIENTATION ──
document.getElementById('btnKitkatStanding').addEventListener('click',()=>{state.kitkatOrientation='standing';document.getElementById('btnKitkatStanding').classList.add('active');document.getElementById('btnKitkatLying').classList.remove('active');document.getElementById('kitkatOrientBadge').textContent='📏 Standing';if(typeof window.updateKitkatOrientations==='function')window.updateKitkatOrientations('standing');showToast('🍬 KitKat → Standing mode',1800);});
document.getElementById('btnKitkatLying').addEventListener('click',()=>{state.kitkatOrientation='lying';document.getElementById('btnKitkatLying').classList.add('active');document.getElementById('btnKitkatStanding').classList.remove('active');document.getElementById('kitkatOrientBadge').textContent='📐 Lying Flat';if(typeof window.updateKitkatOrientations==='function')window.updateKitkatOrientations('lying');showToast('🍬 KitKat → Lying Flat mode',1800);});

// ── BAR SHARD TOGGLE ──
document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Bar Shard"]').addEventListener('click',()=>{
    const v='Chocolate Bar Shard';
    const btn=document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Bar Shard"]');
    if(state.addons.has(v)){state.addons.delete(v);btn.classList.remove('active');if(typeof window.clearBarShardModels==='function')window.clearBarShardModels();state.placedBarShard=[];}
    else{state.addons.set(v,0);btn.classList.add('active');}
    updateBarShardTray();updateAll();
});
function updateChocoTray(){
    const hasF=state.addons.has('Ferrero-style Ball'),hasK=state.addons.has('Kitkat Sticks'),hasO=state.addons.has('Oreo Cookie'),hasB=state.addons.has('Chocolate Bar Shard');
    const hasAny=hasF||hasK||hasO||hasB;
    const chocoNotice=document.getElementById('chocoPlaceNotice');
    if(chocoNotice) chocoNotice.style.display=hasAny?'flex':'none';
    document.getElementById('chocoTray').classList.toggle('visible',hasAny);
    document.getElementById('trayFerrero').style.display=hasF?'':'none';
    document.getElementById('trayKitkat').style.display=hasK?'':'none';
    document.getElementById('trayOreo').style.display=hasO?'':'none';
    document.getElementById('trayBarShard').style.display=hasB?'':'none';
    document.getElementById('kitkatOrientBadge').style.display=hasK?'':'none';
    document.getElementById('oreoOrientBadge').style.display=hasO?'':'none';
    const sep1=document.getElementById('chocoTraySep'),sep2=document.getElementById('chocoTraySep2'),clearBtn=document.getElementById('btnClearAllChoco');
    if(sep1)sep1.style.display=hasAny?'':'none';
    if(sep2)sep2.style.display=(hasK||hasO)?'':'none';
    if(clearBtn)clearBtn.style.display=hasAny?'':'none';
    updateViewerHint();repositionTrays();
}
function updateFerreroTray(){updateChocoTray();}
function updateKitkatTray(){updateChocoTray();}
function updateOreoTray(){updateChocoTray();}
function updateBarShardTray(){updateChocoTray();}
function updateCandleTray(){
    const hasCandles=state.addons.has('Number Candles');
    document.getElementById('candlePickerPanel').classList.toggle('visible',hasCandles);
    document.getElementById('candleDragNotice').style.display=hasCandles?'flex':'none';
    document.getElementById('candleTray').classList.toggle('visible',hasCandles);
    updateViewerHint();repositionTrays();
}
// ── OREO TOGGLE ──
document.getElementById('oreoToggleBtn').addEventListener('click',()=>{
    const v='Oreo Cookie';
    if(state.addons.has(v)){state.addons.delete(v);document.getElementById('oreoToggleBtn').classList.remove('active');if(typeof window.clearOreoModels==='function')window.clearOreoModels();state.placedOreo=[];}
    else{state.addons.set(v,0);document.getElementById('oreoToggleBtn').classList.add('active');}
    updateOreoTray();updateAll();
});

// ── OREO ORIENTATION ──
document.getElementById('btnOreoLying').addEventListener('click',()=>{state.oreoOrientation='lying';document.getElementById('btnOreoLying').classList.add('active');document.getElementById('btnOreoStanding').classList.remove('active');document.getElementById('oreoOrientBadge').textContent='⚫ Lying Flat';if(typeof window.updateOreoOrientations==='function')window.updateOreoOrientations('lying');showToast('⚫ Oreo → Lying Flat mode',1800);});
document.getElementById('btnOreoStanding').addEventListener('click',()=>{state.oreoOrientation='standing';document.getElementById('btnOreoStanding').classList.add('active');document.getElementById('btnOreoLying').classList.remove('active');document.getElementById('oreoOrientBadge').textContent='🔘 Standing';if(typeof window.updateOreoOrientations==='function')window.updateOreoOrientations('standing');showToast('⚫ Oreo → Standing mode',1800);});

function updateViewerHint(){
    const hasFruits=FRUIT_KEYS.some(k=>state.addons.has(k));
    const hasF=state.addons.has('Ferrero-style Ball'),hasK=state.addons.has('Kitkat Sticks'),hasO=state.addons.has('Oreo Cookie'),hasB=state.addons.has('Chocolate Bar Shard');
    const parts=[];
 if(hasFruits)parts.push('🍓 Drag fruits');if(hasF)parts.push('🟤 Ferrero balls');if(hasK)parts.push('🍬 KitKat sticks');if(hasO)parts.push('⚫ Oreo cookies');if(hasB)parts.push('🍫 Bar shards');if(state.addons.has('Number Candles'))parts.push('🕯️ Candles');
    document.getElementById('viewerHint').textContent=parts.length>0?parts.join(' · ')+' — drag to place':'🖱 Drag to rotate · Scroll to zoom';
}

// ── FRUIT CANVAS ──
const fruitCanvas=document.getElementById('fruitCanvas'),fctx=fruitCanvas.getContext('2d'),viewerEl=document.getElementById('viewerEl');
function resizeFruitCanvas(){fruitCanvas.width=viewerEl.clientWidth;fruitCanvas.height=viewerEl.clientHeight;redrawFruits();}
window.addEventListener('resize',resizeFruitCanvas);resizeFruitCanvas();
function redrawFruits(){fctx.clearRect(0,0,fruitCanvas.width,fruitCanvas.height);state.placedFruits.forEach(f=>{fctx.font='28px serif';fctx.textAlign='center';fctx.textBaseline='middle';fctx.shadowColor='rgba(0,0,0,0.5)';fctx.shadowBlur=8;fctx.shadowOffsetY=4;fctx.fillText(f.emoji,f.x,f.y);fctx.shadowColor='transparent';fctx.shadowBlur=0;fctx.shadowOffsetY=0;});}

const dragGhost=document.getElementById('dragGhost');
const dropRing=document.getElementById('dropRing');
const ferreroDropRing=document.getElementById('ferreroDropRing');
const kitkatDropRing=document.getElementById('kitkatDropRing');
const oreoDropRing=document.getElementById('oreoDropRing');
const barShardDropRing=document.getElementById('barShardDropRing');
const placedFruitRecord=[],placedFerreroRecord=[],placedKitkatRecord=[],placedOreoRecord=[],placedBarShardRecord=[],placedCandleRecord=[];
let attachedFruitIdx=-1,_pointerDownOnFruit=false;
let attachedFerreroIdx=-1,_pointerDownOnFerrero=false;
let attachedKitkatIdx=-1,_pointerDownOnKitkat=false;
let attachedOreoIdx=-1,_pointerDownOnOreo=false;
let attachedBarShardIdx=-1,_pointerDownOnBarShard=false;
let attachedCandleIdx=-1,_pointerDownOnCandle=false;

function setCursorGrab(on){viewerEl.style.cursor=on?'grabbing':'';}

function updateAttachedFruit(cx,cy){if(attachedFruitIdx<0)return;if(typeof window.moveDraggingFruit==='function')window.moveDraggingFruit(cx,cy);const rect=viewerEl.getBoundingClientRect();dropRing.style.display='block';dropRing.style.left=(cx-rect.left)+'px';dropRing.style.top=(cy-rect.top)+'px';dragGhost.style.left=cx+'px';dragGhost.style.top=cy+'px';dragGhost.style.transform='translate(-50%,-50%)';}
function dropAttachedFruit(cx,cy){if(attachedFruitIdx<0)return;if(typeof window.moveDraggingFruit==='function')window.moveDraggingFruit(cx,cy);if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);const e=placedFruitRecord[attachedFruitIdx];if(e)showToast(`${e.emoji} ${e.fruit} moved!`,1600);attachedFruitIdx=-1;setCursorGrab(false);dropRing.style.display='none';dragGhost.style.display='none';}
function updateAttachedFerrero(cx,cy){if(attachedFerreroIdx<0)return;if(typeof window.moveDraggingFerrero==='function')window.moveDraggingFerrero(cx,cy);const rect=viewerEl.getBoundingClientRect();ferreroDropRing.style.display='block';ferreroDropRing.style.left=(cx-rect.left)+'px';ferreroDropRing.style.top=(cy-rect.top)+'px';}
function dropAttachedFerrero(cx,cy){if(attachedFerreroIdx<0)return;if(typeof window.moveDraggingFerrero==='function')window.moveDraggingFerrero(cx,cy);if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(-1);showToast('🟤 Ferrero ball moved!',1600);attachedFerreroIdx=-1;setCursorGrab(false);ferreroDropRing.style.display='none';dragGhost.style.display='none';}
function updateAttachedKitkat(cx,cy){if(attachedKitkatIdx<0)return;if(typeof window.moveDraggingKitkat==='function')window.moveDraggingKitkat(cx,cy);const rect=viewerEl.getBoundingClientRect();kitkatDropRing.style.display='block';kitkatDropRing.style.left=(cx-rect.left)+'px';kitkatDropRing.style.top=(cy-rect.top)+'px';}
function dropAttachedKitkat(cx,cy){if(attachedKitkatIdx<0)return;if(typeof window.moveDraggingKitkat==='function')window.moveDraggingKitkat(cx,cy);if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(-1);showToast('🍬 KitKat moved!',1600);attachedKitkatIdx=-1;setCursorGrab(false);kitkatDropRing.style.display='none';dragGhost.style.display='none';}
function updateAttachedOreo(cx,cy){if(attachedOreoIdx<0)return;if(typeof window.moveDraggingOreo==='function')window.moveDraggingOreo(cx,cy);const rect=viewerEl.getBoundingClientRect();oreoDropRing.style.display='block';oreoDropRing.style.left=(cx-rect.left)+'px';oreoDropRing.style.top=(cy-rect.top)+'px';}
function dropAttachedOreo(cx,cy){if(attachedOreoIdx<0)return;if(typeof window.moveDraggingOreo==='function')window.moveDraggingOreo(cx,cy);if(typeof window.setDraggingOreoIdx==='function')window.setDraggingOreoIdx(-1);showToast('⚫ Oreo moved!',1600);attachedOreoIdx=-1;setCursorGrab(false);oreoDropRing.style.display='none';dragGhost.style.display='none';}
function updateAttachedBarShard(cx,cy){if(attachedBarShardIdx<0)return;if(typeof window.moveDraggingBarShard==='function')window.moveDraggingBarShard(cx,cy);const rect=viewerEl.getBoundingClientRect();barShardDropRing.style.display='block';barShardDropRing.style.left=(cx-rect.left)+'px';barShardDropRing.style.top=(cy-rect.top)+'px';}
function dropAttachedBarShard(cx,cy){if(attachedBarShardIdx<0)return;if(typeof window.moveDraggingBarShard==='function')window.moveDraggingBarShard(cx,cy);if(typeof window.setDraggingBarShardIdx==='function')window.setDraggingBarShardIdx(-1);showToast('🍫 Bar shard moved!',1600);attachedBarShardIdx=-1;setCursorGrab(false);barShardDropRing.style.display='none';dragGhost.style.display='none';}
function updateAttachedCandle(cx,cy){if(attachedCandleIdx<0)return;if(typeof window.moveDraggingCandle==='function')window.moveDraggingCandle(cx,cy);const rect=viewerEl.getBoundingClientRect();const cdr=document.getElementById('candleDropRing');cdr.style.display='block';cdr.style.left=(cx-rect.left)+'px';cdr.style.top=(cy-rect.top)+'px';}
function dropAttachedCandle(cx,cy){if(attachedCandleIdx<0)return;if(typeof window.moveDraggingCandle==='function')window.moveDraggingCandle(cx,cy);if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(-1);const e=placedCandleRecord[attachedCandleIdx];if(e)showToast(`🕯️ Candle #${e.num} moved!`,1600);attachedCandleIdx=-1;setCursorGrab(false);document.getElementById('candleDropRing').style.display='none';dragGhost.style.display='none';}
function hookCanvasPointerDown(){
    const canvas=document.querySelector('#model-container canvas');
    if(!canvas){setTimeout(hookCanvasPointerDown,100);return;}
    canvas.addEventListener('pointerdown',e=>{
        if(attachedFruitIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnFruit=true;return;}
        if(attachedFerreroIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnFerrero=true;return;}
        if(attachedKitkatIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnKitkat=true;return;}
        if(attachedOreoIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnOreo=true;return;}
        if(attachedBarShardIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnBarShard=true;return;}
        if(typeof window.getBarShardIndexAtScreen==='function'){const bidx=window.getBarShardIndexAtScreen(e.clientX,e.clientY);if(bidx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnBarShard=true;attachedBarShardIdx=bidx;if(typeof window.setDraggingBarShardIdx==='function')window.setDraggingBarShardIdx(bidx);setCursorGrab(true);dragGhost.textContent='🍫';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Move & click to place',1800);return;}}
        if(typeof window.getOreoIndexAtScreen==='function'){const oidx=window.getOreoIndexAtScreen(e.clientX,e.clientY);if(oidx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnOreo=true;attachedOreoIdx=oidx;if(typeof window.setDraggingOreoIdx==='function')window.setDraggingOreoIdx(oidx);setCursorGrab(true);dragGhost.textContent='⚫';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Move & click to place',1800);return;}}
        if(typeof window.getKitkatIndexAtScreen==='function'){const kidx=window.getKitkatIndexAtScreen(e.clientX,e.clientY);if(kidx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnKitkat=true;attachedKitkatIdx=kidx;if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(kidx);setCursorGrab(true);dragGhost.textContent='🍬';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Move & click to place',1800);return;}}
        if(typeof window.getFerreroIndexAtScreen==='function'){const fidx=window.getFerreroIndexAtScreen(e.clientX,e.clientY);if(fidx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnFerrero=true;attachedFerreroIdx=fidx;if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(fidx);setCursorGrab(true);dragGhost.textContent='🟤';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Move & click to place',1800);return;}}
if(typeof window.getFruitIndexAtScreen==='function'){const idx=window.getFruitIndexAtScreen(e.clientX,e.clientY);if(idx>=0){e.stopPropagation();e.preventDefault();
    _pointerDownOnFruit=true;attachedFruitIdx=idx;
    if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(idx);
    const en=placedFruitRecord[idx];dragGhost.textContent=en?en.emoji:'🍓';
    dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';
    setCursorGrab(true);
    // track if this turns into a drag or stays a click
    window._fruitPointerMoved=false;
    window._fruitClickIdx=idx;window._fruitClickX=e.clientX;window._fruitClickY=e.clientY;
    return;
}}
        if(typeof window.getCandleIndexAtScreen==='function'){const cidx=window.getCandleIndexAtScreen(e.clientX,e.clientY);if(cidx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnCandle=true;attachedCandleIdx=cidx;if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(cidx);setCursorGrab(true);dragGhost.textContent='🕯️';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Move & click to place',1800);return;}}
        _pointerDownOnFruit=false;_pointerDownOnFerrero=false;_pointerDownOnKitkat=false;_pointerDownOnOreo=false;
    },{capture:true});
    canvas.addEventListener('pointermove',e=>{
    if(attachedFruitIdx>=0){
        const dx=e.clientX-(window._fruitClickX||e.clientX),dy=e.clientY-(window._fruitClickY||e.clientY);
        if(Math.abs(dx)>4||Math.abs(dy)>4) window._fruitPointerMoved=true;
        updateAttachedFruit(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';
    }
    if(attachedFerreroIdx>=0){updateAttachedFerrero(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedKitkatIdx>=0){updateAttachedKitkat(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedOreoIdx>=0){updateAttachedOreo(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedBarShardIdx>=0){updateAttachedBarShard(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedCandleIdx>=0){updateAttachedCandle(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
});
    canvas.addEventListener('pointerup',e=>{
        if(_pointerDownOnFruit){_pointerDownOnFruit=false;
            if(attachedFruitIdx>=0){
                if(!window._fruitPointerMoved){
                    // it was a tap/click — show inline rotate panel, cancel drag
                    if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);
                    const idx=attachedFruitIdx;attachedFruitIdx=-1;setCursorGrab(false);dragGhost.style.display='none';dropRing.style.display='none';
                    if(typeof window._showFruitRotatePanel==='function')window._showFruitRotatePanel(idx);
                } else {
                    dropAttachedFruit(e.clientX,e.clientY);
                }
            }
        }
 if(_pointerDownOnFerrero){_pointerDownOnFerrero=false;if(attachedFerreroIdx>=0){if(typeof window._showChocoRotatePanel==='function')window._showChocoRotatePanel('ferrero',attachedFerreroIdx);if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(-1);attachedFerreroIdx=-1;setCursorGrab(false);ferreroDropRing.style.display='none';}}
if(_pointerDownOnKitkat){_pointerDownOnKitkat=false;if(attachedKitkatIdx>=0){if(typeof window._showChocoRotatePanel==='function')window._showChocoRotatePanel('kitkat',attachedKitkatIdx);if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(-1);attachedKitkatIdx=-1;setCursorGrab(false);kitkatDropRing.style.display='none';}}
if(_pointerDownOnOreo){_pointerDownOnOreo=false;if(attachedOreoIdx>=0){if(typeof window._showChocoRotatePanel==='function')window._showChocoRotatePanel('oreo',attachedOreoIdx);if(typeof window.setDraggingOreoIdx==='function')window.setDraggingOreoIdx(-1);attachedOreoIdx=-1;setCursorGrab(false);oreoDropRing.style.display='none';}}
if(_pointerDownOnBarShard){_pointerDownOnBarShard=false;if(attachedBarShardIdx>=0){if(typeof window._showChocoRotatePanel==='function')window._showChocoRotatePanel('barshard',attachedBarShardIdx);if(typeof window.setDraggingBarShardIdx==='function')window.setDraggingBarShardIdx(-1);attachedBarShardIdx=-1;setCursorGrab(false);barShardDropRing.style.display='none';}}
    });
}
hookCanvasPointerDown();

document.addEventListener('mousemove',e=>{
    if(attachedFruitIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedFruit(e.clientX,e.clientY);}
    if(attachedFerreroIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedFerrero(e.clientX,e.clientY);}
    if(attachedKitkatIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedKitkat(e.clientX,e.clientY);}
    if(attachedOreoIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedOreo(e.clientX,e.clientY);}
if(attachedBarShardIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedBarShard(e.clientX,e.clientY);}
    if(attachedCandleIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedCandle(e.clientX,e.clientY);}
});
viewerEl.addEventListener('click',e=>{
    // Fruits are handled in pointerup — skip here to avoid double-firing
    if(attachedFerreroIdx>=0){dropAttachedFerrero(e.clientX,e.clientY);return;}
    if(attachedKitkatIdx>=0){dropAttachedKitkat(e.clientX,e.clientY);return;}
    if(attachedOreoIdx>=0){dropAttachedOreo(e.clientX,e.clientY);return;}
    if(attachedBarShardIdx>=0){dropAttachedBarShard(e.clientX,e.clientY);return;}
    if(attachedCandleIdx>=0){dropAttachedCandle(e.clientX,e.clientY);}
},true);

// ── DRAG FROM TRAY ──
let activeTrayDrag=null,isDraggingFromTray=false;
let activeFerreroDrag=null,isDraggingFerreroFromTray=false;
let activeKitkatDrag=null,isDraggingKitkatFromTray=false;
let activeBarShardDrag=null,isDraggingBarShardFromTray=false;
let activeOreoDrag=null,isDraggingOreoFromTray=false;

document.querySelectorAll('.fruit-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedFruitIdx>=0){attachedFruitIdx=-1;if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);setCursorGrab(false);dropRing.style.display='none';dragGhost.style.display='none';}activeTrayDrag={fruit:el.dataset.fruit,emoji:el.dataset.emoji,type:'fruit'};isDraggingFromTray=true;dragGhost.textContent=el.dataset.emoji;dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';dragGhost.style.fontSize='2rem';dragGhost.style.position='fixed';dragGhost.style.pointerEvents='none';dragGhost.style.zIndex='99999';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.willChange='left,top';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';dropRing.style.display='none';viewerEl.classList.remove('fruit-drag-over');isDraggingFromTray=false;activeTrayDrag=null;});});
document.querySelectorAll('.ferrero-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedFerreroIdx>=0){attachedFerreroIdx=-1;if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(-1);setCursorGrab(false);ferreroDropRing.style.display='none';dragGhost.style.display='none';}activeFerreroDrag={type:'ferrero',emoji:'🟤'};isDraggingFerreroFromTray=true;dragGhost.textContent='🟤';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';ferreroDropRing.style.display='none';viewerEl.classList.remove('ferrero-drag-over');isDraggingFerreroFromTray=false;activeFerreroDrag=null;});});
document.querySelectorAll('.kitkat-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedKitkatIdx>=0){attachedKitkatIdx=-1;if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(-1);setCursorGrab(false);kitkatDropRing.style.display='none';dragGhost.style.display='none';}activeKitkatDrag={type:'kitkat',emoji:'🍬'};isDraggingKitkatFromTray=true;dragGhost.textContent='🍬';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';kitkatDropRing.style.display='none';viewerEl.classList.remove('kitkat-drag-over');isDraggingKitkatFromTray=false;activeKitkatDrag=null;});});
document.querySelectorAll('.bar-shard-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedBarShardIdx>=0){attachedBarShardIdx=-1;if(typeof window.setDraggingBarShardIdx==='function')window.setDraggingBarShardIdx(-1);setCursorGrab(false);barShardDropRing.style.display='none';dragGhost.style.display='none';}activeBarShardDrag={type:'barShard',emoji:'🍫'};isDraggingBarShardFromTray=true;dragGhost.textContent='🍫';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';barShardDropRing.style.display='none';viewerEl.classList.remove('bar-shard-drag-over');isDraggingBarShardFromTray=false;activeBarShardDrag=null;});});
document.querySelectorAll('.oreo-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedOreoIdx>=0){attachedOreoIdx=-1;if(typeof window.setDraggingOreoIdx==='function')window.setDraggingOreoIdx(-1);setCursorGrab(false);oreoDropRing.style.display='none';dragGhost.style.display='none';}activeOreoDrag={type:'oreo',emoji:'⚫'};isDraggingOreoFromTray=true;dragGhost.textContent='⚫';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';oreoDropRing.style.display='none';viewerEl.classList.remove('oreo-drag-over');isDraggingOreoFromTray=false;activeOreoDrag=null;});});

// ── CANDLE TOGGLE & NUMBER PICKER ──
let selectedCandleNum=1;
document.getElementById('opts-candles').querySelector('[data-val="Number Candles"]').addEventListener('click',()=>{
    const v='Number Candles';
    if(state.addons.has(v)){
        state.addons.delete(v);
        document.getElementById('opts-candles').querySelector('[data-val="Number Candles"]').classList.remove('active');
        if(typeof window.clearCandleModels==='function')window.clearCandleModels();
        state.placedCandles=[];placedCandleRecord.length=0;
        attachedCandleIdx=-1;if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(-1);
        setCursorGrab(false);dragGhost.style.display='none';document.getElementById('candleDropRing').style.display='none';
    } else {
        state.addons.set(v,0);
        document.getElementById('opts-candles').querySelector('[data-val="Number Candles"]').classList.add('active');
    }
    updateCandleTray();updateAll();
});
document.getElementById('opts-candle-nums').querySelectorAll('.candle-num-opt').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('opts-candle-nums').querySelectorAll('.candle-num-opt').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        selectedCandleNum=parseInt(el.dataset.candleNum);
        document.getElementById('trayCandleLabel').textContent=`Candle #${selectedCandleNum}`;
        document.getElementById('candleActiveBadge').textContent=`Selected: Candle #${selectedCandleNum} — drag to place`;
    });
});

// ── CANDLE TRAY DRAG ──
let activeCandleDrag=null,isDraggingCandleFromTray=false;
document.getElementById('trayCandle').addEventListener('dragstart',e=>{
    if(attachedCandleIdx>=0){attachedCandleIdx=-1;if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(-1);setCursorGrab(false);document.getElementById('candleDropRing').style.display='none';dragGhost.style.display='none';}
    activeCandleDrag={type:'candle',num:selectedCandleNum};isDraggingCandleFromTray=true;dragGhost.textContent='🕯️';dragGhost.style.display='block';
    const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';
});
document.getElementById('trayCandle').addEventListener('dragend',()=>{dragGhost.style.display='none';document.getElementById('candleDropRing').style.display='none';viewerEl.classList.remove('candle-drag-over');isDraggingCandleFromTray=false;activeCandleDrag=null;});

document.addEventListener('dragover',e=>{
    const rect=viewerEl.getBoundingClientRect();
    const over=e.clientX>=rect.left&&e.clientX<=rect.right&&e.clientY>=rect.top&&e.clientY<=rect.bottom;
    if(isDraggingFromTray&&activeTrayDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('fruit-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';dropRing.style.display='block';dropRing.style.left=(e.clientX-rect.left)+'px';dropRing.style.top=(e.clientY-rect.top)+'px';}else dropRing.style.display='none';}
    if(isDraggingFerreroFromTray&&activeFerreroDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('ferrero-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';ferreroDropRing.style.display='block';ferreroDropRing.style.left=(e.clientX-rect.left)+'px';ferreroDropRing.style.top=(e.clientY-rect.top)+'px';}else ferreroDropRing.style.display='none';}
    if(isDraggingKitkatFromTray&&activeKitkatDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('kitkat-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';kitkatDropRing.style.display='block';kitkatDropRing.style.left=(e.clientX-rect.left)+'px';kitkatDropRing.style.top=(e.clientY-rect.top)+'px';}else kitkatDropRing.style.display='none';}
    if(isDraggingOreoFromTray&&activeOreoDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('oreo-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';oreoDropRing.style.display='block';oreoDropRing.style.left=(e.clientX-rect.left)+'px';oreoDropRing.style.top=(e.clientY-rect.top)+'px';}else oreoDropRing.style.display='none';}
if(isDraggingBarShardFromTray&&activeBarShardDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('bar-shard-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';barShardDropRing.style.display='block';barShardDropRing.style.left=(e.clientX-rect.left)+'px';barShardDropRing.style.top=(e.clientY-rect.top)+'px';}else barShardDropRing.style.display='none';}
    if(isDraggingCandleFromTray&&activeCandleDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('candle-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';const cdr=document.getElementById('candleDropRing');cdr.style.display='block';cdr.style.left=(e.clientX-rect.left)+'px';cdr.style.top=(e.clientY-rect.top)+'px';}else document.getElementById('candleDropRing').style.display='none';}
});
viewerEl.addEventListener('dragover',e=>e.preventDefault());

viewerEl.addEventListener('drop',async e=>{
    e.preventDefault();
    dropRing.style.display='none';ferreroDropRing.style.display='none';kitkatDropRing.style.display='none';oreoDropRing.style.display='none';
    viewerEl.classList.remove('fruit-drag-over','ferrero-drag-over','kitkat-drag-over','oreo-drag-over');
    if(activeBarShardDrag&&isDraggingBarShardFromTray){isDraggingBarShardFromTray=false;activeBarShardDrag=null;dragGhost.style.display='none';if(typeof window.placeBarShardOnCake==='function'){const idx=await window.placeBarShardOnCake(e.clientX,e.clientY);if(idx>=0){placedBarShardRecord[idx]={emoji:'🍫'};state.placedBarShard.push({x:e.clientX,y:e.clientY});showToast('🍫 Bar shard placed! Click to move.',2200);updateAll();}}return;}
    if(activeOreoDrag&&isDraggingOreoFromTray){isDraggingOreoFromTray=false;activeOreoDrag=null;dragGhost.style.display='none';if(typeof window.placeOreoOnCake==='function'){const idx=await window.placeOreoOnCake(e.clientX,e.clientY,state.oreoOrientation);if(idx>=0){placedOreoRecord[idx]={emoji:'⚫'};state.placedOreo.push({x:e.clientX,y:e.clientY,orientation:state.oreoOrientation});showToast(`⚫ Oreo placed ${state.oreoOrientation==='standing'?'standing up':'lying flat'}! Click to move.`,2200);updateAll();}}return;}
    if(activeKitkatDrag&&isDraggingKitkatFromTray){isDraggingKitkatFromTray=false;activeKitkatDrag=null;dragGhost.style.display='none';if(typeof window.placeKitkatOnCake==='function'){const idx=await window.placeKitkatOnCake(e.clientX,e.clientY,state.kitkatOrientation);if(idx>=0){placedKitkatRecord[idx]={emoji:'🍬'};state.placedKitkat.push({x:e.clientX,y:e.clientY,orientation:state.kitkatOrientation});showToast(`🍬 KitKat placed ${state.kitkatOrientation==='standing'?'standing up':'lying flat'}! Click to move.`,2200);updateAll();}}return;}
    if(activeFerreroDrag&&isDraggingFerreroFromTray){isDraggingFerreroFromTray=false;activeFerreroDrag=null;dragGhost.style.display='none';if(typeof window.placeFerreroOnCake==='function'){const idx=await window.placeFerreroOnCake(e.clientX,e.clientY);if(idx>=0){placedFerreroRecord[idx]={emoji:'🟤'};state.placedFerrero.push({x:e.clientX,y:e.clientY});showToast('🟤 Ferrero placed! Click it to move.',2200);updateAll();}}return;}
 if(activeTrayDrag&&isDraggingFromTray){const{fruit,emoji}=activeTrayDrag;isDraggingFromTray=false;activeTrayDrag=null;dragGhost.style.display='none';window._fruitPointerMoved=false;if(typeof window.placeFruitOnCake==='function'){const idx=await window.placeFruitOnCake(fruit,e.clientX,e.clientY);if(idx>=0){placedFruitRecord[idx]={fruit,emoji};showToast(`${emoji} ${fruit} placed! Drag to move, tap to rotate.`,2200);updateAll();}}}
    if(activeCandleDrag&&isDraggingCandleFromTray){const num=activeCandleDrag.num;isDraggingCandleFromTray=false;activeCandleDrag=null;dragGhost.style.display='none';document.getElementById('candleDropRing').style.display='none';viewerEl.classList.remove('candle-drag-over');if(typeof window.placeCandleOnCake==='function'){const idx=await window.placeCandleOnCake(num,e.clientX,e.clientY);if(idx>=0){placedCandleRecord[idx]={num};state.placedCandles.push({x:e.clientX,y:e.clientY,num});showToast(`🕯️ Candle #${num} placed! Click to move.`,2200);updateAll();}}}
});

let touchTrayFruit=null,touchAttachedIdx=-1;
let touchFerreroFruit=null,touchFerreroAttachedIdx=-1;
let touchKitkatFruit=null,touchKitkatAttachedIdx=-1;
let touchOreoFruit=null,touchOreoAttachedIdx=-1;
let touchCandleFruit=null,touchCandleAttachedIdx=-1;
document.querySelectorAll('.fruit-draggable').forEach(el=>{el.addEventListener('touchstart',e=>{touchTrayFruit={fruit:el.dataset.fruit,emoji:el.dataset.emoji};dragGhost.textContent=touchTrayFruit.emoji;dragGhost.style.display='block';},{passive:true});});
document.querySelectorAll('.ferrero-draggable').forEach(el=>{el.addEventListener('touchstart',e=>{touchFerreroFruit={emoji:'🟤'};dragGhost.textContent='🟤';dragGhost.style.display='block';},{passive:true});});
document.querySelectorAll('.kitkat-draggable').forEach(el=>{el.addEventListener('touchstart',e=>{touchKitkatFruit={emoji:'🍬'};dragGhost.textContent='🍬';dragGhost.style.display='block';},{passive:true});});
document.querySelectorAll('.oreo-draggable').forEach(el=>{el.addEventListener('touchstart',e=>{touchOreoFruit={emoji:'⚫'};dragGhost.textContent='⚫';dragGhost.style.display='block';},{passive:true});});
document.getElementById('trayCandle').addEventListener('touchstart',e=>{touchCandleFruit={num:selectedCandleNum};dragGhost.textContent='🕯️';dragGhost.style.display='block';},{passive:true});
document.addEventListener('touchmove',e=>{
 if(!touchTrayFruit&&touchAttachedIdx<0&&!touchFerreroFruit&&touchFerreroAttachedIdx<0&&!touchKitkatFruit&&touchKitkatAttachedIdx<0&&!touchOreoFruit&&touchOreoAttachedIdx<0&&!touchCandleFruit&&touchCandleAttachedIdx<0)return;
    const t=e.touches[0];dragGhost.style.left=t.clientX+'px';dragGhost.style.top=t.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';
    const rect=viewerEl.getBoundingClientRect(),over=t.clientX>=rect.left&&t.clientX<=rect.right&&t.clientY>=rect.top&&t.clientY<=rect.bottom;
    if(touchTrayFruit||touchAttachedIdx>=0){if(over){dropRing.style.display='block';dropRing.style.left=(t.clientX-rect.left)+'px';dropRing.style.top=(t.clientY-rect.top)+'px';if(touchAttachedIdx>=0&&typeof window.moveDraggingFruit==='function')window.moveDraggingFruit(t.clientX,t.clientY);}else dropRing.style.display='none';}
    if(touchFerreroFruit||touchFerreroAttachedIdx>=0){if(over){ferreroDropRing.style.display='block';ferreroDropRing.style.left=(t.clientX-rect.left)+'px';ferreroDropRing.style.top=(t.clientY-rect.top)+'px';if(touchFerreroAttachedIdx>=0&&typeof window.moveDraggingFerrero==='function')window.moveDraggingFerrero(t.clientX,t.clientY);}else ferreroDropRing.style.display='none';}
    if(touchKitkatFruit||touchKitkatAttachedIdx>=0){if(over){kitkatDropRing.style.display='block';kitkatDropRing.style.left=(t.clientX-rect.left)+'px';kitkatDropRing.style.top=(t.clientY-rect.top)+'px';if(touchKitkatAttachedIdx>=0&&typeof window.moveDraggingKitkat==='function')window.moveDraggingKitkat(t.clientX,t.clientY);}else kitkatDropRing.style.display='none';}
if(touchOreoFruit||touchOreoAttachedIdx>=0){if(over){oreoDropRing.style.display='block';oreoDropRing.style.left=(t.clientX-rect.left)+'px';oreoDropRing.style.top=(t.clientY-rect.top)+'px';if(touchOreoAttachedIdx>=0&&typeof window.moveDraggingOreo==='function')window.moveDraggingOreo(t.clientX,t.clientY);}else oreoDropRing.style.display='none';}
    if(touchCandleFruit||touchCandleAttachedIdx>=0){const cdr=document.getElementById('candleDropRing');if(over){cdr.style.display='block';cdr.style.left=(t.clientX-rect.left)+'px';cdr.style.top=(t.clientY-rect.top)+'px';if(touchCandleAttachedIdx>=0&&typeof window.moveDraggingCandle==='function')window.moveDraggingCandle(t.clientX,t.clientY);}else cdr.style.display='none';}
},{passive:true});
document.addEventListener('touchend',async e=>{
    const t=e.changedTouches[0];const rect=viewerEl.getBoundingClientRect(),over=t.clientX>=rect.left&&t.clientX<=rect.right&&t.clientY>=rect.top&&t.clientY<=rect.bottom;
    dragGhost.style.display='none';dropRing.style.display='none';ferreroDropRing.style.display='none';kitkatDropRing.style.display='none';oreoDropRing.style.display='none';
    if(touchAttachedIdx>=0){if(over&&typeof window.moveDraggingFruit==='function')window.moveDraggingFruit(t.clientX,t.clientY);if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);const en=placedFruitRecord[touchAttachedIdx];if(en)showToast(`${en.emoji} repositioned`,1400);touchAttachedIdx=-1;touchTrayFruit=null;return;}
 if(touchTrayFruit&&over&&typeof window.placeFruitOnCake==='function'){const{fruit,emoji}=touchTrayFruit;window._fruitPointerMoved=false;const idx=await window.placeFruitOnCake(fruit,t.clientX,t.clientY);if(idx>=0){placedFruitRecord[idx]={fruit,emoji};showToast(`${emoji} ${fruit} placed! Drag to move, tap to rotate.`,2000);updateAll();}}touchTrayFruit=null;
    if(touchFerreroAttachedIdx>=0){if(over&&typeof window.moveDraggingFerrero==='function')window.moveDraggingFerrero(t.clientX,t.clientY);if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(-1);showToast('🟤 Ferrero repositioned',1400);touchFerreroAttachedIdx=-1;touchFerreroFruit=null;return;}
    if(touchFerreroFruit&&over&&typeof window.placeFerreroOnCake==='function'){const idx=await window.placeFerreroOnCake(t.clientX,t.clientY);if(idx>=0){placedFerreroRecord[idx]={emoji:'🟤'};state.placedFerrero.push({x:t.clientX,y:t.clientY});showToast('🟤 Ferrero placed! Tap to move.',2000);updateAll();}}touchFerreroFruit=null;
    if(touchKitkatAttachedIdx>=0){if(over&&typeof window.moveDraggingKitkat==='function')window.moveDraggingKitkat(t.clientX,t.clientY);if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(-1);showToast('🍬 KitKat repositioned',1400);touchKitkatAttachedIdx=-1;touchKitkatFruit=null;return;}
    if(touchKitkatFruit&&over&&typeof window.placeKitkatOnCake==='function'){const idx=await window.placeKitkatOnCake(t.clientX,t.clientY,state.kitkatOrientation);if(idx>=0){placedKitkatRecord[idx]={emoji:'🍬'};state.placedKitkat.push({x:t.clientX,y:t.clientY,orientation:state.kitkatOrientation});showToast(`🍬 KitKat placed! Tap to move.`,2000);updateAll();}}touchKitkatFruit=null;
    if(touchOreoAttachedIdx>=0){if(over&&typeof window.moveDraggingOreo==='function')window.moveDraggingOreo(t.clientX,t.clientY);if(typeof window.setDraggingOreoIdx==='function')window.setDraggingOreoIdx(-1);showToast('⚫ Oreo repositioned',1400);touchOreoAttachedIdx=-1;touchOreoFruit=null;return;}
if(touchOreoFruit&&over&&typeof window.placeOreoOnCake==='function'){const idx=await window.placeOreoOnCake(t.clientX,t.clientY,state.oreoOrientation);if(idx>=0){placedOreoRecord[idx]={emoji:'⚫'};state.placedOreo.push({x:t.clientX,y:t.clientY,orientation:state.oreoOrientation});showToast(`⚫ Oreo placed! Tap to move.`,2000);updateAll();}}touchOreoFruit=null;
    if(touchCandleAttachedIdx>=0){if(over&&typeof window.moveDraggingCandle==='function')window.moveDraggingCandle(t.clientX,t.clientY);if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(-1);const ce=placedCandleRecord[touchCandleAttachedIdx];if(ce)showToast(`🕯️ Candle #${ce.num} repositioned`,1400);touchCandleAttachedIdx=-1;touchCandleFruit=null;return;}
    if(touchCandleFruit&&over&&typeof window.placeCandleOnCake==='function'){const idx=await window.placeCandleOnCake(selectedCandleNum,t.clientX,t.clientY);if(idx>=0){placedCandleRecord[idx]={num:selectedCandleNum};state.placedCandles.push({x:t.clientX,y:t.clientY,num:selectedCandleNum});showToast(`🕯️ Candle #${selectedCandleNum} placed! Tap to move.`,2000);updateAll();}}touchCandleFruit=null;
},{passive:true});
viewerEl.addEventListener('touchstart',e=>{
    const t=e.touches[0];
    if(!touchTrayFruit&&touchAttachedIdx<0&&typeof window.getFruitIndexAtScreen==='function'){const idx=window.getFruitIndexAtScreen(t.clientX,t.clientY);if(idx>=0){e.preventDefault();e.stopPropagation();touchAttachedIdx=idx;if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(idx);const en=placedFruitRecord[idx];dragGhost.textContent=en?en.emoji:'🍓';dragGhost.style.left=t.clientX+'px';dragGhost.style.top=t.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Drag to move fruit',1400);return;}}
    if(!touchFerreroFruit&&touchFerreroAttachedIdx<0&&typeof window.getFerreroIndexAtScreen==='function'){const idx=window.getFerreroIndexAtScreen(t.clientX,t.clientY);if(idx>=0){e.preventDefault();e.stopPropagation();touchFerreroAttachedIdx=idx;if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(idx);dragGhost.textContent='🟤';dragGhost.style.left=t.clientX+'px';dragGhost.style.top=t.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Drag to move Ferrero',1400);return;}}
    if(!touchKitkatFruit&&touchKitkatAttachedIdx<0&&typeof window.getKitkatIndexAtScreen==='function'){const idx=window.getKitkatIndexAtScreen(t.clientX,t.clientY);if(idx>=0){e.preventDefault();e.stopPropagation();touchKitkatAttachedIdx=idx;if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(idx);dragGhost.textContent='🍬';dragGhost.style.left=t.clientX+'px';dragGhost.style.top=t.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Drag to move KitKat',1400);return;}}
if(!touchOreoFruit&&touchOreoAttachedIdx<0&&typeof window.getOreoIndexAtScreen==='function'){const idx=window.getOreoIndexAtScreen(t.clientX,t.clientY);if(idx>=0){e.preventDefault();e.stopPropagation();touchOreoAttachedIdx=idx;if(typeof window.setDraggingOreoIdx==='function')window.setDraggingOreoIdx(idx);dragGhost.textContent='⚫';dragGhost.style.left=t.clientX+'px';dragGhost.style.top=t.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Drag to move Oreo',1400);return;}}
    if(!touchCandleFruit&&touchCandleAttachedIdx<0&&typeof window.getCandleIndexAtScreen==='function'){const idx=window.getCandleIndexAtScreen(t.clientX,t.clientY);if(idx>=0){e.preventDefault();e.stopPropagation();touchCandleAttachedIdx=idx;if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(idx);dragGhost.textContent='🕯️';dragGhost.style.left=t.clientX+'px';dragGhost.style.top=t.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Drag to move candle',1400);return;}}
},{passive:false});

// ── CLEAR BUTTONS ──
document.getElementById('btnClearCandles').addEventListener('click',()=>{
    attachedCandleIdx=-1;touchCandleAttachedIdx=-1;
    if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(-1);
    setCursorGrab(false);dragGhost.style.display='none';document.getElementById('candleDropRing').style.display='none';
    state.placedCandles=[];placedCandleRecord.length=0;
    if(typeof window.clearCandleModels==='function')window.clearCandleModels();
    showToast('🕯️ Candles cleared',1800);updateAll();
});
document.getElementById('btnClearFruits').addEventListener('click',()=>{attachedFruitIdx=-1;touchAttachedIdx=-1;if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);setCursorGrab(false);dragGhost.style.display='none';dropRing.style.display='none';state.placedFruits=[];placedFruitRecord.length=0;redrawFruits();if(typeof window.clearFruitModels==='function')window.clearFruitModels();showToast('Fruits cleared',1800);});
document.getElementById('btnClearAllChoco').addEventListener('click',()=>{
    attachedFerreroIdx=-1;attachedKitkatIdx=-1;attachedOreoIdx=-1;attachedBarShardIdx=-1;
    if(typeof window.clearFerreroModels==='function')window.clearFerreroModels();
    if(typeof window.clearKitkatModels==='function')window.clearKitkatModels();
    if(typeof window.clearOreoModels==='function')window.clearOreoModels();
    if(typeof window.clearBarShardModels==='function')window.clearBarShardModels();
    state.placedFerrero=[];state.placedKitkat=[];state.placedOreo=[];state.placedBarShard=[];
    placedFerreroRecord.length=0;placedKitkatRecord.length=0;placedOreoRecord.length=0;placedBarShardRecord.length=0;
    setCursorGrab(false);dragGhost.style.display='none';ferreroDropRing.style.display='none';kitkatDropRing.style.display='none';oreoDropRing.style.display='none';barShardDropRing.style.display='none';
    showToast('🍫 All chocolate decorations cleared',1800);updateAll();
});

['opts-choco','opts-sprinkles','opts-candles','opts-deco'].forEach(id=>{
    document.getElementById(id).querySelectorAll('.addon-opt').forEach(el=>{
        // These all have their own dedicated toggle listeners — skip them here
        if(['ferreroToggleBtn','kitkatToggleBtn','oreoToggleBtn'].includes(el.id))return;
        if(el.dataset.val==='Chocolate Bar Shard')return;
        if(el.dataset.val==='Number Candles')return;
        el.addEventListener('click',()=>{
            const v=el.dataset.val,p=parseInt(el.dataset.price)||0;
            if(state.addons.has(v)){state.addons.delete(v);el.classList.remove('active');}
            else{state.addons.set(v,p);el.classList.add('active');}
            updateAll();
        });
    });
});
function getEffectiveShape(){
    if(state.shape==='Round'&&state.tier==='Two-tier')   return 'Two-tier Round';
    if(state.shape==='Round'&&state.tier==='Three-tier') return 'Three-tier Round';
    return state.shape;
}
function getBasePrice(){const eff=getEffectiveShape();return eff==='Round'?(ROUND_SIZE_PRICES[state.roundSize]||350):(SHAPE_PRICES[eff]||350);}
function getFrostingExtraPrice(){let e=0;state.frostings.forEach(f=>{e+=(FROSTING_PRICES[f]||0);});return e;}
function getShapeLabel(){const eff=getEffectiveShape();if(eff==='Round')return `Round ${state.roundSize}"`;if(eff==='Number'){if(state.numberDigits===2)return `Number ${state.numberTens}${state.numberUnits}`;return `Number ${state.numberChoice}`;}return eff;}
// ── MAIN UPDATE ──
function updateAll(){
    const base=getBasePrice(),frostExtra=getFrostingExtraPrice();
// These are priced per placed piece — exclude from flat addon sum
    const PER_PIECE_KEYS=new Set(['Ferrero-style Ball','Kitkat Sticks','Oreo Cookie','Chocolate Bar Shard','Number Candles','Strawberry','Blueberry','Raspberry','Cherry']);
    let addonTotal=0;state.addons.forEach((p,k)=>{if(!PER_PIECE_KEYS.has(k))addonTotal+=p;});
 const FRUIT_PRICES={'Strawberry':45,'Blueberry':25,'Raspberry':55,'Cherry':35};
    const fruitCounts={};
    if(typeof window.getFruitModels==='function'){window.getFruitModels().forEach(m=>{fruitCounts[m.fruit]=(fruitCounts[m.fruit]||0)+1;});}
    FRUIT_KEYS.forEach(k=>{addonTotal+=(fruitCounts[k]||0)*(FRUIT_PRICES[k]||0);});
    const ferreroCount=(typeof window.getFerreroModels==='function')?window.getFerreroModels().length:state.placedFerrero.length;
    const kitkatCount=(typeof window.getKitkatModels==='function')?window.getKitkatModels().length:state.placedKitkat.length;
    const oreoCount=(typeof window.getOreoModels==='function')?window.getOreoModels().length:state.placedOreo.length;
const barShardCount2=(typeof window.getBarShardModels==='function')?window.getBarShardModels().length:0;
    const candleCount=(typeof window.getCandleModels==='function')?window.getCandleModels().length:state.placedCandles.length;
if(state.addons.has('Ferrero-style Ball'))addonTotal+=ferreroCount*55;
    if(state.addons.has('Kitkat Sticks'))addonTotal+=kitkatCount*30;
    if(state.addons.has('Oreo Cookie'))addonTotal+=oreoCount*20;
    if(state.addons.has('Chocolate Bar Shard'))addonTotal+=barShardCount2*40;
    if(state.addons.has('Number Candles'))addonTotal+=candleCount*20;
    // Fruits: always count placed pieces regardless of addons map value
    // (already computed above via fruitCounts loop)
    const total=base+frostExtra+addonTotal;
    document.getElementById('priceBase').textContent='₱'+base.toLocaleString();
    document.getElementById('priceAddons').textContent='₱'+addonTotal.toLocaleString();
    document.getElementById('priceTotal').textContent=total.toLocaleString();
    document.getElementById('priceAddons').classList.toggle('zero',addonTotal===0);
    const frostRow=document.getElementById('priceFrostingRow');
    if(frostExtra>0){frostRow.style.display='';document.getElementById('priceFrosting').textContent='₱'+frostExtra.toLocaleString();}else frostRow.style.display='none';
    const shapeLabel=getShapeLabel(),frostingLabel=[...state.frostings].join(' + ');
    const isSugarIcing=state.frostings.has(SUGAR_ICING_VAL),isFondant=state.frostings.has(FONDANT_VAL);
    document.getElementById('selShape').textContent=shapeLabel;
    document.getElementById('selFlavor').textContent=state.flavor;
    document.getElementById('selFrosting').textContent=frostingLabel;
    document.getElementById('badgeFlavor').textContent=state.flavor;
    document.getElementById('badgeShape').textContent=shapeLabel+' · '+frostingLabel;
    const icingRow=document.getElementById('selIcingRow');
    if(isSugarIcing){icingRow.style.display='';document.getElementById('selIcingColor').textContent=state.icingColorName;}else icingRow.style.display='none';
    if(state.hasDrip){document.getElementById('selDripRow').style.display='';document.getElementById('selDrip').textContent=state.dripFlavor+' Drip';}else document.getElementById('selDripRow').style.display='none';
    const fruitKeys=FRUIT_KEYS.filter(k=>state.addons.has(k));
    if(fruitKeys.length>0){document.getElementById('selFruitsRow').style.display='';document.getElementById('selFruits').textContent=fruitKeys.join(', ');}else document.getElementById('selFruitsRow').style.display='none';
    const hasF=state.addons.has('Ferrero-style Ball');
    if(hasF){document.getElementById('selFerreroRow').style.display='';document.getElementById('selFerrero').textContent=ferreroCount>0?`${ferreroCount} placed`:'Selected · drag to place';}else document.getElementById('selFerreroRow').style.display='none';
    const hasK=state.addons.has('Kitkat Sticks');
    if(hasK){document.getElementById('selKitkatRow').style.display='';const ol=state.kitkatOrientation==='standing'?'Standing':'Lying Flat';document.getElementById('selKitkat').textContent=kitkatCount>0?`${kitkatCount} placed · ${ol}`:`Selected · ${ol}`;}else document.getElementById('selKitkatRow').style.display='none';
    const hasO=state.addons.has('Oreo Cookie');
    if(hasO){document.getElementById('selOreoRow').style.display='';const ol=state.oreoOrientation==='standing'?'Standing':'Lying Flat';document.getElementById('selOreo').textContent=oreoCount>0?`${oreoCount} placed · ${ol}`:`Selected · ${ol}`;}else document.getElementById('selOreoRow').style.display='none';
    const hasB=state.addons.has('Chocolate Bar Shard');
    const barShardCount=(typeof window.getBarShardModels==='function')?window.getBarShardModels().length:state.placedBarShard.length;
    if(hasB){document.getElementById('selBarShardRow').style.display='';document.getElementById('selBarShard').textContent=barShardCount>0?`${barShardCount} placed`:'Selected · drag to place';}else document.getElementById('selBarShardRow').style.display='none';
    const chips=[];
    if(isFondant)chips.push(`<span class="cfg-chip chip-gold">⬜ Fondant</span>`);
    else{[...state.frostings].forEach(f=>{if(f===SUGAR_ICING_VAL)chips.push(`<span class="cfg-chip chip-gold">🍦 Sugar Icing · ${state.icingColorName}</span>`);else if(state.frostings.size>1||f!=='Smooth Buttercream')chips.push(`<span class="cfg-chip chip-teal">${f}</span>`);});}
    if(state.hasDrip)chips.push(`<span class="cfg-chip chip-teal">💧 ${state.dripFlavor} Drip</span>`);
    if(hasF)chips.push(`<span class="cfg-chip chip-gold">🟤 Ferrero${ferreroCount>0?' ×'+ferreroCount:''}</span>`);
    if(hasK)chips.push(`<span class="cfg-chip chip-accent">🍬 KitKat${kitkatCount>0?' ×'+kitkatCount:''} · ${state.kitkatOrientation==='standing'?'Standing':'Flat'}</span>`);
    if(hasO)chips.push(`<span class="cfg-chip chip-accent">⚫ Oreo${oreoCount>0?' ×'+oreoCount:''} · ${state.oreoOrientation==='standing'?'Standing':'Flat'}</span>`);
 if(hasB)chips.push(`<span class="cfg-chip chip-accent">🍫 Bar Shard${barShardCount>0?' ×'+barShardCount:''}</span>`);
    if(state.addons.has('Number Candles'))chips.push(`<span class="cfg-chip chip-gold">🕯️ Candles${candleCount>0?' ×'+candleCount:''}</span>`);
  const fruitChipKeys=new Set(FRUIT_KEYS);
    state.addons.forEach((p,k)=>{
        if(['Drip','Ferrero-style Ball','Kitkat Sticks','Oreo Cookie','Chocolate Bar Shard','Number Candles'].includes(k))return;
        if(fruitChipKeys.has(k))return; // fruits shown via selFruitsRow, not chips
        chips.push(`<span class="cfg-chip chip-accent">${k}</span>`);
    });
    document.getElementById('addonsSummary').innerHTML=chips.length?chips.join(''):'<span class="cfg-val muted" style="font-size:.73rem;">None selected</span>';
    if(typeof window.updateModel==='function'){window.updateModel({...state,shape:getEffectiveShape(),frostings:[...state.frostings],frosting:[...state.frostings][0],icingColor:isSugarIcing?state.icingColor:null});}
}

// ── SAVE DRAFT ──
async function saveDraft(){
    const btn=document.getElementById('btnSaveDraft');
    const cfg={shape:state.shape,roundSize:state.roundSize,numberDigits:state.numberDigits,numberChoice:state.numberChoice,numberTens:state.numberTens,numberUnits:state.numberUnits,flavor:state.flavor,frostings:[...state.frostings],addons:[...state.addons.keys()],hasDrip:state.hasDrip,dripFlavor:state.dripFlavor,icingColor:state.icingColor,icingColorName:state.icingColorName,placedFruits:state.placedFruits,placedFerrero:state.placedFerrero,kitkatOrientation:state.kitkatOrientation,placedKitkat:state.placedKitkat,oreoOrientation:state.oreoOrientation,placedOreo:state.placedOreo};
    try{
        const res=await fetch('{{ route("customer.cake-builder.saveDraft") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify(cfg)});
        if(res.ok){btn.classList.add('saved');btn.innerHTML=`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><polyline points="20 6 9 17 4 12"/></svg> Saved!`;showToast('✓ Draft saved successfully');setTimeout(()=>{btn.classList.remove('saved');btn.innerHTML=`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Save Draft`;},3000);}
    }catch(e){showToast('⚠ Could not save draft');}
}
document.getElementById('btnSaveDraft').addEventListener('click',saveDraft);

// ── LOAD DRAFT ──
async function loadDraft(){
    try{
        const res=await fetch('{{ route("customer.cake-builder.loadDraft") }}');
        const data=await res.json();const d=data.draft;
        if(!d){showToast('No saved draft found');return;}
        document.getElementById('opts-shape').querySelectorAll('[data-val]').forEach(el=>el.classList.toggle('active',el.dataset.val===d.shape));
        state.shape=d.shape||'Round';
        if(d.roundSize){state.roundSize=d.roundSize;document.getElementById('sizeRange').value=state.roundSize;document.getElementById('sizeDisplay').textContent=state.roundSize;}
        document.getElementById('sizeSliderWrap').classList.toggle('visible',state.shape==='Round');
        document.getElementById('numberPickerWrap').classList.toggle('visible',state.shape==='Number');
        if(state.shape==='Number'){
            const digits=d.numberDigits||1;state.numberDigits=digits;const isSingle=digits===1;
            document.getElementById('btnSingleDigit').classList.toggle('active',isSingle);document.getElementById('btnDualDigit').classList.toggle('active',!isSingle);
            document.getElementById('singleDigitSection').style.display=isSingle?'':'none';document.getElementById('dualDigitSection').classList.toggle('visible',!isSingle);
            if(isSingle&&d.numberChoice!==undefined){state.numberChoice=d.numberChoice;document.getElementById('opts-number').querySelectorAll('.num-opt').forEach(el=>el.classList.toggle('active',parseInt(el.dataset.val)===state.numberChoice));}
            else if(!isSingle){state.numberTens=d.numberTens??1;state.numberUnits=d.numberUnits??0;document.getElementById('opts-tens').querySelectorAll('.num-opt-sm').forEach(el=>el.classList.toggle('active',parseInt(el.dataset.val)===state.numberTens));document.getElementById('opts-units').querySelectorAll('.num-opt-sm').forEach(el=>el.classList.toggle('active',parseInt(el.dataset.val)===state.numberUnits));refreshDualPreview();}
        }
        document.getElementById('opts-flavor').querySelectorAll('[data-val]').forEach(el=>el.classList.toggle('active',el.dataset.val===d.flavor));state.flavor=d.flavor;
        state.frostings=new Set();const savedFrostings=Array.isArray(d.frostings)?d.frostings:(d.frosting?[d.frosting]:['Smooth Buttercream']);savedFrostings.forEach(f=>state.frostings.add(f));if(state.frostings.size===0)state.frostings.add('Smooth Buttercream');
        state.icingColor=d.icingColor||'#FFFFFF';state.icingColorName=d.icingColorName||'White';document.getElementById('icingColorGrid').querySelectorAll('.icing-color-opt').forEach(el=>el.classList.toggle('active',el.dataset.icingColor===state.icingColor));document.getElementById('icingColorLabel').textContent=state.icingColorName;
        syncFrostingUI();
        state.hasDrip=!!d.hasDrip;state.dripFlavor=d.dripFlavor||'Vanilla';document.getElementById('dripToggleBtn').classList.toggle('active',state.hasDrip);document.getElementById('dripFlavorPanel').classList.toggle('visible',state.hasDrip);document.getElementById('dripFlavorOpts').querySelectorAll('.drip-flavor-opt').forEach(el=>el.classList.toggle('active',el.dataset.dripFlavor===state.dripFlavor));
        if(d.kitkatOrientation){state.kitkatOrientation=d.kitkatOrientation;document.getElementById('btnKitkatStanding').classList.toggle('active',d.kitkatOrientation==='standing');document.getElementById('btnKitkatLying').classList.toggle('active',d.kitkatOrientation==='lying');document.getElementById('kitkatOrientBadge').textContent=d.kitkatOrientation==='standing'?'📏 Standing':'📐 Lying Flat';}
        if(d.oreoOrientation){state.oreoOrientation=d.oreoOrientation;document.getElementById('btnOreoStanding').classList.toggle('active',d.oreoOrientation==='standing');document.getElementById('btnOreoLying').classList.toggle('active',d.oreoOrientation==='lying');document.getElementById('oreoOrientBadge').textContent=d.oreoOrientation==='standing'?'🔘 Standing':'⚫ Lying Flat';}
        state.addons=new Map();
        document.getElementById('opts-fruits').querySelectorAll('.addon-opt').forEach(el=>{const inDraft=(d.addons||[]).includes(el.dataset.val);el.classList.toggle('active',inDraft);if(inDraft)state.addons.set(el.dataset.val,parseInt(el.dataset.price)||0);});
        document.querySelectorAll('#opts-choco .addon-opt,#opts-sprinkles .addon-opt,#opts-candles .addon-opt,#opts-deco .addon-opt').forEach(el=>{
            const special=['ferreroToggleBtn','kitkatToggleBtn','oreoToggleBtn'];
            if(special.includes(el.id)){const keyMap={ferreroToggleBtn:'Ferrero-style Ball',kitkatToggleBtn:'Kitkat Sticks',oreoToggleBtn:'Oreo Cookie'};const inDraft=(d.addons||[]).includes(keyMap[el.id]);el.classList.toggle('active',inDraft);if(inDraft){state.addons.set(keyMap[el.id],parseInt(el.dataset.price)||0);if(el.id==='kitkatToggleBtn')updateKitkatTray();if(el.id==='oreoToggleBtn')updateOreoTray();if(el.id==='ferreroToggleBtn')updateFerreroTray();}return;}
            const inDraft=(d.addons||[]).includes(el.dataset.val);el.classList.toggle('active',inDraft);if(inDraft)state.addons.set(el.dataset.val,parseInt(el.dataset.price)||0);
        });
        if(state.hasDrip)state.addons.set('Drip',180);
        state.placedFruits=Array.isArray(d.placedFruits)?d.placedFruits:[];state.placedFerrero=Array.isArray(d.placedFerrero)?d.placedFerrero:[];state.placedKitkat=Array.isArray(d.placedKitkat)?d.placedKitkat:[];state.placedOreo=Array.isArray(d.placedOreo)?d.placedOreo:[];
        redrawFruits();updateFruitTray();updateFerreroTray();updateKitkatTray();updateOreoTray();updateAll();showToast('✓ Draft loaded');
    }catch(e){showToast('⚠ Could not load draft');}
}
document.getElementById('btnLoadDraft').addEventListener('click',loadDraft);

function proceed(){
    const base=getBasePrice(),frostExtra=getFrostingExtraPrice();
    let addonTotal=0; state.addons.forEach(p=>addonTotal+=p);
    const isSugarIcing=state.frostings.has(SUGAR_ICING_VAL);
    const ferreroCount=(typeof window.getFerreroModels==='function')?window.getFerreroModels().length:0;
    const kitkatCount=(typeof window.getKitkatModels==='function')?window.getKitkatModels().length:0;
    const oreoCount=(typeof window.getOreoModels==='function')?window.getOreoModels().length:0;

    document.getElementById('configInput').value=JSON.stringify({
        shape:state.shape,
        roundSize:state.shape==='Round'?state.roundSize:null,
        numberDigits:state.shape==='Number'?state.numberDigits:null,
        numberChoice:state.shape==='Number'&&state.numberDigits===1?state.numberChoice:null,
        numberTens:state.shape==='Number'&&state.numberDigits===2?state.numberTens:null,
        numberUnits:state.shape==='Number'&&state.numberDigits===2?state.numberUnits:null,
        shapeLabel:getShapeLabel(),
        flavor:state.flavor,
        frostings:[...state.frostings],
        frosting:[...state.frostings].join(' + '),
        hasDrip:state.hasDrip,
        dripFlavor:state.hasDrip?state.dripFlavor:null,
        hasIcing:isSugarIcing,
        icingColor:isSugarIcing?state.icingColor:null,
        icingColorName:isSugarIcing?state.icingColorName:null,
        addons:[...state.addons.keys()],
        ferreroCount,kitkatCount,kitkatOrientation:state.kitkatOrientation,
        oreoCount,oreoOrientation:state.oreoOrientation,
        placedFruits:state.placedFruits,
        placedFerrero:state.placedFerrero,
        placedKitkat:state.placedKitkat,
        placedOreo:state.placedOreo,
        total:base+frostExtra+addonTotal
    });

    // Capture canvas and submit via POST to a save-preview route
    const canvas = document.querySelector('#model-container canvas');
    if (canvas) {
        try {
            const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
            document.getElementById('cakePreviewInput').value = dataUrl;
        } catch(e) {
            console.warn('Could not capture canvas:', e);
        }
    }

    document.getElementById('proceedForm').submit();
}
document.getElementById('btnProceed').addEventListener('click',proceed);
document.getElementById('btnProceedLg').addEventListener('click',proceed);
document.getElementById('btnResetView').addEventListener('click',()=>{if(typeof window.resetCamera==='function')window.resetCamera();showToast('View reset');});
document.getElementById('spotBrightnessSlider').addEventListener('input', function(){
    const val = parseInt(this.value) / 100;
    document.getElementById('spotBrightnessVal').textContent = this.value + '%';
    if(typeof window._setSpotBrightness === 'function') window._setSpotBrightness(val);
});

syncFrostingUI();
function tryInit(){if(typeof window.updateModel==='function')updateAll();else setTimeout(tryInit,80);}
tryInit();

// ── MOBILE SUMMARY SHEET ──
function initMobileSummary(){
    const btn     = document.getElementById('mobileSummaryBtn');
    const sheet   = document.getElementById('mobileSummarySheet');
    const close   = document.getElementById('closeMobileSummary');
    const content = document.getElementById('mobileSummaryContent');
    const badge   = document.getElementById('mobileTotalBadge');

    if(!btn || !sheet || !close || !content || !badge) return; // guard

    function isMobile(){ return window.innerWidth <= 768; }

    function updateMobileBtn(){
        btn.style.display = isMobile() ? 'flex' : 'none';
        badge.textContent = '₱' + document.getElementById('priceTotal').textContent;
    }

    function showSheet(){
        const rightPanel = document.querySelector('.panel:last-child');
        content.innerHTML = rightPanel ? rightPanel.innerHTML : '';
        sheet.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function hideSheet(){
        sheet.style.display = 'none';
        document.body.style.overflow = '';
    }

    btn.addEventListener('click', showSheet);
    close.addEventListener('click', hideSheet);
    sheet.addEventListener('click', e => { if(e.target === sheet) hideSheet(); });
    window.addEventListener('resize', updateMobileBtn);
    updateMobileBtn();

    // Keep badge synced with total
    const totalEl = document.getElementById('priceTotal');
    if(totalEl){
        new MutationObserver(()=>{
            badge.textContent = '₱' + totalEl.textContent;
        }).observe(totalEl, {childList:true, characterData:true, subtree:true});
    }
}
initMobileSummary();
</script>
<!-- Mobile summary sheet trigger -->
<div id="mobileSummaryBtn" style="display:none;position:fixed;bottom:16px;right:16px;z-index:200;background:var(--accent);color:#fff;border:none;border-radius:50px;padding:10px 18px;font-family:var(--font-body);font-size:.82rem;font-weight:600;cursor:pointer;box-shadow:0 4px 16px rgba(184,92,56,.40);align-items:center;gap:7px;">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    <span id="mobileTotalBadge">₱350</span>
</div>

<div id="mobileSummarySheet" style="display:none;position:fixed;inset:0;z-index:300;background:rgba(44,24,16,0.55);backdrop-filter:blur(4px);">
    <div id="mobileSummaryDrawer" style="position:absolute;bottom:0;left:0;right:0;background:var(--surface);border-radius:18px 18px 0 0;padding:0 0 24px;max-height:80vh;overflow-y:auto;">
        <div style="padding:12px 18px 10px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-family:var(--font-display);font-size:1rem;font-weight:600;">Summary</span>
            <button id="closeMobileSummary" style="background:transparent;border:none;cursor:pointer;color:var(--text-muted);font-size:1.2rem;line-height:1;">✕</button>
        </div>
        <div id="mobileSummaryContent" style="padding:14px 18px;"></div>
    </div>
</div>
<div id="chocoRotInlinePanel" style="display:none;">
    <div style="background:linear-gradient(135deg,#2A1006 0%,#4A2010 100%);padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:8px;">
            <span id="chocoRotInlineEmoji" style="font-size:1.4rem;line-height:1;">🟤</span>
            <div>
                <div style="font-size:.68rem;font-weight:700;color:var(--caramel-light);font-family:var(--font-display);">Rotate <span id="chocoRotInlineName">Ferrero</span></div>
                <div style="font-size:.60rem;color:rgba(232,176,122,0.55);font-family:var(--font-display);">Tap to rotate · Click again to place</div>
            </div>
        </div>
        <button id="chocoRotInlineClose" style="background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.15);border-radius:7px;color:rgba(232,176,122,0.7);font-size:.75rem;cursor:pointer;padding:4px 8px;font-family:var(--font-display);">Done</button>
    </div>
    <div style="background:var(--warm-white);padding:12px 14px;">
   <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
            <span id="chocoRotInlinePreview" style="font-size:2.2rem;line-height:1;display:block;transition:transform .18s;flex-shrink:0;">🟤</span>
            <div style="flex:1;">
                <div style="font-size:.60rem;color:var(--text-muted);margin-bottom:3px;font-family:var(--font-display);font-weight:600;">↕ Tilt (up/down)</div>
                <input type="range" id="chocoRotInlineRange" min="0" max="360" step="5" value="0" class="rot-range" style="width:100%;">
                <div id="chocoRotInlineDeg" style="text-align:center;font-size:.80rem;font-weight:700;color:var(--gold);font-family:var(--font-display);margin-top:2px;">0°</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <span style="font-size:2.2rem;line-height:1;flex-shrink:0;opacity:0;">🟤</span>
            <div style="flex:1;">
                <div style="font-size:.60rem;color:var(--text-muted);margin-bottom:3px;font-family:var(--font-display);font-weight:600;">↔ Spin (sideways)</div>
                <input type="range" id="chocoRotInlineRangeY" min="0" max="360" step="5" value="0" class="rot-range" style="width:100%;">
                <div id="chocoRotInlineDegY" style="text-align:center;font-size:.80rem;font-weight:700;color:var(--gold);font-family:var(--font-display);margin-top:2px;">0°</div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:5px;margin-bottom:10px;">
            <button class="choco-rot-inline-preset" data-deg="0"   style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">0°</button>
            <button class="choco-rot-inline-preset" data-deg="90"  style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">90°</button>
            <button class="choco-rot-inline-preset" data-deg="180" style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">180°</button>
            <button class="choco-rot-inline-preset" data-deg="270" style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">270°</button>
        </div>
        <div style="display:flex;gap:6px;">
            <button id="chocoRotInlineApply" style="flex:1;padding:9px;background:var(--gold);border:none;border-radius:10px;color:#fff;font-size:.76rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">✓ Apply Rotation</button>
            <button id="chocoRotInlineReset" style="padding:9px 12px;background:transparent;border:1.5px solid var(--border-dk);border-radius:10px;color:var(--text-muted);font-size:.72rem;font-weight:600;cursor:pointer;font-family:var(--font-display);">↺</button>
        </div>
    </div>
</div>
<div id="fruitRotPanel" style="display:none;">
    <div style="background:linear-gradient(135deg,var(--brown-deep) 0%,var(--brown-mid) 100%);padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:8px;">
            <span id="fruitRotPanelEmoji" style="font-size:1.4rem;line-height:1;">🍓</span>
            <div>
                <div style="font-size:.68rem;font-weight:700;color:var(--caramel-light);font-family:var(--font-display);">Rotate <span id="fruitRotPanelName">Strawberry</span></div>
                <div style="font-size:.60rem;color:rgba(232,176,122,0.55);font-family:var(--font-display);">Drag to move · Tap to rotate</div>
            </div>
        </div>
        <button id="fruitRotPanelClose" style="background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.15);border-radius:7px;color:rgba(232,176,122,0.7);font-size:.75rem;cursor:pointer;padding:4px 8px;font-family:var(--font-display);">Done</button>
    </div>
    <div style="background:var(--warm-white);padding:12px 14px;">
       <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
            <span id="fruitRotPanelPreview" style="font-size:2.2rem;line-height:1;display:block;transition:transform .18s;flex-shrink:0;">🍓</span>
            <div style="flex:1;">
                <div style="font-size:.60rem;color:var(--text-muted);margin-bottom:3px;font-family:var(--font-display);font-weight:600;">↕ Tilt (up/down)</div>
                <input type="range" id="fruitRotPanelRange" min="0" max="360" step="5" value="0" class="rot-range" style="width:100%;">
                <div id="fruitRotPanelDeg" style="text-align:center;font-size:.80rem;font-weight:700;color:var(--caramel);font-family:var(--font-display);margin-top:2px;">0°</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <span style="font-size:2.2rem;line-height:1;flex-shrink:0;opacity:0;">🍓</span>
            <div style="flex:1;">
                <div style="font-size:.60rem;color:var(--text-muted);margin-bottom:3px;font-family:var(--font-display);font-weight:600;">↔ Spin (sideways)</div>
                <input type="range" id="fruitRotPanelRangeY" min="0" max="360" step="5" value="0" class="rot-range" style="width:100%;">
                <div id="fruitRotPanelDegY" style="text-align:center;font-size:.80rem;font-weight:700;color:var(--caramel);font-family:var(--font-display);margin-top:2px;">0°</div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:5px;margin-bottom:10px;">
            <button class="fruit-rot-panel-preset" data-deg="0"   style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .15s;">0°</button>
            <button class="fruit-rot-panel-preset" data-deg="90"  style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .15s;">90°</button>
            <button class="fruit-rot-panel-preset" data-deg="180" style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .15s;">180°</button>
            <button class="fruit-rot-panel-preset" data-deg="270" style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .15s;">270°</button>
        </div>
        <div style="display:flex;gap:6px;">
            <button id="fruitRotPanelApply" style="flex:1;padding:9px;background:var(--caramel);border:none;border-radius:10px;color:#fff;font-size:.76rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .18s;">✓ Apply Rotation</button>
            <button id="fruitRotPanelReset" style="padding:9px 12px;background:transparent;border:1.5px solid var(--border-dk);border-radius:10px;color:var(--text-muted);font-size:.72rem;font-weight:600;cursor:pointer;font-family:var(--font-display);">↺</button>
        </div>
    </div>
</div>
</body>
</html>  