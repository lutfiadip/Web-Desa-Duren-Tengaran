<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    protected $guarded = [];

    public function getFacebookLink()
    {
        $val = $this->facebook;
        if (empty($val) || $val === '#') {
            return '#';
        }
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }
        return 'https://facebook.com/' . ltrim($val, '/');
    }

    public function getInstagramLink()
    {
        $val = $this->instagram;
        if (empty($val) || $val === '#') {
            return '#';
        }
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }
        $username = ltrim($val, '@');
        return 'https://instagram.com/' . ltrim($username, '/');
    }

    public function getYoutubeLink()
    {
        $val = $this->youtube;
        if (empty($val) || $val === '#') {
            return '#';
        }
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }
        if (str_starts_with($val, '@')) {
            return 'https://youtube.com/' . $val;
        }
        return 'https://youtube.com/@' . ltrim($val, '/');
    }

    public function getCleanPhoneAttribute()
    {
        if (empty($this->phone)) return '';
        $wa = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        return $wa;
    }
}
