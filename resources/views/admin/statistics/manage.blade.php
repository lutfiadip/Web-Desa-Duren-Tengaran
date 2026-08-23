@extends('admin.layouts.admin')

@section('title', 'Kelola Statistik - ' . $type->name)

@section('styles')
<style>
    .manage-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .manage-layout {
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

    /* Draggable rows design */
    tr.dragging {
        opacity: 0.5;
        background-color: #f1f5f9;
        border: 2px dashed var(--primary-light);
    }

    tr.drag-over {
        border-top: 2px solid var(--primary-light);
    }

    .drag-handle {
        cursor: grab;
        color: var(--text-muted);
        text-align: center;
        font-size: 1.1rem;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    .btn-add-row {
        background-color: #f1f5f9;
        border: 1px dashed #cbd5e1;
        color: var(--primary-light);
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 15px;
        transition: var(--transition);
    }

    .btn-add-row:hover {
        background-color: #e2e8f0;
        border-color: #94a3b8;
    }
</style>
<!-- Include SweetAlert2 and Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li style="color: var(--text-dark); font-weight: 600;">Kelola {{ $type->name }}</li>
        </ol>
    </nav>

    <!-- Unsaved banner -->
    <div class="unsaved-banner" id="unsavedIndicator">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span>Ada perubahan data yang belum disimpan di halaman ini.</span>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">Kelola Statistik: {{ $type->name }}</h1>
            <p style="color: var(--text-muted); font-size: 1rem;">Isi nilai, kelola kategori kustom, dan upload berkas laporan kependudukan.</p>
        </div>
        <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="manage-layout">
        <!-- LEFT COLUMN: EDIT FORM -->
        <div class="card" style="padding: 30px; background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin: 0;">
            
            <!-- PERIOD FILTER SECTION -->
            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 25px;">
                <h4 style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-top: 0; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-calendar-days"></i> Periode Pengelolaan Statistik
                </h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select id="semester" class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-weight: 600; cursor: pointer; outline: none;">
                            <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester I (Ganjil)</option>
                            <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester II (Genap)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Tahun</label>
                        <select id="year" class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-weight: 600; cursor: pointer; outline: none;">
                            @foreach($filterYears as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- MAIN DATA FORM -->
            <form action="{{ route('admin.statistics.save-manage', $type->id) }}" method="POST" id="statsForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="semester" value="{{ $semester }}">

                <!-- STATISTIC METADATA -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="source">Sumber Data <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="source" id="source" class="form-control" 
                            value="{{ old('source', $statistic->source) }}" placeholder="Masukkan sumber data statistik..." required
                            style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">
                        <div class="error-feedback" id="source-error">Sumber data wajib diisi.</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pdf_file">Upload Dokumen PDF (Opsional)</label>
                        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="form-control"
                            style="width: 100%; padding: 7px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none; background-color: #f8fafc;">
                        <small style="color: var(--text-muted); font-size: 0.75rem; margin-top: 4px; display: block;">
                            Format: PDF. Ukuran maks: 5MB. 
                            @if($statistic->pdf_file)
                                <a href="{{ asset($statistic->pdf_file) }}" target="_blank" style="color: var(--primary-light); font-weight: 700; text-decoration: none; margin-left: 8px;">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat File Aktif
                                </a>
                            @endif
                        </small>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="notes">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Tulis catatan atau penjelasan singkat tentang data statistik ini..." 
                        style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">{{ old('notes', $statistic->notes) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                    <label class="switch">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $statistic->is_published) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span style="font-weight: 700; color: var(--text-dark); font-size: 0.9rem;">Publikasikan data statistik ini secara langsung</span>
                </div>

                <!-- CATEGORIES TABLE -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 25px; margin-bottom: 10px;">
                    <h4 style="font-size: 1.1rem; font-weight: 800; color: var(--text-dark); margin-top: 0; margin-bottom: 15px;">
                        <i class="fa-solid fa-list-ol" style="color: var(--primary-light);"></i> Daftar Kategori Nilai
                    </h4>
                    
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); font-weight: 800; background-color: #f8fafc;">
                                <th style="padding: 12px;">Kategori <span style="color: #ef4444;">*</span></th>
                                <th style="padding: 12px; width: 130px;">Jumlah Laki-laki <span style="color: #ef4444;">*</span></th>
                                <th style="padding: 12px; width: 130px;">Jumlah Perempuan <span style="color: #ef4444;">*</span></th>
                                <th style="padding: 12px; width: 120px;">Total</th>
                                <th style="padding: 12px; width: 80px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Dynamic rows rendered via JS -->
                        </tbody>
                        <tfoot>
                            <tr style="border-top: 2px solid var(--border-color); font-weight: 800; background-color: #f8fafc;" id="tableFooter">
                                <td style="padding: 12px; color: var(--text-dark); text-align: right;">TOTAL KESELURUHAN</td>
                                <td style="padding: 12px; color: var(--text-dark);" id="footerMale">0</td>
                                <td style="padding: 12px; color: var(--text-dark);" id="footerFemale">0</td>
                                <td style="padding: 12px; color: var(--text-dark);" id="footerTotal">0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <button type="button" class="btn-add-row" id="btnAddRow">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori Baru
                </button>

                <!-- BUTTON ACTIONS -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 25px; display: flex; gap: 12px; justify-content: flex-end; margin-top: 30px;">
                    <button type="button" id="btnReset" class="btn" style="background-color: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-color); padding: 12px 25px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Form
                    </button>
                    <a href="{{ route('admin.statistics.index') }}" class="btn" style="background-color: transparent; border: 1px solid var(--border-color); color: var(--text-dark); text-decoration: none; padding: 12px 25px; border-radius: var(--radius-md); font-weight: 700; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                        Batal
                    </a>
                    <button type="submit" id="btnSubmit" class="btn btn-primary" style="padding: 12px 35px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-circle-check"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT COLUMN: FLOATING PREVIEW & LAST UPDATED -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- REALTIME PREVIEW WIDGET -->
            <div class="preview-widget">
                <div class="preview-header">
                    <i class="fa-solid fa-chart-line"></i> Pratinjau Grafik Berjalan
                </div>

                <!-- Canvas element for Chart.js real-time rendering -->
                <div style="background-color: rgba(255,255,255,0.04); border-radius: var(--radius-md); padding: 10px; margin-bottom: 20px;">
                    <canvas id="previewChart" style="max-height: 220px; width: 100%;"></canvas>
                </div>

                <div class="preview-row">
                    <span class="preview-label"><i class="fa-solid fa-mars" style="color: #93c5fd;"></i> Total Laki-laki</span>
                    <span class="preview-val" id="previewMale">0 Warga</span>
                </div>
                <div class="preview-row">
                    <span class="preview-label"><i class="fa-solid fa-venus" style="color: #f472b6;"></i> Total Perempuan</span>
                    <span class="preview-val" id="previewFemale">0 Warga</span>
                </div>
                <div class="preview-row">
                    <span class="preview-label"><i class="fa-solid fa-layer-group" style="color: #cbd5e1;"></i> Jumlah Kategori</span>
                    <span class="preview-val" id="previewCategories">0 Kategori</span>
                </div>

                <div class="preview-total-box">
                    <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 700; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Total Keseluruhan</div>
                    <div style="font-size: 1.85rem; font-weight: 800; color: #fff;" id="previewTotal">0 Warga</div>
                </div>
            </div>

            <!-- LAST UPDATED INFO CARD -->
            <div class="card" style="padding: 20px; background-color: #f8fafc; border: 1px solid var(--border-color); margin: 0;">
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initialDetails = @json($statistic->details);
        let currentDetails = JSON.parse(JSON.stringify(initialDetails));

        const tableBody = document.getElementById('tableBody');
        const footerMale = document.getElementById('footerMale');
        const footerFemale = document.getElementById('footerFemale');
        const footerTotal = document.getElementById('footerTotal');

        const previewMale = document.getElementById('previewMale');
        const previewFemale = document.getElementById('previewFemale');
        const previewCategories = document.getElementById('previewCategories');
        const previewTotal = document.getElementById('previewTotal');
        
        const unsavedIndicator = document.getElementById('unsavedIndicator');
        const statsForm = document.getElementById('statsForm');

        // Form Period inputs
        const semesterInput = document.getElementById('semester');
        const yearInput = document.getElementById('year');
        const sourceInput = document.getElementById('source');
        const notesInput = document.getElementById('notes');
        const isPublishedInput = document.getElementById('is_published');
        const pdfInput = document.getElementById('pdf_file');

        const initialPeriod = {
            semester: semesterInput.value,
            year: yearInput.value,
            source: sourceInput.value,
            notes: notesInput.value,
            is_published: isPublishedInput.checked
        };

        // Listeners for period dropdown navigation
        function handlePeriodChange() {
            const selectedYear = yearInput.value;
            const selectedSemester = semesterInput.value;
            
            if (selectedYear != "{{ $year }}" || selectedSemester != "{{ $semester }}") {
                let proceed = true;
                
                checkDirty();
                const isDirty = (unsavedIndicator.style.display === 'flex');
                if (isDirty) {
                    proceed = confirm('Anda memiliki perubahan data yang belum disimpan. Pindah ke periode ini akan membatalkan perubahan Anda. Apakah Anda ingin melanjutkan?');
                }
                
                if (proceed) {
                    window.location.href = "{{ route('admin.statistics.manage', $type->id) }}?year=" + selectedYear + "&semester=" + selectedSemester;
                } else {
                    semesterInput.value = "{{ $semester }}";
                    yearInput.value = "{{ $year }}";
                }
            }
        }

        semesterInput.addEventListener('change', handlePeriodChange);
        yearInput.addEventListener('change', handlePeriodChange);

        // Chart.js Setup
        const ctx = document.getElementById('previewChart').getContext('2d');
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Laki-Laki',
                        data: [],
                        backgroundColor: '#3b82f6',
                        borderRadius: 4,
                    },
                    {
                        label: 'Perempuan',
                        data: [],
                        backgroundColor: '#f43f5e',
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { color: '#94a3b8', font: { size: 9 } },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    y: {
                        ticks: { color: '#94a3b8', font: { size: 9 } },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#fff', font: { size: 10 } }
                    }
                }
            }
        });

        // Render table rows
        function renderTable() {
            tableBody.innerHTML = '';
            
            currentDetails.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid var(--border-color)';
                
                // Label Input
                const tdLabel = document.createElement('td');
                tdLabel.style.padding = '12px';
                tdLabel.innerHTML = `
                    <input type="text" class="form-control row-label-input" value="${row.label}" required style="width: 100%; padding: 8px 10px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">
                    <div class="error-feedback row-label-error">Label kategori wajib diisi.</div>
                `;
                tr.appendChild(tdLabel);

                // Male Input
                const tdMale = document.createElement('td');
                tdMale.style.padding = '12px';
                tdMale.innerHTML = `
                    <input type="number" class="form-control row-male-input" value="${row.male_total}" min="0" required style="width: 100%; padding: 8px 10px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">
                    <div class="error-feedback row-male-error">Jumlah wajib angka dan minimal 0.</div>
                `;
                tr.appendChild(tdMale);

                // Female Input
                const tdFemale = document.createElement('td');
                tdFemale.style.padding = '12px';
                tdFemale.innerHTML = `
                    <input type="number" class="form-control row-female-input" value="${row.female_total}" min="0" required style="width: 100%; padding: 8px 10px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">
                    <div class="error-feedback row-female-error">Jumlah wajib angka dan minimal 0.</div>
                `;
                tr.appendChild(tdFemale);

                // Total calculated read-only
                const tdTotal = document.createElement('td');
                tdTotal.style.padding = '12px';
                tdTotal.style.fontWeight = '700';
                tdTotal.style.color = 'var(--text-dark)';
                const total = parseInt(row.male_total) + parseInt(row.female_total);
                tdTotal.innerText = isNaN(total) ? 0 : total.toLocaleString('id-ID');
                tr.appendChild(tdTotal);

                // Delete Action Button
                const tdDelete = document.createElement('td');
                tdDelete.style.padding = '12px';
                tdDelete.style.textAlign = 'center';
                tdDelete.innerHTML = `
                    <button type="button" class="btn btn-delete-row" style="padding: 6px 12px; background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; border-radius: var(--radius-md); cursor: pointer;" title="Hapus Kategori">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                `;
                tr.appendChild(tdDelete);

                // Setup Row Event Listeners for Live Editing
                const labelInput = tdLabel.querySelector('.row-label-input');
                const maleInput = tdMale.querySelector('.row-male-input');
                const femaleInput = tdFemale.querySelector('.row-female-input');
                const deleteBtn = tdDelete.querySelector('.btn-delete-row');

                labelInput.addEventListener('input', function() {
                    row.label = this.value;
                    if (this.value.trim() !== '') {
                        clearValidation(this, tdLabel.querySelector('.row-label-error'));
                    }
                    updateCalculations();
                    checkDirty();
                });

                maleInput.addEventListener('input', function() {
                    const val = parseInt(this.value);
                    row.male_total = isNaN(val) ? 0 : val;
                    if (!isNaN(val) && val >= 0) {
                        clearValidation(this, tdMale.querySelector('.row-male-error'));
                    }
                    tdTotal.innerText = (row.male_total + row.female_total).toLocaleString('id-ID');
                    updateCalculations();
                    checkDirty();
                });

                femaleInput.addEventListener('input', function() {
                    const val = parseInt(this.value);
                    row.female_total = isNaN(val) ? 0 : val;
                    if (!isNaN(val) && val >= 0) {
                        clearValidation(this, tdFemale.querySelector('.row-female-error'));
                    }
                    tdTotal.innerText = (row.male_total + row.female_total).toLocaleString('id-ID');
                    updateCalculations();
                    checkDirty();
                });

                deleteBtn.addEventListener('click', function() {
                    if (currentDetails.length <= 1) {
                        alert('Statistik harus memiliki minimal 1 kategori.');
                        return;
                    }
                    currentDetails.splice(index, 1);
                    renderTable();
                    updateCalculations();
                    checkDirty();
                });

                tableBody.appendChild(tr);
            });
        }

        // Add Category row
        document.getElementById('btnAddRow').addEventListener('click', function() {
            currentDetails.push({
                label: 'Kategori Baru',
                male_total: 0,
                female_total: 0,
                display_order: currentDetails.length + 1
            });
            renderTable();
            updateCalculations();
            checkDirty();
        });

        // Input validation styling functions
        function applyValidation(input, errorElement) {
            input.classList.add('is-invalid');
            if (errorElement) {
                errorElement.style.display = 'block';
            }
        }

        function clearValidation(input, errorElement) {
            input.classList.remove('is-invalid');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }

        // Calculate totals and refresh chart
        function updateCalculations() {
            let totalMale = 0;
            let totalFemale = 0;
            
            const labels = [];
            const maleData = [];
            const femaleData = [];

            currentDetails.forEach(row => {
                const m = parseInt(row.male_total);
                const f = parseInt(row.female_total);
                
                totalMale += isNaN(m) ? 0 : m;
                totalFemale += isNaN(f) ? 0 : f;

                labels.push(row.label || 'Kategori Baru');
                maleData.push(isNaN(m) ? 0 : m);
                femaleData.push(isNaN(f) ? 0 : f);
            });

            const grandTotal = totalMale + totalFemale;

            // Update footer totals
            footerMale.innerText = totalMale.toLocaleString('id-ID');
            footerFemale.innerText = totalFemale.toLocaleString('id-ID');
            footerTotal.innerText = grandTotal.toLocaleString('id-ID');

            // Update preview card totals
            previewMale.innerText = totalMale.toLocaleString('id-ID') + ' Warga';
            previewFemale.innerText = totalFemale.toLocaleString('id-ID') + ' Warga';
            previewCategories.innerText = currentDetails.length + ' Kategori';
            previewTotal.innerText = grandTotal.toLocaleString('id-ID') + ' Warga';

            // Refresh Chart.js data
            chart.data.labels = labels;
            chart.data.datasets[0].data = maleData;
            chart.data.datasets[1].data = femaleData;
            chart.update();
        }

        // Reset form to initial state
        document.getElementById('btnReset').addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin membatalkan semua perubahan dan mereset form ke data semula?')) {
                currentDetails = JSON.parse(JSON.stringify(initialDetails));
                semesterInput.value = initialPeriod.semester;
                yearInput.value = initialPeriod.year;
                sourceInput.value = initialPeriod.source;
                notesInput.value = initialPeriod.notes;
                isPublishedInput.checked = initialPeriod.is_published;
                
                if (pdfInput) {
                    pdfInput.value = '';
                }
                
                document.querySelectorAll('.form-control').forEach(input => {
                    input.classList.remove('is-invalid');
                });
                document.querySelectorAll('.error-feedback').forEach(err => {
                    err.style.display = 'none';
                });

                renderTable();
                updateCalculations();
                checkDirty();
            }
        });

        // Check if form is dirty compared to original DB values
        function checkDirty() {
            let isDirty = false;

            // Check metadata
            if (sourceInput.value !== initialPeriod.source ||
                notesInput.value !== initialPeriod.notes ||
                isPublishedInput.checked !== initialPeriod.is_published ||
                (pdfInput && pdfInput.value !== '')) {
                isDirty = true;
            }

            // Check list length
            if (currentDetails.length !== initialDetails.length) {
                isDirty = true;
            } else {
                // Check items values
                for (let i = 0; i < currentDetails.length; i++) {
                    if (currentDetails[i].label !== initialDetails[i].label ||
                        parseInt(currentDetails[i].male_total) !== parseInt(initialDetails[i].male_total) ||
                        parseInt(currentDetails[i].female_total) !== parseInt(initialDetails[i].female_total)) {
                        isDirty = true;
                        break;
                    }
                }
            }

            unsavedIndicator.style.display = isDirty ? 'flex' : 'none';
        }

        // Event listeners to detect dirty state
        sourceInput.addEventListener('input', checkDirty);
        notesInput.addEventListener('input', checkDirty);
        isPublishedInput.addEventListener('change', checkDirty);
        if (pdfInput) {
            pdfInput.addEventListener('change', checkDirty);
        }

        // Form Submit intercept with SweetAlert2 confirmation
        statsForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Client-side validations
            let hasError = false;
            
            // Validate Source
            if (sourceInput.value.trim() === '') {
                applyValidation(sourceInput, document.getElementById('source-error'));
                hasError = true;
            }

            // Validate Rows
            const trRows = tableBody.querySelectorAll('tr');
            currentDetails.forEach((row, index) => {
                const tr = trRows[index];
                if (tr) {
                    const labelInput = tr.querySelector('.row-label-input');
                    const maleInput = tr.querySelector('.row-male-input');
                    const femaleInput = tr.querySelector('.row-female-input');

                    if (labelInput && labelInput.value.trim() === '') {
                        applyValidation(labelInput, tr.querySelector('.row-label-error'));
                        hasError = true;
                    }
                    
                    const mVal = parseInt(maleInput.value);
                    if (isNaN(mVal) || mVal < 0) {
                        applyValidation(maleInput, tr.querySelector('.row-male-error'));
                        hasError = true;
                    }

                    const fVal = parseInt(femaleInput.value);
                    if (isNaN(fVal) || fVal < 0) {
                        applyValidation(femaleInput, tr.querySelector('.row-female-error'));
                        hasError = true;
                    }
                }
            });

            if (hasError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: 'Tolong periksa kembali inputan Anda. Terdapat data yang tidak valid atau kosong.',
                    confirmButtonColor: '#2563eb'
                });
                return false;
            }

            // Calculations for confirmation message
            let sumMale = 0;
            let sumFemale = 0;
            currentDetails.forEach(row => {
                sumMale += parseInt(row.male_total) || 0;
                sumFemale += parseInt(row.female_total) || 0;
            });
            const sumTotal = sumMale + sumFemale;

            // Dynamic payload creation to submit categories array correctly
            // Clear any old dynamically added input fields
            const oldHiddenFields = statsForm.querySelectorAll('.temp-cat-input');
            oldHiddenFields.forEach(el => el.remove());

            // Add categories inputs dynamically
            currentDetails.forEach((row, index) => {
                const hiddenLabel = document.createElement('input');
                hiddenLabel.type = 'hidden';
                hiddenLabel.name = `categories[${index}][label]`;
                hiddenLabel.value = row.label;
                hiddenLabel.className = 'temp-cat-input';

                const hiddenMale = document.createElement('input');
                hiddenMale.type = 'hidden';
                hiddenMale.name = `categories[${index}][male]`;
                hiddenMale.value = row.male_total;
                hiddenMale.className = 'temp-cat-input';

                const hiddenFemale = document.createElement('input');
                hiddenFemale.type = 'hidden';
                hiddenFemale.name = `categories[${index}][female]`;
                hiddenFemale.value = row.female_total;
                hiddenFemale.className = 'temp-cat-input';

                statsForm.appendChild(hiddenLabel);
                statsForm.appendChild(hiddenMale);
                statsForm.appendChild(hiddenFemale);
            });

            // SweetAlert2 Confirmation Dialog
            Swal.fire({
                title: 'Simpan Data Statistik?',
                html: `
                    <p style="margin-bottom:15px; color:#64748b;">Apakah Anda yakin ingin menyimpan perubahan data statistik kependudukan ini?</p>
                    <div style="background-color: #f8fafc; border: 1px solid var(--border-color); padding: 15px; border-radius: 8px; text-align: left; font-size: 0.9rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <span style="color: #64748b;">Total Laki-laki:</span>
                            <strong style="color: #1e293b;">${sumMale.toLocaleString('id-ID')} Warga</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <span style="color: #64748b;">Total Perempuan:</span>
                            <strong style="color: #1e293b;">${sumFemale.toLocaleString('id-ID')} Warga</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-top: 1px solid #e2e8f0; padding-top: 6px; font-weight: 700; margin-top: 6px;">
                            <span style="color: #1e293b;">Total Keseluruhan:</span>
                            <strong style="color: #2563eb; font-size: 1.05rem;">${sumTotal.toLocaleString('id-ID')} Warga</strong>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: '<i class="fa-solid fa-circle-check"></i> Ya, Simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    statsForm.submit();
                }
            });
        });

        // Initialize Form
        renderTable();
        updateCalculations();
    });
</script>
@endsection
