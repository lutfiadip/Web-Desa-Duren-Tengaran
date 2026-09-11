@extends('layouts.app')

@section('title', 'Statistik Penduduk - Pemerintah Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .stats-hero {
        background: linear-gradient(180deg, rgba(30, 58, 138, 0.9) 0%, rgba(30, 58, 138, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 100px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .stats-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    .stats-hero p {
        font-size: 1.1rem;
        color: #e2e8f0;
        max-width: 700px;
        margin: 0 auto;
    }

    /* --- BREADCRUMB --- */
    .breadcrumb {
        position: absolute;
        top: 30px;
        left: 5%;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .breadcrumb a:hover {
        color: var(--white);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
    }

    /* --- STATS CONTAINER --- */
    .stats-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5% 80px;
    }

    /* --- SUMMARY CARD --- */
    .summary-section {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 20px;
        margin-bottom: 50px;
    }

    @media (min-width: 576px) {
        .summary-section {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .summary-section {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
    }

    .summary-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: var(--transition);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background-color: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .summary-icon.rose {
        background-color: #fff1f2;
        color: #f43f5e;
    }

    .summary-icon.amber {
        background-color: #fffbeb;
        color: #f59e0b;
    }

    .summary-info h3 {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        min-height: 34px;
        display: flex;
        align-items: center;
    }

    .summary-info .val {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.2;
    }

    /* --- CHART GRID --- */
    .chart-grid {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .chart-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .chart-header {
        margin-bottom: 30px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 15px;
    }

    .chart-title h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 6px;
        margin-top: 0;
    }

    .chart-title p {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin: 0;
    }

    .chart-source {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-muted);
    }

    .chart-content-grid {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .chart-wrapper {
        position: relative;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .btn-pdf-download:hover {
        background-color: #dc2626 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5) !important;
    }

    /* --- TABS --- */
    .category-tabs-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .category-tab-btn {
        background-color: var(--white);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 12px 28px;
        font-size: 1rem;
        font-weight: 700;
        border-radius: var(--radius-pill);
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
    }

    .category-tab-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .category-tab-btn.active {
        background-color: var(--primary);
        border-color: var(--primary);
        color: var(--white);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);
    }

    .chart-card.hidden {
        display: none !important;
    }

    /* --- PERIOD FILTER BAR --- */
    .period-filter-wrapper {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 24px 30px;
        margin-bottom: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .period-filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border-color);
    }

    .period-filter-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .period-filter-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background-color: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .period-filter-title-box h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 4px 0;
    }

    .period-filter-title-box p {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin: 0;
    }

    .period-filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .period-filter-form {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .period-select-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .period-select-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .period-select-box {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .period-select {
        padding: 10px 38px 10px 16px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background-color: #f8fafc;
        color: var(--text-dark);
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        outline: none;
        transition: var(--transition);
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    #filterYear {
        width: 120px;
    }

    #filterSemester {
        width: 230px;
    }

    .period-select::-ms-expand {
        display: none;
    }

    .period-select:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .select-arrow-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
        font-size: 0.82rem;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s ease;
    }

    .period-select-box:focus-within .select-arrow-icon,
    .period-select-box.is-open .select-arrow-icon {
        transform: translateY(-50%) rotate(180deg);
        color: var(--primary);
    }

    .btn-filter-period {
        padding: 10px 22px;
        background-color: var(--primary, #2563eb) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: var(--radius-md, 8px);
        font-weight: 700;
        font-size: 0.92rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        outline: none;
        user-select: none;
        -webkit-user-select: none;
    }

    .btn-filter-period * {
        color: #ffffff !important;
    }

    .btn-filter-period:hover {
        background-color: #1d4ed8 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    }

    .btn-filter-period:active,
    .btn-filter-period:focus,
    .btn-filter-period:focus-visible {
        background-color: #1e40af !important;
        color: #ffffff !important;
        transform: translateY(0);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.35);
    }

    .btn-filter-period:disabled,
    .btn-filter-period.loading {
        background-color: #2563eb !important;
        color: #ffffff !important;
        opacity: 0.9;
        cursor: wait;
        transform: none !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-filter-period.btn-pending {
        background-color: #2563eb !important;
        color: #ffffff !important;
        animation: pulseButton 1.5s infinite;
    }

    @keyframes pulseButton {
        0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.5); }
        70% { box-shadow: 0 0 0 8px rgba(37, 99, 235, 0); }
        100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
    }

    @media (max-width: 768px) {
        .period-filter-wrapper {
            padding: 18px 20px;
        }

        .period-filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
        }

        .period-select-group {
            flex-direction: column;
            align-items: stretch;
            gap: 6px;
        }
        
        #filterYear, #filterSemester {
            width: 100%;
        }

        .btn-filter-period {
            justify-content: center;
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
    @php
        // Try to identify standard categories for summary cards
        $genderStat = collect($statisticsData)->first(fn($item) => $item['type']->slug === 'gender');
        $kkStat = collect($statisticsData)->first(fn($item) => $item['type']->slug === 'family_card');
    @endphp

    <!-- HERO HEADER -->
    <section class="stats-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Statistik Penduduk</span>
        </nav>
        <h1>Statistik Penduduk</h1>
        <p>{{ $profile->statistics_page_description ?? 'Visualisasi data demografi penduduk Desa Duren secara transparan berdasarkan data kependudukan resmi semester dan tahun terbaru.' }}</p>
    </section>

    <!-- STATS CONTAINER -->
    <div class="stats-container">

        <!-- PERIOD FILTER BAR -->
        <div class="period-filter-wrapper">
            <!-- TOP: Title & Active Period Status -->
            <div class="period-filter-header">
                <div class="period-filter-header-left">
                    <div class="period-filter-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="period-filter-title-box">
                        <h3>Periode Data Kependudukan</h3>
                        <p>Pilih tahun dan semester di bawah ini, lalu klik tombol <strong>Terapkan</strong> untuk memuat data.</p>
                    </div>
                </div>
                <div class="period-filter-badge">
                    <i class="fa-solid fa-circle-check"></i> Data Ditampilkan: <strong>Semester {{ $selectedSemester == 1 ? 'I (Ganjil)' : 'II (Genap)' }} {{ $selectedYear }}</strong>
                </div>
            </div>

            <!-- BOTTOM: Form Controls Underneath Title -->
            <form action="{{ route('statistics') }}" method="GET" class="period-filter-form" id="periodFilterForm">
                <div class="period-select-group">
                    <label for="filterYear" class="period-select-label"><i class="fa-solid fa-calendar-days"></i> Tahun:</label>
                    <div class="period-select-box">
                        <select name="year" id="filterYear" class="period-select">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down select-arrow-icon"></i>
                    </div>
                </div>

                <div class="period-select-group">
                    <label for="filterSemester" class="period-select-label"><i class="fa-solid fa-clock"></i> Semester:</label>
                    <div class="period-select-box">
                        <select name="semester" id="filterSemester" class="period-select">
                            <option value="1" {{ $selectedSemester == 1 ? 'selected' : '' }}>Semester I (Ganjil)</option>
                            <option value="2" {{ $selectedSemester == 2 ? 'selected' : '' }}>Semester II (Genap)</option>
                        </select>
                        <i class="fa-solid fa-chevron-down select-arrow-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-filter-period" id="btnFilterSubmit">
                    <i class="fa-solid fa-check"></i> Terapkan
                </button>
            </form>
        </div>

        @if(count($statisticsData) > 0)
            <!-- SUMMARY SECTION -->
            <div class="summary-section">
                @if($genderStat)
                    <!-- Total Penduduk -->
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="summary-info">
                            <h3>Total Penduduk</h3>
                            <div class="val">{{ number_format($genderStat['grand_total'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Laki-laki -->
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fa-solid fa-person"></i>
                        </div>
                        <div class="summary-info">
                            <h3>Laki-Laki</h3>
                            <div class="val">{{ number_format($genderStat['total_male'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Perempuan -->
                    <div class="summary-card">
                        <div class="summary-icon rose">
                            <i class="fa-solid fa-person-dress"></i>
                        </div>
                        <div class="summary-info">
                            <h3>Perempuan</h3>
                            <div class="val">{{ number_format($genderStat['total_female'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endif

                <!-- Kepala Keluarga -->
                @if($kkStat)
                    <div class="summary-card">
                        <div class="summary-icon amber">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div class="summary-info">
                            <h3>Total Kepala Keluarga</h3>
                            <div class="val">
                                {{ number_format($kkStat['details']->where('label', 'Sudah Memiliki KK')->first()->total ?? ($kkStat['grand_total']), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- CATEGORY TABS -->
            <div class="category-tabs-container">
                @php $activeTabSet = false; @endphp
                @foreach($statisticsData as $item)
                    <button class="category-tab-btn {{ !$activeTabSet ? 'active' : '' }}" data-category-slug="{{ $item['type']->slug }}">
                        {{ $item['type']->name }}
                    </button>
                    @php $activeTabSet = true; @endphp
                @endforeach
            </div>

            <!-- CHART GRID -->
            <div class="chart-grid">
                @php $activeSectionSet = false; @endphp
                @foreach($statisticsData as $item)
                    <div id="stat-{{ $item['type']->slug }}" class="chart-card {{ !$activeSectionSet ? '' : 'hidden' }}">
                        @php $activeSectionSet = true; @endphp
                        <div class="chart-header">
                            <div class="chart-title">
                                <h2>Statistik {{ $item['type']->name }}</h2>
                                <p>{{ $item['type']->description ?? 'Visualisasi data ' . strtolower($item['type']->name) . ' Desa Duren.' }}</p>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                @if(!empty($item['statistic']->pdf_file))
                                    <a href="{{ asset($item['statistic']->pdf_file) }}" target="_blank" class="btn-pdf-download" style="display: inline-flex; align-items: center; gap: 8px; background-color: #ef4444; color: #fff; padding: 8px 16px; border-radius: var(--radius-pill); font-weight: 700; text-decoration: none; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25); transition: var(--transition);">
                                        <i class="fa-solid fa-file-pdf"></i> Unduh PDF Data
                                    </a>
                                @endif
                                <div class="chart-source">
                                    <i class="fa-solid fa-database"></i> Sumber: {{ $item['statistic']->source ?? 'Data Desa' }}
                                </div>
                            </div>
                        </div>

                        <div class="chart-content-grid">
                            <!-- Left: Chart -->
                            <div class="chart-wrapper">
                                <div id="chart-{{ $item['type']->slug }}"></div>
                            </div>
                            
                            <!-- Table Data -->
                            <div style="width: 100%; max-width: 800px; margin: 0 auto; overflow-x: auto; background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                                    <h4 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: var(--text-dark);">
                                        Tabel Rincian Data
                                    </h4>
                                </div>
                                @php
                                    $showGenderPct = $item['type']->show_gender_percentage && ($item['details']->contains(fn($d) => $d->male_total > 0 || $d->female_total > 0));
                                @endphp
                                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid var(--border-color); font-weight: 800; color: var(--text-dark);">
                                            <th style="padding: 8px 4px;">Kategori</th>
                                            <th style="padding: 8px 4px; text-align: center;">L</th>
                                            @if($showGenderPct)
                                                <th style="padding: 8px 4px; text-align: center; color: var(--text-muted);">%</th>
                                            @endif
                                            <th style="padding: 8px 4px; text-align: center;">P</th>
                                            @if($showGenderPct)
                                                <th style="padding: 8px 4px; text-align: center; color: var(--text-muted);">%</th>
                                            @endif
                                            <th style="padding: 8px 4px; text-align: center;">Total</th>
                                            <th style="padding: 8px 4px; text-align: center;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item['details'] as $detail)
                                            @php
                                                $malePct = $showGenderPct && $detail->total > 0 ? number_format(($detail->male_total / $detail->total) * 100, 1, ',', '.') . '%' : '';
                                                $femalePct = $showGenderPct && $detail->total > 0 ? number_format(($detail->female_total / $detail->total) * 100, 1, ',', '.') . '%' : '';
                                            @endphp
                                            <tr style="border-bottom: 1px solid var(--border-color);">
                                                <td style="padding: 8px 4px; font-weight: 700; color: var(--text-dark);">{{ $detail->label }}</td>
                                                <td style="padding: 8px 4px; text-align: center;">{{ number_format($detail->male_total, 0, ',', '.') }}</td>
                                                @if($showGenderPct)
                                                    <td style="padding: 8px 4px; text-align: center; color: var(--text-muted); font-weight: 600;">{{ $malePct }}</td>
                                                @endif
                                                <td style="padding: 8px 4px; text-align: center;">{{ number_format($detail->female_total, 0, ',', '.') }}</td>
                                                @if($showGenderPct)
                                                    <td style="padding: 8px 4px; text-align: center; color: var(--text-muted); font-weight: 600;">{{ $femalePct }}</td>
                                                @endif
                                                <td style="padding: 8px 4px; text-align: center; font-weight: 700; color: var(--primary);">{{ number_format($detail->total, 0, ',', '.') }}</td>
                                                <td style="padding: 8px 4px; text-align: center; font-weight: 600; color: var(--text-muted);">{{ $detail->percentage }}%</td>
                                            </tr>
                                        @endforeach
                                        @php
                                            $totalMalePct = $showGenderPct && $item['grand_total'] > 0 ? number_format(($item['total_male'] / $item['grand_total']) * 100, 1, ',', '.') . '%' : '';
                                            $totalFemalePct = $showGenderPct && $item['grand_total'] > 0 ? number_format(($item['total_female'] / $item['grand_total']) * 100, 1, ',', '.') . '%' : '';
                                        @endphp
                                        <tr style="border-top: 2px solid var(--border-color); font-weight: 800; background-color: #f1f5f9; color: var(--text-dark);">
                                            <td style="padding: 8px 4px;">TOTAL</td>
                                            <td style="padding: 8px 4px; text-align: center;">{{ number_format($item['total_male'], 0, ',', '.') }}</td>
                                            @if($showGenderPct)
                                                <td style="padding: 8px 4px; text-align: center; color: var(--text-muted);">{{ $totalMalePct }}</td>
                                            @endif
                                            <td style="padding: 8px 4px; text-align: center;">{{ number_format($item['total_female'], 0, ',', '.') }}</td>
                                            @if($showGenderPct)
                                                <td style="padding: 8px 4px; text-align: center; color: var(--text-muted);">{{ $totalFemalePct }}</td>
                                            @endif
                                            <td style="padding: 8px 4px; text-align: center; color: var(--primary);">{{ number_format($item['grand_total'], 0, ',', '.') }}</td>
                                            <td style="padding: 8px 4px; text-align: center;">100%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        @if($item['statistic']->notes)
                            <div style="margin-top: 25px; padding: 12px 18px; background-color: #f8fafc; border-left: 4px solid var(--primary-light); border-radius: 4px; font-size: 0.85rem; color: var(--text-muted); line-height: 1.5;">
                                <strong>Catatan Keterangan:</strong> {{ $item['statistic']->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="empty-state">
                <i class="fa-solid fa-chart-pie"></i>
                <h3>Data Statistik Belum Tersedia</h3>
                <p style="margin-bottom: 25px; max-width: 550px; margin-left: auto; margin-right: auto;">
                    Data statistik kependudukan untuk periode <strong>Semester {{ $selectedSemester == 1 ? 'I (Ganjil)' : 'II (Genap)' }} Tahun {{ $selectedYear }}</strong> belum tersedia atau belum dipublikasikan.
                </p>
                <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('statistics') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; border-radius: var(--radius-pill); text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
                        <i class="fa-solid fa-rotate-left"></i> Lihat Periode Terbaru
                    </a>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
@if(count($statisticsData) > 0)
    <!-- Load ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const fontName = 'Plus Jakarta Sans, sans-serif';
            const colors = {
                male: '#2563eb', // Royal Blue
                female: '#f43f5e', // Rose Pink
            };

            @foreach($statisticsData as $item)
                (function() {
                    const categories = @json($item['details']->pluck('label'));
                    const maleData = @json($item['details']->pluck('male_total'));
                    const femaleData = @json($item['details']->pluck('female_total'));
                    
                    const options = {
                        series: [
                            {
                                name: 'Laki-laki',
                                data: maleData
                            },
                            {
                                name: 'Perempuan',
                                data: femaleData
                            }
                        ],
                        chart: {
                            type: 'bar',
                            height: {{ count($item['details']) > 6 ? 450 : 300 }},
                            toolbar: { show: false },
                            fontFamily: fontName
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                barHeight: '70%',
                                borderRadius: 4,
                                dataLabels: {
                                    position: 'top'
                                }
                            }
                        },
                        colors: [colors.male, colors.female],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            xaxis: { lines: { show: true } },
                            yaxis: { lines: { show: false } }
                        },
                        xaxis: {
                            categories: categories,
                            labels: {
                                style: {
                                    colors: '#64748b',
                                    fontSize: '11px',
                                    fontWeight: '600'
                                },
                                formatter: function (val) {
                                    return val.toLocaleString('id-ID');
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                minWidth: 100,
                                maxWidth: 250,
                                style: {
                                    colors: '#1e293b',
                                    fontSize: '12px',
                                    fontWeight: '700'
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'center',
                            style: {
                                fontWeight: '600'
                            }
                        },
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function (val) {
                                    return val.toLocaleString('id-ID') + ' Jiwa';
                                }
                            }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#chart-{{ $item['type']->slug }}"), options);
                    chart.render();
                })();
            @endforeach

            // Category Tabs Interactivity
            const tabBtns = document.querySelectorAll('.category-tab-btn');
            const cards = document.querySelectorAll('.chart-card');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to current button
                    this.classList.add('active');

                    // Hide all cards
                    cards.forEach(card => card.classList.add('hidden'));

                    // Show selected card
                    const slug = this.getAttribute('data-category-slug');
                    const targetCard = document.getElementById('stat-' + slug);
                    if (targetCard) {
                        targetCard.classList.remove('hidden');
                        
                        // Force redraw ApexCharts inside visible tab container to compute size correctly
                        setTimeout(() => {
                            window.dispatchEvent(new Event('resize'));
                        }, 50);
                    }
                });
            });

        });
    </script>
@endif

<script>
    // Period filter: interactive arrow animation and manual "Terapkan" submission
    document.addEventListener('DOMContentLoaded', function() {
        const filterYear = document.getElementById('filterYear');
        const filterSemester = document.getElementById('filterSemester');
        const periodFilterForm = document.getElementById('periodFilterForm');
        const btnFilterSubmit = document.getElementById('btnFilterSubmit');

        const initialYear = "{{ $selectedYear }}";
        const initialSemester = "{{ $selectedSemester }}";

        // Interactive chevron rotation animation on focus, click, and blur
        document.querySelectorAll('.period-select-box').forEach(box => {
            const sel = box.querySelector('select');
            if (sel) {
                sel.addEventListener('focus', () => box.classList.add('is-open'));
                sel.addEventListener('blur', () => box.classList.remove('is-open'));
                sel.addEventListener('change', () => box.classList.remove('is-open'));
                sel.addEventListener('click', () => box.classList.toggle('is-open'));
            }
        });

        // Highlight "Terapkan" button when user changes selection
        function checkFilterChanges() {
            if (btnFilterSubmit && filterYear && filterSemester) {
                const hasChanged = (filterYear.value !== initialYear || filterSemester.value !== initialSemester);
                if (hasChanged) {
                    btnFilterSubmit.classList.add('btn-pending');
                } else {
                    btnFilterSubmit.classList.remove('btn-pending');
                }
            }
        }

        if (filterYear) {
            filterYear.addEventListener('change', checkFilterChanges);
        }
        if (filterSemester) {
            filterSemester.addEventListener('change', checkFilterChanges);
        }

        // Handle submit button: show loading state
        if (periodFilterForm) {
            periodFilterForm.addEventListener('submit', function() {
                if (btnFilterSubmit) {
                    btnFilterSubmit.classList.add('loading');
                    btnFilterSubmit.style.pointerEvents = 'none';
                    btnFilterSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="color:#ffffff !important;"></i> <span style="color:#ffffff !important;">Menerapkan...</span>';
                }
            });
        }
    });
</script>
@endsection
