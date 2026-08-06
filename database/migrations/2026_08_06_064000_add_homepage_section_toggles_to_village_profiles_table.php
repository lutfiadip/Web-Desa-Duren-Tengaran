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
            $table->boolean('show_potency_on_home')->default(true);
            $table->boolean('show_umkm_on_home')->default(true);
            $table->boolean('show_news_on_home')->default(true);
            $table->boolean('show_gallery_on_home')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'show_potency_on_home',
                'show_umkm_on_home',
                'show_news_on_home',
                'show_gallery_on_home'
            ]);
        });
    }
};
