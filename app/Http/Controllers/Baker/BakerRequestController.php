<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\CakeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BakerRequestController extends Controller
{
    /**
     * List all open/bidding cake requests available to the baker.
     * Hides requests the baker has already bid on.
     */
    public function index()
    {
        $requests = CakeRequest::whereIn('status', ['OPEN', 'BIDDING'])
            ->with(['user', 'bids'])
            ->whereDoesntHave('bids', function ($q) {
                $q->where('baker_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('baker.requests.index', compact('requests'));
    }

    /**
     * Show a single cake request with its bids.
     */
    public function show($id)
    {
        $cakeRequest = CakeRequest::with(['user', 'bids'])
            ->findOrFail($id);

        // Check if the authenticated baker has already placed a bid
        $existingBid = $cakeRequest->bids
            ->where('baker_id', Auth::id())
            ->first();

        return view('baker.requests.show', [
            'request'     => $cakeRequest,
            'cakeRequest' => $cakeRequest,
            'existingBid' => $existingBid,
        ]);
    }
}