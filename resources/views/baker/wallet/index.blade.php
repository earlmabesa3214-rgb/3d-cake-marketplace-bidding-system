@extends('layouts.baker')
@section('title', 'My Wallet')

@push('styles')
<style>
*, *::before, *::after { box-sizing: border-box; }
* { font-family: 'Plus Jakarta Sans', sans-serif; }

:root {
    --brown-deep: #3B1F0F; --brown-mid: #7A4A28;
    --caramel: #C8893A; --caramel-light: #E8A94A;
    --warm-white: #FFFDF9; --cream: #F5EFE6;
    --border: #EAE0D0; --text-dark: #2C1A0E; --text-muted: #9A7A5A;
}

.wallet-wrap { max-width: 900px; margin: 0 auto; padding: 1rem; }
.page-title  { font-size: 1.4rem; font-weight: 800; color: var(--brown-deep); margin-bottom: 0.25rem; }
.page-sub    { font-size: 0.82rem; color: var(--text-muted); margin-bottom: 1.75rem; }

.wallet-hero {
    background: linear-gradient(135deg, #3B1F0F, #7A4A28);
    border-radius: 24px; padding: 2rem 2.5rem; color: white;
    margin-bottom: 1.75rem; position: relative; overflow: hidden;
}
.wallet-hero::before {
    content: ''; position: absolute; right: -40px; top: -40px;
    width: 180px; height: 180px; border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.wallet-balance-label { font-size: 0.68rem; letter-spacing: 0.2em; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.4rem; }
.wallet-balance-amount { font-size: 3rem; font-weight: 800; color: var(--caramel-light); line-height: 1; position: relative; z-index: 1; }
.wallet-balance-sub { font-size: 0.82rem; opacity: 0.65; margin-top: 0.4rem; }

.wallet-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem; position: relative; z-index: 1; }
.wallet-stat { background: rgba(255,255,255,0.1); border-radius: 12px; padding: 0.85rem 1rem; }
.ws-label { font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.6; font-weight: 600; }
.ws-value { font-size: 1.1rem; font-weight: 800; color: white; margin-top: 0.15rem; }

.card { background: var(--warm-white); border: 1px solid var(--border); border-radius: 20px; overflow: hidden; margin-bottom: 1.5rem; }
.card-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
.card-header h3 { font-size: 0.95rem; font-weight: 700; color: var(--brown-deep); margin: 0; }

.form-row { padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: 0.85rem; }
.form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.form-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); }
.form-input {
    padding: 0.7rem 1rem; border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 0.88rem; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);
    transition: border-color 0.2s;
}
.form-input:focus { outline: none; border-color: var(--caramel); }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; }

.btn-withdraw {
    width: 100%; padding: 0.85rem;
    background: linear-gradient(135deg, var(--caramel), var(--caramel-light));
    color: white; border: none; border-radius: 12px;
    font-size: 0.95rem; font-weight: 700; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(200,137,58,0.35);
    transition: all 0.2s; margin-top: 0.5rem;
}
.btn-withdraw:hover { transform: translateY(-1px); }
.btn-withdraw:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }

.badge { display: inline-flex; align-items: center; padding: 0.2rem 0.65rem; border-radius: 20px; font-size: 0.65rem; font-weight: 700; }
.badge-pending  { background: #FEF9E8; color: #8A5010;  border: 1px solid #F0D090; }
.badge-approved { background: #EFF5EF; color: #1B4D2E;  border: 1px solid #BFDFBE; }
.badge-rejected { background: #FDF0EE; color: #8B2A1E;  border: 1px solid #F5C5BE; }

.wd-row {
    padding: 0.9rem 1.5rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
}
.wd-row:last-child { border-bottom: none; }

.alert { display: flex; align-items: flex-start; gap: 0.75rem; border-radius: 12px; padding: 0.9rem 1.25rem; margin-bottom: 1.25rem; font-size: 0.84rem; }
.alert-warning { background: #FEF9E8; border: 1px solid #F0D090; color: #8A5010; }
.alert-info    { background: #EBF3FE; border: 1px solid #BEDAF5; color: #1A3A6B; }
</style>
@endpush

@section('content')

<div class="wallet-wrap">
    <div class="page-title">💰 My Wallet</div>
    <div class="page-sub">Your earnings are held securely. Request a withdrawal anytime.</div>

    @if(session('success'))
    <div class="alert alert-info"><span>✅</span><div>{{ session('success') }}</div></div>
    @endif
    @if(session('error'))
    <div class="alert alert-warning"><span>⚠️</span><div>{{ session('error') }}</div></div>
    @endif

    {{-- Wallet Hero --}}
    <div class="wallet-hero">
        <div class="wallet-balance-label">Available Balance</div>
        <div class="wallet-balance-amount">₱{{ number_format($wallet->balance, 2) }}</div>
        <div class="wallet-balance-sub">Ready to withdraw to your GCash or Maya</div>
        <div class="wallet-stats">
            <div class="wallet-stat">
                <div class="ws-label">Total Earned</div>
                <div class="ws-value">₱{{ number_format($wallet->total_earned, 2) }}</div>
            </div>
            <div class="wallet-stat">
                <div class="ws-label">Total Withdrawn</div>
                <div class="ws-value">₱{{ number_format($wallet->total_withdrawn, 2) }}</div>
            </div>
        </div>
    </div>

    @if($pendingWithdrawal)
    <div class="alert alert-warning">
        <span>⏳</span>
        <div>
            <strong>Withdrawal Pending</strong> — You have a pending withdrawal of
            <strong>₱{{ number_format($pendingWithdrawal->amount, 2) }}</strong>
            to {{ strtoupper($pendingWithdrawal->payment_method) }} {{ $pendingWithdrawal->account_number }}.
            Admin will process it within 1–2 business days.
        </div>
    </div>
    @endif

    {{-- Withdrawal Request Form --}}
    @if(!$pendingWithdrawal && $wallet->balance >= 100)
    <div class="card">
        <div class="card-header">
            <h3>💸 Request Withdrawal</h3>
        </div>
        <form method="POST" action="{{ route('baker.wallet.withdraw') }}">
            @csrf
            <div class="form-row">
                @if($errors->any())
                <div class="alert alert-warning">
                    <span>⚠️</span>
                    <div>{{ $errors->first() }}</div>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Amount to Withdraw *</label>
                    <input type="number" name="amount" class="form-input"
                           min="100" max="{{ $wallet->balance }}"
                           step="0.01" placeholder="e.g. 500.00"
                           value="{{ old('amount') }}">
                    <span style="font-size:0.7rem; color:var(--text-muted);">
                        Min ₱100 · Available: ₱{{ number_format($wallet->balance, 2) }}
                    </span>
                </div>

                <div class="form-group">
                    <label class="form-label">Send To *</label>
                    <select name="payment_method" class="form-input">
                        <option value="gcash"  {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>💙 GCash</option>
                        <option value="maya"   {{ old('payment_method') === 'maya'  ? 'selected' : '' }}>💚 Maya</option>
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Account Name *</label>
                        <input type="text" name="account_name" class="form-input"
                               placeholder="Full name on account"
                               value="{{ old('account_name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Account Number *</label>
                        <input type="text" name="account_number" class="form-input"
                               placeholder="09XX-XXX-XXXX"
                               value="{{ old('account_number') }}">
                    </div>
                </div>

                <div style="background:var(--cream); border-radius:10px; padding:0.85rem 1rem; font-size:0.78rem; color:var(--text-muted); line-height:1.6;">
                    ℹ️ Withdrawals are processed manually by our team within <strong>1–2 business days</strong>.
                    You'll receive a notification once sent.
                </div>

                <button type="submit" class="btn-withdraw">
                    💸 Request Withdrawal
                </button>
            </div>
        </form>
    </div>
    @elseif($wallet->balance < 100)
    <div class="alert alert-info">
        <span>ℹ️</span>
        <div>Minimum withdrawal is <strong>₱100</strong>. Complete more orders to increase your balance.</div>
    </div>
    @endif

    {{-- Withdrawal History --}}
    @if($withdrawals->isNotEmpty())
    <div class="card">
        <div class="card-header"><h3>📋 Withdrawal History</h3></div>
        @foreach($withdrawals as $wd)
        <div class="wd-row">
            <div>
                <div style="font-weight:700; font-size:0.88rem; color:var(--brown-deep);">
                    ₱{{ number_format($wd->amount, 2) }} → {{ strtoupper($wd->payment_method) }}
                </div>
                <div style="font-size:0.72rem; color:var(--text-muted); margin-top:0.15rem;">
                    {{ $wd->account_name }} · {{ $wd->account_number }}
                </div>
                @if($wd->admin_note)
                <div style="font-size:0.72rem; color:var(--brown-mid); margin-top:0.2rem; font-style:italic;">
                    "{{ $wd->admin_note }}"
                </div>
                @endif
            </div>
            <div style="text-align:right; flex-shrink:0;">
                <span class="badge badge-{{ $wd->status }}">
                    {{ ucfirst($wd->status) }}
                </span>
                <div style="font-size:0.68rem; color:var(--text-muted); margin-top:0.25rem;">
                    {{ $wd->requested_at?->format('M d, Y') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection