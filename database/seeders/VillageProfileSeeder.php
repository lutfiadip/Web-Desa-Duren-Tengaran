<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageProfile;
use App\Models\VillageDetail;
use App\Models\OfficialCategory;
use App\Models\Official;
use App\Models\RegulationCategory;
use App\Models\Regulation;
use App\Models\User;
use App\Models\TouristAttraction;
use App\Models\Culture;
use Illuminate\Support\Facades\Schema;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate table to prevent duplicate entries
        Schema::disableForeignKeyConstraints();
        VillageProfile::truncate();
        VillageDetail::truncate();
        Official::truncate();
        OfficialCategory::truncate();
        Regulation::truncate();
        RegulationCategory::truncate();
        TouristAttraction::truncate();
        Culture::truncate();
        Schema::enableForeignKeyConstraints();

        VillageProfile::create([
            'village_name' => 'Duren',
            'logo' => 'img/logo-semarang.png',
            'headman_name' => 'Wahyudi, S.M.',
            'headman_photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'headman_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya. Selamat datang di Website Resmi Desa Duren Tengaran. Website ini kami hadirkan sebagai bentuk komitmen Pemerintah Desa dalam mewujudkan transparansi informasi, peningkatan pelayanan publik, serta wadah promosi potensi desa kepada masyarakat luas.',
            'history' => 'Desa Duren memiliki sejarah panjang yang kaya akan nilai budaya. Nama \'Duren\' diyakini berasal dari melimpahnya pohon durian di wilayah ini pada masa lampau, yang menjadi penanda khas bagi para pendatang. Seiring berjalannya waktu, Desa Duren bertransformasi dari kawasan agraris tradisional menjadi desa yang berkembang menuju kemandirian ekonomi. Melalui semangat gotong royong warga, desa ini berhasil mengintegrasikan sektor pertanian, peternakan, dan UMKM lokal sebagai pilar ekonomi utama.',
            'vision' => 'Terwujudnya Desa Duren yang Mandiri, Sejahtera, Transparan, dan Berdaya Saing Tinggi melalui Optimalisasi Potensi Lokal dan Pelayanan Prima.',
            'mission' => "1. Mewujudkan tata kelola pemerintahan desa yang bersih, transparan, dan akuntabel berbasis teknologi informasi.\n2. Meningkatkan kualitas pelayanan publik yang prima, cepat, tepat, dan ramah kepada masyarakat.\n3. Mendorong pembangunan infrastruktur sarana dan prasarana desa yang merata, aman, dan berkelanjutan.\n4. Mengembangkan perekonomian masyarakat melalui pemberdayaan UMKM, sektor pertanian, dan peternakan unggulan.\n5. Meningkatkan kualitas kehidupan keagamaan, sosial budaya, pemuda, olahraga, serta melestarikan kearifan lokal.",
            'address' => 'Miri, Duren, Kec. Tengaran, Kabupaten Semarang, Jawa Tengah 50775',
            'phone' => '-',
            'email' => '332202.duren@gmail.com',
            'facebook' => '#',
            'instagram' => '@desa.duren',
            'youtube' => '@durentengaran',
            'google_maps_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15822.428399581895!2d110.49061099684128!3d-7.442340578648174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a783709b0bfa5%3A0xc3cf9c98bc97149a!2sDuren%2C%20Tengaran%2C%20Semarang%20Regency%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid',
            'office_hours' => 'Senin - Kamis (08.00 - 15.00 WIB) | Jumat (08.00 - 11.30 WIB)',
            'hero_bg_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'
        ]);

        VillageDetail::create([
            'kecamatan' => 'Tengaran',
            'kabupaten' => 'Semarang',
            'provinsi' => 'Jawa Tengah',
            'zip_code' => '50775',
            'dusun_count' => 8,
            'rt_count' => 35,
            'rw_count' => 8,
        ]);

        $pemdes = OfficialCategory::create(['name' => 'Pemerintah Desa']);

        // 1. Pimpinan (Kepala Desa)
        Official::create([
            'category_id' => $pemdes->id,
            'name' => 'Wahyudi, S.M.',
            'position' => 'Kepala Desa',
            'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'nip' => '-',
            'sort_order' => 1
        ]);

        // 2. Kaur/Kasi (Kaur Keuangan)
        Official::create([
            'category_id' => $pemdes->id,
            'name' => 'Indah Lestari, A.Md.',
            'position' => 'Kaur Keuangan',
            'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'nip' => '-',
            'sort_order' => 3
        ]);

        // 3. Kepala Dusun (Kepala Dusun Miri)
        Official::create([
            'category_id' => $pemdes->id,
            'name' => 'Triyono',
            'position' => 'Kepala Dusun Miri',
            'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'nip' => '-',
            'sort_order' => 9
        ]);

        // Create user if none exists (to link with news & regulations user_id)
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin Desa Duren',
                'email' => 'admin@duren.desa.id',
                'password' => bcrypt('password123'),
            ]);
        }

        // Seed Regulation Categories
        $catPerdes = RegulationCategory::create(['name' => 'Peraturan Desa (Perdes)']);
        $catPerkades = RegulationCategory::create(['name' => 'Peraturan Kepala Desa (Perkades)']);
        $catKeputusan = RegulationCategory::create(['name' => 'Keputusan Kepala Desa']);

        // Seed Sample Regulations
        Regulation::create([
            'category_id' => $catPerdes->id,
            'user_id' => $user->id,
            'title' => 'Rencana Pembangunan Jangka Menengah Desa (RPJMDes) Tahun 2026-2032',
            'number' => '01',
            'year' => 2026,
            'description' => 'Dokumen rencana strategis pembangunan Desa Duren untuk jangka waktu 6 tahun ke depan.',
            'document_file' => 'rpjmdes_2026_2032.pdf',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Regulation::create([
            'category_id' => $catPerdes->id,
            'user_id' => $user->id,
            'title' => 'Anggaran Pendapatan dan Belanja Desa (APBDes) Tahun Anggaran 2026',
            'number' => '02',
            'year' => 2026,
            'description' => 'Rincian rencana keuangan tahunan Pemerintahan Desa Duren untuk tahun anggaran 2026.',
            'document_file' => 'apbdes_2026.pdf',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Regulation::create([
            'category_id' => $catPerkades->id,
            'user_id' => $user->id,
            'title' => 'Rencana Kerja Pemerintah Desa (RKPDes) Tahun 2026',
            'number' => '03',
            'year' => 2025,
            'description' => 'Penjabaran dari RPJM Desa Duren untuk jangka waktu 1 tahun anggaran (tahun 2026).',
            'document_file' => 'rkpdes_2026.pdf',
            'status' => 'published',
            'published_at' => now()->subDays(30),
        ]);

        // Seed Tourist Attractions
        TouristAttraction::create([
            'user_id' => $user->id,
            'title' => 'River Tubing Manggolo Kusumo',
            'slug' => 'river-tubing-manggolo-kusumo',
            'description' => 'River Tubing Manggolo Kusumo merupakan wahana wisata air unggulan di Desa Duren yang memanfaatkan aliran Sungai Serang. Di sini, pengunjung dapat menyusuri keindahan sungai sepanjang beberapa kilometer dengan ban pelampung, menikmati panorama tebing batu eksotis, hutan bambu yang teduh, dan udara pedesaan yang sangat asri. Wahana ini juga ramah untuk anak-anak dengan jalur khusus yang lebih tenang.',
            'thumbnail' => 'https://images.unsplash.com/photo-1533240332313-0db49b439ad3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'address' => 'Dusun Miri, Desa Duren, Kec. Tengaran, Kabupaten Semarang, Jawa Tengah 50775',
            'google_maps_url' => 'https://maps.google.com/?q=River+Tubing+Manggolo+Kusumo+Duren+Tengaran',
            'operating_hours' => 'Sabtu - Minggu (08.00 - 16.00 WIB) | Hari Kerja (Dengan reservasi kelompok)',
            'ticket_price' => 35000,
            'contact' => '0857-4123-4567 (Bpk. Triyono)',
            'facilities' => 'Rompi Pelampung, Helm Pelindung, Ban Tubing, Pemandu Profesional, Gazebo Istirahat, Kamar Mandi/Bilas, Dokumentasi',
            'gallery' => [
                'https://images.unsplash.com/photo-1533240332313-0db49b439ad3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);

        TouristAttraction::create([
            'user_id' => $user->id,
            'title' => 'Agrowisata Kebun Durian Duren',
            'slug' => 'agrowisata-kebun-durian-duren',
            'description' => 'Sesuai dengan nama desanya, Agrowisata Kebun Durian menawarkan sensasi memetik dan mencicipi buah durian lokal unggulan langsung dari pohonnya. Pengunjung dapat belajar cara merawat pohon durian, mengenali berbagai varietas lokal yang lezat, serta bersantai di bawah rindangnya pepohonan durian yang tumbuh subur di wilayah perbukitan desa.',
            'thumbnail' => 'https://images.unsplash.com/photo-1621841315897-b5425231de3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'address' => 'Dusun Duren, Desa Duren, Kec. Tengaran, Kabupaten Semarang, Jawa Tengah 50775',
            'google_maps_url' => 'https://maps.google.com/?q=Desa+Duren+Tengaran',
            'operating_hours' => 'Setiap Hari (08.00 - 17.00 WIB) | Puncak musim durian biasanya terjadi di bulan Desember - Februari',
            'ticket_price' => 10000,
            'contact' => '0812-3456-7890 (Sekretariat BUMDes)',
            'facilities' => 'Area parkir luas, Gazebo/Saung, Warung makan lokal, Toilet umum, Spot foto',
            'gallery' => [
                'https://images.unsplash.com/photo-1621841315897-b5425231de3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);

        // Seed Cultures
        Culture::create([
            'user_id' => $user->id,
            'title' => 'Seni Tari Topeng Ireng',
            'slug' => 'seni-tari-topeng-ireng',
            'description' => 'Seni tari tradisional Topeng Ireng merupakan kesenian rakyat khas lereng Gunung Merbabu dan Merapi yang dilestarikan secara turun-temurun oleh pemuda Desa Duren. Tarian ini menampilkan gerakan dinamis, lincah, dan penuh semangat dengan iringan musik perkusi tradisional, terompet, serta nyanyian moral/keagamaan. Penari mengenakan hiasan bulu unggas melingkar di kepala (mirip suku Indian) dan gemerincing lonceng kecil di kaki yang menghasilkan suara riuh yang khas.',
            'thumbnail' => 'https://images.unsplash.com/photo-1608976451631-f111be15c2ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'location' => 'Sanggar Seni Manunggal Raras, Dusun Duren',
            'implementation_time' => 'Dipentaskan saat upacara adat Merti Dusun, perayaan HUT RI, festival budaya daerah, dan penyambutan tamu penting.',
            'contact' => '0812-9876-5432 (Bpk. Joko - Ketua Sanggar)',
            'gallery' => [
                'https://images.unsplash.com/photo-1608976451631-f111be15c2ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);

        Culture::create([
            'user_id' => $user->id,
            'title' => 'Kesenian Reog & Jaran Kepang',
            'slug' => 'kesenian-reog-dan-jaran-kepang',
            'description' => 'Kesenian Reog dan Jaran Kepang di Desa Duren menceritakan kisah kepahlawanan dan petualangan prajurit berkuda. Kelompok seni lokal menyajikan atraksi tari yang memukau dengan iringan gamelan jawa yang bertempo dinamis. Kesenian ini sangat digemari oleh seluruh lapisan masyarakat desa dan menjadi simbol pemersatu pemuda dalam melestarikan warisan budaya leluhur.',
            'thumbnail' => 'https://images.unsplash.com/photo-1590075865003-e48277faa558?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'location' => 'Halaman Balai Desa atau Dusun setempat',
            'implementation_time' => 'Dipentaskan secara berkala pada acara bersih desa (Merti Dusun) dan hajatan masyarakat.',
            'contact' => '0878-1122-3344 (Bpk. Slamet - Koordinator)',
            'gallery' => [
                'https://images.unsplash.com/photo-1590075865003-e48277faa558?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1506157786151-b8491531f063?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
            ],
            'status' => 'published',
            'is_featured' => true
        ]);
    }
}
