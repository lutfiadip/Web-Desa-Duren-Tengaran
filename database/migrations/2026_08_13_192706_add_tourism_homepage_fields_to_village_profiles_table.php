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
            $table->boolean('show_tourism_on_home')->default(true)->after('show_umkm_on_home');
            $table->string('tourism_subtitle')->nullable()->after('show_tourism_on_home');
            $table->string('tourism_title')->nullable()->after('tourism_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'show_tourism_on_home',
                'tourism_subtitle',
                'tourism_title'
            ]);
        });
    }
};
