<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\VillageProfile;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $profile = VillageProfile::first();
        if (!$profile) return;

        Gallery::create([
            'galleryable_type' => VillageProfile::class,
            'galleryable_id' => $profile->id,
            'image' => 'https://images.unsplash.com/photo-1505506874110-6a7a4c9d2433?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'caption' => 'Pemandangan Alam Desa'
        ]);

        Gallery::create([
            'galleryable_type' => VillageProfile::class,
            'galleryable_id' => $profile->id,
            'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'caption' => 'Kegiatan Warga'
        ]);

        Gallery::create([
            'galleryable_type' => VillageProfile::class,
            'galleryable_id' => $profile->id,
            'image' => 'https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'caption' => 'Fasilitas Desa'
        ]);

        Gallery::create([
            'galleryable_type' => VillageProfile::class,
            'galleryable_id' => $profile->id,
            'image' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'caption' => 'Infrastruktur Jalan'
        ]);
    }
}
