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
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
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
            width: 50px;
            height: 50px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--text-dark);
        }

        .stat-label {
            font-size: 0.85rem;
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

        .icon-ann {
            background-color: #fff7ed;
            color: #ea580c;
        }

        .icon-fac {
            background-color: #f0fdfa;
            color: #0d9488;
        }

        .icon-inst {
            background-color: #f5f3ff;
            color: #6d28d9;
        }

        .icon-agri {
            background-color: #fefce8;
            color: #ca8a04;
        }

        .icon-serv {
            background-color: #f0f9ff;
            color: #0284c7;
        }

        .icon-gall {
            background-color: #faf5ff;
            color: #7e22ce;
        }

        /* --- QUICK ACTIONS --- */
        .quick-actions {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 25px;
            margin-top: 30px;
        }

        @media (max-width: 992px) {
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

        <a href="{{ route('admin.announcements.index') }}" class="stat-card">
            <div class="stat-icon icon-ann">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['announcements'] }}</span>
                <span class="stat-label">Pengumuman</span>
            </div>
        </a>

        <a href="{{ route('admin.facilities.index') }}" class="stat-card">
            <div class="stat-icon icon-fac">
                <i class="fa-solid fa-building-shield"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['facilities'] }}</span>
                <span class="stat-label">Fasilitas Desa</span>
            </div>
        </a>

        <a href="{{ route('admin.institutions.index') }}" class="stat-card">
            <div class="stat-icon icon-inst">
                <i class="fa-solid fa-landmark"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['institutions'] }}</span>
                <span class="stat-label">Lembaga Desa</span>
            </div>
        </a>

        <a href="{{ route('admin.agriculture.index') }}" class="stat-card">
            <div class="stat-icon icon-agri">
                <i class="fa-solid fa-wheat-awn"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['agriculture'] }}</span>
                <span class="stat-label">Pertanian & Peternakan</span>
            </div>
        </a>

        <a href="{{ route('admin.public-services.index') }}" class="stat-card">
            <div class="stat-icon icon-serv">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['services'] }}</span>
                <span class="stat-label">Layanan Publik</span>
            </div>
        </a>

        <a href="{{ route('admin.gallery.index') }}" class="stat-card">
            <div class="stat-icon icon-gall">
                <i class="fa-solid fa-images"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $counts['gallery'] }}</span>
                <span class="stat-label">Galeri Desa</span>
            </div>
        </a>
    </div>

    <!-- QUICK ACTIONS & RECENT WORK -->
    <div class="quick-actions">
        <!-- QUICK SHORTCUTS CARD -->
        <div class="card" style="margin-bottom: 0; background: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div class="card-header" style="border-bottom: 2px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--text-dark); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-bolt" style="color: var(--accent);"></i> Pintasan Cepat
                </h2>
                <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Akses Kilat Form Tambah</span>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <a href="{{ route('admin.news.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-dark); background: #f8fafc; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary-light)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='#f8fafc';">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0;"><i class="fa-solid fa-newspaper"></i></span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 0.85rem; line-height: 1.2;">Tulis Berita</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Kabar & Berita</span>
                    </div>
                </a>

                <a href="{{ route('admin.regulations.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-dark); background: #f8fafc; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary-light)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='#f8fafc';">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0;"><i class="fa-solid fa-gavel"></i></span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 0.85rem; line-height: 1.2;">Unggah Perdes</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Peraturan Desa</span>
                    </div>
                </a>

                <a href="{{ route('admin.officials.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-dark); background: #f8fafc; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary-light)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='#f8fafc';">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0;"><i class="fa-solid fa-users"></i></span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 0.85rem; line-height: 1.2;">Perangkat Desa</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Tambah Pengurus</span>
                    </div>
                </a>

                <a href="{{ route('admin.umkm.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-dark); background: #f8fafc; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary-light)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='#f8fafc';">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: #faf5ff; color: #9333ea; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0;"><i class="fa-solid fa-store"></i></span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 0.85rem; line-height: 1.2;">Daftar UMKM</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Produk Warga</span>
                    </div>
                </a>

                <a href="{{ route('admin.transparency.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-dark); background: #f8fafc; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary-light)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='#f8fafc';">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: #fff1f2; color: #e11d48; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0;"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 0.85rem; line-height: 1.2;">Input APBDes</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Laporan Keuangan</span>
                    </div>
                </a>

                <a href="{{ route('admin.announcements.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius-md); text-decoration: none; color: var(--text-dark); background: #f8fafc; transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--primary-light)'; this.style.background='#fff';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='#f8fafc';">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0;"><i class="fa-solid fa-bullhorn"></i></span>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 700; font-size: 0.85rem; line-height: 1.2;">Tulis Pengumuman</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Info Mendesak</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- RECENT ACTIVITY CARD -->
        <div class="card" style="margin-bottom: 0; background: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div class="card-header" style="border-bottom: 2px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--text-dark); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary-light);"></i> Aktivitas Terbaru
                </h2>
                <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">5 Unggahan Terakhir</span>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @forelse($recentActivities as $activity)
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="width: 32px; height: 32px; border-radius: var(--radius-md); background: {{ $activity['bg'] }}; color: {{ $activity['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0; margin-top: 2px;">
                            <i class="fa-solid {{ $activity['icon'] }}"></i>
                        </span>
                        <div style="display: flex; flex-direction: column; min-width: 0; flex: 1;">
                            <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $activity['title'] }}">{{ $activity['title'] }}</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; text-transform: uppercase; letter-spacing: 0.3px; font-weight: 600;">
                                @if($activity['type'] == 'news') Berita @elseif($activity['type'] == 'regulation') Peraturan @else UMKM @endif
                                &bull; <span style="font-weight: 500; text-transform: none;">{{ $activity['time']->diffForHumans() }}</span>
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 30px 0; color: var(--text-muted); font-size: 0.85rem;">
                        <i class="fa-solid fa-folder-open" style="font-size: 2rem; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                        Belum ada aktivitas unggahan terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection