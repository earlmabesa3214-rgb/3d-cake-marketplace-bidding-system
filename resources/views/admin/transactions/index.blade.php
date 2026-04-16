@extends('layouts.admin')
@section('title', 'Transactions')

@push('styles')
<style>
:root {
    --gold:#C07828; --gold-light:#DC9E48; --gold-soft:#FEF3E2;
    --teal:#1F7A6C; --teal-soft:#E4F2EF;
    --rose:#B43840; --rose-soft:#FDEAEB;
    --espresso:#2C1608; --mocha:#6A4824;
    --t1:#1E0E04; --t2:#4A2C14; --tm:#8C6840;
    --border:#E8E0D0; --bdr-md:#D8CCBA;
    --surface:#FFF; --surface-2:#FAF7F2; --surface-3:#F2ECE2;
    --r:10px; --rl:14px; --rxl:18px;
}

@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
@keyframes pulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(.7);opacity:.4}}

/* HERO */
.tx-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem;position:relative;overflow:hidden;}
.tx-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.tx-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.tx-hero-inner{position:relative;z-index:1;}
.tx-hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.tx-hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.tx-hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.tx-hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.tx-hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}

.tx-body{padding:1.5rem 2rem 4rem;}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-bottom:1.5rem;animation:fadeUp .4s ease both;}
.stat-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rl);padding:1rem 1.25rem;text-align:center;position:relative;overflow:hidden;}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--gold-light));}
.stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.75rem;color:var(--espresso);line-height:1;font-weight:700;}
.stat-label{font-size:.63rem;text-transform:uppercase;letter-spacing:.1em;color:var(--tm);margin-top:.3rem;font-weight:600;}

/* FILTERS */
.filter-bar{display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rl);padding:.85rem 1.25rem;margin-bottom:1.5rem;}
.filter-input{padding:.45rem .85rem;border:1.5px solid var(--border);border-radius:var(--r);font-size:.82rem;font-family:'Plus Jakarta Sans',sans-serif;color:var(--t1);background:white;flex:1;min-width:180px;}
.filter-input:focus{outline:none;border-color:var(--gold);}
.filter-select{padding:.45rem .85rem;border:1.5px solid var(--border);border-radius:var(--r);font-size:.82rem;color:var(--t1);background:white;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;}
.filter-select:focus{outline:none;border-color:var(--gold);}
.filter-btn{padding:.45rem 1.1rem;background:linear-gradient(135deg,var(--gold-light),var(--gold));color:white;border:none;border-radius:var(--r);font-size:.82rem;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;}
.filter-clear{font-size:.78rem;color:var(--tm);text-decoration:none;}
.filter-clear:hover{color:var(--gold);}

/* TABLE */
.table-wrap{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rxl);overflow:hidden;}
.table-top{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1.5px solid var(--border);background:var(--surface-2);}
.table-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.95rem;color:var(--espresso);font-weight:700;}
.table-count{font-size:.72rem;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.22);border-radius:20px;padding:.18rem .65rem;color:#9A5E14;font-weight:700;}

.tx-table{width:100%;border-collapse:collapse;}
.tx-table thead th{padding:.75rem 1.25rem;text-align:left;font-size:.63rem;text-transform:uppercase;letter-spacing:.12em;color:var(--tm);font-weight:700;background:var(--surface-3);border-bottom:1.5px solid var(--border);}
.tx-table thead th.r{text-align:right;}
.tx-table tbody tr{border-bottom:1px solid var(--border);transition:background .12s;}
.tx-table tbody tr:last-child{border-bottom:none;}
.tx-table tbody tr:hover{background:var(--surface-2);}
.tx-table tbody td{padding:.9rem 1.25rem;font-size:.82rem;color:var(--t1);vertical-align:middle;}

/* USER CELL */
.user-cell{display:flex;align-items:center;gap:.55rem;}
.u-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#C07840,#E8A96A);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.72rem;flex-shrink:0;overflow:hidden;}
.u-avatar img{width:100%;height:100%;object-fit:cover;}
.u-name{font-weight:600;font-size:.8rem;color:var(--espresso);}
.u-email{font-size:.68rem;color:var(--tm);margin-top:.1rem;}

/* STATUS PILLS */
.status-pill{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:20px;font-size:.68rem;font-weight:700;white-space:nowrap;}
.pill-ACCEPTED{background:#FEF9E8;color:#9B6A10;border:1px solid #EDD090;}
.pill-WAITING_FOR_PAYMENT{background:#FEF2E4;color:#8A4010;border:1px solid #E8C080;}
.pill-PREPARING{background:#EBF3FE;color:#1A5A8A;border:1px solid #B8D4F0;}
.pill-READY{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.3);}
.pill-WAITING_FINAL_PAYMENT{background:#FEF9E8;color:#9B6A10;border:1px solid #EDD090;}
.pill-DELIVERED{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.3);}
.pill-COMPLETED{background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.3);}
.pill-CANCELLED{background:var(--rose-soft);color:var(--rose);border:1px solid rgba(180,56,64,.3);}

/* PAYMENT */
.pay-paid{display:inline-flex;align-items:center;gap:.2rem;font-size:.68rem;font-weight:600;color:var(--teal);}
.pay-pending{font-size:.68rem;font-weight:600;color:#9B6A10;}
.pay-none{font-size:.68rem;color:var(--tm);}
.pay-rejected{font-size:.68rem;font-weight:600;color:var(--rose);}

.view-btn{display:inline-flex;align-items:center;gap:.3rem;padding:.32rem .75rem;border-radius:var(--r);font-size:.73rem;font-weight:600;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.3);color:#9A5E14;text-decoration:none;transition:all .15s;}
.view-btn:hover{background:var(--gold);color:white;border-color:var(--gold);}

.empty-row td{text-align:center;padding:3rem;color:var(--tm);font-size:.85rem;}
</style>
@endpush

@section('content')

<div class="tx-hero">
    <div class="tx-hero-inner">
        <div class="tx-hero-pill"><span class="tx-hero-dot"></span> Live Overview</div>
        <div class="tx-hero-title"><em>Transactions</em> & Orders</div>
        <div class="tx-hero-sub">All orders happening between customers and bakers</div>
    </div>
</div>

<div class="tx-body">

{{-- STATS --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-num">{{ $stats['total'] }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:#1A5A8A;">{{ $stats['active'] }}</div>
        <div class="stat-label">Active</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:var(--teal);">{{ $stats['completed'] }}</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:var(--rose);">{{ $stats['cancelled'] }}</div>
        <div class="stat-label">Cancelled</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="color:var(--gold);font-size:1.3rem;">₱{{ number_format($stats['revenue'], 0) }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
</div>

{{-- FILTERS --}}
<form method="GET" action="{{ route('admin.transactions.index') }}">
    <div class="filter-bar">
        <input type="text" name="search" class="filter-input"
               placeholder="Search by customer or baker name…"
               value="{{ request('search') }}">
        <select name="status" class="filter-select">
            <option value="">All Statuses</option>
            @foreach(['ACCEPTED','WAITING_FOR_PAYMENT','PREPARING','READY','WAITING_FINAL_PAYMENT','DELIVERED','COMPLETED','CANCELLED'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                {{ str_replace('_', ' ', $s) }}
            </option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn">Filter</button>
        @if(request()->hasAny(['status','search']))
        <a href="{{ route('admin.transactions.index') }}" class="filter-clear">✕ Clear</a>
        @endif
        <span style="margin-left:auto;font-size:.78rem;color:var(--tm);">
            {{ $transactions->total() }} result{{ $transactions->total() !== 1 ? 's' : '' }}
        </span>
    </div>
</form>

{{-- TABLE --}}
<div class="table-wrap">
    <div class="table-top">
        <span class="table-title">All Transactions</span>
        <span class="table-count">{{ $transactions->total() }} orders</span>
    </div>
    <table class="tx-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Baker</th>
                <th>Cake</th>
                <th>Status</th>
                <th>Downpayment</th>
                <th>Final Payment</th>
                <th class="r">Agreed Price</th>
                <th>Delivery Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
            @php
                $config = is_array($tx->cakeRequest->cake_configuration)
                    ? $tx->cakeRequest->cake_configuration
                    : (json_decode($tx->cakeRequest->cake_configuration, true) ?? []);
                $downpayment  = $tx->cakeRequest->payments->where('payment_type','downpayment')->first();
                $finalPayment = $tx->cakeRequest->payments->where('payment_type','final')->first();
            @endphp
            <tr>
                <td style="font-weight:700;color:var(--gold);font-family:'Plus Jakarta Sans',sans-serif;">
                    #{{ str_pad($tx->id, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td>
                    <div class="user-cell">
                        <div class="u-avatar">
                            @if($tx->cakeRequest->user->profile_photo)
                                <img src="{{ asset('storage/'.$tx->cakeRequest->user->profile_photo) }}" alt="">
                            @else
                                {{ strtoupper(substr($tx->cakeRequest->user->first_name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="u-name">{{ $tx->cakeRequest->user->first_name }} {{ $tx->cakeRequest->user->last_name }}</div>
                            <div class="u-email">{{ $tx->cakeRequest->user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="user-cell">
                        <div class="u-avatar" style="background:linear-gradient(135deg,var(--espresso),var(--mocha));">
                            @if($tx->baker->profile_photo)
                                <img src="{{ asset('storage/'.$tx->baker->profile_photo) }}" alt="">
                            @else
                                {{ strtoupper(substr($tx->baker->first_name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="u-name">{{ $tx->baker->first_name }} {{ $tx->baker->last_name }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:.78rem;">
                    {{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}
                    @if(!empty($config['size']))
                    <span style="color:var(--tm);">· {{ $config['size'] }}</span>
                    @endif
                </td>
                <td>
                    <span class="status-pill pill-{{ $tx->status }}">
                        {{ str_replace('_', ' ', $tx->status) }}
                    </span>
                </td>
                <td>
                    @if($downpayment)
                        @if($downpayment->status === 'paid' || $downpayment->status === 'confirmed')
                            <span class="pay-paid">✓ Paid</span>
                        @elseif($downpayment->status === 'rejected')
                            <span class="pay-rejected">✕ Rejected</span>
                        @else
                            <span class="pay-pending">⏳ Pending</span>
                        @endif
                    @else
                        <span class="pay-none">—</span>
                    @endif
                </td>
                <td>
                    @if($finalPayment)
                        @if($finalPayment->status === 'paid' || $finalPayment->status === 'confirmed')
                            <span class="pay-paid">✓ Paid</span>
                        @elseif($finalPayment->status === 'rejected')
                            <span class="pay-rejected">✕ Rejected</span>
                        @else
                            <span class="pay-pending">⏳ Pending</span>
                        @endif
                    @else
                        <span class="pay-none">—</span>
                    @endif
                </td>
                <td class="r" style="font-weight:700;color:var(--espresso);font-family:'Plus Jakarta Sans',sans-serif;">
                    ₱{{ number_format($tx->agreed_price, 0) }}
                </td>
                <td style="font-size:.78rem;color:var(--tm);">
                    {{ $tx->cakeRequest->delivery_date->format('M d, Y') }}
                </td>
                <td>
                    <a href="{{ route('admin.transactions.show', $tx->id) }}" class="view-btn">View →</a>
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="10">No transactions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($transactions->hasPages())
<div style="margin-top:1.25rem;">{{ $transactions->withQueryString()->links() }}</div>
@endif

</div>
@endsection