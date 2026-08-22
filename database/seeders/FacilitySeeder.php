<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FacilityCategory;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pendidikan',
                'icon' => 'fa-solid fa-school',
                'order' => 1,
                'facilities' => [
                    ['name' => 'PAUD', 'quantity' => 2],
                    ['name' => 'TK / RA', 'quantity' => 1],
                    ['name' => 'SD / MI', 'quantity' => 2],
                    ['name' => 'SMP / MTs', 'quantity' => 1],
                ]
            ],
            [
                'name' => 'Kesehatan',
                'icon' => 'fa-solid fa-hospital',
                'order' => 2,
                'facilities' => [
                    ['name' => 'Puskesmas Pembantu', 'quantity' => 1],
                    ['name' => 'Posyandu', 'quantity' => 5],
                    ['name' => 'Bidan Desa', 'quantity' => 1],
                ]
            ],
            [
                'name' => 'Keagamaan',
                'icon' => 'fa-solid fa-mosque',
                'order' => 3,
                'facilities' => [
                    ['name' => 'Masjid', 'quantity' => 6],
                    ['name' => 'Mushola / Surau', 'quantity' => 12],
                ]
            ],
            [
                'name' => 'Umum',
                'icon' => 'fa-solid fa-building',
                'order' => 4,
                'facilities' => [
                    ['name' => 'Balai Desa', 'quantity' => 1],
                    ['name' => 'Gedung Olahraga', 'quantity' => 1],
                    ['name' => 'Pasar Desa', 'quantity' => 0],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = FacilityCategory::create([
                'name' => $categoryData['name'],
                'icon' => $categoryData['icon'],
                'order' => $categoryData['order'],
            ]);

            foreach ($categoryData['facilities'] as $index => $facilityData) {
                Facility::create([
                    'category_id' => $category->id,
                    'name' => $facilityData['name'],
                    'quantity' => $facilityData['quantity'],
                    'order' => $index + 1,
                ]);
            }
        }
    }
}
