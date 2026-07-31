<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PopulationStatistic;
use App\Models\PopulationStatisticDetail;

class PopulationStatisticSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jenis Kelamin
        $gender = PopulationStatistic::create([
            'type' => 'gender',
            'semester' => 2,
            'year' => 2025,
            'source' => 'DKB Semester II Tahun 2025',
        ]);

        PopulationStatisticDetail::create([
            'statistic_id' => $gender->id,
            'label' => 'Total Penduduk',
            'male_total' => 2751,
            'female_total' => 2692,
            'percentage' => 100.00,
            'display_order' => 1,
        ]);

        // 2. Kelompok Umur
        $age = PopulationStatistic::create([
            'type' => 'age',
            'semester' => 2,
            'year' => 2025,
            'source' => 'DKB Semester II Tahun 2025',
        ]);

        $ageGroups = [
            ['0-4', 175, 161, 6.17],
            ['5-9', 226, 195, 7.73],
            ['10-14', 200, 187, 7.11],
            ['15-19', 215, 190, 7.44],
            ['20-24', 230, 210, 8.08],
            ['25-29', 210, 198, 7.49],
            ['30-34', 195, 192, 7.11],
            ['35-39', 205, 185, 7.17],
            ['40-44', 180, 178, 6.58],
            ['45-49', 170, 172, 6.28],
            ['50-54', 160, 155, 5.79],
            ['55-59', 145, 140, 5.24],
            ['60-64', 120, 130, 4.59],
            ['65-69', 95, 105, 3.67],
            ['70-74', 70, 80, 2.76],
            ['75+', 55, 64, 2.19],
        ];

        foreach ($ageGroups as $index => $group) {
            PopulationStatisticDetail::create([
                'statistic_id' => $age->id,
                'label' => $group[0],
                'male_total' => $group[1],
                'female_total' => $group[2],
                'percentage' => $group[3],
                'display_order' => $index + 1,
            ]);
        }

        // 3. Kepemilikan KK
        $kk = PopulationStatistic::create([
            'type' => 'family_card',
            'semester' => 2,
            'year' => 2025,
            'source' => 'DKB Semester II Tahun 2025',
        ]);

        PopulationStatisticDetail::create([
            'statistic_id' => $kk->id,
            'label' => 'Sudah Memiliki KK',
            'male_total' => 1561,
            'female_total' => 323,
            'percentage' => 82.85,
            'display_order' => 1,
        ]);

        PopulationStatisticDetail::create([
            'statistic_id' => $kk->id,
            'label' => 'Belum Memiliki KK',
            'male_total' => 250,
            'female_total' => 140,
            'percentage' => 17.15,
            'display_order' => 2,
        ]);
    }
}
