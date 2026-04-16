@extends('layouts.baker')
@section('title', 'Active Orders')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

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

.page-title    { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; font-weight:800; color:var(--brown-deep); margin-bottom:0.25rem; }
.page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem; }
.section-heading {
        font-family:'Plus Jakarta Sans',sans-serif; font-size:1.1rem; font-weight:800; color:var(--brown-deep);
        margin:2rem 0 1rem; display:flex; align-items:center; gap:0.65rem;
    }
    .section-count {
        display:inline-flex; align-items:center; padding:0.15rem 0.6rem;
        border-radius:20px; font-size:0.7rem; font-weight:700;
        background:var(--caramel); color:white; font-family:'DM Sans',sans-serif;
    }
    .section-count.cancelled { background:#8B2A1E; }

    .orders-grid { display:grid; gap:1.25rem; }

    .order-card {
        background:var(--warm-white); border:1px solid var(--border);
        border-radius:16px; overflow:visible;
        transition:transform 0.2s, box-shadow 0.2s;
    }
    .order-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-lg); }
    .order-card.is-cancelled {
        border-color:#F5C5BE; opacity:0.85;
        background: linear-gradient(180deg, #FFFDF9 0%, #FDF5F3 100%);
    }
    .order-card.is-cancelled:hover { transform:none; box-shadow:none; }

    .order-card-top {
        padding:1.25rem 1.5rem; display:flex; align-items:center;
        justify-content:space-between; border-bottom:1px solid var(--border);
    }
    .order-card.is-cancelled .order-card-top { border-bottom-color:#F5C5BE; }

    .order-id       { font-size:0.85rem; font-weight:700; color:var(--caramel); }
    .order-customer { font-size:0.82rem; color:var(--text-muted); }

    .order-body { display:grid; grid-template-columns:1fr auto; gap:1.5rem; padding:1.25rem 1.5rem; }
  .order-cake-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.05rem; font-weight:700; color:var(--brown-deep); margin-bottom:0.6rem; }
    .order-meta { display:flex; flex-wrap:wrap; gap:0.5rem; margin-bottom:0.85rem; }
    .order-meta-tag {
        padding:0.2rem 0.6rem; background:var(--cream); border:1px solid var(--border);
        border-radius:8px; font-size:0.7rem; color:var(--text-muted); font-weight:600;
    }
    .order-delivery { font-size:0.78rem; color:var(--text-mid); }
    .order-delivery strong { color:var(--brown-deep); }

    .order-amount       { text-align:right; }
.order-amount-val   { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.4rem; font-weight:800; color:var(--brown-deep); }
    .order-amount-label { font-size:0.68rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.08em; }

    /* STATUS BADGE */
    .status-badge {
        display:inline-flex; align-items:center; gap:0.35rem;
        padding:0.3rem 0.8rem; border-radius:20px;
        font-size:0.72rem; font-weight:700;
    }
    .status-badge.active   { background:#FBF3E8; color:#7A3A10; border:1px solid #EDD090; }
    .status-badge.cancelled{ background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
    .status-badge.done     { background:#EBF5EE; color:#166534; border:1px solid #B8DFC6; }

    .progress-section { padding: 0 1.5rem 2.5rem; }

    .progress-track { position: relative; display: flex; align-items: center; }

    .progress-step {
        display: flex;
        align-items: center;
        flex: 1;
        position: relative;
    }
    .progress-step:last-child { flex: 0 0 auto; }

    .progress-line { flex: 1; height: 2px; }
    .progress-line.line-done      { background: var(--caramel); }
    .progress-line.line-pending   { background: var(--border); }
    .progress-line.line-cancelled { background: #F5C5BE; }

    .step-dot {
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700; flex-shrink: 0;
        position: relative; z-index: 1; transition: all 0.3s;
    }
    .step-dot.done         { background: var(--caramel); color: white; }
    .step-dot.active       { background: white; border: 2.5px solid var(--caramel); color: var(--caramel); animation: step-pulse 2s ease-in-out infinite; }
    .step-dot.pending      { background: var(--cream); border: 2px solid var(--border); color: var(--text-muted); }
    .step-dot.cancelled-dot{ background: #F5C5BE; border: 2px solid #F5C5BE; color: #8B2A1E; }

    .step-label {
        position: absolute;
        top: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.6rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.06em;
        color: var(--text-muted); white-space: nowrap;
        line-height: 1.3; text-align: center;
    }
    .progress-step:first-child .step-label { left: 0; transform: none; }
    .progress-step:last-child  .step-label { left: auto; right: 0; transform: none; }
    .step-label.active-label { color: var(--caramel); }

    @keyframes step-pulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(200,137,58,0.4); }
        50%      { box-shadow: 0 0 0 6px rgba(200,137,58,0); }
    }

    /* CANCELLATION REASON BOX */
    .cancel-reason-box {
        margin: 0 1.5rem 1rem;
        padding: 0.75rem 1rem;
        background: #FDF0EE; border: 1.5px solid #F5C5BE; border-radius: 10px;
        display: flex; align-items: flex-start; gap: 0.6rem;
        font-size: 0.78rem; color: #5A1A1A; line-height: 1.5;
    }
    .cancel-reason-box .cr-label {
        font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em;
        color: #8B2A1E; font-weight: 700; margin-bottom: 0.2rem;
    }

    /* ACTIONS */
    .order-actions {
        padding:1rem 1.5rem; border-top:1px solid var(--border);
        display:flex; align-items:center; justify-content:space-between;
        background:var(--cream); border-radius: 0 0 16px 16px;
    }
    .order-card.is-cancelled .order-actions {
        background:#FDF5F3; border-top-color:#F5C5BE;
    }

    .btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.2rem; border-radius:10px; font-size:0.82rem; font-weight:600; cursor:pointer; border:none; transition:all 0.2s; text-decoration:none; }
    .btn-primary { background:var(--caramel); color:white; box-shadow:0 4px 12px rgba(200,137,58,0.3); }
    .btn-primary:hover { background:var(--caramel-light); color:white; }
    .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--text-mid); }
    .btn-outline:hover { border-color:var(--caramel); color:var(--caramel); }
    .btn-report { background:#FDF0EE; color:#8B2A1E; border:1.5px solid #F5C5BE; font-size:0.78rem; }
    .btn-report:hover { background:#F5C5BE; color:#5A1A1A; }

    .days-left-badge { display:inline-flex; align-items:center; gap:0.3rem; padding:0.3rem 0.75rem; border-radius:20px; font-size:0.72rem; font-weight:700; }
    .days-left-badge.urgent { background:#F8EDEA; color:#8B2A1E; border:1px solid #DDB5A8; }
    .days-left-badge.ok     { background:#FBF3E8; color:#7A3A10; border:1px solid #EDD090; }

    .empty-state { padding:4rem 2rem; text-align:center; color:var(--text-muted); background:var(--warm-white); border:1px solid var(--border); border-radius:16px; }
    .empty-state .emoji { font-size:3rem; margin-bottom:1rem; }
    .empty-state h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.2rem; font-weight:800; color:var(--brown-mid); margin-bottom:0.5rem; }

    .section-divider { border:none; border-top:2px dashed var(--border); margin:2rem 0 0; }
</style>
@endpush

@section('content')

<h1 class="page-title">My Orders</h1>
<p class="page-subtitle">Track and manage all your cake orders</p>

@php
$statusSteps = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED'];

$activeOrders    = $orders->whereNotIn('status', ['CANCELLED','COMPLETED','DELIVERED']);
$completedOrders = $orders->whereIn('status', ['COMPLETED','DELIVERED']);
$cancelledOrders = $orders->where('status', 'CANCELLED');
@endphp

{{-- ════════════════ ACTIVE ORDERS ════════════════ --}}
@if($activeOrders->count())
<div class="section-heading">
    ⚡ Active Orders
    <span class="section-count">{{ $activeOrders->count() }}</span>
</div>
<div class="orders-grid">
    @foreach($activeOrders as $order)
    @php
        $config = is_array($order->cakeRequest->cake_configuration)
            ? $order->cakeRequest->cake_configuration
            : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);
        $currentStep = array_search($order->status, $statusSteps);
        if ($currentStep === false) $currentStep = 0;
        $daysLeft  = (int) now()->startOfDay()->diffInDays($order->cakeRequest->delivery_date->startOfDay(), false);
        $isPickup  = $order->cakeRequest->isPickup();
        $isRush    = $order->cakeRequest->is_rush;
        $stepLabels = ['Accepted', 'Awaiting Down', 'Preparing', 'Ready',
            $isPickup ? 'Pickup Pay' : 'Awaiting Final',
            $isPickup ? 'Collected'  : 'Delivered'];
        $stepIcons  = ['✓', '💳', '🥣', '📦',
            $isPickup ? '🏪' : '💰',
            $isPickup ? '🏪' : '🚚'];
    @endphp
    <div class="order-card">
        <div class="order-card-top">
            <div>
                <span class="order-id">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                <span class="order-customer" style="margin-left:0.75rem;">Customer: {{ $order->cakeRequest->user->first_name }}</span>
            </div>
            <div style="display:flex; gap:0.6rem; align-items:center;">
                <span class="status-badge active">● {{ str_replace('_',' ',$order->status) }}</span>
                <span class="days-left-badge {{ $daysLeft <= 2 ? 'urgent' : 'ok' }}">
                    {{ $daysLeft <= 2 ? '🔥 ' : '📅 ' }}{{ $daysLeft }}d left
                </span>
            </div>
        </div>

        <div class="order-body">
            <div>
                <div class="order-cake-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                <div class="order-meta">
                    @if(!empty($config['size']))     <span class="order-meta-tag">{{ $config['size'] }}</span>     @endif
                    @if(!empty($config['frosting'])) <span class="order-meta-tag">{{ $config['frosting'] }}</span> @endif
                </div>
                <div class="order-delivery">Deliver by: <strong>{{ $order->cakeRequest->delivery_date->format('F d, Y') }}</strong></div>
            </div>
            <div class="order-amount">
                <div class="order-amount-label">Agreed Price</div>
                <div class="order-amount-val">₱{{ number_format($order->agreed_price, 0) }}</div>
            </div>
        </div>

        <div class="progress-section">
            <div class="progress-track">
                @foreach($statusSteps as $i => $step)
                <div class="progress-step">
                    <div class="step-dot {{ $i < $currentStep ? 'done' : ($i == $currentStep ? 'active' : 'pending') }}">
                        {{ $i < $currentStep ? '✓' : $stepIcons[$i] }}
                        <span class="step-label {{ $i == $currentStep ? 'active-label' : '' }}">{{ $stepLabels[$i] }}</span>
                    </div>
                    @if($i < count($statusSteps) - 1)
                        <div class="progress-line {{ $i < $currentStep ? 'line-done' : 'line-pending' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="order-actions">
            <a href="{{ route('baker.orders.show', $order->id) }}" class="btn btn-outline">View Details</a>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ════════════════ COMPLETED ORDERS ════════════════ --}}
@if($completedOrders->count())
<div class="section-heading" style="margin-top:2.5rem;">
    🎉 Completed Orders
    <span class="section-count" style="background:#166534;">{{ $completedOrders->count() }}</span>
</div>
<div class="orders-grid">
    @foreach($completedOrders as $order)
    @php
        $config = is_array($order->cakeRequest->cake_configuration)
            ? $order->cakeRequest->cake_configuration
            : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);
    @endphp
    <div class="order-card">
        <div class="order-card-top">
            <div>
                <span class="order-id">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                <span class="order-customer" style="margin-left:0.75rem;">Customer: {{ $order->cakeRequest->user->first_name }}</span>
            </div>
            <span class="status-badge done">✓ Completed</span>
        </div>
        <div class="order-body">
            <div>
                <div class="order-cake-name">{{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}</div>
                <div class="order-delivery">Delivered: <strong>{{ $order->cakeRequest->delivery_date->format('F d, Y') }}</strong></div>
            </div>
            <div class="order-amount">
                <div class="order-amount-label">Earned</div>
                <div class="order-amount-val" style="color:#166534;">₱{{ number_format($order->agreed_price, 0) }}</div>
            </div>
        </div>
        <div class="order-actions">
            <a href="{{ route('baker.orders.show', $order->id) }}" class="btn btn-outline">View Details</a>
            <a href="{{ route('report.create', $order->id) }}" class="btn btn-report">⚠ Report Customer</a>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ════════════════ CANCELLED ORDERS ════════════════ --}}
@if($cancelledOrders->count())
<hr class="section-divider">
<div class="section-heading" style="margin-top:1.5rem; color:#8B2A1E;">
    ❌ Cancelled Orders
    <span class="section-count cancelled">{{ $cancelledOrders->count() }}</span>
</div>
<div class="orders-grid">
    @foreach($cancelledOrders as $order)
    @php
        $config = is_array($order->cakeRequest->cake_configuration)
            ? $order->cakeRequest->cake_configuration
            : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);
        $currentStep = array_search($order->status, $statusSteps);
        if ($currentStep === false) $currentStep = 0;
        $isPickup   = $order->cakeRequest->isPickup();
        $stepLabels = ['Accepted', 'Awaiting Down', 'Preparing', 'Ready',
            $isPickup ? 'Pickup Pay' : 'Awaiting Final',
            $isPickup ? 'Collected'  : 'Delivered'];
        $stepIcons  = ['✓', '💳', '🥣', '📦',
            $isPickup ? '🏪' : '💰',
            $isPickup ? '🏪' : '🚚'];
    @endphp
    <div class="order-card is-cancelled">
        <div class="order-card-top">
            <div>
                <span class="order-id" style="color:#8B2A1E;">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                <span class="order-customer" style="margin-left:0.75rem;">Customer: {{ $order->cakeRequest->user->first_name }}</span>
            </div>
            <div style="display:flex; gap:0.6rem; align-items:center;">
                <span class="status-badge cancelled">✕ Cancelled</span>
                @if($order->cancelled_at)
                <span style="font-size:0.72rem; color:var(--text-muted);">{{ $order->cancelled_at->format('M d, Y') }}</span>
                @endif
            </div>
        </div>

        <div class="order-body">
            <div>
                <div class="order-cake-name" style="color:#8B2A1E; opacity:0.8;">
                    {{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}
                </div>
                <div class="order-meta">
                    @if(!empty($config['size']))     <span class="order-meta-tag">{{ $config['size'] }}</span>     @endif
                    @if(!empty($config['frosting'])) <span class="order-meta-tag">{{ $config['frosting'] }}</span> @endif
                </div>
                <div class="order-delivery">Was due: <strong>{{ $order->cakeRequest->delivery_date->format('F d, Y') }}</strong></div>
            </div>
            <div class="order-amount">
                <div class="order-amount-label">Order Value</div>
                <div class="order-amount-val" style="color:#8B2A1E; text-decoration:line-through; opacity:0.6;">
                    ₱{{ number_format($order->agreed_price, 0) }}
                </div>
            </div>
        </div>

        @if($order->cancel_reason)
        <div class="cancel-reason-box">
            <span>⚠️</span>
            <div>
                <div class="cr-label">Cancellation Reason</div>
                {{ $order->cancel_reason }}
            </div>
        </div>
        @else
        @php
            $downpayment  = \App\Models\Payment::where('cake_request_id', $order->cake_request_id)->where('payment_type', 'downpayment')->first();
            $finalPayment = \App\Models\Payment::where('cake_request_id', $order->cake_request_id)->where('payment_type', 'final')->first();
            $wasAutoCancel = ($downpayment?->rejection_count >= 2) || ($finalPayment?->rejection_count >= 2);
        @endphp
        @if($wasAutoCancel)
        <div class="cancel-reason-box">
            <span>🚫</span>
            <div>
                <div class="cr-label">Auto-Cancelled</div>
                This order was automatically cancelled after 2 rejected payment proofs.
            </div>
        </div>
        @endif
        @endif

        <div class="progress-section">
            <div class="progress-track">
                @foreach($statusSteps as $i => $step)
                <div class="progress-step">
                    <div class="step-dot {{ $i < $currentStep ? 'cancelled-dot' : 'pending' }}">
                        {{ $i < $currentStep ? '✓' : $stepIcons[$i] }}
                        <span class="step-label">{{ $stepLabels[$i] }}</span>
                    </div>
                    @if($i < count($statusSteps) - 1)
                        <div class="progress-line {{ $i < $currentStep ? 'line-cancelled' : 'line-pending' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="order-actions">
            <a href="{{ route('baker.orders.show', $order->id) }}" class="btn btn-outline">View Details</a>
            @php
                $alreadyReported = \App\Models\Report::where('reporter_id', auth()->id())
                    ->where('baker_order_id', $order->id)->exists();
            @endphp
            @if(!$alreadyReported)
            <a href="{{ route('report.create', $order->id) }}" class="btn btn-report">⚠ Report Customer</a>
            @else
            <span style="font-size:0.75rem; color:var(--text-muted); font-weight:600;">✓ Reported</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

@if($orders->isEmpty())
<div class="empty-state">
    <div class="emoji">📦</div>
    <h3>No orders yet</h3>
    <p>When a customer accepts your bid, your order will appear here.</p>
    <a href="{{ route('baker.requests.index') }}" style="display:inline-flex;margin-top:1.25rem;padding:0.7rem 1.4rem;background:var(--caramel);color:white;border-radius:10px;font-weight:600;font-size:0.875rem;text-decoration:none;">
        Browse Requests →
    </a>
</div>
@endif

@endsection