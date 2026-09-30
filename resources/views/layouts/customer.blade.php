<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BakeSphere — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
      *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --cream: #FAF7F2;
    --warm-white: #FFFDF9;
    --brown-deep: #2C1A0E;
    --brown-mid: #5C3D2E;
    --brown-light: #8B6347;
    --caramel: #C8894A;
    --caramel-light: #E8B07A;
    --dusty-rose: #D4896A;
    --sage: #7A9E7E;
    --text-dark: #1A0F08;
    --text-mid: #4A3728;
    --text-muted: #9B8070;
    --border: #E8DDD4;
    --shadow: 0 4px 24px rgba(44,26,14,0.08);
    --shadow-lg: 0 12px 48px rgba(44,26,14,0.15);
}
html { overflow-x: hidden; }
body { min-height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--cream); color: var(--text-dark); }
*, *::before, *::after { font-family: 'Plus Jakarta Sans', sans-serif; }
.sidebar { position:fixed; top:0; left:0; width:260px; height:100vh; background:var(--brown-deep); display:flex; flex-direction:column; z-index:100; overflow:hidden; transition: transform 0.3s ease; }
.sidebar::before { content:''; position:absolute; top:-80px; right:-80px; width:220px; height:220px; background:var(--caramel); border-radius:50%; opacity:0.08; }
.sidebar-brand { padding:1.75rem 1.5rem 1.5rem; border-bottom:1px solid rgba(255,255,255,0.07); flex-shrink:0; }
.brand-logo { display:flex; align-items:center; gap:0.875rem; }
.brand-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg, var(--caramel), var(--brown-light)); display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; box-shadow:0 2px 12px rgba(200,137,74,0.35); }
.brand-text { flex:1; min-width:0; }
.brand-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size:1.2rem; font-weight:700; color:var(--caramel-light); letter-spacing:0.01em; line-height:1.2; }
.brand-sub { font-size:0.68rem; font-weight:500; color:rgba(255,255,255,0.35); letter-spacing:0.14em; text-transform:uppercase; margin-top:3px; }
.sidebar-nav { flex:1; padding:1.5rem 0.75rem; overflow-y:auto; }
.nav-section-label { font-size:0.65rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(255,255,255,0.25); padding:0 1rem; margin:1.25rem 0 0.5rem; }
.nav-link { display:flex; align-items:center; gap:0.55rem; padding:0.7rem 0.9rem; border-radius:10px; color:rgba(255,255,255,0.6); text-decoration:none; font-size:0.875rem; font-weight:500; transition:all 0.2s; margin-bottom:0.15rem; font-family: 'Plus Jakarta Sans', sans-serif; }
.nav-link:hover { background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.95); }
.nav-link.active { background:var(--caramel); color:white; box-shadow:0 4px 16px rgba(200,137,74,0.35); }
.nav-link .icon { width:16px; text-align:left; font-size:1rem; flex-shrink:0; }
.sidebar-user { padding:1.25rem 1.75rem; border-top:1px solid rgba(255,255,255,0.07); display:flex; align-items:center; gap:0.85rem; }
.user-avatar { width:38px; height:38px; border-radius:50%; background:var(--caramel); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.875rem; color:white; flex-shrink:0; overflow:hidden; }
.user-avatar img { width:100%; height:100%; object-fit:cover; }
.user-info { flex:1; min-width:0; }
.user-name { font-size:0.8rem; font-weight:600; color:rgba(255,255,255,0.9); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-family: 'Plus Jakarta Sans', sans-serif; }
.user-role { font-size:0.68rem; color:rgba(255,255,255,0.35); margin-top:0.1rem; font-family: 'Plus Jakarta Sans', sans-serif; }
.logout-btn { background: rgba(180,56,64,0.12); border: 1px solid rgba(180,56,64,0.25); color: #FFAAB0; cursor: pointer; padding: 0.35rem 0.65rem; border-radius: 8px; transition: all 0.2s; display: flex; align-items: center; gap: 0.35rem; font-size: 0.7rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap; }
.logout-btn:hover { background: rgba(180,56,64,0.28); border-color: rgba(180,56,64,0.5); color: #FFD0D3; }
.main { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
.topbar { background: var(--warm-white); border-bottom: 1px solid var(--border); padding: 1rem 2.5rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; gap: 1rem; }
.topbar-breadcrumb { font-size:0.8rem; color:var(--text-muted); flex: 1; font-family: 'Plus Jakarta Sans', sans-serif; }
.topbar-breadcrumb span { color:var(--text-dark); font-weight:600; }
.topbar-right { display:flex; align-items:center; gap:1rem; }
.topbar-greeting { font-size:0.82rem; color:var(--text-muted); font-family: 'Plus Jakarta Sans', sans-serif; }
.topbar-greeting strong { color:var(--brown-mid); }
.notif-bell { position:relative; width:36px; height:36px; border-radius:10px; background:var(--cream); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; text-decoration:none; transition:all 0.2s; font-size:1rem; }
.notif-bell:hover { background:var(--border); }
.notif-badge { position:absolute; top:-5px; right:-5px; min-width:18px; height:18px; background:#E05252; color:white; border-radius:10px; font-size:0.6rem; font-weight:700; display:none; align-items:center; justify-content:center; padding:0 4px; border:2px solid var(--warm-white); }
.notif-badge.visible { display:flex; }
.page-content { flex:1; padding:1.8rem; min-width:0; }
.alert { padding:0.875rem 1.25rem; border-radius:10px; margin-bottom:1.5rem; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem; font-family: 'Plus Jakarta Sans', sans-serif; }
.alert-success { background:#EDF7EE; color:#2D6A30; border:1px solid #C3E6C5; }
.alert-error   { background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
.mobile-menu-btn { display: none; }
.sidebar-overlay { position: fixed; inset: 0; z-index: 99; background: rgba(44,26,14,0.5); backdrop-filter: blur(2px); opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
.sidebar-overlay.visible { opacity: 1; pointer-events: auto; }
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0 !important; }
    .topbar { padding: 0.85rem 1rem; }
    .topbar-greeting { display: none; }
    .page-content { padding: 1rem; }
    .mobile-menu-btn { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; background: var(--cream); border: 1px solid var(--border); cursor: pointer; font-size: 1.1rem; flex-shrink: 0; }
}
@media (min-width: 769px) {
    .mobile-menu-btn { display: none !important; }
    .sidebar-overlay { display: none !important; }
}
  /* ═════ CUSTOMER SHELL: luxury patisserie frame ═════ */
body{background:linear-gradient(180deg,#F7F2E9 0%,#F4EEE3 100%) fixed;color:#1A0F08}
.main{min-width:0}

/* SIDEBAR */
.sidebar{
  background:
    repeating-linear-gradient(45deg,rgba(247,242,233,.012) 0 1px,transparent 1px 8px),
    radial-gradient(ellipse 130% 38% at 0% 0%,rgba(184,148,82,.11),transparent 62%),
    linear-gradient(180deg,#2B1A12 0%,#24150F 50%,#1B0F09 100%);
  border-right:1px solid rgba(184,148,82,.2);
}
.sidebar::before{display:none}

/* branding */
.sidebar-brand{padding:1.9rem 1.5rem 1.6rem;border-bottom:0;position:relative}
.sidebar-brand::after{content:'';position:absolute;left:1.5rem;right:1.5rem;bottom:0;height:1px;background:linear-gradient(90deg,#B89452,rgba(184,148,82,.08))}
.brand-logo{gap:1rem}
.brand-icon{width:46px;height:46px;border-radius:2px;color:#D8BA78;
  background:linear-gradient(145deg,rgba(184,148,82,.2),rgba(184,148,82,.03));
  border:1px solid rgba(184,148,82,.6);
  box-shadow:inset 0 0 0 3px #24150F,inset 0 0 0 4px rgba(184,148,82,.28),0 6px 18px rgba(0,0,0,.28)}
.brand-name{font-size:1.18rem;font-weight:600;letter-spacing:.015em;color:#F7F2E9;line-height:1.1}
.brand-sub{font-size:.56rem;font-weight:700;letter-spacing:.36em;color:#B89452;margin-top:6px}

/* navigation */
.sidebar-nav{padding:1.1rem 1rem 1.25rem;scrollbar-width:thin;scrollbar-color:rgba(184,148,82,.3) transparent}
.nav-section-label{font-size:.58rem;font-weight:700;letter-spacing:.34em;color:rgba(184,148,82,.78);padding:0 .9rem;margin:1.6rem 0 .6rem}
.nav-section-label:first-child{margin-top:.5rem}
.nav-link{position:relative;gap:.85rem;padding:.72rem .9rem;margin-bottom:.1rem;border-radius:2px;border-left:2px solid transparent;
  font-size:.84rem;font-weight:500;letter-spacing:.01em;color:rgba(247,242,233,.62);
  transition:background .3s,color .3s,border-color .3s}
.nav-link svg{width:17px;height:17px;flex-shrink:0;stroke-width:1.5;opacity:.85;transition:stroke .3s,opacity .3s}
.nav-link:hover{background:rgba(247,242,233,.045);color:#F7F2E9;border-left-color:rgba(184,148,82,.45)}
.nav-link:hover svg{stroke:#D8BA78;opacity:1}
.nav-link.active{
  background:linear-gradient(90deg,rgba(184,148,82,.2),rgba(184,148,82,.03) 85%);
  border-left-color:#B89452;color:#F7F2E9;font-weight:600;
  box-shadow:inset 14px 0 26px -16px rgba(216,186,120,.4);
}
.nav-link.active svg{stroke:#D8BA78;opacity:1}

/* wallet amount: integrated gold figure, not a badge */
.nav-link > span[style*="rgba(200,137,74,0.25)"]{
  background:none!important;border-radius:0!important;padding:0 0 0 .7rem!important;
  border-left:1px solid rgba(184,148,82,.4);color:#D8BA78!important;
  font-size:.76rem!important;font-weight:600!important;letter-spacing:.04em;font-variant-numeric:tabular-nums}
/* notification count in sidebar */
.nav-link > span[style*="margin-left:auto"]{
  background:#B89452!important;color:#24150F!important;border-radius:2px!important;
  font-size:.62rem!important;font-weight:800!important;padding:.15rem .45rem!important;letter-spacing:.04em}

/* user area */
.sidebar-user{padding:1.3rem 1.1rem;gap:.65rem;border-top:1px solid rgba(184,148,82,.28);background:rgba(0,0,0,.16)}
.user-avatar{width:40px;height:40px;background:#3A241A;border:1px solid #B89452;box-shadow:0 0 0 3px rgba(184,148,82,.12);color:#D8BA78;font-weight:600}
.sidebar-user form{flex-shrink:0}
.user-name{font-size:.82rem;font-weight:600;color:#F7F2E9;letter-spacing:.01em}
.user-role{font-size:.54rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:#9A897A;margin-top:.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.logout-btn{background:transparent;border:1px solid rgba(247,242,233,.16);color:rgba(247,242,233,.6);border-radius:2px;
  padding:.4rem .55rem;font-size:.54rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;transition:all .3s}
.logout-btn:hover{background:transparent;border-color:#B89452;color:#D8BA78}

/* TOPBAR */
.topbar{background:rgba(247,242,233,.9);-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);
  border-bottom:1px solid rgba(36,21,15,.1);padding:1.2rem clamp(1.25rem,3.5vw,3rem)}
.topbar::after{content:'';position:absolute;left:clamp(1.25rem,3.5vw,3rem);bottom:-1px;width:56px;height:1px;background:#B89452}
.topbar-breadcrumb{font-size:.64rem;font-weight:600;letter-spacing:.24em;text-transform:uppercase;color:#9A897A}
.topbar-breadcrumb span{color:#24150F;font-weight:800}
.topbar-right{gap:1.5rem}
.topbar-greeting{font-size:.8rem;color:#9A897A;letter-spacing:.01em}
.topbar-greeting strong{color:#24150F;font-weight:700}
.notif-bell{width:40px;height:40px;border-radius:2px;background:transparent;border:1px solid rgba(36,21,15,.16);color:#24150F;transition:all .3s}
.notif-bell:hover{background:transparent;border-color:#B89452;color:#8F6F35}
.notif-badge{top:-7px;right:-7px;background:#54252C;color:#F7F2E9;border-radius:2px;border:2px solid #F7F2E9;font-size:.58rem;font-weight:800}
.mobile-menu-btn{width:40px;height:40px;border-radius:2px;background:transparent;border:1px solid rgba(36,21,15,.16);color:#24150F}

/* PAGE CONTENT */
.page-content{padding:clamp(1.5rem,3vw,2.5rem) clamp(1.25rem,3.5vw,3rem) 4rem}

/* ALERTS */
.alert{border-radius:2px;padding:.95rem 1.25rem;font-size:.82rem;font-weight:500;gap:.7rem;border:0;border-left:2px solid}
.alert svg{flex-shrink:0}
.alert-success{background:#EFF2E8;color:#33502F;border-left-color:#5E7F5A}
.alert-error{background:#F6ECEA;color:#54252C;border-left-color:#54252C}

/* MOBILE */
.sidebar-overlay{background:rgba(24,12,7,.66);-webkit-backdrop-filter:blur(3px);backdrop-filter:blur(3px)}
@media (max-width:768px){
  .sidebar{width:min(84vw,300px);box-shadow:26px 0 70px rgba(0,0,0,.4)}
  .topbar{padding:.85rem 1rem}
  .topbar::after{left:1rem}
  .topbar-breadcrumb{font-size:.58rem;letter-spacing:.18em}
  .page-content{padding:1.25rem 1rem 3rem}
}
@media (prefers-reduced-motion:reduce){
  .nav-link,.nav-link svg,.logout-btn,.notif-bell{transition:none}
}
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
<div class="sidebar-brand">
    <div class="brand-logo">
<div class="brand-icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 11H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/>
        <path d="M12 11V7"/>
        <path d="M8 11V8"/>
        <path d="M16 11V8"/>
        <path d="M9 7a3 3 0 0 1 6 0"/>
        <path d="M6 8a2 2 0 0 0 0 3"/>
        <path d="M18 8a2 2 0 0 1 0 3"/>
    </svg>
</div>
        <div class="brand-text">
            <div class="brand-name">BakeSphere</div>
            <div class="brand-sub">Customer Portal</div>
        </div>
    </div>
</div>
    <nav class="sidebar-nav">
   <div class="nav-section-label">Overview</div>
            <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
      <div class="nav-section-label">Orders</div>
<a href="{{ route('customer.cake-builder.index') }}" class="nav-link {{ request()->routeIs('customer.cake-builder.index') ? 'active' : '' }}">
         <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>3D Cake Customization
        </a>
<a href="{{ route('customer.cake-gallery.index') }}" class="nav-link {{ request()->routeIs('customer.cake-gallery*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Cake Gallery
        </a>
        <a href="{{ route('customer.cake-builder.drafts') }}" class="nav-link {{ request()->routeIs('customer.cake-builder.drafts*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>Save Draft
        </a>
<a href="{{ route('customer.cake-requests.index') }}" class="nav-link {{ request()->routeIs('customer.cake-requests*') ? 'active' : '' }}">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>My Orders
</a>
        <div class="nav-section-label">Finance</div>
        @php $customerWalletBalance = \App\Models\Wallet::forUser(auth()->id())->balance; @endphp
        <a href="{{ route('customer.wallet.index') }}" class="nav-link {{ request()->routeIs('customer.wallet*') ? 'active' : '' }}">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            <span style="flex:1;">My Wallet</span>
            <span style="background:rgba(200,137,74,0.25); color:var(--caramel-light); font-size:0.65rem; font-weight:700; padding:0.1rem 0.5rem; border-radius:8px; white-space:nowrap;">
                ₱{{ number_format($customerWalletBalance, 0) }}
            </span>
        </a>
        <div class="nav-section-label">Account</div>
        <a href="{{ route('customer.profile.index') }}" class="nav-link {{ request()->routeIs('customer.profile.index') ? 'active' : '' }}">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Profile
        </a>
        <a href="{{ route('customer.notifications.index') }}" class="nav-link {{ request()->routeIs('customer.notifications*') ? 'active' : '' }}">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg> Notifications
            @php $unread = auth()->user()->unread_notifications_count; @endphp
            @if($unread > 0)
            <span style="margin-left:auto; background:var(--caramel); color:white; font-size:0.65rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:10px;">{{ $unread }}</span>
            @endif
        </a>
    </nav>
    <div class="sidebar-user">
        <div class="user-avatar">
            @php
                $__photo = auth()->user()->profile_photo;
                $__isRemoteUrl = $__photo && preg_match('#^https?://#i', $__photo);
                $__avatarSrc = $__photo
                    ? ($__isRemoteUrl ? $__photo : asset('storage/' . $__photo))
                    : null;
            @endphp
            @if($__avatarSrc)
                <img src="{{ $__avatarSrc }}" alt="Avatar" referrerpolicy="no-referrer">
            @else
                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
            @endif
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="user-role">Customer</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
     <button type="submit" class="logout-btn" title="Logout">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
    </svg>
    <span>Logout</span>
</button>
        </form>
    </div>
</aside>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>
<div class="main">
    <header class="topbar">
  <button class="mobile-menu-btn" id="mobile-menu-btn">☰</button>
        <div class="topbar-breadcrumb">
            Portal / <span>@yield('title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }},
                <strong>{{ auth()->user()->first_name }}</strong>!
            </div>
            <a href="{{ route('customer.notifications.index') }}" class="notif-bell" id="notif-bell">
                🔔
                <span class="notif-badge {{ auth()->user()->unread_notifications_count > 0 ? 'visible' : '' }}" id="notif-count">
                    {{ auth()->user()->unread_notifications_count > 0 ? auth()->user()->unread_notifications_count : '' }}
                </span>
            </a>
        </div>
    </header>
    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✕ {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                ✕ {{ $errors->first() }}
            </div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
<script>
function updateNotifCount() {
    fetch('{{ route("customer.notifications.unread-count") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        const badge = document.getElementById('notif-count');
        if (data.count > 0) {
            badge.textContent = data.count;
            badge.classList.add('visible');
        } else {
            badge.textContent = '';
            badge.classList.remove('visible');
        }
    }).catch(() => {});
}
function openSidebar() {
    document.querySelector('.sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('visible');
}
function closeSidebar() {
    document.querySelector('.sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('visible');
}
document.getElementById('mobile-menu-btn')?.addEventListener('click', openSidebar);
document.getElementById('sidebar-overlay')?.addEventListener('click', closeSidebar);
setInterval(updateNotifCount, 30000);
</script>
</body>
</html>