@extends('layouts.baker')
@section('title', 'Dashboard')

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
        --shadow-lg:    0 8px 32px rgba(59,31,15,0.12);
    }

    .page-title { font-family:'Playfair Display',serif; font-size:1.75rem; color:var(--brown-deep); margin-bottom:0.25rem; }
    .page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem; }

    /* STAT CARDS */
    .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:2rem; }
    .stat-card { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; padding:1.5rem; position:relative; overflow:hidden; transition:transform 0.2s, box-shadow 0.2s; }
    .stat-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-lg); }
    .stat-card::after { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:16px 16px 0 0; }
    .stat-card.c1::after { background:linear-gradient(90deg, var(--caramel), var(--caramel-light)); }
    .stat-card.c2::after { background:linear-gradient(90deg, #9A6028, #C8803A); }
    .stat-card.c3::after { background:linear-gradient(90deg, #7A4A28, #B87040); }
    .stat-card.c4::after { background:linear-gradient(90deg, var(--brown-deep), var(--brown-mid)); }
    .stat-icon { font-size:1.6rem; margin-bottom:0.75rem; }
    .stat-value { font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; color:var(--brown-deep); line-height:1; }
    .stat-label { font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--text-muted); font-weight:600; margin-top:0.3rem; }
    .stat-change { font-size:0.72rem; color:var(--caramel); font-weight:600; margin-top:0.5rem; }

    /* MAIN GRID */
    .main-grid { display:grid; grid-template-columns:1fr 360px; gap:1.5rem; }

    .card { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
    .card-header { padding:1.25rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
    .card-title { font-family:'Playfair Display',serif; font-size:1.05rem; color:var(--brown-deep); }
    .card-link { font-size:0.78rem; color:var(--caramel); text-decoration:none; font-weight:600; }
    .card-link:hover { text-decoration:underline; }

    /* OPEN REQUESTS LIST */
    .request-item { padding:1.1rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:1rem; transition:background 0.15s; cursor:pointer; text-decoration:none; }
    .request-item:last-child { border-bottom:none; }
    .request-item:hover { background:#FBF5EE; }
    .req-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,#F5EFE6,#EDD0A8); display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .req-info { flex:1; min-width:0; }
    .req-name { font-weight:600; font-size:0.875rem; color:var(--text-dark); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .req-meta { font-size:0.72rem; color:var(--text-muted); margin-top:0.15rem; }
    .req-budget { text-align:right; }
    .req-budget-val { font-size:0.9rem; font-weight:700; color:var(--brown-mid); }
    .req-budget-date { font-size:0.68rem; color:var(--text-muted); }
    .req-bid-count { display:inline-flex; align-items:center; gap:0.25rem; font-size:0.68rem; font-weight:700; padding:0.2rem 0.5rem; border-radius:8px; background:#FBF3E8; color:var(--brown-mid); margin-top:0.25rem; }

    /* ACTIVE BIDS LIST */
    .bid-item { padding:1.1rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:1rem; }
    .bid-item:last-child { border-bottom:none; }
    .bid-status { display:inline-flex; align-items:center; gap:0.3rem; padding:0.25rem 0.65rem; border-radius:20px; font-size:0.68rem; font-weight:700; text-transform:uppercase; white-space:nowrap; }
    .bid-status.pending  { background:#FEF6E4; color:#9B6A10; border:1px solid #EDD090; }
    .bid-status.accepted { background:#FBF0E6; color:#7A3A10; border:1px solid #E5C0A0; }
    .bid-status.rejected { background:#F8EDEA; color:#8B2A1E; border:1px solid #DDB5A8; }

    /* EARNINGS MINI CHART */
    .earnings-bars { display:flex; align-items:flex-end; gap:6px; height:80px; padding:0 1.5rem 1.5rem; }
    .e-bar-wrap { flex:1; display:flex; flex-direction:column; align-items:center; gap:4px; }
    .e-bar { width:100%; border-radius:6px 6px 0 0; background:linear-gradient(to top, var(--caramel), var(--caramel-light)); min-height:4px; transition:height 0.5s ease; }
    .e-bar-label { font-size:0.55rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; }

    .empty-mini { padding:2rem; text-align:center; color:var(--text-muted); font-size:0.82rem; }
    .empty-mini .emo { font-size:1.8rem; margin-bottom:0.5rem; }
</style>
@endpush

@section('content')

<h1 class="page-title">Baker Dashboard</h1>
<p class="page-subtitle">Welcome back — here's what's happening today.</p>

<div class="stats-grid">
    <div class="stat-card c1">
        <div class="stat-icon">🎂</div>
        <div class="stat-value">{{ $openRequestsCount }}</div>
        <div class="stat-label">Open Requests</div>
        <div class="stat-change">↑ Available to bid</div>
    </div>
    <div class="stat-card c2">
        <div class="stat-icon">💼</div>
        <div class="stat-value">{{ $myActiveBidsCount }}</div>
        <div class="stat-label">My Active Bids</div>
        <div class="stat-change">Awaiting response</div>
    </div>
    <div class="stat-card c3">
        <div class="stat-icon">📦</div>
        <div class="stat-value">{{ $activeOrdersCount }}</div>
        <div class="stat-label">Orders in Progress</div>
        <div class="stat-change">Currently baking</div>
    </div>
    <div class="stat-card c4">
        <div class="stat-icon">💰</div>
        <div class="stat-value">₱{{ number_format($monthEarnings, 0) }}</div>
        <div class="stat-label">This Month</div>
        <div class="stat-change">{{ $completedThisMonth }} completed</div>
    </div>
</div>

<div class="main-grid">
    <div>
        <div class="card" style="margin-bottom:1.5rem;">
            <div class="card-header">
                <h2 class="card-title">🍰 Open Requests Near You</h2>
                <a href="{{ route('baker.requests.index') }}" class="card-link">View all →</a>
            </div>
            @forelse($openRequests as $req)
            @php
                $config = is_array($req->cake_configuration) ? $req->cake_configuration : (json_decode($req->cake_configuration,true) ?? []);
                $bidCount = $req->bids()->count();
            @endphp
            <a class="request-item" href="{{ route('baker.requests.show', $req->id) }}">
                <div class="req-icon">🎂</div>
                <div class="req-info">
                    <div class="req-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                    <div class="req-meta">
                        {{ $config['size'] ?? '' }}
                        @if(!empty($config['frosting'])) · {{ $config['frosting'] }} @endif
                        · Due {{ $req->delivery_date->format('M d') }}
                    </div>
                    @if($bidCount > 0)
                    <div class="req-bid-count">🏷 {{ $bidCount }} bid{{ $bidCount > 1 ? 's' : '' }}</div>
                    @endif
                </div>
                <div class="req-budget">
                    <div class="req-budget-val">₱{{ number_format($req->budget_min,0) }}–{{ number_format($req->budget_max,0) }}</div>
                    <div class="req-budget-date">{{ $req->delivery_date->diffForHumans() }}</div>
                </div>
            </a>
            @empty
            <div class="empty-mini">
                <div class="emo">🫙</div>
                No open requests right now. Check back soon!
            </div>
            @endforelse
        </div>
    </div>

    <div>
        <div class="card" style="margin-bottom:1.5rem;">
            <div class="card-header">
                <h2 class="card-title">My Recent Bids</h2>
                <a href="{{ route('baker.bids.index') }}" class="card-link">All bids →</a>
            </div>
            @forelse($recentBids as $bid)
            <div class="bid-item">
                <div style="flex:1; min-width:0;">
                    <div style="font-size:0.82rem; font-weight:600; color:var(--text-dark);">
                        #{{ str_pad($bid->cake_request_id, 4,'0',STR_PAD_LEFT) }}
                        {{ $bid->cakeRequest->cake_configuration['flavor'] ?? 'Cake' }}
                    </div>
                    <div style="font-size:0.7rem; color:var(--text-muted); margin-top:0.1rem;">
                        Offered ₱{{ number_format($bid->amount, 0) }} · {{ $bid->created_at->diffForHumans() }}
                    </div>
                </div>
                <span class="bid-status {{ strtolower($bid->status) }}">{{ $bid->status }}</span>
            </div>
            @empty
            <div class="empty-mini">
                <div class="emo">💼</div>
                No bids placed yet.
            </div>
            @endforelse
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Earnings (6 months)</h2>
                <a href="{{ route('baker.earnings.index') }}" class="card-link">Details →</a>
            </div>
            @php $maxEarning = max(array_column($earningsChart, 'total') ?: [1]) ?: 1; @endphp
            <div class="earnings-bars">
                @foreach($earningsChart as $month)
                <div class="e-bar-wrap">
                    <div class="e-bar" style="height:{{ max(4, ($month['total']/$maxEarning)*72) }}px;" title="₱{{ number_format($month['total'],0) }}"></div>
                    <div class="e-bar-label">{{ $month['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection