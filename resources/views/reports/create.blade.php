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
        'no_show'          => ['icon' => '🚫', 'label' => 'No-Show / Unresponsive'],
      'payment_fraud'    => ['icon' => '💳', 'label' => 'Payment Fraud / Fake Receipt'],
        'fake_proof'       => ['icon' => '📄', 'label' => 'Fake Proof of Payment'],
        'harassment'       => ['icon' => '😡', 'label' => 'Harassment / Rude Behavior'],
        'order_abandoned'  => ['icon' => '🛒', 'label' => 'Order Abandoned'],
        'other'            => ['icon' => '💬', 'label' => 'Other'],
    ];

$customerCategories = [
    'poor_quality'    => ['icon' => '🎂', 'label' => 'Poor Cake Quality'],
    'no_show'         => ['icon' => '🚫', 'label' => 'Baker No-Show / Unresponsive'],
    'payment_fraud'   => ['icon' => '💳', 'label' => 'Payment Issue'],
    'harassment'      => ['icon' => '😡', 'label' => 'Harassment / Rude Behavior'],
    'order_abandoned' => ['icon' => '📦', 'label' => 'Order Abandoned / Not Delivered'],
    'other'           => ['icon' => '💬', 'label' => 'Other'],
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
    --brand-deep:    #3B1F0F;
    --brand-mid:     #7A4A28;
    --caramel:       #C8893A;
    --caramel-lt:    #E8A94A;
    --cream:         #F5EFE6;
    --warm-white:    #FFFDF9;
    --border:        #EAE0D0;
    --text-dark:     #2C1A0E;
    --text-mid:      #6B4A2A;
    --text-muted:    #9A7A5A;
    --danger-deep:   #5A1A1A;
    --danger-mid:    #8B2A2A;
    --danger-lt:     #C44030;
    --danger-pale:   #FDF0EE;
    --danger-border: #F5C5BE;
    --shadow-sm:     0 2px 8px rgba(59,31,15,0.08);
    --shadow-md:     0 8px 24px rgba(59,31,15,0.12);
    --shadow-lg:     0 16px 48px rgba(59,31,15,0.16);
    --radius-sm:     10px;
    --radius-md:     16px;
    --radius-lg:     24px;
}

/* ── PAGE WRAPPER ── */
.rp-page {
    max-width: 680px;
    margin: 0 auto;
    padding: 0 0 4rem;
}

/* ── BACK LINK ── */
.rp-back {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-muted);
    text-decoration: none;
    margin-bottom: 1.5rem;
    padding: 0.4rem 0.75rem 0.4rem 0.5rem;
    border-radius: 20px;
    transition: all 0.2s;
    border: 1px solid transparent;
}
.rp-back:hover {
    color: var(--caramel);
    background: var(--cream);
    border-color: var(--border);
}

/* ── HERO BANNER ── */
.rp-hero {
    border-radius: var(--radius-lg);
    padding: 2rem 2rem 1.75rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, var(--danger-deep) 0%, var(--danger-mid) 60%, #A83530 100%);
    color: white;
}
.rp-hero::before {
    content: '';
    position: absolute;
    right: -50px; top: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.rp-hero::after {
    content: '';
    position: absolute;
    right: 60px; bottom: -70px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.rp-hero-inner { position: relative; z-index: 1; display: flex; align-items: flex-start; gap: 1.25rem; }
.rp-hero-icon {
    width: 52px; height: 52px; flex-shrink: 0;
    border-radius: 14px;
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
}
.rp-hero-eyebrow {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    opacity: 0.55;
    margin-bottom: 0.3rem;
}
.rp-hero-title {
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 0.35rem;
}
.rp-hero-sub {
    font-size: 0.8rem;
    opacity: 0.65;
    line-height: 1.6;
}

/* ── SUBJECT CARD ── */
.rp-subject {
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--shadow-sm);
}
.rp-subject-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-lt));
    color: white; display: flex; align-items: center;
    justify-content: center; font-size: 1rem; font-weight: 800;
    flex-shrink: 0; overflow: hidden; border: 2px solid var(--border);
}
.rp-subject-avatar img { width: 100%; height: 100%; object-fit: cover; }
.rp-subject-name { font-size: 0.92rem; font-weight: 700; color: var(--text-dark); }
.rp-subject-role {
    font-size: 0.7rem; color: var(--text-muted);
    display: flex; align-items: center; gap: 0.35rem; margin-top: 0.15rem;
}
.rp-subject-role span {
    padding: 0.1rem 0.45rem;
    background: var(--cream); border: 1px solid var(--border);
    border-radius: 4px; font-weight: 600; font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.07em;
}
.rp-order-pill {
    margin-left: auto; flex-shrink: 0;
    padding: 0.3rem 0.75rem;
    background: var(--cream); border: 1.5px solid var(--border);
    border-radius: 20px; font-size: 0.72rem; font-weight: 700;
    color: var(--caramel); text-align: center;
}
.rp-order-pill small { display: block; font-size: 0.6rem; font-weight: 500; color: var(--text-muted); margin-top: 0.1rem; }

/* ── WARNING BOX ── */
.rp-warning {
    background: #FFFBEB;
    border: 1.5px solid #F0D060;
    border-radius: var(--radius-sm);
    padding: 0.9rem 1.1rem;
    display: flex; align-items: flex-start; gap: 0.65rem;
    margin-bottom: 1.5rem;
    font-size: 0.78rem; color: #7A5200; line-height: 1.6;
}
.rp-warning-icon { font-size: 1rem; flex-shrink: 0; margin-top: 0.1rem; }

/* ── FORM CARD ── */
.rp-card {
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    overflow: hidden;
    margin-bottom: 1.25rem;
    box-shadow: var(--shadow-sm);
}
.rp-card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1.5px solid var(--border);
    display: flex; align-items: center; gap: 0.65rem;
    background: var(--cream);
}
.rp-card-header-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: white; border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
}
.rp-card-title {
    font-size: 0.88rem; font-weight: 700; color: var(--brand-deep);
}
.rp-required {
    margin-left: auto; font-size: 0.62rem;
    color: var(--danger-mid); font-weight: 700;
    background: var(--danger-pale); border: 1px solid var(--danger-border);
    padding: 0.1rem 0.45rem; border-radius: 4px;
}

/* ── CATEGORY GRID ── */
.rp-cat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.6rem;
    padding: 1.25rem 1.5rem;
}

.rp-cat-option { display: none; }

.rp-cat-label {
    display: flex; align-items: center; gap: 0.65rem;
    padding: 0.75rem 0.9rem;
    border: 2px solid var(--border);
    border-radius: var(--radius-sm);
    cursor: pointer;
    background: white;
    transition: all 0.18s cubic-bezier(0.2, 0, 0, 1);
    position: relative;
    overflow: hidden;
}
.rp-cat-label::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(139,42,30,0.06), transparent);
    opacity: 0; transition: opacity 0.18s;
}
.rp-cat-label:hover {
    border-color: var(--danger-border);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}
.rp-cat-label:hover::after { opacity: 1; }

.rp-cat-option:checked + .rp-cat-label {
    border-color: var(--danger-mid);
    background: var(--danger-pale);
    box-shadow: 0 0 0 3px rgba(139,42,30,0.12);
}
.rp-cat-option:checked + .rp-cat-label .rp-cat-check { opacity: 1; }

.rp-cat-emoji { font-size: 1.15rem; flex-shrink: 0; }
.rp-cat-text { font-size: 0.78rem; font-weight: 600; color: var(--text-dark); line-height: 1.3; }
.rp-cat-check {
    position: absolute; top: 6px; right: 6px;
    width: 16px; height: 16px; border-radius: 50%;
    background: var(--danger-mid); color: white;
    font-size: 0.55rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.18s;
}

/* ── DESCRIPTION TEXTAREA ── */
.rp-textarea-wrap { padding: 1.25rem 1.5rem; }
.rp-textarea {
    width: 100%;
    min-height: 110px;
    padding: 0.85rem 1rem;
    background: var(--cream);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    color: var(--text-dark);
    line-height: 1.6;
    resize: vertical;
    transition: all 0.18s;
    outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}
.rp-textarea::placeholder { color: var(--text-muted); }
.rp-textarea:focus {
    border-color: var(--danger-mid);
    background: white;
    box-shadow: 0 0 0 3px rgba(139,42,30,0.1);
}
.rp-char-count {
    text-align: right;
    font-size: 0.68rem;
    color: var(--text-muted);
    margin-top: 0.4rem;
    font-weight: 500;
}
.rp-char-count.warn { color: var(--danger-mid); font-weight: 700; }

/* ── FILE UPLOAD ── */
.rp-file-wrap { padding: 0 1.5rem 1.25rem; }
.rp-dropzone {
    border: 2px dashed var(--border);
    border-radius: var(--radius-sm);
    padding: 1.1rem 1.25rem;
    cursor: pointer;
    background: var(--cream);
    transition: all 0.2s;
    display: flex; align-items: center; gap: 0.85rem;
    position: relative;
}
.rp-dropzone:hover { border-color: var(--danger-mid); background: var(--danger-pale); }
.rp-dropzone.has-file { border-style: solid; border-color: var(--danger-mid); background: var(--danger-pale); }
.rp-dropzone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%;
}
.rp-dz-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: white; border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.rp-dz-title { font-size: 0.82rem; font-weight: 700; color: var(--brand-deep); }
.rp-dz-sub { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.1rem; }
.rp-file-preview {
    width: 44px; height: 44px; border-radius: 8px; object-fit: cover;
    border: 1.5px solid var(--border); display: none; flex-shrink: 0; margin-left: auto;
}
.rp-file-name {
    font-size: 0.72rem; font-weight: 600; color: var(--danger-deep);
    display: none; margin-left: auto; max-width: 140px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.rp-file-badge {
    font-size: 0.6rem; background: #EFF5EF; color: #166534;
    border: 1px solid #BFDFBE; padding: 0.15rem 0.5rem;
    border-radius: 4px; font-weight: 700; display: none; margin-left: 0.4rem; flex-shrink: 0;
}

/* ── SUBMIT ROW ── */
.rp-submit-row {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap;
}
.rp-submit-note {
    font-size: 0.72rem; color: var(--text-muted); line-height: 1.5; flex: 1; min-width: 180px;
}
.rp-submit-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.8rem 1.75rem;
    background: linear-gradient(135deg, var(--danger-deep), var(--danger-mid));
    color: white; border: none; border-radius: var(--radius-sm);
    font-size: 0.875rem; font-weight: 700; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    box-shadow: 0 4px 14px rgba(139,42,30,0.35);
    transition: all 0.2s; white-space: nowrap; flex-shrink: 0;
}
.rp-submit-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(139,42,30,0.45); }
.rp-submit-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.rp-cancel-btn {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.8rem 1.2rem;
    background: white; color: var(--text-mid);
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-size: 0.875rem; font-weight: 600; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    text-decoration: none; transition: all 0.2s; white-space: nowrap; flex-shrink: 0;
}
.rp-cancel-btn:hover { border-color: var(--caramel); color: var(--caramel); }

/* ── VALIDATION ERROR ── */
.rp-error {
    font-size: 0.72rem; color: var(--danger-mid); font-weight: 600;
    padding: 0.4rem 0.75rem;
    background: var(--danger-pale); border: 1px solid var(--danger-border);
    border-radius: 6px; margin-top: 0.5rem; display: none;
}
.rp-error.show { display: block; }

@media (max-width: 560px) {
    .rp-cat-grid { grid-template-columns: 1fr; }
    .rp-hero-title { font-size: 1.25rem; }
    .rp-submit-row { flex-direction: column-reverse; align-items: stretch; }
    .rp-submit-btn, .rp-cancel-btn { justify-content: center; }
}
</style>
@endpush

@section('content')
<div class="rp-page">

    {{-- Back --}}
    <a href="{{ $backRoute }}" class="rp-back">← Back to Order</a>

    {{-- Hero Banner --}}
    <div class="rp-hero">
        <div class="rp-hero-inner">
            <div class="rp-hero-icon">⚠️</div>
            <div>
                <div class="rp-hero-eyebrow">BakeSphere Safety</div>
                <div class="rp-hero-title">Report {{ $isBaker ? 'Customer' : 'Baker' }}</div>
                <div class="rp-hero-sub">Help us keep BakeSphere safe — reports are reviewed by our admin team within 24–48 hours.</div>
            </div>
        </div>
    </div>

    {{-- Reported Party Card --}}
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
            <div class="rp-subject-role">
                <span>{{ $isBaker ? 'Customer' : 'Baker' }}</span>
                {{ $reportedUser->email }}
            </div>
        </div>
        <div class="rp-order-pill">
            #{{ $orderId }}
            <small>Order Ref.</small>
        </div>
    </div>

    {{-- Warning --}}
    <div class="rp-warning">
        <span class="rp-warning-icon">⚠️</span>
        <div><strong>Important:</strong> False reports are taken seriously and may result in account suspension. Only submit if you have a genuine concern. All reports are anonymous to the reported party.</div>
    </div>

    {{-- Form --}}
    @if($errors->any())
    <div class="rp-warning" style="border-color:var(--danger-border); background:var(--danger-pale); color:var(--danger-deep);">
        <span class="rp-warning-icon">❌</span>
        <div>
            <strong>Please fix the following:</strong>
            <ul style="margin:0.4rem 0 0 1rem; font-size:0.78rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form id="report-form" method="POST" action="{{ route('report.store', $bakerOrder->id) }}" enctype="multipart/form-data">
        @csrf

        {{-- Category --}}
        <div class="rp-card">
            <div class="rp-card-header">
                <div class="rp-card-header-icon">📋</div>
                <div class="rp-card-title">What is your complaint about?</div>
                <span class="rp-required">Required</span>
            </div>
            <div class="rp-cat-grid">
                @foreach($categories as $value => $cat)
                <div>
                    <input class="rp-cat-option" type="radio" name="category" id="cat_{{ $value }}" value="{{ $value }}"
                           {{ old('category') === $value ? 'checked' : '' }}>
                    <label class="rp-cat-label" for="cat_{{ $value }}">
                        <span class="rp-cat-emoji">{{ $cat['icon'] }}</span>
                        <span class="rp-cat-text">{{ $cat['label'] }}</span>
                        <span class="rp-cat-check">✓</span>
                    </label>
                </div>
                @endforeach
            </div>
            <div id="cat-error" class="rp-error" style="margin: 0 1.5rem 1rem;">Please select a complaint category.</div>
        </div>

        {{-- Description --}}
        <div class="rp-card">
            <div class="rp-card-header">
                <div class="rp-card-header-icon">✍️</div>
                <div class="rp-card-title">Describe what happened</div>
                <span class="rp-required">Required</span>
            </div>
            <div class="rp-textarea-wrap">
    <textarea class="rp-textarea" name="description" id="rp-desc" maxlength="2000"
                    placeholder="Please describe the issue in detail. Include any relevant dates, amounts, or specific incidents that occurred…"
                    rows="5">{{ old('description') }}</textarea>
                <div class="rp-char-count" id="char-count">0 / 2000 characters</div>
                <div id="desc-error" class="rp-error">Please describe what happened (at least 10 characters).</div>
            </div>
        </div>

        {{-- Screenshot --}}
        <div class="rp-card">
            <div class="rp-card-header">
                <div class="rp-card-header-icon">📸</div>
                <div class="rp-card-title">Attach Screenshot</div>
                <span style="margin-left:auto; font-size:0.62rem; color:var(--text-muted); font-weight:500;">Optional but helpful</span>
            </div>
            <div class="rp-file-wrap">
                <div class="rp-dropzone" id="rp-dropzone">
                    <input type="file" name="screenshot" accept=".jpg,.jpeg,.png,.webp,.pdf"
                           onchange="handleReportFile(this)">
                    <div class="rp-dz-icon" id="rp-dz-icon">📎</div>
                    <div>
                        <div class="rp-dz-title" id="rp-dz-title">Click to upload screenshot</div>
                        <div class="rp-dz-sub" id="rp-dz-sub">JPG, PNG, PDF · max 5 MB</div>
                    </div>
                    <img class="rp-file-preview" id="rp-file-preview" src="" alt="">
                    <span class="rp-file-name" id="rp-file-name"></span>
                    <span class="rp-file-badge" id="rp-file-badge">✓ Ready</span>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="rp-submit-row">
            <a href="{{ $backRoute }}" class="rp-cancel-btn">← Go Back</a>
            <p class="rp-submit-note">Your identity will not be revealed to the reported party. We take every report seriously.</p>
            <button type="submit" class="rp-submit-btn" id="rp-submit" onclick="return validateReport()">
                ⚠️ Submit Report
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
    const btn = document.getElementById('rp-submit');
    if (btn) { btn.disabled = false; btn.innerHTML = '⚠️ Submit Report'; }
    @endif
});
// Character counter
const descEl   = document.getElementById('rp-desc');
const countEl  = document.getElementById('char-count');
function updateCount() {
    const len = descEl.value.length;
countEl.textContent = len + ' / 2000 characters';
countEl.classList.toggle('warn', len > 1800);
}
descEl.addEventListener('input', updateCount);
updateCount();

// File handler
function handleReportFile(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const isImage = file.type.startsWith('image/');
    const dropzone = document.getElementById('rp-dropzone');
    dropzone.classList.add('has-file');
    document.getElementById('rp-dz-title').textContent = file.name;
    document.getElementById('rp-dz-sub').textContent   = (file.size / 1024).toFixed(0) + ' KB';
    document.getElementById('rp-dz-icon').textContent  = isImage ? '🖼️' : '📄';
    document.getElementById('rp-file-badge').style.display = 'inline-block';
    if (isImage) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('rp-file-preview');
            prev.src = e.target.result;
            prev.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Validation
function validateReport() {
    let ok = true;
    const catSelected = document.querySelector('input[name="category"]:checked');
    const catErr  = document.getElementById('cat-error');
    const descErr = document.getElementById('desc-error');

    if (!catSelected) {
        catErr.classList.add('show');
        ok = false;
    } else {
        catErr.classList.remove('show');
    }

    const desc = descEl.value.trim();
    if (desc.length < 10) {
        descErr.classList.add('show');
        ok = false;
    } else {
        descErr.classList.remove('show');
    }

if (ok) {
    const btn = document.getElementById('rp-submit');
    btn.disabled = true;
    btn.innerHTML = '⏳ Submitting…';
    document.getElementById('report-form').submit();
}
return false;
}
</script>
@endsection