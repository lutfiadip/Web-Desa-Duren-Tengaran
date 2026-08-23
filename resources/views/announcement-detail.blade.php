@extends('layouts.app')

@section('title', $announcement->title . ' - Pengumuman Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .detail-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
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
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 5% 80px;
        display: grid;
        grid-template-columns: 8fr 4fr;
        gap: 40px;
    }

    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
        }
    }

    /* --- LEFT COLUMN: CONTENT --- */
    .content-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .content-meta {
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

    .content-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rich-text {
        font-size: 1.1rem;
        color: var(--text-dark);
        line-height: 1.8;
    }

    .rich-text p {
        margin-bottom: 20px;
    }

    /* --- DOWNLOAD BOX --- */
    .download-box {
        margin-top: 40px;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
    }

    @media (max-width: 576px) {
        .download-box {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }
    }

    .download-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .download-icon {
        font-size: 2.2rem;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.08);
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .download-text h4 {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .download-text p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    .download-btn {
        background-color: var(--primary);
        color: var(--white);
        padding: 12px 24px;
        border-radius: var(--radius-pill);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    .download-btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.25);
    }

    /* --- RIGHT COLUMN (SIDEBAR) --- */
    .sidebar-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 130px;
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 12px;
    }

    .sidebar-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .sidebar-item {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        transition: var(--transition);
        padding-bottom: 15px;
        border-bottom: 1px dashed var(--border-color);
    }

    .sidebar-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .sidebar-item-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
        line-height: 1.4;
        transition: var(--transition);
    }

    .sidebar-item:hover .sidebar-item-title {
        color: var(--primary);
    }

    .sidebar-item-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER -->
<section class="detail-hero">
    <div class="breadcrumb">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Beranda</a>
        <span class="separator"><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i></span>
        <a href="{{ route('announcements') }}">Pengumuman</a>
        <span class="separator"><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i></span>
        <span class="current">{{ Str::limit($announcement->title, 20) }}</span>
    </div>
    <h1>{{ $announcement->title }}</h1>
</section>

<!-- MAIN CONTENT GRID -->
<div class="detail-container">
    <!-- Left Column -->
    <div class="content-column">
        <div class="content-card">
            <!-- Meta Info -->
            <div class="content-meta">
                <span>
                    <i class="fa-solid fa-calendar-days"></i>
                    {{ \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('d F Y') }}
                </span>
                <span>
                    <i class="fa-solid fa-clock"></i>
                    {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}
                </span>
                @if($announcement->is_alert)
                    <span style="color: #d97706; font-weight: 700;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Pengumuman Penting
                    </span>
                @endif
                @if($announcement->expired_at)
                    <span style="color: #ef4444; font-weight: 600;">
                        <i class="fa-solid fa-calendar-xmark"></i> Berlaku s.d. {{ \Carbon\Carbon::parse($announcement->expired_at)->translatedFormat('d F Y') }}
                    </span>
                @endif
            </div>

            <!-- Content Body -->
            <div class="rich-text">
                {!! $announcement->content !!}
            </div>

            <!-- Berkas Unduhan -->
            @if($announcement->document_file)
                <div class="download-box">
                    <div class="download-info">
                        <div class="download-icon">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div class="download-text">
                            <h4>Berkas Lampiran Resmi</h4>
                            <p>Silakan unduh berkas lampiran resmi pengumuman ini.</p>
                        </div>
                    </div>
                    <a href="{{ asset($announcement->document_file) }}" download class="download-btn">
                        <i class="fa-solid fa-download"></i> Unduh Berkas
                    </a>
                </div>
            @endif

            <!-- Back Button -->
            <div style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 25px;">
                <a href="{{ route('announcements') }}" class="btn-icon" style="color: var(--text-muted); text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengumuman
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column (Sidebar) -->
    <div class="sidebar-column">
        <div class="sidebar-card">
            <h3 class="sidebar-title">Pengumuman Lainnya</h3>
            <div class="sidebar-list">
                @php
                    $otherAnns = \App\Models\Announcement::active()
                        ->where('id', '!=', $announcement->id)
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                @forelse($otherAnns as $other)
                    <a href="{{ route('announcements.detail', $other->slug) }}" class="sidebar-item">
                        <h4 class="sidebar-item-title">{{ $other->title }}</h4>
                        <span class="sidebar-item-date">
                            <i class="fa-solid fa-calendar-day"></i> {{ \Carbon\Carbon::parse($other->created_at)->translatedFormat('d M Y') }}
                        </span>
                    </a>
                @empty
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Tidak ada pengumuman lainnya.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
