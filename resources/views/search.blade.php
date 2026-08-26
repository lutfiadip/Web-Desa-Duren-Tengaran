@extends('layouts.app')

@section('title', 'Pencarian Global | ' . ($profile->name ?? 'Desa'))

@section('styles')
<style>
    /* Search Page Specific Styles */
    .search-header {
        padding: 180px 5% 80px;
        background: linear-gradient(135deg, var(--primary) 0%, #1e3a8a 100%);
        color: var(--white);
        text-align: center;
        position: relative;
    }

    .search-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: var(--bg-main);
        clip-path: polygon(0 100%, 100% 100%, 100% 0);
    }

    .search-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }

    .search-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 300;
        margin-bottom: 25px;
    }

    .back-home-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: rgba(255, 255, 255, 0.15);
        color: var(--white);
        border-radius: var(--radius-pill);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
    }

    .back-home-btn:hover {
        background: var(--white);
        color: var(--primary);
        transform: translateY(-2px);
    }

    .search-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 5%;
        min-height: 50vh;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid var(--border-color);
    }

    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 25px;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 1.1rem;
    }

    .results-summary {
        font-size: 1.1rem;
        color: var(--text-muted);
        margin-bottom: 40px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--border-color);
    }

    .category-section {
        margin-bottom: 60px;
    }

    .category-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .category-title i {
        color: var(--accent);
    }

    .search-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .search-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 25px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .search-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--primary);
    }

    .search-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .search-card-title a {
        color: var(--text-dark);
        text-decoration: none;
        transition: color 0.2s;
    }

    .search-card:hover .search-card-title a {
        color: var(--primary);
    }

    .search-card-desc {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 20px;
        flex-grow: 1;
        line-height: 1.6;
    }

    .search-card-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--accent);
        font-weight: 600;
        text-decoration: none;
        font-size: 0.95rem;
        transition: var(--transition);
        margin-top: auto;
    }

    .search-card-link:hover {
        color: var(--accent-hover);
        gap: 12px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="search-header">
    <h1 class="search-title">Hasil Pencarian</h1>
    @if(!empty($query))
        <p class="search-subtitle">Menampilkan hasil untuk: <strong>"{{ $query }}"</strong></p>
    @else
        <p class="search-subtitle">Silakan masukkan kata kunci pencarian.</p>
    @endif
    <a href="{{ route('home') }}" class="back-home-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
    </a>
</div>

<div class="search-container">
    @if(empty($query))
        <div class="empty-state">
            <i class="fa-solid fa-magnifying-glass"></i>
            <h3>Mulai Pencarian</h3>
            <p>Gunakan ikon pencarian di sudut kanan atas untuk mencari informasi.</p>
        </div>
    @else
        @php
            $totalResults = collect($results)->flatten(1)->count();
        @endphp

        @if($totalResults == 0)
            <div class="empty-state">
                <i class="fa-solid fa-box-open"></i>
                <h3>Tidak ada hasil ditemukan</h3>
                <p>Maaf, kami tidak menemukan informasi yang sesuai dengan kata kunci "{{ $query }}".</p>
            </div>
        @else
            <div class="results-summary">
                <strong>Ditemukan {{ $totalResults }} hasil pencarian</strong> di berbagai kategori.
            </div>

            <!-- Berita -->
            @if($results['news']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-regular fa-newspaper"></i> Berita & Artikel
                    </h3>
                    <div class="search-grid">
                        @foreach($results['news'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title"><a href="{{ route('news.detail', $item->slug) }}">{{ $item->title }}</a></h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                            <a href="{{ route('news.detail', $item->slug) }}" class="search-card-link">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- UMKM -->
            @if($results['umkm']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-store"></i> Produk UMKM
                    </h3>
                    <div class="search-grid">
                        @foreach($results['umkm'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title"><a href="{{ route('umkm.detail', $item->slug) }}">{{ $item->title }}</a></h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ route('umkm.detail', $item->slug) }}" class="search-card-link">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tourism -->
            @if($results['tourism']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-map-location-dot"></i> Potensi Wisata
                    </h3>
                    <div class="search-grid">
                        @foreach($results['tourism'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title"><a href="{{ route('tourism.detail', $item->slug) }}">{{ $item->title }}</a></h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ route('tourism.detail', $item->slug) }}" class="search-card-link">Lihat Destinasi <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Cultures -->
            @if($results['cultures']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-masks-theater"></i> Seni & Budaya
                    </h3>
                    <div class="search-grid">
                        @foreach($results['cultures'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title"><a href="{{ route('culture.detail', $item->slug) }}">{{ $item->title }}</a></h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ route('culture.detail', $item->slug) }}" class="search-card-link">Kenali Budaya <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Public Services -->
            @if($results['public_services']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-file-signature"></i> Layanan Publik
                    </h3>
                    <div class="search-grid">
                        @foreach($results['public_services'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title"><a href="{{ route('public_services.detail', $item->slug) }}">{{ $item->title }}</a></h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ route('public_services.detail', $item->slug) }}" class="search-card-link">Lihat Layanan <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Regulations -->
            @if($results['regulations']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-gavel"></i> Peraturan Desa
                    </h3>
                    <div class="search-grid">
                        @foreach($results['regulations'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title">
                                <a href="{{ route('regulations') }}">
                                    {{ $item->title }} (No. {{ $item->number }} Tahun {{ $item->year }})
                                </a>
                            </h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ route('regulations') }}" class="search-card-link">Lihat Regulasi <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Perangkat Desa -->
            @if($results['officials']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-user-tie"></i> Perangkat Desa
                    </h3>
                    <div class="search-grid">
                        @foreach($results['officials'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title">
                                <a href="{{ route('officials') }}">
                                    {{ $item->name }}
                                </a>
                            </h5>
                            <p class="search-card-desc" style="font-weight: 600; color: var(--primary);">Jabatan: {{ $item->position }}</p>
                            @if($item->nip)
                                <p class="search-card-desc" style="margin-top: -15px; font-size: 0.85rem;">NIP: {{ $item->nip }}</p>
                            @endif
                            <a href="{{ route('officials') }}" class="search-card-link">Lihat Perangkat Desa <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Lembaga & Organisasi -->
            @if($results['institutions']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-users"></i> Lembaga & Organisasi Desa
                    </h3>
                    <div class="search-grid">
                        @foreach($results['institutions'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title">
                                @php
                                    $isOrg = str_contains(strtolower($item->category->name ?? ''), 'organisasi');
                                    $detailRoute = $isOrg ? route('organization.detail', $item->slug) : route('institution.detail', $item->slug);
                                @endphp
                                <a href="{{ $detailRoute }}">
                                    {{ $item->name }}
                                </a>
                            </h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ $detailRoute }}" class="search-card-link">Lihat Detail Kelembagaan <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Pertanian & Peternakan -->
            @if($results['commodities']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-seedling"></i> Potensi Pertanian & Peternakan
                    </h3>
                    <div class="search-grid">
                        @foreach($results['commodities'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title">
                                <a href="{{ route('potensi.agriculture') }}">
                                    {{ $item->title }}
                                </a>
                            </h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->description), 120) }}</p>
                            <a href="{{ route('potensi.agriculture') }}" class="search-card-link">Lihat Komoditas <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Pengumuman -->
            @if($results['announcements']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-bullhorn"></i> Pengumuman Terbaru
                    </h3>
                    <div class="search-grid">
                        @foreach($results['announcements'] as $item)
                        <div class="search-card">
                            <h5 class="search-card-title">
                                <a href="{{ route('announcements.detail', $item->slug) }}">
                                    {{ $item->title }}
                                </a>
                            </h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                            <a href="{{ route('announcements.detail', $item->slug) }}" class="search-card-link">Baca Pengumuman <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Galeri -->
            @if($results['galleries']->count() > 0)
                <div class="category-section">
                    <h3 class="category-title">
                        <i class="fa-solid fa-images"></i> Galeri Kegiatan
                    </h3>
                    <div class="search-grid">
                        @foreach($results['galleries'] as $item)
                        <div class="search-card">
                            @if($item->image)
                                <div style="width: 100%; height: 150px; background: url('{{ asset($item->image) }}') center/cover no-repeat; border-radius: var(--radius-md); margin-bottom: 15px;"></div>
                            @endif
                            <h5 class="search-card-title">
                                <a href="{{ route('gallery') }}">
                                    Galeri Foto
                                </a>
                            </h5>
                            <p class="search-card-desc">{{ Str::limit(strip_tags($item->caption), 120) }}</p>
                            <a href="{{ route('gallery') }}" class="search-card-link">Buka Galeri <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @endif
    @endif
</div>
@endsection
