<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'position',
        'photo',
        'nip',
        'status',
        'sort_order',
    ];

    public function category()
    {
        return $this->belongsTo(OfficialCategory::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Official::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Official::class, 'parent_id')->orderBy('sort_order');
    }
}
