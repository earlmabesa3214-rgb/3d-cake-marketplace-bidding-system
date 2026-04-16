<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Baker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        $as = request('as', 'customer');

        if (!in_array($as, ['customer', 'baker'])) {
            $as = 'customer';
        }

        session(['google_login_as' => $as]);

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        $intendedRole = session()->pull('google_login_as', 'customer');
        $user         = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Block wrong-role login
            if ($user->role !== $intendedRole && $user->role !== 'admin') {
                $roleLabel = $user->role === 'baker' ? 'a Baker' : 'a Customer';
                return redirect()->route('login')
                    ->withErrors(['email' => "This account is registered as {$roleLabel}. Please use the correct sign-in option."]);
            }

            if ($user->role === 'baker') {
                $baker = $user->baker;

                // Hasn't filled in shop details yet
                if ($baker && empty($baker->shop_name)) {
                    Auth::login($user);
                    return redirect()->route('baker.complete-profile');
                }

                // Still pending admin approval
                if (!$baker || $baker->status === 'pending') {
                    Auth::login($user);
                    return redirect()->route('baker.waiting');
                }

                // Rejected
                if ($baker->status === 'rejected') {
                    return redirect()->route('login')
                        ->withErrors(['email' => 'Your baker application was rejected. Please contact support.']);
                }

                // Approved baker
                Auth::login($user);
                return redirect()->route('baker.dashboard');
            }

            // Admin
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

// Existing Google customer — check all required fields
$hasAddress = $user->addresses()->where('is_default', true)->exists();

if (empty($user->phone) || empty($user->birthdate) || !$hasAddress) {
    Auth::logout();
    session([
        'google_pending' => [
            'first_name'       => $user->first_name,
            'last_name'        => $user->last_name,
            'email'            => $user->email,
            'profile_photo'    => $user->profile_photo,
            'role'             => 'customer',
            'existing_user_id' => $user->id,
        ],
    ]);
    return redirect()->route('customer.complete-profile');
}

            Auth::login($user);
            return redirect()->route('customer.dashboard');
} else {
            // ── NEW USER — store in session only, create record after form submit ──
            [$firstName, $lastName] = $this->splitName($googleUser->getName());

            session([
                'google_pending' => [
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'email'         => $googleUser->getEmail(),
                    'profile_photo' => $googleUser->getAvatar(),
                    'role'          => $intendedRole,
                ],
            ]);

            if ($intendedRole === 'baker') {
                return redirect()->route('baker.complete-profile');
            }

            return redirect()->route('customer.complete-profile');
        }
    }

    private function splitName(string $fullName): array
    {
        $parts = explode(' ', trim($fullName), 2);
        return [$parts[0] ?? 'User', $parts[1] ?? ''];
    }
}