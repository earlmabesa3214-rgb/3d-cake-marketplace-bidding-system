@extends('layouts.customer')

@section('content')
<div class="payment-page">

    {{-- Back button --}}
    <a href="{{ route('customer.cake-requests.show', $cakeRequest->id) }}" class="back-link">
        ← Back to Order Tracker
    </a>

    <div class="payment-layout">

        {{-- LEFT: Payment breakdown --}}
        <div class="payment-main">

            <div class="pay-header">
                <div class="pay-icon">💳</div>
                <div>
                    <h1 class="pay-title">Payment</h1>
                    <p class="pay-sub">Request #{{ str_pad($cakeRequest->id, 4, '0', STR_PAD_LEFT) }} · Agreed price: <strong>₱{{ number_format($bid->amount, 2) }}</strong></p>
                </div>
            </div>

            {{-- Progress cards --}}
            <div class="payment-steps">
                {{-- DOWNPAYMENT --}}
                <div class="pay-step {{ $downpayment && $downpayment->isPaid() ? 'step-done' : 'step-active' }}">
                    <div class="step-header">
                        <div class="step-num">{{ $downpayment && $downpayment->isPaid() ? '✓' : '1' }}</div>
                        <div>
                            <div class="step-label">50% Downpayment</div>
                            <div class="step-amount">₱{{ number_format($downpaymentAmount, 2) }}</div>
                        </div>
                        <div class="step-badge-wrap">
                            @if($downpayment && $downpayment->isPaid())
                                <span class="badge badge-paid">Paid</span>
                            @else
                                <span class="badge badge-due">Due Now</span>
                            @endif
                        </div>
                    </div>

                    @if($downpayment && $downpayment->isPaid())
                        <div class="step-done-info">
                            <span>{{ ucfirst($downpayment->payment_method) }}</span>
                            <span>·</span>
                            <span>{{ $downpayment->paid_at->format('M d, Y h:i A') }}</span>
                            @if($downpayment->proof_of_payment_path)
                                <a href="{{ Storage::url($downpayment->proof_of_payment_path) }}" target="_blank">View proof</a>
                            @endif
                        </div>
                    @else
                        {{-- Payment form --}}
                        @include('customer.payment._payment_form', [
                            'paymentType'   => 'downpayment',
                            'amount'        => $downpaymentAmount,
                            'methods'       => $bakerPaymentMethods,
                            'cakeRequest'   => $cakeRequest,
                        ])
                    @endif
                </div>

                {{-- FINAL PAYMENT --}}
                <div class="pay-step {{ !$downpayment || !$downpayment->isPaid() ? 'step-locked' : ($finalPayment && $finalPayment->isPaid() ? 'step-done' : 'step-active') }}">
                    <div class="step-header">
                        <div class="step-num">{{ $finalPayment && $finalPayment->isPaid() ? '✓' : '2' }}</div>
                        <div>
                            <div class="step-label">50% Final Payment</div>
                            <div class="step-amount">₱{{ number_format($finalAmount, 2) }}</div>
                        </div>
                        <div class="step-badge-wrap">
                            @if($finalPayment && $finalPayment->isPaid())
                                <span class="badge badge-paid">Paid</span>
                            @elseif(!$downpayment || !$downpayment->isPaid())
                                <span class="badge badge-locked">🔒 On Delivery</span>
                            @else
                                <span class="badge badge-due">Due on Delivery</span>
                            @endif
                        </div>
                    </div>

                    @if($finalPayment && $finalPayment->isPaid())
                        <div class="step-done-info">
                            <span>{{ ucfirst($finalPayment->payment_method) }}</span>
                            <span>·</span>
                            <span>{{ $finalPayment->paid_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @elseif($downpayment && $downpayment->isPaid())
                        @include('customer.payment._payment_form', [
                            'paymentType' => 'final',
                            'amount'      => $finalAmount,
                            'methods'     => $bakerPaymentMethods,
                            'cakeRequest' => $cakeRequest,
                        ])
                    @else
                        <p class="locked-note">Complete downpayment first to unlock final payment.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT: Summary card --}}
        <div class="payment-sidebar">
            <div class="summary-card">
                <h3 class="summary-title">Order Summary</h3>
                <div class="summary-row">
                    <span>Cake Type</span>
                    <span>{{ $cakeRequest->cake_type }}</span>
                </div>
                <div class="summary-row">
                    <span>Baker</span>
                    <span>{{ $bid->baker->name }}</span>
                </div>
                <div class="summary-row">
                    <span>Delivery</span>
                    <span>{{ \Carbon\Carbon::parse($cakeRequest->delivery_date)->format('M d, Y') }}</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row summary-total">
                    <span>Agreed Price</span>
                    <span>₱{{ number_format($bid->amount, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Downpayment (50%)</span>
                    <span class="{{ $downpayment && $downpayment->isPaid() ? 'text-green' : '' }}">
                        ₱{{ number_format($downpaymentAmount, 2) }}
                        @if($downpayment && $downpayment->isPaid()) ✓ @endif
                    </span>
                </div>
                <div class="summary-row">
                    <span>Final (50%)</span>
                    <span class="{{ $finalPayment && $finalPayment->isPaid() ? 'text-green' : '' }}">
                        ₱{{ number_format($finalAmount, 2) }}
                        @if($finalPayment && $finalPayment->isPaid()) ✓ @endif
                    </span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row summary-balance">
                    @php
                        $totalPaid = 0;
                        if($downpayment && $downpayment->isPaid()) $totalPaid += $downpaymentAmount;
                        if($finalPayment && $finalPayment->isPaid()) $totalPaid += $finalAmount;
                        $balance = $bid->amount - $totalPaid;
                    @endphp
                    <span>Remaining Balance</span>
                    <span>₱{{ number_format($balance, 2) }}</span>
                </div>
            </div>

            {{-- Secure notice --}}
            <div class="secure-notice">
                <span>🔒</span>
                <span>Payments are processed securely. For GCash/Maya, you'll be redirected to complete payment.</span>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .payment-page { padding: 24px; max-width: 1000px; margin: 0 auto; font-family: 'DM Sans', 'Segoe UI', sans-serif; }

    .back-link { display: inline-flex; align-items: center; gap: 6px; color: #5a7a5a; font-size: 13px; text-decoration: none; margin-bottom: 20px; }
    .back-link:hover { color: #2d5a3d; }

    .payment-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; }
    @media(max-width: 768px) { .payment-layout { grid-template-columns: 1fr; } }

    /* Header */
    .pay-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
    .pay-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #c8862a, #e8a94a); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 4px 12px rgba(200,134,42,0.3); }
    .pay-title { font-size: 22px; font-weight: 700; color: #1a2a1a; margin: 0; }
    .pay-sub { font-size: 13px; color: #6a8a6a; margin: 3px 0 0; }

    /* Steps */
    .payment-steps { display: flex; flex-direction: column; gap: 16px; }

    .pay-step { background: white; border-radius: 16px; border: 1.5px solid #e0e8e0; padding: 20px; transition: box-shadow 0.2s; }
    .pay-step:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
    .step-done { border-color: #b8dfc6; background: #f8fdf8; }
    .step-active { border-color: #f0c070; box-shadow: 0 0 0 3px rgba(200,134,42,0.08); }
    .step-locked { opacity: 0.6; }

    .step-header { display: flex; align-items: center; gap: 14px; }
    .step-num { width: 36px; height: 36px; border-radius: 50%; background: #2d5a3d; color: white; font-size: 14px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .step-done .step-num { background: #22c55e; }
    .step-locked .step-num { background: #ccc; }
    .step-label { font-size: 14px; font-weight: 600; color: #1a2a1a; }
    .step-amount { font-size: 20px; font-weight: 700; color: #2d5a3d; }
    .step-badge-wrap { margin-left: auto; }

    .badge { padding: 4px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.3px; }
    .badge-paid { background: #e8f5ed; color: #1a6b3a; border: 1px solid #b8dfc6; }
    .badge-due { background: #fef3e2; color: #a06010; border: 1px solid #f0c070; }
    .badge-locked { background: #f0f0f0; color: #888; border: 1px solid #ddd; }

    .step-done-info { display: flex; align-items: center; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #e8f0e8; font-size: 13px; color: #4a7a5a; }
    .step-done-info a { color: #2d5a3d; text-decoration: underline; }

    .locked-note { margin-top: 12px; font-size: 13px; color: #999; font-style: italic; }

    /* Summary */
    .summary-card { background: white; border-radius: 16px; border: 1px solid #e0e8e0; padding: 20px; }
    .summary-title { font-size: 15px; font-weight: 700; color: #1a2a1a; margin: 0 0 16px; }
    .summary-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #4a6a4a; padding: 6px 0; }
    .summary-total { font-weight: 700; color: #1a2a1a; font-size: 14px; }
    .summary-balance { font-weight: 700; color: #c8862a; font-size: 15px; }
    .summary-divider { height: 1px; background: #e8eee8; margin: 8px 0; }
    .text-green { color: #22c55e; font-weight: 600; }

    .secure-notice { margin-top: 12px; background: #f5f8f5; border-radius: 10px; padding: 12px; font-size: 12px; color: #5a7a5a; display: flex; gap: 8px; line-height: 1.5; }
</style>
@endpush
@endsection