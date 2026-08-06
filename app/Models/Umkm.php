<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'photo',
        'owner_name',
        'phone',
        'description',
        'location',
        'operating_hours',
    ];

    protected static function booted(): void
    {
        static::creating(function (Umkm $umkm) {
            if (empty($umkm->slug)) {
                $umkm->slug = Str::slug($umkm->name);
                // Ensure unique slug
                $count = static::withTrashed()->where('slug', 'like', $umkm->slug . '%')->count();
                if ($count > 0) {
                    $umkm->slug .= '-' . ($count + 1);
                }
            }
        });
    }

    // ==================
    // Relationships
    // ==================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function photos()
    {
        return $this->hasMany(UmkmPhoto::class)->orderBy('sort_order');
    }

    // ==================
    // Scopes
    // ==================

    public function scopeSearch($query, ?string $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
    }

    public function scopeByCategory($query, ?int $categoryId)
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    }

    // ==================
    // Accessors
    // ==================

    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->phone) return null;
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return "https://wa.me/{$phone}";
    }
}
