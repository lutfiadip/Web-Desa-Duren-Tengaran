<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommunityInstitutionCategory;
use App\Models\CommunityInstitution;
use App\Models\CommunityInstitutionMember;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class CommunityInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CommunityInstitutionCategory::truncate();
        CommunityInstitution::truncate();
        CommunityInstitutionMember::truncate();
        Schema::enableForeignKeyConstraints();

        // Get admin user
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin Desa Duren',
                'email' => 'admin@duren.desa.id',
                'password' => bcrypt('password123'),
            ]);
        }

        // 1. Seed Categories
        $lkdCategory = CommunityInstitutionCategory::create([
            'name' => 'Lembaga Kemasyarakatan Desa (LKD)',
        ]);

        $ormasCategory = CommunityInstitutionCategory::create([
            'name' => 'Organisasi Kemasyarakatan',
        ]);

        // 2. Seed Institutions (LPMD, PKK, Karang Taruna, Posyandu, LINMAS)
        
        // LPMD
        $lpmd = CommunityInstitution::create([
            'category_id' => $lkdCategory->id,
            'user_id' => $user->id,
            'name' => 'Lembaga Pemberdayaan Masyarakat Desa (LPMD)',
            'slug' => 'lpmd',
            'description' => 'Lembaga Pemberdayaan Masyarakat Desa (LPMD) adalah wadah yang dibentuk atas prakarsa masyarakat sebagai mitra Pemerintah Desa dalam menampung dan menyalurkan aspirasi serta kebutuhan masyarakat dalam pembangunan desa. LPMD berperan aktif dalam perencanaan, pelaksanaan, dan pelestarian hasil-hasil pembangunan secara partisipatif.',
            'vision' => 'Terwujudnya kemandirian masyarakat desa yang partisipatif, gotong royong, dan berdaya saing menuju pembangunan desa yang merata dan berkelanjutan.',
            'mission' => "1. Meningkatkan partisipasi aktif masyarakat dalam perencanaan pembangunan desa.\n2. Menumbuhkan kembali semangat gotong royong dan keswadayaan masyarakat.\n3. Bermitra secara sinergis dengan Pemerintah Desa dalam mengawal pelaksanaan program pembangunan.\n4. Mendorong transparansi dan akuntabilitas pembangunan fisik maupun non-fisik.",
            'logo' => 'https://images.unsplash.com/photo-1590650154751-121db79f48c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0812-9900-1122',
            'email' => 'lpmd@duren.desa.id',
            'status' => 'published',
        ]);

        // PKK
        $pkk = CommunityInstitution::create([
            'category_id' => $lkdCategory->id,
            'user_id' => $user->id,
            'name' => 'Pemberdayaan Kesejahteraan Keluarga (PKK)',
            'slug' => 'pkk',
            'description' => 'Pemberdayaan Kesejahteraan Keluarga (PKK) Desa Duren adalah gerakan pembangunan nasional yang tumbuh dari bawah, dengan wanita sebagai penggeraknya untuk mewujudkan keluarga yang sejahtera, sehat, maju, dan mandiri. PKK berperan dalam pelaksanaan 10 Program Pokok PKK guna menopang kesejahteraan keluarga petani dan peternak desa.',
            'vision' => 'Terwujudnya keluarga sejahtera untuk melahirkan generasi penerus Desa Duren yang bertakwa, berpendidikan, sehat, dan mandiri.',
            'mission' => "1. Meningkatkan pembinaan kerohanian dan mental keagamaan dalam keluarga.\n2. Meningkatkan keterampilan dan ketatalaksanaan rumah tangga.\n3. Mendorong derajat kesehatan ibu, anak, dan lansia melalui Posyandu.\n4. Mengembangkan usaha ekonomi produktif keluarga berbasis pangan lokal.",
            'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0856-7788-9900',
            'email' => 'pkk@duren.desa.id',
            'status' => 'published',
        ]);

        // Karang Taruna
        $kt = CommunityInstitution::create([
            'category_id' => $lkdCategory->id,
            'user_id' => $user->id,
            'name' => 'Karang Taruna "Karya Bakti"',
            'slug' => 'karang-taruna',
            'description' => 'Karang Taruna Desa Duren adalah organisasi sosial kemasyarakatan sebagai wadah pengembangan generasi muda yang tumbuh dan berkembang atas dasar kesadaran dan tanggung jawab sosial dari, oleh, dan untuk masyarakat, khususnya generasi muda di wilayah Desa Duren. Karang Taruna aktif dalam menyelenggarakan kegiatan olahraga, kepemudaan, seni budaya, dan kewirausahaan.',
            'vision' => 'Mewujudkan pemuda Desa Duren yang berkarakter, kreatif, mandiri, dan peduli sosial serta tangguh menghadapi tantangan global.',
            'mission' => "1. Mempererat tali persaudaraan antar pemuda dusun se-Desa Duren.\n2. Mengembangkan bakat pemuda di bidang olahraga, seni, teknologi, dan kewirausahaan.\n3. Menyelenggarakan aksi sosial untuk membantu warga kurang mampu.\n4. Mencegah kenakalan remaja melalui edukasi dan kegiatan positif.",
            'logo' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0899-1234-5678',
            'email' => 'karangtaruna@duren.desa.id',
            'status' => 'published',
        ]);

        // Posyandu
        $posyandu = CommunityInstitution::create([
            'category_id' => $lkdCategory->id,
            'user_id' => $user->id,
            'name' => 'Pos Pelayanan Terpadu (Posyandu) "Mekar Sari"',
            'slug' => 'posyandu',
            'description' => 'Posyandu (Pos Pelayanan Terpadu) Desa Duren merupakan wadah pemeliharaan kesehatan masyarakat dari, oleh, dan untuk masyarakat, dibimbing oleh petugas medis puskesmas setempat. Posyandu fokus pada pelayanan kesehatan ibu hamil, bayi, balita, dan lansia secara berkala.',
            'vision' => 'Mencapai masyarakat Desa Duren yang sehat walafiat, bebas stunting, dengan tingkat kesadaran gizi keluarga yang tinggi.',
            'mission' => "1. Memantau tumbuh kembang balita secara rutin melalui penimbangan bulanan.\n2. Memberikan imunisasi dasar lengkap dan kapsul vitamin A.\n3. Memberikan penyuluhan gizi bagi ibu hamil dan menyusui.\n4. Melaksanakan pemeriksaan kesehatan lansia secara terpadu.",
            'logo' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0813-2233-4455',
            'email' => 'posyandu@duren.desa.id',
            'status' => 'published',
        ]);

        // LINMAS
        $linmas = CommunityInstitution::create([
            'category_id' => $lkdCategory->id,
            'user_id' => $user->id,
            'name' => 'Satuan Perlindungan Masyarakat (LINMAS)',
            'slug' => 'linmas',
            'description' => 'Satuan Perlindungan Masyarakat (Satlinmas) Desa Duren adalah organisasi keamanan desa yang bertugas membantu Kepala Desa dalam menjaga ketenteraman, ketertiban umum, penanggulangan bencana, serta pengamanan kegiatan sosial kemasyarakatan dan pemilu.',
            'vision' => 'Terwujudnya situasi ketertiban, ketenteraman, dan keamanan lingkungan desa yang kondusif, tanggap bencana, dan harmonis.',
            'mission' => "1. Melakukan ronda malam patroli keamanan wilayah secara bergantian.\n2. Siap siaga membantu evakuasi dan mitigasi bencana alam di wilayah lereng Merbabu.\n3. Membantu pengaturan lalu lintas dan keamanan acara sosial kemasyarakatan warga.\n4. Menjaga ketertiban jalannya pesta demokrasi (Pemilu/Pilkades).",
            'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0821-4455-6677',
            'email' => 'linmas@duren.desa.id',
            'status' => 'published',
        ]);

        // 3. Seed Members for Institutions

        // LPMD Members
        CommunityInstitutionMember::create([
            'institution_id' => $lpmd->id,
            'name' => 'Budi Santoso, S.E.',
            'position' => 'Ketua LPMD',
            'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $lpmd->id,
            'name' => 'Rudi Hermawan',
            'position' => 'Sekretaris',
            'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $lpmd->id,
            'name' => 'Siti Aminah',
            'position' => 'Bendahara',
            'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);

        // PKK Members
        CommunityInstitutionMember::create([
            'institution_id' => $pkk->id,
            'name' => 'Sri Wahyuni, S.Pd.',
            'position' => 'Ketua Tim Penggerak PKK',
            'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $pkk->id,
            'name' => 'Dewi Lestari',
            'position' => 'Sekretaris',
            'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $pkk->id,
            'name' => 'Rina Astuti',
            'position' => 'Bendahara',
            'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);

        // Karang Taruna Members
        CommunityInstitutionMember::create([
            'institution_id' => $kt->id,
            'name' => 'Fajar Nugroho',
            'position' => 'Ketua Karang Taruna',
            'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $kt->id,
            'name' => 'Bagus Prasetyo',
            'position' => 'Sekretaris',
            'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $kt->id,
            'name' => 'Indah Permatasari',
            'position' => 'Bendahara',
            'photo' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);

        // Posyandu Members
        CommunityInstitutionMember::create([
            'institution_id' => $posyandu->id,
            'name' => 'dr. Rika Safitri',
            'position' => 'Ketua / Pembina Posyandu',
            'photo' => 'https://images.unsplash.com/photo-1594744803329-e58b31de215f?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $posyandu->id,
            'name' => 'Nining Purwati',
            'position' => 'Sekretaris',
            'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $posyandu->id,
            'name' => 'Tuti Handayani',
            'position' => 'Bendahara / Kader Kesehatan',
            'photo' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);

        // LINMAS Members
        CommunityInstitutionMember::create([
            'institution_id' => $linmas->id,
            'name' => 'Beni Setiawan',
            'position' => 'Ketua / Kasatgas LINMAS',
            'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $linmas->id,
            'name' => 'Joko Susilo',
            'position' => 'Anggota Satlinmas',
            'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $linmas->id,
            'name' => 'Slamet Riyadi',
            'position' => 'Anggota Satlinmas',
            'photo' => 'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);

        // ==========================================
        // SEED ORGANISASI KEMASYARAKATAN (ORMAS)
        // ==========================================

        // 1. MUI Desa Duren
        $mui = CommunityInstitution::create([
            'category_id' => $ormasCategory->id,
            'user_id' => $user->id,
            'name' => 'Majelis Ulama Indonesia (MUI) Desa Duren',
            'slug' => 'mui-desa',
            'description' => 'Majelis Ulama Indonesia (MUI) Desa Duren adalah organisasi kemasyarakatan keagamaan wadah musyawarah para ulama, zuama, dan cendekiawan muslim di Desa Duren untuk membimbing, membina, dan mengayomi umat Islam setempat agar terwujud kerukunan hidup beragama.',
            'vision' => 'Terwujudnya masyarakat Desa Duren yang religius, harmonis, toleran, dan berakhlak mulia di bawah naungan keridaan Allah SWT.',
            'mission' => "1. Memperkuat ukhuwah Islamiyah dan jalinan kerukunan antar umat beragama.\n2. Memberikan bimbingan moral keagamaan dan fatwa kemaslahatan umat.\n3. Membina kerukunan umat beragama demi ketenteraman desa.",
            'logo' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0813-9000-8888',
            'email' => 'mui@duren.desa.id',
            'status' => 'published',
        ]);

        CommunityInstitutionMember::create([
            'institution_id' => $mui->id,
            'name' => 'K.H. Ahmad Dahlan',
            'position' => 'Ketua MUI Desa',
            'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $mui->id,
            'name' => 'Ustadz Nur Hadi',
            'position' => 'Sekretaris',
            'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $mui->id,
            'name' => 'H. Syamsudin',
            'position' => 'Bendahara',
            'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);

        // 2. Duren FC
        $durenfc = CommunityInstitution::create([
            'category_id' => $ormasCategory->id,
            'user_id' => $user->id,
            'name' => 'Klub Sepak Bola Duren FC',
            'slug' => 'duren-fc',
            'description' => 'Duren Football Club (Duren FC) adalah organisasi kemasyarakatan di bidang kepemudaan dan olahraga sepak bola yang didirikan secara swadaya oleh pemuda Desa Duren untuk mengembangkan bakat, meningkatkan kebugaran jasmani, dan membina prestasi olahraga pemuda desa.',
            'vision' => 'Menjadi wadah pembinaan sepak bola usia dini dan pemuda Desa Duren yang berprestasi, sportif, dan berjiwa kepemimpinan.',
            'mission' => "1. Mengadakan latihan rutin mingguan bagi pemuda desa.\n2. Mengikuti turnamen sepak bola tingkat kecamatan maupun kabupaten.\n3. Membina sportivitas dan menjauhkan generasi muda dari pergaulan negatif.",
            'logo' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
            'contact' => '0877-3344-5566',
            'email' => 'durenfc@duren.desa.id',
            'status' => 'published',
        ]);

        CommunityInstitutionMember::create([
            'institution_id' => $durenfc->id,
            'name' => 'Roni Wijaya',
            'position' => 'Ketua / Manajer Duren FC',
            'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 1,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $durenfc->id,
            'name' => 'Coach Gunawan',
            'position' => 'Pelatih Kepala',
            'photo' => 'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 2,
        ]);
        CommunityInstitutionMember::create([
            'institution_id' => $durenfc->id,
            'name' => 'Aris Setiawan',
            'position' => 'Kapten Tim',
            'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80',
            'sort_order' => 3,
        ]);
    }
}
