<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — BakeSphere</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cream: #FDF6EE; --rose: #C9725F; --rose-dk: #A85A48;
            --rose-pale: #FFF8F5; --mocha: #6B4C3B; --sand: #E8D5C0;
            --white: #FFFFFF; --err: #D94F38; --success: #5B8F6A;
            --muted: #B09080;
        }
       *, *::before, *::after { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(107,76,59,0.12);
            display: grid;
            grid-template-columns: 360px 1fr;
            overflow: hidden;
            width: 900px;
            max-width: 100%;
        }

        /* ── Left Panel ── */
        .card-left {
            background: linear-gradient(145deg, #6B4C3B 0%, #8A5C48 100%);
            padding: 56px 42px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .card-left::before {
            content: ''; position: absolute;
            width: 280px; height: 280px; border-radius: 50%;
            background: rgba(201,114,95,0.13); top: -70px; left: -70px;
        }
        .card-left::after {
            content: ''; position: absolute;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(201,114,95,0.10); bottom: -50px; right: -50px;
        }
     .brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2rem; color: #E8D5C0; font-weight: 800;
            position: relative; z-index: 1;
        }
        .brand span { color: #C9725F; }

        /* ── Hero SVG ── */
        .hero-illustration {
            width: 220px;
            margin: 18px auto 14px;
            position: relative;
            z-index: 1;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-9px)} }

        .slogan-wrap { position: relative; z-index: 1; }
       .slogan-main {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.05rem; font-weight: 700;
            color: #E8D5C0; line-height: 1.4; margin-bottom: 7px;
        }
        .slogan-sub { font-size: 0.78rem; color: rgba(232,213,192,0.55); line-height: 1.65; }

        /* ── Right Panel ── */
        .card-right {
            padding: 40px 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .greeting-label {
            font-size: 0.64rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.14em;
            color: var(--rose); margin-bottom: 4px;
        }
    h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.75rem; color: var(--mocha);
            font-weight: 800; margin-bottom: 20px; line-height: 1.2;
        }

        /* ── Alerts ── */
        .alert { padding: 10px 13px; border-radius: 9px; margin-bottom: 14px; font-size: 0.83rem; }
        .alert-err  { background: #FEE8E5; border: 1px solid var(--err); color: var(--err); }
        .alert-ok   { background: #E8F5EC; border: 1px solid var(--success); color: var(--success); }
        .alert-google {
            background: #FFF8F5; border: 1px solid #F0C8B8;
            border-radius: 9px; padding: 0.7rem 0.9rem;
            margin-bottom: 14px; display: flex; gap: 0.55rem; align-items: flex-start;
            font-size: 0.8rem; color: #7A4030; line-height: 1.5;
        }
        .alert-google img { width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; }
        .alert-pending {
            background: #FEF9E8; border: 1px solid #F0D4B0;
            border-radius: 9px; padding: 0.7rem 0.9rem;
            margin-bottom: 14px; display: flex; gap: 0.55rem; align-items: flex-start;
        }
        .pending-icon { font-size: 1rem; flex-shrink: 0; }
        .pending-title { font-weight: 700; color: #7A5800; font-size: 0.78rem; margin-bottom: 0.1rem; }
        .pending-msg { font-size: 0.72rem; color: #9B7A10; line-height: 1.55; }

        /* ── Form Fields ── */
        .field { margin-bottom: 12px; }
        .field label {
            display: block; font-size: 0.69rem; font-weight: 600;
            color: var(--mocha); text-transform: uppercase;
            letter-spacing: 0.08em; margin-bottom: 5px;
        }
.field input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--sand); border-radius: 9px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9rem;
            color: var(--mocha); background: var(--white);
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .field input:focus { border-color: var(--rose); box-shadow: 0 0 0 3px rgba(201,114,95,0.13); }
        .field input.is-invalid { border-color: var(--err); }
        .err-msg { font-size: 0.72rem; color: var(--err); margin-top: 3px; }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }
        .pw-toggle {
            position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #9A7B6A;
            font-size: 0.9rem; display: flex; align-items: center; padding: 3px;
        }
        .pw-toggle:hover { color: var(--rose); }

        .row-extra {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 16px;
        }
        .row-extra label { display: flex; align-items: center; gap: 6px; font-size: 0.79rem; color: #7A5C4E; cursor: pointer; }
        .row-extra input[type=checkbox] { accent-color: var(--rose); width: 13px; height: 13px; }
        .row-extra a { font-size: 0.79rem; color: var(--rose); text-decoration: none; }
        .row-extra a:hover { text-decoration: underline; }

.btn-signin {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, var(--mocha), var(--rose));
            color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.92rem; font-weight: 600;
            border: none; border-radius: 9px; cursor: pointer;
            transition: all 0.2s; letter-spacing: 0.02em;
            box-shadow: 0 4px 12px rgba(107,76,59,0.22);
        }
        .btn-signin:hover {
            background: linear-gradient(135deg, var(--rose), var(--rose-dk));
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(107,76,59,0.32);
        }

        /* ── Divider ── */
        .divider {
            display: flex; align-items: center; gap: 10px;
            margin: 16px 0;
        }
        .divider-line { flex: 1; height: 1px; background: var(--sand); }
        .divider-text {
            font-size: 0.64rem; color: var(--muted);
            white-space: nowrap; letter-spacing: 0.04em;
            text-transform: uppercase; font-weight: 500;
        }

        /* ── Google Buttons ── */
        .google-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .google-card {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 13px;
            border: 1.5px solid var(--sand); border-radius: 9px;
            text-decoration: none; background: #faf7f4;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .google-card:hover { border-color: var(--rose); background: var(--rose-pale); box-shadow: 0 3px 10px rgba(201,114,95,0.1); }
        .google-card img { width: 16px; height: 16px; flex-shrink: 0; }
        .google-card-text { display: flex; flex-direction: column; gap: 1px; }
        .google-card-sub { font-size: 0.57rem; text-transform: uppercase; letter-spacing: 0.07em; color: var(--muted); font-weight: 500; }
        .google-card-title { font-size: 0.81rem; font-weight: 600; color: var(--mocha); }

        /* ── Register Links ── */
        .register-links { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
     .reg-link {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 12px;
    border: 1.5px solid var(--sand); border-radius: 9px;
    text-decoration: none; background: var(--cream);
    transition: border-color 0.2s, background 0.2s;
}
        .reg-link:hover { border-color: var(--rose); background: var(--rose-pale); }
        .reg-link-icon { font-size: 1rem; flex-shrink: 0; }
        .reg-link-text { display: flex; flex-direction: column; gap: 1px; }
        .reg-link-action { font-size: 0.57rem; text-transform: uppercase; letter-spacing: 0.07em; color: var(--muted); font-weight: 500; }
        .reg-link-title { font-size: 0.8rem; font-weight: 600; color: var(--mocha); }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .card { grid-template-columns: 1fr; }
            .card-left { display: none; }
            .card-right { padding: 32px 22px 28px; }
            .google-cards, .register-links { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="card">

    <!-- Left Panel -->
    <div class="card-left">
        <div class="brand">Bake<span>Sphere</span></div>

      <div class="hero-illustration">
    <svg width="100%" viewBox="0 0 280 260" xmlns="http://www.w3.org/2000/svg">
        <!-- plate shadow -->
        <ellipse cx="128" cy="242" rx="88" ry="9" fill="#C9725F" opacity="0.15"/>
        <!-- plate -->
        <ellipse cx="128" cy="237" rx="82" ry="8" fill="#E8D5C0"/>

        <!-- BOTTOM TIER -->
        <rect x="56" y="186" width="144" height="50" rx="5" fill="#6B4C3B"/>
        <ellipse cx="128" cy="186" rx="72" ry="10" fill="#8A5C48"/>
        <ellipse cx="128" cy="186" rx="72" ry="10" fill="none" stroke="#FDF6EE" stroke-width="7" opacity="0.85"/>

        <!-- CREAM LAYER 1 -->
        <ellipse cx="128" cy="178" rx="60" ry="7" fill="#FDF6EE"/>

        <!-- MIDDLE TIER -->
        <rect x="68" y="130" width="120" height="50" rx="5" fill="#C9725F"/>
        <ellipse cx="128" cy="130" rx="60" ry="8" fill="#D4836F"/>
        <ellipse cx="128" cy="130" rx="60" ry="8" fill="none" stroke="#FFF8F5" stroke-width="7" opacity="0.9"/>
        <!-- drips -->
        <ellipse cx="82"  cy="179" rx="5" ry="7" fill="#FDF6EE"/>
        <ellipse cx="98"  cy="181" rx="5" ry="7" fill="#FDF6EE"/>
        <ellipse cx="114" cy="182" rx="5" ry="7" fill="#FDF6EE"/>
        <ellipse cx="130" cy="182" rx="5" ry="7" fill="#FDF6EE"/>
        <ellipse cx="146" cy="181" rx="5" ry="7" fill="#FDF6EE"/>
        <ellipse cx="162" cy="179" rx="5" ry="7" fill="#FDF6EE"/>
        <ellipse cx="174" cy="177" rx="4" ry="6" fill="#FDF6EE"/>

        <!-- CREAM LAYER 2 -->
        <ellipse cx="128" cy="122" rx="48" ry="6" fill="#FDF6EE"/>

        <!-- TOP TIER -->
        <rect x="80" y="74" width="96" height="50" rx="5" fill="#A85A48"/>
        <ellipse cx="128" cy="74" rx="48" ry="7" fill="#C4705A"/>
        <ellipse cx="128" cy="74" rx="48" ry="7" fill="none" stroke="#FFF8F5" stroke-width="7" opacity="0.9"/>
        <!-- drips -->
        <ellipse cx="94"  cy="122" rx="4.5" ry="6.5" fill="#FFF8F5"/>
        <ellipse cx="107" cy="123" rx="4.5" ry="6.5" fill="#FFF8F5"/>
        <ellipse cx="120" cy="124" rx="4.5" ry="6.5" fill="#FFF8F5"/>
        <ellipse cx="133" cy="124" rx="4.5" ry="6.5" fill="#FFF8F5"/>
        <ellipse cx="146" cy="123" rx="4.5" ry="6.5" fill="#FFF8F5"/>
        <ellipse cx="158" cy="121" rx="4"   ry="6"   fill="#FFF8F5"/>

        <!-- frosting mound on top -->
        <ellipse cx="128" cy="70" rx="40" ry="6" fill="#FFF8F5" opacity="0.9"/>

        <!-- CANDLES -->
        <rect x="110" y="36" width="8" height="36" rx="3" fill="#E8D5C0"/>
        <rect x="110" y="41" width="8" height="3" rx="1" fill="#C9725F" opacity="0.6"/>
        <rect x="110" y="49" width="8" height="3" rx="1" fill="#C9725F" opacity="0.6"/>
        <rect x="110" y="57" width="8" height="3" rx="1" fill="#C9725F" opacity="0.6"/>
        <rect x="132" y="42" width="8" height="30" rx="3" fill="#C9725F" opacity="0.8"/>
        <rect x="132" y="47" width="8" height="3" rx="1" fill="#E8D5C0" opacity="0.7"/>
        <rect x="132" y="55" width="8" height="3" rx="1" fill="#E8D5C0" opacity="0.7"/>

        <!-- FLAMES -->
        <ellipse cx="114" cy="30" rx="5" ry="9" fill="#F0A060"/>
        <ellipse cx="114" cy="25" rx="3" ry="6" fill="#FFF0A0"/>
        <ellipse cx="114" cy="22" rx="1.5" ry="3" fill="#FFF"/>
        <ellipse cx="136" cy="37" rx="4" ry="7" fill="#F0A060"/>
        <ellipse cx="136" cy="33" rx="2.5" ry="5" fill="#FFF0A0"/>
        <ellipse cx="136" cy="30" rx="1.2" ry="2.5" fill="#FFF"/>

        <!-- WHISK -->
        <rect x="212" y="185" width="11" height="55" rx="4" fill="#6B4C3B"/>
        <rect x="210" y="195" width="15" height="4" rx="2" fill="#8A5C48"/>
        <rect x="210" y="206" width="15" height="4" rx="2" fill="#8A5C48"/>
        <rect x="210" y="217" width="15" height="4" rx="2" fill="#8A5C48"/>
        <path d="M217 185 Q204 155 209 124 Q214 100 222 124 Q227 152 217 185" fill="none" stroke="#C9725F" stroke-width="2.2" stroke-linecap="round"/>
        <path d="M217 185 Q230 155 225 124 Q220 100 212 124 Q207 152 217 185" fill="none" stroke="#C9725F" stroke-width="2.2" stroke-linecap="round"/>
        <path d="M217 185 Q200 160 203 130 Q206 108 214 120" fill="none" stroke="#A85A48" stroke-width="1.3" stroke-linecap="round" opacity="0.5"/>
        <path d="M217 185 Q234 160 231 130 Q228 108 220 120" fill="none" stroke="#A85A48" stroke-width="1.3" stroke-linecap="round" opacity="0.5"/>
        <ellipse cx="206" cy="183" rx="7" ry="3" fill="#FDF6EE" opacity="0.45"/>
        <ellipse cx="229" cy="181" rx="6" ry="3" fill="#FDF6EE" opacity="0.35"/>

        <!-- SPARKLES -->
        <line x1="40" y1="110" x2="40" y2="126" stroke="#C9725F" stroke-width="2.2" stroke-linecap="round"/>
        <line x1="32" y1="118" x2="48" y2="118" stroke="#C9725F" stroke-width="2.2" stroke-linecap="round"/>
        <line x1="34" y1="112" x2="46" y2="124" stroke="#C9725F" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
        <line x1="46" y1="112" x2="34" y2="124" stroke="#C9725F" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/>
        <line x1="252" y1="90" x2="252" y2="102" stroke="#E8D5C0" stroke-width="1.8" stroke-linecap="round"/>
        <line x1="246" y1="96" x2="258" y2="96" stroke="#E8D5C0" stroke-width="1.8" stroke-linecap="round"/>
        <line x1="248" y1="92" x2="256" y2="100" stroke="#E8D5C0" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
        <line x1="256" y1="92" x2="248" y2="100" stroke="#E8D5C0" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
        <line x1="52" y1="62" x2="52" y2="70" stroke="#E8D5C0" stroke-width="1.4" stroke-linecap="round"/>
        <line x1="48" y1="66" x2="56" y2="66" stroke="#E8D5C0" stroke-width="1.4" stroke-linecap="round"/>

        <!-- DOTS -->
        <circle cx="32"  cy="150" r="2.5" fill="#C9725F" opacity="0.55"/>
        <circle cx="26"  cy="188" r="1.8" fill="#E8D5C0" opacity="0.7"/>
        <circle cx="50"  cy="208" r="2"   fill="#C9725F" opacity="0.4"/>
        <circle cx="250" cy="132" r="2"   fill="#E8D5C0" opacity="0.65"/>
        <circle cx="260" cy="198" r="1.8" fill="#C9725F" opacity="0.5"/>
        <circle cx="246" cy="214" r="2.5" fill="#E8D5C0" opacity="0.45"/>
        <circle cx="38"  cy="84"  r="1.8" fill="#C9725F" opacity="0.5"/>
        <circle cx="102" cy="16"  r="1.5" fill="#F0A060" opacity="0.5"/>
        <circle cx="148" cy="22"  r="1.2" fill="#F0A060" opacity="0.45"/>
    </svg>
</div>

        <div class="slogan-wrap">
            <div class="slogan-main">Where Every Slice Tells a Story</div>
            <div class="slogan-sub">Order handcrafted cakes made with love,<br>delivered fresh to your celebration.</div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="card-right">

        <div class="greeting-label">BakeSphere Marketplace</div>
        <h1>Sign In to your Account</h1>

        {{-- Google account error --}}
        @if ($errors->has('email') && str_contains($errors->first('email'), 'Google'))
            <div class="alert-google">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="">
                <div>{{ $errors->first('email') }}</div>
            </div>
        @elseif ($errors->any())
            <div class="alert alert-err">
                @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-ok">{{ session('success') }}</div>
        @endif

        @if (session('pending_approval'))
            <div class="alert-pending">
                <div class="pending-icon">⏳</div>
                <div>
                    <div class="pending-title">Application Submitted!</div>
                    <div class="pending-msg">{{ session('pending_approval') }}</div>
                </div>
            </div>
        @endif

        <!-- ① EMAIL & PASSWORD -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="juan@email.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required autofocus>
            </div>
            <div class="field">
                <label>Password</label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="loginPassword"
                        placeholder="Your password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                    <button type="button" class="pw-toggle" onclick="togglePw()">👁</button>
                </div>
            </div>
            <div class="row-extra">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn-signin">Sign In →</button>
        </form>

        <!-- ② GOOGLE -->
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">or continue with Google</span>
            <div class="divider-line"></div>
        </div>

        <div class="google-cards">
            <a href="{{ route('auth.google', ['as' => 'customer']) }}" class="google-card">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                <div class="google-card-text">
                    <span class="google-card-sub">Sign in as</span>
                    <span class="google-card-title">Customer</span>
                </div>
            </a>
            <a href="{{ route('auth.google', ['as' => 'baker']) }}" class="google-card">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                <div class="google-card-text">
                    <span class="google-card-sub">Sign in as</span>
                    <span class="google-card-title">Baker</span>
                </div>
            </a>
        </div>

        <!-- ③ REGISTER -->
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">Don't have an account yet?</span>
            <div class="divider-line"></div>
        </div>

        <div class="register-links">
            <a href="{{ route('register') }}" class="reg-link">
                <span class="reg-link-icon">👤</span>
                <div class="reg-link-text">
                    <span class="reg-link-action">Register as</span>
                    <span class="reg-link-title">Customer</span>
                </div>
            </a>
            <a href="{{ route('baker.register') }}" class="reg-link">
                <span class="reg-link-icon">🎂</span>
                <div class="reg-link-text">
                    <span class="reg-link-action">Register as</span>
                    <span class="reg-link-title">Baker</span>
                </div>
            </a>
        </div>

    </div>
</div>

<script>
   function togglePw() {
    const f = document.getElementById('loginPassword');
    const b = document.querySelector('.pw-toggle');
    f.type = f.type === 'password' ? 'text' : 'password';
    b.textContent = f.type === 'password' ? '👁' : '🙈';
}

const emailInput   = document.querySelector('input[name="email"]');
const pwField      = document.querySelector('.field:has(#loginPassword)');
const submitBtn    = document.querySelector('.btn-signin');
const googleAlert  = document.querySelector('.alert-google');

pwField.style.display = 'none';
submitBtn.textContent  = 'Continue →';

let debounceTimer;
emailInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    pwField.style.display = 'none';
    submitBtn.style.display = 'block';
    submitBtn.textContent = 'Continue →';
    if (googleAlert) googleAlert.style.display = 'none';
hideGoogleHint();
    hideNotRegisteredHint();

    const email = this.value.trim();
    if (!email.includes('@') || !email.includes('.')) return;

    debounceTimer = setTimeout(() => checkProvider(email), 600);
});

async function checkProvider(email) {
    try {
        const res  = await fetch('{{ route("check.email.provider") }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email })
        });
        const data = await res.json();

        if (data.status === 'google') {
            pwField.style.display = 'none';
            submitBtn.style.display = 'none';
            showGoogleHint();
        } else if (data.status === 'password') {
            pwField.style.display = 'block';
            submitBtn.style.display = 'block';
            submitBtn.textContent = 'Sign In →';
            hideGoogleHint();
} else {
            // Not registered
            pwField.style.display = 'none';
            submitBtn.style.display = 'block';
            submitBtn.textContent = 'Continue →';
            showNotRegisteredHint();
        }
    } catch (e) {
        pwField.style.display = 'block';
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Sign In →';
    }
}

function showGoogleHint() {
    let hint = document.getElementById('dynamic-google-hint');
    if (!hint) {
        hint = document.createElement('div');
        hint.id = 'dynamic-google-hint';
        hint.className = 'alert-google';
        hint.innerHTML = `
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="">
            <div>This account uses Google Sign-In. Use the
            <strong>Continue with Google</strong> button below.</div>
        `;
        emailInput.closest('.field').after(hint);
    }
    hint.style.display = 'flex';
}

function hideGoogleHint() {
    const hint = document.getElementById('dynamic-google-hint');
    if (hint) hint.style.display = 'none';
}

function showNotRegisteredHint() {
    hideGoogleHint();
    let hint = document.getElementById('dynamic-noreg-hint');
    if (!hint) {
        hint = document.createElement('div');
        hint.id = 'dynamic-noreg-hint';
        hint.className = 'alert-google';
        hint.style.borderColor = '#F0D4B0';
        hint.style.background = '#FEF9E8';
        hint.innerHTML = `
            <div style="font-size:1rem;flex-shrink:0">🔍</div>
            <div style="color:#7A5800">No account found with this email.
            <a href="{{ route('register') }}" style="color:var(--rose);font-weight:600">Register as Customer</a>
            or <a href="{{ route('baker.register') }}" style="color:var(--rose);font-weight:600">Register as Baker</a>.</div>
        `;
        emailInput.closest('.field').after(hint);
    }
    hint.style.display = 'flex';
}

function hideNotRegisteredHint() {
    const hint = document.getElementById('dynamic-noreg-hint');
    if (hint) hint.style.display = 'none';
}
</script>
</body>
</html>