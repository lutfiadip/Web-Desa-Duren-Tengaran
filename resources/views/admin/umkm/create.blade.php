@extends('admin.layouts.admin')

@section('title', 'Tambah UMKM Baru')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Daftarkan UMKM Baru</h2>
        <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="title">Nama Usaha (UMKM)</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Keripik Tempe Miri" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="owner_name">Nama Pemilik/Pengelola</label>
                <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Contoh: Ibu Ngatmini" value="{{ old('owner_name') }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category_id">Kategori Usaha</label>
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
                <label for="whatsapp">No. WhatsApp Pemilik (Untuk Hubungi Pembeli)</label>
                <input type="text" id="whatsapp" name="whatsapp" class="form-control" placeholder="Contoh: 628571234567 (gunakan format 62...)" value="{{ old('whatsapp') }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="instagram">Username Instagram (Opsional)</label>
                <input type="text" id="instagram" name="instagram" class="form-control" placeholder="Contoh: @kulinertempe" value="{{ old('instagram') }}">
            </div>

            <div class="form-group">
                <label for="facebook">Nama Halaman Facebook (Opsional)</label>
                <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Contoh: Tempe Ngatmini Duren" value="{{ old('facebook') }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="operating_hours">Jam Operasional Usaha</label>
                <input type="text" id="operating_hours" name="operating_hours" class="form-control" placeholder="Contoh: Setiap Hari (08.00 - 17.00 WIB)" value="{{ old('operating_hours') }}">
            </div>

            <div class="form-group">
                <label for="google_maps_url">Link Google Maps Lokasi Usaha (Opsional)</label>
                <input type="url" id="google_maps_url" name="google_maps_url" class="form-control" placeholder="Contoh: https://maps.google.com/..." value="{{ old('google_maps_url') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Usaha & Produk</label>
            <textarea id="description" name="description" class="form-control" placeholder="Jelaskan produk yang dijual, keunikan, bahan, atau harga..." required style="min-height: 120px;">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Alamat Lengkap Usaha</label>
            <input type="text" id="address" name="address" class="form-control" placeholder="Contoh: Dusun Miri RT 02/RW 04, Desa Duren" value="{{ old('address') }}" required>
        </div>

        <div class="form-group">
            <label for="thumbnail">Gambar Utama / Foto Produk (Thumbnail)</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*" required>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label for="gallery_files">Foto Galeri Produk Tambahan (Opsional, Bisa pilih beberapa sekaligus)</label>
            <input type="file" id="gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Bisa pilih beberapa gambar sekaligus. Maksimal 2MB per gambar.</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Apakah Produk Unggulan?</label>
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
                <i class="fa-solid fa-floppy-disk"></i> Simpan UMKM
            </button>
            <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
