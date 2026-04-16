<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BakerWallet extends Model
{
    protected $fillable = [
        'baker_id', 'balance', 'total_earned', 'total_withdrawn',
    ];

    protected $casts = [
        'balance'          => 'decimal:2',
        'total_earned'     => 'decimal:2',
        'total_withdrawn'  => 'decimal:2',
    ];

    public function baker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'baker_id');
    }

    /**
     * Add funds to wallet (called when order completes).
     */
    public function credit(float $amount): void
    {
        $this->increment('balance', $amount);
        $this->increment('total_earned', $amount);
    }

    /**
     * Deduct funds from wallet (called when withdrawal approved).
     */
    public function debit(float $amount): void
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance.');
        }
        $this->decrement('balance', $amount);
        $this->increment('total_withdrawn', $amount);
    }

    /**
     * Get or create wallet for a baker.
     */
    public static function forBaker(int $bakerId): self
    {
        return self::firstOrCreate(
            ['baker_id' => $bakerId],
            ['balance' => 0, 'total_earned' => 0, 'total_withdrawn' => 0]
        );
    }
}