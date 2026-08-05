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
            $table->text('map_miri')->nullable();
            $table->text('map_dukuh')->nullable();
            $table->text('map_krajan')->nullable();
            $table->text('map_babadan')->nullable();
            $table->text('map_ngepringan')->nullable();
            $table->text('map_tanubayu')->nullable();
            $table->text('map_gading')->nullable();
            $table->text('map_karangwuni')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'map_miri',
                'map_dukuh',
                'map_krajan',
                'map_babadan',
                'map_ngepringan',
                'map_tanubayu',
                'map_gading',
                'map_karangwuni'
            ]);
        });
    }
};
