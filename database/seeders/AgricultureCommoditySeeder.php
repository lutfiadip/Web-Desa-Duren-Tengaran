<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgricultureCommodity;
use Illuminate\Support\Facades\Schema;

class AgricultureCommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AgricultureCommodity::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Durian
        AgricultureCommodity::create([
            'title' => 'Buah Durian Lokal',
            'slug' => 'buah-durian-lokal',
            'category' => 'Hortikultura',
            'thumbnail' => 'https://images.unsplash.com/photo-1621841315897-b5425231de3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => "Sesuai dengan namanya, Desa Duren terkenal dengan pohon durian lokal berbuah lebat yang memiliki rasa manis legit dengan sedikit sentuhan rasa pahit khas yang sangat digemari oleh pecinta buah eksotis ini. Durian Desa Duren diproduksi secara alami dari pekarangan dan perkebunan warga yang menggunakan metode perawatan ramah lingkungan tanpa pestisida kimia.\n\nSaat puncak musim panen tiba antara bulan Desember hingga Februari, agrowisata petik durian menjadi daya tarik wisata kuliner utama yang mendatangkan banyak pengunjung dari luar kota. Pengunjung dapat menikmati sensasi memetik buah durian matang jatuh pohon dan menyantapnya secara langsung di bawah naungan pohon durian yang rindang.",
            'gallery' => [
                'https://images.unsplash.com/photo-1621841315897-b5425231de3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'production_scale' => '15 - 20 Ton per musim panen',
            'harvest_time' => 'Desember - Februari (Musim Tahunan)',
            'address' => 'Dusun Duren, Desa Duren, Kec. Tengaran',
            'contact' => '0812-3456-7890 (Sekretariat BUMDes)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'status' => 'published',
            'is_featured' => true
        ]);

        // 2. Kopi
        AgricultureCommodity::create([
            'title' => 'Kopi Lereng Merbabu',
            'slug' => 'kopi-lereng-merbabu',
            'category' => 'Perkebunan',
            'thumbnail' => 'https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => "Biji kopi robusta dan sebagian kecil arabika diproduksi langsung dari kebun-kebun rakyat yang tersebar di lereng perbukitan teduh Desa Duren. Suhu udara lereng Merbabu yang sejuk memberikan karakter aroma dan cita rasa kopi yang sangat khas: pekat, tebal, dengan keharuman alami yang memikat.\n\nDiolah secara tradisional oleh para kelompok tani kopi mulai dari pemetikan buah merah ceri secara manual, penjemuran alami di bawah sinar matahari, hingga proses sangrai kayu tradisional guna mempertahankan kualitas rasa murni warisan leluhur. Produk kopi ini telah dipasarkan luas secara online dan dapat dibeli di galeri produk lokal.",
            'gallery' => [
                'https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1447933601403-0c6688de566e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'production_scale' => '2.5 Ton per tahun',
            'harvest_time' => 'Juni - Agustus (Musim Panen Kopi)',
            'address' => 'Dusun Karangwuni, Desa Duren, Kec. Tengaran',
            'contact' => '0812-3456-7892 (Mas Andi - Kopi Asli Duren)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'status' => 'published',
            'is_featured' => true
        ]);

        // 3. Susu
        AgricultureCommodity::create([
            'title' => 'Susu Sapi Perah',
            'slug' => 'susu-sapi-perah',
            'category' => 'Peternakan',
            'thumbnail' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => "Peternakan sapi perah rakyat merupakan salah satu klaster ekonomi terbesar di Desa Duren. Puluhan peternak rakyat secara terorganisasi memelihara sapi jenis Friesian Holstein (FH) berkualitas unggul. Susu segar diperah setiap pagi dan sore hari menggunakan teknologi kebersihan standar guna menjaga kemurnian dan kandungan gizi susu murni.\n\nSusu murni yang dihasilkan setiap hari dikumpulkan melalui koperasi desa, lalu didistribusikan secara segar kepada industri pengolahan susu (IPS) regional terkemuka serta diolah secara mandiri menjadi berbagai varian yogurt dan keju skala rumah tangga oleh kelompok ibu-ibu PKK desa.",
            'gallery' => [
                'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1527018601619-a508a2be00cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'production_scale' => '450 - 600 Liter per hari',
            'harvest_time' => 'Setiap Hari (Pagi & Sore hari)',
            'address' => 'Dusun Babadan, Desa Duren, Kec. Tengaran',
            'contact' => '0857-4123-9999 (Bpk. Suparno - Gapoktan Susu)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'status' => 'published',
            'is_featured' => true
        ]);

        // 4. Madu
        AgricultureCommodity::create([
            'title' => 'Madu Hutan Rimba',
            'slug' => 'madu-hutan-rimba',
            'category' => 'Kehutanan',
            'thumbnail' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => "Madu mentah (raw honey) diproduksi secara berkelanjutan dari hasil budidaya lebah madu Apis Mellifera yang menghisap nektar bunga liar di sekitar hutan bambu rindang wilayah konservasi desa. Madu hutan Desa Duren terkenal dengan teksturnya yang kental alami, warna keemasan gelap yang indah, serta rasa manis-lembut beraroma bunga liar.\n\nMadu dipanen secara berkala dengan tetap mempertahankan kelestarian koloni lebah. Diproses secara higienis tanpa melalui proses pemanasan tinggi (pasteurisasi) atau penyaringan mikro kimiawi untuk memastikan seluruh enzim alami, propolis, dan bee pollen yang sangat baik bagi kesehatan tubuh tetap terjaga utuh.",
            'gallery' => [
                'https://images.unsplash.com/photo-1587049352846-4a222e784d38?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1473081556163-2a17de81fc97?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1558583055-d7ac00b1adca?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'production_scale' => '120 - 150 kg per panen',
            'harvest_time' => '3 - 4 kali dalam setahun (Musim Bunga)',
            'address' => 'Dusun Duren (Hutan Bambu Lestari), Desa Duren',
            'contact' => '0812-3456-7894 (Bpk. Hartono - Madu Rimba)',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'status' => 'published',
            'is_featured' => true
        ]);
    }
}
