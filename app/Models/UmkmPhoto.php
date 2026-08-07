<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class UmkmPhoto extends Model
{
    protected $fillable = [
        'umkm_id',
        'photo_path',
        'caption',
        'sort_order',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    protected function photoPath(): Attribute
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
