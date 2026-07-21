<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Informasi Desa Duren Tengaran</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Colors based on the Ecoland reference */
            --primary: #2d6a32;
            /* Forest green */
            --primary-hover: #1f4f24;
            --accent: #facc15;
            /* Bright yellow */
            --accent-hover: #eab308;

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
        }

        /* --- HEADER (Solid Green) --- */
        header {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #052e16;
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
            /* White color for DESA DUREN */
        }

        .logo-subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: 0.5px;
            color: #d1d5db;
            /* Light grey */
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
            /* White/very light grey */
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
            /* Yellow accent for hover */
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

        /* --- HERO SECTION --- */
        .hero {
            /* Dark gradient on the left, fading to right. Background image of agriculture/village */
            background: linear-gradient(90deg, rgba(10, 25, 10, 0.95) 0%, rgba(10, 25, 10, 0.7) 45%, rgba(10, 25, 10, 0.2) 100%),
                url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
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
            /* Reduced icon size */
            color: #713f12;
            /* Dark brown */
            transition: var(--transition);
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
            grid-template-columns: 1.2fr 1fr 1.5fr;
            gap: 40px;
            align-items: stretch;
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
            background-color: #064e3b; 
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

        .kades-card {
            margin-top: 25px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            display: flex;
            padding: 20px;
            gap: 20px;
            flex: 1;
            align-items: center;
        }

        .kades-img-wrapper {
            flex: 0 0 140px;
            border-radius: var(--radius-md);
            overflow: hidden;
            background-color: #f1f5f9;
        }

        .kades-img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .kades-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .kades-name {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .kades-title {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 15px;
        }

        .kades-quote {
            font-size: 0.85rem;
            line-height: 1.6;
            color: var(--text-dark);
            margin-bottom: 20px;
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
            .kades-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .kades-img-wrapper {
                flex: none;
                width: 140px;
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
            .umkm-scroll .info-card {
                flex: 0 0 280px;
            }
        }

        /* --- SECTIONS --- */
        .section {
            padding: 50px 5%; /* Reduced from 80px */
            max-width: 1400px;
            margin: 0 auto;
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
        .umkm-socials {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 10px;
            margin-top: auto;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            background: transparent;
        }
        .social-btn.wa { color: #25D366; }
        .social-btn.ig { color: #E1306C; }
        .social-btn.fb { color: #1877F2; }
        .social-btn.maps { color: var(--text-dark); }
        .social-btn:hover { opacity: 0.7; }

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

        /* --- QUICK INFO GRID --- */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
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

        /* --- FOOTER --- */
        footer {
            background-color: #052e16;
            /* Very dark green */
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

        /* Responsive */
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            header {
                background: #052e16;
                /* Same as footer */
                padding: 1rem 5%;
            }

            .nav-links,
            .header-btn {
                display: none;
            }

            .hero {
                padding-top: 80px;
            }

            .hero-content {
                margin-top: 20px;
            }

            .hero h1 {
                font-size: 2.8rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .btn-solid,
            .btn-outline {
                justify-content: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .demographics-row {
                flex-direction: column;
                gap: 40px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER (Transparent over hero) -->
    <header>
        <a href="#" class="logo-wrapper">
            <img src="{{ asset('img/logo-semarang.png') }}" alt="Logo Kab Semarang" class="logo-img">
            <div class="logo-text">
                <span class="logo-title">DESA DUREN</span>
                <span class="logo-subtitle">KECAMATAN TENGARAN<br>KABUPATEN SEMARANG</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="#" class="active">Beranda</a></li>
            <li><a href="#profil">Profil Desa</a></li>

            <li class="dropdown">
                <a href="#">Pemerintahan <i class="fa-solid fa-chevron-down"
                        style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Perangkat Desa</a></li>
                    <li><a href="#">Peraturan Desa</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#">Potensi <i class="fa-solid fa-chevron-down"
                        style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Wisata dan Budaya</a></li>
                    <li><a href="#">UMKM</a></li>
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

            <li><a href="#berita">Berita</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
    </header>

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
                <a href="#informasi" class="btn-outline">
                    Akses Data <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- DEMOGRAPHICS (Right Side Floating) -->
        <div class="demographics-section">
            <div class="demographics-row">
                <div class="demo-item">
                    <i class="fa-solid fa-users demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Total Penduduk</div>
                        <div class="demo-number">{{ $demografi->total_penduduk ?? '2.450' }}</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-house-chimney demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Rukun Tetangga</div>
                        <div class="demo-number">{{ $demografi->rt ?? '32' }}</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-building demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Rukun Warga</div>
                        <div class="demo-number">{{ $demografi->rw ?? '7' }}</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-map-location-dot demo-icon"></i>
                    <div class="demo-content">
                        <div class="demo-label">Luas Wilayah</div>
                        <div class="demo-number">{{ $demografi->luas_wilayah ?? '350' }} Ha</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SAMBUTAN KEPALA DESA SECTION -->
    <section class="welcome-section">
        <div class="welcome-grid">
            <!-- Col 1: Balai Desa Image -->
            <div class="welcome-col-image">
                <!-- NOTE: Ganti div di bawah ini dengan tag <img ...> jika foto aslinya sudah ada -->
                <!-- Contoh: <img src="{{ asset('img/foto-balai.jpg') }}" alt="Balai Desa Duren" class="balai-desa-img"> -->
                <div class="balai-desa-img" style="background-color: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 600; text-align: center; padding: 20px;">
                    [ Tempat Foto Balai Desa ]
                </div>
            </div>
            
            <!-- Col 2: Tentang Desa Text -->
            <div class="welcome-col-text">
                <div class="section-badge">TENTANG DESA</div>
                <h2 class="welcome-title">Desa Duren</h2>
                <p>Desa Duren merupakan salah satu desa di Kecamatan Tengaran, Kabupaten Semarang yang memiliki potensi besar di bidang pertanian, peternakan, dan pariwisata. Dengan semangat gotong royong, berkembang menuju masyarakat sejahtera, dan berdaya saing.</p>
                <a href="#profil" class="welcome-btn">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            
            <!-- Col 3: Pemerintahan Desa Card -->
            <div class="welcome-col-card">
                <div class="section-badge">PEMERINTAHAN DESA</div>
                <div class="kades-card">
                    <div class="kades-img-wrapper">
                        <!-- NOTE: Ganti div di bawah ini dengan tag <img ...> jika foto aslinya sudah ada -->
                        <!-- Contoh: <img src="{{ asset('img/foto-kades.jpg') }}" alt="Slamet Riyadi" class="kades-img"> -->
                        <div class="kades-img" style="background-color: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 600; text-align: center; padding: 10px; min-height: 160px; height: 100%;">
                            [ Foto Kades ]
                        </div>
                    </div>
                    <div class="kades-info">
                        <h3 class="kades-name">Slamet Riyadi, S.E.</h3>
                        <div class="kades-title">Kepala Desa Duren</div>
                        <p class="kades-quote">Bersama mewujudkan Desa Duren yang maju, mandiri, dan sejahtera melalui pelayanan yang transparan dan partisipatif.</p>
                        <a href="#pemerintahan" class="welcome-btn btn-small">Struktur Organisasi <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POTENSI DESA -->
    <section id="potensi" class="section">
        <div class="section-header">
            <span class="section-subtitle">Potensi Desa</span>
            <h2 class="section-title">Kekayaan & Komoditas Unggulan</h2>
        </div>

        <div class="quick-grid">
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-wheat-awn quick-icon"></i>
                    <h3>Pertanian</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Lahan subur dengan komoditas unggulan padi dan palawija.</p>
                </div>
            </a>
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-cow quick-icon"></i>
                    <h3>Peternakan</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Pusat pengembangan hewan ternak seperti sapi dan kambing.</p>
                </div>
            </a>
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-shop quick-icon"></i>
                    <h3>UMKM</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Produk kerajinan dan makanan khas hasil karya warga desa.</p>
                </div>
            </a>
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-mountain-sun quick-icon"></i>
                    <h3>Pariwisata</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Pesona alam asri yang menarik bagi wisatawan lokal.</p>
                </div>
            </a>
        </div>
    </section>

    <!-- UMKM UNGGULAN -->
    <section id="umkm" class="section" style="background-color: var(--white); border-top: 1px solid var(--border-color);">
        <div class="section-header">
            <span class="section-subtitle">Produk Lokal</span>
            <h2 class="section-title">UMKM Unggulan Desa</h2>
        </div>

        <div class="umkm-scroll">
            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Keripik Pisang" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag" style="background-color: #fef3c7; color: #d97706;">Makanan Ringan</span>
                    </div>
                    <h3 class="card-title">Keripik Pisang Aneka Rasa</h3>
                    <p class="card-desc">Camilan khas Desa Duren yang terbuat dari pisang pilihan dengan berbagai varian rasa seperti cokelat, keju, dan balado.</p>
                    <div class="umkm-socials">
                        <a href="#" class="social-btn maps"><i class="fa-solid fa-location-dot"></i> Maps</a>
                        <a href="#" class="social-btn ig"><i class="fa-brands fa-instagram"></i> IG</a>
                        <a href="#" class="social-btn wa"><i class="fa-brands fa-whatsapp"></i> WA</a>
                        <a href="#" class="social-btn fb"><i class="fa-brands fa-facebook"></i> FB</a>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1599839619722-39751411ea63?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Kerajinan Bambu" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag" style="background-color: #fef3c7; color: #d97706;">Kerajinan</span>
                    </div>
                    <h3 class="card-title">Kerajinan Anyaman Bambu</h3>
                    <p class="card-desc">Berbagai produk dekorasi dan perabotan rumah tangga ramah lingkungan dari anyaman bambu asli karya warga.</p>
                    <div class="umkm-socials">
                        <a href="#" class="social-btn maps"><i class="fa-solid fa-location-dot"></i> Maps</a>
                        <a href="#" class="social-btn ig"><i class="fa-brands fa-instagram"></i> IG</a>
                        <a href="#" class="social-btn wa"><i class="fa-brands fa-whatsapp"></i> WA</a>
                        <a href="#" class="social-btn fb"><i class="fa-brands fa-facebook"></i> FB</a>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1556881286-fc6915169721?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Kopi Lokal" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag" style="background-color: #fef3c7; color: #d97706;">Minuman</span>
                    </div>
                    <h3 class="card-title">Kopi Bubuk Asli Duren</h3>
                    <p class="card-desc">Biji kopi robusta pilihan yang dipetik langsung dari kebun desa dan dipanggang secara tradisional.</p>
                    <div class="umkm-socials">
                        <a href="#" class="social-btn maps"><i class="fa-solid fa-location-dot"></i> Maps</a>
                        <a href="#" class="social-btn ig"><i class="fa-brands fa-instagram"></i> IG</a>
                        <a href="#" class="social-btn wa"><i class="fa-brands fa-whatsapp"></i> WA</a>
                        <a href="#" class="social-btn fb"><i class="fa-brands fa-facebook"></i> FB</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BERITA & PENGUMUMAN -->
    <section id="berita" class="section"
        style="background-color: var(--white); border-top: 1px solid var(--border-color);">
        <div class="section-header">
            <span class="section-subtitle">Kabar Terkini</span>
            <h2 class="section-title">Berita & Pengumuman</h2>
        </div>

        <div class="grid-3">
            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Posyandu" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag">Kesehatan Publik</span>
                        <span><i class="fa-regular fa-clock"></i> 17 Jul 2026</span>
                    </div>
                    <h3 class="card-title">Pelaksanaan Posyandu Bulan Juli</h3>
                    <p class="card-desc">Rekapitulasi data kesehatan balita dan lansia pada kegiatan posyandu rutin
                        bulan ini di Balai Desa Duren Tengaran.</p>
                    <a href="#" class="card-action">Baca Berita <i><i class="fa-solid fa-chevron-right"></i></i></a>
                </div>
            </div>

            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1555617781-64d1f2a3a804?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Rapat Desa" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag">Pemerintahan</span>
                        <span><i class="fa-regular fa-clock"></i> 15 Jul 2026</span>
                    </div>
                    <h3 class="card-title">Hasil Musyawarah Desa (Musdes) 2026</h3>
                    <p class="card-desc">Keputusan musyawarah terkait alokasi anggaran pembangunan infrastruktur dan
                        program pemberdayaan masyarakat tahun anggaran berjalan.</p>
                    <a href="#" class="card-action">Baca Berita <i><i class="fa-solid fa-chevron-right"></i></i></a>
                </div>
            </div>

            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1594708767771-a7502209ff51?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Kerja Bakti" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag">Kegiatan Warga</span>
                        <span><i class="fa-regular fa-clock"></i> 10 Jul 2026</span>
                    </div>
                    <h3 class="card-title">Kerja Bakti Rutin di Lingkungan RW 03</h3>
                    <p class="card-desc">Dokumentasi kegiatan gotong royong warga RW 03 membersihkan saluran pembuangan
                        air sebagai langkah antisipasi musim penghujan.</p>
                    <a href="#" class="card-action">Baca Berita <i><i class="fa-solid fa-chevron-right"></i></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <i class="fa-solid fa-leaf"></i> DurenTengaran
                </div>
                <p style="font-size: 0.95rem; line-height: 1.8; margin-bottom: 25px; color: #cbd5e1;">
                    Website resmi informasi Pemerintah Desa Duren Tengaran. Wadah keterbukaan publik yang menyajikan
                    data dan potensi desa secara aktual.
                </p>
                <div style="display: flex; gap: 15px;">
                    <a href="#"
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="#"
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i
                            class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Informasi Desa</h4>
                <ul>
                    <li><a href="#">Profil Desa</a></li>
                    <li><a href="#">Aparatur Desa</a></li>
                    <li><a href="#">Potensi UMKM</a></li>
                    <li><a href="#">Galeri Desa</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Transparansi Publik</h4>
                <ul>
                    <li><a href="#">Data Demografi</a></li>
                    <li><a href="#">Peraturan Desa</a></li>
                    <li><a href="#">APBDes</a></li>
                    <li><a href="#">Lembaga Masyarakat</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <ul style="color: #94a3b8; font-size: 0.95rem; line-height: 1.8;">
                    <li style="display: flex; gap: 10px;">
                        <i class="fa-solid fa-map-location-dot" style="margin-top: 5px; color: var(--accent);"></i>
                        Jl. Raya Tengaran No. 123, Kab. Semarang, Jawa Tengah 50775
                    </li>
                    <li style="display: flex; gap: 10px;">
                        <i class="fa-solid fa-phone" style="margin-top: 5px; color: var(--accent);"></i>
                        (0298) 123456
                    </li>
                    <li style="display: flex; gap: 10px;">
                        <i class="fa-solid fa-envelope" style="margin-top: 5px; color: var(--accent);"></i>
                        info@durentengaran.desa.id
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