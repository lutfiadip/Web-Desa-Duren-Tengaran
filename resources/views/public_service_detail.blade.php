@extends('layouts.app')

@section('title', $service->title . ' - Layanan Publik')

@section('styles')
<style>
    /* --- HERO SECTION --- */
    .hero-section {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 58, 138, 0.85) 100%),
                    url('{{ asset('img/desa-hero.jpg') }}') center/cover no-repeat;
        padding: 120px 5% 80px;
        text-align: center;
        color: var(--white);
        position: relative;
    }

    .hero-section h1 {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .hero-section p {
        font-size: 1.15rem;
        color: #e2e8f0;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* --- BREADCRUMB --- */
    .breadcrumb {
        position: absolute;
        top: 20px;
        left: 5%;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .breadcrumb a:hover {
        color: var(--accent);
    }

    .breadcrumb .separator {
        color: #64748b;
    }

    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
    }

    /* --- PAGE CONTENT --- */
    .page-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    .detail-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 50px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }

    .detail-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-md);
        background-color: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: -90px auto 30px auto;
        box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 40px 0 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title i {
        color: var(--primary);
    }

    .content-body {
        font-size: 1.05rem;
        color: var(--text-dark);
        line-height: 1.8;
    }
    
    .content-body ul, .content-body ol {
        padding-left: 20px;
        margin-bottom: 20px;
    }
    
    .content-body li {
        margin-bottom: 10px;
    }

    .download-box {
        margin-top: 50px;
        background: linear-gradient(to right, #eff6ff, #f8fafc);
        border-radius: var(--radius-md);
        padding: 30px;
        border: 1px dashed var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .download-info {
        flex-grow: 1;
    }

    .download-info h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .download-info p {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin: 0;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 25px;
        background-color: var(--primary-light);
        color: var(--white);
        border-radius: var(--radius-md);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .btn-download:hover {
        background-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .hero-section {
            padding: 140px 5% 100px;
        }

        .hero-section h1 {
            font-size: 2.2rem;
        }

        .detail-card {
            padding: 30px 20px;
        }

        .download-box {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')

<!-- HERO SECTION -->
<section class="hero-section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Beranda</a>
        <span class="separator">/</span>
        <a href="{{ route('public_services') }}">Layanan Publik</a>
        <span class="separator">/</span>
        <span class="current">Detail</span>
    </nav>
    <h1>{{ $service->title }}</h1>
</section>

<!-- MAIN CONTENT -->
<div class="page-container">
    <div class="detail-card">
        <div class="detail-icon-wrapper">
            <i class="{{ $service->icon ?: 'fa-solid fa-file-lines' }}"></i>
        </div>

        @if($service->description)
            <div class="content-body" style="font-size: 1.15rem; text-align: center; color: var(--text-muted); margin-bottom: 40px; font-style: italic;">
                "{{ $service->description }}"
            </div>
        @endif

        @if($service->requirements)
            <h3 class="section-title">
                <i class="fa-solid fa-list-check"></i> Persyaratan & Alur Layanan
            </h3>
            <div class="content-body">
                {!! nl2br(e($service->requirements)) !!}
            </div>
        @endif

        @if($service->document_file)
            <div class="download-box">
                <div class="download-info">
                    <h4><i class="fa-solid fa-file-pdf" style="color: #ef4444; margin-right: 8px;"></i> Dokumen / Formulir Layanan</h4>
                    <p>Unduh formulir yang diperlukan untuk melengkapi persyaratan layanan ini.</p>
                </div>
                <a href="{{ asset($service->document_file) }}" target="_blank" class="btn-download">
                    <i class="fa-solid fa-download"></i> Unduh File
                </a>
            </div>
        @endif

        <div style="margin-top: 50px; text-align: center;">
            <a href="{{ route('public_services') }}" style="color: var(--text-muted); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: var(--transition);">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Layanan
            </a>
        </div>
    </div>
</div>

@endsection
