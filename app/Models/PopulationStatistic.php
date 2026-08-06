<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PopulationStatistic extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PopulationStatisticType::class, 'statistic_type_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PopulationStatisticDetail::class, 'statistic_id')->orderBy('display_order');
    }
}
