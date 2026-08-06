@extends('admin.layouts.admin')

@section('title', 'Statistik Penduduk')

@section('styles')
<style>
    .stats-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-manage-card {
        background-color: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transition: var(--transition);
    }

    .stat-manage-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-light);
    }

    .card-banner {
        padding: 24px;
        color: var(--white);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .banner-gender {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    }

    .banner-age {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }

    .banner-kk {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
    }

    .banner-icon {
        font-size: 2rem;
    }

    .banner-title h3 {
        font-size: 1.2rem;
        font-weight: 800;
        margin: 0;
    }

    .banner-title p {
        font-size: 0.85rem;
        opacity: 0.85;
        margin: 2px 0 0 0;
    }

    .card-body-details {
        padding: 24px;
        flex-grow: 1;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.95rem;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-dark);
    }

    .detail-value {
        font-weight: 700;
        color: var(--text-muted);
    }

    .card-footer-action {
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        background-color: #f8fafc;
        display: flex;
        justify-content: flex-end;
    }

    .btn-manage {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background-color: var(--primary-light);
        color: var(--white);
        text-decoration: none;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .btn-manage:hover {
        background-color: var(--primary);
    }
</style>
@endsection

@section('content')
    <!-- Toggle Publikasi Halaman -->
    <div class="card" style="margin-bottom: 25px; padding: 24px; border: 1px solid var(--border-color); border-radius: var(--radius-lg); background-color: var(--white); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0;">
                    <i class="fa-solid fa-globe" style="color: var(--primary-light);"></i> Status Publikasi Halaman Statistik
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; margin-bottom: 0;">Tentukan apakah Halaman Statistik Penduduk & Widget Demografi dipublikasikan di website.</p>
            </div>
            <label class="switch">
                <input type="checkbox" class="global-publish-toggle" data-key="publish_statistics" {{ ($profile->publish_statistics ?? true) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">Manajemen Statistik Penduduk</h1>
            <p style="color: var(--text-muted); font-size: 1rem;">Kelola visualisasi data kependudukan dan demografi Desa Duren.</p>
        </div>

        <!-- Period Filter Dropdowns & Add Period Button -->
        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
            @if($isFiltered)
                <a href="{{ route('admin.statistics.index') }}" class="btn" style="padding: 10px 18px; background-color: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: var(--transition);">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            @endif

            <div class="card" style="padding: 12px 20px; background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-md); display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin: 0;">
                <form action="{{ route('admin.statistics.index') }}" method="GET" style="display: flex; align-items: center; gap: 15px; margin: 0; padding: 0;">
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="filter_semester" style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Semester</label>
                        <select name="semester" id="filter_semester" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600; color: var(--text-dark); background-color: #f8fafc; min-width: 180px; outline: none; cursor: pointer;">
                            <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester I (Ganjil)</option>
                            <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester II (Genap)</option>
                        </select>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="filter_year" style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Tahun</label>
                        <select name="year" id="filter_year" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600; color: var(--text-dark); background-color: #f8fafc; min-width: 100px; outline: none; cursor: pointer;">
                            @foreach($filterYears as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <button type="button" class="btn btn-primary" onclick="openAddPeriodModal()" style="padding: 12px 20px; border-radius: var(--radius-md); font-weight: 700; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);">
                <i class="fa-solid fa-plus"></i> Tambah Periode Baru
            </button>
        </div>
    </div>

    <div class="stats-card-grid">
        <!-- 1. GENDER -->
        <div class="stat-manage-card">
            <div class="card-banner banner-gender">
                <i class="fa-solid fa-venus-mars banner-icon"></i>
                <div class="banner-title">
                    <h3>Jenis Kelamin</h3>
                    <p>Total Penduduk laki-laki dan perempuan</p>
                </div>
            </div>
            <div class="card-body-details">
                @if($gender && $gender->details->count() > 0)
                    <div class="detail-row">
                        <span class="detail-label">Laki-Laki</span>
                        <span class="detail-value">{{ number_format($gender->details->first()->male_total, 0, ',', '.') }} Jiwa</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Perempuan</span>
                        <span class="detail-value">{{ number_format($gender->details->first()->female_total, 0, ',', '.') }} Jiwa</span>
                    </div>
                    <div class="detail-row" style="border-top: 2px solid var(--border-color); padding-top: 15px;">
                        <span class="detail-label">Total Penduduk</span>
                        <span class="detail-value" style="color: var(--primary); font-size: 1.1rem;">
                             {{ number_format($gender->details->first()->male_total + $gender->details->first()->female_total, 0, ',', '.') }} Jiwa
                        </span>
                    </div>
                    <div class="detail-row" style="margin-top: 15px;">
                        <span class="detail-label" style="font-size: 0.8rem; font-weight: 500;">Periode</span>
                        <span class="detail-value" style="font-size: 0.8rem;">Semester {{ $gender->semester }} - {{ $gender->year }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label" style="font-size: 0.8rem; font-weight: 500;">Sumber</span>
                        <span class="detail-value" style="font-size: 0.8rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 200px;">{{ $gender->source }}</span>
                    </div>
                @else
                    <p style="color: var(--text-muted); text-align: center; margin: 40px 0;">Belum ada data diinput untuk periode ini.</p>
                @endif
            </div>
            <div class="card-footer-action">
                <a href="{{ route('admin.statistics.edit', 'gender') }}?year={{ $gender ? $gender->year : $year }}&semester={{ $gender ? $gender->semester : $semester }}" class="btn-manage" style="{{ !$gender ? 'background-color: #10b981;' : '' }}">
                    @if($gender)
                        <i class="fa-solid fa-pen-to-square"></i> Sunting Data
                    @else
                        <i class="fa-solid fa-plus"></i> Tambah Data
                    @endif
                </a>
            </div>
        </div>

        <!-- 2. AGE GROUPS -->
        <div class="stat-manage-card">
            <div class="card-banner banner-age">
                <i class="fa-solid fa-users-rectangle banner-icon"></i>
                <div class="banner-title">
                    <h3>Kelompok Umur</h3>
                    <p>Pembagian rentang umur warga</p>
                </div>
            </div>
            <div class="card-body-details" style="max-height: 270px; overflow-y: auto;">
                @if($age && $age->details->count() > 0)
                    @foreach($age->details as $detail)
                        <div class="detail-row">
                            <span class="detail-label">Umur {{ $detail->label }}</span>
                            <span class="detail-value">{{ number_format($detail->male_total + $detail->female_total, 0, ',', '.') }} Jiwa</span>
                        </div>
                    @endforeach
                    <div class="detail-row" style="border-top: 2px solid var(--border-color); padding-top: 15px;">
                        <span class="detail-label" style="font-size: 0.8rem; font-weight: 500;">Periode</span>
                        <span class="detail-value" style="font-size: 0.8rem;">Semester {{ $age->semester }} - {{ $age->year }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label" style="font-size: 0.8rem; font-weight: 500;">Sumber</span>
                        <span class="detail-value" style="font-size: 0.8rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 200px;">{{ $age->source }}</span>
                    </div>
                @else
                    <p style="color: var(--text-muted); text-align: center; margin: 40px 0;">Belum ada data diinput untuk periode ini.</p>
                @endif
            </div>
            <div class="card-footer-action">
                <a href="{{ route('admin.statistics.edit', 'age') }}?year={{ $age ? $age->year : $year }}&semester={{ $age ? $age->semester : $semester }}" class="btn-manage" style="{{ !$age ? 'background-color: #10b981;' : '' }}">
                    @if($age)
                        <i class="fa-solid fa-pen-to-square"></i> Sunting Data
                    @else
                        <i class="fa-solid fa-plus"></i> Tambah Data
                    @endif
                </a>
            </div>
        </div>

        <!-- 3. FAMILY CARD (KK) -->
        <div class="stat-manage-card">
            <div class="card-banner banner-kk">
                <i class="fa-solid fa-address-card banner-icon"></i>
                <div class="banner-title">
                    <h3>Kepemilikan KK</h3>
                    <p>Status kepemilikan Kartu Keluarga</p>
                </div>
            </div>
            <div class="card-body-details">
                @if($kk && $kk->details->count() > 0)
                    @foreach($kk->details as $detail)
                        <div class="detail-row">
                            <span class="detail-label">{{ $detail->label }}</span>
                            <span class="detail-value">{{ number_format($detail->male_total + $detail->female_total, 0, ',', '.') }} KK</span>
                        </div>
                    @endforeach
                    <div class="detail-row" style="border-top: 2px solid var(--border-color); padding-top: 15px;">
                        <span class="detail-label" style="font-size: 0.8rem; font-weight: 500;">Periode</span>
                        <span class="detail-value" style="font-size: 0.8rem;">Semester {{ $kk->semester }} - {{ $kk->year }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label" style="font-size: 0.8rem; font-weight: 500;">Sumber</span>
                        <span class="detail-value" style="font-size: 0.8rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 200px;">{{ $kk->source }}</span>
                    </div>
                @else
                    <p style="color: var(--text-muted); text-align: center; margin: 40px 0;">Belum ada data diinput untuk periode ini.</p>
                @endif
            </div>
            <div class="card-footer-action">
                <a href="{{ route('admin.statistics.edit', 'family_card') }}?year={{ $kk ? $kk->year : $year }}&semester={{ $kk ? $kk->semester : $semester }}" class="btn-manage" style="{{ !$kk ? 'background-color: #10b981;' : '' }}">
                    @if($kk)
                        <i class="fa-solid fa-pen-to-square"></i> Sunting Data
                    @else
                        <i class="fa-solid fa-plus"></i> Tambah Data
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH PERIODE -->
    <div id="addPeriodModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.6); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
        <div class="card" style="background: #fff; border-radius: var(--radius-lg); padding: 30px; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); margin: 0;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-top: 0;">
                <i class="fa-solid fa-calendar-plus" style="color: var(--primary-light);"></i> Tambah Periode Baru
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="modal_semester" style="font-size: 0.8rem; font-weight: 700; color: var(--text-dark);">Semester</label>
                    <select id="modal_semester" style="padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600; color: var(--text-dark); background-color: #f8fafc; cursor: pointer; outline: none; width: 100%;">
                        <option value="1">Semester I (Ganjil)</option>
                        <option value="2" selected>Semester II (Genap)</option>
                    </select>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="modal_year" style="font-size: 0.8rem; font-weight: 700; color: var(--text-dark);">Tahun</label>
                    <input type="number" id="modal_year" value="{{ date('Y') }}" min="2000" max="2100" style="padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600; color: var(--text-dark); background-color: #f8fafc; outline: none; width: 100%;">
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <button type="button" onclick="closeAddPeriodModal()" class="btn" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px 20px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                    Batal
                </button>
                <button type="button" onclick="submitAddPeriod()" class="btn btn-primary" style="padding: 10px 24px; border-radius: var(--radius-md); font-weight: 700; cursor: pointer;">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        function openAddPeriodModal() {
            document.getElementById('addPeriodModal').style.display = 'flex';
        }
        
        function closeAddPeriodModal() {
            document.getElementById('addPeriodModal').style.display = 'none';
        }
        
        function submitAddPeriod() {
            const sem = document.getElementById('modal_semester').value;
            const year = document.getElementById('modal_year').value;
            if(!year) {
                alert('Tahun harus diisi!');
                return;
            }
            closeAddPeriodModal();
            // Redirect to index page with selected period
            window.location.href = "{{ route('admin.statistics.index') }}?year=" + year + "&semester=" + sem;
        }
    </script>
@endsection
