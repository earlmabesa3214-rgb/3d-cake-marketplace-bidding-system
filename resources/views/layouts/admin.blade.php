    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'BakeSphere Admin') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --bg:            #F5F0E8;
                --surface:       #FFFFFF;
                --surface-2:     #FAF7F2;
                --surface-3:     #F2ECE2;
                --border:        #E8E0D0;
                --border-md:     #D8CCBA;
                --gold:          #C07828;
                --gold-dark:     #9A5E14;
                --gold-light:    #DC9E48;
                --gold-soft:     #FEF3E2;
                --copper:        #A45224;
                --teal:          #1F7A6C;
                --teal-soft:     #E4F2EF;
                --rose:          #B43840;
                --rose-soft:     #FDEAEB;
                --espresso:      #2C1608;
                --mocha:         #6A4824;
                --sand:          #C4A470;
                --text-primary:  #1E0E04;
                --text-secondary:#4A2C14;
                --text-muted:    #8C6840;
                --sidebar-w:     268px;
                --header-h:      64px;
                --r:   10px;
                --rl:  14px;
                --rxl: 18px;
            }

            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    height: 100%;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg) !important;
    color: var(--text-primary);
    font-size: 16px;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}
* { font-family: 'Plus Jakarta Sans', sans-serif !important; }
.topbar-date,
.nav-badge,
.order-ref { font-variant-numeric: tabular-nums !important; }
            /* ── SIDEBAR ─────────────────────────────────────── */
            .admin-sidebar {
                position: fixed; top: 0; left: 0;
                width: var(--sidebar-w); height: 100vh;
                background: var(--espresso);
                display: flex; flex-direction: column;
                z-index: 200;
                box-shadow: 2px 0 20px rgba(20,8,0,0.2);
                transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
            }
            .admin-sidebar::after {
                content: '';
                position: absolute; top: 0; right: 0;
                width: 1px; height: 100%;
                background: linear-gradient(180deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 50%, transparent 100%);
            }

            /* ── BRAND ───────────────────────────────────────── */
            .sidebar-brand {
                padding: 1.75rem 1.5rem 1.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.07);
                flex-shrink: 0;
            }
            .brand-logo { display: flex; align-items: center; gap: 0.875rem; }
            .brand-icon {
                width: 42px; height: 42px; border-radius: 12px;
                background: linear-gradient(135deg, var(--gold), var(--copper));
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 2px 12px rgba(192,120,40,0.35);
                flex-shrink: 0;
            }
            .brand-text { flex: 1; min-width: 0; }
        .brand-name {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 1.2rem; font-weight: 700;
                letter-spacing: 0.01em; color: #FDF8F3;
                line-height: 1.2;
            }
       .brand-sub {
    font-size: 0.6rem; font-weight: 500;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: rgba(196,164,112,0.55);
    margin-top: 3px;
    white-space: nowrap;
}

            /* ── NAV ─────────────────────────────────────────── */
            .sidebar-nav {
                flex: 1; overflow-y: auto;
                padding: 1.25rem 0.875rem;
                display: flex; flex-direction: column;
                gap: 0.25rem;
            }
            .sidebar-nav::-webkit-scrollbar { width: 3px; }
            .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

            .nav-group { margin-bottom: 0.5rem; }

    .nav-label {
                font-size: 0.65rem; font-weight: 700;
                letter-spacing: 0.16em; text-transform: uppercase;
                color: rgba(196,164,112,0.45);
                padding: 0 0.75rem;
                margin-bottom: 0.4rem;
                margin-top: 0.75rem;
                display: block;
            }
            .nav-group:first-child .nav-label { margin-top: 0; }

.nav-item {
                display: flex; align-items: center; gap: 0.75rem;
                padding: 0.72rem 0.875rem;
                border-radius: var(--r);
                font-size: 0.875rem; font-weight: 500;
                color: rgba(253,248,243,0.58);
                text-decoration: none;
                transition: all 0.15s ease;
                cursor: pointer;
                border: none; background: none; width: 100%; text-align: left;
                font-family: 'Plus Jakarta Sans', sans-serif;
                position: relative;
                margin-bottom: 0.1rem;
            }
            .nav-item svg {
                flex-shrink: 0; opacity: 0.55;
                transition: opacity 0.15s;
                width: 17px; height: 17px;
            }
            .nav-item span.label { flex: 1; }
            .nav-item:hover {
                background: rgba(255,255,255,0.07);
                color: rgba(253,248,243,0.9);
            }
            .nav-item:hover svg { opacity: 0.85; }
            .nav-item.active {
                background: rgba(192,120,40,0.2);
                color: var(--gold-light);
                font-weight: 600;
            }
            .nav-item.active svg { opacity: 1; color: var(--gold-light); }
            .nav-item.active::before {
                content: '';
                position: absolute; left: 0; top: 50%; transform: translateY(-50%);
                width: 3px; height: 18px; border-radius: 0 2px 2px 0;
                background: var(--gold);
            }

            .nav-badge {
                font-size: 0.62rem; font-weight: 700;
                padding: 0.12rem 0.45rem; border-radius: 8px;
                min-width: 18px; text-align: center;
                background: var(--gold); color: #fff;
                font-variant-numeric: tabular-nums;
            }
            .nav-badge.teal { background: var(--teal); }
            .nav-badge.rose { background: var(--rose); }

            /* ── SIDEBAR USER ─────────────────────────────────── */
            .sidebar-user {
                padding: 1rem 1.25rem;
                border-top: 1px solid rgba(255,255,255,0.07);
                display: flex; align-items: center; gap: 0.75rem;
                flex-shrink: 0;
            }
            .user-avatar {
                width: 38px; height: 38px; border-radius: 10px;
                background: linear-gradient(135deg, var(--gold), var(--copper));
                display: flex; align-items: center; justify-content: center;
                font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
                font-size: 0.75rem; color: #fff; flex-shrink: 0;
            }
            .user-info { flex: 1; min-width: 0; }
    .user-name {
                font-size: 0.875rem; font-weight: 600;
                color: rgba(253,248,243,0.88);
                white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            }
            .user-role { font-size: 0.72rem; color: rgba(196,164,112,0.5); margin-top: 1px; }
.user-logout {
    background: rgba(180,56,64,0.12);
    border: 1px solid rgba(180,56,64,0.25);
    color: #FFAAB0;
    cursor: pointer;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.7rem;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
}
.user-logout:hover {
    background: rgba(180,56,64,0.28);
    border-color: rgba(180,56,64,0.5);
    color: #FFD0D3;
}

            /* ── TOPBAR ───────────────────────────────────────── */
            .admin-topbar {
                position: fixed; top: 0;
                left: var(--sidebar-w); right: 0;
                height: var(--header-h);
                background: var(--surface);
                border-bottom: 1px solid var(--border);
                display: flex; align-items: center;
                padding: 0 1.75rem; z-index: 100;
                gap: 1rem;
                box-shadow: 0 1px 8px rgba(120,80,30,0.05);
            }
       .topbar-breadcrumb {
                display: flex; align-items: center; gap: 0.4rem;
                font-size: 0.875rem; color: var(--text-muted);
                flex: 1; min-width: 0;
            }
            .topbar-breadcrumb .sep { color: var(--border-md); }
       .topbar-breadcrumb .current {
                font-weight: 700; color: var(--text-secondary);
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 0.95rem;
            }
            .topbar-right { display: flex; align-items: center; gap: 0.5rem; }
            .topbar-btn {
                position: relative; width: 36px; height: 36px;
                background: var(--surface-2); border: 1.5px solid var(--border);
                border-radius: var(--r); display: flex; align-items: center;
                justify-content: center; cursor: pointer; color: var(--text-muted);
                transition: all 0.15s;
            }
            .topbar-btn:hover { background: var(--gold-soft); border-color: rgba(192,120,40,0.3); color: var(--gold); }
            .notif-dot {
                position: absolute; top: 6px; right: 6px;
                width: 7px; height: 7px; border-radius: 50%;
                background: var(--rose); border: 1.5px solid var(--surface);
            }
        .topbar-date {
                font-size: 0.8rem; color: var(--text-muted);
                font-variant-numeric: tabular-nums;
                background: var(--surface-2); border: 1.5px solid var(--border);
                border-radius: var(--r); padding: 0 0.875rem;
                height: 36px; display: flex; align-items: center; white-space: nowrap;
            }

            /* ── NOTIF DROPDOWN ───────────────────────────────── */
            .notif-wrap { position: relative; }
            .notif-dropdown {
                position: absolute; top: calc(100% + 8px); right: 0;
                width: 300px; background: var(--surface);
                border: 1.5px solid var(--border-md);
                border-radius: var(--rl);
                box-shadow: 0 12px 40px rgba(80,40,10,0.14);
                z-index: 500; display: none; overflow: hidden;
            }
            .notif-dropdown.open { display: block; animation: dropDown 0.18s ease; }
            @keyframes dropDown { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }
            .notif-header {
                display: flex; justify-content: space-between; align-items: center;
                padding: 0.875rem 1rem; border-bottom: 1px solid var(--border);
                font-size: 0.85rem; font-weight: 700; color: var(--text-secondary);
            }
            .notif-mark { font-size: 0.75rem; font-weight: 500; color: var(--gold); cursor: pointer; }
            .notif-item-drop {
                display: flex; gap: 0.625rem; padding: 0.75rem 1rem;
                border-bottom: 1px solid var(--border); cursor: pointer;
                transition: background 0.12s;
            }
            .notif-item-drop:last-child { border-bottom: none; }
            .notif-item-drop:hover { background: var(--surface-2); }
            .notif-item-drop.unread { background: var(--gold-soft); }
            .notif-indicator { width: 7px; height: 7px; border-radius: 50%; background: var(--gold); flex-shrink: 0; margin-top: 5px; }
            .notif-item-drop.unread .notif-indicator { background: var(--rose); }
            .notif-text { font-size: 0.8rem; color: var(--text-primary); line-height: 1.45; }
            .notif-time { font-size: 0.68rem; color: var(--text-muted); margin-top: 2px; }

            /* ── SEARCH ───────────────────────────────────────── */
            .search-overlay {
                position: fixed; inset: 0; background: rgba(28,12,2,0.48);
                backdrop-filter: blur(4px); z-index: 600;
                display: none; align-items: flex-start;
                justify-content: center; padding-top: 7rem;
            }
            .search-overlay.open { display: flex; animation: fadeIn 0.15s ease; }
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            .search-box {
                width: 100%; max-width: 520px;
                background: var(--surface); border: 1.5px solid var(--border-md);
                border-radius: var(--rxl); overflow: hidden;
                box-shadow: 0 20px 60px rgba(80,40,10,0.2);
                animation: searchIn 0.2s cubic-bezier(0.34,1.2,0.64,1);
            }
            @keyframes searchIn { from { opacity:0; transform:translateY(-16px) scale(0.97); } to { opacity:1; transform:none; } }
            .search-input-row {
                display: flex; align-items: center; gap: 0.75rem;
                padding: 1rem 1.25rem; border-bottom: 1px solid var(--border);
            }
            .search-input-row svg { color: var(--text-muted); flex-shrink: 0; }
            .search-global-input {
                flex: 1; border: none; outline: none; background: none;
                font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9rem; color: var(--text-primary);
            }
            .search-global-input::placeholder { color: var(--text-muted); }
            .search-esc {
                font-size: 0.65rem; font-variant-numeric: tabular-nums;
                color: var(--text-muted); background: var(--surface-3);
                border: 1px solid var(--border-md); border-radius: 5px;
                padding: 0.12rem 0.4rem; cursor: pointer;
            }
            .search-empty { padding: 2rem 1.25rem; text-align: center; font-size: 0.8rem; color: var(--text-muted); }

            /* ── MAIN ─────────────────────────────────────────── */
            .admin-main {
                margin-left: var(--sidebar-w);
                padding-top: calc(var(--header-h) + 1.75rem);
                min-height: 100vh;
                background: var(--bg);
                padding-left: 1.75rem;
                padding-right: 1.75rem;
                padding-bottom: 3rem;
            }

            /* ── ALERTS ───────────────────────────────────────── */
          .alert { padding: 0.875rem 1.25rem; border-radius: var(--r); margin-bottom: 1.5rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; }
            .alert-success { background: #EDF7EE; color: #2D6A30; border: 1px solid #C3E6C5; }
            .alert-error   { background: var(--rose-soft); color: var(--rose); border: 1px solid #F5C5BE; }
            .alert-warning { background: var(--gold-soft); color: var(--gold-dark); border: 1px solid #F0D4A8; }

            /* ── MOBILE ───────────────────────────────────────── */
            @media (max-width: 900px) {
                .admin-sidebar { transform: translateX(-100%); }
                .admin-sidebar.open { transform: translateX(0); box-shadow: 4px 0 32px rgba(20,8,0,0.3); }
                .admin-topbar { left: 0; }
                .admin-main { margin-left: 0; }
                .topbar-date { display: none; }
            }
            .sidebar-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(28,12,2,0.42); z-index: 190;
                backdrop-filter: blur(2px);
            }
            .sidebar-overlay.show { display: block; }
            .mobile-menu-btn {
                display: none; background: var(--surface-2);
                border: 1.5px solid var(--border); border-radius: var(--r);
                width: 36px; height: 36px;
                align-items: center; justify-content: center;
                cursor: pointer; color: var(--text-secondary);
            }
            @media (max-width: 900px) { .mobile-menu-btn { display: flex; } }
        </style>
        <style>
/* ── admin console theme (retints every admin page through the existing variables) ── */
:root{--bg:#f7f2e9;--surface-2:#fbf8f1;--surface-3:#efe6d7;--border:#e2d6c3;--border-md:#d8c8b7;
--espresso:#24150f;--choc:#3a241a;--deep:#4a2a1a;--champ:#b89452;--caramel:#a96f42;--burg:#54252c;--taupe:#9a897a;--beige:#d8c8b7;--cream:#efe6d7;
--gold:#b89452;--gold-dark:#8a6b30;--gold-light:#d3b77e;--gold-soft:#f4ecda;--copper:#a96f42;
--teal:#2f5d46;--teal-soft:#e6eee8;--rose:#7a2a32;--rose-soft:#f4e6e7;
--amber:#a8741a;--amber-soft:#f8efd8;--info:#2f5f6b;--info-soft:#e4eef0;
--text-primary:#24150f;--text-secondary:#3a241a;--text-muted:#7d6b5b;
--sidebar-w:264px;--header-h:60px;--r:6px;--rl:8px;--rxl:8px;}

/* sidebar */
.admin-sidebar{background:linear-gradient(180deg,#24150f 0%,#1c100a 100%);box-shadow:none;border-right:1px solid rgba(184,148,82,.14);}
.sidebar-brand{padding:1.35rem 1.25rem 1.2rem;}
.brand-icon{width:36px;height:36px;border-radius:6px;background:transparent;border:1px solid var(--champ);box-shadow:none;}
.brand-icon svg{stroke:var(--gold-light);}
.brand-name{font-size:1.05rem;font-weight:800;letter-spacing:.02em;}
.brand-sub{color:var(--gold-light);opacity:.7;font-weight:600;letter-spacing:.16em;}
.sidebar-nav{padding:1rem .75rem;}
.nav-label{display:flex;align-items:center;gap:.6rem;color:rgba(211,183,126,.6);letter-spacing:.18em;padding:0 .6rem;}
.nav-label::after{content:'';flex:1;height:1px;background:rgba(255,255,255,.07);}
.nav-item{padding:.6rem .75rem;border-radius:4px;font-size:.84rem;}
.nav-item svg{width:16px;height:16px;}
.nav-item:hover{background:rgba(255,255,255,.05);}
.nav-item.active{background:rgba(184,148,82,.11);color:#ebd9ae;box-shadow:inset 0 0 0 1px rgba(184,148,82,.16);}
.nav-item.active svg{color:var(--gold-light);}
.nav-item.active::before{left:0;height:100%;top:0;transform:none;width:2px;border-radius:0;background:var(--champ);}
.nav-badge{border-radius:3px;background:var(--champ);color:var(--espresso);}
.nav-badge.rose{background:#9a3a44;color:#fff;}
.sidebar-user{padding:.9rem 1rem;background:rgba(0,0,0,.18);}
.user-avatar{width:34px;height:34px;border-radius:6px;background:var(--choc);border:1px solid rgba(184,148,82,.4);color:var(--gold-light);}
.user-role{color:var(--gold-light);opacity:.65;letter-spacing:.08em;text-transform:uppercase;font-size:.62rem;font-weight:600;}
.user-logout{border-radius:4px;}

/* command bar */
.admin-topbar{box-shadow:none;background:#fbf8f1;border-bottom:1px solid var(--border-md);}
.topbar-breadcrumb{font-size:.68rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;gap:.55rem;}
.topbar-breadcrumb .crumb-brand{font-weight:800;color:var(--gold-dark);}
.topbar-breadcrumb .sep{color:var(--taupe);opacity:.6;}
.topbar-breadcrumb .current{font-size:.72rem;font-weight:800;color:var(--espresso);letter-spacing:.14em;}
.topbar-btn,.mobile-menu-btn,.topbar-date{border-width:1px;border-radius:5px;}
.topbar-date{font-size:.74rem;font-weight:600;letter-spacing:.02em;}
.notif-dropdown{border-width:1px;border-radius:8px;box-shadow:0 12px 32px rgba(36,21,15,.16);}
.search-box{border-width:1px;border-radius:8px;animation:searchin .18s ease;}
.search-esc{border-radius:3px;}
.admin-main{padding-left:1.5rem;padding-right:1.5rem;}

/* alerts */
.alert{border-radius:4px;border-left-width:3px;font-size:.85rem;font-weight:600;}
.alert-success{background:var(--teal-soft);color:var(--teal);border-color:#b9d0c0;}
.alert-warning{background:var(--amber-soft);color:#7a5410;border-color:#e4cd97;}
.alert-error{border-color:#ddb9bd;}

/* shared status badges for cake components (use on the components index/forms) */
.st{display:inline-flex;align-items:center;gap:.35rem;padding:.18rem .55rem;border-radius:3px;font-size:.66rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;border:1px solid;}
.st::before{content:'';width:5px;height:5px;border-radius:50%;background:currentcolor;}
.st-draft{background:var(--cream);color:#6f6052;border-color:var(--beige);}
.st-soon{background:var(--amber-soft);color:#7a5410;border-color:#e4cd97;}
.st-active{background:var(--teal-soft);color:var(--teal);border-color:#b9d0c0;}
.st-inactive{background:var(--rose-soft);color:var(--rose);border-color:#ddb9bd;}

/* tablet: compact icon sidebar */
@media(min-width:901px) and (max-width:1180px){
  :root{--sidebar-w:72px;}
  .brand-text,.user-info,.user-logout span,.nav-item .label{display:none;}
  .sidebar-brand{padding:1.2rem 0;display:flex;justify-content:center;}
  .nav-label{font-size:0;padding:0;}.nav-label::after{display:block;}
  .nav-item{justify-content:center;padding:.7rem 0;}
  .nav-badge{position:absolute;top:2px;right:6px;font-size:.55rem;padding:.05rem .3rem;}
  .sidebar-user{flex-direction:column;padding:.8rem 0;}
}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important;}}
</style>
<style>
/* ===== BakeSphere admin header (shared) ===== */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
:root{
  --ah-pad:1.5rem;
  --ah-espresso:#24150F;--ah-choc:#3A241A;--ah-ivory:#F7F2E9;--ah-cream:#EFE6D7;
  --ah-gold:#B89452;--ah-caramel:#A96F42;--ah-beige:#D8C8B7;--ah-taupe:#9A897A;
  --ah-burgundy:#54252C;--ah-sage:#5E7560;
}
@media(max-width:600px){:root{--ah-pad:.75rem}}

.ah-page{padding:var(--ah-pad) var(--ah-pad) 4rem!important;max-width:none!important;box-sizing:border-box}
.ah-hero,.ah-ledger{font-family:'Plus Jakarta Sans',system-ui,sans-serif;font-variant-numeric:tabular-nums}
.ah-hero *,.ah-ledger *{box-sizing:border-box;font-family:inherit}
.ah-ic{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}

/* hero */
.ah-hero{position:relative;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;
  padding:2rem 2rem 4.25rem;border-radius:4px 4px 0 0;color:var(--ah-ivory);
  background:repeating-linear-gradient(135deg,rgba(184,148,82,.05) 0 1px,transparent 1px 14px),linear-gradient(120deg,var(--ah-espresso),var(--ah-choc));
  border-bottom:1px solid var(--ah-gold);
  box-shadow:inset 0 0 0 5px var(--ah-espresso),inset 0 0 0 6px rgba(184,148,82,.45)}
.ah-hero-main{display:flex;align-items:center;gap:1.1rem}
.ah-hero-mark{width:52px;height:52px;display:grid;place-items:center;flex-shrink:0;border:1px solid var(--ah-gold);color:var(--ah-gold);border-radius:2px;background:rgba(184,148,82,.08)}
.ah-hero-mark .ah-ic{width:24px;height:24px}
.ah-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--ah-gold);margin-bottom:.35rem}
.ah-title{margin:0;font-size:2rem;font-weight:800;letter-spacing:-.02em;line-height:1.1;color:var(--ah-ivory)}
.ah-subtitle{margin:.4rem 0 0;font-size:.9rem;color:var(--ah-beige);max-width:60ch}
.ah-side{display:flex;flex-direction:column;gap:.2rem;text-align:right;padding-left:1.25rem;border-left:1px solid rgba(184,148,82,.5)}
.ah-side-label{display:inline-flex;align-items:center;justify-content:flex-end;gap:.45rem;font-size:.68rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--ah-gold)}
.ah-side-value{font-size:.82rem;font-weight:500;letter-spacing:.04em;color:var(--ah-beige)}
.ah-dot{width:6px;height:6px;border-radius:50%;background:var(--ah-gold);box-shadow:0 0 0 3px rgba(184,148,82,.22)}
.ah-side--actions{flex-direction:row;flex-wrap:wrap;align-items:center;gap:.6rem;border-left:none;padding-left:0;text-align:left}

/* stats strip */
.ah-ledger{position:relative;z-index:1;display:grid;grid-template-columns:repeat(var(--cols,4),1fr);
  margin:-2.5rem 1.25rem 2rem;background:#fff;border:1px solid var(--ah-beige);border-top:2px solid var(--ah-gold);border-radius:3px;
  box-shadow:0 22px 40px -28px rgba(36,21,15,.55)}
.ah-top .ah-ledger{margin-bottom:0}
.ah-fig{position:relative;padding:1.35rem 1.5rem 1.4rem;min-width:0}
.ah-fig+.ah-fig{border-left:1px solid var(--ah-cream)}
.ah-fig::before{content:'';position:absolute;left:1.5rem;top:0;width:28px;height:3px;background:var(--ah-accent,var(--ah-gold))}
.ah-fig--sage{--ah-accent:var(--ah-sage)}.ah-fig--burgundy{--ah-accent:var(--ah-burgundy)}
.ah-fig--caramel{--ah-accent:var(--ah-caramel)}.ah-fig--taupe{--ah-accent:var(--ah-taupe)}
.ah-fig-lbl{margin-top:.35rem;font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--ah-taupe)}
.ah-fig-val{margin-top:.55rem;font-size:1.6rem;font-weight:800;letter-spacing:-.02em;line-height:1.1;color:var(--ah-espresso);overflow-wrap:anywhere}
.ah-fig-note{margin-top:.4rem;font-size:.72rem;color:var(--ah-taupe)}
@media(min-width:993px){
  .ah-ledger--3x2 .ah-fig:nth-child(3n+1){border-left:none}
  .ah-ledger--3x2 .ah-fig:nth-child(n+4){border-top:1px solid var(--ah-cream)}
}
@media(max-width:992px){
  .ah-ledger{grid-template-columns:repeat(2,1fr)}
  .ah-fig+.ah-fig{border-left:none}
  .ah-fig:nth-child(even){border-left:1px solid var(--ah-cream)}
  .ah-fig:nth-child(n+3){border-top:1px solid var(--ah-cream)}
  .ah-fig:last-child:nth-child(odd){grid-column:1/-1}
}
@media(max-width:600px){
  .ah-hero{padding:1.5rem 1.25rem 3.75rem}
  .ah-title{font-size:1.5rem}
  .ah-side{text-align:left;padding-left:0;border-left:none}
  .ah-side-label{justify-content:flex-start}
  .ah-ledger{margin:-2.25rem .5rem 1.5rem}
  .ah-fig{padding:1.1rem 1rem}.ah-fig::before{left:1rem}
  .ah-fig-val{font-size:1.15rem}
}

/* resets for old inner wrappers so side padding matches everywhere */
.ah-page .es-tabs{padding:0!important;background:transparent!important;margin-bottom:1.5rem}
.ah-page .es-body{padding:0!important}
.ah-page .sr-body,.ah-page .rx-body{padding:0!important;max-width:none!important;margin:0!important}
.ah-page .cr-registry{margin:0!important}
.ah-page .cr-controls{padding:1rem 1.25rem!important;border:1px solid #D8C8B7;margin-bottom:1.5rem}
.ah-top{margin-bottom:1.5rem}
.db .ah-top{margin-bottom:0}
.ah-page .pg,.ah-page .bs-body{padding:0!important;max-width:none!important;margin:0!important}
.ah-page .table-card{margin-top:0!important}
</style>
@stack('styles')
    </head>
    <body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21H4a1 1 0 0 1-1-1v-1a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v1a1 1 0 0 1-1 1z"/><path d="M12 3c0 0-2 1-2 3h4c0-2-2-3-2-3z"/><path d="M8 15V9a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6"/><line x1="9" y1="12" x2="15" y2="12"/></svg>
                </div>
                <div class="brand-text">
                    <div class="brand-name">BakeSphere</div>
                    <div class="brand-sub">Operations Console</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-group">
                <span class="nav-label">Overview</span>
                <a href="{{ route('dashboard') }}"
                class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    <span class="label">Dashboard</span>
                </a>
            </div>

            <div class="nav-group">
                <span class="nav-label">Operations</span>
          <a href="{{ route('ingredients.index') }}"
                class="nav-item {{ request()->routeIs('ingredients.*') || request()->routeIs('products.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    <span class="label">Cake Components</span>
                </a>
   <a href="{{ route('admin.wallet.index') }}"
                   class="nav-item {{ request()->routeIs('admin.wallet.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    <span class="label">Wallets</span>
                    @php $pendingCashins = \App\Models\CashInRequest::where('status','pending')->count(); @endphp
                    @if($pendingCashins > 0)
                        <span class="nav-badge">{{ $pendingCashins }}</span>
                    @endif
                </a>
<a href="{{ route('admin.escrow.index') }}"
                   class="nav-item {{ request()->routeIs('admin.escrow.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span class="label">Escrow</span>
                </a>

                <a href="{{ route('admin.transactions.index') }}"
                   class="nav-item {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    <span class="label">Transactions</span>
                </a>
            </div>

            <div class="nav-group">
                <span class="nav-label">People</span>
                <a href="{{ route('bakers.index') }}"
                class="nav-item {{ request()->routeIs('bakers.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span class="label">Bakers</span>
                </a>
                <a href="{{ route('customers.index') }}"
                class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="label">Customers</span>
                </a>
            </div>

            <div class="nav-group">
                <span class="nav-label">Analytics</span>
                <a href="{{ route('reports.index') }}"
                class="nav-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span class="label">Sales Reports</span>
                </a>
                <a href="{{ route('admin.reports.index') }}"
                class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span class="label">User Reports</span>
                    @php $pendingReports = \App\Models\Report::where('status','pending_review')->count(); @endphp
                    @if($pendingReports > 0)
                        <span class="nav-badge rose">{{ $pendingReports }}</span>
                    @endif
                </a>
            
            </div>

           

        </nav>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->first_name ?? 'A', 0, 1) . substr(Auth::user()->last_name ?? '', 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ (Auth::user()->first_name ?? '') . ' ' . (Auth::user()->last_name ?? '') }}</div>
                <div class="user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
             <!-- AFTER -->
<button type="submit" class="user-logout" title="Sign out">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    <span>Logout</span>
</button>
            </form>
        </div>
    </aside>

    <!-- ── TOPBAR ── -->
    <div class="admin-topbar">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        <div class="topbar-breadcrumb">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="crumb-brand">BakeSphere</span>
            <span class="sep">/</span>
            <span class="crumb-mid">Administration</span>
            <span class="sep">/</span>
            <span class="current">@yield('title', 'Dashboard')</span>
        </div>

        <div class="topbar-right">
            <div class="topbar-date" id="topbarDate"></div>

            <div class="notif-wrap">
                <button class="topbar-btn" id="notifBtn" onclick="toggleNotif(event)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="notif-dot" id="notifDot"></span>
                </button>
                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-header">
                        Notifications
                        <span class="notif-mark" onclick="markAllRead()">Mark all read</span>
                    </div>
                    <div class="notif-item-drop unread" onclick="markRead(this)">
                        <div class="notif-indicator"></div>
                        <div><div class="notif-text">New baker application received</div><div class="notif-time">2 hours ago</div></div>
                    </div>
                    <div class="notif-item-drop unread" onclick="markRead(this)">
                        <div class="notif-indicator"></div>
                        <div><div class="notif-text">New user report submitted</div><div class="notif-time">4 hours ago</div></div>
                    </div>
                </div>
            </div>

            <button class="topbar-btn" onclick="openSearch()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
        </div>
    </div>

    <!-- ── SEARCH ── -->
    <div class="search-overlay" id="searchOverlay" onclick="closeSearch(event)">
        <div class="search-box" onclick="event.stopPropagation()">
            <div class="search-input-row">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="search-global-input" id="globalInput" placeholder="Search ingredients, orders, customers…">
                <span class="search-esc" onclick="closeSearch()">ESC</span>
            </div>
            <div id="searchResults" class="search-empty">Start typing to search across your bakery data</div>
        </div>
    </div>

    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success"><svg width="15" height="15" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{{ session('success') }}</span></div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><svg width="15" height="15" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg><span>{{ session('error') }}</span></div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning"><svg width="15" height="15" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m10.29 3.86l1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3l13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg><span>{{ session('warning') }}</span></div>
        @endif
        @if($errors->any())
            <div class="alert alert-error"><svg width="15" height="15" viewbox="0 0 24 24" fill="none" stroke="currentcolor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg><span>{{ $errors->first() }}</span></div>
        @endif

        @yield('content')
    </main>

    <script>
    function toggleSidebar() {
        document.getElementById('adminSidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('adminSidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
    (function tick() {
        const el = document.getElementById('topbarDate');
        if (el) {
            const d = new Date();
            el.textContent = d.toLocaleDateString('en-PH', { weekday:'short', month:'short', day:'numeric' })
                + '  ·  ' + d.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit' });
        }
        setTimeout(tick, 1000);
    })();
    function toggleNotif(e) {
        e.stopPropagation();
        document.getElementById('notifDropdown').classList.toggle('open');
    }
    function markRead(el) {
        el.classList.remove('unread');
        el.querySelector('.notif-indicator').style.background = 'var(--border-md)';
    }
    function markAllRead() {
        document.querySelectorAll('.notif-item-drop.unread').forEach(el => {
            el.classList.remove('unread');
            el.querySelector('.notif-indicator').style.background = 'var(--border-md)';
        });
    }
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('notifDropdown');
        const btn = document.getElementById('notifBtn');
        if (dd && !dd.contains(e.target) && btn && !btn.contains(e.target)) dd.classList.remove('open');
    });
    function openSearch() {
        document.getElementById('searchOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('globalInput').focus(), 80);
    }
    function closeSearch(e) {
        if (!e || e.target === document.getElementById('searchOverlay')) {
            document.getElementById('searchOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
    }
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
        if (e.key === 'Escape') {
            closeSearch();
            document.getElementById('notifDropdown')?.classList.remove('open');
        }
    });
    </script>
    @stack('scripts')
    </body>
    </html>