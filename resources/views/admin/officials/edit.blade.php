@extends('admin.layouts.admin')

@section('title', 'Edit Perangkat Desa')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2>Sunting Perangkat Desa</h2>
        <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.officials.update', $official->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Lengkap & Gelar</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Wahyudi, S.M." value="{{ old('name', $official->name) }}" required>
        </div>

        <div class="form-group">
            <label for="position">Jabatan</label>
            <input type="text" id="position" name="position" class="form-control" placeholder="Contoh: Sekretaris Desa" value="{{ old('position', $official->position) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category_id">Kategori Perangkat</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $official->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="parent_id">Atasan Langsung (Opsional)</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="">-- Tidak Ada Atasan --</option>
                    @foreach($parentOfficials as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $official->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }} ({{ $parent->position }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="nip">NIP (Nomor Induk Pegawai)</label>
                <input type="text" id="nip" name="nip" class="form-control" placeholder="Isi '-' jika tidak ada NIP" value="{{ old('nip', $official->nip) }}">
            </div>

            <div class="form-group">
                <label for="sort_order">Urutan Tampilan</label>
                <input type="number" id="sort_order" name="sort_order" class="form-control" placeholder="Contoh: 1" value="{{ old('sort_order', $official->sort_order) }}" required>
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Urutan kecil tampil lebih awal.</span>
            </div>
        </div>

        <div class="form-group">
            <label for="photo">Foto Profil Perangkat</label>
            @if($official->photo)
                <div style="margin-bottom: 12px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Foto saat ini:</span>
                    <img src="{{ asset($official->photo) }}" alt="Foto Current" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border-color);">
                </div>
            @endif
            <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Unggah foto baru untuk mengganti foto lama. Maksimal 2MB.</span>
        </div>

        <div class="form-group">
            <label for="status">Status Keaktifan</label>
            <select id="status" name="status" class="form-control" required>
                <option value="1" {{ old('status', $official->status) == '1' ? 'selected' : '' }}>Aktif menjabat</option>
                <option value="0" {{ old('status', $official->status) == '0' ? 'selected' : '' }}>Non-Aktif/Pensiun</option>
            </select>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
