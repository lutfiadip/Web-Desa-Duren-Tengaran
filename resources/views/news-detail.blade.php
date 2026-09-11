@extends('layouts.app')

@section('title', $article->title . ' - Berita Desa Duren')

@section('meta')
    @php
        $cleanDesc = Str::limit(strip_tags($article->content), 160);
        $imageUrl = $article->featured_image ? (Str::startsWith($article->featured_image, 'http') ? $article->featured_image : asset($article->featured_image)) : asset('img/logo-semarang.png');
    @endphp
    <meta name="description" content="{{ $cleanDesc }}">
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="Portal Informasi Desa Duren">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $cleanDesc }}">
    <meta property="og:image" content="{{ $imageUrl }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="article:published_time" content="{{ $article->published_at }}">
    <meta property="article:section" content="{{ $article->category->name ?? 'Berita' }}">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $cleanDesc }}">
    <meta name="twitter:image" content="{{ $imageUrl }}">
@endsection

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

    /* --- ARTICLE SHARE SECTION & TEMPLATE --- */
    .article-share-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px dashed var(--border-color);
    }

    .share-card-box {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg, 16px);
        padding: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .share-card-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #2563eb 0%, #38bdf8 50%, #10b981 100%);
    }

    .share-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 22px;
    }

    .share-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .share-icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        flex-shrink: 0;
    }

    .share-title-text h4 {
        margin: 0 0 4px 0;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    .share-title-text p {
        margin: 0;
        font-size: 0.88rem;
        color: var(--text-muted);
    }

    .share-buttons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(135px, 1fr));
        gap: 12px;
        margin-bottom: 22px;
    }

    .btn-share {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 14px;
        border-radius: var(--radius-md, 10px);
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        color: #ffffff !important;
        transition: all 0.25s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        user-select: none;
    }

    .btn-share:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-share.wa {
        background: linear-gradient(135deg, #25D366, #128C7E);
    }
    .btn-share.wa:hover {
        background: linear-gradient(135deg, #22c55e, #0f766e);
    }

    .btn-share.fb {
        background: linear-gradient(135deg, #1877F2, #0d65d9);
    }
    .btn-share.fb:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
    }

    .btn-share.x {
        background: linear-gradient(135deg, #0f172a, #000000);
    }
    .btn-share.x:hover {
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .btn-share.tg {
        background: linear-gradient(135deg, #2AABEE, #229ED9);
    }
    .btn-share.tg:hover {
        background: linear-gradient(135deg, #0284c7, #0369a1);
    }

    .btn-share.in {
        background: linear-gradient(135deg, #0A66C2, #004182);
    }
    .btn-share.in:hover {
        background: linear-gradient(135deg, #0284c7, #075985);
    }

    .btn-share.mail {
        background: linear-gradient(135deg, #ea580c, #c2410c);
    }
    .btn-share.mail:hover {
        background: linear-gradient(135deg, #c2410c, #9a3412);
    }

    .btn-share.copy {
        background: #ffffff;
        color: var(--text-dark) !important;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
    }
    .btn-share.copy:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: var(--primary) !important;
    }

    .btn-share.native {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
    }
    .btn-share.native:hover {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
    }

    /* Template Message Accordion Box */
    .share-template-container {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md, 12px);
        padding: 18px 20px;
    }

    .share-template-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .share-template-header span {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .share-template-header span i {
        color: #25D366;
    }

    .share-template-box {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 14px 16px;
        font-size: 0.88rem;
        color: #334155;
        line-height: 1.65;
        white-space: pre-wrap;
        word-break: break-word;
        font-family: inherit;
        max-height: 170px;
        overflow-y: auto;
        border-left: 4px solid #25D366;
    }

    .btn-copy-template {
        background: #25D366;
        color: #ffffff;
        border: none;
        padding: 7px 16px;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(37, 211, 102, 0.25);
    }

    .btn-copy-template:hover {
        background: #128C7E;
        transform: translateY(-1px);
    }

    /* Floating Toast Notification */
    .share-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #0f172a;
        color: #ffffff;
        padding: 14px 24px;
        border-radius: 50px;
        font-size: 0.92rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        z-index: 99999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }

    .share-toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    @media (max-width: 640px) {
        .share-toast {
            left: 20px;
            right: 20px;
            bottom: 20px;
            justify-content: center;
            text-align: center;
        }
        .share-buttons-grid {
            grid-template-columns: repeat(2, 1fr);
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
                    <span><i class="fa-solid fa-eye"></i> {{ number_format($article->views, 0, ',', '.') }} Dilihat</span>
                </div>
                
                @if($article->featured_image)
                    <figure class="article-featured-image-wrapper" style="margin-bottom: 30px; width: 100%;">
                        <div style="border-radius: var(--radius-md); overflow: hidden; max-height: 480px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                            <img src="{{ Str::startsWith($article->featured_image, 'http') ? $article->featured_image : asset($article->featured_image) }}" 
                                 alt="{{ $article->title }}" style="width: 100%; height: auto; max-height: 480px; object-fit: cover; display: block;">
                        </div>
                        @if($article->image_caption)
                            <figcaption style="font-size: 0.85rem; color: var(--text-muted); font-style: italic; text-align: center; margin-top: 10px;">
                                {{ $article->image_caption }}
                            </figcaption>
                        @endif
                    </figure>
                @endif
                
                <div class="article-body">
                    {!! $article->content !!}
                </div>

                @php
                    $shareUrl = request()->url();
                    $shareTitle = $article->title;
                    $cleanExcerpt = Str::limit(strip_tags($article->content), 160);
                    $shareDate = \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y');
                    $kategoriName = $article->category->name ?? 'Berita Desa';
                    
                    // Formatted broadcast message template for WhatsApp, Telegram, etc.
                    $shareBroadcastTemplate = "📢 *KABAR RESMI DESA DUREN*\n"
                                           . "Pemerintah Desa Duren, Kec. Tengaran, Kab. Semarang\n"
                                           . "━━━━━━━━━━━━━━━━━━━━━\n\n"
                                           . "📰 *" . $shareTitle . "*\n\n"
                                           . $cleanExcerpt . "...\n\n"
                                           . "🗓️ *Tanggal:* " . $shareDate . "\n"
                                           . "🏷️ *Kategori:* " . $kategoriName . "\n"
                                           . "🏛️ *Penerbit:* Pemerintah Desa Duren\n\n"
                                           . "━━━━━━━━━━━━━━━━━━━━━\n"
                                           . "🔗 *Baca selengkapnya melalui tautan resmi:*\n"
                                           . $shareUrl . "\n\n"
                                           . "#DesaDuren #Tengaran #Semarang #KabarDesa";

                    $waShareUrl = "https://api.whatsapp.com/send?text=" . urlencode($shareBroadcastTemplate);
                    $fbShareUrl = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($shareUrl);
                    $twShareUrl = "https://twitter.com/intent/tweet?url=" . urlencode($shareUrl) . "&text=" . urlencode($shareTitle . " - Pemdes Duren");
                    $tgShareUrl = "https://t.me/share/url?url=" . urlencode($shareUrl) . "&text=" . urlencode("📢 *" . $shareTitle . "*\n\n" . $cleanExcerpt);
                    $inShareUrl = "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($shareUrl);
                    $mailShareUrl = "mailto:?subject=" . rawurlencode("Berita Desa Duren: " . $shareTitle) . "&body=" . rawurlencode($shareBroadcastTemplate);
                @endphp

                <!-- SHARE SECTION & TEMPLATE SHOWCASE -->
                <div class="article-share-section" id="shareSection">
                    <div class="share-card-box">
                        <div class="share-header">
                            <div class="share-header-left">
                                <div class="share-icon-circle">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </div>
                                <div class="share-title-text">
                                    <h4>Bagikan Berita Ini</h4>
                                    <p>Bantu sebarkan informasi resmi ini kepada warga, keluarga, dan media sosial Anda.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons Grid -->
                        <div class="share-buttons-grid">
                            <!-- WhatsApp -->
                            <a href="{{ $waShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share wa" title="Bagikan ke WhatsApp">
                                <i class="fa-brands fa-whatsapp" style="font-size: 1.15rem;"></i> WhatsApp
                            </a>

                            <!-- Facebook -->
                            <a href="{{ $fbShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share fb" title="Bagikan ke Facebook">
                                <i class="fa-brands fa-facebook-f"></i> Facebook
                            </a>

                            <!-- Telegram -->
                            <a href="{{ $tgShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share tg" title="Bagikan ke Telegram">
                                <i class="fa-brands fa-telegram" style="font-size: 1.1rem;"></i> Telegram
                            </a>

                            <!-- X / Twitter -->
                            <a href="{{ $twShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share x" title="Bagikan ke X / Twitter">
                                <i class="fa-brands fa-x-twitter"></i> Twitter
                            </a>

                            <!-- LinkedIn -->
                            <a href="{{ $inShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share in" title="Bagikan ke LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                            </a>

                            <!-- Email -->
                            <a href="{{ $mailShareUrl }}" class="btn-share mail" title="Bagikan via Email">
                                <i class="fa-solid fa-envelope"></i> Email
                            </a>

                            <!-- Copy Link -->
                            <button type="button" class="btn-share copy btn-copy-article-link" title="Salin Tautan Berita" data-url="{{ $shareUrl }}">
                                <i class="fa-solid fa-link"></i> Salin Link
                            </button>

                            <!-- Native Web Share API -->
                            <button type="button" class="btn-share native btn-native-share" title="Bagikan ke Aplikasi Lain"
                                    data-title="{{ $shareTitle }}" 
                                    data-text="{{ $cleanExcerpt }}" 
                                    data-url="{{ $shareUrl }}">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i> Lainnya
                            </button>
                        </div>

                        <!-- Template Format Pesan WhatsApp -->
                        <div class="share-template-container">
                            <div class="share-template-header">
                                <span>
                                    <i class="fa-brands fa-whatsapp"></i> Pratinjau Format Pesan Broadcast
                                </span>
                                <button type="button" class="btn-copy-template btn-copy-template-text" data-template="{{ $shareBroadcastTemplate }}">
                                    <i class="fa-solid fa-copy"></i> Salin Teks Format
                                </button>
                            </div>
                            <div class="share-template-box" id="templateBoxPreview">{{ $shareBroadcastTemplate }}</div>
                        </div>
                    </div>
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

            <!-- Sidebar Share Widget -->
            <div class="sidebar-widget" style="background: linear-gradient(145deg, #f0fdf4 0%, #ffffff 100%); border: 1px solid #bbf7d0;">
                <h3 class="widget-title" style="color: #166534; border-bottom: 2px solid #86efac; padding-bottom: 8px;">
                    <i class="fa-solid fa-share-nodes" style="color: #16a34a;"></i> Bagikan Berita
                </h3>
                <p style="font-size: 0.85rem; color: #475569; margin-bottom: 15px; line-height: 1.5;">
                    Sebarkan kabar penting ini ke grup warga, WhatsApp, atau media sosial Anda:
                </p>
                <div style="display: flex; flex-direction: column; gap: 9px;">
                    <a href="{{ $waShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share wa" style="width: 100%; justify-content: center; font-size: 0.88rem; padding: 10px 14px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 1.15rem;"></i> Bagikan ke WhatsApp
                    </a>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="{{ $fbShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share fb" style="font-size: 0.82rem; padding: 9px 10px;">
                            <i class="fa-brands fa-facebook-f"></i> Facebook
                        </a>
                        <a href="{{ $tgShareUrl }}" target="_blank" rel="noopener noreferrer" class="btn-share tg" style="font-size: 0.82rem; padding: 9px 10px;">
                            <i class="fa-brands fa-telegram"></i> Telegram
                        </a>
                    </div>
                    <button type="button" class="btn-share copy btn-copy-article-link" style="width: 100%; justify-content: center; font-size: 0.85rem; padding: 9px 14px;" data-url="{{ $shareUrl }}">
                        <i class="fa-solid fa-link"></i> Salin Tautan Berita
                    </button>
                </div>
            </div>

        </div>

    </div>

    <!-- Floating Toast Notification -->
    <div class="share-toast" id="shareToast">
        <i class="fa-solid fa-circle-check" style="color: #22c55e; font-size: 1.25rem;"></i>
        <span id="toastMsg">Tautan berhasil disalin!</span>
    </div>
@endsection

@section('scripts')
<script>
    (function() {
        const toast = document.getElementById('shareToast');
        const toastMsg = document.getElementById('toastMsg');
        let toastTimeout = null;

        function showToast(message) {
            if (!toast || !toastMsg) return;
            toastMsg.textContent = message;
            toast.classList.add('show');
            if (toastTimeout) clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 3200);
        }

        function copyTextToClipboard(text, successMessage) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast(successMessage);
                }).catch(() => {
                    fallbackCopy(text, successMessage);
                });
            } else {
                fallbackCopy(text, successMessage);
            }
        }

        function fallbackCopy(text, successMessage) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();
            try {
                document.execCommand('copy');
                showToast(successMessage);
            } catch (err) {
                showToast('Gagal menyalin secara otomatis. Silakan salin manual.');
            }
            document.body.removeChild(textarea);
        }

        // Copy Article Link buttons (in main card & sidebar)
        document.querySelectorAll('.btn-copy-article-link').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url') || window.location.href;
                copyTextToClipboard(url, 'Tautan berita berhasil disalin!');
                
                // Visual feedback on button
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-check" style="color: #16a34a;"></i> Tersalin!';
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                }, 2000);
            });
        });

        // Copy Template Text button
        document.querySelectorAll('.btn-copy-template-text').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const template = this.getAttribute('data-template') || document.getElementById('templateBoxPreview')?.innerText || '';
                copyTextToClipboard(template, 'Format pesan broadcast disalin! Siap ditempel di WhatsApp atau grup.');

                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-check"></i> Format Tersalin!';
                this.style.background = '#15803d';
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.style.background = '';
                }, 2500);
            });
        });

        // Native Web Share API (Mobile / Modern Browsers)
        document.querySelectorAll('.btn-native-share').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const title = this.getAttribute('data-title') || document.title;
                const text = this.getAttribute('data-text') || '';
                const url = this.getAttribute('data-url') || window.location.href;

                if (navigator.share) {
                    navigator.share({
                        title: title,
                        text: text,
                        url: url
                    }).then(() => {
                        showToast('Berita berhasil dibagikan!');
                    }).catch((err) => {
                        if (err.name !== 'AbortError') {
                            copyTextToClipboard(url, 'Tautan berita disalin ke clipboard.');
                        }
                    });
                } else {
                    copyTextToClipboard(url, 'Tautan berita disalin! (Gunakan menu aplikasi Anda untuk membagikan)');
                }
            });
        });
    })();
</script>
@endsection
