@extends('layouts.baker')
@section('title', 'Order #' . str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --espresso:       #24150F;
    --dark-chocolate: #3A241A;
    --warm-ivory:     #F7F2E9;
    --cream:          #EFE6D7;
    --caramel:        #A96F42;
    --champagne-gold: #B89452;
    --deep-burgundy:  #54252C;
    --taupe:          #9A897A;
    --soft-beige:     #D8C8B7;
    --olive:          #4F6B4A;

    --text-dark:  #24150F;
    --text-mid:   #6F5848;
    --text-muted: #9A897A;
    --rule: 1px solid rgba(36,21,15,.16);
    --ease: cubic-bezier(.22,.8,.32,1);

    /* legacy aliases used by inline styles / partials */
    --brown-deep: var(--espresso);
    --brown-mid: var(--dark-chocolate);
    --caramel-light: var(--champagne-gold);
    --warm-white: var(--warm-ivory);
    --border: rgba(36,21,15,.16);

    /* Adjust this to your real sidebar width from layouts.baker if it differs. */
    --baker-sidebar-w: 260px;
}

.order-wrap, .order-wrap *, .confirm-modal-backdrop *, .reject-modal-backdrop *, .baker3d-backdrop * { font-family: 'Plus Jakarta Sans', sans-serif; }
button, input, select, textarea { font-family: inherit; }
.leaflet-container, .leaflet-popup-content { font-family: 'Plus Jakarta Sans', sans-serif; }
.ic { width: 1em; height: 1em; stroke: currentColor; fill: none; flex: none; }

/* ═══ MOTION ═══ */
@keyframes lx-rise { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
@keyframes lx-draw { from { transform: scaleX(0); } to { transform: scaleX(1); } }
@keyframes lx-glow { 0%,100% { box-shadow: 0 0 0 0 rgba(184,148,82,.5); } 50% { box-shadow: 0 0 0 7px rgba(184,148,82,0); } }
@keyframes spin { to { transform: rotate(360deg); } }
.anim-in { opacity: 0; animation: lx-rise .8s var(--ease) forwards; }
.anim-delay-1 { animation-delay: .05s; } .anim-delay-2 { animation-delay: .15s; } .anim-delay-3 { animation-delay: .25s; }
.anim-delay-4 { animation-delay: .35s; } .anim-delay-5 { animation-delay: .45s; }
@media (prefers-reduced-motion: reduce) {
    .order-wrap *, .order-wrap *::before, .order-wrap *::after { animation: none !important; transition: none !important; opacity: 1 !important; }
}

.order-wrap { padding: 0; }
.back-link { display: inline-flex; align-items: center; gap: .55rem; margin-bottom: 1.5rem; font-size: .66rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--taupe); text-decoration: none; transition: color .3s var(--ease), transform .3s var(--ease); }
.back-link:hover { color: var(--champagne-gold); transform: translateX(-3px); }

/* ═══ HERO (dark container retained) ═══ */
.order-hero { position: relative; overflow: hidden; width: 100%; margin-bottom: 3rem; color: var(--warm-ivory); border-radius: 0;
    padding: clamp(2rem,4vw,3.25rem) clamp(1.25rem,3.5vw,3rem) clamp(1.75rem,3vw,2.5rem);
    background: linear-gradient(180deg, rgba(184,148,82,.12), transparent 50%), var(--espresso); }
.order-hero.s-CANCELLED { background: linear-gradient(180deg, rgba(184,148,82,.1), transparent 50%), var(--deep-burgundy); }
.order-hero::before { content: ''; position: absolute; left: clamp(1.25rem,3.5vw,3rem); right: clamp(1.25rem,3.5vw,3rem); top: 1.25rem; height: 1px; background: rgba(184,148,82,.55); transform-origin: left; animation: lx-draw 1.4s .2s ease backwards; }
.hero-bignum { position: absolute; right: clamp(1rem,3vw,2.5rem); top: 1.75rem; z-index: 0; font-weight: 800; font-size: clamp(6rem,18vw,14rem); line-height: .8; letter-spacing: -.08em; color: transparent; -webkit-text-stroke: 1px rgba(247,242,233,.13); pointer-events: none; user-select: none; }
.hero-top { position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: flex-start; gap: 1.5rem; margin: 1.5rem 0 2.5rem; }
.hero-id { margin-bottom: 1.25rem; font-size: .68rem; font-weight: 700; letter-spacing: .32em; text-transform: uppercase; color: var(--champagne-gold); }
.hero-title { max-width: 16ch; font-size: clamp(2rem,5vw,3.9rem); font-weight: 600; line-height: 1.02; letter-spacing: -.04em; color: var(--warm-ivory); }
.hero-title svg { width: .5em; height: .5em; margin-right: .35em; vertical-align: .12em; stroke: var(--champagne-gold); }
.hero-sub { margin-top: 1rem; max-width: 50ch; font-size: .95rem; font-weight: 300; line-height: 1.7; color: var(--soft-beige); }
.status-badge { align-self: flex-end; padding: .7rem 0 0; border-top: 1px solid var(--champagne-gold); font-size: .66rem; font-weight: 700; letter-spacing: .26em; text-transform: uppercase; white-space: nowrap; color: var(--champagne-gold); }

/* progress: hairline journey */
.progress-row { position: relative; z-index: 1; display: flex; align-items: flex-start; counter-reset: pstep; padding-top: 1.75rem; border-top: 1px solid rgba(247,242,233,.18); }
.p-step { flex: 1; position: relative; display: flex; flex-direction: column; align-items: flex-start; gap: .85rem; padding-right: 1rem; counter-increment: pstep; }
.p-step::after { content: ''; position: absolute; top: 5px; left: 16px; width: calc(100% - 16px); height: 1px; background: rgba(247,242,233,.2); }
.p-step:last-child::after { display: none; }
.p-dot { position: relative; z-index: 1; width: 11px; height: 11px; font-size: 0; color: transparent; border: 1px solid rgba(247,242,233,.4); background: var(--espresso); }
.p-dot svg { display: none; }
.p-dot.done { background: var(--champagne-gold); border-color: var(--champagne-gold); }
.p-dot.active { background: var(--warm-ivory); border-color: var(--champagne-gold); animation: lx-glow 2.2s ease infinite; }
.p-label { text-align: left; font-size: .6rem; font-weight: 600; letter-spacing: .22em; text-transform: uppercase; line-height: 1.3; color: var(--warm-ivory); opacity: .5; }
.p-label::before { content: counter(pstep, decimal-leading-zero); display: block; margin-bottom: .3rem; font-size: 1.5rem; font-weight: 400; letter-spacing: -.02em; }
.p-label.done { opacity: .85; }
.p-label.active { opacity: 1; font-weight: 800; color: var(--champagne-gold); }

/* ═══ LAYOUT ═══ */
.order-page-grid { display: grid; grid-template-columns: minmax(0,1.9fr) minmax(280px,.85fr); gap: 0; align-items: start; }
.order-page-grid > div:first-child { padding-right: clamp(1.5rem,3.5vw,3.5rem); min-width: 0; }
.order-sidebar-col { position: sticky; top: 1.5rem; z-index: 2; padding-left: clamp(1.25rem,2.5vw,2.5rem); border-left: var(--rule); min-width: 0; }
#baker-delivery-map, #delivery-map { position: relative; z-index: 0; isolation: isolate; }
.leaflet-container { z-index: 0 !important; }

/* ═══ SECTIONS (open, hairline-topped) ═══ */
.card { width: 100%; margin-bottom: 3rem; background: transparent; border: 0; border-top: 1px solid var(--espresso); border-radius: 0; box-shadow: none; overflow: visible; }
.card:last-child { margin-bottom: 0; }
.card-header { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1.1rem 0 1.25rem; flex-wrap: wrap; }
.card-header h3 { margin: 0; display: flex; align-items: center; gap: .6rem; font-size: 1.45rem; font-weight: 600; letter-spacing: -.02em; color: var(--espresso); }
.card-header h3 svg { width: 14px; height: 14px; stroke: var(--champagne-gold); stroke-width: 1.6; margin: 0; flex: none; }

.info-row { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: var(--rule); }
.info-row:last-child { border-bottom: none; }
.i-key { font-size: .6rem; font-weight: 700; letter-spacing: .24em; text-transform: uppercase; color: var(--taupe); }
.i-val { font-size: .98rem; font-weight: 500; text-align: right; color: var(--espresso); }
.i-val.accent { font-weight: 700; color: var(--caramel); }
.i-val small { display: flex; justify-content: flex-end; align-items: center; gap: 4px; margin-top: 2px; font-size: .72rem; font-weight: 600; color: var(--caramel); }
.info-row.stack { flex-direction: column; align-items: flex-start; gap: .3rem; }
.info-row.stack .i-text { font-size: .9rem; line-height: 1.6; color: var(--espresso); }
.info-row.stack .i-text.italic { font-style: italic; }

/* Cake spec sheet */
.specs-group { padding: 1.5rem 0 .4rem; border-bottom: var(--rule); }
.specs-group:last-child { border-bottom: none; }
.specs-group-title { margin-bottom: .7rem; font-size: .7rem; font-weight: 700; letter-spacing: .32em; text-transform: uppercase; color: var(--champagne-gold); }
.specs-row { display: grid; grid-template-columns: 150px 1fr; gap: 1.5rem; padding: .8rem 0; border-top: 1px solid rgba(36,21,15,.08); }
.specs-key { font-size: .6rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: var(--taupe); align-self: center; }
.specs-val { font-size: 1.05rem; font-weight: 500; line-height: 1.5; color: var(--espresso); }
.config-grid { display: grid; grid-template-columns: 1fr 1fr; }
.config-item { padding: .9rem 1.25rem .9rem 0; border-bottom: var(--rule); }
.c-label { margin-bottom: .2rem; font-size: .6rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--taupe); }
.c-value { font-size: 1rem; font-weight: 500; color: var(--espresso); }
.details-foot { border-top: 0; margin-top: 0; }

/* ═══ NOTICES / STATES ═══ */
.alert { display: flex; align-items: flex-start; gap: .75rem; margin-bottom: 1.5rem; padding: 1rem 1.25rem; font-size: .86rem; border-left: 3px solid; background: var(--warm-ivory); }
.alert.error { border-color: var(--deep-burgundy); color: var(--deep-burgundy); }
.alert-icon { flex: none; display: grid; place-items: center; font-size: 18px; }
.alert-body { font-weight: 600; }

.report-notice { display: flex; align-items: flex-start; gap: .85rem; margin-bottom: 2rem; padding: 1.1rem 1.35rem; background: var(--warm-ivory); border-left: 3px solid var(--deep-burgundy); box-shadow: 0 10px 30px -14px rgba(36,21,15,.2); }
.report-notice > span { flex: none; color: var(--deep-burgundy); font-size: 18px; display: grid; }
.report-notice-title { margin-bottom: .25rem; font-size: .66rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--deep-burgundy); }
.report-notice-text { font-size: .8rem; line-height: 1.65; color: var(--text-mid); }
.report-notice-text strong { color: var(--espresso); }

.action-area { display: flex; flex-wrap: wrap; align-items: center; gap: .6rem; padding: 0 0 .5rem; }
.action-note { width: 100%; margin: 0; font-size: .75rem; line-height: 1.55; color: var(--text-muted); }

.waiting-box { width: 100%; padding: 1.15rem 1.35rem; background: var(--warm-ivory); border-left: 3px solid var(--champagne-gold); }
.waiting-box .w-icon { display: grid; margin-bottom: .5rem; font-size: 20px; color: var(--champagne-gold); }
.waiting-box .w-title { font-size: 1rem; font-weight: 700; color: var(--espresso); }
.waiting-box .w-sub { margin-top: .3rem; font-size: .8rem; line-height: 1.65; color: var(--text-mid); }
.waiting-box.tone-dark { border-left-color: var(--espresso); }
.waiting-box.tone-dark .w-icon { color: var(--espresso); }
.waiting-box.tone-caramel { border-left-color: var(--caramel); }
.waiting-box.tone-caramel .w-icon, .waiting-box.tone-caramel .w-title { color: var(--caramel); }

/* buttons */
.btn-advance, .btn-confirm-pay, .btn-secondary, .btn-reject-proof { display: inline-flex; align-items: center; justify-content: space-between; gap: .75rem; min-height: 46px; padding: .85rem 1.25rem; border: 1px solid transparent; border-radius: 2px;
    font-size: .68rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; text-decoration: none; cursor: pointer; transition: background .35s var(--ease), color .35s var(--ease), border-color .35s var(--ease); }
.btn-advance, .btn-confirm-pay { background: var(--espresso); border-color: var(--espresso); color: var(--warm-ivory); box-shadow: inset 0 -2px 0 var(--champagne-gold); }
.btn-advance:hover, .btn-confirm-pay:hover { background: var(--champagne-gold); border-color: var(--champagne-gold); color: var(--espresso); }
.btn-secondary { background: transparent; border-color: var(--espresso); color: var(--espresso); justify-content: center; }
.btn-secondary:hover { background: var(--espresso); color: var(--warm-ivory); }
.btn-reject-proof { background: transparent; border-color: var(--deep-burgundy); color: var(--deep-burgundy); }
.btn-reject-proof:hover { background: var(--deep-burgundy); color: var(--warm-ivory); }
.btn-advance .ic, .btn-confirm-pay .ic { width: 14px; height: 14px; }
.btn-advance:focus-visible, .btn-confirm-pay:focus-visible, .btn-secondary:focus-visible, .confirm-modal-btn-ok:focus-visible, .confirm-modal-btn-cancel:focus-visible { outline: 2px solid var(--champagne-gold); outline-offset: 2px; }

.complete-card { padding: 2rem 0; text-align: center; }
.complete-card .ic { width: 40px; height: 40px; stroke: var(--champagne-gold); stroke-width: 1.3; margin-bottom: .75rem; }
.complete-card .cc-title { font-size: 1.3rem; font-weight: 600; letter-spacing: -.01em; color: var(--espresso); }
.complete-card .cc-sub { margin-top: .3rem; font-size: .82rem; color: var(--text-muted); }

/* map card */
.map-frame { width: 100%; height: 260px; border: var(--rule); }
.map-foot { display: flex; justify-content: space-between; align-items: center; gap: .75rem; padding: .9rem 0 0; flex-wrap: wrap; }
.map-foot .dist { font-size: .74rem; color: var(--text-muted); }

/* ═══ SIDEBAR ═══ */
.id-card { position: relative; overflow: hidden; margin-bottom: 2.5rem; padding: 2.1rem 1.75rem; background: var(--espresso); color: var(--warm-ivory); text-align: left; box-shadow: 0 20px 50px rgba(36,21,15,.12); }
.id-card::before { content: ''; position: absolute; left: 1.75rem; right: 1.75rem; top: 0; height: 2px; background: var(--champagne-gold); }
.id-label { font-size: .62rem; font-weight: 700; letter-spacing: .3em; text-transform: uppercase; color: var(--champagne-gold); }
.id-num { margin: .4rem 0; font-size: 3.6rem; font-weight: 300; line-height: 1; letter-spacing: -.06em; color: var(--warm-ivory); }
.id-date { font-size: .72rem; color: var(--taupe); }
.id-divider { margin: 1.15rem 0; border: none; border-top: 1px solid rgba(247,242,233,.15); }
.id-sub { margin-bottom: .3rem; font-size: .6rem; font-weight: 700; letter-spacing: .24em; text-transform: uppercase; color: var(--taupe); }
.id-val { font-size: .95rem; font-weight: 700; color: var(--warm-ivory); }
.id-val.gold { color: var(--champagne-gold); }
.id-val.price { font-size: 1.9rem; font-weight: 300; letter-spacing: -.04em; }

/* payment status (dark) */
.pay-card { margin-bottom: 2.5rem; background: var(--espresso); color: var(--warm-ivory); border-top: 2px solid var(--champagne-gold); box-shadow: 0 20px 50px rgba(36,21,15,.12); }
.pay-card h3 { margin: 0; padding: 1.5rem 1.5rem 1rem; font-size: 1.35rem; font-weight: 500; letter-spacing: -.01em; color: var(--warm-ivory); }
.pay-secure { display: flex; align-items: flex-start; gap: .5rem; padding: .8rem 1.5rem; border-top: 1px solid rgba(247,242,233,.14); border-bottom: 1px solid rgba(247,242,233,.14); font-size: .72rem; line-height: 1.55; color: var(--soft-beige); }
.pay-secure .ic { margin-top: 2px; color: var(--champagne-gold); }
.pay-line { display: flex; align-items: center; justify-content: space-between; gap: .75rem; padding: 1.25rem 1.5rem; }
.pay-line .k { margin-bottom: .2rem; font-size: .6rem; font-weight: 700; letter-spacing: .28em; text-transform: uppercase; color: var(--champagne-gold); }
.pay-line .amt { font-size: 1.9rem; font-weight: 300; letter-spacing: -.04em; color: var(--warm-ivory); }
.pill { display: inline-flex; align-items: center; gap: 5px; padding: .3rem .65rem; border: 1px solid; border-radius: 2px; font-size: .58rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; white-space: nowrap; }
.pill .ic { width: 10px; height: 10px; stroke-width: 2.5; }
.pill.escrow { color: var(--champagne-gold); border-color: var(--champagne-gold); }
.pill.released { color: #9CC7A8; border-color: rgba(156,199,168,.6); }
.pill.verifying { color: var(--soft-beige); border-color: rgba(216,200,183,.5); }
.pill.rejected { color: #d9a0a8; border-color: rgba(217,160,168,.6); }
.pill.awaiting { color: var(--taupe); border-color: rgba(154,137,122,.6); }
.pay-payout { display: flex; justify-content: space-between; align-items: center; gap: .5rem; padding: 1rem 1.5rem; border-top: 1px solid rgba(247,242,233,.14); font-size: .72rem; color: var(--soft-beige); }
.pay-payout b { font-size: 1.15rem; font-weight: 600; color: var(--champagne-gold); }
.pay-released { display: flex; align-items: center; gap: .5rem; padding: .95rem 1.5rem; border-top: 1px solid rgba(247,242,233,.14); font-size: .78rem; font-weight: 600; color: #9CC7A8; flex-wrap: wrap; }
.pay-released a { display: inline-flex; align-items: center; gap: .3rem; color: var(--champagne-gold); font-weight: 700; text-decoration: none; }
.pay-released a .ic { width: 12px; height: 12px; }

.preview-img-wrap { width: 100%; line-height: 0; overflow: hidden; background: radial-gradient(70% 60% at 50% 45%, #FFFBF3, transparent 70%), var(--cream); }
.preview-img-wrap img { width: 100%; height: auto; display: block; }
.card-foot { padding: .75rem 0 0; font-size: .72rem; line-height: 1.55; text-align: center; color: var(--text-muted); }
.ref-img { width: 100%; max-height: 220px; object-fit: cover; display: block; filter: saturate(.92) contrast(1.02); }

/* timeline */
.timeline-log { list-style: none; padding: 0; margin: 0; }
.timeline-log li { position: relative; display: flex; gap: .75rem; padding: 1.1rem 0 1.1rem 2rem; }
.timeline-log li:not(:last-child)::after { content: ''; position: absolute; left: 4px; top: 1.9rem; bottom: -.2rem; width: 1px; background: var(--soft-beige); }
.log-dot { position: absolute; left: 0; top: 1.45rem; width: 9px; height: 9px; background: var(--warm-ivory); border: 1px solid var(--champagne-gold); }
.timeline-log li:first-child .log-dot { background: var(--champagne-gold); }
.log-event { font-size: 1rem; font-weight: 600; color: var(--espresso); }
.log-event.gold { color: var(--caramel); }
.log-event.red { color: var(--deep-burgundy); }
.log-time { margin-top: .15rem; font-size: .6rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--taupe); }

/* payment methods / proof (kept for compatibility) */
.bpm-item { display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: var(--rule); }
.bpm-type { display: flex; align-items: center; gap: .5rem; font-size: .9rem; font-weight: 700; color: var(--espresso); }
.bpm-details { text-align: right; font-size: .78rem; color: var(--text-muted); }
.bpm-details strong { display: block; font-size: .85rem; color: var(--text-dark); }
.proof-section { padding: 1rem 0; border-top: var(--rule); }
.proof-section.proof-rejected { border-top-color: var(--deep-burgundy); }
.proof-section-label { display: flex; align-items: center; gap: .5rem; margin-bottom: .6rem; font-size: .62rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: var(--text-muted); }
.label-badge { padding: .1rem .45rem; border: 1px solid; border-radius: 2px; font-size: .58rem; }
.label-badge.rejected { color: var(--deep-burgundy); } .label-badge.pending { color: var(--caramel); } .label-badge.confirmed { color: var(--olive); }
.proof-img-full { width: 100%; max-height: 220px; object-fit: contain; border: var(--rule); background: var(--cream); }
.proof-img-full.dimmed { opacity: .5; }
.proof-meta-row { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: .6rem; font-size: .75rem; color: var(--text-muted); }
.rejection-reason-box { margin-top: .75rem; padding: .75rem 1rem; border-left: 3px solid var(--deep-burgundy); background: var(--warm-ivory); }
.rejection-reason-box .rr-label { margin-bottom: .25rem; font-size: .6rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--deep-burgundy); }
.rejection-reason-box .rr-text { font-size: .85rem; font-weight: 600; color: var(--espresso); }
.rejection-reason-box .rr-note { margin-top: .3rem; font-size: .76rem; font-style: italic; line-height: 1.5; color: var(--text-mid); }

/* ═══ MODALS ═══ */
.confirm-modal-backdrop, .reject-modal-backdrop { position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem; opacity: 0; pointer-events: none; background: rgba(24,12,7,.78); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); transition: opacity .3s var(--ease); }
.reject-modal-backdrop { z-index: 10000; }
.confirm-modal-backdrop.is-open, .reject-modal-backdrop.is-open { opacity: 1; pointer-events: all; }
.confirm-modal, .reject-modal { width: 100%; max-width: 420px; max-height: calc(100dvh - 2rem); overflow-y: auto; background: var(--warm-ivory); border: 1px solid var(--champagne-gold); border-radius: 2px; box-shadow: 0 30px 80px rgba(0,0,0,.4); transform: translateY(16px); transition: transform .5s var(--ease); }
.reject-modal { max-width: 460px; }
.confirm-modal-backdrop.is-open .confirm-modal, .reject-modal-backdrop.is-open .reject-modal { transform: none; }
.confirm-modal-header, .reject-modal-header { padding: 2rem 2rem 1.6rem; text-align: left; background: var(--espresso); border-bottom: 2px solid var(--champagne-gold); }
.reject-modal-header { background: var(--deep-burgundy); }
.confirm-modal-icon, .reject-modal-icon { display: block; margin: 0 0 1.1rem; }
.confirm-modal-icon svg, .reject-modal-icon svg { stroke: var(--champagne-gold) !important; stroke-width: 1.3; }
.confirm-modal-title, .reject-modal-title { margin-bottom: .35rem; font-size: 1.6rem; font-weight: 500; letter-spacing: -.02em; line-height: 1.15; color: var(--warm-ivory); }
.confirm-modal-subtitle, .reject-modal-sub { font-size: .8rem; line-height: 1.55; color: var(--soft-beige); }
.confirm-modal-body, .reject-modal-body { padding: 1.5rem 2rem; }
.confirm-modal-detail { margin-bottom: 1.15rem; padding: .4rem 0; border-top: 1px solid var(--espresso); }
.confirm-modal-detail-row { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: .65rem 0; border-bottom: var(--rule); font-size: .84rem; }
.confirm-modal-detail-row:last-child { border-bottom: none; }
.confirm-modal-detail-key { font-size: .6rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--taupe); }
.confirm-modal-detail-val { font-size: .95rem; font-weight: 600; text-align: right; color: var(--espresso); }
.confirm-modal-detail-val.gold { color: var(--caramel); }
.confirm-modal-detail-val.big { font-size: 1.1rem; font-weight: 800; }
.confirm-modal-note { padding: 0; font-size: .8rem; line-height: 1.65; text-align: left; color: var(--text-muted); margin: 0; }
.confirm-modal-note.boxed { padding: .8rem 1rem; border-left: 3px solid var(--champagne-gold); background: var(--cream); color: var(--text-mid); }
.confirm-modal-footer, .reject-modal-footer { display: flex; gap: .7rem; padding: 0 2rem 2rem; }
.confirm-modal-btn-cancel, .reject-modal-cancel { flex: 1; min-height: 46px; padding: .8rem 1rem; border: 1px solid var(--espresso); border-radius: 2px; background: transparent; color: var(--espresso); font-size: .66rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; cursor: pointer; transition: background .3s, color .3s; }
.confirm-modal-btn-cancel:hover, .reject-modal-cancel:hover { background: var(--espresso); color: var(--warm-ivory); }
.confirm-modal-btn-ok, .reject-modal-submit { flex: 2; min-height: 46px; display: flex; align-items: center; justify-content: center; gap: .4rem; padding: .8rem 1rem; border: 0; border-radius: 2px; background: var(--espresso); color: var(--warm-ivory); box-shadow: inset 0 -2px 0 var(--champagne-gold);
    font-size: .68rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; cursor: pointer; transition: background .3s, color .3s; }
.confirm-modal-btn-ok:hover:not(:disabled), .reject-modal-submit:hover:not(:disabled) { background: var(--champagne-gold); color: var(--espresso); }
.confirm-modal-btn-ok:disabled, .reject-modal-submit:disabled { opacity: .5; cursor: not-allowed; }
.reject-modal-submit { background: var(--deep-burgundy); }
.btn-spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; }
.is-loading .btn-spinner { display: block; }
.is-loading .btn-text { display: none; }

/* photo upload inside mark-ready modal */
.dz-label { display: flex; align-items: center; gap: .4rem; margin-bottom: .5rem; font-size: .62rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: var(--text-muted); }
.dz-label .ic { width: 13px; height: 13px; color: var(--champagne-gold); }
.dz-label .req { color: var(--deep-burgundy); }
.dropzone { padding: 1rem; border: 1px dashed var(--taupe); border-radius: 2px; background: #fff; text-align: center; cursor: pointer; transition: border-color .3s, background .3s; }
.dropzone:hover { border-color: var(--champagne-gold); }
.dz-icon { display: grid; justify-content: center; margin-bottom: .3rem; font-size: 24px; color: var(--champagne-gold); }
.dz-title { font-size: .8rem; font-weight: 600; color: var(--espresso); }
.dz-sub { margin-top: .2rem; font-size: .68rem; color: var(--text-muted); }
.dz-preview { max-height: 140px; border: var(--rule); object-fit: cover; }
.dz-file { margin-top: .4rem; font-size: .72rem; font-weight: 600; color: var(--espresso); }
.dz-ok { display: flex; align-items: center; justify-content: center; gap: 3px; margin-top: .1rem; font-size: .65rem; font-weight: 700; color: var(--olive); }
.dz-ok .ic { width: 10px; height: 10px; stroke-width: 3; }
.dz-error { display: none; align-items: center; gap: 4px; margin-top: .4rem; font-size: .72rem; font-weight: 600; color: var(--deep-burgundy); }
.dz-error .ic { width: 12px; height: 12px; }

/* reject modal */
.reject-warning-box { display: flex; align-items: flex-start; gap: .6rem; margin-bottom: 1.25rem; padding: .85rem 1rem; border-left: 3px solid var(--champagne-gold); background: var(--cream); font-size: .78rem; line-height: 1.55; color: var(--text-mid); }
.reject-warning-box svg { flex: none; color: var(--champagne-gold); }
.reject-reasons-label { margin-bottom: .6rem; font-size: .6rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: var(--text-muted); }
.reject-reason-list { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.25rem; }
.reject-reason-item { display: flex; align-items: center; gap: .75rem; padding: .7rem 1rem; border: 1px solid var(--soft-beige); border-radius: 2px; background: #fff; font-size: .84rem; color: var(--text-dark); cursor: pointer; user-select: none; transition: border-color .2s, background .2s; }
.reject-reason-item:hover { border-color: var(--deep-burgundy); }
.reject-reason-item.selected { border-color: var(--deep-burgundy); background: rgba(84,37,44,.06); color: var(--deep-burgundy); font-weight: 600; }
.reject-reason-radio { width: 14px; height: 14px; flex: none; border: 1px solid var(--taupe); }
.reject-reason-item.selected .reject-reason-radio { border-color: var(--deep-burgundy); background: var(--deep-burgundy); box-shadow: inset 0 0 0 3px #fff; }
.reject-note-area { width: 100%; min-height: 80px; padding: .75rem 1rem; border: 1px solid var(--soft-beige); border-radius: 2px; background: #fff; font-size: .85rem; color: var(--text-dark); resize: vertical; transition: border-color .2s; }
.reject-note-area:focus { outline: none; border-color: var(--champagne-gold); }
.reject-spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; }

/* 3D modal */
.baker3d-backdrop { position: fixed; top: 0; right: 0; bottom: 0; left: var(--baker-sidebar-w, 0px); z-index: 2147483000; display: flex; align-items: center; justify-content: center; padding: 1.5rem; opacity: 0; pointer-events: none; background: rgba(24,12,7,.78); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); transition: opacity .28s ease; }
.baker3d-backdrop.is-open { opacity: 1; pointer-events: all; }
.baker3d-panel { width: 100%; max-width: 900px; height: 85vh; display: flex; flex-direction: column; overflow: hidden; background: var(--warm-ivory); border: 1px solid var(--champagne-gold); border-radius: 2px; box-shadow: 0 32px 80px rgba(0,0,0,.45); transform: translateY(20px); transition: transform .45s var(--ease); }
.baker3d-backdrop.is-open .baker3d-panel { transform: none; }
.b3d-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem 1.4rem; flex-shrink: 0; background: var(--espresso); border-bottom: 2px solid var(--champagne-gold); }
.b3d-head strong { font-size: .95rem; font-weight: 600; letter-spacing: -.01em; color: var(--warm-ivory); }
.b3d-close { display: grid; place-items: center; width: 32px; height: 32px; border: 1px solid rgba(247,242,233,.3); background: none; color: var(--warm-ivory); cursor: pointer; font-size: 14px; transition: background .3s, color .3s; }
.b3d-close:hover { background: var(--champagne-gold); color: var(--espresso); }
.b3d-body { flex: 1; position: relative; background: var(--cream); }
.b3d-body iframe { width: 100%; height: 100%; border: 0; display: block; }
.b3d-loading { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .85rem; font-size: .8rem; color: var(--text-muted); background: var(--cream); }
.b3d-loading .b3d-icon { display: block; animation: baker3d-bounce 1.1s ease-in-out infinite; }
.b3d-loading .pct { font-size: .9rem; font-weight: 700; color: var(--caramel); }
.b3d-foot { flex-shrink: 0; padding: .7rem 1.25rem; border-top: var(--rule); font-size: .68rem; letter-spacing: .04em; text-align: center; color: var(--text-muted); }
@keyframes baker3d-bounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
@keyframes baker3d-dot { 0%,80%,100% { opacity: .2; } 40% { opacity: 1; } }

/* ═══ VERTICAL CENTERING BETWEEN LINES ═══ */
.SPECS-GROUP { PADDING: 1.25REM 0 0; }
.SPECS-GROUP-TITLE { MARGIN-BOTTOM: 1.25REM; LINE-HEIGHT: 1; }
.SPECS-ROW { ALIGN-ITEMS: CENTER; PADDING: .9REM 0; }
.SPECS-KEY, .I-KEY, .C-LABEL, .LOG-TIME { LINE-HEIGHT: 1; }
.SPECS-VAL, .I-VAL { LINE-HEIGHT: 1.35; }
.INFO-ROW { ALIGN-ITEMS: CENTER; PADDING: 1REM 0; }
.I-VAL { DISPLAY: FLEX; FLEX-DIRECTION: COLUMN; ALIGN-ITEMS: FLEX-END; JUSTIFY-CONTENT: CENTER; }
.TIMELINE-LOG LI { ALIGN-ITEMS: CENTER; }
.LOG-DOT { TOP: 50%; TRANSFORM: TRANSLATEY(-50%); }
.TIMELINE-LOG LI:NOT(:LAST-CHILD)::AFTER { TOP: 50%; BOTTOM: -50%; }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 900px) {
    .order-page-grid { display: block; }
    .order-page-grid > div:first-child { padding-right: 0; }
    .order-sidebar-col { position: static; margin-top: 3rem; padding-left: 0; border-left: 0; border-top: 1px solid var(--espresso); padding-top: 2rem; }
    .baker3d-backdrop { left: 0; }
}
@media (max-width: 767.98px) {
    .hero-top { flex-direction: column; gap: 1.25rem; margin-bottom: 2rem; }
    .status-badge { align-self: flex-start; }
    .card-header h3 { font-size: 1.25rem; }
    .btn-advance, .btn-confirm-pay { width: 100%; }
    .confirm-modal-footer, .reject-modal-footer { flex-direction: column-reverse; }
    .confirm-modal-btn-cancel, .confirm-modal-btn-ok, .reject-modal-cancel, .reject-modal-submit { flex: none; width: 100%; }
    input, select, textarea { font-size: 16px; }
}
@media (max-width: 575.98px) {
    .specs-row { grid-template-columns: 1fr; gap: .15rem; }
    .config-grid { grid-template-columns: 1fr; }
    .confirm-modal-header, .reject-modal-header { padding: 1.5rem 1.25rem 1.25rem; }
    .confirm-modal-body, .reject-modal-body { padding: 1.25rem; }
    .confirm-modal-footer, .reject-modal-footer { padding: 0 1.25rem 1.5rem; }
    .progress-row { flex-direction: column; gap: 0; padding-top: 1rem; }
    .p-step { flex-direction: row; align-items: center; gap: 1rem; padding: .8rem 0; border-bottom: 1px solid rgba(247,242,233,.1); }
    .p-step::after { display: none; }
    .p-label { display: flex; align-items: baseline; gap: .75rem; }
    .p-label::before { margin: 0; font-size: 1.15rem; }
}
</style>
@endpush

@section('content')

@php
  $statusFlow   = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','DELIVERED'];
$icoCheck     = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
$icoHourglass = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.17a2 2 0 0 0-.59-1.42L12 12l-4.41 4.41A2 2 0 0 0 7 17.83V22"/><path d="M7 2v4.17a2 2 0 0 0 .59 1.42L12 12l4.41-4.41A2 2 0 0 0 17 6.17V2"/></svg>';
$icoBowl      = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10h18l-1.5 8.5a2 2 0 0 1-2 1.5H6.5a2 2 0 0 1-2-1.5Z"/><path d="M7 10V6a5 5 0 0 1 10 0v4"/></svg>';
$icoPackage   = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
$icoTruck     = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>';
$icoX         = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

$statusLabels = [
    'ACCEPTED'            => ['icon' => $icoCheck, 'label' => 'Accepted',        'sub' => 'Customer bid accepted'],
    'WAITING_FOR_PAYMENT' => ['icon' => '',   'dot' => $icoHourglass, 'label' => 'Awaiting Payment', 'sub' => 'Waiting for customer payment'],
    'PREPARING'           => ['icon' => $icoBowl, 'label' => 'Preparing',       'sub' => 'Working on the cake'],
    'READY'               => ['icon' => $icoPackage, 'label' => 'Ready',           'sub' => 'Cake is ready for delivery'],
    'DELIVERED'           => ['icon' => $icoTruck, 'label' => 'Delivered',       'sub' => 'Cake delivered'],
    'COMPLETED'           => ['icon' => '',   'label' => 'Completed',       'sub' => 'Order fully completed'],
    'CANCELLED'           => ['icon' => $icoX, 'label' => 'Cancelled',       'sub' => 'Order cancelled'],
];

$displayStatus = in_array($order->status, ['COMPLETED', 'OUT_FOR_DELIVERY']) ? 'DELIVERED' : $order->status;
$currentIdx    = array_search($displayStatus, $statusFlow);
if ($currentIdx === false) $currentIdx = -1;

$config = is_array($order->cakeRequest->cake_configuration)
    ? $order->cakeRequest->cake_configuration
    : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);

// Detailed specs (same data the customer sees). Falls back to the old grid for older orders.
$specsHtml = '';
foreach (($config['baker_summary'] ?? []) as $group) {
    if (empty($group['rows'])) continue;
    $specsHtml .= '<div class="specs-group"><div class="specs-group-title">' . e($group['title'] ?? '') . '</div>';
    foreach ($group['rows'] as $row) {
        $specsHtml .= '<div class="specs-row"><span class="specs-key">' . e((string)($row[0] ?? '')) . '</span><span class="specs-val">' . e((string)($row[1] ?? '')) . '</span></div>';
    }
    $specsHtml .= '</div>';
}
if ($specsHtml === '') {
    $cake = [];
    if (!empty($config['cakeType']))   $cake[] = ['Type', $config['cakeType']];
    if (!empty($config['shapeLabel'])) $cake[] = ['Shape', $config['shapeLabel']];
    elseif (!empty($config['shape']))  $cake[] = ['Shape', $config['shape']];
    if (!empty($config['tier']) && $config['tier'] !== 'Single') $cake[] = ['Tiers', $config['tier']];
    if (!empty($config['size']))       $cake[] = ['Size', $config['size']];

    $flavor        = [];
    $tierFlavors   = $config['tierFlavors']   ?? [];
    $tierFrostings = $config['tierFrostings'] ?? [];
    $tierFillings  = $config['tierFillings']  ?? [];
    $tierLayers    = $config['tierLayers']    ?? [];
    $tc = max(count($tierFlavors), count($tierFrostings), 1);
    for ($i = 0; $i < $tc; $i++) {
        $parts = [];
        if (!empty($tierFlavors[$i])) $parts[] = $tierFlavors[$i] . ' cake';
        $layers = $tierLayers[$i] ?? 1;
        if ($layers) $parts[] = $layers . ' ' . ($layers > 1 ? 'layers' : 'layer');
        if ($layers > 1 && !empty($tierFillings[$i]) && $tierFillings[$i] !== 'No Filling') $parts[] = $tierFillings[$i] . ' filling';
        if (!empty($tierFrostings[$i])) $parts[] = $tierFrostings[$i] . ' frosting';
        if ($parts) {
            $label = $tc > 1 ? 'Tier ' . ($i + 1) . ($i === 0 ? ' (bottom)' : ($i === $tc - 1 ? ' (top)' : '')) : 'Cake';
            $flavor[] = [$label, implode(' · ', $parts)];
        }
    }

    $frost = [];
    if (!empty($config['frosting']))             $frost[] = ['Style', $config['frosting']];
    if (!empty($config['shellBorderColorName'])) $frost[] = ['Shell border', $config['shellBorderColorName']];
    if (!empty($config['icingColorName']))       $frost[] = ['Sugar icing', $config['icingColorName']];

    $deco = [];
    if (!empty($config['hasDrip'])) $deco[] = ['Drip', trim(($config['dripFlavor'] ?? '') . ' drip')];
    $tierFruitBorders = $config['tierFruitBorders'] ?? [];
    foreach ($tierFruitBorders as $i => $f) {
        if (!empty($f) && $f !== 'None') $deco[] = ['Tier ' . ($i + 1) . ' fruit border', $f];
    }
    if (!empty($config['addons'])) $deco[] = ['Add-ons', implode(', ', (array) $config['addons'])];

    foreach ([
        ['title' => 'Cake',              'rows' => $cake],
        ['title' => 'Flavor & Layers',   'rows' => $flavor],
        ['title' => 'Frosting',          'rows' => $frost],
        ['title' => 'Decorations',       'rows' => $deco],
    ] as $group) {
        if (empty($group['rows'])) continue;
        $specsHtml .= '<div class="specs-group"><div class="specs-group-title">' . e($group['title']) . '</div>';
        foreach ($group['rows'] as $row) {
            $specsHtml .= '<div class="specs-row"><span class="specs-key">' . e((string)($row[0] ?? '')) . '</span><span class="specs-val">' . e((string)($row[1] ?? '')) . '</span></div>';
        }
        $specsHtml .= '</div>';
    }

    if ($specsHtml === '') {
        $specsHtml = '<div class="config-grid">';
        foreach (['shape','size','flavor','frosting'] as $k) {
            if (!empty($config[$k])) {
                $specsHtml .= '<div class="config-item"><div class="c-label">' . e(ucfirst($k)) . '</div><div class="c-value">' . e((string) $config[$k]) . '</div></div>';
            }
        }
        if (!empty($config['addons'])) {
            $specsHtml .= '<div class="config-item" style="grid-column:1/-1; border-right:none;"><div class="c-label">Add-ons</div><div class="c-value">' . e(implode(', ', (array) $config['addons'])) . '</div></div>';
        }
        $specsHtml .= '</div>';
    }
}

$totalAmount = $order->agreed_price;
$finalAmount = $totalAmount / 2;

$payment = \App\Models\Payment::where('cake_request_id', $order->cake_request_id)
    ->where('payment_type', 'full')
    ->first();

$paymentEscrow     = $payment?->escrow_status;
$paymentIsPaid     = $payment && $payment->status === 'confirmed';
$paymentIsPending  = $payment && $payment->status === 'pending';
$paymentIsRejected = $payment && $payment->status === 'rejected';

$info = $statusLabels[$order->status] ?? $statusLabels['ACCEPTED'];

$isPickup = $order->cakeRequest->isPickup();

if ($isPickup) {
    $statusLabels['DELIVERED']['label'] = 'Collected';
    $statusLabels['DELIVERED']['icon']  = '';
}

$rejectionReasons = \App\Models\Payment::REJECTION_REASONS;
@endphp

<div class="order-wrap">

<a href="{{ route('baker.orders.index') }}" class="back-link">
    <svg class="ic" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><path d="M19 12H5"/><path d="m11 18-6-6 6-6"/></svg>
    All Orders
</a>


    @if(session('error'))
    <div class="alert error">
        <span class="alert-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></span>
        <div><div class="alert-body">{{ session('error') }}</div></div>
    </div>
    @endif

  {{-- ── HERO ── --}}
    @php
    $heroTitle = $info['icon'] . ' ' . $info['label'];
$heroSub   = $isPickup ? ' Pickup order — customer already paid in full, ready for collection' : $info['sub'];
if ($order->status === 'READY' && $paymentEscrow === 'held') {
    $heroTitle = $isPickup ? 'Ready for Pickup' : 'Out for Delivery';
    $heroSub   = $isPickup
        ? 'Payment already secured — customer will come collect the cake.'
        : 'Payment secured — deliver the cake. Your payment releases once the customer confirms receipt.';
}
    @endphp
    <div class="order-hero s-{{ $order->status }} anim-in anim-delay-1">
        <div class="hero-bignum" aria-hidden="true">{{ str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div class="hero-top">
            <div>
          <div class="hero-id">Order #{{ str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                      <div class="hero-title">{!! $heroTitle !!}</div>
                <div class="hero-sub">{{ $heroSub }}</div>
            </div>
            <div class="status-badge">
                {{ str_replace('_', ' ', $order->status) }}
            </div>
        </div>

        @if($order->status !== 'CANCELLED')
        <div class="progress-row">
            @foreach($statusFlow as $i => $st)
            @php
                $isDone   = $i < $currentIdx;
                $isActive = $i === $currentIdx;
                $sl       = $statusLabels[$st] ?? [];
            @endphp
            <div class="p-step">
                              <div class="p-dot {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
               {!! $isDone ? $icoCheck : ($sl['dot'] ?? $sl['icon'] ?? $i+1) !!}
                </div>
                <div class="p-label {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                    {{ $sl['label'] ?? $st }}
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── TWO-COLUMN LAYOUT ── --}}
    <div class="order-page-grid">

        {{-- ════════════════ LEFT COLUMN ════════════════ --}}
        <div>



           @php
    $reportAgainstBakerOnOrder = \App\Models\Report::where('reported_id', auth()->id())
        ->where('baker_order_id', $order->id)
        ->first();
@endphp
@if($reportAgainstBakerOnOrder)
<div class="report-notice">
    <span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></span>
    <div>
        <div class="report-notice-title">A report has been filed against you for this order</div>
        <div class="report-notice-text">
            Category: <strong>{{ strip_tags(\App\Models\Report::CATEGORIES[$reportAgainstBakerOnOrder->category] ?? $reportAgainstBakerOnOrder->category) }}</strong><br>
            Status: <strong>{{ ucfirst($reportAgainstBakerOnOrder->status) }}</strong> — Our admin team is reviewing this. Please continue to communicate with the customer.
        </div>
    </div>
</div>
@endif
@if(!in_array($order->status, ['COMPLETED','CANCELLED']))
            <div class="card anim-in anim-delay-2">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Actions</h3></div>
                <div class="action-area">

                           @if($order->status === 'WAITING_FOR_PAYMENT')
                    <div class="waiting-box">
                        <div class="w-title">Waiting for Customer Payment</div>
                        <div class="w-sub">We will notify you once the customer has paid in full. No action needed on your end right now — just sit tight!</div>
                    </div>

                @elseif($order->status === 'PREPARING')
                    <form id="form-mark-ready" method="POST" action="{{ route('baker.orders.advance', $order->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="cake_final_photo" id="form-mark-ready-photo" accept="image/*" style="display:none;">
                    </form>
                    <div class="waiting-box tone-dark">
                                      <div class="w-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10h18l-1.5 8.5a2 2 0 0 1-2 1.5H6.5a2 2 0 0 1-2-1.5Z"/><path d="M7 10V6a5 5 0 0 1 10 0v4"/></svg></div>
                        <div class="w-title">You can start preparing now!</div>
                        <div class="w-sub">The customer's payment has been confirmed in full. Start crafting the cake and click the button below when it's ready.</div>
                    </div>
                    <button type="button" class="btn-advance"
                        onclick="openConfirmModal('modal-mark-ready')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>Mark as Ready for {{ $isPickup ? 'Pickup' : 'Delivery' }}
                    </button>
                    <p class="action-note">Upload a photo of your finished cake and notify your customer.</p>
                @elseif($order->status === 'READY')
                 <form id="form-confirm-final" method="POST" action="{{ route('baker.orders.advance', $order->id) }}">
                        @csrf
                    </form>
                    @if($isPickup)
                        <div class="waiting-box">
                            <div class="w-title">Waiting for customer to arrive</div>
                            <div class="w-sub">Payment was already made in full online. Hand over the cake, then confirm below.</div>
                        </div>
                        <button type="button" class="btn-confirm-pay"
                            onclick="openConfirmModal('modal-confirm-final')">
                             Confirm Pickup &amp; Complete
                        </button>
                    @elseif($paymentEscrow === 'held')
                        <div class="waiting-box tone-dark">
                            <div class="w-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                            <div class="w-title">Waiting for customer approval</div>
                            <div class="w-sub">Payment is secured. Your customer is reviewing the cake photo — once they approve, you'll be able to mark it out for delivery.</div>
                        </div>
                    @else
                        <div class="waiting-box">
                            <div class="w-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.17a2 2 0 0 0-.59-1.42L12 12l-4.41 4.41A2 2 0 0 0 7 17.83V22"/><path d="M7 2v4.17a2 2 0 0 0 .59 1.42L12 12l4.41-4.41A2 2 0 0 0 17 6.17V2"/></svg></div>
                            <div class="w-title">Verifying payment</div>
                            <div class="w-sub">Our team is confirming the customer's payment. You'll be notified once funds are held in escrow.</div>
                        </div>
                    @endif

                @elseif($order->status === 'OUT_FOR_DELIVERY')
                    <form id="form-mark-delivered" method="POST" action="{{ route('baker.orders.mark-delivered', $order->id) }}">
                        @csrf
                    </form>
                    <div class="waiting-box tone-caramel">
                        <div class="w-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></div>
                        <div class="w-title">Customer approved — deliver the cake!</div>
                        <div class="w-sub">Once it's on its way, mark it delivered so the customer knows to expect it.</div>
                    </div>
                    <button type="button" class="btn-advance" onclick="openConfirmModal('modal-mark-delivered')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>Mark as Delivered
                    </button>

                @elseif($order->status === 'DELIVERED')
                    <div class="waiting-box tone-dark">
                        <div class="w-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                        <div class="w-title">Delivered — awaiting customer confirmation</div>
                        <div class="w-sub">Your full payment of ₱{{ number_format($order->agreed_price, 2) }} will be released to your wallet once the customer confirms receipt.</div>
                    </div>
                @endif

                </div>
            </div>
            @elseif(in_array($order->status, ['COMPLETED','DELIVERED']))
            <div class="card anim-in anim-delay-2">
                <div class="complete-card">
                    <svg class="ic" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <div class="cc-title">Order Complete!</div>
                    <div class="cc-sub">
                        @if($isPickup) Cash received and order completed.
                        @else Both payments confirmed. This order is archived. @endif
                    </div>
                </div>
            </div>
            @endif

          {{-- ── CAKE & ORDER DETAILS (combined) ── --}}
            <div class="card anim-in anim-delay-3">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>Cake &amp; Order Details</h3></div>
                {!! $specsHtml !!}
                <div class="details-foot">
                    <div class="info-row">
                        <span class="i-key">Fulfillment</span>
                        <span class="i-val accent">{!! $order->cakeRequest->fulfillment_label ?? ($isPickup ? 'Pickup' : 'Delivery') !!}</span>
                    </div>
                    <div class="info-row">
                        <span class="i-key">Budget</span>
                        <span class="i-val">₱{{ number_format($order->cakeRequest->budget_min, 0) }} — ₱{{ number_format($order->cakeRequest->budget_max, 0) }}</span>
                    </div>
             <div class="info-row">
    <span class="i-key">{{ $isPickup ? 'Date' : 'Delivery Date' }}</span>
    <span class="i-val accent">
        {{ $order->cakeRequest->delivery_date->format('M d, Y') }}
        @if($order->cakeRequest->needed_time)
            <small>
                 <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ \Carbon\Carbon::parse($order->cakeRequest->needed_time)->format('g:i A') }}
            </small>
        @endif
    </span>
</div>
                    @if(!empty($config['total']))
                    <div class="info-row">
                        <span class="i-key">Est. Price</span>
                        <span class="i-val accent">₱{{ number_format($config['total'], 0) }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="i-key">Submitted</span>
                        <span class="i-val">{{ $order->cakeRequest->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($order->cakeRequest->custom_message)
                    <div class="info-row stack">
                        <span class="i-key">Message on Cake</span>
                        <span class="i-text italic">"{{ $order->cakeRequest->custom_message }}"</span>
                    </div>
                    @endif
                    @if($order->cakeRequest->special_instructions)
                    <div class="info-row stack">
                        <span class="i-key">Special Instructions</span>
                        <span class="i-text">{{ $order->cakeRequest->special_instructions }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── DELIVERY LOCATION MAP (Baker Side) ── --}}
                      @if(!$isPickup && $order->cakeRequest->delivery_lat && $order->cakeRequest->delivery_lng)
                @php
                $bakerProfileForMap = \App\Models\Baker::where('user_id', $order->baker_id)->first();
                $bakerLat = $bakerProfileForMap->latitude ?? null;
                $bakerLng = $bakerProfileForMap->longitude ?? null;
            @endphp
            <div class="card anim-in anim-delay-4">
                <div class="card-header">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Location</h3>
                </div>
                <div id="baker-delivery-map" class="map-frame"></div>
                @if($bakerLat && $bakerLng)
                <div class="map-foot">
                    <div class="dist">
                        <span id="baker-distance-label">Calculating distance…</span>
                    </div>
                                        <a href="https://www.google.com/maps/dir/?api=1&origin={{ $bakerLat }},{{ $bakerLng }}&destination={{ $order->cakeRequest->delivery_lat }},{{ $order->cakeRequest->delivery_lng }}&travelmode=two-wheeler"
                       target="_blank" rel="noopener" class="btn-secondary" style="white-space:nowrap;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                        Get Directions
                    </a>
                </div>
                @endif
            </div>
            @endif

                    <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Activity</h3></div>
                <ul class="timeline-log">
                    <li>
                        <div class="log-dot"></div>
                        <div>
                            <div class="log-event">Order created</div>
                            <div class="log-time">{{ $order->created_at->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @if($payment)
                    <li>
                        <div class="log-dot"></div>
                        <div>
                            <div class="log-event {{ $paymentIsRejected ? 'red' : '' }}">
                                ₱ Full payment {{ $paymentIsPaid ? 'confirmed' : ($paymentIsRejected ? 'rejected' : 'proof submitted') }}
                            </div>
                            <div class="log-time">{{ ($payment->confirmed_at ?? $payment->rejected_at ?? $payment->paid_at)?->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @endif
                    @if($order->completed_at)
                    <li>
                        <div class="log-dot"></div>
                        <div>
                            <div class="log-event gold"> Order {{ $isPickup ? 'collected & completed' : 'completed' }}</div>
                            <div class="log-time">{{ $order->completed_at->format('M d, Y · g:i A') }}</div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>

            @include('partials.order-chat-bubble', ['order' => $order])

        </div>{{-- /left column --}}

        {{-- ════════════════ RIGHT SIDEBAR ════════════════ --}}
        <div class="order-sidebar-col">
            <div class="id-card anim-in anim-delay-2">
                <div class="id-label">Order</div>
              <div class="id-num">#{{ str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="id-date">{{ $order->created_at->format('M d, Y') }}</div>
                <hr class="id-divider">
                <div class="id-sub">Status</div>
                <div class="id-val gold">{{ str_replace('_', ' ', $order->status) }}</div>
                @if($isPickup)
                <hr class="id-divider">
                <div class="id-sub">Type</div>
                <div class="id-val gold"> Pickup Order</div>
                @endif
                <hr class="id-divider">
                <div class="id-sub">Agreed Price</div>
              <div class="id-val price">₱{{ number_format($order->agreed_price, 0) }}</div>
    
            </div>

     {{-- ── PAYMENT STATUS (ESCROW) ── --}}
            @if(!in_array($order->status, ['ACCEPTED','CANCELLED']))
            <div class="pay-card anim-in anim-delay-3">
          <h3>Payment Status</h3>
                <div class="pay-secure">
                                      <svg class="ic" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Payments are held securely by BakeSphere until you complete the order.
                </div>

                <div class="pay-line">
                    <div>
                        <div class="k">Full Payment</div>
                        <div class="amt">₱{{ number_format($order->agreed_price, 2) }}</div>
                    </div>
                    <div>
                        @if($paymentEscrow === 'held')
                                <span class="pill escrow"><svg class="ic" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>In Escrow</span>
                        @elseif($paymentEscrow === 'released')
                        <span class="pill released"><svg class="ic" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Released</span>
                        @elseif($payment && $payment->status === 'pending')
                        <span class="pill verifying"><svg class="ic" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.17a2 2 0 0 0-.59-1.42L12 12l-4.41 4.41A2 2 0 0 0 7 17.83V22"/><path d="M7 2v4.17a2 2 0 0 0 .59 1.42L12 12l4.41-4.41A2 2 0 0 0 17 6.17V2"/></svg>Verifying</span>
                        @elseif($payment && $payment->status === 'rejected')
                        <span class="pill rejected"><svg class="ic" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Rejected</span>
                        @else
                        <span class="pill awaiting"><svg class="ic" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Awaiting</span>
                        @endif
                    </div>
                </div>

                @if($order->baker_payout)
                <div class="pay-payout">
                    <div>Your payout (after 5% fee)</div>
                    <b>₱{{ number_format($order->baker_payout, 2) }}</b>
                </div>
                @endif
  @if(in_array($order->status, ['DELIVERED','COMPLETED']))
                <div class="pay-released">
                     Funds released! <a href="{{ route('baker.wallet.index') }}">View wallet <svg class="ic" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg></a>
                </div>
                @endif
            </div>
            @endif

                      @if($order->cakeRequest->cake_preview_image)
            <div class="card anim-in anim-delay-4">
                <div class="card-header">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>Cake Design Preview</h3>
                    @if(!empty($config['draft_config']))
                    <button type="button" onclick="openBaker3DPreview()" onmouseenter="window._warmBaker3D && window._warmBaker3D()" class="btn-secondary" style="white-space:nowrap; width:100%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.85.99 6.57 2.61"/><polyline points="21 3 21 8 16 8"/></svg>
                        Rotate &amp; Zoom (3D)
                    </button>
                    @endif
                </div>
                <div class="preview-img-wrap">
                    <img src="{{ asset('storage/' . $order->cakeRequest->cake_preview_image) }}"
                         alt="3D Cake Preview">
                </div>
                <div class="card-foot">
                    @if(!empty($config['draft_config']))
                        Flat snapshot from request time — tap "Rotate &amp; Zoom" above to inspect every side in 3D.
                    @else
                        3D preview captured at time of request
                    @endif
                </div>
            </div>

            {{-- ── 3D ROTATE/ZOOM MODAL (baker-only, read-only viewer) ── --}}
            @if(!empty($config['draft_config']))
            <div id="baker3DModal" class="baker3d-backdrop" role="dialog" aria-modal="true">
                <div class="baker3d-panel">
                    <div class="b3d-head">
                        <strong>Cake 3D Preview — Order #{{ str_pad($order->cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</strong>
                        <button type="button" class="b3d-close" onclick="closeBaker3DPreview()" aria-label="Close 3D preview">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    <div class="b3d-body">
                        <iframe id="baker3DIframe"></iframe>
                        <div id="baker3DLoading" class="b3d-loading">
                            <svg id="baker3DLoadingIcon" class="b3d-icon" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#B89452" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 15c1.2 1 2.4 1 3.6 0 1.2-1 2.4-1 3.6 0 1.2 1 2.4 1 3.6 0 1.2-1 2.4-1 3.6 0V20a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-5Z"/>
                                <path d="M5 15v-3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v3"/>
                                <path d="M12 10V6"/>
                                <path d="M12 6c-1 0-1.6-.7-1.6-1.5S11 3 12 2c1 1 1.6 1.7 1.6 2.5S13 6 12 6Z"/>
                            </svg>
                            <div style="display:flex;flex-direction:column;align-items:center;gap:0.3rem;">
                                <span style="display:inline-flex;align-items:center;gap:1px;">Loading 3D preview<span style="animation:baker3d-dot 1.4s infinite;">.</span><span style="animation:baker3d-dot 1.4s infinite;animation-delay:0.2s;">.</span><span style="animation:baker3d-dot 1.4s infinite;animation-delay:0.4s;">.</span></span>
                                <span id="baker3DLoadingPct" class="pct">0%</span>
                            </div>
                        </div>
                    </div>
                    <div class="b3d-foot">
                        Drag to rotate · Scroll or pinch to zoom — this is the exact cake the customer designed.
                    </div>
                </div>
            </div>
            @endif
            @endif

            @if($order->cakeRequest->reference_image)
            <div class="card anim-in anim-delay-5">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Reference</h3></div>
                <img src="{{ asset('storage/'.$order->cakeRequest->reference_image) }}" alt="Reference" class="ref-img">
            </div>
            @endif
        </div>

    </div>{{-- /order-page-grid --}}
</div>{{-- /order-wrap --}}

<div class="confirm-modal-backdrop" id="modal-mark-ready" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div>
            <div class="confirm-modal-title">Mark as Ready?</div>
            <div class="confirm-modal-subtitle">Upload your finished cake photo to notify the customer</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Customer</span>
                    <span class="confirm-modal-detail-val">{{ $order->cakeRequest->user->first_name }} {{ $order->cakeRequest->user->last_name }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Date</span>
                    <span class="confirm-modal-detail-val">{{ $order->cakeRequest->delivery_date->format('M d, Y') }}</span>
                </div>
            </div>

            <div style="margin-bottom:1rem;">
                <div class="dz-label">
                    <svg class="ic" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>Final Cake Photo <span class="req">*</span>
                </div>
                <div id="cake-photo-dropzone" class="dropzone"
                    onclick="document.getElementById('form-mark-ready-photo').click()">
                    <div id="cake-photo-placeholder">
                        <div class="dz-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg></div>
                        <div class="dz-title">Click to upload cake photo</div>
                        <div class="dz-sub">JPG, PNG · max 5MB · Required</div>
                    </div>
                    <div id="cake-photo-preview-wrap" style="display:none;">
                        <img id="cake-photo-preview" class="dz-preview" src="" alt="Cake preview">
                        <div id="cake-photo-filename" class="dz-file"></div>
                        <div class="dz-ok"><svg class="ic" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>Ready to submit</div>
                    </div>
                </div>
                <div id="cake-photo-error" class="dz-error">
                    <svg class="ic" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>Please upload a photo of the finished cake before continuing.
                </div>
            </div>

            <p class="confirm-modal-note">This will move to <strong>Ready for {{ $isPickup ? 'Pickup' : 'Delivery' }}</strong> and notify the customer with your cake photo.</p>
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-mark-ready')">Cancel</button>
            <button class="confirm-modal-btn-ok" onclick="submitMarkReadyWithPhoto(this)">
                <span class="btn-spinner"></span><span class="btn-text">Mark as Ready</span>
            </button>
        </div>
    </div>
</div>

<div class="confirm-modal-backdrop" id="modal-mark-delivered" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></div>
            <div class="confirm-modal-title">Mark as Delivered?</div>
            <div class="confirm-modal-subtitle">This notifies the customer to expect their cake</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Customer</span>
                    <span class="confirm-modal-detail-val">{{ $order->cakeRequest->user->first_name }} {{ $order->cakeRequest->user->last_name }}</span>
                </div>
            </div>
            <p class="confirm-modal-note">Only confirm this once the cake has actually left for delivery. Your payment releases once the customer confirms they received it.</p>
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-mark-delivered')">Cancel</button>
            <button class="confirm-modal-btn-ok" onclick="submitModal('modal-mark-delivered','form-mark-delivered',this)">
                <span class="btn-spinner"></span><span class="btn-text">Mark as Delivered</span>
            </button>
        </div>
    </div>
</div>

<div class="confirm-modal-backdrop" id="modal-request-final" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg></div>
            <div class="confirm-modal-title">{{ $isPickup ? 'Notify — Ready for Pickup?' : 'Request Final Payment?' }}</div>
            <div class="confirm-modal-subtitle">{{ $isPickup ? 'Customer will come to collect and pay cash' : 'Prompt the customer to pay the remaining balance' }}</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">{{ $isPickup ? 'Cash on Pickup (50%)' : 'Final Amount (50%)' }}</span>
                    <span class="confirm-modal-detail-val gold">₱{{ number_format($finalAmount, 2) }}</span>
                </div>
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Total Order</span>
                    <span class="confirm-modal-detail-val">₱{{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>
    

            <p class="confirm-modal-note">
                @if($isPickup)
                    The customer will be notified to come to your location and bring <strong>₱{{ number_format($finalAmount, 2) }} cash</strong>.
                @else
                    The customer will be prompted to pay the remaining 50% after seeing your finished cake photo.
                @endif
            </p>
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-request-final')">Cancel</button>
         <button class="confirm-modal-btn-ok" id="btn-request-final"
                onclick="submitModal('modal-request-final','form-request-final',this)">
                <span class="btn-spinner"></span><span class="btn-text"> Notify Customer</span>
            </button>
        </div>
    </div>
</div>

<div class="confirm-modal-backdrop" id="modal-confirm-final" role="dialog" aria-modal="true">
    <div class="confirm-modal">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        <div class="confirm-modal-title">{{ $isPickup ? 'Confirm Pickup?' : 'Confirm Delivered?' }}</div>
<div class="confirm-modal-subtitle">{{ $isPickup ? 'Confirm the customer collected their cake' : 'Confirm the cake has been delivered' }}</div>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-modal-detail">
                <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Order</span>
                    <span class="confirm-modal-detail-val">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                      <div class="confirm-modal-detail-row">
                    <span class="confirm-modal-detail-key">Total Paid (in full)</span>
                    <span class="confirm-modal-detail-val big">₱{{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>
            @if($isPickup)
            <p class="confirm-modal-note boxed">
                 This confirms the customer collected the cake in person. Payment was already made in full online — no cash is due.
            </p>
            @else
            <p class="confirm-modal-note">This confirms the cake has been delivered. Your payout releases automatically once the customer confirms receipt.</p>
            @endif
        </div>
        <div class="confirm-modal-footer">
            <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-confirm-final')">Cancel</button>
            <button class="confirm-modal-btn-ok" onclick="submitModal('modal-confirm-final', 'form-confirm-final', this)">
                <span class="btn-spinner"></span><span class="btn-text">{{ $isPickup ? 'Yes, Complete Order' : 'Complete Order' }}</span>
            </button>
        </div>
    </div>
</div>

{{-- ══════════════ REJECT PAYMENT MODAL ══════════════ --}}
<div class="reject-modal-backdrop" id="rejectPaymentModal" role="dialog" aria-modal="true">
    <div class="reject-modal">
        <div class="reject-modal-header">
            <div class="reject-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
            <div class="reject-modal-title">Reject Payment Proof?</div>
            <div class="reject-modal-sub" id="rejectModalSub">Select a reason for the rejection</div>
        </div>
        <div class="reject-modal-body">
                  <div class="reject-warning-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                <div>The customer will be <strong>notified immediately</strong> and asked to re-upload.
                A <strong>second rejection</strong> will <strong>automatically cancel</strong> the order.</div>
            </div>
            <div class="reject-reasons-label">Reason for Rejection *</div>
            <div class="reject-reason-list" id="rejectReasonList">
                @foreach($rejectionReasons as $key => $label)
                <div class="reject-reason-item" data-value="{{ $key }}" onclick="selectRejectReason(this)">
                    <div class="reject-reason-radio"></div>
                    {{ $label }}
                </div>
                @endforeach
            </div>
            <div class="reject-reasons-label">Additional Note <span style="opacity:0.5;">(optional)</span></div>
            <textarea class="reject-note-area" id="rejectNoteInput"
                placeholder="e.g. The GCash reference number could not be verified…"></textarea>
        </div>
        <div class="reject-modal-footer">
            <button class="reject-modal-cancel" onclick="closeRejectModal()">Cancel</button>
            <button class="reject-modal-submit" id="rejectSubmitBtn" disabled onclick="submitRejectModal()">
                <span id="rejectBtnSpinner" class="reject-spinner"></span>
                               <span id="rejectBtnLabel" style="display:inline-flex;align-items:center;gap:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject Proof</span>
            </button>
        </div>
    </div>
</div>

<form id="rejectPaymentForm" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="payment_type"     id="rejectFormPaymentType">
    <input type="hidden" name="rejection_reason" id="rejectFormReason">
    <input type="hidden" name="rejection_note"   id="rejectFormNote">
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('form-mark-ready-photo');
    if (!photoInput) return;
    photoInput.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        const file = this.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('cake-photo-placeholder').style.display = 'none';
            document.getElementById('cake-photo-preview-wrap').style.display = 'block';
            document.getElementById('cake-photo-preview').src = e.target.result;
            document.getElementById('cake-photo-filename').textContent = file.name;
            document.getElementById('cake-photo-dropzone').style.borderColor = 'var(--champagne-gold)';
            document.getElementById('cake-photo-dropzone').style.borderStyle = 'solid';
            document.getElementById('cake-photo-dropzone').style.background = 'var(--cream)';
            document.getElementById('cake-photo-error').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
});

function submitMarkReadyWithPhoto(btn) {
    const photoInput = document.getElementById('form-mark-ready-photo');
    if (!photoInput || !photoInput.files || !photoInput.files[0]) {
        document.getElementById('cake-photo-error').style.display = 'flex';
        document.getElementById('cake-photo-dropzone').style.borderColor = 'var(--deep-burgundy)';
        document.getElementById('cake-photo-dropzone').style.borderStyle = 'solid';
        return;
    }
    btn.disabled = true;
    btn.classList.add('is-loading');
    document.getElementById('form-mark-ready').submit();
}
function toggleProof(wrapperId) {
    const wrap = document.getElementById(wrapperId);
    const btnId = wrapperId === 'down-proof-wrap' ? 'down-proof-btn' : 'final-proof-btn';
    const btn = document.getElementById(btnId);
    const isHidden = wrap.style.display === 'none';
    wrap.style.display = isHidden ? 'block' : 'none';
    btn.textContent = isHidden ? 'Hide' : 'Show';
}
function openConfirmModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeConfirmModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
}
function submitModal(modalId, formId, btn) {
    const form = document.getElementById(formId);
    if (!form) return;
    btn.disabled = true;
    btn.classList.add('is-loading');
    form.submit();
}
document.querySelectorAll('.confirm-modal-backdrop').forEach(b => {
    b.addEventListener('click', function(e) { if (e.target === this) closeConfirmModal(this.id); });
});

let _selectedRejectReason = null;
function openRejectModal(paymentType, paymentTypeLabel, orderId) {
    document.getElementById('rejectPaymentForm').action = '/baker/orders/' + orderId + '/reject-payment';
    document.getElementById('rejectFormPaymentType').value = paymentType;
    document.getElementById('rejectModalSub').textContent  = 'Rejecting: ' + paymentTypeLabel + ' proof';
    _selectedRejectReason = null;
    document.querySelectorAll('.reject-reason-item').forEach(el => el.classList.remove('selected'));
    document.getElementById('rejectNoteInput').value   = '';
    document.getElementById('rejectSubmitBtn').disabled = true;
    document.getElementById('rejectPaymentModal').classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeRejectModal() {
    document.getElementById('rejectPaymentModal').classList.remove('is-open');
    document.body.style.overflow = '';
}
function selectRejectReason(el) {
    document.querySelectorAll('.reject-reason-item').forEach(e => e.classList.remove('selected'));
    el.classList.add('selected');
    _selectedRejectReason = el.dataset.value;
    document.getElementById('rejectSubmitBtn').disabled = false;
}
function submitRejectModal() {
    if (!_selectedRejectReason) return;
    document.getElementById('rejectFormReason').value = _selectedRejectReason;
    document.getElementById('rejectFormNote').value   = document.getElementById('rejectNoteInput').value;
    const btn = document.getElementById('rejectSubmitBtn');
    btn.disabled = true;
    document.getElementById('rejectBtnSpinner').style.display = 'block';
    document.getElementById('rejectBtnLabel').style.display   = 'none';
    document.getElementById('rejectPaymentForm').submit();
}
document.getElementById('rejectPaymentModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key !== 'Escape') return;
    document.querySelectorAll('.confirm-modal-backdrop.is-open').forEach(m => closeConfirmModal(m.id));
    if (document.getElementById('rejectPaymentModal').classList.contains('is-open')) closeRejectModal();
});
</script>

@if(!empty($config['draft_config']))
<script>
const _baker3DConfig = @json($config['draft_config']);
const _baker3DUrl = "{{ route('baker.cake-preview') }}?view_request=1&allow_zoom=1";

// Move the modal to <body> so it always centers against the real viewport,
// even if a parent wrapper has a CSS transform (which would otherwise become
// the containing block for this fixed-position modal instead of the viewport).
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('baker3DModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
});

let _baker3DMessageBound = false;
let _baker3DLoaded  = false; // true once the iframe has actually applied the config
let _baker3DWarming = false;

let _baker3DRealPct   = 0;   // highest percent actually reported by the iframe
let _baker3DShownPct  = 0;   // what's currently on screen
let _baker3DTickTimer = null;

function _setBaker3DPct(p){
    const pctEl = document.getElementById('baker3DLoadingPct');
    if(pctEl) pctEl.textContent = Math.round(p) + '%';
}
function _startBaker3DTicker(){
    if(_baker3DTickTimer) return;
    _baker3DTickTimer = setInterval(function(){
        if(_baker3DShownPct < _baker3DRealPct){
            _baker3DShownPct = Math.min(_baker3DRealPct, _baker3DShownPct + Math.max(1, (_baker3DRealPct - _baker3DShownPct) / 4));
            _setBaker3DPct(_baker3DShownPct);
        }
    }, 80);
}
function _stopBaker3DTicker(){
    if(_baker3DTickTimer){ clearInterval(_baker3DTickTimer); _baker3DTickTimer = null; }
}

function _bindBaker3DMessages(){
    if(_baker3DMessageBound) return;
    _baker3DMessageBound = true;
    const iframe = document.getElementById('baker3DIframe');
    window.addEventListener('message', function(e){
        if(!e.data || !e.data.type) return;
        if(e.data.type === 'bakesphere-tracker-ready'){
            iframe.contentWindow.postMessage({
                type: 'bakesphere-tracker-config',
                config: _baker3DConfig
            }, '*');
        }
        if(e.data.type === 'bakesphere-tracker-progress' && typeof e.data.percent === 'number'){
            _baker3DRealPct = Math.max(0, Math.min(100, e.data.percent));
            _startBaker3DTicker();
        }
        if(e.data.type === 'bakesphere-tracker-loaded' || e.data.type === 'bakesphere-draft-3d-ready'){
            _baker3DLoaded  = true;
            _baker3DRealPct = 100;
            _setBaker3DPct(100);
            _stopBaker3DTicker();
            const loading = document.getElementById('baker3DLoading');
            if(loading) loading.style.display = 'none';
        }
    });
}
// Starts loading the cake into the (still-hidden) iframe ahead of time, so by
// the time the baker actually opens the modal it's often already rendered.
// Safe to call more than once — no-ops once warming/loaded.
window._warmBaker3D = function(){
    if(_baker3DWarming || _baker3DLoaded) return;
    _baker3DWarming = true;
    _baker3DRealPct  = 0;
    _baker3DShownPct = 0;
    _setBaker3DPct(0); // real progress messages will take over from here
    const iframe = document.getElementById('baker3DIframe');
    if(!iframe) return;
    _bindBaker3DMessages();
    iframe.src = _baker3DUrl;
};
// Fallback: if the baker never hovers the button first, still warm it once
// the page has gone idle, well before they'd realistically click it.
(window.requestIdleCallback || function(fn){ setTimeout(fn, 1200); })(window._warmBaker3D);

function openBaker3DPreview(){
    const modal = document.getElementById('baker3DModal');
    const loading = document.getElementById('baker3DLoading');
    if(!modal) return;

    if(_baker3DLoaded){
        loading.style.display = 'none'; // already warmed — show instantly
    } else {
        loading.style.display = 'flex';
        window._warmBaker3D();
    }
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeBaker3DPreview(){
    const modal = document.getElementById('baker3DModal');
    if(modal) modal.classList.remove('is-open');
    document.body.style.overflow = '';
    // Deliberately NOT resetting the iframe src here — keeping the model
    // warm is what makes reopening instant instead of a full reload.
}
document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') closeBaker3DPreview();
});
</script>
@endif

@php $terminalBakerStates = ['COMPLETED','CANCELLED']; @endphp
@if(!in_array($order->status, $terminalBakerStates))
<script>
(function () {
    'use strict';

    var POLL_URL    = @json(route('baker.orders.state-poll', $order->id));
   var POLL_MS     = 3000;
    var lastFp      = null;
    var reloading   = false;

  function fp(d) {
    return [
        d.order_status,
        d.request_status,
        d.down_status,
        d.down_escrow,
        d.final_status,
        d.final_escrow,
        d.has_cake_photo ? '1' : '0',
        d.agreed_price ?? '',
        d.baker_payout ?? '',
    ].join('|');
}
    function ensureStyle() {
        if (document.getElementById('rt-style')) return;
        var s = document.createElement('style');
        s.id  = 'rt-style';
        s.textContent =
            '@keyframes rt-slidein{from{opacity:0;transform:translateX(-50%) translateY(-10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}' +
            '@keyframes rt-pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.65)}}';
        document.head.appendChild(s);
    }

    function triggerReload(msg) {
        if (reloading) return;
        reloading = true;
        ensureStyle();

        var el = document.createElement('div');
        el.style.cssText = [
            'position:fixed','top:1.1rem','left:50%',
            'transform:translateX(-50%)','z-index:99999',
            'background:#24150F','color:#F7F2E9',
            'border:1px solid #B89452','border-radius:2px',
            'padding:0.65rem 1.2rem',
            'font-size:0.72rem','font-weight:700','letter-spacing:0.08em','text-transform:uppercase',
            'display:flex','align-items:center','gap:0.6rem',
            'box-shadow:0 4px 24px rgba(0,0,0,0.28)',
            'white-space:nowrap',
            'animation:rt-slidein 0.25s ease',
        ].join(';');
        el.innerHTML =
            '<span style="width:8px;height:8px;background:#B89452;' +
            'display:inline-block;animation:rt-pulse 1s ease-in-out infinite;"></span> ' +
            (msg || 'Order updated — reloading…');
        document.body.appendChild(el);
        setTimeout(function () { window.location.reload(); }, 950);
    }

  var STATUS_MSGS = {
    'WAITING_FOR_PAYMENT'    : 'Customer is ready to pay — reloading…',
    'PREPARING'              : 'Payment confirmed — start baking!',
    'READY'                  : 'Cake marked ready — reloading…',
    'OUT_FOR_DELIVERY'       : 'Customer approved — time to deliver!',
    'DELIVERED'              : 'Marked as delivered — reloading…',
    'WAITING_FINAL_PAYMENT'  : 'Final payment received — reloading…',
    'COMPLETED'              : 'Order completed — reloading…',
    'CANCELLED'              : 'Order was cancelled.',
    'ACCEPTED'               : 'Order updated — reloading…',
};

    setInterval(function () {
        fetch(POLL_URL, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            },
        })
        .then(function (r) { return r.ok ? r.json() : null; })
       .then(function (data) {
            if (!data) return;
            var current = fp(data);
            if (lastFp === null) { lastFp = current; return; }
            if (current !== lastFp) {
                var msg = STATUS_MSGS[data.order_status]
                       || STATUS_MSGS[data.request_status]
                       || 'Order updated — reloading…';
                triggerReload(msg);
            }
        })
        .catch(function () {});
    }, POLL_MS);
})();
</script>
@endif
@if(!$isPickup && $order->cakeRequest->delivery_lat && $order->cakeRequest->delivery_lng)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const custLat = {{ $order->cakeRequest->delivery_lat }};
    const custLng = {{ $order->cakeRequest->delivery_lng }};
    @if($bakerLat && $bakerLng)
    const bakerLat = {{ $bakerLat }};
    const bakerLng = {{ $bakerLng }};
    @endif

    const map = L.map('baker-delivery-map', {
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false,
    }).setView([custLat, custLng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    const pinSvg = (color) => `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="${color}" stroke="white" stroke-width="1.5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3" fill="white"/></svg>`;

    const custIcon = L.divIcon({ className: '', html: pinSvg('#B89452'), iconSize: [20, 26], iconAnchor: [10, 24] });
    const custMarker = L.marker([custLat, custLng], { icon: custIcon })
        .addTo(map)
        .bindPopup('<strong>{{ addslashes($order->cakeRequest->user->first_name) }}\'s Delivery Address</strong>');

    @if($bakerLat && $bakerLng)
    const bakerIcon = L.divIcon({ className: '', html: pinSvg('#24150F'), iconSize: [20, 26], iconAnchor: [10, 24] });
    const bakerMarker = L.marker([bakerLat, bakerLng], { icon: bakerIcon })
        .addTo(map)
        .bindPopup('<strong>Your Shop Location</strong>');

    map.fitBounds(L.latLngBounds([[bakerLat, bakerLng], [custLat, custLng]]), { padding: [30, 30] });

    const distLabel = document.getElementById('baker-distance-label');

    function drawStraightFallback() {
        L.polyline([[bakerLat, bakerLng], [custLat, custLng]], {
            color: '#B89452', weight: 3, dashArray: '6, 8', opacity: 0.8,
        }).addTo(map);

        const toRad = (d) => d * Math.PI / 180;
        const R = 6371;
        const dLat = toRad(custLat - bakerLat);
        const dLng = toRad(custLng - bakerLng);
        const a = Math.sin(dLat / 2) ** 2 + Math.cos(toRad(bakerLat)) * Math.cos(toRad(custLat)) * Math.sin(dLng / 2) ** 2;
        const distanceKm = R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        if (distLabel) distLabel.textContent = '~' + distanceKm.toFixed(1) + ' km from your shop to the customer';
    }

    if (distLabel) distLabel.textContent = 'Calculating route…';

      const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${bakerLng},${bakerLat};${custLng},${custLat}?overview=full&geometries=geojson&alternatives=false&continue_straight=false`;

    fetch(osrmUrl)
        .then(r => r.ok ? r.json() : Promise.reject())
        .then(data => {
            const route = data.routes && data.routes[0];
            if (!route || !route.geometry || !route.geometry.coordinates || !route.geometry.coordinates.length) {
                drawStraightFallback();
                return;
            }
                    const routeLatLngs = route.geometry.coordinates.map(pt => [pt[1], pt[0]]);
            L.polyline(routeLatLngs, {
                color: '#24150F', weight: 4, opacity: 0.9,
            }).addTo(map);

            map.fitBounds(L.polyline(routeLatLngs).getBounds(), { padding: [30, 30] });

            const distanceKm = route.distance / 1000;
            if (distLabel) distLabel.textContent = '~' + distanceKm.toFixed(1) + ' km driving route to the customer';
        })
        .catch(() => {
            drawStraightFallback();
        });
    @else
    custMarker.openPopup();
    @endif
});
</script>
@endif

@endpush

@endsection