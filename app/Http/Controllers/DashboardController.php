<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Baker;
use App\Models\Order;
use App\Models\BakerOrder;
use App\Models\Ingredient;
use App\Models\CakeRequest;
use App\Models\Bid;
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

        $activeRequestStatuses = ['OPEN','BIDDING','ACCEPTED','WAITING_FOR_PAYMENT','IN_PROGRESS','WAITING_FINAL_PAYMENT','RUSH_MATCHING'];

        $marketplace = [
            'active_requests'      => CakeRequest::whereIn('status', $activeRequestStatuses)->count(),
            'active_bids'          => Bid::where('status', 'PENDING')->count(),
            'awaiting_baker'       => CakeRequest::where('status', 'OPEN')->doesntHave('bids')->count(),
            'awarded_today'        => BakerOrder::whereDate('created_at', now())->count(),
            'avg_bids_per_request' => CakeRequest::count() > 0
                                        ? Bid::count() / CakeRequest::count()
                                        : 0,
        ];

        // ── Popular Customizations: decode cake_configuration off completed/placed orders ──
        $configuredOrders = BakerOrder::with('cakeRequest')
            ->whereHas('cakeRequest', fn($q) => $q->whereNotNull('cake_configuration'))
            ->get()
            ->map(function ($order) {
                $config = is_array($order->cakeRequest->cake_configuration)
                    ? $order->cakeRequest->cake_configuration
                    : (json_decode($order->cakeRequest->cake_configuration, true) ?? []);
                return [
                    'flavor' => $config['flavor'] ?? 'Unknown',
                    'size'   => $config['size'] ?? 'Unknown',
                ];
            });

        $popular_cakes = $configuredOrders
            ->groupBy('flavor')
            ->map(fn($g, $flavor) => (object) ['name' => $flavor, 'order_count' => $g->count()])
            ->sortByDesc('order_count')
            ->take(3)
            ->values();

        $totalConfigured = $configuredOrders->count();
        $popular_sizes = $configuredOrders
            ->groupBy('size')
            ->map(fn($g, $size) => (object) [
                'name'       => $size,
                'percentage' => $totalConfigured > 0 ? round($g->count() / $totalConfigured * 100) : 0,
            ])
            ->sortByDesc('percentage')
            ->take(3)
            ->values();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'pending_bakers',
            'ingredients',
            'marketplace',
            'popular_cakes',
            'popular_sizes'
        ));
    }
}