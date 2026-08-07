<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'umkm_id',
        'category_id',
        'name',
        'slug',
        'photo',
        'price',
        'price_unit',
        'description',
        'is_starred',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_starred' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
                $count = static::withTrashed()->where('slug', 'like', $product->slug . '%')->count();
                if ($count > 0) {
                    $product->slug .= '-' . ($count + 1);
                }
            }
        });
    }

    // ==================
    // Relationships
    // ==================

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ==================
    // Scopes
    // ==================

    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    public function scopeSearch($query, ?string $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
    }

    // ==================
    // Accessors
    // ==================

    public function getFormattedPriceAttribute(): ?string
    {
        if (!$this->price) return null;
        $formatted = 'Rp ' . number_format($this->price, 0, ',', '.');
        if ($this->price_unit) {
            $formatted .= ' / ' . $this->price_unit;
        }
        return $formatted;
    }

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                if (!$value) return null;
                if (str_starts_with($value, 'http')) {
                    return $value;
                }
                return asset('storage/' . $value);
            }
        );
    }
}
