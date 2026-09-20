<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    const STATUSES = ['draft', 'coming_soon', 'active', 'inactive'];
    const COMPONENT_TYPES = ['model_based', 'material_based'];
    const PLACEMENTS = ['top_center', 'top_left', 'top_right', 'front_center', 'side_left', 'side_right', 'base'];
    const CATEGORIES = ['cake_type', 'shape', 'flavor', 'filling', 'cake_style', 'base_icing', 'texture', 'drip', 'fruit', 'choco', 'sprinkle', 'candle', 'deco'];

      protected $fillable = [
        'name', 'emoji', 'category', 'price', 'price_two_tier', 'price_three_tier',
        'price_unit', 'description',
        'status', 'component_type', 'model_path', 'thumbnail_path', 'placement',
        'is_active',
    ];
        protected $casts = [
        'price'            => 'decimal:2',
        'price_two_tier'   => 'decimal:2',
        'price_three_tier' => 'decimal:2',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredient', 'ingredient_id', 'product_id');
    }

    /** What the customer Cake Builder should query for. */
    public function scopeSelectable($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeComingSoon($query)
    {
        return $query->where('status', 'coming_soon');
    }
}