<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — BakeSphere</title>
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;font-family:'Plus Jakarta Sans',system-ui,sans-serif}
:root{
--esp:#24150F;--cof:#3A241A;--cream:#F7F2E9;--beige:#EFE6D7;--caramel:#A96F42;
--gold:#B89452;--gold-l:#D4B06A;--burg:#54252C;--taupe:#9A897A;--latte:#D8C8B7;--blush:#E8D3CA;
--w:#FBF8F2;--mocha:#7A5E4C;--ink:#1C0E08;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.32);
--e:cubic-bezier(.2,.7,.2,1);--r:2px;
/* legacy tokens still referenced by inline styles */
--warm-white:var(--w);--border:var(--latte);--text-dark:var(--ink);--text-muted:var(--taupe);
--brown-dark:var(--esp);--brown-accent:var(--caramel);--brown-pale:var(--beige);--brown-light:var(--gold-l);
--err:var(--burg);--success:var(--caramel)}
html,body{height:100%;background:var(--cream);color:var(--ink)}
body{font-weight:500;line-height:1.6}
:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
 
@keyframes fadeSlideUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}
@keyframes slideInLeft{from{opacity:0;transform:translateX(-32px)}to{opacity:1;transform:none}}
@keyframes lineDraw{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@media(prefers-reduced-motion:reduce){
*,*::before,*::after{animation:none!important;transition:none!important}
.left-panel,.form-header,.section-label,.terms-row,.form-wrap>form>div:last-child{opacity:1!important;transform:none!important}}
 
.page-wrap{display:flex;min-height:100vh}
 
/* ═══ EDITORIAL PANEL ═══ */
.left-panel{position:sticky;top:0;width:min(38vw,440px);flex-shrink:0;height:100vh;overflow:hidden;
  padding:2.75rem 2.5rem;display:flex;flex-direction:column;color:var(--cream);
  background:repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),
    radial-gradient(ellipse 130% 40% at 0 0,rgba(184,148,82,.14),transparent 62%),
    linear-gradient(180deg,#2B1A12,#24150F 55%,#1B0F09);
  border-right:1px solid var(--gold-line);animation:slideInLeft .7s var(--e) backwards}
.left-panel::before,.left-panel::after{display:none}
.panel-photo{position:absolute;left:0;right:0;bottom:0;height:42%;width:100%;object-fit:cover;opacity:.32;filter:saturate(.8);
  -webkit-mask-image:linear-gradient(0deg,#000 20%,transparent);mask-image:linear-gradient(0deg,#000 20%,transparent);pointer-events:none}
.panel-num{position:absolute;right:1.25rem;top:5.5rem;font-size:clamp(9rem,17vw,15rem);font-weight:900;line-height:.8;letter-spacing:-.08em;color:transparent;-webkit-text-stroke:1px rgba(184,148,82,.22);pointer-events:none;user-select:none}
.brand{position:relative;z-index:1;display:flex;align-items:center;gap:1rem;margin-bottom:2.5rem}
.brand-icon{width:46px;height:46px;border:1px solid var(--gold);box-shadow:inset 0 0 0 3px var(--esp),inset 0 0 0 4px var(--gold-line);display:grid;place-items:center;flex-shrink:0}
.brand-icon svg{width:22px;height:22px;stroke:var(--gold-l)}
.brand-name{font-size:1.18rem;font-weight:700;color:var(--cream);line-height:1.1}
.brand-sub{font-size:.56rem;font-weight:700;letter-spacing:.36em;text-transform:uppercase;color:var(--gold);margin-top:6px}
.panel-heading{position:relative;z-index:1;font-size:clamp(2.2rem,3.6vw,3.3rem);font-weight:900;line-height:.98;letter-spacing:-.05em;color:var(--cream);margin-bottom:1rem}
.panel-heading em{font-style:normal;color:transparent;-webkit-text-stroke:1.5px var(--gold)}
.panel-sub{position:relative;z-index:1;font-size:.86rem;line-height:1.75;color:rgba(247,242,233,.6);max-width:34ch;margin-bottom:1.75rem;padding-top:1.1rem;border-top:1px solid var(--gold-line)}
.perks{position:relative;z-index:1;list-style:none}
.perks li{display:flex;gap:.85rem;align-items:flex-start;padding:.7rem 0;border-bottom:1px solid rgba(184,148,82,.14);font-size:.78rem;line-height:1.5;color:rgba(247,242,233,.55)}
.perks li:last-child{border-bottom:0}
.perk-icon{width:30px;height:30px;border:1px solid var(--gold-line);border-radius:var(--r);display:grid;place-items:center;flex-shrink:0}
.perk-icon svg{stroke:var(--gold-l)}
.perk-title{font-weight:700;color:var(--cream);font-size:.8rem;margin-bottom:.1rem}
.side-links{position:relative;z-index:1;margin-top:auto;padding-top:1.25rem;border-top:1px solid var(--gold-line);display:flex;flex-direction:column;gap:.5rem}
.side-links-label{font-size:.58rem;font-weight:700;letter-spacing:.3em;text-transform:uppercase;color:var(--gold)}
.side-link{display:inline-flex;align-items:center;gap:.55rem;padding:.6rem .9rem;border:1px solid rgba(247,242,233,.16);border-radius:var(--r);background:rgba(36,21,15,.7);color:rgba(247,242,233,.75);text-decoration:none;font-size:.74rem;font-weight:700;letter-spacing:.03em;transition:.3s}
.side-link:hover{border-color:var(--gold);color:var(--gold-l)}
 
/* ═══ FORM WORKSPACE ═══ */
.right-panel{flex:1;min-width:0;overflow-y:auto;padding:3.5rem clamp(1.5rem,5vw,4.5rem) 5rem;
  background:radial-gradient(ellipse 60% 30% at 100% 0,rgba(184,148,82,.09),transparent 60%),var(--cream)}
.form-wrap{width:100%;max-width:860px;margin:0 auto}
.form-header{margin-bottom:2.25rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gold-line);animation:fadeSlideUp .6s var(--e) .15s backwards}
.form-header-eyebrow{font-size:.64rem;font-weight:700;letter-spacing:.3em;text-transform:uppercase;color:var(--caramel);margin-bottom:.7rem}
.form-header h1{font-size:clamp(2rem,4vw,3.2rem);font-weight:900;line-height:1;letter-spacing:-.05em;color:var(--esp);margin-bottom:.8rem}
.form-header p{font-size:.86rem;color:var(--mocha)}
.form-header p a{color:var(--esp);font-weight:800;text-decoration:none;border-bottom:1px solid var(--gold);padding-bottom:1px}
.form-header p a:hover{color:var(--caramel)}
 
.alert-error,.alert-success{border-radius:var(--r);padding:.9rem 1.1rem;margin-bottom:1.5rem;font-size:.82rem;font-weight:600;border-left:2px solid}
.alert-error{background:#F6ECEA;color:var(--burg);border-color:var(--burg)}
.alert-success{background:var(--beige);color:var(--esp);border-color:var(--gold)}
 
/* numbered editorial sections (CSS counter, no markup change) */
form{counter-reset:sec}
.section-label{counter-increment:sec;display:flex;align-items:center;gap:.7rem;margin:2.5rem 0 1.25rem;padding-bottom:.7rem;border-bottom:1px solid var(--gold-line);
  font-size:.66rem;font-weight:800;letter-spacing:.26em;text-transform:uppercase;color:var(--esp);animation:fadeSlideUp .6s var(--e) backwards}
.section-label:first-of-type{margin-top:0}
.section-label::before{content:counter(sec,decimal-leading-zero);font-size:1.5rem;font-weight:900;letter-spacing:-.05em;color:var(--gold)}
.section-label svg{stroke:var(--caramel);margin-left:auto}
.section-label:nth-of-type(1){animation-delay:.28s}.section-label:nth-of-type(2){animation-delay:.42s}.section-label:nth-of-type(3){animation-delay:.56s}
 
.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1.1rem}
.form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.1rem}
.form-group{margin-bottom:1.2rem}
.form-label{display:block;margin-bottom:.5rem;font-size:.62rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:var(--mocha)}
.form-label .req{color:var(--caramel)}
.form-label .hint{font-size:.62rem;font-weight:600;letter-spacing:.06em;text-transform:none;color:var(--taupe);margin-left:4px}
.form-input{width:100%;padding:.85rem 1rem;background:var(--w);border:1px solid var(--latte);border-radius:var(--r);font-size:.9rem;font-weight:500;color:var(--ink);outline:none;transition:border-color .25s,box-shadow .25s,background .25s}
.form-input::placeholder{color:var(--taupe)}
.form-input:hover{border-color:var(--taupe)}
.form-input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.2);background:#fff}
.form-input.is-invalid{border-color:var(--burg);border-width:1.5px}
.form-input.is-valid{border-color:var(--caramel)}
select.form-input{cursor:pointer;appearance:none;padding-right:2.5rem;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23B89452' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 1rem center}
.field-error{margin-top:.4rem;font-size:.74rem;font-weight:700;color:var(--burg)}
.field-note{margin-top:.35rem;font-size:.7rem;color:var(--taupe);line-height:1.4}
 
.pw-wrap{position:relative}
.pw-wrap .form-input{padding-right:46px}
.pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:0;cursor:pointer;color:var(--taupe);padding:4px;display:flex;transition:color .25s}
.pw-toggle:hover{color:var(--gold)}
/* thin gold strength line */
.strength-bar{height:2px;background:var(--latte);margin-top:10px;overflow:hidden}
.strength-fill{height:100%;width:0;background:var(--gold)!important;transition:width .4s var(--e)}
.strength-label{margin-top:5px;font-size:.62rem;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:var(--caramel)}
.match-msg{margin-top:6px;font-size:.72rem;font-weight:700}
 
.terms-row{display:flex;align-items:flex-start;gap:.7rem;margin:1.75rem 0 1.4rem;padding-top:1.4rem;border-top:1px solid var(--gold-line);animation:fadeSlideUp .6s var(--e) .68s backwards}
.terms-row input[type=checkbox]{width:16px;height:16px;margin-top:2px;flex-shrink:0;accent-color:var(--gold);cursor:pointer}
.terms-row label{font-size:.82rem;color:var(--mocha);line-height:1.6}
.terms-row label a{color:var(--esp);font-weight:800;cursor:pointer;border-bottom:1px solid var(--gold)}
.terms-row label a:hover{color:var(--caramel)}
.form-wrap>form>div:last-child{animation:fadeSlideUp .6s var(--e) .8s backwards}
 
.btn-submit{display:inline-flex;align-items:center;padding:1rem 2rem;background:var(--esp);color:var(--cream);border:1px solid var(--esp);border-radius:var(--r);font-size:.76rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:transform .3s var(--e),background .3s,color .3s,box-shadow .3s}
.btn-submit:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);box-shadow:0 16px 34px rgba(184,148,82,.4)}
.btn-google{display:inline-flex;align-items:center;gap:9px;padding:1rem 1.4rem;background:transparent;border:1px solid var(--esp);border-radius:var(--r);text-decoration:none;font-size:.76rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:.3s}
.btn-google:hover{border-color:var(--gold);background:var(--beige);transform:translateY(-2px)}
.btn-google img{width:16px;height:16px}
.divider{display:none}
.form-note{margin-top:1.5rem;font-size:.7rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--taupe);text-align:center;line-height:1.6}
 
/* ═══ TERMS / PRIVACY DIALOGS ═══ */
.modal-overlay{display:none;position:fixed;inset:0;z-index:1000;background:rgba(28,14,8,.88);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:20px}
.modal-overlay.open{display:flex}
.modal-box{position:relative;width:100%;max-width:580px;max-height:82vh;overflow-y:auto;background:var(--cream);border:1px solid var(--gold);border-top:4px solid var(--esp);border-radius:var(--r);padding:2.25rem 2.4rem;box-shadow:0 40px 100px rgba(0,0,0,.6);animation:fadeSlideUp .4s var(--e)}
.modal-box h2{font-size:1.7rem;font-weight:900;letter-spacing:-.04em;color:var(--esp);margin-bottom:1rem;padding-bottom:.8rem;border-bottom:1px solid var(--gold-line)}
.modal-box p,.modal-box li{font-size:.86rem;line-height:1.75;color:var(--mocha);margin-bottom:.7rem}
.modal-box ul{padding-left:1.1rem;margin-bottom:.7rem}
.modal-box strong{color:var(--esp);font-weight:800}
.modal-close{position:absolute;top:12px;right:16px;background:none;border:0;color:var(--taupe);font-size:1.2rem;cursor:pointer;line-height:1;transition:color .25s}
.modal-close:hover{color:var(--gold)}
 
/* ═══ PROVINCE / CITY COMBOBOX ═══ */
.combo-wrap{position:relative}
.combo-wrap .form-input{padding-right:2.2rem;cursor:pointer}
.combo-wrap::after{content:'';position:absolute;right:1rem;top:50%;width:7px;height:7px;border-right:1.5px solid var(--gold);border-bottom:1.5px solid var(--gold);transform:translateY(-70%) rotate(45deg);pointer-events:none}
.combo-dropdown{display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:200;max-height:210px;overflow-y:auto;background:var(--w);border:1px solid var(--gold);border-radius:var(--r);box-shadow:0 14px 30px rgba(36,21,15,.18)}
.combo-dropdown.open{display:block}
.combo-option{padding:.6rem 1rem;font-size:.84rem;color:var(--ink);cursor:pointer;transition:background .15s}
.combo-option:hover,.combo-option.highlighted{background:var(--beige);color:var(--esp);font-weight:700}
.combo-option.no-result{color:var(--taupe);font-style:italic;cursor:default}
.combo-option.no-result:hover{background:none}
 
/* ═══ RESPONSIVE ═══ */
@media(max-width:1100px){.left-panel{width:min(34vw,340px);padding:2.25rem 1.75rem}.panel-num{font-size:9rem}}
@media(max-width:900px){.left-panel{width:270px}.right-panel{padding:2.5rem 1.75rem 4rem}}
@media(max-width:700px){
.page-wrap{flex-direction:column}
.left-panel{position:relative;width:100%;height:auto;padding:1.75rem 1.25rem 2rem;border-right:0;border-bottom:1px solid var(--gold-line)}
.panel-photo,.perks,.side-links{display:none}
.panel-num{font-size:6.5rem;top:1rem;right:.75rem}
.brand{margin-bottom:1.5rem}.panel-heading{font-size:2.2rem}.panel-sub{margin-bottom:0}
.right-panel{padding:2rem 1.25rem 3rem;overflow:visible}
.form-row-2,.form-row-3{grid-template-columns:1fr}
.btn-submit,.btn-google{width:100%;justify-content:center}
.modal-box{padding:1.75rem 1.4rem}
}
    </style>
</head>
<body>
<div class="page-wrap">

    <!-- ══ SIDEBAR ══ -->
    <div class="left-panel">
        <div class="brand">
     <div class="brand-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#E8C9A8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div>
            <div>
                <div class="brand-name">BakeSphere</div>
                <div class="brand-sub">Customer Portal</div>
            </div>
        </div>

        <img class="panel-photo" src="{{ asset('models/pic1.jpg') }}" alt="">
<div class="panel-num" aria-hidden="true">01</div>
<h2 class="panel-heading">Create your<br><em>BakeSphere</em><br>account.</h2>
        <p class="panel-sub">Connect with talented local bakers and get a custom cake made just for you.</p>

        <ul class="perks">
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E8C9A8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div><div><div class="perk-title">Custom Cake Builder</div>Design with flavors, tiers, and decorations.</div></li>
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E8C9A8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 12h6"/><path d="M9 16h6"/></svg></div><div><div class="perk-title">Request & Get Bids</div>Post your request and receive bids from local bakers.</div></li>
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E8C9A8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div><div><div class="perk-title">Review Bakers</div>Rate and review after your order is delivered.</div></li>
            <li><div class="perk-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#E8C9A8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div><div><div class="perk-title">Fresh Delivery</div>Get your handcrafted cake delivered to your door.</div></li>
        </ul>

        <div class="side-links">
            <span class="side-links-label">Quick Links</span>
            <a href="{{ route('login') }}" class="side-link"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="7.5" cy="15.5" r="5.5"/><path d="M21 2l-9.6 9.6"/><path d="M15.5 7.5 18 10"/></svg> Already have an account? Sign in</a>
            <a href="{{ route('baker.register') }}" class="side-link"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg> Are you a baker? Join here</a>
        </div>
    </div>

    <!-- ══ RIGHT PANEL ══ -->
    <div class="right-panel">
        <div class="form-wrap">

            <div class="form-header">
                <div class="form-header-eyebrow">Customer Registration</div>
                <h1>Create Your Account</h1>
                <p>Already have one? <a href="{{ route('login') }}">Sign in here</a></p>
            </div>

            {{-- Alerts --}}
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>✕ {{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- ── 1. PERSONAL INFORMATION ── --}}
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg> Personal Information</div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">First Name <span class="req">*</span></label>
                        <input type="text" name="first_name" id="first_name"
                            class="form-input {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                            value="{{ old('first_name') }}" placeholder="Juan" required>
                        <div class="field-error" id="first_name_err" style="display:none;"></div>
                        @error('first_name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name <span class="req">*</span></label>
                        <input type="text" name="last_name" id="last_name"
                            class="form-input {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                            value="{{ old('last_name') }}" placeholder="Dela Cruz" required>
                        <div class="field-error" id="last_name_err" style="display:none;"></div>
                        @error('last_name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Middle Name <span class="hint">(optional)</span></label>
                        <input type="text" name="middle_name" id="middle_name"
                            class="form-input"
                            value="{{ old('middle_name') }}" placeholder="Santos">
                        <div class="field-error" id="middle_name_err" style="display:none;"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Suffix <span class="hint">(optional)</span></label>
                        <select name="suffix" class="form-input">
                            <option value="">— None —</option>
                            <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                            <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                            <option value="II"  {{ old('suffix') == 'II'  ? 'selected' : '' }}>II</option>
                            <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address <span class="req">*</span></label>
                    <input type="email" name="email"
                        class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}" placeholder="juan@email.com" required>
                    @error('email') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">
                            Phone Number <span class="req">*</span>
                            <span class="hint">(PH — 11 digits)</span>
                        </label>
                        <input type="text" name="phone" id="phone"
                            class="form-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            value="{{ old('phone') }}" placeholder="09XXXXXXXXX"
                            maxlength="11" inputmode="numeric" required>
                        <div class="field-error" id="phone_err" style="display:none;"></div>
                        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birthdate <span class="req">*</span></label>
                        <input type="date" name="birthdate"
                            class="form-input {{ $errors->has('birthdate') ? 'is-invalid' : '' }}"
                            value="{{ old('birthdate') }}" required>
                        <div class="field-note">Must be 18 years old or older.</div>
                        @error('birthdate') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- ── 2. DELIVERY ADDRESS ── --}}
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 13-8 13s-8-7-8-13a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg> Delivery Address</div>

      <div class="form-group">
                    <label class="form-label">Street / House No. / Barangay <span class="req">*</span></label>
                    <input type="text" name="address_line"
                        class="form-input {{ $errors->has('address_line') ? 'is-invalid' : '' }}"
                        value="{{ old('address_line') }}"
                        placeholder="123 Sampaguita St., Brgy. Poblacion" required>
                    @error('address_line') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row-3">
                    <div class="form-group" style="position:relative;">
                        <label class="form-label">Province <span class="req">*</span></label>
                        <div class="combo-wrap" id="reg-province-wrap">
                            <input type="text" id="reg-province-display" class="form-input {{ $errors->has('province') ? 'is-invalid' : '' }}"
                                placeholder="Type province..." autocomplete="off" required>
                            <input type="hidden" name="province" id="reg-province-val" value="{{ old('province') }}">
                            <div class="combo-dropdown" id="reg-province-drop"></div>
                        </div>
                        @error('province') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="position:relative;">
                        <label class="form-label">City / Municipality <span class="req">*</span></label>
                        <div class="combo-wrap" id="reg-city-wrap">
                            <input type="text" id="reg-city-display" class="form-input {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                placeholder="Select province first..." autocomplete="off" required>
                            <input type="hidden" name="city" id="reg-city-val" value="{{ old('city') }}">
                            <div class="combo-dropdown" id="reg-city-drop"></div>
                        </div>
                        @error('city') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">ZIP Code <span class="req">*</span></label>
                        <input type="text" name="zip"
                            class="form-input {{ $errors->has('zip') ? 'is-invalid' : '' }}"
                            value="{{ old('zip') }}" placeholder="4110"
                            maxlength="4" inputmode="numeric" required>
                        @error('zip') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- ── 3. SECURITY ── --}}
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Security</div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="password"
                                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="At least 8 characters" required>
                            <button type="button" class="pw-toggle" onclick="togglePw('password', this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                        <div class="strength-label" id="strengthLabel"></div>
                        @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-input" placeholder="Repeat password" required>
                            <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                        <div class="match-msg" id="pw_match_msg"></div>
                    </div>
                </div>

                <div class="terms-row">
                    <input type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>
                    <label for="terms">
                        I agree to the
                        <a onclick="openModal('termsModal')">Terms &amp; Conditions</a>
                        and
                        <a onclick="openModal('privacyModal')">Privacy Policy</a>
                    </label>
                </div>
                @error('terms') <div class="field-error" style="margin-top:-12px;margin-bottom:12px;">{{ $message }}</div> @enderror

      <div style="display:flex; align-items:center; justify-content:center; gap:.75rem; flex-wrap:wrap; margin-top:.25rem;">
                    <button type="submit" class="btn-submit">Create My Account →</button>
                    <span style="font-size:.72rem; color:#B09080;">or</span>
                    <a href="{{ route('auth.google', ['as' => 'customer']) }}" class="btn-google">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                        Continue with Google
                    </a>
                </div>

            </form>

            <div class="divider"></div>

            <p class="form-note">By signing up you confirm you are 18+ and a resident of the Philippines.</p>

        </div>
    </div>
</div>

<!-- ── Terms Modal ── -->
<div class="modal-overlay" id="termsModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('termsModal')">✕</button>
        <h2>Terms &amp; Conditions</h2>
        <p><strong>Effective Date:</strong> January 1, 2025</p>
        <p>Welcome to BakeSphere! By creating an account and using our services, you agree to the following terms.</p>
        <p><strong>1. Acceptance of Terms</strong></p>
        <p>By registering, you confirm you are at least 18 years old and agree to be bound by these Terms and our Privacy Policy.</p>
        <p><strong>2. Account Responsibilities</strong></p>
        <ul>
            <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
            <li>You agree to provide accurate and up-to-date information during registration.</li>
            <li>You must notify us immediately of any unauthorized use of your account.</li>
        </ul>
        <p><strong>3. Use of Service</strong></p>
        <p>BakeSphere connects customers with local bakers. You agree not to misuse the platform or submit fraudulent orders.</p>
        <p><strong>4. Orders &amp; Payments</strong></p>
        <p>All orders are subject to baker availability. Payments are subject to our refund and cancellation policy.</p>
        <p><strong>5. Limitation of Liability</strong></p>
        <p>BakeSphere is not liable for any indirect or consequential damages arising from your use of the platform.</p>
        <p><strong>6. Contact</strong></p>
        <p>For questions, contact us at <strong>support@bakesphere.ph</strong>.</p>
    </div>
</div>

<!-- ── Privacy Modal ── -->
<div class="modal-overlay" id="privacyModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('privacyModal')">✕</button>
        <h2>Privacy Policy</h2>
        <p><strong>Effective Date:</strong> January 1, 2025</p>
        <p>At BakeSphere, we are committed to protecting your personal information.</p>
        <p><strong>1. Information We Collect</strong></p>
        <ul>
            <li><strong>Account Information:</strong> Name, email, phone, and birthdate.</li>
            <li><strong>Order Information:</strong> Delivery addresses and cake preferences.</li>
            <li><strong>Usage Data:</strong> Log data and pages visited.</li>
        </ul>
        <p><strong>2. How We Use Your Information</strong></p>
        <ul>
            <li>To create and manage your account.</li>
            <li>To process and fulfill your cake orders.</li>
            <li>To send order updates and support messages.</li>
        </ul>
        <p><strong>3. Sharing of Information</strong></p>
        <p>We do not sell your personal data. We share information only with bakers fulfilling your orders and payment processors.</p>
        <p><strong>4. Your Rights</strong></p>
        <p>Under the Philippine Data Privacy Act (RA 10173), you have the right to access, correct, or delete your data. Contact <strong>privacy@bakesphere.ph</strong>.</p>
        <p><strong>5. Contact Us</strong></p>
        <p>Email us at <strong>privacy@bakesphere.ph</strong> for privacy concerns.</p>
    </div>
</div>

<script>
    /* PASSWORD STRENGTH */
    const pw = document.getElementById('password');
    const fill = document.getElementById('strengthFill');
    const slabel = document.getElementById('strengthLabel');
    pw.addEventListener('input', function () {
        const v = this.value; let s = 0;
        if (v.length >= 8) s++;
        if (/[A-Z]/.test(v)) s++;
        if (/[0-9]/.test(v)) s++;
        if (/[^A-Za-z0-9]/.test(v)) s++;
        fill.style.width = (s / 4 * 100) + '%';
        fill.style.background = ['#E53935','#FB8C00','#FDD835','#43A047'][s-1] || 'transparent';
        slabel.textContent = s > 0 ? ['Weak','Fair','Good','Strong'][s-1] : '';
        checkMatch();
    });

    /* PASSWORD MATCH */
    const pwc = document.getElementById('password_confirmation');
    const matchMsg = document.getElementById('pw_match_msg');
    function checkMatch() {
        if (!pwc.value) { matchMsg.textContent = ''; pwc.classList.remove('is-invalid','is-valid'); return; }
        if (pw.value === pwc.value) {
            matchMsg.textContent = '✓ Passwords match';
            matchMsg.style.color = '#5B8F6A';
            pwc.classList.remove('is-invalid'); pwc.classList.add('is-valid');
        } else {
            matchMsg.textContent = '✕ Passwords do not match';
            matchMsg.style.color = '#C0392B';
            pwc.classList.remove('is-valid'); pwc.classList.add('is-invalid');
        }
    }
    pwc.addEventListener('input', checkMatch);

    /* NAME FIELDS: no numbers */
    function enforceNoNumbers(inputId, errId) {
        const inp = document.getElementById(inputId);
        const err = document.getElementById(errId);
        if (!inp || !err) return;
        inp.addEventListener('input', function () {
            if (/\d/.test(this.value)) {
                this.value = this.value.replace(/\d/g, '');
                inp.classList.add('is-invalid');
                err.textContent = 'Name must not contain numbers.';
                err.style.display = 'block';
            } else {
                inp.classList.remove('is-invalid');
                err.style.display = 'none';
            }
        });
    }
    enforceNoNumbers('first_name',  'first_name_err');
    enforceNoNumbers('last_name',   'last_name_err');
    enforceNoNumbers('middle_name', 'middle_name_err');

    /* PHONE — digits only, max 11 */
    const phoneInput = document.getElementById('phone');
    const phoneErr   = document.getElementById('phone_err');
    phoneInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });
    phoneInput.addEventListener('keydown', function (e) {
        const allowed = ['Backspace','Delete','Tab','ArrowLeft','ArrowRight','Home','End'];
        if (allowed.includes(e.key)) return;
        if (!/^\d$/.test(e.key)) e.preventDefault();
    });
    phoneInput.addEventListener('blur', function () {
        if (this.value.length > 0 && this.value.length !== 11) {
            phoneErr.textContent = 'Must be exactly 11 digits (e.g. 09XXXXXXXXX).';
            phoneErr.style.display = 'block';
            this.classList.add('is-invalid');
        } else {
            phoneErr.style.display = 'none';
            this.classList.remove('is-invalid');
        }
    });

    /* ZIP — digits only, max 4 */
    const zipInput = document.querySelector('input[name="zip"]');
    if (zipInput) {
        zipInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 4);
        });
    }

    /* BIRTHDATE — must be 18+ */
    const bdInput = document.querySelector('input[name="birthdate"]');
    if (bdInput) {
        const today = new Date();
        const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        bdInput.setAttribute('max', maxDate.toISOString().split('T')[0]);
        bdInput.addEventListener('change', function () {
            const bd = new Date(this.value);
            if (bd > maxDate) { this.classList.add('is-invalid'); }
            else { this.classList.remove('is-invalid'); }
        });
    }

    /* PASSWORD TOGGLE */
    function togglePw(id, btn) {
        const f = document.getElementById(id);
        if (f.type === 'password') { f.type = 'text'; btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'; }
        else { f.type = 'password'; btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>'; }
    }

    /* MODALS */
    function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
    /* ══ PHILIPPINES PROVINCE → CITY COMBOBOX ══ */
    const PH_DATA = {
      "Metro Manila": ["Caloocan","Las Piñas","Makati","Malabon","Mandaluyong","Manila","Marikina","Muntinlupa","Navotas","Parañaque","Pasay","Pasig","Pateros","Quezon City","San Juan","Taguig","Valenzuela"],
      "Cavite": ["Alfonso","Amadeo","Bacoor","Carmona","Dasmariñas","General Emilio Aguinaldo","General Mariano Alvarez","General Trias","Imus","Indang","Kawit","Magallanes","Maragondon","Mendez","Naic","Noveleta","Rosario","Silang","Tagaytay","Tanza","Ternate","Trece Martires"],
      "Laguna": ["Alaminos","Bay","Biñan","Cabuyao","Calamba","Calauan","Cavinti","Famy","Kalayaan","Liliw","Los Baños","Luisiana","Lumban","Mabitac","Magdalena","Majayjay","Nagcarlan","Paete","Pagsanjan","Pakil","Pangil","Pila","Rizal","San Pablo","San Pedro","Santa Cruz","Santa Maria","Santo Tomas","Siniloan","Victoria"],
      "Batangas": ["Agoncillo","Alitagtag","Balayan","Balete","Batangas City","Bauan","Calaca","Calatagan","Cuenca","Ibaan","Laurel","Lemery","Lian","Lipa","Lobo","Mabini","Malvar","Mataasnakahoy","Nasugbu","Padre Garcia","Rosario","San Jose","San Juan","San Luis","San Nicolas","San Pascual","Santa Teresita","Santo Tomas","Taal","Talisay","Taysan","Tingloy","Tuy"],
      "Rizal": ["Angono","Antipolo","Baras","Binangonan","Cainta","Cardona","Jala-Jala","Morong","Pililla","Rodriguez","San Mateo","Tanay","Taytay","Teresa"],
      "Bulacan": ["Angat","Balagtas","Baliuag","Bocaue","Bulakan","Bustos","Calumpit","Doña Remedios Trinidad","Guiguinto","Hagonoy","Malolos","Marilao","Meycauayan","Norzagaray","Obando","Pandi","Paombong","Plaridel","Pulilan","San Ildefonso","San Jose del Monte","San Miguel","San Rafael","Santa Maria"],
      "Pampanga": ["Angeles","Apalit","Arayat","Bacolor","Candaba","Floridablanca","Guagua","Lubao","Mabalacat","Macabebe","Magalang","Masantol","Mexico","Minalin","Porac","San Fernando","San Luis","San Simon","Santa Ana","Santa Rita","Santo Tomas","Sasmuan"],
      "Tarlac": ["Anao","Bamban","Camiling","Capas","Concepcion","Gerona","La Paz","Mayantoc","Moncada","Paniqui","Pura","Ramos","San Clemente","San Jose","San Manuel","Santa Ignacia","Tarlac City","Victoria"],
      "Cebu": ["Alcantara","Alcoy","Alegria","Aloguinsan","Argao","Asturias","Badian","Balamban","Bantayan","Barili","Bogo","Boljoon","Borbon","Carmen","Catmon","Cebu City","Compostela","Consolacion","Cordova","Daanbantayan","Dalaguete","Danao","Dumanjug","Ginatilan","Lapu-Lapu","Liloan","Madridejos","Malabuyoc","Mandaue","Medellin","Minglanilla","Moalboal","Naga","Oslob","Pilar","Pinamungajan","Poro","Ronda","Samboan","San Fernando","San Francisco","San Remigio","Santa Fe","Santander","Sibonga","Sogod","Tabogon","Tabuelan","Talisay","Toledo","Tuburan","Tudela"],
      "Davao del Sur": ["Bansalan","Davao City","Digos","Don Marcelino","Hagonoy","Jose Abad Santos","Kiblawan","Magsaysay","Malalag","Matanao","Padada","Santa Cruz","Sta. Maria","Sulop"],
      "Iloilo": ["Ajuy","Alimodian","Anilao","Badiangan","Balasan","Banate","Barotac Nuevo","Barotac Viejo","Batad","Bingawan","Cabatuan","Calinog","Carles","Concepcion","Dingle","Dueñas","Dumangas","Estancia","Guimbal","Igbaras","Iloilo City","Janiuay","Lambunao","Leganes","Lemery","Leon","Maasin","Miagao","Mina","New Lucena","Oton","Passi","Pavia","Pototan","San Dionisio","San Enrique","San Joaquin","San Miguel","San Rafael","Santa Barbara","Sara","Tigbauan","Tubungan","Zarraga"],
      "Negros Occidental": ["Bacolod","Bago","Binalbagan","Cadiz","Calatrava","Candoni","Cauayan","Enrique B. Magalona","Escalante","Himamaylan","Hinigaran","Hinoba-an","Ilog","Isabela","Kabankalan","La Carlota","La Castellana","Manapla","Moises Padilla","Murcia","Pontevedra","Pulupandan","Sagay","San Carlos","San Enrique","Silay","Sipalay","Talisay","Toboso","Valladolid","Victorias"],
      "Cagayan de Oro": ["Cagayan de Oro"],
      "Zamboanga del Sur": ["Aurora","Bayog","Dimataling","Dinas","Dumalinao","Dumingag","Guipos","Josefina","Kumalarang","Labangan","Lakewood","Lapuyan","Mahayag","Margosatubig","Midsalip","Molave","Pagadian","Pitogo","Ramon Magsaysay","San Miguel","San Pablo","Tabina","Tambulig","Tukuran","Vincenzo A. Sagun","Zamboanga City"],
      "Pangasinan": ["Agno","Aguilar","Alaminos","Alcala","Anda","Asingan","Balungao","Bani","Basista","Bautista","Bayambang","Binalonan","Binmaley","Bolinao","Bugallon","Burgos","Calasiao","Dagupan","Dasol","Infanta","Labrador","Laoac","Lingayen","Mabini","Malasiqui","Manaoag","Mangaldan","Mangatarem","Mapandan","Moncada","Natividad","Pozorrubio","Rosales","San Carlos","San Fabian","San Jacinto","San Manuel","San Nicolas","San Quintin","Santa Barbara","Santa Maria","Santo Tomas","Sison","Sual","Tayug","Umingan","Urbiztondo","Urdaneta","Villasis"],
      "Isabela": ["Alicia","Angadanan","Aurora","Benito Soliven","Burgos","Cabagan","Cabatuan","Cauayan","Cordon","Dinapigue","Divilacan","Echague","Gamu","Ilagan","Jones","Luna","Maconacon","Mallig","Naguilian","Palanan","Quezon","Quirino","Ramon","Reina Mercedes","Roxas","San Agustin","San Guillermo","San Isidro","San Manuel","San Mariano","San Mateo","San Pablo","Santa Maria","Santiago","Santo Tomas","Tumauini"],
      "Nueva Ecija": ["Aliaga","Bongabon","Cabanatuan","Cabiao","Carranglan","Cuyapo","Gabaldon","General Mamerto Natividad","General Tinio","Guimba","Jaen","Laur","Licab","Llanera","Lupao","Muñoz","Nampicuan","Palayan","Pantabangan","Peñaranda","Quezon","Rizal","San Antonio","San Isidro","San Jose","San Leonardo","Santa Rosa","Santo Domingo","Talavera","Talugtug","Zaragoza"],
      "Albay": ["Bacacay","Camalig","Daraga","Guinobatan","Jovellar","Legazpi","Libon","Ligao","Malilipot","Malinao","Manito","Oas","Pio Duran","Polangui","Rapu-Rapu","Santo Domingo","Tabaco","Tiwi"],
      "Quezon": ["Agdangan","Alabat","Atimonan","Buenavista","Burdeos","Calauag","Candelaria","Catanauan","Dolores","General Luna","General Nakar","Guinayangan","Gumaca","Infanta","Jomalig","Lopez","Lucban","Lucena","Macalelon","Mauban","Mulanay","Padre Burgos","Pagbilao","Panukulan","Patnanungan","Perez","Pitogo","Plaridel","Polillo","Quezon","Real","Sampaloc","San Andres","San Antonio","San Francisco","San Narciso","Sariaya","Tagkawayan","Tayabas","Tiaong","Unson"],
      "Camarines Sur": ["Baao","Balatan","Bato","Bombon","Buhi","Bula","Cabusao","Calabanga","Camaligan","Canaman","Caramoan","Del Gallego","Gainza","Garchitorena","Goa","Iriga","Lagonoy","Libmanan","Lupi","Magarao","Milaor","Minalabac","Nabua","Naga","Ocampo","Pamplona","Pasacao","Pili","Presentacion","Ragay","Sagñay","San Fernando","San Jose","Sipocot","Siruma","Tigaon","Tinambac"],
      "Leyte": ["Abuyog","Alangalang","Albuera","Babatngon","Barugo","Bato","Baybay","Burauen","Calubian","Capoocan","Carigara","Dagami","Dulag","Hilongos","Hindang","Inopacan","Isabel","Jaro","Javier","Julita","Kananga","La Paz","Leyte","MacArthur","Mahaplag","Matag-ob","Matalom","Mayorga","Merida","Ormoc","Palo","Palompon","Pastrana","San Isidro","San Miguel","Santa Fe","Tabango","Tabontabon","Tacloban","Tanauan","Tolosa","Tunga","Villaba"],
      "South Cotabato": ["Banga","General Santos","Koronadal","Lake Sebu","Norala","Polomolok","Santo Niño","Surallah","T'boli","Tampakan","Tantangan","Tupi"],
      "Misamis Oriental": ["Alubijid","Balingasag","Balingoan","Binuangan","Cagayan de Oro","Claveria","El Salvador","Gingoog","Gitagum","Initao","Jasaan","Kinoguitan","Lagonglong","Laguindingan","Libertad","Lugait","Magsaysay","Manticao","Medina","Naawan","Opol","Salay","Sugbongcogon","Tagoloan","Talisayan","Villanueva"],
      "Bukidnon": ["Baungon","Cabanglasan","Damulog","Dangcagan","Don Carlos","Impasugong","Kadingilan","Kalilangan","Kibawe","Kitaotao","Lantapan","Libona","Malaybalay","Malitbog","Manolo Fortich","Maramag","Pangantucan","Quezon","San Fernando","Sumilao","Talakag","Valencia"],
      "Benguet": ["Atok","Baguio","Bakun","Bokod","Buguias","Itogon","Kabayan","Kapangan","Kibungan","La Trinidad","Mankayan","Sablan","Tuba","Tublay"],
      "Mountain Province": ["Barlig","Bauko","Besao","Bontoc","Natonin","Paracelis","Sabangan","Sadanga","Sagada","Tadian"],
      "Ifugao": ["Aguinaldo","Alfonso Lista","Asipulo","Banaue","Hingyon","Hungduan","Kiangan","Lagawe","Lamut","Mayoyao","Tinoc"],
      "Kalinga": ["Balbalan","Lubuagan","Pasil","Pinukpuk","Rizal","Tabuk","Tanudan","Tinglayan"],
      "Apayao": ["Calanasan","Conner","Flora","Kabugao","Luna","Pudtol","Santa Marcela"],
      "Abra": ["Bangued","Boliney","Bucay","Bucloc","Daguioman","Danglas","Dolores","La Paz","Lacub","Lagangilang","Lagayan","Langiden","Licuan-Baay","Luba","Malibcong","Manabo","Peñarrubia","Pidigan","Pilar","Sallapadan","San Isidro","San Juan","San Quintin","Tayum","Tineg","Tubo","Villaviciosa"],
      "Ilocos Norte": ["Adams","Bacarra","Badoc","Bangui","Banna","Batac","Burgos","Carasi","Currimao","Dingras","Dumalneg","Laoag","Marcos","Nueva Era","Pagudpud","Paoay","Pasuquin","Piddig","Pinili","San Nicolas","Sarrat","Solsona","Vintar"],
      "Ilocos Sur": ["Alilem","Banayoyo","Bantay","Burgos","Cabugao","Caoayan","Cervantes","Galimuyod","Gregorio del Pilar","Lidlidda","Magsingal","Nagbukel","Narvacan","Quirino","Salcedo","San Emilio","San Esteban","San Ildefonso","San Juan","San Vicente","Santa","Santa Catalina","Santa Cruz","Santa Lucia","Santa Maria","Santiago","Santo Domingo","Sigay","Sinait","Sugpon","Suyo","Tagudin","Vigan"],
      "La Union": ["Agoo","Aringay","Bacnotan","Bagulin","Balaoan","Bangar","Bauang","Burgos","Caba","Luna","Naguilian","Pugo","Rosario","San Fernando","San Gabriel","San Juan","Santo Tomas","Santol","Sudipen","Tubao"],
      "Cagayan": ["Abulug","Alcala","Allacapan","Amulung","Aparri","Baggao","Ballesteros","Buguey","Calayan","Camalaniugan","Claveria","Enrile","Gattaran","Gonzaga","Iguig","Lal-lo","Lasam","Pamplona","Peñablanca","Piat","Rizal","Sanchez-Mira","Santa Ana","Santa Praxedes","Santa Teresita","Santo Niño","Solana","Tuao","Tuguegarao"],
      "Quirino": ["Aglipay","Cabarroguis","Diffun","Maddela","Nagtipunan","Saguday"],
      "Nueva Vizcaya": ["Alfonso Castañeda","Ambaguio","Aritao","Bagabag","Bambang","Bayombong","Diadi","Dupax del Norte","Dupax del Sur","Kasibu","Kayapa","Quezon","Santa Fe","Solano","Villaverde"],
      "Aurora": ["Baler","Casiguran","Dilasag","Dinalungan","Dingalan","Dipaculao","Maria Aurora","San Luis"],
      "Bataan": ["Abucay","Bagac","Balanga","Dinalupihan","Hermosa","Limay","Mariveles","Morong","Orani","Orion","Pilar","Samal"],
      "Zambales": ["Botolan","Cabangan","Candelaria","Castillejos","Iba","Masinloc","Olongapo","Palauig","San Antonio","San Felipe","San Marcelino","San Narciso","Santa Cruz","Subic"],
      "Batanes": ["Basco","Itbayat","Ivana","Mahatao","Sabtang","Uyugan"],
      "Marinduque": ["Boac","Buenavista","Gasan","Mogpog","Santa Cruz","Torrijos"],
      "Occidental Mindoro": ["Abra de Ilog","Calintaan","Looc","Lubang","Magsaysay","Mamburao","Paluan","Rizal","Sablayan","San Jose","Santa Cruz"],
      "Oriental Mindoro": ["Baco","Bansud","Bongabong","Bulalacao","Calapan","Gloria","Mansalay","Naujan","Pinamalayan","Pola","Puerto Galera","Roxas","San Teodoro","Socorro","Victoria"],
      "Romblon": ["Alcantara","Banton","Cajidiocan","Calatrava","Concepcion","Corcuera","Ferrol","Looc","Magdiwang","Odiongan","Romblon","San Agustin","San Andres","San Fernando","San Jose","Santa Fe","Santa Maria"],
      "Palawan": ["Aborlan","Agutaya","Araceli","Balabac","Bataraza","Brooke's Point","Busuanga","Cagayancillo","Coron","Culion","Cuyo","Dumaran","El Nido","Espanola","Kalayaan","Linapacan","Magsaysay","Narra","Puerto Princesa","Quezon","Rizal","Roxas","San Vicente","Sofronio Española","Taytay"],
      "Sorsogon": ["Barcelona","Bulan","Bulusan","Casiguran","Castilla","Donsol","Gubat","Irosin","Juban","Magallanes","Matnog","Pilar","Prieto Diaz","Santa Magdalena","Sorsogon City"],
      "Masbate": ["Aroroy","Baleno","Balud","Batuan","Cataingan","Cawayan","Claveria","Dimasalang","Esperanza","Mandaon","Masbate City","Milagros","Mobo","Monreal","Palanas","Pio V. Corpuz","Placer","San Fernando","San Jacinto","San Pascual","Uson"],
      "Biliran": ["Almeria","Biliran","Cabucgayan","Caibiran","Culaba","Kawayan","Maripipi","Naval"],
      "Eastern Samar": ["Arteche","Balangiga","Balangkayan","Borongan","Can-avid","Dolores","General MacArthur","Giporlos","Guiuan","Hernani","Jipapad","Lawaan","Llorente","Maslog","Maydolong","Mercedes","Oras","Quinapondan","Salcedo","San Julian","San Policarpo","Sulat","Taft"],
      "Northern Samar": ["Allen","Biri","Bobon","Capul","Catarman","Catubig","Gamay","Lapinig","Las Navas","Lavezares","Lope de Vega","Mapanas","Mondragon","Palapag","Pambujan","Rosario","San Antonio","San Isidro","San Jose","San Roque","San Vicente","Silvino Lobos","Victoria"],
      "Western Samar": ["Almagro","Basey","Calbayog","Calbiga","Catbalogan","Daram","Gandara","Hinabangan","Jiabong","Marabut","Matuguinao","Motiong","Pagsanghan","Paranas","Pinabacdao","San Jorge","San Jose de Buan","San Sebastian","Santa Margarita","Santa Rita","Santo Niño","Tagapul-an","Talalora","Tarangnan","Villareal","Zumarraga"],
      "Surigao del Norte": ["Alegria","Bacuag","Burgos","Claver","Dapa","Del Carmen","General Luna","Gigaquit","Mainit","Malimono","Pilar","Placer","San Benito","San Francisco","San Isidro","Santa Monica","Sison","Socorro","Surigao City","Tagana-an","Tubod"],
      "Surigao del Sur": ["Barobo","Bayabas","Bislig","Cagwait","Cantilan","Carmen","Carrascal","Cortes","Hinatuan","Lanuza","Lianga","Lingig","Madrid","Marihatag","San Agustin","San Miguel","Tagbina","Tago","Tandag"],
      "Agusan del Norte": ["Buenavista","Butuan","Cabadbaran","Carmen","Jabonga","Kitcharao","Las Nieves","Magallanes","Nasipit","Remedios T. Romualdez","Santiago","Tubay"],
      "Agusan del Sur": ["Bayugan","Bunawan","Esperanza","La Paz","Loreto","Prosperidad","Rosario","San Francisco","San Luis","Santa Josefa","Sibagat","Talacogon","Trento","Veruela"],
      "Misamis Occidental": ["Aloran","Baliangao","Bonifacio","Calamba","Clarin","Concepcion","Don Victoriano Chiongbian","Jimenez","Lopez Jaena","Oroquieta","Ozamiz","Panaon","Plaridel","Sapang Dalaga","Sinacaban","Tangub","Tudela"],
      "Lanao del Norte": ["Bacolod","Baloi","Baroy","Iligan","Kapatagan","Kauswagan","Kolambugan","Lala","Linamon","Magsaysay","Maigo","Matungao","Munai","Nunungan","Pantao Ragat","Pantar","Poona Piagapo","Salvador","Sapad","Sultan Naga Dimaporo","Tagoloan","Tangkal","Tubod"],
      "Zamboanga del Norte": ["Baliguian","Dapitan","Dipolog","Godod","Gutalac","Jose Dalman","Kalawit","Katipunan","La Libertad","Labason","Leon B. Postigo","Liloy","Manukan","Mutia","Piñan","Polanco","President Manuel A. Roxas","Rizal","Roxas","Salug","Sergio Osmeña Sr.","Siayan","Sibuco","Sibutad","Sindangan","Siocon","Sirawai","Tampilisan"],
      "Compostela Valley": ["Compostela","Laak","Mabini","Maco","Maragusan","Mawab","Monkayo","Montevista","Nabunturan","New Bataan","Pantukan"],
      "Davao del Norte": ["Asuncion","Braulio E. Dujali","Carmen","Kapalong","New Corella","Panabo","San Isidro","Santo Tomas","Tagum","Talaingod"],
      "Davao Oriental": ["Baganga","Banaybanay","Boston","Caraga","Cateel","Governor Generoso","Lupon","Manay","Mati","San Isidro","Tarragona"],
      "North Cotabato": ["Alamada","Aleosan","Arakan","Banisilan","Carmen","Cotabato City","Kabacan","Kidapawan","Libungan","Magpet","Makilala","Matalam","Midsayap","M'lang","Pigkawayan","Pikit","President Roxas","Tulunan"],
      "Sultan Kudarat": ["Bagumbayan","Columbio","Esperanza","Isulan","Kalamansig","Lebak","Lutayan","Lambayong","Palimbang","President Quirino","Senator Ninoy Aquino","Tacurong"],
      "Sarangani": ["Alabel","Glan","Kiamba","Maasim","Maitum","Malapatan","Malungon"],
      "Maguindanao": ["Ampatuan","Barira","Buldon","Buluan","Cotabato City","Datu Abdullah Sangki","Datu Anggal Midtimbang","Datu Blah T. Sinsuat","Datu Hoffer Ampatuan","Datu Montawal","Datu Odin Sinsuat","Datu Paglas","Datu Piang","Datu Salibo","Datu Saudi-Ampatuan","Datu Unsay","General Salipada K. Pendatun","Guindulungan","Kabuntalan","Mangudadatu","Mamasapano","Northern Kabuntalan","Pagalungan","Paglat","Pandag","Parang","Rajah Buayan","Shariff Aguak","Shariff Saydona Mustapha","South Upi","Sultan Kudarat","Sultan Mastura","Sultan sa Barongis","Talayan","Talitay","Upi"],
      "Lanao del Sur": ["Bacolod-Kalawi","Balabagan","Balindong","Bayang","Binidayan","Buadiposo-Buntong","Bubong","Bumbaran","Butig","Calanogas","Ditsaan-Ramain","Ganassi","Kapai","Kapatagan","Lumba-Bayabao","Lumbaca-Unayan","Lumbatan","Lumbayanague","Madalum","Madamba","Maguing","Malabang","Marantao","Marawi","Marogong","Masiu","Mulondo","Pagayawan","Piagapo","Picong","Poona Bayabao","Pualas","Saguiaran","Sultan Dumalondong","Tagoloan II","Tamparan","Taraka","Tubaran","Tugaya","Wao"],
      "Basilan": ["Akbar","Al-Barka","Hadji Mohammad Ajul","Hadji Muhtamad","Isabela","Lamitan","Lantawan","Maluso","Sumisip","Tabuan-Lasa","Tipo-Tipo","Tuburan","Ungkaya Pukan"],
      "Sulu": ["Hadji Panglima Tahil","Indanan","Jolo","Kalingalan Caluang","Lugus","Luuk","Maimbung","Old Panamao","Omar","Pandami","Panglima Estino","Pangutaran","Parang","Pata","Patikul","Talipao","Tapul","Tongkil"],
      "Tawi-Tawi": ["Bongao","Languyan","Mapun","Panglima Sugala","Sapa-Sapa","Sibutu","Simunul","Sitangkai","South Ubian","Tandubas","Turtle Islands"]
    };

    function makeCombo(provinceDisplayId, provinceValId, provinceDropId, cityDisplayId, cityValId, cityDropId, oldProvince, oldCity) {
        const provDisplay = document.getElementById(provinceDisplayId);
        const provVal     = document.getElementById(provinceValId);
        const provDrop    = document.getElementById(provinceDropId);
        const cityDisplay = document.getElementById(cityDisplayId);
        const cityVal     = document.getElementById(cityValId);
        const cityDrop    = document.getElementById(cityDropId);

        const provinces = Object.keys(PH_DATA).sort();

        function renderDrop(drop, items, onSelect) {
            drop.innerHTML = '';
            if (!items.length) {
                drop.innerHTML = '<div class="combo-option no-result">No results found</div>';
            } else {
                items.forEach(function(item) {
                    const d = document.createElement('div');
                    d.className = 'combo-option';
                    d.textContent = item;
                    d.addEventListener('mousedown', function(e) { e.preventDefault(); onSelect(item); });
                    drop.appendChild(d);
                });
            }
            drop.classList.add('open');
        }

        function closeAll() { provDrop.classList.remove('open'); cityDrop.classList.remove('open'); }

        // Province input
        provDisplay.addEventListener('focus', function() {
            const q = this.value.trim().toLowerCase();
            const filtered = provinces.filter(p => p.toLowerCase().includes(q));
            renderDrop(provDrop, filtered, function(val) {
                provDisplay.value = val; provVal.value = val;
                provDrop.classList.remove('open');
                cityDisplay.value = ''; cityVal.value = '';
                cityDisplay.placeholder = 'Type city...';
            });
        });
        provDisplay.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            provVal.value = '';
            const filtered = provinces.filter(p => p.toLowerCase().includes(q));
            renderDrop(provDrop, filtered, function(val) {
                provDisplay.value = val; provVal.value = val;
                provDrop.classList.remove('open');
                cityDisplay.value = ''; cityVal.value = '';
                cityDisplay.placeholder = 'Type city...';
            });
        });

        // City input
        cityDisplay.addEventListener('focus', function() {
            const prov = provVal.value;
            if (!prov) { cityDrop.classList.remove('open'); return; }
            const cities = (PH_DATA[prov] || []).slice().sort();
            const q = this.value.trim().toLowerCase();
            const filtered = cities.filter(c => c.toLowerCase().includes(q));
            renderDrop(cityDrop, filtered, function(val) {
                cityDisplay.value = val; cityVal.value = val;
                cityDrop.classList.remove('open');
            });
        });
        cityDisplay.addEventListener('input', function() {
            const prov = provVal.value;
            if (!prov) return;
            const cities = (PH_DATA[prov] || []).slice().sort();
            const q = this.value.trim().toLowerCase();
            const filtered = cities.filter(c => c.toLowerCase().includes(q));
            renderDrop(cityDrop, filtered, function(val) {
                cityDisplay.value = val; cityVal.value = val;
                cityDrop.classList.remove('open');
            });
        });

        // Close on outside click
        document.addEventListener('mousedown', function(e) {
            if (!provDrop.contains(e.target) && e.target !== provDisplay) provDrop.classList.remove('open');
            if (!cityDrop.contains(e.target) && e.target !== cityDisplay) cityDrop.classList.remove('open');
        });

        // Restore old values on validation fail
        if (oldProvince) { provDisplay.value = oldProvince; provVal.value = oldProvince; cityDisplay.placeholder = 'Type city...'; }
        if (oldCity)     { cityDisplay.value = oldCity;     cityVal.value = oldCity; }
    }
        makeCombo('reg-province-display','reg-province-val','reg-province-drop','reg-city-display','reg-city-val','reg-city-drop','{{ old("province") }}','{{ old("city") }}');

</script>
</body>
</html>