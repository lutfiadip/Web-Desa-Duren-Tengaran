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
        Schema::create('village_details', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan')->default('Tengaran');
            $table->string('kabupaten')->default('Semarang');
            $table->string('provinsi')->default('Jawa Tengah');
            $table->string('zip_code')->default('50775');
            $table->unsignedInteger('dusun_count')->default(4);
            $table->unsignedInteger('rt_count')->default(35);
            $table->unsignedInteger('rw_count')->default(8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_details');
    }
};
