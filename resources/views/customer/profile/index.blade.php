@extends('layouts.customer')
@section('title', 'My Profile')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
/* My Profile: luxury cake-atelier account page. Plus Jakarta Sans only. */
.profile-page{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:1500px;width:100%;margin:1vh auto 4vh;padding:0 clamp(.85rem,2.5vw,2rem) 2rem;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.profile-page *{box-sizing:border-box;font-family:inherit}
.profile-page a:focus-visible,.profile-page button:focus-visible,.profile-page input:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
@keyframes pf-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes pf-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes pf-modal{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
@media(prefers-reduced-motion:reduce){
*,*::before,*::after{animation:none!important;transition:none!important}}

/* header */
.profile-page .page-header{position:relative;margin:0 0 2.25rem;padding-bottom:1.75rem;animation:pf-fadeUp .6s var(--e) backwards}
.page-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.page-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:pf-line .9s var(--e) .3s backwards}
.page-title{font-size:clamp(2.4rem,6vw,4.6rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.page-subtitle{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* layout */
.pf-layout{display:grid;grid-template-columns:360px minmax(0,1fr);gap:3rem;align-items:start}
@media(max-width:1000px){.pf-layout{grid-template-columns:1fr;gap:2.5rem}}

/* identity panel */
.pf-identity{border:1px solid var(--esp);animation:pf-fadeUp .6s var(--e) .1s backwards}
.pf-hero{position:relative;padding:2rem 1.75rem 1.75rem;color:var(--ivory);text-align:left;
background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),radial-gradient(ellipse 90% 70% at 100% 0,rgba(184,148,82,.22),transparent 62%),linear-gradient(160deg,#2B1A12,#24150F 60%,#1B0F09)}
.pf-hero::after{content:"";position:absolute;left:1.75rem;right:1.75rem;bottom:0;height:2px;background:linear-gradient(90deg,var(--gold),transparent)}
.pf-role{display:block;font-size:.6rem;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:var(--gold);margin-bottom:1.4rem}
.pf-avatar{width:96px;height:96px;display:grid;place-items:center;overflow:hidden;background:var(--cof);border:1px solid var(--gold-line);box-shadow:inset 0 0 0 4px #24150F,inset 0 0 0 5px var(--gold-line);font-size:2rem;font-weight:900;color:var(--gold-l);margin-bottom:1.4rem}
.pf-avatar img{width:100%;height:100%;object-fit:cover;padding:6px}
.pf-name{font-size:1.5rem;font-weight:900;letter-spacing:-.04em;line-height:1.05;margin:0 0 .35rem;word-break:break-word}
.pf-email{font-size:.78rem;color:var(--beige);font-weight:500;word-break:break-all;margin-bottom:1.1rem}
.pf-badge{display:inline-flex;align-items:center;gap:.4rem;padding:.35rem .7rem;border:1px solid transparent;border-left-width:2px;font-size:.58rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
.pf-badge.verified{background:rgba(184,148,82,.14);color:var(--gold-l);border-color:var(--gold-line);border-left-color:var(--gold)}
.pf-badge.unverified{background:#F6ECEA;color:var(--burg);border-color:rgba(84,37,44,.28);border-left-color:var(--burg)}

.pf-stats{display:grid;grid-template-columns:1fr 1fr;background:var(--w)}
.pf-stat{position:relative;padding:1.2rem 1.25rem;border-bottom:1px solid var(--line);transition:background .35s}
.pf-stat:nth-child(odd){border-right:1px solid var(--line)}
.pf-stat:hover{background:var(--cream)}
.pf-stat svg{position:absolute;top:1.1rem;right:1.1rem;color:var(--gold)}
.pf-stat-num{font-size:1.7rem;font-weight:900;letter-spacing:-.05em;line-height:1;font-variant-numeric:tabular-nums}
.pf-stat-lbl{font-size:.58rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--taupe);margin-top:.5rem}
.pf-stat-sub{font-size:.68rem;color:var(--mocha);margin-top:.15rem}

.pf-meta{background:var(--w)}
.pf-meta-row{display:flex;justify-content:space-between;align-items:center;gap:.5rem;padding:.85rem 1.25rem;border-bottom:1px solid var(--line);font-size:.78rem}
.pf-meta-row .l{display:flex;align-items:center;gap:.5rem;font-weight:700;color:var(--mocha)}
.pf-meta-row .l svg{color:var(--gold)}
.pf-meta-row .v{font-weight:800}
.pf-meta-row .v.ok{color:var(--credit)}
.pf-meta-row .v.warn{color:var(--burg)}

.pf-edit-cta{display:flex;align-items:center;justify-content:center;gap:.6rem;width:100%;padding:1.05rem;background:var(--esp);color:var(--ivory);border:0;font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;transition:background .3s,color .3s}
.pf-edit-cta:hover{background:var(--gold);color:var(--esp);text-decoration:none}

/* sections */
.pf-main{display:flex;flex-direction:column;gap:3rem}
.pf-section{border-top:1px solid var(--esp);animation:pf-fadeUp .6s var(--e) backwards}
.pf-section:nth-child(1){animation-delay:.25s}.pf-section:nth-child(2){animation-delay:.35s}
.pf-head{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:1.25rem 0 1rem;border-bottom:1px solid var(--line)}
.pf-title{display:flex;align-items:center;gap:.6rem;font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;margin:0}
.pf-title svg{color:var(--gold)}
.pf-head-meta{font-size:.6rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--taupe)}
.pf-head-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.62rem;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--caramel);text-decoration:none;transition:color .25s}
.pf-head-link:hover{color:var(--esp);text-decoration:none}

/* info */
.pf-info{display:grid;grid-template-columns:1fr 1fr}
@media(max-width:560px){.pf-info{grid-template-columns:1fr}}
.pf-cell{padding:1.25rem 1rem 1.25rem 0;border-bottom:1px solid var(--line);transition:background .3s}
.pf-cell:nth-child(even){padding-left:1.5rem;border-left:1px solid var(--line)}
.pf-cell.full{grid-column:1/-1;border-left:0;padding-left:0}
@media(max-width:560px){.pf-cell:nth-child(even){padding-left:0;border-left:0}}
.pf-lbl{display:flex;align-items:center;gap:.5rem;font-size:.58rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);margin-bottom:.5rem}
.pf-lbl svg{color:var(--gold)}
.pf-val{font-size:1.05rem;font-weight:800;letter-spacing:-.02em;word-break:break-word}
.pf-val.muted{color:var(--taupe);font-weight:500}
.pf-sub{font-size:.72rem;color:var(--mocha);margin-top:.2rem}

/* addresses */
.addr-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;padding:1.5rem 0}
@media(max-width:700px){.addr-grid{grid-template-columns:1fr}}
.addr-card{position:relative;padding:1.3rem 1.3rem 1.1rem;background:var(--w);border:1px solid var(--beige);transition:border-color .3s,background .3s}
.addr-card:hover{border-color:var(--taupe)}
.addr-card.is-default{background:var(--cream);border-color:var(--gold-line);box-shadow:inset 0 0 0 4px var(--ivory),inset 0 0 0 5px var(--gold-line)}
.addr-type{display:flex;align-items:center;gap:.6rem;margin-bottom:.9rem}
.addr-type-icon{width:28px;height:28px;display:grid;place-items:center;border:1px solid var(--gold-line);color:var(--gold);flex-shrink:0}
.addr-label{font-size:.66rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase}
.addr-default{margin-left:auto;display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .55rem;background:#F3EAD3;border:1px solid var(--gold-line);border-left:2px solid var(--gold);color:#7A5A15;font-size:.54rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
.addr-street{font-size:.95rem;font-weight:800;letter-spacing:-.01em;line-height:1.4;margin-bottom:.2rem}
.addr-city{font-size:.76rem;color:var(--mocha);margin-bottom:1rem}
.addr-actions{display:flex;gap:.4rem;flex-wrap:wrap;padding-top:.85rem;border-top:1px solid var(--line)}
.addr-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem .8rem;background:transparent;border:1px solid var(--beige);font-size:.6rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--mocha);cursor:pointer;text-decoration:none;transition:.3s}
.addr-btn:hover{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.addr-btn.primary{background:var(--esp);border-color:var(--esp);color:var(--ivory)}
.addr-btn.primary:hover{background:var(--gold);border-color:var(--gold);color:var(--esp)}
.addr-btn.danger{color:var(--burg);border-color:rgba(84,37,44,.3)}
.addr-btn.danger:hover{background:var(--burg);border-color:var(--burg);color:var(--ivory)}
.addr-empty{text-align:center;padding:3.25rem 1rem;border-bottom:1px solid var(--line)}
.addr-empty-icon{display:flex;justify-content:center;margin-bottom:.9rem;color:var(--gold);opacity:.7}
.addr-empty-text{font-size:.9rem;font-weight:700;color:var(--mocha)}

/* add address */
.add-addr-section{padding:1.5rem 0 0;border-top:1px solid var(--line)}
.add-addr-toggle{display:flex;align-items:center;justify-content:center;gap:.8rem;width:100%;padding:1rem;background:var(--w);border:1px dashed var(--taupe);color:var(--esp);cursor:pointer;text-align:left;transition:.3s}
.add-addr-toggle:hover{border-color:var(--gold);background:var(--cream)}
#add-toggle-text{display:block;font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
.toggle-sub{display:block;font-size:.68rem;color:var(--taupe);margin-top:.15rem}
#add-toggle-icon{color:var(--gold)}
.add-addr-form{max-height:0;overflow:hidden;transition:max-height .4s var(--e)}
.add-addr-form.open{max-height:720px;margin-top:1.5rem}
.form-section-title{font-size:.6rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase;color:var(--taupe);margin-bottom:1rem}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
@media(max-width:480px){.form-row{grid-template-columns:1fr}}
.form-group{display:flex;flex-direction:column;gap:.45rem}
.form-label{font-size:.6rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--mocha)}
.form-input{width:100%;padding:.85rem 1rem;background:var(--w);border:1px solid var(--beige);border-radius:0;font-size:.9rem;font-weight:500;color:var(--esp);transition:border-color .25s,box-shadow .25s,background .25s}
.form-input::placeholder{color:var(--taupe)}
.form-input:hover{border-color:var(--taupe)}
.form-input:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.2);background:#fff}
.form-check-row{display:flex;align-items:center;gap:.6rem}
.form-check-row input{width:16px;height:16px;accent-color:var(--esp);cursor:pointer}
.form-check-row label{font-size:.8rem;font-weight:600;color:var(--mocha);cursor:pointer}
.form-actions{display:flex;gap:.6rem;flex-wrap:wrap}
.btn-save{display:inline-flex;align-items:center;gap:.5rem;padding:1rem 1.6rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;transition:background .3s,color .3s,transform .3s var(--e)}
.btn-save:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px)}
.btn-cancel-form{padding:1rem 1.4rem;background:transparent;color:var(--mocha);border:1px solid var(--beige);font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;transition:.3s}
.btn-cancel-form:hover{border-color:var(--esp);color:var(--esp)}

/* modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(27,15,9,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:1rem}
.modal-overlay.open{display:flex}
.modal-box{width:100%;max-width:520px;max-height:90vh;overflow-y:auto;background:var(--ivory);color:var(--esp);border:1px solid var(--esp);box-shadow:inset 0 0 0 5px var(--ivory),inset 0 0 0 6px var(--gold-line),0 30px 70px rgba(0,0,0,.35);animation:pf-modal .3s var(--e)}
.modal-header{display:flex;align-items:center;justify-content:space-between;padding:1.6rem 1.9rem 1rem;border-bottom:1px solid var(--line);margin:0 .4rem}
.modal-title{display:flex;align-items:center;gap:.6rem;font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase}
.modal-title svg{color:var(--gold)}
.modal-close{width:34px;height:34px;display:grid;place-items:center;background:transparent;border:1px solid var(--beige);font-size:1.2rem;line-height:1;color:var(--mocha);cursor:pointer;transition:.3s}
.modal-close:hover{background:var(--esp);border-color:var(--esp);color:var(--gold-l)}
.modal-body{padding:1.5rem 1.9rem 1.9rem}
</style>
@endpush

@section('content')
<div class="profile-page">

    {{-- HEADER --}}
    <div class="page-header">
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">Manage your account information and delivery addresses</p>
    </div>

    <div class="pf-layout">

        {{-- LEFT: IDENTITY --}}
        <aside class="pf-identity">
            <div class="pf-hero">
                <span class="pf-role">Customer</span>
                <div class="pf-avatar">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                    @endif
                </div>
                <h2 class="pf-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
                <div class="pf-email">{{ auth()->user()->email }}</div>

                @if(auth()->user()->is_verified)
                    <span class="pf-badge verified">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Verified Account
                    </span>
                @else
                    <span class="pf-badge unverified">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"></path></svg>
                        Action Needed
                    </span>
                @endif
            </div>

            <div class="pf-stats">
                <div class="pf-stat">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"></path><path d="M12 11V7"></path><path d="M9 7a3 3 0 0 1 6 0"></path></svg>
                    <div class="pf-stat-num">{{ auth()->user()->cakeRequests()->count() }}</div>
                    <div class="pf-stat-lbl">Requests</div>
                    <div class="pf-stat-sub">Total cake requests</div>
                </div>
                <div class="pf-stat">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <div class="pf-stat-num">{{ auth()->user()->cakeRequests()->where('status','COMPLETED')->count() }}</div>
                    <div class="pf-stat-lbl">Completed</div>
                    <div class="pf-stat-sub">Successfully delivered</div>
                </div>
                <div class="pf-stat">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <div class="pf-stat-num">{{ $addresses->count() }}</div>
                    <div class="pf-stat-lbl">Addresses</div>
                    <div class="pf-stat-sub">Saved locations</div>
                </div>
                <div class="pf-stat">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>
                    <div class="pf-stat-num">{{ auth()->user()->created_at->format('Y') }}</div>
                    <div class="pf-stat-lbl">Member</div>
                    <div class="pf-stat-sub">Account age</div>
                </div>
            </div>

            <div class="pf-meta">
                <div class="pf-meta-row">
                    <span class="l">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"></path></svg>
                        Role
                    </span>
                    <span class="v">Customer</span>
                </div>
                <div class="pf-meta-row">
                    <span class="l">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>
                        Member since
                    </span>
                    <span class="v">{{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
                <div class="pf-meta-row">
                    <span class="l">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        Status
                    </span>
                    @if(auth()->user()->is_verified)
                        <span class="v ok">Verified</span>
                    @else
                        <span class="v warn">Unverified</span>
                    @endif
                </div>
            </div>

            <a href="{{ route('customer.profile.edit') }}" class="pf-edit-cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                Edit Profile
            </a>
        </aside>

        {{-- RIGHT --}}
        <div class="pf-main">

            {{-- ACCOUNT INFO --}}
            <section class="pf-section">
                <div class="pf-head">
                    <h3 class="pf-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Account Information
                    </h3>
                    <a href="{{ route('customer.profile.edit') }}" class="pf-head-link">
                        Edit
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="pf-info">
                    <div class="pf-cell">
                        <div class="pf-lbl">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M6 21v-1a6 6 0 0 1 6-6 6 6 0 0 1 6 6v1"></path></svg>
                            First Name
                        </div>
                        <div class="pf-val">{{ auth()->user()->first_name }}</div>
                    </div>
                    <div class="pf-cell">
                        <div class="pf-lbl">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M6 21v-1a6 6 0 0 1 6-6 6 6 0 0 1 6 6v1"></path></svg>
                            Last Name
                        </div>
                        <div class="pf-val">{{ auth()->user()->last_name }}</div>
                    </div>
                    <div class="pf-cell">
                        <div class="pf-lbl">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m2 6 10 7 10-7"></path></svg>
                            Email Address
                        </div>
                        <div class="pf-val">{{ auth()->user()->email }}</div>
                        <div class="pf-sub">Used for sign-in &amp; notifications</div>
                    </div>
                    <div class="pf-cell">
                        <div class="pf-lbl">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"></path></svg>
                            Phone Number
                        </div>
                        <div class="pf-val {{ auth()->user()->phone ? '' : 'muted' }}">{{ auth()->user()->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="pf-cell full">
                        <div class="pf-lbl">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>
                            Member Since
                        </div>
                        <div class="pf-val">{{ auth()->user()->created_at->format('F d, Y') }}</div>
                        <div class="pf-sub">{{ auth()->user()->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </section>

            {{-- DELIVERY ADDRESSES --}}
            <section class="pf-section">
                <div class="pf-head">
                    <h3 class="pf-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Delivery Addresses
                    </h3>
                    <span class="pf-head-meta">{{ $addresses->count() }} saved</span>
                </div>

                @if($addresses->count())
                <div class="addr-grid">
                    @foreach($addresses as $addr)
                    @php
                        $addrIcons = [
                            'Home' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
                            'Work' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
                            'Office' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v18"></path><path d="M6 12H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2"></path><path d="M18 9h2a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1h-2"></path><path d="M10 6h.01M14 6h.01M10 10h.01M14 10h.01M10 14h.01M14 14h.01"></path></svg>',
                            'School' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5Z"></path><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"></path></svg>',
                        ];
                        $addrIconDefault = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
                        $icon = $addrIcons[$addr->label] ?? $addrIconDefault;
                    @endphp
                    <div class="addr-card {{ $addr->is_default ? 'is-default' : '' }}">
                        <div class="addr-type">
                            <div class="addr-type-icon">{!! $icon !!}</div>
                            <span class="addr-label">{{ $addr->label }}</span>
                            @if($addr->is_default)
                                <span class="addr-default">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Default
                                </span>
                            @endif
                        </div>
                        <div class="addr-street">{{ $addr->street }}</div>
                        <div class="addr-city">
                            {{ $addr->city }}{{ $addr->province ? ', ' . $addr->province : '' }}{{ $addr->zip_code ? ' ' . $addr->zip_code : '' }}
                        </div>
                        <div class="addr-actions">
                            @if(!$addr->is_default)
                            <form method="POST" action="{{ route('customer.addresses.setDefault', $addr->id) }}" style="margin:0;">
                                @csrf @method('PATCH')
                                <button type="submit" class="addr-btn primary">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    Set Default
                                </button>
                            </form>
                            @endif
                            <button onclick="openEditAddress({{ $addr->id }}, '{{ $addr->label }}', '{{ addslashes($addr->street) }}', '{{ addslashes($addr->city) }}', '{{ addslashes($addr->province) }}', '{{ $addr->zip_code }}')"
                                    class="addr-btn" type="button">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                                Edit
                            </button>
                            <form method="POST" action="{{ route('customer.addresses.destroy', $addr->id) }}"
                                onsubmit="return confirm('Remove this address?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="addr-btn danger">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="addr-empty">
                    <span class="addr-empty-icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </span>
                    <div class="addr-empty-text">No saved addresses yet. Add one below.</div>
                </div>
                @endif

                <div class="add-addr-section">
                    <button class="add-addr-toggle" onclick="toggleAddForm(this)" type="button">
                        <span id="add-toggle-icon" style="display:flex;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg>
                        </span>
                        <span>
                            <span id="add-toggle-text">Add New Address</span>
                            <span class="toggle-sub">Save another delivery location</span>
                        </span>
                    </button>

                    <div class="add-addr-form" id="addAddressForm">
                        <form method="POST" action="{{ route('customer.addresses.store') }}">
                            @csrf
                            <div class="form-section-title">New Address Details</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Label *</label>
                                    <input type="text" name="label" class="form-input" placeholder="Home, Work, etc." required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Street *</label>
                                    <input type="text" name="street" class="form-input" placeholder="House no., Street name" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">City / Municipality *</label>
                                    <input type="text" name="city" class="form-input" placeholder="e.g. Dasmariñas" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Province</label>
                                    <input type="text" name="province" class="form-input" placeholder="e.g. Cavite">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">ZIP Code</label>
                                    <input type="text" name="zip_code" class="form-input" placeholder="e.g. 4114">
                                </div>
                                <div class="form-group" style="justify-content:flex-end;">
                                    <div class="form-check-row" style="padding-bottom:.85rem;">
                                        <input type="checkbox" name="is_default" id="is_default" value="1">
                                        <label for="is_default">Set as default address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Save Address
                                </button>
                                <button type="button" class="btn-cancel-form" onclick="toggleAddForm(document.querySelector('.add-addr-toggle'))">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

{{-- EDIT ADDRESS MODAL --}}
<div id="editModal" class="profile-page modal-overlay" style="margin:0;max-width:none;padding:1rem;" role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="editModalTitle">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                Edit Address
            </div>
            <button class="modal-close" type="button" onclick="closeEditModal()" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" id="editAddressForm">
                @csrf @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Label *</label>
                        <input type="text" name="label" id="edit_label" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Street *</label>
                        <input type="text" name="street" id="edit_street" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">City *</label>
                        <input type="text" name="city" id="edit_city" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Province</label>
                        <input type="text" name="province" id="edit_province" class="form-input">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label class="form-label">ZIP Code</label>
                    <input type="text" name="zip_code" id="edit_zip" class="form-input">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Update Address
                    </button>
                    <button type="button" class="btn-cancel-form" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleAddForm(btn) {
    const form = document.getElementById('addAddressForm');
    const icon = document.getElementById('add-toggle-icon');
    const text = document.getElementById('add-toggle-text');
    const isOpen = form.classList.toggle('open');
    icon.innerHTML = isOpen
        ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path></svg>'
        : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg>';
    text.textContent = isOpen ? 'Cancel' : 'Add New Address';
}
function openEditAddress(id, label, street, city, province, zip) {
    document.getElementById('edit_label').value    = label;
    document.getElementById('edit_street').value   = street;
    document.getElementById('edit_city').value     = city;
    document.getElementById('edit_province').value = province;
    document.getElementById('edit_zip').value      = zip;
    document.getElementById('editAddressForm').action = `/customer/addresses/${id}`;
    document.getElementById('editModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEditModal();
});
</script>
@endpush