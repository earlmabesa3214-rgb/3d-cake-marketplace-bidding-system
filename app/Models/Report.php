<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
protected $fillable = [
        'reporter_id',
        'reported_id',
        'baker_order_id',
        'reporter_role',
        'category',
        'description',
        'screenshot_path',
        'status',
        'admin_note',
        'reviewed_at',
        'refund_requested',
        'refund_status',
        'refund_amount',
        'refund_note',
        'payment_held',
        'refund_processed_at',
    ];

    const BAKER_CATEGORIES = [
        'no_show'         => '🚫 No-Show / Unresponsive',
        'payment_fraud'   => '💳 Payment Fraud / Fake Receipt',
        'fake_proof'      => '🧾 Fake Proof of Payment',
        'harassment'      => '😡 Harassment / Rude Behavior',
        'order_abandoned' => '📦 Order Abandoned',
        'other'           => '📝 Other',
    ];

    const CUSTOMER_CATEGORIES = [
        'poor_quality'    => '⭐ Poor Quality / Not As Described',
        'no_show'         => '🚫 Baker No-Show / Unresponsive',
        'payment_fraud'   => '💳 Payment Issue',
        'harassment'      => '😡 Harassment / Rude Behavior',
        'order_abandoned' => '📦 Order Abandoned / Not Delivered',
        'other'           => '📝 Other',
    ];

    const CATEGORIES = [
        'payment_fraud'   => '💳 Payment Fraud / Fake Receipt',
        'no_show'         => '🚫 No-Show / Unresponsive',
        'poor_quality'    => '⭐ Poor Quality / Not As Described',
        'harassment'      => '😡 Harassment / Rude Behavior',
        'fake_proof'      => '🧾 Fake Proof of Payment',
        'order_abandoned' => '📦 Order Abandoned',
        'other'           => '📝 Other',
    ];

   const STATUSES = [
        'pending'   => ['label' => 'Pending Review', 'color' => '#9B6A10'],
        'reviewed'  => ['label' => 'Under Review',   'color' => '#1A5A8A'],
        'resolved'  => ['label' => 'Resolved',        'color' => '#166534'],
        'dismissed' => ['label' => 'Dismissed',       'color' => '#6B4A2A'],
    ];

    const REFUND_STATUSES = [
        'pending'  => ['label' => 'Refund Pending',   'color' => '#9B6A10'],
        'on_hold'  => ['label' => 'Payment On Hold',  'color' => '#1A5A8A'],
        'approved' => ['label' => 'Refund Approved',  'color' => '#166534'],
        'rejected' => ['label' => 'Refund Rejected',  'color' => '#8B2A1E'],
    ];

    protected $casts = [
        'reviewed_at'          => 'datetime',
        'refund_processed_at'  => 'datetime',
        'refund_requested'     => 'boolean',
        'payment_held'         => 'boolean',
        'refund_amount'        => 'decimal:2',
    ];

    public function reporter()   { return $this->belongsTo(User::class, 'reporter_id'); }
    public function reported()   { return $this->belongsTo(User::class, 'reported_id'); }
    public function bakerOrder() { return $this->belongsTo(BakerOrder::class); }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? $this->status;
    }

    public function getRefundStatusLabelAttribute(): string
    {
        return self::REFUND_STATUSES[$this->refund_status]['label'] ?? ($this->refund_status ?? '—');
    }

    public function hasActiveRefundRequest(): bool
    {
        return $this->refund_requested && $this->refund_status !== null;
    }
}