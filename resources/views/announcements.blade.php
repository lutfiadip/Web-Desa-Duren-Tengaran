@extends('layouts.app')

@section('title', 'Pengumuman Desa Duren - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .ann-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .ann-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .ann-hero p {
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
    .ann-container {
        max-width: 1200px;
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
        padding: 12px 45px 12px 20px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        background-color: var(--bg-main);
        color: var(--text-dark);
        font-size: 0.95rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .search-input:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .search-submit {
        position: absolute;
        right: 15px;
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 1.1rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-submit:hover {
        color: var(--primary);
    }

    /* --- LIST GRID --- */
    .ann-list {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .ann-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        display: flex;
        gap: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .ann-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .ann-date-block {
        background: rgba(37, 99, 235, 0.06);
        border: 1px solid rgba(37, 99, 235, 0.12);
        color: var(--primary);
        width: 80px;
        height: 80px;
        border-radius: var(--radius-lg);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        line-height: 1.2;
        flex-shrink: 0;
    }

    .ann-date-block .day {
        font-size: 1.8rem;
        color: var(--primary);
        font-weight: 800;
    }

    .ann-date-block .month {
        font-size: 0.85rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 600;
    }

    .ann-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .ann-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 12px;
    }

    .ann-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-dark);
        text-decoration: none;
        line-height: 1.3;
        transition: var(--transition);
    }

    .ann-title:hover {
        color: var(--primary);
    }

    .ann-badges {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .ann-badge {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-alert {
        background-color: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .badge-file {
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary);
    }

    .ann-text {
        font-size: 1rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .ann-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .ann-meta-item {
        font-size: 0.85rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ann-action-link {
        font-size: 0.95rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition);
    }

    .ann-action-link:hover {
        color: var(--primary-hover);
        gap: 10px;
    }
</style>
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="ann-hero">
    <div class="breadcrumb">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Beranda</a>
        <span class="separator"><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i></span>
        <span class="current">Pengumuman</span>
    </div>
    <h1>Pengumuman Desa</h1>
    <p>{{ $profile->announcements_page_description ?? 'Informasi penting, edaran resmi, dan agenda terbaru mengenai pelayanan publik serta kemasyarakatan.' }}</p>
</section>

<!-- MAIN CONTENT -->
<div class="ann-container">
    <!-- Filter/Search Bar -->
    <div class="filter-bar">
        <form action="{{ route('announcements') }}" method="GET" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="Masukkan kata kunci pencarian..." value="{{ request('search') }}">
            <button type="submit" class="search-submit" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <!-- Announcements List -->
    <div class="ann-list">
        @forelse($announcements as $ann)
            <div class="ann-card">
                <div class="ann-date-block">
                    <div class="day">{{ \Carbon\Carbon::parse($ann->created_at)->format('d') }}</div>
                    <div class="month">{{ \Carbon\Carbon::parse($ann->created_at)->format('M') }}</div>
                </div>

                <div class="ann-body">
                    <div class="ann-header">
                        <a href="{{ route('announcements.detail', $ann->slug) }}" class="ann-title">{{ $ann->title }}</a>
                        <div class="ann-badges">
                            @if($ann->is_alert)
                                <span class="ann-badge badge-alert"><i class="fa-solid fa-triangle-exclamation"></i> Penting</span>
                            @endif
                            @if($ann->document_file)
                                <span class="ann-badge badge-file"><i class="fa-solid fa-file-pdf"></i> Dokumen</span>
                            @endif
                        </div>
                    </div>

                    <div class="ann-text">
                        {{ Str::limit(strip_tags($ann->content), 220) }}
                    </div>

                    <div class="ann-footer">
                        <div style="display: flex; gap: 20px;">
                            <div class="ann-meta-item">
                                <i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($ann->created_at)->diffForHumans() }}
                            </div>
                            @if($ann->expired_at)
                                <div class="ann-meta-item" style="color: #d97706; font-weight: 600;">
                                    <i class="fa-solid fa-calendar-xmark"></i> Berlaku s.d. {{ \Carbon\Carbon::parse($ann->expired_at)->translatedFormat('d F Y') }}
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('announcements.detail', $ann->slug) }}" class="ann-action-link">
                            Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; color: var(--text-muted); padding: 50px; background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);">
                <i class="fa-solid fa-bullhorn" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                Belum ada pengumuman terbaru yang dipublikasikan.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
