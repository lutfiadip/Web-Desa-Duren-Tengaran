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
            $table->text('organizations_page_description')->nullable();
            $table->text('announcements_page_description')->nullable();
            $table->text('public_services_page_description')->nullable();
            $table->text('gallery_page_description')->nullable();
            $table->text('statistics_page_description')->nullable();
            $table->text('contact_page_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'organizations_page_description',
                'announcements_page_description',
                'public_services_page_description',
                'gallery_page_description',
                'statistics_page_description',
                'contact_page_description'
            ]);
        });
    }
};
