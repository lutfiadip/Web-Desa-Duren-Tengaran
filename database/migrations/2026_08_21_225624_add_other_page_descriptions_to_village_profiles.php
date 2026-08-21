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
            $table->string('umkm_page_description')->nullable();
            $table->string('tourism_page_description')->nullable();
            $table->string('news_page_description')->nullable();
            $table->string('officials_page_description')->nullable();
            $table->string('regulations_page_description')->nullable();
            $table->string('institutions_page_description')->nullable();
            $table->string('agriculture_page_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'umkm_page_description',
                'tourism_page_description',
                'news_page_description',
                'officials_page_description',
                'regulations_page_description',
                'institutions_page_description',
                'agriculture_page_description',
            ]);
        });
    }
};
