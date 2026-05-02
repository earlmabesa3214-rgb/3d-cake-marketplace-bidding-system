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
        display: flex; align-items: center; gap: 0.4rem;
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
    .spec-item.no-right  { border-right: none; }
    .spec-item.no-bottom { border-bottom: none; }
    .spec-item.full {
        grid-column: 1 / -1;
        border-right: none;
        border-bottom: none;
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
        display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(200,137,58,0.45); }

    .btn-danger {
        width: 100%; padding: 0.75rem;
        background: #FDF0EE; color: #8B2A1E;
        border: 1.5px solid #F5C5BE; border-radius: 10px;
        font-size: 0.82rem; font-weight: 700; cursor: pointer;
        font-family: inherit; transition: background 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 0.4rem;
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

    /* SVG icon helper */
    .icon { display: inline-block; vertical-align: -3px; flex-shrink: 0; }
</style>
@endpush

@section('content')

<a href="{{ route('baker.requests.index') }}" class="back-link">← Back to Browse Requests</a>

@php
    $config   = is_array($request->cake_configuration) ? $request->cake_configuration : (json_decode($request->cake_configuration, true) ?? []);
$bakerMe = \App\Models\Baker::where('user_id', auth()->id())->first();
$myBid = \App\Models\Bid::where('cake_request_id', $request->id)
    ->where(function($q) use ($bakerMe) {
        $q->where('baker_id', auth()->id());
        if ($bakerMe) {
            $q->orWhere('baker_id', $bakerMe->id);
        }
    })
    ->first();
    $daysLeft = (int) now()->diffInDays($request->delivery_date, false);

    // Build spec rows so we can compute borders correctly
    $specRows = [];
    if (!empty($config['flavor']))   $specRows[] = ['label' => 'Flavor',   'value' => $config['flavor'],   'accent' => false];
    if (!empty($config['shape']))    $specRows[] = ['label' => 'Shape',    'value' => $config['shape'],    'accent' => false];
    if (!empty($config['size']))     $specRows[] = ['label' => 'Size',     'value' => $config['size'],     'accent' => false];
    if (!empty($config['layers']))   $specRows[] = ['label' => 'Layers',   'value' => $config['layers'],   'accent' => false];
    if (!empty($config['frosting'])) $specRows[] = ['label' => 'Frosting', 'value' => $config['frosting'], 'accent' => false];
    // Delivery date always appears
    $specRows[] = ['label' => 'Delivery Date', 'value' => '__delivery__', 'accent' => true];

    $totalSpec = count($specRows);
    // If total is odd, last item spans... but we keep 2-col, so last item if odd has no right border
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
                <span class="urgency-badge high">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Rush — Accept Now
                </span>
            @elseif($daysLeft <= 3)
                <span class="urgency-badge high">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    Urgent — {{ $daysLeft }}d left
                </span>
            @else
                <span class="urgency-badge normal">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $daysLeft }} days left
                </span>
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
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>
                    Cake Specifications
                </span>
            </div>
            <div class="spec-grid">
                @foreach($specRows as $idx => $spec)
                    @php
                        $col       = $idx % 2;           // 0 = left, 1 = right
                        $isRight   = ($col === 1);
                        // Last row: items in last 1 or 2 positions
                        $isLastRow = ($idx >= $totalSpec - 2 && $totalSpec % 2 === 0)
                                  || ($idx === $totalSpec - 1);
                        $noRight   = $isRight ? 'no-right' : '';
                        $noBottom  = $isLastRow ? 'no-bottom' : '';
                    @endphp
                    <div class="spec-item {{ $noRight }} {{ $noBottom }}">
                        <div class="spec-label">{{ $spec['label'] }}</div>
                        @if($spec['value'] === '__delivery__')
                            <div class="spec-value accent">
                                {{ $request->delivery_date->format('F d, Y') }}
                                @if($request->needed_time)
                                    <div style="font-size:0.72rem;color:var(--caramel);margin-top:0.15rem;display:flex;align-items:center;gap:0.25rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ \Carbon\Carbon::parse($request->needed_time)->format('g:i A') }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="spec-value {{ $spec['accent'] ? 'accent' : '' }}">{{ $spec['value'] }}</div>
                        @endif
                    </div>
                @endforeach

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
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Customer Notes
                </span>
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
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>
                    3D Cake Preview
                </span>
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
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Delivery Location
                </span>
            </div>
            <div style="padding:1rem 1.5rem;">
                @if($request->hasMapLocation())
                <div id="delivery-map" style="height:240px;border-radius:10px;overflow:hidden;margin-bottom:0.75rem;"></div>
                @else
                <div class="map-placeholder" style="border-radius:10px;margin-bottom:0.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
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

        {{-- All Bids --}}
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    All Bids
                </span>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 0.5rem;opacity:0.4;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Be the first to bid!
            </div>
            @endforelse
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="sidebar-sticky">

        <div class="section-card">
            <div class="budget-display">
                <div class="budget-display-label">{{ $myBid ? 'Your Bid' : 'Estimated Price' }}</div>
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
                <div style="font-size:1.1rem;font-weight:800;margin-bottom:0.25rem;display:flex;align-items:center;gap:0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Rush Order
                </div>
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
                        style="width:100%;padding:0.85rem;background:linear-gradient(135deg,#C8893A,#E8A94A);color:white;border:none;border-radius:10px;font-family:inherit;font-size:0.9rem;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(200,137,58,0.4);display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Submit Rush Bid
                    </button>
                </form>
                <div id="rush-confirm-backdrop" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(20,10,4,0.75);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:1rem;">
                    <div style="background:#FFFDF9;border-radius:24px;max-width:380px;width:100%;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,0.3);">
                        <div style="background:linear-gradient(135deg,#1A0A00,#5C3010);padding:2rem;text-align:center;color:white;">
                            <div style="font-size:2rem;margin-bottom:0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            </div>
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
                                <button onclick="submitRushAccept(this)" style="flex:2;padding:0.75rem;border-radius:12px;border:none;background:linear-gradient(135deg,#C8893A,#E8A94A);color:white;font-size:0.85rem;font-weight:700;cursor:pointer;font-family:inherit;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-2px;margin-right:0.2rem;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                    Submit My Bid
                                </button>
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
                <div style="margin-top:0.85rem;text-align:center;font-size:0.7rem;opacity:0.5;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-1px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Expires in: <span id="rush-exp-timer">--</span>
                </div>
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
            @endif {{-- closes @if($request->status === 'RUSH_MATCHING' && !$myBid) --}}

          @if($myBid)
            {{-- ── ALREADY BID ── --}}
            <div style="padding:1.25rem;">
                @if($request->status === 'RUSH_MATCHING')
                @php
                    $bakerRecordRush = \App\Models\Baker::where('user_id', auth()->id())->first();
                    $rushFeeDisplay  = (float)($bakerRecordRush?->rush_fee ?? 0);
                    $baseDisplay     = $myBid->amount - $rushFeeDisplay;
                @endphp
                <div style="background:linear-gradient(135deg,#1A0A00,#2E1508);border-radius:10px;padding:0.85rem 1rem;margin-bottom:1rem;border:1px solid rgba(200,137,58,0.3);">
                    <div style="font-size:0.62rem;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.4);font-weight:700;margin-bottom:0.6rem;display:flex;align-items:center;gap:0.3rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Your Rush Bid Breakdown
                    </div>
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
                <div style="background:#FEF9E8;border:1px solid #F0D090;border-radius:8px;padding:0.6rem 0.85rem;font-size:0.72rem;color:#8A5010;line-height:1.5;margin-bottom:1rem;display:flex;align-items:flex-start;gap:0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Customer has <strong>60 seconds</strong> to accept your bid. If no one is chosen in time, the system auto-assigns the nearest baker with the best price.
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
                @if(strtoupper($myBid->status) === 'PENDING')
                <form method="POST" action="{{ route('baker.bids.destroy', $myBid->id) }}" id="withdraw-bid-form">
                    @csrf @method('DELETE')
                </form>
                <button type="button" class="btn-danger" onclick="openWithdrawModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Withdraw Bid
                </button>
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
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-1px;margin-right:0.2rem;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Rush Fee (₱)
                        </label>
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
                                  placeholder="Enter notes or comments…">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        Submit Bid
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Quick info card --}}
        <div class="section-card" style="margin-top:1rem;">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 9.4l-9-5.19"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    Order Info
                </span>
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
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Reference Image
                </span>
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

{{-- ── WITHDRAW MODAL (only rendered when $myBid exists) ── --}}
@if($myBid)
<div id="withdraw-modal" style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;padding:1rem;opacity:0;pointer-events:none;transition:opacity 0.25s ease;">
    <div style="position:absolute;inset:0;background:rgba(20,10,4,0.7);backdrop-filter:blur(5px);"></div>
    <div id="withdraw-modal-inner" style="position:relative;background:#FFFDF9;border-radius:24px;width:100%;max-width:380px;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,0.3);transform:translateY(24px) scale(0.96);transition:transform 0.3s cubic-bezier(0.34,1.56,0.64,1);">
        <div style="background:linear-gradient(135deg,#5A1A1A,#8B2E2E);padding:2rem;text-align:center;">
            <div style="width:56px;height:56px;border-radius:50%;background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </div>
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.2rem;font-weight:800;color:white;margin-bottom:0.3rem;">Withdraw Your Bid?</div>
            <div style="font-size:0.78rem;color:rgba(255,255,255,0.55);">This cannot be undone</div>
        </div>
        <div style="padding:1.5rem 2rem;">
            <div style="background:#F5EFE6;border:1px solid #EAE0D0;border-radius:14px;padding:1rem 1.25rem;margin-bottom:1.25rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.82rem;padding:0.3rem 0;">
                    <span style="color:#9A7A5A;font-weight:600;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.08em;">Request</span>
                    <span style="font-weight:700;color:#3B1F0F;">#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.82rem;padding:0.3rem 0;border-top:1px solid #EAE0D0;margin-top:0.35rem;padding-top:0.5rem;">
                    <span style="color:#9A7A5A;font-weight:600;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.08em;">Your Bid</span>
                    <span style="font-weight:700;color:#3B1F0F;">₱{{ number_format($myBid->amount, 0) }}</span>
                </div>
            </div>
            <p style="font-size:0.76rem;color:#9A7A5A;line-height:1.6;text-align:center;margin:0 0 1.25rem;">Withdrawing removes your bid from this request. You can place a new bid if it's still open.</p>
            <div style="display:flex;gap:0.75rem;">
                <button onclick="closeWithdrawModal()" style="flex:1;padding:0.75rem;border-radius:12px;border:1.5px solid #EAE0D0;background:white;color:#6B4A2A;font-size:0.85rem;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:background 0.15s;">Keep Bid</button>
                <button onclick="confirmWithdraw(this)" style="flex:2;padding:0.75rem;border-radius:12px;border:none;background:linear-gradient(135deg,#8B2A1E,#C44030);color:white;font-size:0.85rem;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 4px 14px rgba(139,42,30,0.35);transition:opacity 0.15s;display:flex;align-items:center;justify-content:center;gap:0.35rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Yes, Withdraw
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openWithdrawModal() {
    const modal = document.getElementById('withdraw-modal');
    const inner = document.getElementById('withdraw-modal-inner');
    modal.style.pointerEvents = 'all';
    modal.style.opacity = '1';
    inner.style.transform = 'translateY(0) scale(1)';
    document.body.style.overflow = 'hidden';
}
function closeWithdrawModal() {
    const modal = document.getElementById('withdraw-modal');
    const inner = document.getElementById('withdraw-modal-inner');
    modal.style.opacity = '0';
    inner.style.transform = 'translateY(24px) scale(0.96)';
    modal.style.pointerEvents = 'none';
    document.body.style.overflow = '';
}
function confirmWithdraw(btn) {
    btn.textContent = 'Withdrawing…';
    btn.disabled = true;
    document.getElementById('withdraw-bid-form').submit();
}
document.getElementById('withdraw-modal').addEventListener('click', function(e) {
    if (e.target === this) closeWithdrawModal();
});
</script>
@endif {{-- end @if($myBid) for withdraw modal --}}

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