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
        // 1. Create/Find the merged category "Kepala Desa & Sekretaris"
        $mergedCat = OfficialCategory::firstOrCreate(
            ['name' => 'Kepala Desa & Sekretaris'],
            ['sort_order' => 1]
        );

        // 2. Find old categories
        $kadesCat = OfficialCategory::where('name', 'Kepala Desa')->first();
        $sekdesCat = OfficialCategory::where('name', 'Sekretaris Desa')->first();

        // 3. Move officials from old categories to the new one
        if ($kadesCat) {
            Official::where('category_id', $kadesCat->id)->update(['category_id' => $mergedCat->id]);
            $kadesCat->delete();
        }
        if ($sekdesCat) {
            Official::where('category_id', $sekdesCat->id)->update(['category_id' => $mergedCat->id]);
            $sekdesCat->delete();
        }
        
        // 4. Update sort_orders of other categories to follow
        $kaurKasiCat = OfficialCategory::where('name', 'Kaur & Kasi')->first();
        if ($kaurKasiCat) {
            $kaurKasiCat->update(['sort_order' => 2]);
        }
        
        $kadusCat = OfficialCategory::where('name', 'Kepala Dusun')->first();
        if ($kadusCat) {
            $kadusCat->update(['sort_order' => 3]);
        }
    }

    public function down(): void
    {
        // Reverse is to recreate Kepala Desa and Sekretaris Desa
        $kadesCat = OfficialCategory::firstOrCreate(['name' => 'Kepala Desa'], ['sort_order' => 1]);
        $sekdesCat = OfficialCategory::firstOrCreate(['name' => 'Sekretaris Desa'], ['sort_order' => 2]);

        $mergedCat = OfficialCategory::where('name', 'Kepala Desa & Sekretaris')->first();
        if ($mergedCat) {
            // Move back based on position
            Official::where('category_id', $mergedCat->id)
                ->where('position', 'Kepala Desa')
                ->update(['category_id' => $kadesCat->id]);
                
            Official::where('category_id', $mergedCat->id)
                ->where('position', 'Sekretaris Desa')
                ->update(['category_id' => $sekdesCat->id]);

            $mergedCat->delete();
        }
        
        $kaurKasiCat = OfficialCategory::where('name', 'Kaur & Kasi')->first();
        if ($kaurKasiCat) {
            $kaurKasiCat->update(['sort_order' => 3]);
        }
        
        $kadusCat = OfficialCategory::where('name', 'Kepala Dusun')->first();
        if ($kadusCat) {
            $kadusCat->update(['sort_order' => 4]);
        }
    }
};
