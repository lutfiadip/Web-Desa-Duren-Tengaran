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
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Wahyudi, S.M." value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="position">Jabatan</label>
            <input type="text" id="position" name="position" class="form-control" placeholder="Contoh: Sekretaris Desa" value="{{ old('position') }}" required>
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
            <label for="nip">NIP (Nomor Induk Pegawai)</label>
            <input type="text" id="nip" name="nip" class="form-control" placeholder="Isi '-' jika tidak ada NIP" value="{{ old('nip') }}">
        </div>

        <div class="form-group">
            <label for="photo">Foto Profil Perangkat</label>
            <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label for="status">Status Keaktifan</label>
            <select id="status" name="status" class="form-control" required>
                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif menjabat</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Non-Aktif/Pensiun</option>
            </select>
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
