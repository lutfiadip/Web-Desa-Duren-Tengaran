@extends('layouts.app')

@section('title', 'Panduan Layanan Publik - Desa Duren')

@section('styles')
<style>
    /* --- HERO SECTION --- */
    .hero-section {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 58, 138, 0.8) 100%),
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
        max-width: 700px;
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
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .service-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .service-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        background-color: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 20px;
        transition: var(--transition);
    }

    .service-card:hover .service-icon-wrapper {
        background-color: var(--primary);
        color: var(--white);
    }

    .service-card h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .service-card p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .service-card .read-more {
        color: var(--primary-light);
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .service-card:hover .read-more {
        gap: 12px;
        color: var(--primary);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background-color: var(--white);
        border-radius: var(--radius-lg);
        border: 1px dashed var(--border-color);
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--text-muted);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .hero-section {
            padding: 100px 5% 60px;
        }

        .hero-section h1 {
            font-size: 2.2rem;
        }

        .services-grid {
            grid-template-columns: 1fr;
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
        <span class="current">Panduan Layanan Publik</span>
    </nav>
    <h1>Panduan Layanan Publik</h1>
    <p>Informasi dan persyaratan untuk berbagai layanan administrasi kependudukan dan kemasyarakatan di Desa Duren.</p>
</section>

<!-- MAIN CONTENT -->
<div class="page-container">

    @if($services->count() > 0)
        <div class="services-grid">
            @foreach($services as $service)
                <a href="{{ route('public_services.detail', $service->slug) }}" class="service-card">
                    <div class="service-icon-wrapper">
                        <i class="{{ $service->icon ?: 'fa-solid fa-file-lines' }}"></i>
                    </div>
                    <h3>{{ $service->title }}</h3>
                    <p>{{ Str::limit($service->description, 100) }}</p>
                    <div class="read-more">
                        Lihat Persyaratan <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
        
        @if($services->hasPages())
            <div style="margin-top: 50px; display: flex; justify-content: center;">
                {{ $services->links('pagination::bootstrap-4') }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fa-solid fa-folder-open"></i>
            <h3>Belum Ada Informasi Layanan</h3>
            <p>Informasi layanan publik akan segera diperbarui oleh admin desa.</p>
        </div>
    @endif

</div>

@endsection
