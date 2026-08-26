<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finance_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finance_report_id')->constrained('finance_reports')->onDelete('cascade');
            $table->string('type'); // 'revenue' or 'spending'
            $table->string('label');
            $table->decimal('value', 15, 2)->default(0);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Migrate existing data
        $reports = DB::table('finance_reports')->get();
        foreach ($reports as $report) {
            $details = [
                ['type' => 'revenue', 'label' => 'Alokasi Dana Desa', 'val' => $report->revenue_add ?? 0],
                ['type' => 'revenue', 'label' => 'Dana Desa', 'val' => $report->revenue_dd ?? 0],
                ['type' => 'revenue', 'label' => 'BHPD & BHRD', 'val' => $report->revenue_pbh ?? 0],
                ['type' => 'revenue', 'label' => 'Pendapatan Asli Desa', 'val' => $report->revenue_pad ?? 0],
                ['type' => 'spending', 'label' => 'Pemerintahan Desa', 'val' => $report->spending_pemerintahan ?? 0],
                ['type' => 'spending', 'label' => 'Pembangunan Desa', 'val' => $report->spending_pembangunan ?? 0],
                ['type' => 'spending', 'label' => 'Pembinaan Kemasyarakatan', 'val' => $report->spending_pembinaan ?? 0],
                ['type' => 'spending', 'label' => 'Pemberdayaan Masyarakat', 'val' => $report->spending_pemberdayaan ?? 0],
                ['type' => 'spending', 'label' => 'Penanggulangan Bencana', 'val' => $report->spending_penanggulangan ?? 0],
            ];

            foreach ($details as $index => $det) {
                // Insert default details
                DB::table('finance_report_details')->insert([
                    'finance_report_id' => $report->id,
                    'type' => $det['type'],
                    'label' => $det['label'],
                    'value' => $det['val'],
                    'display_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_report_details');
    }
};
