@extends('layouts.app')

@section('title', 'Peraturan Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .regulations-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('https://images.unsplash.com/photo-1450133064473-71024230f91b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .regulations-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .regulations-hero p {
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
    .regulations-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    /* --- FILTERS --- */
    .filter-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 25px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        margin-bottom: 40px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        background-color: var(--bg-main);
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 500;
        transition: var(--transition);
        outline: none;
    }

    .form-control:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* --- REGULATIONS TABLE --- */
    .table-container {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .reg-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .reg-table th {
        background-color: var(--bg-main);
        color: var(--text-dark);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 18px 24px;
        border-bottom: 2px solid var(--border-color);
    }

    .reg-table td {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        vertical-align: middle;
    }

    .reg-table tr:last-child td {
        border-bottom: none;
    }

    .reg-table tr:hover td {
        background-color: rgba(37, 99, 235, 0.01);
    }

    .badge-year {
        display: inline-block;
        padding: 4px 10px;
        background-color: var(--bg-main);
        border: 1px solid var(--border-color);
        color: var(--text-dark);
        font-weight: 700;
        font-size: 0.8rem;
        border-radius: 4px;
    }

    .badge-category {
        display: inline-block;
        padding: 4px 12px;
        background-color: rgba(37, 99, 235, 0.08);
        color: var(--primary);
        font-weight: 700;
        font-size: 0.8rem;
        border-radius: var(--radius-pill);
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background-color: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-download:hover {
        background-color: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
    }

    .no-results i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .no-results h3 {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .no-results p {
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.6;
    }

    @media (max-width: 992px) {
        .filter-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }
</style>
@endsection

@section('content')

    <!-- HERO SECTION -->
    <section class="regulations-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Peraturan Desa</span>
        </nav>
        <h1>Peraturan Desa</h1>
        <p>Portal resmi dokumen hukum dan produk regulasi yang diterbitkan oleh Pemerintah Desa Duren.</p>
    </section>

    <!-- CONTENT SECTION -->
    <div class="regulations-container">
        
        <!-- FILTER CARD -->
        <div class="filter-card">
            <div class="filter-grid">
                <!-- Search -->
                <div class="form-group">
                    <label for="search-input">Cari Regulasi</label>
                    <input type="text" id="search-input" class="form-control" placeholder="Tulis judul atau nomor peraturan...">
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category-filter">Kategori</label>
                    <select id="category-filter" class="form-control">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year -->
                <div class="form-group">
                    <label for="year-filter">Tahun</label>
                    <select id="year-filter" class="form-control">
                        <option value="all">Semua Tahun</option>
                        @php
                            $years = $regulations->pluck('year')->unique()->sortDesc();
                        @endphp
                        @foreach($years as $yr)
                            <option value="{{ $yr }}">{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- REGULATIONS TABLE -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="reg-table" id="regulations-table">
                    <thead>
                        <tr>
                            <th style="width: 150px;">Nomor & Tahun</th>
                            <th>Judul Peraturan</th>
                            <th style="width: 250px;">Kategori</th>
                            <th>Keterangan</th>
                            <th style="width: 150px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($regulations as $reg)
                            <tr class="regulation-row" 
                                data-title="{{ strtolower($reg->title) }}" 
                                data-number="{{ strtolower($reg->number) }}"
                                data-category="{{ $reg->category->name ?? '' }}" 
                                data-year="{{ $reg->year }}">
                                <td>
                                    <div style="font-weight: 700; color: var(--text-dark);">No. {{ $reg->number }}</div>
                                    <span class="badge-year">{{ $reg->year }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: var(--text-dark); font-size: 1.05rem; margin-bottom: 5px;">{{ $reg->title }}</div>
                                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; font-weight: 500;">
                                        <i class="fa-regular fa-calendar-check" style="margin-right: 5px;"></i> Diterbitkan: {{ \Carbon\Carbon::parse($reg->published_at)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-category">{{ $reg->category->name ?? 'Peraturan' }}</span>
                                </td>
                                <td style="font-size: 0.9rem;">
                                    {{ $reg->description ?? '-' }}
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn-download" onclick="alert('File dokumen &quot;{{ $reg->title }}&quot; sedang dalam proses pengunggahan ke server. Silakan hubungi sekretariat kantor desa jika membutuhkan salinan fisik.')">
                                        <i class="fa-solid fa-file-pdf" style="font-size: 1.1rem; color: #ef4444;"></i> Unduh PDF
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-table-row">
                                <td colspan="5">
                                    <div class="no-results">
                                        <i class="fa-solid fa-folder-open"></i>
                                        <h3>Belum Ada Dokumen Peraturan</h3>
                                        <p>Pemerintah desa belum menerbitkan produk peraturan di portal online ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <!-- Client-side No Match Row -->
                        <tr id="no-match-row" style="display: none;">
                            <td colspan="5">
                                <div class="no-results">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <h3>Tidak Ada Peraturan Cocok</h3>
                                    <p>Silakan periksa kata kunci pencarian atau ganti pilihan filter kategori/tahun Anda.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- CLIENT FILTER JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const categoryFilter = document.getElementById('category-filter');
            const yearFilter = document.getElementById('year-filter');
            const rows = document.querySelectorAll('.regulation-row');
            const noMatchRow = document.getElementById('no-match-row');
            const emptyTableRow = document.getElementById('empty-table-row');

            function filterTable() {
                const query = searchInput.value.toLowerCase().trim();
                const selectedCat = categoryFilter.value;
                const selectedYear = yearFilter.value;
                
                let matchesCount = 0;

                rows.forEach(row => {
                    const title = row.getAttribute('data-title');
                    const number = row.getAttribute('data-number');
                    const category = row.getAttribute('data-category');
                    const year = row.getAttribute('data-year');

                    const matchesSearch = title.includes(query) || number.includes(query);
                    const matchesCategory = (selectedCat === 'all' || category === selectedCat);
                    const matchesYear = (selectedYear === 'all' || year === selectedYear);

                    if (matchesSearch && matchesCategory && matchesYear) {
                        row.style.display = '';
                        matchesCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Handle Empty matches alert
                if (rows.length > 0) {
                    if (matchesCount === 0) {
                        noMatchRow.style.display = '';
                    } else {
                        noMatchRow.style.display = 'none';
                    }
                }
            }

            if (searchInput) searchInput.addEventListener('input', filterTable);
            if (categoryFilter) categoryFilter.addEventListener('change', filterTable);
            if (yearFilter) yearFilter.addEventListener('change', filterTable);
        });
    </script>

@endsection
