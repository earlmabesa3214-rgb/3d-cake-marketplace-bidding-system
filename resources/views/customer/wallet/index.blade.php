@extends('layouts.customer')

@section('title', 'My Wallet')

@section('content')
<div class="wallet-page">

    {{-- ── HEADER ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">My Wallet</h1>
            <p class="page-subtitle">Manage your balance and transactions</p>
        </div>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ── BALANCE CARD ── --}}
    <div class="balance-card">
        <div class="balance-card-bg"></div>
        <div class="balance-content">
            <div class="balance-label">Available Balance</div>
            <div class="balance-amount">₱{{ number_format($wallet->balance, 2) }}</div>
            <div class="balance-stats">
                <div class="balance-stat">
                    <span class="stat-label">Total Deposited</span>
                    <span class="stat-value">₱{{ number_format($wallet->total_deposited, 2) }}</span>
                </div>
                <div class="balance-stat-divider"></div>
                <div class="balance-stat">
                    <span class="stat-label">Total Spent</span>
                    <span class="stat-value">₱{{ number_format($wallet->total_spent, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="wallet-icon-bg">💳</div>
    </div>

    {{-- ── PENDING CASH-IN NOTICE ── --}}
    @if($pendingCashin)
        <div class="pending-notice">
            <div class="pending-icon">⏳</div>
            <div class="pending-text">
                <strong>Cash-in Pending Review</strong>
                <span>₱{{ number_format($pendingCashin->amount, 2) }} — GCash Ref: {{ $pendingCashin->gcash_reference }}</span>
                <span class="pending-sub">Your wallet will be credited once admin verifies your payment proof.</span>
            </div>
        </div>
    @endif

    <div class="wallet-grid">

        {{-- ── CASH IN FORM ── --}}
        @if(!$pendingCashin)
        <div class="card cashin-card">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="card-icon">💰</span> Top Up via GCash
                </h2>
                <p class="card-desc">Send money to our GCash number, then upload your proof here.</p>
            </div>

            <div class="gcash-info-box">
                <div class="gcash-number-label">Send to GCash Number</div>
                <div class="gcash-number">0917 - XXX - XXXX</div>
                <div class="gcash-name">BakeSphere Official</div>
            </div>

            <form action="{{ route('customer.wallet.cash-in') }}" method="POST" enctype="multipart/form-data" class="cashin-form">
                @csrf

                <div class="form-group">
                    <label class="form-label">Amount (₱)</label>
                    <div class="input-prefix-wrap">
                        <span class="input-prefix">₱</span>
                        <input type="number" name="amount" class="form-input @error('amount') is-error @enderror"
                               placeholder="e.g. 500" min="50" max="50000" step="0.01"
                               value="{{ old('amount') }}" required>
                    </div>
                    @error('amount') <span class="field-error">{{ $message }}</span> @enderror
                    <div class="quick-amounts">
                        <button type="button" class="quick-btn" onclick="setAmount(200)">₱200</button>
                        <button type="button" class="quick-btn" onclick="setAmount(500)">₱500</button>
                        <button type="button" class="quick-btn" onclick="setAmount(1000)">₱1,000</button>
                        <button type="button" class="quick-btn" onclick="setAmount(2000)">₱2,000</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">GCash Reference Number</label>
                    <input type="text" name="gcash_reference" class="form-input @error('gcash_reference') is-error @enderror"
                           placeholder="e.g. 1234567890" maxlength="20"
                           value="{{ old('gcash_reference') }}" required>
                    @error('gcash_reference') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Payment Screenshot / Proof</label>
                    <div class="file-drop-area" id="fileDropArea">
                        <input type="file" name="proof" id="proofFile" accept="image/jpg,image/jpeg,image/png"
                               class="file-input @error('proof') is-error @enderror" required onchange="previewFile(this)">
                        <div class="file-drop-content" id="fileDropContent">
                            <div class="file-drop-icon">📸</div>
                            <div class="file-drop-text">Click or drag your GCash screenshot here</div>
                            <div class="file-drop-sub">JPG, JPEG, PNG — max 5MB</div>
                        </div>
                        <img id="filePreview" class="file-preview" src="" alt="Preview" style="display:none;">
                    </div>
                    @error('proof') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Submit Cash-In Request
                </button>
            </form>
        </div>
        @endif

        {{-- ── TRANSACTION HISTORY ── --}}
        <div class="card txn-card">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="card-icon">📋</span> Transaction History
                </h2>
            </div>

            @if($transactions->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🪙</div>
                    <p>No transactions yet.</p>
                    <span>Your transaction history will appear here.</span>
                </div>
            @else
                <div class="txn-list">
                    @foreach($transactions as $txn)
                    <div class="txn-row {{ $txn->isCredit() ? 'txn-credit' : 'txn-debit' }}">
                        <div class="txn-icon">
                            @if($txn->isCredit()) ⬆️ @else ⬇️ @endif
                        </div>
                        <div class="txn-details">
                            <div class="txn-type">{{ $txn->typeLabel() }}</div>
                            <div class="txn-desc">{{ $txn->description ?? '—' }}</div>
                            <div class="txn-date">{{ $txn->created_at->format('M d, Y · h:i A') }}</div>
                        </div>
                        <div class="txn-amount {{ $txn->isCredit() ? 'amount-green' : 'amount-red' }}">
                            {{ $txn->isCredit() ? '+' : '-' }}₱{{ number_format($txn->amount, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>{{-- end .wallet-grid --}}
</div>{{-- end .wallet-page --}}

<style>
/* ── PAGE ── */
.wallet-page {
    padding: 1.5rem;
    max-width: 1100px;
    margin: 0 auto;
}

.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.page-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
    margin: 0 0 0.2rem;
}

.page-subtitle {
    font-size: 0.875rem;
    color: var(--text-muted, #888);
    margin: 0;
}

/* ── ALERTS ── */
.alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.25rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
}
.alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

/* ── BALANCE CARD ── */
.balance-card {
    position: relative;
    background: linear-gradient(135deg, #c8894a 0%, #a0622e 60%, #7a4520 100%);
    border-radius: 20px;
    padding: 2rem;
    color: #fff;
    margin-bottom: 1.5rem;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(160,98,46,0.35);
}

.balance-card-bg {
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
}

.balance-content { position: relative; z-index: 1; }

.balance-label {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    opacity: 0.8;
    margin-bottom: 0.5rem;
}

.balance-amount {
    font-size: 2.8rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 1.5rem;
}

.balance-stats {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.balance-stat { display: flex; flex-direction: column; gap: 0.2rem; }
.stat-label { font-size: 0.72rem; opacity: 0.7; text-transform: uppercase; letter-spacing: 0.08em; }
.stat-value { font-size: 0.95rem; font-weight: 700; }
.balance-stat-divider { width: 1px; height: 30px; background: rgba(255,255,255,0.25); }

.wallet-icon-bg {
    position: absolute;
    bottom: -10px; right: 20px;
    font-size: 6rem;
    opacity: 0.12;
    z-index: 0;
    user-select: none;
}

/* ── PENDING NOTICE ── */
.pending-notice {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}
.pending-icon { font-size: 1.5rem; }
.pending-text { display: flex; flex-direction: column; gap: 0.2rem; font-size: 0.875rem; color: #92400e; }
.pending-text strong { font-size: 0.95rem; color: #78350f; }
.pending-sub { font-size: 0.8rem; opacity: 0.8; }

/* ── GRID ── */
.wallet-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .wallet-grid { grid-template-columns: 1fr; }
}

/* ── CARDS ── */
.card {
    background: var(--card-bg, #fff);
    border-radius: 16px;
    border: 1px solid var(--border, #e8e0d8);
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.card-header { margin-bottom: 1.25rem; }

.card-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
    margin: 0 0 0.35rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-icon { font-size: 1rem; }

.card-desc {
    font-size: 0.82rem;
    color: var(--text-muted, #888);
    margin: 0;
}

/* ── GCASH INFO ── */
.gcash-info-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 1px solid #bae6fd;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    text-align: center;
}
.gcash-number-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: #0369a1; font-weight: 600; margin-bottom: 0.35rem; }
.gcash-number { font-size: 1.4rem; font-weight: 800; color: #0c4a6e; letter-spacing: 0.05em; }
.gcash-name { font-size: 0.78rem; color: #0369a1; margin-top: 0.2rem; }

/* ── FORM ── */
.cashin-form { display: flex; flex-direction: column; gap: 1rem; }

.form-group { display: flex; flex-direction: column; gap: 0.4rem; }

.form-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--text-primary, #374151);
}

.form-input {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--border, #d1c8bc);
    border-radius: 10px;
    font-size: 0.9rem;
    background: var(--input-bg, #faf8f5);
    color: var(--text-primary, #1a1a1a);
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}
.form-input:focus { outline: none; border-color: #c8894a; box-shadow: 0 0 0 3px rgba(200,137,74,0.15); }
.form-input.is-error { border-color: #ef4444; }

.input-prefix-wrap { position: relative; }
.input-prefix {
    position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%);
    font-weight: 700; color: #c8894a; font-size: 0.9rem;
    pointer-events: none;
}
.input-prefix-wrap .form-input { padding-left: 1.8rem; }

.field-error { font-size: 0.78rem; color: #ef4444; }

.quick-amounts {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 0.25rem;
}
.quick-btn {
    padding: 0.3rem 0.7rem;
    background: transparent;
    border: 1.5px solid #c8894a;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #c8894a;
    cursor: pointer;
    transition: all 0.15s;
}
.quick-btn:hover { background: #c8894a; color: #fff; }

/* ── FILE DROP ── */
.file-drop-area {
    position: relative;
    border: 2px dashed var(--border, #d1c8bc);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    background: var(--input-bg, #faf8f5);
    min-height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.file-drop-area:hover { border-color: #c8894a; background: rgba(200,137,74,0.05); }
.file-input {
    position: absolute; inset: 0;
    opacity: 0; width: 100%; height: 100%; cursor: pointer;
}
.file-drop-content { pointer-events: none; }
.file-drop-icon { font-size: 1.8rem; margin-bottom: 0.4rem; }
.file-drop-text { font-size: 0.85rem; font-weight: 600; color: var(--text-primary, #374151); }
.file-drop-sub { font-size: 0.75rem; color: var(--text-muted, #888); margin-top: 0.2rem; }
.file-preview { max-height: 120px; border-radius: 8px; object-fit: contain; width: 100%; }

/* ── SUBMIT BTN ── */
.btn-submit {
    width: 100%;
    padding: 0.8rem;
    background: linear-gradient(135deg, #c8894a, #a0622e);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.1s;
    letter-spacing: 0.02em;
}
.btn-submit:hover { opacity: 0.9; }
.btn-submit:active { transform: scale(0.98); }

/* ── TXN LIST ── */
.txn-list { display: flex; flex-direction: column; gap: 0; }

.txn-row {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 0.9rem 0;
    border-bottom: 1px solid var(--border, #f0ebe3);
}
.txn-row:last-child { border-bottom: none; }

.txn-icon { font-size: 1.1rem; flex-shrink: 0; }

.txn-details { flex: 1; min-width: 0; }
.txn-type { font-size: 0.85rem; font-weight: 700; color: var(--text-primary, #1a1a1a); }
.txn-desc { font-size: 0.78rem; color: var(--text-muted, #888); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 0.1rem; }
.txn-date { font-size: 0.72rem; color: #aaa; margin-top: 0.15rem; }

.txn-amount { font-size: 0.95rem; font-weight: 800; flex-shrink: 0; }
.amount-green { color: #059669; }
.amount-red   { color: #dc2626; }

/* ── EMPTY ── */
.empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
    color: var(--text-muted, #aaa);
}
.empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
.empty-state p { font-size: 0.95rem; font-weight: 600; color: var(--text-primary, #555); margin: 0 0 0.25rem; }
.empty-state span { font-size: 0.82rem; }
</style>

<script>
function setAmount(val) {
    document.querySelector('input[name="amount"]').value = val;
}

function previewFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('filePreview');
            const content = document.getElementById('fileDropContent');
            preview.src = e.target.result;
            preview.style.display = 'block';
            content.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection