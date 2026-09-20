@extends('layouts.admin')

@section('title', 'Wallet Management')

@section('content')
<div class="admin-wallet-page">

    <div class="page-header">
        <div class="page-header-text">
            <div class="page-title-row">
                <span class="page-title-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="14" rx="2.5"/><path d="M2 10h20"/><path d="M16 14.5h2.5"/></svg>
                </span>
                <h1 class="page-title">Wallet Management</h1>
            </div>
            <p class="page-subtitle">Cash-in approvals, withdrawals, and escrow overview</p>
        </div>
        <div class="page-header-meta">
            <span class="live-dot"></span> Live overview &middot; updated {{ now()->format('M d, H:i') }}
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card stat-held">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">₱{{ number_format($totalHeld, 2) }}</div>
                <div class="stat-lbl">In Escrow</div>
            </div>
        </div>
        <div class="stat-card stat-in">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">₱{{ number_format($totalPendingIn, 2) }}</div>
                <div class="stat-lbl">Pending Cash-Ins</div>
            </div>
        </div>
        <div class="stat-card stat-out">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M19 12l-7 7-7-7"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">₱{{ number_format($totalPendingOut, 2) }}</div>
                <div class="stat-lbl">Pending Withdrawals</div>
            </div>
        </div>
        <div class="stat-card stat-escrow">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $heldEscrows->count() }}</div>
                <div class="stat-lbl">Active Escrows</div>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="tabs-bar">
        <button class="tab-btn active" onclick="switchTab('cashin', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
            Cash-In Requests
            @if($pendingCashIns->count() > 0)
                <span class="tab-badge">{{ $pendingCashIns->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('withdrawals', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M19 12l-7 7-7-7"/></svg>
            Withdrawals
            @if($pendingWithdrawals->count() > 0)
                <span class="tab-badge">{{ $pendingWithdrawals->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('escrows', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            Active Escrows
        </button>
    </div>

    {{-- ── TAB: CASH-INS ── --}}
    <div class="tab-panel" id="tab-cashin">
        @if($pendingCashIns->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <p>No pending cash-in requests.</p>
                <span class="empty-sub">New requests will show up here automatically.</span>
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
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingCashIns as $req)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($req->user->full_name, 0, 1)) }}</div>
                                    <div>
                                        <div class="user-name">{{ $req->user->full_name }}</div>
                                        <div class="user-email">{{ $req->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><strong class="amount-highlight">₱{{ number_format($req->amount, 2) }}</strong></td>
                            <td><code class="ref-code">{{ $req->gcash_reference }}</code></td>
                            <td>
                                @if($req->proof_path)
                                    <a href="{{ asset('storage/' . $req->proof_path) }}" target="_blank" class="proof-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        View Proof
                                    </a>
                                @else
                                    <span class="text-muted">No file</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $req->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-approve"
                                        onclick="openApproveModal('{{ route('admin.wallet.cashin.approve', $req) }}', '{{ number_format($req->amount,2) }}', '{{ $req->user->first_name }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        Approve
                                    </button>
                                    <button type="button" class="btn-reject"
                                        onclick="openRejectModal('{{ route('admin.wallet.cashin.reject', $req) }}', '{{ number_format($req->amount,2) }}', '{{ $req->user->first_name }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
                                        Reject
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

    {{-- ── TAB: WITHDRAWALS ── --}}
    <div class="tab-panel" id="tab-withdrawals" style="display:none;">
        @if($pendingWithdrawals->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <p>No pending withdrawal requests.</p>
                <span class="empty-sub">Baker payout requests will appear here.</span>
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
                            <th class="th-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingWithdrawals as $wd)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($wd->user->full_name, 0, 1)) }}</div>
                                    <div>
                                        <div class="user-name">{{ $wd->user->full_name }}</div>
                                        <div class="user-email">{{ $wd->user->email }}</div>
                                    </div>
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
                                    <button type="button" class="btn-approve"
                                        onclick="openWdApproveModal('{{ route('admin.wallet.withdrawal.approve', $wd) }}', '{{ number_format($wd->amount,2) }}', '{{ $wd->user->first_name }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        Approve &amp; Upload Receipt
                                    </button>
                                    <button type="button" class="btn-reject"
                                        onclick="openWdRejectModal('{{ route('admin.wallet.withdrawal.reject', $wd) }}', '{{ number_format($wd->amount,2) }}', '{{ $wd->user->first_name }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
                                        Reject
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

    {{-- ── TAB: ESCROWS ── --}}
    <div class="tab-panel" id="tab-escrows" style="display:none;">
        @if($heldEscrows->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                </div>
                <p>No active escrow holds.</p>
                <span class="empty-sub">Funds held for in-progress orders will appear here.</span>
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
:root {
    --wallet-accent: #c8894a;
    --wallet-accent-dark: #a86f38;
    --wallet-bg: #faf8f5;
    --wallet-border: #e8e0d8;
    --wallet-ink: #1a1a1a;
    --wallet-muted: #8a8681;
    --wallet-amber: #f59e0b;
    --wallet-green: #10b981;
    --wallet-red: #ef4444;
    --wallet-indigo: #6366f1;
}

.admin-wallet-page { padding: 1.5rem; max-width: 100%; margin: 0; color: var(--wallet-ink); }

.page-header {
    display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap;
    gap: 0.75rem; margin-bottom: 1.75rem;
}
.page-title-row { display: flex; align-items: center; gap: 0.6rem; }
.page-title-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(145deg, var(--wallet-accent), var(--wallet-accent-dark));
    color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.page-title-icon svg { width: 20px; height: 20px; }
.page-title { font-size: 1.4rem; font-weight: 700; margin: 0; letter-spacing: -0.01em; }
.page-subtitle { font-size: 0.875rem; color: var(--wallet-muted); margin: 0.2rem 0 0 3.15rem; }
.page-header-meta {
    font-size: 0.78rem; color: var(--wallet-muted); display: flex; align-items: center; gap: 0.4rem;
}
.live-dot {
    width: 7px; height: 7px; border-radius: 50%; background: var(--wallet-green); display: inline-block;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.18);
}

.alert { padding: 0.875rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 500; margin-bottom: 1.25rem; }
.alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
@media(max-width:768px){ .stats-row { grid-template-columns: repeat(2,1fr); } }

.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.35rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid var(--wallet-border);
    box-shadow: 0 1px 2px rgba(20,15,10,0.03), 0 8px 20px -14px rgba(20,15,10,0.15);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 10px -4px rgba(20,15,10,0.1), 0 14px 28px -14px rgba(20,15,10,0.18); }

.stat-icon {
    width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.stat-icon svg { width: 22px; height: 22px; }

.stat-val { font-size: 1.35rem; font-weight: 800; line-height: 1.1; letter-spacing: -0.01em; }
.stat-lbl { font-size: 0.72rem; color: var(--wallet-muted); text-transform: uppercase; letter-spacing: 0.07em; margin-top: 0.25rem; font-weight: 600; }

.stat-held   .stat-icon { background: rgba(245,158,11,0.12); color: var(--wallet-amber); }
.stat-in     .stat-icon { background: rgba(16,185,129,0.12); color: var(--wallet-green); }
.stat-out    .stat-icon { background: rgba(239,68,68,0.12);  color: var(--wallet-red); }
.stat-escrow .stat-icon { background: rgba(99,102,241,0.12); color: var(--wallet-indigo); }

.stat-held   { border-top: 3px solid var(--wallet-amber); }
.stat-in     { border-top: 3px solid var(--wallet-green); }
.stat-out    { border-top: 3px solid var(--wallet-red); }
.stat-escrow { border-top: 3px solid var(--wallet-indigo); }

.tabs-bar { display: flex; gap: 0.5rem; margin-bottom: 1.25rem; border-bottom: 2px solid var(--wallet-border); padding-bottom: 0; }
.tab-btn {
    padding: 0.65rem 1.1rem;
    font-size: 0.875rem;
    font-weight: 600;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    cursor: pointer;
    color: var(--wallet-muted);
    border-radius: 0;
    display: flex; align-items: center; gap: 0.45rem;
    transition: color 0.15s, border-color 0.15s;
}
.tab-btn svg { width: 16px; height: 16px; }
.tab-btn.active { color: var(--wallet-accent); border-bottom-color: var(--wallet-accent); }
.tab-btn:hover { color: var(--wallet-accent); }
.tab-badge {
    background: var(--wallet-red); color: #fff;
    font-size: 0.7rem; font-weight: 700;
    border-radius: 10px; padding: 0.1rem 0.45rem;
    min-width: 18px; text-align: center;
}

.table-wrap {
    overflow-x: auto; background: #fff; border: 1px solid var(--wallet-border);
    border-radius: 14px; box-shadow: 0 1px 2px rgba(20,15,10,0.03);
}
.data-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.data-table th {
    text-align: left; padding: 0.8rem 1rem;
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; color: var(--wallet-muted);
    border-bottom: 1px solid var(--wallet-border);
    background: var(--wallet-bg);
}
.data-table th:first-child { border-top-left-radius: 14px; }
.data-table th:last-child { border-top-right-radius: 14px; }
.th-actions { text-align: right; }
.data-table td { padding: 0.85rem 1rem; border-bottom: 1px solid #f0ebe3; vertical-align: middle; }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: #fbf9f6; }

.user-cell { display: flex; align-items: center; gap: 0.65rem; }
.user-avatar {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(145deg, var(--wallet-accent), var(--wallet-accent-dark));
    color: #fff; font-size: 0.8rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}
.user-name { font-weight: 600; color: var(--wallet-ink); }
.user-email { font-size: 0.78rem; color: var(--wallet-muted); }
.account-cell { display: flex; flex-direction: column; gap: 0.1rem; font-size: 0.85rem; }

.amount-highlight { color: var(--wallet-accent-dark); font-size: 1rem; }
.text-muted { color: #a7a29b; font-size: 0.82rem; }
.text-green { color: #059669; font-weight: 600; }

.ref-code {
    background: #f3f4f6; padding: 0.2rem 0.5rem;
    border-radius: 5px; font-size: 0.82rem; font-family: 'SFMono-Regular', Consolas, monospace;
}

.proof-link {
    color: var(--wallet-accent-dark); font-weight: 600; text-decoration: none; font-size: 0.83rem;
    display: inline-flex; align-items: center; gap: 0.35rem;
}
.proof-link svg { width: 15px; height: 15px; }
.proof-link:hover { text-decoration: underline; }

.badge {
    display: inline-block; padding: 0.22rem 0.65rem;
    border-radius: 20px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em;
}
.badge-orange { background: #fef3c7; color: #92400e; }
.badge-green  { background: #d1fae5; color: #065f46; }
.badge-blue   { background: #dbeafe; color: #1e40af; }

.action-btns { display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: flex-end; }

.btn-approve, .btn-reject {
    padding: 0.45rem 0.9rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    display: inline-flex; align-items: center; gap: 0.35rem;
    transition: background 0.15s, opacity 0.15s;
}
.btn-approve svg, .btn-reject svg { width: 14px; height: 14px; }
.btn-approve { background: #d1fae5; color: #065f46; }
.btn-approve:hover { background: #a7f3d0; }
.btn-reject { background: #fee2e2; color: #991b1b; }
.btn-reject:hover { background: #fca5a5; }

.empty-state { text-align: center; padding: 3.5rem 1rem; color: #aaa; background: #fff; border: 1px solid var(--wallet-border); border-radius: 14px; }
.empty-icon {
    width: 52px; height: 52px; border-radius: 50%; background: rgba(16,185,129,0.1); color: var(--wallet-green);
    display: flex; align-items: center; justify-content: center; margin: 0 auto 0.9rem;
}
.empty-icon svg { width: 24px; height: 24px; }
.empty-state p { font-size: 0.95rem; font-weight: 600; color: #555; margin: 0; }
.empty-sub { font-size: 0.8rem; color: var(--wallet-muted); }

/* MODALS */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(20,15,10,0.45); backdrop-filter: blur(3px);
    z-index: 1000; align-items: center; justify-content: center;
}
.modal-overlay.active { display: flex; }
.modal-box {
    background: #fff; border-radius: 18px; padding: 2rem 2rem 1.75rem;
    width: 100%; max-width: 420px; margin: 1rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    animation: modalIn 0.2s ease;
}
@keyframes modalIn {
    from { transform: scale(0.94); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
.modal-icon {
    width: 52px; height: 52px; border-radius: 50%; margin: 0 auto 0.9rem;
    display: flex; align-items: center; justify-content: center;
}
.modal-icon svg { width: 24px; height: 24px; }
.modal-icon-success { background: rgba(16,185,129,0.12); color: var(--wallet-green); }
.modal-icon-danger  { background: rgba(239,68,68,0.12); color: var(--wallet-red); }
.modal-title { font-size: 1.1rem; font-weight: 800; text-align: center; margin: 0 0 0.4rem; color: var(--wallet-ink); }
.modal-desc { font-size: 0.875rem; color: #666; text-align: center; margin: 0 0 1.25rem; line-height: 1.5; }
.modal-field { margin-bottom: 1.1rem; }
.modal-input {
    width: 100%; padding: 0.65rem 0.9rem; box-sizing: border-box;
    border: 1.5px solid #d1d5db; border-radius: 10px;
    font-size: 0.875rem; color: var(--wallet-ink); background: var(--wallet-bg);
    transition: border-color 0.2s;
}
.modal-input:focus { outline: none; border-color: var(--wallet-accent); box-shadow: 0 0 0 3px rgba(200,137,74,0.12); }
.modal-actions { display: flex; gap: 0.75rem; justify-content: flex-end; }
.modal-btn-cancel {
    padding: 0.55rem 1.1rem; background: #f3f4f6; color: #374151;
    border: none; border-radius: 10px; font-size: 0.85rem;
    font-weight: 600; cursor: pointer; transition: background 0.15s;
}
.modal-btn-cancel:hover { background: #e5e7eb; }
.modal-btn-confirm {
    padding: 0.55rem 1.25rem; border: none; border-radius: 10px;
    font-size: 0.85rem; font-weight: 700; cursor: pointer;
    display: inline-flex; align-items: center; gap: 0.4rem;
    transition: opacity 0.15s;
}
.modal-btn-confirm svg { width: 15px; height: 15px; }
.modal-btn-green { background: #059669; color: #fff; }
.modal-btn-green:hover { background: #047857; }
.modal-btn-red { background: var(--wallet-red); color: #fff; }
.modal-btn-red:hover { background: #dc2626; }
.receipt-drop {
    position: relative; border: 2px dashed #d1d5db; border-radius: 10px;
    padding: 1.25rem; text-align: center; background: var(--wallet-bg);
    min-height: 90px; display: flex; align-items: center; justify-content: center;
    transition: border-color 0.2s; cursor: pointer;
}
.receipt-drop:hover { border-color: var(--wallet-accent); background: rgba(200,137,74,0.04); }
.receipt-drop-icon { color: #a7a29b; }
.receipt-drop-icon svg { width: 22px; height: 22px; margin-bottom: 0.3rem; }
</style>

{{-- APPROVE MODAL --}}
<div id="approveModal" class="modal-overlay" onclick="closeApproveModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h3 class="modal-title">Approve Cash-In</h3>
        <p class="modal-desc" id="approveModalDesc">Are you sure you want to approve this cash-in?</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeApproveModal()">Cancel</button>
            <form id="approveModalForm" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="modal-btn-confirm modal-btn-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    Approve
                </button>
            </form>
        </div>
    </div>
</div>

{{-- REJECT MODAL --}}
<div id="rejectModal" class="modal-overlay" onclick="closeRejectModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
        </div>
        <h3 class="modal-title">Reject Cash-In</h3>
        <p class="modal-desc" id="rejectModalDesc">Please provide a reason for rejection.</p>
        <form id="rejectModalForm" method="POST">
            @csrf
            <div class="modal-field">
                <input type="text" name="reason" id="rejectReason" class="modal-input" placeholder="e.g. Invalid reference number, blurry proof..." required>
            </div>
            <div class="modal-actions">
                <button type="button" class="modal-btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="modal-btn-confirm modal-btn-red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
                    Confirm Reject
                </button>
            </div>
        </form>
    </div>
</div>

{{-- WITHDRAWAL APPROVE MODAL --}}
<div id="wdApproveModal" class="modal-overlay" onclick="closeWdApproveModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h3 class="modal-title">Approve Withdrawal</h3>
        <p class="modal-desc" id="wdApproveModalDesc">Are you sure you want to approve this withdrawal?</p>
        <form id="wdApproveModalForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-field">
                <label style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#888;display:block;margin-bottom:0.4rem;">
                    Upload GCash/Maya Receipt *
                </label>
                <div class="receipt-drop" id="receiptDrop">
                    <input type="file" name="receipt" id="receiptFile" accept="image/jpg,image/jpeg,image/png,application/pdf"
                           required onchange="previewReceipt(this)" style="position:absolute;inset:0;opacity:0;width:100%;height:100%;cursor:pointer;">
                    <div id="receiptDropContent">
                        <div class="receipt-drop-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05 12.25 20.24a5 5 0 0 1-7.07-7.07l9.19-9.19a3.5 3.5 0 0 1 4.95 4.95L10.13 17.1a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                        </div>
                        <div style="font-size:0.78rem;font-weight:600;color:#374151;">Click to upload receipt</div>
                        <div style="font-size:0.68rem;color:#aaa;margin-top:0.15rem;">JPG, PNG, PDF — max 5MB</div>
                    </div>
                    <div id="receiptPreviewName" style="display:none;font-size:0.82rem;font-weight:600;color:#059669;text-align:center;padding:0.5rem;"></div>
                </div>
            </div>
            <div class="modal-field">
                <input type="text" name="admin_note" class="modal-input" placeholder="Optional note to baker (e.g. Sent via GCash)">
            </div>
            <div class="modal-actions">
                <button type="button" class="modal-btn-cancel" onclick="closeWdApproveModal()">Cancel</button>
                <button type="submit" class="modal-btn-confirm modal-btn-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    Confirm &amp; Approve
                </button>
            </div>
        </form>
    </div>
</div>

{{-- WITHDRAWAL REJECT MODAL --}}
<div id="wdRejectModal" class="modal-overlay" onclick="closeWdRejectModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-danger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
        </div>
        <h3 class="modal-title">Reject Withdrawal</h3>
        <p class="modal-desc" id="wdRejectModalDesc">This withdrawal will be rejected.</p>
        <div class="modal-actions">
            <button type="button" class="modal-btn-cancel" onclick="closeWdRejectModal()">Cancel</button>
            <form id="wdRejectModalForm" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="admin_note" value="Rejected by admin.">
                <button type="submit" class="modal-btn-confirm modal-btn-red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
                    Confirm Reject
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).style.display = 'block';
    btn.classList.add('active');
}

// Cash-in Approve
function openApproveModal(url, amount, name) {
    document.getElementById('approveModalDesc').textContent = 'Credit ₱' + amount + ' to ' + name + '\'s wallet?';
    document.getElementById('approveModalForm').action = url;
    document.getElementById('approveModal').classList.add('active');
}
function closeApproveModal() {
    document.getElementById('approveModal').classList.remove('active');
}

// Cash-in Reject
function openRejectModal(url, amount, name) {
    document.getElementById('rejectModalDesc').textContent = 'Rejecting ₱' + amount + ' cash-in for ' + name + '.';
    document.getElementById('rejectModalForm').action = url;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectModal').classList.add('active');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
}

function openWdApproveModal(url, amount, name) {
    document.getElementById('wdApproveModalDesc').textContent = 'Approve ₱' + amount + ' withdrawal for ' + name + '?';
    document.getElementById('wdApproveModalForm').action = url;
    document.getElementById('receiptFile').value = '';
    document.getElementById('receiptDropContent').style.display = 'block';
    document.getElementById('receiptPreviewName').style.display = 'none';
    document.getElementById('wdApproveModal').classList.add('active');
}
function closeWdApproveModal() {
    document.getElementById('wdApproveModal').classList.remove('active');
}
function previewReceipt(input) {
    if (input.files && input.files[0]) {
        document.getElementById('receiptDropContent').style.display = 'none';
        const preview = document.getElementById('receiptPreviewName');
        preview.textContent = '✓ ' + input.files[0].name;
        preview.style.display = 'block';
    }
}

// Withdrawal Reject
function openWdRejectModal(url, amount, name) {
    document.getElementById('wdRejectModalDesc').textContent = 'Reject ₱' + amount + ' withdrawal for ' + name + '?';
    document.getElementById('wdRejectModalForm').action = url;
    document.getElementById('wdRejectModal').classList.add('active');
}
function closeWdRejectModal() {
    document.getElementById('wdRejectModal').classList.remove('active');
}

// Close on Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeApproveModal(); closeRejectModal();
        closeWdApproveModal(); closeWdRejectModal();
    }
});
</script>
@endsection