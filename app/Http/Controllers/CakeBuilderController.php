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
    // Hidden completely: Inactive / Draft
    $disabledNames = \App\Models\Ingredient::whereIn('status', ['inactive', 'draft'])
        ->pluck('name')
        ->values();

    // Visible but locked with a "Coming Soon" badge
    $comingSoonNames = \App\Models\Ingredient::where('status', 'coming_soon')
        ->pluck('name')
        ->values();

    // Active + Coming Soon are loaded so both can be displayed
    $components = \App\Models\Ingredient::whereIn('status', ['active', 'coming_soon'])
        ->get()
        ->groupBy('category');

    $castPriceMap = fn($categoryKey) => $components->get($categoryKey, collect())
        ->pluck('price', 'name')
        ->map(fn($p) => (float) $p);

    $priceMaps = [
        'cake_type' => $castPriceMap('cake_type'),
        'shape'     => $castPriceMap('shape'),
        'filling'   => $castPriceMap('filling'),
        'fruit'     => $castPriceMap('fruit'),
        'choco'     => $castPriceMap('choco'),
        'candle'    => $castPriceMap('candle'),
    ];

    // Tier maps: [single, two-tier, three-tier] per component name.
    // A blank tier field in the admin falls back to the Single price.
    $buildTierMap = function ($categoryKey) use ($components) {
        return $components->get($categoryKey, collect())->mapWithKeys(function ($c) {
            $single = (float) $c->price;
            return [$c->name => [
                $single,
                $c->price_two_tier !== null ? (float) $c->price_two_tier : $single,
                $c->price_three_tier !== null ? (float) $c->price_three_tier : $single,
            ]];
        });
    };

    $tierPriceMaps = [
        'cake_style' => $buildTierMap('cake_style'),
        'base_icing' => $buildTierMap('base_icing'),
        'texture'    => $buildTierMap('texture'),
        'drip'       => $buildTierMap('drip'),
        'sprinkle'   => $buildTierMap('sprinkle'),
        'choco'      => $buildTierMap('choco'),
    ];

    // Round size prices — parses the leading number off names like 'Round 6"'.
    $roundSizePrices = $components->get('shape', collect())
        ->filter(fn($c) => preg_match('/^Round (\d+)"$/', $c->name, $m))
        ->mapWithKeys(function ($c) {
            preg_match('/^Round (\d+)"$/', $c->name, $m);
            return [(int) $m[1] => (float) $c->price];
        });

    // Two/Three-tier shape prices — Round/Square/Heart's own row carries its
    // tier prices in price_two_tier / price_three_tier.
    $tierShapePrices = $components->get('shape', collect())
        ->whereIn('name', ['Round', 'Square', 'Heart'])
        ->mapWithKeys(fn($c) => [$c->name => [
            'two'   => $c->price_two_tier !== null ? (float) $c->price_two_tier : (float) $c->price,
            'three' => $c->price_three_tier !== null ? (float) $c->price_three_tier : (float) $c->price,
        ]]);

      $characterPrices = $components->get('candle', collect())
        ->reject(fn($c) => $c->name === 'Number Candles' || $c->name === 'Number Candles (0–9)')
        ->pluck('price', 'name')
        ->map(fn($p) => (float) $p);

    return view('customer.cake-builder.index', [
        'pricing'          => $this->pricing,
        'prefill'          => $request->only(['flavor', 'frosting', 'size', 'budget_min', 'budget_max', 'occasion', 'baker']),
        'components'       => $components,
        'priceMaps'        => $priceMaps,
        'tierPriceMaps'    => $tierPriceMaps,
        'roundSizePrices'  => $roundSizePrices,
        'tierShapePrices'  => $tierShapePrices,
        'characterPrices'  => $characterPrices,
        'disabledNames'    => $disabledNames,
        'comingSoonNames'  => $comingSoonNames,
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
    public function saveDraft(Request $request)
{
    $user = Auth::user();
    $key  = "cake_drafts_{$user->id}";

    $drafts = Cache::get($key, []);

    // Only 5 slots exist in the shelf scene (scenes 2–6). Block the save
    // and flash a flag the scene view uses to pop the "storage full" modal.
    if (count($drafts) >= 5) {
        return redirect()->route('customer.cake-builder.drafts')
            ->with('draft_limit_reached', true);
    }

    $draft = json_decode($request->input('config', '{}'), true) ?: [];

    $draft['id']       = (string) \Illuminate\Support\Str::uuid();
    $draft['saved_at'] = now()->toDateTimeString();

    // Save the snapshot to disk instead of caching the base64 blob directly —
    // keeps each cached draft row tiny regardless of how many drafts are saved.
    if ($request->filled('preview_image')) {
        $dataUrl = $request->input('preview_image');
        if (preg_match('/^data:image\/(\w+);base64,(.+)$/', $dataUrl, $matches)) {
            $ext       = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $imageData = base64_decode($matches[2]);
            $path      = 'draft-previews/' . $draft['id'] . '.' . $ext;
            \Storage::disk('public')->put($path, $imageData);
            $draft['preview_image'] = \Storage::disk('public')->url($path);
        }
    }

    // Newest draft goes first
    array_unshift($drafts, $draft);

    // Cap at 5 — oldest gets bumped off, and clean up its stored image file
    if (count($drafts) > 5) {
        $overflow = array_slice($drafts, 5);
        foreach ($overflow as $old) {
            if (!empty($old['preview_image'])) {
                $oldPath = str_replace(\Storage::disk('public')->url(''), '', $old['preview_image']);
                \Storage::disk('public')->delete($oldPath);
            }
        }
        $drafts = array_slice($drafts, 0, 5);
    }

    Cache::put($key, $drafts, now()->addDays(30));

    return redirect()->route('customer.cake-builder.drafts')
        ->with('success', 'Draft saved!');
}
public function loadDraft(Request $request)
{
    $user   = Auth::user();
    $key    = "cake_drafts_{$user->id}";
    $drafts = Cache::get($key, []);

    $draft = $request->filled('id')
        ? collect($drafts)->firstWhere('id', $request->query('id'))
        : ($drafts[0] ?? null);

    return response()->json(['draft' => $draft]);
}

public function drafts()
{
    $user   = Auth::user();
    $key    = "cake_drafts_{$user->id}";
    $drafts = Cache::get($key, []);

    return view('customer.save-draft.index', ['drafts' => $drafts]);
}

public function discardDraft(Request $request)
{
    $user   = Auth::user();
    $key    = "cake_drafts_{$user->id}";
    $drafts = Cache::get($key, []);

    $id = $request->input('id');

    $target = collect($drafts)->firstWhere('id', $id);
    if ($target && !empty($target['preview_image'])) {
        $path = str_replace(\Storage::disk('public')->url(''), '', $target['preview_image']);
        \Storage::disk('public')->delete($path);
    }

    $drafts = array_values(array_filter($drafts, fn($d) => ($d['id'] ?? null) !== $id));

    Cache::put($key, $drafts, now()->addDays(30));

    return redirect()->route('customer.cake-builder.drafts')
        ->with('success', 'Draft discarded.');
}

}