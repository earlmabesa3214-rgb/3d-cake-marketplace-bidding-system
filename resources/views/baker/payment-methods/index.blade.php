<div class="bpm-page">

    <div class="bpm-header">
        <div class="bpm-icon">💳</div>
        <div>
            <h1>Payment Methods</h1>
            <p>Manage how customers pay you. Upload your GCash / Maya QR code.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bpm-alert bpm-alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bpm-alert bpm-alert-error">❌ {{ session('error') }}</div>
    @endif

    {{-- ── TWO-COLUMN LAYOUT ── --}}
    <div class="bpm-layout">

        {{-- LEFT: Existing methods --}}
        <div class="bpm-col-left">
            <h2 class="bpm-col-title">YOUR PAYMENT METHODS</h2>

            @if($paymentMethods->isEmpty())
                <div class="bpm-empty">
                    <div class="bpm-empty-icon">📭</div>
                    <div class="bpm-empty-title">No payment methods yet</div>
       <div class="bpm-empty-sub">Add GCash or Maya so customers know how to pay you.</div>
                </div>
            @else
                @foreach($paymentMethods as $method)
                <div class="bpm-method-card {{ $method->is_active ? '' : 'bpm-inactive' }}">
                    <div class="bpm-method-top">
                        <span class="bpm-badge bpm-badge-{{ $method->type }}">
                            {{ $method->icon }} {{ $method->label }}
                        </span>
                        <div class="bpm-method-actions">
                            @if(!$method->is_active)
                                <span class="bpm-inactive-pill">Inactive</span>
                            @endif
                            <button class="bpm-icon-btn" onclick="bpmToggleEdit('{{ $method->id }}')" title="Edit">✏️</button>
                            <form action="{{ route('baker.payment-methods.destroy', $method->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Remove this payment method?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bpm-icon-btn" title="Delete">🗑️</button>
                            </form>
                        </div>
                    </div>

                    <div class="bpm-method-info">
                        @if($method->account_number)
                            <div class="bpm-info-row">
                                <span class="bpm-info-label">Number</span>
                                <span class="bpm-info-val">{{ $method->account_number }}</span>
                            </div>
                        @endif
                        @if($method->account_name)
                            <div class="bpm-info-row">
                                <span class="bpm-info-label">Name</span>
                                <span class="bpm-info-val">{{ $method->account_name }}</span>
                            </div>
                        @endif
                        @if($method->qr_code_path)
                            <div class="bpm-info-row">
                                <span class="bpm-info-label">QR</span>
                                <img src="{{ Storage::url($method->qr_code_path) }}" class="bpm-qr-thumb" alt="QR Code">
                            </div>
                        @endif
                    </div>

                    {{-- Inline edit form --}}
                    <div class="bpm-edit-form" id="bpm-edit-{{ $method->id }}" style="display:none">
                        <form action="{{ route('baker.payment-methods.update', $method->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="bpm-form-grid">
                                <div class="bpm-form-group">
                                    <label class="bpm-label">Account Name</label>
                                    <input type="text" name="account_name" value="{{ $method->account_name }}" placeholder="Juan Dela Cruz" class="bpm-input">
                                </div>
                                @if($method->type !== 'cash')
                                <div class="bpm-form-group">
                                    <label class="bpm-label">{{ $method->label }} Number</label>
                                    <input type="text" name="account_number" value="{{ $method->account_number }}" placeholder="09XXXXXXXXX" class="bpm-input">
                                </div>
                                <div class="bpm-form-group bpm-full">
                                    <label class="bpm-label">QR Code <span class="bpm-optional">(optional)</span></label>
                                    <div class="bpm-file-drop">
                                        <input type="file" name="qr_code" accept="image/*" class="bpm-file-input" id="bpm-qr-{{ $method->id }}" onchange="bpmPreviewQr(this, 'bpm-preview-{{ $method->id }}')">
                                        <label for="bpm-qr-{{ $method->id }}" class="bpm-file-label">
                                            <span>📤 Click to upload new QR code</span>
                                            <small>PNG, JPG up to 5MB</small>
                                        </label>
                                        <img id="bpm-preview-{{ $method->id }}" src="" class="bpm-qr-preview" style="display:none">
                                    </div>
                                </div>
                                @endif
                                <div class="bpm-form-group bpm-full">
                                    <label class="bpm-check-label">
                                        <input type="checkbox" name="is_active" value="1" {{ $method->is_active ? 'checked' : '' }}>
                                        Active (visible to customers)
                                    </label>
                                </div>
                            </div>
                            <div class="bpm-form-actions">
                                <button type="submit" class="bpm-btn-primary">Save Changes</button>
                                <button type="button" class="bpm-btn-ghost" onclick="bpmToggleEdit('{{ $method->id }}')">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        {{-- RIGHT: Add new method panel --}}
        <div class="bpm-col-right">
            <h2 class="bpm-col-title">ADD PAYMENT METHOD</h2>

            <form action="{{ route('baker.payment-methods.store') }}" method="POST" enctype="multipart/form-data" x-data="{ type: 'gcash' }">
                @csrf
                <input type="hidden" name="type" :value="type">

              <div class="bpm-type-selector">
                    <button type="button" class="bpm-type-btn" :class="{ 'bpm-type-active': type === 'gcash' }" @click="type = 'gcash'">📱 GCash</button>
                    <button type="button" class="bpm-type-btn" :class="{ 'bpm-type-active': type === 'maya' }"  @click="type = 'maya'">💜 Maya</button>
                </div>

                <div class="bpm-form-grid">
                    <div class="bpm-form-group">
                        <label class="bpm-label">Account Name</label>
                        <input type="text" name="account_name" placeholder="Your full name" class="bpm-input">
                    </div>
                    <div class="bpm-form-group" x-show="type !== 'cash'">
                        <label class="bpm-label" x-text="type === 'gcash' ? 'GCash Number' : 'Maya Number'"></label>
                        <input type="text" name="account_number" placeholder="09XXXXXXXXX" class="bpm-input">
                    </div>
                    <div class="bpm-form-group bpm-full" x-show="type !== 'cash'">
                        <label class="bpm-label">QR Code Image <span class="bpm-optional">(optional but recommended)</span></label>
                        <div class="bpm-file-drop">
                            <input type="file" name="qr_code" accept="image/*" class="bpm-file-input" id="bpm-new-qr" onchange="bpmPreviewQr(this, 'bpm-new-preview')">
                            <label for="bpm-new-qr" class="bpm-file-label">
                                <span>📤 Upload your QR code</span>
                                <small>Export from GCash/Maya app → My QR → Save Image</small>
                            </label>
                            <img id="bpm-new-preview" src="" class="bpm-qr-preview" style="display:none">
                        </div>
                    </div>
                </div>

                <button type="submit" class="bpm-btn-add">➕ Add Payment Method</button>
            </form>
        </div>

    </div>{{-- end bpm-layout --}}

    @php $pendingCash = collect(); @endphp
    @if($pendingCash->isNotEmpty())
    <div class="bpm-pending-section">
        <h2 class="bpm-col-title">⏳ PENDING CASH CONFIRMATIONS</h2>
        <p class="bpm-section-sub">Customers have marked these as cash payments. Confirm once you receive the money.</p>
        @foreach($pendingCash as $payment)
        <div class="bpm-cash-card">
            <div>
                <div class="bpm-cash-title">Request #{{ str_pad($payment->cake_request_id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="bpm-cash-info">{{ $payment->customer->name }} · {{ ucfirst($payment->payment_type) }} · ₱{{ number_format($payment->amount, 2) }}</div>
                <div class="bpm-cash-date">Marked paid: {{ $payment->paid_at?->format('M d, Y') }}</div>
            </div>
            <form action="{{ route('baker.payment-methods.confirm-cash', $payment->id) }}" method="POST">
                @csrf
                <button type="submit" class="bpm-btn-confirm">✅ Confirm Received</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

</div>

<style>
/* ═══════════════════════════════════════
   PAYMENT METHODS — SCOPED STYLES
   All classes prefixed bpm- to avoid
   collisions with profile page styles
═══════════════════════════════════════ */

.bpm-page {
    width: 100%;
    box-sizing: border-box;
    font-family: 'DM Sans', sans-serif;
}

/* Header */
.bpm-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #EAE0D0;
}
.bpm-icon {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, #C8893A, #E8A94A);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.bpm-header h1 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #3B1F0F;
    margin: 0;
    font-family: 'Playfair Display', serif;
}
.bpm-header p {
    font-size: 0.76rem;
    color: #9A7A5A;
    margin: 2px 0 0;
}

/* Alerts */
.bpm-alert {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin-bottom: 16px;
    font-size: 0.82rem;
}
.bpm-alert-success { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
.bpm-alert-error   { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

/* ── MAIN TWO-COLUMN GRID ── */
.bpm-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 16px;
    align-items: start;
    width: 100%;
    box-sizing: border-box;
}

/* Column titles */
.bpm-col-title {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: #9A7A5A;
    margin: 0 0 12px;
    text-transform: uppercase;
}

/* LEFT column */
.bpm-col-left {
    min-width: 0;
    box-sizing: border-box;
}

/* RIGHT column — the add panel */
.bpm-col-right {
    min-width: 0;
    background: #FFFDF9;
    border: 1.5px solid #EAE0D0;
    border-radius: 14px;
    padding: 18px;
    box-sizing: border-box;
    box-shadow: 0 2px 12px rgba(59,31,15,0.06);
}

/* Empty state */
.bpm-empty {
    background: #FFFDF9;
    border: 1.5px dashed #D4C4B0;
    border-radius: 14px;
    padding: 36px 24px;
    text-align: center;
}
.bpm-empty-icon  { font-size: 2.2rem; margin-bottom: 10px; }
.bpm-empty-title { font-size: 0.9rem; font-weight: 700; color: #3B1F0F; margin-bottom: 6px; }
.bpm-empty-sub   { font-size: 0.78rem; color: #9A7A5A; line-height: 1.5; }

/* Method cards */
.bpm-method-card {
    background: #FFFDF9;
    border: 1.5px solid #EAE0D0;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 10px;
    transition: box-shadow 0.15s;
}
.bpm-method-card:hover { box-shadow: 0 4px 16px rgba(59,31,15,0.08); }
.bpm-inactive { opacity: 0.55; }

.bpm-method-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.bpm-badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
}
.bpm-badge-gcash { background: #EEF2FF; color: #3730A3; }
.bpm-badge-maya  { background: #F5F3FF; color: #6D28D9; }
.bpm-badge-cash  { background: #FEF9E8; color: #7A5800; border: 1px solid #F0D4B0; }

.bpm-method-actions { display: flex; align-items: center; gap: 6px; }
.bpm-inactive-pill {
    font-size: 0.64rem;
    background: #F5EFE6;
    color: #9A7A5A;
    padding: 2px 8px;
    border-radius: 999px;
}
.bpm-icon-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
    padding: 4px 6px;
    border-radius: 6px;
    transition: background 0.15s;
}
.bpm-icon-btn:hover { background: #F5EFE6; }

.bpm-method-info { display: flex; flex-direction: column; gap: 4px; }
.bpm-info-row { display: flex; align-items: center; gap: 10px; font-size: 0.82rem; }
.bpm-info-label {
    font-size: 0.63rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #9A7A5A;
    min-width: 52px;
}
.bpm-info-val { color: #2C1A0E; font-weight: 500; }
.bpm-qr-thumb {
    width: 52px; height: 52px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid #EAE0D0;
}

/* Edit form */
.bpm-edit-form {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #EAE0D0;
}

/* Shared form grid */
.bpm-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 10px;
}
.bpm-form-group { display: flex; flex-direction: column; gap: 4px; }
.bpm-full { grid-column: 1 / -1; }
.bpm-label {
    font-size: 0.71rem;
    font-weight: 600;
    color: #6B4A2A;
}
.bpm-optional { font-weight: 400; color: #9A7A5A; }
.bpm-input {
    padding: 0.58rem 0.8rem;
    border: 1.5px solid #EAE0D0;
    border-radius: 8px;
    font-size: 0.84rem;
    font-family: 'DM Sans', sans-serif;
    background: #FFFDF9;
    color: #2C1A0E;
    outline: none;
    width: 100%;
    box-sizing: border-box;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.bpm-input:focus { border-color: #C8893A; box-shadow: 0 0 0 3px rgba(200,137,58,0.1); }

.bpm-check-label {
    font-size: 0.78rem;
    color: #6B4A2A;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}

/* File drop */
.bpm-file-drop { position: relative; }
.bpm-file-input { display: none; }
.bpm-file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    padding: 14px;
    border: 2px dashed #D4C4B0;
    border-radius: 10px;
    cursor: pointer;
    font-size: 0.76rem;
    color: #7A4A28;
    background: #F5EFE6;
    text-align: center;
    transition: all 0.15s;
}
.bpm-file-label:hover { border-color: #C8893A; background: #EAE0D0; }
.bpm-file-label small { font-size: 0.66rem; color: #9A7A5A; }
.bpm-qr-preview {
    width: 90px; height: 90px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid #EAE0D0;
    margin-top: 8px;
    display: block;
}

/* Form action buttons */
.bpm-form-actions { display: flex; gap: 8px; margin-top: 12px; }
.bpm-btn-primary {
    padding: 8px 16px;
    background: linear-gradient(135deg, #7A4A28, #C8893A);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
}
.bpm-btn-ghost {
    padding: 8px 16px;
    background: #F5EFE6;
    color: #6B4A2A;
    border: 1px solid #EAE0D0;
    border-radius: 8px;
    font-size: 0.8rem;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
}

/* Type selector */
.bpm-type-selector {
    display: flex;
    gap: 6px;
    margin-bottom: 14px;
}
.bpm-type-btn {
    flex: 1;
    padding: 8px 6px;
    border: 1.5px solid #EAE0D0;
    border-radius: 8px;
    background: #FFFDF9;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    color: #9A7A5A;
    transition: all 0.15s;
    text-align: center;
}
.bpm-type-btn:hover   { border-color: #C8893A; color: #3B1F0F; }
.bpm-type-active      { border-color: #C8893A !important; background: #F5EFE6 !important; color: #3B1F0F !important; }

/* Add button */
.bpm-btn-add {
    width: 100%;
    margin-top: 6px;
    padding: 11px;
    background: linear-gradient(135deg, #7A4A28, #C8893A);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.2s;
}
.bpm-btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(123,79,58,0.3); }

/* Pending cash */
.bpm-pending-section { margin-top: 20px; }
.bpm-section-sub { font-size: 0.75rem; color: #9A7A5A; margin: -4px 0 12px; }
.bpm-cash-card {
    background: #FFFDF9;
    border: 1.5px solid #EAE0D0;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}
.bpm-cash-title { font-size: 0.88rem; font-weight: 700; color: #2C1A0E; }
.bpm-cash-info  { font-size: 0.76rem; color: #6B4A2A; margin-top: 2px; }
.bpm-cash-date  { font-size: 0.68rem; color: #9A7A5A; margin-top: 2px; }
.bpm-btn-confirm {
    background: linear-gradient(135deg, #7A4A28, #C8893A);
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 0.76rem;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    white-space: nowrap;
}
.bpm-btn-confirm:hover { box-shadow: 0 4px 12px rgba(123,79,58,0.3); }

/* Responsive */
@media (max-width: 860px) {
    .bpm-layout {
        grid-template-columns: 1fr;
    }
    .bpm-col-right {
        order: -1; /* Show Add panel on top on mobile */
    }
    .bpm-form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function bpmToggleEdit(id) {
    const el = document.getElementById('bpm-edit-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
function bpmPreviewQr(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>