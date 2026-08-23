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
        $services = DB::table('public_services')
            ->whereNotNull('document_file')
            ->where('document_file', '!=', '')
            ->get();

        foreach ($services as $service) {
            DB::table('public_service_documents')->insert([
                'public_service_id' => $service->id,
                'file_path' => $service->document_file,
                'title' => 'Formulir Persyaratan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('public_service_documents')->truncate();
    }
};
