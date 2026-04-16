{{--
    ══════════════════════════════════════════════════════════════════
    PARTIAL: partials/payment-rejection-customer.blade.php

    Shows rejection status + re-upload form on the customer tracker.
    Include inside the payment section card on customer/cake-requests/show.blade.php

    Example call (after the existing .psc-split block):
        @include('partials.payment-rejection-customer', [
            'payment'         => $downpayment,
            'paymentType'     => 'downpayment',
            'cakeRequest'     => $cakeRequest,
        ])
    ══════════════════════════════════════════════════════════════════
--}}

@php
    $isRejected  = $payment && $payment->status === 'rejected';
    $rejCount    = $payment?->rejection_count ?? 0;
    $isSecondRej = $rejCount >= 2;
@endphp

@if($isRejected)
<div id="payment-rejected-notice-{{ $paymentType }}" style="margin: 0 1.5rem 1.25rem;">

    {{-- ── ALERT BANNER ── --}}
    <div style="background:#FDF0EE; border:2px solid #F5C5BE; border-radius:16px; overflow:hidden; position:relative;">
        <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#C44030,#E86050,#C44030);"></div>
        <div style="padding:1.1rem 1.25rem;">
            <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.5rem;">
                <div style="width:32px; height:32px; background:linear-gradient(135deg,#8B2A1E,#C44030); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:0.9rem; flex-shrink:0;">✕</div>
                <div>
                    <div style="font-weight:700; font-size:0.9rem; color:#5A1A1A;">Payment Proof Rejected</div>
                    <div style="font-size:0.72rem; color:#8B2A1E; margin-top:0.05rem;">
                        @if(!$isSecondRej) Please upload a valid receipt @else Your order has been cancelled @endif
                    </div>
                </div>
                @if($rejCount > 0)
                <div style="margin-left:auto; background:#F5C5BE; color:#8B2A1E; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.65rem; font-weight:700; white-space:nowrap;">
                    Rejection #{{ $rejCount }}
                </div>
                @endif
            </div>

            {{-- Reason --}}
            @if($payment->rejection_reason)
            <div style="background:rgba(255,255,255,0.6); border:1px solid #F5C5BE; border-radius:10px; padding:0.65rem 0.85rem; margin-bottom:0.75rem;">
                <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.1em; color:#8B2A1E; font-weight:700; margin-bottom:0.2rem;">Reason</div>
                <div style="font-size:0.84rem; font-weight:600; color:#5A1A1A;">
                    {{ \App\Models\Payment::REJECTION_REASONS[$payment->rejection_reason] ?? $payment->rejection_reason }}
                </div>
                @if($payment->rejection_note)
                <div style="font-size:0.76rem; color:#7A2A20; margin-top:0.3rem; font-style:italic; line-height:1.5;">
                    "{{ $payment->rejection_note }}"
                </div>
                @endif
            </div>
            @endif

            {{-- Auto-cancel warning --}}
            @if(!$isSecondRej)
            <div style="background:#FEF9E8; border:1px solid #F0D090; border-radius:8px; padding:0.55rem 0.75rem; font-size:0.73rem; color:#8A5010; display:flex; gap:0.4rem; align-items:flex-start;">
                <span style="flex-shrink:0;">⚠️</span>
                <span><strong>Warning:</strong> If your next upload is rejected again, your order will be automatically cancelled.</span>
            </div>
            @else
            <div style="background:#FDF0EE; border:1px solid #F5C5BE; border-radius:8px; padding:0.55rem 0.75rem; font-size:0.73rem; color:#8B2A1E; display:flex; gap:0.4rem; align-items:flex-start;">
                <span style="flex-shrink:0;">🚫</span>
                <span><strong>Order Cancelled.</strong> Your order was automatically cancelled due to repeated invalid payment proofs. Contact support if you believe this is an error.</span>
            </div>
            @endif
        </div>

        {{-- ── RE-UPLOAD FORM ── (only shown if first rejection) --}}
        @if(!$isSecondRej)
        <div style="border-top:1px solid #F5C5BE; padding:1.1rem 1.25rem; background:rgba(253,240,238,0.5);">
            <div style="font-size:0.68rem; text-transform:uppercase; letter-spacing:0.1em; color:#8B2A1E; font-weight:700; margin-bottom:0.75rem;">
                📎 Upload New Payment Proof
            </div>

            <form id="reupload-form-{{ $paymentType }}"
                  method="POST"
                  action="{{ route('customer.payment.reupload', $cakeRequest->id) }}"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_type" value="{{ $paymentType }}">

                {{-- File drop zone --}}
                <label for="reupload-input-{{ $paymentType }}"
                       id="reupload-zone-{{ $paymentType }}"
                       style="display:block; border:2px dashed #F5C5BE; border-radius:12px; padding:1.25rem; text-align:center; cursor:pointer; transition:all 0.2s; background:white;"
                       onmouseover="this.style.borderColor='#C44030'; this.style.background='#FDF5F3';"
                       onmouseout="this.style.borderColor='#F5C5BE'; this.style.background='white';">
                    <div id="reupload-preview-{{ $paymentType }}" style="display:none; margin-bottom:0.75rem;">
                        <img id="reupload-preview-img-{{ $paymentType }}"
                             style="max-height:120px; max-width:100%; border-radius:8px; object-fit:contain; border:1px solid #F5C5BE;">
                    </div>
                    <div id="reupload-placeholder-{{ $paymentType }}">
                        <div style="font-size:1.5rem; margin-bottom:0.4rem;">📄</div>
                        <div style="font-size:0.82rem; font-weight:600; color:#8B2A1E;">Click to select receipt</div>
                        <div style="font-size:0.72rem; color:#9A7A6A; margin-top:0.2rem;">JPG, PNG or PDF · max 5 MB</div>
                    </div>
                    <input type="file" id="reupload-input-{{ $paymentType }}"
                           name="proof" accept="image/*,.pdf"
                           style="display:none;"
                           onchange="handleReuploadPreview(this, '{{ $paymentType }}')">
                </label>

                <button type="button"
                    id="reupload-btn-{{ $paymentType }}"
                    onclick="submitReupload('{{ $paymentType }}')"
                    disabled
                    style="width:100%; margin-top:0.85rem; padding:0.8rem; background:linear-gradient(135deg,#8B2A1E,#C44030); color:white; border:none; border-radius:10px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'DM Sans',sans-serif; box-shadow:0 4px 14px rgba(139,42,30,0.35); transition:all 0.2s; opacity:0.45; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                    <span id="reupload-btn-spinner-{{ $paymentType }}" style="display:none; width:16px; height:16px; border:2px solid rgba(255,255,255,0.3); border-top-color:white; border-radius:50%; animation:spin 0.7s linear infinite;"></span>
                    <span id="reupload-btn-label-{{ $paymentType }}">📤 Re-submit Proof</span>
                </button>
            </form>
        </div>
        @endif

    </div>
</div>

<script>
(function() {
    window.handleReuploadPreview = function(input, type) {
        const file = input.files[0];
        if (!file) return;

        const btn = document.getElementById('reupload-btn-' + type);
        btn.disabled = false;
        btn.style.opacity = '1';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('reupload-preview-img-' + type).src = e.target.result;
                document.getElementById('reupload-preview-' + type).style.display = 'block';
                document.getElementById('reupload-placeholder-' + type).style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            // PDF: show filename instead
            document.getElementById('reupload-placeholder-' + type).innerHTML =
                '<div style="font-size:1.5rem">📄</div><div style="font-size:0.82rem; font-weight:600; color:#8B2A1E;">' + file.name + '</div>';
        }
    };

    window.submitReupload = function(type) {
        const btn = document.getElementById('reupload-btn-' + type);
        btn.disabled = true;
        document.getElementById('reupload-btn-spinner-' + type).style.display = 'block';
        document.getElementById('reupload-btn-label-' + type).style.display = 'none';
        document.getElementById('reupload-form-' + type).submit();
    };
})();
</script>
@endif