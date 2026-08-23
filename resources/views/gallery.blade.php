@extends('layouts.app')

@section('title', 'Galeri Dokumentasi Kegiatan - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .gallery-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .gallery-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .gallery-hero p {
        font-size: 1.2rem;
        color: #d1d5db;
        max-width: 750px;
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

    /* --- CONTAINER --- */
    .gallery-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5% 80px;
    }

    /* --- GRID SYSTEM --- */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .gallery-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .gallery-image-wrapper {
        position: relative;
        width: 100%;
        padding-top: 65%; /* 16:10 Aspect Ratio */
        overflow: hidden;
        background: #f1f5f9;
    }

    .gallery-image-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .gallery-image-wrapper img {
        transform: scale(1.06);
    }

    .gallery-info {
        padding: 20px 25px;
        background: var(--white);
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .gallery-caption {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.4;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 8px;
        border-top: 1px dashed var(--border-color);
        padding-top: 12px;
        margin-top: auto;
    }

    /* --- LIGHTBOX MODAL --- */
    .lightbox {
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease;
        padding: 20px;
    }

    .lightbox.active {
        opacity: 1;
        pointer-events: all;
    }

    .lightbox-close {
        position: absolute;
        top: 30px;
        right: 40px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--white);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10002;
    }

    .lightbox-close:hover {
        background: var(--accent);
        border-color: var(--accent);
        transform: rotate(90deg);
    }

    .lightbox-content {
        max-width: 90%;
        max-height: 80vh;
        position: relative;
        transform: scale(0.9);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        border-radius: 12px;
        overflow: hidden;
    }

    .lightbox.active .lightbox-content {
        transform: scale(1);
    }

    .lightbox-image {
        display: block;
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
    }

    .lightbox-caption {
        color: var(--white);
        margin-top: 20px;
        text-align: center;
        max-width: 800px;
        font-size: 1.2rem;
        font-weight: 600;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .lightbox-meta {
        font-size: 0.9rem;
        color: #94a3b8;
        margin-top: 8px;
    }

    /* --- PAGINATION STYLING --- */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .gallery-hero h1 {
            font-size: 2.2rem;
        }
        .gallery-grid {
            grid-template-columns: 1fr;
        }
        .lightbox-close {
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="gallery-hero">
    <div class="breadcrumb">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Beranda</a>
        <span class="separator"><i class="fa-solid fa-chevron-right" style="font-size: 0.8rem;"></i></span>
        <span class="current">Galeri Desa</span>
    </div>
    <h1>Galeri Kegiatan Desa</h1>
    <p>Dokumentasi foto berbagai kegiatan sosial, pembangunan sarana prasarana, keagamaan, kebudayaan, serta potensi pariwisata di Desa Duren.</p>
</section>

<!-- Gallery Grid Section -->
<div class="gallery-container">
    <div class="gallery-grid">
        @forelse($galleries as $gallery)
            <div class="gallery-card" onclick="openLightbox('{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset($gallery->image) }}', '{{ addslashes($gallery->caption ?? 'Dokumentasi Kegiatan Desa') }}', '{{ $gallery->created_at ? $gallery->created_at->format('d M Y') : '' }}')">
                <div class="gallery-image-wrapper">
                    @if($gallery->is_featured)
                        <span style="position: absolute; top: 15px; right: 15px; background: var(--accent); color: var(--text-dark); font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: var(--radius-sm); z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.15); display: inline-flex; align-items: center; gap: 4px; border: 1px solid rgba(255,255,255,0.25);">
                            <i class="fa-solid fa-star" style="color: #d97706;"></i> Beranda
                        </span>
                    @endif
                    <img src="{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset($gallery->image) }}" 
                         alt="{{ $gallery->caption ?? 'Galeri Desa' }}"
                         loading="lazy">
                </div>
                <div class="gallery-info">
                    <div class="gallery-caption">{{ $gallery->caption ?? 'Dokumentasi Kegiatan Desa' }}</div>
                    <div class="gallery-meta">
                        <i class="fa-regular fa-calendar"></i>
                        <span>{{ $gallery->created_at ? $gallery->created_at->format('d M Y') : 'Tanggal tidak terdaftar' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--text-muted); background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                <i class="fa-regular fa-images" style="font-size: 3.5rem; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                <p style="font-size: 1.1rem; font-weight: 500;">Belum ada dokumentasi foto galeri desa saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="pagination-wrapper">
            {{ $galleries->links() }}
        </div>
    @endif
</div>

<!-- Lightbox Pop-up -->
<div id="gallery-lightbox" class="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></button>
    <div class="lightbox-content">
        <img id="lightbox-img" class="lightbox-image" src="" alt="Zoomed Image">
    </div>
    <div id="lightbox-caption" class="lightbox-caption"></div>
    <div id="lightbox-meta" class="lightbox-meta"></div>
</div>
@endsection

@section('scripts')
<script>
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxMeta = document.getElementById('lightbox-meta');

    function openLightbox(imageSrc, captionText, dateText) {
        lightboxImg.src = imageSrc;
        lightboxCaption.textContent = captionText || 'Dokumentasi Kegiatan Desa';
        lightboxMeta.innerHTML = dateText ? `<i class="fa-regular fa-calendar"></i> ${dateText}` : '';
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Stop page scrolling
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = ''; // Restore page scrolling
        // Clear src after fade transition
        setTimeout(() => {
            lightboxImg.src = '';
        }, 400);
    }

    // Close lightbox on click outside the image
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Close lightbox on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
            closeLightbox();
        }
    });
</script>
@endsection
