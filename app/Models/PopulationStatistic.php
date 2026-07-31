<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PopulationStatistic extends Model
{
    protected $guarded = [];

    public function details(): HasMany
    {
        return $this->hasMany(PopulationStatisticDetail::class, 'statistic_id')->orderBy('display_order');
    }
}
