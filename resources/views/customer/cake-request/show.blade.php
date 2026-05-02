    @extends('layouts.customer')
    @section('title', 'Order Tracker — #' . str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT))

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── BASE ── */
    .back-link { display:inline-flex; align-items:center; gap:0.4rem; font-size:0.82rem; color:var(--text-muted); text-decoration:none; margin-bottom:1rem; transition:color 0.2s; }
    .back-link:hover { color:var(--caramel); }

    /* ── HERO TRACKER BANNER ── */
    .tracker-hero {
        border-radius: 24px;
        padding: 2.5rem 3rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: white;
    }

.tracker-hero.status-OPEN                { background: linear-gradient(135deg, #3B1F0F 0%, #7A4A28 100%); }
    .tracker-hero.status-RUSH_MATCHING       { background: linear-gradient(135deg, #1A1A3B 0%, #3A2A7A 100%); }
    .tracker-hero.status-BIDDING             { background: linear-gradient(135deg, #3B1F0F 0%, #7A4A28 100%); }
    .tracker-hero.status-ACCEPTED            { background: linear-gradient(135deg, #2E1508 0%, #6A3A1A 100%); }
    .tracker-hero.status-WAITING_FOR_PAYMENT { background: linear-gradient(135deg, #3B1F0F 0%, #7A4A28 100%); }
    .tracker-hero.status-WAITING_FINAL_PAYMENT { background: linear-gradient(135deg, #2E1508 0%, #6A3A1A 100%); }
    .tracker-hero.status-IN_PROGRESS         { background: linear-gradient(135deg, #2E1508 0%, #6A3A1A 100%); }
    .tracker-hero.status-COMPLETED           { background: linear-gradient(135deg, #1E0F04 0%, #5C3A18 100%); }
    .tracker-hero.status-CANCELLED           { background: linear-gradient(135deg, #5A1A1A 0%, #8B2A2A 100%); }
    .tracker-hero.status-EXPIRED             { background: linear-gradient(135deg, #3B2A1A 0%, #6A4A2A 100%); }

    .tracker-hero::before {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .tracker-hero::after {
        content: '';
        position: absolute;
        right: 80px; bottom: -80px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }

    .hero-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.75rem; position:relative; z-index:1; }
    .hero-request-id { font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; opacity:0.6; margin-bottom:0.4rem; }
    .hero-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.75rem; font-weight:800; line-height:1.2; margin-bottom:0.35rem; }

    .hero-subtitle { font-size:0.85rem; opacity:0.65; }

    .hero-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.1rem;
        border-radius: 20px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .pulse-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #FFE082;
        animation: pulse 1.5s ease-in-out infinite;
        flex-shrink: 0;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.7); }
    }

    /* ── PROGRESS TRACKER STEPS ── */
    .tracker-steps { display:flex; align-items:center; position:relative; z-index:1; }
    .tracker-step { display:flex; flex-direction:column; align-items:center; gap:0.5rem; flex:1; position:relative; }
    .tracker-step::after { content:''; position:absolute; top:16px; left:50%; width:100%; height:2px; background:rgba(255,255,255,0.2); z-index:0; }
    .tracker-step:last-child::after { display:none; }
    .tracker-step-dot {
        width:32px; height:32px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        font-size:0.85rem; font-weight:700;
        position:relative; z-index:1;
        border:2px solid rgba(255,255,255,0.3);
        background:rgba(255,255,255,0.1);
        color:rgba(255,255,255,0.5);
        transition:all 0.3s;
    }
    .tracker-step-dot.done   { background:rgba(255,255,255,0.9); color:#7B4A1E; border-color:white; }
    .tracker-step-dot.active { background:white; color:#7B4A1E; border-color:white; box-shadow:0 0 0 6px rgba(255,255,255,0.2); animation:stepPulse 2s ease-in-out infinite; }
    @keyframes stepPulse {
        0%, 100% { box-shadow: 0 0 0 4px rgba(255,255,255,0.2); }
        50% { box-shadow: 0 0 0 10px rgba(255,255,255,0.08); }
    }
    .tracker-step-label { font-size:0.6rem; font-weight:600; text-align:center; opacity:0.5; letter-spacing:0.05em; text-transform:uppercase; line-height:1.3; }
    .tracker-step-label.done   { opacity:0.8; }
    .tracker-step-label.active { opacity:1; font-weight:700; }

    /* ── PAY CTA INSIDE HERO ── */
    .hero-pay-cta {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; position: relative; z-index: 1;
    }
    .hero-pay-cta-text { font-size: 0.85rem; opacity: 0.8; }
    .hero-pay-cta-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: white; color: #7C3A00;
        padding: 0.6rem 1.35rem; border-radius: 999px;
        font-size: 0.85rem; font-weight: 700; text-decoration: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15); transition: all 0.2s;
    }
    .hero-pay-cta-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,0,0,0.2); color: #7C3A00; text-decoration: none; }

    /* ── WHAT HAPPENS NEXT BOX ── */
    .next-box {
        background:var(--warm-white); border:1px solid var(--border); border-radius:16px;
        padding:1.5rem 2rem; margin-bottom:2rem;
        display:flex; align-items:flex-start; gap:1rem;
    }
    .next-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; }
    .next-icon.yellow { background:#FEF9E8; }
    .next-icon.blue   { background:#FEF3E8; }
    .next-icon.green  { background:#EFF5EF; }
    .next-icon.red    { background:#FDF0EE; }
    .next-icon.orange { background:#FEF3E2; }
    .next-title { font-weight:700; font-size:0.95rem; color:var(--brown-deep); margin-bottom:0.3rem; }
    .next-desc  { font-size:0.82rem; color:var(--text-muted); line-height:1.6; }

    /* ── MAIN LAYOUT ── */
    .tracker-layout { display:grid; grid-template-columns:1fr 300px; gap:1.5rem; align-items:start; }

    /* ── Bid list wrapper ── */
    .bids-list-wrap {
        background: var(--warm-white);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .bids-list-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
    }
    .bids-list-header h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:0.95rem; font-weight:700; color:var(--brown-deep); }

    .bid-count-pill {
        display: inline-flex; align-items: center;
        padding: 0.2rem 0.65rem;
        background: var(--caramel); color: white;
        border-radius: 20px; font-size: 0.68rem; font-weight: 700;
    }

    /* ── Compact bid card ── */
    .bid-card {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
        position: relative;
    }
    .bid-card:last-child { border-bottom: none; }
    .bid-card:hover { background: #FFFAF5; }
    .bid-card::before {
        content: '';
        position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
        background: var(--caramel); border-radius: 3px 0 0 3px;
        opacity: 0; transition: opacity 0.2s;
    }
    .bid-card:hover::before { opacity: 1; }

    .bid-top { display:flex; align-items:center; gap:0.75rem; margin-bottom:0.6rem; }
    .bid-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #C07840, #E8A96A);
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem; flex-shrink: 0; overflow: hidden;
    }
    .bid-avatar img { width:100%; height:100%; object-fit:cover; }
    .bid-name { font-weight: 700; font-size: 0.85rem; color: var(--text-dark); }
    .bid-meta { font-size: 0.67rem; color: var(--text-muted); margin-top: 0.1rem; }
    .bid-stars { color: #F5A623; font-size: 0.65rem; }
    .bid-price { text-align: right; flex-shrink: 0; }
    .bid-price-num { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.15rem; font-weight:800; color:var(--brown-deep); line-height:1; }
    .bid-price-days { font-size: 0.62rem; color: var(--text-muted); margin-top: 0.15rem; }
    .bid-msg {
        font-size: 0.75rem; color: var(--text-mid, #6B5244); line-height: 1.5;
        padding: 0.45rem 0.7rem;
        background: var(--cream, #FDF6F0);
        border-left: 2px solid var(--caramel); border-radius: 0 6px 6px 0;
        margin-bottom: 0.65rem; font-style: italic;
    }
    .bid-bottom { display:flex; align-items:center; justify-content:space-between; gap:0.75rem; }
    .bid-tags { display:flex; flex-wrap:wrap; gap:0.25rem; flex:1; min-width:0; overflow:hidden; max-height:22px; }
    .bid-tag {
        padding: 0.1rem 0.4rem;
        background: var(--cream, #FDF6F0); border: 1px solid var(--border);
        border-radius: 4px; font-size: 0.6rem; color: var(--text-muted); font-weight: 600; white-space: nowrap;
    }
    .btn-accept {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.45rem 0.9rem;
        background: var(--caramel, #C07840); color: white;
        border: none; border-radius: 8px;
        font-size: 0.75rem; font-weight: 700; cursor: pointer;
        font-family:'Plus Jakarta Sans', sans-serif
        box-shadow: 0 2px 8px rgba(192,120,64,0.3);
        transition: all 0.2s; white-space: nowrap; flex-shrink: 0;
    }
    .btn-accept:hover { background: #A86030; transform: translateY(-1px); }

    /* ── Right: request summary sidebar ── */
    .bids-sidebar { position: sticky; top: 5rem; }
    .bids-summary-card {
        background: var(--warm-white);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .bids-summary-top {
        background: linear-gradient(135deg, #5C3D2E, #9B6030);
        color: white;
        padding: 1.25rem 1.25rem 1rem;
    }
    .bss-label { font-size: 0.6rem; letter-spacing: 0.18em; text-transform: uppercase; opacity: 0.5; }
    .bss-id { font-family:'Plus Jakarta Sans',sans-serif; font-size: 2.2rem; font-weight:800; color: #FFD49A; line-height: 1; margin: 0.25rem 0 0.15rem; }

    .bss-date { font-size: 0.68rem; opacity: 0.4; }
    .bss-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.7rem 1.25rem; border-bottom: 1px solid var(--border);
    }
    .bss-row:last-child { border-bottom: none; }
    .bss-key { font-size: 0.65rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; }
    .bss-val { font-size: 0.8rem; font-weight: 600; color: var(--text-dark); text-align: right; max-width: 55%; }

    /* ── CARDS ── */
    .card { background:var(--warm-white); border:1px solid var(--border); border-radius:20px; overflow:hidden; margin-bottom:1.5rem; }
    .card:last-child { margin-bottom:0; }
    .card-header { padding:1.1rem 1.75rem; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .card-header h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:0.95rem; font-weight:700; color:var(--brown-deep); }


    .config-grid { display:grid; grid-template-columns:1fr 1fr; }
    .config-item { padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); border-right:1px solid var(--border); }
    .config-item:nth-child(even) { border-right:none; }
    .config-item:nth-last-child(-n+2) { border-bottom:none; }
    .c-label { font-size:0.65rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--text-muted); font-weight:600; margin-bottom:0.25rem; }
    .c-value { font-size:0.88rem; font-weight:600; color:var(--brown-deep); }

    .info-row { display:flex; justify-content:space-between; align-items:center; padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); gap:1rem; }
    .info-row:last-child { border-bottom:none; }
    .i-key { font-size:0.72rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.08em; }
    .i-val { font-size:0.86rem; color:var(--text-dark); font-weight:500; text-align:right; }
    .notes-box { padding:1.1rem 1.5rem; font-size:0.86rem; color:var(--text-dark); line-height:1.65; }

    /* ── SIDEBAR ── */
    .id-card {
        background: linear-gradient(135deg, var(--brown-deep, #5C3D2E), var(--brown-mid, #7B4F3A));
        border-radius: 20px; padding: 1.75rem 1.5rem; text-align: center; margin-bottom: 1.5rem; color: white;
    }
    .id-label { font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; opacity:0.45; margin-bottom:0.3rem; }
    .id-num { font-family:'Plus Jakarta Sans',sans-serif; font-size:2.75rem; font-weight:800; color:var(--caramel-light, #E8C9A8); line-height:1; }
    .id-date { font-size:0.7rem; opacity:0.35; margin-top:0.4rem; }
    .id-divider { border:none; border-top:1px solid rgba(255,255,255,0.1); margin:1rem 0; }

    .timeline-log { padding:0; list-style:none; }
    .timeline-log li { padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:flex-start; gap:0.75rem; font-size:0.8rem; }
    .timeline-log li:last-child { border-bottom:none; }
    .log-dot { width:8px; height:8px; border-radius:50%; background:var(--caramel); flex-shrink:0; margin-top:0.3rem; }
    .log-event { font-weight:600; color:var(--text-dark); }
    .log-time { font-size:0.7rem; color:var(--text-muted); margin-top:0.1rem; }

    .btn { display:inline-flex; align-items:center; justify-content:center; gap:0.4rem; padding:0.75rem 1.4rem; border-radius:10px; font-size:0.875rem; font-weight:600; text-decoration:none; cursor:pointer; border:none; transition:all 0.2s; font-family:'Plus Jakarta Sans', sans-serif; width:100%; }
    .btn-danger  { background:#FDF0EE; color:#8B2A1E; border:1.5px solid #F5C5BE; }
    .btn-danger:hover { background:#F5C5BE; }
    .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--text-mid, #6B5244); margin-top:0.5rem; }
    .btn-outline:hover { border-color:var(--caramel); color:var(--caramel); }

    /* ── SUCCESS TOAST ── */
    .success-toast {
        display:flex; align-items:center; gap:0.85rem;
        background:#FBF4EC; border:1px solid #D4B896; border-radius:14px;
        padding:1rem 1.5rem; margin-bottom:1.5rem; animation:slideIn 0.4s ease;
    }
    @keyframes slideIn { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
    .toast-icon  { font-size:1.5rem; flex-shrink:0; }
    .toast-title { font-weight:700; color:var(--brown-deep, #5C3D2E); font-size:0.9rem; }
    .toast-sub   { font-size:0.78rem; color:var(--caramel, #C07840); margin-top:0.1rem; }

    /* ── BIDS WAITING / CONFIRMED BAKER ── */
    .bids-waiting { padding:2.5rem 1.5rem; text-align:center; }
    .bids-waiting-icon { font-size:2.5rem; margin-bottom:0.85rem; display:block; animation:bob 2.5s ease-in-out infinite; }
    @keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    .bids-waiting-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1rem; font-weight:700; color:var(--brown-deep); margin-bottom:0.4rem; }
    .bids-waiting-sub { font-size:0.78rem; color:var(--text-muted); line-height:1.6; }

    .confirmed-baker-card { margin:1.25rem 1.5rem; border:1.5px solid #D4B896; border-radius:14px; overflow:hidden; background:#FBF4EC; }
    .confirmed-baker-header { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.25rem; background:#F5E8D4; border-bottom:1px solid #D4B896; }
    .confirmed-baker-body { padding:1.1rem 1.25rem; }
    .confirmed-price { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.5rem; color:var(--brown-deep, #5C3D2E); font-weight:800; }
    .confirmed-label { font-size:0.68rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--caramel, #C07840); font-weight:600; }

    .bid-baker-info { display:flex; align-items:center; gap:0.75rem; }
    .bid-baker-name { font-weight:700; font-size:0.875rem; color:var(--text-dark); }
    .bid-baker-meta { font-size:0.7rem; color:var(--text-muted); margin-top:0.1rem; display:flex; align-items:center; gap:0.4rem; }
    .bid-baker-avatar {
        width:40px; height:40px; border-radius:50%;
        background:linear-gradient(135deg, #C07840, #E8A96A);
        color:white; display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:0.95rem; flex-shrink:0; overflow:hidden;
    }
    .bid-baker-avatar img { width:100%; height:100%; object-fit:cover; }
    .bid-stars { color:#F5A623; letter-spacing:1px; font-size:0.72rem; }
    .bid-specs { display:flex; flex-wrap:wrap; gap:0.3rem; }
    .bid-spec-tag { padding:0.15rem 0.55rem; background:var(--cream,#FDF6F0); border:1px solid var(--border); border-radius:6px; font-size:0.65rem; color:var(--text-muted); font-weight:600; }

    /* ── BAKING PROGRESS ── */
    .baker-progress-wrap { padding:1.25rem 1.5rem; }
    .baker-steps { display:flex; align-items:flex-start; gap:0; width:100%; }
    .b-step { flex:1; display:flex; flex-direction:column; align-items:center; gap:0; min-width:0; }
    .b-step-row { display:flex; align-items:center; width:100%; justify-content:center; }
    .b-connector { flex:1; height:2px; min-width:0; }
    .b-dot { width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.65rem; font-weight:700; flex-shrink:0; transition:all 0.3s; position:relative; z-index:1; }
    .b-dot.done    { background:var(--caramel); color:white; }
    .b-dot.active  { background:white; border:2.5px solid var(--caramel); color:var(--caramel); animation:stepPulse 2s ease-in-out infinite; }
    .b-dot.pending { background:var(--cream,#FDF6F0); border:2px solid var(--border); color:var(--text-muted); }
    .b-label { font-size:0.56rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-muted); margin-top:0.4rem; text-align:center; font-weight:600; }
    .b-label.active { color:var(--caramel); }

    .payment-section-card {
        background: var(--warm-white);
        border-radius: 20px;
        border: 2px solid #f0d090;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(200,134,42,0.1);
        position: relative;
    }
    .payment-section-card::before {
        content: '';
        position: absolute; top:0; left:0; right:0; height:3px;
        background: linear-gradient(90deg, #c8862a, #e8a94a, #c8862a);
    }
    .psc-header { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid #f0e8d0; }
    .psc-header-left { display:flex; align-items:center; gap:0.75rem; }
    .psc-icon { width:36px; height:36px; background:linear-gradient(135deg,#c8862a,#e8a94a); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .psc-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:0.95rem; color:var(--brown-deep); font-weight:700; }
    .psc-sub { font-size:0.72rem; color:var(--text-muted); margin-top:0.1rem; }
    .psc-manage-btn { font-size:0.78rem; color:#c8862a; font-weight:600; text-decoration:none; padding:0.4rem 0.9rem; border:1.5px solid #f0c070; border-radius:8px; transition:background 0.2s; }
    .psc-manage-btn:hover { background:#fef8ed; }
    .psc-split { display:flex; flex-direction:column; padding:1rem 1.25rem; gap:0.6rem; }
    .psc-half { width:100%; border-radius:12px; padding:0.85rem 1rem; display:flex; align-items:center; justify-content:space-between; }
    .half-paid     { background:#f0fbf4; border:1.5px solid #b8dfc6; }
    .half-pending  { background:#fef8ed; border:1.5px solid #f0d090; }
    .half-locked   { background:#f5f5f5; border:1.5px solid #e0e0e0; }
    .half-rejected { background:#FDF0EE; border:1.5px solid #F5C5BE; }
    .half-left { display:flex; flex-direction:column; gap:0.15rem; }
    .half-label { font-size:0.62rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); }
    .half-amount { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.25rem; font-weight:800; color:var(--brown-deep); line-height:1.1; }
    .half-status { font-size:0.72rem; font-weight:600; margin-top:0.1rem; }
    .half-status.paid     { color:#16a34a; }
    .half-status.pending  { color:#c8862a; }
    .half-status.locked   { color:#aaa; }
    .half-status.rejected { color:#8B2A1E; }
    .psc-divider { display:flex; align-items:center; gap:0.5rem; padding:0 0.25rem; }
    .psc-divider-line { flex:1; height:1px; background:#e8dfc8; }
    .psc-total { font-size:0.65rem; font-weight:700; color:var(--text-muted); white-space:nowrap; flex-shrink:0; }
    .psc-cta { padding:1rem 1.5rem; background:#fffaf0; border-top:1px solid #f0e8d0; text-align:center; }
    .psc-pay-btn { display:inline-block; background:linear-gradient(135deg,#c8862a,#e8a94a); color:white; text-decoration:none; padding:0.75rem 2rem; border-radius:10px; font-size:0.875rem; font-weight:700; box-shadow:0 4px 12px rgba(200,134,42,0.35); transition:all 0.2s; }
    .psc-pay-btn:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(200,134,42,0.45); color:white; text-decoration:none; }
    .psc-cta-note { margin-top:0.5rem; font-size:0.72rem; color:var(--text-muted); }
    .psc-paid-notice { padding:0.85rem 1.5rem; background:#FBF4EC; border-top:1px solid #D4B896; display:flex; align-items:center; gap:0.5rem; font-size:0.78rem; color:var(--brown-deep,#5C3D2E); font-weight:600; }

    /* ── REJECTION ALERT ── */
    .rejection-alert {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #F5C5BE;
        margin-bottom: 0;
    }
    .rejection-alert-header {
        background: linear-gradient(135deg, #5A1A1A, #8B2E2E);
        padding: 0.75rem 1rem;
        display: flex; align-items: center; gap: 0.6rem; color: white;
    }
    .rejection-alert-icon {
        width: 28px; height: 28px; border-radius: 8px;
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; flex-shrink: 0;
    }
    .rejection-alert-title { font-weight: 700; font-size: 0.82rem; }
    .rejection-alert-sub { font-size: 0.68rem; opacity: 0.7; margin-top: 0.1rem; }
    .rejection-count-badge {
        margin-left: auto;
        padding: 0.15rem 0.5rem; border-radius: 20px;
        background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
        font-size: 0.65rem; font-weight: 700; white-space: nowrap;
    }
    .rejection-body { padding: 0.85rem 1rem; background: #FDF5F3; display: flex; flex-direction: column; gap: 0.6rem; }
    .rejection-reason-display {
        background: white; border: 1px solid #F5C5BE; border-radius: 8px;
        padding: 0.55rem 0.75rem;
    }
    .rejection-reason-display .rr-label {
        font-size: 0.58rem; text-transform: uppercase; letter-spacing: 0.1em;
        color: #8B2A1E; font-weight: 700; margin-bottom: 0.15rem;
    }
    .rejection-reason-display .rr-text { font-size: 0.8rem; font-weight: 600; color: #5A1A1A; }
    .rejection-reason-display .rr-note { font-size: 0.72rem; color: #7A2A20; margin-top: 0.2rem; font-style: italic; line-height: 1.4; }
    .rejection-warning-box {
        background: #FEF9E8; border: 1px solid #F0D090; border-radius: 8px;
        padding: 0.55rem 0.75rem;
        display: flex; align-items: flex-start; gap: 0.4rem;
        font-size: 0.73rem; color: #8A5010; line-height: 1.5;
    }
    .rejection-cancelled-box {
        background: #FDF0EE; border: 1px solid #F5C5BE; border-radius: 8px;
        padding: 0.75rem 1rem; text-align: center;
    }
    .rejection-cancelled-box .rc-icon { font-size: 1.25rem; margin-bottom: 0.3rem; }
    .rejection-cancelled-box .rc-title { font-weight: 700; color: #8B2A1E; font-size: 0.82rem; margin-bottom: 0.2rem; }
    .rejection-cancelled-box .rc-sub { font-size: 0.72rem; color: #7A2A20; line-height: 1.4; }

    /* ── REUPLOAD FORM ── */
    .reupload-form-wrap { display: flex; flex-direction: column; gap: 0.5rem; }
    .reupload-dropzone {
        border: 1.5px dashed #F5C5BE; border-radius: 10px;
        padding: 0.85rem 1rem; cursor: pointer;
        background: white; transition: all 0.2s; position: relative;
        display: flex; align-items: center; gap: 0.75rem;
    }
    .reupload-dropzone:hover { border-color: #8B2A1E; background: #FDF5F3; }
    .reupload-dropzone.has-file { border-color: #8B2A1E; background: #FDF5F3; }
    .reupload-dropzone-icon { font-size: 1.1rem; flex-shrink: 0; }
    .reupload-dropzone-text { font-size: 0.78rem; font-weight: 600; color: #8B2A1E; }
    .reupload-dropzone-sub { font-size: 0.66rem; color: var(--text-muted); margin-top: 0.1rem; }
    .reupload-preview { width: 48px; height: 48px; object-fit: cover; border-radius: 6px; display: none; flex-shrink: 0; margin-left: auto; }
    .reupload-filename { font-size: 0.7rem; color: #5A1A1A; font-weight: 600; margin-left: auto; display: none; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .reupload-file-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; }
    .reupload-submit-btn {
        padding: 0.55rem 1rem;
        background: linear-gradient(135deg, #8B2A1E, #C44030);
        color: white; border: none; border-radius: 8px;
        font-size: 0.78rem; font-weight: 700; cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif
        transition: all 0.2s; align-self: flex-end;
        display: inline-flex; align-items: center; gap: 0.35rem;
    }
    .reupload-submit-btn:disabled { opacity: 0.4; cursor: not-allowed; }
    .reupload-submit-btn:not(:disabled):hover { opacity: 0.9; transform: translateY(-1px); }

    /* ═══════════════════════════════════════════
    CUSTOM CONFIRMATION MODALS
    ═══════════════════════════════════════════ */
    .confirm-modal-backdrop {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(20, 10, 4, 0.65);
        backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center;
        padding: 1rem; opacity: 0; pointer-events: none; transition: opacity 0.25s ease;
    }
    .confirm-modal-backdrop.is-open { opacity: 1; pointer-events: all; }
    .confirm-modal {
        background: var(--warm-white, #FFFDF9); border-radius: 24px; width: 100%; max-width: 400px;
        overflow: hidden; box-shadow: 0 32px 80px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.1);
        transform: translateY(20px) scale(0.96); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .confirm-modal-backdrop.is-open .confirm-modal { transform: translateY(0) scale(1); }
    .confirm-modal-header { padding: 2rem 2rem 1.5rem; text-align: center; }
    .confirm-modal-header.variant-danger  { background: linear-gradient(135deg, #5A1A1A, #8B2E2E); }
    .confirm-modal-header.variant-accept  { background: linear-gradient(135deg, #7B4A1E, #C07840); }
    .confirm-modal-header.variant-advance { background: linear-gradient(135deg, #4A2E08, #9A6830); }
    .confirm-modal-icon {
        width: 64px; height: 64px; border-radius: 50%;
        background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.25);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.75rem; margin: 0 auto 1rem;
    }
    .confirm-modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.25rem; font-weight: 700; color: white; margin-bottom: 0.35rem; line-height: 1.3; }
    .confirm-modal-subtitle { font-size: 0.78rem; color: rgba(255,255,255,0.65); line-height: 1.5; }
    .confirm-modal-body { padding: 1.5rem 2rem; }
    .confirm-modal-detail { background: var(--cream, #F5EFE6); border: 1px solid var(--border, #EAE0D0); border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
    .confirm-modal-detail-row { display: flex; justify-content: space-between; align-items: center; padding: 0.35rem 0; font-size: 0.82rem; }
    .confirm-modal-detail-row:not(:last-child) { border-bottom: 1px solid var(--border, #EAE0D0); margin-bottom: 0.35rem; padding-bottom: 0.5rem; }
    .confirm-modal-detail-key { color: var(--text-muted, #9A7A5A); font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; }
    .confirm-modal-detail-val { font-weight: 700; color: var(--brown-deep, #3B1F0F); font-size: 0.86rem; text-align: right; }
    .confirm-modal-note { font-size: 0.76rem; color: var(--text-muted, #9A7A5A); line-height: 1.6; text-align: center; padding: 0 0.5rem; }
    .confirm-modal-footer { display: flex; gap: 0.75rem; padding: 0 2rem 2rem; }
    .confirm-modal-btn-cancel {
        flex: 1; padding: 0.75rem 1rem; border-radius: 12px;
        border: 1.5px solid var(--border, #EAE0D0); background: white; color: var(--text-mid, #6B4A2A);
        font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif transition: all 0.2s;
    }
    .confirm-modal-btn-cancel:hover { border-color: var(--text-muted); color: var(--text-dark); }
    .confirm-modal-btn-ok {
        flex: 2; padding: 0.75rem 1rem; border-radius: 12px; border: none;
        font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif
        transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    }
    .confirm-modal-btn-ok:hover { transform: translateY(-1px); }
    .confirm-modal-btn-ok:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .confirm-modal-btn-ok.style-danger {
        background: linear-gradient(135deg, #8B2A1E, #C44030); color: white; box-shadow: 0 4px 14px rgba(139,42,30,0.4);
    }
    .confirm-modal-btn-ok.style-danger:hover { box-shadow: 0 6px 20px rgba(139,42,30,0.5); }
    .confirm-modal-btn-ok.style-accept {
        background: linear-gradient(135deg, #7B4A1E, #C07840); color: white; box-shadow: 0 4px 14px rgba(192,120,64,0.4);
    }
    .confirm-modal-btn-ok.style-accept:hover { box-shadow: 0 6px 20px rgba(192,120,64,0.5); }

    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-spinner {
        width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: white;
        border-radius: 50%; animation: spin 0.7s linear infinite; display: none;
    }
    .is-loading .btn-spinner { display: block; }
    .is-loading .btn-text { display: none; }

    /* ── ACCEPT BID MODAL ── */
    .modal-backdrop {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(30, 15, 5, 0.55);
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .modal-backdrop.open { opacity: 1; pointer-events: all; }
    .modal-box {
        background: var(--warm-white, #FFFAF5); border-radius: 24px; padding: 0;
        width: 100%; max-width: 420px; box-shadow: 0 24px 60px rgba(0,0,0,0.2);
        overflow: hidden; transform: translateY(16px) scale(0.97);
        transition: transform 0.28s cubic-bezier(0.34,1.56,0.64,1);
    }
    .modal-backdrop.open .modal-box { transform: translateY(0) scale(1); }
    .modal-header { background: linear-gradient(135deg, #7B4A1E, #C07840); padding: 1.75rem 2rem 1.5rem; color: white; text-align: center; }
    .modal-header-icon { font-size: 2.5rem; margin-bottom: 0.5rem; display: block; }
    .modal-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.2rem; }
    .modal-header-sub { font-size: 0.78rem; opacity: 0.7; }
    .modal-body { padding: 1.5rem 2rem; }
    .modal-baker-row { display:flex; align-items:center; gap:1rem; background:#FDF6F0; border:1px solid #F0E0C8; border-radius:14px; padding:1rem 1.25rem; margin-bottom:1.25rem; }
    .modal-baker-avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,#C07840,#E8A96A); color:white; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.1rem; flex-shrink:0; }
    .modal-baker-name { font-weight:700; font-size:0.9rem; color:var(--brown-deep,#5C3D2E); }
    .modal-baker-meta { font-size:0.72rem; color:var(--text-muted,#8B6E5A); margin-top:0.15rem; }
    .modal-price-row { display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; border-top:1px solid #F0E0C8; }
    .modal-price-label { font-size:0.72rem; color:var(--text-muted,#8B6E5A); font-weight:600; text-transform:uppercase; letter-spacing:0.08em; }
    .modal-price-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.4rem; color:var(--brown-deep,#5C3D2E); font-weight:800; }
    .modal-price-split { font-size:0.7rem; color:var(--text-muted,#8B6E5A); text-align:right; margin-top:0.1rem; }
    .modal-note { font-size:0.78rem; color:var(--text-muted,#8B6E5A); line-height:1.6; text-align:center; padding:0.75rem 0.5rem 0; }
    .modal-footer { display:flex; gap:0.75rem; padding:1.25rem 2rem 1.75rem; }
    .modal-btn-cancel { flex:1; padding:0.75rem; border-radius:12px; border:1.5px solid #E0D0C0; background:white; color:var(--text-mid,#6B5244); font-size:0.875rem; font-weight:600; cursor:pointer; font-family:'Plus Jakarta Sans', sans-serif; transition:all 0.2s; }
    .modal-btn-cancel:hover { border-color:var(--caramel,#C07840); color:var(--caramel,#C07840); }
    .modal-btn-confirm { flex:2; padding:0.75rem; border-radius:12px; border:none; background:linear-gradient(135deg,#7B4A1E,#C07840); color:white; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans', sans-serif; box-shadow:0 4px 14px rgba(192,120,64,0.4); transition:all 0.2s; }
    .modal-btn-confirm:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(192,120,64,0.5); }
    </style>
    @endpush

    @section('content')
    {{-- Rush modal handled by #rushMatchModal below --}}
    <a href="{{ route('customer.cake-requests.index') }}" class="back-link">← All Orders</a>

    @php
    // Rush and normal orders now follow the same bidding flow.
    // Rush orders just show an ⚡ badge to bakers so they know to prioritise.
$steps = [
        ['key'=>'OPEN',                  'label'=>'Submitted',    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>'],
        ['key'=>'RUSH_MATCHING',         'label'=>'Matching',     'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>'],
        ['key'=>'WAITING_FOR_PAYMENT',   'label'=>'Downpay',      'icon'=>'₱'],
        ['key'=>'IN_PROGRESS',           'label'=>'Preparing',    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11h18"/><path d="M4 11V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4"/><path d="M9 11V6"/><path d="M15 11V6"/><rect x="2" y="11" width="20" height="9" rx="2"/></svg>'],
        ['key'=>'WAITING_FINAL_PAYMENT', 'label'=>$cakeRequest->isPickup() ? 'Pickup' : 'Final Pay', 'icon'=>$cakeRequest->isPickup() ? '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/><path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4"/><path d="M9 14h6"/></svg>' : '₱'],
        ['key'=>'COMPLETED',             'label'=>$cakeRequest->isPickup() ? 'Collected' : 'Delivered', 'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'],
    ];
    $rushOrder = ['OPEN','RUSH_MATCHING','WAITING_FOR_PAYMENT','IN_PROGRESS','WAITING_FINAL_PAYMENT','COMPLETED'];
    $order = $cakeRequest->is_rush
        ? $rushOrder
        : ['OPEN','BIDDING','ACCEPTED','WAITING_FOR_PAYMENT','IN_PROGRESS','WAITING_FINAL_PAYMENT','COMPLETED'];
        $currentIdx = array_search($cakeRequest->status, $order);
        if ($currentIdx === false) $currentIdx = -1;

        // 1A: WAITING_FINAL_PAYMENT is now pickup-aware
        $statusMessages = [
'OPEN'                   => ['title'=>'Waiting for Bakers', 'sub'=>'Your request is live. Bakers are reviewing it now.'],
            'RUSH_MATCHING'          => ['icon'=>'⚡','color'=>'blue',  'title'=>'Choose your rush baker!',          'desc'=>'Nearby rush bakers have been notified and will submit their prices. Accept the best offer before the 60-second timer expires!'],
            'BIDDING'                => ['title'=>'Bakers Are Bidding!',          'sub'=>'Review the offers below and accept the best one.'],
    'ACCEPTED'               => ['title'=>'Baker Confirmed!',             'sub'=>'Your baker is getting started. You\'ll be notified when your cake is ready.'],
            'WAITING_FOR_PAYMENT'    => ['title'=>'Pay Your Downpayment',     'sub'=>'Your baker is ready and waiting. Send the 50% downpayment to begin preparation.'],
        'IN_PROGRESS'            => ['title'=>'Your Cake is Being Made!',     'sub'=>'Your baker is crafting your cake. You\'ll receive a photo once it\'s ready!'],
            'WAITING_FINAL_PAYMENT'  => [
                'title' => $cakeRequest->isPickup()
                    ? ' Ready for Pickup — Pay Cash'
                    : '💰 Pay Final 50%',
                'sub'   => $cakeRequest->isPickup()
                    ? 'Your cake is ready! Visit the baker, collect your cake, and pay the remaining balance in cash.'
                    : 'Your cake is ready! Pay the remaining balance so your baker can deliver it to you.',
            ],
            'COMPLETED'              => ['title'=>'Order Completed! ',          'sub'=>$cakeRequest->isPickup() ? 'Your cake has been collected. Enjoy!' : 'Your cake has been delivered. Enjoy!'],
            'CANCELLED'              => ['title'=>'Request Cancelled',            'sub'=>'This request was cancelled.'],
            'EXPIRED'                => ['title'=>'Request Expired',              'sub'=>'No baker accepted this request in time.'],
        ];
        $msg = $statusMessages[$cakeRequest->status] ?? ['title'=>$cakeRequest->status,'sub'=>''];

        $config = is_array($cakeRequest->cake_configuration)
            ? $cakeRequest->cake_configuration
            : (json_decode($cakeRequest->cake_configuration, true) ?? []);

        $bakerOrder = $cakeRequest->bakerOrder ?? null;

        $bOrderStatuses = ['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED'];
        $bOrderLabels   = ['Accepted','Awaiting Down','Preparing','Ready',$cakeRequest->isPickup() ? 'Pickup Pay' : 'Awaiting Final',$cakeRequest->isPickup() ? 'Collected' : 'Delivered'];
        $bOrderIcons    = ['✓','₱','🥣','📦',$cakeRequest->isPickup() ? '' : '💰',$cakeRequest->isPickup() ? '' : ''];

        $bakerDisplayStatus = $bakerOrder?->status === 'COMPLETED' ? 'DELIVERED' : $bakerOrder?->status;
        $bCurrentStep = $bakerOrder ? (array_search($bakerDisplayStatus, $bOrderStatuses) ?: 0) : -1;
    $acceptedBid        = null;
        $downpayment        = null;
        $finalPayment       = null;
        $downpaymentAmount  = $bakerOrder ? round($bakerOrder->agreed_price * 0.5, 2) : 0;
        $bakerPaymentMethods = collect();
        if (in_array($cakeRequest->status, ['ACCEPTED','WAITING_FOR_PAYMENT','WAITING_FINAL_PAYMENT','IN_PROGRESS','COMPLETED'])) {
            $acceptedBid = $cakeRequest->bids->whereIn('status', ['ACCEPTED', 'accepted'])->first();

if ($acceptedBid) {
                $downpaymentAmount = round(($bakerOrder ? $bakerOrder->agreed_price : $acceptedBid->amount) * 0.5, 2);
            $downpayment  = \App\Models\Payment::where('cake_request_id', $cakeRequest->id)->where('payment_type', 'downpayment')->first();
    $finalPayment = \App\Models\Payment::where('cake_request_id', $cakeRequest->id)->where('payment_type', 'final')->first();
                $bakerRecord = \App\Models\Baker::where('user_id', $acceptedBid->baker_id)->first();
                if ($bakerRecord) {
                    $bakerPaymentMethods = \App\Models\BakerPaymentMethod::where('baker_id', $bakerRecord->id)->where('is_active', true)->get();
                }
            }

            if (!$acceptedBid && $bakerOrder) {
                $downpaymentAmount = round($bakerOrder->agreed_price * 0.5, 2);
            $downpayment  = \App\Models\Payment::where('cake_request_id', $cakeRequest->id)->where('payment_type', 'downpayment')->first();
    $finalPayment = \App\Models\Payment::where('cake_request_id', $cakeRequest->id)->where('payment_type', 'final')->first();
                $bakerRecordFb = \App\Models\Baker::where('user_id', $bakerOrder->baker_id)->first();
                if ($bakerRecordFb) {
                    $bakerPaymentMethods = \App\Models\BakerPaymentMethod::where('baker_id', $bakerRecordFb->id)->where('is_active', true)->get();
                    $acceptedBid = (object)['amount' => $bakerOrder->agreed_price, 'baker_id' => $bakerOrder->baker_id];
                    $downpaymentAmount = round($bakerOrder->agreed_price * 0.5, 2);
                }
            }
        }
    $downIsRejected  = $downpayment  && $downpayment->status  === 'rejected';
    $finalIsRejected = $finalPayment && $finalPayment->status === 'rejected';
    $downIsPending   = $downpayment  && $downpayment->status  === 'pending';
    $finalIsPending  = $finalPayment && $finalPayment->status === 'pending';
        $rejectionReasons = \App\Models\Payment::REJECTION_REASONS;

        $effectiveStatus = $cakeRequest->status;
        if ($bakerOrder) {
            if ($bakerOrder->status === 'WAITING_FINAL_PAYMENT' && $cakeRequest->status === 'IN_PROGRESS') {
                $effectiveStatus = 'WAITING_FINAL_PAYMENT';
                $cakeRequest->updateQuietly(['status' => 'WAITING_FINAL_PAYMENT']);
                $cakeRequest->status = 'WAITING_FINAL_PAYMENT';
            }
            if ($bakerOrder->status === 'WAITING_FOR_PAYMENT' && $cakeRequest->status === 'ACCEPTED') {
                $effectiveStatus = 'WAITING_FOR_PAYMENT';
                $cakeRequest->updateQuietly(['status' => 'WAITING_FOR_PAYMENT']);
                $cakeRequest->status = 'WAITING_FOR_PAYMENT';
            }
        }
    $currentIdx = array_search($cakeRequest->status, $order);
        if ($currentIdx === false) $currentIdx = -1;
        $msg = $statusMessages[$cakeRequest->status] ?? ['title'=>$cakeRequest->status,'sub'=>''];

        // Override: customer already paid final — waiting for baker to confirm delivery
        if ($effectiveStatus === 'WAITING_FINAL_PAYMENT' && $finalPayment && $finalPayment->escrow_status === 'held') {
            $msg = [
                'title' => ' Waiting for Delivery',
                'sub'   => 'Your final payment is confirmed and held securely. Your baker will confirm delivery shortly.',
            ];
        }
    @endphp

    {{-- ── HERO TRACKER ── --}}
    <div class="tracker-hero status-{{ $cakeRequest->status }}">
        <div class="hero-top">
            <div>
                <div class="hero-request-id">Request ID · #{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="hero-title">{{ $msg['title'] }}</div>
                <div class="hero-subtitle">{{ $msg['sub'] }}</div>
            </div>
            <div class="hero-status-badge">
             @if(in_array($cakeRequest->status, ['OPEN','BIDDING','WAITING_FOR_PAYMENT','WAITING_FINAL_PAYMENT']))
                    <div class="pulse-dot"></div>
                @else
                    <span>
                        @if($cakeRequest->status === 'COMPLETED') <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        @elseif(in_array($cakeRequest->status, ['CANCELLED','EXPIRED'])) <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        @else ●
                        @endif
                    </span>
                @endif
    {{ str_replace('_',' ',$cakeRequest->status) }}
            </div>
        </div>
@if(!in_array($cakeRequest->status, ['CANCELLED','EXPIRED']) && !in_array($cakeRequest->status, ['OPEN','BIDDING','RUSH_MATCHING']))
        <div class="tracker-steps">
            @foreach($steps as $step)
            @php
                $stepIdx = array_search($step['key'], $order);
                $isDone  = $stepIdx < $currentIdx;
                $isActive= $stepIdx === $currentIdx;
            @endphp
            <div class="tracker-step">
                <div class="tracker-step-dot {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
     @if($isDone) <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> @else {!! $step['icon'] !!} @endif
                </div>
                <div class="tracker-step-label {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                    {{ $step['label'] }}
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>

    {{-- ── WHAT HAPPENS NEXT ── --}}
    @php
     $nextInfo = [
    'OPEN'                   => ['icon'=>'hourglass','color'=>'yellow','title'=>'What happens next?',              'desc'=>"Bakers are reviewing your request. You'll be notified as soon as someone places a bid."],
    'RUSH_MATCHING'          => ['icon'=>'bolt',     'color'=>'blue',  'title'=>'Choose your rush baker!',         'desc'=>'Nearby rush bakers have been notified and will submit their prices. Accept the best offer before the 60-second timer expires!'],
    'BIDDING'                => ['icon'=>'bell',     'color'=>'yellow','title'=>'You have bids!',                  'desc'=>'Review each baker\'s offer below — check their price, estimated days, and message, then accept the best one.'],
    'ACCEPTED'               => ['icon'=>'cake',     'color'=>'green', 'title'=>'Your baker is confirmed!',        'desc'=>'Your baker is getting started on your order. You\'ll be notified when it\'s time to pay your downpayment.'],
    'WAITING_FOR_PAYMENT'    => ['icon'=>'peso',     'color'=>'orange','title'=>'Action required: Pay now!',       'desc'=>'Your baker is confirmed and ready to start. Pay the 50% downpayment so they can begin preparing your cake.'],
    'WAITING_FINAL_PAYMENT'  => $cakeRequest->isPickup()
                ? ['icon'=>'store',   'color'=>'orange','title'=>'Action required: Go collect your cake!',  'desc'=>'Your cake is ready at the baker\'s location. Visit them, bring ₱' . number_format($downpaymentAmount, 2) . ' cash, and collect your cake!']
                : ['icon'=>'peso',    'color'=>'orange','title'=>'Action required: Pay final 50%!',         'desc'=>'Your baker has finished your cake and sent a photo above for your review. Pay the remaining balance so your baker can deliver it to you.'],
    'COMPLETED'              => ['icon'=>'check',    'color'=>'green', 'title'=>'Order complete!',                 'desc'=>'We hope you loved it! Feel free to place another order anytime.'],
    'CANCELLED'              => ['icon'=>'x',        'color'=>'red',   'title'=>'Request cancelled',               'desc'=>'You can create a new cake request anytime from your dashboard.'],
    'EXPIRED'                => ['icon'=>'clock',    'color'=>'red',   'title'=>'No bakers responded',             'desc'=>'Try a new request with a wider budget or further delivery date.'],
        ];
       $next = $nextInfo[$effectiveStatus] ?? $nextInfo[$cakeRequest->status] ?? null;
        $nextIconSvg = [
            'hourglass' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>',
            'bolt'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
            'bell'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
            'cake'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>',
            'peso'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg>',
            'store'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/><path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4"/><path d="M9 14h6"/></svg>',
            'check'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            'x'         => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
            'clock'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        ];
    @endphp

    {{-- ── MAIN TWO-COLUMN LAYOUT ── --}}
    <div class="tracker-layout">

    @if($cakeRequest->status === 'BIDDING' && $cakeRequest->bids->count() > 0)
        {{-- ── LEFT: Bid list ── --}}
        <div>
            <div class="bids-list-wrap" style="margin-bottom:1.5rem;">
                <div class="bids-list-header">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Baker Offers</h3>
                    <span class="bid-count-pill">{{ $cakeRequest->bids->count() }} bid{{ $cakeRequest->bids->count() !== 1 ? 's' : '' }}</span>
                </div>
                @foreach($cakeRequest->bids->sortBy('amount') as $bid)
                <div class="bid-card">
                    <div class="bid-top">
                        <div class="bid-avatar">
                        @if($bid->baker->profile_photo)
        <img src="{{ str_starts_with($bid->baker->profile_photo, 'http') ? $bid->baker->profile_photo : asset('storage/'.$bid->baker->profile_photo) }}" alt="">
    @else
        {{ strtoupper(substr($bid->baker->first_name, 0, 1)) }}
    @endif
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div class="bid-name">
                                {{ $bid->baker->first_name }} {{ $bid->baker->last_name }}
                                @if($cakeRequest->is_rush && $bid->baker->baker?->accepts_rush_orders)
                                    <span style="font-size:0.62rem; background:#FEF3E8; color:#C8562A; border:1px solid #F0C0A0; border-radius:4px; padding:1px 5px; font-weight:700; vertical-align:middle; margin-left:4px; display:inline-flex; align-items:center; gap:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush</span>
                                @endif
                            </div>
                            <div class="bid-meta">
                            @if($bid->baker->baker?->rating)
        @php
            $r = $bid->baker->baker->rating;
            $full = floor($r);
            $half = ($r - $full) >= 0.5 ? 1 : 0;
            $empty = 5 - $full - $half;
        @endphp
    <span class="bid-stars">
        {{ str_repeat('★', $full) }}
        @if($half)<span style="position:relative;display:inline-block;font-size:inherit;"><span style="position:absolute;overflow:hidden;width:50%;color:#F5A623;">★</span><span style="color:#ccc;">☆</span></span>@endif
        <span style="color:#ccc;">{{ str_repeat('☆', $empty) }}</span>
    </span>
        {{ number_format($r, 1) }} ·
    @endif
                                {{ $bid->baker->baker?->total_reviews ?? 0 }} reviews · {{ $bid->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="bid-price">
                            <div class="bid-price-num">₱{{ number_format($bid->amount, 0) }}</div>
                            <div class="bid-price-days">{{ $bid->estimated_days }}d estimate</div>
                        </div>
                    </div>
                    @if($bid->message)
                    <div class="bid-msg">"{{ $bid->message }}"</div>
                    @endif
                    <div class="bid-bottom">
                        @if($bid->baker->baker?->specialties)
                        <div class="bid-tags">
                            @foreach(array_slice(is_array($bid->baker->baker->specialties) ? $bid->baker->baker->specialties : explode(',', $bid->baker->baker->specialties), 0, 4) as $spec)
                            <span class="bid-tag">{{ trim($spec) }}</span>
                            @endforeach
                        </div>
                        @else
                        <div></div>
                        @endif
                       <form id="accept-bid-form-{{ $bid->id }}" method="POST"
    action="{{ route('customer.cake-requests.accept-bid', [$cakeRequest->id, $bid->id]) }}"
    class="accept-bid-form">
    @csrf
</form>
                    {{-- Find this in each bid card --}}
 <button type="button" class="btn-accept"
                            onclick="openAcceptModal(this)"
                         data-form-id="accept-bid-form-{{ $bid->id }}"
                            data-name="{{ $bid->baker->first_name }} {{ $bid->baker->last_name }}"
                            data-amount="₱{{ number_format($bid->amount, 0) }}"
                            data-days="{{ $bid->estimated_days }}"
                            data-baker-id="{{ $bid->baker_id }}"
                            data-customer-lat="{{ $cakeRequest->delivery_lat }}"
                            data-customer-lng="{{ $cakeRequest->delivery_lng }}"
                            data-customer-address="{{ $cakeRequest->delivery_address }}"
                            data-rush-fee="{{ $bid->rush_fee ?? 0 }}"
                            data-is-rush="{{ $cakeRequest->is_rush ? '1' : '0' }}">
                      ✓ Accept (₱{{ number_format($bid->amount, 0) }}{{ $cakeRequest->is_rush && ($bid->rush_fee ?? 0) > 0 ? ' + ₱' . number_format($bid->rush_fee, 0) . ' rush' : '' }})
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
    {{-- ── 3D CAKE PREVIEW ── --}}
    @if($cakeRequest->cake_preview_image)
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header">
            <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>Your Cake Design Preview</h3>
        </div>
        <img src="{{ asset('storage/' . $cakeRequest->cake_preview_image) }}"
            alt="3D Cake Preview"
            style="width:100%; max-height:320px; object-fit:cover; display:block;">
        <div style="padding:0.75rem 1.5rem; font-size:0.75rem; color:var(--text-muted); text-align:center;">
            3D preview captured at time of request
        </div>
    </div>
    @endif
    {{-- Cake Design --}}
    <div class="card">
        <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>Cake Design</h3></div>
        <div class="config-grid">
            @foreach(['shape','size','flavor','frosting'] as $key)
                @if(!empty($config[$key])) <div class="config-item"><div class="c-label">{{ ucfirst($key) }}</div><div class="c-value">{{ $config[$key] }}</div></div> @endif
            @endforeach
            @if(!empty($config['addons'])) <div class="config-item" style="grid-column:1/-1; border-right:none;"><div class="c-label">Add-ons</div><div class="c-value">{{ implode(', ', (array)$config['addons']) }}</div></div> @endif
        </div>
    </div>



    {{-- 1B: Delivery / Pickup Location (BIDDING state) --}}
    @if($cakeRequest->isPickup())
        {{-- Pickup: no baker confirmed yet, nothing to show --}}
    @elseif($cakeRequest->delivery_lat && $cakeRequest->delivery_lng)
    <div class="card">
        <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 10c0 6-8 13-8 13s-8-7-8-13a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>Delivery Location</h3></div>
        @if($cakeRequest->delivery_address)
            <div style="padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); font-size:0.82rem; color:var(--text-mid); line-height:1.5;">{{ $cakeRequest->delivery_address }}</div>
        @endif
        <div id="show-map" style="width:100%; height:220px;"></div>
    </div>
    @endif

    {{-- Notes --}}
    @if($cakeRequest->custom_message || $cakeRequest->special_instructions)
    <div class="card">
        <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>Notes</h3></div>
        @if($cakeRequest->custom_message)
            <div class="notes-box" style="border-bottom:1px solid var(--border);">
                <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--text-muted);font-weight:600;margin-bottom:0.4rem;">Message on Cake</div>
                "{{ $cakeRequest->custom_message }}"
            </div>
        @endif
        @if($cakeRequest->special_instructions)
            <div class="notes-box">
                <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--text-muted);font-weight:600;margin-bottom:0.4rem;">Special Instructions</div>
                {{ $cakeRequest->special_instructions }}
            </div>
        @endif
    </div>
    @endif


        </div>

        {{-- ── RIGHT sidebar (bidding state) ── --}}
        <div>
            <div class="bids-summary-card" style="margin-bottom:1.5rem;">
                <div class="bids-summary-top">
                    <div class="bss-label">Request ID</div>
                    <div class="bss-id">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="bss-date">{{ $cakeRequest->created_at->format('M d, Y') }}</div>
                </div>
                <div class="bss-row"><span class="bss-key">Shape</span><span class="bss-val">{{ $config['shapeLabel'] ?? $config['shape'] ?? '—' }}</span></div>
                <div class="bss-row"><span class="bss-key">Flavour</span><span class="bss-val">{{ $config['flavor'] ?? '—' }}</span></div>
                <div class="bss-row"><span class="bss-key">Frosting</span><span class="bss-val">{{ $config['frosting'] ?? '—' }}</span></div>
                <div class="bss-row"><span class="bss-key">Budget</span><span class="bss-val">₱{{ number_format($cakeRequest->budget_min, 0) }}–₱{{ number_format($cakeRequest->budget_max, 0) }}</span></div>
              <div class="bss-row">
    <span class="bss-key">Delivery</span>
    <span class="bss-val" style="color:var(--caramel); font-weight:700;">
        {{ $cakeRequest->delivery_date->format('M d, Y') }}
        @if($cakeRequest->needed_time)
            <span style="font-size:0.72rem; display:flex; align-items:center; gap:3px; margin-top:1px;"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ \Carbon\Carbon::parse($cakeRequest->needed_time)->format('g:i A') }}</span>
        @endif
    </span>
</div>
               @if(!in_array($cakeRequest->status, ['OPEN','BIDDING','RUSH_MATCHING']))
<div class="bss-row"><span class="bss-key">Method</span><span class="bss-val" style="color:{{ $cakeRequest->isPickup() ? '#8A5010' : 'var(--caramel)' }}; font-weight:700;">{{ $cakeRequest->fulfillment_label }}</span></div>
@else
<div class="bss-row"><span class="bss-key">Method</span><span class="bss-val" style="color:var(--text-muted); font-size:0.72rem;">Chosen when baker is accepted</span></div>
@endif
                @if(!empty($config['addons']))
                <div class="bss-row" style="flex-direction:column; align-items:flex-start; gap:0.3rem;">
                    <span class="bss-key">Add-ons</span>
                    <span style="font-size:0.68rem; color:var(--text-dark); line-height:1.5;">{{ implode(', ', (array)$config['addons']) }}</span>
                </div>
                @endif
            </div>
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Activity Log</h3></div>
                <ul class="timeline-log">
                    <li><div class="log-dot"></div><div><div class="log-event">Request submitted</div><div class="log-time">{{ $cakeRequest->created_at->format('M d, Y · g:i A') }}</div></div></li>
                    @if($cakeRequest->bids->count() > 0)
                    <li><div class="log-dot"></div><div><div class="log-event">{{ $cakeRequest->bids->count() }} bid{{ $cakeRequest->bids->count() > 1 ? 's' : '' }} received</div><div class="log-time">{{ $cakeRequest->bids->first()->created_at->format('M d, Y · g:i A') }}</div></div></li>
                    @endif
                </ul>
            </div>
        <div class="card">
        <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Actions</h3></div>
        <div style="padding:1.25rem 1.5rem;">
            <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:1rem; line-height:1.6;">Review the offers on the left and accept the one that suits you best.</p>
            <form id="form-cancel-request" method="POST" action="{{ route('customer.cake-requests.destroy', $cakeRequest->id) }}">
        @csrf @method('DELETE')
    </form>
            <button type="button" class="btn btn-danger" onclick="openConfirmModal('modal-cancel-request')">✕ Cancel Request</button>
            <a href="{{ route('customer.cake-requests.index') }}" class="btn btn-outline">← All Requests</a>
        </div>
    </div>

    {{-- Reference Image --}}
    @if($cakeRequest->reference_image)
    <div class="card">
        <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Reference Image</h3></div>
        <img src="{{ asset('storage/'.$cakeRequest->reference_image) }}" alt="Reference" style="width:100%; max-height:220px; object-fit:cover; border-radius:0 0 20px 20px;">
    </div>
    @endif

@elseif($cakeRequest->status === 'RUSH_MATCHING')
        <div>
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Rush Matching</h3>
                    @if($cakeRequest->rush_expires_at)
                    <span id="rush-countdown" style="font-size:0.75rem; font-weight:700; color:#3A2A7A; background:#EEF; padding:0.2rem 0.7rem; border-radius:20px; border:1px solid #C0C0FF;">
                        ⏱ <span id="rush-timer">--</span>
                    </span>
                    @endif
                </div>
   @if($cakeRequest->bids->count() > 0)
                <div class="bids-waiting">
                  <span class="bids-waiting-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--caramel)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></span>
                    <div class="bids-waiting-title" style="color:var(--caramel);">{{ $cakeRequest->bids->count() }} baker{{ $cakeRequest->bids->count() !== 1 ? 's' : '' }} responded!</div>
                    <div class="bids-waiting-sub">Review their prices below and accept the best one. Your timer is running!</div>
                </div>
                @else
                <div class="bids-waiting">
                   <span class="bids-waiting-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></span>
                    <div class="bids-waiting-title">Waiting for rush bakers…</div>
                    <div class="bids-waiting-sub">We've notified the nearest available rush bakers.<br>They'll submit their prices — you pick the best one.</div>
                </div>
                @endif
            </div>

@if($cakeRequest->bids->count() > 0)
            <div class="bids-list-wrap" style="margin-bottom:1.5rem;">
                <div class="bids-list-header">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Rush Bids</h3>
                    <span class="bid-count-pill">{{ $cakeRequest->bids->count() }} bid{{ $cakeRequest->bids->count() !== 1 ? 's' : '' }}</span>
                </div>
                @foreach($cakeRequest->bids->sortBy('amount') as $bid)
                <div class="bid-card">
                    <div class="bid-top">
                        <div class="bid-avatar">
                            @if($bid->baker->profile_photo)
                                <img src="{{ str_starts_with($bid->baker->profile_photo, 'http') ? $bid->baker->profile_photo : asset('storage/'.$bid->baker->profile_photo) }}" alt="">
                            @else
                                {{ strtoupper(substr($bid->baker->first_name, 0, 1)) }}
                            @endif
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div class="bid-name">
                                {{ $bid->baker->first_name }} {{ $bid->baker->last_name }}
                                <span style="font-size:0.62rem; background:#FEF3E8; color:#C8562A; border:1px solid #F0C0A0; border-radius:4px; padding:1px 5px; font-weight:700; vertical-align:middle; margin-left:4px; display:inline-flex; align-items:center; gap:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush</span>
                            </div>
                            <div class="bid-meta">{{ $bid->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="bid-price">
                            <div class="bid-price-num">₱{{ number_format($bid->amount, 0) }}</div>
                            <div class="bid-price-days">{{ $bid->estimated_days }}d estimate</div>
                        </div>
                    </div>
                    @if($bid->message)
                    <div class="bid-msg">"{{ $bid->message }}"</div>
                    @endif
                    <div class="bid-bottom">
                        <div></div>
                        <form id="accept-rush-bid-form-{{ $bid->id }}" method="POST"
                            action="{{ route('customer.cake-requests.accept-bid', [$cakeRequest->id, $bid->id]) }}">
                            @csrf
                        </form>
                      <button type="button" class="btn-accept"
                        onclick="openAcceptModal(this)"
                      data-form-id="accept-rush-bid-form-{{ $bid->id }}"
                        data-name="{{ $bid->baker->first_name }} {{ $bid->baker->last_name }}"
                        data-amount="₱{{ number_format($bid->amount, 0) }}"
                        data-days="{{ $bid->estimated_days }}"
                        data-baker-id="{{ $bid->baker_id }}"
                        data-customer-lat="{{ $cakeRequest->delivery_lat }}"
                        data-customer-lng="{{ $cakeRequest->delivery_lng }}"
                        data-customer-address="{{ $cakeRequest->delivery_address }}"
                        data-rush-fee="{{ $bid->rush_fee ?? 0 }}"
                        data-is-rush="{{ $cakeRequest->is_rush ? '1' : '0' }}">
                    ✓ Accept (₱{{ number_format($bid->amount, 0) }}{{ ($bid->rush_fee ?? 0) > 0 ? ' + ₱' . number_format($bid->rush_fee, 0) . ' rush' : '' }})
                    </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Cake design + location cards same as OPEN --}}
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>Cake Design</h3></div>
                <div class="config-grid">
                    @foreach(['shape','size','flavor','frosting'] as $key)
                        @if(!empty($config[$key]))
                        <div class="config-item"><div class="c-label">{{ ucfirst($key) }}</div><div class="c-value">{{ $config[$key] }}</div></div>
                        @endif
                    @endforeach
                    @if(!empty($config['addons']))
                    <div class="config-item" style="grid-column:1/-1; border-right:none;"><div class="c-label">Add-ons</div><div class="c-value">{{ implode(', ', (array)$config['addons']) }}</div></div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="id-card">
                <div class="id-label">Request ID</div>
                <div class="id-num">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="id-date">{{ $cakeRequest->created_at->format('M d, Y') }}</div>
                <hr class="id-divider">
                <div style="font-size:0.75rem; opacity:0.6; margin-bottom:0.3rem;">Status</div>
                <div style="font-weight:700; font-size:0.9rem; color:#C8C8FF;">⚡ Rush Matching</div>
            </div>
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Actions</h3></div>
                <div style="padding:1.25rem 1.5rem;">
                    <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:1rem; line-height:1.6;">You can cancel while we're still searching for a baker.</p>
                    <form id="form-cancel-request" method="POST" action="{{ route('customer.cake-requests.destroy', $cakeRequest->id) }}">@csrf @method('DELETE')</form>
                    <button type="button" class="btn btn-danger" onclick="openConfirmModal('modal-cancel-request')">✕ Cancel Request</button>
                    <a href="{{ route('customer.cake-requests.index') }}" class="btn btn-outline">← All Requests</a>
                </div>
            </div>
        </div>

@elseif($cakeRequest->status === 'OPEN')
        <div>
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Baker Offers</h3></div>
                <div class="bids-waiting">
                   <span class="bids-waiting-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg></span>
                    <div class="bids-waiting-title">Waiting for bakers…</div>
                    <div class="bids-waiting-sub">Bakers will see your request and place bids soon.<br>This page refreshes automatically every minute.</div>
                </div>
            </div>

    <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>Cake Design</h3></div>
                <div class="config-grid">
                    @foreach(['shape','size','flavor','frosting'] as $key)
                        @if(!empty($config[$key]))
                        <div class="config-item"><div class="c-label">{{ ucfirst($key) }}</div><div class="c-value">{{ $config[$key] }}</div></div>
                        @endif
                    @endforeach
                    @if(!empty($config['addons']))
                    <div class="config-item" style="grid-column:1/-1; border-right:none;"><div class="c-label">Add-ons</div><div class="c-value">{{ implode(', ', (array)$config['addons']) }}</div></div>
                    @endif
                </div>
            </div>

            {{-- ── ADD THIS RIGHT HERE (OPEN state) ── --}}
            @if($cakeRequest->cake_preview_image)
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>3D Cake Preview</h3></div>
                <img src="{{ asset('storage/' . $cakeRequest->cake_preview_image) }}"
                    alt="3D Cake Preview"
                    style="width:100%; max-height:320px; object-fit:cover; display:block;">
                <div style="padding:0.75rem 1.5rem; font-size:0.75rem; color:var(--text-muted); text-align:center;">
                    3D preview captured at time of request
                </div>
            </div>
            @endif



            {{-- 1B: Delivery / Pickup Location (OPEN state) --}}
            @if($cakeRequest->isPickup())
                {{-- Pickup: no baker confirmed yet --}}
            @elseif($cakeRequest->delivery_lat && $cakeRequest->delivery_lng)
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 10c0 6-8 13-8 13s-8-7-8-13a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>Delivery Location</h3></div>
                @if($cakeRequest->delivery_address)
                    <div style="padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); font-size:0.82rem; color:var(--text-mid); line-height:1.5;">{{ $cakeRequest->delivery_address }}</div>
                @endif
                <div id="show-map" style="width:100%; height:220px;"></div>
            </div>
            @endif
        </div>

    {{-- RIGHT SIDEBAR (OPEN state) --}}
        <div>
            <div class="id-card">
                <div class="id-label">Request ID</div>
                <div class="id-num">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="id-date">{{ $cakeRequest->created_at->format('M d, Y') }}</div>
                <hr class="id-divider">
                <div style="font-size:0.75rem; opacity:0.6; margin-bottom:0.3rem;">Current Status</div>
                <div style="font-weight:700; font-size:0.9rem; color:var(--caramel-light, #E8C9A8);">{{ $cakeRequest->status_label ?? str_replace('_',' ',$cakeRequest->status) }}</div>
            </div>
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Activity Log</h3></div>
                <ul class="timeline-log">
                    <li><div class="log-dot"></div><div><div class="log-event">Request submitted</div><div class="log-time">{{ $cakeRequest->created_at->format('M d, Y · g:i A') }}</div></div></li>
                    <li style="opacity:0.4;"><div class="log-dot" style="background:var(--border);"></div><div><div class="log-event">Waiting for baker bids…</div><div class="log-time">Pending</div></div></li>
                </ul>
            </div>

            {{-- ── ADD THIS ORDER DETAILS SUMMARY ── --}}
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M16.5 9.4 7.55 4.24"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg>Order Details</h3></div>
               @if(!in_array($cakeRequest->status, ['OPEN','BIDDING','RUSH_MATCHING']))
<div class="info-row">
    <span class="i-key">Method</span>
    <span class="i-val" style="font-weight:700; color:{{ $cakeRequest->isPickup() ? '#8A5010' : 'var(--caramel)' }};">{{ $cakeRequest->fulfillment_label }}</span>
</div>
@else
<div class="info-row">
    <span class="i-key">Method</span>
    <span class="i-val" style="font-weight:600; color:var(--text-muted);">Chosen when baker is accepted</span>
</div>
@endif
                <div class="info-row"><span class="i-key">Budget</span><span class="i-val">₱{{ number_format($cakeRequest->budget_min,0) }} — ₱{{ number_format($cakeRequest->budget_max,0) }}</span></div>
              <div class="info-row">
    <span class="i-key">Date & Time needed</span>
    <span class="i-val" style="font-weight:700; color:var(--caramel);">
        {{ $cakeRequest->delivery_date->format('M d, Y') }}
        @if($cakeRequest->needed_time)
            <span style="font-size:0.75rem; display:block; margin-top:1px;">
                🕐 {{ \Carbon\Carbon::parse($cakeRequest->needed_time)->format('g:i A') }}
            </span>
        @endif
    </span>
</div>
                <div class="info-row"><span class="i-key">Submitted</span><span class="i-val">{{ $cakeRequest->created_at->format('M d, Y') }}</span></div>
            </div>

            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Actions</h3></div>
                <div style="padding:1.25rem 1.5rem;">
                    <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:1rem; line-height:1.6;">You can cancel this request while no baker has accepted it.</p>
                    <form id="form-cancel-request" method="POST" action="{{ route('customer.cake-requests.destroy', $cakeRequest->id) }}">@csrf @method('DELETE')</form>
                    <button type="button" class="btn btn-danger" onclick="openConfirmModal('modal-cancel-request')">✕ Cancel Request</button>
                    <a href="{{ route('customer.cake-requests.index') }}" class="btn btn-outline">← All Requests</a>
                </div>
            </div>
            {{-- Reference Image --}}
            @if($cakeRequest->reference_image)
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Reference Image</h3></div>
                <img src="{{ asset('storage/'.$cakeRequest->reference_image) }}" alt="Reference" style="width:100%; max-height:220px; object-fit:cover; border-radius:0 0 20px 20px;">
            </div>
            @endif
        </div>
    @else
        {{-- ALL OTHER STATES --}}
        <div>
            {{-- Baker card --}}
    @if($bakerOrder && in_array($cakeRequest->status, ['ACCEPTED','WAITING_FOR_PAYMENT','WAITING_FINAL_PAYMENT','IN_PROGRESS','COMPLETED']))
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header">
            <h3>@if($cakeRequest->status === 'COMPLETED') <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ $cakeRequest->isPickup() ? 'Collected from' : 'Delivered by' }} @else <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Your Baker @endif</h3>
            <span style="font-size:0.72rem; color:var(--caramel,#C07840); font-weight:700; background:#FBF4EC; padding:0.2rem 0.7rem; border-radius:20px; border:1px solid #D4B896;">✓ Confirmed</span>
        </div>

        {{-- Single flat baker row --}}
        <div style="padding:1rem 1.5rem; display:flex; align-items:center; gap:1rem; border-bottom:1px solid var(--border);">
            <div class="bid-baker-avatar" style="width:44px; height:44px; font-size:1.1rem; flex-shrink:0;">
            @if($bakerOrder->baker->profile_photo)
        <img src="{{ str_starts_with($bakerOrder->baker->profile_photo, 'http') ? $bakerOrder->baker->profile_photo : asset('storage/'.$bakerOrder->baker->profile_photo) }}" alt="">
    @else
        {{ strtoupper(substr($bakerOrder->baker->first_name, 0, 1)) }}
    @endif
            </div>
            <div style="flex:1; min-width:0;">
                <div style="font-weight:700; font-size:0.9rem; color:var(--brown-deep);">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</div>
                <div style="font-size:0.72rem; color:var(--text-muted); margin-top:2px; display:flex; align-items:center; gap:0.4rem;">
                    @if($bakerOrder->baker->baker?->rating)
                        <span style="color:#F5A623;">{{ str_repeat('★', round($bakerOrder->baker->baker->rating)) }}</span>
                        {{ number_format($bakerOrder->baker->baker->rating, 1) }} ·
                    @endif
                    {{ $bakerOrder->baker->baker?->total_reviews ?? 0 }} reviews
                </div>
                @if($bakerOrder->baker->baker?->specialties)
                <div style="display:flex; flex-wrap:wrap; gap:0.25rem; margin-top:0.5rem;">
                    @foreach(array_slice(is_array($bakerOrder->baker->baker->specialties) ? $bakerOrder->baker->baker->specialties : explode(',', $bakerOrder->baker->baker->specialties), 0, 5) as $spec)
                    <span style="padding:0.1rem 0.45rem; background:var(--cream,#FDF6F0); border:1px solid var(--border); border-radius:4px; font-size:0.6rem; color:var(--text-muted); font-weight:600;">{{ trim($spec) }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            
        </div>

    @if($bakerOrder->cake_final_photo)
    <div style="border-top:1px solid var(--border);">
        <div style="padding:0.75rem 1.5rem; background:var(--cream); border-bottom:1px solid var(--border); display:flex; align-items:center; gap:0.5rem;">
            <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); display:inline-flex; align-items:center; gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>Finished Cake Photo</span>
            <span style="font-size:0.62rem; background:#EBF5EE; color:#166534; padding:0.1rem 0.45rem; border-radius:4px; font-weight:700;">FROM YOUR BAKER</span>
        </div>
    <div style="width:100%; background:#2C1A0E; display:flex; align-items:center; justify-content:center; max-height:380px; overflow:hidden;">
        <img src="{{ asset('storage/'.$bakerOrder->cake_final_photo) }}"
            alt="Finished Cake"
            style="width:100%; height:100%; max-height:380px; object-fit:contain; display:block;">
    </div>

    </div>
    @endif


        @if($cakeRequest->status === 'COMPLETED')
        <div style="padding:1.1rem 1.5rem; text-align:center; background:#FBF4EC; border-top:1px solid #D4B896;">
            <div style="margin-bottom:0.3rem; display:flex; justify-content:center; gap:0.3rem;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></div>
            <div style="font-weight:700; color:var(--brown-deep,#5C3D2E); font-size:0.88rem;">{{ $cakeRequest->isPickup() ? 'Cake collected successfully!' : 'Cake delivered successfully!' }}</div>
            <div style="font-size:0.75rem; color:var(--caramel,#C07840); margin-top:0.2rem;">Thank you for using BakeSphere.</div>
        </div>
        @endif
    </div>
    @endif

    {{-- PAYMENT SECTION --}}
    {{-- CTA / Rejection area (COMPLETED state payment moved to sidebar) --}}
    @if($acceptedBid && in_array($cakeRequest->status, ['COMPLETED']) && $downIsRejected)
    <div style="border-top:1px solid #f0e8d0;">
        {{-- Single unified rejection container --}}
        <div style="margin:1rem 1.5rem; border-radius:12px; overflow:hidden; border:1px solid #F5C5BE;">
            {{-- Header row --}}
            <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem 1rem; background:#FDF0EE;">
                <div style="display:flex; align-items:center; gap:0.6rem;">
                    <span style="font-size:0.8rem; color:#8B2A1E; font-weight:700;">✕ Downpayment proof rejected</span>
                </div>
                <span style="background:rgba(139,42,30,.12); color:#8B2A1E; font-size:0.62rem; font-weight:700; padding:2px 8px; border-radius:99px; white-space:nowrap;">{{ $downpayment->rejection_count }}/2</span>
            </div>
            {{-- Reason row --}}
            @if($downpayment->rejection_reason)
            <div style="display:flex; align-items:baseline; gap:0.5rem; padding:0.6rem 1rem; background:white; border-top:1px solid #F5C5BE;">
                <span style="font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#8B2A1E; flex-shrink:0;">Reason:</span>
                <span style="font-size:0.78rem; font-weight:600; color:#3B1F0F;">{{ $rejectionReasons[$downpayment->rejection_reason] ?? $downpayment->rejection_reason }}</span>
                @if($downpayment->rejection_note)
                <span style="font-size:0.72rem; color:var(--text-muted); font-style:italic; margin-left:auto;">"{{ $downpayment->rejection_note }}"</span>
                @endif
            </div>
            @endif
        </div>

        @if($downpayment->rejection_count >= 2)
        <div style="margin:0 1.5rem 1rem; text-align:center; padding:0.85rem 1rem; background:#FDF0EE; border:1px solid #F5C5BE; border-radius:10px;">
            <div style="margin-bottom:0.25rem;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B2A1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
            <div style="font-size:0.82rem; font-weight:700; color:#8B2A1E; margin-bottom:0.2rem;">Order automatically cancelled</div>
            <div style="font-size:0.72rem; color:#7A2A20; line-height:1.4;">Contact support if you believe this is an error.</div>
        </div>
        @else
        {{-- Warning line --}}
        <div style="margin:0 1.5rem 0.75rem; font-size:0.73rem; color:#8A5010; line-height:1.5;">
            ⚠ <strong>One more rejection cancels your order.</strong> Submit a valid, unedited receipt to the correct account.
        </div>

        {{-- Re-upload form --}}
        <form id="reupload-downpayment-form" method="POST" action="{{ route('customer.payment.reupload', $cakeRequest->id) }}" enctype="multipart/form-data" style="margin:0 1.5rem 1.25rem;">
            @csrf
            <input type="hidden" name="payment_type" value="downpayment">

            {{-- Dropzone --}}
            <div id="downDropzone" style="border:1.5px dashed #D4C4B0; border-radius:10px; padding:0.75rem 1rem; cursor:pointer; display:flex; align-items:center; gap:0.75rem; position:relative; transition:all .15s; background:white; margin-bottom:0.6rem;">
                <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" id="downProofInput"
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%;"
                    onchange="handleReuploadFile(this,'downDropzone','downPreview','downFilename','downSubmitBtn')">
                {{-- Default state --}}
                <div id="downDefaultState" style="display:flex; align-items:center; gap:0.75rem; width:100%;">
                    <div style="width:34px; height:34px; background:#F8F5F0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0;">📎</div>
                    <div>
                        <div style="font-size:0.8rem; font-weight:600; color:#3B1F0F;">Click to upload new proof</div>
                        <div style="font-size:0.68rem; color:var(--text-muted); margin-top:1px;">JPG, PNG, or PDF · max 5 MB</div>
                    </div>
                </div>
                {{-- Selected state (hidden until file chosen) --}}
                <div id="downSelectedState" style="display:none; align-items:center; gap:0.75rem; width:100%;">
                    <div style="width:40px; height:40px; border-radius:8px; overflow:hidden; flex-shrink:0; border:1px solid var(--border); background:#F8F5F0; display:flex; align-items:center; justify-content:center;">
                        <img id="downPreview" src="" alt="" style="width:100%; height:100%; object-fit:cover; display:none;">
                        <span id="downFileIcon" style="font-size:1.1rem;">📄</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div id="downFilename" style="font-size:0.8rem; font-weight:600; color:#3B1F0F; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"></div>
                        <div style="font-size:0.68rem; color:#22c55e; margin-top:1px; font-weight:600;">✓ Ready to submit</div>
                    </div>
                    <span style="font-size:0.68rem; color:var(--text-muted); background:#F0EBE3; padding:2px 8px; border-radius:20px; flex-shrink:0;">Change</span>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" id="downSubmitBtn" disabled
                        onclick="this.disabled=true; this.querySelector('.btn-label').textContent='Submitting…'; document.getElementById('reupload-downpayment-form').submit();"
                        style="background:#8B2A1E; color:white; border:none; border-radius:8px; padding:0.55rem 1.1rem; font-size:0.8rem; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans', sans-serif; display:inline-flex; align-items:center; gap:5px; opacity:0.4; transition:opacity .2s;">
                    <span>📤</span> <span class="btn-label">Re-submit proof</span>
                </button>
            </div>
        </form>
        @endif
    </div>

    @elseif($finalIsRejected)
    <div style="border-top:1px solid #f0e8d0;">
        <div style="margin:1rem 1.5rem; border-radius:12px; overflow:hidden; border:1px solid #F5C5BE;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem 1rem; background:#FDF0EE;">
                <span style="font-size:0.8rem; color:#8B2A1E; font-weight:700;">✕ Final payment proof rejected</span>
                <span style="background:rgba(139,42,30,.12); color:#8B2A1E; font-size:0.62rem; font-weight:700; padding:2px 8px; border-radius:99px; white-space:nowrap;">{{ $finalPayment->rejection_count }}/2</span>
            </div>
            @if($finalPayment->rejection_reason)
            <div style="display:flex; align-items:baseline; gap:0.5rem; padding:0.6rem 1rem; background:white; border-top:1px solid #F5C5BE;">
                <span style="font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#8B2A1E; flex-shrink:0;">Reason:</span>
                <span style="font-size:0.78rem; font-weight:600; color:#3B1F0F;">{{ $rejectionReasons[$finalPayment->rejection_reason] ?? $finalPayment->rejection_reason }}</span>
                @if($finalPayment->rejection_note)
                <span style="font-size:0.72rem; color:var(--text-muted); font-style:italic; margin-left:auto;">"{{ $finalPayment->rejection_note }}"</span>
                @endif
            </div>
            @endif
        </div>

        @if($finalPayment->rejection_count >= 2)
        <div style="margin:0 1.5rem 1rem; text-align:center; padding:0.85rem 1rem; background:#FDF0EE; border:1px solid #F5C5BE; border-radius:10px;">
            <div style="margin-bottom:0.25rem;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B2A1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
            <div style="font-size:0.82rem; font-weight:700; color:#8B2A1E; margin-bottom:0.2rem;">Order automatically cancelled</div>
            <div style="font-size:0.72rem; color:#7A2A20; line-height:1.4;">Contact support if you believe this is an error.</div>
        </div>
        @else
        <div style="margin:0 1.5rem 0.75rem; font-size:0.73rem; color:#8A5010; line-height:1.5;">
            ⚠ <strong>One more rejection cancels your order.</strong> Submit a valid, unedited receipt to the correct account.
        </div>

        <form id="reupload-final-form" method="POST" action="{{ route('customer.payment.reupload', $cakeRequest->id) }}" enctype="multipart/form-data" style="margin:0 1.5rem 1.25rem;">
            @csrf
            <input type="hidden" name="payment_type" value="final">
            <div id="finalDropzone" style="border:1.5px dashed #D4C4B0; border-radius:10px; padding:0.75rem 1rem; cursor:pointer; display:flex; align-items:center; gap:0.75rem; position:relative; transition:all .15s; background:white; margin-bottom:0.6rem;">
                <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" id="finalProofInput"
                    style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%;"
                    onchange="handleReuploadFile(this,'finalDropzone','finalPreview','finalFilename','finalSubmitBtn')">
                <div id="finalDefaultState" style="display:flex; align-items:center; gap:0.75rem; width:100%;">
                    <div style="width:34px; height:34px; background:#F8F5F0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0;">📎</div>
                    <div>
                        <div style="font-size:0.8rem; font-weight:600; color:#3B1F0F;">Click to upload new proof</div>
                        <div style="font-size:0.68rem; color:var(--text-muted); margin-top:1px;">JPG, PNG, or PDF · max 5 MB</div>
                    </div>
                </div>
                <div id="finalSelectedState" style="display:none; align-items:center; gap:0.75rem; width:100%;">
                    <div style="width:40px; height:40px; border-radius:8px; overflow:hidden; flex-shrink:0; border:1px solid var(--border); background:#F8F5F0; display:flex; align-items:center; justify-content:center;">
                        <img id="finalPreview" src="" alt="" style="width:100%; height:100%; object-fit:cover; display:none;">
                        <span id="finalFileIcon" style="font-size:1.1rem;">📄</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div id="finalFilename" style="font-size:0.8rem; font-weight:600; color:#3B1F0F; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"></div>
                        <div style="font-size:0.68rem; color:#22c55e; margin-top:1px; font-weight:600;">✓ Ready to submit</div>
                    </div>
                    <span style="font-size:0.68rem; color:var(--text-muted); background:#F0EBE3; padding:2px 8px; border-radius:20px; flex-shrink:0;">Change</span>
                </div>
            </div>
            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" id="finalSubmitBtn" disabled
                        onclick="this.disabled=true; this.querySelector('.btn-label').textContent='Submitting…'; document.getElementById('reupload-final-form').submit();"
                        style="background:#8B2A1E; color:white; border:none; border-radius:8px; padding:0.55rem 1.1rem; font-size:0.8rem; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans', sans-serif; display:inline-flex; align-items:center; gap:5px; opacity:0.4; transition:opacity .2s;">
                    <span>📤</span> <span class="btn-label">Re-submit proof</span>
                </button>
            </div>
        </form>
        @endif
    </div>
                </div>
    @elseif($downpayment && $downpayment->isPaid() && (!$finalPayment || !$finalPayment->isPaid()))
        @if($effectiveStatus === 'WAITING_FINAL_PAYMENT')
            @if($finalIsPending)
            <div class="psc-cta" style="background:#FEF9E8; border-top-color:#F0D090;">
                <div style="font-size:0.85rem; font-weight:600; color:#8A5010;">⏳ Final payment proof submitted — waiting for baker confirmation</div>
                <p class="psc-cta-note">You'll be notified once your baker confirms receipt.</p>
            </div>
            @elseif($cakeRequest->isPickup())
            <div class="psc-cta" style="background:#FEF9E8; border-top-color:#F0D090;">
                <div style="font-size:0.85rem; font-weight:600; color:#8A5010;"> Pick up the cake and pay <strong>₱{{ number_format($downpaymentAmount, 2) }}</strong> cash to collect your cake.</div>
                <p class="psc-cta-note">The baker will confirm receipt and complete your order.</p>
            </div>
        @else
            {{-- Payment is handled via the sidebar payment card --}}
            @endif
        @else
        <div class="psc-paid-notice">
            @if($cakeRequest->isPickup())
                 Downpayment confirmed · Remaining ₱{{ number_format($downpaymentAmount, 2) }} due as cash on pickup
            @else
                 Downpayment confirmed · Remaining ₱{{ number_format($downpaymentAmount, 2) }} due on delivery
            @endif
        </div>
        @endif
    @endif
    {{-- ── 3D CAKE PREVIEW ── --}}
    @if($cakeRequest->cake_preview_image)
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header">
            <h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>Your Cake Design Preview</h3>
        </div>
        <img src="{{ asset('storage/' . $cakeRequest->cake_preview_image) }}"
            alt="3D Cake Preview"
            style="width:100%; max-height:320px; object-fit:cover; display:block;">
        <div style="padding:0.75rem 1.5rem; font-size:0.75rem; color:var(--text-muted); text-align:center;">
            3D preview captured at time of request
        </div>
    </div>
    @endif
        {{-- Cake Design + Order Details (combined) --}}
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>Cake &amp; Order Details</h3></div>
                <div class="config-grid">
                    @foreach(['shape','size','flavor','frosting'] as $key)
                        @if(!empty($config[$key])) <div class="config-item"><div class="c-label">{{ ucfirst($key) }}</div><div class="c-value">{{ $config[$key] }}</div></div> @endif
                    @endforeach
                    @if(!empty($config['addons'])) <div class="config-item" style="grid-column:1/-1; border-right:none;"><div class="c-label">Add-ons</div><div class="c-value">{{ implode(', ', (array)$config['addons']) }}</div></div> @endif
                </div>
                <div style="border-top:1px solid var(--border);">
                    <div class="info-row">
                        <span class="i-key">Method</span>
                        <span class="i-val" style="font-weight:700; color:{{ $cakeRequest->isPickup() ? '#8A5010' : 'var(--caramel)' }};">{{ $cakeRequest->fulfillment_label }}</span>
                    </div>
                    <div class="info-row"><span class="i-key">Budget</span><span class="i-val">₱{{ number_format($cakeRequest->budget_min,0) }} — ₱{{ number_format($cakeRequest->budget_max,0) }}</span></div>
                   <div class="info-row">
                        <span class="i-key">Date</span>
                        <span class="i-val" style="font-weight:700; color:var(--caramel);">
                            {{ $cakeRequest->delivery_date->format('M d, Y') }}
                            @if($cakeRequest->needed_time)
                                <span style="font-size:0.75rem; display:block; margin-top:1px;">🕐 {{ \Carbon\Carbon::parse($cakeRequest->needed_time)->format('g:i A') }}</span>
                            @endif
                        </span>
                    </div>
                    @if(!empty($config['total']))<div class="info-row"><span class="i-key">Est. Price</span><span class="i-val" style="color:var(--caramel); font-weight:700;">₱{{ number_format($config['total'],0) }}</span></div>@endif
                    <div class="info-row"><span class="i-key">Submitted</span><span class="i-val">{{ $cakeRequest->created_at->format('M d, Y') }}</span></div>
                    @if($cakeRequest->custom_message)
                    <div class="info-row" style="flex-direction:column; align-items:flex-start; gap:0.25rem;">
                        <span class="i-key">Message on Cake</span>
                        <span style="font-size:0.82rem; color:var(--text-dark); font-style:italic;">"{{ $cakeRequest->custom_message }}"</span>
                    </div>
                    @endif
                    @if($cakeRequest->special_instructions)
                    <div class="info-row" style="flex-direction:column; align-items:flex-start; gap:0.25rem; border-bottom:none;">
                        <span class="i-key">Special Instructions</span>
                        <span style="font-size:0.82rem; color:var(--text-dark); line-height:1.5;">{{ $cakeRequest->special_instructions }}</span>
                    </div>
                    @endif
                </div>
            </div>

            

            {{-- 1B: Delivery / Pickup Location (all other states) --}}
            @if($cakeRequest->isPickup())
                @if($bakerOrder && in_array($cakeRequest->status, ['ACCEPTED','WAITING_FOR_PAYMENT','IN_PROGRESS','WAITING_FINAL_PAYMENT','COMPLETED']))
                <div class="card">
                    <div class="card-header"><h3> Pickup Location</h3></div>
                    @php
                        $bakerProfile = \App\Models\Baker::where('user_id', $bakerOrder->baker_id)->first();
                    @endphp
                    @if($bakerProfile && $bakerProfile->address)
                    <div style="padding:1rem 1.5rem;">
                        <div style="font-size:0.68rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:600; margin-bottom:0.4rem;">Baker's Address</div>
                        <div style="font-size:0.9rem; font-weight:600; color:var(--brown-deep); line-height:1.5;">{{ $bakerProfile->address }}</div>
                        @if($effectiveStatus === 'WAITING_FINAL_PAYMENT')
                        <div style="margin-top:0.85rem; background:#FEF9E8; border:1.5px solid #F0D090; border-radius:10px; padding:0.75rem 1rem; font-size:0.78rem; color:#8A5010; display:flex; align-items:flex-start; gap:0.5rem;">
                            <span>💵</span>
                            <div><strong>Cash on pickup:</strong> Bring ₱{{ number_format(round($bakerOrder->agreed_price * 0.5, 2), 2) }} in cash when you collect your cake.</div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div style="padding:1rem 1.5rem; font-size:0.82rem; color:var(--text-muted);">
                        📍 Baker's pickup address will appear here. You can also ask via the chat below.
                    </div>
                    @endif
                </div>
                @endif
            @elseif($cakeRequest->delivery_lat && $cakeRequest->delivery_lng)
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><path d="M20 10c0 6-8 13-8 13s-8-7-8-13a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>Delivery Location</h3></div>
                @if($cakeRequest->delivery_address)
                <div style="padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); font-size:0.82rem; color:var(--text-mid); line-height:1.5;">{{ $cakeRequest->delivery_address }}</div>
                @endif
                <div id="show-map" style="width:100%; height:220px;"></div>
            </div>
            @endif



        @if($bakerOrder && in_array($cakeRequest->status, ['ACCEPTED','WAITING_FOR_PAYMENT','WAITING_FINAL_PAYMENT','IN_PROGRESS','COMPLETED']))
                @include('partials.order-chat-bubble', ['order' => $bakerOrder])
            @endif
        </div>

        {{-- RIGHT SIDEBAR (other states) --}}
        <div>
            <div class="id-card">
                <div class="id-label">Request ID</div>
                <div class="id-num">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="id-date">{{ $cakeRequest->created_at->format('M d, Y') }}</div>
                <hr class="id-divider">
                <div style="font-size:0.75rem; opacity:0.6; margin-bottom:0.3rem;">Current Status</div>
                <div style="font-weight:700; font-size:0.9rem; color:var(--caramel-light, #E8C9A8);">{{ $cakeRequest->status_label ?? str_replace('_',' ',$cakeRequest->status) }}</div>
                @if($bakerOrder)
                <hr class="id-divider">
                <div style="font-size:0.75rem; opacity:0.6; margin-bottom:0.3rem;">Agreed Price</div>
                <div style="font-weight:700; font-size:1.1rem; color:white;">₱{{ number_format($bakerOrder->agreed_price, 0) }}</div>
                @endif
        
            </div>
    @if($effectiveStatus === 'IN_PROGRESS' && $downpayment && $downpayment->isPaid())
            {{-- Payment summary for IN_PROGRESS --}}
            <div class="payment-section-card" style="margin-bottom:1.5rem;">
                <div class="psc-header">
                    <div class="psc-header-left">
                        <div class="psc-icon">₱</div>
                        <div>
                            <div class="psc-title">Payment</div>
                           @if($cakeRequest->is_rush)
@php
    $acceptedBidModel = $cakeRequest->bids->whereIn('status', ['ACCEPTED','accepted'])->first();
    $rushFeeDisplay = ($acceptedBidModel?->rush_fee ?? 0);
    $cakeBasePrice  = $acceptedBid->amount;
@endphp
                            <div style="display:flex; gap:0.5rem; margin-top:0.35rem; flex-wrap:wrap;">
                                <span style="font-size:0.62rem; background:#FEF3E8; color:#C8562A; border:1px solid #F0C0A0; border-radius:4px; padding:1px 6px; font-weight:700; display:inline-flex; align-items:center; gap:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Order</span>
                                <span style="font-size:0.62rem; color:var(--text-muted);">Cake ₱{{ number_format($cakeBasePrice, 2) }} + Rush ₱{{ number_format($rushFeeDisplay, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="psc-split">
                    <div class="psc-half half-paid">
                        <div class="half-left">
                            <div class="half-label">① Downpayment · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            <div class="half-status paid">✓ Confirmed & paid</div>
                        </div>
                        <div style="width:32px;height:32px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">✓</div>
                    </div>
                    <div class="psc-divider">
                        <div class="psc-divider-line"></div>
                        <div class="psc-total">Total ₱{{ number_format($bakerOrder ? $bakerOrder->agreed_price : $acceptedBid->amount, 2) }}</div>
                        <div class="psc-divider-line"></div>
                    </div>
            <div class="psc-half half-locked">
                        <div class="half-left">
                            <div class="half-label">② Final Payment · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            @if($bakerOrder && $bakerOrder->cake_final_photo)
                                <div class="half-status pending">📸 Cake ready — payment incoming</div>
                            @else
                                <div class="half-status locked">🔒 Unlocks when cake is ready</div>
                            @endif
                        </div>
                        <div style="width:32px;height:32px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;">
                            @if($bakerOrder && $bakerOrder->cake_final_photo) 📸 @else 🔒 @endif
                        </div>
                    </div>
                </div>
            @if($bakerOrder && $bakerOrder->cake_final_photo)
                <div class="psc-cta">
                    @php $customerWalletInProgress = \App\Models\Wallet::forUser(auth()->id()); @endphp
                    @if($customerWalletInProgress->hasEnough(round($bakerOrder->agreed_price * 0.5, 2)))
                    <button type="button" onclick="openConfirmModal('modal-pay-final')" class="psc-pay-btn" style="background:linear-gradient(135deg,#7B4A1E,#C07840); border:none; cursor:pointer; width:100%;">
                         Confirm Cake & Pay ₱{{ number_format(round($bakerOrder->agreed_price * 0.5, 2), 2) }}
                    </button>
                    <p class="psc-cta-note"> Wallet: ₱{{ number_format($customerWalletInProgress->balance, 2) }}</p>
                    @else
                    <a href="{{ route('customer.wallet.index') }}" class="psc-pay-btn" style="background:linear-gradient(135deg,#8B2A1E,#C44030);">
                        ⚠ Top Up — Need ₱{{ number_format(round($bakerOrder->agreed_price * 0.5, 2) - $customerWalletInProgress->balance, 2) }} more
                    </a>
                    @endif
                </div>
                @else
                <div class="psc-paid-notice"> Downpayment confirmed · Final payment unlocks when cake photo is ready</div>
                @endif
            </div>
            @endif
    @if($effectiveStatus === 'WAITING_FINAL_PAYMENT' && $acceptedBid)
            {{-- Payment card in sidebar for WAITING_FINAL_PAYMENT --}}
            <div class="payment-section-card" id="payment-section" style="margin-bottom:1.5rem;">
                <div class="psc-header">
                    <div class="psc-header-left">
                        <div class="psc-icon">₱</div>
                        <div>
                            <div class="psc-title">Payment</div>
                          @if($cakeRequest->is_rush)
@php
    $acceptedBidModel = $cakeRequest->bids->whereIn('status', ['ACCEPTED','accepted'])->first();
    $rushFeeDisplay = ($acceptedBidModel?->rush_fee ?? 0);
    $cakeBasePrice  = $acceptedBid->amount;
@endphp
                            <div style="display:flex; gap:0.5rem; margin-top:0.35rem; flex-wrap:wrap;">
                                <span style="font-size:0.62rem; background:#FEF3E8; color:#C8562A; border:1px solid #F0C0A0; border-radius:4px; padding:1px 6px; font-weight:700; display:inline-flex; align-items:center; gap:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Order</span>
                                <span style="font-size:0.62rem; color:var(--text-muted);">Cake ₱{{ number_format($cakeBasePrice, 2) }} + Rush ₱{{ number_format($rushFeeDisplay, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="psc-split">
                    <div class="psc-half half-paid">
                        <div class="half-left">
                            <div class="half-label">① Downpayment · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            <div class="half-status paid">✓ Confirmed & paid</div>
                        </div>
                        <div style="width:32px;height:32px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">✓</div>
                    </div>
                    <div class="psc-divider">
                        <div class="psc-divider-line"></div>
                        <div class="psc-total">Total ₱{{ number_format($bakerOrder ? $bakerOrder->agreed_price : $acceptedBid->amount, 2) }}</div>
                        <div class="psc-divider-line"></div>
                    </div>
                    <div class="psc-half {{ $finalIsRejected ? 'half-rejected' : ($finalIsPending ? 'half-pending' : 'half-pending') }}">
                        <div class="half-left">
                            <div class="half-label">② {{ $cakeRequest->isPickup() ? 'Cash on Pickup' : 'Final Payment' }} · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            @if($finalIsRejected)
                                <div class="half-status rejected">✕ Proof rejected</div>
                            @elseif($finalIsPending)
                                <div class="half-status pending">⏳ Under review</div>
                            @elseif($cakeRequest->isPickup())
                                <div class="half-status pending">💵 Pay cash at pickup</div>
                            @else
                                <div class="half-status pending">⚠ Payment required</div>
                            @endif
                        </div>
                        @if($finalIsRejected)
                            <div style="width:32px;height:32px;background:#FDF0EE;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">✕</div>
                        @elseif($cakeRequest->isPickup())
                            <div style="width:32px;height:32px;background:#FEF9E8;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;"></div>
                        @else
                            <div style="width:32px;height:32px;background:#FEF3D8;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;">₱</div>
                        @endif
                    </div>
                </div>
    @if($finalIsRejected)
                    <div class="psc-paid-notice" style="background:#FDF0EE; border-top-color:#F5C5BE; color:#8B2A1E;">✕ Proof rejected — re-upload above</div>
        @elseif($finalPayment && $finalPayment->escrow_status === 'held')
                    <div class="psc-paid-notice" style="background:#EBF3FE; border-top-color:#BEDAF5; color:#1A3A6B;"> Final payment paid — waiting for baker to confirm delivery</div>
                @elseif($finalIsPending)
                    <div class="psc-paid-notice" style="background:#EBF3FE; border-top-color:#BEDAF5; color:#1A3A6B;">⏳ Proof submitted — under review</div>
                @elseif($finalPayment && $finalPayment->isPaid())
                    <div class="psc-paid-notice" style="background:#EFF5EF; border-top-color:#BFDFBE; color:#1B4D2E;"> Final payment confirmed — confirm receipt below</div>
                @elseif($cakeRequest->isPickup())
                    <div class="psc-paid-notice"> Pay ₱{{ number_format($downpaymentAmount, 2) }} cash when you collect</div>
                @else
                    <div class="psc-cta">
                        @php $customerWallet = \App\Models\Wallet::forUser(auth()->id()); @endphp
                        @if($customerWallet->hasEnough(round($bakerOrder->agreed_price * 0.5, 2)))
                        <button type="button" onclick="openConfirmModal('modal-pay-final')" class="psc-pay-btn" style="background:linear-gradient(135deg,#7B4A1E,#C07840); border:none; cursor:pointer; width:100%;">
                             Confirm Cake & Pay ₱{{ number_format(round($bakerOrder->agreed_price * 0.5, 2), 2) }}
                        </button>
                        <p class="psc-cta-note">Wallet: ₱{{ number_format($customerWallet->balance, 2) }}</p>
                        @else
                        <a href="{{ route('customer.wallet.index') }}" class="psc-pay-btn" style="background:linear-gradient(135deg,#8B2A1E,#C44030);">
                            ⚠ Top Up — Need ₱{{ number_format(round($bakerOrder->agreed_price * 0.5, 2) - $customerWallet->balance, 2) }} more
                        </a>
                        @endif
                    </div>
                @endif
            </div>
            @endif

    {{-- NOTE: After final payment confirmed in modal, the sidebar pay button is replaced by a notice --}}

    @if($effectiveStatus === 'WAITING_FOR_PAYMENT' && !$downIsRejected)
            {{-- Payment card FIRST for WAITING_FOR_PAYMENT --}}
            <div class="payment-section-card" id="payment-section" style="margin-bottom:1.5rem;">
                <div class="psc-header">
                    <div class="psc-header-left">
                        <div class="psc-icon">₱</div>
                        <div>
                            <div class="psc-title">Payment</div>
                        @if($cakeRequest->is_rush)
@php
    $acceptedBidModel = $cakeRequest->bids->whereIn('status', ['ACCEPTED','accepted'])->first();
    $rushFeeDisplay = ($acceptedBidModel?->rush_fee ?? 0);
    $cakeBasePrice  = $acceptedBid->amount;
@endphp
                            <div style="display:flex; gap:0.5rem; margin-top:0.35rem; flex-wrap:wrap;">
                                <span style="font-size:0.62rem; background:#FEF3E8; color:#C8562A; border:1px solid #F0C0A0; border-radius:4px; padding:1px 6px; font-weight:700; display:inline-flex; align-items:center; gap:2px;"><svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Rush Order</span>
                                <span style="font-size:0.62rem; color:var(--text-muted);">Cake ₱{{ number_format($cakeBasePrice, 2) }} + Rush ₱{{ number_format($rushFeeDisplay, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            <div class="psc-split">
                    <div class="psc-half half-pending">
                        <div class="half-left">
                            <div class="half-label">① Downpayment · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            <div class="half-status pending">⚠ Payment required</div>
                        </div>
                        <div style="width:32px;height:32px;background:#FEF3D8;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;">₱</div>
                    </div>
                    <div class="psc-divider">
                        <div class="psc-divider-line"></div>
                        <div class="psc-total">Total ₱{{ number_format($bakerOrder ? $bakerOrder->agreed_price : $acceptedBid->amount, 2) }}</div>
                        <div class="psc-divider-line"></div>
                    </div>
                    <div class="psc-half half-locked">
                        <div class="half-left">
                            <div class="half-label">② Final Payment · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            <div class="half-status locked">🔒 Unlocks on delivery</div>
                        </div>
                        <div style="width:32px;height:32px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;">🔒</div>
                    </div>
                </div>
                <div class="psc-cta">
                <button type="button" onclick="openConfirmModal('modal-pay-downpayment')" class="psc-pay-btn" style="border:none;cursor:pointer;width:100%;display:block;text-align:center;">₱ Pay Downpayment Now</button>
                
                </div>
            </div>
            @endif

    {{-- Payment summary card for COMPLETED state --}}
            @if($acceptedBid && $cakeRequest->status === 'COMPLETED')
            <div class="payment-section-card" style="margin-bottom:1.5rem;">
                <div class="psc-header">
                    <div class="psc-header-left">
                        <div class="psc-icon">₱</div>
                        <div>
                            <div class="psc-title">Payment</div>
                            <div class="psc-sub">
                                ₱{{ number_format($acceptedBid->amount, 2) }} agreed ·
                                @if($cakeRequest->isPickup()) 50% online + 50% cash @else 50 / 50 split @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="psc-split">
                    <div class="psc-half half-paid">
                        <div class="half-left">
                            <div class="half-label">① Downpayment · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            <div class="half-status paid">✓ Confirmed & paid</div>
                        </div>
                        <div style="width:32px;height:32px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">✓</div>
                    </div>
                    <div class="psc-divider">
                        <div class="psc-divider-line"></div>
                        <div class="psc-total">Total ₱{{ number_format($bakerOrder ? $bakerOrder->agreed_price : $acceptedBid->amount, 2) }}</div>
                        <div class="psc-divider-line"></div>
                    </div>
                    <div class="psc-half {{ $finalPayment && $finalPayment->isPaid() ? 'half-paid' : 'half-locked' }}">
                        <div class="half-left">
                            <div class="half-label">② {{ $cakeRequest->isPickup() ? 'Cash on Pickup' : 'Final Payment' }} · 50%</div>
                            <div class="half-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                            @if($finalPayment && $finalPayment->isPaid())
                                <div class="half-status paid">✓ Confirmed & paid</div>
                            @else
                                <div class="half-status locked">—</div>
                            @endif
                        </div>
                        @if($finalPayment && $finalPayment->isPaid())
                            <div style="width:32px;height:32px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">✓</div>
                        @else
                            <div style="width:32px;height:32px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;">—</div>
                        @endif
                    </div>
                </div>
                <div class="psc-paid-notice"> All payments complete!</div>
            </div>
            @endif

            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Actions</h3></div>
                <div style="padding:1.25rem 1.5rem;">
                @if(in_array($cakeRequest->status, ['OPEN', 'ACCEPTED']))
                        <form id="form-cancel-request-sidebar" method="POST" action="{{ route('customer.cake-requests.destroy', $cakeRequest->id) }}">@csrf @method('DELETE')</form>
                        <button type="button" class="btn btn-danger" onclick="openConfirmModal('modal-cancel-request')">✕ Cancel Request</button>
                @elseif($effectiveStatus === 'WAITING_FOR_PAYMENT' && !$downIsRejected)
                        <form id="form-cancel-request-sidebar2" method="POST" action="{{ route('customer.cake-requests.destroy', $cakeRequest->id) }}">@csrf @method('DELETE')</form>
                        <button type="button" class="btn btn-danger" onclick="openConfirmModal('modal-cancel-request')">✕ Cancel this order</button>
                    {{-- 1D: WAITING_FINAL_PAYMENT sidebar actions — pickup-aware --}}
    @elseif($effectiveStatus === 'WAITING_FINAL_PAYMENT' && !$finalIsRejected)
                        @if($cakeRequest->isPickup())
                            <div style="background:#FEF9E8; border:1.5px solid #F0D090; border-radius:10px; padding:0.85rem 1rem; font-size:0.78rem; color:#8A5010; font-weight:600; text-align:center; margin-bottom:0.75rem;">
                                 Pickup the cake and pay <strong>₱{{ number_format(round($bakerOrder?->agreed_price * 0.5, 2), 2) }}</strong> cash to collect your cake.
                            </div>
                        @elseif($finalIsPending)
                            <div style="background:#FEF9E8; border:1.5px solid #F0D090; border-radius:10px; padding:0.85rem 1rem; font-size:0.78rem; color:#8A5010; font-weight:600; text-align:center; margin-bottom:0.75rem;">
                                ⏳ Final payment proof submitted — waiting for baker confirmation.
                            </div>
                        @elseif($finalPayment && $finalPayment->isPaid())
                            <form id="form-confirm-received-sidebar" method="POST" action="{{ route('customer.orders.confirm-received', $bakerOrder->id) }}">
                                @csrf
                            </form>
                            <button type="button" onclick="openConfirmModal('modal-confirm-received')" style="width:100%; padding:0.75rem; background:linear-gradient(135deg,#5C3D2E,#9B6030); color:white; border:none; border-radius:10px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 4px 12px rgba(92,61,46,0.3); transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:0.4rem; margin-bottom:0.5rem;">
                                 Cake Received — Complete Order
                            </button>
                            <p style="font-size:0.72rem; color:var(--text-muted); text-align:center; line-height:1.5; margin-bottom:0.5rem;">Click once you have physically received your cake.</p>
                        @else
                            <p style="font-size:0.82rem; color:var(--text-muted); text-align:center; padding:0.5rem 0; line-height:1.6;">See payment section above to pay the final balance.</p>
                        @endif
                    @elseif($downIsRejected || $finalIsRejected)
                        <div style="background:#FDF0EE; border:1.5px solid #F5C5BE; border-radius:10px; padding:0.85rem 1rem; font-size:0.78rem; color:#8B2A1E; font-weight:600; text-align:center; margin-bottom:0.75rem;">❌ Re-upload your proof above to continue</div>
                    @elseif($cakeRequest->status === 'COMPLETED')
                        <p style="font-size:0.82rem; color:var(--caramel,#C07840); font-weight:600; text-align:center; padding:0.5rem 0;"> Order complete!</p>
                        @if($bakerOrder)
                        @php $alreadyReported = \App\Models\Report::where('reporter_id', auth()->id())->where('baker_order_id', $bakerOrder->id)->exists(); @endphp
                        @if(!$alreadyReported)
                        <a href="{{ route('report.create', $bakerOrder->id) }}" class="btn btn-danger" style="margin-top:0.5rem;">⚠ Report Baker</a>
                        @else
                        <p style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-top:0.5rem;">✓ Report submitted</p>
                        @endif
                        @endif
                    @elseif($cakeRequest->status === 'CANCELLED')
                        <p style="font-size:0.82rem; color:var(--text-muted); text-align:center; padding:0.5rem 0;">This request was cancelled.</p>
                        @if($bakerOrder)
                        @php $alreadyReported = \App\Models\Report::where('reporter_id', auth()->id())->where('baker_order_id', $bakerOrder->id)->exists(); @endphp
                        @if(!$alreadyReported)
                        <a href="{{ route('report.create', $bakerOrder->id) }}" class="btn btn-danger" style="margin-top:0.5rem;">⚠ Report Baker</a>
                        @else
                        <p style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-top:0.5rem;">✓ Report submitted</p>
                        @endif
                        @endif
            @elseif($effectiveStatus === 'IN_PROGRESS')
                        <button type="button" class="btn btn-danger" onclick="openConfirmModal('modal-cancel-in-progress')">✕ Cancel Order</button>
                    @else
                        <p style="font-size:0.82rem; color:var(--text-muted); text-align:center; padding:0.5rem 0; line-height:1.6;">This request is being processed.</p>
                    @endif
                    <a href="{{ route('customer.cake-requests.index') }}" class="btn btn-outline">← All Requests</a>
                    @if(in_array($cakeRequest->status, ['CANCELLED','EXPIRED','COMPLETED']))
                    <a href="{{ route('customer.cake-builder.index') }}" class="btn btn-outline" style="margin-top:0.5rem;">🎂 New Cake Request</a>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Activity Log</h3></div>
                <ul class="timeline-log">
                    <li><div class="log-dot"></div><div><div class="log-event">Request submitted</div><div class="log-time">{{ $cakeRequest->created_at->format('M d, Y · g:i A') }}</div></div></li>
                    @if($cakeRequest->bids->count() > 0)
                    <li><div class="log-dot"></div><div><div class="log-event">{{ $cakeRequest->bids->count() }} baker bid{{ $cakeRequest->bids->count() > 1 ? 's' : '' }} received</div><div class="log-time">{{ $cakeRequest->bids->first()->created_at->format('M d, Y · g:i A') }}</div></div></li>
                    @endif
                    @if($bakerOrder)
                    <li><div class="log-dot"></div><div><div class="log-event">Baker accepted — {{ $bakerOrder->baker->first_name }}</div><div class="log-time">{{ $bakerOrder->created_at->format('M d, Y · g:i A') }}</div></div></li>
                    @endif
                    @if($downIsRejected)
                    <li><div class="log-dot" style="background:#F5C5BE;"></div><div><div class="log-event" style="color:#8B2A1E;">❌ Downpayment proof rejected</div><div class="log-time">{{ $downpayment->rejected_at?->format('M d, Y · g:i A') }}</div></div></li>
                    @elseif($downpayment && $downpayment->isPaid())
                    <li><div class="log-dot" style="background:#c8862a;"></div><div><div class="log-event">₱ Downpayment confirmed</div><div class="log-time">{{ $downpayment->confirmed_at?->format('M d, Y · g:i A') ?? $downpayment->paid_at?->format('M d, Y · g:i A') }}</div></div></li>
                    @elseif($downpayment && $downpayment->status === 'pending')
                    <li><div class="log-dot" style="background:#EDD090;"></div><div><div class="log-event" style="color:#9B6A10;">⏳ Downpayment proof under review</div><div class="log-time">{{ $downpayment->paid_at?->format('M d, Y · g:i A') }}</div></div></li>
                    @elseif($effectiveStatus === 'WAITING_FOR_PAYMENT')
                    <li><div class="log-dot" style="background:#c8862a;"></div><div><div class="log-event" style="color:#c8862a;">₱ Awaiting your downpayment</div><div class="log-time">Action required</div></div></li>
                    @endif
                    @if($finalIsRejected)
                    <li><div class="log-dot" style="background:#F5C5BE;"></div><div><div class="log-event" style="color:#8B2A1E;">❌ Final payment proof rejected</div><div class="log-time">{{ $finalPayment->rejected_at?->format('M d, Y · g:i A') }}</div></div></li>
                    @endif
                @if($bakerOrder && $bakerOrder->cake_final_photo && in_array($effectiveStatus, ['IN_PROGRESS','WAITING_FINAL_PAYMENT']))
                    <li><div class="log-dot" style="background:#5C3D2E;"></div><div><div class="log-event">📸 Cake photo received from baker</div><div class="log-time">Baker marked cake as ready</div></div></li>
                    @endif
                    @if($effectiveStatus === 'WAITING_FINAL_PAYMENT' && !$finalIsRejected && (!$finalPayment || !$finalPayment->isPaid()))
                    <li><div class="log-dot" style="background:#c8862a;"></div><div><div class="log-event" style="color:#c8862a;">{{ $cakeRequest->isPickup() ? ' Cake ready for pickup' : '💰 Final payment requested' }}</div><div class="log-time">Action required</div></div></li>
                    @endif
                    @if($cakeRequest->status === 'COMPLETED')
                    <li><div class="log-dot" style="background:var(--caramel,#C07840);"></div><div><div class="log-event" style="color:var(--caramel,#C07840);">{{ $cakeRequest->isPickup() ? 'Cake collected ' : 'Order delivered ' }}</div><div class="log-time">{{ $bakerOrder?->completed_at?->format('M d, Y · g:i A') }}</div></div></li>
                    @endif
                </ul>
            </div>

        {{-- Reference Image --}}
            @if($cakeRequest->reference_image)
            <div class="card">
                <div class="card-header"><h3><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:5px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Reference Image</h3></div>
                <img src="{{ asset('storage/'.$cakeRequest->reference_image) }}" alt="Reference" style="width:100%; max-height:220px; object-fit:cover; border-radius:0 0 20px 20px;">
            </div>
            @endif

            {{-- Rate Your Baker --}}
            @if($bakerOrder)
                @include('partials.delivery-review', ['bakerOrder' => $bakerOrder, 'cakeRequest' => $cakeRequest])
            @endif

        </div>
    @endif
    </div>

    {{-- ══ BAKER PROFILE DRAWER ══ --}}
    <div id="bakerProfileDrawer" style="position:fixed;inset:0;z-index:10500;display:flex;pointer-events:none;opacity:0;transition:opacity 0.25s;">
        {{-- Backdrop --}}
        <div onclick="closeBakerProfileDrawer()" style="position:absolute;inset:0;background:rgba(20,10,4,0.6);backdrop-filter:blur(4px);"></div>

        {{-- Panel --}}
        <div id="bakerProfilePanel" style="position:absolute;right:0;top:0;bottom:0;width:100%;max-width:480px;background:#FFFDF9;display:flex;flex-direction:column;box-shadow:-8px 0 40px rgba(0,0,0,0.2);transform:translateX(100%);transition:transform 0.3s cubic-bezier(0.34,1.56,0.64,1);overflow:hidden;">

            {{-- Header --}}
            <div id="bpd-header" style="background:linear-gradient(135deg,#3B1F0F,#7A4A28);color:white;padding:1.5rem;flex-shrink:0;position:relative;">
                <button onclick="closeBakerProfileDrawer()" style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,0.15);border:none;border-radius:50%;width:32px;height:32px;color:white;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div id="bpd-avatar" style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#C8893A,#E8A94A);display:flex;align-items:center;justify-content:center;font-size:1.3rem;font-weight:700;color:white;flex-shrink:0;overflow:hidden;border:2px solid rgba(255,255,255,0.3);">?</div>
                    <div>
                    <div id="bpd-name" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.15rem;font-weight:800;">Loading…</div>
                        <div id="bpd-shop" style="font-size:0.75rem;opacity:0.7;margin-top:0.15rem;"></div>
                        <div id="bpd-rating-row" style="display:flex;align-items:center;gap:0.5rem;margin-top:0.35rem;"></div>
                    </div>
                </div>
            </div>

            {{-- Scrollable body --}}
            <div style="flex:1;overflow-y:auto;padding:0;">

                {{-- Quick stats --}}
                    <div id="bpd-stats" style="border-bottom:1px solid #EAE0D0;"></div>


                {{-- Bio --}}
                <div id="bpd-bio-wrap" style="display:none;padding:1rem 1.25rem;border-bottom:1px solid #EAE0D0;font-size:0.82rem;color:#6B4A2A;line-height:1.65;font-style:italic;"></div>

                {{-- Specialties --}}
                <div id="bpd-specs-wrap" style="display:none;padding:1rem 1.25rem;border-bottom:1px solid #EAE0D0;">
                    <div style="font-size:0.62rem;text-transform:uppercase;letter-spacing:0.1em;color:#9A7A5A;font-weight:700;margin-bottom:0.6rem;">🎂 Specialties</div>
                    <div id="bpd-specs" style="display:flex;flex-wrap:wrap;gap:0.4rem;"></div>
                </div>

                {{-- Portfolio --}}
                <div id="bpd-portfolio-wrap" style="display:none;padding:1rem 1.25rem;border-bottom:1px solid #EAE0D0;">
                    <div style="font-size:0.62rem;text-transform:uppercase;letter-spacing:0.1em;color:#9A7A5A;font-weight:700;margin-bottom:0.75rem;">📸 Cake Designs</div>
                    <div id="bpd-portfolio" style="display:grid;grid-template-columns:repeat(3,1fr);gap:0.5rem;"></div>
                </div>

                {{-- Reviews --}}
                <div style="padding:1rem 1.25rem;">
                    <div style="font-size:0.62rem;text-transform:uppercase;letter-spacing:0.1em;color:#9A7A5A;font-weight:700;margin-bottom:0.75rem;">💬 Customer Reviews</div>
                <div id="bpd-reviews" style="display:flex;flex-direction:column;gap:0.6rem;">
                        <div id="bpd-reviews-loading" style="text-align:center;padding:1.5rem;color:#9A7A5A;font-size:0.82rem;">Loading reviews…</div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div style="padding:1rem 1.25rem;border-top:1px solid #EAE0D0;background:white;flex-shrink:0;">
                <button onclick="closeBakerProfileDrawer()" style="width:100%;padding:0.7rem;border-radius:10px;border:1.5px solid #EAE0D0;background:white;color:#6B4A2A;font-size:0.85rem;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans', sans-serif;">Close</button>
            </div>
        </div>
    </div>

    {{-- MODALS --}}

    {{-- Cancel Request Modal --}}
    <div class="confirm-modal-backdrop" id="modal-cancel-request" role="dialog" aria-modal="true">
        <div class="confirm-modal">
            <div class="confirm-modal-header variant-danger">
                <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                <div class="confirm-modal-title">Cancel This Request?</div>
                <div class="confirm-modal-subtitle">This action cannot be undone</div>
            </div>
            <div class="confirm-modal-body">
                <div class="confirm-modal-detail">
                    <div class="confirm-modal-detail-row"><span class="confirm-modal-detail-key">Order ID</span><span class="confirm-modal-detail-val">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                    <div class="confirm-modal-detail-row"><span class="confirm-modal-detail-key">Date & time needed</span><span class="confirm-modal-detail-val">{{ $cakeRequest->delivery_date->format('M d, Y') }}</span></div>
                    <div class="confirm-modal-detail-row"><span class="confirm-modal-detail-key">Current Status</span><span class="confirm-modal-detail-val">{{ str_replace('_', ' ', $cakeRequest->status) }}</span></div>
                </div>
                <p class="confirm-modal-note">Cancelling will remove this request permanently. You can always create a new one from your dashboard.</p>
            </div>
        <div class="confirm-modal-footer">
                <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-cancel-request')">Keep It</button>
                <button class="confirm-modal-btn-ok style-danger" onclick="submitCancelRequest(this)">
                    <span class="btn-spinner"></span><span class="btn-text">✕ Yes, Cancel</span>
                </button>
            </div>
        </div>
    </div>
    {{-- Accept Bid Modal --}}
    <div class="modal-backdrop" id="acceptModal" role="dialog" aria-modal="true">
        <div class="modal-box" style="max-width:720px; width:95vw; max-height:92vh; overflow:hidden; display:flex; flex-direction:column;">

            {{-- HEADER --}}
            <div class="modal-header" style="flex-shrink:0;">
                <span class="modal-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg></span>
                <div class="modal-header-title">Confirm Your Baker</div>
                <div class="modal-header-sub">Review details before accepting this bid</div>
            </div>

            {{-- BODY: Two-column landscape --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; flex:1; min-height:0; overflow:hidden;">

                {{-- LEFT: Map + Location --}}
                <div style="padding:1.25rem; border-right:1px solid var(--border,#EAE0D0); display:flex; flex-direction:column; gap:0.75rem; overflow-y:auto;">

                    {{-- Baker info row --}}
                    <div style="display:flex; align-items:center; gap:0.75rem; background:#FDF6F0; border:1px solid #F0E0C8; border-radius:12px; padding:0.75rem 1rem;">
                        <div class="modal-baker-avatar" id="modalAvatar" style="width:38px;height:38px;font-size:0.95rem;">E</div>
                        <div style="flex:1; min-width:0;">
                            <div class="modal-baker-name" id="modalBakerName" style="font-size:0.88rem;">Baker Name</div>
                            <div class="modal-baker-meta" id="modalBakerMeta" style="font-size:0.68rem;">—</div>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            <div id="modalBakerRating" style="font-size:0.88rem; font-weight:700; color:var(--caramel);">—</div>
                            <div id="modalBakerReviews" style="font-size:0.65rem; color:var(--text-muted);">—</div>
                        </div>
                    </div>

                {{-- Distance badge + address --}}
                    <div>
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.35rem; flex-wrap:wrap;">
                            <div id="modalDistance" style="font-size:0.75rem; font-weight:700; color:var(--caramel); background:#FEF3E8; padding:0.2rem 0.65rem; border-radius:20px; border:1px solid rgba(200,137,74,0.25); display:none;">Calculating…</div>
                            <div id="modalSuggestion" style="font-size:0.72rem; font-weight:600; padding:0.2rem 0.65rem; border-radius:20px; display:none;"></div>
                        </div>
                        <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.4;" id="modalBakerAddress">Loading…</div>
                    </div>

                    {{-- Map --}}
                    <div style="flex:1; min-height:180px; position:relative;">
                        <div id="modalMap" style="width:100%; height:100%; min-height:180px; border-radius:10px; border:1px solid var(--border,#EAE0D0); overflow:hidden; background:#f0ebe3;"></div>
                        <div style="position:absolute; bottom:6px; left:50%; transform:translateX(-50%); background:rgba(255,255,255,0.92); border-radius:20px; padding:3px 10px; font-size:0.62rem; color:var(--text-muted); display:flex; align-items:center; gap:6px; white-space:nowrap; box-shadow:0 1px 4px rgba(0,0,0,0.12);">
                            <span>🔵 You</span><span>·</span><span>🟠 Baker</span>
                        </div>
                    </div>

                    {{-- View Profile Button --}}
                    <button type="button" id="modalViewProfileBtn"
                        onclick="openBakerProfileDrawer()"
                        style="display:none; width:100%; padding:0.6rem 1rem; border:1.5px solid var(--border,#EAE0D0); border-radius:10px; background:var(--warm-white,#FFFDF9); color:var(--brown-mid,#7A4A28); font-size:0.8rem; font-weight:600; cursor:pointer; font-family:'Plus Jakarta Sans', sans-serif; transition:all 0.15s; text-align:center;">
                        👤 View Baker Profile
                    </button>
                </div>

                {{-- RIGHT: Method + Price --}}
                <div style="padding:1.25rem; display:flex; flex-direction:column; gap:0.75rem; overflow-y:auto;">

                    {{-- Smart suggestion banner --}}
                    <div id="modalSmartBanner" style="display:none; border-radius:10px; padding:0.65rem 0.85rem; font-size:0.78rem; line-height:1.5; border:1.5px solid;">
                        <div id="modalSmartBannerText"></div>
                    </div>

                    {{-- Fulfillment choice --}}
                    <div>
                        <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:600; margin-bottom:0.5rem;">How will you receive your cake?</div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem;">
    <label id="modal-ft-delivery" onclick="setModalFulfillment('delivery')" style="border:2px solid var(--caramel,#C07840); border-radius:10px; padding:0.6rem 0.7rem; cursor:pointer; background:#FEF3E8; position:relative; transition:all 0.2s;">                            <input type="radio" name="modal_fulfillment" value="delivery" checked style="position:absolute;opacity:0;width:0;height:0;">
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    
                                    <div>
                                        <div style="font-weight:700; font-size:0.78rem; color:var(--brown-deep);">Delivery</div>
                                        <div style="font-size:0.62rem; color:var(--text-muted);">Get your cake delivered</div>
                                    </div>
                                </div>
                            </label>
    <label id="modal-ft-pickup" onclick="setModalFulfillment('pickup')" style="border:2px solid var(--border,#EAE0D0); border-radius:10px; padding:0.6rem 0.7rem; cursor:pointer; background:white; position:relative; transition:all 0.2s;">                            <input type="radio" name="modal_fulfillment" value="pickup" style="position:absolute;opacity:0;width:0;height:0;">
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <span style="font-size:1.1rem;"></span>
                                    <div>
                                        <div style="font-weight:700; font-size:0.78rem; color:var(--brown-deep);">Pickup</div>
                                        <div style="font-size:0.62rem; color:var(--text-muted);">Collect · Pay cash</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div id="modalPickupNotice" style="display:none; margin-top:0.5rem; background:#FEF9E8; border:1.5px solid #F0D090; border-radius:8px; padding:0.55rem 0.75rem; font-size:0.72rem; color:#8A5010; line-height:1.5;">
                             Baker's address shared after confirmation. Pay final 50% in cash when you collect.
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div style="height:1px; background:var(--border,#EAE0D0);"></div>

                    {{-- Price breakdown --}}
                    <div>
                        <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:600; margin-bottom:0.5rem;">💰 Price Breakdown</div>
                 <div style="background:var(--cream,#F5EFE6); border:1px solid var(--border,#EAE0D0); border-radius:10px; overflow:hidden;">
                            <div id="modalBasePriceRow" style="display:none; justify-content:space-between; padding:0.6rem 0.85rem; border-bottom:1px solid var(--border,#EAE0D0);">
                                <span style="font-size:0.75rem; color:var(--text-muted);">🎂 Cake Price</span>
                                <span id="modalBasePriceAmount" style="font-size:0.82rem; font-weight:600; color:var(--brown-deep);">—</span>
                            </div>
                            <div id="modalRushFeeRow" style="display:none; justify-content:space-between; padding:0.6rem 0.85rem; border-bottom:1px solid var(--border,#EAE0D0);">
                                <span style="font-size:0.75rem; color:#C8562A; font-weight:600;">⚡ Rush Fee</span>
                                <span id="modalRushFeeAmount" style="font-size:0.82rem; font-weight:700; color:#C8562A;">—</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; padding:0.6rem 0.85rem; border-bottom:1px solid var(--border,#EAE0D0);">
                                <span style="font-size:0.75rem; color:var(--text-muted);">Agreed Price</span>
                                <span id="modalPrice" style="font-size:0.9rem; font-weight:700; color:var(--brown-deep);">₱0</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; padding:0.6rem 0.85rem; border-bottom:1px solid var(--border,#EAE0D0);">
                                <span style="font-size:0.75rem; color:var(--text-muted);">₱ Downpayment (50%)</span>
                                <span id="modalDownpayment" style="font-size:0.82rem; font-weight:600; color:#c8862a;">—</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; padding:0.6rem 0.85rem;">
                                <span style="font-size:0.75rem; color:var(--text-muted);" id="modalFinalLabel">🔒 On Delivery (50%)</span>
                                <span id="modalFinalAmount" style="font-size:0.82rem; font-weight:600; color:var(--text-muted);">—</span>
                            </div>
                        </div>
                    </div>

                    {{-- Note --}}
                    <div style="background:#FEF9E8; border:1px solid #F0D090; border-radius:8px; padding:0.6rem 0.85rem; font-size:0.72rem; color:#8A5010; line-height:1.5;">
                        ℹ️ Once confirmed, your baker begins preparations. A down payment is required to start. Down payments are non-refundable as they cover initial preparation costs.
                    </div>

                    {{-- Spacer to push footer --}}
                    <div style="flex:1;"></div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer" style="flex-shrink:0; border-top:1px solid var(--border,#EAE0D0); padding:1rem 1.5rem; background:white;">
                <button class="modal-btn-cancel" onclick="closeAcceptModal()">✕ Cancel</button>
            <button type="button" class="modal-btn-confirm" id="modalConfirmBtn" onclick="handleConfirmBaker(this)">✓ Confirm Baker</button>
            </div>
        </div>
    </div>

    {{-- Reviews Modal --}}
    <div class="modal-backdrop" id="reviewsModal" role="dialog" aria-modal="true" style="z-index:10000;">
        <div class="modal-box" style="max-width:480px; max-height:88vh; display:flex; flex-direction:column;">
            <div class="modal-header">
                <span class="modal-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
                <div class="modal-header-title" id="reviewsModalTitle">Baker Reviews</div>
                <div class="modal-header-sub" id="reviewsModalSub">Loading…</div>
            </div>

            {{-- Rating summary --}}
            <div id="reviewsModalSummary" style="padding:1rem 1.5rem; border-bottom:1px solid var(--border,#EAE0D0); display:flex; align-items:center; gap:1.5rem; background:var(--cream,#F5EFE6);">
                <div style="text-align:center;">
                    <div id="reviewsAvgBig" style="font-size:2.5rem; font-weight:700; color:var(--brown-deep); line-height:1;">—</div>
                    <div id="reviewsStarsBig" style="font-size:1rem; color:#F5A623; margin:0.2rem 0;">—</div>
                    <div id="reviewsTotalBig" style="font-size:0.72rem; color:var(--text-muted);">— reviews</div>
                </div>
                <div style="flex:1;" id="reviewsBarChart"></div>
            </div>

            {{-- Reviews list --}}
            <div id="reviewsModalList" style="flex:1; overflow-y:auto; padding:0.5rem 0;">
                <div style="padding:2rem; text-align:center; color:var(--text-muted); font-size:0.82rem;">Loading reviews…</div>
            </div>

            <div style="padding:1rem 1.5rem; border-top:1px solid var(--border,#EAE0D0); background:white;">
                <button class="modal-btn-cancel" onclick="closeReviewsModal()" style="width:100%; padding:0.7rem;">Close</button>
            </div>
        </div>
    </div>
    {{-- Downpayment Confirmation Modal --}}
    <div class="confirm-modal-backdrop" id="modal-pay-downpayment" role="dialog" aria-modal="true">
        <div class="confirm-modal">
            <div class="confirm-modal-header variant-accept">
                <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg></div>
                <div class="confirm-modal-title">Confirm Downpayment?</div>
                <div class="confirm-modal-subtitle">This will be deducted from your wallet immediately</div>
            </div>
            <div class="confirm-modal-body">
                <div class="confirm-modal-detail">
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Baker</span>
                        <span class="confirm-modal-detail-val">{{ $bakerOrder?->baker->first_name }} {{ $bakerOrder?->baker->last_name }}</span>
                    </div>
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Downpayment (50%)</span>
                        <span class="confirm-modal-detail-val" style="color:var(--caramel);">₱{{ number_format($downpaymentAmount, 2) }}</span>
                    </div>
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Total Order</span>
                        <span class="confirm-modal-detail-val">₱{{ number_format($bakerOrder?->agreed_price ?? 0, 2) }}</span>
                    </div>
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Wallet Balance</span>
                        <span class="confirm-modal-detail-val">₱{{ number_format(\App\Models\Wallet::forUser(auth()->id())->balance, 2) }}</span>
                    </div>
                </div>
                <p class="confirm-modal-note" style="background:#FEF9E8; border:1px solid #F0D090; border-radius:8px; padding:0.65rem; color:#8A5010; margin-bottom:0;">
                    ⚠️ <strong>Downpayments are non-refundable.</strong> They cover the baker's initial preparation costs. Only confirm if you are ready to proceed.
                </p>
            </div>
        <div class="confirm-modal-footer">
                <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-pay-downpayment')">Cancel</button>
                <button class="confirm-modal-btn-ok style-accept" onclick="submitDownpayment(this)">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">✓ Confirm & Pay</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Final Payment Confirmation Modal --}}
    <div class="confirm-modal-backdrop" id="modal-pay-final" role="dialog" aria-modal="true">
        <div class="confirm-modal">
            <div class="confirm-modal-header variant-accept">
                <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg></div>
                <div class="confirm-modal-title">Confirm Final Payment?</div>
                <div class="confirm-modal-subtitle">Your cake is ready — pay to receive delivery</div>
            </div>
            <div class="confirm-modal-body">
                <div class="confirm-modal-detail">
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Baker</span>
                        <span class="confirm-modal-detail-val">{{ $bakerOrder?->baker->first_name }} {{ $bakerOrder?->baker->last_name }}</span>
                    </div>
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Final Payment (50%)</span>
                        <span class="confirm-modal-detail-val" style="color:var(--caramel);">₱{{ number_format($downpaymentAmount, 2) }}</span>
                    </div>
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Total Order</span>
                        <span class="confirm-modal-detail-val">₱{{ number_format($bakerOrder?->agreed_price ?? 0, 2) }}</span>
                    </div>
                    @php $customerWalletModal = \App\Models\Wallet::forUser(auth()->id()); @endphp
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Wallet Balance</span>
                        <span class="confirm-modal-detail-val">₱{{ number_format($customerWalletModal->balance, 2) }}</span>
                    </div>
                </div>
                <p class="confirm-modal-note" style="background:#EFF5EF; border:1px solid #BFDFBE; border-radius:8px; padding:0.75rem; color:#1B4D2E; margin-bottom:0; text-align:left;">
                    🎂 <strong>Confirm you've reviewed the finished cake photo.</strong> Once paid, your baker will proceed with delivery. After receiving your cake, click <em>"Cake Received — Complete Order"</em> to finish the transaction.
                </p>
            </div>
        <div class="confirm-modal-footer">
                <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-pay-final')">Cancel</button>
                <button class="confirm-modal-btn-ok style-accept" onclick="submitFinalPayment(this)">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">✓ Confirm & Pay</span>
                </button>
            </div>
        </div>
    </div>
    <div class="confirm-modal-backdrop" id="modal-cancel-in-progress" role="dialog" aria-modal="true">
        <div class="confirm-modal">
            <div class="confirm-modal-header variant-danger">
                <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                <div class="confirm-modal-title">Cancel This Order?</div>
                <div class="confirm-modal-subtitle">Your baker is already preparing your cake</div>
            </div>
            <div class="confirm-modal-body">
                <div class="confirm-modal-detail">
                    <div class="confirm-modal-detail-row"><span class="confirm-modal-detail-key">Order ID</span><span class="confirm-modal-detail-val">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                    <div class="confirm-modal-detail-row"><span class="confirm-modal-detail-key">Baker</span><span class="confirm-modal-detail-val">{{ $bakerOrder?->baker->first_name }} {{ $bakerOrder?->baker->last_name }}</span></div>
                    <div class="confirm-modal-detail-row"><span class="confirm-modal-detail-key">Downpayment Paid</span><span class="confirm-modal-detail-val" style="color:#8B2A1E;">₱{{ number_format($downpaymentAmount, 2) }}</span></div>
                </div>
                <p class="confirm-modal-note" style="background:#FDF0EE; border:1px solid #F5C5BE; border-radius:8px; padding:0.75rem; color:#8B2A1E; margin-bottom:0; text-align:left;">
                    ⚠️ <strong>Your downpayment of ₱{{ number_format($downpaymentAmount, 2) }} is non-refundable.</strong> It was used to cover your baker's initial preparation costs. Cancelling now means you will lose this amount.
                </p>
            </div>
            <div class="confirm-modal-footer">
                <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-cancel-in-progress')">Keep Order</button>
                <button class="confirm-modal-btn-ok style-danger" onclick="submitCancelInProgress(this)">
                    <span class="btn-spinner"></span><span class="btn-text">✕ Yes, Cancel & Lose Downpayment</span>
                </button>
            </div>
        </div>
    </div>
    <form id="form-cancel-in-progress" method="POST" action="{{ route('customer.cake-requests.destroy', $cakeRequest->id) }}">
        @csrf @method('DELETE')
    </form>

    {{-- Confirm Cake Received Modal --}}
    @if($bakerOrder)
    <div class="confirm-modal-backdrop" id="modal-confirm-received" role="dialog" aria-modal="true">
        <div class="confirm-modal">
            <div class="confirm-modal-header variant-accept">
                <div class="confirm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <div class="confirm-modal-title">Confirm Cake Received?</div>
                <div class="confirm-modal-subtitle">This will complete your order and release payment to your baker</div>
            </div>
            <div class="confirm-modal-body">
                <div class="confirm-modal-detail">
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Baker</span>
                        <span class="confirm-modal-detail-val">{{ $bakerOrder->baker->first_name }} {{ $bakerOrder->baker->last_name }}</span>
                    </div>
                    <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Order ID</span>
                        <span class="confirm-modal-detail-val">#{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
            <div class="confirm-modal-detail-row">
                        <span class="confirm-modal-detail-key">Released to Baker</span>
                        <span class="confirm-modal-detail-val" style="color:var(--caramel);">₱{{ number_format($bakerOrder->agreed_price, 2) }}</span>
                    </div>
                </div>
                <p class="confirm-modal-note" style="background:#FBF4EC; border:1px solid #D4B896; border-radius:8px; padding:0.75rem; color:var(--brown-deep,#5C3D2E); margin-bottom:0; text-align:left; line-height:1.6;">
                🍰 Once confirmed, the full <strong>₱{{ number_format($bakerOrder->agreed_price, 2) }}</strong> will be <strong>released directly to your baker's wallet</strong>. Only confirm after you have physically received your cake and are satisfied with it.
                </p>
            </div>
            <div class="confirm-modal-footer">
                <button class="confirm-modal-btn-cancel" onclick="closeConfirmModal('modal-confirm-received')">Not Yet</button>
                <button class="confirm-modal-btn-ok style-accept" onclick="submitConfirmReceived(this)">
                    <span class="btn-spinner"></span>
                    <span class="btn-text"> Yes, I Got My Cake!</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Hidden form for downpayment --}}
    @if($bakerOrder)
    <form id="form-pay-final" method="POST"
        action="{{ route('customer.orders.confirm-cake-pay', $bakerOrder->id) }}">
        @csrf
    </form>
    <form id="form-pay-downpayment" method="POST"
        action="{{ route('customer.orders.pay-downpayment', $bakerOrder->id) }}">
        @csrf
    </form>
   @endif
    @endsection
    <script>
    function handleReuploadFile(input, dropzoneId, previewId, filenameId, submitBtnId) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const isImage = file.type.startsWith('image/');

        // Determine which form's states to toggle
        const prefix = dropzoneId === 'downDropzone' ? 'down' : 'final';
        const defaultState  = document.getElementById(prefix + 'DefaultState');
        const selectedState = document.getElementById(prefix + 'SelectedState');
        const preview       = document.getElementById(prefix + 'Preview');
        const fileIcon      = document.getElementById(prefix + 'FileIcon');
        const filename      = document.getElementById(prefix + 'Filename');
        const submitBtn     = document.getElementById(submitBtnId);
        const dropzone      = document.getElementById(dropzoneId);

        // Switch to selected state
        if (defaultState)  defaultState.style.display  = 'none';
        if (selectedState) { selectedState.style.display = 'flex'; }
        if (dropzone) { dropzone.style.borderColor = '#8B2A1E'; dropzone.style.borderStyle = 'solid'; dropzone.style.background = '#FDF5F3'; }

        if (filename) filename.textContent = file.name;

        if (isImage && preview) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (fileIcon) fileIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            if (preview) preview.style.display = 'none';
            if (fileIcon) fileIcon.textContent = file.type === 'application/pdf' ? '📄' : '📎';
        }

        if (submitBtn) { submitBtn.disabled = false; submitBtn.style.opacity = '1'; }
    }
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @if(!$cakeRequest->isPickup() && $cakeRequest->delivery_lat && $cakeRequest->delivery_lng)
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $cakeRequest->delivery_lat }};
        const lng = {{ $cakeRequest->delivery_lng }};
        const map = L.map('show-map', { zoomControl: true, dragging: false, scrollWheelZoom: false, doubleClickZoom: false }).setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors', maxZoom: 19 }).addTo(map);
        const icon = L.divIcon({ className: '', html: `<div style="width:20px;height:20px;background:#C8894A;border:3px solid white;border-radius:50%;box-shadow:0 2px 12px rgba(200,137,74,0.7);"></div>`, iconSize: [20,20], iconAnchor: [10,10] });
        L.marker([lat,lng],{icon}).addTo(map).bindPopup('📍 Delivery here').openPopup();
    });
    </script>
    @endif

@if(in_array($cakeRequest->status, ['OPEN','BIDDING']))
    <script>setTimeout(function() { window.location.reload(); }, 60000);</script>
    @endif

    @if($cakeRequest->status === 'RUSH_MATCHING')
    <script>
// Auto-reload every 5s to show new rush bids
    setTimeout(function() { window.location.reload(); }, 5000);

    // Countdown timer
    @if($cakeRequest->rush_expires_at)
    (function() {
        const expiresAt = new Date('{{ $cakeRequest->rush_expires_at->toISOString() }}');
        const timerEl   = document.getElementById('rush-timer');
        if (!timerEl) return;
        function tick() {
            const diff = Math.max(0, Math.floor((expiresAt - new Date()) / 1000));
            const m = Math.floor(diff / 60);
            const s = diff % 60;
            timerEl.textContent = m + ':' + String(s).padStart(2,'0');
            if (diff > 0) setTimeout(tick, 1000);
            else timerEl.closest('#rush-countdown').style.background = '#FFE0E0';
        }
        tick();
    })();
    @endif
    </script>
    @endif
    <script>
    function openConfirmModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => { const f = modal.querySelector('.confirm-modal-btn-cancel'); if (f) f.focus(); }, 100);
    }
    function closeConfirmModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    function submitCancelRequest(btn) {
        const form = document.getElementById('form-cancel-request') || document.getElementById('form-cancel-request-sidebar');
        if (!form) return;
        btn.disabled = true;
        btn.classList.add('is-loading');
        form.submit();
    }
    document.querySelectorAll('.confirm-modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', function(e) { if (e.target === this) closeConfirmModal(this.id); });
    });
    let _pendingForm = null;
    let _modalMap = null;
    let _drawerBakerId = null;  // ← move declaration here, before openAcceptModal

    function haversineKm(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 +
                Math.cos(lat1*Math.PI/180) * Math.cos(lat2*Math.PI/180) * Math.sin(dLng/2)**2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    function applySmartSuggestion(km, bakerCity) {
        const banner  = document.getElementById('modalSmartBanner');
        const bannerT = document.getElementById('modalSmartBannerText');
        const pill    = document.getElementById('modalSuggestion');

        if (!km || isNaN(km)) { banner.style.display='none'; pill.style.display='none'; return; }

        const distText = km < 1
            ? Math.round(km * 1000) + ' m'
            : km.toFixed(1) + ' km';

    document.getElementById('modalDistance').textContent = `📍 ${distText} away`;

        if (km <= 5) {
            // Suggest pickup
            pill.textContent = '💡 Pickup recommended';
            pill.style.cssText = 'font-size:0.72rem;font-weight:600;padding:0.2rem 0.65rem;border-radius:20px;background:#FEF9E8;color:#8A5010;border:1px solid #F0D090;display:inline-block;';

            banner.style.display = 'block';
            banner.style.background = '#FEF9E8';
            banner.style.borderColor = '#F0D090';
            bannerT.innerHTML = `💡 <strong>Baker is only ${distText} away — Pickup is a great option!</strong><br>
                <span style="font-size:0.68rem;color:#8A5010;">You save on delivery fees and can collect your cake directly. Final payment is cash on pickup.</span>`;

            // Auto-highlight pickup but don't force-select
            document.getElementById('modal-ft-pickup').style.boxShadow = '0 0 0 3px rgba(200,137,74,0.2)';
            document.getElementById('modal-ft-delivery').style.boxShadow = 'none';
        } else {
            // Suggest delivery
            pill.textContent = '💡 Delivery recommended';
            pill.style.cssText = 'font-size:0.72rem;font-weight:600;padding:0.2rem 0.65rem;border-radius:20px;background:#EBF3FE;color:#1A3A6B;border:1px solid #BFDBFE;display:inline-block;';

            banner.style.display = 'block';
            banner.style.background = '#EBF3FE';
            banner.style.borderColor = '#BFDBFE';
            bannerT.innerHTML = `<strong>Baker is ${distText} away — Delivery is recommended.</strong><br>
                <span style="font-size:0.68rem;color:#1A3A6B;">The baker will deliver your cake to your address. Much more convenient at this distance!</span>`;

            document.getElementById('modal-ft-delivery').style.boxShadow = '0 0 0 3px rgba(52,120,232,0.15)';
            document.getElementById('modal-ft-pickup').style.boxShadow = 'none';
        }
    }

    function extractCity(address) {
        if (!address) return null;
        // Try to extract city/municipality from Philippine address format
        const parts = address.split(',').map(p => p.trim());
        // Usually: Street, Barangay, City, Province, Region, Country
        if (parts.length >= 3) return parts[parts.length - 3] || parts[1] || null;
        return null;
    }

    function openAcceptModal(btn) {
        const name     = btn.dataset.name;
        const amount   = btn.dataset.amount;
        const days     = btn.dataset.days;
        const formId   = btn.dataset.formId;
const bakerId  = btn.dataset.bakerId;
        const custLat  = parseFloat(btn.dataset.customerLat) || null;
        const custLng  = parseFloat(btn.dataset.customerLng) || null;
        const custAddr = btn.dataset.customerAddress || '';
      const rushFee  = parseFloat(btn.dataset.rushFee) || 0;
const isRush   = btn.dataset.isRush === '1';
    _pendingForm   = document.getElementById(formId);
        console.log('formId:', formId, '| form found:', _pendingForm);
        _drawerBakerId = bakerId;
        document.getElementById('modalViewProfileBtn').style.display = 'block';

        // Reset UI
        document.getElementById('modalAvatar').textContent       = name.charAt(0).toUpperCase();
        document.getElementById('modalBakerName').textContent    = name;
        document.getElementById('modalBakerMeta').textContent    = days + ' day estimate';
        document.getElementById('modalBakerAddress').textContent = 'Loading baker info…';
        document.getElementById('modalBakerRating').textContent  = '—';
        document.getElementById('modalBakerReviews').textContent = '—';
        document.getElementById('modalDistance').textContent     = 'Calculating…';
        document.getElementById('modalSuggestion').style.display = 'none';
        document.getElementById('modalSuggestion').textContent = '';
        document.getElementById('modalSmartBanner').style.display = 'none';
    const reviewsSection = document.getElementById('modalReviewsSection');
    const reviewsList = document.getElementById('modalReviewsList');
    if (reviewsSection) reviewsSection.style.display = 'none';
    if (reviewsList) reviewsList.innerHTML = '';
        document.getElementById('modalPrice').textContent        = amount;
        document.getElementById('modalDownpayment').textContent  = '—';
        document.getElementById('modalFinalAmount').textContent  = '—';

const numAmount = parseFloat(amount.replace(/[₱,]/g,'')) || 0;
        const agreedTotal = isRush ? numAmount + rushFee : numAmount;

        if (agreedTotal > 0) {
            const half = (agreedTotal / 2).toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2});
            document.getElementById('modalDownpayment').textContent = '₱' + half;
            document.getElementById('modalFinalAmount').textContent = '₱' + half;
        }

        // Rush fee row
        const rushFeeRow = document.getElementById('modalRushFeeRow');
        if (rushFeeRow) {
        if (isRush) {
document.getElementById('modalRushFeeAmount').textContent = '+₱' + rushFee.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2});
document.getElementById('modalBasePriceAmount').textContent = '₱' + numAmount.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2});
document.getElementById('modalPrice').textContent = '₱' + agreedTotal.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2});
    rushFeeRow.style.display = 'flex';
    const basePriceRow = document.getElementById('modalBasePriceRow');
    if (basePriceRow) basePriceRow.style.display = 'flex';
} else {
    rushFeeRow.style.display = 'none';
    const basePriceRow = document.getElementById('modalBasePriceRow');
    if (basePriceRow) basePriceRow.style.display = 'none';
}
        }

        setModalFulfillment('delivery');
        document.getElementById('modal-ft-delivery').style.boxShadow = 'none';
        document.getElementById('modal-ft-pickup').style.boxShadow   = 'none';

        // Map placeholder
        document.getElementById('modalMap').innerHTML = '<div style="height:100%;min-height:180px;display:flex;align-items:center;justify-content:center;color:#9B8070;font-size:0.8rem;">Loading map…</div>';

    if (bakerId) {
            fetch(`/baker-info/${bakerId}`)
                .then(r => r.json())
                .then(data => {
                    console.log('Baker API response:', data);      // ← ADD THIS
                    console.log('Address value:', data.address);   // ← ADD THIS
                const addrEl = document.getElementById('modalBakerAddress');
                    addrEl.style.display = '';
                    addrEl.textContent = data.address || 'Address not provided';
                    document.getElementById('modalBakerRating').textContent =
                        data.rating ? '★ ' + parseFloat(data.rating).toFixed(1) : 'No rating yet';
                    document.getElementById('modalBakerReviews').textContent =
                        (data.total_reviews || 0) + ' reviews';

                    const bakerLat = parseFloat(data.latitude);
                    const bakerLng = parseFloat(data.longitude);

                    // Distance + smart suggestion
                    let km = null;
                    if (custLat && custLng && bakerLat && bakerLng) {
                        km = haversineKm(custLat, custLng, bakerLat, bakerLng);
                    }
                    const bakerCity = extractCity(data.address);
                    applySmartSuggestion(km, bakerCity);

                    // Build map
                    document.getElementById('modalMap').innerHTML = '';
                    setTimeout(() => {
                        if (_modalMap) { _modalMap.remove(); _modalMap = null; }

                        const mapCenter = (bakerLat && bakerLng)
                            ? [bakerLat, bakerLng]
                            : (custLat && custLng ? [custLat, custLng] : [14.5995, 120.9842]);

                        _modalMap = L.map('modalMap', {
                            zoomControl: false,
                            scrollWheelZoom: false,
                            dragging: true,
                        }).setView(mapCenter, 13);

                        // Add zoom control top-right
                        L.control.zoom({ position: 'topright' }).addTo(_modalMap);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap', maxZoom: 19,
                        }).addTo(_modalMap);

                        if (bakerLat && bakerLng) {
                            const bakerIcon = L.divIcon({
                                className: '',
                                html: `<div style="width:16px;height:16px;background:#C8894A;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(200,137,74,0.7);"></div>`,
                                iconSize: [16,16], iconAnchor: [8,8],
                            });
                            L.marker([bakerLat, bakerLng], {icon: bakerIcon})
                                .addTo(_modalMap)
                                .bindPopup(`🟠 <strong>${name}</strong>`);
                        }

                        if (custLat && custLng) {
                            const custIcon = L.divIcon({
                                className: '',
                                html: `<div style="width:16px;height:16px;background:#3478E8;border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(52,120,232,0.7);"></div>`,
                                iconSize: [16,16], iconAnchor: [8,8],
                            });
                            L.marker([custLat, custLng], {icon: custIcon})
                                .addTo(_modalMap)
                                .bindPopup(`🔵 <strong>Your Location</strong>`);
                        }

                        if (bakerLat && bakerLng && custLat && custLng) {
                            _modalMap.fitBounds([[bakerLat, bakerLng],[custLat, custLng]], {padding:[25,25]});
                            L.polyline([[bakerLat,bakerLng],[custLat,custLng]], {
                                color:'#C8894A', weight:2, dashArray:'5,5', opacity:0.65
                            }).addTo(_modalMap);
                        }

                        setTimeout(() => _modalMap.invalidateSize(), 150);
                    }, 50);

        // Safe reviews rendering - guards against missing elements
    if (data.reviews && data.reviews.length > 0) {
        const reviewsSec = document.getElementById('modalReviewsSection');
        const list = document.getElementById('modalReviewsList');
        if (reviewsSec) reviewsSec.style.display = 'block';
        if (list) {
            data.reviews.forEach(r => {
                const stars = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);
                const div = document.createElement('div');
                div.style.cssText = 'background:white;border:1px solid var(--border,#EAE0D0);border-radius:8px;padding:0.5rem 0.75rem;flex-shrink:0;';
                div.innerHTML = `
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.2rem;">
                        <span style="font-size:0.75rem;font-weight:700;color:var(--brown-deep);">${r.name}</span>
                        <span style="font-size:0.7rem;color:#F5A623;">${stars}</span>
                    </div>
                    ${r.comment ? `<div style="font-size:0.7rem;color:var(--text-muted);line-height:1.4;font-style:italic;">"${r.comment}"</div>` : ''}
                    <div style="font-size:0.62rem;color:var(--text-muted);margin-top:0.2rem;">${r.date}</div>
                `;
                list.appendChild(div);
            });
        }
    }
                })
    .catch((err) => {
        console.error('Catch triggered:', err);  // ← ADD THIS to see what crashes
        // REMOVE or comment out this line:
        // document.getElementById('modalBakerAddress').textContent = 'Address not provided';
        const distEl = document.getElementById('modalDistance');
        distEl.style.display = 'none';
        document.getElementById('modalMap').innerHTML =
            '<div style="height:180px;display:flex;align-items:center;justify-content:center;color:#9B8070;font-size:0.8rem;background:#f8f4f0;border-radius:10px;">📍 Map unavailable</div>';
    });
        }

        document.getElementById('acceptModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function submitFinalPayment(btn) {
        const form = document.getElementById('form-pay-final');
        if (!form) return;
        btn.disabled = true;
        btn.classList.add('is-loading');
        form.submit();
    }
    function submitCancelInProgress(btn) {
        const form = document.getElementById('form-cancel-in-progress');
        if (!form) return;
        btn.disabled = true;
        btn.classList.add('is-loading');
        form.submit();
    }
    function submitConfirmReceived(btn) {
        const form = document.getElementById('form-confirm-received-inline') || document.getElementById('form-confirm-received-sidebar');
        if (!form) return;
        btn.disabled = true;
        btn.classList.add('is-loading');
        form.submit();
    }
    function submitDownpayment(btn) {
        const form = document.getElementById('form-pay-downpayment');
        if (!form) return;
        btn.disabled = true;
        btn.classList.add('is-loading');
        form.submit();
    }
    function setModalFulfillment(mode) {
        window._selectedFulfillment = mode;  // ← store it reliably
        const isPickup = mode === 'pickup';
        const dlabel = document.getElementById('modal-ft-delivery');
        const plabel = document.getElementById('modal-ft-pickup');
        dlabel.style.borderColor = isPickup ? 'var(--border,#EAE0D0)' : 'var(--caramel,#C07840)';
        dlabel.style.background  = isPickup ? 'white' : '#FEF3E8';
        plabel.style.borderColor = isPickup ? 'var(--caramel,#C07840)' : 'var(--border,#EAE0D0)';
        plabel.style.background  = isPickup ? '#FEF3E8' : 'white';
        document.getElementById('modalPickupNotice').style.display = isPickup ? 'block' : 'none';

        const finalLabel = document.getElementById('modalFinalLabel');
        if (finalLabel) finalLabel.textContent = isPickup ? '💵 Cash on Pickup (50%)' : '🔒 On Delivery (50%)';

        document.querySelectorAll('input[name="modal_fulfillment"]').forEach(r => {
            r.checked = r.value === mode;
        });
    }

    const radioDelivery = document.querySelector('input[name="modal_fulfillment"][value="delivery"]');
    const radioPickup   = document.querySelector('input[name="modal_fulfillment"][value="pickup"]');
    if (radioDelivery) radioDelivery.addEventListener('change', function() {
        if (this.checked) setModalFulfillment('delivery');
    });
    if (radioPickup) radioPickup.addEventListener('change', function() {
        if (this.checked) setModalFulfillment('pickup');
    });

    // Fix: also attach click on the label wrappers
    document.getElementById('modal-ft-delivery')?.addEventListener('click', () => setModalFulfillment('delivery'));
    document.getElementById('modal-ft-pickup')?.addEventListener('click',   () => setModalFulfillment('pickup'));

    function handleConfirmBaker(btn) {
        if (!_pendingForm) {
            console.error('No pending form - _pendingForm is null');
            alert('Something went wrong. Please refresh and try again.');
            return;
        }
        const mode = window._selectedFulfillment || 'delivery';
        const existing = _pendingForm.querySelector('input[name="fulfillment_type"]');
        if (existing) existing.remove();
        const ftInput = document.createElement('input');
        ftInput.type  = 'hidden';
        ftInput.name  = 'fulfillment_type';
        ftInput.value = mode;
        _pendingForm.appendChild(ftInput);
        btn.textContent = 'Confirming…';
        btn.disabled    = true;
        setTimeout(() => _pendingForm.submit(), 50);
    }

    function closeAcceptModal() {
        document.getElementById('acceptModal').classList.remove('open');
        document.body.style.overflow = '';
        _pendingForm = null;
        if (_modalMap) { _modalMap.remove(); _modalMap = null; }
    }
    function openReviewsModal(userId, bakerName) {
        const modal = document.getElementById('reviewsModal');
        document.getElementById('reviewsModalTitle').textContent = bakerName + "'s Reviews";
        document.getElementById('reviewsModalSub').textContent   = 'Loading…';
        document.getElementById('reviewsModalList').innerHTML    =
            '<div style="padding:2rem;text-align:center;color:#9B8070;font-size:0.82rem;">Loading…</div>';
        document.getElementById('reviewsAvgBig').textContent    = '—';
        document.getElementById('reviewsStarsBig').textContent  = '—';
        document.getElementById('reviewsTotalBig').textContent  = '—';
        document.getElementById('reviewsBarChart').innerHTML    = '';

        modal.classList.add('open');
        document.body.style.overflow = 'hidden';

        fetch(`/baker-reviews/${userId}`)
            .then(r => r.json())
            .then(data => {
                const total = data.total || 0;
                const avg   = data.avg   || 0;

                document.getElementById('reviewsModalSub').textContent  = total + ' total review' + (total !== 1 ? 's' : '');
                document.getElementById('reviewsAvgBig').textContent    = avg > 0 ? avg.toFixed(1) : '—';
            if (avg > 0) {
        const f = Math.floor(avg), h = (avg - f) >= 0.5 ? 1 : 0, e = 5 - f - h;
        document.getElementById('reviewsStarsBig').innerHTML = '★'.repeat(f) + (h ? '<span style="position:relative;display:inline-block;"><span style="position:absolute;overflow:hidden;width:50%;">★</span>☆</span>' : '') + '☆'.repeat(e);
    } else {
        document.getElementById('reviewsStarsBig').textContent = '—';
    }
                document.getElementById('reviewsTotalBig').textContent  = total + ' reviews';

                // Bar chart per star
                if (total > 0) {
                    const counts = [5,4,3,2,1].map(s => ({
                        star: s,
                        count: data.reviews.filter(r => r.rating === s).length
                    }));
                    const barHtml = counts.map(c => {
                        const pct = total > 0 ? Math.round((c.count / total) * 100) : 0;
                        return `
                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;">
                                <span style="font-size:0.65rem;color:var(--text-muted);width:14px;text-align:right;">${c.star}</span>
                                <span style="font-size:0.6rem;color:#F5A623;">★</span>
                                <div style="flex:1;height:7px;background:var(--border,#EAE0D0);border-radius:4px;overflow:hidden;">
                                    <div style="width:${pct}%;height:100%;background:${c.star >= 4 ? '#F5A623' : c.star === 3 ? '#C8894A' : '#E05252'};border-radius:4px;transition:width 0.5s;"></div>
                                </div>
                                <span style="font-size:0.62rem;color:var(--text-muted);width:18px;">${c.count}</span>
                            </div>`;
                    }).join('');
                    document.getElementById('reviewsBarChart').innerHTML = barHtml;
                }

                // Review list
                const list = document.getElementById('reviewsModalList');
                if (!data.reviews || data.reviews.length === 0) {
                    list.innerHTML = '<div style="padding:2.5rem;text-align:center;color:var(--text-muted);font-size:0.82rem;">No reviews yet.</div>';
                    return;
                }
                list.innerHTML = data.reviews.map(r => {
                    const stars = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);
                    const starColor = r.rating >= 4 ? '#F5A623' : r.rating === 3 ? '#C8894A' : '#E05252';
                    return `
                        <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--border,#EAE0D0);">
                            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:0.4rem;gap:0.5rem;">
                                <div style="display:flex;align-items:center;gap:0.6rem;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#C07840,#E8A96A);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;flex-shrink:0;">${r.name.charAt(0).toUpperCase()}</div>
                                    <div>
                                        <div style="font-size:0.82rem;font-weight:700;color:var(--brown-deep);">${r.name}</div>
                                        <div style="font-size:0.65rem;color:var(--text-muted);">${r.date}</div>
                                    </div>
                                </div>
                                <div style="font-size:0.82rem;color:${starColor};flex-shrink:0;">${stars}</div>
                            </div>
                            ${r.comment ? `<div style="font-size:0.78rem;color:var(--text-muted);line-height:1.55;padding-left:2.4rem;font-style:italic;">"${r.comment}"</div>` : ''}
                        </div>`;
                }).join('');
            })
            .catch(() => {
                document.getElementById('reviewsModalList').innerHTML =
                    '<div style="padding:2rem;text-align:center;color:var(--text-muted);font-size:0.82rem;">Could not load reviews.</div>';
            });
    }

    function closeReviewsModal() {
        document.getElementById('reviewsModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.getElementById('reviewsModal').addEventListener('click', function(e) {
        if (e.target === this) closeReviewsModal();
    });
    document.getElementById('acceptModal').addEventListener('click', function(e) {
        if (e.target === this) closeAcceptModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('.confirm-modal-backdrop.is-open').forEach(m => closeConfirmModal(m.id));
        if (document.getElementById('acceptModal')?.classList.contains('open')) closeAcceptModal();
        if (document.getElementById('bakerProfileDrawer')?.style.opacity === '1') closeBakerProfileDrawer();
    });


    // ── PORTFOLIO LIGHTBOX ──
    function openPortfolioLightbox(images, startIdx) {
        let current = startIdx;
        const total = images.length;

        // Remove existing lightbox if any
        const existing = document.getElementById('portfolioLightbox');
        if (existing) existing.remove();

        const lb = document.createElement('div');
        lb.id = 'portfolioLightbox';
        lb.style.cssText = 'position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,0.92);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1rem;';

        function render() {
            lb.innerHTML = `
                <button onclick="document.getElementById('portfolioLightbox').remove();"
                    style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,0.15);border:none;border-radius:50%;width:40px;height:40px;color:white;font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:2;">✕</button>
                <div style="position:relative;max-width:90vw;max-height:80vh;display:flex;align-items:center;gap:1rem;">
                    ${total > 1 ? `<button onclick="lbPrev()" style="background:rgba(255,255,255,0.15);border:none;border-radius:50%;width:40px;height:40px;color:white;font-size:1.2rem;cursor:pointer;flex-shrink:0;">‹</button>` : ''}
                    <img src="${images[current]}" style="max-width:80vw;max-height:78vh;object-fit:contain;border-radius:8px;box-shadow:0 8px 40px rgba(0,0,0,0.5);">
                    ${total > 1 ? `<button onclick="lbNext()" style="background:rgba(255,255,255,0.15);border:none;border-radius:50%;width:40px;height:40px;color:white;font-size:1.2rem;cursor:pointer;flex-shrink:0;">›</button>` : ''}
                </div>
                ${total > 1 ? `<div style="color:rgba(255,255,255,0.5);font-size:0.78rem;">${current + 1} / ${total}</div>` : ''}`;
        }

        window.lbPrev = () => { current = (current - 1 + total) % total; render(); };
        window.lbNext = () => { current = (current + 1) % total; render(); };

        lb.addEventListener('click', e => { if (e.target === lb) lb.remove(); });
        document.body.appendChild(lb);
        render();
    }

    function openBakerProfileDrawer() {
        if (!_drawerBakerId) return;
        const drawer = document.getElementById('bakerProfileDrawer');
        const panel  = document.getElementById('bakerProfilePanel');
        drawer.style.pointerEvents = 'all';
        drawer.style.opacity = '1';
        panel.style.transform = 'translateX(0)';
        document.body.style.overflow = 'hidden';

        fetch(`/baker-public-profile/${_drawerBakerId}`)
            .then(r => r.json())
            .then(d => renderBakerDrawer(d))
            .catch(() => {
                document.getElementById('bpd-name').textContent = 'Could not load profile';
            });
    }

    function closeBakerProfileDrawer() {
        const drawer = document.getElementById('bakerProfileDrawer');
        const panel  = document.getElementById('bakerProfilePanel');
        panel.style.transform = 'translateX(100%)';
        drawer.style.opacity = '0';
        setTimeout(() => { drawer.style.pointerEvents = 'none'; }, 300);
        document.body.style.overflow = '';
    }

    function renderBakerDrawer(d) {
    const av = document.getElementById('bpd-avatar');
        if (d.profile_photo) {
            const img = new Image();
            img.onload = () => {
                av.innerHTML = `<img src="${d.profile_photo}" style="width:100%;height:100%;object-fit:cover;">`;
            };
            img.onerror = () => {
                av.textContent = d.name.charAt(0).toUpperCase();
                console.warn('Profile photo failed to load:', d.profile_photo);
            };
            img.src = d.profile_photo;
        } else {
            av.textContent = d.name.charAt(0).toUpperCase();
        }

        // Name / shop
        document.getElementById('bpd-name').textContent = d.name;
        document.getElementById('bpd-shop').textContent  = d.shop_name ? ' ' + d.shop_name : '';

        // Rating row
        const ratingRow = document.getElementById('bpd-rating-row');
        if (d.rating) {
    const full  = Math.floor(d.rating);
    const half  = (d.rating - full) >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    const stars = '★'.repeat(full) + (half ? '<span style="position:relative;display:inline-block;"><span style="position:absolute;overflow:hidden;width:50%;">★</span>☆</span>' : '') + '☆'.repeat(empty);
            ratingRow.innerHTML = `
                <span style="color:#F5A623;font-size:0.82rem;">${stars}</span>
                <span style="font-size:0.75rem;font-weight:700;opacity:0.9;">${parseFloat(d.rating).toFixed(1)}</span>
                <span style="font-size:0.68rem;opacity:0.55;">(${d.total_reviews} review${d.total_reviews !== 1 ? 's' : ''})</span>`;
        } else {
            ratingRow.innerHTML = `<span style="font-size:0.72rem;opacity:0.55;">No reviews yet</span>`;
        }

        // Stats
    // Stats
        const expMap = {'less_than_1':'< 1 yr','1-2':'1–2 yrs','3-5':'3–5 yrs','5-10':'5–10 yrs','10+':'10+ yrs'};
        const expVal  = expMap[d.experience] || d.experience || null;
        const portVal = d.portfolio && d.portfolio.length > 0 ? d.portfolio.length + ' photo' + (d.portfolio.length !== 1 ? 's' : '') : null;
        const stats = [
            ['<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', 'Experience', expVal],
            ['<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8894A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/></svg>', 'Designs', portVal],
        ];
    document.getElementById('bpd-stats').innerHTML = `
            <div style="display:grid;grid-template-columns:1fr 1fr;width:100%;border-top:1px solid #EAE0D0;">
                ${stats.map((s, i) => `
                <div style="padding:1rem 0.75rem;text-align:center;${i === 0 ? 'border-right:1px solid #EAE0D0;' : ''}display:flex;flex-direction:column;align-items:center;gap:0.2rem;">
                    <div style="font-size:1.15rem;line-height:1;">${s[0]}</div>
                    <div style="font-size:0.58rem;text-transform:uppercase;letter-spacing:0.1em;color:#9A7A5A;font-weight:700;margin-top:0.15rem;">${s[1]}</div>
                    <div style="font-size:0.88rem;font-weight:700;color:#3B1F0F;margin-top:0.1rem;">${s[2] !== null ? s[2] : '<span style="color:#C8C0B4;font-weight:400;font-size:0.75rem;">Not set</span>'}</div>
                </div>`).join('')}
            </div>`;

        // Bio
        const bioWrap = document.getElementById('bpd-bio-wrap');
        if (d.bio) { bioWrap.textContent = '"' + d.bio + '"'; bioWrap.style.display = 'block'; }
        else { bioWrap.style.display = 'none'; }

        // Specialties
        const specsWrap = document.getElementById('bpd-specs-wrap');
        const specsEl   = document.getElementById('bpd-specs');
        if (d.specialties && d.specialties.length > 0) {
            specsEl.innerHTML = d.specialties.map(s =>
                `<span style="padding:0.2rem 0.65rem;background:#F5EFE6;border:1px solid #EAE0D0;border-radius:20px;font-size:0.72rem;font-weight:600;color:#6B4A2A;">${s}</span>`
            ).join('');
            specsWrap.style.display = 'block';
        } else { specsWrap.style.display = 'none'; }

    // Portfolio
        const portWrap = document.getElementById('bpd-portfolio-wrap');
        const portEl   = document.getElementById('bpd-portfolio');
    if (d.portfolio && d.portfolio.length > 0) {
            // Store portfolio on window to avoid inline JSON escaping issues
            window._drawerPortfolio = d.portfolio;
            portEl.innerHTML = d.portfolio.map((url, idx) =>
                `<div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid #EAE0D0;cursor:zoom-in;" data-port-idx="${idx}">
                    <img src="${url}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </div>`
            ).join('');
            // Attach click listeners after rendering
            portEl.querySelectorAll('[data-port-idx]').forEach(el => {
                el.addEventListener('click', function() {
                    openPortfolioLightbox(window._drawerPortfolio, parseInt(this.dataset.portIdx));
                });
            });
            portWrap.style.display = 'block';
        } else { portWrap.style.display = 'none'; }

    // Reviews — always re-render
        const revEl = document.getElementById('bpd-reviews');
        revEl.innerHTML = ''; // clear loading state
        if (!d.reviews || d.reviews.length === 0) {
            revEl.innerHTML = '<div style="text-align:center;padding:1.5rem;color:#9A7A5A;font-size:0.82rem;">No reviews yet.</div>';
            return;
        }
        revEl.innerHTML = d.reviews.map(r => {
            const stars     = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);
            const starColor = r.rating >= 4 ? '#F5A623' : r.rating === 3 ? '#C8894A' : '#E05252';
            return `<div style="background:white;border:1px solid #EAE0D0;border-radius:10px;padding:0.85rem 1rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.35rem;">
                    <span style="font-size:0.82rem;font-weight:700;color:#3B1F0F;">${r.name}</span>
                    <div style="display:flex;align-items:center;gap:0.4rem;">
                        <span style="font-size:0.75rem;color:${starColor};">${stars}</span>
                        <span style="font-size:0.62rem;color:#9A7A5A;">${r.date}</span>
                    </div>
                </div>
                ${r.comment ? `<div style="font-size:0.75rem;color:#6B4A2A;line-height:1.55;font-style:italic;">"${r.comment}"</div>` : ''}
            </div>`;
        }).join('');
    }
    </script>
