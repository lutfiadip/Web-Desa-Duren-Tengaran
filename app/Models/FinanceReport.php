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
        'revenue_pad',
        'revenue_add',
        'revenue_dd',
        'revenue_pbh',
        'spending_target',
        'spending_realization',
        'spending_pemerintahan',
        'spending_pembangunan',
        'spending_pembinaan',
        'spending_pemberdayaan',
        'spending_penanggulangan',
        'financing_target',
        'financing_realization',
        'apbdes_poster',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'revenue_target' => 'decimal:2',
        'revenue_realization' => 'decimal:2',
        'revenue_pad' => 'decimal:2',
        'revenue_add' => 'decimal:2',
        'revenue_dd' => 'decimal:2',
        'revenue_pbh' => 'decimal:2',
        'spending_target' => 'decimal:2',
        'spending_realization' => 'decimal:2',
        'spending_pemerintahan' => 'decimal:2',
        'spending_pembangunan' => 'decimal:2',
        'spending_pembinaan' => 'decimal:2',
        'spending_pemberdayaan' => 'decimal:2',
        'spending_penanggulangan' => 'decimal:2',
        'financing_target' => 'decimal:2',
        'financing_realization' => 'decimal:2',
    ];

    public function documents()
    {
        return $query = $this->hasMany(FinanceDocument::class);
    }
}
