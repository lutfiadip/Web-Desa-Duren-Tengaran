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
        'document_file',
        'icon',
        'is_active',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
