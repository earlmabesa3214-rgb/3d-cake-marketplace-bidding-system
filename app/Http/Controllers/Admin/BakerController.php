<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Baker;
use App\Notifications\BakerApproved;
use App\Notifications\BakerRejected;
use Illuminate\Http\Request;

class BakerController extends Controller
{
    public function index(Request $request)
    {
        $query = Baker::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bakers = $query->get();
        return view('admin.bakers.index', compact('bakers'));
    }

    public function show(Baker $baker)
    {
        $baker->load('user');
        return view('admin.bakers.show', compact('baker'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:bakers',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'specialties' => 'nullable|string',
        ]);

        Baker::create($data);
        return back()->with('success', 'Baker registered successfully.');
    }

    public function update(Request $request, Baker $baker)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:bakers,email,' . $baker->id,
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'specialties' => 'nullable|string',
            'status'      => 'required|in:pending,approved,rejected',
        ]);

        $baker->update($data);
        return back()->with('success', 'Baker updated successfully.');
    }

    /**
     * Approve a baker application.
     * Updates status → sends approval email → baker can now log in to dashboard.
     */
    public function approve(Baker $baker)
    {
        $baker->update(['status' => 'approved']);

        // Notify the baker's user account via email
        if ($baker->user) {
            $baker->user->notify(new BakerApproved($baker));
        }

        return back()->with('success', $baker->name . ' has been approved. They will receive an email notification.');
    }

    /**
     * Reject a baker application.
     * Updates status → sends rejection email → baker is blocked at login.
     */
    public function reject(Request $request, Baker $baker)
    {
        $reason = $request->input('reason', '');

        $baker->update(['status' => 'rejected']);

        // Notify the baker's user account via email
        if ($baker->user) {
            $baker->user->notify(new BakerRejected($baker, $reason));
        }

        return back()->with('success', $baker->name . ' has been rejected. They will receive an email notification.');
    }

    public function destroy(Baker $baker)
    {
        $baker->delete();
        return back()->with('success', 'Baker removed successfully.');
    }

    public function create() { return redirect()->route('bakers.index'); }
    public function edit($id) { return redirect()->route('bakers.index'); }
}