@extends('layouts.admin')
@section('title', 'Sales Report')

@push('styles')
<style>
/* BakeSphere Admin · Sales Report (scoped: .sr) */
.sr, .sr * { font-family:'Plus Jakarta Sans',sans-serif; box-sizing:border-box; }
.sr {
    --espresso:#24150F; --chocolate:#3A241A; --ivory:#F7F2E9; --cream:#EFE6D7;
    --caramel:#A96F42; --gold:#B89452; --burgundy:#54252C; --taupe:#9A897A; --beige:#D8C8B7;
    --ok:#2F6B4F; --ok-bg:#E6EFE8; --ok-bd:#B9D2C3; --info:#33566F;
    --line:#E2D6C4; --ink:#24150F; --ink-2:#5C4738;
    background:var(--ivory); color:var(--ink); font-variant-numeric:tabular-nums;
}
.sr svg { width:1em; height:1em; flex-shrink:0; }

/* HERO */
.sr-hero { background:var(--espresso); color:var(--ivory); padding:2.25rem 2.25rem 2rem; border-bottom:3px solid var(--gold); }
.sr-hero-in { display:flex; justify-content:space-between; align-items:flex-end; gap:1.5rem; flex-wrap:wrap; max-width:1400px; margin:0 auto; }
.sr-kicker { font-size:.66rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--gold); margin-bottom:.6rem; }
.sr-title { font-size:2.1rem; font-weight:800; letter-spacing:-.035em; line-height:1.05; margin:0 0 .5rem; color:#fff; }
.sr-sub { font-size:.86rem; color:rgba(247,242,233,.62); max-width:52ch; line-height:1.6; margin:0; }
.sr-year { display:inline-flex; align-items:center; gap:.55rem; padding:.5rem .9rem; border:1px solid rgba(184,148,82,.45); font-size:.74rem; font-weight:700; border-radius:4px; }
.sr-year svg { color:var(--gold); font-size:1rem; }

.sr-body { padding:0 0 4rem; }
.sr-body > .sr-panel:first-child { margin-top:3.25rem !important; }

/* METRICS */
.sr-metrics { display:grid; grid-template-columns:repeat(3,1fr); background:#fff; border:1px solid var(--line); border-top:3px solid var(--chocolate); margin-bottom:1.5rem; }
.sr-m { padding:1.2rem 1.4rem; border-right:1px solid var(--line); border-bottom:1px solid var(--line); }
.sr-m:nth-child(3n) { border-right:none; }
.sr-m:nth-last-child(-n+3) { border-bottom:none; }
.sr-m-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:.7rem; }
.sr-m-lbl { font-size:.68rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--taupe); }
.sr-m-ico { font-size:1.05rem; color:var(--gold); }
.sr-m-val { font-size:2rem; font-weight:800; letter-spacing:-.04em; line-height:1; color:var(--espresso); }
.sr-m.is-money .sr-m-val { color:var(--ok); }
.sr-m-note { font-size:.72rem; color:var(--taupe); margin-top:.5rem; }

/* PANELS */
.sr-panel { background:#fff; border:1px solid var(--line); margin-bottom:1.5rem; }
.sr-panel-h { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:1rem 1.5rem; border-bottom:1px solid var(--line); }
.sr-panel-t { display:flex; align-items:center; gap:.6rem; margin:0; font-size:.98rem; font-weight:800; letter-spacing:-.01em; color:var(--espresso); }
.sr-panel-t svg { color:var(--caramel); }
.sr-tag { font-size:.7rem; font-weight:700; color:var(--chocolate); background:var(--cream); border:1px solid var(--beige); padding:.2rem .65rem; border-radius:3px; }
.sr-panel-b { padding:1.25rem 1.5rem 1.4rem; }

/* CHART */
.sr-legend { display:flex; gap:1.25rem; margin-bottom:1.25rem; flex-wrap:wrap; }
.sr-leg { display:flex; align-items:center; gap:.4rem; font-size:.72rem; font-weight:600; color:var(--ink-2); }
.sr-leg i { width:10px; height:10px; display:inline-block; border-radius:2px; }
.sr-chart { display:flex; align-items:flex-end; gap:.5rem; height:220px; padding-top:1.5rem; border-bottom:1px solid var(--beige); background:
    repeating-linear-gradient(to top, transparent 0, transparent calc(25% - 1px), #EFE6D7 calc(25% - 1px), #EFE6D7 25%); }
.sr-col { flex:1; min-width:0; display:flex; flex-direction:column; align-items:center; height:100%; }
.sr-bar-o { flex:1; width:100%; display:flex; align-items:flex-end; justify-content:center; }
.sr-bar { width:68%; max-width:44px; min-height:4px; position:relative; border-radius:2px 2px 0 0; cursor:default; transition:opacity .15s; }
.sr-bar:hover, .sr-bar:focus-visible { opacity:.8; outline:none; }
.sr-bar.is-filled { background:var(--chocolate); }
.sr-bar.is-current { background:var(--gold); }
.sr-bar.is-empty { background:var(--cream); border:1px solid var(--beige); }
.sr-bar::after { content:attr(data-tip); position:absolute; bottom:calc(100% + 6px); left:50%; transform:translateX(-50%); background:var(--espresso); color:var(--ivory); font-size:.64rem; font-weight:600; padding:.3rem .55rem; border-radius:3px; white-space:nowrap; pointer-events:none; opacity:0; transition:opacity .12s; z-index:10; }
.sr-bar:hover::after, .sr-bar:focus-visible::after { opacity:1; }
.sr-lbls { display:flex; gap:.5rem; margin-top:.5rem; }
.sr-lbl { flex:1; text-align:center; font-size:.66rem; font-weight:700; color:var(--taupe); }
.sr-lbl.is-current { color:var(--caramel); }

/* TABLE */
.sr-table { width:100%; border-collapse:collapse; }
.sr-table thead th { padding:.75rem 1.25rem; text-align:left; font-size:.64rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--taupe); background:var(--ivory); border-bottom:1px solid var(--line); white-space:nowrap; }
.sr-table .r { text-align:right; }
.sr-table tbody tr { border-bottom:1px solid #EFE6D7; transition:background .12s; }
.sr-table tbody tr:last-child { border-bottom:none; }
.sr-table tbody tr:hover { background:#FBF8F2; }
.sr-table tbody td { padding:1rem 1.25rem; font-size:.84rem; vertical-align:middle; }
.sr-table tfoot td { padding:1rem 1.25rem; font-size:.84rem; background:var(--cream); border-top:2px solid var(--chocolate); font-weight:800; color:var(--espresso); }
.sr-rank { display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; border-radius:3px; font-size:.72rem; font-weight:800; border:1px solid var(--beige); background:var(--ivory); color:var(--taupe); }
.sr-rank.is-1 { background:var(--gold); border-color:var(--gold); color:#fff; }
.sr-rank.is-2 { background:var(--chocolate); border-color:var(--chocolate); color:var(--ivory); }
.sr-rank.is-3 { background:var(--caramel); border-color:var(--caramel); color:#fff; }
.sr-baker { display:flex; align-items:center; gap:.7rem; min-width:0; }
.sr-av { width:36px; height:36px; border-radius:50%; background:var(--espresso); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.78rem; overflow:hidden; flex-shrink:0; }
.sr-av img { width:100%; height:100%; object-fit:cover; }
.sr-name { font-weight:700; font-size:.84rem; color:var(--espresso); }
.sr-email { font-size:.7rem; color:var(--ink-2); word-break:break-all; }
.sr-rev { font-weight:800; color:var(--ok); }
.sr-ord { font-weight:700; color:var(--espresso); }
.sr-avg { font-weight:600; color:var(--ink-2); }
.sr-share { display:flex; align-items:center; gap:.6rem; }
.sr-share-track { width:100px; height:6px; background:var(--cream); border-radius:1px; overflow:hidden; }
.sr-share-bar { display:block; height:100%; background:var(--gold); }
.sr-share-n { font-size:.74rem; font-weight:700; color:var(--ink-2); }
.sr-dash { color:var(--beige); }
.sr-st { display:inline-flex; align-items:center; gap:.4rem; padding:.24rem .65rem; border-radius:3px; font-size:.7rem; font-weight:700; border:1px solid transparent; white-space:nowrap; }
.sr-st-on { background:var(--ok-bg); color:var(--ok); border-color:var(--ok-bd); }
.sr-st-off { background:var(--cream); color:var(--taupe); border-color:var(--beige); }
.sr-empty td { text-align:center; padding:3.5rem 1rem !important; color:var(--taupe); }

/* RESPONSIVE */
@media (max-width:980px) {
    .sr-metrics { grid-template-columns:repeat(2,1fr); }
    .sr-m, .sr-m:nth-child(3n), .sr-m:nth-last-child(-n+3) { border-right:1px solid var(--line); border-bottom:1px solid var(--line); }
    .sr-m:nth-child(2n) { border-right:none; }
    .sr-m:nth-last-child(-n+2) { border-bottom:none; }
}
@media (max-width:820px) {
    .sr-body { padding-left:0; padding-right:0; }
    .sr-table thead { position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0); }
    .sr-table, .sr-table tbody, .sr-table tfoot, .sr-table tr, .sr-table td { display:block; width:100%; }
    .sr-table tbody tr { padding:.9rem 1.1rem; }
    .sr-table tbody td, .sr-table tfoot td { padding:.4rem 0; display:flex; align-items:center; justify-content:space-between; gap:1rem; text-align:right; }
    .sr-table tbody td::before, .sr-table tfoot td::before { content:attr(data-label); font-size:.62rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--taupe); flex-shrink:0; text-align:left; }
    .sr-table td[data-label=""]::before { display:none; }
    .sr-table tfoot tr { display:block; padding:.9rem 1.1rem; background:var(--cream); border-top:2px solid var(--chocolate); }
    .sr-table tfoot td { background:transparent; border:none; }
    .sr-empty td::before { display:none; }
    .sr-empty td { display:block; }
}
@media (max-width:480px) {
    .sr-metrics { grid-template-columns:1fr; }
    .sr-m, .sr-m:nth-child(2n), .sr-m:nth-last-child(-n+2) { border-right:none; border-bottom:1px solid var(--line); }
    .sr-m:last-child { border-bottom:none; }
    .sr-chart, .sr-lbls { gap:.2rem; }
    .sr-lbl { font-size:.56rem; }
}
/* animations */
@keyframes sr-rise { from{opacity:0;transform:translatey(12px)} to{opacity:1;transform:none} }
@keyframes sr-fade { from{opacity:0} to{opacity:1} }
@keyframes sr-grow { from{transform:scaley(0);opacity:0} to{transform:scaley(1);opacity:1} }
.sr-panel { animation:sr-rise .55s ease both; }
.sr-body .sr-panel:nth-child(2) { animation-delay:.12s; }
.sr-bar { transform-origin:bottom; animation:sr-grow .7s cubic-bezier(.2,.8,.2,1) both; animation-delay:calc(var(--i, 1) * 45ms + 150ms); }
.sr-lbls { animation:sr-fade .6s .5s ease both; }
.sr-table tbody tr { animation:sr-fade .5s .3s ease both; }
.sr-rank, .sr-share-bar { transition:width .3s; }
@media (prefers-reduced-motion:reduce) { .sr * { transition:none !important; animation:none !important; } }
</style>
@endpush

@section('content')

@php
    $monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $byMonth    = $monthly->keyBy('month');
    $maxRev     = $monthly->max('revenue') ?: 1;
    $totalRev   = $stats['total_revenue'];
    $curMonth   = now()->month;
@endphp
<div class="sr ah-page">

<div class="ah-top">
<header class="ah-hero">
    <div class="ah-hero-main">
        <span class="ah-hero-mark"><svg class="ah-ic" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
        <div>
            <div class="ah-eyebrow">BakeSphere &middot; Analytics</div>
            <h1 class="ah-title">Sales Report</h1>
            <p class="ah-subtitle">Revenue and order tracking across all bakers.</p>
        </div>
    </div>
    <div class="ah-side">
        <span class="ah-side-label"><span class="ah-dot"></span>Fiscal year</span>
        <span class="ah-side-value">{{ now()->year }}</span>
    </div>
</header>
<section class="ah-ledger ah-ledger--3x2" style="--cols:3" aria-label="Sales metrics">
    <div class="ah-fig"><div class="ah-fig-lbl">Year Revenue</div><div class="ah-fig-val">₱{{ number_format($stats['total_revenue'], 0) }}</div><div class="ah-fig-note">All completed orders</div></div>
    <div class="ah-fig ah-fig--caramel"><div class="ah-fig-lbl">Total Orders</div><div class="ah-fig-val">{{ number_format($stats['total_orders']) }}</div><div class="ah-fig-note">Delivered + Completed</div></div>
    <div class="ah-fig ah-fig--taupe"><div class="ah-fig-lbl">Bakers on Platform</div><div class="ah-fig-val">{{ $stats['total_bakers'] }}</div><div class="ah-fig-note">{{ $stats['active_bakers'] }} active this year</div></div>
    <div class="ah-fig ah-fig--sage"><div class="ah-fig-lbl">This Month Revenue</div><div class="ah-fig-val">₱{{ number_format($stats['this_month_revenue'], 0) }}</div><div class="ah-fig-note">{{ $monthNames[$curMonth - 1] }} {{ now()->year }}</div></div>
    <div class="ah-fig ah-fig--burgundy"><div class="ah-fig-lbl">This Month Orders</div><div class="ah-fig-val">{{ $stats['this_month_orders'] }}</div><div class="ah-fig-note">Current month</div></div>
    <div class="ah-fig"><div class="ah-fig-lbl">Avg Order Value</div><div class="ah-fig-val">₱{{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 0) : '0' }}</div><div class="ah-fig-note">Per completed order</div></div>
</section>
</div>

<div class="sr-body">

    {{-- MONTHLY CHART --}}
    <section class="sr-panel" aria-labelledby="sr-h-monthly">
        <div class="sr-panel-h">
            <h2 class="sr-panel-t" id="sr-h-monthly">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M3 17V9M8 17V4M13 17v-6M18 17H2" stroke-linecap="round"/></svg>
                Monthly Revenue
            </h2>
            <span class="sr-tag">{{ now()->year }}</span>
        </div>
        <div class="sr-panel-b">
            <div class="sr-legend">
                <span class="sr-leg"><i style="background:var(--chocolate);"></i> Revenue</span>
                <span class="sr-leg"><i style="background:var(--gold);"></i> Current month</span>
                <span class="sr-leg"><i style="background:var(--cream);border:1px solid var(--beige);"></i> No data</span>
            </div>
            <div class="sr-chart" role="img" aria-label="Monthly revenue bar chart for {{ now()->year }}">
                @for($m = 1; $m <= 12; $m++)
                @php
                    $row  = $byMonth->get($m);
                    $rev  = $row ? floatval($row->revenue) : 0;
                    $pct  = $rev > 0 ? max(($rev / $maxRev) * 100, 5) : 6;
                    $tip  = $rev > 0
                        ? $monthNames[$m-1].': ₱'.number_format($rev,0).' ('.($row->orders ?? 0).' orders)'
                        : $monthNames[$m-1].': No completed orders';
                @endphp
                <div class="sr-col" style="--i:{{ $m }}">
                    <div class="sr-bar-o">
                        <div class="sr-bar {{ $rev > 0 ? ($m === $curMonth ? 'is-current' : 'is-filled') : 'is-empty' }}"
                             style="height:{{ $pct }}%"
                             tabindex="0"
                             data-tip="{{ $tip }}"
                             aria-label="{{ $tip }}">
                        </div>
                    </div>
                </div>
                @endfor
            </div>
            <div class="sr-lbls" aria-hidden="true">
                @for($m = 1; $m <= 12; $m++)
                <span class="sr-lbl {{ $m === $curMonth ? 'is-current' : '' }}">{{ $monthNames[$m-1] }}</span>
                @endfor
            </div>
        </div>
    </section>

    {{-- BAKER BREAKDOWN --}}
    <section class="sr-panel" aria-labelledby="sr-h-bakers">
        <div class="sr-panel-h">
            <h2 class="sr-panel-t" id="sr-h-bakers">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M5 3h10v4a5 5 0 0 1-10 0zM5 5H2.5v1.5A2.5 2.5 0 0 0 5 9M15 5h2.5v1.5A2.5 2.5 0 0 1 15 9M10 12v3M6.5 17h7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Baker Earnings Breakdown
            </h2>
            <span class="sr-tag">{{ $bakers->count() }} bakers</span>
        </div>
        <table class="sr-table">
            <thead>
                <tr>
                    <th scope="col" style="width:56px;">#</th>
                    <th scope="col">Baker</th>
                    <th scope="col" class="r">Revenue</th>
                    <th scope="col" class="r">Orders</th>
                    <th scope="col" class="r">Avg / Order</th>
                    <th scope="col">Share of Total</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bakers as $i => $baker)
                @php
                    $rev   = floatval($baker->total_revenue ?? 0);
                    $ord   = intval($baker->total_orders ?? 0);
                    $avg   = $ord > 0 ? $rev / $ord : 0;
                    $share = $totalRev > 0 ? ($rev / $totalRev) * 100 : 0;
                    $rank  = $i + 1;
                @endphp
                <tr>
                    <td data-label="#">
                        <span class="sr-rank {{ $rank <= 3 ? 'is-'.$rank : '' }}">{{ $rank }}</span>
                    </td>
                    <td data-label="Baker">
                        <div class="sr-baker">
                            <div class="sr-av">
                                @if($baker->profile_photo)
                                    <img src="{{ asset('storage/'.$baker->profile_photo) }}" alt="">
                                @else
                                    {{ strtoupper(substr($baker->first_name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="sr-name">{{ $baker->first_name }} {{ $baker->last_name }}</div>
                                <div class="sr-email">{{ $baker->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="r" data-label="Revenue">
                        <span class="sr-rev">{{ $rev > 0 ? '₱'.number_format($rev, 2) : '—' }}</span>
                    </td>
                    <td class="r" data-label="Orders">
                        <span class="sr-ord">{{ $ord > 0 ? $ord : '—' }}</span>
                    </td>
                    <td class="r" data-label="Avg / Order">
                        <span class="sr-avg">{{ $avg > 0 ? '₱'.number_format($avg, 2) : '—' }}</span>
                    </td>
                    <td data-label="Share of Total">
                        @if($share > 0)
                        <div class="sr-share">
                            <span class="sr-share-track"><span class="sr-share-bar" style="width:{{ min(max($share,1),100) }}%;"></span></span>
                            <span class="sr-share-n">{{ number_format($share, 1) }}%</span>
                        </div>
                        @else
                            <span class="sr-dash">—</span>
                        @endif
                    </td>
                    <td data-label="Status">
                        @if($ord > 0)
                            <span class="sr-st sr-st-on">
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Active
                            </span>
                        @else
                            <span class="sr-st sr-st-off">
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10" cy="10" r="6.5"/></svg>
                                No orders
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="sr-empty"><td colspan="7">No bakers found.</td></tr>
                @endforelse
            </tbody>
            @if($bakers->where('total_orders', '>', 0)->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="2" data-label="">Platform Total</td>
                    <td class="r" data-label="Revenue"><span class="sr-rev">₱{{ number_format($totalRev, 2) }}</span></td>
                    <td class="r" data-label="Orders"><span class="sr-ord">{{ $stats['total_orders'] }}</span></td>
                    <td class="r" data-label="Avg / Order">
                        <span class="sr-avg">₱{{ $stats['total_orders'] > 0 ? number_format($totalRev / $stats['total_orders'], 2) : '0.00' }}</span>
                    </td>
                    <td colspan="2" data-label=""></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </section>

</div>
</div>
@endsection