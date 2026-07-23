<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function officials()
    {
        return $this->hasMany(Official::class, 'category_id')->orderBy('sort_order');
    }
}
