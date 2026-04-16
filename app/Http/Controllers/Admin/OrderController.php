<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Baker;
use Illuminate\Http\Request;

class OrderController extends Controller {

    public function index(Request $request) {
        $query = Order::with('customer','baker');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders    = $query->latest()->get();
        $customers = Customer::all();
        $bakers    = Baker::where('status','approved')->get();
        return view('admin.orders.index', compact('orders','customers','bakers'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'customer_id'   => 'nullable|exists:customers,id',
            'baker_id'      => 'nullable|exists:bakers,id',
            'total_amount'  => 'required|numeric|min:0',
            'status'        => 'required|in:pending,confirmed,baking,ready,delivered,cancelled',
            'notes'         => 'nullable|string',
            'delivery_date' => 'nullable|date',
        ]);
        $data['order_number'] = Order::generateNumber();
        Order::create($data);
        return back()->with('success', 'Order created successfully.');
    }

    public function update(Request $request, Order $order) {
        $data = $request->validate([
            'customer_id'   => 'nullable|exists:customers,id',
            'baker_id'      => 'nullable|exists:bakers,id',
            'total_amount'  => 'required|numeric|min:0',
            'status'        => 'required|in:pending,confirmed,baking,ready,delivered,cancelled',
            'notes'         => 'nullable|string',
            'delivery_date' => 'nullable|date',
        ]);
        $order->update($data);
        return back()->with('success', 'Order updated successfully.');
    }

    public function updateStatus(Request $request, Order $order) {
        $request->validate(['status' => 'required|in:pending,confirmed,baking,ready,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }

    public function destroy(Order $order) {
        $order->delete();
        return back()->with('success', 'Order deleted.');
    }

    public function create()  { return redirect()->route('orders.index'); }
    public function show($id) { return redirect()->route('orders.index'); }
    public function edit($id) { return redirect()->route('orders.index'); }
}