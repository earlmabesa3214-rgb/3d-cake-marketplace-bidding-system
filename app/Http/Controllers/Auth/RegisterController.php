<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|min:8|confirmed',
            'terms'      => 'accepted',
        ], [
            'email.unique'       => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
            'terms.accepted'     => 'You must accept the Terms & Conditions.',
        ]);

        User::create([
            'first_name'               => $request->first_name,
            'last_name'                => $request->last_name,
            'email'                    => $request->email,
            'phone'                    => $request->phone,
            'password'                 => Hash::make($request->password),
            'email_verification_token' => Str::random(64),
            'is_verified'              => false,
            'role'                     => 'customer',
        ]);

        return redirect()->route('login')
            ->with('success', 'Account created! You can now log in.');
    }
}