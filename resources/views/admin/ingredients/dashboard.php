{{-- ══════════════════════════════════════════════════════
     FILE: resources/views/admin/dashboard.blade.php
══════════════════════════════════════════════════════ --}}
@extends('layouts.app')
@section('breadcrumb')<span class="current">Dashboard</span>@endsection
@section('content')
<style>
    :root{--gold:#C47E2A;--gold-light:#E0A050;--gold-soft:#FDF2E4;--gold-glow:rgba(196,126,42,0.18);--copper:#A85828;--teal:#277A6E;--teal-soft:#E5F2F0;--rose:#B83C44;--rose-soft:#FDEAEB;--espresso:#341C08;--text-primary:#2A1806;--text-secondary:#604028;--text-muted:#9C7850;--border:#E5DDD0;--border-md:#D4C9B5;--surface:#FFFFFF;--surface-2:#FAF7F2;--surface-3:#F2ECE2;--radius:12px;--radius-lg:16px;--radius-xl:22px;}
    .page{padding:2.25rem 2rem 4rem;max-width:1200px;margin:0 auto;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.75)}}
    .page-header{margin-bottom:2rem;animation:fadeUp .45s ease both;}
    .eyebrow{font-size:.655rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);display:flex;align-items:center;gap:.5rem;margin-bottom:.5rem;}
    .eyebrow-line{display:inline-block;width:20px;height:2px;background:linear-gradient(90deg,var(--gold),var(--copper));border-radius:2px;}
    h1{font-family:'Syne',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:var(--espresso);}
    h1 span{background:linear-gradient(135deg,#9E6118,var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .sub{font-size:.8375rem;color:var(--text-muted);margin-top:.35rem;}
    .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.75rem;}
    .scard{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:1.25rem 1.375rem;position:relative;overflow:hidden;animation:fadeUp .5s ease both;transition:transform .2s,box-shadow .2s;box-shadow:0 2px 8px rgba(140,100,60,.05);}
    .scard:hover{transform:translateY(-2px);box-shadow:0 6px 22px var(--gold-glow);}
    .scard::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:var(--radius-lg) var(--radius-lg) 0 0;}
    .scard:nth-child(1)::before{background:linear-gradient(90deg,var(--gold),var(--gold-light));}
    .scard:nth-child(2)::before{background:linear-gradient(90deg,var(--teal),#56C9BC);}
    .scard:nth-child(3)::before{background:linear-gradient(90deg,var(--copper),var(--gold));}
    .scard:nth-child(4)::before{background:linear-gradient(90deg,var(--rose),#E06070);}
    .scard:nth-child(1){animation-delay:.04s;} .scard:nth-child(2){animation-delay:.09s;} .scard:nth-child(3){animation-delay:.14s;} .scard:nth-child(4){animation-delay:.19s;}
    .sicon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:.875rem;}
    .scard:nth-child(1) .sicon{background:var(--gold-soft);color:var(--gold);}
    .scard:nth-child(2) .sicon{background:var(--teal-soft);color:var(--teal);}
    .scard:nth-child(3) .sicon{background:#FDEEE4;color:var(--copper);}
    .scard:nth-child(4) .sicon{background:var(--rose-soft);color:var(--rose);}
    .slabel{font-size:.695rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.25rem;}
    .sval{font-family:'Syne',sans-serif;font-size:1.8rem;font-weight:700;letter-spacing:-.04em;color:var(--espresso);}
    .sdelta{font-size:.715rem;color:var(--teal);font-weight:500;margin-top:.2rem;}
    .row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.75rem;}
    .panel{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius-xl);overflow:hidden;box-shadow:0 2px 10px rgba(140,100,60,.06);animation:fadeUp .5s ease .2s both;}
    .ph{display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.375rem;border-bottom:1px solid var(--border);background:var(--surface-2);}
    .pt{font-family:'Syne',sans-serif;font-size:.8375rem;font-weight:700;color:var(--text-secondary);display:flex;align-items:center;gap:.5rem;}
    .pdot{width:7px;height:7px;border-radius:50%;animation:pulse 2.5s infinite;}
    .pdot.gold{background:var(--gold);} .pdot.rose{background:var(--rose);} .pdot.teal{background:var(--teal);}
    .pb{padding:1.125rem 1.375rem;}
    .pb a{font-size:.78rem;font-weight:600;color:var(--gold);text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;}
    .pb a:hover{color:#9E6118;}
    .order-list{display:flex;flex-direction:column;gap:.5rem;}
    .order-row{display:flex;align-items:center;justify-content:space-between;padding:.625rem .75rem;border-radius:var(--radius);background:var(--surface-2);border:1px solid var(--border);}
    .order-num{font-family:'JetBrains Mono',monospace;font-size:.75rem;font-weight:600;color:var(--text-secondary);}
    .order-cust{font-size:.78rem;color:var(--text-muted);margin-top:1px;}
    .badge{display:inline-flex;align-items:center;padding:.2rem .6rem;border-radius:20px;font-size:.67rem;font-weight:600;}
    .badge.pending{background:#FEF9E7;color:#9C7010;border:1px solid #EDD880;}
    .badge.confirmed{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(39,122,110,.3);}
    .badge.baking{background:#FDF2E4;color:var(--copper);border:1px solid rgba(168,88,40,.3);}
    .badge.ready{background:#E5F2F0;color:var(--teal);border:1px solid rgba(39,122,110,.4);}
    .badge.delivered{background:#F0F9F7;color:#1A6050;border:1px solid rgba(26,96,80,.3);}
    .badge.cancelled{background:var(--rose-soft);color:var(--rose);border:1px solid rgba(184,60,68,.25);}
    @media(max-width:768px){.stats{grid-template-columns:1fr 1fr;}.row2{grid-template-columns:1fr;}.page{padding:1.5rem 1rem 3rem;}}
</style>
<div class="page">
    <div class="page-header">
        <div class="eyebrow"><span class="eyebrow-line"></span> Bakery Overview</div>
        <h1>Welcome back, <span>{{ Auth::user()->name ?? 'Admin' }}</span></h1>
        <p class="sub">Here's what's happening at your bakery today — {{ now()->format('l, F j, Y') }}</p>
    </div>
    <div class="stats">
        <div class="scard">
            <div class="sicon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div>
            <div class="slabel">Total Orders</div>
            <div class="sval">{{ $stats['total_orders'] }}</div>
            <div class="sdelta">{{ $stats['pending_orders'] }} pending</div>
        </div>
        <div class="scard">
            <div class="sicon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="slabel">Active Bakers</div>
            <div class="sval">{{ $stats['total_bakers'] }}</div>
            <div class="sdelta">{{ $stats['pending_bakers'] }} awaiting approval</div>
        </div>
        <div class="scard">
            <div class="sicon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
            <div class="slabel">Customers</div>
            <div class="sval">{{ $stats['total_customers'] }}</div>
            <div class="sdelta">Registered accounts</div>
        </div>
        <div class="scard">
            <div class="sicon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
            <div class="slabel">Monthly Revenue</div>
            <div class="sval">₱{{ number_format($stats['monthly_revenue'], 0) }}</div>
            <div class="sdelta">This month</div>
        </div>
    </div>
    <div class="row2">
        <div class="panel">
            <div class="ph">
                <div class="pt"><div class="pdot gold"></div> Recent Orders</div>
                <a href="{{ route('orders.index') }}" style="font-size:.75rem;color:var(--gold);text-decoration:none;font-weight:600;">View all →</a>
            </div>
            <div class="pb">
                <div class="order-list">
                    @forelse($recent_orders as $order)
                    <div class="order-row">
                        <div>
                            <div class="order-num">{{ $order->order_number }}</div>
                            <div class="order-cust">{{ $order->customer->name ?? 'Walk-in' }}</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <span style="font-size:.8rem;font-family:'JetBrains Mono',monospace;color:var(--teal);font-weight:600;">₱{{ number_format($order->total_amount,2) }}</span>
                            <span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    @empty
                    <p style="text-align:center;color:var(--text-muted);font-size:.82rem;padding:1.5rem 0;">No orders yet. <a href="{{ route('orders.index') }}" style="color:var(--gold);">Create one →</a></p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="ph">
                <div class="pt"><div class="pdot rose"></div> Baker Applications</div>
                <a href="{{ route('bakers.index') }}" style="font-size:.75rem;color:var(--gold);text-decoration:none;font-weight:600;">View all →</a>
            </div>
            <div class="pb">
                <div class="order-list">
                    @forelse($pending_bakers as $baker)
                    <div class="order-row">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#B8782A,#E8A850);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:.7rem;color:#fff;flex-shrink:0;">{{ strtoupper(substr($baker->name,0,2)) }}</div>
                            <div>
                                <div style="font-size:.8125rem;font-weight:600;color:var(--text-primary);">{{ $baker->name }}</div>
                                <div style="font-size:.7rem;color:var(--text-muted);">{{ $baker->city ?? 'Unknown city' }}</div>
                            </div>
                        </div>
                        <span class="badge pending">Pending</span>
                    </div>
                    @empty
                    <p style="text-align:center;color:var(--text-muted);font-size:.82rem;padding:1.5rem 0;">No pending applications.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection