<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BakeSphere — Artisan Cake Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --brown-darkest: #1a0d07;
            --brown-dark:    #2B1810;
            --brown-mid:     #3D2314;
            --amber:         #C47B2E;
            --amber-light:   #D4943A;
            --amber-pale:    #E8A84A;
            --cream:         #FDF6EE;
            --cream-warm:    #F5EBD8;
            --cream-mid:     #EDD8BC;
            --text-primary:  #2B1810;
            --text-muted:    #7A5A40;
            --text-faint:    #B09070;
            --white:         #FFFFFF;
            --sidebar-bg:    #241508;
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
            background: var(--brown-darkest);
        }

        /* ═══════════════════════════════════
           HERO — CSS grid, fills full viewport
        ═══════════════════════════════════ */
        .hero {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 600px;
            display: grid;
            grid-template-columns: 45% 55%;
            grid-template-rows: 72px 1fr 64px;
            overflow: hidden;
        }

        /* Warm atmospheric glow on left */
        .hero-glow {
            position: absolute; inset: 0; pointer-events: none; z-index: 0;
            background:
                radial-gradient(ellipse 60% 75% at 0%  55%, rgba(196,123,46,0.17) 0%, transparent 60%),
                radial-gradient(ellipse 45% 55% at 28% 100%, rgba(92,52,32,0.38)  0%, transparent 52%),
                radial-gradient(ellipse 52% 42% at 22% 0%,   rgba(61,35,20,0.55)  0%, transparent 56%);
        }

        /* Grain texture */
        .hero-grain {
            position: absolute; inset: 0; pointer-events: none; z-index: 1;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.045'/%3E%3C/svg%3E");
            opacity: 0.55;
        }

        /* Particles — left half */
        .particles { position: absolute; left: 0; top: 0; width: 45%; height: 100%; pointer-events: none; z-index: 2; overflow: hidden; }
        .particle {
            position: absolute; border-radius: 50%;
            background: rgba(196,123,46,0.42);
            animation: rise linear infinite;
        }
        @keyframes rise {
            0%   { transform: translateY(0) scale(0.4); opacity: 0; }
            8%   { opacity: 0.7; }
            92%  { opacity: 0.25; }
            100% { transform: translateY(-100vh) scale(1.4); opacity: 0; }
        }

        /* ── NAV — row 1, both columns ── */
        .nav {
            grid-column: 1 / -1;
            grid-row: 1;
            position: relative; z-index: 30;
            display: flex; align-items: center;
            padding: 0 52px;
            border-bottom: 1px solid rgba(196,123,46,0.07);
        }

        .logo {
            display: flex; align-items: center; gap: 11px;
            text-decoration: none;
        }
        .logo-icon {
            width: 38px; height: 38px; border-radius: 9px;
            background: var(--amber);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .logo-icon svg { width: 19px; height: 19px; }
        .logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.28rem; font-weight: 900;
            color: var(--cream); letter-spacing: -0.01em; line-height: 1;
        }
        .logo-name span { color: var(--amber); }
        .logo-sub {
            font-size: 0.44rem; font-weight: 600;
            letter-spacing: 0.24em; text-transform: uppercase;
            color: rgba(253,246,238,0.26); margin-top: 2px;
        }

        /* ── LEFT — text, row 2, col 1 ── */
        .hero-left {
            grid-column: 1;
            grid-row: 2;
            position: relative; z-index: 10;
            display: flex; flex-direction: column; justify-content: center;
            padding: 0 52px;
        }

        .eyebrow {
            font-size: 0.56rem; font-weight: 700;
            letter-spacing: 0.26em; text-transform: uppercase;
            color: var(--amber); margin-bottom: 16px;
            display: flex; align-items: center; gap: 11px;
        }
        .eyebrow::before {
            content: ''; width: 26px; height: 1.5px;
            background: var(--amber); flex-shrink: 0;
        }

        .headline {
            font-family: 'Playfair Display', serif;
            color: var(--cream); line-height: 0.93;
            margin-bottom: 22px;
        }
       .headline .l1 {
            font-size: clamp(4.7rem, 3.2vw, 3rem);
            font-weight: 900; display: block; letter-spacing: -0.03em; white-space: nowrap;
        }
        .headline .l2 {
            font-size: clamp(3.4rem, 5.8vw, 5.2rem);
            font-weight: 700; font-style: italic;
            display: block; color: var(--amber); letter-spacing: -0.02em;
        }

        .hero-sub { 
            font-size: 0.9rem; line-height: 1.82;
            color: rgba(253,246,238,0.4);
            max-width: 360px; margin-bottom: 34px;
        }
        .hero-sub strong { color: rgba(253,246,238,0.76); font-weight: 600; }

        .btn-login {
            background: var(--amber);
            color: var(--brown-darkest);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem; font-weight: 800;
            letter-spacing: 0.12em; text-transform: uppercase;
            padding: 15px 36px; border: none; border-radius: 8px;
            cursor: pointer; transition: all 0.24s;
            box-shadow: 0 8px 30px rgba(196,123,46,0.44);
            display: inline-block; text-decoration: none; align-self: flex-start;
        }
        .btn-login:hover {
            background: var(--amber-pale);
            transform: translateY(-2px);
            box-shadow: 0 14px 38px rgba(196,123,46,0.6);
        }

        /* ── RIGHT — GIF full bleed, row 2, col 2 ── */
        .hero-right {
            grid-column: 2;
            grid-row: 2;
            position: relative;
            overflow: hidden;
        }

        /* Fade left edge into dark background */
        .hero-right-vignette {
            position: absolute; inset: 0; z-index: 6; pointer-events: none;
            background:
                linear-gradient(to right,  var(--brown-darkest) 0%, rgba(26,13,7,0.55) 12%, transparent 32%),
                linear-gradient(to bottom, var(--brown-darkest) 0%, transparent 12%),
                linear-gradient(to top,    var(--brown-darkest) 0%, transparent 12%);
        }

        /* GIF / video — drop in your asset here */
        .gif-media {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; display: block;
        }

        /* Placeholder (remove when GIF is added) */
        .gif-placeholder {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 14px;
        }
        .gif-placeholder-bg {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #2a1508 0%, #3d2010 50%, #2a1508 100%);
        }
        .gif-placeholder-icon {
            width: 60px; height: 60px; border-radius: 50%;
            border: 2px dashed rgba(196,123,46,0.4);
            background: rgba(196,123,46,0.1);
            display: flex; align-items: center; justify-content: center;
            position: relative; z-index: 1;
            animation: iconPulse 2.6s ease-in-out infinite;
        }
        @keyframes iconPulse {
            0%,100% { transform: scale(1); opacity: 0.65; }
            50%      { transform: scale(1.08); opacity: 1; }
        }
        .gif-placeholder-label {
            font-size: 0.68rem; font-weight: 700;
            color: rgba(253,246,238,0.4);
            letter-spacing: 0.16em; text-transform: uppercase;
            position: relative; z-index: 1;
        }
        .gif-placeholder-sub {
            font-size: 0.56rem; color: rgba(253,246,238,0.2);
            letter-spacing: 0.08em; position: relative; z-index: 1;
        }

        .gif-badge {
            position: absolute; bottom: 14px; right: 14px; z-index: 10;
            background: rgba(26,13,7,0.7);
            border: 1px solid rgba(196,123,46,0.28);
            border-radius: 6px;
            font-size: 0.48rem; font-weight: 700;
            color: var(--amber); letter-spacing: 0.14em; text-transform: uppercase;
            padding: 5px 10px; backdrop-filter: blur(6px);
        }

       .stats-bar {
            grid-column: 1 / -1;
            grid-row: 3;
            position: relative; z-index: 20;
            display: flex; align-items: center; justify-content: center;
            padding: 0 52px;
            border-top: 1px solid rgba(253,246,238,0.055);
            background: rgba(18,9,3,0.7);
            backdrop-filter: blur(10px);
        }
   .stat {
            display: flex; align-items: baseline; gap: 8px;
            padding: 0 32px;
        }
        .stat:first-child { padding-left: 32px; }
  .stat-num {
    font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.45rem; font-weight: 700; color: var(--amber);
        }
       .stat-lbl {
    font-size: 0.54rem; letter-spacing: 0.13em; text-transform: uppercase;
    color: rgba(253,246,238,0.26); font-weight: 500; font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .stat-div { width: 1px; height: 26px; background: rgba(253,246,238,0.07); flex-shrink: 0; }

        /* ═══════════════════════════════════
           LOGIN MODAL
        ═══════════════════════════════════ */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 200;
            background: rgba(10,5,2,0.88);
            backdrop-filter: blur(10px);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            opacity: 0; pointer-events: none;
            transition: opacity 0.35s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }

        .modal {
            display: grid;
            grid-template-columns: 248px 1fr;
            width: 690px; max-width: 100%;
            max-height: 96vh;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.78), 0 0 0 1px rgba(196,123,46,0.2);
            transform: translateY(28px) scale(0.96);
            transition: transform 0.38s cubic-bezier(0.34,1.56,0.64,1), opacity 0.35s ease;
            opacity: 0;
        }
        .modal-overlay.active .modal { transform: translateY(0) scale(1); opacity: 1; }

        /* Left decorative panel */
        .modal-left {
            background: var(--sidebar-bg);
            padding: 42px 24px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; position: relative; overflow: hidden;
        }
        .modal-left::before {
            content: ''; position: absolute;
            width: 220px; height: 220px; border-radius: 50%;
            background: radial-gradient(circle, rgba(196,123,46,0.18) 0%, transparent 70%);
            top: -70px; left: -70px;
        }
        .modal-left::after {
            content: ''; position: absolute;
            width: 160px; height: 160px; border-radius: 50%;
            background: radial-gradient(circle, rgba(196,123,46,0.1) 0%, transparent 70%);
            bottom: -50px; right: -50px;
        }

        .modal-logo {
            display: flex; align-items: center; gap: 9px;
            position: relative; z-index: 1; margin-bottom: 22px;
        }
        .modal-logo-icon {
            width: 34px; height: 34px; border-radius: 8px;
            background: var(--amber);
            display: flex; align-items: center; justify-content: center;
        }
       .modal-logo-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.15rem; font-weight: 900;
            color: var(--cream); line-height: 1;
        }
        .modal-logo-name span { color: var(--amber); }

        .modal-cake {
            position: relative; z-index: 1;
            width: 108px; margin: 0 auto 16px;
            animation: float 3.8s ease-in-out infinite;
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .modal-tagline { position: relative; z-index: 1; }
        .modal-tagline-main {
            font-size: 0.82rem; font-weight: 700;
            color: var(--cream); line-height: 1.5; margin-bottom: 6px;
        }
        .modal-tagline-sub {
            font-size: 0.64rem; color: rgba(253,246,238,0.34); line-height: 1.7;
        }

        /* Right form panel */
        .modal-right {
            background: var(--cream);
            padding: 32px 30px 28px;
            display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow-y: auto;
        }

        .modal-close {
            position: absolute; top: 12px; right: 14px;
            background: none; border: none;
            color: var(--text-muted); font-size: 1.2rem;
            cursor: pointer; transition: color 0.2s; line-height: 1;
        }
        .modal-close:hover { color: var(--amber); }

        .form-eyebrow {
            font-size: 0.52rem; font-weight: 700;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--amber); margin-bottom: 3px;
        }
       .form-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.42rem; font-weight: 700;
            color: var(--text-primary); margin-bottom: 18px; line-height: 1.2;
        }

        /* Alerts */
        .alert { padding: 9px 12px; border-radius: 8px; margin-bottom: 12px; font-size: 0.78rem; }
        .alert-err { background: rgba(180,60,40,0.1); border: 1px solid rgba(180,60,40,0.25); color: #9a2e1e; }
        .alert-ok  { background: rgba(80,140,90,0.1); border: 1px solid rgba(80,140,90,0.25); color: #3a7a48; }
        .alert-pending {
            background: rgba(196,123,46,0.1); border: 1px solid rgba(196,123,46,0.28);
            border-radius: 8px; padding: 0.6rem 0.85rem;
            margin-bottom: 12px; display: flex; gap: 0.55rem; align-items: flex-start;
        }
        .pending-title { font-weight: 700; color: var(--amber); font-size: 0.74rem; margin-bottom: 2px; }
        .pending-msg { font-size: 0.68rem; color: var(--text-muted); line-height: 1.5; }
        .alert-google-hint {
            background: rgba(196,123,46,0.07); border: 1px solid rgba(196,123,46,0.22);
            border-radius: 8px; padding: 0.6rem 0.85rem;
            margin-bottom: 12px; display: flex; gap: 0.55rem; align-items: flex-start;
            font-size: 0.76rem; color: var(--text-muted); line-height: 1.5;
        }
        .alert-google-hint img { width: 13px; height: 13px; flex-shrink: 0; margin-top: 2px; }

        /* Fields */
        .field { margin-bottom: 10px; }
        .field label {
            display: block; font-size: 0.57rem; font-weight: 700;
            color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 0.1em; margin-bottom: 5px;
        }
        .field input {
            width: 100%; padding: 10px 13px;
            background: var(--white);
            border: 1.5px solid var(--cream-mid);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.87rem; color: var(--text-primary);
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .field input::placeholder { color: var(--text-faint); }
        .field input:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(196,123,46,0.1);
        }
        .field input.is-invalid { border-color: rgba(180,60,40,0.5); }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 40px; }
        .pw-toggle {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--text-faint); font-size: 0.84rem;
            display: flex; align-items: center; padding: 3px; transition: color 0.2s;
        }
        .pw-toggle:hover { color: var(--amber); }

        .row-extra {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 12px;
        }
        .row-extra label {
            display: flex; align-items: center; gap: 5px;
            font-size: 0.72rem; color: var(--text-muted); cursor: pointer;
        }
        .row-extra input[type=checkbox] { accent-color: var(--amber); width: 12px; height: 12px; }
        .row-extra a { font-size: 0.72rem; color: var(--amber); text-decoration: none; }
        .row-extra a:hover { text-decoration: underline; }

        .btn-signin {
            width: 100%; padding: 12px;
            background: var(--amber); color: var(--brown-darkest);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.86rem; font-weight: 800;
            border: none; border-radius: 8px; cursor: pointer;
            transition: all 0.22s; letter-spacing: 0.04em;
            box-shadow: 0 5px 18px rgba(196,123,46,0.32);
        }
        .btn-signin:hover {
            background: var(--amber-pale); transform: translateY(-1px);
            box-shadow: 0 9px 26px rgba(196,123,46,0.48);
        }

        .divider { display: flex; align-items: center; gap: 9px; margin: 11px 0; }
        .divider-line { flex: 1; height: 1px; background: var(--cream-mid); }
        .divider-text {
            font-size: 0.54rem; color: var(--text-faint);
            white-space: nowrap; letter-spacing: 0.07em; text-transform: uppercase;
        }

        .google-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 7px; }
        .google-card {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 8px 10px;
            border: 1.5px solid var(--cream-mid); border-radius: 8px;
            text-decoration: none; background: var(--white);
            transition: border-color 0.2s, box-shadow 0.2s; cursor: pointer;
        }
        .google-card:hover { border-color: var(--amber); box-shadow: 0 2px 8px rgba(196,123,46,0.15); }
        .google-card img { width: 14px; height: 14px; flex-shrink: 0; }
        .google-card-sub { font-size: 0.5rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-faint); }
        .google-card-title { font-size: 0.74rem; font-weight: 600; color: var(--text-primary); }

        .register-links { display: grid; grid-template-columns: 1fr 1fr; gap: 7px; }
        .reg-link {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 8px 10px;
            border: 1.5px solid var(--cream-mid); border-radius: 8px;
            text-decoration: none; background: var(--white);
            transition: border-color 0.2s, box-shadow 0.2s; cursor: pointer;
        }
        .reg-link:hover { border-color: var(--amber); box-shadow: 0 2px 8px rgba(196,123,46,0.15); }
        .reg-link-icon { font-size: 14px; flex-shrink: 0; }
        .reg-link-action { font-size: 0.5rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-faint); }
        .reg-link-title  { font-size: 0.74rem; font-weight: 600; color: var(--text-primary); }

        /* Responsive */
        @media (max-width: 820px) {
            .hero { grid-template-columns: 1fr; grid-template-rows: 64px 1fr 260px 60px; height: auto; }
            .hero-left { padding: 28px 28px 0; }
            .hero-right { grid-column: 1; grid-row: 3; }
            .stats-bar { grid-row: 4; padding: 0 28px; }
            .modal { grid-template-columns: 1fr; }
            .modal-left { display: none; }
            .modal-right { padding: 30px 22px 24px; }
            .google-cards, .register-links { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-grain"></div>
    <div class="particles" id="particles"></div>

    <!-- NAV -->
    <nav class="nav">
<div class="logo">        <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <!-- Bottom tier -->
                  <ellipse cx="12" cy="20" rx="8" ry="2" fill="#2B1810"/>
                  <rect x="4" y="16" width="16" height="4" rx="1" fill="#2B1810" opacity="0.9"/>
                  <ellipse cx="12" cy="16" rx="8" ry="1.5" fill="#3D2314"/>
                  <!-- Middle tier -->
                  <ellipse cx="12" cy="15" rx="5.5" ry="1.2" fill="#2B1810"/>
                  <rect x="6.5" y="11.5" width="11" height="3.5" rx="1" fill="#2B1810" opacity="0.9"/>
                  <ellipse cx="12" cy="11.5" rx="5.5" ry="1.2" fill="#3D2314"/>
                  <!-- Top tier -->
                  <ellipse cx="12" cy="10.5" rx="3.5" ry="1" fill="#2B1810"/>
                  <rect x="8.5" y="7.5" width="7" height="3" rx="1" fill="#2B1810" opacity="0.9"/>
                  <ellipse cx="12" cy="7.5" rx="3.5" ry="1" fill="#3D2314"/>
                  <!-- Candle -->
                  <rect x="11.3" y="5" width="1.4" height="2.5" rx="0.5" fill="#2B1810"/>
                  <ellipse cx="12" cy="4.8" rx="0.9" ry="1.4" fill="#E8A84A" opacity="0.95"/>
                  <ellipse cx="12" cy="4.2" rx="0.5" ry="0.8" fill="#FFD060"/>
                </svg>
            </div>
            <div>
                <div class="logo-name">Bake<span>Sphere</span></div>
        
            </div>
        </div>
    </nav>

    <!-- LEFT TEXT -->
    <div class="hero-left">
        <div class="eyebrow">Est. 2024 — Made to Order</div>
        <h1 class="headline">
            <span class="l1">Where Every Slice</span>
            <span class="l2">Tells a Story</span>
        </h1>
        <p class="hero-sub">
          Fresh, made-to-order cakes from <strong>nearby bakers</strong> perfect for any celebration.
        </p>
        <button class="btn-login" onclick="openLogin()">Login to Order →</button>
    </div>

    <!-- RIGHT: GIF FULL BLEED -->
    <div class="hero-right">
        <!--
        ════════════════════════════════════════════════════════════
        FIND & REPLACE: Swap the gif-placeholder div below with:

            <img
                src="{{ asset('images/cake-customization.gif') }}"
                alt="Watch our bakers customize your cake"
                class="gif-media">

        GIFs loop automatically by default — no extra attributes needed.
        The gif-media class makes it fill the entire right column.
        ════════════════════════════════════════════════════════════
        -->
  <img src="{{ asset('GIF/gifcake.gif') }}" alt="Cake customization" class="gif-media">

        <!-- Vignette overlay — keep this even after adding GIF -->
        <div class="hero-right-vignette"></div>
        <div class="gif-badge">GIF Placeholder</div>
    </div>

    <!-- STATS BAR -->
    <div class="stats-bar">
        <div class="stat">
            <span class="stat-num">500+</span>
            <span class="stat-lbl">Cake Decorators</span>
        </div>
        <div class="stat-div"></div>
        <div class="stat">
            <span class="stat-num">12k</span>
            <span class="stat-lbl">Cakes Orders</span>
        </div>
        <div class="stat-div"></div>
        <div class="stat">
            <span class="stat-num">4.9★</span>
            <span class="stat-lbl">Avg. Rating Bakers</span>
        </div>
        <div class="stat-div"></div>
        <div class="stat">
            <span class="stat-num">100%</span>
            <span class="stat-lbl">Made with Love</span>
        </div>
    </div>
</section>


<!-- ════════════════════════
     LOGIN MODAL
════════════════════════ -->
<div class="modal-overlay" id="loginOverlay" onclick="handleOverlayClick(event)">
    <div class="modal" role="dialog" aria-modal="true" aria-label="Sign in to BakeSphere">

        <div class="modal-left">
            <div class="modal-logo">
             <div class="modal-logo-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <ellipse cx="12" cy="20" rx="8" ry="2" fill="#2B1810"/>
                      <rect x="4" y="16" width="16" height="4" rx="1" fill="#2B1810" opacity="0.9"/>
                      <ellipse cx="12" cy="16" rx="8" ry="1.5" fill="#3D2314"/>
                      <ellipse cx="12" cy="15" rx="5.5" ry="1.2" fill="#2B1810"/>
                      <rect x="6.5" y="11.5" width="11" height="3.5" rx="1" fill="#2B1810" opacity="0.9"/>
                      <ellipse cx="12" cy="11.5" rx="5.5" ry="1.2" fill="#3D2314"/>
                      <ellipse cx="12" cy="10.5" rx="3.5" ry="1" fill="#2B1810"/>
                      <rect x="8.5" y="7.5" width="7" height="3" rx="1" fill="#2B1810" opacity="0.9"/>
                      <ellipse cx="12" cy="7.5" rx="3.5" ry="1" fill="#3D2314"/>
                      <rect x="11.3" y="5" width="1.4" height="2.5" rx="0.5" fill="#2B1810"/>
                      <ellipse cx="12" cy="4.8" rx="0.9" ry="1.4" fill="#E8A84A" opacity="0.95"/>
                      <ellipse cx="12" cy="4.2" rx="0.5" ry="0.8" fill="#FFD060"/>
                    </svg>
                </div>
                <div class="modal-logo-name">Bake<span>Sphere</span></div>
            </div>

            <div class="modal-cake">
                <svg width="100%" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="cg1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#7A4528"/><stop offset="100%" stop-color="#3D2314"/>
                        </linearGradient>
                        <linearGradient id="cg2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#C47B2E"/><stop offset="100%" stop-color="#7A4528"/>
                        </linearGradient>
                        <linearGradient id="cg3" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#D4943A"/><stop offset="100%" stop-color="#8A5530"/>
                        </linearGradient>
                    </defs>
                    <ellipse cx="100" cy="184" rx="66" ry="8" fill="#E8D5C0"/>
                    <ellipse cx="100" cy="181" rx="58" ry="5.5" fill="#D0BC9E"/>
                    <path d="M38 155 Q38 165 100 169 Q162 165 162 155 L162 125 Q162 115 100 111 Q38 115 38 125 Z" fill="url(#cg1)"/>
                    <ellipse cx="100" cy="111" rx="62" ry="9" fill="#7A4528"/>
                    <ellipse cx="100" cy="110" rx="62" ry="9" fill="none" stroke="#FDF6EE" stroke-width="7" opacity="0.85"/>
                    <ellipse cx="100" cy="104" rx="52" ry="7" fill="#FDF6EE"/>
                    <ellipse cx="60" cy="112" rx="4.5" ry="7" fill="#FDF6EE"/><ellipse cx="74" cy="113" rx="4.5" ry="7" fill="#FDF6EE"/>
                    <ellipse cx="88" cy="114" rx="4.5" ry="7" fill="#FDF6EE"/><ellipse cx="102" cy="115" rx="4.5" ry="7" fill="#FDF6EE"/>
                    <ellipse cx="116" cy="114" rx="4.5" ry="7" fill="#FDF6EE"/><ellipse cx="130" cy="112" rx="4" ry="6.5" fill="#FDF6EE"/>
                    <path d="M52 96 Q52 106 100 110 Q148 106 148 96 L148 68 Q148 58 100 54 Q52 58 52 68 Z" fill="url(#cg2)"/>
                    <ellipse cx="100" cy="54" rx="48" ry="8" fill="#C47B2E"/>
                    <ellipse cx="100" cy="53" rx="48" ry="8" fill="none" stroke="#FDF6EE" stroke-width="7" opacity="0.88"/>
                    <ellipse cx="100" cy="47" rx="40" ry="6" fill="#FDF6EE"/>
                    <ellipse cx="67" cy="55" rx="4" ry="6.5" fill="#FDF6EE"/><ellipse cx="80" cy="56" rx="4" ry="6.5" fill="#FDF6EE"/>
                    <ellipse cx="93" cy="57" rx="4" ry="6.5" fill="#FDF6EE"/><ellipse cx="106" cy="57" rx="4" ry="6.5" fill="#FDF6EE"/>
                    <ellipse cx="119" cy="56" rx="3.5" ry="6" fill="#FDF6EE"/>
                    <path d="M64 38 Q64 47 100 51 Q136 47 136 38 L136 18 Q136 9 100 5 Q64 9 64 18 Z" fill="url(#cg3)"/>
                    <ellipse cx="100" cy="5" rx="36" ry="6" fill="#D4943A"/>
                    <ellipse cx="100" cy="4" rx="36" ry="6" fill="none" stroke="#FDF6EE" stroke-width="6" opacity="0.9"/>
                    <ellipse cx="100" cy="0" rx="28" ry="5" fill="#FDF6EE" opacity="0.95"/>
                    <rect x="95" y="-18" width="10" height="22" rx="4" fill="#E8D5C0"/>
                    <rect x="95" y="-14" width="10" height="3" rx="1.5" fill="#C47B2E" opacity="0.65"/>
                    <ellipse cx="100" cy="-22" rx="5.5" ry="9" fill="#F0A060" opacity="0.96"/>
                    <ellipse cx="100" cy="-25" rx="3.2" ry="6" fill="#FFD060"/>
                    <ellipse cx="100" cy="-28" rx="1.6" ry="3" fill="#fff" opacity="0.88"/>
                </svg>
            </div>

            <div class="modal-tagline">
                <div class="modal-tagline-sub">Order handcrafted cakes made<br>with love.</div>
            </div>
        </div>

        <div class="modal-right">
            <button class="modal-close" onclick="closeLogin()" aria-label="Close">&times;</button>

            <div class="form-eyebrow">BakeSphere Marketplace</div>
            <h2 class="form-title">Sign In to your Account</h2>

            {{-- Google account error --}}
            @if ($errors->has('email') && str_contains($errors->first('email'), 'Google'))
                <div class="alert-google-hint">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="">
                    <div>{{ $errors->first('email') }}</div>
                </div>
            @elseif ($errors->has('password'))
                {{-- password error: shown inline under field, pw field stays visible --}}
            @elseif ($errors->any())
                <div class="alert alert-err">
                    @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-ok">{{ session('success') }}</div>
            @endif

            @if (session('pending_approval'))
                <div class="alert-pending">
                    <div style="font-size:0.9rem;flex-shrink:0;">⏳</div>
                    <div>
                        <div class="pending-title">Application Submitted!</div>
                        <div class="pending-msg">{{ session('pending_approval') }}</div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="juan@email.com"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        id="loginEmail" required autofocus>
                </div>
              <div class="field" id="pwFieldWrap"
                     style="{{ $errors->has('password') ? 'display:block' : 'display:none' }}">
                    <label>Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="loginPassword"
                            placeholder="Your password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        <button type="button" class="pw-toggle" onclick="togglePw()">👁</button>
                    </div>
                    @error('password')
                        <div style="color:#9a2e1e;font-size:0.72rem;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>
                            <div class="row-extra" id="extraRow"
                     style="{{ $errors->has('password') ? 'display:flex' : 'display:none' }}">

                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="#">Forgot password?</a>
                </div>
          <button type="submit" class="btn-signin" id="submitBtn">
                    {{ $errors->has('password') ? 'Sign In →' : 'Continue →' }}
                </button>
            </form>

            <div class="divider"><div class="divider-line"></div><span class="divider-text">or continue with Google</span><div class="divider-line"></div></div>
            <div class="google-cards">
                <a href="{{ route('auth.google', ['as' => 'customer']) }}" class="google-card">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                    <div><div class="google-card-sub">Sign in as</div><div class="google-card-title">Customer</div></div>
                </a>
                <a href="{{ route('auth.google', ['as' => 'baker']) }}" class="google-card">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                    <div><div class="google-card-sub">Sign in as</div><div class="google-card-title">Baker</div></div>
                </a>
            </div>

            <div class="divider"><div class="divider-line"></div><span class="divider-text">Don't have an account yet?</span><div class="divider-line"></div></div>
            <div class="register-links">
                <a href="{{ route('register') }}" class="reg-link">
                    <span class="reg-link-icon">👤</span>
                    <div><div class="reg-link-action">Register as</div><div class="reg-link-title">Customer</div></div>
                </a>
                <a href="{{ route('baker.register') }}" class="reg-link">
                    <span class="reg-link-icon">🎂</span>
                    <div><div class="reg-link-action">Register as</div><div class="reg-link-title">Baker</div></div>
                </a>
            </div>
        </div>
    </div>
</div>


<script>
    /* Particles */
    const pc = document.getElementById('particles');
    for (let i = 0; i < 16; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        const s = 1.4 + Math.random() * 3;
        p.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*92}%;bottom:0;animation-duration:${7+Math.random()*10}s;animation-delay:${Math.random()*9}s;opacity:0;`;
        pc.appendChild(p);
    }

    /* Modal */
    function openLogin() {
        document.getElementById('loginOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('loginEmail').focus(), 350);
    }
    function closeLogin() {
        document.getElementById('loginOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    function handleOverlayClick(e) {
        if (e.target === document.getElementById('loginOverlay')) closeLogin();
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLogin(); });

    @if ($errors->any() || session('success') || session('pending_approval'))
        document.addEventListener('DOMContentLoaded', () => openLogin());
    @endif

    function togglePw() {
        const f = document.getElementById('loginPassword');
        const b = document.querySelector('.pw-toggle');
        f.type = f.type === 'password' ? 'text' : 'password';
        b.textContent = f.type === 'password' ? '👁' : '🙈';
    }

    /* Smart email provider check */
    const emailInput = document.getElementById('loginEmail');
    const pwWrap     = document.getElementById('pwFieldWrap');
    const extraRow   = document.getElementById('extraRow');
    const submitBtn  = document.getElementById('submitBtn');
    let debTimer;

    emailInput.addEventListener('input', function () {
        clearTimeout(debTimer);
        pwWrap.style.display = extraRow.style.display = 'none';
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Continue →';
        hideHints();
        const email = this.value.trim();
        if (!email.includes('@') || !email.includes('.')) return;
        debTimer = setTimeout(() => checkProvider(email), 600);
    });

    async function checkProvider(email) {
        try {
            const res  = await fetch('{{ route("check.email.provider") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ email })
            });
            const data = await res.json();
            if (data.status === 'google') {
                pwWrap.style.display = extraRow.style.display = 'none';
                submitBtn.style.display = 'none';
                showHint('google');
            } else if (data.status === 'password') {
                pwWrap.style.display = 'block';
                extraRow.style.display = 'flex';
                submitBtn.style.display = 'block';
                submitBtn.textContent = 'Sign In →';
                hideHints();
            } else {
                pwWrap.style.display = extraRow.style.display = 'none';
                submitBtn.style.display = 'block';
                submitBtn.textContent = 'Continue →';
                showHint('noreg');
            }
        } catch {
            pwWrap.style.display = 'block';
            extraRow.style.display = 'flex';
            submitBtn.style.display = 'block';
            submitBtn.textContent = 'Sign In →';
        }
    }

    function showHint(type) {
        hideHints();
        const hint = document.createElement('div');
        if (type === 'google') {
            hint.id = 'hint-google'; hint.className = 'alert-google-hint';
            hint.innerHTML = `<img src="https://www.svgrepo.com/show/475656/google-color.svg" alt=""><div>This account uses Google Sign-In. Use the <strong>Continue with Google</strong> button below.</div>`;
        } else {
            hint.id = 'hint-noreg'; hint.className = 'alert-google-hint';
            hint.style.cssText = 'border-color:rgba(196,123,46,0.2);background:rgba(196,123,46,0.05);';
            hint.innerHTML = `<div style="font-size:14px;flex-shrink:0">🔍</div><div style="color:#7A5A40">No account found. <a href="{{ route('register') }}" style="color:#C47B2E;font-weight:700">Register as Customer</a> or <a href="{{ route('baker.register') }}" style="color:#C47B2E;font-weight:700">Register as Baker</a>.</div>`;
        }
        emailInput.closest('.field').after(hint);
    }

    function hideHints() {
        ['hint-google','hint-noreg'].forEach(id => { const el = document.getElementById(id); if (el) el.remove(); });
    }
</script>
</body>
</html> 