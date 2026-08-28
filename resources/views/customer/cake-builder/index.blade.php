<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Builder — BakeSphere</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&family=Dancing+Script:wght@600;700&display=swap" rel="stylesheet">
    <style>
/* ============================================================
   BAKESPHERE — ATELIER CONFIGURATOR
   New visual system. Same brand palette + fonts as before,
   completely new layout language: a wide-screen "studio" with
   a floating step rail, a full-bleed cake stage, and a ticket-
   style order card. Built on top of the untouched builder logic.
   ============================================================ */

:root {
    --brown-deep:    #3B1F0E;
    --brown-mid:     #6B3A1F;
    --caramel:       #A0673A;
    --caramel-light: #C9A17C;
    --warm-white:    #FFFFFF;
    --cream:         #F7F4EF;

--bg:        #F7F1E8;
    --surface:   #FFFFFF;
    --border:    #E0D2BC;
    --border-dk: #C9AF8C;
    --text:      #2E1A0D;
    --text-muted:#8A7B6C;
    --accent:    #A0673A;
    --accent-dk: #7A4C28;
    --accent-lt: #F5EFE6;
    --gold:      #B08A3E;
    --gold-lt:   #F7F1E2;
    --teal:      #1F7A6C;
    --teal-soft: #E4F2EF;
    --rail-w:    84px;
    --studio-w:  428px;
    --ticket-w:  392px;
    --nav-h:     60px;
    --radius:    18px;
    --radius-sm: 12px;
    --radius-lg: 26px;
    --radius-pill: 999px;

    --sp-1: 4px;  --sp-2: 8px;  --sp-3: 12px; --sp-4: 16px;
    --sp-5: 20px; --sp-6: 24px; --sp-7: 32px; --sp-8: 40px;

    --shadow-xs: 0 1px 2px rgba(59,31,14,0.05);
    --shadow-sm: 0 3px 10px rgba(59,31,14,0.08);
    --shadow-md: 0 10px 26px rgba(59,31,14,0.12);
    --shadow-lg: 0 24px 60px rgba(59,31,14,0.22);
    --shadow-glow: 0 0 0 2px rgba(200,137,74,0.35);

    --ease: cubic-bezier(0.4, 0, 0.2, 1);
    --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
    --transition: 0.16s var(--ease);
    --transition-md: 0.28s var(--ease-out);

    --font-display: 'Plus Jakarta Sans', system-ui, sans-serif;
    --font-body:    'Plus Jakarta Sans', system-ui, sans-serif;
    --font-mono:    'DM Mono', 'Plus Jakarta Sans', monospace;
}

@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
}

* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; }
body {
    font-family: var(--font-display);
    background: var(--bg);
    color: var(--text);
    border-top: 4px solid var(--brown-deep);
    height: 100vh; overflow: hidden;
    display: flex; flex-direction: column;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
}

a:focus-visible, button:focus-visible, [tabindex]:focus-visible,
.shape-opt:focus-visible, .opt:focus-visible, .addon-opt:focus-visible,
.icing-color-opt:focus-visible, input:focus-visible {
    outline: 2.5px solid var(--caramel);
    outline-offset: 2px;
    border-radius: 6px;
}
::selection { background: rgba(200,137,74,0.28); color: var(--brown-deep); }

nav {
    height: var(--nav-h);
    background: var(--brown-deep);
    border-bottom: 2.5px solid var(--brown-deep);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 var(--sp-6);
    flex-shrink: 0;
    z-index: 100;
    position: relative;
}
.nav-left { display: flex; align-items: center; gap: var(--sp-4); }
.btn-back {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px;
    border: 1.5px solid rgba(255,255,255,0.30);
    border-radius: var(--radius-pill);
    background: rgba(255,255,255,0.10);
    color: var(--warm-white);
    font-family: var(--font-body); font-size: .78rem; font-weight: 600;
    cursor: pointer; text-decoration: none;
    transition: all var(--transition);
}
.btn-back:hover { border-color: var(--caramel-light); color: var(--caramel-light); background: rgba(255,255,255,0.18); }
.nav-divider { display: none; }
.nav-brand {
    font-family: var(--font-display);
    font-size: 1.30rem; font-weight: 800;
    color: var(--warm-white); text-decoration: none; letter-spacing: -0.03em;
}
.nav-brand em { color: var(--caramel-light); font-style: normal; font-weight: 400; }
.nav-right { display: flex; align-items: center; gap: var(--sp-3); }

.nav-center {
    display: flex; align-items: center; gap: 18px;
    position: absolute; left: 50%; top: 50%;
    transform: translate(-50%, -50%);
}
.nav-step {
    display: flex; align-items: center; gap: 8px;
    font-family: var(--font-mono); font-size: .66rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: rgba(255,255,255,0.45);
}
.nav-step.active { color: var(--warm-white); }
.step-dot { width: 18px; height: 3px; border-radius: 2px; background: rgba(255,255,255,0.25); flex-shrink: 0; transition: all var(--transition-md); }
.nav-step.active .step-dot { background: var(--caramel-light); width: 26px; }
.step-line { display: none; }
.btn-save-draft { display: none !important; }
.btn-proceed { display: none !important; }

/* ================= STUDIO LAYOUT ================= */
.builder {
    display: grid;
    grid-template-columns: var(--studio-w) 1fr var(--ticket-w);
    flex: 1; min-height: 0;
    gap: var(--sp-4);
    padding: var(--sp-4) var(--sp-4) 0;
}

.panel {
    background: transparent;
    overflow-y: auto; overflow-x: hidden;
    display: flex; flex-direction: column;
    scrollbar-width: thin; scrollbar-color: var(--border-dk) transparent;
}
.panel:first-child { border-right: none; }
.panel:last-child  { border-left: none; background: transparent; }
.panel::-webkit-scrollbar { width: 5px; }
.panel::-webkit-scrollbar-thumb { background: var(--border-dk); border-radius: 6px; }

.panel-header {
    padding: var(--sp-2) 2px var(--sp-4);
    position: sticky; top: 0;
    background: var(--bg);
    z-index: 10;
    border-bottom: none;
}
.panel:last-child .panel-header { background: var(--bg); }
.panel-title {
    font-family: var(--font-display);
    font-size: 1.36rem; font-weight: 800;
    color: var(--brown-deep);
    display: flex; align-items: center; gap: var(--sp-2);
    letter-spacing: -0.02em;
}
.panel-title svg { display: none; }
.panel-title::before {
    content: '';
    width: 10px; height: 10px; border-radius: 3px;
    background: var(--caramel);
    transform: rotate(45deg);
    flex-shrink: 0;
}
.panel-subtitle { font-size: .76rem; color: var(--text-muted); margin-top: 4px; font-family: var(--font-body); }
.panel-body { padding: 0 2px var(--sp-8); display: flex; flex-direction: column; gap: var(--sp-3); }
.panel-body > div:not(.price-total-block) { background: var(--warm-white); border: 1.5px solid var(--border-dk); border-radius: var(--radius); padding: var(--sp-5); box-shadow: var(--shadow-xs); }
.panel-body > div:not(.price-total-block):hover { box-shadow: var(--shadow-sm); }

.section-label {
    font-size: .70rem;
    text-transform: uppercase; letter-spacing: .08em;
    font-weight: 700; color: var(--warm-white);
    margin-bottom: var(--sp-3);
    display: flex; align-items: center; gap: var(--sp-2);
    font-family: var(--font-display);
    padding: 8px 12px;
    background: var(--brown-deep);
    border-radius: 8px;
    position: relative;
    counter-increment: studio-step;
}
.panel-body { counter-reset: studio-step; }
.section-label::before {
    content: counter(studio-step, decimal-leading-zero);
    position: static;
    width: auto; height: auto; transform: none;
    background: none;
    color: var(--caramel-light);
    font-family: var(--font-mono);
    font-weight: 700;
    font-size: .74rem;
    letter-spacing: 0;
}
.section-label::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.25); }
.section-req {
    font-size: .58rem; font-weight: 700;
    color: var(--warm-white);
    background: var(--caramel);
    border: none;
    padding: .20rem .55rem; border-radius: var(--radius-pill);
    margin-left: auto; margin-right: 0;
    letter-spacing: 0.06em; font-family: var(--font-mono); text-transform: uppercase;
}

/* ================= FROSTING GUIDE BANNER ================= */
.frosting-guide { background: linear-gradient(135deg,#F0F7FF 0%,#E8F2FF 100%); border: 1.5px solid rgba(48,100,200,.14); border-radius: var(--radius-sm); padding: 12px 14px; margin-bottom: 10px; }
.frosting-guide-title { font-size: .74rem; font-weight: 700; color: #1A3A80; font-family: var(--font-display); display: flex; align-items: center; gap: 6px; margin-bottom: 10px; }
.frosting-guide-title-icon { font-size: 1rem; }
.frosting-guide-steps { display: flex; flex-direction: column; gap: 7px; }
.frosting-step { display: flex; align-items: flex-start; gap: 8px; }
.frosting-step-num { width: 18px; height: 18px; border-radius: 50%; background: #3064C8; color: #fff; font-size: .6rem; font-weight: 700; font-family: var(--font-body); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
.frosting-step-body { flex: 1; }
.frosting-step-label { font-size: .70rem; font-weight: 700; color: #1A3A80; font-family: var(--font-display); display: block; margin-bottom: 1px; }
.frosting-step-desc { font-size: .65rem; color: #2A50A0; font-family: var(--font-display); line-height: 1.5; }
.frosting-step-desc strong { font-weight: 700; }
.frosting-guide-note { margin-top: 9px; padding: 7px 10px; background: rgba(196,154,60,.10); border: 1px solid rgba(196,154,60,.22); border-radius: 8px; font-size: .65rem; color: #6B4C08; font-family: var(--font-body); line-height: 1.5; display: flex; align-items: flex-start; gap: 6px; }
.frosting-guide-note-icon { font-size: .85rem; flex-shrink: 0; margin-top: 1px; }

.frosting-section-label {
    font-size: .64rem; font-weight: 700; text-transform: uppercase; letter-spacing: .10em;
    color: var(--brown-mid); padding: .3rem 0 .2rem;
    display: flex; align-items: center; gap: 6px;
    font-family: var(--font-display); margin-top: 6px;
}
.frosting-section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

/* ================= SHAPE GRID — swatch tiles ================= */
.shape-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.shape-opt {
    border: 1.5px solid var(--border);
    border-radius: 16px;
    padding: 16px 6px 13px;
    cursor: pointer;
    transition: transform var(--transition-md), box-shadow var(--transition-md), border-color var(--transition), background var(--transition);
    background: linear-gradient(160deg, var(--cream), var(--surface));
    text-align: center;
    box-shadow: var(--shadow-xs);
    position: relative;
    min-height: 44px;
}
.shape-opt svg { transition: transform var(--transition-md); color: var(--brown-mid); }
.shape-opt:hover { border-color: var(--caramel); transform: translateY(-3px); box-shadow: var(--shadow-md); }
.shape-opt:hover svg { transform: scale(1.08) rotate(-2deg); }
.shape-opt:active { transform: translateY(0) scale(0.98); }
.shape-opt.active { border-color: var(--caramel); background: linear-gradient(160deg, var(--accent-lt), var(--warm-white)); box-shadow: var(--shadow-glow); }
.shape-opt.active svg { color: var(--accent-dk); }
.shape-opt.active::after {
    content: '';
    position: absolute; top: 8px; right: 9px;
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--caramel);
}
.shape-opt .sh-name { font-size: .66rem; font-weight: 700; color: var(--text); display: block; font-family: var(--font-display); letter-spacing: 0.01em; margin-top: 5px; }
.shape-opt.active .sh-name { color: var(--accent-dk); }

/* ================= SIZE SLIDER ================= */
.size-slider-wrap {
    display: none; margin-top: 12px;
    background: var(--cream); border: none; border-radius: 14px;
    padding: 15px 16px 14px; box-shadow: none;
}
.size-slider-wrap.visible { display: block; }
.size-slider-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.size-slider-label { font-size: .68rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .08em; font-family: var(--font-mono); }
.size-slider-val { font-family: var(--font-mono); font-size: 1.20rem; font-weight: 700; color: var(--accent-dk); }
input[type=range].size-range { -webkit-appearance: none; appearance: none; width: 100%; height: 5px; background: var(--border-dk); border-radius: 3px; outline: none; cursor: pointer; }
input[type=range].size-range::-webkit-slider-thumb { -webkit-appearance: none; width: 22px; height: 22px; border-radius: 50%; background: var(--caramel); border: 4px solid #fff; box-shadow: 0 3px 10px rgba(160,80,30,.42); cursor: pointer; transition: transform var(--transition); }
input[type=range].size-range::-webkit-slider-thumb:hover { transform: scale(1.12); }
.size-ticks { display: flex; justify-content: space-between; margin-top: 6px; }
.size-tick { font-size: .60rem; color: var(--text-muted); font-family: var(--font-mono); }

/* ================= NUMBER PICKER ================= */
.number-picker-wrap { display: none; margin-top: 12px; background: var(--cream); border: none; border-radius: 14px; padding: 15px 16px 14px; }
.number-picker-wrap.visible { display: block; }
.number-picker-label { font-size: .68rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .08em; font-family: var(--font-mono); margin-bottom: 12px; }
.digit-mode-toggle { display: flex; gap: 0; border: 1.5px solid var(--border-dk); border-radius: var(--radius-pill); overflow: hidden; margin-bottom: 12px; }
.digit-mode-btn { flex: 1; padding: 9px 10px; font-size: .76rem; font-weight: 600; font-family: var(--font-display); color: var(--text-muted); background: var(--surface); border: none; cursor: pointer; transition: all var(--transition); text-align: center; min-height: 40px; }
.digit-mode-btn + .digit-mode-btn { border-left: 1.5px solid var(--border-dk); }
.digit-mode-btn.active { background: var(--caramel); color: #fff; }
.digit-mode-btn:hover:not(.active) { background: var(--accent-lt); color: var(--accent); }
.number-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 7px; }
.num-opt { border: 1.5px solid var(--border); border-radius: 12px; padding: 9px 4px; cursor: pointer; text-align: center; font-family: var(--font-mono); font-size: 1.1rem; font-weight: 700; color: var(--text-muted); background: var(--surface); transition: all var(--transition); min-height: 40px; display: flex; align-items: center; justify-content: center; }
.num-opt:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-lt); }
.num-opt.active { border-color: var(--accent); background: var(--caramel); color: #fff; }
.dual-digit-wrap { display: none; flex-direction: column; gap: 12px; }
.dual-digit-wrap.visible { display: flex; }
.dual-digit-preview { text-align: center; font-family: var(--font-mono); font-size: 2.5rem; font-weight: 700; color: var(--accent-dk); letter-spacing: .04em; line-height: 1; padding: 6px 0 2px; }
.dual-digit-preview span { font-size: .64rem; font-family: var(--font-body); font-weight: 500; color: var(--text-muted); display: block; margin-top: 4px; text-transform: uppercase; letter-spacing: .1em; }
.dual-col-label { font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: var(--text-muted); margin-bottom: 6px; font-family: var(--font-mono); }
.dual-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.num-grid-sm { display: grid; grid-template-columns: repeat(3,1fr); gap: 6px; }
.num-opt-sm { border: 1.5px solid var(--border); border-radius: 8px; padding: 6px 2px; cursor: pointer; text-align: center; font-family: var(--font-mono); font-size: .95rem; font-weight: 700; color: var(--text-muted); background: var(--surface); transition: all var(--transition); min-height: 34px; display: flex; align-items: center; justify-content: center; }
.num-opt-sm:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-lt); }
.num-opt-sm.active { border-color: var(--accent); background: var(--caramel); color: #fff; }

/* ================= OPTION PILLS ================= */
.opts { display: flex; flex-wrap: wrap; gap: var(--sp-2); }
.opt {
    padding: 10px 16px;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-size: .78rem; font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    transition: border-color var(--transition), background var(--transition), color var(--transition), transform var(--transition);
    background: var(--surface);
    position: relative;
    font-family: var(--font-display);
    text-align: center;
    min-height: 40px;
    display: inline-flex; align-items: center;
}
.opt:hover { border-color: var(--caramel); color: var(--accent-dk); background: var(--accent-lt); }
.opt:active { transform: scale(0.97); }
.opt.active { border-color: var(--brown-deep); color: #fff; background: var(--brown-deep); padding-right: 30px; box-shadow: var(--shadow-sm); }
.opt.active span { color: #fff; }
.opt.active::after {
    content: '✓'; position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
    font-size: .62rem; font-weight: 700; color: var(--caramel-light);
}
.flavor-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

/* ================= ADDON GRID (cards) ================= */
.addon-grid { display: grid; grid-template-columns: 1fr 1fr; gap: var(--sp-2); min-width: 0; width: 100%; }
.a-icon { font-size: 1rem; flex-shrink: 0; line-height: 1; color: var(--brown-mid); transition: color var(--transition); }
.addon-opt.active .a-icon { color: var(--accent-dk); }
.a-info { flex: 1; min-width: 0; overflow: hidden; }
.a-name { font-size: .74rem; font-weight: 700; color: var(--text); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: var(--font-display); }
.addon-opt.active .a-name { color: var(--accent-dk); }
.a-price { font-size: .62rem; color: var(--text-muted); display: block; margin-top: 1px; font-family: var(--font-mono); white-space: nowrap; }
.addon-check { width: 17px; height: 17px; border: 1.5px solid var(--border-dk); border-radius: 6px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: all var(--transition-md); background: var(--surface); }
.addon-check svg { width: 9px; height: 9px; opacity: 0; transition: opacity var(--transition); transform: scale(0.6); }
.addon-opt.active .addon-check svg { opacity: 1; transform: scale(1); }
.addon-opt {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 12px 13px;
    cursor: pointer;
    transition: transform var(--transition-md), box-shadow var(--transition-md), border-color var(--transition), background var(--transition);
    background: var(--surface);
    display: flex; align-items: center; gap: 9px;
    min-width: 0; overflow: hidden;
    box-shadow: none;
    min-height: 44px;
}
.addon-opt:hover { border-color: var(--caramel); background: var(--accent-lt); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
.addon-opt:active { transform: translateY(0) scale(0.98); }
.addon-opt.active { border-color: var(--caramel); background: var(--accent-lt); box-shadow: var(--shadow-glow); }
.addon-opt.active .a-name { color: var(--caramel); }
.addon-opt.active .addon-check { background: var(--caramel); border-color: var(--caramel); }

/* ================= DRIP FLAVOR SUB-PANEL ================= */
.drip-flavor-panel { display: none; margin-top: 9px; background: var(--bg); border: 1.5px solid rgba(31,122,108,.22); border-radius: 14px; padding: 11px 12px; }
.drip-flavor-panel.visible { display: block; }
.drip-flavor-header { font-size: .65rem; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 9px; font-family: var(--font-mono); display: flex; align-items: center; gap: 6px; }
.drip-flavor-header::after { content: ''; flex: 1; height: 1px; background: rgba(31,122,108,.18); }
.drip-flavors { display: flex; flex-wrap: wrap; gap: 6px; }
.drip-flavor-opt { padding: 6px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-pill); font-size: .74rem; font-weight: 500; color: var(--text-muted); cursor: pointer; transition: all var(--transition); background: var(--surface); display: flex; align-items: center; gap: 6px; font-family: var(--font-body); min-height: 32px; }
.drip-flavor-opt:hover { border-color: var(--teal); color: var(--teal); background: var(--teal-soft); }
.drip-flavor-opt.active { border-color: var(--teal); background: var(--teal); color: #fff; }
.drip-color-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; border: 1px solid rgba(0,0,0,.12); }

.icing-panel { display: none; margin-top: 8px; background: var(--cream); border: none; border-radius: 14px; padding: 11px 12px; }
.icing-panel.visible { display: block; }
.icing-header { font-size: .65rem; font-weight: 700; color: #7A5C10; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 10px; font-family: var(--font-mono); display: flex; align-items: center; gap: 6px; }
.icing-header::after { content: ''; flex: 1; height: 1px; background: rgba(196,154,60,.22); }
.icing-color-grid { display: grid; grid-template-columns: repeat(6,1fr); gap: 7px; margin-bottom: 9px; }
.icing-color-opt { width: 100%; aspect-ratio: 1; border-radius: 9px; border: 2.5px solid transparent; cursor: pointer; transition: all var(--transition); position: relative; min-height: 32px; }
.icing-color-opt:hover { transform: scale(1.10); }
.icing-color-opt.active { border-color: #2C1810; box-shadow: 0 0 0 2px rgba(44,24,16,.22); transform: scale(1.06); }
.icing-color-opt.active::after { content: '✓'; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: .62rem; font-weight: 700; color: rgba(255,255,255,.95); text-shadow: 0 1px 2px rgba(0,0,0,.6); }
.icing-color-opt.light-color.active::after { color: rgba(0,0,0,.55); text-shadow: none; }
.icing-color-label { font-size: .66rem; color: #7A5C10; font-family: var(--font-body); text-align: center; margin-top: 5px; font-weight: 500; }

.frosting-opt[data-val="Sugar Icing"].active { border-color: var(--gold) !important; background: var(--gold-lt) !important; }
.frosting-opt[data-val="Sugar Icing"].active .a-name { color: #7A5C10 !important; }
.frosting-opt[data-val="Sugar Icing"].active .addon-check { background: var(--gold) !important; border-color: var(--gold) !important; }

.frosting-combo-hint { display: none; margin-top: 9px; padding: 9px 12px; background: var(--teal-soft); border: 1px solid rgba(31,122,108,.20); border-radius: 14px; font-size: .71rem; color: var(--teal); font-family: var(--font-body); line-height: 1.5; }
.frosting-combo-hint.visible { display: flex; align-items: flex-start; gap: 7px; }
.frosting-combo-hint-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.frosting-combo-label { font-weight: 600; display: block; }
.frosting-combo-sub { color: rgba(31,122,108,.75); font-size: .67rem; }

.frosting-opt.frosting-locked { opacity: .38; pointer-events: none; filter: grayscale(.6); position: relative; }
.frosting-opt.frosting-locked::after { content: '🚫'; position: absolute; top: 5px; right: 6px; font-size: .6rem; opacity: .75; pointer-events: none; }
.frosting-opt.active[data-val="Fondant Smooth"] { border-color: var(--gold) !important; background: var(--gold-lt) !important; box-shadow: 0 0 0 3px rgba(196,154,60,.14); }
.frosting-opt.active[data-val="Fondant Smooth"] .a-name { color: #7A5C10 !important; }
.frosting-opt.active[data-val="Fondant Smooth"] .addon-check { background: var(--gold) !important; border-color: var(--gold) !important; }
.fondant-notice { display: none; margin-top: 9px; padding: 10px 12px; background: linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%); border: 1.5px solid rgba(196,154,60,.32); border-radius: 14px; font-size: .71rem; color: #7A5C10; font-family: var(--font-body); line-height: 1.55; gap: 8px; align-items: flex-start; }
.fondant-notice.visible { display: flex; }
.fondant-notice-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
.fondant-notice-title { font-weight: 700; display: block; margin-bottom: 1px; color: #6B4C08; }
.fondant-notice-sub { color: rgba(122,92,16,.72); font-size: .66rem; }

.price-row.frosting-extra-row { background: rgba(31,122,108,.04); }
.price-row.frosting-extra-row .pr-label { color: var(--teal); }
.price-row.frosting-extra-row .pr-val { color: var(--teal); }

.viewer {
    position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;
    margin: var(--sp-4) 0;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
   background:
        /* warm pendant light glow, softly diffused — dimmed */
        radial-gradient(ellipse 42% 32% at 50% 4%, rgba(255,236,195,0.30) 0%, rgba(255,224,175,0.12) 42%, transparent 72%),
        radial-gradient(ellipse 24% 20% at 78% 9%, rgba(255,228,180,0.16) 0%, transparent 68%),
        radial-gradient(ellipse 24% 20% at 21% 11%, rgba(255,228,180,0.13) 0%, transparent 68%),
        /* faint blurred greenery in the corners */
        radial-gradient(ellipse 24% 30% at 3% 20%, rgba(126,156,96,0.28) 0%, rgba(146,170,116,0.12) 45%, transparent 72%),
        radial-gradient(ellipse 22% 28% at 97% 24%, rgba(116,150,90,0.24) 0%, transparent 70%),
        /* hazy wooden shelf bands, out of focus */
        linear-gradient(180deg, transparent 0%, transparent 29%, rgba(122,84,48,0.20) 33%, rgba(142,98,58,0.28) 37%, rgba(122,84,48,0.18) 41%, transparent 46%),
        linear-gradient(180deg, transparent 0%, transparent 55%, rgba(112,76,42,0.16) 58%, rgba(132,92,52,0.22) 61%, rgba(112,76,42,0.14) 64%, transparent 69%),
        /* soft indistinct baking props in the far distance */
        radial-gradient(circle at 11% 61%, rgba(205,166,116,0.22) 0%, transparent 13%),
        radial-gradient(circle at 89% 57%, rgba(196,156,106,0.20) 0%, transparent 15%),
        radial-gradient(circle at 16% 39%, rgba(214,180,136,0.16) 0%, transparent 11%),
        radial-gradient(circle at 83% 40%, rgba(206,170,124,0.16) 0%, transparent 11%),
        /* cream bakery wall, falling gently into a warm floor tone */
        linear-gradient(180deg, #F7F0E4 0%, #F2E8D7 22%, #EBDBC1 46%, #DCC49E 68%, #C7A67A 85%, #A88354 100%);
}
#model-container { position: absolute; inset: 0; }
#model-container canvas { width: 100% !important; height: 100% !important; display: block; }
.viewer::before {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 38%;
    background: linear-gradient(to top, rgba(120,80,30,0.50) 0%, rgba(140,95,40,0.22) 40%, transparent 100%);
    pointer-events: none; z-index: 2;
}
.viewer::after {
    content: ''; position: absolute; inset: 0;
    background:
        linear-gradient(135deg, transparent 38%, rgba(255,220,130,0.09) 50%, transparent 62%),
        radial-gradient(ellipse 30% 90% at 88% 20%, rgba(255,230,150,0.12) 0%, transparent 55%),
        radial-gradient(ellipse 120% 90% at 50% 100%, rgba(59,31,14,0.16) 0%, transparent 70%);
    pointer-events: none; z-index: 2;
    box-shadow: inset 0 0 60px rgba(59,31,14,0.12);
}

/* Trays (fruit / choco / candle) */
.fruit-tray, .choco-tray { position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%); display: none; align-items: center; gap: 6px; z-index: 30; background: rgba(58,32,10,0.80); backdrop-filter: blur(16px); border: 1px solid rgba(210,165,90,0.30); border-radius: var(--radius-lg); padding: 8px 14px; box-shadow: 0 6px 22px rgba(30,15,4,0.42); pointer-events: all; }
.fruit-tray.visible, .choco-tray.visible { display: flex; }
.choco-tray { background: rgba(30,10,4,0.90); border-color: rgba(180,100,40,0.40); z-index: 31; }
.fruit-tray-label, .choco-tray-label { font-size: .60rem; font-weight: 700; color: rgba(220,175,100,0.82); text-transform: uppercase; letter-spacing: .1em; font-family: var(--font-mono); white-space: nowrap; margin-right: 2px; }
.fruit-draggable, .ferrero-draggable, .kitkat-draggable, .oreo-draggable, .bar-shard-draggable, .toblerone-draggable, .candle-draggable {
    width: 40px; height: 40px; border-radius: 10px; border: 1.5px solid rgba(200,150,70,0.30);
    background: rgba(80,48,16,0.55); cursor: grab; display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; transition: all var(--transition); user-select: none; -webkit-user-select: none; position: relative; flex-shrink: 0;
}
.fruit-draggable:hover, .ferrero-draggable:hover, .kitkat-draggable:hover, .oreo-draggable:hover, .bar-shard-draggable:hover, .toblerone-draggable:hover, .candle-draggable:hover { border-color: rgba(220,175,100,0.65); background: rgba(100,62,20,0.78); transform: scale(1.08); }
.fruit-draggable:active, .ferrero-draggable:active, .kitkat-draggable:active, .oreo-draggable:active, .bar-shard-draggable:active, .toblerone-draggable:active, .candle-draggable:active { cursor: grabbing; }
.fruit-tip, .ferrero-tip, .kitkat-tip, .oreo-tip, .bar-shard-tip, .toblerone-tip { position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%); background: #3C2010; color: #F0D090; font-size: .58rem; white-space: nowrap; padding: 3px 8px; border-radius: 6px; pointer-events: none; opacity: 0; transition: opacity .15s; font-family: var(--font-body); }
.fruit-draggable:hover .fruit-tip, .ferrero-draggable:hover .ferrero-tip, .kitkat-draggable:hover .kitkat-tip, .oreo-draggable:hover .oreo-tip, .bar-shard-draggable:hover .bar-shard-tip, .toblerone-draggable:hover .toblerone-tip, .candle-draggable:hover .fruit-tip { opacity: 1; }
.fruit-tray-sep, .choco-tray-sep, .ferrero-tray-sep, .kitkat-tray-sep, .oreo-tray-sep, .bar-shard-tray-sep { width: 1px; height: 24px; background: rgba(200,150,70,0.22); margin: 0 2px; }
.fruit-clear-btn, .choco-clear-btn, .ferrero-clear-btn, .kitkat-clear-btn, .oreo-clear-btn, .bar-shard-clear-btn { padding: 6px 11px; border: 1.5px solid rgba(200,90,60,.40); border-radius: var(--radius-pill); background: transparent; color: rgba(230,130,105,0.88); font-size: .68rem; font-weight: 600; cursor: pointer; font-family: var(--font-body); transition: all var(--transition); white-space: nowrap; }
.fruit-clear-btn:hover, .choco-clear-btn:hover, .ferrero-clear-btn:hover, .kitkat-clear-btn:hover, .oreo-clear-btn:hover, .bar-shard-clear-btn:hover { border-color: rgba(230,80,55,0.70); color: #FF7550; }

.ferrero-tray, .kitkat-tray, .oreo-tray, .bar-shard-tray { position: absolute; bottom: 58px; left: 50%; transform: translateX(-50%); display: none; align-items: center; gap: 6px; z-index: 31; backdrop-filter: blur(16px); border-radius: var(--radius-lg); padding: 8px 14px; pointer-events: all; }
.ferrero-tray.visible, .kitkat-tray.visible, .oreo-tray.visible, .bar-shard-tray.visible { display: flex; }
.ferrero-tray { background: rgba(38,18,6,0.90); border: 1px solid rgba(196,154,60,0.38); box-shadow: 0 6px 22px rgba(20,8,2,0.5); }
.kitkat-tray { background: rgba(80,10,10,0.90); border: 1px solid rgba(200,50,50,0.38); box-shadow: 0 6px 22px rgba(40,6,6,0.5); }
.oreo-tray { background: rgba(20,18,24,0.94); border: 1px solid rgba(230,220,210,0.26); box-shadow: 0 6px 22px rgba(8,6,10,0.55); }
.bar-shard-tray { background: rgba(30,12,4,0.94); border: 1px solid rgba(120,60,20,0.46); box-shadow: 0 6px 22px rgba(16,6,2,0.55); }
.ferrero-tray-label, .kitkat-tray-label, .oreo-tray-label, .bar-shard-tray-label { font-size: .60rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; font-family: var(--font-mono); white-space: nowrap; margin-right: 2px; }
.ferrero-tray-label { color: rgba(196,154,60,0.90); } .kitkat-tray-label { color: rgba(255,130,110,0.90); } .oreo-tray-label { color: rgba(230,220,200,0.82); } .bar-shard-tray-label { color: rgba(210,150,90,0.90); }

.rot-panel { display: none; margin-top: 10px; background: var(--warm-white); border: 1.5px solid rgba(200,137,74,.32); border-radius: 14px; padding: 12px 13px; }
.rot-panel.visible { display: block; }
.rot-panel-title { font-size: .68rem; font-weight: 700; color: #7A4A1E; margin-bottom: 9px; display: flex; align-items: center; gap: 5px; font-family: var(--font-mono); }
.rot-panel-title svg { flex-shrink: 0; }
.rot-preview-row { display: flex; align-items: center; gap: 10px; margin-bottom: 9px; }
.rot-emoji-preview { font-size: 2rem; line-height: 1; transition: transform .18s; display: block; }
.rot-slider-col { flex: 1; }
.rot-slider-ends { display: flex; justify-content: space-between; font-size: .62rem; color: var(--text-muted); font-family: var(--font-mono); margin-bottom: 4px; }
.rot-deg-display { text-align: center; font-size: .82rem; font-weight: 700; color: var(--caramel); font-family: var(--font-mono); margin-top: 4px; }
input[type=range].rot-range { -webkit-appearance: none; appearance: none; width: 100%; height: 6px; border-radius: 3px; background: var(--border); outline: none; cursor: pointer; }
input[type=range].rot-range::-webkit-slider-thumb { -webkit-appearance: none; width: 24px; height: 24px; border-radius: 50%; background: var(--caramel); border: 3px solid #fff; box-shadow: 0 3px 8px rgba(60,20,5,.30); cursor: pointer; }
.rot-preset-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 6px; margin-bottom: 9px; }
.rot-preset-btn { padding: 8px 4px; border: 1.5px solid rgba(200,137,74,.32); border-radius: 10px; background: rgba(200,137,74,.09); color: #7A4A1E; font-size: .70rem; font-weight: 700; cursor: pointer; text-align: center; font-family: var(--font-display); transition: all .15s; min-height: 36px; }
.rot-preset-btn:hover { background: rgba(200,137,74,.22); }
.rot-actions { display: flex; gap: 7px; }
.rot-apply-btn { flex: 1; padding: 10px; background: var(--caramel); border: none; border-radius: 12px; color: #fff; font-size: .76rem; font-weight: 700; cursor: pointer; font-family: var(--font-display); transition: all .18s; min-height: 40px; }
.rot-apply-btn:hover { background: var(--caramel-light); }
.rot-reset-btn { padding: 10px 12px; background: transparent; border: 1.5px solid rgba(200,137,74,.36); border-radius: 12px; color: var(--text-muted); font-size: .72rem; font-weight: 600; cursor: pointer; font-family: var(--font-display); min-height: 40px; }
.rot-reset-btn:hover { border-color: var(--caramel); color: var(--caramel); }
.rot-panel.rot-gold { border-color: rgba(196,154,60,.38); }
.rot-panel.rot-gold .rot-panel-title { color: #6B4C08; }
.rot-panel.rot-gold input[type=range].rot-range::-webkit-slider-thumb { background: var(--gold); }
.rot-panel.rot-gold .rot-deg-display { color: var(--gold); }
.rot-panel.rot-gold .rot-preset-btn { border-color: rgba(196,154,60,.32); background: rgba(196,154,60,.11); color: #6B4C08; }
.rot-panel.rot-gold .rot-preset-btn:hover { background: rgba(196,154,60,.25); }
.rot-panel.rot-gold .rot-apply-btn { background: var(--gold); }
.rot-panel.rot-gold .rot-apply-btn:hover { background: #D4AA4C; }
.rot-panel.rot-gold .rot-reset-btn { border-color: rgba(196,154,60,.38); }
.rot-panel.rot-gold .rot-reset-btn:hover { border-color: var(--gold); color: var(--gold); }

.orient-panel { display: none; margin-top: 9px; background: linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%); border: 1.5px solid rgba(196,154,60,.28); border-radius: 14px; padding: 11px 12px; }
.orient-panel.visible { display: block; }
.orient-panel-header { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 9px; font-family: var(--font-mono); display: flex; align-items: center; gap: 6px; color: #7A5C10; }
.orient-panel-header::after { content: ''; flex: 1; height: 1px; background: rgba(196,154,60,.22); }
.orient-toggle { display: flex; gap: 0; border: 1.5px solid rgba(196,154,60,.36); border-radius: 12px; overflow: hidden; }
.orient-btn { flex: 1; padding: 9px 6px; font-size: .74rem; font-weight: 600; font-family: var(--font-display); color: #7A5C10; background: rgba(255,248,230,.6); border: none; cursor: pointer; transition: all var(--transition); text-align: center; display: flex; align-items: center; justify-content: center; gap: 5px; min-height: 40px; }
.orient-btn + .orient-btn { border-left: 1.5px solid rgba(196,154,60,.28); }
.orient-btn.active { background: var(--gold); color: #fff; }
.orient-btn:hover:not(.active) { background: rgba(196,154,60,.16); color: #6B4C08; }
.orient-btn-icon { font-size: .9rem; }
.orient-hint { margin-top: 8px; font-size: .63rem; color: rgba(122,92,16,.72); font-family: var(--font-body); line-height: 1.5; }

#fruitCanvas { position: absolute; inset: 0; z-index: 25; pointer-events: none; }
.drop-ring { position: absolute; border: 2px dashed rgba(180,120,40,0.65); border-radius: 50%; pointer-events: none; z-index: 26; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
@keyframes ringPulse { 0%,100%{opacity:1;transform:translate(-50%,-50%) scale(1);} 50%{opacity:.4;transform:translate(-50%,-50%) scale(1.18);} }
.ferrero-drop-ring { position: absolute; border: 2px dashed rgba(196,154,60,0.80); border-radius: 50%; pointer-events: none; z-index: 27; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
.kitkat-drop-ring { position: absolute; border: 2px dashed rgba(220,60,40,0.80); border-radius: 8px; pointer-events: none; z-index: 28; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
.oreo-drop-ring { position: absolute; border: 2px dashed rgba(200,190,175,0.80); border-radius: 50%; pointer-events: none; z-index: 29; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
.bar-shard-drop-ring { position: absolute; border: 2px dashed rgba(180,100,30,0.80); border-radius: 6px; pointer-events: none; z-index: 35; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
.toblerone-drop-ring { position: absolute; border: 2px dashed rgba(196,154,60,0.80); border-radius: 8px; pointer-events: none; z-index: 36; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
.candle-drop-ring { position: absolute; border: 2px dashed rgba(196,154,60,0.80); border-radius: 50%; pointer-events: none; z-index: 36; display: none; transform: translate(-50%,-50%); animation: ringPulse .7s ease-in-out infinite; }
#dragGhost { display: none; }
.viewer.fruit-drag-over { outline: 3px dashed rgba(180,120,40,0.45); outline-offset: -4px; }
.viewer.ferrero-drag-over { outline: 3px dashed rgba(196,154,60,0.60); outline-offset: -4px; }
.viewer.kitkat-drag-over { outline: 3px dashed rgba(220,60,40,0.55); outline-offset: -4px; }
.viewer.oreo-drag-over { outline: 3px dashed rgba(200,190,175,0.55); outline-offset: -4px; }
.viewer.bar-shard-drag-over { outline: 3px dashed rgba(160,90,30,0.60); outline-offset: -4px; }
.viewer.toblerone-drag-over { outline: 3px dashed rgba(196,154,60,0.60); outline-offset: -4px; }
.viewer.candle-drag-over { outline: 3px dashed rgba(196,154,60,0.60); outline-offset: -4px; }

.model-loading { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; pointer-events: none; z-index: 5; transition: opacity .4s var(--ease-out); }
.model-loading.hidden { opacity: 0; }
.loading-spinner { width: 40px; height: 40px; border: 3px solid rgba(160,100,30,0.14); border-top-color: rgba(180,120,40,0.92); border-radius: 50%; animation: spin .85s linear infinite; box-shadow: 0 4px 14px rgba(160,100,30,0.14); }
@keyframes spin { to { transform: rotate(360deg); } }
.loading-text { font-size: .76rem; color: rgba(120,70,20,0.75); font-family: var(--font-body); font-weight: 600; letter-spacing: 0.01em; }

.viewer-badge {
    position: absolute; bottom: 16px; left: 16px; top: auto;
    background: rgba(40,20,8,0.55);
    backdrop-filter: blur(18px) saturate(1.5); -webkit-backdrop-filter: blur(18px) saturate(1.5);
    border: 1px solid rgba(232,176,122,0.26);
    border-radius: var(--radius-pill);
    padding: 10px 18px;
    box-shadow: 0 6px 20px rgba(30,15,5,0.35);
    z-index: 10;
    transition: transform var(--transition-md);
    display: flex; align-items: center; gap: 10px;
}
.viewer-badge:hover { transform: translateY(-1px); }
.badge-flavor { font-size: .72rem; font-weight: 700; color: var(--caramel-light); text-transform: uppercase; letter-spacing: .06em; font-family: var(--font-display); }
.badge-shape  { font-size: .66rem; color: rgba(232,176,122,0.68); font-family: var(--font-mono); position: relative; padding-left: 10px; }
.badge-shape::before { content: '·'; position: absolute; left: 2px; color: rgba(232,176,122,0.5); }

.viewer-hint {
    position: absolute; top: 18px; left: 50%; transform: translateX(-50%); bottom: auto;
    background: rgba(40,20,8,0.42);
    backdrop-filter: blur(14px) saturate(1.3); -webkit-backdrop-filter: blur(14px) saturate(1.3);
    border: 1px solid rgba(232,176,122,0.18);
    border-radius: var(--radius-pill);
    padding: 6px 16px;
    font-size: .68rem; color: rgba(232,176,122,0.75);
    white-space: nowrap;
    z-index: 10;
    font-family: var(--font-display);
    transition: top .2s ease, opacity .3s;
}
.viewer-controls { position: absolute; top: 16px; right: 16px; display: flex; flex-direction: column; gap: 7px; z-index: 10; }
.view-btn {
    width: 36px; height: 36px;
    background: rgba(40,20,8,0.55);
    backdrop-filter: blur(18px) saturate(1.5); -webkit-backdrop-filter: blur(18px) saturate(1.5);
    border: 1px solid rgba(232,176,122,0.26);
    border-radius: var(--radius-pill);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: rgba(232,176,122,0.75);
    transition: all var(--transition-md);
    box-shadow: 0 3px 10px rgba(30,15,5,0.32);
}
.view-btn:hover { background: rgba(90,48,22,0.85); color: var(--caramel-light); border-color: rgba(232,176,122,0.50); transform: translateY(-1px) rotate(-8deg); }
.view-btn:active { transform: translateY(0) rotate(0deg); }
.model-status {
    position: absolute; bottom: 66px; left: 50%; transform: translateX(-50%);
    background: rgba(40,20,8,0.50); backdrop-filter: blur(10px);
    border: 1px solid rgba(232,176,122,0.18);
    border-radius: var(--radius-pill); padding: 4px 14px;
    font-size: .64rem; color: rgba(232,176,122,0.72); white-space: nowrap; z-index: 10;
    font-family: var(--font-mono); transition: opacity .3s; pointer-events: none;
}
.model-status.hidden { opacity: 0; }

/* ================= RIGHT PANEL: "ORDER TICKET" ================= */
.config-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: none; transition: box-shadow var(--transition-md); }
.config-card:hover { box-shadow: var(--shadow-sm); }
.config-card-header { padding: 12px 18px; border-bottom: 1px dashed var(--border-dk); font-size: .64rem; text-transform: uppercase; letter-spacing: .10em; font-weight: 700; color: var(--brown-mid); font-family: var(--font-mono); display: flex; align-items: center; gap: 7px; background: transparent; }
.price-block { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: none; }
.price-block-header { padding: 12px 18px; border-bottom: 1px dashed var(--border-dk); font-size: .64rem; text-transform: uppercase; letter-spacing: .10em; font-weight: 700; color: var(--brown-mid); font-family: var(--font-mono); background: transparent; }

.price-total-block {
    background: linear-gradient(135deg, var(--brown-deep) 0%, var(--brown-mid) 100%);
    border-radius: var(--radius-lg);
    padding: 24px 26px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 16px 34px rgba(59,31,14,0.32), 0 2px 8px rgba(59,31,14,0.18);
    position: relative; overflow: hidden;
}
.price-total-block::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 70% 100% at 100% 0%, rgba(232,176,122,0.22) 0%, transparent 60%); pointer-events: none; }
.price-total-block::after {
    content: '';
    position: absolute; left: -10px; top: 50%; width: 20px; height: 20px;
    background: var(--bg); border-radius: 50%; transform: translateY(-50%);
}
.pt-label { font-size: .64rem; text-transform: uppercase; letter-spacing: .16em; font-weight: 700; color: rgba(255,255,255,0.55); font-family: var(--font-mono); margin-bottom: 5px; }
.pt-currency { font-size: 1.15rem; font-family: var(--font-mono); font-weight: 700; color: var(--caramel-light); }
.pt-number { font-family: var(--font-mono); font-size: 2.35rem; font-weight: 700; color: #fff; font-variant-numeric: tabular-nums; line-height: 1; letter-spacing: -0.01em; }
.pt-note { font-size: .63rem; color: rgba(255,255,255,0.48); font-family: var(--font-display); margin-top: 6px; }

.cfg-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 11px 18px; font-size: .80rem; font-family: var(--font-display); gap: 8px; transition: background var(--transition); }
.cfg-row:hover { background: rgba(200,137,74,0.04); }
.cfg-row + .cfg-row { border-top: 1px dashed var(--border); }
.cfg-key { color: var(--text-muted); font-weight: 600; font-size: .66rem; flex-shrink: 0; padding-top: 1px; font-family: var(--font-mono); text-transform: uppercase; letter-spacing: .04em; }
.cfg-val { font-weight: 700; color: var(--text); text-align: right; line-height: 1.45; font-size: .78rem; font-family: var(--font-display); }
.cfg-val.muted { color: var(--border-dk); font-weight: 400; font-style: italic; }
.cfg-chips { display: flex; flex-wrap: wrap; gap: 5px; justify-content: flex-end; }
.cfg-chip { padding: 3px 9px; border-radius: var(--radius-pill); font-size: .64rem; font-weight: 700; font-family: var(--font-display); }
.cfg-chip.chip-accent { background: var(--accent-lt); color: var(--caramel); }
.cfg-chip.chip-gold   { background: var(--gold-lt); color: #7A5C10; }
.cfg-chip.chip-teal   { background: var(--teal-soft); color: var(--teal); }

.price-rows { padding: 2px 0; }
.price-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 18px; font-size: .8rem; font-family: var(--font-display); }
.price-row + .price-row { border-top: 1px dashed var(--border); }
.pr-label { color: var(--text-muted); font-family: var(--font-display); }
.pr-val { font-weight: 700; color: var(--text); font-family: var(--font-mono); font-variant-numeric: tabular-nums; }
.pr-val.zero { color: var(--border-dk); }

.btn-proceed-lg {
    width: 100%; padding: 17px;
    background: var(--brown-deep);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-family: var(--font-display); font-size: .92rem; font-weight: 700;
    cursor: pointer;
    transition: transform var(--transition-md), box-shadow var(--transition-md), background var(--transition);
    box-shadow: 0 10px 24px rgba(59,31,14,0.30);
    display: flex; align-items: center; justify-content: center; gap: 9px;
    letter-spacing: 0.02em; position: relative; overflow: hidden; min-height: 54px;
}
.btn-proceed-lg::after { content: ''; position: absolute; inset: 0; background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.14) 50%, transparent 70%); transform: translateX(-100%); transition: transform 0.6s var(--ease-out); }
.btn-proceed-lg:hover { background: var(--brown-mid); transform: translateY(-2px); box-shadow: 0 14px 30px rgba(59,31,14,0.36); }
.btn-proceed-lg:hover::after { transform: translateX(100%); }
.btn-proceed-lg:active { transform: translateY(0); }

.btn-load-draft {
    width: 100%; padding: 12px;
    background: transparent; color: var(--text-muted);
    border: 1.5px dashed var(--border-dk); border-radius: var(--radius-sm);
    font-family: var(--font-display); font-size: .82rem; font-weight: 600;
    cursor: pointer; transition: all var(--transition);
    display: flex; align-items: center; justify-content: center; gap: 7px;
    min-height: 46px;
}
.btn-load-draft:hover { border-color: var(--caramel); color: var(--caramel); background: var(--accent-lt); }

/* ================= TOAST ================= */
.toast {
    position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(20px);
    background: var(--brown-deep);
    color: #fff; padding: 12px 24px; border-radius: var(--radius-pill);
    font-size: .8rem; font-weight: 600;
    opacity: 0; pointer-events: none;
    transition: all .32s var(--ease-out);
    z-index: 9999;
    box-shadow: 0 10px 28px rgba(59,31,14,0.40), 0 2px 8px rgba(59,31,14,0.22);
    white-space: nowrap; font-family: var(--font-display);
    border: 1px solid rgba(255,255,255,0.10);
}
.toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

.addon-section-lbl {
    font-size: .64rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; color: var(--brown-mid);
    padding: .4rem 0 .25rem; display: flex; align-items: center; gap: 6px; font-family: var(--font-display);
}
.addon-section-lbl::after { content: ''; flex: 1; height: 1px; background: var(--border); }

.fruits-drag-notice { margin-top: 9px; padding: 10px 12px; background: var(--accent-lt); border: 1.5px dashed var(--caramel); border-radius: 12px; font-size: .74rem; color: var(--accent-dk); font-weight: 600; font-family: var(--font-body); line-height: 1.55; align-items: center; gap: 8px; }
.fruits-drag-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.fruits-drag-label { font-weight: 700; display: block; margin-bottom: 1px; }
.fruits-drag-sub { color: rgba(31,122,108,.72); font-size: .65rem; }
.ferrero-drag-notice { margin-top: 9px; padding: 9px 12px; background: linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%); border: 1px solid rgba(196,154,60,.26); border-radius: 12px; font-size: .70rem; color: #7A5C10; font-family: var(--font-body); line-height: 1.55; align-items: flex-start; gap: 7px; }
.ferrero-drag-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.ferrero-drag-label { font-weight: 700; display: block; margin-bottom: 1px; color: #6B4C08; }
.ferrero-drag-sub { color: rgba(122,92,16,.72); font-size: .65rem; }
.kitkat-drag-notice { margin-top: 9px; padding: 9px 12px; background: linear-gradient(135deg,#FFF0EE 0%,#FFE0DC 100%); border: 1px solid rgba(200,60,40,.20); border-radius: 12px; font-size: .70rem; color: #8C2010; font-family: var(--font-body); line-height: 1.55; align-items: flex-start; gap: 7px; }
.kitkat-drag-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.kitkat-drag-label { font-weight: 700; display: block; margin-bottom: 1px; color: #7A1A08; }
.kitkat-drag-sub { color: rgba(140,32,16,.70); font-size: .65rem; }
.oreo-drag-notice { margin-top: 9px; padding: 9px 12px; background: linear-gradient(135deg,#F4F2F8 0%,#E8E4F0 100%); border: 1px solid rgba(80,70,100,.16); border-radius: 12px; font-size: .70rem; color: #3A3048; font-family: var(--font-body); line-height: 1.55; align-items: flex-start; gap: 7px; }
.oreo-drag-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.oreo-drag-label { font-weight: 700; display: block; margin-bottom: 1px; color: #2C2438; }
.oreo-drag-sub { color: rgba(58,48,72,.68); font-size: .65rem; }
.bar-shard-drag-notice { margin-top: 9px; padding: 9px 12px; background: linear-gradient(135deg,#FBF0E6 0%,#F5E0C8 100%); border: 1px solid rgba(140,70,20,.20); border-radius: 12px; font-size: .70rem; color: #5C2808; font-family: var(--font-body); line-height: 1.55; align-items: flex-start; gap: 7px; }
.bar-shard-drag-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.bar-shard-drag-label { font-weight: 700; display: block; margin-bottom: 1px; color: #4A1E04; }
.bar-shard-drag-sub { color: rgba(92,40,8,.68); font-size: .65rem; }
.candle-drag-notice { margin-top: 9px; padding: 9px 12px; background: linear-gradient(135deg,#FFF8E8 0%,#FFF0CC 100%); border: 1px solid rgba(196,154,60,.26); border-radius: 12px; font-size: .70rem; color: #7A5C10; font-family: var(--font-body); line-height: 1.55; align-items: flex-start; gap: 7px; }
.candle-drag-icon { font-size: .9rem; flex-shrink: 0; margin-top: 1px; }
.candle-drag-label { font-weight: 700; display: block; margin-bottom: 1px; color: #6B4C08; }
.candle-drag-sub { color: rgba(122,92,16,.72); font-size: .65rem; }

.candle-picker-panel { display: none; margin-top: 9px; background: linear-gradient(135deg,#FFF8E8 0%,#FFF0CC 100%); border: 1.5px solid rgba(196,154,60,.32); border-radius: 14px; padding: 11px 12px; }
.candle-picker-panel.visible { display: block; }
.candle-picker-header { font-size: .65rem; font-weight: 700; color: #7A5C10; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 9px; font-family: var(--font-mono); display: flex; align-items: center; gap: 6px; }
.candle-picker-header::after { content: ''; flex: 1; height: 1px; background: rgba(196,154,60,.22); }
.candle-num-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 6px; margin-bottom: 9px; }
.candle-num-opt { border: 1.5px solid var(--border); border-radius: 10px; padding: 7px 4px; cursor: pointer; text-align: center; font-family: var(--font-mono); font-size: 1rem; font-weight: 700; color: var(--text-muted); background: var(--surface); transition: all var(--transition); min-height: 36px; display: flex; align-items: center; justify-content: center; }
.candle-num-opt:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-lt); }
.candle-num-opt.active { border-color: var(--gold); background: var(--gold); color: #fff; }
.candle-active-badge { font-size: .68rem; color: #7A5C10; font-family: var(--font-body); text-align: center; font-weight: 500; }

.char-cat-group { border: 1.5px solid rgba(200,137,74,.22); border-radius: 10px; overflow: hidden; background: rgba(255,255,255,.55); margin-bottom: 6px; }
.char-cat-toggle { width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 9px 11px; background: transparent; border: none; cursor: pointer; font-family: var(--font-display); font-size: .74rem; font-weight: 700; color: var(--brown-mid); text-align: left; min-height: 38px; }
.char-cat-toggle:hover { background: rgba(200,137,74,.08); }
.char-cat-toggle-name { flex: 1; }
.char-cat-toggle-count { font-size: .60rem; font-weight: 600; color: var(--caramel); margin-right: 6px; font-family: var(--font-mono); }
.char-cat-arrow { font-size: .68rem; color: var(--caramel); transition: transform .18s; flex-shrink: 0; }
.char-cat-group.open .char-cat-arrow { transform: rotate(90deg); }
.char-cat-options { display: none; grid-template-columns: repeat(3,1fr); gap: 6px; padding: 0 10px 10px; }
.char-cat-group.open .char-cat-options { display: grid; }
.char-cat-options .candle-num-opt { font-size: .58rem; padding: 7px 3px; flex-direction:column; display:flex; align-items:center; justify-content:center; gap:2px; line-height:1.25; }
.char-price { font-size: .52rem; font-weight: 700; opacity: .70; }
/* ================= TUTORIAL OVERLAY ================= */
.tut-overlay{
    position:fixed;inset:0;z-index:5000;
    background:rgba(44,24,16,0.55);
    backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);
    display:flex;align-items:center;justify-content:center;
    opacity:0;pointer-events:none;
    transition:opacity .28s var(--ease-out);
    padding:20px;
}
.tut-overlay.visible{opacity:1;pointer-events:all;}
.tut-modal{
    width:100%;max-width:900px;
    background:var(--warm-white);
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow-lg);
    padding:40px 48px 32px;
    position:relative;
    transform:translateY(14px) scale(.97);
    transition:transform .32s var(--ease-out);
}
.tut-overlay.visible .tut-modal{transform:translateY(0) scale(1);}
.tut-skip{
    position:absolute;top:20px;right:22px;
    background:rgba(20,10,4,0.45);
    backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,0.14);cursor:pointer;
    font-family:var(--font-display);font-size:.76rem;font-weight:600;
    letter-spacing:.02em;
    color:rgba(255,255,255,0.92);padding:7px 12px;border-radius:8px;
    transition:all var(--transition);
    z-index:3;
}
.tut-skip:hover{background:rgba(20,10,4,0.65);color:#fff;}
.tut-skip:hover{color:var(--caramel);background:var(--accent-lt);}
.tut-slides{position:relative;min-height:520px;}
.tut-step-layout{display:flex;flex-direction:column;}
.tut-step-layout .tut-shot-frame{
    margin:-40px -48px 26px;
    width:calc(100% + 96px);
    border-radius:0;
    border-left:none;border-right:none;border-top:none;
}
.tut-step-layout .tut-shot-frame .tut-icon-img{width:100%;height:440px;aspect-ratio:auto;object-fit:cover;display:block;}
.tut-step-layout .tut-step-text{display:flex;flex-direction:column;}
.tut-slide{display:none;text-align:left;animation:tutFadeIn .3s var(--ease-out);}
.tut-slide.active{display:block;}
@keyframes tutFadeIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}
.tut-icon{font-size:2.6rem;line-height:1;margin-bottom:14px;}
.tut-shot-frame{
    border-radius:16px;overflow:hidden;
    border:1px solid var(--border);
    box-shadow:0 12px 30px rgba(59,31,14,0.22);
    margin:0 0 24px;background:#1a0f06;
}
.tut-shot-bar{
    display:flex;align-items:center;gap:6px;
    padding:9px 14px;
    background:linear-gradient(180deg,#3a2413,#2a1a0d);
}
.tut-shot-bar span{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.20);flex-shrink:0;}
.tut-shot-bar span:nth-child(1){background:#ff5f57;}
.tut-shot-bar span:nth-child(2){background:#febc2e;}
.tut-shot-bar span:nth-child(3){background:#28c840;}
.tut-icon-img{
    width:100%;display:block;
    aspect-ratio:16/9;
    object-fit:cover;object-position:center top;
    image-rendering:auto;
}
.tut-eyebrow{
    font-family:var(--font-mono);font-size:.68rem;font-weight:700;
    letter-spacing:.14em;text-transform:uppercase;color:var(--caramel);
    margin:0 0 8px;
}
.tut-welcome-top{display:flex;align-items:center;gap:16px;margin-bottom:20px;}
.tut-welcome-top .tut-eyebrow{margin:0 0 4px;}
.tut-welcome-top .tut-title{margin:0;}
.tut-welcome-mark{
    width:48px;height:48px;border-radius:12px;flex-shrink:0;
    background:linear-gradient(135deg,var(--caramel),var(--brown-mid));
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 8px 18px rgba(160,103,58,0.30);
}
.tut-welcome-mark svg{display:block;}
.tut-preview-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:26px;}
.tut-preview-item{display:flex;align-items:flex-start;gap:12px;padding:15px 16px;border:1px solid var(--border);border-radius:14px;background:var(--cream);transition:border-color var(--transition),background var(--transition);}
.tut-preview-item:hover{border-color:var(--caramel);background:var(--accent-lt);}
.tut-slide-closing{text-align:center;display:none;flex-direction:column;align-items:center;padding:20px 20px 4px;}
.tut-slide-closing.active{display:flex;}
.tut-closing-mark{
    width:56px;height:56px;border-radius:50%;
    background:linear-gradient(135deg,var(--caramel),var(--brown-mid));
    display:flex;align-items:center;justify-content:center;
    margin:0 0 20px;
    box-shadow:0 10px 24px rgba(160,103,58,0.35);
}
.tut-slide-closing .tut-eyebrow{text-align:center;}
.tut-slide-closing .tut-title{text-align:center;max-width:440px;}
.tut-slide-closing .tut-desc{text-align:center;max-width:440px;margin:0 auto;}
.tut-closing-strip{
    display:flex;gap:14px;margin-top:28px;
    padding:16px 26px;border-radius:var(--radius-pill);
    background:var(--cream);border:1px solid var(--border);
}
.tut-closing-strip span{
    display:flex;align-items:center;justify-content:center;
    width:38px;height:38px;border-radius:50%;
    background:var(--warm-white);border:1px solid var(--border);
    color:var(--caramel);
    transition:transform var(--transition),border-color var(--transition),color var(--transition);
}
.tut-closing-strip span:hover{transform:translateY(-2px);border-color:var(--caramel);color:var(--accent-dk);}
.tut-preview-num{width:26px;height:26px;border-radius:8px;background:var(--brown-deep);color:var(--caramel-light);font-family:var(--font-mono);font-weight:700;font-size:.76rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.tut-preview-label{font-family:var(--font-display);font-weight:700;font-size:.80rem;color:var(--brown-deep);line-height:1.3;}
.tut-preview-sub{font-family:var(--font-body);font-size:.68rem;color:var(--text-muted);margin-top:2px;}
.tut-title{
    font-family:var(--font-display);font-size:1.42rem;font-weight:800;
    color:var(--brown-deep);margin:0 0 12px;letter-spacing:-0.01em;
}
.tut-desc{
    font-family:var(--font-body);font-size:.92rem;line-height:1.7;
    color:var(--text-muted);margin:0;max-width:100%;
}
.tut-desc strong{color:var(--accent-dk);font-weight:700;}
.tut-dots{display:flex;justify-content:center;gap:7px;margin:26px 0 22px;}
.tut-dot{width:7px;height:7px;border-radius:50%;background:var(--border-dk);transition:all var(--transition-md);cursor:pointer;}
.tut-dot.active{background:var(--caramel);width:22px;border-radius:4px;}
.tut-actions{display:flex;gap:10px;}
.tut-btn{
    flex:1;padding:13px;border-radius:var(--radius-sm);
    font-family:var(--font-display);font-size:.84rem;font-weight:700;
    cursor:pointer;border:none;transition:all var(--transition-md);
    min-height:48px;
}
.tut-btn-back{background:transparent;border:1.5px solid var(--border-dk);color:var(--text-muted);}
.tut-btn-back:hover{border-color:var(--caramel);color:var(--caramel);}
.tut-btn-back.tut-hidden{visibility:hidden;}
.tut-btn-next{background:var(--brown-deep);color:#fff;box-shadow:0 8px 20px rgba(59,31,14,0.28);}
.tut-btn-next:hover{background:var(--brown-mid);transform:translateY(-1px);}
@media (max-width:600px){
    .tut-modal{padding:24px 20px 20px;max-width:94vw;}
    .tut-icon{font-size:2.2rem;}
    .tut-step-layout .tut-shot-frame{
        margin:-24px -20px 20px;
        width:calc(100% + 40px);
    }
    .tut-step-layout .tut-shot-frame .tut-icon-img{height:220px;}
    .tut-welcome-top{gap:12px;margin-bottom:16px;}
    .tut-welcome-mark{width:38px;height:38px;}
    .tut-title{font-size:1.14rem;}
    .tut-desc{font-size:.84rem;}
     .tut-preview-grid{grid-template-columns:1fr;gap:9px;margin-top:18px;}
    .tut-preview-item{padding:12px 13px;}
    .tut-slides{min-height:auto;}
    .tut-closing-mark{width:46px;height:46px;margin-bottom:16px;}
    .tut-closing-strip{gap:10px;padding:12px 18px;margin-top:20px;}
    .tut-closing-strip span{width:32px;height:32px;}
    .tut-closing-strip span svg{width:18px;height:18px;}
}

@media (min-width:601px) and (max-width:850px){
    .tut-step-layout .tut-shot-frame .tut-icon-img{height:340px;}
}
/* ================= RESPONSIVE ================= */
@media (max-width: 1300px) { :root { --studio-w: 380px; --ticket-w: 340px; } }

@media (max-width: 980px) {
    :root { --studio-w: 320px; }
    .panel:last-child { display: none; }
    .builder { grid-template-columns: var(--studio-w) 1fr; }
    body { overflow: auto; }
}

@media (max-width: 768px) {
    :root { --studio-w: 100%; --nav-h: 54px; }
    body { overflow: auto; height: auto; min-height: 100vh; }
    nav { padding: 0 14px; gap: 8px; }
    .nav-center { display: none; }
    .btn-back span { display: none; }
    .nav-brand { font-size: 1.10rem; }
    .builder { display: flex; flex-direction: column; height: auto; overflow: visible; padding: 12px 12px 90px; }
    .viewer {
        order: -1; width: 100%; height: 68vw;
        min-height: 300px; max-height: 460px; flex-shrink: 0;
        margin: 0 0 12px;
    }
    .panel:first-child { order: 1; width: 100%; max-height: none; overflow-y: visible; }
    .panel:last-child { display: none !important; }
    .viewer-badge { bottom: 10px; left: 10px; padding: 6px 12px; }
    .badge-flavor { font-size: .62rem; } .badge-shape { font-size: .58rem; }
    .viewer-controls { top: 10px; right: 10px; }
    .view-btn { width: 32px; height: 32px; }
    #brightnessControl { top: 10px !important; right: 46px !important; padding: 5px 10px !important; gap: 6px !important; }
    #spotBrightnessSlider { width: 55px !important; }
    #spotBrightnessVal { min-width: 24px; font-size: .6rem !important; }
    .viewer-hint { font-size: .6rem; padding: 6px 12px; top: 10px; max-width: 90%; white-space: normal; text-align: center; }
    .panel-body { padding: 0 0 110px; gap: 12px; }
    .panel-header { padding: 6px 2px 8px; }
    .shape-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }
    .addon-grid { grid-template-columns: 1fr 1fr; gap: 6px; }
    .opt, .addon-opt, .shape-opt, .num-opt, .digit-mode-btn, .orient-btn { min-height: 44px; }
    .fruit-tray, .choco-tray { max-width: calc(100% - 20px); flex-wrap: wrap; gap: 6px; padding: 7px 11px; }
    .model-status { bottom: 12px; }
}

@media (max-width: 400px) {
    .addon-grid { grid-template-columns: 1fr; }
    .shape-grid { grid-template-columns: repeat(2, 1fr); }
    .viewer { min-height: 260px; height: 75vw; }
}

#dragGhost {
    display: none !important;
    position: fixed !important;
    font-size: 2rem;
    pointer-events: none;
    z-index: 99999;
    will-change: left, top;
}
/* ================= PAGE LOAD ANIMATION ================= */
@keyframes slideInLeft { from { opacity: 0; transform: translateX(-24px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideInRight { from { opacity: 0; transform: translateX(24px); } to { opacity: 1; transform: translateX(0); } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
@keyframes navReveal { from { opacity: 0; transform: translateY(-14px); } to { opacity: 1; transform: translateY(0); } }
nav { animation: navReveal 0.4s cubic-bezier(0.4,0,0.2,1) both; }
.panel:first-child { animation: slideInLeft 0.5s 0.10s cubic-bezier(0.4,0,0.2,1) both; }
.panel:last-child { animation: slideInRight 0.5s 0.16s cubic-bezier(0.4,0,0.2,1) both; }
.viewer { animation: fadeInUp 0.55s 0.06s cubic-bezier(0.4,0,0.2,1) both; }
.btn-save-draft, .btn-proceed { display: none !important; }
    </style>
</head>
<body>

<!-- ================= TUTORIAL OVERLAY ================= -->
<div class="tut-overlay" id="tutOverlay">
    <div class="tut-modal" id="tutModal">
        <button class="tut-skip" id="tutSkipBtn">Skip</button>
        <div class="tut-slides" id="tutSlides">
                              <div class="tut-slide active" data-step="1">
                <div class="tut-welcome-top">
                    <div class="tut-welcome-mark">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 21h16"/><path d="M12 3v6"/><path d="M8 11c0-2 1-3 4-3s4 1 4 3"/></svg>
                    </div>
                    <div>
                        <div class="tut-eyebrow">Cake Builder</div>
                        <h2 class="tut-title">Design your own custom cake</h2>
                    </div>
                </div>
                <p class="tut-desc">We'll walk you through four quick steps to build a cake that's exactly yours — from the base to the final decorations.</p>
                          <div class="tut-preview-grid">
                    <div class="tut-preview-item">
                        <span class="tut-preview-num">1</span>
                        <div>
                            <div class="tut-preview-label">Cake Type, Shape &amp; Tier</div>
                            <div class="tut-preview-sub">Pick your base</div>
                        </div>
                    </div>
                    <div class="tut-preview-item">
                        <span class="tut-preview-num">2</span>
                        <div>
                            <div class="tut-preview-label">Flavor, Filling &amp; Style</div>
                            <div class="tut-preview-sub">Make it taste right</div>
                        </div>
                    </div>
                    <div class="tut-preview-item">
                        <span class="tut-preview-num">3</span>
                        <div>
                            <div class="tut-preview-label">Drips, Fruits &amp; Chocolates</div>
                            <div class="tut-preview-sub">Decorate it</div>
                        </div>
                    </div>
                    <div class="tut-preview-item">
                        <span class="tut-preview-num">4</span>
                        <div>
                            <div class="tut-preview-label">Add Characters &amp; Finish</div>
                            <div class="tut-preview-sub">Review &amp; submit</div>
                        </div>
                    </div>
                </div>
                           <div style="margin-top:18px;padding:12px 16px;background:var(--gold-lt);border:1px solid rgba(196,154,60,.28);border-radius:12px;font-size:.86rem;color:#6B4C08;font-family:var(--font-body);line-height:1.65;display:flex;align-items:flex-start;gap:10px;">
                    <span style="font-size:1.15rem;flex-shrink:0;margin-top:1px;">⚠️</span>
                    <span><strong>Note:</strong> Some cake components may not be compatible or suitable for combination in an actual cake. The 3D Cake Designer is intended only for visualization purposes, so certain combinations may appear in the 3D preview even though they may not be practically applicable or accurately represent the final cake design.</span>
                </div>
            </div>     <div class="tut-slide" data-step="2">
                <div class="tut-step-layout">
                    <div class="tut-shot-frame">
                        <div class="tut-shot-bar"><span></span><span></span><span></span></div>
                        <img src="/models/step1.gif" alt="Step 1" class="tut-icon-img">
                    </div>
                    <div class="tut-step-text">
                        <div class="tut-eyebrow">Step 1 of 4</div>
                        <h2 class="tut-title">Cake Type, Shape &amp; Tier</h2>
                        <p class="tut-desc">Start by choosing your <strong>Cake Type</strong> (Sponge, Chiffon, or Cheesecake), pick a <strong>Cake Shape</strong>, and set a <strong>Cake Tier</strong> if you want a stacked cake. Your 3D cake updates instantly as you choose.</p>
                    </div>
                </div>
            </div>
                     <div class="tut-slide" data-step="3">
                <div class="tut-step-layout">
                    <div class="tut-shot-frame">
                        <div class="tut-shot-bar"><span></span><span></span><span></span></div>
                        <img src="/models/step2.gif" alt="Step 2" class="tut-icon-img">
                    </div>
                    <div class="tut-step-text">
                        <div class="tut-eyebrow">Step 2 of 4</div>
                        <h2 class="tut-title">Flavor, Filling &amp; Style</h2>
                        <p class="tut-desc">Select a <strong>Flavor</strong>, add a <strong>Filling</strong>, then choose your <strong>Cake Style</strong> and <strong>Frosting/Icing</strong> — even pick custom colors.</p>
                    </div>
                </div>
            </div>
                 <div class="tut-slide" data-step="4">
                <div class="tut-step-layout">
                    <div class="tut-shot-frame">
                        <div class="tut-shot-bar"><span></span><span></span><span></span></div>
                        <img src="/models/step3.gif" alt="Step 3" class="tut-icon-img">
                    </div>
                    <div class="tut-step-text">
                        <div class="tut-eyebrow">Step 3 of 4</div>
                        <h2 class="tut-title">Drips, Fruits &amp; Chocolates</h2>
                        <p class="tut-desc">Turn on add-ons like <strong>Drip</strong>, <strong>Fruits</strong>, and <strong>Chocolate decorations</strong> — then <strong>drag them straight onto your cake</strong> in the 3D preview to place them exactly where you want.</p>
                    </div>
                </div>
            </div>
                   <div class="tut-slide" data-step="5">
                <div class="tut-step-layout">
                    <div class="tut-shot-frame">
                        <div class="tut-shot-bar"><span></span><span></span><span></span></div>
                        <img src="/models/step4.gif" alt="Step 4" class="tut-icon-img">
                    </div>
                    <div class="tut-step-text">
                        <div class="tut-eyebrow">Step 4 of 4</div>
                        <h2 class="tut-title">Add Characters &amp; Finish</h2>
                        <p class="tut-desc">Finish it off with a <strong>Character Topper</strong> if you'd like one, then check your full order and price breakdown on the right panel. Happy with it? Tap <strong>Submit Request</strong> to send your custom cake order.</p>
                    </div>
                </div>
            </div>
            <div class="tut-slide tut-slide-closing" data-step="6">
                <div class="tut-closing-mark">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <div class="tut-eyebrow">You're all set</div>
                <h2 class="tut-title">Time to bring your cake to life!</h2>
                <p class="tut-desc">Mix and match flavors, shapes, and decorations until it feels just right — your 3D preview updates instantly, so have fun exploring.</p>
                           <div class="tut-closing-strip">
                    <span title="Cake">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 21h16"/><path d="M12 3v6"/><path d="M8 11c0-2 1-3 4-3s4 1 4 3"/></svg>
                    </span>
                    <span title="Fruit">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8 2 5 6 5 10c0 5 4 10 7 12 3-2 7-7 7-12 0-4-3-8-7-8z"/><path d="M12 2c0 0 2-3 5-1"/></svg>
                    </span>
                    <span title="Chocolate">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="14" rx="2"/><line x1="8" y1="6" x2="8" y2="20"/><line x1="16" y1="6" x2="16" y2="20"/><line x1="2" y1="13" x2="22" y2="13"/></svg>
                    </span>
                    <span title="Candle">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="8" width="6" height="14" rx="1"/><path d="M10 8V5"/><path d="M9 5c0-1.5.5-3 1-3s1 1.5 1 3"/><rect x="14" y="8" width="4" height="13" rx="1"/><path d="M16 8V5"/><path d="M15 5c0-1.5.5-3 1-3s1 1.5 1 3"/></svg>
                    </span>
                    <span title="Character topper">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="tut-dots" id="tutDots"></div>
        <div class="tut-actions">
            <button class="tut-btn tut-btn-back tut-hidden" id="tutBackBtn">Back</button>
            <button class="tut-btn tut-btn-next" id="tutNextBtn">Next</button>
        </div>
    </div>
</div>

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
           
        </div>
        <div class="panel-body">

    {{-- CAKE TYPE --}}
            <div>
                <div class="section-label">Cake Type <span class="section-req">required</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 10px;font-family:var(--font-display);">Choose your cake base or specialty cake.</p>
     <div class="opts" id="opts-cake-type" style="margin-bottom:2px;display:grid;grid-template-columns:repeat(2,1fr);gap:7px;">
                    <div class="opt active" data-cake-type="Sponge Cake">Sponge Cake</div>
                    <div class="opt" data-cake-type="Chiffon Cake">Chiffon Cake</div>
                    <div class="opt" data-cake-type="Cheesecake">Cheesecake</div>
                </div>
            </div>

            {{-- SHAPE --}}
            <div>
        <div class="section-label">Cake Shape <span class="section-req">required</span></div>
                <div class="shape-grid" id="opts-shape">
                  <div class="shape-opt active" data-val="Round"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="16" rx="9" ry="3.5"/><ellipse cx="12" cy="12" rx="9" ry="3.5"/><line x1="3" y1="12" x2="3" y2="16"/><line x1="21" y1="12" x2="21" y2="16"/><ellipse cx="12" cy="8.5" rx="9" ry="3.5"/><line x1="3" y1="8.5" x2="3" y2="12"/><line x1="21" y1="8.5" x2="21" y2="12"/></svg><span class="sh-name">Round</span></div>
                  <div class="shape-opt" data-val="Square"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="13" width="18" height="6" rx="1"/><rect x="3" y="8" width="18" height="5" rx="1"/><rect x="5" y="4" width="14" height="4" rx="1"/></svg><span class="sh-name">Square</span></div>
                    <div class="shape-opt" data-val="Heart"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 21C12 21 3 15 3 9a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 6-9 12-9 12z"/><path d="M3 13h18"/></svg><span class="sh-name">Heart</span></div>
                  <div class="shape-opt" data-val="Number"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><text x="4" y="18" font-size="14" font-weight="700" fill="currentColor" stroke="none" font-family="sans-serif">18</text></svg><span class="sh-name">Number</span></div>
            <div class="shape-opt" data-val="Bundt">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <ellipse cx="12" cy="14" rx="9" ry="4.5"/>
                        <ellipse cx="12" cy="14" rx="4" ry="2"/>
                        <path d="M3 14 Q3 7 12 7 Q21 7 21 14"/>
                        <path d="M8 14 Q8 10 12 10 Q16 10 16 14"/>
                    </svg>
                    <span class="sh-name">Bundt</span>
                </div>
                </div>
             <div id="cakeTierSection">
              <div class="section-label" style="margin-top:14px;">Cake Tier <span style="font-size:.6rem;color:var(--text-muted);font-weight:400;margin-left:auto;">optional · Round only</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 8px;font-family:var(--font-display);">Leave on <strong>Single</strong> unless you want a stacked cake. Only applies to <strong>Round</strong> as of now.</p>
                <div class="shape-grid" id="opts-tier" style="grid-template-columns:repeat(3,1fr);">
                    <div class="shape-opt active" data-tier="Single"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="16" rx="8" ry="4"/><rect x="4" y="10" width="16" height="6" rx="1"/><path d="M6 10c0-3 2-5 6-5s6 2 6 5"/></svg><span class="sh-name">Single</span></div>
                    <div class="shape-opt" data-tier="Two-tier"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="19" rx="8" ry="2.5"/><rect x="4" y="14" width="16" height="5" rx="1"/><ellipse cx="12" cy="13" rx="5" ry="1.8"/><rect x="7" y="9" width="10" height="4" rx="1"/><path d="M9 9c0-2 1-3 3-3s3 1 3 3"/></svg><span class="sh-name">Two-tier</span></div>
                 <div class="shape-opt" data-tier="Three-tier"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="21" rx="8" ry="2"/><rect x="4" y="17" width="16" height="4" rx="1"/><ellipse cx="12" cy="16" rx="5.5" ry="1.5"/><rect x="6.5" y="12" width="11" height="4" rx="1"/><ellipse cx="12" cy="11" rx="3.5" ry="1.2"/><rect x="8.5" y="8" width="7" height="3" rx="1"/><path d="M10.5 8c0-1.5.8-2.5 1.5-2.5s1.5 1 1.5 2.5"/></svg><span class="sh-name">Three-tier</span></div>
        
                </div>
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
{{-- FLAVOUR --}}
            <div id="flavourSection">
                <div class="section-label">Flavor <span class="section-req">required</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 10px;font-family:var(--font-display);">Choose a flavor for your selected cake type.</p>
           <div class="opts" id="opts-flavor" style="margin-bottom:2px;">
                    <div class="opt active" data-val="Vanilla"    data-price="0">  <span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#F2C96A;border:1px solid #E0B040;"></span>Vanilla</span></div>
                    <div class="opt"        data-val="Chocolate"  data-price="80">  <span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#5C2D0E;"></span>Chocolate</span></div>
                    <div class="opt"        data-val="Red Velvet" data-price="100"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#8B1111;"></span>Red Velvet</span></div>
                    <div class="opt"        data-val="Strawberry" data-price="120"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#D94070;"></span>Strawberry</span></div>
                    <div class="opt"        data-val="Blueberry"  data-price="110"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#3A4A8A;"></span>Blueberry</span></div>
                    <div class="opt"        data-val="Ube"        data-price="130"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#6B3FA0;"></span>Ube</span></div>
                    <div class="opt"        data-val="Mocha"      data-price="100"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#4A2810;"></span>Mocha</span></div>
                    <div class="opt"        data-val="Mango"      data-price="120"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#F5A623;border:1px solid #E09010;"></span>Mango</span></div>
                    <div class="opt"        data-val="Biscoff"    data-price="140"><span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#C8752A;border:1px solid #A85A18;"></span>Biscoff</span></div>
                    <div class="opt"        data-val="Carrot"     data-price="80"> <span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#E8791E;"></span>Carrot</span></div>
                    <div class="opt"        data-val="Banana"     data-price="60"> <span style="display:flex;align-items:center;gap:6px;"><span class="flavor-dot" style="background:#F0DE7A;border:1px solid #D8C450;"></span>Banana</span></div>
                </div>
            </div>
{{-- FILLING --}}
            <div>
                <div class="section-label">Filling <span style="font-size:.6rem;color:var(--text-muted);font-weight:400;margin-left:auto;">optional</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 10px;font-family:var(--font-display);">Choose what goes between the cake layers.</p>
                <div class="opts" id="opts-filling" style="margin-bottom:2px;">
                    <div class="opt active" data-filling="No Filling">No Filling</div>
                    <div class="opt" data-filling="Vanilla Cream">Vanilla Cream</div>
                    <div class="opt" data-filling="Chocolate Ganache">Chocolate Ganache</div>
                    <div class="opt" data-filling="Cream Cheese">Cream Cheese</div>
                    <div class="opt" data-filling="Strawberry">Strawberry</div>
                    <div class="opt" data-filling="Blueberry">Blueberry</div>
                    <div class="opt" data-filling="Biscoff">Biscoff</div>
                </div>
            </div>

            {{-- CAKE STYLE --}}
            <div>
                <div class="section-label">Cake Style <span class="section-req">required</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 10px;font-family:var(--font-display);">Choose the<strong> overall finish</strong> or look of your cake.</p>
                <div class="addon-grid" id="opts-cake-style">
                    <div class="addon-opt frosting-opt active" data-val="Smooth Buttercream" data-price="0" data-group="style">
                      <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="17" rx="9" ry="4"/><rect x="3" y="10" width="18" height="7" rx="1"/><path d="M5 10c0-4 2-7 7-7s7 3 7 7"/></svg></div>
                        <div class="a-info"><span class="a-name">Smooth BC</span><span class="a-price">Default · Included</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                    <div class="addon-opt frosting-opt" data-val="Semi-naked Style" data-price="200" data-group="style">
                      <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="17" rx="9" ry="4"/><rect x="3" y="10" width="18" height="7" rx="1"/><path d="M5 10c0-4 2-7 7-7s7 3 7 7"/></svg></div>
                        <div class="a-info"><span class="a-name">Semi-naked</span><span class="a-price">+₱200</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                  <div class="addon-opt frosting-opt" data-val="Fondant Smooth" data-price="350" data-group="style">
                      <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="10" width="18" height="7" rx="1"/><path d="M5 10c0-4 2-7 7-7s7 3 7 7"/><path d="M3 14h18"/></svg></div>
                        <div class="a-info"><span class="a-name">Fondant</span><span class="a-price">+₱350</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                   
                    <div class="addon-opt frosting-opt" data-val="Ombre Style" data-price="250" data-group="style">
                        <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="17" rx="9" ry="4"/><rect x="3" y="10" width="18" height="7" rx="1"/><path d="M5 10c0-4 2-7 7-7s7 3 7 7"/><line x1="3" y1="11" x2="21" y2="11"/><line x1="3" y1="13" x2="21" y2="13"/><line x1="3" y1="15" x2="21" y2="15"/></svg></div>
                        <div class="a-info"><span class="a-name">Ombre</span><span class="a-price">+₱250</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>
          <div class="fondant-notice" id="fondantNotice">
                    <span class="fondant-notice-icon">⬜</span>
                    <div>
                        <span class="fondant-notice-title">Fondant selected — solo only</span>
                        <span class="fondant-notice-sub">Fondant replaces all frosting/icing options. Tap Fondant again to deselect.</span>
                    </div>
                </div>
          <div class="icing-panel" id="ombreColorPanel" style="background:linear-gradient(135deg,#FDF0F5 0%,#F2ECFB 100%);border-color:rgba(179,157,219,.35);">
    <div class="icing-header" style="color:#6B4A8A;">🎨 Choose your ombre colors</div>
   <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#8A6AA8;margin-bottom:6px;font-family:var(--font-body);">Top color</div>
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
        <div class="ombre-custom-swatch" id="ombreTopCustomSwatch" title="Pick any color" style="position:relative;width:48px;height:48px;border-radius:10px;flex-shrink:0;background:conic-gradient(from 0deg,#FF0000,#FFFF00,#00FF00,#00FFFF,#0000FF,#FF00FF,#FF0000);overflow:hidden;border:2px solid rgba(0,0,0,.08);box-shadow:0 0 0 3px rgba(179,157,219,.20);">
            <input type="color" id="ombreTopCustomInput" value="#F7A8C4" style="position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;border:none;padding:0;">
        </div>
        <span style="font-size:.68rem;color:#8A6AA8;font-family:var(--font-body);">Tap the wheel to pick any top color</span>
    </div>
    <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#8A6AA8;margin:10px 0 6px;font-family:var(--font-body);">Bottom color</div>
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
        <div class="ombre-custom-swatch" id="ombreBottomCustomSwatch" title="Pick any color" style="position:relative;width:48px;height:48px;border-radius:10px;flex-shrink:0;background:conic-gradient(from 0deg,#FF0000,#FFFF00,#00FF00,#00FFFF,#0000FF,#FF00FF,#FF0000);overflow:hidden;border:2px solid rgba(0,0,0,.08);box-shadow:0 0 0 3px rgba(179,157,219,.20);">
            <input type="color" id="ombreBottomCustomInput" value="#8A6AC8" style="position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;border:none;padding:0;">
        </div>
        <span style="font-size:.68rem;color:#8A6AA8;font-family:var(--font-body);">Tap the wheel to pick any bottom color</span>
    </div>
    <div style="display:flex;align-items:center;gap:10px;margin-top:8px;padding:8px 10px;background:rgba(255,255,255,.5);border-radius:9px;">
        <div style="width:34px;height:34px;border-radius:8px;flex-shrink:0;background:linear-gradient(to bottom, var(--ombre-preview-top,#F7A8C4) 0%, var(--ombre-preview-bottom,#8A6AC8) 100%);border:1.5px solid rgba(0,0,0,.08);" id="ombrePreviewSwatch"></div>
        <span style="font-size:.66rem;color:#6B4A8A;font-family:var(--font-body);line-height:1.5;">Baker will blend these two shades top-to-bottom on your cake.</span>
    </div>
</div>
            </div>
            {{-- FROSTING / ICING --}}
            <div>
                <div class="section-label">Frosting / Icing <span class="section-req">required</span></div>
                <p style="font-size:.68rem;color:var(--text-muted);margin:0 0 10px;font-family:var(--font-display);">Choose the <strong>icing</strong>used underneath or alongside <strong>your</strong> selected <strong>cake </strong> style.</p>

                <div class="frosting-section-label">🎨 Base Icing <span class="section-req">required</span></div>
                <div class="addon-grid" id="opts-frosting-base">
                    <div class="addon-opt frosting-opt active" data-val="Smooth Buttercream" data-price="0" data-group="base">
                        <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2c0 0 4 4 4 10s-4 10-4 10"/><path d="M2 12h20"/></svg></div>
                      <div class="a-info"><span class="a-name">Shell Border</span><span class="a-price">Default · Included · choose color</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                              <div class="addon-opt frosting-opt" data-val="Sugar Icing" data-price="150" data-group="base">
                        <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 8h10l-2 13H9L7 8z"/><path d="M5 8c0-4 3-6 7-6s7 2 7 6"/></svg></div>
                        <div class="a-info"><span class="a-name">Sugar Icing</span><span class="a-price">+₱150 · choose color</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                    <div class="addon-opt frosting-opt" data-val="Rosettes" data-price="100" data-group="base">
                        <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 2c0 4-3 7-3 10s3 6 3 10"/><path d="M2 12c4 0 7 3 10 3s6-3 10-3"/><path d="M5 5c3 3 3 6 7 7s6-1 9-4"/><path d="M5 19c3-3 3-6 7-7s6 1 9 4"/></svg></div>
                        <div class="a-info"><span class="a-name">Rosettes</span><span class="a-price">+₱100 · add-on</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>

                <div class="icing-panel" id="icingPanel">
                    <div class="icing-header">Choose icing color</div>
                    <div class="icing-color-grid" id="icingColorGrid" style="grid-template-columns:repeat(6,minmax(0,1fr));gap:5px;">
                        <div class="icing-color-opt light-color active" data-icing-color="#FFFFFF" data-icing-name="White"    style="background:#FFFFFF;border-color:#D5C8B8;"></div>
                        <div class="icing-color-opt light-color"        data-icing-color="#FFCCE0" data-icing-name="Pink"     style="background:#FFCCE0;"></div>
                        <div class="icing-color-opt light-color"        data-icing-color="#C8E6FF" data-icing-name="Sky Blue" style="background:#C8E6FF;"></div>
                        <div class="icing-color-opt light-color"        data-icing-color="#D4C8FF" data-icing-name="Lavender" style="background:#D4C8FF;"></div>
                        <div class="icing-color-opt"                    data-icing-color="#F5C842" data-icing-name="Gold"     style="background:#F5C842;"></div>
                        <div class="icing-color-opt"                    data-icing-color="#2C1810" data-icing-name="Chocolate" style="background:#2C1810;"></div>
                    </div>
                    <div class="icing-color-label" id="icingColorLabel">White</div>
                </div>

             <div class="frosting-section-label" style="margin-top:10px;">🖌️ Texture <span style="font-size:.58rem;color:var(--text-muted);font-weight:400;margin-left:4px;white-space:nowrap;">(OPTIONAL)</span></div>
                <div class="addon-grid" id="opts-frosting-special">
                           <div class="addon-opt frosting-opt" data-val="Textured Buttercream" data-price="150" data-group="texture">
                        <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 17l4-4 3 3 5-6 6 7H3z"/><path d="M3 7h18"/><path d="M3 12h18"/></svg></div>
                        <div class="a-info"><span class="a-name">Textured</span><span class="a-price">+₱150 · add-on</span></div>
                        <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                    </div>
                </div>
         <div class="candle-picker-panel" id="rosettePlacementPanel" style="background:linear-gradient(135deg,#FDF0F5 0%,#FBEAF0 100%);border-color:rgba(216,120,150,.32);">
       <div class="candle-picker-header">🌹 Rosette placement <span id="rosetteNumberDigitNotice" style="display:none;font-size:.58rem;font-weight:400;margin-left:6px;color:#B02040;">(rosettes only available for single-digit Number cakes)</span></div>
                                   <div class="candle-num-grid" id="opts-rosette-placement" style="grid-template-columns:repeat(3,1fr);">
                        <div class="candle-num-opt active" data-rosette-placement="Border" style="font-size:.58rem;">Border</div>
                        <div class="candle-num-opt" data-rosette-placement="Full Top" style="font-size:.58rem;">Full</div>
                        <div class="candle-num-opt" data-rosette-placement="Sides" style="font-size:.58rem;">Sides</div>
                        <div class="candle-num-opt" data-rosette-placement="Cluster Right" style="font-size:.54rem;">Cluster R</div>
                        <div class="candle-num-opt" data-rosette-placement="Cluster Left" style="font-size:.54rem;">Cluster L</div>
                    </div>
                  <div class="candle-active-badge" id="rosettePlacementBadge">Selected: Border</div>

                    <div class="frosting-section-label" style="margin-top:10px;">✨ Combo placements <span style="font-size:.58rem;color:var(--text-muted);font-weight:400;margin-left:4px;">(pick one, optional)</span></div>
                                   <div class="candle-num-grid" id="opts-rosette-combo" style="grid-template-columns:1fr;gap:6px;">
                        <div class="candle-num-opt" data-rosette-placement="Border+Sides" style="font-size:.68rem;text-align:left;padding:8px 10px;">Border + Sides</div>
                        <div class="candle-num-opt" data-rosette-placement="Full Top+Sides" style="font-size:.68rem;text-align:left;padding:8px 10px;">Full Top + Sides</div>
                        <div class="candle-num-opt" data-rosette-placement="Cluster Right+Sides" style="font-size:.68rem;text-align:left;padding:8px 10px;">Cluster Right + Sides</div>
                        <div class="candle-num-opt" data-rosette-placement="Cluster Left+Sides" style="font-size:.68rem;text-align:left;padding:8px 10px;">Cluster Left + Sides</div>
                    </div>
                                   <div class="candle-num-grid" id="opts-rosette-combo-number" style="grid-template-columns:1fr;gap:6px;display:none;">
                        <div class="candle-num-opt" data-rosette-placement="Border+Sides" style="font-size:.68rem;text-align:left;padding:8px 10px;">Border + Sides</div>
                        <div class="candle-num-opt" data-rosette-placement="Full Top+Sides" style="font-size:.68rem;text-align:left;padding:8px 10px;">Full Top + Sides</div>
                        <div class="candle-num-opt" data-rosette-placement="Middle+Sides" data-requires-middle="1" style="font-size:.68rem;text-align:left;padding:8px 10px;">Middle + Sides</div>
                    </div>

                    <div class="icing-header" style="margin-top:10px;">🎨 Rosette color</div>
                    <div class="icing-color-grid" id="rosetteColorGrid" style="grid-template-columns:repeat(6,minmax(0,1fr));gap:5px;">
                        <div class="icing-color-opt light-color active" data-rosette-color="#FFFFFF" data-rosette-color-name="White"    style="background:#FFFFFF;border-color:#D5C8B8;"></div>
                        <div class="icing-color-opt light-color"        data-rosette-color="#FFCCE0" data-rosette-color-name="Pink"     style="background:#FFCCE0;"></div>
                        <div class="icing-color-opt light-color"        data-rosette-color="#C8E6FF" data-rosette-color-name="Sky Blue" style="background:#C8E6FF;"></div>
                        <div class="icing-color-opt light-color"        data-rosette-color="#D4C8FF" data-rosette-color-name="Lavender" style="background:#D4C8FF;"></div>
                        <div class="icing-color-opt"                    data-rosette-color="#F5C842" data-rosette-color-name="Gold"     style="background:#F5C842;"></div>
                        <div class="icing-color-opt"                    data-rosette-color="#2C1810" data-rosette-color-name="Chocolate" style="background:#2C1810;"></div>
                    </div>
                    <div class="icing-color-label" id="rosetteColorLabel">White</div>
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

                <div class="addon-section-lbl"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l7 10a7 7 0 1 1-14 0L12 2z"/></svg> Drip</div>
                <div class="addon-grid" style="margin-bottom:6px;">
                    <div class="addon-opt" data-group="drips" data-val="Drip" data-price="180" id="dripToggleBtn">
                        <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l7 10a7 7 0 1 1-14 0L12 2z"/></svg></div>
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
                        <div class="drip-flavor-opt"        data-drip-flavor="Mango"         data-drip-color="#F5A623"><span class="drip-color-dot" style="background:#F5A623;"></span>Mango</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Salted Caramel" data-drip-color="#A0620A"><span class="drip-color-dot" style="background:#A0620A;"></span>Salted Caramel</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Blueberry"     data-drip-color="#3A1878"><span class="drip-color-dot" style="background:#3A1878;"></span>Blueberry</div>
                        <div class="drip-flavor-opt"        data-drip-flavor="Raspberry"     data-drip-color="#C01858"><span class="drip-color-dot" style="background:#C01858;"></span>Raspberry</div>
                    </div>
                </div>
<div class="addon-section-lbl" style="margin-top:10px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8 2 5 6 5 10c0 5 4 10 7 12 3-2 7-7 7-12 0-4-3-8-7-8z"/><path d="M12 2c0 0 2-3 5-1"/></svg> Fruits</div>
              <div style="background:var(--accent-lt);border:1px solid rgba(200,137,74,.25);border-radius:12px;padding:10px 12px;">
                    <p style="font-size:.72rem;font-weight:700;color:#7A4A1E;margin:0 0 10px;font-family:var(--font-display);">🖱️ Drag a fruit straight onto the cake below</p>
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;" id="opts-fruits">
                <div class="addon-opt fruit-tile" data-group="fruits" data-val="Strawberry" data-price="45" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C8 2 5 6 5 10c0 5 4 10 7 12 3-2 7-7 7-12 0-4-3-8-7-8z"/><path d="M12 2c0 0 2-3 5-1"/><circle cx="10" cy="10" r=".5" fill="currentColor"/><circle cx="14" cy="8" r=".5" fill="currentColor"/><circle cx="11" cy="14" r=".5" fill="currentColor"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Strawberry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱45/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                  <div class="addon-opt fruit-tile" data-group="fruits" data-val="Blueberry" data-price="25" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="14" r="5"/><circle cx="15" cy="11" r="4"/><circle cx="14" cy="17" r="3.5"/><path d="M9 4c0 0 1-2 3-2s3 2 3 2"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Blueberry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱25/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                    <div class="addon-opt fruit-tile" data-group="fruits" data-val="Raspberry" data-price="55" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="14" r="3"/><circle cx="7" cy="12" r="3"/><circle cx="17" cy="12" r="3"/><circle cx="9" cy="7" r="3"/><circle cx="15" cy="7" r="3"/><path d="M12 4V2"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Raspberry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱55/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                     <div class="addon-opt fruit-tile" data-group="fruits" data-val="Cherry" data-price="35" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="17" r="4"/><circle cx="17" cy="15" r="4"/><path d="M8 13C8 8 12 4 16 3"/><path d="M17 11C17 7 15 4 12 3"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Cherry</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱35/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt fruit-tile" data-group="fruits" data-val="Mango Slice" data-price="40" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 18 Q5 6 12 4 Q19 6 19 18 Q15 21 12 21 Q9 21 5 18z"/><path d="M12 4 Q12 12 12 21"/><path d="M5 18 Q12 15 19 18"/><path d="M6 13 Q12 11 18 13"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Mango Cube</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱40/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt fruit-tile" data-group="fruits" data-val="Kiwi Slice" data-price="30" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><line x1="12" y1="3" x2="12" y2="8"/><line x1="12" y1="16" x2="12" y2="21"/><line x1="3" y1="12" x2="8" y2="12"/><line x1="16" y1="12" x2="21" y2="12"/><line x1="5.6" y1="5.6" x2="8.5" y2="8.5"/><line x1="15.5" y1="15.5" x2="18.4" y2="18.4"/><line x1="18.4" y1="5.6" x2="15.5" y2="8.5"/><line x1="8.5" y1="15.5" x2="5.6" y2="18.4"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Kiwi Slice</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱30/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                   <div class="addon-opt fruit-tile" data-group="fruits" data-val="Peach Slice" data-price="35" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 3 Q18 3 20 9 Q22 15 18 19 Q15 22 12 22 Q9 22 6 19 Q2 15 4 9 Q6 3 12 3z"/><path d="M12 3 Q12 8 11 13 Q10 18 12 22"/><path d="M12 3 Q13 6 12 9"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Peach Slice</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱35/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt fruit-tile" data-group="fruits" data-val="Banana Slice" data-price="35" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 4c-1 5-1 10 2 14 3 3 8 3 11-1 1-1.5 1.5-3 1-4-1 2-3 3-5 3-4 0-7-3-8-8-.3-1.5-.5-3-1-4z"/><circle cx="18" cy="18" r="1.2" fill="currentColor" stroke="none"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Banana Slice</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱35/pc</span>
                            <div class="addon-check" style="margin-top:2px;"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                    </div>
                    <div id="fruitsDragNotice" style="display:none;margin-top:9px;padding:7px 10px;background:rgba(200,137,74,.15);border-radius:8px;font-size:.70rem;color:#7A4A1E;font-family:var(--font-display);align-items:center;gap:6px;flex-direction:row;">
                        <span style="font-size:1.1rem;">👆</span>
                        <span><strong>Now tap the cake preview</strong> to place your fruit. Tap a placed fruit to move it.</span>
                    </div>
            
                </div>

<div class="addon-section-lbl" style="margin-top:10px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="14" rx="2"/><line x1="8" y1="6" x2="8" y2="20"/><line x1="16" y1="6" x2="16" y2="20"/><line x1="2" y1="13" x2="22" y2="13"/></svg> Chocolate Decorations</div>
                <div style="background:var(--gold-lt);border:1px solid rgba(196,154,60,.28);border-radius:12px;padding:10px 12px;">
                    <p style="font-size:.72rem;font-weight:700;color:#6B4C08;margin:0 0 10px;font-family:var(--font-display);">Tap a decoration to add it — then tap the cake preview to place it</p>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;" id="opts-choco">
                   <div class="addon-opt" data-group="choco" data-val="Ferrero-style Ball" data-price="55" id="ferreroToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="2"/><path d="M7 7l2 2M15 15l2 2M17 7l-2 2M9 15l-2 2"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Ferrero</span>
                 <span class="a-price" style="font-size:.60rem;text-align:center;">+₱55/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt" data-group="choco" data-val="Kitkat Sticks" data-price="30" id="kitkatToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="8" width="18" height="8" rx="2"/><line x1="9" y1="8" x2="9" y2="16"/><line x1="15" y1="8" x2="15" y2="16"/><path d="M3 12h18"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">KitKat</span>
                 <span class="a-price" style="font-size:.60rem;text-align:center;">+₱30/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
            <div class="addon-opt" data-group="choco" data-val="Oreo Cookie" data-price="20" id="oreoToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="6"/><path d="M8 9h8M8 12h8M8 15h8"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Oreo</span>
                         <span class="a-price" style="font-size:.60rem;text-align:center;">+₱20/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                      <div class="addon-opt" data-group="choco" data-val="Chocolate Bar Shard" data-price="40" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7l18 3-4 10L3 7z"/><line x1="8" y1="8" x2="6" y2="14"/><line x1="13" y1="9" x2="11" y2="15"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Bar Shard</span>
                       <span class="a-price" style="font-size:.60rem;text-align:center;">+₱40/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                        <div class="addon-opt" data-group="choco" data-val="Chocolate Curls" data-price="45" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 12c0-3 2-5 4-4s3 4 1 6-6 3-8 1-2-6 1-8 8-2 9 2-1 8-5 9-9-2-9-6 3-8 7-8"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Choco Curls</span>
                      <span class="a-price" style="font-size:.60rem;text-align:center;">+₱45</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                  <div class="addon-opt" data-group="choco" data-val="Chocolate Plaque" data-price="80" id="plaqueToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="6" width="18" height="12" rx="2"/><line x1="9" y1="6" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="18"/><line x1="3" y1="12" x2="21" y2="12"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Choco Plaque</span>
                       <span class="a-price" style="font-size:.60rem;text-align:center;">+₱80</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                       <div class="addon-opt" data-group="choco" data-val="Toblerone Triangle" data-price="50" id="tobleroneToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 3 L22 20 L2 20 Z"/><path d="M12 3 L17 20"/><path d="M12 3 L7 20"/><line x1="5" y1="14" x2="19" y2="14"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Toblerone</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱50/pc</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                                           <div class="addon-opt" data-group="choco" data-val="Chocolate Sprinkles" data-price="30" id="chocoSprinkleToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="1.5"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Choco Sprinkles</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱30</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                                        <div class="addon-opt" data-group="choco" data-val="Crushed Peanuts" data-price="35" id="peanutsToggleBtn" style="flex-direction:column;align-items:center;padding:10px 6px;gap:5px;border-radius:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="9" r="2.4"/><circle cx="15" cy="8" r="2"/><circle cx="17" cy="14" r="1.8"/><circle cx="10" cy="15" r="2.2"/><circle cx="6" cy="16" r="1.6"/></svg>
                            <span class="a-name" style="font-size:.68rem;text-align:center;">Crushed Peanuts</span>
                            <span class="a-price" style="font-size:.60rem;text-align:center;">+₱35</span>
                            <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                        </div>
                    </div>
                <div class="candle-picker-panel" id="plaqueShapePanel" style="background:linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%);border-color:rgba(196,154,60,.32);">
                        <div class="candle-picker-header">🍫 Choose plaque shape</div>
                        <div class="candle-num-grid" id="opts-plaque-shape" style="grid-template-columns:repeat(5,1fr);">
                            <div class="candle-num-opt active" data-plaque-shape="Square" style="font-size:.60rem;">Square</div>
                            <div class="candle-num-opt" data-plaque-shape="Rectangle" style="font-size:.60rem;">Rect.</div>
                            <div class="candle-num-opt" data-plaque-shape="Circle" style="font-size:.60rem;">Circle</div>
                            <div class="candle-num-opt" data-plaque-shape="Heart" style="font-size:.60rem;">Heart</div>
                            <div class="candle-num-opt" data-plaque-shape="Oval" style="font-size:.60rem;">Oval</div>
                        </div>
                 <div class="candle-active-badge" id="plaqueShapeBadge">Selected: Square plaque</div>
                       <div style="margin-top:10px;">
                            <label style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--brown-mid);font-family:var(--font-mono);display:block;margin-bottom:6px;">Message: <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-muted);">(up to 3 lines — press Enter for a new line)</span></label>
                            <textarea id="plaqueMessageInput" maxlength="60" rows="3" placeholder="e.g. Happy&#10;Birthday!" style="width:100%;padding:9px 12px;border:1.5px solid var(--border-dk);border-radius:10px;font-family:var(--font-display);font-size:.80rem;color:var(--text);background:var(--surface);outline:none;resize:none;line-height:1.4;"></textarea>
                        </div>
                    </div>
                    <div class="candle-picker-panel" id="tobleroneFlavorPanel" style="background:linear-gradient(135deg,#FBF5E6 0%,#F5EDD8 100%);border-color:rgba(196,154,60,.32);">
                        <div class="candle-picker-header">🔺 Choose Toblerone flavor</div>
                        <div class="candle-num-grid" id="opts-toblerone-flavor" style="grid-template-columns:repeat(2,1fr);">
                            <div class="candle-num-opt active" data-toblerone-flavor="Chocolate" style="font-size:.62rem;">🍫 Chocolate</div>
                            <div class="candle-num-opt" data-toblerone-flavor="White" style="font-size:.62rem;">🤍 White</div>
                        </div>
                        <div class="candle-active-badge" id="tobleroneFlavorBadge">Selected: Chocolate · with hazelnut bits</div>
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

                <div id="chocoCurlsPlacementPanel" style="display:none;margin-top:9px;background:var(--gold-lt);border:1.5px solid rgba(196,154,60,.32);border-radius:12px;padding:9px 11px;">
                    <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:#6B4C08;margin-bottom:8px;font-family:var(--font-display);">🍫 Choco Curls placement</div>
                    <div style="display:flex;gap:0;border:1.5px solid rgba(196,154,60,.36);border-radius:9px;overflow:hidden;">
                        <button class="choco-curls-place-btn active" data-placement="middle" style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;cursor:pointer;background:var(--gold);color:#fff;transition:all .15s;">Middle</button>
                        <button class="choco-curls-place-btn"        data-placement="sides"  style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid rgba(196,154,60,.36);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Sides</button>
                        <button class="choco-curls-place-btn"        data-placement="both"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid rgba(196,154,60,.36);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Both</button>
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

                <div class="addon-section-lbl" style="margin-top:10px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/></svg> Sprinkles</div>
          <div class="addon-grid" id="opts-sprinkles" style="margin-bottom:10px;">
                    <div class="addon-opt" data-group="sprinkles" data-val="Cylinder Sprinkles" data-price="30"><div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1.5"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/></svg></div><div class="a-info"><span class="a-name">Cylinder Mix</span><span class="a-price">+₱30</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
               <div class="addon-opt" data-group="sprinkles" data-val="Sphere Sprinkles"   data-price="30"><div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><circle cx="5" cy="5" r="2"/><circle cx="19" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/></svg></div><div class="a-info"><span class="a-name">Pearl Mix</span>   <span class="a-price">+₱30</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
                </div>

                <!-- Cylinder placement panel -->
                <div id="cylinderPlacementPanel" style="display:none;margin-top:6px;background:var(--cream);border:1.5px solid rgba(200,137,74,.28);border-radius:12px;padding:9px 11px;">
                    <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--brown-mid);margin-bottom:8px;font-family:var(--font-display);">✨ Cylinder placement</div>
                    <div style="display:flex;gap:0;border:1.5px solid var(--border-dk);border-radius:9px;overflow:hidden;">
                        <button class="sprinkle-place-btn active" data-type="cylinder" data-placement="top"  style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;cursor:pointer;background:var(--caramel);color:#fff;transition:all .15s;">Top only</button>
                        <button class="sprinkle-place-btn"        data-type="cylinder" data-placement="sides" style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid var(--border-dk);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Sides only</button>
                        <button class="sprinkle-place-btn"        data-type="cylinder" data-placement="both"  style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid var(--border-dk);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Both</button>
                    </div>
                </div>
                <!-- Pearl placement panel -->
                <div id="pearlPlacementPanel" style="display:none;margin-top:6px;background:var(--cream);border:1.5px solid rgba(200,137,74,.28);border-radius:12px;padding:9px 11px;">
                    <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--brown-mid);margin-bottom:8px;font-family:var(--font-display);">🔮 Pearl placement</div>
                    <div style="display:flex;gap:0;border:1.5px solid var(--border-dk);border-radius:9px;overflow:hidden;">
                        <button class="sprinkle-place-btn active" data-type="pearl" data-placement="top"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;cursor:pointer;background:var(--caramel);color:#fff;transition:all .15s;">Top only</button>
                        <button class="sprinkle-place-btn"        data-type="pearl" data-placement="sides"  style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid var(--border-dk);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Sides only</button>
                        <button class="sprinkle-place-btn"        data-type="pearl" data-placement="both"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid var(--border-dk);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Both</button>
                    </div>
                </div>

                <!-- Chocolate Sprinkles placement panel -->
                <div id="chocoSprinklePlacementPanel" style="display:none;margin-top:6px;background:var(--gold-lt);border:1.5px solid rgba(196,154,60,.30);border-radius:12px;padding:9px 11px;">
                    <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:#6B4C08;margin-bottom:8px;font-family:var(--font-display);">🍫 Choco Sprinkles placement</div>
                    <div style="display:flex;gap:0;border:1.5px solid rgba(196,154,60,.36);border-radius:9px;overflow:hidden;">
                        <button class="sprinkle-place-btn active" data-type="chocoSprinkle" data-placement="top"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;cursor:pointer;background:var(--gold);color:#fff;transition:all .15s;">Top only</button>
                        <button class="sprinkle-place-btn"        data-type="chocoSprinkle" data-placement="sides"  style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid rgba(196,154,60,.36);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Sides only</button>
                        <button class="sprinkle-place-btn"        data-type="chocoSprinkle" data-placement="both"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid rgba(196,154,60,.36);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Both</button>
                    </div>
                </div>

                <!-- Crushed Peanuts placement panel -->
                <div id="peanutsPlacementPanel" style="display:none;margin-top:6px;background:var(--cream);border:1.5px solid rgba(200,137,74,.28);border-radius:12px;padding:9px 11px;">
                    <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--brown-mid);margin-bottom:8px;font-family:var(--font-display);">🥜 Crushed Peanuts placement</div>
                    <div style="display:flex;gap:0;border:1.5px solid var(--border-dk);border-radius:9px;overflow:hidden;">
                        <button class="sprinkle-place-btn active" data-type="peanuts" data-placement="top"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;cursor:pointer;background:var(--caramel);color:#fff;transition:all .15s;">Top only</button>
                        <button class="sprinkle-place-btn"        data-type="peanuts" data-placement="sides"  style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid var(--border-dk);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Sides only</button>
                        <button class="sprinkle-place-btn"        data-type="peanuts" data-placement="both"   style="flex:1;padding:7px 4px;font-size:.72rem;font-weight:600;font-family:var(--font-display);border:none;border-left:1.5px solid var(--border-dk);cursor:pointer;background:var(--surface);color:var(--text-muted);transition:all .15s;">Both</button>
                    </div>
                </div>
                <div class="addon-section-lbl"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="8" width="6" height="14" rx="1"/><path d="M12 8V4"/><path d="M10 4c0-1.5 1-3 2-3s2 1.5 2 3"/></svg> Candles &amp; Toppers</div>
          <div class="addon-grid" id="opts-candles" style="margin-bottom:10px;">
                    <div class="addon-opt" data-group="candles" data-val="Number Candles"        data-price="20"> <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="8" y="8" width="4" height="13" rx="1"/><path d="M10 8V5"/><path d="M9 5c0-1.5.5-3 1-3s1 1.5 1 3"/><rect x="14" y="8" width="4" height="13" rx="1"/><path d="M16 8V5"/><path d="M15 5c0-1.5.5-3 1-3s1 1.5 1 3"/></svg></div><div class="a-info"><span class="a-name">Number Candle</span><span class="a-price">+₱20/pc</span></div><div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div></div>
               <div class="addon-opt" data-group="candles" data-val="Character Topper" data-price="150" id="characterToggleBtn">
    <div class="a-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg></div>
    <div class="a-info"><span class="a-name">Character Topper</span> <span class="a-price">+₱150 · pick character</span></div>
    <div class="addon-check"><svg viewBox="0 0 12 12" fill="none" stroke="#fff" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
</div>
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

       <div class="candle-picker-panel" id="characterPickerPanel">
                    <div class="candle-picker-header"> Choose your character topper</div>
                        <div id="characterCategoryList" style="display:flex;flex-direction:column;">

                  <div class="char-cat-group" data-cat-group="spongebob">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">SpongeBob SquarePants</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                                <div class="candle-num-opt" data-character="SpongeBob">SpongeBob<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Squidward">Squidward<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Patrick Star">Patrick Star<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Gary">Gary<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Squidward's House">Squidward's House<span class="char-price">₱500</span></div>
                                <div class="candle-num-opt" data-character="SpongeBob's House">SpongeBob's House<span class="char-price">₱500</span></div>
                                <div class="candle-num-opt" data-character="Patrick's House">Patrick's House<span class="char-price">₱500</span></div>
                            </div>
                        </div>

                        <div class="char-cat-group" data-cat-group="ben10">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">Ben 10</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                                <div class="candle-num-opt" data-character="Ben 10">Ben 10<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Ben 10 RV">Ben 10 RV<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Gwen">Gwen<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Lolo Max">Lolo Max<span class="char-price">₱350</span></div>
                            </div>
                        </div>

                        <div class="char-cat-group" data-cat-group="powerpuff">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">Powerpuff Girls</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                                <div class="candle-num-opt" data-character="Buttercup">Buttercup<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Blossom">Blossom<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Bubbles">Bubbles<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Powerpuff House">Powerpuff House<span class="char-price">₱500</span></div>
                            </div>
                        </div>

                        <div class="char-cat-group" data-cat-group="dora">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">Dora the Explorer</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                                <div class="candle-num-opt" data-character="Dora">Dora<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Boots">Boots<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Dora's House">Dora's House<span class="char-price">₱500</span></div>
                            </div>
                        </div>

                    <div class="char-cat-group" data-cat-group="sanrio">
    <button type="button" class="char-cat-toggle">
        <span class="char-cat-toggle-name">Sanrio</span>
        <span class="char-cat-arrow">▸</span>
    </button>
    <div class="char-cat-options">
        <div class="candle-num-opt" data-character="Kuromi">Kuromi<span class="char-price">₱350</span></div>
        <div class="candle-num-opt" data-character="My Melody">Melody<span class="char-price">₱350</span></div>
        <div class="candle-num-opt" data-character="Cinnamoroll">Cinnamoroll<span class="char-price">₱350</span></div>
        <div class="candle-num-opt" data-character="Hello Kitty">Hello Kitty<span class="char-price">₱350</span></div>
    </div>
</div>

                        <div class="char-cat-group" data-cat-group="cars">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">Cars</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                                <div class="candle-num-opt" data-character="Lightning McQueen">Lightning McQueen<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Sally">Sally<span class="char-price">₱350</span></div>
                            </div>
                        </div>

                        <div class="char-cat-group" data-cat-group="mickey">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">MickeyMouse Clubhouse</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                             <div class="candle-num-opt" data-character="Mickey Mouse">Mickey Mouse<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Minnie Mouse">Minnie Mouse<span class="char-price">₱350</span></div>
                                <div class="candle-num-opt" data-character="Mickey Mouse Clubhouse">Mickey Clubhouse<span class="char-price">₱500</span></div>
                            </div>
                        </div>

                        <div class="char-cat-group" data-cat-group="cocomelon">
                            <button type="button" class="char-cat-toggle">
                                <span class="char-cat-toggle-name">Cocomelon</span>
                                <span class="char-cat-arrow">▸</span>
                            </button>
                            <div class="char-cat-options">
                                <div class="candle-num-opt" data-character="Cocomelon">Cocomelon<span class="char-price">₱350</span></div>
                            </div>
                        </div>


                    </div>
           <div class="candle-active-badge" id="characterActiveBadge" style="margin-top:8px;">None placed yet — tap a character to add</div>
                  <button id="btnClearCharacters" style="margin-top:6px;width:100%;padding:7px;background:transparent;border:1.5px dashed rgba(200,137,74,.40);border-radius:9px;color:var(--brown-mid);font-size:.70rem;font-weight:600;cursor:pointer;font-family:var(--font-display);">Clear all placed characters</button>
                </div>
       

              </div>
        </div>
    </div>

    {{-- CENTER: VIEWER --}}
    <div class="viewer" id="viewerEl">
        <div id="model-container"></div>
           <canvas id="fruitCanvas"></canvas>
        <div class="icing-anim-overlay" id="icingAnimOverlay"></div>
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
            <button class="view-btn" id="btnHelpTutorial" title="How this works">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 1 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </button>
        </div>
      <div id="brightnessControl" style="display:none;"></div>
        <div class="viewer-hint" id="viewerHint">🖱 Drag to rotate &nbsp;·&nbsp; Scroll to zoom</div>
        <div class="model-status hidden" id="modelStatus">Ready</div>

      {{-- FRUIT TRAY --}}
        <div class="fruit-tray" id="fruitTray">
            <span class="fruit-tray-label">Drag:</span>
            <div class="fruit-draggable" data-fruit="Strawberry" data-emoji="🍓" draggable="true" id="trayStrawberry">🍓<span class="fruit-tip">Strawberry</span></div>
            <div class="fruit-draggable" data-fruit="Blueberry"  data-emoji="🫐" draggable="true" id="trayBlueberry">🫐<span class="fruit-tip">Blueberry</span></div>
            <div class="fruit-draggable" data-fruit="Raspberry"  data-emoji="🍇" draggable="true" id="trayRaspberry">🍇<span class="fruit-tip">Raspberry</span></div>
            <div class="fruit-draggable" data-fruit="Cherry"     data-emoji="🍒" draggable="true" id="trayCherry">🍒<span class="fruit-tip">Cherry</span></div>
            <div class="fruit-draggable" data-fruit="Mango Slice" data-emoji="🥭" draggable="true" id="trayMango">🥭<span class="fruit-tip">Mango</span></div>
            <div class="fruit-draggable" data-fruit="Kiwi Slice"  data-emoji="🥝" draggable="true" id="trayKiwi">🥝<span class="fruit-tip">Kiwi</span></div>
           <div class="fruit-draggable" data-fruit="Peach Slice" data-emoji="🍑" draggable="true" id="trayPeach">🍑<span class="fruit-tip">Peach</span></div>
            <div class="fruit-draggable" data-fruit="Banana Slice" data-emoji="🍌" draggable="true" id="trayBanana">🍌<span class="fruit-tip">Banana</span></div>
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
            <div class="toblerone-draggable" data-toblerone="Toblerone Triangle" data-emoji="🔺" draggable="true" id="trayToblerone" style="display:none;">🔺<span class="toblerone-tip">Toblerone</span></div>
            <div class="choco-tray-sep" id="chocoTraySep" style="display:none;"></div>
            <span style="font-size:.6rem;color:rgba(255,130,110,.7);font-family:var(--font-body);display:none;" id="kitkatOrientBadge">📏 Standing</span>
            <span style="font-size:.6rem;color:rgba(230,220,200,.7);font-family:var(--font-body);display:none;" id="oreoOrientBadge">⚫ Lying Flat</span>
            <div class="choco-tray-sep" id="chocoTraySep2" style="display:none;"></div>
            <button class="choco-clear-btn" id="btnClearAllChoco" style="display:none;">Clear all</button>
        </div>

{{-- CANDLE TRAY --}}
        <div class="fruit-tray" id="candleTray" style="background:rgba(38,22,4,0.88);border:1px solid rgba(196,154,60,0.45);">
            <span class="fruit-tray-label" style="color:rgba(220,180,80,0.85);">🕯️ Candle:</span>
                       <div class="candle-draggable" id="trayCandle" draggable="true" style="border-color:rgba(196,154,60,0.45);background:rgba(60,35,5,0.70);">🕯️<span class="fruit-tip" id="trayCandleLabel">Candle #1</span></div>
            <div class="fruit-tray-sep" style="background:rgba(196,154,60,0.25);"></div>
            <button class="fruit-clear-btn" id="btnClearCandles">Clear all</button>
        </div>

       <div id="dragGhost" style="display:none;"></div>
        <div class="drop-ring" id="dropRing" style="width:36px;height:36px;"></div>
        <div class="ferrero-drop-ring" id="ferreroDropRing" style="width:40px;height:40px;"></div>
        <div class="kitkat-drop-ring" id="kitkatDropRing" style="width:48px;height:24px;"></div>
        <div class="oreo-drop-ring" id="oreoDropRing" style="width:42px;height:42px;"></div>
<div class="bar-shard-drop-ring" id="barShardDropRing" style="width:48px;height:36px;"></div>
        <div class="toblerone-drop-ring" id="tobleroneDropRing" style="width:44px;height:44px;"></div>
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
             <div class="cfg-row"><span class="cfg-key">Cake Type</span><span class="cfg-val" id="selCakeType">Sponge Cake</span></div>
                              <div class="cfg-row"><span class="cfg-key">Shape</span><span class="cfg-val" id="selShape">Round 6"</span></div>
                <div class="cfg-row" id="selFlavorRow"><span class="cfg-key">Flavour</span><span class="cfg-val" id="selFlavor">Vanilla</span></div>
                <div class="cfg-row" id="selFillingRow"><span class="cfg-key">Filling</span><span class="cfg-val" id="selFilling">No Filling</span></div>
                <div class="cfg-row"><span class="cfg-key">Cake Style</span><span class="cfg-val" id="selCakeStyle">Smooth Buttercream</span></div>
                <div class="cfg-row"><span class="cfg-key">Frosting</span><span class="cfg-val" id="selFrosting">Default</span></div>
                <div class="cfg-row" id="selIcingRow" style="display:none;"><span class="cfg-key">Icing Color</span><span class="cfg-val" id="selIcingColor">White</span></div>
           
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
                   
                </div>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#B85C38" stroke-width="1.5" opacity="0.35"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <button class="btn-proceed-lg" id="btnProceedLg">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Submit Request
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

const renderer = new THREE.WebGLRenderer({
    antialias: false,
    alpha: true,
    preserveDrawingBuffer: false,
    powerPreference: 'high-performance',
});
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));
renderer.setSize(container.clientWidth, container.clientHeight);
renderer.outputEncoding      = THREE.sRGBEncoding;
renderer.toneMapping         = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.05;
renderer.shadowMap.enabled    = true;
renderer.shadowMap.type       = THREE.PCFShadowMap;
renderer.shadowMap.autoUpdate = false;
renderer.shadowMap.needsUpdate = true;
renderer.setClearColor(0x000000, 0); // transparent — CSS background shows through
// Dynamic clear color will be set per flavor via _applyFlavorTheme
container.appendChild(renderer.domElement);
const scene  = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(36, container.clientWidth / container.clientHeight, 0.01, 100);
camera.position.set(0, 1.8, 8.5);
const controls = new OrbitControls(camera, renderer.domElement);
const _basePixelRatio = Math.min(window.devicePixelRatio, 1.5);
let _interactionLowResTimer = null;
controls.addEventListener('start', ()=>{
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1));
    if(_interactionLowResTimer) clearTimeout(_interactionLowResTimer);
});
controls.addEventListener('end', ()=>{
    if(_interactionLowResTimer) clearTimeout(_interactionLowResTimer);
    _interactionLowResTimer = setTimeout(()=>{
        renderer.setPixelRatio(_basePixelRatio);
        renderer.shadowMap.needsUpdate = true;
    }, 120);
});
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

let _spotBrightness = 0.18; // 0.0 – 1.0, user-adjustable — dimmed

const spotLights = STAGE_LIGHTS.map((cfg, i) => {
const spot = new THREE.SpotLight(0xD8E8FF, 1.2 * _spotBrightness);
spot.position.set(...cfg.pos);
spot.angle      = 0.16;
spot.penumbra   = 0.75;
spot.decay      = 3.2;
    spot.castShadow = (i === 1); // only center casts shadow
    if(i === 1){
       spot.shadow.mapSize.set(512, 512);
        spot.shadow.camera.near = 0.5;
        spot.shadow.camera.far  = 18;
        spot.shadow.bias        = -0.0003;
        spot.shadow.normalBias  = 0.04;
        spot.shadow.radius      = 2;
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

const bounceFill = new THREE.PointLight(0xE8C870, 0.45);
bounceFill.position.set(0, -0.8, 0);
scene.add(bounceFill);
const fillLight = new THREE.DirectionalLight(0xF0C878, 0.06);
fillLight.position.set(-5, 5, 3); scene.add(fillLight);
const tableBouce = new THREE.DirectionalLight(0xD4904A, 0.08);
tableBouce.position.set(0, -2, 2); scene.add(tableBouce);
const backWall = new THREE.DirectionalLight(0xE8C870, 0.04);
backWall.position.set(1, 3, -8); scene.add(backWall);
scene.add(new THREE.AmbientLight(0xC89840, 0.12));

// ── Soft circular glow behind/under the cake ──
(function buildAtmosphere(){
    // Radial floor glow — warm pool of light under cake stand
    const glowGeo = new THREE.CircleGeometry(2.8, 64);
    const glowMat = new THREE.MeshBasicMaterial({
        color: 0xFFCC66, transparent: true, opacity: 0.13,
        depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide,
    });
    const glowMesh = new THREE.Mesh(glowGeo, glowMat);
    glowMesh.rotation.x = -Math.PI / 2;
    glowMesh.position.set(0, -1.17, 0);
    scene.add(glowMesh);

    // Inner tighter glow
    const innerGeo = new THREE.CircleGeometry(1.2, 48);
    const innerMat = new THREE.MeshBasicMaterial({
        color: 0xFFEE99, transparent: true, opacity: 0.18,
        depthWrite: false, blending: THREE.AdditiveBlending, side: THREE.DoubleSide,
    });
    const innerMesh = new THREE.Mesh(innerGeo, innerMat);
    innerMesh.rotation.x = -Math.PI / 2;
    innerMesh.position.set(0, -1.16, 0);
    scene.add(innerMesh);


})();
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
const coneH = 4.8, coneR = 1.35, coneSegs = 16, coneRings = 10;
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
      const cSegs = 14, cRings = 8;
      const cRadius = coneLength * Math.tan(0.14); // tighter cone, no floor splash

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
const characterModels = [];
const candleModels = [];
let _draggingCharacterIdx = -1;
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
// Instead of a one-shot flag, keep rendering until a timestamp passes.
// This covers async model loads and multi-second reveal animations,
// not just the single frame right after a click.
let _renderUntil = performance.now() + 800; // render on initial page load
window._requestRender = function(durationMs){
    const target = performance.now() + (durationMs || 500);
    if (target > _renderUntil) _renderUntil = target;
};
function animate(){
    requestAnimationFrame(animate);
    const delta = clock.getDelta();
    const elapsed = clock.elapsedTime;

    const hasFlames = candleModels.length > 0;
    const isDraggingDecoration =
        (typeof window.getDraggingFruitIdx     === 'function' && window.getDraggingFruitIdx()     >= 0) ||
        (typeof window.getDraggingFerreroIdx   === 'function' && window.getDraggingFerreroIdx()   >= 0) ||
        (typeof window.getDraggingKitkatIdx    === 'function' && window.getDraggingKitkatIdx()    >= 0) ||
        (typeof window.getDraggingOreoIdx      === 'function' && window.getDraggingOreoIdx()      >= 0) ||
        (typeof window.getDraggingBarShardIdx  === 'function' && window.getDraggingBarShardIdx()  >= 0) ||
        (typeof window.getDraggingTobleroneIdx === 'function' && window.getDraggingTobleroneIdx() >= 0) ||
        (typeof window.getDraggingCandleIdx    === 'function' && window.getDraggingCandleIdx()    >= 0) ||
        (typeof window.getDraggingCharacterIdx === 'function' && window.getDraggingCharacterIdx() >= 0);
    if (hasFlames || isDraggingDecoration) window._requestRender(300);

    const controlsChanged = controls.update(delta);
    if (controlsChanged) window._requestRender(300);

    if (performance.now() >= _renderUntil) {
        return;
    }
    if(candleModels.length){
        for(let ci=0; ci<candleModels.length; ci++){
            candleModels[ci].group.traverse(node => {
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
        }
    }

    if(typeof characterModels !== 'undefined'){
        const _easeFactor = Math.min(1, delta * 10);
        characterModels.forEach(m=>{
            if(m.group._targetPos) m.group.position.lerp(m.group._targetPos, _easeFactor);
        });
    }

    renderer.render(scene, camera);
}
animate();
const SHAPE_SLUG = {
    'Round':          'round',
    'Square':         'square',
    'Heart':          'heart',
    'Bundt':          'bundt',
    'Sponge Cake':    'sponge',
    'Chiffon':        'chiffon',
    'Two-tier Round': 'two-tier',
    'Three-tier Round':'three-tier',
    'Four-tier Round':'four-tier',
};
function getRosetteFileMap(slug){
    if(slug === 'square'){
        return {
            'Border':        'rosette_square',
            'Full Top':      'rosette_top_square',
            'Sides':         'rosette_sides_square',
            'Cluster Right': 'rosette_cluster_right_square',
            'Cluster Left':  'rosette_cluster_left_square',
        };
    }
    if(slug === 'heart'){
        return {
            'Border':        'rosette_heart',
            'Full Top':      'rosette_top_heart',
            'Sides':         'rosette_sides_heart',
            'Cluster Right': 'rosette_cluster_right_heart',
            'Cluster Left':  'rosette_cluster_left_heart',
        };
    }
    if(slug === 'two-tier'){
        return {
            'Border':        'rosette_two-tier',
            'Full Top':      'rosette_top_two-tier',
            'Sides':         'rosette_sides_two-tier',
            'Cluster Right': 'rosette_cluster_right_two-tier',
            'Cluster Left':  'rosette_cluster_left_two-tier',
        };
    }
    if(slug === 'three-tier'){
        return {
            'Border':        'rosette_three-tier',
            'Full Top':      'rosette_top_three-tier',
            'Sides':         'rosette_sides_three-tier',
            'Cluster Right': 'rosette_cluster_right_three-tier',
            'Cluster Left':  'rosette_cluster_left_three-tier',
        };
    }
  return {
        'Border':        `rosette_${slug}`,
        'Full Top':      'rosette_top',
        'Sides':         'rosette_sides',
        'Cluster Right': 'rosette_cluster_right',
        'Cluster Left':  'rosette_cluster_left',
    };
}
// Number-shape rosette pieces are per-digit exports: rosette_{digit}_middle.glb,
// rosette_{digit}_border.glb, rosette_{digit}_full.glb, rosette_{digit}_sides.glb.
// Only these four placements are supported for Number cakes.
function getNumberRosetteFileMap(digit){
    return {
        'Middle':   `rosette_${digit}_middle`,
        'Border':   `rosette_${digit}_border`,
        'Full Top': `rosette_${digit}_full`,
        'Sides':    `rosette_${digit}_sides`,
    };
}
// Per-digit horizontal nudge for the "Sides" rosette placement on single-digit
// Number cakes. Values are a FRACTION of the cake's own diameter.
// xNudge: positive = move right, negative = move left.
// zNudge: negative = move toward the top of the top-down view, positive = move toward the bottom.
const ROSETTE_SIDES_DIGIT_NUDGE = {
    1: { xNudge: 0.025, zNudge: -0.013 },
4: { xNudge: 0,    zNudge: -0.015 },
    7: { xNudge: 0,    zNudge: -0.01 },
};
// Semi-naked cakes reuse the SAME per-digit nudge values as smooth BC —
// close enough in proportions that separate tuning isn't needed.
function getRosetteSidesNudge(digit, frostingsArr){
    return ROSETTE_SIDES_DIGIT_NUDGE[digit] || {xNudge:0, zNudge:0, yNudge:0};
}
// Shared scale+position fit for ONE rosette piece against ITS digit's base
// mesh. Used at initial build time for both single- and dual-digit Number
// cakes, and re-invoked once more after everything settles (see the final
// settle block near the end of updateScene) so a piece that ends up
// positioned against a stale pre-stand transform gets corrected.
function fitNumberRosettePiece(rg, baseMesh, digitVal, placement, frostingsArr){
    if(!rg || !baseMesh) return;
    rg.position.set(0,0,0); rg.rotation.set(0,0,0); rg.scale.set(1,1,1);
    rg.updateMatrixWorld(true);
    baseMesh.updateMatrixWorld(true);
    const baseBox = new THREE.Box3().setFromObject(baseMesh);
    const baseDiam = Math.max(baseBox.max.x-baseBox.min.x, baseBox.max.z-baseBox.min.z);
    const baseHeight = baseBox.max.y - baseBox.min.y;
    const rawBox = new THREE.Box3().setFromObject(rg);
    const rawDiam = Math.max(rawBox.max.x-rawBox.min.x, rawBox.max.z-rawBox.min.z);
    const rawHeight = rawBox.max.y - rawBox.min.y;
    const scale = rawDiam > 0.0001 ? baseDiam/rawDiam : 1.0;

    if(placement === 'Sides'){
        const SIDES_DIAM_MULT = 1.12;
        const scaleXZ = scale * SIDES_DIAM_MULT;
        const targetHeight = baseHeight * 0.92;
        const scaleY = rawHeight > 0.0001 ? targetHeight/rawHeight : scaleXZ;
        rg.scale.set(scaleXZ, scaleY, scaleXZ);
    } else {
        rg.scale.setScalar(scale);
    }
    rg.updateMatrixWorld(true);

    const scaledBox = new THREE.Box3().setFromObject(rg);
    const scaledCenter = scaledBox.getCenter(new THREE.Vector3());
    const baseCenter = baseBox.getCenter(new THREE.Vector3());

    if(placement === 'Sides'){
        const nudge = getRosetteSidesNudge(digitVal, frostingsArr);
        rg.position.set(
            baseCenter.x - scaledCenter.x + (baseDiam * (nudge.xNudge||0)),
            (baseBox.max.y - scaledBox.max.y) + 0.02 + (baseDiam * (nudge.yNudge||0)),
            baseCenter.z - scaledCenter.z + (baseDiam * (nudge.zNudge||0))
        );
    } else {
        const wrapperTopY = baseMesh.parent
            ? new THREE.Box3().setFromObject(baseMesh.parent).max.y
            : baseBox.max.y;
        const roseSink = (scaledBox.max.y - scaledBox.min.y) * 0.12;
        rg.position.set(
            baseCenter.x - scaledCenter.x,
            wrapperTopY - scaledBox.min.y - roseSink,
            baseCenter.z - scaledCenter.z
        );
    }
    rg.updateMatrixWorld(true);
}
// Digits 0, 4, 6, 8, 9 have a dedicated "middle" export; digits 1, 2, 3, 5, 7
// only have Border/Full/Sides (no Middle piece exists for those numeral shapes).
const NUMBER_ROSETTE_DIGITS_WITH_MIDDLE = new Set([0,4,6,8,9]);
function getAvailableNumberRosettePlacements(digit){
    const base = ['Border','Full Top','Sides'];
    if(NUMBER_ROSETTE_DIGITS_WITH_MIDDLE.has(digit)) base.unshift('Middle');
    return base;
}
function getFrostingFileSuffix(arr){
    if(arr.includes('Fondant Smooth'))  return 'fondant';
    if(arr.includes('Semi-naked Style')) return 'seminaked';
    const s=arr.includes('Smooth Buttercream'), t=arr.includes('Textured Buttercream');
    if(s&&t) return 'smoothandtextured';
    if(t)    return 'textured';
    return 'smooth';
}
function getNumberBaseFileName(digit, frostingsArr){
    // Base sponge/shape file. Loads the semi-naked variant when Semi-naked Style
    // is the active cake style — mirrors base_seminaked_{shape}.glb for other shapes.
    if(frostingsArr && frostingsArr.includes('Semi-naked Style')) return `seminaked_${digit}`;
    return `number_${digit}`;
}
function getNumberFrostFileName(digit, frostingsArr){
    // Shell Border (Smooth Buttercream) overlay, layered ON TOP of the base —
    // the number-shape equivalent of frosting_round_smooth.glb.
    // Only Smooth Buttercream has a dedicated per-digit export so far.
    if(frostingsArr.includes('Smooth Buttercream')) return `number${digit}_smoothbc`;
    return null;
}
function getNumberTextureFileName(digit, frostingsArr){
    // Textured Buttercream overlay — layered ON TOP of the base (and on top of the
    // Shell Border overlay if that's also active), never replaces the base model.
    if(frostingsArr.includes('Textured Buttercream')) return `number${digit}textured`;
    return null;
}
function getNumberDripFileName(digit){
    // Drip overlay — dedicated per-digit export (e.g. drip0.glb), layered ON TOP of the base.
    return `drip${digit}`;
}
function shouldLoadFrostingGLB(arr){
    return arr.some(f=>f!=='Sugar Icing'&&f!=='Drip');
}
function isFondantOnly(arr){ return arr.includes('Fondant Smooth'); }

const FLAVORS={
  'Vanilla':   {sponge:{hex:'#C8822A',roughness:.82,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#9A5A14',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#F5E6B8',roughness:.46,metalness:.02,envMapIntensity:.65},top:{hex:'#FBF0CE',roughness:.36,metalness:.03,envMapIntensity:.72},drip:{hex:'#E8D9A0',roughness:.14,metalness:.04}},
    'Chocolate': {sponge:{hex:'#361004',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#200802',roughness:.92,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#5A1E0E',roughness:.38,metalness:.06,envMapIntensity:.70},top:{hex:'#6C2610',roughness:.30,metalness:.08,envMapIntensity:.78},drip:{hex:'#320E06',roughness:.10,metalness:.10}},
   'Red Velvet':{sponge:{hex:'#880E0E',roughness:.84,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#680606',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#F7DCE0',roughness:.36,metalness:.01,envMapIntensity:.70},top:{hex:'#FFF6F2',roughness:.28,metalness:.01,envMapIntensity:.78},drip:{hex:'#BE0E0E',roughness:.14,metalness:.02}},
    'Strawberry':{sponge:{hex:'#CC2454',roughness:.82,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#A4163C',roughness:.86,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#FF4474',roughness:.40,metalness:.01,envMapIntensity:.62},top:{hex:'#FF5680',roughness:.32,metalness:.01,envMapIntensity:.70},drip:{hex:'#DE2454',roughness:.12,metalness:.02}},
    'Ube':       {sponge:{hex:'#481C7C',roughness:.84,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#301260',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#8638C8',roughness:.38,metalness:.04,envMapIntensity:.68},top:{hex:'#9644D6',roughness:.30,metalness:.05,envMapIntensity:.76},drip:{hex:'#5E24AC',roughness:.12,metalness:.05}},
   'Mocha':     {sponge:{hex:'#220E00',roughness:.88,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#140600',roughness:.92,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#7A451E',roughness:.38,metalness:.06,envMapIntensity:.66},top:{hex:'#8A4F24',roughness:.30,metalness:.07,envMapIntensity:.74},drip:{hex:'#582C0E',roughness:.12,metalness:.07}},
 'Mango':     {sponge:{hex:'#F5B818',roughness:.82,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#D4900C',roughness:.86,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#FFC01E',roughness:.40,metalness:.01,envMapIntensity:.68},top:{hex:'#FFD24C',roughness:.32,metalness:.01,envMapIntensity:.76},drip:{hex:'#F0A008',roughness:.12,metalness:.02}},
  'Biscoff':   {sponge:{hex:'#C8682A',roughness:.86,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#A04E18',roughness:.90,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#D4844A',roughness:.42,metalness:.03,envMapIntensity:.64},top:{hex:'#E09060',roughness:.34,metalness:.03,envMapIntensity:.72},drip:{hex:'#8A3A10',roughness:.14,metalness:.04}},
    'Blueberry': {sponge:{hex:'#2E3E7A',roughness:.83,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#20295E',roughness:.87,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#B8C4E8',roughness:.40,metalness:.02,envMapIntensity:.66},top:{hex:'#C8D2F0',roughness:.32,metalness:.02,envMapIntensity:.74},drip:{hex:'#3A1878',roughness:.12,metalness:.04}},
    'Carrot':    {sponge:{hex:'#B8631E',roughness:.85,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#8E4A12',roughness:.89,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#F5EAD0',roughness:.40,metalness:.01,envMapIntensity:.66},top:{hex:'#FBF4E2',roughness:.32,metalness:.01,envMapIntensity:.74},drip:{hex:'#A0611C',roughness:.13,metalness:.03}},
    'Banana':    {sponge:{hex:'#E8D078',roughness:.83,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#C8A84C',roughness:.87,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#F7EEC8',roughness:.42,metalness:.01,envMapIntensity:.64},top:{hex:'#FDF8E4',roughness:.34,metalness:.01,envMapIntensity:.72},drip:{hex:'#D8B858',roughness:.14,metalness:.03}},
   'Blueberry Cheesecake': {sponge:{hex:'#F0EAD8',roughness:.70,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#C8B888',roughness:.80,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#E8E0F0',roughness:.36,metalness:.02,envMapIntensity:.68},top:{hex:'#F4EEFA',roughness:.28,metalness:.02,envMapIntensity:.76},drip:{hex:'#4A2E78',roughness:.12,metalness:.04}},
    'Strawberry Cheesecake': {sponge:{hex:'#F0E4D0',roughness:.68,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#D8B888',roughness:.78,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#FCDCE4',roughness:.36,metalness:.01,envMapIntensity:.68},top:{hex:'#FFEAF0',roughness:.28,metalness:.01,envMapIntensity:.76},drip:{hex:'#D8395E',roughness:.12,metalness:.02}},
    'Mango Cheesecake':      {sponge:{hex:'#F0E4C8',roughness:.68,metalness:.0,emissive:'#000000',emissiveIntensity:.0},crust:{hex:'#D8B868',roughness:.78,metalness:.0,emissive:'#000000',emissiveIntensity:.0},frosting:{hex:'#FCE8B8',roughness:.36,metalness:.01,envMapIntensity:.68},top:{hex:'#FFF2D0',roughness:.28,metalness:.01,envMapIntensity:.76},drip:{hex:'#F0A020',roughness:.12,metalness:.02}},
};
const DRIP_FLAVOR_COLORS={
    'Vanilla':'#ECBC28','Chocolate':'#320E06','Red Velvet':'#BE0E0E',
    'Strawberry':'#DE2454','Ube':'#5E24AC','Mocha':'#582C0E',
    'Caramel':'#D08010','White Chocolate':'#F8EED8',
    'Mango':'#F5A020','Salted Caramel':'#A0620A',
    'Blueberry':'#3A1878','Raspberry':'#C01858',
};
const FONDANT_FLAVOR_COLORS={
    'Vanilla':   '#F5EFDC',
    'Chocolate': '#6B4226',
    'Red Velvet':'#F6EEEA',
    'Strawberry':'#FADDE1',
    'Ube':       '#C9A6E8',
    'Mocha':     '#D8C3A5',
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
'Semi-naked Style':    {roughness:.85,metalness:.00,envBoost:-.08,opacity:1.0},
    'Ombre Style':         {roughness:.68,metalness:.01,envBoost:.02},
    'Sugar Icing':         {roughness:.14,metalness:.02,envBoost:.34},
};
function disposeMaterial(mat){
    if(!mat) return;
    ['map','normalMap','roughnessMap','aoMap','metalnessMap','emissiveMap'].forEach(k=>{
        if(mat[k]) mat[k].dispose();
    });
    mat.dispose();
}
function applyGLBMaterial(group,colorHex,roughness,metalness,opacity,envMapIntensity,emissiveHex='#000'){
    group.traverse(child=>{
        if(!child.isMesh) return;
        disposeMaterial(child.material); // ← added: free the old material/textures first
        child.material=new THREE.MeshStandardMaterial({
            color:new THREE.Color(colorHex), roughness, metalness,
            transparent:opacity<1.0, opacity, envMapIntensity:envMapIntensity??0.6,
            emissive:new THREE.Color(emissiveHex), emissiveIntensity:.05
        });
        child.castShadow=child.receiveShadow=true;
    });
}
// ── Slowly "reveals" a GLB group with a rising clip-plane wipe, so it looks
// like the icing is being spread/piped on from the base upward instead of
// popping in instantly. Uses THREE's local clipping planes — works on any
// mesh regardless of its material, and cleans itself up when done. ──
function revealIcingWithWipe(group, duration){
    if(!group) return;
    duration = duration || 1800;
    renderer.localClippingEnabled = true;
    group.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(group);
    const topY = box.max.y, botY = box.min.y;
    const pad = Math.max(0.01, (topY - botY) * 0.06);
    const meshes = [];
    group.traverse(c=>{ if(c.isMesh) meshes.push(c); });
    if(meshes.length === 0) return;

    const clipPlane = new THREE.Plane(new THREE.Vector3(0,-1,0), botY - pad);
    meshes.forEach(m=>{
        const mats = Array.isArray(m.material) ? m.material : [m.material];
        mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = [clipPlane]; mm.needsUpdate = true; } });
    });

    const startTime = performance.now();
    function frame(now){
        const t = Math.min(1, (now - startTime) / duration);
        const eased = t < 0.5 ? 2*t*t : 1 - Math.pow(-2*t + 2, 2) / 2; // easeInOutQuad
        clipPlane.constant = (botY - pad) + ((topY + pad) - (botY - pad)) * eased;
        if(t < 1){
            requestAnimationFrame(frame);
        } else {
            meshes.forEach(m=>{
                const mats = Array.isArray(m.material) ? m.material : [m.material];
                mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = []; mm.needsUpdate = true; } });
            });
        }
    }
    requestAnimationFrame(frame);
}
window._triggerIcingReveal = function(duration){ revealIcingWithWipe(currentIcing, duration); };
// Synchronously clips a GLB group down to fully hidden — called the instant the
// icing mesh is created/colored, in the same tick, so it never renders fully
// visible even for a single frame before the reveal animation takes over.
function hideGroupInstantly(group){
    if(!group) return;
    renderer.localClippingEnabled = true;
    group.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(group);
    const pad = Math.max(0.01, (box.max.y - box.min.y) * 0.06);
    const clipPlane = new THREE.Plane(new THREE.Vector3(0,-1,0), box.min.y - pad);
    group.traverse(c=>{
        if(!c.isMesh) return;
        const mats = Array.isArray(c.material) ? c.material : [c.material];
        mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = [clipPlane]; mm.needsUpdate = true; } });
    });
}
// ── Shell Border "piping" reveal — sweeps the border ring into view like it's
// being piped around the cake in a circle, using a per-fragment angle discard
// (via onBeforeCompile) instead of a flat clip plane, so it can sweep a full
// 360° smoothly (a plain clip plane can't do more than a 180° half-reveal). ──
function revealShellCircular(group, duration){
    if(!group) return;
    duration = duration || 2200;
    const meshes = [];
    group.traverse(c=>{ if(c.isMesh) meshes.push(c); });
    if(meshes.length === 0) return;

    meshes.forEach(mesh=>{
        if(!mesh.geometry.boundingBox) mesh.geometry.computeBoundingBox();
        const bb = mesh.geometry.boundingBox;
        const cx = (bb.min.x + bb.max.x) * 0.5;
        const cz = (bb.min.z + bb.max.z) * 0.5;
        const mats = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
             mats.forEach(mat=>{
            if(!mat) return;
            mat.clippingPlanes = []; // clear any full-hide plane left by hideGroupInstantly
            mat.onBeforeCompile = (shader)=>{
                shader.uniforms.uCenterXZ   = { value: new THREE.Vector2(cx, cz) };
                shader.uniforms.uSweepAngle = { value: 0.0001 }; // starts fully hidden
                shader.vertexShader = shader.vertexShader
                    .replace('#include <common>', '#include <common>\nvarying vec3 vIcingLocalPos;')
                    .replace('#include <begin_vertex>', '#include <begin_vertex>\nvIcingLocalPos = position;');
                shader.fragmentShader = shader.fragmentShader
                    .replace('#include <common>', '#include <common>\nvarying vec3 vIcingLocalPos;\nuniform vec2 uCenterXZ;\nuniform float uSweepAngle;')
                    .replace('#include <clipping_planes_fragment>', `
                        vec2 icingRel = vIcingLocalPos.xz - uCenterXZ;
                        float icingAng = atan(icingRel.y, icingRel.x);
                        if(icingAng < 0.0) icingAng += 6.283185307179586;
                        if(icingAng > uSweepAngle) discard;
                        #include <clipping_planes_fragment>`);
                mat.userData.icingShader = shader;
            };
            mat.needsUpdate = true;
        });
    });

    const startTime = performance.now();
    function frame(now){
        const t = Math.min(1, (now - startTime) / duration);
        const eased = t < 0.5 ? 2*t*t : 1 - Math.pow(-2*t + 2, 2) / 2;
        const angle = eased * Math.PI * 2 + 0.02;
        meshes.forEach(mesh=>{
            const mats = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
            mats.forEach(mat=>{
                if(mat && mat.userData.icingShader){
                    mat.userData.icingShader.uniforms.uSweepAngle.value = angle;
                }
            });
        });
        if(t < 1){
            requestAnimationFrame(frame);
        } else {
            meshes.forEach(mesh=>{
                const mats = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
                mats.forEach(mat=>{ if(mat){ mat.onBeforeCompile = ()=>{}; mat.needsUpdate = true; } });
            });
        }
    }
    requestAnimationFrame(frame);
}
window._triggerShellReveal = function(duration){ revealShellCircular(currentFrost, duration); };
// Used for the initial default Shell Border, e.g. right after the tutorial
// closes — hides the already-loaded frost mesh instantly then sweeps it back
// in, since by that point the model finished loading long before any reveal
// flag was set (the normal load-hook path never fires for it).
window._triggerShellHideAndReveal = function(duration){
    if(!currentFrost) return false;
    hideGroupInstantly(currentFrost);
    revealShellCircular(currentFrost, duration || 2200);
    return true;
};
// ── Fondant "draping" reveal — sweeps a horizontal clip plane DOWN from the
// top of the cake to the bottom, so the fondant skin appears to be draped
// over the cake and smoothed downward into place, instead of popping in. ──
function revealFondantDrape(group, duration){
    if(!group) return;
    duration = duration || 2400;
    renderer.localClippingEnabled = true;
    group.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(group);
    const topY = box.max.y, botY = box.min.y;
    const pad = Math.max(0.01, (topY - botY) * 0.06);
    const meshes = [];
    group.traverse(c=>{ if(c.isMesh) meshes.push(c); });
    if(meshes.length === 0) return;

    // Normal points UP; keep condition is y >= -constant. Starting constant
    // hides everything (threshold above the top), ending constant reveals
    // everything (threshold below the bottom) — draping top-to-bottom.
    const startConstant = -(topY + pad);
    const endConstant   = -(botY - pad);
    const clipPlane = new THREE.Plane(new THREE.Vector3(0,1,0), startConstant);
    meshes.forEach(m=>{
        const mats = Array.isArray(m.material) ? m.material : [m.material];
        mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = [clipPlane]; mm.needsUpdate = true; } });
    });

    const startTime = performance.now();
    function frame(now){
        const t = Math.min(1, (now - startTime) / duration);
        const eased = t < 0.5 ? 2*t*t : 1 - Math.pow(-2*t + 2, 2) / 2; // easeInOutQuad
        clipPlane.constant = startConstant + (endConstant - startConstant) * eased;
        if(t < 1){
            requestAnimationFrame(frame);
        } else {
            meshes.forEach(m=>{
                const mats = Array.isArray(m.material) ? m.material : [m.material];
                mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = []; mm.needsUpdate = true; } });
            });
        }
    }
    requestAnimationFrame(frame);
}
window._triggerFondantReveal = function(duration){ revealFondantDrape(currentFrost, duration); };
window._triggerFondantHideAndReveal = function(duration){
    if(!currentFrost) return false;
    hideGroupInstantly(currentFrost);
    revealFondantDrape(currentFrost, duration || 2400);
    return true;
};
// ── Drip "piping bag" reveal — sweeps top-to-bottom just like fondant drape,
// which reads as the drip being squeezed out at the top and running down.
function revealDripFlow(group, duration){
    if(!group) return;
    duration = duration || 1600;
    renderer.localClippingEnabled = true;
    group.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(group);
    const topY = box.max.y, botY = box.min.y;
    const pad = Math.max(0.01, (topY - botY) * 0.06);
    const meshes = [];
    group.traverse(c=>{ if(c.isMesh) meshes.push(c); });
    if(meshes.length === 0) return;

    const startConstant = -(topY + pad);
    const endConstant   = -(botY - pad);
    const clipPlane = new THREE.Plane(new THREE.Vector3(0,1,0), startConstant);
    meshes.forEach(m=>{
        const mats = Array.isArray(m.material) ? m.material : [m.material];
        mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = [clipPlane]; mm.needsUpdate = true; } });
    });

    const startTime = performance.now();
    function frame(now){
        const t = Math.min(1, (now - startTime) / duration);
        const eased = t < 0.5 ? 2*t*t : 1 - Math.pow(-2*t + 2, 2) / 2;
        clipPlane.constant = startConstant + (endConstant - startConstant) * eased;
        if(typeof window._requestRender==='function') window._requestRender(200);
        if(t < 1){
            requestAnimationFrame(frame);
        } else {
            meshes.forEach(m=>{
                const mats = Array.isArray(m.material) ? m.material : [m.material];
                mats.forEach(mm=>{ if(mm){ mm.clippingPlanes = []; mm.needsUpdate = true; } });
            });
        }
    }
    requestAnimationFrame(frame);
}
window._triggerDripReveal = function(duration){ revealDripFlow(currentDrip, duration); };
// ── Choco Curls "shredding" reveal — each fragment gets a random hash value;
// as the threshold rises from 0 to 1, curls appear to scatter/settle into
// place piece by piece, like shavings being shredded onto the cake, instead
// of popping in all at once. ──
function revealChocoCurlsShred(pieces, duration){
    duration = duration || 1400;
    if(!pieces || !pieces.length) return;
    const meshes = [];
    pieces.forEach(obj => { if(obj) obj.traverse(c=>{ if(c.isMesh) meshes.push(c); }); });
    if(meshes.length === 0) return;

    meshes.forEach(mesh=>{
        const mats = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
        mats.forEach(mat=>{
            if(!mat) return;
            mat.clippingPlanes = [];
            mat.onBeforeCompile = (shader)=>{
                shader.uniforms.uShredThreshold = { value: 0.0 };
                shader.vertexShader = shader.vertexShader
                    .replace('#include <common>', '#include <common>\nvarying vec3 vShredPos;')
                    .replace('#include <begin_vertex>', '#include <begin_vertex>\nvShredPos = position;');
                shader.fragmentShader = shader.fragmentShader
                    .replace('#include <common>', '#include <common>\nvarying vec3 vShredPos;\nuniform float uShredThreshold;')
                    .replace('#include <clipping_planes_fragment>', `
                        float shredHash = fract(sin(dot(vShredPos.xyz, vec3(12.9898,78.233,45.164))) * 43758.5453);
                        if(shredHash > uShredThreshold) discard;
                        #include <clipping_planes_fragment>`);
                mat.userData.shredShader = shader;
            };
            mat.needsUpdate = true;
        });
    });

    const startTime = performance.now();
    function frame(now){
        const t = Math.min(1, (now - startTime) / duration);
        const eased = t < 0.5 ? 2*t*t : 1 - Math.pow(-2*t + 2, 2) / 2;
        const threshold = eased + 0.03; // slight overshoot so the last fragments aren't left stranded
        meshes.forEach(mesh=>{
            const mats = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
            mats.forEach(mat=>{
                if(mat && mat.userData.shredShader){
                    mat.userData.shredShader.uniforms.uShredThreshold.value = threshold;
                }
            });
        });
        if(typeof window._requestRender==='function') window._requestRender(200);
        if(t < 1){
            requestAnimationFrame(frame);
        } else {
            meshes.forEach(mesh=>{
                const mats = Array.isArray(mesh.material) ? mesh.material : [mesh.material];
                mats.forEach(mat=>{ if(mat){ mat.onBeforeCompile = ()=>{}; mat.needsUpdate = true; } });
            });
        }
    }
    requestAnimationFrame(frame);
}
window._triggerChocoCurlsShred = function(duration){ revealChocoCurlsShred(currentChocoCurls, duration); };
// Same as applyGLBMaterial but preserves any texture maps already baked into the GLB
// (map / normalMap / roughnessMap / aoMap) — needed for models like Bundt whose
// rippled surface detail comes from a normal map, not just geometry.
function applyGLBMaterialKeepMaps(group,colorHex,roughness,metalness,opacity,envMapIntensity,emissiveHex='#000'){
    group.traverse(child=>{
        if(!child.isMesh) return;
        const old = child.material;
        // Deliberately NOT keeping the baked diffuse "map" — it carries its own base
        // tone which was multiplying against colorHex and washing the Bundt out paler
        // than every other cake shape. Keeping only normalMap/roughnessMap preserves
        // the rippled bump detail while letting colorHex land exactly like it does
        // for every other frosting layer.
        const oldNormalMap    = old && old.normalMap    ? old.normalMap    : null;
        const oldRoughnessMap = old && old.roughnessMap ? old.roughnessMap : null;
        const oldNormalScale  = old && old.normalScale  ? old.normalScale.clone() : null;
        child.material=new THREE.MeshStandardMaterial({
            color:new THREE.Color(colorHex), roughness, metalness,
            transparent:opacity<1.0, opacity, envMapIntensity:envMapIntensity??0.6,
            emissive:new THREE.Color(emissiveHex), emissiveIntensity:.05,
            normalMap: oldNormalMap, roughnessMap: oldRoughnessMap,
        });
        if(oldNormalScale) child.material.normalScale.copy(oldNormalScale);
        child.material.needsUpdate = true;
        child.castShadow=child.receiveShadow=true;
    });
}
// Paints a real two-color vertical gradient onto a mesh using per-vertex colors,
// computed from each vertex's WORLD-space height — not UVs. This means it works
// Boosts saturation on a picked color and caps its lightness so it reads
// as a vivid, recognizable color under the warm stage lighting instead of
// washing out pale. Leaves white/near-neutral colors (like the default
// White rosette) untouched so they don't pick up an unwanted tint.
function boostRosetteColor(hexColor){
    const c = new THREE.Color(hexColor);
    const hsl = {h:0,s:0,l:0};
    c.getHSL(hsl);
    if(hsl.s < 0.04) return hexColor;
    const boostedS = Math.min(1, hsl.s * 1.35 + 0.08);
    const cappedL  = Math.min(hsl.l, 0.58);
    c.setHSL(hsl.h, boostedS, cappedL);
    return '#' + c.getHexString();
}
// ── Ombre texture maps — procedural horizontal "comb" ridges, like a cake
// scraper dragged around the buttercream. Cached once and reused. ──
function makeOmbreTextureNormalMap(size = 256){
    const canvas = document.createElement('canvas');
    canvas.width = canvas.height = size;
    const ctx = canvas.getContext('2d');
    const imgData = ctx.createImageData(size, size);
    const d = imgData.data;
    const ridgeCount = 22; // number of horizontal comb ridges around the cake
    for(let y=0;y<size;y++){
        const fy = y / size;
        const ridgePos = fy * ridgeCount;
        const ridgePhase = ridgePos - Math.floor(ridgePos);
        const ridgeShape = Math.sin(ridgePhase * Math.PI); // 0 → 1 → 0 per ridge band
        for(let x=0;x<size;x++){
            const i = (y*size+x)*4;
            // slight wobble so ridges read as hand-combed, not perfectly mechanical
            const wobble = Math.sin(x*0.15 + y*0.4)*0.15 + Math.sin(x*0.05)*0.08;
            const strength = Math.max(0, Math.min(1, ridgeShape + wobble));
            const nx = 128;
            const ny = Math.max(0, Math.min(255, 128 + (strength-0.5)*60));
            const nz = Math.max(0, Math.min(255, 200 + strength*50));
            d[i]=nx; d[i+1]=ny; d[i+2]=nz; d[i+3]=255;
        }
    }
    ctx.putImageData(imgData,0,0);
    const tex = new THREE.CanvasTexture(canvas);
    tex.wrapS = tex.wrapT = THREE.RepeatWrapping;
    tex.repeat.set(4,3);
    return tex;
}
function makeOmbreTextureRoughnessMap(size = 256){
    const canvas = document.createElement('canvas');
    canvas.width = canvas.height = size;
    const ctx = canvas.getContext('2d');
    const imgData = ctx.createImageData(size, size);
    const d = imgData.data;
    const ridgeCount = 22;
    for(let y=0;y<size;y++){
        const fy = y / size;
        const ridgePos = fy * ridgeCount;
        const ridgePhase = ridgePos - Math.floor(ridgePos);
        const ridgeShape = Math.sin(ridgePhase * Math.PI);
        for(let x=0;x<size;x++){
            const i = (y*size+x)*4;
            const val = Math.round(140 + ridgeShape*90 + (Math.random()-0.5)*10);
            const c = Math.max(0, Math.min(255, val));
            d[i]=c; d[i+1]=c; d[i+2]=c; d[i+3]=255;
        }
    }
    ctx.putImageData(imgData,0,0);
    const tex = new THREE.CanvasTexture(canvas);
    tex.wrapS = tex.wrapT = THREE.RepeatWrapping;
    tex.repeat.set(4,3);
    return tex;
}
function getOmbreTextureMaps(){
    if(!window._ombreTextureMapsCache){
        window._ombreTextureMapsCache = {
            normal: makeOmbreTextureNormalMap(),
            rough:  makeOmbreTextureRoughnessMap(),
        };
    }
    return window._ombreTextureMapsCache;
}
function applyOmbreGradient(group, topHex, bottomHex, roughness, metalness, opacity, envMapIntensity){
    group.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(group);
    const minY = box.min.y, maxY = box.max.y;
    const spanY = Math.max(0.0001, maxY - minY);
    const cTop = new THREE.Color(topHex);
    const cBottom = new THREE.Color(bottomHex);
    const worldPos = new THREE.Vector3();
    const hsl = {h:0,s:0,l:0};
    const ombreMaps = getOmbreTextureMaps();
    group.traverse(child=>{
        if(!child.isMesh) return;
        const geo = child.geometry;
        const posAttr = geo.attributes.position;
        const count = posAttr.count;
        const colors = new Float32Array(count*3);
        for(let i=0;i<count;i++){
            worldPos.set(posAttr.getX(i), posAttr.getY(i), posAttr.getZ(i));
            child.localToWorld(worldPos);
                   let t = (worldPos.y - minY) / spanY;
            t = Math.max(0, Math.min(1, t));
            // Full-height smoothstep blend — a continuous gradient from bottom to
            // top color across the ENTIRE cake, like a soft dip-dyed buttercream
            // (see reference photo), instead of two flat solid bands with only a
            // thin transition strip squeezed into the middle.
            const tCurve = t*t*(3-2*t);
            const c = cBottom.clone().lerp(cTop, tCurve);
            // Boost saturation and cap lightness — the scene's warm spotlights wash
            // pastel/cool tones toward beige-white on rough diffuse surfaces, so
            // raw picked colors read as barely-there. Punching saturation up and
            // pulling lightness down slightly keeps the chosen color recognizable.
            c.getHSL(hsl);
            const boostedS = Math.min(1, hsl.s * 1.55 + 0.10);
            const cappedL  = Math.min(hsl.l, 0.62);
            c.setHSL(hsl.h, boostedS, cappedL);
            colors[i*3]=c.r; colors[i*3+1]=c.g; colors[i*3+2]=c.b;
        }
        geo.setAttribute('color', new THREE.BufferAttribute(colors,3));
        child.material = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            vertexColors: true,
            roughness: Math.max(roughness, 0.68),
            metalness,
            transparent: opacity<1.0, opacity,
            envMapIntensity: envMapIntensity??0.6,
            normalMap: ombreMaps.normal,
            normalScale: new THREE.Vector2(0.55, 0.55),
            roughnessMap: ombreMaps.rough,
        });
        child.material.needsUpdate = true;
        child.castShadow = child.receiveShadow = true;
    });
}
function recolorGLB(flavorName,frostingsArr,dripFlavor,icingColorHex,ombreTopColor,ombreBottomColor){
    flavorName = flavorName || 'Vanilla'; // safety fallback
    const pal=FLAVORS[flavorName]||FLAVORS['Vanilla'];
    const hasTextured  =frostingsArr.includes('Textured Buttercream');
    const hasSmooth    =frostingsArr.includes('Smooth Buttercream');
    const hasSemiNakedR=frostingsArr.includes('Semi-naked Style');
    const styleName    =hasSemiNakedR?'Semi-naked Style':hasTextured?'Textured Buttercream':hasSmooth?'Smooth Buttercream':(frostingsArr.filter(f=>f!=='Sugar Icing')[0]||'Smooth Buttercream');
    const style      =FROSTING_STYLES[styleName]||FROSTING_STYLES['Smooth Buttercream'];
    const frostEnv   =Math.max(.20,(pal.top.envMapIntensity??0.6)+style.envBoost);
if(currentBase && !hasSemiNakedR && !frostingsArr.includes('Fondant Smooth')){
    const isOmbreActive = frostingsArr.includes('Ombre Style');
    if(_isBundtActive){
        // Bundt has no separate frosting-layer GLB — currentBase IS the whole visible
        // cake, so it must use the same crust/sponge color every other shape's base
        // uses (pal.crust.hex), not the pale frosting tint (pal.frosting.hex), or it
        // reads as a completely different color from the rest of the cakes.
      if(isOmbreActive){
            applyOmbreGradient(currentBase, ombreTopColor||'#F7A8C4', ombreBottomColor||'#8A6AC8', style.roughness, style.metalness, 1.0, frostEnv);
        } else {
            applyGLBMaterialKeepMaps(currentBase, pal.crust.hex, pal.crust.roughness, pal.crust.metalness??0, 1.0, .45, pal.sponge.emissive??'#000');
        }
  } else if(isOmbreActive){
        // The round/square/heart frosting GLB is only a piped BORDER ring — the
        // visible body of the cake is actually currentBase (crust). So for Ombre to
        // cover the whole cake (not just the top ring), the body must also be
        // painted with the same gradient, not the flat crust color.
        // Uses 'style'/'frostEnv' (the Ombre Style profile) instead of the very
        // matte pal.crust values — matte roughness (.88) was scattering light hard
        // under the warm stage lighting and washing the picked colors out to pale.
        applyOmbreGradient(currentBase, ombreTopColor||'#F7A8C4', ombreBottomColor||'#8A6AC8', style.roughness, style.metalness, 1.0, frostEnv);
    } else {
        applyGLBMaterial(currentBase,  pal.crust.hex, pal.crust.roughness, pal.crust.metalness??0, 1.0, .45, pal.sponge.emissive??'#000');
    }
}
if(currentBase && hasSemiNakedR && !frostingsArr.includes('Fondant Smooth')){
    const SEMI_NAKED_SPONGE={
        'Vanilla':   '#D4956A',
        'Chocolate': '#5C2A12',
        'Red Velvet':'#9B1B1B',
        'Strawberry':'#D4406A',
        'Ube':       '#5C2A8A',
        'Mocha':     '#3A1E0A',
    };
    const spongeTintHex = SEMI_NAKED_SPONGE[flavorName] || '#D4956A';
    currentBase.traverse(child=>{
        if(!child.isMesh) return;
        if(child.material){
            child.material = child.material.clone();
            child.material.color.set(new THREE.Color(spongeTintHex));
            child.material.needsUpdate = true;
        }
        child.castShadow    = true;
        child.receiveShadow = true;
    });
}
if(currentFrost && hasSemiNakedR){
    const useShellColor = hasSmooth && icingColorHex;
    const SHELL_BORDER_DEFAULT = '#F5EFE2';
    const frostTint = new THREE.Color(useShellColor ? (SUGAR_ICING_COLORS[icingColorHex] || icingColorHex) : SHELL_BORDER_DEFAULT);
    currentFrost.traverse(child=>{
        if(!child.isMesh) return;
        if(child.material){
            // Keep the existing texture map — just tint the color
            // Three.js multiplies: finalColor = color × texture
            child.material = child.material.clone();
            child.material.color.set(frostTint);
        } else {
            // Sphere meshes with no material — assign tinted material
            child.material = new THREE.MeshStandardMaterial({
                color: frostTint,
                roughness: 0.85,
                metalness: 0.0,
            });
        }
        child.castShadow    = true;
        child.receiveShadow = true;
    });
}
if(currentFrost && hasSemiNakedR && currentFrost.userData.keepOriginalTexture) { /* keep baked texture as-is */ }
else if(currentFrost && !hasSemiNakedR){
  if(frostingsArr.includes('Fondant Smooth')){
const fondantHex = pal.crust.hex;
  // ── Kill ALL spotlight shadows when fondant is active ──
    spotLights.forEach(s => { s.castShadow = false; });
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

function makeFondantNormalMap(pattern, size = 128) {
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

     function makeFondantRoughnessMap(variance, size = 128) {
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

    window._fondantTexCache = window._fondantTexCache || {};
const _fCacheKey = flavorName + '_' + profile.pattern;
if(!window._fondantTexCache[_fCacheKey]){
    window._fondantTexCache[_fCacheKey] = {
        normal: makeFondantNormalMap(profile.pattern),
        rough:  makeFondantRoughnessMap(profile.roughnessVariance),
    };
}
const normalMap    = window._fondantTexCache[_fCacheKey].normal;
const roughnessMap = window._fondantTexCache[_fCacheKey].rough;
child.material = new THREE.MeshStandardMaterial({
            color:             new THREE.Color(fondantHex),
            roughness:         0.35,
            metalness:         0.00,
            envMapIntensity:   0.55,
            normalMap:         normalMap,
            normalScale:       new THREE.Vector2(profile.normalStrength * 2.5, profile.normalStrength * 2.5),
            roughnessMap:      roughnessMap,
            emissive:          new THREE.Color(0x000000),
            emissiveIntensity: 0.0,
        });
        child.material.envMap = null;
        child.material.needsUpdate = true;
        child.castShadow    = true;
        child.receiveShadow = true;
       return; // ← STOP HERE, skip all code below

});
if(window._pendingFondantReveal){
    window._pendingFondantReveal = false;
    hideGroupInstantly(currentFrost);
    requestAnimationFrame(()=>revealFondantDrape(currentFrost, 2400));
}
} else {
                 // Shell Border (Smooth Buttercream) has its own independent color —
            // it no longer follows the flavor at all. It uses the user-picked
            // color if one was chosen, otherwise a fixed neutral default that
            // never changes when the flavor changes.
       const isNakedOrOmbre = frostingsArr.includes('Ombre Style');
            const useShellColor  = hasSmooth && !isNakedOrOmbre && icingColorHex;
            const SHELL_BORDER_DEFAULT = '#F5EFE2';
                       const frostColorHex  = useShellColor ? (SUGAR_ICING_COLORS[icingColorHex] || icingColorHex) : SHELL_BORDER_DEFAULT;
            applyGLBMaterial(currentFrost, frostColorHex, style.roughness, style.metalness, style.opacity??1.0, frostEnv);
            if(window._pendingShellReveal) hideGroupInstantly(currentFrost);
        }
    }
 if(currentIcing){
        const icingRich = SUGAR_ICING_COLORS[icingColorHex] || icingColorHex || '#F8F6F2';
        // Always apply the selected icing color to ALL meshes — never tint with sponge/frosting colors
        applyGLBMaterial(currentIcing, icingRich, 0.12, 0.02, 1.0, 0.88);
        // Hide it immediately, same tick, so it never flashes fully visible
        // before the rising-wipe reveal animation starts a moment later.
        if(window._pendingIcingReveal) hideGroupInstantly(currentIcing);
    }
   if(currentDrip){
        applyGLBMaterial(currentDrip,  dripFlavor?(DRIP_FLAVOR_COLORS[dripFlavor]||pal.drip.hex):pal.drip.hex, pal.drip.roughness??0.10, pal.drip.metalness??0.05, 1.0, .80);
        if(window._pendingDripReveal) hideGroupInstantly(currentDrip);
    }
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
let loadedKey='', currentBase=null, currentFrost=null, currentDrip=null, currentIcing=null, currentTexture=null, currentRosette=null, currentCheesecakeCrust=null, currentChocoCurls=[], currentChocoCurlsPlacement=null, currentChocoCurlsTier='Single', currentChocoCurlsShape='Round';
let _isBundtActive=false;
let isLoading=false, pendingState=null;
const fruitModels=[];
const ferreroModels=[];
const kitkatModels=[];
const oreoModels=[];
function deepCloneObject3D(obj){
    const clone = obj.clone(true);
    // Object3D.clone() shares geometry/material BY REFERENCE across every clone of a
    // cached GLB. Mutating one clone's geometry (e.g. writing vertex colors for an
    // Ombre gradient) silently mutates every other instance ever cloned from that
    // same cached source. Deep-cloning geometry + material per instance here stops
    // that cross-contamination.
    clone.traverse(node=>{
        if(node.isMesh){
            node.geometry = node.geometry.clone();
            if(Array.isArray(node.material)) node.material = node.material.map(m=>m.clone());
            else if(node.material) node.material = node.material.clone();
        }
    });
    return clone;
}
function stripOutlierMeshes(group, label){
    const meshes = [];
    group.traverse(c => { if(c.isMesh) meshes.push(c); });
    if(meshes.length <= 1) return;

    group.updateMatrixWorld(true);
    const infos = meshes.map(m => {
        const box = new THREE.Box3().setFromObject(m);
        const size = box.getSize(new THREE.Vector3());
        return { mesh: m, size };
    });

    const horiz = infos.map(i => Math.max(i.size.x, i.size.z)).sort((a,b)=>a-b);
    const medianHoriz = horiz[Math.floor(horiz.length/2)] || 1;

    infos.forEach(info => {
        const tallRatio = info.size.y / Math.max(medianHoriz, 0.0001);
        const tinyFootprint = Math.max(info.size.x, info.size.z) < medianHoriz * 0.4;
        if(tallRatio > 4 || (info.size.y > medianHoriz * 3 && tinyFootprint)){
            console.warn(`[GLB cleanup] Removing outlier mesh "${info.mesh.name}" in ${label} — size:`, info.size);
            if(info.mesh.parent) info.mesh.parent.remove(info.mesh);
        }
    });
}
// ── Warm the GLB cache for rosette pieces in the background, before the user
// actually selects one. Fires and forgets — doesn't block anything, just
// makes the eventual real load feel instant since it'll already be cached.
function prefetchRosetteModels(shape){
    const slug = shape === 'Two-tier Round' ? 'two-tier' : shape === 'Three-tier Round' ? 'three-tier' : (SHAPE_SLUG[shape]||'round');
    if(slug === 'bundt' || shape === 'Number') return; // no rosettes for these
    const fileMap = getRosetteFileMap(slug);
    Object.values(fileMap).forEach(file=>{
        const url = `/models/${file}.glb`;
        if(!glbCache[url]){
            loadGLB(url).catch(()=>{}); // silent — real load will retry/log if it actually fails
        }
    });
}
window._prefetchRosetteModels = prefetchRosetteModels;
function buildFullPreloadQueue(){
    const urls = new Set();
    // Only the currently-selected shape's rosette set — not every shape.
    if (typeof state !== 'undefined') {
        const slug = state.shape === 'Round' && state.tier === 'Two-tier' ? 'two-tier'
                   : state.shape === 'Round' && state.tier === 'Three-tier' ? 'three-tier'
                   : (SHAPE_SLUG[state.shape] || 'round');
        if (slug !== 'bundt' && state.shape !== 'Number') {
            Object.values(getRosetteFileMap(slug)).forEach(file=>urls.add(`/models/${file}.glb`));
        }
    }
    // Small, cheap, and used by the majority of customers regardless of choices.
    ['ferrero','kitkat','oreo_cookie','Toblerone','flame'].forEach(f=>urls.add(`/models/${f}.glb`));
    ['Strawberry','Blueberry','Raspberry','Cherry','kiwi','banana'].forEach(f=>urls.add(`/models/${f}.glb`));
    return Array.from(urls);
}
function preloadAllDecorationAssets(){
    const queue = buildFullPreloadQueue();
    let i = 0;
    const BATCH = 3; // a few in flight at once — enough to saturate the connection without flooding it
    function runBatch(){
        if(i >= queue.length) return;
        const slice = queue.slice(i, i+BATCH);
        i += BATCH;
        slice.forEach(url=>{
            if(!glbCache[url]) loadGLB(url).catch(()=>{}); // silent — missing files just won't warm the cache
        });
        const schedule = window.requestIdleCallback || (fn=>setTimeout(fn, 120));
        schedule(runBatch);
    }
    runBatch();
}
window._preloadAllDecorationAssets = preloadAllDecorationAssets;
const glbLoadingPromises = {};
function loadGLB(url){
    if(glbCache[url]) return Promise.resolve(deepCloneObject3D(glbCache[url]));
    if(glbLoadingPromises[url]) return glbLoadingPromises[url].then(scene=>deepCloneObject3D(scene));
    const p = new Promise((resolve,reject)=>{
        new GLTFLoader().load(url, gltf=>{
            stripOutlierMeshes(gltf.scene, url);
            glbCache[url]=gltf.scene;
            delete glbLoadingPromises[url];
            resolve(gltf.scene);
        },
            xhr=>{if(xhr.total>0)loadingTx.textContent=`Loading… ${Math.round(xhr.loaded/xhr.total*100)}%`;},
            err=>{ delete glbLoadingPromises[url]; reject(err); });
    });
    glbLoadingPromises[url] = p;
    return p.then(scene=>deepCloneObject3D(scene));
}
function glbHasMesh(group){let f=false;group.traverse(c=>{if(c.isMesh)f=true;});return f;}

// Maps inch size to world-space diameter. 6" = 2.0 (baseline)
function inchesToWorldScale(inches){ return (inches / 6.0) * 2.0; }

function positionGroup(group, inches, heightMult){
    group.position.set(0,0,0); group.rotation.set(0,0,0); group.scale.set(1,1,1); group.updateMatrixWorld(true);
    const box=new THREE.Box3().setFromObject(group), size=box.getSize(new THREE.Vector3());
    const maxDim=Math.max(size.x,size.y,size.z); if(maxDim<0.0001) return;
    const hSize=Math.max(size.x,size.z);
    const targetDiameter = inchesToWorldScale(inches || 6);
    const scale=hSize>0.0001?targetDiameter/hSize:1.0;
    group.scale.set(scale, scale * (heightMult || 1.0), scale); group.updateMatrixWorld(true);
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

    // Scale EACH digit independently to the SAME footprint diameter a solo
    // digit uses — matching positionGroup()'s own single-digit target
    // (largest of X/Z, i.e. the horizontal footprint), NOT the vertical Y
    // height. Numeral cake meshes are mostly flat (small Y, large X/Z), so
    // targeting Y forced thin digits like "1"/"7" to scale up massively to
    // hit that height, blowing up X/Z right along with it since scale is
    // uniform. Targeting the same diameter every solo digit already uses
    // means each digit in a double-digit cake renders at EXACTLY solo size,
    // regardless of which two digits are picked — no more size mismatch.
    const DUAL_DIGIT_TARGET_DIAM = inchesToWorldScale(4.5) * 0.85;
    function scaleDigitToDiam(g){
        const b = new THREE.Box3().setFromObject(g);
        const hSize = Math.max(b.max.x-b.min.x, b.max.z-b.min.z);
        const s = hSize > 0.0001 ? DUAL_DIGIT_TARGET_DIAM / hSize : 1.0;
        g.scale.setScalar(s);
        g.updateMatrixWorld(true);
    }
    scaleDigitToDiam(gT);
    scaleDigitToDiam(gU);

    const bT=new THREE.Box3().setFromObject(gT), bU=new THREE.Box3().setFromObject(gU);
    const wT=bT.max.x-bT.min.x, wU=bU.max.x-bU.min.x;
    const gap=(wT+wU)*0.08, totalW=wT+gap+wU, startX=-totalW/2;
    gT.position.x=startX-bT.min.x; gU.position.x=startX+wT+gap-bU.min.x;
    gT.position.y=-bT.min.y; gU.position.y=-bU.min.y;
    gT.position.z=-(bT.min.z+(bT.max.z-bT.min.z)/2);
    gU.position.z=-(bU.min.z+(bU.max.z-bU.min.z)/2);
  wrapper.add(gT); wrapper.add(gU); wrapper.updateMatrixWorld(true);

    // Just center the wrapper at the origin and rest it on the floor —
    // NO further rescaling here, since each digit is already sized correctly.
    const wb = new THREE.Box3().setFromObject(wrapper);
    const wc = wb.getCenter(new THREE.Vector3());
    wrapper.position.set(-wc.x, -wb.min.y, -wc.z);
    wrapper.updateMatrixWorld(true);
    const wb2 = new THREE.Box3().setFromObject(wrapper);
    const midY2 = (wb2.min.y + wb2.max.y) * 0.5;
    wrapper.position.y -= midY2;
    wrapper.updateMatrixWorld(true);

    // Store the exact local placement used for the base digits so the icing digits
    // (loaded separately below) can reuse it instead of computing their own —
    // their bounding boxes can differ slightly from the base meshes, which was
    // pushing the icing out of alignment and making it appear to vanish.
    wrapper.userData.digitLocalPos = { T: gT.position.clone(), U: gU.position.clone() };
}
function clearScene(keepDecorations=false){
    invalidateCakeMeshesCache();
    while(sceneRoot.children.length) sceneRoot.remove(sceneRoot.children[0]);
   currentBase=currentFrost=currentDrip=currentIcing=currentTexture=currentRosette=currentCheesecakeCrust=null;
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
        if(typeof tobleroneModels!=='undefined'){
            tobleroneModels.forEach(m=>scene.remove(m.group));
            tobleroneModels.length=0;
        }
        candleModels.forEach(m=>{scene.remove(m.group);if(m.mixer){const mi=mixers.indexOf(m.mixer);if(mi>=0)mixers.splice(mi,1);}});
        candleModels.length=0;
    }
}
function addStandToScene(cakeGroup, extraSink=0){
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
    const lift = plateTopWorldY - cakeBottomY + 0.004 - extraSink;
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

// Builds a thin graham-cracker-style crust layer that hugs the cake's own
// footprint, so it automatically matches Round, Square, Heart, or tiered
// shapes without needing separate crust models per shape. Removes any
function updateCheesecakeCrust(cakeType){
    if(currentCheesecakeCrust){ sceneRoot.remove(currentCheesecakeCrust); currentCheesecakeCrust=null; }
    if(cakeType !== 'Cheesecake') return;
    const cakeRef = currentBase || currentFrost;
    if(!cakeRef || !glbHasMesh(cakeRef)) return;
    cakeRef.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(cakeRef);
    const fullHeight = box.max.y - box.min.y;
    if(fullHeight < 0.01) return;

    const crust = deepCloneObject3D(cakeRef);
    const CRUST_COLOR = '#7A4A22'; // richer, clearly-visible graham-cracker brown
    crust.traverse(c=>{
        if(!c.isMesh) return;
        c.material = new THREE.MeshStandardMaterial({
            color: new THREE.Color(CRUST_COLOR),
            roughness: 0.90, metalness: 0.0, envMapIntensity: 0.30,
            // Stops the flicker/glitch: the crust's side wall previously sat at
            // the exact same radius as the cake's own side wall, so the GPU
            // couldn't decide which surface was in front (z-fighting). Nudging
            // the crust's depth value fixes that without moving it visually.
            polygonOffset: true,
            polygonOffsetFactor: -4,
            polygonOffsetUnits: -4,
        });
        c.castShadow = c.receiveShadow = true;
    });

// Thin slice — ~10% of the cake's height, clamped to a sensible range so
    // it reads as a crust layer rather than a second tier.
    const desiredThickness = Math.max(0.05, Math.min(0.14, fullHeight * 0.10));
    const sY = desiredThickness / fullHeight;
    // Only a hair wider than the cake — just enough to avoid sitting exactly
    // on the same surface as the cake wall (which caused the flicker). Keep
    // this small or the crust reads as an oversized skirt around the base.
    const sXZ = 1.006;
    crust.scale.set(crust.scale.x * sXZ, crust.scale.y * sY, crust.scale.z * sXZ);
    crust.updateMatrixWorld(true);

    // Re-align: bottom flush with the cake's own bottom, re-centered on X/Z
    // (widening the XZ scale above shifts the bounding box off-center).
    const newBox = new THREE.Box3().setFromObject(crust);
    const cakeCenter = box.getCenter(new THREE.Vector3());
    const crustCenter = newBox.getCenter(new THREE.Vector3());
    crust.position.y += (box.min.y - newBox.min.y) + 0.002;
    crust.position.x += cakeCenter.x - crustCenter.x;
    crust.position.z += cakeCenter.z - crustCenter.z;
    crust.updateMatrixWorld(true);

    sceneRoot.add(crust);
    currentCheesecakeCrust = crust;
}

async function updateScene(state){
const {shape,flavor,frostings,hasDrip,dripFlavor,icingColor,ombreTopColor,ombreBottomColor,rosettePlacement,rosetteColor}=state;
    const frostingsArr=(frostings&&frostings.length>0)?frostings:['Smooth Buttercream'];
    const isNumber   =(shape==='Number');
    const isSugarIcing=frostingsArr.includes('Sugar Icing');
    const frostSuffix =getFrostingFileSuffix(frostingsArr);
    const needFrostGLB=shouldLoadFrostingGLB(frostingsArr);

  let newKey;
if(isNumber){
    const numStr=state.numberDigits===2?`${state.numberTens??1}_${state.numberUnits??0}`:`${state.numberChoice??0}`;
        const numStyleKey=frostingsArr.includes('Semi-naked Style')?'seminaked':(frostingsArr.includes('Smooth Buttercream')?'smoothbc':'plain');
        const numTexKey=frostingsArr.includes('Textured Buttercream')?'_tx':'_ntx';
            const numRosetteOnKey = frostingsArr.includes('Rosettes') && !frostingsArr.includes('Fondant Smooth');
        const numRosetteKey = numRosetteOnKey ? `_rosette_${(rosettePlacement||'Border').replace(/\s+/g,'')}_${rosetteColor||'ni'}` : '_norosette';
        newKey=`num_${numStr}_${flavor}_${needFrostGLB?frostSuffix:'nobc'}_${isSugarIcing?icingColor:'ni'}_${hasDrip?dripFlavor:'nd'}_${numStyleKey}${numTexKey}${numRosetteKey}`;
} else {
        const slug=SHAPE_SLUG[shape]||'round';
      const sizeKey=(shape==='Round')?`_${state.roundSize||6}in`:'';
const shellBorderKey = (frostingsArr.includes('Semi-naked Style') && frostingsArr.includes('Smooth Buttercream')) ? '_withshell' : '_noshell';
const _cakeStyleKey = frostingsArr.includes('Semi-naked Style') ? 'sn' : frostingsArr.includes('Fondant Smooth') ? 'fn' : 'bc';
const _texturedKey = frostingsArr.includes('Textured Buttercream') ? '_tx' : '_ntx';
const _rosetteOn  = frostingsArr.includes('Rosettes') && !frostingsArr.includes('Fondant Smooth');
const _rosetteKey = _rosetteOn ? `_rosette_${(rosettePlacement||'Border').replace(/\s+/g,'')}_${rosetteColor||'ni'}` : '_norosette';
newKey=`${slug}${sizeKey}_${flavor}_${_cakeStyleKey}_${needFrostGLB?frostSuffix:'nobc'}${shellBorderKey}${_texturedKey}_${isSugarIcing?icingColor:'ni'}_${hasDrip?dripFlavor:'nd'}${_rosetteKey}`;
    }
if(loadedKey===newKey&&sceneRoot.children.length>0){
recolorGLB(flavor,frostingsArr,dripFlavor,icingColor,ombreTopColor,ombreBottomColor);
    updateCheesecakeCrust(state.cakeType);
    if(typeof window._requestRender==='function') window._requestRender(3000);
    return;
}
// Force recolor even if key differs only by flavor for semi-naked
const prevKeyNoFlavor = loadedKey.replace(/_(Vanilla|Chocolate|Red Velvet|Strawberry|Ube|Mocha)_/, '_FLAVOR_');
const newKeyNoFlavor  = newKey.replace(/_(Vanilla|Chocolate|Red Velvet|Strawberry|Ube|Mocha)_/, '_FLAVOR_');
if(prevKeyNoFlavor===newKeyNoFlavor&&sceneRoot.children.length>0){
    loadedKey=newKey;
   recolorGLB(flavor,frostingsArr,dripFlavor,icingColor,ombreTopColor,ombreBottomColor);
    updateCheesecakeCrust(state.cakeType);
    if(typeof window._requestRender==='function') window._requestRender(3000);
    return;
}
    if(isLoading){pendingState=state;return;}
    isLoading=true; sceneRoot.visible=false;
    loadingEl.style.cssText='display:flex;opacity:1;'; loadingTx.textContent='Building 3D preview…'; statusEl.classList.add('hidden');

let usedGLB=false;
    try {

    if(isNumber){
        clearScene(true);
        try{
     if(state.numberDigits===2){
                const T=state.numberTens??1, U=state.numberUnits??0;
             const [rT,rU]=await Promise.allSettled([loadGLB(`/models/${getNumberBaseFileName(T, frostingsArr)}.glb`),loadGLB(`/models/${getNumberBaseFileName(U, frostingsArr)}.glb`)]);
                const gT=rT.status==='fulfilled'&&glbHasMesh(rT.value)?rT.value:null;
                const gU=rU.status==='fulfilled'&&glbHasMesh(rU.value)?rU.value:null;
                if(gT||gU){
                    const baseWrapper=new THREE.Group();
      if(gT&&gU) alignDualDigits(gT,gU,baseWrapper);
        else { baseWrapper.add(gT||gU); positionGroup(baseWrapper, 4.5, 1.0); }
sceneRoot.add(baseWrapper);
                    if(frostingsArr.includes('Fondant Smooth')){ currentFrost=baseWrapper; } else { currentBase=baseWrapper; }

                              const frostNameT = getNumberFrostFileName(T, frostingsArr);
                    const frostNameU = getNumberFrostFileName(U, frostingsArr);
                    if(frostNameT || frostNameU){
                        const [frT,frU]=await Promise.allSettled([
                            frostNameT?loadGLB(`/models/${frostNameT}.glb`):Promise.resolve(null),
                            frostNameU?loadGLB(`/models/${frostNameU}.glb`):Promise.resolve(null),
                        ]);
                        const fgT=frT.status==='fulfilled'&&frT.value&&glbHasMesh(frT.value)?frT.value:null;
                        const fgU=frU.status==='fulfilled'&&frU.value&&glbHasMesh(frU.value)?frU.value:null;
                        if(fgT||fgU){
                            const frostWrapper=new THREE.Group();
                                                   baseWrapper.updateMatrixWorld(true);
                            const baseDigitMeshes = baseWrapper.children; // [gT, gU] in original order
                            // Fit EACH digit's ring independently to its OWN base digit's
                            // diameter — same diameter-match + top-align approach the
                            // single-digit Shell Border path uses, instead of sharing one
                            // scale factor across both digits.
                            // Single-digit mode scales the WHOLE digit to a 4.5" target diameter
                            // (see positionGroup(baseGLB, 4.5, 1.0) in the single-digit branch),
                            // which comes out to inchesToWorldScale(4.5) world units. That's the
                            // size the "+0.07" nudge was originally tuned against. In dual-digit
                            // mode each digit only gets a FRACTION of that width (since two digits
                            // share it), so the nudge must shrink by the same fraction — not by
                            // the ring's own fit-scale (scaleD), which varies wildly per digit
                            // shape (e.g. thin "1" vs round "0") and was causing one digit's ring
                            // to float far more than the other's.
                            const SINGLE_DIGIT_REF_DIAM = inchesToWorldScale(4.5);
                            function fitDigitFrost(fg, baseDigitMesh){
                                if(!fg || !baseDigitMesh) return;
                                fg.position.set(0,0,0); fg.rotation.set(0,0,0); fg.scale.set(1,1,1);
                                fg.updateMatrixWorld(true);
                                const baseBoxD  = new THREE.Box3().setFromObject(baseDigitMesh);
                                const baseDiamD = Math.max(baseBoxD.max.x-baseBoxD.min.x, baseBoxD.max.z-baseBoxD.min.z);
                                const rawBoxD  = new THREE.Box3().setFromObject(fg);
                                const rawDiamD = Math.max(rawBoxD.max.x-rawBoxD.min.x, rawBoxD.max.z-rawBoxD.min.z);
                                const scaleD = rawDiamD > 0.0001 ? baseDiamD/rawDiamD : 1.0;
                                fg.scale.setScalar(scaleD);
                                fg.updateMatrixWorld(true);
                                const scaledBoxD = new THREE.Box3().setFromObject(fg);
                                const scaledCenterD = scaledBoxD.getCenter(new THREE.Vector3());
                                const baseCenterD = baseBoxD.getCenter(new THREE.Vector3());
                                const sizeRatio = SINGLE_DIGIT_REF_DIAM > 0.0001 ? (baseDiamD / SINGLE_DIGIT_REF_DIAM) : 1.0;
                                fg.position.set(
                                    baseCenterD.x - scaledCenterD.x,
                                    (baseBoxD.max.y - scaledBoxD.max.y) + (0.07 * sizeRatio),
                                    baseCenterD.z - scaledCenterD.z
                                );
                                fg.updateMatrixWorld(true);
                            }
                            fitDigitFrost(fgT, baseDigitMeshes[0]);
                            fitDigitFrost(fgU, baseDigitMeshes[1]);
                            if(fgT) frostWrapper.add(fgT);
                            if(fgU) frostWrapper.add(fgU);
                            sceneRoot.add(frostWrapper); currentFrost=frostWrapper;
                        }
                    }
             // ── Textured Buttercream overlay — ADD-on, never replaces base ──
                    const texNameT = getNumberTextureFileName(T, frostingsArr);
                    const texNameU = getNumberTextureFileName(U, frostingsArr);
                    if(texNameT || texNameU){
                        const [txT,txU]=await Promise.allSettled([
                            texNameT?loadGLB(`/models/${texNameT}.glb`):Promise.resolve(null),
                            texNameU?loadGLB(`/models/${texNameU}.glb`):Promise.resolve(null),
                        ]);
                        const tgT=txT.status==='fulfilled'&&txT.value&&glbHasMesh(txT.value)?txT.value:null;
                        const tgU=txU.status==='fulfilled'&&txU.value&&glbHasMesh(txU.value)?txU.value:null;
                                          if(tgT||tgU){
                            const texWrapper=new THREE.Group();
                            const baseDigitMeshesTex = baseWrapper.children; // [gT, gU] — already individually scaled
                            if(tgT&&tgU){
                                [tgT,tgU].forEach(g=>{g.position.set(0,0,0);g.rotation.set(0,0,0);g.scale.set(1,1,1);g.updateMatrixWorld(true);});
                                // Apply each base digit's OWN scale to its matching texture overlay —
                                // baseWrapper is no longer uniformly scaled (each digit scales
                                // independently now), so texWrapper.scale.copy(baseWrapper.scale)
                                // was leaving these at raw/unscaled size.
                                tgT.scale.copy(baseDigitMeshesTex[0].scale);
                                tgU.scale.copy(baseDigitMeshesTex[1].scale);
                                tgT.updateMatrixWorld(true); tgU.updateMatrixWorld(true);
                                const dp = baseWrapper.userData.digitLocalPos;
                                if(dp){
                                    tgT.position.copy(dp.T);
                                    tgU.position.copy(dp.U);
                                } else {
                                    const bT3=new THREE.Box3().setFromObject(tgT),bU3=new THREE.Box3().setFromObject(tgU);
                                    const wT3=bT3.max.x-bT3.min.x,wU3=bU3.max.x-bU3.min.x;
                                    const gap3=(wT3+wU3)*0.08,totalW3=wT3+gap3+wU3,startX3=-totalW3/2;
                                    tgT.position.x=startX3-bT3.min.x; tgU.position.x=startX3+wT3+gap3-bU3.min.x;
                                    tgT.position.y=-bT3.min.y; tgU.position.y=-bU3.min.y;
                                    tgT.position.z=-(bT3.min.z+(bT3.max.z-bT3.min.z)/2);
                                    tgU.position.z=-(bU3.min.z+(bU3.max.z-bU3.min.z)/2);
                                }
                                texWrapper.add(tgT); texWrapper.add(tgU);
                            } else {
                                const single = tgT||tgU;
                                single.scale.copy(tgT ? baseDigitMeshesTex[0].scale : baseDigitMeshesTex[1].scale);
                                texWrapper.add(single);
                            }
                            texWrapper.position.copy(baseWrapper.position);
                            sceneRoot.add(texWrapper); currentTexture=texWrapper;
                        }
                    }
                    // ── Drip overlay — dedicated per-digit export (drip0.glb, drip1.glb, ...), layered ON TOP of the base ──
                    if(hasDrip){
                        const dripNameT = getNumberDripFileName(T);
                        const dripNameU = getNumberDripFileName(U);
                        const [drT,drU]=await Promise.allSettled([
                            loadGLB(`/models/${dripNameT}.glb`).catch(()=>null),
                            loadGLB(`/models/${dripNameU}.glb`).catch(()=>null),
                        ]);
                        const dgT=drT.status==='fulfilled'&&drT.value&&glbHasMesh(drT.value)?drT.value:null;
                        const dgU=drU.status==='fulfilled'&&drU.value&&glbHasMesh(drU.value)?drU.value:null;
                        if(dgT||dgU){
                            const dripWrapper=new THREE.Group();
                            if(dgT&&dgU){
                                [dgT,dgU].forEach(g=>{g.position.set(0,0,0);g.rotation.set(0,0,0);g.scale.set(1,1,1);g.updateMatrixWorld(true);});
                                const dp = baseWrapper.userData.digitLocalPos;
                                if(dp){
                                    dgT.position.copy(dp.T);
                                    dgU.position.copy(dp.U);
                                } else {
                                    const bT4=new THREE.Box3().setFromObject(dgT),bU4=new THREE.Box3().setFromObject(dgU);
                                    const wT4=bT4.max.x-bT4.min.x,wU4=bU4.max.x-bU4.min.x;
                                    const gap4=(wT4+wU4)*0.08,totalW4=wT4+gap4+wU4,startX4=-totalW4/2;
                                    dgT.position.x=startX4-bT4.min.x; dgU.position.x=startX4+wT4+gap4-bU4.min.x;
                                    dgT.position.y=-bT4.min.y; dgU.position.y=-bU4.min.y;
                                    dgT.position.z=-(bT4.min.z+(bT4.max.z-bT4.min.z)/2);
                                    dgU.position.z=-(bU4.min.z+(bU4.max.z-bU4.min.z)/2);
                                }
                                dripWrapper.add(dgT); dripWrapper.add(dgU);
                            } else { dripWrapper.add(dgT||dgU); }
                            dripWrapper.scale.copy(baseWrapper.scale);
                            dripWrapper.position.copy(baseWrapper.position);
                            sceneRoot.add(dripWrapper); currentDrip=dripWrapper;
                        }
                    }
                                   if(isSugarIcing){
                        const [irT,irU]=await Promise.allSettled([loadGLB(`/models/icing_${T}.glb`),loadGLB(`/models/icing_${U}.glb`)]);
                        const igT=irT.status==='fulfilled'&&glbHasMesh(irT.value)?irT.value:null;
                        const igU=irU.status==='fulfilled'&&glbHasMesh(irU.value)?irU.value:null;
                  if(igT||igU){
                            const icingWrapper=new THREE.Group();
                            baseWrapper.updateMatrixWorld(true);
                            const baseDigitMeshesIcing = baseWrapper.children; // [gT, gU] in original order
                            // Fit EACH digit's icing ring independently to its OWN base digit's
                            // diameter/top edge — same approach as fitDigitFrost above — instead of
                            // reusing the base digits' raw local positions. icing_N.glb shares
                            // number_N.glb's local origin but NOT seminaked_N.glb's, so reusing
                            // digitLocalPos silently broke Sugar Icing whenever Semi-naked was the
                            // active cake style.
                            const SINGLE_DIGIT_REF_DIAM_ICING = inchesToWorldScale(4.5);
                            function fitDigitIcing(ig, baseDigitMesh){
                                if(!ig || !baseDigitMesh) return;
                                ig.position.set(0,0,0); ig.rotation.set(0,0,0); ig.scale.set(1,1,1);
                                ig.updateMatrixWorld(true);
                                const baseBoxI  = new THREE.Box3().setFromObject(baseDigitMesh);
                                const baseDiamI = Math.max(baseBoxI.max.x-baseBoxI.min.x, baseBoxI.max.z-baseBoxI.min.z);
                                const rawBoxI  = new THREE.Box3().setFromObject(ig);
                                const rawDiamI = Math.max(rawBoxI.max.x-rawBoxI.min.x, rawBoxI.max.z-rawBoxI.min.z);
                                const scaleI = rawDiamI > 0.0001 ? baseDiamI/rawDiamI : 1.0;
                                ig.scale.setScalar(scaleI);
                                ig.updateMatrixWorld(true);
                                const scaledBoxI = new THREE.Box3().setFromObject(ig);
                                const scaledCenterI = scaledBoxI.getCenter(new THREE.Vector3());
                                const baseCenterI = baseBoxI.getCenter(new THREE.Vector3());
                                const sizeRatioI = SINGLE_DIGIT_REF_DIAM_ICING > 0.0001 ? (baseDiamI / SINGLE_DIGIT_REF_DIAM_ICING) : 1.0;
                                ig.position.set(
                                    baseCenterI.x - scaledCenterI.x,
                                    (baseBoxI.max.y - scaledBoxI.max.y) + (0.07 * sizeRatioI),
                                    baseCenterI.z - scaledCenterI.z
                                );
                                ig.updateMatrixWorld(true);
                            }
                            fitDigitIcing(igT, baseDigitMeshesIcing[0]);
                            fitDigitIcing(igU, baseDigitMeshesIcing[1]);
                            if(igT) icingWrapper.add(igT);
                            if(igU) icingWrapper.add(igU);
                            sceneRoot.add(icingWrapper); currentIcing=icingWrapper;
                        }
                    }
                          // ── Rosette overlay — per-digit export (rosette_{N}_middle/border/full/sides.glb),
                    // layered ON TOP of the base. Now works for dual-digit numbers too — each digit
                    // gets its own independently-fitted rosette piece, same approach as the Shell
                    // Border / Textured / Icing overlays above.
                              // Rosettes now work alongside Semi-naked Style too — only Fondant
                    // (which replaces the whole cake surface) still excludes Rosettes.
                    const numRosetteOnDual = frostingsArr.includes('Rosettes') && !frostingsArr.includes('Fondant Smooth');
                    if(numRosetteOnDual){
                        const rMapT = getNumberRosetteFileMap(T);
                        const rMapU = getNumberRosetteFileMap(U);
                        const rFileT = rMapT[rosettePlacement] || rMapT['Border'];
                        const rFileU = rMapU[rosettePlacement] || rMapU['Border'];
                        const [rrT,rrU]=await Promise.allSettled([
                            rFileT?loadGLB(`/models/${rFileT}.glb`):Promise.resolve(null),
                            rFileU?loadGLB(`/models/${rFileU}.glb`):Promise.resolve(null),
                        ]);
                        const rgT=rrT.status==='fulfilled'&&rrT.value&&glbHasMesh(rrT.value)?rrT.value:null;
                        const rgU=rrU.status==='fulfilled'&&rrU.value&&glbHasMesh(rrU.value)?rrU.value:null;
                                         if(rgT||rgU){
                                                 const rosetteWrapper=new THREE.Group();
                            baseWrapper.updateMatrixWorld(true);
                            const baseDigitMeshesR = baseWrapper.children;
                            const SINGLE_DIGIT_REF_DIAM_R = inchesToWorldScale(4.5);
            function fitDigitRosette(rg, baseDigitMesh, digitVal){
    if(!rg || !baseDigitMesh) return;
    rg.position.set(0,0,0); rg.rotation.set(0,0,0); rg.scale.set(1,1,1);
    rg.updateMatrixWorld(true);
    const baseBoxR = new THREE.Box3().setFromObject(baseDigitMesh);
    const baseDiamR = Math.max(baseBoxR.max.x-baseBoxR.min.x, baseBoxR.max.z-baseBoxR.min.z);
    const baseHeightR = baseBoxR.max.y - baseBoxR.min.y;
    const rawBoxR = new THREE.Box3().setFromObject(rg);
    const rawDiamR = Math.max(rawBoxR.max.x-rawBoxR.min.x, rawBoxR.max.z-rawBoxR.min.z);
    const rawHeightR = rawBoxR.max.y - rawBoxR.min.y;
    const scaleR = rawDiamR > 0.0001 ? baseDiamR/rawDiamR : 1.0;
    if(rosettePlacement === 'Sides'){
        // Same independent height-match as the single-digit path — each
        // digit's own band spans its own body, so a shorter digit like "1"
        // and a taller one like "8" both wrap correctly side by side. Scaled
        // slightly WIDER than an exact diameter match (1.12x) so the band
        // sits just outside the digit's surface instead of embedding flush.
        const SIDES_DIAM_MULT_R = 1.12;
        const scaleXZ_R = scaleR * SIDES_DIAM_MULT_R;
        const targetHeightR = baseHeightR * 0.92;
        const scaleYR = rawHeightR > 0.0001 ? targetHeightR/rawHeightR : scaleXZ_R;
        rg.scale.set(scaleXZ_R, scaleYR, scaleXZ_R);
    } else {
        rg.scale.setScalar(scaleR);
    }
    rg.updateMatrixWorld(true);

    const scaledBoxR = new THREE.Box3().setFromObject(rg);
    const scaledCenterR = scaledBoxR.getCenter(new THREE.Vector3());
    const baseCenterR = baseBoxR.getCenter(new THREE.Vector3());
    // Per-digit nudge — same map the single-digit path uses. Values are a
    // fraction of THIS digit's own diameter, so tens/units digits (which can
    const _dNudge = (rosettePlacement === 'Sides')
        ? getRosetteSidesNudge(digitVal, frostingsArr)
        : {xNudge:0, zNudge:0, yNudge:0};

    if(rosettePlacement === 'Sides'){
        rg.position.set(
            baseCenterR.x - scaledCenterR.x + (baseDiamR * (_dNudge.xNudge||0)),
            (baseBoxR.max.y - scaledBoxR.max.y) + 0.02 + (baseDiamR * (_dNudge.yNudge||0)),
            baseCenterR.z - scaledCenterR.z + (baseDiamR * (_dNudge.zNudge||0))
        );
    } else {
        // Anchor Border/Full/Middle to the SHARED wrapper's top (not this
        // digit's own top) so both digits sit at the same height even when
        // one numeral shape is naturally taller than the other.
        const wrapperTopY = baseDigitMesh.parent
            ? new THREE.Box3().setFromObject(baseDigitMesh.parent).max.y
            : baseBoxR.max.y;
        const roseSinkD = (scaledBoxR.max.y - scaledBoxR.min.y) * 0.12;
        rg.position.set(
            baseCenterR.x - scaledCenterR.x,
            wrapperTopY - scaledBoxR.min.y - roseSinkD,
            baseCenterR.z - scaledCenterR.z
        );
    }
    rg.updateMatrixWorld(true);
}
                            fitDigitRosette(rgT, baseDigitMeshesR[0], T);
                            fitDigitRosette(rgU, baseDigitMeshesR[1], U);
                            if(rgT) rosetteWrapper.add(rgT);
                            if(rgU) rosetteWrapper.add(rgU);
                                              sceneRoot.add(rosetteWrapper); currentRosette=rosetteWrapper;
                            applyGLBMaterial(currentRosette, boostRosetteColor(rosetteColor || '#FFFFFF'), 0.58, 0.01, 1.0, 0.40);
                            if(window._pendingRosetteReveal){ hideGroupInstantly(currentRosette); currentRosette.userData.pendingReveal = true; window._pendingRosetteReveal = false; }
                        }
                    }
              const yBefore2=baseWrapper.position.y;
                    addStandToScene(baseWrapper);
                    const yDelta2=baseWrapper.position.y-yBefore2;
                                    if(yDelta2!==0){
                        if(currentIcing){currentIcing.position.y+=yDelta2;currentIcing.updateMatrixWorld(true);}
                        if(currentFrost && currentFrost!==baseWrapper){currentFrost.position.y+=yDelta2;currentFrost.updateMatrixWorld(true);}
                        if(currentTexture){currentTexture.position.y+=yDelta2;currentTexture.updateMatrixWorld(true);}
                        if(currentDrip){currentDrip.position.y+=yDelta2;currentDrip.updateMatrixWorld(true);}
                        if(currentRosette){currentRosette.position.y+=yDelta2;currentRosette.updateMatrixWorld(true);}
                    }
                 recolorGLB(flavor,frostingsArr,dripFlavor,icingColor,ombreTopColor,ombreBottomColor);
                    usedGLB=true; showStatus('Loaded ✓');
                }
   } else {
               const N=state.numberChoice??0;
              const baseGLB=await loadGLB(`/models/${getNumberBaseFileName(N, frostingsArr)}.glb`).catch(()=>null);
     if(baseGLB&&glbHasMesh(baseGLB)){
            positionGroup(baseGLB, 4.5, 1.0);
                  sceneRoot.add(baseGLB);
                    if(frostingsArr.includes('Fondant Smooth')){ currentFrost=baseGLB; } else { currentBase=baseGLB; }

                 const frostNameN = getNumberFrostFileName(N, frostingsArr);
                    if(frostNameN){
                        const frostGLB=await loadGLB(`/models/${frostNameN}.glb`).catch(()=>null);
                    if(frostGLB&&glbHasMesh(frostGLB)){
                            // Don't blindly copy baseGLB's scale — number{N}_smoothbc.glb was
                            // authored against number_{N}.glb's raw proportions, not
                            // seminaked_{N}.glb's. Fit the ring independently to whatever the
                            // ACTUAL rendered base measures (diameter + top-align), same
                            // approach used for Round/Square/Heart Shell Border overlays.
                            frostGLB.position.set(0,0,0); frostGLB.rotation.set(0,0,0); frostGLB.scale.set(1,1,1);
                            frostGLB.updateMatrixWorld(true);
                            const baseBoxN = new THREE.Box3().setFromObject(baseGLB);
                            const baseDiamN = Math.max(baseBoxN.max.x-baseBoxN.min.x, baseBoxN.max.z-baseBoxN.min.z);
                            const rawFrostBoxN = new THREE.Box3().setFromObject(frostGLB);
                            const rawFrostDiamN = Math.max(rawFrostBoxN.max.x-rawFrostBoxN.min.x, rawFrostBoxN.max.z-rawFrostBoxN.min.z);
                            const frostScaleN = rawFrostDiamN > 0.0001 ? baseDiamN/rawFrostDiamN : 1.0;
                            frostGLB.scale.setScalar(frostScaleN);
                            frostGLB.updateMatrixWorld(true);
                            const scaledFrostBoxN = new THREE.Box3().setFromObject(frostGLB);
                            const scaledFrostCenterN = scaledFrostBoxN.getCenter(new THREE.Vector3());
                            const baseCenterN = baseBoxN.getCenter(new THREE.Vector3());
                            frostGLB.position.set(
                                baseCenterN.x - scaledFrostCenterN.x,
                                (baseBoxN.max.y - scaledFrostBoxN.max.y) + 0.07,
                                baseCenterN.z - scaledFrostCenterN.z
                            );
                            frostGLB.updateMatrixWorld(true);
                            sceneRoot.add(frostGLB); currentFrost=frostGLB;
                        }
                    }
                   // ── Textured Buttercream overlay — ADD-on, never replaces base ──
                    const texNameN = getNumberTextureFileName(N, frostingsArr);
                    if(texNameN){
                        const texGLB=await loadGLB(`/models/${texNameN}.glb`).catch(()=>null);
                        if(texGLB&&glbHasMesh(texGLB)){
                            texGLB.scale.copy(baseGLB.scale);
                            texGLB.position.copy(baseGLB.position);
                            texGLB.rotation.copy(baseGLB.rotation);
                            sceneRoot.add(texGLB); currentTexture=texGLB;
                        }
                    }

                          if(isSugarIcing){
                        const icingGLB=await loadGLB(`/models/icing_${N}.glb`).catch(()=>null);
                        if(icingGLB&&glbHasMesh(icingGLB)){
                            // Fit independently to the ACTUAL rendered base (baseGLB) instead of
                            // blindly copying its transform — icing_{N}.glb was authored against
                            // number_{N}.glb's raw proportions, not seminaked_{N}.glb's. Measure
                            // the real base mesh and top-align to it, same approach used for the
                            // Shell Border overlay above (and for Rosettes further below).
                            icingGLB.position.set(0,0,0); icingGLB.rotation.set(0,0,0); icingGLB.scale.set(1,1,1);
                            icingGLB.updateMatrixWorld(true);
                            const baseBoxIN = new THREE.Box3().setFromObject(baseGLB);
                            const baseDiamIN = Math.max(baseBoxIN.max.x-baseBoxIN.min.x, baseBoxIN.max.z-baseBoxIN.min.z);
                            const rawIcingBoxN = new THREE.Box3().setFromObject(icingGLB);
                            const rawIcingDiamN = Math.max(rawIcingBoxN.max.x-rawIcingBoxN.min.x, rawIcingBoxN.max.z-rawIcingBoxN.min.z);
                            const icingScaleN = rawIcingDiamN > 0.0001 ? baseDiamIN/rawIcingDiamN : 1.0;
                            icingGLB.scale.setScalar(icingScaleN);
                            icingGLB.updateMatrixWorld(true);
                            const scaledIcingBoxN = new THREE.Box3().setFromObject(icingGLB);
                            const scaledIcingCenterN = scaledIcingBoxN.getCenter(new THREE.Vector3());
                            const baseCenterIN = baseBoxIN.getCenter(new THREE.Vector3());
                            icingGLB.position.set(
                                baseCenterIN.x - scaledIcingCenterN.x,
                                (baseBoxIN.max.y - scaledIcingBoxN.max.y) + 0.07,
                                baseCenterIN.z - scaledIcingCenterN.z
                            );
                            icingGLB.updateMatrixWorld(true);
                            sceneRoot.add(icingGLB); currentIcing=icingGLB;
                        }
                    }

          // ── Drip overlay — dedicated per-digit export (drip0.glb, drip1.glb, ...), layered ON TOP of the base ──
                    if(hasDrip){
                        const dripNameN = getNumberDripFileName(N);
                        const dripGLB=await loadGLB(`/models/${dripNameN}.glb`).catch(()=>null);
                        if(dripGLB&&glbHasMesh(dripGLB)){
                            dripGLB.scale.copy(baseGLB.scale);
                            dripGLB.position.copy(baseGLB.position);
                            dripGLB.rotation.copy(baseGLB.rotation);
                            sceneRoot.add(dripGLB); currentDrip=dripGLB;
                        }
}
                                   // ── Rosette overlay — supports both a single placement AND a combo
                    // (e.g. "Border+Sides") for single-digit numbers. Each half of a combo
                    // is its own GLB, fitted independently, then grouped together. ──
                    const numRosetteOn = frostingsArr.includes('Rosettes') && !frostingsArr.includes('Fondant Smooth');
                    if(numRosetteOn){
                        const rMapSD = getNumberRosetteFileMap(N);
                        const rosettePlacementListSD = rosettePlacement.split('+').map(s=>s.trim());
                        const rosettePiecesSD = [];
                        for(const pl of rosettePlacementListSD){
                            const fileSD = rMapSD[pl] || rMapSD['Border'];
                            const gSD = await loadGLB(`/models/${fileSD}.glb`).catch(()=>null);
                            if(gSD && glbHasMesh(gSD)) rosettePiecesSD.push({ glb:gSD, placement:pl });
                        }
                        if(rosettePiecesSD.length > 0){
                            function fitSingleDigitRosettePiece(rosetteGLB, placement){
                                rosetteGLB.position.set(0,0,0); rosetteGLB.rotation.set(0,0,0); rosetteGLB.scale.set(1,1,1);
                                rosetteGLB.updateMatrixWorld(true);
                                const baseBoxSD  = new THREE.Box3().setFromObject(baseGLB);
                                const baseDiamSD = Math.max(baseBoxSD.max.x-baseBoxSD.min.x, baseBoxSD.max.z-baseBoxSD.min.z);
                                const baseHeightSD = baseBoxSD.max.y - baseBoxSD.min.y;
                                const rawBoxSD  = new THREE.Box3().setFromObject(rosetteGLB);
                                const rawDiamSD = Math.max(rawBoxSD.max.x-rawBoxSD.min.x, rawBoxSD.max.z-rawBoxSD.min.z);
                                const rawHeightSD = rawBoxSD.max.y - rawBoxSD.min.y;
                                const scaleSD = rawDiamSD > 0.0001 ? baseDiamSD/rawDiamSD : 1.0;
                                if(placement === 'Sides'){
                                    const SIDES_DIAM_MULT_SD = 1.12;
                                    const scaleXZ_SD = scaleSD * SIDES_DIAM_MULT_SD;
                                    const targetHeightSD = baseHeightSD * 0.92;
                                    const scaleYSD = rawHeightSD > 0.0001 ? targetHeightSD/rawHeightSD : scaleXZ_SD;
                                    rosetteGLB.scale.set(scaleXZ_SD, scaleYSD, scaleXZ_SD);
                                } else {
                                    rosetteGLB.scale.setScalar(scaleSD);
                                }
                                rosetteGLB.updateMatrixWorld(true);

                                const scaledBoxSD = new THREE.Box3().setFromObject(rosetteGLB);
                                const scaledCenterSD = scaledBoxSD.getCenter(new THREE.Vector3());
                                const baseCenterSD = baseBoxSD.getCenter(new THREE.Vector3());

                                const _roseSidesNudgeSD = (placement === 'Sides') ? getRosetteSidesNudge(N, frostingsArr) : {xNudge:0, zNudge:0, yNudge:0};
                                if(placement === 'Sides'){
                                    rosetteGLB.position.set(
                                        baseCenterSD.x - scaledCenterSD.x + (baseDiamSD * _roseSidesNudgeSD.xNudge),
                                        (baseBoxSD.max.y - scaledBoxSD.max.y) + 0.02 + (baseDiamSD * (_roseSidesNudgeSD.yNudge||0)),
                                        baseCenterSD.z - scaledCenterSD.z + (baseDiamSD * _roseSidesNudgeSD.zNudge)
                                    );
                                } else {
                                    const roseSinkSD = (scaledBoxSD.max.y - scaledBoxSD.min.y) * 0.12;
                                    rosetteGLB.position.set(
                                        baseCenterSD.x - scaledCenterSD.x,
                                        baseBoxSD.max.y - scaledBoxSD.min.y - roseSinkSD,
                                        baseCenterSD.z - scaledCenterSD.z
                                    );
                                }
                                rosetteGLB.updateMatrixWorld(true);
                            }

                            rosettePiecesSD.forEach(p => fitSingleDigitRosettePiece(p.glb, p.placement));

                            if(rosettePiecesSD.length === 1){
                                currentRosette = rosettePiecesSD[0].glb;
                            } else {
                                currentRosette = new THREE.Group();
                                rosettePiecesSD.forEach(p => currentRosette.add(p.glb));
                            }
                            sceneRoot.add(currentRosette);
                            applyGLBMaterial(currentRosette, boostRosetteColor(rosetteColor || '#FFFFFF'), 0.58, 0.01, 1.0, 0.40);
                            if(window._pendingRosetteReveal){ hideGroupInstantly(currentRosette); currentRosette.userData.pendingReveal = true; window._pendingRosetteReveal = false; }
                        }
                    }

                   const yBefore3=baseGLB.position.y;
                    addStandToScene(baseGLB);
                    const yDelta3=baseGLB.position.y-yBefore3;
                 if(yDelta3!==0){
                        if(currentIcing){currentIcing.position.y+=yDelta3;currentIcing.updateMatrixWorld(true);}
                        if(currentFrost && currentFrost!==baseGLB){currentFrost.position.y+=yDelta3;currentFrost.updateMatrixWorld(true);}
                        if(currentTexture){currentTexture.position.y+=yDelta3;currentTexture.updateMatrixWorld(true);}
                        if(currentDrip){currentDrip.position.y+=yDelta3;currentDrip.updateMatrixWorld(true);}
                        if(currentRosette){currentRosette.position.y+=yDelta3;currentRosette.updateMatrixWorld(true);}
                    }
                   recolorGLB(flavor,frostingsArr,dripFlavor,icingColor,ombreTopColor,ombreBottomColor);
                    usedGLB=true; showStatus('Loaded ✓');
                }
            }
        } catch(e){ console.warn('Number GLB error',e); }
        if(!usedGLB){ showNoPreview('Number'); }
    } else {
const slug      = shape === 'Two-tier Round' ? 'two-tier' : shape === 'Three-tier Round' ? 'three-tier' : (SHAPE_SLUG[shape]||'round');
const originalShape = shape;
_isBundtActive = (slug === 'bundt');
const needFrost = shouldLoadFrostingGLB(frostingsArr);
const hasFondant    = frostingsArr.includes('Fondant Smooth');
const hasSemiNaked  = frostingsArr.includes('Semi-naked Style');
const hasSemiNakedR = hasSemiNaked;
const semiNakedSlug = (shape === 'Two-tier Round') ? 'two-tier' : (shape === 'Three-tier Round') ? 'three-tier' : (shape === 'Heart') ? 'heart' : (shape === 'Square') ? 'square' : 'round';
const baseURL  = (slug === 'bundt')
    ? (hasSemiNaked ? `/models/bundt_seminaked.glb` : `/models/bundt.glb`)
    : hasSemiNaked
        ? `/models/base_seminaked_${semiNakedSlug}.glb`
        : `/models/base_${slug}.glb`;
console.log('[Debug] Loading base:', baseURL);
const hasShellBorder = frostingsArr.includes('Smooth Buttercream');
const hasTextured = frostingsArr.includes('Textured Buttercream');
const frostURL = hasFondant
    ? `/models/fondant_${slug}.glb`
  : (hasSemiNaked && (slug === 'round' || slug === 'two-tier' || slug === 'three-tier' || slug === 'square' || slug === 'heart'))
            ? (hasShellBorder ? `/models/frosting_${slug}_smooth.glb` : null)
  : (isSugarIcing && !hasSemiNaked && !hasTextured)
            ? null
            : (slug === 'bundt')
                ? (hasShellBorder ? `/models/bundt_smoothbc.glb` : null)
                // Only load a base-coat overlay when Shell Border or Textured is actually
                // selected — 'Rosettes' alone (with no base coat underneath) must not
                // silently fall back to the 'smooth' default.
                : (needFrost && (hasShellBorder || hasTextured) ? `/models/frosting_${slug}_${frostSuffix}.glb` : null);
console.log('[SemiNaked Debug] hasShellBorder:', hasShellBorder, '| frostURL:', frostURL);
console.log('[Fondant Debug] hasFondant:', hasFondant, '| frostURL:', frostURL, '| slug:', slug);
const activeCakeStyle = frostingsArr.find(f => ['Semi-naked Style','Fondant Smooth','Smooth Buttercream'].includes(f)) || 'Smooth Buttercream';
const icingURL = isSugarIcing
    ? (slug === 'bundt'
        ? `/models/bundt_icing.glb`
        : activeCakeStyle === 'Semi-naked Style' && !hasShellBorder
            ? `/models/icing_${slug}_seminaked.glb`
            : `/models/icing_${slug}.glb`)
    : null;
const dripURL = hasDrip
    ? (slug === 'bundt'
        ? `/models/bundt_drip.glb`
        : hasFondant
            ? `/models/fondant_drip_${slug}.glb`
            : hasSemiNaked
                ? (slug === 'heart' ? `/models/drip_heart_round.glb` : `/models/drip_seminaked_${slug}.glb`)
                : `/models/drip_${slug}.glb`)
    : null;
const rosetteActive = frostingsArr.includes('Rosettes') && !hasFondant;
// Combo placements (e.g. "Border+Sides") need TWO rosette pieces instead of
// one — split on '+' so each half is fetched and positioned independently.
const rosettePlacementList = rosetteActive ? rosettePlacement.split('+').map(s=>s.trim()) : [];
const rosetteURLs = rosettePlacementList.map(pl => `/models/${getRosetteFileMap(slug)[pl] || `rosette_${slug}`}.glb`);
const urlList  = [baseURL];
const idxFrost = (frostURL) ? (urlList.push(frostURL)-1) : -1;
const idxIcing = icingURL                 ? (urlList.push(icingURL)-1) : -1;
const idxDrip  = dripURL                  ? (urlList.push(dripURL) -1) : -1;
const idxRosetteStart = rosetteURLs.length ? urlList.length : -1;
rosetteURLs.forEach(u=>urlList.push(u));

const results  = await Promise.allSettled(urlList.map(u=>loadGLB(u)));
const baseGLB  = results[0]?.status==='fulfilled' ? results[0].value : null;
const frostGLB = idxFrost>=0 && results[idxFrost]?.status==='fulfilled' ? results[idxFrost].value : null;
if(hasFondant && !frostGLB) console.error(`[Fondant] Missing: /models/fondant_${slug}.glb`);
const icingGLB = idxIcing>=0 && results[idxIcing]?.status==='fulfilled' ? results[idxIcing].value : null;
const dripGLB  = idxDrip >=0 && results[idxDrip] ?.status==='fulfilled' ? results[idxDrip].value  : null;
// Each entry: { glb, placement } — one per piece in the combo (or a single entry for non-combos)
const rosettePieces = [];
if(idxRosetteStart >= 0){
    rosettePlacementList.forEach((pl, i)=>{
        const r = results[idxRosetteStart + i];
        const g = r?.status==='fulfilled' ? r.value : null;
        if(g && glbHasMesh(g)) rosettePieces.push({ glb:g, placement:pl });
        else console.error(`[Rosette] Missing: ${rosetteURLs[i]}`);
    });
}

clearScene(true);

const toPos = [];
if(baseGLB  && glbHasMesh(baseGLB)) { currentBase  = baseGLB;  sceneRoot.add(currentBase);  toPos.push(currentBase);  }
if(frostGLB && glbHasMesh(frostGLB)) { currentFrost = frostGLB; sceneRoot.add(currentFrost); toPos.push(currentFrost); }
if(icingGLB && glbHasMesh(icingGLB)) { currentIcing = icingGLB; sceneRoot.add(currentIcing); toPos.push(currentIcing); }
if(dripGLB  && glbHasMesh(dripGLB))  { currentDrip  = dripGLB;  sceneRoot.add(currentDrip);  toPos.push(currentDrip);  }
const rosetteIsCombo = rosettePieces.length > 1;
if(rosettePieces.length === 1) {
    // Single placement (no combo) — keep this EXACTLY like before: the raw
    // loaded piece goes straight into the scene with no wrapper group, so
    // all the sizing/position math below behaves identically to the
    // pre-combo version (this is what "Sides" etc. depend on).
    currentRosette = rosettePieces[0].glb;
    sceneRoot.add(currentRosette);
    applyGLBMaterial(currentRosette, boostRosetteColor(rosetteColor || '#FFFFFF'), 0.58, 0.01, 1.0, 0.40);
    if(window._pendingRosetteReveal){ hideGroupInstantly(currentRosette); currentRosette.userData.pendingReveal = true; window._pendingRosetteReveal = false; }
} else if(rosettePieces.length > 1) {
    // Combo placement (e.g. Border+Sides) — needs two independent pieces,
    // so only THIS case gets wrapped in a group.
    currentRosette = new THREE.Group();
    rosettePieces.forEach(p => currentRosette.add(p.glb));
    sceneRoot.add(currentRosette);
    applyGLBMaterial(currentRosette, boostRosetteColor(rosetteColor || '#FFFFFF'), 0.58, 0.01, 1.0, 0.40);
    if(window._pendingRosetteReveal){ hideGroupInstantly(currentRosette); currentRosette.userData.pendingReveal = true; window._pendingRosetteReveal = false; }
}
// Only frost gets texture preservation skipped — base always recolors
if(hasSemiNaked && currentFrost) currentFrost.userData.keepOriginalTexture = true;

// Fits the loaded rosette (single piece or combo group) to the ACTUAL final
// diameter/position of whichever cake mesh is passed in — used for the normal
// path AND reused for semi-naked cakes so Rosettes behave identically no
// matter which cake style is active.
function fitRosetteToCake(cakeRef){
    if(!currentRosette || !cakeRef) return;
    const rosetteUnits = rosetteIsCombo
        ? currentRosette.children.map((c,i)=>({ obj:c, placement: rosettePieces[i].placement }))
        : [{ obj: currentRosette, placement: rosettePieces[0].placement }];
    rosetteUnits.forEach(({obj: child, placement}) => {
        child.position.set(0,0,0);
        child.rotation.set(0,0,0);
        child.scale.set(1,1,1);
        child.updateMatrixWorld(true);
        const rawRoseBox  = new THREE.Box3().setFromObject(child);
        const rawRoseDiam = Math.max(rawRoseBox.max.x-rawRoseBox.min.x, rawRoseBox.max.z-rawRoseBox.min.z);
        const cakeBoxNow  = new THREE.Box3().setFromObject(cakeRef);
        const cakeDiamNow = Math.max(cakeBoxNow.max.x-cakeBoxNow.min.x, cakeBoxNow.max.z-cakeBoxNow.min.z);
        const ROSETTE_SIDES_ADJUST = {
            'round':      { diamMult: 1.08, yNudge: 0 },
            'square':     { diamMult: 1.1, yNudge: 0 },
            'heart':      { diamMult: 1.05, yNudge: 0 },
            'two-tier':   { diamMult: 1.14, yNudge: 0.05 },
            'three-tier': { diamMult: 1.10, yNudge: 0.07 },
        };
        const ROSETTE_FULLTOP_ADJUST = {
            heart:  { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            round:  { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            square: { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            'two-tier': { diamMult: 0.8, xNudge: 0, zNudge: 0 },
            'three-tier': { diamMult: 0.53, xNudge: 0, zNudge: 0 },
        };
        const ROSETTE_CLUSTER_RIGHT_ADJUST = {
            heart:  { diamMult: 0.8, xNudge: 0, zNudge: 0 },
            round:  { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            square: { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            'two-tier': { diamMult: 0.8, xNudge: -0.05, zNudge: 0 },
            'three-tier': { diamMult: 0.5, xNudge: -0.1, zNudge: 0 },
        };
        const ROSETTE_CLUSTER_LEFT_ADJUST = {
            heart:  { diamMult: 0.8, xNudge: 0, zNudge: 0 },
            round:  { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            square: { diamMult: 1.0, xNudge: 0, zNudge: 0 },
            'two-tier': { diamMult: 0.8, xNudge: 0.05, zNudge: 0 },
            'three-tier': { diamMult: 0.5, xNudge: 0.1, zNudge: 0 },
        };
      const ROSETTE_BORDER_ADJUST = {
    'two-tier':   { diamMult: 1.05, yNudge: 0.24 },
    'three-tier': { diamMult: 1.05, yNudge: 0.38 },
};
        const roseDiamMult = (placement === 'Sides')
            ? (ROSETTE_SIDES_ADJUST[slug]?.diamMult ?? 1.14)
            : (placement === 'Full Top')
                ? (ROSETTE_FULLTOP_ADJUST[slug]?.diamMult ?? 1.0)
                : (placement === 'Cluster Right')
                    ? (ROSETTE_CLUSTER_RIGHT_ADJUST[slug]?.diamMult ?? 1.0)
                    : (placement === 'Cluster Left')
                        ? (ROSETTE_CLUSTER_LEFT_ADJUST[slug]?.diamMult ?? 1.0)
                        : (placement === 'Border')
                            ? (ROSETTE_BORDER_ADJUST[slug]?.diamMult ?? 1.0)
                            : 1.0;
        // Drip hangs down over the same outer edge Border/Sides rosettes sit on and can
        // visually swallow them. When Drip is active, nudge those placements slightly
        // wider so the rosette ring sits proud of the drip instead of being covered by it.
        const DRIP_CLEARANCE_MULT = { 'Border': 1.06, 'Sides': 1.05 };
        const roseDiamMultFinal = (hasDrip && DRIP_CLEARANCE_MULT[placement])
            ? roseDiamMult * DRIP_CLEARANCE_MULT[placement]
            : roseDiamMult;
        const roseScale = rawRoseDiam > 0.0001 ? (cakeDiamNow*roseDiamMultFinal)/rawRoseDiam : 1.0;
        child.scale.setScalar(roseScale);
        child.updateMatrixWorld(true);
        const scaledRoseBox  = new THREE.Box3().setFromObject(child);
        const scaledRoseSize = scaledRoseBox.getSize(new THREE.Vector3());
        const roseCenter     = scaledRoseBox.getCenter(new THREE.Vector3());
        const cakeCenterNow  = cakeBoxNow.getCenter(new THREE.Vector3());
        const cakeRadiusNow  = cakeDiamNow * 0.5;

        let targetX = cakeCenterNow.x - roseCenter.x;
        let targetZ = cakeCenterNow.z - roseCenter.z;
        let targetY;
        const roseSink = scaledRoseSize.y * 0.12;

        if(placement === 'Cluster Right' || placement === 'Cluster Left'){
            const clusterOffset = cakeRadiusNow * 0.42;
            targetX += (placement === 'Cluster Right' ? clusterOffset : -clusterOffset);
            const clusterAdjust = (placement === 'Cluster Right' ? ROSETTE_CLUSTER_RIGHT_ADJUST : ROSETTE_CLUSTER_LEFT_ADJUST)[slug] || { xNudge:0, zNudge:0 };
            targetX += cakeDiamNow * clusterAdjust.xNudge;
            targetZ += cakeDiamNow * clusterAdjust.zNudge;
            targetY = cakeBoxNow.max.y - scaledRoseBox.min.y - roseSink;
        } else if(placement === 'Sides'){
            const sidesSink = scaledRoseSize.y * 0.90;
            const sidesYNudge = ROSETTE_SIDES_ADJUST[slug]?.yNudge ?? 0;
            targetY = cakeBoxNow.max.y - scaledRoseBox.min.y - sidesSink - (cakeDiamNow * sidesYNudge);
        } else if(placement === 'Border' && ROSETTE_BORDER_ADJUST[slug]){
            const bAdjust = ROSETTE_BORDER_ADJUST[slug];
            targetY = cakeBoxNow.max.y - scaledRoseBox.min.y - roseSink - (cakeDiamNow * bAdjust.yNudge);
        } else {
            targetY = cakeBoxNow.max.y - scaledRoseBox.min.y - roseSink;
        }
        child.position.set(targetX, targetY, targetZ);
        child.updateMatrixWorld(true);
    });
}

if(toPos.length > 0 || hasFondant){
            sceneRoot.updateMatrixWorld(true);
const _inches = (shape==='Round') ? (state.roundSize||6) : (shape==='Heart') ? 7.5 : (shape==='Number') ? 5 : 6;

if(hasFondant && currentFrost && glbHasMesh(currentFrost)){
                // ── FONDANT: use positionGroup for consistent sizing ──
                currentFrost.position.set(0,0,0); currentFrost.rotation.set(0,0,0); currentFrost.scale.set(1,1,1);
                currentFrost.updateMatrixWorld(true);

                // Scale using the same logic as normal cakes
                positionGroup(currentFrost, _inches);
                currentFrost.updateMatrixWorld(true);

                // Add stand
                const yBefore = currentFrost.position.y;
                addStandToScene(currentFrost);
                currentFrost.updateMatrixWorld(true);
   } else {
if(hasSemiNakedR && currentFrost && !currentBase) {
        // Shell border only — frosting_round_seminaked_smooth.glb IS the whole cake
        positionGroup(currentFrost, _inches);
        currentFrost.updateMatrixWorld(true);
        addStandToScene(currentFrost);
        currentFrost.updateMatrixWorld(true);
    fitRosetteToCake(currentFrost);
    recolorGLB(flavor, frostingsArr, dripFlavor, icingColor, ombreTopColor, ombreBottomColor);
        usedGLB = true; showStatus('Loaded ✓');
    } else if(hasSemiNakedR && currentBase){
                    // Collect ring-style overlay GLBs (frost, icing) — these get diameter-fitted
                    // to the base below. Drip is handled separately further down: its seminaked
                    // export already matches the base's own coordinate frame, so force-fitting it
                    // like a thin ring was squishing it and pulling it up too high instead of
                    // letting it hang down naturally like it does on Smooth BC.
                    const overlays = [];
                    if(currentFrost) overlays.push(currentFrost);
                    if(currentIcing) overlays.push(currentIcing);
                    // Size the base independently (this is base_seminaked_*.glb — its own
                    // dedicated raw file, proven to size correctly on its own via positionGroup).
                    positionGroup(currentBase, _inches);

                    // Now fit each overlay independently to the base's ACTUAL final size/
                    // position — never assume the overlay shares the base's raw coordinate
                    // frame. This matters because Shell Border's overlay now reuses
                    // frosting_*_smooth.glb, the SAME file normal (non-semi-naked) Smooth BC
                    // uses to overlay base_*.glb — not base_seminaked_*.glb, so its raw scale/
                    // origin has no guaranteed relationship to the semi-naked base file.
                               const baseBoxSN = new THREE.Box3().setFromObject(currentBase);
                    const baseCenterSN = baseBoxSN.getCenter(new THREE.Vector3());
                    const baseDiamSN = Math.max(baseBoxSN.max.x-baseBoxSN.min.x, baseBoxSN.max.z-baseBoxSN.min.z);
                                   // Per-shape diameter correction for the Shell Border ring — some shapes'
                    // ring GLBs are exported slightly smaller than the cake footprint, so a
                    // straight diameter match leaves them sitting inset instead of on the edge.
                    // Tune per-shape here; 1.0 = no change.
                    const SHELL_BORDER_DIAM_MULT = {
                        round:  1.0,
                        square: 1.12,
                        heart:  1.0,
                    };
                                     // Per-shape extra Y offset ON TOP OF the base 0.08 nudge — increase to
                    // lift the ring further up, decrease (or go negative) to push it down.
                    const SHELL_BORDER_Y_EXTRA = {
                        round:      0,
                        square:     0,
                        heart:      0.03,
                        'two-tier':   -0.04,
                        'three-tier': -0.05,
                    };
                                    const shellDiamMult = SHELL_BORDER_DIAM_MULT[slug] ?? 1.0;
                    const shellYExtra = SHELL_BORDER_Y_EXTRA[slug] ?? 0;
                                    overlays.forEach(g=>{
                        if(slug === 'bundt'){
                            // Bundt's shell border (bundt_smoothbc.glb) is already authored
                            // to line up correctly when its transform is copied straight from
                            // the base bundt mesh — same approach the smooth-BC (non-semi-naked)
                            // Bundt path uses. The generic diameter-fit math below doesn't
                            // apply here since Bundt's scalloped shape breaks the diameter
                            // assumption other shapes rely on.
                            g.scale.copy(currentBase.scale);
                            g.position.copy(currentBase.position);
                            g.rotation.copy(currentBase.rotation);
                            g.updateMatrixWorld(true);
                                                    // Drip visually eats into the Shell Border / Sugar Icing overlay
                            // on Bundt cakes since they sit at the same height — nudge the
                            // overlay up so it clears the drip. Only applies when Drip is on.
                            if(hasDrip){
                                const bundtBoxSN = new THREE.Box3().setFromObject(currentBase);
                                const bundtHeightSN = bundtBoxSN.max.y - bundtBoxSN.min.y;
                                g.position.y += bundtHeightSN * 0.055;
                                g.updateMatrixWorld(true);
                            }
                            return;
                        }
                        g.position.set(0,0,0); g.rotation.set(0,0,0); g.scale.set(1,1,1);
                        g.updateMatrixWorld(true);
                        const rawBoxSN = new THREE.Box3().setFromObject(g);
                        const rawDiamSN = Math.max(rawBoxSN.max.x-rawBoxSN.min.x, rawBoxSN.max.z-rawBoxSN.min.z);
                        const scaleSN = rawDiamSN > 0.0001 ? (baseDiamSN*shellDiamMult)/rawDiamSN : 1.0;
                        g.scale.setScalar(scaleSN);
                        g.updateMatrixWorld(true);
                        const scaledBoxSN = new THREE.Box3().setFromObject(g);
                        const scaledCenterSN = scaledBoxSN.getCenter(new THREE.Vector3());
                        // Shell Border / Drip overlays are top-anchored rings, not full-height
                        // skins — align their TOP to the cake's top so the ring sits at the
                        // rim (matching the plain Smooth-Buttercream reference render),
                        // instead of aligning bottoms and burying the ring at the base.
                                     g.position.set(
                            baseCenterSN.x - scaledCenterSN.x,
                            (baseBoxSN.max.y - scaledBoxSN.max.y) + 0.08 + shellYExtra,
                            baseCenterSN.z - scaledCenterSN.z
                        );
                        g.updateMatrixWorld(true);
                    });

                    // Drip — copy the base's transform directly instead of independently
                    // re-fitting it like a ring, so it hangs down the sides naturally.
                    if(currentDrip){
                        currentDrip.scale.copy(currentBase.scale);
                        currentDrip.position.copy(currentBase.position);
                        currentDrip.rotation.copy(currentBase.rotation);
                        currentDrip.updateMatrixWorld(true);
                    }

                 // Add stand and shift all overlays by same delta
                    const yBefore = currentBase.position.y;
                    // Bundt sits high due to stray geometry — same sink applied to the
                    // regular (non-semi-naked) bundt path below, so semi-naked matches it.
                    const _bundtSinkSN = _isBundtActive ? 0.16 : 0;
                    addStandToScene(currentBase, _bundtSinkSN);
                                                    const yDelta = currentBase.position.y - yBefore;
                    if(yDelta !== 0){
                        overlays.forEach(g => { g.position.y += yDelta; g.updateMatrixWorld(true); });
                        if(currentDrip){ currentDrip.position.y += yDelta; currentDrip.updateMatrixWorld(true); }
                    }
                        [currentBase, ...overlays, ...(currentDrip?[currentDrip]:[])].forEach(g => { g.visible = true; });
                    fitRosetteToCake(currentBase);
                }else {
       if(!hasFondant){
                                   if(slug === 'bundt' && toPos.length >= 2){
                        // Bundt overlays (Shell Border / Sugar Icing / Drip) must reuse the
                        // whole-cake bundt mesh's own transform instead of being folded into
                        // a combined bounding box — bundt.glb + bundt_smoothbc.glb together
                        // have a very different footprint than bundt.glb alone, and sizing
                        // off the combined box was shrinking the visible cake and leaving
                        // overlay decorations (like Choco Curls) floating above it.
                        positionGroup(currentBase, _inches);
                        toPos.slice(1).forEach(g=>{
                            g.scale.copy(currentBase.scale);
                            g.position.copy(currentBase.position);
                            g.rotation.copy(currentBase.rotation);
                            g.updateMatrixWorld(true);
                        });
                                             // Drip visually eats into the Shell Border / Sugar Icing overlay on
                        // Bundt cakes since they render at the same height as the drip —
                        // nudge those two overlays up so they clear it. Drip itself (currentDrip)
                        // is left untouched. Only applies when Drip is active.
                        if(hasDrip){
                            const bundtBox = new THREE.Box3().setFromObject(currentBase);
                            const bundtHeight = bundtBox.max.y - bundtBox.min.y;
                            const nudgeUp = bundtHeight * 0.055;
                            if(currentFrost && currentFrost !== currentBase){ currentFrost.position.y += nudgeUp; currentFrost.updateMatrixWorld(true); }
                            if(currentIcing){ currentIcing.position.y += nudgeUp; currentIcing.updateMatrixWorld(true); }
                        }
                    } else if(toPos.length >= 2){
                        positionMultiGroup(_inches, ...toPos);
                    } else if(toPos.length === 1){
                        positionGroup(toPos[0], _inches);
                    }
               if(toPos.length > 0){
                        const yBefore = toPos[0].position.y;
                        // Bundt sits a bit high due to stray geometry in the current bundt.glb —
                        // nudge it down. Increase this number for more sink, decrease for less.
                        const _bundtSink = (shape==='Bundt') ? 0.16 : 0;
                        addStandToScene(toPos[0], _bundtSink);
                        const yDelta = toPos[0].position.y - yBefore;
                        if(yDelta !== 0) toPos.slice(1).forEach(g=>{ g.position.y+=yDelta; g.updateMatrixWorld(true); });
fitRosetteToCake(toPos[0]);
                    }
                }
                }
            }
     recolorGLB(flavor, frostingsArr, dripFlavor, icingColor, ombreTopColor, ombreBottomColor);
            usedGLB = true; showStatus('Loaded ✓');
        } else if(hasFondant && currentFrost && glbHasMesh(currentFrost)){
       recolorGLB(flavor, frostingsArr, dripFlavor, icingColor, ombreTopColor, ombreBottomColor);
            usedGLB = true; showStatus('Loaded ✓');
        }
  if(!usedGLB){ showNoPreview(shape); }
        updateCheesecakeCrust(state.cakeType);
    }
loadedKey=newKey; sceneRoot.visible=true;
    invalidateCakeMeshesCache();
isLoading=false;
    loadingEl.style.opacity='0'; setTimeout(()=>{loadingEl.style.display='none';},400);
    isLoading=false;
    if(typeof window._requestRender==='function') window._requestRender(3000); // covers reveal animations + settling
    if(pendingState){const n=pendingState;pendingState=null;updateScene(n);}
requestAnimationFrame(()=>{
        if(typeof window._reprojectAllToppings==='function') window._reprojectAllToppings();
        if(typeof window._reapplySprinkles==='function') window._reapplySprinkles();
        if(typeof window._reapplyChocoCurls==='function') window._reapplyChocoCurls(state.tier, state.shape);
        if(typeof window._reapplyPlaque==='function') window._reapplyPlaque();
        if(typeof window._reapplyCharacterTopper==='function') window._reapplyCharacterTopper();
              if(window._pendingIcingReveal && currentIcing){
            window._pendingIcingReveal = false;
            revealIcingWithWipe(currentIcing, 1800);
        }
              if(window._pendingShellReveal && currentFrost){
            window._pendingShellReveal = false;
            revealShellCircular(currentFrost, 2200);
        }
          if(currentRosette && currentRosette.userData && currentRosette.userData.pendingReveal){
            currentRosette.userData.pendingReveal = false;
            revealShellCircular(currentRosette, 2200);
        }
        if(window._pendingFondantReveal && currentFrost){
            window._pendingFondantReveal = false;
            revealFondantDrape(currentFrost, 2400);
        }
                if(window._pendingDripReveal && currentDrip){
            window._pendingDripReveal = false;
            revealDripFlow(currentDrip, 1600);
        }
        // Re-fit the rosette one more time after everything (stand, matrices) has
        // fully settled — fixes cases where Rosettes is the ONLY base icing (no
        // Shell Border/Sugar Icing layer loaded alongside it), which changes
        // which code path positions the cake and can leave the rosette's scale
        // stale from before the stand/offset was applied.
        if(typeof currentRosette !== 'undefined' && currentRosette && typeof fitRosetteToCake === 'function'){
            const cakeRefNow = (typeof currentBase !== 'undefined' && currentBase) ? currentBase
                              : (typeof currentFrost !== 'undefined' && currentFrost) ? currentFrost
                              : null;
            if(cakeRefNow) fitRosetteToCake(cakeRefNow);
        }
    });
if(pendingState){const n=pendingState;pendingState=null;updateScene(n);}
    } catch(e) { console.error('[updateScene crash]', e); isLoading=false; loadingEl.style.opacity='0'; setTimeout(()=>{loadingEl.style.display='none';},400); sceneRoot.visible=true; }
}
const sprinklesMeshes = { cylinder: null, pearl: null, chocoSprinkle: null, peanuts: null };
const sprinklePlacement = { cylinder: 'top', pearl: 'top', chocoSprinkle: 'top', peanuts: 'top' };
window._sprinklePlacement = sprinklePlacement;
// One Raycaster, reused for every sample point instead of allocating a new
// object (and its internal arrays) hundreds of times per sprinkle rebuild.
const _sharedSurfaceRaycaster = new THREE.Raycaster();
const _sharedSideRaycaster    = new THREE.Raycaster();

function _snapToSurface(x, z) {
    _sharedSurfaceRaycaster.set(
        new THREE.Vector3(x, 20, z),
        new THREE.Vector3(0, -1, 0)
    );
    const meshes = getSprinkleTargetMeshes();
    const hits = _sharedSurfaceRaycaster.intersectObjects(meshes, false);
    if (hits.length === 0) return null;
    hits.sort((a, b) => b.point.y - a.point.y);
    return hits[0].point.y;
}

function _snapToSide(cx, cz, angle, y) {
    const FAR    = 10.0;
    const origin = new THREE.Vector3(
        cx + Math.cos(angle) * FAR,
        y,
        cz + Math.sin(angle) * FAR
    );
    const dir = new THREE.Vector3(-Math.cos(angle), 0, -Math.sin(angle));
    _sharedSideRaycaster.set(origin, dir);
    _sharedSideRaycaster.far = FAR * 2;
    const meshes = getSprinkleTargetMeshes();
    const hits   = _sharedSideRaycaster.intersectObjects(meshes, false);
    if (hits.length === 0) return null;
    hits.sort((a, b) => a.distance - b.distance);
    return hits[0].point;
}

// ── Build a list of candidate top-surface points via dense grid raycasting ──
// This guarantees sprinkles only land on actual cake surface (works for heart, number, any shape)
function _buildSurfacePoints(density) {
    sceneRoot.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(sceneRoot);
    const cx  = (box.min.x + box.max.x) * 0.5;
    const cz  = (box.min.z + box.max.z) * 0.5;
    const rx  = (box.max.x - box.min.x) * 0.52;
    const rz  = (box.max.z - box.min.z) * 0.52;

    const points = []; // { x, y, z, isTop }
    const step   = density; // smaller = denser grid

    for (let xi = -rx; xi <= rx; xi += step) {
        for (let zi = -rz; zi <= rz; zi += step) {
            const wx = cx + xi + (Math.random() - 0.5) * step * 0.8;
            const wz = cz + zi + (Math.random() - 0.5) * step * 0.8;
            const wy = _snapToSurface(wx, wz);
            if (wy !== null) {
                points.push({ x: wx, y: wy, z: wz });
            }
        }
    }
    return points;
}
function buildCylinderSprinkles() {
    if (sprinklesMeshes.cylinder) {
        scene.remove(sprinklesMeshes.cylinder);
        sprinklesMeshes.cylinder = null;
    }

    const COLORS = [
        0xFF4466, 0xFF8C00, 0xFFD700, 0x44DD44,
        0x44AAFF, 0xAA44FF, 0xFF44CC, 0xFFFFFF,
        0xFF6699, 0x00CCFF, 0xFF3300, 0x99FF44,
    ];

    const group = new THREE.Group();
    const ROD_R = 0.010;
    const ROD_L = 0.052;

    if (sprinklePlacement.cylinder === 'top' || sprinklePlacement.cylinder === 'both') {
        const topPoints = _buildSurfacePoints(0.095);
        for (let i = topPoints.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [topPoints[i], topPoints[j]] = [topPoints[j], topPoints[i]];
        }
        const topCount = Math.min(220, topPoints.length);
        for (let i = 0; i < topCount; i++) {
            const { x, y, z } = topPoints[i];
            const geo = new THREE.CylinderGeometry(ROD_R, ROD_R, ROD_L, 7);
            const mat = new THREE.MeshStandardMaterial({
                color: COLORS[Math.floor(Math.random() * COLORS.length)],
                roughness: 0.28, metalness: 0.08, envMapIntensity: 1.0,
            });
            const mesh = new THREE.Mesh(geo, mat);
            mesh.rotation.z = Math.PI / 2;
            mesh.rotation.y = Math.random() * Math.PI * 2;
            mesh.rotation.x = (Math.random() - 0.5) * 0.12;
            mesh.position.set(x, y + ROD_R * 0.5, z);
            mesh.castShadow = true;
            group.add(mesh);
        }
    }

    if (sprinklePlacement.cylinder === 'sides' || sprinklePlacement.cylinder === 'both') {
        sceneRoot.updateMatrixWorld(true);
        const cakeMeshesForBox = getSprinkleTargetMeshes();
        const cakeBox = new THREE.Box3();
        cakeMeshesForBox.forEach(m => cakeBox.expandByObject(m));
        if (cakeBox.isEmpty()) cakeBox.setFromObject(sceneRoot);
        const cakeCX  = (cakeBox.min.x + cakeBox.max.x) * 0.5;
        const cakeCZ  = (cakeBox.min.z + cakeBox.max.z) * 0.5;
        const cakeH   = cakeBox.max.y - cakeBox.min.y;
        // Stratified: divide wall into angle × height cells, place one per cell
        const ANGLE_SEGS = 32;  // slices around circumference
        const HEIGHT_SEGS = 7;  // rows from bottom to top
        for (let ai = 0; ai < ANGLE_SEGS; ai++) {
            for (let hi = 0; hi < HEIGHT_SEGS; hi++) {
                // Jitter within each cell for natural look
                const angleBase  = (ai / ANGLE_SEGS) * Math.PI * 2;
                const angleJitter = (Math.random() - 0.5) * (Math.PI * 2 / ANGLE_SEGS) * 0.85;
                const angle      = angleBase + angleJitter;
                const heightBase = 0.04 + (hi / HEIGHT_SEGS) * 0.88;
                const heightFrac = heightBase + Math.random() * (0.88 / HEIGHT_SEGS) * 0.85;
                const y = cakeBox.min.y + heightFrac * cakeH;
                const hit = _snapToSide(cakeCX, cakeCZ, angle, y);
                if (!hit) continue;
                const geo = new THREE.CylinderGeometry(ROD_R, ROD_R, ROD_L, 7);
                const mat = new THREE.MeshStandardMaterial({
                    color: COLORS[Math.floor(Math.random() * COLORS.length)],
                    roughness: 0.28, metalness: 0.08, envMapIntensity: 1.0,
                });
                const mesh = new THREE.Mesh(geo, mat);
                // Lay the rod on its SIDE (tip the cylinder axis 90° off vertical),
                // then spin it randomly in the plane of the wall so each piece points
                // a different horizontal-ish direction — like a sprinkle stuck flat
                // against frosting, never poking straight out like a quill.
                mesh.rotation.z = Math.PI / 2;
                mesh.rotation.y = Math.random() * Math.PI * 2;
                mesh.rotation.x = (Math.random() - 0.5) * 0.5;
                const cylOut = ROD_R * 0.9; // sits mostly embedded, just barely proud of the wall
                mesh.position.set(
                    hit.x + Math.cos(angle) * cylOut,
                    hit.y + (Math.random() - 0.5) * 0.012,
                    hit.z + Math.sin(angle) * cylOut
                );
                mesh.castShadow = true;
                group.add(mesh);
            }
        }
    }

    scene.add(group);
    sprinklesMeshes.cylinder = group;
}
function buildPearlSprinkles() {
    if (sprinklesMeshes.pearl) {
        scene.remove(sprinklesMeshes.pearl);
        sprinklesMeshes.pearl = null;
    }

    const PEARL_COLORS = [
        { color: 0xFFB8D0, emissive: 0xFF90B8 },
        { color: 0xB8E4FF, emissive: 0x80CCFF },
        { color: 0xFFFBD6, emissive: 0xFFF09A },
        { color: 0xFFD6F0, emissive: 0xFFAADD },
        { color: 0xD8F4FF, emissive: 0xAAE8FF },
        { color: 0xF4F0FF, emissive: 0xDDD0FF },
    ];

    const group     = new THREE.Group();
    const PEARL_MIN = 0.015;
    const PEARL_MAX = 0.024;
if (sprinklePlacement.pearl === 'top' || sprinklePlacement.pearl === 'both') {
        const topPoints = _buildSurfacePoints(0.085);
        for (let i = topPoints.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [topPoints[i], topPoints[j]] = [topPoints[j], topPoints[i]];
        }
        const topCount = Math.min(180, topPoints.length);
        for (let i = 0; i < topCount; i++) {
            const { x, y, z } = topPoints[i];
            const pal  = PEARL_COLORS[Math.floor(Math.random() * PEARL_COLORS.length)];
            const size = PEARL_MIN + Math.random() * (PEARL_MAX - PEARL_MIN);
            const geo  = new THREE.SphereGeometry(size, 9, 9);
            const mat  = new THREE.MeshStandardMaterial({
                color:             new THREE.Color(pal.color),
                emissive:          new THREE.Color(pal.emissive),
                emissiveIntensity: 0.08,
                roughness:         0.05,
                metalness:         0.12,
                envMapIntensity:   1.6,
            });
            const mesh = new THREE.Mesh(geo, mat);
mesh.position.set(x, y + size * 0.5, z);
            mesh.castShadow = true;
            group.add(mesh);
        }
    }

if (sprinklePlacement.pearl === 'sides' || sprinklePlacement.pearl === 'both') {
        sceneRoot.updateMatrixWorld(true);
        const cakeMeshesForBox2 = getSprinkleTargetMeshes();
        const cakeBox = new THREE.Box3();
        cakeMeshesForBox2.forEach(m => cakeBox.expandByObject(m));
        if (cakeBox.isEmpty()) cakeBox.setFromObject(sceneRoot);
        const cakeCX  = (cakeBox.min.x + cakeBox.max.x) * 0.5;
        const cakeCZ  = (cakeBox.min.z + cakeBox.max.z) * 0.5;
        const cakeH   = cakeBox.max.y - cakeBox.min.y;
  // Stratified: divide wall into angle × height cells, place one per cell
        const ANGLE_SEGS_P  = 30;  // slices around circumference
        const HEIGHT_SEGS_P = 7;   // rows from bottom to top
        for (let ai = 0; ai < ANGLE_SEGS_P; ai++) {
            for (let hi = 0; hi < HEIGHT_SEGS_P; hi++) {
                const angleBase   = (ai / ANGLE_SEGS_P) * Math.PI * 2;
                const angleJitter = (Math.random() - 0.5) * (Math.PI * 2 / ANGLE_SEGS_P) * 0.85;
                const angle       = angleBase + angleJitter;
                const heightBase  = 0.04 + (hi / HEIGHT_SEGS_P) * 0.88;
                const heightFrac  = heightBase + Math.random() * (0.88 / HEIGHT_SEGS_P) * 0.85;
                const y = cakeBox.min.y + heightFrac * cakeH;
                const hit = _snapToSide(cakeCX, cakeCZ, angle, y);
                if (!hit) continue;
                const pal  = PEARL_COLORS[Math.floor(Math.random() * PEARL_COLORS.length)];
                const size = PEARL_MIN + Math.random() * (PEARL_MAX - PEARL_MIN);
                const geo  = new THREE.SphereGeometry(size, 9, 9);
                const mat  = new THREE.MeshStandardMaterial({
                    color:             new THREE.Color(pal.color),
                    emissive:          new THREE.Color(pal.emissive),
                    emissiveIntensity: 0.07,
                    roughness:         0.05,
                    metalness:         0.12,
                    envMapIntensity:   1.6,
                });
                const mesh = new THREE.Mesh(geo, mat);
                const pearlOut = size * 0.5;
                mesh.position.set(
                    hit.x + Math.cos(angle) * pearlOut,
                    hit.y,
                    hit.z + Math.sin(angle) * pearlOut
                );
                mesh.castShadow = true;
                group.add(mesh);
            }
        }
    }

    scene.add(group);
    sprinklesMeshes.pearl = group;
}

// ── Chocolate Sprinkles — same rod style as Cylinder Sprinkles, single dark choco tone ──
function buildChocoSprinkles() {
    if (sprinklesMeshes.chocoSprinkle) {
        scene.remove(sprinklesMeshes.chocoSprinkle);
        sprinklesMeshes.chocoSprinkle = null;
    }
    const CHOCO_COLOR = 0x2A1206;
    const group = new THREE.Group();
    const ROD_R = 0.010;
    const ROD_L = 0.050;

    if (sprinklePlacement.chocoSprinkle === 'top' || sprinklePlacement.chocoSprinkle === 'both') {
        const topPoints = _buildSurfacePoints(0.095);
        for (let i = topPoints.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [topPoints[i], topPoints[j]] = [topPoints[j], topPoints[i]];
        }
        const topCount = Math.min(220, topPoints.length);
        for (let i = 0; i < topCount; i++) {
            const { x, y, z } = topPoints[i];
            const geo = new THREE.CylinderGeometry(ROD_R, ROD_R, ROD_L, 7);
            const mat = new THREE.MeshStandardMaterial({ color: CHOCO_COLOR, roughness: 0.32, metalness: 0.06, envMapIntensity: 0.85 });
            const mesh = new THREE.Mesh(geo, mat);
            mesh.rotation.z = Math.PI / 2;
            mesh.rotation.y = Math.random() * Math.PI * 2;
            mesh.rotation.x = (Math.random() - 0.5) * 0.12;
            mesh.position.set(x, y + ROD_R * 0.5, z);
            mesh.castShadow = true;
            group.add(mesh);
        }
    }
    if (sprinklePlacement.chocoSprinkle === 'sides' || sprinklePlacement.chocoSprinkle === 'both') {
        sceneRoot.updateMatrixWorld(true);
        const cakeMeshesForBox = getSprinkleTargetMeshes();
        const cakeBox = new THREE.Box3();
        cakeMeshesForBox.forEach(m => cakeBox.expandByObject(m));
        if (cakeBox.isEmpty()) cakeBox.setFromObject(sceneRoot);
        const cakeCX = (cakeBox.min.x + cakeBox.max.x) * 0.5;
        const cakeCZ = (cakeBox.min.z + cakeBox.max.z) * 0.5;
        const cakeH  = cakeBox.max.y - cakeBox.min.y;
        const ANGLE_SEGS = 32, HEIGHT_SEGS = 7;
        for (let ai = 0; ai < ANGLE_SEGS; ai++) {
            for (let hi = 0; hi < HEIGHT_SEGS; hi++) {
                const angleBase = (ai / ANGLE_SEGS) * Math.PI * 2;
                const angle = angleBase + (Math.random() - 0.5) * (Math.PI * 2 / ANGLE_SEGS) * 0.85;
                const heightBase = 0.04 + (hi / HEIGHT_SEGS) * 0.88;
                const heightFrac = heightBase + Math.random() * (0.88 / HEIGHT_SEGS) * 0.85;
                const y = cakeBox.min.y + heightFrac * cakeH;
                const hit = _snapToSide(cakeCX, cakeCZ, angle, y);
                if (!hit) continue;
                 const geo = new THREE.CylinderGeometry(ROD_R, ROD_R, ROD_L, 7);
                const mat = new THREE.MeshStandardMaterial({ color: CHOCO_COLOR, roughness: 0.32, metalness: 0.06, envMapIntensity: 0.85 });
                const mesh = new THREE.Mesh(geo, mat);
                // Lay the rod on its side and spin it randomly in the wall's plane —
                // flush against the frosting, random horizontal-ish orientation,
                // never poking straight outward.
                mesh.rotation.z = Math.PI / 2;
                mesh.rotation.y = Math.random() * Math.PI * 2;
                mesh.rotation.x = (Math.random() - 0.5) * 0.5;
                const cylOut = ROD_R * 0.9;
                mesh.position.set(hit.x + Math.cos(angle) * cylOut, hit.y + (Math.random() - 0.5) * 0.012, hit.z + Math.sin(angle) * cylOut);
                mesh.castShadow = true;
                group.add(mesh);
            }
        }
    }
    scene.add(group);
    sprinklesMeshes.chocoSprinkle = group;
}
// ── Crushed Peanuts — dense-looking crushed topping built cheaply via
// InstancedMesh. Raycasting stays at the same coarse density as the other
// decorations (fruits/sprinkles); we get the "extra dense" look by spawning a
// small cluster of jittered chunks per sampled point, then batching ALL chunks
// into one InstancedMesh per color (4 draw calls total) instead of thousands
// of individual Mesh/geometry/material objects — that per-object overhead
// (plus the old ultra-fine raycast grid) is what was freezing the page. ──
function buildCrushedPeanuts() {
    if (sprinklesMeshes.peanuts) {
        scene.remove(sprinklesMeshes.peanuts);
        sprinklesMeshes.peanuts = null;
    }
    const PEANUT_COLORS = [0xC89860, 0xB8804A, 0xD4A66E, 0xA06E3C];
    const group = new THREE.Group();
    const CHUNK_MIN = 0.008;
    const CHUNK_MAX = 0.016;
    const CLUSTER_PER_POINT = 15; // same cluster count for top AND sides so density matches on both

    // One shared unit geometry, reused (scaled per-instance) across every peanut —
    // avoids allocating thousands of separate BufferGeometries.
    if (!window._peanutBaseGeo) window._peanutBaseGeo = new THREE.DodecahedronGeometry(1, 0);
    const baseGeo = window._peanutBaseGeo;
    const mats = PEANUT_COLORS.map(c => new THREE.MeshStandardMaterial({
        color: c, roughness: 0.62, metalness: 0.01, envMapIntensity: 0.55,
    }));

    // Gather placement transforms first (cheap raycasts), batch into InstancedMesh after.
    const byColor = [[], [], [], []];
    const dummy = new THREE.Object3D();

    if (sprinklePlacement.peanuts === 'top' || sprinklePlacement.peanuts === 'both') {
        const topPoints = _buildSurfacePoints(0.095); // identical raycast cost to Cylinder Sprinkles
        for (let i = topPoints.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [topPoints[i], topPoints[j]] = [topPoints[j], topPoints[i]];
        }
        const topCount = Math.min(220, topPoints.length); // same cap as Cylinder Sprinkles
        for (let i = 0; i < topCount; i++) {
            const { x, y, z } = topPoints[i];
            for (let c = 0; c < CLUSTER_PER_POINT; c++) {
                const size = CHUNK_MIN + Math.random() * (CHUNK_MAX - CHUNK_MIN);
                const jx = (Math.random() - 0.5) * 0.06;
                const jz = (Math.random() - 0.5) * 0.06;
                const colorIdx = Math.floor(Math.random() * PEANUT_COLORS.length);
                dummy.position.set(x + jx, y + size * 0.28, z + jz);
                dummy.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, Math.random() * Math.PI);
                dummy.scale.set(size, size * 0.62, size);
                dummy.updateMatrix();
                byColor[colorIdx].push(dummy.matrix.clone());
            }
        }
    }

    if (sprinklePlacement.peanuts === 'sides' || sprinklePlacement.peanuts === 'both') {
        sceneRoot.updateMatrixWorld(true);
        const cakeMeshesForBox = getSprinkleTargetMeshes();
        const cakeBox = new THREE.Box3();
        cakeMeshesForBox.forEach(m => cakeBox.expandByObject(m));
        if (cakeBox.isEmpty()) cakeBox.setFromObject(sceneRoot);
        const cakeCX = (cakeBox.min.x + cakeBox.max.x) * 0.5;
        const cakeCZ = (cakeBox.min.z + cakeBox.max.z) * 0.5;
        const cakeH  = cakeBox.max.y - cakeBox.min.y;
        const ANGLE_SEGS = 40, HEIGHT_SEGS = 11; // close to Cylinder Sprinkles' side cost, slightly denser grid
        for (let ai = 0; ai < ANGLE_SEGS; ai++) {
            for (let hi = 0; hi < HEIGHT_SEGS; hi++) {
                const angleBase = (ai / ANGLE_SEGS) * Math.PI * 2;
                const angle = angleBase + (Math.random() - 0.5) * (Math.PI * 2 / ANGLE_SEGS) * 0.85;
                const heightBase = 0.04 + (hi / HEIGHT_SEGS) * 0.88;
                const heightFrac = heightBase + Math.random() * (0.88 / HEIGHT_SEGS) * 0.85;
                const y = cakeBox.min.y + heightFrac * cakeH;
                const hit = _snapToSide(cakeCX, cakeCZ, angle, y);
                if (!hit) continue;
                // Wide jitter per cluster point — wider than the grid spacing itself —
                // so neighboring clusters overlap and blend into a continuous random
                // scatter (matching the top's organic look) instead of visible dotted
                // rows/columns tracing the raycast grid.
                const angleStep = (Math.PI * 2 / ANGLE_SEGS);
                const heightStep = (0.88 / HEIGHT_SEGS) * cakeH;
                for (let c = 0; c < CLUSTER_PER_POINT; c++) {
                    const size = CHUNK_MIN + Math.random() * (CHUNK_MAX - CHUNK_MIN);
                    const chunkOut = size * 0.5;
                    const jAngle = angle + (Math.random() - 0.5) * angleStep * 1.3;
                    const jY = (Math.random() - 0.5) * heightStep * 1.3;
                    const colorIdx = Math.floor(Math.random() * PEANUT_COLORS.length);
                    dummy.position.set(hit.x + Math.cos(jAngle) * chunkOut, hit.y + jY, hit.z + Math.sin(jAngle) * chunkOut);
                    dummy.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, Math.random() * Math.PI);
                    dummy.scale.set(size, size, size);
                    dummy.updateMatrix();
                    byColor[colorIdx].push(dummy.matrix.clone());
                }
            }
        }
    }

    // Batch each color into a single InstancedMesh — 4 draw calls total, however
    // many thousand peanuts are placed.
    byColor.forEach((matrices, idx) => {
        if (matrices.length === 0) return;
        const inst = new THREE.InstancedMesh(baseGeo, mats[idx], matrices.length);
        inst.castShadow = true;
        matrices.forEach((m, i) => inst.setMatrixAt(i, m));
        inst.instanceMatrix.needsUpdate = true;
        group.add(inst);
    });

    scene.add(group);
    sprinklesMeshes.peanuts = group;
}
function clearSprinkles(type) {
    if (type === 'cylinder' && sprinklesMeshes.cylinder) {
        scene.remove(sprinklesMeshes.cylinder);
        sprinklesMeshes.cylinder = null;
    }
    if (type === 'pearl' && sprinklesMeshes.pearl) {
        scene.remove(sprinklesMeshes.pearl);
        sprinklesMeshes.pearl = null;
    }
    if (type === 'chocoSprinkle' && sprinklesMeshes.chocoSprinkle) {
        scene.remove(sprinklesMeshes.chocoSprinkle);
        sprinklesMeshes.chocoSprinkle = null;
    }
    if (type === 'peanuts' && sprinklesMeshes.peanuts) {
        scene.remove(sprinklesMeshes.peanuts);
        sprinklesMeshes.peanuts = null;
    }
}

window.buildCylinderSprinkles = buildCylinderSprinkles;
window.buildPearlSprinkles    = buildPearlSprinkles;
window.buildChocoSprinkles    = buildChocoSprinkles;
window.buildCrushedPeanuts    = buildCrushedPeanuts;
window.clearSprinkles         = clearSprinkles;

document.querySelectorAll('.sprinkle-place-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const type      = btn.dataset.type;      // 'cylinder' or 'pearl'
        const placement = btn.dataset.placement; // 'top','sides','both'

        // Rosette placement can lock out certain sprinkle placements.
        if(typeof rosetteBlocksAddon === 'function'){
            const _rReason = rosetteBlocksAddon('sprinkle', placement);
            if(_rReason){ if(typeof showToast === 'function') showToast('⚠ '+_rReason, 2600); return; }
        }

        // Update state
        sprinklePlacement[type] = placement;

        // Sync button styles within this group
        document.querySelectorAll(`.sprinkle-place-btn[data-type="${type}"]`).forEach(b => {
            const on = b.dataset.placement === placement;
            b.style.background = on ? 'var(--caramel)' : 'var(--surface)';
            b.style.color      = on ? '#fff'           : 'var(--text-muted)';
            b.style.fontWeight = on ? '700'            : '600';
        });

        // Rebuild the active sprinkle
        if (type === 'cylinder' && sprinklesMeshes.cylinder) {
            scene.remove(sprinklesMeshes.cylinder);
            sprinklesMeshes.cylinder = null;
            buildCylinderSprinkles();
        }
        if (type === 'pearl' && sprinklesMeshes.pearl) {
            scene.remove(sprinklesMeshes.pearl);
            sprinklesMeshes.pearl = null;
            buildPearlSprinkles();
        }
        if (type === 'chocoSprinkle' && sprinklesMeshes.chocoSprinkle) {
            scene.remove(sprinklesMeshes.chocoSprinkle);
            sprinklesMeshes.chocoSprinkle = null;
            buildChocoSprinkles();
        }
        if (type === 'peanuts' && sprinklesMeshes.peanuts) {
            scene.remove(sprinklesMeshes.peanuts);
            sprinklesMeshes.peanuts = null;
            buildCrushedPeanuts();
        }
    });
});
// Re-apply active sprinkles after cake model reloads
const _origUpdateScene = window.updateModel;
window._reapplySprinkles = function() {
    if (sprinklesMeshes.cylinder)     { scene.remove(sprinklesMeshes.cylinder);     sprinklesMeshes.cylinder     = null; buildCylinderSprinkles(); }
    if (sprinklesMeshes.pearl)        { scene.remove(sprinklesMeshes.pearl);        sprinklesMeshes.pearl        = null; buildPearlSprinkles(); }
    if (sprinklesMeshes.chocoSprinkle){ scene.remove(sprinklesMeshes.chocoSprinkle);sprinklesMeshes.chocoSprinkle= null; buildChocoSprinkles(); }
    if (sprinklesMeshes.peanuts)      { scene.remove(sprinklesMeshes.peanuts);      sprinklesMeshes.peanuts      = null; buildCrushedPeanuts(); }
};
const decoGLBCache={};
const decoGLBLoadingPromises={};
function _cloneDecoScene(scene){const c=scene.clone(true);c.traverse(x=>{if(x.isMesh&&x.material)x.material=x.material.clone();});return c;}
function loadDecoGLB(url){
    if(decoGLBCache[url]) return Promise.resolve(_cloneDecoScene(decoGLBCache[url]));
    if(decoGLBLoadingPromises[url]) return decoGLBLoadingPromises[url].then(_cloneDecoScene);
    const p=new Promise((resolve,reject)=>{
        new GLTFLoader().load(url,gltf=>{
            decoGLBCache[url]=gltf.scene;
            delete decoGLBLoadingPromises[url];
            resolve(gltf.scene);
        },undefined,err=>{delete decoGLBLoadingPromises[url];console.error('[Deco]',url,err);reject(err);});
    });
    decoGLBLoadingPromises[url]=p;
    return p.then(_cloneDecoScene);
}
// yNudge = extra downward push, as a fraction of cake diameter, applied on
// top of the normal sink calc. Increase it to pull a floating piece DOWN;
// decrease (or make negative) to lift it back UP if it sinks too far.
const CHOCO_CURLS_CONFIG = {
    middle: [ { file:'chococurls_center',       diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 } ],
    sides:  [ { file:'chococurls_circle_around', diamMult:1.35, sitOnTop:true, sinkFrac:0.15, yNudge:0.15 } ],
    both:   [
        { file:'chococurls_center',       diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 },
        { file:'chococurls_circle_around', diamMult:1.35, sitOnTop:true, sinkFrac:0.15, yNudge:0.15 },
    ],
};
// Two-tier variant — a single combined mesh with rings sized for BOTH tier
// edges already built at the correct relative offset (per the Blender
// reference), so it's positioned as one group instead of stacking two rings.
const CHOCO_CURLS_CONFIG_TWO_TIER = {
    middle:[ { file:'chococurls_center',           diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 } ],
    sides: [ { file:'chococurls_two-tier_around', diamMult:1.35, sitOnTop:true, sinkFrac:0.15, yNudge:0.40 } ],
    both:  [
        { file:'chococurls_center',           diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 },
        { file:'chococurls_two-tier_around',  diamMult:1.35, sitOnTop:true, sinkFrac:0.15, yNudge:0.40 },
    ],
};
// Three-tier variant — same idea as two-tier: one combined mesh covering all
// three tier edges at once, built at the correct relative offsets in Blender.
// Starting values copied from the two-tier config — tune diamMult (width)
// and yNudge (height) the same way once you see it in the preview.
const CHOCO_CURLS_CONFIG_THREE_TIER = {
    middle:[ { file:'chococurls_center',             diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 } ],
    sides: [ { file:'chococurls_three-tier_around', diamMult:1.35, sitOnTop:true, sinkFrac:0.15, yNudge:0.54 } ],
    both:  [
        { file:'chococurls_center',             diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 },
        { file:'chococurls_three-tier_around',  diamMult:1.35, sitOnTop:true, sinkFrac:0.15, yNudge:0.54 },
    ],
};
// Square variant — a single mesh built to trace a square cake's edge instead
// of a circular one. Starting values copied from the round "sides" config —
// tune diamMult (width) / sinkFrac / yNudge once you see it against the cake.
const CHOCO_CURLS_CONFIG_SQUARE = {
    middle: [ { file:'chococurls_center',        diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 } ],
    sides:  [ { file:'chococurls_square_around', diamMult:1.62, sitOnTop:true, sinkFrac:0.15, yNudge:0.52 } ],
    both:   [
        { file:'chococurls_center',        diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 },
        { file:'chococurls_square_around', diamMult:1.62, sitOnTop:true, sinkFrac:0.15, yNudge:0.52 },
    ],
};
const CHOCO_CURLS_CONFIG_HEART = {
    middle: [ { file:'chococurls_center',       diamMult:1.50, sitOnTop:true, sinkFrac:1.55, yNudge:0.45 } ],
    sides:  [ { file:'chococurls_heart_around', diamMult:0.90, sitOnTop:true, sinkFrac:0.15, yNudge:0.01 } ],
    both:   [
        { file:'chococurls_center',       diamMult:0.50, sitOnTop:true, sinkFrac:0.48, yNudge:0 },
        { file:'chococurls_heart_around', diamMult:0.90, sitOnTop:true, sinkFrac:0.15, yNudge:0.01 },
    ]
};
const CHOCO_CURLS_CONFIG_BUNDT = {
    middle: [ { file:'chococurls_bundt_center', diamMult:0.50, sitOnTop:true, sinkFrac:0.57, yNudge:-0.01 } ],
    sides:  [ { file:'chococurls_bundt_around', diamMult:0.9, sitOnTop:true, sinkFrac:0.42, yNudge:0.1 } ],
    both:   [
        { file:'chococurls_bundt_center', diamMult:0.50, sitOnTop:true, sinkFrac:0.57, yNudge:-0.01 },
        { file:'chococurls_bundt_around', diamMult:0.9, sitOnTop:true, sinkFrac:0.42, yNudge:0.1 },
    ]
};
// Digits with no dedicated "center" (middle) model — Middle and Both get hidden
// for these, leaving Sides as the only placement option.
const CHOCO_CURLS_NO_MIDDLE_DIGITS = [1,2,3,5,7];
function updateChocoCurlsPlacementAvailability(){
    if(typeof state === 'undefined') return;
    const middleBtn = document.querySelector('.choco-curls-place-btn[data-placement="middle"]');
    const sidesBtn  = document.querySelector('.choco-curls-place-btn[data-placement="sides"]');
    const bothBtn   = document.querySelector('.choco-curls-place-btn[data-placement="both"]');
    if(!middleBtn || !sidesBtn || !bothBtn) return;
    const isRestricted = state.shape === 'Number' && state.numberDigits === 1 && CHOCO_CURLS_NO_MIDDLE_DIGITS.includes(state.numberChoice);
    middleBtn.style.display = isRestricted ? 'none' : '';
    bothBtn.style.display   = isRestricted ? 'none' : '';
    if(isRestricted && state.chocoCurlsPlacement !== 'sides'){
        state.chocoCurlsPlacement = 'sides';
        [middleBtn, sidesBtn, bothBtn].forEach(b=>b.classList.remove('active'));
        sidesBtn.classList.add('active');
        sidesBtn.style.background = 'var(--gold)'; sidesBtn.style.color = '#fff';
        middleBtn.style.background = 'var(--surface)'; middleBtn.style.color = 'var(--text-muted)';
        bothBtn.style.background = 'var(--surface)'; bothBtn.style.color = 'var(--text-muted)';
        if(state.addons && state.addons.has('Chocolate Curls') && typeof window.placeChocoCurls==='function'){
            window.placeChocoCurls('sides', state.tier, state.shape);
        }
    }
}
window._updateChocoCurlsPlacementAvailability = updateChocoCurlsPlacementAvailability;
window.placeChocoCurls = async function(placement, tier, shape, animate){
    if(animate === undefined) animate = true;
    currentChocoCurlsTier  = tier  || 'Single';
    currentChocoCurlsShape = shape || 'Round';
 const configSet = currentChocoCurlsShape === 'Bundt'  ? CHOCO_CURLS_CONFIG_BUNDT
                     : currentChocoCurlsShape === 'Square' ? CHOCO_CURLS_CONFIG_SQUARE
                     : currentChocoCurlsShape === 'Heart'  ? CHOCO_CURLS_CONFIG_HEART
                     : currentChocoCurlsTier === 'Two-tier'   ? CHOCO_CURLS_CONFIG_TWO_TIER
                     : currentChocoCurlsTier === 'Three-tier' ? CHOCO_CURLS_CONFIG_THREE_TIER
                     : CHOCO_CURLS_CONFIG;
// Fall back through middle → sides → both → first available key, so an
// unconfigured placement for a given shape/tier never leaves `parts`
// undefined and silently crashing the whole function.
let parts = configSet[placement] || configSet.middle || configSet.sides || configSet.both || Object.values(configSet)[0];
if(!parts){
    console.error('[ChocoCurls] No config available at all for', currentChocoCurlsShape, currentChocoCurlsTier, placement);
    return false;
}
    // Number-shape digit-specific pieces — e.g. chococurls_0_center.glb (middle) and
    // chococurls_0_around.glb (sides) for digit 0. Add an entry per digit here to
    // tune each piece's own size/position independently — any field you omit falls
    // back to the generic chococurls_center / chococurls_circle_around values above.
   const CHOCO_CURLS_NUMBER_OVERRIDES = {
        0: {
            center: { diamMult:0.70, sinkFrac:0.50, yNudge:0 },
           around: { diamMult:1.08, sinkFrac:0.21, yNudge:0.10 },
        },
        1: {
          around: { diamMult:0.9, sinkFrac:0.25, yNudge:0.10 },
        },
       2: {
    around: { diamMult:1.20, sinkFrac:0.30, yNudge:0.14, xNudge:0.04, zNudge:0.06 },
},
3: {
          around: { diamMult:1.10, sinkFrac:0.18, yNudge:0.10 },
        },
         4: {
            center: { diamMult:0.20, sinkFrac:0.57, yNudge:0, xNudge:-0.04, zNudge:0.01 },
           around: { diamMult:0.95, sinkFrac:0.38, yNudge:0.10 },
        },
        5: {
          around: { diamMult:1.28, sinkFrac:0.33, yNudge:0.10, xNudge:0.03, zNudge:-0.05 },
        },
       6: {
        center: { diamMult:0.40, sinkFrac:0.52, yNudge:-0.02, xNudge:0.02, zNudge:0.16 },
        around: { diamMult:1.2, sinkFrac:0.33, yNudge:0.1, xNudge:0.01, zNudge:0.02 },
    },
    7: {
          around: { diamMult:1.25, sinkFrac:0.35, yNudge:0.10, xNudge:-0.10, zNudge:-0.07 },
        },
         8: {
        center: { diamMult:0.68, sinkFrac:0.55, yNudge:-0.02, xNudge:0.01, zNudge:-0.01 },
        around: { diamMult:1.03, sinkFrac:0.30, yNudge:0.1, xNudge:-0.01, zNudge:0.00 },
    }, 
    9: {
        center: { diamMult:0.38, sinkFrac:0.55, yNudge:-0.02, xNudge:-0.02, zNudge:-0.16 },
        around: { diamMult:1.18, sinkFrac:0.33, yNudge:0.1, xNudge:-0.01, zNudge:0.011 },
    },
    };
    if(currentChocoCurlsShape === 'Number' && typeof state !== 'undefined' && state.numberDigits === 1){
        const _digit = state.numberChoice;
        const _ov = CHOCO_CURLS_NUMBER_OVERRIDES[_digit] || {};
        parts = parts.map(p => {
            if(p.file === 'chococurls_center'){
                const { file:_centerFile, ..._centerRest } = _ov.center || {};
                return { ...p, ..._centerRest, file: _centerFile || `chococurls_${_digit}_center` };
            }
            if(p.file === 'chococurls_circle_around'){
                const { file:_aroundFile, ..._aroundRest } = _ov.around || {};
                return { ...p, ..._aroundRest, file: _aroundFile || `chococurls_${_digit}_around` };
            }
            return p;
        });
    }
    try{
        const cakeRef = currentBase || currentFrost;
        if(!cakeRef) return false;
        cakeRef.updateMatrixWorld(true);
        const cakeBox = new THREE.Box3().setFromObject(cakeRef);
        const cakeCenter = cakeBox.getCenter(new THREE.Vector3());
        const cakeDiameter = Math.max(cakeBox.max.x - cakeBox.min.x, cakeBox.max.z - cakeBox.min.z);

        // Clear any previously placed curl piece(s) before loading the new set
        if(currentChocoCurls && currentChocoCurls.length){
            currentChocoCurls.forEach(obj=>scene.remove(obj));
        }
        currentChocoCurls = [];

      // ── Realistic dark chocolate curl color — override whatever material the GLB came with ──
        const CURL_BASE   = new THREE.Color('#22100A');
        const CURL_HILITE = new THREE.Color('#3D2416');

        for(const part of parts){
            const url = `/models/${part.file}.glb`;
            const fg = await loadDecoGLB(url);
            fg.traverse(c=>{ if(c.isMesh){ c.castShadow=true; c.receiveShadow=true; } });
            fg.position.set(0,0,0); fg.rotation.set(0,0,0); fg.scale.set(1,1,1);
            fg.updateMatrixWorld(true);

            const rawBox  = new THREE.Box3().setFromObject(fg);
            const rawSize = rawBox.getSize(new THREE.Vector3());
            const rawDiam = Math.max(rawSize.x, rawSize.z);

            const targetDiam = cakeDiameter * part.diamMult;
            const targetY    = part.sitOnTop ? cakeBox.max.y : cakeCenter.y;

            const scale = rawDiam > 0.0001 ? targetDiam / rawDiam : 1.0;
            fg.scale.setScalar(scale);
            fg.updateMatrixWorld(true);

           const scaledBox    = new THREE.Box3().setFromObject(fg);
            const scaledCenter = scaledBox.getCenter(new THREE.Vector3());
            const scaledSize   = scaledBox.getSize(new THREE.Vector3());
            // Sink the piece into the frosting relative to ITS OWN height.
            const sinkAmount = part.sitOnTop ? scaledSize.y * (part.sinkFrac ?? 0.48) : 0;
            const yNudgeAmount = cakeDiameter * (part.yNudge || 0);
            // xNudge/zNudge — horizontal offsets, same fraction-of-diameter convention
            // as yNudge. diamMult only changes SIZE (the piece is always re-centered on
            // the cake's X/Z center afterward), so these are the only way to shift it
            // sideways to line up with an off-center numeral shape like "2".
            const xNudgeAmount = cakeDiameter * (part.xNudge || 0);
            const zNudgeAmount = cakeDiameter * (part.zNudge || 0);
            const offsetY = (part.sitOnTop ? (targetY - scaledBox.min.y - sinkAmount) : (targetY - scaledCenter.y)) - yNudgeAmount;

            fg.position.set(
                cakeCenter.x - scaledCenter.x + xNudgeAmount,
                offsetY,
                cakeCenter.z - scaledCenter.z + zNudgeAmount
            );
            fg.updateMatrixWorld(true);

            fg.traverse(c=>{
                if(!c.isMesh) return;
                if(c.material){ if(c.material.map) c.material.map.dispose(); c.material.dispose(); }
          c.material = new THREE.MeshStandardMaterial({
                    color: CURL_BASE,
                    roughness: 0.52,
                    metalness: 0.02,
                    envMapIntensity: 0.75,
                    emissive: CURL_HILITE,
                    emissiveIntensity: 0.02,
                });
                c.castShadow = true;
                c.receiveShadow = true;
            });

            scene.add(fg);
            currentChocoCurls.push(fg);
        }

        currentChocoCurlsPlacement = placement;
        if(animate) revealChocoCurlsShred(currentChocoCurls, 1400);
        return true;
    }catch(err){
        console.error('[ChocoCurls]', placement, err);
        if(typeof showToast === 'function') showToast('⚠ Choco Curls model failed to load — check /models/ path', 3000);
        return false;
    }
};
window.clearChocoCurls = function(){
    if(currentChocoCurls && currentChocoCurls.length){
        currentChocoCurls.forEach(obj=>scene.remove(obj));
    }
    currentChocoCurls = [];
    currentChocoCurlsPlacement = null;
};
window._reapplyChocoCurls = function(tier, shape){
    if(tier !== undefined) currentChocoCurlsTier = tier;
    if(shape !== undefined) currentChocoCurlsShape = shape;
    if(currentChocoCurls && currentChocoCurls.length){
        const placement = currentChocoCurlsPlacement || 'middle';
        // Retry a few times in case this fires before the newly-reloaded cake
        // mesh (currentBase/currentFrost) is fully in place.
        // animate=false — this path runs on every cake reload (shape/size/
        // flavor/tier changes), not just when the user clicks Choco Curls,
        // so the shred animation must not replay here.
        const _tryReapply=(attempts)=>{
            window.placeChocoCurls(placement, currentChocoCurlsTier, currentChocoCurlsShape, false).then(ok=>{
                if(!ok && attempts>0) setTimeout(()=>_tryReapply(attempts-1),200);
            }).catch(()=>{
                if(attempts>0) setTimeout(()=>_tryReapply(attempts-1),200);
            });
        };
        _tryReapply(15);
    }
};

// ── CHOCOLATE PLAQUE — single flat piece, auto-centered on top of the cake ──
let currentPlaque = null;
const PLAQUE_SHAPE_FILE_MAP = {
    'Square':'plaque_square','Rectangle':'plaque_rectangle','Circle':'plaque_circle',
    'Heart':'plaque_heart','Oval':'plaque_oval',
};
window.placePlaqueOnCake = async function(shapeKey){
    const file = PLAQUE_SHAPE_FILE_MAP[shapeKey] || 'plaque_square';
    try{
        const cakeRef = currentBase || currentFrost;
        if(!cakeRef) return false;
        cakeRef.updateMatrixWorld(true);
        const cakeBox = new THREE.Box3().setFromObject(cakeRef);
        const cakeCenter = cakeBox.getCenter(new THREE.Vector3());
        const cakeDiameter = Math.max(cakeBox.max.x - cakeBox.min.x, cakeBox.max.z - cakeBox.min.z);

        if(currentPlaque){ scene.remove(currentPlaque); currentPlaque = null; }

   const fg = await loadDecoGLB(`/models/${file}.glb`);
        const PLAQUE_BASE   = new THREE.Color('#22100A');
        const PLAQUE_HILITE = new THREE.Color('#3D2416');
        fg.traverse(c=>{
            if(!c.isMesh) return;
            if(c.material){ if(c.material.map) c.material.map.dispose(); c.material.dispose(); }
            c.material = new THREE.MeshStandardMaterial({
                color: PLAQUE_BASE,
                roughness: 0.52,
                metalness: 0.02,
                envMapIntensity: 0.75,
                emissive: PLAQUE_HILITE,
                emissiveIntensity: 0.02,
            });
            c.castShadow = true;
            c.receiveShadow = true;
        });
        fg.position.set(0,0,0); fg.rotation.set(0,0,0); fg.scale.set(1,1,1);
        fg.updateMatrixWorld(true);

        const rawBox  = new THREE.Box3().setFromObject(fg);
        const rawSize = rawBox.getSize(new THREE.Vector3());
        const rawDiam = Math.max(rawSize.x, rawSize.z);
        const targetDiam = cakeDiameter * 0.42;
        const scale = rawDiam > 0.0001 ? targetDiam / rawDiam : 1.0;
        fg.scale.setScalar(scale);
        fg.updateMatrixWorld(true);

        const scaledBox    = new THREE.Box3().setFromObject(fg);
        const scaledCenter = scaledBox.getCenter(new THREE.Vector3());
        const scaledSize   = scaledBox.getSize(new THREE.Vector3());
        const sinkAmount   = scaledSize.y * 0.15;
        const offsetY = cakeBox.max.y - scaledBox.min.y - sinkAmount;

        fg.position.set(
            cakeCenter.x - scaledCenter.x,
            offsetY,
            cakeCenter.z - scaledCenter.z
        );
        fg.updateMatrixWorld(true);

        scene.add(fg);
        currentPlaque = fg;
        return true;
    }catch(err){
        console.error('[Plaque]', shapeKey, err);
        if(typeof showToast === 'function') showToast('⚠ Plaque model failed to load — check /models/ path', 3000);
        return false;
    }
};
window.clearPlaque = function(){
    if(currentPlaque){ scene.remove(currentPlaque); currentPlaque = null; }
    if(typeof window.clearPlaqueMessage === 'function') window.clearPlaqueMessage();
};
let currentPlaqueText = null;
function buildPlaqueTextTexture(text){
    const canvas = document.createElement('canvas');
    canvas.width = 512; canvas.height = 256;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0,0,canvas.width,canvas.height);
    const lines = (text || '').split('\n').slice(0,3).map(l=>l.trim());
    const hasText = lines.some(l=>l.length>0);
    if(hasText){
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
     const lineCount = lines.length;
        let fontSize = lineCount===1 ? 130 : lineCount===2 ? 100 : 78;
        const fitFont = size => `700 ${size}px "Dancing Script", cursive`;
        ctx.font = fitFont(fontSize);
        let maxWidth = Math.max(...lines.map(l=>ctx.measureText(l).width));
        while(maxWidth > canvas.width*0.94 && fontSize > 16){
            fontSize -= 2;
            ctx.font = fitFont(fontSize);
            maxWidth = Math.max(...lines.map(l=>ctx.measureText(l).width));
        }
        const maxTotalHeight = canvas.height*0.90;
        while(fontSize*1.08*lineCount > maxTotalHeight && fontSize > 16){
            fontSize -= 2;
            ctx.font = fitFont(fontSize);
        }
        const lineHeight = fontSize * 1.08;
        const totalHeight = lineHeight * lineCount;
        const startY = (canvas.height - totalHeight)/2 + lineHeight/2;
        ctx.fillStyle = '#FFFFFF';
        ctx.shadowColor = 'rgba(0,0,0,0.35)';
        ctx.shadowBlur = 4;
        ctx.shadowOffsetY = 1;
        lines.forEach((line, i)=>{
            ctx.fillText(line, canvas.width/2, startY + i*lineHeight);
        });
        ctx.shadowColor = 'transparent';
        ctx.shadowBlur = 0;
        ctx.shadowOffsetY = 0;
    }
    const tex = new THREE.CanvasTexture(canvas);
    tex.needsUpdate = true;
    return tex;
}
window.setPlaqueMessage = function(text){
    if(currentPlaqueText){
        scene.remove(currentPlaqueText);
        currentPlaqueText.geometry.dispose();
        if(currentPlaqueText.material.map) currentPlaqueText.material.map.dispose();
        currentPlaqueText.material.dispose();
        currentPlaqueText = null;
    }
    if(!currentPlaque || !text || !text.trim()) return;
    currentPlaque.updateMatrixWorld(true);
    const box = new THREE.Box3().setFromObject(currentPlaque);
    const size = box.getSize(new THREE.Vector3());
    const center = box.getCenter(new THREE.Vector3());
    const planeW = Math.max(size.x, 0.01) * 0.82;
    const planeH = Math.max(size.z, 0.01) * 0.82;
    const tex = buildPlaqueTextTexture(text);
    const mat = new THREE.MeshBasicMaterial({ map: tex, transparent: true, depthWrite: false });
    const geo = new THREE.PlaneGeometry(planeW, planeH);
    const mesh = new THREE.Mesh(geo, mat);
    mesh.rotation.x = -Math.PI / 2;
    mesh.position.set(center.x, box.max.y + 0.002, center.z);
    mesh.renderOrder = 10;
    scene.add(mesh);
    currentPlaqueText = mesh;
};
// ── CHARACTER TOPPERS — file-name lookup by character name ──
const CHARACTER_FILE_MAP = {
    'Mickey Mouse':      'mickeymouse',
    'Minnie Mouse':      'minniemouse',
    'Lightning McQueen': 'lightningmcqueen',
    'Sally':             'sally',
    'Kuromi':            'kuromi',
    'Hello Kitty':       'hellokitty',
    'Cinnamoroll':       'cinnamoroll',
    'My Melody':         'melody',
    'Cocomelon':         'cocomelon',
    'Squidward':         'squidward',
    'Patrick Star':      'patrickstar',
    'Gary':               'gary',
    'SpongeBob':          'spongebob',
    'Dora':               'dora',
    'Boots':              'boots',
    'Ben 10':             'ben10',
   'Buttercup':          'buttercup',
    'Blossom':            'blossom',
    'Bubbles':            'bubbles',
    "Squidward's House":      'squidwards_house',
    "SpongeBob's House":      'spongebob_house',
    "Patrick's House":        'patrickhouse',
    "Dora's House":           'dora_house',
    'Powerpuff House':        'powerpuff_house',
    'Mickey Mouse Clubhouse': 'mickey_mouse_clubhouse',
    'Ben 10 RV':              'rvben10',
    'Gwen':                   'gwen',
    'Lolo Max':               'lolomax',
};
let currentCharacterTopper = null;
// Per-character size correction, calibrated against Cinnamoroll (1.0 = baseline).
// Raw GLB exports rarely share the same real-world scale, so matching bounding-box
// diameter alone still looks inconsistent — bump a character's number up if it
// renders smaller than Cinnamoroll on the cake, or down if it renders bigger.
const CHARACTER_SIZE_MULT = {
    'Mickey Mouse':      0.5,
    'Minnie Mouse':      0.45,
    'Lightning McQueen': 0.9,
    'Sally':             0.8,
    'Kuromi':            0.6,
    'Hello Kitty':       0.6,
    'Cinnamoroll':       0.9, // ← baseline
    'My Melody':         0.6,
    'Cocomelon':         0.5,
    // SpongeBob / Squidward / Patrick sized up to match the SpongeBob's House scale
    'Squidward':         0.6,
    'Patrick Star':      0.5,
    'SpongeBob':          0.5,
    // Gary stays a small sidekick — smaller than SpongeBob
    'Gary':               0.35,
    'Dora':               0.6,
    'Boots':              0.4,
    'Ben 10':             0.45,
    'Buttercup':          0.5,
    'Blossom':            0.5,
    'Bubbles':            0.5,
    // Houses are normalized by HEIGHT (see CHARACTER_SIZE_MODE) so they land at
    // the same height Gary used to render at (his old baseline mult of 1.0)
    "Squidward's House":      1.0,
    "SpongeBob's House":      0.9,
    "Patrick's House":        0.8,
    "Dora's House":           1.0,
    'Powerpuff House':        1.0,
    'Mickey Mouse Clubhouse': 0.8,
    'Ben 10 RV':              2.0,
    'Gwen':                   0.4,
    'Lolo Max':               0.6,
};
// Houses are wide/squat, so sizing them off their largest single axis (width)
// makes them come out too short. These get normalized by HEIGHT instead, so
// their vertical size lines up with the standing character figures.
const CHARACTER_SIZE_MODE = {
    "Squidward's House": 'height',
    "SpongeBob's House": 'height',
    "Patrick's House":   'height',
    "Dora's House":      'height',
    'Powerpuff House':        'height',
    'Mickey Mouse Clubhouse': 'height',
};
// Per-character starting yaw (Y-axis rotation, radians) so every model faces
const CHARACTER_ROTATION_Y = {
    'Kuromi':    Math.PI,
    'My Melody': Math.PI,
    'Gary':      Math.PI,
};

window.placeCharacterOnCake = async function(characterKey, cx, cy){
    const file = CHARACTER_FILE_MAP[characterKey] || 'mickeymouse';
    try{
        const cakeRef = currentBase || currentFrost;
        if(!cakeRef) return -1;
        cakeRef.updateMatrixWorld(true);
        const cakeBox = new THREE.Box3().setFromObject(cakeRef);
        const cakeCenter = cakeBox.getCenter(new THREE.Vector3());
        const cakeDiameter = Math.max(cakeBox.max.x - cakeBox.min.x, cakeBox.max.z - cakeBox.min.z);

        const fg = await loadDecoGLB(`/models/${file}.glb`);
        fg.traverse(c=>{ if(c.isMesh){ c.castShadow = true; c.receiveShadow = true; } });
        fg.position.set(0,0,0); fg.rotation.set(0,0,0); fg.scale.set(1,1,1);
        fg.updateMatrixWorld(true);

        const rawBox  = new THREE.Box3().setFromObject(fg);
        const rawSize = rawBox.getSize(new THREE.Vector3());
        const sizeMode = CHARACTER_SIZE_MODE[characterKey] || 'maxAxis';
        // Use the largest SINGLE axis by default — a stray/degenerate vertex far
        // from the model can blow the scale factor up. Wide "house"-style models
        // are normalized off their HEIGHT instead (see CHARACTER_SIZE_MODE), so
        // their vertical size lines up with the standing character figures.
        const rawDiam = sizeMode === 'height' ? rawSize.y : Math.max(rawSize.x, rawSize.y, rawSize.z);
        const sizeMult = CHARACTER_SIZE_MULT[characterKey] ?? 1.0;
        const targetDiam = cakeDiameter * 0.30 * sizeMult;
        const MIN_SAFE_DIM = 0.01;
        const MAX_SAFE_DIM = 500.0;
        let scale = 1.0;
        if(isFinite(rawDiam) && rawDiam > MIN_SAFE_DIM && rawDiam < MAX_SAFE_DIM){
            scale = targetDiam / rawDiam;
        } else {
            console.warn('[CharacterTopper] Degenerate bounding box for', characterKey, '- raw size:', rawSize, '- using fallback scale');
        }
        fg.scale.setScalar(scale);
        fg.updateMatrixWorld(true);

        const checkBox = new THREE.Box3().setFromObject(fg);
        const checkSize = checkBox.getSize(new THREE.Vector3());
        const checkMax = sizeMode === 'height' ? checkSize.y : Math.max(checkSize.x, checkSize.y, checkSize.z);
        if(!isFinite(checkMax) || checkMax > targetDiam * 2.5){
            const fixScale = checkMax > 0.0001 ? (targetDiam / checkMax) * scale : scale;
            fg.scale.setScalar(fixScale);
            fg.updateMatrixWorld(true);
        }

        fg.rotation.y = CHARACTER_ROTATION_Y[characterKey] || 0;
        fg.updateMatrixWorld(true);

        const scaledBox  = new THREE.Box3().setFromObject(fg);
        const scaledSize = scaledBox.getSize(new THREE.Vector3());
        const bottomOffset = -scaledBox.min.y - scaledSize.y * 0.06;

        characterModels.forEach(m=>m.group.visible=false);
        let sp = null;
        if(cx !== undefined && cy !== undefined && typeof raycastCakeTop === 'function'){
            sp = raycastCakeTop(cx, cy);
        }
        characterModels.forEach(m=>m.group.visible=true);
        if(!sp){ sp = new THREE.Vector3(cakeCenter.x, cakeBox.max.y, cakeCenter.z); }

        fg.position.set(sp.x, sp.y + bottomOffset, sp.z);
        // Smoothing target starts equal to the drop position so it doesn't
        // animate in from the origin on first placement.
        fg._targetPos = fg.position.clone();
        fg.updateMatrixWorld(true);

        scene.add(fg);
        const idx = characterModels.length;
        characterModels.push({ group: fg, key: characterKey, bottomOffset });
        return idx;
    }catch(err){
        console.error('[CharacterTopper]', characterKey, err);
        if(typeof showToast === 'function') showToast('⚠ Character model failed to load — check /models/ path', 3000);
        return -1;
    }
};
window.clearCharacterModels = function(){
    characterModels.forEach(m=>scene.remove(m.group));
    characterModels.length = 0;
    _draggingCharacterIdx = -1;
};
window.removeCharacterModel = function(idx){
    if(idx<0||idx>=characterModels.length) return false;
    scene.remove(characterModels[idx].group);
    characterModels.splice(idx,1);
    return true;
};
window.getCharacterModels = function(){ return characterModels; };
window.getCharacterIndexAtScreen = function(cx, cy){
    const rect = document.getElementById('viewerEl').getBoundingClientRect();
    const ndc = new THREE.Vector2(((cx-rect.left)/rect.width)*2-1, -((cy-rect.top)/rect.height)*2+1);
    const rc = new THREE.Raycaster(); rc.setFromCamera(ndc, camera);
    for(let i=characterModels.length-1;i>=0;i--){
        const t=[]; characterModels[i].group.traverse(c=>{ if(c.isMesh) t.push(c); });
        if(rc.intersectObjects(t,false).length>0) return i;
    }
    return -1;
};
window.moveDraggingCharacter = function(cx, cy){
    if(_draggingCharacterIdx<0 || !characterModels[_draggingCharacterIdx]) return;
    const e = characterModels[_draggingCharacterIdx];
    characterModels.forEach(m=>m.group.visible=false);
    const h = raycastCakeTop(cx, cy);
    characterModels.forEach(m=>m.group.visible=true);
    if(h){
        // Set a smoothing TARGET instead of snapping directly to the raycast
        // hit — the animate() loop eases the visible position toward this
        // each frame, so dragging feels smooth instead of jumpy.
        if(!e.group._targetPos) e.group._targetPos = e.group.position.clone();
        e.group._targetPos.set(h.x, h.y + e.bottomOffset, h.z);
    }
    // Keep the render loop alive while dragging — without this the render
    // budget expires mid-drag (moving a character doesn't move the camera),
    // which is why the topper visually froze/stuttered while being moved.
    if(typeof window._requestRender==='function') window._requestRender(300);
};
window.setDraggingCharacterIdx = function(idx){ _draggingCharacterIdx = idx; };
window.getDraggingCharacterIdx = function(){ return _draggingCharacterIdx; };
window.setCharacterYRotation = function(idx, deg){
    if(idx<0 || !characterModels[idx]) return;
    characterModels[idx].group.rotation.y = deg * Math.PI / 180;
};
window.getCharacterYRotationDeg = function(idx){
    if(idx<0 || !characterModels[idx]) return 0;
    return Math.round((characterModels[idx].group.rotation.y * 180 / Math.PI + 360) % 360);
};
window._reapplyCharacterTopper = function(){
    // Repositioning after a cake reload is handled by the shared topping
    // reprojection system (_reprojectAllToppings), which now covers
    // characterModels too — nothing extra needed here.
};
window.clearPlaqueMessage = function(){
    if(currentPlaqueText){
        scene.remove(currentPlaqueText);
        currentPlaqueText.geometry.dispose();
        if(currentPlaqueText.material.map) currentPlaqueText.material.map.dispose();
        currentPlaqueText.material.dispose();
        currentPlaqueText = null;
    }
};
window._reapplyPlaque = function(){
    if(currentPlaque && typeof state !== 'undefined' && state.addons && state.addons.has('Chocolate Plaque')){
        window.placePlaqueOnCake(state.plaqueShape).then(ok=>{
            if(ok && typeof state.plaqueMessage === 'string') window.setPlaqueMessage(state.plaqueMessage);
        });
    }
};
let _cachedCakeMeshes = null;
function invalidateCakeMeshesCache(){ _cachedCakeMeshes = null; }
function getCakeMeshes(){
    // Called on every pointermove while dragging a fruit/candle/choco piece
    // (via raycastCakeTop) — re-walking the whole scene graph each time was
    // a major source of drag lag once several decorations were on the cake.
    // Cache the list; only rebuild when the cake itself actually changes.
    if(_cachedCakeMeshes) return _cachedCakeMeshes;
    const m=[];
    sceneRoot.traverse(c=>{
        if(!c.isMesh) return;
        let node=c,isStand=false;
        while(node){if(node.userData&&node.userData.isStand){isStand=true;break;}node=node.parent;}
        if(!isStand) m.push(c);
    });
    _cachedCakeMeshes = m;
    return m;
}
// Sprinkles / crushed peanuts should only land on the plain cake or base
// frosting surface — never on top of rosettes or other piped 3D decorations,
// which already have their own texture and get visually cluttered when
// sprinkles pile on top of them.
function getSprinkleTargetMeshes(){
    const m=[];
    sceneRoot.traverse(c=>{
        if(!c.isMesh) return;
        let node=c,isExcluded=false;
        while(node){
            if(node.userData && node.userData.isStand){isExcluded=true;break;}
            if(currentRosette && node===currentRosette){isExcluded=true;break;}
            // Exclude the piped Shell Border / Sugar Icing overlay — sprinkles and
            // crushed peanuts should only land on the plain cake body/frosting,
            // not on top of the decorative piping.
            if(currentIcing && node===currentIcing){isExcluded=true;break;}
            node=node.parent;
        }
        if(!isExcluded) m.push(c);
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
const fruitGLBCache={};
const fruitGLBLoadingPromises={};
function _cloneFruitScene(scene){const c=scene.clone(true);c.traverse(x=>{if(x.isMesh&&x.material)x.material=x.material.clone();});return c;}
function loadFruitGLB(url){
    if(fruitGLBCache[url]) return Promise.resolve(_cloneFruitScene(fruitGLBCache[url]));
    if(fruitGLBLoadingPromises[url]) return fruitGLBLoadingPromises[url].then(_cloneFruitScene);
    const p=new Promise((resolve,reject)=>{
        new GLTFLoader().load(url,gltf=>{
            fruitGLBCache[url]=gltf.scene;
            delete fruitGLBLoadingPromises[url];
            resolve(gltf.scene);
        },undefined,err=>{delete fruitGLBLoadingPromises[url];console.error('[Fruit]',url,err);reject(err);});
    });
    fruitGLBLoadingPromises[url]=p;
    return p.then(_cloneFruitScene);
}
let _draggingFruitIdx=-1;

// Procedural mango — a small shiny yellow/orange cube (no GLB needed)
function buildMangoCubeMesh(){
    const g=new THREE.Group();
    const size=0.10;
    const mat=new THREE.MeshStandardMaterial({
        color:new THREE.Color('#F7A927'),
        roughness:0.10, metalness:0.30, envMapIntensity:1.5,
    });
    const geo=new THREE.BoxGeometry(size,size,size);
    const mesh=new THREE.Mesh(geo,mat);
    mesh.castShadow=mesh.receiveShadow=true;
    g.add(mesh);
    g.rotation.y=Math.random()*Math.PI*2;
    g.rotation.x=(Math.random()-0.5)*0.3;
    g.updateMatrixWorld(true);
    return g;
}
// Procedural peach slice — a rounded, curved lens/crescent segment with a soft
// radial flesh gradient and a warm skin-colored rim along the outer curve,
// closer to a real peach slice than the old flat pizza-wedge shape.
function buildPeachSliceMesh(){
    const g=new THREE.Group();
    const a=0.135;        // half-length of the slice, tip to tip
    const hTop=0.058;     // bulge of the outer/skin curve
    const hBottom=0.026;  // bulge of the inner/cut curve (gentler)
    const thickness=0.030;

    // ── Lens/crescent profile ──
    const shape=new THREE.Shape();
    shape.moveTo(-a,0);
    shape.quadraticCurveTo(0,hTop,a,0);
    shape.quadraticCurveTo(0,-hBottom,-a,0);

    const extrudeSettings={
        depth:thickness, bevelEnabled:true, bevelThickness:0.010,
        bevelSize:0.010, bevelSegments:4, curveSegments:20,
    };
    const geo=new THREE.ExtrudeGeometry(shape,extrudeSettings);
    geo.center();

    // ── Radial flesh gradient: pale gold center → warm orange edges ──
    const posAttr=geo.attributes.position;
    const count=posAttr.count;
    const colors=new Float32Array(count*3);
const cCenter=new THREE.Color('#FFCB6B');
    const cEdge=new THREE.Color('#F2661E');
    for(let i=0;i<count;i++){
        const x=posAttr.getX(i), y=posAttr.getY(i);
        const t=Math.min(1, Math.sqrt(x*x+y*y*2.4)/a);
        const c=cCenter.clone().lerp(cEdge,t);
        colors[i*3]=c.r; colors[i*3+1]=c.g; colors[i*3+2]=c.b;
    }
    geo.setAttribute('color', new THREE.BufferAttribute(colors,3));
    geo.rotateX(-Math.PI/2); // lay the slice flat, cut-face up
    geo.computeVertexNormals();

  const fleshMat=new THREE.MeshStandardMaterial({
        vertexColors:true, roughness:0.24, metalness:0.03, envMapIntensity:1.05,
    });
    const flesh=new THREE.Mesh(geo,fleshMat);
    flesh.castShadow=flesh.receiveShadow=true;
    g.add(flesh);

    // ── Warm skin-colored rim tracing just the outer (top) curve ──
    const rimCurve=new THREE.QuadraticBezierCurve3(
        new THREE.Vector3(-a,0,0),
        new THREE.Vector3(0,hTop,0),
        new THREE.Vector3(a,0,0),
    );
    const rimGeo=new THREE.TubeGeometry(rimCurve,20,0.012,8,false);
    rimGeo.rotateX(-Math.PI/2);
   const skinMat=new THREE.MeshStandardMaterial({
        color:new THREE.Color('#C8391A'),
        roughness:0.36, metalness:0.0, envMapIntensity:0.85,
    });
    const rim=new THREE.Mesh(rimGeo,skinMat);
    rim.position.y=thickness*0.5;
    rim.castShadow=true;
    g.add(rim);

    g.rotation.y=Math.random()*Math.PI*2;
    g.updateMatrixWorld(true);
    return g;
}
window.placeFruitOnCake=async function(fruitName,cx,cy,ei){
    const map={'Strawberry':'/models/Strawberry.glb','Blueberry':'/models/Blueberry.glb','Raspberry':'/models/Raspberry.glb','Cherry':'/models/Cherry.glb','Kiwi Slice':'/models/kiwi.glb','Banana Slice':'/models/banana.glb'};
    const proceduralFruits=['Mango Slice','Peach Slice'];
    const isProcedural=proceduralFruits.includes(fruitName);
    const url=map[fruitName];
    if(!url && !isProcedural) return -1;
    try{
        let fg,fh;
        if(ei!==undefined&&ei>=0&&fruitModels[ei]){
            fg=fruitModels[ei].group;
            const sb=new THREE.Box3().setFromObject(fg);fh=(sb.max.y-sb.min.y)*.5;
        }else{
            if(isProcedural){
                fg = fruitName==='Mango Slice' ? buildMangoCubeMesh() : buildPeachSliceMesh();
                fg.updateMatrixWorld(true);
            } else {
                fg=await loadFruitGLB(url);
                fg.traverse(c=>{if(c.isMesh){c.castShadow=true;c.receiveShadow=true;}});
                fg.updateMatrixWorld(true);
       const rb=new THREE.Box3().setFromObject(fg);
                const rbSize=rb.getSize(new THREE.Vector3());
                console.log('[Fruit DEBUG]', fruitName, 'raw bbox size:', rbSize.x.toFixed(4), rbSize.y.toFixed(4), rbSize.z.toFixed(4));
                // Use the LARGEST SINGLE AXIS, not the diagonal — a mesh that's
                // tiny on X/Z but huge/degenerate on Y can still have a
                // deceptively "normal" diagonal length, letting a stretched
                // capsule shape slip past a diagonal-only check.
                const maxAxis = Math.max(rbSize.x, rbSize.y, rbSize.z);
          const fruitSizes={'Strawberry':0.22,'Blueberry':0.12,'Raspberry':0.16,'Cherry':0.20,'Kiwi Slice':0.20,'Banana Slice':0.13};
                const T=fruitSizes[fruitName]||0.18;
        const MIN_SAFE_DIM = 0.005;
                const MAX_SAFE_DIM = 200.0; // raised to accommodate GLBs exported at a larger scale (e.g. Blueberry.glb)d this
                let useFallback = !isFinite(maxAxis) || maxAxis < MIN_SAFE_DIM || maxAxis > MAX_SAFE_DIM;
                if(!useFallback){
                    const scale = T / maxAxis;
                    fg.scale.setScalar(scale);
                    fg.updateMatrixWorld(true);
                    // Hard backstop: verify the SCALED result actually landed in a
                    // sane world-space size. If not (e.g. non-uniform mesh where
                    // one axis still dominates after scaling), fall back rather
                    // than show a giant shape.
                    const checkBox = new THREE.Box3().setFromObject(fg);
                    const checkSize = checkBox.getSize(new THREE.Vector3());
                    const checkMax = Math.max(checkSize.x, checkSize.y, checkSize.z);
                    if(!isFinite(checkMax) || checkMax > T * 3){
                        useFallback = true;
                    }
                }
                if(useFallback){
                    console.warn('[Fruit] Degenerate/oversized bounds for', fruitName, '- using fallback sphere');
                    fg = new THREE.Group();
                    const fallbackMat = new THREE.MeshStandardMaterial({ color: 0xD94070, roughness: 0.4, metalness: 0.0 });
                    const fallbackMesh = new THREE.Mesh(new THREE.SphereGeometry(T*0.5, 16, 16), fallbackMat);
                    fallbackMesh.castShadow = fallbackMesh.receiveShadow = true;
                    fg.add(fallbackMesh);
                }
              if(fruitName==='Strawberry'||fruitName==='Raspberry'){fg.rotation.x=0;fg.rotation.y=0;}
                fg.updateMatrixWorld(true);
                // Re-center horizontally so the mesh's visual center (not its raw
                // GLB pivot) lands under the cursor. Some exports — e.g. banana.glb —
                // don't have their origin at the geometric center in X/Z, which made
                // the visible fruit appear offset from the actual drop point.
                const _centerBox = new THREE.Box3().setFromObject(fg);
                const _centerXZ = _centerBox.getCenter(new THREE.Vector3());
                const _wrapped = new THREE.Group();
                fg.position.x -= _centerXZ.x;
                fg.position.z -= _centerXZ.z;
                _wrapped.add(fg);
                fg = _wrapped;
                fg.updateMatrixWorld(true);
            }
            const sb=new THREE.Box3().setFromObject(fg);fh=(sb.max.y-sb.min.y)*.5;
        }
        fruitModels.forEach(m=>m.group.visible=false);
        const hp=raycastCakeTop(cx,cy);
        fruitModels.forEach(m=>m.group.visible=true);
        let sp;
        if(hp){sp=hp;}else{
            sceneRoot.updateMatrixWorld(true);
            const cb=new THREE.Box3().setFromObject(sceneRoot),cc=cb.getCenter(new THREE.Vector3());
            sp=new THREE.Vector3(cc.x,cb.max.y,cc.z);
        }
        fg.updateMatrixWorld(true);
        const _fBox=new THREE.Box3().setFromObject(fg);
        const _fHeight=_fBox.max.y-_fBox.min.y;
        const _fOffset=-_fBox.min.y-(_fHeight*0.25);
        fg.position.set(sp.x,sp.y+_fOffset,sp.z);
        if(ei!==undefined&&ei>=0&&fruitModels[ei])return ei;
        scene.add(fg);
        const idx=fruitModels.length;
        fruitModels.push({group:fg,fruit:fruitName,halfH:fh,bottomOffset:_fOffset});
        return idx;
    }catch(err){console.error('[Fruit]',fruitName,err);return -1;}
};
window.clearFruitModels=function(){fruitModels.forEach(m=>scene.remove(m.group));fruitModels.length=0;_draggingFruitIdx=-1;};
window.removeFruitModel=function(idx){if(idx<0||idx>=fruitModels.length)return false;scene.remove(fruitModels[idx].group);fruitModels.splice(idx,1);if(window._placedFruitRecord)window._placedFruitRecord.splice(idx,1);return true;};
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
window.removeFerreroModel = function(idx) { if(idx<0||idx>=ferreroModels.length)return false; scene.remove(ferreroModels[idx].group); ferreroModels.splice(idx,1); if(window._placedFerreroRecord)window._placedFerreroRecord.splice(idx,1); return true; };
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
window.removeKitkatModel = function(idx) { if(idx<0||idx>=kitkatModels.length)return false; scene.remove(kitkatModels[idx].group); kitkatModels.splice(idx,1); if(window._placedKitkatRecord)window._placedKitkatRecord.splice(idx,1); return true; };
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
window.removeOreoModel = function(idx) { if(idx<0||idx>=oreoModels.length)return false; scene.remove(oreoModels[idx].group); oreoModels.splice(idx,1); if(window._placedOreoRecord)window._placedOreoRecord.splice(idx,1); return true; };
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

const barShardModels = [];
let _draggingBarShardIdx = -1;

const tobleroneModels = [];
let _draggingTobleroneIdx = -1;
// ── Toblerone flavor styling — recolors the bar and scatters real nut-bump
// geometry across its faces so White vs Chocolate visibly differ, not just
// by base color but by having actual nut studs like a real Toblerone bar. ──
function recolorTobleroneBar(fg, flavor){
    const barColor  = flavor === 'White' ? '#F5EFDC' : '#3A1206';
    const roughness = flavor === 'White' ? 0.26 : 0.32;
    fg.traverse(c=>{
        if(!c.isMesh || c.userData.isTobleroneNut) return;
        if(c.material){ if(c.material.map) c.material.map.dispose(); c.material.dispose(); }
        c.material = new THREE.MeshStandardMaterial({
            color: new THREE.Color(barColor),
            roughness: roughness,
            metalness: 0.03,
            envMapIntensity: 0.78,
        });
        c.castShadow = true;
        c.receiveShadow = true;
    });
}
function clearTobleroneNuts(fg){
    fg.traverse(c=>{
        if(!c.isMesh) return;
        const toRemove = c.children.filter(ch => ch.userData && ch.userData.isTobleroneNut);
        toRemove.forEach(n=>{ c.remove(n); if(n.geometry) n.geometry.dispose(); });
    });
}
// ── Area-weighted surface sampling — picks random points ON the actual
// mesh faces (not the bounding box, which includes empty air around a
// triangular prism), so nuts always sit flush on a real surface. Bigger
// faces get proportionally more samples than tiny ones. ──
function _buildTriAreaCDF(geometry){
    const pos = geometry.attributes.position;
    const index = geometry.index;
    const triCount = index ? Math.floor(index.count/3) : Math.floor(pos.count/3);
    if(triCount === 0) return null;
    const areas = new Float32Array(triCount);
    const vA=new THREE.Vector3(), vB=new THREE.Vector3(), vC=new THREE.Vector3();
    const eAB=new THREE.Vector3(), eAC=new THREE.Vector3(), crossV=new THREE.Vector3();
    let total = 0;
    for(let t=0;t<triCount;t++){
        let ia, ib, ic;
        if(index){ ia=index.getX(t*3); ib=index.getX(t*3+1); ic=index.getX(t*3+2); }
        else { ia=t*3; ib=t*3+1; ic=t*3+2; }
        vA.fromBufferAttribute(pos, ia);
        vB.fromBufferAttribute(pos, ib);
        vC.fromBufferAttribute(pos, ic);
        eAB.subVectors(vB, vA); eAC.subVectors(vC, vA);
        crossV.crossVectors(eAB, eAC);
        total += crossV.length() * 0.5;
        areas[t] = total;
    }
    if(total < 0.000001) return null;
    return { areas, total, triCount, index };
}
function _sampleSurfacePoint(geometry, cdf){
    const pos = geometry.attributes.position;
    // Binary search into the area-weighted cumulative distribution
    const r = Math.random() * cdf.total;
    let lo = 0, hi = cdf.triCount - 1;
    while(lo < hi){
        const mid = (lo + hi) >> 1;
        if(cdf.areas[mid] < r) lo = mid + 1; else hi = mid;
    }
    const t = lo;
    let ia, ib, ic;
    if(cdf.index){ ia=cdf.index.getX(t*3); ib=cdf.index.getX(t*3+1); ic=cdf.index.getX(t*3+2); }
    else { ia=t*3; ib=t*3+1; ic=t*3+2; }
    const vA = new THREE.Vector3().fromBufferAttribute(pos, ia);
    const vB = new THREE.Vector3().fromBufferAttribute(pos, ib);
    const vC = new THREE.Vector3().fromBufferAttribute(pos, ic);
    let r1 = Math.random(), r2 = Math.random();
    if(r1 + r2 > 1){ r1 = 1 - r1; r2 = 1 - r2; }
    const point = new THREE.Vector3()
        .addScaledVector(vA, 1 - r1 - r2)
        .addScaledVector(vB, r1)
        .addScaledVector(vC, r2);
    const normal = new THREE.Vector3()
        .subVectors(vB, vA)
        .cross(new THREE.Vector3().subVectors(vC, vA))
        .normalize();
    return { point, normal };
}
function addNutsToToblerone(fg, flavor){
    // Peanuts are brown regardless of bar flavor — a real peanut doesn't change
    // color based on what chocolate it's embedded in. White bars get a slightly
    // richer/darker brown so the nuts read clearly against the pale background.
    const NUT_COLOR = flavor === 'White' ? '#B8804A' : '#C89860';
    const NUT_DARK  = flavor === 'White' ? '#7A4E1E' : '#6B4820';
    const nutMat     = new THREE.MeshStandardMaterial({ color:new THREE.Color(NUT_COLOR), roughness:0.58, metalness:0.02, envMapIntensity:0.70 });
    const nutDarkMat = new THREE.MeshStandardMaterial({ color:new THREE.Color(NUT_DARK),  roughness:0.62, metalness:0.00 });
    const meshes = [];
    fg.traverse(c=>{ if(c.isMesh && !c.userData.isTobleroneNut) meshes.push(c); });
    if(meshes.length === 0) return;

    // ── Pass 1: measure each mesh's real surface area so nut count scales
    // with face size — the thin side-edge strips of the prism are tiny
    // compared to the big front/back sloped faces, and should barely get
    // any nuts instead of an equal share. ──
    const meshInfo = meshes.map(mesh=>{
        const geo = mesh.geometry;
        if(!geo || !geo.attributes || !geo.attributes.position) return { mesh, geo:null, cdf:null, area:0 };
        const cdf = _buildTriAreaCDF(geo);
        return { mesh, geo, cdf, area: cdf ? cdf.total : 0 };
    });
    const totalArea = meshInfo.reduce((s,m)=>s+m.area, 0);
    if(totalArea < 0.000001) return;

    const NUT_TOTAL = 22; // total peanuts across the whole bar
    const MIN_FACE_SHARE = 0.12; // faces smaller than this share of total area (thin side edges) get skipped entirely

    meshInfo.forEach(({mesh, geo, cdf, area})=>{
        if(!cdf || area <= 0) return;
        const share = area / totalArea;
        if(share < MIN_FACE_SHARE) return; // skip thin side-edge strips — front/back only
        const nutCount = Math.max(3, Math.round(share * NUT_TOTAL));

        if(!geo.boundingBox) geo.computeBoundingBox();
        const bbSize = new THREE.Vector3(); geo.boundingBox.getSize(bbSize);
        const maxDim = Math.max(bbSize.x, bbSize.y, bbSize.z);
        if(maxDim < 0.0001) return;

        for(let i=0;i<nutCount;i++){
            const { point, normal } = _sampleSurfacePoint(geo, cdf);
            if(normal.lengthSq() < 0.0001) continue; // skip degenerate triangle
            const peanutLen = maxDim * (0.020 + Math.random()*0.008); // small, peanut-sized
            const nutGeo = new THREE.SphereGeometry(peanutLen, 6, 5);
            // Local X = length (long axis), Local Y = width, Local Z = thickness (flat)
            nutGeo.scale(1.0, 0.55, 0.22); // flattened peanut — thin along Z
            const mat = Math.random() > 0.45 ? nutMat : nutDarkMat;
            const nut = new THREE.Mesh(nutGeo, mat);

            // Align the FLAT axis (local Z, the thin dimension) to the surface
            // normal so the peanut lies flush against the face — length and
            // width stay tangent to the surface — then spin randomly around
            // the normal so peanuts don't all point the same way.
            const flatAxis = new THREE.Vector3(0,0,1);
            const alignQ = new THREE.Quaternion().setFromUnitVectors(flatAxis, normal);
            const twistQ = new THREE.Quaternion().setFromAxisAngle(normal, Math.random()*Math.PI*2);
            nut.quaternion.copy(twistQ.multiply(alignQ));

            const embed = peanutLen * 0.10; // sit almost flush, barely embedded
            nut.position.copy(point).addScaledVector(normal, embed);

            nut.userData.isTobleroneNut = true;
            nut.castShadow = true;
            nut.receiveShadow = true;
            mesh.add(nut);
        }
    });
}
window.reflavorToblerone = function(flavor){
    tobleroneModels.forEach(m=>{
        clearTobleroneNuts(m.group);
        recolorTobleroneBar(m.group, flavor);
        addNutsToToblerone(m.group, flavor);
        m.flavor = flavor;
    });
};

window.placeTobleroneOnCake = async function(cx, cy, ei) {
    const url = '/models/Toblerone.glb';
    const flavor = (typeof state !== 'undefined' && state.tobleroneFlavor) ? state.tobleroneFlavor : 'Chocolate';
    try {
        let fg, fh;
        if (ei !== undefined && ei >= 0 && tobleroneModels[ei]) {
            fg = tobleroneModels[ei].group;
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        } else {
            fg = await loadFruitGLB(url);
            fg.traverse(c => { if (c.isMesh) { c.castShadow = true; c.receiveShadow = true; } });
            fg.updateMatrixWorld(true);
            const rb = new THREE.Box3().setFromObject(fg);
            const sz = rb.getSize(new THREE.Vector3());
            const maxD = Math.max(sz.x, sz.y, sz.z);
            fg.scale.setScalar(maxD > 0.0001 ? 0.26 / maxD : 1.0);
            fg.rotation.y = Math.random() * Math.PI * 2;
            fg.updateMatrixWorld(true);
            recolorTobleroneBar(fg, flavor);
            addNutsToToblerone(fg, flavor);
            const sb = new THREE.Box3().setFromObject(fg);
            fh = (sb.max.y - sb.min.y) * 0.5;
        }
        tobleroneModels.forEach(m => m.group.visible = false);
        const hp = raycastCakeTop(cx, cy);
        tobleroneModels.forEach(m => m.group.visible = true);
        let sp;
        if (hp) { sp = hp; } else {
            sceneRoot.updateMatrixWorld(true);
            const cb = new THREE.Box3().setFromObject(sceneRoot);
            const cc = cb.getCenter(new THREE.Vector3());
            sp = new THREE.Vector3(cc.x, cb.max.y, cc.z);
        }
        fg.updateMatrixWorld(true);
        const _tbBox = new THREE.Box3().setFromObject(fg);
        const _tbOffset = -_tbBox.min.y;
        fg.position.set(sp.x, sp.y + _tbOffset, sp.z);
        if (ei !== undefined && ei >= 0 && tobleroneModels[ei]) return ei;
        scene.add(fg);
        const idx = tobleroneModels.length;
        tobleroneModels.push({ group: fg, halfH: fh, bottomOffset: _tbOffset, flavor });
        return idx;
    } catch (err) { console.error('[Toblerone]', err); return -1; }
};
window.clearTobleroneModels = function() { tobleroneModels.forEach(m => scene.remove(m.group)); tobleroneModels.length = 0; _draggingTobleroneIdx = -1; };
window.removeTobleroneModel = function(idx) { if(idx<0||idx>=tobleroneModels.length)return false; scene.remove(tobleroneModels[idx].group); tobleroneModels.splice(idx,1); if(window._placedTobleroneRecord)window._placedTobleroneRecord.splice(idx,1); return true; };
window.getTobleroneIndexAtScreen = function(cx, cy) {
    const rect = document.getElementById('viewerEl').getBoundingClientRect();
    const ndc = new THREE.Vector2(((cx - rect.left) / rect.width) * 2 - 1, -((cy - rect.top) / rect.height) * 2 + 1);
    const rc = new THREE.Raycaster(); rc.setFromCamera(ndc, camera);
    for (let i = tobleroneModels.length - 1; i >= 0; i--) {
        const t = []; tobleroneModels[i].group.traverse(c => { if (c.isMesh) t.push(c); });
        if (rc.intersectObjects(t, false).length > 0) return i;
    }
    return -1;
};
window.moveDraggingToblerone = function(cx, cy) {
    if (_draggingTobleroneIdx < 0 || !tobleroneModels[_draggingTobleroneIdx]) return;
    const e = tobleroneModels[_draggingTobleroneIdx];
    tobleroneModels.forEach(m => m.group.visible = false);
    const h = raycastCakeTop(cx, cy);
    tobleroneModels.forEach(m => m.group.visible = true);
    if (h) { e.group.position.set(h.x, h.y + e.bottomOffset, h.z); }
};
window.setDraggingTobleroneIdx = function(idx) { _draggingTobleroneIdx = idx; };
window.getDraggingTobleroneIdx = function() { return _draggingTobleroneIdx; };
window.getTobleroneModels = function() { return tobleroneModels; };


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
window.removeBarShardModel = function(idx) { if(idx<0||idx>=barShardModels.length)return false; scene.remove(barShardModels[idx].group); barShardModels.splice(idx,1); if(window._placedBarShardRecord)window._placedBarShardRecord.splice(idx,1); return true; };
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
    saveNormalized(tobleroneModels);saveNormalized(candleModels);
    if(typeof characterModels!=='undefined')saveNormalized(characterModels);
};
window._reprojectAllToppings=function(){
    reprojectModels(fruitModels);reprojectModels(ferreroModels);
    reprojectModels(kitkatModels);reprojectModels(oreoModels);reprojectModels(barShardModels);
    reprojectModels(tobleroneModels);reprojectModels(candleModels);
    if(typeof characterModels!=='undefined')reprojectModels(characterModels);
};
window._threeCamera   = camera;
window._threeControls = controls;
window._threeRenderer = renderer;
window._threeScene    = scene;
window._requestShadowUpdate = function(){ if(renderer) renderer.shadowMap.needsUpdate = true; };
window.isCakeSceneReady=function(){ return !!(currentBase || currentFrost); };
window.updateModel=(state)=>updateScene(state);
window.resetCamera=()=>{
    const tier = state ? state.tier : 'Single';
    let camY = 2.8, camZ = 9.5, targetY = 0.0;
    if (tier === 'Two-tier')   { camY = 3.8; camZ = 10.5; targetY = 0.4; }
    if (tier === 'Three-tier') { camY = 5.2; camZ = 12.5; targetY = 0.8; }
    camera.position.set(0, camY, camZ);
    controls.target.set(0, targetY, 0);
    controls.update();
    if(typeof window._requestRender==='function') window._requestRender();   // ← ADD THIS LINE
};
window._viewerReady=true;
(function(){
    let activeFruitPanelIdx = -1;
   const FRUIT_EMOJI = { Strawberry:'🍓', Blueberry:'🫐', Raspberry:'🍇', Cherry:'🍒', 'Mango Slice':'🥭', 'Kiwi Slice':'🥝', 'Peach Slice':'🍑', 'Banana Slice':'🍌' };
    // Rotation axis per fruit — Strawberry/Raspberry use X for placement so we rotate Y instead
  const FRUIT_ROT_AXIS = { Strawberry:'z', Raspberry:'z', Blueberry:'z', Cherry:'z', 'Mango Slice':'z', 'Kiwi Slice':'z', 'Peach Slice':'z', 'Banana Slice':'z' };
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
        if(typeof window._requestRender==='function') window._requestRender(2000);
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
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    fruitRangeY.addEventListener('input', function(){
        const d = parseInt(this.value);
        fruitDegLabelY.textContent = d + '°';
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[activeFruitPanelIdx];
        if(m){ m.group.rotation.y = d * Math.PI / 180; }
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    document.querySelectorAll('.fruit-rot-panel-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = parseInt(btn.dataset.deg);
            range.value = d; degLabel.textContent = d + '°';
            preview.style.transform = `rotate(${d}deg)`;
            const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
            const m = models[activeFruitPanelIdx];
            if(m){ const axis = getAxis(m.fruit); m.group.rotation[axis] = d * Math.PI / 180; }
            if(typeof window._requestRender==='function') window._requestRender(500);
        });
    });
document.getElementById('fruitRotPanelApply').addEventListener('click', () => {
        const deg = parseInt(range.value);
        const em = emojiEl.textContent;
        showToast(`${em} Rotated ${deg}°`, 1600);
        hidePanel();
    });

    document.getElementById('fruitRotPanelDelete').addEventListener('click', () => {
        const idx = activeFruitPanelIdx;
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[idx];
        if (!m) { hidePanel(); return; }
        const em = FRUIT_EMOJI[m.fruit] || '🍓';
        const name = m.fruit;
        if (typeof window.removeFruitModel === 'function') window.removeFruitModel(idx);
        hidePanel();
        showToast(`${em} ${name} removed`, 1800);
        if (typeof window._updateAll === 'function') window._updateAll();
    });

document.getElementById('fruitRotPanelReset').addEventListener('click', () => {
        range.value = 0; degLabel.textContent = '0°';
        fruitRangeY.value = 0; fruitDegLabelY.textContent = '0°';
        preview.style.transform = 'rotate(0deg)';
        const models = typeof window.getFruitModels === 'function' ? window.getFruitModels() : [];
        const m = models[activeFruitPanelIdx];
        if(m){ const axis = getAxis(m.fruit); m.group.rotation[axis] = 0; m.group.rotation.y = 0; }
        if(typeof window._requestRender==='function') window._requestRender(500);
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

    const CHOCO_EMOJI = { ferrero:'🟤', kitkat:'🍬', oreo:'⚫', barshard:'🍫', toblerone:'🔺' };
    const CHOCO_NAME  = { ferrero:'Ferrero', kitkat:'KitKat', oreo:'Oreo', barshard:'Bar Shard', toblerone:'Toblerone' };
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
        if(type==='toblerone')return typeof window.getTobleroneModels==='function'?window.getTobleroneModels():[];
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
        if(typeof window._requestRender==='function') window._requestRender(2000);
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
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    rangeY.addEventListener('input', function(){
        const d = parseInt(this.value);
        degLabelY.textContent = d + '°';
        const models = getModels(activeChocoType);
        const m = models[activeChocoPanelIdx];
        if(m){ m.group.rotation.y = d * Math.PI / 180; }
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    document.querySelectorAll('.choco-rot-inline-preset').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = parseInt(btn.dataset.deg);
            range.value = d; degLabel.textContent = d + '°';
            preview.style.transform = `rotate(${d}deg)`;
            const models = getModels(activeChocoType);
            const m = models[activeChocoPanelIdx];
            if(m){ m.group.rotation.z = d * Math.PI / 180; }
            if(typeof window._requestRender==='function') window._requestRender(500);
        });
    });
document.getElementById('chocoRotInlineApply').addEventListener('click', () => {
        const deg = parseInt(range.value);
        const em = emojiEl.textContent;
        showToast(`${em} Rotated ${deg}°`, 1600);
        hideChocoPanel();
    });

    document.getElementById('chocoRotInlineDelete').addEventListener('click', () => {
        const type = activeChocoType;
        const idx  = activeChocoPanelIdx;
        const em   = CHOCO_EMOJI[type]  || '🍫';
        const name = CHOCO_NAME[type]   || type;
     const removeFnMap = {
            ferrero:   window.removeFerreroModel,
            kitkat:    window.removeKitkatModel,
            oreo:      window.removeOreoModel,
            barshard:  window.removeBarShardModel,
            toblerone: window.removeTobleroneModel,
        };
        const removeFn = removeFnMap[type];
        if (typeof removeFn === 'function') removeFn(idx);
        hideChocoPanel();
        showToast(`${em} ${name} removed`, 1800);
        if (typeof window._updateAll === 'function') window._updateAll();
    });
document.getElementById('chocoRotInlineReset').addEventListener('click', () => {
        range.value = 0; degLabel.textContent = '0°';
        rangeY.value = 0; degLabelY.textContent = '0°';
        preview.style.transform = 'rotate(0deg)';
        const models = getModels(activeChocoType);
        const m = models[activeChocoPanelIdx];
        if(m){ m.group.rotation.z = 0; m.group.rotation.y = 0; }
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    document.getElementById('chocoRotInlineClose').addEventListener('click', hideChocoPanel);
    document.addEventListener('keydown', e => { if(e.key === 'Escape') hideChocoPanel(); });

window._showChocoRotatePanel = showChocoPanel;
    window._hideChocoRotatePanel = hideChocoPanel;
})();
// ── CHARACTER TOPPER MOVE/ROTATE PANEL (works per placed instance) ──
(function(){
    const panel    = document.getElementById('characterMovePanel');
    const range    = document.getElementById('characterMovePanelRange');
    const degLabel = document.getElementById('characterMovePanelDeg');
    const nameEl   = document.getElementById('characterMovePanelName');
    let activeIdx  = -1;

    const viewer = document.getElementById('viewerEl');
    if(viewer) viewer.appendChild(panel);
    panel.style.cssText = 'display:none;position:absolute;top:58px;left:14px;z-index:50;width:260px;border-radius:14px;overflow:hidden;border:1.5px solid rgba(90,110,196,.35);box-shadow:0 4px 20px rgba(30,15,5,0.35);';

    function refreshDeg(){
        const d = typeof window.getCharacterYRotationDeg==='function' ? window.getCharacterYRotationDeg(activeIdx) : 0;
        range.value = d;
        degLabel.textContent = d + '°';
    }
    function showPanel(idx){
        activeIdx = idx;
        const models = typeof window.getCharacterModels==='function' ? window.getCharacterModels() : [];
        const m = models[idx];
        nameEl.textContent = m ? m.key : 'character';
        refreshDeg();
        panel.style.display = 'block';
    }
    function hidePanel(){ panel.style.display = 'none'; activeIdx = -1; }

    range.addEventListener('input', function(){
        const d = parseInt(this.value);
        degLabel.textContent = d + '°';
        if(typeof window.setCharacterYRotation==='function') window.setCharacterYRotation(activeIdx, d);
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    document.querySelectorAll('.character-move-preset').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            const d = parseInt(btn.dataset.deg);
            range.value = d; degLabel.textContent = d + '°';
            if(typeof window.setCharacterYRotation==='function') window.setCharacterYRotation(activeIdx, d);
            if(typeof window._requestRender==='function') window._requestRender(500);
        });
    });
    document.getElementById('characterMovePanelReset').addEventListener('click', ()=>{
        range.value = 0; degLabel.textContent = '0°';
        if(typeof window.setCharacterYRotation==='function') window.setCharacterYRotation(activeIdx, 0);
        if(typeof window._requestRender==='function') window._requestRender(500);
    });
    document.getElementById('characterMovePanelDelete').addEventListener('click', ()=>{
        if(activeIdx>=0 && typeof window.removeCharacterModel==='function') window.removeCharacterModel(activeIdx);
        hidePanel();
        if(typeof window.getCharacterModels==='function'){
            const remaining = window.getCharacterModels().length;
            const badge = document.getElementById('characterActiveBadge');
            if(remaining===0 && typeof state !== 'undefined'){
                state.addons.delete('Character Topper');
                const btn = document.getElementById('characterToggleBtn');
                if(btn) btn.classList.remove('active');
                if(badge) badge.textContent = 'None placed yet — tap a character to add';
            } else if(badge){
                badge.textContent = `${remaining} placed — tap any character again to add more`;
            }
        }
        if(typeof window._updateAll === 'function') window._updateAll();
        showToast('🎭 Character topper removed', 1800);
    });
    document.getElementById('characterMovePanelClose').addEventListener('click', hidePanel);

    window._showCharacterMovePanel = showPanel;
    window._hideCharacterMovePanel = hidePanel;
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

window._dumpScene = function(){
    console.log('=== FULL SCENE DUMP ===');
    scene.updateMatrixWorld(true);
    scene.traverse(obj=>{
        if(!obj.isMesh && !obj.isGroup) return;
        const box = new THREE.Box3().setFromObject(obj);
        const size = box.getSize(new THREE.Vector3());
        if(size.y > 1.0 || Math.max(size.x,size.z) > 1.0){
            console.log(obj.isMesh ? 'MESH' : 'GROUP', `"${obj.name || '(unnamed)'}"`,
                'size:', {x:+size.x.toFixed(3), y:+size.y.toFixed(3), z:+size.z.toFixed(3)},
                'parent:', obj.parent ? (obj.parent.name || obj.parent.type) : 'none',
                obj);
        }
    });
    console.log('=== END DUMP ===');
};
</script>

<script>
const TIER_INDEX = {'Single':0,'Two-tier':1,'Three-tier':2};
function getTierIdx(){ return TIER_INDEX[state.tier] ?? 0; }

// Cake Style — priced against whichever style is currently ACTIVE
const CAKE_STYLE_TIER_PRICES = {
    'Smooth Buttercream': [0,250,450],
    'Semi-naked Style':   [200,400,600],
    'Fondant Smooth':     [350,750,1100],
    'Ombre Style':        [250,500,750],
};
// Frosting section — Shell Border only charges this when it's layered as an
// EXTRA overlay on top of Semi-naked/Ombre (when it IS the cake style itself,
// it's already covered by CAKE_STYLE_TIER_PRICES above).
const FROSTING_SHELL_TIER_PRICES   = [0,100,180];
const FROSTING_SUGAR_TIER_PRICES   = [150,300,450];
const FROSTING_TEXTURE_TIER_PRICES = [150,300,450];
const FROSTING_ROSETTE_TIER_PRICES = [100,300,500];
const ADDON_TIER_PRICES = {
    'Drip':                [180,300,450],
    'Cylinder Sprinkles':  [30,50,70],
    'Sphere Sprinkles':    [30,50,70],
    'Chocolate Curls':     [45,80,120],
    'Chocolate Sprinkles': [30,50,75],
    'Crushed Peanuts':     [35,60,90],
};

// Keeps every priced button's visible text AND data-price in sync with the
// currently selected tier, so click handlers that read dataset.price always
// pick up the right tier-adjusted amount.
function refreshTierPriceLabels(){
    const ti = getTierIdx();
    function setLabel(selector, price, opts){
        const el = document.querySelector(selector);
        if(!el) return;
        const span = el.classList.contains('a-price') ? el : el.querySelector('.a-price');
        if(!span) return;
        const suffix = opts && opts.suffix ? ' · '+opts.suffix : '';
        span.textContent = price===0 ? `Default · Included${suffix}` : `+₱${price.toLocaleString()}${suffix}`;
        if(el.dataset) el.dataset.price = price;
    }

    setLabel('#opts-cake-style [data-val="Smooth Buttercream"]', CAKE_STYLE_TIER_PRICES['Smooth Buttercream'][ti]);
    setLabel('#opts-cake-style [data-val="Semi-naked Style"]',   CAKE_STYLE_TIER_PRICES['Semi-naked Style'][ti]);
    setLabel('#opts-cake-style [data-val="Fondant Smooth"]',     CAKE_STYLE_TIER_PRICES['Fondant Smooth'][ti]);
    setLabel('#opts-cake-style [data-val="Ombre Style"]',        CAKE_STYLE_TIER_PRICES['Ombre Style'][ti]);

    setLabel('#opts-frosting-base [data-val="Smooth Buttercream"]', FROSTING_SHELL_TIER_PRICES[ti], {suffix:'choose color'});
    setLabel('#opts-frosting-base [data-val="Sugar Icing"]',        FROSTING_SUGAR_TIER_PRICES[ti], {suffix:'choose color'});

    setLabel('#opts-frosting-special [data-val="Textured Buttercream"]', FROSTING_TEXTURE_TIER_PRICES[ti], {suffix:'add-on'});
    setLabel('#opts-frosting-special [data-val="Rosettes"]',             FROSTING_ROSETTE_TIER_PRICES[ti], {suffix:'add-on'});

    setLabel('#dripToggleBtn', ADDON_TIER_PRICES['Drip'][ti], {suffix:'pick flavor'});

    setLabel('#opts-sprinkles [data-val="Cylinder Sprinkles"]', ADDON_TIER_PRICES['Cylinder Sprinkles'][ti]);
    setLabel('#opts-sprinkles [data-val="Sphere Sprinkles"]',   ADDON_TIER_PRICES['Sphere Sprinkles'][ti]);

    setLabel('#opts-choco [data-val="Chocolate Curls"]',     ADDON_TIER_PRICES['Chocolate Curls'][ti],     {suffix:'add-on'});
    setLabel('#opts-choco [data-val="Chocolate Sprinkles"]', ADDON_TIER_PRICES['Chocolate Sprinkles'][ti]);
    setLabel('#opts-choco [data-val="Crushed Peanuts"]',     ADDON_TIER_PRICES['Crushed Peanuts'][ti]);

    // Any of these add-ons already active on the cake get their stored price
    // bumped/dropped immediately too, so the total reflects the new tier
    // even without the customer re-clicking the button.
    Object.keys(ADDON_TIER_PRICES).forEach(k=>{
        if(state.addons.has(k)) state.addons.set(k, ADDON_TIER_PRICES[k][ti]);
    });
}
const CHARACTER_PRICES = {
    'SpongeBob':350,'Squidward':350,'Patrick Star':350,'Gary':350,
    "Squidward's House":500,"SpongeBob's House":500,"Patrick's House":500,
    'Ben 10':350,'Ben 10 RV':350,'Gwen':350,'Lolo Max':350,
    'Buttercup':350,'Blossom':350,'Bubbles':350,'Powerpuff House':500,
    'Dora':350,'Boots':350,"Dora's House":500,
    'Kuromi':350,'My Melody':350,'Cinnamoroll':350,'Hello Kitty':350,
    'Lightning McQueen':350,'Sally':350,
    'Mickey Mouse':350,'Minnie Mouse':350,'Mickey Mouse Clubhouse':500,
    'Cocomelon':350,
};
// Final Cake Type list: Sponge Cake, Chiffon Cake, Cheesecake — Butter Cake removed completely.
const CAKE_TYPE_GENERIC   = ['Sponge Cake','Chiffon Cake','Cheesecake'];
// No Cake Type auto-defines its own flavor anymore — Flavor is always a separate pick,
// including for Cheesecake (Blueberry Cheesecake, Strawberry Cheesecake, etc. are now
// Cake Type "Cheesecake" + Flavor, not standalone Cake Types). Left empty and referenced
// below so existing conditional logic keeps working unmodified.
const CAKE_TYPE_SPECIALTY = [];
const CAKE_TYPE_TO_FLAVOR = {};
// Maps Cake Type "Cheesecake" + a given Flavor to the existing FLAVORS palette key that
// already has dedicated cheesecake-style coloring — preserves the original 3D look for
// Blueberry/Strawberry/Mango Cheesecake without inventing new visual configs.
const CHEESECAKE_FLAVOR_MAP = {
    'Blueberry':  'Blueberry Cheesecake',
    'Strawberry': 'Strawberry Cheesecake',
    'Mango':      'Mango Cheesecake',
};
// Optional per-type upcharge — defaults to 0 so existing pricing is unaffected
// unless a type is explicitly priced here. Tune freely.
const CAKE_TYPE_PRICES = {
    'Sponge Cake':0,'Chiffon Cake':0,'Cheesecake':150,
};
const CAKE_TYPE_SHAPE_RESTRICTIONS = {
    'Cheesecake': ['Number','Bundt'],
};

// ── FILLING (between the cake layers — separate from Cake Type/Flavor) ──
const FILLING_PRICES = {
    'No Filling':0,'Vanilla Cream':40,'Chocolate Ganache':60,'Cream Cheese':60,
    'Strawberry':50,'Blueberry':50,'Biscoff':70,
};
const FONDANT_VAL    ='Fondant Smooth';
const SUGAR_ICING_VAL='Sugar Icing';
const BASE_COAT_VALS =['Smooth Buttercream','Sugar Icing'];
const SHAPE_PRICES   ={'Round':350,'Square':500,'Heart':520,'Bundt':480,'Sponge Cake':300,'Chiffon':320,'Two-tier Round':950,'Three-tier Round':1400,'Number':600};
const ROUND_SIZE_PRICES={4:180,5:220,6:280,7:350,8:420,9:500,10:600};
const FRUIT_KEYS=['Strawberry','Blueberry','Raspberry','Cherry','Mango Slice','Kiwi Slice','Peach Slice','Banana Slice'];
const PLAQUE_SHAPE_FILES = {
    'Square':'plaque_square','Rectangle':'plaque_rectangle','Circle':'plaque_circle',
    'Heart':'plaque_heart','Oval':'plaque_oval',
};
const CAKE_STYLE_VALS_INIT = ['Smooth Buttercream','Semi-naked Style','Fondant Smooth'];
const state={
    shape:'Round', tier:'Single', roundSize:6,
    numberDigits:1, numberChoice:0, numberTens:1, numberUnits:0,
    cakeType:'Sponge Cake',
    flavor:'Vanilla',
    filling:'No Filling',
    frostings:new Set(['Smooth Buttercream']),
    addons:new Map(),
    hasDrip:false, dripFlavor:'Vanilla',
icingColor:'#FFFFFF', icingColorName:'White', hasCustomIcingColor:false,
    rosettePlacement:'Border', rosetteColor:'#FFFFFF', rosetteColorName:'White',
    ombreTopColor:'#F7A8C4', ombreBottomColor:'#8A6AC8',
    placedFruits:[],
    placedFerrero:[],
    kitkatOrientation:'standing',
    placedKitkat:[],
    oreoOrientation:'lying',
    placedOreo:[],
placedBarShard:[],
    placedToblerone:[],
    tobleroneFlavor:'Chocolate',
  placedCandles:[],
  chocoCurlsPlacement:'middle',
plaqueShape: 'Square',
    plaqueMessage: '',
    characterTopper: 'Mickey Mouse',
};
function showToast(msg,duration=2800){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),duration);}

function playIcingBagAnimation(){
    const viewer = document.getElementById('viewerEl');
    const overlay = document.getElementById('icingAnimOverlay');
    if(!viewer || !overlay) return;

    overlay.innerHTML = `
        <div class="icing-anim-bag" id="icingAnimBag">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 8 C14 4 20 2 32 2 C44 2 50 4 50 8 L46 30 C46 34 40 38 32 38 C24 38 18 34 18 30 Z" fill="#F5EFE2" stroke="#C9AF8C" stroke-width="1.5"/>
                <path d="M28 38 L36 38 L33 54 L31 54 Z" fill="#E8D9A0" stroke="#C9AF8C" stroke-width="1.5"/>
                <circle cx="32" cy="55" r="3" fill="#FFFDF6"/>
                <path d="M20 14 Q32 10 44 14" stroke="#C9AF8C" stroke-width="1.2" fill="none" opacity="0.6"/>
            </svg>
        </div>`;

    overlay.classList.remove('playing');
    void overlay.offsetWidth; // force reflow so the animation restarts every time
    overlay.classList.add('playing');

    const waypoints = [
        {t:0,   left:-14, top:10},
        {t:15,  left:8,   top:6},
        {t:35,  left:30,  top:14},
        {t:50,  left:50,  top:6},
        {t:65,  left:70,  top:14},
        {t:85,  left:92,  top:8},
        {t:100, left:108, top:6},
    ];
    function sampleAt(pct){
        for(let i=0;i<waypoints.length-1;i++){
            const a=waypoints[i], b=waypoints[i+1];
            if(pct>=a.t && pct<=b.t){
                const localT=(pct-a.t)/(b.t-a.t);
                return { left:a.left+(b.left-a.left)*localT, top:a.top+(b.top-a.top)*localT };
            }
        }
        return waypoints[waypoints.length-1];
    }

    const DURATION=2600, DRIP_INTERVAL=90;
    let elapsed=0;
    const dripTimer=setInterval(()=>{
        elapsed+=DRIP_INTERVAL;
        const pct=Math.min(100,(elapsed/DURATION)*100);
        const pos=sampleAt(pct);
        const drip=document.createElement('div');
        drip.className='icing-anim-drip';
        drip.style.left = (pos.left+4) + '%';
        drip.style.top  = (pos.top+16) + '%';
        overlay.appendChild(drip);
        setTimeout(()=>drip.remove(), 900);
        if(elapsed>=DURATION) clearInterval(dripTimer);
    }, DRIP_INTERVAL);

    setTimeout(()=>{ overlay.classList.remove('playing'); overlay.innerHTML=''; }, DURATION+150);
}
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
        if(state.shape === 'Bundt'){
            state.frostings.delete('Textured Buttercream');
            if(state.frostings.has(FONDANT_VAL)){
                state.frostings.delete(FONDANT_VAL);
                state.frostings.add('Semi-naked Style');
            }
        }
        syncFrostingUI(); // refresh Shell Border lock state (restricted for Bundt)
             // Reset tier to Single for non-Round shapes
        if(state.shape !== 'Round'){
            state.tier = 'Single';
            document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(x=>x.classList.toggle('active', x.dataset.tier==='Single'));
            refreshTierPriceLabels();
        }
       // Disable Two/Three-tier buttons when shape is not Round
        document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(x=>{
            const isTiered = x.dataset.tier !== 'Single';
            x.style.opacity = (state.shape !== 'Round' && isTiered) ? '0.35' : '';
            x.style.pointerEvents = (state.shape !== 'Round' && isTiered) ? 'none' : '';
        });
        document.getElementById('cakeTierSection').style.display = (state.shape === 'Round') ? '' : 'none';
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
       if(typeof window._updateChocoCurlsPlacementAvailability==='function') window._updateChocoCurlsPlacementAvailability();
        if(state.frostings.has('Sugar Icing')) window._pendingIcingReveal = true;
        if(state.frostings.has('Smooth Buttercream') && !state.frostings.has('Fondant Smooth')) window._pendingShellReveal = true;
        if(state.frostings.has('Rosettes')) window._pendingRosetteReveal = true;
        if(state.frostings.has('Fondant Smooth')) window._pendingFondantReveal = true;
        redrawFruits();
        updateAll();
        if(typeof window._prefetchRosetteModels==='function') window._prefetchRosetteModels(state.shape);
    });
});
// ── TIER ──
document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(el=>{
    el.addEventListener('click',()=>{
        if(state.shape !== 'Round' && el.dataset.tier !== 'Single') return;
        document.getElementById('opts-tier').querySelectorAll('[data-tier]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.tier = el.dataset.tier;
        refreshTierPriceLabels();
        updateAll();
        showToast(`Prices updated for ${state.tier} cake`, 1800);
    });
});

document.getElementById('sizeRange').addEventListener('input',function(){
    if(typeof window._saveAllToppingNormals==='function') window._saveAllToppingNormals();
    state.roundSize=parseInt(this.value);
    document.getElementById('sizeDisplay').textContent=state.roundSize;
    updateAll();
});
function refreshDualPreview(){document.getElementById('dualPreview').childNodes[0].textContent=`${state.numberTens}${state.numberUnits}`;}
document.getElementById('opts-number').querySelectorAll('.num-opt').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-number').querySelectorAll('.num-opt').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.numberChoice=parseInt(el.dataset.val);if(typeof window._updateChocoCurlsPlacementAvailability==='function')window._updateChocoCurlsPlacementAvailability();updateAll();});});
document.getElementById('opts-tens').querySelectorAll('.num-opt-sm').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-tens').querySelectorAll('.num-opt-sm').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.numberTens=parseInt(el.dataset.val);refreshDualPreview();updateAll();});});
document.getElementById('opts-units').querySelectorAll('.num-opt-sm').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-units').querySelectorAll('.num-opt-sm').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.numberUnits=parseInt(el.dataset.val);refreshDualPreview();updateAll();});});
document.getElementById('btnSingleDigit').addEventListener('click',()=>{state.numberDigits=1;document.getElementById('btnSingleDigit').classList.add('active');document.getElementById('btnDualDigit').classList.remove('active');document.getElementById('singleDigitSection').style.display='';document.getElementById('dualDigitSection').classList.remove('visible');updateAll();});
document.getElementById('btnDualDigit').addEventListener('click',()=>{state.numberDigits=2;document.getElementById('btnDualDigit').classList.add('active');document.getElementById('btnSingleDigit').classList.remove('active');document.getElementById('singleDigitSection').style.display='none';document.getElementById('dualDigitSection').classList.add('visible');refreshDualPreview();updateAll();});
// ── FLAVOUR ──
document.getElementById('opts-flavor').querySelectorAll('[data-val]').forEach(el=>{el.addEventListener('click',()=>{document.getElementById('opts-flavor').querySelectorAll('[data-val]').forEach(x=>x.classList.remove('active'));el.classList.add('active');state.flavor=el.dataset.val;updateAll();});});

// ── CAKE TYPE ──
function syncCakeTypeUI(){
    const isSpecialty = CAKE_TYPE_SPECIALTY.includes(state.cakeType);
    const flavourSection = document.getElementById('flavourSection');
    if(flavourSection) flavourSection.style.display = isSpecialty ? 'none' : '';
    if(isSpecialty){
        // Specialty types already define their flavor — drive the 3D color
        // palette from the cake type itself instead of a separate pick.
        state.flavor = CAKE_TYPE_TO_FLAVOR[state.cakeType] || state.flavor;
    }
    // Compatibility: some cake types don't fit every shape.
    const restricted = CAKE_TYPE_SHAPE_RESTRICTIONS[state.cakeType] || [];
    document.getElementById('opts-shape').querySelectorAll('[data-val]').forEach(x=>{
        const isRestricted = restricted.includes(x.dataset.val);
        x.style.opacity = isRestricted ? '0.35' : '';
        x.style.pointerEvents = isRestricted ? 'none' : '';
    });
    if(restricted.includes(state.shape)){
        const roundBtn = document.getElementById('opts-shape').querySelector('[data-val="Round"]');
        if(roundBtn) roundBtn.click();
    }
}
document.getElementById('opts-cake-type').querySelectorAll('[data-cake-type]').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('opts-cake-type').querySelectorAll('[data-cake-type]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.cakeType = el.dataset.cakeType;
        if(state.cakeType === 'Cheesecake' && state.frostings.has(FONDANT_VAL)){
            state.frostings.delete(FONDANT_VAL);
            state.frostings.add('Smooth Buttercream');
        }
        syncCakeTypeUI();
        syncFrostingUI();
        updateAll();
    });
});
syncCakeTypeUI();

// ── FILLING ──
document.getElementById('opts-filling').querySelectorAll('[data-filling]').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('opts-filling').querySelectorAll('[data-filling]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.filling = el.dataset.filling;
        updateAll();
    });
});
const CAKE_STYLE_VALS = ['Semi-naked Style','Ombre Style','Fondant Smooth','Smooth Buttercream'];
const CAKE_STYLE_VALS_ALL = ['Semi-naked Style','Ombre Style','Fondant Smooth','Smooth Buttercream'];
document.getElementById('opts-cake-style').querySelectorAll('.frosting-opt').forEach(el=>{
    el.addEventListener('click',()=>{
        const v = el.dataset.val;
        if(typeof window._prefetchRosetteModels==='function') window._prefetchRosetteModels(state.shape);
        if(el.classList.contains('active')) return;
   if(v === FONDANT_VAL && state.cakeType === 'Cheesecake'){
            showToast('Fondant is not available for Cheesecake');
            return;
        }
        if(v === FONDANT_VAL && state.shape === 'Bundt'){
            showToast('Fondant is not available for Bundt cakes');
            return;
        }
        // Visually uncheck ALL cake style buttons
        document.getElementById('opts-cake-style').querySelectorAll('.frosting-opt').forEach(x=>{
            x.classList.remove('active');
            const chk = x.querySelector('.addon-check');
            if(chk){ chk.style.background=''; chk.style.borderColor=''; }
            const svg = x.querySelector('.addon-check svg');
            if(svg) svg.style.opacity='0';
            const nm = x.querySelector('.a-name');
            if(nm) nm.style.color='';
            x.style.borderColor='';
            x.style.background='';
            x.style.boxShadow='';
        });

        // Visually check the clicked one
        el.classList.add('active');
        const chk = el.querySelector('.addon-check');
        if(chk){ chk.style.background='var(--caramel)'; chk.style.borderColor='var(--caramel)'; }
        const svg = el.querySelector('.addon-check svg');
        if(svg) svg.style.opacity='1';
        const nm = el.querySelector('.a-name');
        if(nm) nm.style.color='var(--caramel)';

// Only clear the mutually-exclusive STYLE markers — NOT 'Smooth Buttercream',
// which doubles as the Shell Border toggle. Deleting it on every style switch
// was wiping out an already-active Shell Border the instant the user picked
// Semi-naked or Ombre, forcing them to re-click Shell Border to bring it back.
['Semi-naked Style','Ombre Style','Fondant Smooth'].forEach(s=>state.frostings.delete(s));
// Don't blindly re-add 'Smooth Buttercream' when Rosettes is the active base icing —
// Rosettes already occupies that slot, and re-adding it here was silently re-enabling
// Shell Border underneath Rosettes, producing a "Rosettes + Smooth Buttercream" conflict.
if(v === 'Smooth Buttercream' && state.frostings.has('Rosettes')){
    // keep Rosettes as the base icing — just switch off Semi-naked/Ombre/Fondant (done above)
} else {
    state.frostings.add(v);
}

if(v===FONDANT_VAL){
    state.frostings.delete('Textured Buttercream');
    state.frostings.delete(SUGAR_ICING_VAL);
    state.frostings.delete('Smooth Buttercream');
    state.frostings.delete('Rosettes'); // Fondant replaces all base icing/texture options
    window._pendingFondantReveal = true;
} else if(v==='Smooth Buttercream'){
    // If Sugar Icing or Rosettes is already the active base icing, don't override it —
    // just remove the 'Smooth Buttercream' that might have been added above
    if(state.frostings.has(SUGAR_ICING_VAL) || state.frostings.has('Rosettes')){
        state.frostings.delete('Smooth Buttercream');
    }
    // Textured and other add-ons stay as-is
}
// Semi-naked / Ombre: leave any existing Shell Border ('Smooth Buttercream') or Rosettes state untouched
        syncFrostingUI(); updateAll();
    });
});
allFrostingOpts().forEach(el=>{
    if(el.closest('#opts-cake-style')) return;
    el.addEventListener('click',()=>{
        if(state.frostings.has(FONDANT_VAL)){showToast('Fondant is selected — deselect it first from Cake Style');return;}
    const v = el.dataset.val;
        if(state.shape === 'Bundt' && (v === 'Textured Buttercream' || v === 'Rosettes')){
            showToast(v + ' is not available for Bundt cakes');
            return;
        }
if(v === 'Smooth Buttercream'){
            if(activeCakeStyleFn() === 'Semi-naked Style'){
                // In semi-naked: toggle Shell Border on/off independently
                // WITHOUT touching the cake style (Semi-naked stays selected)
                             const shellOn = state.frostings.has('Smooth Buttercream');
                if(shellOn){
                    state.frostings.delete('Smooth Buttercream');
                } else {
                    // Shell Border, Sugar Icing, and Rosettes are mutually exclusive
                    // base-icing choices — turning Shell Border on must clear both
                    // of the others, or two base icings can end up active together.
                    state.frostings.delete(SUGAR_ICING_VAL);
                    state.frostings.delete('Rosettes');
                    state.frostings.add('Smooth Buttercream');
                    window._pendingShellReveal = true;
                }
                // Ensure Semi-naked Style stays as the cake style
                state.frostings.delete('Fondant Smooth');
                if(!state.frostings.has('Semi-naked Style')) state.frostings.add('Semi-naked Style');
                syncFrostingUI(); updateAll();
                return;
     } else {
    // Normal Smooth BC cake style — remove Sugar Icing / Rosettes, ensure Smooth BC is in frostings
    state.frostings.delete(SUGAR_ICING_VAL);
    state.frostings.delete('Rosettes');
    if(!state.frostings.has('Smooth Buttercream')){
        state.frostings.add('Smooth Buttercream');
        window._pendingShellReveal = true;
    }
}
        } else if(v === SUGAR_ICING_VAL){
            if(state.frostings.has(SUGAR_ICING_VAL)){
                // Already the active base icing — clicking it again does nothing.
                // Pick a different base icing option (Shell Border / Rosettes) to switch away.
                return;
            } else {
                state.frostings.delete('Smooth Buttercream');
                state.frostings.delete('Rosettes');
                state.frostings.add(SUGAR_ICING_VAL);
                window._pendingIcingReveal = true;
            }
    } else if(v === 'Rosettes'){
            // Rosettes replace the base icing entirely — no Shell Border / Sugar Icing underneath
            if(state.frostings.has(v)){
                // Already the active base icing — clicking it again does nothing.
                // Pick a different base icing option (Shell Border / Sugar Icing) to switch away.
                return;
            } else {
                state.frostings.add(v);
                state.frostings.delete('Smooth Buttercream');
                state.frostings.delete(SUGAR_ICING_VAL);
                window._pendingRosetteReveal = true;
                // If the stored placement collides with a decoration already on the
                // cake, auto-switch to the first free placement instead of rendering
                // a broken combo.
                if(rosetteComboBlockedReason(state.rosettePlacement)){
                    const ROSETTE_ORDER = ['Border','Full Top','Sides','Cluster Right','Cluster Left'];
                    const free = ROSETTE_ORDER.find(pl => !addonBlocksRosettePlacement(pl));
                    if(free){
                        state.rosettePlacement = free;
                        document.querySelectorAll('#opts-rosette-placement [data-rosette-placement], #opts-rosette-combo [data-rosette-placement]').forEach(x=>x.classList.toggle('active', x.dataset.rosettePlacement===free));
                        const badge = document.getElementById('rosettePlacementBadge');
                        if(badge) badge.textContent = 'Selected: ' + free;
                        showToast('⚠ Switched Rosette placement to '+free+' — the previous spot was taken by another decoration.', 3200);
                    }
                }
            }
        } else {
            // Textured — toggle
            if(state.frostings.has(v)){
                state.frostings.delete(v);
            } else {
                const _tReason = rosetteBlocksAddon('textured');
                if(_tReason){ showToast('⚠ '+_tReason, 2600); return; }
                state.frostings.add(v);
            }
        }
        syncFrostingUI(); updateAll();
    });
});
function activeCakeStyleFn(){
    return CAKE_STYLE_VALS.find(s=>state.frostings.has(s)) || 'Smooth Buttercream';
}
function syncFrostingUI(){
    if(state.shape === 'Bundt'){
        state.frostings.delete('Textured Buttercream');
        if(state.frostings.has('Rosettes')){
            state.frostings.delete('Rosettes');
            if(![...state.frostings].some(f=>BASE_COAT_VALS.includes(f))) state.frostings.add('Smooth Buttercream');
        }
    }
  if(state.cakeType === 'Cheesecake' && state.frostings.has(FONDANT_VAL)){
        state.frostings.delete(FONDANT_VAL);
        if(![...state.frostings].some(f=>CAKE_STYLE_VALS.includes(f))) state.frostings.add('Smooth Buttercream');
    }
    if(state.shape === 'Bundt' && state.frostings.has(FONDANT_VAL)){
        state.frostings.delete(FONDANT_VAL);
        if(![...state.frostings].some(f=>CAKE_STYLE_VALS.includes(f))) state.frostings.add('Semi-naked Style');
    }
    const fondantActive   = state.frostings.has(FONDANT_VAL);
    const isSugarIcing    = state.frostings.has(SUGAR_ICING_VAL);
    const isTextured      = state.frostings.has('Textured Buttercream');
    const activeCakeStyle = CAKE_STYLE_VALS.find(s=>state.frostings.has(s)) || 'Smooth Buttercream';
  // ── Cake Style buttons (radio-style) ──
    document.getElementById('opts-cake-style').querySelectorAll('.frosting-opt').forEach(el=>{
        const isActive = el.dataset.val === activeCakeStyle;
        el.classList.toggle('active', isActive);
        const chk = el.querySelector('.addon-check');
        if(chk){ chk.style.background = isActive ? 'var(--caramel)' : ''; chk.style.borderColor = isActive ? 'var(--caramel)' : ''; }
        const svg = el.querySelector('.addon-check svg');
        if(svg) svg.style.opacity = isActive ? '1' : '0';
        const nm = el.querySelector('.a-name');
        if(nm) nm.style.color = isActive ? 'var(--caramel)' : '';
        el.style.borderColor  = isActive ? 'var(--caramel)' : '';
        el.style.background   = isActive ? 'var(--accent-lt)' : '';
        el.style.boxShadow    = isActive ? '0 0 0 3px rgba(200,137,74,0.15)' : '';
    if(el.dataset.val === FONDANT_VAL){
            const lockFondant = state.cakeType === 'Cheesecake' || state.shape === 'Bundt';
            el.style.opacity = lockFondant ? '0.38' : '';
            el.style.pointerEvents = lockFondant ? 'none' : '';
        }
    });
// ── Frosting/Icing section: fully lock when Fondant active ──
    const frostingBase    = document.getElementById('opts-frosting-base');
    const frostingSpecial = document.getElementById('opts-frosting-special');
    const icingLockOverlay = document.getElementById('frostingIcingLock');
    const rosetteActiveState = state.frostings.has('Rosettes');

     if(fondantActive){
        if(frostingBase)    { frostingBase.style.opacity='0.38'; frostingBase.style.pointerEvents='none'; }
        if(frostingSpecial) { frostingSpecial.style.opacity='0.38'; frostingSpecial.style.pointerEvents='none'; }
        if(icingLockOverlay) icingLockOverlay.style.display='flex';
    } else {
        // Shell Border / Sugar Icing / Rosettes are now all freely clickable —
        // picking one simply switches the base icing to that choice.
        if(frostingBase)    { frostingBase.style.opacity=''; frostingBase.style.pointerEvents=''; }
        if(frostingSpecial) { frostingSpecial.style.opacity=''; frostingSpecial.style.pointerEvents=''; }
        if(icingLockOverlay) icingLockOverlay.style.display='none';
        if(frostingBase){
            frostingBase.querySelectorAll('.frosting-opt').forEach(el=>{ el.style.opacity=''; el.style.pointerEvents=''; });
        }
    }
document.getElementById('opts-frosting-base').querySelectorAll('.frosting-opt').forEach(el=>{
        let isActive = false;
    if(el.dataset.val === 'Smooth Buttercream'){
            // Active whenever Shell Border ('Smooth Buttercream') is present in state —
            // it doubles as the default base coat AND an optional overlay for
            // Semi-naked / Ombre styles, so it must not depend on which cake style
            // is currently active or it'll wrongly show unchecked after a style switch.
            isActive = state.frostings.has('Smooth Buttercream') && !fondantActive;
        } else if(el.dataset.val === SUGAR_ICING_VAL){
            isActive = isSugarIcing && !fondantActive;
        } else {
            isActive = state.frostings.has(el.dataset.val) && !fondantActive;
        }
        el.classList.toggle('active', isActive);
        const chk = el.querySelector('.addon-check');
        if(chk){ chk.style.background = isActive ? 'var(--caramel)' : ''; chk.style.borderColor = isActive ? 'var(--caramel)' : ''; }
        const svg = el.querySelector('.addon-check svg');
        if(svg) svg.style.opacity = isActive ? '1' : '0';
        const nm = el.querySelector('.a-name');
        if(nm) nm.style.color = isActive ? 'var(--caramel)' : '';
      el.style.borderColor = isActive ? 'var(--caramel)' : '';
        el.style.background  = isActive ? 'var(--accent-lt)' : '';
        el.style.boxShadow   = isActive ? '0 0 0 3px rgba(200,137,74,0.12)' : '';
    });

    // Rosettes aren't available for Bundt cakes — lock the button visually.
    const rosetteBaseBtn = document.querySelector('#opts-frosting-base [data-val="Rosettes"]');
    if(rosetteBaseBtn){
        const lockRosetteBundt = state.shape === 'Bundt';
        if(lockRosetteBundt && !state.frostings.has('Rosettes')){
            rosetteBaseBtn.style.opacity = '0.38';
            rosetteBaseBtn.style.pointerEvents = 'none';
        } else {
            rosetteBaseBtn.style.opacity = '';
            rosetteBaseBtn.style.pointerEvents = '';
        }
    }

 // ── Texture button ──
    const isSemiNaked = activeCakeStyle === 'Semi-naked Style';
    const isBundtShapeTex = state.shape === 'Bundt';
    document.getElementById('opts-frosting-special').querySelectorAll('.frosting-opt').forEach(el=>{
        const isActive = state.frostings.has(el.dataset.val) && !fondantActive && !isSemiNaked && !isBundtShapeTex;
        el.classList.toggle('active', isActive);
        const chk = el.querySelector('.addon-check');
        if(chk){ chk.style.background = isActive ? 'var(--caramel)' : ''; chk.style.borderColor = isActive ? 'var(--caramel)' : ''; }
        const svg = el.querySelector('.addon-check svg');
        if(svg) svg.style.opacity = isActive ? '1' : '0';
        const nm = el.querySelector('.a-name');
        if(nm) nm.style.color = isActive ? 'var(--caramel)' : '';
        el.style.borderColor = isActive ? 'var(--caramel)' : '';
        el.style.background  = isActive ? 'var(--accent-lt)' : '';
        el.style.boxShadow   = isActive ? '0 0 0 3px rgba(200,137,74,0.12)' : '';
        // Disable visually when semi-naked or Bundt is active
        el.style.opacity = (isSemiNaked || isBundtShapeTex) ? '0.38' : '';
        el.style.pointerEvents = (isSemiNaked || isBundtShapeTex) ? 'none' : '';
    });
    // Also remove Textured from state when semi-naked or Bundt is selected
    if(isSemiNaked || isBundtShapeTex) state.frostings.delete('Textured Buttercream');

// ── Icing color panel — also available for Shell Border (Smooth Buttercream) ──
       const showShellBorderColor = state.frostings.has('Smooth Buttercream') && !isSugarIcing;
    document.getElementById('icingPanel').classList.toggle('visible', (isSugarIcing || showShellBorderColor) && !fondantActive);

    // ── Ombre color panel ──
    document.getElementById('ombreColorPanel').classList.toggle('visible', activeCakeStyle === 'Ombre Style' && !fondantActive);

   document.getElementById('fondantNotice').classList.toggle('visible', fondantActive);

const rosettePanelEl = document.getElementById('rosettePlacementPanel');
    if(rosettePanelEl){
        const rosetteOn = state.frostings.has('Rosettes') && !fondantActive;
        rosettePanelEl.classList.toggle('visible', rosetteOn);
const isNumberShape = state.shape === 'Number';
        // Only these digits have a dedicated "middle" rosette piece — must match
        // NUMBER_ROSETTE_DIGITS_WITH_MIDDLE in the module script above.
        const NUMBER_ROSETTE_MIDDLE_DIGITS = new Set([0,4,6,8,9]);
        // For dual-digit numbers, "Middle" is only offered when BOTH digits have
        // a dedicated middle piece — otherwise one digit would be missing it.
        const digitsForRosetteCheck = state.numberDigits === 2 ? [state.numberTens, state.numberUnits] : [state.numberChoice];
        const allDigitsHaveMiddle = digitsForRosetteCheck.every(d => NUMBER_ROSETTE_MIDDLE_DIGITS.has(d));
        const NUMBER_ROSETTE_OPTS = (isNumberShape && allDigitsHaveMiddle)
            ? ['Middle','Border','Full Top','Sides']
            : ['Border','Full Top','Sides'];
        // Rosettes now work for both single AND dual-digit numbers.
        const numberRosetteReady = isNumberShape;
           document.querySelectorAll('#opts-rosette-placement [data-rosette-placement]').forEach(el=>{
            const allowed = !isNumberShape || NUMBER_ROSETTE_OPTS.includes(el.dataset.rosettePlacement);
            el.style.display = allowed ? '' : 'none';
        });
        // Combo rendering is only implemented for single-digit numbers.
        const isSingleDigitNumber = isNumberShape && state.numberDigits === 1;
        const comboLabels = rosettePanelEl.querySelectorAll('.frosting-section-label');
        comboLabels.forEach(l=>{ l.style.display = (isNumberShape && !isSingleDigitNumber) ? 'none' : ''; });
        const comboGrid       = document.getElementById('opts-rosette-combo');
        const comboGridNumber = document.getElementById('opts-rosette-combo-number');
        if(comboGrid)       comboGrid.style.display       = isNumberShape ? 'none' : '';
        if(comboGridNumber) comboGridNumber.style.display = isSingleDigitNumber ? '' : 'none';
        if(comboGridNumber){
            const digitHasMiddle = NUMBER_ROSETTE_MIDDLE_DIGITS.has(state.numberChoice);
            comboGridNumber.querySelectorAll('[data-requires-middle]').forEach(el=>{
                el.style.display = digitHasMiddle ? '' : 'none';
            });
        }
        const numberComboOpts = ['Border+Sides','Full Top+Sides','Middle+Sides'];
        let validPlacement = !isNumberShape
            || (isSingleDigitNumber && (NUMBER_ROSETTE_OPTS.includes(state.rosettePlacement) || numberComboOpts.includes(state.rosettePlacement)))
            || (!isSingleDigitNumber && NUMBER_ROSETTE_OPTS.includes(state.rosettePlacement));
        if(validPlacement && state.rosettePlacement === 'Middle+Sides' && !NUMBER_ROSETTE_MIDDLE_DIGITS.has(state.numberChoice)){
            validPlacement = false; // this digit has no Middle piece
        }
        if(!validPlacement){
            state.rosettePlacement = 'Border';
        }
        document.querySelectorAll('#opts-rosette-placement [data-rosette-placement], #opts-rosette-combo [data-rosette-placement], #opts-rosette-combo-number [data-rosette-placement]').forEach(x=>x.classList.toggle('active', x.dataset.rosettePlacement===state.rosettePlacement));
        const badge = document.getElementById('rosettePlacementBadge');
        if(badge) badge.textContent = 'Selected: ' + state.rosettePlacement.replace('+',' + ');
        const rosetteNotice = document.getElementById('rosetteNumberDigitNotice');
        if(rosetteNotice) rosetteNotice.style.display = 'none';
        if(rosettePanelEl){
            rosettePanelEl.style.opacity = '';
            rosettePanelEl.style.pointerEvents = '';
        }
    }
    // ── Combo hint ──
    const hint = document.getElementById('frostingComboHint');
    const allActive = [...state.frostings].filter(f => f !== FONDANT_VAL);
    if(!fondantActive && allActive.length > 1){
        hint.classList.add('visible');
        document.getElementById('frostingComboLabel').textContent = allActive.join(' + ');
    } else {
        hint.classList.remove('visible');
    }
}
document.getElementById('icingColorGrid').querySelectorAll('.icing-color-opt').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('icingColorGrid').querySelectorAll('.icing-color-opt').forEach(x=>x.classList.remove('active'));
        el.classList.add('active'); state.icingColor=el.dataset.icingColor; state.icingColorName=el.dataset.icingName;
        state.hasCustomIcingColor=true;
        document.getElementById('icingColorLabel').textContent=el.dataset.icingName;
        updateAll();
    });
});

// ── ROSETTE PLACEMENT ↔ OTHER DECORATIONS MUTUAL EXCLUSION ──
const SPRINKLE_TYPE_ADDON_NAME = {
    cylinder: 'Cylinder Sprinkles',
    pearl: 'Sphere Sprinkles',
    chocoSprinkle: 'Chocolate Sprinkles',
    peanuts: 'Crushed Peanuts',
};
const SPRINKLE_TYPE_LABEL = {
    cylinder: 'Cylinder Mix',
    pearl: 'Pearl Mix',
    chocoSprinkle: 'Choco Sprinkles',
    peanuts: 'Crushed Peanuts',
};
// What each single rosette placement restricts elsewhere.
// Full Top: Choco Curls is blocked entirely (middle/sides/both all restricted —
// there's no valid placement left), and Choco Sprinkles/Crushed Peanuts/Pearl Mix/
// Cylinder Mix lose BOTH "top" and "both" (only "sides" stays available).
// Border: Choco Curls loses sides+both, but Middle stays available.
// Cluster Right/Left: no restrictions at all — everything stays available.
const ROSETTE_FORWARD_RESTRICT = {
    'Sides':         { textured:true, sprinkle:['sides','both'] },
    'Full Top':      { chocoCurlsBlockAll:true, plaque:true, sprinkle:['top','both'] },
    'Border':        { chocoCurls:['sides','both'] },
    'Cluster Right': {},
    'Cluster Left':  {},
};
function activeRosettePlacementList(){
    if(!state.frostings.has('Rosettes')) return [];
    return (state.rosettePlacement||'Border').split('+').map(s=>s.trim());
}
// Would the CURRENTLY selected rosette placement(s) block turning on/choosing `kind`/`value`?
function rosetteBlocksAddon(kind, value){
    const placements = activeRosettePlacementList();
    for(const pl of placements){
        const r = ROSETTE_FORWARD_RESTRICT[pl];
        if(!r) continue;
        if(kind==='textured' && r.textured) return `Rosette (${pl}) is active — Textured isn't available with it.`;
        if(kind==='plaque' && r.plaque) return `Rosette (${pl}) is active — Chocolate Plaque isn't available with it.`;
        if(kind==='chocoCurls'){
            if(r.chocoCurlsBlockAll) return `Rosette (${pl}) is active — Choco Curls isn't available with it.`;
            if(r.chocoCurls && r.chocoCurls.includes(value)) return `Rosette (${pl}) is active — Choco Curls (${value}) isn't available with it.`;
        }
        if(kind==='sprinkle' && r.sprinkle && r.sprinkle.includes(value)) return `Rosette (${pl}) is active — that placement isn't available with it.`;
    }
    return null;
}
// Would any CURRENTLY active other decoration block selecting rosette placement `pl`?
function addonBlocksRosettePlacement(pl){
    const r = ROSETTE_FORWARD_RESTRICT[pl];
    if(!r) return null;
    if(r.textured && state.frostings.has('Textured Buttercream')) return `Textured is active — remove it first to use Rosette (${pl}).`;
    if(r.plaque && state.addons.has('Chocolate Plaque')) return `Chocolate Plaque is active — remove it first to use Rosette (${pl}).`;
    if(r.chocoCurlsBlockAll && state.addons.has('Chocolate Curls')) return `Choco Curls is active — remove it first to use Rosette (${pl}).`;
    if(r.chocoCurls && state.addons.has('Chocolate Curls') && r.chocoCurls.includes(state.chocoCurlsPlacement)) return `Choco Curls (${state.chocoCurlsPlacement}) is active — change or remove it first to use Rosette (${pl}).`;
    if(r.sprinkle){
        for(const type of Object.keys(SPRINKLE_TYPE_ADDON_NAME)){
            const name = SPRINKLE_TYPE_ADDON_NAME[type];
            const curP = (window._sprinklePlacement && window._sprinklePlacement[type]) || 'top';
            if(state.addons.has(name) && r.sprinkle.includes(curP)){
                return `${SPRINKLE_TYPE_LABEL[type]} (${curP}) is active — change or remove it first to use Rosette (${pl}).`;
            }
        }
    }
    return null;
}
function rosetteComboBlockedReason(comboPlacement){
    const parts = (comboPlacement||'').split('+').map(s=>s.trim());
    for(const pl of parts){
        const reason = addonBlocksRosettePlacement(pl);
        if(reason) return reason;
    }
    return null;
}
// Visually locks buttons on both sides so the conflict is obvious before a click.
function syncRosetteAddonLocks(){
    const rosetteOn = state.frostings.has('Rosettes') && !state.frostings.has(FONDANT_VAL);
    const activePl = activeRosettePlacementList();
    const lockTextured = rosetteOn && activePl.some(pl => ROSETTE_FORWARD_RESTRICT[pl] && ROSETTE_FORWARD_RESTRICT[pl].textured);
    const lockPlaque   = rosetteOn && activePl.some(pl => ROSETTE_FORWARD_RESTRICT[pl] && ROSETTE_FORWARD_RESTRICT[pl].plaque);
    const lockChocoCurlsAll = rosetteOn && activePl.some(pl => ROSETTE_FORWARD_RESTRICT[pl] && ROSETTE_FORWARD_RESTRICT[pl].chocoCurlsBlockAll);
    const lockedCurls  = new Set();
    const lockedSprinkle = new Set();
    if(rosetteOn){
        activePl.forEach(pl=>{
            const r = ROSETTE_FORWARD_RESTRICT[pl];
            if(!r) return;
            (r.chocoCurls||[]).forEach(p=>lockedCurls.add(p));
            (r.sprinkle||[]).forEach(p=>lockedSprinkle.add(p));
        });
    }
    const texturedBtn = document.querySelector('#opts-frosting-special [data-val="Textured Buttercream"]');
    if(texturedBtn && lockTextured && !texturedBtn.classList.contains('active')){
        texturedBtn.style.opacity='0.35'; texturedBtn.style.pointerEvents='none';
    }
    const plaqueBtn = document.getElementById('plaqueToggleBtn');
    if(plaqueBtn){
        if(lockPlaque && !state.addons.has('Chocolate Plaque')){
            plaqueBtn.style.opacity='0.35'; plaqueBtn.style.pointerEvents='none';
        } else if(!state.addons.has('Chocolate Plaque')){
            plaqueBtn.style.opacity=''; plaqueBtn.style.pointerEvents='';
        }
    }
    // Choco Curls master toggle — fully locked (grayed + unclickable), same
    // treatment as the Chocolate Plaque button above, whenever the active
    // rosette placement blocks Choco Curls entirely (e.g. Full Top).
    const chocoCurlsBtn = document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Curls"]');
    if(chocoCurlsBtn){
        if(lockChocoCurlsAll && !state.addons.has('Chocolate Curls')){
            chocoCurlsBtn.style.opacity='0.35'; chocoCurlsBtn.style.pointerEvents='none';
        } else if(!state.addons.has('Chocolate Curls')){
            chocoCurlsBtn.style.opacity=''; chocoCurlsBtn.style.pointerEvents='';
        }
    }
    document.querySelectorAll('.choco-curls-place-btn').forEach(btn=>{
        const p = btn.dataset.placement;
        const locked = (lockChocoCurlsAll || lockedCurls.has(p)) && state.chocoCurlsPlacement!==p;
        btn.style.opacity = locked ? '0.35' : '';
        btn.style.pointerEvents = locked ? 'none' : '';
    });
    document.querySelectorAll('.sprinkle-place-btn').forEach(btn=>{
        const p = btn.dataset.placement, type = btn.dataset.type;
        const isCurrent = window._sprinklePlacement && window._sprinklePlacement[type]===p;
        const locked = lockedSprinkle.has(p) && !isCurrent;
        btn.style.opacity = locked ? '0.35' : '';
        btn.style.pointerEvents = locked ? 'none' : '';
    });
    document.querySelectorAll('#opts-rosette-placement [data-rosette-placement], #opts-rosette-combo [data-rosette-placement]').forEach(el=>{
        const target = el.dataset.rosettePlacement;
        const isCurrent = rosetteOn && state.rosettePlacement===target;
        const locked = !isCurrent && !!rosetteComboBlockedReason(target);
        el.style.opacity = locked ? '0.35' : '';
        el.style.pointerEvents = locked ? 'none' : '';
    });
}
function bindRosettePlacementOpts(containerId){
    const container = document.getElementById(containerId);
    if(!container) return;
    container.querySelectorAll('[data-rosette-placement]').forEach(el=>{
        el.addEventListener('click',()=>{
            const target = el.dataset.rosettePlacement;
            const reason = rosetteComboBlockedReason(target);
            if(reason){ showToast('⚠ '+reason, 2600); return; }
            // Only one placement (single OR combo) can be active at a time —
            // clear ALL THREE grids (single placements + generic combos +
            // number-cake combos), not just the container that was clicked.
            document.querySelectorAll('#opts-rosette-placement [data-rosette-placement], #opts-rosette-combo [data-rosette-placement], #opts-rosette-combo-number [data-rosette-placement]').forEach(x=>x.classList.remove('active'));
            el.classList.add('active');
               state.rosettePlacement = target;
            document.getElementById('rosettePlacementBadge').textContent = 'Selected: ' + state.rosettePlacement.replace('+',' + ');
            window._pendingRosetteReveal = true;
            updateAll();
        });
    });
}
bindRosettePlacementOpts('opts-rosette-placement');
bindRosettePlacementOpts('opts-rosette-combo');
bindRosettePlacementOpts('opts-rosette-combo-number');
document.getElementById('rosetteColorGrid').querySelectorAll('.icing-color-opt').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('rosetteColorGrid').querySelectorAll('.icing-color-opt').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.rosetteColor = el.dataset.rosetteColor;
        state.rosetteColorName = el.dataset.rosetteColorName;
        document.getElementById('rosetteColorLabel').textContent = el.dataset.rosetteColorName;
        updateAll();
    });
});

// ── OMBRE COLOR PICKERS ──
function updateOmbrePreview(){
    document.getElementById('ombrePreviewSwatch').style.setProperty('--ombre-preview-top', state.ombreTopColor);
    document.getElementById('ombrePreviewSwatch').style.setProperty('--ombre-preview-bottom', state.ombreBottomColor);
}
// Custom color-wheel swatches — unlimited colors via native picker
const ombreTopCustomInput  = document.getElementById('ombreTopCustomInput');
const ombreTopCustomSwatch = document.getElementById('ombreTopCustomSwatch');
ombreTopCustomInput.addEventListener('input', function(){
    ombreTopCustomSwatch.style.background = this.value;
    state.ombreTopColor = this.value;
    updateOmbrePreview();
    updateAll();
});

const ombreBottomCustomInput  = document.getElementById('ombreBottomCustomInput');
const ombreBottomCustomSwatch = document.getElementById('ombreBottomCustomSwatch');
ombreBottomCustomInput.addEventListener('input', function(){
    ombreBottomCustomSwatch.style.background = this.value;
    state.ombreBottomColor = this.value;
    updateOmbrePreview();
    updateAll();
});
document.getElementById('dripToggleBtn').addEventListener('click',()=>{
    state.hasDrip=!state.hasDrip;
    document.getElementById('dripToggleBtn').classList.toggle('active',state.hasDrip);
    document.getElementById('dripFlavorPanel').classList.toggle('visible',state.hasDrip);
    if(state.hasDrip){
        state.addons.set('Drip',ADDON_TIER_PRICES['Drip'][getTierIdx()]);
        window._pendingDripReveal = true;
    } else {
        state.addons.delete('Drip');
    }
    updateAll();
});
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
if(hint){let maxBottom=16;order2.forEach(id=>{const el=document.getElementById(id);if(el&&el.classList.contains('visible')){const b=parseInt(el.style.bottom)||14;const h=el.getBoundingClientRect().height||54;maxBottom=Math.max(maxBottom,b+h+8);}});
    hint.style.top = 'auto';
    hint.style.bottom = maxBottom + 'px';
}
        });});
    }
}
const FRUIT_TRAY_ID_MAP={'Strawberry':'trayStrawberry','Blueberry':'trayBlueberry','Raspberry':'trayRaspberry','Cherry':'trayCherry','Mango Slice':'trayMango','Kiwi Slice':'trayKiwi','Peach Slice':'trayPeach','Banana Slice':'trayBanana'};
function updateFruitTray(){
    const hasFruits=FRUIT_KEYS.some(k=>state.addons.has(k));
    document.getElementById('fruitTray').classList.toggle('visible',hasFruits);
    document.getElementById('fruitsDragNotice').style.display=hasFruits?'flex':'none';
    FRUIT_KEYS.forEach(k=>{const t=document.getElementById(FRUIT_TRAY_ID_MAP[k]||('tray'+k));if(t)t.style.display=state.addons.has(k)?'':'none';});
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

document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Bar Shard"]').addEventListener('click',()=>{
    const v='Chocolate Bar Shard';
    const btn=document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Bar Shard"]');
    if(state.addons.has(v)){state.addons.delete(v);btn.classList.remove('active');if(typeof window.clearBarShardModels==='function')window.clearBarShardModels();state.placedBarShard=[];}
    else{state.addons.set(v,0);btn.classList.add('active');}
    updateBarShardTray();updateAll();
});
document.getElementById('tobleroneToggleBtn').addEventListener('click',()=>{
    const v='Toblerone Triangle';
    if(state.addons.has(v)){
        state.addons.delete(v);
        document.getElementById('tobleroneToggleBtn').classList.remove('active');
        document.getElementById('tobleroneFlavorPanel').classList.remove('visible');
        if(typeof window.clearTobleroneModels==='function')window.clearTobleroneModels();
        state.placedToblerone=[];placedTobleroneRecord.length=0;
    } else {
        state.addons.set(v,0);
        document.getElementById('tobleroneToggleBtn').classList.add('active');
        document.getElementById('tobleroneFlavorPanel').classList.add('visible');
    }
    updateTobleroneTray();updateAll();
});
document.getElementById('opts-toblerone-flavor').querySelectorAll('[data-toblerone-flavor]').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('opts-toblerone-flavor').querySelectorAll('[data-toblerone-flavor]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.tobleroneFlavor = el.dataset.tobleroneFlavor;
        const nutNote = state.tobleroneFlavor === 'White' ? 'with almond-style nuts' : 'with hazelnut nougat bits';
        document.getElementById('tobleroneFlavorBadge').textContent = `Selected: ${state.tobleroneFlavor} · ${nutNote}`;
        // NOTE: intentionally NOT calling reflavorToblerone() here — switching
        // the flavor picker only affects the NEXT piece dropped onto the cake.
        // Pieces already placed keep whatever flavor they were dropped as, so
        // a customer can mix Chocolate and White pieces on the same cake.
        showToast(`🔺 Next Toblerone will be ${state.tobleroneFlavor}`, 1800);
    });
});
// ── CHOCOLATE CURLS TOGGLE ──
function _tryPlaceChocoCurls(placement, attempts){
    if(typeof window.placeChocoCurls==='function' && (typeof window.isCakeSceneReady!=='function' || window.isCakeSceneReady())){
        window.placeChocoCurls(placement, state.tier, state.shape).then(ok=>{
            if(ok){
                showToast('🍫 Choco Curls updated!',1500);
            } else if(attempts>0){
                setTimeout(()=>_tryPlaceChocoCurls(placement, attempts-1),200);
            } else {
                showToast('⚠ Could not load Choco Curls for this shape/placement',2400);
            }
        }).catch(()=>{
            if(attempts>0) setTimeout(()=>_tryPlaceChocoCurls(placement, attempts-1),200);
            else showToast('⚠ Could not load Choco Curls for this shape/placement',2400);
        });
    } else if(attempts>0){
        setTimeout(()=>_tryPlaceChocoCurls(placement, attempts-1),200);
    } else {
        showToast('⚠ Could not load Choco Curls for this shape/placement',2400);
    }
}
function _setAddonOptChecked(btn, checked){
    btn.classList.toggle('active', checked);
    const chk = btn.querySelector('.addon-check');
    if(chk){ chk.style.background = checked ? 'var(--caramel)' : ''; chk.style.borderColor = checked ? 'var(--caramel)' : ''; }
    const svg = btn.querySelector('.addon-check svg');
    if(svg) svg.style.opacity = checked ? '1' : '0';
    const nm = btn.querySelector('.a-name');
    if(nm) nm.style.color = checked ? 'var(--caramel)' : '';
    btn.style.borderColor = checked ? 'var(--caramel)' : '';
    btn.style.background  = checked ? 'var(--accent-lt)' : '';
    btn.style.boxShadow   = checked ? 'var(--shadow-glow)' : '';
}
document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Curls"]').addEventListener('click',()=>{
    const v='Chocolate Curls';
    const btn=document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Curls"]');
    if(state.addons.has(v)){
        state.addons.delete(v);
        _setAddonOptChecked(btn, false);
        document.getElementById('chocoCurlsPlacementPanel').style.display='none';
        if(typeof window.clearChocoCurls==='function') window.clearChocoCurls();
        // Fully reset the placement selector back to its default ("Middle") so
        // the next time Chocolate Curls is turned on, it starts clean.
        state.chocoCurlsPlacement = 'middle';
        document.querySelectorAll('.choco-curls-place-btn').forEach(b=>{
            const on = b.dataset.placement === 'middle';
            b.style.background = on ? 'var(--gold)' : 'var(--surface)';
            b.style.color      = on ? '#fff'         : 'var(--text-muted)';
            b.style.fontWeight = on ? '700'          : '600';
        });
    } else {
        const _ccReason = rosetteBlocksAddon('chocoCurls', state.chocoCurlsPlacement || 'middle');
        if(_ccReason){ showToast('⚠ '+_ccReason, 2600); return; }
        state.addons.set(v, ADDON_TIER_PRICES['Chocolate Curls'][getTierIdx()]);
        _setAddonOptChecked(btn, true);
        document.getElementById('chocoCurlsPlacementPanel').style.display='block';
        if(typeof window._updateChocoCurlsPlacementAvailability==='function') window._updateChocoCurlsPlacementAvailability();
        setTimeout(()=>_tryPlaceChocoCurls(state.chocoCurlsPlacement, 25),300);
    }
    updateAll();
});
document.querySelectorAll('.choco-curls-place-btn').forEach(btn=>{
    btn.addEventListener('click',()=>{
        const placement=btn.dataset.placement;
        if(state.chocoCurlsPlacement===placement && state.addons.has('Chocolate Curls')) return; // already showing this placement
        const _cReason = rosetteBlocksAddon('chocoCurls', placement);
        if(_cReason){ showToast('⚠ '+_cReason, 2600); return; }
        state.chocoCurlsPlacement=placement;
        document.querySelectorAll('.choco-curls-place-btn').forEach(b=>{
            const on=b.dataset.placement===placement;
            b.style.background=on?'var(--gold)':'var(--surface)';
            b.style.color=on?'#fff':'var(--text-muted)';
            b.style.fontWeight=on?'700':'600';
        });
        // Auto-activate Chocolate Curls if it isn't already (defensive — the
        // panel is normally hidden until the addon is on, but this guarantees
        // real-time behavior regardless of how the click was triggered).
              if(!state.addons.has('Chocolate Curls')){
            state.addons.set('Chocolate Curls', ADDON_TIER_PRICES['Chocolate Curls'][getTierIdx()]);
            const chocoBtn = document.querySelector('#opts-choco .addon-opt[data-val="Chocolate Curls"]');
            if(chocoBtn) _setAddonOptChecked(chocoBtn, true);
        }
        // Fire immediately — no waiting on any prior state — so Sides/Both/Middle
        // render on the very first click, every time.
        _tryPlaceChocoCurls(placement, 20);
        updateAll();
    });
});

function updateChocoTray(){
    const hasF=state.addons.has('Ferrero-style Ball'),hasK=state.addons.has('Kitkat Sticks'),hasO=state.addons.has('Oreo Cookie'),hasB=state.addons.has('Chocolate Bar Shard'),hasT=state.addons.has('Toblerone Triangle');
    const hasAny=hasF||hasK||hasO||hasB||hasT;
    const chocoNotice=document.getElementById('chocoPlaceNotice');
    if(chocoNotice) chocoNotice.style.display=hasAny?'flex':'none';
    document.getElementById('chocoTray').classList.toggle('visible',hasAny);
    document.getElementById('trayFerrero').style.display=hasF?'':'none';
    document.getElementById('trayKitkat').style.display=hasK?'':'none';
    document.getElementById('trayOreo').style.display=hasO?'':'none';
    document.getElementById('trayBarShard').style.display=hasB?'':'none';
    document.getElementById('trayToblerone').style.display=hasT?'':'none';
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
function updateTobleroneTray(){updateChocoTray();}
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
    const hasF=state.addons.has('Ferrero-style Ball'),hasK=state.addons.has('Kitkat Sticks'),hasO=state.addons.has('Oreo Cookie'),hasB=state.addons.has('Chocolate Bar Shard'),hasT=state.addons.has('Toblerone Triangle');
    const parts=[];
 if(hasFruits)parts.push('🍓 Drag fruits');if(hasF)parts.push('🟤 Ferrero balls');if(hasK)parts.push('🍬 KitKat sticks');if(hasO)parts.push('⚫ Oreo cookies');if(hasB)parts.push('🍫 Bar shards');if(hasT)parts.push('🔺 Toblerone');if(state.addons.has('Number Candles'))parts.push('🕯️ Candles');
    document.getElementById('viewerHint').textContent=parts.length>0?parts.join(' · ')+' — drag to place':'🖱 Drag to rotate · Scroll to zoom';
}

// ── FRUIT CANVAS ──
const fruitCanvas=document.getElementById('fruitCanvas'),fctx=fruitCanvas.getContext('2d'),viewerEl=document.getElementById('viewerEl');
function resizeFruitCanvas(){fruitCanvas.width=viewerEl.clientWidth;fruitCanvas.height=viewerEl.clientHeight;redrawFruits();}
window.addEventListener('resize',resizeFruitCanvas);resizeFruitCanvas();
function redrawFruits(){fctx.clearRect(0,0,fruitCanvas.width,fruitCanvas.height);state.placedFruits.forEach(f=>{fctx.font='28px serif';fctx.textAlign='center';fctx.textBaseline='middle';fctx.shadowColor='rgba(0,0,0,0.5)';fctx.shadowBlur=8;fctx.shadowOffsetY=4;fctx.fillText(f.emoji,f.x,f.y);fctx.shadowColor='transparent';fctx.shadowBlur=0;fctx.shadowOffsetY=0;});}

window._lastDropTime = 0;
const dragGhost=document.getElementById('dragGhost');
const dropRing=document.getElementById('dropRing');
const ferreroDropRing=document.getElementById('ferreroDropRing');
const kitkatDropRing=document.getElementById('kitkatDropRing');
const oreoDropRing=document.getElementById('oreoDropRing');
const barShardDropRing=document.getElementById('barShardDropRing');
const placedFruitRecord=[],placedFerreroRecord=[],placedKitkatRecord=[],placedOreoRecord=[],placedBarShardRecord=[],placedTobleroneRecord=[],placedCandleRecord=[];
window._placedFruitRecord=placedFruitRecord;window._placedFerreroRecord=placedFerreroRecord;window._placedKitkatRecord=placedKitkatRecord;window._placedOreoRecord=placedOreoRecord;window._placedBarShardRecord=placedBarShardRecord;window._placedTobleroneRecord=placedTobleroneRecord;window._placedCandleRecord=placedCandleRecord;
let attachedFruitIdx=-1,_pointerDownOnFruit=false;
let attachedFerreroIdx=-1,_pointerDownOnFerrero=false;
let attachedKitkatIdx=-1,_pointerDownOnKitkat=false;
let attachedOreoIdx=-1,_pointerDownOnOreo=false;
let attachedBarShardIdx=-1,_pointerDownOnBarShard=false;
let attachedTobleroneIdx=-1,_pointerDownOnToblerone=false;
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
const tobleroneDropRing=document.getElementById('tobleroneDropRing');
function updateAttachedToblerone(cx,cy){if(attachedTobleroneIdx<0)return;if(typeof window.moveDraggingToblerone==='function')window.moveDraggingToblerone(cx,cy);const rect=viewerEl.getBoundingClientRect();tobleroneDropRing.style.display='block';tobleroneDropRing.style.left=(cx-rect.left)+'px';tobleroneDropRing.style.top=(cy-rect.top)+'px';}
function dropAttachedToblerone(cx,cy){if(attachedTobleroneIdx<0)return;if(typeof window.moveDraggingToblerone==='function')window.moveDraggingToblerone(cx,cy);if(typeof window.setDraggingTobleroneIdx==='function')window.setDraggingTobleroneIdx(-1);showToast('🔺 Toblerone moved!',1600);attachedTobleroneIdx=-1;setCursorGrab(false);tobleroneDropRing.style.display='none';dragGhost.style.display='none';}
function updateAttachedCandle(cx,cy){if(attachedCandleIdx<0)return;if(typeof window.moveDraggingCandle==='function')window.moveDraggingCandle(cx,cy);const rect=viewerEl.getBoundingClientRect();const cdr=document.getElementById('candleDropRing');cdr.style.display='block';cdr.style.left=(cx-rect.left)+'px';cdr.style.top=(cy-rect.top)+'px';}
function dropAttachedCandle(cx,cy){if(attachedCandleIdx<0)return;if(typeof window.moveDraggingCandle==='function')window.moveDraggingCandle(cx,cy);if(typeof window.setDraggingCandleIdx==='function')window.setDraggingCandleIdx(-1);const e=placedCandleRecord[attachedCandleIdx];if(e)showToast(`🕯️ Candle #${e.num} moved!`,1600);attachedCandleIdx=-1;setCursorGrab(false);document.getElementById('candleDropRing').style.display='none';dragGhost.style.display='none';}
let attachedCharacterIdx=-1,_pointerDownOnCharacter=false;
function updateAttachedCharacter(cx,cy){if(attachedCharacterIdx<0)return;if(typeof window.moveDraggingCharacter==='function')window.moveDraggingCharacter(cx,cy);}
function dropAttachedCharacter(cx,cy){if(attachedCharacterIdx<0)return;if(typeof window.moveDraggingCharacter==='function')window.moveDraggingCharacter(cx,cy);if(typeof window.setDraggingCharacterIdx==='function')window.setDraggingCharacterIdx(-1);attachedCharacterIdx=-1;setCursorGrab(false);dragGhost.style.display='none';showToast('🎭 Character moved!',1600);}
function hookCanvasPointerDown(){
    const canvas=document.querySelector('#model-container canvas');
    if(!canvas){setTimeout(hookCanvasPointerDown,100);return;}
    canvas.addEventListener('pointerdown',e=>{
        if(Date.now() - (window._lastDropTime||0) < 350) return;
        if(attachedCharacterIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnCharacter=true;return;}
        if(typeof window.getCharacterIndexAtScreen==='function'){
            const cidx=window.getCharacterIndexAtScreen(e.clientX,e.clientY);
            if(cidx>=0){
                e.stopPropagation();e.preventDefault();_pointerDownOnCharacter=true;attachedCharacterIdx=cidx;
                if(typeof window.setDraggingCharacterIdx==='function')window.setDraggingCharacterIdx(cidx);
                setCursorGrab(true);dragGhost.textContent='🎭';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';
                window._characterPointerMoved=false;window._characterClickX=e.clientX;window._characterClickY=e.clientY;
                return;
            }
        }
        if(attachedFruitIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnFruit=true;return;}
        if(attachedFerreroIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnFerrero=true;return;}
        if(attachedKitkatIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnKitkat=true;return;}
        if(attachedOreoIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnOreo=true;return;}
     if(attachedBarShardIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnBarShard=true;return;}
        if(attachedTobleroneIdx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnToblerone=true;return;}
        if(typeof window.getTobleroneIndexAtScreen==='function'){const tidx=window.getTobleroneIndexAtScreen(e.clientX,e.clientY);if(tidx>=0){e.stopPropagation();e.preventDefault();_pointerDownOnToblerone=true;attachedTobleroneIdx=tidx;if(typeof window.setDraggingTobleroneIdx==='function')window.setDraggingTobleroneIdx(tidx);setCursorGrab(true);dragGhost.textContent='🔺';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.display='block';showToast('Move & click to place',1800);return;}}
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
    if(attachedCharacterIdx>=0){
        const dx=e.clientX-(window._characterClickX||e.clientX),dy=e.clientY-(window._characterClickY||e.clientY);
        if(Math.abs(dx)>4||Math.abs(dy)>4) window._characterPointerMoved=true;
        updateAttachedCharacter(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';
    }
    if(attachedFruitIdx>=0){
        const dx=e.clientX-(window._fruitClickX||e.clientX),dy=e.clientY-(window._fruitClickY||e.clientY);
        if(Math.abs(dx)>4||Math.abs(dy)>4) window._fruitPointerMoved=true;
        updateAttachedFruit(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';
    }
    if(attachedFerreroIdx>=0){updateAttachedFerrero(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedKitkatIdx>=0){updateAttachedKitkat(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedOreoIdx>=0){updateAttachedOreo(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
   if(attachedBarShardIdx>=0){updateAttachedBarShard(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedTobleroneIdx>=0){updateAttachedToblerone(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
    if(attachedCandleIdx>=0){updateAttachedCandle(e.clientX,e.clientY);dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';}
});
canvas.addEventListener('pointerup',e=>{
        if(_pointerDownOnCharacter){_pointerDownOnCharacter=false;
            if(attachedCharacterIdx>=0){
                if(!window._characterPointerMoved){
                    const idx=attachedCharacterIdx;
                    if(typeof window.setDraggingCharacterIdx==='function')window.setDraggingCharacterIdx(-1);
                    attachedCharacterIdx=-1;setCursorGrab(false);dragGhost.style.display='none';
                    if(typeof window._showCharacterMovePanel==='function') window._showCharacterMovePanel(idx);
                } else {
                    dropAttachedCharacter(e.clientX,e.clientY);
                }
            }
        }
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
if(_pointerDownOnToblerone){_pointerDownOnToblerone=false;if(attachedTobleroneIdx>=0){if(typeof window._showChocoRotatePanel==='function')window._showChocoRotatePanel('toblerone',attachedTobleroneIdx);if(typeof window.setDraggingTobleroneIdx==='function')window.setDraggingTobleroneIdx(-1);attachedTobleroneIdx=-1;setCursorGrab(false);tobleroneDropRing.style.display='none';}}
    });
}
hookCanvasPointerDown();

document.addEventListener('mousemove',e=>{
    if(attachedCharacterIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedCharacter(e.clientX,e.clientY);}
    if(attachedFruitIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedFruit(e.clientX,e.clientY);}
    if(attachedFerreroIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedFerrero(e.clientX,e.clientY);}
    if(attachedKitkatIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedKitkat(e.clientX,e.clientY);}
    if(attachedOreoIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedOreo(e.clientX,e.clientY);}
if(attachedBarShardIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedBarShard(e.clientX,e.clientY);}
    if(attachedTobleroneIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedToblerone(e.clientX,e.clientY);}
    if(attachedCandleIdx>=0){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';updateAttachedCandle(e.clientX,e.clientY);}
});
viewerEl.addEventListener('click',e=>{
    // Fruits are handled in pointerup — skip here to avoid double-firing
    if(attachedFerreroIdx>=0){dropAttachedFerrero(e.clientX,e.clientY);return;}
    if(attachedKitkatIdx>=0){dropAttachedKitkat(e.clientX,e.clientY);return;}
    if(attachedOreoIdx>=0){dropAttachedOreo(e.clientX,e.clientY);return;}
    if(attachedBarShardIdx>=0){dropAttachedBarShard(e.clientX,e.clientY);return;}
    if(attachedTobleroneIdx>=0){dropAttachedToblerone(e.clientX,e.clientY);return;}
    if(attachedCandleIdx>=0){dropAttachedCandle(e.clientX,e.clientY);}
},true);
// ── DRAG FROM TRAY ──
let activeTrayDrag=null,isDraggingFromTray=false;
let activeFerreroDrag=null,isDraggingFerreroFromTray=false;
let activeKitkatDrag=null,isDraggingKitkatFromTray=false;
let activeBarShardDrag=null,isDraggingBarShardFromTray=false;
let activeOreoDrag=null,isDraggingOreoFromTray=false;

document.querySelectorAll('.fruit-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedFruitIdx>=0){attachedFruitIdx=-1;if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);setCursorGrab(false);dropRing.style.display='none';dragGhost.style.display='none';}activeTrayDrag={fruit:el.dataset.fruit,emoji:el.dataset.emoji,type:'fruit'};isDraggingFromTray=true;dragGhost.textContent=el.dataset.emoji;dragGhost.style.transform='translate(-50%,-50%)';dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';dropRing.style.display='none';viewerEl.classList.remove('fruit-drag-over');isDraggingFromTray=false;activeTrayDrag=null;});});
document.querySelectorAll('.ferrero-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedFerreroIdx>=0){attachedFerreroIdx=-1;if(typeof window.setDraggingFerreroIdx==='function')window.setDraggingFerreroIdx(-1);setCursorGrab(false);ferreroDropRing.style.display='none';dragGhost.style.display='none';}activeFerreroDrag={type:'ferrero',emoji:'🟤'};isDraggingFerreroFromTray=true;dragGhost.textContent='🟤';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';ferreroDropRing.style.display='none';viewerEl.classList.remove('ferrero-drag-over');isDraggingFerreroFromTray=false;activeFerreroDrag=null;});});
document.querySelectorAll('.kitkat-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedKitkatIdx>=0){attachedKitkatIdx=-1;if(typeof window.setDraggingKitkatIdx==='function')window.setDraggingKitkatIdx(-1);setCursorGrab(false);kitkatDropRing.style.display='none';dragGhost.style.display='none';}activeKitkatDrag={type:'kitkat',emoji:'🍬'};isDraggingKitkatFromTray=true;dragGhost.textContent='🍬';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';kitkatDropRing.style.display='none';viewerEl.classList.remove('kitkat-drag-over');isDraggingKitkatFromTray=false;activeKitkatDrag=null;});});
document.querySelectorAll('.bar-shard-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedBarShardIdx>=0){attachedBarShardIdx=-1;if(typeof window.setDraggingBarShardIdx==='function')window.setDraggingBarShardIdx(-1);setCursorGrab(false);barShardDropRing.style.display='none';dragGhost.style.display='none';}activeBarShardDrag={type:'barShard',emoji:'🍫'};isDraggingBarShardFromTray=true;dragGhost.textContent='🍫';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';barShardDropRing.style.display='none';viewerEl.classList.remove('bar-shard-drag-over');isDraggingBarShardFromTray=false;activeBarShardDrag=null;});});
let activeTobleroneDrag=null,isDraggingTobleroneFromTray=false;
document.querySelectorAll('.toblerone-draggable').forEach(el=>{el.addEventListener('dragstart',e=>{if(attachedTobleroneIdx>=0){attachedTobleroneIdx=-1;if(typeof window.setDraggingTobleroneIdx==='function')window.setDraggingTobleroneIdx(-1);setCursorGrab(false);tobleroneDropRing.style.display='none';dragGhost.style.display='none';}activeTobleroneDrag={type:'toblerone',emoji:'🔺'};isDraggingTobleroneFromTray=true;dragGhost.textContent='🔺';dragGhost.style.display='block';const em=new Image();em.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';e.dataTransfer.setDragImage(em,0,0);e.dataTransfer.effectAllowed='copy';});el.addEventListener('dragend',()=>{dragGhost.style.display='none';tobleroneDropRing.style.display='none';viewerEl.classList.remove('toblerone-drag-over');isDraggingTobleroneFromTray=false;activeTobleroneDrag=null;});});
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
    if(isDraggingTobleroneFromTray&&activeTobleroneDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('toblerone-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';tobleroneDropRing.style.display='block';tobleroneDropRing.style.left=(e.clientX-rect.left)+'px';tobleroneDropRing.style.top=(e.clientY-rect.top)+'px';}else tobleroneDropRing.style.display='none';}
    if(isDraggingCandleFromTray&&activeCandleDrag){dragGhost.style.left=e.clientX+'px';dragGhost.style.top=e.clientY+'px';dragGhost.style.transform='translate(-50%,-50%)';viewerEl.classList.toggle('candle-drag-over',over);if(over){e.preventDefault();e.dataTransfer.dropEffect='copy';const cdr=document.getElementById('candleDropRing');cdr.style.display='block';cdr.style.left=(e.clientX-rect.left)+'px';cdr.style.top=(e.clientY-rect.top)+'px';}else document.getElementById('candleDropRing').style.display='none';}
});
viewerEl.addEventListener('dragover',e=>e.preventDefault());

viewerEl.addEventListener('drop',async e=>{
    e.preventDefault();
    window._lastDropTime = Date.now();
    dropRing.style.display='none';ferreroDropRing.style.display='none';kitkatDropRing.style.display='none';oreoDropRing.style.display='none';
    viewerEl.classList.remove('fruit-drag-over','ferrero-drag-over','kitkat-drag-over','oreo-drag-over');
   if(activeBarShardDrag&&isDraggingBarShardFromTray){isDraggingBarShardFromTray=false;activeBarShardDrag=null;dragGhost.style.display='none';if(typeof window.placeBarShardOnCake==='function'){const idx=await window.placeBarShardOnCake(e.clientX,e.clientY);if(idx>=0){placedBarShardRecord[idx]={emoji:'🍫'};state.placedBarShard.push({x:e.clientX,y:e.clientY});showToast('🍫 Bar shard placed! Click to move.',2200);updateAll();}}return;}
    if(activeTobleroneDrag&&isDraggingTobleroneFromTray){isDraggingTobleroneFromTray=false;activeTobleroneDrag=null;dragGhost.style.display='none';if(typeof window.placeTobleroneOnCake==='function'){const idx=await window.placeTobleroneOnCake(e.clientX,e.clientY);if(idx>=0){placedTobleroneRecord[idx]={emoji:'🔺'};state.placedToblerone.push({x:e.clientX,y:e.clientY});showToast('🔺 Toblerone placed! Click to move.',2200);updateAll();}}return;}
    if(activeOreoDrag&&isDraggingOreoFromTray){isDraggingOreoFromTray=false;activeOreoDrag=null;dragGhost.style.display='none';if(typeof window.placeOreoOnCake==='function'){const idx=await window.placeOreoOnCake(e.clientX,e.clientY,state.oreoOrientation);if(idx>=0){placedOreoRecord[idx]={emoji:'⚫'};state.placedOreo.push({x:e.clientX,y:e.clientY,orientation:state.oreoOrientation});showToast(`⚫ Oreo placed ${state.oreoOrientation==='standing'?'standing up':'lying flat'}! Click to move.`,2200);updateAll();}}return;}
    if(activeKitkatDrag&&isDraggingKitkatFromTray){isDraggingKitkatFromTray=false;activeKitkatDrag=null;dragGhost.style.display='none';if(typeof window.placeKitkatOnCake==='function'){const idx=await window.placeKitkatOnCake(e.clientX,e.clientY,state.kitkatOrientation);if(idx>=0){placedKitkatRecord[idx]={emoji:'🍬'};state.placedKitkat.push({x:e.clientX,y:e.clientY,orientation:state.kitkatOrientation});showToast(`🍬 KitKat placed ${state.kitkatOrientation==='standing'?'standing up':'lying flat'}! Click to move.`,2200);updateAll();}}return;}
    if(activeFerreroDrag&&isDraggingFerreroFromTray){isDraggingFerreroFromTray=false;activeFerreroDrag=null;dragGhost.style.display='none';if(typeof window.placeFerreroOnCake==='function'){const idx=await window.placeFerreroOnCake(e.clientX,e.clientY);if(idx>=0){placedFerreroRecord[idx]={emoji:'🟤'};state.placedFerrero.push({x:e.clientX,y:e.clientY});showToast('🟤 Ferrero placed! Click it to move.',2200);updateAll();}}return;}
 if(activeTrayDrag&&isDraggingFromTray){const{fruit,emoji}=activeTrayDrag;isDraggingFromTray=false;activeTrayDrag=null;dragGhost.style.display='none';window._fruitPointerMoved=false;if(fruit&&typeof window.placeFruitOnCake==='function'){try{const idx=await window.placeFruitOnCake(fruit,e.clientX,e.clientY);if(idx>=0){placedFruitRecord[idx]={fruit,emoji};showToast(`${emoji} ${fruit} placed! Drag to move, tap to rotate.`,2200);updateAll();}else{showToast(`⚠ Could not place ${fruit} — model failed to load`,2600);}}catch(err){console.error('[Fruit drop]',fruit,err);showToast(`⚠ Could not place ${fruit} — check console for details`,2600);}}return;}
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
    window._lastDropTime = Date.now();
    dragGhost.style.display='none';dropRing.style.display='none';ferreroDropRing.style.display='none';kitkatDropRing.style.display='none';oreoDropRing.style.display='none';
    if(touchAttachedIdx>=0){if(over&&typeof window.moveDraggingFruit==='function')window.moveDraggingFruit(t.clientX,t.clientY);if(typeof window.setDraggingFruitIdx==='function')window.setDraggingFruitIdx(-1);const en=placedFruitRecord[touchAttachedIdx];if(en)showToast(`${en.emoji} repositioned`,1400);touchAttachedIdx=-1;touchTrayFruit=null;return;}
  if(touchTrayFruit&&touchTrayFruit.fruit&&over&&typeof window.placeFruitOnCake==='function'){const{fruit,emoji}=touchTrayFruit;window._fruitPointerMoved=false;try{const idx=await window.placeFruitOnCake(fruit,t.clientX,t.clientY);if(idx>=0){placedFruitRecord[idx]={fruit,emoji};showToast(`${emoji} ${fruit} placed! Drag to move, tap to rotate.`,2000);updateAll();}else{showToast(`⚠ Could not place ${fruit} — model failed to load`,2600);}}catch(err){console.error('[Fruit touch drop]',fruit,err);showToast(`⚠ Could not place ${fruit} — check console for details`,2600);}}touchTrayFruit=null;
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
// ── CHOCOLATE PLAQUE TOGGLE & SHAPE PICKER ──
document.getElementById('plaqueToggleBtn').addEventListener('click',()=>{
    const v='Chocolate Plaque';
    if(state.addons.has(v)){
        state.addons.delete(v);
        document.getElementById('plaqueToggleBtn').classList.remove('active');
        document.getElementById('plaqueShapePanel').classList.remove('visible');
        if(typeof window.clearPlaque==='function') window.clearPlaque();
    } else {
        const _pReason = rosetteBlocksAddon('plaque');
        if(_pReason){ showToast('⚠ '+_pReason, 2600); return; }
        state.addons.set(v,80);
        document.getElementById('plaqueToggleBtn').classList.add('active');
        document.getElementById('plaqueShapePanel').classList.add('visible');
    const _tryPlace=(attempts)=>{
            if(typeof window.placePlaqueOnCake==='function'){
                window.placePlaqueOnCake(state.plaqueShape).then(ok=>{
                    if(ok){
                        showToast('🍫 Chocolate Plaque added!',1800);
                        if(state.plaqueMessage && typeof window.setPlaqueMessage==='function') window.setPlaqueMessage(state.plaqueMessage);
                    }
                });
            } else if(attempts>0){ setTimeout(()=>_tryPlace(attempts-1),150); }
        };
        setTimeout(()=>_tryPlace(10),300);
    }
    updateAll();
});
document.getElementById('opts-plaque-shape').querySelectorAll('[data-plaque-shape]').forEach(el=>{
    el.addEventListener('click',()=>{
        document.getElementById('opts-plaque-shape').querySelectorAll('[data-plaque-shape]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.plaqueShape=el.dataset.plaqueShape;
        document.getElementById('plaqueShapeBadge').textContent=`Selected: ${state.plaqueShape} plaque`;
      if(state.addons.has('Chocolate Plaque') && typeof window.placePlaqueOnCake==='function'){
            window.placePlaqueOnCake(state.plaqueShape).then(ok=>{
                if(ok && state.plaqueMessage && typeof window.setPlaqueMessage==='function') window.setPlaqueMessage(state.plaqueMessage);
            });
        }
        updateAll();
    });
});

document.getElementById('plaqueMessageInput').addEventListener('keydown',function(e){
    if(e.key === 'Enter'){
        const currentLines = this.value.split('\n').length;
        if(currentLines >= 3) e.preventDefault();
    }
});
document.getElementById('plaqueMessageInput').addEventListener('input',function(){
    let lines = this.value.split('\n');
    if(lines.length > 3){
        lines = lines.slice(0,3);
        this.value = lines.join('\n');
    }
    state.plaqueMessage = this.value;
    if(state.addons.has('Chocolate Plaque') && typeof window.setPlaqueMessage==='function'){
        window.setPlaqueMessage(this.value);
    }
});
document.getElementById('characterToggleBtn').addEventListener('click',()=>{
    const v='Character Topper';
    if(state.addons.has(v)){
        state.addons.delete(v);
        document.getElementById('characterToggleBtn').classList.remove('active');
        document.getElementById('characterPickerPanel').classList.remove('visible');
        if(typeof window.clearCharacterModels==='function') window.clearCharacterModels();
        document.getElementById('characterActiveBadge').textContent = 'None placed yet — tap a character to add';
    } else {
        state.addons.set(v,0);
        document.getElementById('characterToggleBtn').classList.add('active');
        document.getElementById('characterPickerPanel').classList.add('visible');
        // No auto-placement — wait for the user to pick a character from the panel
    }
    updateAll();
});
document.getElementById('btnClearCharacters').addEventListener('click',()=>{
    if(typeof window.clearCharacterModels==='function') window.clearCharacterModels();
    state.addons.delete('Character Topper');
    document.getElementById('characterToggleBtn').classList.remove('active');
    document.getElementById('characterActiveBadge').textContent = 'None placed yet — tap a character to add';
    if(typeof window._hideCharacterMovePanel==='function') window._hideCharacterMovePanel();
    showToast('🎭 All characters cleared',1800);
    updateAll();
});
// ── Accordion toggle for character categories ──
document.querySelectorAll('#characterCategoryList .char-cat-toggle').forEach(btn=>{
    btn.addEventListener('click',()=>{
        const group = btn.closest('.char-cat-group');
        group.classList.toggle('open');
    });
});

// ── Character selection (works across all category groups) — every tap adds
// another instance to the cake, so any quantity/mix of characters can be placed. ──
document.querySelectorAll('#characterCategoryList [data-character]').forEach(el=>{
    el.addEventListener('click',(e)=>{
        e.stopPropagation();
        document.querySelectorAll('#characterCategoryList [data-character]').forEach(x=>x.classList.remove('active'));
        el.classList.add('active');
        state.characterTopper = el.dataset.character;
        if(!state.addons.has('Character Topper')){
            state.addons.set('Character Topper', 0);
            document.getElementById('characterToggleBtn').classList.add('active');
            document.getElementById('characterPickerPanel').classList.add('visible');
        }
        if(typeof window.placeCharacterOnCake==='function'){
            window.placeCharacterOnCake(state.characterTopper).then(idx=>{
                if(idx>=0){
                    const count = typeof window.getCharacterModels==='function' ? window.getCharacterModels().length : 1;
                    const price = CHARACTER_PRICES[state.characterTopper] || 350;
                    document.getElementById('characterActiveBadge').textContent = `${count} placed — tap any character again to add more`;
                    showToast(`🎭 ${state.characterTopper} added! (₱${price})`,1600);
                    updateAll();
                }
            });
        }
    });
});
document.getElementById('btnClearAllChoco').addEventListener('click',()=>{
    attachedFerreroIdx=-1;attachedKitkatIdx=-1;attachedOreoIdx=-1;attachedBarShardIdx=-1;attachedTobleroneIdx=-1;
    if(typeof window.clearFerreroModels==='function')window.clearFerreroModels();
    if(typeof window.clearKitkatModels==='function')window.clearKitkatModels();
    if(typeof window.clearOreoModels==='function')window.clearOreoModels();
    if(typeof window.clearBarShardModels==='function')window.clearBarShardModels();
    if(typeof window.clearTobleroneModels==='function')window.clearTobleroneModels();
    state.placedFerrero=[];state.placedKitkat=[];state.placedOreo=[];state.placedBarShard=[];state.placedToblerone=[];
    placedFerreroRecord.length=0;placedKitkatRecord.length=0;placedOreoRecord.length=0;placedBarShardRecord.length=0;placedTobleroneRecord.length=0;
    setCursorGrab(false);dragGhost.style.display='none';ferreroDropRing.style.display='none';kitkatDropRing.style.display='none';oreoDropRing.style.display='none';barShardDropRing.style.display='none';tobleroneDropRing.style.display='none';
    showToast('🍫 All chocolate decorations cleared',1800);updateAll();
});
['opts-choco','opts-sprinkles','opts-candles'].forEach(id=>{
    document.getElementById(id).querySelectorAll('.addon-opt').forEach(el=>{
        if(['ferreroToggleBtn','kitkatToggleBtn','oreoToggleBtn','tobleroneToggleBtn'].includes(el.id))return;
    if(el.dataset.val==='Chocolate Bar Shard')return;
    if(el.dataset.val==='Toblerone Triangle')return;
    if(el.dataset.val==='Chocolate Curls')return;
 
        if(el.dataset.val==='Chocolate Plaque')return;
        if(el.dataset.val==='Character Topper')return;
        el.addEventListener('click',()=>{
            const v=el.dataset.val,p=parseInt(el.dataset.price)||0;
            if(state.addons.has(v)){
                state.addons.delete(v);
                el.classList.remove('active');
              if(v==='Cylinder Sprinkles' && typeof window.clearSprinkles==='function') { window.clearSprinkles('cylinder'); document.getElementById('cylinderPlacementPanel').style.display='none'; }
                if(v==='Sphere Sprinkles'   && typeof window.clearSprinkles==='function') { window.clearSprinkles('pearl');    document.getElementById('pearlPlacementPanel').style.display='none'; }
                if(v==='Chocolate Sprinkles'&& typeof window.clearSprinkles==='function') { window.clearSprinkles('chocoSprinkle'); document.getElementById('chocoSprinklePlacementPanel').style.display='none'; }
                if(v==='Crushed Peanuts'    && typeof window.clearSprinkles==='function') { window.clearSprinkles('peanuts');  document.getElementById('peanutsPlacementPanel').style.display='none'; }
                } else {
                const _sprinkleTypeMap = {'Cylinder Sprinkles':'cylinder','Sphere Sprinkles':'pearl','Chocolate Sprinkles':'chocoSprinkle','Crushed Peanuts':'peanuts'};
                const _sType = _sprinkleTypeMap[v];
                if(_sType){
                    const _curP = (window._sprinklePlacement && window._sprinklePlacement[_sType]) || 'top';
                    const _sReason = rosetteBlocksAddon('sprinkle', _curP);
                    if(_sReason){ showToast('⚠ '+_sReason, 2600); return; }
                }
                state.addons.set(v,p);
                el.classList.add('active');
                // Wait for cake to be in scene then build
                const _tryBuild = (attempts) => {
                        if (typeof window.buildCylinderSprinkles === 'function') {
                       if(v==='Cylinder Sprinkles') { window.buildCylinderSprinkles(); document.getElementById('cylinderPlacementPanel').style.display='block'; }
                if(v==='Sphere Sprinkles')   { window.buildPearlSprinkles();    document.getElementById('pearlPlacementPanel').style.display='block'; }
                if(v==='Chocolate Sprinkles'){ window.buildChocoSprinkles();    document.getElementById('chocoSprinklePlacementPanel').style.display='block'; }
                if(v==='Crushed Peanuts')   { window.buildCrushedPeanuts();    document.getElementById('peanutsPlacementPanel').style.display='block'; }
                    } else if (attempts > 0) {
                        setTimeout(() => _tryBuild(attempts - 1), 150);
                    }
                };
                setTimeout(() => _tryBuild(10), 300);
            }
            updateAll();
        });
    });
});
function getEffectiveShape(){
    if(state.shape==='Round'&&state.tier==='Two-tier')   return 'Two-tier Round';
    if(state.shape==='Round'&&state.tier==='Three-tier') return 'Three-tier Round';

    if(state.shape==='Square'&&state.tier==='Two-tier')  return 'Two-tier Square';
    if(state.shape==='Square'&&state.tier==='Three-tier')return 'Three-tier Square';

    if(state.shape==='Heart'&&state.tier==='Two-tier')   return 'Two-tier Heart';
    if(state.shape==='Heart'&&state.tier==='Three-tier') return 'Three-tier Heart';

    return state.shape;
}
function getBasePrice(){const eff=getEffectiveShape();const shapeBase=eff==='Round'?(ROUND_SIZE_PRICES[state.roundSize]||350):(SHAPE_PRICES[eff]||350);return shapeBase+(CAKE_TYPE_PRICES[state.cakeType]||0);}
function getFillingPrice(){return FILLING_PRICES[state.filling]||0;}
function getFrostingExtraPrice(){
    const ti = getTierIdx();
    let e = 0;
    const activeStyle = CAKE_STYLE_VALS.find(s=>state.frostings.has(s)) || 'Smooth Buttercream';
    e += (CAKE_STYLE_TIER_PRICES[activeStyle] || [0,0,0])[ti];
    state.frostings.forEach(f=>{
        if(f === activeStyle) return; // already priced above as the cake style itself
        if(f === 'Smooth Buttercream')      e += FROSTING_SHELL_TIER_PRICES[ti];
        else if(f === 'Sugar Icing')        e += FROSTING_SUGAR_TIER_PRICES[ti];
        else if(f === 'Textured Buttercream') e += FROSTING_TEXTURE_TIER_PRICES[ti];
        else if(f === 'Rosettes')           e += FROSTING_ROSETTE_TIER_PRICES[ti];
    });
    return e;
}
function getShapeLabel(){const eff=getEffectiveShape();if(eff==='Round')return `Round ${state.roundSize}"`;if(eff==='Number'){if(state.numberDigits===2)return `Number ${state.numberTens}${state.numberUnits}`;return `Number ${state.numberChoice}`;}return eff;}
// Customer-friendly combined name, e.g. "Blueberry Cheesecake", "Ube Chiffon Cake", "Chocolate Sponge Cake"
function getCombinedCakeTypeLabel(){
    const type=state.cakeType, flavor=state.flavor;
    if(type==='Cheesecake') return `${flavor} Cheesecake`;
    if(type==='Chiffon Cake') return `${flavor} Chiffon Cake`;
    if(type==='Sponge Cake') return `${flavor} Sponge Cake`;
    return `${flavor} ${type}`;
}
// Resolves the flavor key actually sent to the 3D preview — reuses the existing
// Blueberry/Strawberry/Mango Cheesecake palette entries when Cake Type is Cheesecake,
// otherwise passes the plain flavor through untouched.
function getEffectiveFlavorKey(){
    if(state.cakeType==='Cheesecake' && CHEESECAKE_FLAVOR_MAP[state.flavor]) return CHEESECAKE_FLAVOR_MAP[state.flavor];
    return state.flavor;
}
function updateAll(){
  syncRosetteAddonLocks();
  const base=getBasePrice(),frostExtra=getFrostingExtraPrice(),fillingPrice=getFillingPrice();
  const ti=getTierIdx();
// These are priced per placed piece — exclude from flat addon sum
 const PER_PIECE_KEYS=new Set(['Ferrero-style Ball','Kitkat Sticks','Oreo Cookie','Chocolate Bar Shard','Toblerone Triangle','Number Candles','Strawberry','Blueberry','Raspberry','Cherry','Character Topper']);
    let addonTotal=0;
    state.addons.forEach((p,k)=>{
        if(PER_PIECE_KEYS.has(k)) return;
        // Tier-dependent add-ons always price off the live tier, regardless
        // of what value was stored on it at the moment it was clicked.
        addonTotal += ADDON_TIER_PRICES[k] ? ADDON_TIER_PRICES[k][ti] : p;
    });
 const FRUIT_PRICES={'Strawberry':45,'Blueberry':25,'Raspberry':55,'Cherry':35,'Mango Slice':40,'Kiwi Slice':30,'Peach Slice':35};
    const fruitCounts={};
    if(typeof window.getFruitModels==='function'){window.getFruitModels().forEach(m=>{fruitCounts[m.fruit]=(fruitCounts[m.fruit]||0)+1;});}
    FRUIT_KEYS.forEach(k=>{addonTotal+=(fruitCounts[k]||0)*(FRUIT_PRICES[k]||0);});
    const ferreroCount=(typeof window.getFerreroModels==='function')?window.getFerreroModels().length:state.placedFerrero.length;
    const kitkatCount=(typeof window.getKitkatModels==='function')?window.getKitkatModels().length:state.placedKitkat.length;
    const oreoCount=(typeof window.getOreoModels==='function')?window.getOreoModels().length:state.placedOreo.length;
const barShardCount2=(typeof window.getBarShardModels==='function')?window.getBarShardModels().length:0;
    const tobleroneCount2=(typeof window.getTobleroneModels==='function')?window.getTobleroneModels().length:0;
    const candleCount=(typeof window.getCandleModels==='function')?window.getCandleModels().length:state.placedCandles.length;
if(state.addons.has('Ferrero-style Ball'))addonTotal+=ferreroCount*55;
    if(state.addons.has('Kitkat Sticks'))addonTotal+=kitkatCount*30;
    if(state.addons.has('Oreo Cookie'))addonTotal+=oreoCount*20;
    if(state.addons.has('Chocolate Bar Shard'))addonTotal+=barShardCount2*40;
    if(state.addons.has('Toblerone Triangle'))addonTotal+=tobleroneCount2*50;
if(state.addons.has('Number Candles'))addonTotal+=candleCount*20;
    const characterModelsList=(typeof window.getCharacterModels==='function')?window.getCharacterModels():[];
    const characterCount=characterModelsList.length;
    let characterTotalPrice=0;
    if(state.addons.has('Character Topper')){
        characterModelsList.forEach(m=>{ characterTotalPrice += (CHARACTER_PRICES[m.key] || 350); });
        addonTotal += characterTotalPrice;
    }
    // Fruits: always count placed pieces regardless of addons map value
    // (already computed above via fruitCounts loop)
   const total=base+frostExtra+addonTotal+fillingPrice;
    document.getElementById('priceBase').textContent='₱'+base.toLocaleString();
    document.getElementById('priceAddons').textContent='₱'+addonTotal.toLocaleString();
    document.getElementById('priceTotal').textContent=total.toLocaleString();
    document.getElementById('priceAddons').classList.toggle('zero',addonTotal===0);
    const frostRow=document.getElementById('priceFrostingRow');
    if(frostExtra>0){frostRow.style.display='';document.getElementById('priceFrosting').textContent='₱'+frostExtra.toLocaleString();}else frostRow.style.display='none';
      const shapeLabel=getShapeLabel();
    const activeCakeStyleForSummary = CAKE_STYLE_VALS.find(s=>state.frostings.has(s)) || 'Smooth Buttercream';
    const frostingExtras=[...state.frostings].filter(f=>f!==activeCakeStyleForSummary);
    const frostingLabel = frostingExtras.length ? frostingExtras.join(' + ') : 'Default';
    document.getElementById('selCakeType').textContent=getCombinedCakeTypeLabel();
    document.getElementById('selFlavorRow').style.display='none';
    document.getElementById('selFillingRow').style.display='';
    document.getElementById('selFilling').textContent = (state.filling && state.filling!=='No Filling')
        ? state.filling+(fillingPrice>0?` (+₱${fillingPrice})`:'')
        : 'No Filling';
    const isSugarIcing=state.frostings.has(SUGAR_ICING_VAL),isFondant=state.frostings.has(FONDANT_VAL);
    document.getElementById('selShape').textContent=shapeLabel;
    document.getElementById('selFlavor').textContent=state.flavor;
    document.getElementById('selCakeStyle').textContent=activeCakeStyleForSummary;
    document.getElementById('selFrosting').textContent=frostingLabel;
    document.getElementById('badgeFlavor').textContent=state.flavor;
    document.getElementById('badgeShape').textContent=shapeLabel+' · '+activeCakeStyleForSummary;
    const icingRow=document.getElementById('selIcingRow');
    if(isSugarIcing){icingRow.style.display='';document.getElementById('selIcingColor').textContent=state.icingColorName;}else icingRow.style.display='none';
    const hasF=state.addons.has('Ferrero-style Ball');
    const hasK=state.addons.has('Kitkat Sticks');
    const hasO=state.addons.has('Oreo Cookie');
    const hasB=state.addons.has('Chocolate Bar Shard');
    const barShardCount=(typeof window.getBarShardModels==='function')?window.getBarShardModels().length:state.placedBarShard.length;
    const chips=[];
    if(state.hasDrip)chips.push(`<span class="cfg-chip chip-teal">💧 ${state.dripFlavor} Drip</span>`);
    FRUIT_KEYS.forEach(k=>{
        const c = fruitCounts[k]||0;
        if(c>0) chips.push(`<span class="cfg-chip chip-accent">🍓 ${k} ×${c}</span>`);
    });
    if(hasF)chips.push(`<span class="cfg-chip chip-gold">🟤 Ferrero${ferreroCount>0?' ×'+ferreroCount:''}</span>`);
    if(hasK)chips.push(`<span class="cfg-chip chip-accent">🍬 KitKat${kitkatCount>0?' ×'+kitkatCount:''} · ${state.kitkatOrientation==='standing'?'Standing':'Flat'}</span>`);
    if(hasO)chips.push(`<span class="cfg-chip chip-accent">⚫ Oreo${oreoCount>0?' ×'+oreoCount:''} · ${state.oreoOrientation==='standing'?'Standing':'Flat'}</span>`);
    if(hasB)chips.push(`<span class="cfg-chip chip-accent">🍫 Bar Shard${barShardCount>0?' ×'+barShardCount:''}</span>`);
    if(state.addons.has('Chocolate Curls'))chips.push(`<span class="cfg-chip chip-gold">🍫 Choco Curls · ${state.chocoCurlsPlacement}</span>`);
    if(state.addons.has('Chocolate Plaque'))chips.push(`<span class="cfg-chip chip-gold">🍫 Choco Plaque · ${state.plaqueShape}</span>`);
    const hasT=state.addons.has('Toblerone Triangle');
    const tobleroneCount=(typeof window.getTobleroneModels==='function')?window.getTobleroneModels().length:0;
    if(hasT)chips.push(`<span class="cfg-chip chip-accent">🔺 ${state.tobleroneFlavor||'Chocolate'} Toblerone${tobleroneCount>0?' ×'+tobleroneCount:''}</span>`);
    if(state.addons.has('Chocolate Sprinkles'))chips.push(`<span class="cfg-chip chip-gold">🍫 Choco Sprinkles</span>`);
    if(state.addons.has('Crushed Peanuts'))chips.push(`<span class="cfg-chip chip-gold">🥜 Crushed Peanuts</span>`);
    if(state.addons.has('Cylinder Sprinkles'))chips.push(`<span class="cfg-chip chip-accent">✨ Cylinder Mix</span>`);
    if(state.addons.has('Sphere Sprinkles'))chips.push(`<span class="cfg-chip chip-accent">✨ Pearl Mix</span>`);
    if(state.addons.has('Number Candles'))chips.push(`<span class="cfg-chip chip-gold">🕯️ Candles${candleCount>0?' ×'+candleCount:''}</span>`);
    if(state.addons.has('Character Topper'))chips.push(`<span class="cfg-chip chip-accent">🎭 ${characterCount>0?characterCount+'× characters · ₱'+characterTotalPrice.toLocaleString():state.characterTopper}</span>`);
    document.getElementById('addonsSummary').innerHTML=chips.length?chips.join(''):'<span class="cfg-val muted" style="font-size:.73rem;">None selected</span>';
   const shellBorderColorActive = state.frostings.has('Smooth Buttercream') && !isSugarIcing && !isFondant && state.hasCustomIcingColor;
 if(typeof window.updateModel==='function'){window.updateModel({...state,shape:getEffectiveShape(),flavor:getEffectiveFlavorKey(),frostings:[...state.frostings],frosting:[...state.frostings][0],icingColor:(isSugarIcing||shellBorderColorActive)?state.icingColor:null});}
    if(typeof window._requestShadowUpdate==='function') setTimeout(window._requestShadowUpdate, 200);
      if(typeof window._requestRender==='function') window._requestRender();  
}

// ── SAVE DRAFT ──
async function saveDraft(){
    const btn=document.getElementById('btnSaveDraft');
  const cfg={cakeType:state.cakeType,filling:state.filling,shape:state.shape,roundSize:state.roundSize,numberDigits:state.numberDigits,numberChoice:state.numberChoice,numberTens:state.numberTens,numberUnits:state.numberUnits,flavor:state.flavor,frostings:[...state.frostings],addons:[...state.addons.keys()],hasDrip:state.hasDrip,dripFlavor:state.dripFlavor,icingColor:state.icingColor,icingColorName:state.icingColorName,placedFruits:state.placedFruits,placedFerrero:state.placedFerrero,kitkatOrientation:state.kitkatOrientation,placedKitkat:state.placedKitkat,oreoOrientation:state.oreoOrientation,placedOreo:state.placedOreo};
    try{
        const res=await fetch('{{ route("customer.cake-builder.saveDraft") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify(cfg)});
        if(res.ok){btn.classList.add('saved');btn.innerHTML=`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><polyline points="20 6 9 17 4 12"/></svg> Saved!`;showToast('✓ Draft saved successfully');setTimeout(()=>{btn.classList.remove('saved');btn.innerHTML=`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Save Draft`;},3000);}
    }catch(e){showToast('⚠ Could not save draft');}
}
if(document.getElementById('btnSaveDraft')) document.getElementById('btnSaveDraft').addEventListener('click',saveDraft);

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
       if(d.cakeType){state.cakeType=d.cakeType;document.getElementById('opts-cake-type').querySelectorAll('[data-cake-type]').forEach(el=>el.classList.toggle('active',el.dataset.cakeType===d.cakeType));syncCakeTypeUI();}
        if(d.filling){state.filling=d.filling;document.getElementById('opts-filling').querySelectorAll('[data-filling]').forEach(el=>el.classList.toggle('active',el.dataset.filling===d.filling));}
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
        cakeType:state.cakeType,
        filling:state.filling,
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

  // Capture canvas at beauty-shot angle then submit
    const canvas = document.querySelector('#model-container canvas');
  if (canvas &&
        window._threeCamera &&
        window._threeControls &&
        window._threeRenderer &&
        window._threeScene) {

        const _cam = window._threeCamera;
        const _ctl = window._threeControls;
        const _ren = window._threeRenderer;
        const _scn = window._threeScene;

        // Save current camera state
        const savedPos    = _cam.position.clone();
        const savedTarget = _ctl.target.clone();

// Move to a good front-facing angle
        const tier = state ? state.tier : 'Single';
        let camY = 0.8, camZ = 7.0, tgtY = -0.6;
        if (tier === 'Two-tier')   { camY = 1.2; camZ = 8.5; tgtY = -0.2; }
        if (tier === 'Three-tier') { camY = 1.8; camZ = 10.5; tgtY = 0.2; }

        _cam.position.set(0, camY, camZ);
        _ctl.target.set(0, tgtY, 0);
        _ctl.update();
        _ren.render(_scn, _cam);

        // Composite: warm background + WebGL canvas
        try {
            const off = document.createElement('canvas');
            off.width  = canvas.width;
            off.height = canvas.height;
            const ctx  = off.getContext('2d');
            const grad = ctx.createLinearGradient(0, 0, off.width, off.height);
            grad.addColorStop(0,   '#E8D5B0');
            grad.addColorStop(0.4, '#D9C49A');
            grad.addColorStop(0.7, '#C8AC7A');
            grad.addColorStop(1,   '#A07840');
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, off.width, off.height);
            ctx.drawImage(canvas, 0, 0);
            document.getElementById('cakePreviewInput').value =
                off.toDataURL('image/jpeg', 0.92);
        } catch(e) {
            console.warn('Canvas capture failed:', e);
        }

// Restore camera instantly
        _cam.position.copy(savedPos);
        _ctl.target.copy(savedTarget);
        _ctl.update();
    }

    document.getElementById('proceedForm').submit();
}
if(document.getElementById('btnProceed')) document.getElementById('btnProceed').addEventListener('click',proceed);
document.getElementById('btnProceedLg').addEventListener('click',proceed);
document.getElementById('btnResetView').addEventListener('click',()=>{if(typeof window.resetCamera==='function')window.resetCamera();showToast('View reset');});
if(typeof window._setSpotBrightness === 'function') window._setSpotBrightness(0.07);
window._updateAll=updateAll;
syncFrostingUI();
updateOmbrePreview();
refreshTierPriceLabels();

// ── PRESET LOADER (from dashboard featured cards) ──
(function applyPreset() {
    const params = new URLSearchParams(window.location.search);
    if (!params.has('preset_flavor')) return;

    const flavor     = params.get('preset_flavor');
    const shape      = params.get('preset_shape')       || 'Round';
    const size       = parseInt(params.get('preset_size') || '6');
    const frosting   = params.get('preset_frosting')    || 'Smooth Buttercream';
    const hasDrip    = params.get('preset_drip')        === '1';
    const dripFlavor = params.get('preset_drip_flavor') || 'Vanilla';
    const sprinkles  = params.get('preset_addon_sprinkles') || null;
    const presetName = params.get('preset_name')        || null;

    // Shape
    state.shape = shape;
    state.roundSize = size;
    document.getElementById('opts-shape').querySelectorAll('[data-val]').forEach(el => {
        el.classList.toggle('active', el.dataset.val === shape);
    });
    document.getElementById('sizeRange').value = size;
    document.getElementById('sizeDisplay').textContent = size;
    document.getElementById('sizeSliderWrap').classList.toggle('visible', shape === 'Round');
    document.getElementById('numberPickerWrap').classList.toggle('visible', shape === 'Number');

    // Flavor
    state.flavor = flavor;
    document.getElementById('opts-flavor').querySelectorAll('[data-val]').forEach(el => {
        el.classList.toggle('active', el.dataset.val === flavor);
    });

    // Frosting
    state.frostings = new Set();
    const CAKE_STYLE_MAP = {
        'Smooth Buttercream':   () => { state.frostings.add('Smooth Buttercream'); },
        'Semi-naked Style':     () => { state.frostings.add('Semi-naked Style'); },
        'Fondant Smooth':       () => { state.frostings.add('Fondant Smooth'); },
        'Textured Buttercream': () => {
            state.frostings.add('Smooth Buttercream');
            state.frostings.add('Textured Buttercream');
        },
    };
    (CAKE_STYLE_MAP[frosting] || CAKE_STYLE_MAP['Smooth Buttercream'])();
    syncFrostingUI();

    // Drip
    if (hasDrip) {
        state.hasDrip = true;
        state.dripFlavor = dripFlavor;
        state.addons.set('Drip', 180);
        document.getElementById('dripToggleBtn').classList.add('active');
        document.getElementById('dripFlavorPanel').classList.add('visible');
        document.getElementById('dripFlavorOpts').querySelectorAll('.drip-flavor-opt').forEach(el => {
            el.classList.toggle('active', el.dataset.dripFlavor === dripFlavor);
        });
    }

    // Sprinkles
    if (sprinkles) {
        const sprinkleEl = document.querySelector(`#opts-sprinkles .addon-opt[data-val="${sprinkles}"]`);
        if (sprinkleEl) {
            state.addons.set(sprinkles, parseInt(sprinkleEl.dataset.price) || 30);
            sprinkleEl.classList.add('active');
            const _waitAndBuild = (attempts) => {
                if (typeof window.buildCylinderSprinkles === 'function') {
                    if (sprinkles === 'Cylinder Sprinkles') {
                        window.buildCylinderSprinkles();
                        document.getElementById('cylinderPlacementPanel').style.display = 'block';
                    }
                    if (sprinkles === 'Sphere Sprinkles') {
                        window.buildPearlSprinkles();
                        document.getElementById('pearlPlacementPanel').style.display = 'block';
                    }
                } else if (attempts > 0) {
                    setTimeout(() => _waitAndBuild(attempts - 1), 300);
                }
            };
            setTimeout(() => _waitAndBuild(15), 800);
        }
    }

    // Toast
    if (presetName) {
        setTimeout(() => showToast(`✨ "${presetName}" loaded — customize it your way!`, 3200), 1200);
    }

    // Clean URL
    window.history.replaceState({}, document.title, window.location.pathname);
})();

function tryInit(){if(typeof window.updateModel==='function')updateAll();else setTimeout(tryInit,80);}
tryInit();
setTimeout(()=>{ if(typeof window._prefetchRosetteModels==='function') window._prefetchRosetteModels(state.shape); }, 400);
setTimeout(()=>{ if(typeof window._preloadAllDecorationAssets==='function') window._preloadAllDecorationAssets(); }, 4000);


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
            <button id="chocoRotInlineDelete" title="Remove this item" style="padding:9px 13px;background:transparent;border:1.5px solid rgba(200,50,30,.40);border-radius:10px;color:#C03020;font-size:.82rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .15s;" onmouseover="this.style.background='rgba(200,50,30,.10)'" onmouseout="this.style.background='transparent'">🗑</button>
            <button id="chocoRotInlineReset" style="padding:9px 12px;background:transparent;border:1.5px solid var(--border-dk);border-radius:10px;color:var(--text-muted);font-size:.72rem;font-weight:600;cursor:pointer;font-family:var(--font-display);">↺</button>
        </div>
    </div>
</div>
<div id="characterMovePanel" style="display:none;">
    <div style="background:linear-gradient(135deg,#3A4A9A 0%,#2A3878 100%);padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:8px;">
            <span style="font-size:1.4rem;line-height:1;">🎭</span>
            <div>
                <div style="font-size:.68rem;font-weight:700;color:#D8E0FF;font-family:var(--font-display);">Move &amp; rotate <span id="characterMovePanelName">character</span></div>
                <div style="font-size:.60rem;color:rgba(216,224,255,0.65);font-family:var(--font-display);">Drag on the cake to move · spin below to rotate</div>
            </div>
        </div>
        <button id="characterMovePanelClose" style="background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.15);border-radius:7px;color:rgba(216,224,255,0.85);font-size:.75rem;cursor:pointer;padding:4px 8px;font-family:var(--font-display);">Done</button>
    </div>
    <div style="background:var(--warm-white);padding:12px 14px;">
        <div style="font-size:.60rem;color:var(--text-muted);margin-bottom:3px;font-family:var(--font-display);font-weight:600;">↔ Rotate 360°</div>
        <input type="range" id="characterMovePanelRange" min="0" max="360" step="5" value="0" class="rot-range" style="width:100%;">
        <div id="characterMovePanelDeg" style="text-align:center;font-size:.80rem;font-weight:700;color:#3A4A9A;font-family:var(--font-display);margin-top:2px;margin-bottom:10px;">0°</div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:5px;margin-bottom:10px;">
            <button class="character-move-preset" data-deg="0"   style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">0°</button>
            <button class="character-move-preset" data-deg="90"  style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">90°</button>
            <button class="character-move-preset" data-deg="180" style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">180°</button>
            <button class="character-move-preset" data-deg="270" style="padding:7px 2px;border:1.5px solid var(--border);border-radius:9px;background:var(--cream);color:var(--brown-mid);font-size:.68rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">270°</button>
        </div>
        <div style="display:flex;gap:6px;">
            <button id="characterMovePanelDelete" title="Remove this topper" style="flex:1;padding:9px 13px;background:transparent;border:1.5px solid rgba(200,50,30,.40);border-radius:10px;color:#C03020;font-size:.76rem;font-weight:700;cursor:pointer;font-family:var(--font-display);">🗑 Remove</button>
            <button id="characterMovePanelReset" style="padding:9px 12px;background:transparent;border:1.5px solid var(--border-dk);border-radius:10px;color:var(--text-muted);font-size:.72rem;font-weight:600;cursor:pointer;font-family:var(--font-display);">↺ Reset</button>
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
            <button id="fruitRotPanelDelete" title="Remove this fruit" style="padding:9px 13px;background:transparent;border:1.5px solid rgba(200,50,30,.40);border-radius:10px;color:#C03020;font-size:.82rem;font-weight:700;cursor:pointer;font-family:var(--font-display);transition:all .15s;" onmouseover="this.style.background='rgba(200,50,30,.10)'" onmouseout="this.style.background='transparent'">🗑</button>
            <button id="fruitRotPanelReset" style="padding:9px 12px;background:transparent;border:1.5px solid var(--border-dk);border-radius:10px;color:var(--text-muted);font-size:.72rem;font-weight:600;cursor:pointer;font-family:var(--font-display);">↺</button>
        </div>
    </div>
</div>
<script>
(function(){
    const TUT_STORAGE_KEY = 'bakesphere_cakebuilder_tutorial_seen';
    const overlay   = document.getElementById('tutOverlay');
    const slidesWrap= document.getElementById('tutSlides');
    const slides    = Array.from(slidesWrap.querySelectorAll('.tut-slide'));
    const dotsWrap  = document.getElementById('tutDots');
    const backBtn   = document.getElementById('tutBackBtn');
    const nextBtn   = document.getElementById('tutNextBtn');
    const skipBtn   = document.getElementById('tutSkipBtn');
    const helpBtn   = document.getElementById('btnHelpTutorial');
    let current = 0;

    slides.forEach((_, i)=>{
        const dot = document.createElement('div');
        dot.className = 'tut-dot' + (i===0 ? ' active' : '');
        dot.addEventListener('click', ()=>goToStep(i));
        dotsWrap.appendChild(dot);
    });
    const dots = Array.from(dotsWrap.querySelectorAll('.tut-dot'));

      function render(){
        slides.forEach((s,i)=>s.classList.toggle('active', i===current));
        dots.forEach((d,i)=>d.classList.toggle('active', i===current));
        backBtn.classList.toggle('tut-hidden', current===0);
        nextBtn.textContent = (current === slides.length-1) ? 'Start Customizing' : 'Next';
    }
    function goToStep(i){ current = Math.max(0, Math.min(slides.length-1, i)); render(); }

    function openTutorial(){
        current = 0; render();
        overlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }
    function closeTutorial(remember){
        overlay.classList.remove('visible');
        document.body.style.overflow = '';
        if(remember){ try{ localStorage.setItem(TUT_STORAGE_KEY, '1'); }catch(e){} }
        playDefaultShellRevealOnce();
    }

    // The default cake loads Smooth Buttercream (Shell Border) behind the
    // tutorial overlay, so it's already fully visible the moment the overlay
    // closes. Retry a few times in case the 3D model is still mid-load.
    function playDefaultShellRevealOnce(attempts){
        attempts = attempts === undefined ? 20 : attempts;
        if(typeof window._triggerShellHideAndReveal === 'function' && window._triggerShellHideAndReveal()){
            return;
        }
        if(attempts > 0) setTimeout(()=>playDefaultShellRevealOnce(attempts-1), 150);
    }
    nextBtn.addEventListener('click', ()=>{
        if(current === slides.length-1){ closeTutorial(true); }
        else { goToStep(current+1); }
    });
    backBtn.addEventListener('click', ()=> goToStep(current-1));
    skipBtn.addEventListener('click', ()=> closeTutorial(true));
    overlay.addEventListener('click', (e)=>{ if(e.target===overlay) closeTutorial(true); });
    if(helpBtn) helpBtn.addEventListener('click', openTutorial);

    openTutorial();
})();
</script>
</body>
</html>