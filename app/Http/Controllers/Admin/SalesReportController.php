<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use App\Models\User;

class SalesReportController extends Controller
{
    public function index()
    {
        $year = now()->year;

        $monthly = BakerOrder::selectRaw('
                MONTH(created_at) AS month,
                SUM(agreed_price) AS revenue,
                COUNT(*)          AS orders
            ')
            ->whereYear('created_at', $year)
            ->whereIn('status', ['DELIVERED', 'COMPLETED'])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $bakers = User::where('role', 'baker')
            ->withCount([
                'bakerOrders as total_orders' => fn($q) => $q
                    ->whereIn('status', ['DELIVERED', 'COMPLETED'])
                    ->whereYear('created_at', $year),
            ])
            ->withSum([
                'bakerOrders as total_revenue' => fn($q) => $q
                    ->whereIn('status', ['DELIVERED', 'COMPLETED'])
                    ->whereYear('created_at', $year),
            ], 'agreed_price')
            ->orderByDesc('total_revenue')
            ->get();

        $base = BakerOrder::whereYear('created_at', $year)
            ->whereIn('status', ['DELIVERED', 'COMPLETED']);

        $stats = [
            'total_revenue'      => (clone $base)->sum('agreed_price'),
            'total_orders'       => (clone $base)->count(),
            'total_bakers'       => User::where('role', 'baker')->count(),
            'active_bakers'      => User::where('role', 'baker')
                ->whereHas('bakerOrders', fn($q) => $q
                    ->whereYear('created_at', $year)
                    ->whereIn('status', ['DELIVERED', 'COMPLETED'])
                )->count(),
            'this_month_revenue' => (clone $base)
                ->whereMonth('created_at', now()->month)->sum('agreed_price'),
            'this_month_orders'  => (clone $base)
                ->whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.sales.index', compact('monthly', 'bakers', 'stats'));
    }
}