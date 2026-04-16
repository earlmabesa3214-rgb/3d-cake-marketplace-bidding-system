@extends('layouts.customer')

@section('title', 'My Wallet')

@section('content')
<div class="wallet-page">

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success"><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><span>{{ session('error') }}</span></div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">My Wallet</h1>
            <p class="page-subtitle">Manage your balance and transactions</p>
        </div>
    </div>

    {{-- BALANCE ROW --}}
    <div class="balance-row">
        <div class="bal-card">
            <div class="bal-card-bg"></div>
            <div class="bal-label">Available Balance</div>
            <div class="bal-amount">₱{{ number_format($wallet->balance, 2) }}</div>
            <div class="wallet-icon-bg">💳</div>
        </div>
        <div class="stat-card stat-deposited">
            <div class="stat-lbl">Total Deposited</div>
            <div class="stat-amt">₱{{ number_format($wallet->total_deposited, 2) }}</div>
        </div>
        <div class="stat-card stat-spent">
            <div class="stat-lbl">Total Spent</div>
            <div class="stat-amt">₱{{ number_format($wallet->total_spent, 2) }}</div>
        </div>
    </div>

    {{-- PENDING NOTICE --}}
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

        {{-- CASH IN FORM --}}
        @if(!$pendingCashin)
        <div class="card cashin-card">
            <div class="card-head">
                <div class="card-title">💰 Top Up via GCash</div>
                <div class="card-desc">Send money to our GCash number, then upload your proof here.</div>
            </div>

            <div class="gcash-info-box">
                <div class="gcash-number-label">Send to GCash Number</div>
                <div class="gcash-number">0917 – XXX – XXXX</div>
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
                <button type="submit" class="btn-submit">Submit Cash-In Request</button>
            </form>
        </div>
        @endif

        {{-- TRANSACTION HISTORY --}}
        <div class="card txn-card">
            <div class="card-head">
                <div class="card-title">📋 Transaction History</div>
            </div>

            @if($transactions->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🪙</div>
                    <p>No transactions yet.</p>
                    <span>Your transaction history will appear here.</span>
                </div>
            @else
                <table class="txn-table">
                    <thead>
                        <tr>
                            <th style="width:38%">Description</th>
                            <th style="width:18%">Type</th>
                            <th style="width:26%">Date</th>
                            <th style="width:18%;text-align:right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $txn)
                        <tr>
                            <td>
                                <div class="txn-type">{{ $txn->typeLabel() }}</div>
                                <div class="txn-desc">{{ $txn->description ?? '—' }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $txn->isCredit() ? 'badge-credit' : 'badge-debit' }}">
                                    {{ $txn->isCredit() ? 'Credit' : 'Debit' }}
                                </span>
                            </td>
                            <td>
                                <div class="txn-date-main">{{ $txn->created_at->format('M d, Y') }}</div>
                                <div class="txn-date-sub">{{ $txn->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="{{ $txn->isCredit() ? 'amount-green' : 'amount-red' }}">
                                {{ $txn->isCredit() ? '+' : '-' }}₱{{ number_format($txn->amount, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
@if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
                <div class="txn-pagination">
                    <div class="pagination-info">
                        Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} resultsShowing {{ $transactions->firstItem() ?? 1 }} to {{ $transactions->lastItem() ?? $transactions->count() }} of {{ $transactions->total() ?? $transactions->count() }} results
                    </div>
                    <ul class="pagination">
                        <li class="{{ $transactions->onFirstPage() ? 'disabled' : '' }}">
                            @if($transactions->onFirstPage()) <span>‹</span>
                            @else <a href="{{ $transactions->previousPageUrl() }}">‹</a> @endif
                        </li>
                        @foreach($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                        <li class="{{ $page == $transactions->currentPage() ? 'active' : '' }}">
                            @if($page == $transactions->currentPage()) <span>{{ $page }}</span>
                            @else <a href="{{ $url }}">{{ $page }}</a> @endif
                        </li>
                        @endforeach
                        <li class="{{ !$transactions->hasMorePages() ? 'disabled' : '' }}">
                            @if($transactions->hasMorePages()) <a href="{{ $transactions->nextPageUrl() }}">›</a>
                            @else <span>›</span> @endif
                        </li>
                    </ul>
                </div>
                @endif
            @endif
        </div>

    </div>
</div>

<style>
.wallet-page { padding: 1.5rem 2rem; max-width: 100%; }

.page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
.page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.4rem; font-weight: 800; color: var(--brown-deep); letter-spacing: -0.02em; }
.page-subtitle { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.1rem; }

.alert { display: flex; align-items: center; gap: 0.75rem; padding: 0.875rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 500; margin-bottom: 1.25rem; }
.alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

/* BALANCE ROW */
.balance-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem; }

.bal-card { position: relative; background: linear-gradient(135deg, #c8894a 0%, #a0622e 60%, #7a4520 100%); border-radius: 16px; padding: 1.25rem 1.5rem; color: #fff; overflow: hidden; box-shadow: 0 6px 24px rgba(160,98,46,0.3); }
.bal-card-bg { position: absolute; top: -30px; right: -30px; width: 140px; height: 140px; background: rgba(255,255,255,0.07); border-radius: 50%; }
.bal-label { font-size: 0.68rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.75; margin-bottom: 0.35rem; position: relative; z-index: 1; }
.bal-amount { font-size: 1.9rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.1; position: relative; z-index: 1; }
.wallet-icon-bg { position: absolute; bottom: -10px; right: 16px; font-size: 4.5rem; opacity: 0.1; z-index: 0; user-select: none; }

.stat-card { background: var(--warm-white, #fff); border: 1px solid var(--border, #e8e0d8); border-radius: 16px; padding: 1.25rem 1.5rem; }
.stat-lbl { font-size: 0.68rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted, #9a8a7a); margin-bottom: 0.35rem; }
.stat-amt { font-size: 1.5rem; font-weight: 800; }
.stat-deposited .stat-amt { color: #059669; }
.stat-spent .stat-amt { color: #dc2626; }

/* PENDING */
.pending-notice { display: flex; align-items: flex-start; gap: 1rem; background: #fffbeb; border: 1px solid #fcd34d; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
.pending-icon { font-size: 1.4rem; }
.pending-text { display: flex; flex-direction: column; gap: 0.2rem; font-size: 0.875rem; color: #92400e; }
.pending-text strong { font-size: 0.9rem; color: #78350f; }
.pending-sub { font-size: 0.78rem; opacity: 0.8; }

/* GRID */
.wallet-grid { display: grid; grid-template-columns: 400px 1fr; gap: 1.25rem; }
@media (max-width: 900px) { .wallet-grid { grid-template-columns: 1fr; } .balance-row { grid-template-columns: 1fr; } }

/* CARDS */
.card { background: var(--warm-white, #fff); border: 1px solid var(--border, #e8e0d8); border-radius: 16px; overflow: hidden; }
.card-head { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border, #f0ebe3); }
.card-title { font-size: 0.95rem; font-weight: 700; color: var(--text-dark, #1a1a1a); display: flex; align-items: center; gap: 0.5rem; margin: 0 0 0.2rem; }
.card-desc { font-size: 0.78rem; color: var(--text-muted, #9a8a7a); margin: 0; }

/* GCASH */
.gcash-info-box { margin: 1rem 1.5rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd; border-radius: 12px; padding: 0.85rem 1rem; text-align: center; }
.gcash-number-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.08em; color: #0369a1; font-weight: 600; margin-bottom: 0.25rem; }
.gcash-number { font-size: 1.25rem; font-weight: 800; color: #0c4a6e; letter-spacing: 0.05em; }
.gcash-name { font-size: 0.72rem; color: #0369a1; margin-top: 0.15rem; }

/* FORM */
.cashin-form { display: flex; flex-direction: column; gap: 0.9rem; padding: 0 1.5rem 1.5rem; }
.form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.form-label { font-size: 0.75rem; font-weight: 600; color: var(--text-dark, #374151); }
.form-input { width: 100%; padding: 0.6rem 0.85rem; border: 1.5px solid var(--border, #d1c8bc); border-radius: 10px; font-size: 0.875rem; background: var(--input-bg, #faf8f5); color: var(--text-dark, #1a1a1a); transition: border-color 0.2s; box-sizing: border-box; }
.form-input:focus { outline: none; border-color: #c8894a; box-shadow: 0 0 0 3px rgba(200,137,74,0.12); }
.form-input.is-error { border-color: #ef4444; }
.input-prefix-wrap { position: relative; }
.input-prefix { position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); font-weight: 700; color: #c8894a; font-size: 0.875rem; pointer-events: none; }
.input-prefix-wrap .form-input { padding-left: 1.7rem; }
.field-error { font-size: 0.72rem; color: #ef4444; }
.quick-amounts { display: flex; gap: 0.4rem; flex-wrap: wrap; margin-top: 0.25rem; }
.quick-btn { padding: 0.25rem 0.65rem; background: transparent; border: 1.5px solid #c8894a; border-radius: 20px; font-size: 0.72rem; font-weight: 600; color: #c8894a; cursor: pointer; transition: all 0.15s; }
.quick-btn:hover { background: #c8894a; color: #fff; }

.file-drop-area { position: relative; border: 2px dashed var(--border, #d1c8bc); border-radius: 10px; padding: 1.25rem; text-align: center; cursor: pointer; background: var(--input-bg, #faf8f5); min-height: 100px; display: flex; align-items: center; justify-content: center; transition: border-color 0.2s; }
.file-drop-area:hover { border-color: #c8894a; background: rgba(200,137,74,0.04); }
.file-input { position: absolute; inset: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
.file-drop-content { pointer-events: none; }
.file-drop-icon { font-size: 1.5rem; margin-bottom: 0.35rem; }
.file-drop-text { font-size: 0.78rem; font-weight: 600; color: var(--text-dark, #374151); }
.file-drop-sub { font-size: 0.68rem; color: var(--text-muted, #9a8a7a); margin-top: 0.15rem; }
.file-preview { max-height: 100px; border-radius: 8px; object-fit: contain; width: 100%; }

.btn-submit { width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #c8894a, #a0622e); color: #fff; border: none; border-radius: 10px; font-size: 0.875rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s, transform 0.1s; letter-spacing: 0.02em; }
.btn-submit:hover { opacity: 0.9; }
.btn-submit:active { transform: scale(0.98); }

/* TXN TABLE */
.txn-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
.txn-table th { padding: 0.75rem 1.25rem; text-align: left; font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-muted, #9a8a7a); border-bottom: 1px solid var(--border, #f0ebe3); font-weight: 600; background: var(--cream, #faf8f5); }
.txn-table td { padding: 0.85rem 1.25rem; font-size: 0.82rem; border-bottom: 1px solid var(--border, #f0ebe3); color: var(--text-dark, #1a1a1a); vertical-align: middle; }
.txn-table tr:last-child td { border-bottom: none; }
.txn-table tbody tr:hover td { background: #fef9f4; }
.txn-type { font-weight: 700; font-size: 0.82rem; color: var(--text-dark, #1a1a1a); }
.txn-desc { font-size: 0.72rem; color: var(--text-muted, #9a8a7a); margin-top: 0.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.txn-date-main { font-size: 0.78rem; font-weight: 600; }
.txn-date-sub { font-size: 0.68rem; color: #bbb; margin-top: 0.1rem; }
.amount-green { font-weight: 800; color: #059669; text-align: right; }
.amount-red { font-weight: 800; color: #dc2626; text-align: right; }
.badge { display: inline-flex; align-items: center; padding: 0.22rem 0.65rem; border-radius: 20px; font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; }
.badge-credit { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.badge-debit { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

.txn-pagination { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; padding: 1rem 1.25rem; border-top: 1px solid var(--border, #f0ebe3); }
.pagination-info { font-size: 0.72rem; color: var(--text-muted); }
.pagination { display: flex; align-items: center; gap: 0.3rem; list-style: none; margin: 0; padding: 0; }
.pagination li span, .pagination li a { display: inline-flex; align-items: center; justify-content: center; min-width: 30px; height: 30px; padding: 0 0.4rem; border-radius: 8px; font-size: 0.75rem; font-weight: 600; text-decoration: none; border: 1.5px solid var(--border); color: var(--text-muted); background: transparent; transition: all 0.2s; cursor: pointer; }
.pagination li a:hover { border-color: var(--caramel); color: var(--caramel); background: #FEF3E8; }
.pagination li.active span { background: var(--caramel); color: white; border-color: var(--caramel); }
.pagination li.disabled span { opacity: 0.4; cursor: not-allowed; }

.empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-muted, #9a8a7a); }
.empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
.empty-state p { font-size: 0.9rem; font-weight: 600; color: var(--text-dark, #555); margin: 0 0 0.2rem; }
.empty-state span { font-size: 0.78rem; }
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
</script> b
@endsection