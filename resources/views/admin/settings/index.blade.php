@extends('layouts.admin')
@section('title', 'Settings')

@push('styles')
<style>
* { font-family: 'Plus Jakarta Sans', sans-serif !important; }
.info-val, .fi-pre-tag, .fi-pre input { font-family: 'DM Mono', monospace !important; }

:root{
    --gold:#C07828;--gold-dark:#9A5E14;--gold-light:#DC9E48;--gold-soft:#FEF3E2;
    --gold-glow:rgba(192,120,40,.16);--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;
    --rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;
    --t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--bg:#F5F0E8;
    --s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;
    --r:10px;--rl:14px;--rxl:18px;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}

.pg{ padding:0 0 5rem; }

/* HERO */
.set-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem;position:relative;overflow:hidden;}
.set-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.set-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.set-hero-inner{position:relative;z-index:1;}
.set-hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.set-hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.set-hero-title{font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.set-hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.set-hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}

/* LAYOUT */
.set-layout{display:grid;grid-template-columns:210px 1fr;gap:1.5rem;padding:1.5rem 2rem 0;align-items:start;}

/* SIDEBAR NAV */
.set-nav{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);overflow:hidden;position:sticky;top:1rem;animation:fadeUp .4s ease both;}
.set-nav-header{padding:.875rem 1.125rem;border-bottom:1px solid var(--bdr);background:var(--s2);}
.set-nav-header-lbl{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--tm);}
.set-nav-list{padding:.375rem;}
.set-nav-item{display:flex;align-items:center;gap:.55rem;padding:.625rem .75rem;border-radius:var(--r);font-size:.8rem;font-weight:600;color:var(--t2);text-decoration:none;cursor:pointer;transition:all .15s;border:none;background:none;width:100%;text-align:left;}
.set-nav-item:hover{background:var(--s3);color:var(--t1);}
.set-nav-item.active{background:var(--gold-soft);color:var(--gold-dark);border:1px solid rgba(192,120,40,.2);}
.set-nav-item svg{flex-shrink:0;opacity:.7;}
.set-nav-item.active svg{opacity:1;}
.set-nav-divider{height:1px;background:var(--bdr);margin:.375rem .75rem;}

/* PANELS */
.set-panel{display:none;flex-direction:column;gap:1.125rem;animation:fadeUp .35s ease both;}
.set-panel.active{display:flex;}

/* CARD */
.set-card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);overflow:hidden;box-shadow:0 2px 8px rgba(100,60,20,.04);}
.set-card-head{display:flex;align-items:center;gap:.625rem;padding:1rem 1.375rem;border-bottom:1px solid var(--bdr);background:var(--s2);}
.set-card-ic{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ic-gold{background:var(--gold-soft);color:var(--gold);}
.ic-teal{background:var(--teal-soft);color:var(--teal);}
.ic-rose{background:var(--rose-soft);color:var(--rose);}
.ic-copper{background:#FDEEE4;color:var(--copper);}
.set-card-title{font-size:.875rem;font-weight:700;color:var(--t2);}
.set-card-sub{font-size:.7rem;color:var(--tm);margin-top:.1rem;}
.set-card-body{padding:1.25rem 1.375rem;}
.set-card-footer{display:flex;justify-content:flex-end;padding:.875rem 1.375rem;border-top:1px solid var(--bdr);background:var(--s2);}

/* FORM */
.fg{margin-bottom:1rem;}
.fg:last-child{margin-bottom:0;}
.fg label{display:block;font-size:.68rem;font-weight:700;color:var(--t2);margin-bottom:.4rem;letter-spacing:.07em;text-transform:uppercase;}
.fg .hint{font-size:.67rem;color:var(--tm);margin-top:.3rem;}
.fi-pre{display:flex;align-items:center;border:1.5px solid var(--bdr-md);border-radius:var(--r);background:var(--s2);overflow:hidden;transition:border-color .2s,box-shadow .2s;}
.fi-pre:focus-within{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-glow);}
.fi-pre-tag{padding:0 .875rem;font-size:.78rem;font-weight:600;color:var(--tm);background:var(--s3);height:42px;display:flex;align-items:center;border-right:1.5px solid var(--bdr-md);white-space:nowrap;}
.fi-pre input{border:none;outline:none;background:transparent;height:42px;padding:0 .875rem;font-size:.875rem;color:var(--t1);flex:1;width:100%;}
.fgrid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.fselect{width:100%;height:42px;padding:0 1rem;font-size:.875rem;color:var(--t1);background:var(--s2);border:1.5px solid var(--bdr-md);border-radius:var(--r);outline:none;cursor:pointer;transition:border-color .2s;}
.fselect:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-glow);}

/* TOGGLE */
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:.875rem 1rem;background:var(--s2);border:1.5px solid var(--bdr);border-radius:var(--r);margin-bottom:.625rem;transition:all .2s;}
.toggle-row:has(input:checked){border-color:rgba(31,122,108,.3);background:var(--teal-soft);}
.toggle-row:last-child{margin-bottom:0;}
.toggle-info{flex:1;}
.toggle-lbl{font-size:.825rem;font-weight:600;color:var(--t1);}
.toggle-hint{font-size:.68rem;color:var(--tm);margin-top:.15rem;}
.tswitch{position:relative;width:42px;height:23px;flex-shrink:0;margin-left:1rem;}
.tswitch input{opacity:0;width:0;height:0;position:absolute;}
.ttrack{position:absolute;inset:0;background:var(--bdr-md);border-radius:12px;cursor:pointer;transition:all .25s;}
.ttrack::after{content:'';position:absolute;left:3px;top:3px;width:15px;height:15px;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(40,20,0,.2);transition:all .25s cubic-bezier(.34,1.4,.64,1);}
.tswitch input:checked+.ttrack{background:var(--teal);}
.tswitch input:checked+.ttrack::after{transform:translateX(19px);}

/* INFO ROW */
.info-row{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;border-bottom:1px solid var(--bdr);font-size:.82rem;}
.info-row:last-child{border-bottom:none;}
.info-key{color:var(--tm);font-weight:500;}
.info-val{font-weight:600;color:var(--t1);font-size:.78rem;}

/* STATUS BADGE */
.status-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .65rem;border-radius:20px;font-size:.65rem;font-weight:700;}
.badge-active{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.25);}
.badge-warn{background:#FEF9E7;color:#9C7010;border:1px solid #EDD880;}

/* SAVE BTN */
.btn-save{display:inline-flex;align-items:center;gap:.45rem;height:38px;padding:0 1.375rem;font-size:.8rem;font-weight:700;color:#fff;background:linear-gradient(135deg,var(--gold-light),var(--gold));border:none;border-radius:var(--r);cursor:pointer;box-shadow:0 3px 12px var(--gold-glow);transition:transform .15s,box-shadow .15s;position:relative;overflow:hidden;}
.btn-save::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.15),transparent 55%);}
.btn-save:hover{transform:translateY(-1px);box-shadow:0 6px 18px var(--gold-glow);}

@media(max-width:900px){
    .set-layout{grid-template-columns:1fr;}
    .set-nav{position:static;}
    .set-nav-list{display:flex;flex-wrap:wrap;padding:.5rem;gap:.25rem;}
    .set-nav-item{width:auto;}
    .set-nav-divider{display:none;}
    .fgrid{grid-template-columns:1fr;}
    .set-layout{padding:1rem;}
}
</style>
@endpush

@section('content')
<div class="pg">

    {{-- HERO --}}
    <div class="set-hero">
        <div class="set-hero-inner">
            <div class="set-hero-pill"><span class="set-hero-dot"></span> Admin Panel</div>
            <div class="set-hero-title"><em>System</em> Settings</div>
            <div class="set-hero-sub">Configure your BakeSphere platform rules and transaction flow</div>
        </div>
    </div>

    @if(session('success'))
    <div style="margin:1rem 2rem 0;display:flex;align-items:center;gap:.75rem;background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.28);border-radius:var(--r);padding:.8rem 1.125rem;font-size:.85rem;color:var(--teal);" id="sa">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
        <button style="margin-left:auto;background:none;border:none;color:var(--teal);cursor:pointer;font-size:1.1rem;opacity:.6;" onclick="document.getElementById('sa').remove()">×</button>
    </div>
    @endif

    <div class="set-layout">

        {{-- SIDEBAR --}}
        <nav class="set-nav">
            <div class="set-nav-header"><div class="set-nav-header-lbl">Settings Menu</div></div>
            <div class="set-nav-list">
                <button class="set-nav-item active" onclick="switchTab('orders',this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                    Order Rules
                </button>
                <button class="set-nav-item" onclick="switchTab('payment',this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Payment
                </button>
                <button class="set-nav-item" onclick="switchTab('topup',this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Wallet & Top-up
                </button>
                <div class="set-nav-divider"></div>
                <button class="set-nav-item" onclick="switchTab('accounts',this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Accounts
                </button>
                <button class="set-nav-item" onclick="switchTab('system',this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M2 12h2M20 12h2M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41"/></svg>
                    System Info
                </button>
            </div>
        </nav>

        {{-- PANELS --}}
        <div>

            {{-- ===== ORDER RULES ===== --}}
            <div id="tab-orders" class="set-panel active">

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-gold">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Cake Request Rules</div>
                            <div class="set-card-sub">Controls for how customers submit cake requests</div>
                        </div>
                    </div>
                    <div class="set-card-body">
                        <div class="fgrid">
                            <div class="fg">
                                <label>Minimum Advance Days Required</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">days</span>
                                    <input type="number" name="min_advance_days" value="3" min="1">
                                </div>
                                <div class="hint">Customers must place orders at least this many days before delivery date</div>
                            </div>
                            <div class="fg">
                                <label>Minimum Order Amount</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">₱</span>
                                    <input type="number" name="min_order_amount" value="500" min="0" step="50">
                                </div>
                                <div class="hint">Cake requests below this price will not be accepted</div>
                            </div>
                        </div>
                    </div>
                    <div class="set-card-footer">
                        <button class="btn-save" onclick="saved(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-teal">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Bidding Rules</div>
                            <div class="set-card-sub">Controls for baker bidding on cake requests</div>
                        </div>
                    </div>
                    <div class="set-card-body">
                        <div class="fgrid">
                            <div class="fg">
                                <label>Bidding Window Duration</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">hours</span>
                                    <input type="number" name="bidding_window_hours" value="48" min="1">
                                </div>
                                <div class="hint">How long bakers can submit bids after a request is posted</div>
                            </div>
                            <div class="fg">
                                <label>Max Bids per Request</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">bakers</span>
                                    <input type="number" name="max_bids_per_request" value="10" min="1">
                                </div>
                                <div class="hint">Maximum number of bakers that can bid on one cake request</div>
                            </div>
                        </div>
                        <div class="fgrid" style="margin-top:1rem;">
                            <div class="fg">
                                <label>Max Active Orders per Baker</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">orders</span>
                                    <input type="number" name="max_active_orders" value="5" min="1" max="50">
                                </div>
                                <div class="hint">Bakers won't receive new bids once this limit is reached</div>
                            </div>
                            <div class="fg">
                                <label>Rush Order Fee</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">%</span>
                                    <input type="number" name="rush_order_fee_percent" value="20" min="0" max="100">
                                </div>
                                <div class="hint">Extra percentage added to the agreed price for rush orders</div>
                            </div>
                        </div>
                    </div>
                    <div class="set-card-footer">
                        <button class="btn-save" onclick="saved(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>

            {{-- ===== PAYMENT ===== --}}
            <div id="tab-payment" class="set-panel">

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-teal">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Downpayment Structure</div>
                            <div class="set-card-sub">Configure how the two-stage payment split works</div>
                        </div>
                    </div>
                    <div class="set-card-body">
                        <div class="fgrid">
                            <div class="fg">
                                <label>Downpayment Percentage</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">%</span>
                                    <input type="number" name="downpayment_percent" value="50" min="1" max="99">
                                </div>
                                <div class="hint">Percentage of agreed price collected before baker starts preparing. Remaining balance is collected before delivery/pickup.</div>
                            </div>
                            <div class="fg">
                                <label>Escrow Release Delay After Confirmation</label>
                                <div class="fi-pre">
                                    <span class="fi-pre-tag">hours</span>
                                    <input type="number" name="escrow_release_delay_hours" value="0" min="0" max="72">
                                </div>
                                <div class="hint">Hours to wait after customer confirms delivery before releasing funds to baker. Set 0 for instant release.</div>
                            </div>
                        </div>
                    </div>
                    <div class="set-card-footer">
                        <button class="btn-save" onclick="saved(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-gold">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Accepted Payment Methods</div>
                            <div class="set-card-sub">Which channels customers can use to pay bakers</div>
                        </div>
                    </div>
                    <div class="set-card-body">
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">GCash</div>
                                <div class="toggle-hint">Allow GCash transfers as payment proof</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="pay_gcash" checked><span class="ttrack"></span></label>
                        </div>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">Maya (PayMaya)</div>
                                <div class="toggle-hint">Allow Maya wallet transfers</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="pay_maya" checked><span class="ttrack"></span></label>
                        </div>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">Bank Transfer</div>
                                <div class="toggle-hint">Allow direct bank deposits with proof of transfer</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="pay_bank"><span class="ttrack"></span></label>
                        </div>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">Cash on Delivery / Pickup</div>
                                <div class="toggle-hint">Allow cash payment upon cake delivery or pickup</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="pay_cod"><span class="ttrack"></span></label>
                        </div>
                    </div>
                    <div class="set-card-footer">
                        <button class="btn-save" onclick="saved(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>

            {{-- ===== WALLET & TOP-UP ===== --}}
            <div id="tab-topup" class="set-panel">

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-copper">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Top-up Receipt Review</div>
                            <div class="set-card-sub">Controls for how customer wallet top-up requests are handled</div>
                        </div>
                    </div>
                    <div class="set-card-body">
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">Manual Admin Approval Required</div>
                                <div class="toggle-hint">Admin must manually review and approve each top-up receipt before funds are credited to the customer's wallet</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="manual_topup_approval" checked><span class="ttrack"></span></label>
                        </div>
                        <div class="fg" style="margin-top:1rem;">
                            <label>Minimum Top-up Amount</label>
                            <div class="fi-pre">
                                <span class="fi-pre-tag">₱</span>
                                <input type="number" name="min_topup_amount" value="100" min="50" step="50">
                            </div>
                            <div class="hint">Minimum single top-up transaction allowed</div>
                        </div>
                        <div class="fg">
                            <label>Maximum Top-up Amount per Transaction</label>
                            <div class="fi-pre">
                                <span class="fi-pre-tag">₱</span>
                                <input type="number" name="max_topup_amount" value="10000" min="100" step="100">
                            </div>
                            <div class="hint">Cap on a single top-up transaction to prevent fraud</div>
                        </div>
                    </div>
                    <div class="set-card-footer">
                        <button class="btn-save" onclick="saved(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>

            {{-- ===== ACCOUNTS ===== --}}
            <div id="tab-accounts" class="set-panel">

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-copper">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Registration Controls</div>
                            <div class="set-card-sub">Open or close the platform to new users</div>
                        </div>
                    </div>
                    <div class="set-card-body">
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">Allow New Customer Registrations</div>
                                <div class="toggle-hint">Disable to temporarily stop new customer sign-ups</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="allow_customer_register" checked><span class="ttrack"></span></label>
                        </div>
                        <div class="toggle-row">
                            <div class="toggle-info">
                                <div class="toggle-lbl">Allow New Baker Registrations</div>
                                <div class="toggle-hint">Disable to close baker applications platform-wide</div>
                            </div>
                            <label class="tswitch"><input type="checkbox" name="allow_baker_register" checked><span class="ttrack"></span></label>
                        </div>
                    </div>
                    <div class="set-card-footer">
                        <button class="btn-save" onclick="saved(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>

            {{-- ===== SYSTEM INFO ===== --}}
            <div id="tab-system" class="set-panel">

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-teal">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">System Information</div>
                            <div class="set-card-sub">Current platform environment details</div>
                        </div>
                    </div>
                    <div>
                        <div class="info-row">
                            <span class="info-key">Application Name</span>
                            <span class="info-val">{{ config('app.name') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Laravel Version</span>
                            <span class="info-val">{{ app()->version() }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">PHP Version</span>
                            <span class="info-val">{{ phpversion() }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Environment</span>
                            <span class="info-val">
                                <span class="status-badge {{ app()->environment('production') ? 'badge-active' : 'badge-warn' }}">
                                    {{ strtoupper(app()->environment()) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Debug Mode</span>
                            <span class="info-val">
                                <span class="status-badge {{ config('app.debug') ? 'badge-warn' : 'badge-active' }}">
                                    {{ config('app.debug') ? 'ON' : 'OFF' }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Timezone</span>
                            <span class="info-val">{{ config('app.timezone') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Server Time</span>
                            <span class="info-val">{{ now()->format('D, M j Y · H:i:s') }}</span>
                        </div>
                    </div>
                </div>

                <div class="set-card">
                    <div class="set-card-head">
                        <div class="set-card-ic ic-gold">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                        <div>
                            <div class="set-card-title">Platform Stats</div>
                            <div class="set-card-sub">Live counts from the database</div>
                        </div>
                    </div>
                    <div>
                        <div class="info-row">
                            <span class="info-key">Total Cake Requests</span>
                            <span class="info-val">{{ \App\Models\CakeRequest::count() }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Total Bakers</span>
                            <span class="info-val">{{ \App\Models\Baker::count() }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Total Customers</span>
                            <span class="info-val">{{ \App\Models\User::where('role','customer')->count() }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Completed Orders</span>
                            <span class="info-val">{{ \App\Models\BakerOrder::where('status','COMPLETED')->count() }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Total Revenue (Completed)</span>
                            <span class="info-val">₱{{ number_format(\App\Models\BakerOrder::where('status','COMPLETED')->sum('agreed_price'), 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>{{-- end main --}}
    </div>{{-- end layout --}}
</div>

@push('scripts')
<script>
function switchTab(name, btn) {
    document.querySelectorAll('.set-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.set-nav-item').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
function saved(btn) {
    const orig = btn.innerHTML;
    btn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Saved!';
    btn.style.background = 'linear-gradient(135deg,var(--teal),#2A9D8A)';
    setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; }, 2000);
}
</script>
@endpush
@endsection