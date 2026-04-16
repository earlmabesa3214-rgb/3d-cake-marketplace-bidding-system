<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Baker extends Model
{
protected $fillable = [
    'user_id', 'name', 'email', 'phone', 'address', 'city',
    'specialties', 'status',
    'shop_name', 'experience_years', 'min_order_price', 'social_media',
    'bio', 'seller_type', 'latitude', 'longitude', 'full_address',
    'dti_sec_number', 'business_permit', 'dti_certificate',
    'sanitary_permit', 'bir_certificate', 'gov_id_type',
    'gov_id_front', 'gov_id_back', 'id_selfie', 'food_safety_cert',
    'portfolio', 'is_available', 'is_approved', 'password',
    'accepts_rush_orders', 'rush_fee',
];

protected $casts = [
    'is_available'        => 'boolean',
    'is_approved'         => 'boolean',
    'accepts_rush_orders' => 'boolean',
    'latitude'            => 'decimal:7',
    'longitude'           => 'decimal:7',
];
    /**
     * Always return specialties as an array, regardless of how it's stored.
     */
    public function getSpecialtiesAttribute($value): array
    {
        if (is_array($value)) return $value;
        if (empty($value)) return [];
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) return $decoded;
        return array_filter(array_map('trim', explode(',', $value)));
    }

    public function setSpecialtiesAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['specialties'] = json_encode($value);
        } elseif (is_string($value)) {
            $arr = array_filter(array_map('trim', explode(',', $value)));
            $this->attributes['specialties'] = json_encode(array_values($arr));
        } else {
            $this->attributes['specialties'] = json_encode([]);
        }
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(BakerOrder::class);
    }

  public function paymentMethods(): HasMany
    {
        return $this->hasMany(\App\Models\BakerPaymentMethod::class, 'baker_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(\App\Models\BakerReview::class, 'baker_user_id', 'user_id');
    }

    public function getLiveRatingAttribute(): ?float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round((float) $avg, 1) : null;
    }

    public function getLiveReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}