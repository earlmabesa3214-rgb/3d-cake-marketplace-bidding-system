@extends('layouts.admin')
@section('title', 'Transaction #' . str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<style>
:root {
    --gold:#C07828; --gold-light:#E0A050; --gold-soft:#FDF2E4;
    --teal:#277A6E; --teal-soft:#E5F2F0;
    --rose:#B83C44; --rose-soft:#FDEAEB;
    --espresso:#341C08; --text-primary:#2A1806;
    --text-muted:#9C7850; --border:#E5DDD0;
    --surface:#FFF; --surface-2:#FAF7F2; --surface-3:#F2ECE2;
}
.back-link { display:inline-flex; align-items:center; gap:0.4rem; font-size:0.82rem; color:var(--text-muted); text-decoration:none; margin-bottom:1.25rem; transition:color 0.2s; font-family:'Plus Jakarta Sans',sans-serif; }
.back-link:hover { color:var(--gold); }

/* HERO */
.tx-hero {
    background:linear-gradient(135deg,#341C08,#6A3A18);
    border-radius:20px; padding:1.75rem 2rem; color:white;
    margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; gap:1rem;
    position:relative; overflow:hidden;
}
.tx-hero::before { content:''; position:absolute; right:-40px; top:-40px; width:200px; height:200px; border-radius:50%; background:rgba(255,255,255,0.04); }
.th-id   { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; font-weight:800; margin-bottom:0.2rem; }
.th-sub  { font-size:0.78rem; opacity:0.6; font-family:'Plus Jakarta Sans',sans-serif; }
.th-price { text-align:right; }
.th-price-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:2rem; font-weight:800; color:#FFD49A; }
.th-price-label { font-size:0.65rem; opacity:0.5; text-transform:uppercase; letter-spacing:0.1em; font-family:'Plus Jakarta Sans',sans-serif; }

/* STATUS BADGE */
.status-pill { display:inline-flex; align-items:center; gap:0.3rem; padding:0.3rem 0.85rem; border-radius:20px; font-size:0.72rem; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; }
.pill-ACCEPTED            { background:#FEF9E8; color:#9B6A10; border:1px solid #EDD090; }
.pill-WAITING_FOR_PAYMENT { background:#FEF2E4; color:#8A4010; border:1px solid #E8C080; }
.pill-PREPARING           { background:#EBF3FE; color:#1A5A8A; border:1px solid #B8D4F0; }
.pill-READY               { background:#EBF5EE; color:#166534; border:1px solid #B8DFC6; }
.pill-WAITING_FINAL_PAYMENT { background:#FEF9E8; color:#9B6A10; border:1px solid #EDD090; }
.pill-DELIVERED           { background:#EBF5EE; color:#166534; border:1px solid #B8DFC6; }
.pill-COMPLETED           { background:#EBF5EE; color:#166534; border:1px solid #B8DFC6; }
.pill-CANCELLED           { background:var(--rose-soft); color:var(--rose); border:1px solid rgba(184,60,68,0.3); }

.layout { display:grid; grid-template-columns:1fr 320px; gap:1.5rem; align-items:start; }

/* CARDS */
.card { background:var(--surface); border:1.5px solid var(--border); border-radius:16px; overflow:hidden; margin-bottom:1.5rem; }
.card:last-child { margin-bottom:0; }
.card-header { padding:1rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:0.6rem; background:var(--surface-2); }
.card-header h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:0.95rem; color:var(--espresso); margin:0; font-weight:700; }

/* PARTIES */
.party-row { display:flex; gap:1rem; padding:1.25rem 1.5rem; }
.party-box { flex:1; padding:1rem 1.25rem; border-radius:12px; border:1.5px solid var(--border); background:var(--surface-2); }
.party-box.customer-box { border-color:#D4B896; background:#FBF4EC; }
.party-box.baker-box    { border-color:#C8C0B0; background:var(--surface-3); }
.pb-label { font-size:0.6rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--text-muted); font-weight:700; margin-bottom:0.65rem; font-family:'Plus Jakarta Sans',sans-serif; }
.pb-avatar { width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#C07840,#E8A96A); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem; flex-shrink:0; overflow:hidden; margin-bottom:0.6rem; }
.pb-avatar img { width:100%; height:100%; object-fit:cover; }
.pb-name  { font-weight:700; font-size:0.88rem; color:var(--espresso); font-family:'Plus Jakarta Sans',sans-serif; }
.pb-email { font-size:0.72rem; color:var(--text-muted); margin-top:0.15rem; font-family:'Plus Jakarta Sans',sans-serif; }

/* DETAIL ROWS */
.detail-row { display:flex; justify-content:space-between; align-items:center; padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); gap:1rem; }
.detail-row:last-child { border-bottom:none; }
.d-key { font-size:0.68rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; }
.d-val { font-size:0.85rem; color:var(--text-primary); font-weight:500; text-align:right; font-family:'Plus Jakarta Sans',sans-serif; }

/* PAYMENT CARDS */
.payment-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; padding:1.25rem 1.5rem; }
.pay-card { border-radius:12px; padding:1rem; border:1.5px solid var(--border); }
.pay-card.paid     { border-color:#B8DFC6; background:#EBF5EE; }
.pay-card.pending  { border-color:#EDD090; background:#FEF9E8; }
.pay-card.rejected { border-color:#F5C5BE; background:#FDF0EE; }
.pay-card.none     { background:var(--surface-2); opacity:0.6; }
.pay-card-label  { font-size:0.62rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:700; margin-bottom:0.5rem; font-family:'Plus Jakarta Sans',sans-serif; }
.pay-card-amount { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.3rem; font-weight:800; color:var(--espresso); margin-bottom:0.35rem; }
.pay-card-status { font-size:0.72rem; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; }
.pay-card.paid     .pay-card-status { color:#166534; }
.pay-card.pending  .pay-card-status { color:#9B6A10; }
.pay-card.rejected .pay-card-status { color:var(--rose); }
.pay-proof { margin-top:0.5rem; }
.pay-proof a { font-size:0.7rem; color:var(--gold); font-weight:600; text-decoration:none; font-family:'Plus Jakarta Sans',sans-serif; }
.pay-proof a:hover { text-decoration:underline; }

/* CAKE CONFIG */
.config-grid { display:grid; grid-template-columns:1fr 1fr; }
.config-item { padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); border-right:1px solid var(--border); }
.config-item:nth-child(even) { border-right:none; }
.config-item:nth-last-child(-n+2) { border-bottom:none; }
.c-label { font-size:0.63rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:600; margin-bottom:0.2rem; font-family:'Plus Jakarta Sans',sans-serif; }
.c-value { font-size:0.86rem; font-weight:600; color:var(--espresso); font-family:'Plus Jakarta Sans',sans-serif; }

/* PROGRESS STEPS */
.progress-wrap { padding:1.25rem 1.5rem; }
.steps { display:flex; align-items:flex-start; }
.step  { flex:1; display:flex; flex-direction:column; align-items:center; }
.step-row { display:flex; align-items:center; width:100%; }
.connector { flex:1; height:2px; }
.dot { width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.65rem; font-weight:700; flex-shrink:0; }
.dot.done    { background:var(--gold); color:white; }
.dot.active  { background:white; border:2.5px solid var(--gold); color:var(--gold); }
.dot.pending { background:var(--surface-3); border:2px solid var(--border); color:var(--text-muted); }
.step-label  { font-size:0.55rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-muted); margin-top:0.4rem; text-align:center; font-weight:600; font-family:'Plus Jakarta Sans',sans-serif; }
.step-label.active { color:var(--gold); }

/* CHAT */
.chat-wrap { padding:1.25rem 1.5rem; display:flex; flex-direction:column; gap:0.75rem; max-height:320px; overflow-y:auto; }
.chat-bubble { max-width:80%; }
.chat-bubble.left  { align-self:flex-start; }
.chat-bubble.right { align-self:flex-end; }
.bubble-inner { padding:0.65rem 0.9rem; border-radius:12px; font-size:0.82rem; line-height:1.5; font-family:'Plus Jakarta Sans',sans-serif; }
.chat-bubble.left  .bubble-inner { background:var(--surface-2); border:1px solid var(--border); color:var(--text-primary); }
.chat-bubble.right .bubble-inner { background:linear-gradient(135deg,var(--gold),var(--gold-light)); color:white; }
.bubble-meta { font-size:0.65rem; color:var(--text-muted); margin-top:0.25rem; font-family:'Plus Jakarta Sans',sans-serif; }
.chat-bubble.right .bubble-meta { text-align:right; }

/* TIMELINE */
.timeline { list-style:none; padding:0; }
.timeline li { padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:flex-start; gap:0.65rem; font-size:0.8rem; }
.timeline li:last-child { border-bottom:none; }
.tl-dot   { width:8px; height:8px; border-radius:50%; background:var(--gold); flex-shrink:0; margin-top:0.3rem; }
.tl-event { font-weight:600; color:var(--text-primary); font-family:'Plus Jakarta Sans',sans-serif; }
.tl-time  { font-size:0.7rem; color:var(--text-muted); margin-top:0.1rem; font-family:'Plus Jakarta Sans',sans-serif; }

.empty-chat { text-align:center; padding:2rem; color:var(--text-muted); font-size:0.82rem; font-family:'Plus Jakarta Sans',sans-serif; }
</style>
@endpush

@section('content')

<a href="{{ route('admin.transactions.index') }}" class="back-link">← All Transactions</a>

@php
    $config = is_array($bakerOrder->cakeRequest->cake_configuration)
        ? $bakerOrder->cakeRequest->cake_configuration
        : (json_decode($bakerOrder->cakeRequest->cake_configuration, true) ?? []);

    $payments = $bakerOrder->cakeRequest->payments ?? collect();
    $downpayment  = $payments->where('payment_type','downpayment')->first();
    $finalPayment = $payments->where('payment_type','final')->first();

    $statusSteps  = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED'];
    $stepLabels   = ['Accepted','Awaiting Down','Preparing','Ready','Awaiting Final','Delivered'];
    $stepIcons    = ['✓','💳','🥣','📦','💰','🚚'];
    $currentStep  = array_search($bakerOrder->status, $statusSteps);
    if ($currentStep === false) $currentStep = 0;

    $downStatus  = $downpayment  ? $downpayment->status  : 'none';
    $finalStatus = $finalPayment ? $finalPayment->status : 'none';
@endphp

{{-- HERO --}}
<div class="tx-hero">
    <div>
        <div class="th-id">Transaction #{{ str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div class="th-sub">
            Order #{{ str_pad($bakerOrder->cake_request_id, 4, '0', STR_PAD_LEFT) }} ·
            {{ $bakerOrder->created_at->format('M d, Y · g:i A') }}
        </div>
        <div style="margin-top:0.75rem;">
            <span class="status-pill pill-{{ $bakerOrder->status }}">
                {{ str_replace('_',' ', $bakerOrder->status) }}
            </span>
        </div>
    </div>
    <div class="th-price">
        <div class="th-price-label">Agreed Price</div>
        <div class="th-price-val">₱{{ number_format($bakerOrder->agreed_price, 0) }}</div>
    </div>
</div>

<div class="layout">
    {{-- LEFT --}}
    <div>
        {{-- Parties --}}
        <div class="card">
            <div class="card-header"><span>👥</span><h3>People Involved</h3></div>
            <div class="party-row">
                <div class="party-box customer-box">
                    <div class="pb-label">👤 Customer</div>
                    <div class="pb-avatar">
                        @if($bakerOrder->cakeRequest->user->profile_photo)
                            <img src="{{ asset('storage/'.$bakerOrder->cakeRequest->user->profile_photo) }}" alt="">
                        @else {{ strtoupper(substr($bakerOrder->cakeRequest->user->first_name,0,1)) }} @endif
                    </div>
                    <div class="pb-name">{{ $bakerOrder->cakeRequest->user->first_name }} {{ $bakerOrder->cakeRequest->user->last_name }}</div>
                    <div class="pb-email">{{ $bakerOrder->cakeRequest->user->email }}</div>
                </div>
                <div class="party-box baker-box">
                    <div class="pb-label">👨‍🍳 Baker</div>
                    <div class="pb-avatar" style="background:linear-gradient(135deg,#3B1F0F,#7A4A28);">
                        @if($bakerOrder->baker->profile_photo)
                            <img src="{{ asset('storage/'.$bakerOrder->baker->profile_photo) }}" alt="">
                        @else {{ strtoupper(substr($bakerOrder->baker->first_name,0,1)) }} @endif
                    </div>
                    <div class="pb-name">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</div>
                    <div class="pb-email">{{ $bakerOrder->baker->email }}</div>
                </div>
            </div>
        </div>

        {{-- Baking Progress --}}
        <div class="card">
            <div class="card-header"><span>📊</span><h3>Order Progress</h3></div>
            <div class="progress-wrap">
                <div class="steps">
                    @foreach($statusSteps as $i => $step)
                    <div class="step">
                        <div class="step-row">
                            @if($i > 0)
                            <div class="connector" style="background:{{ $i <= $currentStep ? 'var(--gold)' : 'var(--border)' }};"></div>
                            @endif
                            <div class="dot {{ $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : 'pending') }}">
                                {{ $i < $currentStep ? '✓' : $stepIcons[$i] }}
                            </div>
                            @if($i < count($statusSteps)-1)
                            <div class="connector" style="background:{{ $i < $currentStep ? 'var(--gold)' : 'var(--border)' }};"></div>
                            @endif
                        </div>
                        <div class="step-label {{ $i === $currentStep ? 'active' : '' }}">{{ $stepLabels[$i] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Payments --}}
        <div class="card">
            <div class="card-header"><span>💳</span><h3>Payments</h3></div>
            <div class="payment-grid">
                {{-- Downpayment --}}
                @php
                    $dpClass = $downpayment ? ($downpayment->status === 'paid' || $downpayment->status === 'confirmed' ? 'paid' : ($downpayment->status === 'rejected' ? 'rejected' : 'pending')) : 'none';
                @endphp
                <div class="pay-card {{ $dpClass }}">
                    <div class="pay-card-label">50% Downpayment</div>
                    <div class="pay-card-amount">₱{{ number_format($bakerOrder->agreed_price * 0.5, 0) }}</div>
                    @if($downpayment)
                        <div class="pay-card-status">
                            @if($dpClass === 'paid') ✓ Confirmed
                            @elseif($dpClass === 'rejected') ✕ Rejected ({{ $downpayment->rejection_count }}x)
                            @else ⏳ Pending Review
                            @endif
                        </div>
                        @if($downpayment->proof_path)
                        <div class="pay-proof">
                            <a href="{{ asset('storage/'.$downpayment->proof_path) }}" target="_blank">View Proof →</a>
                        </div>
                        @endif
                    @else
                        <div class="pay-card-status" style="color:var(--text-muted);">Not yet submitted</div>
                    @endif
                </div>

                {{-- Final Payment --}}
                @php
                    $fpClass = $finalPayment ? ($finalPayment->status === 'paid' || $finalPayment->status === 'confirmed' ? 'paid' : ($finalPayment->status === 'rejected' ? 'rejected' : 'pending')) : 'none';
                @endphp
                <div class="pay-card {{ $fpClass }}">
                    <div class="pay-card-label">50% Final Payment</div>
                    <div class="pay-card-amount">₱{{ number_format($bakerOrder->agreed_price * 0.5, 0) }}</div>
                    @if($finalPayment)
                        <div class="pay-card-status">
                            @if($fpClass === 'paid') ✓ Confirmed
                            @elseif($fpClass === 'rejected') ✕ Rejected ({{ $finalPayment->rejection_count }}x)
                            @else ⏳ Pending Review
                            @endif
                        </div>
                        @if($finalPayment->proof_path)
                        <div class="pay-proof">
                            <a href="{{ asset('storage/'.$finalPayment->proof_path) }}" target="_blank">View Proof →</a>
                        </div>
                        @endif
                    @else
                        <div class="pay-card-status" style="color:var(--text-muted);">🔒 On delivery</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Cake Config --}}
        <div class="card">
            <div class="card-header"><span>🎂</span><h3>Cake Configuration</h3></div>
            <div class="config-grid">
                @foreach(['flavor','shape','size','frosting'] as $key)
                @if(!empty($config[$key]))
                <div class="config-item">
                    <div class="c-label">{{ ucfirst($key) }}</div>
                    <div class="c-value">{{ $config[$key] }}</div>
                </div>
                @endif
                @endforeach
                @if(!empty($config['addons']))
                <div class="config-item" style="grid-column:1/-1; border-right:none;">
                    <div class="c-label">Add-ons</div>
                    <div class="c-value">{{ implode(', ', (array)$config['addons']) }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Chat Messages --}}
        <div class="card">
            <div class="card-header"><span>💬</span><h3>Chat History</h3></div>
            @if($bakerOrder->messages && $bakerOrder->messages->count())
            <div class="chat-wrap">
                @foreach($bakerOrder->messages as $msg)
                @php $isCustomer = $msg->sender_id === $bakerOrder->cakeRequest->user_id; @endphp
                <div class="chat-bubble {{ $isCustomer ? 'right' : 'left' }}">
                    <div class="bubble-inner">{{ $msg->message }}</div>
                    <div class="bubble-meta">
                        {{ $msg->sender->first_name ?? 'Unknown' }} · {{ $msg->created_at->format('M d, g:i A') }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-chat">💬 No messages exchanged yet.</div>
            @endif
        </div>
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>
        {{-- Order Summary --}}
        <div class="card" style="margin-bottom:1.5rem;">
            <div class="card-header"><span>📋</span><h3>Summary</h3></div>
            <div class="detail-row">
                <span class="d-key">Transaction ID</span>
                <span class="d-val" style="color:var(--gold); font-weight:700;">#{{ str_pad($bakerOrder->id,4,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span class="d-key">Request ID</span>
                <span class="d-val">#{{ str_pad($bakerOrder->cake_request_id,4,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span class="d-key">Status</span>
                <span class="d-val">
                    <span class="status-pill pill-{{ $bakerOrder->status }}" style="font-size:0.65rem;">
                        {{ str_replace('_',' ',$bakerOrder->status) }}
                    </span>
                </span>
            </div>
            <div class="detail-row">
                <span class="d-key">Agreed Price</span>
                <span class="d-val" style="font-weight:700;">₱{{ number_format($bakerOrder->agreed_price,0) }}</span>
            </div>
            <div class="detail-row">
                <span class="d-key">Delivery Date</span>
                <span class="d-val" style="color:var(--gold); font-weight:600;">{{ $bakerOrder->cakeRequest->delivery_date->format('M d, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="d-key">Created</span>
                <span class="d-val">{{ $bakerOrder->created_at->format('M d, Y') }}</span>
            </div>
            @if($bakerOrder->cancel_reason)
            <div class="detail-row" style="flex-direction:column; align-items:flex-start; gap:0.3rem;">
                <span class="d-key">Cancel Reason</span>
                <span style="font-size:0.8rem; color:var(--rose); line-height:1.5; font-family:'Plus Jakarta Sans',sans-serif;">{{ $bakerOrder->cancel_reason }}</span>
            </div>
            @endif
        </div>

        {{-- Timeline --}}
        <div class="card">
            <div class="card-header"><span>🕐</span><h3>Activity Timeline</h3></div>
            <ul class="timeline">
                <li>
                    <div class="tl-dot"></div>
                    <div>
                        <div class="tl-event">Order created</div>
                        <div class="tl-time">{{ $bakerOrder->created_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @if($downpayment)
                <li>
                    <div class="tl-dot" style="background:#C07828;"></div>
                    <div>
                        <div class="tl-event">Downpayment proof submitted</div>
                        <div class="tl-time">{{ $downpayment->created_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @if($downpayment->status === 'paid' || $downpayment->status === 'confirmed')
                <li>
                    <div class="tl-dot" style="background:#166534;"></div>
                    <div>
                        <div class="tl-event">✓ Downpayment confirmed</div>
                        <div class="tl-time">{{ ($downpayment->confirmed_at ?? $downpayment->updated_at)->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @elseif($downpayment->status === 'rejected')
                <li>
                    <div class="tl-dot" style="background:var(--rose);"></div>
                    <div>
                        <div class="tl-event">✕ Downpayment rejected</div>
                        <div class="tl-time">{{ $downpayment->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @endif
                @if($finalPayment && ($finalPayment->status === 'paid' || $finalPayment->status === 'confirmed'))
                <li>
                    <div class="tl-dot" style="background:#166534;"></div>
                    <div>
                        <div class="tl-event">✓ Final payment confirmed</div>
                        <div class="tl-time">{{ ($finalPayment->confirmed_at ?? $finalPayment->updated_at)->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @if($bakerOrder->status === 'COMPLETED')
                <li>
                    <div class="tl-dot" style="background:#166534;"></div>
                    <div>
                        <div class="tl-event">🎉 Order completed</div>
                        <div class="tl-time">{{ $bakerOrder->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @if($bakerOrder->status === 'CANCELLED')
                <li>
                    <div class="tl-dot" style="background:var(--rose);"></div>
                    <div>
                        <div class="tl-event">✕ Order cancelled</div>
                        <div class="tl-time">{{ $bakerOrder->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

@endsection