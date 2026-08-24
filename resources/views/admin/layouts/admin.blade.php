<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Panel Desa Duren</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1e3a8a; /* Deep Navy */
            --primary-light: #2563eb; /* Sapphire */
            --accent: #f59e0b; /* Amber */
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-sidebar: #0f172a;
            --bg-main: #f1f5f9;
            --white: #ffffff;
            --border-color: #e2e8f0;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition: all 0.25s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: var(--bg-sidebar);
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: width 0.3s ease, transform 0.3s ease;
            overflow: hidden;
        }

        /* Sidebar collapsed state */
        body.sidebar-collapsed .sidebar {
            width: 0;
            transform: translateX(-260px);
        }

        body.sidebar-collapsed .main-wrapper {
            width: 100%;
        }

        /* Toggle button in header */
        .sidebar-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-dark);
            font-size: 1.2rem;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            margin-right: 12px;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            background-color: var(--bg-main);
            color: var(--primary-light);
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--white);
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand img {
            height: 38px;
        }

        .sidebar-brand span {
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 12px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-menu li {
            margin-bottom: 6px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: var(--white);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a.active {
            background-color: var(--primary-light);
            color: var(--white);
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* --- SUBMENU SIDEBAR --- */
        .sidebar-menu .submenu {
            list-style: none;
            padding-left: 20px;
            margin-top: 4px;
            display: none;
        }

        .sidebar-menu .has-submenu.active-parent .submenu {
            display: block;
        }

        .sidebar-menu .submenu li {
            margin-bottom: 4px;
        }

        .sidebar-menu .submenu a {
            padding: 10px 16px;
            font-size: 0.9rem;
            opacity: 0.85;
            background-color: transparent !important;
            color: #94a3b8;
        }

        .sidebar-menu .submenu a:hover, 
        .sidebar-menu .submenu a.active {
            opacity: 1;
            color: var(--white) !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        .sidebar-menu .submenu a.active {
            background-color: var(--primary-light) !important;
        }

        .sidebar-menu .submenu-toggle {
            cursor: pointer;
            display: flex;
            justify-content: space-between !important;
            align-items: center;
        }

        .sidebar-menu .submenu-toggle .arrow {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
            margin-left: auto;
        }

        .sidebar-menu .has-submenu.active-parent .submenu-toggle .arrow {
            transform: rotate(180deg);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            background-color: #ef4444;
            color: var(--white);
            border: none;
            border-radius: var(--radius-md);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        /* --- MAIN WRAPPER --- */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* --- HEADER --- */
        header {
            background-color: var(--white);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }

        .header-title h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #eff6ff;
            color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* --- CONTENT --- */
        .content {
            padding: 32px;
            flex-grow: 1;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        /* --- ALERTS --- */
        .alert {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            min-width: 320px;
            max-width: 450px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 16px 20px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: opacity 0.4s ease, transform 0.4s ease;
            opacity: 1;
            transform: translateY(0);
        }

        .alert.hide {
            opacity: 0;
            transform: translateY(-20px);
        }

        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* --- COMMON UI STYLES --- */
        .card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }

        .card-header h2 {
            font-size: 1.2rem;
            font-weight: 800;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-light);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background-color: #cbd5e1;
        }

        .btn-danger {
            background-color: #ef4444;
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* --- FORMS --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            font-size: 0.95rem;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            padding-right: 40px;
            cursor: pointer;
        }

        select.form-control:focus {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232563eb' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='18 15 12 9 6 15'%3e%3c/polyline%3e%3c/svg%3e");
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* --- TABLES --- */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            padding: 14px 16px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: 0.8rem;
            font-weight: 700;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-secondary {
            background-color: #e2e8f0;
            color: #475569;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #d97706;
        }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-icon:hover {
            background-color: #f8fafc;
            color: var(--text-dark);
        }

        .btn-icon.edit:hover {
            border-color: var(--primary-light);
            color: var(--primary-light);
            background-color: #eff6ff;
        }

        .btn-icon.delete:hover {
            border-color: #ef4444;
            color: #ef4444;
            background-color: #fee2e2;
        }

        /* --- PAGINATION --- */
        .pagination-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            list-style: none;
            gap: 5px;
        }

        .pagination li a, .pagination li span {
            padding: 8px 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .pagination li a:hover {
            background-color: #f1f5f9;
        }

        .pagination li.active span {
            background-color: var(--primary-light);
            color: var(--white);
            border-color: var(--primary-light);
        }

        /* Switch Toggle Styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
            flex-shrink: 0;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .25s ease;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .25s ease;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        input:checked + .slider {
            background-color: var(--primary-light);
        }
        input:checked + .slider:before {
            transform: translateX(24px);
        }

        /* Dynamic gallery photo deletion styles */
        .gallery-photo-wrapper {
            position: relative;
            transition: transform 0.2s ease;
        }
        .gallery-photo-wrapper:hover {
            transform: scale(1.02);
        }
        .gallery-photo-wrapper .btn-delete-photo {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #ef4444;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.25);
            transition: all 0.2s;
            opacity: 0;
            pointer-events: none;
            z-index: 10;
            padding: 0;
            line-height: 1;
        }
        .gallery-photo-wrapper .btn-delete-photo i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .gallery-photo-wrapper:hover .btn-delete-photo {
            opacity: 1;
            pointer-events: auto;
        }
        .gallery-photo-wrapper .btn-delete-photo:hover {
            background-color: #dc2626;
            transform: scale(1.15);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('img/logo-semarang.png') }}" alt="Logo">
            <span>ADMIN<br>DESA DUREN</span>
        </a>

        <ul class="sidebar-menu">
            <!-- 1. Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            </li>

            <!-- 2. Halaman Utama -->
            <li class="has-submenu">
                <a href="#" class="submenu-toggle">
                    <i class="fa-solid fa-home"></i>
                    <span>Halaman Utama</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.homepage.edit') }}" class="{{ request()->routeIs('admin.homepage.edit') ? 'active' : '' }}">
                            <i class="fa-solid fa-home"></i> Beranda Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-images"></i> Galeri Desa
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 3. Profil & Kontak -->
            <li class="has-submenu">
                <a href="#" class="submenu-toggle">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span>Profil & Kontak</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.edit') || request()->routeIs('admin.profile.edit-identity') || request()->routeIs('admin.profile.edit-layout') ? 'active' : '' }}">
                            <i class="fa-solid fa-house-chimney"></i> Profil Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profile.edit-contact') }}" class="{{ request()->routeIs('admin.profile.edit-contact') ? 'active' : '' }}">
                            <i class="fa-solid fa-address-book"></i> Info Kontak
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 4. Pemerintahan -->
            <li class="has-submenu">
                <a href="#" class="submenu-toggle">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <span>Pemerintahan</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.officials.index') }}" class="{{ request()->routeIs('admin.officials.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users"></i> Perangkat Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.regulations.index') }}" class="{{ request()->routeIs('admin.regulations.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-gavel"></i> Peraturan Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transparency.index') }}" class="{{ request()->routeIs('admin.transparency.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-line"></i> Transparansi
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 5. Kemasyarakatan -->
            <li class="has-submenu">
                <a href="#" class="submenu-toggle">
                    <i class="fa-solid fa-people-group"></i>
                    <span>Kemasyarakatan</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.institutions.index') }}" class="{{ request()->routeIs('admin.institutions.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-landmark"></i> Lembaga
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.organizations.index') }}" class="{{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-rectangle"></i> Organisasi
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 6. Potensi Desa -->
            <li class="has-submenu">
                <a href="#" class="submenu-toggle">
                    <i class="fa-solid fa-store"></i>
                    <span>Potensi Desa</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.tourism.index') }}" class="{{ request()->routeIs('admin.tourism.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-map-location-dot"></i> Tempat Wisata
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.culture.index') }}" class="{{ request()->routeIs('admin.culture.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-masks-theater"></i> Kebudayaan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.umkm.index') }}" class="{{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-store"></i> UMKM Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.agriculture.index') }}" class="{{ request()->routeIs('admin.agriculture.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-wheat-awn"></i> Pertanian & Peternakan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 7. Informasi & Layanan -->
            <li class="has-submenu">
                <a href="#" class="submenu-toggle">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Info & Layanan</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-newspaper"></i> Berita Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.public-services.index') }}" class="{{ request()->routeIs('admin.public-services.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-folder-open"></i> Panduan Layanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.statistics.index') }}" class="{{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-pie"></i> Statistik Penduduk
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 8. Kelola Admin -->
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-gear"></i> Kelola Admin
                </a>
            </li>

            <!-- 9. Lihat Website -->
            <li style="margin-top: 20px;">
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fa-solid fa-globe"></i> Lihat Website
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <header>
            <div style="display: flex; align-items: center;">
                <button class="sidebar-toggle-btn" id="sidebar-toggle-btn" title="Sembunyikan / Tampilkan Sidebar">
                    <i class="fa-solid fa-bars" id="sidebar-toggle-icon"></i>
                </button>
                <div class="header-title">
                    <h1>@yield('title', 'Admin Panel')</h1>
                </div>
            </div>
            <div class="user-info">
                <div class="user-avatar" style="text-transform: uppercase;">{{ substr(Auth::user()->name ?? 'AD', 0, 2) }}</div>
                <div style="font-weight: 700; font-size: 0.95rem;">{{ Auth::user()->name ?? 'Admin Desa' }}</div>
            </div>
        </header>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <ul style="list-style: none;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto add red asterisk to labels of required inputs globally
            document.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
                let id = input.getAttribute('id');
                let label = null;
                if (id) {
                    label = document.querySelector(`label[for="${id}"]`);
                }
                if (!label) {
                    let formGroup = input.closest('.form-group') || input.closest('.form-row') || input.parentElement;
                    if (formGroup) {
                        label = formGroup.querySelector('label');
                    }
                }
                if (label && !label.innerHTML.includes('*') && !label.textContent.includes('*')) {
                    const star = document.createElement('span');
                    star.style.color = '#ef4444';
                    star.style.marginLeft = '4px';
                    star.style.fontWeight = 'bold';
                    star.innerHTML = '*';
                    label.appendChild(star);
                }
            });

            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Create close button
                const closeBtn = document.createElement('button');
                closeBtn.innerHTML = '&times;';
                closeBtn.className = 'alert-close-btn';
                
                // Style close button dynamically
                closeBtn.style.background = 'none';
                closeBtn.style.border = 'none';
                closeBtn.style.fontSize = '1.3rem';
                closeBtn.style.lineHeight = '1';
                closeBtn.style.cursor = 'pointer';
                closeBtn.style.marginLeft = 'auto';
                closeBtn.style.padding = '0 0 0 12px';
                closeBtn.style.color = 'inherit';
                closeBtn.style.opacity = '0.5';
                closeBtn.style.transition = 'opacity 0.2s';
                closeBtn.setAttribute('aria-label', 'Close alert');
                
                closeBtn.addEventListener('mouseenter', () => closeBtn.style.opacity = '1');
                closeBtn.addEventListener('mouseleave', () => closeBtn.style.opacity = '0.5');

                alert.appendChild(closeBtn);

                // Dismiss function
                const dismiss = () => {
                    alert.classList.add('hide');
                    setTimeout(() => {
                        alert.remove();
                    }, 400); // Wait for CSS transition
                };

                // Close button click listener
                closeBtn.addEventListener('click', dismiss);

                // Auto-dismiss after 4 seconds
                setTimeout(dismiss, 4000);
            });

            // AJAX toggle for global publish settings
            const toggles = document.querySelectorAll('.global-publish-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const key = this.getAttribute('data-key');
                    const value = this.checked ? 1 : 0;
                    
                    fetch('{{ route("admin.profile.update-setting") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ key: key, value: value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Status publikasi berhasil diperbarui.', 'success');
                        } else {
                            showToast(data.message || 'Gagal memperbarui status publikasi.', 'error');
                            this.checked = !this.checked;
                        }
                    })
                    .catch(error => {
                        console.error('Error updating setting:', error);
                        showToast('Terjadi kesalahan koneksi.', 'error');
                        this.checked = !this.checked;
                    });
                });
            });

            function showToast(message, type) {
                // Remove existing toast first if any
                const existingToast = document.querySelector('.toast-notification');
                if (existingToast) {
                    existingToast.remove();
                }

                const toast = document.createElement('div');
                toast.className = `alert alert-${type === 'success' ? 'success' : 'error'} toast-notification`;
                toast.style.position = 'fixed';
                toast.style.top = '24px';
                toast.style.right = '24px';
                toast.style.zIndex = '9999';
                toast.style.minWidth = '320px';
                toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
                toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-xmark'}"></i> <span style="flex-grow: 1;">${message}</span>`;
                
                const closeBtn = document.createElement('button');
                closeBtn.innerHTML = '&times;';
                closeBtn.style.background = 'none';
                closeBtn.style.border = 'none';
                closeBtn.style.fontSize = '1.3rem';
                closeBtn.style.cursor = 'pointer';
                closeBtn.style.marginLeft = 'auto';
                closeBtn.style.color = 'inherit';
                closeBtn.style.paddingLeft = '12px';
                closeBtn.addEventListener('click', () => toast.remove());
                toast.appendChild(closeBtn);
                
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.4s ease';
                    setTimeout(() => toast.remove(), 400);
                }, 3000);
            }

            // Listen to invalid input events to show a floating notification
            let lastInvalidNoticeTime = 0;
            document.addEventListener('invalid', function(e) {
                const now = Date.now();
                if (now - lastInvalidNoticeTime > 1000) {
                    lastInvalidNoticeTime = now;
                    showToast('Mohon lengkapi semua kolom yang wajib diisi!', 'error');
                }
            }, true);

            // Delegate photo deletion click handlers
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-delete-photo');
                if (btn) {
                    e.preventDefault();
                    const modelName = btn.getAttribute('data-model');
                    const modelId = btn.getAttribute('data-id');
                    const photoPath = btn.getAttribute('data-photo');
                    const wrapper = btn.closest('.gallery-photo-wrapper');
                    
                    if (confirm('Apakah Anda yakin ingin menghapus foto ini dari galeri?')) {
                        fetch('{{ route("admin.gallery.delete-photo") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                model: modelName,
                                id: modelId,
                                photo: photoPath
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                wrapper.style.transition = 'all 0.3s ease';
                                wrapper.style.opacity = '0';
                                wrapper.style.transform = 'scale(0.8)';
                                setTimeout(() => {
                                    wrapper.remove();
                                    const container = wrapper.parentElement;
                                    if (container && container.querySelectorAll('.gallery-photo-wrapper').length === 0) {
                                        location.reload();
                                    }
                                }, 300);
                                showToast('Foto berhasil dihapus dari galeri.', 'success');
                            } else {
                                showToast(data.message || 'Gagal menghapus foto.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting photo:', error);
                            showToast('Terjadi kesalahan koneksi.', 'error');
                        });
                    }
                }
            });

            // --- SIDEBAR SUBMENU ACCORDION ---
            const submenuToggles = document.querySelectorAll('.submenu-toggle');
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    const isOpen = parent.classList.contains('active-parent');
                    
                    // Close other submenus first to keep it neat
                    document.querySelectorAll('.has-submenu').forEach(item => {
                        item.classList.remove('active-parent');
                    });
                    
                    if (!isOpen) {
                        parent.classList.add('active-parent');
                    }
                });
            });

            // --- SIDEBAR TOGGLE ---
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const toggleIcon = document.getElementById('sidebar-toggle-icon');

            function updateToggleIcon() {
                if (document.body.classList.contains('sidebar-collapsed')) {
                    toggleIcon.className = 'fa-solid fa-bars';
                    toggleBtn.title = 'Tampilkan Sidebar';
                } else {
                    toggleIcon.className = 'fa-solid fa-bars';
                    toggleBtn.title = 'Sembunyikan Sidebar';
                }
            }

            // Load saved state from localStorage
            if (localStorage.getItem('adminSidebarCollapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
            }
            updateToggleIcon();

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    document.body.classList.toggle('sidebar-collapsed');
                    const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                    localStorage.setItem('adminSidebarCollapsed', isCollapsed);
                    updateToggleIcon();
                });
            }

            // Auto-expand parents of active submenu items on load
            document.querySelectorAll('.submenu a.active').forEach(activeLink => {
                const parent = activeLink.closest('.has-submenu');
                if (parent) {
                    parent.classList.add('active-parent');
                }
            });
        });
    </script>
</body>
</html>
