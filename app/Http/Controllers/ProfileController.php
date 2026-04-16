<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
    return view('customer.profile.index', compact('user', 'addresses'));
}

    public function edit()
    {
        $user = Auth::user();
        return view('customer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => ['required','email', Rule::unique('users')->ignore($user->id)],
            'phone'         => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'      => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic info
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        // Handle password change
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('customer.profile.index')
            ->with('success', 'Profile updated successfully!');
    }
 public function bakerPublicProfile($bakerId)
{
    $bakerUser   = \App\Models\User::with('baker')->findOrFail($bakerId);
    $bakerRecord = $bakerUser->baker;

    // Portfolio
    $portfolio = [];
    if ($bakerRecord?->portfolio) {
        $portfolio = is_array($bakerRecord->portfolio)
            ? $bakerRecord->portfolio
            : (json_decode($bakerRecord->portfolio, true) ?? []);
    }

    // Specialties — handle both JSON string and array
    $specialties = [];
    if ($bakerRecord?->specialties) {
        $specialties = is_array($bakerRecord->specialties)
            ? $bakerRecord->specialties
            : (json_decode($bakerRecord->specialties, true) ?? []);
    }

    // Reviews using BakerReview model
    $reviews = collect();
    try {
        $reviews = \App\Models\BakerReview::where('baker_user_id', $bakerId)
            ->with('customer:id,first_name,last_name')
            ->latest()
            ->take(20)
            ->get()
            ->map(fn($r) => [
                'name'    => ($r->customer?->first_name ?? 'Customer') . ' '
                           . substr($r->customer?->last_name ?? '', 0, 1) . '.',
                'rating'  => (int) $r->rating,
                'comment' => $r->comment ?? '',
                'date'    => $r->created_at->format('M d, Y'),
            ]);
    } catch (\Exception $e) {
        // BakerReview table may not exist yet — return empty
    }

    $avgRating    = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : null;
    $totalReviews = $reviews->count();

    return response()->json([
        'name'          => $bakerUser->first_name . ' ' . $bakerUser->last_name,
        'shop_name'     => $bakerRecord?->shop_name,
        'bio'           => $bakerRecord?->bio,
        'experience'    => $bakerRecord?->experience_years,
        'min_order'     => $bakerRecord?->min_order_price,
        'specialties'   => $specialties,
        'portfolio'     => array_map(fn($p) => \Storage::url($p), $portfolio),
        'profile_photo' => $bakerUser->profile_photo
            ? (str_starts_with($bakerUser->profile_photo, 'http')
                ? $bakerUser->profile_photo
                : \Storage::url($bakerUser->profile_photo))
            : null,
        'rating'        => $avgRating,
        'total_reviews' => $totalReviews,
        'reviews'       => $reviews->values(),
        'seller_type'   => $bakerRecord?->seller_type,
        'social_media'  => $bakerRecord?->social_media,
    ]);
}
}
