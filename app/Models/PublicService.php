<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicService extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'service_flow',
        'disclaimer',
        'processing_time',
        'service_cost',
        'document_file',
        'icon',
        'is_active',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function documents()
    {
        return $this->hasMany(PublicServiceDocument::class);
    }
}
