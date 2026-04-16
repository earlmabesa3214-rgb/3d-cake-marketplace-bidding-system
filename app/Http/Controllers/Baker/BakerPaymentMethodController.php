<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\BakerPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BakerPaymentMethodController extends Controller
{
    public function index()
    {
        $baker          = Auth::user()->baker;
        $paymentMethods = BakerPaymentMethod::where('baker_id', $baker->id)->get();

        return view('baker.payment-methods.index', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'           => 'required|in:gcash,maya,cash',
            'account_name'   => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:20',
            'qr_code'        => 'nullable|image|max:5120',
        ]);

        $baker = Auth::user()->baker;

        // Prevent duplicate type
        if (BakerPaymentMethod::where('baker_id', $baker->id)->where('type', $request->type)->exists()) {
            return back()->with('error', ucfirst($request->type) . ' payment method already added.');
        }

        $qrPath = null;
        if ($request->hasFile('qr_code')) {
            $qrPath = $request->file('qr_code')->store('baker-qr-codes', 'public');
        }

        BakerPaymentMethod::create([
            'baker_id'       => $baker->id,
            'type'           => $request->type,
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'qr_code_path'   => $qrPath,
            'is_active'      => true,
        ]);

        return back()->with('success', 'Payment method added successfully!');
    }

    public function update(Request $request, BakerPaymentMethod $paymentMethod)
    {
        abort_if($paymentMethod->baker_id !== Auth::user()->baker->id, 403);

        $request->validate([
            'account_name'   => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:20',
            'qr_code'        => 'nullable|image|max:5120',
            'is_active'      => 'boolean',
        ]);

        $data = $request->only(['account_name', 'account_number', 'is_active']);

        if ($request->hasFile('qr_code')) {
            // Delete old QR
            if ($paymentMethod->qr_code_path) {
                Storage::disk('public')->delete($paymentMethod->qr_code_path);
            }
            $data['qr_code_path'] = $request->file('qr_code')->store('baker-qr-codes', 'public');
        }

        $paymentMethod->update($data);

        return back()->with('success', 'Payment method updated!');
    }

    public function destroy(BakerPaymentMethod $paymentMethod)
    {
        abort_if($paymentMethod->baker_id !== Auth::user()->baker->id, 403);

        if ($paymentMethod->qr_code_path) {
            Storage::disk('public')->delete($paymentMethod->qr_code_path);
        }

        $paymentMethod->delete();

        return back()->with('success', 'Payment method removed.');
    }

    // Baker confirms cash payment received
    public function confirmCash(Request $request, $paymentId)
    {
        $payment = \App\Models\Payment::findOrFail($paymentId);
        abort_if($payment->baker_id !== Auth::id(), 403);

        $payment->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Payment confirmed!');
    }
}