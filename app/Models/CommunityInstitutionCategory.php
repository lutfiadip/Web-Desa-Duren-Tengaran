<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityInstitutionCategory extends Model
{
    protected $guarded = [];

    public function institutions()
    {
        return $this->hasMany(CommunityInstitution::class, 'category_id');
    }
}
