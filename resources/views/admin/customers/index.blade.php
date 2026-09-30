@extends('layouts.admin')
@section('title', 'Customers')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ==========================================================
   BakeSphere Admin · Customer Registry
   Prefix: cr-  (scoped so nothing leaks into layouts.admin)
   ========================================================== */
.cr{
    --espresso:#24150F;--chocolate:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;
    --caramel:#A96F42;--gold:#B89452;--burgundy:#54252C;--taupe:#9A897A;--beige:#D8C8B7;
    --ink:#24150F;--ink-2:#5B463A;--ink-3:#8A7868;
    --line:#E3D8C8;--line-strong:#D8C8B7;
    --ok:#3F6B4E;--ok-bg:#E7EEE6;--ok-line:#C5D6C6;
    --off:#7C6E62;--off-bg:#EDE5D8;
    --radius:4px;
    font-family:'Plus Jakarta Sans',sans-serif;
    color:var(--ink);
    padding-bottom:4rem;
}
.cr *,.cr *::before,.cr *::after{box-sizing:border-box;font-family:inherit;}

@keyframes cr-rise{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
@keyframes cr-fade{from{opacity:0}to{opacity:1}}

/* ---------- Registry header ---------- */
.cr-head{
    background:var(--espresso);
    color:var(--ivory);
    padding:1.75rem 2.25rem 0;
    border-bottom:3px solid var(--gold);
    animation:cr-rise .5s ease both;
}
.cr-crumbs{
    display:flex;align-items:center;gap:.5rem;
    font-size:.6875rem;font-weight:500;letter-spacing:.06em;color:rgba(247,242,233,.5);
    margin-bottom:1.5rem;
}
.cr-crumbs svg{opacity:.5;}
.cr-crumbs strong{color:var(--gold);font-weight:600;}
.cr-head-main{
    display:flex;align-items:flex-end;justify-content:space-between;gap:2rem;flex-wrap:wrap;
    padding-bottom:1.75rem;
}
.cr-title{margin:0 0 .5rem;font-size:2.25rem;font-weight:800;letter-spacing:-.035em;line-height:1.05;color:var(--ivory);}
.cr-lede{margin:0;max-width:34ch;font-size:.9375rem;font-weight:400;line-height:1.55;color:rgba(247,242,233,.62);}

.cr-stats{display:flex;margin:0;padding:0;list-style:none;}
.cr-stat{
    padding:0 2rem;min-width:9.5rem;
    border-left:1px solid rgba(216,200,183,.2);
}
.cr-stat:first-child{padding-left:0;border-left:none;}
.cr-stat:last-child{padding-right:0;}
.cr-stat-label{display:block;font-size:.6875rem;font-weight:600;letter-spacing:.08em;color:rgba(247,242,233,.5);margin-bottom:.375rem;text-transform:uppercase;}
.cr-stat-value{display:block;font-size:2.5rem;font-weight:700;letter-spacing:-.04em;line-height:1;color:var(--ivory);font-variant-numeric:tabular-nums;}
.cr-stat--verified .cr-stat-value{color:var(--gold);}

/* ---------- Controls ---------- */
.cr-controls{
    display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;
   margin-top:1.75rem;border:1px solid var(--line-strong);border-radius:var(--radius);padding:1.125rem 1.5rem;
    background:var(--cream);
    border-bottom:1px solid var(--line-strong);
    animation:cr-fade .6s .1s ease both;
}
.cr-controls-label{font-size:.75rem;font-weight:700;color:var(--ink-2);letter-spacing:.01em;white-space:nowrap;}
.cr-form{display:flex;align-items:center;gap:.5rem;flex:1;flex-wrap:wrap;margin:0;}
.cr-search{position:relative;flex:1 1 260px;max-width:360px;}
.cr-search svg{position:absolute;left:.8125rem;top:50%;transform:translateY(-50%);color:var(--ink-3);pointer-events:none;}
.cr-input,.cr-select{
    height:40px;border:1px solid var(--line-strong);border-radius:var(--radius);
    background:#fff;color:var(--ink);font-size:.8125rem;font-weight:500;outline:none;
    transition:border-color .15s,box-shadow .15s;
}
.cr-input{width:100%;padding:0 .875rem 0 2.5rem;}
.cr-input::placeholder{color:var(--ink-3);font-weight:400;}
.cr-select{
    padding:0 2.25rem 0 .875rem;appearance:none;-webkit-appearance:none;cursor:pointer;
    background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23A96F42' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right .875rem center;
}
.cr-input:focus,.cr-select:focus{border-color:var(--caramel);box-shadow:0 0 0 3px rgba(184,148,82,.22);}
.cr-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:.4rem;
    height:40px;padding:0 1.125rem;border-radius:var(--radius);
    font-size:.8125rem;font-weight:600;text-decoration:none;cursor:pointer;
    transition:background .15s,border-color .15s,color .15s;
}
.cr-btn--primary{background:var(--espresso);border:1px solid var(--espresso);color:var(--ivory);}
.cr-btn--primary:hover{background:var(--chocolate);border-color:var(--chocolate);}
.cr-btn--ghost{background:transparent;border:1px solid var(--line-strong);color:var(--ink-2);}
.cr-btn--ghost:hover{background:#fff;border-color:var(--taupe);color:var(--ink);}

/* ---------- Registry table ---------- */
.cr-registry{
    margin:1.5rem 0 0;
    background:#fff;border:1px solid var(--line-strong);border-radius:var(--radius);
    overflow:hidden;
    animation:cr-rise .5s .15s ease both;
}
.cr-registry-bar{
    display:flex;align-items:center;justify-content:space-between;gap:1rem;
    padding:.875rem 1.5rem;border-bottom:1px solid var(--line-strong);background:var(--ivory);
}
.cr-registry-title{margin:0;font-size:.875rem;font-weight:700;color:var(--ink);letter-spacing:-.005em;}
.cr-registry-count{font-size:.75rem;font-weight:500;color:var(--ink-3);font-variant-numeric:tabular-nums;}
.cr-scroll{overflow-x:auto;overflow-y:hidden;-webkit-overflow-scrolling:touch;}

.cr-table{width:100%;min-width:780px;border-collapse:collapse;}
.cr-table th{
    padding:.75rem 1.5rem;text-align:left;white-space:nowrap;
    font-size:.6875rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-3);
    background:var(--ivory);border-bottom:1px solid var(--line-strong);
}
.cr-table td{padding:1rem 1.5rem;vertical-align:middle;border-bottom:1px solid var(--line);font-size:.8125rem;}
.cr-table tbody tr:last-child td{border-bottom:none;}
.cr-table tbody tr{transition:background .12s;}
.cr-table tbody tr:hover{background:var(--ivory);}
.cr-table .is-center{text-align:center;}
.cr-table .is-right{text-align:right;}

.cr-person{display:flex;align-items:center;gap:.875rem;min-width:0;}
.cr-avatar{
    width:38px;height:38px;flex-shrink:0;border-radius:var(--radius);
    display:flex;align-items:center;justify-content:center;
    font-size:.75rem;font-weight:700;letter-spacing:.04em;color:var(--ivory);
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.08);
}
.cr-name{font-size:.9375rem;font-weight:700;letter-spacing:-.01em;color:var(--ink);line-height:1.25;}
.cr-email{margin-top:.125rem;font-size:.75rem;font-weight:400;color:var(--ink-3);word-break:break-all;}
.cr-meta{font-size:.8125rem;font-weight:500;color:var(--ink-2);font-variant-numeric:tabular-nums;white-space:nowrap;}

.cr-req{display:inline-flex;flex-direction:column;align-items:center;line-height:1;}
.cr-req-num{font-size:1.125rem;font-weight:700;letter-spacing:-.02em;color:var(--ink);font-variant-numeric:tabular-nums;}
.cr-req-num.is-zero{color:var(--beige);}
.cr-req-label{margin-top:.25rem;font-size:.625rem;font-weight:500;letter-spacing:.04em;color:var(--ink-3);}

.cr-badge{
    display:inline-flex;align-items:center;gap:.4rem;
    padding:.25rem .625rem;border-radius:var(--radius);
    font-size:.6875rem;font-weight:700;letter-spacing:.02em;border:1px solid transparent;
    transition:background .15s,color .15s;
}
.cr-badge::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;flex-shrink:0;}
.cr-badge--active{background:var(--ok-bg);border-color:var(--ok-line);color:var(--ok);}
.cr-badge--inactive{background:var(--off-bg);border-color:var(--line-strong);color:var(--off);}
.cr-badge--inactive::before{background:transparent;box-shadow:inset 0 0 0 1.5px currentColor;}

.cr-actions{display:flex;align-items:center;justify-content:flex-end;gap:.375rem;}
.cr-actions form{margin:0;}
.cr-icon-btn{
    display:inline-flex;align-items:center;justify-content:center;
    width:32px;height:32px;padding:0;border-radius:var(--radius);
    border:1px solid var(--line-strong);background:#fff;color:var(--ink-2);
    text-decoration:none;cursor:pointer;transition:background .15s,border-color .15s,color .15s;
}
.cr-icon-btn--view:hover{background:var(--espresso);border-color:var(--espresso);color:var(--ivory);}
.cr-icon-btn--delete{color:var(--taupe);}
.cr-icon-btn--delete:hover{background:rgba(84,37,44,.08);border-color:var(--burgundy);color:var(--burgundy);}

/* ---------- Empty state ---------- */
.cr-empty{padding:4rem 2rem;text-align:center;}
.cr-empty-icon{
    width:48px;height:48px;margin:0 auto 1.25rem;border-radius:var(--radius);
    border:1px solid var(--line-strong);background:var(--ivory);color:var(--caramel);
    display:flex;align-items:center;justify-content:center;
}
.cr-empty-title{margin:0 0 .375rem;font-size:1.0625rem;font-weight:700;letter-spacing:-.015em;color:var(--ink);}
.cr-empty-text{margin:0;font-size:.8125rem;color:var(--ink-3);}

/* ---------- Pagination ---------- */
.cr-pager{
    display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap;
    padding:.875rem 1.5rem;border-top:1px solid var(--line-strong);background:var(--ivory);
}
.cr-pager-info{font-size:.75rem;font-weight:500;color:var(--ink-3);font-variant-numeric:tabular-nums;}
.cr-pager-info b{color:var(--ink);font-weight:700;}
.cr-pager-links{display:flex;gap:.25rem;flex-wrap:wrap;}
.cr-page{
    display:inline-flex;align-items:center;justify-content:center;
    min-width:32px;height:32px;padding:0 .5rem;border-radius:var(--radius);
    border:1px solid var(--line-strong);background:#fff;color:var(--ink-2);
    font-size:.75rem;font-weight:600;text-decoration:none;font-variant-numeric:tabular-nums;
    transition:background .15s,border-color .15s,color .15s;
}
a.cr-page:hover{border-color:var(--caramel);color:var(--caramel);}
.cr-page.is-current{background:var(--espresso);border-color:var(--espresso);color:var(--ivory);}
.cr-page.is-disabled{opacity:.4;pointer-events:none;}

/* ---------- Focus & motion ---------- */
.cr a:focus-visible,.cr button:focus-visible{outline:2px solid var(--gold);outline-offset:2px;}
@media (prefers-reduced-motion:reduce){
    .cr *,.cr *::before,.cr *::after{animation:none!important;transition:none!important;}
}

/* ---------- Responsive ---------- */
@media (max-width:1024px){
    .cr-controls{padding-left:1.25rem;padding-right:1.25rem;}
    .cr-registry{margin:1.5rem 0 0;}
}
@media (max-width:768px){
    .cr-head{padding:1.25rem 1rem 0;}
    .cr-head-main{flex-direction:column;align-items:stretch;gap:1.5rem;}
    .cr-title{font-size:1.75rem;}
    .cr-stats{border-top:1px solid rgba(216,200,183,.2);padding-top:1.25rem;}
    .cr-stat{flex:1;min-width:0;padding:0 1.25rem;}
    .cr-stat-value{font-size:2rem;}
    .cr-controls{padding:1rem;gap:.75rem;flex-direction:column;align-items:stretch;}
    .cr-form{flex-direction:column;align-items:stretch;}
    .cr-search{max-width:none;flex:none;}
    .cr-registry{margin:1rem 0 0;}
    .cr-registry-bar,.cr-pager{padding-left:1rem;padding-right:1rem;}
    .cr-table th,.cr-table td{padding:.875rem 1rem;}
    .cr-pager{justify-content:center;}
}
</style>
@endpush

@section('content')

@php
$totalCount=method_exists($customers,'total')?$customers->total():$customers->count();
$verifiedCount=$customers->filter(fn($c)=>!is_null($c->email_verified_at))->count();
@endphp
<div class="cr ah-page">

<div class="ah-top">
<header class="ah-hero">
    <div class="ah-hero-main">
        <span class="ah-hero-mark"><svg class="ah-ic" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
        <div>
            <div class="ah-eyebrow">BakeSphere &middot; People</div>
            <h1 class="ah-title">Customer Registry</h1>
            <p class="ah-subtitle">Manage the people powering the BakeSphere marketplace.</p>
        </div>
    </div>
    <div class="ah-side">
        <span class="ah-side-label"><span class="ah-dot"></span>Live registry</span>
        <span class="ah-side-value">Updated {{ now()->format('M d, H:i') }}</span>
    </div>
</header>
<section class="ah-ledger" style="--cols:2" aria-label="Customer summary">
    <div class="ah-fig"><div class="ah-fig-lbl">Total</div><div class="ah-fig-val">{{ $totalCount }}</div><div class="ah-fig-note">Registered customers</div></div>
    <div class="ah-fig ah-fig--sage"><div class="ah-fig-lbl">Verified</div><div class="ah-fig-val">{{ $verifiedCount }}</div><div class="ah-fig-note">Email verified</div></div>
</section>
</div>

    {{-- Directory controls --}}
    <section class="cr-controls" aria-label="Customer directory controls">
        <span class="cr-controls-label">Directory controls</span>
        <form class="cr-form" method="GET" action="{{ route('customers.index') }}">
            <div class="cr-search">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input class="cr-input" type="text" name="search" placeholder="Search by name or email…" value="{{ request('search') }}" aria-label="Search by name or email">
            </div>
            <select class="cr-select" name="status" onchange="this.form.submit()" aria-label="Filter by status">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
            </select>
            <button type="submit" class="cr-btn cr-btn--primary">Search</button>
            @if(request('search')||request('status'))
            <a href="{{ route('customers.index') }}" class="cr-btn cr-btn--ghost">Clear</a>
            @endif
        </form>
    </section>

    {{-- Registry --}}
    <section class="cr-registry">
        <div class="cr-registry-bar">
            <h2 class="cr-registry-title">All Customers</h2>
            <span class="cr-registry-count">{{ $totalCount }} records</span>
        </div>

        @if($customers->isEmpty())
        <div class="cr-empty">
            <div class="cr-empty-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h3 class="cr-empty-title">No customers found</h3>
            <p class="cr-empty-text">{{ request('search')?'Try a different search term.':'No customers have registered yet.' }}</p>
        </div>
        @else
        <div class="cr-scroll">
            <table class="cr-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Joined</th>
                        <th class="is-center">Requests</th>
                        <th class="is-center">Status</th>
                        <th class="is-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $grads=[
                        'linear-gradient(135deg,#24150F,#3A241A)',
                        'linear-gradient(135deg,#3A241A,#5B3A29)',
                        'linear-gradient(135deg,#8A5A35,#A96F42)',
                        'linear-gradient(135deg,#54252C,#72363F)',
                        'linear-gradient(135deg,#7C6E62,#9A897A)',
                    ];
                    @endphp
                    @foreach($customers as $customer)
                    @php
                        $bg=$grads[$loop->index%5];
                        $firstName=$customer->first_name??'';$lastName=$customer->last_name??'';
                        $fullName=trim($firstName.' '.$lastName)?:($customer->name??'Unknown');
                        $initials=strtoupper(substr($firstName,0,1).substr($lastName,0,1))?:'?';
                        $status=$customer->email_verified_at?'active':'inactive';
                        $reqCount=$customer->cakeRequests?$customer->cakeRequests->count():0;
                    @endphp
                    <tr>
                        <td>
                            <div class="cr-person">
                                <div class="cr-avatar" style="background:{{ $bg }}" aria-hidden="true">{{ $initials }}</div>
                                <div>
                                    <div class="cr-name">{{ $fullName }}</div>
                                    <div class="cr-email">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="cr-meta">{{ $customer->phone ?? '—' }}</span></td>
                        <td><span class="cr-meta">{{ $customer->created_at->format('M d, Y') }}</span></td>
                        <td class="is-center">
                            <span class="cr-req">
                                <span class="cr-req-num {{ $reqCount==0?'is-zero':'' }}">{{ sprintf('%02d',$reqCount) }}</span>
                                <span class="cr-req-label">{{ $reqCount==1?'request':'requests' }}</span>
                            </span>
                        </td>
                        <td class="is-center"><span class="cr-badge cr-badge--{{ $status }}">{{ ucfirst($status) }}</span></td>
                        <td>
                            <div class="cr-actions">
                                @if(Route::has('customers.show'))
                                <a href="{{ route('customers.show',$customer->id) }}" class="cr-icon-btn cr-icon-btn--view" title="View record" aria-label="View record for {{ $fullName }}">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @endif
                                @if(Route::has('customers.destroy'))
                                <form method="POST" action="{{ route('customers.destroy',$customer->id) }}" onsubmit="return confirm('Delete this customer?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="cr-icon-btn cr-icon-btn--delete" title="Delete customer" aria-label="Delete {{ $fullName }}">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($customers,'hasPages')&&$customers->hasPages())
        <nav class="cr-pager" aria-label="Pagination">
            <span class="cr-pager-info">Showing <b>{{ $customers->firstItem() }}–{{ $customers->lastItem() }}</b> of <b>{{ $customers->total() }}</b></span>
            <div class="cr-pager-links">
                @if($customers->onFirstPage())
                <span class="cr-page is-disabled" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                <a class="cr-page" href="{{ $customers->previousPageUrl() }}" aria-label="Previous page"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @foreach($customers->getUrlRange(1,$customers->lastPage()) as $page=>$url)
                    @if($page==$customers->currentPage())
                    <span class="cr-page is-current" aria-current="page">{{ $page }}</span>
                    @else
                    <a class="cr-page" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($customers->hasMorePages())
                <a class="cr-page" href="{{ $customers->nextPageUrl() }}" aria-label="Next page"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                <span class="cr-page is-disabled" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </nav>
        @endif
        @endif
    </section>
</div>

@endsection