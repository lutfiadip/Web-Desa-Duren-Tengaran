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
                    placeholder="Masukkan nama layanan...">
            </div>

            <div class="form-group">
                <label for="icon">Ikon (FontAwesome Class) <small
                        style="color: var(--text-muted); font-weight: normal;">(Opsional)</small></label>
                <input type="text" name="icon" id="icon" class="form-control"
                    value="{{ old('icon', 'fa-solid fa-file-lines') }}" placeholder="Masukkan kelas ikon FontAwesome...">
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
                    placeholder="Masukkan catatan atau persyaratan layanan...">{{ old('disclaimer') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="processing_time">Waktu Penyelesaian</label>
                    <input type="text" name="processing_time" id="processing_time" class="form-control"
                        value="{{ old('processing_time') }}" placeholder="Masukkan 1 Hari Kerja...">
                </div>

                <div class="form-group">
                    <label for="service_cost">Biaya Layanan</label>
                    <input type="text" name="service_cost" id="service_cost" class="form-control"
                        value="{{ old('service_cost') }}" placeholder="Masukkan gratis...">
                </div>
            </div>

            <div class="form-group" style="margin-top: 25px;">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Dokumen / Formulir Layanan <small style="color: var(--text-muted); font-weight: normal;">(Format: PDF/DOC/DOCX, Maks: 10MB)</small></label>
                <div id="documents-container" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 15px;">
                    <div class="document-row" style="display: flex; gap: 15px; align-items: flex-start; background: #f8fafc; padding: 15px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        <div style="flex: 2;">
                            <label style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; display: block;">Nama Dokumen</label>
                            <input type="text" name="document_titles[]" class="form-control" placeholder="Contoh: Formulir Permohonan KK (F-1.01)">
                        </div>
                        <div style="flex: 3;">
                            <label style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; display: block;">Pilih File Dokumen</label>
                            <input type="file" name="document_files[]" class="form-control" accept=".pdf,.doc,.docx">
                        </div>
                        <button type="button" class="btn btn-danger btn-remove-doc" style="margin-top: 24px; padding: 10px; border-radius: var(--radius-md); height: 42px; display: flex; align-items: center; justify-content: center; background-color: #ef4444; border-color: #ef4444; color: #fff; cursor: pointer; display: none;">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
                <button type="button" id="btn-add-doc" class="btn btn-secondary" style="font-size: 0.9rem; font-weight: 700; padding: 8px 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; background-color: #f1f5f9; border-color: #cbd5e1; color: var(--text-dark);">
                    <i class="fa-solid fa-plus"></i> Tambah Dokumen Lain
                </button>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('documents-container');
        const btnAdd = document.getElementById('btn-add-doc');

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.document-row');
            rows.forEach((row, index) => {
                const btnRemove = row.querySelector('.btn-remove-doc');
                if (rows.length === 1) {
                    btnRemove.style.display = 'none';
                    row.querySelectorAll('input').forEach(input => {
                        input.removeAttribute('required');
                    });
                } else {
                    btnRemove.style.display = 'flex';
                    row.querySelectorAll('input').forEach(input => {
                        input.setAttribute('required', 'required');
                    });
                }
            });
        }

        updateRemoveButtons();

        btnAdd.addEventListener('click', function () {
            const newRow = container.querySelector('.document-row').cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => {
                input.value = '';
                input.setAttribute('required', 'required');
            });
            container.appendChild(newRow);
            updateRemoveButtons();
        });

        container.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-doc')) {
                const row = e.target.closest('.document-row');
                row.remove();
                updateRemoveButtons();
            }
        });
    });
</script>
@endsection