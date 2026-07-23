<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegulationCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function regulations()
    {
        return $this->hasMany(Regulation::class, 'category_id');
    }
}
