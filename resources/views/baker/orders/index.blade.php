@extends('layouts.baker')
@section('title', 'Active Orders')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* My Orders: same cake-atelier ledger language as My Bids. Plus Jakarta Sans only. */
.orders-page{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;--sage-d:#33502F;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.orders-page *{box-sizing:border-box;font-family:inherit}
.orders-page svg{flex-shrink:0}
.orders-page a:focus-visible,.orders-page button:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes op-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes op-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes op-pulse{0%,100%{opacity:1}50%{opacity:.3}}
@keyframes op-ring{0%,100%{box-shadow:0 0 0 0 rgba(184,148,82,.45)}50%{box-shadow:0 0 0 6px rgba(184,148,82,0)}}
@media(prefers-reduced-motion:reduce){.orders-page *,.orders-page *::before,.orders-page *::after{animation:none!important;transition:none!important}}

/* header */
.op-header{position:relative;margin:0 0 2rem;padding-bottom:1.75rem;animation:op-fadeUp .6s var(--e) backwards}
.op-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.op-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:op-line .9s var(--e) .3s backwards}
.op-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.op-sub{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* section jump (same control styling as the My Bids filters) */
.op-jump{display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;margin-bottom:.5rem;animation:op-fadeUp .6s var(--e) .1s backwards}
.op-jump-label{font-size:.6rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);margin-right:.75rem}
.op-chip{display:inline-flex;align-items:center;gap:.55rem;padding:.65rem 1.1rem;background:transparent;border:1px solid var(--beige);font-size:.66rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mocha);text-decoration:none;transition:background .3s,color .3s,border-color .3s}
a.op-chip:hover{border-color:var(--gold);color:var(--esp);text-decoration:none}
.op-chip.is-empty{opacity:.45}
.op-chip b{font-weight:900;color:var(--esp);font-variant-numeric:tabular-nums}
.op-dot{width:7px;height:7px;flex-shrink:0;transform:rotate(45deg)}
.op-dot.active{background:var(--gold)}
.op-dot.done{background:var(--sage)}
.op-dot.cancelled{background:var(--burg)}

/* section */
.op-sec{margin-top:3rem;scroll-margin-top:1.5rem;animation:op-fadeUp .6s var(--e) .2s backwards}
.op-sec-head{display:flex;align-items:center;gap:.75rem;padding-bottom:1rem}
.op-sec-head svg{color:var(--gold)}
.op-sec-head h2{margin:0;font-size:1.4rem;font-weight:900;letter-spacing:-.03em;line-height:1}
.op-sec-count{margin-left:auto;min-width:32px;height:28px;padding:0 .6rem;display:inline-flex;align-items:center;justify-content:center;background:var(--esp);color:var(--gold-l);font-size:.72rem;font-weight:800;letter-spacing:.08em;font-variant-numeric:tabular-nums}
.op-sec-count.done{background:var(--sage-d);color:var(--ivory)}
.op-sec-count.cancelled{background:var(--burg);color:var(--ivory)}
.op-sec.cancelled .op-sec-head h2,.op-sec.cancelled .op-sec-head svg{color:var(--burg)}
.op-list{display:grid;gap:1.25rem;padding-top:1.25rem;border-top:1px solid var(--esp)}

/* order row */
.op-row{position:relative;padding:1.5rem 1.75rem 0;background:var(--w);border:1px solid var(--beige);border-left:3px solid var(--gold);animation:op-fadeUp .5s var(--e) backwards;transition:border-color .3s,box-shadow .3s}
.op-row:hover{border-color:var(--gold);box-shadow:0 14px 32px -20px rgba(36,21,15,.35)}
#completed-orders .op-row{border-left-color:var(--sage)}
#completed-orders .op-row:hover{border-color:var(--sage)}
.op-row.is-cancelled{border-left-color:var(--burg);background:#FCF8F6}
.op-row.is-cancelled:hover{border-color:var(--burg);box-shadow:none}
.op-grid{display:grid;grid-template-columns:minmax(80px,9%) minmax(0,1fr) minmax(150px,17%) minmax(120px,14%) minmax(150px,17%);gap:1rem 1.5rem;align-items:center}
.op-label{font-size:.54rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}
.op-ref{margin-top:.2rem;font-size:1rem;font-weight:900;letter-spacing:-.03em;color:var(--caramel);font-variant-numeric:tabular-nums}
.op-row.is-cancelled .op-ref{color:var(--burg)}
.op-cake{font-size:1.05rem;font-weight:800;letter-spacing:-.02em;line-height:1.25}
.op-row.is-cancelled .op-cake{color:var(--burg);opacity:.85}
.op-sub-line{margin-top:.3rem;font-size:.75rem;color:var(--taupe)}
.op-tags{display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.6rem}
.op-tag{padding:.25rem .6rem;background:var(--cream);border:1px solid var(--beige);font-size:.68rem;font-weight:600;color:var(--mocha)}
.op-date{margin-top:.25rem;font-size:.84rem;font-weight:700}
.op-amount{margin-top:.2rem;font-size:1.35rem;font-weight:900;letter-spacing:-.04em;color:var(--credit);font-variant-numeric:tabular-nums}
.op-amount.done{color:var(--sage-d)}
.op-amount.cancelled{color:var(--burg);text-decoration:line-through;opacity:.6}
.op-status{display:flex;flex-direction:column;align-items:flex-start;gap:.4rem}
.op-cancelled-on{font-size:.72rem;color:var(--taupe)}

/* badges (same construction as My Bids) */
.op-badge{display:inline-flex;align-items:center;gap:.4rem;padding:.3rem .6rem;border:1px solid transparent;border-left-width:2px;font-size:.56rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;white-space:nowrap}
.op-badge.active{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.op-badge.done{background:#EFF2E8;color:var(--sage-d);border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.op-badge.cancelled{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}
.op-badge.ok{background:var(--cream);color:var(--mocha);border-color:var(--beige);border-left-color:var(--taupe)}
.op-badge.urgent{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}
.op-pulse{display:inline-block;width:6px;height:6px;border-radius:50%;background:currentColor;animation:op-pulse 1.6s ease-in-out infinite}

/* progress */
.op-progress{margin-top:1.5rem;padding:1.75rem 0 2.75rem;border-top:1px solid var(--line)}
.op-track{display:flex;align-items:center}
.op-step{display:flex;align-items:center;flex:1;position:relative}
.op-step:last-child{flex:0 0 auto}
.op-line{flex:1;height:1px}
.op-line.line-done{background:var(--gold)}
.op-line.line-pending{background:var(--beige)}
.op-line.line-cancelled{background:rgba(84,37,44,.3)}
.op-node{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;z-index:1}
.op-node.done{background:var(--esp);color:var(--gold-l)}
.op-node.active{background:var(--w);border:1.5px solid var(--gold);color:var(--caramel);animation:op-ring 2.4s ease-in-out infinite}
.op-node.pending{background:var(--ivory);border:1px solid var(--beige);color:var(--taupe)}
.op-node.cancelled-dot{background:#F6ECEA;border:1px solid rgba(84,37,44,.28);color:var(--burg)}
.op-step-label{position:absolute;top:calc(100% + 8px);left:50%;transform:translateX(-50%);font-size:.58rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--taupe);white-space:nowrap;line-height:1.3;text-align:center}
.op-step:first-child .op-step-label{left:0;transform:none}
.op-step:last-child .op-step-label{left:auto;right:0;transform:none}
.op-step-label.active-label{color:var(--esp);font-weight:800}

/* cancellation note */
.op-note{margin:1.25rem 0 0;padding:.9rem 1.1rem;background:#F6ECEA;border:1px solid rgba(84,37,44,.28);border-left:2px solid var(--burg);display:flex;align-items:flex-start;gap:.7rem;font-size:.85rem;line-height:1.55;color:#3E1A1F}
.op-note svg{margin-top:2px;color:var(--burg)}
.op-note-label{font-size:.56rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--burg);margin-bottom:.25rem}

/* actions */
.op-actions{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin:0 -1.75rem;padding:1rem 1.75rem!important;border-top:1px solid var(--line);background:var(--cream)}
.op-note + .op-progress{padding-top:1.5rem}
.op-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem .9rem;background:transparent;border:1px solid var(--esp);font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);text-decoration:none;cursor:pointer;transition:background .3s,color .3s,border-color .3s}
.op-btn:hover{background:var(--esp);color:var(--gold-l);text-decoration:none}
.op-btn.report{border-color:rgba(84,37,44,.3);color:var(--burg)}
.op-btn.report:hover{background:var(--burg);border-color:var(--burg);color:var(--ivory)}
.op-reported{display:inline-flex;align-items:center;gap:.4rem;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--taupe)}

/* empty (identical to My Bids) */
.op-empty{padding:4.5rem 1rem;text-align:center;border-top:1px solid var(--esp);border-bottom:1px solid var(--line);margin-top:2rem}
.op-empty-icon{display:flex;justify-content:center;margin-bottom:1.1rem;color:var(--gold);opacity:.75}
.op-empty .eyebrow{display:block;font-size:.6rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--caramel);margin-bottom:.8rem}
.op-empty h3{font-size:clamp(1.5rem,3vw,2.2rem);font-weight:900;letter-spacing:-.04em;line-height:1;margin:0 0 .7rem}
.op-empty p{font-size:.92rem;color:var(--mocha);max-width:44ch;margin:0 auto}
.op-empty-cta{display:inline-flex;align-items:center;gap:.6rem;margin-top:1.6rem;padding:1.05rem 1.7rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:background .3s,color .3s,transform .3s var(--e)}
.op-empty-cta:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);text-decoration:none}

/* responsive */
@media(max-width:1000px){
    .op-grid{grid-template-columns:minmax(80px,auto) minmax(0,1fr) minmax(0,1fr)}
    .op-status{grid-column:1 / -1;flex-direction:row;flex-wrap:wrap;align-items:center}
}
@media(max-width:620px){
    .op-grid{grid-template-columns:1fr 1fr}
    .op-grid > :nth-child(2){grid-column:1 / -1;order:-1}
    .op-step-label{display:none}
    .op-step-label.active-label{display:block}
    .op-actions{flex-wrap:wrap}
    .op-row{padding:1.25rem 1.1rem 0}
    .op-actions{margin:0 -1.1rem;padding:1rem 1.1rem!important}
}
</style>
@endpush

@section('content')

@php
    // ── SVG icon set (mirrors the icon language used on the order-detail page) ──
    $icoBolt      = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>';
    $icoCheckCirc = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
    $icoXCirc     = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';

    $icoCheck  = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
    $icoXSmall = '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

    $icoCard    = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>';
    $icoBowl    = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10h18l-1.5 8.5a2 2 0 0 1-2 1.5H6.5a2 2 0 0 1-2-1.5Z"/><path d="M7 10V6a5 5 0 0 1 10 0v4"/></svg>';
    $icoPackage = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
    $icoTruck   = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>';
    $icoStore   = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 7h20l-1.5 5a2 2 0 0 1-2 1.5H5.5A2 2 0 0 1 3.5 12L2 7Z"/><path d="M4 12v7a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-7"/><path d="M9 20v-5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v5"/><path d="M2 7l1.5-4h17L22 7"/></svg>';

    $icoCalendar = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';
    $icoAlarm    = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2"/><path d="M5 3 2 6"/><path d="m22 6-3-3"/></svg>';

    $icoAlertTri = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
    $icoAlertSm  = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
    $icoBan      = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>';
    $icoBoxLg    = '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
    $icoArrow    = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
@endphp

@php
// Status flow now mirrors the order-detail page: full payment upfront, no separate
// down-payment / final-payment stages. OUT_FOR_DELIVERY is a sub-state of READY
// (escrow held, cake en route) and is displayed at the same step as DELIVERED.
$statusSteps = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','DELIVERED'];

$activeOrders    = $orders->whereNotIn('status', ['CANCELLED','COMPLETED']);
$completedOrders = $orders->where('status', 'COMPLETED');
$cancelledOrders = $orders->where('status', 'CANCELLED');
@endphp

<div class="orders-page">

<div class="op-header">
    <div>
        <h1 class="op-title">My Orders</h1>
        <p class="op-sub">Track and manage all your cake orders</p>
    </div>
</div>

@if($orders->isNotEmpty())
<div class="op-jump">
    <span class="op-jump-label">Jump to</span>
    @if($activeOrders->count())
        <a href="#active-orders" class="op-chip"><span class="op-dot active"></span>Active <b>{{ $activeOrders->count() }}</b></a>
    @else
        <span class="op-chip is-empty"><span class="op-dot active"></span>Active <b>0</b></span>
    @endif
    @if($completedOrders->count())
        <a href="#completed-orders" class="op-chip"><span class="op-dot done"></span>Completed <b>{{ $completedOrders->count() }}</b></a>
    @else
        <span class="op-chip is-empty"><span class="op-dot done"></span>Completed <b>0</b></span>
    @endif
    @if($cancelledOrders->count())
        <a href="#cancelled-orders" class="op-chip"><span class="op-dot cancelled"></span>Cancelled <b>{{ $cancelledOrders->count() }}</b></a>
    @else
        <span class="op-chip is-empty"><span class="op-dot cancelled"></span>Cancelled <b>0</b></span>
    @endif
</div>
@endif

{{-- ════════════════ ACTIVE ORDERS ════════════════ --}}
@if($activeOrders->count())
<section class="op-sec" id="active-orders">
    <div class="op-sec-head">
        {!! $icoBolt !!}
        <h2>Active Orders</h2>
        <span class="op-sec-count">{{ $activeOrders->count() }}</span>
    </div>
    <div class="op-list">
    @foreach($activeOrders as $order)
    @php
        $config = is_array($order->cakeRequest->cake_configuration)
            ? $order->cakeRequest->cake_configuration
            : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);

        $isPickup = $order->cakeRequest->isPickup();
        $isRush   = $order->cakeRequest->is_rush;

        // Map delivery sub-states onto the same 5-step flow used on the detail page.
        $displayStatus = in_array($order->status, ['OUT_FOR_DELIVERY']) ? 'DELIVERED' : $order->status;
        $currentStep   = array_search($displayStatus, $statusSteps);
        if ($currentStep === false) $currentStep = 0;

        $daysLeft = (int) now()->startOfDay()->diffInDays($order->cakeRequest->delivery_date->startOfDay(), false);

        $stepLabels = ['Accepted', 'Awaiting Payment', 'Preparing', 'Ready', $isPickup ? 'Collected' : 'Delivered'];
        $stepIcons  = [$icoCheck, $icoCard, $icoBowl, $icoPackage, $isPickup ? $icoStore : $icoTruck];
    @endphp
    <article class="op-row" style="animation-delay: {{ min($loop->index, 12) * 0.05 + 0.3 }}s;">
        <div class="op-grid">
            <div>
                <div class="op-label">Order</div>
                <div class="op-ref">#{{ str_pad($order->cakeRequest->id,4,'0',STR_PAD_LEFT) }}</div>
            </div>
            <div>
                <div class="op-cake">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                <div class="op-sub-line">Customer: {{ $order->cakeRequest->user->first_name }}</div>
                @if(!empty($config['size']) || !empty($config['frosting']))
                <div class="op-tags">
                    @if(!empty($config['size']))     <span class="op-tag">{{ $config['size'] }}</span>     @endif
                    @if(!empty($config['frosting'])) <span class="op-tag">{{ $config['frosting'] }}</span> @endif
                </div>
                @endif
            </div>
            <div>
                <div class="op-label">Order needed by</div>
                <div class="op-date">{{ $order->cakeRequest->delivery_date->format('F d, Y') }}</div>
            </div>
            <div>
                <div class="op-label">Agreed Price</div>
                <div class="op-amount">₱{{ number_format($order->agreed_price, 0) }}</div>
            </div>
            <div class="op-status">
                <span class="op-badge active"><span class="op-pulse"></span>{{ str_replace('_',' ',$order->status) }}</span>
                <span class="op-badge {{ $daysLeft <= 2 ? 'urgent' : 'ok' }}">
                    {!! $daysLeft <= 2 ? $icoAlarm : $icoCalendar !!}{{ $daysLeft }}d left
                </span>
            </div>
        </div>

        <div class="op-progress">
            <div class="op-track">
                @foreach($statusSteps as $i => $step)
                <div class="op-step">
                    <div class="op-node {{ $i < $currentStep ? 'done' : ($i == $currentStep ? 'active' : 'pending') }}">
                        {!! $i < $currentStep ? $icoCheck : $stepIcons[$i] !!}
                        <span class="op-step-label {{ $i == $currentStep ? 'active-label' : '' }}">{{ $stepLabels[$i] }}</span>
                    </div>
                    @if($i < count($statusSteps) - 1)
                        <div class="op-line {{ $i < $currentStep ? 'line-done' : 'line-pending' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="op-actions" style="padding-top:0;">
            <a href="{{ route('baker.orders.show', $order->id) }}" class="op-btn">View Details</a>
        </div>
    </article>
    @endforeach
    </div>
</section>
@endif

{{-- ════════════════ COMPLETED ORDERS ════════════════ --}}
@if($completedOrders->count())
<section class="op-sec" id="completed-orders">
    <div class="op-sec-head">
        {!! $icoCheckCirc !!}
        <h2>Completed Orders</h2>
        <span class="op-sec-count done">{{ $completedOrders->count() }}</span>
    </div>
    <div class="op-list">
    @foreach($completedOrders as $order)
    @php
        $config = is_array($order->cakeRequest->cake_configuration)
            ? $order->cakeRequest->cake_configuration
            : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);
    @endphp
    <article class="op-row" style="animation-delay: {{ min($loop->index, 12) * 0.05 + 0.3 }}s;">
        <div class="op-grid">
            <div>
                <div class="op-label">Order</div>
                <div class="op-ref">#{{ str_pad($order->cakeRequest->id,4,'0',STR_PAD_LEFT) }}</div>
            </div>
            <div>
                <div class="op-cake">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                <div class="op-sub-line">Customer: {{ $order->cakeRequest->user->first_name }}</div>
            </div>
            <div>
                <div class="op-label">Delivered</div>
                <div class="op-date">{{ $order->cakeRequest->delivery_date->format('F d, Y') }}</div>
            </div>
            <div>
                <div class="op-label">Earned</div>
                <div class="op-amount done">₱{{ number_format($order->agreed_price, 0) }}</div>
            </div>
            <div class="op-status">
                <span class="op-badge done">{!! $icoCheck !!}Completed</span>
            </div>
        </div>
        <div class="op-actions">
            <a href="{{ route('baker.orders.show', $order->id) }}" class="op-btn">View Details</a>
            <a href="{{ route('report.create', $order->id) }}" class="op-btn report">{!! $icoAlertSm !!}Report Customer</a>
        </div>
    </article>
    @endforeach
    </div>
</section>
@endif

{{-- ════════════════ CANCELLED ORDERS ════════════════ --}}
@if($cancelledOrders->count())
<section class="op-sec cancelled" id="cancelled-orders">
    <div class="op-sec-head">
        {!! $icoXCirc !!}
        <h2>Cancelled Orders</h2>
        <span class="op-sec-count cancelled">{{ $cancelledOrders->count() }}</span>
    </div>
    <div class="op-list">
    @foreach($cancelledOrders as $order)
    @php
        $config = is_array($order->cakeRequest->cake_configuration)
            ? $order->cakeRequest->cake_configuration
            : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);

        $isPickup = $order->cakeRequest->isPickup();

        $displayStatus = in_array($order->status, ['OUT_FOR_DELIVERY']) ? 'DELIVERED' : $order->status;
        $currentStep   = array_search($displayStatus, $statusSteps);
        if ($currentStep === false) $currentStep = 0;

        $stepLabels = ['Accepted', 'Awaiting Payment', 'Preparing', 'Ready', $isPickup ? 'Collected' : 'Delivered'];
        $stepIcons  = [$icoCheck, $icoCard, $icoBowl, $icoPackage, $isPickup ? $icoStore : $icoTruck];

        // Full-payment flow: a single 'full' payment record now drives auto-cancellation
        // after two rejected proofs (mirrors the order-detail page).
        $fullPayment   = \App\Models\Payment::where('cake_request_id', $order->cake_request_id)
            ->where('payment_type', 'full')->first();
        $wasAutoCancel = ($fullPayment?->rejection_count ?? 0) >= 2;
    @endphp
    <article class="op-row is-cancelled" style="animation-delay: {{ min($loop->index, 12) * 0.05 + 0.3 }}s;">
        <div class="op-grid">
            <div>
                <div class="op-label">Order</div>
                <div class="op-ref">#{{ str_pad($order->cakeRequest->id,4,'0',STR_PAD_LEFT) }}</div>
            </div>
            <div>
                <div class="op-cake">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                <div class="op-sub-line">Customer: {{ $order->cakeRequest->user->first_name }}</div>
                @if(!empty($config['size']) || !empty($config['frosting']))
                <div class="op-tags">
                    @if(!empty($config['size']))     <span class="op-tag">{{ $config['size'] }}</span>     @endif
                    @if(!empty($config['frosting'])) <span class="op-tag">{{ $config['frosting'] }}</span> @endif
                </div>
                @endif
            </div>
            <div>
                <div class="op-label">Was due</div>
                <div class="op-date">{{ $order->cakeRequest->delivery_date->format('F d, Y') }}</div>
            </div>
            <div>
                <div class="op-label">Order Value</div>
                <div class="op-amount cancelled">₱{{ number_format($order->agreed_price, 0) }}</div>
            </div>
            <div class="op-status">
                <span class="op-badge cancelled">{!! $icoXSmall !!}Cancelled</span>
                @if($order->cancelled_at)
                <span class="op-cancelled-on">{{ $order->cancelled_at->format('M d, Y') }}</span>
                @endif
            </div>
        </div>

        @if($order->cancel_reason)
        <div class="op-note">
            {!! $icoAlertTri !!}
            <div>
                <div class="op-note-label">Cancellation Reason</div>
                {{ $order->cancel_reason }}
            </div>
        </div>
        @elseif($wasAutoCancel)
        <div class="op-note">
            {!! $icoBan !!}
            <div>
                <div class="op-note-label">Auto-Cancelled</div>
                This order was automatically cancelled after 2 rejected payment proofs.
            </div>
        </div>
        @endif

        <div class="op-progress">
            <div class="op-track">
                @foreach($statusSteps as $i => $step)
                <div class="op-step">
                    <div class="op-node {{ $i < $currentStep ? 'cancelled-dot' : 'pending' }}">
                        {!! $i < $currentStep ? $icoCheck : $stepIcons[$i] !!}
                        <span class="op-step-label">{{ $stepLabels[$i] }}</span>
                    </div>
                    @if($i < count($statusSteps) - 1)
                        <div class="op-line {{ $i < $currentStep ? 'line-cancelled' : 'line-pending' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="op-actions" style="padding-top:0;">
            <a href="{{ route('baker.orders.show', $order->id) }}" class="op-btn">View Details</a>
            @php
                $alreadyReported = \App\Models\Report::where('reporter_id', auth()->id())
                    ->where('baker_order_id', $order->id)->exists();
            @endphp
            @if(!$alreadyReported)
            <a href="{{ route('report.create', $order->id) }}" class="op-btn report">{!! $icoAlertSm !!}Report Customer</a>
            @else
            <span class="op-reported">{!! $icoCheck !!}Reported</span>
            @endif
        </div>
    </article>
    @endforeach
    </div>
</section>
@endif

@if($orders->isEmpty())
<div class="op-empty">
    <div class="op-empty-icon">{!! $icoBoxLg !!}</div>
    <span class="eyebrow">Your order ledger</span>
    <h3>No orders yet</h3>
    <p>When a customer accepts your bid, your order will appear here.</p>
    <a href="{{ route('baker.requests.index') }}" class="op-empty-cta">Browse Requests {!! $icoArrow !!}</a>
</div>
@endif

</div>{{-- /.orders-page --}}

@endsection 