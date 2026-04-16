@extends('layouts.baker')
@section('title', 'My Profile')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
:root {
    --brown-deep:   #3B1F0F;
    --brown-mid:    #7A4A28;
    --caramel:      #C8893A;
    --caramel-light:#E8A94A;
    --warm-white:   #FFFDF9;
    --cream:        #F5EFE6;
    --border:       #EAE0D0;
    --text-dark:    #2C1A0E;
    --text-mid:     #6B4A2A;
    --text-muted:   #9A7A5A;
    --err:          #C0392B;
    --success:      #5B8F6A;
}

/* ── HERO ── */
.profile-hero {
    background: linear-gradient(135deg, var(--brown-deep) 0%, var(--brown-mid) 60%, #5A3018 100%);
    padding: 2.5rem 2rem 0;
    border-radius: 0 0 24px 24px;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.profile-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%),
                radial-gradient(circle at 10% 80%, rgba(232,169,74,0.07) 0%, transparent 40%);
    pointer-events: none;
}
.hero-top {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
    flex-wrap: wrap;
}
.avatar-wrap { position: relative; flex-shrink: 0; }
.avatar-circle {
    width: 90px; height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-light));
    border: 3px solid rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    font-size: 2rem; font-weight: 700; color: #fff;
}
.avatar-circle img { width: 100%; height: 100%; object-fit: cover; }
.hero-info { flex: 1; min-width: 200px; }
.hero-name  { font-size: 1.6rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem; }
.hero-email { font-size: 0.85rem; color: rgba(255,255,255,0.6); margin-bottom: 0.75rem; }
.hero-tags  { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.tag { padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.72rem; font-weight: 600; }
.tag-role    { background: rgba(232,169,74,0.2); color: var(--caramel-light); border: 1px solid rgba(232,169,74,0.3); }
.tag-shop    { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8); border: 1px solid rgba(255,255,255,0.15); }
.tag-pending { background: rgba(245,158,11,0.2); color: #FDE68A; border: 1px solid rgba(245,158,11,0.3); }
.tag-approved{ background: rgba(91,143,106,0.25); color: #A7F3D0; border: 1px solid rgba(91,143,106,0.3); }
.tag-incomplete { background: rgba(192,57,43,0.2); color: #FCA5A5; border: 1px solid rgba(192,57,43,0.3); }

/* TAB NAV */
.tab-nav {
    display: flex;
    gap: 0;
    margin-top: 1.5rem;
    position: relative;
    z-index: 1;
}
.tab-btn {
    padding: 0.75rem 1.5rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: rgba(255,255,255,0.5);
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
    white-space: nowrap;
}
.tab-btn:hover  { color: rgba(255,255,255,0.8); }
.tab-btn.active { color: #fff; border-bottom-color: var(--caramel); }
.tab-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 16px; height: 16px;
    background: #EF4444;
    border-radius: 50%;
    font-size: 0.6rem;
    font-weight: 700;
    color: #fff;
    margin-left: 5px;
    vertical-align: middle;
}

/* ── PAGE BODY ── */
.profile-body { padding: 0 1.5rem 3rem; }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* ── SECTION CARD ── */
.section-card {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(59,31,15,0.05);
}
.section-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--cream);
}
.section-card-title {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--brown-deep);
}
.section-card-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-light));
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.section-card-body { padding: 1.5rem; }

/* ── INFO ROWS ── */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.info-item {}
.info-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}
.info-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-dark);
    line-height: 1.5;
}
.info-empty { color: var(--border); font-style: italic; font-weight: 400; font-size: 0.85rem; }

/* ── COMPLETION STATUS ── */
.completion-bar-wrap {
    background: var(--warm-white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
.completion-bar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}
.completion-bar-title { font-size: 0.85rem; font-weight: 700; color: var(--brown-deep); }
.completion-pct { font-size: 0.85rem; font-weight: 700; color: var(--caramel); }
.completion-track {
    height: 8px;
    background: var(--border);
    border-radius: 999px;
    overflow: hidden;
    margin-bottom: 0.75rem;
}
.completion-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--caramel), var(--caramel-light));
    border-radius: 999px;
    transition: width 0.6s ease;
}
.completion-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.completion-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.65rem;
    border-radius: 20px;
    font-size: 0.68rem;
    font-weight: 600;
}
.chip-ok      { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
.chip-missing { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }

/* ── FORM ELEMENTS ── */
.form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-group { margin-bottom: 1.1rem; }
.form-label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--text-mid); margin-bottom: 0.4rem; }
.form-label .req  { color: var(--caramel); }
.form-label .hint { font-size: 0.7rem; font-weight: 400; color: var(--text-muted); margin-left: 4px; }
.form-input {
    width: 100%; padding: 0.7rem 0.9rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.88rem;
    font-family: 'DM Sans', sans-serif;
    background: var(--warm-white);
    color: var(--text-dark);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input:focus { border-color: var(--caramel); box-shadow: 0 0 0 3px rgba(200,137,58,0.12); }
textarea.form-input { resize: vertical; min-height: 85px; }
select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%239A7A5A' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.9rem center; }
.field-error { font-size: 0.73rem; color: var(--err); margin-top: 0.3rem; }

/* ── FILE UPLOAD ── */
.file-upload-area { border: 2px dashed var(--border); border-radius: 12px; padding: 1rem 0.75rem; text-align: center; cursor: pointer; transition: all 0.2s; background: var(--warm-white); position: relative; }
.file-upload-area:hover { border-color: var(--caramel); background: var(--cream); }
.file-upload-area.has-file { border-color: var(--success); background: #F0FAF3; }
.file-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.file-upload-icon  { font-size: 1.3rem; margin-bottom: 0.25rem; }
.file-upload-title { font-size: 0.78rem; font-weight: 600; color: var(--brown-mid); }
.file-upload-hint  { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.15rem; }
.file-name-display { margin-top: 0.35rem; font-size: 0.7rem; color: var(--success); font-weight: 600; display: none; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.current-file-link { font-size: 0.7rem; color: var(--caramel); margin-top: 0.25rem; display: block; }

/* ── DOC GRID ── */
.doc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }

/* ── SPECIALTIES ── */
.specialties-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 0.5rem; }
.specialty-check { display: flex; align-items: center; gap: 0.45rem; padding: 0.45rem 0.7rem; border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.15s; font-size: 0.8rem; font-weight: 500; color: var(--text-muted); user-select: none; }
.specialty-check:hover { border-color: var(--caramel); color: var(--brown-mid); }
.specialty-check input { display: none; }
.specialty-check.checked { border-color: var(--caramel); background: var(--cream); color: var(--brown-deep); font-weight: 600; }
.check-indicator { width: 14px; height: 14px; border: 2px solid currentColor; border-radius: 3px; display: flex; align-items: center; justify-content: center; font-size: 0.55rem; flex-shrink: 0; }

/* ── MAP ── */
#profile-map { height: 260px; width: 100%; border-radius: 10px; overflow: hidden; }
.btn-locate { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 0.9rem; background: var(--cream); border: 1.5px solid var(--border); border-radius: 8px; font-size: 0.78rem; font-weight: 600; color: var(--brown-mid); cursor: pointer; transition: all 0.15s; font-family: 'DM Sans', sans-serif; margin-bottom: 0.75rem; }
.btn-locate:hover { background: var(--border); border-color: var(--caramel); color: var(--brown-deep); }
.map-coords { font-size: 0.72rem; color: var(--caramel); font-weight: 600; margin-bottom: 0.5rem; display: none; }
.map-coords.visible { display: block; }

/* ── PORTFOLIO PREVIEW ── */
.portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem; }
.portfolio-item { position: relative; aspect-ratio: 1; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); }
.portfolio-item img { width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s; }
.portfolio-item:hover img { opacity: 0.85; }
.portfolio-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--cream); font-size: 1.6rem; cursor: pointer; transition: all 0.15s; border: 2px dashed var(--border); border-radius: 10px; aspect-ratio: 1; }
.portfolio-empty:hover { background: var(--border); border-color: var(--caramel); }
.portfolio-empty-label { font-size: 0.62rem; color: var(--text-muted); margin-top: 0.2rem; font-weight: 600; }
.portfolio-del-btn { position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; background: rgba(192,57,43,0.88); color: #fff; border: none; border-radius: 50%; font-size: 0.7rem; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: all 0.15s; z-index: 5; line-height: 1; font-weight: 700; }
.portfolio-del-btn:hover { background: #C0392B; transform: scale(1.1); }
.portfolio-new-badge { position: absolute; bottom: 5px; left: 5px; background: var(--caramel); color: #fff; font-size: 0.58rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px; z-index: 5; }

/* ── SUBMIT BUTTON ── */
.btn-save {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.8rem 2rem;
    background: linear-gradient(135deg, var(--brown-mid), var(--caramel));
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.92rem;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(123,79,58,0.25);
    transition: all 0.2s;
}
.btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(123,79,58,0.35); }

/* ── ALERT ── */
.alert { padding: 0.9rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.875rem; }
.alert-success { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
.alert-error   { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

/* ── AVAILABILITY TOGGLE ── */
.availability-row { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; }
.avail-label { font-size: 0.88rem; font-weight: 600; color: var(--text-dark); }
.avail-sub   { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.15rem; }
.toggle-switch { position: relative; width: 44px; height: 24px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider { position: absolute; inset: 0; background: var(--border); border-radius: 999px; transition: 0.3s; cursor: pointer; }
.toggle-slider:before { content: ''; position: absolute; width: 18px; height: 18px; background: white; border-radius: 50%; left: 3px; bottom: 3px; transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
input:checked + .toggle-slider { background: var(--success); }
input:checked + .toggle-slider:before { transform: translateX(20px); }

@media (max-width: 768px) {
    .info-grid, .form-row, .doc-grid, .specialties-grid { grid-template-columns: 1fr; }
    .profile-hero { padding: 1.5rem 1rem 0; }
    .profile-body { padding: 0 1rem 3rem; }
    .tab-btn { padding: 0.65rem 0.9rem; font-size: 0.75rem; }
}
</style>
@endpush

@section('content')

@php
    $bakerRecord  = $baker->baker;
    $missingFields = \App\Http\Middleware\BakerProfileComplete::getMissingFields($baker);
    $totalRequired = 5; // shop, address, lat/lng, docs (2 fields)
    $missingCount  = count($missingFields);
    $doneCount     = max(0, $totalRequired - $missingCount);
    $pct           = round(($doneCount / $totalRequired) * 100);

    // All checkable items for the bar
    $allChecks = [
        'Bakery / Shop Name'      => !empty($bakerRecord?->shop_name),
        'Bakery Address'          => !empty($bakerRecord?->full_address) || !empty($bakerRecord?->address),
        'Map Pin Location'        => !empty($bakerRecord?->latitude) && !empty($bakerRecord?->longitude),
        'Business Documents'      => ($bakerRecord?->seller_type === 'homebased')
                                        ? (!empty($bakerRecord?->gov_id_front) && !empty($bakerRecord?->id_selfie))
                                        : (!empty($bakerRecord?->business_permit) && !empty($bakerRecord?->dti_certificate)),
        'Sanitary / Gov ID'       => ($bakerRecord?->seller_type === 'homebased')
                                        ? true
                                        : !empty($bakerRecord?->sanitary_permit),
    ];
    $totalChecks = count($allChecks);
    $doneChecks  = count(array_filter($allChecks));
    $pct         = round(($doneChecks / $totalChecks) * 100);

    $oldSpecs = old('specialties', is_array($bakerRecord?->specialties) ? $bakerRecord->specialties : []);
    $specialtyOptions = ['Wedding Cakes','Birthday Cakes','Fondant Art','Cupcakes','Macarons','Cheesecakes','Custom Designs','Vegan Cakes','Gluten-Free','Chocolate Cakes','Pastries','Tarts'];
@endphp

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error">✕ {{ $errors->first() }}</div>
@endif

{{-- ── HERO ── --}}
<div class="profile-hero">
    <div class="hero-top">
        <div class="avatar-wrap">
            <div class="avatar-circle">
                @if($baker->profile_photo)
                    <img src="{{ Str::startsWith($baker->profile_photo, 'http') ? $baker->profile_photo : Storage::url($baker->profile_photo) }}" alt="Photo">
                @else
                    {{ strtoupper(substr($baker->first_name,0,1).substr($baker->last_name,0,1)) }}
                @endif
            </div>
        </div>
        <div class="hero-info">
            <div class="hero-name">{{ $baker->first_name }} {{ $baker->last_name }}</div>
            <div class="hero-email">{{ $baker->email }}</div>
            <div class="hero-tags">
                <span class="tag tag-role">🎂 Baker</span>
                @if(!empty($bakerRecord?->shop_name))
                    <span class="tag tag-shop">🏪 {{ $bakerRecord->shop_name }}</span>
                @endif
                @if($bakerRecord?->is_approved)
                    <span class="tag tag-approved">✅ Approved</span>
                @else
                    <span class="tag tag-pending">⏳ Pending Approval</span>
                @endif
                @if($missingCount > 0)
                    <span class="tag tag-incomplete">⚠ {{ $missingCount }} incomplete</span>
                @endif
            </div>
        </div>
    </div>

    <div class="tab-nav">
        <button class="tab-btn active" onclick="switchTab('overview', this)">Overview</button>
        <button class="tab-btn" onclick="switchTab('bakery', this)">
            Bakery Info
            @if(empty($bakerRecord?->shop_name)) <span class="tab-badge">!</span> @endif
        </button>
<button class="tab-btn" onclick="switchTab('documents', this)">Documents</button>
        <button class="tab-btn" onclick="switchTab('location', this)">
            Location
            @if(empty($bakerRecord?->latitude)) <span class="tab-badge">!</span> @endif
        </button>
<button class="tab-btn" onclick="switchTab('portfolio', this)">Cake Designs</button>
{{-- ADD THIS --}}
<button class="tab-btn" onclick="switchTab('reviews', this)">⭐ Reviews
    @if($reviews->count() > 0)
        <span class="tab-badge" style="background:var(--caramel);">{{ $reviews->count() }}</span>
    @endif
</button>

<button class="tab-btn" onclick="switchTab('payments', this)">💳 Payments</button>

    </div>
</div>

<div class="profile-body">

    {{-- ══ OVERVIEW TAB ══ --}}
    <div class="tab-panel active" id="tab-overview">

        {{-- Completion bar --}}
        <div class="completion-bar-wrap">
            <div class="completion-bar-header">
                <div class="completion-bar-title">Profile Completion — required to bid</div>
                <div class="completion-pct">{{ $pct }}%</div>
            </div>
            <div class="completion-track">
                <div class="completion-fill" style="width: {{ $pct }}%;"></div>
            </div>
            <div class="completion-chips">
                @foreach($allChecks as $label => $done)
                    <span class="completion-chip {{ $done ? 'chip-ok' : 'chip-missing' }}">
                        {{ $done ? '✓' : '✕' }} {{ $label }}
                    </span>
                @endforeach
            </div>
        </div>

      {{-- Personal Info --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="section-card-icon">👤</div>
                    Personal Information
                </div>
                <span style="font-size:0.72rem;color:var(--text-muted);font-weight:500;">Member since {{ $baker->created_at->format('M Y') }}</span>
            </div>
            <div class="section-card-body" style="padding:0;">

                {{-- Profile banner row --}}
                <div style="display:flex;align-items:center;gap:1.25rem;padding:1.5rem;border-bottom:1px solid var(--border);background:linear-gradient(135deg,var(--cream) 0%,var(--warm-white) 100%);">
                    <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--caramel),var(--caramel-light));display:flex;align-items:center;justify-content:center;font-size:1.4rem;font-weight:700;color:#fff;flex-shrink:0;box-shadow:0 4px 12px rgba(200,137,58,0.3);">
                        @if($baker->profile_photo)
                            <img src="{{ Str::startsWith($baker->profile_photo,'http') ? $baker->profile_photo : Storage::url($baker->profile_photo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" alt="">
                        @else
                            {{ strtoupper(substr($baker->first_name,0,1).substr($baker->last_name,0,1)) }}
                        @endif
                    </div>
                    <div>
                        <div style="font-size:1.1rem;font-weight:700;color:var(--brown-deep);">{{ $baker->first_name }} {{ $baker->last_name }}</div>
                        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.1rem;">{{ $baker->email }}</div>
                        <div style="margin-top:0.4rem;">
                            <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.7rem;font-weight:600;background:var(--cream);border:1px solid var(--border);color:var(--text-mid);padding:0.15rem 0.6rem;border-radius:20px;">
                                {{ $bakerRecord?->seller_type === 'homebased' ? '🏠 Home-Based Baker' : '🏢 Registered Business' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Detail rows --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;">
                    @php
                        $phone = $baker->phone ?? $bakerRecord?->phone;
                        $details = [
                            ['📞', 'Phone', $phone ?: null],
                            ['📅', 'Member Since', $baker->created_at->format('F d, Y')],
                        ];
                    @endphp
                    @foreach($details as [$icon, $lbl, $val])
                    <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--border);{{ $loop->even ? 'border-left:1px solid var(--border);' : '' }}">
                        <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:0.35rem;">{{ $icon }} {{ $lbl }}</div>
                        <div style="font-size:0.88rem;font-weight:600;color:var(--text-dark);">
                            @if($val) {{ $val }} @else <span style="color:var(--border);font-style:italic;font-weight:400;font-size:0.82rem;">Not provided</span> @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

 {{-- Bakery Summary --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-card-title">
                    <div class="section-card-icon">🧁</div>
                    Bakery Details
                </div>
                <button onclick="switchTab('bakery', document.querySelector('[onclick*=bakery]'))"
                    style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.75rem;font-weight:600;color:var(--caramel);background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:0.3rem 0.75rem;cursor:pointer;font-family:'DM Sans',sans-serif;">
                    ✏️ Edit
                </button>
            </div>
            <div class="section-card-body" style="padding:0;">

                {{-- Shop name hero strip --}}
                @if(!empty($bakerRecord?->shop_name))
                <div style="padding:1.25rem 1.5rem;background:linear-gradient(135deg,var(--cream),var(--warm-white));border-bottom:1px solid var(--border);display:flex;align-items:center;gap:0.75rem;">
                    <span style="font-size:1.5rem;">🏪</span>
                    <div>
                        <div style="font-size:1rem;font-weight:700;color:var(--brown-deep);">{{ $bakerRecord->shop_name }}</div>
                        @if($bakerRecord?->bio)
                        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.2rem;line-height:1.5;max-width:600px;">{{ Str::limit($bakerRecord->bio, 120) }}</div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Stats row --}}
                <div style="display:grid;grid-template-columns:repeat(3,1fr);border-bottom:1px solid var(--border);">
                    @php
                        $stats = [
                            ['⏱️', 'Experience', $bakerRecord?->experience_years ?? null],
                            ['💰', 'Min. Order',  $bakerRecord?->min_order_price ? '₱'.number_format($bakerRecord->min_order_price,0) : null],
                            ['🔗', 'Online Shop',  $bakerRecord?->social_media ? 'Linked' : null],
                        ];
                    @endphp
                    @foreach($stats as [$icon, $lbl, $val])
                    <div style="padding:1rem 1.25rem;text-align:center;{{ !$loop->last ? 'border-right:1px solid var(--border);' : '' }}">
                        <div style="font-size:1.1rem;margin-bottom:0.2rem;">{{ $icon }}</div>
                        <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:0.25rem;">{{ $lbl }}</div>
                        @if($val)
                            @if($lbl === 'Online Shop' && $bakerRecord?->social_media)
                                <a href="{{ $bakerRecord->social_media }}" target="_blank" style="font-size:0.8rem;font-weight:700;color:var(--caramel);text-decoration:none;">View →</a>
                            @else
                                <div style="font-size:0.88rem;font-weight:700;color:var(--brown-deep);">{{ $val }}</div>
                            @endif
                        @else
                            <div style="font-size:0.78rem;color:var(--border);font-style:italic;">Not set</div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Specialties --}}
                <div style="padding:1.1rem 1.5rem;">
                    <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:0.65rem;">🎂 Specialties</div>
                    @if(!empty($bakerRecord?->specialties))
                        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                            @foreach((array)$bakerRecord->specialties as $s)
                                <span style="background:var(--cream);border:1px solid var(--border);padding:0.25rem 0.7rem;border-radius:20px;font-size:0.72rem;font-weight:600;color:var(--text-mid);">{{ $s }}</span>
                            @endforeach
                        </div>
                    @else
                        <span style="font-size:0.82rem;color:var(--border);font-style:italic;">No specialties added yet — <button onclick="switchTab('bakery',document.querySelector('[onclick*=bakery]'))" style="background:none;border:none;color:var(--caramel);font-weight:600;cursor:pointer;font-size:0.82rem;padding:0;">add some →</button></span>
                    @endif
                </div>

            </div>
        </div>

    </div>{{-- end overview --}}

    {{-- ══ BAKERY INFO TAB ══ --}}
    <div class="tab-panel" id="tab-bakery">
        <form method="POST" action="{{ route('baker.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="_tab" value="bakery">

            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-title"><div class="section-card-icon">🧁</div> Bakery Information</div>
                </div>
                <div class="section-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-input" value="{{ old('first_name', $baker->first_name) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-input" value="{{ old('last_name', $baker->last_name) }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone', $baker->phone ?? $bakerRecord?->phone) }}" placeholder="09XXXXXXXXXX" maxlength="12" inputmode="numeric">
                            <div class="field-error" id="phone_err" style="display:none;"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Shop / Brand Name <span class="req">*</span></label>
                            <input type="text" name="shop_name" class="form-input" value="{{ old('shop_name', $bakerRecord?->shop_name) }}" placeholder="Sweet Dreams Bakery" required>
                            @error('shop_name') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Years of Experience</label>
                            <select name="experience_years" class="form-input">
                                <option value="">Select...</option>
                                @foreach(['less_than_1'=>'Less than 1 year','1-2'=>'1–2 years','3-5'=>'3–5 years','5-10'=>'5–10 years','10+'=>'10+ years'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('experience_years', $bakerRecord?->experience_years) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Min. Order Price (₱)</label>
                            <input type="number" name="min_order_price" class="form-input" min="0" value="{{ old('min_order_price', $bakerRecord?->min_order_price) }}" placeholder="500">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Social Media / Online Shop <span class="hint">(optional)</span></label>
                        <input type="url" name="social_media" class="form-input" value="{{ old('social_media', $bakerRecord?->social_media) }}" placeholder="https://facebook.com/yourbakery">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Short Bio <span class="hint">(optional)</span></label>
                        <textarea name="bio" class="form-input" placeholder="Tell customers about your baking style…">{{ old('bio', $bakerRecord?->bio) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Specialties</label>
                        <div class="specialties-grid">
                            @foreach($specialtyOptions as $spec)
                            <label class="specialty-check {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}">
                                <input type="checkbox" name="specialties[]" value="{{ $spec }}" {{ in_array($spec, $oldSpecs) ? 'checked' : '' }}>
                                <span class="check-indicator">{{ in_array($spec, $oldSpecs) ? '✓' : '' }}</span>
                                {{ $spec }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;">
                <button type="submit" class="btn-save">💾 Save Bakery Info</button>
            </div>
        </form>
    </div>

{{-- ══ DOCUMENTS TAB ══ --}}
<div class="tab-panel" id="tab-documents">
    <div class="section-card">
        <div class="section-card-header">
            <div class="section-card-title">
                <div class="section-card-icon">📋</div>
                Submitted Documents
            </div>
            <span style="font-size:0.72rem;background:#FEF9E8;color:#7A5800;padding:0.2rem 0.75rem;border-radius:20px;font-weight:700;border:1px solid #F0D4B0;">🔒 Read-only — contact admin to update</span>
        </div>
        <div class="section-card-body">
            @if(($bakerRecord?->seller_type ?? 'registered') === 'registered')
                <div class="doc-grid">
                    @foreach([
                        ['DTI/SEC Number',    $bakerRecord?->dti_sec_number,  '🔢', false],
                        ['Business Permit',   $bakerRecord?->business_permit, '📄', true],
                        ['DTI Certificate',   $bakerRecord?->dti_certificate, '📋', true],
                        ['Sanitary Permit',   $bakerRecord?->sanitary_permit, '🛡️', true],
                        ['BIR Certificate',   $bakerRecord?->bir_certificate, '📑', true],
                    ] as [$label, $value, $icon, $isFile])
                    <div class="info-item">
                        <div class="info-label">{{ $icon }} {{ $label }}</div>
                        <div class="info-value">
                            @if($value)
                                @if($isFile)
                                    <a href="{{ Storage::url($value) }}" target="_blank" style="color:var(--caramel);font-weight:600;font-size:0.82rem;">✓ View File →</a>
                                @else
                                    {{ $value }}
                                @endif
                            @else
                                <span class="info-empty">Not submitted</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="doc-grid">
                    @foreach([
                        ['ID Type',         $bakerRecord?->gov_id_type,  '🪪', false],
                        ['Gov\'t ID Front',  $bakerRecord?->gov_id_front, '🪪', true],
                        ['Gov\'t ID Back',   $bakerRecord?->gov_id_back,  '🪪', true],
                        ['Selfie with ID',   $bakerRecord?->id_selfie,    '🤳', true],
                        ['Food Safety Cert', $bakerRecord?->food_safety_cert, '🛡️', true],
                    ] as [$label, $value, $icon, $isFile])
                    <div class="info-item">
                        <div class="info-label">{{ $icon }} {{ $label }}</div>
                        <div class="info-value">
                            @if($value)
                                @if($isFile)
                                    <a href="{{ Storage::url($value) }}" target="_blank" style="color:var(--caramel);font-weight:600;font-size:0.82rem;">✓ View File →</a>
                                @else
                                    {{ $value }}
                                @endif
                            @else
                                <span class="info-empty">Not submitted</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
          

    {{-- ══ LOCATION TAB ══ --}}
    <div class="tab-panel" id="tab-location">
        <form method="POST" action="{{ route('baker.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="_tab" value="location">

            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-title"><div class="section-card-icon">📍</div> Bakery Location</div>
                </div>
                <div class="section-card-body">
                    <p style="font-size:0.82rem;color:var(--text-muted);margin-bottom:1rem;line-height:1.6;">Pin your exact bakery location on the map so customers can see how far you are when reviewing your bids.</p>

                    <button type="button" class="btn-locate" onclick="locateMe()">🎯 Use My Current Location</button>
                    <div class="map-coords" id="map-coords">📍 Pinned: <span id="coords-display"></span></div>

                    <div id="profile-map" style="margin-bottom:1rem;"></div>

                    <div class="form-group">
                        <label class="form-label">Full Address <span class="req">*</span></label>
                        <input type="text" name="full_address" id="display-address" class="form-input" value="{{ old('full_address', $bakerRecord?->full_address ?? $bakerRecord?->address) }}" placeholder="Auto-fills when you pin the map, or type manually">
                        @error('full_address') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <input type="hidden" name="latitude"  id="input-lat"  value="{{ old('latitude',  $bakerRecord?->latitude) }}">
                    <input type="hidden" name="longitude" id="input-lng"  value="{{ old('longitude', $bakerRecord?->longitude) }}">
                    <input type="hidden" name="address"   id="input-addr" value="{{ old('address',   $bakerRecord?->address) }}">
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;">
                <button type="submit" class="btn-save">💾 Save Location</button>
            </div>
        </form>
    </div>

   {{-- ══ PORTFOLIO TAB ══ --}}
    <div class="tab-panel" id="tab-portfolio">
        <form method="POST" action="{{ route('baker.profile.update') }}" enctype="multipart/form-data" id="portfolio-form">
            @csrf @method('PUT')
            <input type="hidden" name="_tab" value="portfolio">

            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-title"><div class="section-card-icon">🎂</div> Cake Designs</div>
                    <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;" id="portfolio-count-label"></span>
                </div>
                <div class="section-card-body">
                    @php
                        $portfolio = [];
                        if ($bakerRecord?->portfolio) {
                            $portfolio = is_array($bakerRecord->portfolio)
                                ? $bakerRecord->portfolio
                                : (json_decode($bakerRecord->portfolio, true) ?? []);
                        }
                        $maxPhotos = 5;
                    @endphp

                    <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:1rem;line-height:1.6;">
                        Click an empty slot to add a photo. Click <strong style="color:#C0392B;">✕</strong> on any photo to remove it. You can have up to <strong>5</strong> designs.
                    </p>

                    {{-- Dynamic grid managed by JS --}}
                    <div class="portfolio-grid" id="portfolio-grid"></div>

                    {{-- Hidden: tracks which existing photos to delete --}}
                    <div id="remove-inputs-container"></div>

                    {{-- Hidden: new file inputs appended by JS --}}
                    <div id="new-file-inputs-container" style="display:none;"></div>

                    <div style="background:var(--cream);border:1px solid var(--border);border-radius:10px;padding:0.75rem 1rem;font-size:0.78rem;color:var(--text-muted);margin-top:0.75rem;">
                        💡 JPG or PNG · Max 5MB each · Slots auto-shift when a photo is removed.
                    </div>
                </div>
            </div>

          <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
                <button type="button" class="btn-save" onclick="submitPortfolioForm()">💾 Save Cake Designs</button>
            </div>
        </form>

        {{-- Seed existing portfolio data into JS --}}
        <script>
            window._existingPortfolio = @json($portfolio);
            window._portfolioMax = {{ $maxPhotos }};
            window._storageBase = "{{ Storage::url('') }}";
        </script>
    </div>
{{-- ══ REVIEWS TAB ══ --}}
<div class="tab-panel" id="tab-reviews">

    @php
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
        $ratingCounts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
        foreach($reviews as $r) { $ratingCounts[(int)$r->rating] = ($ratingCounts[(int)$r->rating] ?? 0) + 1; }
    @endphp

    <div class="section-card" style="margin-bottom:1.5rem;">
        <div class="section-card-header">
            <div class="section-card-title">
                <div class="section-card-icon">⭐</div>
                Customer Reviews
            </div>
            <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">{{ $reviews->count() }} total review{{ $reviews->count() !== 1 ? 's' : '' }}</span>
        </div>
        <div class="section-card-body">

            @if($reviews->count() === 0)
                <div style="text-align:center;padding:2.5rem 1rem;">
                    <div style="font-size:2.5rem;margin-bottom:0.75rem;">🎂</div>
                    <div style="font-size:0.95rem;font-weight:600;color:var(--text-mid);margin-bottom:0.35rem;">No reviews yet</div>
                    <div style="font-size:0.8rem;color:var(--text-muted);">Reviews will appear here once customers complete their orders.</div>
                </div>
            @else

                <div style="display:flex;gap:2rem;align-items:center;padding-bottom:1.25rem;border-bottom:1px solid var(--border);margin-bottom:1.25rem;flex-wrap:wrap;">
                    <div style="text-align:center;min-width:80px;">
                        <div style="font-size:3rem;font-weight:800;color:var(--brown-deep);line-height:1;">{{ $avgRating }}</div>
                        <div style="color:#F59E0B;font-size:1.1rem;margin:0.25rem 0;">
                            @for($i=1;$i<=5;$i++){{ $i <= round($avgRating) ? '★' : '☆' }}@endfor
                        </div>
                        <div style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">out of 5</div>
                    </div>
                    <div style="flex:1;min-width:180px;">
                        @foreach([5,4,3,2,1] as $star)
                        @php $count = $ratingCounts[$star]; $pct = $reviews->count() > 0 ? round(($count/$reviews->count())*100) : 0; @endphp
                        <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.4rem;">
                            <span style="font-size:0.72rem;font-weight:700;color:var(--text-muted);width:10px;text-align:right;">{{ $star }}</span>
                            <span style="color:#F59E0B;font-size:0.72rem;">★</span>
                            <div style="flex:1;height:7px;background:var(--border);border-radius:999px;overflow:hidden;">
                                <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#F59E0B,#FCD34D);border-radius:999px;"></div>
                            </div>
                            <span style="font-size:0.7rem;color:var(--text-muted);width:22px;">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                @foreach($reviews as $review)
                <div style="padding:1.1rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                    <div style="display:flex;align-items:flex-start;gap:0.85rem;">
                        <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--caramel),var(--caramel-light));display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($review->customer?->first_name ?? 'C', 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.4rem;margin-bottom:0.3rem;">
                                <span style="font-size:0.88rem;font-weight:700;color:var(--brown-deep);">
                                    {{ $review->customer ? $review->customer->first_name . ' ' . substr($review->customer->last_name,0,1) . '.' : 'Customer' }}
                                </span>
                                <span style="font-size:0.7rem;color:var(--text-muted);">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div style="color:#F59E0B;font-size:0.85rem;margin-bottom:0.45rem;">
                                @for($i=1;$i<=5;$i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                                <span style="font-size:0.72rem;color:var(--text-muted);margin-left:4px;font-weight:600;">{{ $review->rating }}/5</span>
                            </div>
                            @if($review->comment)
                            <div style="font-size:0.83rem;color:var(--text-mid);line-height:1.6;background:var(--cream);border-left:3px solid var(--caramel);padding:0.6rem 0.85rem;border-radius:0 8px 8px 0;">
                                "{{ $review->comment }}"
                            </div>
                            @else
                            <div style="font-size:0.78rem;color:var(--text-muted);font-style:italic;">No written comment.</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

            @endif
        </div>
    </div>
</div>

{{-- ══ PAYMENTS TAB ══ --}}
<div class="tab-panel" id="tab-payments">
        @include('baker.payment-methods.index')

    </div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ── TAB SWITCHING ──
function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    if (btn) btn.classList.add('active');

    if (name === 'location'  && !window._mapInitialized) initMap();
    if (name === 'portfolio' && window._portfolioRender)  window._portfolioRender();
}

// Boot portfolio grid on first load
document.addEventListener('DOMContentLoaded', function () {
    if (window._portfolioRender) window._portfolioRender();
});

// ── SPECIALTIES ──
document.querySelectorAll('.specialty-check').forEach(label => {
    label.addEventListener('click', function () {
        const input = this.querySelector('input'), ind = this.querySelector('.check-indicator');
        setTimeout(() => { this.classList.toggle('checked', input.checked); ind.textContent = input.checked ? '✓' : ''; }, 0);
    });
});
// ── FILE UPLOAD ──
function handleFile(input, areaId, nameId) {
    const area = document.getElementById(areaId), nameEl = document.getElementById(nameId);
    if (input.files && input.files[0]) { area.classList.add('has-file'); nameEl.style.display = 'block'; nameEl.textContent = '✓ ' + input.files[0].name; }
}
// ── PORTFOLIO MANAGER ──
window._portfolioRender = (function () {
    let existing    = [];
    let newSlots    = {};
    let removedPaths = [];   // ← persistent removal tracker
    let MAX         = 5;
    let booted      = false;

    function boot() {
        existing = (window._existingPortfolio || []).slice();
        MAX      = window._portfolioMax || 5;
        booted   = true;
    }

    function totalCount() { return existing.length + Object.keys(newSlots).length; }
    function emptySlots()  { return MAX - totalCount(); }

    function render() {
        if (!booted) boot();
        const grid   = document.getElementById('portfolio-grid');
        const label  = document.getElementById('portfolio-count-label');
        const nwCont = document.getElementById('new-file-inputs-container');
        if (!grid) return;

        grid.innerHTML  = '';
        nwCont.innerHTML = '';
        // NOTE: do NOT clear rmCont here — we rebuild it from removedPaths array instead
        const rmCont = document.getElementById('remove-inputs-container');
        rmCont.innerHTML = '';
        removedPaths.forEach(function (path) {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'remove_photos[]'; inp.value = path;
            rmCont.appendChild(inp);
        });

        label.textContent = totalCount() + ' / ' + MAX + ' photos';

        // Existing saved photos
        existing.forEach(function (path, i) {
            const div = document.createElement('div');
            div.className = 'portfolio-item';
            div.innerHTML = '<img src="' + window._storageBase + path + '" alt="Design">'
                          + '<button type="button" class="portfolio-del-btn" title="Remove">✕</button>';
            div.querySelector('.portfolio-del-btn').addEventListener('click', function () {
                removedPaths.push(path);   // ← add to persistent tracker
                existing.splice(i, 1);
                render();
            });
            grid.appendChild(div);
        });

        // New pending photos
        Object.keys(newSlots).forEach(function (key) {
            const slot = newSlots[key];
            const div  = document.createElement('div');
            div.className = 'portfolio-item';
            div.innerHTML = '<img src="' + slot.previewURL + '" alt="New">'
                          + '<span class="portfolio-new-badge">NEW</span>'
                          + '<button type="button" class="portfolio-del-btn" title="Remove">✕</button>';
            div.querySelector('.portfolio-del-btn').addEventListener('click', function () {
                URL.revokeObjectURL(slot.previewURL);
                delete newSlots[key];
                render();
            });
            grid.appendChild(div);

            const inp = document.createElement('input');
            inp.type = 'file'; inp.name = 'new_photos[]'; inp.style.display = 'none';
            nwCont.appendChild(inp);
            try {
                const dt = new DataTransfer();
                dt.items.add(slot.file);
                inp.files = dt.files;
            } catch(e) {
                inp._file = slot.file;
            }
        });

        // Empty add-photo slots
        for (let e = 0; e < emptySlots(); e++) {
            const slotKey = 'slot_' + Date.now() + '_' + e;
            const div = document.createElement('div');
            div.className = 'portfolio-item portfolio-empty';
            div.style.position = 'relative';
            div.innerHTML = '<input type="file" accept=".jpg,.jpeg,.png"'
                          + ' style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;z-index:3;">'
                          + '<span>📷</span>'
                          + '<span class="portfolio-empty-label">Add Photo</span>';
            div.querySelector('input[type=file]').addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                if (file.size > 5 * 1024 * 1024) { alert('Max 5MB per photo.'); return; }
                if (totalCount() >= MAX) { alert('Maximum ' + MAX + ' photos reached.'); return; }
                newSlots[slotKey] = { file: file, previewURL: URL.createObjectURL(file) };
                render();
            });
            grid.appendChild(div);
        }
    }

    return render;
})();

// ── PORTFOLIO FORM SUBMIT via FormData ──
function submitPortfolioForm() {
    const form = document.getElementById('portfolio-form');
    const fd   = new FormData();

    fd.append('_token', document.querySelector('input[name="_token"]').value);
    fd.append('_method', 'PUT');
    fd.append('_tab', 'portfolio');

    // Remove inputs — now reliably populated from persistent array
    document.querySelectorAll('#remove-inputs-container input').forEach(inp => {
        fd.append('remove_photos[]', inp.value);
    });

    // New file inputs
    document.querySelectorAll('#new-file-inputs-container input[type=file]').forEach(inp => {
        const file = (inp.files && inp.files[0]) ? inp.files[0] : inp._file;
        if (file) fd.append('new_photos[]', file);
    });

    fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }, redirect: 'follow' })
        .then(() => {
            window.location.href = '{{ route("baker.profile.index") }}?tab=portfolio';
        })
        .catch(() => { form.submit(); });
}

// ── PHONE ──
const phoneInput = document.getElementById('phone');
if (phoneInput) {
    const phoneErr = document.getElementById('phone_err');
    phoneInput.addEventListener('input', function () { this.value = this.value.replace(/\D/g,'').slice(0,12); });
    phoneInput.addEventListener('blur', function () {
        if (this.value.length > 0 && this.value.length !== 12) { phoneErr.textContent = 'Must be exactly 12 digits.'; phoneErr.style.display = 'block'; }
        else { phoneErr.style.display = 'none'; }
    });
}

// ── MAP ──
window._mapInitialized = false;
let _map, _marker;
const _brownIcon = null;

function initMap() {
    window._mapInitialized = true;
    const lat = parseFloat(document.getElementById('input-lat').value) || 14.5995;
    const lng = parseFloat(document.getElementById('input-lng').value) || 120.9842;
    const zoom = document.getElementById('input-lat').value ? 15 : 13;

    _map = L.map('profile-map').setView([lat, lng], zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap', maxZoom: 19 }).addTo(_map);

    const icon = L.divIcon({ html: `<div style="width:26px;height:26px;background:linear-gradient(135deg,#7A4A28,#C8893A);border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.3);"></div>`, iconSize:[26,26], iconAnchor:[13,26], className:'' });

    if (document.getElementById('input-lat').value) {
        _marker = L.marker([lat, lng], { icon, draggable: true }).addTo(_map);
        _marker.on('dragend', () => { const p = _marker.getLatLng(); updateCoords(p.lat, p.lng); reverseGeocode(p.lat, p.lng); });
        showCoords(lat, lng);
    }

    _map.on('click', e => {
        if (_marker) _marker.setLatLng([e.latlng.lat, e.latlng.lng]);
        else { _marker = L.marker([e.latlng.lat, e.latlng.lng], { icon, draggable: true }).addTo(_map); _marker.on('dragend', () => { const p = _marker.getLatLng(); updateCoords(p.lat, p.lng); reverseGeocode(p.lat, p.lng); }); }
        updateCoords(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

function updateCoords(lat, lng) {
    document.getElementById('input-lat').value = lat.toFixed(7);
    document.getElementById('input-lng').value = lng.toFixed(7);
    showCoords(lat, lng);
}
function showCoords(lat, lng) {
    const el = document.getElementById('map-coords');
    el.classList.add('visible');
    document.getElementById('coords-display').textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
}
function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(r => r.json())
        .then(d => { if (d?.display_name) { document.getElementById('display-address').value = d.display_name; document.getElementById('input-addr').value = d.display_name; } })
        .catch(() => {});
}
function locateMe() {
    if (!navigator.geolocation) { alert('Geolocation not supported.'); return; }
    navigator.geolocation.getCurrentPosition(p => {
        if (!window._mapInitialized) initMap();
        _map.setView([p.coords.latitude, p.coords.longitude], 16);
        if (_marker) _marker.setLatLng([p.coords.latitude, p.coords.longitude]);
        else { const icon = L.divIcon({ html:`<div style="width:26px;height:26px;background:linear-gradient(135deg,#7A4A28,#C8893A);border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.3);"></div>`, iconSize:[26,26], iconAnchor:[13,26], className:'' }); _marker = L.marker([p.coords.latitude, p.coords.longitude], { icon, draggable:true }).addTo(_map); }
        updateCoords(p.coords.latitude, p.coords.longitude);
        reverseGeocode(p.coords.latitude, p.coords.longitude);
    }, () => alert('Could not get your location.'));
}

// Open to the right tab if redirected with ?tab=
const urlTab = new URLSearchParams(window.location.search).get('tab');
if (urlTab) { const btn = document.querySelector(`[onclick*="${urlTab}"]`); if (btn) switchTab(urlTab, btn); }

// If incomplete_profile flash, open to first missing tab
@if(session('incomplete_profile'))
    @if(empty($bakerRecord?->shop_name))
        switchTab('bakery', document.querySelector('[onclick*="bakery"]'));
    @elseif(empty($bakerRecord?->latitude))
        switchTab('location', document.querySelector('[onclick*="location"]'));
    @else
        switchTab('documents', document.querySelector('[onclick*="documents"]'));
    @endif
@endif
</script>
@endpush