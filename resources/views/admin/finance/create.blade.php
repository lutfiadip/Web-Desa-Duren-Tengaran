@extends('admin.layouts.admin')

@section('title', 'Tambah Tahun Anggaran')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Tambah Tahun Anggaran Transparansi Baru</h2>
            <a href="{{ route('admin.transparency.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.transparency.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div class="form-group">
                    <label for="year">Tahun Anggaran</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="Masukkan tahun anggaran" required
                        min="2000" max="2100">
                </div>
                <div class="form-group" style="display: flex; align-items: center; margin-top: 25px;">
                    <label class="switch" style="margin-right: 12px;">
                        <input type="checkbox" name="is_active" value="1" checked>
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
                Masukkan target dan realisasi dari 3 sektor utama APBDes. Angka ini akan otomatis dihitung persentasenya dan
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
                    <label for="revenue_realization">Total Realisasi Pendapatan (Rp) <span
                            style="font-weight: 500; font-size: 0.8rem; color: var(--text-muted);">(Dihitung Otomatis dari
                            Rincian)</span></label>
                    <input type="number" name="revenue_realization" id="revenue_realization" class="form-control"
                        placeholder="0" readonly
                        style="background-color: #e2e8f0; font-weight: 700; color: var(--text-dark);">
                </div>

                <div style="margin-top: 15px; border-top: 1px dashed var(--border-color); padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h5
                            style="font-weight: 700; color: var(--text-dark); margin: 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Rincian Pendapatan (Realisasi):</h5>
                        <button type="button" class="btn btn-secondary" id="btn-add-revenue"
                            style="padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-plus"></i> Tambah Rincian
                        </button>
                    </div>
                    <div id="revenue-details-container">
                        <!-- Dynamic rows added via JS -->
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
                    <label for="spending_realization">Total Realisasi Belanja (Rp) <span
                            style="font-weight: 500; font-size: 0.8rem; color: var(--text-muted);">(Dihitung Otomatis dari
                            Rincian)</span></label>
                    <input type="number" name="spending_realization" id="spending_realization" class="form-control"
                        placeholder="0" readonly
                        style="background-color: #e2e8f0; font-weight: 700; color: var(--text-dark);">
                </div>

                <div style="margin-top: 15px; border-top: 1px dashed var(--border-color); padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h5
                            style="font-weight: 700; color: var(--text-dark); margin: 0; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            Rincian Belanja (Realisasi):</h5>
                        <button type="button" class="btn btn-secondary" id="btn-add-spending"
                            style="padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-plus"></i> Tambah Rincian
                        </button>
                    </div>
                    <div id="spending-details-container">
                        <!-- Dynamic rows added via JS -->
                    </div>
                </div>
            </div>

            <!-- Baliho Poster APBDes -->
            <h3
                style="font-size: 1.1rem; font-weight: 800; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin: 25px 0 15px 0; color: var(--primary);">
                <i class="fa-solid fa-image"></i> Poster Infografis APBDes
            </h3>
            <div class="form-group">
                <label for="apbdes_poster">Unggah Gambar Infografis APBDes</label>
                <input type="file" name="apbdes_poster" id="apbdes_poster" class="form-control" accept="image/*">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format yang
                    didukung: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
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
                        <i class="fa-solid fa-plus"></i> Tambah Berkas Dokumen
                    </button>
                </div>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                    Unggah dokumen pendukung seperti RPJMDes, RKPDes, Laporan Realisasi Pembangunan, atau Daftar Aset Desa.
                    Dokumen harus berformat **PDF** agar dapat dibaca langsung oleh warga.
                </p>

                <div id="documents-container" style="display: flex; flex-direction: column; gap: 15px;">
                    <!-- Container row will be appended here dynamically by JavaScript -->
                </div>
            </div>

            <div
                style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
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
            let revenueCounter = 0;

            function addRevenueRow(label = '', value = '') {
                const row = document.createElement('div');
                row.style = 'display: grid; grid-template-columns: 3fr 2fr auto; gap: 15px; align-items: flex-end; margin-bottom: 12px;';
                row.innerHTML = `
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 600;">Nama Rincian / Indikator</label>
                    <input type="text" name="revenue_details[${revenueCounter}][label]" class="form-control rev-label-input" value="${label}" placeholder="Masukkan rincian pendapatan" required>
                </div>
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 600;">Nominal Realisasi (Rp)</label>
                    <input type="number" name="revenue_details[${revenueCounter}][value]" class="form-control rev-val-input" value="${value}" placeholder="Masukkan nominal" min="0" required>
                </div>
                <button type="button" class="btn btn-danger btn-remove-revenue" style="padding: 10px 14px; margin-bottom: 0;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `;
                revenueContainer.appendChild(row);
                revenueCounter++;

                // Add event listeners
                row.querySelector('.rev-val-input').addEventListener('input', calculateTotalRevenueRealization);
                row.querySelector('.btn-remove-revenue').addEventListener('click', function () {
                    row.remove();
                    calculateTotalRevenueRealization();
                });
            }

            // Default Revenue rows on creation
            const defaultRevenues = [
                { label: 'Alokasi Dana Desa', value: '' },
                { label: 'Dana Desa', value: '' },
                { label: 'BHPD & BHRD', value: '' },
                { label: 'Pendapatan Asli Desa', value: '' }
            ];
            defaultRevenues.forEach(r => addRevenueRow(r.label, r.value));

            btnAddRevenue.addEventListener('click', () => addRevenueRow());

            function calculateTotalRevenueRealization() {
                let total = 0;
                document.querySelectorAll('.rev-val-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('revenue_realization').value = Math.round(total);
            }

            // Spending Details Management
            const spendingContainer = document.getElementById('spending-details-container');
            const btnAddSpending = document.getElementById('btn-add-spending');
            let spendingCounter = 0;

            function addSpendingRow(label = '', value = '') {
                const row = document.createElement('div');
                row.style = 'display: grid; grid-template-columns: 3fr 2fr auto; gap: 15px; align-items: flex-end; margin-bottom: 12px;';
                row.innerHTML = `
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 600;">Nama Bidang / Indikator</label>
                    <input type="text" name="spending_details[${spendingCounter}][label]" class="form-control spend-label-input" value="${label}" placeholder="Masukkan rincian belanja" required>
                </div>
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 600;">Nominal Realisasi (Rp)</label>
                    <input type="number" name="spending_details[${spendingCounter}][value]" class="form-control spend-val-input" value="${value}" placeholder="Masukkan nominal" min="0" required>
                </div>
                <button type="button" class="btn btn-danger btn-remove-spending" style="padding: 10px 14px; margin-bottom: 0;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `;
                spendingContainer.appendChild(row);
                spendingCounter++;

                // Add event listeners
                row.querySelector('.spend-val-input').addEventListener('input', calculateTotalSpendingRealization);
                row.querySelector('.btn-remove-spending').addEventListener('click', function () {
                    row.remove();
                    calculateTotalSpendingRealization();
                });
            }

            // Default Spending rows on creation
            const defaultSpendings = [
                { label: 'Pemerintahan Desa', value: '' },
                { label: 'Pembangunan Desa', value: '' },
                { label: 'Pembinaan Kemasyarakatan', value: '' },
                { label: 'Pemberdayaan Masyarakat', value: '' },
                { label: 'Penanggulangan Bencana', value: '' }
            ];
            defaultSpendings.forEach(s => addSpendingRow(s.label, s.value));

            btnAddSpending.addEventListener('click', () => addSpendingRow());

            function calculateTotalSpendingRealization() {
                let total = 0;
                document.querySelectorAll('.spend-val-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('spending_realization').value = Math.round(total);
            }

            const container = document.getElementById('documents-container');
            const btnAdd = document.getElementById('btn-add-document');
            let indexCounter = 0;

            function addDocumentRow() {
                const row = document.createElement('div');
                row.className = 'document-row';
                row.style = 'display: grid; grid-template-columns: 2fr 1.5fr 2fr auto; gap: 15px; align-items: flex-end; background: #fafafa; padding: 15px; border-radius: var(--radius-md); border: 1px dashed var(--border-color);';

                row.innerHTML = `
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 700;">Judul Laporan / Dokumen</label>
                    <input type="text" name="document_titles[${indexCounter}]" class="form-control" placeholder="Masukkan judul dokumen" required>
                </div>
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 700;">Kategori Halaman / Tab</label>
                    <select name="document_categories[${indexCounter}]" class="form-control" required>
                        <option value="budget">Anggaran & Realisasi (APBDes)</option>
                        <option value="development">Pembangunan Desa (Proyek Fisik)</option>
                        <option value="asset">Aset & Inventaris Desa</option>
                        <option value="report">Arsip Dokumen Lainnya</option>
                    </select>
                </div>
                <div class="form-group" style="margin: 0;">
                    <label style="font-size: 0.8rem; font-weight: 700;">Berkas File (PDF)</label>
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

            // Add first row by default
            addDocumentRow();

            btnAdd.addEventListener('click', addDocumentRow);
        });
    </script>
@endsection