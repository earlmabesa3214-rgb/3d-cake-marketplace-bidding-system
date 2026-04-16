<?php

namespace App\Http\Controllers;

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
    ->latest()
    ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
        ]);

        $customer->update($request->only('name', 'email', 'phone', 'status'));

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}