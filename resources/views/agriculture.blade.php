@extends('layouts.app')

@section('title', 'Potensi Pertanian & Peternakan - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .agri-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
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
        z-index: 2;
    }

    .com-featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: rgba(245, 158, 11, 0.9);
        backdrop-filter: blur(4px);
        color: var(--white);
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
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
    /* --- SEARCH BAR --- */
    .search-filter-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
    }

    .search-box-wrapper {
        position: relative;
        width: 100%;
    }

    .search-btn {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.2rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        outline: none;
        transition: var(--transition);
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-btn:hover {
        color: var(--primary);
        transform: translateY(-50%) scale(1.15);
    }

    .search-input {
        width: 100%;
        padding: 16px 55px 16px 20px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        background-color: var(--bg-main);
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 500;
        transition: var(--transition);
        outline: none;
    }

    .search-input:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="agri-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Pertanian & Peternakan</span>
        </nav>
        <h1>{{ $agriProfile->title ?? 'Pertanian & Perkebunan' }}</h1>
        <p>{{ $profile->agriculture_page_description ?? 'Potensi dan komoditas unggulan sektor pertanian dan perkebunan Desa Duren.' }}</p>
    </section>

    <!-- CONTENT -->
    <div class="agri-container">
        
        <!-- SEARCH BAR -->
        <div class="search-filter-card">
            <div class="search-box-wrapper">
                <button type="button" id="search-btn" class="search-btn" title="Cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" id="search-input" class="search-input" placeholder="Cari komoditas pertanian/peternakan atau kelompok tani...">
            </div>
        </div>
        
        @if($agriProfile && ($agriProfile->description_1 || $agriProfile->description_2))
        <!-- PROFIL UMUM -->
        <div class="agri-section">
            <div class="agri-card">
                <h2 class="agri-section-title"><i class="fa-solid fa-seedling"></i> Profil Sektor Agraris Desa</h2>
                @if($agriProfile->description_1)
                    <p class="agri-desc-text">{{ $agriProfile->description_1 }}</p>
                @endif
                @if($agriProfile->description_2)
                    <p class="agri-desc-text">{{ $agriProfile->description_2 }}</p>
                @endif
            </div>
        </div>
        @endif

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
                    @forelse($commodities as $com)
                        <div class="com-card" data-title="{{ strtolower($com->title) }}" data-desc="{{ strtolower(strip_tags($com->description)) }}" data-category="{{ strtolower($com->category) }}">
                            <div class="com-img-wrapper">
                                <span class="com-badge">{{ $com->category }}</span>
                                @if($com->is_featured)
                                    <span class="com-featured-badge"><i class="fa-solid fa-star"></i> Unggulan</span>
                                @endif
                                <img src="{{ $com->thumbnail ? (Str::startsWith($com->thumbnail, 'http') ? $com->thumbnail : asset($com->thumbnail)) : 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" alt="{{ $com->title }}" class="com-img">
                            </div>
                            <div class="com-body">
                                <h3 class="com-title">{{ $com->title }}</h3>
                                <p class="com-desc">{{ Str::limit(strip_tags($com->description), 150) }}</p>
                                <a href="{{ route('potensi.agriculture.detail', $com->slug) }}" class="com-link">Lihat Detail Komoditas <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; grid-column: 1 / -1; color: var(--text-muted); padding: 30px; background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border-color);">Data komoditas belum tersedia.</div>
                    @endforelse
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
                                <tr class="farmer-group-row" data-name="{{ strtolower($group->name) }}" data-sector="{{ strtolower($group->sector) }}" data-dusun="{{ strtolower($group->dusun) }}">
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

    <!-- FILTER SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchBtn = document.getElementById('search-btn');
            
            const comGrid = document.querySelector('.com-grid');
            const comCards = comGrid ? comGrid.querySelectorAll('.com-card') : [];
            
            const tableBody = document.querySelector('.gapoktan-table tbody');
            const tableRows = tableBody ? tableBody.querySelectorAll('.farmer-group-row') : [];
            
            // Create empty state elements
            const createEmptyState = (message) => {
                const div = document.createElement('div');
                div.className = 'search-empty-state';
                div.style.gridColumn = '1 / -1';
                div.style.display = 'none';
                div.style.textAlign = 'center';
                div.style.padding = '30px';
                div.style.background = 'var(--white)';
                div.style.borderRadius = 'var(--radius-lg)';
                div.style.border = '1px solid var(--border-color)';
                div.style.color = 'var(--text-muted)';
                div.innerHTML = `
                    <i class="fa-solid fa-magnifying-glass-minus" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                    <h3>Komoditas Tidak Ditemukan</h3>
                    <p>${message}</p>
                `;
                return div;
            };

            const createTableEmptyRow = () => {
                const tr = document.createElement('tr');
                tr.className = 'table-empty-row';
                tr.style.display = 'none';
                tr.innerHTML = `
                    <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">
                        <i class="fa-solid fa-magnifying-glass-minus" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 10px; opacity: 0.6;"></i>
                        <div>Tidak ada kelompok tani yang cocok dengan pencarian.</div>
                    </td>
                `;
                return tr;
            };

            let comEmpty, tableEmpty;
            if (comGrid && comCards.length > 0) {
                comEmpty = createEmptyState('Maaf, komoditas yang Anda cari tidak dapat ditemukan.');
                comGrid.appendChild(comEmpty);
            }
            if (tableBody && tableRows.length > 0) {
                tableEmpty = createTableEmptyRow();
                tableBody.appendChild(tableEmpty);
            }

            function filterItems() {
                const query = searchInput.value.toLowerCase().trim();
                
                // Filter commodities
                let comMatches = 0;
                comCards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const desc = card.getAttribute('data-desc') || '';
                    const category = card.getAttribute('data-category') || '';
                    if (title.includes(query) || desc.includes(query) || category.includes(query)) {
                        card.style.display = 'flex';
                        comMatches++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                if (comEmpty) {
                    comEmpty.style.display = (comMatches === 0 && comCards.length > 0) ? 'block' : 'none';
                }

                // Filter farmer groups
                let groupMatches = 0;
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const sector = row.getAttribute('data-sector') || '';
                    const dusun = row.getAttribute('data-dusun') || '';
                    if (name.includes(query) || sector.includes(query) || dusun.includes(query)) {
                        row.style.display = '';
                        groupMatches++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                if (tableEmpty) {
                    tableEmpty.style.display = (groupMatches === 0 && tableRows.length > 0) ? '' : 'none';
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterItems);
            }
            if (searchBtn && searchInput) {
                searchBtn.addEventListener('click', function() {
                    filterItems();
                    searchInput.focus();
                });
            }
        });
    </script>
@endsection
