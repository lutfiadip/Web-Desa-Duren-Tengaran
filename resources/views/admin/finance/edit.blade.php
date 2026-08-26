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
                    <input type="number" name="year" id="year" class="form-control" value="{{ $report->year }}"
                        placeholder="Contoh: 2026" required min="2000" max="2100">
                </div>
                <div class="form-group" style="display: flex; align-items: center; margin-top: 25px;">
                    <label class="switch" style="margin-right: 12px;">
                        <input type="checkbox" name="is_active" value="1" {{ $report->is_active ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span style="font-weight: 700; color: var(--text-dark);">Tampilkan di Halaman Publik</span>
                </div>
            </div>

            <h3
                style="font-size: 1.1rem; font-weight: 800; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin: 25px 0 15px 0; color: var(--primary);">
                <i class="fa-solid fa-calculator"></i> Ringkasan Nominal APBDes (Angka Utama)
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                Masukkan realisasi dari 2 sektor utama APBDes. Angka ini akan otomatis dihitung persentasenya dan
                divisualisasikan dalam bentuk progress bar di halaman publik.
            </p>

            <!-- Sektor Pendapatan -->
            <div
                style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 20px;">
                <h4
                    style="font-weight: 700; color: #15803d; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                    <span style="width: 8px; height: 8px; background: #15803d; border-radius: 50%;"></span> Sektor
                    Pendapatan Desa
                </h4>
                <div class="form-group">
                    <label for="revenue_realization">Total Realisasi Pendapatan (Rp) <span style="font-weight: 500; font-size: 0.8rem; color: var(--text-muted);">(Dihitung Otomatis dari Rincian)</span></label>
                    <input type="number" name="revenue_realization" id="revenue_realization" class="form-control"
                        value="{{ (int) $report->revenue_realization }}" readonly style="background-color: #e2e8f0; font-weight: 700; color: var(--text-dark);">
                </div>

                <div style="margin-top: 15px; border-top: 1px dashed var(--border-color); padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h5 style="font-weight: 700; color: var(--text-dark); margin: 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Rincian Pendapatan (Realisasi):</h5>
                        <button type="button" class="btn btn-secondary" id="btn-add-revenue" style="padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-plus"></i> Tambah Rincian
                        </button>
                    </div>
                    <div id="revenue-details-container">
                        @foreach($report->details->where('type', 'revenue') as $index => $detail)
                            <div class="dynamic-revenue-row" style="display: grid; grid-template-columns: 3fr 2fr auto; gap: 15px; align-items: flex-end; margin-bottom: 12px;">
                                <div class="form-group" style="margin: 0;">
                                    <label style="font-size: 0.8rem; font-weight: 600;">Nama Rincian / Indikator</label>
                                    <input type="text" name="revenue_details[{{ $index }}][label]" class="form-control rev-label-input" value="{{ $detail->label }}" placeholder="Contoh: Alokasi Dana Desa" required>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label style="font-size: 0.8rem; font-weight: 600;">Nominal Realisasi (Rp)</label>
                                    <input type="number" name="revenue_details[{{ $index }}][value]" class="form-control rev-val-input" value="{{ (int)$detail->value }}" placeholder="0" min="0" required>
                                </div>
                                <button type="button" class="btn btn-danger btn-remove-revenue" style="padding: 10px 14px; margin-bottom: 0;">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sektor Belanja -->
            <div
                style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 20px;">
                <h4
                    style="font-weight: 700; color: #b91c1c; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                    <span style="width: 8px; height: 8px; background: #b91c1c; border-radius: 50%;"></span> Sektor Belanja /
                    Pengeluaran Desa
                </h4>
                <div class="form-group">
                    <label for="spending_realization">Total Realisasi Belanja (Rp) <span style="font-weight: 500; font-size: 0.8rem; color: var(--text-muted);">(Dihitung Otomatis dari Rincian)</span></label>
                    <input type="number" name="spending_realization" id="spending_realization" class="form-control"
                        value="{{ (int) $report->spending_realization }}" readonly style="background-color: #e2e8f0; font-weight: 700; color: var(--text-dark);">
                </div>

                <div style="margin-top: 15px; border-top: 1px dashed var(--border-color); padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h5 style="font-weight: 700; color: var(--text-dark); margin: 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Rincian Belanja (Realisasi):</h5>
                        <button type="button" class="btn btn-secondary" id="btn-add-spending" style="padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-plus"></i> Tambah Rincian
                        </button>
                    </div>
                    <div id="spending-details-container">
                        @foreach($report->details->where('type', 'spending') as $index => $detail)
                            <div class="dynamic-spending-row" style="display: grid; grid-template-columns: 3fr 2fr auto; gap: 15px; align-items: flex-end; margin-bottom: 12px;">
                                <div class="form-group" style="margin: 0;">
                                    <label style="font-size: 0.8rem; font-weight: 600;">Nama Bidang / Indikator</label>
                                    <input type="text" name="spending_details[{{ $index }}][label]" class="form-control spend-label-input" value="{{ $detail->label }}" placeholder="Contoh: Pemerintahan Desa" required>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label style="font-size: 0.8rem; font-weight: 600;">Nominal Realisasi (Rp)</label>
                                    <input type="number" name="spending_details[{{ $index }}][value]" class="form-control spend-val-input" value="{{ (int)$detail->value }}" placeholder="0" min="0" required>
                                </div>
                                <button type="button" class="btn btn-danger btn-remove-spending" style="padding: 10px 14px; margin-bottom: 0;">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Baliho Poster APBDes -->
            <h3
                style="font-size: 1.1rem; font-weight: 800; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin: 25px 0 15px 0; color: var(--primary);">
                <i class="fa-solid fa-image"></i> Poster Infografis Baliho APBDes
            </h3>
            <div class="form-group" style="display: flex; flex-direction: column; gap: 15px;">
                @if($report->apbdes_poster)
                    <div id="poster-preview-container"
                        style="position: relative; max-width: 250px; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 10px; background: #fafafa;">
                        <button type="button" id="btn-delete-poster"
                            style="position: absolute; top: -10px; right: -10px; background: #ef4444; color: white; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10;"
                            title="Hapus Gambar">
                            <i class="fa-solid fa-xmark" style="font-size: 0.85rem;"></i>
                        </button>
                        <input type="hidden" name="delete_poster" id="delete-poster-input" value="0">
                        <span style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 8px;">Poster Saat
                            Ini:</span>
                        <a href="{{ asset($report->apbdes_poster) }}" target="_blank"
                            style="display: block; border-radius: 4px; overflow: hidden;">
                            <img src="{{ asset($report->apbdes_poster) }}" alt="Poster APBDes"
                                style="width: 100%; height: auto; max-height: 150px; object-fit: contain;">
                        </a>
                    </div>
                @endif
                <div>
                    <label for="apbdes_poster">Ubah Gambar Infografis APBDes</label>
                    <input type="file" name="apbdes_poster" id="apbdes_poster" class="form-control" accept="image/*">
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Biarkan
                        kosong jika tidak ingin mengubah poster saat ini.</span>
                </div>
            </div>

            <!-- Documents Section -->
            <div style="margin-top: 30px;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin-bottom: 15px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary); margin: 0;">
                        <i class="fa-solid fa-file-pdf"></i> Lampiran Berkas Dokumen PDF
                    </h3>
                    <button type="button" id="btn-add-document" class="btn btn-secondary"
                        style="padding: 6px 12px; font-size: 0.85rem;">
                        <i class="fa-solid fa-plus"></i> Tambah Berkas Baru
                    </button>
                </div>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                    Daftar dokumen laporan transparansi yang terunggah untuk tahun anggaran {{ $report->year }}. Warga dapat
                    membaca secara langsung berkas PDF ini secara online.
                </p>

                <!-- Existing Documents -->
                @if($report->documents->count() > 0)
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-dark); margin-bottom: 10px;">Dokumen
                        Terunggah:</h4>
                    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 25px;">
                        @foreach($report->documents as $doc)
                            <div class="existing-doc-row" data-id="{{ $doc->id }}"
                                style="display: grid; grid-template-columns: 2.2fr 1.5fr 2fr auto; gap: 15px; align-items: flex-end; background: #fff; padding: 12px 15px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                                <div class="form-group" style="margin: 0;">
                                    <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">Judul
                                        Dokumen</label>
                                    <input type="text" name="existing_document_titles[{{ $doc->id }}]" value="{{ $doc->title }}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">Kategori Halaman /
                                        Tab</label>
                                    <select name="existing_document_categories[{{ $doc->id }}]" class="form-control" required>
                                        <option value="budget" {{ $doc->category === 'budget' ? 'selected' : '' }}>Anggaran &
                                            Realisasi (APBDes)</option>
                                        <option value="development" {{ $doc->category === 'development' ? 'selected' : '' }}>
                                            Pembangunan Desa (Proyek Fisik)</option>
                                        <option value="asset" {{ $doc->category === 'asset' ? 'selected' : '' }}>Aset & Inventaris
                                            Desa</option>
                                        <option value="report" {{ $doc->category === 'report' ? 'selected' : '' }}>Arsip Dokumen
                                            Lainnya</option>
                                    </select>
                                </div>
                                <div style="margin: 0; padding-bottom: 10px;">
                                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-secondary"
                                        style="padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-file-pdf"></i> Lihat File Saat Ini
                                    </a>
                                </div>
                                <button type="button" class="btn btn-danger btn-delete-existing-doc"
                                    style="padding: 10px 14px; margin-bottom: 0;">
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

            <div
                style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('admin.transparency.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- AUTO-CALCULATE REALIZATION FROM DYNAMIC DETAILS ---
            // Revenue Details Management
            const revenueContainer = document.getElementById('revenue-details-container');
            const btnAddRevenue = document.getElementById('btn-add-revenue');
            let revenueCounter = {{ $report->details->where('type', 'revenue')->count() }};

            function addRevenueRow(label = '', value = '') {
                const row = document.createElement('div');
                row.className = 'dynamic-revenue-row';
                row.style = 'display: grid; grid-template-columns: 3fr 2fr auto; gap: 15px; align-items: flex-end; margin-bottom: 12px;';
                row.innerHTML = `
                    <div class="form-group" style="margin: 0;">
                        <label style="font-size: 0.8rem; font-weight: 600;">Nama Rincian / Indikator</label>
                        <input type="text" name="revenue_details[${revenueCounter}][label]" class="form-control rev-label-input" value="${label}" placeholder="Contoh: Alokasi Dana Desa" required>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label style="font-size: 0.8rem; font-weight: 600;">Nominal Realisasi (Rp)</label>
                        <input type="number" name="revenue_details[${revenueCounter}][value]" class="form-control rev-val-input" value="${value}" placeholder="0" min="0" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove-revenue" style="padding: 10px 14px; margin-bottom: 0;">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                `;
                revenueContainer.appendChild(row);
                revenueCounter++;

                // Add event listeners
                row.querySelector('.rev-val-input').addEventListener('input', calculateTotalRevenueRealization);
                row.querySelector('.btn-remove-revenue').addEventListener('click', function() {
                    row.remove();
                    calculateTotalRevenueRealization();
                });
            }

            btnAddRevenue.addEventListener('click', () => addRevenueRow());

            function calculateTotalRevenueRealization() {
                let total = 0;
                document.querySelectorAll('.rev-val-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('revenue_realization').value = Math.round(total);
            }

            // Setup listeners for existing revenue rows
            document.querySelectorAll('.rev-val-input').forEach(input => {
                input.addEventListener('input', calculateTotalRevenueRealization);
            });
            document.querySelectorAll('.btn-remove-revenue').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.dynamic-revenue-row').remove();
                    calculateTotalRevenueRealization();
                });
            });

            // Spending Details Management
            const spendingContainer = document.getElementById('spending-details-container');
            const btnAddSpending = document.getElementById('btn-add-spending');
            let spendingCounter = {{ $report->details->where('type', 'spending')->count() }};

            function addSpendingRow(label = '', value = '') {
                const row = document.createElement('div');
                row.className = 'dynamic-spending-row';
                row.style = 'display: grid; grid-template-columns: 3fr 2fr auto; gap: 15px; align-items: flex-end; margin-bottom: 12px;';
                row.innerHTML = `
                    <div class="form-group" style="margin: 0;">
                        <label style="font-size: 0.8rem; font-weight: 600;">Nama Bidang / Indikator</label>
                        <input type="text" name="spending_details[${spendingCounter}][label]" class="form-control spend-label-input" value="${label}" placeholder="Contoh: Pemerintahan Desa" required>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label style="font-size: 0.8rem; font-weight: 600;">Nominal Realisasi (Rp)</label>
                        <input type="number" name="spending_details[${spendingCounter}][value]" class="form-control spend-val-input" value="${value}" placeholder="0" min="0" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove-spending" style="padding: 10px 14px; margin-bottom: 0;">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                `;
                spendingContainer.appendChild(row);
                spendingCounter++;

                // Add event listeners
                row.querySelector('.spend-val-input').addEventListener('input', calculateTotalSpendingRealization);
                row.querySelector('.btn-remove-spending').addEventListener('click', function() {
                    row.remove();
                    calculateTotalSpendingRealization();
                });
            }

            btnAddSpending.addEventListener('click', () => addSpendingRow());

            function calculateTotalSpendingRealization() {
                let total = 0;
                document.querySelectorAll('.spend-val-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('spending_realization').value = Math.round(total);
            }

            // Setup listeners for existing spending rows
            document.querySelectorAll('.spend-val-input').forEach(input => {
                input.addEventListener('input', calculateTotalSpendingRealization);
            });
            document.querySelectorAll('.btn-remove-spending').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.dynamic-spending-row').remove();
                    calculateTotalSpendingRealization();
                });
            });



            const container = document.getElementById('new-documents-container');
            const deletedContainer = document.getElementById('deleted-docs-container');
            const btnAdd = document.getElementById('btn-add-document');
            let indexCounter = 0;

            // Handle delete existing documents on client-side
            document.querySelectorAll('.btn-delete-existing-doc').forEach(btn => {
                btn.addEventListener('click', function () {
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
                row.querySelector('.btn-remove-row').addEventListener('click', function () {
                    row.remove();
                });
            }

            btnAdd.addEventListener('click', addNewDocumentRow);

            // Handle delete poster via cross button
            document.getElementById('btn-delete-poster')?.addEventListener('click', function () {
                if (confirm('Apakah Anda yakin ingin menghapus gambar baliho ini? Gambar akan dihapus secara permanen saat Anda menyimpan perubahan.')) {
                    document.getElementById('delete-poster-input').value = '1';
                    document.getElementById('poster-preview-container').style.display = 'none';
                }
            });
        });
    </script>
@endsection