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
        Schema::create('population_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->index();
            $table->tinyInteger('semester');
            $table->year('year');
            $table->string('source')->nullable();
            $table->timestamps();

            // Mencegah duplikasi data per periode
            $table->unique(['type', 'semester', 'year']);
        });

        Schema::create('population_statistic_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_id')->constrained('population_statistics')->onDelete('cascade');
            $table->string('label');
            $table->integer('male_total')->nullable();
            $table->integer('female_total')->nullable();
            
            // Auto-calculate total using Stored Generated Column
            $table->integer('total')->storedAs('COALESCE(male_total, 0) + COALESCE(female_total, 0)');
            
            $table->decimal('percentage', 5, 2)->nullable();
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
    }
};
