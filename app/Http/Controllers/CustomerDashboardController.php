<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
   public function index()
{
    $user = auth()->user();
    
    $totalRequests     = $user->cakeRequests()->count();
    $pendingRequests   = $user->cakeRequests()->whereIn('status', ['OPEN','BIDDING','ACCEPTED','IN_PROGRESS','WAITING_FOR_PAYMENT','WAITING_FINAL_PAYMENT'])->count();
    $completedRequests = $user->cakeRequests()->where('status', 'COMPLETED')->count();
    $recentRequests    = $user->cakeRequests()->latest()->take(5)->get();

    return view('customer.dashboard', compact(
        'totalRequests',
        'pendingRequests', 
        'completedRequests',
        'recentRequests'
    ));
}
}