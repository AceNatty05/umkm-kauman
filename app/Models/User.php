<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'photo',
        'role',
        'phone_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'phone_verified' => 'boolean',
        ];
    }

    // ==================
    // Role Helpers
    // ==================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // ==================
    // Relationships
    // ==================

    public function umkms()
    {
        return $this->hasMany(Umkm::class);
    }

    // ==================
    // Accessors
    // ==================

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ?: 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=556B2F&color=fff';
    }
}
