@extends('layouts.baker')
@section('title', 'Request #' . str_pad($request->id, 4, '0', STR_PAD_LEFT))

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

    * { font-family: 'Plus Jakarta Sans', sans-serif; }

    .back-link {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.8rem; color: var(--text-muted); text-decoration: none;
        margin-bottom: 1.5rem; font-weight: 500; transition: color 0.2s;
    }
    .back-link:hover { color: var(--caramel); }

    /* ── HERO BANNER ── */
    .request-hero {
        background: linear-gradient(135deg, #2C1A0E 0%, #5C3D2E 60%, #7A4A28 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .request-hero::before {
        content: '';
        position: absolute; right: -40px; top: -40px;
        width: 200px; height: 200px; border-radius: 50%;
        background: rgba(200,137,58,0.12);
    }
    .request-hero::after {
        content: '';
        position: absolute; right: 100px; bottom: -60px;
        width: 140px; height: 140px; border-radius: 50%;
        background: rgba(200,137,58,0.07);
    }
    .hero-left { position: relative; z-index: 1; }
    .hero-req-id {
        font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase;
        color: rgba(255,255,255,0.45); margin-bottom: 0.35rem;
    }
    .hero-cake-name {
        font-size: 1.6rem; font-weight: 800; color: white;
        line-height: 1.15; margin-bottom: 0.5rem;
        letter-spacing: -0.01em;
    }
    .hero-meta { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .hero-tag {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.25rem 0.75rem; border-radius: 20px;
        background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18);
        font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.85);
        line-height: 1;
    }
    .hero-right {
        text-align: right; position: relative; z-index: 1; flex-shrink: 0;
    }
    .hero-budget-label {
        font-size: 0.6rem; letter-spacing: 0.15em; text-transform: uppercase;
        color: rgba(255,255,255,0.4); margin-bottom: 0.2rem;
    }
    .hero-budget {
        font-size: 1.5rem; font-weight: 800; color: var(--caramel-light);
        line-height: 1;
    }
    .hero-deadline {
        font-size: 0.72rem; color: rgba(255,255,255,0.5); margin-top: 0.4rem;
    }
  .urgency-badge {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.25rem 0.75rem; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700; margin-top: 0;
    }
.urgency-badge.high   { background: rgba(180,60,60,0.25); color: #FFAAAA; border: 1px solid rgba(180,60,60,0.4); line-height:1; }
.urgency-badge.normal { background: rgba(200,137,58,0.2); color: #E8C07A; border: 1px solid rgba(200,137,58,0.3); line-height:1; }

    /* ── LAYOUT ── */
    .detail-grid { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start; }

    /* ── SECTION CARDS ── */
    .section-card {
        background: var(--warm-white);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .section-card:last-child { margin-bottom: 0; }

    .section-header {
        padding: 0.9rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--cream);
    }
    .section-title {
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.1em;
        color: var(--text-mid);
    }
    .section-badge {
        font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.55rem;
        background: var(--caramel); color: white; border-radius: 20px;
    }

    /* ── SPEC GRID ── */
    .spec-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }
    .spec-item {
        padding: 0.9rem 1.5rem;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
    }
    .spec-item:nth-child(even) { border-right: none; }
    .spec-item:nth-last-child(-n+2) { border-bottom: none; }
    .spec-item.full {
        grid-column: 1 / -1;
        border-right: none;
    }
    .spec-label {
        font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.1em;
        color: var(--text-muted); font-weight: 700; margin-bottom: 0.3rem;
    }
    .spec-value {
        font-size: 0.875rem; font-weight: 600; color: var(--text-dark);
        line-height: 1.4;
    }
    .spec-value.accent { color: var(--caramel); }

    .addon-tags { display: flex; flex-wrap: wrap; gap: 0.35rem; margin-top: 0.25rem; }
    .addon-tag {
        padding: 0.2rem 0.6rem; background: var(--cream);
        border: 1px solid var(--border); border-radius: 6px;
        font-size: 0.7rem; color: var(--text-mid); font-weight: 600;
    }

    /* ── REFERENCE IMAGE ── */
    .ref-image-full {
        width: 100%;
        display: block;
        object-fit: contain;
        max-height: 480px;
        background: #F0EBE3;
    }
   .preview-image-full {
        width: 100%;
        display: block;
        object-fit: cover;
        max-height: 360px;
        background: #F0EBE3;
    }

    /* ── MAP ── */
    .map-placeholder {
        height: 200px; background: linear-gradient(135deg, #F5EFE6, #EDD0A8);
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 0.5rem;
        font-size: 0.82rem; color: var(--text-muted);
    }

    /* ── BIDS LIST ── */
    .bid-row {
        padding: 0.85rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
        transition: background 0.15s;
    }
    .bid-row:last-child { border-bottom: none; }
    .bid-row:hover { background: #FBF5EE; }
    .bid-row.mine { background: #FBF4EC; border-left: 3px solid var(--caramel); }

    /* ── SIDEBAR ── */
    .budget-display {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #FBF0E0, #F5E4C8);
        border-bottom: 1px solid var(--border);
        text-align: center;
    }
    .budget-display-label {
        font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.12em;
        color: var(--text-muted); font-weight: 700; margin-bottom: 0.3rem;
    }
    .budget-display-value {
        font-size: 1.4rem; font-weight: 800; color: var(--brown-deep);
    }

    /* ── BID FORM ── */
    .bid-form-wrap { padding: 1.25rem; }
    .form-group { margin-bottom: 1.1rem; }
    .form-label {
        display: block; font-size: 0.72rem; font-weight: 700;
        color: var(--text-mid); margin-bottom: 0.35rem;
        text-transform: uppercase; letter-spacing: 0.06em;
    }
    .form-input {
        width: 100%; padding: 0.65rem 1rem;
        border: 1.5px solid var(--border); border-radius: 10px;
        font-size: 0.875rem; font-family: inherit;
        background: var(--cream); outline: none;
        transition: border-color 0.2s, background 0.2s;
        box-sizing: border-box; color: var(--text-dark);
    }
    .form-input:focus { border-color: var(--caramel); background: white; }
    .form-textarea { resize: vertical; min-height: 90px; }
    .form-hint { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.3rem; }

    .btn-submit {
        width: 100%; padding: 0.85rem;
        background: linear-gradient(135deg, var(--brown-mid), var(--caramel));
        color: white; border: none; border-radius: 12px;
        font-size: 0.875rem; font-weight: 700; cursor: pointer;
        font-family: inherit; transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(200,137,58,0.35);
    }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(200,137,58,0.45); }

    .btn-danger {
        width: 100%; padding: 0.75rem;
        background: #FDF0EE; color: #8B2A1E;
        border: 1.5px solid #F5C5BE; border-radius: 10px;
        font-size: 0.82rem; font-weight: 700; cursor: pointer;
        font-family: inherit; transition: background 0.2s;
    }
    .btn-danger:hover { background: #F5C5BE; }

    /* ── MY BID DISPLAY ── */
    .my-bid-amount {
        font-size: 1.75rem; font-weight: 800; color: var(--brown-deep);
        line-height: 1;
    }
    .bid-status-pill {
        display: inline-flex; align-items: center;
        padding: 0.25rem 0.75rem; border-radius: 20px;
        font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .bid-status-pill.pending  { background: #FEF6E4; color: #9B6A10; border: 1px solid #EDD090; }
    .bid-status-pill.accepted { background: #FBF0E6; color: #7A3A10; border: 1px solid #E5C0A0; }
    .bid-status-pill.rejected { background: #F8EDEA; color: #8B2A1E; border: 1px solid #DDB5A8; }

    /* ── STICKY SIDEBAR ── */
    .sidebar-sticky { position: sticky; top: 5rem; }

    /* ── NOTES BOX ── */
    .notes-box {
        margin: 0; padding: 1rem 1.5rem;
        font-size: 0.82rem; color: var(--text-mid);
        line-height: 1.65; font-style: italic;
        border-left: 3px solid var(--caramel);
        background: #FBF6F0;
    }
</style>
@endpush

@section('content')

<a href="{{ route('baker.requests.index') }}" class="back-link">← Back to Browse Requests</a>

@php
    $config   = is_array($request->cake_configuration) ? $request->cake_configuration : (json_decode($request->cake_configuration, true) ?? []);
    $myBid    = $request->bids()->where('baker_id', auth()->id())->first();
    $daysLeft = (int) now()->diffInDays($request->delivery_date, false);
@endphp

{{-- HERO --}}
<div class="request-hero">
    <div class="hero-left">
        <div class="hero-req-id">Request · #{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div class="hero-cake-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
        <div class="hero-meta">
            @if(!empty($config['size']))<span class="hero-tag">{{ $config['size'] }}</span>@endif
            @if(!empty($config['frosting']))<span class="hero-tag">{{ $config['frosting'] }}</span>@endif
            @if(!empty($config['layers']))<span class="hero-tag">{{ $config['layers'] }} layers</span>@endif
         @if($request->status === 'RUSH_MATCHING')
                <span class="urgency-badge high">⚡ Rush — Accept Now</span>
            @elseif($daysLeft <= 3)
                <span class="urgency-badge high">🔥 Urgent — {{ $daysLeft }}d left</span>
            @else
                <span class="urgency-badge normal">📅 {{ $daysLeft }} days left</span>
            @endif
        </div>
    </div>
    <div class="hero-right">
        <div class="hero-budget-label">Budget Range</div>
        <div class="hero-budget">₱{{ number_format($request->budget_min, 0) }}–₱{{ number_format($request->budget_max, 0) }}</div>
        <div class="hero-deadline">Due {{ $request->delivery_date->format('M d, Y') }}</div>
        <div style="font-size:0.68rem;color:rgba(255,255,255,0.35);margin-top:0.3rem;">{{ $request->bids()->count() }} bid{{ $request->bids()->count() !== 1 ? 's' : '' }} so far</div>
    </div>
</div>

<div class="detail-grid">

    {{-- LEFT COLUMN --}}
    <div>

        {{-- Cake Specs --}}
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">🎂 Cake Specifications</span>
            </div>
            <div class="spec-grid">
                @if(!empty($config['flavor']))
                <div class="spec-item">
                    <div class="spec-label">Flavor</div>
                    <div class="spec-value">{{ $config['flavor'] }}</div>
                </div>
                @endif
                @if(!empty($config['shape']))
                <div class="spec-item">
                    <div class="spec-label">Shape</div>
                    <div class="spec-value">{{ $config['shape'] }}</div>
                </div>
                @endif
                @if(!empty($config['size']))
                <div class="spec-item">
                    <div class="spec-label">Size</div>
                    <div class="spec-value">{{ $config['size'] }}</div>
                </div>
                @endif
                @if(!empty($config['layers']))
                <div class="spec-item">
                    <div class="spec-label">Layers</div>
                    <div class="spec-value">{{ $config['layers'] }}</div>
                </div>
                @endif
                @if(!empty($config['frosting']))
                <div class="spec-item">
                    <div class="spec-label">Frosting</div>
                    <div class="spec-value">{{ $config['frosting'] }}</div>
                </div>
                @endif
              <div class="spec-item">
    <div class="spec-label">Delivery Date</div>
    <div class="spec-value accent">
        {{ $request->delivery_date->format('F d, Y') }}
        @if($request->needed_time)
            <div style="font-size:0.72rem; color:var(--caramel); margin-top:0.15rem;">
                🕐 {{ \Carbon\Carbon::parse($request->needed_time)->format('g:i A') }}
            </div>
        @endif
    </div>
</div>
                @if(!empty($config['addons']))
                <div class="spec-item full">
                    <div class="spec-label">Add-ons</div>
                    <div class="addon-tags">
                        @foreach((array)$config['addons'] as $addon)
                        <span class="addon-tag">{{ $addon }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Notes --}}
        @if($request->custom_message || $request->special_instructions)
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">📝 Customer Notes</span>
            </div>
            @if($request->custom_message)
            <div class="notes-box" style="{{ $request->special_instructions ? 'border-bottom:1px solid var(--border);' : '' }}">
                <div style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);margin-bottom:0.3rem;font-style:normal;">Message on Cake</div>
                "{{ $request->custom_message }}"
            </div>
            @endif
            @if($request->special_instructions)
            <div class="notes-box" style="font-style:normal;">
                <div style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);margin-bottom:0.3rem;">Special Instructions</div>
                {{ $request->special_instructions }}
            </div>
            @endif
        </div>
        @endif
        {{-- 3D Preview --}}
        @if($request->cake_preview_image)
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">🎂 3D Cake Preview</span>
            </div>
            <img src="{{ asset('storage/'.$request->cake_preview_image) }}"
                 class="preview-image-full"
                 alt="3D Cake Preview">
            <div style="padding:0.6rem 1rem;font-size:0.7rem;color:var(--text-muted);text-align:center;border-top:1px solid var(--border);">
                Customer's 3D cake design preview
            </div>
        </div>
        @endif

        {{-- Delivery Location --}}
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">📍 Delivery Location</span>
            </div>
            <div style="padding:1rem 1.5rem;">
                @if($request->hasMapLocation())
                <div id="delivery-map" style="height:240px;border-radius:10px;overflow:hidden;margin-bottom:0.75rem;"></div>
                @else
                <div class="map-placeholder" style="border-radius:10px;margin-bottom:0.75rem;">
                    <span style="font-size:1.5rem;">📍</span>
                    <span>No precise location set</span>
                </div>
                @endif
                @if($request->delivery_address)
                <div style="font-size:0.82rem;color:var(--text-mid);font-weight:500;line-height:1.5;">
                    {{ $request->delivery_address }}
                </div>
                @endif
            </div>
        </div>

        {{-- Other Bids --}}
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">🏷 All Bids</span>
                <span class="section-badge">{{ $request->bids()->count() }}</span>
            </div>
            @forelse($request->bids as $bid)
            <div class="bid-row {{ $myBid && $myBid->id === $bid->id ? 'mine' : '' }}">
                <div>
                    <div style="font-size:0.8rem;font-weight:600;color:var(--text-dark);">
                        Baker #{{ $bid->baker_id }}
                        @if($myBid && $myBid->id === $bid->id)
                        <span style="font-size:0.65rem;color:var(--caramel);margin-left:0.3rem;">← you</span>
                        @endif
                    </div>
                    <div style="font-size:0.68rem;color:var(--text-muted);margin-top:0.1rem;">{{ $bid->created_at->diffForHumans() }}</div>
                </div>
                <div style="font-size:0.95rem;font-weight:700;color:var(--brown-mid);">₱{{ number_format($bid->amount, 0) }}</div>
            </div>
            @empty
            <div style="padding:2rem;text-align:center;font-size:0.82rem;color:var(--text-muted);">
                <div style="font-size:1.5rem;margin-bottom:0.5rem;">🏷</div>
                Be the first to bid!
            </div>
            @endforelse
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="sidebar-sticky">

        <div class="section-card">
        <div class="budget-display">
                <div class="budget-display-label">{{ $myBid ? 'Your Bid' : "Customer's Budget" }}</div>
                <div class="my-bid-amount">
                    @if($myBid)
                        ₱{{ number_format($myBid->amount, 0) }}
                    @else
                        ₱{{ number_format($request->budget_min, 0) }}–{{ number_format($request->budget_max, 0) }}
                    @endif
                </div>
             
                @if($myBid)
                <div style="margin-top:0.75rem;">
                    <span class="bid-status-pill {{ strtolower($myBid->status) }}">{{ $myBid->status }}</span>
                </div>
                @endif
            </div>

    @if($request->status === 'RUSH_MATCHING' && !$myBid)
            {{-- ── RUSH BID BLOCK ── --}}
            @php
                $config2     = is_array($request->cake_configuration) ? $request->cake_configuration : (json_decode($request->cake_configuration, true) ?? []);
                $basePrice   = (float)($config2['total'] ?? $request->budget_min ?? 0);
                $bakerRecord = \App\Models\Baker::where('user_id', auth()->id())->first();
                $rushFee     = (float)($bakerRecord?->rush_fee ?? 0);
                $autoPrice   = $basePrice + $rushFee;
                if ($autoPrice > $request->budget_max) { $autoPrice = (float)$request->budget_max; }
            @endphp
            <div style="background:linear-gradient(135deg,#1A0A00,#3B1F0F);padding:1.25rem;color:white;">
                <div style="font-size:1.1rem;font-weight:800;margin-bottom:0.25rem;">⚡ Rush Order</div>
    <div style="font-size:0.75rem;opacity:0.6;margin-bottom:1rem;">Submit your price — the customer picks within 60 seconds.</div>
                <div style="background:rgba(255,255,255,0.08);border-radius:10px;padding:0.85rem;margin-bottom:1rem;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem;">
                        <span style="font-size:0.7rem;opacity:0.6;text-transform:uppercase;letter-spacing:0.07em;">Base price</span>
                        <span style="font-weight:700;font-size:0.85rem;">₱{{ number_format($basePrice, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem;">
                        <span style="font-size:0.7rem;opacity:0.6;text-transform:uppercase;letter-spacing:0.07em;">Your rush fee</span>
                        <span style="font-weight:700;font-size:0.85rem;color:#E8A94A;">+ ₱{{ number_format($rushFee, 2) }}</span>
                    </div>
                    <div style="border-top:1px solid rgba(255,255,255,0.15);padding-top:0.4rem;display:flex;justify-content:space-between;">
                        <span style="font-size:0.75rem;font-weight:700;opacity:0.9;">You earn</span>
                        <span style="font-size:1.2rem;font-weight:800;color:#E8A94A;">₱{{ number_format($autoPrice, 2) }}</span>
                    </div>
                </div>
                @if(!$bakerRecord?->accepts_rush_orders || !$bakerRecord?->is_available)
                <div style="background:rgba(255,255,255,0.08);border-radius:10px;padding:0.75rem;font-size:0.75rem;opacity:0.75;text-align:center;">
                    ⚠ Enable Rush Mode and set yourself as Available in your profile to accept rush orders.
                </div>
                @else
                <form method="POST" action="{{ route('baker.rush-orders.accept', $request->id) }}" id="rush-accept-form">
                    @csrf
                    <button type="button" onclick="openRushConfirm()"
                        style="width:100%;padding:0.85rem;background:linear-gradient(135deg,#C8893A,#E8A94A);color:white;border:none;border-radius:10px;font-family:inherit;font-size:0.9rem;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(200,137,58,0.4);">
             ⚡ Submit Rush Bid
                    </button>
                </form>
                <div id="rush-confirm-backdrop" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(20,10,4,0.75);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:1rem;">
                    <div style="background:#FFFDF9;border-radius:24px;max-width:380px;width:100%;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,0.3);">
                        <div style="background:linear-gradient(135deg,#1A0A00,#5C3010);padding:2rem;text-align:center;color:white;">
                            <div style="font-size:2rem;margin-bottom:0.5rem;">⚡</div>
         <div style="font-family:inherit;font-size:1.2rem;font-weight:800;margin-bottom:0.25rem;">Submit Rush Bid?</div>
                            <div style="font-size:0.75rem;opacity:0.6;">Your price appears to the customer immediately</div>
                        </div>
                        <div style="padding:1.5rem;">
                            <div style="background:#F5EFE6;border-radius:12px;padding:1rem;margin-bottom:1rem;">
                                <div style="display:flex;justify-content:space-between;padding:0.3rem 0;font-size:0.82rem;">
                                    <span style="color:#9A7A5A;">Customer</span>
                                    <span style="font-weight:700;color:#2C1A0E;">{{ $request->user->first_name }}</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:0.3rem 0;font-size:0.82rem;border-top:1px solid #EAE0D0;margin-top:0.3rem;padding-top:0.6rem;">
                                    <span style="color:#9A7A5A;">Delivery date</span>
                                    <span style="font-weight:700;color:#C8893A;">{{ $request->delivery_date->format('M d, Y') }}</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:0.3rem 0;font-size:0.82rem;border-top:1px solid #EAE0D0;margin-top:0.3rem;padding-top:0.6rem;">
                                    <span style="color:#9A7A5A;">You earn</span>
                                    <span style="font-size:1.1rem;font-weight:800;color:#2C1A0E;">₱{{ number_format($autoPrice, 2) }}</span>
                                </div>
                            </div>
                            <div style="display:flex;gap:0.75rem;">
                                <button onclick="closeRushConfirm()" style="flex:1;padding:0.75rem;border-radius:12px;border:1.5px solid #EAE0D0;background:white;color:#6B4A2A;font-size:0.85rem;font-weight:600;cursor:pointer;font-family:inherit;">Cancel</button>
                                <button onclick="submitRushAccept(this)" style="flex:2;padding:0.75rem;border-radius:12px;border:none;background:linear-gradient(135deg,#C8893A,#E8A94A);color:white;font-size:0.85rem;font-weight:700;cursor:pointer;font-family:inherit;">⚡ Submit My Bid</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                function openRushConfirm(){document.getElementById('rush-confirm-backdrop').style.display='flex';document.body.style.overflow='hidden';}
                function closeRushConfirm(){document.getElementById('rush-confirm-backdrop').style.display='none';document.body.style.overflow='';}
           function submitRushAccept(btn){btn.textContent='Submitting…';btn.disabled=true;document.getElementById('rush-accept-form').submit();}
                document.getElementById('rush-confirm-backdrop').addEventListener('click',function(e){if(e.target===this)closeRushConfirm();});
                </script>
                @if($request->rush_expires_at)
                <div style="margin-top:0.85rem;text-align:center;font-size:0.7rem;opacity:0.5;">⏱ Expires in: <span id="rush-exp-timer">--</span></div>
                <script>
                (function(){
                    const exp=new Date('{{ $request->rush_expires_at->toISOString() }}');
                    const el=document.getElementById('rush-exp-timer');
                    function tick(){const d=Math.max(0,Math.floor((exp-new Date())/1000));el.textContent=Math.floor(d/60)+':'+String(d%60).padStart(2,'0');if(d>0)setTimeout(tick,1000);else el.textContent='Expired';}
                    tick();
                })();
                </script>
                @endif
               @endif
            </div>
@endif   {{-- closes @if($request->status === 'RUSH_MATCHING' && !$myBid) --}}

@if($myBid)
            {{-- Already bid --}}
            <div style="padding:1.25rem;">
                @if($request->status === 'RUSH_MATCHING')
                @php
                    $bakerRecordRush = \App\Models\Baker::where('user_id', auth()->id())->first();
                    $rushFeeDisplay  = (float)($bakerRecordRush?->rush_fee ?? 0);
                    $baseDisplay     = $myBid->amount - $rushFeeDisplay;
                @endphp
                <div style="background:linear-gradient(135deg,#1A0A00,#2E1508);border-radius:10px;padding:0.85rem 1rem;margin-bottom:1rem;border:1px solid rgba(200,137,58,0.3);">
                    <div style="font-size:0.62rem;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.4);font-weight:700;margin-bottom:0.6rem;">⚡ Your Rush Bid Breakdown</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;padding:0.3rem 0;border-bottom:1px solid rgba(255,255,255,0.08);">
                        <span style="color:rgba(255,255,255,0.55);">Base price</span>
                        <span style="font-weight:600;color:rgba(255,255,255,0.85);">₱{{ number_format($baseDisplay, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;padding:0.3rem 0;border-bottom:1px solid rgba(255,255,255,0.08);">
                        <span style="color:rgba(255,255,255,0.55);">Your rush fee</span>
                        <span style="font-weight:600;color:#E8A94A;">+ ₱{{ number_format($rushFeeDisplay, 2) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.9rem;padding:0.4rem 0 0;">
                        <span style="color:rgba(255,255,255,0.8);font-weight:700;">You earn</span>
                        <span style="font-weight:800;color:#E8A94A;">₱{{ number_format($myBid->amount, 2) }}</span>
                    </div>
                </div>
                <div style="background:#FEF9E8;border:1px solid #F0D090;border-radius:8px;padding:0.6rem 0.85rem;font-size:0.72rem;color:#8A5010;line-height:1.5;margin-bottom:1rem;">
                    ⏱ Customer has <strong>60 seconds</strong> to accept your bid. If no one is chosen in time, the system auto-assigns the nearest baker with the best price.
                </div>
                @endif
                @if($myBid->message)
                <div style="background:var(--cream);border-radius:10px;padding:0.85rem 1rem;font-size:0.82rem;color:var(--text-mid);margin-bottom:1rem;border-left:3px solid var(--caramel);line-height:1.55;">
                    "{{ $myBid->message }}"
                </div>
                @endif
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;color:var(--text-muted);padding:0.5rem 0;border-bottom:1px solid var(--border);">
                    <span>Estimate</span>
                    <strong style="color:var(--text-dark);">{{ $myBid->estimated_days ? $myBid->estimated_days.' days' : '—' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;color:var(--text-muted);padding:0.5rem 0;margin-bottom:1rem;">
                    <span>Submitted</span>
                    <strong style="color:var(--text-dark);">{{ $myBid->created_at->diffForHumans() }}</strong>
                </div>
                @if($myBid->status === 'PENDING')
                <form method="POST" action="{{ route('baker.bids.destroy', $myBid->id) }}" onsubmit="return confirm('Withdraw your bid?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger">Withdraw Bid</button>
                </form>
                @endif
            </div>

            @else
            {{-- Bid form --}}
            <div class="bid-form-wrap" id="bid-form">
                <form method="POST" action="{{ route('baker.bids.store') }}">
                    @csrf
                    <input type="hidden" name="cake_request_id" value="{{ $request->id }}">

                   <div class="form-group">
                        <label class="form-label">Your Bid (₱) *</label>
                        <input type="number" name="amount" class="form-input"
                               min="1" step="1"
                               placeholder="{{ number_format($request->budget_min, 0) }}"
                               value="{{ old('amount') }}" required>
                        <div class="form-hint">Range: ₱{{ number_format($request->budget_min,0) }}–₱{{ number_format($request->budget_max,0) }}</div>
                    </div>

                    @if($request->is_rush)
                    <div class="form-group">
                        <label class="form-label">⚡ Rush Fee (₱)</label>
                        <input type="number" name="rush_fee" class="form-input"
                               min="0" step="1"
                               placeholder="e.g. 150"
                               value="{{ old('rush_fee', 0) }}">
                        <div class="form-hint">Extra charge you add for rush/urgent handling. Enter 0 if none.</div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Days to Complete *</label>
                        <input type="number" name="estimated_days" class="form-input"
                               min="1" max="60" step="1"
                               placeholder="e.g. 3"
                               value="{{ old('estimated_days') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Message to Customer</label>
                        <textarea name="message" class="form-input form-textarea"
                                  placeholder="Enter notes or comments… ">{{ old('message') }}</textarea>
                    
                    </div>

                    <button type="submit" class="btn-submit">🏷 Submit Bid</button>
                </form>
            </div>
            @endif
        </div>

        {{-- Quick info card --}}
        <div class="section-card" style="margin-top:1rem;">
            <div class="section-header">
                <span class="section-title">📦 Order Info</span>
            </div>
            <div style="padding:0;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1.25rem;border-bottom:1px solid var(--border);font-size:0.8rem;">
                    <span style="color:var(--text-muted);font-weight:500;">Submitted</span>
                    <span style="font-weight:600;color:var(--text-dark);">{{ $request->created_at->format('M d, Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1.25rem;border-bottom:1px solid var(--border);font-size:0.8rem;">
                    <span style="color:var(--text-muted);font-weight:500;">Fulfillment</span>
                    <span style="font-weight:600;color:var(--caramel);">{{ $request->fulfillment_label ?? 'Delivery' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1.25rem;font-size:0.8rem;">
                    <span style="color:var(--text-muted);font-weight:500;">Total Bids</span>
                    <span style="font-weight:700;color:var(--brown-deep);">{{ $request->bids()->count() }}</span>
                </div>
            </div>
       </div>

        {{-- Reference Image --}}
        @if($request->reference_image)
        <div class="section-card" style="margin-top:1rem;">
            <div class="section-header">
                <span class="section-title">🖼️ Reference Image</span>
            </div>
            <img src="{{ asset('storage/'.$request->reference_image) }}"
                 class="ref-image-full"
                 alt="Reference Image">
            <div style="padding:0.6rem 1rem;font-size:0.7rem;color:var(--text-muted);text-align:center;border-top:1px solid var(--border);">
                Match this style as closely as possible
            </div>
        </div>
        @endif

    </div>

</div>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($request->hasMapLocation())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $request->delivery_lat }};
    const lng = {{ $request->delivery_lng }};
    const map = L.map('delivery-map', {
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false,
        doubleClickZoom: false
    }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:20px;height:20px;background:#C8894A;border:3px solid white;border-radius:50%;box-shadow:0 2px 12px rgba(200,137,74,0.7);"></div>`,
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    L.marker([lat, lng], { icon })
        .addTo(map)
        .bindPopup('📍 Customer delivery location')
        .openPopup();
});
</script>
@endif
@endpush