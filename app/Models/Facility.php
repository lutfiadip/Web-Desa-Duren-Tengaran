<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'quantity', 'description', 'order'];

    public function category()
    {
        return $this->belongsTo(FacilityCategory::class, 'category_id');
    }
}
