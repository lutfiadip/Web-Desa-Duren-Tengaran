<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityInstitutionMember extends Model
{
    protected $guarded = [];

    public function institution()
    {
        return $this->belongsTo(CommunityInstitution::class, 'institution_id');
    }
}
