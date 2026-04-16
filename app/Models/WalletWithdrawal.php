<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletWithdrawal extends Model
{
    protected $fillable = [
        'user_id', 'wallet_id', 'amount', 'status', 'payment_method',
        'account_name', 'account_number', 'requested_at', 'processed_at',
        'processed_by', 'admin_note',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'amount'       => 'decimal:2',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function wallet() { return $this->belongsTo(Wallet::class); }
}