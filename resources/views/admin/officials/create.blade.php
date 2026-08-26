@extends('admin.layouts.admin')

@section('title', 'Tambah Perangkat Desa')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2>Tambah Perangkat Desa Baru</h2>
        <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.officials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap & Gelar</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama lengkap..." value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="position">Jabatan</label>
            <input type="text" id="position" name="position" class="form-control" placeholder="Masukkan nama jabatan..." value="{{ old('position') }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori Perangkat</label>
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
            <label for="photo">Foto Profil Perangkat</label>
            <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Keaktifan</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Non-Aktif</span>
                <label class="switch">
                    <input type="hidden" name="status" id="status-input" value="{{ old('status', '1') }}">
                    <input type="checkbox" id="status-toggle" {{ old('status', '1') == '1' ? 'checked' : '' }} onchange="document.getElementById('status-input').value = this.checked ? '1' : '0'">
                    <span class="slider"></span>
                </label>
                <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Aktif</span>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perangkat
            </button>
            <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
