<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::saving(function ($news) {
            if (empty($news->excerpt) && !empty($news->content)) {
                $news->excerpt = \Illuminate\Support\Str::limit(strip_tags($news->content), 120);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
}
