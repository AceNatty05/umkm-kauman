<?php

namespace App\Models;

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
}
