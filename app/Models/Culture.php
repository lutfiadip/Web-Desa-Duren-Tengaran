<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Culture extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function getCleanContactAttribute()
    {
        if (empty($this->contact)) return '';
        $wa = preg_replace('/[^0-9]/', '', $this->contact);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        return $wa;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
