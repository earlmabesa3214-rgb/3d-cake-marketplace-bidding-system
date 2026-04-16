<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = User::where('role', 'customer')
            ->when($request->search, fn($q) => $q
                ->where('first_name', 'like', "%{$request->search}%")
                ->orWhere('last_name',  'like', "%{$request->search}%")
                ->orWhere('email',      'like', "%{$request->search}%"))
            ->when($request->status === 'active',   fn($q) => $q->whereNotNull('email_verified_at'))
            ->when($request->status === 'inactive', fn($q) => $q->whereNull('email_verified_at'))
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        return view('admin.customers.index', compact('customer'));
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return back()->with('success', 'Customer removed successfully.');
    }

    public function create()                          { return redirect()->route('customers.index'); }
    public function edit($id)                         { return redirect()->route('customers.index'); }
    public function store(Request $request)           { return redirect()->route('customers.index'); }
    public function update(Request $request, $id)     { return redirect()->route('customers.index'); }
}