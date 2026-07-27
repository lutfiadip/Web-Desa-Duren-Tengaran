@extends('layouts.app')

@section('title', 'Potensi Pertanian & Peternakan - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .agri-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .agri-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .agri-hero p {
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

    /* --- CONTAINER & SECTIONS --- */
    .agri-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    .agri-section {
        margin-bottom: 60px;
    }

    .agri-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 45px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: var(--transition);
        margin-bottom: 40px;
    }

    .agri-card:hover {
        border-color: rgba(37, 99, 235, 0.15);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
    }

    .agri-section-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 15px;
    }

    .agri-section-title i {
        color: var(--primary);
    }

    .agri-desc-text {
        font-size: 1.1rem;
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 25px;
        text-align: justify;
    }

    /* --- STATS GRID --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .stats-card {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px 25px;
        text-align: center;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        background-color: var(--white);
        border-color: var(--primary);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.05);
    }

    .stats-card i {
        font-size: 2.5rem;
        color: var(--primary);
        margin-bottom: 15px;
        display: inline-block;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .stats-label {
        font-size: 0.95rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* --- COMMODITIES --- */
    .com-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }

    .com-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .com-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.06);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .com-img-wrapper {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .com-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .com-card:hover .com-img {
        transform: scale(1.05);
    }

    .com-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background-color: rgba(37, 99, 235, 0.9);
        backdrop-filter: blur(4px);
        color: var(--white);
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .com-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .com-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 12px;
    }

    .com-desc {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .com-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition);
    }

    .com-link:hover {
        color: var(--primary-hover);
        gap: 10px;
    }

    /* --- GAPOKTAN TABLE --- */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        margin-top: 20px;
    }

    .gapoktan-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.95rem;
    }

    .gapoktan-table th {
        background-color: #f1f5f9;
        color: var(--text-dark);
        font-weight: 700;
        padding: 16px 20px;
        border-bottom: 2px solid var(--border-color);
    }

    .gapoktan-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted);
        font-weight: 500;
    }

    .gapoktan-table tr:last-child td {
        border-bottom: none;
    }

    .gapoktan-table tr:hover td {
        background-color: #f8fafc;
        color: var(--text-dark);
    }

    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: 0.75rem;
        font-weight: 700;
    }

    .badge-status.active {
        background-color: #d1fae5;
        color: #065f46;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .agri-hero h1 {
            font-size: 2.2rem;
        }
        
        .agri-hero p {
            font-size: 1rem;
        }

        .agri-card {
            padding: 25px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .com-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="agri-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="separator">Potensi</span>
            <span class="separator">/</span>
            <span class="current">Pertanian & Peternakan</span>
        </nav>
        <h1>{{ $agriProfile->title ?? 'Pertanian & Peternakan' }}</h1>
        <p>{{ $agriProfile->subtitle ?? 'Menjelajahi potensi agraris dan kelimpahan sumber daya pangan lokal di Desa Duren, Kecamatan Tengaran' }}</p>
    </section>

    <!-- CONTENT -->
    <div class="agri-container">
        
        <!-- PROFIL UMUM -->
        <div class="agri-section">
            <div class="agri-card">
                <h2 class="agri-section-title"><i class="fa-solid fa-seedling"></i> Profil Sektor Agraris Desa</h2>
                @if($agriProfile)
                    @if($agriProfile->description_1)
                        <p class="agri-desc-text">{{ $agriProfile->description_1 }}</p>
                    @endif
                    @if($agriProfile->description_2)
                        <p class="agri-desc-text">{{ $agriProfile->description_2 }}</p>
                    @endif
                @else
                    <p class="agri-desc-text">Data profil pertanian belum terisi.</p>
                @endif
            </div>
        </div>

        <!-- STATISTIK LAHAN TANI -->
        <div class="agri-section">
            <div class="agri-card">
                <h2 class="agri-section-title"><i class="fa-solid fa-chart-pie"></i> Potensi Luas Penggunaan Lahan</h2>
                <p class="agri-desc-text" style="margin-bottom: 10px;">
                    Pemanfaatan tata ruang wilayah Desa Duren didominasi oleh peruntukan lahan hijau produktif guna mendukung ketahanan pangan lokal. Berikut merupakan estimasi sebaran pemanfaatan lahan pertanian dan perkebunan:
                </p>

                <div class="stats-grid">
                    @forelse($landStats as $stat)
                        <div class="stats-card">
                            <i class="fa-solid {{ $stat->icon ?? 'fa-leaf' }}"></i>
                            <div class="stats-number">{{ $stat->area }} {{ $stat->unit }}</div>
                            <div class="stats-label">{{ $stat->label }}</div>
                        </div>
                    @empty
                        <div style="text-align: center; grid-column: 1 / -1; color: var(--text-muted);">Data statistik lahan belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KOMODITAS UNGGULAN -->
        <div class="agri-section">
            <div class="agri-card" style="border: none; padding: 0; background: transparent; box-shadow: none;">
                <h2 class="agri-section-title" style="border-bottom: 2px solid var(--border-color); padding-bottom: 15px; background: var(--white); padding: 25px; border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin-bottom: 0;"><i class="fa-solid fa-wheat-awn"></i> Komoditas Unggulan Desa</h2>
                
                <div class="com-grid">
                    <!-- Durian -->
                    <div class="com-card">
                        <div class="com-img-wrapper">
                            <span class="com-badge">Hortikultura</span>
                            <img src="https://images.unsplash.com/photo-1621841315897-b5425231de3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Durian Lokal" class="com-img">
                        </div>
                        <div class="com-body">
                            <h3 class="com-title">Buah Durian Lokal</h3>
                            <p class="com-desc">Sesuai namanya, Desa Duren terkenal dengan pohon durian lokal berbuah lebat yang manis-pahit legit dengan daging tebal. Menjadi andalan agrowisata tahunan desa saat musim panen tiba.</p>
                            <a href="{{ route('tourism.detail', 'agrowisata-kebun-durian-duren') }}" class="com-link">Lihat Agrowisata Kebun <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <!-- Kopi -->
                    <div class="com-card">
                        <div class="com-img-wrapper">
                            <span class="com-badge">Perkebunan</span>
                            <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Kopi Lereng Merbabu" class="com-img">
                        </div>
                        <div class="com-body">
                            <h3 class="com-title">Kopi Lereng Merbabu</h3>
                            <p class="com-desc">Biji kopi robusta pilihan dari perbukitan lereng Gunung Merbabu diolah secara tradisional oleh warga setempat menghasilkan cita rasa harum yang mantap dan tebal.</p>
                            <a href="{{ route('umkm.detail', 'kopi-bubuk-asli-duren') }}" class="com-link">Beli Kopi Lokal <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <!-- Susu Sapi -->
                    <div class="com-card">
                        <div class="com-img-wrapper">
                            <span class="com-badge">Peternakan</span>
                            <img src="https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sapi Perah" class="com-img">
                        </div>
                        <div class="com-body">
                            <h3 class="com-title">Susu Sapi Perah</h3>
                            <p class="com-desc">Pusat peternakan sapi perah rakyat memproduksi ratusan liter susu murni higienis berkualitas tinggi setiap hari, dipasok untuk kebutuhan konsumsi lokal dan industri susu olahan regional.</p>
                            <span class="com-desc" style="color: var(--text-muted); font-size: 0.85rem; font-style: italic;">*Komoditas unggulan komersial desa</span>
                        </div>
                    </div>

                    <!-- Madu Hutan -->
                    <div class="com-card">
                        <div class="com-img-wrapper">
                            <span class="com-badge">Kehutanan</span>
                            <img src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Madu Hutan" class="com-img">
                        </div>
                        <div class="com-body">
                            <h3 class="com-title">Madu Hutan Rimba</h3>
                            <p class="com-desc">Madu murni alami tanpa bahan campuran kimia yang dipanen dari budidaya lebah madu liar di area sekitar hutan bambu rindang wilayah desa.</p>
                            <a href="{{ route('umkm.detail', 'madu-hutan-rimba-duren') }}" class="com-link">Beli Madu Murni <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KELOMPOK TANI (GAPOKTAN) -->
        <div class="agri-section">
            <div class="agri-card">
                <h2 class="agri-section-title"><i class="fa-solid fa-users-items"></i> Kelembagaan Kelompok Tani (Gapoktan)</h2>
                <p class="agri-desc-text" style="margin-bottom: 20px;">
                    Guna mempermudah koordinasi, pembagian bantuan bibit pupuk, dan pemasaran hasil panen, para petani dan peternak terhimpun ke dalam Gabungan Kelompok Tani (Gapoktan) tingkat desa. Berikut daftar kelompok tani aktif:
                </p>

                <div class="table-responsive">
                    <table class="gapoktan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelompok</th>
                                <th>Sektor Komoditas</th>
                                <th>Dusun Operasional</th>
                                <th>Status Aktif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($farmerGroups as $index => $group)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->sector }}</td>
                                    <td>{{ $group->dusun }}</td>
                                    <td>
                                        @if($group->is_active)
                                            <span class="badge-status active">Aktif</span>
                                        @else
                                            <span class="badge-status" style="background-color: #fee2e2; color: #991b1b;">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 20px;">Data kelompok tani belum tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
