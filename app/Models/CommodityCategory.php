<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommodityCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function commodities()
    {
        return $this->hasMany(AgricultureCommodity::class, 'category_id');
    }
}
