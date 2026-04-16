<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use App\Models\CakeRequest;
use App\Models\Payment;
use App\Models\PlatformAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerPaymentController extends Controller
{
    public function show(CakeRequest $cakeRequest)
    {
        abort_if($cakeRequest->user_id !== Auth::id(), 403);

        abort_unless(
            in_array($cakeRequest->status, [
                'WAITING_FOR_PAYMENT', 'WAITING_FINAL_PAYMENT',
                'ACCEPTED', 'IN_PROGRESS', 'COMPLETED',
            ]),
            404, 'Payment is not available for this request.'
        );

        $acceptedBid = $cakeRequest->bids()
            ->whereIn('status', ['ACCEPTED', 'accepted'])
            ->first();
        abort_if(!$acceptedBid, 404, 'No accepted bid found.');

        // Platform accounts instead of baker's personal accounts
        $platformAccounts = PlatformAccount::active();
        $gcashAccount     = $platformAccounts->where('type', 'gcash')->first();
        $mayaAccount      = $platformAccounts->where('type', 'maya')->first();

        $downpayment  = Payment::where('cake_request_id', $cakeRequest->id)
            ->where('payment_type', 'downpayment')->first();
        $finalPayment = Payment::where('cake_request_id', $cakeRequest->id)
            ->where('payment_type', 'final')->first();

        $activePaymentType = $cakeRequest->status === 'WAITING_FINAL_PAYMENT'
            ? 'final'
            : 'downpayment';

        return view('customer.payment.show', compact(
            'cakeRequest', 'acceptedBid',
            'gcashAccount', 'mayaAccount',
            'downpayment', 'finalPayment',
            'activePaymentType'
        ));
    }

    public function submitProof(Request $request, CakeRequest $cakeRequest)
    {
        abort_if($cakeRequest->user_id !== Auth::id(), 403);

        abort_unless(
            in_array($cakeRequest->status, [
                'WAITING_FOR_PAYMENT', 'WAITING_FINAL_PAYMENT',
                'ACCEPTED', 'IN_PROGRESS',
            ]),
            403, 'Cannot submit payment for this request.'
        );

        $request->validate([
            'payment_method'    => 'required|in:gcash,maya',
            'payment_type'      => 'required|in:downpayment,final',
            'platform_reference'=> 'required|string|max:100',
            'proof_of_payment'  => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'platform_reference.required' => 'Please enter the GCash/Maya reference number.',
            'proof_of_payment.required'   => 'Please upload your payment screenshot.',
        ]);

        $paymentType = $request->payment_type;

        $existing = Payment::where('cake_request_id', $cakeRequest->id)
            ->where('payment_type', $paymentType)->first();

        if ($existing && $existing->isPaid()) {
            return back()->with('error', ucfirst($paymentType) . ' has already been confirmed.');
        }

        $acceptedBid       = $cakeRequest->bids()->whereIn('status', ['ACCEPTED', 'accepted'])->first();
        $totalAmount       = $acceptedBid->amount;
        $downpaymentAmount = round($totalAmount * 0.5, 2);
        $amount            = $paymentType === 'downpayment'
            ? $downpaymentAmount
            : ($totalAmount - $downpaymentAmount);

        $proofPath = $request->file('proof_of_payment')
            ->store('payment-proofs', 'public');

        Payment::updateOrCreate(
            ['cake_request_id' => $cakeRequest->id, 'payment_type' => $paymentType],
            [
                'bid_id'             => $acceptedBid->id,
                'customer_id'        => Auth::id(),
                'payment_method'     => $request->payment_method,
                'status'             => 'pending',
                'escrow_status'      => 'pending',
                'agreed_price'       => $totalAmount,
                'amount'             => $amount,
                'proof_of_payment_path' => $proofPath,
                'platform_reference' => $request->platform_reference,
                'paid_at'            => now(),
            ]
        );

        return redirect()
            ->route('customer.cake-requests.show', $cakeRequest->id)
            ->with('success', 'Payment proof submitted! Our team will verify and hold your payment securely. You will be notified once confirmed.');
    }

    public function reupload(Request $request, CakeRequest $cakeRequest)
    {
        abort_if($cakeRequest->user_id !== Auth::id(), 403);

        $request->validate([
            'payment_type'      => 'required|in:downpayment,final',
            'proof'             => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'platform_reference'=> 'required|string|max:100',
        ]);

        $payment = Payment::where('cake_request_id', $cakeRequest->id)
            ->where('payment_type', $request->payment_type)
            ->firstOrFail();

        if ($payment->status !== 'rejected') {
            return redirect()
                ->route('customer.cake-requests.show', $cakeRequest->id)
                ->with('error', 'This payment cannot be re-uploaded right now.');
        }

        if (($payment->rejection_count ?? 0) >= 2) {
            $cakeRequest->update(['status' => 'CANCELLED']);
            return redirect()
                ->route('customer.cake-requests.show', $cakeRequest->id)
                ->with('error', 'Your order has been cancelled due to repeated payment rejections.');
        }

        if ($payment->proof_of_payment_path) {
            Storage::disk('public')->delete($payment->proof_of_payment_path);
        }

        $proofPath = $request->file('proof')->store('payment-proofs', 'public');

        $payment->update([
            'proof_of_payment_path' => $proofPath,
            'platform_reference'    => $request->platform_reference,
            'status'                => 'pending',
            'escrow_status'         => 'pending',
            'paid_at'               => now(),
            'rejection_reason'      => null,
            'rejection_note'        => null,
            'rejected_at'           => null,
            'reupload_requested_at' => null,
        ]);

        return redirect()
            ->route('customer.cake-requests.show', $cakeRequest->id)
            ->with('success', 'Proof re-submitted! Our team will verify it shortly.');
    }
}