<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BakerProfileComplete
{
    /**
     * Fields required before a baker can bid.
     * Returns array of missing field labels, or empty array if complete.
     */
    public static function getMissingFields($user): array
    {
        $baker = $user->baker;
        if (!$baker) return ['Baker profile not found'];

        $missing = [];

        if (empty($baker->shop_name))   $missing[] = 'Bakery / Shop Name';
        if (empty($baker->full_address) && empty($baker->address)) $missing[] = 'Bakery Address';
        if (empty($baker->latitude) || empty($baker->longitude))   $missing[] = 'Map Pin Location';

        // Documents — check based on seller type
        if ($baker->seller_type === 'homebased') {
            if (empty($baker->gov_id_front)) $missing[] = 'Government ID (Front)';
            if (empty($baker->id_selfie))    $missing[] = 'Selfie with ID';
        } else {
            // registered or null (default to registered check)
            if (empty($baker->business_permit))  $missing[] = 'Business Permit';
            if (empty($baker->dti_certificate))  $missing[] = 'DTI / SEC Certificate';
            if (empty($baker->sanitary_permit))  $missing[] = 'Sanitary Permit';
        }

        return $missing;
    }

    public static function isComplete($user): bool
    {
        return empty(self::getMissingFields($user));
    }

    /**
     * Block bid routes if profile is incomplete.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->role === 'baker' && !self::isComplete($user)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Complete your baker profile before bidding.',
                ], 403);
            }

            return redirect()->route('baker.profile.index')
                ->with('incomplete_profile', true)
                ->withErrors(['profile' => 'Please complete your baker profile before placing bids.']);
        }

        return $next($request);
    }
}