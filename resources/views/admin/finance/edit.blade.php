@extends('admin.layouts.admin')

@section('title', 'Sunting Tahun Anggaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Sunting Tahun Anggaran {{ $report->year }}</h2>
        <a href="{{ route('admin.transparency.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.transparency.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div id="deleted-docs-container">
            <!-- Hidden inputs for deleted document IDs will be placed here by JS -->
        </div>

        <div class="form-row" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group">
                <label for="year">Tahun Anggaran</label>
                <input type="number" name="year" id="year" class="form-control" value="{{ $report->year }}" placeholder="Contoh: 2026" required min="2000" max="2100">
            </div>
            <div class="form-group" style="display: flex; align-items: center; margin-top: 25px;">
                <label class="switch" style="margin-right: 12px;">
                    <input type="checkbox" name="is_active" value="1" {{ $report->is_active ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <span style="font-weight: 700; color: var(--text-dark);">Tampilkan di Halaman Publik</span>
            </div>
        </div>

        <h3 style="font-size: 1.1rem; font-weight: 800; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin: 25px 0 15px 0; color: var(--primary);">
            <i class="fa-solid fa-calculator"></i> Ringkasan Nominal APBDes (Angka Utama)
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
            Masukkan target dan realisasi dari 3 sektor utama APBDes. Angka ini akan otomatis dihitung persentasenya dan divisualisasikan dalam bentuk progress bar di halaman publik.
        </p>

        <!-- Sektor Pendapatan -->
        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 20px;">
            <h4 style="font-weight: 700; color: #15803d; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 8px; height: 8px; background: #15803d; border-radius: 50%;"></span> Sektor Pendapatan Desa
            </h4>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div class="form-group">
                    <label for="revenue_target">Target Pendapatan (Rp)</label>
                    <input type="number" name="revenue_target" id="revenue_target" class="form-control" value="{{ (int)$report->revenue_target }}" required min="0">
                </div>
                <div class="form-group">
                    <label for="revenue_realization">Realisasi Pendapatan (Rp)</label>
                    <input type="number" name="revenue_realization" id="revenue_realization" class="form-control" value="{{ (int)$report->revenue_realization }}" required min="0">
                </div>
            </div>
        </div>

        <!-- Sektor Belanja -->
        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 20px;">
            <h4 style="font-weight: 700; color: #b91c1c; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 8px; height: 8px; background: #b91c1c; border-radius: 50%;"></span> Sektor Belanja / Pengeluaran Desa
            </h4>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div class="form-group">
                    <label for="spending_target">Target Belanja (Rp)</label>
                    <input type="number" name="spending_target" id="spending_target" class="form-control" value="{{ (int)$report->spending_target }}" required min="0">
                </div>
                <div class="form-group">
                    <label for="spending_realization">Realisasi Belanja (Rp)</label>
                    <input type="number" name="spending_realization" id="spending_realization" class="form-control" value="{{ (int)$report->spending_realization }}" required min="0">
                </div>
            </div>
        </div>

        <!-- Sektor Pembiayaan -->
        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 20px;">
            <h4 style="font-weight: 700; color: #475569; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 8px; height: 8px; background: #475569; border-radius: 50%;"></span> Sektor Pembiayaan Desa
            </h4>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div class="form-group">
                    <label for="financing_target">Target Pembiayaan (Rp)</label>
                    <input type="number" name="financing_target" id="financing_target" class="form-control" value="{{ (int)$report->financing_target }}" required min="0">
                </div>
                <div class="form-group">
                    <label for="financing_realization">Realisasi Pembiayaan (Rp)</label>
                    <input type="number" name="financing_realization" id="financing_realization" class="form-control" value="{{ (int)$report->financing_realization }}" required min="0">
                </div>
            </div>
        </div>

        <!-- Baliho Poster APBDes -->
        <h3 style="font-size: 1.1rem; font-weight: 800; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin: 25px 0 15px 0; color: var(--primary);">
            <i class="fa-solid fa-image"></i> Poster Infografis Baliho APBDes
        </h3>
        <div class="form-group" style="display: flex; flex-direction: column; gap: 15px;">
            @if($report->apbdes_poster)
                <div style="max-width: 250px; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 10px; background: #fafafa;">
                    <span style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 8px;">Poster Saat Ini:</span>
                    <a href="{{ asset($report->apbdes_poster) }}" target="_blank" style="display: block; border-radius: 4px; overflow: hidden;">
                        <img src="{{ asset($report->apbdes_poster) }}" alt="Poster APBDes" style="width: 100%; height: auto; max-height: 150px; object-fit: contain;">
                    </a>
                </div>
            @endif
            <div>
                <label for="apbdes_poster">Ubah Gambar Baliho APBDes (Poster Laporan)</label>
                <input type="file" name="apbdes_poster" id="apbdes_poster" class="form-control" accept="image/*">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Biarkan kosong jika tidak ingin mengubah poster saat ini.</span>
            </div>
        </div>

        <!-- Documents Section -->
        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin-bottom: 15px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary); margin: 0;">
                    <i class="fa-solid fa-file-pdf"></i> Lampiran Berkas Dokumen PDF
                </h3>
                <button type="button" id="btn-add-document" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.85rem;">
                    <i class="fa-solid fa-plus"></i> Tambah Berkas Baru
                </button>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                Daftar dokumen laporan transparansi yang terunggah untuk tahun anggaran {{ $report->year }}. Warga dapat membaca secara langsung berkas PDF ini secara online.
            </p>

            <!-- Existing Documents -->
            @if($report->documents->count() > 0)
                <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-dark); margin-bottom: 10px;">Dokumen Terunggah:</h4>
                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 25px;">
                    @foreach($report->documents as $doc)
                        <div class="existing-doc-row" data-id="{{ $doc->id }}" style="display: grid; grid-template-columns: 2.2fr 1.5fr 2fr auto; gap: 15px; align-items: flex-end; background: #fff; padding: 12px 15px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                            <div class="form-group" style="margin: 0;">
                                <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">Judul Dokumen</label>
                                <input type="text" name="existing_document_titles[{{ $doc->id }}]" value="{{ $doc->title }}" class="form-control" required>
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">Kategori Halaman / Tab</label>
                                <select name="existing_document_categories[{{ $doc->id }}]" class="form-control" required>
                                    <option value="budget" {{ $doc->category === 'budget' ? 'selected' : '' }}>Anggaran & Realisasi (APBDes)</option>
                                    <option value="development" {{ $doc->category === 'development' ? 'selected' : '' }}>Pembangunan Desa (Proyek Fisik)</option>
                                    <option value="asset" {{ $doc->category === 'asset' ? 'selected' : '' }}>Aset & Inventaris Desa</option>
                                    <option value="report" {{ $doc->category === 'report' ? 'selected' : '' }}>Arsip Dokumen Lainnya</option>
                                </select>
                            </div>
                            <div style="margin: 0; padding-bottom: 10px;">
                                <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat File Saat Ini
                                </a>
                            </div>
                            <button type="button" class="btn btn-danger btn-delete-existing-doc" style="padding: 10px 14px; margin-bottom: 0;">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- New Documents Container -->
            <div id="new-documents-container" style="display: flex; flex-direction: column; gap: 15px;">
                <!-- Container row will be appended here dynamically by JavaScript -->
            </div>
        </div>

        <div style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
            <a href="{{ route('admin.transparency.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('new-documents-container');
    const deletedContainer = document.getElementById('deleted-docs-container');
    const btnAdd = document.getElementById('btn-add-document');
    let indexCounter = 0;

    // Handle delete existing documents on client-side
    document.querySelectorAll('.btn-delete-existing-doc').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('.existing-doc-row');
            const docId = row.getAttribute('data-id');
            
            if (confirm('Apakah Anda yakin ingin menghapus dokumen ini dari daftar? File akan terhapus saat Anda menekan tombol Simpan Perubahan.')) {
                // Append hidden input to track deletion
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_documents[]';
                input.value = docId;
                deletedContainer.appendChild(input);
                
                // Hide row
                row.style.display = 'none';
                // Remove required validations from fields in hidden row
                row.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
            }
        });
    });

    // Handle adding new documents
    function addNewDocumentRow() {
        const row = document.createElement('div');
        row.className = 'document-row';
        row.style = 'display: grid; grid-template-columns: 2fr 1.5fr 2fr auto; gap: 15px; align-items: flex-end; background: #fbfbfb; padding: 15px; border-radius: var(--radius-md); border: 1px dashed var(--border-color);';
        
        row.innerHTML = `
            <div class="form-group" style="margin: 0;">
                <label style="font-size: 0.8rem; font-weight: 700; color: var(--primary-light);">Judul Laporan / Dokumen (Baru)</label>
                <input type="text" name="document_titles[${indexCounter}]" class="form-control" placeholder="Contoh: Dokumen Evaluasi Triwulan II" required>
            </div>
            <div class="form-group" style="margin: 0;">
                <label style="font-size: 0.8rem; font-weight: 700; color: var(--primary-light);">Kategori Halaman / Tab</label>
                <select name="document_categories[${indexCounter}]" class="form-control" required>
                    <option value="budget">Anggaran & Realisasi (APBDes)</option>
                    <option value="development">Pembangunan Desa (Proyek Fisik)</option>
                    <option value="asset">Aset & Inventaris Desa</option>
                    <option value="report">Arsip Dokumen Lainnya</option>
                </select>
            </div>
            <div class="form-group" style="margin: 0;">
                <label style="font-size: 0.8rem; font-weight: 700; color: var(--primary-light);">Berkas File (PDF)</label>
                <input type="file" name="document_files[${indexCounter}]" class="form-control" accept="application/pdf" required>
            </div>
            <button type="button" class="btn btn-danger btn-remove-row" style="padding: 10px 14px; margin-bottom: 0;">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        `;
        
        container.appendChild(row);
        indexCounter++;

        // Add delete handler to the remove button
        row.querySelector('.btn-remove-row').addEventListener('click', function() {
            row.remove();
        });
    }

    btnAdd.addEventListener('click', addNewDocumentRow);
});
</script>
@endsection
