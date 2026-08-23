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

        <form action="{{ route('admin.public-services.update', $public_service) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Nama Layanan *</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $public_service->title) }}" required>
            </div>

            <div class="form-group">
                <label for="icon">Ikon (FontAwesome Class) <small
                        style="color: var(--text-muted); font-weight: normal;">(Opsional)</small></label>
                <input type="text" name="icon" id="icon" class="form-control"
                    value="{{ old('icon', $public_service->icon) }}">
                <span style="font-size: 0.85rem; color: var(--text-muted);">Contoh: fa-solid fa-file-lines</span>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Singkat</label>
                <textarea name="description" id="description" class="form-control"
                    rows="3">{{ old('description', $public_service->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="requirements">Persyaratan (Gunakan enter untuk memisahkan poin)</label>
                <textarea name="requirements" id="requirements" class="form-control"
                    rows="5">{{ old('requirements', $public_service->requirements) }}</textarea>
            </div>

            <div class="form-group">
                <label for="service_flow">Alur Layanan (Gunakan enter untuk memisahkan poin)</label>
                <textarea name="service_flow" id="service_flow" class="form-control"
                    rows="5">{{ old('service_flow', $public_service->service_flow) }}</textarea>
            </div>

            <div class="form-group">
                <label for="disclaimer">Catatan Penting <small
                        style="color: var(--text-muted); font-weight: normal;">(Opsional)</small></label>
                <textarea name="disclaimer" id="disclaimer" class="form-control"
                    rows="3">{{ old('disclaimer', $public_service->disclaimer) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="processing_time">Waktu Penyelesaian</label>
                    <input type="text" name="processing_time" id="processing_time" class="form-control"
                        value="{{ old('processing_time', $public_service->processing_time) }}"
                        placeholder="Masukkan waktu penyelesaian...">
                </div>

                <div class="form-group">
                    <label for="service_cost">Biaya Layanan</label>
                    <input type="text" name="service_cost" id="service_cost" class="form-control"
                        value="{{ old('service_cost', $public_service->service_cost) }}" placeholder="Masukkan biaya atau tarif...">
                </div>
            </div>

            <!-- Kelola Dokumen Pendukung -->
            <div class="form-group" style="margin-top: 25px;">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 12px; display: block;">Dokumen / Formulir Layanan <small style="color: var(--text-muted); font-weight: normal;">(Format: PDF/DOC/DOCX, Maks: 10MB)</small></label>

                <!-- Daftar Dokumen Saat Ini -->
                @if($public_service->documents->isNotEmpty())
                    <div style="margin-bottom: 20px;">
                        <label style="font-size: 0.9rem; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; display: block;">Daftar Dokumen Saat Ini</label>
                        <div id="delete-documents-container"></div>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            @foreach($public_service->documents as $doc)
                                <div class="existing-document-row" style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 12px 15px; border-radius: var(--radius-md); border: 1px solid var(--border-color); gap: 15px;">
                                    <div style="flex: 1; display: flex; align-items: center; gap: 10px;">
                                        <i class="fa-solid fa-file-lines" style="color: var(--primary-light); font-size: 1.2rem;"></i>
                                        <input type="text" name="existing_document_titles[{{ $doc->id }}]" class="form-control" value="{{ $doc->title }}" placeholder="Nama Dokumen" style="flex: 1;" required>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-secondary" style="font-size: 0.85rem; padding: 6px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; background-color: #f1f5f9; border-color: #cbd5e1; color: var(--text-dark);">
                                            <i class="fa-solid fa-eye"></i> Lihat File
                                        </a>
                                        <button type="button" class="btn btn-danger btn-delete-existing-doc" data-doc-id="{{ $doc->id }}" style="padding: 10px; border-radius: var(--radius-md); height: 38px; display: flex; align-items: center; justify-content: center; background-color: #ef4444; border-color: #ef4444; color: #fff; cursor: pointer;" title="Hapus Dokumen">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tambah Dokumen Baru -->
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 0.9rem; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; display: block;">Tambah Dokumen Baru</label>
                    <div id="new-documents-container" style="display: flex; flex-direction: column; gap: 12px;">
                        <!-- Will be populated dynamically via JavaScript -->
                    </div>
                </div>

                <button type="button" id="btn-add-doc" class="btn btn-secondary" style="font-size: 0.9rem; font-weight: 700; padding: 8px 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; background-color: #f1f5f9; border-color: #cbd5e1; color: var(--text-dark);">
                    <i class="fa-solid fa-plus"></i> Tambah Baris Dokumen
                </button>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('new-documents-container');
        const btnAdd = document.getElementById('btn-add-doc');

        btnAdd.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.className = 'document-row';
            newRow.style.cssText = 'display: flex; gap: 15px; align-items: flex-start; background: #fffbeb; padding: 15px; border-radius: var(--radius-md); border: 1px solid #fef3c7;';
            newRow.innerHTML = `
                <div style="flex: 2;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; display: block;">Nama Dokumen</label>
                    <input type="text" name="document_titles[]" class="form-control" placeholder="Masukkan nama dokumen..." required>
                </div>
                <div style="flex: 3;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; display: block;">Pilih File Dokumen</label>
                    <input type="file" name="document_files[]" class="form-control" accept=".pdf,.doc,.docx" required>
                </div>
                <button type="button" class="btn btn-danger btn-remove-doc" style="margin-top: 24px; padding: 10px; border-radius: var(--radius-md); height: 42px; display: flex; align-items: center; justify-content: center; background-color: #ef4444; border-color: #ef4444; color: #fff; cursor: pointer;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `;
            container.appendChild(newRow);
        });

        container.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-doc')) {
                const row = e.target.closest('.document-row');
                row.remove();
            }
        });

        // Handle deletion of existing documents
        document.querySelectorAll('.btn-delete-existing-doc').forEach(button => {
            button.addEventListener('click', function () {
                if (confirm('Apakah Anda yakin ingin menghapus dokumen ini secara permanen setelah perubahan disimpan?')) {
                    const docId = this.getAttribute('data-doc-id');
                    const row = this.closest('.existing-document-row');
                    
                    // Add hidden input to form
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_documents[]';
                    input.value = docId;
                    document.getElementById('delete-documents-container').appendChild(input);
                    
                    // Remove row from DOM
                    row.remove();
                }
            });
        });
    });
</script>
@endsection