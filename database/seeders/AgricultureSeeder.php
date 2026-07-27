<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgricultureProfile;
use App\Models\LandStatistic;
use App\Models\FarmerGroup;
use Illuminate\Support\Facades\Schema;

class AgricultureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AgricultureProfile::truncate();
        LandStatistic::truncate();
        FarmerGroup::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Agriculture Profile
        AgricultureProfile::create([
            'title' => 'Pertanian & Peternakan',
            'subtitle' => 'Menjelajahi potensi agraris dan kelimpahan sumber daya pangan lokal di Desa Duren, Kecamatan Tengaran',
            'description_1' => 'Desa Duren terletak di kawasan perbukitan lereng Gunung Merbabu yang subur. Letak geografis dengan ketinggian yang ideal, curah hujan yang cukup, dan struktur tanah vulkanis yang kaya hara menjadikan sektor pertanian dan peternakan sebagai tulang penggerek perekonomian utama warga desa. Sebagian besar warga desa berprofesi sebagai petani lahan basah, petani hortikultura, serta peternak sapi perah mandiri.',
            'description_2' => 'Pemerintah Desa Duren berkomitmen penuh untuk mendorong produktivitas pangan lokal melalui modernisasi alat pertanian, peningkatan jaringan irigasi sawah, pemanfaatan pupuk organik ramah lingkungan, serta pembinaan intensif kelompok ternak sapi demi melestarikan swasembada pangan desa dan meningkatkan kesejahteraan hidup petani.',
            'hero_image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
        ]);

        // 2. Seed Land Statistics
        LandStatistic::create([
            'label' => 'Sawah Irigasi',
            'area' => 45,
            'unit' => 'Ha',
            'icon' => 'fa-water',
            'sort_order' => 1,
        ]);

        LandStatistic::create([
            'label' => 'Sawah Tadah Hujan',
            'area' => 30,
            'unit' => 'Ha',
            'icon' => 'fa-cloud-sun-rain',
            'sort_order' => 2,
        ]);

        LandStatistic::create([
            'label' => 'Tegalan & Kebun',
            'area' => 65,
            'unit' => 'Ha',
            'icon' => 'fa-tree',
            'sort_order' => 3,
        ]);

        LandStatistic::create([
            'label' => 'Hutan Rakyat',
            'area' => 25,
            'unit' => 'Ha',
            'icon' => 'fa-mountain',
            'sort_order' => 4,
        ]);

        // 3. Seed Farmer Groups
        FarmerGroup::create([
            'name' => 'Tani Mulyo I',
            'sector' => 'Tanaman Pangan & Hortikultura',
            'dusun' => 'Dusun Krajan',
            'is_active' => true,
        ]);

        FarmerGroup::create([
            'name' => 'Tani Mulyo II',
            'sector' => 'Tanaman Pangan & Irigasi',
            'dusun' => 'Dusun Miri',
            'is_active' => true,
        ]);

        FarmerGroup::create([
            'name' => 'Maju Rukun',
            'sector' => 'Perkebunan Kopi & Cengkeh',
            'dusun' => 'Dusun Karangwuni',
            'is_active' => true,
        ]);

        FarmerGroup::create([
            'name' => 'Susu Makmur',
            'sector' => 'Peternakan Sapi Perah',
            'dusun' => 'Dusun Babadan',
            'is_active' => true,
        ]);

        FarmerGroup::create([
            'name' => 'Wana Lestari',
            'sector' => 'Hutan Rakyat & Lebah Madu',
            'dusun' => 'Dusun Duren',
            'is_active' => true,
        ]);
    }
}
