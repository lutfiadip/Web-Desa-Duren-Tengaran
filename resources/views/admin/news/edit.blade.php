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
            <label for="status">Status Penerbitan</label>
            <select id="status" name="status" class="form-control" required>
                <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Terbitkan (Published)</option>
            </select>
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
