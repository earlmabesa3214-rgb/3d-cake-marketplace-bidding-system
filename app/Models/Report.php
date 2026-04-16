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
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
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
}