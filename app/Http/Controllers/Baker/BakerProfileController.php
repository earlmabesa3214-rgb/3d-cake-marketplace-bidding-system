<?php

namespace App\Http\Controllers\Baker;

use App\Http\Controllers\Controller;
use App\Models\BakerPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BakerProfileController extends Controller
{
    public function index()
{
    $baker          = Auth::user()->load('baker');
    $paymentMethods = BakerPaymentMethod::where('baker_id', $baker->baker?->id ?? 0)
                        ->orderBy('created_at')
                        ->get();
    $methodTypes    = $paymentMethods->pluck('type')->toArray();

    // Add this:
    $reviews = \App\Models\BakerReview::where('baker_user_id', $baker->id)
                ->with('customer:id,first_name,last_name')
                ->latest()
                ->get();

    return view('baker.profile.index', compact('baker', 'paymentMethods', 'methodTypes', 'reviews'));
}

    public function edit()
    {
        return redirect()->route('baker.profile.index');
    }

    public function update(Request $request)
    {
        $user  = Auth::user();
        $baker = $user->baker;
        $tab   = $request->input('_tab', 'bakery');

        switch ($tab) {

            case 'bakery':
                $request->validate([
                    'shop_name'        => 'required|string|max:255',
                    'first_name'       => 'nullable|string|max:100',
                    'last_name'        => 'nullable|string|max:100',
                    'phone'            => 'nullable|string|max:20',
                    'experience_years' => 'nullable|string',
                    'min_order_price'  => 'nullable|numeric|min:0',
                    'social_media'     => 'nullable|url|max:255',
                    'bio'              => 'nullable|string|max:1000',
                    'specialties'      => 'nullable|array',
                ]);

                $user->update([
                    'first_name' => $request->first_name ?? $user->first_name,
                    'last_name'  => $request->last_name  ?? $user->last_name,
                    'phone'      => $request->phone      ?? $user->phone,
                ]);

                $baker->update([
                    'shop_name'        => $request->shop_name,
                    'experience_years' => $request->experience_years,
                    'min_order_price'  => $request->min_order_price,
                    'social_media'     => $request->social_media,
                    'bio'              => $request->bio,
                    'specialties'      => $request->specialties ?? [],
                    'name'             => ($request->first_name ?? $user->first_name) . ' ' . ($request->last_name ?? $user->last_name),
                    'email'            => $user->email,
                ]);
                auth()->user()->notify(new \App\Notifications\ProfileUpdatedNotification('Bakery information updated successfully.'));

                break;
case 'location':
    $request->validate([
        'full_address' => 'required|string|max:500',
        'latitude'     => 'nullable|numeric',
        'longitude'    => 'nullable|numeric',
    ]);
    $baker->update([
        'full_address' => $request->full_address,
        'address'      => $request->full_address,
        'latitude'     => $request->latitude  ?: null,
        'longitude'    => $request->longitude ?: null,
    ]);
    auth()->user()->notify(new \App\Notifications\ProfileUpdatedNotification('Bakery location updated successfully.'));

    break;

          case 'portfolio':
    $portfolio = is_array($baker->portfolio)
        ? $baker->portfolio
        : (json_decode($baker->portfolio, true) ?? []);

    // Remove deleted photos
    if ($request->filled('remove_photos')) {
        foreach ($request->remove_photos as $path) {
            Storage::disk('public')->delete($path);
            $portfolio = array_values(array_filter($portfolio, fn($p) => $p !== $path));
        }
    }

    // Add new photos (up to 5 total)
    if ($request->hasFile('new_photos')) {
        foreach ($request->file('new_photos') as $photo) {
            if (count($portfolio) >= 5) break;
            $portfolio[] = $photo->store('baker-portfolio', 'public');
        }
    }

    $baker->update(['portfolio' => $portfolio]);
    auth()->user()->notify(new \App\Notifications\ProfileUpdatedNotification('Portfolio photos updated successfully.'));

    break;

default:
    break;
        }

        return redirect()->route('baker.profile.index', ['tab' => $tab])
            ->with('success', 'Profile updated successfully!');
    }

    public function toggleAvailability(Request $request)
    {
        $baker = Auth::user()->baker;
        if (!$baker) {
            return back()->with('error', 'Baker profile not found.');
        }
        $baker->update(['is_available' => !$baker->is_available]);
        $status = $baker->is_available ? 'Available' : 'Unavailable';
        return back()->with('success', "You are now marked as {$status}.");
    }
    
public function toggleRush(Request $request)
    {
        $baker = auth()->user()->baker;

        if ($request->has('accepts_rush')) {
            $baker->update(['accepts_rush_orders' => $request->accepts_rush]);
        }
        if ($request->has('rush_fee')) {
            $baker->update(['rush_fee' => max(0, (int) $request->rush_fee)]);
        }

        return response()->json(['ok' => true]);
    }
}