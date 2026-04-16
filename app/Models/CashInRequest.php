<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashInRequest extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'gcash_reference', 'paymongo_source_id',
        'paymongo_checkout_url', 'proof_path', 'method', 'status',
        'approved_at', 'approved_by', 'reject_reason',
    ];

    protected $casts = ['approved_at' => 'datetime', 'amount' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
}