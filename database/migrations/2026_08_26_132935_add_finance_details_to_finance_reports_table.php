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
        Schema::table('finance_reports', function (Blueprint $table) {
            $table->decimal('revenue_pad', 15, 2)->default(0);
            $table->decimal('revenue_add', 15, 2)->default(0);
            $table->decimal('revenue_dd', 15, 2)->default(0);
            $table->decimal('revenue_pbh', 15, 2)->default(0);
            
            $table->decimal('spending_pemerintahan', 15, 2)->default(0);
            $table->decimal('spending_pembangunan', 15, 2)->default(0);
            $table->decimal('spending_pembinaan', 15, 2)->default(0);
            $table->decimal('spending_pemberdayaan', 15, 2)->default(0);
            $table->decimal('spending_penanggulangan', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finance_reports', function (Blueprint $table) {
            $table->dropColumn([
                'revenue_pad',
                'revenue_add',
                'revenue_dd',
                'revenue_pbh',
                'spending_pemerintahan',
                'spending_pembangunan',
                'spending_pembinaan',
                'spending_pemberdayaan',
                'spending_penanggulangan'
            ]);
        });
    }
};
