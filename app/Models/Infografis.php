<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    protected $fillable = ['nama', 'foto'];

    protected $casts = [
        'foto' => 'array',
    ];
}
