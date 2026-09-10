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
        if (Schema::hasTable('cultures') && !Schema::hasColumn('cultures', 'contact_person')) {
            Schema::table('cultures', function (Blueprint $table) {
                $table->string('contact_person')->nullable()->after('contact');
            });
        }

        if (Schema::hasTable('agriculture_commodities') && !Schema::hasColumn('agriculture_commodities', 'contact_person')) {
            Schema::table('agriculture_commodities', function (Blueprint $table) {
                $table->string('contact_person')->nullable()->after('contact');
            });
        }

        if (Schema::hasTable('community_institutions') && !Schema::hasColumn('community_institutions', 'contact_person')) {
            Schema::table('community_institutions', function (Blueprint $table) {
                $table->string('contact_person')->nullable()->after('contact');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cultures') && Schema::hasColumn('cultures', 'contact_person')) {
            Schema::table('cultures', function (Blueprint $table) {
                $table->dropColumn('contact_person');
            });
        }

        if (Schema::hasTable('agriculture_commodities') && Schema::hasColumn('agriculture_commodities', 'contact_person')) {
            Schema::table('agriculture_commodities', function (Blueprint $table) {
                $table->dropColumn('contact_person');
            });
        }

        if (Schema::hasTable('community_institutions') && Schema::hasColumn('community_institutions', 'contact_person')) {
            Schema::table('community_institutions', function (Blueprint $table) {
                $table->dropColumn('contact_person');
            });
        }
    }
};
