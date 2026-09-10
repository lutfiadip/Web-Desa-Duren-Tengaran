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

    public function getCleanContactAttribute()
    {
        if (empty($this->contact)) return '';
        $wa = preg_replace('/[^0-9]/', '', $this->contact);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        return $wa;
    }
}
