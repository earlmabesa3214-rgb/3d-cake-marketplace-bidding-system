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
        $baker = \App\Models\Baker::where('user_id', Auth::id())->first();

        // ── Standard open/bidding requests (baker hasn't bid yet) ──
        $requests = CakeRequest::whereIn('status', ['OPEN', 'BIDDING'])
            ->with(['user', 'bids'])
            ->whereDoesntHave('bids', function ($q) {
                $q->where('baker_id', Auth::id());
            })
            ->latest()
            ->get();

        // ── Rush requests: only show if baker has rush ON + available + within 10 km ──
        $rushRequests = collect();
        if ($baker && $baker->accepts_rush_orders && $baker->is_available
            && $baker->latitude && $baker->longitude)
        {
     $rushRequests = CakeRequest::where('status', 'RUSH_MATCHING')
                ->where('is_rush', true)
                ->with(['user'])
                ->whereDoesntHave('bids', function ($q) {
                    $q->where('baker_id', Auth::id());
                })
                ->latest()
                ->get()
                ->filter(function ($req) use ($baker) {
                    if (!$req->delivery_lat || !$req->delivery_lng) return true; // pickup — show anyway

                    $R    = 6371;
                    $dLat = deg2rad($baker->latitude - $req->delivery_lat);
                    $dLng = deg2rad($baker->longitude - $req->delivery_lng);
                    $a    = sin($dLat / 2) ** 2
                          + cos(deg2rad($req->delivery_lat)) * cos(deg2rad($baker->latitude))
                          * sin($dLng / 2) ** 2;
                    $km   = $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
                    return $km <= 10;
                });
        }

      // Merge (rush first)
$allRequests = $rushRequests->concat($requests)->values();

// Manual pagination
$perPage     = 10;
$currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
$paged       = new \Illuminate\Pagination\LengthAwarePaginator(
    $allRequests->forPage($currentPage, $perPage),
    $allRequests->count(),
    $perPage,
    $currentPage,
    ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
);

return view('baker.requests.index', [
    'requests'     => $paged,
    'rushRequests' => $rushRequests,
    'baker'        => $baker,
]); 
    }

    /**
     * Show a single cake request with its bids.
     */
    public function show($id)
    {
        $cakeRequest = CakeRequest::with(['user', 'bids'])
            ->findOrFail($id);
$baker = \App\Models\Baker::where('user_id', Auth::id())->first();

        $existingBid = $baker
            ? $cakeRequest->bids->where('baker_id', $baker->id)->first()
            : null;

        // For rush orders: calculate distance to show baker
        $distanceKm = null;
        if ($baker && $cakeRequest->is_rush && $baker->latitude && $baker->longitude
            && $cakeRequest->delivery_lat && $cakeRequest->delivery_lng)
        {
            $R    = 6371;
            $dLat = deg2rad($baker->latitude - $cakeRequest->delivery_lat);
            $dLng = deg2rad($baker->longitude - $cakeRequest->delivery_lng);
            $a    = sin($dLat / 2) ** 2
                  + cos(deg2rad($cakeRequest->delivery_lat)) * cos(deg2rad($baker->latitude))
                  * sin($dLng / 2) ** 2;
            $distanceKm = round($R * 2 * atan2(sqrt($a), sqrt(1 - $a)), 1);
        }

        return view('baker.requests.show', [
            'request'     => $cakeRequest,
            'cakeRequest' => $cakeRequest,
            'existingBid' => $existingBid,
            'distanceKm'  => $distanceKm,
            'baker'        => $baker,
        ]);
    }
}