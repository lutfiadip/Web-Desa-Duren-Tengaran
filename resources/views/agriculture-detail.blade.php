@extends('layouts.app')

@section('title', $commodity->title . ' - Potensi Pertanian & Peternakan Desa Duren')

@section('styles')
<style>
    /* --- BREADCRUMB --- */
    .breadcrumb-wrapper {
        background-color: transparent;
        border-bottom: none;
        padding: 30px 5% 10px;
    }
    
    .breadcrumb {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .breadcrumb a {
        color: var(--text-muted);
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .breadcrumb a:hover {
        color: var(--primary);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--text-dark);
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* --- LAYOUT GRID --- */
    .detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 50px 5% 80px;
        display: grid;
        grid-template-columns: 8fr 4fr;
        gap: 40px;
    }

    /* --- LEFT COLUMN: CONTENT & GALLERY --- */
    .gallery-wrapper {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        padding: 25px;
        margin-bottom: 35px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .main-image-container {
        width: 100%;
        height: 480px;
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 20px;
        background-color: #f1f5f9;
        position: relative;
    }

    .main-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.15s ease-in-out;
    }

    .thumbnail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 15px;
    }

    .thumbnail-card {
        height: 80px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: var(--transition);
        background-color: #f1f5f9;
    }

    .thumbnail-card.active {
        border-color: var(--primary);
        transform: scale(0.96);
    }

    .thumbnail-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .thumbnail-card:hover img {
        opacity: 0.8;
    }

    .com-content-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .com-header {
        margin-bottom: 25px;
    }

    .com-badge {
        display: inline-block;
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        margin-bottom: 12px;
        letter-spacing: 0.5px;
    }

    .com-content-card h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-dark);
        letter-spacing: -0.5px;
        margin-bottom: 0;
    }

    .com-description {
        font-size: 1.1rem;
        color: var(--text-muted);
        line-height: 1.8;
        text-align: justify;
    }

    .com-description p {
        margin-bottom: 20px;
    }

    .com-description p:last-child {
        margin-bottom: 0;
    }

    /* --- RIGHT COLUMN: SIDEBAR INFO --- */
    .sidebar-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 100px;
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 25px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar-title i {
        color: var(--primary);
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        background-color: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .info-text-wrapper {
        flex-grow: 1;
    }

    .info-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .info-val {
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 700;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background-color: #2563eb;
        color: var(--white);
        padding: 14px 20px;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
        text-align: center;
    }

    .action-btn:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* --- RECOMMENDATIONS --- */
    .recom-section {
        background-color: #f8fafc;
        border-top: 1px solid var(--border-color);
        padding: 70px 5%;
    }

    .recom-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    .recom-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 35px;
    }

    .recom-header h2 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
    }

    .recom-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .recom-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .recom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .recom-img-wrapper {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .recom-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .recom-card:hover .recom-img {
        transform: scale(1.04);
    }

    .recom-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: rgba(37, 99, 235, 0.9);
        color: var(--white);
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .recom-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .recom-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .recom-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .recom-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: var(--transition);
    }

    .recom-link:hover {
        gap: 8px;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .sidebar-card {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 768px) {
        .main-image-container {
            height: 300px;
        }

        .com-content-card {
            padding: 25px;
        }

        .com-content-card h1 {
            font-size: 1.8rem;
        }
    }
</style>
@endsection

@section('content')
    <!-- BREADCRUMB -->
    <div class="breadcrumb-wrapper">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <a href="{{ route('potensi.agriculture') }}">Pertanian & Peternakan</a>
            <span class="separator">/</span>
            <span class="current">{{ $commodity->title }}</span>
        </nav>
    </div>

    <!-- MAIN DETAIL CONTENT -->
    <div class="detail-container">
        
        <!-- LEFT COLUMN -->
        <div class="main-content-column">
            
            <!-- IMAGE GALLERY DISPLAY -->
            <div class="gallery-wrapper">
                <div class="main-image-container">
                    <img id="main-image" src="{{ $commodity->thumbnail ? (Str::startsWith($commodity->thumbnail, 'http') ? $commodity->thumbnail : asset($commodity->thumbnail)) : 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $commodity->title }}">
                </div>
                
                @if(is_array($commodity->gallery) && count($commodity->gallery) > 1)
                    <div class="thumbnail-grid">
                        @foreach($commodity->gallery as $index => $image)
                            <div class="thumbnail-card {{ $index === 0 ? 'active' : '' }}" data-src="{{ Str::startsWith($image, 'http') ? $image : asset($image) }}">
                                <img src="{{ Str::startsWith($image, 'http') ? $image : asset($image) }}" alt="Galeri {{ $commodity->title }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- DETAILED PROFILE & TEXT -->
            <div class="com-content-card">
                <div class="com-header">
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 12px;">
                        <span class="com-badge" style="margin-bottom: 0;">{{ $commodity->category }}</span>
                        @if($commodity->is_featured)
                            <span class="com-badge" style="background-color: rgba(245, 158, 11, 0.15); color: #d97706; margin-bottom: 0;"><i class="fa-solid fa-star"></i> Unggulan</span>
                        @endif
                    </div>
                    <h1>{{ $commodity->title }}</h1>
                </div>
                
                <div class="com-description">
                    {!! nl2br(e($commodity->description)) !!}
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (SIDEBAR) -->
        <div class="sidebar-column">
            <div class="sidebar-card">
                <h3 class="sidebar-title"><i class="fa-solid fa-circle-info"></i> Informasi Komoditas</h3>
                
                <div class="info-list">
                    <!-- Kategori -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div class="info-text-wrapper">
                            <div class="info-label">Kategori Potensi</div>
                            <div class="info-val">{{ $commodity->category }}</div>
                        </div>
                    </div>

                    <!-- Skala Produksi -->
                    @if($commodity->production_scale)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </div>
                            <div class="info-text-wrapper">
                                <div class="info-label">Skala Produksi</div>
                                <div class="info-val">{{ $commodity->production_scale }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Musim Panen / Waktu Produksi -->
                    @if($commodity->harvest_time)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div class="info-text-wrapper">
                                <div class="info-label">Waktu Produksi / Panen</div>
                                <div class="info-val">{{ $commodity->harvest_time }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Dusun Sentra -->
                    @if($commodity->address)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="info-text-wrapper">
                                <div class="info-label">Sentra Dusun</div>
                                <div class="info-val">{{ $commodity->address }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Kontak Hubung -->
                    @if($commodity->contact)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="info-text-wrapper">
                                <div class="info-label">Kontak Pengelola</div>
                                <div class="info-val">{{ $commodity->contact }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($commodity->google_maps_url)
                    <a href="{{ $commodity->google_maps_url }}" target="_blank" class="action-btn">
                        <i class="fa-solid fa-map-location-dot"></i> Petunjuk Rute Lokasi
                    </a>
                @endif
            </div>
        </div>

    </div>

    <!-- RECOMMENDATIONS SECTION -->
    @if(count($otherCommodities) > 0)
        <section class="recom-section">
            <div class="recom-wrapper">
                <div class="recom-header">
                    <h2>Komoditas Unggulan Lainnya</h2>
                    <a href="{{ route('potensi.agriculture') }}" class="recom-link" style="font-size: 1rem; font-weight: 700;">Lihat Semua <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem;"></i></a>
                </div>
                
                <div class="recom-grid">
                    @foreach($otherCommodities as $other)
                        <div class="recom-card">
                            <div class="recom-img-wrapper">
                                <span class="recom-badge">{{ $other->category }}</span>
                                <img src="{{ $other->thumbnail ? (Str::startsWith($other->thumbnail, 'http') ? $other->thumbnail : asset($other->thumbnail)) : 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" alt="{{ $other->title }}" class="com-img">
                            </div>
                            <div class="recom-body">
                                <h3 class="recom-title">{{ $other->title }}</h3>
                                <p class="recom-desc">{{ Str::limit(strip_tags($other->description), 100) }}</p>
                                <a href="{{ route('potensi.agriculture.detail', $other->slug) }}" class="recom-link">Lihat Detail Komoditas <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnails = document.querySelectorAll('.thumbnail-card');
        const mainImage = document.getElementById('main-image');

        thumbnails.forEach(card => {
            card.addEventListener('click', function () {
                // Hapus kelas aktif dari semua thumbnail
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Tambah kelas aktif pada thumbnail yang diklik
                this.classList.add('active');
                
                const newSrc = this.getAttribute('data-src');
                
                // Animasi pergantian gambar halus
                mainImage.style.opacity = '0.1';
                setTimeout(() => {
                    mainImage.setAttribute('src', newSrc);
                    mainImage.style.opacity = '1';
                }, 150);
            });
        });
    });
</script>
@endsection
