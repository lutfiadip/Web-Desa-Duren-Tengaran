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
        Schema::create('finance_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unique();
            $table->decimal('revenue_target', 15, 2)->default(0);
            $table->decimal('revenue_realization', 15, 2)->default(0);
            $table->decimal('spending_target', 15, 2)->default(0);
            $table->decimal('spending_realization', 15, 2)->default(0);
            $table->decimal('financing_target', 15, 2)->default(0);
            $table->decimal('financing_realization', 15, 2)->default(0);
            $table->string('apbdes_poster')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('finance_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finance_report_id')->constrained('finance_reports')->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->string('category'); // 'budget', 'development', 'asset', 'report'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_documents');
        Schema::dropIfExists('finance_reports');
    }
};
