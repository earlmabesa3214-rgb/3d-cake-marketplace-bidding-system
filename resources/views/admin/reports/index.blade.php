@extends('layouts.admin')
@section('title', 'User Reports')

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

.rpt-hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 50%,#5C2C10 100%);padding:2rem 2.25rem;position:relative;overflow:hidden;}
.rpt-hero::before{content:'';position:absolute;inset:0;opacity:.025;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:26px 26px;}
.rpt-hero::after{content:'';position:absolute;right:-50px;top:-50px;width:240px;height:240px;background:radial-gradient(circle,rgba(192,120,40,.16),transparent 65%);border-radius:50%;}
.hero-inner{position:relative;z-index:1;}
.hero-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.14);border-radius:20px;padding:.22rem .7rem;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.58);margin-bottom:.875rem;}
.hero-dot{width:5px;height:5px;border-radius:50%;background:var(--gold-light);animation:pulse 2s infinite;}
.hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.04em;color:#fff;line-height:1.1;margin-bottom:.4rem;}
.hero-title em{font-style:normal;background:linear-gradient(90deg,var(--gold-light),#F0C070);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero-sub{font-size:.8rem;color:rgba(255,255,255,.42);}

.rpt-body{padding:1.5rem 2rem 4rem;}

.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;animation:fadeUp .38s ease both;}
.scard{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rl);padding:1.1rem 1.3rem;position:relative;overflow:hidden;}
.scard::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
.scard.gold::before{background:linear-gradient(90deg,var(--gold),var(--gold-light));}
.scard.rose::before{background:linear-gradient(90deg,var(--rose),#D05060);}
.scard.teal::before{background:linear-gradient(90deg,var(--teal),#3BAA98);}
.scard.mocha::before{background:linear-gradient(90deg,var(--mocha),#A07040);}
.scard-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.6rem;font-weight:700;color:var(--t1);line-height:1;}
.scard-lbl{font-size:.63rem;text-transform:uppercase;letter-spacing:.1em;color:var(--tm);font-weight:700;margin-top:.3rem;}

.filter-bar{display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rl);padding:.85rem 1.25rem;margin-bottom:1.5rem;}
.filter-select{padding:.45rem .85rem;border:1.5px solid var(--border);border-radius:var(--r);font-size:.82rem;color:var(--t1);background:white;font-family:'DM Sans',sans-serif;cursor:pointer;}
.filter-select:focus{outline:none;border-color:var(--gold);}
.filter-btn{padding:.45rem 1.1rem;background:linear-gradient(135deg,var(--gold-light),var(--gold));color:white;border:none;border-radius:var(--r);font-size:.82rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;}
.filter-clear{font-size:.78rem;color:var(--tm);text-decoration:none;}
.filter-clear:hover{color:var(--rose);}
.filter-count{margin-left:auto;font-size:.75rem;color:var(--tm);font-family:'DM Mono',monospace;}

.table-wrap{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--rxl);overflow:hidden;animation:fadeUp .38s ease .1s both;}
.table-top{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1.5px solid var(--border);background:var(--surface-2);}
.table-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:.95rem;font-weight:700;color:var(--espresso);}
.table-badge{font-size:.7rem;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.22);border-radius:20px;padding:.18rem .65rem;color:#9A5E14;font-weight:700;}

.rpt-table{width:100%;border-collapse:collapse;}
.rpt-table thead th{padding:.7rem 1.25rem;text-align:left;font-size:.62rem;text-transform:uppercase;letter-spacing:.12em;color:var(--tm);font-weight:700;background:var(--surface-3);border-bottom:1.5px solid var(--border);}
.rpt-table tbody tr{border-bottom:1px solid var(--border);transition:background .12s;}
.rpt-table tbody tr:last-child{border-bottom:none;}
.rpt-table tbody tr:hover{background:var(--surface-2);}
.rpt-table tbody td{padding:.85rem 1.25rem;font-size:.82rem;color:var(--t1);vertical-align:middle;}

.user-cell{display:flex;align-items:center;gap:.5rem;}
.u-av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.68rem;color:#fff;flex-shrink:0;overflow:hidden;}
.u-av img{width:100%;height:100%;object-fit:cover;}
.u-name{font-weight:600;font-size:.78rem;color:var(--espresso);}
.u-role{font-size:.64rem;color:var(--tm);}

.pill{display:inline-flex;align-items:center;gap:.28rem;padding:.2rem .6rem;border-radius:20px;font-size:.67rem;font-weight:700;white-space:nowrap;}
.pill-pending   {background:#FEF9E8;color:#9B6A10;border:1px solid #EDD090;}
.pill-reviewed  {background:#EBF3FE;color:#1A5A8A;border:1px solid #B8D4F0;}
.pill-resolved  {background:var(--teal-soft);color:var(--teal);border:1px solid rgba(31,122,108,.3);}
.pill-dismissed {background:var(--surface-3);color:var(--tm);border:1px solid var(--bdr-md);}

.cat-tag{display:inline-flex;padding:.16rem .52rem;border-radius:6px;font-size:.66rem;font-weight:600;background:var(--gold-soft);color:#9A5E14;border:1px solid rgba(192,120,40,.2);}
.order-ref{font-family:'DM Mono',monospace;font-size:.72rem;font-weight:600;color:var(--espresso);}
.date-txt{font-size:.74rem;color:var(--tm);}
.view-btn{display:inline-flex;align-items:center;gap:.28rem;padding:.28rem .7rem;border-radius:var(--r);font-size:.72rem;font-weight:600;background:var(--gold-soft);border:1.5px solid rgba(192,120,40,.3);color:#9A5E14;text-decoration:none;transition:all .15s;}
.view-btn:hover{background:var(--gold);color:#fff;border-color:var(--gold);}
.empty-row td{text-align:center;padding:3.5rem;color:var(--tm);}

@media(max-width:900px){.stats-row{grid-template-columns:repeat(2,1fr);}.rpt-body{padding:1.25rem 1rem 3rem;}}
</style>
@endpush

@section('content')

@php
    $statTotal    = \App\Models\Report::count();
    $statPending  = \App\Models\Report::where('status','pending')->count();
    $statResolved = \App\Models\Report::where('status','resolved')->count();
    $statReviewed = \App\Models\Report::where('status','reviewed')->count();
@endphp

<div class="rpt-hero">
    <div class="hero-inner">
        <div class="hero-pill"><span class="hero-dot"></span> Moderation</div>
        <div class="hero-title"><em>User</em> Reports</div>
        <div class="hero-sub">Reports filed by customers and bakers against each other</div>
    </div>
</div>

<div class="rpt-body">

    <div class="stats-row">
        <div class="scard gold">
            <div class="scard-val">{{ $statTotal }}</div>
            <div class="scard-lbl">Total Reports</div>
        </div>
        <div class="scard rose">
            <div class="scard-val" style="color:var(--rose);">{{ $statPending }}</div>
            <div class="scard-lbl">Pending</div>
        </div>
        <div class="scard teal">
            <div class="scard-val" style="color:var(--teal);">{{ $statResolved }}</div>
            <div class="scard-lbl">Resolved</div>
        </div>
        <div class="scard mocha">
            <div class="scard-val" style="color:var(--mocha);">{{ $statReviewed }}</div>
            <div class="scard-lbl">Under Review</div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.reports.index') }}">
        <div class="filter-bar">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                @foreach(['pending','reviewed','resolved','dismissed'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <select name="role" class="filter-select">
                <option value="">All Reporter Roles</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="baker"    {{ request('role') === 'baker'    ? 'selected' : '' }}>Baker</option>
            </select>
            <button type="submit" class="filter-btn">Filter</button>
            @if(request()->hasAny(['status','role']))
            <a href="{{ route('admin.reports.index') }}" class="filter-clear">✕ Clear</a>
            @endif
            <span class="filter-count">
                {{ $reports->total() }} result{{ $reports->total() !== 1 ? 's' : '' }}
            </span>
        </div>
    </form>

    <div class="table-wrap">
        <div class="table-top">
            <span class="table-title">All Reports</span>
            <span class="table-badge">{{ $reports->total() }} total</span>
        </div>
        <table class="rpt-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reporter</th>
                    <th>Reported</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td style="font-family:'DM Mono',monospace;font-weight:700;color:var(--gold);">
                        #{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        <div class="user-cell">
                            <div class="u-av" style="background:linear-gradient(135deg,var(--espresso),var(--mocha));">
                                @if($report->reporter?->profile_photo)
                                    <img src="{{ asset('storage/'.$report->reporter->profile_photo) }}" alt="">
                                @else
                                    {{ strtoupper(substr($report->reporter?->first_name ?? '?', 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="u-name">{{ $report->reporter?->first_name }} {{ $report->reporter?->last_name }}</div>
                                <div class="u-role">{{ ucfirst($report->reporter_role ?? '—') }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="user-cell">
                            <div class="u-av" style="background:linear-gradient(135deg,#C07840,#E8A96A);">
                                @if($report->reported?->profile_photo)
                                    <img src="{{ asset('storage/'.$report->reported->profile_photo) }}" alt="">
                                @else
                                    {{ strtoupper(substr($report->reported?->first_name ?? '?', 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="u-name">{{ $report->reported?->first_name }} {{ $report->reported?->last_name }}</div>
                                <div class="u-role">{{ $report->reported?->role ? ucfirst($report->reported->role) : '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="cat-tag">{{ ucwords(str_replace('_', ' ', $report->category ?? '—')) }}</span>
                    </td>
                    <td>
                        @if($report->bakerOrder)
                            <span class="order-ref">#{{ str_pad($report->bakerOrder->id, 4, '0', STR_PAD_LEFT) }}</span>
                        @else
                            <span style="color:var(--tm);font-size:.74rem;">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="pill pill-{{ $report->status ?? 'pending' }}">
                            {{ ucfirst($report->status ?? 'pending') }}
                        </span>
                    </td>
                    <td><span class="date-txt">{{ $report->created_at->format('M d, Y') }}</span></td>
                    <td>
                        @if(Route::has('admin.reports.show'))
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="view-btn">View →</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="8">No reports found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reports->hasPages())
    <div style="margin-top:1.25rem;">{{ $reports->withQueryString()->links() }}</div>
    @endif

</div>
@endsection