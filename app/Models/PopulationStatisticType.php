<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PopulationStatisticType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function statistics(): HasMany
    {
        return $this->hasMany(PopulationStatistic::class, 'statistic_type_id');
    }
}
