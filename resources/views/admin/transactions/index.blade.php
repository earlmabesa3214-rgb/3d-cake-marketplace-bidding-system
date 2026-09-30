@extends('layouts.admin')
@section('title', 'Transactions')

@push('styles')
<style>
/* =====================================================================
   BAKESPHERE · TRANSACTION LEDGER
   Sections: 1 Tokens · 2 Base · 3 Hero · 4 Stats · 5 Filters
             6 Ledger table · 7 Cells · 8 Status & payment · 9 Motion
   ===================================================================== */

/* 1 · TOKENS */
:root {
    --bs-espresso:#24150F;
    --bs-choc:#3A241A;
    --bs-ivory:#F7F2E9;
    --bs-cream:#EFE6D7;
    --bs-caramel:#A96F42;
    --bs-gold:#B89452;
    --bs-gold-ink:#8A6A2C;
    --bs-gold-light:#D9BE84;
    --bs-burgundy:#54252C;
    --bs-taupe:#9A897A;
    --bs-muted:#75665A;
    --bs-beige:#D8C8B7;
    --bs-blush:#E8D3CA;
    --bs-white:#FFFFFF;
    --bs-sage:#4E6B5A;
    --bs-slate:#4F6474;
    --bs-radius:3px;
    --bs-shadow:0 1px 2px rgba(36,21,15,.06), 0 8px 24px -12px rgba(36,21,15,.18);
}

/* 2 · BASE */
.bs-page, .bs-page * { font-family:'Plus Jakarta Sans', sans-serif; box-sizing:border-box; }
.bs-page { background:var(--bs-ivory); color:var(--bs-espresso); min-height:100%; }
.bs-ic { width:1em; height:1em; fill:none; stroke:currentColor; stroke-width:1.7; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }
.bs-eyebrow { font-size:.66rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; }
.bs-body { padding:3.25rem 0 4.5rem; }

/* 3 · HERO */
.bs-hero { position:relative; overflow:hidden; padding:3rem 2.5rem 2.75rem; color:var(--bs-ivory);
    background:linear-gradient(160deg, var(--bs-espresso) 0%, var(--bs-choc) 100%);
    border-bottom:1px solid var(--bs-gold); }
.bs-hero::before { content:''; position:absolute; inset:0; pointer-events:none;
    background-image:repeating-linear-gradient(90deg, rgba(184,148,82,.06) 0 1px, transparent 1px 96px); }
.bs-hero::after { content:''; position:absolute; top:0; left:2.5rem; width:72px; height:3px; background:var(--bs-gold); }
.bs-hero-inner { position:relative; z-index:1; display:flex; justify-content:space-between; align-items:flex-end; gap:2rem; flex-wrap:wrap; }
.bs-hero .bs-eyebrow { color:var(--bs-gold-light); margin-bottom:1rem; }
.bs-hero-title { font-size:clamp(2.2rem, 5vw, 3.75rem); font-weight:800; letter-spacing:-.045em; line-height:1.02; margin:0 0 1rem; color:var(--bs-ivory); }
.bs-hero-sub { font-size:.92rem; line-height:1.65; color:rgba(247,242,233,.62); max-width:34rem; margin:0; }
.bs-live { display:inline-flex; align-items:center; gap:.6rem; padding:.55rem .95rem; border:1px solid rgba(184,148,82,.45);
    font-size:.64rem; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:var(--bs-gold-light); border-radius:var(--bs-radius); }
.bs-live-dot { width:6px; height:6px; border-radius:50%; background:var(--bs-gold); animation:bsPulse 2.4s ease-in-out infinite; }

/* 4 · STATS BAND */
.bs-stats { display:grid; grid-template-columns:repeat(4, 1fr) 1.7fr; background:var(--bs-white);
    border:1px solid var(--bs-beige); margin-bottom:2rem; box-shadow:var(--bs-shadow); }
.bs-stat { padding:1.5rem 1.6rem 1.6rem; border-right:1px solid var(--bs-beige); min-width:0; }
.bs-stat-label { display:flex; align-items:center; gap:.5rem; font-size:.64rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--bs-muted); }
.bs-stat-label::before { content:''; width:6px; height:6px; background:var(--bs-taupe); flex-shrink:0; }
.bs-stat.is-active .bs-stat-label::before { background:var(--bs-slate); }
.bs-stat.is-done .bs-stat-label::before { background:var(--bs-sage); }
.bs-stat.is-cancelled .bs-stat-label::before { background:var(--bs-burgundy); }
.bs-stat-num { margin-top:.85rem; font-size:2.5rem; font-weight:800; letter-spacing:-.04em; line-height:1; font-variant-numeric:tabular-nums; }
.bs-stat.is-cancelled .bs-stat-num { color:var(--bs-burgundy); }
.bs-stat.is-revenue { background:var(--bs-choc); border-right:none; border-left:3px solid var(--bs-gold); }
.bs-stat.is-revenue .bs-stat-label { color:var(--bs-gold-light); }
.bs-stat.is-revenue .bs-stat-label::before { background:var(--bs-gold); }
.bs-stat.is-revenue .bs-stat-num { color:var(--bs-ivory); font-size:2.9rem; }
.bs-stat.is-revenue .bs-stat-num .bs-cur { color:var(--bs-gold-light); font-size:1.5rem; margin-right:.2rem; font-weight:700; }

/* 5 · FILTER BAR */
.bs-filter { background:var(--bs-cream); border:1px solid var(--bs-beige); border-top:2px solid var(--bs-espresso); padding:1.1rem 1.4rem 1.35rem; margin-bottom:2rem; }
.bs-filter-head { display:flex; align-items:baseline; justify-content:space-between; gap:1rem; margin-bottom:.9rem; }
.bs-filter-title { color:var(--bs-espresso); }
.bs-filter-count { font-size:.76rem; font-weight:600; color:var(--bs-muted); }
.bs-filter-row { display:flex; flex-wrap:wrap; gap:.75rem; align-items:center; }
.bs-search { position:relative; flex:1 1 260px; }
.bs-search .bs-ic { position:absolute; left:.95rem; top:50%; transform:translateY(-50%); color:var(--bs-muted); font-size:1rem; pointer-events:none; }
.bs-input, .bs-select { height:44px; width:100%; padding:0 1rem; background:var(--bs-ivory); color:var(--bs-espresso);
    border:1px solid var(--bs-taupe); border-radius:var(--bs-radius); font-size:.84rem; font-weight:500; transition:border-color .2s, box-shadow .2s, background .2s; }
.bs-input { padding-left:2.6rem; }
.bs-select { width:auto; min-width:200px; cursor:pointer; }
.bs-input::placeholder { color:var(--bs-muted); }
.bs-input:hover, .bs-select:hover { border-color:var(--bs-caramel); background:var(--bs-white); }
.bs-input:focus, .bs-select:focus { outline:none; border-color:var(--bs-gold); background:var(--bs-white); box-shadow:0 0 0 3px rgba(184,148,82,.25); }
.bs-apply { height:44px; padding:0 1.6rem; border:1px solid var(--bs-espresso); background:var(--bs-espresso); color:var(--bs-ivory);
    font-size:.72rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; border-radius:var(--bs-radius); cursor:pointer; transition:background .2s, border-color .2s, color .2s; }
.bs-apply:hover { background:var(--bs-gold); border-color:var(--bs-gold); color:var(--bs-espresso); }
.bs-apply:focus-visible, .bs-view:focus-visible, .bs-clear:focus-visible { outline:2px solid var(--bs-gold); outline-offset:2px; }
.bs-clear { display:inline-flex; align-items:center; gap:.4rem; font-size:.74rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--bs-muted); text-decoration:none; padding:0 .4rem; transition:color .2s; }
.bs-clear:hover { color:var(--bs-burgundy); }

/* 6 · LEDGER TABLE */
.bs-ledger { background:var(--bs-white); border:1px solid var(--bs-beige); box-shadow:var(--bs-shadow); }
.bs-ledger-top { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:1.15rem 1.6rem; border-bottom:1px solid var(--bs-beige); border-left:3px solid var(--bs-gold); }
.bs-ledger-title { font-size:1.05rem; font-weight:800; letter-spacing:-.02em; margin:0; }
.bs-ledger-count { font-size:.66rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--bs-gold-ink); border:1px solid var(--bs-gold); padding:.3rem .7rem; border-radius:var(--bs-radius); }
.bs-scroll { overflow-x:auto;overflow-y:hidden; -webkit-overflow-scrolling:touch; }
.bs-table { width:100%; min-width:1120px; border-collapse:collapse; }
.bs-table thead th { padding:.85rem 1.1rem; text-align:left; font-size:.6rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--bs-muted); background:var(--bs-cream); border-bottom:1px solid var(--bs-beige); white-space:nowrap; }
.bs-table thead th.r, .bs-table td.r { text-align:right; }
.bs-table tbody tr { border-bottom:1px solid var(--bs-cream); transition:background .18s; }
.bs-table tbody tr:last-child { border-bottom:none; }
.bs-table tbody tr:hover { background:var(--bs-ivory); }
.bs-table tbody td { padding:1.2rem 1.1rem; font-size:.82rem; vertical-align:middle; }
.bs-table tbody tr:hover td:first-child { box-shadow:inset 3px 0 0 var(--bs-gold); }
.bs-empty td { text-align:center; padding:4rem 1rem; color:var(--bs-muted); font-size:.88rem; font-weight:500; }

/* 7 · CELLS */
.bs-txno { font-size:.78rem; font-weight:800; letter-spacing:.06em; color:var(--bs-gold-ink); font-variant-numeric:tabular-nums; }
.bs-id { display:flex; align-items:center; gap:.7rem; min-width:0; }
.bs-avatar { width:36px; height:36px; border-radius:50%; background:var(--bs-caramel); color:var(--bs-white); display:flex; align-items:center; justify-content:center; font-size:.78rem; font-weight:800; overflow:hidden; flex-shrink:0; box-shadow:0 0 0 2px var(--bs-white), 0 0 0 3px var(--bs-beige); }
.bs-avatar.is-baker { background:var(--bs-espresso); }
.bs-avatar img { width:100%; height:100%; object-fit:cover; display:block; }
.bs-name { font-weight:700; font-size:.82rem; line-height:1.3; }
.bs-email { font-size:.7rem; color:var(--bs-muted); margin-top:.15rem; overflow-wrap:anywhere; }
.bs-cake-flavor { font-size:.68rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
.bs-cake-meta { font-size:.78rem; color:var(--bs-muted); margin-top:.2rem; }
.bs-price { font-size:1.15rem; font-weight:800; letter-spacing:-.03em; font-variant-numeric:tabular-nums; white-space:nowrap; }
.bs-price .bs-cur { font-size:.8rem; color:var(--bs-gold-ink); margin-right:.1rem; font-weight:700; }
.bs-date { font-size:.78rem; font-weight:600; color:var(--bs-choc); white-space:nowrap; }
.bs-view { display:inline-flex; align-items:center; gap:.45rem; padding:.55rem .85rem; border:1px solid var(--bs-espresso); border-radius:var(--bs-radius);
    font-size:.64rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--bs-espresso); text-decoration:none; white-space:nowrap; transition:background .2s, color .2s, border-color .2s; }
.bs-view .bs-ic { transition:transform .2s; }
.bs-view:hover { background:var(--bs-espresso); color:var(--bs-gold-light); }
.bs-view:hover .bs-ic { transform:translateX(3px); }
.bs-pager { margin-top:1.5rem; }

/* 8 · STATUS & PAYMENT */
.bs-status { display:inline-flex; align-items:center; gap:.45rem; padding:.32rem .7rem; border-radius:var(--bs-radius); border:1px solid; font-size:.62rem; font-weight:700; letter-spacing:.09em; text-transform:uppercase; white-space:nowrap; }
.bs-status::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; }
.bs-s-ACCEPTED, .bs-s-WAITING_FOR_PAYMENT, .bs-s-WAITING_FINAL_PAYMENT { color:#7A5A1E; background:rgba(184,148,82,.14); border-color:rgba(184,148,82,.55); }
.bs-s-PREPARING { color:var(--bs-slate); background:rgba(79,100,116,.1); border-color:rgba(79,100,116,.4); }
.bs-s-READY, .bs-s-DELIVERED, .bs-s-COMPLETED { color:var(--bs-sage); background:rgba(78,107,90,.11); border-color:rgba(78,107,90,.4); }
.bs-s-CANCELLED { color:var(--bs-burgundy); background:rgba(84,37,44,.08); border-color:rgba(84,37,44,.4); }
.bs-pay { display:inline-flex; align-items:center; gap:.4rem; font-size:.74rem; font-weight:700; white-space:nowrap; }
.bs-pay .bs-ic { width:18px; height:18px; padding:3px; border-radius:50%; border:1px solid currentColor; }
.bs-pay.is-paid { color:var(--bs-sage); }
.bs-pay.is-pending { color:#7A5A1E; }
.bs-pay.is-rejected { color:var(--bs-burgundy); }
.bs-pay.is-none { color:var(--bs-taupe); font-weight:500; }

/* 9 · MOTION */
@keyframes bsRise { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
@keyframes bsFade { from { opacity:0; } to { opacity:1; } }
@keyframes bsPulse { 0%,100% { opacity:1; } 50% { opacity:.35; } }
.bs-hero-inner > * { animation:bsRise .6s ease both; }
.bs-hero-inner > *:nth-child(2) { animation-delay:.12s; }
.bs-stats { animation:bsRise .55s .1s ease both; }
.bs-filter { animation:bsRise .55s .18s ease both; }
.bs-ledger { animation:bsRise .55s .26s ease both; }
.bs-table tbody tr { animation:bsFade .45s ease both; animation-delay:calc(.3s + min(var(--i, 0), 12) * 35ms); }

/* RESPONSIVE */
@media (max-width:1000px) {
    .bs-body { padding:2.5rem 0 3.5rem; }
    .bs-hero { padding:2.25rem 1.25rem 2rem; }
    .bs-hero::after { left:1.25rem; }
    .bs-stats { grid-template-columns:repeat(2, 1fr); }
    .bs-stat { border-bottom:1px solid var(--bs-beige); }
    .bs-stat:nth-child(2n) { border-right:none; }
    .bs-stat.is-revenue { grid-column:1 / -1; border-bottom:none; border-left:3px solid var(--bs-gold); }
}
@media (max-width:640px) {
    .bs-filter-row > * { flex:1 1 100%; }
    .bs-select { width:100%; }
    .bs-apply { width:100%; }
    .bs-stat-num { font-size:2rem; }
    .bs-stat.is-revenue .bs-stat-num { font-size:2.3rem; }
    .bs-ledger-top { padding:1rem; }
}
@media (prefers-reduced-motion:reduce) {
    .bs-page *, .bs-page *::before, .bs-page *::after { animation:none !important; transition:none !important; }
}
</style>
@endpush

@section('content')

{{-- Icon sprite --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="bs-i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
    <symbol id="bs-i-check" viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></symbol>
    <symbol id="bs-i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></symbol>
    <symbol id="bs-i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></symbol>
    <symbol id="bs-i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6.5"/><path d="M16 16l4.5 4.5"/></symbol>
</svg>
<div class="bs-page ah-page">

<div class="ah-top">
<header class="ah-hero">
    <div class="ah-hero-main">
        <span class="ah-hero-mark"><svg class="ah-ic" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></span>
        <div>
            <div class="ah-eyebrow">BakeSphere &middot; Finance</div>
            <h1 class="ah-title">Transactions &amp; Orders</h1>
            <p class="ah-subtitle">A complete operational view of customer-baker transactions.</p>
        </div>
    </div>
    <div class="ah-side">
        <span class="ah-side-label"><span class="ah-dot"></span>Live marketplace</span>
        <span class="ah-side-value">Updated {{ now()->format('M d, H:i') }}</span>
    </div>
</header>
<section class="ah-ledger" style="--cols:5" aria-label="Transaction statistics">
    <div class="ah-fig ah-fig--taupe"><div class="ah-fig-lbl">Total</div><div class="ah-fig-val">{{ $stats['total'] }}</div></div>
    <div class="ah-fig ah-fig--caramel"><div class="ah-fig-lbl">Active</div><div class="ah-fig-val">{{ $stats['active'] }}</div></div>
    <div class="ah-fig ah-fig--sage"><div class="ah-fig-lbl">Completed</div><div class="ah-fig-val">{{ $stats['completed'] }}</div></div>
    <div class="ah-fig ah-fig--burgundy"><div class="ah-fig-lbl">Cancelled</div><div class="ah-fig-val">{{ $stats['cancelled'] }}</div></div>
    <div class="ah-fig"><div class="ah-fig-lbl">Total Revenue</div><div class="ah-fig-val">₱{{ number_format($stats['revenue'], 0) }}</div></div>
</section>
</div>

<div class="bs-body">

{{-- FILTERS --}}
<form method="GET" action="{{ route('admin.transactions.index') }}">
    <div class="bs-filter">
        <div class="bs-filter-head">
            <span class="bs-eyebrow bs-filter-title">Transaction Filters</span>
            <span class="bs-filter-count">
                {{ $transactions->total() }} result{{ $transactions->total() !== 1 ? 's' : '' }}
            </span>
        </div>
        <div class="bs-filter-row">
            <div class="bs-search">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-search"/></svg>
                <input type="text" name="search" class="bs-input"
                       aria-label="Search customers or bakers"
                       placeholder="Search customers or bakers"
                       value="{{ request('search') }}">
            </div>
            <select name="status" class="bs-select" aria-label="Filter by status">
                <option value="">All Statuses</option>
                @foreach(['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED','COMPLETED','CANCELLED'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                    {{ str_replace('_', ' ', $s) }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="bs-apply">Apply</button>
            @if(request()->hasAny(['status','search']))
            <a href="{{ route('admin.transactions.index') }}" class="bs-clear">
                <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-x"/></svg> Clear
            </a>
            @endif
        </div>
    </div>
</form>

{{-- LEDGER --}}
<section class="bs-ledger">
    <div class="bs-ledger-top">
        <h2 class="bs-ledger-title">All Transactions</h2>
        <span class="bs-ledger-count">{{ $transactions->total() }} orders</span>
    </div>
    <div class="bs-scroll">
    <table class="bs-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Baker</th>
                <th>Cake</th>
                <th>Status</th>
                <th>Downpayment</th>
                <th>Final Payment</th>
                <th class="r">Agreed Price</th>
                <th>Delivery Date</th>
                <th><span class="sr-only" style="position:absolute;left:-9999px;">View</span></th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
            @php
                $config = is_array($tx->cakeRequest->cake_configuration)
                    ? $tx->cakeRequest->cake_configuration
                    : (json_decode($tx->cakeRequest->cake_configuration, true) ?? []);
                $downpayment  = $tx->cakeRequest->payments->where('payment_type','downpayment')->first();
                $finalPayment = $tx->cakeRequest->payments->where('payment_type','final')->first();
            @endphp
            <tr style="--i:{{ $loop->index }};">
                <td>
                    <span class="bs-txno">#{{ str_pad($tx->id, 4, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td>
                    <div class="bs-id">
                        <div class="bs-avatar">
                            @if($tx->cakeRequest->user->profile_photo)
                                <img src="{{ asset('storage/'.$tx->cakeRequest->user->profile_photo) }}" alt="">
                            @else
                                {{ strtoupper(substr($tx->cakeRequest->user->first_name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="bs-name">{{ $tx->cakeRequest->user->first_name }} {{ $tx->cakeRequest->user->last_name }}</div>
                            <div class="bs-email">{{ $tx->cakeRequest->user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="bs-id">
                        <div class="bs-avatar is-baker">
                            @if($tx->baker->profile_photo)
                                <img src="{{ asset('storage/'.$tx->baker->profile_photo) }}" alt="">
                            @else
                                {{ strtoupper(substr($tx->baker->first_name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="bs-name">{{ $tx->baker->first_name }} {{ $tx->baker->last_name }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="bs-cake-flavor">{{ $config['flavor'] ?? 'Custom' }}</div>
                    <div class="bs-cake-meta">
                        {{ $config['shape'] ?? 'Cake' }}@if(!empty($config['size'])) · {{ $config['size'] }}@endif
                    </div>
                </td>
                <td>
                    <span class="bs-status bs-s-{{ $tx->status }}">
                        {{ str_replace('_', ' ', $tx->status) }}
                    </span>
                </td>
                <td>
                    @if($downpayment)
                        @if($downpayment->status === 'paid' || $downpayment->status === 'confirmed')
                            <span class="bs-pay is-paid"><svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-check"/></svg>Paid</span>
                        @elseif($downpayment->status === 'rejected')
                            <span class="bs-pay is-rejected"><svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-x"/></svg>Rejected</span>
                        @else
                            <span class="bs-pay is-pending"><svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-clock"/></svg>Pending</span>
                        @endif
                    @else
                        <span class="bs-pay is-none">—</span>
                    @endif
                </td>
                <td>
                    @if($finalPayment)
                        @if($finalPayment->status === 'paid' || $finalPayment->status === 'confirmed')
                            <span class="bs-pay is-paid"><svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-check"/></svg>Paid</span>
                        @elseif($finalPayment->status === 'rejected')
                            <span class="bs-pay is-rejected"><svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-x"/></svg>Rejected</span>
                        @else
                            <span class="bs-pay is-pending"><svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-clock"/></svg>Pending</span>
                        @endif
                    @else
                        <span class="bs-pay is-none">—</span>
                    @endif
                </td>
                <td class="r">
                    <span class="bs-price"><span class="bs-cur">₱</span>{{ number_format($tx->agreed_price, 0) }}</span>
                </td>
                <td>
                    <span class="bs-date">{{ $tx->cakeRequest->delivery_date->format('M d, Y') }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.transactions.show', $tx->id) }}" class="bs-view" aria-label="View transaction">
                        View <svg class="bs-ic" viewBox="0 0 24 24" aria-hidden="true"><use href="#bs-i-arrow"/></svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr class="bs-empty"><td colspan="10">No transactions found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</section>

@if($transactions->hasPages())
<div class="bs-pager">{{ $transactions->withQueryString()->links() }}</div>
@endif

</div>
</div>
@endsection