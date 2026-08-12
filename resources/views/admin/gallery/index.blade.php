@extends('admin.layouts.admin')

@section('title', 'Kelola Galeri Desa')

@section('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .gallery-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
    }

    .gallery-card-img-wrapper {
        position: relative;
        padding-top: 60%; /* 5:3 Aspect Ratio */
        background-color: #f1f5f9;
        overflow: hidden;
    }

    .gallery-card-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .gallery-card:hover .gallery-card-img {
        transform: scale(1.05);
    }

    .gallery-card-body {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .gallery-caption {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.8em; /* fixed height for alignment */
    }

    .gallery-actions {
        display: flex;
        gap: 10px;
        border-top: 1px solid var(--border-color);
        padding-top: 12px;
        margin-top: auto;
    }

    .gallery-actions .btn {
        flex: 1;
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
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
            <li style="color: var(--text-dark); font-weight: 600;">Galeri Desa</li>
        </ol>
    </nav>



    <div class="card">
        <div class="card-header">
            <h2>Galeri Pesona Desa</h2>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Foto Galeri
            </a>
        </div>

        @if($galleries->isEmpty())
            <div style="text-align: center; padding: 60px 20px; color: var(--text-muted);">
                <i class="fa-regular fa-image" style="font-size: 3rem; margin-bottom: 15px; color: #cbd5e1;"></i>
                <p style="font-size: 1rem; font-weight: 600;">Belum ada foto galeri desa.</p>
                <p style="font-size: 0.85rem; margin-top: 5px;">Silakan tambahkan foto baru untuk ditampilkan di halaman beranda.</p>
            </div>
        @else
            <div class="gallery-grid">
                @foreach($galleries as $gallery)
                    <div class="gallery-card">
                        <div class="gallery-card-img-wrapper">
                            <img src="{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset($gallery->image) }}" alt="{{ $gallery->caption ?? 'Galeri Desa' }}" class="gallery-card-img">
                        </div>
                        <div class="gallery-card-body">
                            <div class="gallery-caption" title="{{ $gallery->caption }}">
                                {{ $gallery->caption ?? 'Tidak ada deskripsi' }}
                            </div>
                            <div class="gallery-actions">
                                <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-secondary" style="border-color: var(--border-color); color: var(--text-dark); text-decoration: none;">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="background-color: #ef4444; border-color: #ef4444; color: #fff; width: 100%; cursor: pointer;">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 30px;">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
@endsection
