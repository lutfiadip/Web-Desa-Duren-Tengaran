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
        Schema::create('demographic_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('demographic_periods')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('demographic_categories')->onDelete('cascade');
            $table->string('label');
            $table->unsignedInteger('male_count')->default(0);
            $table->unsignedInteger('female_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demographic_statistics');
    }
};
