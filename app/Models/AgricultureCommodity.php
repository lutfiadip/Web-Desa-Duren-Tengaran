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

    public function getCleanContactAttribute()
    {
        if (empty($this->contact)) return '';
        $wa = preg_replace('/[^0-9]/', '', $this->contact);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        return $wa;
    }
}
