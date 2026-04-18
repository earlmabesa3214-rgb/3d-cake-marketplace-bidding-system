<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CakeRequest extends Model
{
    use HasFactory;

protected $fillable = [
        'user_id',
        'address_id',
        'cake_configuration',
        'custom_message',
        'reference_image',
        'budget_min',
        'budget_max',
        'delivery_date',
        'needed_time',
        'delivery_lat',
        'delivery_lng',
        'delivery_address',
        'special_instructions',
        'status',
        'is_rush',
        'rush_fee',
        'rush_auto_price',
        'rush_expires_at',
        'fulfillment_type',
        'cake_preview_image',
    ];
protected $casts = [
        'cake_configuration' => 'array',
        'delivery_date'      => 'date',
        'needed_time'        => 'string',
        'budget_min'         => 'decimal:2',
        'budget_max'         => 'decimal:2',
        'delivery_lat'       => 'float',
        'delivery_lng'       => 'float',
        'is_rush'            => 'boolean',
        'rush_expires_at'    => 'datetime',
    ];
    public function isPickup(): bool
    {
        return $this->fulfillment_type === 'pickup';
    }

    public function isDelivery(): bool
    {
        return $this->fulfillment_type !== 'pickup';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function bakerOrder()
    {
        return $this->hasOne(BakerOrder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'cake_request_id');
    }

    public function getReferenceImageUrlAttribute(): ?string
    {
        return $this->reference_image
            ? asset('storage/' . $this->reference_image)
            : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'RUSH_MATCHING'          => '⚡ Rush — Matching Baker',
            'OPEN'                   => '🟡 Waiting for Bakers',
            'BIDDING'                => '🔵 Bidding Ongoing',
            'ACCEPTED'               => '🟢 Accepted',
            'WAITING_FOR_PAYMENT'    => ' Awaiting Downpayment',
            'IN_PROGRESS'            => '🔵 In Progress',
            'WAITING_FINAL_PAYMENT'  => ' Awaiting Final Payment',
            'COMPLETED'              => '🟢 Completed',
            'CANCELLED'              => '🔴 Cancelled',
            'EXPIRED'                => '🔴 Expired',
            default                  => $this->status,
        };
    }

    public function getFulfillmentLabelAttribute(): string
    {
        return $this->fulfillment_type === 'pickup' ? '🏪 Pickup' : '🚚 Delivery';
    }

    public function hasMapLocation(): bool
    {
        return !is_null($this->delivery_lat) && !is_null($this->delivery_lng);
    }
}