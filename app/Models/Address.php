<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'house_unit_no',
        'street',
        'barangay',
        'city',
        'province',
        'zip_code',
        'landmark',
        'latitude',
        'longitude',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor: Full address as string
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->house_unit_no,
            $this->street,
            $this->barangay,
            $this->city,
            $this->province,
            $this->zip_code,
        ]);
        return implode(', ', $parts);
    }
}