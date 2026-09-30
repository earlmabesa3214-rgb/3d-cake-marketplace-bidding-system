@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
<style>
*{font-family:'Plus Jakarta Sans',sans-serif;}
.db{display:flex;flex-direction:column;gap:1.25rem;padding-bottom:3rem;animation:dbIn .35s ease both;}
@keyframes dbIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
@keyframes grow{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}
.num{font-variant-numeric:tabular-nums;}

/* Operations header */
.ops-head{display:flex;justify-content:space-between;align-items:flex-end;gap:1rem;padding:1.5rem 1.75rem;background:var(--espresso);border-radius:var(--rl);border-bottom:2px solid var(--champ);}
.ops-kicker{display:flex;align-items:center;gap:.5rem;font-size:.68rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--gold-light);}
.live-dot{width:6px;height:6px;border-radius:50%;background:var(--gold-light);animation:pulse 2.5s infinite;}
.ops-title{font-size:clamp(1.4rem,2.6vw,1.9rem);font-weight:800;letter-spacing:-.025em;color:#F7F2E9;line-height:1.15;margin-top:.5rem;}
.ops-greet{font-size:.8rem;color:rgba(247,242,233,.5);margin-top:.35rem;}
.ops-clock{text-align:right;flex-shrink:0;padding-left:1.25rem;border-left:1px solid rgba(255,255,255,.12);}
.ops-time{font-size:1.4rem;font-weight:700;color:#F7F2E9;letter-spacing:.02em;font-variant-numeric:tabular-nums;}
.ops-date{font-size:.7rem;color:rgba(247,242,233,.45);margin-top:.15rem;}

/* Attention band */
.alert-band{display:flex;align-items:center;flex-wrap:wrap;gap:.5rem 1.25rem;padding:.7rem 1.1rem;background:var(--amber-soft);border:1px solid #E4CD97;border-left:3px solid var(--amber);border-radius:var(--r);font-size:.8rem;color:#5E4210;}
.alert-band strong{display:flex;align-items:center;gap:.4rem;font-weight:800;}
.alert-band a,.alert-band span.ai{font-weight:600;color:#5E4210;text-decoration:none;padding-left:1.25rem;border-left:1px solid #E4CD97;}
.alert-band a:hover{text-decoration:underline;}

/* KPI strip */
.kpi-strip{display:grid;grid-template-columns:repeat(4,1fr);background:var(--surface);border:1px solid var(--border);border-radius:var(--rl);overflow:hidden;}
.kpi{padding:1.15rem 1.25rem 1rem;border-right:1px solid var(--border);}
.kpi:last-child{border-right:none;}
.kpi-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:.9rem;}
.kpi-lbl{display:flex;align-items:center;gap:.45rem;font-size:.68rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.12em;}
.kpi-lbl svg,.kpi-lbl .peso{color:var(--champ);flex-shrink:0;}
.peso{font-size:.85rem;font-weight:800;line-height:1;}
.kpi-val{font-size:2.15rem;font-weight:800;letter-spacing:-.04em;color:var(--espresso);line-height:1;font-variant-numeric:tabular-nums;}
.kpi-chip{font-size:.66rem;font-weight:700;padding:.15rem .5rem;border-radius:3px;border:1px solid transparent;}
.kpi-chip.up{background:var(--teal-soft);color:var(--teal);border-color:#B9D0C0;}
.kpi-chip.warn{background:var(--amber-soft);color:#7A5410;border-color:#E4CD97;}
.kpi-chip.muted{background:var(--surface-3);color:var(--text-muted);border-color:var(--border-md);}
.kpi-line{height:2px;background:var(--surface-3);margin-top:1rem;}
.kpi-line i{display:block;height:100%;background:var(--champ);transform-origin:left;animation:grow .9s ease both .15s;}

/* Marketplace monitor */
.monitor{background:var(--espresso);border-radius:var(--rl);overflow:hidden;border:1px solid var(--choc);}
.monitor-head{display:flex;justify-content:space-between;align-items:center;padding:.85rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.03);}
.monitor-title{display:flex;align-items:center;gap:.55rem;font-size:.78rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#F7F2E9;}
.monitor-tag{font-size:.64rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--gold-light);border:1px solid rgba(211,183,126,.35);padding:.2rem .55rem;border-radius:3px;}
.monitor-grid{display:grid;grid-template-columns:repeat(5,1fr);}
.m-cell{padding:1.1rem 1.25rem;border-right:1px solid rgba(255,255,255,.07);position:relative;}
.m-cell:last-child{border-right:none;}
.m-cell::before{content:'';position:absolute;left:0;top:0;width:100%;height:2px;background:transparent;}
.m-cell.warn::before{background:#C9973A;}
.m-cell.good::before{background:#5E9478;}
.m-num{font-size:1.9rem;font-weight:800;color:#F7F2E9;letter-spacing:-.03em;line-height:1;font-variant-numeric:tabular-nums;}
.m-cell.warn .m-num{color:#E8C27A;}
.m-cell.good .m-num{color:#9CC7AE;}
.m-lbl{font-size:.66rem;font-weight:600;color:rgba(247,242,233,.5);text-transform:uppercase;letter-spacing:.1em;margin-top:.55rem;}

/* Body */
.db-body{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:1.25rem;align-items:start;}
.col{display:flex;flex-direction:column;gap:1.25rem;min-width:0;}
.panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--rl);overflow:hidden;}
.panel-head{display:flex;align-items:center;justify-content:space-between;padding:.8rem 1.15rem;border-bottom:1px solid var(--border);background:var(--surface-2);}
.panel-title{font-size:.72rem;font-weight:800;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.12em;}
.plink{display:inline-flex;align-items:center;gap:.25rem;font-size:.74rem;font-weight:700;color:var(--gold-dark);text-decoration:none;}
.plink:hover{color:var(--espresso);}
.panel-body{padding:1.1rem 1.15rem;}
.empty{padding:2.25rem;text-align:center;color:var(--text-muted);font-size:.82rem;}

/* Table */
.tbl-wrap{overflow-x:auto;}
.otable{width:100%;border-collapse:collapse;min-width:520px;}
.otable thead th{padding:.6rem 1.15rem;font-size:.66rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.12em;white-space:nowrap;text-align:left;background:var(--surface-3);border-bottom:1px solid var(--border-md);position:sticky;top:0;}
.otable thead th.r{text-align:right;}.otable thead th.c{text-align:center;}
.otable tbody tr{border-bottom:1px solid var(--border);transition:background .12s;}
.otable tbody tr:last-child{border-bottom:none;}
.otable tbody tr:hover{background:var(--surface-2);}
.otable tbody td{padding:.7rem 1.15rem;vertical-align:middle;font-size:.85rem;}
.o-num{font-size:.78rem;font-weight:700;color:var(--gold-dark);font-variant-numeric:tabular-nums;letter-spacing:.02em;}
.o-cust{font-weight:700;color:var(--espresso);}
.o-meta{font-size:.72rem;color:var(--text-muted);margin-top:1px;}
.o-amt{font-weight:800;color:var(--espresso);text-align:right;font-variant-numeric:tabular-nums;white-space:nowrap;}
.badge{display:inline-flex;align-items:center;gap:.35rem;padding:.18rem .55rem;border-radius:3px;font-size:.66rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;border:1px solid var(--border-md);background:var(--surface-3);color:#6F6052;}
.badge::before{content:'';width:5px;height:5px;border-radius:50%;background:currentColor;flex-shrink:0;}
.badge.pending{background:var(--amber-soft);border-color:#E4CD97;color:#7A5410;}
.badge.confirmed,.badge.ready{background:var(--info-soft);border-color:#B7D0D5;color:var(--info);}
.badge.baking{background:#F6EADF;border-color:#E0C3A8;color:#8A5330;}
.badge.delivered,.badge.completed{background:var(--teal-soft);border-color:#B9D0C0;color:var(--teal);}
.badge.cancelled{background:var(--rose-soft);border-color:#DDB9BD;color:var(--rose);}

/* Admin tools */
.tools{display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));}
.tool{display:flex;align-items:center;gap:.8rem;padding:.9rem 1.15rem;text-decoration:none;border-right:1px solid var(--border);border-bottom:1px solid var(--border);transition:background .15s;position:relative;}
.tool:hover{background:var(--gold-soft);}
.tool::before{content:'';position:absolute;left:0;top:0;bottom:0;width:2px;background:transparent;transition:background .15s;}
.tool:hover::before{background:var(--champ);}
.tool-ic{width:30px;height:30px;border:1px solid var(--border-md);border-radius:5px;display:flex;align-items:center;justify-content:center;color:var(--deep);flex-shrink:0;background:var(--surface-2);}
.tool-cat{font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--gold-dark);}
.tool-lbl{font-size:.85rem;font-weight:700;color:var(--espresso);margin-top:1px;}
.tool-sub{font-size:.72rem;color:var(--text-muted);margin-top:1px;}

/* Side panels */
.rev-val{font-size:1.9rem;font-weight:800;letter-spacing:-.04em;color:var(--espresso);font-variant-numeric:tabular-nums;}
.rev-trend{display:flex;align-items:center;gap:.3rem;font-size:.76rem;color:var(--teal);font-weight:700;margin:.25rem 0 1rem;}
.sparkbars{display:flex;align-items:flex-end;gap:3px;height:48px;}
.sbar{flex:1;min-height:3px;background:var(--cream);border-top:2px solid var(--beige);transition:background .15s;transform-origin:bottom;animation:barUp .7s ease both;}
@keyframes barUp{from{transform:scaleY(0)}to{transform:scaleY(1)}}
.sbar:hover,.sbar.cur{background:var(--champ);border-top-color:var(--gold-dark);}
.rev-stats{display:grid;grid-template-columns:1fr 1fr;border:1px solid var(--border);margin-top:1rem;border-radius:var(--r);overflow:hidden;}
.rev-tile{padding:.65rem .8rem;}
.rev-tile+.rev-tile{border-left:1px solid var(--border);}
.rev-tile-lbl{font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--text-muted);}
.rev-tile-val{font-size:1.1rem;font-weight:800;color:var(--espresso);margin-top:.15rem;font-variant-numeric:tabular-nums;}
.pop-block{margin-bottom:1.1rem;}.pop-block:last-child{margin-bottom:0;}
.pop-block-title{font-size:.64rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.12em;margin-bottom:.4rem;padding-bottom:.4rem;border-bottom:1px solid var(--border);}
.pop-cake-row{display:flex;align-items:center;justify-content:space-between;padding:.4rem 0;}
.pop-cake-name{display:flex;align-items:center;gap:.55rem;font-size:.84rem;font-weight:700;color:var(--espresso);}
.pop-rank{width:20px;height:20px;border:1px solid var(--champ);color:var(--gold-dark);font-size:.68rem;font-weight:800;display:flex;align-items:center;justify-content:center;border-radius:3px;flex-shrink:0;}
.pop-cake-count{font-size:.76rem;font-weight:600;color:var(--text-muted);font-variant-numeric:tabular-nums;}
.pop-size-row{margin-bottom:.6rem;}.pop-size-row:last-child{margin-bottom:0;}
.pop-size-top{display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:.3rem;}
.pop-size-name{font-weight:700;color:var(--text-secondary);}
.pop-size-pct{font-weight:800;color:var(--gold-dark);font-variant-numeric:tabular-nums;}
.pop-size-bar{height:3px;background:var(--surface-3);}
.pop-size-fill{height:100%;background:var(--champ);transform-origin:left;animation:grow .9s ease both .2s;}
.baker-list{display:flex;flex-direction:column;}
.baker-row{display:flex;align-items:center;gap:.7rem;padding:.6rem 0;border-bottom:1px solid var(--border);text-decoration:none;transition:background .12s;}
.baker-row:last-child{border-bottom:none;}
.baker-row:hover .baker-name{color:var(--gold-dark);}
.baker-ava{width:30px;height:30px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.62rem;color:#F7F2E9;flex-shrink:0;}
.baker-name{font-size:.85rem;font-weight:700;color:var(--espresso);}
.baker-meta{font-size:.72rem;color:var(--text-muted);}
.bstatus{font-size:.62rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:.15rem .5rem;border-radius:3px;white-space:nowrap;border:1px solid var(--border-md);background:var(--surface-3);color:#6F6052;}
.bstatus.pending{background:var(--amber-soft);border-color:#E4CD97;color:#7A5410;}
.bstatus.approved{background:var(--teal-soft);border-color:#B9D0C0;color:var(--teal);}
.bstatus.rejected{background:var(--rose-soft);border-color:#DDB9BD;color:var(--rose);}
.ing-row{display:flex;align-items:center;justify-content:space-between;padding:.42rem 0;border-bottom:1px solid var(--border);}
.ing-row:last-child{border-bottom:none;}
.ing-cat{display:flex;align-items:center;gap:.5rem;font-size:.82rem;font-weight:600;color:var(--text-secondary);}
.ing-dot{width:7px;height:7px;border-radius:2px;flex-shrink:0;}
.ing-cnt{font-size:.78rem;font-weight:700;color:var(--text-muted);font-variant-numeric:tabular-nums;}

@media(max-width:1180px){.db-body{grid-template-columns:1fr;}.monitor-grid{grid-template-columns:repeat(3,1fr);}.m-cell:nth-child(3){border-right:none;}.m-cell:nth-child(n+4){border-top:1px solid rgba(255,255,255,.07);}}
@media(max-width:900px){.kpi-strip{grid-template-columns:repeat(2,1fr);}.kpi:nth-child(2){border-right:none;}.kpi:nth-child(n+3){border-top:1px solid var(--border);}}
@media(max-width:640px){.ops-head{padding:1.15rem;}.ops-clock{display:none;}.monitor-grid{grid-template-columns:repeat(2,1fr);}.m-cell:nth-child(3){border-right:1px solid rgba(255,255,255,.07);}.m-cell:nth-child(2n){border-right:none;}.kpi-val{font-size:1.7rem;}.alert-band a,.alert-band span.ai{padding-left:0;border-left:none;}}
@media(prefers-reduced-motion:reduce){.db,.kpi-line i,.sbar,.pop-size-fill{animation:none!important;}}
</style>
@endpush

@section('content')
@php
    $iconStroke = 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
@endphp
<div class="db">

    {{-- Operations header --}}
    <header class="ops-head">
        <div>
            <div class="ops-kicker"><span class="live-dot"></span> BakeSphere Operations</div>
            <h1 class="ops-title">System activity at a glance</h1>
            <p class="ops-greet">{{ now()->hour < 12 ? 'Good morning' : (now()->hour < 18 ? 'Good afternoon' : 'Good evening') }}, {{ Auth::user()->first_name ?? 'Admin' }}.</p>
        </div>
        <div class="ops-clock">
            <div class="ops-time" id="liveTime">--:--</div>
            <div class="ops-date">{{ now()->format('D, M j Y') }}</div>
        </div>
    </header>

    {{-- Attention band --}}
    @if($stats['pending_bakers'] > 0 || $marketplace['awaiting_baker'] > 0 || $stats['pending_orders'] > 0)
    <div class="alert-band">
        <strong><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Needs attention</strong>
        @if($stats['pending_bakers'] > 0)<a href="{{ route('bakers.index') }}">{{ $stats['pending_bakers'] }} baker application{{ $stats['pending_bakers'] == 1 ? '' : 's' }} awaiting review</a>@endif
        @if($marketplace['awaiting_baker'] > 0)<span class="ai">{{ $marketplace['awaiting_baker'] }} request{{ $marketplace['awaiting_baker'] == 1 ? '' : 's' }} awaiting a baker</span>@endif
        @if($stats['pending_orders'] > 0)<a href="{{ route('admin.transactions.index') }}">{{ $stats['pending_orders'] }} pending order{{ $stats['pending_orders'] == 1 ? '' : 's' }}</a>@endif
    </div>
    @endif

    {{-- Executive metrics --}}
    <section class="kpi-strip">
        <div class="kpi">
            <div class="kpi-top">
                <span class="kpi-lbl"><svg width="14" height="14" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg> Total Orders</span>
                <span class="kpi-chip {{ $stats['pending_orders']>0?'warn':'muted' }}">{{ $stats['pending_orders'] }} pending</span>
            </div>
            <div class="kpi-val">{{ $stats['total_orders'] }}</div>
            <div class="kpi-line"><i style="width:{{ min(100,$stats['total_orders']*5) }}%"></i></div>
        </div>
        <div class="kpi">
            <div class="kpi-top">
                <span class="kpi-lbl"><span class="peso">₱</span> Monthly Revenue</span>
                <span class="kpi-chip up">This month</span>
            </div>
            <div class="kpi-val">₱{{ number_format($stats['monthly_revenue'],0) }}</div>
            <div class="kpi-line"><i style="width:72%"></i></div>
        </div>
        <div class="kpi">
            <div class="kpi-top">
                <span class="kpi-lbl"><svg width="14" height="14" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> Bakers</span>
                <span class="kpi-chip {{ $stats['pending_bakers']>0?'warn':'muted' }}">{{ $stats['pending_bakers'] }} awaiting</span>
            </div>
            <div class="kpi-val">{{ $stats['total_bakers'] }}</div>
            <div class="kpi-line"><i style="width:{{ min(100,$stats['total_bakers']*8) }}%"></i></div>
        </div>
        <div class="kpi">
            <div class="kpi-top">
                <span class="kpi-lbl"><svg width="14" height="14" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Customers</span>
                <span class="kpi-chip muted">Registered</span>
            </div>
            <div class="kpi-val">{{ $stats['total_customers'] }}</div>
            <div class="kpi-line"><i style="width:{{ min(100,$stats['total_customers']*4) }}%"></i></div>
        </div>
    </section>

    {{-- Marketplace monitor --}}
    <section class="monitor">
        <div class="monitor-head">
            <div class="monitor-title"><span class="live-dot"></span> Marketplace Activity</div>
            <span class="monitor-tag">Reverse bidding</span>
        </div>
        <div class="monitor-grid">
            <div class="m-cell"><div class="m-num">{{ $marketplace['active_requests'] }}</div><div class="m-lbl">Active Cake Requests</div></div>
            <div class="m-cell"><div class="m-num">{{ $marketplace['active_bids'] }}</div><div class="m-lbl">Active Bids</div></div>
            <div class="m-cell warn"><div class="m-num">{{ $marketplace['awaiting_baker'] }}</div><div class="m-lbl">Awaiting Baker</div></div>
            <div class="m-cell good"><div class="m-num">{{ $marketplace['awarded_today'] }}</div><div class="m-lbl">Awarded Today</div></div>
            <div class="m-cell"><div class="m-num">{{ number_format($marketplace['avg_bids_per_request'], 1) }}</div><div class="m-lbl">Avg. Bids / Request</div></div>
        </div>
    </section>

    <div class="db-body">
        <div class="col">

            {{-- Recent transactions --}}
            <section class="panel">
                <div class="panel-head">
                    <div class="panel-title">Recent Transactions</div>
                    <a href="{{ route('admin.transactions.index') }}" class="plink">View all <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a>
                </div>
                @if($recent_orders->isEmpty())
                <div class="empty">No transactions yet.</div>
                @else
                <div class="tbl-wrap">
                <table class="otable">
                    <thead><tr><th>Ref #</th><th>Customer</th><th class="c">Status</th><th class="r">Amount</th></tr></thead>
                    <tbody>
                        @foreach($recent_orders as $o)
                        <tr>
                            <td><span class="o-num">#{{ str_pad($o->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                            <td>
                                <div class="o-cust">{{ $o->cakeRequest->user->first_name ?? '' }} {{ $o->cakeRequest->user->last_name ?? 'Unknown' }}</div>
                                <div class="o-meta">{{ $o->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="c" style="text-align:center;">
                                <span class="badge {{ strtolower($o->status) }}">{{ str_replace('_', ' ', ucfirst(strtolower($o->status))) }}</span>
                            </td>
                            <td class="o-amt">₱{{ number_format($o->agreed_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @endif
            </section>

            {{-- Administrative tools (existing routes only) --}}
            <section class="panel">
                <div class="panel-head"><div class="panel-title">Administrative Tools</div></div>
                <div class="tools">
                    <a href="{{ route('ingredients.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></span><span><div class="tool-cat">Catalog</div><div class="tool-lbl">Add Ingredient</div><div class="tool-sub">Expand catalog</div></span></a>
                    <a href="{{ route('products.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg></span><span><div class="tool-cat">Catalog</div><div class="tool-lbl">New Product</div><div class="tool-sub">Add to cake menu</div></span></a>
                    <a href="{{ route('bakers.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></span><span><div class="tool-cat">People</div><div class="tool-lbl">Review Bakers</div><div class="tool-sub">{{ $stats['pending_bakers'] }} pending</div></span></a>
                    <a href="{{ route('customers.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span><span><div class="tool-cat">Customers</div><div class="tool-lbl">Customer Registry</div><div class="tool-sub">View registry</div></span></a>
                    <a href="{{ route('admin.wallet.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></span><span><div class="tool-cat">Finance</div><div class="tool-lbl">Wallets</div><div class="tool-sub">Balances and cash-ins</div></span></a>
                    <a href="{{ route('admin.escrow.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span><span><div class="tool-cat">Finance</div><div class="tool-lbl">Escrow</div><div class="tool-sub">Held payments</div></span></a>
                    <a href="{{ route('admin.transactions.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></span><span><div class="tool-cat">Finance</div><div class="tool-lbl">Transactions</div><div class="tool-sub">All baker orders</div></span></a>
                    <a href="{{ route('reports.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span><span><div class="tool-cat">Reporting</div><div class="tool-lbl">Sales Reports</div><div class="tool-sub">Revenue analytics</div></span></a>
                    <a href="{{ route('admin.reports.index') }}" class="tool"><span class="tool-ic"><svg width="15" height="15" viewBox="0 0 24 24" {!! $iconStroke !!}><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span><span><div class="tool-cat">Reporting</div><div class="tool-lbl">User Reports</div><div class="tool-sub">Baker and customer complaints</div></span></a>
                </div>
            </section>
        </div>

        <div class="col">
            {{-- Revenue --}}
            <section class="panel">
                <div class="panel-head">
                    <div class="panel-title">Revenue</div>
                    <span style="font-size:.7rem;font-weight:600;color:var(--text-muted);">{{ now()->format('M Y') }}</span>
                </div>
                <div class="panel-body">
                    <div class="rev-val">₱{{ number_format($stats['monthly_revenue'],0) }}</div>
                    <div class="rev-trend"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg> Revenue this month</div>
                    <div class="sparkbars">
                        @foreach([35,52,40,68,55,78,100] as $i=>$h)
                        <div class="sbar {{ $i===6?'cur':'' }}" style="height:{{ $h }}%;animation-delay:{{ .05*$i }}s"></div>
                        @endforeach
                    </div>
                    <div class="rev-stats">
                        <div class="rev-tile"><div class="rev-tile-lbl">Orders</div><div class="rev-tile-val">{{ $stats['total_orders'] }}</div></div>
                        <div class="rev-tile"><div class="rev-tile-lbl">Avg. Order</div><div class="rev-tile-val">₱{{ $stats['total_orders']>0?number_format($stats['monthly_revenue']/max($stats['total_orders'],1),0):'0' }}</div></div>
                    </div>
                </div>
            </section>

            {{-- Popular customizations --}}
            <section class="panel">
                <div class="panel-head"><div class="panel-title">Popular Customizations</div></div>
                <div class="panel-body">
                    <div class="pop-block">
                        <div class="pop-block-title">Top Cake Types</div>
                        @foreach($popular_cakes as $i => $cake)
                        <div class="pop-cake-row">
                            <div class="pop-cake-name"><span class="pop-rank">{{ $i+1 }}</span>{{ $cake->name }}</div>
                            <span class="pop-cake-count">{{ $cake->order_count }} orders</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="pop-block">
                        <div class="pop-block-title">Popular Sizes</div>
                        @foreach($popular_sizes as $size)
                        <div class="pop-size-row">
                            <div class="pop-size-top"><span class="pop-size-name">{{ $size->name }}</span><span class="pop-size-pct">{{ $size->percentage }}%</span></div>
                            <div class="pop-size-bar"><div class="pop-size-fill" style="width:{{ $size->percentage }}%"></div></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Baker applications --}}
            @if($pending_bakers->count()>0)
            <section class="panel">
                <div class="panel-head">
                    <div class="panel-title">Baker Applications</div>
                    <a href="{{ route('bakers.index') }}" class="plink">All <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a>
                </div>
                <div class="panel-body" style="padding-top:.5rem;padding-bottom:.5rem;">
                    <div class="baker-list">
                        @foreach($pending_bakers as $baker)
                        @php $bg=['#4A2A1A','#2F5D46','#54252C','#A96F42'][$loop->index%4]; @endphp
                        <a href="{{ route('bakers.index') }}" class="baker-row">
                            <div class="baker-ava" style="background:{{ $bg }}">{{ strtoupper(substr($baker->first_name ?? $baker->name ?? 'B',0,2)) }}</div>
                            <div style="flex:1;min-width:0;"><div class="baker-name">{{ $baker->first_name ?? $baker->name }}</div><div class="baker-meta">{{ $baker->created_at->diffForHumans() }}</div></div>
                            <span class="bstatus {{ $baker->status }}">{{ ucfirst($baker->status) }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            {{-- Ingredients --}}
            <section class="panel">
                <div class="panel-head">
                    <div class="panel-title">Ingredients</div>
                    <a href="{{ route('ingredients.index') }}" class="plink">Manage <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a>
                </div>
                <div class="panel-body" style="padding-top:.6rem;padding-bottom:.6rem;">
                    @php
                        $catColors=['shape'=>'#B89452','flavor'=>'#7A2A32','frosting'=>'#A8741A','drip'=>'#2F5D46','fruit'=>'#A96F42','choco'=>'#4A2A1A','sprinkle'=>'#D3B77E','candle'=>'#8A6B30','deco'=>'#2F5F6B'];
                        $catNames=['shape'=>'Cake Shape','flavor'=>'Flavors','frosting'=>'Frosting','drip'=>'Drips','fruit'=>'Fruits','choco'=>'Choco Decor','sprinkle'=>'Sprinkles','candle'=>'Candles','deco'=>'Decor'];
                        $grouped=$ingredients->groupBy('category');
                    @endphp
                    @if($grouped->isEmpty())
                    <p style="text-align:center;color:var(--text-muted);font-size:.8rem;padding:.5rem 0;">No ingredients yet. <a href="{{ route('ingredients.index') }}" style="color:var(--gold-dark);font-weight:700;">Add one</a></p>
                    @else
                    <div>
                        @foreach($catColors as $cat=>$clr)
                        @php $n=$grouped->get($cat,collect())->count(); @endphp
                        @if($n>0)
                        <div class="ing-row"><span class="ing-cat"><span class="ing-dot" style="background:{{ $clr }}"></span>{{ $catNames[$cat] ?? $cat }}</span><span class="ing-cnt">{{ $n }}</span></div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function tick(){
    const el=document.getElementById('liveTime');
    if(el) el.textContent=new Date().toLocaleTimeString('en-PH',{hour:'2-digit',minute:'2-digit',second:'2-digit'});
    setTimeout(tick,1000);
})();
</script>
@endpush
@endsection