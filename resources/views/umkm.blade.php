@extends('layouts.app')

@section('title', 'UMKM & Produk Unggulan Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .umkm-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ asset($profile->hero_bg_image ?? "https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80") }}') center/cover no-repeat;
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

    .search-box-wrapper i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.2rem;
    }

    .search-input {
        width: 100%;
        padding: 16px 20px 16px 55px;
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
    }

    .select-box-wrapper i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    .select-box-wrapper i.fa-filter {
        left: 20px;
        font-size: 1.1rem;
    }

    .select-box-wrapper i.fa-chevron-down {
        right: 20px;
        font-size: 0.9rem;
    }

    .category-select {
        width: 100%;
        padding: 16px 45px 16px 50px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        background-color: var(--bg-main);
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 600;
        transition: var(--transition);
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .category-select:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    /* --- GRID --- */
    .umkm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 30px;
    }

    /* --- CARDS --- */
    .umkm-card {
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

    .umkm-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .umkm-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
        display: block;
    }

    .umkm-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .umkm-card:hover .umkm-image {
        transform: scale(1.05);
    }

    .category-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background-color: rgba(37, 99, 235, 0.9);
        backdrop-filter: blur(4px);
        color: var(--white);
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: var(--accent);
        color: var(--white);
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .umkm-details {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .umkm-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .owner-info {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 15px;
    }

    .owner-info i {
        color: var(--primary);
    }

    .umkm-desc {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .umkm-meta-info {
        border-top: 1px solid var(--border-color);
        padding-top: 18px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        min-height: 56px; /* Menjaga stabilitas tinggi ketika waktu operasional kosong */
    }

    .meta-item {
        display: flex;
        gap: 10px;
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .meta-item i {
        color: var(--primary);
        font-size: 1rem;
        width: 18px;
        text-align: center;
        margin-top: 3px;
    }

    /* --- ACTION BUTTONS --- */
    .umkm-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        min-height: 90px; /* Menjaga stabilitas tinggi untuk 2 baris tombol kontak */
        align-content: start; /* Merapatkan tombol ke atas agar sejajar dengan informasi di atasnya */
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
                    <i class="fa-solid fa-magnifying-glass"></i>
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
                <div class="umkm-card" data-category-id="{{ $umkm->category_id }}" data-title="{{ strtolower($umkm->title) }}" data-desc="{{ strtolower($umkm->description) }}">
                    <a href="{{ route('umkm.detail', $umkm->slug) }}" class="umkm-image-wrapper">
                        <img src="{{ Str::startsWith($umkm->thumbnail, 'http') ? $umkm->thumbnail : asset('storage/' . $umkm->thumbnail) }}"
                             alt="{{ $umkm->title }}" class="umkm-image" loading="lazy">
                        <span class="category-badge">{{ $umkm->category->name ?? 'Lokal' }}</span>
                        @if($umkm->is_featured)
                            <span class="featured-badge"><i class="fa-solid fa-star"></i> Unggulan</span>
                        @endif
                    </a>
                    <div class="umkm-details">
                        <a href="{{ route('umkm.detail', $umkm->slug) }}" style="text-decoration: none; color: inherit;">
                            <h3 class="umkm-title">{{ $umkm->title }}</h3>
                        </a>
                        <div class="owner-info">
                            <i class="fa-solid fa-circle-user"></i> Pemilik: {{ $umkm->owner_name }}
                        </div>
                        <p class="umkm-desc">{{ $umkm->description }}</p>
                        
                        <div class="umkm-meta-info">
                            <div class="meta-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $umkm->address }}</span>
                            </div>
                            @if($umkm->operating_hours)
                                <div class="meta-item">
                                    <i class="fa-solid fa-clock"></i>
                                    <span>{{ $umkm->operating_hours }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="umkm-actions">
                            @if($umkm->whatsapp)
                                <a href="https://wa.me/{{ $umkm->whatsapp }}?text=Halo%20{{ rawurlencode($umkm->owner_name) }},%20saya%20tertarik%20dengan%20produk%20{{ rawurlencode($umkm->title) }}%20yang%20saya%20lihat%20di%20Website%20Resmi%20Desa%20Duren." 
                                   target="_blank" class="action-btn btn-wa">
                                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                </a>
                            @endif
                            
                            @if($umkm->instagram)
                                <a href="https://instagram.com/{{ $umkm->instagram }}" target="_blank" class="action-btn btn-ig">
                                    <i class="fa-brands fa-instagram"></i> Instagram
                                </a>
                            @endif

                            @if($umkm->facebook)
                                <a href="https://facebook.com/{{ $umkm->facebook }}" target="_blank" class="action-btn btn-fb">
                                    <i class="fa-brands fa-facebook-f"></i> Facebook
                                </a>
                            @endif

                            @if($umkm->google_maps_url)
                                <a href="{{ $umkm->google_maps_url }}" target="_blank" class="action-btn btn-maps">
                                    <i class="fa-solid fa-location-dot"></i> Lokasi Maps
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
