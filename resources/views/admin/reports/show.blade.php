@extends('layouts.admin')
@section('title', 'Report #' . $report->id)

@push('styles')
<style>
/* BakeSphere Admin · Case Workspace (scoped: .rd) */
.rd, .rd * { font-family:'Plus Jakarta Sans',sans-serif; box-sizing:border-box; }
.rd {
    --espresso:#24150F; --chocolate:#3A241A; --ivory:#F7F2E9; --cream:#EFE6D7;
    --caramel:#A96F42; --gold:#B89452; --burgundy:#54252C; --taupe:#9A897A; --beige:#D8C8B7;
    --ok:#2F6B4F; --ok-bg:#E6EFE8; --ok-bd:#B9D2C3; --warn:#8A6417; --warn-bg:#F6ECD3; --warn-bd:#E5D29B;
    --bad:#54252C; --bad-bg:#F1E2E1; --bad-bd:#DDBFBD; --info:#33566F; --info-bg:#E2EAF0; --info-bd:#BCCCD8;
    --line:#E2D6C4; --ink:#24150F; --ink-2:#5C4738;
    background:var(--ivory); color:var(--ink); font-variant-numeric:tabular-nums; padding:1.5rem 2.25rem 4rem; max-width:1400px; margin:0 auto;
}
.rd svg { width:1em; height:1em; flex-shrink:0; }
.rd a:focus-visible, .rd button:focus-visible, .rd input:focus-visible, .rd select:focus-visible, .rd textarea:focus-visible { outline:2px solid var(--gold); outline-offset:2px; }

.rd-back { display:inline-flex; align-items:center; gap:.45rem; font-size:.78rem; font-weight:700; color:var(--ink-2); text-decoration:none; margin-bottom:1.1rem; }
.rd-back:hover { color:var(--caramel); }

/* HEADER */
.rd-head { background:var(--espresso); color:var(--ivory); border-bottom:3px solid var(--gold); padding:1.6rem 1.9rem; display:flex; justify-content:space-between; align-items:center; gap:1.5rem; flex-wrap:wrap; margin-bottom:1.5rem; }
.rd-head-l { display:flex; align-items:center; gap:1.1rem; }
.rd-head-ico { width:52px; height:52px; border:1px solid rgba(184,148,82,.55); display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:1.5rem; border-radius:4px; }
.rd-kicker { font-size:.64rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:var(--gold); }
.rd-id { font-size:1.9rem; font-weight:800; letter-spacing:-.03em; line-height:1.1; color:#fff; margin:.15rem 0 0; }
.rd-head-meta { display:flex; gap:2rem; flex-wrap:wrap; align-items:center; }
.rd-meta-k { font-size:.6rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:rgba(247,242,233,.5); margin-bottom:.25rem; }
.rd-meta-v { font-size:.84rem; font-weight:600; color:var(--ivory); }

/* PILLS */
.rd-pill { display:inline-flex; align-items:center; gap:.4rem; padding:.28rem .7rem; border-radius:3px; font-size:.72rem; font-weight:700; border:1px solid transparent; white-space:nowrap; }
.rd-pill-pending { background:var(--warn-bg); color:var(--warn); border-color:var(--warn-bd); }
.rd-pill-reviewed { background:var(--info-bg); color:var(--info); border-color:var(--info-bd); }
.rd-pill-resolved { background:var(--ok-bg); color:var(--ok); border-color:var(--ok-bd); }
.rd-pill-dismissed { background:var(--cream); color:var(--ink-2); border-color:var(--beige); }
.rd-pill-on_hold { background:var(--info-bg); color:var(--info); border-color:var(--info-bd); }
.rd-pill-approved { background:var(--ok-bg); color:var(--ok); border-color:var(--ok-bd); }
.rd-pill-rejected { background:var(--bad-bg); color:var(--bad); border-color:var(--bad-bd); }

.rd-flash { display:flex; align-items:center; gap:.6rem; background:var(--ok-bg); border:1px solid var(--ok-bd); color:var(--ok); padding:.8rem 1.1rem; font-size:.82rem; font-weight:600; margin-bottom:1.5rem; }

/* LAYOUT */
.rd-layout { display:grid; grid-template-columns:minmax(0,1fr) 340px; gap:1.5rem; align-items:start; }
.rd-col { display:flex; flex-direction:column; gap:1.5rem; min-width:0; }
.rd-aside { position:sticky; top:1rem; }

/* SECTIONS */
.rd-sec { background:#fff; border:1px solid var(--line); }
.rd-sec-h { display:flex; align-items:center; gap:.65rem; padding:.95rem 1.4rem; border-bottom:1px solid var(--line); }
.rd-sec-h svg { font-size:1.05rem; color:var(--caramel); }
.rd-sec-h h2 { margin:0; font-size:.72rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:var(--chocolate); }
.rd-sec.is-dark > .rd-sec-h { background:var(--espresso); border-bottom-color:var(--espresso); }
.rd-sec.is-dark > .rd-sec-h svg { color:var(--gold); }
.rd-sec.is-dark > .rd-sec-h h2 { color:var(--ivory); }

/* PARTIES */
.rd-parties { display:grid; grid-template-columns:1fr 1fr; }
.rd-party { padding:1.3rem 1.4rem; }
.rd-party + .rd-party { border-left:1px solid var(--line); }
.rd-party-lbl { font-size:.62rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; margin-bottom:.9rem; display:flex; align-items:center; gap:.4rem; }
.rd-party.is-reporter .rd-party-lbl { color:var(--chocolate); }
.rd-party.is-reported .rd-party-lbl { color:var(--burgundy); }
.rd-party-row { display:flex; gap:.9rem; align-items:center; }
.rd-av { width:46px; height:46px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:1rem; overflow:hidden; flex-shrink:0; }
.rd-av img { width:100%; height:100%; object-fit:cover; }
.is-reporter .rd-av { background:var(--espresso); }
.is-reported .rd-av { background:var(--caramel); }
.rd-p-name { font-weight:800; font-size:.92rem; color:var(--espresso); }
.rd-p-email { font-size:.76rem; color:var(--ink-2); word-break:break-all; margin-top:.15rem; }
.rd-p-role { display:inline-block; margin-top:.5rem; padding:.16rem .55rem; border:1px solid var(--beige); background:var(--ivory); border-radius:3px; font-size:.66rem; font-weight:700; color:var(--chocolate); }

/* CASE RECORD */
.rd-dl { margin:0; }
.rd-dr { display:grid; grid-template-columns:150px 1fr; gap:1rem; padding:.85rem 1.4rem; border-bottom:1px solid #EFE6D7; align-items:center; }
.rd-dr:last-child { border-bottom:none; }
.rd-dr dt { font-size:.66rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--taupe); }
.rd-dr dd { margin:0; font-size:.86rem; font-weight:600; color:var(--ink); }
.rd-order-ref { color:var(--caramel); font-weight:800; }

/* EVIDENCE */
.rd-text { padding:1.3rem 1.4rem; font-size:.9rem; line-height:1.75; color:var(--ink); white-space:pre-line; max-width:78ch; }
.rd-frame { margin:1.3rem 1.4rem; padding:.7rem; background:var(--ivory); border:1px solid var(--beige); }
.rd-frame img { display:block; max-width:100%; height:auto; margin:0 auto; border:1px solid var(--line); background:#fff; }
.rd-note { margin:1.3rem 1.4rem; padding:1rem 1.2rem; background:var(--cream); border-left:3px solid var(--gold); font-size:.86rem; line-height:1.7; color:var(--chocolate); }
.rd-note-flag { display:flex; align-items:center; gap:.4rem; font-size:.62rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--caramel); padding:0 1.4rem; margin-top:1.1rem; }

/* PAYMENT */
.rd-sub { padding:1.15rem 1.4rem; border-bottom:1px solid var(--line); }
.rd-sub:last-child { border-bottom:none; }
.rd-sub-t { font-size:.64rem; font-weight:800; letter-spacing:.13em; text-transform:uppercase; color:var(--taupe); margin-bottom:.8rem; display:flex; justify-content:space-between; align-items:center; gap:.75rem; }
.rd-fin { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
.rd-fin-c { padding:.85rem 1rem; background:var(--ivory); border:1px solid var(--line); }
.rd-fin-c.is-ok { background:var(--ok-bg); border-color:var(--ok-bd); }
.rd-fin-c.is-bad { background:var(--bad-bg); border-color:var(--bad-bd); }
.rd-fin-k { font-size:.6rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--taupe); margin-bottom:.3rem; }
.rd-fin-v { font-size:1.3rem; font-weight:800; letter-spacing:-.02em; color:var(--espresso); display:flex; align-items:center; gap:.4rem; }
.is-ok .rd-fin-v { color:var(--ok); } .is-bad .rd-fin-v { color:var(--bad); }
.rd-payout { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; padding:.9rem 1rem; border:1px solid var(--line); background:var(--ivory); }
.rd-payout.is-frozen { background:var(--bad-bg); border-color:var(--bad-bd); }
.rd-payout-s { display:flex; align-items:center; gap:.45rem; font-size:.84rem; font-weight:800; color:var(--ok); }
.is-frozen .rd-payout-s { color:var(--bad); }
.rd-payout-m { font-size:.72rem; color:var(--ink-2); margin-top:.2rem; }
.rd-field { margin-bottom:.8rem; }
.rd-label { display:block; font-size:.64rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--ink-2); margin-bottom:.4rem; }
.rd-input, .rd-textarea { width:100%; padding:.65rem .8rem; border:1px solid var(--beige); border-radius:4px; background:#fff; font-size:.85rem; color:var(--ink); }
.rd-textarea { resize:vertical; min-height:72px; line-height:1.55; }
.rd-input:focus, .rd-textarea:focus { border-color:var(--gold); }

.rd-btn { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; padding:.68rem 1.1rem; border-radius:4px; font-size:.8rem; font-weight:700; cursor:pointer; border:1px solid transparent; transition:background .15s; }
.rd-btn.is-block { width:100%; }
.rd-btn-dark { background:var(--espresso); color:var(--ivory); border-color:var(--espresso); } .rd-btn-dark:hover { background:var(--chocolate); }
.rd-btn-ok { background:var(--ok); color:#fff; border-color:var(--ok); } .rd-btn-ok:hover { background:#265843; }
.rd-btn-bad { background:var(--burgundy); color:#fff; border-color:var(--burgundy); } .rd-btn-bad:hover { background:#411d23; }
.rd-btn-ghost-bad { background:#fff; color:var(--bad); border-color:var(--bad-bd); } .rd-btn-ghost-bad:hover { background:var(--bad-bg); }
.rd-forms { display:grid; gap:1.1rem; }
.rd-form-box { border:1px solid var(--line); padding:1rem; background:#fff; }
.rd-form-box.is-approve { border-top:3px solid var(--ok); }
.rd-form-box.is-reject { border-top:3px solid var(--burgundy); }
.rd-form-box h3 { margin:0 0 .8rem; font-size:.78rem; font-weight:800; color:var(--espresso); }
.rd-processed { padding:1rem 1.1rem; border:1px solid var(--line); }
.rd-processed.is-approved { background:var(--ok-bg); border-color:var(--ok-bd); }
.rd-processed.is-rejected { background:var(--bad-bg); border-color:var(--bad-bd); }
.rd-processed-t { display:flex; align-items:center; gap:.5rem; font-size:.86rem; font-weight:800; }
.is-approved .rd-processed-t { color:var(--ok); } .is-rejected .rd-processed-t { color:var(--bad); }
.rd-processed-n { font-size:.78rem; color:var(--ink-2); margin-top:.5rem; line-height:1.55; }
.rd-processed-d { font-size:.7rem; color:var(--taupe); margin-top:.4rem; }
.rd-empty { padding:1.1rem 1.4rem; font-size:.8rem; color:var(--ink-2); display:flex; align-items:center; gap:.5rem; }

/* ACTION PANEL */
.rd-fieldset { border:none; padding:0; margin:0 0 1.2rem; }
.rd-fieldset legend { padding:0; }
.rd-opts { display:grid; gap:.5rem; }
.rd-opt { position:relative; }
.rd-opt input { position:absolute; opacity:0; inset:0; width:100%; height:100%; cursor:pointer; margin:0; }
.rd-opt-b { display:flex; align-items:center; gap:.65rem; padding:.7rem .9rem; border:1px solid var(--beige); background:#fff; font-size:.82rem; font-weight:600; color:var(--ink-2); transition:all .12s; }
.rd-opt-b svg { font-size:1rem; color:var(--taupe); }
.rd-opt:hover .rd-opt-b { border-color:var(--gold); }
.rd-opt input:checked + .rd-opt-b { border-color:var(--espresso); background:var(--espresso); color:var(--ivory); }
.rd-opt input:checked + .rd-opt-b svg { color:var(--gold); }
.rd-opt input:focus-visible + .rd-opt-b { outline:2px solid var(--gold); outline-offset:2px; }
.rd-opt-hint { font-weight:400; text-transform:none; letter-spacing:0; color:var(--taupe); }
.rd-cur { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.1rem; padding-bottom:1rem; border-bottom:1px solid var(--line); }

/* TIMELINE */
.rd-tl { list-style:none; margin:0; padding:1.2rem 1.4rem; }
.rd-tl li { position:relative; padding:0 0 1.3rem 1.6rem; }
.rd-tl li:last-child { padding-bottom:0; }
.rd-tl li::before { content:''; position:absolute; left:4px; top:1rem; bottom:-.1rem; width:1px; background:var(--beige); }
.rd-tl li:last-child::before { display:none; }
.rd-tl-dot { position:absolute; left:0; top:.28rem; width:9px; height:9px; border-radius:50%; background:var(--caramel); box-shadow:0 0 0 3px #fff; }
.rd-tl-dot.is-info { background:var(--info); } .rd-tl-dot.is-ok { background:var(--ok); } .rd-tl-dot.is-mute { background:var(--taupe); }
.rd-tl-e { font-size:.82rem; font-weight:700; color:var(--ink); }
.rd-tl-t { font-size:.72rem; color:var(--taupe); margin-top:.15rem; }

/* RESPONSIVE */
@media (max-width:1040px) { .rd-layout { grid-template-columns:1fr; } .rd-aside { position:static; } }
@media (max-width:640px) {
    .rd { padding:1rem 1rem 3rem; }
    .rd-head { padding:1.25rem; } .rd-head-meta { gap:1.25rem; }
    .rd-parties { grid-template-columns:1fr; } .rd-party + .rd-party { border-left:none; border-top:1px solid var(--line); }
    .rd-dr { grid-template-columns:1fr; gap:.25rem; }
    .rd-fin { grid-template-columns:1fr; }
}
@media (prefers-reduced-motion:reduce) { .rd * { transition:none !important; } }
</style>
@endpush

@section('content')

@php
    $s = $report->status;
    $reportedRole = $report->reporter_role === 'baker' ? 'Customer' : 'Baker';
    $ico = [
        'pending'   => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path d="M10 5.8V10l2.8 1.8" stroke-linecap="round"/></svg>',
        'reviewed'  => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="9" r="5.5"/><path d="m13.2 13.2 4 4" stroke-linecap="round"/></svg>',
        'resolved'  => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'dismissed' => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 5 10 10M15 5 5 15" stroke-linecap="round"/></svg>',
    ];
@endphp

<div class="rd">

<a href="{{ route('admin.reports.index') }}" class="rd-back">
    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M16 10H5M9.5 5l-5 5 5 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    Back to Reports
</a>

{{-- HEADER --}}
<header class="rd-head">
    <div class="rd-head-l">
        <div class="rd-head-ico">
            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 2 3.5 4.6v5c0 3.8 2.6 6.6 6.5 8.4 3.9-1.8 6.5-4.6 6.5-8.4v-5z"/><path d="M10 7v4M10 13.2v.1" stroke-linecap="round"/></svg>
        </div>
        <div>
            <div class="rd-kicker">Report</div>
            <h1 class="rd-id">#{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</h1>
        </div>
    </div>
    <div class="rd-head-meta">
        <div>
            <div class="rd-meta-k">Submitted</div>
            <div class="rd-meta-v">{{ $report->created_at->format('M d, Y · g:i A') }}</div>
        </div>
        <div>
            <div class="rd-meta-k">Order</div>
            <div class="rd-meta-v">#{{ str_pad($report->baker_order_id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div>
            <div class="rd-meta-k">Current status</div>
            <span class="rd-pill rd-pill-{{ $s }}">{!! $ico[$s] ?? $ico['dismissed'] !!} {{ $report->status_label }}</span>
        </div>
    </div>
</header>

<div class="rd-layout">

    {{-- LEFT: INVESTIGATION --}}
    <div class="rd-col">

        {{-- Parties --}}
        <section class="rd-sec" aria-labelledby="rd-h-parties">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="7.5" cy="7" r="3"/><path d="M2 16.5c.4-3 2.6-4.5 5.5-4.5s5.1 1.5 5.5 4.5M13 4.2a3 3 0 0 1 0 5.6M15 12.3c1.8.6 2.7 2 3 4.2" stroke-linecap="round"/></svg>
                <h2 id="rd-h-parties">Involved Parties</h2>
            </div>
            <div class="rd-parties">
                <div class="rd-party is-reporter">
                    <div class="rd-party-lbl">Reporter</div>
                    <div class="rd-party-row">
                        <div class="rd-av">
                            @if($report->reporter->profile_photo)
                                <img src="{{ asset('storage/'.$report->reporter->profile_photo) }}" alt="">
                            @else {{ strtoupper(substr($report->reporter->first_name,0,1)) }} @endif
                        </div>
                        <div>
                            <div class="rd-p-name">{{ $report->reporter->first_name }} {{ $report->reporter->last_name }}</div>
                            <div class="rd-p-email">{{ $report->reporter->email }}</div>
                        </div>
                    </div>
                    <span class="rd-p-role">{{ ucfirst($report->reporter_role) }}</span>
                </div>

                <div class="rd-party is-reported">
                    <div class="rd-party-lbl">Reported User</div>
                    @if($report->reported)
                        <div class="rd-party-row">
                            <div class="rd-av">
                                @if($report->reported->profile_photo)
                                    <img src="{{ asset('storage/'.$report->reported->profile_photo) }}" alt="">
                                @else
                                    {{ strtoupper(substr($report->reported->first_name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="rd-p-name">{{ $report->reported->first_name }} {{ $report->reported->last_name }}</div>
                                <div class="rd-p-email">{{ $report->reported->email }}</div>
                            </div>
                        </div>
                    @else
                        <div class="rd-party-row">
                            <div class="rd-av">?</div>
                            <div>
                                <div class="rd-p-name">Unknown User</div>
                                <div class="rd-p-email">—</div>
                            </div>
                        </div>
                    @endif
                    <span class="rd-p-role">{{ $reportedRole }}</span>
                </div>
            </div>
        </section>

        {{-- Case record --}}
        <section class="rd-sec" aria-labelledby="rd-h-details">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M5 2.5h7l3 3v12H5z"/><path d="M12 2.5v3h3M7.5 9h5M7.5 12h5M7.5 15h3" stroke-linecap="round"/></svg>
                <h2 id="rd-h-details">Report Details</h2>
            </div>
            <dl class="rd-dl">
                <div class="rd-dr"><dt>Category</dt><dd>{{ $report->category_label }}</dd></div>
                <div class="rd-dr"><dt>Status</dt><dd><span class="rd-pill rd-pill-{{ $report->status }}">{!! $ico[$s] ?? $ico['dismissed'] !!} {{ $report->status_label }}</span></dd></div>
                @if($report->bakerOrder)
                <div class="rd-dr"><dt>Order</dt>
                    <dd><span class="rd-order-ref">#{{ str_pad($report->baker_order_id,4,'0',STR_PAD_LEFT) }}</span>
                        &nbsp;·&nbsp; ₱{{ number_format($report->bakerOrder->agreed_price,0) }}</dd></div>
                <div class="rd-dr"><dt>Order Status</dt><dd style="text-transform:capitalize;">{{ str_replace('_',' ',$report->bakerOrder->status) }}</dd></div>
                @endif
                <div class="rd-dr"><dt>Submitted</dt><dd>{{ $report->created_at->format('M d, Y · g:i A') }}</dd></div>
                @if($report->reviewed_at)
                <div class="rd-dr"><dt>Reviewed At</dt><dd>{{ $report->reviewed_at->format('M d, Y · g:i A') }}</dd></div>
                @endif
            </dl>
        </section>

        {{-- Description --}}
        <section class="rd-sec" aria-labelledby="rd-h-desc">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M3.5 4.5h13M3.5 8.5h13M3.5 12.5h8" stroke-linecap="round"/></svg>
                <h2 id="rd-h-desc">Report Description</h2>
            </div>
            <div class="rd-text">{{ $report->description }}</div>
        </section>

        {{-- Evidence --}}
        @if($report->screenshot_path)
        <section class="rd-sec" aria-labelledby="rd-h-ev">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="2.5" y="4" width="15" height="12" rx="1"/><circle cx="7" cy="8.5" r="1.4"/><path d="m3 15 4.5-4.5 3 3 2.5-2.5 4 4" stroke-linejoin="round"/></svg>
                <h2 id="rd-h-ev">Attached Evidence</h2>
            </div>
            <div class="rd-frame">
                <img src="{{ asset('storage/'.$report->screenshot_path) }}" alt="Report Screenshot">
            </div>
        </section>
        @endif

        {{-- Internal admin note --}}
        @if($report->admin_note)
        <section class="rd-sec" aria-labelledby="rd-h-note">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="4" y="9" width="12" height="8" rx="1"/><path d="M7 9V6.5a3 3 0 0 1 6 0V9"/></svg>
                <h2 id="rd-h-note">Internal Admin Note</h2>
            </div>
            <div class="rd-note">{{ $report->admin_note }}</div>
        </section>
        @endif

        {{-- PAYMENT & REFUND CONTROL PANEL --}}
        @if($report->bakerOrder)
        @php
            $bo = $report->bakerOrder;
            $downpayment = \App\Models\Payment::where('cake_request_id', $bo->cake_request_id)
                ->where('payment_type', 'downpayment')->where('status', 'paid')->first();
            $downpaymentAmount = $downpayment ? $downpayment->amount : round($bo->agreed_price * 0.5, 2);
            $rfKey = in_array($report->refund_status, ['pending','on_hold','approved','rejected']) ? $report->refund_status : 'pending';
        @endphp
        <section class="rd-sec is-dark" aria-labelledby="rd-h-pay">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="2.5" y="5" width="15" height="10.5" rx="1"/><path d="M2.5 8.5h15M5.5 12.5h3" stroke-linecap="round"/></svg>
                <h2 id="rd-h-pay">Payment Control Center</h2>
            </div>

            {{-- Snapshot --}}
            <div class="rd-sub">
                <div class="rd-sub-t">Order Payment Snapshot</div>
                <div class="rd-fin">
                    <div class="rd-fin-c">
                        <div class="rd-fin-k">Agreed Price</div>
                        <div class="rd-fin-v">₱{{ number_format($bo->agreed_price, 2) }}</div>
                    </div>
                    <div class="rd-fin-c {{ $downpayment ? 'is-ok' : 'is-bad' }}">
                        <div class="rd-fin-k">Downpayment</div>
                        <div class="rd-fin-v">
                            @if($downpayment)
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                ₱{{ number_format($downpaymentAmount,2) }}
                            @else
                                Not Paid
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payout control --}}
            <div class="rd-sub">
                <div class="rd-sub-t">Payout Control</div>
                <div class="rd-payout {{ $bo->payout_frozen ? 'is-frozen' : '' }}">
                    <div>
                        <div class="rd-payout-s">
                            @if($bo->payout_frozen)
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="9" width="12" height="8" rx="1"/><path d="M7 9V6.5a3 3 0 0 1 6 0V9"/></svg>
                                Baker Payout Frozen
                            @else
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Payout Normal
                            @endif
                        </div>
                        <div class="rd-payout-m" style="text-transform:capitalize;">Order #{{ str_pad($bo->id, 4, '0', STR_PAD_LEFT) }} · {{ str_replace('_', ' ', $bo->status) }}</div>
                    </div>
                    <form method="POST" action="{{ route('admin.reports.hold-payment', $report->id) }}">
                        @csrf
                        <input type="hidden" name="hold" value="{{ $bo->payout_frozen ? '0' : '1' }}">
                        <button type="submit" class="rd-btn {{ $bo->payout_frozen ? 'rd-btn-ok' : 'rd-btn-bad' }}">
                            @if($bo->payout_frozen)
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="9" width="12" height="8" rx="1"/><path d="M7 9V6.5a3 3 0 0 1 5.6-1.5" stroke-linecap="round"/></svg>
                                Release Hold
                            @else
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="9" width="12" height="8" rx="1"/><path d="M7 9V6.5a3 3 0 0 1 6 0V9"/></svg>
                                Freeze Payout
                            @endif
                        </button>
                    </form>
                </div>
            </div>

            {{-- Refund --}}
            @if($report->refund_requested)
            <div class="rd-sub">
                <div class="rd-sub-t">
                    <span>Refund Request</span>
                    @if($report->refund_status)
                    <span class="rd-pill rd-pill-{{ $rfKey }}">{{ $report->refund_status_label }}</span>
                    @endif
                </div>

                @if(!in_array($report->refund_status, ['approved','rejected']))
                <div class="rd-forms">
                    {{-- Approve --}}
                    <form method="POST" action="{{ route('admin.reports.refund.approve', $report->id) }}" class="rd-form-box is-approve">
                        @csrf
                        <h3>Approve refund</h3>
                        <div class="rd-field">
                            <label class="rd-label" for="rd-refund-amount">Refund Amount (₱)</label>
                            <input id="rd-refund-amount" class="rd-input" type="number" name="refund_amount" step="0.01" min="1"
                                   value="{{ $downpaymentAmount }}" max="{{ $downpaymentAmount }}"
                                   placeholder="e.g. {{ $downpaymentAmount }}">
                        </div>
                        <div class="rd-field">
                            <label class="rd-label" for="rd-approve-note">Refund Note</label>
                            <textarea id="rd-approve-note" class="rd-textarea" name="refund_note" placeholder="Note to customer (reason for approval)…"></textarea>
                        </div>
                        <button type="submit" class="rd-btn rd-btn-ok is-block"
                                onclick="return confirm('Approve this refund and credit ₱{{ $downpaymentAmount }} to the customer\'s wallet?')">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Approve Refund
                        </button>
                    </form>

                    {{-- Reject --}}
                    <form method="POST" action="{{ route('admin.reports.refund.reject', $report->id) }}" class="rd-form-box is-reject">
                        @csrf
                        <h3>Reject refund</h3>
                        <div class="rd-field">
                            <label class="rd-label" for="rd-reject-note">Reason for Rejection</label>
                            <textarea id="rd-reject-note" class="rd-textarea" name="refund_note" placeholder="Reason for rejection (required)…" required></textarea>
                        </div>
                        <button type="submit" class="rd-btn rd-btn-ghost-bad is-block"
                                onclick="return confirm('Reject this refund request?')">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 5 10 10M15 5 5 15" stroke-linecap="round"/></svg>
                            Reject Refund
                        </button>
                    </form>
                </div>
                @else
                <div class="rd-processed is-{{ $report->refund_status }}">
                    <div class="rd-processed-t">
                        @if($report->refund_status==='approved')
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m4.5 10.5 3.5 3.5 7.5-8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Refund of ₱{{ number_format($report->refund_amount,2) }} credited to customer
                        @else
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 5 10 10M15 5 5 15" stroke-linecap="round"/></svg>
                            Refund rejected
                        @endif
                    </div>
                    @if($report->refund_note)
                    <div class="rd-processed-n">{{ $report->refund_note }}</div>
                    @endif
                    @if($report->refund_processed_at)
                    <div class="rd-processed-d">Processed {{ $report->refund_processed_at->format('M d, Y · g:i A') }}</div>
                    @endif
                </div>
                @endif
            </div>
            @else
            <div class="rd-empty">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path d="M10 9v4.5M10 6.6v.1" stroke-linecap="round"/></svg>
                No refund request submitted by customer.
            </div>
            @endif
        </section>
        @endif
    </div>

    {{-- RIGHT: DECISION PANEL --}}
    <aside class="rd-col rd-aside" aria-label="Moderation controls">

        <section class="rd-sec is-dark" aria-labelledby="rd-h-act">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M3 5.5h8M15 5.5h2M3 10h2M9 10h8M3 14.5h10M17 14.5h0" stroke-linecap="round"/><circle cx="13" cy="5.5" r="1.8"/><circle cx="7" cy="10" r="1.8"/><circle cx="15" cy="14.5" r="1.8"/></svg>
                <h2 id="rd-h-act">Moderation Action</h2>
            </div>
            <div style="padding:1.3rem 1.4rem;">
                <div class="rd-cur">
                    <span class="rd-label" style="margin:0;">Current Status</span>
                    <span class="rd-pill rd-pill-{{ $s }}">{!! $ico[$s] ?? $ico['dismissed'] !!} {{ $report->status_label }}</span>
                </div>

                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}">
                    @csrf @method('PATCH')

                    <fieldset class="rd-fieldset">
                        <legend class="rd-label">Status</legend>
                        <div class="rd-opts">
                            <label class="rd-opt">
                                <input type="radio" name="status" value="pending" {{ $report->status==='pending' ? 'checked':'' }}>
                                <span class="rd-opt-b">{!! $ico['pending'] !!} Pending Review</span>
                            </label>
                            <label class="rd-opt">
                                <input type="radio" name="status" value="reviewed" {{ $report->status==='reviewed' ? 'checked':'' }}>
                                <span class="rd-opt-b">{!! $ico['reviewed'] !!} Under Review</span>
                            </label>
                            <label class="rd-opt">
                                <input type="radio" name="status" value="resolved" {{ $report->status==='resolved' ? 'checked':'' }}>
                                <span class="rd-opt-b">{!! $ico['resolved'] !!} Resolved</span>
                            </label>
                            <label class="rd-opt">
                                <input type="radio" name="status" value="dismissed" {{ $report->status==='dismissed' ? 'checked':'' }}>
                                <span class="rd-opt-b">{!! $ico['dismissed'] !!} Dismissed</span>
                            </label>
                        </div>
                    </fieldset>

                    <div class="rd-field">
                        <label class="rd-label" for="rd-admin-note">Admin Note <span class="rd-opt-hint">(optional)</span></label>
                        <textarea id="rd-admin-note" name="admin_note" class="rd-textarea" style="min-height:110px;"
                            placeholder="Add an internal note about your decision…">{{ old('admin_note', $report->admin_note) }}</textarea>
                    </div>

                    <button type="submit" class="rd-btn rd-btn-dark is-block">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 3.5h9l3 3v10H4z" stroke-linejoin="round"/><path d="M7 3.5v4h5v-4M7 16.5v-5h6v5"/></svg>
                        Save Update
                    </button>
                </form>
            </div>
        </section>

        {{-- Timeline --}}
        <section class="rd-sec" aria-labelledby="rd-h-tl">
            <div class="rd-sec-h">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path d="M10 5.8V10l2.8 1.8" stroke-linecap="round"/></svg>
                <h2 id="rd-h-tl">Timeline</h2>
            </div>
            <ol class="rd-tl">
                <li>
                    <span class="rd-tl-dot"></span>
                    <div class="rd-tl-e">Report submitted</div>
                    <div class="rd-tl-t">{{ $report->created_at->format('M d, Y · g:i A') }}</div>
                </li>
                @if($report->reviewed_at)
                <li>
                    <span class="rd-tl-dot is-info"></span>
                    <div class="rd-tl-e">Admin reviewed</div>
                    <div class="rd-tl-t">{{ $report->reviewed_at->format('M d, Y · g:i A') }}</div>
                </li>
                @endif
                @if(in_array($report->status, ['resolved','dismissed']))
                <li>
                    <span class="rd-tl-dot {{ $report->status==='resolved' ? 'is-ok' : 'is-mute' }}"></span>
                    <div class="rd-tl-e">{{ ucfirst($report->status) }}</div>
                    <div class="rd-tl-t">{{ $report->updated_at->format('M d, Y · g:i A') }}</div>
                </li>
                @endif
            </ol>
        </section>
    </aside>

</div>
</div>

@endsection