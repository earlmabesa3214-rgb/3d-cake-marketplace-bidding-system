<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    protected $fillable = [
        'user_id', 'balance', 'total_deposited', 'total_spent',
        'total_earned', 'total_withdrawn', 'status',
    ];

    protected $casts = [
        'balance'          => 'decimal:2',
        'total_deposited'  => 'decimal:2',
        'total_spent'      => 'decimal:2',
        'total_earned'     => 'decimal:2',
        'total_withdrawn'  => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public static function forUser(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0, 'total_deposited' => 0, 'total_spent' => 0,
             'total_earned' => 0, 'total_withdrawn' => 0, 'status' => 'active']
        );
    }

    public function hasEnough(float $amount): bool
    {
        return $this->balance >= $amount;
    }

    /**
     * Deduct from balance and record transaction.
     * Used when holding funds in escrow.
     */
    public function holdForEscrow(float $amount, int $orderId, string $description): WalletTransaction
    {
        if (!$this->hasEnough($amount)) {
            throw new \Exception('Insufficient wallet balance. Please top up first.');
        }

        return DB::transaction(function () use ($amount, $orderId, $description) {
            $before = $this->balance;
            $this->decrement('balance', $amount);
            $this->increment('total_spent', $amount);
            $this->refresh();

            return WalletTransaction::create([
                'wallet_id'        => $this->id,
                'type'             => 'escrow_hold',
                'amount'           => $amount,
                'balance_before'   => $before,
                'balance_after'    => $this->balance,
                'description'      => $description,
                'related_order_id' => $orderId,
                'status'           => 'completed',
            ]);
        });
    }

    /**
     * Add to balance. Used when receiving escrow release or cash-in.
     */
    public function credit(float $amount, string $type, string $description, ?int $orderId = null): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $type, $description, $orderId) {
            $before = $this->balance;
            $this->increment('balance', $amount);

            if ($type === 'deposit' || $type === 'cashin') {
                $this->increment('total_deposited', $amount);
            } elseif ($type === 'escrow_release') {
                $this->increment('total_earned', $amount);
            }

            $this->refresh();

            return WalletTransaction::create([
                'wallet_id'        => $this->id,
                'type'             => $type,
                'amount'           => $amount,
                'balance_before'   => $before,
                'balance_after'    => $this->balance,
                'description'      => $description,
                'related_order_id' => $orderId,
                'status'           => 'completed',
            ]);
        });
    }

    /**
     * Deduct for withdrawal.
     */
    public function debit(float $amount, string $description): WalletTransaction
    {
        if (!$this->hasEnough($amount)) {
            throw new \Exception('Insufficient wallet balance.');
        }

        return DB::transaction(function () use ($amount, $description) {
            $before = $this->balance;
            $this->decrement('balance', $amount);
            $this->increment('total_withdrawn', $amount);
            $this->refresh();

            return WalletTransaction::create([
                'wallet_id'      => $this->id,
                'type'           => 'withdrawal',
                'amount'         => $amount,
                'balance_before' => $before,
                'balance_after'  => $this->balance,
                'description'    => $description,
                'status'         => 'completed',
            ]);
        });
    }
}