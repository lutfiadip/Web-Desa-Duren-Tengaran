<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemographicStatistic extends Model
{
    protected $fillable = [
        'period_id',
        'label',
        'male_count',
        'female_count',
    ];
}
