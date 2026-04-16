<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BakeSphere Admin') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

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
            --gold-glow:     rgba(192,120,40,0.18);
            --copper:        #A45224;
            --teal:          #1F7A6C;
            --teal-soft:     #E4F2EF;
            --rose:          #B43840;
            --rose-soft:     #FDEAEB;
            --espresso:      #2C1608;
            --mocha:         #6A4824;
            --sand:          #C4A470;
            --text-primary:   #1E0E04;
            --text-secondary: #4A2C14;
            --text-muted:     #8C6840;
            --sidebar-w:     252px;
            --header-h:      60px;
            --r:   10px;
            --rl:  14px;
            --rxl: 18px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg) !important;
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ── SIDEBAR ── */
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

        /* Brand */
        .sidebar-brand {
            padding: 1.375rem 1.25rem 1.125rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .brand-logo { display: flex; align-items: center; gap: 0.75rem; }
        .brand-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--gold), var(--copper));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 12px rgba(192,120,40,0.35);
            flex-shrink: 0;
        }
        .brand-text { flex: 1; min-width: 0; }
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.9375rem; font-weight: 800;
            letter-spacing: -0.02em; color: #FDF8F3;
            line-height: 1.1;
        }
        .brand-sub {
            font-size: 0.6rem; font-weight: 500;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: rgba(196,164,112,0.55);
            font-family: 'DM Sans', sans-serif;
            margin-top: 2px;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1; overflow-y: auto;
            padding: 1rem 0.75rem;
            display: flex; flex-direction: column;
        }
        .sidebar-nav::-webkit-scrollbar { width: 2px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); }

        .nav-group { margin-bottom: 1.25rem; }
        .nav-label {
            font-size: 0.6rem; font-weight: 700;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: rgba(196,164,112,0.38);
            padding: 0 0.625rem;
            margin-bottom: 0.25rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-item {
            display: flex; align-items: center; gap: 0.625rem;
            padding: 0.5625rem 0.75rem;
            border-radius: var(--r);
            font-size: 0.8125rem; font-weight: 500;
            color: rgba(253,248,243,0.52);
            text-decoration: none;
            transition: all 0.15s ease;
            cursor: pointer;
            border: none; background: none; width: 100%; text-align: left;
            font-family: 'DM Sans', sans-serif;
        }
        .nav-item svg { flex-shrink: 0; opacity: 0.55; transition: opacity 0.15s; width: 15px; height: 15px; }
        .nav-item span.label { flex: 1; }
        .nav-item:hover {
            background: rgba(255,255,255,0.055);
            color: rgba(253,248,243,0.85);
        }
        .nav-item:hover svg { opacity: 0.85; }
        .nav-item.active {
            background: rgba(192,120,40,0.18);
            color: var(--gold-light);
            font-weight: 600;
        }
        .nav-item.active svg { opacity: 1; color: var(--gold-light); }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0.75rem;
            width: 3px; height: 16px; border-radius: 2px;
            background: var(--gold);
        }
        .nav-item { position: relative; }

        .nav-badge {
            font-size: 0.6rem; font-weight: 700;
            padding: 0.1rem 0.4rem; border-radius: 8px;
            font-family: 'DM Mono', monospace;
            min-width: 16px; text-align: center;
            background: var(--gold); color: #fff;
        }
        .nav-badge.teal { background: var(--teal); }
        .nav-badge.rose { background: var(--rose); }

        /* User */
        .sidebar-user {
            padding: 0.75rem 1rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; gap: 0.625rem;
            flex-shrink: 0;
        }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, var(--gold), var(--copper));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 0.65rem; color: #fff; flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name {
            font-size: 0.775rem; font-weight: 600;
            color: rgba(253,248,243,0.85);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            font-family: 'DM Sans', sans-serif;
        }
        .user-role {
            font-size: 0.62rem; color: rgba(196,164,112,0.5);
        }
        .user-logout {
            background: none; border: none; cursor: pointer;
            color: rgba(196,164,112,0.4); padding: 0.25rem;
            border-radius: 6px; transition: all 0.15s;
            display: flex; align-items: center;
        }
        .user-logout:hover { color: #FFAAB0; background: rgba(180,56,64,0.15); }

        /* ── TOPBAR ── */
        .admin-topbar {
            position: fixed; top: 0;
            left: var(--sidebar-w); right: 0;
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 1.5rem; z-index: 100;
            gap: 1rem;
            box-shadow: 0 1px 8px rgba(120,80,30,0.05);
        }
        .topbar-breadcrumb {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.775rem; color: var(--text-muted);
            flex: 1; min-width: 0;
            font-family: 'DM Sans', sans-serif;
        }
        .topbar-breadcrumb .sep { color: var(--border-md); font-size: 0.7rem; }
        .topbar-breadcrumb .current {
            font-weight: 600; color: var(--text-secondary);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .topbar-right { display: flex; align-items: center; gap: 0.5rem; }
        .topbar-btn {
            position: relative; width: 34px; height: 34px;
            background: var(--surface-2); border: 1.5px solid var(--border);
            border-radius: var(--r); display: flex; align-items: center;
            justify-content: center; cursor: pointer; color: var(--text-muted);
            transition: all 0.15s;
        }
        .topbar-btn:hover {
            background: var(--gold-soft); border-color: rgba(192,120,40,0.3);
            color: var(--gold);
        }
        .notif-dot {
            position: absolute; top: 6px; right: 6px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--rose); border: 1.5px solid var(--surface);
        }
        .topbar-date {
            font-size: 0.72rem; color: var(--text-muted);
            font-family: 'DM Mono', monospace;
            background: var(--surface-2); border: 1.5px solid var(--border);
            border-radius: var(--r); padding: 0 0.75rem;
            height: 34px; display: flex; align-items: center; white-space: nowrap;
        }

        /* Notifications dropdown */
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
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.8rem; font-weight: 700; color: var(--text-secondary);
        }
        .notif-mark { font-size: 0.7rem; font-weight: 500; color: var(--gold); cursor: pointer; font-family: 'DM Sans', sans-serif; }
        .notif-item {
            display: flex; gap: 0.625rem; padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border); cursor: pointer;
            transition: background 0.12s;
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item:hover { background: var(--surface-2); }
        .notif-item.unread { background: var(--gold-soft); }
        .notif-indicator {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--gold); flex-shrink: 0; margin-top: 5px;
        }
        .notif-item.unread .notif-indicator { background: var(--rose); }
        .notif-text { font-size: 0.775rem; color: var(--text-primary); line-height: 1.45; font-family: 'DM Sans', sans-serif; }
        .notif-time { font-size: 0.65rem; color: var(--text-muted); margin-top: 2px; }

        /* Search overlay */
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
            background: var(--surface);
            border: 1.5px solid var(--border-md);
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
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
            color: var(--text-primary);
        }
        .search-global-input::placeholder { color: var(--text-muted); }
        .search-esc {
            font-size: 0.65rem; font-family: 'DM Mono', monospace;
            color: var(--text-muted); background: var(--surface-3);
            border: 1px solid var(--border-md); border-radius: 5px;
            padding: 0.12rem 0.4rem; cursor: pointer;
        }
        .search-empty { padding: 2rem 1.25rem; text-align: center; font-size: 0.8rem; color: var(--text-muted); font-family: 'DM Sans', sans-serif; }

        /* ── MAIN ── */
        .admin-main {
            margin-left: var(--sidebar-w);
            padding-top: var(--header-h);
            min-height: 100vh;
            background: var(--bg);
        }

        /* ── MOBILE ── */
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
            width: 34px; height: 34px;
            align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-secondary);
        }
        @media (max-width: 900px) { .mobile-menu-btn { display: flex; } }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <div class="brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
            </div>
            <div class="brand-text">
                <div class="brand-name">BakeSphere</div>
                <div class="brand-sub">Bakery Management</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-group">
            <div class="nav-label">Overview</div>
            <a href="{{ (function(){ try{ return route('dashboard'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                <span class="label">Dashboard</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Operations</div>
            <a href="{{ (function(){ try{ return route('ingredients.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('ingredients.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                <span class="label">Ingredients</span>
            </a>
            <a href="{{ (function(){ try{ return route('orders.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="label">Orders</span>
                <span class="nav-badge" id="ordersBadge">12</span>
            </a>
            <a href="{{ (function(){ try{ return route('products.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class="label">Products & Cakes</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">People</div>
            <a href="{{ (function(){ try{ return route('bakers.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('bakers.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="label">Bakers</span>
                <span class="nav-badge rose">3</span>
            </a>
            <a href="{{ (function(){ try{ return route('customers.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="label">Customers</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Analytics</div>
            <a href="{{ (function(){ try{ return route('reports.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                <span class="label">Sales Reports</span>
            </a>
            <a href="{{ (function(){ try{ return route('system.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('system.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span class="label">System Monitor</span>
                <span class="nav-badge teal">Live</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-label">Settings</div>
            <a href="{{ (function(){ try{ return route('settings.index'); }catch(\Exception $e){ return '#'; } })() }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                <span class="label">Settings</span>
            </a>
        </div>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->first_name ?? 'A', 0, 1) . substr(Auth::user()->last_name ?? '', 0, 1)) }}</div>
        <div class="user-info">
            <div class="user-name">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</div>
            <div class="user-role">Administrator</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="user-logout" title="Sign out">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
        </form>
    </div>
</aside>

<!-- TOPBAR -->
<div class="admin-topbar">
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <div class="topbar-breadcrumb">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Admin</span>
        <span class="sep">›</span>
        {!! $__env->yieldContent('breadcrumb', '<span class="current">Dashboard</span>') !!}
    </div>

    <div class="topbar-right">
        <div class="topbar-date" id="topbarDate"></div>

        <div class="notif-wrap">
            <button class="topbar-btn" id="notifBtn" onclick="toggleNotif(event)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="notif-dot" id="notifDot"></span>
            </button>
            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    Notifications
                    <span class="notif-mark" onclick="markAllRead()">Mark all read</span>
                </div>
                <div class="notif-item unread" onclick="markRead(this)">
                    <div class="notif-indicator"></div>
                    <div><div class="notif-text">New baker application from <strong>Maria Asuncion</strong></div><div class="notif-time">2 hours ago</div></div>
                </div>
                <div class="notif-item unread" onclick="markRead(this)">
                    <div class="notif-indicator"></div>
                    <div><div class="notif-text">Order #1042 awaiting confirmation</div><div class="notif-time">4 hours ago</div></div>
                </div>
                <div class="notif-item unread" onclick="markRead(this)">
                    <div class="notif-indicator"></div>
                    <div><div class="notif-text">Low stock: <strong>Dark Chocolate</strong> below threshold</div><div class="notif-time">Yesterday</div></div>
                </div>
                <div class="notif-item" onclick="markRead(this)">
                    <div class="notif-indicator" style="background:var(--border-md)"></div>
                    <div><div class="notif-text">Weekly sales report ready for review</div><div class="notif-time">2 days ago</div></div>
                </div>
            </div>
        </div>

        <button class="topbar-btn" onclick="openSearch()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
    </div>
</div>

<!-- SEARCH OVERLAY -->
<div class="search-overlay" id="searchOverlay" onclick="closeSearch(event)">
    <div class="search-box" onclick="event.stopPropagation()">
        <div class="search-input-row">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" class="search-global-input" id="globalInput" placeholder="Search ingredients, orders, customers…" oninput="runSearch()">
            <span class="search-esc" onclick="closeSearch()">ESC</span>
        </div>
        <div id="searchResults" class="search-empty">Start typing to search across your bakery data</div>
    </div>
</div>

<!-- MAIN -->
<main class="admin-main">
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
        updateDot();
    }
    function markAllRead() {
        document.querySelectorAll('.notif-item.unread').forEach(el => {
            el.classList.remove('unread');
            el.querySelector('.notif-indicator').style.background = 'var(--border-md)';
        });
        updateDot();
    }
    function updateDot() {
        const unread = document.querySelectorAll('.notif-item.unread').length;
        document.getElementById('notifDot').style.display = unread > 0 ? 'block' : 'none';
    }
    document.addEventListener('click', function(e) {
        const dd = document.getElementById('notifDropdown');
        if (dd && !dd.contains(e.target) && !document.getElementById('notifBtn').contains(e.target)) {
            dd.classList.remove('open');
        }
    });
    function openSearch() {
        document.getElementById('searchOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('globalInput').focus(), 80);
    }
    function closeSearch(e) {
        if (!e || e.target === document.getElementById('searchOverlay')) {
            document.getElementById('searchOverlay').classList.remove('open');
            document.getElementById('globalInput').value = '';
            document.getElementById('searchResults').innerHTML = 'Start typing to search across your bakery data';
            document.getElementById('searchResults').className = 'search-empty';
            document.body.style.overflow = '';
        }
    }
    function runSearch() {
        const q = document.getElementById('globalInput').value.trim();
        const area = document.getElementById('searchResults');
        if (q.length < 2) {
            area.innerHTML = 'Start typing to search across your bakery data';
            area.className = 'search-empty';
            return;
        }
        area.className = 'search-empty';
        area.innerHTML = `Searching for "<strong>${q}</strong>"…`;
    }
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
        if (e.key === 'Escape') { closeSearch(); document.getElementById('notifDropdown')?.classList.remove('open'); }
    });
</script>
</body>
</html>