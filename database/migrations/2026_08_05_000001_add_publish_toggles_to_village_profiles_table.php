<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            // Profile page subsections toggles
            $table->boolean('publish_headman_greeting')->default(true);
            $table->boolean('publish_vision_mission')->default(true);
            $table->boolean('publish_history')->default(true);
            $table->boolean('publish_organization_structure')->default(true);
            $table->boolean('publish_geographics')->default(true);

            // General modules toggles
            $table->boolean('publish_about')->default(true);
            $table->boolean('publish_statistics')->default(true);
            $table->boolean('publish_officials')->default(true);
            $table->boolean('publish_regulations')->default(true);
            $table->boolean('publish_news')->default(true);
            $table->boolean('publish_tourism')->default(true);
            $table->boolean('publish_umkm')->default(true);
            $table->boolean('publish_agriculture')->default(true);
            $table->boolean('publish_institutions')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'publish_headman_greeting',
                'publish_vision_mission',
                'publish_history',
                'publish_organization_structure',
                'publish_geographics',
                'publish_about',
                'publish_statistics',
                'publish_officials',
                'publish_regulations',
                'publish_news',
                'publish_tourism',
                'publish_umkm',
                'publish_agriculture',
                'publish_institutions',
            ]);
        });
    }
};
