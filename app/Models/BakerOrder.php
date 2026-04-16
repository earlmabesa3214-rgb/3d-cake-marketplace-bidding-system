<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BakerOrder extends Model
{
    use HasFactory;

   protected $fillable = [
    'baker_id',
    'cake_request_id',
    'bid_id',
    'agreed_price',
    'status',
    'completed_at',
    'cancelled_at',
    'cancel_reason',
    'cake_final_photo',
];

    protected $casts = [
        'agreed_price' => 'decimal:2',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function baker()       { return $this->belongsTo(User::class, 'baker_id'); }
    public function cakeRequest() { return $this->belongsTo(CakeRequest::class); }
    public function bid()         { return $this->belongsTo(Bid::class); }
    public function messages()    { return $this->hasMany(OrderMessage::class)->oldest(); }
    public function reports()     { return $this->hasMany(Report::class); }

    public function isCancelled(): bool
    {
        return $this->status === 'CANCELLED';
    }
}