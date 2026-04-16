@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
<style>
:root{--gold:#C07828;--gold-dark:#9A5E14;--gold-light:#DC9E48;--gold-soft:#FEF3E2;--gold-glow:rgba(192,120,40,.16);--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;--rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;--t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--bg:#F5F0E8;--s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;--r:10px;--rl:14px;--rxl:18px;}
*{font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}
.db{padding:0 0 5rem;}
.hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2.25rem 2.25rem 5rem;position:relative;overflow:hidden;}
.hero::before{content:'';position:absolute;inset:0;opacity:.03;background-image:radial-gradient(circle, #fff 1px, transparent 1px);background-size:28px 28px;}
.hero::after{content:'';position:absolute;right:-60px;top:-60px;width:300px;height:300px;background:radial-gradient(circle,rgba(192,120,40,.18),transparent 65%);border-radius:50%;}
.hero-inner{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;position:relative;z-index:1;}

.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; font-weight:800; color:var(--brown-deep); margin-bottom:0.25rem; }
    .page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem; }
.hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:.5rem;letter-spacing:-.02em;}
.hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero-sub{font-size:.9rem;color:rgba(255,255,255,.55);line-height:1.6;}
.hero-clock{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.11);border-radius:var(--rl);padding:.75rem 1.125rem;text-align:right;flex-shrink:0;min-width:120px;}
.hero-time{font-family:'DM Mono',monospace;font-size:1.375rem;font-weight:500;color:#fff;letter-spacing:.02em;}
.hero-date{font-size:.65rem;color:rgba(255,255,255,.38);margin-top:.25rem;}
.kpi-row{display:grid;grid-template-columns:repeat(4,1fr);gap:.875rem;padding:0 1.75rem;margin-top:-2.875rem;position:relative;z-index:10;}
.kpi-card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);padding:1.25rem 1.125rem;box-shadow:0 6px 24px rgba(50,20,0,.12);transition:transform .18s,box-shadow .18s;animation:fadeUp .5s ease both;}
.kpi-card:hover{transform:translateY(-2px);box-shadow:0 14px 36px rgba(50,20,0,.14);}
.kpi-card:nth-child(1){animation-delay:.05s}.kpi-card:nth-child(2){animation-delay:.1s}.kpi-card:nth-child(3){animation-delay:.15s}.kpi-card:nth-child(4){animation-delay:.2s}
.kpi-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:.875rem;}
.kpi-ic{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;}
.kpi-card:nth-child(1) .kpi-ic{background:var(--gold-soft);color:var(--gold);}
.kpi-card:nth-child(2) .kpi-ic{background:var(--teal-soft);color:var(--teal);}
.kpi-card:nth-child(3) .kpi-ic{background:#FDEEE4;color:var(--copper);}
.kpi-card:nth-child(4) .kpi-ic{background:var(--rose-soft);color:var(--rose);}
.kpi-chip{font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:20px;}
.kpi-chip.up{background:var(--teal-soft);color:var(--teal);}
.kpi-chip.warn{background:var(--rose-soft);color:var(--rose);}
.kpi-chip.muted{background:var(--s3);color:var(--tm);}
.kpi-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:2.1rem;font-weight:800;letter-spacing:-.04em;color:var(--espresso);line-height:1;}
.kpi-lbl{font-size:.75rem;font-weight:700;color:var(--tm);text-transform:uppercase;letter-spacing:.09em;margin-top:.3rem;}
.kpi-bar{height:3px;border-radius:2px;margin-top:.75rem;background:var(--s3);overflow:hidden;}
.kpi-bar-fill{height:100%;border-radius:2px;}
.kpi-card:nth-child(1) .kpi-bar-fill{background:linear-gradient(90deg,var(--gold),var(--gold-light));}
.kpi-card:nth-child(2) .kpi-bar-fill{background:linear-gradient(90deg,var(--teal),#48BEB0);}
.kpi-card:nth-child(3) .kpi-bar-fill{background:linear-gradient(90deg,var(--copper),var(--gold));}
.kpi-card:nth-child(4) .kpi-bar-fill{background:linear-gradient(90deg,var(--rose),#D85060);}
.db-body{padding:2rem 1.75rem 0;display:grid;grid-template-columns:1fr 340px;gap:1.25rem;}
.col-main{display:flex;flex-direction:column;gap:1.125rem;}
.col-side{display:flex;flex-direction:column;gap:1.125rem;}
.panel{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);overflow:hidden;box-shadow:0 2px 8px rgba(100,60,20,.05);animation:fadeUp .5s ease both;}
.panel-head{display:flex;align-items:center;justify-content:space-between;padding:.9375rem 1.25rem;border-bottom:1px solid var(--bdr);background:var(--s2);}
.panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:800;color:var(--t2);display:flex;align-items:center;gap:.4rem;}
.pdot{width:6px;height:6px;border-radius:50%;animation:pulse 2.5s infinite;}
.pdot.gold{background:var(--gold);}.pdot.teal{background:var(--teal);}.pdot.rose{background:var(--rose);}
.plink{font-size:.74rem;font-weight:600;color:var(--gold);text-decoration:none;display:inline-flex;align-items:center;gap:.2rem;}
.plink:hover{color:var(--gold-dark);}
.panel-body{padding:1.125rem 1.25rem;}
.otable{width:100%;border-collapse:collapse;}
.otable thead tr{background:var(--s3);border-bottom:1.5px solid var(--bdr);}
.otable thead th{padding:.7rem 1.25rem;font-size:.7rem;font-weight:700;color:var(--tm);text-transform:uppercase;letter-spacing:.1em;white-space:nowrap;text-align:left;}
.otable thead th.r{text-align:right;}.otable thead th.c{text-align:center;}
.otable tbody tr{border-bottom:1px solid var(--bdr);transition:background .12s;}
.otable tbody tr:last-child{border-bottom:none;}
.otable tbody tr:hover{background:var(--s2);}
.otable tbody td{padding:.9rem 1.25rem;vertical-align:middle;font-size:.875rem;}
.o-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:.8rem;font-weight:600;color:var(--t2);}
.o-cust{font-weight:700;color:var(--t1);font-size:.875rem;}
.o-meta{font-size:.74rem;color:var(--tm);margin-top:2px;}
.o-amt{font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;font-weight:700;color:var(--teal);text-align:right;}
.badge{display:inline-flex;align-items:center;gap:.22rem;padding:.22rem .65rem;border-radius:20px;font-size:.72rem;font-weight:700;}
.badge::before{content:'';width:4px;height:4px;border-radius:50%;flex-shrink:0;}
.badge.pending{background:#FEF9E7;border:1.5px solid #EDD880;color:#9C7010;}.badge.pending::before{background:#C4A010;}
.badge.confirmed{background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.3);color:var(--teal);}
.badge.baking{background:#FDF2E4;border:1.5px solid rgba(164,82,36,.3);color:var(--copper);}
.badge.ready{background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.35);color:var(--teal);}
.badge.delivered{background:#EFF8F7;border:1.5px solid rgba(20,90,70,.3);color:#145A46;}
.badge.cancelled{background:var(--rose-soft);border:1.5px solid rgba(180,56,64,.25);color:var(--rose);}
.badge.completed{background:#EFF8F7;border:1.5px solid rgba(20,90,70,.3);color:#145A46;}
.qa-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;}
.qa{display:flex;align-items:center;gap:.55rem;padding:.75rem .875rem;border-radius:var(--r);background:var(--s2);border:1.5px solid var(--bdr);text-decoration:none;transition:all .15s;}
.qa:hover{border-color:rgba(192,120,40,.3);background:var(--gold-soft);transform:translateY(-1px);}
.qa-ic{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.qa:nth-child(1) .qa-ic{background:var(--gold-soft);color:var(--gold);}
.qa:nth-child(2) .qa-ic{background:var(--teal-soft);color:var(--teal);}
.qa:nth-child(3) .qa-ic{background:#FDEEE4;color:var(--copper);}
.qa:nth-child(4) .qa-ic{background:var(--rose-soft);color:var(--rose);}
.qa:nth-child(5) .qa-ic{background:var(--s3);color:var(--mocha);}
.qa:nth-child(6) .qa-ic{background:#EEF0F8;color:#4050A0);}
.qa:nth-child(7) .qa-ic{background:#FDEAEB;color:#B43840;}
.qa:nth-child(8) .qa-ic{background:#E4F2EF;color:#1F7A6C;}
.qa-lbl{font-size:.85rem;font-weight:700;color:var(--t2);}
.qa-sub{font-size:.73rem;color:var(--tm);margin-top:2px;}
.rev-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:2rem;font-weight:800;letter-spacing:-.04em;color:var(--espresso);}
.rev-trend{display:flex;align-items:center;gap:.3rem;font-size:.82rem;color:var(--teal);font-weight:700;margin:.3rem 0 1rem;}
.sparkbars{display:flex;align-items:flex-end;gap:3px;height:50px;}
.sbar{flex:1;border-radius:3px 3px 0 0;min-height:3px;background:var(--gold-soft);border:1px solid rgba(192,120,40,.14);cursor:pointer;transition:background .18s;}
.sbar:hover,.sbar.cur{background:linear-gradient(180deg,var(--gold-light),var(--gold));border-color:var(--gold);}
.rev-stats{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-top:1rem;}
.rev-tile{padding:.625rem .75rem;border-radius:var(--r);}
.rev-tile.g{background:var(--gold-soft);border:1px solid rgba(192,120,40,.18);}
.rev-tile.t{background:var(--teal-soft);border:1px solid rgba(31,122,108,.16);}
.rev-tile-lbl{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:var(--tm);margin-bottom:.2rem;}
.rev-tile-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.2rem;font-weight:800;color:var(--espresso);}
.baker-list{display:flex;flex-direction:column;gap:.4rem;}
.baker-row{display:flex;align-items:center;gap:.625rem;padding:.55rem .7rem;border-radius:var(--r);background:var(--s2);border:1px solid var(--bdr);text-decoration:none;transition:all .15s;}
.baker-row:hover{border-color:rgba(192,120,40,.3);background:var(--gold-soft);}
.baker-ava{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.65rem;color:#fff;flex-shrink:0;}
.baker-name{font-size:.875rem;font-weight:700;color:var(--t1);}
.baker-meta{font-size:.73rem;color:var(--tm);margin-top:2px;}
.bstatus{font-size:.7rem;font-weight:700;padding:.2rem .55rem;border-radius:6px;white-space:nowrap;flex-shrink:0;}
.bstatus.pending{background:#FEF9E7;color:#9C7010;border:1px solid #EDD880;}
.bstatus.approved{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.28);}
.bstatus.rejected{background:var(--rose-soft);color:var(--rose);border:1px solid rgba(180,56,64,.22);}
.ing-list{display:flex;flex-direction:column;gap:.35rem;}
.ing-row{display:flex;align-items:center;justify-content:space-between;padding:.45rem .7rem;border-radius:8px;background:var(--s2);border:1px solid var(--bdr);}
.ing-cat{display:flex;align-items:center;gap:.4rem;font-size:.85rem;font-weight:600;color:var(--t2);}
.ing-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
.ing-cnt{font-family:'DM Mono',monospace;font-size:.78rem;font-weight:600;color:var(--tm);}
@media(max-width:1060px){.db-body{grid-template-columns:1fr;}.kpi-row{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.kpi-row{grid-template-columns:1fr 1fr;padding:0 1rem;}.hero{padding:1.75rem 1.25rem 4.25rem;}.hero-clock{display:none;}.db-body{padding:1.5rem 1rem 0;}}
</style>
@endpush

@section('content')
<div class="db">
    <div class="hero">
        <div class="hero-inner">
            <div>
    <div class="hero-title">
                    {{ now()->hour < 12 ? 'Good morning' : (now()->hour < 18 ? 'Good afternoon' : 'Good evening') }}, <em>{{ Auth::user()->first_name ?? 'Admin' }}</em>
                </div>
                <div class="hero-sub">Here's everything happening at your bakery right now.</div>
            </div>
            <div class="hero-clock">
                <div class="hero-time" id="liveTime">--:--</div>
                <div class="hero-date">{{ now()->format('D, M j Y') }}</div>
            </div>
        </div>
    </div>

    <div class="kpi-row">
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg></div>
                <span class="kpi-chip {{ $stats['pending_orders']>0?'warn':'muted' }}">{{ $stats['pending_orders'] }} pending</span>
            </div>
            <div class="kpi-val">{{ $stats['total_orders'] }}</div>
            <div class="kpi-lbl">Total Orders</div>
            <div class="kpi-bar"><div class="kpi-bar-fill" style="width:{{ min(100,$stats['total_orders']*5) }}%"></div></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-top">
             <div class="kpi-ic" style="font-size:1rem;font-weight:800;color:var(--teal);font-family:'Plus Jakarta Sans',sans-serif;">₱</div>
                <span class="kpi-chip up">↑ This month</span>
            </div>
            <div class="kpi-val">₱{{ number_format($stats['monthly_revenue'],0) }}</div>
            <div class="kpi-lbl">Monthly Revenue</div>
            <div class="kpi-bar"><div class="kpi-bar-fill" style="width:72%"></div></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <span class="kpi-chip {{ $stats['pending_bakers']>0?'warn':'muted' }}">{{ $stats['pending_bakers'] }} awaiting</span>
            </div>
            <div class="kpi-val">{{ $stats['total_bakers'] }}</div>
            <div class="kpi-lbl">Bakers</div>
            <div class="kpi-bar"><div class="kpi-bar-fill" style="width:{{ min(100,$stats['total_bakers']*8) }}%"></div></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <span class="kpi-chip muted">Registered</span>
            </div>
            <div class="kpi-val">{{ $stats['total_customers'] }}</div>
            <div class="kpi-lbl">Customers</div>
            <div class="kpi-bar"><div class="kpi-bar-fill" style="width:{{ min(100,$stats['total_customers']*4) }}%"></div></div>
        </div>
    </div>

    <div class="db-body">
        <div class="col-main">
            <div class="panel" style="animation-delay:.2s">
<div class="panel-head">
    <div class="panel-title"><div class="pdot gold"></div> Recent Transactions</div>
    {{-- ✅ FIX: View all now goes to transactions page --}}
    <a href="{{ route('admin.transactions.index') }}" class="plink">View all →</a>
</div>
@if($recent_orders->isEmpty())
<div style="padding:2.5rem;text-align:center;color:var(--tm);font-size:.8rem;">No transactions yet.</div>
@else
<table class="otable">
    <thead><tr><th>Ref #</th><th>Customer</th><th class="c">Status</th><th class="r">Amount</th></tr></thead>
    <tbody>
        @foreach($recent_orders as $o)
        <tr>
            {{-- ✅ FIX: Show transaction ID padded, not order_number --}}
            <td><span class="o-num">#{{ str_pad($o->id, 4, '0', STR_PAD_LEFT) }}</span></td>
            {{-- ✅ FIX: Pull customer name from cakeRequest->user, not $o->customer --}}
            <td>
                <div class="o-cust">
                    {{ $o->cakeRequest->user->first_name ?? '' }} {{ $o->cakeRequest->user->last_name ?? 'Unknown' }}
                </div>
                <div class="o-meta">{{ $o->created_at->diffForHumans() }}</div>
            </td>
            <td class="c">
                <span class="badge {{ strtolower($o->status) }}">
                    {{ str_replace('_', ' ', ucfirst(strtolower($o->status))) }}
                </span>
            </td>
            {{-- ✅ FIX: Use agreed_price from BakerOrder, not total_amount --}}
            <td class="o-amt">₱{{ number_format($o->agreed_price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
            </div>

            <div class="panel" style="animation-delay:.28s">
                <div class="panel-head"><div class="panel-title"><div class="pdot gold"></div> Quick Actions</div></div>
                <div class="panel-body">
                    <div class="qa-grid">
                       
                        <a href="{{ route('ingredients.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div><div><div class="qa-lbl">Add Ingredient</div><div class="qa-sub">Expand catalog</div></div></a>
                        <a href="{{ route('bakers.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><div><div class="qa-lbl">Review Bakers</div><div class="qa-sub">{{ $stats['pending_bakers'] }} pending</div></div></a>
                        <a href="{{ route('customers.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div><div class="qa-lbl">Customers</div><div class="qa-sub">View registry</div></div></a>
                        <a href="{{ route('products.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg></div><div><div class="qa-lbl">New Product</div><div class="qa-sub">Add to cake menu</div></div></a>
                        <a href="{{ route('reports.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><div><div class="qa-lbl">Sales Reports</div><div class="qa-sub">Revenue analytics</div></div></a>
                        <a href="{{ route('admin.reports.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div><div><div class="qa-lbl">User Reports</div><div class="qa-sub">Baker & customer complaints</div></div></a>
                        <a href="{{ route('admin.transactions.index') }}" class="qa"><div class="qa-ic"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div><div><div class="qa-lbl">Transactions</div><div class="qa-sub">All baker orders</div></div></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-side">
            <div class="panel" style="animation-delay:.24s">
                <div class="panel-head">
                    <div class="panel-title"><div class="pdot teal"></div> Revenue</div>
                    <span style="font-size:.68rem;font-family:'DM Mono',monospace;color:var(--tm);">{{ now()->format('M Y') }}</span>
                </div>
                <div class="panel-body">
                    <div class="rev-val">₱{{ number_format($stats['monthly_revenue'],0) }}</div>
                    <div class="rev-trend"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg> Revenue this month</div>
                    <div class="sparkbars">
                        @foreach([35,52,40,68,55,78,100] as $i=>$h)
                        <div class="sbar {{ $i===6?'cur':'' }}" style="height:{{ $h }}%"></div>
                        @endforeach
                    </div>
                    <div class="rev-stats">
                        <div class="rev-tile g"><div class="rev-tile-lbl">Orders</div><div class="rev-tile-val">{{ $stats['total_orders'] }}</div></div>
                        <div class="rev-tile t"><div class="rev-tile-lbl">Avg. Order</div><div class="rev-tile-val">₱{{ $stats['total_orders']>0?number_format($stats['monthly_revenue']/max($stats['total_orders'],1),0):'0' }}</div></div>
                    </div>
                </div>
            </div>

            @if($pending_bakers->count()>0)
            <div class="panel" style="animation-delay:.3s">
                <div class="panel-head">
                    <div class="panel-title"><div class="pdot rose"></div> Baker Applications</div>
                    <a href="{{ route('bakers.index') }}" class="plink">All →</a>
                </div>
                <div class="panel-body">
                    <div class="baker-list">
                        @foreach($pending_bakers as $baker)
                        @php $bg=['linear-gradient(135deg,#B8782A,#E0A048)','linear-gradient(135deg,#1E6860,#38B090)','linear-gradient(135deg,#883030,#B05858)','linear-gradient(135deg,#503820,#907048)'][$loop->index%4]; @endphp
                        <a href="{{ route('bakers.index') }}" class="baker-row">
                            <div class="baker-ava" style="background:{{ $bg }}">{{ strtoupper(substr($baker->first_name ?? $baker->name ?? 'B',0,2)) }}</div>
                            <div style="flex:1;min-width:0;"><div class="baker-name">{{ $baker->first_name ?? $baker->name }}</div><div class="baker-meta">{{ $baker->created_at->diffForHumans() }}</div></div>
                            <span class="bstatus {{ $baker->status }}">{{ ucfirst($baker->status) }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="panel" style="animation-delay:.36s">
                <div class="panel-head">
                    <div class="panel-title"><div class="pdot gold"></div> Ingredients</div>
                    <a href="{{ route('ingredients.index') }}" class="plink">Manage →</a>
                </div>
                <div class="panel-body">
                    @php $catColors=['Cake Type'=>'#C07828','Size'=>'#A45224','Flavor'=>'#B04040','Filling'=>'#1F7A6C','Frosting'=>'#C08018','Topping'=>'#6A4824']; $grouped=$ingredients->groupBy('category'); @endphp
                    @if($grouped->isEmpty())
                    <p style="text-align:center;color:var(--tm);font-size:.8rem;padding:.5rem 0;">No ingredients yet. <a href="{{ route('ingredients.index') }}" style="color:var(--gold);font-weight:600;">Add one →</a></p>
                    @else
                    <div class="ing-list">
                        @foreach($catColors as $cat=>$clr)
                        @php $n=$grouped->get($cat,collect())->count(); @endphp
                        @if($n>0)
                        <div class="ing-row"><span class="ing-cat"><span class="ing-dot" style="background:{{ $clr }}"></span>{{ $cat }}</span><span class="ing-cnt">{{ $n }}</span></div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
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