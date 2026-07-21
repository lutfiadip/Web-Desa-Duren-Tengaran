<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;
use App\Models\UmkmCategory;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@desa.id'],
            ['name' => 'Admin Desa', 'password' => Hash::make('password')]
        );

        $catMakanan = UmkmCategory::create(['name' => 'Makanan Ringan']);
        $catKerajinan = UmkmCategory::create(['name' => 'Kerajinan']);
        $catMinuman = UmkmCategory::create(['name' => 'Minuman']);

        Umkm::create([
            'category_id' => $catMakanan->id,
            'user_id' => $user->id,
            'title' => 'Keripik Pisang Aneka Rasa',
            'slug' => Str::slug('Keripik Pisang Aneka Rasa'),
            'owner_name' => 'Ibu Siti',
            'description' => 'Keripik pisang renyah buatan rumahan dengan pilihan rasa cokelat, keju, balado, dan original.',
            'thumbnail' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Krajan, RT 01/RW 02',
            'whatsapp' => '6281234567890',
            'status' => 'published',
            'is_featured' => true
        ]);

        Umkm::create([
            'category_id' => $catKerajinan->id,
            'user_id' => $user->id,
            'title' => 'Kerajinan Anyaman Bambu',
            'slug' => Str::slug('Kerajinan Anyaman Bambu'),
            'owner_name' => 'Bapak Budi',
            'description' => 'Berbagai macam produk kerajinan anyaman bambu seperti tampah, tenggok, dan hiasan dinding.',
            'thumbnail' => 'https://images.unsplash.com/photo-1544967082-29ee1d713c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Duren, RT 03/RW 01',
            'whatsapp' => '6281234567890',
            'status' => 'published',
            'is_featured' => true
        ]);

        Umkm::create([
            'category_id' => $catMinuman->id,
            'user_id' => $user->id,
            'title' => 'Kopi Bubuk Asli Duren',
            'slug' => Str::slug('Kopi Bubuk Asli Duren'),
            'owner_name' => 'Mas Andi',
            'description' => 'Kopi robusta petik merah asli dari perkebunan Desa Duren. Diolah dengan cara tradisional.',
            'thumbnail' => 'https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Karang, RT 02/RW 03',
            'whatsapp' => '6281234567890',
            'status' => 'published',
            'is_featured' => true
        ]);
    }
}
