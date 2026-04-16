<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
  public function handle(Request $request, Closure $next, string $role): Response
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role !== $role) {
        return match(auth()->user()->role) {
            'admin'    => redirect()->route('dashboard'),
            'baker'    => redirect()->route('baker.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default    => redirect()->route('login'),
        };
    }

    // ── ADD THIS BLOCK ──────────────────────────────────────────
    // Block pending/incomplete bakers from accessing baker routes
    if ($role === 'baker') {
        $baker = auth()->user()->baker;

        // Profile not yet filled in
        if ($baker && empty($baker->shop_name)) {
            return redirect()->route('baker.complete-profile');
        }

        // Waiting for admin approval
        if (!$baker || $baker->status === 'pending') {
            return redirect()->route('baker.waiting');
        }

        // Rejected baker — log out and redirect
        if ($baker->status === 'rejected') {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your baker application was rejected. Please contact support.']);
        }
    }
    // ────────────────────────────────────────────────────────────

    return $next($request);
}
}