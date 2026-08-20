@extends('layouts.app')

@section('title', 'Portal Informasi Desa Duren Tengaran')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* --- CARDS (Mobile Style) --- */
    .card-item {
        position: relative;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 520px;
        text-decoration: none;
        background: #0f172a;
    }

    .card-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    .card-image-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-item:hover .card-image-bg {
        transform: scale(1.08);
    }

    .card-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        background: linear-gradient(to bottom, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.4) 45%, rgba(15, 23, 42, 0.95) 100%);
    }

    .card-content {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 30px 25px;
        color: var(--white);
    }

    .card-top-badge {
        align-self: flex-start;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 8px 18px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9rem;
        color: var(--white);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .card-top-badge.featured {
        background: rgba(245, 158, 11, 0.7);
        border: 1px solid rgba(245, 158, 11, 0.9);
    }

    .card-bottom-info {
        margin-top: auto;
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .card-item .card-title {
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 15px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--white);
    }

    .card-divider {
        border: none;
        height: 1px;
        background: rgba(255, 255, 255, 0.3);
        margin: 0 0 15px 0;
        width: 100%;
    }

    .card-subtitle {
        font-size: 1rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-subtitle i {
        color: var(--accent);
    }

    .card-item .card-desc {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.6;
        margin-bottom: 25px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-action-btn {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: var(--white);
        padding: 14px 0;
        width: 100%;
        text-align: center;
        border-radius: var(--radius-pill);
        font-weight: 800;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: auto;
        display: inline-block;
    }

    .card-item:hover .card-action-btn {
        background: var(--white);
        color: var(--text-dark);
        transform: scale(1.02);
    }

        /* Swiper Gallery Styles */
        .gallerySwiper {
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .gallerySwiper .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 320px;
            height: 420px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            
            /* CSS Illusion for 3D stacked effect */
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(0.85);
            opacity: 0.6;
            z-index: 1;
        }
        .gallerySwiper .swiper-slide-active {
            transform: scale(1.05);
            opacity: 1;
            z-index: 10;
            box-shadow: 0 20px 45px rgba(0,0,0,0.2);
        }
        .gallerySwiper .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        /* --- HERO SECTION (MNTN STYLE) --- */
        .hero {
            /* Dark gradient on the left, fading to transparent on the right */
            background: 
                linear-gradient(to bottom, transparent 75%, var(--bg-main) 100%),
                linear-gradient(90deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.6) 40%, rgba(15, 23, 42, 0) 100%),
                url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : asset('assets/images/hero-bg.jpg') }}') center/cover no-repeat;
            min-height: 200vh; /* Made extremely long downwards */
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            padding: 30vh 5% 150px 12%; /* Added left padding to clear the sidebar */
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
            margin: 0;
            text-align: left;
            position: relative;
            z-index: 10;
        }

        .hero-floating-bar {
            position: absolute;
            bottom: 285px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 850px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-pill);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            z-index: 20;
        }

        .hero-floating-item {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
            padding: 10px;
            text-decoration: none;
            color: var(--text-dark);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: var(--radius-md);
        }

        .hero-floating-item:nth-last-child(2) {
            border-right: none;
        }

        .hero-floating-item:hover {
            background: rgba(37, 99, 235, 0.04);
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.1);
        }

        .hero-floating-icon {
            width: 45px;
            height: 45px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .hero-floating-item:hover .hero-floating-icon {
            background: var(--primary);
            color: var(--white);
            transform: scale(1.15) rotate(-8deg);
        }

        .hero-floating-text h4 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-dark);
        }

        .hero-floating-text p {
            font-size: 0.8rem;
            color: #475569; /* Darker slate for better readability */
            margin: 0;
            line-height: 1.2;
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .hero-floating-bar {
                flex-direction: column;
                bottom: 20px;
                padding: 15px;
                border-radius: var(--radius-lg);
            }
            .hero-floating-item {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                width: 100%;
            }
            .hero-floating-item:nth-last-child(2) {
                border-bottom: none;
            }
            .hero-floating-btn {
                width: 100%;
                border-radius: var(--radius-md);
                margin-left: 0;
                margin-top: 15px;
                height: 45px;
            }
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
            position: absolute;
            bottom: 420px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            background: transparent;
            border: none;
            padding: 0;
            box-shadow: none;
            z-index: 20;
            width: max-content;
        }

        .demo-item {
            display: flex;
            align-items: center;
            gap: 15px;
            color: var(--white);
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .demo-item:hover {
            background: rgba(15, 23, 42, 0.8);
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .demo-icon {
            font-size: 1.6rem;
            color: var(--accent);
        }

        .demo-number {
            font-size: 1.3rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: 0.5px;
        }

        .demo-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-top: 4px;
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

        .close-video-btn, .close-image-btn {
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

        .close-video-btn:hover, .close-image-btn:hover {
            color: var(--accent);
        }

        /* Image Modal */
        .image-modal {
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

        .image-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .image-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(5px);
        }

        .image-modal-content {
            position: relative;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            z-index: 2;
            transform: translateY(20px) scale(0.95);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-modal.active .image-modal-content {
            transform: translateY(0) scale(1);
        }

        .image-modal-img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            object-fit: contain;
        }

        .image-modal-caption {
            color: white;
            margin-top: 15px;
            font-size: 1.1rem;
            text-align: center;
            font-weight: 600;
        }

        .modal-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 15px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
            z-index: 10;
        }

        .modal-nav-btn:hover {
            background: var(--accent);
        }

        .modal-prev {
            left: -60px;
        }

        .modal-next {
            right: -60px;
        }
        
        @media(max-width: 768px) {
            .modal-prev { left: -10px; }
            .modal-next { right: -10px; }
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
                position: relative;
                bottom: auto;
                left: auto;
                transform: none;
                flex-direction: column;
                width: 100%;
                margin-top: 40px;
                gap: 15px;
            }
            .demo-item {
                width: 100%;
                justify-content: center;
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
            overflow-x: auto;
            gap: 20px;
            padding-bottom: 20px;
            scrollbar-width: thin;
        }
        
        .umkm-scroll .info-card,
        .umkm-scroll .card-item,
        .umkm-scroll .umkm-card {
            min-width: 320px;
            flex: 0 0 auto;
        }
        .umkm-scroll::-webkit-scrollbar {
            display: none;
        }
        .umkm-scroll .info-card,
        .umkm-scroll .umkm-card {
            flex: 0 0 350px;
            scroll-snap-align: start;
        }

        /* --- MODERN PRODUCT CARD FOR UMKM --- */
        .umkm-card {
            position: relative;
            background: var(--white);
            border-radius: 24px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0,0,0,0.04);
            text-decoration: none;
        }
        
        .umkm-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .umkm-card .card-image-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 4/3;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .umkm-card .card-image-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .umkm-card:hover .card-image-bg {
            transform: scale(1.08);
        }

        .umkm-card .card-top-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(5px);
            color: var(--primary-dark);
            padding: 6px 12px;
            border-radius: var(--radius-pill);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            z-index: 2;
        }

        .umkm-card .featured-badge {
            left: auto;
            right: 12px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .umkm-card .card-content {
            padding: 0 10px 10px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .umkm-card .card-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .umkm-card .card-owner {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .umkm-card .card-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .umkm-card .card-meta-list {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
            padding-top: 15px;
            border-top: 1px dashed var(--border-color);
        }

        .umkm-card .card-meta-item {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .umkm-card .card-meta-item i {
            color: var(--primary);
            width: 14px;
            text-align: center;
            margin-top: 2px;
        }

        .umkm-card .umkm-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .umkm-card .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 700;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            color: white;
        }

        .umkm-card .btn-wa { background-color: #25d366; }
        .umkm-card .btn-wa:hover { background-color: #128c7e; transform: translateY(-2px); }
        .umkm-card .btn-ig { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
        .umkm-card .btn-ig:hover { opacity: 0.9; transform: translateY(-2px); }
        .umkm-card .btn-fb { background-color: #1877f2; }
        .umkm-card .btn-fb:hover { background-color: #0d65d9; transform: translateY(-2px); }
        .umkm-card .btn-maps { background-color: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-color); }
        .umkm-card .btn-maps:hover { background-color: #e2e8f0; transform: translateY(-2px); }
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
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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

        /* News Reference Card Styles */
        .news-ref-card {
            display: flex; 
            height: 280px; 
            border-radius: var(--radius-lg); 
            overflow: hidden; 
            background: #f8fafc; 
            border: 1px solid #cbd5e1; /* Added darker visible border */
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            text-decoration: none; 
            color: inherit; 
            transition: all 0.3s ease;
        }
        .news-ref-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .news-ref-card:hover .ref-card-img {
            transform: scale(1.08);
        }
        .news-ref-label {
            width: 45px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-right: 1px solid #e2e8f0;
        }
        .news-ref-label span {
            writing-mode: vertical-rl; 
            transform: rotate(180deg); 
            color: #94a3b8; 
            font-weight: 800; 
            font-size: 0.9rem; 
            letter-spacing: 3px; 
            text-transform: uppercase;
            white-space: nowrap;
        }
        .news-ref-content {
            flex: 1; 
            position: relative; 
            overflow: hidden;
        }
        .ref-card-img {
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .news-ref-overlay {
            position: absolute; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            padding: 80px 20px 20px; 
            background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.6) 50%, transparent 100%); 
            display: flex; 
            flex-direction: column; 
            justify-content: flex-end;
        }
        .news-ref-title {
            color: var(--white); 
            font-size: 1.15rem; 
            font-weight: 700; 
            margin: 0 0 8px 0; 
            line-height: 1.4; 
            display: -webkit-box; 
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical; 
            overflow: hidden;
        }
        .news-ref-meta {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem; 
            line-height: 1.4;
            margin: 0;
            display: -webkit-box; 
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical; 
            overflow: hidden;
        }
        .news-ref-views {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }
        .news-ref-date {
            position: absolute; 
            top: 20px; 
            right: 20px; 
            text-align: right; 
            line-height: 1;
            z-index: 2;
        }
        .news-ref-date .day {
            color: var(--white); 
            font-size: 1.5rem; 
            font-weight: 900; 
            text-shadow: 0 2px 8px rgba(0,0,0,0.6);
        }
        .news-ref-date .month {
            color: var(--white); 
            font-size: 0.85rem; 
            font-weight: 700; 
            text-shadow: 0 2px 8px rgba(0,0,0,0.6); 
            text-transform: uppercase;
        }
        .grid-news {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 335px), 1fr)); /* Use auto-fill to prevent stretching */
            gap: 30px;
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

            <div class="hero-actions" style="display: flex; gap: 15px; margin-top: 40px; flex-wrap: wrap; justify-content: flex-start; align-items: center; margin-left: 0; padding-left: 0;">
                <a href="{{ route('profile') }}" class="btn-solid" style="background-color: var(--primary); color: white; padding: 14px 35px; border-radius: var(--radius-pill); font-weight: 600; font-size: 1.1rem; text-decoration: none; transition: all 0.3s ease; border: 2px solid var(--primary); display: inline-flex; align-items: center; gap: 10px; margin: 0;">
                    Jelajahi Desa <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('news') }}" class="btn-outline" style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px); color: white; padding: 14px 35px; border-radius: var(--radius-pill); font-weight: 600; font-size: 1.1rem; text-decoration: none; transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.5); display: inline-flex; align-items: center; gap: 10px; margin: 0;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'; this.style.borderColor='white'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.5)'">
                    <i class="fa-regular fa-newspaper"></i> Berita Desa
                </a>
            </div>
        </div>

        <!-- Demographics Bar -->
            <div class="hero-demographics">
                <div class="demo-item">
                    <i class="fa-solid fa-users demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ $demografi->total_penduduk ? ($demografi->total_penduduk->male_count + $demografi->total_penduduk->female_count) : 0 }}</div>
                        <div class="demo-label">Total Penduduk</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-house-chimney demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ $villageDetail->rt_count ?? 0 }}</div>
                        <div class="demo-label">Rukun Tetangga</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-building demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ $villageDetail->rw_count ?? 0 }}</div>
                        <div class="demo-label">Rukun Warga</div>
                    </div>
                </div>
                <div class="demo-item">
                    <i class="fa-solid fa-map-location-dot demo-icon"></i>
                    <div>
                        <div class="demo-number">{{ $demografi->luas_wilayah->male_count ?? 0 }} <span style="font-size: 0.8em; opacity: 0.8;">Ha</span></div>
                        <div class="demo-label">Luas Wilayah</div>
                    </div>
                </div>
            </div>
            
        

        <!-- POTENSI DESA FLOATING BAR -->
        @if(($profile->show_potency_on_home ?? true) && (($profile->publish_agriculture ?? true) || ($profile->publish_umkm ?? true) || ($profile->publish_tourism ?? true)))
        <div class="hero-floating-bar">
            @if($profile->publish_agriculture ?? true)
            <a href="{{ route('potensi.agriculture') }}" class="hero-floating-item">
                <div class="hero-floating-icon"><i class="fa-solid fa-wheat-awn"></i></div>
                <div class="hero-floating-text">
                    <h4>Pertanian</h4>
                </div>
            </a>
            <a href="{{ route('potensi.agriculture') }}" class="hero-floating-item">
                <div class="hero-floating-icon"><i class="fa-solid fa-cow"></i></div>
                <div class="hero-floating-text">
                    <h4>Peternakan</h4>
                </div>
            </a>
            @endif

            @if($profile->publish_umkm ?? true)
            <a href="{{ route('umkm') }}" class="hero-floating-item">
                <div class="hero-floating-icon"><i class="fa-solid fa-shop"></i></div>
                <div class="hero-floating-text">
                    <h4>UMKM</h4>
                </div>
            </a>
            @endif

            @if($profile->publish_tourism ?? true)
            <a href="{{ route('tourism') }}" class="hero-floating-item">
                <div class="hero-floating-icon"><i class="fa-solid fa-mountain-sun"></i></div>
                <div class="hero-floating-text">
                    <h4>Pariwisata</h4>
                </div>
            </a>
            @endif
            

        </div>
        @endif

    </section>

    <!-- ANCHOR POINT FOR EXPLORE -->
    <div id="potensi"></div>
    <div id="explore"></div>

    @foreach($sectionsOrder as $section)
        @if($section === 'about')
            <!-- SAMBUTAN KEPALA DESA SECTION -->
            @if($profile->publish_about ?? true)
            <section class="welcome-section" style="padding: 20px 5%;">
                <div class="section-card" style="width: 100%; max-width: 1400px; margin: 0 auto;">
                    <div class="welcome-grid">
                        <!-- Col 1: Video Profil Desa -->
                        <div class="welcome-col-image" style="position: relative; width: 100%; aspect-ratio: 16/9;">
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
                            <div class="hero-video-card" onclick="openVideoModal()" style="width: 100%; height: 100%; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.3s ease;">
                                <img src="{{ $ytThumbnail }}" alt="Video Profil Desa" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onerror="this.onerror=null;this.src='https://img.youtube.com/vi/{{ $ytVideoId }}/hqdefault.jpg';" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                <div class="play-btn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 70px; height: 70px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; z-index: 2; transition: all 0.3s ease; box-shadow: 0 0 20px rgba(0,0,0,0.3);" onmouseover="this.parentElement.querySelector('img').style.transform='scale(1.05)'; this.style.transform='translate(-50%, -50%) scale(1.1)'; this.style.backgroundColor='var(--accent-hover)'" onmouseout="this.parentElement.querySelector('img').style.transform='scale(1)'; this.style.transform='translate(-50%, -50%) scale(1)'; this.style.backgroundColor='var(--accent)'">
                                    <i class="fa-solid fa-play" style="margin: 0; transform: translateX(0px);"></i>
                                </div>
                            </div>
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
            <!-- POTENSI DESA SECTION MOVED TO HERO FLOATING BAR -->
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
                        <div class="umkm-card">
                            <a href="{{ route('umkm.detail', $umkm->slug) }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></a>
                            
                            <div class="card-image-wrapper">
                                <img src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset($umkm->thumbnail) }}" alt="{{ $umkm->title }}" class="card-image-bg" loading="lazy">
                                
                                <div class="card-top-badge" style="color: var(--primary-dark);">
                                    {{ $umkm->category->name ?? 'Lokal' }}
                                </div>
                                
                                @if($umkm->is_featured)
                                <div class="card-top-badge featured-badge">
                                    <i class="fa-solid fa-star"></i> Unggulan
                                </div>
                                @endif
                            </div>

                            <div class="card-content">
                                <h3 class="card-title">{{ $umkm->title }}</h3>
                                
                                <div class="card-owner">
                                    <i class="fa-solid fa-circle-user"></i> {{ $umkm->owner_name }}
                                </div>

                                <p class="card-desc">
                                    {{ Str::limit(strip_tags($umkm->description), 80) }}
                                </p>
                                
                                <div class="card-meta-list">
                                    <div class="card-meta-item">
                                        <i class="fa-solid fa-location-dot"></i> <span>{{ Str::limit($umkm->address, 45) }}</span>
                                    </div>
                                    @if($umkm->operating_hours)
                                    <div class="card-meta-item">
                                        <i class="fa-solid fa-clock"></i> <span>{{ $umkm->operating_hours }}</span>
                                    </div>
                                    @endif
                                </div>

                                <div class="umkm-actions">
                                    @if($umkm->whatsapp)
                                        <a href="https://wa.me/{{ $umkm->whatsapp }}?text=Halo%20{{ rawurlencode($umkm->owner_name) }},%20saya%20tertarik%20dengan%20produk%20{{ rawurlencode($umkm->title) }}%20yang%20saya%20lihat%20di%20Website%20Resmi%20Desa%20Duren." 
                                           target="_blank" class="action-btn btn-wa" title="WhatsApp">
                                            <i class="fa-brands fa-whatsapp"></i> WA
                                        </a>
                                    @endif
                                    
                                    @if($umkm->instagram)
                                        <a href="https://instagram.com/{{ $umkm->instagram }}" target="_blank" class="action-btn btn-ig" title="Instagram">
                                            <i class="fa-brands fa-instagram"></i> IG
                                        </a>
                                    @endif

                                    @if($umkm->facebook)
                                        <a href="https://facebook.com/{{ $umkm->facebook }}" target="_blank" class="action-btn btn-fb" title="Facebook">
                                            <i class="fa-brands fa-facebook-f"></i> FB
                                        </a>
                                    @endif

                                    @if($umkm->google_maps_url)
                                        <a href="{{ $umkm->google_maps_url }}" target="_blank" class="action-btn btn-maps" title="Lokasi Maps">
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
                        <a href="{{ route('tourism.detail', $wisata->slug) }}" class="card-item">
                            @if($wisata->thumbnail)
                            <img src="{{ Str::startsWith($wisata->thumbnail, 'http') ? $wisata->thumbnail : asset($wisata->thumbnail) }}" alt="{{ $wisata->title }}" class="card-image-bg">
                            @else
                            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $wisata->title }}" class="card-image-bg">
                            @endif

                            <div class="card-overlay"></div>

                            <div class="card-content">
                                <div class="card-top-badge featured">Destinasi Wisata</div>

                                <div class="card-bottom-info">
                                    <h3 class="card-title">{{ $wisata->title }}</h3>
                                    <hr class="card-divider">
                                    
                                    <div class="card-subtitle">
                                        <i class="fa-solid fa-location-dot"></i> 
                                        {{ Str::limit($wisata->address ?? 'Desa Duren', 40) }}
                                    </div>
                                    
                                    <p class="card-desc">{{ Str::limit(strip_tags($wisata->description), 100) }}</p>
                                    
                                    <span class="card-action-btn">Lihat Detail</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        
                        @foreach($cultures as $culture)
                        <a href="{{ route('culture.detail', $culture->slug) }}" class="card-item">
                            @if($culture->thumbnail)
                            <img src="{{ Str::startsWith($culture->thumbnail, 'http') ? $culture->thumbnail : asset($culture->thumbnail) }}" alt="{{ $culture->title }}" class="card-image-bg">
                            @else
                            <img src="https://images.unsplash.com/photo-1590075865003-e48277faa558?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $culture->title }}" class="card-image-bg">
                            @endif

                            <div class="card-overlay"></div>

                            <div class="card-content">
                                <div class="card-top-badge featured">Cagar Budaya</div>

                                <div class="card-bottom-info">
                                    <h3 class="card-title">{{ $culture->title }}</h3>
                                    <hr class="card-divider">
                                    
                                    <div class="card-subtitle">
                                        <i class="fa-solid fa-location-arrow"></i> 
                                        {{ Str::limit($culture->location ?? 'Desa Duren', 40) }}
                                    </div>
                                    
                                    <p class="card-desc">{{ Str::limit(strip_tags($culture->description), 100) }}</p>
                                    
                                    <span class="card-action-btn">Lihat Detail</span>
                                </div>
                            </div>
                        </a>
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
            
                    <div class="grid-news">
                        @foreach($news as $item)
                        <a href="{{ route('news.detail', $item->slug) }}" class="news-ref-card">
                            <!-- Left Vertical Label -->
                            <div class="news-ref-label">
                                <span>{{ $item->category->name ?? 'BERITA' }}</span>
                            </div>
                            
                            <!-- Right Image & Content Area -->
                            <div class="news-ref-content">
                                <!-- Background Image -->
                                <img src="{{ Str::startsWith($item->featured_image, 'http') ? $item->featured_image : asset($item->featured_image) }}"
                                     alt="{{ $item->title }}" class="ref-card-img">
                                
                                <!-- Top Left Views -->
                                <div class="news-ref-views">
                                    <i class="fa-solid fa-eye"></i> {{ number_format($item->views, 0, ',', '.') }}
                                </div>

                                <!-- Top Right Date Block -->
                                <div class="news-ref-date">
                                    <div class="day">{{ \Carbon\Carbon::parse($item->published_at)->format('d') }}</div>
                                    <div class="month">{{ \Carbon\Carbon::parse($item->published_at)->format('M') }}</div>
                                </div>
                                
                                <!-- Bottom Gradient Overlay -->
                                <div class="news-ref-overlay">
                                    <h3 class="news-ref-title">{{ $item->title }}</h3>
                                    <p class="news-ref-meta">
                                        {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 80) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        @elseif($section === 'gallery')
            <!-- GALERI DESA -->
            @if($profile->show_gallery_on_home ?? true)
            <style>
                .gallerySwiper .swiper-slide {
                    cursor: pointer;
                }
                .gallerySwiper .swiper-slide-active:hover {
                    transform: scale(1.08);
                }
                .gallerySwiper .swiper-slide img {
                    transition: transform 0.3s ease;
                }
            </style>
            <section id="galeri" class="section">
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <span class="section-subtitle">{{ $profile->gallery_subtitle ?? 'Pesona Desa' }}</span>
                        <h2 class="section-title">{{ $profile->gallery_title ?? 'Galeri Desa' }}</h2>
                    </div>
                    <div class="swiper gallerySwiper">
                        <div class="swiper-wrapper">
                            @foreach($galleries as $gallery)
                            <div class="swiper-slide" onclick="openImageModal({{ $loop->index }})" style="cursor: pointer;">
                                <img src="{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset($gallery->image) }}" 
                                     alt="{{ $gallery->caption ?? 'Galeri Desa' }}" 
                                     draggable="false">
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
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

    <!-- Image Modal Structure -->
    <div id="image-modal" class="image-modal">
        <div class="image-modal-overlay" onclick="closeImageModal()"></div>
        <div class="image-modal-content">
            <button class="close-image-btn" onclick="closeImageModal()"><i class="fa-solid fa-xmark"></i></button>
            <button class="modal-nav-btn modal-prev" onclick="navigateModal(-1)"><i class="fa-solid fa-chevron-left"></i></button>
            <img id="modal-image" class="image-modal-img" src="" alt="Galeri" style="cursor: pointer;" onclick="navigateModal(1)" title="Klik untuk gambar selanjutnya">
            <button class="modal-nav-btn modal-next" onclick="navigateModal(1)"><i class="fa-solid fa-chevron-right"></i></button>
            <div id="modal-caption" class="image-modal-caption"></div>
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

        // Image Modal Functions
        const galleryData = [
            @foreach($galleries as $gallery)
                {
                    src: "{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset($gallery->image) }}",
                    caption: "{{ $gallery->caption ?? 'Galeri Desa' }}"
                },
            @endforeach
        ];
        
        let currentModalIndex = 0;

        function openImageModal(index) {
            if (galleryData.length === 0) return;
            currentModalIndex = index;
            updateModalContent();
            
            const modal = document.getElementById('image-modal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function navigateModal(direction) {
            currentModalIndex += direction;
            if (currentModalIndex < 0) {
                currentModalIndex = galleryData.length - 1; // loop to end
            } else if (currentModalIndex >= galleryData.length) {
                currentModalIndex = 0; // loop to start
            }
            updateModalContent();
        }

        function updateModalContent() {
            const img = document.getElementById('modal-image');
            const cap = document.getElementById('modal-caption');
            const data = galleryData[currentModalIndex];
            
            img.src = data.src;
            cap.innerText = data.caption;
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".gallerySwiper", {
                slidesPerView: "auto",
                spaceBetween: -30, // Negative space pulls side images behind the center image
                centeredSlides: true,
                grabCursor: true,
                loop: false,
                initialSlide: 1,
                speed: 600,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                }
            });
        });
    </script>
@endsection