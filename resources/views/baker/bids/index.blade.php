@extends('layouts.baker')
@section('title', 'My Bids')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

:root {
    --brown-deep:    #3B1F0F;
    --brown-mid:     #7A4A28;
    --caramel:       #C8893A;
    --caramel-light: #E8A94A;
    --caramel-pale:  #FDF0DC;
    --warm-white:    #FFFDF9;
    --cream:         #F5EFE6;
    --border:        #EAE0D0;
    --text-dark:     #2C1A0E;
    --text-mid:      #6B4A2A;
    --text-muted:    #9A7A5A;
    --shadow-warm:   0 8px 40px rgba(59,31,15,0.12);
}
* { font-family: 'Plus Jakarta Sans', sans-serif; }
.table { table-layout: fixed; width: 100%; }
    .table th:nth-child(1), .table td:nth-child(1) { width: 10%; }
    .table th:nth-child(2), .table td:nth-child(2) { width: 20%; }
    .table th:nth-child(3), .table td:nth-child(3) { width: 12%; }
    .table th:nth-child(4), .table td:nth-child(4) { width: 14%; }
    .table th:nth-child(5), .table td:nth-child(5) { width: 13%; }
    .table th:nth-child(6), .table td:nth-child(6) { width: 10%; }
    .table th:nth-child(7), .table td:nth-child(7) { width: 13%; }
    .table th:nth-child(8), .table td:nth-child(8) { width: 11%; }
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; color:var(--brown-deep); }
.page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-top:0.25rem; }
    .filters { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center; }
    .filter-btn { padding:0.35rem 1rem; border-radius:20px; font-size:0.78rem; font-weight:600; border:1.5px solid var(--border); background:transparent; color:var(--text-muted); cursor:pointer; text-decoration:none; transition:all 0.2s; }
.filter-btn:hover, .filter-btn.active { border-color:var(--caramel); color:var(--caramel); background:#FEF3E8; }
    .card { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
    .table { width:100%; border-collapse:collapse; }
   .table th { padding:0.85rem 1.5rem; text-align:center; font-size:0.68rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--text-muted); border-bottom:1px solid var(--border); font-weight:600; background:var(--cream); }
    .table td { padding:1rem 1.5rem; font-size:0.86rem; border-bottom:1px solid var(--border); color:var(--text-dark); vertical-align:middle; text-align:center; }
    .table tr:last-child td { border-bottom:none; }
    .table tbody tr { transition:background 0.15s; }
   /* AFTER */
.table tbody tr:hover td { background: var(--cream); }

    .badge { display:inline-flex; align-items:center; gap:0.3rem; padding:0.28rem 0.75rem; border-radius:20px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; }
    .badge-PENDING  { background:#FEF9E8; color:#9B7A10; border:1px solid #F0D4B0; }
    .badge-ACCEPTED { background:#EDF7EE; color:#2D6A30; border:1px solid #C3E6C5; }
    .badge-REJECTED { background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
    .badge-WITHDRAWN{ background:#F5EDE8; color:#7A5A3A; border:1px solid #E8D4C0; }

    .pulse { display:inline-block; width:7px; height:7px; border-radius:50%; background:currentColor; animation:dot-pulse 1.5s ease-in-out infinite; }
    @keyframes dot-pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .btn-sm { display:inline-flex; align-items:center; gap:0.3rem; padding:0.35rem 0.8rem; border-radius:8px; font-size:0.75rem; font-weight:600; cursor:pointer; border:none; transition:all 0.2s; text-decoration:none; }
    .btn-view { background:var(--cream); border:1px solid var(--border); color:var(--text-mid); }
    .btn-view:hover { border-color:var(--caramel); color:var(--caramel); }
    .btn-withdraw { background:#FDF0EE; border:1px solid #F5C5BE; color:#8B2A1E; }
    .btn-withdraw:hover { background:#F5C5BE; }

    .empty-state { padding:4rem 2rem; text-align:center; color:var(--text-muted); }
    .empty-state .emoji { font-size:3rem; margin-bottom:1rem; }
    .empty-state h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.1rem; font-weight:800; color:var(--brown-mid); margin-bottom:0.5rem; }
.cake-info-sub { font-size:0.72rem; color:var(--text-muted); margin-top:0.15rem; }

/* ── PAGINATION ── */
nav[role="navigation"] { display:flex; align-items:center; justify-content:center; }
nav[role="navigation"] ul,
.pagination { display:flex; align-items:center; gap:0.3rem; list-style:none; margin:0; padding:0; }
.pagination li span,
.pagination li a {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:34px; height:34px; padding:0 0.6rem;
    border-radius:8px; font-size:0.8rem; font-weight:600;
    border:1.5px solid var(--border); color:var(--text-muted);
    background:white; text-decoration:none; transition:all 0.2s;
}
.pagination li a:hover { border-color:var(--caramel); color:var(--caramel); background:#FEF3E8; }
.pagination li span[aria-current="page"] {
    background:var(--caramel); color:white;
    border-color:var(--caramel); cursor:default;
}
.pagination li span.disabled,
.pagination li span:not([aria-current]) { color:#C8C0B0; cursor:default; background:#F8F4F0; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">My Bids</h1>
        <p class="page-subtitle">Track all bids you've placed on cake requests</p>
    </div>
</div>

<div class="filters">
    <span style="font-size:0.72rem; color:var(--text-muted); font-weight:600;">Filter:</span>
    <a href="{{ route('baker.bids.index') }}" class="filter-btn {{ !request('status') ? 'active':'' }}">All</a>
    <a href="{{ route('baker.bids.index', ['status'=>'PENDING']) }}" class="filter-btn {{ request('status')==='PENDING' ? 'active':'' }}">🟡 Pending</a>
    <a href="{{ route('baker.bids.index', ['status'=>'ACCEPTED']) }}" class="filter-btn {{ request('status')==='ACCEPTED' ? 'active':'' }}">🟢 Accepted</a>
    <a href="{{ route('baker.bids.index', ['status'=>'REJECTED']) }}" class="filter-btn {{ request('status')==='REJECTED' ? 'active':'' }}">🔴 Rejected</a>
</div>

<div class="card">
    @if($bids->count())
    <table class="table">
        <thead>
            <tr>
                <th>Request</th>
                <th>Cake</th>
                <th>My Bid</th>
                <th>Budget Range</th>
                <th>Delivery</th>
                <th>Placed</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($bids as $bid)
            @php
                $config = is_array($bid->cakeRequest->cake_configuration)
                    ? $bid->cakeRequest->cake_configuration
                    : (json_decode($bid->cakeRequest->cake_configuration,true) ?? []);
            @endphp
            <tr>
                <td>
                    <div style="font-weight:700; color:var(--caramel); font-size:0.9rem;">
                        #{{ str_pad($bid->cake_request_id, 4,'0',STR_PAD_LEFT) }}
                    </div>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                    <div class="cake-info-sub">{{ $config['size'] ?? '' }}@if(!empty($config['frosting'])) · {{ $config['frosting'] }} @endif</div>
                </td>
                <td>
                    <div style="font-weight:700; font-size:0.9rem; color:var(--brown-mid);">₱{{ number_format($bid->amount,0) }}</div>
                    @if($bid->estimated_days)
                    <div class="cake-info-sub">{{ $bid->estimated_days }}d est.</div>
                    @endif
                </td>
                <td style="font-size:0.78rem; color:var(--text-muted);">
                    ₱{{ number_format($bid->cakeRequest->budget_min,0) }}–{{ number_format($bid->cakeRequest->budget_max,0) }}
                </td>
                <td>
                    <div style="font-size:0.82rem; font-weight:600;">{{ $bid->cakeRequest->delivery_date->format('M d, Y') }}</div>
                    <div class="cake-info-sub">{{ $bid->cakeRequest->delivery_date->diffForHumans() }}</div>
                </td>
                <td style="font-size:0.78rem; color:var(--text-muted);">{{ $bid->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $bid->status }}">
                        @if($bid->status === 'PENDING') <span class="pulse"></span> @endif
                        {{ $bid->status }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('baker.requests.show', $bid->cake_request_id) }}" class="btn-sm btn-view">View</a>
                        @if($bid->status === 'PENDING')
                        <form method="POST" action="{{ route('baker.bids.destroy', $bid->id) }}" onsubmit="return confirm('Withdraw bid?')">
                            @csrf @method('DELETE')
                    
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($bids->hasPages())
    <div style="padding:1.25rem 1.5rem; border-top:1px solid var(--border);">
        {{ $bids->links() }}
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="emoji">💼</div>
        <h3>No bids yet</h3>
        <p>Browse open cake requests and place your first bid!</p>
        <a href="{{ route('baker.requests.index') }}" style="display:inline-flex;margin-top:1.25rem;padding:0.7rem 1.4rem;background:var(--caramel);color:white;border-radius:10px;font-weight:600;font-size:0.875rem;text-decoration:none;">
            Browse Requests →
        </a>
    </div>
    @endif
</div>

@endsection