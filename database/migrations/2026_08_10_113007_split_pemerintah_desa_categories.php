<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OfficialCategory;
use App\Models\Official;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the new categories if they don't exist
        $kadesCat = OfficialCategory::firstOrCreate(['name' => 'Kepala Desa'], ['sort_order' => 1]);
        $sekdesCat = OfficialCategory::firstOrCreate(['name' => 'Sekretaris Desa'], ['sort_order' => 2]);
        $kaurKasiCat = OfficialCategory::firstOrCreate(['name' => 'Kaur & Kasi'], ['sort_order' => 3]);
        $kadusCat = OfficialCategory::firstOrCreate(['name' => 'Kepala Dusun'], ['sort_order' => 4]);

        // 2. Migrate officials to new categories based on their positions and sort_order
        $officials = Official::all();
        foreach ($officials as $official) {
            if ($official->position === 'Kepala Desa') {
                $official->update(['category_id' => $kadesCat->id]);
            } elseif ($official->position === 'Sekretaris Desa') {
                $official->update(['category_id' => $sekdesCat->id]);
            } elseif (in_array($official->sort_order, [3, 4, 5, 6, 7, 8])) {
                $official->update(['category_id' => $kaurKasiCat->id]);
            } elseif ($official->sort_order >= 9) {
                $official->update(['category_id' => $kadusCat->id]);
            }
        }

        // 3. Delete the old "Pemerintah Desa" category if it exists and has no officials left
        $pemdesCat = OfficialCategory::where('name', 'Pemerintah Desa')->first();
        if ($pemdesCat && $pemdesCat->officials()->count() === 0) {
            $pemdesCat->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate Pemerintah Desa
        $pemdesCat = OfficialCategory::firstOrCreate(['name' => 'Pemerintah Desa'], ['sort_order' => 1]);

        // Put all officials back into Pemerintah Desa
        Official::query()->update(['category_id' => $pemdesCat->id]);

        // Delete the new categories
        OfficialCategory::whereIn('name', ['Kepala Desa', 'Sekretaris Desa', 'Kaur & Kasi', 'Kepala Dusun'])->delete();
    }
};
