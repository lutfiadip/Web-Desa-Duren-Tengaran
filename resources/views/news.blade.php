@extends('layouts.app')

@section('title', 'Kabar & Berita Desa Duren - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .news-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .news-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .news-hero p {
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
    .news-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5% 80px;
    }

    /* --- FILTER BAR --- */
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 30px;
        margin-bottom: 40px;
        background: var(--white);
        padding: 20px 30px;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    /* Search Form */
    .search-form {
        display: flex;
        align-items: center;
        position: relative;
        flex-grow: 1;
        max-width: 450px;
    }

    .search-input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        font-size: 0.95rem;
        font-weight: 500;
        outline: none;
        transition: var(--transition);
        background-color: #f8fafc;
    }

    .search-input:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .search-icon {
        position: absolute;
        left: 18px;
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Category Filter Select Dropdown */
    .category-select-wrapper {
        position: relative;
        min-width: 220px;
    }

    .category-select {
        width: 100%;
        padding: 12px 45px 12px 20px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        background-color: #f8fafc;
        outline: none;
        transition: var(--transition);
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
    }

    .category-select:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .select-icon {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
        font-size: 0.95rem;
    }

    /* --- NEWS GRID --- */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .news-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .news-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.06);
        border-color: rgba(37, 99, 235, 0.15);
    }

    /* Card Image */
    .card-img-wrapper {
        width: 100%;
        height: 230px;
        overflow: hidden;
        position: relative;
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card:hover .card-img {
        transform: scale(1.08);
    }

    .card-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--primary);
        color: var(--white);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: var(--radius-sm);
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    }

    /* Card Body */
    .card-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-meta {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 12px;
    }

    .card-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-meta i {
        color: var(--primary);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.4;
        margin-bottom: 12px;
        text-decoration: none;
        transition: var(--transition);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 3.5rem;
    }

    .card-title:hover {
        color: var(--primary);
    }

    .card-excerpt {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-align: justify;
        flex-grow: 1;
    }

    .card-action {
        border-top: 1px solid var(--border-color);
        padding-top: 15px;
        margin-top: auto;
    }

    .card-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--primary);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .card-btn:hover {
        color: var(--primary-hover);
        gap: 10px;
    }

    /* --- PAGINATION --- */
    .news-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 40px;
    }

    .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background-color: var(--white);
        color: var(--text-dark);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
        font-size: 0.95rem;
    }

    .page-link:hover:not(.disabled) {
        background-color: #eff6ff;
        color: var(--primary);
        border-color: var(--primary);
    }

    .page-link.active {
        background-color: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .page-link.disabled {
        color: #cbd5e1;
        border-color: #f1f5f9;
        cursor: not-allowed;
        background-color: #f8fafc;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 992px) {
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-form {
            max-width: 100%;
        }

        .category-filters {
            justify-content: flex-start;
        }
    }

    @media (max-width: 768px) {
        .news-hero h1 {
            font-size: 2.2rem;
        }
        
        .news-hero p {
            font-size: 1rem;
        }

        .news-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="news-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Berita</span>
        </nav>
        <h1>Kabar & Berita Desa Duren</h1>
        <p>Menyajikan informasi terbaru mengenai kegiatan kemasyarakatan, pengumuman resmi, dan perkembangan pembangunan di Desa Duren</p>
    </section>

    <!-- CONTAINER -->
    <div class="news-container">
        
        <!-- FILTER BAR -->
        <div class="filter-bar">
            <!-- Search -->
            <form action="{{ route('news') }}" method="GET" class="search-form">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari judul atau isi berita..." value="{{ request('search') }}">
            </form>

            <!-- Categories Select Dropdown -->
            <div class="category-select-wrapper">
                <select class="category-select" onchange="window.location.href = this.value">
                    <option value="{{ route('news', request()->only('search')) }}" {{ !request('category') ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ route('news', array_merge(request()->only('search'), ['category' => $category->slug])) }}" 
                                {{ request('category') === $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down select-icon"></i>
            </div>
        </div>

        <!-- NEWS GRID -->
        <div class="news-grid">
            @forelse($news as $item)
                <div class="news-card">
                    <div class="card-img-wrapper">
                        <img src="{{ $item->featured_image ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                             alt="{{ $item->title }}" class="card-img">
                        <span class="card-badge">{{ $item->category->name ?? 'Berita' }}</span>
                    </div>

                    <div class="card-body">
                        <div class="card-meta">
                            <span><i class="fa-solid fa-calendar-days"></i> {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d M Y') }}</span>
                            <span><i class="fa-solid fa-user"></i> Admin</span>
                        </div>
                        
                        <a href="{{ route('news.detail', $item->slug) }}" class="card-title" title="{{ $item->title }}">
                            {{ $item->title }}
                        </a>
                        
                        <p class="card-excerpt">
                            {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 120) }}
                        </p>
                        
                        <div class="card-action">
                            <a href="{{ route('news.detail', $item->slug) }}" class="card-btn">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border-color); color: var(--text-muted);">
                    <i class="fa-solid fa-newspaper" style="font-size: 3.5rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                    <p style="font-size: 1.15rem; font-weight: 700; margin-bottom: 5px;">Berita tidak ditemukan</p>
                    <p style="font-size: 0.95rem; margin-bottom: 0;">Silakan cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if ($news->hasPages())
            <nav class="news-pagination">
                @if ($news->onFirstPage())
                    <span class="page-link disabled"><i class="fa-solid fa-chevron-left"></i></span>
                @else
                    <a href="{{ $news->previousPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                @endif

                @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                    @if ($page == $news->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($news->hasMorePages())
                    <a href="{{ $news->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                @else
                    <span class="page-link disabled"><i class="fa-solid fa-chevron-right"></i></span>
                @endif
            </nav>
        @endif

    </div>
@endsection
