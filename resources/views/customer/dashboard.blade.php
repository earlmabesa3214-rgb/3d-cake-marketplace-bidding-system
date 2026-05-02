@extends('layouts.customer')
@section('title', 'Dashboard')

@push('styles')
<style>
* { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ─── PAGE ENTRY ANIMATIONS ─── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-8px); }
}
@keyframes flickerA {
    0%,100% { opacity:1; transform: scaleY(1); }
    50%      { opacity:0.7; transform: scaleY(0.85); }
}
@keyframes flickerB {
    0%,100% { opacity:1; transform: scaleY(1); }
    33%      { opacity:0.6; transform: scaleY(0.9); }
    66%      { opacity:0.9; transform: scaleY(1.05); }
}
@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
}
@keyframes pulse-ring {
    0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(200,137,74,0.4); }
    70%  { transform: scale(1);    box-shadow: 0 0 0 10px rgba(200,137,74,0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(200,137,74,0); }
}

.dash-animate { animation: fadeUp 0.55s cubic-bezier(.22,.68,0,1.2) both; }
.dash-animate.d1 { animation-delay: 0.05s; }
.dash-animate.d2 { animation-delay: 0.12s; }
.dash-animate.d3 { animation-delay: 0.19s; }
.dash-animate.d4 { animation-delay: 0.26s; }
.dash-animate.d5 { animation-delay: 0.33s; }

/* ─── HERO ─── */
.dashboard-hero {
    background: linear-gradient(135deg, #1C0F07 0%, #3D2416 45%, #5C3D2E 100%);
    border-radius: 24px;
    padding: 0;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.5rem;
    display: grid;
    grid-template-columns: 1fr auto;
    min-height: 200px;
    box-shadow: 0 20px 60px rgba(44,26,14,0.35);
}

/* Subtle dot-grid texture */
.dashboard-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(200,137,74,0.15) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
}

/* Warm glow bottom-left */
.dashboard-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(200,137,74,0.2) 0%, transparent 70%);
    pointer-events: none;
}

.hero-content {
    padding: 2.25rem 2.75rem;
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.65rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--caramel-light);
    font-weight: 700;
    margin-bottom: 0.65rem;
    opacity: 0.85;
}
.hero-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px; height: 1.5px;
    background: var(--caramel-light);
    opacity: 0.6;
}

.hero-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}
.hero-title .wave { display: inline-block; }

.hero-sub {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.6;
    max-width: 420px;
}

.hero-actions {
    display: flex;
    gap: 0.65rem;
    margin-top: 1.75rem;
    flex-wrap: wrap;
}

.hero-cta {
    display: inline-flex; align-items: center; gap: 0.45rem;
    padding: 0.65rem 1.35rem;
    background: linear-gradient(135deg, var(--caramel) 0%, #D4944F 100%);
    color: white; border-radius: 10px; text-decoration: none;
    font-size: 0.82rem; font-weight: 700;
    transition: all 0.2s;
    box-shadow: 0 4px 20px rgba(200,137,74,0.45);
    letter-spacing: 0.01em;
}
.hero-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(200,137,74,0.55);
    color: white;
}

.hero-cta-ghost {
    display: inline-flex; align-items: center; gap: 0.45rem;
    padding: 0.65rem 1.35rem;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.8);
    border: 1.5px solid rgba(255,255,255,0.15);
    border-radius: 10px; text-decoration: none;
    font-size: 0.82rem; font-weight: 600;
    transition: all 0.2s; backdrop-filter: blur(4px);
}
.hero-cta-ghost:hover { background: rgba(255,255,255,0.16); color: white; }

.hero-illustration {
    position: relative;
    width: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    align-self: center;
    padding: 2rem 2rem 1rem 0;
    z-index: 2;
}
.hero-illustration svg { filter: drop-shadow(0 8px 24px rgba(0,0,0,0.35)); }


/* Floating sparkles */
.hero-sparkle {
    position: absolute;
    border-radius: 50%;
    background: var(--caramel-light);
    opacity: 0.5;
}
.hs1 { width:10px; height:10px; top: 15%; left: 8%; animation: pulse-ring 2.5s ease-in-out infinite; }
.hs2 { width: 6px; height: 6px; top: 70%; left: 5%; animation: pulse-ring 3.2s ease-in-out infinite 0.5s; }
.hs3 { width: 8px; height: 8px; top: 25%; right: 10%; animation: pulse-ring 2.8s ease-in-out infinite 1s; }

@media (max-width: 640px) {
    .dashboard-hero { grid-template-columns: 1fr; }
    .hero-illustration { display: none; }
    .hero-content { padding: 1.75rem 1.5rem; }
}

/* ─── STATS GRID ─── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
@media (max-width: 700px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 440px) { .stats-grid { grid-template-columns: 1fr; } }
.stat-card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 1.25rem 1.5rem;
    text-decoration: none;
    color: inherit;
    position: relative;
    overflow: hidden;
    transition: transform 0.22s cubic-bezier(.22,.68,0,1.2), box-shadow 0.22s;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
}
.stat-card .stat-icon-box {
    flex-shrink: 0;
}
.stat-card .stat-meta {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(44,26,14,0.12);
    border-color: rgba(200,137,74,0.3);
}

/* Accent bar left */
.stat-card::before {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 3px;
    border-radius: 0 4px 4px 0;
    margin-top: 0.25rem;
}
.stat-card.c1::before { background: linear-gradient(180deg, var(--caramel), var(--caramel-light)); }
.stat-card.c2::before { background: linear-gradient(180deg, #9A6028, #C8803A); }
.stat-card.c3::before { background: linear-gradient(180deg, var(--brown-deep), var(--brown-mid)); }



.stat-icon-box {
    width: 46px; height: 46px;
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.stat-card.c1 .stat-icon-box { background: linear-gradient(135deg, #FEF3E8, #FDDFC0); }
.stat-card.c2 .stat-icon-box { background: linear-gradient(135deg, #F5EDE0, #EDD8BB); }
.stat-card.c3 .stat-icon-box { background: linear-gradient(135deg, #EDE8E4, #D8CFC8); }

.stat-info { position: relative; z-index: 1; }
.stat-value {
    font-size: 2.1rem;
    font-weight: 800;
    color: var(--brown-deep);
    line-height: 1;
    letter-spacing: -0.03em;
}
.stat-label {
    font-size: 0.68rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--text-muted);
    font-weight: 700;
    margin-top: 0.25rem;
}
.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.5rem;
    font-size: 0.68rem;
    font-weight: 600;
    padding: 0.15rem 0.55rem;
    border-radius: 20px;
}
.stat-badge.warm { background: #FEF3E8; color: var(--caramel); }
.stat-badge.green { background: #EFF5EF; color: #2D6A30; }

/* ─── TWO-COLUMN LAYOUT ─── */
.dashboard-cols {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
    align-items: start;
}
@media (max-width: 920px) { .dashboard-cols { grid-template-columns: 1fr; } }

/* ─── SECTION HEADERS ─── */
.section-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 0.875rem;
}
.section-title {
    font-size: 0.88rem;
    font-weight: 800;
    color: var(--brown-deep);
    letter-spacing: -0.01em;
    display: flex; align-items: center; gap: 0.5rem;
}
.section-title::before {
    content: '';
    display: inline-block;
    width: 3px; height: 14px;
    background: linear-gradient(180deg, var(--caramel), var(--caramel-light));
    border-radius: 2px;
}
.section-link {
    font-size: 0.74rem; color: var(--caramel);
    text-decoration: none; font-weight: 700;
    display: flex; align-items: center; gap: 0.25rem;
    transition: gap 0.2s;
}
.section-link:hover { gap: 0.5rem; }

/* ─── QUICK ACTIONS ─── */
.actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
@media (max-width: 480px) { .actions-grid { grid-template-columns: 1fr; } }

.action-card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.1rem 1.2rem;
    text-decoration: none; color: inherit;
    display: flex; align-items: center; gap: 0.85rem;
    transition: all 0.22s cubic-bezier(.22,.68,0,1.2);
    position: relative; overflow: hidden;
}
.action-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(200,137,74,0.04), transparent);
    opacity: 0;
    transition: opacity 0.2s;
}
.action-card:hover {
    border-color: rgba(200,137,74,0.4);
    box-shadow: 0 8px 24px rgba(44,26,14,0.1);
    transform: translateY(-2px);
}
.action-card:hover::after { opacity: 1; }

.action-icon-wrap {
    width: 42px; height: 42px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem; flex-shrink: 0;
    transition: transform 0.2s;
}
.action-card:hover .action-icon-wrap { transform: scale(1.1) rotate(-3deg); }
.action-icon-wrap.caramel { background: #FEF3E8; }
.action-icon-wrap.rose    { background: #FDF0EC; }
.action-icon-wrap.sage    { background: #EFF5EF; }
.action-icon-wrap.brown   { background: #F5EDE8; }

.action-text { flex: 1; min-width: 0; }
.action-title { font-weight: 700; font-size: 0.83rem; color: var(--text-dark); }
.action-desc  { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.1rem; }
.action-arrow {
    margin-left: auto; color: var(--caramel);
    opacity: 0; font-size: 0.85rem;
    transition: all 0.2s; flex-shrink: 0;
    width: 24px; height: 24px; border-radius: 50%;
    background: #FEF3E8;
    display: flex; align-items: center; justify-content: center;
}
.action-card:hover .action-arrow { opacity: 1; transform: translateX(2px); }

/* ─── RECENT TABLE CARD ─── */
.card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(44,26,14,0.04);
}
.card-header {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    background: linear-gradient(to right, var(--cream), var(--warm-white));
}
.card-header h3 { font-size: 0.88rem; font-weight: 800; color: var(--brown-deep); }
.card-link { font-size: 0.74rem; color: var(--caramel); text-decoration: none; font-weight: 700; }
.card-link:hover { text-decoration: underline; }

.table { width: 100%; border-collapse: collapse; }
.table th {
    padding: 0.65rem 1.4rem;
    text-align: left; font-size: 0.64rem;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--text-muted); border-bottom: 1px solid var(--border);
    font-weight: 700; background: var(--cream);
}
.table td {
    padding: 0.85rem 1.4rem; font-size: 0.83rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-dark); vertical-align: middle;
}
.table tr:last-child td { border-bottom: none; }
.table tbody tr { cursor: pointer; transition: background 0.15s; }
.table tbody tr:hover td { background: #FEF9F4; }

.req-id { font-weight: 800; color: var(--caramel); font-size: 0.83rem; font-variant-numeric: tabular-nums; }
.cake-name { font-weight: 700; font-size: 0.82rem; }
.cake-sub  { font-size: 0.69rem; color: var(--text-muted); margin-top: 0.15rem; }

/* ─── BADGES ─── */
.badge {
    display: inline-flex; align-items: center;
    padding: 0.2rem 0.6rem; border-radius: 20px;
    font-size: 0.62rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.05em;
    white-space: nowrap; border: 1px solid;
}
.badge-OPEN                  { background: #FEF9E8; color: #9B7A10; border-color: #F0D4B0; }
.badge-BIDDING               { background: #EBF3FE; color: #1A5BBE; border-color: #BFDBFE; }
.badge-ACCEPTED              { background: #EFF5EF; color: #2D6A30; border-color: #BFDFBE; }
.badge-IN_PROGRESS           { background: #EBF3FE; color: #1A5BBE; border-color: #BFDBFE; }
.badge-WAITING_FOR_PAYMENT   { background: #FFF4E0; color: #9B6010; border-color: #F5D8A0; }
.badge-WAITING_FINAL_PAYMENT { background: #FFF4E0; color: #9B6010; border-color: #F5D8A0; }
.badge-COMPLETED             { background: #EFF5EF; color: #2D6A30; border-color: #BFDFBE; }
.badge-CANCELLED             { background: #FDF0EE; color: #8B2A1E; border-color: #F5C5BE; }
.badge-EXPIRED               { background: #F5EDE8; color: #7A5A3A; border-color: #E8D4C0; }

/* ─── ACTIVITY FEED ─── */
.activity-card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(44,26,14,0.04);
}
.activity-header {
    padding: 1rem 1.2rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(to right, var(--cream), var(--warm-white));
    display: flex; align-items: center; justify-content: space-between;
}
.activity-header h3 { font-size: 0.88rem; font-weight: 800; color: var(--brown-deep); }

.activity-list { list-style: none; }
.activity-item {
    display: flex; align-items: flex-start; gap: 0.75rem;
    padding: 0.85rem 1.2rem;
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
    text-decoration: none; color: inherit;
    position: relative;
}
.activity-item:last-child { border-bottom: none; }
.activity-item:hover { background: var(--cream); }

/* Timeline line connecting dots */
.activity-item::before {
    content: '';
    position: absolute;
    left: calc(1.2rem + 3px);
    top: calc(0.85rem + 14px);
    bottom: 0;
    width: 1px;
    background: var(--border);
}
.activity-item:last-child::before { display: none; }

.activity-dot-wrap {
    flex-shrink: 0;
    margin-top: 4px;
    position: relative;
    z-index: 1;
}
.activity-dot {
    width: 8px; height: 8px; border-radius: 50%;
    border: 2px solid var(--warm-white);
    box-shadow: 0 0 0 1px currentColor;
}
.activity-dot.open        { background: #F0C040; color: #F0C040; }
.activity-dot.bidding     { background: #3478E8; color: #3478E8; }
.activity-dot.accepted    { background: #2D6A30; color: #2D6A30; }
.activity-dot.in_progress { background: #C8894A; color: #C8894A; }
.activity-dot.completed   { background: #2D6A30; color: #2D6A30; }
.activity-dot.cancelled   { background: #C0392B; color: #C0392B; }
.activity-dot.default     { background: var(--caramel); color: var(--caramel); }

.activity-body { flex: 1; min-width: 0; }
.activity-title { font-size: 0.78rem; font-weight: 700; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.activity-sub   { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.15rem; line-height: 1.4; }

.activity-badge {
    padding: 0.15rem 0.5rem; border-radius: 20px;
    font-size: 0.58rem; font-weight: 800;
    text-transform: uppercase; white-space: nowrap; flex-shrink: 0;
    letter-spacing: 0.04em; border: 1px solid;
}
.activity-badge.open        { background: #FEF9E8; color: #9B7A10; border-color: #F0D4B0; }
.activity-badge.bidding     { background: #EBF3FE; color: #1A5BBE; border-color: #BFDBFE; }
.activity-badge.accepted    { background: #EFF5EF; color: #2D6A30; border-color: #BFDFBE; }
.activity-badge.in_progress { background: #FEF3E8; color: var(--caramel); border-color: #F5D8C0; }
.activity-badge.completed   { background: #EFF5EF; color: #2D6A30; border-color: #BFDFBE; }
.activity-badge.cancelled   { background: #FDF0EE; color: #8B2A1E; border-color: #F5C5BE; }
.activity-badge.default     { background: #FEF3E8; color: var(--caramel); border-color: #F5D8C0; }

.activity-empty {
    padding: 2.5rem 1.5rem; text-align: center;
    color: var(--text-muted); font-size: 0.8rem;
}
.activity-empty-icon { font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.4; }

/* ─── EMPTY STATE ─── */
.empty-state { padding: 2.5rem; text-align: center; color: var(--text-muted); }
.empty-state .emoji { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; opacity: 0.6; }
.empty-state p { font-size: 0.85rem; margin-bottom: 1.1rem; }
.empty-cta {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.6rem 1.25rem; background: var(--caramel);
    color: white; border-radius: 9px; text-decoration: none;
    font-size: 0.8rem; font-weight: 700;
}
</style>
@endpush

@section('content')

{{-- ═══ HERO ═══ --}}
<div class="dashboard-hero dash-animate d1">

    <div class="hero-content">
        <div class="hero-eyebrow">Welcome</div>
        <div class="hero-title">
            Hello, {{ auth()->user()->first_name }}! <span class="wave"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 11V6a2 2 0 0 0-4 0v5"/><path d="M14 10V4a2 2 0 0 0-4 0v6"/><path d="M10 10.5V6a2 2 0 0 0-4 0v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L8 15"/></svg></span>
        </div>
        <div class="hero-sub">
            @if($totalRequests === 0)
                Ready to order your first custom cake? Let's build something delicious.
            @elseif($pendingRequests > 0)
                You have <strong style="color:var(--caramel-light);">{{ $pendingRequests }} active {{ Str::plural('order', $pendingRequests) }}</strong> in progress. Check on them below.
            @else
                Welcome back — everything looks great with your orders.
            @endif
        </div>
        <div class="hero-actions">
            <a href="{{ route('customer.cake-builder.index') }}" class="hero-cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Create Your Own 3D Custom Cake
            </a>
            @if($pendingRequests > 0)
            <a href="{{ route('customer.cake-requests.index') }}" class="hero-cta-ghost">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                View Active Orders
            </a>
            @endif
        </div>
    </div>

    {{-- Cake Illustration --}}
    <div class="hero-illustration">
        <div class="hero-sparkle hs1"></div>
        <div class="hero-sparkle hs2"></div>
        <div class="hero-sparkle hs3"></div>
        <svg width="140" height="170" viewBox="0 0 140 170" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Candles -->
            <rect x="44" y="6" width="8" height="26" rx="4" fill="#D4944F" opacity="0.9"/>
            <rect x="88" y="2" width="8" height="30" rx="4" fill="#D4944F" opacity="0.9"/>
            <!-- Flames -->
            <ellipse cx="48" cy="5" rx="5" ry="7" fill="#F7CC50" class="flame-a"/>
            <ellipse cx="48" cy="5" rx="3" ry="5" fill="#FFF3A3" class="flame-a"/>
            <ellipse cx="92" cy="1" rx="5" ry="7" fill="#F7CC50" class="flame-b"/>
            <ellipse cx="92" cy="1" rx="3" ry="5" fill="#FFF3A3" class="flame-b"/>

            <!-- Top tier -->
            <rect x="30" y="32" width="80" height="38" rx="11" fill="#C8894A" opacity="0.95"/>
            <!-- Top tier frosting drip -->
            <path d="M30 43 Q38 50 46 43 Q54 36 62 43 Q70 50 78 43 Q86 36 94 43 Q102 50 110 43" stroke="#E8B07A" stroke-width="3" fill="none" opacity="0.6"/>
            <rect x="30" y="64" width="80" height="6" rx="3" fill="#9A6028" opacity="0.7"/>

            <!-- Bottom tier -->
            <rect x="14" y="70" width="112" height="52" rx="13" fill="#E8B07A" opacity="0.95"/>
            <!-- Bottom tier frosting drip -->
            <path d="M14 84 Q25 95 36 84 Q47 73 58 84 Q69 95 80 84 Q91 73 102 84 Q113 95 126 84" stroke="#FDDFC0" stroke-width="3.5" fill="none" opacity="0.7"/>
            <rect x="14" y="115" width="112" height="7" rx="3.5" fill="#C8703A" opacity="0.7"/>

            <!-- Base plate -->
            <ellipse cx="70" cy="126" rx="64" ry="10" fill="#9A6028" opacity="0.6"/>

            <!-- Decorations bottom tier -->
            <circle cx="38" cy="96" r="5" fill="white" opacity="0.25"/>
            <circle cx="70" cy="91" r="5" fill="white" opacity="0.25"/>
            <circle cx="102" cy="96" r="5" fill="white" opacity="0.25"/>
            <circle cx="54" cy="104" r="4" fill="white" opacity="0.18"/>
            <circle cx="86" cy="104" r="4" fill="white" opacity="0.18"/>

            <!-- Decorations top tier -->
            <circle cx="52" cy="48" r="4" fill="white" opacity="0.22"/>
            <circle cx="88" cy="45" r="4" fill="white" opacity="0.22"/>
            <circle cx="70" cy="52" r="3" fill="white" opacity="0.18"/>

            <!-- Ribbon/band on bottom tier -->
            <rect x="14" y="108" width="112" height="7" rx="3.5" fill="#C8703A" opacity="0.4"/>
        </svg>
    </div>

</div>
<div class="stats-grid dash-animate d2">
<a href="{{ route('customer.cake-requests.index') }}" class="stat-card c1">
    <div class="stat-icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 12h6"/><path d="M9 16h6"/></svg></div>
    <div class="stat-meta">
        <div class="stat-value">{{ $totalRequests }}</div>
        <div class="stat-label">Total Requests</div>
        <div class="stat-badge warm">All time</div>
    </div>
</a>

<a href="{{ route('customer.cake-requests.index', ['status' => 'OPEN']) }}" class="stat-card c2">
    <div class="stat-icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9A6028" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg></div>
    <div class="stat-meta">
        <div class="stat-value">{{ $pendingRequests }}</div>
        <div class="stat-label">Active Orders</div>
        <div class="stat-badge warm">In progress</div>
    </div>
</a>

<a href="{{ route('customer.cake-requests.index', ['status' => 'COMPLETED']) }}" class="stat-card c3">
    <div class="stat-icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#5C3D2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>

    <div class="stat-meta">
        <div class="stat-value">{{ $completedRequests }}</div>
        <div class="stat-label">Completed</div>
        <div class="stat-badge {{ $completedRequests > 0 ? 'green' : 'warm' }}">
            {{ $completedRequests > 0 ? 'Fulfilled' : 'None yet' }}
        </div>
    </div>
</a>
</div>
{{-- ═══ TWO COLUMNS ═══ --}}
<div class="dashboard-cols">

    {{-- LEFT COLUMN --}}
    <div class="dash-animate d3">

        {{-- Quick Actions --}}
        <div class="section-header">
            <div class="section-title">Quick Actions</div>
        </div>
        <div class="actions-grid">
            <a href="{{ route('customer.cake-builder.index') }}" class="action-card">
                <div class="action-icon-wrap caramel"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r="2.5"/><circle cx="6.5" cy="12" r="2.5"/><circle cx="13.5" cy="17.5" r="2.5"/><path d="M17.5 12a4.5 4.5 0 0 1-9 0 4.5 4.5 0 0 1 9 0z" opacity="0.3"/><path d="M21 12c0 1.66-4 3-4 3s-4-1.34-4-3 4-3 4-3 4 1.34 4 3z"/></svg></div>
                <div class="action-text">
                    <div class="action-title">Cake Builder</div>
                    <div class="action-desc">Design a custom cake</div>
                </div>
                <span class="action-arrow">→</span>
            </a>
            <a href="{{ route('customer.cake-requests.index') }}" class="action-card">
                <div class="action-icon-wrap rose"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 12h6"/><path d="M9 16h6"/></svg></div>
                <div class="action-text">
                    <div class="action-title">My Requests</div>
                    <div class="action-desc">Track all your orders</div>
                </div>
                <span class="action-arrow">→</span>
            </a>
          <a href="{{ route('customer.cake-requests.index', ['status' => 'COMPLETED']) }}" class="action-card">
                <div class="action-icon-wrap sage"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D6A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg></div>
                <div class="action-text">
                    <div class="action-title">Order History</div>
                    <div class="action-desc">View past orders</div>
                </div>
                <span class="action-arrow">→</span>
            </a>
            <a href="{{ route('customer.profile.index') }}" class="action-card">
                <div class="action-icon-wrap brown"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7B4F3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                <div class="action-text">
                    <div class="action-title">My Profile</div>
                    <div class="action-desc">Update your details</div>
                </div>
                <span class="action-arrow">→</span>
            </a>
        </div>

        {{-- Recent Requests Table --}}
        <div class="card">
            <div class="card-header">
                <h3>Recent Requests</h3>
                <a href="{{ route('customer.cake-requests.index') }}" class="card-link">View all →</a>
            </div>
            @if($recentRequests->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cake</th>
                            <th>Delivery</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentRequests as $req)
                        @php
                            $config = is_array($req->cake_configuration)
                                ? $req->cake_configuration
                                : (json_decode($req->cake_configuration, true) ?? []);
                        @endphp
                        <tr onclick="window.location='{{ route('customer.cake-requests.show', $req->id) }}'">
                            <td><span class="req-id">#{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                            <td>
                                <div class="cake-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                                <div class="cake-sub">₱{{ number_format($req->budget_min, 0) }} – ₱{{ number_format($req->budget_max, 0) }}</div>
                            </td>
                            <td style="font-size:0.78rem; color:var(--text-muted); font-weight:500;">
                                {{ $req->delivery_date->format('M d, Y') }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $req->status }}">
                                    {{ str_replace('_', ' ', $req->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <span class="emoji"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></span>
                    <p>No requests yet. Start your first one!</p>
                    <a href="{{ route('customer.cake-builder.index') }}" class="empty-cta"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg> Build a Cake</a>
                </div>
            @endif
        </div>
    </div>

    {{-- RIGHT COLUMN: ACTIVITY FEED --}}
    <div class="dash-animate d4">
        <div class="section-header">
            <div class="section-title">Activity</div>
            <a href="{{ route('customer.notifications.index') }}" class="section-link">All →</a>
        </div>
        <div class="activity-card">
            <div class="activity-header">
                <h3>Order Updates</h3>
            </div>
            @if($recentRequests->count())
                <ul class="activity-list">
                    @foreach($recentRequests->take(6) as $req)
                    @php
                        $cfg = is_array($req->cake_configuration)
                            ? $req->cake_configuration
                            : (json_decode($req->cake_configuration, true) ?? []);
                        $dotClass = match($req->status) {
                            'OPEN'                                            => 'open',
                            'BIDDING'                                         => 'bidding',
                            'ACCEPTED'                                        => 'accepted',
                            'IN_PROGRESS','WAITING_FOR_PAYMENT',
                            'WAITING_FINAL_PAYMENT'                           => 'in_progress',
                            'COMPLETED'                                       => 'completed',
                            'CANCELLED','EXPIRED'                             => 'cancelled',
                            default                                           => 'default',
                        };
                        $statusMsg = match($req->status) {
                            'OPEN'                  => 'Waiting for baker bids',
                            'BIDDING'               => 'Bakers are bidding!',
                            'ACCEPTED'              => 'Baker confirmed',
                            'WAITING_FOR_PAYMENT'   => 'Pay downpayment',
                            'IN_PROGRESS'           => 'Cake being made',
                            'WAITING_FINAL_PAYMENT' => 'Pay final balance',
                            'COMPLETED'             => 'Delivered ✓',
                            'CANCELLED'             => 'Cancelled',
                            'EXPIRED'               => 'Expired',
                            default                 => str_replace('_', ' ', $req->status),
                        };
                    @endphp
                    <a href="{{ route('customer.cake-requests.show', $req->id) }}" class="activity-item">
                        <div class="activity-dot-wrap">
                            <div class="activity-dot {{ $dotClass }}"></div>
                        </div>
                        <div class="activity-body">
                            <div class="activity-title">
                                #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }} · {{ $cfg['flavor'] ?? 'Custom' }} {{ $cfg['shape'] ?? 'Cake' }}
                            </div>
                            <div class="activity-sub">{{ $statusMsg }} · {{ $req->updated_at->diffForHumans() }}</div>
                        </div>
                        <span class="activity-badge {{ $dotClass }}">{{ str_replace('_', ' ', $req->status) }}</span>
                    </a>
                    @endforeach
                </ul>
            @else
                <div class="activity-empty">
                    <div class="activity-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div>
                    No activity yet.<br>
                    <a href="{{ route('customer.cake-builder.index') }}" style="color:var(--caramel); font-weight:700; text-decoration:none; font-size:0.78rem;">Start your first order →</a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection