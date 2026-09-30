@extends('layouts.baker')
@section('title', 'My Bids')

@push('styles')
<style>
/* My Bids: luxury cake-atelier ledger. Plus Jakarta Sans only. */
.bids-page{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.bids-page *{box-sizing:border-box;font-family:inherit}
.bids-page a:focus-visible,.bids-page button:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes bp-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes bp-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes bp-pulse{0%,100%{opacity:1}50%{opacity:.3}}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important}}

/* header */
.bids-page .page-header{position:relative;margin:0 0 2rem;padding-bottom:1.75rem;animation:bp-fadeUp .6s var(--e) backwards}
.page-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.page-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:bp-line .9s var(--e) .3s backwards}
.page-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.page-subtitle{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* filters */
.filters{display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;margin-bottom:2rem;animation:bp-fadeUp .6s var(--e) .1s backwards}
.filters-label{font-size:.6rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);margin-right:.75rem}
.filter-btn{display:inline-flex;align-items:center;gap:.55rem;padding:.65rem 1.1rem;background:transparent;border:1px solid var(--beige);font-size:.66rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mocha);text-decoration:none;cursor:pointer;transition:background .3s,color .3s,border-color .3s}
.filter-btn:hover{border-color:var(--gold);color:var(--esp);text-decoration:none}
.filter-btn.active{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.filter-dot{width:7px;height:7px;flex-shrink:0;transform:rotate(45deg)}
.filter-dot.pending{background:var(--gold)}
.filter-dot.accepted{background:var(--sage)}
.filter-dot.rejected{background:var(--burg)}

/* ledger */
.card{border-top:1px solid var(--esp);animation:bp-fadeUp .6s var(--e) .2s backwards}
.table-scroll{overflow-x:auto;scrollbar-width:thin;scrollbar-color:var(--gold-line) transparent}
.table{width:100%;min-width:920px;border-collapse:collapse;table-layout:fixed}
.table th:nth-child(1),.table td:nth-child(1){width:9%}
.table th:nth-child(2),.table td:nth-child(2){width:20%}
.table th:nth-child(3),.table td:nth-child(3){width:11%}
.table th:nth-child(4),.table td:nth-child(4){width:14%}
.table th:nth-child(5),.table td:nth-child(5){width:14%}
.table th:nth-child(6),.table td:nth-child(6){width:10%}
.table th:nth-child(7),.table td:nth-child(7){width:12%}
.table th:nth-child(8),.table td:nth-child(8){width:10%}
.table th{padding:1rem .75rem;text-align:left;font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);border-bottom:1px solid var(--esp)}
.table th:first-child,.table td:first-child{padding-left:0}
.table th:last-child,.table td:last-child{padding-right:0}
.table td{padding:1.25rem .75rem;font-size:.84rem;color:var(--esp);border-bottom:1px solid var(--line);vertical-align:middle}
.table tbody tr{opacity:0;animation:bp-fadeUp .5s var(--e) forwards;transition:background .3s}
.table tbody tr:hover td{background:rgba(239,230,215,.5)}
.table tr:last-child td{border-bottom:0}
.ref-label{font-size:.54rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}
.ref-num{margin-top:.2rem;font-size:1rem;font-weight:900;letter-spacing:-.03em;color:var(--caramel);font-variant-numeric:tabular-nums}
.cake-name{font-size:.95rem;font-weight:800;letter-spacing:-.02em}
.cake-info-sub{margin-top:.25rem;font-size:.72rem;color:var(--taupe)}
.bid-amount{font-size:1.05rem;font-weight:900;letter-spacing:-.03em;color:var(--credit);font-variant-numeric:tabular-nums}
.budget-cell{font-size:.78rem;font-weight:600;color:var(--mocha);font-variant-numeric:tabular-nums}
.date-main{font-size:.82rem;font-weight:700}
.placed-cell{font-size:.78rem;color:var(--mocha)}

/* status */
.badge{display:inline-flex;align-items:center;gap:.4rem;padding:.3rem .6rem;border:1px solid transparent;border-left-width:2px;font-size:.56rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;white-space:nowrap}
.badge-PENDING{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.badge-ACCEPTED{background:#EFF2E8;color:#33502F;border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.badge-REJECTED{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}
.badge-WITHDRAWN{background:var(--cream);color:var(--mocha);border-color:var(--beige);border-left-color:var(--taupe)}
.pulse{display:inline-block;width:6px;height:6px;border-radius:50%;background:currentColor;animation:bp-pulse 1.6s ease-in-out infinite}

/* actions */
.row-actions{display:flex;gap:.4rem;align-items:center}
.btn-sm{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem .9rem;background:transparent;border:1px solid var(--esp);font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);text-decoration:none;cursor:pointer;transition:background .3s,color .3s}
.btn-view:hover{background:var(--esp);color:var(--gold-l);text-decoration:none}
.btn-withdraw{border-color:rgba(84,37,44,.3);color:var(--burg)}
.btn-withdraw:hover{background:var(--burg);border-color:var(--burg);color:var(--ivory)}

/* pagination (works with the default and bootstrap views) */
.pager-wrap{padding:1.25rem 0;border-top:1px solid var(--esp)}
.pager-wrap nav{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:.75rem}
.pager-wrap nav svg{width:14px;height:14px}
.pager-wrap nav p{font-size:.6rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe)}
.pager-wrap nav a,.pager-wrap nav span[aria-current] span,.pager-wrap nav span[aria-disabled] span,
.pagination li span,.pagination li a{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 .6rem;border:1px solid transparent;border-radius:0;font-size:.78rem;font-weight:800;text-decoration:none;color:var(--mocha);background:transparent;transition:.3s}
.pager-wrap nav a:hover,.pagination li a:hover{border-color:var(--gold);color:var(--esp);background:transparent}
.pager-wrap nav span[aria-current] span,.pagination li.active span,.pagination li span[aria-current="page"]{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.pager-wrap nav span[aria-disabled] span,.pagination li.disabled span{opacity:.35}
.pagination{display:flex;align-items:center;gap:.25rem;list-style:none;margin:0;padding:0}
.pager-wrap nav>div:first-child{display:none}
@media(min-width:640px){.pager-wrap nav>div:first-child{display:none}}

/* empty */
.empty-state{padding:4.5rem 1rem;text-align:center;border-bottom:1px solid var(--line)}
.empty-icon{display:flex;justify-content:center;margin-bottom:1.1rem;color:var(--gold);opacity:.75}
.empty-state .eyebrow{display:block;font-size:.6rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--caramel);margin-bottom:.8rem}
.empty-state h3{font-size:clamp(1.5rem,3vw,2.2rem);font-weight:900;letter-spacing:-.04em;line-height:1;margin:0 0 .7rem}
.empty-state p{font-size:.92rem;color:var(--mocha);max-width:44ch;margin:0 auto}
.empty-cta{display:inline-flex;align-items:center;gap:.6rem;margin-top:1.6rem;padding:1.05rem 1.7rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:background .3s,color .3s,transform .3s var(--e)}
.empty-cta:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);text-decoration:none}
</style>
@endpush

@section('content')
<div class="bids-page">

<div class="page-header">
    <div>
        <h1 class="page-title">My Bids</h1>
        <p class="page-subtitle">Track all bids you've placed on cake requests</p>
    </div>
</div>

<div class="filters">
    <span class="filters-label">Filter</span>
    <a href="{{ route('baker.bids.index') }}" class="filter-btn {{ !request('status') ? 'active':'' }}">All</a>
    <a href="{{ route('baker.bids.index', ['status'=>'PENDING']) }}" class="filter-btn {{ request('status')==='PENDING' ? 'active':'' }}"><span class="filter-dot pending"></span>Pending</a>
    <a href="{{ route('baker.bids.index', ['status'=>'ACCEPTED']) }}" class="filter-btn {{ request('status')==='ACCEPTED' ? 'active':'' }}"><span class="filter-dot accepted"></span>Accepted</a>
    <a href="{{ route('baker.bids.index', ['status'=>'REJECTED']) }}" class="filter-btn {{ request('status')==='REJECTED' ? 'active':'' }}"><span class="filter-dot rejected"></span>Rejected</a>
</div>

<div class="card">
    @if($bids->count())
    <div class="table-scroll">
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
            <tr style="animation-delay: {{ min($loop->index, 12) * 0.05 + 0.3 }}s;">
                <td>
                    <div class="ref-label">Request</div>
                    <div class="ref-num">#{{ str_pad($bid->cake_request_id, 4,'0',STR_PAD_LEFT) }}</div>
                </td>
                <td>
                    <div class="cake-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                    <div class="cake-info-sub">{{ $config['size'] ?? '' }}@if(!empty($config['frosting'])) · {{ $config['frosting'] }} @endif</div>
                </td>
                <td>
                    <div class="bid-amount">₱{{ number_format($bid->amount,0) }}</div>
                    @if($bid->estimated_days)
                    <div class="cake-info-sub">{{ $bid->estimated_days }}d est.</div>
                    @endif
                </td>
                <td class="budget-cell">
                    ₱{{ number_format($bid->cakeRequest->budget_min,0) }}–{{ number_format($bid->cakeRequest->budget_max,0) }}
                </td>
                <td>
                    <div class="date-main">{{ $bid->cakeRequest->delivery_date->format('M d, Y') }}</div>
                    <div class="cake-info-sub">{{ $bid->cakeRequest->delivery_date->diffForHumans() }}</div>
                </td>
                <td class="placed-cell">{{ $bid->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $bid->status }}">
                        @if($bid->status === 'PENDING') <span class="pulse"></span> @endif
                        {{ $bid->status }}
                    </span>
                </td>
                <td>
                    <div class="row-actions">
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
    </div>

    @if($bids->hasPages())
    <div class="pager-wrap">
        {{ $bids->links() }}
    </div>
    @endif

    @else
    <div class="empty-state">
        <div class="empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M2 13h20"/></svg></div>
        <span class="eyebrow">Your bid ledger</span>
        <h3>No bids yet</h3>
        <p>Browse open cake requests and place your first bid!</p>
        <a href="{{ route('baker.requests.index') }}" class="empty-cta">
            Browse Requests
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
    @endif
</div>

</div>
@endsection