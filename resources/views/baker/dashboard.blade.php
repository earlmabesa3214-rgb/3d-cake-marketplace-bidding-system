@extends('layouts.baker')
@section('title', 'Dashboard')

@push('styles')
<style>
/* Baker Dashboard: luxury cake-atelier workspace. Plus Jakarta Sans only. */
.bd{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.bd *{box-sizing:border-box;font-family:inherit}
.bd svg{display:block}
.bd a{text-decoration:none}
.bd a:focus-visible,.bd button:focus-visible,.bd input:focus-visible+.bd-fulfil-card-inner{outline:2px solid var(--gold);outline-offset:3px}
@keyframes bd-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes bd-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes bd-pulse{0%,100%{box-shadow:0 0 0 0 rgba(184,148,82,.55)}50%{box-shadow:0 0 0 6px rgba(184,148,82,0)}}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important}}
.bd-reveal{animation:bd-fadeUp .6s var(--e) backwards}
.bd-reveal.r1{animation-delay:.02s}.bd-reveal.r2{animation-delay:.12s}.bd-reveal.r3{animation-delay:.22s}.bd-reveal.r4{animation-delay:.32s}

/* header */
.bd-head{position:relative;display:flex;align-items:flex-end;justify-content:space-between;gap:2rem;flex-wrap:wrap;margin:0 0 2.25rem;padding-bottom:1.75rem}
.bd-head::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.bd-head::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:bd-line .9s var(--e) .3s backwards}
.bd-head-left{min-width:260px;flex:1}
.bd-eyebrow{display:block;font-size:.66rem;font-weight:800;letter-spacing:.32em;text-transform:uppercase;color:var(--caramel);margin-bottom:.9rem}
.bd-greeting{font-size:clamp(2.2rem,5.4vw,4.2rem);font-weight:900;line-height:.98;letter-spacing:-.05em;margin:0}
.bd-greeting-sub{margin:1rem 0 0;max-width:54ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

.bd-status-card{position:relative;display:block;flex-shrink:0;min-width:260px;padding:1.25rem 1.4rem 1.2rem;color:var(--ivory);transition:transform .3s var(--e);
background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),radial-gradient(ellipse 90% 70% at 100% 0,rgba(184,148,82,.22),transparent 62%),linear-gradient(160deg,#2B1A12,#24150F 60%,#1B0F09)}
.bd-status-card::after{content:"";position:absolute;left:1.4rem;right:1.4rem;bottom:0;height:2px;background:linear-gradient(90deg,var(--gold),transparent)}
.bd-status-card:hover{transform:translateY(-2px)}
.bd-status-label{font-size:.6rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--gold);margin-bottom:.8rem}
.bd-availability-row{display:flex;align-items:center;gap:.65rem;margin-bottom:.4rem}
.bd-avail-dot{width:9px;height:9px;border-radius:50%;background:var(--gold);flex-shrink:0}
.bd-avail-dot.is-off{background:var(--taupe)}
.bd-avail-dot.is-on{animation:bd-pulse 2.4s ease-in-out infinite}
.bd-availability-text{font-size:1.15rem;font-weight:900;letter-spacing:-.03em}
.bd-status-sub{font-size:.76rem;color:var(--beige);line-height:1.5}

/* priority */
.bd-priority{display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;margin-bottom:2.25rem;padding:1.4rem 1.6rem;background:var(--cream);border:1px solid var(--gold-line);border-left:3px solid var(--gold)}
.bd-priority.state-none{border-left-color:var(--sage)}
.bd-priority.state-requests{background:var(--w);border-color:var(--esp);border-left:3px solid var(--gold)}
.bd-priority-icon{width:52px;height:52px;flex-shrink:0;display:grid;place-items:center;color:var(--gold);border:1px solid var(--gold-line);box-shadow:inset 0 0 0 4px var(--cream),inset 0 0 0 5px var(--gold-line)}
.bd-priority.state-requests .bd-priority-icon{box-shadow:inset 0 0 0 4px var(--w),inset 0 0 0 5px var(--gold-line)}
.bd-priority.state-none .bd-priority-icon{color:var(--sage)}
.bd-priority-body{flex:1;min-width:220px}
.bd-priority-title{font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;margin-bottom:.5rem}
.bd-priority-sub{font-size:.88rem;line-height:1.6;color:var(--mocha)}
.bd-priority-progress{display:flex;align-items:center;gap:.8rem;margin-top:.8rem}
.bd-priority-progress-track{flex:1;max-width:200px;height:4px;background:var(--beige);overflow:hidden}
.bd-priority-progress-fill{height:100%;width:0%;background:var(--gold);transition:width 1s var(--e)}
.bd-priority-progress-label{font-size:.6rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--credit);white-space:nowrap}
.bd-priority-cta{display:inline-flex;align-items:center;gap:.6rem;flex-shrink:0;padding:1rem 1.5rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:background .3s,color .3s,transform .3s var(--e)}
.bd-priority-cta:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px)}
.bd-priority-cta svg{transition:transform .3s}
.bd-priority-cta:hover svg{transform:translateX(3px)}

/* stats */
.bd-stats{display:grid;grid-template-columns:repeat(4,1fr);border:1px solid var(--esp);margin-bottom:3rem}
.bd-stat{position:relative;display:block;padding:1.6rem 1.5rem 1.5rem;background:var(--w);color:var(--esp);transition:background .35s}
.bd-stat+.bd-stat{border-left:1px solid var(--line)}
.bd-stat:hover{background:var(--cream)}
.bd-stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem}
.bd-stat-icon{color:var(--gold)}
.bd-stat-arrow{color:var(--taupe);transition:transform .3s,color .3s}
.bd-stat:hover .bd-stat-arrow{transform:translateX(3px);color:var(--esp)}
.bd-stat-value{font-size:clamp(1.9rem,3vw,2.6rem);font-weight:900;letter-spacing:-.05em;line-height:1;font-variant-numeric:tabular-nums}
.bd-stat.c4 .bd-stat-value{color:var(--credit)}
.bd-stat-label{margin-top:.8rem;font-size:.6rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}
.bd-stat-foot{margin-top:.3rem;font-size:.74rem;color:var(--mocha)}
.bd-stat-accent{position:absolute;left:1.5rem;bottom:0;width:32px;height:2px;background:var(--gold);transition:width .4s var(--e)}
.bd-stat:hover .bd-stat-accent{width:calc(100% - 3rem)}

/* main grid */
.bd-main{display:grid;grid-template-columns:minmax(0,1fr) 400px;gap:3rem;align-items:start}
.bd-col{min-width:0;display:flex;flex-direction:column;gap:3rem}
.bd-panel{border-top:1px solid var(--esp)}
.bd-panel-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1.25rem 0 1rem;border-bottom:1px solid var(--line)}
.bd-panel-title{display:flex;align-items:center;gap:.6rem;font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase}
.bd-panel-title svg{color:var(--gold);flex-shrink:0}
.bd-panel-link{font-size:.6rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--caramel);white-space:nowrap;transition:color .25s}
.bd-panel-link:hover{color:var(--esp)}

/* requests */
.bd-req{display:flex;align-items:center;gap:1.25rem;padding:1.3rem 0;border-bottom:1px solid var(--line);color:var(--esp);transition:background .3s,padding-left .3s var(--e)}
.bd-req:hover{background:rgba(239,230,215,.5);padding-left:.75rem}
.bd-req-visual{width:64px;height:64px;flex-shrink:0;display:grid;place-items:center;color:var(--gold);background:var(--cream);border:1px solid var(--gold-line);box-shadow:inset 0 0 0 4px var(--cream),inset 0 0 0 5px var(--gold-line)}
.bd-req-info{flex:1;min-width:0}
.bd-req-name{font-size:1.1rem;font-weight:900;letter-spacing:-.03em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.bd-req-badges{display:flex;flex-wrap:wrap;margin-top:.45rem}
.bd-req-badge{font-size:.58rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mocha);padding:0 .7rem;border-left:1px solid var(--beige)}
.bd-req-badge:first-child{padding-left:0;border-left:0}
.bd-req-meta-row{display:flex;align-items:center;gap:1rem;flex-wrap:wrap;margin-top:.6rem}
.bd-req-meta-item{display:inline-flex;align-items:center;gap:.4rem;font-size:.74rem;font-weight:600;color:var(--taupe)}
.bd-req-meta-item svg{color:var(--gold)}
.bd-req-bids{display:inline-flex;align-items:center;gap:.4rem;padding:.2rem .55rem;background:#F3EAD3;border:1px solid var(--gold-line);border-left:2px solid var(--gold);color:#7A5A15;font-size:.58rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
.bd-req-right{display:flex;align-items:center;gap:1rem;flex-shrink:0;text-align:right}
.bd-req-budget-val{font-size:1.05rem;font-weight:900;letter-spacing:-.03em;color:var(--credit);font-variant-numeric:tabular-nums}
.bd-req-budget-date{margin-top:.2rem;font-size:.68rem;color:var(--taupe)}
.bd-req-arrow{color:var(--taupe);transition:transform .3s,color .3s}
.bd-req:hover .bd-req-arrow{transform:translateX(4px);color:var(--esp)}

/* empty */
.bd-empty{padding:3rem 1rem;text-align:center;border-bottom:1px solid var(--line)}
.bd-empty-icon{display:flex;justify-content:center;margin-bottom:.9rem;color:var(--gold);opacity:.7}
.bd-empty-title{font-size:1.05rem;font-weight:900;letter-spacing:-.03em;margin-bottom:.3rem}
.bd-empty-sub{font-size:.8rem;color:var(--mocha)}

/* earnings */
.bd-earn-summary{padding:1.5rem 0 .25rem}
.bd-earn-value{font-size:clamp(2rem,4vw,3rem);font-weight:900;letter-spacing:-.05em;line-height:1;color:var(--credit);font-variant-numeric:tabular-nums}
.bd-earn-label{margin-top:.6rem;font-size:.6rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--taupe)}
.bd-chart-wrap{position:relative;padding:1.25rem 0 0}
.bd-chart{display:flex;align-items:flex-end;gap:10px;height:132px;border-bottom:1px solid var(--esp);background-image:linear-gradient(0deg,var(--line) 1px,transparent 1px);background-size:100% 33px;background-position:bottom}
.bd-bar-col{flex:1;height:100%;display:flex;flex-direction:column;justify-content:flex-end;align-items:center}
.bd-bar{width:100%;max-width:34px;height:0;min-height:3px;cursor:pointer;background:linear-gradient(to top,var(--esp),var(--cof) 60%,var(--gold));transition:height 1s var(--e),filter .2s}
.bd-bar:hover{filter:brightness(1.25)}
.bd-bar-label{margin-top:.6rem;font-size:.56rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;text-align:center;color:var(--taupe)}
.bd-tooltip{position:absolute;z-index:3;padding:.4rem .65rem;background:var(--esp);color:var(--ivory);border:1px solid var(--gold-line);font-size:.68rem;font-weight:700;white-space:nowrap;pointer-events:none;opacity:0;transform:translate(-50%,-6px);transition:opacity .15s,transform .15s}
.bd-tooltip.show{opacity:1;transform:translate(-50%,-12px)}

/* fulfillment */
.bd-fulfil-desc{padding:1.25rem 0 1rem;font-size:.82rem;line-height:1.6;color:var(--mocha)}
.bd-fulfil-cards{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1rem}
.bd-fulfil-card{position:relative;display:block;cursor:pointer}
.bd-fulfil-card input{position:absolute;opacity:0;width:0;height:0}
.bd-fulfil-card-inner{position:relative;display:flex;flex-direction:column;align-items:flex-start;gap:.5rem;height:100%;padding:1.1rem 1rem;background:var(--w);border:1px solid var(--beige);transition:border-color .3s,background .3s,transform .3s var(--e)}
.bd-fulfil-card:hover .bd-fulfil-card-inner{border-color:var(--taupe);transform:translateY(-2px)}
.bd-fulfil-card-icon{display:grid;place-items:center;width:34px;height:34px;color:var(--mocha);border:1px solid var(--beige);transition:.3s}
.bd-fulfil-card-title{font-size:.95rem;font-weight:900;letter-spacing:-.02em}
.bd-fulfil-card-sub{margin-top:-.3rem;font-size:.7rem;color:var(--taupe)}
.bd-fulfil-card-tag{padding:.25rem .55rem;font-size:.54rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:var(--taupe);border:1px solid var(--beige);border-left-width:2px}
.bd-fulfil-card input:checked+.bd-fulfil-card-inner{background:var(--cream);border-color:var(--gold-line);box-shadow:inset 0 0 0 4px var(--ivory),inset 0 0 0 5px var(--gold-line)}
.bd-fulfil-card input:checked+.bd-fulfil-card-inner .bd-fulfil-card-icon{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.bd-fulfil-card input:checked+.bd-fulfil-card-inner .bd-fulfil-card-tag{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.bd-fulfil-status{display:flex;align-items:center;gap:.6rem;padding:.8rem 1rem;background:#EFF2E8;border-left:2px solid var(--sage);color:#33502F;font-size:.76rem;font-weight:700;line-height:1.45}
.bd-fulfil-status.is-warn{background:#F6ECEA;border-left-color:var(--burg);color:var(--burg)}
.bd-fulfil-status svg{flex-shrink:0}

/* profile completion */
.bd-profile-body{padding:1.4rem 0 .25rem}
.bd-profile-pct{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:.9rem}
.bd-profile-pct-val{font-size:2rem;font-weight:900;letter-spacing:-.05em;line-height:1}
.bd-profile-pct-label{font-size:.6rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--taupe)}
.bd-progress-track{display:flex;gap:4px;height:6px;margin-bottom:1.1rem}
.bd-progress-track .layer{flex:1;position:relative;overflow:hidden;background:var(--beige)}
.bd-progress-fill{position:absolute;inset:0;background:var(--gold)}
.bd-profile-chips{display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:1.1rem}
.bd-chip{padding:.3rem .65rem;background:#F3EAD3;color:#7A5A15;border:1px solid var(--gold-line);border-left:2px solid var(--gold);font-size:.62rem;font-weight:800;letter-spacing:.08em}
.bd-profile-cta{display:inline-flex;align-items:center;gap:.5rem;font-size:.62rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--caramel);transition:color .25s}
.bd-profile-cta:hover{color:var(--esp)}
.bd-profile-ready{display:flex;align-items:center;gap:1rem;padding:1.4rem 0;border-bottom:1px solid var(--line)}
.bd-ready-icon{width:42px;height:42px;flex-shrink:0;display:grid;place-items:center;color:var(--sage);border:1px solid rgba(94,127,90,.4)}
.bd-ready-title{font-size:.95rem;font-weight:900;letter-spacing:-.02em}
.bd-ready-sub{margin-top:.2rem;font-size:.76rem;color:var(--mocha)}

/* recent bids */
.bd-bid{display:flex;align-items:flex-start;gap:1rem;padding:1.05rem 0;border-bottom:1px solid var(--line)}
.bd-bid-rail{position:relative;flex-shrink:0;width:9px;display:flex;justify-content:center;align-self:stretch}
.bd-bid-rail::before{content:'';position:absolute;top:16px;bottom:-17px;width:1px;background:var(--beige)}
.bd-bid:last-child .bd-bid-rail::before{display:none}
.bd-bid-dot{position:relative;z-index:1;width:9px;height:9px;margin-top:.4rem;background:var(--gold);transform:rotate(45deg)}
.bd-bid-dot.accepted{background:var(--sage)}
.bd-bid-dot.rejected{background:var(--burg)}
.bd-bid-info{flex:1;min-width:0}
.bd-bid-name{font-size:.86rem;font-weight:800;letter-spacing:-.01em}
.bd-bid-meta{margin-top:.2rem;font-size:.72rem;color:var(--taupe)}
.bd-bid-status{flex-shrink:0;padding:.28rem .55rem;border:1px solid transparent;border-left-width:2px;font-size:.54rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;white-space:nowrap}
.bd-bid-status.pending{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.bd-bid-status.accepted{background:#EFF2E8;color:#33502F;border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.bd-bid-status.rejected{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}

/* responsive */
@media(max-width:1100px){.bd-main{grid-template-columns:1fr;gap:2.5rem}}
@media(max-width:780px){
.bd-stats{grid-template-columns:1fr 1fr}
.bd-stat:nth-child(3){border-left:0}
.bd-stat:nth-child(n+3){border-top:1px solid var(--line)}
.bd-status-card{width:100%}
}
@media(max-width:560px){
.bd-fulfil-cards{grid-template-columns:1fr}
.bd-req{flex-wrap:wrap}
.bd-req-right{width:100%;justify-content:space-between;padding-left:84px}
.bd-priority-cta{width:100%;justify-content:center}
}
</style>
@endpush

@section('content')
@php
    $bakerRecordDash = \App\Models\Baker::where('user_id', auth()->id())->first();

    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

    $fulfillmentSet = (bool) ($bakerRecordDash?->accepts_delivery || $bakerRecordDash?->accepts_pickup);

    if ($profileIncomplete) {
        $priorityType = 'profile';
    } elseif (!$fulfillmentSet) {
        $priorityType = 'fulfillment';
    } elseif ($openRequestsCount > 0) {
        $priorityType = 'requests';
    } else {
        $priorityType = 'none';
    }

    $headerSub = match ($priorityType) {
        'profile'     => 'Finish setting up your profile so customers can find and trust you.',
        'fulfillment' => 'Set your delivery options below so you can start bidding.',
        'requests'    => $openRequestsCount . ' new cake ' . Str::plural('request', $openRequestsCount) . ' waiting for your offer.',
        default       => "Here's what's happening with your bakery today.",
    };

    // Rough profile-completion estimate for the progress bar.
    $bdTotalProfileFields = 5;
    $bdMissingCount = $profileIncomplete ? count($missingFields) : 0;
    $bdCompletedFields = max(0, $bdTotalProfileFields - $bdMissingCount);
    $bdProfilePct = $profileIncomplete ? (int) round(($bdCompletedFields / $bdTotalProfileFields) * 100) : 100;

    $bdDeliveryOn = (bool) $bakerRecordDash?->accepts_delivery;
    $bdPickupOn   = (bool) $bakerRecordDash?->accepts_pickup;
    $bdStatusSub = $fulfillmentSet
        ? implode(' + ', array_filter([$bdDeliveryOn ? 'Delivery' : null, $bdPickupOn ? 'Pickup' : null]))
        : 'Choose delivery or pickup to start bidding';
@endphp

<div class="bd">

    {{-- HEADER --}}
    <div class="bd-head bd-reveal r1">
        <div class="bd-head-left">
            <span class="bd-eyebrow">Baker workspace</span>
            <h1 class="bd-greeting">{{ $greeting }}, {{ auth()->user()->first_name }}</h1>
            <p class="bd-greeting-sub">{{ $headerSub }}</p>
        </div>

        <a href="#fulfillment-settings" class="bd-status-card">
            <div class="bd-status-label">Baker Status</div>
            <div class="bd-availability-row">
                <span class="bd-avail-dot {{ $fulfillmentSet ? 'is-on' : 'is-off' }}"></span>
                <span class="bd-availability-text">{{ $fulfillmentSet ? 'Accepting Orders' : 'Bidding Paused' }}</span>
            </div>
            <div class="bd-status-sub">{{ $bdStatusSub }}</div>
        </a>
    </div>

    {{-- PRIORITY / ACTION CENTER --}}
    <div class="bd-priority bd-reveal r2 state-{{ $priorityType }}">
        <div class="bd-priority-icon">
            @if($priorityType === 'profile')
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            @elseif($priorityType === 'fulfillment')
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5a2 2 0 0 1-2 2h-1"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            @elseif($priorityType === 'requests')
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            @endif
        </div>
        <div class="bd-priority-body">
            @if($priorityType === 'profile')
                <div class="bd-priority-title">Profile Setup</div>
                <div class="bd-priority-sub">Complete the details customers look for before choosing a baker.</div>
                <div class="bd-priority-progress">
                    <div class="bd-priority-progress-track"><div class="bd-priority-progress-fill" data-pct="{{ $bdProfilePct }}"></div></div>
                    <span class="bd-priority-progress-label">{{ $bdProfilePct }}% complete</span>
                </div>
            @elseif($priorityType === 'fulfillment')
                <div class="bd-priority-title">Order Fulfillment Required</div>
                <div class="bd-priority-sub">Choose delivery, pickup, or both. You can't place bids until at least one is on.</div>
            @elseif($priorityType === 'requests')
                <div class="bd-priority-title">New Cake Requests</div>
                <div class="bd-priority-sub">{{ $openRequestsCount }} {{ Str::plural('customer', $openRequestsCount) }} nearby {{ $openRequestsCount === 1 ? 'is' : 'are' }} looking for a baker. Review the details and send an offer.</div>
            @else
                <div class="bd-priority-title">Bakery Status: Ready</div>
                <div class="bd-priority-sub">You're all caught up. New cake requests will appear here.</div>
            @endif
        </div>
        @if($priorityType === 'profile')
        <a href="{{ route('baker.profile.index') }}" class="bd-priority-cta">Complete Profile <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        @elseif($priorityType === 'fulfillment')
        <a href="#fulfillment-settings" class="bd-priority-cta">Configure Fulfillment <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        @elseif($priorityType === 'requests')
        <a href="{{ route('baker.requests.index') }}" class="bd-priority-cta">View Requests <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        @endif
    </div>

    {{-- STATS (each links to its section) --}}
    <div class="bd-stats bd-reveal r3">
        <a href="{{ route('baker.requests.index') }}" class="bd-stat c1">
            <div class="bd-stat-top">
                <span class="bd-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg></span>
                <svg class="bd-stat-arrow" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
            <div class="bd-stat-value" data-count="{{ $openRequestsCount }}">0</div>
            <div class="bd-stat-label">Open Requests</div>
            <div class="bd-stat-foot">New cakes waiting</div>
            <div class="bd-stat-accent"></div>
        </a>
        <a href="{{ route('baker.bids.index') }}" class="bd-stat c2">
            <div class="bd-stat-top">
                <span class="bd-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></span>
                <svg class="bd-stat-arrow" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
            <div class="bd-stat-value" data-count="{{ $myActiveBidsCount }}">0</div>
            <div class="bd-stat-label">Active Bids</div>
            <div class="bd-stat-foot">Offers in review</div>
            <div class="bd-stat-accent"></div>
        </a>
        <a href="{{ route('baker.orders.index') }}" class="bd-stat c3">
            <div class="bd-stat-top">
                <span class="bd-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></span>
                <svg class="bd-stat-arrow" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
            <div class="bd-stat-value" data-count="{{ $activeOrdersCount }}">0</div>
            <div class="bd-stat-label">Orders in Progress</div>
            <div class="bd-stat-foot">Currently baking</div>
            <div class="bd-stat-accent"></div>
        </a>
        <a href="{{ route('baker.earnings.index') }}" class="bd-stat c4">
            <div class="bd-stat-top">
                <span class="bd-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg></span>
                <svg class="bd-stat-arrow" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
            <div class="bd-stat-value" data-count="{{ $monthEarnings }}" data-format="currency">₱0</div>
            <div class="bd-stat-label">Monthly Earnings</div>
            <div class="bd-stat-foot">{{ $completedThisMonth }} {{ Str::plural('order', $completedThisMonth) }} completed</div>
            <div class="bd-stat-accent"></div>
        </a>
    </div>

    {{-- MAIN GRID --}}
    <div class="bd-main bd-reveal r4">

        {{-- LEFT: open requests + earnings --}}
        <div class="bd-col">
            <section class="bd-panel">
                <div class="bd-panel-head">
                    <div class="bd-panel-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>Open Cake Requests</div>
                    <a href="{{ route('baker.requests.index') }}" class="bd-panel-link">View all</a>
                </div>
                @forelse($openRequests as $req)
                @php
                    $config = is_array($req->cake_configuration) ? $req->cake_configuration : (json_decode($req->cake_configuration, true) ?? []);
                    $bidCount = $req->bids()->count();
                    $reqBadgeParts = array_filter([$config['shape'] ?? null, $config['size'] ?? null, $config['frosting'] ?? null]);
                @endphp
                <a class="bd-req" href="{{ route('baker.requests.show', $req->id) }}">
                    <div class="bd-req-visual"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg></div>
                    <div class="bd-req-info">
                        <div class="bd-req-name">{{ $config['flavor'] ?? 'Custom' }} Cake</div>
                        <div class="bd-req-badges">
                            @foreach($reqBadgeParts as $part)
                            <span class="bd-req-badge">{{ $part }}</span>
                            @endforeach
                        </div>
                        <div class="bd-req-meta-row">
                            <span class="bd-req-meta-item"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>Due {{ $req->delivery_date->format('M d') }}</span>
                            @if($bidCount > 0)
                            <span class="bd-req-bids"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>{{ $bidCount }} {{ Str::plural('offer', $bidCount) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="bd-req-right">
                        <div>
                            <div class="bd-req-budget-val">₱{{ number_format($req->budget_min,0) }}–{{ number_format($req->budget_max,0) }}</div>
                            <div class="bd-req-budget-date">{{ $req->delivery_date->diffForHumans() }}</div>
                        </div>
                        <svg class="bd-req-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </div>
                </a>
                @empty
                <div class="bd-empty">
                    <div class="bd-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/></svg></div>
                    <div class="bd-empty-title">No open requests right now</div>
                    <div class="bd-empty-sub">New requests near you will show up here as soon as customers post them.</div>
                </div>
                @endforelse
            </section>

            <section class="bd-panel">
                <div class="bd-panel-head">
                    <div class="bd-panel-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg>Earnings</div>
                    <a href="{{ route('baker.earnings.index') }}" class="bd-panel-link">Details</a>
                </div>
                <div class="bd-earn-summary">
                    <div class="bd-earn-value">₱{{ number_format($monthEarnings, 0) }}</div>
                    <div class="bd-earn-label">This month · {{ $completedThisMonth }} {{ Str::plural('order', $completedThisMonth) }} completed</div>
                </div>
                @php $maxEarning = max(array_column($earningsChart, 'total') ?: [1]) ?: 1; @endphp
                <div class="bd-chart-wrap">
                    <div class="bd-chart">
                        @foreach($earningsChart as $month)
                        <div class="bd-bar-col">
                            <div class="bd-bar"
                                 data-h="{{ max(3, ($month['total'] / $maxEarning) * 128) }}"
                                 data-value="₱{{ number_format($month['total'], 0) }}"
                                 data-label="{{ $month['label'] }}"></div>
                        </div>
                        @endforeach
                    </div>
                    <div style="display:flex; gap:10px;">
                        @foreach($earningsChart as $month)
                        <div class="bd-bar-label" style="flex:1;">{{ $month['label'] }}</div>
                        @endforeach
                    </div>
                    <div class="bd-tooltip" id="bdChartTooltip"></div>
                </div>
            </section>
        </div>

        {{-- RIGHT: sidebar --}}
        <div class="bd-col">
            <section class="bd-panel" id="fulfillment-settings">
                <div class="bd-panel-head">
                    <div class="bd-panel-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5a2 2 0 0 1-2 2h-1"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>Order Fulfillment</div>
                </div>
                <div class="bd-fulfil-desc">How will customers receive their cakes? Select at least one.</div>
                <div class="bd-fulfil-cards">
                    <label class="bd-fulfil-card" for="pref-delivery">
                        <input type="checkbox" id="pref-delivery" {{ $bdDeliveryOn ? 'checked' : '' }} onchange="saveFulfillment()">
                        <span class="bd-fulfil-card-inner">
                            <span class="bd-fulfil-card-icon"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                            <span class="bd-fulfil-card-title">Delivery</span>
                            <span class="bd-fulfil-card-sub">Customer delivery</span>
                            <span class="bd-fulfil-card-tag">{{ $bdDeliveryOn ? 'Enabled' : 'Off' }}</span>
                        </span>
                    </label>
                    <label class="bd-fulfil-card" for="pref-pickup">
                        <input type="checkbox" id="pref-pickup" {{ $bdPickupOn ? 'checked' : '' }} onchange="saveFulfillment()">
                        <span class="bd-fulfil-card-inner">
                            <span class="bd-fulfil-card-icon"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/><path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4"/><path d="M9 14h6"/></svg></span>
                            <span class="bd-fulfil-card-title">Pickup</span>
                            <span class="bd-fulfil-card-sub">Store pickup</span>
                            <span class="bd-fulfil-card-tag">{{ $bdPickupOn ? 'Enabled' : 'Off' }}</span>
                        </span>
                    </label>
                </div>
                <div id="fulfillment-status" class="bd-fulfil-status {{ !$fulfillmentSet ? 'is-warn' : '' }}">
                    <svg id="fulfillment-status-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        @if(!$fulfillmentSet)
                        <path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                        @else
                        <polyline points="20 6 9 17 4 12"/>
                        @endif
                    </svg>
                    <span id="fulfillment-status-text">{{ !$fulfillmentSet ? "Select at least one. You can't bid until this is set." : 'Ready to bid · Saved automatically' }}</span>
                </div>
            </section>

            <section class="bd-panel">
                @if($profileIncomplete)
                <div class="bd-panel-head">
                    <div class="bd-panel-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Baker Profile</div>
                </div>
                <div class="bd-profile-body">
                    <div class="bd-profile-pct">
                        <span class="bd-profile-pct-val">{{ $bdProfilePct }}%</span>
                        <span class="bd-profile-pct-label">ready</span>
                    </div>
                    <div class="bd-progress-track">
                        @for($i = 0; $i < $bdTotalProfileFields; $i++)
                        <div class="layer">
                            @if(($i + 1) * (100 / $bdTotalProfileFields) <= $bdProfilePct)
                            <div class="bd-progress-fill"></div>
                            @endif
                        </div>
                        @endfor
                    </div>
                    <div class="bd-profile-chips">
                        @foreach($missingFields as $field)
                        <span class="bd-chip">{{ $field }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('baker.profile.index') }}" class="bd-profile-cta">Complete profile <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                </div>
                @else
                <div class="bd-panel-head">
                    <div class="bd-panel-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Baker Profile</div>
                </div>
                <div class="bd-profile-ready">
                    <div class="bd-ready-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                    <div>
                        <div class="bd-ready-title">Your profile is ready</div>
                        <div class="bd-ready-sub">Customers can now view your baker profile.</div>
                    </div>
                </div>
                @endif
            </section>

            <section class="bd-panel">
                <div class="bd-panel-head">
                    <div class="bd-panel-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>Recent Bids</div>
                    <a href="{{ route('baker.bids.index') }}" class="bd-panel-link">All bids</a>
                </div>
                @forelse($recentBids as $bid)
                <div class="bd-bid">
                    <div class="bd-bid-rail"><div class="bd-bid-dot {{ strtolower($bid->status) }}"></div></div>
                    <div class="bd-bid-info">
                        <div class="bd-bid-name">#{{ str_pad($bid->cake_request_id, 4, '0', STR_PAD_LEFT) }} · {{ $bid->cakeRequest->cake_configuration['flavor'] ?? 'Cake' }}</div>
                        <div class="bd-bid-meta">Your offer · ₱{{ number_format($bid->amount, 0) }} · {{ $bid->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="bd-bid-status {{ strtolower($bid->status) }}">{{ $bid->status }}</span>
                </div>
                @empty
                <div class="bd-empty">
                    <div class="bd-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></div>
                    <div class="bd-empty-title">No bids placed yet</div>
                    <div class="bd-empty-sub">Offers you send will appear here.</div>
                </div>
                @endforelse
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function saveFulfillment() {
    const delivery = document.getElementById('pref-delivery').checked;
    const pickup   = document.getElementById('pref-pickup').checked;
    const statusEl = document.getElementById('fulfillment-status');
    const statusText = document.getElementById('fulfillment-status-text');
    const statusIcon = document.getElementById('fulfillment-status-icon');

    fetch('{{ route("baker.toggle-rush") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ accepts_delivery: delivery, accepts_pickup: pickup })
    });

    const availDot = document.querySelector('.bd-avail-dot');
    const availText = document.querySelector('.bd-availability-text');
    const statusSub = document.querySelector('.bd-status-sub');

    // Reflect selection on the feature cards themselves
    document.querySelectorAll('.bd-fulfil-card').forEach(card => {
        const tag = card.querySelector('.bd-fulfil-card-tag');
        const input = card.querySelector('input');
        if (tag && input) tag.textContent = input.checked ? 'Enabled' : 'Off';
    });

    if (!delivery && !pickup) {
        statusEl.classList.add('is-warn');
        statusText.textContent = "Select at least one. You can't bid until this is set.";
        statusIcon.innerHTML = '<path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"></path>';
        if (availDot) { availDot.classList.remove('is-on'); availDot.classList.add('is-off'); }
        if (availText) availText.textContent = 'Bidding Paused';
        if (statusSub) statusSub.textContent = 'Choose delivery or pickup to start bidding';
    } else {
        statusEl.classList.remove('is-warn');
        const label = (delivery && pickup) ? 'Delivery + Pickup' : (delivery ? 'Delivery' : 'Pickup');
        statusText.textContent = 'Ready to bid · Saved automatically';
        statusIcon.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
        if (availDot) { availDot.classList.remove('is-off'); availDot.classList.add('is-on'); }
        if (availText) availText.textContent = 'Accepting Orders';
        if (statusSub) statusSub.textContent = label;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Count-up stats
    document.querySelectorAll('.bd-stat-value[data-count]').forEach(el => {
        const target = parseFloat(el.dataset.count) || 0;
        const isCurrency = el.dataset.format === 'currency';
        const duration = 900;
        const start = performance.now();
        function tick(now) {
            const progress = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = Math.round(target * eased);
            el.textContent = isCurrency ? ('₱' + value.toLocaleString('en-PH')) : value.toLocaleString('en-PH');
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    });

    // Profile progress bar (priority banner)
    const priorityFill = document.querySelector('.bd-priority-progress-fill');
    if (priorityFill) {
        const pct = priorityFill.dataset.pct || 0;
        requestAnimationFrame(() => { priorityFill.style.width = pct + '%'; });
    }

    // Earnings chart bars + tooltip
    const tooltip = document.getElementById('bdChartTooltip');
    const chartWrap = document.querySelector('.bd-chart-wrap');
    document.querySelectorAll('.bd-bar').forEach((bar, i) => {
        const h = bar.dataset.h;
        setTimeout(() => { bar.style.height = h + 'px'; }, 150 + i * 70);

        bar.addEventListener('mouseenter', () => {
            if (!tooltip || !chartWrap) return;
            tooltip.textContent = bar.dataset.value + ' · ' + bar.dataset.label;
            const barRect = bar.getBoundingClientRect();
            const wrapRect = chartWrap.getBoundingClientRect();
            tooltip.style.left = (barRect.left - wrapRect.left + barRect.width / 2) + 'px';
            tooltip.style.top = (barRect.top - wrapRect.top) + 'px';
            tooltip.classList.add('show');
        });
        bar.addEventListener('mouseleave', () => {
            if (tooltip) tooltip.classList.remove('show');
        });
    });
});
</script>
@endpush