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
            $table->string('about_subtitle')->nullable()->default('TENTANG DESA');
            $table->string('potency_title')->nullable()->default('Kekayaan & Komoditas Unggulan');
            $table->string('potency_subtitle')->nullable()->default('Potensi Desa');
            $table->string('potency_agriculture_desc')->nullable()->default('Lahan subur dengan komoditas unggulan padi dan palawija.');
            $table->string('potency_animal_husbandry_desc')->nullable()->default('Pusat pengembangan hewan ternak seperti sapi dan kambing.');
            $table->string('potency_umkm_desc')->nullable()->default('Produk kerajinan dan makanan khas hasil karya warga desa.');
            $table->string('potency_tourism_desc')->nullable()->default('Pesona alam asri yang menarik bagi wisatawan lokal.');
            $table->string('umkm_title')->nullable()->default('UMKM Unggulan Desa');
            $table->string('umkm_subtitle')->nullable()->default('Produk Lokal');
            $table->string('news_title')->nullable()->default('Berita & Pengumuman');
            $table->string('news_subtitle')->nullable()->default('Kabar Terkini');
            $table->string('gallery_title')->nullable()->default('Galeri Desa');
            $table->string('gallery_subtitle')->nullable()->default('Pesona Desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'about_subtitle',
                'potency_title',
                'potency_subtitle',
                'potency_agriculture_desc',
                'potency_animal_husbandry_desc',
                'potency_umkm_desc',
                'potency_tourism_desc',
                'umkm_title',
                'umkm_subtitle',
                'news_title',
                'news_subtitle',
                'gallery_title',
                'gallery_subtitle'
            ]);
        });
    }
};
