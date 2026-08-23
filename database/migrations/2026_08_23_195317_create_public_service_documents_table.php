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
        Schema::create('public_service_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_service_id')->constrained('public_services')->onDelete('cascade');
            $table->string('file_path');
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_service_documents');
    }
};
