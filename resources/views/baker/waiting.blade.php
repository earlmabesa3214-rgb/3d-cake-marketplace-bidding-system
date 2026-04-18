<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Under Review — BakeSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cream: #FDF6F0; --warm-white: #FFFDF9;
            --brown-dark: #5C3D2E; --brown-mid: #7B4F3A;
            --brown-accent: #C07850; --brown-light: #E8C9A8;
            --brown-pale: #F5E6D8; --border: #E2CDB8;
            --text-dark: #2D1A0E; --text-muted: #9A7A65;
            --success: #5B8F6A; --amber: #D4870A;
        }
        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: var(--warm-white);
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(107,76,59,.10);
        }

        /* Animated clock icon */
        .icon-wrap {
            width: 80px; height: 80px;
            background: #FEF9E8;
            border: 2px solid #F0D4A0;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.4rem;
            margin: 0 auto 1.5rem;
            animation: pulse 2.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(212,135,10,.2); }
            50%       { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(212,135,10,.0); }
        }

        .eyebrow {
            font-size: .68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .16em;
            color: var(--amber); margin-bottom: .5rem;
        }
        h1 {
          font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.75rem; color: var(--text-dark);
            margin-bottom: .75rem; line-height: 1.25;
        }
        .subtitle {
            font-size: .9rem; color: var(--text-muted);
            line-height: 1.7; margin-bottom: 2rem;
        }

        /* Status steps */
        .steps {
            display: flex;
            flex-direction: column;
            gap: .6rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        .step-row {
            display: flex; align-items: center; gap: .85rem;
            padding: .65rem .9rem;
            border-radius: 10px;
            font-size: .84rem;
        }
        .step-row.done {
            background: #EAF5EE;
            color: var(--success);
        }
        .step-row.active {
            background: #FEF9E8;
            border: 1.5px solid #F0D4A0;
            color: var(--amber);
            font-weight: 600;
        }
        .step-row.pending {
            background: var(--brown-pale);
            color: var(--text-muted);
        }
        .step-dot {
            width: 22px; height: 22px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; font-weight: 700; flex-shrink: 0;
        }
        .step-row.done   .step-dot { background: var(--success); color: #fff; }
        .step-row.active .step-dot { background: var(--amber); color: #fff; animation: spin-slow 3s linear infinite; }
        .step-row.pending .step-dot { background: var(--border); color: var(--text-muted); }
        @keyframes spin-slow { 0%{transform:rotate(0deg)} 100%{transform:rotate(360deg)} }

        /* Info box */
        .info-box {
            background: var(--brown-pale);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: .82rem;
            color: var(--brown-mid);
            line-height: 1.65;
            margin-bottom: 2rem;
            text-align: left;
        }
        .info-box strong { color: var(--brown-dark); }

        /* Baker info summary */
        .baker-summary {
            display: flex; align-items: center; gap: .75rem;
            padding: .9rem 1rem;
            background: var(--warm-white);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            margin-bottom: 2rem;
            text-align: left;
        }
        .baker-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            object-fit: cover; flex-shrink: 0;
            border: 2px solid var(--border);
        }
        .baker-avatar-placeholder {
            width: 42px; height: 42px; border-radius: 50%;
            background: var(--brown-accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .baker-info-name { font-size: .88rem; font-weight: 700; color: var(--text-dark); }
        .baker-info-shop { font-size: .76rem; color: var(--text-muted); margin-top: .1rem; }

        .btn-logout {
            width: 100%;
            padding: .85rem;
            background: transparent;
            border: 1.5px solid var(--border);
            border-radius: 10px;
           font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem; font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .2s;
        }
        .btn-logout:hover {
            border-color: var(--brown-accent);
            color: var(--brown-mid);
            background: var(--brown-pale);
        }
    </style>
</head>
<body>

<div class="card">

    <div class="icon-wrap">⏳</div>

    <div class="eyebrow">Baker Application</div>
    <h1>Your Application is Under Review</h1>
    <p class="subtitle">
        Our admin team is reviewing your baker profile and documents.
        You'll receive an email once a decision has been made.
    </p>

    <!-- Baker info -->
    <div class="baker-summary">
        @if(auth()->user()->profile_photo)
            <img src="{{ auth()->user()->profile_photo }}" class="baker-avatar" alt="Profile">
        @else
            <div class="baker-avatar-placeholder">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</div>
        @endif
        <div>
            <div class="baker-info-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="baker-info-shop">{{ auth()->user()->baker?->shop_name ?? 'Baker applicant' }} &mdash; {{ auth()->user()->email }}</div>
        </div>
    </div>

    <!-- Progress steps -->
    <div class="steps">
        <div class="step-row done">
            <div class="step-dot">✓</div>
            <span>Registration submitted</span>
        </div>
        <div class="step-row done">
            <div class="step-dot">✓</div>
            <span>Documents uploaded</span>
        </div>
        <div class="step-row active">
            <div class="step-dot">⟳</div>
            <span>Admin review in progress — 1 to 2 business days</span>
        </div>
        <div class="step-row pending">
            <div class="step-dot">4</div>
            <span>Account approved — start bidding</span>
        </div>
    </div>

    <!-- Info -->
    <div class="info-box">
        <strong>What happens next?</strong><br>
        Once approved, you'll get an email at <strong>{{ auth()->user()->email }}</strong> with a link to log in and access your baker dashboard.
        If your application is rejected, you'll also be notified by email with the reason.
    </div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">Sign Out</button>
    </form>

</div>

</body>
</html>