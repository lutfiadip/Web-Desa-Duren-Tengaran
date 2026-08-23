@extends('layouts.app')

@section('title', $service->title . ' - Panduan Layanan Publik')

@section('styles')
<style>
    /* --- HERO SECTION --- */
    .hero-section {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : asset('img/desa-hero.jpg') }}') center/cover no-repeat;
        padding: 160px 5% 140px;
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
        list-style: none;
        padding-left: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .content-body ul li {
        position: relative;
        padding: 15px 20px 15px 45px;
        background: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: var(--radius-md);
        margin-bottom: 0;
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.05);
    }
    
    .content-body ul li:hover {
        border-color: var(--primary-light);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        transform: translateY(-2px);
    }
    
    .content-body ul li::before {
        content: '\f00c'; /* FontAwesome check */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        left: 15px;
        top: 17px;
        color: var(--white);
        background: var(--primary);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
    
    .content-body ol {
        counter-reset: item;
    }
    
    .content-body ol li {
        position: relative;
        padding: 15px 20px 15px 55px;
        background: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: var(--radius-md);
        margin-bottom: 0;
        counter-increment: item;
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.05);
    }
    
    .content-body ol li:hover {
        border-color: var(--primary-light);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        transform: translateY(-2px);
    }
    
    .content-body ol li::before {
        content: counter(item);
        position: absolute;
        left: 15px;
        top: 15px;
        width: 26px;
        height: 26px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.3);
    }
    
    .content-body strong {
        color: var(--primary-dark, #1e3a8a);
    }
    
    /* INFO BOXES */
    .info-boxes {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
        margin-bottom: 30px;
    }
    
    .info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: var(--transition);
    }
    
    .info-box:hover {
        border-color: var(--primary-light);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    
    .info-box-icon {
        width: 50px;
        height: 50px;
        background: rgba(37, 99, 235, 0.1);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    
    .info-box-content h4 {
        margin: 0 0 4px 0;
        font-size: 0.95rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-box-content p {
        margin: 0;
        font-size: 1.15rem;
        color: var(--text-dark);
        font-weight: 700;
    }
    
    /* --- DISCLAIMER BOX --- */
    .disclaimer-box {
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        padding: 20px 25px;
        margin-top: 10px;
        margin-bottom: 40px;
        border-radius: 0 var(--radius-md) var(--radius-md) 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .disclaimer-box h4 {
        margin: 0 0 10px 0;
        color: #d97706;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.1rem;
    }
    
    .disclaimer-box p {
        margin: 0;
        color: #78350f;
        line-height: 1.6;
        font-size: 1rem;
    }
    
    /* --- TABS SECTION --- */
    .service-tabs {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 30px;
        overflow-x: auto;
        padding-bottom: 5px; /* for box-shadow */
    }
    
    .tab-btn {
        background: var(--white);
        border: 2px solid #e2e8f0;
        padding: 12px 25px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #64748b;
        border-radius: 50px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    
    .tab-btn i {
        font-size: 1.15rem;
    }
    
    .tab-btn:hover {
        border-color: #cbd5e1;
        color: var(--text-dark);
        background: #f8fafc;
    }
    
    .tab-btn.active {
        border-color: var(--primary);
        color: var(--white);
        background: var(--primary);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    
    .tab-content {
        display: none;
        animation: fadeInTab 0.4s ease forwards;
    }
    
    .tab-content.active {
        display: block;
    }
    
    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
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
        background-color: var(--primary);
        color: var(--white);
        border-radius: var(--radius-md);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .btn-download:hover {
        background-color: var(--primary-hover);
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
        
        .info-boxes {
            grid-template-columns: 1fr;
            gap: 15px;
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
        <a href="{{ route('public_services') }}">Panduan Layanan Publik</a>
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

        @if($service->processing_time || $service->service_cost)
            <div class="info-boxes">
                @if($service->processing_time)
                <div class="info-box">
                    <div class="info-box-icon">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="info-box-content">
                        <h4>Waktu Penyelesaian</h4>
                        <p>{{ $service->processing_time }}</p>
                    </div>
                </div>
                @endif
                
                @if($service->service_cost)
                <div class="info-box">
                    <div class="info-box-icon">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="info-box-content">
                        <h4>Biaya Layanan</h4>
                        <p>{{ $service->service_cost }}</p>
                    </div>
                </div>
                @endif
            </div>
        @endif

        @if($service->requirements || $service->service_flow)
            <div class="service-tabs-container" style="margin-bottom: 40px;">
                <div class="service-tabs">
                    @if($service->requirements)
                    <button class="tab-btn {{ $service->requirements ? 'active' : '' }}" onclick="switchTab('requirements')" id="btn-tab-requirements">
                        <i class="fa-solid fa-file-signature"></i> Persyaratan
                    </button>
                    @endif
                    
                    @if($service->service_flow)
                    <button class="tab-btn {{ !$service->requirements && $service->service_flow ? 'active' : '' }}" onclick="switchTab('flow')" id="btn-tab-flow">
                        <i class="fa-solid fa-list-ol"></i> Alur Layanan
                    </button>
                    @endif
                </div>

                @if($service->requirements)
                <div id="tab-requirements" class="tab-content {{ $service->requirements ? 'active' : '' }}">
                    <div class="content-body">
                        {!! Illuminate\Support\Str::markdown($service->requirements) !!}
                    </div>
                </div>
                @endif
                
                @if($service->service_flow)
                <div id="tab-flow" class="tab-content {{ !$service->requirements && $service->service_flow ? 'active' : '' }}">
                    <div class="content-body">
                        {!! Illuminate\Support\Str::markdown($service->service_flow) !!}
                    </div>
                </div>
                @endif
            </div>
        @endif
        
        @if($service->disclaimer)
            <div class="disclaimer-box">
                <h4><i class="fa-solid fa-triangle-exclamation"></i> Catatan Penting</h4>
                {!! Illuminate\Support\Str::markdown($service->disclaimer) !!}
            </div>
        @endif

        @if($service->documents->isNotEmpty())
            <div class="download-section" style="margin-top: 50px; background: linear-gradient(to right, #eff6ff, #f8fafc); border-radius: var(--radius-md); padding: 30px; border: 1px dashed var(--primary);">
                <div style="margin-bottom: 20px;">
                    <h4 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-folder-open" style="color: var(--primary);"></i> Dokumen / Formulir Layanan Pendukung
                    </h4>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">Unduh file atau formulir berikut untuk melengkapi persyaratan layanan ini.</p>
                </div>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    @foreach($service->documents as $doc)
                        <div style="display: flex; align-items: center; justify-content: space-between; background: var(--white); padding: 15px 20px; border-radius: var(--radius-md); border: 1px solid var(--border-color); gap: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 12px; min-width: 250px;">
                                <i class="fa-solid fa-file-lines" style="color: var(--primary); font-size: 1.4rem;"></i>
                                <span style="font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">{{ $doc->title }}</span>
                            </div>
                            <a href="{{ asset($doc->file_path) }}" download class="btn-download" style="background-color: var(--primary); text-decoration: none;">
                                <i class="fa-solid fa-download"></i> Unduh Dokumen
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="margin-top: 50px; text-align: center;">
            <a href="{{ route('public_services') }}" style="color: var(--text-muted); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: var(--transition);">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Layanan
            </a>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Remove active class from all buttons and contents
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        // Add active class to selected button and content
        document.getElementById('btn-tab-' + tabId).classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>

@endsection
