<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageProfile;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        VillageProfile::create([
            'village_name' => 'Duren',
            'logo' => 'img/logo-semarang.png',
            'headman_name' => 'Bapak Kepala Desa',
            'headman_photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'headman_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya. Selamat datang di Website Resmi Desa Duren Tengaran. Website ini kami hadirkan sebagai bentuk komitmen Pemerintah Desa dalam mewujudkan transparansi informasi, peningkatan pelayanan publik, serta wadah promosi potensi desa kepada masyarakat luas.',
            'address' => 'Kecamatan Tengaran, Kabupaten Semarang',
            'facebook' => '#',
            'instagram' => '#',
            'youtube' => '#'
        ]);
    }
}
