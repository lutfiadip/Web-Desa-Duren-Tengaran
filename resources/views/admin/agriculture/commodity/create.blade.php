@extends('admin.layouts.admin')

@section('title', 'Tambah Komoditas Baru')

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
                <a href="{{ route('admin.agriculture.index', ['tab' => 'commodities']) }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Pertanian & Peternakan
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Tambah Komoditas</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-plus-circle" style="color: var(--primary-light);"></i> Tambah Komoditas Baru
            </h2>
            <a href="{{ route('admin.agriculture.index', ['tab' => 'commodities']) }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.agriculture.commodity.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Nama Komoditas <span style="color: red;">*</span></label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan nama komoditas..." required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="category">Kategori <span style="color: red;">*</span></label>
                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Hortikultura" {{ old('category') == 'Hortikultura' ? 'selected' : '' }}>Hortikultura (Sayur & Buah)</option>
                        <option value="Perkebunan" {{ old('category') == 'Perkebunan' ? 'selected' : '' }}>Perkebunan</option>
                        <option value="Peternakan" {{ old('category') == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                        <option value="Kehutanan" {{ old('category') == 'Kehutanan' ? 'selected' : '' }}>Kehutanan</option>
                        <option value="Pangan" {{ old('category') == 'Pangan' ? 'selected' : '' }}>Pangan Utama (Padi, Jagung, dll)</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="thumbnail">Foto / Gambar Sampul <span style="color: red;">*</span></label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" required>
                    <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Format: JPG, JPEG, PNG, WEBP (Maks: 2MB).</span>
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Lengkap <span style="color: red;">*</span></label>
                <textarea name="description" id="description" rows="6" class="form-control @error('description') is-invalid @enderror" placeholder="Tuliskan info lengkap mengenai komoditas ini, potensi hasil panen, cara pengolahan, dll." required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="production_scale">Skala / Volume Produksi</label>
                    <input type="text" name="production_scale" id="production_scale" class="form-control @error('production_scale') is-invalid @enderror" value="{{ old('production_scale') }}" placeholder="Masukkan skala atau volume produksi...">
                    @error('production_scale')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harvest_time">Waktu Panen / Siklus</label>
                    <input type="text" name="harvest_time" id="harvest_time" class="form-control @error('harvest_time') is-invalid @enderror" value="{{ old('harvest_time') }}" placeholder="Masukkan waktu panen atau siklus...">
                    @error('harvest_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="contact">Kontak Penanggung Jawab / Gapoktan</label>
                    <input type="text" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" placeholder="Masukkan nomor kontak...">
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Lokasi Budidaya / Alamat</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Masukkan alamat lokasi budidaya...">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="google_maps_url">Link Google Maps Lokasi</label>
                <input type="url" name="google_maps_url" id="google_maps_url" class="form-control @error('google_maps_url') is-invalid @enderror" value="{{ old('google_maps_url') }}" placeholder="Masukkan link Google Maps lokasi...">
                @error('google_maps_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gallery_files">Galeri Foto Pendukung</label>
                <input type="file" name="gallery_files[]" id="gallery_files" class="form-control @error('gallery_files') is-invalid @enderror" multiple>
                <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Anda dapat memilih lebih dari satu foto sekaligus.</span>
                @error('gallery_files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Publikasi</label>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                        <label class="switch">
                            <input type="checkbox" name="status" value="published" {{ old('status', 'published') == 'published' ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Tandai Sebagai Komoditas Unggulan <span style="color: red;">*</span></label>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                        <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Tidak</span>
                        <label class="switch">
                            <input type="hidden" name="is_featured" id="featured-input" value="{{ old('is_featured', '0') }}">
                            <input type="checkbox" id="featured-toggle" {{ old('is_featured') == '1' ? 'checked' : '' }} onchange="document.getElementById('featured-input').value = this.checked ? '1' : '0'">
                            <span class="slider"></span>
                        </label>
                        <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Ya, Tampilkan sebagai Unggulan</span>
                    </div>
                    @error('is_featured')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan Komoditas
                </button>
            </div>
        </form>
    </div>
@endsection
