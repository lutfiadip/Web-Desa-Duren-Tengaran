@extends('admin.layouts.admin')

@section('title', 'Tambah Kebudayaan Baru')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Tambah Kebudayaan/Seni Baru</h2>
        <a href="{{ route('admin.culture.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.culture.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Nama Seni / Upacara / Kebudayaan</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan nama kebudayaan..." value="{{ old('title') }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="location">Tempat/Lokasi Penyelenggaraan</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="Masukkan nama sanggar atau lokasi..." value="{{ old('location') }}" required>
            </div>

            <div class="form-group">
                <label for="contact">Narahubung / Kontak (Opsional)</label>
                <input type="text" id="contact" name="contact" class="form-control" placeholder="Masukkan nomor kontak..." value="{{ old('contact') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="implementation_time">Waktu Penyelenggaraan / Rutinitas Pentas</label>
            <input type="text" id="implementation_time" name="implementation_time" class="form-control" placeholder="Masukkan waktu pelaksanaan kegiatan..." value="{{ old('implementation_time') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Lengkap Kebudayaan</label>
            <textarea id="description" name="description" class="form-control" placeholder="Tuliskan latar belakang sejarah, ciri khas gerakan, alat musik, atau makna tarian..." required style="min-height: 150px;">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="thumbnail">Gambar Utama / Foto Pentas (Thumbnail)</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*" required>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label for="gallery_files">Foto Galeri Kebudayaan Tambahan (Opsional)</label>
            <input type="file" id="gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Apakah Kebudayaan Unggulan?</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Bukan Unggulan</span>
                    <label class="switch">
                        <input type="hidden" name="is_featured" id="featured-input" value="{{ old('is_featured', '0') }}">
                        <input type="checkbox" id="featured-toggle" {{ old('is_featured') == '1' ? 'checked' : '' }} onchange="document.getElementById('featured-input').value = this.checked ? '1' : '0'">
                        <span class="slider"></span>
                    </label>
                    <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Ya, Jadikan Unggulan</span>
                </div>
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
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Kebudayaan
            </button>
            <a href="{{ route('admin.culture.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
