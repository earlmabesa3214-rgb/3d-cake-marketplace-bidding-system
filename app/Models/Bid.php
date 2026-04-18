<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'baker_id',
        'cake_request_id',
      'amount',
        'rush_fee',
        'estimated_days',
        'message',
        'status',   // PENDING | ACCEPTED | REJECTED | WITHDRAWN
    ];   

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function baker()
    {
        return $this->belongsTo(User::class, 'baker_id');
    }

    public function cakeRequest()
    {
        return $this->belongsTo(CakeRequest::class);
    }

    public function bakerOrder()
    {
        return $this->hasOne(BakerOrder::class);
    }
}