<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join as Baker — BakeSphere</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        html, body { min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--cream); color: var(--text-dark); }
        .page-wrap { display: grid; grid-template-columns: 300px 1fr; min-height: 100vh; }

        /* SIDEBAR */
        .left-panel {
            background: linear-gradient(160deg, #3D2314 0%, #6B3A22 60%, #8B4E2E 100%);
            padding: 2.5rem 1.75rem;
            display: flex; flex-direction: column;
            position: sticky; top: 0; height: 100vh; overflow: hidden;
        }
        .left-panel::before { content:''; position:absolute; top:-80px; right:-80px; width:240px; height:240px; border-radius:50%; background:var(--brown-accent); opacity:.12; }
        .left-panel::after  { content:''; position:absolute; bottom:-60px; left:-40px; width:180px; height:180px; border-radius:50%; background:var(--brown-light); opacity:.08; }
        .brand { margin-bottom: 2rem; position: relative; z-index: 1; display:flex; align-items:center; gap:.75rem; }
        .brand-icon { font-size: 1.8rem; line-height:1; }
        .brand-name { font-family: 'Plus Jakarta Sans', sans-serif;font-size: 1.2rem; color: var(--brown-light); line-height:1.2; }
        .brand-sub { font-size: .62rem; letter-spacing: .18em; text-transform: uppercase; color: rgba(255,255,255,.3); margin-top: .2rem; }
        .panel-heading { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; color: #fff; line-height: 1.3; margin-bottom: .6rem; position: relative; z-index: 1; }
        .panel-sub { font-size: .82rem; color: rgba(255,255,255,.5); line-height: 1.7; margin-bottom: 1.75rem; position: relative; z-index: 1; }
        .perks { list-style: none; position: relative; z-index: 1; }
        .perks li { display:flex; align-items:flex-start; gap:.65rem; padding:.65rem 0; border-bottom:1px solid rgba(255,255,255,.07); font-size:.79rem; color:rgba(255,255,255,.52); line-height:1.5; }
        .perks li:last-child { border-bottom: none; }
        .perk-icon { width:28px; height:28px; border-radius:7px; background:rgba(255,255,255,.08); display:flex; align-items:center; justify-content:center; font-size:.85rem; flex-shrink:0; }
        .perk-title { font-weight:600; color:rgba(255,255,255,.88); margin-bottom:.1rem; font-size:.8rem; }
        .already-link { margin-top:auto; position:relative; z-index:1; padding-top:1.25rem; border-top:1px solid rgba(255,255,255,0.1); display:flex; flex-direction:column; gap:.5rem; }
        .already-link a { display:inline-flex; align-items:center; gap:.4rem; padding:.55rem 1rem; border-radius:8px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.06); color:var(--brown-light); text-decoration:none; font-size:.8rem; font-weight:600; transition:all .2s; }
        .already-link a:hover { background:rgba(255,255,255,0.12); border-color:rgba(255,255,255,0.25); color:#fff; }
        .already-link-label { font-size:.68rem; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:.12em; margin-bottom:.25rem; }

        /* RIGHT PANEL */
        .right-panel { overflow-y: auto; padding: 3rem 3.5rem 5rem; }
        .form-header { margin-bottom: 2rem; }
        .form-header-eyebrow { font-size:.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.14em; color:var(--brown-accent); margin-bottom:.5rem; }
        .form-header h1 { font-family: 'Plus Jakarta Sans', sans-serif;font-size:2rem; color:var(--text-dark); margin-bottom:.5rem; line-height:1.2; }
        .form-header p { font-size:.9rem; color:var(--text-muted); line-height:1.65; }

        /* SELLER TYPE */
        .seller-type-toggle { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:2rem; }
        .seller-type-card { border:2px solid var(--border); border-radius:14px; padding:1.1rem 1.2rem; cursor:pointer; transition:all .2s; background:var(--warm-white); position:relative; display:block; }
        .seller-type-card:hover { border-color:var(--brown-accent); background:var(--brown-pale); }
        .seller-type-card.active { border-color:var(--brown-accent); background:var(--brown-pale); box-shadow:0 4px 16px rgba(192,120,80,.15); }
        .seller-type-card input[type=radio] { display:none; }
        .stc-badge { position:absolute; top:10px; right:10px; font-size:.6rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; padding:2px 7px; border-radius:20px; }
        .badge-registered { background:#E8F4EC; color:#3A7A50; }
        .badge-homebased { background:#FEF9E8; color:#7A5800; }
        .stc-icon { font-size:1.6rem; margin-bottom:.4rem; }
        .stc-title { font-size:.95rem; font-weight:700; color:var(--text-dark); margin-bottom:.2rem; }
        .stc-desc { font-size:.78rem; color:var(--text-muted); line-height:1.5; }

        /* CONTENT GRID */
        .content-grid { display:grid; grid-template-columns:1fr 400px; gap:3rem; align-items:start; }

        /* SECTION LABELS */
        .section-label { font-size:.64rem; font-weight:700; text-transform:uppercase; letter-spacing:.2em; color:var(--brown-accent); margin:2rem 0 1.1rem; padding-bottom:.6rem; border-bottom:1.5px solid var(--border); display:flex; align-items:center; gap:.4rem; }

        /* FORM ELEMENTS */
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        .form-group { margin-bottom:1.2rem; }
        .form-label { display:block; font-size:.82rem; font-weight:600; color:var(--brown-dark); margin-bottom:.45rem; }
        .form-label .req { color:var(--brown-accent); }
        .form-label .hint { font-size:.72rem; font-weight:400; color:var(--text-muted); margin-left:4px; }
        .form-input { width:100%; padding:.75rem 1rem; border:1.5px solid var(--border); border-radius:10px; font-size:.9rem; font-family:'Plus Jakarta Sans',sans-serif; background:var(--warm-white); color:var(--text-dark); outline:none; transition:border-color .2s, box-shadow .2s; }
        .form-input:focus { border-color:var(--brown-accent); box-shadow:0 0 0 3px rgba(192,120,80,.12); }
        .form-input.is-invalid { border-color:var(--err); }
        .form-input.is-valid { border-color:var(--success); }
        textarea.form-input { resize:vertical; min-height:90px; }
        select.form-input { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%239A7A65' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 1rem center; }

        /* PASSWORD */
        .pw-wrap { position:relative; }
        .pw-wrap .form-input { padding-right:46px; }
        .pw-toggle { position:absolute; right:13px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); font-size:1rem; padding:4px; display:flex; align-items:center; }
        .pw-toggle:hover { color:var(--brown-accent); }
        .strength-bar { height:4px; border-radius:4px; background:var(--border); margin-top:8px; overflow:hidden; }
        .strength-fill { height:100%; border-radius:4px; width:0; transition:width .3s,background .3s; }
        .strength-label { font-size:.72rem; color:var(--text-muted); margin-top:4px; }
        .match-msg { font-size:.75rem; margin-top:5px; }

        /* FIELD MESSAGES */
        .field-error { font-size:.75rem; color:var(--err); margin-top:.35rem; }
        .field-hint  { font-size:.72rem; color:var(--text-muted); margin-top:.3rem; }

        /* FILE UPLOAD */
        .file-upload-area { border:2px dashed var(--border); border-radius:12px; padding:1.25rem .75rem; text-align:center; cursor:pointer; transition:all .2s; background:var(--warm-white); position:relative; }
        .file-upload-area:hover { border-color:var(--brown-accent); background:var(--brown-pale); }
        .file-upload-area.has-file { border-color:var(--success); background:#F0FAF3; }
        .file-upload-area input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
        .file-upload-icon { font-size:1.4rem; margin-bottom:.3rem; }
        .file-upload-title { font-size:.8rem; font-weight:600; color:var(--brown-mid); margin-bottom:.15rem; }
        .file-upload-hint { font-size:.7rem; color:var(--text-muted); line-height:1.4; }
       /* AFTER */
.file-name-display {
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    font-size: .72rem;
    color: var(--success);
    font-weight: 600;
    display: none;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-align: center;
    pointer-events: none;
}

        /* SPECIALTIES */
        .specialties-grid { display:grid; grid-template-columns:1fr 1fr; gap:.5rem; }
        .specialty-check { display:flex; align-items:center; gap:.5rem; padding:.5rem .8rem; border:1.5px solid var(--border); border-radius:8px; cursor:pointer; transition:all .15s; font-size:.82rem; font-weight:500; color:var(--text-muted); user-select:none; }
        .specialty-check:hover { border-color:var(--brown-accent); color:var(--brown-mid); }
        .specialty-check input { display:none; }
        .specialty-check.checked { border-color:var(--brown-accent); background:var(--brown-pale); color:var(--brown-dark); font-weight:600; }
        .check-indicator { width:14px; height:14px; border:2px solid currentColor; border-radius:3px; display:flex; align-items:center; justify-content:center; font-size:.55rem; flex-shrink:0; }

        /* NOTICES */
        .approval-notice { background:#FEF9E8; border:1px solid #F0D4B0; border-radius:12px; padding:1rem 1.2rem; margin-bottom:2rem; display:flex; gap:.75rem; align-items:flex-start; }
        .approval-notice-icon { font-size:1.2rem; flex-shrink:0; }
        .approval-notice-text { font-size:.83rem; color:#9B7A10; line-height:1.65; }
        .approval-notice-text strong { color:#7A5800; }
        .homebased-notice { background:#EEF6FF; border:1px solid #BFD9F5; border-radius:12px; padding:.9rem 1rem; margin-bottom:1rem; display:flex; gap:.65rem; align-items:flex-start; }
        .homebased-notice-icon { font-size:1rem; flex-shrink:0; margin-top:.1rem; }
        .homebased-notice-text { font-size:.8rem; color:#1E5C9B; line-height:1.6; }
        .homebased-notice-text strong { color:#0D3D70; }
        .alert-error { background:#FDF0EE; border:1px solid #F5C5BE; border-radius:10px; padding:.85rem 1.1rem; margin-bottom:1.5rem; font-size:.85rem; color:#8B2A1E; }

.map-column { display:flex; flex-direction:column; gap:0; position:sticky; top:2rem; padding-top:0; }
        .map-card { background:var(--warm-white); border:1.5px solid var(--border); border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(92,61,46,.08); }
        .map-card-header { padding:1rem 1.25rem .75rem; border-bottom:1px solid var(--border); }
        .map-card-header h3 {font-family: 'Plus Jakarta Sans', sans-serif; font-size:1rem; color:var(--text-dark); margin-bottom:.2rem; }
        .map-card-header p { font-size:.78rem; color:var(--text-muted); line-height:1.55; }
        #baker-map { height:280px; width:100%; }
        .map-card-footer { padding:.85rem 1.25rem; border-top:1px solid var(--border); }
        .btn-locate { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem .9rem; background:var(--brown-pale); border:1.5px solid var(--border); border-radius:8px; font-size:.78rem; font-weight:600; color:var(--brown-mid); cursor:pointer; transition:all .15s; font-family:'Plus Jakarta Sans',sans-serif; margin-bottom:.6rem; width:100%; justify-content:center; }
        .btn-locate:hover { background:var(--brown-light); border-color:var(--brown-accent); color:var(--brown-dark); }
        .map-coords { font-size:.74rem; color:var(--brown-accent); font-weight:600; margin-bottom:.4rem; display:none; }
        .map-coords.visible { display:block; }
        .map-instructions { font-size:.72rem; color:var(--text-muted); line-height:1.5; }
        .address-field-wrap { padding:.9rem 1.25rem 1.1rem; border-top:1px solid var(--border); }

        /* DOCS CARD — below map */
        .docs-card { background:var(--warm-white); border:1.5px solid var(--border); border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(92,61,46,.08); margin-top:1.25rem; }
        .docs-card-header { padding:.9rem 1.25rem; border-bottom:1px solid var(--border); background:var(--brown-pale); }
        .docs-card-header h3 {font-family: 'Plus Jakarta Sans', sans-serif;font-size:.95rem; color:var(--brown-dark); display:flex; align-items:center; gap:.4rem; }
        .docs-card-header p { font-size:.75rem; color:var(--text-muted); margin-top:.2rem; line-height:1.5; }
    .docs-card-body { padding:1.1rem 1.25rem 1.25rem; }
        .docs-card-body .form-group { margin-bottom: 1rem; }
        .docs-card-body .form-group:last-child { margin-bottom: 0; }
        .docs-card-body .doc-grid { margin-top: 0; }
        .docs-card-body select.form-input { margin-bottom: 0; }

.doc-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-top:.75rem; }
        .doc-grid .form-group { margin-bottom:0 !important; }

        .docs-card .doc-grid { margin-top: 0.75rem; }
        .docs-card .homebased-notice { margin-bottom: 1rem; }
        .docs-card .form-group:last-child { margin-bottom: 0; }

        /* CONDITIONAL SECTIONS — must come after doc-grid rules */
        .section-registered, .section-homebased { display:none; margin-top: 1.25rem; }
        .section-registered.show, .section-homebased.show { display:block; }

        /* REGISTERED BADGE vs HOMEBASED BADGE on docs card */

        /* REGISTERED BADGE vs HOMEBASED BADGE on docs card */
        .docs-type-badge { display:inline-flex; align-items:center; gap:.3rem; font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; padding:.2rem .6rem; border-radius:20px; margin-left:.5rem; }
        .docs-type-badge.registered { background:#E8F4EC; color:#3A7A50; }
        .docs-type-badge.homebased { background:#FEF9E8; color:#7A5800; }

        /* SUBMIT */
        .submit-wrap { margin-top:2rem; padding-top:1.5rem; border-top:1.5px solid var(--border); }
        .btn-submit { width:100%; padding:.95rem; background:linear-gradient(135deg,var(--brown-mid),var(--brown-accent)); color:#fff; border:none; border-radius:12px; font-size:1rem; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; box-shadow:0 6px 20px rgba(123,79,58,.3); transition:all .2s; letter-spacing:.02em; }
        .btn-submit:hover { background:linear-gradient(135deg,var(--brown-accent),#D4906A); transform:translateY(-1px); box-shadow:0 8px 24px rgba(123,79,58,.42); }
        .login-link { text-align:center; margin-top:1.25rem; font-size:.82rem; color:var(--text-muted); }
        .login-link a { color:var(--brown-accent); text-decoration:none; font-weight:600; }
        .login-link a:hover { text-decoration:underline; }

        @media (max-width:1100px) { .content-grid { grid-template-columns:1fr; } .map-column { position:static; } }
        @media (max-width:768px) { .page-wrap { grid-template-columns:1fr; } .left-panel { display:none; } .right-panel { padding:2rem 1.5rem 4rem; } .seller-type-toggle,.form-row,.doc-grid { grid-template-columns:1fr; } }
        /* CONFIRMATION MODAL */
.modal-overlay {
    position: fixed; inset: 0; background: rgba(45,26,14,.55);
    backdrop-filter: blur(4px); z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem; opacity: 0; pointer-events: none; transition: opacity .25s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }
.modal-box {
    background: var(--warm-white); border-radius: 20px;
    border: 1.5px solid var(--border); width: 100%; max-width: 620px;
    max-height: 88vh; overflow-y: auto;
    box-shadow: 0 24px 64px rgba(45,26,14,.22);
    transform: translateY(16px); transition: transform .25s;
}
.modal-overlay.open .modal-box { transform: translateY(0); }
.modal-head {
    padding: 1.25rem 1.5rem 1rem;
    border-bottom: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; background: var(--warm-white); z-index: 2;
    border-radius: 20px 20px 0 0;
}
.modal-head h2 { font-family: 'Plus Jakarta Sans', sans-serif;font-size: 1.15rem; color: var(--text-dark); }
.modal-close {
    width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid var(--border);
    background: none; cursor: pointer; font-size: 1rem; color: var(--text-muted);
    display: flex; align-items: center; justify-content: center; transition: all .15s;
}
.modal-close:hover { background: var(--brown-pale); border-color: var(--brown-accent); color: var(--brown-dark); }
.modal-body { padding: 1.25rem 1.5rem 1.5rem; }
.modal-section { margin-bottom: 1.25rem; }
.modal-section-title {
    font-size: .6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .18em; color: var(--brown-accent);
    padding-bottom: .4rem; border-bottom: 1.5px solid var(--border);
    margin-bottom: .75rem;
}
.modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
.modal-item { background: var(--brown-pale); border-radius: 8px; padding: .55rem .75rem; }
.modal-item.missing { background: #FDF0EE; border: 1.5px solid #F5C5BE; }
.modal-item-label { font-size: .6rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--text-muted); margin-bottom: .15rem; }
.modal-item.missing .modal-item-label { color: var(--err); }
.modal-item-value { font-size: .82rem; font-weight: 600; color: var(--brown-dark); line-height: 1.3; }
.modal-item.missing .modal-item-value { color: var(--err); font-style: italic; }
.modal-missing-banner {
    background: #FDF0EE; border: 1.5px solid #F5C5BE; border-radius: 10px;
    padding: .75rem 1rem; margin-bottom: 1.25rem;
    font-size: .82rem; color: #8B2A1E; display: none;
}
.modal-missing-banner.show { display: block; }
.modal-footer {
    padding: 1rem 1.5rem 1.25rem;
    border-top: 1.5px solid var(--border);
    display: flex; gap: .75rem;
    position: sticky; bottom: 0; background: var(--warm-white);
    border-radius: 0 0 20px 20px;
}
.btn-modal-back {
    flex: 1; padding: .75rem; background: transparent;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: .88rem; font-weight: 600;
    color: var(--text-muted); cursor: pointer; transition: all .2s;
}
.btn-modal-back:hover { border-color: var(--brown-accent); color: var(--brown-mid); background: var(--brown-pale); }
.btn-modal-confirm {
    flex: 2; padding: .75rem;
    background: linear-gradient(135deg, var(--brown-mid), var(--brown-accent));
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: .92rem; font-weight: 700;
    cursor: pointer; transition: all .2s;
}
.btn-modal-confirm:hover { background: linear-gradient(135deg, var(--brown-accent), #D4906A); transform: translateY(-1px); }
.btn-modal-confirm:disabled { opacity: .5; cursor: not-allowed; transform: none; }
.specialties-tags { display: flex; flex-wrap: wrap; gap: .3rem; margin-top: .15rem; }
.specialty-tag { padding: .15rem .5rem; background: var(--brown-light); border-radius: 20px; font-size: .68rem; font-weight: 600; color: var(--brown-dark); }
    </style>
</head>
<body>
<div class="page-wrap">

    {{-- SIDEBAR --}}
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">🎂</div>
            <div>
                <div class="brand-name">BakeSphere</div>
                <div class="brand-sub">Baker Portal</div>
            </div>
        </div>
        <h2 class="panel-heading">Turn your passion into profit</h2>
        <p class="panel-sub">Join our network of talented bakers — home-based or registered. Receive orders and grow your baking business.</p>
        <ul class="perks">
            <li><div class="perk-icon">💼</div><div><div class="perk-title">Bid on Orders</div>Browse custom cake requests and submit competitive bids.</div></li>
            <li><div class="perk-icon">💰</div><div><div class="perk-title">Set Your Price</div>You decide what your creations are worth.</div></li>
            <li><div class="perk-icon">🏠</div><div><div class="perk-title">Home Bakers Welcome</div>No business permit needed — just a valid government ID.</div></li>
            <li><div class="perk-icon">⭐</div><div><div class="perk-title">Build Your Reputation</div>Earn reviews and grow your baker profile over time.</div></li>
        </ul>
        <div class="already-link">
            <span class="already-link-label">Quick Links</span>
            <a href="{{ route('login') }}">🔑 Already a baker? Sign in</a>
            <a href="{{ route('register') }}">🛍️ Ordering a cake? Customer sign up</a>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="form-header">
            <div class="form-header-eyebrow">Baker Registration</div>
            <h1>Create Your Baker Account</h1>
            <p>Fill in your details below. Our admin team will review and approve your account within 1–2 business days before you can start bidding.</p>
        </div>

        @if($errors->any())
        <div class="alert-error">✕ {{ $errors->first() }}</div>
        @endif

        <div class="approval-notice">
            <div class="approval-notice-icon">⏳</div>
            <div class="approval-notice-text"><strong>Approval required.</strong> After registering, an admin will review your profile and documents before you can start receiving orders. This usually takes 1–2 business days.</div>
        </div>

        {{-- SELLER TYPE --}}
        <div class="seller-type-toggle">
            <label class="seller-type-card active" id="card-registered" onclick="setSellerType('registered')">
                <input type="radio" name="_seller_type_ui" value="registered" checked>
                <span class="stc-badge badge-registered">✓ Verified</span>
                <div class="stc-icon">🏢</div>
                <div class="stc-title">Registered Business</div>
                <div class="stc-desc">DTI/SEC registration and business permit. Higher bid limits and a Verified badge.</div>
            </label>
            <label class="seller-type-card" id="card-homebased" onclick="setSellerType('homebased')">
                <input type="radio" name="_seller_type_ui" value="homebased">
                <span class="stc-badge badge-homebased">🏠 Home Baker</span>
                <div class="stc-icon">🧁</div>
                <div class="stc-title">Home-Based Baker</div>
                <div class="stc-desc">No business permit needed — just a valid government ID and a selfie. Great for starting out!</div>
            </label>
        </div>

        <form method="POST" action="{{ route('baker.register.submit') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="seller_type" id="seller_type_input" value="registered">

            <div class="content-grid">

                {{-- ── LEFT COLUMN: Personal + Bakery + Profile ── --}}
                <div>

                    <div class="section-label">👤 Personal Information</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" id="first_name" class="form-input" value="{{ old('first_name') }}" required placeholder="Juan">
                            <div class="field-error" id="first_name_err" style="display:none;"></div>
                            @error('first_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" id="last_name" class="form-input" value="{{ old('last_name') }}" required placeholder="dela Cruz">
                            <div class="field-error" id="last_name_err" style="display:none;"></div>
                            @error('last_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address <span class="req">*</span></label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="you@email.com">
                        @error('email') <div class="field-error">{{ $message }}</div> @enderror
                    </div>


                  <div class="form-group">
    <label class="form-label">Phone Number <span class="req">*</span> <span class="hint">(PH — 11 digits)</span></label>
                        <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone') }}" required placeholder="09XXXXXXXXX" maxlength="11" inputmode="numeric">

                        <div class="field-error" id="phone_err" style="display:none;"></div>
                        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password <span class="req">*</span></label>
                            <div class="pw-wrap">
                                <input type="password" name="password" id="password" class="form-input" required placeholder="Min. 8 characters">
                                <button type="button" class="pw-toggle" onclick="togglePw('password', this)">👁</button>
                            </div>
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                            <div class="strength-label" id="strengthLabel"></div>
                            @error('password') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password <span class="req">*</span></label>
                            <div class="pw-wrap">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required placeholder="Repeat password">
                                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)">👁</button>
                            </div>
                            <div class="match-msg" id="pw_match_msg"></div>
                        </div>
                    </div>

                    <div class="section-label">🧁 Bakery Information</div>

                    <div class="form-group">
                        <label class="form-label">Cake Shop / Brand Name <span class="req">*</span></label>
                        <input type="text" name="shop_name" class="form-input" value="{{ old('shop_name') }}" required placeholder="e.g. Sweet Dreams Bakery">
                        @error('shop_name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

 <div class="form-group">
                        <label class="form-label">Years of Experience <span class="req">*</span></label>
                        <select name="experience_years" class="form-input" required>
                            <option value="">Select...</option>
                            <option value="less_than_1" {{ old('experience_years')=='less_than_1'?'selected':'' }}>Less than 1 year</option>
                            <option value="1-2" {{ old('experience_years')=='1-2'?'selected':'' }}>1–2 years</option>
                            <option value="3-5" {{ old('experience_years')=='3-5'?'selected':'' }}>3–5 years</option>
                            <option value="5-10" {{ old('experience_years')=='5-10'?'selected':'' }}>5–10 years</option>
                            <option value="10+" {{ old('experience_years')=='10+'?'selected':'' }}>10+ years</option>
                        </select>
                        @error('experience_years') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Social Media Page / Online Shop <span class="hint">(optional but recommended)</span></label>
                        <input type="url" name="social_media" class="form-input" value="{{ old('social_media') }}" placeholder="https://facebook.com/yourbakery or Instagram link">
                        <div class="field-hint">Helps customers find and trust your shop. Boosts approval chances.</div>
                        @error('social_media') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="section-label">✨ Baker Profile</div>

                    <div class="form-group">
                        <label class="form-label">Short Bio <span class="hint">(optional)</span></label>
                        <textarea name="bio" class="form-input" placeholder="Tell customers about your baking style, experience, and what makes your cakes special…">{{ old('bio') }}</textarea>
                        @error('bio') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                 <div class="form-group">
                        <label class="form-label">Cake Designs <span class="hint">(up to 3 photos of your best work) You can upload more later.</span></label>
                        <div class="file-upload-area" id="portfolio-area" style="height:auto;min-height:150px;cursor:pointer;">
                            <input type="file" name="portfolio[]" accept=".jpg,.jpeg,.png" multiple onchange="handlePortfolio(this)" style="z-index:4;">
                            <div id="portfolio-empty-state">
                                <div class="file-upload-icon">📸</div>
                                <div class="file-upload-title">Upload Cake Designs</div>
                                <div class="file-upload-hint">Select up to 3 cake photos · JPG or PNG · Max 5MB each</div>
                            </div>
                          <div id="portfolio-preview-grid" style="display:none;width:100%;padding:8px;pointer-events:none;"></div>
                            <div class="file-name-display" id="portfolio-names" style="position:relative;transform:none;width:100%;margin-top:4px;bottom:auto;left:auto;"></div>
                        </div>
                        @error('portfolio') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Specialties <span class="hint">(select all that apply)</span></label>
                        <div class="specialties-grid">
                            @php
                                $specialtyOptions = ['Wedding Cakes','Birthday Cakes','Fondant Art','Cupcakes','Macarons','Cheesecakes','Custom Designs','Vegan Cakes','Gluten-Free','Chocolate Cakes','Pastries','Tarts'];
                                $oldSpecs = old('specialties', []);
                            @endphp
                            @foreach($specialtyOptions as $spec)
                            <label class="specialty-check {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}">
                                <input type="checkbox" name="specialties[]" value="{{ $spec }}" {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}>
                                <span class="check-indicator">{{ in_array($spec, $oldSpecs) ? '✓' : '' }}</span>
                                {{ $spec }}
                            </label>
                            @endforeach
                        </div>
                        @error('specialties') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="submit-wrap">
                  <button type="button" class="btn-submit" onclick="openModal(this.closest('form'))">
    🎂 Submit Baker Application
</button>
 
<div style="display:flex;align-items:center;gap:12px;margin-top:1.25rem;margin-bottom:1rem;">
    <div style="flex:1;height:1px;background:var(--border);"></div>
    <span style="font-size:.72rem;color:#B09080;white-space:nowrap;">or sign up with Google</span>
    <div style="flex:1;height:1px;background:var(--border);"></div>
</div>
 
<a href="{{ route('auth.google', ['as' => 'baker']) }}"
   style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:.85rem;border:1.5px solid var(--border);border-radius:12px;text-decoration:none;background:var(--warm-white);font-family:'Plus Jakarta Sans',sans-serif;font-size:.94rem;font-weight:600;color:var(--brown-dark);transition:border-color .2s,background .2s,box-shadow .2s;"
   onmouseover="this.style.borderColor='var(--brown-accent)';this.style.background='var(--brown-pale)'"
   onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--warm-white)'">
    <img src="https://www.svgrepo.com/show/475656/google-color.svg" style="width:18px;height:18px;" alt="Google">
    Continue with Google as Baker
</a>
 
<div class="login-link" style="margin-top:1.25rem;">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
 
                    </div>

                </div>

                {{-- ── RIGHT COLUMN: Map + Documents ── --}}
                <div class="map-column">

                    {{-- MAP --}}
               <div class="section-label">📍 Bakery Location</div>
                    <p style="font-size:.82rem;color:var(--text-muted);line-height:1.65;margin-bottom:.9rem;">Pin your location so customers know how far you are when reviewing your bids.</p>

                    <div class="map-card">
                        <div class="map-card-header">
                            <h3>Pin Your Location</h3>
                            <p>Click the map or use your current location to drop a pin.</p>
                        </div>
                        <div id="baker-map"></div>
                        <div class="map-card-footer">
                            <button type="button" class="btn-locate" onclick="locateMe()">🎯 Use My Current Location</button>
                            <div class="map-coords" id="map-coords">📍 Pinned: <span id="coords-display"></span></div>
                            <div class="map-instructions">🖱️ Click the map to place your pin, or drag to fine-tune.</div>
                        </div>
                        <div class="address-field-wrap">
                            <label class="form-label">Full Address</label>
                            <input type="text" name="full_address" id="display-address" class="form-input" value="{{ old('full_address') }}" placeholder="Auto-fills when you pin the map, or type manually">
                            @error('full_address') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <input type="hidden" name="latitude"  id="input-lat"  value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="input-lng"  value="{{ old('longitude') }}">
                    <input type="hidden" name="address"   id="input-addr" value="{{ old('address') }}">
                    @error('latitude') <div class="field-error" style="margin-top:.5rem;">Please pin your location on the map.</div> @enderror

                    {{-- ── REGISTERED BUSINESS DOCUMENTS ── --}}
                    <div class="section-registered show" id="section-registered">
                        <div class="docs-card">
                            <div class="docs-card-header">
                                <h3>📋 Business Documents <span class="docs-type-badge registered">✓ Registered</span></h3>
                                <p>Upload your DTI/SEC registration, business permit, and sanitary permit.</p>
                            </div>
                            <div class="docs-card-body">

                                <div class="form-group">
                                    <label class="form-label">DTI or SEC Registration Number <span class="req">*</span></label>
                                    <input type="text" name="dti_sec_number" class="form-input" value="{{ old('dti_sec_number') }}" placeholder="e.g. DTI-0001234 or SEC-CS20190012345">
                                    @error('dti_sec_number') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="doc-grid">
                                    <div class="form-group">
                                        <label class="form-label">Business Permit <span class="req">*</span></label>
                                        <div class="file-upload-area" id="permit-upload-area">
                                            <input type="file" name="business_permit" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'permit-upload-area','permit-file-name')">
                                            <div class="file-upload-icon">📄</div>
                                            <div class="file-upload-title">Mayor's Permit</div>
                                            <div class="file-upload-hint">JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="permit-file-name"></div>
                                        </div>
                                        @error('business_permit') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">DTI / SEC Certificate <span class="req">*</span></label>
                                        <div class="file-upload-area" id="dti-upload-area">
                                            <input type="file" name="dti_certificate" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'dti-upload-area','dti-file-name')">
                                            <div class="file-upload-icon">📋</div>
                                            <div class="file-upload-title">DTI / SEC Cert</div>
                                            <div class="file-upload-hint">JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="dti-file-name"></div>
                                        </div>
                                        @error('dti_certificate') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Sanitary / Health Permit <span class="req">*</span></label>
                                        <div class="file-upload-area" id="sanitary-upload-area">
                                            <input type="file" name="sanitary_permit" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'sanitary-upload-area','sanitary-file-name')">
                                            <div class="file-upload-icon">🛡️</div>
                                            <div class="file-upload-title">Sanitary Permit</div>
                                            <div class="file-upload-hint">Food Safety / Health · Max 5MB</div>
                                            <div class="file-name-display" id="sanitary-file-name"></div>
                                        </div>
                                        @error('sanitary_permit') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">BIR COR <span class="hint">(optional)</span></label>
                                        <div class="file-upload-area" id="bir-upload-area">
                                            <input type="file" name="bir_certificate" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'bir-upload-area','bir-file-name')">
                                            <div class="file-upload-icon">📑</div>
                                            <div class="file-upload-title">BIR Certificate</div>
                                            <div class="file-upload-hint">JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="bir-file-name"></div>
                                        </div>
                                        @error('bir_certificate') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ── HOME-BASED DOCUMENTS ── --}}
                    <div class="section-homebased" id="section-homebased">
                        <div class="docs-card">
                            <div class="docs-card-header">
                                <h3>🏠 Home Baker Verification <span class="docs-type-badge homebased">🏠 Home Baker</span></h3>
                                <p>No business permit needed — just a valid government ID and a selfie.</p>
                            </div>
                            <div class="docs-card-body">

                                <div class="homebased-notice">
                                    <div class="homebased-notice-icon">ℹ️</div>
                                    <div class="homebased-notice-text">
                                        <strong>No business permit required.</strong> Similar to how Shopee and Lazada verify sellers — submit a government ID and selfie. You'll get a <em>Home Baker</em> badge with the option to upgrade to Verified later.
                                    </div>
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
                                        <label class="form-label">Gov't ID — Front <span class="req">*</span></label>
                                        <div class="file-upload-area" id="gov-id-front-area">
                                            <input type="file" name="gov_id_front" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'gov-id-front-area','gov-id-front-name')">
                                            <div class="file-upload-icon">🪪</div>
                                            <div class="file-upload-title">Front of ID</div>
                                            <div class="file-upload-hint">Clear photo · JPG/PNG</div>
                                            <div class="file-name-display" id="gov-id-front-name"></div>
                                        </div>
                                        @error('gov_id_front') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" style="white-space:nowrap; font-size:.75rem;">Gov't ID — Back <span class="hint">(if applicable)</span></label>
                                        <div class="file-upload-area" id="gov-id-back-area">
                                            <input type="file" name="gov_id_back" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'gov-id-back-area','gov-id-back-name')">
                                            <div class="file-upload-icon">🪪</div>
                                            <div class="file-upload-title">Back of ID</div>
                                            <div class="file-upload-hint">Clear photo · JPG/PNG</div>
                                            <div class="file-name-display" id="gov-id-back-name"></div>
                                        </div>
                                        @error('gov_id_back') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group doc-grid-full">
                                        <label class="form-label">Selfie Holding Your ID <span class="req">*</span></label>
                                        <div class="file-upload-area" id="selfie-area">
                                            <input type="file" name="id_selfie" accept=".jpg,.jpeg,.png" onchange="handleFile(this,'selfie-area','selfie-name')">
                                            <div class="file-upload-icon">🤳</div>
                                            <div class="file-upload-title">Selfie with ID</div>
                                            <div class="file-upload-hint">Hold your ID clearly beside your face · JPG/PNG · Max 5MB</div>
                                            <div class="file-name-display" id="selfie-name"></div>
                                        </div>
                                        @error('id_selfie') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group doc-grid-full">
                                        <label class="form-label">Food Safety Certificate <span class="hint">(optional but preferred)</span></label>
                                        <div class="file-upload-area" id="food-cert-area">
                                            <input type="file" name="food_safety_cert" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFile(this,'food-cert-area','food-cert-name')">
                                            <div class="file-upload-icon">🛡️</div>
                                            <div class="file-upload-title">Food Safety Certificate</div>
                                            <div class="file-upload-hint">NCDA / DOH certificate · JPG, PNG, PDF · Max 5MB</div>
                                            <div class="file-name-display" id="food-cert-name"></div>
                                        </div>
                                        @error('food_safety_cert') <div class="field-error">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>{{-- end map-column --}}

            </div>
        </form>
    </div>
</div>
<!-- CONFIRMATION MODAL -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div class="modal-head">
            <h2>🎂 Review Your Application</h2>
            <button type="button" class="modal-close" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body">

            <div class="modal-missing-banner" id="missingBanner">
                ⚠️ Please go back and fill in the highlighted required fields before submitting.
            </div>

            <!-- Personal Info -->
            <div class="modal-section">
                <div class="modal-section-title">👤 Personal Information</div>
                <div class="modal-grid">
                    <div class="modal-item" id="ms-first_name">
                        <div class="modal-item-label">First Name</div>
                        <div class="modal-item-value" id="mv-first_name">—</div>
                    </div>
                    <div class="modal-item" id="ms-last_name">
                        <div class="modal-item-label">Last Name</div>
                        <div class="modal-item-value" id="mv-last_name">—</div>
                    </div>
                    <div class="modal-item" id="ms-email">
                        <div class="modal-item-label">Email</div>
                        <div class="modal-item-value" id="mv-email">—</div>
                    </div>
                    <div class="modal-item" id="ms-phone">
                        <div class="modal-item-label">Phone</div>
                        <div class="modal-item-value" id="mv-phone">—</div>
                    </div>
                </div>
            </div>

            <!-- Bakery Info -->
            <div class="modal-section">
                <div class="modal-section-title">🧁 Bakery Information</div>
                <div class="modal-grid">
                    <div class="modal-item" id="ms-shop_name">
                        <div class="modal-item-label">Shop / Brand Name</div>
                        <div class="modal-item-value" id="mv-shop_name">—</div>
                    </div>
                    <div class="modal-item" id="ms-experience_years">
                        <div class="modal-item-label">Years of Experience</div>
                        <div class="modal-item-value" id="mv-experience_years">—</div>
                    </div>
                 
                    <div class="modal-item">
                        <div class="modal-item-label">Social Media</div>
                        <div class="modal-item-value" id="mv-social_media">Not provided</div>
                    </div>
                </div>
            </div>

            <!-- Baker Profile -->
            <div class="modal-section">
                <div class="modal-section-title">✨ Baker Profile</div>
                <div class="modal-grid">
                    <div class="modal-item">
                        <div class="modal-item-label">Bio</div>
                        <div class="modal-item-value" id="mv-bio" style="font-size:.78rem;font-weight:400;">Not provided</div>
                    </div>
                    <div class="modal-item">
                        <div class="modal-item-label">Cake Designs</div>
                        <div class="modal-item-value" id="mv-portfolio">None selected</div>
                    </div>
                </div>
                <div class="modal-item" style="margin-top:.5rem;">
                    <div class="modal-item-label">Specialties</div>
                    <div id="mv-specialties"><span style="font-size:.8rem;color:var(--text-muted);font-style:italic;">None selected</span></div>
                </div>
            </div>

            <!-- Location -->
            <div class="modal-section">
                <div class="modal-section-title">📍 Location</div>
                <div class="modal-item">
                    <div class="modal-item-label">Address</div>
                    <div class="modal-item-value" id="mv-full_address">Not pinned</div>
                </div>
            </div>

            <!-- Seller Type -->
            <div class="modal-section">
                <div class="modal-section-title">📋 Seller Type &amp; Documents</div>
                <div class="modal-item" style="margin-bottom:.5rem;">
                    <div class="modal-item-label">Type</div>
                    <div class="modal-item-value" id="mv-seller_type">—</div>
                </div>
                <div id="mv-docs-registered" style="display:none;">
                    <div class="modal-grid">
                        <div class="modal-item" id="ms-dti_sec_number">
                            <div class="modal-item-label">DTI / SEC Number</div>
                            <div class="modal-item-value" id="mv-dti_sec_number">—</div>
                        </div>
                        <div class="modal-item" id="ms-business_permit">
                            <div class="modal-item-label">Business Permit</div>
                            <div class="modal-item-value" id="mv-business_permit">—</div>
                        </div>
                        <div class="modal-item" id="ms-dti_certificate">
                            <div class="modal-item-label">DTI / SEC Cert</div>
                            <div class="modal-item-value" id="mv-dti_certificate">—</div>
                        </div>
                        <div class="modal-item" id="ms-sanitary_permit">
                            <div class="modal-item-label">Sanitary Permit</div>
                            <div class="modal-item-value" id="mv-sanitary_permit">—</div>
                        </div>
                    </div>
                </div>
                <div id="mv-docs-homebased" style="display:none;">
                    <div class="modal-grid">
                        <div class="modal-item" id="ms-gov_id_type">
                            <div class="modal-item-label">ID Type</div>
                            <div class="modal-item-value" id="mv-gov_id_type">—</div>
                        </div>
                        <div class="modal-item" id="ms-gov_id_front">
                            <div class="modal-item-label">Gov't ID Front</div>
                            <div class="modal-item-value" id="mv-gov_id_front">—</div>
                        </div>
                        <div class="modal-item" id="ms-id_selfie">
                            <div class="modal-item-label">Selfie with ID</div>
                            <div class="modal-item-value" id="mv-id_selfie">—</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn-modal-back" onclick="closeModal()">← Go Back &amp; Edit</button>
       <button type="button" class="btn-modal-confirm" id="btnConfirmSubmit" onclick="doSubmit()">
    🎂 Confirm &amp; Submit Application
</button>
        </div>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    /* SELLER TYPE */
    function setSellerType(type) {
        document.getElementById('seller_type_input').value = type;
        document.getElementById('card-registered').classList.toggle('active', type==='registered');
        document.getElementById('card-homebased').classList.toggle('active', type==='homebased');
        document.getElementById('section-registered').classList.toggle('show', type==='registered');
        document.getElementById('section-homebased').classList.toggle('show', type==='homebased');
    }

    /* SPECIALTIES */
    document.querySelectorAll('.specialty-check').forEach(label => {
        label.addEventListener('click', function () {
            const input = this.querySelector('input'), indicator = this.querySelector('.check-indicator');
            setTimeout(() => { this.classList.toggle('checked', input.checked); indicator.textContent = input.checked ? '✓' : ''; }, 0);
        });
    });
function handleFile(input, areaId, nameId) {
        const area = document.getElementById(areaId), nameEl = document.getElementById(nameId);
        if (input.files && input.files[0]) {
            const file = input.files[0];
            area.classList.add('has-file');
            nameEl.style.display='block';
            nameEl.textContent='✓ '+file.name;
            const prevId = areaId+'-img-prev';
            let prevEl = document.getElementById(prevId);
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!prevEl) {
                        prevEl = document.createElement('img');
                        prevEl.id = prevId;
                        prevEl.style.cssText='position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:8px;opacity:0.92;z-index:1;pointer-events:none;';
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
    const dt = new DataTransfer();

    function renderGrid() {
        const area       = document.getElementById('portfolio-area');
        const nameEl     = document.getElementById('portfolio-names');
        const grid       = document.getElementById('portfolio-preview-grid');
        const emptyState = document.getElementById('portfolio-empty-state');
        const files      = Array.from(dt.files);

        area.classList.toggle('has-file', files.length > 0);
        grid.innerHTML = '';
        grid.style.display = 'grid';
        grid.style.gridTemplateColumns = 'repeat(3, 1fr)';
        grid.style.gap = '6px';
        emptyState.style.display = files.length > 0 ? 'none' : '';
        nameEl.style.display = files.length > 0 ? 'block' : 'none';
        nameEl.textContent = files.length > 0 ? '✓ ' + files.length + ' of 3 photo(s) selected' : '';

        for (let i = 0; i < 3; i++) {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'position:relative;border-radius:8px;overflow:hidden;aspect-ratio:1;flex-shrink:0;';

            if (files[i]) {
                wrap.style.background = '#eee';
                /* Remove button */
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.textContent = '✕';
                removeBtn.style.cssText = 'position:absolute;top:4px;right:4px;z-index:5;width:20px;height:20px;border-radius:50%;border:none;background:rgba(0,0,0,0.55);color:#fff;font-size:.65rem;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;padding:0;';
                const idx = i;
                removeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const newDt = new DataTransfer();
                    Array.from(dt.files).forEach(function (f, fi) { if (fi !== idx) newDt.items.add(f); });
                    /* Clear and refill dt */
                    while (dt.items.length) dt.items.remove(0);
                    Array.from(newDt.files).forEach(function (f) { dt.items.add(f); });
                    /* Sync input */
                    document.querySelector('[name="portfolio[]"]').files = dt.files;
                    renderGrid();
                });
                const reader = new FileReader();
                const capturedWrap = wrap;
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
                    capturedWrap.appendChild(img);
                    capturedWrap.appendChild(removeBtn);
                };
                reader.readAsDataURL(files[i]);
            } else {
                wrap.style.cssText += 'background:rgba(0,0,0,0.05);border:2px dashed rgba(0,0,0,0.12);display:flex;align-items:center;justify-content:center;cursor:pointer;';
                wrap.innerHTML = '<span style="font-size:1.4rem;opacity:0.3;pointer-events:none;">📷</span>';
                /* Clicking empty slot opens file picker */
                wrap.addEventListener('click', function (e) {
                    e.stopPropagation();
                    document.querySelector('[name="portfolio[]"]').click();
                });
            }

            grid.appendChild(wrap);
        }
    }

    window.handlePortfolio = function (input) {
        if (!input.files || input.files.length === 0) return;
        Array.from(input.files).forEach(function (f) {
            if (dt.files.length < 3) dt.items.add(f);
        });
        /* Sync input element so the form submits the accumulated files */
        input.files = dt.files;
        renderGrid();
    };
})();
    function enforceNoNumbers(inputId, errId) {
        const inp = document.getElementById(inputId), err = document.getElementById(errId);
        inp.addEventListener('input', function() {
            if (/\d/.test(this.value)) { this.value = this.value.replace(/\d/g,''); inp.classList.add('is-invalid'); err.textContent='Name must not contain numbers.'; err.style.display='block'; }
            else { inp.classList.remove('is-invalid'); err.style.display='none'; }
        });
    }
    enforceNoNumbers('first_name','first_name_err');
    enforceNoNumbers('last_name','last_name_err');

    /* PHONE */
    const phoneInput = document.getElementById('phone'), phoneErr = document.getElementById('phone_err');
  phoneInput.addEventListener('input', function() { this.value = this.value.replace(/\D/g,'').slice(0,11); });

    phoneInput.addEventListener('keydown', function(e) { const a=['Backspace','Delete','Tab','ArrowLeft','ArrowRight','Home','End']; if(a.includes(e.key))return; if(!/^\d$/.test(e.key))e.preventDefault(); });
    phoneInput.addEventListener('blur', function() {
       if (this.value.length>0 && this.value.length!==11) { phoneErr.textContent='Must be exactly 11 digits (e.g. 09XXXXXXXXX).';
 phoneErr.style.display='block'; this.classList.add('is-invalid'); }
        else { phoneErr.style.display='none'; this.classList.remove('is-invalid'); }
    });

    /* PASSWORD STRENGTH */
    const pw=document.getElementById('password'), fill=document.getElementById('strengthFill'), slabel=document.getElementById('strengthLabel');
    pw.addEventListener('input', function() {
        const v=this.value; let s=0;
        if(v.length>=8)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^A-Za-z0-9]/.test(v))s++;
        fill.style.width=(s/4*100)+'%';
        fill.style.background=['#E53935','#FB8C00','#FDD835','#43A047'][s-1]||'transparent';
        slabel.textContent=s>0?['Weak','Fair','Good','Strong'][s-1]:'';
        checkMatch();
    });

    /* PASSWORD MATCH */
    const pwc=document.getElementById('password_confirmation'), matchMsg=document.getElementById('pw_match_msg');
    function checkMatch() {
        if(!pwc.value){matchMsg.textContent='';pwc.classList.remove('is-invalid','is-valid');return;}
        if(pw.value===pwc.value){matchMsg.textContent='✓ Passwords match';matchMsg.style.color='var(--success)';pwc.classList.remove('is-invalid');pwc.classList.add('is-valid');}
        else{matchMsg.textContent='✕ Passwords do not match';matchMsg.style.color='var(--err)';pwc.classList.remove('is-valid');pwc.classList.add('is-invalid');}
    }
    pwc.addEventListener('input', checkMatch);
function togglePw(id,btn){const f=document.getElementById(id);if(f.type==='password'){f.type='text';btn.textContent='Hide';}else{f.type='password';btn.textContent='Show';}}

    /* MAP */
    const map=L.map('baker-map').setView([14.5995,120.9842],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap',maxZoom:19}).addTo(map);
    const brownIcon=L.divIcon({html:`<div style="width:26px;height:26px;background:linear-gradient(135deg,#7B4F3A,#C07850);border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.35);"></div>`,iconSize:[26,26],iconAnchor:[13,26],className:''});
    let marker=null;
    @if(old('latitude') && old('longitude'))
        placeMarker({{old('latitude')}},{{old('longitude')}});map.setView([{{old('latitude')}},{{old('longitude')}}],15);
    @endif
    map.on('click',e=>placeMarker(e.latlng.lat,e.latlng.lng));
    function placeMarker(lat,lng){
        if(marker)marker.setLatLng([lat,lng]);
        else{marker=L.marker([lat,lng],{icon:brownIcon,draggable:true}).addTo(map);marker.on('dragend',()=>{const p=marker.getLatLng();updateCoords(p.lat,p.lng);reverseGeocode(p.lat,p.lng);});}
        updateCoords(lat,lng);reverseGeocode(lat,lng);
    }
    function updateCoords(lat,lng){
        document.getElementById('input-lat').value=lat.toFixed(7);document.getElementById('input-lng').value=lng.toFixed(7);
        const b=document.getElementById('map-coords');b.classList.add('visible');document.getElementById('coords-display').textContent=lat.toFixed(5)+', '+lng.toFixed(5);
    }
    function reverseGeocode(lat,lng){
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`).then(r=>r.json()).then(d=>{if(d&&d.display_name){document.getElementById('display-address').value=d.display_name;document.getElementById('input-addr').value=d.display_name;}}).catch(()=>{});
    }
    function locateMe(){
        if(!navigator.geolocation){alert('Geolocation not supported.');return;}
        navigator.geolocation.getCurrentPosition(p=>{map.setView([p.coords.latitude,p.coords.longitude],16);placeMarker(p.coords.latitude,p.coords.longitude);},()=>alert('Could not get your location. Please pin manually.'));
    }
    /* ── CONFIRMATION MODAL ── */
var _bakerForm = null;

function openModal(form) {
    _bakerForm = form;
    var missing = [];

    // Helper
    function fill(id, val, required) {
        var s = document.getElementById('ms-' + id);
        var v = document.getElementById('mv-' + id);
        if (!v) return;
        if (val) {
            if (s) s.classList.remove('missing');
            v.textContent = val;
        } else {
            if (required) {
                if (s) s.classList.add('missing');
                v.textContent = 'Required — please fill this in';
                missing.push(id);
            } else {
                if (s) s.classList.remove('missing');
                v.textContent = 'Not provided';
            }
        }
    }

    // Personal
    fill('first_name',      document.querySelector('[name=first_name]')?.value,      true);
    fill('last_name',       document.querySelector('[name=last_name]')?.value,       true);
    fill('email',           document.querySelector('[name=email]')?.value,           true);
    var phone = document.querySelector('[name=phone]')?.value;
    fill('phone', phone && phone.length === 11 ? phone : '', true);

    // Bakery
    fill('shop_name',        document.querySelector('[name=shop_name]')?.value,       true);
    var expEl = document.querySelector('[name=experience_years]');
    fill('experience_years', expEl?.options[expEl.selectedIndex]?.text !== 'Select...' ? expEl?.options[expEl.selectedIndex]?.text : '', true);

    document.getElementById('mv-social_media').textContent = document.querySelector('[name=social_media]')?.value || 'Not provided';

    // Profile
    var bio = document.querySelector('[name=bio]')?.value;
    document.getElementById('mv-bio').textContent = bio ? (bio.length > 80 ? bio.slice(0,80)+'…' : bio) : 'Not provided';

    var portfolioInput = document.querySelector('[name="portfolio[]"]');
    document.getElementById('mv-portfolio').textContent = portfolioInput?.files?.length ? portfolioInput.files.length + ' photo(s) selected' : 'None selected';

    var checked = Array.from(document.querySelectorAll('[name="specialties[]"]:checked')).map(c => c.value);
    var specEl = document.getElementById('mv-specialties');
    if (checked.length) {
        specEl.innerHTML = '<div class="specialties-tags">' + checked.map(s => '<span class="specialty-tag">' + s + '</span>').join('') + '</div>';
    } else {
        specEl.innerHTML = '<span style="font-size:.8rem;color:var(--text-muted);font-style:italic;">None selected</span>';
    }

    // Location
    var addr = document.getElementById('display-address')?.value;
    document.getElementById('mv-full_address').textContent = addr || 'Not pinned yet';

    // Seller type
    var type = document.getElementById('seller_type_input').value;
    document.getElementById('mv-seller_type').textContent = type === 'registered' ? '🏢 Registered Business' : '🏠 Home-Based Baker';
    document.getElementById('mv-docs-registered').style.display = type === 'registered' ? 'block' : 'none';
    document.getElementById('mv-docs-homebased').style.display  = type === 'homebased'  ? 'block' : 'none';

    if (type === 'registered') {
        fill('dti_sec_number',  document.querySelector('[name=dti_sec_number]')?.value,              true);
        fill('business_permit', document.querySelector('[name=business_permit]')?.files?.[0]?.name,  true);
        fill('dti_certificate', document.querySelector('[name=dti_certificate]')?.files?.[0]?.name,  true);
        fill('sanitary_permit', document.querySelector('[name=sanitary_permit]')?.files?.[0]?.name,  true);
    } else {
        var govIdEl = document.querySelector('[name=gov_id_type]');
        fill('gov_id_type',  govIdEl?.value ? govIdEl.options[govIdEl.selectedIndex].text : '', true);
        fill('gov_id_front', document.querySelector('[name=gov_id_front]')?.files?.[0]?.name,   true);
        fill('id_selfie',    document.querySelector('[name=id_selfie]')?.files?.[0]?.name,      true);
    }

    // Missing banner + confirm button
    var banner = document.getElementById('missingBanner');
    var btn    = document.getElementById('btnConfirmSubmit');
    if (missing.length > 0) {
        banner.classList.add('show');
        btn.disabled = true;
        btn.textContent = '⚠️ Fill in ' + missing.length + ' required field(s) first';
    } else {
        banner.classList.remove('show');
        btn.disabled = false;
        btn.textContent = '🎂 Confirm & Submit Application';
    }

    document.getElementById('confirmModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('confirmModal').classList.remove('open');
    document.body.style.overflow = '';
}

function doSubmit() {
    if (_bakerForm) {
        document.getElementById('btnConfirmSubmit').textContent = 'Submitting…';
        document.getElementById('btnConfirmSubmit').disabled = true;
        _bakerForm.submit();
    }
}

// Close on overlay click
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

</body>
</html>