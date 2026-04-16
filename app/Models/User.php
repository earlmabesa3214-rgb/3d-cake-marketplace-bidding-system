<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'first_name', 'last_name', 'middle_name', 'suffix', 'email', 'phone',
        'birthdate', 'password', 'role', 'profile_photo',
        'is_verified', 'email_verification_token',
        'provider', // 'google' or null
    ];

    protected $hidden = [
        'password', 'remember_token', 'email_verification_token',
    ];

 protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate'         => 'date',
        'is_verified'       => 'boolean',
        'password'          => 'hashed',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────────────────────────

    public function cakeRequests()
    {
        return $this->hasMany(CakeRequest::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function baker()
    {
        return $this->hasOne(Baker::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'baker_id');
    }

   public function bakerOrders()
    {
        return $this->hasMany(BakerOrder::class, 'baker_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function getWalletBalanceAttribute(): float
    {
        return $this->wallet?->balance ?? 0;
    }

    // ── HELPERS ────────────────────────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->unreadNotifications->count();
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo)
            : null;
    }

    // ── ROLE CHECKS ────────────────────────────────────────────────────────────

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isBaker(): bool    { return $this->role === 'baker'; }
}