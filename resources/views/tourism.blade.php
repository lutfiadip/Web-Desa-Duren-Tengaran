@extends('layouts.app')

@section('title', 'Wisata & Budaya Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .tourism-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
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
    
    .card-top-badge.featured.tourism-badge {
        background: rgba(16, 185, 129, 0.7);
        border: 1px solid rgba(16, 185, 129, 0.9);
    }

    .card-bottom-info {
        margin-top: auto;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 15px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        font-family: 'Plus Jakarta Sans', sans-serif;
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

    .card-desc {
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

    .no-data-alert {
        text-align: center;
        padding: 40px;
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
    }

    /* --- SEARCH BAR --- */
    .search-filter-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
    }

    .search-box-wrapper {
        position: relative;
        width: 100%;
    }

    .search-btn {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.2rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        outline: none;
        transition: var(--transition);
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-btn:hover {
        color: var(--primary);
        transform: translateY(-50%) scale(1.15);
    }

    .search-input {
        width: 100%;
        padding: 16px 55px 16px 20px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        background-color: var(--bg-main);
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 500;
        transition: var(--transition);
        outline: none;
    }

    .search-input:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
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

        <!-- SEARCH BAR -->
        <div class="search-filter-card">
            <div class="search-box-wrapper">
                <button type="button" id="search-btn" class="search-btn" title="Cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" id="search-input" class="search-input" placeholder="Cari objek wisata atau kesenian...">
            </div>
        </div>

        <!-- TOURISM SECTION -->
        @if($profile->publish_tourism ?? true)
        <section style="margin-bottom: 80px;">
            <div class="section-title-wrapper">
                <span class="section-subtitle">Destinasi Alam</span>
                <h2 class="section-title">Objek Wisata Unggulan</h2>
                <div class="section-divider"></div>
            </div>

            <div class="tourism-grid">
                @forelse($attractions as $attraction)
                    <a href="{{ route('tourism.detail', $attraction->slug) }}" class="card-item" data-title="{{ strtolower($attraction->title) }}" data-desc="{{ strtolower($attraction->description) }}">
                        @if($attraction->thumbnail)
                            <img src="{{ Str::startsWith($attraction->thumbnail, 'http') ? $attraction->thumbnail : asset($attraction->thumbnail) }}" alt="{{ $attraction->title }}" class="card-image-bg">
                        @else
                            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $attraction->title }}" class="card-image-bg">
                        @endif
                        
                        <div class="card-overlay"></div>

                        <div class="card-content">
                            @if($attraction->is_featured)
                                <div class="card-top-badge featured tourism-badge"><i class="fa-solid fa-star" style="margin-right: 5px;"></i> Terfavorit</div>
                            @else
                                <div class="card-top-badge">Wisata Desa</div>
                            @endif

                            <div class="card-bottom-info">
                                <h3 class="card-title">{{ $attraction->title }}</h3>
                                <hr class="card-divider">
                                
                                <div class="card-subtitle">
                                    <i class="fa-solid fa-location-dot"></i> 
                                    {{ Str::limit($attraction->address, 40) }}
                                </div>
                                
                                <p class="card-desc">{{ strip_tags($attraction->description) }}</p>
                                
                                <span class="card-action-btn">Lihat Detail</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-data-alert" style="grid-column: 1 / -1;">
                        <i class="fa-solid fa-map-pin" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                        <h3>Belum Ada Destinasi Wisata</h3>
                        <p>Konten pariwisata sedang dalam tahap penyusunan oleh Pemerintah Desa.</p>
                    </div>
                @endforelse
            </div>
        </section>
        @endif

        <!-- CULTURE SECTION -->
        @if($profile->publish_culture ?? true)
        <section>
            <div class="section-title-wrapper">
                <span class="section-subtitle">Warisan Leluhur</span>
                <h2 class="section-title">Kesenian & Kebudayaan</h2>
                <div class="section-divider"></div>
            </div>

            <div class="culture-grid">
                @forelse($cultures as $culture)
                    <a href="{{ route('culture.detail', $culture->slug) }}" class="card-item" data-title="{{ strtolower($culture->title) }}" data-desc="{{ strtolower($culture->description) }}">
                        @if($culture->thumbnail)
                            <img src="{{ Str::startsWith($culture->thumbnail, 'http') ? $culture->thumbnail : asset($culture->thumbnail) }}" alt="{{ $culture->title }}" class="card-image-bg">
                        @else
                            <img src="https://images.unsplash.com/photo-1590075865003-e48277faa558?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="{{ $culture->title }}" class="card-image-bg">
                        @endif
                        
                        <div class="card-overlay"></div>

                        <div class="card-content">
                            @if($culture->is_featured)
                                <div class="card-top-badge featured"><i class="fa-solid fa-award" style="margin-right: 5px;"></i> Cagar Budaya</div>
                            @else
                                <div class="card-top-badge">Tradisi Seni</div>
                            @endif

                            <div class="card-bottom-info">
                                <h3 class="card-title">{{ $culture->title }}</h3>
                                <hr class="card-divider">
                                
                                <div class="card-subtitle">
                                    <i class="fa-solid fa-location-arrow"></i> 
                                    {{ Str::limit($culture->location ?? 'Desa Duren', 40) }}
                                </div>
                                
                                <p class="card-desc">{{ strip_tags($culture->description) }}</p>
                                
                                <span class="card-action-btn">Lihat Detail</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-data-alert" style="grid-column: 1 / -1;">
                        <i class="fa-solid fa-masks-theater" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                        <h3>Belum Ada Kesenian/Kebudayaan</h3>
                        <p>Dokumentasi cagar budaya dan kelompok kesenian sedang didata.</p>
                    </div>
                @endforelse
            </div>
        </section>
        @endif

    </div>

    <!-- FILTER SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchBtn = document.getElementById('search-btn');
            
            const tourismGrid = document.querySelector('.tourism-grid');
            const cultureGrid = document.querySelector('.culture-grid');
            
            const tourismCards = tourismGrid ? tourismGrid.querySelectorAll('.card-item:not(.empty-state)') : [];
            const cultureCards = cultureGrid ? cultureGrid.querySelectorAll('.card-item:not(.empty-state)') : [];
            
            // Create empty state elements dynamically if they don't exist
            const createEmptyState = (message) => {
                const div = document.createElement('div');
                div.className = 'no-data-alert search-empty-state';
                div.style.gridColumn = '1 / -1';
                div.style.display = 'none';
                div.innerHTML = `
                    <i class="fa-solid fa-magnifying-glass-minus" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                    <h3>Konten Tidak Ditemukan</h3>
                    <p>${message}</p>
                `;
                return div;
            };

            let tourismEmpty, cultureEmpty;
            if (tourismGrid && tourismCards.length > 0) {
                tourismEmpty = createEmptyState('Maaf, objek wisata yang Anda cari tidak dapat ditemukan.');
                tourismGrid.appendChild(tourismEmpty);
            }
            if (cultureGrid && cultureCards.length > 0) {
                cultureEmpty = createEmptyState('Maaf, kesenian atau kebudayaan yang Anda cari tidak dapat ditemukan.');
                cultureGrid.appendChild(cultureEmpty);
            }

            function filterItems() {
                const query = searchInput.value.toLowerCase().trim();
                
                let tourismMatches = 0;
                tourismCards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const desc = card.getAttribute('data-desc') || '';
                    if (title.includes(query) || desc.includes(query)) {
                        card.style.display = 'flex';
                        tourismMatches++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                if (tourismEmpty) {
                    tourismEmpty.style.display = (tourismMatches === 0 && tourismCards.length > 0) ? 'block' : 'none';
                }

                let cultureMatches = 0;
                cultureCards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const desc = card.getAttribute('data-desc') || '';
                    if (title.includes(query) || desc.includes(query)) {
                        card.style.display = 'flex';
                        cultureMatches++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                if (cultureEmpty) {
                    cultureEmpty.style.display = (cultureMatches === 0 && cultureCards.length > 0) ? 'block' : 'none';
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterItems);
            }
            if (searchBtn && searchInput) {
                searchBtn.addEventListener('click', function() {
                    filterItems();
                    searchInput.focus();
                });
            }
        });
    </script>
@endsection
