<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For each tourist attraction, if ticket_price > 0 and ticket_packages is null or empty,
        // create a default package "Tiket Masuk" with the value of ticket_price.
        $attractions = DB::table('tourist_attractions')->get();
        foreach ($attractions as $attraction) {
            $packages = json_decode($attraction->ticket_packages, true);
            if (empty($packages)) {
                $price = $attraction->ticket_price;
                $defaultPackages = [
                    [
                        'name' => 'Tiket Masuk',
                        'price' => (int)$price
                    ]
                ];
                DB::table('tourist_attractions')
                    ->where('id', $attraction->id)
                    ->update(['ticket_packages' => json_encode($defaultPackages)]);
            }
        }
    }

    public function down(): void
    {
        // No-op or revert if needed
    }
};
