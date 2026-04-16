<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'is_active',
        'ingredient_ids',
    ];

    protected $casts = [
        'ingredient_ids' => 'array',
        'is_active'      => 'boolean',
        'base_price'     => 'decimal:2',
    ];
}