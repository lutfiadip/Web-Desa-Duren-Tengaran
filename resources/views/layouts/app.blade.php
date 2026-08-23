@php
    $activeAlerts = \App\Models\Announcement::active()->where('is_alert', true)->latest()->get();
    $hasAlert = $activeAlerts->isNotEmpty();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Informasi Desa Duren Tengaran')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Colors based on Blue & White modern layout */
            --primary: #2563eb;
            /* Sapphire Blue */
            --primary-hover: #1d4ed8;
            --accent: #f59e0b;
            /* Amber Gold */
            --accent-hover: #d97706;

            --text-dark: #1e293b;
            --text-muted: #475569;
            --bg-main: #f8fafc;
            --white: #ffffff;
            --border-color: #e2e8f0;

            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-pill: 9999px;

            --transition: all 0.3s ease;
            --alert-height: {{ $hasAlert ? '44px' : '0px' }};
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex-grow: 1;
        }

        /* --- HEADER (Solid Navy) --- */
        header {
            position: fixed;
            /* Changed to fixed so hero goes underneath */
            top: var(--alert-height, 0px);
            left: 0;
            width: 100%;
            background-color: #1e3a8a;
            /* Same as footer */
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            /* Increased z-index */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.4s ease, box-shadow 0.4s ease, padding 0.4s ease;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            color: var(--text-dark);
            text-decoration: none;
        }

        .logo-img {
            height: 55px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-title {
            font-size: 1.3rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: 0.5px;
            color: var(--white);
        }

        .logo-subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: 0.5px;
            color: #d1d5db;
        }

        /* Menu Button */
        .menu-btn {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.7);
            color: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .menu-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
        }

        /* Overlay Menu */
        .overlay-menu {
            position: fixed;
            top: 0;
            right: -100%;
            /* Hidden by default */
            width: 350px;
            height: 100vh;
            background-color: #1e3a8a;
            z-index: 2000;
            padding: 80px 40px;
            transition: right 0.4s ease;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
        }

        .overlay-menu.active {
            right: 0;
            /* Slide in */
        }

        .overlay-menu .close-btn {
            position: absolute;
            top: 20px;
            right: 25px;
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1.8rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .overlay-menu .close-btn:hover {
            color: var(--accent);
            transform: scale(1.1);
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            list-style: none;
            align-items: flex-start;
        }

        .nav-links>li {
            width: 100%;
        }

        .nav-links>li>a {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.2rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 0;
            justify-content: space-between;
        }

        .nav-links>li>a:hover,
        .nav-links>li>a.active {
            color: var(--accent);
        }

        /* Dropdown Styles in Overlay */
        .dropdown {
            position: relative;
            width: 100%;
        }

        .dropdown-menu {
            display: none;
            flex-direction: column;
            gap: 10px;
            padding-left: 15px;
            margin-top: 15px;
            border-left: 2px solid rgba(255, 255, 255, 0.2);
            list-style: none;
        }

        .dropdown.active .dropdown-menu {
            display: flex;
        }

        .dropdown-menu a {
            color: #cbd5e1;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            display: block;
        }

        .dropdown-menu a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        /* Search Modal */
        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(15, 23, 42, 0.95);
            z-index: 2050;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .search-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .search-modal .close-btn {
            position: absolute;
            top: 30px;
            right: 40px;
            background: transparent;
            border: none;
            color: var(--white);
            font-size: 2.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-modal .close-btn:hover {
            color: var(--accent);
            transform: scale(1.1);
        }

        .search-form {
            width: 80%;
            max-width: 800px;
            position: relative;
        }

        .search-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 3px solid rgba(255, 255, 255, 0.3);
            color: var(--white);
            font-size: 3rem;
            padding: 10px 0;
            padding-right: 60px;
            font-weight: 700;
            outline: none;
            transition: var(--transition);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .search-input:focus {
            border-bottom-color: var(--accent);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .search-submit {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 2rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-submit:hover {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .search-input {
                font-size: 2rem;
            }

            .search-modal .close-btn {
                top: 20px;
                right: 20px;
                font-size: 2rem;
            }
        }

        /* Mobile Overlay Adjustment */
        @media (max-width: 576px) {
            .overlay-menu {
                width: 100%;
                /* Full screen on mobile */
            }
        }

        /* --- BUTTONS --- */
        .btn-solid {
            background-color: var(--primary);
            color: var(--white);
            padding: 12px 25px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-solid i {
            color: var(--accent);
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .btn-solid:hover {
            background-color: var(--primary-hover);
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
        }

        .btn-solid:hover i {
            transform: translateX(6px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--accent);
            padding: 12px 25px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            border: 2px solid var(--accent);
            cursor: pointer;
        }

        .btn-outline i {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .btn-outline:hover {
            background-color: rgba(250, 204, 21, 0.1);
            color: var(--white);
        }

        /* --- FOOTER --- */
        footer {
            background-color: #1e3a8a;
            color: #94a3b8;
            padding: 80px 5% 40px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 50px;
            max-width: 1400px;
            margin: 0 auto;
            margin-bottom: 60px;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-brand i {
            color: var(--accent);
        }

        .footer-col h4 {
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 15px;
        }

        .footer-col ul li a {
            color: #94a3b8;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--accent);
        }

        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            header {
                background: #1e3a8a;
                padding: 1rem 5%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        /* --- ANNOUNCEMENT ALERT MARQUEE --- */
        .announcement-alert-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--alert-height);
            background-color: var(--accent);
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            font-weight: 700;
            font-size: 0.9rem;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .alert-marquee-container {
            flex-grow: 1;
            overflow: hidden;
            display: flex;
            align-items: center;
            margin: 0 15px;
        }

        .alert-marquee-text {
            display: inline-block;
            white-space: nowrap;
            padding-left: 100%;
            animation: alertMarquee 25s linear infinite;
        }

        .alert-marquee-text a {
            color: #0f172a;
            text-decoration: none;
            margin-right: 50px;
            font-weight: 800;
            transition: var(--transition);
        }

        .alert-marquee-text a:hover {
            color: var(--primary);
        }

        .alert-close-btn {
            background: none;
            border: none;
            font-size: 1.4rem;
            font-weight: 800;
            cursor: pointer;
            color: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            line-height: 1;
            transition: var(--transition);
        }

        .alert-close-btn:hover {
            transform: scale(1.15);
            color: #ef4444;
        }

        @keyframes alertMarquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }
    </style>
    @yield('styles')
</head>

<body>

    @if($hasAlert)
        <div id="announcement-alert-banner" class="announcement-alert-bar">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-bullhorn" style="font-size: 1.1rem; color: #1e3a8a;"></i>
                <span style="font-size: 0.75rem; background: #1e3a8a; color: white; padding: 2px 8px; border-radius: 4px; font-weight: 800; letter-spacing: 0.5px; white-space: nowrap;">PENGUMUMAN PENTING:</span>
            </div>
            <div class="alert-marquee-container">
                <div class="alert-marquee-text">
                    @foreach($activeAlerts as $alert)
                        <a href="{{ route('announcements.detail', $alert->slug) }}">{{ $alert->title }} &bull; </a>
                    @endforeach
                </div>
            </div>
            <button class="alert-close-btn" onclick="dismissAlertBanner()">&times;</button>
        </div>
    @endif

    <!-- HEADER -->
    <header class="{{ request()->routeIs('home') ? 'header-transparent' : '' }}" id="main-header">
        <a href="{{ route('home') }}" class="logo-wrapper">
            <img src="{{ asset('img/logo-semarang.png') }}" alt="Logo Kab Semarang" class="logo-img">
            <div class="logo-text">
                <span class="logo-title">DESA DUREN</span>
                <span class="logo-subtitle">KECAMATAN TENGARAN<br>KABUPATEN SEMARANG</span>
            </div>
        </a>

        <div class="header-actions" style="display: flex; gap: 15px; align-items: center;">
            <!-- Search Toggle Button -->
            <button id="search-toggle" class="menu-btn" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <!-- Menu Toggle Button -->
            <button id="menu-toggle" class="menu-btn" aria-label="Menu">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>

        <!-- Overlay Menu -->
        <div id="overlay-menu" class="overlay-menu">
            <button id="menu-close" class="close-btn" aria-label="Close Menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                </li>
                @if($profile->publish_profile ?? true)
                    <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile*') ? 'active' : '' }}">Profil
                            Desa</a></li>
                @endif

                @if(($profile->publish_officials ?? true) || ($profile->publish_regulations ?? true))
                    <li class="dropdown">
                        <a href="#"
                            class="dropdown-toggle {{ request()->routeIs('officials*') || request()->routeIs('regulations*') ? 'active' : '' }}">Pemerintahan
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem;"></i></a>
                        <ul class="dropdown-menu">
                            @if($profile->publish_officials ?? true)
                                <li><a href="{{ route('officials') }}">Perangkat Desa</a></li>
                            @endif
                            @if($profile->publish_regulations ?? true)
                                <li><a href="{{ route('regulations') }}">Peraturan Desa</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(($profile->publish_tourism ?? true) || ($profile->publish_umkm ?? true) || ($profile->publish_agriculture ?? true))
                    <li class="dropdown">
                        <a href="#"
                            class="dropdown-toggle {{ request()->routeIs('tourism*') || request()->routeIs('umkm*') || request()->routeIs('potensi.agriculture*') || request()->routeIs('culture*') ? 'active' : '' }}">Potensi
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem;"></i></a>
                        <ul class="dropdown-menu">
                            @if($profile->publish_tourism ?? true)
                                <li><a href="{{ route('tourism') }}">Wisata dan Budaya</a></li>
                            @endif
                            @if($profile->publish_umkm ?? true)
                                <li><a href="{{ route('umkm') }}">UMKM</a></li>
                            @endif
                            @if($profile->publish_agriculture ?? true)
                                <li><a href="{{ route('potensi.agriculture') }}">Pertanian & Peternakan</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if($profile->publish_institutions ?? true)
                    <li class="dropdown">
                        <a href="#"
                            class="dropdown-toggle {{ request()->routeIs('institutions*') || request()->routeIs('institution*') || request()->routeIs('organizations*') || request()->routeIs('organization*') ? 'active' : '' }}">Kelembagaan
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('institutions') }}">Lembaga Masyarakat</a></li>
                            <li><a href="{{ route('organizations') }}">Organisasi Masyarakat</a></li>
                        </ul>
                    </li>
                @endif

                @if($profile->publish_news ?? true)
                    <li><a href="{{ route('news') }}" class="{{ request()->routeIs('news*') ? 'active' : '' }}">Berita</a>
                    </li>
                @endif
                <li><a href="{{ route('announcements') }}" class="{{ request()->routeIs('announcements*') ? 'active' : '' }}">Pengumuman</a></li>
                @if($profile->publish_statistics ?? true)
                    <li><a href="{{ route('statistics') }}"
                            class="{{ request()->routeIs('statistics*') ? 'active' : '' }}">Statistik</a></li>
                @endif
                <li><a href="{{ route('public_services') }}"
                        class="{{ request()->routeIs('public_services*') ? 'active' : '' }}">Panduan Layanan Publik</a></li>
                <li><a href="{{ route('gallery') }}"
                        class="{{ request()->routeIs('gallery*') ? 'active' : '' }}">Galeri</a></li>
                <li><a href="{{ route('contact') }}"
                        class="{{ request()->routeIs('contact*') ? 'active' : '' }}">Kontak</a></li>
            </ul>
        </div>

        <!-- Search Modal -->
        <div id="search-modal" class="search-modal">
            <button id="search-close" class="close-btn" aria-label="Close Search">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Cari informasi di website..."
                    autocomplete="off">
                <button type="submit" class="search-submit" aria-label="Submit Search">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- CONTENT -->
    <main style="padding-top: calc({{ request()->routeIs('home') ? '0px' : '85px' }} + var(--alert-height, 0px));">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer id="kontak">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="logo-wrapper" style="margin-bottom: 20px; text-decoration: none;">
                    <img src="{{ asset('img/logo-semarang.png') }}" alt="Logo Kab Semarang" class="logo-img">
                    <div class="logo-text">
                        <span class="logo-title">DESA DUREN</span>
                        <span class="logo-subtitle">KECAMATAN TENGARAN<br>KABUPATEN SEMARANG</span>
                    </div>
                </a>
                <p style="font-size: 0.95rem; line-height: 1.8; margin-bottom: 25px; color: #cbd5e1;">
                    Website resmi Desa Duren sebagai media informasi dan pelayanan kepada masyarakat.
                </p>
                <div style="display: flex; gap: 15px;">
                    @if($profile && $profile->facebook && $profile->facebook !== '#')
                        <a href="{{ $profile->getFacebookLink() }}"
                            style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                                class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if($profile && $profile->instagram && $profile->instagram !== '#')
                        <a href="{{ $profile->getInstagramLink() }}"
                            style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                                class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if($profile && $profile->youtube && $profile->youtube !== '#')
                        <a href="{{ $profile->getYoutubeLink() }}"
                            style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                                class="fa-brands fa-youtube"></i></a>
                    @endif
                </div>

                <!-- Statistik Kunjungan -->
                <div
                    style="margin-top: 25px; background: rgba(255, 255, 255, 0.04); padding: 16px 20px; border-radius: var(--radius-lg); border: 1px solid rgba(255, 255, 255, 0.08); max-width: 250px;">
                    <h5
                        style="color: var(--white); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; margin-top: 0;">
                        <i class="fa-solid fa-chart-line" style="color: var(--accent);"></i> Statistik Kunjungan
                    </h5>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #cbd5e1;">
                        <div style="display: flex; justify-content: space-between; gap: 20px;">
                            <span>Hari Ini:</span>
                            <span
                                style="font-weight: 700; color: var(--white);">{{ number_format($visitorStats['today'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; gap: 20px;">
                            <span>Bulan Ini:</span>
                            <span
                                style="font-weight: 700; color: var(--white);">{{ number_format($visitorStats['month'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; gap: 20px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 8px; margin-top: 4px;">
                            <span>Total Kunjungan:</span>
                            <span
                                style="font-weight: 700; color: var(--accent);">{{ number_format($visitorStats['total'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-col">
                <h4>Profil & Pemerintahan</h4>
                <ul>
                    @if($profile->publish_profile ?? true)
                        <li><a href="{{ route('profile') }}">Profil Desa</a></li>
                    @endif
                    @if($profile->publish_officials ?? true)
                        <li><a href="{{ route('officials') }}">Perangkat Desa</a></li>
                    @endif
                    @if($profile->publish_regulations ?? true)
                        <li><a href="{{ route('regulations') }}">Peraturan Desa</a></li>
                    @endif
                    @if($profile->publish_news ?? true)
                        <li><a href="{{ route('news') }}">Berita Desa</a></li>
                    @endif
                    <li><a href="{{ route('announcements') }}">Pengumuman Desa</a></li>
                    @if($profile->publish_statistics ?? true)
                        <li><a href="{{ route('statistics') }}">Statistik Penduduk</a></li>
                    @endif
                    <li><a href="{{ route('gallery') }}">Galeri Desa</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Potensi & Kelembagaan</h4>
                <ul>
                    @if($profile->publish_umkm ?? true)
                        <li><a href="{{ route('umkm') }}">Potensi UMKM</a></li>
                    @endif
                    @if($profile->publish_tourism ?? true)
                        <li><a href="{{ route('tourism') }}">Wisata & Budaya</a></li>
                    @endif
                    @if($profile->publish_institutions ?? true)
                        <li><a href="{{ route('institutions') }}">Lembaga Masyarakat</a></li>
                    @endif
                    <li><a href="{{ route('contact') }}">Kontak Kami</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <ul style="color: #94a3b8; font-size: 0.95rem; line-height: 1.8;">
                    @if($profile && $profile->address)
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-map-location-dot" style="margin-top: 5px; color: var(--accent);"></i>
                            @php
                                $targetMapUrl = $profile->office_maps_url ?: 'https://www.google.com/maps/search/?api=1&query=Kantor+Kepala+Desa+Duren+Tengaran';
                            @endphp
                            <a href="{{ $targetMapUrl }}" target="_blank"
                                style="color: inherit; text-decoration: none; transition: var(--transition);"
                                onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='inherit'">
                                {{ $profile->address }}
                            </a>
                        </li>
                    @endif
                    @if($profile && $profile->phone)
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-phone" style="margin-top: 5px; color: var(--accent);"></i>
                            {{ $profile->phone }}
                        </li>
                    @endif
                    @if($profile && $profile->email)
                        <li style="display: flex; gap: 10px;">
                            <i class="fa-solid fa-envelope" style="margin-top: 5px; color: var(--accent);"></i>
                            <a href="mailto:{{ $profile->email }}" style="color: inherit; text-decoration: none;">
                                {{ $profile->email }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div
            style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; text-align: center; font-size: 0.9rem; color: #64748b;">
            &copy; 2026 Pemerintah Desa Duren Tengaran. Hak Cipta Dilindungi.
        </div>
    </footer>

    @yield('scripts')

    @if(request()->routeIs('home'))
        <style>
            /* CSS Khusus untuk Header Transparan di Beranda */
            header.header-transparent {
                background-color: transparent !important;
                box-shadow: none !important;
                padding-top: 25px;
                /* Sedikit diturunkan agar lebih lega di hero */
            }

            header.header-scrolled {
                background-color: #1e3a8a !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
                padding-top: 15px;
                /* Kembali normal */
            }
        </style>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('main-header');
            const menuToggle = document.getElementById('menu-toggle');
            const menuClose = document.getElementById('menu-close');
            const overlayMenu = document.getElementById('overlay-menu');
            const searchToggle = document.getElementById('search-toggle');
            const searchClose = document.getElementById('search-close');
            const searchModal = document.getElementById('search-modal');
            const searchInput = document.querySelector('.search-input');
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            // Menu Open/Close
            if (menuToggle && overlayMenu) {
                menuToggle.addEventListener('click', () => {
                    overlayMenu.classList.add('active');
                });
            }
            if (menuClose && overlayMenu) {
                menuClose.addEventListener('click', () => {
                    overlayMenu.classList.remove('active');
                });
            }

            // Search Open/Close
            if (searchToggle && searchModal) {
                searchToggle.addEventListener('click', () => {
                    searchModal.classList.add('active');
                    setTimeout(() => searchInput.focus(), 100);
                });
            }
            if (searchClose && searchModal) {
                searchClose.addEventListener('click', () => {
                    searchModal.classList.remove('active');
                });
            }

            // Dropdown Toggle
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('active');
                    // Optional: change chevron icon direction
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (this.parentElement.classList.contains('active')) {
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-up');
                        } else {
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        }
                    }
                });
            });

            @if(request()->routeIs('home'))
            function handleScroll() {
                if (window.scrollY > 80) {
                    header.classList.add('header-scrolled');
                    header.classList.remove('header-transparent');
                } else {
                    header.classList.add('header-transparent');
                    header.classList.remove('header-scrolled');
                }
            }

            // Run on load
            handleScroll();

            // Run on scroll
            window.addEventListener('scroll', handleScroll);
            @endif
        });

        function dismissAlertBanner() {
            const banner = document.getElementById('announcement-alert-banner');
            if (banner) {
                banner.remove();
                document.documentElement.style.setProperty('--alert-height', '0px');
            }
        }
    </script>
</body>

</html>