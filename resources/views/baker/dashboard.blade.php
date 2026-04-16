@extends('layouts.baker')
@section('title', 'Dashboard')

@push('styles')
<style>


* { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

/* ══ HERO ══ */
.dash-hero {
    background: linear-gradient(135deg, #1C0F07 0%, #3D2416 45%, #5C3D2E 100%);
    border-radius: 24px;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.5rem;
    display: grid;
    grid-template-columns: 1fr auto;
    min-height: 200px;
    box-shadow: 0 20px 60px rgba(44,26,14,0.35);
}
.dash-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(circle, rgba(200,137,74,0.15) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
}
.dash-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(200,137,74,0.2) 0%, transparent 70%);
    pointer-events: none;
}
.hero-content {
    padding: 2.25rem 2.75rem;
    position: relative; z-index: 2;
    display: flex; flex-direction: column; justify-content: center;
}
.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 0.4rem;
    font-size: 0.65rem; letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--caramel-light); font-weight: 700; margin-bottom: 0.65rem; opacity: 0.85;
}
.hero-eyebrow::before {
    content: ''; display: inline-block; width: 18px; height: 1.5px;
    background: var(--caramel-light); opacity: 0.6;
}
.hero-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800; line-height: 1.15; margin-bottom: 0.5rem; letter-spacing: -0.02em;
}
.hero-sub {
    font-size: 0.875rem; color: rgba(255,255,255,0.55);
    line-height: 1.6; max-width: 420px; margin-bottom: 1.75rem;
}

/* Rush toggle */
.hero-rush-wrap { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
.hero-rush {
    display: inline-flex; align-items: center; gap: 0.85rem;
    background: rgba(255,255,255,0.07); border: 1px solid rgba(200,137,74,0.35);
    border-radius: 100px; padding: 0.6rem 1rem 0.6rem 0.75rem; backdrop-filter: blur(8px);
}
.rush-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--caramel-light); flex-shrink: 0;
    animation: rushPulse 2s ease-in-out infinite;
}
.rush-dot.off { background: rgba(255,255,255,0.2); animation: none; }
@keyframes rushPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(232,169,74,0.5); }
    50%      { box-shadow: 0 0 0 5px rgba(232,169,74,0); }
}
.rush-label { font-size: 0.78rem; font-weight: 700; color: rgba(255,255,255,0.85); }
.rush-switch { position: relative; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; }
.rush-switch input { opacity:0; width:0; height:0; position:absolute; }
.rush-slider {
    position: absolute; inset: 0;
    background: rgba(255,255,255,0.15); border-radius: 24px;
    border: 1.5px solid rgba(255,255,255,0.2); transition: 0.3s;
}
.rush-slider::before {
    content: ''; position: absolute;
    width: 16px; height: 16px; border-radius: 50%;
    left: 3px; top: 50%; transform: translateY(-50%);
    background: white; transition: 0.3s; box-shadow: 0 2px 6px rgba(0,0,0,0.25);
}
.rush-switch input:checked + .rush-slider { background: var(--caramel); border-color: var(--caramel-light); }
.rush-switch input:checked + .rush-slider::before { transform: translateY(-50%) translateX(20px); }
.rush-fee-field {
    display: flex; align-items: center; gap: 0.35rem;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
    border-radius: 8px; padding: 0.3rem 0.6rem;
}
.rush-fee-field span { font-size: 0.72rem; color: rgba(255,255,255,0.5); }
.rush-fee-field input {
    width: 52px; background: transparent; border: none;
    color: white; font-size: 0.85rem; font-weight: 700;
    text-align: center; outline: none; font-family: 'Plus Jakarta Sans', sans-serif;
}

/* Hero illustration */
.hero-illustration {
    position: relative; width: 220px;
    display: flex; align-items: center; justify-content: center; align-self: center;
    padding: 2rem 2rem 1rem 0; z-index: 2;
}
@keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(200,137,74,0.4); }
    70%  { box-shadow: 0 0 0 10px rgba(200,137,74,0); }
    100% { box-shadow: 0 0 0 0 rgba(200,137,74,0); }
}
.hero-sparkle { position: absolute; border-radius: 50%; background: var(--caramel-light); opacity: 0.5; }
.hs1 { width:10px;height:10px;top:15%;left:8%;animation:pulse-ring 2.5s ease-in-out infinite; }
.hs2 { width:6px;height:6px;top:70%;left:5%;animation:pulse-ring 3.2s ease-in-out infinite 0.5s; }
.hs3 { width:8px;height:8px;top:25%;right:10%;animation:pulse-ring 2.8s ease-in-out infinite 1s; }

@media (max-width: 640px) {
    .dash-hero { grid-template-columns: 1fr; }
    .hero-illustration { display: none; }
    .hero-content { padding: 1.75rem 1.5rem; }
}

/* ══ PROFILE BANNER ══ */
.pib {
    display:flex; align-items:center; justify-content:space-between; gap:1rem;
    background:linear-gradient(135deg,#FEF3C7,#FDE68A); border:1.5px solid #F59E0B;
    border-radius:16px; padding:1.1rem 1.5rem; margin-bottom:1.5rem; flex-wrap:wrap;
}
.pib-left { display:flex; align-items:flex-start; gap:0.9rem; }
.pib-title { font-size:0.92rem; font-weight:700; color:#78350F; margin-bottom:0.35rem; }
.pib-missing { display:flex; flex-wrap:wrap; gap:0.4rem; align-items:center; font-size:0.72rem; color:#92400E; }
.pib-chip { background:rgba(245,158,11,0.2); border:1px solid rgba(245,158,11,0.4); color:#78350F; padding:0.15rem 0.6rem; border-radius:20px; font-weight:600; font-size:0.68rem; }
.pib-btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.65rem 1.25rem; background:#F59E0B; color:#fff; border-radius:10px; font-size:0.85rem; font-weight:700; text-decoration:none; white-space:nowrap; transition:background 0.2s; flex-shrink:0; }
.pib-btn:hover { background:#D97706; color:#fff; }

/* ══ STATS ══ */
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:2rem; }
.stat-card {
    background:var(--warm-white); border:1px solid var(--border); border-radius:16px;
    padding:1.5rem; position:relative; overflow:hidden; transition:transform 0.2s,box-shadow 0.2s;
}
.stat-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-warm); }
.stat-card::after {
    content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:16px 16px 0 0;
}
.stat-card.c1::after { background:linear-gradient(90deg,var(--caramel),var(--caramel-light)); }
.stat-card.c2::after { background:linear-gradient(90deg,#9A6028,#C8803A); }
.stat-card.c3::after { background:linear-gradient(90deg,#7A4A28,#B87040); }
.stat-card.c4::after { background:linear-gradient(90deg,var(--brown-deep),var(--brown-mid)); }
.stat-icon { font-size:1.6rem; margin-bottom:0.75rem; }
.stat-value { font-size:2rem; font-weight:700; color:var(--brown-deep); line-height:1; }
.stat-label { font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--text-muted); font-weight:600; margin-top:0.3rem; }
.stat-change { font-size:0.72rem; color:var(--caramel); font-weight:600; margin-top:0.5rem; }

/* ══ MAIN GRID ══ */
.main-grid { display:grid; grid-template-columns:1fr 360px; gap:1.5rem; }
.card { background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
.card-header {
    padding:1.25rem 1.5rem; border-bottom:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between;
}
.card-title { font-size:1.05rem; font-weight:700; color:var(--brown-deep); }
.card-link { font-size:0.78rem; color:var(--caramel); text-decoration:none; font-weight:600; }
.card-link:hover { text-decoration:underline; }

.request-item {
    padding:1.1rem 1.5rem; border-bottom:1px solid var(--border);
    display:flex; align-items:center; gap:1rem; transition:background 0.15s; cursor:pointer; text-decoration:none;
}
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

.bid-item { padding:1.1rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:1rem; }
.bid-item:last-child { border-bottom:none; }
.bid-status { display:inline-flex; align-items:center; padding:0.25rem 0.65rem; border-radius:20px; font-size:0.68rem; font-weight:700; text-transform:uppercase; white-space:nowrap; }
.bid-status.pending  { background:#FEF6E4; color:#9B6A10; border:1px solid #EDD090; }
.bid-status.accepted { background:#FBF0E6; color:#7A3A10; border:1px solid #E5C0A0; }
.bid-status.rejected { background:#F8EDEA; color:#8B2A1E; border:1px solid #DDB5A8; }

.earnings-bars { display:flex; align-items:flex-end; gap:6px; height:80px; padding:0 1.5rem 1.5rem; }
.e-bar-wrap { flex:1; display:flex; flex-direction:column; align-items:center; gap:4px; }
.e-bar { width:100%; border-radius:6px 6px 0 0; background:linear-gradient(to top,var(--caramel),var(--caramel-light)); min-height:4px; transition:height 0.8s cubic-bezier(.22,.68,0,1.2); }
.e-bar-label { font-size:0.55rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; }

.empty-mini { padding:2rem; text-align:center; color:var(--text-muted); font-size:0.82rem; }
.empty-mini .emo { font-size:1.8rem; margin-bottom:0.5rem; }
</style>
@endpush

@section('content')

<div class="dash-hero">
    <div class="hero-content">
        <div class="hero-eyebrow">Welcome</div>
        <div class="hero-title">Hello, {{ auth()->user()->first_name }}!</div>
        <div class="hero-sub">
            @if($openRequestsCount > 0)
                You have <strong style="color:var(--caramel-light);">{{ $openRequestsCount }} open {{ Str::plural('request', $openRequestsCount) }}</strong> waiting for a bid. Get baking!
            @else
                Welcome back — here's what's happening today.
            @endif
        </div>
    <div class="hero-rush-wrap">
    <div style="display:inline-flex; flex-direction:column; gap:0.5rem; background:rgba(255,255,255,0.07); border:1px solid rgba(200,137,74,0.35); border-radius:16px; padding:0.85rem 1.1rem; backdrop-filter:blur(8px);">
        <div style="display:flex; align-items:center; gap:0.85rem;">
            <div class="rush-dot {{ auth()->user()->baker->accepts_rush_orders ? '' : 'off' }}" id="rushDot"></div>
            <span class="rush-label">⚡ Rush Orders</span>
            <label class="rush-switch" style="margin-left:auto;">
                <input type="checkbox" id="rushToggle"
                       {{ auth()->user()->baker->accepts_rush_orders ? 'checked' : '' }}
                       onchange="toggleRush(this)">
                <span class="rush-slider"></span>
            </label>
        </div>
        <div style="font-size:0.68rem; color:rgba(255,255,255,0.38); line-height:1.5; padding-left:1.35rem;">
            When on, you'll be auto-matched and assigned to customers who need a cake ASAP.
        </div>
    </div>
    <div class="rush-fee-field" id="rush-fee-wrap"
         style="{{ auth()->user()->baker->accepts_rush_orders ? '' : 'display:none' }}">
        <span>Rush Fee ₱</span>
        <input type="number" id="rushFeeInput"
               value="{{ auth()->user()->baker->rush_fee ?? 150 }}"
               min="0" max="9999"
               onchange="saveRushFee(this.value)">
    </div>
</div>
</div>

    <div class="hero-illustration">
        <div class="hero-sparkle hs1"></div>
        <div class="hero-sparkle hs2"></div>
        <div class="hero-sparkle hs3"></div>
        <svg width="140" height="170" viewBox="0 0 140 170" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="44" y="6" width="8" height="26" rx="4" fill="#D4944F" opacity="0.9"/>
            <rect x="88" y="2" width="8" height="30" rx="4" fill="#D4944F" opacity="0.9"/>
            <ellipse cx="48" cy="5" rx="5" ry="7" fill="#F7CC50"/>
            <ellipse cx="48" cy="5" rx="3" ry="5" fill="#FFF3A3"/>
            <ellipse cx="92" cy="1" rx="5" ry="7" fill="#F7CC50"/>
            <ellipse cx="92" cy="1" rx="3" ry="5" fill="#FFF3A3"/>
            <rect x="30" y="32" width="80" height="38" rx="11" fill="#C8894A" opacity="0.95"/>
            <path d="M30 43 Q38 50 46 43 Q54 36 62 43 Q70 50 78 43 Q86 36 94 43 Q102 50 110 43" stroke="#E8B07A" stroke-width="3" fill="none" opacity="0.6"/>
            <rect x="30" y="64" width="80" height="6" rx="3" fill="#9A6028" opacity="0.7"/>
            <rect x="14" y="70" width="112" height="52" rx="13" fill="#E8B07A" opacity="0.95"/>
            <path d="M14 84 Q25 95 36 84 Q47 73 58 84 Q69 95 80 84 Q91 73 102 84 Q113 95 126 84" stroke="#FDDFC0" stroke-width="3.5" fill="none" opacity="0.7"/>
            <rect x="14" y="115" width="112" height="7" rx="3.5" fill="#C8703A" opacity="0.7"/>
            <ellipse cx="70" cy="126" rx="64" ry="10" fill="#9A6028" opacity="0.6"/>
            <circle cx="38" cy="96" r="5" fill="white" opacity="0.25"/>
            <circle cx="70" cy="91" r="5" fill="white" opacity="0.25"/>
            <circle cx="102" cy="96" r="5" fill="white" opacity="0.25"/>
            <circle cx="52" cy="104" r="4" fill="white" opacity="0.18"/>
            <circle cx="86" cy="104" r="4" fill="white" opacity="0.18"/>
            <circle cx="52" cy="48" r="4" fill="white" opacity="0.22"/>
            <circle cx="88" cy="45" r="4" fill="white" opacity="0.22"/>
            <circle cx="70" cy="52" r="3" fill="white" opacity="0.18"/>
            <rect x="14" y="108" width="112" height="7" rx="3.5" fill="#C8703A" opacity="0.4"/>
        </svg>
    </div>
</div>

@if($profileIncomplete)
<div class="pib">
    <div class="pib-left">
        <div style="font-size:1.4rem; flex-shrink:0; margin-top:0.1rem;">⚠️</div>
        <div>
            <div class="pib-title">Complete your profile to start bidding</div>
            <div class="pib-missing">
                Missing:
                @foreach($missingFields as $field)
                    <span class="pib-chip">{{ $field }}</span>
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('baker.profile.index') }}" class="pib-btn">Complete Profile →</a>
</div>
@endif

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
                    <div class="e-bar"
                         data-h="{{ max(4, ($month['total']/$maxEarning)*72) }}"
                         style="height:0px;"
                         title="₱{{ number_format($month['total'],0) }}"></div>
                    <div class="e-bar-label">{{ $month['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleRush(checkbox) {
    const feeWrap = document.getElementById('rush-fee-wrap');
    const dot = document.getElementById('rushDot');
    feeWrap.style.display = checkbox.checked ? '' : 'none';
    dot.classList.toggle('off', !checkbox.checked);
    fetch('{{ route("baker.toggle-rush") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ accepts_rush: checkbox.checked })
    });
}
function saveRushFee(value) {
    fetch('{{ route("baker.toggle-rush") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ rush_fee: parseInt(value) })
    });
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.e-bar').forEach((bar, i) => {
        const h = bar.dataset.h;
        setTimeout(() => { bar.style.height = h + 'px'; }, 100 + i * 80);
    });
});
</script>
@endpush