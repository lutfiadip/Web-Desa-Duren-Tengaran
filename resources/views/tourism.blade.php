@extends('layouts.app')

@section('title', 'Wisata & Budaya Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .tourism-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ asset($profile->hero_bg_image ?? "https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80") }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .tourism-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .tourism-hero p {
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

    /* --- CONTAINER --- */
    .tourism-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    /* --- SECTIONS --- */
    .section-title-wrapper {
        margin-bottom: 40px;
        text-align: center;
        position: relative;
    }

    .section-subtitle {
        color: var(--primary);
        font-size: 0.9rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: block;
        margin-bottom: 10px;
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .section-divider {
        width: 80px;
        height: 4px;
        background-color: var(--accent);
        margin: 0 auto;
        border-radius: var(--radius-pill);
    }

    /* --- GRID --- */
    .tourism-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
        gap: 30px;
        margin-bottom: 80px;
    }

    .culture-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
        gap: 30px;
    }

    /* --- CARDS --- */
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
    }

    .card-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .card-image-wrapper {
        position: relative;
        height: 260px;
        overflow: hidden;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .card-item:hover .card-image {
        transform: scale(1.05);
    }

    .card-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: var(--primary);
        color: var(--white);
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 0.8rem;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .card-badge.featured {
        background-color: var(--accent);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
    }

    .card-body {
        padding: 30px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-item-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .card-item-desc {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    /* --- DETAILS / METADATA --- */
    .card-meta-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .card-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .card-meta-item:last-child {
        margin-bottom: 0;
    }

    .card-meta-item i {
        color: var(--primary);
        font-size: 1.05rem;
        width: 20px;
        text-align: center;
        margin-top: 2px;
    }

    .card-meta-item strong {
        color: var(--text-dark);
    }

    /* Facility Tags */
    .facility-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 20px;
    }

    .facility-tag {
        background-color: rgba(37, 99, 235, 0.05);
        color: var(--primary);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
        border: 1px solid rgba(37, 99, 235, 0.1);
    }

    /* Card Actions */
    .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-action.primary {
        background-color: var(--primary);
        color: var(--white);
        border: none;
    }

    .btn-action.primary:hover {
        background-color: var(--primary-hover);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    .btn-action.outline {
        background-color: transparent;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
    }

    .btn-action.outline:hover {
        background-color: var(--bg-main);
        border-color: #cbd5e1;
    }

    .no-data-alert {
        text-align: center;
        padding: 40px;
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
    }

    @media (max-width: 992px) {
        .tourism-grid, .culture-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

    <!-- HERO SECTION -->
    <section class="tourism-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Wisata & Budaya</span>
        </nav>
        <h1>Wisata & Budaya</h1>
        <p>Jelajahi pesona keindahan alam tersembunyi dan kekayaan warisan seni budaya leluhur di Desa Duren.</p>
    </section>

    <!-- CONTENT CONTAINER -->
    <div class="tourism-container">

        <!-- TOURISM SECTION -->
        <section style="margin-bottom: 80px;">
            <div class="section-title-wrapper">
                <span class="section-subtitle">Destinasi Alam</span>
                <h2 class="section-title">Objek Wisata Unggulan</h2>
                <div class="section-divider"></div>
            </div>

            <div class="tourism-grid">
                @forelse($attractions as $attraction)
                    <div class="card-item">
                        <a href="{{ route('tourism.detail', $attraction->slug) }}" class="card-image-wrapper">
                            @if($attraction->thumbnail)
                                <img src="{{ Str::startsWith($attraction->thumbnail, 'http') ? $attraction->thumbnail : asset('storage/' . $attraction->thumbnail) }}" alt="{{ $attraction->title }}" class="card-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $attraction->title }}" class="card-image">
                            @endif

                            @if($attraction->is_featured)
                                <span class="card-badge featured"><i class="fa-solid fa-star" style="margin-right: 5px;"></i> Terfavorit</span>
                            @else
                                <span class="card-badge">Wisata Desa</span>
                            @endif
                        </a>

                        <div class="card-body">
                            <a href="{{ route('tourism.detail', $attraction->slug) }}" style="text-decoration: none; color: inherit;">
                                <h3 class="card-item-title">{{ $attraction->title }}</h3>
                            </a>
                            <p class="card-item-desc">{{ Str::limit($attraction->description, 130) }}</p>
                            
                            @if($attraction->facilities)
                                <div class="facility-container" style="margin-top: 15px;">
                                    @foreach(explode(',', $attraction->facilities) as $facility)
                                        <span class="facility-tag">{{ trim($facility) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <ul class="card-meta-list" style="margin-top: 15px;">
                                <li class="card-meta-item">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    <span><strong>Lokasi:</strong> {{ Str::limit($attraction->address, 60) }}</span>
                                </li>
                                <li class="card-meta-item">
                                    <i class="fa-solid fa-ticket"></i>
                                    <span><strong>Tiket Masuk:</strong> 
                                        @if($attraction->ticket_price > 0)
                                            Rp {{ number_format($attraction->ticket_price, 0, ',', '.') }}
                                        @else
                                            Gratis / Sukarela
                                        @endif
                                    </span>
                                </li>
                            </ul>

                            <div class="card-actions" style="margin-top: auto;">
                                <a href="{{ route('tourism.detail', $attraction->slug) }}" class="btn-action primary">
                                    <i class="fa-solid fa-circle-info"></i> Lihat Detail
                                </a>
                                <a href="{{ $attraction->google_maps_url ?? 'https://maps.google.com' }}" target="_blank" class="btn-action outline">
                                    <i class="fa-solid fa-route"></i> Petunjuk Rute
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-data-alert" style="grid-column: 1 / -1;">
                        <i class="fa-solid fa-map-pin" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                        <h3>Belum Ada Destinasi Wisata</h3>
                        <p>Konten pariwisata sedang dalam tahap penyusunan oleh Pemerintah Desa.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- CULTURE SECTION -->
        <section>
            <div class="section-title-wrapper">
                <span class="section-subtitle">Warisan Leluhur</span>
                <h2 class="section-title">Kesenian & Kebudayaan</h2>
                <div class="section-divider"></div>
            </div>

            <div class="culture-grid">
                @forelse($cultures as $culture)
                    <div class="card-item">
                        <a href="{{ route('culture.detail', $culture->slug) }}" class="card-image-wrapper">
                            @if($culture->thumbnail)
                                <img src="{{ Str::startsWith($culture->thumbnail, 'http') ? $culture->thumbnail : asset('storage/' . $culture->thumbnail) }}" alt="{{ $culture->title }}" class="card-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1590075865003-e48277faa558?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $culture->title }}" class="card-image">
                            @endif

                            @if($culture->is_featured)
                                <span class="card-badge featured"><i class="fa-solid fa-award" style="margin-right: 5px;"></i> Cagar Budaya</span>
                            @else
                                <span class="card-badge">Tradisi Seni</span>
                            @endif
                        </a>

                        <div class="card-body">
                            <a href="{{ route('culture.detail', $culture->slug) }}" style="text-decoration: none; color: inherit;">
                                <h3 class="card-item-title">{{ $culture->title }}</h3>
                            </a>
                            <p class="card-item-desc">{{ Str::limit($culture->description, 130) }}</p>

                            <ul class="card-meta-list" style="margin-top: 15px;">
                                <li class="card-meta-item">
                                    <i class="fa-solid fa-location-arrow"></i>
                                    <span><strong>Tempat Pelaksanaan:</strong> {{ $culture->location ?? 'Desa Duren' }}</span>
                                </li>
                            </ul>

                            <div class="card-actions" style="margin-top: auto;">
                                <a href="{{ route('culture.detail', $culture->slug) }}" class="btn-action primary" style="grid-column: 1 / -1;">
                                    <i class="fa-solid fa-circle-info"></i> Lihat Detail Kesenian
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-data-alert" style="grid-column: 1 / -1;">
                        <i class="fa-solid fa-masks-theater" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                        <h3>Belum Ada Kesenian/Kebudayaan</h3>
                        <p>Dokumentasi cagar budaya dan kelompok kesenian sedang didata.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </div>

@endsection
