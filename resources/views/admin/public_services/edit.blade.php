@extends('admin.layouts.admin')

@section('title', 'Edit Layanan Publik')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Panduan Layanan Publik: {{ $public_service->title }}</h2>
        <a href="{{ route('admin.public-services.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.public-services.update', $public_service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Nama Layanan *</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $public_service->title) }}" required>
        </div>

        <div class="form-group">
            <label for="icon">Ikon (FontAwesome Class) <small style="color: var(--text-muted); font-weight: normal;">(Opsional)</small></label>
            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $public_service->icon) }}">
            <span style="font-size: 0.85rem; color: var(--text-muted);">Contoh: fa-solid fa-file-lines</span>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Singkat</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $public_service->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="requirements">Persyaratan / Alur (Bisa copy-paste teks berformat)</label>
            <textarea name="requirements" id="requirements" class="form-control" rows="8">{{ old('requirements', $public_service->requirements) }}</textarea>
        </div>

        <div class="form-group">
            <label for="document_file">File Formulir/Dokumen Pendukung Baru <small style="color: var(--text-muted); font-weight: normal;">(Format: PDF/DOC/DOCX. Biarkan kosong jika tidak ingin mengubah file saat ini)</small></label>
            @if($public_service->document_file)
                <div style="margin-bottom: 10px; font-size: 0.9rem;">
                    File saat ini: <a href="{{ asset($public_service->document_file) }}" target="_blank" style="color: var(--primary-light); font-weight: 600;">Lihat File</a>
                </div>
            @endif
            <input type="file" name="document_file" id="document_file" class="form-control" accept=".pdf,.doc,.docx">
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 15px; margin-top: 30px;">
            <label style="margin-bottom: 0;">Status Aktif</label>
            <label class="switch">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $public_service->is_active) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 20px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
