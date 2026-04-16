@extends('layouts.customer')
@section('title', 'My Cake Requests')

@push('styles')
<style>
.table th:nth-child(1), .table td:nth-child(1) { width: 13%; }  /* Request */
.table th:nth-child(2), .table td:nth-child(2) { width: 20%; }  /* Cake */
.table th:nth-child(3), .table td:nth-child(3) { width: 14%; }  /* Budget */
.table th:nth-child(4), .table td:nth-child(4) { width: 16%; padding-left: 1rem; padding-right: 2.5rem; }  /* Delivery Date */
.table th:nth-child(5), .table td:nth-child(5) { width: 13%; padding-left: 0.5rem; padding-right: 5rem; }  /* Submitted */
.table th:nth-child(6), .table td:nth-child(6) { width: 8%; text-align: left; }

.table th:nth-child(7), .table td:nth-child(7) { width: 5%;  }  /* Arrow */

.table { table-layout: fixed; width: 100%; }
    /* PAGINATION */
.pagination-wrap { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.5rem; }
.pagination-info { font-size:0.75rem; color:var(--text-muted); }
.pagination { display:flex; align-items:center; gap:0.3rem; list-style:none; margin:0; padding:0; }
.pagination li span,
.pagination li a { display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:32px; padding:0 0.5rem; border-radius:8px; font-size:0.78rem; font-weight:600; text-decoration:none; border:1.5px solid var(--border); color:var(--text-muted); background:transparent; transition:all 0.2s; cursor:pointer; }
.pagination li a:hover { border-color:var(--caramel); color:var(--caramel); background:#FEF3E8; }
.pagination li.active span { background:var(--caramel); color:white; border-color:var(--caramel); }
.pagination li.disabled span { opacity:0.4; cursor:not-allowed; }
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.4rem; font-weight:800; color:var(--brown-deep); letter-spacing:-0.02em; }
.page-subtitle { font-size:0.78rem; color:var(--text-muted); margin-top:0.1rem; }
    .btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.7rem 1.4rem; border-radius:10px; font-size:0.875rem; font-weight:600; text-decoration:none; cursor:pointer; border:none; transition:all 0.2s; }
    .btn-primary { background:var(--caramel); color:white; box-shadow:0 4px 12px rgba(200,137,74,0.3); }
    .btn-primary:hover { background:var(--caramel-light); transform:translateY(-1px); }

    .filters { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center; }
    .filter-btn { padding:0.35rem 1rem; border-radius:20px; font-size:0.78rem; font-weight:600; border:1.5px solid var(--border); background:transparent; color:var(--text-muted); cursor:pointer; text-decoration:none; transition:all 0.2s; }
    .filter-btn:hover, .filter-btn.active { border-color:var(--caramel); color:var(--caramel); background:#FEF3E8; }

    .card { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden; }

    .table { width:100%; border-collapse:collapse; }
.table th { padding:0.85rem 1.5rem; text-align:center; font-size:0.68rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--text-muted); border-bottom:1px solid var(--border); font-weight:600; background:var(--cream); }
.table td { padding:1rem 1.5rem; font-size:0.86rem; border-bottom:1px solid var(--border); color:var(--text-dark); vertical-align:middle; text-align:center; }
    .table tr:last-child td { border-bottom:none; }
    .table tbody tr { cursor:pointer; transition:background 0.15s; }
    .table tbody tr:hover td { background:#FEF9F4; }
    .table tbody tr:hover .row-arrow { opacity:1; transform:translateX(0); }
    .row-arrow { opacity:0; transform:translateX(-6px); transition:all 0.2s; color:var(--caramel); font-size:1rem; }

    .badge { display:inline-flex; align-items:center; gap:0.3rem; padding:0.28rem 0.75rem; border-radius:20px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap; }
    .badge-OPEN        { background:#FEF9E8; color:#9B7A10; border:1px solid #F0D4B0; }
    .badge-BIDDING     { background:#EBF3FE; color:#1A5BBE; border:1px solid #BFDBFE; }
    .badge-ACCEPTED    { background:#EFF5EF; color:#2D6A30; border:1px solid #BFDFBE; }
    .badge-IN_PROGRESS { background:#EBF3FE; color:#1A5BBE; border:1px solid #BFDBFE; }
    .badge-COMPLETED   { background:#EFF5EF; color:#2D6A30; border:1px solid #BFDFBE; }
    .badge-CANCELLED   { background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
    .badge-EXPIRED     { background:#F5EDE8; color:#7A5A3A; border:1px solid #E8D4C0; }
    .badge-WAITING_FOR_PAYMENT   { background:#FFF4E0; color:#9B6010; border:1px solid #F5D8A0; }
.badge-WAITING_FINAL_PAYMENT { background:#FEF0D8; color:#8B5010; border:1px solid #F0C880; }
/* ADD this after the existing .badge rule */
.badge { 
    display:inline-flex; align-items:center; gap:0.3rem; 
    padding:0.28rem 0.65rem; border-radius:20px; font-size:0.65rem; 
    font-weight:700; text-transform:uppercase; letter-spacing:0.04em; 
    white-space:nowrap; 
}

    .pulse { display:inline-block; width:7px; height:7px; border-radius:50%; background:currentColor; animation:dot-pulse 1.5s ease-in-out infinite; }
    @keyframes dot-pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .cake-info-main { font-weight:600; color:var(--text-dark); }
    .cake-info-sub { font-size:0.72rem; color:var(--text-muted); margin-top:0.15rem; }

    .empty-state { padding:4rem 2rem; text-align:center; color:var(--text-muted); }
    .empty-state .emoji { font-size:3rem; margin-bottom:1rem; }
.empty-state h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.1rem; font-weight:800; color:var(--brown-mid); margin-bottom:0.5rem; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Order Transactions</h1>
        <p class="page-subtitle">Click any row to view its order tracker</p>
    </div>
   
</div>

<div class="filters">
    <span style="font-size:0.72rem; color:var(--text-muted); font-weight:600;">Filter:</span>
    <a href="{{ route('customer.cake-requests.index') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">All</a>
    <a href="{{ route('customer.cake-requests.index', ['status' => 'OPEN']) }}" class="filter-btn {{ request('status') === 'OPEN' ? 'active' : '' }}">🟡 Open</a>
    <a href="{{ route('customer.cake-requests.index', ['status' => 'BIDDING']) }}" class="filter-btn {{ request('status') === 'BIDDING' ? 'active' : '' }}">🔵 Bidding</a>
    <a href="{{ route('customer.cake-requests.index', ['status' => 'ACCEPTED']) }}" class="filter-btn {{ request('status') === 'ACCEPTED' ? 'active' : '' }}">🟢 Accepted</a>
    <a href="{{ route('customer.cake-requests.index', ['status' => 'COMPLETED']) }}" class="filter-btn {{ request('status') === 'COMPLETED' ? 'active' : '' }}">✓ Completed</a>
    <a href="{{ route('customer.cake-requests.index', ['status' => 'CANCELLED']) }}" class="filter-btn {{ request('status') === 'CANCELLED' ? 'active' : '' }}">✕ Cancelled</a>
</div>

<div class="card">
    @if($requests->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Request</th>
                    <th>Cake</th>
                    <th>Budget</th>
                    <th>Delivery Date</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                @php
                    $config = is_array($req->cake_configuration)
                        ? $req->cake_configuration
                        : (json_decode($req->cake_configuration, true) ?? []);
                @endphp
                <tr onclick="window.location='{{ route('customer.cake-requests.show', $req->id) }}'">
                    <td>
                        <div style="font-weight:700; color:var(--caramel); font-size:0.9rem;">
                            #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </td>
                    <td>
                        <div class="cake-info-main">
                            {{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}
                        </div>
                        <div class="cake-info-sub">
                            {{ $config['size'] ?? '' }}
                            @if(!empty($config['frosting'])) · {{ $config['frosting'] }} @endif
                            @if(!empty($config['addons'])) · {{ count((array)$config['addons']) }} add-ons @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.82rem; font-weight:600; color:var(--brown-mid);">
                            ₱{{ number_format($req->budget_min, 0) }} – ₱{{ number_format($req->budget_max, 0) }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.82rem; font-weight:600;">
                            {{ $req->delivery_date->format('M d, Y') }}
                        </div>
                        <div style="font-size:0.7rem; color:var(--text-muted);">
                            {{ $req->delivery_date->diffForHumans() }}
                        </div>
                    </td>
                    <td style="font-size:0.78rem; color:var(--text-muted);">
                        {{ $req->created_at->format('M d, Y') }}
                    </td>
                <td>
    <span class="badge badge-{{ $req->status }}">
        @if(in_array($req->status, ['OPEN','BIDDING']))
            <span class="pulse"></span>
        @endif
        {{ str_replace('_', ' ', $req->status) }}
    </span>
</td>
                    <td>
                        <span class="row-arrow">→</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($requests->hasPages())
        <div style="padding:1.25rem 1.5rem; border-top:1px solid var(--border);">
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} results
                </div>
                <ul class="pagination">
                    <li class="{{ $requests->onFirstPage() ? 'disabled' : '' }}">
                        @if($requests->onFirstPage())
                            <span>‹</span>
                        @else
                            <a href="{{ $requests->previousPageUrl() }}">‹</a>
                        @endif
                    </li>

                    @foreach($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                        <li class="{{ $page == $requests->currentPage() ? 'active' : '' }}">
                            @if($page == $requests->currentPage())
                                <span>{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach

                    <li class="{{ !$requests->hasMorePages() ? 'disabled' : '' }}">
                        @if($requests->hasMorePages())
                            <a href="{{ $requests->nextPageUrl() }}">›</a>
                        @else
                            <span>›</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        @endif

    @else
        <div class="empty-state">
            <div class="emoji">🎂</div>
            <h3>No requests yet</h3>
            <p>You haven't made any cake requests. Start your first one!</p>
            <a href="{{ route('customer.cake-requests.create') }}" class="btn btn-primary" style="margin-top:1.25rem; display:inline-flex;">
                + Create Your First Request
            </a>
        </div>
    @endif
</div>

@endsection