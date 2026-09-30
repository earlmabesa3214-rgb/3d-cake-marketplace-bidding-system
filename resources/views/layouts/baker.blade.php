<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BakeSphere — @yield('title', 'Baker Portal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    /* legacy tokens, kept so existing baker pages keep resolving them */
    --cream: #F7F2E9;
    --warm-white: #FBF8F2;
    --brown-deep: #24150F;
    --brown-mid: #3A241A;
    --brown-light: #7A5E4C;
    --caramel: #A96F42;
    --caramel-light: #D4B06A;
    --dusty-rose: #D4896A;
    --sage: #7A9E7E;
    --text-dark: #1A0F08;
    --text-mid: #4A3728;
    --text-muted: #9A897A;
    --border: #D8C8B7;
    --shadow: 0 4px 24px rgba(36,21,15,0.08);
    --shadow-lg: 0 12px 48px rgba(36,21,15,0.15);

    /* luxury palette */
    --esp: #24150F;
    --ivory: #F7F2E9;
    --gold: #B89452;
    --gold-l: #D8BA78;
    --burg: #54252C;
    --taupe: #9A897A;
}

html { overflow-x: hidden; }
html, body { min-height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); }
body { background: linear-gradient(180deg, #F7F2E9 0%, #F4EEE3 100%) fixed; }
*, *::before, *::after { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ═════ SIDEBAR ═════ */
.sidebar {
    position: fixed; top: 0; left: 0; width: 260px; height: 100vh; z-index: 100;
    display: flex; flex-direction: column; overflow: hidden;
    background:
        repeating-linear-gradient(45deg, rgba(247,242,233,.012) 0 1px, transparent 1px 8px),
        radial-gradient(ellipse 130% 38% at 0% 0%, rgba(184,148,82,.11), transparent 62%),
        linear-gradient(180deg, #2B1A12 0%, #24150F 50%, #1B0F09 100%);
    border-right: 1px solid rgba(184,148,82,.2);
    transition: transform 0.3s ease;
}

.sidebar-brand { position: relative; flex-shrink: 0; padding: 1.9rem 1.5rem 1.6rem; }
.sidebar-brand::after { content: ''; position: absolute; left: 1.5rem; right: 1.5rem; bottom: 0; height: 1px; background: linear-gradient(90deg, #B89452, rgba(184,148,82,.08)); }
.brand-logo { display: flex; align-items: center; gap: 1rem; }
.brand-icon {
    width: 46px; height: 46px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: #D8BA78;
    border-radius: 2px;
    background: linear-gradient(145deg, rgba(184,148,82,.2), rgba(184,148,82,.03));
    border: 1px solid rgba(184,148,82,.6);
    box-shadow: inset 0 0 0 3px #24150F, inset 0 0 0 4px rgba(184,148,82,.28), 0 6px 18px rgba(0,0,0,.28);
}
.brand-text { flex: 1; min-width: 0; }
.brand-name { font-size: 1.18rem; font-weight: 600; letter-spacing: .015em; color: #F7F2E9; line-height: 1.1; }
.brand-sub { font-size: .56rem; font-weight: 700; letter-spacing: .36em; text-transform: uppercase; color: #B89452; margin-top: 6px; }

.sidebar-nav { flex: 1; padding: 1.1rem 1rem 1.25rem; overflow-y: auto; scrollbar-width: thin; scrollbar-color: rgba(184,148,82,.3) transparent; }
.nav-section-label { font-size: .58rem; font-weight: 700; letter-spacing: .34em; text-transform: uppercase; color: rgba(184,148,82,.78); padding: 0 .9rem; margin: 1.6rem 0 .6rem; }
.nav-section-label:first-child { margin-top: .5rem; }
.nav-link {
    position: relative; display: flex; align-items: center; gap: .85rem;
    padding: .72rem .9rem; margin-bottom: .1rem; border-radius: 2px; border-left: 2px solid transparent;
    font-size: .84rem; font-weight: 500; letter-spacing: .01em; color: rgba(247,242,233,.62); text-decoration: none;
    transition: background .3s, color .3s, border-color .3s;
}
.nav-link svg { width: 17px; height: 17px; flex-shrink: 0; stroke-width: 1.5; opacity: .85; transition: stroke .3s, opacity .3s; }
.nav-link .icon { display: flex; align-items: center; justify-content: center; width: 17px; flex-shrink: 0; }
.nav-link:hover { background: rgba(247,242,233,.045); color: #F7F2E9; border-left-color: rgba(184,148,82,.45); }
.nav-link:hover svg { stroke: #D8BA78; opacity: 1; }
.nav-link.active {
    background: linear-gradient(90deg, rgba(184,148,82,.2), rgba(184,148,82,.03) 85%);
    border-left-color: #B89452; color: #F7F2E9; font-weight: 600;
    box-shadow: inset 14px 0 26px -16px rgba(216,186,120,.4);
}
.nav-link.active svg { stroke: #D8BA78; opacity: 1; }
.nav-label { flex: 1; white-space: nowrap; }
.nav-amount { padding-left: .7rem; border-left: 1px solid rgba(184,148,82,.4); color: #D8BA78; font-size: .76rem; font-weight: 600; letter-spacing: .04em; font-variant-numeric: tabular-nums; white-space: nowrap; }
.nav-count { margin-left: auto; padding: .15rem .45rem; border-radius: 2px; background: #B89452; color: #24150F; font-size: .62rem; font-weight: 800; letter-spacing: .04em; }

.sidebar-user { display: flex; align-items: center; gap: .65rem; padding: 1.3rem 1.1rem; border-top: 1px solid rgba(184,148,82,.28); background: rgba(0,0,0,.16); }
.user-avatar { width: 40px; height: 40px; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #3A241A; border: 1px solid #B89452; box-shadow: 0 0 0 3px rgba(184,148,82,.12); color: #D8BA78; font-weight: 600; font-size: .875rem; }
.user-avatar img { width: 100%; height: 100%; object-fit: cover; }
.user-info { flex: 1; min-width: 0; }
.user-name { font-size: .82rem; font-weight: 600; color: #F7F2E9; letter-spacing: .01em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-role { margin-top: .25rem; font-size: .54rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: #9A897A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sidebar-user form { flex-shrink: 0; }
.logout-btn { display: flex; align-items: center; gap: .35rem; padding: .4rem .55rem; border-radius: 2px; background: transparent; border: 1px solid rgba(247,242,233,.16); color: rgba(247,242,233,.6); font-size: .54rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; white-space: nowrap; cursor: pointer; transition: all .3s; }
.logout-btn:hover { border-color: #B89452; color: #D8BA78; }

/* ═════ MAIN + TOPBAR ═════ */
.main { margin-left: 260px; min-width: 0; min-height: 100vh; display: flex; flex-direction: column; }
.topbar {
    position: sticky; top: 0; z-index: 50; display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    padding: 1.2rem clamp(1.25rem, 3.5vw, 3rem);
    background: rgba(247,242,233,.9); -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(36,21,15,.1);
}
.topbar::after { content: ''; position: absolute; left: clamp(1.25rem, 3.5vw, 3rem); bottom: -1px; width: 56px; height: 1px; background: #B89452; }
.topbar-breadcrumb { flex: 1; font-size: .64rem; font-weight: 600; letter-spacing: .24em; text-transform: uppercase; color: #9A897A; }
.topbar-breadcrumb span { color: #24150F; font-weight: 800; }
.topbar-right { display: flex; align-items: center; gap: 1.5rem; }
.topbar-greeting { font-size: .8rem; color: #9A897A; letter-spacing: .01em; }
.topbar-greeting strong { color: #24150F; font-weight: 700; }

.notif-bell { position: relative; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 2px; background: transparent; border: 1px solid rgba(36,21,15,.16); color: #24150F; text-decoration: none; cursor: pointer; transition: all .3s; }
.notif-bell:hover { border-color: #B89452; color: #8F6F35; }
.notif-badge { position: absolute; top: -7px; right: -7px; min-width: 18px; height: 18px; display: none; align-items: center; justify-content: center; padding: 0 4px; border-radius: 2px; background: #54252C; color: #F7F2E9; border: 2px solid #F7F2E9; font-size: .58rem; font-weight: 800; }
.notif-badge.visible { display: flex; }

.page-content { flex: 1; min-width: 0; overflow-x: hidden; padding: clamp(1.5rem, 3vw, 2.5rem) clamp(1.25rem, 3.5vw, 3rem) 4rem; }

/* ═════ ALERTS ═════ */
.alert { display: flex; align-items: center; gap: .7rem; padding: .95rem 1.25rem; margin-bottom: 1.5rem; border-radius: 2px; border: 0; border-left: 2px solid; font-size: .82rem; font-weight: 500; }
.alert svg { flex-shrink: 0; }
.alert-success { background: #EFF2E8; color: #33502F; border-left-color: #5E7F5A; }
.alert-error   { background: #F6ECEA; color: #54252C; border-left-color: #54252C; }
.alert-warning { background: #F3EAD3; color: #7A5A15; border-left-color: #B89452; }

/* ═════ MOBILE ═════ */
.mobile-menu-btn { display: none; }
.sidebar-overlay { position: fixed; inset: 0; z-index: 99; background: rgba(24,12,7,.66); -webkit-backdrop-filter: blur(3px); backdrop-filter: blur(3px); opacity: 0; pointer-events: none; transition: opacity .3s ease; }
.sidebar-overlay.visible { opacity: 1; pointer-events: auto; }
@media (max-width: 768px) {
    .sidebar { width: min(84vw, 300px); transform: translateX(-100%); box-shadow: 26px 0 70px rgba(0,0,0,.4); }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0 !important; }
    .topbar { padding: .85rem 1rem; }
    .topbar::after { left: 1rem; }
    .topbar-breadcrumb { font-size: .58rem; letter-spacing: .18em; }
    .topbar-greeting { display: none; }
    .page-content { padding: 1.25rem 1rem 3rem; }
    .mobile-menu-btn { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; flex-shrink: 0; border-radius: 2px; background: transparent; border: 1px solid rgba(36,21,15,.16); color: #24150F; cursor: pointer; }
}
@media (min-width: 769px) {
    .mobile-menu-btn { display: none !important; }
    .sidebar-overlay { display: none !important; }
}
@media (prefers-reduced-motion: reduce) {
    .nav-link, .nav-link svg, .logout-btn, .notif-bell, .sidebar, .sidebar-overlay { transition: none; }
}
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <div class="brand-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 17h12v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2z"/>
                    <path d="M6 17v-2.5C4 13.5 3 12 3 10a5 5 0 0 1 5-5 5 5 0 0 1 4 2 5 5 0 0 1 4-2 5 5 0 0 1 5 5c0 2-1 3.5-3 4.5V17"/>
                    <line x1="6" y1="15" x2="18" y2="15"/>
                </svg>
            </div>
            <div class="brand-text">
                <div class="brand-name">BakeSphere</div>
                <div class="brand-sub">Baker Portal</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="{{ route('baker.dashboard') }}" class="nav-link {{ request()->routeIs('baker.dashboard') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div class="nav-section-label">Work</div>
        <a href="{{ route('baker.requests.index') }}" class="nav-link {{ request()->routeIs('baker.requests*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/></svg>
            <span class="nav-label">Browse Cake Orders</span>
            @php $openCount = \App\Models\CakeRequest::where('status', 'OPEN')->count(); @endphp
            @if($openCount > 0)
            <span class="nav-count">{{ $openCount }}</span>
            @endif
        </a>
        <a href="{{ route('baker.bids.index') }}" class="nav-link {{ request()->routeIs('baker.bids*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            My Bids
        </a>
        <a href="{{ route('baker.orders.index') }}" class="nav-link {{ request()->routeIs('baker.orders*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            Active Orders
        </a>

        <div class="nav-section-label">Finance</div>
        @php $bakerWalletBalance = \App\Models\Wallet::forUser(auth()->id())->balance; @endphp
        <a href="{{ route('baker.wallet.index') }}" class="nav-link {{ request()->routeIs('baker.wallet*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M16 12h.01"/><path d="M2 10h20"/></svg>
            <span class="nav-label">Wallet</span>
            <span class="nav-amount">₱{{ number_format($bakerWalletBalance, 0) }}</span>
        </a>
        <a href="{{ route('baker.earnings.index') }}" class="nav-link {{ request()->routeIs('baker.earnings*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M8 9h5a3 3 0 0 1 0 6H8"/></svg>
            Earnings
        </a>

        <div class="nav-section-label">Account</div>
        <a href="{{ route('baker.profile.index') }}" class="nav-link {{ request()->routeIs('baker.profile*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profile
        </a>
        <a href="{{ route('baker.notifications.index') }}" class="nav-link {{ request()->routeIs('baker.notifications*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Notifications
            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
            @if($unread > 0)
            <span class="nav-count">{{ $unread }}</span>
            @endif
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">
            @if(auth()->user()->profile_photo)
                @php $photo = auth()->user()->profile_photo; @endphp
                <img src="{{ str_starts_with($photo, 'http') ? $photo : asset('storage/' . $photo) }}" alt="Avatar">
            @else
                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
            @endif
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="user-role">Baker</div>
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
        <button class="mobile-menu-btn" id="mobile-menu-btn" type="button" aria-label="Open menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="topbar-breadcrumb">
            Baker Portal / <span>@yield('title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }},
                <strong>{{ auth()->user()->first_name }}</strong>!
            </div>
            <a href="{{ route('baker.notifications.index') }}" class="notif-bell" id="notif-bell" aria-label="Notifications">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="notif-badge {{ auth()->user()->unreadNotifications->count() > 0 ? 'visible' : '' }}" id="notif-count">
                    {{ auth()->user()->unreadNotifications->count() > 0 ? auth()->user()->unreadNotifications->count() : '' }}
                </span>
            </a>
        </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/></svg>
                {{ session('warning') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
<script>
function updateNotifCount() {
    fetch('{{ route("baker.notifications.unread-count") }}', {
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
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
setInterval(updateNotifCount, 30000);
</script>
</body>
</html>