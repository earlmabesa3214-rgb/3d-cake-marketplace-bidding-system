@extends('layouts.admin')
@section('title', 'Escrow Management')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
* { font-family: 'Plus Jakarta Sans', sans-serif; }

:root {
    --brown-deep: #3B1F0F;
    --brown-mid:  #7A4A28;
    --caramel:    #C8893A;
    --caramel-light: #E8A94A;
    --warm-white: #FFFDF9;
    --cream:      #F5EFE6;
    --border:     #EAE0D0;
    --text-dark:  #2C1A0E;
    --text-muted: #9A7A5A;
}

.escrow-wrap { padding: 1.5rem; max-width: 100%; margin: 0; }
.page-title { font-size: 1.5rem; font-weight: 800; color: var(--brown-deep); margin-bottom: 0.25rem; }
.page-sub   { font-size: 0.82rem; color: var(--text-muted); margin-bottom: 1.75rem; }

/* Stats row */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
.stat-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 16px; padding: 1.25rem 1.5rem;
}
.stat-label  { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600; }
.stat-value  { font-size: 1.75rem; font-weight: 800; color: var(--brown-deep); margin: 0.25rem 0 0; line-height: 1; }
.stat-sub    { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.2rem; }

/* Tabs */
.tab-nav { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--border); padding-bottom: 0; }
.tab-btn {
    padding: 0.6rem 1.25rem; border-radius: 8px 8px 0 0;
    font-size: 0.82rem; font-weight: 700; cursor: pointer;
    border: none; background: none; color: var(--text-muted);
    border-bottom: 2px solid transparent; margin-bottom: -2px;
    transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.tab-btn.active { color: var(--caramel); border-bottom-color: var(--caramel); }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* Table */
.data-table { width: 100%; border-collapse: collapse; }
.data-table th {
    text-align: left; font-size: 0.65rem; text-transform: uppercase;
    letter-spacing: 0.1em; color: var(--text-muted); font-weight: 700;
    padding: 0.75rem 1rem; border-bottom: 2px solid var(--border);
    background: var(--cream);
}
.data-table td {
    padding: 0.9rem 1rem; border-bottom: 1px solid var(--border);
    font-size: 0.82rem; color: var(--text-dark); vertical-align: middle;
}
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: #FFFAF5; }

/* Badges */
.badge {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.2rem 0.65rem; border-radius: 20px;
    font-size: 0.65rem; font-weight: 700;
}
.badge-pending  { background: #FEF9E8; color: #8A5010; border: 1px solid #F0D090; }
.badge-held     { background: #EBF3FE; color: #1A3A6B; border: 1px solid #BEDAF5; }
.badge-released { background: #EFF5EF; color: #1B4D2E; border: 1px solid #BFDFBE; }
.badge-rejected { background: #FDF0EE; color: #8B2A1E; border: 1px solid #F5C5BE; }

/* Proof thumbnail */
.proof-thumb {
    width: 48px; height: 48px; border-radius: 8px;
    object-fit: cover; border: 1px solid var(--border);
    cursor: zoom-in; transition: transform 0.2s;
}
.proof-thumb:hover { transform: scale(1.1); }

/* Action buttons */
.btn-confirm {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.4rem 0.85rem; border-radius: 8px;
    background: linear-gradient(135deg, #1B4D2E, #2D7A4A);
    color: white; border: none; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-confirm:hover { transform: translateY(-1px); opacity: 0.9; }

.btn-reject {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.4rem 0.85rem; border-radius: 8px;
    background: #FDF0EE; color: #8B2A1E;
    border: 1.5px solid #F5C5BE; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-reject:hover { background: #F5C5BE; }

.btn-approve-withdraw {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.4rem 0.85rem; border-radius: 8px;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-light));
    color: white; border: none; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-approve-withdraw:hover { transform: translateY(-1px); }

/* Modal */
.modal-overlay {
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(20,10,4,0.65); backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem; opacity: 0; pointer-events: none; transition: opacity 0.25s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }
.modal-box {
    background: var(--warm-white); border-radius: 20px;
    width: 100%; max-width: 460px; overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.25);
    transform: translateY(16px) scale(0.97);
    transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.modal-overlay.open .modal-box { transform: translateY(0) scale(1); }
.modal-header { padding: 1.5rem 2rem 1.25rem; color: white; }
.modal-header.green  { background: linear-gradient(135deg, #1B4D2E, #2D7A4A); }
.modal-header.red    { background: linear-gradient(135deg, #5A1A1A, #8B2E2E); }
.modal-header.caramel{ background: linear-gradient(135deg, var(--brown-deep), var(--brown-mid)); }
.modal-header h3 { font-size: 1.1rem; font-weight: 800; margin: 0 0 0.2rem; }
.modal-header p  { font-size: 0.75rem; opacity: 0.7; margin: 0; }
.modal-body  { padding: 1.5rem 2rem; }
.modal-footer{ display: flex; gap: 0.75rem; padding: 0 2rem 1.75rem; }
.modal-input {
    width: 100%; padding: 0.7rem 1rem; border: 1.5px solid var(--border);
    border-radius: 10px; font-size: 0.88rem;
    font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);
    margin-bottom: 0.75rem; background: white;
}
.modal-input:focus { outline: none; border-color: var(--caramel); }
.modal-cancel {
    flex: 1; padding: 0.7rem; border-radius: 10px;
    border: 1.5px solid var(--border); background: white;
    color: var(--text-muted); font-size: 0.85rem; font-weight: 600;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
}
.modal-submit {
    flex: 2; padding: 0.7rem; border-radius: 10px; border: none;
    font-size: 0.85rem; font-weight: 700; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif; color: white;
    transition: all 0.2s;
}
.modal-submit.green  { background: linear-gradient(135deg, #1B4D2E, #2D7A4A); }
.modal-submit.red    { background: linear-gradient(135deg, #8B2A1E, #C44030); }
.modal-submit.caramel{ background: linear-gradient(135deg, var(--caramel), var(--caramel-light)); }

/* Platform account cards */
.account-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1rem;
}

/* Proof lightbox */
.lightbox {
    position: fixed; inset: 0; z-index: 99999;
    background: rgba(0,0,0,0.9); display: none;
    align-items: center; justify-content: center;
}
.lightbox.show { display: flex; }
.lightbox img { max-width: 90vw; max-height: 90vh; border-radius: 12px; }
</style>
@endpush

@section('content')

@php
    $pendingCount     = $pendingPayments->count();
    $heldTotal        = $heldPayments->sum('amount');
    $pendingWithdrawTotal = $pendingWithdrawals->sum('amount');
@endphp

<div class="escrow-wrap">
    <div class="page-title">🔒 Escrow Management</div>
    <div class="page-sub">Review payment proofs, hold funds, release to bakers, and manage withdrawals.</div>

    @if(session('success'))
    <div style="background:#EFF5EF; border:1px solid #BFDFBE; border-radius:12px; padding:0.85rem 1.25rem; margin-bottom:1.25rem; font-size:0.84rem; color:#1B4D2E; display:flex; align-items:center; gap:0.6rem;">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#FDF0EE; border:1px solid #F5C5BE; border-radius:12px; padding:0.85rem 1.25rem; margin-bottom:1.25rem; font-size:0.84rem; color:#8B2A1E; display:flex; align-items:center; gap:0.6rem;">
        ⚠️ {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Pending Review</div>
            <div class="stat-value" style="color:#8A5010;">{{ $pendingCount }}</div>
            <div class="stat-sub">Proofs awaiting verification</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Held in Escrow</div>
            <div class="stat-value" style="color:#1A3A6B;">₱{{ number_format($heldTotal, 2) }}</div>
            <div class="stat-sub">{{ $heldPayments->count() }} payments held</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending Withdrawals</div>
            <div class="stat-value" style="color:var(--caramel);">₱{{ number_format($pendingWithdrawTotal, 2) }}</div>
            <div class="stat-sub">{{ $pendingWithdrawals->count() }} requests</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Platform Fee (5%)</div>
            <div class="stat-value" style="color:#1B4D2E;">
                ₱{{ number_format(\App\Models\BakerOrder::where('payout_status','RELEASED')->sum('platform_fee'), 2) }}
            </div>
            <div class="stat-sub">Total collected</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tab-nav">
        <button class="tab-btn active" onclick="switchTab('pending', this)">
            ⏳ Pending Proofs
            @if($pendingCount > 0)
            <span style="background:#C8893A; color:white; border-radius:20px; padding:0.1rem 0.5rem; font-size:0.62rem; margin-left:0.3rem;">{{ $pendingCount }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('held', this)">🔒 Held in Escrow</button>
        <button class="tab-btn" onclick="switchTab('withdrawals', this)">
            💸 Withdrawals
            @if($pendingWithdrawals->count() > 0)
            <span style="background:#C8893A; color:white; border-radius:20px; padding:0.1rem 0.5rem; font-size:0.62rem; margin-left:0.3rem;">{{ $pendingWithdrawals->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('accounts', this)">⚙️ Platform Accounts</button>
    </div>

    {{-- Tab: Pending Proofs --}}
    <div class="tab-panel active" id="tab-pending">
        @if($pendingPayments->isEmpty())
        <div style="text-align:center; padding:3rem; color:var(--text-muted); font-size:0.88rem;">
            <div style="font-size:2rem; margin-bottom:0.75rem;">✅</div>
            No pending payment proofs. You're all caught up!
        </div>
        @else
        <div style="background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Proof</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingPayments as $payment)
                    <tr>
                        <td>
                            @if($payment->proof_of_payment_path)
                            <img src="{{ asset('storage/'.$payment->proof_of_payment_path) }}"
                                 class="proof-thumb"
                                 onclick="openLightbox('{{ asset('storage/'.$payment->proof_of_payment_path) }}')"
                                 alt="Proof">
                            @else
                            <span style="color:var(--text-muted); font-size:0.75rem;">No image</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:700;">#{{ str_pad($payment->cake_request_id, 4, '0', STR_PAD_LEFT) }}</div>
                            <div style="font-size:0.7rem; color:var(--text-muted);">
                                Baker: {{ $payment->cakeRequest?->bakerOrder?->baker?->first_name ?? '—' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $payment->cakeRequest?->user?->first_name }} {{ $payment->cakeRequest?->user?->last_name }}</div>
                            <div style="font-size:0.7rem; color:var(--text-muted);">{{ $payment->cakeRequest?->user?->email }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $payment->payment_type === 'downpayment' ? 'badge-pending' : 'badge-held' }}">
                                {{ ucfirst($payment->payment_type) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:800; color:var(--brown-deep);">₱{{ number_format($payment->amount, 2) }}</div>
                            <div style="font-size:0.68rem; color:var(--text-muted);">of ₱{{ number_format($payment->agreed_price, 2) }}</div>
                        </td>
                        <td>{{ strtoupper($payment->payment_method ?? '—') }}</td>
                        <td>
                            <code style="font-size:0.78rem; background:var(--cream); padding:0.2rem 0.5rem; border-radius:4px;">
                                {{ $payment->platform_reference ?? '—' }}
                            </code>
                        </td>
                        <td style="font-size:0.75rem; color:var(--text-muted);">
                            {{ $payment->paid_at?->format('M d · g:i A') }}
                        </td>
                        <td>
                            <div style="display:flex; gap:0.4rem; flex-wrap:wrap;">
                                <button class="btn-confirm"
                                    onclick="openConfirmModal({{ $payment->id }}, '{{ $payment->platform_reference }}', '₱{{ number_format($payment->amount, 2) }}')">
                                    ✓ Confirm
                                </button>
                                <button class="btn-reject"
                                    onclick="openRejectModal({{ $payment->id }})">
                                    ✕ Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Tab: Held in Escrow --}}
    <div class="tab-panel" id="tab-held">
        @if($heldPayments->isEmpty())
        <div style="text-align:center; padding:3rem; color:var(--text-muted); font-size:0.88rem;">
            <div style="font-size:2rem; margin-bottom:0.75rem;">🔒</div>
            No funds currently held in escrow.
        </div>
        @else
        <div style="background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Baker</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Held Since</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($heldPayments as $payment)
                    <tr>
                        <td><span style="font-weight:700;">#{{ str_pad($payment->cake_request_id, 4, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $payment->cakeRequest?->user?->first_name }} {{ $payment->cakeRequest?->user?->last_name }}</td>
                        <td>{{ $payment->cakeRequest?->bakerOrder?->baker?->first_name ?? '—' }}</td>
                        <td><span class="badge badge-held">{{ ucfirst($payment->payment_type) }}</span></td>
                        <td><strong>₱{{ number_format($payment->amount, 2) }}</strong></td>
                        <td><code style="font-size:0.78rem; background:var(--cream); padding:0.2rem 0.5rem; border-radius:4px;">{{ $payment->platform_reference }}</code></td>
                        <td style="font-size:0.75rem; color:var(--text-muted);">{{ $payment->held_at?->format('M d · g:i A') }}</td>
                        <td>
                            <span class="badge badge-pending">
                                {{ $payment->cakeRequest?->bakerOrder?->status ?? '—' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Tab: Withdrawals --}}
    <div class="tab-panel" id="tab-withdrawals">
        @if($pendingWithdrawals->isEmpty())
        <div style="text-align:center; padding:3rem; color:var(--text-muted); font-size:0.88rem;">
            <div style="font-size:2rem; margin-bottom:0.75rem;">💸</div>
            No pending withdrawal requests.
        </div>
        @else
        <div style="background:var(--warm-white); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Baker</th>
                        <th>Amount</th>
                        <th>Send To</th>
                        <th>Account</th>
                        <th>Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingWithdrawals as $wr)
                    <tr>
                        <td>
                            <div style="font-weight:700;">{{ $wr->baker?->first_name }} {{ $wr->baker?->last_name }}</div>
                            <div style="font-size:0.7rem; color:var(--text-muted);">{{ $wr->baker?->email }}</div>
                        </td>
                        <td><strong style="font-size:1rem; color:var(--caramel);">₱{{ number_format($wr->amount, 2) }}</strong></td>
                        <td><span class="badge badge-pending">{{ strtoupper($wr->payment_method) }}</span></td>
                        <td>
                            <div style="font-weight:600;">{{ $wr->account_name }}</div>
                            <code style="font-size:0.78rem; background:var(--cream); padding:0.15rem 0.45rem; border-radius:4px;">{{ $wr->account_number }}</code>
                        </td>
                        <td style="font-size:0.75rem; color:var(--text-muted);">{{ $wr->requested_at?->format('M d, Y · g:i A') }}</td>
                        <td>
                            <div style="display:flex; gap:0.4rem;">
                                <button class="btn-approve-withdraw"
                                    onclick="openApproveWithdrawalModal({{ $wr->id }}, '{{ $wr->baker?->first_name }}', '₱{{ number_format($wr->amount, 2) }}', '{{ $wr->account_number }}')">
                                    ✓ Approve & Send
                                </button>
                                <button class="btn-reject"
                                    onclick="openRejectWithdrawalModal({{ $wr->id }})">
                                    ✕ Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Tab: Platform Accounts --}}
    <div class="tab-panel" id="tab-accounts">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
            @foreach($platformAccounts as $account)
            <div class="account-card">
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                    <div style="width:40px; height:40px; border-radius:10px; background:linear-gradient(135deg,var(--caramel),var(--caramel-light)); display:flex; align-items:center; justify-content:center; font-size:1.1rem;">
                        {{ $account->type === 'gcash' ? '💙' : '💚' }}
                    </div>
                    <div>
                        <div style="font-weight:800; font-size:0.95rem; color:var(--brown-deep);">{{ strtoupper($account->type) }}</div>
                        <div style="font-size:0.72rem; color:var(--text-muted);">Platform collection account</div>
                    </div>
                    <span class="badge {{ $account->is_active ? 'badge-released' : 'badge-rejected' }}" style="margin-left:auto;">
                        {{ $account->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                @if($account->qr_code_path)
                <div style="text-align:center; margin-bottom:1rem;">
                    <img src="{{ asset('storage/'.$account->qr_code_path) }}"
                         style="width:120px; height:120px; object-fit:contain; border-radius:10px; border:1px solid var(--border); cursor:zoom-in;"
                         onclick="openLightbox('{{ asset('storage/'.$account->qr_code_path) }}')">
                </div>
                @endif

                <div style="background:var(--cream); border-radius:10px; padding:0.85rem 1rem; margin-bottom:1rem; font-size:0.84rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                        <span style="color:var(--text-muted); font-size:0.68rem; text-transform:uppercase; letter-spacing:0.08em; font-weight:600;">Account Name</span>
                        <span style="font-weight:700;">{{ $account->account_name }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--text-muted); font-size:0.68rem; text-transform:uppercase; letter-spacing:0.08em; font-weight:600;">Number</span>
                        <span style="font-weight:700;">{{ $account->account_number }}</span>
                    </div>
                </div>

                <form method="POST"
                      action="{{ route('admin.escrow.account.update', $account->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom:0.6rem;">
                        <label style="font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.3rem;">Account Name</label>
                        <input type="text" name="account_name" class="modal-input" style="margin:0;"
                               value="{{ $account->account_name }}">
                    </div>
                    <div style="margin-bottom:0.6rem;">
                        <label style="font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.3rem;">Account Number</label>
                        <input type="text" name="account_number" class="modal-input" style="margin:0;"
                               value="{{ $account->account_number }}">
                    </div>
                    <div style="margin-bottom:0.75rem;">
                        <label style="font-size:0.65rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.3rem;">Update QR Code</label>
                        <input type="file" name="qr_code" accept="image/*"
                               style="font-size:0.8rem; width:100%;">
                    </div>
                    <button type="submit" class="btn-confirm" style="width:100%; justify-content:center; padding:0.6rem;">
                        💾 Save Changes
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ── CONFIRM PAYMENT MODAL ── --}}
<div class="modal-overlay" id="modal-confirm-payment">
    <div class="modal-box">
        <div class="modal-header green">
            <h3>✓ Confirm Payment Receipt</h3>
            <p>Verify you've received this payment in the platform account</p>
        </div>
        <div class="modal-body">
            <div style="background:var(--cream); border-radius:12px; padding:1rem 1.25rem; margin-bottom:1rem; font-size:0.84rem;" id="confirm-payment-detail"></div>
            <label style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.4rem;">
                Confirm Reference Number *
            </label>
            <input type="text" class="modal-input" id="confirm-ref-input"
                   placeholder="Enter reference number to confirm">
            <div style="font-size:0.72rem; color:var(--text-muted); line-height:1.5;">
                Once confirmed, funds will be held in escrow and the baker will be notified to start preparing.
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-cancel" onclick="closeModal('modal-confirm-payment')">Cancel</button>
            <button class="modal-submit green" onclick="submitConfirmPayment()">✓ Confirm & Hold in Escrow</button>
        </div>
    </div>
</div>

{{-- ── REJECT PAYMENT MODAL ── --}}
<div class="modal-overlay" id="modal-reject-payment">
    <div class="modal-box">
        <div class="modal-header red">
            <h3>✕ Reject Payment Proof</h3>
            <p>Customer will be asked to resubmit</p>
        </div>
        <div class="modal-body">
            <label style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.4rem;">Reason *</label>
            <select class="modal-input" id="reject-reason-select">
                @foreach(\App\Models\Payment::REJECTION_REASONS as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <label style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.4rem;">Note (optional)</label>
            <textarea class="modal-input" id="reject-note-input" rows="3"
                      placeholder="Additional details for the customer…" style="resize:vertical;"></textarea>
        </div>
        <div class="modal-footer">
            <button class="modal-cancel" onclick="closeModal('modal-reject-payment')">Cancel</button>
            <button class="modal-submit red" onclick="submitRejectPayment()">✕ Reject Proof</button>
        </div>
    </div>
</div>

{{-- ── APPROVE WITHDRAWAL MODAL ── --}}
<div class="modal-overlay" id="modal-approve-withdrawal">
    <div class="modal-box">
        <div class="modal-header caramel">
            <h3>💸 Approve Withdrawal</h3>
            <p>Confirm you've sent the funds manually</p>
        </div>
        <div class="modal-body">
            <div style="background:var(--cream); border-radius:12px; padding:1rem 1.25rem; margin-bottom:1rem; font-size:0.84rem;" id="withdrawal-detail"></div>
            <label style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.4rem;">Admin Note (optional)</label>
            <input type="text" class="modal-input" id="withdrawal-admin-note"
                   placeholder="e.g. Sent via GCash ref #1234567890">
        </div>
        <div class="modal-footer">
            <button class="modal-cancel" onclick="closeModal('modal-approve-withdrawal')">Cancel</button>
            <button class="modal-submit caramel" onclick="submitApproveWithdrawal()">✓ Mark as Sent</button>
        </div>
    </div>
</div>

{{-- ── REJECT WITHDRAWAL MODAL ── --}}
<div class="modal-overlay" id="modal-reject-withdrawal">
    <div class="modal-box">
        <div class="modal-header red">
            <h3>✕ Reject Withdrawal</h3>
            <p>Funds stay in baker's wallet</p>
        </div>
        <div class="modal-body">
            <label style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); display:block; margin-bottom:0.4rem;">Reason *</label>
            <textarea class="modal-input" id="reject-withdrawal-note" rows="3"
                      placeholder="Reason for rejection…" style="resize:vertical;"></textarea>
        </div>
        <div class="modal-footer">
            <button class="modal-cancel" onclick="closeModal('modal-reject-withdrawal')">Cancel</button>
            <button class="modal-submit red" onclick="submitRejectWithdrawal()">✕ Reject Request</button>
        </div>
    </div>
</div>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <img src="" id="lightbox-img" alt="Proof">
</div>

{{-- Hidden forms --}}
<form id="form-confirm-payment" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="platform_reference" id="form-confirm-ref">
</form>
<form id="form-reject-payment" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="rejection_reason" id="form-reject-reason">
    <input type="hidden" name="rejection_note"   id="form-reject-note">
</form>
<form id="form-approve-withdrawal" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="admin_note" id="form-approve-note">
</form>
<form id="form-reject-withdrawal" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="admin_note" id="form-reject-wd-note">
</form>

@push('scripts')
<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
}

let _confirmPaymentId = null;
function openConfirmModal(id, ref, amount) {
    _confirmPaymentId = id;
    document.getElementById('confirm-ref-input').value = ref || '';
    document.getElementById('confirm-payment-detail').innerHTML =
        `<strong>Payment #${id}</strong> · Amount: <strong style="color:var(--caramel)">${amount}</strong><br>
         <span style="font-size:0.75rem; color:var(--text-muted);">Submitted reference: <code>${ref || 'None'}</code></span>`;
    openModal('modal-confirm-payment');
}
function submitConfirmPayment() {
    const ref = document.getElementById('confirm-ref-input').value.trim();
    if (!ref) { alert('Please enter the reference number.'); return; }
    document.getElementById('form-confirm-ref').value = ref;
    document.getElementById('form-confirm-payment').action =
        `/admin/escrow/payments/${_confirmPaymentId}/confirm`;
    document.getElementById('form-confirm-payment').submit();
}

let _rejectPaymentId = null;
function openRejectModal(id) {
    _rejectPaymentId = id;
    document.getElementById('reject-reason-select').selectedIndex = 0;
    document.getElementById('reject-note-input').value = '';
    openModal('modal-reject-payment');
}
function submitRejectPayment() {
    document.getElementById('form-reject-reason').value =
        document.getElementById('reject-reason-select').value;
    document.getElementById('form-reject-note').value =
        document.getElementById('reject-note-input').value;
    document.getElementById('form-reject-payment').action =
        `/admin/escrow/payments/${_rejectPaymentId}/reject`;
    document.getElementById('form-reject-payment').submit();
}

let _approveWithdrawalId = null;
function openApproveWithdrawalModal(id, name, amount, account) {
    _approveWithdrawalId = id;
    document.getElementById('withdrawal-admin-note').value = '';
    document.getElementById('withdrawal-detail').innerHTML =
        `Send <strong style="color:var(--caramel)">${amount}</strong> to <strong>${name}</strong><br>
         Account: <code>${account}</code>`;
    openModal('modal-approve-withdrawal');
}
function submitApproveWithdrawal() {
    document.getElementById('form-approve-note').value =
        document.getElementById('withdrawal-admin-note').value;
    document.getElementById('form-approve-withdrawal').action =
        `/admin/escrow/withdrawals/${_approveWithdrawalId}/approve`;
    document.getElementById('form-approve-withdrawal').submit();
}

let _rejectWithdrawalId = null;
function openRejectWithdrawalModal(id) {
    _rejectWithdrawalId = id;
    document.getElementById('reject-withdrawal-note').value = '';
    openModal('modal-reject-withdrawal');
}
function submitRejectWithdrawal() {
    const note = document.getElementById('reject-withdrawal-note').value.trim();
    if (!note) { alert('Please provide a reason.'); return; }
    document.getElementById('form-reject-wd-note').value = note;
    document.getElementById('form-reject-withdrawal').action =
        `/admin/escrow/withdrawals/${_rejectWithdrawalId}/reject`;
    document.getElementById('form-reject-withdrawal').submit();
}

function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open')
        .forEach(m => closeModal(m.id));
});

function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.add('show');
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('show');
}
</script>
@endpush

@endsection