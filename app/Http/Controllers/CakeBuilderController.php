<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CakeBuilderController extends Controller
{
    // Pricing config — adjust to your actual prices
    private array $pricing = [
        'size'     => ['6"' => 500, '8"' => 700, '10"' => 950, '12"' => 1200],
        'flavor'   => ['Vanilla' => 0, 'Chocolate' => 50, 'Red Velvet' => 80, 'Ube' => 80, 'Strawberry' => 60],
        'frosting' => ['Buttercream' => 0, 'Fondant' => 150, 'Whipped Cream' => 50, 'Mirror Glaze' => 200],
        'addons'   => [
            'drips'       => 50,
            'fruits'      => 80,
            'choco_deco'  => 70,
            'sprinkles'   => 30,
            'candles'     => 40,
            'toppers'     => 100,
            'decorative'  => 60,
        ],
    ];

    public function index(Request $request)
{
    return view('customer.cake-builder.index', [
        'pricing'  => $this->pricing,
        'prefill'  => $request->only(['flavor', 'frosting', 'size', 'budget_min', 'budget_max', 'occasion', 'baker']),
    ]);
}

    public function calculatePrice(Request $request)
    {
        $request->validate([
            'size'    => 'required|string',
            'flavor'  => 'required|string',
            'frosting'=> 'required|string',
            'addons'  => 'nullable|array',
        ]);

        $base   = $this->pricing['size'][$request->size] ?? 0;
        $flavor = $this->pricing['flavor'][$request->flavor] ?? 0;
        $frost  = $this->pricing['frosting'][$request->frosting] ?? 0;

        $addonsTotal = 0;
        foreach ($request->addons ?? [] as $addon) {
            $addonsTotal += $this->pricing['addons'][$addon] ?? 0;
        }

        $total = $base + $flavor + $frost + $addonsTotal;

        return response()->json([
            'breakdown' => [
                'base_size' => $base,
                'flavor'    => $flavor,
                'frosting'  => $frost,
                'add_ons'   => $addonsTotal,
            ],
            'total' => $total,
        ]);
    }

    public function saveDraft(Request $request)
    {
        $user = Auth::user();

        $key = "cake_draft_{$user->id}";
        Cache::put($key, $request->all(), now()->addDays(7));

        return response()->json(['message' => 'Draft saved!']);
    }

    public function loadDraft()
    {
        $user = Auth::user();
        $key  = "cake_draft_{$user->id}";
        $draft = Cache::get($key);

        return response()->json(['draft' => $draft]);
    }
public function saveAndProceed(Request $request)
{
    $tempKey = null;

    if ($request->filled('cake_preview')) {
        $dataUrl = $request->input('cake_preview');
        if (preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $matches)) {
            $imageData = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1));
            $ext       = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $tempKey   = 'cake_temp_' . uniqid() . '.' . $ext;
            \Storage::disk('public')->put('cake-previews/temp/' . $tempKey, $imageData);
        }
    }

    return redirect()->route('customer.cake-requests.create', [
        'config'    => $request->input('config'),
        'temp_key'  => $tempKey,
    ]);
}
public function drafts()
{
    $user  = Auth::user();
    $key   = "cake_draft_{$user->id}";
    $draft = Cache::get($key);

    return view('customer.save-draft.index', ['draft' => $draft]);
}

public function discardDraft()
{
    Cache::forget("cake_draft_" . Auth::id());
    return redirect()->route('customer.cake-builder.drafts')
        ->with('success', 'Draft discarded.');
}

}