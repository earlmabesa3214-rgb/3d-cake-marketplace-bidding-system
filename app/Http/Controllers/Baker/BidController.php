<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\CakeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function index()
    {
        $bids = Bid::where('baker_id', Auth::id())
            ->with('cakeRequest.user')
            ->latest()
            ->paginate(10);

        return view('baker.bids.index', compact('bids'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cake_request_id' => 'required|exists:cake_requests,id',
            'amount'          => 'required|numeric|min:1',
            'estimated_days'  => 'required|integer|min:1|max:30',
            'message'         => 'nullable|string|max:1000',
        ]);

        $cakeRequest = CakeRequest::findOrFail($validated['cake_request_id']);

        // Only allow bidding on OPEN or BIDDING requests
        if (!in_array($cakeRequest->status, ['OPEN', 'BIDDING'])) {
            return back()->with('error', 'This request is no longer accepting bids.');
        }

        // Prevent duplicate bids from the same baker
        $alreadyBid = Bid::where('baker_id', Auth::id())
            ->where('cake_request_id', $cakeRequest->id)
            ->exists();

        if ($alreadyBid) {
            return back()->with('error', 'You have already placed a bid on this request.');
        }

        Bid::create([
            'baker_id'        => Auth::id(),
            'cake_request_id' => $cakeRequest->id,
            'amount'          => $validated['amount'],
            'estimated_days'  => $validated['estimated_days'],
            'message'         => $validated['message'] ?? null,
            'status'          => 'PENDING',
        ]);

        // Mark as BIDDING so customer knows bids are coming in
        // but keep it visible to ALL other bakers
        if ($cakeRequest->status === 'OPEN') {
            $cakeRequest->update(['status' => 'BIDDING']);
        }

        return redirect()->route('baker.requests.show', $cakeRequest->id)
            ->with('success', 'Your bid has been submitted!');
    }

    public function destroy(Bid $bid)
    {
        if ($bid->baker_id !== Auth::id()) {
            abort(403);
        }

        $bid->delete();

        // If no bids remain, revert status back to OPEN
        $cakeRequest = $bid->cakeRequest;
        if ($cakeRequest && $cakeRequest->bids()->count() === 0) {
            $cakeRequest->update(['status' => 'OPEN']);
        }

        return back()->with('success', 'Bid withdrawn successfully.');
    }
}