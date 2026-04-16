<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCompleteProfileController extends Controller
{
  public function show()
    {
        $user = Auth::user();

        if (!$user) {
            $pending = session('google_pending');
            if (!$pending || $pending['role'] !== 'customer') {
                return redirect()->route('login');
            }
            // Unsaved user object just for the view
            $user = new \App\Models\User($pending);
            return view('auth.customer-complete-profile', compact('user'));
        }

        // Existing logged-in user — check if already complete
        $hasAddress = $user->addresses()->where('is_default', true)->exists();
        if (!empty($user->phone) && !empty($user->birthdate) && $hasAddress) {
            return redirect()->route('customer.dashboard');
        }

        return view('auth.customer-complete-profile', compact('user'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'phone'        => 'required|string|size:11',
            'birthdate'    => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'address_line' => 'required|string|max:300',
            'city'         => 'required|string|max:100',
            'province'     => 'required|string|max:100',
            'zip'          => 'required|string|size:4',
            'middle_name'  => 'nullable|string|max:100',
            'suffix'       => 'nullable|string|max:10',
        ]);

     // Resolve user — either logged in or pending Google customer (not yet in DB)
        $user = Auth::user();

if (!$user) {
            $pending = session('google_pending');
            if (!$pending || $pending['role'] !== 'customer') {
                return redirect()->route('login');
            }

            // Existing user who never completed profile
            if (!empty($pending['existing_user_id'])) {
                $user = \App\Models\User::find($pending['existing_user_id']);
                if (!$user) {
                    return redirect()->route('login');
                }
            } else {
                // Brand new Google user
                $user = \App\Models\User::create([
                    'first_name'    => $pending['first_name'],
                    'last_name'     => $pending['last_name'],
                    'email'         => $pending['email'],
                    'password'      => bcrypt(\Illuminate\Support\Str::random(24)),
                    'provider'      => 'google',
                    'role'          => 'customer',
                    'profile_photo' => $pending['profile_photo'],
                    'is_verified'   => true,
                ]);
            }

            session()->forget('google_pending');
        }
        $user->update([
            'phone'       => $request->phone,
            'birthdate'   => $request->birthdate,
            'middle_name' => $request->middle_name,
            'suffix'      => $request->suffix,
        ]);

        // Save default address
        $user->addresses()->create([
            'street'     => $request->address_line,
            'city'       => $request->city,
            'province'   => $request->province,
            'zip_code'   => $request->zip,
            'is_default' => true,
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Welcome to BakeSphere! Your profile is complete.');
    }
}