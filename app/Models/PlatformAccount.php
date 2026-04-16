<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformAccount extends Model
{
    protected $fillable = [
        'type', 'account_name', 'account_number', 'qr_code_path', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function active(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('is_active', true)->get();
    }

    public static function byType(string $type): ?self
    {
        return self::where('type', $type)->where('is_active', true)->first();
    }
}