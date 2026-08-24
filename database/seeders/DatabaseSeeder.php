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
            AdminUserSeeder::class,
            VillageProfileSeeder::class,
            HeroSectionSeeder::class,
            OfficialCategorySeeder::class,
            OfficialSeeder::class,
            DemographicCategorySeeder::class,
            DemographicStatisticSeeder::class,
            FacilitySeeder::class,
            DemographicSeeder::class,
            UmkmSeeder::class,
            NewsSeeder::class,
            GallerySeeder::class,
            AgricultureSeeder::class,
            AgricultureCommoditySeeder::class,
            CommunityInstitutionSeeder::class,
            PopulationStatisticSeeder::class,
            TransparencySeeder::class,
        ]);
    }
}
