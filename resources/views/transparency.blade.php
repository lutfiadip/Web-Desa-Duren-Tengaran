@extends('layouts.app')

@section('title', 'Akuntabilitas & Transparansi Keuangan - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .trans-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .trans-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .trans-hero p {
        font-size: 1.2rem;
        color: #d1d5db;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* --- BREADCRUMB --- */
    .breadcrumb {
        position: absolute;
        top: 30px;
        left: 5%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
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
        color: var(--accent);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
    }

    /* --- CONTAINER --- */
    .trans-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 50px 5% 80px;
    }

    /* --- YEAR SELECTOR --- */
    .year-selector-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 40px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 20px;
    }

    .year-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .year-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .year-pill {
        padding: 10px 24px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        border-radius: 30px;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .year-pill:hover {
        background: #e2e8f0;
        color: var(--primary);
    }

    .year-pill.active {
        background: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
    }

    /* --- BUDGET SUMMARY GRID --- */
    .budget-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    @media (max-width: 992px) {
        .budget-grid {
            grid-template-columns: 1fr;
        }
    }

    .budget-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 30px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 20px;
        position: relative;
        overflow: visible;
        transition: var(--transition);
        height: auto;
    }

    .budget-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .budget-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
    }

    .card-revenue::after { background: #10b981; }
    .card-spending::after { background: #ef4444; }
    .card-financing::after { background: #3b82f6; }

    .card-header-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .card-revenue .card-header-icon { background: #ecfdf5; color: #10b981; }
    .card-spending .card-header-icon { background: #fef2f2; color: #ef4444; }
    .card-financing .card-header-icon { background: #eff6ff; color: #3b82f6; }

    .budget-card h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #475569;
        margin: 0 0 15px 0;
    }

    .budget-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 8px;
    }

    .budget-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    .budget-value {
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--text-dark);
    }

    .realization-value {
        font-size: 1.35rem;
        font-weight: 800;
    }
    .card-revenue .realization-value { color: #047857; }
    .card-spending .realization-value { color: #b91c1c; }
    .card-financing .realization-value { color: #1d4ed8; }

    /* --- PROGRESS BAR --- */
    .progress-wrapper {
        margin-top: 20px;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .progress-bar-bg {
        width: 100%;
        height: 10px;
        background: #f1f5f9;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 5px;
        transition: width 1s ease-in-out;
    }

    .card-revenue .progress-bar-fill { background: #10b981; }
    .card-spending .progress-bar-fill { background: #ef4444; }
    .card-financing .progress-bar-fill { background: #3b82f6; }

    /* --- BUDGET DETAIL SUB-ITEMS --- */
    .budget-details-list {
        margin-top: 20px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 15px;
    }
    
    .budget-detail-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.85rem;
        margin-bottom: 12px;
        padding: 8px 12px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #f1f5f9;
        transition: var(--transition);
    }
    
    .budget-detail-item:hover {
        background: #f1f5f9;
        transform: translateX(3px);
    }
    
    .badge-percent {
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.72rem;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        width: 58px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
    }

    /* --- SILPA STATS --- */
    .silpa-box {
        background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: var(--radius-lg);
        color: var(--white);
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 50px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .silpa-text h3 {
        font-size: 1.35rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .silpa-text p {
        font-size: 0.95rem;
        color: #94a3b8;
        margin: 0;
    }

    .silpa-amount {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--accent);
        letter-spacing: -0.5px;
    }

    /* --- SECTION TABS --- */
    .tabs-nav {
        display: flex;
        gap: 15px;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 30px;
        overflow-x: auto;
        padding-bottom: 2px;
    }

    .tab-btn {
        background: none;
        border: none;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        transition: var(--transition);
        border-bottom: 3px solid transparent;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-btn:hover {
        color: var(--primary);
    }

    .tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .tab-pane {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- POSTER TAB --- */
    .poster-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .poster-container {
            grid-template-columns: 1fr;
        }
    }

    .poster-img-wrapper {
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        background: #f8fafc;
        position: relative;
        cursor: zoom-in;
    }

    .poster-img-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.4s ease;
    }

    .poster-img-wrapper:hover img {
        transform: scale(1.03);
    }

    .poster-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0) 100%);
        padding: 20px;
        color: var(--white);
        display: flex;
        justify-content: space-between;
        align-items: center;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* --- DOCUMENTS GRID --- */
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .doc-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: var(--transition);
        position: relative;
    }

    .doc-card:hover {
        border-color: rgba(30, 58, 138, 0.3);
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    }

    .doc-icon {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #eff6ff;
        color: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 15px;
    }

    .doc-card h4 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 10px 0;
        line-height: 1.4;
    }

    .doc-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .doc-actions {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 10px;
    }

    .btn-preview {
        background: var(--primary);
        color: var(--white);
        text-align: center;
        padding: 10px;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        border: none;
        transition: var(--transition);
    }

    .btn-preview:hover {
        background: var(--primary-hover);
    }

    .btn-download {
        background: #f1f5f9;
        color: #475569;
        text-align: center;
        padding: 10px;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: var(--transition);
    }

    .btn-download:hover {
        background: #e2e8f0;
        color: var(--text-dark);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="trans-hero">
    <div class="breadcrumb">
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Beranda</a>
        <span class="separator">/</span>
        <a href="{{ route('profile') }}">Pemerintahan</a>
        <span class="separator">/</span>
        <span class="current">Akuntabilitas & Transparansi</span>
    </div>
    <h1>Akuntabilitas & Transparansi</h1>
    <p>{{ $profile->transparency_page_description ?? 'Komitmen keterbukaan informasi publik Pemerintah Desa Duren dalam pengelolaan APBDes, proyek pembangunan fisik, serta inventaris aset desa.' }}</p>
</section>

<!-- Main Container -->
<div class="trans-container">
    @if(!$report)
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 20px; background: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            <i class="fa-solid fa-folder-open" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"></i>
            <h2 style="font-weight: 800; color: var(--text-dark); margin-bottom: 10px;">Belum Ada Data Transparansi</h2>
            <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto; line-height: 1.6;">
                Pemerintah desa sedang mempersiapkan laporan akuntabilitas keuangan dan dokumen transparansi untuk dipublikasikan. Silakan periksa kembali di lain waktu.
            </p>
        </div>
    @else
        <!-- Year Selector Bar -->
        <div class="year-selector-wrap" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 40px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
            <h2 class="year-title" style="font-size: 1.4rem; font-weight: 800; color: var(--text-dark); margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-calendar-days" style="color: var(--primary);"></i>
                Tahun Anggaran APBDes:
            </h2>
            <div style="position: relative;">
                <select onchange="window.location.href = this.value" style="padding: 12px 45px 12px 20px; font-size: 1rem; font-weight: 700; color: var(--text-dark); background-color: var(--white); border: 2px solid var(--border-color); border-radius: 30px; cursor: pointer; outline: none; transition: var(--transition); appearance: none; -webkit-appearance: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); min-width: 160px;">
                    @foreach($years as $yr)
                        <option value="{{ route('transparency', ['year' => $yr->year]) }}" {{ $report->year == $yr->year ? 'selected' : '' }}>
                            Tahun {{ $yr->year }}
                        </option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-muted); font-size: 0.9rem;"></i>
            </div>
        </div>

        @php
            // Calculate Percentages
            $revPercent = $report->revenue_target > 0 ? min(round(($report->revenue_realization / $report->revenue_target) * 100, 1), 100) : 0;
            $spendPercent = $report->spending_target > 0 ? min(round(($report->spending_realization / $report->spending_target) * 100, 1), 100) : 0;
            $finPercent = $report->financing_target > 0 ? min(round(($report->financing_realization / $report->financing_target) * 100, 1), 100) : 0;
            
            // Calculate SILPA (Sisa Lebih Pembiayaan Anggaran)
            // SILPA Realisasi = (Realisasi Pendapatan + Realisasi Pembiayaan) - Realisasi Belanja
            $silpa = ($report->revenue_realization + $report->financing_realization) - $report->spending_realization;
        @endphp

        <!-- APBDes Summary Cards -->
        <div class="budget-grid">
            <!-- Pendapatan Card -->
            <div class="budget-card card-revenue">
                <div>
                    <div class="card-header-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <h3>PENDAPATAN DESA</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Realisasi Sektor:</span>
                        <span class="budget-value realization-value" style="display: block; font-size: 1.8rem; line-height: 1.2; white-space: nowrap;">Rp {{ number_format($report->revenue_realization, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Rincian Pendapatan Sesuai Infografis -->
                @php
                    $revenueDetails = $report->details->where('type', 'revenue');
                @endphp
                <div class="budget-details-list">
                    <h4 style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Rincian Realisasi Pendapatan:</h4>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($revenueDetails as $index => $detail)
                            @php
                                $pct = $report->revenue_realization > 0 ? round(($detail->value / $report->revenue_realization) * 100, 1) : 0;
                                $colors = [
                                    ['bg' => 'rgba(245, 158, 11, 0.15)', 'fg' => '#d97706'],
                                    ['bg' => 'rgba(124, 58, 237, 0.15)', 'fg' => '#7c3aed'],
                                    ['bg' => 'rgba(16, 185, 129, 0.15)', 'fg' => '#059669'],
                                    ['bg' => 'rgba(220, 38, 38, 0.15)', 'fg' => '#dc2626'],
                                    ['bg' => 'rgba(59, 130, 246, 0.15)', 'fg' => '#2563eb'],
                                ];
                                $color = $colors[$index % count($colors)];
                            @endphp
                            <div class="budget-detail-item" style="display: flex; align-items: flex-start; gap: 12px; justify-content: flex-start;">
                                <span class="badge-percent" style="background: {{ $color['bg'] }}; color: {{ $color['fg'] }}; flex-shrink: 0; margin-top: 2px;">{{ number_format($pct, 1, ',', '.') }}%</span>
                                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 0; flex: 1; text-align: left;">
                                    <span style="font-weight: 600; color: #475569; font-size: 0.8rem; line-height: 1.3;">{{ $detail->label }}</span>
                                    <span style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">Rp {{ number_format($detail->value, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Belanja Card -->
            <div class="budget-card card-spending">
                <div>
                    <div class="card-header-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    <h3>BELANJA / PENGELUARAN</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Realisasi Sektor:</span>
                        <span class="budget-value realization-value" style="display: block; font-size: 1.8rem; line-height: 1.2; white-space: nowrap;">Rp {{ number_format($report->spending_realization, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Rincian Belanja Sesuai Infografis -->
                @php
                    $spendingDetails = $report->details->where('type', 'spending');
                @endphp
                <div class="budget-details-list">
                    <h4 style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Rincian Realisasi Belanja:</h4>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($spendingDetails as $index => $detail)
                            @php
                                $pct = $report->spending_realization > 0 ? round(($detail->value / $report->spending_realization) * 100, 1) : 0;
                                $colors = [
                                    ['bg' => 'rgba(220, 38, 38, 0.15)', 'fg' => '#dc2626'],
                                    ['bg' => 'rgba(59, 130, 246, 0.15)', 'fg' => '#2563eb'],
                                    ['bg' => 'rgba(124, 58, 237, 0.15)', 'fg' => '#7c3aed'],
                                    ['bg' => 'rgba(245, 158, 11, 0.15)', 'fg' => '#d97706'],
                                    ['bg' => 'rgba(16, 185, 129, 0.15)', 'fg' => '#059669'],
                                ];
                                $color = $colors[$index % count($colors)];
                            @endphp
                            <div class="budget-detail-item" style="display: flex; align-items: flex-start; gap: 12px; justify-content: flex-start;">
                                <span class="badge-percent" style="background: {{ $color['bg'] }}; color: {{ $color['fg'] }}; flex-shrink: 0; margin-top: 2px;">{{ number_format($pct, 1, ',', '.') }}%</span>
                                <div style="display: flex; flex-direction: column; gap: 4px; min-width: 0; flex: 1; text-align: left;">
                                    <span style="font-weight: 600; color: #475569; font-size: 0.8rem; line-height: 1.3;">{{ $detail->label }}</span>
                                    <span style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">Rp {{ number_format($detail->value, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Navigation Tabs -->
        @php
            $visibleTabs = [];
            if ($profile->transparency_show_apbdes ?? true) $visibleTabs[] = 'poster';
            if ($profile->transparency_show_budget ?? true) $visibleTabs[] = 'budget';
            if ($profile->transparency_show_development ?? true) $visibleTabs[] = 'development';
            if ($profile->transparency_show_asset ?? true) $visibleTabs[] = 'asset';
            if ($profile->transparency_show_report ?? true) $visibleTabs[] = 'reports';

            $activeTab = reset($visibleTabs);
        @endphp

        @if(count($visibleTabs) > 0)
            <div class="tabs-nav">
                @if($profile->transparency_show_apbdes ?? true)
                <button class="tab-btn {{ $activeTab === 'poster' ? 'active' : '' }}" data-tab="tab-poster">
                    <i class="fa-solid fa-image"></i> Infografis APBDes
                </button>
                @endif
                @if($profile->transparency_show_budget ?? true)
                <button class="tab-btn {{ $activeTab === 'budget' ? 'active' : '' }}" data-tab="tab-budget">
                    <i class="fa-solid fa-chart-column"></i> Anggaran & Realisasi
                </button>
                @endif
                @if($profile->transparency_show_development ?? true)
                <button class="tab-btn {{ $activeTab === 'development' ? 'active' : '' }}" data-tab="tab-development">
                    <i class="fa-solid fa-building-flag"></i> Pembangunan & Proyek Fisik
                </button>
                @endif
                @if($profile->transparency_show_asset ?? true)
                <button class="tab-btn {{ $activeTab === 'asset' ? 'active' : '' }}" data-tab="tab-asset">
                    <i class="fa-solid fa-boxes-stacked"></i> Aset & Inventaris Desa
                </button>
                @endif
                @if($profile->transparency_show_report ?? true)
                <button class="tab-btn {{ $activeTab === 'reports' ? 'active' : '' }}" data-tab="tab-reports">
                    <i class="fa-solid fa-folder-closed"></i> Arsip Dokumen Perencanaan
                </button>
                @endif
            </div>

            <!-- Tab Panes Content -->
            
            @if($profile->transparency_show_apbdes ?? true)
            <!-- Tab 1: Infografis APBDes -->
            <div id="tab-poster" class="tab-pane {{ $activeTab === 'poster' ? 'active' : '' }}">
                <div class="poster-container">
                    <div class="poster-img-wrapper" onclick="openPosterModal()">
                        @if($report->apbdes_poster)
                            <img src="{{ asset($report->apbdes_poster) }}" alt="Infografis APBDes Desa Duren Tahun {{ $report->year }}">
                            <div class="poster-overlay">
                                <span><i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk memperbesar gambar</span>
                            </div>
                        @else
                            <div style="padding: 100px 20px; text-align: center; color: #94a3b8; font-weight: 600;">
                                <i class="fa-solid fa-image" style="font-size: 3.5rem; display: block; margin-bottom: 15px; opacity: 0.5;"></i>
                                Gambar Infografis APBDes belum diunggah untuk tahun {{ $report->year }}.
                            </div>
                        @endif
                    </div>
                    <div class="poster-desc">
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--text-dark); margin: 0 0 15px 0;">Infografis APBDes {{ $report->year }}</h3>
                        <p style="color: #475569; font-size: 0.98rem; line-height: 1.7; margin-bottom: 20px;">
                            {{ $profile->transparency_infographics_description ?? 'Infografis merupakan sarana transparansi publik yang dipasang di sudut strategis desa untuk memudahkan warga melihat rincian alokasi anggaran pendapatan desa, anggaran belanja per bidang (pemerintahan, pembangunan, pembinaan, pemberdayaan), dan sisa anggaran secara ringkas dan komunikatif.' }}
                        </p>
                        @if($report->apbdes_poster)
                            <a href="{{ asset($report->apbdes_poster) }}" download class="btn-preview" style="padding: 12px 25px; border-radius: 30px;">
                                <i class="fa-solid fa-download"></i> Unduh Gambar Infografis
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if($profile->transparency_show_budget ?? true)
            <!-- Tab 2: Anggaran & Realisasi (PDFs) -->
            <div id="tab-budget" class="tab-pane {{ $activeTab === 'budget' ? 'active' : '' }}">
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 20px; color: var(--text-dark);">
                    Laporan Keuangan & Realisasi APBDes
                </h3>
                @if($budgetDocs->count() > 0)
                    <div class="docs-grid">
                        @foreach($budgetDocs as $doc)
                            <div class="doc-card">
                                <div>
                                    <div class="doc-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                                    <h4>{{ $doc->title }}</h4>
                                    <div class="doc-meta">
                                        <i class="fa-solid fa-calendar"></i> Tahun {{ $report->year }}
                                    </div>
                                </div>
                                <div class="doc-actions">
                                    <button type="button" class="btn-preview btn-preview-pdf" data-title="{{ $doc->title }}" data-url="{{ asset($doc->file_path) }}">
                                        <i class="fa-solid fa-eye"></i> Lihat PDF
                                    </button>
                                    <a href="{{ asset($doc->file_path) }}" download class="btn-download">
                                        <i class="fa-solid fa-download"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; border: 2px dashed var(--border-color); border-radius: var(--radius-lg); color: var(--text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                        Belum ada lampiran berkas laporan anggaran untuk kategori ini.
                    </div>
                @endif
            </div>
            @endif

            @if($profile->transparency_show_development ?? true)
            <!-- Tab 3: Pembangunan & Proyek Fisik -->
            <div id="tab-development" class="tab-pane {{ $activeTab === 'development' ? 'active' : '' }}">
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 20px; color: var(--text-dark);">
                    Laporan Realisasi Pembangunan & Proyek Fisik Desa
                </h3>
                @if($developmentDocs->count() > 0)
                    <div class="docs-grid">
                        @foreach($developmentDocs as $doc)
                            <div class="doc-card">
                                <div>
                                    <div class="doc-icon"><i class="fa-solid fa-helmet-safety"></i></div>
                                    <h4>{{ $doc->title }}</h4>
                                    <div class="doc-meta">
                                        <i class="fa-solid fa-calendar"></i> Tahun {{ $report->year }}
                                    </div>
                                </div>
                                <div class="doc-actions">
                                    <button type="button" class="btn-preview btn-preview-pdf" data-title="{{ $doc->title }}" data-url="{{ asset($doc->file_path) }}">
                                        <i class="fa-solid fa-eye"></i> Lihat PDF
                                    </button>
                                    <a href="{{ asset($doc->file_path) }}" download class="btn-download">
                                        <i class="fa-solid fa-download"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; border: 2px dashed var(--border-color); border-radius: var(--radius-lg); color: var(--text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                        Belum ada lampiran berkas laporan proyek pembangunan fisik.
                    </div>
                @endif
            </div>
            @endif

            @if($profile->transparency_show_asset ?? true)
            <!-- Tab 4: Aset & Inventaris Desa -->
            <div id="tab-asset" class="tab-pane {{ $activeTab === 'asset' ? 'active' : '' }}">
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 20px; color: var(--text-dark);">
                    Daftar Kekayaan, Aset, & Inventaris Pemerintah Desa
                </h3>
                @if($assetDocs->count() > 0)
                    <div class="docs-grid">
                        @foreach($assetDocs as $doc)
                            <div class="doc-card">
                                <div>
                                    <div class="doc-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                    <h4>{{ $doc->title }}</h4>
                                    <div class="doc-meta">
                                        <i class="fa-solid fa-calendar"></i> Tahun {{ $report->year }}
                                    </div>
                                </div>
                                <div class="doc-actions">
                                    <button type="button" class="btn-preview btn-preview-pdf" data-title="{{ $doc->title }}" data-url="{{ asset($doc->file_path) }}">
                                        <i class="fa-solid fa-eye"></i> Lihat PDF
                                    </button>
                                    <a href="{{ asset($doc->file_path) }}" download class="btn-download">
                                        <i class="fa-solid fa-download"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; border: 2px dashed var(--border-color); border-radius: var(--radius-lg); color: var(--text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                        Belum ada lampiran berkas daftar kekayaan/aset desa.
                    </div>
                @endif
            </div>
            @endif

            @if($profile->transparency_show_report ?? true)
            <!-- Tab 5: Arsip Dokumen Perencanaan -->
            <div id="tab-reports" class="tab-pane {{ $activeTab === 'reports' ? 'active' : '' }}">
                <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 20px; color: var(--text-dark);">
                    Arsip Dokumen Perencanaan Resmi & Dokumen Pendukung Lainnya
                </h3>
                @if($reportDocs->count() > 0)
                    <div class="docs-grid">
                        @foreach($reportDocs as $doc)
                            <div class="doc-card">
                                <div>
                                    <div class="doc-icon"><i class="fa-solid fa-file-lines"></i></div>
                                    <h4>{{ $doc->title }}</h4>
                                    <div class="doc-meta">
                                        <i class="fa-solid fa-calendar"></i> Tahun {{ $report->year }}
                                    </div>
                                </div>
                                <div class="doc-actions">
                                    <button type="button" class="btn-preview btn-preview-pdf" data-title="{{ $doc->title }}" data-url="{{ asset($doc->file_path) }}">
                                        <i class="fa-solid fa-eye"></i> Lihat PDF
                                    </button>
                                    <a href="{{ asset($doc->file_path) }}" download class="btn-download">
                                        <i class="fa-solid fa-download"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; border: 2px dashed var(--border-color); border-radius: var(--radius-lg); color: var(--text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                        Belum ada arsip dokumen perencanaan resmi.
                    </div>
                @endif
            </div>
            @endif
        @else
            <div style="text-align: center; padding: 80px 20px; border: 2px dashed var(--border-color); border-radius: var(--radius-lg); color: var(--text-muted); margin-top: 30px;">
                <i class="fa-solid fa-eye-slash" style="font-size: 3rem; display: block; margin-bottom: 15px; opacity: 0.5;"></i>
                Tidak ada kategori informasi transparansi yang sedang dipublikasikan saat ini.
            </div>
        @endif
    @endif
</div>

<!-- Poster Zoom Modal -->
@if($report && $report->apbdes_poster)
<div id="poster-modal" class="pdf-modal" onclick="closePosterModal()">
    <div style="max-width: 90%; max-height: 90vh; background: none; box-shadow: none;" onclick="event.stopPropagation()">
        <button type="button" onclick="closePosterModal()" style="position: fixed; top: 20px; right: 20px; background: rgba(15, 23, 42, 0.6); border: none; color: white; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; transition: var(--transition);">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img src="{{ asset($report->apbdes_poster) }}" alt="Infografis APBDes" style="max-width: 100%; max-height: 85vh; width: auto; height: auto; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); object-fit: contain;">
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- TABS NAVIGATION ---
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');

            // Set active class on buttons
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Show active pane
            tabPanes.forEach(pane => {
                if (pane.id === targetTab) {
                    pane.classList.add('active');
                } else {
                    pane.classList.remove('active');
                }
            });
        });
    });


    // Close poster modal on pressing Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePosterModal();
        }
    });
});

// --- POSTER MODAL ---
function openPosterModal() {
    const posterModal = document.getElementById('poster-modal');
    if (posterModal) {
        posterModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closePosterModal() {
    const posterModal = document.getElementById('poster-modal');
    if (posterModal) {
        posterModal.classList.remove('active');
        document.body.style.overflow = '';
    }
}
</script>
@endsection
