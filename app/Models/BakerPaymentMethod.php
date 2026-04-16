<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BakerPaymentMethod extends Model
{
    protected $fillable = [
        'baker_id', 'type', 'account_name', 'account_number',
        'qr_code_path', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function baker(): BelongsTo
    {
        return $this->belongsTo(Baker::class);
    }

    public function getQrCodeUrlAttribute(): ?string
    {
        return $this->qr_code_path ? Storage::url($this->qr_code_path) : null;
    }

    public function getLabelAttribute(): string
    {
        return match($this->type) {
            'gcash' => 'GCash',
            'maya'  => 'Maya',
            'cash'  => 'Cash on Delivery',
            default => ucfirst($this->type),
        };
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'gcash' => '📱',
            'maya'  => '💜',
            'cash'  => '💵',
            default => '💳',
        };
    }
}