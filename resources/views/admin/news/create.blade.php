@extends('admin.layouts.admin')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Tulis Berita Baru</h2>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Judul Berita</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul berita yang menarik" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori Berita</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="content">Isi Berita</label>
            <textarea id="content" name="content" class="form-control" placeholder="Tuliskan detail berita di sini..." required style="min-height: 250px;">{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="featured_image">Gambar Cover (Featured Image)</label>
            <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Penerbitan</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                <label class="switch">
                    <input type="hidden" name="status" id="status-input" value="{{ old('status', 'draft') }}">
                    <input type="checkbox" id="status-toggle" {{ old('status') === 'published' ? 'checked' : '' }} onchange="document.getElementById('status-input').value = this.checked ? 'published' : 'draft'">
                    <span class="slider"></span>
                </label>
                <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Berita
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
