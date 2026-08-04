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
            transition: var(--transition);
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
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
                    <i class="fa-solid fa-house-chimney"></i> Profil Desa
                </a>
            </li>
            <li>
                <a href="{{ route('admin.statistics.index') }}" class="{{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Statistik Penduduk
                </a>
            </li>
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
                <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-newspaper"></i> Berita Desa
                </a>
            </li>
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
            <div class="header-title">
                <h1>@yield('title', 'Admin Panel')</h1>
            </div>
            <div class="user-info">
                <div class="user-avatar">AD</div>
                <div style="font-weight: 700; font-size: 0.95rem;">Admin Desa</div>
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
        });
    </script>
</body>
</html>
