<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'cake_request_id',
        'order_id',
        'bid_id',
        'customer_id',
        'baker_id',
        'payment_type',
        'amount',
        'agreed_price',
        'status',
        'escrow_status',
        'platform_reference',
        'held_at',
        'released_at',
        'refunded_at',
        'payment_method',
        'proof_of_payment_path',
        'paid_at',
        'confirmed_at',
        'paymongo_source_id',
        'paymongo_checkout_url',
        'rejection_reason',
        'rejection_note',
        'rejected_at',
        'rejection_count',
        'reupload_requested_at',
    ];

   protected $casts = [
        'paid_at'               => 'datetime',
        'confirmed_at'          => 'datetime',
        'rejected_at'           => 'datetime',
        'reupload_requested_at' => 'datetime',
        'held_at'               => 'datetime',
        'released_at'           => 'datetime',
        'refunded_at'           => 'datetime',
        'rejection_count'       => 'integer',
    ];

    public const REJECTION_REASONS = [
        'ref_not_found'     => 'Reference number not found',
        'amount_incorrect'  => 'Amount is incorrect',
        'edited_suspicious' => 'Edited / suspicious receipt',
        'wrong_account'     => 'Wrong account used',
        'other'             => 'Other',
    ];

    // ── Helpers ──────────────────────────────────────────────
    public function isPaid(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

   public function shouldAutoCancelOnReject(): bool
    {
        return $this->rejection_count >= 2;
    }

    public function isHeld(): bool
    {
        return $this->escrow_status === 'held';
    }

    public function isReleased(): bool
    {
        return $this->escrow_status === 'released';
    }

    public function markAsHeld(string $reference): void
    {
        $this->update([
            'escrow_status'      => 'held',
            'platform_reference' => $reference,
            'held_at'            => now(),
            'status'             => 'confirmed',
            'confirmed_at'       => now(),
        ]);
    }

    public function getRejectionReasonLabelAttribute(): string
    {
        return self::REJECTION_REASONS[$this->rejection_reason] ?? $this->rejection_reason ?? 'Unknown';
    }

    // ── Relationships ─────────────────────────────────────────
    public function cakeRequest(): BelongsTo
    {
        return $this->belongsTo(CakeRequest::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(BakerOrder::class, 'order_id');
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function baker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'baker_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}