<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageProfile;
use App\Models\VillageDetail;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate table to prevent duplicate entries
        VillageProfile::truncate();
        VillageDetail::truncate();

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
            'office_hours' => 'Senin - Kamis (08.00 - 15.00 WIB) | Jumat (08.00 - 11.30 WIB)'
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
    }
}
