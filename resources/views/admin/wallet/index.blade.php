@extends('layouts.admin')

@section('title', 'Wallet Management')

@section('content')
<div class="admin-wallet-page">

    <div class="page-header">
        <div>
            <h1 class="page-title">💳 Wallet Management</h1>
            <p class="page-subtitle">Cash-in approvals, withdrawals, and escrow overview</p>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card stat-held">
            <div class="stat-icon">🔒</div>
            <div class="stat-body">
                <div class="stat-val">₱{{ number_format($totalHeld, 2) }}</div>
                <div class="stat-lbl">In Escrow</div>
            </div>
        </div>
        <div class="stat-card stat-in">
            <div class="stat-icon">⬆️</div>
            <div class="stat-body">
                <div class="stat-val">₱{{ number_format($totalPendingIn, 2) }}</div>
                <div class="stat-lbl">Pending Cash-Ins</div>
            </div>
        </div>
        <div class="stat-card stat-out">
            <div class="stat-icon">⬇️</div>
            <div class="stat-body">
                <div class="stat-val">₱{{ number_format($totalPendingOut, 2) }}</div>
                <div class="stat-lbl">Pending Withdrawals</div>
            </div>
        </div>
        <div class="stat-card stat-escrow">
            <div class="stat-icon">📦</div>
            <div class="stat-body">
                <div class="stat-val">{{ $heldEscrows->count() }}</div>
                <div class="stat-lbl">Active Escrows</div>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="tabs-bar">
        <button class="tab-btn active" onclick="switchTab('cashin', this)">
            Cash-In Requests
            @if($pendingCashIns->count() > 0)
                <span class="tab-badge">{{ $pendingCashIns->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('withdrawals', this)">
            Withdrawals
            @if($pendingWithdrawals->count() > 0)
                <span class="tab-badge">{{ $pendingWithdrawals->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('escrows', this)">
            Active Escrows
        </button>
    </div>

    {{-- ── TAB: CASH-INS ── --}}
    <div class="tab-panel" id="tab-cashin">
        @if($pendingCashIns->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">✅</div>
                <p>No pending cash-in requests.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>GCash Ref</th>
                            <th>Proof</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingCashIns as $req)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-name">{{ $req->user->full_name }}</div>
                                    <div class="user-email">{{ $req->user->email }}</div>
                                </div>
                            </td>
                            <td><strong class="amount-highlight">₱{{ number_format($req->amount, 2) }}</strong></td>
                            <td><code class="ref-code">{{ $req->gcash_reference }}</code></td>
                            <td>
                                @if($req->proof_path)
                                    <a href="{{ asset('storage/' . $req->proof_path) }}" target="_blank" class="proof-link">
                                        🖼 View Proof
                                    </a>
                                @else
                                    <span class="text-muted">No file</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $req->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="action-btns">
                                    <form action="{{ route('admin.wallet.cashin.approve', $req) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-approve"
                                            onclick="return confirm('Approve ₱{{ number_format($req->amount,2) }} cash-in for {{ $req->user->first_name }}?')">
                                            ✅ Approve
                                        </button>
                                    </form>
                                    <button type="button" class="btn-reject" onclick="openRejectModal({{ $req->id }})">
                                        ❌ Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                        {{-- Reject modal trigger form (hidden) --}}
                        <tr id="reject-form-{{ $req->id }}" style="display:none;">
                            <td colspan="6">
                                <form action="{{ route('admin.wallet.cashin.reject', $req) }}" method="POST" class="reject-inline-form">
                                    @csrf
                                    <input type="text" name="reason" class="reject-input" placeholder="Reason for rejection..." required>
                                    <button type="submit" class="btn-reject-confirm">Confirm Reject</button>
                                    <button type="button" class="btn-cancel-reject" onclick="closeRejectModal({{ $req->id }})">Cancel</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ── TAB: WITHDRAWALS ── --}}
    <div class="tab-panel" id="tab-withdrawals" style="display:none;">
        @if($pendingWithdrawals->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">✅</div>
                <p>No pending withdrawal requests.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Baker</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Account</th>
                            <th>Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingWithdrawals as $wd)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-name">{{ $wd->user->full_name }}</div>
                                    <div class="user-email">{{ $wd->user->email }}</div>
                                </div>
                            </td>
                            <td><strong class="amount-highlight">₱{{ number_format($wd->amount, 2) }}</strong></td>
                            <td><span class="badge badge-blue">{{ strtoupper($wd->payment_method) }}</span></td>
                            <td>
                                <div class="account-cell">
                                    <div>{{ $wd->account_name }}</div>
                                    <div class="text-muted">{{ $wd->account_number }}</div>
                                </div>
                            </td>
                            <td class="text-muted">{{ $wd->requested_at?->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="action-btns">
                                    <form action="{{ route('admin.wallet.withdrawal.approve', $wd) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-approve"
                                            onclick="return confirm('Approve ₱{{ number_format($wd->amount,2) }} withdrawal for {{ $wd->user->first_name }}?')">
                                            ✅ Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.wallet.withdrawal.reject', $wd) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="admin_note" value="Rejected by admin.">
                                        <button type="submit" class="btn-reject"
                                            onclick="return confirm('Reject this withdrawal?')">
                                            ❌ Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ── TAB: ESCROWS ── --}}
    <div class="tab-panel" id="tab-escrows" style="display:none;">
        @if($heldEscrows->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🔓</div>
                <p>No active escrow holds.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Baker</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Baker Gets</th>
                            <th>Fee</th>
                            <th>Held Since</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heldEscrows as $hold)
                        <tr>
                            <td><strong>#{{ $hold->order_id }}</strong></td>
                            <td>{{ $hold->order->cakeRequest->user->full_name ?? '—' }}</td>
                            <td>{{ $hold->order->baker->full_name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $hold->payment_type === 'downpayment' ? 'badge-orange' : 'badge-green' }}">
                                    {{ ucfirst($hold->payment_type) }}
                                </span>
                            </td>
                            <td><strong>₱{{ number_format($hold->amount, 2) }}</strong></td>
                            <td class="text-green">₱{{ number_format($hold->baker_payout_amount, 2) }}</td>
                            <td class="text-muted">₱{{ number_format($hold->platform_fee_amount, 2) }}</td>
                            <td class="text-muted">{{ $hold->held_at?->format('M d, Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<style>
.admin-wallet-page { padding: 1.5rem; max-width: 100%; margin: 0; }

.page-header { margin-bottom: 1.5rem; }
.page-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 0.25rem; }
.page-subtitle { font-size: 0.875rem; color: #888; margin: 0; }

.alert { padding: 0.875rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 500; margin-bottom: 1.25rem; }
.alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media(max-width:768px){ .stats-row { grid-template-columns: repeat(2,1fr); } }

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid #e8e0d8;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
.stat-icon { font-size: 1.75rem; }
.stat-val { font-size: 1.3rem; font-weight: 800; }
.stat-lbl { font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 0.1rem; }

.stat-held { border-left: 4px solid #f59e0b; }
.stat-in   { border-left: 4px solid #10b981; }
.stat-out  { border-left: 4px solid #ef4444; }
.stat-escrow { border-left: 4px solid #6366f1; }

.tabs-bar { display: flex; gap: 0.5rem; margin-bottom: 1.25rem; border-bottom: 2px solid #e8e0d8; padding-bottom: 0; }
.tab-btn {
    padding: 0.6rem 1.1rem;
    font-size: 0.875rem;
    font-weight: 600;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    cursor: pointer;
    color: #888;
    border-radius: 0;
    display: flex; align-items: center; gap: 0.4rem;
    transition: color 0.15s, border-color 0.15s;
}
.tab-btn.active { color: #c8894a; border-bottom-color: #c8894a; }
.tab-btn:hover { color: #c8894a; }
.tab-badge {
    background: #ef4444; color: #fff;
    font-size: 0.7rem; font-weight: 700;
    border-radius: 10px; padding: 0.1rem 0.45rem;
    min-width: 18px; text-align: center;
}

.table-wrap { overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.data-table th {
    text-align: left; padding: 0.7rem 0.9rem;
    font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; color: #888;
    border-bottom: 2px solid #e8e0d8;
    background: #faf8f5;
}
.data-table td { padding: 0.8rem 0.9rem; border-bottom: 1px solid #f0ebe3; vertical-align: middle; }
.data-table tr:hover td { background: #faf8f5; }

.user-cell { display: flex; flex-direction: column; gap: 0.1rem; }
.user-name { font-weight: 600; color: #1a1a1a; }
.user-email { font-size: 0.78rem; color: #888; }
.account-cell { display: flex; flex-direction: column; gap: 0.1rem; font-size: 0.85rem; }

.amount-highlight { color: #c8894a; font-size: 1rem; }
.text-muted { color: #aaa; font-size: 0.82rem; }
.text-green { color: #059669; font-weight: 600; }

.ref-code {
    background: #f3f4f6; padding: 0.2rem 0.5rem;
    border-radius: 5px; font-size: 0.82rem; font-family: monospace;
}

.proof-link {
    color: #c8894a; font-weight: 600; text-decoration: none; font-size: 0.83rem;
}
.proof-link:hover { text-decoration: underline; }

.badge {
    display: inline-block; padding: 0.2rem 0.6rem;
    border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
}
.badge-orange { background: #fef3c7; color: #92400e; }
.badge-green  { background: #d1fae5; color: #065f46; }
.badge-blue   { background: #dbeafe; color: #1e40af; }

.action-btns { display: flex; gap: 0.5rem; flex-wrap: wrap; }

.btn-approve, .btn-reject {
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: opacity 0.15s;
}
.btn-approve { background: #d1fae5; color: #065f46; }
.btn-approve:hover { background: #a7f3d0; }
.btn-reject { background: #fee2e2; color: #991b1b; }
.btn-reject:hover { background: #fca5a5; }

.reject-inline-form {
    display: flex; gap: 0.5rem; align-items: center;
    padding: 0.75rem; background: #fff7f7;
    border-radius: 8px; flex-wrap: wrap;
}
.reject-input {
    flex: 1; min-width: 200px;
    padding: 0.5rem 0.75rem;
    border: 1.5px solid #fca5a5; border-radius: 8px;
    font-size: 0.85rem;
}
.reject-input:focus { outline: none; border-color: #ef4444; }
.btn-reject-confirm {
    padding: 0.45rem 0.9rem; background: #ef4444; color: #fff;
    border: none; border-radius: 8px; font-size: 0.8rem;
    font-weight: 700; cursor: pointer;
}
.btn-cancel-reject {
    padding: 0.45rem 0.9rem; background: #e5e7eb; color: #374151;
    border: none; border-radius: 8px; font-size: 0.8rem;
    font-weight: 700; cursor: pointer;
}

.empty-state { text-align: center; padding: 3rem 1rem; color: #aaa; }
.empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
.empty-state p { font-size: 0.95rem; font-weight: 600; color: #555; margin: 0; }
</style>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).style.display = 'block';
    btn.classList.add('active');
}

function openRejectModal(id) {
    document.getElementById('reject-form-' + id).style.display = 'table-row';
}
function closeRejectModal(id) {
    document.getElementById('reject-form-' + id).style.display = 'none';
}
</script>
@endsection