@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <style>
        .welcome-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 35px;
            border-radius: var(--radius-lg);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .welcome-card p {
            font-size: 1rem;
            color: #cbd5e1;
            max-width: 600px;
            line-height: 1.6;
        }

        .welcome-card i.bg-icon {
            position: absolute;
            right: 40px;
            bottom: -20px;
            font-size: 10rem;
            color: rgba(255, 255, 255, 0.05);
            pointer-events: none;
        }

        /* --- STATS GRID --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-light);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--text-dark);
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* --- COLOR VARIANTS --- */
        .icon-news {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .icon-reg {
            background-color: #fef3c7;
            color: #d97706;
        }

        .icon-off {
            background-color: #f0fdf4;
            color: #16a34a;
        }

        .icon-umkm {
            background-color: #faf5ff;
            color: #9333ea;
        }

        .icon-tour {
            background-color: #ecfeff;
            color: #0891b2;
        }

        .icon-cult {
            background-color: #fff1f2;
            color: #e11d48;
        }

        /* --- QUICK ACTIONS --- */
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        .action-list {
            list-style: none;
        }

        .action-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .action-item:last-child {
            border-bottom: none;
        }

        .action-link {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
        }

        .action-link:hover {
            color: var(--primary-light);
        }
    </style>
@endsection

@section('content')
    <!-- WELCOME CARD -->
    <div class="welcome-card">
        <h2>Selamat Datang, Admin!</h2>
        <p>Anda sedang berada di Panel Administrasi Website Resmi Desa Duren, Kecamatan Tengaran. Kelola semua konten,
            informasi publik, potensi wisata, produk UMKM, dan profil desa dari satu dashboard pusat.</p>
        <i class="fa-solid fa-house-chimney-user bg-icon"></i>
    </div>

    <!-- STATS GRID -->
    <div class="stats-grid">
        <a href="{{ route('admin.news.index') }}" class="stat-card">
            <div class="stat-icon icon-news">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['news'] }}</span>
                <span class="stat-label">Berita Desa</span>
            </div>
        </a>

        <a href="{{ route('admin.regulations.index') }}" class="stat-card">
            <div class="stat-icon icon-reg">
                <i class="fa-solid fa-gavel"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['regulations'] }}</span>
                <span class="stat-label">Peraturan Desa</span>
            </div>
        </a>

        <a href="{{ route('admin.officials.index') }}" class="stat-card">
            <div class="stat-icon icon-off">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['officials'] }}</span>
                <span class="stat-label">Perangkat Desa</span>
            </div>
        </a>

        <a href="{{ route('admin.umkm.index') }}" class="stat-card">
            <div class="stat-icon icon-umkm">
                <i class="fa-solid fa-store"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['umkm'] }}</span>
                <span class="stat-label">Produk UMKM</span>
            </div>
        </a>

        <a href="{{ route('admin.tourism.index') }}" class="stat-card">
            <div class="stat-icon icon-tour">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['tourism'] }}</span>
                <span class="stat-label">Tempat Wisata</span>
            </div>
        </a>

        <a href="{{ route('admin.culture.index') }}" class="stat-card">
            <div class="stat-icon icon-cult">
                <i class="fa-solid fa-masks-theater"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['culture'] }}</span>
                <span class="stat-label">Karya Budaya</span>
            </div>
        </a>
    </div>

    <!-- QUICK ACTIONS & RECENT WORK -->
    <div class="quick-actions">
        <!-- QUICK SHORTCUTS CARD -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h2><i class="fa-solid fa-bolt" style="color: var(--accent); margin-right: 8px;"></i> Pintasan Cepat</h2>
            </div>
            <ul class="action-list">
                <li class="action-item">
                    <a href="{{ route('admin.news.create') }}" class="action-link">
                        <i class="fa-solid fa-circle-plus" style="color: var(--primary-light);"></i> Tulis Berita Baru
                    </a>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-muted); font-size: 0.8rem;"></i>
                </li>
                <li class="action-item">
                    <a href="{{ route('admin.regulations.create') }}" class="action-link">
                        <i class="fa-solid fa-circle-plus" style="color: var(--primary-light);"></i> Unggah Regulasi/Perdes
                    </a>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-muted); font-size: 0.8rem;"></i>
                </li>
                <li class="action-item">
                    <a href="{{ route('admin.officials.create') }}" class="action-link">
                        <i class="fa-solid fa-circle-plus" style="color: var(--primary-light);"></i> Tambah Perangkat Desa
                    </a>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-muted); font-size: 0.8rem;"></i>
                </li>
                <li class="action-item">
                    <a href="{{ route('admin.umkm.create') }}" class="action-link">
                        <i class="fa-solid fa-circle-plus" style="color: var(--primary-light);"></i> Daftarkan UMKM Baru
                    </a>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-muted); font-size: 0.8rem;"></i>
                </li>
            </ul>
        </div>

        <!-- CONTACT & INFO CONFIG CARD -->
        <div class="card" style="margin-bottom: 0;">
            <div class="card-header">
                <h2><i class="fa-solid fa-circle-info" style="color: var(--primary-light); margin-right: 8px;"></i>
                    Informasi Umum</h2>
            </div>
            <div style="font-size: 0.95rem; line-height: 1.8; color: var(--text-muted);">
                <p style="margin-bottom: 15px;">Semua data yang diunggah atau disunting di panel admin ini akan langsung
                    tercermin secara real-time pada portal publik Desa Duren.</p>
                <p style="margin-bottom: 15px;">Gunakan berkas gambar berformat <strong>JPG, JPEG, PNG, WEBP</strong> untuk
                    foto/gambar dengan ukuran maksimal 2MB per gambar agar loading website publik tetap optimal.</p>
            </div>
        </div>
    </div>
@endsection