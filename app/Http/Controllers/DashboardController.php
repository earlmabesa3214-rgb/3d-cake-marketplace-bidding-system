<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Baker;
use App\Models\Order;
use App\Models\BakerOrder;
use App\Models\Ingredient;
use App\Models\CakeRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => CakeRequest::count(),
            'pending_orders'  => CakeRequest::whereIn('status', ['OPEN','BIDDING','ACCEPTED','IN_PROGRESS'])->count(),

            // ✅ FIX: Pull monthly revenue from BakerOrder (completed transactions) not Order
            'monthly_revenue' => BakerOrder::where('status', 'COMPLETED')
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->sum('agreed_price') ?? 0,

            'total_bakers'    => Baker::count(),
            'pending_bakers'  => Baker::where('status', 'pending')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
        ];

        // ✅ FIX: Recent orders now pulls from BakerOrder (transactions) not CakeRequest
        $recent_orders  = BakerOrder::with(['cakeRequest.user', 'baker'])
                            ->latest()
                            ->take(6)
                            ->get();

        $pending_bakers = Baker::where('status', 'pending')->latest()->take(4)->get();
        $ingredients    = Ingredient::all();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'pending_bakers',
            'ingredients'
        ));
    }
}