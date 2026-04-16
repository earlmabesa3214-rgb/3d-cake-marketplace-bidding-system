<?php
// FILE: app/Models/Ingredient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        // Explicitly name the pivot table to avoid confusion
        return $this->belongsToMany(Product::class, 'product_ingredient', 'ingredient_id', 'product_id');
    }
}