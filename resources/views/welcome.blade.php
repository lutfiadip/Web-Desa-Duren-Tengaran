<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Informasi Desa Duren Tengaran</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Colors based on the Ecoland reference */
            --primary: #2d6a32; /* Forest green */
            --primary-hover: #1f4f24;
            --accent: #facc15; /* Bright yellow */
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

        /* --- HEADER (Transparent over hero) --- */
        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .logo-img {
            height: 55px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            color: var(--white);
        }

        .logo-title {
            font-size: 1.3rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .logo-subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-links > li {
            white-space: nowrap;
        }

        .nav-links > li > a {
            text-decoration: none;
            color: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        .nav-links > li > a:hover, .nav-links > li > a.active {
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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

        /* Custom alignment for hero content since badge is removed */
        .hero-content {
            margin-top: 80px; 
            max-width: 800px;
            color: var(--white);
        }

        /* --- HERO SECTION --- */
        .hero {
            /* Dark gradient on the left, fading to right. Background image of agriculture/village */
            background: linear-gradient(90deg, rgba(10, 25, 10, 0.95) 0%, rgba(10, 25, 10, 0.7) 45%, rgba(10, 25, 10, 0.2) 100%), 
                        url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            color: var(--white);
            margin-top: 50px; /* Offset for header */
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

        .hero h1 {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.05;
            margin-bottom: 25px;
            letter-spacing: -1px;
            color: var(--white);
        }

        .hero p {
            font-size: 1.15rem;
            color: #d1d5db; /* Light gray */
            margin-bottom: 40px;
            max-width: 600px;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
        }

        .btn-solid {
            background-color: var(--primary);
            color: var(--white);
            padding: 16px 36px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
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
            padding: 16px 36px;
            border-radius: var(--radius-pill);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
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
        }

        /* --- YELLOW BAR (Immediate transition from Hero) --- */
        .yellow-bar {
            background-color: var(--accent);
            padding: 25px 5%;
            position: relative;
            z-index: 10;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .demographics-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .demo-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px 15px;
            border-radius: var(--radius-md);
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(5px);
            transition: var(--transition);
        }

        .demo-item:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.35);
            box-shadow: 0 15px 25px rgba(133, 77, 14, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .demo-icon {
            font-size: 1.8rem;
            color: #713f12;
            margin-bottom: 10px;
            opacity: 0.9;
            transition: var(--transition);
        }

        .demo-item:hover .demo-icon {
            transform: scale(1.1);
        }

        .demo-number {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 5px;
            color: #713f12;
            line-height: 1;
        }

        .demo-label {
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #854d0e;
            margin-top: 8px;
        }

        /* --- SECTIONS --- */
        .section {
            padding: 80px 5%;
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
            border: 1px solid var(--border-color);
            border-bottom: 4px solid var(--primary);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .card-content {
            padding: 30px;
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
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
            background-color: #052e16; /* Very dark green */
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
            .hero h1 { font-size: 3.5rem; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            header { background: rgba(10, 25, 10, 0.95); padding: 1rem 5%; }
            .nav-links, .header-btn { display: none; }
            .hero { padding-top: 80px; }
            .hero-content { margin-top: 20px; }
            .hero h1 { font-size: 2.8rem; }
            .hero-buttons { flex-direction: column; gap: 15px; }
            .btn-solid, .btn-outline { justify-content: center; }
            .footer-grid { grid-template-columns: 1fr; }
            .demographics-row { flex-direction: column; gap: 40px; }
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
                <a href="#">Pemerintahan <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Perangkat Desa</a></li>
                    <li><a href="#">Peraturan Desa</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
                <a href="#">Potensi <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 3px;"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Wisata dan Budaya</a></li>
                    <li><a href="#">UMKM</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#">Kelembagaan <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 3px;"></i></a>
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
            <h1>
                Transparansi<br>
                dan Potensi Desa
            </h1>
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
    </section>

    <!-- YELLOW BAR (Demographics directly under hero) -->
    <section class="yellow-bar">
        <div class="demographics-row">
            <div class="demo-item">
                <i class="fa-solid fa-users demo-icon"></i>
                <div class="demo-number">{{ $demografi->total_penduduk ?? '2.450' }}</div>
                <div class="demo-label">Total Penduduk</div>
            </div>
            <div class="demo-item">
                <i class="fa-solid fa-house-chimney demo-icon"></i>
                <div class="demo-number">{{ $demografi->rt ?? '32' }}</div>
                <div class="demo-label">Rukun Tetangga</div>
            </div>
            <div class="demo-item">
                <i class="fa-solid fa-building demo-icon"></i>
                <div class="demo-number">{{ $demografi->rw ?? '7' }}</div>
                <div class="demo-label">Rukun Warga</div>
            </div>
            <div class="demo-item">
                <i class="fa-solid fa-map-location-dot demo-icon"></i>
                <div class="demo-number">{{ $demografi->luas_wilayah ?? '350' }}<span style="font-size:1.2rem; margin-left: 5px;">Ha</span></div>
                <div class="demo-label">Luas Wilayah</div>
            </div>
        </div>
    </section>

    <!-- AKSES CEPAT INFORMASI -->
    <section id="informasi" class="section">
        <div class="section-header">
            <span class="section-subtitle">Akses Data Publik</span>
            <h2 class="section-title">Informasi & Transparansi</h2>
        </div>
        
        <div class="quick-grid">
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-scale-balanced quick-icon"></i>
                    <h3>Peraturan Desa</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Dokumen perundang-undangan dan regulasi desa.</p>
                </div>
            </a>
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-chart-pie quick-icon"></i>
                    <h3>APBDes</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Laporan alokasi dan transparansi dana desa.</p>
                </div>
            </a>
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-users-viewfinder quick-icon"></i>
                    <h3>Data Demografi</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Statistik kependudukan berdasarkan usia dan gender.</p>
                </div>
            </a>
            <a href="#" style="text-decoration: none;">
                <div class="quick-box">
                    <i class="fa-solid fa-sitemap quick-icon"></i>
                    <h3>Lembaga Desa</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Informasi kelembagaan seperti PKK dan Karang Taruna.</p>
                </div>
            </a>
        </div>
    </section>

    <!-- BERITA & PENGUMUMAN -->
    <section id="berita" class="section" style="background-color: var(--white); border-top: 1px solid var(--border-color);">
        <div class="section-header">
            <span class="section-subtitle">Kabar Terkini</span>
            <h2 class="section-title">Berita & Pengumuman</h2>
        </div>

        <div class="grid-3">
            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Posyandu" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag">Kesehatan Publik</span>
                        <span><i class="fa-regular fa-clock"></i> 17 Jul 2026</span>
                    </div>
                    <h3 class="card-title">Pelaksanaan Posyandu Bulan Juli</h3>
                    <p class="card-desc">Rekapitulasi data kesehatan balita dan lansia pada kegiatan posyandu rutin bulan ini di Balai Desa Duren Tengaran.</p>
                    <a href="#" class="card-action">Baca Berita <i><i class="fa-solid fa-chevron-right"></i></i></a>
                </div>
            </div>
            
            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1555617781-64d1f2a3a804?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Rapat Desa" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag">Pemerintahan</span>
                        <span><i class="fa-regular fa-clock"></i> 15 Jul 2026</span>
                    </div>
                    <h3 class="card-title">Hasil Musyawarah Desa (Musdes) 2026</h3>
                    <p class="card-desc">Keputusan musyawarah terkait alokasi anggaran pembangunan infrastruktur dan program pemberdayaan masyarakat tahun anggaran berjalan.</p>
                    <a href="#" class="card-action">Baca Berita <i><i class="fa-solid fa-chevron-right"></i></i></a>
                </div>
            </div>

            <div class="info-card">
                <img src="https://images.unsplash.com/photo-1594708767771-a7502209ff51?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Kerja Bakti" class="card-img">
                <div class="card-content">
                    <div class="card-meta">
                        <span class="tag">Kegiatan Warga</span>
                        <span><i class="fa-regular fa-clock"></i> 10 Jul 2026</span>
                    </div>
                    <h3 class="card-title">Kerja Bakti Rutin di Lingkungan RW 03</h3>
                    <p class="card-desc">Dokumentasi kegiatan gotong royong warga RW 03 membersihkan saluran pembuangan air sebagai langkah antisipasi musim penghujan.</p>
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
                    Website resmi informasi Pemerintah Desa Duren Tengaran. Wadah keterbukaan publik yang menyajikan data dan potensi desa secara aktual.
                </p>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white);"><i class="fa-brands fa-youtube"></i></a>
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
        
        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; text-align: center; font-size: 0.9rem; color: #64748b;">
            &copy; 2026 Pemerintah Desa Duren Tengaran. Hak Cipta Dilindungi.
        </div>
    </footer>

</body>
</html>