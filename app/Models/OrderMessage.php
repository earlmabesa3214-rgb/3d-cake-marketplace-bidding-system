<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderMessage extends Model
{
    protected $fillable = [
        'baker_order_id',
        'sender_id',
        'body',
        'image_path',   // ← new
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /* ── Relationships ── */

    public function bakerOrder(): BelongsTo
    {
        return $this->belongsTo(BakerOrder::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /* ── Helpers ── */

    public function isPaid(): bool
    {
        return !is_null($this->read_at);
    }
}