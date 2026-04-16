{{--
    ══════════════════════════════════════════════════════════════════
    PARTIAL: partials/payment-proof-baker.blade.php

    Usage in baker/orders/show.blade.php — replace each proof section
    with this partial, passing the $payment variable.

    Example call:
        @include('partials.payment-proof-baker', [
            'payment'          => $downpayment,
            'paymentType'      => 'downpayment',
            'paymentTypeLabel' => 'Downpayment',
            'amount'           => $downpaymentAmount,
            'order'            => $order,
        ])
    ══════════════════════════════════════════════════════════════════
--}}

@php
    $isRejected = $payment && $payment->status === 'rejected';
    $isPending  = $payment && $payment->status === 'pending';
    $isConfirmed= $payment && $payment->status === 'confirmed';
    $rejCount   = $payment?->rejection_count ?? 0;
@endphp

@if($payment && ($isPending || $isConfirmed || $isRejected))
<div class="proof-section" style="{{ $isRejected ? 'border-top: 1px solid #F5C5BE; background: #FDF5F3;' : 'border-top: 1px solid #EDD090;' }}">

    {{-- Section label --}}
    <div class="proof-section-label" style="{{ $isRejected ? 'color:#8B2A1E;' : '' }}">
        {{ $paymentTypeLabel }} Proof
        @if($isRejected)
            <span style="margin-left:0.5rem; background:#F5C5BE; color:#8B2A1E; padding:0.1rem 0.5rem; border-radius:4px; font-size:0.65rem; font-weight:700;">REJECTED</span>
        @elseif($isPending)
            <span style="margin-left:0.5rem; background:#FEF9ED; color:#9B6A10; padding:0.1rem 0.5rem; border-radius:4px; font-size:0.65rem; font-weight:700;">PENDING REVIEW</span>
        @elseif($isConfirmed)
            <span style="margin-left:0.5rem; background:#F0FBF4; color:#166534; padding:0.1rem 0.5rem; border-radius:4px; font-size:0.65rem; font-weight:700;">CONFIRMED ✓</span>
        @endif
    </div>

    {{-- Proof image --}}
    @if($payment->proof_of_payment_path)
    <img src="{{ asset('storage/'.$payment->proof_of_payment_path) }}"
         class="proof-img-full"
         alt="{{ $paymentTypeLabel }} Proof"
         style="{{ $isRejected ? 'opacity:0.55; border:2px dashed #F5C5BE;' : '' }}">
    @endif

    {{-- Meta row --}}
    <div class="proof-meta-row">
        @if($payment->paid_at)
            <span>📅 {{ $payment->paid_at->format('M d, Y · g:i A') }}</span>
        @endif
        @if($payment->payment_method)
            <span>💳 via {{ strtoupper($payment->payment_method) }}</span>
        @endif
        @if($rejCount > 0)
            <span style="color:#8B2A1E; font-weight:700;">⚠ {{ $rejCount }} rejection{{ $rejCount > 1 ? 's' : '' }}</span>
        @endif
        <span style="color:{{ $isConfirmed ? 'var(--caramel)' : ($isRejected ? '#8B2A1E' : '#9B6A10') }}; font-weight:700;">
            {{ $isConfirmed ? '✓ Confirmed' : ($isRejected ? '✕ Rejected' : '⏳ Pending') }}
        </span>
    </div>

    {{-- ── REJECTION DETAILS (if already rejected) ── --}}
    @if($isRejected && $payment->rejection_reason)
    <div style="margin-top:0.75rem; padding:0.75rem 1rem; background:#FDF0EE; border:1.5px solid #F5C5BE; border-radius:10px;">
        <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.1em; color:#8B2A1E; font-weight:700; margin-bottom:0.3rem;">Rejection Reason</div>
        <div style="font-size:0.84rem; font-weight:600; color:#5A1A1A;">
            {{ \App\Models\Payment::REJECTION_REASONS[$payment->rejection_reason] ?? $payment->rejection_reason }}
        </div>
        @if($payment->rejection_note)
        <div style="font-size:0.78rem; color:#7A2A20; margin-top:0.35rem; font-style:italic;">"{{ $payment->rejection_note }}"</div>
        @endif
    </div>
    @endif

    {{-- ── BAKER ACTIONS: PENDING state → Confirm or Reject ── --}}
    @if($isPending && !$isConfirmed)
    <div style="margin-top:1rem; display:flex; gap:0.75rem; align-items:center;">

        {{-- Quick confirm button --}}
        <form id="form-confirm-{{ $paymentType }}" method="POST"
              action="{{ $paymentType === 'downpayment'
                  ? route('baker.orders.confirm-payment', $order->id)
                  : route('baker.orders.confirm-final-payment', $order->id) }}">
            @csrf
        </form>
        <button type="button"
            class="btn-confirm-pay"
            style="flex:1; padding:0.65rem 1rem; font-size:0.82rem;"
            onclick="openConfirmModal('modal-confirm-{{ $paymentType }}')">
            ✅ Confirm Receipt
        </button>

        {{-- Reject button → opens rejection modal --}}
        <button type="button"
            class="btn-reject-payment"
            onclick="openRejectModal('{{ $paymentType }}', '{{ $paymentTypeLabel }}', '{{ $order->id }}')"
            style="flex:1; padding:0.65rem 1rem; background:#FDF0EE; color:#8B2A1E; border:1.5px solid #F5C5BE; border-radius:10px; font-size:0.82rem; font-weight:700; cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.2s;">
            ✕ Reject Proof
        </button>
    </div>
    @endif

</div>
@endif


{{-- ════════════════════════════════════════════════════════════
     REJECTION MODAL — include ONCE per page (outside loops)
     Put this right before @endsection in baker/orders/show.blade.php
     ════════════════════════════════════════════════════════════ --}}
@once
<style>
/* ── Reject Payment Modal ── */
.reject-modal-backdrop {
    position: fixed; inset: 0; z-index: 10000;
    background: rgba(20,8,4,0.7);
    backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; pointer-events: none;
    transition: opacity 0.25s ease;
}
.reject-modal-backdrop.is-open { opacity: 1; pointer-events: all; }
.reject-modal {
    background: var(--warm-white, #FFFDF9);
    border-radius: 24px;
    width: 100%; max-width: 460px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.3);
    transform: translateY(24px) scale(0.95);
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.reject-modal-backdrop.is-open .reject-modal { transform: translateY(0) scale(1); }

.reject-modal-header {
    background: linear-gradient(135deg, #5A1A1A, #8B2E2E);
    padding: 2rem 2rem 1.5rem;
    text-align: center;
}
.reject-modal-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; margin: 0 auto 1rem;
}
.reject-modal-title { font-family:'Playfair Display',serif; font-size:1.2rem; color:white; font-weight:700; margin-bottom:0.25rem; }
.reject-modal-sub   { font-size:0.78rem; color:rgba(255,255,255,0.65); }

.reject-modal-body { padding: 1.5rem 2rem; }

.reject-warning-box {
    background: #FEF9E8; border: 1.5px solid #F0D090;
    border-radius: 12px; padding: 0.85rem 1rem;
    margin-bottom: 1.25rem;
    display: flex; align-items: flex-start; gap: 0.6rem;
    font-size: 0.78rem; color: #8A5010; line-height: 1.5;
}
.reject-warning-box strong { font-weight: 700; }

.reject-reasons-label {
    font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em;
    color: var(--text-muted,#9A7A5A); font-weight: 600; margin-bottom: 0.6rem;
}
.reject-reason-list { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.25rem; }
.reject-reason-item {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.65rem 1rem;
    border: 1.5px solid var(--border,#EAE0D0);
    border-radius: 10px; cursor: pointer;
    font-size: 0.84rem; color: var(--text-dark,#2C1A0E);
    background: white; transition: all 0.15s;
    user-select: none;
}
.reject-reason-item:hover { border-color: #8B2A1E; background: #FDF5F3; }
.reject-reason-item.selected { border-color: #8B2A1E; background: #FDF0EE; color: #5A1A1A; font-weight: 600; }
.reject-reason-radio {
    width: 16px; height: 16px; border-radius: 50%;
    border: 2px solid var(--border,#EAE0D0);
    flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.reject-reason-item.selected .reject-reason-radio {
    border-color: #8B2A1E; background: #8B2A1E;
    box-shadow: inset 0 0 0 3px white;
}
.reject-note-area {
    width: 100%; padding: 0.75rem 1rem;
    border: 1.5px solid var(--border,#EAE0D0);
    border-radius: 10px; font-family: 'DM Sans',sans-serif;
    font-size: 0.84rem; color: var(--text-dark,#2C1A0E);
    resize: vertical; min-height: 80px;
    background: white; transition: border-color 0.2s;
    box-sizing: border-box;
}
.reject-note-area:focus { outline: none; border-color: #8B2A1E; }

.reject-modal-footer {
    display: flex; gap: 0.75rem;
    padding: 0 2rem 2rem;
}
.reject-modal-cancel {
    flex: 1; padding: 0.75rem; border-radius: 12px;
    border: 1.5px solid var(--border,#EAE0D0);
    background: white; color: var(--text-mid,#6B4A2A);
    font-size: 0.85rem; font-weight: 600;
    cursor: pointer; font-family: 'DM Sans',sans-serif;
    transition: all 0.2s;
}
.reject-modal-cancel:hover { border-color: var(--text-muted); }
.reject-modal-submit {
    flex: 2; padding: 0.75rem; border-radius: 12px;
    border: none;
    background: linear-gradient(135deg,#8B2A1E,#C44030);
    color: white; font-size: 0.85rem; font-weight: 700;
    cursor: pointer; font-family: 'DM Sans',sans-serif;
    box-shadow: 0 4px 14px rgba(139,42,30,0.4);
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 0.4rem;
}
.reject-modal-submit:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(139,42,30,0.5); }
.reject-modal-submit:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }
</style>

{{-- The Modal DOM --}}
<div class="reject-modal-backdrop" id="rejectPaymentModal" role="dialog" aria-modal="true">
    <div class="reject-modal">
        <div class="reject-modal-header">
            <div class="reject-modal-icon">✕</div>
            <div class="reject-modal-title">Reject Payment Proof?</div>
            <div class="reject-modal-sub" id="rejectModalSub">Select a reason for the rejection</div>
        </div>
        <div class="reject-modal-body">

            {{-- Warning banner --}}
            <div class="reject-warning-box">
                <span>⚠️</span>
                <div>The customer will be <strong>notified immediately</strong> and asked to re-upload a valid receipt.
                If they are rejected a <strong>second time</strong>, the order will be <strong>automatically cancelled</strong>.</div>
            </div>

            {{-- Reason selector --}}
            <div class="reject-reasons-label">Reason for Rejection *</div>
            <div class="reject-reason-list" id="rejectReasonList">
                @foreach(\App\Models\Payment::REJECTION_REASONS as $key => $label)
                <div class="reject-reason-item" data-value="{{ $key }}" onclick="selectRejectReason(this)">
                    <div class="reject-reason-radio"></div>
                    {{ $label }}
                </div>
                @endforeach
            </div>

            {{-- Optional note --}}
            <div class="reject-reasons-label">Additional Note <span style="opacity:0.5;">(optional)</span></div>
            <textarea class="reject-note-area" id="rejectNoteInput"
                placeholder="e.g. The GCash reference number could not be verified in our records…"></textarea>
        </div>

        <div class="reject-modal-footer">
            <button class="reject-modal-cancel" onclick="closeRejectModal()">Cancel</button>
            {{-- This button submits the hidden form below --}}
            <button class="reject-modal-submit" id="rejectSubmitBtn" disabled onclick="submitRejectModal()">
                <span class="btn-spinner" id="rejectSpinner" style="display:none;width:16px;height:16px;border:2px solid rgba(255,255,255,0.3);border-top-color:white;border-radius:50%;animation:spin 0.7s linear infinite;"></span>
                <span id="rejectSubmitLabel">✕ Reject Proof</span>
            </button>
        </div>
    </div>
</div>

{{-- Hidden form — action set dynamically by JS --}}
<form id="rejectPaymentForm" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="payment_type"     id="rejectFormPaymentType">
    <input type="hidden" name="rejection_reason" id="rejectFormReason">
    <input type="hidden" name="rejection_note"   id="rejectFormNote">
</form>

<script>
(function () {
    let _selectedReason = null;

    window.openRejectModal = function(paymentType, paymentTypeLabel, orderId) {
        // Set form action
        document.getElementById('rejectPaymentForm').action =
            '/baker/orders/' + orderId + '/reject-payment';

        document.getElementById('rejectFormPaymentType').value = paymentType;
        document.getElementById('rejectModalSub').textContent =
            'Rejecting: ' + paymentTypeLabel + ' proof';

        // Reset state
        _selectedReason = null;
        document.querySelectorAll('.reject-reason-item').forEach(el => el.classList.remove('selected'));
        document.getElementById('rejectNoteInput').value = '';
        document.getElementById('rejectSubmitBtn').disabled = true;

        // Open
        document.getElementById('rejectPaymentModal').classList.add('is-open');
        document.body.style.overflow = 'hidden';
    };

    window.closeRejectModal = function() {
        document.getElementById('rejectPaymentModal').classList.remove('is-open');
        document.body.style.overflow = '';
    };

    window.selectRejectReason = function(el) {
        document.querySelectorAll('.reject-reason-item').forEach(e => e.classList.remove('selected'));
        el.classList.add('selected');
        _selectedReason = el.dataset.value;
        document.getElementById('rejectSubmitBtn').disabled = false;
    };

    window.submitRejectModal = function() {
        if (!_selectedReason) return;

        document.getElementById('rejectFormReason').value =
            _selectedReason;
        document.getElementById('rejectFormNote').value =
            document.getElementById('rejectNoteInput').value;

        const btn = document.getElementById('rejectSubmitBtn');
        btn.disabled = true;
        document.getElementById('rejectSpinner').style.display = 'block';
        document.getElementById('rejectSubmitLabel').style.display = 'none';

        document.getElementById('rejectPaymentForm').submit();
    };

    // Backdrop click closes
    document.getElementById('rejectPaymentModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
})();
</script>
@endonce