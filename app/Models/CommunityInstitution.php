<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityInstitution extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CommunityInstitutionCategory::class, 'category_id');
    }

    public function members()
    {
        return $this->hasMany(CommunityInstitutionMember::class, 'institution_id');
    }
}
