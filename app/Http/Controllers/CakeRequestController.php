<?php

namespace App\Http\Controllers;

use App\Models\CakeRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CakeRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = CakeRequest::where('user_id', Auth::id())->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(10);

        return view('customer.cake-request.index', compact('requests'));
    }

public function create(Request $request)
{
    $addresses   = Address::where('user_id', Auth::id())->get();
    $config      = [];
    $cakePreview = null;
    $tempKey     = null;

    if ($request->has('config')) {
        $decoded = json_decode($request->query('config'), true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $config = $decoded;
        }
    }

    if ($request->has('temp_key')) {
        $tempKey     = $request->query('temp_key');
        $cakePreview = $tempKey; // pass the key to the view
    }

    return view('customer.cake-request.create', compact('addresses', 'config', 'cakePreview', 'tempKey'));
}
public function store(Request $request)
{
    $isPickup = $request->fulfillment_type === 'pickup';

    $rules = [
        'cake_configuration'   => 'required|string',
        'custom_message'       => 'nullable|string|max:500',
        'reference_image'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        'budget_min'           => 'required|numeric|min:1',
        'budget_max'           => 'required|numeric|gt:budget_min',
        'delivery_date'        => 'required|date|after_or_equal:today',
        'special_instructions' => 'nullable|string|max:1000',
        'fulfillment_type'     => 'required|in:delivery,pickup',
    ];

    if (!$isPickup) {
        $rules['delivery_lat']     = 'required|numeric';
        $rules['delivery_lng']     = 'required|numeric';
        $rules['delivery_address'] = 'required|string|max:500';
    }

    $request->validate($rules, [
        'budget_max.gt'         => 'Maximum budget must be greater than minimum.',
        'delivery_date.after'   => 'Delivery date must be a future date.',
        'delivery_lat.required' => 'Please drop a pin on the map to set your delivery location.',
    ]);

$imagePath = null;
    if ($request->hasFile('reference_image')) {
        $imagePath = $request->file('reference_image')
            ->store('cake-request-images', 'public');
    }

    // ── RUSH ORDER LOGIC ──────────────────────────────────────────────────
    $isRush  = $request->boolean('is_rush');
    $rushFee = 0;
    $autoAssignedBakerId = null;

    if ($isRush) {
        $customerLat = (float) $request->delivery_lat;
        $customerLng = (float) $request->delivery_lng;

        $rushBaker = \App\Models\Baker::where('accepts_rush_orders', true)
            ->where('is_available', true)
            ->where('status', 'approved')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->sortBy(function ($baker) use ($customerLat, $customerLng) {
                $R    = 6371;
                $dLat = deg2rad($baker->latitude - $customerLat);
                $dLng = deg2rad($baker->longitude - $customerLng);
                $a    = sin($dLat/2) * sin($dLat/2) +
                        cos(deg2rad($customerLat)) * cos(deg2rad($baker->latitude)) *
                        sin($dLng/2) * sin($dLng/2);
                return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
            })
            ->first();

        if ($rushBaker) {
            $rushFee             = $rushBaker->rush_fee ?? 0;
            $autoAssignedBakerId = $rushBaker->user_id;
        }
    }

// Replace the cake_preview_image block with this:
$previewPath = null;
if ($request->filled('cake_preview_temp_key')) {
    $tempKey  = $request->input('cake_preview_temp_key');
    $tempPath = 'cake-previews/temp/' . $tempKey;
    if (\Storage::disk('public')->exists($tempPath)) {
        $finalPath = 'cake-previews/' . $tempKey;
        \Storage::disk('public')->move($tempPath, $finalPath);
        $previewPath = $finalPath;
    }
}

  $cakeRequest = CakeRequest::create([
        'user_id'              => Auth::id(),
        'cake_configuration'   => $request->cake_configuration,
        'custom_message'       => $request->custom_message,
        'reference_image'      => $imagePath,
        'cake_preview_image'   => $previewPath,
        'budget_min'           => $request->budget_min,
        'budget_max'           => $request->budget_max,
        'delivery_date'        => $request->delivery_date,
        'fulfillment_type'     => $request->fulfillment_type,
        'delivery_lat'         => $isPickup ? null : $request->delivery_lat,
        'delivery_lng'         => $isPickup ? null : $request->delivery_lng,
        'delivery_address'     => $isPickup ? 'Pickup at Baker\'s Location' : $request->delivery_address,
        'special_instructions' => $request->special_instructions,
        'is_rush'              => $isRush,
        'rush_fee'             => $rushFee,
'status'               => ($isRush && $autoAssignedBakerId) ? 'WAITING_FOR_PAYMENT' : 'OPEN',
    ]);

    // ── If rush and baker found, auto-create bid + order ──────────────────
    if ($isRush && $autoAssignedBakerId) {
        $config    = json_decode($request->cake_configuration, true);
        $bidAmount = ($config['total'] ?? 0) + $rushFee;

    $bid = \App\Models\Bid::create([
            'cake_request_id' => $cakeRequest->id,
            'baker_id'        => $autoAssignedBakerId,
            'amount'          => $bidAmount,
            'status'          => 'ACCEPTED',
            'note'            => 'Auto-matched rush order',
            'estimated_days'  => 1,
        ]);
\App\Models\BakerOrder::create([
            'baker_id'        => $autoAssignedBakerId,
            'cake_request_id' => $cakeRequest->id,
            'bid_id'          => $bid->id,
            'agreed_price'    => $bidAmount,
            'status'          => 'WAITING_FOR_PAYMENT',
            'payout_status'   => 'PENDING',
        ]);
        $bakerUser = \App\Models\User::find($autoAssignedBakerId);
        if ($bakerUser) {
            $bakerUser->notify(new \App\Notifications\BidAcceptedNotification($bid, $cakeRequest));
        }

   return redirect()->route('customer.cake-requests.show', $cakeRequest->id)
    ->with('success', '⚡ Rush order matched! A baker near you has been assigned and will start immediately.')
    ->with('show_rush_modal', true);
    }

    // ── No rush baker available — fall back to normal open bidding ─────────
    if ($isRush && !$autoAssignedBakerId) {
        return redirect()->route('customer.cake-requests.show', $cakeRequest->id)
            ->with('info', '⚡ No rush bakers available right now. Your request has been posted openly — bakers will respond soon.');
    }

    return redirect()->route('customer.cake-requests.show', $cakeRequest->id)
        ->with('success', 'Your cake request has been submitted! Bakers will respond soon.');
}
    public function show(CakeRequest $cakeRequest)
    {
        if ($cakeRequest->user_id !== Auth::id()) {
            abort(403);
        }
        return view('customer.cake-request.show', compact('cakeRequest'));
    }

    public function destroy(CakeRequest $cakeRequest)
    {
        if ($cakeRequest->user_id !== Auth::id()) {
            abort(403);
        }

if (!in_array($cakeRequest->status, ['OPEN', 'BIDDING', 'ACCEPTED'])) {
    return back()->withErrors(['error' => 'Only open, bidding, or accepted requests can be cancelled.']);
}
      $cakeRequest->update(['status' => 'CANCELLED']);

// Also cancel any associated baker order so the baker cannot take further action
$bakerOrder = $cakeRequest->bakerOrder ?? null;
if (!$bakerOrder) {
    $bakerOrder = \App\Models\BakerOrder::where('cake_request_id', $cakeRequest->id)->first();
}
if ($bakerOrder && !in_array($bakerOrder->status, ['CANCELLED', 'DELIVERED', 'COMPLETED'])) {
    $bakerOrder->update([
        'status'        => 'CANCELLED',
        'cancelled_at'  => now(),
        'cancel_reason' => 'Cancelled by customer.',
    ]);
}

return redirect()->route('customer.cake-requests.index')
    ->with('success', 'Request cancelled successfully.');
    }

   public function acceptBid(Request $request, int $requestId, int $bidId)
{
        $cakeRequest = \App\Models\CakeRequest::where('user_id', auth()->id())->findOrFail($requestId);

//abort_if(!in_array($cakeRequest->status, ['OPEN', 'BIDDING']), 403, 'This request is no longer open. Current status: ' . $cakeRequest->status);



        $bid = \App\Models\Bid::where('cake_request_id', $requestId)->findOrFail($bidId);

        \DB::transaction(function () use ($cakeRequest, $bid) {
            $bid->update(['status' => 'ACCEPTED']);

            \App\Models\Bid::where('cake_request_id', $cakeRequest->id)
                ->where('id', '!=', $bid->id)
                ->update(['status' => 'REJECTED']);
\App\Models\BakerOrder::create([
    'baker_id'        => $bid->baker_id,
    'cake_request_id' => $cakeRequest->id,
    'bid_id'          => $bid->id,
    'agreed_price'    => $bid->amount,
    'status'          => 'WAITING_FOR_PAYMENT',
    'payout_status'   => 'PENDING',
]);

$fulfillmentType = request()->input('fulfillment_type', 'delivery');
$cakeRequest->update([
    'status'           => 'WAITING_FOR_PAYMENT',
    'fulfillment_type' => in_array($fulfillmentType, ['delivery','pickup']) ? $fulfillmentType : 'delivery',
]);



$bakerUser = \App\Models\User::find($bid->baker_id);
if ($bakerUser) {
    $bakerUser->notify(new \App\Notifications\BidAcceptedNotification($bid, $cakeRequest));
}
        });

    return redirect()->route('customer.cake-requests.show', $requestId)
                 ->with('success', 'Baker confirmed! Pay your downpayment to begin preparation.');
    }
}