<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $catKegiatan = NewsCategory::create(['name' => 'Kegiatan Desa', 'slug' => 'kegiatan-desa']);
        $catPengumuman = NewsCategory::create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);

        News::create([
            'category_id' => $catKegiatan->id,
            'user_id' => $user->id,
            'title' => 'Kerja Bakti Bersih Desa Menyambut Bulan Suci Ramadhan',
            'slug' => Str::slug('Kerja Bakti Bersih Desa Menyambut Bulan Suci Ramadhan'),
            'content' => 'Warga Desa Duren bergotong royong membersihkan lingkungan sekitar balai desa dan jalan utama.',
            'featured_image' => 'https://images.unsplash.com/photo-1594708767771-a7502209ff51?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);

        News::create([
            'category_id' => $catPengumuman->id,
            'user_id' => $user->id,
            'title' => 'Jadwal Penyaluran BLT Dana Desa Tahap III Tahun 2026',
            'slug' => Str::slug('Jadwal Penyaluran BLT Dana Desa Tahap III Tahun 2026'),
            'content' => 'Pemerintah Desa Duren akan melaksanakan penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Tahap III.',
            'featured_image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'status' => 'published',
            'published_at' => now()->subDays(5),
        ]);

        News::create([
            'category_id' => $catKegiatan->id,
            'user_id' => $user->id,
            'title' => 'Pelatihan Kewirausahaan untuk Pelaku UMKM Desa Duren',
            'slug' => Str::slug('Pelatihan Kewirausahaan untuk Pelaku UMKM Desa Duren'),
            'content' => 'Dalam rangka meningkatkan kapasitas pelaku usaha mikro, kecil, dan menengah di desa.',
            'featured_image' => 'https://images.unsplash.com/photo-1556761175-4b46a572b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'status' => 'published',
            'published_at' => now()->subDays(10),
        ]);
    }
}
