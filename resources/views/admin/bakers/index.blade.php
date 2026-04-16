@extends('layouts.admin')
@section('title', 'Bakers')
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
:root{--gold:#C07828;--gold-dark:#9A5E14;--gold-light:#DC9E48;--gold-soft:#FEF3E2;--gold-glow:rgba(192,120,40,.16);--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;--rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;--t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--bg:#F5F0E8;--s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;--r:10px;--rl:14px;--rxl:18px;}
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes slideUp{from{opacity:0;transform:translateY(18px) scale(.97)}to{opacity:1;transform:none}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}
*,*::before,*::after{box-sizing:border-box;}

.pg{
    width:100%;
    padding:0 0 5rem;
    font-family:'Plus Jakarta Sans',sans-serif;
}

/* ── HERO BANNER ── */
.bakers-hero{
    background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 55%,#5C2C10 100%);
    padding:2rem 2.5rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:1.5rem;
    position:relative;
    overflow:hidden;
    animation:fadeUp .4s ease both;
}
.bakers-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:24px 24px;}
.bakers-hero::after{content:'';position:absolute;right:-60px;top:-60px;width:280px;height:280px;background:radial-gradient(circle,rgba(192,120,40,.14),transparent 65%);border-radius:50%;}
.hero-left{position:relative;z-index:1;}
.hero-eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.13);border-radius:20px;padding:.22rem .75rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:.75rem;font-family:'Plus Jakarta Sans',sans-serif;}
.hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.35rem;}
.hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero-sub{font-size:.8rem;color:rgba(255,255,255,.4);font-family:'Plus Jakarta Sans',sans-serif;}
.hero-stats{display:flex;gap:.75rem;position:relative;z-index:1;flex-wrap:wrap;}
.hero-stat{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.11);border-radius:var(--rl);padding:.875rem 1.25rem;text-align:center;min-width:90px;}
.hero-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.625rem;font-weight:800;color:#fff;line-height:1;}
.hero-stat-lbl{font-size:.58rem;color:rgba(255,255,255,.38);margin-top:.28rem;text-transform:uppercase;letter-spacing:.1em;font-family:'Plus Jakarta Sans',sans-serif;}

/* ── TOOLBAR ── */
.toolbar{display:flex;align-items:center;justify-content:space-between;padding:1.375rem 2rem;gap:1rem;flex-wrap:wrap;border-bottom:1.5px solid var(--bdr);background:var(--s2);}
.toolbar-left{display:flex;align-items:center;gap:.625rem;flex:1;min-width:0;}
.tsearch{display:flex;align-items:center;gap:.4rem;background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--r);padding:0 .875rem;height:36px;transition:border-color .18s,box-shadow .18s;min-width:220px;}
.tsearch:focus-within{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-glow);}
.tsearch input{border:none;background:none;outline:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:.78rem;color:var(--t1);width:190px;}
.tsearch input::placeholder{color:var(--tm);}

/* ── TABLE CARD ── */
.table-card{
    margin:1.5rem 2rem 0;
    background:var(--s);
    border:1.5px solid var(--bdr);
    border-radius:var(--rxl);
    overflow:hidden;
    box-shadow:0 3px 16px rgba(120,80,30,.07);
    animation:fadeUp .45s ease .08s both;
}
.table-topbar{display:flex;align-items:center;justify-content:space-between;padding:.9375rem 1.5rem;border-bottom:1.5px solid var(--bdr);background:var(--s2);gap:1rem;flex-wrap:wrap;}
.table-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.8125rem;font-weight:700;color:var(--t2);display:flex;align-items:center;gap:.4rem;}
.title-dot{width:6px;height:6px;border-radius:50%;background:var(--gold);box-shadow:0 0 5px rgba(192,120,40,.3);animation:pulse 2.5s infinite;}
.table-count{font-size:.7rem;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.2);border-radius:20px;padding:.15rem .6rem;color:var(--gold-dark);font-weight:600;font-family:'DM Mono',monospace;}

/* Section headers */
.section-block{border-top:1.5px solid var(--bdr);}
.section-block:first-child{border-top:none;}
.section-label{display:flex;align-items:center;gap:.5rem;padding:.9rem 1.5rem .5rem;}
.section-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.dot-pending{background:#C4A010;}
.dot-approved{background:var(--teal);}
.dot-rejected{background:var(--rose);}
.section-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;font-family:'Plus Jakarta Sans',sans-serif;}
.pending-title{color:#9C7010;}
.approved-title{color:var(--teal);}
.rejected-title{color:var(--rose);}
.section-count{font-size:.68rem;border-radius:10px;padding:.1rem .45rem;font-weight:700;font-family:'DM Mono',monospace;}
.count-pending{background:#FEF9E7;border:1px solid #EDD880;color:#9C7010;}
.count-approved{background:var(--teal-soft);border:1px solid rgba(31,122,108,.28);color:var(--teal);}
.count-rejected{background:var(--rose-soft);border:1px solid rgba(180,56,64,.22);color:var(--rose);}

/* Baker cards grid */
.bakers-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:.875rem;padding:.5rem 1.5rem 1.375rem;}
.baker-card{background:var(--s2);border:1.5px solid var(--bdr);border-radius:var(--rl);padding:1.125rem;transition:border-color .18s,box-shadow .18s,transform .18s;}
.baker-card:hover{border-color:rgba(192,120,40,.28);box-shadow:0 5px 20px var(--gold-glow);transform:translateY(-2px);}
.baker-top{display:flex;align-items:flex-start;gap:.75rem;margin-bottom:.875rem;}
.baker-ava{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;}
.baker-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:700;color:var(--t1);line-height:1.2;}
.baker-email{font-size:.73rem;color:var(--tm);margin-top:2px;font-family:'Plus Jakarta Sans',sans-serif;}
.type-tag{display:inline-flex;align-items:center;gap:.2rem;margin-top:4px;padding:.12rem .48rem;border-radius:5px;font-size:.6rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
.type-homebased{background:#FEF9E7;border:1px solid #EDD880;color:#8A6010;}
.type-registered{background:var(--teal-soft);border:1px solid rgba(31,122,108,.28);color:var(--teal);}
.status-pill{display:inline-flex;align-items:center;gap:.28rem;padding:.2rem .6rem;border-radius:20px;font-size:.64rem;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0;margin-top:2px;}
.status-pill::before{content:'';width:4px;height:4px;border-radius:50%;flex-shrink:0;}
.status-pending{background:#FEF9E7;border:1.5px solid #EDD880;color:#9C7010;}.status-pending::before{background:#C4A010;}
.status-approved{background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.28);color:var(--teal);}.status-approved::before{background:var(--teal);animation:pulse 2.5s infinite;}
.status-rejected{background:var(--rose-soft);border:1.5px solid rgba(180,56,64,.22);color:var(--rose);}.status-rejected::before{background:var(--rose);}
.baker-meta{font-size:.755rem;color:var(--tm);margin-bottom:.75rem;display:flex;flex-wrap:wrap;gap:.125rem;font-family:'Plus Jakarta Sans',sans-serif;}
.baker-meta span{display:inline-flex;align-items:center;gap:.28rem;margin-right:.75rem;}
.baker-actions{display:flex;gap:.4rem;flex-wrap:wrap;align-items:center;}
.btn-sm{display:inline-flex;align-items:center;gap:.22rem;height:28px;padding:0 .7rem;font-family:'Plus Jakarta Sans',sans-serif;font-size:.7rem;font-weight:600;border-radius:7px;border:1.5px solid;cursor:pointer;transition:all .15s;background:transparent;white-space:nowrap;text-decoration:none;}
.btn-approve{color:var(--teal);border-color:rgba(31,122,108,.28);background:var(--teal-soft);}
.btn-approve:hover{background:var(--teal);border-color:var(--teal);color:#fff;}
.btn-reject{color:var(--rose);border-color:rgba(180,56,64,.2);background:var(--rose-soft);}
.btn-reject:hover{background:var(--rose);border-color:var(--rose);color:#fff;}
.btn-view{color:var(--gold-dark);border-color:rgba(192,120,40,.28);background:var(--gold-soft);}
.btn-view:hover{background:var(--gold);border-color:var(--gold);color:#fff;}
.btn-del{color:var(--rose);border-color:rgba(180,56,64,.2);background:var(--rose-soft);}
.btn-del:hover{background:var(--rose);border-color:var(--rose);color:#fff;}

.table-foot{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.5rem;border-top:1px solid var(--bdr);background:var(--s2);font-size:.75rem;color:var(--tm);font-family:'Plus Jakarta Sans',sans-serif;}
.empty-state{text-align:center;padding:3.5rem 2rem;}
.empty-orb{width:54px;height:54px;border-radius:16px;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.18);display:inline-flex;align-items:center;justify-content:center;margin-bottom:.875rem;color:var(--gold);}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:700;color:var(--t1);margin-bottom:.28rem;}
.empty-sub{font-size:.78rem;color:var(--tm);font-family:'Plus Jakarta Sans',sans-serif;}

/* Modals */
.modal-backdrop{position:fixed;inset:0;background:rgba(28,12,2,.46);backdrop-filter:blur(5px);z-index:1040;display:none;}
.modal-backdrop.show{display:block;animation:fadeIn .2s ease;}
.modal-wrap{position:fixed;inset:0;z-index:1050;display:none;align-items:center;justify-content:center;padding:1rem;}
.modal-wrap.show{display:flex;}
.modal-box{background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--rxl);width:100%;max-width:500px;box-shadow:0 20px 56px rgba(50,20,4,.18);overflow:hidden;position:relative;}
.modal-box.show{animation:slideUp .25s cubic-bezier(.34,1.1,.64,1) both;}
.modal-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--copper),var(--gold-light));}
.m-head{display:flex;align-items:center;justify-content:space-between;padding:1.375rem 1.375rem 0;}
.m-head-left{display:flex;align-items:center;gap:.75rem;}
.m-icon{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--gold),var(--copper));display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;}
.m-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1rem;font-weight:700;color:var(--espresso);letter-spacing:-.02em;}
.m-sub{font-size:.72rem;color:var(--tm);margin-top:2px;font-family:'Plus Jakarta Sans',sans-serif;}
.m-close{background:var(--s2);border:1.5px solid var(--bdr);color:var(--tm);cursor:pointer;width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .15s;line-height:1;}
.m-close:hover{color:var(--rose);background:var(--rose-soft);}
.m-body{padding:1.25rem 1.375rem;display:flex;flex-direction:column;gap:.875rem;}
.m-footer{padding:.875rem 1.375rem 1.375rem;display:flex;justify-content:flex-end;gap:.625rem;}
.m-divider{height:1px;background:var(--bdr);margin:0 1.375rem;}
.fg label{display:block;font-size:.68rem;font-weight:600;color:var(--t2);letter-spacing:.06em;text-transform:uppercase;margin-bottom:.375rem;font-family:'Plus Jakarta Sans',sans-serif;}
.fi,.fs{width:100%;height:40px;padding:0 .875rem;font-family:'Plus Jakarta Sans',sans-serif;font-size:.84rem;color:var(--t1);background:var(--s2);border:1.5px solid var(--bdr-md);border-radius:var(--r);outline:none;transition:border-color .18s,box-shadow .18s;}
.fi::placeholder{color:var(--tm);}
.fi:focus,.fs:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-glow);background:#fff;}
.fs{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23C07828' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .875rem center;background-color:var(--s2);padding-right:2.25rem;cursor:pointer;}
.fgrid{display:grid;grid-template-columns:1fr 1fr;gap:.875rem;}
.btn-cancel{height:36px;padding:0 1rem;font-family:'Plus Jakarta Sans',sans-serif;font-size:.78rem;font-weight:600;color:var(--tm);background:var(--s2);border:1.5px solid var(--bdr-md);border-radius:var(--r);cursor:pointer;transition:all .15s;}
.btn-cancel:hover{color:var(--t2);background:var(--gold-soft);}
.btn-submit{height:36px;padding:0 1.25rem;font-family:'Plus Jakarta Sans',sans-serif;font-size:.8rem;font-weight:600;color:#fff;background:linear-gradient(135deg,var(--gold),var(--copper));border:none;border-radius:var(--r);cursor:pointer;box-shadow:0 2px 10px var(--gold-glow);transition:all .18s;}
.btn-submit:hover{transform:translateY(-1px);}
.del-box{background:var(--s);border:1.5px solid var(--bdr-md);border-radius:var(--rxl);width:100%;max-width:330px;box-shadow:0 20px 56px rgba(50,20,4,.18);overflow:hidden;position:relative;}
.del-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--rose),#D05060);}
.del-box.show{animation:slideUp .22s cubic-bezier(.34,1.1,.64,1) both;}
.del-body{padding:1.625rem 1.375rem;text-align:center;}
.del-icon{width:48px;height:48px;border-radius:13px;background:var(--rose-soft);border:1.5px solid rgba(180,56,64,.2);display:inline-flex;align-items:center;justify-content:center;color:var(--rose);margin-bottom:.75rem;}
.del-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9375rem;font-weight:700;color:var(--espresso);margin-bottom:.3rem;}
.del-desc{font-size:.78rem;color:var(--tm);line-height:1.55;font-family:'Plus Jakarta Sans',sans-serif;}
.del-footer{display:flex;gap:.5rem;padding:0 1.375rem 1.375rem;}
.del-footer .btn-cancel{flex:1;display:flex;align-items:center;justify-content:center;}
.btn-confirm-del{flex:1;height:36px;font-family:'Plus Jakarta Sans',sans-serif;font-size:.78rem;font-weight:600;color:#fff;background:linear-gradient(135deg,var(--rose),#943040);border:none;border-radius:var(--r);cursor:pointer;transition:all .18s;}
.btn-confirm-del:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(180,56,64,.28);}
.toast-wrap{position:fixed;bottom:1.5rem;right:1.5rem;z-index:2000;display:flex;flex-direction:column;gap:.5rem;pointer-events:none;}
.toast{display:flex;align-items:center;gap:.625rem;padding:.75rem 1rem;background:var(--espresso);color:#FDF8F3;border-radius:var(--rl);font-size:.79rem;font-weight:500;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 6px 22px rgba(28,10,0,.22);pointer-events:all;animation:toastIn .25s ease;min-width:230px;}
.toast.success{border-left:3px solid var(--teal);}.toast.error{border-left:3px solid var(--rose);}
@keyframes toastIn{from{opacity:0;transform:translateX(12px)}to{opacity:1;transform:none}}
@keyframes toastOut{to{opacity:0;transform:translateX(12px)}}
.alert{display:flex;align-items:center;gap:.75rem;background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.25);border-radius:var(--r);padding:.8125rem 2.5rem;font-size:.8125rem;color:var(--teal);margin:1rem 2rem 0;font-family:'Plus Jakarta Sans',sans-serif;}
.alert-close{margin-left:auto;background:none;border:none;color:var(--teal);cursor:pointer;font-size:1.1rem;opacity:.55;transition:opacity .15s;padding:0;}
.alert-close:hover{opacity:1;}
@media(max-width:768px){.bakers-grid{grid-template-columns:1fr;}.fgrid{grid-template-columns:1fr;}.table-card{margin:1rem;}.toolbar{padding:1rem;}.bakers-hero{flex-direction:column;padding:1.5rem;}.hero-stats{width:100%;justify-content:flex-start;}}
</style>

<div class="pg">

    {{-- HERO BANNER --}}
    <div class="bakers-hero">
        <div class="hero-left">
            <div class="hero-eyebrow"><span class="hero-dot"></span> Personnel Management</div>
            <div class="hero-title"><em>Baker</em> Registry</div>
            <div class="hero-sub">Review applications, manage baker profiles, and control access</div>
        </div>
        <div class="hero-stats">
            @php
                $pendingCount  = $bakers->where('status','pending')->count();
                $approvedCount = $bakers->where('status','approved')->count();
                $rejectedCount = $bakers->where('status','rejected')->count();
            @endphp
            <div class="hero-stat"><div class="hero-stat-val">{{ $bakers->count() }}</div><div class="hero-stat-lbl">Total</div></div>
            <div class="hero-stat"><div class="hero-stat-val">{{ $pendingCount }}</div><div class="hero-stat-lbl">Pending</div></div>
            <div class="hero-stat"><div class="hero-stat-val">{{ $approvedCount }}</div><div class="hero-stat-lbl">Approved</div></div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert" id="successAlert">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
        <button class="alert-close" onclick="document.getElementById('successAlert').remove()">×</button>
    </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-topbar">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <div class="table-title"><div class="title-dot"></div> Baker Directory</div>
                <div class="table-count">{{ $bakers->count() }}</div>
            </div>
            <div class="tsearch">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Search by name, email, shop…" oninput="filterBakers(this.value)">
            </div>
        </div>

        @php
            $pending  = $bakers->where('status', 'pending');
            $approved = $bakers->where('status', 'approved');
            $rejected = $bakers->where('status', 'rejected');
            $colors = [
                'linear-gradient(135deg,#B8782A,#E0A048)',
                'linear-gradient(135deg,#1E6860,#38B090)',
                'linear-gradient(135deg,#883030,#B05858)',
                'linear-gradient(135deg,#503820,#906040)',
                'linear-gradient(135deg,#283880,#5070C8)',
            ];
        @endphp

        @if($bakers->isEmpty())
            <div class="empty-state">
                <div class="empty-orb"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                <div class="empty-title">No bakers registered</div>
                <div class="empty-sub">Register the first baker to get started.</div>
            </div>
        @else

            {{-- ── PENDING ── --}}
            @if($pending->count())
            <div class="section-block" id="section-pending">
                <div class="section-label">
                    <span class="section-dot dot-pending"></span>
                    <span class="section-title pending-title">Pending Review</span>
                    <span class="section-count count-pending">{{ $pending->count() }}</span>
                </div>
                <div class="bakers-grid">
                    @foreach($pending as $baker)
                    @php $bg = $colors[$baker->id % count($colors)]; @endphp
                    <div class="baker-card" data-name="{{ strtolower($baker->name) }}" data-email="{{ strtolower($baker->email) }}" data-shop="{{ strtolower($baker->shop_name ?? '') }}">
                        <div class="baker-top">
                            <div class="baker-ava" style="background:{{ $bg }}">{{ strtoupper(substr($baker->name,0,2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="baker-name">{{ $baker->name }}</div>
                                <div class="baker-email">{{ $baker->email }}</div>
                                @if($baker->seller_type === 'homebased')
                                    <span class="type-tag type-homebased">🏠 Home-Based</span>
                                @elseif($baker->seller_type === 'registered')
                                    <span class="type-tag type-registered">🏢 Registered</span>
                                @endif
                            </div>
                            <span class="status-pill status-pending">Pending</span>
                        </div>
                        <div class="baker-meta">
                            @if($baker->phone)<span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.8 19.79 19.79 0 0 1 1.58 5.22 2 2 0 0 1 3.55 3h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.91a16 16 0 0 0 6.08 6.08l1.08-.88a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>{{ $baker->phone }}</span>@endif
                            @if($baker->shop_name)<span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>{{ $baker->shop_name }}</span>@endif
                        </div>
                        <div class="baker-actions">
                            <form method="POST" action="{{ route('bakers.approve', $baker->id) }}" style="display:inline">@csrf @method('PATCH')
                                <button type="submit" class="btn-sm btn-approve"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Approve</button>
                            </form>
                            <form method="POST" action="{{ route('bakers.reject', $baker->id) }}" style="display:inline">@csrf @method('PATCH')
                                <button type="submit" class="btn-sm btn-reject"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject</button>
                            </form>
                            <a href="{{ route('bakers.show', $baker->id) }}" class="btn-sm btn-view"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>View</a>
                            <button class="btn-sm btn-del" onclick="confirmDelete({{ $baker->id }}, '{{ addslashes($baker->name) }}')"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── APPROVED ── --}}
            @if($approved->count())
            <div class="section-block" id="section-approved">
                <div class="section-label">
                    <span class="section-dot dot-approved"></span>
                    <span class="section-title approved-title">Approved Bakers</span>
                    <span class="section-count count-approved">{{ $approved->count() }}</span>
                </div>
                <div class="bakers-grid">
                    @foreach($approved as $baker)
                    @php $bg = $colors[$baker->id % count($colors)]; @endphp
                    <div class="baker-card" data-name="{{ strtolower($baker->name) }}" data-email="{{ strtolower($baker->email) }}" data-shop="{{ strtolower($baker->shop_name ?? '') }}">
                        <div class="baker-top">
                            <div class="baker-ava" style="background:{{ $bg }}">{{ strtoupper(substr($baker->name,0,2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="baker-name">{{ $baker->name }}</div>
                                <div class="baker-email">{{ $baker->email }}</div>
                                @if($baker->seller_type === 'homebased')
                                    <span class="type-tag type-homebased">🏠 Home-Based</span>
                                @elseif($baker->seller_type === 'registered')
                                    <span class="type-tag type-registered">🏢 Registered</span>
                                @endif
                            </div>
                            <span class="status-pill status-approved">Approved</span>
                        </div>
                        <div class="baker-meta">
                            @if($baker->phone)<span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.8 19.79 19.79 0 0 1 1.58 5.22 2 2 0 0 1 3.55 3h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.91a16 16 0 0 0 6.08 6.08l1.08-.88a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>{{ $baker->phone }}</span>@endif
                            @if($baker->shop_name)<span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>{{ $baker->shop_name }}</span>@endif
                        </div>
                        <div class="baker-actions">
                            <a href="{{ route('bakers.show', $baker->id) }}" class="btn-sm btn-view"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>View</a>
                            <button class="btn-sm btn-del" onclick="confirmDelete({{ $baker->id }}, '{{ addslashes($baker->name) }}')"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── REJECTED ── --}}
            @if($rejected->count())
            <div class="section-block" id="section-rejected">
                <div class="section-label">
                    <span class="section-dot dot-rejected"></span>
                    <span class="section-title rejected-title">Rejected Applications</span>
                    <span class="section-count count-rejected">{{ $rejected->count() }}</span>
                </div>
                <div class="bakers-grid">
                    @foreach($rejected as $baker)
                    @php $bg = $colors[$baker->id % count($colors)]; @endphp
                    <div class="baker-card" data-name="{{ strtolower($baker->name) }}" data-email="{{ strtolower($baker->email) }}" data-shop="{{ strtolower($baker->shop_name ?? '') }}">
                        <div class="baker-top">
                            <div class="baker-ava" style="background:{{ $bg }}">{{ strtoupper(substr($baker->name,0,2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="baker-name">{{ $baker->name }}</div>
                                <div class="baker-email">{{ $baker->email }}</div>
                                @if($baker->seller_type === 'homebased')
                                    <span class="type-tag type-homebased">🏠 Home-Based</span>
                                @elseif($baker->seller_type === 'registered')
                                    <span class="type-tag type-registered">🏢 Registered</span>
                                @endif
                            </div>
                            <span class="status-pill status-rejected">Rejected</span>
                        </div>
                        <div class="baker-meta">
                            @if($baker->phone)<span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.8 19.79 19.79 0 0 1 1.58 5.22 2 2 0 0 1 3.55 3h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.91a16 16 0 0 0 6.08 6.08l1.08-.88a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>{{ $baker->phone }}</span>@endif
                            @if($baker->shop_name)<span><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>{{ $baker->shop_name }}</span>@endif
                        </div>
                        <div class="baker-actions">
                            <a href="{{ route('bakers.show', $baker->id) }}" class="btn-sm btn-view"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>View</a>
                            <button class="btn-sm btn-del" onclick="confirmDelete({{ $baker->id }}, '{{ addslashes($baker->name) }}')"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        @endif

        <div class="table-foot">
            Showing <strong id="visCount">{{ $bakers->count() }}</strong> of <strong>{{ $bakers->count() }}</strong> bakers
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none">@csrf @method('DELETE')</form>
<div class="toast-wrap" id="toastWrap"></div>
<div class="modal-backdrop" id="modalBackdrop"></div>

{{-- REGISTER BAKER MODAL --}}
<div class="modal-wrap" id="bakerModal">
    <div class="modal-box" id="bakerModalBox" onclick="event.stopPropagation()">
        <form id="bakerForm" method="POST" action="{{ route('bakers.store') }}">
            @csrf <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="m-head">
                <div class="m-head-left">
                    <div class="m-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <div class="m-title" id="modalTitle">Register Baker</div>
                        <div class="m-sub" id="modalSub">Add a new baker to the registry</div>
                    </div>
                </div>
                <button type="button" class="m-close" onclick="closeModal()">×</button>
            </div>
            <div class="m-body">
                <div class="fgrid">
                    <div class="fg"><label>Full Name</label><input type="text" class="fi" name="name" id="bName" placeholder="e.g. Maria Santos" required></div>
                    <div class="fg"><label>Email Address</label><input type="email" class="fi" name="email" id="bEmail" placeholder="baker@email.com" required></div>
                </div>
                <div class="fgrid">
                    <div class="fg"><label>Phone Number</label><input type="text" class="fi" name="phone" id="bPhone" placeholder="+63 912 345 6789"></div>
                    <div class="fg"><label>City</label><input type="text" class="fi" name="city" id="bCity" placeholder="e.g. Marikina City"></div>
                </div>
                <div class="fg"><label>Address</label><input type="text" class="fi" name="address" id="bAddress" placeholder="Street address"></div>
                <div class="fg"><label>Specialties</label><input type="text" class="fi" name="specialties" id="bSpec" placeholder="e.g. Wedding cakes, Fondant art"></div>
            </div>
            <div class="m-divider"></div>
            <div class="m-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit" id="submitBtn">Register Baker</button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE CONFIRM MODAL --}}
<div class="modal-wrap" id="deleteModal">
    <div class="del-box" id="delBox" onclick="event.stopPropagation()">
        <div class="del-body">
            <div class="del-icon">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
            </div>
            <div class="del-title">Remove Baker?</div>
            <div class="del-desc">You are about to permanently remove <strong id="delName"></strong> from the registry. This cannot be undone.</div>
        </div>
        <div class="del-footer">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Keep Baker</button>
            <button type="button" class="btn-confirm-del" onclick="submitDelete()">Remove</button>
        </div>
    </div>
</div>

<script>
let delId = null;

function openModal() {
    document.getElementById('modalBackdrop').classList.add('show');
    document.getElementById('bakerModal').classList.add('show');
    document.getElementById('bakerModalBox').classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('bName').focus(), 160);
}
function closeModal() {
    document.getElementById('modalBackdrop').classList.remove('show');
    document.getElementById('bakerModal').classList.remove('show');
    document.getElementById('bakerModalBox').classList.remove('show');
    document.getElementById('deleteModal').classList.remove('show');
    document.getElementById('delBox').classList.remove('show');
    document.body.style.overflow = '';
}
function resetForm() {
    document.getElementById('modalTitle').textContent = 'Register Baker';
    document.getElementById('modalSub').textContent = 'Add a new baker to the registry';
    document.getElementById('bakerForm').action = '{{ route('bakers.store') }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('submitBtn').textContent = 'Register Baker';
    ['bName','bEmail','bPhone','bCity','bAddress','bSpec'].forEach(id => document.getElementById(id).value = '');
}

document.getElementById('modalBackdrop').addEventListener('click', closeModal);
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

function confirmDelete(id, name) {
    delId = id;
    document.getElementById('delName').textContent = '"' + name + '"';
    document.getElementById('modalBackdrop').classList.add('show');
    document.getElementById('deleteModal').classList.add('show');
    document.getElementById('delBox').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('modalBackdrop').classList.remove('show');
    document.getElementById('deleteModal').classList.remove('show');
    document.getElementById('delBox').classList.remove('show');
    document.body.style.overflow = '';
    delId = null;
}
function submitDelete() {
    if (!delId) return;
    const f = document.getElementById('deleteForm');
    f.action = '/bakers/' + delId;
    f.submit();
}
function filterBakers(q) {
    q = q.toLowerCase();
    let v = 0;
    document.querySelectorAll('.baker-card').forEach(c => {
        const match = !q || c.dataset.name.includes(q) || c.dataset.email.includes(q) || c.dataset.shop.includes(q);
        c.style.display = match ? '' : 'none';
        if (match) v++;
    });
    document.getElementById('visCount').textContent = v;
}
function showToast(msg, type = 'success') {
    const c = document.getElementById('toastWrap');
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.textContent = msg;
    c.appendChild(t);
    setTimeout(() => { t.style.animation = 'toastOut .25s ease forwards'; setTimeout(() => t.remove(), 250); }, 3200);
}
@if(session('success'))
document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}', 'success'));
@endif
</script>
@endsection