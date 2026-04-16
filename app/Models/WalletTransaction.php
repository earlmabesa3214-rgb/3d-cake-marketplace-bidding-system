<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id', 'type', 'amount', 'balance_before', 'balance_after',
        'reference_code', 'description', 'related_order_id',
        'related_payment_id', 'status',
    ];

    protected $casts = ['amount' => 'decimal:2'];

    public function wallet() { return $this->belongsTo(Wallet::class); }

    public function typeLabel(): string
    {
        return match($this->type) {
            'cashin'          => '💳 Cash In',
            'deposit'         => '💰 Deposit',
            'escrow_hold'     => '🔒 Payment Held',
            'escrow_release'  => '✅ Payment Released',
            'escrow_refund'   => '↩️ Refunded',
            'withdrawal'      => '📤 Withdrawal',
            'fee'             => '⚙️ Platform Fee',
            default           => ucfirst($this->type),
        };
    }

    public function isCredit(): bool
    {
        return in_array($this->type, ['cashin', 'deposit', 'escrow_release', 'escrow_refund']);
    }
}