
@php
    // Auto-detect layout based on reporter role
    $layout = $reporterRole === 'baker' ? 'layouts.baker' : 'layouts.customer';
@endphp

@extends($layout)
@section('title', 'Report ' . ($reporterRole === 'baker' ? 'Customer' : 'Baker'))

@push('styles')
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
}

.report-wrap { max-width: 640px; margin: 0 auto; }

.back-link { display:inline-flex; align-items:center; gap:0.4rem; font-size:0.82rem; color:var(--text-muted); text-decoration:none; margin-bottom:1.25rem; transition:color 0.2s; }
.back-link:hover { color:var(--caramel); }

/* ── REPORT HERO ── */
.report-hero {
    background: linear-gradient(135deg, #5A1A1A, #8B2E2E);
    border-radius: 20px; padding: 2rem 2.5rem; color: white;
    margin-bottom: 1.75rem; position: relative; overflow: hidden;
}
.report-hero::before {
    content: ''; position: absolute; right:-40px; top:-40px;
    width:200px; height:200px; border-radius:50%;
    background: rgba(255,255,255,0.05);
}
.report-hero-icon {
    width:56px; height:56px; border-radius:16px;
    background:rgba(255,255,255,0.15); border:1.5px solid rgba(255,255,255,0.25);
    display:flex; align-items:center; justify-content:center;
    font-size:1.5rem; margin-bottom:1rem; position:relative; z-index:1;
}
.report-hero-title { font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:0.35rem; position:relative; z-index:1; }
.report-hero-sub   { font-size:0.82rem; opacity:0.7; position:relative; z-index:1; }

/* ── REPORTED USER CARD ── */
.reported-user-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 16px; padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 1.5rem;
}
.reported-avatar {
    width:44px; height:44px; border-radius:50%;
    background: linear-gradient(135deg, #C07840, #E8A96A);
    color:white; display:flex; align-items:center; justify-content:center;
    font-weight:700; font-size:1.1rem; flex-shrink:0; overflow:hidden;
}
.reported-avatar img { width:100%; height:100%; object-fit:cover; }
.reported-name   { font-weight:700; font-size:0.9rem; color:var(--brown-deep); }
.reported-role   { font-size:0.72rem; color:var(--text-muted); margin-top:0.1rem; }
.reported-order  { margin-left:auto; text-align:right; font-size:0.75rem; color:var(--text-muted); }
.reported-order strong { color:var(--caramel); font-size:0.9rem; display:block; font-family:'Playfair Display',serif; }

/* ── ALREADY REPORTED ── */
.already-reported-box {
    background: #FEF9E8; border: 2px solid #F0D090; border-radius: 16px;
    padding: 1.5rem 2rem; text-align:center; margin-bottom: 1.5rem;
}
.already-reported-box .ar-icon  { font-size: 2rem; margin-bottom: 0.5rem; }
.already-reported-box .ar-title { font-family:'Playfair Display',serif; font-size:1rem; color:var(--brown-deep); margin-bottom:0.3rem; }
.already-reported-box .ar-sub   { font-size:0.78rem; color:var(--text-muted); }

/* ── FORM CARD ── */
.form-card {
    background: var(--warm-white); border: 1px solid var(--border);
    border-radius: 20px; overflow: hidden; margin-bottom: 1.5rem;
}
.form-card-header {
    padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 0.6rem;
}
.form-card-header h3 { font-family:'Playfair Display',serif; font-size:0.95rem; color:var(--brown-deep); margin:0; }
.form-card-body { padding: 1.5rem; }

.form-label {
    display: block; font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.1em;
    color: var(--text-muted); margin-bottom: 0.6rem;
}
.form-label span { color: #8B2A1E; }

/* Category list */
.category-list  { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1.25rem; }
.category-item  {
    display: flex; align-items: center; gap: 0.65rem;
    padding: 0.7rem 0.9rem; border: 1.5px solid var(--border);
    border-radius: 10px; cursor: pointer; font-size: 0.82rem;
    color: var(--text-dark); background: white; transition: all 0.15s; user-select: none;
}
.category-item:hover  { border-color: #8B2A1E; background: #FDF5F3; }
.category-item.selected { border-color: #8B2A1E; background: #FDF0EE; color: #5A1A1A; font-weight: 600; }
.category-radio {
    width: 16px; height: 16px; border-radius: 50%; border: 2px solid var(--border);
    flex-shrink: 0; transition: all 0.15s;
}
.category-item.selected .category-radio { border-color: #8B2A1E; background: #8B2A1E; box-shadow: inset 0 0 0 3px white; }
.category-input { display: none; }

/* Textarea */
.form-textarea {
    width: 100%; padding: 0.85rem 1rem; border: 1.5px solid var(--border);
    border-radius: 10px; font-family: 'DM Sans', sans-serif;
    font-size: 0.86rem; color: var(--text-dark); resize: vertical;
    min-height: 120px; box-sizing: border-box; transition: border-color 0.2s;
}
.form-textarea:focus { outline: none; border-color: #8B2A1E; }
.char-count { font-size: 0.7rem; color: var(--text-muted); text-align: right; margin-top: 0.3rem; }

/* Screenshot upload */
.screenshot-dropzone {
    border: 2px dashed var(--border); border-radius: 12px;
    padding: 1.5rem; text-align: center; cursor: pointer;
    background: var(--cream); transition: all 0.2s; position: relative;
}
.screenshot-dropzone:hover { border-color: var(--caramel); background: #FBF3E8; }
.screenshot-dropzone.has-file { border-color: #166534; background: #EBF5EE; }
.screenshot-dropzone input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; }
.sdz-icon    { font-size: 1.5rem; margin-bottom: 0.4rem; }
.sdz-text    { font-size: 0.82rem; font-weight: 600; color: var(--text-mid); }
.sdz-sub     { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.2rem; }
.sdz-preview { max-width:100%; max-height:160px; object-fit:contain; border-radius:8px; margin-top:0.75rem; display:none; }
.sdz-filename{ font-size:0.76rem; color:#166534; font-weight:600; margin-top:0.5rem; display:none; }

/* Warning box */
.warning-box {
    background: #FEF9E8; border: 1.5px solid #F0D090; border-radius: 12px;
    padding: 0.9rem 1.1rem; display: flex; gap: 0.65rem;
    font-size: 0.78rem; color: #8A5010; line-height: 1.6; margin-bottom: 1.5rem;
}

/* Submit */
.submit-btn {
    width: 100%; padding: 0.9rem; border: none; border-radius: 12px;
    background: linear-gradient(135deg, #8B2A1E, #C44030);
    color: white; font-size: 0.9rem; font-weight: 700;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(139,42,30,0.35); transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
}
.submit-btn:disabled { opacity: 0.45; cursor: not-allowed; }
.submit-btn:not(:disabled):hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(139,42,30,0.45); }

@keyframes spin { to { transform: rotate(360deg); } }
.btn-spinner { width:16px; height:16px; border:2px solid rgba(255,255,255,0.3); border-top-color:white; border-radius:50%; animation:spin 0.7s linear infinite; display:none; }
.is-submitting .btn-spinner { display:block; }
.is-submitting .btn-label   { display:none; }
</style>
@endpush

@section('content')

@php
    $backRoute = $reporterRole === 'baker'
        ? route('baker.orders.show', $bakerOrder->id)
        : route('customer.cake-requests.show', $bakerOrder->cake_request_id);
  $categories = $reporterRole === 'baker'
    ? \App\Models\Report::BAKER_CATEGORIES
    : \App\Models\Report::CUSTOMER_CATEGORIES;
@endphp

<div class="report-wrap">

<a href="{{ $backRoute }}" class="back-link">← Back to Order</a>

{{-- ── HERO ── --}}
<div class="report-hero">
    <div class="report-hero-icon">⚠️</div>
    <div class="report-hero-title">
        Report {{ $reporterRole === 'baker' ? 'Customer' : 'Baker' }}
    </div>
    <div class="report-hero-sub">
        Help us keep BakeSphere safe — reports are reviewed by our admin team within 24–48 hours.
    </div>
</div>

{{-- ── REPORTED USER ── --}}
<div class="reported-user-card">
    <div class="reported-avatar">
        @if($reportedUser->profile_photo)
            <img src="{{ asset('storage/'.$reportedUser->profile_photo) }}" alt="">
        @else
            {{ strtoupper(substr($reportedUser->first_name, 0, 1)) }}
        @endif
    </div>
    <div>
        <div class="reported-name">{{ $reportedUser->first_name }} {{ $reportedUser->last_name }}</div>
        <div class="reported-role">
            {{ $reporterRole === 'baker' ? '👤 Customer' : '👨‍🍳 Baker' }}
        </div>
    </div>
    <div class="reported-order">
        <strong>#{{ str_pad($bakerOrder->id, 4, '0', STR_PAD_LEFT) }}</strong>
        Order Reference
    </div>
</div>

{{-- ── ALREADY REPORTED ── --}}
@if($existing)
<div class="already-reported-box">
    <div class="ar-icon">✅</div>
    <div class="ar-title">Report Already Submitted</div>
    <div class="ar-sub">
        You submitted a report for this order on {{ $existing->created_at->format('M d, Y') }}.
        Status: <strong>{{ \App\Models\Report::STATUSES[$existing->status]['label'] ?? $existing->status }}</strong>
    </div>
</div>
@else

{{-- ── WARNING ── --}}
<div class="warning-box">
    <span>⚠️</span>
    <div>
        <strong>Important:</strong> False reports are taken seriously and may result in account suspension.
        Only submit if you have a genuine concern. All reports are anonymous to the reported party.
    </div>
</div>

{{-- ── REPORT FORM ── --}}
@if($errors->any())
<div style="background:#FDF0EE; border:1.5px solid #F5C5BE; border-radius:12px; padding:0.85rem 1.1rem; margin-bottom:1.25rem; font-size:0.82rem; color:#8B2A1E;">
    @foreach($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
</div>
@endif

<form method="POST" action="{{ route('report.store', $bakerOrder->id) }}"
      enctype="multipart/form-data" id="reportForm"
      onsubmit="handleSubmit(event)">
    @csrf

    {{-- Category --}}
    <div class="form-card">
        <div class="form-card-header">
            <span>📋</span>
            <h3>What is your complaint about? <span style="color:#8B2A1E;">*</span></h3>
        </div>
        <div class="form-card-body">
            <div class="category-list">
                @foreach($categories as $key => $label)
                <label class="category-item {{ old('category') === $key ? 'selected' : '' }}" id="cat-label-{{ $key }}">
                    <div class="category-radio"></div>
                    <input type="radio" name="category" value="{{ $key }}" class="category-input"
                           {{ old('category') === $key ? 'checked' : '' }}
                           onchange="selectCategory('{{ $key }}')">
                    {{ $label }}
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Description --}}
    <div class="form-card">
        <div class="form-card-header">
            <span>📝</span>
            <h3>Describe what happened <span style="color:#8B2A1E;">*</span></h3>
        </div>
        <div class="form-card-body">
            <textarea name="description" class="form-textarea" id="descriptionArea"
                      placeholder="Please provide as much detail as possible — what happened, when it happened, and any other relevant context…"
                      maxlength="2000"
                      oninput="updateCharCount(this)">{{ old('description') }}</textarea>
            <div class="char-count"><span id="charCount">{{ strlen(old('description','')) }}</span>/2000</div>
        </div>
    </div>

    {{-- Screenshot --}}
    <div class="form-card">
        <div class="form-card-header">
            <span>🖼️</span>
            <h3>Attach Screenshot <span style="color:var(--text-muted); font-weight:400; font-size:0.82rem;">(optional)</span></h3>
        </div>
        <div class="form-card-body">
            <div class="screenshot-dropzone" id="screenshotDropzone">
                <input type="file" name="screenshot" accept=".jpg,.jpeg,.png"
                       onchange="handleScreenshot(this)">
                <div class="sdz-icon">📎</div>
                <div class="sdz-text">Click to attach a screenshot</div>
                <div class="sdz-sub">JPG or PNG · max 4MB</div>
                <img id="sdz-preview" class="sdz-preview" src="" alt="Preview">
                <div id="sdz-filename" class="sdz-filename"></div>
            </div>
        </div>
    </div>

    <button type="submit" class="submit-btn" id="submitBtn">
        <span class="btn-spinner"></span>
        <span class="btn-label">⚠️ Submit Report</span>
    </button>
</form>
@endif

</div>

@push('scripts')
<script>
function selectCategory(key) {
    document.querySelectorAll('.category-item').forEach(el => el.classList.remove('selected'));
    document.getElementById('cat-label-' + key)?.classList.add('selected');
}

function updateCharCount(el) {
    document.getElementById('charCount').textContent = el.value.length;
}

function handleScreenshot(input) {
    const file = input.files[0];
    if (!file) return;
    const dz = document.getElementById('screenshotDropzone');
    dz.classList.add('has-file');
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('sdz-preview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('sdz-filename').style.display = 'none';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('sdz-filename').textContent = '📄 ' + file.name;
        document.getElementById('sdz-filename').style.display = 'block';
    }
}

function handleSubmit(e) {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.classList.add('is-submitting');
}
</script>
@endpush

@endsection