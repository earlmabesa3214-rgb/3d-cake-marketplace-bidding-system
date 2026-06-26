@extends($isBaker ? 'layouts.baker' : 'layouts.customer')
{{--
    Shared Report Form — works for baker (reporting customer) AND customer (reporting baker)
    Route: /report/order/{bakerOrder}
    Controller passes: $bakerOrder, $isBaker (bool), $reportedUser
--}}
@php
    $isBaker      = $isBaker ?? (auth()->user()->role === 'baker');
    $reportedUser = $reportedUser ?? ($isBaker ? $bakerOrder->cakeRequest->user : $bakerOrder->baker);
    $orderId      = str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT);

    $bakerCategories = [
        'no_show'          => ['label' => 'No-Show / Unresponsive'],
        'payment_fraud'    => ['label' => 'Payment Fraud / Fake Receipt'],
        'fake_proof'       => ['label' => 'Fake Proof of Payment'],
        'harassment'       => ['label' => 'Harassment / Rude Behavior'],
        'order_abandoned'  => ['label' => 'Order Abandoned'],
        'other'            => ['label' => 'Other'],
    ];

    $customerCategories = [
        'poor_quality'    => ['label' => 'Poor Cake Quality'],
        'no_show'         => ['label' => 'Baker No-Show / Unresponsive'],
        'payment_fraud'   => ['label' => 'Payment Issue'],
        'harassment'      => ['label' => 'Harassment / Rude Behavior'],
        'order_abandoned' => ['label' => 'Order Abandoned / Not Delivered'],
        'other'           => ['label' => 'Other'],
    ];

    $categories = $isBaker ? $bakerCategories : $customerCategories;
    $backRoute   = $isBaker
        ? route('baker.orders.show', $bakerOrder->id)
        : route('customer.cake-requests.show', $bakerOrder->cake_request_id);
@endphp

@section('title', 'Report ' . ($isBaker ? 'Customer' : 'Baker') . ' — #' . $orderId)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*, *::before, *::after {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    box-sizing: border-box;
}

:root {
    --brown-deep:    #3B1F0F;
    --brown-mid:     #7A4A28;
    --caramel:       #C8893A;
    --caramel-lt:    #E8A94A;
    --cream:         #F5EFE6;
    --warm-white:    #FFFDF9;
    --border:        #EAE0D0;
    --text-dark:     #2C1A0E;
    --text-mid:      #6B4A2A;
    --text-muted:    #9A7A5A;
    --red-deep:      #4A1515;
    --red-mid:       #7A2020;
    --red-accent:    #B03030;
    --red-pale:      #FDF2F2;
    --red-border:    #EABFBF;
    --shadow-sm:     0 1px 4px rgba(59,31,15,0.07);
    --shadow-md:     0 4px 16px rgba(59,31,15,0.10);
}
.rp-page {
    max-width: 100%;
    margin: 0 auto;
    padding: 0 0 5rem;
}

/* ── BACK ── */
.rp-back {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--text-muted);
    text-decoration: none;
    margin-bottom: 1.75rem;
    transition: color 0.18s;
}
.rp-back:hover { color: var(--caramel); }
.rp-back svg { transition: transform 0.18s; }
.rp-back:hover svg { transform: translateX(-2px); }

/* ── PAGE HEADER ── */
.rp-page-header {
    margin-bottom: 2rem;
}
.rp-page-header-top {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}
.rp-header-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--red-deep), var(--red-mid));
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.rp-page-title {
    font-size: 1.45rem;
    font-weight: 800;
    color: var(--brown-deep);
    line-height: 1.2;
}
.rp-page-sub {
    font-size: 0.8rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin-left: calc(44px + 1rem);
}

/* ── SUBJECT STRIP ── */
.rp-subject {
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.9rem;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-sm);
}
.rp-subject-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-lt));
    color: white; display: flex; align-items: center;
    justify-content: center; font-size: 0.95rem; font-weight: 800;
    flex-shrink: 0; overflow: hidden; border: 2px solid var(--border);
}
.rp-subject-avatar img { width: 100%; height: 100%; object-fit: cover; }
.rp-subject-name { font-size: 0.88rem; font-weight: 700; color: var(--text-dark); }
.rp-subject-meta {
    font-size: 0.68rem; color: var(--text-muted);
    margin-top: 0.15rem; display: flex; align-items: center; gap: 0.4rem;
}
.rp-subject-role-tag {
    padding: 0.1rem 0.4rem;
    background: var(--cream); border: 1px solid var(--border);
    border-radius: 4px; font-weight: 700; font-size: 0.6rem;
    text-transform: uppercase; letter-spacing: 0.06em; color: var(--brown-mid);
}
.rp-order-ref {
    margin-left: auto; flex-shrink: 0;
    text-align: right;
}
.rp-order-ref-num {
    font-size: 0.82rem; font-weight: 800; color: var(--caramel);
}
.rp-order-ref-label {
    font-size: 0.6rem; color: var(--text-muted); margin-top: 0.1rem;
    text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600;
}

/* ── NOTICE BAR ── */
.rp-notice {
    background: #FFFBEB;
    border: 1.5px solid #EDD070;
    border-radius: 10px;
    padding: 0.8rem 1rem;
    display: flex; align-items: flex-start; gap: 0.6rem;
    margin-bottom: 1.5rem;
    font-size: 0.76rem; color: #6B4800; line-height: 1.6;
}
.rp-notice-icon { flex-shrink: 0; margin-top: 1px; }

/* ── SECTION ── */
.rp-section {
    margin-bottom: 1rem;
}
.rp-section-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--text-muted);
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.rp-required-dot {
    width: 5px; height: 5px; border-radius: 50%;
    background: var(--red-accent); flex-shrink: 0;
}

/* ── CATEGORY LIST ── */
.rp-cat-list {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.rp-cat-radio { display: none; }
.rp-cat-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.8rem 1rem;
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.15s;
    position: relative;
}
.rp-cat-item:hover {
    border-color: #C8A0A0;
    background: #FDFAFA;
}
.rp-cat-radio:checked + .rp-cat-item {
    border-color: var(--red-accent);
    background: var(--red-pale);
}
.rp-cat-radio:checked + .rp-cat-item .rp-cat-indicator {
    border-color: var(--red-accent);
    background: var(--red-accent);
}
.rp-cat-radio:checked + .rp-cat-item .rp-cat-indicator::after {
    opacity: 1;
}
.rp-cat-indicator {
    width: 18px; height: 18px; border-radius: 50%;
    border: 2px solid var(--border);
    flex-shrink: 0;
    transition: all 0.15s;
    display: flex; align-items: center; justify-content: center;
    position: relative;
}
.rp-cat-indicator::after {
    content: '';
    width: 6px; height: 6px; border-radius: 50%;
    background: white;
    opacity: 0;
    transition: opacity 0.15s;
}
.rp-cat-label-text {
    font-size: 0.84rem;
    font-weight: 600;
    color: var(--text-dark);
    flex: 1;
}
.rp-cat-svg {
    flex-shrink: 0;
    color: var(--text-muted);
}
.rp-cat-radio:checked + .rp-cat-item .rp-cat-svg {
    color: var(--red-accent);
}

/* ── TEXTAREA ── */
.rp-textarea {
    width: 100%;
    min-height: 120px;
    padding: 0.9rem 1rem;
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.84rem;
    color: var(--text-dark);
    line-height: 1.6;
    resize: vertical;
    transition: all 0.15s;
    outline: none;
}
.rp-textarea::placeholder { color: var(--text-muted); }
.rp-textarea:focus {
    border-color: var(--red-accent);
    background: white;
    box-shadow: 0 0 0 3px rgba(176,48,48,0.08);
}
.rp-char-hint {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 0.4rem;
}
.rp-char-count {
    font-size: 0.68rem; color: var(--text-muted); font-weight: 500;
}
.rp-char-count.warn { color: var(--red-accent); font-weight: 700; }
.rp-char-min {
    font-size: 0.68rem; color: var(--text-muted);
}

/* ── FILE UPLOAD ── */
.rp-dropzone {
    border: 1.5px dashed var(--border);
    border-radius: 10px;
    padding: 1rem 1.25rem;
    cursor: pointer;
    background: var(--warm-white);
    transition: all 0.18s;
    display: flex; align-items: center; gap: 0.85rem;
    position: relative;
}
.rp-dropzone:hover {
    border-color: var(--red-accent);
    background: var(--red-pale);
}
.rp-dropzone.has-file {
    border-style: solid;
    border-color: var(--red-accent);
    background: var(--red-pale);
}
.rp-dropzone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%;
}
.rp-dz-icon-wrap {
    width: 40px; height: 40px; border-radius: 10px;
    background: var(--cream); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: var(--text-muted); transition: all 0.18s;
}
.rp-dropzone.has-file .rp-dz-icon-wrap {
    background: var(--red-pale); border-color: var(--red-border);
    color: var(--red-accent);
}
.rp-dz-text-title { font-size: 0.82rem; font-weight: 700; color: var(--text-dark); }
.rp-dz-text-sub { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.1rem; }
.rp-file-preview {
    width: 40px; height: 40px; border-radius: 7px; object-fit: cover;
    border: 1.5px solid var(--border); display: none; flex-shrink: 0; margin-left: auto;
}
.rp-file-ok {
    margin-left: auto; flex-shrink: 0;
    display: none; align-items: center; gap: 0.35rem;
    font-size: 0.68rem; font-weight: 700; color: #166534;
    background: #EFF5EF; border: 1px solid #BFDFBE;
    padding: 0.2rem 0.55rem; border-radius: 20px;
}
.rp-optional-tag {
    margin-left: auto;
    font-size: 0.62rem;
    color: var(--text-muted);
    font-weight: 500;
    font-style: italic;
}

/* ── REFUND CARD ── */
.rp-refund-card {
    background: #FFFBEB;
    border: 1.5px solid #EDD070;
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    margin-bottom: 1rem;
}
.rp-refund-header {
    display: flex; align-items: center; gap: 0.6rem;
    margin-bottom: 0.75rem;
}
.rp-refund-title { font-size: 0.88rem; font-weight: 700; color: var(--brown-deep); }
.rp-refund-notice {
    font-size: 0.75rem; color: #6B4800; line-height: 1.6;
    margin-bottom: 0.85rem;
    padding: 0.65rem 0.85rem;
    background: rgba(255,255,255,0.6);
    border-radius: 8px;
    border: 1px solid #EDD070;
}
.rp-refund-check-label {
    display: flex; align-items: flex-start; gap: 0.7rem; cursor: pointer;
}
.rp-refund-check-label input[type="checkbox"] {
    width: 17px; height: 17px; margin-top: 2px;
    accent-color: var(--red-accent); flex-shrink: 0;
}
.rp-refund-check-title { font-size: 0.84rem; font-weight: 700; color: var(--brown-deep); }
.rp-refund-check-sub { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.15rem; line-height: 1.5; }

/* ── DIVIDER ── */
.rp-divider {
    height: 1px; background: var(--border); margin: 1.25rem 0;
}

/* ── VALIDATION ERROR ── */
.rp-error {
    font-size: 0.72rem; color: var(--red-accent); font-weight: 600;
    display: flex; align-items: center; gap: 0.35rem;
    margin-top: 0.45rem; display: none;
}
.rp-error.show { display: flex; }

/* ── SUBMIT ROW ── */
.rp-footer {
    display: flex; align-items: center; gap: 0.75rem;
    flex-wrap: wrap; margin-top: 1.5rem;
}
.rp-cancel-btn {
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.7rem 1.1rem;
    background: white; color: var(--text-mid);
    border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 0.84rem; font-weight: 600; cursor: pointer;
    text-decoration: none; transition: all 0.18s; white-space: nowrap;
}
.rp-cancel-btn:hover { border-color: var(--caramel); color: var(--caramel); }
.rp-submit-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, var(--red-deep), var(--red-mid));
    color: white; border: none; border-radius: 10px;
    font-size: 0.84rem; font-weight: 700; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    box-shadow: 0 3px 12px rgba(122,32,32,0.28);
    transition: all 0.18s; white-space: nowrap;
}
.rp-submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 5px 18px rgba(122,32,32,0.38);
}
.rp-submit-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.rp-footer-note {
    flex: 1; min-width: 160px;
    font-size: 0.7rem; color: var(--text-muted); line-height: 1.5;
    display: flex; align-items: center; gap: 0.4rem;
}

/* ── VALIDATION ERRORS BLOCK ── */
.rp-errors-block {
    background: var(--red-pale);
    border: 1.5px solid var(--red-border);
    border-radius: 10px;
    padding: 0.9rem 1rem;
    display: flex; align-items: flex-start; gap: 0.6rem;
    margin-bottom: 1.25rem;
    font-size: 0.78rem; color: var(--red-mid); line-height: 1.6;
}

@media (max-width: 560px) {
    .rp-footer { flex-direction: column-reverse; align-items: stretch; }
    .rp-submit-btn, .rp-cancel-btn { justify-content: center; }
    .rp-page-sub { margin-left: 0; margin-top: 0.35rem; }
}
</style>
@endpush

@section('content')
<div class="rp-page">

    {{-- Back --}}
    <a href="{{ $backRoute }}" class="rp-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Order
    </a>

    {{-- Page Header --}}
    <div class="rp-page-header">
        <div class="rp-page-header-top">
            <div class="rp-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="rp-page-title">Report {{ $isBaker ? 'Customer' : 'Baker' }}</div>
        </div>
        <div class="rp-page-sub">Help us keep BakeSphere safe — reports are reviewed by our admin team within 24–48 hours.</div>
    </div>

    {{-- Reported Party --}}
    <div class="rp-subject">
        <div class="rp-subject-avatar">
            @if($reportedUser->profile_photo)
                <img src="{{ str_starts_with($reportedUser->profile_photo, 'http') ? $reportedUser->profile_photo : asset('storage/'.$reportedUser->profile_photo) }}" alt="">
            @else
                {{ strtoupper(substr($reportedUser->first_name, 0, 1)) }}
            @endif
        </div>
        <div>
            <div class="rp-subject-name">{{ $reportedUser->first_name }} {{ $reportedUser->last_name }}</div>
            <div class="rp-subject-meta">
                <span class="rp-subject-role-tag">{{ $isBaker ? 'Customer' : 'Baker' }}</span>
                {{ $reportedUser->email }}
            </div>
        </div>
        <div class="rp-order-ref">
            <div class="rp-order-ref-num">#{{ $orderId }}</div>
            <div class="rp-order-ref-label">Order Ref.</div>
        </div>
    </div>

    {{-- Warning notice --}}
    <div class="rp-notice">
        <div class="rp-notice-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8B6000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div><strong>Important:</strong> False reports are taken seriously and may result in account suspension. Only submit if you have a genuine concern. All reports are anonymous to the reported party.</div>
    </div>

    {{-- Server validation errors --}}
    @if($errors->any())
    <div class="rp-errors-block">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong>Please fix the following:</strong>
            <ul style="margin:0.35rem 0 0 1rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form id="report-form" method="POST" action="{{ route('report.store', $bakerOrder->id) }}" enctype="multipart/form-data">
        @csrf

        {{-- Category --}}
        <div class="rp-section">
            <div class="rp-section-label">
                <span class="rp-required-dot"></span>
                What is your complaint about?
            </div>
            <div class="rp-cat-list">
                @foreach($categories as $value => $cat)
                @php
                    $catIcons = [
                        'no_show'          => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>',
                        'payment_fraud'    => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
                        'fake_proof'       => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/></svg>',
                        'harassment'       => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
                        'order_abandoned'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
                        'poor_quality'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/></svg>',
                        'other'            => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>',
                    ];
                    $icon = $catIcons[$value] ?? $catIcons['other'];
                @endphp
                <div>
                    <input class="rp-cat-radio" type="radio" name="category" id="cat_{{ $value }}" value="{{ $value }}"
                           {{ old('category') === $value ? 'checked' : '' }}>
                    <label class="rp-cat-item" for="cat_{{ $value }}">
                        <div class="rp-cat-indicator"></div>
                        <span class="rp-cat-label-text">{{ $cat['label'] }}</span>
                        <span class="rp-cat-svg">{!! $icon !!}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <div id="cat-error" class="rp-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Please select a complaint category.
            </div>
        </div>

        <div class="rp-divider"></div>

        {{-- Description --}}
        <div class="rp-section">
            <div class="rp-section-label">
                <span class="rp-required-dot"></span>
                Describe what happened
            </div>
            <textarea class="rp-textarea" name="description" id="rp-desc" maxlength="2000"
                placeholder="Describe the issue in detail — include relevant dates, amounts, or specific incidents…"
                rows="5">{{ old('description') }}</textarea>
            <div class="rp-char-hint">
                <div class="rp-char-min">Minimum 10 characters</div>
                <div class="rp-char-count" id="char-count">0 / 2000</div>
            </div>
            <div id="desc-error" class="rp-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Please describe what happened (at least 10 characters).
            </div>
        </div>

        <div class="rp-divider"></div>

        {{-- Screenshot --}}
        <div class="rp-section">
            <div class="rp-section-label" style="justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:0.4rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    Attach Screenshot
                </div>
                <span class="rp-optional-tag">Optional — helps with investigation</span>
            </div>
            <div class="rp-dropzone" id="rp-dropzone">
                <input type="file" name="screenshot" accept=".jpg,.jpeg,.png,.webp,.pdf"
                       onchange="handleReportFile(this)">
                <div class="rp-dz-icon-wrap" id="rp-dz-icon-wrap">
                    <svg id="rp-dz-svg-default" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <svg id="rp-dz-svg-done" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <div class="rp-dz-text-title" id="rp-dz-title">Click to upload screenshot</div>
                    <div class="rp-dz-text-sub" id="rp-dz-sub">JPG, PNG, PDF · max 5 MB</div>
                </div>
                <img class="rp-file-preview" id="rp-file-preview" src="" alt="">
                <div class="rp-file-ok" id="rp-file-ok">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Attached
                </div>
            </div>
        </div>

        {{-- Refund request (customer only) --}}
        @if(!$isBaker)
        <div class="rp-refund-card" id="refund-request-card" style="display:none;">
            <div class="rp-refund-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8B6000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg>
                <div class="rp-refund-title">Request a Refund?</div>
            </div>
            <div class="rp-refund-notice">
                Downpayments are strictly non-refundable under normal circumstances. However, if your baker failed to comply by the agreed deadline, you may request a refund review. Our admin team will investigate and decide based on evidence.
            </div>
            <label class="rp-refund-check-label">
                <input type="checkbox" name="request_refund" id="request_refund" value="1">
                <div>
                    <div class="rp-refund-check-title">Yes, I want to request a refund</div>
                    <div class="rp-refund-check-sub">Admin will review your evidence and decide. Refunds are credited to your BakeSphere wallet if approved.</div>
                </div>
            </label>
        </div>
        <script>
        const refundEligibleCats = ['no_show', 'order_abandoned'];
        document.querySelectorAll('input[name="category"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const card = document.getElementById('refund-request-card');
                if (card) {
                    card.style.display = refundEligibleCats.includes(this.value) ? 'block' : 'none';
                    if (!refundEligibleCats.includes(this.value)) {
                        document.getElementById('request_refund').checked = false;
                    }
                }
            });
        });
        </script>
        @endif

        {{-- Footer --}}
        <div class="rp-footer">
            <a href="{{ $backRoute }}" class="rp-cancel-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Go Back
            </a>
            <div class="rp-footer-note">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Your identity will not be revealed to the reported party.
            </div>
            <button type="submit" class="rp-submit-btn" id="rp-submit" onclick="return validateReport()">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Submit Report
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
    const btn = document.getElementById('rp-submit');
    if (btn) { btn.disabled = false; btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Submit Report'; }
    @endif
});

const descEl  = document.getElementById('rp-desc');
const countEl = document.getElementById('char-count');
function updateCount() {
    const len = descEl.value.length;
    countEl.textContent = len + ' / 2000';
    countEl.classList.toggle('warn', len > 1800);
}
descEl.addEventListener('input', updateCount);
updateCount();

function handleReportFile(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const isImage = file.type.startsWith('image/');
    const dropzone = document.getElementById('rp-dropzone');
    dropzone.classList.add('has-file');

    document.getElementById('rp-dz-title').textContent = file.name;
    document.getElementById('rp-dz-sub').textContent   = (file.size / 1024).toFixed(0) + ' KB';
    document.getElementById('rp-dz-svg-default').style.display = 'none';
    document.getElementById('rp-dz-svg-done').style.display    = 'block';

    const okEl = document.getElementById('rp-file-ok');
    okEl.style.display = 'flex';

    if (isImage) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('rp-file-preview');
            prev.src = e.target.result;
            prev.style.display = 'block';
            okEl.style.display = 'none'; // hide badge if preview visible
        };
        reader.readAsDataURL(file);
    }
}

function validateReport() {
    let ok = true;
    const catSelected = document.querySelector('input[name="category"]:checked');
    const catErr  = document.getElementById('cat-error');
    const descErr = document.getElementById('desc-error');

    catErr.classList.toggle('show', !catSelected);
    if (!catSelected) ok = false;

    const desc = descEl.value.trim();
    descErr.classList.toggle('show', desc.length < 10);
    if (desc.length < 10) ok = false;

    if (ok) {
        const btn = document.getElementById('rp-submit');
        btn.disabled = true;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation:spin 0.7s linear infinite;"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Submitting…';
        document.getElementById('report-form').submit();
    }
    return false;
}

// Spinner keyframe
const s = document.createElement('style');
s.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(s);
</script>
@endsection