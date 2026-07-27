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
        Schema::create('agriculture_commodities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // e.g., Hortikultura, Perkebunan, Peternakan, Kehutanan
            $table->string('thumbnail')->nullable();
            $table->text('description');
            $table->json('gallery')->nullable();
            $table->string('production_scale')->nullable();
            $table->string('harvest_time')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->text('google_maps_url')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agriculture_commodities');
    }
};
