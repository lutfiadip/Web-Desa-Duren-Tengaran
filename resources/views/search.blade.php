@extends('layouts.app')

@section('title', 'Pencarian Global | ' . ($profile->name ?? 'Desa'))

@section('content')
<!-- Page Header -->
<div class="page-header" style="padding: 150px 0 50px; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: var(--white); text-align: center;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 20px;">Hasil Pencarian</h1>
        @if(!empty($query))
            <p class="page-subtitle" style="font-size: 1.2rem; opacity: 0.9;">Menampilkan hasil untuk: <strong>"{{ $query }}"</strong></p>
        @else
            <p class="page-subtitle" style="font-size: 1.2rem; opacity: 0.9;">Silakan masukkan kata kunci pencarian.</p>
        @endif
    </div>
</div>

<div class="container py-5">
    @if(empty($query))
        <div class="text-center py-5">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 4rem; color: var(--border); margin-bottom: 20px;"></i>
            <h3>Mulai Pencarian</h3>
            <p class="text-muted">Gunakan ikon pencarian di sudut kanan atas untuk mencari informasi.</p>
        </div>
    @else
        @php
            $totalResults = collect($results)->flatten(1)->count();
        @endphp

        @if($totalResults == 0)
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open" style="font-size: 4rem; color: var(--border); margin-bottom: 20px;"></i>
                <h3>Tidak ada hasil ditemukan</h3>
                <p class="text-muted">Maaf, kami tidak menemukan informasi yang sesuai dengan kata kunci "{{ $query }}".</p>
            </div>
        @else
            <p class="mb-5 text-muted">Ditemukan {{ $totalResults }} hasil pencarian di berbagai kategori.</p>

            <!-- Berita -->
            @if($results['news']->count() > 0)
                <div class="search-category mb-5">
                    <h3 class="mb-4" style="border-bottom: 2px solid var(--border); padding-bottom: 10px;">
                        <i class="fa-regular fa-newspaper me-2" style="color: var(--accent);"></i> Berita & Artikel
                    </h3>
                    <div class="row g-4">
                        @foreach($results['news'] as $item)
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); transition: var(--transition);">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('news.detail', $item->slug) }}" style="color: var(--primary); text-decoration: none;">{{ $item->title }}</a></h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('news.detail', $item->slug) }}" class="btn-read-more" style="color: var(--accent); font-weight: 600; text-decoration: none;">Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- UMKM -->
            @if($results['umkm']->count() > 0)
                <div class="search-category mb-5">
                    <h3 class="mb-4" style="border-bottom: 2px solid var(--border); padding-bottom: 10px;">
                        <i class="fa-solid fa-store me-2" style="color: var(--accent);"></i> Produk UMKM
                    </h3>
                    <div class="row g-4">
                        @foreach($results['umkm'] as $item)
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); transition: var(--transition);">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('umkm.detail', $item->slug) }}" style="color: var(--primary); text-decoration: none;">{{ $item->title }}</a></h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit(strip_tags($item->description), 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('umkm.detail', $item->slug) }}" class="btn-read-more" style="color: var(--accent); font-weight: 600; text-decoration: none;">Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tourism -->
            @if($results['tourism']->count() > 0)
                <div class="search-category mb-5">
                    <h3 class="mb-4" style="border-bottom: 2px solid var(--border); padding-bottom: 10px;">
                        <i class="fa-solid fa-map-location-dot me-2" style="color: var(--accent);"></i> Potensi Wisata
                    </h3>
                    <div class="row g-4">
                        @foreach($results['tourism'] as $item)
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); transition: var(--transition);">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('tourism.detail', $item->slug) }}" style="color: var(--primary); text-decoration: none;">{{ $item->name }}</a></h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit(strip_tags($item->description), 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('tourism.detail', $item->slug) }}" class="btn-read-more" style="color: var(--accent); font-weight: 600; text-decoration: none;">Jelajahi <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Cultures -->
            @if($results['cultures']->count() > 0)
                <div class="search-category mb-5">
                    <h3 class="mb-4" style="border-bottom: 2px solid var(--border); padding-bottom: 10px;">
                        <i class="fa-solid fa-masks-theater me-2" style="color: var(--accent);"></i> Seni & Budaya
                    </h3>
                    <div class="row g-4">
                        @foreach($results['cultures'] as $item)
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); transition: var(--transition);">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('culture.detail', $item->slug) }}" style="color: var(--primary); text-decoration: none;">{{ $item->name }}</a></h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit(strip_tags($item->description), 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('culture.detail', $item->slug) }}" class="btn-read-more" style="color: var(--accent); font-weight: 600; text-decoration: none;">Baca Budaya <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Public Services -->
            @if($results['public_services']->count() > 0)
                <div class="search-category mb-5">
                    <h3 class="mb-4" style="border-bottom: 2px solid var(--border); padding-bottom: 10px;">
                        <i class="fa-solid fa-file-signature me-2" style="color: var(--accent);"></i> Layanan Publik
                    </h3>
                    <div class="row g-4">
                        @foreach($results['public_services'] as $item)
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); transition: var(--transition);">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('public_services.detail', $item->slug) }}" style="color: var(--primary); text-decoration: none;">{{ $item->title }}</a></h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit(strip_tags($item->description), 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('public_services.detail', $item->slug) }}" class="btn-read-more" style="color: var(--accent); font-weight: 600; text-decoration: none;">Lihat Persyaratan <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

        @endif
    @endif
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection
