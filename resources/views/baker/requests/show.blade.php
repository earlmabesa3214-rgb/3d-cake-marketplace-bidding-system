@extends('layouts.baker')
@section('title', 'Request #' . str_pad($request->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --espresso:       #24150F;
        --dark-chocolate: #3A241A;
        --warm-ivory:     #F7F2E9;
        --cream:          #EFE6D7;
        --caramel:        #A96F42;
        --champagne-gold: #B89452;
        --deep-burgundy:  #54252C;
        --taupe:          #9A897A;
        --soft-beige:     #D8C8B7;
        --olive:          #4F6B4A;

        --text-dark:  #24150F;
        --text-mid:   #6F5848;
        --text-muted: #9A897A;

        --ease: cubic-bezier(.22,.8,.32,1);
        --shadow-card: 0 1px 2px rgba(36,21,15,.06), 0 10px 30px -14px rgba(36,21,15,.2);
        --shadow-lift: 0 30px 70px -20px rgba(36,21,15,.45);
    }

    .rd-page, .rd-page * { font-family:'Plus Jakarta Sans', sans-serif; }
    .rd-page .icon { display:inline-block; vertical-align:-3px; flex-shrink:0; }

    /* ═══ ANIMATIONS ═══ */
    @keyframes rdFadeDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:none; } }
    @keyframes rdFadeUp   { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:none; } }
    @keyframes rdRule     { from { transform:scaleX(0); } to { transform:scaleX(1); } }

    @media (prefers-reduced-motion: reduce) {
        .rd-page *, .rd-page *::before, .rd-page *::after { animation:none !important; transition:none !important; }
    }

    .rd-anim-back    { animation:rdFadeDown .5s var(--ease) backwards; }
    .rd-anim-hero    { animation:rdFadeUp .7s var(--ease) .05s backwards; }
    .rd-anim-sidebar { animation:rdFadeUp .6s var(--ease) .15s backwards; }

    .back-link { display:inline-flex; align-items:center; gap:.5rem; margin-bottom:1.75rem; font-size:.66rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase;
        color:var(--text-muted); text-decoration:none; transition:color .3s var(--ease), transform .3s var(--ease); }
    .back-link:hover { color:var(--espresso); transform:translateX(-3px); }

    /* ═══ HERO BANNER (container retained, luxury styling) ═══ */
    .request-hero { position:relative; display:flex; align-items:center; justify-content:space-between; gap:2rem; flex-wrap:wrap; margin-bottom:2rem; padding:clamp(1.75rem,4vw,2.75rem) clamp(1.5rem,4vw,3rem); overflow:hidden; color:var(--warm-ivory);
        background:radial-gradient(60% 130% at 92% 0%, rgba(184,148,82,.24), transparent 60%), radial-gradient(40% 90% at 0% 100%, rgba(84,37,44,.55), transparent 70%), linear-gradient(135deg,var(--espresso),var(--dark-chocolate));
        border-radius:3px; box-shadow:var(--shadow-lift); }
    .request-hero::before { content:''; position:absolute; inset:10px; border:1px solid rgba(184,148,82,.3); pointer-events:none; }
    .request-hero::after { content:''; position:absolute; right:-80px; top:-80px; width:280px; height:280px; border-radius:50%; border:1px solid rgba(184,148,82,.22); box-shadow:0 0 0 34px rgba(184,148,82,.05), 0 0 0 68px rgba(184,148,82,.03); pointer-events:none; }
    .hero-left { position:relative; z-index:1; min-width:0; flex:1 1 380px; }
    .hero-req-id { margin-bottom:.8rem; font-size:.66rem; font-weight:700; letter-spacing:.24em; text-transform:uppercase; color:var(--champagne-gold); }
    .hero-cake-name { margin-bottom:1rem; font-size:clamp(1.9rem,4.6vw,3.1rem); font-weight:800; line-height:1.06; letter-spacing:-.035em; color:var(--warm-ivory); }
    .hero-cake-name::after { content:''; display:block; width:64px; height:1px; margin-top:1rem; background:var(--champagne-gold); transform-origin:left; animation:rdRule 1s var(--ease) .35s backwards; }
    .hero-meta { display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
    .hero-tag { display:inline-flex; align-items:center; gap:.3rem; padding:.42rem .75rem; border:1px solid rgba(247,242,233,.22); border-radius:2px; background:rgba(247,242,233,.07);
        font-size:.66rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:rgba(247,242,233,.88); line-height:1; }
    .hero-right { position:relative; z-index:1; flex-shrink:0; text-align:right; padding-left:2rem; border-left:1px solid rgba(184,148,82,.35); }
    .hero-budget-label { margin-bottom:.4rem; font-size:.6rem; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:rgba(247,242,233,.5); }
    .hero-budget { font-size:clamp(1.6rem,3vw,2.2rem); font-weight:800; line-height:1; letter-spacing:-.03em; color:var(--champagne-gold); }
    .hero-deadline { margin-top:.65rem; font-size:.8rem; font-weight:600; color:rgba(247,242,233,.75); }
    .hero-bids { margin-top:.25rem; font-size:.72rem; color:rgba(247,242,233,.5); }

    .urgency-badge { display:inline-flex; align-items:center; gap:.4rem; padding:.42rem .75rem; border-radius:2px; font-size:.66rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; line-height:1; }
    .urgency-badge.high   { background:var(--deep-burgundy); color:var(--warm-ivory); border:1px solid rgba(184,148,82,.55); }
    .urgency-badge.normal { background:transparent; color:var(--champagne-gold); border:1px solid rgba(184,148,82,.6); }

    /* ═══ LAYOUT ═══ */
    .detail-grid { display:grid; grid-template-columns:1fr 360px; gap:2rem; align-items:start; }
    .sidebar-sticky { position:sticky; top:5rem; }

    /* ═══ SECTION CARDS ═══ */
    .section-card { margin-bottom:1.5rem; overflow:hidden; background:var(--warm-ivory); border:1px solid var(--soft-beige); border-radius:3px; box-shadow:var(--shadow-card); animation:rdFadeUp .7s var(--ease) backwards; }
    .section-card:last-child { margin-bottom:0; }
    .section-card:nth-of-type(1) { animation-delay:.08s; }
    .section-card:nth-of-type(2) { animation-delay:.16s; }
    .section-card:nth-of-type(3) { animation-delay:.24s; }
    .section-card:nth-of-type(4) { animation-delay:.32s; }
    .section-card:nth-of-type(n+5) { animation-delay:.4s; }

    .section-header { display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:.95rem 1.5rem; border-bottom:1px solid var(--soft-beige); background:var(--cream); }
    .section-title { display:flex; align-items:center; gap:.55rem; font-size:.66rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--text-dark); }
    .section-title .icon { color:var(--champagne-gold); }
    .section-badge { padding:.2rem .6rem; border-radius:2px; background:var(--espresso); color:var(--warm-ivory); font-size:.62rem; font-weight:700; letter-spacing:.08em; box-shadow:inset 0 -2px 0 var(--champagne-gold); }
    .section-foot { padding:.7rem 1rem; text-align:center; font-size:.68rem; letter-spacing:.04em; color:var(--text-muted); border-top:1px solid var(--soft-beige); }

    /* ═══ SPECS ═══ */
    .spec-grid { display:grid; grid-template-columns:1fr 1fr; }
    .spec-item { padding:1rem 1.5rem; border-bottom:1px solid var(--soft-beige); border-right:1px solid var(--soft-beige); }
    .spec-item.no-right  { border-right:none; }
    .spec-item.no-bottom { border-bottom:none; }
    .spec-item.full { grid-column:1 / -1; border-right:none; border-bottom:none; }
    .spec-label { margin-bottom:.3rem; font-size:.6rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--text-muted); }
    .spec-value { font-size:.92rem; font-weight:600; line-height:1.4; color:var(--text-dark); }
    .spec-value.accent { color:var(--caramel); }
    .spec-time { display:flex; align-items:center; gap:.3rem; margin-top:.2rem; font-size:.72rem; color:var(--caramel); }

    .addon-tags { display:flex; flex-wrap:wrap; gap:.35rem; margin-top:.3rem; }
    .addon-tag { padding:.22rem .6rem; border:1px solid var(--soft-beige); border-radius:2px; background:var(--cream); font-size:.7rem; font-weight:600; color:var(--text-mid); }

    .spec-group { padding:1rem 1.5rem .5rem; border-bottom:1px solid var(--soft-beige); }
    .spec-group:last-child { border-bottom:none; }
    .spec-group-title { margin-bottom:.4rem; font-size:.6rem; font-weight:800; letter-spacing:.2em; text-transform:uppercase; color:var(--champagne-gold); }
    .spec-row { display:flex; justify-content:space-between; gap:1.25rem; padding:.6rem 0; border-top:1px solid rgba(216,200,183,.55); font-size:.86rem; }
    .spec-row:first-of-type { border-top:none; }
    .spec-row-label { flex-shrink:0; font-weight:500; color:var(--text-muted); }
    .spec-row-value { font-weight:700; text-align:right; line-height:1.45; color:var(--text-dark); }
    .spec-row-value.accent { color:var(--caramel); }

    /* ═══ NOTES ═══ */
    .notes-box { margin:0; padding:1.1rem 1.5rem 1.1rem 1.4rem; border-left:2px solid var(--champagne-gold); font-size:.86rem; font-style:italic; line-height:1.65; color:var(--text-mid); }
    .notes-box + .notes-box { border-top:1px solid var(--soft-beige); }
    .notes-box.plain { font-style:normal; }
    .notes-label { margin-bottom:.35rem; font-size:.6rem; font-weight:700; font-style:normal; letter-spacing:.18em; text-transform:uppercase; color:var(--text-muted); }

    /* ═══ IMAGES ═══ */
    .img-stage { background:radial-gradient(70% 60% at 50% 45%, #FFFBF3 0%, rgba(255,251,243,0) 70%), linear-gradient(180deg,var(--warm-ivory),var(--cream)); overflow:hidden; }
    .ref-image-full, .preview-image-full { display:block; width:100%; max-height:480px; object-fit:contain; transition:transform .8s var(--ease); }
    .preview-image-full { padding:1.25rem; filter:drop-shadow(0 16px 16px rgba(36,21,15,.2)); max-height:420px; }
    .section-card:hover .ref-image-full, .section-card:hover .preview-image-full { transform:scale(1.02); }

    /* ═══ LOCATION ═══ */
    .loc-wrap { padding:1.1rem 1.5rem; }
    #delivery-map { height:240px; margin-bottom:.8rem; border:1px solid var(--soft-beige); border-radius:2px; overflow:hidden; }
    .map-placeholder { height:180px; margin-bottom:.8rem; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.5rem; border:1px solid var(--soft-beige); border-radius:2px;
        background:radial-gradient(60% 80% at 50% 30%, rgba(184,148,82,.14), transparent 70%), var(--cream); font-size:.8rem; color:var(--text-muted); }
    .map-placeholder svg { color:var(--champagne-gold); }
    .loc-address { font-size:.86rem; font-weight:500; line-height:1.55; color:var(--text-mid); }

    /* ═══ BIDS LIST ═══ */
    .bid-row { display:flex; justify-content:space-between; align-items:center; padding:.95rem 1.5rem; border-bottom:1px solid var(--soft-beige); transition:background .3s var(--ease); animation:rdFadeUp .5s var(--ease) backwards; }
    .bid-row:nth-child(2) { animation-delay:.05s; }
    .bid-row:nth-child(3) { animation-delay:.1s; }
    .bid-row:nth-child(n+4) { animation-delay:.15s; }
    .bid-row:last-child { border-bottom:none; }
    .bid-row:hover { background:var(--cream); }
    .bid-row.mine { background:rgba(184,148,82,.1); border-left:2px solid var(--champagne-gold); }
    .bid-name { font-size:.84rem; font-weight:700; color:var(--text-dark); }
    .bid-you { margin-left:.5rem; padding:.12rem .45rem; border:1px solid var(--champagne-gold); border-radius:2px; font-size:.56rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--caramel); }
    .bid-time { margin-top:.15rem; font-size:.7rem; color:var(--text-muted); }
    .bid-amount { font-size:1.05rem; font-weight:800; letter-spacing:-.02em; color:var(--espresso); }
    .bids-empty { padding:2.25rem; text-align:center; font-size:.84rem; color:var(--text-muted); }
    .bids-empty svg { display:block; margin:0 auto .6rem; color:var(--champagne-gold); opacity:.7; }

    /* ═══ SIDEBAR: PRICE / BID ═══ */
    .budget-display { padding:1.5rem; text-align:center; border-bottom:1px solid var(--soft-beige); background:radial-gradient(70% 90% at 50% 0%, rgba(184,148,82,.16), transparent 70%), var(--cream); }
    .budget-display-label { margin-bottom:.45rem; font-size:.6rem; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:var(--text-muted); }
    .my-bid-amount { font-size:2rem; font-weight:800; line-height:1; letter-spacing:-.03em; color:var(--espresso); }
    .bid-status-pill { display:inline-flex; align-items:center; margin-top:.85rem; padding:.3rem .75rem; border-radius:2px; font-size:.62rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; border:1px solid; }
    .bid-status-pill.pending  { background:rgba(184,148,82,.14); color:var(--caramel); border-color:var(--champagne-gold); }
    .bid-status-pill.accepted { background:rgba(79,107,74,.1); color:var(--olive); border-color:rgba(79,107,74,.5); }
    .bid-status-pill.rejected { background:rgba(84,37,44,.08); color:var(--deep-burgundy); border-color:rgba(84,37,44,.45); }

    .bid-form-wrap { padding:1.4rem; }
    .form-group { margin-bottom:1.1rem; }
    .form-label { display:flex; align-items:center; gap:.35rem; margin-bottom:.4rem; font-size:.62rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--text-mid); }
    .form-input { width:100%; box-sizing:border-box; padding:.8rem 1rem; border:1px solid var(--soft-beige); border-radius:2px; background:#fff; color:var(--text-dark); font-size:.9rem; outline:none; transition:border-color .3s var(--ease), box-shadow .3s var(--ease); }
    .form-input::placeholder { color:var(--taupe); }
    .form-input:focus { border-color:var(--champagne-gold); box-shadow:0 0 0 3px rgba(184,148,82,.18); }
    .form-textarea { resize:vertical; min-height:96px; }
    .form-hint { margin-top:.35rem; font-size:.7rem; color:var(--text-muted); }

    .btn-submit, .btn-danger { width:100%; display:flex; align-items:center; justify-content:center; gap:.5rem; border-radius:3px; font-size:.7rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; cursor:pointer; transition:background .3s var(--ease), color .3s var(--ease), transform .3s var(--ease); }
    .btn-submit { padding:.95rem; border:1px solid var(--espresso); background:var(--espresso); color:var(--warm-ivory); box-shadow:inset 0 -2px 0 var(--champagne-gold); }
    .btn-submit:hover { background:var(--dark-chocolate); }
    .btn-danger { padding:.85rem; border:1px solid rgba(84,37,44,.4); background:transparent; color:var(--deep-burgundy); }
    .btn-danger:hover { background:var(--deep-burgundy); color:var(--warm-ivory); }
    .btn-submit:active, .btn-danger:active { transform:scale(.98); }
    .btn-submit:focus-visible, .btn-danger:focus-visible, .btn-rush-submit:focus-visible, .rd-modal-btn:focus-visible { outline:2px solid var(--champagne-gold); outline-offset:2px; }

    /* ═══ ALREADY BID ═══ */
    .mybid-wrap { padding:1.4rem; }
    .bid-msg { margin-bottom:1rem; padding:.9rem 1rem; border-left:2px solid var(--champagne-gold); font-size:.84rem; font-style:italic; line-height:1.6; color:var(--text-mid); background:var(--cream); }
    .info-line { display:flex; justify-content:space-between; align-items:center; padding:.6rem 0; font-size:.8rem; color:var(--text-muted); border-bottom:1px solid var(--soft-beige); }
    .info-line strong { color:var(--text-dark); }
    .info-line.last { border-bottom:none; margin-bottom:1rem; }
    .rush-wait { display:flex; align-items:flex-start; gap:.5rem; margin-bottom:1rem; padding:.7rem .9rem; border:1px solid var(--soft-beige); border-left:2px solid var(--champagne-gold); background:var(--cream); font-size:.74rem; line-height:1.55; color:var(--text-mid); }
    .rush-wait svg { flex-shrink:0; margin-top:2px; color:var(--champagne-gold); }

    /* ═══ RUSH BLOCK (dark panel) ═══ */
    .rush-block { padding:1.4rem; color:var(--warm-ivory); background:radial-gradient(70% 100% at 100% 0%, rgba(184,148,82,.2), transparent 65%), linear-gradient(135deg,var(--espresso),var(--dark-chocolate)); animation:rdFadeUp .6s var(--ease) .1s backwards; }
    .rush-title { display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem; font-size:1.1rem; font-weight:800; letter-spacing:-.01em; }
    .rush-title svg { color:var(--champagne-gold); }
    .rush-sub { margin-bottom:1.1rem; font-size:.76rem; line-height:1.5; color:rgba(247,242,233,.6); }
    .rush-summary { margin-bottom:1.1rem; padding:.9rem 1rem; border:1px solid rgba(184,148,82,.3); background:rgba(247,242,233,.05); }
    .rush-row { display:flex; justify-content:space-between; align-items:center; padding:.35rem 0; }
    .rush-row span:first-child { font-size:.62rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:rgba(247,242,233,.55); }
    .rush-row span:last-child { font-size:.86rem; font-weight:700; }
    .rush-row .gold { color:var(--champagne-gold); }
    .rush-row.total { margin-top:.35rem; padding-top:.7rem; border-top:1px solid rgba(184,148,82,.3); }
    .rush-row.total span:first-child { color:var(--warm-ivory); }
    .rush-row.total span:last-child { font-size:1.3rem; font-weight:800; color:var(--champagne-gold); }
    .rush-notice { display:flex; align-items:flex-start; gap:.55rem; padding:.85rem 1rem; border:1px solid rgba(184,148,82,.35); font-size:.76rem; line-height:1.55; color:rgba(247,242,233,.8); }
    .rush-notice svg { flex-shrink:0; margin-top:2px; color:var(--champagne-gold); }
    .btn-rush-submit { width:100%; display:flex; align-items:center; justify-content:center; gap:.5rem; padding:.95rem; border:1px solid var(--champagne-gold); border-radius:3px; background:var(--champagne-gold); color:var(--espresso);
        font-size:.72rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; cursor:pointer; transition:background .3s var(--ease), color .3s var(--ease), transform .3s var(--ease); }
    .btn-rush-submit:hover { background:var(--warm-ivory); border-color:var(--warm-ivory); }
    .btn-rush-submit:active { transform:scale(.98); }
    .rush-expiry { display:flex; align-items:center; justify-content:center; gap:.35rem; margin-top:.9rem; font-size:.72rem; color:rgba(247,242,233,.55); }

    .rush-breakdown { margin-bottom:1rem; padding:.9rem 1rem; color:var(--warm-ivory); background:linear-gradient(135deg,var(--espresso),var(--dark-chocolate)); border-left:2px solid var(--champagne-gold); }
    .rush-breakdown-title { display:flex; align-items:center; gap:.35rem; margin-bottom:.5rem; font-size:.6rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:rgba(247,242,233,.5); }
    .rush-breakdown .rush-row { border-bottom:1px solid rgba(247,242,233,.1); }
    .rush-breakdown .rush-row.total { border-bottom:none; border-top:none; margin-top:0; padding-top:.5rem; }
    .rush-breakdown .rush-row.total span:last-child { font-size:1rem; }

    /* ═══ ORDER INFO / REPORT ═══ */
    .info-row { display:flex; justify-content:space-between; align-items:center; padding:.85rem 1.4rem; border-bottom:1px solid var(--soft-beige); font-size:.82rem; }
    .info-row:last-child { border-bottom:none; }
    .info-row span:first-child { font-size:.6rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--text-muted); }
    .info-row span:last-child { font-weight:700; color:var(--text-dark); }
    .info-row .accent { color:var(--caramel); }

    .report-notice { margin-top:1.5rem; padding:1.1rem 1.4rem; border:1px solid var(--soft-beige); border-left:3px solid var(--deep-burgundy); background:var(--warm-ivory); box-shadow:var(--shadow-card); animation:rdFadeUp .6s var(--ease) backwards; }
    .report-notice-title { display:flex; align-items:center; gap:.5rem; margin-bottom:.35rem; font-size:.66rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--deep-burgundy); }
    .report-notice-text { font-size:.78rem; line-height:1.6; color:var(--text-mid); }
    .report-notice-text strong { color:var(--text-dark); }

    /* ═══ MODALS ═══ */
    .rd-modal-backdrop { position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; padding:1rem; opacity:0; pointer-events:none; background:rgba(36,21,15,.72); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); transition:opacity .3s var(--ease); }
    .rd-modal-backdrop.withdraw { z-index:99999; }
    .rd-modal { width:100%; max-width:400px; overflow:hidden; background:var(--warm-ivory); border:1px solid var(--champagne-gold); border-radius:3px; box-shadow:var(--shadow-lift); transform:translateY(20px) scale(.97); transition:transform .4s var(--ease); }
    .rd-modal-head { padding:2rem 1.5rem; text-align:center; color:var(--warm-ivory); background:radial-gradient(70% 100% at 50% 0%, rgba(184,148,82,.25), transparent 70%), linear-gradient(135deg,var(--espresso),var(--dark-chocolate)); }
    .rd-modal-head.danger { background:radial-gradient(70% 100% at 50% 0%, rgba(184,148,82,.18), transparent 70%), linear-gradient(135deg,var(--deep-burgundy),#3A1A1F); }
    .rd-modal-icon { width:52px; height:52px; margin:0 auto 1rem; display:grid; place-items:center; border:1px solid var(--champagne-gold); border-radius:50%; color:var(--champagne-gold); }
    .rd-modal-title { margin-bottom:.3rem; font-size:1.2rem; font-weight:800; letter-spacing:-.02em; }
    .rd-modal-sub { font-size:.76rem; color:rgba(247,242,233,.6); }
    .rd-modal-body { padding:1.5rem; }
    .rd-modal-summary { margin-bottom:1.15rem; padding:.9rem 1.1rem; border:1px solid var(--soft-beige); background:var(--cream); }
    .rd-modal-row { display:flex; justify-content:space-between; align-items:center; padding:.5rem 0; font-size:.84rem; border-top:1px solid var(--soft-beige); }
    .rd-modal-row:first-child { border-top:none; }
    .rd-modal-row span:first-child { font-size:.6rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; color:var(--text-muted); }
    .rd-modal-row span:last-child { font-weight:700; color:var(--text-dark); }
    .rd-modal-row .accent { color:var(--caramel); }
    .rd-modal-row .big { font-size:1.1rem; font-weight:800; }
    .rd-modal-note { margin:0 0 1.15rem; text-align:center; font-size:.78rem; line-height:1.6; color:var(--text-muted); }
    .rd-modal-actions { display:flex; gap:.7rem; }
    .rd-modal-btn { display:flex; align-items:center; justify-content:center; gap:.4rem; padding:.85rem; border:1px solid transparent; border-radius:3px; font-size:.68rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; cursor:pointer; transition:background .3s var(--ease), color .3s var(--ease), border-color .3s var(--ease); }
    .rd-modal-btn.cancel { flex:1; background:transparent; border-color:var(--soft-beige); color:var(--text-mid); }
    .rd-modal-btn.cancel:hover { border-color:var(--espresso); background:var(--warm-ivory); }
    .rd-modal-btn.confirm { flex:2; background:var(--espresso); border-color:var(--espresso); color:var(--warm-ivory); box-shadow:inset 0 -2px 0 var(--champagne-gold); }
    .rd-modal-btn.confirm:hover { background:var(--dark-chocolate); }
    .rd-modal-btn.confirm.danger { background:var(--deep-burgundy); border-color:var(--deep-burgundy); }
    .rd-modal-btn:disabled { opacity:.6; cursor:default; }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width:980px) {
        .detail-grid { grid-template-columns:1fr; }
        .sidebar-sticky { position:static; }
        .hero-right { text-align:left; padding-left:0; padding-top:1.25rem; border-left:none; border-top:1px solid rgba(184,148,82,.35); width:100%; }
    }
    @media (max-width:560px) {
        .spec-grid { grid-template-columns:1fr; }
        .spec-item, .spec-item.no-right { border-right:none; }
        .spec-item.no-bottom { border-bottom:1px solid var(--soft-beige); }
        .spec-item:last-child { border-bottom:none; }
        .section-header, .spec-group, .notes-box, .loc-wrap, .bid-row { padding-left:1.15rem; padding-right:1.15rem; }
        .rd-modal-actions { flex-direction:column-reverse; }
        .rd-modal-btn.cancel, .rd-modal-btn.confirm { flex:none; width:100%; }
    }
</style>
@endpush

@section('content')
<div class="rd-page">

<a href="{{ route('baker.requests.index') }}" class="back-link rd-anim-back">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m11 18-6-6 6-6"/></svg>
    Back to Browse Requests
</a>

@php
    $config   = is_array($request->cake_configuration) ? $request->cake_configuration : (json_decode($request->cake_configuration, true) ?? []);
$bakerMe = \App\Models\Baker::where('user_id', auth()->id())->first();
$myBid = \App\Models\Bid::where('cake_request_id', $request->id)
    ->where(function($q) use ($bakerMe) {
        $q->where('baker_id', auth()->id());
        if ($bakerMe) {
            $q->orWhere('baker_id', $bakerMe->id);
        }
    })
    ->first();
 $daysLeft = (int) now()->diffInDays($request->delivery_date, false);
    $summary       = $config['baker_summary'] ?? [];
    $heroName      = $config['cake_label'] ?? trim(($config['flavor'] ?? 'Custom') . ' ' . ($config['shape'] ?? 'Cake'));
    $heroTags      = $config['hero_tags'] ?? array_values(array_filter([$config['size'] ?? null, $config['frosting'] ?? null]));
    $customerTotal = $config['total'] ?? null;
    // Build spec rows so we can compute borders correctly
    $specRows = [];
    if (!empty($config['flavor']))   $specRows[] = ['label' => 'Flavor',   'value' => $config['flavor'],   'accent' => false];
    if (!empty($config['shape']))    $specRows[] = ['label' => 'Shape',    'value' => $config['shape'],    'accent' => false];
    if (!empty($config['size']))     $specRows[] = ['label' => 'Size',     'value' => $config['size'],     'accent' => false];
    if (!empty($config['layers']))   $specRows[] = ['label' => 'Layers',   'value' => $config['layers'],   'accent' => false];
    if (!empty($config['frosting'])) $specRows[] = ['label' => 'Frosting', 'value' => $config['frosting'], 'accent' => false];
    // Delivery date always appears
    $specRows[] = ['label' => 'Delivery Date', 'value' => '__delivery__', 'accent' => true];

    $totalSpec = count($specRows);
    // If total is odd, last item spans... but we keep 2-col, so last item if odd has no right border
@endphp

{{-- HERO --}}
<div class="request-hero rd-anim-hero">
    <div class="hero-left">
        <div class="hero-req-id">Request · #{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div class="hero-cake-name">{{ $heroName }}</div>
        <div class="hero-meta">
            @foreach($heroTags as $t)<span class="hero-tag">{{ $t }}</span>@endforeach
            @if($request->status === 'RUSH_MATCHING')
                <span class="urgency-badge high">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Rush — Accept Now
                </span>
            @elseif($daysLeft <= 3)
                <span class="urgency-badge high">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Urgent — {{ $daysLeft }}d left
                </span>
            @else
                <span class="urgency-badge normal">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $daysLeft }} days left
                </span>
            @endif
        </div>
    </div>
    <div class="hero-right">
        <div class="hero-budget-label">Budget Range</div>
        <div class="hero-budget">₱{{ number_format($request->budget_min, 0) }}–₱{{ number_format($request->budget_max, 0) }}</div>
        <div class="hero-deadline">Due {{ $request->delivery_date->format('M d, Y') }}</div>
        <div class="hero-bids">{{ $request->bids()->count() }} bid{{ $request->bids()->count() !== 1 ? 's' : '' }} so far</div>
    </div>
</div>

<div class="detail-grid">

    {{-- LEFT COLUMN --}}
    <div>

       @if(!empty($summary))
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">Cake Specifications</span>
                @if($customerTotal)<span class="section-badge">Customer estimate ₱{{ number_format($customerTotal) }}</span>@endif
            </div>
            @foreach($summary as $group)
                @if(!empty($group['rows']))
                <div class="spec-group">
                    <div class="spec-group-title">{{ $group['title'] }}</div>
                    @foreach($group['rows'] as $row)
                    <div class="spec-row">
                        <span class="spec-row-label">{{ $row[0] }}</span>
                        <span class="spec-row-value">{{ $row[1] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            @endforeach
            <div class="spec-group">
                <div class="spec-group-title">Delivery</div>
                <div class="spec-row">
                    <span class="spec-row-label">Date</span>
                    <span class="spec-row-value accent">{{ $request->delivery_date->format('F d, Y') }}@if($request->needed_time) · {{ \Carbon\Carbon::parse($request->needed_time)->format('g:i A') }}@endif</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Cake Specs (legacy requests without baker_summary) --}}
        @if(empty($summary))
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>
                    Cake Specifications
                </span>
            </div>
            <div class="spec-grid">
                @foreach($specRows as $idx => $spec)
                    @php
                        $col       = $idx % 2;           // 0 = left, 1 = right
                        $isRight   = ($col === 1);
                        // Last row: items in last 1 or 2 positions
                        $isLastRow = ($idx >= $totalSpec - 2 && $totalSpec % 2 === 0)
                                  || ($idx === $totalSpec - 1);
                        $noRight   = $isRight ? 'no-right' : '';
                        $noBottom  = $isLastRow ? 'no-bottom' : '';
                    @endphp
                    <div class="spec-item {{ $noRight }} {{ $noBottom }}">
                        <div class="spec-label">{{ $spec['label'] }}</div>
                        @if($spec['value'] === '__delivery__')
                            <div class="spec-value accent">
                                {{ $request->delivery_date->format('F d, Y') }}
                                @if($request->needed_time)
                                    <div class="spec-time">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ \Carbon\Carbon::parse($request->needed_time)->format('g:i A') }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="spec-value {{ $spec['accent'] ? 'accent' : '' }}">{{ $spec['value'] }}</div>
                        @endif
                    </div>
                @endforeach

                @if(!empty($config['addons']))
                <div class="spec-item full">
                    <div class="spec-label">Add-ons</div>
                    <div class="addon-tags">
                        @foreach((array)$config['addons'] as $addon)
                        <span class="addon-tag">{{ $addon }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
@endif
        {{-- Notes --}}
        @if($request->custom_message || $request->special_instructions)
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Customer Notes
                </span>
            </div>
            @if($request->custom_message)
            <div class="notes-box">
                <div class="notes-label">Message on Cake</div>
                "{{ $request->custom_message }}"
            </div>
            @endif
            @if($request->special_instructions)
            <div class="notes-box plain">
                <div class="notes-label">Special Instructions</div>
                {{ $request->special_instructions }}
            </div>
            @endif
        </div>
        @endif

        {{-- Delivery Location --}}
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Location
                </span>
            </div>
            <div class="loc-wrap">
                @if($request->hasMapLocation())
                <div id="delivery-map"></div>
                @else
                <div class="map-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>No precise location set</span>
                </div>
                @endif
                @if($request->delivery_address)
                <div class="loc-address">
                    {{ $request->delivery_address }}
                </div>
                @endif
            </div>
        </div>

        {{-- All Bids --}}
        <div class="section-card">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    All Bids
                </span>
                <span class="section-badge">{{ $request->bids()->count() }}</span>
            </div>
            @forelse($request->bids as $bid)
            <div class="bid-row {{ $myBid && $myBid->id === $bid->id ? 'mine' : '' }}">
                <div>
                    <div class="bid-name">
                        Baker #{{ $bid->baker_id }}
                        @if($myBid && $myBid->id === $bid->id)
                        <span class="bid-you">You</span>
                        @endif
                    </div>
                    <div class="bid-time">{{ $bid->created_at->diffForHumans() }}</div>
                </div>
                <div class="bid-amount">₱{{ number_format($bid->amount, 0) }}</div>
            </div>
            @empty
            <div class="bids-empty">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Be the first to bid!
            </div>
            @endforelse
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="sidebar-sticky rd-anim-sidebar">

        <div class="section-card">
            <div class="budget-display">
                <div class="budget-display-label">{{ $myBid ? 'Your Bid' : 'Estimated Price' }}</div>
                <div class="my-bid-amount">
                    @if($myBid)
                        ₱{{ number_format($myBid->amount, 0) }}
                    @else
                        ₱{{ number_format($request->budget_min, 0) }}–{{ number_format($request->budget_max, 0) }}
                    @endif
                </div>
                @if($myBid)
                <div>
                    <span class="bid-status-pill {{ strtolower($myBid->status) }}">{{ $myBid->status }}</span>
                </div>
                @endif
            </div>

            @if($request->status === 'RUSH_MATCHING' && !$myBid)
            {{-- ── RUSH BID BLOCK ── --}}
            @php
                $config2     = is_array($request->cake_configuration) ? $request->cake_configuration : (json_decode($request->cake_configuration, true) ?? []);
                $basePrice   = (float)($config2['total'] ?? $request->budget_min ?? 0);
                $bakerRecord = \App\Models\Baker::where('user_id', auth()->id())->first();
                $rushFee     = (float)($bakerRecord?->rush_fee ?? 0);
                $autoPrice   = $basePrice + $rushFee;
                if ($autoPrice > $request->budget_max) { $autoPrice = (float)$request->budget_max; }
            @endphp
            <div class="rush-block">
                <div class="rush-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Rush Order
                </div>
                <div class="rush-sub">Submit your price — the customer picks within 60 seconds.</div>
                <div class="rush-summary">
                    <div class="rush-row">
                        <span>Base price</span>
                        <span>₱{{ number_format($basePrice, 2) }}</span>
                    </div>
                    <div class="rush-row">
                        <span>Your rush fee</span>
                        <span class="gold">+ ₱{{ number_format($rushFee, 2) }}</span>
                    </div>
                    <div class="rush-row total">
                        <span>You earn</span>
                        <span>₱{{ number_format($autoPrice, 2) }}</span>
                    </div>
                </div>
                @if(!$bakerRecord?->accepts_rush_orders || !$bakerRecord?->is_available)
                <div class="rush-notice">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    Enable Rush Mode and set yourself as Available in your profile to accept rush orders.
                </div>
                @else
                <form method="POST" action="{{ route('baker.rush-orders.accept', $request->id) }}" id="rush-accept-form">
                    @csrf
                    <button type="button" onclick="openRushConfirm()" class="btn-rush-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Submit Rush Bid
                    </button>
                </form>
                <div id="rush-confirm-backdrop" class="rd-modal-backdrop">
                    <div id="rush-confirm-inner" class="rd-modal">
                        <div class="rd-modal-head">
                            <div class="rd-modal-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            </div>
                            <div class="rd-modal-title">Submit Rush Bid?</div>
                            <div class="rd-modal-sub">Your price appears to the customer immediately</div>
                        </div>
                        <div class="rd-modal-body">
                            <div class="rd-modal-summary">
                                <div class="rd-modal-row">
                                    <span>Customer</span>
                                    <span>{{ $request->user->first_name }}</span>
                                </div>
                                <div class="rd-modal-row">
                                    <span>Delivery date</span>
                                    <span class="accent">{{ $request->delivery_date->format('M d, Y') }}</span>
                                </div>
                                <div class="rd-modal-row">
                                    <span>You earn</span>
                                    <span class="big">₱{{ number_format($autoPrice, 2) }}</span>
                                </div>
                            </div>
                            <div class="rd-modal-actions">
                                <button onclick="closeRushConfirm()" class="rd-modal-btn cancel">Cancel</button>
                                <button onclick="submitRushAccept(this)" class="rd-modal-btn confirm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                    Submit My Bid
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                function openRushConfirm(){
                    const modal=document.getElementById('rush-confirm-backdrop');
                    const inner=document.getElementById('rush-confirm-inner');
                    modal.style.pointerEvents='all';
                    modal.style.opacity='1';
                    inner.style.transform='translateY(0) scale(1)';
                    document.body.style.overflow='hidden';
                }
                function closeRushConfirm(){
                    const modal=document.getElementById('rush-confirm-backdrop');
                    const inner=document.getElementById('rush-confirm-inner');
                    modal.style.opacity='0';
                    inner.style.transform='translateY(24px) scale(0.96)';
                    modal.style.pointerEvents='none';
                    document.body.style.overflow='';
                }
                function submitRushAccept(btn){btn.textContent='Submitting…';btn.disabled=true;document.getElementById('rush-accept-form').submit();}
                document.getElementById('rush-confirm-backdrop').addEventListener('click',function(e){if(e.target===this)closeRushConfirm();});
                </script>
                @if($request->rush_expires_at)
                <div class="rush-expiry">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Expires in: <span id="rush-exp-timer">--</span>
                </div>
                <script>
                (function(){
                    const exp=new Date('{{ $request->rush_expires_at->toISOString() }}');
                    const el=document.getElementById('rush-exp-timer');
                    function tick(){
                        const d=Math.max(0,Math.floor((exp-new Date())/1000));
                        el.textContent=Math.floor(d/60)+':'+String(d%60).padStart(2,'0');
                        el.style.color = d <= 10 ? '#E7A7A0' : '';
                        if(d>0)setTimeout(tick,1000);else el.textContent='Expired';
                    }
                    tick();
                })();
                </script>
                @endif
                @endif
            </div>
            @endif {{-- closes @if($request->status === 'RUSH_MATCHING' && !$myBid) --}}

          @if($myBid)
            {{-- ── ALREADY BID ── --}}
            <div class="mybid-wrap">
                @if($request->status === 'RUSH_MATCHING')
                @php
                    $bakerRecordRush = \App\Models\Baker::where('user_id', auth()->id())->first();
                    $rushFeeDisplay  = (float)($bakerRecordRush?->rush_fee ?? 0);
                    $baseDisplay     = $myBid->amount - $rushFeeDisplay;
                @endphp
                <div class="rush-breakdown">
                    <div class="rush-breakdown-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Your Rush Bid Breakdown
                    </div>
                    <div class="rush-row">
                        <span>Base price</span>
                        <span>₱{{ number_format($baseDisplay, 2) }}</span>
                    </div>
                    <div class="rush-row">
                        <span>Your rush fee</span>
                        <span class="gold">+ ₱{{ number_format($rushFeeDisplay, 2) }}</span>
                    </div>
                    <div class="rush-row total">
                        <span>You earn</span>
                        <span class="gold">₱{{ number_format($myBid->amount, 2) }}</span>
                    </div>
                </div>
                <div class="rush-wait">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span>Customer has <strong>60 seconds</strong> to accept your bid. If no one is chosen in time, the system auto-assigns the nearest baker with the best price.</span>
                </div>
                @endif
                @if($myBid->message)
                <div class="bid-msg">
                    "{{ $myBid->message }}"
                </div>
                @endif
                <div class="info-line">
                    <span>Estimate</span>
                    <strong>{{ $myBid->estimated_days ? $myBid->estimated_days.' days' : '—' }}</strong>
                </div>
                <div class="info-line last">
                    <span>Submitted</span>
                    <strong>{{ $myBid->created_at->diffForHumans() }}</strong>
                </div>
                @if(strtoupper($myBid->status) === 'PENDING')
                <form method="POST" action="{{ route('baker.bids.destroy', $myBid->id) }}" id="withdraw-bid-form">
                    @csrf @method('DELETE')
                </form>
                <button type="button" class="btn-danger" onclick="openWithdrawModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Withdraw Bid
                </button>
                @endif
            </div>

            @else
            {{-- Bid form --}}
            <div class="bid-form-wrap" id="bid-form">
                <form method="POST" action="{{ route('baker.bids.store') }}">
                    @csrf
                    <input type="hidden" name="cake_request_id" value="{{ $request->id }}">

                    <div class="form-group">
                        <label class="form-label">Your Bid (₱) *</label>
                        <input type="number" name="amount" class="form-input"
                               min="1" step="1"
                               placeholder="{{ number_format($request->budget_min, 0) }}"
                               value="{{ old('amount') }}" required>
                        <div class="form-hint">Range: ₱{{ number_format($request->budget_min,0) }}–₱{{ number_format($request->budget_max,0) }}</div>
                    </div>

                    @if($request->is_rush)
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Rush Fee (₱)
                        </label>
                        <input type="number" name="rush_fee" class="form-input"
                               min="0" step="1"
                               placeholder="e.g. 150"
                               value="{{ old('rush_fee', 0) }}">
                        <div class="form-hint">Extra charge you add for rush/urgent handling. Enter 0 if none.</div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Days to Complete *</label>
                        <input type="number" name="estimated_days" class="form-input"
                               min="1" max="60" step="1"
                               placeholder="e.g. 3"
                               value="{{ old('estimated_days') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Message to Customer</label>
                        <textarea name="message" class="form-input form-textarea"
                                  placeholder="Enter notes or comments…">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        Submit Bid
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Quick info card --}}
        <div class="section-card" style="margin-top:1.5rem;">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 9.4l-9-5.19"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    Order Info
                </span>
            </div>
            <div>
                <div class="info-row">
                    <span>Submitted</span>
                    <span>{{ $request->created_at->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span>Fulfillment</span>
                    <span class="accent">{!! $request->fulfillment_label ?? 'Delivery' !!}</span>
                </div>
                <div class="info-row">
                    <span>Total Bids</span>
                    <span>{{ $request->bids()->count() }}</span>
                </div>
            </div>
        </div>

      {{-- Help Center Notice (if a report was filed against baker on this order) --}}
        @php
            $bakerOrderForReport = \App\Models\BakerOrder::where('cake_request_id', $request->id)
                ->where('baker_id', auth()->id())
                ->first();
            $reportOnThisRequest = $bakerOrderForReport
                ? \App\Models\Report::where('reported_id', auth()->id())
                    ->where('baker_order_id', $bakerOrderForReport->id)
                    ->first()
                : null;
        @endphp
        @if($reportOnThisRequest)
        <div class="report-notice">
            <div class="report-notice-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                A report was filed for this order
            </div>
            <div class="report-notice-text">
                Category: <strong>{{ strip_tags(\App\Models\Report::CATEGORIES[$reportOnThisRequest->category] ?? $reportOnThisRequest->category) }}</strong><br>
                Status: <strong>{{ ucfirst($reportOnThisRequest->status) }}</strong> — Our admin team is reviewing this.
            </div>
        </div>
        @endif

        {{-- Reference Image --}}
        @if($request->reference_image)
        <div class="section-card" style="margin-top:1.5rem;">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Reference Image
                </span>
            </div>
            <div class="img-stage">
                <img src="{{ asset('storage/'.$request->reference_image) }}"
                     class="ref-image-full"
                     alt="Reference Image">
            </div>
            <div class="section-foot">Match this style as closely as possible</div>
        </div>
        @endif

        {{-- 3D Preview --}}
        @if($request->cake_preview_image)
        <div class="section-card" style="margin-top:1.5rem;">
            <div class="section-header">
                <span class="section-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>
                    3D Cake Preview
                </span>
            </div>
            <div class="img-stage">
                <img src="{{ asset('storage/'.$request->cake_preview_image) }}"
                     class="preview-image-full"
                     alt="3D Cake Preview">
            </div>
            <div class="section-foot">Customer's 3D cake design preview</div>
        </div>
        @endif

    </div>

</div>

{{-- ── WITHDRAW MODAL (only rendered when $myBid exists) ── --}}
@if($myBid)
<div id="withdraw-modal" class="rd-modal-backdrop withdraw">
    <div id="withdraw-modal-inner" class="rd-modal">
        <div class="rd-modal-head danger">
            <div class="rd-modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </div>
            <div class="rd-modal-title">Withdraw Your Bid?</div>
            <div class="rd-modal-sub">This cannot be undone</div>
        </div>
        <div class="rd-modal-body">
            <div class="rd-modal-summary">
                <div class="rd-modal-row">
                    <span>Request</span>
                    <span>#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="rd-modal-row">
                    <span>Your Bid</span>
                    <span>₱{{ number_format($myBid->amount, 0) }}</span>
                </div>
            </div>
            <p class="rd-modal-note">Withdrawing removes your bid from this request. You can place a new bid if it's still open.</p>
            <div class="rd-modal-actions">
                <button onclick="closeWithdrawModal()" class="rd-modal-btn cancel">Keep Bid</button>
                <button onclick="confirmWithdraw(this)" class="rd-modal-btn confirm danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Yes, Withdraw
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openWithdrawModal() {
    const modal = document.getElementById('withdraw-modal');
    const inner = document.getElementById('withdraw-modal-inner');
    modal.style.pointerEvents = 'all';
    modal.style.opacity = '1';
    inner.style.transform = 'translateY(0) scale(1)';
    document.body.style.overflow = 'hidden';
}
function closeWithdrawModal() {
    const modal = document.getElementById('withdraw-modal');
    const inner = document.getElementById('withdraw-modal-inner');
    modal.style.opacity = '0';
    inner.style.transform = 'translateY(24px) scale(0.96)';
    modal.style.pointerEvents = 'none';
    document.body.style.overflow = '';
}
function confirmWithdraw(btn) {
    btn.textContent = 'Withdrawing…';
    btn.disabled = true;
    document.getElementById('withdraw-bid-form').submit();
}
document.getElementById('withdraw-modal').addEventListener('click', function(e) {
    if (e.target === this) closeWithdrawModal();
});
</script>
@endif {{-- end @if($myBid) for withdraw modal --}}

</div>
@endsection

@push('scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($request->hasMapLocation())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $request->delivery_lat }};
    const lng = {{ $request->delivery_lng }};
    const map = L.map('delivery-map', {
        zoomControl: true,
        dragging: true,
        scrollWheelZoom: false,
        doubleClickZoom: false
    }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:20px;height:20px;background:#B89452;border:3px solid #F7F2E9;border-radius:50%;box-shadow:0 2px 12px rgba(36,21,15,0.5);"></div>`,
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    L.marker([lat, lng], { icon })
        .addTo(map)
        .bindPopup('Customer delivery location')
        .openPopup();
});
</script>
@endif
@endpush