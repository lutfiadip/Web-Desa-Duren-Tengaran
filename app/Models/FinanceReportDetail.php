<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'finance_report_id',
        'type',
        'label',
        'value',
        'display_order',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'display_order' => 'integer',
    ];

    public function report()
    {
        return $this->belongsTo(FinanceReport::class, 'finance_report_id');
    }
}
