@extends('layouts.baker')
@section('title', 'Earnings')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* Earnings: same cake-atelier ledger language as Bids, Orders and Wallet. Plus Jakarta Sans only. */
.earnings-page{
--esp:#24150F;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;--sage-d:#33502F;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.earnings-page *{box-sizing:border-box;font-family:inherit}
.earnings-page svg{flex-shrink:0}
.earnings-page a:focus-visible,.earnings-page button:focus-visible,.earnings-page .er-bar:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes er-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes er-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes er-grow{from{transform:scaleY(0)}to{transform:scaleY(1)}}
@media(prefers-reduced-motion:reduce){.earnings-page *,.earnings-page *::before,.earnings-page *::after{animation:none!important;transition:none!important}}

/* header */
.er-header{position:relative;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;margin:0 0 2rem;padding-bottom:1.75rem;animation:er-fadeUp .6s var(--e) backwards}
.er-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.er-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:er-line .9s var(--e) .3s backwards}
.er-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.er-sub{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}
.er-report-btn{display:inline-flex;align-items:center;gap:.55rem;padding:.75rem 1.2rem;background:transparent;border:1px solid var(--esp);border-radius:0;font-size:.62rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:background .3s,color .3s}
.er-report-btn:hover{background:var(--esp);color:var(--gold-l)}

.er-label{font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}

/* summary */
.er-stats{display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:1.25rem;margin-bottom:2rem}
.er-stat{background:var(--w);border:1px solid var(--beige);border-top:2px solid var(--esp);padding:1.6rem 1.7rem;display:flex;flex-direction:column;animation:er-fadeUp .6s var(--e) backwards}
.er-stat-icon{margin-bottom:1rem;color:var(--gold)}
.er-stat-icon svg{width:24px;height:24px}
.er-stat-value{margin-top:.7rem;font-size:clamp(1.6rem,2.8vw,2.2rem);font-weight:900;letter-spacing:-.04em;line-height:1;color:var(--esp);font-variant-numeric:tabular-nums}
.er-stat-sub{margin-top:.75rem;font-size:.78rem;color:var(--mocha)}
.er-stat.hero{background:var(--esp);border-color:var(--esp);border-top-width:1px;border-left:3px solid var(--gold);color:var(--ivory)}
.er-stat.hero .er-label{color:var(--gold-l)}
.er-stat.hero .er-stat-value{color:var(--gold-l);font-size:clamp(2.2rem,4.4vw,3.4rem);letter-spacing:-.05em}
.er-stat.hero .er-stat-sub{color:rgba(247,242,233,.7)}
.er-stat.hero .er-stat-icon{color:var(--gold-l)}

/* main grid + panels */
.er-main{display:grid;grid-template-columns:1fr 380px;gap:1.5rem;align-items:start}
.er-panel{background:var(--w);border:1px solid var(--beige);border-top:2px solid var(--esp);animation:er-fadeUp .6s var(--e) .2s backwards}
.er-panel-head{padding:1.1rem 1.5rem;border-bottom:1px solid var(--line)}
.er-panel-head h2{margin:0;font-size:1.1rem;font-weight:900;letter-spacing:-.03em;line-height:1}

/* ledger table */
.er-scroll{overflow-x:auto;scrollbar-width:thin;scrollbar-color:var(--gold-line) transparent}
.er-table{width:100%;min-width:520px;border-collapse:collapse}
.er-table th{padding:1rem 1.5rem;text-align:left;font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);border-bottom:1px solid var(--esp)}
.er-table td{padding:1.15rem 1.5rem;font-size:.86rem;color:var(--esp);border-bottom:1px solid var(--line);vertical-align:middle}
.er-table tbody tr{transition:background .3s}
.er-table tbody tr:hover td{background:rgba(239,230,215,.5)}
.er-table tr:last-child td{border-bottom:0}
.er-month{font-size:.95rem;font-weight:800;letter-spacing:-.02em}
.er-amount{font-size:1rem;font-weight:900;letter-spacing:-.03em;color:var(--credit);font-variant-numeric:tabular-nums}
.er-count{display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:28px;padding:0 .5rem;background:var(--cream);border:1px solid var(--beige);font-size:.78rem;font-weight:800;color:var(--mocha);font-variant-numeric:tabular-nums}
.er-avg{font-size:.82rem;font-weight:600;color:var(--mocha);font-variant-numeric:tabular-nums}

/* chart */
.er-chart{padding:2.75rem 1.5rem 1.25rem}
.er-bars{display:flex;align-items:flex-end;gap:10px;height:160px;border-bottom:1px solid var(--esp)}
.er-bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;height:100%}
.er-bar{position:relative;width:100%;min-height:4px;background:var(--esp);cursor:pointer;transform-origin:bottom;animation:er-grow .7s var(--e) backwards;transition:background .3s}
.er-bar:hover,.er-bar:focus-visible{background:var(--caramel)}
.er-bar.current{background:var(--gold)}
.er-bar.current:hover{background:var(--caramel)}
.er-tip{display:none;position:absolute;top:-34px;left:50%;transform:translateX(-50%);background:var(--esp);color:var(--ivory);font-size:.66rem;font-weight:800;padding:4px 8px;white-space:nowrap;z-index:2;font-variant-numeric:tabular-nums}
.er-bar:hover .er-tip,.er-bar:focus-visible .er-tip{display:block}
.er-axis{display:flex;gap:10px;margin-top:.7rem}
.er-axis span{flex:1;text-align:center;font-size:.56rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--taupe)}
.er-axis span.current{color:var(--esp)}

/* best month */
.er-best{margin:.25rem 1.5rem 1.5rem;padding:1rem 1.2rem;display:flex;align-items:center;gap:.9rem;background:var(--cream);border-left:2px solid var(--gold)}
.er-best svg{color:var(--gold)}
.er-best-value{margin-top:.3rem;font-size:1rem;font-weight:800;letter-spacing:-.02em;line-height:1.35;font-variant-numeric:tabular-nums}

/* empty */
.er-empty{padding:4rem 1.5rem;text-align:center}
.er-empty svg{color:var(--gold);opacity:.75;margin-bottom:1rem}
.er-empty h3{margin:0 0 .6rem;font-size:clamp(1.4rem,2.6vw,1.9rem);font-weight:900;letter-spacing:-.04em;line-height:1}
.er-empty p{margin:0 auto;max-width:44ch;font-size:.92rem;color:var(--mocha)}

/* responsive */
@media(max-width:1000px){.er-stats{grid-template-columns:1fr 1fr}.er-stat.hero{grid-column:1 / -1}}
@media(max-width:900px){.er-main{grid-template-columns:1fr}}
@media(max-width:520px){.er-stats{grid-template-columns:1fr}.er-stat.hero{padding:1.5rem}}
</style>
@endpush

@section('content')

<div class="earnings-page">

<div class="er-header">
    <div>
        <h1 class="er-title">Earnings</h1>
        <p class="er-sub">Your financial overview and monthly breakdown</p>
    </div>
    <button type="button" class="er-report-btn" onclick="generateReport()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/></svg>
        Generate Report
    </button>
</div>

{{-- ── STAT CARDS ── --}}
<div class="er-stats">
    <div class="er-stat hero" style="animation-delay:0.1s;">
        <div class="er-stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="13" rx="2"/><path d="M2 10h20"/><circle cx="12" cy="14.5" r="2.5"/></svg></div>
        <div class="er-label">This Month</div>
        <div class="er-stat-value">₱{{ number_format($thisMonth, 0) }}</div>
        <div class="er-stat-sub">{{ now()->format('F Y') }}</div>
    </div>
    <div class="er-stat" style="animation-delay:0.18s;">
        <div class="er-stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
        <div class="er-label">All Time Earnings</div>
        <div class="er-stat-value">₱{{ number_format($allTime, 0) }}</div>
        <div class="er-stat-sub">Since you joined</div>
    </div>
    <div class="er-stat" style="animation-delay:0.26s;">
        <div class="er-stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21v-6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6"/><path d="M2 21h20"/><path d="M4 15c1-1.5 2.5-1.5 3.5 0s2.5 1.5 3.5 0 2.5-1.5 3.5 0 2.5 1.5 3.5 0"/><path d="M12 9V5"/><path d="M12 5c-1.1 0-1.8-.8-1.8-1.6C10.2 2.5 12 1 12 1s1.8 1.5 1.8 2.4c0 .8-.7 1.6-1.8 1.6z"/></svg></div>
        <div class="er-label">Completed Orders</div>
        <div class="er-stat-value">{{ $completedCount }}</div>
        <div class="er-stat-sub">Total fulfilled</div>
    </div>
</div>

{{-- ── MAIN GRID ── --}}
<div class="er-main">

    {{-- Monthly Breakdown Table --}}
    <div class="er-panel">
        <div class="er-panel-head">
            <h2>Monthly Breakdown</h2>
        </div>
        @if($monthly->isEmpty())
            <div class="er-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" width="44" height="44"><path d="M21 8l-2 13H5L3 8"/><path d="M1 3h22"/><path d="M10 12h4"/></svg>
                <h3>No earnings yet</h3>
                <p>Complete your first order to start seeing earnings here.</p>
            </div>
        @else
            <div class="er-scroll">
            <table class="er-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Earnings</th>
                        <th>Orders</th>
                        <th>Avg. per Order</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthly as $row)
                    @php $avg = $row->count > 0 ? $row->total / $row->count : 0; @endphp
                    <tr>
                        <td>
                            <div class="er-month">
                                {{ \Carbon\Carbon::createFromDate($row->year, $row->month, 1)->format('F Y') }}
                            </div>
                        </td>
                        <td><span class="er-amount">₱{{ number_format($row->total, 2) }}</span></td>
                        <td><span class="er-count">{{ $row->count }}</span></td>
                        <td class="er-avg">₱{{ number_format($avg, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endif
    </div>

    {{-- Chart + Best Month ── --}}
    <div>
        <div class="er-panel">
            <div class="er-panel-head">
                <h2>6-Month Chart</h2>
            </div>

            @php
                $chartData = [];
                for ($i = 5; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $row   = $monthly->first(fn($r) =>
                        $r->year == $month->year && $r->month == $month->month
                    );
                    $chartData[] = [
                        'label' => $month->format('M'),
                        'total' => $row?->total ?? 0,
                    ];
                }
                $maxVal = max(array_column($chartData, 'total')) ?: 1;
                $bestMonth = $monthly->sortByDesc('total')->first();
            @endphp

            <div class="er-chart">
                <div class="er-bars">
                    @foreach($chartData as $bar)
                    <div class="er-bar-wrap">
                        <div class="er-bar {{ $loop->last ? 'current' : '' }}" tabindex="0"
                             style="height: {{ max(4, ($bar['total'] / $maxVal) * 140) }}px; animation-delay: {{ $loop->index * 0.06 + 0.3 }}s;">
                            <div class="er-tip">₱{{ number_format($bar['total'], 0) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="er-axis">
                    @foreach($chartData as $bar)
                    <span class="{{ $loop->last ? 'current' : '' }}">{{ $bar['label'] }}</span>
                    @endforeach
                </div>
            </div>

            @if($bestMonth)
            <div class="er-best">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><path d="M8 21h8"/><path d="M12 17v4"/><path d="M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M7 5H4a2 2 0 0 0 0 4h1"/><path d="M17 5h3a2 2 0 0 1 0 4h-1"/></svg>
                <div>
                    <div class="er-label">Best Month</div>
                    <div class="er-best-value">
                        {{ \Carbon\Carbon::createFromDate($bestMonth->year, $bestMonth->month, 1)->format('F Y') }}
                        — ₱{{ number_format($bestMonth->total, 0) }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>

</div>{{-- /.earnings-page --}}

@endsection
@push('scripts')
@php
    $monthlyForReport = $monthly->map(function ($r) {
        return [
            'year'  => $r->year,
            'month' => $r->month,
            'total' => $r->total,
            'count' => $r->count,
        ];
    })->values();
@endphp
<script>
window._earningsReport = {
    bakerName: @json(auth()->user()->first_name . ' ' . auth()->user()->last_name),
    thisMonth: {{ $thisMonth }},
    allTime: {{ $allTime }},
    completedCount: {{ $completedCount }},
    monthly: @json($monthlyForReport)
};

function generateReport() {
    const data = window._earningsReport;
    const rows = data.monthly.map(r => {
        const monthName = new Date(r.year, r.month - 1, 1).toLocaleString('en-US', { month: 'long', year: 'numeric' });
        const avg = r.count > 0 ? r.total / r.count : 0;
        return `<tr>
            <td>${monthName}</td>
            <td class="num">₱${Number(r.total).toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2})}</td>
            <td class="num">${r.count}</td>
            <td class="num">₱${Number(avg).toLocaleString('en-US', {maximumFractionDigits:0})}</td>
        </tr>`;
    }).join('');

    const win = window.open('', '_blank', 'width=900,height=1000');
    win.document.write(`
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Earnings Report — ${data.bakerName}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap">
        <style>
            * { box-sizing: border-box; }
            body { font-family: 'Plus Jakarta Sans', sans-serif; color: #24150F; margin: 0; padding: 48px 56px; }
            .report-header { display:flex; justify-content:space-between; align-items:flex-end; border-bottom: 1px solid rgba(184,148,82,.6); padding-bottom: 18px; margin-bottom: 32px; position: relative; }
            .report-header::after { content:''; position:absolute; left:0; bottom:-1px; width:72px; height:3px; background:#B89452; }
            .report-title { font-size: 30px; font-weight: 900; letter-spacing: -0.04em; margin: 0 0 6px; }
            .report-sub { font-size: 11px; font-weight: 800; letter-spacing: 0.24em; text-transform: uppercase; color: #9A897A; margin: 0; }
            .report-meta { text-align: right; font-size: 11px; color: #7A5E4C; }
            .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
            .summary-box { border: 1px solid #D8C8B7; border-top: 2px solid #24150F; padding: 14px 16px; }
            .summary-label { font-size: 9px; font-weight: 800; letter-spacing: 0.24em; text-transform: uppercase; color: #9A897A; margin-bottom: 8px; }
            .summary-value { font-size: 22px; font-weight: 900; letter-spacing: -0.03em; color: #24150F; }
            table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 24px; }
            th { text-align: left; font-size: 9px; font-weight: 800; letter-spacing: 0.24em; text-transform: uppercase; color: #9A897A; border-bottom: 1px solid #24150F; padding: 10px; }
            td { padding: 10px; border-bottom: 1px solid rgba(36,21,15,.14); font-weight: 500; }
            td.num, th.num { text-align: right; font-variant-numeric: tabular-nums; }
            .footer-note { font-size: 10px; color: #7A5E4C; margin-top: 40px; border-top: 1px solid rgba(36,21,15,.14); padding-top: 12px; line-height: 1.6; }
            @media print { body { padding: 24px 32px; } }
        </style>
    </head>
    <body>
        <div class="report-header">
            <div>
                <p class="report-title">${data.bakerName}</p>
                <p class="report-sub">Earnings Report</p>
            </div>
            <div class="report-meta">
                Generated ${new Date().toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' })}
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-box">
                <div class="summary-label">This Month</div>
                <div class="summary-value">₱${Number(data.thisMonth).toLocaleString('en-US', {maximumFractionDigits:0})}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">All-Time Earnings</div>
                <div class="summary-value">₱${Number(data.allTime).toLocaleString('en-US', {maximumFractionDigits:0})}</div>
            </div>
            <div class="summary-box">
                <div class="summary-label">Completed Orders</div>
                <div class="summary-value">${data.completedCount}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr><th>Month</th><th class="num">Earnings</th><th class="num">Orders</th><th class="num">Avg. per Order</th></tr>
            </thead>
            <tbody>
                ${rows || '<tr><td colspan="4" style="text-align:center;color:#9A897A;">No earnings recorded yet.</td></tr>'}
            </tbody>
        </table>

        <p class="footer-note">This report was generated automatically from your BakeSphere account activity and reflects completed orders at the time of generation.</p>

        <script>window.onload = function(){ var ready = (document.fonts && document.fonts.ready) ? document.fonts.ready : Promise.resolve(); ready.then(function(){ setTimeout(function(){ window.print(); }, 300); }); };<\/script>
    </body>
    </html>
    `);
    win.document.close();
}
</script>
@endpush