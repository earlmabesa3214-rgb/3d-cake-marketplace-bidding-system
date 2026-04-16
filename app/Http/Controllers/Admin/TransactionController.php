<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BakerOrder;
use App\Models\CakeRequest;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = BakerOrder::with([
            'cakeRequest.user',
            'baker',
            // removed 'cakeRequest.payments' — relationship doesn't exist
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('cakeRequest.user', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', "%$search%")
                       ->orWhere('last_name',  'like', "%$search%")
                       ->orWhere('email',       'like', "%$search%");
                })->orWhereHas('baker', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', "%$search%")
                       ->orWhere('last_name',  'like', "%$search%");
                });
            });
        }

        $transactions = $query->paginate(20);

        $stats = [
            'total'     => BakerOrder::count(),
            'active'    => BakerOrder::whereNotIn('status', ['COMPLETED', 'CANCELLED'])->count(),
            'completed' => BakerOrder::where('status', 'COMPLETED')->count(),
            'cancelled' => BakerOrder::where('status', 'CANCELLED')->count(),
            'revenue'   => BakerOrder::where('status', 'COMPLETED')->sum('agreed_price'),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    public function show(BakerOrder $bakerOrder)
    {
        $bakerOrder->load([
            'cakeRequest.user',
            // removed 'cakeRequest.payments' here too
            'baker',
            'messages.sender',
        ]);

        return view('admin.transactions.show', compact('bakerOrder'));
    }
}