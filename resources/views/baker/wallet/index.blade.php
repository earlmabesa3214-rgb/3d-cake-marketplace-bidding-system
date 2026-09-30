@extends('layouts.baker')
@section('title', 'My Wallet')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap');

/* My Wallet: same cake-atelier ledger language as My Bids and My Orders. Plus Jakarta Sans only. */
.wallet-page{
--esp:#24150F;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;--sage:#5E7F5A;--sage-d:#33502F;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:0 auto;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.wallet-page *{box-sizing:border-box;font-family:inherit}
.wallet-page svg{flex-shrink:0}
.wallet-page a:focus-visible,.wallet-page button:focus-visible,.wallet-page input:focus-visible,.wallet-page select:focus-visible{outline:2px solid var(--gold);outline-offset:2px}
@keyframes wl-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes wl-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes wl-modal{from{transform:translateY(10px) scale(.98);opacity:0}to{transform:none;opacity:1}}
@media(prefers-reduced-motion:reduce){.wallet-page *,.wallet-page *::before,.wallet-page *::after{animation:none!important;transition:none!important}}

/* header */
.wl-header{position:relative;margin:0 0 2rem;padding-bottom:1.75rem;animation:wl-fadeUp .6s var(--e) backwards}
.wl-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.wl-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:wl-line .9s var(--e) .3s backwards}
.wl-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.wl-sub{margin:1rem 0 0;max-width:56ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

.wl-label{font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe)}

/* balance ledger */
.wl-summary{display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:1.25rem;margin-bottom:1.5rem;animation:wl-fadeUp .6s var(--e) .1s backwards}
.wl-balance{background:var(--esp);color:var(--ivory);border-left:3px solid var(--gold);padding:1.9rem 2rem;display:flex;flex-direction:column;justify-content:center}
.wl-balance .wl-label{color:var(--gold-l)}
.wl-balance-amount{margin-top:.75rem;font-size:clamp(2.2rem,4.4vw,3.4rem);font-weight:900;letter-spacing:-.05em;line-height:1;color:var(--gold-l);font-variant-numeric:tabular-nums}
.wl-balance-sub{margin-top:.85rem;font-size:.82rem;line-height:1.6;color:rgba(247,242,233,.7)}
.wl-stat{background:var(--w);border:1px solid var(--beige);border-top:2px solid var(--esp);padding:1.5rem 1.6rem;display:flex;flex-direction:column;justify-content:center}
.wl-stat-value{margin-top:.75rem;font-size:clamp(1.5rem,2.6vw,2rem);font-weight:900;letter-spacing:-.04em;line-height:1;font-variant-numeric:tabular-nums}
.wl-stat-value.earned{color:var(--sage-d)}
.wl-stat-value.withdrawn{color:var(--burg)}

/* notes / alerts */
.wl-note{margin:0 0 1.5rem;padding:.95rem 1.2rem;display:flex;align-items:flex-start;gap:.75rem;font-size:.86rem;line-height:1.6;border:1px solid transparent;border-left-width:2px}
.wl-note svg{margin-top:3px}
.wl-note.warning{background:#F3EAD3;color:#5C4210;border-color:var(--gold-line);border-left-color:var(--gold)}
.wl-note.warning svg{color:var(--credit)}
.wl-note.info{background:var(--cream);color:var(--mocha);border-color:var(--beige);border-left-color:var(--taupe)}
.wl-note.error{background:#F6ECEA;color:#3E1A1F;border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}
.wl-note.error svg{color:var(--burg)}
.wl-note.in-form{margin:0}

/* grid + panels */
.wl-grid{display:grid;grid-template-columns:minmax(340px,420px) 1fr;gap:1.5rem;align-items:start}
.wl-panel{background:var(--w);border:1px solid var(--beige);border-top:2px solid var(--esp);animation:wl-fadeUp .6s var(--e) .2s backwards}
.wl-panel-head{display:flex;align-items:center;gap:.7rem;padding:1.1rem 1.5rem;border-bottom:1px solid var(--line)}
.wl-panel-head svg{color:var(--gold)}
.wl-panel-head h2{margin:0;font-size:1.1rem;font-weight:900;letter-spacing:-.03em;line-height:1}

/* form */
.wl-form{padding:1.5rem;display:flex;flex-direction:column;gap:1.1rem}
.wl-field{display:flex;flex-direction:column;gap:.45rem;min-width:0}
.wl-input{width:100%;min-width:0;padding:.8rem .95rem;background:var(--ivory);border:1px solid var(--beige);border-radius:0;font-size:.9rem;font-weight:500;color:var(--esp);transition:border-color .25s,background .25s}
.wl-input::placeholder{color:var(--taupe)}
.wl-input:hover{border-color:var(--gold)}
.wl-input:focus{outline:none;border-color:var(--gold);background:#fff}
select.wl-input{appearance:none;-webkit-appearance:none;padding-right:2.4rem;cursor:pointer;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237A5E4C' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .95rem center}
.wl-hint{font-size:.72rem;color:var(--taupe);font-variant-numeric:tabular-nums}
.wl-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem;min-width:0}
.wl-info{padding:.9rem 1rem;background:var(--cream);border-left:2px solid var(--gold);font-size:.78rem;line-height:1.65;color:var(--mocha)}
.wl-info strong{color:var(--esp)}
.wl-submit{display:flex;align-items:center;justify-content:center;gap:.6rem;width:100%;padding:1.05rem 1.5rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);border-radius:0;font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;transition:background .3s,color .3s,border-color .3s}
.wl-submit:hover{background:var(--gold);border-color:var(--gold);color:var(--esp)}
.wl-submit:disabled{opacity:.45;cursor:not-allowed}

/* history */
.wl-scroll{max-height:520px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:var(--gold-line) transparent}
.wl-row{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;padding:1.1rem 1.5rem;border-bottom:1px solid var(--line);transition:background .3s}
.wl-row:hover{background:rgba(239,230,215,.5)}
.wl-row:last-child{border-bottom:0}
.wl-amount{font-size:1.05rem;font-weight:900;letter-spacing:-.03em;color:var(--credit);font-variant-numeric:tabular-nums}
.wl-amount span{font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--mocha);margin-left:.4rem}
.wl-meta{margin-top:.3rem;font-size:.75rem;color:var(--taupe)}
.wl-admin-note{margin-top:.5rem;padding:.45rem .7rem;border-left:2px solid var(--gold);background:var(--cream);font-size:.75rem;line-height:1.5;color:var(--mocha)}
.wl-receipt{display:inline-flex;align-items:center;gap:.4rem;margin-top:.6rem;font-size:.6rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--caramel);text-decoration:none;border-bottom:1px solid var(--gold-line);padding-bottom:1px;transition:color .3s,border-color .3s}
.wl-receipt:hover{color:var(--esp);border-color:var(--esp);text-decoration:none}
.wl-side{text-align:right;flex-shrink:0}
.wl-date{margin-top:.5rem;font-size:.72rem;color:var(--taupe)}
.wl-badge{display:inline-flex;align-items:center;padding:.3rem .6rem;border:1px solid transparent;border-left-width:2px;font-size:.56rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;white-space:nowrap}
.wl-badge.badge-pending{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.wl-badge.badge-approved{background:#EFF2E8;color:var(--sage-d);border-color:rgba(94,127,90,.35);border-left-color:var(--sage)}
.wl-badge.badge-rejected{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}
.wl-empty{text-align:center;padding:3.5rem 1rem}
.wl-empty svg{color:var(--gold);opacity:.75;margin-bottom:1rem}
.wl-empty p{margin:0 0 .3rem;font-size:1.15rem;font-weight:900;letter-spacing:-.03em;color:var(--esp)}
.wl-empty span{font-size:.86rem;color:var(--mocha)}

/* modal (opens on user action) */
.wl-overlay{display:none;position:fixed;inset:0;background:rgba(36,21,15,.55);backdrop-filter:blur(3px);z-index:1000;align-items:center;justify-content:center;padding:1rem}
.wl-overlay.active{display:flex}
.wl-modal{width:100%;max-width:420px;background:var(--w);border-top:3px solid var(--gold);padding:2rem 2rem 1.75rem;box-shadow:0 30px 70px rgba(36,21,15,.35);animation:wl-modal .25s var(--e)}
.wl-modal-icon{display:flex;justify-content:center;margin-bottom:1rem;color:var(--gold)}
.wl-modal h3{margin:0 0 .6rem;text-align:center;font-size:1.4rem;font-weight:900;letter-spacing:-.04em;line-height:1.1}
.wl-modal p{margin:0 0 1.6rem;text-align:center;font-size:.88rem;line-height:1.65;color:var(--mocha)}
.wl-modal-actions{display:flex;gap:.6rem;justify-content:flex-end}
.wl-btn{display:inline-flex;align-items:center;justify-content:center;padding:.8rem 1.3rem;border:1px solid var(--esp);border-radius:0;background:transparent;font-size:.62rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:background .3s,color .3s,border-color .3s}
.wl-btn:hover{background:var(--esp);color:var(--gold-l)}
.wl-btn.solid{background:var(--esp);color:var(--ivory)}
.wl-btn.solid:hover{background:var(--gold);border-color:var(--gold);color:var(--esp)}

/* responsive */
@media(max-width:1000px){.wl-summary{grid-template-columns:1fr 1fr}.wl-balance{grid-column:1 / -1}}
@media(max-width:900px){.wl-grid{grid-template-columns:1fr}}
@media(max-width:520px){.wl-summary{grid-template-columns:1fr}.wl-grid-2{grid-template-columns:1fr}.wl-row{flex-direction:column}.wl-side{text-align:left}.wl-balance{padding:1.5rem}}
</style>
@endpush

@push('scripts')
<script>
function openWithdrawModal() {
    document.getElementById('withdrawModal').classList.add('active');
}
function closeWithdrawModal() {
    document.getElementById('withdrawModal').classList.remove('active');
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeWithdrawModal();
});
</script>
@endpush

@section('content')

@php
    // ── SVG icon set ──
    $icoWallet = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8a2 2 0 0 0-2-2H4a2 2 0 0 1 0-4h13"/><path d="M4 6v12a2 2 0 0 0 2 2h14a1 1 0 0 0 1-1v-5"/><path d="M18 14h.01"/></svg>';
    $icoSend   = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
    $icoSendLg = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
    $icoSendSm = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
    $icoClock  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
    $icoAlert  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
    $icoInfo   = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
    $icoList   = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>';
    $icoInbox  = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>';
    $icoReceipt= '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/></svg>';
@endphp

<div class="wallet-page">

    <div class="wl-header">
        <div>
            <h1 class="wl-title">My Wallet</h1>
            <p class="wl-sub">Your earnings are held securely. Request a withdrawal anytime.</p>
        </div>
    </div>

    {{-- Wallet Hero --}}
    <div class="wl-summary">
        <div class="wl-balance">
            <div class="wl-label">Available Balance</div>
            <div class="wl-balance-amount">₱{{ number_format($wallet->balance, 2) }}</div>
            <div class="wl-balance-sub">Ready to withdraw to your GCash or Maya</div>
        </div>
        <div class="wl-stat">
            <div class="wl-label">Total Earned</div>
            <div class="wl-stat-value earned">₱{{ number_format($wallet->total_earned, 2) }}</div>
        </div>
        <div class="wl-stat">
            <div class="wl-label">Total Withdrawn</div>
            <div class="wl-stat-value withdrawn">₱{{ number_format($wallet->total_withdrawn, 2) }}</div>
        </div>
    </div>

    @if($pendingWithdrawal)
    <div class="wl-note warning">
        {!! $icoClock !!}
        <div>
            <strong>Withdrawal Pending</strong> — You have a pending withdrawal of
            <strong>₱{{ number_format($pendingWithdrawal->amount, 2) }}</strong>
            to {{ strtoupper($pendingWithdrawal->payment_method) }} {{ $pendingWithdrawal->account_number }}.
            Admin will process it within 1–2 business days.
        </div>
    </div>
    @endif

    {{-- Withdrawal Request Form + History --}}
    <div class="wl-grid">
    @if(!$pendingWithdrawal && $wallet->balance >= 100)
    <div class="wl-panel">
        <div class="wl-panel-head">
            {!! $icoSend !!}
            <h2>Request Withdrawal</h2>
        </div>
        <form method="POST" action="{{ route('baker.wallet.withdraw') }}" id="withdrawForm">
            @csrf
            <div class="wl-form">
                @if($errors->any())
                <div class="wl-note error in-form">
                    {!! $icoAlert !!}
                    <div>{{ $errors->first() }}</div>
                </div>
                @endif

                <div class="wl-field">
                    <label class="wl-label" for="wd-amount">Amount to Withdraw *</label>
                    <input type="number" id="wd-amount" name="amount" class="wl-input"
                           min="100" max="{{ $wallet->balance }}"
                           step="0.01" placeholder="e.g. 500.00"
                           value="{{ old('amount') }}">
                    <span class="wl-hint">
                        Min ₱100 · Available: ₱{{ number_format($wallet->balance, 2) }}
                    </span>
                </div>

                <div class="wl-field">
                    <label class="wl-label" for="wd-method">Send To *</label>
                    <select id="wd-method" name="payment_method" class="wl-input">
                        <option value="gcash"  {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="maya"   {{ old('payment_method') === 'maya'  ? 'selected' : '' }}>Maya</option>
                    </select>
                </div>

                <div class="wl-grid-2">
                    <div class="wl-field">
                        <label class="wl-label" for="wd-name">Account Name *</label>
                        <input type="text" id="wd-name" name="account_name" class="wl-input"
                               placeholder="Full name on account"
                               value="{{ old('account_name') }}">
                    </div>
                    <div class="wl-field">
                        <label class="wl-label" for="wd-number">Account Number *</label>
                        <input type="text" id="wd-number" name="account_number" class="wl-input"
                               placeholder="09XX-XXX-XXXX"
                               value="{{ old('account_number') }}">
                    </div>
                </div>

                <div class="wl-info">
                    Withdrawals are processed manually by our team within <strong>1–2 business days</strong>.
                    You'll receive a notification once sent.
                </div>

                <button type="button" class="wl-submit" onclick="openWithdrawModal()">
                    {!! $icoSendSm !!} Request Withdrawal
                </button>
            </div>
        </form>
    </div>
    @elseif($wallet->balance < 100)
    <div class="wl-note info">
        {!! $icoInfo !!}
        <div>Minimum withdrawal is <strong>₱100</strong>. Complete more orders to increase your balance.</div>
    </div>
    @endif

    {{-- Withdrawal History --}}
    <div class="wl-panel">
        <div class="wl-panel-head">
            {!! $icoList !!}
            <h2>Withdrawal History</h2>
        </div>
        @if($withdrawals->isEmpty())
        <div class="wl-empty">
            {!! $icoInbox !!}
            <p>No withdrawals yet</p>
            <span>Your withdrawal requests will appear here.</span>
        </div>
        @else
        <div class="wl-scroll">
        @foreach($withdrawals as $wd)
        <div class="wl-row">
            <div>
                <div class="wl-amount">
                    ₱{{ number_format($wd->amount, 2) }}<span>→ {{ strtoupper($wd->payment_method) }}</span>
                </div>
                <div class="wl-meta">
                    {{ $wd->account_name }} · {{ $wd->account_number }}
                </div>
                @if($wd->admin_note)
                <div class="wl-admin-note">
                    "{{ $wd->admin_note }}"
                </div>
                @endif
                @if($wd->receipt_path)
                <a href="{{ asset('storage/' . $wd->receipt_path) }}" target="_blank" class="wl-receipt">
                    {!! $icoReceipt !!} View Receipt
                </a>
                @endif
            </div>
            <div class="wl-side">
                <span class="wl-badge badge-{{ $wd->status }}">
                    {{ ucfirst($wd->status) }}
                </span>
                <div class="wl-date">
                    {{ $wd->requested_at?->format('M d, Y') }}
                </div>
            </div>
        </div>
        @endforeach
        </div>
        @endif
    </div>

    </div>{{-- end .wl-grid --}}

    {{-- WITHDRAW CONFIRM MODAL --}}
    <div id="withdrawModal" class="wl-overlay" onclick="closeWithdrawModal()">
        <div class="wl-modal" role="dialog" aria-modal="true" aria-labelledby="wlModalTitle" onclick="event.stopPropagation()">
            <div class="wl-modal-icon">{!! $icoSendLg !!}</div>
            <h3 id="wlModalTitle">Confirm Withdrawal</h3>
            <p>Are you sure you want to request this withdrawal? Admin will process it within 1–2 business days.</p>
            <div class="wl-modal-actions">
                <button type="button" class="wl-btn" onclick="closeWithdrawModal()">Cancel</button>
                <button type="button" class="wl-btn solid" onclick="document.getElementById('withdrawForm').submit()">
                    Yes, Request
                </button>
            </div>
        </div>
    </div>

</div>{{-- /.wallet-page --}}

@endsection