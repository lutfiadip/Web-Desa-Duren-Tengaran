@extends('admin.layouts.admin')

@section('title', 'Tambah Peraturan Desa')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2>Tambah Peraturan Baru</h2>
        <a href="{{ route('admin.regulations.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.regulations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Judul/Tentang Peraturan</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan perihal atau judul peraturan" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori Peraturan</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="number">Nomor Peraturan</label>
                <input type="text" id="number" name="number" class="form-control" placeholder="Contoh: 03" value="{{ old('number') }}" required>
            </div>

            <div class="form-group">
                <label for="year">Tahun Penetapan</label>
                <input type="number" id="year" name="year" class="form-control" placeholder="Contoh: {{ date('Y') }}" value="{{ old('year', date('Y')) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Singkat / Penjelasan</label>
            <textarea id="description" name="description" class="form-control" placeholder="Tuliskan ringkasan singkat dari peraturan ini (opsional)">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="document_file">Berkas Dokumen (PDF, Word, Zip)</label>
            <input type="file" id="document_file" name="document_file" class="form-control" accept=".pdf,.doc,.docx,.zip" required>
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal ukuran file: 5MB.</span>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Terbitkan (Published)</option>
            </select>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Regulasi
            </button>
            <a href="{{ route('admin.regulations.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
