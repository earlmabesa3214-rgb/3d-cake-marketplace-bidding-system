@extends('layouts.baker')
@section('title', 'Browse Requests')

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

    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; color:var(--brown-deep); }
    .page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-top:0.25rem; }

    .filters { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center; }
    .filter-btn { padding:0.35rem 1rem; border-radius:20px; font-size:0.78rem; font-weight:600; border:1.5px solid var(--border); background:transparent; color:var(--text-muted); cursor:pointer; text-decoration:none; transition:all 0.2s; }
    .filter-btn:hover, .filter-btn.active { border-color:var(--caramel); color:var(--caramel); background:#FBF3E8; }

    .search-bar { width:260px; flex:none; }

    .search-bar input { width:100%; padding:0.45rem 1rem; border-radius:20px; border:1.5px solid var(--border); background:var(--cream); font-size:0.82rem; font-family:inherit; outline:none; transition:border-color 0.2s; }
    .search-bar input:focus { border-color:var(--caramel); }

    .requests-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:1.25rem; }

    .req-card { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden; transition:transform 0.2s, box-shadow 0.2s; }
    .req-card:hover { transform:translateY(-3px); box-shadow:var(--shadow-lg); }
    .req-card-header { padding:1.25rem 1.5rem 1rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--cream); }
    .req-card-id { font-size:0.75rem; font-weight:700; color:var(--caramel); letter-spacing:0.05em; }
    .req-card-date { font-size:0.7rem; color:var(--text-muted); }

    .req-card-body { padding:1.25rem 1.5rem; }
.req-cake-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.1rem; color:var(--brown-deep); margin-bottom:0.4rem; }
    .req-tags { display:flex; flex-wrap:wrap; gap:0.4rem; margin-bottom:1rem; }
    .req-tag { padding:0.2rem 0.6rem; background:var(--cream); border:1px solid var(--border); border-radius:8px; font-size:0.68rem; color:var(--text-muted); font-weight:600; }

    .req-detail-row { display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0; border-bottom:1px dashed var(--border); font-size:0.8rem; }
    .req-detail-row:last-of-type { border-bottom:none; }
    .req-detail-label { color:var(--text-muted); font-weight:500; }
    .req-detail-val { font-weight:700; color:var(--text-dark); }

    .req-card-footer { padding:1rem 1.5rem; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--cream); }
    .bid-count-pill { font-size:0.7rem; color:var(--text-muted); display:flex; align-items:center; gap:0.3rem; }
    .bid-already { font-size:0.7rem; font-weight:700; color:var(--caramel); display:flex; align-items:center; gap:0.3rem; }

    .btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.25rem; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; cursor:pointer; border:none; transition:all 0.2s; }
    .btn-primary { background:var(--caramel); color:white; box-shadow:0 4px 12px rgba(200,137,58,0.3); }
    .btn-primary:hover { background:var(--caramel-light); transform:translateY(-1px); }
    .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--text-mid); }
    .btn-outline:hover { border-color:var(--caramel); color:var(--caramel); }

    .urgency-high { color:#B85A2A; font-weight:700; }
    .urgency-normal { color:var(--text-dark); }

    .empty-state { padding:4rem 2rem; text-align:center; color:var(--text-muted); }
    .empty-state .emoji { font-size:3rem; margin-bottom:1rem; }
.empty-state h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.2rem; color:var(--brown-mid); margin-bottom:0.5rem; }
</style>
@endpush

@section('content')
@php $profileIncomplete = !empty(\App\Http\Middleware\BakerProfileComplete::getMissingFields(auth()->user())); @endphp

@if($profileIncomplete)
<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;background:linear-gradient(135deg,#FEF3C7,#FDE68A);border:1.5px solid #F59E0B;border-radius:14px;padding:1rem 1.5rem;margin-bottom:1.5rem;flex-wrap:wrap;">
    <div style="display:flex;align-items:center;gap:0.75rem;">
        <span style="font-size:1.3rem;">⚠️</span>
        <div>
            <div style="font-size:0.88rem;font-weight:700;color:#78350F;">Your profile is incomplete — bidding is disabled</div>
            <div style="font-size:0.75rem;color:#92400E;margin-top:0.2rem;">
                Missing: 
                @foreach(\App\Http\Middleware\BakerProfileComplete::getMissingFields(auth()->user()) as $f)
                    <span style="background:rgba(245,158,11,0.2);border:1px solid rgba(245,158,11,0.4);color:#78350F;padding:0.1rem 0.5rem;border-radius:20px;font-weight:600;font-size:0.68rem;margin-right:0.25rem;">{{ $f }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('baker.profile.index') }}" style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.2rem;background:#F59E0B;color:#fff;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;white-space:nowrap;flex-shrink:0;">Complete Profile →</a>
</div>
@endif

<div class="page-header">
    <div>
        <h1 class="page-title">Browse Cake Orders</h1>
        <p class="page-subtitle">{{ $requests->total() }} open request{{ $requests->total() !== 1 ? 's' : '' }} awaiting bakers</p>
    </div>
</div>

<div class="filters">
    <span style="font-size:0.72rem; color:var(--text-muted); font-weight:600;">Sort:</span>
    <a href="{{ route('baker.requests.index', array_merge(request()->query(), ['sort'=>'newest'])) }}" class="filter-btn {{ request('sort','newest')==='newest' ? 'active':'' }}">Newest</a>
    <a href="{{ route('baker.requests.index', array_merge(request()->query(), ['sort'=>'deadline'])) }}" class="filter-btn {{ request('sort')==='deadline' ? 'active':'' }}"> Urgent First</a>
    <a href="{{ route('baker.requests.index', array_merge(request()->query(), ['sort'=>'budget_high'])) }}" class="filter-btn {{ request('sort')==='budget_high' ? 'active':'' }}"> High Budget</a>
    <span style="width:1px;height:20px;background:var(--border);"></span>
    <form method="GET" class="search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by flavor, shape…">
    </form>
</div>

@if($requests->count())
<div class="requests-grid">
    @foreach($requests as $req)
    @php
        $config = is_array($req->cake_configuration) ? $req->cake_configuration : (json_decode($req->cake_configuration,true) ?? []);
        $bidCount = $req->bids()->count();
        $myBid = $req->bids()->where('baker_id', auth()->id())->first();
$daysLeft = (int) now()->diffInDays($req->delivery_date, false);
    @endphp
    <div class="req-card">
        <div class="req-card-header">
            <span class="req-card-id">#{{ str_pad($req->id,4,'0',STR_PAD_LEFT) }}</span>
            <span class="req-card-date">Submitted {{ $req->created_at->diffForHumans() }}</span>
        </div>
        <div class="req-card-body">
            <div class="req-cake-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
            <div class="req-tags">
                @if(!empty($config['size'])) <span class="req-tag">{{ $config['size'] }}</span> @endif
                @if(!empty($config['frosting'])) <span class="req-tag">{{ $config['frosting'] }}</span> @endif
                @if(!empty($config['layers'])) <span class="req-tag">{{ $config['layers'] }} layers</span> @endif
                @if(!empty($config['addons'])) @foreach((array)$config['addons'] as $addon) <span class="req-tag">{{ $addon }}</span> @endforeach @endif
            </div>
            <div class="req-detail-row">
                <span class="req-detail-label">Budget</span>
                <span class="req-detail-val">₱{{ number_format($req->budget_min,0) }} – ₱{{ number_format($req->budget_max,0) }}</span>
            </div>
            <div class="req-detail-row">
                <span class="req-detail-label">Cake Needed by</span>
                <span class="req-detail-val {{ $daysLeft <= 3 ? 'urgency-high' : 'urgency-normal' }}">
                    {{ $req->delivery_date->format('M d, Y') }}
                    @if($daysLeft <= 3)  @endif
                    <span style="font-weight:400; font-size:0.7rem; color:var(--text-muted);"> ({{ $daysLeft }}d)</span>
                </span>
            </div>
            @if($req->delivery_address)
            <div class="req-detail-row">
                <span class="req-detail-label">Delivery Area</span>
                <span class="req-detail-val" style="font-size:0.75rem; text-align:right; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $req->delivery_address }}</span>
            </div>
            @endif
            @if($req->special_instructions)
            <div style="margin-top:0.75rem; padding:0.6rem 0.8rem; background:var(--cream); border-radius:8px; font-size:0.75rem; color:var(--text-muted); border-left:3px solid var(--caramel);">
                {{ Str::limit($req->special_instructions, 80) }}
            </div>
            @endif
        </div>
        <div class="req-card-footer">
            <div>
                @if($myBid)
                    <div class="bid-already">✓ You bid ₱{{ number_format($myBid->amount,0) }}</div>
                @else
                    <div class="bid-count-pill">🏷 {{ $bidCount }} bid{{ $bidCount !== 1 ? 's' : '' }}</div>
                @endif
            </div>
            <div style="display:flex;gap:0.5rem;">
              <a href="{{ route('baker.requests.show', $req->id) }}" class="btn btn-outline">View</a>
@if(!$myBid)
    @if($profileIncomplete)
        <a href="{{ route('baker.profile.index') }}" class="btn btn-primary" style="background:#D97706;" title="Complete your profile first">⚠ Complete Profile </a>
    @else
        <a href="{{ route('baker.requests.show', $req->id) }}#bid-form" class="btn btn-primary">Place Bid</a>
    @endif
@endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($requests->hasPages())
<div style="margin-top:1.5rem;">{{ $requests->links() }}</div>
@endif

@else
<div class="empty-state">
    <div class="emoji">🍰</div>
    <h3>No open requests right now</h3>
    <p>Check back soon — customers are submitting new cake orders regularly!</p>
</div>
@endif

@endsection