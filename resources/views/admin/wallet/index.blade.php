@extends('layouts.admin')

@section('title', 'Wallet Management')

@section('content')

{{-- SVG sprite (icons referenced with <use>) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <defs>
        <symbol id="i-wallet" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="14" rx="2.5"/><path d="M2 10h20"/><path d="M16 14.5h2.5"/></symbol>
        <symbol id="i-up" viewBox="0 0 24 24"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></symbol>
        <symbol id="i-down" viewBox="0 0 24 24"><path d="M12 5v14"/><path d="M19 12l-7 7-7-7"/></symbol>
        <symbol id="i-lock" viewBox="0 0 24 24"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></symbol>
        <symbol id="i-box" viewBox="0 0 24 24"><path d="M21 8l-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></symbol>
        <symbol id="i-check" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></symbol>
        <symbol id="i-x" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></symbol>
        <symbol id="i-image" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></symbol>
        <symbol id="i-clip" viewBox="0 0 24 24"><path d="M21.44 11.05 12.25 20.24a5 5 0 0 1-7.07-7.07l9.19-9.19a3.5 3.5 0 0 1 4.95 4.95L10.13 17.1a2 2 0 0 1-2.83-2.83l8.49-8.48"/></symbol>
    </defs>
</svg>

<div class="wm-page">

    {{-- HEADER --}}
    <header class="wm-hero">
        <div class="wm-hero-main">
            <span class="wm-hero-mark"><svg class="ic"><use href="#i-wallet"/></svg></span>
            <div>
                <div class="wm-eyebrow">BakeSphere &middot; Wallet Operations</div>
                <h1 class="wm-title">Wallet Management</h1>
                <p class="wm-subtitle">Cash-in approvals, withdrawals, and escrow overview</p>
            </div>
        </div>
        <div class="wm-live">
            <span class="wm-live-label"><span class="wm-live-dot"></span>Live ledger</span>
            <span class="wm-live-time">Updated {{ now()->format('M d, H:i') }}</span>
        </div>
    </header>

    {{-- STATS: FINANCIAL LEDGER STRIP --}}
    <section class="wm-ledger" aria-label="Financial summary">
        <div class="wm-fig wm-fig-held">
            <div class="wm-fig-lbl"><svg class="ic"><use href="#i-lock"/></svg>In Escrow</div>
            <div class="wm-fig-val">₱{{ number_format($totalHeld, 2) }}</div>
        </div>
        <div class="wm-fig wm-fig-in">
            <div class="wm-fig-lbl"><svg class="ic"><use href="#i-up"/></svg>Pending Cash-Ins</div>
            <div class="wm-fig-val">₱{{ number_format($totalPendingIn, 2) }}</div>
        </div>
        <div class="wm-fig wm-fig-out">
            <div class="wm-fig-lbl"><svg class="ic"><use href="#i-down"/></svg>Pending Withdrawals</div>
            <div class="wm-fig-val">₱{{ number_format($totalPendingOut, 2) }}</div>
        </div>
        <div class="wm-fig wm-fig-count">
            <div class="wm-fig-lbl"><svg class="ic"><use href="#i-box"/></svg>Active Escrows</div>
            <div class="wm-fig-val">{{ $heldEscrows->count() }}</div>
        </div>
    </section>

    {{-- TABS --}}
    <nav class="wm-tabs" aria-label="Wallet sections">
        <button class="tab-btn active" onclick="switchTab('cashin', this)">
            <svg class="ic"><use href="#i-up"/></svg>
            Cash-In Requests
            @if($pendingCashIns->count() > 0)
                <span class="tab-badge">{{ $pendingCashIns->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('withdrawals', this)">
            <svg class="ic"><use href="#i-down"/></svg>
            Withdrawals
            @if($pendingWithdrawals->count() > 0)
                <span class="tab-badge">{{ $pendingWithdrawals->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" onclick="switchTab('escrows', this)">
            <svg class="ic"><use href="#i-lock"/></svg>
            Active Escrows
        </button>
    </nav>

    {{-- ── TAB: CASH-INS ── --}}
    <div class="tab-panel" id="tab-cashin">
        <div class="wm-section-head">
            <span class="wm-section-no">01</span>
            <div>
                <h2 class="wm-section-title">Pending cash-in ledger</h2>
                <p class="wm-section-note">Verify the GCash reference and proof, then approve or decline.</p>
            </div>
        </div>
        @if($pendingCashIns->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><svg class="ic"><use href="#i-check"/></svg></div>
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
                                        <svg class="ic"><use href="#i-image"/></svg>
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
                                        <svg class="ic"><use href="#i-check"/></svg>
                                        Approve
                                    </button>
                                    <button type="button" class="btn-reject"
                                        onclick="openRejectModal('{{ route('admin.wallet.cashin.reject', $req) }}', '{{ number_format($req->amount,2) }}', '{{ $req->user->first_name }}')">
                                        <svg class="ic"><use href="#i-x"/></svg>
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
        <div class="wm-section-head">
            <span class="wm-section-no">02</span>
            <div>
                <h2 class="wm-section-title">Pending withdrawal ledger</h2>
                <p class="wm-section-note">Baker payouts. Send the funds, then upload the receipt to approve.</p>
            </div>
        </div>
        @if($pendingWithdrawals->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><svg class="ic"><use href="#i-check"/></svg></div>
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
                            <td><span class="badge badge-method">{{ strtoupper($wd->payment_method) }}</span></td>
                            <td>
                                <div class="account-cell">
                                    <span class="account-lbl">Account name</span>
                                    <span class="account-val">{{ $wd->account_name }}</span>
                                    <span class="account-lbl">Account number</span>
                                    <span class="account-val account-num">{{ $wd->account_number }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $wd->requested_at?->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-approve"
                                        onclick="openWdApproveModal('{{ route('admin.wallet.withdrawal.approve', $wd) }}', '{{ number_format($wd->amount,2) }}', '{{ $wd->user->first_name }}')">
                                        <svg class="ic"><use href="#i-check"/></svg>
                                        Approve &amp; Upload Receipt
                                    </button>
                                    <button type="button" class="btn-reject"
                                        onclick="openWdRejectModal('{{ route('admin.wallet.withdrawal.reject', $wd) }}', '{{ number_format($wd->amount,2) }}', '{{ $wd->user->first_name }}')">
                                        <svg class="ic"><use href="#i-x"/></svg>
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
        <div class="wm-section-head">
            <span class="wm-section-no">03</span>
            <div>
                <h2 class="wm-section-title">Active escrow ledger</h2>
                <p class="wm-section-note">Each hold splits into the baker payout and the platform fee.</p>
            </div>
        </div>
        @if($heldEscrows->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><svg class="ic"><use href="#i-lock"/></svg></div>
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
                            <th class="th-num">Amount</th>
                            <th class="th-num">Baker Gets</th>
                            <th class="th-num">Fee</th>
                            <th>Held Since</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heldEscrows as $hold)
                        <tr>
                            <td><strong class="order-no">#{{ $hold->order_id }}</strong></td>
                            <td>{{ $hold->order->cakeRequest->user->full_name ?? '—' }}</td>
                            <td>{{ $hold->order->baker->full_name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $hold->payment_type === 'downpayment' ? 'badge-down' : 'badge-full' }}">
                                    {{ ucfirst($hold->payment_type) }}
                                </span>
                            </td>
                            <td class="td-num"><strong class="escrow-total">₱{{ number_format($hold->amount, 2) }}</strong></td>
                            <td class="td-num text-green">₱{{ number_format($hold->baker_payout_amount, 2) }}</td>
                            <td class="td-num text-muted">₱{{ number_format($hold->platform_fee_amount, 2) }}</td>
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
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ───────── TOKENS ───────── */
:root {
    --bs-espresso: #24150F;
    --bs-chocolate: #3A241A;
    --bs-ivory: #F7F2E9;
    --bs-cream: #EFE6D7;
    --bs-caramel: #A96F42;
    --bs-gold: #B89452;
    --bs-burgundy: #54252C;
    --bs-taupe: #9A897A;
    --bs-beige: #D8C8B7;
    --bs-blush: #E8D3CA;
    --bs-white: #FFFFFF;
    --bs-sage: #5E7560;
    --bs-sage-soft: #DFE6D8;
    --bs-gold-soft: #F1E6CC;
    --bs-burgundy-soft: #F0DCDA;
    --bs-font: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
    --bs-ease: cubic-bezier(.2,.7,.2,1);
}

/* ───────── BASE ───────── */
.wm-page, .modal-overlay, .modal-overlay * , .wm-page * {
    font-family: var(--bs-font);
    box-sizing: border-box;
}
.wm-page { padding: 1.5rem; max-width: 100%; color: var(--bs-espresso); font-variant-numeric: tabular-nums; }
.ic { width: 16px; height: 16px; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.wm-page button, .modal-overlay button, .modal-overlay input { font-family: inherit; }
.wm-page :focus-visible, .modal-overlay :focus-visible { outline: 2px solid var(--bs-gold); outline-offset: 2px; }

/* ───────── HERO ───────── */
.wm-hero {
    position: relative; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    padding: 2rem 2rem 4.25rem; border-radius: 4px 4px 0 0; color: var(--bs-ivory);
    background:
        repeating-linear-gradient(135deg, rgba(184,148,82,.05) 0 1px, transparent 1px 14px),
        linear-gradient(120deg, var(--bs-espresso) 0%, var(--bs-chocolate) 100%);
    border-bottom: 1px solid var(--bs-gold);
    box-shadow: inset 0 0 0 5px var(--bs-espresso), inset 0 0 0 6px rgba(184,148,82,.45);
}
.wm-hero-main { display: flex; align-items: center; gap: 1.1rem; }
.wm-hero-mark {
    width: 52px; height: 52px; display: grid; place-items: center; flex-shrink: 0;
    border: 1px solid var(--bs-gold); color: var(--bs-gold); border-radius: 2px;
    background: rgba(184,148,82,.08);
}
.wm-hero-mark .ic { width: 24px; height: 24px; }
.wm-eyebrow { font-size: .7rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--bs-gold); margin-bottom: .35rem; }
.wm-title { margin: 0; font-size: 2rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.1; color: var(--bs-ivory); }
.wm-subtitle { margin: .4rem 0 0; font-size: .9rem; color: var(--bs-beige); max-width: 60ch; }
.wm-live { text-align: right; display: flex; flex-direction: column; gap: .2rem; padding-left: 1.25rem; border-left: 1px solid rgba(184,148,82,.5); }
.wm-live-label { display: inline-flex; align-items: center; justify-content: flex-end; gap: .45rem; font-size: .68rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: var(--bs-gold); }
.wm-live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--bs-gold); box-shadow: 0 0 0 3px rgba(184,148,82,.22); }
.wm-live-time { font-size: .82rem; font-weight: 500; color: var(--bs-beige); letter-spacing: .04em; }

/* ───────── LEDGER STRIP ───────── */
.wm-ledger {
    position: relative; z-index: 1; display: grid; grid-template-columns: repeat(4, 1fr);
    margin: -2.5rem 1.25rem 2rem; background: var(--bs-white);
    border: 1px solid var(--bs-beige); border-top: 2px solid var(--bs-gold); border-radius: 3px;
    box-shadow: 0 22px 40px -28px rgba(36,21,15,.55);
}
.wm-fig { position: relative; padding: 1.35rem 1.5rem 1.4rem; min-width: 0; }
.wm-fig + .wm-fig { border-left: 1px solid var(--bs-cream); }
.wm-fig::before { content: ''; position: absolute; left: 1.5rem; top: 0; width: 28px; height: 3px; background: var(--fig-accent, var(--bs-gold)); }
.wm-fig-held  { --fig-accent: var(--bs-gold); }
.wm-fig-in    { --fig-accent: var(--bs-sage); }
.wm-fig-out   { --fig-accent: var(--bs-burgundy); }
.wm-fig-count { --fig-accent: var(--bs-caramel); }
.wm-fig-lbl { display: flex; align-items: center; gap: .45rem; font-size: .68rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--bs-taupe); margin-top: .35rem; }
.wm-fig-lbl .ic { color: var(--fig-accent); width: 14px; height: 14px; }
.wm-fig-val { margin-top: .55rem; font-size: 1.6rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.1; color: var(--bs-espresso); overflow-wrap: anywhere; }
.wm-fig-held .wm-fig-val { font-size: 1.85rem; }

/* ───────── TABS ───────── */
.wm-tabs { display: flex; gap: .25rem; margin: 0 0 1.5rem; border-bottom: 1px solid var(--bs-beige); overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; }
.tab-btn {
    display: inline-flex; align-items: center; gap: .55rem; white-space: nowrap;
    padding: .85rem 1.25rem; margin-bottom: -1px; cursor: pointer;
    font-size: .74rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
    color: var(--bs-taupe); background: transparent; border: none; border-bottom: 2px solid transparent; border-radius: 0;
    transition: color .2s var(--bs-ease), background .2s var(--bs-ease), border-color .2s var(--bs-ease);
}
.tab-btn:hover { color: var(--bs-caramel); background: rgba(184,148,82,.07); }
.tab-btn.active { color: var(--bs-espresso); border-bottom-color: var(--bs-gold); background: linear-gradient(180deg, transparent, rgba(184,148,82,.12)); }
.tab-btn.active .ic { color: var(--bs-gold); }
.tab-badge {
    min-width: 20px; padding: .12rem .5rem; text-align: center; border-radius: 2px;
    font-size: .68rem; font-weight: 800; letter-spacing: .02em; line-height: 1.35;
    color: var(--bs-espresso); background: var(--bs-gold-soft); border: 1px solid var(--bs-gold);
}
.tab-btn.active .tab-badge { background: var(--bs-gold); color: var(--bs-espresso); }

/* ───────── SECTION HEAD ───────── */
.tab-panel { animation: wmFade .28s var(--bs-ease); }
@keyframes wmFade { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
.wm-section-head { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
.wm-section-no { font-size: 1.6rem; font-weight: 800; letter-spacing: -.02em; color: var(--bs-gold); padding-right: 1rem; border-right: 1px solid var(--bs-beige); line-height: 1; }
.wm-section-title { margin: 0; font-size: 1.05rem; font-weight: 800; letter-spacing: .01em; color: var(--bs-espresso); }
.wm-section-note { margin: .2rem 0 0; font-size: .82rem; color: var(--bs-taupe); }

/* ───────── TABLES ───────── */
.table-wrap {
    overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; background: var(--bs-white);
    border: 1px solid var(--bs-beige); border-top: 2px solid var(--bs-espresso); border-radius: 3px;
    box-shadow: 0 18px 34px -30px rgba(36,21,15,.5);
}
.data-table { width: 100%; min-width: 880px; border-collapse: collapse; font-size: .86rem; }
.data-table th {
    text-align: left; padding: .9rem 1.1rem; white-space: nowrap;
    font-size: .66rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase;
    color: var(--bs-taupe); background: var(--bs-ivory); border-bottom: 1px solid var(--bs-beige);
}
.th-actions { text-align: right !important; }
.th-num, .td-num { text-align: right !important; }
.data-table td { padding: 1rem 1.1rem; vertical-align: middle; border-bottom: 1px solid var(--bs-cream); color: var(--bs-chocolate); }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr { transition: background .2s var(--bs-ease); }
.data-table tbody tr:hover td { background: #FBF8F2; }

.user-cell { display: flex; align-items: center; gap: .75rem; }
.user-avatar {
    width: 36px; height: 36px; flex-shrink: 0; display: grid; place-items: center; border-radius: 2px;
    font-size: .82rem; font-weight: 800; color: var(--bs-gold);
    background: var(--bs-espresso); box-shadow: inset 0 0 0 1px rgba(184,148,82,.6);
}
.user-name { font-weight: 700; color: var(--bs-espresso); }
.user-email { font-size: .76rem; color: var(--bs-taupe); margin-top: .1rem; }

.amount-highlight { font-size: 1.05rem; font-weight: 800; letter-spacing: -.01em; color: var(--bs-espresso); white-space: nowrap; }
.text-muted { color: var(--bs-taupe); font-size: .8rem; font-weight: 500; }
.text-green { color: var(--bs-sage); font-weight: 700; white-space: nowrap; }
.td-num { white-space: nowrap; }
.order-no { font-weight: 800; letter-spacing: .04em; color: var(--bs-caramel); }
.escrow-total { font-size: 1rem; font-weight: 800; color: var(--bs-espresso); }

.ref-code {
    display: inline-block; padding: .25rem .6rem; border-radius: 2px;
    font-size: .78rem; font-weight: 700; letter-spacing: .1em; color: var(--bs-chocolate);
    background: var(--bs-cream); border: 1px solid var(--bs-beige);
}

.proof-link {
    display: inline-flex; align-items: center; gap: .4rem; padding: .3rem 0; text-decoration: none;
    font-size: .8rem; font-weight: 700; letter-spacing: .03em; color: var(--bs-caramel);
    border-bottom: 1px solid var(--bs-gold); transition: color .2s, border-color .2s;
}
.proof-link:hover { color: var(--bs-espresso); border-color: var(--bs-espresso); }

.badge { display: inline-block; padding: .25rem .65rem; border-radius: 2px; font-size: .66rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; border: 1px solid transparent; }
.badge-method { color: var(--bs-chocolate); background: var(--bs-cream); border-color: var(--bs-beige); }
.badge-down   { color: #7A5A1E; background: var(--bs-gold-soft); border-color: var(--bs-gold); }
.badge-full   { color: var(--bs-sage); background: var(--bs-sage-soft); border-color: #B9C7B3; }

.account-cell { display: flex; flex-direction: column; }
.account-lbl { font-size: .6rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--bs-taupe); margin-top: .3rem; }
.account-lbl:first-child { margin-top: 0; }
.account-val { font-size: .86rem; font-weight: 600; color: var(--bs-espresso); }
.account-num { letter-spacing: .08em; }

.action-btns { display: flex; gap: .5rem; flex-wrap: wrap; justify-content: flex-end; }
.btn-approve, .btn-reject {
    display: inline-flex; align-items: center; gap: .4rem; padding: .45rem .85rem; cursor: pointer;
    font-size: .74rem; font-weight: 700; letter-spacing: .06em; white-space: nowrap; border-radius: 2px;
    transition: background .2s var(--bs-ease), color .2s var(--bs-ease), border-color .2s var(--bs-ease);
}
.btn-approve .ic, .btn-reject .ic { width: 13px; height: 13px; stroke-width: 2.2; }
.btn-approve { color: var(--bs-sage); background: var(--bs-sage-soft); border: 1px solid #B9C7B3; }
.btn-approve:hover { color: var(--bs-white); background: var(--bs-sage); border-color: var(--bs-sage); }
.btn-reject { color: var(--bs-burgundy); background: transparent; border: 1px solid rgba(84,37,44,.4); }
.btn-reject:hover { color: var(--bs-white); background: var(--bs-burgundy); border-color: var(--bs-burgundy); }

/* ───────── EMPTY STATES ───────── */
.empty-state { text-align: center; padding: 3.5rem 1rem; background: var(--bs-ivory); border: 1px solid var(--bs-beige); border-top: 2px solid var(--bs-gold); border-radius: 3px; }
.empty-icon { width: 52px; height: 52px; margin: 0 auto 1rem; display: grid; place-items: center; color: var(--bs-gold); border: 1px solid var(--bs-gold); border-radius: 2px; background: rgba(184,148,82,.08); }
.empty-icon .ic { width: 22px; height: 22px; }
.empty-state p { margin: 0; font-size: .95rem; font-weight: 700; color: var(--bs-espresso); }
.empty-sub { display: block; margin-top: .3rem; font-size: .82rem; color: var(--bs-taupe); }

/* ───────── MODALS ───────── */
.modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 1000; align-items: center; justify-content: center; padding: 1rem;
    background: rgba(36,21,15,.62); backdrop-filter: blur(3px);
}
.modal-overlay.active { display: flex; animation: wmOverlay .2s ease; }
@keyframes wmOverlay { from { opacity: 0; } to { opacity: 1; } }
.modal-box {
    width: 100%; max-width: 440px; max-height: calc(100vh - 2rem); overflow-y: auto;
    padding: 2rem 2rem 1.6rem; background: var(--bs-ivory); border-radius: 3px;
    border-top: 3px solid var(--bs-gold); box-shadow: 0 30px 70px rgba(36,21,15,.45);
    animation: modalIn .24s var(--bs-ease);
}
@keyframes modalIn { from { transform: translateY(10px) scale(.97); opacity: 0; } to { transform: none; opacity: 1; } }
.modal-icon { width: 48px; height: 48px; margin: 0 auto 1rem; display: grid; place-items: center; border-radius: 2px; }
.modal-icon .ic { width: 22px; height: 22px; stroke-width: 2; }
.modal-icon-success { color: var(--bs-sage); background: var(--bs-sage-soft); border: 1px solid #B9C7B3; }
.modal-icon-danger  { color: var(--bs-burgundy); background: var(--bs-burgundy-soft); border: 1px solid rgba(84,37,44,.35); }
.modal-title { margin: 0 0 .5rem; text-align: center; font-size: .78rem; font-weight: 800; letter-spacing: .2em; text-transform: uppercase; color: var(--bs-caramel); }
.modal-desc {
    margin: 0 0 1.4rem; padding: 1rem .5rem; text-align: center; line-height: 1.45;
    font-size: 1.1rem; font-weight: 700; color: var(--bs-espresso);
    border-top: 1px solid var(--bs-beige); border-bottom: 1px solid var(--bs-beige);
}
.modal-field { margin-bottom: 1.1rem; }
.modal-label { display: block; margin-bottom: .45rem; font-size: .66rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--bs-taupe); }
.modal-input {
    width: 100%; padding: .7rem .9rem; font-size: .88rem; color: var(--bs-espresso);
    background: var(--bs-white); border: 1px solid var(--bs-beige); border-radius: 2px;
    transition: border-color .2s, box-shadow .2s;
}
.modal-input::placeholder { color: var(--bs-taupe); }
.modal-input:focus { outline: none; border-color: var(--bs-gold); box-shadow: 0 0 0 3px rgba(184,148,82,.2); }
.modal-actions { display: flex; gap: .65rem; justify-content: flex-end; flex-wrap: wrap; }
.modal-btn-cancel {
    padding: .65rem 1.15rem; cursor: pointer; font-size: .74rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: var(--bs-chocolate); background: transparent; border: 1px solid var(--bs-beige); border-radius: 2px; transition: background .2s;
}
.modal-btn-cancel:hover { background: var(--bs-cream); }
.modal-btn-confirm {
    display: inline-flex; align-items: center; gap: .45rem; padding: .65rem 1.3rem; cursor: pointer;
    font-size: .74rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
    border: 1px solid transparent; border-radius: 2px; transition: background .2s, color .2s;
}
.modal-btn-confirm .ic { width: 14px; height: 14px; stroke-width: 2.2; }
.modal-btn-green { color: var(--bs-white); background: var(--bs-sage); }
.modal-btn-green:hover { background: #4C614E; }
.modal-btn-red { color: var(--bs-white); background: var(--bs-burgundy); }
.modal-btn-red:hover { background: #3F1B21; }

.receipt-drop {
    position: relative; min-height: 96px; display: flex; align-items: center; justify-content: center; padding: 1.25rem;
    text-align: center; cursor: pointer; background: var(--bs-white);
    border: 1px dashed var(--bs-gold); border-radius: 2px; transition: background .2s, border-color .2s;
}
.receipt-drop:hover { background: var(--bs-gold-soft); border-color: var(--bs-caramel); }
.receipt-drop-icon { color: var(--bs-gold); }
.receipt-drop-icon .ic { width: 24px; height: 24px; margin-bottom: .35rem; }
.receipt-drop-title { font-size: .82rem; font-weight: 700; color: var(--bs-espresso); }
.receipt-drop-hint { margin-top: .2rem; font-size: .66rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--bs-taupe); }
.receipt-preview-name { display: none; padding: .5rem; text-align: center; font-size: .84rem; font-weight: 700; color: var(--bs-sage); word-break: break-all; }

/* ───────── RESPONSIVE ───────── */
@media (max-width: 992px) {
    .wm-ledger { grid-template-columns: repeat(2, 1fr); }
    .wm-fig:nth-child(3) { border-left: none; }
    .wm-fig:nth-child(n+3) { border-top: 1px solid var(--bs-cream); }
}
@media (max-width: 600px) {
    .wm-page { padding: .75rem; }
    .wm-hero { padding: 1.5rem 1.25rem 3.75rem; }
    .wm-title { font-size: 1.5rem; }
    .wm-live { text-align: left; padding-left: 0; border-left: none; }
    .wm-live-label { justify-content: flex-start; }
    .wm-ledger { margin: -2.25rem .5rem 1.5rem; }
    .wm-fig { padding: 1.1rem 1rem; }
    .wm-fig::before { left: 1rem; }
    .wm-fig-val, .wm-fig-held .wm-fig-val { font-size: 1.15rem; }
    .tab-btn { padding: .8rem .9rem; }
    .modal-box { padding: 1.5rem 1.25rem 1.25rem; }
    .modal-actions > * , .modal-actions form { flex: 1 1 auto; }
    .modal-actions .modal-btn-confirm, .modal-actions .modal-btn-cancel { width: 100%; justify-content: center; }
}

@media (prefers-reduced-motion: reduce) {
    .tab-panel, .modal-overlay.active, .modal-box { animation: none; }
    .tab-btn, .data-table tbody tr, .btn-approve, .btn-reject, .modal-btn-confirm, .modal-btn-cancel, .modal-input, .receipt-drop, .proof-link { transition: none; }
}
</style>

{{-- APPROVE MODAL --}}
<div id="approveModal" class="modal-overlay" onclick="closeApproveModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-success"><svg class="ic"><use href="#i-check"/></svg></div>
        <h3 class="modal-title">Approve Cash-In</h3>
        <p class="modal-desc" id="approveModalDesc">Are you sure you want to approve this cash-in?</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeApproveModal()">Cancel</button>
            <form id="approveModalForm" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="modal-btn-confirm modal-btn-green">
                    <svg class="ic"><use href="#i-check"/></svg>
                    Approve Cash-In
                </button>
            </form>
        </div>
    </div>
</div>

{{-- REJECT MODAL --}}
<div id="rejectModal" class="modal-overlay" onclick="closeRejectModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-danger"><svg class="ic"><use href="#i-x"/></svg></div>
        <h3 class="modal-title">Reject Cash-In</h3>
        <p class="modal-desc" id="rejectModalDesc">Please provide a reason for rejection.</p>
        <form id="rejectModalForm" method="POST">
            @csrf
            <div class="modal-field">
                <label class="modal-label" for="rejectReason">Reason for rejection</label>
                <input type="text" name="reason" id="rejectReason" class="modal-input" placeholder="e.g. Invalid reference number, blurry proof..." required>
            </div>
            <div class="modal-actions">
                <button type="button" class="modal-btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="modal-btn-confirm modal-btn-red">
                    <svg class="ic"><use href="#i-x"/></svg>
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

{{-- WITHDRAWAL APPROVE MODAL --}}
<div id="wdApproveModal" class="modal-overlay" onclick="closeWdApproveModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-success"><svg class="ic"><use href="#i-check"/></svg></div>
        <h3 class="modal-title">Approve Withdrawal</h3>
        <p class="modal-desc" id="wdApproveModalDesc">Are you sure you want to approve this withdrawal?</p>
        <form id="wdApproveModalForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-field">
                <label class="modal-label">Payment receipt &middot; Upload the GCash/Maya receipt *</label>
                <div class="receipt-drop" id="receiptDrop">
                    <input type="file" name="receipt" id="receiptFile" accept="image/jpg,image/jpeg,image/png,application/pdf"
                           required onchange="previewReceipt(this)" style="position:absolute;inset:0;opacity:0;width:100%;height:100%;cursor:pointer;">
                    <div id="receiptDropContent">
                        <div class="receipt-drop-icon"><svg class="ic"><use href="#i-clip"/></svg></div>
                        <div class="receipt-drop-title">Click to upload receipt</div>
                        <div class="receipt-drop-hint">JPG / PNG / PDF &middot; Max 5MB</div>
                    </div>
                    <div id="receiptPreviewName" class="receipt-preview-name"></div>
                </div>
            </div>
            <div class="modal-field">
                <label class="modal-label" for="wdAdminNote">Admin note</label>
                <input type="text" name="admin_note" id="wdAdminNote" class="modal-input" placeholder="Optional note to baker (e.g. Sent via GCash)">
            </div>
            <div class="modal-actions">
                <button type="button" class="modal-btn-cancel" onclick="closeWdApproveModal()">Cancel</button>
                <button type="submit" class="modal-btn-confirm modal-btn-green">
                    <svg class="ic"><use href="#i-check"/></svg>
                    Confirm &amp; Approve
                </button>
            </div>
        </form>
    </div>
</div>

{{-- WITHDRAWAL REJECT MODAL --}}
<div id="wdRejectModal" class="modal-overlay" onclick="closeWdRejectModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-icon modal-icon-danger"><svg class="ic"><use href="#i-x"/></svg></div>
        <h3 class="modal-title">Reject Withdrawal</h3>
        <p class="modal-desc" id="wdRejectModalDesc">This withdrawal will be rejected.</p>
        <div class="modal-actions">
            <button type="button" class="modal-btn-cancel" onclick="closeWdRejectModal()">Cancel</button>
            <form id="wdRejectModalForm" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="admin_note" value="Rejected by admin.">
                <button type="submit" class="modal-btn-confirm modal-btn-red">
                    <svg class="ic"><use href="#i-x"/></svg>
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