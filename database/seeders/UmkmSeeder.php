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
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Umkm::truncate();
        UmkmCategory::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $user = User::firstOrCreate(
            ['email' => 'admin@desa.id'],
            ['name' => 'Admin Desa', 'password' => Hash::make('password')]
        );

        $catMakanan = UmkmCategory::firstOrCreate(['name' => 'Makanan Ringan']);
        $catKerajinan = UmkmCategory::firstOrCreate(['name' => 'Kerajinan']);
        $catMinuman = UmkmCategory::firstOrCreate(['name' => 'Minuman']);
        $catPertanian = UmkmCategory::firstOrCreate(['name' => 'Pertanian & Peternakan']);

        Umkm::create([
            'category_id' => $catMakanan->id,
            'user_id' => $user->id,
            'title' => 'Keripik Pisang Aneka Rasa',
            'slug' => Str::slug('Keripik Pisang Aneka Rasa'),
            'owner_name' => 'Ibu Siti',
            'description' => 'Keripik pisang renyah buatan rumahan dengan pilihan rasa cokelat premium, keju lumer, balado pedas, dan original gurih. Diproduksi dari pisang pilihan hasil kebun sendiri.',
            'thumbnail' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Krajan, RT 01/RW 02, Desa Duren',
            'whatsapp' => '6281234567890',
            'instagram' => 'keripik.pisang.duren',
            'facebook' => 'Keripik Pisang Ibu Siti',
            'operating_hours' => 'Setiap Hari (08.00 - 20.00 WIB)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'gallery' => [
                'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1528825871115-3581a5387919?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);

        Umkm::create([
            'category_id' => $catKerajinan->id,
            'user_id' => $user->id,
            'title' => 'Kerajinan Anyaman Bambu',
            'slug' => Str::slug('Kerajinan Anyaman Bambu'),
            'owner_name' => 'Bapak Budi',
            'description' => 'Berbagai macam produk kerajinan anyaman bambu berkualitas tinggi seperti tampah, tenggok, kap lampu estetik, tas bambu modern, dan hiasan dinding kreatif.',
            'thumbnail' => 'https://images.unsplash.com/photo-1544967082-29ee1d713c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Duren, RT 03/RW 01, Desa Duren',
            'whatsapp' => '6281234567891',
            'operating_hours' => 'Senin - Sabtu (08.00 - 16.00 WIB)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'gallery' => [
                'https://images.unsplash.com/photo-1544967082-29ee1d713c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1590736969955-71cc94801759?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1507290439931-a8e02da938c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);

        Umkm::create([
            'category_id' => $catMinuman->id,
            'user_id' => $user->id,
            'title' => 'Kopi Bubuk Asli Duren',
            'slug' => Str::slug('Kopi Bubuk Asli Duren'),
            'owner_name' => 'Mas Andi',
            'description' => 'Kopi robusta petik merah asli dari perkebunan lereng Desa Duren. Diolah dengan metode sangrai tradisional untuk menjaga aroma khas dan cita rasa yang mantap.',
            'thumbnail' => 'https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Karangwuni, RT 02/RW 03, Desa Duren',
            'whatsapp' => '6281234567892',
            'instagram' => 'kopi.asli.duren',
            'operating_hours' => 'Setiap Hari (24 Jam untuk pemesanan online)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'gallery' => [
                'https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);

        Umkm::create([
            'category_id' => $catMakanan->id,
            'user_id' => $user->id,
            'title' => 'Gula Jawa Aren Murni',
            'slug' => Str::slug('Gula Jawa Aren Murni'),
            'owner_name' => 'Mbah Rejo',
            'description' => 'Gula jawa aren asli tanpa campuran bahan kimia pengawet. Diproduksi langsung dari nira kelapa/aren pilihan dengan proses perebusan tradisional di atas tungku kayu.',
            'thumbnail' => 'https://images.unsplash.com/photo-1608039829572-78524f79c4c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Miri, RT 04/RW 01, Desa Duren',
            'whatsapp' => '6281234567893',
            'operating_hours' => 'Senin - Jumat (07.00 - 15.00 WIB)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'gallery' => [
                'https://images.unsplash.com/photo-1608039829572-78524f79c4c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1596450514966-7f4c47b0ecb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1622484211148-717df2c1f5ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ],
            'status' => 'published',
            'is_featured' => false
        ]);

        Umkm::create([
            'category_id' => $catPertanian->id,
            'user_id' => $user->id,
            'title' => 'Madu Hutan Rimba Duren',
            'slug' => Str::slug('Madu Hutan Rimba Duren'),
            'owner_name' => 'Bapak Hartono',
            'description' => 'Madu murni mentah (raw honey) hasil budidaya lebah Apis Mellifera di sekitar hutan bambu Desa Duren. Terjamin kemurniannya tanpa pemanasan dan pengenceran.',
            'thumbnail' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'address' => 'Dusun Babadan, RT 02/RW 04, Desa Duren',
            'whatsapp' => '6281234567894',
            'instagram' => 'madu.rimba.duren',
            'operating_hours' => 'Setiap Hari (08.00 - 17.00 WIB)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'gallery' => [
                'https://images.unsplash.com/photo-1587049352846-4a222e784d38?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1473081556163-2a17de81fc97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1558583055-d7ac00b1adca?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ],
            'status' => 'published',
            'is_featured' => false
        ]);
    }
}
