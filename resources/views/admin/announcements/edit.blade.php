@extends('admin.layouts.admin')

@section('title', 'Edit Pengumuman')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor .note-editing-area { font-family: 'Plus Jakarta Sans', sans-serif; }
    .note-editor.note-frame { border-radius: var(--radius-md); border-color: var(--border-color); }
</style>
@endsection

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h2>Edit Pengumuman Desa</h2>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Pengumuman <span style="color: red;">*</span></label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul pengumuman..." value="{{ old('title', $announcement->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Isi Pengumuman <span style="color: red;">*</span></label>
            <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" placeholder="Tuliskan isi pengumuman..." required style="min-height: 250px;">{{ old('content', $announcement->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="document_file">Berkas Lampiran Dokumen (Opsional)</label>
            
            @if($announcement->document_file)
                <div id="document-preview-wrapper" style="position: relative; display: flex; align-items: center; gap: 15px; margin-bottom: 12px; padding: 12px; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                    <button type="button" onclick="markDocumentDeleted()" style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border: none; width: 20px; height: 20px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.15); z-index: 10;" title="Hapus Berkas">
                        <i class="fa-solid fa-xmark" style="font-size: 0.75rem;"></i>
                    </button>
                    <div style="font-size: 1.5rem; color: #ef4444;"><i class="fa-solid fa-file-pdf"></i></div>
                    <div style="flex-grow: 1;">
                        <div style="font-weight: 700; font-size: 0.9rem;">Berkas Terlampir</div>
                        <a href="{{ asset($announcement->document_file) }}" target="_blank" style="font-size: 0.8rem; color: var(--primary-light); text-decoration: none;">Lihat Berkas Saat Ini</a>
                    </div>
                    <input type="hidden" name="delete_document" id="delete_document_input" value="0">
                </div>
            @endif

            <input type="file" id="document_file" name="document_file" class="form-control @error('document_file') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.png,.jpg,.jpeg">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format file: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR, PNG, JPG. Maksimal 5MB. Unggah untuk mengganti berkas yang lama.</span>
            @error('document_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="expired_at">Tanggal Kedaluwarsa (Masa Berlaku Opsional)</label>
            <input type="date" id="expired_at" name="expired_at" class="form-control @error('expired_at') is-invalid @enderror" value="{{ old('expired_at', $announcement->expired_at ? $announcement->expired_at->format('Y-m-d') : '') }}">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Kosongkan jika pengumuman berlaku selamanya. Pengumuman otomatis disembunyikan dari publik setelah tanggal ini lewat.</span>
            @error('expired_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Tampilkan sebagai Alert / Banner Darurat</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Tidak</span>
                    <label class="switch">
                        <input type="hidden" name="is_alert" id="is_alert-input" value="{{ old('is_alert', $announcement->is_alert ? '1' : '0') }}">
                        <input type="checkbox" id="is_alert-toggle" {{ old('is_alert', $announcement->is_alert) ? 'checked' : '' }} onchange="document.getElementById('is_alert-input').value = this.checked ? '1' : '0'">
                        <span class="slider"></span>
                    </label>
                    <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Ya</span>
                </div>
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Jika aktif, pengumuman akan berjalan di pita running text paling atas website.</span>
            </div>

            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Keaktifan</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Nonaktif</span>
                    <label class="switch">
                        <input type="hidden" name="is_active" id="is_active-input" value="{{ old('is_active', $announcement->is_active ? '1' : '0') }}">
                        <input type="checkbox" id="is_active-toggle" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }} onchange="document.getElementById('is_active-input').value = this.checked ? '1' : '0'">
                        <span class="slider"></span>
                    </label>
                    <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Aktif</span>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            placeholder: 'Tuliskan isi pengumuman...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    function markDocumentDeleted() {
        if(confirm('Apakah Anda yakin ingin menghapus berkas dokumen lampiran ini?')) {
            document.getElementById('delete_document_input').value = '1';
            document.getElementById('document-preview-wrapper').style.display = 'none';
        }
    }
</script>
@endsection
