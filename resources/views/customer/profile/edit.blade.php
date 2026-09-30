@extends('layouts.customer')
@section('title', 'Edit Profile')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
/* Edit Profile: luxury cake-atelier form. Plus Jakarta Sans only. */
.edit-page{
--esp:#24150F;--cof:#3A241A;--ivory:#F7F2E9;--cream:#EFE6D7;--caramel:#A96F42;--gold:#B89452;--gold-l:#D4B06A;
--burg:#54252C;--taupe:#9A897A;--beige:#D8C8B7;--w:#FBF8F2;--mocha:#7A5E4C;--credit:#7A6120;
--line:rgba(36,21,15,.14);--gold-line:rgba(184,148,82,.35);--e:cubic-bezier(.2,.7,.2,1);
max-width:860px;width:100%;margin:1vh auto 4vh;padding:0 clamp(.85rem,2.5vw,2rem) 2rem;color:var(--esp);font-family:'Plus Jakarta Sans',sans-serif}
.edit-page *{box-sizing:border-box;font-family:inherit}
.edit-page a:focus-visible,.edit-page button:focus-visible,.edit-page input:focus-visible,.edit-page label:focus-within{outline:2px solid var(--gold);outline-offset:3px}
@keyframes ed-fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes ed-line{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important}}

/* header */
.edit-page .page-header{position:relative;margin:0 0 2.25rem;padding-bottom:1.75rem;animation:ed-fadeUp .6s var(--e) backwards}
.page-header::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:var(--gold-line)}
.page-header::before{content:"";position:absolute;left:0;bottom:0;width:72px;height:3px;background:var(--gold);z-index:1;transform-origin:left;animation:ed-line .9s var(--e) .3s backwards}
.page-title{font-size:clamp(2.4rem,6vw,4.2rem);font-weight:900;line-height:.95;letter-spacing:-.05em;margin:0}
.page-subtitle{margin:1rem 0 0;max-width:52ch;font-size:.98rem;line-height:1.7;color:var(--mocha)}

/* sections */
.edit-form{animation:ed-fadeUp .6s var(--e) .15s backwards}
.edit-section{padding:0 0 2.25rem;margin-bottom:2.25rem;border-bottom:1px solid var(--line)}
.section-label{display:flex;align-items:center;gap:.6rem;padding:1.25rem 0 1rem;margin-bottom:1.5rem;border-top:1px solid var(--esp);border-bottom:1px solid var(--line);font-size:.7rem;font-weight:800;letter-spacing:.24em;text-transform:uppercase}
.section-label svg{color:var(--gold)}

/* photo */
.photo-row{display:flex;align-items:center;gap:1.75rem}
@media(max-width:520px){.photo-row{flex-direction:column;align-items:flex-start}}
.photo-thumb{width:112px;height:112px;flex-shrink:0;display:grid;place-items:center;overflow:hidden;background:var(--esp);border:1px solid var(--gold-line);box-shadow:inset 0 0 0 4px var(--esp),inset 0 0 0 5px var(--gold-line);font-size:2.4rem;font-weight:900;color:var(--gold-l)}
.photo-thumb img{width:100%;height:100%;object-fit:cover;padding:6px}
.photo-info{flex:1}
.photo-info-title{font-size:1.1rem;font-weight:800;letter-spacing:-.02em;margin-bottom:.25rem}
.photo-info-hint{font-size:.78rem;color:var(--mocha);margin-bottom:1rem}
.photo-upload-btn{position:relative;overflow:hidden;display:inline-flex;align-items:center;gap:.55rem;padding:.8rem 1.2rem;background:transparent;border:1px solid var(--esp);font-size:.66rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:var(--esp);cursor:pointer;transition:background .3s,color .3s}
.photo-upload-btn:hover{background:var(--esp);color:var(--gold-l)}
.photo-upload-btn input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%}

/* fields */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem}
@media(max-width:560px){.form-row{grid-template-columns:1fr}}
.form-row:last-child{margin-bottom:0}
.form-group{display:flex;flex-direction:column;gap:.45rem}
.form-label{display:flex;align-items:center;gap:.4rem;font-size:.6rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--mocha)}
.form-label svg{color:var(--gold)}
.form-input{width:100%;padding:.9rem 1rem;background:var(--w);border:1px solid var(--beige);border-radius:0;font-size:.92rem;font-weight:500;color:var(--esp);transition:border-color .25s,box-shadow .25s,background .25s}
.form-input::placeholder{color:var(--taupe)}
.form-input:hover{border-color:var(--taupe)}
.form-input:focus{outline:none;border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,148,82,.2);background:#fff}
.form-input.is-invalid{border-color:var(--burg)}
.invalid-msg{font-size:.74rem;font-weight:700;color:var(--burg)}
.pw-hint{font-size:.72rem;color:var(--taupe)}

/* password */
.pw-wrap{position:relative}
.pw-wrap .form-input{padding-right:46px}
.pw-toggle{position:absolute;right:6px;top:50%;transform:translateY(-50%);display:grid;place-items:center;width:34px;height:34px;background:none;border:0;color:var(--taupe);cursor:pointer;transition:color .25s}
.pw-toggle:hover{color:var(--gold)}
.security-note{display:flex;align-items:flex-start;gap:.75rem;padding:1rem 1.2rem;margin-bottom:1.5rem;background:var(--cream);border:1px solid var(--gold-line);border-left:2px solid var(--gold);font-size:.8rem;line-height:1.6;color:var(--mocha)}
.security-note svg{flex-shrink:0;margin-top:.15rem;color:var(--gold)}
.pw-strength{display:flex;gap:4px;margin-top:.35rem}
.pw-strength span{height:3px;flex:1;background:var(--beige);transition:background .25s}

/* footer */
.edit-footer{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap}
.btn-submit{display:inline-flex;align-items:center;gap:.6rem;padding:1.05rem 1.9rem;background:var(--esp);color:var(--ivory);border:1px solid var(--esp);font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;cursor:pointer;box-shadow:0 12px 28px rgba(36,21,15,.25);transition:background .3s,color .3s,transform .3s var(--e),box-shadow .3s}
.btn-submit:hover{background:var(--gold);border-color:var(--gold);color:var(--esp);transform:translateY(-2px);box-shadow:0 16px 34px rgba(184,148,82,.4)}
.btn-submit:active{transform:none}
.btn-back{display:inline-flex;align-items:center;gap:.6rem;padding:1.05rem 1.6rem;background:transparent;color:var(--mocha);border:1px solid var(--beige);font-size:.72rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;transition:.3s}
.btn-back:hover{border-color:var(--esp);color:var(--esp);text-decoration:none}
</style>
@endpush

@section('content')
<div class="edit-page">

    <div class="page-header">
        <h1 class="page-title">Edit Profile</h1>
        <p class="page-subtitle">Update your personal information and password</p>
    </div>

    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="edit-form">
        @csrf
        @method('PUT')

        {{-- PROFILE PHOTO --}}
        <div class="edit-section">
            <div class="section-label">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"></path><circle cx="12" cy="13" r="3.5"></circle></svg>
                Profile Photo
            </div>
            <div class="photo-row">
                <div class="photo-thumb">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Photo">
                    @else
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                    @endif
                </div>
                <div class="photo-info">
                    <div class="photo-info-title">{{ auth()->user()->first_name }}'s Photo</div>
                    <div class="photo-info-hint">JPG or PNG, max 2MB. Recommended 200&times;200px.</div>
                    <label class="photo-upload-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        Choose New Photo
                        <input type="file" name="profile_photo" accept="image/*" onchange="previewPhoto(this)">
                    </label>
                    @error('profile_photo')
                        <div class="invalid-msg" style="margin-top:.5rem">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- PERSONAL INFO --}}
        <div class="edit-section">
            <div class="section-label">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Personal Information
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name"
                           class="form-input @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name', auth()->user()->first_name) }}" required>
                    @error('first_name')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name"
                           class="form-input @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name', auth()->user()->last_name) }}" required>
                    @error('last_name')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m2 6 10 7 10-7"></path></svg>
                        Email Address *
                    </label>
                    <input type="email" name="email"
                           class="form-input @error('email') is-invalid @enderror"
                           value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"></path></svg>
                        Phone Number
                    </label>
                    <input type="text" name="phone"
                           class="form-input @error('phone') is-invalid @enderror"
                           value="{{ old('phone', auth()->user()->phone) }}"
                           placeholder="e.g. 09123456789">
                    @error('phone')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- CHANGE PASSWORD --}}
        <div class="edit-section">
            <div class="section-label">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Change Password
            </div>
            <div class="security-note">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>Leave both fields blank to keep your current password. Choose at least 8 characters for a stronger account.</span>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="newPassword"
                               class="form-input @error('password') is-invalid @enderror"
                               placeholder="Min. 8 characters" oninput="updateStrength(this.value)">
                        <button type="button" class="pw-toggle" onclick="togglePw('newPassword', this)" aria-label="Show or hide password">
                            <svg class="eye-on" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg class="eye-off" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                    <div class="pw-strength" id="pwStrength"><span></span><span></span><span></span><span></span></div>
                    @error('password')
                        <div class="invalid-msg">{{ $message }}</div>
                    @enderror
                    <div class="pw-hint">Leave blank to keep your current password.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password_confirmation" id="confirmPassword"
                               class="form-input" placeholder="Repeat new password">
                        <button type="button" class="pw-toggle" onclick="togglePw('confirmPassword', this)" aria-label="Show or hide password">
                            <svg class="eye-on" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg class="eye-off" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="edit-footer">
            <button type="submit" class="btn-submit">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Save Changes
            </button>
            <a href="{{ route('customer.profile.index') }}" class="btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function previewPhoto(input) {
    if (!input.files || !input.files[0]) return;
    const thumb = input.closest('.photo-row').querySelector('.photo-thumb');
    const reader = new FileReader();
    reader.onload = e => {
        thumb.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
    };
    reader.readAsDataURL(input.files[0]);
}
function togglePw(fieldId, btn) {
    const f = document.getElementById(fieldId);
    f.type = f.type === 'password' ? 'text' : 'password';
    btn.querySelector('.eye-on').style.display  = f.type === 'password' ? 'block' : 'none';
    btn.querySelector('.eye-off').style.display = f.type === 'password' ? 'none' : 'block';
}
function updateStrength(val) {
    const bars = document.querySelectorAll('#pwStrength span');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/\d/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const colors = ['#D8C8B7', '#A96F42', '#B89452', '#24150F'];
    bars.forEach((b, i) => { b.style.background = (val.length && i < score) ? colors[score - 1] : '#D8C8B7'; });
}
</script>
@endpush