<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use App\Models\BakerReview;
use App\Models\Baker;
use App\Services\EscrowService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private EscrowService $escrow) {}

    public function confirmDelivery(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== auth()->id(), 403);

        try {
            $this->escrow->releaseToBaker($order);
        } catch (\Exception $e) {
            return back()->with('error', 'Could not complete order: ' . $e->getMessage());
        }

        return back()->with('success', '🎉 Delivery confirmed! Baker has been paid.');
    }

    public function store(Request $request, BakerOrder $order)
    {
        abort_if($order->cakeRequest->user_id !== auth()->id(), 403);

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existing = BakerReview::where('baker_order_id', $order->id)
            ->where('customer_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this order.');
        }

        BakerReview::create([
            'baker_user_id'  => $order->baker_id,
            'customer_id'    => auth()->id(),
            'baker_order_id' => $order->id,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        $bakerRecord = Baker::where('user_id', $order->baker_id)->first();
        if ($bakerRecord) {
            $avg   = BakerReview::where('baker_user_id', $order->baker_id)->avg('rating');
            $count = BakerReview::where('baker_user_id', $order->baker_id)->count();
            $bakerRecord->update([
                'rating'        => round($avg, 2),
                'total_reviews' => $count,
            ]);
        }

        return back()->with('success', 'Thank you for your review!');
    }
}