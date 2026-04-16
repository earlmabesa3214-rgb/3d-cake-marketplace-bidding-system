{{--
  Partial: customer/payment/_payment_form.blade.php
  Variables: $paymentType, $amount, $methods (collection), $cakeRequest
--}}

<div class="pf-wrap" x-data="{ method: '{{ $methods->first()?->type ?? 'cash' }}', showProof: false }">

    {{-- Method selector --}}
    <div class="pf-label">Choose Payment Method</div>
    <div class="method-grid">
        @foreach($methods as $m)
        <button type="button"
            class="method-card"
            :class="{ 'method-selected': method === '{{ $m->type }}' }"
            @click="method = '{{ $m->type }}'">
            <span class="method-emoji">{{ $m->icon }}</span>
            <span class="method-name">{{ $m->label }}</span>
        </button>
        @endforeach

        @if($methods->isEmpty())
        <div class="no-methods">Baker hasn't set up payment methods yet. Please contact them directly.</div>
        @endif
    </div>

    {{-- GCash / Maya: show baker's QR + number, then Pay Online button --}}
    @foreach($methods->whereIn('type', ['gcash', 'maya']) as $m)
    <div x-show="method === '{{ $m->type }}'" class="method-detail">
        @if($m->qr_code_path)
        <div class="qr-section">
            <p class="qr-hint">Scan this QR code in {{ $m->label }}</p>
            <img src="{{ Storage::url($m->qr_code_path) }}" alt="{{ $m->label }} QR" class="qr-img">
        </div>
        @endif

        @if($m->account_number)
        <div class="account-box">
            <span class="account-label">{{ $m->label }} Number</span>
            <div class="account-number-row">
                <span class="account-number" id="num-{{ $m->type }}">{{ $m->account_number }}</span>
                <button type="button" onclick="copyNumber('{{ $m->account_number }}', '{{ $m->type }}')" class="copy-btn">Copy</button>
            </div>
            @if($m->account_name)
            <span class="account-name">Account name: {{ $m->account_name }}</span>
            @endif
        </div>
        @endif

        {{-- Pay via PayMongo redirect --}}
        <form action="{{ route('customer.payment.initiate', $cakeRequest->id) }}" method="POST" class="pf-form">
            @csrf
            <input type="hidden" name="payment_method" value="{{ $m->type }}">
            <input type="hidden" name="payment_type"   value="{{ $paymentType }}">
            <button type="submit" class="pay-btn pay-btn-online">
                🔒 Pay ₱{{ number_format($amount, 2) }} via {{ $m->label }}
            </button>
        </form>

        <div class="or-divider"><span>or upload proof after manual transfer</span></div>

        {{-- Manual proof upload --}}
        <form action="{{ route('customer.payment.upload-proof', $cakeRequest->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="payment_type" value="{{ $paymentType }}">
            <div class="proof-upload">
                <label for="proof-{{ $m->type }}-{{ $paymentType }}">
                    <span>📎 Upload screenshot / proof</span>
                    <input type="file" id="proof-{{ $m->type }}-{{ $paymentType }}" name="proof" accept="image/*" class="file-input">
                </label>
                <button type="submit" class="pay-btn pay-btn-proof">Submit Proof</button>
            </div>
        </form>
    </div>
    @endforeach

    {{-- Cash --}}
    @if($methods->where('type', 'cash')->isNotEmpty())
    <div x-show="method === 'cash'" class="method-detail">
        <div class="cash-info">
            <p>💵 Pay in cash on delivery or pickup. Your baker will confirm receipt.</p>
        </div>
        <form action="{{ route('customer.payment.initiate', $cakeRequest->id) }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method" value="cash">
            <input type="hidden" name="payment_type"   value="{{ $paymentType }}">
            <button type="submit" class="pay-btn pay-btn-cash">
                Confirm Cash Payment (₱{{ number_format($amount, 2) }})
            </button>
        </form>
    </div>
    @endif

</div>

<script>
function copyNumber(num, type) {
    navigator.clipboard.writeText(num).then(() => {
        const btn = event.target;
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = 'Copy', 2000);
    });
}
</script>

<style>
.pf-wrap { margin-top: 16px; padding-top: 16px; border-top: 1px solid #e8eee8; }
.pf-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #8a9a8a; margin-bottom: 10px; }

.method-grid { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; }
.method-card {
    display: flex; flex-direction: column; align-items: center; gap: 4px;
    padding: 10px 18px; border-radius: 10px;
    border: 1.5px solid #e0e8e0; background: white; cursor: pointer;
    transition: all 0.15s; font-family: inherit;
}
.method-card:hover { border-color: #c8862a; background: #fef8ed; }
.method-selected { border-color: #c8862a !important; background: #fef8ed !important; box-shadow: 0 0 0 3px rgba(200,134,42,0.15); }
.method-emoji { font-size: 20px; }
.method-name { font-size: 12px; font-weight: 600; color: #2a3a2a; }

.no-methods { font-size: 13px; color: #e05a5a; background: #fef0f0; padding: 10px 14px; border-radius: 8px; border: 1px solid #fcc; }

.method-detail { animation: fadeIn 0.2s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

.qr-section { text-align: center; margin-bottom: 14px; }
.qr-hint { font-size: 12px; color: #6a8a6a; margin-bottom: 8px; }
.qr-img { width: 160px; height: 160px; object-fit: contain; border: 1px solid #e0e8e0; border-radius: 12px; padding: 8px; }

.account-box { background: #f5f8f5; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; border: 1px solid #dce8dc; }
.account-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #5a7a5a; }
.account-number-row { display: flex; align-items: center; gap: 10px; margin: 4px 0; }
.account-number { font-size: 18px; font-weight: 700; color: #1a2a1a; letter-spacing: 1px; }
.copy-btn { background: #2d5a3d; color: white; border: none; padding: 4px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; }
.copy-btn:hover { background: #1e4530; }
.account-name { font-size: 12px; color: #6a8a6a; }

.pay-btn { width: 100%; padding: 13px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: all 0.2s; }
.pay-btn-online { background: linear-gradient(135deg, #0055a5, #0077cc); color: white; box-shadow: 0 4px 12px rgba(0,85,165,0.3); }
.pay-btn-online:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,85,165,0.4); }
.pay-btn-proof { background: #2d5a3d; color: white; margin-top: 8px; }
.pay-btn-cash { background: linear-gradient(135deg, #c8862a, #e8a94a); color: white; box-shadow: 0 4px 12px rgba(200,134,42,0.3); }

.or-divider { text-align: center; position: relative; margin: 14px 0; }
.or-divider::before { content: ''; position: absolute; left: 0; right: 0; top: 50%; height: 1px; background: #e0e8e0; }
.or-divider span { position: relative; background: white; padding: 0 12px; font-size: 11px; color: #8a9a8a; }

.proof-upload { display: flex; flex-direction: column; gap: 8px; }
.proof-upload label { display: flex; align-items: center; gap: 8px; padding: 10px 14px; border: 1.5px dashed #b8c8b8; border-radius: 8px; cursor: pointer; font-size: 13px; color: #4a7a4a; background: #f8faf8; }
.proof-upload label:hover { border-color: #2d5a3d; background: #f0f8f0; }
.file-input { display: none; }

.cash-info { background: #fef8ed; border-radius: 10px; padding: 14px; margin-bottom: 14px; border: 1px solid #f0d090; }
.cash-info p { font-size: 13px; color: #8a6020; line-height: 1.5; margin: 0; }

.pf-form { margin-bottom: 0; }
</style>