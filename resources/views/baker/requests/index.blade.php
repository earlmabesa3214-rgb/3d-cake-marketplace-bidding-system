@extends('layouts.baker')
@section('title', 'Browse Requests')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --espresso:       #24150F;
        --dark-chocolate: #3A241A;
        --warm-ivory:     #F7F2E9;
        --cream:          #EFE6D7;
        --caramel:        #A96F42;
        --champagne-gold: #B89452;
        --deep-burgundy:  #54252C;
        --taupe:          #9A897A;
        --soft-beige:     #D8C8B7;

        --text-dark:  #24150F;
        --text-mid:   #6F5848;
        --text-muted: #9A897A;

        --ease: cubic-bezier(.22,.8,.32,1);
        --shadow-card: 0 1px 2px rgba(36,21,15,.06), 0 10px 30px -14px rgba(36,21,15,.2);
        --shadow-lift: 0 2px 4px rgba(36,21,15,.06), 0 26px 50px -20px rgba(36,21,15,.34);
    }

    .br-page, .br-page * { font-family:'Plus Jakarta Sans', sans-serif; }
    .br-page .ico { width:1em; height:1em; stroke:currentColor; fill:none; stroke-width:1.75; stroke-linecap:round; stroke-linejoin:round; flex:none; }

    /* ═══ ANIMATIONS ═══ */
    @keyframes brFadeDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:none; } }
    @keyframes brFadeUp   { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:none; } }
    @keyframes brReveal   { from { opacity:0; transform:scale(1.06); } to { opacity:1; transform:none; } }
    @keyframes brRule     { from { transform:scaleX(0); } to { transform:scaleX(1); } }

    @media (prefers-reduced-motion: reduce) {
        .br-page *, .br-page *::before, .br-page *::after { animation:none !important; transition:none !important; }
    }

    .br-anim-banner     { animation:brFadeDown .6s var(--ease) backwards; }
    .br-anim-header     { animation:brFadeUp .6s var(--ease) .06s backwards; }
    .br-anim-filters    { animation:brFadeUp .6s var(--ease) .12s backwards; }
    .br-anim-card       { animation:brFadeUp .7s var(--ease) backwards; }
    .br-anim-empty      { animation:brFadeUp .7s var(--ease) .1s backwards; }
    .br-anim-pagination { animation:brFadeUp .6s var(--ease) .1s backwards; }

    /* ═══ PROFILE BANNER ═══ */
    .profile-banner { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem; padding:1.1rem 1.5rem;
        background:var(--warm-ivory); border:1px solid var(--soft-beige); border-left:3px solid var(--deep-burgundy); box-shadow:var(--shadow-card); }
    .profile-banner-main { display:flex; align-items:flex-start; gap:.9rem; }
    .profile-banner-icon { width:40px; height:40px; display:grid; place-items:center; border:1px solid var(--champagne-gold); background:var(--cream); color:var(--deep-burgundy); font-size:19px; }
    .profile-banner-eyebrow { font-size:.62rem; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:var(--deep-burgundy); }
    .profile-banner-title { font-size:.92rem; font-weight:800; color:var(--text-dark); margin-top:.2rem; }
    .profile-banner-text { font-size:.78rem; color:var(--text-mid); margin-top:.2rem; display:flex; flex-wrap:wrap; align-items:center; gap:.35rem; }
    .profile-banner-field { padding:.12rem .55rem; border:1px solid var(--soft-beige); background:var(--cream); color:var(--deep-burgundy); font-weight:600; font-size:.68rem; }

    /* ═══ PAGE HEADER (matches My Orders / My Bids) ═══ */
    .page-header { display:block; margin-bottom:2.25rem; padding:0 0 2.2rem; background:none; box-shadow:none; overflow:visible; color:var(--text-dark);
        border-bottom:1px solid var(--soft-beige); position:relative; }
    .page-header::before { content:''; position:absolute; left:0; bottom:-1px; width:72px; height:2px; background:var(--champagne-gold); transform-origin:left; animation:brRule 1s var(--ease) .3s backwards; }
    .page-title { margin:0; font-size:clamp(2.6rem,7vw,4.6rem); font-weight:800; letter-spacing:-.04em; line-height:1.02; color:var(--espresso); }
    .page-subtitle { margin:.9rem 0 0; font-size:1rem; font-weight:400; color:var(--text-mid); }

    /* ═══ FILTERS ═══ */
    .filters { display:flex; gap:.6rem; flex-wrap:wrap; align-items:center; margin-bottom:2rem; padding:0; background:none; border:none; box-shadow:none; }
    .filters-label { margin-right:.9rem; font-size:.62rem; font-weight:700; letter-spacing:.22em; text-transform:uppercase; color:var(--text-muted); }
    .filter-btn { display:inline-flex; align-items:center; gap:.55rem; padding:.85rem 1.1rem; border:1px solid var(--soft-beige); border-radius:2px; background:var(--warm-ivory); color:var(--text-mid);
        font-size:.68rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; text-decoration:none; cursor:pointer; transition:background .3s var(--ease), color .3s var(--ease), border-color .3s var(--ease); }
    .filter-btn::before { content:''; width:6px; height:6px; background:var(--champagne-gold); transform:rotate(45deg); transition:transform .3s var(--ease); }
    .filter-btn:hover { border-color:var(--espresso); color:var(--text-dark); }
    .filter-btn:hover::before { transform:rotate(45deg) scale(1.3); }
    .filter-btn.active { background:var(--espresso); border-color:var(--espresso); color:var(--warm-ivory); }
    .filter-btn.active::before { display:none; }
    .filter-divider { display:none; }

    .search-bar { position:relative; width:280px; flex:none; margin:0 0 0 auto; }
    .search-bar .ico { position:absolute; left:.9rem; top:50%; transform:translateY(-50%); width:15px; height:15px; color:var(--taupe); pointer-events:none; }
    .search-bar input { width:100%; padding:.85rem 1rem .85rem 2.45rem; border:1px solid var(--soft-beige); border-radius:2px; background:#fff; color:var(--text-dark); font-size:.82rem; outline:none; transition:border-color .3s var(--ease), box-shadow .3s var(--ease); }
    .search-bar input::placeholder { color:var(--taupe); }
    .search-bar input:focus { border-color:var(--champagne-gold); box-shadow:0 0 0 3px rgba(184,148,82,.18); }

    /* ═══ GRID + CARD ═══ */
    .requests-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:1.75rem; }

    .req-card { display:flex; flex-direction:column; overflow:hidden; background:var(--warm-ivory); border:1px solid var(--soft-beige); border-radius:4px; box-shadow:var(--shadow-card);
        transition:transform .5s var(--ease), box-shadow .5s var(--ease), border-color .5s var(--ease); }
    .req-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lift); border-color:var(--champagne-gold); }

    .req-media { position:relative; aspect-ratio:4/3; overflow:hidden;
        background:radial-gradient(70% 60% at 50% 42%, #FFFBF3 0%, rgba(255,251,243,0) 70%), linear-gradient(180deg,var(--warm-ivory) 0%,var(--cream) 100%); }
    .req-media::before { content:''; position:absolute; inset:10px; border:1px solid rgba(184,148,82,.45); pointer-events:none; z-index:1; }
    .req-media img { width:100%; height:100%; object-fit:contain; display:block; padding:1.6rem 1.4rem; filter:drop-shadow(0 16px 16px rgba(36,21,15,.22));
        animation:brReveal 1s var(--ease) backwards; transition:transform .8s var(--ease); }
    .req-card:hover .req-media img { transform:scale(1.04); }
    .req-media-empty { height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.5rem; color:var(--taupe); }
    .req-media-empty .ico { width:46px; height:46px; stroke-width:1.1; color:var(--champagne-gold); }
    .req-media-empty small { font-size:.62rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; }

    .req-chip { position:absolute; z-index:2; padding:.32rem .65rem; border-radius:2px; font-size:.68rem; font-weight:700; backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); animation:brFadeDown .5s var(--ease) .15s backwards; }
    .req-chip-id   { top:20px; left:20px; background:rgba(36,21,15,.88); color:var(--warm-ivory); letter-spacing:.1em; border-left:2px solid var(--champagne-gold); }
    .req-chip-days { top:20px; right:20px; background:rgba(247,242,233,.94); color:var(--text-dark); letter-spacing:.08em; text-transform:uppercase; border-right:2px solid var(--champagne-gold); }
    .req-chip-days.is-urgent { background:var(--deep-burgundy); color:var(--warm-ivory); }
    .req-chip-time { bottom:20px; left:20px; display:inline-flex; align-items:center; gap:.35rem; background:rgba(247,242,233,.9); color:var(--text-mid); font-weight:600; }
    .req-chip-time .ico { width:12px; height:12px; }

    .req-card-body { flex:1; padding:1.3rem 1.5rem; }
    .req-cake-name { margin-bottom:.6rem; font-size:1.2rem; font-weight:800; letter-spacing:-.02em; line-height:1.25; color:var(--text-dark);
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .req-tags { display:flex; flex-wrap:wrap; gap:.4rem; margin-bottom:1.1rem; }
    .req-tag { padding:.22rem .6rem; border:1px solid var(--soft-beige); border-radius:2px; background:var(--cream); color:var(--text-mid); font-size:.68rem; font-weight:600; }
    .req-tag-more { background:transparent; border-color:var(--champagne-gold); color:var(--caramel); }

    .req-budget { display:flex; justify-content:space-between; align-items:center; gap:.75rem; margin-bottom:.5rem; padding:.85rem 1rem;
        background:linear-gradient(135deg,var(--cream),var(--warm-ivory)); border:1px solid var(--soft-beige); border-left:2px solid var(--champagne-gold); border-radius:2px; }
    .req-budget-val { font-size:1.2rem; font-weight:800; letter-spacing:-.02em; color:var(--espresso); white-space:nowrap; }

    .req-detail-row { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:.6rem 0; border-bottom:1px solid var(--soft-beige); font-size:.8rem; }
    .req-detail-row:last-of-type { border-bottom:none; }
    .req-detail-label { color:var(--text-muted); font-size:.62rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; }
    .req-detail-val { font-weight:700; color:var(--text-dark); }
    .req-detail-val small { font-weight:500; font-size:.7rem; color:var(--text-muted); }
    .req-detail-val.is-address { max-width:190px; font-size:.78rem; text-align:right; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .urgency-high { color:var(--deep-burgundy); }
    .urgency-normal { color:var(--text-dark); }

    .req-note { margin-top:.9rem; padding:.1rem 0 .1rem .9rem; border-left:2px solid var(--champagne-gold); font-size:.8rem; font-style:italic; line-height:1.6; color:var(--text-mid); }

    .req-card-footer { display:flex; align-items:center; justify-content:space-between; gap:.75rem; flex-wrap:wrap; padding:1rem 1.5rem 1.2rem; border-top:1px solid var(--soft-beige);
        background:linear-gradient(180deg,transparent,rgba(239,230,215,.6)); }
    .bid-count-pill, .bid-already { display:flex; align-items:center; gap:.4rem; font-size:.74rem; font-weight:700; letter-spacing:.04em; }
    .bid-count-pill { color:var(--text-mid); }
    .bid-count-pill .ico { width:15px; height:15px; color:var(--champagne-gold); }
    .bid-already { color:var(--espresso); }
    .bid-already .ico { width:15px; height:15px; stroke-width:2.4; color:var(--champagne-gold); }
    .req-card-actions { display:flex; gap:.5rem; }

    /* ═══ BUTTONS ═══ */
    .btn { display:inline-flex; align-items:center; gap:.45rem; padding:.62rem 1rem; border:1px solid transparent; border-radius:3px; font-size:.68rem; font-weight:700; letter-spacing:.13em; text-transform:uppercase; text-decoration:none; white-space:nowrap; cursor:pointer;
        transition:background .3s var(--ease), color .3s var(--ease), border-color .3s var(--ease), transform .3s var(--ease); }
    .btn .ico { width:13px; height:13px; transition:transform .3s var(--ease); }
    .btn:hover .ico { transform:translateX(3px); }
    .btn:active { transform:scale(.98); }
    .btn:focus-visible, .filter-btn:focus-visible { outline:2px solid var(--champagne-gold); outline-offset:2px; }
    .btn-primary { background:var(--espresso); border-color:var(--espresso); color:var(--warm-ivory); box-shadow:inset 0 -2px 0 var(--champagne-gold); }
    .btn-primary:hover { background:var(--dark-chocolate); border-color:var(--dark-chocolate); }
    .btn-outline { background:transparent; border-color:var(--soft-beige); color:var(--text-dark); }
    .btn-outline:hover { background:var(--warm-ivory); border-color:var(--espresso); }
    .btn-gold { background:var(--champagne-gold); border-color:var(--champagne-gold); color:var(--espresso); }
    .btn-gold:hover { background:var(--espresso); border-color:var(--espresso); color:var(--warm-ivory); }

    /* ═══ EMPTY STATE ═══ */
    .empty-state { position:relative; padding:clamp(3rem,7vw,5rem) 1.5rem; text-align:center; color:var(--text-mid); border:1px solid var(--soft-beige);
        background:radial-gradient(50% 70% at 50% 0%, rgba(184,148,82,.14), transparent 70%), var(--warm-ivory); box-shadow:var(--shadow-card); }
    .empty-state::before { content:''; position:absolute; inset:10px; border:1px solid rgba(184,148,82,.3); pointer-events:none; }
    .empty-state .empty-icon { width:80px; height:80px; margin:0 auto 1.25rem; display:grid; place-items:center; border:1px solid var(--champagne-gold); border-radius:50%; background:var(--cream); color:var(--caramel); font-size:36px; }
    .empty-state .empty-eyebrow { font-size:.66rem; font-weight:700; letter-spacing:.22em; text-transform:uppercase; color:var(--champagne-gold); }
    .empty-state h3 { margin:.6rem 0 .5rem; font-size:clamp(1.3rem,3vw,1.8rem); font-weight:800; letter-spacing:-.02em; color:var(--text-dark); }
    .empty-state p { max-width:46ch; margin:0 auto; font-size:.86rem; line-height:1.65; }

    /* ═══ PAGINATION (Laravel default views) ═══ */
    .br-pagination { margin-top:2.25rem; display:flex; justify-content:center; }
    .br-pagination nav { width:100%; }
    .br-pagination nav > div:first-child { display:none; }
    .br-pagination nav > div:last-child { display:flex; flex-direction:column; align-items:center; gap:1rem; }
    .br-pagination p { margin:0; font-size:.75rem; color:var(--text-muted); }
    .br-pagination svg { width:1rem; height:1rem; }
    .br-pagination span.relative.z-0, .pagination { display:inline-flex; flex-wrap:wrap; justify-content:center; gap:.3rem; margin:0; padding:0; list-style:none; box-shadow:none; }
    .br-pagination a, .br-pagination .page-link, .br-pagination span[aria-disabled="true"] > span, .br-pagination span[aria-current="page"] > span {
        display:inline-flex; align-items:center; justify-content:center; min-width:40px; height:40px; margin:0 !important; padding:0 .8rem; border:1px solid var(--soft-beige); border-radius:3px !important;
        background:var(--warm-ivory); color:var(--text-mid); font-size:.78rem; font-weight:700; text-decoration:none; transition:background .3s var(--ease), color .3s var(--ease), border-color .3s var(--ease); }
    .br-pagination a:hover, .br-pagination .page-link:hover { background:var(--cream); border-color:var(--champagne-gold); color:var(--text-dark); }
    .br-pagination span[aria-current="page"] > span, .br-pagination .page-item.active .page-link { background:var(--espresso); border-color:var(--espresso); color:var(--warm-ivory); box-shadow:inset 0 -2px 0 var(--champagne-gold); }
    .br-pagination span[aria-disabled="true"] > span, .br-pagination .page-item.disabled .page-link { opacity:.45; background:transparent; }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width:760px) {
        .filters { padding:1rem; }
        .filter-divider { display:none; }
        .search-bar { width:100%; margin:.4rem 0 0; }
        .filters-label { width:100%; }
    }
    @media (max-width:520px) {
        .requests-grid { grid-template-columns:1fr; }
        .filter-btn { flex:1; justify-content:center; padding:.75rem .4rem; font-size:.6rem; letter-spacing:.08em; }
        .req-card-body { padding:1.15rem 1.15rem; }
        .req-card-footer { padding:1rem 1.15rem 1.2rem; }
        .req-card-actions { width:100%; }
        .req-card-actions .btn { flex:1; justify-content:center; }
        .profile-banner .btn { width:100%; justify-content:center; }
    }
</style>
@endpush

@section('content')
@php $profileIncomplete = !empty(\App\Http\Middleware\BakerProfileComplete::getMissingFields(auth()->user())); @endphp

<div class="br-page">

@if($profileIncomplete)
<div class="profile-banner br-anim-banner" role="alert">
    <div class="profile-banner-main">
        <span class="profile-banner-icon" aria-hidden="true">
            <svg class="ico" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M12 12v3.2"/><path d="M12 18h.01"/></svg>
        </span>
        <div>
            <div class="profile-banner-eyebrow">Profile completion required</div>
            <div class="profile-banner-title">Your profile is incomplete — bidding is disabled</div>
            <div class="profile-banner-text">
                Missing:
                @foreach(\App\Http\Middleware\BakerProfileComplete::getMissingFields(auth()->user()) as $f)
                    <span class="profile-banner-field">{{ $f }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('baker.profile.index') }}" class="btn btn-gold">Complete Profile <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg></a>
</div>
@endif

<div class="page-header br-anim-header">
    <div>
        <h1 class="page-title">Browse Cake Orders</h1>
        <p class="page-subtitle">{{ $requests->total() }} open request{{ $requests->total() !== 1 ? 's' : '' }} awaiting bakers</p>
    </div>
</div>

<div class="filters br-anim-filters">
    <span class="filters-label">Sort:</span>
    <a href="{{ route('baker.requests.index', array_merge(request()->query(), ['sort'=>'newest'])) }}" class="filter-btn {{ request('sort','newest')==='newest' ? 'active':'' }}">Newest</a>
    <a href="{{ route('baker.requests.index', array_merge(request()->query(), ['sort'=>'deadline'])) }}" class="filter-btn {{ request('sort')==='deadline' ? 'active':'' }}">Urgent First</a>
    <a href="{{ route('baker.requests.index', array_merge(request()->query(), ['sort'=>'budget_high'])) }}" class="filter-btn {{ request('sort')==='budget_high' ? 'active':'' }}">High Budget</a>
    <span class="filter-divider"></span>
    <form method="GET" class="search-bar">
        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by flavor, shape…" aria-label="Search requests">
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
        $rawPreview = $req->cake_preview ?? $req->preview_image ?? $req->cake_image ?? ($config['cake_preview'] ?? null);
        $previewUrl = null;
        if ($rawPreview) {
            $previewUrl = Str::startsWith($rawPreview, ['data:image', 'http://', 'https://', '/'])
                ? $rawPreview
                : asset('storage/' . ltrim($rawPreview, '/'));
        }
        $cakeTitle = $config['cake_label'] ?? trim(($config['flavor'] ?? 'Custom') . ' ' . ($config['shape'] ?? 'Cake'));
        $addonList = array_values((array) ($config['addons'] ?? []));
        $cardDelay = min($loop->index * 0.06, 0.6);
    @endphp
    <div class="req-card br-anim-card" style="animation-delay: {{ $cardDelay }}s;">
        <div class="req-media">
            @if($previewUrl)
                <img src="{{ $previewUrl }}" alt="Cake preview for request #{{ $req->id }}" loading="lazy">
            @else
                <div class="req-media-empty">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3c.9 1 .9 2 0 3-.9-1-.9-2 0-3z"/><path d="M12 6v3"/><path d="M6 12a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2H6z"/><path d="M4 14h16v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/></svg>
                    <small>No preview</small>
                </div>
            @endif
            <span class="req-chip req-chip-id">#{{ str_pad($req->id,4,'0',STR_PAD_LEFT) }}</span>
            <span class="req-chip req-chip-days {{ $daysLeft <= 3 ? 'is-urgent' : '' }}">
                {{ $daysLeft <= 0 ? 'Due today' : $daysLeft . 'd left' }}
            </span>
            <span class="req-chip req-chip-time">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                {{ $req->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="req-card-body">
            <div class="req-cake-name">{{ $cakeTitle }}</div>
            <div class="req-tags">
                @if(!empty($config['size'])) <span class="req-tag">{{ $config['size'] }}</span> @endif
                @if(!empty($config['frosting'])) <span class="req-tag">{{ $config['frosting'] }}</span> @endif
                @if(!empty($config['layers'])) <span class="req-tag">{{ $config['layers'] }} layers</span> @endif
                @foreach(array_slice($addonList, 0, 3) as $addon) <span class="req-tag">{{ $addon }}</span> @endforeach
                @if(count($addonList) > 3) <span class="req-tag req-tag-more">+{{ count($addonList) - 3 }} more</span> @endif
            </div>
            <div class="req-budget">
                <span class="req-detail-label">Budget</span>
                <span class="req-budget-val">₱{{ number_format($req->budget_min,0) }} – ₱{{ number_format($req->budget_max,0) }}</span>
            </div>
            <div class="req-detail-row">
                <span class="req-detail-label">Cake Needed by</span>
                <span class="req-detail-val {{ $daysLeft <= 3 ? 'urgency-high' : 'urgency-normal' }}">
                    {{ $req->delivery_date->format('M d, Y') }}
                    <small>({{ $daysLeft }}d)</small>
                </span>
            </div>
            @if($req->delivery_address)
            <div class="req-detail-row">
                <span class="req-detail-label">Delivery Area</span>
                <span class="req-detail-val is-address">{{ $req->delivery_address }}</span>
            </div>
            @endif
            @if($req->special_instructions)
            <div class="req-note">
                {{ Str::limit($req->special_instructions, 80) }}
            </div>
            @endif
        </div>
        <div class="req-card-footer">
            <div>
                @if($myBid)
                    <div class="bid-already">
                        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>
                        You bid ₱{{ number_format($myBid->amount,0) }}
                    </div>
                @else
                    <div class="bid-count-pill">
                        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.6 13.4 13.4 20.6a2 2 0 0 1-2.8 0L3 13V3h10l7.6 7.6a2 2 0 0 1 0 2.8z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg>
                        {{ $bidCount }} bid{{ $bidCount !== 1 ? 's' : '' }}
                    </div>
                @endif
            </div>
            <div class="req-card-actions">
                <a href="{{ route('baker.requests.show', $req->id) }}" class="btn btn-outline">View</a>
                @if(!$myBid)
                    @if($profileIncomplete)
                        <a href="{{ route('baker.profile.index') }}" class="btn btn-gold" title="Complete your profile first">Complete Profile</a>
                    @else
                        <a href="{{ route('baker.requests.show', $req->id) }}#bid-form" class="btn btn-primary">Place Bid <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg></a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($requests->hasPages())
<div class="br-pagination br-anim-pagination">{{ $requests->links() }}</div>
@endif

@else
<div class="empty-state br-anim-empty">
    <div class="empty-icon" aria-hidden="true">
        <svg class="ico" viewBox="0 0 24 24" style="stroke-width:1.3;"><path d="M12 3c.9 1 .9 2 0 3-.9-1-.9-2 0-3z"/><path d="M12 6v3"/><path d="M6 12a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2H6z"/><path d="M4 14h16v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/></svg>
    </div>
    <div class="empty-eyebrow">The request book is quiet</div>
    <h3>No open requests right now</h3>
    <p>Check back soon — customers are submitting new cake orders regularly!</p>
</div>
@endif

</div>
@endsection