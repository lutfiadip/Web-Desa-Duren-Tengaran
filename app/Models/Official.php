<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'position',
        'photo',
        'nip',
        'status',
        'sort_order',
    ];

    public function category()
    {
        return $this->belongsTo(OfficialCategory::class, 'category_id');
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

    public function parent()
    {
        return $this->belongsTo(Official::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Official::class, 'parent_id')->orderBy('sort_order');
    }
}
