@extends('layouts.app')

@section('title', 'Profil Desa Duren - Portal Informasi Resmi')

@section('styles')
    <style>
        /* --- PROFILE HERO --- */
        .profile-hero {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
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
            margin-bottom: 60px;
        }

        .profile-section-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 45px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.015), 0 1px 3px rgba(0, 0, 0, 0.01);
            transition: var(--transition);
            margin-bottom: 40px;
        }

        .profile-section-card:hover {
            border-color: rgba(37, 99, 235, 0.15);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
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
            gap: 30px;
        }

        .visi-card,
        .misi-card {
            background: var(--bg-main);
            border-radius: var(--radius-lg);
            padding: 35px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: none;
        }

        .visi-card::before,
        .misi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .visi-card:hover,
        .misi-card:hover {
            transform: translateY(-3px);
            background: var(--white);
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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

        .visi-card h3,
        .misi-card h3 {
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

        .history-layout.no-image {
            display: block;
        }

        .history-img-wrapper {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
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

        .geo-info-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* --- DUSUN BUTTONS & MAPS --- */
        .dusun-buttons-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        .dusun-btn {
            background-color: var(--bg-main);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: var(--transition);
            text-align: left;
        }

        .dusun-btn .dusun-icon {
            font-size: 1.25rem;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .dusun-btn-info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 2px 0;
            transition: var(--transition);
        }

        .dusun-btn-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
            transition: var(--transition);
        }

        .dusun-btn:hover {
            border-color: var(--primary);
            background-color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .dusun-btn:hover .dusun-icon {
            color: var(--primary);
        }

        .dusun-btn.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }

        .dusun-btn.active .dusun-icon,
        .dusun-btn.active .dusun-btn-info h4,
        .dusun-btn.active .dusun-btn-info p {
            color: var(--white);
        }

        .dusun-map-panel {
            background-color: var(--bg-main);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            width: 100%;
            height: 100%;
        }

        .dusun-map-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            color: var(--text-muted);
            text-align: center;
            padding: 40px;
        }

        .dusun-map-placeholder i {
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.8;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @media (max-width: 480px) {
            .dusun-buttons-grid {
                grid-template-columns: 1fr;
            }
        }

        .office-hours-box {
            background: linear-gradient(135deg, #1e3a8a, #172554);
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
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
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .detail-profile-card.no-image {
            grid-template-columns: 1fr;
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

            .history-layout,
            .geografis-layout,
            .detail-profile-card {
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
            .profile-section-card {
                padding: 30px 20px;
            }

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

        /* --- KADES GREETING --- */
        .kades-greeting-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 50px;
            align-items: flex-start;
        }

        .kades-profile-img-wrapper {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
        }

        .kades-profile-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .kades-greeting-layout {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
            }

            .kades-profile-img-wrapper {
                max-width: 200px;
                margin: 0 auto;
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
        <h1>Profil Desa {{ $profile->village_name ?? '' }}</h1>
        <p>Mengenal lebih dekat mengenai Desa Duren Tengaran.</p>
    </section>

    <div class="profile-container">

        @foreach($sectionsOrder as $section)
            @if($section === 'sambutan_kades')
                <!-- SAMBUTAN KEPALA DESA SECTION -->
                @if($profile->publish_headman_greeting ?? true)
                    <section class="profile-section">
                        <div class="profile-section-card">
                            <div class="kades-greeting-layout">
                                <div class="kades-profile-img-wrapper">
                                    @if($profile && $profile->headman_photo)
                                        <img src="{{ Str::startsWith($profile->headman_photo, 'http') ? $profile->headman_photo : asset($profile->headman_photo) }}"
                                            alt="{{ $profile->headman_name }}" class="kades-profile-img">
                                    @else
                                        <div
                                            style="background-color: #e2e8f0; min-height: 250px; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 600;">
                                            [ Foto Kepala Desa ]
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="profile-section-title">Sambutan Kepala Desa</h2>
                                    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px;">
                                        {{ $profile->headman_name ?? '' }}
                                    </h3>
                                    <p style="font-size: 0.95rem; color: var(--primary); font-weight: 600; margin-bottom: 20px;">
                                        Kepala Desa {{ $profile->village_name ?? '' }}
                                    </p>
                                    <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-muted);">
                                        {{ $profile->headman_greeting ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @elseif($section === 'visi_misi')
                <!-- VISI & MISI SECTION -->
                @if($profile->publish_vision_mission ?? true)
                    <section class="profile-section">
                        <div class="profile-section-card">
                            <h2 class="profile-section-title">Visi & Misi</h2>
                            <div class="visi-misi-grid">
                                <!-- Visi Card -->
                                <div class="visi-card">
                                    <div class="card-icon-wrapper">
                                        <i class="fa-solid fa-eye"></i>
                                    </div>
                                    <h3>Visi</h3>
                                    <p class="visi-content">
                                        "{{ $profile->vision ?? '' }}"
                                    </p>
                                </div>

                                <!-- Misi Card -->
                                <div class="misi-card">
                                    <div class="card-icon-wrapper">
                                        <i class="fa-solid fa-bullseye"></i>
                                    </div>
                                    <h3>Misi</h3>
                                    @php
                                        $missions = $profile && $profile->mission ? explode("\n", $profile->mission) : [];
                                    @endphp
                                    <ul class="misi-list">
                                        @foreach($missions as $mission)
                                            @if(trim($mission))
                                                <li>{{ trim(preg_replace('/^\d+\.\s*/', '', $mission)) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @elseif($section === 'sejarah')
                <!-- SEJARAH SECTION -->
                @if($profile->publish_history ?? true)
                    <section class="profile-section">
                        <div class="profile-section-card">
                            <div class="history-layout {{ $profile && $profile->history_image ? '' : 'no-image' }}">
                                @if($profile && $profile->history_image)
                                    <div class="history-img-wrapper">
                                        <img src="{{ asset($profile->history_image) }}"
                                            alt="Sejarah Desa {{ $profile->village_name ?? '' }}" class="history-img">
                                    </div>
                                @endif
                                <div>
                                    <h2 class="profile-section-title">Sejarah Desa</h2>
                                    <div class="history-text">
                                        @if($profile && $profile->history)
                                            {!! nl2br(e($profile->history)) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @elseif($section === 'struktur_organisasi')
                <!-- STRUKTUR ORGANISASI SECTION -->
                @if(($profile->publish_organization_structure ?? true) && ($profile->organization_structure_image ?? false))
                    <section class="profile-section">
                        <div class="profile-section-card" style="text-align: center;">
                            <h2 class="profile-section-title">Struktur Organisasi</h2>
                            <div style="margin-top: 30px;">
                                <img src="{{ asset($profile->organization_structure_image) }}"
                                    alt="Struktur Organisasi Desa {{ $profile->village_name ?? '' }}"
                                    style="max-width: 100%; height: auto; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                            </div>
                        </div>
                    </section>
                @endif
            @elseif($section === 'detail_wilayah')
                <!-- DETAIL PROFIL DESA SECTION -->
                @if($profile->publish_village_detail ?? true)
                    <section class="profile-section">
                        <div class="profile-section-card detail-profile-card {{ (!$profile || !$profile->village_detail_image) ? 'no-image' : '' }}">
                            <div class="detail-profile-left">
                                <h2 class="detail-title">Detail Wilayah & Geografis</h2>
                                <div class="title-underline"></div>
                                @if($villageDetail && ($villageDetail->kecamatan || $villageDetail->kabupaten || $villageDetail->provinsi))
                                    <p class="detail-description">
                                        Desa {{ $profile->village_name ?? '' }} terletak di Kecamatan {{ $villageDetail->kecamatan ?? '' }},
                                        Kabupaten {{ $villageDetail->kabupaten ?? '' }}, Provinsi {{ $villageDetail->provinsi ?? '' }}.
                                    </p>
                                @endif

                                <div class="detail-info-list">
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-house-chimney"></i>
                                            <span class="info-label-text">Nama Desa</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $profile->village_name ?? '' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-building"></i>
                                            <span class="info-label-text">Kecamatan</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->kecamatan ?? '' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-shield-halved"></i>
                                            <span class="info-label-text">Kabupaten</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->kabupaten ?? '' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-map"></i>
                                            <span class="info-label-text">Provinsi</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->provinsi ?? '' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-envelope-open-text"></i>
                                            <span class="info-label-text">Kode Pos</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->zip_code ?? '' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-leaf"></i>
                                            <span class="info-label-text">Luas Wilayah</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $demografi->luas_wilayah->male_count ?? '' }} Ha</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-users"></i>
                                            <span class="info-label-text">Jumlah Penduduk</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">
                                            @if($demografi->total_penduduk)
                                                {{ number_format($demografi->total_penduduk->male_count + $demografi->total_penduduk->female_count, 0, ',', '.') }}
                                                Jiwa
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-sitemap"></i>
                                            <span class="info-label-text">Jumlah Dusun</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->dusun_count ?? '' }} Dusun</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-layer-group"></i>
                                            <span class="info-label-text">Jumlah RW</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->rw_count ?? '' }} RW</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label-wrapper">
                                            <i class="fa-solid fa-people-roof"></i>
                                            <span class="info-label-text">Jumlah RT</span>
                                        </span>
                                        <span class="info-colon">:</span>
                                        <span class="info-value">{{ $villageDetail->rt_count ?? '' }} RT</span>
                                    </div>
                                </div>
                            </div>
                            @if($profile && $profile->village_detail_image)
                            <div class="detail-profile-right">
                                <img src="{{ asset($profile->village_detail_image) }}"
                                    alt="Profil Desa {{ $profile->village_name ?? '' }}" class="detail-profile-img">
                            </div>
                            @endif
                        </div>
                    </section>
                @endif
            @elseif($section === 'geografis_dusun')
                <!-- GEOGRAFIS & WILAYAH DUSUN SECTION -->
                @if($profile->publish_geographics ?? true)
                    <section id="peta-desa" class="profile-section" style="margin-bottom: 0;">
                        <div class="profile-section-card">
                            <h2 class="profile-section-title">Geografis & Wilayah Dusun</h2>
                            <div class="geografis-layout">
                                <!-- Info Grid -->
                                <div class="geo-info-content">
                                    <div>
                                        <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 20px;">
                                            Secara geografis, Desa Duren terletak di Kecamatan Tengaran, Kabupaten Semarang. Desa ini
                                            berada di dataran tinggi yang memiliki suhu udara sejuk dengan tanah subur.
                                        </p>

                                        <h4
                                            style="font-size: 0.9rem; font-weight: 700; color: var(--text-dark); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Pilih Peta Wilayah:</h4>
                                        <div class="dusun-buttons-grid">
                                            <div class="dusun-btn active" data-dusun="all">
                                                <div class="dusun-icon"><i class="fa-solid fa-map"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Semua Wilayah</h4>
                                                    <p>Peta Umum Desa</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Miri" data-map-url="{{ $profile->map_miri ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Miri</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Dukuh" data-map-url="{{ $profile->map_dukuh ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Dukuh</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Krajan" data-map-url="{{ $profile->map_krajan ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Krajan</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Babadan" data-map-url="{{ $profile->map_babadan ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Babadan</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Ngepringan" data-map-url="{{ $profile->map_ngepringan ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Ngepringan</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Tanubayu" data-map-url="{{ $profile->map_tanubayu ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Tanubayu</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Gading" data-map-url="{{ $profile->map_gading ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Gading</h4>
                                                    <p>Klik untuk detail</p>
                                                </div>
                                            </div>
                                            <div class="dusun-btn" data-dusun="Karangwuni" data-map-url="{{ $profile->map_karangwuni ?? '' }}">
                                                <div class="dusun-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="dusun-btn-info">
                                                    <h4>Dusun Karangwuni</h4>
                                                    <p>Klik untuk detail</p>
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
                                            <p>{{ $profile->office_hours ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Google Map Embed & Dusun Map panel -->
                                <div class="map-wrapper" style="min-height: 400px; display: flex; flex-direction: column;">
                                    <!-- Main Village Map -->
                                    <div id="main-village-map" style="width: 100%; height: 100%; min-height: 400px; display: block;">
                                        @if($profile && $profile->google_maps_url)
                                            @php
                                                $mapUrl = $profile->google_maps_url;
                                                if (str_contains($mapUrl, '/maps/d/')) {
                                                    $mapUrl = preg_replace('/\/maps\/d\/(?:u\/\d+\/)?(?:edit|viewer)/', '/maps/d/embed', $mapUrl);
                                                }
                                            @endphp
                                            <iframe src="{{ $mapUrl }}" class="map-frame" allowfullscreen="" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        @else
                                            <div
                                                style="background-color: #cbd5e1; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-weight: 600;">
                                                [ Google Maps Tidak Tersedia ]
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Specific Dusun Map Viewer -->
                                    <div id="dusun-map-viewer" class="dusun-map-panel"
                                        style="display: none; min-height: 400px; padding: 0; overflow: hidden; position: relative;">
                                        <iframe id="dusun-map-iframe" src="" class="map-frame" allowfullscreen="" loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            style="width: 100%; height: 100%; min-height: 400px; border: 0; display: none;">
                                        </iframe>
                                        <div class="dusun-map-placeholder" id="dusun-map-placeholder-box"
                                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%; padding: 40px; text-align: center; margin: auto;">
                                            <i class="fa-solid fa-map-location-dot"
                                                style="font-size: 3rem; color: var(--primary-color); margin-bottom: 15px;"></i>
                                            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin: 0;"
                                                id="dusun-map-title">Peta Dusun Miri</h3>
                                            <p
                                                style="font-size: 0.95rem; color: var(--text-muted); max-width: 320px; margin: 10px 0 0 0;">
                                                [ Placeholder Peta Google Maps Wilayah Dusun Miri ]
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        @endforeach

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.dusun-btn');
                const mainMap = document.getElementById('main-village-map');
                const dusunMap = document.getElementById('dusun-map-viewer');
                const dusunIframe = document.getElementById('dusun-map-iframe');
                const dusunPlaceholder = document.getElementById('dusun-map-placeholder-box');
                const mapTitle = document.getElementById('dusun-map-title');
                const mapDesc = dusunPlaceholder.querySelector('p');

                buttons.forEach(btn => {
                    btn.addEventListener('click', function () {
                        buttons.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        const dusunName = this.getAttribute('data-dusun');
                        let mapUrl = this.getAttribute('data-map-url');

                        if (dusunName === 'all') {
                            // Show main Google Map
                            mainMap.style.display = 'block';
                            dusunMap.style.display = 'none';
                        } else {
                            // Show specific Dusun map panel
                            mainMap.style.display = 'none';
                            dusunMap.style.display = 'flex';

                            if (mapUrl && mapUrl.trim() !== '') {
                                // If My Maps URL, ensure embed format is used
                                if (mapUrl.includes('/maps/d/')) {
                                    mapUrl = mapUrl.replace(/\/maps\/d\/(u\/\d+\/)?(edit|viewer)/, '/maps/d/embed');
                                }
                                // Display iframe with map
                                dusunIframe.src = mapUrl;
                                dusunIframe.style.display = 'block';
                                dusunPlaceholder.style.display = 'none';
                            } else {
                                // Display placeholder text if no map URL
                                dusunIframe.src = '';
                                dusunIframe.style.display = 'none';
                                dusunPlaceholder.style.display = 'flex';
                                mapTitle.textContent = `Peta Dusun ${dusunName}`;
                                mapDesc.textContent = `[ Placeholder Peta Google Maps Wilayah Dusun ${dusunName} ]`;
                            }
                        }
                    });
                });
            });
        </script>
@endsection