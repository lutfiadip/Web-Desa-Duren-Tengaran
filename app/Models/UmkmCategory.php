<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmCategory extends Model
{
    protected $guarded = [];

    public function umkms()
    {
        return $this->hasMany(Umkm::class, 'category_id');
    }
}
