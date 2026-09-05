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
    $pickupIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/><path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4"/><path d="M9 14h6"/></svg>';
    $deliveryIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>';

    return $this->fulfillment_type === 'pickup'
        ? $pickupIcon . 'Pickup'
        : $deliveryIcon . 'Delivery';
}

    public function hasMapLocation(): bool
    {
        return !is_null($this->delivery_lat) && !is_null($this->delivery_lng);
    }
}