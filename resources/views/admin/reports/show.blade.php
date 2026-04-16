@extends('layouts.admin')
@section('title', 'Report #' . $report->id)

@push('styles')
<style>
:root {
    --brown-deep:#3B1F0F; --caramel:#C8893A;
    --warm-white:#FFFDF9; --cream:#F5EFE6;
    --border:#EAE0D0; --text-muted:#9A7A5A; --text-dark:#2C1A0E;
}
.back-link { display:inline-flex; align-items:center; gap:0.4rem; font-size:0.82rem; color:var(--text-muted); text-decoration:none; margin-bottom:1.25rem; transition:color 0.2s; }
.back-link:hover { color:var(--caramel); }

.report-layout { display:grid; grid-template-columns:1fr 320px; gap:1.5rem; align-items:start; }

/* ── REPORT HERO ── */
.report-hero {
    background:linear-gradient(135deg,#5A1A1A,#8B2E2E);
    border-radius:20px; padding:1.75rem 2rem; color:white; margin-bottom:1.5rem;
    display:flex; align-items:center; justify-content:space-between; gap:1rem;
}
.rh-left { display:flex; align-items:center; gap:1rem; }
.rh-icon { width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,0.15); border:1.5px solid rgba(255,255,255,0.25); display:flex; align-items:center; justify-content:center; font-size:1.4rem; flex-shrink:0; }
.rh-id   { font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:0.15rem; }
.rh-sub  { font-size:0.78rem; opacity:0.65; }
.rh-status { padding:0.4rem 1rem; border-radius:20px; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); font-size:0.8rem; font-weight:700; }

/* CARDS */
.card { background:var(--warm-white); border:1px solid var(--border); border-radius:20px; overflow:hidden; margin-bottom:1.5rem; }
.card:last-child { margin-bottom:0; }
.card-header { padding:1rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:0.6rem; }
.card-header h3 { font-family:'Playfair Display',serif; font-size:0.95rem; color:var(--brown-deep); margin:0; }

/* PARTY ROW */
.party-row { display:flex; gap:1rem; padding:1.25rem 1.5rem; }
.party-box {
    flex:1; padding:1rem 1.25rem; border-radius:14px;
    border:1.5px solid var(--border); background:var(--cream);
}
.party-box.reporter-box { border-color:#F5C5BE; background:#FDF5F3; }
.pb-label  { font-size:0.62rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--text-muted); font-weight:700; margin-bottom:0.65rem; }
.pb-avatar {
    width:40px; height:40px; border-radius:50%;
    background:linear-gradient(135deg,#C07840,#E8A96A);
    color:white; display:flex; align-items:center; justify-content:center;
    font-weight:700; font-size:1rem; flex-shrink:0; overflow:hidden; margin-bottom:0.6rem;
}
.pb-avatar img { width:100%; height:100%; object-fit:cover; }
.pb-name { font-weight:700; font-size:0.88rem; color:var(--brown-deep); }
.pb-email { font-size:0.72rem; color:var(--text-muted); margin-top:0.15rem; }

/* DETAIL ROWS */
.detail-row { display:flex; justify-content:space-between; align-items:center; padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); gap:1rem; }
.detail-row:last-child { border-bottom:none; }
.d-key { font-size:0.68rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); font-weight:700; }
.d-val { font-size:0.85rem; color:var(--text-dark); font-weight:500; text-align:right; }

/* DESCRIPTION */
.description-box { padding:1.25rem 1.5rem; font-size:0.86rem; color:var(--text-dark); line-height:1.7; }

/* SCREENSHOT */
.screenshot-box { padding:1.25rem 1.5rem; }
.screenshot-box img { max-width:100%; border-radius:12px; border:1px solid var(--border); }

/* ADMIN ACTION FORM */
.admin-form-card { background:var(--warm-white); border:1px solid var(--border); border-radius:20px; overflow:hidden; }
.admin-form-header { padding:1rem 1.5rem; border-bottom:1px solid var(--border); background:linear-gradient(135deg,#3B1F0F,#7A4A28); }
.admin-form-header h3 { font-family:'Playfair Display',serif; font-size:0.95rem; color:white; margin:0; }
.admin-form-body { padding:1.5rem; }
.form-label { display:block; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:0.5rem; }
.form-select {
    width:100%; padding:0.7rem 0.9rem; border:1.5px solid var(--border);
    border-radius:10px; font-family:'DM Sans',sans-serif; font-size:0.86rem;
    color:var(--text-dark); background:white; margin-bottom:1.1rem;
}
.form-select:focus { outline:none; border-color:var(--caramel); }
.form-textarea {
    width:100%; padding:0.75rem 0.9rem; border:1.5px solid var(--border);
    border-radius:10px; font-family:'DM Sans',sans-serif; font-size:0.84rem;
    color:var(--text-dark); resize:vertical; min-height:100px;
    box-sizing:border-box; margin-bottom:1.1rem;
}
.form-textarea:focus { outline:none; border-color:var(--caramel); }
.save-btn {
    width:100%; padding:0.75rem; border:none; border-radius:10px;
    background:linear-gradient(135deg,#3B1F0F,#7A4A28); color:white;
    font-size:0.875rem; font-weight:700; cursor:pointer;
    font-family:'DM Sans',sans-serif; transition:all 0.2s;
}
.save-btn:hover { opacity:0.9; }

/* TIMELINE */
.timeline { padding:0; list-style:none; }
.timeline li { padding:0.85rem 1.5rem; border-bottom:1px solid var(--border); display:flex; align-items:flex-start; gap:0.65rem; font-size:0.8rem; }
.timeline li:last-child { border-bottom:none; }
.tl-dot { width:8px; height:8px; border-radius:50%; background:var(--caramel); flex-shrink:0; margin-top:0.3rem; }
.tl-event { font-weight:600; color:var(--text-dark); }
.tl-time  { font-size:0.7rem; color:var(--text-muted); margin-top:0.1rem; }

/* STATUS BADGES */
.status-pill { display:inline-flex; align-items:center; gap:0.3rem; padding:0.25rem 0.65rem; border-radius:20px; font-size:0.72rem; font-weight:700; }
.pill-pending   { background:#FEF9E8; color:#9B6A10; border:1px solid #F0D090; }
.pill-reviewed  { background:#EBF3FE; color:#1A5A8A; border:1px solid #B8D4F0; }
.pill-resolved  { background:#EBF5EE; color:#166534; border:1px solid #B8DFC6; }
.pill-dismissed { background:var(--cream); color:var(--text-muted); border:1px solid var(--border); }

.success-flash {
    background:#EBF5EE; border:1.5px solid #B8DFC6; border-radius:12px;
    padding:0.85rem 1.1rem; font-size:0.82rem; color:#166534;
    font-weight:600; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.5rem;
}
</style>
@endpush

@section('content')

<a href="{{ route('admin.reports.index') }}" class="back-link">← All Reports</a>

@if(session('success'))
<div class="success-flash">✅ {{ session('success') }}</div>
@endif

{{-- HERO --}}
<div class="report-hero">
    <div class="rh-left">
        <div class="rh-icon">⚠️</div>
        <div>
            <div class="rh-id">Report #{{ $report->id }}</div>
            <div class="rh-sub">
                Submitted {{ $report->created_at->format('M d, Y · g:i A') }} ·
                Order #{{ str_pad($report->baker_order_id,4,'0',STR_PAD_LEFT) }}
            </div>
        </div>
    </div>
    @php $s = $report->status; @endphp
    <div class="rh-status">
        @if($s==='pending') ⏳ @elseif($s==='reviewed') 🔍 @elseif($s==='resolved') ✅ @else ✕ @endif
        {{ $report->status_label }}
    </div>
</div>

<div class="report-layout">

    {{-- LEFT --}}
    <div>
        {{-- Parties --}}
        <div class="card">
            <div class="card-header"><span>👤</span><h3>Involved Parties</h3></div>
            <div class="party-row">
                <div class="party-box reporter-box">
                    <div class="pb-label">⚠️ Reporter ({{ ucfirst($report->reporter_role) }})</div>
                    <div class="pb-avatar">
                        @if($report->reporter->profile_photo)
                            <img src="{{ asset('storage/'.$report->reporter->profile_photo) }}" alt="">
                        @else {{ strtoupper(substr($report->reporter->first_name,0,1)) }} @endif
                    </div>
                    <div class="pb-name">{{ $report->reporter->first_name }} {{ $report->reporter->last_name }}</div>
                    <div class="pb-email">{{ $report->reporter->email }}</div>
                </div>
                <div class="party-box">
                    <div class="pb-label">🎯 Reported ({{ $report->reporter_role === 'baker' ? 'Customer' : 'Baker' }})</div>
                    <div class="pb-avatar">
                        @if($report->reported->profile_photo)
                            <img src="{{ asset('storage/'.$report->reported->profile_photo) }}" alt="">
                        @else {{ strtoupper(substr($report->reported->first_name,0,1)) }} @endif
                    </div>
                    <div class="pb-name">{{ $report->reported->first_name }} {{ $report->reported->last_name }}</div>
                    <div class="pb-email">{{ $report->reported->email }}</div>
                </div>
            </div>
        </div>

        {{-- Report details --}}
        <div class="card">
            <div class="card-header"><span>📋</span><h3>Report Details</h3></div>
            <div class="detail-row">
                <span class="d-key">Category</span>
                <span class="d-val">{{ $report->category_label }}</span>
            </div>
            <div class="detail-row">
                <span class="d-key">Status</span>
                <span class="d-val">
                    <span class="status-pill pill-{{ $report->status }}">{{ $report->status_label }}</span>
                </span>
            </div>
            @if($report->bakerOrder)
            <div class="detail-row">
                <span class="d-key">Order</span>
                <span class="d-val" style="color:var(--caramel); font-weight:700;">
                    #{{ str_pad($report->baker_order_id,4,'0',STR_PAD_LEFT) }}
                    · ₱{{ number_format($report->bakerOrder->agreed_price,0) }}
                </span>
            </div>
            <div class="detail-row">
                <span class="d-key">Order Status</span>
                <span class="d-val">{{ str_replace('_',' ',$report->bakerOrder->status) }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="d-key">Submitted</span>
                <span class="d-val">{{ $report->created_at->format('M d, Y · g:i A') }}</span>
            </div>
            @if($report->reviewed_at)
            <div class="detail-row">
                <span class="d-key">Reviewed At</span>
                <span class="d-val">{{ $report->reviewed_at->format('M d, Y · g:i A') }}</span>
            </div>
            @endif
        </div>

        {{-- Description --}}
        <div class="card">
            <div class="card-header"><span>📝</span><h3>Description</h3></div>
            <div class="description-box">{{ $report->description }}</div>
        </div>

        {{-- Screenshot --}}
        @if($report->screenshot_path)
        <div class="card">
            <div class="card-header"><span>🖼️</span><h3>Attached Screenshot</h3></div>
            <div class="screenshot-box">
                <img src="{{ asset('storage/'.$report->screenshot_path) }}" alt="Report Screenshot">
            </div>
        </div>
        @endif

        {{-- Admin note (read-only display if set) --}}
        @if($report->admin_note)
        <div class="card">
            <div class="card-header"><span>🔒</span><h3>Admin Note</h3></div>
            <div class="description-box" style="background:#FEF9E8; font-style:italic; color:#7A4A10;">
                "{{ $report->admin_note }}"
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>
        {{-- Admin action form --}}
        <div class="admin-form-card" style="margin-bottom:1.5rem;">
            <div class="admin-form-header"><h3>⚙️ Update Report</h3></div>
            <div class="admin-form-body">
                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}">
                    @csrf @method('PATCH')

                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending"   {{ $report->status==='pending'   ? 'selected':'' }}>⏳ Pending Review</option>
                        <option value="reviewed"  {{ $report->status==='reviewed'  ? 'selected':'' }}>🔍 Under Review</option>
                        <option value="resolved"  {{ $report->status==='resolved'  ? 'selected':'' }}>✅ Resolved</option>
                        <option value="dismissed" {{ $report->status==='dismissed' ? 'selected':'' }}>✕ Dismissed</option>
                    </select>

                    <label class="form-label">Admin Note <span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span></label>
                    <textarea name="admin_note" class="form-textarea"
                        placeholder="Add an internal note about your decision…">{{ old('admin_note', $report->admin_note) }}</textarea>

                    <button type="submit" class="save-btn">💾 Save Update</button>
                </form>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card">
            <div class="card-header"><span>🕐</span><h3>Timeline</h3></div>
            <ul class="timeline">
                <li>
                    <div class="tl-dot"></div>
                    <div>
                        <div class="tl-event">Report submitted</div>
                        <div class="tl-time">{{ $report->created_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @if($report->reviewed_at)
                <li>
                    <div class="tl-dot" style="background:#1A5A8A;"></div>
                    <div>
                        <div class="tl-event">Admin reviewed</div>
                        <div class="tl-time">{{ $report->reviewed_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
                @if(in_array($report->status, ['resolved','dismissed']))
                <li>
                    <div class="tl-dot" style="background:{{ $report->status==='resolved' ? '#166534' : 'var(--text-muted)' }};"></div>
                    <div>
                        <div class="tl-event">{{ ucfirst($report->status) }}</div>
                        <div class="tl-time">{{ $report->updated_at->format('M d, Y · g:i A') }}</div>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>

</div>

@endsection