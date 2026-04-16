@extends('layouts.customer')
@section('title', 'Payment — #' . str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.payment-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0.5rem 1rem 1rem;  /* ← reduced top padding */
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.back-link {
    display: inline-flex; align-items: center; gap: 0.4rem;
    font-size: 0.82rem; color: var(--text-muted); text-decoration: none;
    margin-bottom: 1.25rem; transition: color 0.2s;
}
.back-link:hover { color: var(--caramel); }

/* ── HERO ── */
.pay-hero {
    border-radius: 20px;
    padding: 2rem 2.5rem;
    margin-bottom: 1.75rem;
    color: white;
    position: relative;
    overflow: hidden;
}
.pay-hero.type-downpayment { background: linear-gradient(135deg, #3B1A08 0%, #7A3B10 60%, #A0510F 100%); }
.pay-hero.type-final       { background: linear-gradient(135deg, #3B1A08 0%, #7A3B10 60%, #A0510F 100%); }
.pay-hero.type-done        { background: linear-gradient(135deg, #1B4D2E 0%, #2D7A4A 100%); }
.pay-hero::before {
    content: ''; position: absolute; right: -40px; top: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.pay-hero-label { font-size: 0.68rem; letter-spacing: 0.2em; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.4rem; }
.pay-hero-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; line-height: 1.1; margin-bottom: 0.25rem; position: relative; z-index: 1; font-weight: 800; }
.pay-hero-sub   { font-size: 0.82rem; opacity: 0.7; position: relative; z-index: 1; }

/* ── SPLIT PROGRESS BAR ── */
.split-bar {
    display: flex; border-radius: 12px; overflow: hidden;
    border: 1px solid var(--border); margin-bottom: 1.75rem;
}
.split-half { flex: 1; padding: 1rem 1.25rem; text-align: center; background: var(--warm-white); }
.split-half.active { background: #FEF3E8; border: 2px solid #C8862A; border-radius: 12px; }
.split-half.done   { background: #EFF5EF; }
.split-half.locked { background: #F8F8F8; }
.split-divider { width: 1px; background: var(--border); }
.split-label  { font-size: 0.62rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); }
.split-amount { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.3rem; color: var(--brown-deep); margin: 0.2rem 0; font-weight: 800; }.split-status { font-size: 0.72rem; font-weight: 600; }
.split-status.done   { color: #22c55e; }
.split-status.active { color: #c8862a; }
.split-status.locked { color: #aaa; }

/* ── ALERT BOX ── */
.alert-box {
    display: flex; align-items: flex-start; gap: 0.85rem;
    border-radius: 14px; padding: 1rem 1.25rem;
    margin-bottom: 1.5rem; font-size: 0.84rem;
}
.alert-box.success { background: #EFF5EF; border: 1px solid #BFDFBE; color: #1B4D2E; }
.alert-box.warning { background: #FEF9E8; border: 1px solid #F0D090; color: #8A5010; }
.alert-box.info    { background: #EBF3FE; border: 1px solid #BEDAF5; color: #1A3A6B; }
.alert-icon  { font-size: 1.3rem; flex-shrink: 0; }
.alert-title { font-weight: 700; margin-bottom: 0.2rem; }
.alert-sub   { font-size: 0.78rem; opacity: 0.85; line-height: 1.5; }

/* ── TWO COLUMN LAYOUT ── */
.payment-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.75rem;
    align-items: start;
}

/* ── PROOF SUBMITTED STATE ── */
.proof-submitted-card {
    background: var(--warm-white); border: 1.5px solid #F0D090;
    border-radius: 16px; overflow: hidden; margin-bottom: 1.5rem;
}
.proof-submitted-header {
    background: #FEF9E8; padding: 1rem 1.5rem;
    border-bottom: 1px solid #F0E0A0;
    display: flex; align-items: center; gap: 0.75rem;
}
.proof-submitted-body { padding: 1.25rem 1.5rem; }
.proof-img {
    width: 100%; border-radius: 10px; border: 1px solid var(--border);
    max-height: 300px; object-fit: contain; background: #f5f5f5;
}
.proof-meta { margin-top: 0.75rem; font-size: 0.78rem; color: var(--text-muted); display: flex; gap: 1rem; flex-wrap: wrap; }
.proof-meta span { display: flex; align-items: center; gap: 0.3rem; }

/* ── PAYMENT METHODS CARD ── */
.methods-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 20px; overflow: hidden; margin-bottom: 0;
}
.methods-header {
    padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 0.75rem;
}
.methods-header-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #c8862a, #e8a94a);
    border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.methods-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem; color: var(--brown-deep); font-weight: 700; }.methods-sub   { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.1rem; }

/* Tabs */
.method-tabs { display: flex; border-bottom: 1px solid var(--border); }
.method-tab {
    flex: 1; padding: 0.75rem 1rem; font-size: 0.8rem; font-weight: 600;
    text-align: center; cursor: pointer; border-bottom: 2.5px solid transparent;
    color: var(--text-muted); transition: all 0.2s;
    background: none; border-top: none; border-left: none; border-right: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.method-tab.active { border-bottom-color: var(--caramel); color: var(--caramel); }
.method-panel { display: none; padding: 1.5rem; }
.method-panel.active { display: block; }

/* QR timer */
.qr-timer-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
.qr-timer-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.3rem 0.75rem; border-radius: 20px;
    font-size: 0.75rem; font-weight: 700; border: 1.5px solid; transition: all 0.5s;
}
.qr-timer-badge.green  { background: #EFF5EF; color: #1B4D2E; border-color: #C3E6C5; }
.qr-timer-badge.yellow { background: #FEF9E8; color: #8A5010; border-color: #F0D090; }
.qr-timer-badge.red    { background: #FDF0EE; color: #8B2A1E; border-color: #F5C5BE; }
/* ── QR ZOOM MODAL ── */
.qr-modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,0.75); backdrop-filter: blur(4px);
    align-items: center; justify-content: center; flex-direction: column; gap: 1rem;
}
.qr-modal-overlay.show { display: flex; }
.qr-modal-img {
    max-width: 90vw; max-height: 80vh; border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5); cursor: zoom-out;
}
.qr-modal-actions {
    display: flex; gap: 0.75rem; align-items: center;
}
.qr-modal-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.6rem 1.25rem; border-radius: 10px; font-size: 0.82rem;
    font-weight: 700; cursor: pointer; border: none;font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.qr-modal-btn.download {
    background: linear-gradient(135deg, #c8862a, #e8a94a);
    color: white; box-shadow: 0 4px 12px rgba(200,134,42,0.4);
}
.qr-modal-btn.download:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(200,134,42,0.5); }
.qr-modal-btn.close-btn {
    background: rgba(255,255,255,0.15); color: white;
    border: 1.5px solid rgba(255,255,255,0.3);
}
.qr-modal-btn.close-btn:hover { background: rgba(255,255,255,0.25); }
.qr-modal-hint { font-size: 0.72rem; color: rgba(255,255,255,0.5); }

/* ── HOW TO PAY STEPS ── */
.how-to-pay {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 20px; overflow: hidden; margin-top: 1.25rem;
}
.how-to-pay-header {
    padding: 0.9rem 1.5rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 0.6rem;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9rem;
    color: var(--brown-deep); font-weight: 700;
}
.how-to-pay-body { padding: 1.25rem 1.5rem; }
.step-list { display: flex; flex-direction: column; gap: 0.75rem; }
.step-item {
    display: flex; align-items: flex-start; gap: 0.75rem;
}
.step-num {
    width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #c8862a, #e8a94a);
    color: white; font-size: 0.7rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    margin-top: 0.05rem;
}
.step-text { font-size: 0.8rem; color: var(--text-mid, #555); line-height: 1.5; }
.step-text strong { color: var(--brown-deep); }

/* ── QR clickable cursor ── */
.qr-img { cursor: zoom-in; }
.qr-img-wrap { position: relative; display: inline-block; width: 100%; text-align: center; }
.qr-img { width: 220px; height: auto; border-radius: 12px; border: 1px solid var(--border); transition: filter 0.4s; }

.qr-img.expired { filter: blur(6px) grayscale(1); opacity: 0.5; }
.qr-expired-overlay {
    position: absolute; inset: 0; display: none;
    align-items: center; justify-content: center; flex-direction: column; gap: 0.5rem;
}
.qr-expired-overlay.show { display: flex; }
.qr-expired-text { font-weight: 700; font-size: 0.85rem; color: #8B2A1E; background: white; padding: 0.4rem 0.9rem; border-radius: 8px; border: 1.5px solid #F5C5BE; }

.account-detail {
    background: var(--cream, #F5EFE4); border-radius: 12px;
    padding: 1rem 1.25rem; margin: 1rem 0; font-size: 0.86rem;
}
.account-detail .detail-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
.account-detail .detail-row:last-child { margin-bottom: 0; }
.detail-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600; }
.detail-value { font-weight: 700; color: var(--brown-deep); font-size: 0.9rem; }

/* ── UPLOAD FORM ── */
.upload-form-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 20px; overflow: hidden; margin-bottom: 0;
}
.upload-form-header {
    padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem;
    color: var(--brown-deep); font-weight: 700;
}
.upload-form-body { padding: 1.5rem; }

.form-group { margin-bottom: 1.25rem; }
.form-label { display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 0.5rem; }

.upload-zone {
    border: 2px dashed var(--border); border-radius: 12px; padding: 2rem;
    text-align: center; cursor: pointer; transition: all 0.2s;
    background: var(--cream, #F5EFE4);
}
.upload-zone:hover { border-color: var(--caramel); background: #FEF9E8; }
.upload-zone input { display: none; }
.upload-zone-icon { font-size: 2rem; margin-bottom: 0.5rem; display: block; }
.upload-zone-text { font-size: 0.82rem; color: var(--text-muted); }
.upload-zone-text strong { color: var(--caramel); }
.upload-preview { display: none; margin-top: 1rem; }
.upload-preview img { max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid var(--border); }

.btn-submit {
    width: 100%; padding: 0.875rem;
    background: linear-gradient(135deg, #c8862a, #e8a94a);
    color: white; border: none; border-radius: 12px;
    font-size: 0.95rem; font-weight: 700; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(200,134,42,0.35); transition: all 0.2s;
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(200,134,42,0.45); }

.refresh-btn {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.45rem 1rem; background: var(--cream, #F5EFE4);
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: 0.78rem; font-weight: 600; color: var(--text-mid);
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.2s;
}
.refresh-btn:hover { border-color: var(--caramel); color: var(--caramel); }

.no-methods-notice { padding: 2.5rem 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; }

/* ── ALL PAID STATE ── */
.all-paid-banner {
    background: linear-gradient(135deg, #1B4D2E, #2D7A4A);
    border-radius: 20px; padding: 2.5rem; text-align: center;
    color: white; margin-bottom: 1.5rem;
}
.all-paid-banner .big-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
.all-paid-banner h2 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; margin: 0 0 0.5rem; font-weight: 800; }
.all-paid-banner p { opacity: 0.75; font-size: 0.85rem; margin: 0; }

@media (max-width: 960px) {
    .payment-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .payment-wrap { padding: 1rem; }
}
</style>
@endpush

@section('content')

@php
    $totalAmount       = $acceptedBid->amount;
    $downpaymentAmount = round($totalAmount * 0.5, 2);
    $finalAmount       = $totalAmount - $downpaymentAmount;

$downIsPaid      = $downpayment  && $downpayment->isPaid();
$finalIsPaid     = $finalPayment && $finalPayment->isPaid();
$downIsPending   = $downpayment  && $downpayment->status === 'pending';
$finalIsPending  = $finalPayment && $finalPayment->status === 'pending';
$downIsRejected  = $downpayment  && $downpayment->status === 'rejected';
$finalIsRejected = $finalPayment && $finalPayment->status === 'rejected';

    $allDone   = $downIsPaid && $finalIsPaid;
    $isPickup  = $cakeRequest->isPickup();
@endphp

<div class="payment-wrap">
    <a href="{{ route('customer.cake-requests.show', $cakeRequest->id) }}" class="back-link">← Back to Order Tracker</a>

    {{-- ── HERO ── --}}
    @if($allDone)
    <div class="pay-hero type-done">
        <div class="pay-hero-label">Request #{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div class="pay-hero-title">🎉 All Payments Complete!</div>
        <div class="pay-hero-sub">Both the downpayment and final payment have been confirmed.</div>
    </div>
    @elseif($activePaymentType === 'final')
    <div class="pay-hero type-final">
        <div class="pay-hero-label">Request #{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
      <div class="pay-hero-title">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round" style="vertical-align:middle; margin-right:0.4rem; opacity:0.9;">
        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
        <line x1="1" y1="10" x2="23" y2="10"></line>
    </svg>
    Final Payment
</div>
        <div class="pay-hero-sub">Your cake is ready! Pay the remaining 50% to receive delivery.</div>
    </div>
    @else
    <div class="pay-hero type-downpayment">
        <div class="pay-hero-label">Request #{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
<div class="pay-hero-title">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round" style="vertical-align:middle; margin-right:0.4rem; opacity:0.9;">
        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
        <line x1="1" y1="10" x2="23" y2="10"></line>
    </svg>
    Pay Downpayment
</div>


        <div class="pay-hero-sub">Send 50% now so your baker can begin baking your cake.</div>
    </div>
    @endif

    {{-- ── SPLIT PROGRESS BAR ── --}}
    <div class="split-bar">
        <div class="split-half {{ $downIsPaid ? 'done' : ($activePaymentType === 'downpayment' ? 'active' : '') }}">
            <div class="split-label">50% Downpayment</div>
            <div class="split-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
            @if($downIsPaid)
                <div class="split-status done">✓ Confirmed</div>
            @elseif($downIsPending)
                <div class="split-status active">⏳ Under Review</div>
            @elseif($activePaymentType === 'downpayment')
                <div class="split-status active">← Pay Now</div>
            @else
                <div class="split-status locked">Pending</div>
            @endif
        </div>
        <div class="split-divider"></div>
        <div class="split-half {{ $finalIsPaid ? 'done' : ($activePaymentType === 'final' ? 'active' : 'locked') }}">
            <div class="split-label">50% {{ $isPickup ? 'Cash on Pickup' : 'on Delivery' }}</div>
            <div class="split-amount">₱{{ number_format($finalAmount, 2) }}</div>
            @if($finalIsPaid)
                <div class="split-status done">✓ Confirmed</div>
            @elseif($finalIsPending)
                <div class="split-status active">⏳ Under Review</div>
            @elseif($isPickup && $downIsPaid)
                <div class="split-status active">💵 Cash on Pickup</div>
            @elseif($activePaymentType === 'final')
                <div class="split-status active">← Pay Now</div>
            @else
                <div class="split-status locked">🔒 {{ $isPickup ? 'Pay at Pickup' : 'After Downpayment' }}</div>
            @endif
        </div>
    </div>

    {{-- ── FLASH MESSAGES ── --}}
    @if(session('success'))
    <div class="alert-box success">
        <span class="alert-icon">✅</span>
        <div><div class="alert-title">Success!</div><div class="alert-sub">{{ session('success') }}</div></div>
    </div>
    @endif
    @if(session('error'))
    <div class="alert-box warning">
        <span class="alert-icon">⚠️</span>
        <div><div class="alert-title">Error</div><div class="alert-sub">{{ session('error') }}</div></div>
    </div>
    @endif

    {{-- ══════════════ STATE: ALL PAID ══════════════ --}}
    @if($allDone)
    <div class="all-paid-banner">
        <span class="big-icon">🎂</span>
        <h2>You're all paid up!</h2>
        <p>Downpayment + Final payment both confirmed. Enjoy your cake!</p>
    </div>

    {{-- ══════════════ STATE: DOWNPAYMENT PENDING ══════════════ --}}
    @elseif($downIsPending && $activePaymentType === 'downpayment')
    <div class="proof-submitted-card">
        <div class="proof-submitted-header">
            <span style="font-size:1.5rem;">⏳</span>
            <div>
              <div style="font-weight:700; color:#8A5010; font-size:0.9rem;">Proof Submitted — Awaiting Platform Verification</div>
                <div style="font-size:0.75rem; color:#B07030; margin-top:0.15rem;">Our team will verify your payment and hold it securely in escrow.</div>
            </div>
        </div>
        @if($downpayment->proof_of_payment_path)
        <div class="proof-submitted-body">
            <img src="{{ asset('storage/'.$downpayment->proof_of_payment_path) }}" class="proof-img" alt="Payment Proof">
            <div class="proof-meta">
                <span>📅 {{ $downpayment->paid_at?->format('M d, Y · g:i A') }}</span>
                @if($downpayment->payment_method)
                <span>💳 via {{ strtoupper($downpayment->payment_method) }}</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- ══════════════ STATE: FINAL PAYMENT PENDING ══════════════ --}}
    @elseif($finalIsPending && $activePaymentType === 'final')
    <div class="proof-submitted-card">
        <div class="proof-submitted-header">
            <span style="font-size:1.5rem;">⏳</span>
            <div>
             <div style="font-weight:700; color:#8A5010; font-size:0.9rem;">Final Payment Submitted — Awaiting Platform Verification</div>
                <div style="font-size:0.75rem; color:#B07030; margin-top:0.15rem;">Our team will verify and release funds to your baker once delivery is confirmed.</div>
            </div>
        </div>
        @if($finalPayment->proof_of_payment_path)
        <div class="proof-submitted-body">
            <img src="{{ asset('storage/'.$finalPayment->proof_of_payment_path) }}" class="proof-img" alt="Payment Proof">
            <div class="proof-meta">
                <span>📅 {{ $finalPayment->paid_at?->format('M d, Y · g:i A') }}</span>
                @if($finalPayment->payment_method)
                <span>💳 via {{ strtoupper($finalPayment->payment_method) }}</span>
                @endif
            </div>
        </div>
        @endif
    </div>
{{-- ══════════════ STATE: DOWNPAYMENT REJECTED ══════════════ --}}
@elseif($downIsRejected && $activePaymentType === 'downpayment')
<div style="background:#FDF0EE; border:1.5px solid #F5C5BE; border-radius:16px; overflow:hidden; margin-bottom:1.5rem;">
    <div style="background:#F9E0DC; padding:1rem 1.5rem; border-bottom:1px solid #F5C5BE; display:flex; align-items:center; gap:0.75rem;">
        <span style="font-size:1.5rem;">❌</span>
        <div>
            <div style="font-weight:700; color:#8B2A1E; font-size:0.9rem;">Downpayment Proof Rejected</div>
            <div style="font-size:0.75rem; color:#B04030; margin-top:0.15rem;">
                Your baker could not verify this payment. Please re-upload a valid receipt.
            </div>
        </div>
        @if($downpayment->rejection_count ?? false)
        <span style="margin-left:auto; font-size:0.75rem; font-weight:700; background:#F5C5BE; color:#8B2A1E; padding:0.25rem 0.6rem; border-radius:20px;">
            {{ $downpayment->rejection_count }}/2 rejections
        </span>
        @endif
    </div>
    <div style="padding:1.25rem 1.5rem;">
        @if($downpayment->rejection_reason)
        <div style="background:#FDF8F8; border:1px solid #F0C8C0; border-radius:10px; padding:0.85rem 1rem; margin-bottom:1rem; font-size:0.84rem; color:#7A2A1E;">
            <span style="font-weight:700;">Reason:</span> {{ $downpayment->rejection_reason }}
        </div>
        @endif

        @if(($downpayment->rejection_count ?? 0) >= 2)
        <div class="alert-box warning" style="margin-bottom:1rem;">
            <span class="alert-icon">⚠️</span>
            <div>
                <div class="alert-title">Final Warning</div>
                <div class="alert-sub">If this upload is rejected again, your order will be <strong>automatically cancelled</strong>. Please submit a valid, unedited payment receipt.</div>
            </div>
        </div>
        @else
        <div class="alert-box warning" style="margin-bottom:1rem;">
            <span class="alert-icon">⚠️</span>
            <div class="alert-sub">Please upload a clear, unedited screenshot of your payment confirmation.</div>
        </div>
        @endif

        <form method="POST"
              action="{{ route('customer.payment.reupload', $cakeRequest->id) }}"
              enctype="multipart/form-data">
            @csrf
       <input type="hidden" name="payment_type" value="downpayment">
            <div style="margin-bottom:0.75rem;">
                <label class="form-label" style="font-size:0.68rem;">Reference Number <span style="color:#C44030;">*</span></label>
                <input type="text" name="platform_reference" required placeholder="GCash/Maya reference number"
                       style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #F5C5BE; border-radius:8px; font-size:0.84rem; font-family:'Plus Jakarta Sans',sans-serif;">
            </div>
            <div class="upload-zone" onclick="document.getElementById('reupload-down').click()" style="margin-bottom:1rem;">
                <input type="file" id="reupload-down" name="proof" accept="image/*,.pdf"
                       onchange="previewReupload(this, 'reupload-down-preview', 'reupload-down-img')">
                <span class="upload-zone-icon">📎</span>
                <div class="upload-zone-text"><strong>Click to upload new proof</strong><br>JPG, PNG, or PDF · max 5MB</div>
                <div id="reupload-down-preview" style="display:none; margin-top:1rem;">
                    <img id="reupload-down-img" src="" style="max-width:100%; max-height:180px; border-radius:8px; border:1px solid var(--border);">
                </div>
            </div>
            <button type="submit" class="btn-submit">🔄 Re-submit Downpayment Proof</button>
        </form>
    </div>
</div>

{{-- ══════════════ STATE: FINAL PAYMENT REJECTED ══════════════ --}}
@elseif($finalIsRejected && $activePaymentType === 'final')
<div style="background:#FDF0EE; border:1.5px solid #F5C5BE; border-radius:16px; overflow:hidden; margin-bottom:1.5rem;">
    <div style="background:#F9E0DC; padding:1rem 1.5rem; border-bottom:1px solid #F5C5BE; display:flex; align-items:center; gap:0.75rem;">
        <span style="font-size:1.5rem;">❌</span>
        <div>
            <div style="font-weight:700; color:#8B2A1E; font-size:0.9rem;">Final Payment Proof Rejected</div>
            <div style="font-size:0.75rem; color:#B04030; margin-top:0.15rem;">
                Your baker could not verify this payment. Please re-upload a valid receipt.
            </div>
        </div>
        @if($finalPayment->rejection_count ?? false)
        <span style="margin-left:auto; font-size:0.75rem; font-weight:700; background:#F5C5BE; color:#8B2A1E; padding:0.25rem 0.6rem; border-radius:20px;">
            {{ $finalPayment->rejection_count }}/2 rejections
        </span>
        @endif
    </div>
    <div style="padding:1.25rem 1.5rem;">
        @if($finalPayment->rejection_reason)
        <div style="background:#FDF8F8; border:1px solid #F0C8C0; border-radius:10px; padding:0.85rem 1rem; margin-bottom:1rem; font-size:0.84rem; color:#7A2A1E;">
            <span style="font-weight:700;">Reason:</span> {{ $finalPayment->rejection_reason }}
        </div>
        @endif

        @if(($finalPayment->rejection_count ?? 0) >= 2)
        <div class="alert-box warning" style="margin-bottom:1rem;">
            <span class="alert-icon">⚠️</span>
            <div>
                <div class="alert-title">Final Warning</div>
                <div class="alert-sub">If this upload is rejected again, your order will be <strong>automatically cancelled</strong>. Please submit a valid, unedited payment receipt.</div>
            </div>
        </div>
        @else
        <div class="alert-box warning" style="margin-bottom:1rem;">
            <span class="alert-icon">⚠️</span>
            <div class="alert-sub">Please upload a clear, unedited screenshot of your payment confirmation.</div>
        </div>
        @endif

        <form method="POST"
              action="{{ route('customer.payment.reupload', $cakeRequest->id) }}"
              enctype="multipart/form-data">
            @csrf
        <input type="hidden" name="payment_type" value="final">
            <div style="margin-bottom:0.75rem;">
                <label class="form-label" style="font-size:0.68rem;">Reference Number <span style="color:#C44030;">*</span></label>
                <input type="text" name="platform_reference" required placeholder="GCash/Maya reference number"
                       style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #F5C5BE; border-radius:8px; font-size:0.84rem; font-family:'Plus Jakarta Sans',sans-serif;">
            </div>
            <div class="upload-zone" onclick="document.getElementById('reupload-final').click()" style="margin-bottom:1rem;">
                <input type="file" id="reupload-final" name="proof" accept="image/*,.pdf"
                       onchange="previewReupload(this, 'reupload-final-preview', 'reupload-final-img')">
                <span class="upload-zone-icon">📎</span>
                <div class="upload-zone-text"><strong>Click to upload new proof</strong><br>JPG, PNG, or PDF · max 5MB</div>
                <div id="reupload-final-preview" style="display:none; margin-top:1rem;">
                    <img id="reupload-final-img" src="" style="max-width:100%; max-height:180px; border-radius:8px; border:1px solid var(--border);">
                </div>
            </div>
            <button type="submit" class="btn-submit">🔄 Re-submit Final Payment Proof</button>
        </form>
    </div>
</div>
    {{-- ══════════════ STATE: SHOW PAYMENT METHODS + FORM ══════════════ --}}
    @else
    @php
        $currentAmount = $activePaymentType === 'final' ? $finalAmount : $downpaymentAmount;
    $gcashMethods  = collect($gcashAccount ? [$gcashAccount] : []);
    $mayaMethods   = collect($mayaAccount  ? [$mayaAccount]  : []);
    $cashMethods   = collect(); // escrow system — no cash except pickup handled by baker
    $hasQr         = $gcashAccount || $mayaAccount;
    $gcash         = $gcashAccount;
    $maya          = $mayaAccount;
    @endphp

  <div class="alert-box info" style="margin-bottom:1.25rem;">
        <span class="alert-icon">🔒</span>
        <div>
            <div class="alert-title">Secure Escrow Payment</div>
            <div class="alert-sub">Your payment goes to the <strong>BakeSphere platform account</strong> — not directly to the baker. Funds are held safely until your order is delivered, protecting both you and the baker.</div>
        </div>
    </div>
    @if($activePaymentType === 'final')
    <div class="alert-box warning">
        <span class="alert-icon">📦</span>
        <div>
            <div class="alert-title">Your cake is ready for delivery!</div>
            <div class="alert-sub">Pay the remaining ₱{{ number_format($finalAmount, 2) }} to the platform account below. Funds will be released to your baker once delivered.</div>
        </div>
    </div>
    @endif

    {{-- ── TWO COLUMN: Methods LEFT | Upload RIGHT ── --}}
    <div class="payment-grid">

        {{-- LEFT: Payment Methods --}}
        <div>
           @if(!$gcashAccount && !$mayaAccount)
            <div class="methods-card">
                <div class="no-methods-notice">
                    <span style="font-size:2rem; display:block; margin-bottom:0.5rem;">🔒</span>
                    Platform payment accounts are not yet configured.<br>
                    Please contact support.
                </div>
            </div>
            @else
            <div class="methods-card">
                <div class="methods-header">
                    <div class="methods-header-icon">💳</div>
                    <div>
                        <div class="methods-title">Payment Methods</div>
                        <div class="methods-sub">Send ₱{{ number_format($currentAmount, 2) }} via one of these options</div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="method-tabs">
                    @if($gcashMethods->isNotEmpty())
                    <button class="method-tab active" onclick="switchTab('gcash', this)">💙 GCash</button>
                    @endif
                    @if($mayaMethods->isNotEmpty())
                    <button class="method-tab {{ $gcashMethods->isEmpty() ? 'active' : '' }}" onclick="switchTab('maya', this)">💚 Maya</button>
                    @endif
                    @if($cashMethods->isNotEmpty())
                    <button class="method-tab {{ $gcashMethods->isEmpty() && $mayaMethods->isEmpty() ? 'active' : '' }}" onclick="switchTab('cash', this)">💵 Cash</button>
                    @endif
                </div>

                {{-- GCash Panel --}}
                @if($gcashMethods->isNotEmpty())
                @php $gcash = $gcashMethods->first(); @endphp
                <div class="method-panel active" id="panel-gcash">
                    @if($gcash->qr_code_path)
                 <div class="qr-timer-row">
                        <div style="font-size:0.8rem; font-weight:600; color:var(--brown-deep);">Scan QR Code</div>
                        <div class="qr-timer-badge green">🔒 Platform Account</div>
                    </div>
      <div class="qr-img-wrap" onclick="openQrModal('{{ asset('storage/'.$gcash->qr_code_path) }}', 'GCash QR')">
    <img src="{{ asset('storage/'.$gcash->qr_code_path) }}" class="qr-img" id="qr-img" alt="GCash QR">
    <div class="qr-expired-overlay" id="qr-expired-overlay">
        <span class="qr-expired-text">🚫 QR Expired — Refresh</span>
    </div>
</div>
                    <div style="margin-top:0.75rem; text-align:center;">
                        <form method="POST" action="{{ route('customer.payment.refresh-qr', $cakeRequest->id) }}" id="refresh-form">
                            @csrf
                            <button type="submit" class="refresh-btn" id="refresh-btn" style="display:none;">🔄 Refresh QR</button>
                        </form>
                    </div>
                    @endif
                    <div class="account-detail">
                        <div class="detail-row">
                            <span class="detail-label">Account Name</span>
                            <span class="detail-value">{{ $gcash->account_name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Account Number</span>
                            <span class="detail-value">{{ $gcash->account_number }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount to Send</span>
                            <span class="detail-value" style="color:var(--caramel);">₱{{ number_format($currentAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Maya Panel --}}
                @if($mayaMethods->isNotEmpty())
                @php $maya = $mayaMethods->first(); @endphp
                <div class="method-panel {{ $gcashMethods->isEmpty() ? 'active' : '' }}" id="panel-maya">
                    @if($maya->qr_code_path)
                    <div class="qr-timer-row">
                        <div style="font-size:0.8rem; font-weight:600; color:var(--brown-deep);">Scan QR Code</div>
                        <div class="qr-timer-badge green">🔒 Platform Account</div>
                    </div>
 <div class="qr-img-wrap" onclick="openQrModal('{{ asset('storage/'.$maya->qr_code_path) }}', 'Maya QR')">
    <img src="{{ asset('storage/'.$maya->qr_code_path) }}" class="qr-img" id="qr-img-maya" alt="Maya QR">
    <div class="qr-expired-overlay" id="qr-expired-overlay-maya">
        <span class="qr-expired-text">🚫 QR Expired — Refresh</span>
    </div>
</div>
                    <div style="margin-top:0.75rem; text-align:center;">
                        <button type="button" class="refresh-btn" id="refresh-btn-maya" style="display:none;"
                                onclick="document.getElementById('refresh-form').submit()">🔄 Refresh QR</button>
                    </div>
                    @endif
                    <div class="account-detail">
                        <div class="detail-row">
                            <span class="detail-label">Account Name</span>
                            <span class="detail-value">{{ $maya->account_name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Account Number</span>
                            <span class="detail-value">{{ $maya->account_number }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount to Send</span>
                            <span class="detail-value" style="color:var(--caramel);">₱{{ number_format($currentAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Cash Panel --}}
                @if($cashMethods->isNotEmpty())
                <div class="method-panel {{ $gcashMethods->isEmpty() && $mayaMethods->isEmpty() ? 'active' : '' }}" id="panel-cash">
                    <div class="alert-box info" style="margin-bottom:0;">
                        <span class="alert-icon">💵</span>
                        <div>
                            <div class="alert-title">Pay Cash on Delivery</div>
                            <div class="alert-sub">Prepare ₱{{ number_format($currentAmount, 2) }} in cash. Submit the form to notify your baker.</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
   @endif
        </div>

        {{-- RIGHT: Upload Form --}}

        {{-- RIGHT: Upload Form --}}
        <div>
            <div class="upload-form-card">
                <div class="upload-form-header">
                    📸 {{ $activePaymentType === 'final' ? 'Submit Final Payment' : 'Submit Proof of Payment' }}
                </div>
                <div class="upload-form-body">
                    <form method="POST"
                          action="{{ route('customer.payment.submit-proof', $cakeRequest->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="payment_type" value="{{ $activePaymentType }}">
                  <input type="hidden" name="payment_method" id="auto-payment-method"
                               value="{{ $gcashAccount ? 'gcash' : 'maya' }}">

            <div class="form-group">
                            <label class="form-label">GCash / Maya Reference Number <span style="color:#C44030;">*</span></label>
                            <input type="text" name="platform_reference"
                                   placeholder="e.g. 1234567890"
                                   required
                                   style="width:100%; padding:0.75rem 1rem; border:1.5px solid var(--border); border-radius:10px; font-size:0.88rem; font-family:'Plus Jakarta Sans',sans-serif; color:var(--brown-deep);"
                                   value="{{ old('platform_reference') }}">
                            <div style="font-size:0.68rem; color:var(--text-muted); margin-top:0.3rem;">Enter the 13-digit reference number from your GCash/Maya receipt.</div>
                        </div>
                        <div class="form-group" id="proof-upload-group">
                            <label class="form-label">Screenshot / Proof of Payment <span style="color:#C44030;">*</span></label>
                            <div class="upload-zone" onclick="document.getElementById('proof-file').click()">
                                <input type="file" name="proof_of_payment" id="proof-file"
                                       accept="image/*" onchange="previewProof(this)">
                                <span class="upload-zone-icon">📷</span>
                                <div class="upload-zone-text">
                                    <strong>Click to upload</strong> or drag & drop<br>
                                    JPG, PNG, GIF up to 5MB
                                </div>
                                <div class="upload-preview" id="proof-preview">
                                    <img id="proof-preview-img" src="" alt="Preview">
                                </div>
                            </div>
                        </div>

             <button type="submit" class="btn-submit">
                            {{ $activePaymentType === 'final' ? '🎉 Submit Final Payment to Platform' : '✓ Submit Proof to Platform' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── HOW TO PAY ── --}}
            <div class="how-to-pay" style="margin-top:1.25rem;">
                <div class="how-to-pay-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                         stroke-linejoin="round" style="color:var(--caramel);">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    How to Pay via {{ $gcashMethods->isNotEmpty() ? 'GCash' : ($mayaMethods->isNotEmpty() ? 'Maya' : 'Cash') }}
                </div>
                <div class="how-to-pay-body">
                    <div class="step-list">
                        @if($gcashMethods->isNotEmpty() || $mayaMethods->isNotEmpty())
                        @php $methodName = $gcashMethods->isNotEmpty() ? 'GCash' : 'Maya'; @endphp
                        <div class="step-item">
                            <div class="step-num">1</div>
                            <div class="step-text">Open your <strong>{{ $methodName }}</strong> app on your phone.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">2</div>
                            <div class="step-text">Tap <strong>Send Money</strong> → then tap <strong>Scan QR Code</strong>.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">3</div>
                            <div class="step-text"><strong>Tap the QR image</strong> on the left to zoom in and save it, then scan it in {{ $methodName }}. Or manually enter the account number shown.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">4</div>
                            <div class="step-text">Enter the exact amount: <strong>₱{{ number_format($currentAmount, 2) }}</strong>. Double-check before confirming.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">5</div>
                            <div class="step-text">After payment, <strong>take a screenshot</strong> of the confirmation screen.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">6</div>
                            <div class="step-text">Upload the screenshot above, then hit <strong>Submit</strong>.</div>
                        </div>
                        @else
                        <div class="step-item">
                            <div class="step-num">1</div>
                            <div class="step-text">Prepare <strong>₱{{ number_format($currentAmount, 2) }}</strong> in cash for your delivery rider.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">2</div>
                            <div class="step-text">Click <strong>Submit</strong> above to notify your baker that you'll pay on delivery.</div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">3</div>
                            <div class="step-text">Hand over the exact amount when your order arrives. Your baker will mark it as paid.</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end payment-grid --}}

    @endif {{-- end states --}}

{{-- ── QR ZOOM MODAL ── --}}
    <div class="qr-modal-overlay" id="qr-modal" onclick="closeQrModal(event)">
        <img src="" class="qr-modal-img" id="qr-modal-img" alt="QR Code">
        <div class="qr-modal-actions">
            <button class="qr-modal-btn download" onclick="downloadQr(event)">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download QR
            </button>
            <button class="qr-modal-btn close-btn" onclick="closeQrModal()">✕ Close</button>
        </div>
        <div class="qr-modal-hint">Tap outside or press ESC to close</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewReupload(input, previewDivId, previewImgId) {
    const preview = document.getElementById(previewDivId);
    const img     = document.getElementById(previewImgId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.type === 'application/pdf') {
            preview.style.display = 'block';
            img.style.display = 'none';
            preview.innerHTML = '<div style="padding:0.75rem; background:#f5f5f5; border-radius:8px; font-size:0.82rem; color:#555;">📄 ' + file.name + '</div>';
        } else {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                img.style.display = 'block';
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
}
function switchTab(method, btn) {
    document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.method-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    const panel = document.getElementById('panel-' + method);
    if (panel) panel.classList.add('active');
    const methodInput = document.getElementById('auto-payment-method');
    if (methodInput) methodInput.value = method;
}

function previewProof(input) {
    const preview = document.getElementById('proof-preview');
    const img     = document.getElementById('proof-preview-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

let currentQrSrc = '';
let currentQrLabel = '';

function openQrModal(src, label) {
    currentQrSrc = src;
    currentQrLabel = label;
    document.getElementById('qr-modal-img').src = src;
    document.getElementById('qr-modal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeQrModal(e) {
    if (e && e.target !== document.getElementById('qr-modal')) return;
    document.getElementById('qr-modal').classList.remove('show');
    document.body.style.overflow = '';
}

function downloadQr(e) {
    e.stopPropagation();
    const a = document.createElement('a');
    a.href = currentQrSrc;
    a.download = currentQrLabel.replace(/\s+/g, '_') + '_QR.png';
    a.target = '_blank';
    a.click();
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.getElementById('qr-modal').classList.remove('show');
        document.body.style.overflow = '';
    }
});

@if(isset($qrExpiresAt))
(function() {
    const expiresAt = {{ $qrExpiresAt }} * 1000;
    function updateTimer() {
        const remaining = Math.max(0, Math.floor((expiresAt - Date.now()) / 1000));
        const mins = String(Math.floor(remaining / 60)).padStart(2, '0');
        const secs = String(remaining % 60).padStart(2, '0');
        const text = mins + ':' + secs;
        ['qr-countdown','qr-countdown-maya'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = text;
        });
        ['qr-timer-badge','qr-timer-badge-maya'].forEach(id => {
            const badge = document.getElementById(id);
            if (!badge) return;
            badge.className = 'qr-timer-badge ' + (remaining === 0 ? 'red' : remaining <= 120 ? 'yellow' : 'green');
        });
        if (remaining === 0) {
            ['qr-img','qr-img-maya'].forEach(id => { const img = document.getElementById(id); if (img) img.classList.add('expired'); });
            ['qr-expired-overlay','qr-expired-overlay-maya'].forEach(id => { const el = document.getElementById(id); if (el) el.classList.add('show'); });
            ['refresh-btn','refresh-btn-maya'].forEach(id => { const btn = document.getElementById(id); if (btn) btn.style.display = 'inline-flex'; });
        } else {
            setTimeout(updateTimer, 1000);
        }
    }
    updateTimer();
})();
@endif
</script>
@endpush