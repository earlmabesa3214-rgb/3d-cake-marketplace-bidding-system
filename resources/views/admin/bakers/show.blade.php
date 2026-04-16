@extends('layouts.admin')
@section('title', 'Baker — ' . $baker->name)
@section('content')
<style>
:root{--gold:#C07828;--gold-dk:#9A5E14;--gold-lt:#DC9E48;--gold-soft:#FEF3E2;--copper:#A45224;--teal:#1F7A6C;--teal-soft:#E4F2EF;--rose:#B43840;--rose-soft:#FDEAEB;--espresso:#2C1608;--mocha:#6A4824;--t1:#1E0E04;--t2:#4A2C14;--tm:#8C6840;--s:#FFF;--s2:#FAF7F2;--s3:#F2ECE2;--bdr:#E8E0D0;--bdr-md:#D8CCBA;--r:10px;--rl:14px;--rxl:20px;}
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
*,*::before,*::after{box-sizing:border-box;}
.pg {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: .75rem 1.5rem 4rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.back-btn{display:inline-flex;align-items:center;gap:.4rem;font-size:.78rem;font-weight:600;color:var(--tm);text-decoration:none;margin-bottom:.875rem;transition:color .15s;}
.back-btn:hover{color:var(--gold);}
.hero{background:linear-gradient(135deg,var(--espresso) 0%,#3E1E08 55%,#5C2C10 100%);border-radius:var(--rxl);padding:1.5rem 2rem;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;position:relative;overflow:hidden;animation:fadeUp .35s ease both;}
.hero::before{content:'';position:absolute;inset:0;opacity:.03;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:24px 24px;}
.hero-left{display:flex;align-items:center;gap:1.25rem;position:relative;z-index:1;}
.hero-avatar{width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--gold),var(--copper));display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1rem;color:#fff;flex-shrink:0;}
.hero-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.375rem;font-weight:800;color:#fff;line-height:1.2;margin-bottom:.2rem;letter-spacing:-.02em;}
.hero-shop{font-size:.8rem;color:rgba(255,255,255,.5);}
.hero-right{display:flex;align-items:center;gap:.75rem;position:relative;z-index:1;flex-wrap:wrap;}
.badge{display:inline-flex;align-items:center;gap:.35rem;padding:.3rem .85rem;border-radius:20px;font-size:.7rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
.badge-registered{background:rgba(31,122,108,.25);border:1px solid rgba(31,122,108,.4);color:#7ADBC8;}
.badge-homebased{background:rgba(192,120,40,.22);border:1px solid rgba(192,120,40,.38);color:#DC9E48;}
.badge-pending{background:rgba(255,200,40,.14);border:1px solid rgba(255,200,40,.28);color:#F5D060;}
.badge-approved{background:rgba(31,122,108,.22);border:1px solid rgba(31,122,108,.4);color:#7ADBC8;}
.badge-rejected{background:rgba(180,56,64,.22);border:1px solid rgba(180,56,64,.38);color:#F08090;}
.action-bar{display:flex;gap:.625rem;margin-bottom:1.25rem;flex-wrap:wrap;animation:fadeUp .35s ease .05s both;}
.btn-approve{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.25rem;background:linear-gradient(135deg,var(--teal),#2A9A88);color:#fff;border:none;border-radius:var(--r);font-size:.82rem;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .15s;}
.btn-approve:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(31,122,108,.3);}
.btn-reject{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.25rem;background:linear-gradient(135deg,var(--rose),#943040);color:#fff;border:none;border-radius:var(--r);font-size:.82rem;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .15s;}
.btn-reject:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(180,56,64,.28);}
.layout { display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; align-items: start; }

.card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);overflow:hidden;margin-bottom:1.125rem;animation:fadeUp .38s ease .1s both;}
.card:last-child{margin-bottom:0;}
.card-head{display:flex;align-items:center;gap:.6rem;padding:.8rem 1.25rem;border-bottom:1.5px solid var(--bdr);background:var(--s2);}
.card-head-icon{width:28px;height:28px;border-radius:7px;background:var(--gold-soft);display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0;}
.card-head h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:.82rem;font-weight:700;color:var(--t2);margin:0;}
.info-row{display:flex;justify-content:space-between;align-items:center;padding:.625rem 1.25rem;border-bottom:1px solid var(--bdr);gap:1rem;}
.info-row:last-child{border-bottom:none;}
.info-key{font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--tm);font-weight:700;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;}
.info-val{font-size:.82rem;color:var(--t1);font-weight:500;text-align:right;font-family:'Plus Jakarta Sans',sans-serif;}
.info-val a{color:var(--gold);text-decoration:none;}
.info-val a:hover{text-decoration:underline;}
.tag{display:inline-flex;padding:.18rem .55rem;border-radius:6px;font-size:.65rem;font-weight:600;background:var(--gold-soft);border:1px solid rgba(192,120,40,.2);color:var(--gold-dk);margin:.18rem .15rem;font-family:'Plus Jakarta Sans',sans-serif;}
.bio-text{padding:1rem 1.25rem;font-size:.82rem;color:var(--t2);line-height:1.75;font-family:'Plus Jakarta Sans',sans-serif;}
.doc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1.125rem 1.25rem; }
.doc-item{border:1.5px solid var(--bdr);border-radius:var(--rl);overflow:hidden;background:var(--s2);}
.doc-label{padding:.45rem .75rem;font-size:.62rem;text-transform:uppercase;letter-spacing:.1em;color:var(--tm);font-weight:700;border-bottom:1px solid var(--bdr);font-family:'Plus Jakarta Sans',sans-serif;}
.doc-preview{position:relative;aspect-ratio:4/3;background:var(--s3);display:flex;align-items:center;justify-content:center;}
.doc-preview img{width:100%;height:100%;object-fit:cover;cursor:pointer;transition:opacity .15s;}
.doc-preview img:hover{opacity:.85;}
.doc-pdf{display:flex;flex-direction:column;align-items:center;gap:.4rem;color:var(--tm);font-size:.75rem;}
.doc-none{color:var(--tm);font-size:.73rem;font-family:'Plus Jakarta Sans',sans-serif;}
.portfolio-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: .75rem; padding: 1.125rem 1.25rem; }
.portfolio-item{aspect-ratio:1;border-radius:var(--r);overflow:hidden;background:var(--s3);}
.portfolio-item img{width:100%;height:100%;object-fit:cover;cursor:pointer;transition:transform .2s;}
.portfolio-item img:hover{transform:scale(1.04);}
.side-card{background:var(--s);border:1.5px solid var(--bdr);border-radius:var(--rxl);overflow:hidden;margin-bottom:1.125rem;}
.side-card:last-child{margin-bottom:0;}
.side-head{padding:.7rem 1rem;border-bottom:1px solid var(--bdr);background:var(--s2);font-size:.76rem;font-weight:700;color:var(--t2);font-family:'Plus Jakarta Sans',sans-serif;}
.side-body{padding:.75rem 1rem;}
.meta-item{display:flex;align-items:flex-start;gap:.5rem;padding:.4rem 0;border-bottom:1px solid var(--bdr);}
.meta-item:last-child{border-bottom:none;}
.meta-icon{width:20px;text-align:center;font-size:.82rem;flex-shrink:0;margin-top:.05rem;}
.meta-key{font-size:.62rem;text-transform:uppercase;color:var(--tm);font-weight:700;margin-bottom:.1rem;font-family:'Plus Jakarta Sans',sans-serif;}
.meta-val{color:var(--t1);font-size:.78rem;font-family:'Plus Jakarta Sans',sans-serif;}
.type-banner{padding:.875rem 1.25rem;display:flex;align-items:center;gap:.75rem;}
.type-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
.type-registered .type-icon{background:var(--teal-soft);}
.type-homebased .type-icon{background:var(--gold-soft);}
.type-title{font-size:.85rem;font-weight:700;color:var(--t1);font-family:'Plus Jakarta Sans',sans-serif;}
.type-sub{font-size:.71rem;color:var(--tm);margin-top:.15rem;font-family:'Plus Jakarta Sans',sans-serif;}
.lightbox{position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:9000;display:none;align-items:center;justify-content:center;padding:1.5rem;}
.lightbox.open{display:flex;}
.lightbox img{max-width:90vw;max-height:88vh;border-radius:12px;box-shadow:0 24px 64px rgba(0,0,0,.5);}
.lb-close{position:fixed;top:1.25rem;right:1.5rem;width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.12);border:none;color:#fff;font-size:1.3rem;cursor:pointer;display:flex;align-items:center;justify-content:center;}
.alert-success{display:flex;align-items:center;gap:.75rem;padding:.8rem 1rem;border-radius:var(--r);font-size:.8rem;font-weight:500;margin-bottom:1rem;background:var(--teal-soft);border:1.5px solid rgba(31,122,108,.25);color:var(--teal);font-family:'Plus Jakarta Sans',sans-serif;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}.doc-grid{grid-template-columns:1fr;}.hero{flex-direction:column;align-items:flex-start;}.hero-right{flex-wrap:wrap;}}
</style>

<div class="pg">

<a href="{{ route('bakers.index') }}" class="back-btn">← Back to Baker Registry</a>

@if(session('success'))
<div class="alert-success">✅ {{ session('success') }}</div>
@endif

{{-- HERO --}}
<div class="hero">
    <div class="hero-left">
        <div class="hero-avatar">{{ strtoupper(substr($baker->name,0,2)) }}</div>
        <div>
            <div class="hero-name">{{ $baker->name }}</div>
            <div class="hero-shop">{{ $baker->shop_name ?? 'Baker Application' }} · Submitted {{ $baker->created_at->format('M d, Y') }}</div>
        </div>
    </div>
    <div class="hero-right">
        @if($baker->seller_type === 'homebased')
            <span class="badge badge-homebased">🏠 Home-Based Baker</span>
        @else
            <span class="badge badge-registered">🏢 Registered Business</span>
        @endif
        <span class="badge badge-{{ $baker->status }}">
            @if($baker->status==='pending')⏳@elseif($baker->status==='approved')✅@else✕@endif
            {{ ucfirst($baker->status) }}
        </span>
    </div>
</div>

{{-- ACTION BAR --}}
@if($baker->status === 'pending')
<div class="action-bar">
    <form method="POST" action="{{ route('bakers.approve', $baker->id) }}" style="display:inline">
        @csrf @method('PATCH')
        <button type="submit" class="btn-approve">✓ Approve Application</button>
    </form>
    <form method="POST" action="{{ route('bakers.reject', $baker->id) }}" style="display:inline">
        @csrf @method('PATCH')
        <button type="submit" class="btn-reject">✕ Reject Application</button>
    </form>
</div>
@endif

<div class="layout">

{{-- LEFT COLUMN --}}
<div>

    {{-- BAKER TYPE --}}
    <div class="card">
        <div class="card-head">
            <div class="card-head-icon">{{ $baker->seller_type==='homebased'?'🏠':'🏢' }}</div>
            <h3>Baker Type</h3>
        </div>
        <div class="type-banner type-{{ $baker->seller_type }}">
            <div class="type-icon">{{ $baker->seller_type==='homebased'?'🧁':'🏛️' }}</div>
            <div>
                <div class="type-title">{{ $baker->seller_type==='homebased'?'Home-Based Baker':'Registered Business' }}</div>
                <div class="type-sub">{{ $baker->seller_type==='homebased'?'Verified via government ID and selfie — no business permit required.':'Verified via DTI/SEC registration, business permit, and sanitary permit.' }}</div>
            </div>
        </div>
    </div>

    {{-- PERSONAL INFO --}}
    <div class="card">
        <div class="card-head"><div class="card-head-icon">👤</div><h3>Personal Information</h3></div>
        <div class="info-row"><span class="info-key">Full Name</span><span class="info-val">{{ $baker->name }}</span></div>
        <div class="info-row"><span class="info-key">Email</span><span class="info-val"><a href="mailto:{{ $baker->email }}">{{ $baker->email }}</a></span></div>
        <div class="info-row"><span class="info-key">Phone</span><span class="info-val">{{ $baker->phone ?? '—' }}</span></div>
        <div class="info-row"><span class="info-key">Address</span><span class="info-val">{{ $baker->full_address ?? $baker->address ?? '—' }}</span></div>
        @if($baker->latitude && $baker->longitude)
        <div class="info-row">
            <span class="info-key">Map</span>
            <span class="info-val"><a href="https://maps.google.com/?q={{ $baker->latitude }},{{ $baker->longitude }}" target="_blank">📍 View on Google Maps</a></span>
        </div>
        @endif
        <div class="info-row"><span class="info-key">Submitted</span><span class="info-val">{{ $baker->created_at->format('M d, Y · g:i A') }}</span></div>
    </div>

    {{-- BAKERY INFO --}}
    <div class="card">
        <div class="card-head"><div class="card-head-icon">🎂</div><h3>Bakery Information</h3></div>
        <div class="info-row"><span class="info-key">Shop Name</span><span class="info-val">{{ $baker->shop_name ?? '—' }}</span></div>
        <div class="info-row"><span class="info-key">Experience</span><span class="info-val">{{ $baker->experience_years ?? '—' }}</span></div>
        <div class="info-row"><span class="info-key">Min. Order</span><span class="info-val">{{ $baker->min_order_price ? '₱'.number_format($baker->min_order_price,0) : '—' }}</span></div>
        @if($baker->social_media)
        <div class="info-row"><span class="info-key">Social Media</span><span class="info-val"><a href="{{ $baker->social_media }}" target="_blank">{{ $baker->social_media }}</a></span></div>
        @endif
        @php $specs = is_array($baker->specialties) ? $baker->specialties : json_decode($baker->specialties ?? '[]', true); @endphp
        @if(!empty($specs))
        <div class="info-row">
            <span class="info-key">Specialties</span>
            <span class="info-val">@foreach($specs as $s)<span class="tag">{{ $s }}</span>@endforeach</span>
        </div>
        @endif
    </div>

    {{-- BIO --}}
    @if($baker->bio)
    <div class="card">
        <div class="card-head"><div class="card-head-icon">📝</div><h3>About the Baker</h3></div>
        <div class="bio-text">{{ $baker->bio }}</div>
    </div>
    @endif

    {{-- REGISTERED BUSINESS DOCS --}}
    @if($baker->seller_type === 'registered')
    <div class="card">
        <div class="card-head"><div class="card-head-icon">📋</div><h3>Business Documents</h3></div>
        <div class="info-row">
            <span class="info-key">DTI / SEC Number</span>
            <span class="info-val" style="font-family:'DM Mono',monospace;font-weight:700;color:var(--gold);">{{ $baker->dti_sec_number ?? '—' }}</span>
        </div>
        <div class="doc-grid">
            @foreach([
                'business_permit'  => "Mayor's / Business Permit",
                'dti_certificate'  => 'DTI / SEC Certificate',
                'sanitary_permit'  => 'Sanitary / Health Permit',
                'bir_certificate'  => 'BIR Certificate (optional)',
            ] as $field => $label)
            <div class="doc-item">
                <div class="doc-label">{{ $label }}</div>
                <div class="doc-preview">
                    @if($baker->$field)
                        @php
                            $cleanPath = str_replace('public/', '', $baker->$field);
                            $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                        @endphp
                        @if(in_array($ext, ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/'.$cleanPath) }}" alt="{{ $label }}" onclick="openLightbox(this.src)">
                        @else
                            <div class="doc-pdf">
                                <span style="font-size:1.8rem">📄</span>
                                <a href="{{ asset('storage/'.$cleanPath) }}" target="_blank" style="color:var(--gold);font-size:.72rem;font-weight:600;">View PDF</a>
                            </div>
                        @endif
                    @else
                        <div class="doc-none">Not uploaded</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- HOME-BASED IDENTITY DOCS --}}
    @if($baker->seller_type === 'homebased')
    <div class="card">
        <div class="card-head"><div class="card-head-icon">🪪</div><h3>Identity Verification</h3></div>
        <div class="info-row">
            <span class="info-key">ID Type</span>
            <span class="info-val">{{ $baker->gov_id_type ? ucwords(str_replace('_',' ',$baker->gov_id_type)) : '—' }}</span>
        </div>
        <div class="doc-grid">
            @foreach([
                'gov_id_front'     => "Gov't ID — Front",
                'gov_id_back'      => "Gov't ID — Back",
                'id_selfie'        => 'Selfie with ID',
                'food_safety_cert' => 'Food Safety Certificate',
            ] as $field => $label)
            <div class="doc-item">
                <div class="doc-label">{{ $label }}</div>
                <div class="doc-preview">
                    @if($baker->$field)
                        @php
                            $cleanPath = str_replace('public/', '', $baker->$field);
                            $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
                        @endphp
                        @if(in_array($ext, ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/'.$cleanPath) }}" alt="{{ $label }}" onclick="openLightbox(this.src)">
                        @else
                            <div class="doc-pdf">
                                <span style="font-size:1.8rem">📄</span>
                                <a href="{{ asset('storage/'.$cleanPath) }}" target="_blank" style="color:var(--gold);font-size:.72rem;font-weight:600;">View PDF</a>
                            </div>
                        @endif
                    @else
                        <div class="doc-none">Not uploaded</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- PORTFOLIO --}}
    @php $portfolio = is_array($baker->portfolio) ? $baker->portfolio : json_decode($baker->portfolio ?? '[]', true); @endphp
    @if(!empty($portfolio))
    <div class="card">
        <div class="card-head"><div class="card-head-icon">📸</div><h3>Portfolio Photos</h3></div>
        <div class="portfolio-grid">
            @foreach($portfolio as $photo)
            @php $cleanPhoto = str_replace('public/', '', $photo); @endphp
            <div class="portfolio-item">
                <img src="{{ asset('storage/'.$cleanPhoto) }}" alt="Portfolio" onclick="openLightbox(this.src)">
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>{{-- end left column --}}

{{-- RIGHT SIDEBAR --}}
<div>

    {{-- SUMMARY --}}
    <div class="side-card">
        <div class="side-head">📊 Application Summary</div>
        <div class="side-body">
            <div class="meta-item">
                <div class="meta-icon">🆔</div>
                <div><div class="meta-key">App ID</div><div class="meta-val" style="font-family:'DM Mono',monospace;">#{{ str_pad($baker->id,4,'0',STR_PAD_LEFT) }}</div></div>
            </div>
            <div class="meta-item">
                <div class="meta-icon">📅</div>
                <div><div class="meta-key">Submitted</div><div class="meta-val">{{ $baker->created_at->format('M d, Y') }}</div></div>
            </div>
            <div class="meta-item">
                <div class="meta-icon">{{ $baker->seller_type==='homebased'?'🏠':'🏢' }}</div>
                <div><div class="meta-key">Type</div><div class="meta-val">{{ $baker->seller_type==='homebased'?'Home-Based':'Registered Business' }}</div></div>
            </div>
            <div class="meta-item">
                <div class="meta-icon">⭐</div>
                <div><div class="meta-key">Experience</div><div class="meta-val">{{ $baker->experience_years ?? '—' }}</div></div>
            </div>
            <div class="meta-item">
                <div class="meta-icon">💰</div>
                <div><div class="meta-key">Min. Order</div><div class="meta-val">{{ $baker->min_order_price ? '₱'.number_format($baker->min_order_price,0) : '—' }}</div></div>
            </div>
        </div>
    </div>

    {{-- DOCUMENT CHECKLIST --}}
    <div class="side-card">
        <div class="side-head">✅ Document Checklist</div>
        <div class="side-body">
            @if($baker->seller_type === 'registered')
                @foreach([
                    'dti_sec_number'  => 'DTI/SEC Number',
                    'business_permit' => 'Business Permit',
                    'dti_certificate' => 'DTI Certificate',
                    'sanitary_permit' => 'Sanitary Permit',
                    'bir_certificate' => 'BIR Certificate',
                ] as $f => $l)
                <div class="meta-item">
                    <div class="meta-icon">{{ $baker->$f ? '✅' : '❌' }}</div>
                    <div class="meta-val" style="{{ $baker->$f ? '' : 'color:var(--tm)' }}">{{ $l }}</div>
                </div>
                @endforeach
            @else
                @foreach([
                    'gov_id_type'      => 'ID Type',
                    'gov_id_front'     => "Gov't ID Front",
                    'gov_id_back'      => "Gov't ID Back",
                    'id_selfie'        => 'Selfie with ID',
                    'food_safety_cert' => 'Food Safety Cert',
                ] as $f => $l)
                <div class="meta-item">
                    <div class="meta-icon">{{ $baker->$f ? '✅' : '⬜' }}</div>
                    <div class="meta-val" style="{{ $baker->$f ? '' : 'color:var(--tm)' }}">{{ $l }}</div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- DECISION (only if pending) --}}
    @if($baker->status === 'pending')
    <div class="side-card">
        <div class="side-head">⚙️ Decision</div>
        <div class="side-body" style="display:flex;flex-direction:column;gap:.625rem;">
            <form method="POST" action="{{ route('bakers.approve', $baker->id) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn-approve" style="width:100%;justify-content:center;">✓ Approve Application</button>
            </form>
            <form method="POST" action="{{ route('bakers.reject', $baker->id) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn-reject" style="width:100%;justify-content:center;">✕ Reject Application</button>
            </form>
        </div>
    </div>
    @endif

</div>{{-- end sidebar --}}
</div>{{-- end layout --}}
</div>{{-- end pg --}}

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lb-close" onclick="closeLightbox()">×</button>
    <img src="" id="lightboxImg" alt="Document preview" onclick="event.stopPropagation()">
</div>

<script>
function openLightbox(src){
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(){
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeLightbox(); });
</script>
@endsection