<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'revenue_target',
        'revenue_realization',
        'spending_target',
        'spending_realization',
        'financing_target',
        'financing_realization',
        'apbdes_poster',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'revenue_target' => 'decimal:2',
        'revenue_realization' => 'decimal:2',
        'spending_target' => 'decimal:2',
        'spending_realization' => 'decimal:2',
        'financing_target' => 'decimal:2',
        'financing_realization' => 'decimal:2',
    ];

    public function documents()
    {
        return $query = $this->hasMany(FinanceDocument::class);
    }
}
