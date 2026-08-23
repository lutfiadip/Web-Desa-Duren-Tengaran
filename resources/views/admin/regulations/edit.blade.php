@extends('admin.layouts.admin')

@section('title', 'Edit Peraturan Desa')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2>Sunting Peraturan</h2>
        <a href="{{ route('admin.regulations.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.regulations.update', $regulation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul/Tentang Peraturan</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan perihal peraturan" value="{{ old('title', $regulation->title) }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori Peraturan</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $regulation->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="number">Nomor Peraturan</label>
                <input type="text" id="number" name="number" class="form-control" placeholder="Masukkan nomor peraturan..." value="{{ old('number', $regulation->number) }}" required>
            </div>

            <div class="form-group">
                <label for="year">Tahun Penetapan</label>
                <input type="number" id="year" name="year" class="form-control" placeholder="Masukkan {{ date }}..." value="{{ old('year', $regulation->year) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Singkat / Penjelasan</label>
            <textarea id="description" name="description" class="form-control" placeholder="Tuliskan ringkasan singkat dari peraturan ini (opsional)">{{ old('description', $regulation->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="document_file">Berkas Dokumen (PDF, Word, Zip)</label>
            @if($regulation->document_file)
                <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Berkas saat ini:</span>
                    <a href="{{ asset($regulation->document_file) }}" target="_blank" class="btn btn-secondary" style="padding: 5px 12px; font-size: 0.8rem;">
                        <i class="fa-solid fa-file-pdf" style="color: #ef4444; margin-right: 5px;"></i> Lihat File
                    </a>
                </div>
            @endif
            <input type="file" id="document_file" name="document_file" class="form-control" accept=".pdf,.doc,.docx,.zip">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Unggah berkas baru untuk mengganti file lama. Maksimal 5MB.</span>
        </div>

        <div class="form-group">
            <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Publikasi</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                <label class="switch">
                    <input type="hidden" name="status" id="status-input" value="{{ old('status', $regulation->status) }}">
                    <input type="checkbox" id="status-toggle" {{ old('status', $regulation->status) === 'published' ? 'checked' : '' }} onchange="document.getElementById('status-input').value = this.checked ? 'published' : 'draft'">
                    <span class="slider"></span>
                </label>
                <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.regulations.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
