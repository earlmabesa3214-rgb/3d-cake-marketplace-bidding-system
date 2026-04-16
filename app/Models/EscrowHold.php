<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowHold extends Model
{
    protected $fillable = [
        'customer_wallet_id', 'baker_wallet_id', 'order_id', 'payment_type',
        'amount', 'platform_fee_rate', 'platform_fee_amount', 'baker_payout_amount',
        'status', 'held_at', 'released_at', 'refunded_at',
    ];

    protected $casts = [
        'held_at'     => 'datetime',
        'released_at' => 'datetime',
        'refunded_at' => 'datetime',
        'amount'      => 'decimal:2',
    ];

    public function order()          { return $this->belongsTo(BakerOrder::class, 'order_id'); }
    public function customerWallet() { return $this->belongsTo(Wallet::class, 'customer_wallet_id'); }
    public function bakerWallet()    { return $this->belongsTo(Wallet::class, 'baker_wallet_id'); }
}