@extends('admin.layouts.admin')

@section('title', 'Edit UMKM')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Sunting Data UMKM</h2>
        <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="title">Nama Usaha (UMKM)</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Keripik Tempe Miri" value="{{ old('title', $umkm->title) }}" required>
            </div>

            <div class="form-group">
                <label for="owner_name">Nama Pemilik/Pengelola</label>
                <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Contoh: Ibu Ngatmini" value="{{ old('owner_name', $umkm->owner_name) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category_id">Kategori Usaha</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $umkm->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="whatsapp">No. WhatsApp Pemilik (Gunakan format 62...)</label>
                <input type="text" id="whatsapp" name="whatsapp" class="form-control" placeholder="Contoh: 628571234567" value="{{ old('whatsapp', $umkm->whatsapp) }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="instagram">Username Instagram (Opsional)</label>
                <input type="text" id="instagram" name="instagram" class="form-control" placeholder="Contoh: @kulinertempe" value="{{ old('instagram', $umkm->instagram) }}">
            </div>

            <div class="form-group">
                <label for="facebook">Nama Halaman Facebook (Opsional)</label>
                <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Contoh: Tempe Ngatmini Duren" value="{{ old('facebook', $umkm->facebook) }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="operating_hours">Jam Operasional Usaha</label>
                <input type="text" id="operating_hours" name="operating_hours" class="form-control" placeholder="Contoh: Setiap Hari (08.00 - 17.00 WIB)" value="{{ old('operating_hours', $umkm->operating_hours) }}">
            </div>

            <div class="form-group">
                <label for="google_maps_url">Link Google Maps Lokasi Usaha (Opsional)</label>
                <input type="url" id="google_maps_url" name="google_maps_url" class="form-control" placeholder="Contoh: https://maps.google.com/..." value="{{ old('google_maps_url', $umkm->google_maps_url) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Usaha & Produk</label>
            <textarea id="description" name="description" class="form-control" placeholder="Jelaskan produk..." required style="min-height: 120px;">{{ old('description', $umkm->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Alamat Lengkap Usaha</label>
            <input type="text" id="address" name="address" class="form-control" placeholder="Contoh: Dusun Miri RT 02/RW 04, Desa Duren" value="{{ old('address', $umkm->address) }}" required>
        </div>

        <div class="form-group">
            <label for="thumbnail">Gambar Utama / Foto Produk (Thumbnail)</label>
            @if($umkm->thumbnail)
                <div style="margin-bottom: 12px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Thumbnail saat ini:</span>
                    <img src="{{ asset($umkm->thumbnail) }}" alt="Thumbnail Current" style="width: 150px; height: 100px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                </div>
            @endif
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2MB. Kosongkan jika tidak ingin mengubah.</span>
        </div>

        <div class="form-group">
            <label for="gallery_files">Foto Galeri Produk Tambahan (Opsional)</label>
            @if(is_array($umkm->gallery) && count($umkm->gallery) > 0)
                <div style="margin-bottom: 15px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Galeri foto saat ini:</span>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        @foreach($umkm->gallery as $imgUrl)
                            <div class="gallery-photo-wrapper">
                                <img src="{{ asset($imgUrl) }}" alt="Galeri" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                                <button type="button" class="btn-delete-photo" data-model="umkm" data-id="{{ $umkm->id }}" data-photo="{{ $imgUrl }}" title="Hapus Foto"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        @endforeach
                    </div>
                    <label style="margin-top: 10px; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; color: #b91c1c; cursor: pointer;">
                        <input type="checkbox" name="replace_gallery" value="1"> Hapus semua galeri lama sebelum mengunggah galeri baru
                    </label>
                </div>
            @endif
            <input type="file" id="gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal 2MB per gambar.</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="is_featured">Apakah Produk Unggulan?</label>
                <select id="is_featured" name="is_featured" class="form-control" required>
                    <option value="0" {{ old('is_featured', $umkm->is_featured) == '0' ? 'selected' : '' }}>Bukan Unggulan (Tampil Biasa)</option>
                    <option value="1" {{ old('is_featured', $umkm->is_featured) == '1' ? 'selected' : '' }}>Ya, Jadikan Unggulan (Tampil di Beranda/Sorotan)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status Penerbitan</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="draft" {{ old('status', $umkm->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $umkm->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
