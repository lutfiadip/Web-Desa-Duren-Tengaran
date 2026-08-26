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
                <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2026" required min="2000" max="2100">
            </div>
            <div class="form-group" style="display: flex; align-items: center; margin-top: 25px;">
                <label class="switch" style="margin-right: 12px;">
                    <input type="checkbox" name="is_active" value="1" checked>
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
            <div class="form-group">
                <label for="revenue_realization">Realisasi Pendapatan (Rp)</label>
                <input type="number" name="revenue_realization" id="revenue_realization" class="form-control" placeholder="Contoh: 1200000000" required min="0">
            </div>
            
            <div style="margin-top: 15px; border-top: 1px dashed var(--border-color); padding-top: 15px;">
                <h5 style="font-weight: 700; color: var(--text-dark); margin-bottom: 12px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Rincian Pendapatan (Realisasi):</h5>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div class="form-group">
                        <label for="revenue_add" style="font-size: 0.8rem; font-weight: 600;">1. Alokasi Dana Desa (ADD) (Rp)</label>
                        <input type="number" name="revenue_add" id="revenue_add" class="form-control" placeholder="Contoh: 518019000" min="0">
                    </div>
                    <div class="form-group">
                        <label for="revenue_dd" style="font-size: 0.8rem; font-weight: 600;">2. Dana Desa (DD) (Rp)</label>
                        <input type="number" name="revenue_dd" id="revenue_dd" class="form-control" placeholder="Contoh: 886640000" min="0">
                    </div>
                    <div class="form-group">
                        <label for="revenue_pbh" style="font-size: 0.8rem; font-weight: 600;">3. BHPD & BHRD (Bagi Hasil Pajak & Retribusi) (Rp)</label>
                        <input type="number" name="revenue_pbh" id="revenue_pbh" class="form-control" placeholder="Contoh: 162723000" min="0">
                    </div>
                    <div class="form-group">
                        <label for="revenue_pad" style="font-size: 0.8rem; font-weight: 600;">4. Pendapatan Asli Desa (PAD) (Rp)</label>
                        <input type="number" name="revenue_pad" id="revenue_pad" class="form-control" placeholder="Contoh: 152280000" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sektor Belanja -->
        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 20px;">
            <h4 style="font-weight: 700; color: #b91c1c; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 8px; height: 8px; background: #b91c1c; border-radius: 50%;"></span> Sektor Belanja / Pengeluaran Desa
            </h4>
            <div class="form-group">
                <label for="spending_realization">Realisasi Belanja (Rp)</label>
                <input type="number" name="spending_realization" id="spending_realization" class="form-control" placeholder="Contoh: 1100000000" required min="0">
            </div>
            
            <div style="margin-top: 15px; border-top: 1px dashed var(--border-color); padding-top: 15px;">
                <h5 style="font-weight: 700; color: var(--text-dark); margin-bottom: 12px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Rincian Belanja (Realisasi):</h5>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div class="form-group">
                        <label for="spending_pemerintahan" style="font-size: 0.8rem; font-weight: 600;">1. Bidang Pemerintahan Desa (Rp)</label>
                        <input type="number" name="spending_pemerintahan" id="spending_pemerintahan" class="form-control" placeholder="Contoh: 973347640" min="0">
                    </div>
                    <div class="form-group">
                        <label for="spending_pembangunan" style="font-size: 0.8rem; font-weight: 600;">2. Bidang Pembangunan Desa (Rp)</label>
                        <input type="number" name="spending_pembangunan" id="spending_pembangunan" class="form-control" placeholder="Contoh: 1247861400" min="0">
                    </div>
                    <div class="form-group">
                        <label for="spending_pembinaan" style="font-size: 0.8rem; font-weight: 600;">3. Bidang Pembinaan Kemasyarakatan (Rp)</label>
                        <input type="number" name="spending_pembinaan" id="spending_pembinaan" class="form-control" placeholder="Contoh: 71115850" min="0">
                    </div>
                    <div class="form-group">
                        <label for="spending_pemberdayaan" style="font-size: 0.8rem; font-weight: 600;">4. Bidang Pemberdayaan Masyarakat (Rp)</label>
                        <input type="number" name="spending_pemberdayaan" id="spending_pemberdayaan" class="form-control" placeholder="Contoh: 129910000" min="0">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="spending_penanggulangan" style="font-size: 0.8rem; font-weight: 600;">5. Bidang Penanggulangan Bencana, Keadaan Darurat & Mendesak (Rp)</label>
                        <input type="number" name="spending_penanggulangan" id="spending_penanggulangan" class="form-control" placeholder="Contoh: 146991203" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Baliho Poster APBDes -->
        <h3 style="font-size: 1.1rem; font-weight: 800; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin: 25px 0 15px 0; color: var(--primary);">
            <i class="fa-solid fa-image"></i> Poster Infografis Baliho APBDes
        </h3>
        <div class="form-group">
            <label for="apbdes_poster">Unggah Gambar Baliho APBDes (Poster Laporan)</label>
            <input type="file" name="apbdes_poster" id="apbdes_poster" class="form-control" accept="image/*">
            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</span>
        </div>

        <!-- Documents Section -->
        <div style="margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-color); padding-bottom: 8px; margin-bottom: 15px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary); margin: 0;">
                    <i class="fa-solid fa-file-pdf"></i> Lampiran Berkas Dokumen PDF
                </h3>
                <button type="button" id="btn-add-document" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.85rem;">
                    <i class="fa-solid fa-plus"></i> Tambah Berkas Dokumen
                </button>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                Unggah dokumen pendukung seperti RPJMDes, RKPDes, Laporan Realisasi Pembangunan, atau Daftar Aset Desa. Dokumen harus berformat **PDF** agar dapat dibaca langsung oleh warga.
            </p>

            <div id="documents-container" style="display: flex; flex-direction: column; gap: 15px;">
                <!-- Container row will be appended here dynamically by JavaScript -->
            </div>
        </div>

        <div style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- AUTO-CALCULATE REALIZATION FROM DETAILS ---
    const revenueDetailInputs = [
        document.getElementById('revenue_add'),
        document.getElementById('revenue_dd'),
        document.getElementById('revenue_pbh'),
        document.getElementById('revenue_pad')
    ];
    const revenueRealizationInput = document.getElementById('revenue_realization');

    function calculateTotalRevenueRealization() {
        let total = 0;
        let anyInputFilled = false;
        revenueDetailInputs.forEach(input => {
            if (input && input.value !== '') {
                total += parseFloat(input.value) || 0;
                anyInputFilled = true;
            }
        });
        if (anyInputFilled && revenueRealizationInput) {
            revenueRealizationInput.value = Math.round(total);
        }
    }

    revenueDetailInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', calculateTotalRevenueRealization);
        }
    });

    const spendingDetailInputs = [
        document.getElementById('spending_pemerintahan'),
        document.getElementById('spending_pembangunan'),
        document.getElementById('spending_pembinaan'),
        document.getElementById('spending_pemberdayaan'),
        document.getElementById('spending_penanggulangan')
    ];
    const spendingRealizationInput = document.getElementById('spending_realization');

    function calculateTotalSpendingRealization() {
        let total = 0;
        let anyInputFilled = false;
        spendingDetailInputs.forEach(input => {
            if (input && input.value !== '') {
                total += parseFloat(input.value) || 0;
                anyInputFilled = true;
            }
        });
        if (anyInputFilled && spendingRealizationInput) {
            spendingRealizationInput.value = Math.round(total);
        }
    }

    spendingDetailInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', calculateTotalSpendingRealization);
        }
    });

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
                <input type="text" name="document_titles[${indexCounter}]" class="form-control" placeholder="Contoh: Laporan Realisasi Semester I" required>
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
        row.querySelector('.btn-remove-row').addEventListener('click', function() {
            row.remove();
        });
    }

    // Add first row by default
    addDocumentRow();

    btnAdd.addEventListener('click', addDocumentRow);
});
</script>
@endsection
