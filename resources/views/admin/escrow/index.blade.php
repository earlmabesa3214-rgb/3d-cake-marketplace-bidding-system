@extends('layouts.admin')
@section('title', 'Escrow Management')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ==========================================================
   BakeSphere Admin · Escrow Management
   Prefix: es-  (scoped under .es, modals included)
   ========================================================== */
.es{
    --espresso:#24150F;--chocolate:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;
    --caramel:#A96F42;--gold:#B89452;--burgundy:#54252C;--taupe:#9A897A;--beige:#D8C8B7;
    --ink:#24150F;--ink-2:#5B463A;--ink-3:#8A7868;
    --line:#E3D8C8;--line-strong:#D8C8B7;
    --ok:#3F6B4E;--ok-bg:#E7EEE6;--ok-line:#C5D6C6;--ok-deep:#2F4F3A;
    --warn:#7A5A14;--warn-bg:#F5EBD3;--warn-line:#E4D2A2;
    --danger:#54252C;--danger-bg:#F3E6E6;--danger-line:#DDBFC2;
    --radius:4px;
    font-family:'Plus Jakarta Sans',sans-serif;
    color:var(--ink);
    padding-bottom:4rem;
}
.es *,.es *::before,.es *::after{box-sizing:border-box;font-family:inherit;}

@keyframes es-rise{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
@keyframes es-fade{from{opacity:0}to{opacity:1}}

/* ---------- Header ---------- */
.es-head{background:var(--espresso);color:var(--ivory);padding:1.75rem 2.25rem 0;border-bottom:3px solid var(--gold);animation:es-rise .5s ease both;}
.es-crumbs{display:flex;align-items:center;gap:.5rem;font-size:.6875rem;font-weight:500;letter-spacing:.06em;color:rgba(247,242,233,.5);margin-bottom:1.5rem;}
.es-crumbs svg{opacity:.5;}
.es-crumbs strong{color:var(--gold);font-weight:600;}
.es-head-main{display:flex;align-items:flex-end;justify-content:space-between;gap:2rem;flex-wrap:wrap;padding-bottom:1.75rem;}
.es-title{margin:0 0 .5rem;font-size:2.25rem;font-weight:800;letter-spacing:-.035em;line-height:1.05;color:var(--ivory);}
.es-lede{margin:0;max-width:40ch;font-size:.9375rem;line-height:1.55;color:rgba(247,242,233,.62);}

.es-stats{display:flex;flex-wrap:wrap;margin:0;padding:0;list-style:none;row-gap:1rem;}
.es-stat{padding:0 1.75rem;min-width:9rem;border-left:1px solid rgba(216,200,183,.2);}
.es-stat:first-child{padding-left:0;border-left:none;}
.es-stat:last-child{padding-right:0;}
.es-stat-label{display:block;font-size:.6875rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:rgba(247,242,233,.5);margin-bottom:.375rem;}
.es-stat-value{display:block;font-size:1.75rem;font-weight:700;letter-spacing:-.03em;line-height:1;color:var(--ivory);font-variant-numeric:tabular-nums;}
.es-stat-value--gold{color:var(--gold);}
.es-stat-note{display:block;margin-top:.375rem;font-size:.6875rem;color:rgba(247,242,233,.45);}

/* ---------- Tabs ---------- */
.es-tabs{display:flex;gap:0;padding:0 2.25rem;background:var(--cream);border-bottom:1px solid var(--line-strong);overflow-x:auto;overflow-y:hidden;animation:es-fade .6s .1s ease both;}
.es-tab{
    display:inline-flex;align-items:center;gap:.5rem;white-space:nowrap;
    padding:1rem 1.25rem;margin-bottom:-1px;border:none;border-bottom:2px solid transparent;background:none;
    font-size:.8125rem;font-weight:600;color:var(--ink-3);cursor:pointer;transition:color .15s,border-color .15s;
}
.es-tab:hover{color:var(--ink);}
.es-tab.is-active{color:var(--ink);border-bottom-color:var(--espresso);font-weight:700;}
.es-tab.is-active svg{color:var(--caramel);}
.es-tab-count{padding:.125rem .5rem;border-radius:var(--radius);background:var(--espresso);color:var(--ivory);font-size:.625rem;font-weight:700;font-variant-numeric:tabular-nums;}

/* ---------- Body ---------- */
.es-body{padding:1.75rem 2.25rem 0;}
.es-panel{display:none;}
.es-panel.is-active{display:block;animation:es-fade .3s ease both;}

.es-alert{display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem;padding:.875rem 1.125rem;border-radius:var(--radius);border:1px solid;border-left-width:3px;font-size:.8125rem;font-weight:500;}
.es-alert svg{flex-shrink:0;}
.es-alert--success{background:var(--ok-bg);border-color:var(--ok-line);border-left-color:var(--ok);color:var(--ok-deep);}
.es-alert--error{background:var(--danger-bg);border-color:var(--danger-line);border-left-color:var(--danger);color:var(--danger);}

/* Search */
.es-search{position:relative;max-width:360px;margin-bottom:1rem;}
.es-search svg{position:absolute;left:.8125rem;top:50%;transform:translateY(-50%);color:var(--ink-3);pointer-events:none;}
.es-search .es-input{padding-left:2.5rem;}

/* Inputs */
.es-input{
    width:100%;height:40px;padding:0 .875rem;border:1px solid var(--line-strong);border-radius:var(--radius);
    background:#fff;color:var(--ink);font-size:.8125rem;font-weight:500;outline:none;
    transition:border-color .15s,box-shadow .15s;
}
textarea.es-input{height:auto;padding:.625rem .875rem;resize:vertical;line-height:1.5;}
select.es-input{cursor:pointer;}
.es-input::placeholder{color:var(--ink-3);font-weight:400;}
.es-input:focus{border-color:var(--caramel);box-shadow:0 0 0 3px rgba(184,148,82,.22);}
.es-label{display:block;margin-bottom:.375rem;font-size:.6875rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-3);}
.es-field{margin-bottom:.875rem;}

/* Data surface & table */
.es-surface{background:#fff;border:1px solid var(--line-strong);border-radius:var(--radius);overflow:hidden;}
.es-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;}
.es-table{width:100%;border-collapse:collapse;}
.es-table--wide{min-width:1040px;}
.es-table--mid{min-width:820px;}
.es-table--narrow{min-width:720px;}
.es-table th{padding:.75rem 1.25rem;text-align:left;white-space:nowrap;font-size:.6875rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-3);background:var(--ivory);border-bottom:1px solid var(--line-strong);}
.es-table td{padding:1rem 1.25rem;vertical-align:middle;border-bottom:1px solid var(--line);font-size:.8125rem;color:var(--ink);}
.es-table tbody tr:last-child td{border-bottom:none;}
.es-table tbody tr{transition:background .12s;}
.es-table tbody tr:hover{background:var(--ivory);}

.es-strong{font-weight:700;color:var(--ink);}
.es-sub{margin-top:.125rem;font-size:.6875rem;color:var(--ink-3);}
.es-time{font-size:.75rem;color:var(--ink-2);font-variant-numeric:tabular-nums;white-space:nowrap;}
.es-amount{font-size:.9375rem;font-weight:700;letter-spacing:-.01em;color:var(--ink);font-variant-numeric:tabular-nums;white-space:nowrap;}
.es-amount--payout{font-size:1rem;}
.es-muted{font-size:.75rem;color:var(--ink-3);}
.es-code{display:inline-block;padding:.1875rem .5rem;border:1px solid var(--line);border-radius:var(--radius);background:var(--ivory);font-size:.75rem;font-weight:600;color:var(--ink-2);letter-spacing:.02em;}
.es-inline{display:flex;align-items:center;gap:.375rem;}
.es-row-actions{display:flex;gap:.375rem;flex-wrap:wrap;}

/* Proof thumb */
.es-proof{width:44px;height:44px;border-radius:var(--radius);object-fit:cover;border:1px solid var(--line-strong);cursor:zoom-in;transition:border-color .15s;}
.es-proof:hover{border-color:var(--caramel);}

/* Badges */
.es-badge{display:inline-flex;align-items:center;gap:.375rem;padding:.25rem .625rem;border-radius:var(--radius);border:1px solid transparent;font-size:.6875rem;font-weight:700;letter-spacing:.02em;white-space:nowrap;}
.es-badge::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;flex-shrink:0;}
.es-badge--pending{background:var(--warn-bg);border-color:var(--warn-line);color:var(--warn);}
.es-badge--held{background:var(--cream);border-color:var(--line-strong);color:var(--chocolate);}
.es-badge--released{background:var(--ok-bg);border-color:var(--ok-line);color:var(--ok);}
.es-badge--rejected{background:var(--danger-bg);border-color:var(--danger-line);color:var(--danger);}

/* Buttons */
.es-btn{display:inline-flex;align-items:center;justify-content:center;gap:.4rem;height:34px;padding:0 .875rem;border-radius:var(--radius);border:1px solid transparent;font-size:.75rem;font-weight:700;cursor:pointer;white-space:nowrap;transition:background .15s,border-color .15s,color .15s;}
.es-btn--confirm{background:var(--ok-deep);border-color:var(--ok-deep);color:var(--ivory);}
.es-btn--confirm:hover{background:var(--ok);border-color:var(--ok);}
.es-btn--approve{background:var(--espresso);border-color:var(--espresso);color:var(--ivory);}
.es-btn--approve:hover{background:var(--chocolate);border-color:var(--chocolate);}
.es-btn--reject{background:#fff;border-color:var(--danger-line);color:var(--danger);}
.es-btn--reject:hover{background:var(--danger-bg);border-color:var(--danger);}
.es-btn--block{width:100%;height:40px;}
.es-btn:disabled{opacity:.55;cursor:not-allowed;}

.es-copy{display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;width:26px;height:26px;padding:0;border:1px solid var(--line-strong);border-radius:var(--radius);background:#fff;color:var(--ink-3);cursor:pointer;transition:background .15s,border-color .15s,color .15s;}
.es-copy:hover{background:var(--ivory);border-color:var(--caramel);color:var(--caramel);}
.es-copy.is-copied{background:var(--ok-bg);border-color:var(--ok-line);color:var(--ok);}

/* Empty state */
.es-empty{padding:4rem 2rem;text-align:center;background:#fff;border:1px solid var(--line-strong);border-radius:var(--radius);}
.es-empty-icon{width:48px;height:48px;margin:0 auto 1.25rem;display:flex;align-items:center;justify-content:center;border:1px solid var(--line-strong);border-radius:var(--radius);background:var(--ivory);color:var(--caramel);}
.es-empty-text{margin:0;font-size:.875rem;font-weight:600;color:var(--ink-2);}

/* Platform accounts */
.es-accounts{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1.5rem;}
.es-account{background:#fff;border:1px solid var(--line-strong);border-radius:var(--radius);overflow:hidden;}
.es-account-head{display:flex;align-items:center;gap:.875rem;padding:1rem 1.5rem;border-bottom:1px solid var(--line-strong);background:var(--ivory);}
.es-account-icon{width:40px;height:40px;flex-shrink:0;display:flex;align-items:center;justify-content:center;border-radius:var(--radius);color:var(--ivory);}
.es-account-icon--gcash{background:linear-gradient(135deg,#8A5A35,#A96F42);}
.es-account-icon--other{background:linear-gradient(135deg,#24150F,#3A241A);}
.es-account-name{font-size:.9375rem;font-weight:800;letter-spacing:-.01em;color:var(--ink);}
.es-account-head .es-badge{margin-left:auto;}
.es-account-body{padding:1.5rem;}
.es-qr{text-align:center;margin-bottom:1.25rem;}
.es-qr img{width:120px;height:120px;object-fit:contain;border:1px solid var(--line-strong);border-radius:var(--radius);background:#fff;cursor:zoom-in;}
.es-dl{margin:0 0 1.25rem;border:1px solid var(--line);border-radius:var(--radius);background:var(--ivory);}
.es-dl-row{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:.75rem 1rem;font-size:.8125rem;}
.es-dl-row + .es-dl-row{border-top:1px solid var(--line);}
.es-dl-row dt{font-size:.6875rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-3);}
.es-dl-row dd{margin:0;font-weight:700;color:var(--ink);}
.es-file{width:100%;font-size:.8125rem;color:var(--ink-2);}

/* Modals */
.es-overlay{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(36,21,15,.7);opacity:0;pointer-events:none;transition:opacity .2s;}
.es-overlay.is-open{opacity:1;pointer-events:all;}
.es-modal{width:100%;max-width:480px;max-height:calc(100vh - 2rem);overflow-y:auto;background:var(--ivory);border-radius:6px;box-shadow:0 24px 60px rgba(0,0,0,.35);transform:translateY(10px);transition:transform .25s ease;}
.es-overlay.is-open .es-modal{transform:none;}
.es-modal-head{padding:1.375rem 1.75rem 1.25rem;color:var(--ivory);border-bottom:3px solid var(--gold);}
.es-modal-head--ok{background:var(--ok-deep);}
.es-modal-head--danger{background:var(--burgundy);}
.es-modal-head--neutral{background:var(--espresso);}
.es-modal-title{display:flex;align-items:center;gap:.5rem;margin:0 0 .25rem;font-size:1.0625rem;font-weight:800;letter-spacing:-.015em;}
.es-modal-desc{margin:0;font-size:.75rem;color:rgba(247,242,233,.7);}
.es-modal-body{padding:1.5rem 1.75rem;}
.es-modal-foot{display:flex;gap:.75rem;padding:0 1.75rem 1.5rem;}
.es-modal-foot .es-modal-cancel{flex:1;}
.es-modal-foot .es-modal-submit{flex:2;}
.es-modal-cancel,.es-modal-submit{display:inline-flex;align-items:center;justify-content:center;gap:.4rem;height:42px;padding:0 1rem;border-radius:var(--radius);font-size:.8125rem;font-weight:700;cursor:pointer;transition:background .15s,border-color .15s;}
.es-modal-cancel{background:#fff;border:1px solid var(--line-strong);color:var(--ink-2);}
.es-modal-cancel:hover{border-color:var(--taupe);color:var(--ink);}
.es-modal-submit{border:1px solid transparent;color:var(--ivory);}
.es-modal-submit--ok{background:var(--ok-deep);}
.es-modal-submit--ok:hover{background:var(--ok);}
.es-modal-submit--danger{background:var(--burgundy);}
.es-modal-submit--danger:hover{background:#6B3039;}
.es-modal-submit--neutral{background:var(--espresso);}
.es-modal-submit--neutral:hover{background:var(--chocolate);}
.es-modal-submit:disabled{opacity:.55;cursor:not-allowed;}
.es-detail{margin-bottom:1rem;padding:1rem 1.125rem;border:1px solid var(--line-strong);border-radius:var(--radius);background:#fff;font-size:.8125rem;line-height:1.6;color:var(--ink-2);}
.es-detail strong{color:var(--ink);}
.es-detail .es-detail-accent{color:var(--caramel);}
.es-hint{margin:0;font-size:.75rem;line-height:1.5;color:var(--ink-3);}
.es-check{display:flex;align-items:flex-start;gap:.5rem;margin-top:.25rem;font-size:.8125rem;color:var(--ink);cursor:pointer;}
.es-check input{margin-top:.2rem;accent-color:var(--espresso);}
.es-error{display:none;margin-top:.5rem;font-size:.75rem;font-weight:600;color:var(--danger);}

/* Lightbox */
.es-lightbox{position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;background:rgba(20,10,5,.92);}
.es-lightbox.is-open{display:flex;}
.es-lightbox img{max-width:90vw;max-height:90vh;border-radius:var(--radius);}
.es-lightbox-close{position:absolute;top:1.5rem;right:1.5rem;width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(247,242,233,.25);border-radius:var(--radius);background:rgba(247,242,233,.08);color:var(--ivory);cursor:pointer;transition:background .15s;}
.es-lightbox-close:hover{background:rgba(247,242,233,.18);}

/* Focus & motion */
.es a:focus-visible,.es button:focus-visible,.es input:focus-visible{outline:2px solid var(--gold);outline-offset:2px;}
@media (prefers-reduced-motion:reduce){.es *,.es *::before,.es *::after{animation:none!important;transition:none!important;}}

/* Responsive */
@media (max-width:1024px){
    .es-head,.es-tabs,.es-body{padding-left:1.5rem;padding-right:1.5rem;}
    .es-accounts{grid-template-columns:1fr;}
}
@media (max-width:768px){
    .es-head{padding:1.25rem 1rem 0;}
    .es-head-main{flex-direction:column;align-items:stretch;gap:1.25rem;}
    .es-title{font-size:1.75rem;}
    .es-stats{display:grid;grid-template-columns:1fr 1fr;border-top:1px solid rgba(216,200,183,.2);padding-top:1.25rem;column-gap:0;}
    .es-stat,.es-stat:first-child,.es-stat:last-child{padding:0 1rem;min-width:0;border-left:none;}
    .es-stat:nth-child(odd){padding-left:0;}
    .es-stat:nth-child(even){border-left:1px solid rgba(216,200,183,.2);}
    .es-stat-value{font-size:1.375rem;}
    .es-tabs{padding:0 1rem;}
    .es-body{padding:1.25rem 1rem 0;}
    .es-search{max-width:none;}
    .es-table th,.es-table td{padding:.875rem 1rem;}
    .es-modal-head,.es-modal-body{padding-left:1.25rem;padding-right:1.25rem;}
    .es-modal-foot{padding:0 1.25rem 1.25rem;}
}
</style>
@endpush

@section('content')

@php
    $pendingCount     = $pendingPayments->count();
    $heldTotal        = $heldPayments->sum('amount');
    $pendingWithdrawTotal = $pendingWithdrawals->sum('amount');
@endphp
<div class="es ah-page">

<div class="ah-top">
<header class="ah-hero">
    <div class="ah-hero-main">
        <span class="ah-hero-mark"><svg class="ah-ic" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
        <div>
            <div class="ah-eyebrow">BakeSphere &middot; Finance</div>
            <h1 class="ah-title">Escrow Management</h1>
            <p class="ah-subtitle">Review payment proofs, hold funds, release to bakers, and manage withdrawals.</p>
        </div>
    </div>
    <div class="ah-side">
        <span class="ah-side-label"><span class="ah-dot"></span>Live escrow</span>
        <span class="ah-side-value">Updated {{ now()->format('M d, H:i') }}</span>
    </div>
</header>
<section class="ah-ledger" aria-label="Escrow summary">
    <div class="ah-fig"><div class="ah-fig-lbl">Pending Review</div><div class="ah-fig-val">{{ $pendingCount }}</div><div class="ah-fig-note">Proofs awaiting verification</div></div>
    <div class="ah-fig ah-fig--sage"><div class="ah-fig-lbl">Held in Escrow</div><div class="ah-fig-val">₱{{ number_format($heldTotal, 2) }}</div><div class="ah-fig-note">{{ $heldPayments->count() }} payments held</div></div>
    <div class="ah-fig ah-fig--burgundy"><div class="ah-fig-lbl">Pending Withdrawals</div><div class="ah-fig-val">₱{{ number_format($pendingWithdrawTotal, 2) }}</div><div class="ah-fig-note">{{ $pendingWithdrawals->count() }} requests</div></div>
        <div class="ah-fig ah-fig--caramel"><div class="ah-fig-lbl">Platform Fee (5%)</div><div class="ah-fig-val">₱{{ number_format($heldTotal * 0.05, 2) }}</div><div class="ah-fig-note">Total collected</div></div>
</section>
</div>

    {{-- Tabs --}}
    <div class="es-tabs" role="tablist">
        <button type="button" class="es-tab is-active" role="tab" onclick="switchTab('pending', this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/></svg>
            Pending Proofs
            @if($pendingCount > 0)
            <span class="es-tab-count">{{ $pendingCount }}</span>
            @endif
        </button>
        <button type="button" class="es-tab" role="tab" onclick="switchTab('held', this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
            Held in Escrow
        </button>
        <button type="button" class="es-tab" role="tab" onclick="switchTab('withdrawals', this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
            Withdrawals
            @if($pendingWithdrawals->count() > 0)
            <span class="es-tab-count">{{ $pendingWithdrawals->count() }}</span>
            @endif
        </button>
        <button type="button" class="es-tab" role="tab" onclick="switchTab('accounts', this)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Platform Accounts
        </button>
    </div>

    <div class="es-body">

        @if(session('success'))
        <div class="es-alert es-alert--success" role="status">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="es-alert es-alert--error" role="alert">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Tab: Pending Proofs --}}
        <div class="es-panel is-active" id="tab-pending">
            @if($pendingPayments->isEmpty())
            <div class="es-empty">
                <div class="es-empty-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <p class="es-empty-text">No pending payment proofs. You're all caught up!</p>
            </div>
            @else
            <div class="es-search">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="es-input" placeholder="Search by customer, order # or reference…" aria-label="Search pending proofs" oninput="filterTable(this.value, 'table-pending')">
            </div>
            <div class="es-surface">
                <div class="es-scroll">
                    <table class="es-table es-table--wide" id="table-pending">
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
                                         class="es-proof"
                                         onclick="openLightbox('{{ asset('storage/'.$payment->proof_of_payment_path) }}')"
                                         alt="Proof">
                                    @else
                                    <span class="es-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="es-strong">#{{ str_pad($payment->cake_request_id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="es-sub">Baker: {{ $payment->cakeRequest?->bakerOrder?->baker?->first_name ?? '—' }}</div>
                                </td>
                                <td>
                                    <div class="es-strong">{{ $payment->cakeRequest?->user?->first_name }} {{ $payment->cakeRequest?->user?->last_name }}</div>
                                    <div class="es-sub">{{ $payment->cakeRequest?->user?->email }}</div>
                                </td>
                                <td>
                                    <span class="es-badge {{ $payment->payment_type === 'downpayment' ? 'es-badge--pending' : 'es-badge--held' }}">
                                        {{ ucfirst($payment->payment_type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="es-amount">₱{{ number_format($payment->amount, 2) }}</div>
                                    <div class="es-sub">of ₱{{ number_format($payment->agreed_price, 2) }}</div>
                                </td>
                                <td>{{ strtoupper($payment->payment_method ?? '—') }}</td>
                                <td>
                                    <div class="es-inline">
                                        <code class="es-code">{{ $payment->platform_reference ?? '—' }}</code>
                                        @if($payment->platform_reference)
                                        <button type="button" class="es-copy" title="Copy reference" aria-label="Copy reference" onclick="copyToClipboard('{{ $payment->platform_reference }}', this)">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="es-time">{{ $payment->paid_at?->format('M d · g:i A') }}</span></td>
                                <td>
                                    <div class="es-row-actions">
                                        <button type="button" class="es-btn es-btn--confirm"
                                            onclick="openConfirmModal({{ $payment->id }}, '{{ $payment->platform_reference }}', '₱{{ number_format($payment->amount, 2) }}')">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Confirm
                                        </button>
                                        <button type="button" class="es-btn es-btn--reject"
                                            onclick="openRejectModal({{ $payment->id }})">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Tab: Held in Escrow --}}
        <div class="es-panel" id="tab-held">
            @if($heldPayments->isEmpty())
            <div class="es-empty">
                <div class="es-empty-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg></div>
                <p class="es-empty-text">No funds currently held in escrow.</p>
            </div>
            @else
            <div class="es-search">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="es-input" placeholder="Search by customer, baker or reference…" aria-label="Search held payments" oninput="filterTable(this.value, 'table-held')">
            </div>
            <div class="es-surface">
                <div class="es-scroll">
                    <table class="es-table es-table--wide" id="table-held">
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
                                <td><span class="es-strong">#{{ str_pad($payment->cake_request_id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td>{{ $payment->cakeRequest?->user?->first_name }} {{ $payment->cakeRequest?->user?->last_name }}</td>
                                <td>{{ $payment->cakeRequest?->bakerOrder?->baker?->first_name ?? '—' }}</td>
                                <td><span class="es-badge es-badge--held">{{ ucfirst($payment->payment_type) }}</span></td>
                                <td><span class="es-amount">₱{{ number_format($payment->amount, 2) }}</span></td>
                                <td>
                                    <div class="es-inline">
                                        <code class="es-code">{{ $payment->platform_reference }}</code>
                                        <button type="button" class="es-copy" title="Copy reference" aria-label="Copy reference" onclick="copyToClipboard('{{ $payment->platform_reference }}', this)">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                        </button>
                                    </div>
                                </td>
                                <td><span class="es-time">{{ $payment->held_at?->format('M d · g:i A') }}</span></td>
                                <td>
                                    <span class="es-badge es-badge--pending">
                                        {{ $payment->cakeRequest?->bakerOrder?->status ?? '—' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Tab: Withdrawals --}}
        <div class="es-panel" id="tab-withdrawals">
            @if($pendingWithdrawals->isEmpty())
            <div class="es-empty">
                <div class="es-empty-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/></svg></div>
                <p class="es-empty-text">No pending withdrawal requests.</p>
            </div>
            @else
            <div class="es-search">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="es-input" placeholder="Search by baker name or account…" aria-label="Search withdrawals" oninput="filterTable(this.value, 'table-withdrawals')">
            </div>
            <div class="es-surface">
                <div class="es-scroll">
                    <table class="es-table es-table--mid" id="table-withdrawals">
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
                                    <div class="es-strong">{{ $wr->baker?->first_name }} {{ $wr->baker?->last_name }}</div>
                                    <div class="es-sub">{{ $wr->baker?->email }}</div>
                                </td>
                                <td><span class="es-amount es-amount--payout">₱{{ number_format($wr->amount, 2) }}</span></td>
                                <td><span class="es-badge es-badge--pending">{{ strtoupper($wr->payment_method) }}</span></td>
                                <td>
                                    <div class="es-strong">{{ $wr->account_name }}</div>
                                    <div class="es-inline" style="margin-top:.25rem;">
                                        <code class="es-code">{{ $wr->account_number }}</code>
                                        <button type="button" class="es-copy" title="Copy account number" aria-label="Copy account number" onclick="copyToClipboard('{{ $wr->account_number }}', this)">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                        </button>
                                    </div>
                                </td>
                                <td><span class="es-time">{{ $wr->requested_at?->format('M d, Y · g:i A') }}</span></td>
                                <td>
                                    <div class="es-row-actions">
                                        <button type="button" class="es-btn es-btn--approve"
                                            onclick="openApproveWithdrawalModal({{ $wr->id }}, '{{ $wr->baker?->first_name }}', '₱{{ number_format($wr->amount, 2) }}', '{{ $wr->account_number }}')">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Approve &amp; Send
                                        </button>
                                        <button type="button" class="es-btn es-btn--reject"
                                            onclick="openRejectWithdrawalModal({{ $wr->id }})">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Tab: Platform Accounts --}}
        <div class="es-panel" id="tab-accounts">
            <div class="es-accounts">
                @foreach($platformAccounts as $account)
                <article class="es-account">
                    <div class="es-account-head">
                        <div class="es-account-icon {{ $account->type === 'gcash' ? 'es-account-icon--gcash' : 'es-account-icon--other' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>
                        </div>
                        <div>
                            <div class="es-account-name">{{ strtoupper($account->type) }}</div>
                            <div class="es-sub">Platform collection account</div>
                        </div>
                        <span class="es-badge {{ $account->is_active ? 'es-badge--released' : 'es-badge--rejected' }}">
                            {{ $account->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="es-account-body">
                        @if($account->qr_code_path)
                        <div class="es-qr">
                            <img src="{{ asset('storage/'.$account->qr_code_path) }}"
                                 alt="QR code"
                                 onclick="openLightbox('{{ asset('storage/'.$account->qr_code_path) }}')">
                        </div>
                        @endif

                        <dl class="es-dl">
                            <div class="es-dl-row">
                                <dt>Account Name</dt>
                                <dd>{{ $account->account_name }}</dd>
                            </div>
                            <div class="es-dl-row">
                                <dt>Number</dt>
                                <dd class="es-inline">
                                    <span>{{ $account->account_number }}</span>
                                    <button type="button" class="es-copy" title="Copy account number" aria-label="Copy account number" onclick="copyToClipboard('{{ $account->account_number }}', this)">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                    </button>
                                </dd>
                            </div>
                        </dl>

                        <form method="POST"
                              action="{{ route('admin.escrow.account.update', $account->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="es-field">
                                <label class="es-label">Account Name</label>
                                <input type="text" name="account_name" class="es-input" value="{{ $account->account_name }}">
                            </div>
                            <div class="es-field">
                                <label class="es-label">Account Number</label>
                                <input type="text" name="account_number" class="es-input" value="{{ $account->account_number }}">
                            </div>
                            <div class="es-field">
                                <label class="es-label">Update QR Code</label>
                                <input type="file" name="qr_code" accept="image/*" class="es-file">
                            </div>
                            <button type="submit" class="es-btn es-btn--approve es-btn--block">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Save Changes
                            </button>
                        </form>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ── CONFIRM PAYMENT MODAL ── --}}
    <div class="es-overlay" id="modal-confirm-payment">
        <div class="es-modal">
            <div class="es-modal-head es-modal-head--ok">
                <h3 class="es-modal-title"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Confirm Payment Receipt</h3>
                <p class="es-modal-desc">Verify you've received this payment in the platform account</p>
            </div>
            <div class="es-modal-body">
                <div class="es-detail" id="confirm-payment-detail"></div>
                <label class="es-label" for="confirm-ref-input">Confirm Reference Number *</label>
                <input type="text" class="es-input" id="confirm-ref-input" placeholder="Enter reference number to confirm">
                <div id="confirm-ref-error" class="es-error"></div>
                <p class="es-hint" style="margin-top:.75rem;">Once confirmed, funds will be held in escrow and the baker will be notified to start preparing.</p>
            </div>
            <div class="es-modal-foot">
                <button type="button" class="es-modal-cancel" onclick="closeModal('modal-confirm-payment')">Cancel</button>
                <button type="button" class="es-modal-submit es-modal-submit--ok" onclick="submitConfirmPayment(this)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Confirm &amp; Hold in Escrow</button>
            </div>
        </div>
    </div>

    {{-- ── REJECT PAYMENT MODAL ── --}}
    <div class="es-overlay" id="modal-reject-payment">
        <div class="es-modal">
            <div class="es-modal-head es-modal-head--danger">
                <h3 class="es-modal-title"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject Payment Proof</h3>
                <p class="es-modal-desc">Customer will be asked to resubmit</p>
            </div>
            <div class="es-modal-body">
                <div class="es-field">
                    <label class="es-label" for="reject-reason-select">Reason *</label>
                    <select class="es-input" id="reject-reason-select">
                        @foreach(\App\Models\Payment::REJECTION_REASONS as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="es-label" for="reject-note-input">Note (optional)</label>
                <textarea class="es-input" id="reject-note-input" rows="3" placeholder="Additional details for the customer…"></textarea>
            </div>
            <div class="es-modal-foot">
                <button type="button" class="es-modal-cancel" onclick="closeModal('modal-reject-payment')">Cancel</button>
                <button type="button" class="es-modal-submit es-modal-submit--danger" onclick="submitRejectPayment(this)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject Proof</button>
            </div>
        </div>
    </div>

    {{-- ── APPROVE WITHDRAWAL MODAL ── --}}
    <div class="es-overlay" id="modal-approve-withdrawal">
        <div class="es-modal">
            <div class="es-modal-head es-modal-head--neutral">
                <h3 class="es-modal-title"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/></svg> Approve Withdrawal</h3>
                <p class="es-modal-desc">Confirm you've sent the funds manually</p>
            </div>
            <div class="es-modal-body">
                <div class="es-detail" id="withdrawal-detail"></div>
                <label class="es-label" for="withdrawal-admin-note">Admin Note (optional)</label>
                <input type="text" class="es-input" id="withdrawal-admin-note" placeholder="e.g. Sent via GCash ref #1234567890" style="margin-bottom:.875rem;">
                <label class="es-check">
                    <input type="checkbox" id="withdrawal-confirm-check">
                    <span>I confirm I have manually sent these funds to the account above.</span>
                </label>
                <div id="withdrawal-error" class="es-error"></div>
            </div>
            <div class="es-modal-foot">
                <button type="button" class="es-modal-cancel" onclick="closeModal('modal-approve-withdrawal')">Cancel</button>
                <button type="button" class="es-modal-submit es-modal-submit--neutral" onclick="submitApproveWithdrawal(this)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Mark as Sent</button>
            </div>
        </div>
    </div>

    {{-- ── REJECT WITHDRAWAL MODAL ── --}}
    <div class="es-overlay" id="modal-reject-withdrawal">
        <div class="es-modal">
            <div class="es-modal-head es-modal-head--danger">
                <h3 class="es-modal-title"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject Withdrawal</h3>
                <p class="es-modal-desc">Funds stay in baker's wallet</p>
            </div>
            <div class="es-modal-body">
                <label class="es-label" for="reject-withdrawal-note">Reason *</label>
                <textarea class="es-input" id="reject-withdrawal-note" rows="3" placeholder="Reason for rejection…"></textarea>
                <div id="reject-withdrawal-error" class="es-error"></div>
            </div>
            <div class="es-modal-foot">
                <button type="button" class="es-modal-cancel" onclick="closeModal('modal-reject-withdrawal')">Cancel</button>
                <button type="button" class="es-modal-submit es-modal-submit--danger" onclick="submitRejectWithdrawal(this)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject Request</button>
            </div>
        </div>
    </div>

    {{-- Lightbox --}}
    <div class="es-lightbox" id="lightbox" onclick="closeLightbox()">
        <button type="button" class="es-lightbox-close" aria-label="Close image" onclick="event.stopPropagation(); closeLightbox()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
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

</div>

@push('scripts')
<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.es-tab').forEach(b => b.classList.remove('is-active'));
    document.querySelectorAll('.es-panel').forEach(p => p.classList.remove('is-active'));
    btn.classList.add('is-active');
    document.getElementById('tab-' + tab).classList.add('is-active');
}

function filterTable(query, tableId) {
    const q = query.trim().toLowerCase();
    document.querySelectorAll('#' + tableId + ' tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function copyToClipboard(text, btn) {
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const original = btn.innerHTML;
        btn.classList.add('is-copied');
        btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        setTimeout(() => { btn.classList.remove('is-copied'); btn.innerHTML = original; }, 1500);
    });
}

function showInlineError(id, message) {
    const el = document.getElementById(id);
    el.textContent = message;
    el.style.display = 'block';
}
function hideInlineError(id) {
    document.getElementById(id).style.display = 'none';
}
function setSubmitting(btn, label) {
    if (!btn) return;
    btn.disabled = true;
    btn.innerHTML = label;
}

let _confirmPaymentId = null;
function openConfirmModal(id, ref, amount) {
    _confirmPaymentId = id;
    hideInlineError('confirm-ref-error');
    document.getElementById('confirm-ref-input').value = ref || '';
    document.getElementById('confirm-payment-detail').innerHTML =
        `<strong>Payment #${id}</strong> · Amount: <strong class="es-detail-accent">${amount}</strong><br>
         <span class="es-muted">Submitted reference: <code class="es-code">${ref || 'None'}</code></span>`;
    openModal('modal-confirm-payment');
}
function submitConfirmPayment(btn) {
    const ref = document.getElementById('confirm-ref-input').value.trim();
    if (!ref) { showInlineError('confirm-ref-error', 'Please enter the reference number.'); return; }
    hideInlineError('confirm-ref-error');
    document.getElementById('form-confirm-ref').value = ref;
    document.getElementById('form-confirm-payment').action =
        `/admin/escrow/payments/${_confirmPaymentId}/confirm`;
    setSubmitting(btn, 'Confirming…');
    document.getElementById('form-confirm-payment').submit();
}

let _rejectPaymentId = null;
function openRejectModal(id) {
    _rejectPaymentId = id;
    document.getElementById('reject-reason-select').selectedIndex = 0;
    document.getElementById('reject-note-input').value = '';
    openModal('modal-reject-payment');
}
function submitRejectPayment(btn) {
    document.getElementById('form-reject-reason').value =
        document.getElementById('reject-reason-select').value;
    document.getElementById('form-reject-note').value =
        document.getElementById('reject-note-input').value;
    document.getElementById('form-reject-payment').action =
        `/admin/escrow/payments/${_rejectPaymentId}/reject`;
    setSubmitting(btn, 'Rejecting…');
    document.getElementById('form-reject-payment').submit();
}

let _approveWithdrawalId = null;
function openApproveWithdrawalModal(id, name, amount, account) {
    _approveWithdrawalId = id;
    document.getElementById('withdrawal-admin-note').value = '';
    document.getElementById('withdrawal-confirm-check').checked = false;
    hideInlineError('withdrawal-error');
    document.getElementById('withdrawal-detail').innerHTML =
        `Send <strong class="es-detail-accent">${amount}</strong> to <strong>${name}</strong><br>
         Account: <code class="es-code">${account}</code>`;
    openModal('modal-approve-withdrawal');
}
function submitApproveWithdrawal(btn) {
    if (!document.getElementById('withdrawal-confirm-check').checked) {
        showInlineError('withdrawal-error', 'Please confirm you have sent the funds before continuing.');
        return;
    }
    hideInlineError('withdrawal-error');
    document.getElementById('form-approve-note').value =
        document.getElementById('withdrawal-admin-note').value;
    document.getElementById('form-approve-withdrawal').action =
        `/admin/escrow/withdrawals/${_approveWithdrawalId}/approve`;
    setSubmitting(btn, 'Sending…');
    document.getElementById('form-approve-withdrawal').submit();
}

let _rejectWithdrawalId = null;
function openRejectWithdrawalModal(id) {
    _rejectWithdrawalId = id;
    document.getElementById('reject-withdrawal-note').value = '';
    hideInlineError('reject-withdrawal-error');
    openModal('modal-reject-withdrawal');
}
function submitRejectWithdrawal(btn) {
    const note = document.getElementById('reject-withdrawal-note').value.trim();
    if (!note) { showInlineError('reject-withdrawal-error', 'Please provide a reason.'); return; }
    hideInlineError('reject-withdrawal-error');
    document.getElementById('form-reject-wd-note').value = note;
    document.getElementById('form-reject-withdrawal').action =
        `/admin/escrow/withdrawals/${_rejectWithdrawalId}/reject`;
    setSubmitting(btn, 'Rejecting…');
    document.getElementById('form-reject-withdrawal').submit();
}

function openModal(id) {
    document.getElementById(id).classList.add('is-open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('is-open');
    document.body.style.overflow = '';
}
document.querySelectorAll('.es-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.es-overlay.is-open').forEach(m => closeModal(m.id));
        closeLightbox();
    }
});

function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.add('is-open');
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('is-open');
}
</script>
@endpush

@endsection