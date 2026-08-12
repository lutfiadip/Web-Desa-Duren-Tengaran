@extends('layouts.app')

@section('title', $article->title . ' - Berita Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .detail-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $article->featured_image ? (Str::startsWith($article->featured_image, 'http') ? $article->featured_image : asset($article->featured_image)) : ($profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "") }}') center/cover no-repeat;
        padding: 180px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .detail-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
        line-height: 1.2;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
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
        color: var(--white);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 250px;
    }

    /* --- DETAIL CONTAINER & GRID --- */
    .detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5% 80px;
        display: grid;
        grid-template-columns: 8fr 4fr;
        gap: 40px;
    }

    /* --- LEFT COLUMN: CONTENT --- */
    .article-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .article-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .article-meta i {
        color: var(--primary);
    }

    .article-badge {
        background-color: #eff6ff;
        color: var(--primary);
        font-weight: 700;
        padding: 4px 10px;
        border-radius: var(--radius-sm);
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .article-body {
        font-size: 1.1rem;
        color: var(--text-dark);
        line-height: 1.8;
        text-align: justify;
    }

    .article-body p {
        margin-bottom: 20px;
    }

    .article-body p:last-child {
        margin-bottom: 0;
    }

    /* --- RIGHT COLUMN: SIDEBAR --- */
    .sidebar-widget {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .widget-title i {
        color: var(--primary);
    }

    /* Sidebar Search */
    .sidebar-search-form {
        position: relative;
    }

    .sidebar-search-input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        font-size: 0.9rem;
        outline: none;
        transition: var(--transition);
        background-color: #f8fafc;
    }

    .sidebar-search-input:focus {
        border-color: var(--primary);
        background-color: var(--white);
    }

    .sidebar-search-btn {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.9rem;
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

    .sidebar-search-btn:hover {
        color: var(--primary);
        transform: translateY(-50%) scale(1.15);
    }

    /* Sidebar Categories List */
    .sidebar-cat-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .sidebar-cat-item a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
        transition: var(--transition);
        padding: 5px 0;
    }

    .sidebar-cat-item a:hover {
        color: var(--primary);
        padding-left: 5px;
    }

    .sidebar-cat-badge {
        background-color: #f1f5f9;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: var(--radius-pill);
    }

    .sidebar-cat-item a:hover .sidebar-cat-badge {
        background-color: #eff6ff;
        color: var(--primary);
    }

    /* Sidebar Recent News */
    .recent-news-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .recent-news-item {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .recent-img-wrapper {
        width: 80px;
        height: 75px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid var(--border-color);
    }

    .recent-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .recent-news-item:hover .recent-img {
        transform: scale(1.08);
    }

    .recent-info {
        flex-grow: 1;
    }

    .recent-title {
        font-size: 0.95rem;
        font-weight: 750;
        color: var(--text-dark);
        line-height: 1.4;
        text-decoration: none;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: var(--transition);
    }

    .recent-title:hover {
        color: var(--primary);
    }

    .recent-date {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .article-card {
            padding: 30px;
        }
    }

    @media (max-width: 768px) {
        .detail-hero h1 {
            font-size: 2.2rem;
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
            <a href="{{ route('news') }}">Berita</a>
            <span class="separator">/</span>
            <span class="current">{{ $article->title }}</span>
        </nav>
        <h1>{{ $article->title }}</h1>
    </section>

    <!-- DETAIL CONTAINER -->
    <div class="detail-container">
        
        <!-- LEFT COLUMN: CONTENT -->
        <div class="detail-main">
            <article class="article-card">
                <div class="article-meta">
                    <span class="article-badge">{{ $article->category->name ?? 'Berita' }}</span>
                    <span><i class="fa-solid fa-calendar-days"></i> {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y') }}</span>
                    <span><i class="fa-solid fa-user"></i> Admin Desa</span>
                </div>
                
                @if($article->featured_image)
                    <div class="article-featured-image-wrapper" style="margin-bottom: 30px; border-radius: var(--radius-md); overflow: hidden; width: 100%; max-height: 480px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <img src="{{ Str::startsWith($article->featured_image, 'http') ? $article->featured_image : asset($article->featured_image) }}" 
                             alt="{{ $article->title }}" style="width: 100%; height: auto; max-height: 480px; object-fit: cover; display: block;">
                    </div>
                @endif
                
                <div class="article-body">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </article>
        </div>

        <!-- RIGHT COLUMN: SIDEBAR -->
        <div class="detail-sidebar">
            
            <!-- Search Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title"><i class="fa-solid fa-magnifying-glass"></i> Cari Berita</h3>
                <form action="{{ route('news') }}" method="GET" class="sidebar-search-form" style="position: relative;">
                    <button type="submit" class="sidebar-search-btn" title="Cari">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" name="search" class="sidebar-search-input" placeholder="Ketik kata kunci...">
                </form>
            </div>

            <!-- Categories Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title"><i class="fa-solid fa-folder-open"></i> Kategori Berita</h3>
                <ul class="sidebar-cat-list">
                    @foreach($categories as $category)
                        <li class="sidebar-cat-item">
                            <a href="{{ route('news', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                                <span class="sidebar-cat-badge">
                                    {{ \App\Models\News::where('category_id', $category->id)->where('status', 'published')->count() }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Recent News Widget -->
            @if(count($recentNews) > 0)
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fa-solid fa-rss"></i> Berita Terbaru</h3>
                    <div class="recent-news-list">
                        @foreach($recentNews as $recent)
                            <div class="recent-news-item">
                                <a href="{{ route('news.detail', $recent->slug) }}" class="recent-img-wrapper">
                                    <img src="{{ $recent->featured_image ? (Str::startsWith($recent->featured_image, 'http') ? $recent->featured_image : asset($recent->featured_image)) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" 
                                         alt="{{ $recent->title }}" class="recent-img">
                                </a>
                                <div class="recent-info">
                                    <a href="{{ route('news.detail', $recent->slug) }}" class="recent-title" title="{{ $recent->title }}">
                                        {{ $recent->title }}
                                    </a>
                                    <div class="recent-date">{{ \Carbon\Carbon::parse($recent->published_at)->translatedFormat('d M Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
