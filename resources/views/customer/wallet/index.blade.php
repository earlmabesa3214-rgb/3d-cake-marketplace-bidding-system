@extends('layouts.customer')

@section('title', 'My Wallet')

@section('content')
<div class="wallet-page">

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
            <div class="wallet-icon-bg">
                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
        </div>
            <div class="stat-card stat-deposited">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
            </div>
            <div class="stat-lbl">Total Deposited</div>
            <div class="stat-amt">₱{{ number_format($wallet->total_deposited, 2) }}</div>
        </div>
        <div class="stat-card stat-spent">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
            </div>
            <div class="stat-lbl">Total Spent</div>
            <div class="stat-amt">₱{{ number_format($wallet->total_spent, 2) }}</div>
        </div>
    </div>

    {{-- PENDING NOTICE --}}
    @if($pendingCashin)
        <div class="pending-notice">
            <div class="pending-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="pending-text">
                <strong>Cash-in Pending Review</strong>
                <span>₱{{ number_format($pendingCashin->amount, 2) }} — GCash Ref: {{ $pendingCashin->gcash_reference }}</span>
                <span class="pending-sub">Your wallet will be credited once admin verifies your payment proof.</span>
            </div>
        </div>
    @endif

    <div class="wallet-grid {{ $pendingCashin ? 'no-cashin' : '' }}">

        {{-- CASH IN FORM --}}
        @if(!$pendingCashin)
        <div class="card cashin-card">
            <div class="card-head">
          <div class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    Top Up via GCash
                </div>
                <div class="card-desc">Send money to our GCash number, then upload your proof here.</div>
            </div>

         <div class="gcash-info-box">
                <div class="gcash-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                </div>
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
                            <div class="file-drop-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.5;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
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
                <div class="card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Transaction History
                </div>
            </div>

            @if($transactions->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.35;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p>No transactions yet.</p>
                    <span>Your transaction history will appear here.</span>
                </div>
            @else
                <div class="card-body-scroll">
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
                            @php
                                // typeLabel() prepends an emoji glyph (e.g. 🔒 / 💳) — strip any
                                // leading pictographs/symbols so we can render a proper SVG icon
                                // instead, consistent with the rest of the page's icon system.
                                $txnLabel = trim(preg_replace('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}\x{FE0F}]/u', '', $txn->typeLabel()));
                            @endphp
                            <tr>
                                <td>
                                    <div class="txn-type">
                                        <span class="txn-icon {{ $txn->isCredit() ? 'txn-icon-credit' : 'txn-icon-debit' }}">
                                            @if($txn->isCredit())
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                                            @endif
                                        </span>
                                        {{ $txnLabel }}
                                    </div>
                                    <div class="txn-desc">{{ $txn->description ?? '—' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $txn->isCredit() ? 'badge-credit' : 'badge-debit' }}">
                                        {{ $txn->isCredit() ? 'Credit' : 'Payment' }}
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
                </div>
            @endif
        </div>

    </div>
</div>

<style>
/* My Wallet — luxury cake-atelier ledger. Plus Jakarta Sans only. */
.wallet-page{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:1vh auto 4vh;padding:0 clamp(.85rem,2.5vw,2rem) 2rem;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.wallet-page *{box-sizing:border-box;font-family:inherit}
.wallet-page a:focus-visible,.wallet-page button:focus-visible,.wallet-page input:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes wl-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes wl-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@media(prefers-reduced-motion:reduce){
*,*::before,*::after{animation:none!important;transition:none!important}
.page-header,.balance-row>*,.pending-notice,.wallet-grid>.card{opacity:1!important;transform:none!important}}

/* ═══ HEADER ═══ */
.wallet-page .page-header{display:block;position:relative;margin:0 0 2.25rem;padding-bottom:1.75rem;animation:wl-fadeUp .6s var(--e) backwards}
.page-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.page-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:wl-line .9s var(--e) .3s backwards}
.wl-eyebrow{display:block;font-size:.66rem;font-weight:800;letter-spacing:.32em;text-transform:uppercase;color:var(--caramel);margin-bottom:.9rem}
.page-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;color:var(--esp);margin:0}
.page-subtitle{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

.wallet-page .alert{display:flex;align-items:center;gap:.75rem;padding:.95rem 1.2rem;border-radius:0;border:0;border-left:2px solid;font-size:.85rem;font-weight:600;margin-bottom:1.25rem}
.alert-success{background:var(--cream);color:var(--esp);border-left-color:var(--gold)}
.alert-error{background:#F6ECEA;color:var(--burg);border-left-color:var(--burg)}

/* ═══ BALANCE HERO + STATS ═══ */
.balance-row{display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:0;margin-bottom:2.5rem;border:1px solid var(--esp)}
.balance-row>*{animation:wl-fadeUp .6s var(--e) backwards}
.balance-row>*:nth-child(1){animation-delay:.1s}.balance-row>*:nth-child(2){animation-delay:.2s}.balance-row>*:nth-child(3){animation-delay:.3s}
.bal-card{position:relative;overflow:hidden;padding:2rem 2rem 1.9rem;color:var(--ivory);border-radius:0;box-shadow:none;transform:none;
  background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),radial-gradient(ellipse 90% 70% at 100% 0,rgba(184,148,82,.2),transparent 62%),linear-gradient(160deg,#2B1A12,#24150F 60%,#1B0F09)}
.bal-card:hover{transform:none;box-shadow:none}
.bal-card::after{content:"";position:absolute;left:2rem;right:2rem;bottom:0;height:2px;background:linear-gradient(90deg,var(--gold),transparent)}
.bal-card-bg{position:absolute;top:1.25rem;right:1.25rem;width:64px;height:64px;border:1px solid var(--gold-line);border-radius:0;background:none;box-shadow:inset 0 0 0 4px #24150F,inset 0 0 0 5px var(--gold-line)}
.bal-label{position:relative;z-index:1;font-size:.62rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--gold);opacity:1;margin-bottom:1rem}
.bal-amount{position:relative;z-index:1;font-size:clamp(2.6rem,5vw,4.2rem);font-weight:900;line-height:.9;letter-spacing:-.06em;font-variant-numeric:tabular-nums}
.wallet-icon-bg{position:absolute;bottom:1rem;right:1.5rem;opacity:.12;color:var(--gold-l)}
.wallet-icon-bg svg{width:64px;height:64px}
.stat-card{position:relative;display:flex;flex-direction:column;justify-content:flex-end;padding:1.75rem 1.5rem;background:var(--w);border:0;border-left:1px solid var(--line);border-radius:0;transition:background .35s;transform:none}
.stat-card:hover{background:var(--cream);box-shadow:none;transform:none}
.stat-icon{position:absolute;top:1.4rem;right:1.4rem;width:auto;height:auto;margin:0;background:none!important;display:block}
.stat-deposited .stat-icon{color:var(--gold)}.stat-spent .stat-icon{color:var(--burg)}
.stat-lbl{order:-1;font-size:.6rem;font-weight:800;letter-spacing:.26em;text-transform:uppercase;color:var(--taupe);margin-bottom:.7rem}
.stat-amt{font-size:clamp(1.5rem,2.6vw,2.2rem);font-weight:900;letter-spacing:-.05em;line-height:1;font-variant-numeric:tabular-nums}
.stat-deposited .stat-amt{color:var(--credit)}.stat-spent .stat-amt{color:var(--burg)}

/* ═══ PENDING NOTICE ═══ */
.pending-notice{display:flex;align-items:flex-start;gap:1rem;background:var(--cream);border:1px solid var(--gold-line);border-left:2px solid var(--gold);border-radius:0;padding:1.1rem 1.3rem;margin-bottom:2rem;animation:wl-fadeUp .6s var(--e) .35s backwards}
.pending-icon{flex-shrink:0;margin-top:.1rem}
.pending-icon svg{stroke:var(--gold)}
.pending-text{display:flex;flex-direction:column;gap:.25rem;font-size:.85rem;color:var(--mocha)}
.pending-text strong{font-size:.66rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--esp)}
.pending-sub{font-size:.76rem;opacity:.85}

/* ═══ LAYOUT ═══ */
.wallet-grid{display:grid;grid-template-columns:420px minmax(0,1fr);gap:3rem;align-items:start}
.wallet-grid.no-cashin{grid-template-columns:1fr}
@media(max-width:1000px){.wallet-grid{grid-template-columns:1fr;gap:2.5rem}.balance-row{grid-template-columns:1fr 1fr}.bal-card{grid-column:1/-1}.stat-card:nth-child(2){border-left:0}}
@media(max-width:560px){.balance-row{grid-template-columns:1fr}.stat-card{border-left:0;border-top:1px solid var(--line)}}

.wallet-page .card{background:transparent;border:0;border-top:1px solid var(--esp);border-radius:0;overflow:visible;animation:wl-fadeUp .6s var(--e) backwards}
.cashin-card{animation-delay:.4s}.txn-card{animation-delay:.5s}
.wallet-page .card-head{padding:1.25rem 0 1rem;border-bottom:1px solid var(--line)}
.wallet-page .card-title{display:flex;align-items:center;gap:.6rem;font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--esp);margin:0 0 .4rem}
.card-title svg{color:var(--gold)}
.wallet-page .card-desc{font-size:.82rem;line-height:1.6;color:var(--mocha);margin:0}

/* GCash reference plate */
.gcash-info-box{position:relative;margin:1.5rem 0;padding:1.4rem 1rem 1.2rem;text-align:center;background:radial-gradient(circle at 50% 0,rgba(255,255,255,.9),transparent 70%),var(--cream);border:1px solid var(--gold-line);border-radius:0;box-shadow:inset 0 0 0 5px var(--ivory),inset 0 0 0 6px var(--gold-line)}
.gcash-icon{display:grid;place-items:center;width:40px;height:40px;margin:0 auto .7rem;background:var(--esp);border-radius:0;box-shadow:none}
.gcash-icon svg{stroke:var(--gold-l)}
.gcash-number-label{font-size:.56rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--caramel);margin-bottom:.35rem}
.gcash-number{font-size:1.5rem;font-weight:900;letter-spacing:.02em;color:var(--esp);font-variant-numeric:tabular-nums}
.gcash-name{font-size:.7rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--taupe);margin-top:.3rem}

/* form */
.cashin-form{display:flex;flex-direction:column;gap:1.2rem;padding:0}
.wallet-page .form-group{display:flex;flex-direction:column;gap:.45rem}
.wallet-page .form-label{font-size:.6rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--mocha)}
.wallet-page .form-input{width:100%;padding:.85rem 1rem;background:var(--w);border:1px solid var(--beige);border-radius:0;font-size:.9rem;font-weight:500;color:var(--esp);transition:border-color .25s,box-shadow .25s,background .25s}
.form-input::placeholder{color:var(--taupe)}
.form-input:hover{border-color:var(--taupe)}
.wallet-page .form-input:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.2);background:#fff}
.form-input.is-error{border-color:var(--burg)}
.input-prefix-wrap{position:relative}
.input-prefix{position:absolute;left:1rem;top:50%;transform:translateY(-50%);font-weight:800;color:var(--gold);font-size:.9rem;pointer-events:none}
.input-prefix-wrap .form-input{padding-left:2rem}
.wallet-page .field-error{font-size:.74rem;font-weight:700;color:var(--burg)}
.quick-amounts{display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.3rem}
.quick-btn{padding:.45rem .85rem;background:transparent;border:1px solid var(--beige);border-radius:0;font-size:.68rem;font-weight:800;letter-spacing:.08em;color:var(--mocha);cursor:pointer;transition:.3s}
.quick-btn:hover{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}

.file-drop-area{position:relative;display:flex;align-items:center;justify-content:center;min-height:120px;padding:1.25rem;text-align:center;cursor:pointer;background:var(--w);border:1px dashed var(--taupe);border-radius:0;transition:.3s}
.file-drop-area:hover{border-color:var(--gold);background:var(--cream)}
.file-input{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
.file-drop-content{pointer-events:none}
.file-drop-icon{display:flex;justify-content:center;margin-bottom:.4rem;color:var(--gold)}
.file-drop-icon svg{opacity:1!important}
.file-drop-text{font-size:.8rem;font-weight:800;color:var(--esp)}
.file-drop-sub{font-size:.68rem;color:var(--taupe);margin-top:.2rem}
.file-preview{max-height:130px;width:100%;object-fit:contain;border-radius:0}

.btn-submit{width:100%;padding:1.05rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);border-radius:0;font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:background .3s,color .3s,transform .3s var(--e),box-shadow .3s}
.btn-submit:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);box-shadow:0 16px 34px rgba(184,148,82,.4);opacity:1}
.btn-submit:active{transform:translateY(0)}

/* ═══ TRANSACTION LEDGER ═══ */
.txn-card .card-body-scroll{max-height:560px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:var(--gold-line) transparent}
.txn-table{width:100%;border-collapse:collapse;table-layout:fixed}
.txn-table th{padding:.9rem .75rem;text-align:left;font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);background:transparent;border-bottom:1px solid var(--esp);position:sticky;top:0;z-index:1;background:var(--ivory)}
.txn-table th:first-child,.txn-table td:first-child{padding-left:0}
.txn-table th:last-child,.txn-table td:last-child{padding-right:0}
.txn-table td{padding:1.05rem .75rem;font-size:.82rem;border-bottom:1px solid var(--line);color:var(--esp);vertical-align:middle}
.txn-table tr:last-child td{border-bottom:0}
.txn-table tbody tr{transition:background .3s}
.txn-table tbody tr:hover td{background:rgba(239,230,215,.5)}
.txn-type{display:flex;align-items:center;gap:.6rem;font-weight:800;font-size:.85rem;letter-spacing:-.01em}
.txn-icon{display:inline-grid;place-items:center;width:26px;height:26px;border:1px solid;border-radius:0;flex-shrink:0;background:none}
.txn-icon-credit{color:var(--gold);border-color:var(--gold-line)}
.txn-icon-debit{color:var(--burg);border-color:rgba(84,37,44,.3)}
.txn-desc{font-size:.72rem;color:var(--taupe);margin-top:.15rem;padding-left:calc(26px + .6rem);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.txn-date-main{font-size:.8rem;font-weight:700}
.txn-date-sub{font-size:.68rem;color:var(--taupe);margin-top:.1rem}
.amount-green,.amount-red{font-size:.95rem;font-weight:900;letter-spacing:-.03em;text-align:right;font-variant-numeric:tabular-nums}
.amount-green{color:var(--credit)}.amount-red{color:var(--burg)}
.wallet-page .badge{display:inline-flex;align-items:center;padding:.3rem .6rem;border-radius:0;border:1px solid transparent;border-left-width:2px;font-size:.56rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;white-space:nowrap}
.badge-credit{background:#F3EAD3;color:#7A5A15;border-color:var(--gold-line);border-left-color:var(--gold)}
.badge-debit{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}

.txn-pagination{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;padding:1rem 0;border-top:1px solid var(--esp)}
.pagination-info{font-size:.6rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe)}
.pagination{display:flex;gap:.25rem;list-style:none;margin:0;padding:0}
.pagination li span,.pagination li a{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 .5rem;border:1px solid transparent;border-radius:0;font-size:.78rem;font-weight:800;text-decoration:none;color:var(--mocha);background:transparent;transition:.3s}
.pagination li a:hover{border-color:var(--gold);color:var(--esp);background:transparent}
.pagination li.active span{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.pagination li.disabled span{opacity:.35}

.wallet-page .empty-state{text-align:center;padding:3.5rem 1rem;color:var(--taupe);border-bottom:1px solid var(--line)}
.empty-icon{display:flex;justify-content:center;margin-bottom:.9rem;color:var(--gold)}
.empty-icon svg{opacity:.7!important}
.empty-state p{font-size:1.05rem;font-weight:900;letter-spacing:-.03em;color:var(--esp);margin:0 0 .3rem}
.empty-state span{font-size:.8rem;color:var(--mocha)}
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