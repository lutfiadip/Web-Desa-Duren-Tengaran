<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VillageProfileSeeder::class,
            DemographicSeeder::class,
            UmkmSeeder::class,
            NewsSeeder::class,
            GallerySeeder::class,
            AgricultureSeeder::class,
            AgricultureCommoditySeeder::class,
            CommunityInstitutionSeeder::class,
        ]);
    }
}
