@extends('admin.layouts.admin')

@section('title', 'Tambah Tempat Wisata')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Tambah Wisata Baru</h2>
        <a href="{{ route('admin.tourism.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.tourism.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Nama Tempat Wisata</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan nama tempat wisata..." value="{{ old('title') }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="contact">Narahubung / Kontak Pengelola</label>
                <input type="text" id="contact" name="contact" class="form-control" placeholder="Masukkan nomor telepon atau kontak..." value="{{ old('contact') }}">
            </div>

            <div class="form-group">
                <label for="operating_hours">Jam Operasional Wisata</label>
                <input type="text" id="operating_hours" name="operating_hours" class="form-control" placeholder="Masukkan jam operasional..." value="{{ old('operating_hours') }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="google_maps_url">Link Google Maps Lokasi Wisata</label>
                <input type="url" id="google_maps_url" name="google_maps_url" class="form-control" placeholder="Masukkan link Google Maps lokasi..." value="{{ old('google_maps_url') }}">
            </div>

            <div class="form-group">
                <label for="facilities">Fasilitas Wisata (Pisahkan dengan koma)</label>
                <input type="text" id="facilities" name="facilities" class="form-control" placeholder="Masukkan fasilitas (pisahkan dengan koma)..." value="{{ old('facilities') }}">
            </div>
        </div>

        <!-- Harga Tiket / Paket Wisata -->
        <div class="form-group" style="margin-top: 10px; padding: 15px; background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md);">
            <label style="font-weight: 700; color: var(--text-dark); display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span>Harga Tiket / Paket Wisata <span style="color: red;">*</span></span>
                <button type="button" id="btn-add-package" class="btn btn-secondary btn-sm" style="padding: 4px 10px; font-size: 0.8rem; display: flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-plus"></i> Tambah Tiket/Paket
                </button>
            </label>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 15px; margin-top: -5px;">Masukkan daftar harga tiket atau paket wisata (misal: "Tiket Dewasa" Rp 15.000, "Tiket Masuk" harga 0 jika gratis/sukarela). Harus ada minimal 1 baris.</p>
            
            <div id="packages-container" style="display: flex; flex-direction: column; gap: 10px;">
                <!-- Baris paket akan dimasukkan secara dinamis dengan JS -->
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Lengkap Wisata</label>
            <textarea id="description" name="description" class="form-control" placeholder="Jelaskan daya tarik, keunikan, rute, atau imbauan bagi wisatawan..." required style="min-height: 150px;">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Alamat Lokasi Wisata</label>
            <input type="text" id="address" name="address" class="form-control" placeholder="Masukkan alamat lengkap..." value="{{ old('address') }}" required>
        </div>

        <div class="form-group">
            <label for="thumbnail">Gambar Utama / Banner (Thumbnail)</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*" required>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label for="gallery_files">Foto Galeri Wisata Tambahan (Opsional)</label>
            <input type="file" id="gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Bisa memilih beberapa foto sekaligus.</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Apakah Wisata Unggulan?</label>
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
                <i class="fa-solid fa-floppy-disk"></i> Simpan Tempat Wisata
            </button>
            <a href="{{ route('admin.tourism.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    .package-row {
        display: flex;
        gap: 15px;
        align-items: center;
        background: var(--white);
        padding: 10px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('packages-container');
        const btnAdd = document.getElementById('btn-add-package');
        let index = 0;

        function addPackageRow(name = '', price = '') {
            const row = document.createElement('div');
            row.className = 'package-row';
            row.innerHTML = `
                <div style="flex: 2;">
                    <input type="text" name="ticket_packages[${index}][name]" class="form-control" placeholder="Masukkan nama tiket atau paket..." value="${name}" required>
                </div>
                <div style="flex: 1; display: flex; align-items: center; gap: 8px;">
                    <span style="font-weight: 600; color: var(--text-muted);">Rp</span>
                    <input type="number" name="ticket_packages[${index}][price]" class="form-control" placeholder="0 (gratis/sukarela)" value="${price}" required min="0">
                </div>
                <button type="button" class="btn-icon delete btn-remove-package" style="background:none; border:none; cursor:pointer;" title="Hapus Paket">
                    <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i>
                </button>
            `;
            container.appendChild(row);

            row.querySelector('.btn-remove-package').addEventListener('click', function() {
                row.remove();
            });

            index++;
        }

        btnAdd.addEventListener('click', function() {
            addPackageRow();
        });

        // Add initial rows from old input if validation failed, otherwise add one default row
        @if(old('ticket_packages'))
            @foreach(old('ticket_packages') as $pkg)
                addPackageRow('{{ e($pkg['name'] ?? '') }}', '{{ e($pkg['price'] ?? '') }}');
            @endforeach
        @else
            addPackageRow('Tiket Masuk', '0');
        @endif
    });
</script>
@endsection
