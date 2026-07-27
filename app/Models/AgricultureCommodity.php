<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgricultureCommodity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
    ];
}
