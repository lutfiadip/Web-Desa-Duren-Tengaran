@extends('admin.layouts.admin')

@section('title', 'Sunting Profil Desa')

@section('styles')
<style>
    .profile-menu-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .profile-menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .profile-menu-item:hover {
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.08), 0 4px 6px -2px rgba(37, 99, 235, 0.04);
        background: #f8fafc;
    }

    .profile-menu-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        background: rgba(37, 99, 235, 0.08);
        color: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .profile-menu-item:hover .profile-menu-icon {
        background: var(--primary-light);
        color: #ffffff;
    }

    .profile-menu-content {
        flex-grow: 1;
        margin-left: 20px;
    }

    .profile-menu-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .profile-menu-desc {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .profile-menu-arrow {
        font-size: 1.1rem;
        color: #94a3b8;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .profile-menu-item:hover .profile-menu-arrow {
        color: var(--primary-light);
        transform: translateX(4px);
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 25px; font-size: 0.9rem;">
        <ol style="list-style: none; padding: 0; display: flex; gap: 8px; align-items: center; color: var(--text-muted); margin: 0;">
            <li>
                <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Profil Desa</li>
        </ol>
    </nav>

    <!-- Toggle Publikasi Halaman -->
    <div class="card" style="max-width: 800px; margin: 0 auto 20px auto;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <div>
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0;">
                    <i class="fa-solid fa-globe" style="color: var(--primary-light);"></i> Status Publikasi Halaman Profil Desa
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">Tentukan apakah Halaman Profil Desa dipublikasikan secara umum di website.</p>
            </div>
            <label class="switch">
                <input type="checkbox" class="global-publish-toggle" data-key="publish_profile" {{ ($profile->publish_profile ?? true) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-gears" style="color: var(--primary-light);"></i> Pengaturan Profil Desa
            </h2>
        </div>



        <div class="profile-menu-list">
            <!-- Pilihan 1: Identitas & Informasi Dasar Desa -->
            <a href="{{ route('admin.profile.edit-identity') }}" class="profile-menu-item">
                <div class="profile-menu-icon">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div class="profile-menu-content">
                    <div class="profile-menu-title">Identitas & Informasi Dasar Desa</div>
                    <div class="profile-menu-desc">Kelola nama desa, jam operasional kantor desa, dan logo resmi desa.</div>
                </div>
                <div class="profile-menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>

            <!-- Pilihan 2: Tata Letak & Bagian Halaman Profil -->
            <a href="{{ route('admin.profile.edit-layout') }}" class="profile-menu-item">
                <div class="profile-menu-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="profile-menu-content">
                    <div class="profile-menu-title">Tata Letak & Bagian Halaman Profil</div>
                    <div class="profile-menu-desc">Atur urutan bagian halaman utama (Drag & Drop), kelola kata sambutan kades, sejarah, visi misi, bagan organisasi, dan link peta dusun.</div>
                </div>
                <div class="profile-menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>

            <!-- Pilihan 3: Teks & Deskripsi Halaman -->
            <a href="{{ route('admin.profile.edit-descriptions') }}" class="profile-menu-item">
                <div class="profile-menu-icon">
                    <i class="fa-solid fa-align-left"></i>
                </div>
                <div class="profile-menu-content">
                    <div class="profile-menu-title">Teks & Deskripsi Halaman</div>
                    <div class="profile-menu-desc">Atur teks deskripsi (subjudul) yang muncul pada banner halaman UMKM, Pariwisata, Berita, Aparatur, Peraturan, Lembaga, dan Pertanian.</div>
                </div>
                <div class="profile-menu-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </a>

        </div>
    </div>
@endsection