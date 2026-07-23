<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan',
        'kabupaten',
        'provinsi',
        'zip_code',
        'dusun_count',
        'rt_count',
        'rw_count',
    ];
}
