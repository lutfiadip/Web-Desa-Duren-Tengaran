<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'finance_report_id',
        'title',
        'file_path',
        'category',
    ];

    public function report()
    {
        return $this->belongsTo(FinanceReport::class, 'finance_report_id');
    }
}
