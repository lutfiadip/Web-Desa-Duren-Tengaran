@extends('admin.layouts.admin')

@section('title', 'Edit Kebudayaan Desa')

@section('content')
    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h2>Sunting Kebudayaan/Seni</h2>
            <a href="{{ route('admin.culture.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.culture.update', $culture->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Nama Seni / Upacara / Kebudayaan</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan seni Tari..."
                    value="{{ old('title', $culture->title) }}" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="location">Tempat/Lokasi Penyelenggaraan</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Masukkan sanggar Seni..."
                        value="{{ old('location', $culture->location) }}" required>
                </div>

                <div class="form-group">
                    <label for="contact">Narahubung / Kontak</label>
                    <input type="text" id="contact" name="contact" class="form-control" placeholder="Masukkan 0812-9876-5432..."
                        value="{{ old('contact', $culture->contact) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="implementation_time">Waktu Penyelenggaraan / Rutinitas Pentas</label>
                <input type="text" id="implementation_time" name="implementation_time" class="form-control"
                    placeholder="Masukkan dipentaskan saat upacara adat Merti Dusun atau HUT RI..."
                    value="{{ old('implementation_time', $culture->implementation_time) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Lengkap Kebudayaan</label>
                <textarea id="description" name="description" class="form-control" placeholder="Tuliskan latar belakang..."
                    required style="min-height: 150px;">{{ old('description', $culture->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="thumbnail">Gambar Utama (Thumbnail)</label>
                @if($culture->thumbnail)
                    <div style="margin-bottom: 12px;">
                        <span
                            style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Thumbnail
                            saat ini:</span>
                        <img src="{{ asset($culture->thumbnail) }}" alt="Thumbnail Current"
                            style="width: 180px; height: 120px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file:
                    JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
            </div>

            <div class="form-group">
                <label for="gallery_files">Foto Galeri Kebudayaan</label>
                @if(is_array($culture->gallery) && count($culture->gallery) > 0)
                    <div style="margin-bottom: 15px;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Galeri
                            saat ini:</span>
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            @foreach($culture->gallery as $imgUrl)
                                <div class="gallery-photo-wrapper">
                                    <img src="{{ asset($imgUrl) }}" alt="Galeri"
                                        style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                                    <button type="button" class="btn-delete-photo" data-model="culture" data-id="{{ $culture->id }}"
                                        data-photo="{{ $imgUrl }}" title="Hapus Foto"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <label
                            style="margin-top: 10px; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; color: #b91c1c; cursor: pointer;">
                            <input type="checkbox" name="replace_gallery" value="1"> Hapus semua galeri lama sebelum mengunggah
                            galeri baru
                        </label>
                    </div>
                @endif
                <input type="file" id="gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Apakah
                        Kebudayaan Unggulan?</label>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Bukan Unggulan</span>
                        <label class="switch">
                            <input type="hidden" name="is_featured" id="featured-input"
                                value="{{ old('is_featured', $culture->is_featured) }}">
                            <input type="checkbox" id="featured-toggle" {{ old('is_featured', $culture->is_featured) == '1' ? 'checked' : '' }}
                                onchange="document.getElementById('featured-input').value = this.checked ? '1' : '0'">
                            <span class="slider"></span>
                        </label>
                        <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Ya, Jadikan
                            Unggulan</span>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status
                        Penerbitan</label>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                        <label class="switch">
                            <input type="hidden" name="status" id="status-input"
                                value="{{ old('status', $culture->status) }}">
                            <input type="checkbox" id="status-toggle" {{ old('status', $culture->status) === 'published' ? 'checked' : '' }}
                                onchange="document.getElementById('status-input').value = this.checked ? 'published' : 'draft'">
                            <span class="slider"></span>
                        </label>
                        <span
                            style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.culture.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection