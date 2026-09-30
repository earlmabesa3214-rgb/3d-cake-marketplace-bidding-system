@extends('layouts.admin')
@section('title', 'Transaction #' . str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<style>
/* =====================================================================
   BAKESPHERE · TRANSACTION CASE FILE
   Sections: 1 Tokens · 2 Base · 3 Hero · 4 Panels · 5 Parties
             6 Progress · 7 Payment ledger · 8 Specification · 9 Comms log
             10 Sidebar · 11 Motion · 12 Responsive
   ===================================================================== */

/* 1 · TOKENS */
:root {
    --bs-espresso:#24150F;
    --bs-choc:#3A241A;
    --bs-ivory:#F7F2E9;
    --bs-cream:#EFE6D7;
    --bs-caramel:#A96F42;
    --bs-gold:#B89452;
    --bs-gold-ink:#8A6A2C;
    --bs-gold-light:#D9BE84;
    --bs-burgundy:#54252C;
    --bs-taupe:#9A897A;
    --bs-muted:#75665A;
    --bs-beige:#D8C8B7;
    --bs-blush:#E8D3CA;
    --bs-white:#FFFFFF;
    --bs-sage:#4E6B5A;
    --bs-slate:#4F6474;
    --bs-radius:3px;
    --bs-shadow:0 1px 2px rgba(36,21,15,.06), 0 8px 24px -12px rgba(36,21,15,.18);
}

/* 2 · BASE */
.bs-case, .bs-case * { font-family:'Plus Jakarta Sans', sans-serif; box-sizing:border-box; }
.bs-case { color:var(--bs-espresso); }
.bs-ic { width:1em; height:1em; fill:none; stroke:currentColor; stroke-width:1.7; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }
.bs-eyebrow { font-size:.64rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; }
.bs-back { display:inline-flex; align-items:center; gap:.5rem; margin-bottom:1.25rem; font-size:.7rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--bs-muted); text-decoration:none; transition:color .2s; }
.bs-back:hover { color:var(--bs-gold-ink); }
.bs-back .bs-ic { transition:transform .2s; }
.bs-back:hover .bs-ic { transform:translateX(-3px); }
.bs-back:focus-visible { outline:2px solid var(--bs-gold); outline-offset:3px; }

.bs-status { display:inline-flex; align-items:center; gap:.45rem; padding:.36rem .8rem; border-radius:var(--bs-radius); border:1px solid; font-size:.64rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; white-space:nowrap; }
.bs-status::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; }
.bs-s-ACCEPTED, .bs-s-WAITING_FOR_PAYMENT, .bs-s-WAITING_FINAL_PAYMENT { color:#7A5A1E; background:rgba(184,148,82,.14); border-color:rgba(184,148,82,.55); }
.bs-s-PREPARING { color:var(--bs-slate); background:rgba(79,100,116,.1); border-color:rgba(79,100,116,.4); }
.bs-s-READY, .bs-s-DELIVERED, .bs-s-COMPLETED { color:var(--bs-sage); background:rgba(78,107,90,.11); border-color:rgba(78,107,90,.4); }
.bs-s-CANCELLED { color:var(--bs-burgundy); background:rgba(84,37,44,.08); border-color:rgba(84,37,44,.4); }
/* On the dark hero, badges need lighter tones */
.bs-hero .bs-status { color:var(--bs-gold-light); background:rgba(184,148,82,.14); border-color:rgba(184,148,82,.5); }
.bs-hero .bs-s-CANCELLED { color:#E8D3CA; background:rgba(232,211,202,.1); border-color:rgba(232,211,202,.45); }
.bs-hero .bs-s-READY, .bs-hero .bs-s-DELIVERED, .bs-hero .bs-s-COMPLETED { color:#B9D3C2; background:rgba(185,211,194,.1); border-color:rgba(185,211,194,.4); }
.bs-hero .bs-s-PREPARING { color:#BFD0DC; background:rgba(191,208,220,.1); border-color:rgba(191,208,220,.4); }

/* 3 · HERO */
.bs-hero { position:relative; overflow:hidden; display:grid; grid-template-columns:1fr auto; gap:2.5rem; align-items:end; margin-bottom:1.75rem; padding:2.5rem 2.5rem 2.25rem; color:var(--bs-ivory);
    background:linear-gradient(160deg, var(--bs-espresso) 0%, var(--bs-choc) 100%); border-radius:var(--bs-radius); box-shadow:var(--bs-shadow); }
.bs-hero::before { content:''; position:absolute; inset:0; pointer-events:none; background-image:repeating-linear-gradient(90deg, rgba(184,148,82,.06) 0 1px, transparent 1px 96px); }
.bs-hero::after { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg, var(--bs-gold), rgba(184,148,82,.15)); }
.bs-hero > * { position:relative; z-index:1; }
.bs-hero .bs-eyebrow { color:var(--bs-gold-light); margin-bottom:.9rem; }
.bs-hero-id { font-size:clamp(2rem, 4.5vw, 3.1rem); font-weight:800; letter-spacing:-.045em; line-height:1.05; margin:0 0 .75rem; color:var(--bs-ivory); font-variant-numeric:tabular-nums; }
.bs-hero-sub { font-size:.82rem; color:rgba(247,242,233,.62); margin:0 0 1.25rem; line-height:1.6; }
.bs-hero-price { text-align:right; padding-left:2.5rem; border-left:1px solid rgba(184,148,82,.4); }
.bs-hero-price .bs-eyebrow { margin-bottom:.6rem; }
.bs-hero-price-val { font-size:clamp(2.4rem, 5vw, 3.6rem); font-weight:800; letter-spacing:-.04em; line-height:1; color:var(--bs-gold-light); font-variant-numeric:tabular-nums; }

/* LAYOUT */
.bs-layout { display:grid; grid-template-columns:minmax(0, 1fr) 340px; gap:1.75rem; align-items:start; }

/* 4 · PANELS */
.bs-panel { background:var(--bs-white); border:1px solid var(--bs-beige); margin-bottom:1.75rem; overflow:hidden; box-shadow:var(--bs-shadow); }
.bs-panel:last-child { margin-bottom:0; }
.bs-panel-head { display:flex; align-items:center; gap:.7rem; padding:1rem 1.6rem; border-bottom:1px solid var(--bs-beige); border-left:3px solid var(--bs-gold); background:var(--bs-white); }
.bs-panel-head .bs-ic { font-size:1.05rem; color:var(--bs-gold-ink); }
.bs-panel-head h3 { margin:0; font-size:.98rem; font-weight:800; letter-spacing:-.02em; color:var(--bs-espresso); }
.bs-label { font-size:.62rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--bs-muted); }

/* 5 · PARTIES */
.bs-parties { display:grid; grid-template-columns:1fr auto 1fr; }
.bs-party { padding:1.6rem; min-width:0; }
.bs-party .bs-label { margin-bottom:1rem; display:block; }
.bs-party-body { display:flex; align-items:center; gap:1rem; }
.bs-avatar { width:56px; height:56px; border-radius:50%; background:var(--bs-caramel); color:var(--bs-white); display:flex; align-items:center; justify-content:center; font-size:1.15rem; font-weight:800; overflow:hidden; flex-shrink:0; box-shadow:0 0 0 3px var(--bs-white), 0 0 0 4px var(--bs-beige); }
.bs-avatar.is-baker { background:var(--bs-espresso); }
.bs-avatar img { width:100%; height:100%; object-fit:cover; display:block; }
.bs-party-name { font-size:1rem; font-weight:800; letter-spacing:-.02em; line-height:1.25; }
.bs-party-email { font-size:.76rem; color:var(--bs-muted); margin-top:.25rem; overflow-wrap:anywhere; }
.bs-bridge { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.5rem; padding:1rem 0; }
.bs-bridge::before, .bs-bridge::after { content:''; flex:1; width:1px; background:var(--bs-beige); }
.bs-bridge-icon { width:34px; height:34px; border:1px solid var(--bs-gold); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--bs-gold-ink); background:var(--bs-ivory); }

/* 6 · PROGRESS */
.bs-progress { padding:1.75rem 1.6rem 1.5rem; overflow-x:auto; }
.bs-steps { display:flex; min-width:600px; }
.bs-step { flex:1; display:flex; flex-direction:column; align-items:center; min-width:0; }
.bs-step-row { display:flex; align-items:center; width:100%; }
.bs-conn { flex:1; height:2px; background:var(--bs-beige); position:relative; overflow:hidden; }
.bs-conn::after { content:''; position:absolute; inset:0; background:var(--bs-gold); transform:scaleX(0); transform-origin:left; }
.bs-conn.on::after { transform:scaleX(1); animation:bsLine .7s .3s ease both; }
.bs-dot { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.68rem; font-weight:800; letter-spacing:.02em; flex-shrink:0; font-variant-numeric:tabular-nums; }
.bs-dot.done { background:var(--bs-gold); color:var(--bs-espresso); }
.bs-dot.done .bs-ic { font-size:.95rem; stroke-width:2.2; }
.bs-dot.active { background:var(--bs-espresso); color:var(--bs-gold-light); box-shadow:0 0 0 3px var(--bs-white), 0 0 0 4px var(--bs-gold); }
.bs-dot.pending { background:var(--bs-cream); border:1px solid var(--bs-beige); color:var(--bs-muted); }
.bs-step-icon { margin-top:.9rem; font-size:1.05rem; color:var(--bs-taupe); }
.bs-step-icon.is-current { color:var(--bs-gold-ink); }
.bs-step-icon.is-done { color:var(--bs-espresso); }
.bs-step-label { margin-top:.35rem; font-size:.58rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; text-align:center; color:var(--bs-muted); padding:0 .2rem; }
.bs-step-label.active { color:var(--bs-gold-ink); }

/* 7 · PAYMENT LEDGER */
.bs-pay-grid { display:grid; grid-template-columns:1fr 1fr; }
.bs-pay { padding:1.5rem 1.6rem 1.6rem; border-left:3px solid var(--bs-taupe); background:var(--bs-ivory); }
.bs-pay + .bs-pay { border-left-width:3px; }
.bs-pay.paid { border-left-color:var(--bs-sage); background:rgba(78,107,90,.07); }
.bs-pay.pending { border-left-color:var(--bs-gold); background:rgba(184,148,82,.1); }
.bs-pay.rejected { border-left-color:var(--bs-burgundy); background:rgba(84,37,44,.06); }
.bs-pay.none { border-left-color:var(--bs-beige); background:var(--bs-ivory); }
.bs-pay-amount { margin:.7rem 0 1rem; font-size:2rem; font-weight:800; letter-spacing:-.04em; line-height:1; font-variant-numeric:tabular-nums; }
.bs-pay-amount .bs-cur { font-size:1.05rem; color:var(--bs-gold-ink); margin-right:.15rem; font-weight:700; }
.bs-pay.none .bs-pay-amount { color:var(--bs-muted); }
.bs-pay-state { display:inline-flex; align-items:center; gap:.5rem; font-size:.72rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
.bs-pay-state .bs-ic { width:20px; height:20px; padding:4px; border-radius:50%; border:1px solid currentColor; }
.bs-pay.paid .bs-pay-state { color:var(--bs-sage); }
.bs-pay.pending .bs-pay-state { color:#7A5A1E; }
.bs-pay.rejected .bs-pay-state { color:var(--bs-burgundy); }
.bs-pay.none .bs-pay-state { color:var(--bs-muted); }
.bs-pay-proof { margin-top:1.1rem; padding-top:.9rem; border-top:1px solid rgba(154,137,122,.35); }
.bs-pay-proof a { display:inline-flex; align-items:center; gap:.45rem; font-size:.64rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--bs-espresso); text-decoration:none; border-bottom:1px solid var(--bs-gold); padding-bottom:.2rem; transition:color .2s, gap .2s; }
.bs-pay-proof a:hover { color:var(--bs-gold-ink); gap:.7rem; }
.bs-pay-proof a:focus-visible { outline:2px solid var(--bs-gold); outline-offset:3px; }

/* 8 · CAKE SPECIFICATION */
.bs-spec { display:grid; grid-template-columns:1fr 1fr; margin-bottom:-1px; }
.bs-spec-item { padding:1.1rem 1.6rem 1.2rem; border-bottom:1px solid var(--bs-beige); border-right:1px solid var(--bs-beige); }
.bs-spec-item:nth-child(even) { border-right:none; }
.bs-spec-item.wide { grid-column:1 / -1; border-right:none; background:var(--bs-ivory); }
.bs-spec-value { margin-top:.4rem; font-size:1.05rem; font-weight:800; letter-spacing:-.015em; line-height:1.35; }

/* 9 · COMMUNICATION LOG */
.bs-log { padding:1.25rem 1.6rem; display:flex; flex-direction:column; gap:1rem; max-height:320px; overflow-y:auto; }
.bs-entry { max-width:82%; padding:.8rem 1.05rem .9rem; }
.bs-entry.is-baker { align-self:flex-start; background:var(--bs-ivory); border-left:3px solid var(--bs-choc); }
.bs-entry.is-customer { align-self:flex-end; text-align:right; background:rgba(184,148,82,.11); border-right:3px solid var(--bs-gold); }
.bs-entry-head { display:flex; align-items:baseline; gap:.6rem; flex-wrap:wrap; margin-bottom:.4rem; }
.bs-entry.is-customer .bs-entry-head { justify-content:flex-end; }
.bs-entry-role { font-size:.58rem; font-weight:800; letter-spacing:.18em; text-transform:uppercase; color:var(--bs-choc); }
.bs-entry.is-customer .bs-entry-role { color:var(--bs-gold-ink); }
.bs-entry-meta { font-size:.68rem; color:var(--bs-muted); }
.bs-entry-text { font-size:.85rem; line-height:1.6; overflow-wrap:anywhere; }
.bs-empty { display:flex; flex-direction:column; align-items:center; gap:.6rem; padding:2.5rem 1rem; text-align:center; color:var(--bs-muted); font-size:.84rem; font-weight:500; }
.bs-empty .bs-ic { font-size:1.5rem; color:var(--bs-taupe); }

/* 10 · SIDEBAR */
.bs-row { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:.95rem 1.6rem; border-bottom:1px solid var(--bs-cream); }
.bs-row:last-child { border-bottom:none; }
.bs-row-val { font-size:.86rem; font-weight:600; text-align:right; }
.bs-row-val.is-id { font-size:1.4rem; font-weight:800; letter-spacing:-.03em; color:var(--bs-gold-ink); font-variant-numeric:tabular-nums; }
.bs-row-val.is-price { font-size:1.2rem; font-weight:800; letter-spacing:-.03em; font-variant-numeric:tabular-nums; }
.bs-row-val.is-date { color:var(--bs-gold-ink); font-weight:700; }
.bs-row.is-id { background:var(--bs-ivory); padding-top:1.2rem; padding-bottom:1.2rem; }
.bs-row.is-reason { flex-direction:column; align-items:flex-start; gap:.5rem; border-left:3px solid var(--bs-burgundy); background:rgba(84,37,44,.05); }
.bs-reason-text { font-size:.82rem; line-height:1.6; color:var(--bs-burgundy); }
.bs-timeline { list-style:none; margin:0; padding:1.4rem 1.6rem 1.2rem; }
.bs-timeline li { position:relative; display:flex; gap:.9rem; padding-bottom:1.35rem; }
.bs-timeline li:last-child { padding-bottom:.2rem; }
.bs-timeline li::before { content:''; position:absolute; left:4.5px; top:16px; bottom:-2px; width:1px; background:var(--bs-beige); }
.bs-timeline li:last-child::before { display:none; }
.bs-tl-dot { width:10px; height:10px; border-radius:50%; background:var(--bs-gold); flex-shrink:0; margin-top:.3rem; box-shadow:0 0 0 3px var(--bs-white); position:relative; z-index:1; }
.bs-tl-dot.is-sage { background:var(--bs-sage); }
.bs-tl-dot.is-burgundy { background:var(--bs-burgundy); }
.bs-tl-event { font-size:.84rem; font-weight:700; line-height:1.35; }
.bs-tl-time { font-size:.7rem; color:var(--bs-muted); margin-top:.2rem; }

/* 11 · MOTION */
@keyframes bsRise { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
@keyframes bsLine { from { transform:scaleX(0); } to { transform:scaleX(1); } }
.bs-hero { animation:bsRise .6s ease both; }
.bs-layout .bs-panel { animation:bsRise .55s ease both; }
.bs-layout > div:first-child .bs-panel:nth-child(1) { animation-delay:.08s; }
.bs-layout > div:first-child .bs-panel:nth-child(2) { animation-delay:.16s; }
.bs-layout > div:first-child .bs-panel:nth-child(3) { animation-delay:.24s; }
.bs-layout > div:first-child .bs-panel:nth-child(4) { animation-delay:.32s; }
.bs-layout > div:first-child .bs-panel:nth-child(5) { animation-delay:.4s; }
.bs-layout > div:last-child .bs-panel:nth-child(1) { animation-delay:.14s; }
.bs-layout > div:last-child .bs-panel:nth-child(2) { animation-delay:.26s; }

/* 12 · RESPONSIVE */
@media (max-width:1100px) {
    .bs-layout { grid-template-columns:minmax(0, 1fr); }
}
@media (max-width:760px) {
    .bs-hero { grid-template-columns:1fr; gap:1.5rem; padding:2rem 1.4rem 1.75rem; }
    .bs-hero-price { text-align:left; padding-left:0; padding-top:1.4rem; border-left:none; border-top:1px solid rgba(184,148,82,.4); }
    .bs-parties { grid-template-columns:1fr; }
    .bs-bridge { flex-direction:row; padding:0 1.6rem; }
    .bs-bridge::before, .bs-bridge::after { width:auto; height:1px; }
    .bs-pay-grid { grid-template-columns:1fr; }
    .bs-spec { grid-template-columns:1fr; }
    .bs-spec-item { border-right:none; }
    .bs-entry { max-width:94%; }
    .bs-panel-head, .bs-row { padding-left:1.2rem; padding-right:1.2rem; }
}
@media (prefers-reduced-motion:reduce) {
    .bs-case *, .bs-case *::before, .bs-case *::after { animation:none !important; transition:none !important; }
    .bs-conn.on::after { transform:scaleX(1); }
}
</style>
@endpush

@section('content')

{{-- Icon sprite --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="bs-i-back" viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6"/></symbol>
    <symbol id="bs-i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
    <symbol id="bs-i-check" viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></symbol>
    <symbol id="bs-i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></symbol>
    <symbol id="bs-i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></symbol>
    <symbol id="bs-i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 018 0v3"/></symbol>
    <symbol id="bs-i-users" viewBox="0 0 24 24"><circle cx="9" cy="8.5" r="3.2"/><path d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/><path d="M16 5.5a3 3 0 010 6M18 14c1.8.7 3 2.4 3 5"/></symbol>
    <symbol id="bs-i-swap" viewBox="0 0 24 24"><path d="M4 9h14M14 5l4 4-4 4M20 15H6M10 11l-4 4 4 4"/></symbol>
    <symbol id="bs-i-bars" viewBox="0 0 24 24"><path d="M5 20V11M12 20V5M19 20v-6"/></symbol>
    <symbol id="bs-i-card" viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="1.5"/><path d="M3 10h18M7 15h3"/></symbol>
    <symbol id="bs-i-bowl" viewBox="0 0 24 24"><path d="M4 11h16a8 8 0 01-16 0z"/><path d="M9 7l1.5-3M14 7l-1-3"/></symbol>
    <symbol id="bs-i-box" viewBox="0 0 24 24"><path d="M3.5 8L12 4l8.5 4v8L12 20l-8.5-4z"/><path d="M3.5 8L12 12l8.5-4M12 12v8"/></symbol>
    <symbol id="bs-i-coin" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M14.8 9.2c-.6-.8-1.6-1.2-2.8-1.2-1.6 0-2.8.8-2.8 2s1 1.7 2.8 2 2.8.8 2.8 2-1.2 2-2.8 2c-1.2 0-2.3-.4-2.9-1.2M12 6.5V8M12 16v1.5"/></symbol>
    <symbol id="bs-i-truck" viewBox="0 0 24 24"><path d="M2.5 7h11v9h-11zM13.5 10h4l3 3v3h-7"/><circle cx="7" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></symbol>
    <symbol id="bs-i-cake" viewBox="0 0 24 24"><path d="M4 20h16v-6a2 2 0 00-2-2H6a2 2 0 00-2 2z"/><path d="M4 16c2 1.5 4 1.5 6 0s4-1.5 6 0 3 1 4 0M12 12V8M12 5.5v.01"/></symbol>
    <symbol id="bs-i-chat" viewBox="0 0 24 24"><path d="M4 5h16v11H9l-5 4z"/></symbol>
    <symbol id="bs-i-file" viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4M9 12h6M9 16h6"/></symbol>
    <symbol id="bs-i-log" viewBox="0 0 24 24"><circle cx="6" cy="6" r="1.6"/><circle cx="6" cy="18" r="1.6"/><path d="M6 8v8M11 6h9M11 12h9M11 18h9"/></symbol>
</svg>

<div class="bs-case">

<a href="{{ route('admin.transactions.index') }}" class="bs-back">
    <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-back"/></svg> All Transactions
</a>

@php
    $config = is_array($bakerOrder->cakeRequest->cake_configuration)
        ? $bakerOrder->cakeRequest->cake_configuration
        : (json_decode($bakerOrder->cakeRequest->cake_configuration, true) ?? []);

    $payments = $bakerOrder->cakeRequest->payments ?? collect();
    $downpayment  = $payments->where('payment_type','downpayment')->first();
    $finalPayment = $payments->where('payment_type','final')->first();

    $statusSteps  = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED'];
    $stepLabels   = ['Accepted','Awaiting Down','Preparing','Ready','Awaiting Final','Delivered'];
    $stepIcons    = ['check','card','bowl','box','coin','truck'];
    $currentStep  = array_search($bakerOrder->status, $statusSteps);
    if ($currentStep === false) $currentStep = 0;

    $downStatus  = $downpayment  ? $downpayment->status  : 'none';
    $finalStatus = $finalPayment ? $finalPayment->status : 'none';
@endphp

{{-- HERO --}}
<header class="bs-hero">
    <div>
        <div class="bs-eyebrow">Transaction Case File</div>
        <h1 class="bs-hero-id">Transaction #{{ str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT) }}</h1>
        <p class="bs-hero-sub">
            Order #{{ str_pad($bakerOrder->cake_request_id, 4, '0', STR_PAD_LEFT) }} ·
            Created {{ $bakerOrder->created_at->format('M d, Y · g:i A') }}
        </p>
        <span class="bs-status bs-s-{{ $bakerOrder->status }}">
            {{ str_replace('_',' ', $bakerOrder->status) }}
        </span>
    </div>
    <div class="bs-hero-price">
        <div class="bs-eyebrow">Agreed Price</div>
        <div class="bs-hero-price-val">₱{{ number_format($bakerOrder->agreed_price, 0) }}</div>
    </div>
</header>

<div class="bs-layout">
    {{-- LEFT --}}
    <div>
        {{-- Parties --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-users"/></svg>
                <h3>People Involved</h3>
            </div>
            <div class="bs-parties">
                <div class="bs-party">
                    <span class="bs-label">Customer</span>
                    <div class="bs-party-body">
                        <div class="bs-avatar">
                            @if($bakerOrder->cakeRequest->user->profile_photo)
                                <img src="{{ asset('storage/'.$bakerOrder->cakeRequest->user->profile_photo) }}" alt="">
                            @else {{ strtoupper(substr($bakerOrder->cakeRequest->user->first_name,0,1)) }} @endif
                        </div>
                        <div>
                            <div class="bs-party-name">{{ $bakerOrder->cakeRequest->user->first_name }} {{ $bakerOrder->cakeRequest->user->last_name }}</div>
                            <div class="bs-party-email">{{ $bakerOrder->cakeRequest->user->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="bs-bridge" aria-hidden="true">
                    <span class="bs-bridge-icon"><svg class="bs-ic" viewBox="0 0 24 24"><use href="#bs-i-swap"/></svg></span>
                </div>
                <div class="bs-party">
                    <span class="bs-label">Baker</span>
                    <div class="bs-party-body">
                        <div class="bs-avatar is-baker">
                            @if($bakerOrder->baker->profile_photo)
                                <img src="{{ asset('storage/'.$bakerOrder->baker->profile_photo) }}" alt="">
                            @else {{ strtoupper(substr($bakerOrder->baker->first_name,0,1)) }} @endif
                        </div>
                        <div>
                            <div class="bs-party-name">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</div>
                            <div class="bs-party-email">{{ $bakerOrder->baker->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Baking Progress --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-bars"/></svg>
                <h3>Order Progress</h3>
            </div>
            <div class="bs-progress">
                <div class="bs-steps">
                    @foreach($statusSteps as $i => $step)
                    <div class="bs-step">
                        <div class="bs-step-row">
                            @if($i > 0)
                            <div class="bs-conn {{ $i <= $currentStep ? 'on' : '' }}"></div>
                            @else
                            <div style="flex:1;"></div>
                            @endif
                            <div class="bs-dot {{ $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : 'pending') }}">
                                @if($i < $currentStep)
                                    <svg class="bs-ic" viewBox="0 0 24 24" aria-label="Completed"><use href="#bs-i-check"/></svg>
                                @else
                                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                @endif
                            </div>
                            @if($i < count($statusSteps)-1)
                            <div class="bs-conn {{ $i < $currentStep ? 'on' : '' }}"></div>
                            @else
                            <div style="flex:1;"></div>
                            @endif
                        </div>
                        <svg class="bs-ic bs-step-icon {{ $i === $currentStep ? 'is-current' : ($i < $currentStep ? 'is-done' : '') }}" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-{{ $stepIcons[$i] }}"/></svg>
                        <div class="bs-step-label {{ $i === $currentStep ? 'active' : '' }}">{{ $stepLabels[$i] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Payments --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-card"/></svg>
                <h3>Payment Ledger</h3>
            </div>
            <div class="bs-pay-grid">
                {{-- Downpayment --}}
                @php
                    $dpClass = $downpayment ? ($downpayment->status === 'paid' || $downpayment->status === 'confirmed' ? 'paid' : ($downpayment->status === 'rejected' ? 'rejected' : 'pending')) : 'none';
                @endphp
                <div class="bs-pay {{ $dpClass }}">
                    <div class="bs-label">50% Downpayment</div>
                    <div class="bs-pay-amount"><span class="bs-cur">₱</span>{{ number_format($bakerOrder->agreed_price * 0.5, 0) }}</div>
                    @if($downpayment)
                        <div class="bs-pay-state">
                            @if($dpClass === 'paid')
                                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-check"/></svg> Confirmed
                            @elseif($dpClass === 'rejected')
                                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-x"/></svg> Rejected ({{ $downpayment->rejection_count }}x)
                            @else
                                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-clock"/></svg> Pending Review
                            @endif
                        </div>
                        @if($downpayment->proof_path)
                        <div class="bs-pay-proof">
                            <a href="{{ asset('storage/'.$downpayment->proof_path) }}" target="_blank">
                                View Payment Proof <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-arrow"/></svg>
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="bs-pay-state">Not yet submitted</div>
                    @endif
                </div>

                {{-- Final Payment --}}
                @php
                    $fpClass = $finalPayment ? ($finalPayment->status === 'paid' || $finalPayment->status === 'confirmed' ? 'paid' : ($finalPayment->status === 'rejected' ? 'rejected' : 'pending')) : 'none';
                @endphp
                <div class="bs-pay {{ $fpClass }}">
                    <div class="bs-label">50% Final Payment</div>
                    <div class="bs-pay-amount"><span class="bs-cur">₱</span>{{ number_format($bakerOrder->agreed_price * 0.5, 0) }}</div>
                    @if($finalPayment)
                        <div class="bs-pay-state">
                            @if($fpClass === 'paid')
                                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-check"/></svg> Confirmed
                            @elseif($fpClass === 'rejected')
                                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-x"/></svg> Rejected ({{ $finalPayment->rejection_count }}x)
                            @else
                                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-clock"/></svg> Pending Review
                            @endif
                        </div>
                        @if($finalPayment->proof_path)
                        <div class="bs-pay-proof">
                            <a href="{{ asset('storage/'.$finalPayment->proof_path) }}" target="_blank">
                                View Payment Proof <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-arrow"/></svg>
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="bs-pay-state">
                            <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-lock"/></svg> On delivery
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Cake Config --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-cake"/></svg>
                <h3>Cake Specification</h3>
            </div>
            <div class="bs-spec">
                @foreach(['flavor','shape','size','frosting'] as $key)
                @if(!empty($config[$key]))
                <div class="bs-spec-item">
                    <div class="bs-label">{{ ucfirst($key) }}</div>
                    <div class="bs-spec-value">{{ $config[$key] }}</div>
                </div>
                @endif
                @endforeach
                @if(!empty($config['addons']))
                <div class="bs-spec-item wide">
                    <div class="bs-label">Add-ons</div>
                    <div class="bs-spec-value">{{ implode(', ', (array)$config['addons']) }}</div>
                </div>
                @endif
            </div>
        </section>

        {{-- Chat Messages --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-chat"/></svg>
                <h3>Chat History</h3>
            </div>
            @if($bakerOrder->messages && $bakerOrder->messages->count())
            <div class="bs-log">
                @foreach($bakerOrder->messages as $msg)
                @php $isCustomer = $msg->sender_id === $bakerOrder->cakeRequest->user_id; @endphp
                <div class="bs-entry {{ $isCustomer ? 'is-customer' : 'is-baker' }}">
                    <div class="bs-entry-head">
                        <span class="bs-entry-role">{{ $isCustomer ? 'Customer' : 'Baker' }}</span>
                        <span class="bs-entry-meta">
                            {{ $msg->sender->first_name ?? 'Unknown' }} · {{ $msg->created_at->format('M d, g:i A') }}
                        </span>
                    </div>
                    <div class="bs-entry-text">{{ $msg->message }}</div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bs-empty">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-chat"/></svg>
                No messages exchanged yet.
            </div>
            @endif
        </section>
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>
        {{-- Order Summary --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-file"/></svg>
                <h3>Transaction Summary</h3>
            </div>
            <div class="bs-row is-id">
                <span class="bs-label">Transaction ID</span>
                <span class="bs-row-val is-id">#{{ str_pad($bakerOrder->id,4,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="bs-row">
                <span class="bs-label">Request ID</span>
                <span class="bs-row-val">#{{ str_pad($bakerOrder->cake_request_id,4,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="bs-row">
                <span class="bs-label">Status</span>
                <span class="bs-row-val">
                    <span class="bs-status bs-s-{{ $bakerOrder->status }}">
                        {{ str_replace('_',' ',$bakerOrder->status) }}
                    </span>
                </span>
            </div>
            <div class="bs-row">
                <span class="bs-label">Agreed Price</span>
                <span class="bs-row-val is-price">₱{{ number_format($bakerOrder->agreed_price,0) }}</span>
            </div>
            <div class="bs-row">
                <span class="bs-label">Delivery Date</span>
                <span class="bs-row-val is-date">{{ $bakerOrder->cakeRequest->delivery_date->format('M d, Y') }}</span>
            </div>
            <div class="bs-row">
                <span class="bs-label">Created</span>
                <span class="bs-row-val">{{ $bakerOrder->created_at->format('M d, Y') }}</span>
            </div>
            @if($bakerOrder->cancel_reason)
            <div class="bs-row is-reason">
                <span class="bs-label">Cancel Reason</span>
                <span class="bs-reason-text">{{ $bakerOrder->cancel_reason }}</span>
            </div>
            @endif
        </section>

        {{-- Timeline --}}
        <section class="bs-panel">
            <div class="bs-panel-head">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-log"/></svg>
                <h3>Activity Timeline</h3>
            </div>
            <ul class="bs-timeline">
                <li>
                    <div class="bs-tl-dot"></div>
                    <div>
                        <div class="bs-tl-event">Order created</div>
                        <div class="bs-tl-time">{{ $bakerOrder->created_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @if($downpayment)
                <li>
                    <div class="bs-tl-dot"></div>
                    <div>
                        <div class="bs-tl-event">Downpayment proof submitted</div>
                        <div class="bs-tl-time">{{ $downpayment->created_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @if($downpayment->status === 'paid' || $downpayment->status === 'confirmed')
                <li>
                    <div class="bs-tl-dot is-sage"></div>
                    <div>
                        <div class="bs-tl-event">Downpayment confirmed</div>
                        <div class="bs-tl-time">{{ ($downpayment->confirmed_at ?? $downpayment->updated_at)->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @elseif($downpayment->status === 'rejected')
                <li>
                    <div class="bs-tl-dot is-burgundy"></div>
                    <div>
                        <div class="bs-tl-event">Downpayment rejected</div>
                        <div class="bs-tl-time">{{ $downpayment->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @endif
                @if($finalPayment && ($finalPayment->status === 'paid' || $finalPayment->status === 'confirmed'))
                <li>
                    <div class="bs-tl-dot is-sage"></div>
                    <div>
                        <div class="bs-tl-event">Final payment confirmed</div>
                        <div class="bs-tl-time">{{ ($finalPayment->confirmed_at ?? $finalPayment->updated_at)->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @if($bakerOrder->status === 'COMPLETED')
                <li>
                    <div class="bs-tl-dot is-sage"></div>
                    <div>
                        <div class="bs-tl-event">Order completed</div>
                        <div class="bs-tl-time">{{ $bakerOrder->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @if($bakerOrder->status === 'CANCELLED')
                <li>
                    <div class="bs-tl-dot is-burgundy"></div>
                    <div>
                        <div class="bs-tl-event">Order cancelled</div>
                        <div class="bs-tl-time">{{ $bakerOrder->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
            </ul>
        </section>
    </div>
</div>

</div>
@endsection