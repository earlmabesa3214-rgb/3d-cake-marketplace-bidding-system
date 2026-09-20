@extends('layouts.baker')
@section('title', 'Earnings')

@push('styles')
<style>
:root {
    --brown-deep:   #3B1F0F;
    --brown-mid:    #7A4A28;
    --caramel:      #C8893A;
    --caramel-light:#E8A94A;
    --warm-white:   #FFFDF9;
    --cream:        #F5EFE6;
    --border:       #EAE0D0;
    --text-dark:    #2C1A0E;
    --text-mid:     #6B4A2A;
    --text-muted:   #9A7A5A;
    --shadow:       0 4px 24px rgba(59,31,15,0.08);
    --shadow-lg:    0 8px 32px rgba(59,31,15,0.12);
}

.page-title    { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; font-weight:800; color:var(--brown-deep); margin-bottom:0.25rem; }
.page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-bottom:0; }

.page-header-row { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2rem; }

.btn-report {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.1rem;
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--brown-mid);
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}
.btn-report:hover { border-color: var(--caramel); color: var(--brown-deep); background: var(--cream); }
.btn-report svg { flex-shrink: 0; }

/* ── STAT CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.stat-card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
.stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 16px 16px 0 0;
}
.stat-card.c1::after { background: linear-gradient(90deg, var(--caramel), var(--caramel-light)); }
.stat-card.c2::after { background: linear-gradient(90deg, #9A6028, #C8803A); }
.stat-card.c3::after { background: linear-gradient(90deg, var(--brown-deep), var(--brown-mid)); }

.stat-icon  { margin-bottom: 0.75rem; color: var(--caramel); }
.stat-icon svg { width: 26px; height: 26px; }
.stat-value { font-family:'Plus Jakarta Sans',sans-serif; font-size: 2rem; font-weight: 800; color: var(--brown-deep); line-height: 1; }
.stat-label { font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-muted); font-weight: 600; margin-top: 0.3rem; }
.stat-sub   { font-size: 0.72rem; color: var(--caramel); font-weight: 600; margin-top: 0.5rem; }

/* ── MAIN GRID ── */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
}

/* ── CARD ── */
.card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}
.card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--cream);
}
.card-title { font-family:'Plus Jakarta Sans',sans-serif; font-size: 1.05rem; font-weight:700; color: var(--brown-deep); }

/* ── TABLE ── */
.earnings-table { width: 100%; border-collapse: collapse; }
.earnings-table th {
    padding: 0.85rem 1.5rem;
    text-align: left;
    font-size: 0.68rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    font-weight: 600;
    background: var(--cream);
}
.earnings-table td {
    padding: 1rem 1.5rem;
    font-size: 0.86rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-dark);
    vertical-align: middle;
}
.earnings-table tr:last-child td { border-bottom: none; }
.earnings-table tbody tr { transition: background 0.15s; }
.earnings-table tbody tr:hover td { background: var(--cream); }

.month-label { font-weight: 600; color: var(--brown-mid); }
.amount-val  { font-weight: 700; color: var(--brown-deep); font-size: 0.9rem; }
.order-count {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px;
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-mid);
}

/* ── BAR CHART ── */
.chart-wrap {
    padding: 1.25rem 1.5rem 1rem;
}
.chart-bars {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 160px;
    margin-bottom: 0.5rem;
}
.chart-bar-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    height: 100%;
    justify-content: flex-end;
}
.chart-bar {
    width: 100%;
    border-radius: 6px 6px 0 0;
    background: linear-gradient(to top, var(--caramel), var(--caramel-light));
    min-height: 4px;
    transition: height 0.6s ease;
    cursor: pointer;
    position: relative;
}
.chart-bar:hover { opacity: 0.85; }
.chart-bar .tooltip {
    display: none;
    position: absolute;
    top: -32px; left: 50%;
    transform: translateX(-50%);
    background: var(--brown-deep);
    color: #fff;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 3px 7px;
    border-radius: 6px;
    white-space: nowrap;
}
.chart-bar:hover .tooltip { display: block; }
.chart-bar-label {
    font-size: 0.6rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
}

/* ── BEST MONTH ── */
.best-month-card {
    background: linear-gradient(135deg, var(--brown-deep), var(--brown-mid));
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    margin: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.best-month-icon { color: #fff; flex-shrink: 0; display: flex; align-items: center; }
.best-month-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.55); margin-bottom: 0.15rem; }
.best-month-value { font-family:'Plus Jakarta Sans',sans-serif; font-size: 1rem; color: #fff; font-weight: 700; }

/* ── EMPTY ── */
.empty-state { padding: 3rem 2rem; text-align: center; color: var(--text-muted); }
.empty-state .emoji { color: var(--border); margin-bottom: 0.75rem; display: flex; justify-content: center; }
.empty-state h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size: 1.1rem; font-weight:700; color: var(--brown-mid); margin-bottom: 0.4rem; }

@media (max-width: 900px) {
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .main-grid  { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .stats-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<div class="page-header-row">
    <div>
        <h1 class="page-title">Earnings</h1>
        <p class="page-subtitle">Your financial overview and monthly breakdown</p>
    </div>
    <button type="button" class="btn-report" onclick="generateReport()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/></svg>
        Generate Report
    </button>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stats-grid">
    <div class="stat-card c1">
        <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="13" rx="2"/><path d="M2 10h20"/><circle cx="12" cy="14.5" r="2.5"/></svg></div>
        <div class="stat-value">₱{{ number_format($thisMonth, 0) }}</div>
        <div class="stat-label">This Month</div>
        <div class="stat-sub">{{ now()->format('F Y') }}</div>
    </div>
    <div class="stat-card c2">
        <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
        <div class="stat-value">₱{{ number_format($allTime, 0) }}</div>
        <div class="stat-label">All Time Earnings</div>
        <div class="stat-sub">Since you joined</div>
    </div>
    <div class="stat-card c3">
        <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21v-6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6"/><path d="M2 21h20"/><path d="M4 15c1-1.5 2.5-1.5 3.5 0s2.5 1.5 3.5 0 2.5-1.5 3.5 0 2.5 1.5 3.5 0"/><path d="M12 9V5"/><path d="M12 5c-1.1 0-1.8-.8-1.8-1.6C10.2 2.5 12 1 12 1s1.8 1.5 1.8 2.4c0 .8-.7 1.6-1.8 1.6z"/></svg></div>
        <div class="stat-value">{{ $completedCount }}</div>
        <div class="stat-label">Completed Orders</div>
        <div class="stat-sub">Total fulfilled</div>
    </div>
</div>

{{-- ── MAIN GRID ── --}}
<div class="main-grid">

    {{-- Monthly Breakdown Table --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Monthly Breakdown</h2>
        </div>
        @if($monthly->isEmpty())
            <div class="empty-state">
                         <div class="emoji"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="40" height="40"><path d="M21 8l-2 13H5L3 8"/><path d="M1 3h22"/><path d="M10 12h4"/></svg></div>
                <h3>No earnings yet</h3>
                <p>Complete your first order to start seeing earnings here.</p>
            </div>
        @else
            <table class="earnings-table">
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
                            <div class="month-label">
                                {{ \Carbon\Carbon::createFromDate($row->year, $row->month, 1)->format('F Y') }}
                            </div>
                        </td>
                        <td><span class="amount-val">₱{{ number_format($row->total, 2) }}</span></td>
                        <td><span class="order-count">{{ $row->count }}</span></td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">₱{{ number_format($avg, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Chart + Best Month ── --}}
    <div>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">6-Month Chart</h2>
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

            <div class="chart-wrap">
                <div class="chart-bars">
                    @foreach($chartData as $bar)
                    <div class="chart-bar-wrap">
                        <div class="chart-bar"
                             style="height: {{ max(4, ($bar['total'] / $maxVal) * 140) }}px;">
                            <div class="tooltip">₱{{ number_format($bar['total'], 0) }}</div>
                        </div>
                        <div class="chart-bar-label">{{ $bar['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($bestMonth)
            <div class="best-month-card">
                          <div class="best-month-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><path d="M8 21h8"/><path d="M12 17v4"/><path d="M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M7 5H4a2 2 0 0 0 0 4h1"/><path d="M17 5h3a2 2 0 0 1 0 4h-1"/></svg></div>
                <div>
                    <div class="best-month-label">Best Month</div>
                    <div class="best-month-value">
                        {{ \Carbon\Carbon::createFromDate($bestMonth->year, $bestMonth->month, 1)->format('F Y') }}
                        — ₱{{ number_format($bestMonth->total, 0) }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>

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
        <style>
            * { box-sizing: border-box; }
            body { font-family: Georgia, 'Times New Roman', serif; color: #2C1A0E; margin: 0; padding: 48px 56px; }
            .report-header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom: 2px solid #3B1F0F; padding-bottom: 16px; margin-bottom: 28px; }
            .report-title { font-size: 22px; font-weight: 700; margin: 0 0 4px; }
            .report-sub { font-size: 12px; color: #6B4A2A; margin: 0; }
            .report-meta { text-align: right; font-size: 11px; color: #9A7A5A; }
            .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
            .summary-box { border: 1px solid #EAE0D0; border-radius: 6px; padding: 14px 16px; }
            .summary-label { font-size: 10px; letter-spacing: 0.08em; text-transform: uppercase; color: #9A7A5A; margin-bottom: 6px; }
            .summary-value { font-size: 20px; font-weight: 700; color: #3B1F0F; }
            table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 24px; }
            th { text-align: left; font-size: 10px; letter-spacing: 0.06em; text-transform: uppercase; color: #6B4A2A; border-bottom: 1.5px solid #3B1F0F; padding: 8px 10px; }
            td { padding: 8px 10px; border-bottom: 1px solid #EAE0D0; }
            td.num, th.num { text-align: right; }
            .footer-note { font-size: 10px; color: #9A7A5A; margin-top: 40px; border-top: 1px solid #EAE0D0; padding-top: 12px; }
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
                ${rows || '<tr><td colspan="4" style="text-align:center;color:#9A7A5A;">No earnings recorded yet.</td></tr>'}
            </tbody>
        </table>

        <p class="footer-note">This report was generated automatically from your BakeSphere account activity and reflects completed orders at the time of generation.</p>

        <script>window.onload = function(){ setTimeout(function(){ window.print(); }, 300); };<\/script>
    </body>
    </html>
    `);
    win.document.close();
}
</script>
@endpush