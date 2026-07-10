<?php

namespace App\Models\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'purpose',
        'code_hash',
        'attempts',
        'max_attempts',
        'expires_at',
        'sent_at',
        'consumed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function scopePending($query)
    {
        return $query->whereNull('consumed_at');
    }

    public function scopePurpose($query, string $purpose)
    {
        return $query->where('purpose', $purpose);
    }

    public function scopePhone($query, string $phone)
    {
        return $query->where('phone_number', $phone);
    }
}
