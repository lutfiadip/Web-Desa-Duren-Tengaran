@extends('layouts.app')

@section('title', 'Profil Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- PROFILE HERO --- */
    .profile-hero {
        background: linear-gradient(180deg, rgba(5, 46, 22, 0.9) 0%, rgba(5, 46, 22, 0.75) 100%),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .profile-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .profile-hero p {
        font-size: 1.2rem;
        color: #d1d5db;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* --- BREADCRUMB --- */
    .breadcrumb {
        position: absolute;
        top: 30px;
        left: 5%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .breadcrumb a:hover {
        color: var(--accent);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
    }

    /* --- CONTAINER & SECTIONS --- */
    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    .profile-section {
        margin-bottom: 80px;
    }
    
    .profile-section-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 35px;
        position: relative;
        display: inline-block;
    }
    
    .profile-section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 4px;
        background-color: var(--primary);
        border-radius: var(--radius-md);
    }

    /* --- VISI & MISI --- */
    .visi-misi-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 40px;
    }
    
    .visi-card, .misi-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    
    .visi-card::before, .misi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
    }
    
    .visi-card:hover, .misi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .card-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: rgba(45, 106, 50, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }
    
    .card-icon-wrapper i {
        font-size: 1.8rem;
        color: var(--primary);
    }
    
    .visi-card h3, .misi-card h3 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
    }
    
    .visi-content {
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--text-muted);
        font-style: italic;
        font-weight: 500;
    }
    
    .misi-list {
        list-style: none;
    }
    
    .misi-list li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 15px;
        font-size: 1.05rem;
        color: var(--text-muted);
        line-height: 1.6;
    }
    
    .misi-list li::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 3px;
        color: var(--primary);
        font-size: 0.95rem;
    }

    /* --- SEJARAH DESA --- */
    .history-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 50px;
        align-items: center;
    }
    
    .history-img-wrapper {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 400px;
    }
    
    .history-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .history-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-muted);
    }

    /* --- GEOGRAFIS & BATAS --- */
    .geografis-layout {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 50px;
    }
    
    .geo-info-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .batas-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 25px;
        margin-bottom: 35px;
    }
    
    .batas-box {
        background-color: var(--bg-main);
        padding: 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: var(--transition);
    }

    .batas-box:hover {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }
    
    .batas-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: rgba(45, 106, 50, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .batas-content h5 {
        font-size: 0.85rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    
    .batas-content p {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .office-hours-box {
        background: linear-gradient(135deg, #052e16, #022c22);
        color: var(--white);
        padding: 25px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: auto;
    }
    
    .office-hours-icon {
        font-size: 2.2rem;
        color: var(--accent);
    }
    
    .office-hours-content h4 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .office-hours-content p {
        font-size: 0.95rem;
        color: #cbd5e1;
    }
    
    .map-wrapper {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 100%;
        min-height: 450px;
        border: 1px solid var(--border-color);
    }
    
    .map-frame {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* --- DETAIL PROFILE CARD --- */
    .detail-profile-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 50px;
        align-items: center;
    }
    
    .detail-profile-left {
        display: flex;
        flex-direction: column;
    }
    
    .detail-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 5px;
    }
    
    .title-underline {
        width: 35px;
        height: 3px;
        background-color: var(--primary);
        border-radius: 2px;
        margin-bottom: 25px;
    }
    
    .detail-description {
        color: var(--text-muted);
        font-size: 1.05rem;
        line-height: 1.7;
        margin-bottom: 30px;
    }
    
    .detail-info-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 35px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        font-size: 1rem;
        line-height: 1.5;
    }
    
    .info-label-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 180px;
        color: var(--text-dark);
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .info-label-wrapper i {
        color: var(--primary);
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }
    
    .info-colon {
        width: 20px;
        color: var(--text-muted);
        font-weight: 600;
        text-align: center;
        flex-shrink: 0;
    }
    
    .info-value {
        color: var(--text-dark);
        font-weight: 700;
    }
    
    .btn-map-link {
        align-self: flex-start;
        padding: 12px 25px;
        background-color: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: var(--transition);
    }
    
    .btn-map-link:hover {
        background-color: var(--primary);
        color: var(--white);
    }
    
    .detail-profile-right {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        height: 100%;
        min-height: 450px;
    }
    
    .detail-profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 1024px) {
        .history-layout, .geografis-layout, .detail-profile-card {
            grid-template-columns: 1fr;
        }
        
        .history-img-wrapper {
            height: 300px;
        }
        
        .map-wrapper {
            min-height: 350px;
            height: 350px;
        }

        .detail-profile-card {
            gap: 40px;
        }
        
        .detail-profile-right {
            min-height: 300px;
            height: 300px;
        }
    }
    
    @media (max-width: 768px) {
        .visi-misi-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-hero h1 {
            font-size: 2.4rem;
        }
        
        .batas-grid {
            grid-template-columns: 1fr;
        }

        .info-item {
            flex-wrap: wrap;
        }
        
        .info-label-wrapper {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .info-colon {
            display: none;
        }
        
        .info-value {
            padding-left: 32px;
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

    <!-- HERO SECTION -->
    <section class="profile-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Profil Desa</span>
        </nav>
        <h1>Profil Desa {{ $profile->village_name ?? 'Duren' }}</h1>
        <p>Mengenal lebih dekat sejarah, visi misi, tata geografis, dan komitmen pelayanan Pemerintah Desa Duren Tengaran.</p>
    </section>

    <div class="profile-container">

        <!-- VISI & MISI SECTION -->
        <section class="profile-section">
            <h2 class="profile-section-title">Visi & Misi</h2>
            <div class="visi-misi-grid">
                <!-- Visi Card -->
                <div class="visi-card">
                    <div class="card-icon-wrapper">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3>Visi</h3>
                    <p class="visi-content">
                        "{{ $profile->vision ?? 'Terwujudnya Desa Duren yang Mandiri, Sejahtera, Transparan, dan Berdaya Saing Tinggi melalui Optimalisasi Potensi Lokal dan Pelayanan Prima.' }}"
                    </p>
                </div>
                
                <!-- Misi Card -->
                <div class="misi-card">
                    <div class="card-icon-wrapper">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3>Misi</h3>
                    @php
                        $missions = explode("\n", $profile->mission ?? '');
                    @endphp
                    <ul class="misi-list">
                        @forelse($missions as $mission)
                            @if(trim($mission))
                                <li>{{ trim(preg_replace('/^\d+\.\s*/', '', $mission)) }}</li>
                            @endif
                        @empty
                            <li>Mewujudkan tata kelola pemerintahan desa yang bersih, transparan, dan akuntabel.</li>
                            <li>Meningkatkan pelayanan publik berbasis teknologi informasi yang cepat dan ramah.</li>
                            <li>Mengembangkan perekonomian warga melalui pemberdayaan UMKM, pertanian, dan peternakan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </section>

        <!-- SEJARAH SECTION -->
        <section class="profile-section" style="border-top: 1px solid var(--border-color); padding-top: 60px;">
            <div class="history-layout">
                <div class="history-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         alt="Pertanian Desa Duren" class="history-img">
                </div>
                <div>
                    <h2 class="profile-section-title">Sejarah Desa</h2>
                    <div class="history-text">
                        <p style="margin-bottom: 20px;">
                            {{ $profile->history ?? 'Desa Duren memiliki sejarah panjang yang kaya akan nilai budaya. Nama \'Duren\' diyakini berasal dari melimpahnya pohon durian di wilayah ini pada masa lampau, yang menjadi penanda khas bagi para pendatang. Seiring berjalannya waktu, Desa Duren bertransformasi dari kawasan agraris tradisional menjadi desa yang berkembang menuju kemandirian ekonomi.' }}
                        </p>
                        <p>
                            Melalui semangat gotong royong warga, desa ini berhasil mengintegrasikan sektor pertanian, peternakan, dan UMKM lokal sebagai pilar ekonomi utama. Kini Pemerintah Desa terus berupaya mengadopsi kemajuan teknologi untuk meningkatkan pelayanan masyarakat dan transparansi informasi demi terwujudnya kemakmuran bersama yang berkesinambungan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- DETAIL PROFIL DESA SECTION -->
        <section class="profile-section" style="border-top: 1px solid var(--border-color); padding-top: 60px;">
            <div class="detail-profile-card">
                <div class="detail-profile-left">
                    <h2 class="detail-title">Profil Desa</h2>
                    <div class="title-underline"></div>
                    <p class="detail-description">
                        Desa Duren terletak di Kecamatan Tengaran, Kabupaten Semarang, Provinsi Jawa Tengah. Desa ini memiliki potensi sumber daya alam yang melimpah serta masyarakat yang guyub dan berbudaya.
                    </p>
                    
                    <div class="detail-info-list">
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-house-chimney"></i>
                                <span class="info-label-text">Nama Desa</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">{{ $profile->village_name ?? 'Duren' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-building"></i>
                                <span class="info-label-text">Kecamatan</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">Tengaran</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span class="info-label-text">Kabupaten</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">Semarang</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-map"></i>
                                <span class="info-label-text">Provinsi</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">Jawa Tengah</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-envelope-open-text"></i>
                                <span class="info-label-text">Kode Pos</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">50775</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-leaf"></i>
                                <span class="info-label-text">Luas Wilayah</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">{{ $demografi->luas_wilayah->male_count ?? '350' }} Ha</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-users"></i>
                                <span class="info-label-text">Jumlah Penduduk</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">
                                @if($demografi->total_penduduk)
                                    {{ number_format($demografi->total_penduduk->male_count + $demografi->total_penduduk->female_count, 0, ',', '.') }} Jiwa
                                @else
                                    2.450 Jiwa
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label-wrapper">
                                <i class="fa-solid fa-sitemap"></i>
                                <span class="info-label-text">Jumlah Dusun</span>
                            </span>
                            <span class="info-colon">:</span>
                            <span class="info-value">4 Dusun</span>
                        </div>
                    </div>
                    
                    <a href="#peta-desa" class="btn-map-link">
                        <i class="fa-solid fa-location-dot"></i> Lihat Peta Desa
                    </a>
                </div>
                <div class="detail-profile-right">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                         alt="Profil Desa Duren" class="detail-profile-img">
                </div>
            </div>
        </section>

        <!-- GEOGRAFIS SECTION -->
        <section id="peta-desa" class="profile-section" style="border-top: 1px solid var(--border-color); padding-top: 60px; margin-bottom: 0;">
            <h2 class="profile-section-title">Geografis & Batas Wilayah</h2>
            <div class="geografis-layout">
                <!-- Info Grid -->
                <div class="geo-info-card">
                    <div>
                        <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 10px;">
                            Secara geografis, Desa Duren terletak di Kecamatan Tengaran, Kabupaten Semarang. Desa ini berada di dataran tinggi yang memiliki suhu udara sejuk dengan tanah subur yang mendukung sektor pertanian dan peternakan.
                        </p>
                        
                        <div class="batas-grid">
                            <div class="batas-box">
                                <div class="batas-icon"><i class="fa-solid fa-arrow-up"></i></div>
                                <div class="batas-content">
                                    <h5>Batas Utara</h5>
                                    <p>Desa Patemon</p>
                                </div>
                            </div>
                            <div class="batas-box">
                                <div class="batas-icon"><i class="fa-solid fa-arrow-right"></i></div>
                                <div class="batas-content">
                                    <h5>Batas Timur</h5>
                                    <p>Desa Karangduren</p>
                                </div>
                            </div>
                            <div class="batas-box">
                                <div class="batas-icon"><i class="fa-solid fa-arrow-down"></i></div>
                                <div class="batas-content">
                                    <h5>Batas Selatan</h5>
                                    <p>Desa Barukan</p>
                                </div>
                            </div>
                            <div class="batas-box">
                                <div class="batas-icon"><i class="fa-solid fa-arrow-left"></i></div>
                                <div class="batas-content">
                                    <h5>Batas Barat</h5>
                                    <p>Desa Klero</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Office Hours -->
                    <div class="office-hours-box">
                        <div class="office-hours-icon">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="office-hours-content">
                            <h4>Jam Pelayanan Kantor Desa</h4>
                            <p>{{ $profile->office_hours ?? 'Senin - Kamis (08.00 - 15.00 WIB) | Jumat (08.00 - 11.30 WIB)' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Google Map Embed -->
                <div class="map-wrapper">
                    @if($profile && $profile->google_maps_url)
                        <iframe src="{{ $profile->google_maps_url }}" 
                                class="map-frame" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @else
                        <div style="background-color: #cbd5e1; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 600;">
                            [ Google Maps Tidak Tersedia ]
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </div>

@endsection
