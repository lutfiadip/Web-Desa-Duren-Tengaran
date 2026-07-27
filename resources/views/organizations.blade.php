@extends('layouts.app')

@section('title', 'Organisasi Kemasyarakatan (Ormas) - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .inst-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .inst-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .inst-hero p {
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

    /* --- CONTAINER & GRID --- */
    .inst-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5% 80px;
    }

    .category-section {
        margin-bottom: 60px;
    }

    .category-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 30px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .category-title i {
        color: var(--primary);
    }

    .inst-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 30px;
    }

    /* --- INSTITUTION CARD --- */
    .inst-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .inst-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.05);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .card-top {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
    }

    .inst-logo-wrapper {
        width: 70px;
        height: 70px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background-color: #eff6ff;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .inst-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .inst-initial {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary);
    }

    .inst-meta-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.3;
        margin-bottom: 5px;
    }

    .inst-badge {
        display: inline-block;
        background-color: #f1f5f9;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: var(--radius-sm);
    }

    .inst-body {
        margin-bottom: 25px;
        flex-grow: 1;
    }

    .inst-desc {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        text-align: justify;
    }

    .inst-action-wrapper {
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .inst-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background-color: #eff6ff;
        color: var(--primary);
        padding: 12px 20px;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-decoration: none;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .inst-btn:hover {
        background-color: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .inst-hero h1 {
            font-size: 2.2rem;
        }
        
        .inst-hero p {
            font-size: 1rem;
        }

        .inst-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="inst-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Organisasi Masyarakat</span>
        </nav>
        <h1>Organisasi Kemasyarakatan</h1>
        <p>Mengenal berbagai organisasi sosial, keagamaan, olahraga, dan kepemudaan yang aktif bergerak di tengah masyarakat Desa Duren secara swadaya</p>
    </section>

    <!-- CONTENT -->
    <div class="inst-container">
        
        @forelse($categories as $category)
            @if($category->institutions->count() > 0)
                <div class="category-section">
                    <h2 class="category-title">
                        <i class="fa-solid fa-users-rectangle"></i> {{ $category->name }}
                    </h2>
                    
                    <div class="inst-grid">
                        @foreach($category->institutions as $inst)
                            <div class="inst-card">
                                <div>
                                    <div class="card-top">
                                        <div class="inst-logo-wrapper">
                                            @if($inst->logo)
                                                <img src="{{ $inst->logo }}" alt="{{ $inst->name }}" class="inst-logo">
                                            @else
                                                <div class="inst-initial">{{ substr($inst->name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="inst-meta-title">{{ $inst->name }}</h3>
                                            <span class="inst-badge">{{ $category->name }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="inst-body">
                                        <p class="inst-desc">{{ Str::limit(strip_tags($inst->description), 150) }}</p>
                                    </div>
                                </div>
                                
                                <div class="inst-action-wrapper">
                                    <a href="{{ route('organization.detail', $inst->slug) }}" class="inst-btn">
                                        Lihat Profil Organisasi <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <div style="text-align: center; padding: 50px; background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border-color); color: var(--text-muted);">
                <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0;">Belum ada organisasi kemasyarakatan yang terdaftar.</p>
            </div>
        @endforelse

    </div>
@endsection
