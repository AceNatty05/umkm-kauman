<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'phone',
        'code',
        'type',
        'attempts',
        'expires_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    public function hasExceededAttempts(): bool
    {
        return $this->attempts >= config('otp.max_attempts', 5);
    }

    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }
}
