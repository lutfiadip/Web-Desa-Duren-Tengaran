@extends('admin.layouts.admin')

@section('title', 'Tambah Foto Galeri')

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
            <li>
                <a href="{{ route('admin.gallery.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Galeri Desa
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Tambah Foto</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header">
            <h2>Tambah Foto Galeri Baru</h2>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary" style="text-decoration: none;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" style="padding: 20px;">
            @csrf

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="image">File Foto Galeri</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB. Direkomendasikan rasio landscape (misalnya 4:3 atau 16:9).</span>
                @error('image')
                    <span style="color: #ef4444; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 30px;">
                <label for="caption">Keterangan / Caption Foto</label>
                <input type="text" id="caption" name="caption" class="form-control" placeholder="Contoh: Pemandangan Sawah di Dusun Miri" value="{{ old('caption') }}">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Keterangan singkat tentang isi foto yang akan ditampilkan di halaman beranda.</span>
                @error('caption')
                    <span style="color: #ef4444; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; cursor: pointer;">
                    <i class="fa-solid fa-circle-check"></i> Simpan Foto
                </button>
            </div>
        </form>
    </div>
@endsection
