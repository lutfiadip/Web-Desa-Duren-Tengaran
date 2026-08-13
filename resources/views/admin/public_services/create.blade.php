@extends('admin.layouts.admin')

@section('title', 'Tambah Layanan Publik')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Tambah Panduan Layanan Publik</h2>
            <a href="{{ route('admin.public-services.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.public-services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Nama Layanan *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required
                    placeholder="Contoh: Pembuatan KTP Baru">
            </div>

            <div class="form-group">
                <label for="icon">Ikon (FontAwesome Class) <small
                        style="color: var(--text-muted); font-weight: normal;">(Opsional)</small></label>
                <input type="text" name="icon" id="icon" class="form-control"
                    value="{{ old('icon', 'fa-solid fa-file-lines') }}" placeholder="Contoh: fa-solid fa-file-lines">
                <span style="font-size: 0.85rem; color: var(--text-muted);">Cari referensi ikon di <a
                        href="https://fontawesome.com/search?o=r&m=free" target="_blank"
                        style="color: var(--primary-light);">FontAwesome Free</a></span>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Singkat</label>
                <textarea name="description" id="description" class="form-control" rows="3"
                    placeholder="Jelaskan secara singkat mengenai layanan ini.">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="requirements">Persyaratan (Gunakan enter untuk memisahkan poin)</label>
                <textarea name="requirements" id="requirements" class="form-control" rows="5"
                    placeholder="1. Fotokopi KK&#10;2. Pengantar RT/RW&#10;3. Pas Foto 3x4...">{{ old('requirements') }}</textarea>
            </div>

            <div class="form-group">
                <label for="service_flow">Alur Layanan (Gunakan enter untuk memisahkan poin)</label>
                <textarea name="service_flow" id="service_flow" class="form-control" rows="5"
                    placeholder="1. Datang ke Balai Desa&#10;2. Menyerahkan Berkas&#10;3. Proses Cetak...">{{ old('service_flow') }}</textarea>
            </div>

            <div class="form-group">
                <label for="disclaimer">Catatan Penting <small
                        style="color: var(--text-muted); font-weight: normal;">(Opsional)</small></label>
                <textarea name="disclaimer" id="disclaimer" class="form-control" rows="3"
                    placeholder="Contoh: Pastikan semua dokumen dibawa dalam bentuk asli dan fotokopi...">{{ old('disclaimer') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="processing_time">Waktu Penyelesaian</label>
                    <input type="text" name="processing_time" id="processing_time" class="form-control"
                        value="{{ old('processing_time') }}" placeholder="Contoh: 1 Hari Kerja">
                </div>

                <div class="form-group">
                    <label for="service_cost">Biaya Layanan</label>
                    <input type="text" name="service_cost" id="service_cost" class="form-control"
                        value="{{ old('service_cost') }}" placeholder="Contoh: Gratis">
                </div>
            </div>

            <div class="form-group">
                <label for="document_file">Dokumen Pendukung <small
                        style="color: var(--text-muted); font-weight: normal;">(Format: PDF/DOC/DOCX, Maks:
                        10MB)</small></label>
                <input type="file" name="document_file" id="document_file" class="form-control" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 15px; margin-top: 30px;">
                <label style="margin-bottom: 0;">Status Aktif</label>
                <label class="switch">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                    <i class="fa-solid fa-save"></i> Simpan Layanan
                </button>
            </div>
        </form>
    </div>
@endsection