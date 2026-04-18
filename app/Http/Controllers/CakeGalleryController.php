<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CakeRequest;
use App\Models\Baker;
use App\Models\BakerReview;

class CakeGalleryController extends Controller
{
    public function index(Request $request)
    {
        // ── Trending: most ordered cake configurations ──
        $trending = CakeRequest::whereNotNull('cake_configuration')
            ->whereIn('status', ['COMPLETED', 'IN_PROGRESS', 'WAITING_FINAL_PAYMENT'])
            ->get()
            ->groupBy(function ($r) {
                $config = is_array($r->cake_configuration)
                    ? $r->cake_configuration
                    : (json_decode($r->cake_configuration, true) ?? []);
                return ($config['flavor'] ?? 'Unknown') . '|' . ($config['frosting'] ?? '') . '|' . ($config['size'] ?? '');
            })
            ->map(fn($group) => [
                'config'    => is_array($group->first()->cake_configuration)
                    ? $group->first()->cake_configuration
                    : (json_decode($group->first()->cake_configuration, true) ?? []),
                'count'     => $group->count(),
                'image'     => $group->first()->cake_preview_image,
                'min_price' => $group->min('budget_min'),
                'max_price' => $group->max('budget_max'),
            ])
            ->sortByDesc('count')
            ->take(6)
            ->values();

        // ── Budget tiers ──
        $budgetTiers = [
            ['label' => 'Under ₱500',       'min' => 0,    'max' => 500,  'icon' => '💚'],
            ['label' => '₱500 – ₱1,000',    'min' => 500,  'max' => 1000, 'icon' => '💛'],
            ['label' => '₱1,000 – ₱2,000',  'min' => 1000, 'max' => 2000, 'icon' => '🧡'],
            ['label' => 'Premium ₱2,000+',   'min' => 2000, 'max' => 9999, 'icon' => '❤️'],
        ];

        // ── Occasions ──
        $occasions = [
            ['label' => 'Birthday',     'icon' => '🎂', 'keywords' => ['birthday', 'birth']],
            ['label' => 'Wedding',      'icon' => '💍', 'keywords' => ['wedding', 'bridal']],
            ['label' => 'Anniversary',  'icon' => '💕', 'keywords' => ['anniversary']],
            ['label' => 'Graduation',   'icon' => '🎓', 'keywords' => ['graduation', 'grad']],
            ['label' => 'Christmas',    'icon' => '🎄', 'keywords' => ['christmas', 'noel']],
            ['label' => 'Baby Shower',  'icon' => '🍼', 'keywords' => ['baby', 'shower']],
        ];

        // ── Baker showcase: top rated bakers with completed orders ──
        $topBakers = Baker::where('status', 'approved')
            ->where('is_available', true)
            ->whereHas('user.bakerOrders', fn($q) => $q->where('status', 'COMPLETED'))
            ->with('user')
            ->get()
            ->map(function ($baker) {
                $reviewCount = BakerReview::where('baker_user_id', $baker->user_id)->count();
                $avgRating   = BakerReview::where('baker_user_id', $baker->user_id)->avg('rating');
                $completedCount = $baker->user->bakerOrders()->where('status', 'COMPLETED')->count();
                $samplePhoto = $baker->user->bakerOrders()
                    ->where('status', 'COMPLETED')
                    ->whereNotNull('cake_final_photo')
                    ->latest()
                    ->first()?->cake_final_photo;

                return [
                    'baker'          => $baker,
                    'user'           => $baker->user,
                    'avg_rating'     => $avgRating ? round($avgRating, 1) : null,
                    'review_count'   => $reviewCount,
                    'completed'      => $completedCount,
                    'sample_photo'   => $samplePhoto,
                ];
            })
            ->filter(fn($b) => $b['completed'] > 0)
            ->sortByDesc('avg_rating')
            ->take(6)
            ->values();

        // ── Customizable templates (preset configs) ──
        $templates = [
            ['name' => 'Classic Vanilla', 'size' => '8"', 'flavor' => 'Vanilla',   'frosting' => 'Buttercream', 'icon' => '🤍', 'tag' => 'Most Popular'],
            ['name' => 'Chocolate Dream', 'size' => '8"', 'flavor' => 'Chocolate', 'frosting' => 'Fondant',     'icon' => '🍫', 'tag' => 'Fan Favorite'],
            ['name' => 'Red Velvet Love', 'size' => '6"', 'flavor' => 'Red Velvet','frosting' => 'Buttercream', 'icon' => '❤️', 'tag' => 'Romantic'],
            ['name' => 'Ube Delight',     'size' => '8"', 'flavor' => 'Ube',       'frosting' => 'Whipped Cream','icon' => '💜', 'tag' => 'Filipino Fave'],
            ['name' => 'Strawberry Bliss','size' => '6"', 'flavor' => 'Strawberry','frosting' => 'Mirror Glaze','icon' => '🍓', 'tag' => 'Fruity'],
            ['name' => 'Grand Chocolate', 'size' => '12"','flavor' => 'Chocolate', 'frosting' => 'Mirror Glaze','icon' => '🎯', 'tag' => 'Grand Celebration'],
        ];

        // ── Selected budget filter ──
        $selectedBudget = $request->query('budget');
        $selectedTier   = collect($budgetTiers)->firstWhere('label', $selectedBudget);

        // ── Recent completed cakes (for gallery feed) ──
        $recentCakes = CakeRequest::where('status', 'COMPLETED')
            ->whereNotNull('cake_preview_image')
            ->latest()
            ->take(12)
            ->get();

        return view('customer.cake-gallery.index', compact(
            'trending', 'budgetTiers', 'occasions', 'topBakers',
            'templates', 'selectedBudget', 'selectedTier', 'recentCakes'
        ));
    }
}