<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Baker Profile — BakeSphere</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cream:        #FDF6F0;
            --warm-white:   #FFFDF9;
            --brown-dark:   #5C3D2E;
            --brown-mid:    #7B4F3A;
            --brown-accent: #C07850;
            --brown-light:  #E8C9A8;
            --brown-pale:   #F5E6D8;
            --border:       #E2CDB8;
            --text-dark:    #2D1A0E;
            --text-muted:   #9A7A65;
            --err:          #C0392B;
            --success:      #5B8F6A;
        }

        html, body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--cream);
            color: var(--text-dark);
        }

        /* ══ TOP BANNER ══ */
        .top-banner {
            background: linear-gradient(135deg, #3D2314, #7B4F3A);
            padding: .75rem 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,.2);
        }
        .top-banner-left { display: flex; align-items: center; gap: 1.25rem; }
        .top-banner-brand { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.2rem; color: var(--brown-light); font-weight: 700; }
        .top-banner-brand span { color: var(--brown-accent); }
        .btn-back-login {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: .75rem; font-weight: 600; color: rgba(255,255,255,.55);
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
            border-radius: 7px; padding: .35rem .75rem; text-decoration: none; transition: all .2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-back-login:hover { background: rgba(255,255,255,.15); color: rgba(255,255,255,.85); border-color: rgba(255,255,255,.3); }
        .top-banner-right { display: flex; align-items: center; gap: .65rem; font-size: .8rem; color: rgba(255,255,255,.55); font-family: 'Plus Jakarta Sans', sans-serif; }
        .top-banner-avatar-placeholder { width: 30px; height: 30px; border-radius: 50%; background: var(--brown-accent); display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; color: #fff; }
.progress-wrap {
    background: var(--warm-white);
    padding: .55rem 2.5rem;
    display: flex; align-items: center; justify-content: center;
    border-bottom: 1.5px solid var(--border);
}
.progress-inner {
    display: flex; align-items: center; width: 100%;
}
.step {
    display: flex; align-items: center; gap: .45rem;
    font-size: .75rem; color: var(--text-muted);
    white-space: nowrap; font-family: 'Plus Jakarta Sans', sans-serif;
    flex-shrink: 0;
}
.step.done   { color: var(--success); }
.step.active { color: var(--brown-accent); font-weight: 600; }
.step-num {
    width: 20px; height: 20px; border-radius: 50%;
    border: 2px solid currentColor;
    display: flex; align-items: center; justify-content: center;
    font-size: .64rem; font-weight: 700; flex-shrink: 0;
}
.step.done .step-num   { background: var(--success); color: #fff; border-color: var(--success); }
.step.active .step-num { background: var(--brown-accent); color: #fff; border-color: var(--brown-accent); }
.step-line {
    flex: 1;
    height: 1px;
    background: var(--border);
    margin: 0 .75rem;
}
        /* ══ PAGE BODY ══ */
        .page-body { max-width: 1400px; margin: 0 auto; padding: 1.75rem 2.5rem 4rem; }

        /* ══ PAGE HEADER ══ */
        .page-header { margin-bottom: 1.1rem; }
        .page-header-eyebrow { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .16em; color: var(--brown-accent); margin-bottom: .25rem; font-family: 'Plus Jakarta Sans', sans-serif; }
        .page-header h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.55rem; font-weight: 800; color: var(--text-dark); margin-bottom: .2rem; line-height: 1.2; }
        .page-header p { font-size: .84rem; color: var(--text-muted); line-height: 1.55; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ PREFILL NOTICE ══ */
        .prefill-notice { display: flex; align-items: flex-start; gap: .75rem; background: #EEF6FF; border: 1.5px solid #BFD9F5; border-radius: 10px; padding: .75rem 1rem; margin-bottom: .75rem; }
        .prefill-notice-title { font-weight: 700; color: #0D3D70; font-size: .82rem; font-family: 'Plus Jakarta Sans', sans-serif; }
        .prefill-chips { display: flex; flex-wrap: wrap; gap: .3rem; margin-top: .3rem; }
        .prefill-chip { display: inline-flex; align-items: center; gap: .2rem; padding: .15rem .55rem; background: #D0E8FF; border-radius: 20px; font-size: .68rem; font-weight: 600; color: #0D3D70; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ PREFILLED GRID ══ */
        .prefilled-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; margin-bottom: 1.25rem; padding: .9rem 1rem; background: var(--brown-pale); border: 1.5px solid var(--border); border-radius: 10px; }
        .prefilled-item label { font-size: .63rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--text-muted); margin-bottom: .2rem; display: block; font-family: 'Plus Jakarta Sans', sans-serif; }
        .prefilled-value { display: flex; align-items: center; gap: .4rem; font-size: .84rem; font-weight: 600; color: var(--brown-dark); font-family: 'Plus Jakarta Sans', sans-serif; }
        .locked-badge { font-size: .58rem; background: var(--success); color: #fff; padding: .12rem .4rem; border-radius: 20px; font-weight: 700; margin-left: .5rem; white-space: nowrap; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ SELLER TYPE ══ */
        .seller-type-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: 1.25rem; }
        .seller-type-card { border: 2px solid var(--border); border-radius: 12px; padding: .85rem 1rem; cursor: pointer; transition: all .2s; background: var(--warm-white); position: relative; display: block; }
        .seller-type-card:hover { border-color: var(--brown-accent); background: var(--brown-pale); }
        .seller-type-card.active { border-color: var(--brown-accent); background: var(--brown-pale); box-shadow: 0 3px 12px rgba(192,120,80,.15); }
        .seller-type-card input[type=radio] { display: none; }
        .stc-badge { position: absolute; top: 8px; right: 8px; font-size: .58rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 2px 6px; border-radius: 20px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .badge-registered { background: #E8F4EC; color: #3A7A50; }
        .badge-homebased  { background: #FEF9E8; color: #7A5800; }
        .stc-title { font-size: .88rem; font-weight: 700; color: var(--text-dark); margin-bottom: .15rem; font-family: 'Plus Jakarta Sans', sans-serif; }
        .stc-desc  { font-size: .74rem; color: var(--text-muted); line-height: 1.45; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ MAIN GRID ══ */
        .main-grid { display: grid; grid-template-columns: 1fr 420px; gap: 1.5rem; align-items: start; }

        /* ══ SECTION LABEL ══ */
        .section-label { font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .2em; color: var(--brown-accent); margin: 1.25rem 0 .75rem; padding-bottom: .5rem; border-bottom: 1.5px solid var(--border); display: flex; align-items: center; gap: .4rem; font-family: 'Plus Jakarta Sans', sans-serif; }
        .section-label:first-child { margin-top: 0; }

        /* ══ FORM — matches customer profile sizing ══ */
        .form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .85rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group:last-child { margin-bottom: 0; }

        .form-label { display: block; font-size: .82rem; font-weight: 600; color: var(--brown-dark); margin-bottom: .4rem; font-family: 'Plus Jakarta Sans', sans-serif; }
        .form-label .req  { color: var(--brown-accent); }
        .form-label .hint { font-size: .7rem; font-weight: 400; color: var(--text-muted); margin-left: 3px; }

        /* ── Core input — same height/padding as customer profile ── */
        .form-input {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: .88rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--warm-white);
            color: var(--text-dark);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus { border-color: var(--brown-accent); box-shadow: 0 0 0 3px rgba(192,120,80,.12); }
        .form-input.is-invalid { border-color: var(--err); }
        .form-input.is-valid   { border-color: var(--success); }
        textarea.form-input { resize: vertical; min-height: 100px; }
        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%239A7A65' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .85rem center;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        .field-error { font-size: .74rem; color: var(--err); margin-top: .3rem; font-family: 'Plus Jakarta Sans', sans-serif; }
        .field-hint  { font-size: .71rem; color: var(--text-muted); margin-top: .25rem; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ PASSWORD ══ */
        .pw-wrap { position: relative; }
        .pw-wrap .form-input { padding-right: 44px; }
        .pw-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: .9rem; padding: 4px; display: flex; align-items: center; font-family: 'Plus Jakarta Sans', sans-serif; }
        .pw-toggle:hover { color: var(--brown-accent); }
        .strength-bar { height: 3px; border-radius: 4px; background: var(--border); margin-top: 6px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 4px; width: 0; transition: width .3s, background .3s; }
        .strength-label { font-size: .71rem; color: var(--text-muted); margin-top: 3px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .match-msg { font-size: .74rem; margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ FILE UPLOAD ══ */
        .file-upload-area {
            border: 2px dashed var(--border); border-radius: 10px;
            padding: .75rem .5rem; text-align: center; cursor: pointer;
            transition: all .2s; background: var(--warm-white);
            position: relative; height: 110px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .file-upload-area:hover  { border-color: var(--brown-accent); background: var(--brown-pale); }
        .file-upload-area.has-file { border-color: var(--success); background: #F0FAF3; border-style: solid; }
        .file-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; z-index: 2; }
        .file-upload-icon  { font-size: 1.1rem; margin-bottom: .15rem; flex-shrink: 0; pointer-events: none; }
        .file-upload-title { font-size: .72rem; font-weight: 600; color: var(--brown-mid); margin-bottom: .05rem; pointer-events: none; line-height: 1.2; font-family: 'Plus Jakarta Sans', sans-serif; }
        .file-upload-hint  { font-size: .62rem; color: var(--text-muted); line-height: 1.2; pointer-events: none; font-family: 'Plus Jakarta Sans', sans-serif; }
        .file-name-display { position: absolute; bottom: 6px; left: 50%; transform: translateX(-50%); width: 90%; font-size: .62rem; color: var(--success); font-weight: 600; display: none; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: center; pointer-events: none; font-family: 'Plus Jakarta Sans', sans-serif; }

        .portfolio-wrap { display: flex; flex-direction: column; }
        .portfolio-wrap .file-upload-area { flex: 1; height: auto; min-height: 120px; }

        /* ══ SPECIALTIES ══ */
        .specialties-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .4rem; }
        .specialty-check { display: flex; align-items: center; gap: .45rem; padding: .45rem .7rem; border: 1.5px solid var(--border); border-radius: 7px; cursor: pointer; transition: all .15s; font-size: .78rem; font-weight: 500; color: var(--text-muted); user-select: none; font-family: 'Plus Jakarta Sans', sans-serif; }
        .specialty-check:hover { border-color: var(--brown-accent); color: var(--brown-mid); }
        .specialty-check input { display: none; }
        .specialty-check.checked { border-color: var(--brown-accent); background: var(--brown-pale); color: var(--brown-dark); font-weight: 600; }
        .check-indicator { width: 13px; height: 13px; border: 2px solid currentColor; border-radius: 3px; display: flex; align-items: center; justify-content: center; font-size: .52rem; flex-shrink: 0; }

        /* ══ COLUMNS ══ */
        .col-left  { display: flex; flex-direction: column; }
        .right-col { display: flex; flex-direction: column; gap: 1rem; position: sticky; top: 1rem; }

        /* ══ MAP CARD ══ */
        .map-card { background: var(--warm-white); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 3px 16px rgba(92,61,46,.07); }
        .map-card-header { padding: .8rem 1rem .65rem; border-bottom: 1px solid var(--border); }
        .map-card-header h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: .92rem; font-weight: 700; color: var(--text-dark); margin-bottom: .15rem; }
        .map-card-header p  { font-size: .74rem; color: var(--text-muted); line-height: 1.45; font-family: 'Plus Jakarta Sans', sans-serif; }
        #baker-map { height: 260px; width: 100%; }
        .map-card-footer { padding: .7rem 1rem; border-top: 1px solid var(--border); }
        .btn-locate { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem .85rem; background: var(--brown-pale); border: 1.5px solid var(--border); border-radius: 7px; font-size: .75rem; font-weight: 600; color: var(--brown-mid); cursor: pointer; transition: all .15s; font-family: 'Plus Jakarta Sans', sans-serif; margin-bottom: .5rem; width: 100%; justify-content: center; }
        .btn-locate:hover { background: var(--brown-light); border-color: var(--brown-accent); color: var(--brown-dark); }
        .map-coords { font-size: .7rem; color: var(--brown-accent); font-weight: 600; margin-bottom: .3rem; display: none; font-family: 'Plus Jakarta Sans', sans-serif; }
        .map-coords.visible { display: block; }
        .map-instructions { font-size: .68rem; color: var(--text-muted); line-height: 1.45; font-family: 'Plus Jakarta Sans', sans-serif; }
        .address-field-wrap { padding: .75rem 1rem; border-top: 1px solid var(--border); }

        /* ══ DOCS CARD ══ */
        .docs-card { background: var(--warm-white); border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 3px 16px rgba(92,61,46,.07); }
        .docs-card-header { padding: .75rem 1rem; border-bottom: 1px solid var(--border); background: var(--brown-pale); }
        .docs-card-header h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: .88rem; font-weight: 700; color: var(--brown-dark); display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; }
        .docs-card-header p  { font-size: .72rem; color: var(--text-muted); margin-top: .15rem; line-height: 1.45; font-family: 'Plus Jakarta Sans', sans-serif; }
        .docs-card-body { padding: .9rem 1rem 1rem; }
        .doc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-top: .65rem; }
        .doc-grid .form-group { margin-bottom: 0; }
        .docs-type-badge { display: inline-flex; align-items: center; gap: .25rem; font-size: .58rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: .18rem .55rem; border-radius: 20px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .docs-type-badge.registered { background: #E8F4EC; color: #3A7A50; }
        .docs-type-badge.homebased  { background: #FEF9E8; color: #7A5800; }

        /* ══ HOMEBASED NOTICE ══ */
        .homebased-notice { background: #EEF6FF; border: 1px solid #BFD9F5; border-radius: 9px; padding: .7rem .85rem; margin-bottom: .75rem; display: flex; gap: .55rem; align-items: flex-start; }
        .homebased-notice-text { font-size: .76rem; color: #1E5C9B; line-height: 1.55; font-family: 'Plus Jakarta Sans', sans-serif; }
        .homebased-notice-text strong { color: #0D3D70; }

        /* ══ CONDITIONAL SECTIONS ══ */
        .section-registered, .section-homebased { display: none; }
        .section-registered.show, .section-homebased.show { display: block; }

        /* ══ ALERT ══ */
        .alert-error { background: #FDF0EE; border: 1px solid #F5C5BE; border-radius: 9px; padding: .75rem 1rem; margin-bottom: 1rem; font-size: .82rem; color: #8B2A1E; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ══ SUBMIT ══ */
        .submit-wrap { margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1.5px solid var(--border); }
        .btn-submit { width: 100%; padding: .9rem; background: linear-gradient(135deg, var(--brown-mid), var(--brown-accent)); color: #fff; border: none; border-radius: 10px; font-size: .95rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; box-shadow: 0 5px 16px rgba(123,79,58,.28); transition: all .2s; letter-spacing: .02em; }
        .btn-submit:hover { background: linear-gradient(135deg, var(--brown-accent), #D4906A); transform: translateY(-1px); }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 1200px) { .main-grid { grid-template-columns: 1fr 380px; } }
        @media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } .right-col { position: static; } }
        @media (max-width: 768px) {
            .prefilled-grid, .seller-type-toggle { grid-template-columns: 1fr; }
            .form-row, .doc-grid, .specialties-grid { grid-template-columns: 1fr; }
            .page-body { padding: 1.25rem 1rem 3rem; }
            .top-banner, .progress-wrap { padding-left: 1rem; padding-right: 1rem; }
        }
    </style>
</head>
<body>

<!-- TOP BANNER -->
<div class="top-banner">
    <div class="top-banner-left">
        <a href="{{ route('login') }}" class="btn-back-login"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back to Login</a>
        <div class="top-banner-brand">Bake<span>Sphere</span></div>
    </div>

</div>
<!-- PROGRESS STEPS -->
<div class="progress-wrap">
    <div class="progress-inner">
        <div class="step done">
            <div class="step-num"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg></div>
            <span>Google Sign-Up</span>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-num">2</div>
            <span>Complete Profile</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-num">3</div>
            <span>Admin Approval</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-num">4</div>
            <span>Start Bidding</span>
        </div>
    </div>
</div>

<!-- PAGE BODY -->
<div class="page-body">

    <div class="page-header">
        <div class="page-header-eyebrow">Step 2 of 4 &mdash; Baker Registration</div>
        <h1>Complete Your Baker Profile</h1>
        <p>Your Google account filled in your name and email. Just add your bakery details and documents below to submit your application.</p>
    </div>

    @if($errors->any())
    <div class="alert-error"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> {{ $errors->first() }}</div>
    @endif

    <div class="prefill-notice">
        <div>
            <div class="prefill-notice-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" style="display:inline-block;vertical-align:middle"><circle cx="12" cy="12" r="12" fill="#5B8F6A"/><polyline points="7 12.5 10.5 16 17 9" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Auto-filled from your Google Account &mdash; The following details are locked.</div>
            <div class="prefill-chips">
                <span class="prefill-chip"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Full Name</span>
                <span class="prefill-chip"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Email Address</span>
                <span class="prefill-chip"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Profile Photo</span>
            </div>
        </div>
    </div>

    <!-- Prefilled locked fields -->
    <div class="prefilled-grid">
        <div class="prefilled-item">
            <label>Full Name</label>
            <div class="prefilled-value">
                {{ $user->first_name }} {{ $user->last_name }}
                <span class="locked-badge"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> From Google</span>
            </div>
        </div>
        <div class="prefilled-item">
            <label>Email Address</label>
            <div class="prefilled-value">
                {{ $user->email }}
                <span class="locked-badge"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> From Google</span>
            </div>
        </div>
        <div class="prefilled-item">
            <label>Profile Photo</label>
            <div class="prefilled-value">
             
                <span class="locked-badge"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> From Google</span>
            </div>
        </div>
    </div>

    <!-- SELLER TYPE -->
    <div class="seller-type-toggle">
        <label class="seller-type-card active" id="card-registered" onclick="setSellerType('registered')">
            <input type="radio" name="_seller_type_ui" value="registered" checked>
            <span class="stc-badge badge-registered"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Verified</span>
            <div class="stc-title"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Registered Business</div>
            <div class="stc-desc">DTI/SEC registration and business permit. Higher bid limits and a Verified badge.</div>
        </label>
        <label class="seller-type-card" id="card-homebased" onclick="setSellerType('homebased')">
            <input type="radio" name="_seller_type_ui" value="homebased">
            <span class="stc-badge badge-homebased"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Home Baker</span>
            <div class="stc-title"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Home-Based Baker</div>
            <div class="stc-desc">No business permit &mdash; just a valid government ID and a selfie.</div>
        </label>
    </div>

    <form method="POST" action="{{ route('baker.complete-profile.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="seller_type" id="seller_type_input" value="registered">

        <div class="main-grid">

            <!-- LEFT COLUMN -->
            <div class="col-left">

                <!-- ── CONTACT ── -->
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.11 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 5.61 5.61l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg> Contact Details</div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Phone Number <span class="req">*</span> <span class="hint">(PH &mdash; 11 digits)</span></label>
                        <input type="text" name="phone" id="phone" class="form-input"
                               placeholder="09XXXXXXXXX" maxlength="11" inputmode="numeric"
                               value="{{ old('phone', $user->phone ?? '') }}" required>
                        <div class="field-error" id="phone_err" style="display:none;"></div>
                        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birthdate <span class="req">*</span></label>
                        <input type="date" name="birthdate" class="form-input"
                               value="{{ old('birthdate') }}" required>
                        <div class="field-hint">Must be 18 years old or older.</div>
                        @error('birthdate') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- ── PASSWORD ── -->
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Set Your Password</div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="password" class="form-input" required placeholder="Min. 8 characters">
                            <button type="button" class="pw-toggle" onclick="togglePw('password', this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                        <div class="strength-label" id="strengthLabel"></div>
                        @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required placeholder="Repeat password">
                            <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                        <div class="match-msg" id="pw_match_msg"></div>
                    </div>
                </div>

                <!-- ── BAKERY INFO ── -->
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Bakery Information</div>

                <div class="form-group">
                    <label class="form-label">Cake Shop / Brand Name <span class="req">*</span></label>
                    <input type="text" name="shop_name" class="form-input"
                           value="{{ old('shop_name') }}" placeholder="e.g. Sweet Dreams Bakery" required>
                    @error('shop_name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

            <div class="form-group">
                    <label class="form-label">Years of Experience <span class="req">*</span></label>
                    <select name="experience_years" class="form-input" required>
                        <option value="">Select...</option>
                        <option value="less_than_1" {{ old('experience_years')=='less_than_1'?'selected':'' }}>Less than 1 year</option>
                        <option value="1-2"  {{ old('experience_years')=='1-2' ?'selected':'' }}>1&ndash;2 years</option>
                        <option value="3-5"  {{ old('experience_years')=='3-5' ?'selected':'' }}>3&ndash;5 years</option>
                        <option value="5-10" {{ old('experience_years')=='5-10'?'selected':'' }}>5&ndash;10 years</option>
                        <option value="10+"  {{ old('experience_years')=='10+' ?'selected':'' }}>10+ years</option>
                    </select>
                    @error('experience_years') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Social Media / Online Shop <span class="hint">(optional but recommended)</span></label>
                    <input type="url" name="social_media" class="form-input"
                           value="{{ old('social_media') }}" placeholder="https://facebook.com/yourbakery">
                    <div class="field-hint">Helps customers find and trust your shop.</div>
                    @error('social_media') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <!-- ── BAKER PROFILE ── -->
                <div class="section-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none" style="display:inline-block;vertical-align:middle"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> Baker Profile</div>

                <div class="form-group">
                    <label class="form-label">Short Bio <span class="hint">(optional)</span></label>
                    <textarea name="bio" class="form-input"
                              placeholder="Tell customers about your baking style, what makes you unique, and your most popular creations&hellip;">{{ old('bio') }}</textarea>
                    @error('bio') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <!-- Portfolio + Specialties side by side -->
                <div class="form-row">
                        <div class="form-group portfolio-wrap">
                        <label class="form-label">Cake Designs <span class="hint">(up to 3 photos) You can upload more later.</span></label>
                        <div class="file-upload-area" id="portfolio-area" style="height:auto;min-height:130px;cursor:pointer;">
                            <input type="file" name="portfolio[]" accept=".jpg,.jpeg,.png" multiple onchange="handlePortfolio(this)" style="z-index:4;">
                            <div id="portfolio-empty-state">
                                <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg></div>
                                <div class="file-upload-title">Upload Cake Designs</div>
                                <div class="file-upload-hint">JPG or PNG · Max 5MB each · Up to 3</div>
                            </div>
                          <div id="portfolio-preview-grid" style="display:none;width:100%;padding:8px;pointer-events:none;"></div>
                            <div class="file-name-display" id="portfolio-names" style="position:relative;transform:none;width:100%;margin-top:4px;bottom:auto;left:auto;"></div>
                        </div>
                        @error('portfolio') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Specialties <span class="hint">(select all that apply)</span></label>
                        <div class="specialties-grid">
                            @php $oldSpecs = old('specialties', []); @endphp
                            @foreach(['Wedding Cakes','Birthday Cakes','Fondant Art','Cupcakes','Macarons','Cheesecakes','Custom Designs','Vegan Cakes','Gluten-Free','Chocolate Cakes','Pastries','Tarts'] as $spec)
                            <label class="specialty-check {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}">
                                <input type="checkbox" name="specialties[]" value="{{ $spec }}" {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}>
                                <span class="check-indicator">{{ in_array($spec, $oldSpecs) ? '<svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>' : '' }}</span>
                                {{ $spec }}
                            </label>
                            @endforeach
                        </div>
                        @error('specialties') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- ── SUBMIT ── -->
                <div class="submit-wrap">
                    <button type="submit" class="btn-submit"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v2"/><path d="M12 8v2"/><path d="M17 8v2"/></svg> Submit Baker Application <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></button>
                </div>

            </div><!-- end col-left -->

            <!-- RIGHT COLUMN -->
            <div class="right-col">

                <!-- Map Card -->
                <div class="map-card">
                    <div class="map-card-header">
                        <h3><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Pin Your Bakery Location</h3>
                        <p>Click the map or use your current location so customers know how far you are.</p>
                    </div>
                    <div id="baker-map"></div>
                    <div class="map-card-footer">
                        <button type="button" class="btn-locate" onclick="locateMe()"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg> Use My Current Location</button>
                        <div class="map-coords" id="map-coords"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Pinned: <span id="coords-display"></span></div>
                        <div class="map-instructions"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M4 4l7.07 17 2.51-7.39L21 11.07z"/></svg> Click the map to place your pin, or drag to fine-tune.</div>
                    </div>
                    <div class="address-field-wrap">
                        <label class="form-label">Full Address</label>
                        <input type="text" name="full_address" id="display-address" class="form-input"
                               value="{{ old('full_address') }}"
                               placeholder="Auto-fills when you pin, or type manually">
                        @error('full_address') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <input type="hidden" name="latitude"  id="input-lat"  value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="input-lng"  value="{{ old('longitude') }}">
                <input type="hidden" name="address"   id="input-addr" value="{{ old('address') }}">
                @error('latitude') <div class="field-error" style="margin-top:.5rem;">Please pin your location on the map.</div> @enderror

                <!-- Registered Business Docs -->
                <div class="section-registered show" id="section-registered">
                    <div class="docs-card">
                        <div class="docs-card-header">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg> Business Documents <span class="docs-type-badge registered"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><polyline points="20 6 9 17 4 12"/></svg> Registered</span></h3>
                            <p>Upload your DTI/SEC, business permit, and sanitary permit.</p>
                        </div>
                        <div class="docs-card-body">
                            <div class="form-group">
                                <label class="form-label">DTI or SEC Registration Number <span class="req">*</span></label>
                                <input type="text" name="dti_sec_number" class="form-input"
                                       value="{{ old('dti_sec_number') }}" placeholder="e.g. DTI-0001234">
                                @error('dti_sec_number') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="doc-grid">
                                <div class="form-group">
                                    <label class="form-label">Business Permit <span class="req">*</span></label>
                                    <div class="file-upload-area" id="permit-area">
                                        <input type="file" name="business_permit" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'permit-area','permit-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                        <div class="file-upload-title">Mayor's Permit</div>
                                        <div class="file-upload-hint">JPG, PNG, PDF &middot; Max 5MB</div>
                                        <div class="file-name-display" id="permit-name"></div>
                                    </div>
                                    @error('business_permit') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">DTI / SEC Certificate <span class="req">*</span></label>
                                    <div class="file-upload-area" id="dti-area">
                                        <input type="file" name="dti_certificate" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'dti-area','dti-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
                                        <div class="file-upload-title">DTI / SEC Cert</div>
                                        <div class="file-upload-hint">JPG, PNG, PDF &middot; Max 5MB</div>
                                        <div class="file-name-display" id="dti-name"></div>
                                    </div>
                                    @error('dti_certificate') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Sanitary Permit <span class="req">*</span></label>
                                    <div class="file-upload-area" id="sanitary-area">
                                        <input type="file" name="sanitary_permit" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'sanitary-area','sanitary-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                                        <div class="file-upload-title">Sanitary Permit</div>
                                        <div class="file-upload-hint">Max 5MB</div>
                                        <div class="file-name-display" id="sanitary-name"></div>
                                    </div>
                                    @error('sanitary_permit') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">BIR COR <span class="hint">(optional)</span></label>
                                    <div class="file-upload-area" id="bir-area">
                                        <input type="file" name="bir_certificate" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'bir-area','bir-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
                                        <div class="file-upload-title">BIR Certificate</div>
                                        <div class="file-upload-hint">Max 5MB</div>
                                        <div class="file-name-display" id="bir-name"></div>
                                    </div>
                                    @error('bir_certificate') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Home-Based Baker Docs -->
                <div class="section-homebased" id="section-homebased">
                    <div class="docs-card">
                        <div class="docs-card-header">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Home Baker Verification <span class="docs-type-badge homebased"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Home Baker</span></h3>
                            <p>No business permit needed &mdash; just a valid ID and a selfie.</p>
                        </div>
                        <div class="docs-card-body">
                            <div class="homebased-notice">
                                <div class="homebased-notice-text"><strong>No business permit required.</strong> Submit a government ID and selfie to get your Home Baker badge.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Government ID Type <span class="req">*</span></label>
                                <select name="gov_id_type" class="form-input">
                                    <option value="">Select ID type...</option>
                                    <option value="national_id">Philippine National ID (PhilSys)</option>
                                    <option value="passport">Philippine Passport</option>
                                    <option value="drivers_license">Driver's License</option>
                                    <option value="sss">SSS ID</option>
                                    <option value="philhealth">PhilHealth ID</option>
                                    <option value="voters_id">Voter's ID</option>
                                    <option value="postal_id">Postal ID</option>
                                    <option value="prc_id">PRC ID</option>
                                </select>
                                @error('gov_id_type') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="doc-grid">
                                <div class="form-group">
                                    <label class="form-label">Gov't ID &mdash; Front <span class="req">*</span></label>
                                    <div class="file-upload-area" id="id-front-area">
                                        <input type="file" name="gov_id_front" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'id-front-area','id-front-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="12" r="2.5"/><line x1="13" y1="10" x2="20" y2="10"/><line x1="13" y1="14" x2="20" y2="14"/></svg></div>
                                        <div class="file-upload-title">Front of ID</div>
                                        <div class="file-upload-hint">Clear photo &middot; JPG/PNG</div>
                                        <div class="file-name-display" id="id-front-name"></div>
                                    </div>
                                    @error('gov_id_front') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gov't ID &mdash; Back <span class="hint">(if applicable)</span></label>
                                    <div class="file-upload-area" id="id-back-area">
                                        <input type="file" name="gov_id_back" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'id-back-area','id-back-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="12" r="2.5"/><line x1="13" y1="10" x2="20" y2="10"/><line x1="13" y1="14" x2="20" y2="14"/></svg></div>
                                        <div class="file-upload-title">Back of ID</div>
                                        <div class="file-upload-hint">Clear photo &middot; JPG/PNG</div>
                                        <div class="file-name-display" id="id-back-name"></div>
                                    </div>
                                    @error('gov_id_back') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Selfie with ID <span class="req">*</span></label>
                                    <div class="file-upload-area" id="selfie-area">
                                        <input type="file" name="id_selfie" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'selfie-area','selfie-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><circle cx="12" cy="7" r="4"/><path d="M4 21v-1a8 8 0 0 1 16 0v1"/></svg></div>
                                        <div class="file-upload-title">Selfie Holding ID</div>
                                        <div class="file-upload-hint">Hold ID beside your face</div>
                                        <div class="file-name-display" id="selfie-name"></div>
                                    </div>
                                    @error('id_selfie') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Food Safety Cert <span class="hint">(optional)</span></label>
                                    <div class="file-upload-area" id="food-area">
                                        <input type="file" name="food_safety_cert" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'food-area','food-name')">
                                        <div class="file-upload-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                                        <div class="file-upload-title">Food Safety Cert</div>
                                        <div class="file-upload-hint">Max 5MB</div>
                                        <div class="file-name-display" id="food-name"></div>
                                    </div>
                                    @error('food_safety_cert') <div class="field-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- end right-col -->
        </div><!-- end main-grid -->
    </form>
</div><!-- end page-body -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    /* Seller type toggle */
    function setSellerType(type) {
        document.getElementById('seller_type_input').value = type;
        document.getElementById('card-registered').classList.toggle('active', type === 'registered');
        document.getElementById('card-homebased').classList.toggle('active', type === 'homebased');
        document.getElementById('section-registered').classList.toggle('show', type === 'registered');
        document.getElementById('section-homebased').classList.toggle('show', type === 'homebased');
    }

    /* Specialty checkboxes */
    document.querySelectorAll('.specialty-check').forEach(function(label) {
        label.addEventListener('click', function() {
            var input = this.querySelector('input');
            var ind   = this.querySelector('.check-indicator');
            setTimeout(function() {
                label.classList.toggle('checked', input.checked);
                ind.textContent = input.checked ? '<svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>' : '';
            }, 0);
        });
    });

   function handleFile(input, areaId, nameId) {
        var area   = document.getElementById(areaId);
        var nameEl = document.getElementById(nameId);
        if (input.files && input.files[0]) {
            var file = input.files[0];
            area.classList.add('has-file');
            nameEl.style.display = 'block';
            nameEl.textContent   = '✓ ' + file.name;
            var prevId = areaId + '-img-prev';
            var prevEl = document.getElementById(prevId);
            if (file.type.indexOf('image/') === 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (!prevEl) {
                        prevEl = document.createElement('img');
                        prevEl.id = prevId;
                        prevEl.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:8px;opacity:0.92;z-index:1;pointer-events:none;';
                        area.appendChild(prevEl);
                    }
                    prevEl.src = e.target.result;
                    nameEl.style.zIndex = '3';
                    nameEl.style.background = 'rgba(0,0,0,0.45)';
                    nameEl.style.color = '#fff';
                    nameEl.style.borderRadius = '20px';
                    nameEl.style.padding = '2px 10px';
                    nameEl.style.bottom = '8px';
                };
                reader.readAsDataURL(file);
            } else {
                if (prevEl) prevEl.remove();
            }
        }
    }
/* Portfolio — accumulates up to 3 files across multiple picks */
(function () {
    var dt = new DataTransfer();

    function renderGrid() {
        var area       = document.getElementById('portfolio-area');
        var nameEl     = document.getElementById('portfolio-names');
        var grid       = document.getElementById('portfolio-preview-grid');
        var emptyState = document.getElementById('portfolio-empty-state');
        var files      = Array.from(dt.files);

        area.classList.toggle('has-file', files.length > 0);
        grid.innerHTML = '';
        grid.style.display = 'grid';
        grid.style.gridTemplateColumns = 'repeat(3, 1fr)';
        grid.style.gap = '6px';
        emptyState.style.display = files.length > 0 ? 'none' : '';
        nameEl.style.display = files.length > 0 ? 'block' : 'none';
        nameEl.textContent = files.length > 0 ? '✓ ' + files.length + ' of 3 photo(s) selected' : '';

        for (var i = 0; i < 3; i++) {
            (function (idx) {
                var wrap = document.createElement('div');
                wrap.style.cssText = 'position:relative;border-radius:8px;overflow:hidden;aspect-ratio:1;flex-shrink:0;';

                if (files[idx]) {
                    wrap.style.background = '#eee';
                    /* Remove button */
                    var removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.textContent = '✕';
                    removeBtn.style.cssText = 'position:absolute;top:4px;right:4px;z-index:5;width:20px;height:20px;border-radius:50%;border:none;background:rgba(0,0,0,0.55);color:#fff;font-size:.65rem;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;padding:0;';
                    (function (capturedIdx, capturedBtn) {
                        capturedBtn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            var newDt = new DataTransfer();
                            Array.from(dt.files).forEach(function (f, fi) { if (fi !== capturedIdx) newDt.items.add(f); });
                            while (dt.items.length) dt.items.remove(0);
                            Array.from(newDt.files).forEach(function (f) { dt.items.add(f); });
                            document.querySelector('[name="portfolio[]"]').files = dt.files;
                            renderGrid();
                        });
                    })(idx, removeBtn);

                    var reader = new FileReader();
                    (function (capturedWrap, capturedRemoveBtn) {
                        reader.onload = function (e) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
                            capturedWrap.appendChild(img);
                            capturedWrap.appendChild(capturedRemoveBtn);
                        };
                    })(wrap, removeBtn);
                    reader.readAsDataURL(files[idx]);
                } else {
                    wrap.style.cssText += 'background:rgba(0,0,0,0.05);border:2px dashed rgba(0,0,0,0.12);display:flex;align-items:center;justify-content:center;cursor:pointer;';
                    wrap.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3;pointer-events:none;display:block;margin:auto;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>';
                    wrap.addEventListener('click', function (e) {
                        e.stopPropagation();
                        document.querySelector('[name="portfolio[]"]').click();
                    });
                }

                grid.appendChild(wrap);
            })(i);
        }
    }

    window.handlePortfolio = function (input) {
        if (!input.files || input.files.length === 0) return;
        Array.from(input.files).forEach(function (f) {
            if (dt.files.length < 3) dt.items.add(f);
        });
        input.files = dt.files;
        renderGrid();
    };
})();
    /* Phone validation */
    var phoneInput = document.getElementById('phone');
    var phoneErr   = document.getElementById('phone_err');
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });
    phoneInput.addEventListener('blur', function() {
        if (this.value.length > 0 && this.value.length !== 11) {
            phoneErr.textContent = 'Must be exactly 11 digits (e.g. 09XXXXXXXXX).';
            phoneErr.style.display = 'block';
            this.classList.add('is-invalid');
        } else {
            phoneErr.style.display = 'none';
            this.classList.remove('is-invalid');
        }
    });

    /* Birthdate 18+ */
    var bd = document.querySelector('input[name="birthdate"]');
    if (bd) {
        var today = new Date();
        var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        bd.setAttribute('max', maxDate.toISOString().split('T')[0]);
        bd.addEventListener('change', function() {
            if (new Date(this.value) > maxDate) this.classList.add('is-invalid');
            else this.classList.remove('is-invalid');
        });
    }

    /* Password strength */
    var pw   = document.getElementById('password');
    var fill = document.getElementById('strengthFill');
    var slabel = document.getElementById('strengthLabel');
    pw.addEventListener('input', function() {
        var v = this.value; var s = 0;
        if (v.length >= 8) s++;
        if (/[A-Z]/.test(v)) s++;
        if (/[0-9]/.test(v)) s++;
        if (/[^A-Za-z0-9]/.test(v)) s++;
        fill.style.width      = (s / 4 * 100) + '%';
        fill.style.background = ['#E53935','#FB8C00','#FDD835','#43A047'][s - 1] || 'transparent';
        slabel.textContent    = s > 0 ? ['Weak','Fair','Good','Strong'][s - 1] : '';
        checkMatch();
    });

    /* Password match */
    var pwc      = document.getElementById('password_confirmation');
    var matchMsg = document.getElementById('pw_match_msg');
    function checkMatch() {
        if (!pwc.value) { matchMsg.textContent = ''; pwc.classList.remove('is-invalid','is-valid'); return; }
        if (pw.value === pwc.value) {
            matchMsg.textContent   = '✓ Passwords match';
            matchMsg.style.color   = 'var(--success)';
            pwc.classList.remove('is-invalid'); pwc.classList.add('is-valid');
        } else {
            matchMsg.textContent   = '✕ Passwords do not match';
            matchMsg.style.color   = 'var(--err)';
            pwc.classList.remove('is-valid'); pwc.classList.add('is-invalid');
        }
    }
    pwc.addEventListener('input', checkMatch);
         function togglePw(id, btn) {
            var f = document.getElementById(id);
            if (f.type === 'password') { f.type = 'text';     btn.textContent = 'Hide'; }
            else                       { f.type = 'password'; btn.textContent = 'Show'; }
        }

    /* Leaflet map */
    var map = L.map('baker-map').setView([14.5995, 120.9842], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap', maxZoom: 19
    }).addTo(map);

    var brownIcon = L.divIcon({
        html: '<div style="width:26px;height:26px;background:linear-gradient(135deg,#7B4F3A,#C07850);border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.35);"></div>',
        iconSize: [26,26], iconAnchor: [13,26], className: ''
    });

    var marker = null;

    // Restore pinned location on back-navigation
    var oldLat = '{{ old("latitude") }}';
    var oldLng = '{{ old("longitude") }}';
    if (oldLat && oldLng) {
        placeMarker(parseFloat(oldLat), parseFloat(oldLng));
        map.setView([parseFloat(oldLat), parseFloat(oldLng)], 15);
    }

    map.on('click', function(e) { placeMarker(e.latlng.lat, e.latlng.lng); });

    function placeMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { icon: brownIcon, draggable: true }).addTo(map);
            marker.on('dragend', function() {
                var p = marker.getLatLng();
                updateCoords(p.lat, p.lng);
                reverseGeocode(p.lat, p.lng);
            });
        }
        updateCoords(lat, lng);
        reverseGeocode(lat, lng);
    }

    function updateCoords(lat, lng) {
        document.getElementById('input-lat').value = lat.toFixed(7);
        document.getElementById('input-lng').value = lng.toFixed(7);
        var b = document.getElementById('map-coords');
        b.classList.add('visible');
        document.getElementById('coords-display').textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
    }

    function reverseGeocode(lat, lng) {
        fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng)
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (d && d.display_name) {
                    document.getElementById('display-address').value = d.display_name;
                    document.getElementById('input-addr').value      = d.display_name;
                }
            })
            .catch(function() {});
    }

    function locateMe() {
        if (!navigator.geolocation) { alert('Geolocation not supported.'); return; }
        navigator.geolocation.getCurrentPosition(
            function(p) {
                map.setView([p.coords.latitude, p.coords.longitude], 16);
                placeMarker(p.coords.latitude, p.coords.longitude);
            },
            function() { alert('Could not get your location. Please pin manually.'); }
        );
    }
</script>
</body>
</html>