<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TouristAttraction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
        'ticket_packages' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
