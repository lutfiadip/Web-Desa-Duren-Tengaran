<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PopulationStatisticDetail extends Model
{
    protected $guarded = [];

    public function statistic(): BelongsTo
    {
        return $this->belongsTo(PopulationStatistic::class, 'statistic_id');
    }
}
