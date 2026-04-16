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
.page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem; }

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

.stat-icon  { font-size: 1.6rem; margin-bottom: 0.75rem; }
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
.best-month-icon { font-size: 1.5rem; flex-shrink: 0; }
.best-month-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.55); margin-bottom: 0.15rem; }
.best-month-value { font-family:'Plus Jakarta Sans',sans-serif; font-size: 1rem; color: #fff; font-weight: 700; }

/* ── EMPTY ── */
.empty-state { padding: 3rem 2rem; text-align: center; color: var(--text-muted); }
.empty-state .emoji { font-size: 2.5rem; margin-bottom: 0.75rem; }
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

<h1 class="page-title">Earnings</h1>
<p class="page-subtitle">Your financial overview and monthly breakdown</p>

{{-- ── STAT CARDS ── --}}
<div class="stats-grid">
    <div class="stat-card c1">
        <div class="stat-icon">💰</div>
        <div class="stat-value">₱{{ number_format($thisMonth, 0) }}</div>
        <div class="stat-label">This Month</div>
        <div class="stat-sub">{{ now()->format('F Y') }}</div>
    </div>
    <div class="stat-card c2">
        <div class="stat-icon">📈</div>
        <div class="stat-value">₱{{ number_format($allTime, 0) }}</div>
        <div class="stat-label">All Time Earnings</div>
        <div class="stat-sub">Since you joined</div>
    </div>
    <div class="stat-card c3">
        <div class="stat-icon">🎂</div>
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
                <div class="emoji">🫙</div>
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
                <div class="best-month-icon">🏆</div>
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