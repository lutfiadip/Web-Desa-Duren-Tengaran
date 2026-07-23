@extends('layouts.app')

@section('title', 'Perangkat Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .officials-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .officials-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .officials-hero p {
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
    .officials-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    .officials-section {
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 35px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 4px;
        background-color: var(--primary);
        border-radius: var(--radius-md);
    }

    /* --- CARDS GRID --- */
    .pimpinan-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(300px, 420px));
        gap: 40px;
        justify-content: center;
        margin-bottom: 50px;
    }

    .staff-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .kadus-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    /* --- APPARATUS CARD DESIGN --- */
    .apparatus-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 35px 25px;
    }

    .apparatus-card:hover {
        transform: translateY(-5px);
        border-color: rgba(37, 99, 235, 0.15);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.08);
    }

    .apparatus-img-wrapper {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 20px;
        border: 4px solid var(--border-color);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        transition: var(--transition);
        position: relative;
    }

    .apparatus-card:hover .apparatus-img-wrapper {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    .apparatus-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .apparatus-name {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .apparatus-position {
        display: inline-block;
        padding: 6px 16px;
        background-color: rgba(37, 99, 235, 0.08);
        color: var(--primary);
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: var(--radius-pill);
        margin-bottom: 12px;
        transition: var(--transition);
    }

    .apparatus-card:hover .apparatus-position {
        background-color: var(--primary);
        color: var(--white);
    }



    @media (max-width: 768px) {
        .pimpinan-grid {
            grid-template-columns: 1fr;
            justify-items: center;
        }
    }
</style>
@endsection

@section('content')

    <!-- HERO SECTION -->
    <section class="officials-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Perangkat Desa</span>
        </nav>
        <h1>Perangkat Desa Duren</h1>
        <p>Struktur Organisasi dan Tata Kerja Pemerintah Desa Duren, Kecamatan Tengaran, Kabupaten Semarang.</p>
    </section>

    <!-- CONTENT SECTION -->
    <div class="officials-container">
        @if(!$kades && !$sekdes && $staff->isEmpty() && $kadus->isEmpty())
            <div class="profile-section-card" style="text-align: center; padding: 60px 20px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.015);">
                <div style="font-size: 3.5rem; color: var(--primary); margin-bottom: 25px; opacity: 0.8;">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <h3 style="font-size: 1.6rem; font-weight: 800; color: var(--text-dark); margin-bottom: 12px;">Data Perangkat Desa Belum Tersedia</h3>
                <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto; line-height: 1.7; font-size: 1.05rem;">
                    Informasi mengenai perangkat desa sedang dalam proses pembaruan data. Silakan kunjungi kembali halaman ini dalam beberapa waktu ke depan.
                </p>
            </div>
        @else
            <!-- SECTION 1: PIMPINAN -->
            <section class="officials-section">
                <div class="pimpinan-grid">
                    <!-- Kepala Desa -->
                    @if($kades)
                    <div class="apparatus-card">
                        <div class="apparatus-img-wrapper">
                            <img src="{{ $kades->photo }}" alt="{{ $kades->name }}" class="apparatus-img">
                        </div>
                        <h3 class="apparatus-name">{{ $kades->name }}</h3>
                        <span class="apparatus-position">{{ $kades->position }}</span>
                    </div>
                    @endif

                    <!-- Sekretaris Desa -->
                    @if($sekdes)
                    <div class="apparatus-card">
                        <div class="apparatus-img-wrapper">
                            <img src="{{ $sekdes->photo }}" alt="{{ $sekdes->name }}" class="apparatus-img">
                        </div>
                        <h3 class="apparatus-name">{{ $sekdes->name }}</h3>
                        <span class="apparatus-position">{{ $sekdes->position }}</span>
                    </div>
                    @endif
                </div>
            </section>

            <!-- SECTION 2: KAUR & KASI (STAFF) -->
            <section class="officials-section">
                <h2 class="section-title">Kaur & Kasi</h2>
                <div class="staff-grid">
                    @foreach($staff as $member)
                    <div class="apparatus-card">
                        <div class="apparatus-img-wrapper">
                            <img src="{{ $member->photo }}" alt="{{ $member->name }}" class="apparatus-img">
                        </div>
                        <h3 class="apparatus-name">{{ $member->name }}</h3>
                        <span class="apparatus-position">{{ $member->position }}</span>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- SECTION 3: KEPALA DUSUN -->
            <section class="officials-section" style="margin-bottom: 0;">
                <h2 class="section-title">Kepala Dusun</h2>
                <div class="kadus-grid">
                    @foreach($kadus as $member)
                    <div class="apparatus-card">
                        <div class="apparatus-img-wrapper">
                            <img src="{{ $member->photo }}" alt="{{ $member->name }}" class="apparatus-img">
                        </div>
                        <h3 class="apparatus-name">{{ $member->name }}</h3>
                        <span class="apparatus-position">{{ $member->position }}</span>
                    </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

@endsection
