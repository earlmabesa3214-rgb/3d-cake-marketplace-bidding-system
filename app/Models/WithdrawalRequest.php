<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'baker_id', 'amount', 'status',
        'payment_method', 'account_name', 'account_number',
        'requested_at', 'processed_at', 'admin_note', 'processed_by',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function baker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'baker_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}