<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgricultureCommodity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function commodityCategory()
    {
        return $this->belongsTo(CommodityCategory::class, 'category_id');
    }

    public function getCategoryAttribute()
    {
        return $this->commodityCategory?->name ?? '';
    }
}
