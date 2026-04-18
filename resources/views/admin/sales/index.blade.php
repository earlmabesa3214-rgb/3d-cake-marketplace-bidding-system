@extends('layouts.admin')
@section('title', 'Sales Report')

@push('styles')
<style>
* { font-family: 'Plus Jakarta Sans', sans-serif !important; }
:root {
    --gold:#C07828; --gold-light:#DC9E48; --gold-soft:#FEF3E2; --gold-glow:rgba(192,120,40,.14);
    --teal:#1F7A6C; --teal-soft:#E4F2EF;
    --rose:#B43840; --rose-soft:#FDEAEB;
    --espresso:#2C1608; --mocha:#6A4824;
    --t1:#1E0E04; --t2:#4A2C14; --tm:#8C6840;
    --border:#E8E0D0; --bdr-md:#D8CCBA;
    --surface:#FFF; --surface-2:#FAF7F2; --surface-3:#F2ECE2;
    --r:10px; --rl:14px; --rxl:18px;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
@keyframes pulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(.7);opacity:.4}}

/* HERO */
.rpt-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem;position:relative;overflow:hidden;}
.rpt-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.rpt-hero::after{content:'';position:absolute;right:-60px;top:-60px;width:260px;height:260px;background:radial-gradient(circle,rgba(192,120,40,.18),transparent 65%);border-radius:50%;}
.hero-inner{position:relative;z-index:1;}
.hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}

.rpt-body{padding:1.5rem 2rem 4rem;}

/* STATS */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;animation:fadeUp .38s ease both;}
.scard{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rl);padding:1.2rem 1.4rem;position:relative;overflow:hidden;}
.scard::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
.scard.gold::before{background:linear-gradient(90deg,var(--gold),var(--gold-light));}
.scard.teal::before{background:linear-gradient(90deg,var(--teal),#3BAA98);}
.scard.rose::before{background:linear-gradient(90deg,var(--rose),#D05060);}
.scard.mocha::before{background:linear-gradient(90deg,var(--mocha),#A07040);}
.scard.blue::before{background:linear-gradient(90deg,#2A6AA8,#4A8AC8);}
.scard.green::before{background:linear-gradient(90deg,#2A7A3A,#4A9A5A);}
.scard-lbl{font-size:.63rem;text-transform:uppercase;letter-spacing:.1em;color:var(--tm);font-weight:700;margin-bottom:.5rem;}
.scard-val{font-family:'DM Mono',monospace;font-size:1.6rem;font-weight:700;color:var(--t1);line-height:1;}
.scard-sub{font-size:.7rem;color:var(--tm);margin-top:.35rem;}

/* CHART */
.section{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rxl);overflow:hidden;margin-bottom:1.5rem;animation:fadeUp .38s ease .08s both;}
.section-hd{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1.5px solid var(--border);background:var(--surface-2);}
.section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.95rem;font-weight:700;color:var(--espresso);}
.section-badge{font-size:.7rem;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.22);border-radius:20px;padding:.18rem .65rem;color:#9A5E14;font-weight:700;}
.section-body{padding:1.25rem 1.5rem;}

.legend{display:flex;gap:1.1rem;margin-bottom:1.1rem;}
.leg-item{display:flex;align-items:center;gap:.32rem;font-size:.7rem;color:var(--tm);}
.leg-dot{width:9px;height:9px;border-radius:3px;}

.bar-chart{display:flex;align-items:flex-end;gap:.4rem;height:180px;}
.bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:.3rem;height:100%;}
.bar-outer{flex:1;width:100%;display:flex;align-items:flex-end;}
.bar{width:100%;border-radius:5px 5px 0 0;min-height:4px;position:relative;transition:opacity .18s;cursor:default;}
.bar:hover{opacity:.75;}
.bar::after{content:attr(data-tip);position:absolute;bottom:calc(100% + 5px);left:50%;transform:translateX(-50%);background:var(--espresso);color:#fff;font-size:.58rem;font-weight:600;padding:.18rem .42rem;border-radius:5px;white-space:nowrap;pointer-events:none;opacity:0;transition:opacity .14s;z-index:10;}
.bar:hover::after{opacity:1;}
.bar.filled{background:linear-gradient(180deg,var(--gold-light),var(--gold));}
.bar.empty{background:var(--surface-3);border:1.5px solid var(--border);}
.bar-lbl{font-size:.6rem;color:var(--tm);font-weight:600;}

/* BAKER TABLE */
.bk-table{width:100%;border-collapse:collapse;}
.bk-table thead th{padding:.65rem 1.25rem;text-align:left;font-size:.62rem;text-transform:uppercase;letter-spacing:.12em;color:var(--tm);font-weight:700;background:var(--surface-3);border-bottom:1.5px solid var(--border);}
.bk-table thead th.r{text-align:right;}
.bk-table tbody tr{border-bottom:1px solid var(--border);transition:background .12s;}
.bk-table tbody tr:last-child{border-bottom:none;}
.bk-table tbody tr:hover{background:var(--surface-2);}
.bk-table tbody td{padding:.85rem 1.25rem;font-size:.82rem;color:var(--t1);vertical-align:middle;}
.bk-table tfoot td{padding:.85rem 1.25rem;font-size:.82rem;}
.r{text-align:right;}

.rank-badge{display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:6px;font-size:.68rem;font-weight:800;font-family:'DM Mono',monospace;}
.rank-1{background:linear-gradient(135deg,#F0C040,#C89020);color:#fff;}
.rank-2{background:linear-gradient(135deg,#C8D0D8,#8898A8);color:#fff;}
.rank-3{background:linear-gradient(135deg,#D8A878,#A07040);color:#fff;}
.rank-n{background:var(--surface-3);color:var(--tm);border:1.5px solid var(--border);}

.baker-cell{display:flex;align-items:center;gap:.6rem;}
.b-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--espresso),var(--mocha));color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.72rem;flex-shrink:0;overflow:hidden;}
.b-avatar img{width:100%;height:100%;object-fit:cover;}
.b-name{font-weight:600;font-size:.82rem;color:var(--espresso);}
.b-email{font-size:.67rem;color:var(--tm);}

.rev-val{font-family:'DM Mono',monospace;font-weight:700;color:var(--teal);}
.ord-val{font-family:'DM Mono',monospace;font-weight:600;color:var(--espresso);}
.avg-val{font-family:'DM Mono',monospace;font-size:.76rem;color:var(--tm);}

.share-bar-wrap{display:flex;align-items:center;gap:.5rem;}
.share-bar{height:6px;border-radius:3px;background:linear-gradient(90deg,var(--gold-light),var(--gold));display:inline-block;min-width:3px;}

.status-active{display:inline-flex;align-items:center;gap:.28rem;padding:.18rem .55rem;border-radius:20px;font-size:.65rem;font-weight:700;background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.28);color:var(--teal);}
.status-inactive{display:inline-flex;align-items:center;gap:.28rem;padding:.18rem .55rem;border-radius:20px;font-size:.65rem;font-weight:700;background:var(--surface-3);border:1.5px solid var(--bdr-md);color:var(--tm);}

.empty-row td{text-align:center;padding:3rem;color:var(--tm);}

@media(max-width:900px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .rpt-body{padding:1.25rem 1rem 3rem;}
}
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

{{-- HERO --}}
<div class="rpt-hero">
    <div class="hero-inner">
        <div class="hero-pill"><span class="hero-dot"></span> Analytics · {{ now()->year }}</div>
        <div class="hero-title"><em>Sales</em> Report</div>
        <div class="hero-sub">Revenue and order tracking across all bakers — {{ now()->year }}</div>
    </div>
</div>

<div class="rpt-body">

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="scard gold">
            <div class="scard-lbl">💰 Year Revenue</div>
            <div class="scard-val">₱{{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="scard-sub">All completed orders · {{ now()->year }}</div>
        </div>
        <div class="scard teal">
            <div class="scard-lbl">🛒 Total Orders</div>
            <div class="scard-val">{{ number_format($stats['total_orders']) }}</div>
            <div class="scard-sub">Delivered + Completed</div>
        </div>
        <div class="scard mocha">
            <div class="scard-lbl">👨‍🍳 Bakers on Platform</div>
            <div class="scard-val">{{ $stats['total_bakers'] }}</div>
            <div class="scard-sub">{{ $stats['active_bakers'] }} active this year</div>
        </div>
        <div class="scard rose">
            <div class="scard-lbl">📅 This Month Revenue</div>
            <div class="scard-val">₱{{ number_format($stats['this_month_revenue'], 0) }}</div>
            <div class="scard-sub">{{ $monthNames[$curMonth - 1] }} {{ now()->year }}</div>
        </div>
        <div class="scard blue">
            <div class="scard-lbl">📦 This Month Orders</div>
            <div class="scard-val">{{ $stats['this_month_orders'] }}</div>
            <div class="scard-sub">
                @if($stats['total_orders'] > 0)
                    {{ number_format(($stats['this_month_orders'] / $stats['total_orders']) * 100, 1) }}% of year total
                @else
                    No orders yet
                @endif
            </div>
        </div>
        <div class="scard green">
            <div class="scard-lbl">📊 Avg Order Value</div>
            <div class="scard-val">₱{{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 0) : '0' }}</div>
            <div class="scard-sub">Per completed order</div>
        </div>
    </div>

    {{-- MONTHLY CHART --}}
    <div class="section">
        <div class="section-hd">
            <span class="section-title">Monthly Revenue</span>
            <span class="section-badge">{{ now()->year }}</span>
        </div>
        <div class="section-body">
            <div class="legend">
                <div class="leg-item"><div class="leg-dot" style="background:var(--gold);"></div> Revenue</div>
                <div class="leg-item"><div class="leg-dot" style="background:var(--surface-3);border:1.5px solid var(--border);"></div> No data</div>
            </div>
            <div class="bar-chart">
                @for($m = 1; $m <= 12; $m++)
                @php
                    $row  = $byMonth->get($m);
                    $rev  = $row ? floatval($row->revenue) : 0;
                    $pct  = $rev > 0 ? max(($rev / $maxRev) * 100, 5) : 6;
                    $tip  = $rev > 0
                        ? $monthNames[$m-1].': ₱'.number_format($rev,0).' ('.($row->orders ?? 0).' orders)'
                        : $monthNames[$m-1].': No completed orders';
                @endphp
                <div class="bar-col">
                    <div class="bar-outer">
                        <div class="bar {{ $rev > 0 ? 'filled' : 'empty' }}"
                             style="height:{{ $pct }}%"
                             data-tip="{{ $tip }}">
                        </div>
                    </div>
                    <span class="bar-lbl">{{ $monthNames[$m-1] }}</span>
                </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- BAKER BREAKDOWN --}}
    <div class="section">
        <div class="section-hd">
            <span class="section-title">Baker Earnings Breakdown</span>
            <span class="section-badge">{{ $bakers->count() }} bakers</span>
        </div>
        <table class="bk-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Baker</th>
                    <th class="r">Revenue</th>
                    <th class="r">Orders</th>
                    <th class="r">Avg / Order</th>
                    <th>Share of Total</th>
                    <th>Status</th>
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
                    <td>
                        <span class="rank-badge {{ $rank <= 3 ? 'rank-'.$rank : 'rank-n' }}">
                            {{ $rank <= 3 ? ['🥇','🥈','🥉'][$rank-1] : $rank }}
                        </span>
                    </td>
                    <td>
                        <div class="baker-cell">
                            <div class="b-avatar">
                                @if($baker->profile_photo)
                                    <img src="{{ asset('storage/'.$baker->profile_photo) }}" alt="">
                                @else
                                    {{ strtoupper(substr($baker->first_name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="b-name">{{ $baker->first_name }} {{ $baker->last_name }}</div>
                                <div class="b-email">{{ $baker->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="r">
                        <span class="rev-val">{{ $rev > 0 ? '₱'.number_format($rev, 2) : '—' }}</span>
                    </td>
                    <td class="r">
                        <span class="ord-val">{{ $ord > 0 ? $ord : '—' }}</span>
                    </td>
                    <td class="r">
                        <span class="avg-val">{{ $avg > 0 ? '₱'.number_format($avg, 2) : '—' }}</span>
                    </td>
                    <td>
                        @if($share > 0)
                        <div class="share-bar-wrap">
                            <span class="share-bar" style="width:{{ max($share,1) }}%;max-width:100px;"></span>
                            <span style="font-size:.7rem;color:var(--tm);font-family:'DM Mono',monospace;">
                                {{ number_format($share, 1) }}%
                            </span>
                        </div>
                        @else
                            <span style="font-size:.72rem;color:var(--bdr-md);">—</span>
                        @endif
                    </td>
                    <td>
                        @if($ord > 0)
                            <span class="status-active">● Active</span>
                        @else
                            <span class="status-inactive">○ No orders</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="7">No bakers found.</td></tr>
                @endforelse
            </tbody>
            @if($bakers->where('total_orders', '>', 0)->count() > 0)
            <tfoot>
                <tr style="background:var(--surface-3);border-top:2px solid var(--border);">
                    <td colspan="2" style="font-weight:700;color:var(--espresso);padding:.85rem 1.25rem;">
                        Platform Total
                    </td>
                    <td class="r" style="padding:.85rem 1.25rem;">
                        <span class="rev-val" style="font-size:.88rem;">₱{{ number_format($totalRev, 2) }}</span>
                    </td>
                    <td class="r" style="padding:.85rem 1.25rem;">
                        <span class="ord-val" style="font-size:.88rem;">{{ $stats['total_orders'] }}</span>
                    </td>
                    <td class="r" style="padding:.85rem 1.25rem;">
                        <span class="avg-val">
                            ₱{{ $stats['total_orders'] > 0 ? number_format($totalRev / $stats['total_orders'], 2) : '0.00' }}
                        </span>
                    </td>
                    <td colspan="2" style="padding:.85rem 1.25rem;"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

</div>
@endsection