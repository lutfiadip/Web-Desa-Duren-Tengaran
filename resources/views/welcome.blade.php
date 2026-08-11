@extends('layouts.app')

@section('title', 'Portal Informasi Desa Duren Tengaran')

@section('styles')
<style>

        /* --- HERO SECTION --- */
        .hero {
            /* Dark gradient on the left, fading to right. Background image of agriculture/village */
            background: linear-gradient(90deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.7) 45%, rgba(15, 23, 42, 0.2) 100%),
                url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
            min-height: calc(100vh - 80px);
            /* Adjusted for solid header */
            display: flex;
            align-items: center;
            padding: 80px 5% 120px 5%;
            /* Added top & bottom padding to expand height */
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            color: var(--white);
            /* Removed margin-top since header is now solid */
        }

        .badge-outline {
            display: inline-flex;
            align-items: center;
            padding: 8px 24px;
            border-radius: var(--radius-pill);
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--accent);
            border: 1px solid var(--accent);
            margin-bottom: 25px;
        }

        .hero-title-wrapper {
            margin-bottom: 25px;
            text-align: left;
            /* Ensure it is left-aligned */
        }

        .hero-subtitle {
            font-size: 1rem;
            /* Reduced size */
            font-weight: 800;
            color: var(--white);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .hero-main-title {
            font-size: 3.8rem;
            /* Reduced size */
            font-weight: 900;
            line-height: 1.1;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: var(--white);
        }

        .hero-location {
            font-size: 1rem;
            /* Reduced size */
            font-weight: 600;
            color: var(--white);
        }

        .hero p {
            font-size: 1.1rem;
            color: #d1d5db;
            /* Light gray */
            margin-bottom: 40px;
            max-width: 600px;
            line-height: 1.7;
            text-align: left;
            /* Left align text */
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: flex-start;
            /* Align left */
        }

        .btn-solid {
            background-color: var(--primary);
            color: var(--white);
            padding: 12px 25px;
            /* Reduced padding */
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            /* Reduced font size */
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            border: none;
        }

        .btn-solid i {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .btn-solid:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--accent);
            padding: 12px 25px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            border: 2px solid var(--accent);
        }

        .btn-outline i {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .btn-outline:hover {
            background-color: rgba(250, 204, 21, 0.1);
            color: var(--primary);
        }

        /* --- DEMOGRAPHICS OVERLAY (Right Side Floating) --- */
        .demographics-section {
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 210px;
            /* Reduced width */
        }

        .demographics-row {
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Reduced gap */
        }

        .demo-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            text-align: left;
            background: var(--accent);
            /* Bright yellow */
            padding: 12px 15px;
            /* Reduced padding */
            border-radius: var(--radius-md);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Slightly smaller shadow */
            transition: var(--transition);
            border: 2px solid rgba(255, 255, 255, 0.2);
            gap: 12px;
            /* Reduced gap */
        }

        .demo-item:hover {
            transform: translateY(-5px);
        }

        .demo-icon {
            font-size: 1.4rem;
            color: #713f12;
            transition: var(--transition);
            width: 35px;
            text-align: center;
        }

        .demo-item:hover .demo-icon {
            transform: scale(1.1);
        }

        .demo-content {
            display: flex;
            flex-direction: column;
        }

        .demo-number {
            font-size: 1.05rem;
            /* Reduced number size */
            font-weight: 800;
            color: #713f12;
            line-height: 1.2;
            margin-top: 2px;
        }

        .demo-label {
            font-weight: 700;
            font-size: 0.7rem;
            /* Reduced label size */
            text-transform: capitalize;
            color: #854d0e;
        }

        /* --- WELCOME SECTION (NEW LAYOUT) --- */
        .welcome-section {
            padding: 40px 5%;
            background-color: var(--bg-main);
            display: flex;
            justify-content: center;
        }

        .welcome-grid {
            max-width: 1400px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 50px;
            align-items: center;
        }

        /* Col 1 */
        .welcome-col-image {
            height: 100%;
        }
        .balai-desa-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-height: 300px;
        }

        /* Col 2 */
        .welcome-col-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 15px;
            padding: 20px 0;
        }

        .section-badge {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            margin-bottom: 5px;
            display: inline-block;
            align-self: flex-start;
        }
        .section-badge::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 3px;
            background-color: var(--primary);
            border-radius: 2px;
        }

        .welcome-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
            margin-top: 10px;
        }

        .welcome-col-text p {
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .welcome-btn {
            align-self: flex-start;
            padding: 12px 25px;
            background-color: var(--primary); 
            color: white;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            font-size: 0.95rem;
            border: none;
        }
        .welcome-btn:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Col 3 */
        .welcome-col-card {
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .btn-small {
            padding: 10px 20px;
            font-size: 0.85rem;
        }

        @media (max-width: 1024px) {
            .welcome-grid {
                grid-template-columns: 1fr;
            }
            .balai-desa-img {
                height: 300px;
            }
        }

        /* --- HORIZONTAL SCROLL FOR UMKM --- */
        .umkm-scroll {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            padding-bottom: 20px;
            scroll-snap-type: x mandatory;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .umkm-scroll::-webkit-scrollbar {
            display: none;
        }
        .umkm-scroll .info-card {
            flex: 0 0 350px;
            scroll-snap-align: start;
        }
        @media (max-width: 768px) {
            .section-card {
                padding: 30px 20px;
            }
            .umkm-scroll .info-card {
                flex: 0 0 280px;
            }
        }

        /* --- SECTIONS --- */
        .section {
            padding: 30px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 45px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.015), 0 1px 3px rgba(0, 0, 0, 0.01);
            transition: var(--transition);
        }

        .section-card:hover {
            border-color: rgba(37, 99, 235, 0.15);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-subtitle {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        /* --- GRID & CARDS --- */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        /* Clean Information Cards */
        .info-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border: 1px solid var(--border-color);
            border-bottom: 4px solid var(--primary);
            display: flex;
            flex-direction: column;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .card-content {
            padding: 30px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card-meta span.tag {
            color: #854d0e;
            background: var(--accent);
            padding: 5px 12px;
            border-radius: 4px;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .card-desc {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        /* UMKM Social Links */
        .umkm-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: auto;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-wa {
            background-color: #25d366;
            color: var(--white);
        }

        .btn-wa:hover {
            background-color: #128c7e;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
        }

        .btn-ig {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            color: var(--white);
        }

        .btn-ig:hover {
            opacity: 0.9;
            box-shadow: 0 4px 12px rgba(220, 39, 67, 0.2);
        }

        .btn-fb {
            background-color: #1877f2;
            color: var(--white);
        }

        .btn-fb:hover {
            background-color: #0d65d9;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.2);
        }

        .btn-maps {
            background-color: #f1f5f9;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .btn-maps:hover {
            background-color: #e2e8f0;
        }

        .card-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            font-size: 1.05rem;
        }

        .card-action:hover {
            color: var(--primary-hover);
        }

        .card-action i {
            background: var(--primary);
            color: var(--white);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .hero-actions {
            margin-top: 40px;
            margin-bottom: 60px;
            /* Added space to avoid collision with overlapping cards */
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* --- GALLERY GRID --- */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-md);
            height: 250px;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }

        /* --- QUICK INFO GRID --- */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        @media (max-width: 1024px) {
            .quick-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .quick-grid {
                grid-template-columns: 1fr;
            }
        }

        .quick-box {
            background: var(--bg-main);
            padding: 30px 20px;
            border-radius: var(--radius-lg);
            text-align: center;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .quick-box:hover {
            background: var(--white);
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .quick-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .quick-box h3 {
            font-size: 1.2rem;
            color: var(--text-dark);
            margin-bottom: 10px;
        }


    </style>
@endsection

@section('content')


    <!-- HERO SECTION (Ecoland Layout Match) -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-title-wrapper">
                <div class="hero-subtitle">WEBSITE RESMI</div>
                <h1 class="hero-main-title">
                    DESA DUREN
                </h1>
                <div class="hero-location">Kecamatan Tengaran, Kabupaten Semarang</div>
            </div>

            <p>
                Selamat datang di situs resmi Pemerintah Desa Duren Tengaran. Temukan
                informasi demografi, regulasi desa, serta berita terkini secara terbuka
                dan mudah diakses oleh seluruh elemen masyarakat.
            </p>
            <div class="hero-buttons">
                <a href="#berita" class="btn-solid">
                    Kabar Terbaru <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('statistics') }}" class="btn-outline">
                    Akses Data <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- DEMOGRAPHICS (Right Side Floating) -->
        @if($profile->publish_statistics ?? true)
        <div class="demographics-section">
            <div class="demographics-row">
                <div class="demo-item">
                    <i class="fa-solid fa-users demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Total Penduduk</div>
                        <div class="demo-number">
                            @if(isset($populationGender) && $populationGender->details->count() > 0)
                                {{ number_format($populationGender->details->first()->male_total + $populationGender->details->first()->female_total, 0, ',', '.') }}
                            @elseif($demografi->total_penduduk)
                                {{ number_format($demografi->total_penduduk->male_count + $demografi->total_penduduk->female_count, 0, ',', '.') }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-house-chimney demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Rukun Tetangga</div>
                        <div class="demo-number">{{ $villageDetail->rt_count ?? '' }}</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-building demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Rukun Warga</div>
                        <div class="demo-number">{{ $villageDetail->rw_count ?? '' }}</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-map-location-dot demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Luas Wilayah</div>
                        <div class="demo-number">{{ $demografi->luas_wilayah->male_count ?? '' }} Ha</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>

    @foreach($sectionsOrder as $section)
        @if($section === 'about')
            <!-- SAMBUTAN KEPALA DESA SECTION -->
            @if($profile->publish_about ?? true)
            <section class="welcome-section" style="padding: 20px 5%;">
                <div class="section-card" style="width: 100%; max-width: 1400px; margin: 0 auto;">
                    <div class="welcome-grid">
                        <!-- Col 1: Balai Desa Image -->
                        <div class="welcome-col-image">
                            @if($profile && $profile->about_image)
                                <img src="{{ asset($profile->about_image) }}" alt="Balai Desa {{ $profile->village_name ?? '' }}" class="balai-desa-img">
                            @else
                                <div class="balai-desa-img" style="background-color: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 600; text-align: center; padding: 20px;">
                                    [ Tempat Foto Balai Desa ]
                                </div>
                            @endif
                        </div>
                        
                        <!-- Col 2: Tentang Desa Text -->
                        <div class="welcome-col-text">
                            <div class="section-badge">{{ $profile->about_subtitle ?? 'TENTANG DESA' }}</div>
                            <h2 class="welcome-title">Desa {{ $profile->village_name ?? '' }}</h2>
                            <p>{{ $profile->about_text ?? '' }}</p>
                            <a href="{{ route('profile') }}" class="welcome-btn">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </section>
            @endif
        @elseif($section === 'potency')
            <!-- POTENSI DESA -->
            @if(($profile->show_potency_on_home ?? true) && (($profile->publish_agriculture ?? true) || ($profile->publish_umkm ?? true) || ($profile->publish_tourism ?? true)))
            <section id="potensi" class="section">
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <span class="section-subtitle">{{ $profile->potency_subtitle ?? 'Potensi Desa' }}</span>
                        <h2 class="section-title">{{ $profile->potency_title ?? 'Kekayaan & Komoditas Unggulan' }}</h2>
                    </div>
            
                    <div class="quick-grid" style="margin-top: 0;">
                        @if($profile->publish_agriculture ?? true)
                        <a href="{{ route('potensi.agriculture') }}" style="text-decoration: none;">
                            <div class="quick-box">
                                <i class="fa-solid fa-wheat-awn quick-icon"></i>
                                <h3>Pertanian</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_agriculture_desc ?? 'Lahan subur dengan komoditas unggulan padi dan palawija.' }}</p>
                            </div>
                        </a>
                        <a href="{{ route('potensi.agriculture') }}" style="text-decoration: none;">
                            <div class="quick-box">
                                <i class="fa-solid fa-cow quick-icon"></i>
                                <h3>Peternakan</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_animal_husbandry_desc ?? 'Pusat pengembangan hewan ternak seperti sapi dan kambing.' }}</p>
                            </div>
                        </a>
                        @endif

                        @if($profile->publish_umkm ?? true)
                        <a href="{{ route('umkm') }}" style="text-decoration: none;">
                            <div class="quick-box">
                                <i class="fa-solid fa-shop quick-icon"></i>
                                <h3>UMKM</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_umkm_desc ?? 'Produk kerajinan dan makanan khas hasil karya warga desa.' }}</p>
                            </div>
                        </a>
                        @endif

                        @if($profile->publish_tourism ?? true)
                        <a href="{{ route('tourism') }}" style="text-decoration: none;">
                            <div class="quick-box">
                                <i class="fa-solid fa-mountain-sun quick-icon"></i>
                                <h3>Pariwisata</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_tourism_desc ?? 'Pesona alam asri yang menarik bagi wisatawan lokal.' }}</p>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </section>
            @endif
        @elseif($section === 'umkm')
            <!-- UMKM UNGGULAN -->
            @if(($profile->show_umkm_on_home ?? true) && ($profile->publish_umkm ?? true))
            <section id="umkm" class="section">
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <span class="section-subtitle">{{ $profile->umkm_subtitle ?? 'Produk Lokal' }}</span>
                        <h2 class="section-title">{{ $profile->umkm_title ?? 'UMKM Unggulan Desa' }}</h2>
                    </div>
            
                    <div class="umkm-scroll" style="padding-bottom: 0;">
                        @foreach($umkms as $umkm)
                        <div class="info-card">
                            <a href="{{ route('umkm.detail', $umkm->slug) }}" style="display: block;">
                                <img src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset('storage/' . $umkm->thumbnail) }}"
                                    alt="{{ $umkm->title }}" class="card-img">
                            </a>
                            <div class="card-content">
                                <div class="card-meta">
                                    <span class="tag" style="background-color: #fef3c7; color: #d97706;">{{ $umkm->category->name ?? 'UMKM' }}</span>
                                </div>
                                <a href="{{ route('umkm.detail', $umkm->slug) }}" style="text-decoration: none; color: inherit;">
                                    <h3 class="card-title">{{ $umkm->title }}</h3>
                                </a>
                                <p class="card-desc">{{ $umkm->description }}</p>
                                <div class="umkm-actions">
                                    @if($umkm->whatsapp)
                                        <a href="https://wa.me/{{ $umkm->whatsapp }}?text=Halo%20{{ rawurlencode($umkm->owner_name) }},%20saya%20tertarik%20dengan%20produk%20{{ rawurlencode($umkm->title) }}%20yang%20saya%20lihat%20di%20Website%20Resmi%20Desa%20Duren." 
                                           target="_blank" class="action-btn btn-wa">
                                            <i class="fa-brands fa-whatsapp"></i> WA
                                        </a>
                                    @endif
                                    
                                    @if($umkm->instagram)
                                        <a href="https://instagram.com/{{ $umkm->instagram }}" target="_blank" class="action-btn btn-ig">
                                            <i class="fa-brands fa-instagram"></i> IG
                                        </a>
                                    @endif

                                    @if($umkm->facebook)
                                        <a href="https://facebook.com/{{ $umkm->facebook }}" target="_blank" class="action-btn btn-fb">
                                            <i class="fa-brands fa-facebook-f"></i> FB
                                        </a>
                                    @endif

                                    @if($umkm->google_maps_url)
                                        <a href="{{ $umkm->google_maps_url }}" target="_blank" class="action-btn btn-maps">
                                            <i class="fa-solid fa-location-dot"></i> Maps
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div style="text-align: center; margin-top: 40px;">
                        <a href="{{ route('umkm') }}" class="btn-solid">
                            Lihat Semua UMKM <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </section>
            @endif
        @elseif($section === 'news')
            <!-- BERITA & PENGUMUMAN -->
            @if(($profile->show_news_on_home ?? true) && ($profile->publish_news ?? true))
            <section id="berita" class="section">
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <span class="section-subtitle">{{ $profile->news_subtitle ?? 'Kabar Terkini' }}</span>
                        <h2 class="section-title">{{ $profile->news_title ?? 'Berita & Pengumuman' }}</h2>
                    </div>
            
                    <div class="grid-3">
                        @foreach($news as $item)
                        <div class="info-card">
                            <img src="{{ Str::startsWith($item->featured_image, 'http') ? $item->featured_image : asset($item->featured_image) }}"
                                alt="{{ $item->title }}" class="card-img">
                            <div class="card-content">
                                <div class="card-meta">
                                    <span class="tag">{{ $item->category->name ?? 'Berita' }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</span>
                                </div>
                                <h3 class="card-title">{{ $item->title }}</h3>
                                <p class="card-desc">{{ $item->excerpt ?? Str::limit(strip_tags($item->content), 120) }}</p>
                                <a href="{{ route('news.detail', $item->slug) }}" class="card-action">Baca Berita <i><i class="fa-solid fa-chevron-right"></i></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        @elseif($section === 'gallery')
            <!-- GALERI DESA -->
            @if($profile->show_gallery_on_home ?? true)
            <section id="galeri" class="section">
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <span class="section-subtitle">{{ $profile->gallery_subtitle ?? 'Pesona Desa' }}</span>
                        <h2 class="section-title">{{ $profile->gallery_title ?? 'Galeri Desa' }}</h2>
                    </div>
                    <div class="gallery-grid">
                        @foreach($galleries as $gallery)
                        <div class="gallery-item">
                            <img src="{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption ?? 'Galeri Desa' }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        @endif
    @endforeach

@endsection