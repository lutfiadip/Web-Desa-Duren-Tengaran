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
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #1e3a8a;
            /* Same as footer */
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
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

        .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-links>li {
            white-space: nowrap;
        }

        .nav-links>li>a {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 10px 0;
        }

        .nav-links>li>a:hover,
        .nav-links>li>a.active {
            color: var(--accent);
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: var(--white);
            min-width: 220px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: var(--radius-md);
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: var(--transition);
            list-style: none;
            border-top: 3px solid var(--primary);
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(10px);
        }

        .dropdown-menu li {
            margin: 0;
        }

        .dropdown-menu a {
            color: var(--text-dark);
            padding: 10px 20px;
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-menu a:hover {
            background: var(--bg-main);
            color: var(--primary);
            padding-left: 25px;
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

            .nav-links {
                display: none;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <!-- HEADER -->
    <header>
        <a href="{{ route('home') }}" class="logo-wrapper">
            <img src="{{ asset('img/logo-semarang.png') }}" alt="Logo Kab Semarang" class="logo-img">
            <div class="logo-text">
                <span class="logo-title">DESA DUREN</span>
                <span class="logo-subtitle">KECAMATAN TENGARAN<br>KABUPATEN SEMARANG</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profil Desa</a></li>

            <li class="dropdown">
                <a href="#" class="{{ request()->routeIs('officials') || request()->routeIs('regulations') ? 'active' : '' }}">Pemerintahan <i class="fa-solid fa-chevron-down"
                        style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('officials') }}">Perangkat Desa</a></li>
                    <li><a href="{{ route('regulations') }}">Peraturan Desa</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="{{ request()->routeIs('tourism') ? 'active' : '' }}">Potensi <i class="fa-solid fa-chevron-down"
                        style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('tourism') }}">Wisata dan Budaya</a></li>
                    <li><a href="{{ request()->routeIs('home') ? '#umkm' : route('home') . '#umkm' }}">UMKM</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#">Kelembagaan <i class="fa-solid fa-chevron-down"
                        style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Lembaga Masyarakat</a></li>
                    <li><a href="#">Organisasi Masyarakat</a></li>
                </ul>
            </li>

            <li><a href="{{ request()->routeIs('home') ? '#berita' : route('home') . '#berita' }}">Berita</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
    </header>

    <!-- CONTENT -->
    <main>
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
                    <a href="{{ $profile->facebook ?? '#' }}"
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com/{{ $profile->instagram ?? 'desa.duren' }}"
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="https://youtube.com/{{ $profile->youtube ?? '@durentengaran' }}"
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                            class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Profil & Pemerintahan</h4>
                <ul>
                    <li><a href="{{ route('profile') }}">Profil Desa</a></li>
                    <li><a href="{{ route('officials') }}">Perangkat Desa</a></li>
                    <li><a href="{{ route('regulations') }}">Peraturan Desa</a></li>
                    <li><a href="{{ request()->routeIs('home') ? '#berita' : route('home') . '#berita' }}">Berita Desa</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Potensi & Kelembagaan</h4>
                <ul>
                    <li><a href="{{ request()->routeIs('home') ? '#umkm' : route('home') . '#umkm' }}">Potensi UMKM</a></li>
                    <li><a href="{{ request()->routeIs('home') ? '#galeri' : route('home') . '#galeri' }}">Wisata & Budaya</a></li>
                    <li><a href="#">Lembaga Masyarakat</a></li>
                    <li><a href="#kontak">Kontak Kami</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <ul style="color: #94a3b8; font-size: 0.95rem; line-height: 1.8;">
                    <li style="display: flex; gap: 10px;">
                        <i class="fa-solid fa-map-location-dot" style="margin-top: 5px; color: var(--accent);"></i>
                        {{ $profile->address ?? 'Miri, Duren, Kec. Tengaran, Kabupaten Semarang, Jawa Tengah 50775' }}
                    </li>
                    <li style="display: flex; gap: 10px;">
                        <i class="fa-solid fa-phone" style="margin-top: 5px; color: var(--accent);"></i>
                        {{ $profile->phone ?? '-' }}
                    </li>
                    <li style="display: flex; gap: 10px;">
                        <i class="fa-solid fa-envelope" style="margin-top: 5px; color: var(--accent);"></i>
                        {{ $profile->email ?? '332202.duren@gmail.com' }}
                    </li>
                </ul>
            </div>
        </div>

        <div
            style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; text-align: center; font-size: 0.9rem; color: #64748b;">
            &copy; 2026 Pemerintah Desa Duren Tengaran. Hak Cipta Dilindungi.
        </div>
    </footer>

</body>

</html>
