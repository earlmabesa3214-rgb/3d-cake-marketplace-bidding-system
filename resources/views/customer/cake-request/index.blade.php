@extends('layouts.customer')
@section('title', 'My Cake Requests')

@push('styles')
<style>
.table th:nth-child(1), .table td:nth-child(1) { width: 12%; }  /* Request */
.table th:nth-child(2), .table td:nth-child(2) { width: 30%; }  /* Cake */
.table th:nth-child(3), .table td:nth-child(3) { width: 22%; }  /* Budget */
.table th:nth-child(4), .table td:nth-child(4) { width: 44%; padding-left: 0.75rem; padding-right: 0.25rem; }  /* Delivery Date — these four fill 100% of the pad */
.table th:nth-child(5), .table td:nth-child(5) { width: 0; padding: 0; overflow: visible; position: relative; }  /* Submitted — no longer a real column, see .submitted-float */
.table th:nth-child(6), .table td:nth-child(6) { width: 0; padding: 0; overflow: visible; position: relative; }/* Status — no longer a real column, see .status-float */
.table { table-layout: fixed; width: 100%; }
.table tr { position: relative; }

.badge { display:inline-flex; align-items:center; gap:0.3rem; padding:0.28rem 0.75rem; border-radius:20px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap; }
.badge-OPEN        { background:#FEF9E8; color:#9B7A10; border:1px solid #F0D4B0; }
.badge-BIDDING     { background:#EBF3FE; color:#1A5BBE; border:1px solid #BFDBFE; }
.badge-ACCEPTED    { background:#EFF5EF; color:#2D6A30; border:1px solid #BFDFBE; }
.badge-IN_PROGRESS { background:#EBF3FE; color:#1A5BBE; border:1px solid #BFDBFE; }
.badge-COMPLETED   { background:#EFF5EF; color:#2D6A30; border:1px solid #BFDFBE; }
.badge-CANCELLED   { background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
.badge-EXPIRED     { background:#F5EDE8; color:#7A5A3A; border:1px solid #E8D4C0; }
.badge-WAITING_FOR_PAYMENT   { background:#FFF4E0; color:#9B6010; border:1px solid #F5D8A0; }
.badge-WAITING_FINAL_PAYMENT { background:#FEF0D8; color:#8B5010; border:1px solid #F0C880; }
.pulse { display:inline-block; width:7px; height:7px; border-radius:50%; background:currentColor; animation:dot-pulse 1.5s ease-in-out infinite; }
@keyframes dot-pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }
    /* PAGINATION */
.pagination-wrap { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.5rem; }
.pagination-info { font-size:0.75rem; color:var(--text-muted); }
.pagination { display:flex; align-items:center; gap:0.3rem; list-style:none; margin:0; padding:0; }
.pagination li span,
.pagination li a { display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:32px; padding:0 0.5rem; border-radius:8px; font-size:0.78rem; font-weight:600; text-decoration:none; border:1.5px solid var(--border); color:var(--text-muted); background:transparent; transition:all 0.2s; cursor:pointer; }
.pagination li a:hover { border-color:var(--caramel); color:var(--caramel); background:#FEF3E8; }
.pagination li.active span { background:var(--caramel); color:white; border-color:var(--caramel); }
.pagination li.disabled span { opacity:0.4; cursor:not-allowed; }
.page-header {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;
    /* Pulls the title/subtitle up toward the top of the notebook page.
       transform is visual-only — it doesn't change the space this element
       reserves in the layout — so everything below it (filters, table,
       and therefore the transaction rows tied to the pen anchors) stays
       exactly where it was. */
    transform: translateY(var(--header-lift, -0.75vh));
}
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.7rem; font-weight:800; color:var(--brown-deep); letter-spacing:-0.02em; }
.page-subtitle { font-size:0.92rem; color:var(--text-muted); margin-top:0.1rem; }
    .btn { display:inline-flex; align-items:center; gap:0.4rem; padding:0.7rem 1.4rem; border-radius:10px; font-size:0.875rem; font-weight:600; text-decoration:none; cursor:pointer; border:none; transition:all 0.2s; }
    .btn-primary { background:var(--caramel); color:white; box-shadow:0 4px 12px rgba(200,137,74,0.3); }
    .btn-primary:hover { background:var(--caramel-light); transform:translateY(-1px); }
.filters {
    background:transparent; border:none; padding:0.6rem 0.4rem; margin-bottom:0.75rem; display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center;
    /* Same visual-only lift as .page-header, kept in sync so the title,
       subtitle, and filter pills all rise together while the table
       below stays anchored exactly where it was. */
    transform: translateY(var(--header-lift, -0.75vh));
}
    .filter-btn { padding:0.3rem 0.85rem; border-radius:20px; font-size:0.85rem; font-weight:600; border:1.5px solid var(--border); background:transparent; color:var(--text-muted); cursor:pointer; text-decoration:none; transition:all 0.2s; }
    .filter-btn:hover, .filter-btn.active { border-color:var(--caramel); color:var(--caramel); background:rgba(254,243,232,0.6); }
.card { background:transparent; border:none; border-radius:16px; overflow:visible; }
     .table-scroll {
        /* Shows exactly PEN_ROW_HEIGHT * 8 rows worth of height; anything
           beyond that scrolls WITHIN this box only — the notebook page
           itself never grows, since the pen anchors are tied to 8 fixed
           physical lines drawn on it. */
        max-height: calc(7 * var(--pen-row-height, 72px));
        overflow-y: auto;
        overflow-x: visible;
        width: 100%;
            /* Snaps to whole-row increments once scrolling settles, rather than
           forcing a snap on every intermediate scroll frame — "mandatory"
           was fighting fast/uneven wheel deltas (especially scrolling up)
           and causing a visible bounce as it kept re-snapping mid-scroll. */
        scroll-snap-type: y proximity;
        /* Hide the scrollbar chrome entirely — scrolling (wheel/touch/
           trackpad) still works natively, it's just invisible. */
        scrollbar-width: none;      /* Firefox */
        -ms-overflow-style: none;   /* old Edge/IE */
        /* Stops the browser's elastic "rubber-band" overscroll bounce —
           without this you can still drag/scroll "up" past the top row
           (or down past the last row) even when there's nothing left to
           reveal, which is the "scrolling in default view" you're seeing. */
        overscroll-behavior: contain;
    }
    .table-scroll::-webkit-scrollbar { display: none; } /* Chrome/Safari */
    .table { width:100%; border-collapse:separate; border-spacing:0; }
    /* thead no longer lives inside .table-scroll (see the Blade change),
       so it doesn't need to stick anymore — it's already always visible,
       outside the scrolling box. */
    .table-head-standalone { margin-bottom: 0; }
.table th { padding:0.55rem 0.6rem; text-align:left; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); border-bottom:1px solid var(--border); font-weight:600; background:transparent; font-size: 0.8rem; }
       .table td {
        padding:0.6rem 0.6rem; font-size:0.95rem; border-bottom:1px solid var(--border);
        color:var(--text-dark); vertical-align:top; text-align:left;
        /* Hard-capped so content can never inflate a row past pen-row-height —
           that drift was what pushed row 7 half out of the 8*rowHeight box
           and threw off the scroll-based slot math. */
        height: var(--pen-row-height, 72px);
        max-height: var(--pen-row-height, 72px);
        overflow: hidden;
        box-sizing: border-box;
    }
    .table tbody tr { height: var(--pen-row-height, 72px); }
    /* Clamped locally (not on the td) so it doesn't clip the status/submitted
       floats, which intentionally extend outside their cell. */
    .cake-info-sub { overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
    .table tr:last-child td { border-bottom:none; }
      .table tbody tr { cursor:pointer; scroll-snap-align: start; position: relative; z-index: 1; }
    .table tbody tr:hover .row-arrow { opacity:1; transform:translateX(0); }
    .row-arrow { opacity:0; transform:translateX(-6px); transition:all 0.2s; color:var(--caramel); font-size:1rem; }
    .delete-req-btn {
        display:inline-flex; align-items:center; justify-content:center;
        width:24px; height:24px; border-radius:50%; border:1.5px solid #F5C5BE;
        background:#FDF0EE; color:#8B2A1E; font-size:0.85rem; line-height:1;
        cursor:pointer; flex-shrink:0; transition:all 0.15s; padding:0;
    }
      .delete-req-btn:hover { background:#8B2A1E; color:#fff; border-color:#8B2A1E; transform:scale(1.08); }
    .delete-req-btn:disabled { opacity:0.5; cursor:not-allowed; transform:none; }

        .confirm-modal-overlay {
        position: fixed; inset: 0; z-index: 999;
        background: rgba(43, 30, 20, 0.45);
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
    }
    .confirm-modal-overlay[hidden] { display: none; }
    .confirm-modal {
        background: var(--warm-white, #fff);
        border-radius: 16px;
        max-width: 360px; width: 100%;
        padding: 1.5rem;
        box-shadow: 0 12px 32px rgba(0,0,0,0.18);
        text-align: center;
    }
    .confirm-modal .confirm-icon {
        width: 48px; height: 48px; border-radius: 50%;
        background: #FDF0EE; color: #8B2A1E; font-size: 1.4rem;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 0.9rem;
    }
    .confirm-modal h3 {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.05rem;
        font-weight: 800; color: var(--brown-deep); margin-bottom: 0.4rem;
    }
    .confirm-modal p {
        font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1.3rem; line-height: 1.4;
    }
    .confirm-modal-actions { display: flex; gap: 0.6rem; }
    .confirm-modal-actions button {
        flex: 1; padding: 0.65rem 1rem; border-radius: 10px;
        font-size: 0.85rem; font-weight: 700; cursor: pointer; border: 1.5px solid var(--border);
        background: transparent; color: var(--brown-deep); transition: all 0.15s;
    }
    .confirm-modal-actions button.confirm-danger {
        background: #8B2A1E; color: #fff; border-color: #8B2A1E;
    }
    .confirm-modal-actions button.confirm-danger:hover { background: #6f2117; }
    .confirm-modal-actions button.confirm-cancel:hover { border-color: var(--caramel); color: var(--caramel); }

    .badge { display:inline-flex; align-items:center; gap:0.3rem; padding:0.28rem 0.75rem; border-radius:20px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap; }
    .badge-OPEN        { background:#FEF9E8; color:#9B7A10; border:1px solid #F0D4B0; }
    .badge-BIDDING     { background:#EBF3FE; color:#1A5BBE; border:1px solid #BFDBFE; }
    .badge-ACCEPTED    { background:#EFF5EF; color:#2D6A30; border:1px solid #BFDFBE; }
    .badge-IN_PROGRESS { background:#EBF3FE; color:#1A5BBE; border:1px solid #BFDBFE; }
    .badge-COMPLETED   { background:#EFF5EF; color:#2D6A30; border:1px solid #BFDFBE; }
    .badge-CANCELLED   { background:#FDF0EE; color:#8B2A1E; border:1px solid #F5C5BE; }
    .badge-EXPIRED     { background:#F5EDE8; color:#7A5A3A; border:1px solid #E8D4C0; }
    .badge-WAITING_FOR_PAYMENT   { background:#FFF4E0; color:#9B6010; border:1px solid #F5D8A0; }
.badge-WAITING_FINAL_PAYMENT { background:#FEF0D8; color:#8B5010; border:1px solid #F0C880; }
.badge { 
    display:inline-flex; align-items:center; justify-content:center; gap:0.25rem; 
    padding:0.3rem 0.55rem; border-radius:10px; font-size:0.66rem; 
    font-weight:700; text-transform:uppercase; letter-spacing:0rem; 
    white-space:normal; text-align:center; line-height:1.2;
    width: 92px; min-width: 92px; max-width: 92px; flex-shrink: 0;
}
    .pulse { display:inline-block; width:7px; height:7px; border-radius:50%; background:currentColor; animation:dot-pulse 1.5s ease-in-out infinite; }
    @keyframes dot-pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .cake-info-main { font-weight:600; color:var(--text-dark); font-size:1rem; line-height:1.3; }
    .cake-info-sub { font-size:0.85rem; color:var(--text-muted); margin-top:0.3rem; line-height:1.45; }

    .empty-state { padding:4rem 2rem; text-align:center; color:var(--text-muted); }
    .empty-state .emoji { font-size:3rem; margin-bottom:1rem; }
.empty-state h3 { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.1rem; font-weight:800; color:var(--brown-mid); margin-bottom:0.5rem; }

/* ============ 3D BACKGROUND + CALIBRATION ============ */
.bakesphere-3d-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    overflow: hidden;
}
.bakesphere-3d-bg canvas { display: block; width: 100%; height: 100%; }
.bakesphere-3d-bg.calibrating { pointer-events: auto; }
.bakesphere-page-content {
    position: relative;
    z-index: 1;
    /* Shifted further right so the pad — and the Submitted/Status
       floats anchored to its right edge — sit closer to the rings. */
    margin: 2vh 25vw 8vh 13.4vw;
    transform: rotate(0deg) scale(0.9);
    transform-origin: center;
    /* Hidden until the 3D models finish loading (see JS), so the text
       and the pen/background don't pop in at different times. */
    opacity: 0;
    transition: opacity 0.4s ease;
}
.bakesphere-page-content.assets-ready {
    opacity: 1;
}
.calibration-toggle-btn {
    position: fixed; top: 5.5rem; right: 1rem; z-index: 200;
    padding: 0.6rem 1.1rem; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--warm-white);
    color: var(--brown-deep); font-size: 0.78rem; font-weight: 700;
    cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.calibration-toggle-btn.active { background: var(--caramel); color: #fff; border-color: var(--caramel); }
.calibration-panel {
    position: fixed; top: 8.5rem; right: 1rem; z-index: 200;
    width: 300px; max-height: calc(100vh - 12rem); overflow-y: auto;
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 14px; padding: 1rem 1.1rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12); font-size: 0.75rem;
}
.calibration-panel h4 {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8rem;
    font-weight: 800; color: var(--brown-deep); margin: 0.9rem 0 0.4rem;
    text-transform: uppercase; letter-spacing: 0.05em;
}
.calibration-panel h4:first-child { margin-top: 0; }
.calib-row { display: grid; grid-template-columns: 16px 1fr; align-items: center; gap: 0.4rem; margin-bottom: 0.35rem; }
.calib-row label { font-weight: 700; color: var(--text-muted); }
.calib-row input[type="number"] { width: 100%; padding: 0.3rem 0.4rem; border-radius: 6px; border: 1px solid var(--border); font-size: 0.72rem; background: #fff; }
.calib-actions { display: flex; gap: 0.4rem; margin-top: 0.75rem; }
.calib-actions button { flex: 1; padding: 0.45rem 0.5rem; border-radius: 8px; border: 1.5px solid var(--border); background: transparent; color: var(--brown-deep); font-size: 0.7rem; font-weight: 700; cursor: pointer; }
.calib-actions button.primary { background: var(--caramel); color: #fff; border-color: var(--caramel); }
.calib-hint { font-size: 0.66rem; color: var(--text-muted); margin-top: 0.5rem; line-height: 1.4; }
</style>
@endpush

@section('content')

<div id="bakesphere-3d-bg" class="bakesphere-3d-bg" aria-hidden="true">
    <canvas id="myorders-canvas"></canvas>
</div>

<button type="button" id="calibration-toggle" class="calibration-toggle-btn">🎛️ Enable 3D Calibration</button>
<div id="model-load-status" style="position:fixed; top:9.5rem; right:1rem; z-index:200; font-size:0.7rem; font-family:monospace; background:rgba(0,0,0,0.75); color:#fff; padding:0.4rem 0.6rem; border-radius:6px; max-width:260px; line-height:1.4;"></div>

<div id="calibration-panel" class="calibration-panel" hidden>
    <h4>Model — Position</h4>
    <div class="calib-row"><label>X</label><input type="number" step="0.001" id="mPosX"></div>
    <div class="calib-row"><label>Y</label><input type="number" step="0.001" id="mPosY"></div>
    <div class="calib-row"><label>Z</label><input type="number" step="0.001" id="mPosZ"></div>

    <h4>Model — Rotation (°)</h4>
    <div class="calib-row"><label>X</label><input type="number" step="0.1" id="mRotX"></div>
    <div class="calib-row"><label>Y</label><input type="number" step="0.1" id="mRotY"></div>
    <div class="calib-row"><label>Z</label><input type="number" step="0.1" id="mRotZ"></div>

    <h4>Model — Scale</h4>
    <div class="calib-row"><label>X</label><input type="number" step="0.001" id="mScaleX"></div>
    <div class="calib-row"><label>Y</label><input type="number" step="0.001" id="mScaleY"></div>
    <div class="calib-row"><label>Z</label><input type="number" step="0.001" id="mScaleZ"></div>

    <h4>Camera — Position</h4>
    <div class="calib-row"><label>X</label><input type="number" step="0.001" id="cPosX"></div>
    <div class="calib-row"><label>Y</label><input type="number" step="0.001" id="cPosY"></div>
    <div class="calib-row"><label>Z</label><input type="number" step="0.001" id="cPosZ"></div>

    <h4>Camera — Target</h4>
    <div class="calib-row"><label>X</label><input type="number" step="0.001" id="cTgtX"></div>
    <div class="calib-row"><label>Y</label><input type="number" step="0.001" id="cTgtY"></div>
    <div class="calib-row"><label>Z</label><input type="number" step="0.001" id="cTgtZ"></div>

    <h4>Camera — FOV</h4>
    <div class="calib-row"><label>°</label><input type="number" step="0.1" id="cFov"></div>

    <div class="calib-actions">
        <button type="button" id="calib-reset">Reset View</button>
        <button type="button" id="calib-copy" class="primary">Copy Coordinates</button>
    </div>
    <div class="calib-hint">Left drag: orbit · Middle drag: pan (right drag also works) · Wheel: zoom</div>
</div>

<div id="cancel-confirm-modal" class="confirm-modal-overlay" hidden>
    <div class="confirm-modal">
        <div class="confirm-icon">✕</div>
        <h3>Cancel this request?</h3>
        <p id="cancel-confirm-text">This cannot be undone.</p>
        <div class="confirm-modal-actions">
            <button type="button" class="confirm-cancel" id="cancel-confirm-no">Keep it</button>
            <button type="button" class="confirm-danger" id="cancel-confirm-yes">Yes, cancel</button>
        </div>
    </div>
</div>

<div class="bakesphere-page-content">
<div class="page-header">
    <div>
        <h1 class="page-title">Order Transactions</h1>
        <p class="page-subtitle">Click any row to view its order tracker</p>
    </div>
   
</div>

<div class="card">
    @if($requests->count())
        <!-- Header lives in its own table, OUTSIDE .table-scroll. This is
             deliberate: previously the <thead> sat inside the scroll box
             and ate into the "8 rows worth" of height budget, leaving room
             for only ~7 full rows before the 8th got sliced in half.
             Splitting it out means .table-scroll's max-height is spent
             entirely on body rows, so the math is exact. Both tables share
             the .table class so the nth-child column-width rules keep the
             columns aligned between the two. -->
        <table class="table table-head-standalone">
            <thead>
                       <tr>
                    <th>Request</th>
                    <th>Cake</th>
                    <th>Budget</th>
                    <th>Delivery Date</th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <div class="table-scroll">
        <table class="table">
            <tbody>
                @foreach($requests as $req)
                @php
                    $config = is_array($req->cake_configuration)
                        ? $req->cake_configuration
                        : (json_decode($req->cake_configuration, true) ?? []);
                @endphp
                <tr onclick="window.location='{{ route('customer.cake-requests.show', $req->id) }}'">
                    <td>
                        <div style="font-weight:700; color:var(--caramel); font-size:0.9rem;">
                            #{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </td>
                    <td>
                        <div class="cake-info-main">
                            {{ $config['flavor'] ?? 'Custom' }} {{ $config['shape'] ?? 'Cake' }}
                        </div>
                        <div class="cake-info-sub">
                            {{ $config['size'] ?? '' }}
                            @if(!empty($config['frosting'])) · {{ $config['frosting'] }} @endif
                            @if(!empty($config['addons'])) · {{ count((array)$config['addons']) }} add-ons @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.95rem; font-weight:600; color:var(--brown-mid); white-space:nowrap;">
                            ₱{{ number_format($req->budget_min, 0) }} – ₱{{ number_format($req->budget_max, 0) }}
                        </div>
                    </td>
                               <td>
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:0.6rem;">
                            <div>
                                <div style="font-size:0.95rem; font-weight:600; white-space:nowrap;">
                                    {{ $req->delivery_date->format('M d, Y') }}
                                </div>
                                <div style="font-size:0.82rem; color:var(--text-muted); white-space:nowrap;">
                                    {{ $req->delivery_date->diffForHumans() }}
                                </div>
                            </div>
                            <div style="display:flex; align-items:center; gap:0.5rem; flex-shrink:0;">
                                <span class="badge badge-{{ $req->status }}">
                                    @if(in_array($req->status, ['OPEN','BIDDING']))
                                        <span class="pulse"></span>
                                    @endif
                                    {{ str_replace('_', ' ', $req->status) }}
                                </span>
                                                <button type="button"
                                        class="delete-req-btn"
                                        data-request-id="{{ $req->id }}"
                                        data-delete-url="{{ route('customer.cake-requests.destroy', $req->id) }}"
                                        title="Cancel this request"
                                        onclick="event.stopPropagation();">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="row-arrow">→</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        @if($requests->hasPages())
        <div style="padding:1.25rem 1.5rem; border-top:1px solid var(--border);">
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} results
                </div>
                <ul class="pagination">
                    <li class="{{ $requests->onFirstPage() ? 'disabled' : '' }}">
                        @if($requests->onFirstPage())
                            <span>‹</span>
                        @else
                            <a href="{{ $requests->previousPageUrl() }}">‹</a>
                        @endif
                    </li>

                    @foreach($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                        <li class="{{ $page == $requests->currentPage() ? 'active' : '' }}">
                            @if($page == $requests->currentPage())
                                <span>{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach

                    <li class="{{ !$requests->hasMorePages() ? 'disabled' : '' }}">
                        @if($requests->hasMorePages())
                            <a href="{{ $requests->nextPageUrl() }}">›</a>
                        @else
                            <span>›</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        @endif

    @else
        <div class="empty-state">
            <div class="emoji">🎂</div>
            <h3>No requests yet</h3>
            <p>You haven't made any cake requests. Start your first one!</p>
            <a href="{{ route('customer.cake-requests.create') }}" class="btn btn-primary" style="margin-top:1.25rem; display:inline-flex;">
                + Create Your First Request
            </a>
        </div>
    @endif
</div>

</div>

<script type="importmap">
{
    "imports": {
        "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
        "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
    }
}
</script>
<script type="module">
import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
(function () {
    if (window.__bakesphereOrdersBgInit) return;
    window.__bakesphereOrdersBgInit = true;

       const MODEL_CONFIG = {
        position: { x: 0, y: 0, z: 0 },
        rotation: { x: 0, y: 0, z: 0 }, // degrees
        scale:    { x: 1, y: 1, z: 1 }
    };
      const AUTO_PLACE_PEN = true;
    const PEN_MODEL_CONFIG = {
        position: { x: 0, y: 0, z: 0 },
        rotation: { x: 60, y: -20, z: 0 }, // degrees
        scale:    { x: 1, y: 1, z: 1 }
    };
    const PEN_VIEW_OFFSET = { x: -0.33, y: 0.07, z: 0 }; // offset from camera target, in world units

    // Idle/default position — separate from row 0, so the pen rests
    // beside the "Order Transactions" header instead of sitting on top
    // of the first transaction row. Tune with the same keyboard nudging
    // (hover nothing / mouse away from the table, then use arrows/W/S —
    // see the "REST POSITION TUNING" block below).
    const PEN_REST_OFFSET = { x: -0.20, y: 0.40, z: -0.1 };
    const PEN_REST_ROTATION = { x: 60, y: -20, z: 0 };  // degrees — resting angle
    const PEN_HOVER_ROTATION = { x: 60, y: -20, z: 0 }; // degrees — angle while circling/settled on a row
    const PEN_SCALE_FACTOR = 0.01; // pen's own radius as a fraction of the model's radius
const CAMERA_CONFIG = {
    position: { x: 2.507, y: 8.203, z: -13.761 },
    target:   { x: 2.475, y: 6.914, z: -13.761 },
    fov: 45
};

      const MODEL_URL = '/models/myorders.glb';
    const PEN_MODEL_URL = '/models/pen.glb';
    const statusEl = document.getElementById('model-load-status');
    function logStatus(msg) {
        console.log('[bakesphere]', msg);
        if (statusEl) statusEl.innerHTML += msg + '<br>';
    }

    // Reveal the page text/table only once BOTH glb models have loaded
    // (or a max wait has elapsed, so a slow/broken model never blocks
    // the page forever) — avoids the ugly "text pops in, model catches
    // up later" flash.
    const pageContentEl = document.querySelector('.bakesphere-page-content');
    let mainModelReady = false;
    let penModelReady = false;
    let assetsRevealed = false;
    function revealPageContent() {
        if (assetsRevealed) return;
        assetsRevealed = true;
        if (pageContentEl) pageContentEl.classList.add('assets-ready');
    }
    function maybeRevealPageContent() {
        if (mainModelReady && penModelReady) revealPageContent();
    }
    const ASSET_REVEAL_TIMEOUT_MS = 4000;
    setTimeout(revealPageContent, ASSET_REVEAL_TIMEOUT_MS);
    const bg = document.getElementById('bakesphere-3d-bg');
    const canvas = document.getElementById('myorders-canvas');

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(CAMERA_CONFIG.fov, window.innerWidth / window.innerHeight, 0.01, 1000);

    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0); // transparent — page shows through

    // Lighting
    scene.add(new THREE.HemisphereLight(0xfff3e0, 0x3a2a1a, 1.1));
    const key = new THREE.DirectionalLight(0xffffff, 1.4);
    key.position.set(4, 6, 5);
    scene.add(key);
    const fill = new THREE.DirectionalLight(0xffe3c2, 0.5);
    fill.position.set(-5, 2, -4);
    scene.add(fill);

    // Calibration-only helpers
    const axesHelper = new THREE.AxesHelper(2);
    const gridHelper = new THREE.GridHelper(10, 10);
    axesHelper.visible = false;
    gridHelper.visible = false;
    scene.add(axesHelper, gridHelper);
    // MODEL_CONFIG is applied to this group only — never to the raw
    // loaded GLTF scene — so transforms stay predictable.
    const modelGroup = new THREE.Group();
    scene.add(modelGroup);

    // Pen model lives in its own group so it can be positioned above
    // modelGroup independently once modelGroup's bounding box is known.
    const penGroup = new THREE.Group();
    scene.add(penGroup);

    function applyModelConfig() {
        modelGroup.position.set(MODEL_CONFIG.position.x, MODEL_CONFIG.position.y, MODEL_CONFIG.position.z);
        modelGroup.rotation.set(
            THREE.MathUtils.degToRad(MODEL_CONFIG.rotation.x),
            THREE.MathUtils.degToRad(MODEL_CONFIG.rotation.y),
            THREE.MathUtils.degToRad(MODEL_CONFIG.rotation.z)
        );
        modelGroup.scale.set(MODEL_CONFIG.scale.x, MODEL_CONFIG.scale.y, MODEL_CONFIG.scale.z);
    }
    applyModelConfig();
    function applyPenConfig() {
        penGroup.rotation.set(
            THREE.MathUtils.degToRad(PEN_MODEL_CONFIG.rotation.x),
            THREE.MathUtils.degToRad(PEN_MODEL_CONFIG.rotation.y),
            THREE.MathUtils.degToRad(PEN_MODEL_CONFIG.rotation.z)
        );
        penGroup.scale.set(PEN_MODEL_CONFIG.scale.x, PEN_MODEL_CONFIG.scale.y, PEN_MODEL_CONFIG.scale.z);
    }
    applyPenConfig();
     const PEN_ROW_ANCHORS = {
        0: { x: -0.210, y:  -0.150, z: 0 },
        1: { x: -0.120, y: -0.150, z: 0 },
        2: { x: -0.030, y: -0.150, z: 0 },
        3: { x: 0.070, y: -0.150, z: 0 },
        4: { x:  0.170, y: -0.150, z: 0 },
        5: { x:  0.270, y: -0.150, z: 0 },
        6: { x:  0.360, y: -0.150, z: 0 },
       
    };
    const PEN_ROW_BASE_OFFSET = { x: PEN_VIEW_OFFSET.x, y: PEN_VIEW_OFFSET.y, z: PEN_VIEW_OFFSET.z };
    const PEN_ROW_STEP_OFFSET = { x: 0, y: -0.11, z: 0 }; // fallback for rows not yet in PEN_ROW_ANCHORS
    const PEN_NUDGE_STEP = 0.02;
    const PEN_NUDGE_STEP_BIG = 0.1;
 const PEN_CIRCLE_RADIUS_X = 0.40; // reach along the row's length (Request <-> Delivery Date) — same for every row
const PEN_CIRCLE_RADIUS_Z = 0.06; // depth of the oval, keep small
      const PEN_CIRCLE_SPEED    = 25;   // radians per second — fast, single-loop speed (~0.31s for one full turn)
    const PEN_LERP_SPEED      = 0.12; // how fast the pen eases toward its target each frame (0–1)
       let hoveredRowIndex = null;
    let circleAngle = 0;
    let circleActive = false; // true only while the single fast loop is playing
    let penCurrentPos = null; // lazily initialized from the pen's actual starting position
    let penFixedScale = null; // captured once, then re-applied every frame so it can never drift/shrink

       // ---------------- BROWN "INK" TRAIL ----------------
    // Traces the pen's path only while it's actively circling a row —
    // looks like the pen is drawing a loop, then disappears once the
    // loop finishes / a new row is hovered. Built as a TubeGeometry
    // (not a plain Line) since WebGL ignores line-width on most GPUs —
    // a tube is the only reliable way to get a visibly thick stroke.
    const PEN_TRAIL_MAX_POINTS = 128;
    const PEN_TRAIL_COLOR = 0x6b3a1a;   // brown ink
    const PEN_TRAIL_RADIUS = 0.004;      // thickness of the stroke, in world units
    const trailMaterial = new THREE.MeshBasicMaterial({ color: PEN_TRAIL_COLOR, transparent: true, opacity: 0.92 });
    let trailMesh = null;
    let trailPoints = [];

    function trailClear() {
        trailPoints = [];
        if (trailMesh) {
            scene.remove(trailMesh);
            trailMesh.geometry.dispose();
            trailMesh = null;
        }
    }

    function trailPush(pos) {
        if (trailPoints.length >= PEN_TRAIL_MAX_POINTS) return; // cap reached; stop extending
        trailPoints.push(pos.clone());
        if (trailPoints.length < 2) return; // need at least 2 points for a curve/tube

        if (trailMesh) {
            scene.remove(trailMesh);
            trailMesh.geometry.dispose();
        }
        const curve = new THREE.CatmullRomCurve3(trailPoints);
        const segments = Math.max(trailPoints.length * 4, 8);
        const geometry = new THREE.TubeGeometry(curve, segments, PEN_TRAIL_RADIUS, 8, false);
        trailMesh = new THREE.Mesh(geometry, trailMaterial);
        trailMesh.frustumCulled = false;
        scene.add(trailMesh);
    }
    function getRowAnchor(rowIndex) {
        if (PEN_ROW_ANCHORS[rowIndex]) {
            const a = PEN_ROW_ANCHORS[rowIndex];
            return {
                x: CAMERA_CONFIG.target.x + a.x,
                y: CAMERA_CONFIG.target.y + a.y,
                z: CAMERA_CONFIG.target.z + a.z,
            };
        }
        return {
            x: CAMERA_CONFIG.target.x + PEN_ROW_BASE_OFFSET.x + PEN_ROW_STEP_OFFSET.x * rowIndex,
            y: CAMERA_CONFIG.target.y + PEN_ROW_BASE_OFFSET.y + PEN_ROW_STEP_OFFSET.y * rowIndex,
            z: CAMERA_CONFIG.target.z + PEN_ROW_BASE_OFFSET.z + PEN_ROW_STEP_OFFSET.z * rowIndex,
        };
    }

    function nudgeHoveredRowAnchor(dx, dy, dz) {
        if (hoveredRowIndex === null) return;
        const current = PEN_ROW_ANCHORS[hoveredRowIndex] || (function () {
            const fallback = getRowAnchor(hoveredRowIndex);
            return {
                x: fallback.x - CAMERA_CONFIG.target.x,
                y: fallback.y - CAMERA_CONFIG.target.y,
                z: fallback.z - CAMERA_CONFIG.target.z,
            };
        })();
        current.x += dx;
        current.y += dy;
        current.z += dz;
        PEN_ROW_ANCHORS[hoveredRowIndex] = current;
        if (statusEl) {
            statusEl.innerHTML = 'Row ' + hoveredRowIndex + ' anchor:<br>x: ' + current.x.toFixed(3) +
                '<br>y: ' + current.y.toFixed(3) + '<br>z: ' + current.z.toFixed(3) +
                '<br><br>Arrows = X/Z &nbsp; W/S = Y &nbsp; Shift = bigger step';
        }
    }
    function nudgeRestOffset(dx, dy, dz) {
        PEN_REST_OFFSET.x += dx;
        PEN_REST_OFFSET.y += dy;
        PEN_REST_OFFSET.z += dz;
        if (statusEl) {
            statusEl.innerHTML = 'REST offset:<br>x: ' + PEN_REST_OFFSET.x.toFixed(3) +
                '<br>y: ' + PEN_REST_OFFSET.y.toFixed(3) + '<br>z: ' + PEN_REST_OFFSET.z.toFixed(3) +
                '<br><br>Arrows = X/Z &nbsp; W/S = Y &nbsp; Shift = bigger step';
        }
    }

    document.addEventListener('keydown', function (e) {
        const step = e.shiftKey ? PEN_NUDGE_STEP_BIG : PEN_NUDGE_STEP;

        if (hoveredRowIndex !== null) {
            // Tuning a specific row's hover anchor (mouse is over a row).
            if (e.key === 'ArrowLeft')  { nudgeHoveredRowAnchor(-step, 0, 0); e.preventDefault(); }
            if (e.key === 'ArrowRight') { nudgeHoveredRowAnchor(step, 0, 0);  e.preventDefault(); }
            if (e.key === 'ArrowUp')    { nudgeHoveredRowAnchor(0, 0, -step); e.preventDefault(); }
            if (e.key === 'ArrowDown')  { nudgeHoveredRowAnchor(0, 0, step);  e.preventDefault(); }
            if (e.key === 'w' || e.key === 'W') { nudgeHoveredRowAnchor(step, 0, 0);  e.preventDefault(); }
            if (e.key === 's' || e.key === 'S') { nudgeHoveredRowAnchor(-step, 0, 0); e.preventDefault(); }
        } else {
            // Mouse isn't over any row — tune the idle/rest position instead.
            if (e.key === 'ArrowLeft')  { nudgeRestOffset(-step, 0, 0); e.preventDefault(); }
            if (e.key === 'ArrowRight') { nudgeRestOffset(step, 0, 0);  e.preventDefault(); }
            if (e.key === 'ArrowUp')    { nudgeRestOffset(0, 0, -step); e.preventDefault(); }
            if (e.key === 'ArrowDown')  { nudgeRestOffset(0, 0, step);  e.preventDefault(); }
            if (e.key === 'w' || e.key === 'W') { nudgeRestOffset(step, 0, 0);  e.preventDefault(); }
            if (e.key === 's' || e.key === 'S') { nudgeRestOffset(-step, 0, 0); e.preventDefault(); }
        }
    });
     // Reusable scratch vectors (avoid allocating every frame)
    const _camRight = new THREE.Vector3();
    const _camUp = new THREE.Vector3();
    const _camForward = new THREE.Vector3();

    function updatePenHover(dt) {
        if (!penCurrentPos) penCurrentPos = penGroup.position.clone();

        // Capture the pen's scale the first time we see it, then force
        // it back every frame — guarantees the pen's size never shrinks
        // or grows no matter what else runs during hover/animation.
        if (!penFixedScale) penFixedScale = penGroup.scale.clone();
        penGroup.scale.copy(penFixedScale);
           let target;
        if (hoveredRowIndex !== null) {
            const anchor = getRowAnchor(hoveredRowIndex);

            if (circleActive) {
                circleAngle += PEN_CIRCLE_SPEED * dt;
                if (circleAngle >= Math.PI * 2) {
                    circleAngle = Math.PI * 2; // clamp — one loop only, then park at the anchor
                    circleActive = false;
                }
            }

            // Build the ellipse using the CAMERA's own right/up
            // directions instead of raw world X/Z, so the loop
            // reads as horizontal on screen regardless of the
            // camera's tilt angle.
            camera.getWorldDirection(_camForward);
            _camRight.crossVectors(_camForward, camera.up).normalize();
            _camUp.crossVectors(_camRight, _camForward).normalize();

            const ox = Math.cos(circleAngle) * PEN_CIRCLE_RADIUS_X; // screen-horizontal
            const oy = Math.sin(circleAngle) * PEN_CIRCLE_RADIUS_Z; // screen-vertical (kept small)

            target = {
                x: anchor.x + _camRight.x * ox + _camUp.x * oy,
                y: anchor.y + _camRight.y * ox + _camUp.y * oy,
                z: anchor.z + _camRight.z * ox + _camUp.z * oy
            };

            trailPush(new THREE.Vector3(target.x, target.y, target.z));
        } else {
            target = {
                x: CAMERA_CONFIG.target.x + PEN_REST_OFFSET.x,
                y: CAMERA_CONFIG.target.y + PEN_REST_OFFSET.y,
                z: CAMERA_CONFIG.target.z + PEN_REST_OFFSET.z
            };
        }

               penCurrentPos.x += (target.x - penCurrentPos.x) * PEN_LERP_SPEED;
        penCurrentPos.y += (target.y - penCurrentPos.y) * PEN_LERP_SPEED;
        penCurrentPos.z += (target.z - penCurrentPos.z) * PEN_LERP_SPEED;
        penGroup.position.copy(penCurrentPos);

        // Ease rotation toward whichever pose is active (rest vs hover),
        // rather than snapping, so the angle change looks natural.
        const rot = hoveredRowIndex !== null ? PEN_HOVER_ROTATION : PEN_REST_ROTATION;
        const rx = THREE.MathUtils.degToRad(rot.x);
        const ry = THREE.MathUtils.degToRad(rot.y);
        const rz = THREE.MathUtils.degToRad(rot.z);
        penGroup.rotation.x += (rx - penGroup.rotation.x) * PEN_LERP_SPEED;
        penGroup.rotation.y += (ry - penGroup.rotation.y) * PEN_LERP_SPEED;
        penGroup.rotation.z += (rz - penGroup.rotation.z) * PEN_LERP_SPEED;
    }
    // The 3D anchors are tied to FIXED physical lines drawn on the
    // notebook art (8 of them) — they have nothing to do with how many
    // transactions actually exist. So instead of using a row's position
    // in the underlying list (which breaks the moment there's a 9th/10th
    // transaction and the list scrolls), we work out which of the 8
    // on-screen slots a row currently occupies, based on where it sits
    // relative to the top of the scrollable viewport. That number is
    // always 0–7 no matter how far the list has scrolled.
    const PEN_VISIBLE_ROWS = 7;
      function computeVisibleSlot(row) {
        const container = row.closest('.table-scroll');
        if (!container) return 0;
        // Use the row's DOM order plus how many whole rows have scrolled
        // past, rather than dividing this row's own bounding-box offset
        // by its own measured height. The per-row division broke once a
        // row's rendered height drifted even slightly from the others
        // (e.g. a longer cake description), since the divisor used for
        // the whole offset came from just that one row — a tiny mismatch
        // early on then threw off every row after it, which is why
        // hovering could land on slot 3 instead of the expected slot.
        // Row index and scroll position are both whole, stable numbers,
        // so this stays exact regardless of any one row's height.
        const rows = Array.from(container.querySelectorAll('tbody tr'));
        const rowIndex = rows.indexOf(row);
        if (rowIndex === -1) return 0;
        const rowHeight = (rows[0] && rows[0].getBoundingClientRect().height) || 72;
        const scrolledRows = Math.round(container.scrollTop / rowHeight);
        const slot = rowIndex - scrolledRows;
        return Math.max(0, Math.min(PEN_VISIBLE_ROWS - 1, slot));
    }
       const cancelModal = document.getElementById('cancel-confirm-modal');
    const cancelModalText = document.getElementById('cancel-confirm-text');
    const cancelModalYes = document.getElementById('cancel-confirm-yes');
    const cancelModalNo = document.getElementById('cancel-confirm-no');
    let pendingCancelBtn = null;

    function openCancelModal(btn) {
        pendingCancelBtn = btn;
        const requestId = btn.getAttribute('data-request-id');
        cancelModalText.textContent = 'Cancel request #' + String(requestId).padStart(4, '0') + '? This cannot be undone.';
        cancelModal.hidden = false;
    }
    function closeCancelModal() {
        cancelModal.hidden = true;
        pendingCancelBtn = null;
    }

    cancelModalNo.addEventListener('click', closeCancelModal);
    cancelModal.addEventListener('click', function (e) {
        if (e.target === cancelModal) closeCancelModal();
    });

    cancelModalYes.addEventListener('click', function () {
        const btn = pendingCancelBtn;
        if (!btn) return;
        closeCancelModal();

        const url = btn.getAttribute('data-delete-url');
        btn.disabled = true;
        const originalText = btn.textContent;
        btn.textContent = '…';

        const token = document.querySelector('meta[name="csrf-token"]');
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token ? token.getAttribute('content') : '',
                'Accept': 'application/json',
            }
        })
        .then(function (res) {
            return res.json().then(function (data) {
                return { ok: res.ok, data: data };
            });
        })
        .then(function (result) {
            if (!result.ok || !result.data.success) {
                throw new Error(result.data.message || 'Cancel failed');
            }
            const row = btn.closest('tr');
            if (row) {
                row.style.transition = 'opacity 0.2s, transform 0.2s';
                row.style.opacity = '0';
                row.style.transform = 'scale(0.97)';
                setTimeout(function () { row.remove(); }, 200);
            }
        })
        .catch(function (err) {
            console.error('[bakesphere] cancel failed', err);
            alert(err.message || 'Could not cancel this request. Please try again.');
            btn.disabled = false;
            btn.textContent = originalText;
        });
    });

    document.querySelectorAll('.delete-req-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            e.preventDefault();
            if (btn.disabled) return;
            openCancelModal(btn);
        });
    });

    document.querySelectorAll('.table tbody tr').forEach(function (row) {
         row.addEventListener('mouseenter', function () {
            hoveredRowIndex = computeVisibleSlot(row);
            circleAngle = 0;
            circleActive = true; // reset so each new hover gets its own single loop
            trailClear(); // wipe any leftover ink from a previous row's loop
            if (statusEl) statusEl.innerHTML = 'Hovering visible slot ' + hoveredRowIndex + ' — use arrows/W/S to nudge (Shift = bigger step)';
        });
        row.addEventListener('mouseleave', function () {
            hoveredRowIndex = null;
            // Trail is left as-is briefly then cleared on the next hover;
            // clearing immediately here would cut the ink off mid-fade if
            // the mouse leaves while the loop is still drawing.
        });
    });
    // Blender-style controls: left = orbit, middle (or right) = pan, wheel = zoom
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.08;
    controls.enabled = false; // only active in calibration mode
    controls.mouseButtons = { LEFT: THREE.MOUSE.ROTATE, MIDDLE: THREE.MOUSE.PAN, RIGHT: THREE.MOUSE.PAN };
    controls.target.set(CAMERA_CONFIG.target.x, CAMERA_CONFIG.target.y, CAMERA_CONFIG.target.z);

    let initialCameraPos = null;
    let initialTarget = new THREE.Vector3(CAMERA_CONFIG.target.x, CAMERA_CONFIG.target.y, CAMERA_CONFIG.target.z);
      let mainModelBox = null, mainModelCenter = null, mainModelRadius = null;
    let penLoaded = false;

     function placePenAboveMainModel() {
        if (AUTO_PLACE_PEN) {
            // Anchor to the camera's default view target so the pen always
            // spawns inside the frame the camera is already looking at,
            // regardless of the main model's own size/shape.
            const tx = CAMERA_CONFIG.target.x + PEN_VIEW_OFFSET.x;
            const ty = CAMERA_CONFIG.target.y + PEN_VIEW_OFFSET.y;
            const tz = CAMERA_CONFIG.target.z + PEN_VIEW_OFFSET.z;
            penGroup.position.set(tx, ty, tz);

            const s = Math.max((mainModelRadius || 1) * PEN_SCALE_FACTOR, 0.001);
            penGroup.scale.set(s, s, s);
            logStatus('pen placed at (' + tx.toFixed(2) + ', ' + ty.toFixed(2) + ', ' + tz.toFixed(2) + '), scale=' + s.toFixed(3));
        } else {
            penGroup.position.set(PEN_MODEL_CONFIG.position.x, PEN_MODEL_CONFIG.position.y, PEN_MODEL_CONFIG.position.z);
            penGroup.scale.set(PEN_MODEL_CONFIG.scale.x, PEN_MODEL_CONFIG.scale.y, PEN_MODEL_CONFIG.scale.z);
        }
        syncInputsFromScene();
    }
    const loader = new GLTFLoader();
    loader.load(MODEL_URL, function (gltf) {
        modelGroup.add(gltf.scene);
        logStatus('✅ myorders.glb loaded');

        const box = new THREE.Box3().setFromObject(modelGroup);
        const size = new THREE.Vector3();
        const center = new THREE.Vector3();
        box.getSize(size);
        box.getCenter(center);
        const radius = Math.max(size.x, size.y, size.z) * 0.5 || 1;

        mainModelBox = box;
        mainModelCenter = center;
        mainModelRadius = radius;

        if (CAMERA_CONFIG.position.x === null) {
            const dist = radius / Math.sin(THREE.MathUtils.degToRad(camera.fov) / 2) * 1.15;
            camera.position.set(center.x, center.y + radius * 0.25, center.z + dist);
            controls.target.copy(center);
        } else {
            camera.position.set(CAMERA_CONFIG.position.x, CAMERA_CONFIG.position.y, CAMERA_CONFIG.position.z);
            controls.target.set(CAMERA_CONFIG.target.x, CAMERA_CONFIG.target.y, CAMERA_CONFIG.target.z);
        }
        camera.updateProjectionMatrix();
        controls.update();

        initialCameraPos = camera.position.clone();
        initialTarget = controls.target.clone();

        axesHelper.position.copy(center);
        gridHelper.position.set(center.x, box.min.y, center.z);

        placePenAboveMainModel();
        syncInputsFromScene();
      }, undefined, function (err) {
        logStatus('❌ FAILED to load myorders.glb — check the path/server console');
        console.error('Failed to load /models/myorders.glb', err);
        mainModelReady = true;
        maybeRevealPageContent();
    });

    loader.load(PEN_MODEL_URL, function (gltf) {
        penGroup.add(gltf.scene);
        penLoaded = true;
        logStatus('✅ pen.glb loaded');
        placePenAboveMainModel(); // no longer waits on the main model's bbox
        penModelReady = true;
        maybeRevealPageContent();
    }, undefined, function (err) {
        logStatus('❌ FAILED to load pen.glb — check that /models/pen.glb exists');
        console.error('Failed to load /models/pen.glb', err);
        penModelReady = true;
        maybeRevealPageContent();
    });
    function onResize() {
        const w = window.innerWidth, h = window.innerHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    }
    window.addEventListener('resize', onResize);

       let lastFrameTime = performance.now();
    function animate() {
        requestAnimationFrame(animate);
        const now = performance.now();
        const dt = Math.min((now - lastFrameTime) / 1000, 0.1); // clamp to avoid big jumps on tab-switch
        lastFrameTime = now;

        // Defensive guard: never render into a zero-size canvas.
        if (renderer.domElement.clientWidth === 0 || renderer.domElement.clientHeight === 0) return;
        controls.update();
        updatePenHover(dt);
        renderer.render(scene, camera);
    }
    animate();
    // -------------------- CALIBRATION PANEL WIRING --------------------
    const toggleBtn = document.getElementById('calibration-toggle');
    const panel = document.getElementById('calibration-panel');
    const inputs = {
        mPosX: document.getElementById('mPosX'), mPosY: document.getElementById('mPosY'), mPosZ: document.getElementById('mPosZ'),
        mRotX: document.getElementById('mRotX'), mRotY: document.getElementById('mRotY'), mRotZ: document.getElementById('mRotZ'),
        mScaleX: document.getElementById('mScaleX'), mScaleY: document.getElementById('mScaleY'), mScaleZ: document.getElementById('mScaleZ'),
        cPosX: document.getElementById('cPosX'), cPosY: document.getElementById('cPosY'), cPosZ: document.getElementById('cPosZ'),
        cTgtX: document.getElementById('cTgtX'), cTgtY: document.getElementById('cTgtY'), cTgtZ: document.getElementById('cTgtZ'),
        cFov: document.getElementById('cFov')
    };

    function fmt(n) { return Number(n).toFixed(3); }

    function syncInputsFromScene() {
        inputs.mPosX.value = fmt(modelGroup.position.x);
        inputs.mPosY.value = fmt(modelGroup.position.y);
        inputs.mPosZ.value = fmt(modelGroup.position.z);
        inputs.mRotX.value = fmt(THREE.MathUtils.radToDeg(modelGroup.rotation.x));
        inputs.mRotY.value = fmt(THREE.MathUtils.radToDeg(modelGroup.rotation.y));
        inputs.mRotZ.value = fmt(THREE.MathUtils.radToDeg(modelGroup.rotation.z));
        inputs.mScaleX.value = fmt(modelGroup.scale.x);
        inputs.mScaleY.value = fmt(modelGroup.scale.y);
        inputs.mScaleZ.value = fmt(modelGroup.scale.z);
        inputs.cPosX.value = fmt(camera.position.x);
        inputs.cPosY.value = fmt(camera.position.y);
        inputs.cPosZ.value = fmt(camera.position.z);
        inputs.cTgtX.value = fmt(controls.target.x);
        inputs.cTgtY.value = fmt(controls.target.y);
        inputs.cTgtZ.value = fmt(controls.target.z);
        inputs.cFov.value = fmt(camera.fov);
    }

    controls.addEventListener('change', function () {
        inputs.cPosX.value = fmt(camera.position.x);
        inputs.cPosY.value = fmt(camera.position.y);
        inputs.cPosZ.value = fmt(camera.position.z);
        inputs.cTgtX.value = fmt(controls.target.x);
        inputs.cTgtY.value = fmt(controls.target.y);
        inputs.cTgtZ.value = fmt(controls.target.z);
    });

    function bindModelInput(el, apply) {
        el.addEventListener('input', function () {
            const v = parseFloat(el.value);
            if (!isNaN(v)) apply(v);
        });
    }
    bindModelInput(inputs.mPosX, v => modelGroup.position.x = v);
    bindModelInput(inputs.mPosY, v => modelGroup.position.y = v);
    bindModelInput(inputs.mPosZ, v => modelGroup.position.z = v);
    bindModelInput(inputs.mRotX, v => modelGroup.rotation.x = THREE.MathUtils.degToRad(v));
    bindModelInput(inputs.mRotY, v => modelGroup.rotation.y = THREE.MathUtils.degToRad(v));
    bindModelInput(inputs.mRotZ, v => modelGroup.rotation.z = THREE.MathUtils.degToRad(v));
    bindModelInput(inputs.mScaleX, v => modelGroup.scale.x = v);
    bindModelInput(inputs.mScaleY, v => modelGroup.scale.y = v);
    bindModelInput(inputs.mScaleZ, v => modelGroup.scale.z = v);
    bindModelInput(inputs.cPosX, v => camera.position.x = v);
    bindModelInput(inputs.cPosY, v => camera.position.y = v);
    bindModelInput(inputs.cPosZ, v => camera.position.z = v);
    bindModelInput(inputs.cTgtX, v => controls.target.x = v);
    bindModelInput(inputs.cTgtY, v => controls.target.y = v);
    bindModelInput(inputs.cTgtZ, v => controls.target.z = v);
    bindModelInput(inputs.cFov, v => { camera.fov = v; camera.updateProjectionMatrix(); });

    toggleBtn.addEventListener('click', function () {
        const turningOn = panel.hasAttribute('hidden');
        if (turningOn) {
            panel.removeAttribute('hidden');
            bg.classList.add('calibrating');
            controls.enabled = true;
            axesHelper.visible = true;
            gridHelper.visible = true;
            toggleBtn.classList.add('active');
            toggleBtn.textContent = '✕ Exit Calibration';
            syncInputsFromScene();
        } else {
            panel.setAttribute('hidden', '');
            bg.classList.remove('calibrating');
            controls.enabled = false;
            axesHelper.visible = false;
            gridHelper.visible = false;
            toggleBtn.classList.remove('active');
            toggleBtn.textContent = '🎛️ Enable 3D Calibration';
        }
    });

    document.getElementById('calib-reset').addEventListener('click', function () {
        MODEL_CONFIG.position = { x: 0, y: 0, z: 0 };
        MODEL_CONFIG.rotation = { x: 0, y: 0, z: 0 };
        MODEL_CONFIG.scale = { x: 1, y: 1, z: 1 };
        applyModelConfig();
        if (initialCameraPos) {
            camera.position.copy(initialCameraPos);
            controls.target.copy(initialTarget);
            camera.fov = CAMERA_CONFIG.fov;
            camera.updateProjectionMatrix();
            controls.update();
        }
        syncInputsFromScene();
    });

    document.getElementById('calib-copy').addEventListener('click', function () {
        const text =
`MODEL:
position: { x: ${inputs.mPosX.value}, y: ${inputs.mPosY.value}, z: ${inputs.mPosZ.value} }
rotation: { x: ${inputs.mRotX.value}, y: ${inputs.mRotY.value}, z: ${inputs.mRotZ.value} }
scale: { x: ${inputs.mScaleX.value}, y: ${inputs.mScaleY.value}, z: ${inputs.mScaleZ.value} }

CAMERA:
position: { x: ${inputs.cPosX.value}, y: ${inputs.cPosY.value}, z: ${inputs.cPosZ.value} }
target: { x: ${inputs.cTgtX.value}, y: ${inputs.cTgtY.value}, z: ${inputs.cTgtZ.value} }
fov: ${inputs.cFov.value}`;
        navigator.clipboard.writeText(text).then(function () {
            const btn = document.getElementById('calib-copy');
            const orig = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => { btn.textContent = orig; }, 1200);
        });
    });

    window.addEventListener('pagehide', function () {
        window.removeEventListener('resize', onResize);
        renderer.dispose();
        controls.dispose();
    });
})();
</script>

@endsection