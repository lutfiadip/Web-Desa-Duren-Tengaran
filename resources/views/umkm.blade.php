@extends('layouts.app')

@section('title', 'UMKM & Produk Unggulan Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .umkm-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .umkm-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .umkm-hero p {
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
    .umkm-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    /* --- SEARCH & FILTER BAR --- */
    .search-filter-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 3fr 1.2fr;
        gap: 20px;
        width: 100%;
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

    .select-box-wrapper {
        position: relative;
        width: 100%;
        background-color: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-pill);
        transition: var(--transition);
        height: 54px;
    }

    .select-box-wrapper:focus-within {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .select-box-wrapper i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
        transition: transform 0.2s ease;
        z-index: 2;
    }

    .select-box-wrapper i.fa-filter {
        left: 20px;
        font-size: 1.1rem;
    }

    .select-box-wrapper i.fa-chevron-down {
        right: 20px;
        font-size: 0.9rem;
    }

    .select-box-wrapper:focus-within i.fa-chevron-down {
        transform: translateY(-50%) rotate(180deg);
    }

    .category-select {
        width: 100%;
        height: 100%;
        padding: 0 45px;
        border: none;
        background: transparent;
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 600;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        text-align: center;
        text-align-last: center;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 1;
    }

    .category-select option {
        text-align: left;
    }

    /* --- GRID --- */
    .umkm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    /* --- CARDS (Modern Product / UMKM) --- */
    .card-item {
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
    
    .card-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .card-image-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-image-bg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .card-item:hover .card-image-bg {
        transform: scale(1.08);
    }

    .card-top-badge {
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

    .featured-badge {
        left: auto;
        right: 12px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .card-content {
        padding: 0 10px 10px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .card-owner {
        font-size: 0.85rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .card-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta-list {
        margin-top: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 20px;
        padding-top: 15px;
        border-top: 1px dashed var(--border-color);
    }

    .card-meta-item {
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .card-meta-item i {
        color: var(--primary);
        width: 14px;
        text-align: center;
        margin-top: 2px;
    }

    .umkm-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        position: relative;
        z-index: 2;
    }

    .action-btn {
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

    .btn-wa { background-color: #25d366; }
    .btn-wa:hover { background-color: #128c7e; transform: translateY(-2px); }
    .btn-ig { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .btn-ig:hover { opacity: 0.9; transform: translateY(-2px); }
    .btn-fb { background-color: #1877f2; }
    .btn-fb:hover { background-color: #0d65d9; transform: translateY(-2px); }
    .btn-maps { background-color: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-color); }
    .btn-maps:hover { background-color: #e2e8f0; transform: translateY(-2px); }

    /* --- EMPTY STATE --- */
    .empty-state {
        grid-column: 1 / -1;
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-muted);
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 1rem;
        max-width: 400px;
        margin: 0;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .umkm-hero h1 {
            font-size: 2.2rem;
        }
        
        .umkm-hero p {
            font-size: 1rem;
        }

        .filter-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .search-filter-card {
            padding: 20px;
        }

        .umkm-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <!-- HERO -->
    <section class="umkm-hero">
        <div class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Beranda</a>
            <span class="separator"><i class="fa-solid fa-chevron-right" style="font-size: 0.8rem;"></i></span>
            <span class="current">UMKM Desa</span>
        </div>
        <h1>UMKM & Produk Desa</h1>
        <p>Jelajahi berbagai produk lokal unggulan hasil karya warga Desa Duren. Dukung perekonomian desa dengan membeli produk lokal.</p>
    </section>

    <!-- MAIN CONTAINER -->
    <div class="umkm-container">
        
        <!-- SEARCH & FILTER -->
        <div class="search-filter-card">
            <div class="filter-grid">
                <div class="search-box-wrapper">
                    <button type="button" id="search-btn" class="search-btn" title="Cari">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" id="search-input" class="search-input" placeholder="Cari nama UMKM atau produk...">
                </div>
                
                <div class="select-box-wrapper">
                    <i class="fa-solid fa-filter"></i>
                    <select id="category-select" class="category-select">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- GRID LIST -->
        <div class="umkm-grid" id="umkm-grid">
            @foreach($umkms as $umkm)
                <div class="card-item umkm-card" data-category-id="{{ $umkm->category_id }}" data-title="{{ strtolower($umkm->title) }}" data-desc="{{ strtolower($umkm->description) }}">
                    <!-- Link wrapper -->
                    <a href="{{ route('umkm.detail', $umkm->slug) }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></a>
                    
                    <div class="card-image-wrapper">
                        <img src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset($umkm->thumbnail) }}" alt="{{ $umkm->title }}" class="card-image-bg" loading="lazy">
                        
                        <div class="card-top-badge" style="color: var(--primary-dark);">
                            {{ $umkm->category->name ?? 'Lokal' }}
                        </div>
                        
                        @if($umkm->is_featured)
                        <div class="card-top-badge featured">
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

            <!-- EMPTY STATE -->
            <div class="empty-state" id="empty-state">
                <i class="fa-solid fa-store-slash"></i>
                <h3>UMKM Tidak Ditemukan</h3>
                <p>Maaf, produk atau nama UMKM yang Anda cari tidak dapat ditemukan. Silakan ganti kata kunci atau pilih kategori lain.</p>
            </div>
        </div>

    </div>

    <!-- FILTER SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const categorySelect = document.getElementById('category-select');
            const umkmGrid = document.getElementById('umkm-grid');
            const cards = umkmGrid.querySelectorAll('.umkm-card');
            const emptyState = document.getElementById('empty-state');

            let activeCategory = 'all';
            let searchQuery = '';

            // Handle Category Filter change
            categorySelect.addEventListener('change', function() {
                activeCategory = this.value;
                filterUMKM();
            });

            // Handle Search button click
            const searchBtn = document.getElementById('search-btn');
            searchBtn.addEventListener('click', function() {
                searchQuery = searchInput.value.toLowerCase().trim();
                filterUMKM();
                searchInput.focus();
            });

            // Handle Search typing
            searchInput.addEventListener('input', function() {
                searchQuery = this.value.toLowerCase().trim();
                filterUMKM();
            });

            function filterUMKM() {
                let matchCount = 0;

                cards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category-id');
                    const cardTitle = card.getAttribute('data-title');
                    const cardDesc = card.getAttribute('data-desc');

                    const matchesCategory = (activeCategory === 'all' || cardCategory === activeCategory);
                    const matchesSearch = (searchQuery === '' || cardTitle.includes(searchQuery) || cardDesc.includes(searchQuery));

                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'flex';
                        matchCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (matchCount === 0) {
                    emptyState.style.display = 'flex';
                } else {
                    emptyState.style.display = 'none';
                }
            }
        });
    </script>
@endsection
