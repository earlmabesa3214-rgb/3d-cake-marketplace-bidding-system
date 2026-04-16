<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BakeSphere — @yield('title', 'Baker Portal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">




    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --cream: #FAF7F2;
    --warm-white: #FFFDF9;
--brown-deep: #3D2010;

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

html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--cream); color: var(--text-dark); }

/* ── SIDEBAR ── */
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
.nav-link { display:flex; align-items:center; gap:0.75rem; padding:0.7rem 1rem; border-radius:10px; color:rgba(255,255,255,0.6); text-decoration:none; font-size:0.875rem; font-weight:500; transition:all 0.2s; margin-bottom:0.15rem; }
.nav-link:hover { background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.95); }
.nav-link.active { background:var(--caramel); color:white; box-shadow:0 4px 16px rgba(200,137,74,0.35); }
.nav-link .icon { width:20px; text-align:center; font-size:1rem; }

.sidebar-user { padding:1.25rem 1.75rem; border-top:1px solid rgba(255,255,255,0.07); display:flex; align-items:center; gap:0.85rem; }
.user-avatar { width:38px; height:38px; border-radius:50%; background:var(--caramel); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.875rem; color:white; flex-shrink:0; overflow:hidden; }
.user-avatar img { width:100%; height:100%; object-fit:cover; }
.user-info { flex:1; min-width:0; }
.user-name { font-size:0.8rem; font-weight:600; color:rgba(255,255,255,0.9); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.user-role { font-size:0.68rem; color:rgba(255,255,255,0.35); margin-top:0.1rem; }

.logout-btn {
    background: rgba(180,56,64,0.12);
    border: 1px solid rgba(180,56,64,0.25);
    color: #FFAAB0;
    cursor: pointer;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.7rem;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
}
.logout-btn:hover {
    background: rgba(180,56,64,0.28);
    border-color: rgba(180,56,64,0.5);
    color: #FFD0D3;
}

/* ── MAIN ── */
.main { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }

/* ── TOPBAR ── */
.topbar {
    background: var(--warm-white);
    border-bottom: 1px solid var(--border);
    padding: 1rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 50;
    gap: 1rem;
}
.topbar-breadcrumb {
    font-size: 0.8rem;
    color: var(--text-muted);
    flex: 1;
}
.topbar-breadcrumb span { color: var(--text-dark); font-weight: 600; }
.topbar-right { display: flex; align-items: center; gap: 1rem; }
.topbar-greeting { font-size: 0.82rem; color: var(--text-muted); }
.topbar-greeting strong { color: var(--brown-mid); }



/* ── NOTIFICATION BELL ── */
.notif-bell { position:relative; width:36px; height:36px; border-radius:10px; background:var(--cream); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; cursor:pointer; text-decoration:none; transition:all 0.2s; font-size:1rem; }
.notif-bell:hover { background:var(--border); }
.notif-badge { position:absolute; top:-5px; right:-5px; min-width:18px; height:18px; background:#E05252; color:white; border-radius:10px; font-size:0.6rem; font-weight:700; display:none; align-items:center; justify-content:center; padding:0 4px; border:2px solid var(--warm-white); }
.notif-badge.visible { display:flex; }

/* ── PAGE CONTENT ── */
.page-content { flex:1; padding:2.5rem; min-width:0; overflow-x:hidden; }

/* ── ALERTS ── */
.alert { padding:0.875rem 1.25rem; border-radius:10px; margin-bottom:1.5rem; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem; }
.alert-success { background:#FEF6EC; color:#7A4A1E; border:1px solid #F0D4A8; }
.alert-error   { background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
.alert-warning { background:#FEF9E8; color:#9B7A10; border:1px solid #F0D4B0; }

/* ── MOBILE MENU BUTTON ── */
.mobile-menu-btn { display: none; }

/* ── SIDEBAR OVERLAY ── */
.sidebar-overlay {
    position: fixed;
    inset: 0;
    z-index: 99;
    background: rgba(44,26,14,0.5);
    backdrop-filter: blur(2px);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}
.sidebar-overlay.visible {
    opacity: 1;
    pointer-events: auto;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar.open {
        transform: translateX(0);
    }
    .main {
        margin-left: 0 !important;
    }
    .topbar {
        padding: 0.85rem 1rem;
    }
    .topbar-greeting {
        display: none;
    }
    .page-content {
        padding: 1rem;
    }
    .mobile-menu-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--cream);
        border: 1px solid var(--border);
        cursor: pointer;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
}
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
<!-- AFTER -->
<div class="sidebar-brand">
    <div class="brand-logo">
        <div class="brand-icon">👨‍🍳</div>
        <div class="brand-text">
            <div class="brand-name">BakeSphere</div>
            <div class="brand-sub">Baker Portal</div>
        </div>
    </div>
</div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="{{ route('baker.dashboard') }}" class="nav-link {{ request()->routeIs('baker.dashboard') ? 'active' : '' }}">
            <span class="icon">⊞</span> Dashboard
        </a>

        <div class="nav-section-label">Work</div>
      <a href="{{ route('baker.requests.index') }}" class="nav-link {{ request()->routeIs('baker.requests*') ? 'active' : '' }}">
            <span class="icon">🎂</span> <span style="white-space:nowrap;">Browse Cake Orders</span>
            @php $openCount = \App\Models\CakeRequest::where('status', 'OPEN')->count(); @endphp
            @if($openCount > 0)
            <span style="margin-left:auto; background:var(--caramel); color:white; font-size:0.65rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:10px;">{{ $openCount }}</span>
            @endif
        </a>
        <a href="{{ route('baker.bids.index') }}" class="nav-link {{ request()->routeIs('baker.bids*') ? 'active' : '' }}">
            <span class="icon">💼</span> My Bids
        </a>
        <a href="{{ route('baker.orders.index') }}" class="nav-link {{ request()->routeIs('baker.orders*') ? 'active' : '' }}">
            <span class="icon">📦</span> Active Orders
        </a>

   <div class="nav-section-label">Finance</div>
        @php $bakerWalletBalance = \App\Models\Wallet::forUser(auth()->id())->balance; @endphp
        <a href="{{ route('baker.wallet.index') }}" class="nav-link {{ request()->routeIs('baker.wallet*') ? 'active' : '' }}">
            <span class="icon">₱</span>
            <span style="flex:1;">Wallet</span>
            <span style="background:rgba(200,137,74,0.25); color:var(--caramel-light); font-size:0.65rem; font-weight:700; padding:0.1rem 0.5rem; border-radius:8px; white-space:nowrap;">
                ₱{{ number_format($bakerWalletBalance, 0) }}
            </span>
        </a>
        <a href="{{ route('baker.earnings.index') }}" class="nav-link {{ request()->routeIs('baker.earnings*') ? 'active' : '' }}">
            <span class="icon">💰</span> Earnings
        </a>

        <div class="nav-section-label">Account</div>
        <a href="{{ route('baker.profile.index') }}" class="nav-link {{ request()->routeIs('baker.profile*') ? 'active' : '' }}">
            <span class="icon">👤</span> Profile & Portfolio
        </a>
        <a href="{{ route('baker.notifications.index') }}" class="nav-link {{ request()->routeIs('baker.notifications*') ? 'active' : '' }}">
            <span class="icon">🔔</span> Notifications
            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
            @if($unread > 0)
            <span style="margin-left:auto; background:var(--caramel); color:white; font-size:0.65rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:10px;">{{ $unread }}</span>
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
    <button class="mobile-menu-btn" id="mobile-menu-btn">☰</button>
    <div class="topbar-breadcrumb">
        Baker Portal / <span>@yield('title', 'Dashboard')</span>
    </div>
    <div class="topbar-right">
        
            <div class="topbar-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }},
                <strong>{{ auth()->user()->first_name }}</strong>!
            </div>
            <a href="{{ route('baker.notifications.index') }}" class="notif-bell" id="notif-bell">
                🔔
                <span class="notif-badge {{ auth()->user()->unreadNotifications->count() > 0 ? 'visible' : '' }}" id="notif-count">
                    {{ auth()->user()->unreadNotifications->count() > 0 ? auth()->user()->unreadNotifications->count() : '' }}
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
        @if(session('warning'))
            <div class="alert alert-warning">⚠ {{ session('warning') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">✕ {{ $errors->first() }}</div>
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
setInterval(updateNotifCount, 30000);

</script>
</body>
</html>