@extends($isBaker ? 'layouts.baker' : 'layouts.customer')
{{--
    Shared Report Form — works for baker (reporting customer) AND customer (reporting baker)
    Route: /report/order/{bakerOrder}
    Controller passes: $bakerOrder, $isBaker (bool), $reportedUser
    Styled in the same cake-atelier ledger language as Notifications, Bids, Orders and Wallet.
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
    $backRoute  = $isBaker
        ? route('baker.orders.show', $bakerOrder->id)
        : route('customer.cake-requests.show', $bakerOrder->cake_request_id);

    // ── SVG helper + icon set (same stroke style as the notifications page) ──
    $ico = fn ($paths, $s = 20, $w = '1.75') => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="'.$w.'" stroke-linecap="round" stroke-linejoin="round">'.$paths.'</svg>';
    $catIcons = [
        'no_show'         => '<circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>',
        'payment_fraud'   => '<rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
        'fake_proof'      => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/>',
        'harassment'      => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'order_abandoned' => '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
        'poor_quality'    => '<path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/>',
        'other'           => '<circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>',
    ];
    $icoBack   = $ico('<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>', 12, '2.5');
    $icoAlert  = $ico('<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>', 16, '2');
    $icoWarn   = $ico('<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>', 14, '2.25');
    $icoUpload = $ico('<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>', 20);
    $icoCheck  = $ico('<polyline points="20 6 9 17 4 12"/>', 20, '2');
    $icoLock   = $ico('<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>', 14, '2');
    $icoCoin   = $ico('<circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/>', 20);
@endphp

@section('title', 'Report ' . ($isBaker ? 'Customer' : 'Baker') . ' — #' . $orderId)

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* Report form: same cake-atelier ledger language as Notifications, Bids, Orders and Wallet. Plus Jakarta Sans only. */
.report-page{
--esp:#24150F;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;--sage-d:#33502F;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;padding-bottom:5rem;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.report-page *{box-sizing:border-box;font-family:inherit}
.report-page svg{flex-shrink:0}
.report-page a:focus-visible,.report-page button:focus-visible,.report-page textarea:focus-visible,
.report-page .rp-radio:focus-visible + .rp-cat,.report-page .rp-dz input:focus-visible + .rp-dz-icon{outline:2px solid var(--gold);outline-offset:3px}
@keyframes rp-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes rp-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes rp-spin{to{transform:rotate(360deg)}}
@media(prefers-reduced-motion:reduce){.report-page *,.report-page *::before,.report-page *::after{animation:none!important;transition:none!important}}

/* back link */
.rp-back{display:inline-flex;align-items:center;gap:.4rem;margin-bottom:1.5rem;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--caramel);text-decoration:none;border-bottom:1px solid var(--gold-line);padding-bottom:1px;transition:color .3s,border-color .3s}
.rp-back:hover{color:var(--esp);border-color:var(--esp);text-decoration:none}

/* header */
.rp-header{position:relative;margin:0 0 2rem;padding-bottom:1.75rem;animation:rp-fadeUp .6s var(--e) backwards}
.rp-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.rp-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:rp-line .9s var(--e) .3s backwards}
.rp-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.rp-sub{margin:1rem 0 0;max-width:56ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* two columns: the form fills the left, guidance sits on the right */
.rp-layout{display:grid;grid-template-columns:minmax(0,1fr) 380px;gap:3.5rem;align-items:start}
.rp-body{min-width:0;animation:rp-fadeUp .6s var(--e) .15s backwards}
.rp-aside{position:sticky;top:1.5rem;animation:rp-fadeUp .6s var(--e) .3s backwards}
.rp-aside-block{padding:1.25rem 0 1.75rem;border-top:1px solid var(--esp)}
.rp-aside-block + .rp-aside-block{margin-top:1rem}
.rp-aside-title{margin:0 0 .5rem;font-size:1rem;font-weight:800;letter-spacing:-.02em}
.rp-steps,.rp-tips{list-style:none;margin:0;padding:0}
.rp-steps li{display:grid;grid-template-columns:auto minmax(0,1fr);gap:1rem;padding:1rem 0;border-bottom:1px solid var(--line)}
.rp-step-n{width:30px;height:30px;display:flex;align-items:center;justify-content:center;background:var(--esp);color:var(--gold-l);font-size:.78rem;font-weight:900}
.rp-step-t{font-size:.9rem;font-weight:800;letter-spacing:-.01em;line-height:1.3}
.rp-step-d{margin-top:.2rem;font-size:.82rem;line-height:1.55;color:var(--mocha)}
.rp-tips li{position:relative;padding:.9rem 0 .9rem 1.5rem;border-bottom:1px solid var(--line);font-size:.86rem;line-height:1.6;color:var(--mocha)}
.rp-tips li::before{content:"";position:absolute;left:.15rem;top:1.3rem;width:7px;height:7px;background:var(--gold);transform:rotate(45deg)}
.rp-tips strong{color:var(--esp);font-weight:800}
@media(max-width:1100px){
    .rp-layout{grid-template-columns:minmax(0,1fr);gap:2rem}
    .rp-aside{position:static}
}

/* reported party: a ledger row */
.rp-subject{display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:1.25rem;padding:1.25rem 1.25rem 1.25rem 0;border-top:1px solid var(--esp);border-bottom:1px solid var(--line)}
.rp-avatar{width:48px;height:48px;display:flex;align-items:center;justify-content:center;background:var(--esp);color:var(--gold-l);font-size:1.1rem;font-weight:900;overflow:hidden}
.rp-avatar img{width:100%;height:100%;object-fit:cover}
.rp-subject-name{font-size:.98rem;font-weight:800;letter-spacing:-.02em;line-height:1.3}
.rp-subject-meta{display:flex;align-items:center;flex-wrap:wrap;gap:.6rem;margin-top:.35rem;font-size:.8rem;color:var(--mocha);word-break:break-all}
.rp-tag{display:inline-flex;align-items:center;padding:.22rem .5rem;background:var(--esp);color:var(--gold-l);font-size:.52rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase}
.rp-order{text-align:right}
.rp-order-num{font-size:1.15rem;font-weight:900;letter-spacing:-.03em;color:var(--caramel)}
.rp-order-label{margin-top:.15rem;font-size:.52rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe)}

/* notice / errors: bordered bar with a colored edge */
.rp-alert{position:relative;display:flex;align-items:flex-start;gap:.75rem;margin:1.5rem 0 0;padding:1rem 1.25rem 1rem 1.5rem;background:#F8F1E2;border-bottom:1px solid var(--line);font-size:.86rem;line-height:1.6;color:var(--mocha)}
.rp-alert::before{content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold)}
.rp-alert svg{margin-top:2px;color:var(--credit)}
.rp-alert strong{color:var(--esp);font-weight:800}
.rp-alert.error{background:#F6ECEA;color:var(--burg)}
.rp-alert.error::before{background:var(--burg)}
.rp-alert.error svg{color:var(--burg)}
.rp-alert ul{margin:.35rem 0 0 1rem;padding:0}

/* sections */
.rp-section{padding:1.75rem 0;border-bottom:1px solid var(--line)}
.rp-label{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.6rem;margin:0 0 1rem;font-size:1rem;font-weight:800;letter-spacing:-.02em}
.rp-label-main{display:inline-flex;align-items:center;gap:.6rem}
.rp-req{width:7px;height:7px;background:var(--gold);transform:rotate(45deg);flex-shrink:0}
.rp-opt{font-size:.74rem;font-weight:600;letter-spacing:0;color:var(--taupe)}

/* category list */
.rp-cats{border-top:1px solid var(--esp)}
.rp-cat-wrap{position:relative}
.rp-radio{position:absolute;opacity:0;width:1px;height:1px;pointer-events:none}
.rp-cat{position:relative;display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;gap:1.25rem;padding:1rem 1.25rem 1rem 1.5rem;border-bottom:1px solid var(--line);cursor:pointer;transition:background .3s}
.rp-cat:hover{background:rgba(239,230,215,.5)}
.rp-icon{width:42px;height:42px;display:flex;align-items:center;justify-content:center;border:1px solid var(--beige);background:var(--cream);color:var(--mocha);transition:background .3s,color .3s,border-color .3s}
.rp-cat-text{font-size:.94rem;font-weight:700;letter-spacing:-.01em;color:var(--esp)}
.rp-mark{width:9px;height:9px;border:1px solid var(--taupe);transform:rotate(45deg);transition:background .25s,border-color .25s}
.rp-radio:checked + .rp-cat{background:#F8F1E2}
.rp-radio:checked + .rp-cat::before{content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold)}
.rp-radio:checked + .rp-cat .rp-icon{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.rp-radio:checked + .rp-cat .rp-mark{background:var(--gold);border-color:var(--gold)}

/* textarea */
.rp-textarea{display:block;width:100%;min-height:150px;padding:1rem 1.1rem;background:var(--w);border:1px solid var(--beige);border-radius:0;font-size:.92rem;line-height:1.7;color:var(--esp);resize:vertical;transition:border-color .25s,background .25s}
.rp-textarea::placeholder{color:var(--taupe)}
.rp-textarea:hover{border-color:var(--taupe)}
.rp-textarea:focus{outline:none;border-color:var(--esp);background:#fff}
.rp-hint{display:flex;justify-content:space-between;align-items:center;gap:1rem;margin-top:.6rem;font-size:.74rem;font-weight:600;color:var(--taupe)}
.rp-count.warn{color:var(--burg);font-weight:800}

/* upload */
.rp-dz{position:relative;display:flex;align-items:center;gap:1.1rem;padding:1rem 1.25rem;background:var(--w);border:1px dashed var(--taupe);cursor:pointer;transition:background .3s,border-color .3s}
.rp-dz:hover{background:rgba(239,230,215,.5);border-color:var(--esp)}
.rp-dz.has-file{border-style:solid;border-color:var(--gold-line);background:#F8F1E2}
.rp-dz input[type="file"]{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
.rp-dz-icon{width:42px;height:42px;display:flex;align-items:center;justify-content:center;border:1px solid var(--beige);background:var(--cream);color:var(--mocha)}
.rp-dz.has-file .rp-dz-icon{background:#EFF2E8;border-color:rgba(94,127,90,.35);color:var(--sage-d)}
.rp-dz-title{font-size:.9rem;font-weight:800;letter-spacing:-.01em;word-break:break-all}
.rp-dz-sub{margin-top:.15rem;font-size:.76rem;color:var(--mocha)}
.rp-preview{display:none;width:42px;height:42px;object-fit:cover;border:1px solid var(--beige);margin-left:auto}
.rp-attached{display:none;align-items:center;margin-left:auto;padding:.22rem .5rem;background:var(--esp);color:var(--gold-l);font-size:.52rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase}

/* refund request */
.rp-refund{display:none;position:relative;margin-top:1.75rem;padding:1.25rem 1.25rem 1.25rem 1.5rem;background:#F8F1E2;border-bottom:1px solid var(--line)}
.rp-refund::before{content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold)}
.rp-refund-head{display:flex;align-items:center;gap:.7rem;margin-bottom:.75rem;color:var(--credit)}
.rp-refund-title{font-size:1rem;font-weight:800;letter-spacing:-.02em;color:var(--esp)}
.rp-refund-note{margin:0 0 1rem;max-width:70ch;font-size:.86rem;line-height:1.6;color:var(--mocha)}
.rp-check{display:flex;align-items:flex-start;gap:.8rem;cursor:pointer}
.rp-check input{width:18px;height:18px;margin-top:2px;accent-color:var(--burg);flex-shrink:0}
.rp-check-title{font-size:.9rem;font-weight:800;letter-spacing:-.01em}
.rp-check-sub{margin-top:.2rem;font-size:.8rem;line-height:1.5;color:var(--mocha)}

/* inline validation */
.rp-error{display:none;align-items:center;gap:.4rem;margin-top:.7rem;font-size:.8rem;font-weight:700;color:var(--burg)}
.rp-error.show{display:flex}

/* footer + buttons */
.rp-footer{display:flex;align-items:center;flex-wrap:wrap;gap:1rem;margin-top:2rem}
.rp-note{flex:1;min-width:200px;display:flex;align-items:center;gap:.5rem;font-size:.78rem;line-height:1.5;color:var(--taupe)}
.rp-btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;height:36px;padding:0 .95rem;background:var(--w);border:1px solid var(--esp);border-radius:0;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);text-decoration:none;white-space:nowrap;cursor:pointer;transition:background .25s,color .25s,border-color .25s}
.rp-btn:hover{background:var(--esp);color:var(--gold-l);text-decoration:none}
.rp-btn.submit{height:42px;padding:0 1.3rem;background:var(--burg);border-color:var(--burg);color:var(--ivory)}
.rp-btn.submit:hover:not(:disabled){background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.rp-btn:disabled{opacity:.5;cursor:not-allowed}
.rp-spin{animation:rp-spin .7s linear infinite}

@media(max-width:720px){
    .rp-subject{grid-template-columns:auto minmax(0,1fr);row-gap:.9rem;padding-right:0}
    .rp-order{grid-column:1 / -1;display:flex;align-items:baseline;justify-content:space-between;text-align:left}
    .rp-cat{gap:1rem;padding:.95rem 1rem .95rem 1.25rem}
    .rp-icon{width:38px;height:38px}
    .rp-footer{flex-direction:column-reverse;align-items:stretch}
    .rp-btn{justify-content:center}
    .rp-note{min-width:0}
}
</style>
@endpush

@section('content')
<div class="report-page">

    {{-- Back --}}
    <a href="{{ $backRoute }}" class="rp-back">{!! $icoBack !!} Back to order</a>

    {{-- Page header --}}
    <div class="rp-header">
        <h1 class="rp-title">Report {{ $isBaker ? 'Customer' : 'Baker' }}</h1>
        <p class="rp-sub">Help us keep BakeSphere safe. Our admin team reviews every report within 24–48 hours.</p>
    </div>

    <div class="rp-layout">
    <div class="rp-body">

        {{-- Reported party --}}
        <div class="rp-subject">
            <div class="rp-avatar">
                @if($reportedUser->profile_photo)
                    <img src="{{ str_starts_with($reportedUser->profile_photo, 'http') ? $reportedUser->profile_photo : asset('storage/'.$reportedUser->profile_photo) }}" alt="">
                @else
                    {{ strtoupper(substr($reportedUser->first_name, 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="rp-subject-name">{{ $reportedUser->first_name }} {{ $reportedUser->last_name }}</div>
                <div class="rp-subject-meta">
                    <span class="rp-tag">{{ $isBaker ? 'Customer' : 'Baker' }}</span>
                    {{ $reportedUser->email }}
                </div>
            </div>
            <div class="rp-order">
                <div class="rp-order-num">#{{ $orderId }}</div>
                <div class="rp-order-label">Order ref.</div>
            </div>
        </div>

        {{-- Warning notice --}}
        <div class="rp-alert">
            {!! $icoAlert !!}
            <div><strong>Important:</strong> False reports are taken seriously and may result in account suspension. Only submit if you have a genuine concern. All reports are anonymous to the reported party.</div>
        </div>

        {{-- Server validation errors --}}
        @if($errors->any())
        <div class="rp-alert error">
            {!! $icoAlert !!}
            <div>
                <strong>Please fix the following:</strong>
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
        @endif

        <form id="report-form" method="POST" action="{{ route('report.store', $bakerOrder->id) }}" enctype="multipart/form-data">
            @csrf

            {{-- Category --}}
            <div class="rp-section">
                <div class="rp-label"><span class="rp-label-main"><span class="rp-req"></span>What is your complaint about?</span></div>
                <div class="rp-cats" role="radiogroup">
                    @foreach($categories as $value => $cat)
                    <div class="rp-cat-wrap">
                        <input class="rp-radio" type="radio" name="category" id="cat_{{ $value }}" value="{{ $value }}" {{ old('category') === $value ? 'checked' : '' }}>
                        <label class="rp-cat" for="cat_{{ $value }}">
                            <span class="rp-icon">{!! $ico($catIcons[$value] ?? $catIcons['other'], 18) !!}</span>
                            <span class="rp-cat-text">{{ $cat['label'] }}</span>
                            <span class="rp-mark"></span>
                        </label>
                    </div>
                    @endforeach
                </div>
                <div id="cat-error" class="rp-error">{!! $ico('<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>', 14, '2.25') !!} Choose a complaint category.</div>
            </div>

            {{-- Description --}}
            <div class="rp-section">
                <div class="rp-label"><span class="rp-label-main"><span class="rp-req"></span>Describe what happened</span></div>
                <textarea class="rp-textarea" name="description" id="rp-desc" maxlength="2000" rows="5"
                    placeholder="Include relevant dates, amounts or specific incidents…">{{ old('description') }}</textarea>
                <div class="rp-hint">
                    <span>Minimum 10 characters</span>
                    <span class="rp-count" id="char-count">0 / 2000</span>
                </div>
                <div id="desc-error" class="rp-error">{!! $ico('<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>', 14, '2.25') !!} Describe what happened in at least 10 characters.</div>
            </div>

            {{-- Screenshot --}}
            <div class="rp-section">
                <div class="rp-label">
                    <span class="rp-label-main">Attach a screenshot</span>
                    <span class="rp-opt">Optional, helps with the investigation</span>
                </div>
                <div class="rp-dz" id="rp-dropzone">
                    <input type="file" name="screenshot" accept=".jpg,.jpeg,.png,.webp,.pdf" onchange="handleReportFile(this)">
                    <div class="rp-dz-icon">
                        <span id="rp-dz-svg-default">{!! $icoUpload !!}</span>
                        <span id="rp-dz-svg-done" style="display:none;">{!! $icoCheck !!}</span>
                    </div>
                    <div>
                        <div class="rp-dz-title" id="rp-dz-title">Click to upload a screenshot</div>
                        <div class="rp-dz-sub" id="rp-dz-sub">JPG, PNG, PDF · max 5 MB</div>
                    </div>
                    <img class="rp-preview" id="rp-file-preview" src="" alt="">
                    <div class="rp-attached" id="rp-file-ok">Attached</div>
                </div>
            </div>

            {{-- Refund request (customer only) --}}
            @if(!$isBaker)
            <div class="rp-refund" id="refund-request-card">
                <div class="rp-refund-head">
                    {!! $icoCoin !!}
                    <div class="rp-refund-title">Request a refund?</div>
                </div>
                <p class="rp-refund-note">Downpayments are non-refundable under normal circumstances. If your baker missed the agreed deadline, you can request a refund review. Our admin team will investigate and decide based on the evidence.</p>
                <label class="rp-check">
                    <input type="checkbox" name="request_refund" id="request_refund" value="1">
                    <div>
                        <div class="rp-check-title">Yes, I want to request a refund</div>
                        <div class="rp-check-sub">Admin reviews your evidence and decides. Approved refunds are credited to your BakeSphere wallet.</div>
                    </div>
                </label>
            </div>
            <script>
            const refundEligibleCats = ['no_show', 'order_abandoned'];
            function syncRefundCard() {
                const picked = document.querySelector('input[name="category"]:checked');
                const card = document.getElementById('refund-request-card');
                const show = picked && refundEligibleCats.includes(picked.value);
                card.style.display = show ? 'block' : 'none';
                if (!show) document.getElementById('request_refund').checked = false;
            }
            document.querySelectorAll('input[name="category"]').forEach(r => r.addEventListener('change', syncRefundCard));
            syncRefundCard();
            </script>
            @endif

            {{-- Footer --}}
            <div class="rp-footer">
                <a href="{{ $backRoute }}" class="rp-btn">{!! $icoBack !!} Go back</a>
                <div class="rp-note">{!! $icoLock !!} Your identity will not be revealed to the reported party.</div>
                <button type="submit" class="rp-btn submit" id="rp-submit" onclick="return validateReport()">{!! $icoWarn !!} Submit report</button>
            </div>
        </form>
    </div>

    {{-- Guidance column --}}
    <aside class="rp-aside">
        <div class="rp-aside-block">
            <h2 class="rp-aside-title">What happens next</h2>
            <ol class="rp-steps">
                <li>
                    <span class="rp-step-n">1</span>
                    <div>
                        <div class="rp-step-t">Your report is sent to admin</div>
                        <div class="rp-step-d">It is anonymous to the {{ $isBaker ? 'customer' : 'baker' }} you are reporting.</div>
                    </div>
                </li>
                <li>
                    <span class="rp-step-n">2</span>
                    <div>
                        <div class="rp-step-t">Admin reviews the evidence</div>
                        <div class="rp-step-d">Every report is reviewed within 24–48 hours.</div>
                    </div>
                </li>
                <li>
                    <span class="rp-step-n">3</span>
                    <div>
                        <div class="rp-step-t">Admin decides the outcome</div>
                        <div class="rp-step-d">
                            @if($isBaker)
                                Action is taken on the account if the report is upheld.
                            @else
                                Action is taken on the account if the report is upheld. Approved refunds are credited to your BakeSphere wallet.
                            @endif
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <div class="rp-aside-block">
            <h2 class="rp-aside-title">Make your report count</h2>
            <ul class="rp-tips">
                <li><strong>Be specific.</strong> Include dates, amounts and what was agreed.</li>
                <li><strong>Attach proof.</strong> A screenshot of the chat or receipt speeds up the review.</li>
                <li><strong>Stick to the facts.</strong> Describe what happened on order #{{ $orderId }} only.</li>
            </ul>
        </div>
    </aside>
    </div>
</div>

<script>
const SUBMIT_LABEL = @json('Submit report');
const SUBMIT_ICON  = @json($icoWarn);

document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
    const btn = document.getElementById('rp-submit');
    if (btn) { btn.disabled = false; btn.innerHTML = SUBMIT_ICON + ' ' + SUBMIT_LABEL; }
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
    document.getElementById('rp-dropzone').classList.add('has-file');
    document.getElementById('rp-dz-title').textContent = file.name;
    document.getElementById('rp-dz-sub').textContent   = (file.size / 1024).toFixed(0) + ' KB';
    document.getElementById('rp-dz-svg-default').style.display = 'none';
    document.getElementById('rp-dz-svg-done').style.display    = 'inline-flex';

    const okEl = document.getElementById('rp-file-ok');
    okEl.style.display = 'inline-flex';

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('rp-file-preview');
            prev.src = e.target.result;
            prev.style.display = 'block';
            okEl.style.display = 'none'; // hide badge when the preview is visible
        };
        reader.readAsDataURL(file);
    }
}

function validateReport() {
    let ok = true;
    const catSelected = document.querySelector('input[name="category"]:checked');
    document.getElementById('cat-error').classList.toggle('show', !catSelected);
    if (!catSelected) ok = false;

    const tooShort = descEl.value.trim().length < 10;
    document.getElementById('desc-error').classList.toggle('show', tooShort);
    if (tooShort) ok = false;

    if (ok) {
        const btn = document.getElementById('rp-submit');
        btn.disabled = true;
        btn.innerHTML = '<svg class="rp-spin" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Submitting…';
        document.getElementById('report-form').submit();
    }
    return false;
}
</script>
@endsection