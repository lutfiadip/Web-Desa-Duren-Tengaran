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
            $table->boolean('transparency_show_apbdes')->default(true);
            $table->boolean('transparency_show_budget')->default(true);
            $table->boolean('transparency_show_development')->default(true);
            $table->boolean('transparency_show_asset')->default(true);
            $table->boolean('transparency_show_report')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'transparency_show_apbdes',
                'transparency_show_budget',
                'transparency_show_development',
                'transparency_show_asset',
                'transparency_show_report'
            ]);
        });
    }
};
