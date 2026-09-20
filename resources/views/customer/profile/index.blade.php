@extends('layouts.customer')
@section('title', 'My Profile')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<style>
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.profile-wrap { max-width: 1100px; margin: 0 auto; }

/* ── TOP BAR ── */
.profile-topbar {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2rem;
}
.profile-topbar-left h1 {
    font-size: 1.55rem;
    font-weight: 800;
    color: var(--brown-deep, #3B1F0F);
    letter-spacing: -0.02em;
    margin-bottom: 0.2rem;
}
.profile-topbar-left p {
    font-size: 0.82rem;
    color: var(--text-muted, #9A7A5A);
}

/* ── LAYOUT ── */
.profile-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.5rem;
    align-items: start;
}

/* ── LEFT PANEL ── */
.profile-panel {
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border, #EAE0D0);
    background: var(--warm-white, #FFFDF9);
}

.panel-hero {
    position: relative;
    height: 96px;
    background: linear-gradient(135deg, #2C1508 0%, #7A4A28 60%, #C07840 100%);
}
.panel-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.panel-avatar-ring {
    position: absolute;
    bottom: -36px;
    left: 50%;
    transform: translateX(-50%);
    width: 72px;
    height: 72px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, #C07840, #E8A96A);
    box-shadow: 0 4px 16px rgba(59,31,15,0.25);
    z-index: 1;
}
.panel-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--brown-deep, #3B1F0F);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    color: #E8C9A8;
    overflow: hidden;
    border: 3px solid var(--warm-white, #FFFDF9);
}
.panel-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

.panel-body { padding: 2.75rem 1.5rem 1.5rem; text-align: center; }

.panel-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--brown-deep, #3B1F0F);
    letter-spacing: -0.01em;
    margin-bottom: 0.2rem;
}
.panel-email {
    font-size: 0.73rem;
    color: var(--text-muted, #9A7A5A);
    margin-bottom: 1.25rem;
}
.panel-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.85rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    margin-bottom: 1.5rem;
}
.panel-badge.verified  { background: #EDFAF1; color: #1A7A40; border: 1px solid #A8DFC0; }
.panel-badge.unverified { background: #FEF9E8; color: #9B7A10; border: 1px solid #F0D890; }

/* Stats */
.panel-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border: 1px solid var(--border, #EAE0D0);
    border-radius: 14px;
    overflow: hidden;
}
.stat-cell {
    padding: 0.85rem 0.75rem;
    text-align: center;
    border-right: 1px solid var(--border, #EAE0D0);
    transition: background 0.2s;
}
.stat-cell:hover { background: var(--cream, #F5EFE6); }
.stat-cell:nth-child(even)  { border-right: none; }
.stat-cell:nth-child(n+3)   { border-top: 1px solid var(--border, #EAE0D0); }
.stat-num {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--brown-deep, #3B1F0F);
    line-height: 1;
    margin-bottom: 0.2rem;
}
.stat-lbl {
    font-size: 0.58rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted, #9A7A5A);
    font-weight: 600;
}

/* Panel meta rows */
.panel-meta {
    margin-top: 1.25rem;
    border: 1px solid var(--border, #EAE0D0);
    border-radius: 14px;
    overflow: hidden;
}
.panel-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.65rem 1rem;
    font-size: 0.78rem;
    border-bottom: 1px solid var(--border, #EAE0D0);
}
.panel-meta-row:last-child { border-bottom: none; }
.pm-label { color: var(--text-muted, #9A7A5A); }
.pm-value { font-weight: 600; color: var(--brown-deep, #3B1F0F); }

.profile-card {
    background: var(--warm-white, #FFFDF9);
    border: 1px solid var(--border, #EAE0D0);
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: box-shadow 0.25s;
}
.profile-card:hover { box-shadow: 0 8px 24px rgba(59,31,15,0.06); }
.profile-card:last-child { margin-bottom: 0; }

.pc-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border, #EAE0D0);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pc-header-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--brown-deep, #3B1F0F);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.pc-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 7px;
    background: rgba(192,120,64,0.1);
    color: var(--caramel, #C07840);
    flex-shrink: 0;
}
.pc-header-meta {
    font-size: 0.72rem;
    color: var(--text-muted, #9A7A5A);
    background: var(--cream, #F5EFE6);
    padding: 0.2rem 0.65rem;
    border-radius: 20px;
    font-weight: 600;
}
.pc-header-link {
    font-size: 0.72rem;
    color: var(--caramel, #C07840);
    font-weight: 600;
    text-decoration: none;
}
.pc-header-link:hover { text-decoration: underline; }

/* Info grid */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; }
.info-cell {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border, #EAE0D0);
    border-right: 1px solid var(--border, #EAE0D0);
}
.info-cell:nth-child(even)     { border-right: none; }
.info-cell:nth-last-child(-n+2){ border-bottom: none; }
.info-cell.full                { grid-column: 1 / -1; border-right: none; border-bottom: none; }
.info-lbl {
    font-size: 0.6rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--text-muted, #9A7A5A);
    font-weight: 700;
    margin-bottom: 0.3rem;
}
.info-val {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--brown-deep, #3B1F0F);
}

/* ── ADDRESS CARDS ── */
.addr-grid {
    padding: 1.25rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
}
.addr-card {
    border: 1.5px solid var(--border, #EAE0D0);
    border-radius: 14px;
    padding: 1rem 1.1rem;
    transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
    background: white;
    position: relative;
}
.addr-card:hover { border-color: var(--caramel, #C07840); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59,31,15,0.08); }
.addr-card.is-default {
    border-color: var(--caramel, #C07840);
    background: linear-gradient(135deg, #FFF8F2, #FEF3E8);
}
.addr-card.is-default::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #C07840, #E8A96A);
    border-radius: 14px 14px 0 0;
}
.addr-type-row {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin-bottom: 0.55rem;
}
.addr-type-icon {
    width: 26px; height: 26px;
    border-radius: 7px;
    background: var(--cream, #F5EFE6);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-mid, #6B4A2A);
    flex-shrink: 0;
}
.addr-card.is-default .addr-type-icon { background: rgba(192,120,64,0.12); }
.addr-label-text {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted, #9A7A5A);
}
.addr-default-tag {
    margin-left: auto;
    font-size: 0.58rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background: var(--caramel, #C07840);
    color: white;
    padding: 0.15rem 0.5rem;
    border-radius: 20px;
}
.addr-street {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--brown-deep, #3B1F0F);
    margin-bottom: 0.2rem;
    line-height: 1.4;
}
.addr-city {
    font-size: 0.72rem;
    color: var(--text-muted, #9A7A5A);
    margin-bottom: 0.85rem;
}
.addr-actions {
    display: flex;
    gap: 0.3rem;
    flex-wrap: wrap;
    padding-top: 0.65rem;
    border-top: 1px solid var(--border, #EAE0D0);
}
.addr-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-size: 0.68rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none;
    background: transparent;
}
.addr-btn.ghost { background: var(--cream, #F5EFE6); color: var(--text-mid, #6B4A2A); }
.addr-btn.ghost:hover { background: var(--border, #EAE0D0); }
.addr-btn.danger { background: #FDF0EE; color: #8B2A1E; }
.addr-btn.danger:hover { background: #F5C5BE; }

.addr-empty {
    padding: 2.5rem 1.5rem;
    text-align: center;
    color: var(--text-muted, #9A7A5A);
}
.addr-empty-icon { display: flex; justify-content: center; margin-bottom: 0.65rem; opacity: 0.35; }
.addr-empty-text { font-size: 0.82rem; }

/* ── ADD ADDRESS ── */
.add-addr-section {
    padding: 1.25rem;
    border-top: 1px solid var(--border, #EAE0D0);
    background: var(--cream, #F5EFE6);
}
.add-addr-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1.5px dashed var(--caramel, #C07840);
    border-radius: 10px;
    background: transparent;
    color: var(--caramel, #C07840);
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.add-addr-toggle:hover { background: rgba(192,120,64,0.07); }

.add-addr-form { display: none; margin-top: 1rem; }
.add-addr-form.open { display: block; }

.form-section-title {
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--text-muted, #9A7A5A);
    font-weight: 700;
    margin-bottom: 0.75rem;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}
.form-group { display: flex; flex-direction: column; gap: 0.3rem; }
.form-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-mid, #6B4A2A);
}
.form-input {
    padding: 0.6rem 0.85rem;
    border: 1.5px solid var(--border, #EAE0D0);
    border-radius: 9px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.83rem;
    color: var(--brown-deep, #3B1F0F);
    background: white;
    outline: none;
    width: 100%;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input:focus {
    border-color: var(--caramel, #C07840);
    box-shadow: 0 0 0 3px rgba(192,120,64,0.12);
}
.form-input::placeholder { color: #C0B0A0; }
.form-check-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.75rem 0 1rem;
}
.form-check-row input[type="checkbox"] {
    width: 16px; height: 16px;
    accent-color: var(--caramel, #C07840);
    cursor: pointer;
}
.form-check-row label {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-mid, #6B4A2A);
    cursor: pointer;
    text-transform: none;
    letter-spacing: 0;
}
.form-actions { display: flex; gap: 0.5rem; }
.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.65rem 1.4rem;
    background: var(--brown-deep, #3B1F0F);
    color: white;
    border: none;
    border-radius: 9px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-save:hover { background: var(--caramel, #C07840); }
.btn-cancel-form {
    padding: 0.65rem 1.1rem;
    background: white;
    color: var(--text-mid, #6B4A2A);
    border: 1.5px solid var(--border, #EAE0D0);
    border-radius: 9px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-cancel-form:hover { border-color: var(--caramel, #C07840); color: var(--caramel, #C07840); }

/* ── EDIT MODAL ── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(20, 10, 4, 0.55);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: var(--warm-white, #FFFDF9);
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 24px 60px rgba(0,0,0,0.2);
    animation: modalPop 0.22s ease;
}
@keyframes modalPop {
    from { opacity: 0; transform: scale(0.96) translateY(6px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border, #EAE0D0);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.modal-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--brown-deep, #3B1F0F);
}
.modal-close {
    width: 30px; height: 30px;
    border-radius: 50%;
    border: none;
    background: var(--cream, #F5EFE6);
    color: var(--text-muted, #9A7A5A);
    font-size: 0.9rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.modal-close:hover { background: var(--border, #EAE0D0); }
.modal-body { padding: 1.5rem; }
</style>
@endpush

@section('content')
<div class="profile-wrap">

    {{-- TOP BAR ── single title only, no edit button here --}}
    <div class="profile-topbar">
        <div class="profile-topbar-left">
            <h1>My Profile</h1>
            <p>Manage your account information and delivery addresses</p>
        </div>
    </div>

    <div class="profile-layout">

        {{-- ── LEFT PANEL ── --}}
        <div class="profile-panel">
            <div class="panel-hero">
                <div class="panel-avatar-ring">
                    <div class="panel-avatar">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar">
                        @else
                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="panel-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                <div class="panel-email">{{ auth()->user()->email }}</div>
@if(auth()->user()->is_verified)
                    <div class="panel-badge verified">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Verified Account
                    </div>
                @else
                    <div class="panel-badge unverified">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4M12 17h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"></path></svg>
                        Unverified
                    </div>
                @endif

                <div class="panel-stats">
                    <div class="stat-cell">
                        <div class="stat-num">{{ auth()->user()->cakeRequests()->count() }}</div>
                        <div class="stat-lbl">Requests</div>
                    </div>
                    <div class="stat-cell">
                        <div class="stat-num">{{ auth()->user()->cakeRequests()->where('status','COMPLETED')->count() }}</div>
                        <div class="stat-lbl">Completed</div>
                    </div>
                    <div class="stat-cell">
                        <div class="stat-num">{{ $addresses->count() }}</div>
                        <div class="stat-lbl">Addresses</div>
                    </div>
                    <div class="stat-cell">
                        <div class="stat-num">{{ auth()->user()->created_at->format('Y') }}</div>
                        <div class="stat-lbl">Member</div>
                    </div>
                </div>

                <div class="panel-meta">
                    <div class="panel-meta-row">
                        <span class="pm-label">Role</span>
                        <span class="pm-value">Customer</span>
                    </div>
                    <div class="panel-meta-row">
                        <span class="pm-label">Member since</span>
                        <span class="pm-value">{{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
        <div class="panel-meta-row">
                        <span class="pm-label">Status</span>
                        <span class="pm-value">
                            @if(auth()->user()->is_verified)
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;color:#1A7A40;">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Verified
                                </span>
                            @else
                                <span style="color:#9B7A10;">Unverified</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Single edit button only here --}}
            <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border, #EAE0D0);">
<a href="{{ route('customer.profile.edit') }}"
                   style="display:flex; align-items:center; justify-content:center; gap:0.45rem; width:100%; padding:0.7rem 1rem; border-radius:10px; background:var(--brown-deep,#3B1F0F); color:white; font-size:0.82rem; font-weight:700; text-decoration:none; transition:all 0.2s;"
                   onmouseover="this.style.background='var(--caramel,#C07840)'"
                   onmouseout="this.style.background='var(--brown-deep,#3B1F0F)'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                    Edit Profile
                </a>
            </div>
        </div>

        {{-- ── RIGHT COLUMN ── --}}
        <div>

            {{-- ACCOUNT INFO --}}
            <div class="profile-card">
                <div class="pc-header">
              <div class="pc-header-title">
                        <span class="pc-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span> Account Information
                    </div>
                    <a href="{{ route('customer.profile.edit') }}" class="pc-header-link">Edit →</a>
                </div>
                <div class="info-grid">
                    <div class="info-cell">
                        <div class="info-lbl">First Name</div>
                        <div class="info-val">{{ auth()->user()->first_name }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-lbl">Last Name</div>
                        <div class="info-val">{{ auth()->user()->last_name }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-lbl">Email Address</div>
                        <div class="info-val">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-lbl">Phone Number</div>
                        <div class="info-val">{{ auth()->user()->phone ?? '—' }}</div>
                    </div>
                    <div class="info-cell full">
                        <div class="info-lbl">Member Since</div>
                        <div class="info-val">{{ auth()->user()->created_at->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>

            {{-- DELIVERY ADDRESSES --}}
            <div class="profile-card">
                <div class="pc-header">
           <div class="pc-header-title">
                        <span class="pc-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg></span> Delivery Addresses
                    </div>
                    <span class="pc-header-meta">{{ $addresses->count() }} saved</span>
                </div>

                @if($addresses->count())
                <div class="addr-grid">
                    @foreach($addresses as $addr)
                 @php
                        $addrIcons = [
                            'Home' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
                            'Work' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
                            'Office' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v18"></path><path d="M6 12H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2"></path><path d="M18 9h2a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1h-2"></path><path d="M10 6h.01M14 6h.01M10 10h.01M14 10h.01M10 14h.01M14 14h.01"></path></svg>',
                            'School' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5Z"></path><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"></path></svg>',
                        ];
                        $addrIconDefault = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
                        $icon = $addrIcons[$addr->label] ?? $addrIconDefault;
                    @endphp
                    <div class="addr-card {{ $addr->is_default ? 'is-default' : '' }}">
                        <div class="addr-type-row">
                      <div class="addr-type-icon">{!! $icon !!}</div>
                            <span class="addr-label-text">{{ $addr->label }}</span>
                            @if($addr->is_default)
                                <span class="addr-default-tag">Default</span>
                            @endif
                        </div>
                        <div class="addr-street">{{ $addr->street }}</div>
                        <div class="addr-city">
                            {{ $addr->city }}{{ $addr->province ? ', ' . $addr->province : '' }}{{ $addr->zip_code ? ' ' . $addr->zip_code : '' }}
                        </div>
                        <div class="addr-actions">
                            @if(!$addr->is_default)
                            <form method="POST" action="{{ route('customer.addresses.setDefault', $addr->id) }}" style="margin:0;">
                                @csrf @method('PATCH')
                       <button type="submit" class="addr-btn ghost">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    Set Default
                                </button>
                            </form>
                            @endif
                       <button onclick="openEditAddress({{ $addr->id }}, '{{ $addr->label }}', '{{ addslashes($addr->street) }}', '{{ addslashes($addr->city) }}', '{{ addslashes($addr->province) }}', '{{ $addr->zip_code }}')"
                                    class="addr-btn ghost">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                                Edit
                            </button>
                            <form method="POST" action="{{ route('customer.addresses.destroy', $addr->id) }}"
                                  onsubmit="return confirm('Remove this address?')" style="margin:0;">
                                @csrf @method('DELETE')
                             <button type="submit" class="addr-btn danger">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
          <div class="addr-empty">
                    <span class="addr-empty-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </span>
                    <div class="addr-empty-text">No saved addresses yet. Add one below.</div>
                </div>
                @endif

                <div class="add-addr-section">
          <button class="add-addr-toggle" onclick="toggleAddForm(this)">
                        <span id="add-toggle-icon" style="display:flex;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg>
                        </span>
                        <span id="add-toggle-text">Add New Address</span>
                    </button>

                    <div class="add-addr-form" id="addAddressForm">
                        <form method="POST" action="{{ route('customer.addresses.store') }}" style="margin-top:1rem;">
                            @csrf
                            <div class="form-section-title">New Address Details</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Label *</label>
                                    <input type="text" name="label" class="form-input" placeholder="Home, Work, etc." required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Street *</label>
                                    <input type="text" name="street" class="form-input" placeholder="House no., Street name" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">City / Municipality *</label>
                                    <input type="text" name="city" class="form-input" placeholder="e.g. Dasmariñas" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Province</label>
                                    <input type="text" name="province" class="form-input" placeholder="e.g. Cavite">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">ZIP Code</label>
                                    <input type="text" name="zip_code" class="form-input" placeholder="e.g. 4114">
                                </div>
                                <div class="form-group" style="justify-content:flex-end;">
                                    <div class="form-check-row" style="margin:0; margin-top:auto;">
                                        <input type="checkbox" name="is_default" id="is_default" value="1">
                                        <label for="is_default">Set as default address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                         <button type="submit" class="btn-save">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Save Address
                                </button>
                                <button type="button" class="btn-cancel-form" onclick="toggleAddForm(document.querySelector('.add-addr-toggle'))">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- EDIT ADDRESS MODAL --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
      <div class="modal-title" style="display:flex;align-items:center;gap:0.5rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                Edit Address
            </div>
            <button class="modal-close" onclick="closeEditModal()">✕</button>
        </div>
        <div class="modal-body">
            <form method="POST" id="editAddressForm">
                @csrf @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Label *</label>
                        <input type="text" name="label" id="edit_label" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Street *</label>
                        <input type="text" name="street" id="edit_street" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">City *</label>
                        <input type="text" name="city" id="edit_city" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Province</label>
                        <input type="text" name="province" id="edit_province" class="form-input">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:1.25rem;">
                    <label class="form-label">ZIP Code</label>
                    <input type="text" name="zip_code" id="edit_zip" class="form-input">
                </div>
                <div class="form-actions">
       <button type="submit" class="btn-save">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Update Address
                    </button>
                    <button type="button" class="btn-cancel-form" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleAddForm(btn) {
    const form = document.getElementById('addAddressForm');
    const icon = document.getElementById('add-toggle-icon');
    const text = document.getElementById('add-toggle-text');
    const isOpen = form.classList.toggle('open');
    icon.innerHTML = isOpen
        ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path></svg>'
        : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"></path></svg>';
    text.textContent = isOpen ? 'Cancel' : 'Add New Address';
}
function openEditAddress(id, label, street, city, province, zip) {
    document.getElementById('edit_label').value    = label;
    document.getElementById('edit_street').value   = street;
    document.getElementById('edit_city').value     = city;
    document.getElementById('edit_province').value = province;
    document.getElementById('edit_zip').value      = zip;
    document.getElementById('editAddressForm').action = `/customer/addresses/${id}`;
    document.getElementById('editModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endpush