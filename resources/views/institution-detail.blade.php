@extends('layouts.app')

@section('title', $institution->name . ' - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- BREADCRUMB --- */
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
    }

    /* --- PROFILE HERO HEADER --- */
    .profile-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 100px 5% 60px;
        color: var(--white);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .hero-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .hero-logo-wrapper {
        width: 110px;
        height: 110px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .hero-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-initial {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--white);
    }

    .hero-text h1 {
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
        line-height: 1.2;
    }

    .hero-badge {
        display: inline-block;
        background-color: rgba(255, 255, 255, 0.15);
        color: #d1d5db;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: var(--radius-sm);
        letter-spacing: 0.5px;
    }

    /* --- LAYOUT GRID --- */
    .detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 50px 5% 80px;
        display: grid;
        grid-template-columns: 8fr 4fr;
        gap: 40px;
    }

    /* --- LEFT COLUMN --- */
    .card-section {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 40px;
        margin-bottom: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .card-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 12px;
    }

    .section-title i {
        color: var(--primary);
    }

    .about-text {
        font-size: 1.1rem;
        color: var(--text-muted);
        line-height: 1.8;
        text-align: justify;
    }

    /* --- VISION & MISSION CARDS --- */
    .vimi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-top: 20px;
    }

    .vimi-card {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 30px;
        height: 100%;
    }

    .vimi-card h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vimi-card h3 i {
        color: var(--primary);
    }

    .vimi-content {
        font-size: 1rem;
        color: var(--text-muted);
        line-height: 1.7;
    }

    /* --- STRUCTURE (MEMBERS) --- */
    .members-title {
        text-align: center;
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 40px;
    }

    .structure-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 30px;
        justify-content: center;
    }

    /* Target specific grids for structure hierarchy */
    .leader-row {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        position: relative;
    }

    .leader-row::after {
        content: '';
        position: absolute;
        bottom: -25px;
        left: 50%;
        width: 2px;
        height: 25px;
        background-color: var(--border-color);
        display: none; /* Can be enabled for connector lines */
    }

    .staff-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 240px));
        gap: 30px;
        justify-content: center;
    }

    .member-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 20px;
        text-align: center;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.01);
    }

    .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        border-color: var(--primary);
    }

    .member-photo-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 15px;
        border: 3px solid #f1f5f9;
        background-color: #f1f5f9;
    }

    .member-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .member-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .member-position {
        font-size: 0.85rem;
        color: var(--primary);
        font-weight: 600;
    }

    /* --- RIGHT COLUMN (SIDEBAR) --- */
    .sidebar-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 100px;
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 25px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar-title i {
        color: var(--primary);
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        background-color: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .info-text-wrapper {
        flex-grow: 1;
    }

    .info-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .info-val {
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 700;
        word-break: break-all;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .sidebar-card {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .card-section {
            padding: 25px;
        }

        .vimi-grid {
            grid-template-columns: 1fr;
        }
        
        .staff-row {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }
</style>
@endsection

@section('content')
    <!-- PROFILE HERO -->
    <section class="profile-hero">
        <!-- BREADCRUMB -->
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <a href="{{ route('institutions') }}">Lembaga Masyarakat</a>
            <span class="separator">/</span>
            <span class="current">{{ $institution->name }}</span>
        </nav>

        <div class="hero-content">
            <div class="hero-logo-wrapper">
                @if($institution->logo)
                    <img src="{{ Str::startsWith($institution->logo, 'http') ? $institution->logo : asset($institution->logo) }}" alt="{{ $institution->name }}" class="hero-logo">
                @else
                    <div class="hero-initial">{{ substr($institution->name, 0, 1) }}</div>
                @endif
            </div>
            <div class="hero-text">
                <span class="hero-badge">{{ $institution->category->name ?? 'Lembaga Masyarakat' }}</span>
                <h1>{{ $institution->name }}</h1>
            </div>
        </div>
    </section>

    <!-- CONTENT CONTAINER -->
    <div class="detail-container">
        
        <!-- LEFT COLUMN: PROFILE, VISION, MEMBERS -->
        <div class="main-content-column">
            
            <!-- TENTANG LEMBAGA -->
            <div class="card-section">
                <h2 class="section-title"><i class="fa-solid fa-circle-nodes"></i> Profil & Tugas Pokok</h2>
                <div class="about-text">
                    {!! nl2br(e($institution->description)) !!}
                </div>
            </div>

            <!-- VISI & MISI -->
            @if($institution->vision || $institution->mission)
                <div class="card-section">
                    <h2 class="section-title"><i class="fa-solid fa-bullseye"></i> Visi & Misi Lembaga</h2>
                    
                    <div class="vimi-grid">
                        @if($institution->vision)
                            <div class="vimi-card">
                                <h3><i class="fa-solid fa-eye"></i> Visi</h3>
                                <div class="vimi-content">
                                    {{ $institution->vision }}
                                </div>
                            </div>
                        @endif

                        @if($institution->mission)
                            <div class="vimi-card">
                                <h3><i class="fa-solid fa-list-check"></i> Misi</h3>
                                <div class="vimi-content" style="white-space: pre-line;">{{ $institution->mission }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- STRUKTUR KEPENGURUSAN -->
            @if(count($members) > 0)
                <div class="card-section">
                    <h2 class="section-title"><i class="fa-solid fa-sitemap"></i> Struktur Organisasi Pengurus</h2>
                    
                    <!-- LKD Hierarchy layout -->
                    @php
                        $leader = $members->first();
                        $staff = $members->slice(1);
                    @endphp

                    <!-- Leader (Ketua) Row -->
                    @if($leader)
                        <div class="leader-row">
                            <div class="member-card" style="width: 240px; border-color: var(--primary); background: #eff6ff;">
                                <div class="member-photo-wrapper" style="border-color: #dbeafe;">
                                    <img src="{{ $leader->photo ? (Str::startsWith($leader->photo, 'http') ? $leader->photo : asset($leader->photo)) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" alt="{{ $leader->name }}" class="member-photo">
                                </div>
                                <h4 class="member-name">{{ $leader->name }}</h4>
                                <div class="member-position">{{ $leader->position }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Staff/Other Members Row -->
                    @if(count($staff) > 0)
                        <div class="staff-row">
                            @foreach($staff as $member)
                                <div class="member-card">
                                    <div class="member-photo-wrapper">
                                        <img src="{{ $member->photo ? (Str::startsWith($member->photo, 'http') ? $member->photo : asset($member->photo)) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" alt="{{ $member->name }}" class="member-photo">
                                    </div>
                                    <h4 class="member-name">{{ $member->name }}</h4>
                                    <div class="member-position">{{ $member->position }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN: SIDEBAR CONTACT INFO -->
        <div class="sidebar-column">
            <div class="sidebar-card">
                <h3 class="sidebar-title"><i class="fa-solid fa-address-book"></i> Kontak & Informasi</h3>
                
                <div class="info-list">
                    <!-- Kategori -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-folder"></i>
                        </div>
                        <div class="info-text-wrapper">
                            <div class="info-label">Jenis Lembaga</div>
                            <div class="info-val">{{ $institution->category->name ?? 'Lembaga Masyarakat' }}</div>
                        </div>
                    </div>

                    <!-- Sekretariat -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-building-user"></i>
                        </div>
                        <div class="info-text-wrapper">
                            <div class="info-label">Alamat Sekretariat</div>
                            <div class="info-val">{{ $institution->address ?? 'Kantor Desa Duren, Kec. Tengaran, Kab. Semarang, 50775' }}</div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    @if($institution->contact)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="info-text-wrapper">
                                <div class="info-label">No. Telepon / WhatsApp</div>
                                <div class="info-val">{{ $institution->contact }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Email -->
                    @if($institution->email)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="info-text-wrapper">
                                <div class="info-label">Alamat Email</div>
                                <div class="info-val">{{ $institution->email }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
