@extends('admin.layouts.admin')

@section('title', 'Edit Tempat Wisata')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Sunting Tempat Wisata</h2>
        <a href="{{ route('admin.tourism.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.tourism.update', $tourism->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Nama Tempat Wisata</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Kali Kulon Desa Duren" value="{{ old('title', $tourism->title) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="ticket_price">Harga Tiket Masuk (IDR / Rupiah)</label>
                <input type="number" id="ticket_price" name="ticket_price" class="form-control" placeholder="Contoh: 15000" value="{{ old('ticket_price', $tourism->ticket_price) }}" required>
            </div>

            <div class="form-group">
                <label for="contact">Narahubung / Kontak Pengelola</label>
                <input type="text" id="contact" name="contact" class="form-control" placeholder="Contoh: 0857-1234-5678" value="{{ old('contact', $tourism->contact) }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="operating_hours">Jam Operasional Wisata</label>
                <input type="text" id="operating_hours" name="operating_hours" class="form-control" placeholder="Contoh: Setiap Hari" value="{{ old('operating_hours', $tourism->operating_hours) }}">
            </div>

            <div class="form-group">
                <label for="google_maps_url">Link Google Maps Lokasi Wisata</label>
                <input type="url" id="google_maps_url" name="google_maps_url" class="form-control" placeholder="Contoh: https://maps.google.com/..." value="{{ old('google_maps_url', $tourism->google_maps_url) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="facilities">Fasilitas Wisata (Pisahkan dengan koma)</label>
            <input type="text" id="facilities" name="facilities" class="form-control" placeholder="Contoh: Gazebo, Kamar Mandi" value="{{ old('facilities', $tourism->facilities) }}">
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Lengkap Wisata</label>
            <textarea id="description" name="description" class="form-control" placeholder="Jelaskan daya tarik..." required style="min-height: 150px;">{{ old('description', $tourism->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Alamat Lokasi Wisata</label>
            <input type="text" id="address" name="address" class="form-control" placeholder="Contoh: Dusun Krajan RT 01/RW 03, Desa Duren" value="{{ old('address', $tourism->address) }}" required>
        </div>

        <div class="form-group">
            <label for="thumbnail">Gambar Utama / Banner (Thumbnail)</label>
            @if($tourism->thumbnail)
                <div style="margin-bottom: 12px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Banner saat ini:</span>
                    <img src="{{ asset($tourism->thumbnail) }}" alt="Banner Current" style="width: 180px; height: 120px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                </div>
            @endif
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label for="gallery_files">Foto Galeri Wisata Tambahan (Opsional)</label>
            @if(is_array($tourism->gallery) && count($tourism->gallery) > 0)
                <div style="margin-bottom: 15px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Galeri saat ini:</span>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @foreach($tourism->gallery as $imgUrl)
                            <img src="{{ asset($imgUrl) }}" alt="Galeri" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                        @endforeach
                    </div>
                    <label style="margin-top: 10px; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; color: #b91c1c; cursor: pointer;">
                        <input type="checkbox" name="replace_gallery" value="1"> Hapus semua galeri lama sebelum mengunggah galeri baru
                    </label>
                </div>
            @endif
            <input type="file" id="gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="is_featured">Apakah Wisata Unggulan?</label>
                <select id="is_featured" name="is_featured" class="form-control" required>
                    <option value="0" {{ old('is_featured', $tourism->is_featured) == '0' ? 'selected' : '' }}>Bukan Unggulan</option>
                    <option value="1" {{ old('is_featured', $tourism->is_featured) == '1' ? 'selected' : '' }}>Ya, Jadikan Unggulan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status Penerbitan</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="draft" {{ old('status', $tourism->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $tourism->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.tourism.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
