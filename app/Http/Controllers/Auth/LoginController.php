<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 1. Check if Google account
        $user = User::where('email', $request->email)->first();

        if ($user && $user->provider === 'google') {
            return back()->withErrors([
                'email' => 'This account uses Google Sign-In. Please use the "Continue with Google" button below.',
            ])->withInput($request->only('email'));
        }

        // 2. Attempt login
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. Admin → straight to dashboard
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

            // 4. Baker → check approval status before allowing in
            if ($user->role === 'baker') {
                $baker = $user->baker;

                // Baker has no profile yet (Google user who didn't finish)
                if (!$baker || empty($baker->shop_name)) {
                    return redirect()->route('baker.complete-profile');
                }

                // Still waiting for admin review
                if ($baker->status === 'pending') {
                    return redirect()->route('baker.waiting');
                }

                // Admin rejected the application
                if ($baker->status === 'rejected') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')->withErrors([
                        'email' => 'Your baker application was rejected. Please contact support for more information.',
                    ]);
                }

                // approved → let them in
                return redirect()->route('baker.dashboard');
            }

            // 5. Customer
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }

    /**
     * Smart email check — called by the login form JS to detect Google vs password accounts.
     * Public route (no auth middleware) because the user is not logged in yet.
     */
    public function checkEmailProvider(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'not_found']);
        }

        if ($user->provider === 'google') {
            return response()->json(['status' => 'google']);
        }

        return response()->json(['status' => 'password']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}