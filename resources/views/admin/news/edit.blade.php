@extends('admin.layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Sunting Berita</h2>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Berita</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul berita" value="{{ old('title', $news->title) }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori Berita</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="content">Isi Berita</label>
            <textarea id="content" name="content" class="form-control" placeholder="Tuliskan detail berita di sini..." required style="min-height: 250px;">{{ old('content', $news->content) }}</textarea>
        </div>

        <div class="form-group">
            <label for="featured_image">Gambar Cover (Featured Image)</label>
            @if($news->featured_image)
                <div style="margin-bottom: 12px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Cover saat ini:</span>
                    <img src="{{ asset($news->featured_image) }}" alt="Cover Current" style="width: 180px; height: 120px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                </div>
            @endif
            <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Unggah gambar baru jika ingin menggantinya. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Penerbitan</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                <label class="switch">
                    <input type="hidden" name="status" id="status-input" value="{{ old('status', $news->status) }}">
                    <input type="checkbox" id="status-toggle" {{ old('status', $news->status) === 'published' ? 'checked' : '' }} onchange="document.getElementById('status-input').value = this.checked ? 'published' : 'draft'">
                    <span class="slider"></span>
                </label>
                <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
