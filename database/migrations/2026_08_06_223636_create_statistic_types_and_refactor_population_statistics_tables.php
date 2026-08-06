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
        // Drop existing tables first to prevent constraint or data conflict
        Schema::dropIfExists('population_statistic_details');
        Schema::dropIfExists('population_statistics');

        // 1. Create population_statistic_types table
        Schema::create('population_statistic_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Re-create population_statistics table with new schema
        Schema::create('population_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_type_id')->constrained('population_statistic_types')->onDelete('cascade');
            $table->tinyInteger('semester');
            $table->year('year');
            $table->string('source')->nullable();
            $table->string('pdf_file')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['statistic_type_id', 'semester', 'year'], 'pop_stats_type_sem_year_unique');
        });

        // 3. Re-create population_statistic_details table without redundant columns
        Schema::create('population_statistic_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_id')->constrained('population_statistics')->onDelete('cascade');
            $table->string('label');
            $table->integer('male_total')->default(0);
            $table->integer('female_total')->default(0);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('population_statistic_details');
        Schema::dropIfExists('population_statistics');
        Schema::dropIfExists('population_statistic_types');

        // Restore original tables
        Schema::create('population_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->index();
            $table->tinyInteger('semester');
            $table->year('year');
            $table->string('source')->nullable();
            $table->string('pdf_file')->nullable();
            $table->timestamps();

            $table->unique(['type', 'semester', 'year']);
        });

        Schema::create('population_statistic_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_id')->constrained('population_statistics')->onDelete('cascade');
            $table->string('label');
            $table->integer('male_total')->nullable();
            $table->integer('female_total')->nullable();
            $table->integer('total')->storedAs('COALESCE(male_total, 0) + COALESCE(female_total, 0)');
            $table->decimal('percentage', 5, 2)->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }
};
