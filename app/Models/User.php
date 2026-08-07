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
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
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
        if (!$this->photo) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=556B2F&color=fff';
        }
        if (str_starts_with($this->photo, 'http')) {
            return $this->photo;
        }
        return asset('storage/' . $this->photo);
    }
}
