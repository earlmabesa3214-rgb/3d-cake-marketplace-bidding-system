@extends('layouts.customer')
@section('title', 'Edit Profile')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<style>
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.edit-wrap { max-width: 720px; }

/* ── TOP BAR ── */
.edit-topbar { margin-bottom: 2rem; }
.edit-topbar h1 {
    font-size: 1.55rem;
    font-weight: 800;
    color: var(--brown-deep, #3B1F0F);
    letter-spacing: -0.02em;
    margin-bottom: 0.2rem;
}
.edit-topbar p {
    font-size: 0.82rem;
    color: var(--text-muted, #9A7A5A);
}

/* ── FORM CARD ── */
.edit-card {
    background: var(--warm-white, #FFFDF9);
    border: 1px solid var(--border, #EAE0D0);
    border-radius: 20px;
    overflow: hidden;
}

.edit-section {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border, #EAE0D0);
}
.edit-section:last-of-type { border-bottom: none; }

.section-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--text-muted, #9A7A5A);
    margin-bottom: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-label span { font-size: 1rem; }

/* ── PHOTO SECTION ── */
.photo-row {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}
.photo-thumb {
    width: 68px; height: 68px;
    border-radius: 14px;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid var(--border, #EAE0D0);
    background: var(--brown-deep, #3B1F0F);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    color: #E8C9A8;
}
.photo-thumb img { width: 100%; height: 100%; object-fit: cover; }
.photo-info { flex: 1; }
.photo-info-title { font-size: 0.85rem; font-weight: 700; color: var(--brown-deep, #3B1F0F); margin-bottom: 0.2rem; }
.photo-info-hint  { font-size: 0.72rem; color: var(--text-muted, #9A7A5A); margin-bottom: 0.65rem; }

.photo-upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.45rem 0.9rem;
    border: 1.5px solid var(--border, #EAE0D0);
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-mid, #6B4A2A);
    background: white;
    cursor: pointer;
    transition: all 0.15s;
    position: relative;
    overflow: hidden;
}
.photo-upload-btn:hover { border-color: var(--caramel, #C07840); color: var(--caramel, #C07840); }
.photo-upload-btn input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
}

/* ── FORM FIELDS ── */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}
.form-row:last-child { margin-bottom: 0; }
.form-group { display: flex; flex-direction: column; gap: 0.3rem; }
.form-group.full { grid-column: 1 / -1; }

.form-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-mid, #6B4A2A);
}
.form-input {
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--border, #EAE0D0);
    border-radius: 9px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.85rem;
    color: var(--brown-deep, #3B1F0F);
    background: var(--cream, #F5EFE6);
    outline: none;
    width: 100%;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}
.form-input:focus {
    border-color: var(--caramel, #C07840);
    box-shadow: 0 0 0 3px rgba(192,120,64,0.12);
    background: white;
}
.form-input.is-invalid { border-color: #C0392B; }
.form-input::placeholder { color: #C8B8A8; }

.invalid-msg {
    font-size: 0.72rem;
    color: #C0392B;
    margin-top: 0.15rem;
}

/* Password hint */
.pw-hint {
    font-size: 0.72rem;
    color: var(--text-muted, #9A7A5A);
    margin-top: 0.25rem;
    font-style: italic;
}

/* ── FOOTER ── */
.edit-footer {
    padding: 1.25rem 2rem;
    border-top: 1px solid var(--border, #EAE0D0);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--cream, #F5EFE6);
}
.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.7rem 1.5rem;
    background: var(--brown-deep, #3B1F0F);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}
.btn-submit:hover { background: var(--caramel, #C07840); transform: translateY(-1px); }

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.7rem 1.25rem;
    background: white;
    color: var(--text-mid, #6B4A2A);
    border: 1.5px solid var(--border, #EAE0D0);
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-back:hover { border-color: var(--caramel, #C07840); color: var(--caramel, #C07840); text-decoration: none; }
</style>
@endpush

@section('content')
<div class="edit-wrap">

    <div class="edit-topbar">
        <h1>Edit Profile</h1>
        <p>Update your personal information and password</p>
    </div>

    <div class="edit-card">
        <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- PROFILE PHOTO --}}
            <div class="edit-section">
                <div class="section-label"><span>📷</span> Profile Photo</div>
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
                        <div class="photo-info-hint">JPG or PNG, max 2MB. Recommended 200×200px.</div>
                        <label class="photo-upload-btn">
                            📁 Choose New Photo
                            <input type="file" name="profile_photo" accept="image/*"
                                   onchange="previewPhoto(this)">
                        </label>
                        @error('profile_photo')
                            <div class="invalid-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- PERSONAL INFO --}}
            <div class="edit-section">
                <div class="section-label"><span>👤</span> Personal Information</div>
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
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email"
                               class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="invalid-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
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
                <div class="section-label"><span>🔒</span> Change Password</div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password"
                               class="form-input @error('password') is-invalid @enderror"
                               placeholder="Min. 8 characters">
                        @error('password')
                            <div class="invalid-msg">{{ $message }}</div>
                        @enderror
                        <div class="pw-hint">Leave blank to keep your current password.</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-input"
                               placeholder="Repeat new password">
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="edit-footer">
                <button type="submit" class="btn-submit">✓ Save Changes</button>
                <a href="{{ route('customer.profile.index') }}" class="btn-back">← Cancel</a>
            </div>

        </form>
    </div>
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
</script>
@endpush