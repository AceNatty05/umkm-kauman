<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ==================
    // Relationships
    // ==================

    public function umkms()
    {
        return $this->hasMany(Umkm::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
