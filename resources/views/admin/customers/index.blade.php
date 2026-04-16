@extends('layouts.admin')
@section('title', 'Customers')

@push('styles')
<style>
:root{
    --gold:#C07828;--gold-dark:#9A5E14;--gold-light:#DC9E48;--gold-soft:#FEF3E2;
    --gold-glow:rgba(192,120,40,.16);--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;
    --rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;
    --t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--bg:#F5F0E8;
    --s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;
    --r:10px;--rl:14px;--rxl:18px;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}

.pg{padding:0 0 5rem;}

/* HERO */
.cust-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:1rem;}
.cust-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.cust-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.cust-hero-left{position:relative;z-index:1;}
.cust-hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.cust-hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.cust-hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.cust-hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.cust-hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}
.cust-hero-right{position:relative;z-index:1;display:flex;gap:.625rem;}
.hero-stat{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.11);border-radius:var(--rl);padding:.75rem 1.125rem;text-align:center;min-width:82px;}
.hero-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.5rem;font-weight:800;color:#fff;}
.hero-stat-lbl{font-size:.6rem;color:rgba(255,255,255,.38);margin-top:.2rem;text-transform:uppercase;letter-spacing:.09em;}

/* TOOLBAR */
.toolbar{display:flex;align-items:center;gap:.875rem;padding:1.375rem 2rem 0;flex-wrap:wrap;}
.search-wrap{position:relative;flex:1;max-width:320px;}
.search-wrap svg{position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--tm);pointer-events:none;}
.search-input{width:100%;padding:.6rem .875rem .6rem 2.25rem;border:1.5px solid var(--bdr);border-radius:var(--r);font-size:.8rem;font-family:'Plus Jakarta Sans',sans-serif;color:var(--t1);background:var(--s);outline:none;transition:border-color .18s,box-shadow .18s;height:38px;}
.search-input:focus{border-color:rgba(192,120,40,.38);box-shadow:0 0 0 3px var(--gold-glow);}
.search-input::placeholder{color:var(--tm);}
.filter-select{height:38px;padding:0 2rem 0 .75rem;border:1.5px solid var(--bdr);border-radius:var(--r);font-size:.78rem;font-family:'Plus Jakarta Sans',sans-serif;color:var(--t2);background:var(--s) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23C07828' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right .625rem center;appearance:none;outline:none;}
.btn-search{display:inline-flex;align-items:center;gap:.35rem;height:38px;padding:0 1rem;background:var(--gold);color:#fff;border:none;border-radius:var(--r);font-size:.78rem;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;transition:background .15s;}
.btn-search:hover{background:var(--gold-dark);}
.btn-clear{display:inline-flex;align-items:center;height:38px;padding:0 .875rem;border:1.5px solid var(--bdr);border-radius:var(--r);font-size:.78rem;color:var(--t2);text-decoration:none;font-weight:600;background:var(--s);}
.btn-clear:hover{background:var(--s2);}

/* PANEL */
.panel{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);overflow:hidden;box-shadow:0 2px 10px rgba(100,60,20,.05);margin:1.25rem 2rem 0;animation:fadeUp .45s ease both;}
.panel-head{display:flex;align-items:center;justify-content:space-between;padding:.9375rem 1.375rem;border-bottom:1px solid var(--bdr);background:var(--s2);}
.panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.8125rem;font-weight:700;color:var(--t2);display:flex;align-items:center;gap:.4rem;}
.pdot{width:6px;height:6px;border-radius:50%;background:var(--gold);box-shadow:0 0 5px rgba(192,120,40,.3);animation:pulse 2.5s infinite;}
.head-count{font-size:.7rem;color:var(--tm);font-family:'Plus Jakarta Sans',sans-serif;}

/* TABLE */
.ctable{width:100%;border-collapse:collapse;}
.ctable thead tr{background:var(--s3);border-bottom:1.5px solid var(--bdr);}
.ctable thead th{padding:.7rem 1.375rem;font-size:.635rem;font-weight:700;color:var(--tm);text-transform:uppercase;letter-spacing:.1em;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap;text-align:left;}
.ctable thead th.r{text-align:right;}.ctable thead th.c{text-align:center;}
.ctable tbody tr{border-bottom:1px solid var(--bdr);transition:background .12s;}
.ctable tbody tr:last-child{border-bottom:none;}
.ctable tbody tr:hover{background:var(--s2);}
.ctable tbody td{padding:.875rem 1.375rem;vertical-align:middle;font-size:.8rem;}
.cust-cell{display:flex;align-items:center;gap:.625rem;}
.cust-ava{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:.66rem;color:#fff;flex-shrink:0;}
.cust-name{font-weight:600;color:var(--t1);font-size:.825rem;}
.cust-email{font-size:.69rem;color:var(--tm);margin-top:1px;}
.muted{font-size:.78rem;color:var(--tm);}
.orders-cnt{font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;color:var(--teal);font-size:.825rem;text-align:center;}
.badge{display:inline-flex;align-items:center;gap:.22rem;padding:.18rem .55rem;border-radius:20px;font-size:.64rem;font-weight:600;}
.badge::before{content:'';width:4px;height:4px;border-radius:50%;flex-shrink:0;}
.badge.active{background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.28);color:var(--teal);}.badge.active::before{background:var(--teal);animation:pulse 2s infinite;}
.badge.inactive{background:var(--s3);border:1.5px solid var(--bdr);color:var(--tm);}.badge.inactive::before{background:var(--tm);}
.act-wrap{display:flex;align-items:center;gap:.3rem;justify-content:flex-end;}
.act-btn{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;border:1.5px solid var(--bdr);background:var(--s);color:var(--tm);text-decoration:none;transition:all .15s;cursor:pointer;}
.act-btn.view:hover{border-color:rgba(31,122,108,.32);background:var(--teal-soft);color:var(--teal);}
.act-btn.del:hover{border-color:rgba(180,56,64,.28);background:var(--rose-soft);color:var(--rose);}

.empty-state{padding:3.5rem 2rem;text-align:center;}
.empty-icon{width:52px;height:52px;border-radius:16px;background:var(--gold-soft);display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.9rem;font-weight:700;color:var(--t2);margin-bottom:.3rem;}
.empty-sub{font-size:.8rem;color:var(--tm);}

/* PAGINATION */
.pagi{display:flex;align-items:center;justify-content:space-between;padding:.875rem 1.375rem;border-top:1px solid var(--bdr);background:var(--s2);flex-wrap:wrap;gap:.5rem;}
.pagi-info{font-size:.74rem;color:var(--tm);}
.pagi-links{display:flex;gap:.28rem;flex-wrap:wrap;}
.pagi-links a,.pagi-links span{display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:28px;padding:0 .4rem;border-radius:7px;font-size:.76rem;font-weight:600;border:1.5px solid var(--bdr);background:var(--s);color:var(--t2);text-decoration:none;transition:all .15s;}
.pagi-links a:hover{border-color:rgba(192,120,40,.3);background:var(--gold-soft);color:var(--gold);}
.pagi-links span.active{background:var(--gold);border-color:var(--gold);color:#fff;}
.pagi-links span.disabled{opacity:.38;pointer-events:none;}

@media(max-width:768px){.toolbar{padding:1.125rem 1rem 0;}.panel{margin:1rem 1rem 0;}.ctable thead th,.ctable td{padding:.625rem .875rem;}}
</style>
@endpush

@section('content')

@php
$totalCount=method_exists($customers,'total')?$customers->total():$customers->count();
$verifiedCount=$customers->filter(fn($c)=>!is_null($c->email_verified_at))->count();
@endphp

<div class="pg">
    <div class="cust-hero">
        <div class="cust-hero-left">
            <div class="cust-hero-pill"><span class="cust-hero-dot"></span> People</div>
            <div class="cust-hero-title">Customer <em>Directory</em></div>
            <div class="cust-hero-sub">Manage and view all registered customers.</div>
        </div>
        <div class="cust-hero-right">
            <div class="hero-stat"><div class="hero-stat-val">{{ $totalCount }}</div><div class="hero-stat-lbl">Total</div></div>
            <div class="hero-stat"><div class="hero-stat-val">{{ $verifiedCount }}</div><div class="hero-stat-lbl">Verified</div></div>
        </div>
    </div>

    <div class="toolbar">
        <form method="GET" action="{{ route('customers.index') }}" style="display:flex;align-items:center;gap:.5rem;flex:1;flex-wrap:wrap;">
            <div class="search-wrap">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input class="search-input" type="text" name="search" placeholder="Search by name or email…" value="{{ request('search') }}">
            </div>
            <select class="filter-select" name="status" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
            </select>
            <button type="submit" class="btn-search">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Search
            </button>
            @if(request('search')||request('status'))
            <a href="{{ route('customers.index') }}" class="btn-clear">Clear</a>
            @endif
        </form>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div class="panel-title"><div class="pdot"></div> All Customers</div>
            <span class="head-count">{{ $totalCount }} records</span>
        </div>

        @if($customers->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
            <div class="empty-title">No customers found</div>
            <div class="empty-sub">{{ request('search')?'Try a different search term.':'No customers have registered yet.' }}</div>
        </div>
        @else
        <table class="ctable">
            <thead><tr><th>Customer</th><th>Phone</th><th>Joined</th><th class="c">Requests</th><th class="c">Status</th><th class="r">Actions</th></tr></thead>
            <tbody>
                @php $grads=['linear-gradient(135deg,#B8782A,#E0A048)','linear-gradient(135deg,#1E6860,#38B090)','linear-gradient(135deg,#883030,#B05858)','linear-gradient(135deg,#503820,#906040)','linear-gradient(135deg,#283880,#5070C8)','linear-gradient(135deg,#603878,#A060C0)']; @endphp
                @foreach($customers as $customer)
                @php
                    $bg=$grads[$loop->index%6];
                    $firstName=$customer->first_name??'';$lastName=$customer->last_name??'';
                    $fullName=trim($firstName.' '.$lastName)?:($customer->name??'Unknown');
                    $initials=strtoupper(substr($firstName,0,1).substr($lastName,0,1))?:'?';
                    $status=$customer->email_verified_at?'active':'inactive';
                    $reqCount=$customer->cakeRequests?$customer->cakeRequests->count():0;
                @endphp
                <tr>
                    <td>
                        <div class="cust-cell">
                            <div class="cust-ava" style="background:{{ $bg }}">{{ $initials }}</div>
                            <div><div class="cust-name">{{ $fullName }}</div><div class="cust-email">{{ $customer->email }}</div></div>
                        </div>
                    </td>
                    <td><span class="muted">{{ $customer->phone ?? '—' }}</span></td>
                    <td><span class="muted">{{ $customer->created_at->format('M d, Y') }}</span></td>
                    <td class="orders-cnt">{{ $reqCount }}</td>
                    <td style="text-align:center;"><span class="badge {{ $status }}">{{ ucfirst($status) }}</span></td>
                    <td>
                        <div class="act-wrap">
                            @if(Route::has('customers.show'))
                            <a href="{{ route('customers.show',$customer->id) }}" class="act-btn view" title="View">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @endif
                            @if(Route::has('customers.destroy'))
                            <form method="POST" action="{{ route('customers.destroy',$customer->id) }}" onsubmit="return confirm('Delete this customer?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn del" title="Delete">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if(method_exists($customers,'hasPages')&&$customers->hasPages())
        <div class="pagi">
            <span class="pagi-info">Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }} of {{ $customers->total() }}</span>
            <div class="pagi-links">
                @if($customers->onFirstPage())<span class="disabled">‹</span>@else<a href="{{ $customers->previousPageUrl() }}">‹</a>@endif
                @foreach($customers->getUrlRange(1,$customers->lastPage()) as $page=>$url)
                    @if($page==$customers->currentPage())<span class="active">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif
                @endforeach
                @if($customers->hasMorePages())<a href="{{ $customers->nextPageUrl() }}">›</a>@else<span class="disabled">›</span>@endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

@endsection