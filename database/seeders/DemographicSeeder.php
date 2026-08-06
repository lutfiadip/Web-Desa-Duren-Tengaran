<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DemographicStatistic;
use App\Models\DemographicCategory;
use App\Models\DemographicPeriod;

class DemographicSeeder extends Seeder
{
    public function run(): void
    {
        $period = DemographicPeriod::create([
            'year' => 2025,
            'semester' => 2,
            'is_active' => true
        ]);

        $category = DemographicCategory::create([
            'name' => 'Umum',
            'slug' => 'umum'
        ]);

        // Total Penduduk (gabungan dari male_count dan female_count)
        DemographicStatistic::create([
            'period_id' => $period->id,
            'category_id' => $category->id,
            'label' => 'Total Penduduk',
            'male_count' => 1200,
            'female_count' => 1250, // Total = 2450
        ]);

        DemographicStatistic::create([
            'period_id' => $period->id,
            'category_id' => $category->id,
            'label' => 'Rukun Tetangga',
            'male_count' => 32, // Menyimpan 32 disini
            'female_count' => 0,
        ]);

        DemographicStatistic::create([
            'period_id' => $period->id,
            'category_id' => $category->id,
            'label' => 'Rukun Warga',
            'male_count' => 7,
            'female_count' => 0,
        ]);

        DemographicStatistic::create([
            'period_id' => $period->id,
            'category_id' => $category->id,
            'label' => 'Luas Wilayah',
            'male_count' => 350,
            'female_count' => 0,
        ]);
    }
}
