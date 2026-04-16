@php
    $userRole = auth()->user()->role ?? 'customer';
    $layout = $userRole === 'baker' ? 'layouts.baker' : 'layouts.customer';
@endphp

@extends($layout)
@section('title', 'My Reports')

@push('styles')
<style>
:root {
    --brown-deep:#3B1F0F; --caramel:#C8893A;
    --warm-white:#FFFDF9; --cream:#F5EFE6;
    --border:#EAE0D0; --text-muted:#9A7A5A; --text-dark:#2C1A0E;
}
.page-title    { font-family:'Playfair Display',serif; font-size:1.75rem; color:var(--brown-deep); margin-bottom:0.25rem; }
.page-subtitle { font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem; }

.reports-list { display:grid; gap:1rem; }

.report-card {
    background:var(--warm-white); border:1px solid var(--border);
    border-radius:16px; overflow:hidden; transition:box-shadow 0.2s;
}
.report-card:hover { box-shadow:0 4px 20px rgba(59,31,15,0.08); }

.report-card-top {
    padding:1rem 1.5rem; display:flex; align-items:center;
    justify-content:space-between; border-bottom:1px solid var(--border);
    background:var(--cream);
}
.report-order-ref { font-weight:700; font-size:0.85rem; color:var(--caramel); }
.report-date  { font-size:0.72rem; color:var(--text-muted); }

.report-card-body { padding:1rem 1.5rem; display:flex; align-items:center; gap:1rem; }

.reported-avatar {
    width:40px; height:40px; border-radius:50%; flex-shrink:0;
    background:linear-gradient(135deg,#C07840,#E8A96A);
    color:white; display:flex; align-items:center; justify-content:center;
    font-weight:700; font-size:1rem; overflow:hidden;
}
.reported-avatar img { width:100%; height:100%; object-fit:cover; }

.report-info { flex:1; min-width:0; }
.report-target-name { font-weight:700; font-size:0.88rem; color:var(--brown-deep); margin-bottom:0.15rem; }
.report-target-role { font-size:0.7rem; color:var(--text-muted); }

.category-badge {
    display:inline-flex; align-items:center; padding:0.2rem 0.65rem;
    background:var(--cream); border:1px solid var(--border);
    border-radius:8px; font-size:0.72rem; font-weight:600; color:var(--text-dark);
    margin-top:0.35rem; white-space:nowrap;
}

.report-desc-preview {
    font-size:0.78rem; color:var(--text-muted); line-height:1.5;
    overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
    max-width:300px; margin-top:0.35rem;
}

.status-pill { display:inline-flex; align-items:center; gap:0.3rem; padding:0.25rem 0.7rem; border-radius:20px; font-size:0.72rem; font-weight:700; flex-shrink:0; }
.pill-pending   { background:#FEF9E8; color:#9B6A10; border:1px solid #F0D090; }
.pill-reviewed  { background:#EBF3FE; color:#1A5A8A; border:1px solid #B8D4F0; }
.pill-resolved  { background:#EBF5EE; color:#166534; border:1px solid #B8DFC6; }
.pill-dismissed { background:var(--cream); color:var(--text-muted); border:1px solid var(--border); }

.admin-note-box {
    margin:0 1.5rem 1rem; padding:0.75rem 1rem;
    background:#FEF9E8; border:1.5px solid #F0D090; border-radius:10px;
    font-size:0.78rem; color:#7A4A10; line-height:1.5; font-style:italic;
}
.admin-note-box .an-label { font-style:normal; font-weight:700; font-size:0.65rem; text-transform:uppercase; letter-spacing:0.1em; color:#9B6A10; margin-bottom:0.2rem; }

.empty-state {
    text-align:center; padding:4rem 2rem;
    background:var(--warm-white); border:1px solid var(--border); border-radius:16px;
}
.empty-state .emoji { font-size:3rem; margin-bottom:1rem; }
.empty-state h3 { font-family:'Playfair Display',serif; font-size:1.2rem; color:var(--brown-deep); margin-bottom:0.5rem; }
.empty-state p  { font-size:0.82rem; color:var(--text-muted); }
</style>
@endpush

@section('content')

<h1 class="page-title">My Reports</h1>
<p class="page-subtitle">Reports you've submitted to BakeSphere support</p>

@if($reports->count())
<div class="reports-list">
    @foreach($reports as $report)
    <div class="report-card">
        <div class="report-card-top">
            <div>
                <span class="report-order-ref">
                    Order #{{ $report->bakerOrder ? str_pad($report->baker_order_id,4,'0',STR_PAD_LEFT) : '—' }}
                </span>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                @php $s = $report->status; @endphp
                <span class="status-pill pill-{{ $s }}">
                    @if($s==='pending') ⏳ @elseif($s==='reviewed') 🔍 @elseif($s==='resolved') ✅ @else ✕ @endif
                    {{ \App\Models\Report::STATUSES[$s]['label'] ?? $s }}
                </span>
                <span class="report-date">{{ $report->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        <div class="report-card-body">
            <div class="reported-avatar">
                @if($report->reported->profile_photo)
                    <img src="{{ asset('storage/'.$report->reported->profile_photo) }}" alt="">
                @else
                    {{ strtoupper(substr($report->reported->first_name,0,1)) }}
                @endif
            </div>
            <div class="report-info">
                <div class="report-target-name">
                    Reported: {{ $report->reported->first_name }} {{ $report->reported->last_name }}
                </div>
                <div class="report-target-role">
                    {{ $report->reporter_role === 'baker' ? '👤 Customer' : '👨‍🍳 Baker' }}
                </div>
                <span class="category-badge">{{ $report->category_label }}</span>
                <div class="report-desc-preview">{{ $report->description }}</div>
            </div>
        </div>
        @if($report->admin_note)
        <div class="admin-note-box">
            <div class="an-label">Admin Response</div>
            {{ $report->admin_note }}
        </div>
        @endif
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="emoji">✅</div>
    <h3>No reports submitted</h3>
    <p>You haven't filed any reports. We hope everything has been smooth!</p>
</div>
@endif

@endsection