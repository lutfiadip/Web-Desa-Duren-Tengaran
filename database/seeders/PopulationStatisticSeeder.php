<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PopulationStatistic;
use App\Models\PopulationStatisticDetail;
use App\Models\PopulationStatisticType;

class PopulationStatisticSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Population Statistic Types
        $familyCardType = PopulationStatisticType::create([
            'name' => 'Kepemilikan KK',
            'slug' => 'family_card',
            'description' => 'Status kepemilikan Kartu Keluarga warga Desa Duren.',
            'display_order' => 1,
            'is_active' => true,
        ]);

        $genderType = PopulationStatisticType::create([
            'name' => 'Jenis Kelamin',
            'slug' => 'gender',
            'description' => 'Total penduduk laki-laki dan perempuan Desa Duren.',
            'display_order' => 2,
            'is_active' => true,
        ]);

        $ageType = PopulationStatisticType::create([
            'name' => 'Kelompok Umur',
            'slug' => 'age',
            'description' => 'Pembagian rentang umur warga Desa Duren.',
            'display_order' => 3,
            'is_active' => true,
        ]);

        $religionType = PopulationStatisticType::create([
            'name' => 'Agama',
            'slug' => 'religion',
            'description' => 'Penyebaran keyakinan/agama warga Desa Duren.',
            'display_order' => 4,
            'is_active' => false,
        ]);

        $educationType = PopulationStatisticType::create([
            'name' => 'Pendidikan',
            'slug' => 'education',
            'description' => 'Tingkat pendidikan terakhir warga Desa Duren.',
            'display_order' => 5,
            'is_active' => false,
        ]);

        $occupationType = PopulationStatisticType::create([
            'name' => 'Pekerjaan',
            'slug' => 'occupation',
            'description' => 'Mata pencaharian warga Desa Duren.',
            'display_order' => 6,
            'is_active' => false,
        ]);

        // 2. Seed Jenis Kelamin Data
        $gender = PopulationStatistic::create([
            'statistic_type_id' => $genderType->id,
            'semester' => 2,
            'year' => 2025,
            'source' => 'DKB Semester II Tahun 2025',
            'is_published' => true,
            'published_at' => now(),
        ]);

        PopulationStatisticDetail::create([
            'statistic_id' => $gender->id,
            'label' => 'Total Penduduk',
            'male_total' => 2751,
            'female_total' => 2692,
            'display_order' => 1,
        ]);

        // 3. Seed Kelompok Umur Data
        $age = PopulationStatistic::create([
            'statistic_type_id' => $ageType->id,
            'semester' => 2,
            'year' => 2025,
            'source' => 'DKB Semester II Tahun 2025',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $ageGroups = [
            ['0-4', 175, 161],
            ['5-9', 226, 195],
            ['10-14', 200, 187],
            ['15-19', 215, 190],
            ['20-24', 230, 210],
            ['25-29', 210, 198],
            ['30-34', 195, 192],
            ['35-39', 205, 185],
            ['40-44', 180, 178],
            ['45-49', 170, 172],
            ['50-54', 160, 155],
            ['55-59', 145, 140],
            ['60-64', 120, 130],
            ['65-69', 95, 105],
            ['70-74', 70, 80],
            ['75+', 55, 64],
        ];

        foreach ($ageGroups as $index => $group) {
            PopulationStatisticDetail::create([
                'statistic_id' => $age->id,
                'label' => $group[0],
                'male_total' => $group[1],
                'female_total' => $group[2],
                'display_order' => $index + 1,
            ]);
        }

        // 4. Seed Kepemilikan KK Data
        $kk = PopulationStatistic::create([
            'statistic_type_id' => $familyCardType->id,
            'semester' => 2,
            'year' => 2025,
            'source' => 'DKB Semester II Tahun 2025',
            'is_published' => true,
            'published_at' => now(),
        ]);

        PopulationStatisticDetail::create([
            'statistic_id' => $kk->id,
            'label' => 'Sudah Memiliki KK',
            'male_total' => 1561,
            'female_total' => 323,
            'display_order' => 1,
        ]);

        PopulationStatisticDetail::create([
            'statistic_id' => $kk->id,
            'label' => 'Belum Memiliki KK',
            'male_total' => 250,
            'female_total' => 140,
            'display_order' => 2,
        ]);
    }
}
