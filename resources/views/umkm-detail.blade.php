@extends('layouts.app')

@section('title', $umkm->title . ' - UMKM Desa Duren')

@section('styles')
<style>
    /* --- HERO --- */
    .detail-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $umkm->thumbnail ? (Str::startsWith($umkm->thumbnail, "http") ? $umkm->thumbnail : asset($umkm->thumbnail)) : ($profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "") }}') center/cover no-repeat;
        padding: 180px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .detail-hero h1 {
        font-size: 3.2rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
        line-height: 1.2;
    }
    
    .detail-hero p {
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

    /* --- CONTENT LAYOUT --- */
    .detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }

    /* --- LEFT COLUMN --- */
    .detail-main {
        display: flex;
        flex-direction: column;
        gap: 35px;
    }

    .detail-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    .detail-card h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 15px;
    }

    .detail-card h2 i {
        color: var(--primary);
    }

    .description-text {
        color: var(--text-muted);
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 25px;
        text-align: justify;
    }

    /* --- RIGHT COLUMN (SIDEBAR) --- */
    .detail-sidebar {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .info-box {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    .info-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 12px;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-item i {
        color: var(--primary);
        font-size: 1.2rem;
        margin-top: 3px;
        width: 20px;
        text-align: center;
    }

    .info-item strong {
        color: var(--text-dark);
        display: block;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    /* Sidebar Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-side {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 20px;
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-side.wa {
        background-color: #25d366;
        color: var(--white);
    }

    .btn-side.wa:hover {
        background-color: #20ba5a;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.2);
    }

    .btn-side.ig {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: var(--white);
    }

    .btn-side.ig:hover {
        opacity: 0.95;
        box-shadow: 0 4px 12px rgba(220, 39, 67, 0.2);
    }

    .btn-side.fb {
        background-color: #1877f2;
        color: var(--white);
    }

    .btn-side.fb:hover {
        background-color: #166fe5;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.2);
    }

    .btn-side.map {
        background-color: #f1f5f9;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
    }

    .btn-side.map:hover {
        background-color: #e2e8f0;
    }

    /* --- RECOMMENDATIONS --- */
    .recommendations-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 5% 80px;
    }

    .rec-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    /* --- REUSABLE CARD CSS --- */
    .card-item {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
    }

    .card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    .card-image-wrapper {
        height: 220px;
        overflow: hidden;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-item-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .card-item-desc {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
        }
        .rec-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

    <!-- HERO HEADER -->
    <section class="detail-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <a href="{{ route('umkm') }}">UMKM Desa</a>
            <span class="separator">/</span>
            <span class="current">{{ $umkm->title }}</span>
        </nav>
        <h1>{{ $umkm->title }}</h1>
        <p>Produk Lokal Unggulan Desa Duren, Kecamatan Tengaran</p>
    </section>

    <!-- CONTENT -->
    <div class="detail-container">
        
        <!-- LEFT COLUMN -->
        <div class="detail-main">
            <!-- Deskripsi & Gambar -->
            <div class="detail-card">
                <div class="detail-image-main-wrapper" style="margin-bottom: 15px; border-radius: var(--radius-lg); overflow: hidden; height: 450px; border: 1px solid var(--border-color); box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    @if($umkm->thumbnail)
                        <img id="main-image" src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset($umkm->thumbnail) }}" alt="{{ $umkm->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s ease;">
                    @else
                        <img id="main-image" src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $umkm->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s ease;">
                    @endif
                </div>

                @if(!empty($umkm->gallery) && count($umkm->gallery) > 0)
                    <div class="gallery-thumbnails" style="display: flex; gap: 10px; margin-bottom: 35px; overflow-x: auto; padding-bottom: 10px;">
                        <div class="thumb-item active" onclick="changeMainImage(this, '{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset($umkm->thumbnail) }}')" style="width: 100px; height: 70px; border-radius: 6px; overflow: hidden; border: 2px solid var(--primary); cursor: pointer; flex-shrink: 0; transition: var(--transition);">
                            <img src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset($umkm->thumbnail) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        @foreach($umkm->gallery as $galImg)
                            @if($galImg != $umkm->thumbnail)
                                <div class="thumb-item" onclick="changeMainImage(this, '{{ Str::startsWith($galImg, 'http') ? $galImg : asset($galImg) }}')" style="width: 100px; height: 70px; border-radius: 6px; overflow: hidden; border: 2px solid transparent; cursor: pointer; flex-shrink: 0; transition: var(--transition);">
                                    <img src="{{ Str::startsWith($galImg, 'http') ? $galImg : asset($galImg) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <h2><i class="fa-solid fa-circle-info"></i> Deskripsi UMKM</h2>
                <div class="description-text">
                    {!! nl2br(e($umkm->description)) !!}
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (SIDEBAR) -->
        <div class="detail-sidebar">
            <div class="info-box">
                <h3 class="info-title">Informasi Usaha</h3>
                <ul class="info-list">
                    <li class="info-item">
                        <i class="fa-solid fa-circle-user"></i>
                        <div>
                            <strong>Nama Pemilik</strong>
                            {{ $umkm->owner_name }}
                        </div>
                    </li>
                    <li class="info-item">
                        <i class="fa-solid fa-tags"></i>
                        <div>
                            <strong>Kategori Produk</strong>
                            {{ $umkm->category->name ?? 'Lokal' }}
                        </div>
                    </li>
                    <li class="info-item">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <div>
                            <strong>Alamat Usaha</strong>
                            {{ $umkm->address }}
                        </div>
                    </li>
                    @if($umkm->operating_hours)
                        <li class="info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <strong>Jam Operasional</strong>
                                {{ $umkm->operating_hours }}
                            </div>
                        </li>
                    @endif
                </ul>

                <div class="action-buttons">
                    @if($umkm->whatsapp)
                        <a href="https://wa.me/{{ $umkm->clean_whatsapp }}?text=Halo%20{{ rawurlencode($umkm->owner_name) }},%20saya%20tertarik%20dengan%20produk%20{{ rawurlencode($umkm->title) }}%20yang%20saya%20lihat%20di%20Website%20Resmi%20Desa%20Duren." 
                           target="_blank" class="btn-side wa">
                            <i class="fa-brands fa-whatsapp" style="font-size: 1.3rem;"></i> WhatsApp
                        </a>
                    @endif

                    @if($umkm->instagram)
                        <a href="{{ $umkm->instagram_link }}" target="_blank" class="btn-side ig">
                            <i class="fa-brands fa-instagram" style="font-size: 1.3rem;"></i> Instagram Toko
                        </a>
                    @endif

                    @if($umkm->facebook)
                        <a href="{{ $umkm->facebook_link }}" target="_blank" class="btn-side fb">
                            <i class="fa-brands fa-facebook-f" style="font-size: 1.3rem;"></i> Facebook Profil
                        </a>
                    @endif

                    @if($umkm->google_maps_url)
                        <a href="{{ $umkm->google_maps_url }}" target="_blank" class="btn-side map">
                            <i class="fa-solid fa-route"></i> Petunjuk Arah Peta
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- RECOMMENDATIONS -->
    @if($otherUmkms->count() > 0)
        <section class="recommendations-section">
            <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark); text-align: center; margin-bottom: 10px;">Produk Lokal Lainnya</h2>
            <div style="width: 50px; height: 3px; background-color: var(--accent); margin: 0 auto 35px; border-radius: var(--radius-pill);"></div>
            <div class="rec-grid">
                @foreach($otherUmkms as $other)
                    <a href="{{ route('umkm.detail', $other->slug) }}" class="card-item">
                        <div class="card-image-wrapper">
                            @if($other->thumbnail)
                                <img src="{{ Str::startsWith($other->thumbnail, 'http') ? $other->thumbnail : asset($other->thumbnail) }}" alt="{{ $other->title }}" class="card-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $other->title }}" class="card-image">
                            @endif
                        </div>
                        <div class="card-body">
                            <h3 class="card-item-title">{{ $other->title }}</h3>
                            <p class="card-item-desc">{{ Str::limit($other->description, 100) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <script>
        function changeMainImage(element, imageUrl) {
            const mainImage = document.getElementById('main-image');
            mainImage.style.opacity = 0.3;
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = 1;
            }, 150);

            document.querySelectorAll('.thumb-item').forEach(thumb => {
                thumb.style.borderColor = 'transparent';
                thumb.classList.remove('active');
            });
            element.style.borderColor = 'var(--primary)';
            element.classList.add('active');
        }
    </script>
@endsection

