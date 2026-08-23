<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicServiceDocument extends Model
{
    protected $fillable = [
        'public_service_id',
        'file_path',
        'title',
    ];

    public function publicService()
    {
        return $this->belongsTo(PublicService::class);
    }
}
