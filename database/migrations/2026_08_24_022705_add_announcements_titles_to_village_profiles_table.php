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
            $table->string('announcements_subtitle')->nullable()->default('Informasi Penting');
            $table->string('announcements_title')->nullable()->default('Pengumuman Desa Terbaru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn(['announcements_subtitle', 'announcements_title']);
        });
    }
};
