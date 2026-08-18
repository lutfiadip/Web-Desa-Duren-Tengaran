@extends('layouts.app')

@section('title', 'Portal Informasi Desa Duren Tengaran')

@section('styles')
<style>

        /* --- HERO SECTION (MNTN STYLE) --- */
        .hero {
            /* Dark gradient on the left, fading to transparent on the right */
            background: 
                linear-gradient(to bottom, transparent 75%, var(--bg-main) 100%),
                linear-gradient(90deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.6) 40%, rgba(15, 23, 42, 0) 100%),
                url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
            min-height: 200vh; /* Made extremely long downwards */
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 30vh 5% 150px; /* Push content to top viewport */
            position: relative;
        }

        .hero-left-sidebar {
            position: absolute;
            left: 5%;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            transform-origin: left center;
            display: flex;
            align-items: center;
            gap: 25px;
            color: var(--white);
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 2px;
        }

        .hero-left-sidebar span {
            margin-right: 10px;
        }

        .hero-left-sidebar a {
            color: var(--white);
            text-decoration: none;
            transform: rotate(90deg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }

        .hero-left-sidebar a:hover {
            color: var(--accent);
        }

        .hero-content {
            max-width: 900px;
            color: var(--white);
            margin: 0 auto;
            text-align: left;
            position: relative;
            z-index: 10;
        }

        .hero-subtitle {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .hero-subtitle::before {
            content: "";
            display: inline-block;
            width: 70px;
            height: 2px;
            background-color: var(--accent);
        }

        .hero-main-title {
            font-size: 5.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin: 0 0 40px 0;
            text-transform: capitalize;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', serif; /* Or actual serif if available */
        }
        
        .hero p {
            font-size: 1.15rem;
            color: #e2e8f0;
            margin-bottom: 45px;
            max-width: 650px;
            line-height: 1.8;
            text-align: left;
            font-weight: 400;
        }

        .hero-scroll-down {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            color: var(--white);
            font-weight: 700;
            text-decoration: none;
            font-size: 1rem;
            letter-spacing: 1px;
        }

        .hero-scroll-down i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .hero-scroll-down:hover {
            color: var(--accent);
        }

        .hero-scroll-down:hover i {
            transform: translateY(7px);
        }

        .hero-right-sidebar {
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 20px;
            color: var(--white);
            font-weight: 700;
            font-size: 0.9rem;
        }

        .hero-slider-indicator {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 20px;
            position: relative;
            padding-right: 25px;
        }

        .hero-slider-indicator span {
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.3s;
        }

        .hero-slider-indicator span.active {
            opacity: 1;
        }
        
        .hero-slider-indicator::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: rgba(255,255,255,0.3);
        }

        .hero-slider-indicator .active-line {
            position: absolute;
            right: 0;
            top: 35px; /* Adjust based on active item */
            width: 2px;
            height: 30px;
            background-color: var(--white);
            z-index: 2;
        }

        .hero-demographics {
            display: flex;
            justify-content: flex-start;
            gap: 20px;
            margin-top: 10px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .demo-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--white);
            background: rgba(15, 23, 42, 0.5);
            padding: 10px 20px;
            border-radius: var(--radius-md);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .demo-item:hover {
            transform: translateY(-5px);
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--accent);
        }

        .demo-icon {
            font-size: 1.5rem;
            color: var(--accent);
        }

        .demo-number {
            font-size: 1.2rem;
            font-weight: 800;
            line-height: 1;
        }

        .demo-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.8;
            margin-top: 3px;
        }

        /* --- VIDEO PROFILE (FLOATING) --- */
        .hero-video-wrapper {
            position: absolute;
            top: 120vh; /* Move it down to the second viewport area so it doesn't overlap */
            left: 50%;
            transform: translateX(-50%);
            z-index: 15;
            width: 90%;
            max-width: 400px;
        }
        
        .hero-video-card {
            position: relative;
            width: 100%;
            height: 250px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border: 2px solid rgba(255,255,255,0.15);
            transition: var(--transition);
        }

        .hero-video-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 50px rgba(0,0,0,0.5);
            border-color: var(--accent);
        }
        
        .hero-video-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .hero-video-card:hover img {
            transform: scale(1.05);
        }

        .hero-video-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.1) 60%);
        }

        .play-btn {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 65px;
            height: 65px;
            background: var(--accent);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            z-index: 2;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);
            transition: var(--transition);
            padding-left: 5px; /* Visual center for play icon */
        }

        .hero-video-card:hover .play-btn {
            transform: translate(-50%, -50%) scale(1.1);
            background: #d97706;
        }

        .video-text {
            position: absolute;
            bottom: 25px;
            left: 25px;
            right: 25px;
            z-index: 2;
            color: var(--white);
            text-align: center;
        }

        .video-text h4 {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .video-text p {
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0;
        }

        /* Video Modal */
        .video-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .video-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .video-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(5px);
        }

        .video-modal-content {
            position: relative;
            width: 90%;
            max-width: 900px;
            z-index: 2;
            transform: translateY(20px) scale(0.95);
            transition: transform 0.3s ease;
        }

        .video-modal.active .video-modal-content {
            transform: translateY(0) scale(1);
        }

        .close-video-btn {
            position: absolute;
            top: -50px;
            right: -20px;
            background: none;
            border: none;
            color: var(--white);
            font-size: 2.5rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-video-btn:hover {
            color: var(--accent);
        }

        .iframe-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            background: #000;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255,255,255,0.1);
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        @media (max-width: 1024px) {
            .hero-left-sidebar, .hero-right-sidebar {
                display: none; /* Hide on smaller screens */
            }
            .hero-main-title {
                font-size: 4rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero {
                background: 
                    linear-gradient(to bottom, transparent 80%, var(--bg-main) 100%),
                    linear-gradient(180deg, rgba(15, 23, 42, 0.5) 0%, rgba(15, 23, 42, 0.95) 60%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
                align-items: flex-start;
                padding-top: 25vh;
                padding-bottom: 250px;
            }
            .hero-main-title {
                font-size: 3rem;
            }
            .hero-subtitle {
                font-size: 0.85rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .hero-demographics {
                gap: 15px;
            }
            .demo-item {
                padding: 8px 15px;
                flex: 1 1 calc(50% - 15px);
            }
            .demo-number { font-size: 1.1rem; }
            .demo-icon { font-size: 1.3rem; }
            .demo-label { font-size: 0.7rem; }
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
            gap: 10px;
            align-items: center;
            transition: var(--transition);
        }

        .welcome-btn:hover {
            background-color: var(--primary-hover);
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

        .quick-grid > a {
            text-decoration: none;
            display: block;
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
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
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


    <!-- HERO SECTION (MNTN Layout) -->
    <section class="hero">
        


        <!-- Center Content -->
        <div class="hero-content">
            <div class="hero-subtitle">Website Resmi Pemerintah Desa</div>
            <h1 class="hero-main-title">
                DESA DUREN
            </h1>
            <p>
                Mengenal desa, masyarakat, potensi, dan berbagai informasi Desa Duren dalam satu ruang digital. Kecamatan Tengaran &middot; Kabupaten Semarang.
            </p>

            <!-- Demographics Bar -->
            <div class="hero-demographics">
                <div class="demo-item">
                    <i class="fa-solid fa-users demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ ($demografi->total_penduduk->male_count ?? 0) + ($demografi->total_penduduk->female_count ?? 0) > 0 ? ($demografi->total_penduduk->male_count ?? 0) + ($demografi->total_penduduk->female_count ?? 0) : '2.450' }}</div>
                        <div class="demo-label">Total Penduduk</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-house-chimney demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ ($demografi->rt->male_count ?? 0) + ($demografi->rt->female_count ?? 0) > 0 ? ($demografi->rt->male_count ?? 0) + ($demografi->rt->female_count ?? 0) : '32' }}</div>
                        <div class="demo-label">Rukun Tetangga</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-building demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ ($demografi->rw->male_count ?? 0) + ($demografi->rw->female_count ?? 0) > 0 ? ($demografi->rw->male_count ?? 0) + ($demografi->rw->female_count ?? 0) : '7' }}</div>
                        <div class="demo-label">Rukun Warga</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-map-location-dot demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ ($demografi->luas_wilayah->male_count ?? 0) + ($demografi->luas_wilayah->female_count ?? 0) > 0 ? ($demografi->luas_wilayah->male_count ?? 0) + ($demografi->luas_wilayah->female_count ?? 0) : '350' }} <span style="font-size: 0.8em; opacity: 0.8;">Ha</span></div>
                        <div class="demo-label">Luas Wilayah</div>
                    </div>
                </div>
            </div>
            
            <a href="#explore" class="hero-scroll-down">
                scroll down <i class="fa-solid fa-arrow-down"></i>
            </a>
        </div>
        
        <!-- Video Profile Floating Element -->
        @php
            $ytVideoId = 'LXb3EKWsInQ'; // Default fallback ID
            if ($profile && !empty($profile->video_url)) {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $profile->video_url, $match);
                if (isset($match[1])) {
                    $ytVideoId = $match[1];
                }
            }
            $ytThumbnail = "https://img.youtube.com/vi/{$ytVideoId}/maxresdefault.jpg";
        @endphp
        <div class="hero-video-wrapper">
            <div class="hero-video-card" onclick="openVideoModal()">
                <!-- We use the dynamically extracted YouTube thumbnail -->
                <img src="{{ $ytThumbnail }}" alt="Video Profil Desa" onerror="this.onerror=null;this.src='https://img.youtube.com/vi/{{ $ytVideoId }}/hqdefault.jpg';">
                <div class="play-btn">
                    <i class="fa-solid fa-play"></i>
                </div>
                <div class="video-text">
                    <h4>Tonton Profil Desa</h4>
                    <p>Kenali Desa Duren lebih dekat</p>
                </div>
            </div>
        </div>

    </section>

    <!-- ANCHOR POINT FOR EXPLORE -->
    <div id="explore"></div>

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
                        <a href="{{ route('potensi.agriculture') }}">
                            <div class="quick-box">
                                <i class="fa-solid fa-wheat-awn quick-icon"></i>
                                <h3>Pertanian</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_agriculture_desc ?? 'Lahan subur dengan komoditas unggulan padi dan palawija.' }}</p>
                            </div>
                        </a>
                        <a href="{{ route('potensi.agriculture') }}">
                            <div class="quick-box">
                                <i class="fa-solid fa-cow quick-icon"></i>
                                <h3>Peternakan</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_animal_husbandry_desc ?? 'Pusat pengembangan hewan ternak seperti sapi dan kambing.' }}</p>
                            </div>
                        </a>
                        @endif

                        @if($profile->publish_umkm ?? true)
                        <a href="{{ route('umkm') }}">
                            <div class="quick-box">
                                <i class="fa-solid fa-shop quick-icon"></i>
                                <h3>UMKM</h3>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $profile->potency_umkm_desc ?? 'Produk kerajinan dan makanan khas hasil karya warga desa.' }}</p>
                            </div>
                        </a>
                        @endif

                        @if($profile->publish_tourism ?? true)
                        <a href="{{ route('tourism') }}">
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
                                <img src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset($umkm->thumbnail) }}"
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
        @elseif($section === 'tourism')
            <!-- PARIWISATA & BUDAYA -->
            @if(($profile->show_tourism_on_home ?? true) && ($profile->publish_tourism ?? true))
            <section id="pariwisata" class="section">
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <span class="section-subtitle">{{ $profile->tourism_subtitle ?? 'Destinasi Wisata' }}</span>
                        <h2 class="section-title">{{ $profile->tourism_title ?? 'Pariwisata & Budaya Desa' }}</h2>
                    </div>
            
                    <div class="grid-3">
                        @foreach($tourisms as $wisata)
                        <div class="info-card">
                            <a href="{{ route('tourism.detail', $wisata->slug) }}" style="display: block;">
                                @if($wisata->thumbnail)
                                <img src="{{ Str::startsWith($wisata->thumbnail, 'http') ? $wisata->thumbnail : asset($wisata->thumbnail) }}" alt="{{ $wisata->title }}" class="card-img">
                                @else
                                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $wisata->title }}" class="card-img">
                                @endif
                            </a>
                            <div class="card-content">
                                <div class="card-meta">
                                    <span class="tag" style="background-color: #dbeafe; color: #1d4ed8;">Destinasi Wisata</span>
                                </div>
                                <a href="{{ route('tourism.detail', $wisata->slug) }}" style="text-decoration: none; color: inherit;">
                                    <h3 class="card-title">{{ $wisata->title }}</h3>
                                </a>
                                <p class="card-desc">{{ Str::limit(strip_tags($wisata->description), 100) }}</p>
                                <a href="{{ route('tourism.detail', $wisata->slug) }}" class="card-action">Lihat Detail Wisata <i><i class="fa-solid fa-chevron-right"></i></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div style="text-align: center; margin-top: 40px;">
                        <a href="{{ route('tourism') }}" class="btn-solid">
                            Lihat Semua Destinasi <i class="fa-solid fa-arrow-right"></i>
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
                        <div class="info-card" style="position: relative;">
                            <div style="position: relative; overflow: hidden; height: 220px; width: 100%; border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                                <img src="{{ Str::startsWith($item->featured_image, 'http') ? $item->featured_image : asset($item->featured_image) }}"
                                    alt="{{ $item->title }}" class="card-img" style="height: 100%; width: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 15px; right: 15px; background-color: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); color: var(--white); font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 5px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); z-index: 2;">
                                    <i class="fa-solid fa-eye" style="font-size: 0.75rem;"></i> {{ number_format($item->views, 0, ',', '.') }}
                                </span>
                            </div>
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
                            <img src="{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset($gallery->image) }}" alt="{{ $gallery->caption ?? 'Galeri Desa' }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        @endif
    @endforeach

    <!-- Video Modal Structure -->
    <div id="video-modal" class="video-modal">
        <div class="video-modal-overlay" onclick="closeVideoModal()"></div>
        <div class="video-modal-content">
            <button class="close-video-btn" onclick="closeVideoModal()"><i class="fa-solid fa-xmark"></i></button>
            <div class="iframe-container">
                <!-- Placeholder YouTube nature video to simulate a drone shot / village profile -->
                <iframe id="youtube-video" src="" title="Video Profil Desa" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <script>
        function openVideoModal() {
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('youtube-video');
            
            // Get YouTube video URL from profile, fallback to placeholder if empty
            const videoUrl = "{{ $profile->video_url ?? 'https://www.youtube.com/watch?v=LXb3EKWsInQ' }}";
            let videoId = "";
            
            // Extract Video ID using regex
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = videoUrl.match(regExp);
            if (match && match[2].length === 11) {
                videoId = match[2];
            } else {
                videoId = "LXb3EKWsInQ"; // Fallback ID
            }
            
            iframe.src = "https://www.youtube.com/embed/" + videoId + "?autoplay=1&mute=0"; 
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // prevent background scrolling
        }

        function closeVideoModal() {
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('youtube-video');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto'; // restore scrolling
            setTimeout(() => {
                iframe.src = ""; // Stop video from playing in background
            }, 300);
        }
    </script>
@endsection