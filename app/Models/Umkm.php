<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(UmkmCategory::class, 'category_id');
    }

    public function getInstagramLinkAttribute()
    {
        if (empty($this->instagram)) return '#';
        $ig = trim($this->instagram);
        if (str_starts_with($ig, 'http')) {
            return $ig;
        }
        $ig = ltrim($ig, '@');
        return 'https://instagram.com/' . $ig;
    }

    public function getFacebookLinkAttribute()
    {
        if (empty($this->facebook)) return '#';
        $fb = trim($this->facebook);
        if (str_starts_with($fb, 'http')) {
            return $fb;
        }
        $fb = ltrim($fb, '@');
        return 'https://facebook.com/' . $fb;
    }

    public function getCleanWhatsappAttribute()
    {
        if (empty($this->whatsapp)) return '';
        $wa = preg_replace('/[^0-9]/', '', $this->whatsapp);
        
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        return $wa;
    }
}
