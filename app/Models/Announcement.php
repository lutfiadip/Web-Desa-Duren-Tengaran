<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'document_file',
        'is_active',
        'is_alert',
        'expired_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_alert' => 'boolean',
        'expired_at' => 'date',
    ];

    /**
     * Scope for active announcements (not expired and is_active is true)
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>=', now()->toDateString());
            });
    }
}
