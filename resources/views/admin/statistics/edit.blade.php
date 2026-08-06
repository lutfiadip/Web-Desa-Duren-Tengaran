@extends('admin.layouts.admin')

@section('title', 'Sunting Statistik ' . ($type === 'gender' ? 'Jenis Kelamin' : ($type === 'age' ? 'Kelompok Umur' : 'Kepemilikan KK')))

@section('styles')
<style>
    .edit-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .edit-layout {
            grid-template-columns: 1fr;
        }
    }

    .form-group label {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 0.85rem;
        margin-bottom: 6px;
        display: block;
    }

    /* Unsaved changes indicator banner */
    .unsaved-banner {
        display: none;
        background-color: #fffbeb;
        border: 1px solid #fef3c7;
        color: #d97706;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        margin-bottom: 25px;
        font-weight: 700;
        font-size: 0.85rem;
        align-items: center;
        gap: 8px;
    }

    /* Floating preview widget */
    .preview-widget {
        background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
        color: #fff;
        border-radius: var(--radius-lg);
        padding: 24px;
        position: sticky;
        top: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .preview-header {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 1.2px;
        color: #93c5fd;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 15px;
    }

    .preview-label {
        font-size: 0.9rem;
        color: #94a3b8;
    }

    .preview-val {
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
    }

    .preview-total-box {
        background: rgba(255,255,255,0.06);
        border-radius: var(--radius-md);
        padding: 15px;
        margin-top: 20px;
        border: 1px solid rgba(255,255,255,0.1);
        text-align: center;
    }

    /* Custom Confirmation Modal */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(15, 23, 42, 0.6);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 30px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        animation: slideUp 0.2s ease-out;
    }

    @keyframes slideUp {
        from { transform: translateY(15px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    /* Validation styling */
    .is-invalid {
        border-color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }

    .error-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 4px;
        display: none;
    }

    /* Dynamic table buttons */
    .btn-add-row {
        background-color: #f1f5f9;
        border: 1px dashed #cbd5e1;
        color: var(--primary-light);
        width: 100%;
        padding: 10px;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        transition: var(--transition);
    }

    .btn-add-row:hover {
        background-color: #e2e8f0;
        border-color: #94a3b8;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 25px; font-size: 0.9rem;">
        <ol style="list-style: none; padding: 0; display: flex; gap: 8px; align-items: center; color: var(--text-muted); margin: 0;">
            <li>
                <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500;">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li>
                <a href="{{ route('admin.statistics.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500;">
                    Statistik Penduduk
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Sunting Statistik {{ $type === 'gender' ? 'Jenis Kelamin' : ($type === 'age' ? 'Kelompok Umur' : 'Kepemilikan KK') }}</li>
        </ol>
    </nav>

    <!-- Header title -->
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">
            Sunting Statistik {{ $type === 'gender' ? 'Jenis Kelamin' : ($type === 'age' ? 'Kelompok Umur' : 'Kepemilikan KK') }}
        </h1>
        <p style="color: var(--text-muted);">Ubah data rincian nilai kependudukan berdasarkan periode semester yang berjalan.</p>
    </div>

    <!-- Laravel Validation Alert -->
    @if ($errors->any())
        <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 15px 20px; border-radius: var(--radius-md); margin-bottom: 30px; font-weight: 600;">
            <ul style="list-style: none; margin: 0; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Unsaved banner indicator -->
    <div class="unsaved-banner" id="unsavedIndicator">
        <i class="fa-solid fa-circle-dot" style="animation: pulseIndicator 1.5s infinite;"></i>
        <span>Ada perubahan yang belum disimpan.</span>
    </div>

    <div class="edit-layout">
        <!-- LEFT COLUMN: EDIT FORM -->
        <div class="card" style="padding: 30px;">
            <form id="statsForm" action="{{ route('admin.statistics.update', $type) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- 1. PERIODE DATA -->
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-top: 0;">
                    <i class="fa-solid fa-calendar-days"></i> Periode & Sumber Data
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select id="semester" name="semester" class="form-control" required>
                            <option value="1" {{ old('semester', $statistic->semester) == 1 ? 'selected' : '' }}>Semester I (Ganjil)</option>
                            <option value="2" {{ old('semester', $statistic->semester) == 2 ? 'selected' : '' }}>Semester II (Genap)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Tahun</label>
                        <select id="year" name="year" class="form-control" required>
                            @for($y = 2020; $y <= date('Y') + 3; $y++)
                                <option value="{{ $y }}" {{ old('year', $statistic->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="source">Sumber Data</label>
                    <input type="text" id="source" name="source" class="form-control" 
                        value="{{ old('source', $statistic->source) }}" placeholder="Contoh: DKB Semester II Tahun 2025" required>
                    <div class="error-feedback" id="source-error">Sumber data tidak boleh kosong.</div>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label for="pdf_file">Berkas PDF Asli (Opsional)</label>
                    @if($statistic->pdf_file)
                        <div style="margin-bottom: 10px; font-size: 0.9rem;">
                            <span style="color: var(--text-muted);">Berkas saat ini: </span>
                            <a href="{{ asset($statistic->pdf_file) }}" target="_blank" style="color: var(--primary-light); font-weight: 700; text-decoration: none;">
                                <i class="fa-solid fa-file-pdf"></i> Lihat Berkas PDF
                            </a>
                        </div>
                    @endif
                    <input type="file" id="pdf_file" name="pdf_file" class="form-control" accept="application/pdf">
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal ukuran berkas: 5 MB. Hanya menerima file format PDF.</span>
                    <div class="error-feedback" id="pdf_file-error">File harus berformat PDF dan maksimal 5MB.</div>
                </div>

                <!-- 2. DATA TABLE -->
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                    <i class="fa-solid fa-list-ol"></i> Rincian Nilai Jumlah Penduduk (Jiwa)
                </h3>

                <div class="table-responsive" style="margin-bottom: 15px;">
                    <table class="table" style="width: 100%; border-collapse: collapse; text-align: left;" id="detailsTable">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 12px; font-weight: 800; color: var(--text-dark);">Label Data</th>
                                <th style="padding: 12px; font-weight: 800; color: var(--text-dark); width: 140px;">Laki-laki</th>
                                <th style="padding: 12px; font-weight: 800; color: var(--text-dark); width: 140px;">Perempuan</th>
                                <th style="padding: 12px; font-weight: 800; color: var(--text-dark); width: 100px;">Total</th>
                                <th style="padding: 12px; font-weight: 800; color: var(--text-dark); width: 80px;">%</th>
                                @if($type === 'age')
                                    <th style="padding: 12px; font-weight: 800; color: var(--text-dark); width: 70px; text-align: center;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Dynamic rows rendered via JS -->
                        </tbody>
                        <tfoot>
                            <tr style="border-top: 2px solid var(--border-color); font-weight: 800; background-color: #f8fafc;" id="tableFooter">
                                <td style="padding: 12px; color: var(--text-dark);">TOTAL KESELURUHAN</td>
                                <td style="padding: 12px; color: var(--text-dark);" id="footerMale">0</td>
                                <td style="padding: 12px; color: var(--text-dark);" id="footerFemale">0</td>
                                <td style="padding: 12px; color: var(--text-dark);" id="footerTotal">0</td>
                                <td style="padding: 12px; color: var(--text-dark);">100%</td>
                                @if($type === 'age')
                                    <td></td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($type === 'age')
                    <button type="button" class="btn-add-row" id="btnAddRow">
                        <i class="fa-solid fa-plus"></i> Tambah Baris Kelompok Umur
                    </button>
                @endif

                <!-- BUTTON ACTIONS -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 25px; display: flex; gap: 12px; justify-content: flex-end; margin-top: 30px;">
                    <button type="button" id="btnReset" class="btn" style="background-color: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-color); padding: 12px 25px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                    <a href="{{ route('admin.statistics.index') }}" class="btn" style="background-color: transparent; border: 1px solid var(--border-color); color: var(--text-dark); text-decoration: none; padding: 12px 25px; border-radius: var(--radius-md); font-weight: 700; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                        Batal
                    </a>
                    <button type="submit" id="btnSubmit" class="btn btn-primary" style="padding: 12px 35px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-circle-check"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT COLUMN: FLOATING PREVIEW & LAST UPDATED -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- REALTIME PREVIEW WIDGET -->
            <div class="preview-widget">
                <div class="preview-header">
                    <i class="fa-solid fa-eye"></i> Pratinjau Nilai Berjalan
                </div>

                <div class="preview-row">
                    <span class="preview-label">Laki-laki</span>
                    <span class="preview-val" id="previewMale">0 Jiwa</span>
                </div>
                <div class="preview-row" id="previewMalePercentRow" style="margin-top: -10px; margin-bottom: 15px; display: none;">
                    <span class="preview-label"></span>
                    <span style="font-size: 0.85rem; color: #93c5fd;" id="previewMalePercent">0% dari total</span>
                </div>

                <div class="preview-row">
                    <span class="preview-label">Perempuan</span>
                    <span class="preview-val" id="previewFemale">0 Jiwa</span>
                </div>
                <div class="preview-row" id="previewFemalePercentRow" style="margin-top: -10px; margin-bottom: 15px; display: none;">
                    <span class="preview-label"></span>
                    <span style="font-size: 0.85rem; color: #93c5fd;" id="previewFemalePercent">0% dari total</span>
                </div>

                <div class="preview-total-box">
                    <div style="font-size: 0.85rem; color: #94a3b8; font-weight: 700; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Total Penduduk</div>
                    <div style="font-size: 1.85rem; font-weight: 800; color: #fff;" id="previewTotal">0 Jiwa</div>
                </div>
            </div>

            <!-- LAST UPDATED INFO CARD -->
            <div class="card" style="padding: 20px; background-color: #f8fafc; border: 1px solid var(--border-color);">
                <h4 style="font-size: 0.8rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; margin-top: 0;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Informasi Terakhir
                </h4>
                <div style="font-size: 0.9rem; font-weight: 700; color: var(--text-dark); line-height: 1.5;">
                    Terakhir Diperbarui:
                </div>
                <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px; line-height: 1.5;">
                    {{ $statistic->updated_at ? $statistic->updated_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('DD MMMM YYYY') : now('Asia/Jakarta')->locale('id')->isoFormat('DD MMMM YYYY') }} <br>
                    Pukul {{ $statistic->updated_at ? $statistic->updated_at->timezone('Asia/Jakarta')->format('H.i') : now('Asia/Jakarta')->format('H.i') }} WIB <br>
                    oleh: <strong style="color: var(--text-dark);">{{ Auth::user()->name ?? 'Admin Desa' }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- CUSTOM CONFIRMATION MODAL -->
    <div class="custom-modal" id="confirmModal">
        <div class="modal-content">
            <h3 class="modal-title">
                <i class="fa-solid fa-circle-question" style="color: var(--primary-light); font-size: 1.4rem;"></i>
                Konfirmasi Penyimpanan
            </h3>
            <p style="color: var(--text-muted); line-height: 1.5; font-size: 0.95rem; margin-bottom: 20px;">
                Apakah Anda yakin ingin menyimpan perubahan statistik penduduk?
            </p>
            
            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); padding: 15px; border-radius: var(--radius-md); margin-bottom: 10px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem;">
                    <span style="color: var(--text-muted);">Laki-laki:</span>
                    <strong style="color: var(--text-dark);" id="modalMale">0 Jiwa</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem;">
                    <span style="color: var(--text-muted);">Perempuan:</span>
                    <strong style="color: var(--text-dark);" id="modalFemale">0 Jiwa</strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 8px; font-weight: 700; font-size: 0.95rem;">
                    <span style="color: var(--text-dark);">Total:</span>
                    <strong style="color: var(--primary-light);" id="modalTotal">0 Jiwa</strong>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn" id="modalBtnCancel" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px 20px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                    Batal
                </button>
                <button type="button" class="btn btn-primary" id="modalBtnConfirm" style="padding: 10px 24px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const type = "{{ $type }}";
        const initialDetails = @json($statistic->details);
        let currentDetails = JSON.parse(JSON.stringify(initialDetails));

        const tableBody = document.getElementById('tableBody');
        const footerMale = document.getElementById('footerMale');
        const footerFemale = document.getElementById('footerFemale');
        const footerTotal = document.getElementById('footerTotal');

        const previewMale = document.getElementById('previewMale');
        const previewFemale = document.getElementById('previewFemale');
        const previewTotal = document.getElementById('previewTotal');
        
        const previewMalePercentRow = document.getElementById('previewMalePercentRow');
        const previewMalePercent = document.getElementById('previewMalePercent');
        const previewFemalePercentRow = document.getElementById('previewFemalePercentRow');
        const previewFemalePercent = document.getElementById('previewFemalePercent');

        const unsavedIndicator = document.getElementById('unsavedIndicator');
        const confirmModal = document.getElementById('confirmModal');
        const statsForm = document.getElementById('statsForm');

        const modalMale = document.getElementById('modalMale');
        const modalFemale = document.getElementById('modalFemale');
        const modalTotal = document.getElementById('modalTotal');

        // Form Period inputs
        const semesterInput = document.getElementById('semester');
        const yearInput = document.getElementById('year');
        const sourceInput = document.getElementById('source');

        const initialPeriod = {
            semester: semesterInput.value,
            year: yearInput.value,
            source: sourceInput.value
        };

        // Render the details table rows
        function renderTable() {
            tableBody.innerHTML = '';
            
            currentDetails.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid var(--border-color)';
                
                let labelHtml = '';
                if (type === 'age') {
                    labelHtml = `
                        <input type="text" name="details[${index}][label]" class="form-control row-label-input" 
                            value="${row.label}" required style="max-width: 250px;">
                        <div class="error-feedback row-label-error">Label tidak boleh kosong.</div>
                    `;
                } else {
                    labelHtml = `
                        <span style="font-weight: 700; color: var(--text-dark);">${row.label}</span>
                        <input type="hidden" name="details[${index}][label]" value="${row.label}">
                    `;
                }

                let deleteCell = '';
                if (type === 'age') {
                    deleteCell = `
                        <td style="padding: 12px; text-align: center;">
                            <button type="button" class="btn btn-danger btn-delete-row" data-index="${index}" style="padding: 6px 12px; background-color: #ef4444; border-color: #ef4444; color: #fff; cursor: pointer;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    `;
                }

                tr.innerHTML = `
                    <td style="padding: 12px; vertical-align: middle;">
                        ${labelHtml}
                        <input type="hidden" name="details[${index}][id]" value="${row.id || ''}">
                    </td>
                    <td style="padding: 12px;">
                        <input type="number" name="details[${index}][male]" class="form-control row-male-input" 
                            value="${row.male_total}" min="0" step="1" required style="max-width: 140px;">
                        <div class="error-feedback row-male-error">Harus angka & >= 0.</div>
                    </td>
                    <td style="padding: 12px;">
                        <input type="number" name="details[${index}][female]" class="form-control row-female-input" 
                            value="${row.female_total}" min="0" step="1" required style="max-width: 140px;">
                        <div class="error-feedback row-female-error">Harus angka & >= 0.</div>
                    </td>
                    <td style="padding: 12px; vertical-align: middle; font-weight: 700; color: var(--text-dark);" class="row-total-val">
                        0
                    </td>
                    <td style="padding: 12px; vertical-align: middle; color: var(--text-muted); font-size: 0.85rem;" class="row-percent-val">
                        0%
                    </td>
                    ${deleteCell}
                `;

                tableBody.appendChild(tr);
            });

            // Bind listeners for inputs
            bindRowListeners();
            calculateTotals();
        }

        // Bind keyup/change listeners to inputs in table
        function bindRowListeners() {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach((tr, index) => {
                const labelInput = tr.querySelector('.row-label-input');
                const maleInput = tr.querySelector('.row-male-input');
                const femaleInput = tr.querySelector('.row-female-input');

                if (labelInput) {
                    labelInput.addEventListener('input', function() {
                        currentDetails[index].label = this.value;
                        validateInput(this, this.value.trim() !== '', tr.querySelector('.row-label-error'));
                        checkDirty();
                    });
                }

                maleInput.addEventListener('input', function() {
                    const val = parseInt(this.value);
                    currentDetails[index].male_total = isNaN(val) ? 0 : val;
                    validateInput(this, !isNaN(val) && val >= 0, tr.querySelector('.row-male-error'));
                    calculateTotals();
                    checkDirty();
                });

                femaleInput.addEventListener('input', function() {
                    const val = parseInt(this.value);
                    currentDetails[index].female_total = isNaN(val) ? 0 : val;
                    validateInput(this, !isNaN(val) && val >= 0, tr.querySelector('.row-female-error'));
                    calculateTotals();
                    checkDirty();
                });
            });

            // Bind delete button listeners
            if (type === 'age') {
                const deleteBtns = tableBody.querySelectorAll('.btn-delete-row');
                deleteBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const idx = parseInt(this.getAttribute('data-index'));
                        currentDetails.splice(idx, 1);
                        renderTable();
                        checkDirty();
                    });
                });
            }
        }

        // Validate an input field visually
        function validateInput(input, isValid, errorElement) {
            if (isValid) {
                input.classList.remove('is-invalid');
                if (errorElement) errorElement.style.display = 'none';
            } else {
                input.classList.add('is-invalid');
                if (errorElement) errorElement.style.display = 'block';
            }
        }

        // Calculate and refresh all totals
        function calculateTotals() {
            let sumMale = 0;
            let sumFemale = 0;
            let sumTotal = 0;

            // Recalculate row totals
            const rows = tableBody.querySelectorAll('tr');
            currentDetails.forEach((row, index) => {
                const rTotal = row.male_total + row.female_total;
                sumMale += row.male_total;
                sumFemale += row.female_total;
                sumTotal += rTotal;

                if (rows[index]) {
                    rows[index].querySelector('.row-total-val').innerText = rTotal.toLocaleString('id-ID');
                }
            });

            // Update footer totals
            footerMale.innerText = sumMale.toLocaleString('id-ID');
            footerFemale.innerText = sumFemale.toLocaleString('id-ID');
            footerTotal.innerText = sumTotal.toLocaleString('id-ID');

            // Update dynamic percentages per row
            currentDetails.forEach((row, index) => {
                const rTotal = row.male_total + row.female_total;
                let percent = 0;
                if (sumTotal > 0) {
                    percent = ((rTotal / sumTotal) * 100).toFixed(2);
                }

                if (rows[index]) {
                    rows[index].querySelector('.row-percent-val').innerText = percent + '%';
                }
            });

            // Update preview widget
            previewMale.innerText = sumMale.toLocaleString('id-ID') + ' Jiwa';
            previewFemale.innerText = sumFemale.toLocaleString('id-ID') + ' Jiwa';
            previewTotal.innerText = sumTotal.toLocaleString('id-ID') + ' Jiwa';

            if (type === 'gender' && sumTotal > 0) {
                previewMalePercentRow.style.display = 'flex';
                previewFemalePercentRow.style.display = 'flex';
                previewMalePercent.innerText = ((sumMale / sumTotal) * 100).toFixed(2) + '% dari total';
                previewFemalePercent.innerText = ((sumFemale / sumTotal) * 100).toFixed(2) + '% dari total';
            } else {
                previewMalePercentRow.style.display = 'none';
                previewFemalePercentRow.style.display = 'none';
            }
        }

        // Check if there are unsaved changes
        function checkDirty() {
            let isDirty = false;

            // Check period inputs
            if (semesterInput.value !== initialPeriod.semester ||
                yearInput.value !== initialPeriod.year ||
                sourceInput.value !== initialPeriod.source) {
                isDirty = true;
            }

            // Check if pdf file has a value selected
            const pdfInput = document.getElementById('pdf_file');
            if (pdfInput && pdfInput.files.length > 0) {
                isDirty = true;
            }

            // Check details list length
            if (currentDetails.length !== initialDetails.length) {
                isDirty = true;
            } else {
                // Check details content
                for (let i = 0; i < currentDetails.length; i++) {
                    if (currentDetails[i].label !== initialDetails[i].label ||
                        currentDetails[i].male_total !== initialDetails[i].male_total ||
                        currentDetails[i].female_total !== initialDetails[i].female_total) {
                        isDirty = true;
                        break;
                    }
                }
            }

            if (isDirty) {
                unsavedIndicator.style.display = 'flex';
            } else {
                unsavedIndicator.style.display = 'none';
            }
        }

        // Handle Add Row for Age group
        if (type === 'age') {
            const btnAddRow = document.getElementById('btnAddRow');
            btnAddRow.addEventListener('click', function() {
                currentDetails.push({
                    id: null,
                    label: '',
                    male_total: 0,
                    female_total: 0,
                    percentage: 0
                });
                renderTable();
                checkDirty();
            });
        }

        // Listeners for period fields redirection
        function handlePeriodChange() {
            const selectedYear = yearInput.value;
            const selectedSemester = semesterInput.value;
            
            // Check if values changed from initial loaded values
            if (selectedYear != "{{ $statistic->year }}" || selectedSemester != "{{ $statistic->semester }}") {
                let proceed = true;
                
                // If form is dirty, confirm navigation
                checkDirty();
                const isDirty = (unsavedIndicator.style.display === 'flex');
                if (isDirty) {
                    proceed = confirm('Anda memiliki perubahan data yang belum disimpan. Pindah ke periode ini akan membatalkan perubahan Anda. Apakah Anda ingin melanjutkan?');
                }
                
                if (proceed) {
                    window.location.href = "{{ route('admin.statistics.edit', $type) }}?year=" + selectedYear + "&semester=" + selectedSemester;
                } else {
                    // Reset inputs to original loaded values
                    yearInput.value = "{{ $statistic->year }}";
                    semesterInput.value = "{{ $statistic->semester }}";
                }
            }
        }

        semesterInput.addEventListener('change', handlePeriodChange);
        yearInput.addEventListener('change', handlePeriodChange);

        sourceInput.addEventListener('input', function() {
            validateInput(this, this.value.trim() !== '', document.getElementById('source-error'));
            checkDirty();
        });

        // Listener for pdf file field
        const pdfInput = document.getElementById('pdf_file');
        if (pdfInput) {
            pdfInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const isValid = file.type === 'application/pdf' && file.size <= 5 * 1024 * 1024;
                    validateInput(this, isValid, document.getElementById('pdf_file-error'));
                } else {
                    validateInput(this, true, document.getElementById('pdf_file-error'));
                }
                checkDirty();
            });
        }

        // Reset Button action
        document.getElementById('btnReset').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin membatalkan semua perubahan dan mereset form ke data semula?')) {
                currentDetails = JSON.parse(JSON.stringify(initialDetails));
                semesterInput.value = initialPeriod.semester;
                yearInput.value = initialPeriod.year;
                sourceInput.value = initialPeriod.source;
                
                if (pdfInput) {
                    pdfInput.value = '';
                }
                
                // Clear any invalid styling
                document.querySelectorAll('.form-control').forEach(input => {
                    input.classList.remove('is-invalid');
                });
                document.querySelectorAll('.error-feedback').forEach(err => {
                    err.style.display = 'none';
                });

                renderTable();
                checkDirty();
            }
        });

        // Form Submit interception for Confirmation Modal
        statsForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Client-side final validation check
            let hasError = false;
            
            // Check Year
            if (!yearInput.value) {
                hasError = true;
            }

            // Check Source
            if (sourceInput.value.trim() === '') {
                validateInput(sourceInput, false, document.getElementById('source-error'));
                hasError = true;
            }

            // Check rows
            const rows = tableBody.querySelectorAll('tr');
            currentDetails.forEach((row, index) => {
                const tr = rows[index];
                if (tr) {
                    const labelInput = tr.querySelector('.row-label-input');
                    const maleInput = tr.querySelector('.row-male-input');
                    const femaleInput = tr.querySelector('.row-female-input');

                    if (labelInput && labelInput.value.trim() === '') {
                        validateInput(labelInput, false, tr.querySelector('.row-label-error'));
                        hasError = true;
                    }
                    
                    const mVal = parseInt(maleInput.value);
                    if (isNaN(mVal) || mVal < 0) {
                        validateInput(maleInput, false, tr.querySelector('.row-male-error'));
                        hasError = true;
                    }

                    const fVal = parseInt(femaleInput.value);
                    if (isNaN(fVal) || fVal < 0) {
                        validateInput(femaleInput, false, tr.querySelector('.row-female-error'));
                        hasError = true;
                    }
                }
            });

            if (hasError) {
                alert('Tolong periksa kembali inputan Anda. Terdapat data yang tidak valid atau kosong.');
                return false;
            }

            // Populate and show custom confirmation modal
            let sumMale = 0;
            let sumFemale = 0;
            currentDetails.forEach(row => {
                sumMale += row.male_total;
                sumFemale += row.female_total;
            });
            const sumTotal = sumMale + sumFemale;

            modalMale.innerText = sumMale.toLocaleString('id-ID') + ' Jiwa';
            modalFemale.innerText = sumFemale.toLocaleString('id-ID') + ' Jiwa';
            modalTotal.innerText = sumTotal.toLocaleString('id-ID') + ' Jiwa';

            confirmModal.style.display = 'flex';
        });

        // Modal Action listeners
        document.getElementById('modalBtnCancel').addEventListener('click', function() {
            confirmModal.style.display = 'none';
        });

        document.getElementById('modalBtnConfirm').addEventListener('click', function() {
            confirmModal.style.display = 'none';
            statsForm.submit(); // submit form for real
        });

        // Initialize table
        renderTable();
    });
</script>
@endsection
