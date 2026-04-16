<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BakerReview extends Model
{
    protected $fillable = [
        'baker_user_id',
        'customer_id',
        'baker_order_id',
        'rating',
        'comment',
    ];

    public function baker()
    {
        return $this->belongsTo(User::class, 'baker_user_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

 public function bakerOrder()
    {
        return $this->belongsTo(BakerOrder::class, 'baker_order_id');
    }

    protected static function booted()
    {
        static::saved(function ($review) {
            static::recalculateBakerStats($review->baker_user_id);
        });

        static::deleted(function ($review) {
            static::recalculateBakerStats($review->baker_user_id);
        });
    }

    protected static function recalculateBakerStats($bakerUserId)
    {
        $baker = \App\Models\Baker::where('user_id', $bakerUserId)->first();
        if (!$baker) return;

        $count = static::where('baker_user_id', $bakerUserId)->count();
        $avg   = static::where('baker_user_id', $bakerUserId)->avg('rating');

        $baker->total_reviews = $count;
        $baker->rating        = $avg ? round($avg, 1) : null;
        $baker->save();
    }
}