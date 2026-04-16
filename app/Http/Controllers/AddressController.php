<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->latest()->get();
        return view('customer.profile.index', [
            'user'      => Auth::user(),
            'addresses' => $addresses,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'    => 'required|string|max:50',
            'street'   => 'required|string|max:255',
            'city'     => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        // If first address, set as default
        $isFirst = Address::where('user_id', Auth::id())->count() === 0;

        Address::create([
            'user_id'    => Auth::id(),
            'label'      => $request->label,
            'street'     => $request->street,
            'city'       => $request->city,
            'province'   => $request->province,
            'zip_code'   => $request->zip_code,
            'is_default' => $isFirst || $request->boolean('is_default'),
        ]);

        return back()->with('success', 'Address added successfully!');
    }

    public function update(Request $request, Address $address)
    {
        // Ownership check
        if ($address->user_id !== Auth::id()) abort(403);

        $request->validate([
            'label'    => 'required|string|max:50',
            'street'   => 'required|string|max:255',
            'city'     => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $address->update($request->only(['label','street','city','province','zip_code']));

        return back()->with('success', 'Address updated!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $address->delete();

        // If deleted address was default, set next one as default
        if ($address->is_default) {
            $next = Address::where('user_id', Auth::id())->first();
            if ($next) $next->update(['is_default' => true]);
        }

        return back()->with('success', 'Address removed.');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        // Remove default from all
        Address::where('user_id', Auth::id())->update(['is_default' => false]);

        // Set this as default
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated!');
    }
}