@extends('layouts.admin')
@section('title', 'User Reports')

@push('styles')
<style>
/* BakeSphere Admin · Moderation Overview (scoped: .rx) */
.rx, .rx * { font-family:'Plus Jakarta Sans',sans-serif; box-sizing:border-box; }
.rx {
    --espresso:#24150F; --chocolate:#3A241A; --ivory:#F7F2E9; --cream:#EFE6D7;
    --caramel:#A96F42; --gold:#B89452; --burgundy:#54252C; --taupe:#9A897A; --beige:#D8C8B7;
    --ok:#2F6B4F; --ok-bg:#E6EFE8; --warn:#8A6417; --warn-bg:#F6ECD3;
    --bad:#54252C; --bad-bg:#F1E2E1; --info:#33566F; --info-bg:#E2EAF0;
    --line:#E2D6C4; --ink:#24150F; --ink-2:#5C4738;
    background:var(--ivory); color:var(--ink); font-variant-numeric:tabular-nums; min-height:100%;
}
.rx svg { width:1em; height:1em; flex-shrink:0; }

/* HERO */
.rx-hero { background:var(--espresso); color:var(--ivory); padding:2.25rem 2.25rem 2rem; border-bottom:3px solid var(--gold); }
.rx-hero-in { display:flex; justify-content:space-between; align-items:flex-end; gap:1.5rem; flex-wrap:wrap; max-width:1400px; margin:0 auto; }
.rx-kicker { font-size:.66rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--gold); margin-bottom:.6rem; }
.rx-title { font-size:2.1rem; font-weight:800; letter-spacing:-.035em; line-height:1.05; margin:0 0 .5rem; color:#fff; }
.rx-sub { font-size:.86rem; color:rgba(247,242,233,.62); max-width:46ch; line-height:1.6; margin:0; }
.rx-live { display:inline-flex; align-items:center; gap:.55rem; padding:.5rem .9rem; border:1px solid rgba(184,148,82,.45); font-size:.72rem; font-weight:600; color:var(--ivory); border-radius:4px; }
.rx-live svg { color:var(--gold); font-size:1rem; }
.rx-live b { color:var(--gold); font-weight:800; }

.rx-body { padding:0 0 4rem; }
.rx-body > .rx-filter:first-child { margin-top:3.25rem !important; }

/* METRICS STRIP */
.rx-metrics { display:grid; grid-template-columns:repeat(4,1fr); background:#fff; border:1px solid var(--line); border-top:3px solid var(--chocolate); margin-bottom:1.5rem; }
.rx-m { padding:1.15rem 1.4rem 1.1rem; border-right:1px solid var(--line); }
.rx-m:last-child { border-right:none; }
.rx-m-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:.7rem; }
.rx-m-lbl { font-size:.68rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--taupe); }
.rx-m-ico { font-size:1.05rem; }
.rx-m-val { font-size:2.35rem; font-weight:800; letter-spacing:-.04em; line-height:1; color:var(--espresso); }
.rx-m-note { font-size:.72rem; color:var(--taupe); margin-top:.45rem; }
.rx-m.is-pending .rx-m-ico, .rx-m.is-pending .rx-m-val { color:var(--burgundy); }
.rx-m.is-resolved .rx-m-ico, .rx-m.is-resolved .rx-m-val { color:var(--ok); }
.rx-m.is-review .rx-m-ico, .rx-m.is-review .rx-m-val { color:var(--info); }
.rx-m.is-total .rx-m-ico { color:var(--gold); }

/* FILTER TOOLBAR */
.rx-filter { background:var(--cream); border:1px solid var(--line); padding:1rem 1.25rem 1.1rem; margin-bottom:1.5rem; }
.rx-filter-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:.8rem; gap:1rem; }
.rx-filter-ttl { display:flex; align-items:center; gap:.5rem; font-size:.7rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:var(--chocolate); }
.rx-count { font-size:.76rem; color:var(--ink-2); font-weight:600; }
.rx-count b { color:var(--espresso); font-weight:800; }
.rx-filter-row { display:flex; gap:.9rem; flex-wrap:wrap; align-items:flex-end; }
.rx-field { display:flex; flex-direction:column; gap:.35rem; min-width:190px; flex:1 1 190px; max-width:280px; }
.rx-field label { font-size:.66rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-2); }
.rx-select { width:100%; padding:.6rem 2rem .6rem .8rem; border:1px solid var(--beige); border-radius:4px; font-size:.84rem; color:var(--ink); background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%239A897A'%3E%3Cpath d='M5.2 7.5 10 12.3l4.8-4.8 1.1 1.1L10 14.5 4.1 8.6z'/%3E%3C/svg%3E") no-repeat right .55rem center/1rem; appearance:none; cursor:pointer; }
.rx-select:focus, .rx-btn:focus-visible, .rx-clear:focus-visible, .rx-view:focus-visible { outline:2px solid var(--gold); outline-offset:2px; }
.rx-actions { display:flex; align-items:center; gap:.9rem; }
.rx-btn { display:inline-flex; align-items:center; gap:.45rem; padding:.62rem 1.2rem; background:var(--espresso); color:var(--ivory); border:1px solid var(--espresso); border-radius:4px; font-size:.8rem; font-weight:700; cursor:pointer; transition:background .15s; }
.rx-btn:hover { background:var(--chocolate); }
.rx-clear { display:inline-flex; align-items:center; gap:.3rem; font-size:.78rem; font-weight:600; color:var(--ink-2); text-decoration:none; padding:.3rem .2rem; }
.rx-clear:hover { color:var(--burgundy); }

/* TABLE */
.rx-panel { background:#fff; border:1px solid var(--line); }
.rx-panel-top { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid var(--line); }
.rx-panel-ttl { font-size:.98rem; font-weight:800; letter-spacing:-.01em; color:var(--espresso); margin:0; }
.rx-total { font-size:.7rem; font-weight:700; color:var(--chocolate); background:var(--cream); border:1px solid var(--beige); padding:.2rem .65rem; border-radius:3px; }
.rx-table { width:100%; border-collapse:collapse; }
.rx-table thead th { padding:.75rem 1.25rem; text-align:left; font-size:.64rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--taupe); background:var(--ivory); border-bottom:1px solid var(--line); white-space:nowrap; }
.rx-table tbody tr { border-bottom:1px solid #EFE6D7; transition:background .12s; }
.rx-table tbody tr:last-child { border-bottom:none; }
.rx-table tbody tr:hover { background:#FBF8F2; }
.rx-table tbody td { padding:1.05rem 1.25rem; font-size:.84rem; vertical-align:middle; }
.rx-id { font-weight:800; color:var(--caramel); letter-spacing:.01em; }
.rx-user { display:flex; align-items:center; gap:.65rem; min-width:0; }
.rx-av { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.76rem; font-weight:700; color:#fff; overflow:hidden; flex-shrink:0; }
.rx-av img { width:100%; height:100%; object-fit:cover; }
.rx-av.is-reporter { background:var(--espresso); }
.rx-av.is-reported { background:var(--caramel); }
.rx-role-tag { font-size:.6rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--taupe); display:block; margin-bottom:.1rem; }
.rx-name { font-weight:700; font-size:.82rem; color:var(--espresso); line-height:1.25; }
.rx-role { font-size:.7rem; color:var(--ink-2); }
.rx-cat { display:inline-flex; padding:.22rem .6rem; border:1px solid var(--beige); background:var(--ivory); border-radius:3px; font-size:.7rem; font-weight:600; color:var(--chocolate); }
.rx-order { display:inline-flex; align-items:center; gap:.35rem; font-size:.78rem; font-weight:700; color:var(--espresso); }
.rx-order svg { color:var(--taupe); }
.rx-none { color:var(--taupe); }
.rx-date { font-size:.78rem; color:var(--ink-2); white-space:nowrap; }
.rx-pill { display:inline-flex; align-items:center; gap:.35rem; padding:.24rem .65rem; border-radius:3px; font-size:.7rem; font-weight:700; white-space:nowrap; border:1px solid transparent; }
.rx-pill-pending { background:var(--warn-bg); color:var(--warn); border-color:#E5D29B; }
.rx-pill-reviewed { background:var(--info-bg); color:var(--info); border-color:#BCCCD8; }
.rx-pill-resolved { background:var(--ok-bg); color:var(--ok); border-color:#B9D2C3; }
.rx-pill-dismissed { background:var(--cream); color:var(--taupe); border-color:var(--beige); }
.rx-view { display:inline-flex; align-items:center; gap:.4rem; padding:.42rem .8rem; border:1px solid var(--chocolate); color:var(--chocolate); border-radius:4px; font-size:.74rem; font-weight:700; text-decoration:none; white-space:nowrap; transition:all .15s; }
.rx-view:hover { background:var(--chocolate); color:var(--ivory); }
.rx-empty td { text-align:center; padding:3.5rem 1rem !important; color:var(--taupe); }
.rx-empty svg { display:block; margin:0 auto .6rem; font-size:1.6rem; }
.rx-pages { margin-top:1.25rem; }

/* RESPONSIVE */
@media (max-width:980px) {
    .rx-metrics { grid-template-columns:repeat(2,1fr); }
    .rx-m:nth-child(2) { border-right:none; }
    .rx-m:nth-child(-n+2) { border-bottom:1px solid var(--line); }
}
@media (max-width:820px) {
    .rx-body { padding-left:0; padding-right:0; }
    .rx-table thead { position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0); }
    .rx-table, .rx-table tbody, .rx-table tr, .rx-table td { display:block; width:100%; }
    .rx-table tbody tr { padding:.9rem 1.1rem; }
    .rx-table tbody td { padding:.4rem 0; display:flex; align-items:center; justify-content:space-between; gap:1rem; }
    .rx-table tbody td::before { content:attr(data-label); font-size:.62rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--taupe); flex-shrink:0; }
    .rx-table tbody td[data-label=""]::before { display:none; }
    .rx-empty td { display:block; }
    .rx-empty td::before { display:none; }
    .rx-field { max-width:none; flex:1 1 100%; }
    .rx-actions { width:100%; }
}
@media (max-width:480px) { .rx-metrics { grid-template-columns:1fr; } .rx-m { border-right:none; border-bottom:1px solid var(--line); } .rx-m:last-child { border-bottom:none; } }
/* animations */
@keyframes rx-rise { from{opacity:0;transform:translatey(12px)} to{opacity:1;transform:none} }
@keyframes rx-fade { from{opacity:0} to{opacity:1} }
.rx-filter { animation:rx-rise .5s ease both; }
.rx-panel { animation:rx-rise .55s .12s ease both; }
.rx-table tbody tr { animation:rx-fade .5s .3s ease both; }
.rx-pages { animation:rx-fade .5s .4s ease both; }
.rx-pill, .rx-cat { transition:transform .15s; }
.rx-table tbody tr:hover .rx-pill { transform:translatey(-1px); }
@media (prefers-reduced-motion:reduce) { .rx * { transition:none !important; animation:none !important; } }
</style>
@endpush

@section('content')

@php
    $statTotal    = \App\Models\Report::count();
    $statPending  = \App\Models\Report::where('status','pending')->count();
    $statResolved = \App\Models\Report::where('status','resolved')->count();
    $statReviewed = \App\Models\Report::where('status','reviewed')->count();
@endphp
<div class="rx ah-page">

<div class="ah-top">
<header class="ah-hero">
    <div class="ah-hero-main">
        <span class="ah-hero-mark"><svg class="ah-ic" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>
        <div>
            <div class="ah-eyebrow">BakeSphere &middot; Moderation</div>
            <h1 class="ah-title">User Reports</h1>
            <p class="ah-subtitle">Review customer and baker reports, investigate disputes, and manage resolution actions.</p>
        </div>
    </div>
    <div class="ah-side">
        <span class="ah-side-label"><span class="ah-dot"></span>Moderation queue</span>
        <span class="ah-side-value">{{ $statPending }} awaiting action</span>
    </div>
</header>
<section class="ah-ledger" aria-label="Report metrics">
    <div class="ah-fig"><div class="ah-fig-lbl">Total Reports</div><div class="ah-fig-val">{{ $statTotal }}</div><div class="ah-fig-note">All filed cases</div></div>
    <div class="ah-fig ah-fig--burgundy"><div class="ah-fig-lbl">Pending</div><div class="ah-fig-val">{{ $statPending }}</div><div class="ah-fig-note">Needs attention</div></div>
    <div class="ah-fig ah-fig--sage"><div class="ah-fig-lbl">Resolved</div><div class="ah-fig-val">{{ $statResolved }}</div><div class="ah-fig-note">Closed with a decision</div></div>
    <div class="ah-fig ah-fig--caramel"><div class="ah-fig-lbl">Under Review</div><div class="ah-fig-val">{{ $statReviewed }}</div><div class="ah-fig-note">Being investigated</div></div>
</section>
</div>

<div class="rx-body">

        {{-- FILTERS (server-side GET) --}}
        <form method="GET" action="{{ route('admin.reports.index') }}" class="rx-filter">
            <div class="rx-filter-head">
                <div class="rx-filter-ttl">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M3 4.5h14l-5.3 6.2v4.6l-3.4 1.7v-6.3z" stroke-linejoin="round"/></svg>
                    Filter Reports
                </div>
                <span class="rx-count" role="status">Results: <b>{{ $reports->total() }}</b> result{{ $reports->total() !== 1 ? 's' : '' }}</span>
            </div>
            <div class="rx-filter-row">
                <div class="rx-field">
                    <label for="f-status">Status</label>
                    <select id="f-status" name="status" class="rx-select">
                        <option value="">All Statuses</option>
                        @foreach(['pending','reviewed','resolved','dismissed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rx-field">
                    <label for="f-role">Reporter Role</label>
                    <select id="f-role" name="role" class="rx-select">
                        <option value="">All Reporter Roles</option>
                        <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="baker"    {{ request('role') === 'baker'    ? 'selected' : '' }}>Baker</option>
                    </select>
                </div>
                <div class="rx-field">
                    <label for="f-category">Category</label>
                    <select id="f-category" name="category" class="rx-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ strip_tags($label) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rx-actions">
                    <button type="submit" class="rx-btn">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Apply Filters
                    </button>
                    @if(request()->hasAny(['status','role','category']))
                    <a href="{{ route('admin.reports.index') }}" class="rx-clear">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 5 10 10M15 5 5 15" stroke-linecap="round"/></svg>
                        Clear
                    </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="rx-panel">
            <div class="rx-panel-top">
                <h2 class="rx-panel-ttl">All Reports</h2>
                <span class="rx-total">{{ $reports->total() }} total</span>
            </div>
            <table class="rx-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Reporter</th>
                        <th scope="col">Reported</th>
                        <th scope="col">Category</th>
                        <th scope="col">Order</th>
                        <th scope="col">Status</th>
                        <th scope="col">Submitted</th>
                        <th scope="col"><span class="sr-only" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    @php $st = $report->status ?? 'pending'; @endphp
                    <tr>
                        <td data-label="#"><span class="rx-id">#{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                        <td data-label="Reporter">
                            <div class="rx-user">
                                <div class="rx-av is-reporter">
                                    @if($report->reporter?->profile_photo)
                                        <img src="{{ asset('storage/'.$report->reporter->profile_photo) }}" alt="">
                                    @else
                                        {{ strtoupper(substr($report->reporter?->first_name ?? '?', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <span class="rx-role-tag">Reporter</span>
                                    <div class="rx-name">{{ $report->reporter?->first_name }} {{ $report->reporter?->last_name }}</div>
                                    <div class="rx-role">{{ ucfirst($report->reporter_role ?? '—') }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Reported">
                            <div class="rx-user">
                                <div class="rx-av is-reported">
                                    @if($report->reported?->profile_photo)
                                        <img src="{{ asset('storage/'.$report->reported->profile_photo) }}" alt="">
                                    @else
                                        {{ strtoupper(substr($report->reported?->first_name ?? '?', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <span class="rx-role-tag">Reported User</span>
                                    <div class="rx-name">{{ $report->reported?->first_name }} {{ $report->reported?->last_name }}</div>
                                    <div class="rx-role">{{ $report->reported?->role ? ucfirst($report->reported->role) : '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Category">
                            <span class="rx-cat">{{ ucwords(str_replace('_', ' ', $report->category ?? '—')) }}</span>
                        </td>
                        <td data-label="Order">
                            @if($report->bakerOrder)
                                <span class="rx-order">
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 6.5 10 3l6 3.5v7L10 17l-6-3.5z" stroke-linejoin="round"/><path d="m4 6.5 6 3.5 6-3.5M10 10v7"/></svg>
                                    #{{ str_pad($report->bakerOrder->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            @else
                                <span class="rx-none">—</span>
                            @endif
                        </td>
                        <td data-label="Status">
                            <span class="rx-pill rx-pill-{{ $st }}">
                                @if($st === 'pending')
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path d="M10 5.8V10l2.8 1.8" stroke-linecap="round"/></svg>
                                @elseif($st === 'reviewed')
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="9" r="5.5"/><path d="m13.2 13.2 4 4" stroke-linecap="round"/></svg>
                                @elseif($st === 'resolved')
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @else
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 5 10 10M15 5 5 15" stroke-linecap="round"/></svg>
                                @endif
                                {{ ucfirst($st) }}
                            </span>
                        </td>
                        <td data-label="Submitted"><span class="rx-date">{{ $report->created_at->format('M d, Y') }}</span></td>
                        <td data-label="">
                            @if(Route::has('admin.reports.show'))
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="rx-view">
                                View Report
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="rx-empty"><td colspan="8">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M5 2.5h7l3 3v12H5z"/><path d="M12 2.5v3h3"/></svg>
                        No reports found.
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
        <div class="rx-pages">{{ $reports->withQueryString()->links() }}</div>
        @endif

    </div>
</div>
@endsection