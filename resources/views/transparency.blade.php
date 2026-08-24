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
        grid-template-columns: repeat(3, 1fr);
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
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
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

    /* --- LIGHTBOX MODAL --- */
    .pdf-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
    }

    .pdf-modal.active {
        display: flex;
        opacity: 1;
    }

    .pdf-modal-container {
        background: var(--white);
        border-radius: var(--radius-lg);
        width: 90%;
        max-width: 1000px;
        height: 85vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: modalSlide 0.3s ease;
    }

    @keyframes modalSlide {
        from { transform: translateY(30px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }

    .pdf-modal-header {
        padding: 15px 25px;
        background: #fafafa;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pdf-modal-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-dark);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70%;
    }

    .pdf-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pdf-modal-close:hover {
        color: #ef4444;
        transform: scale(1.1);
    }

    .pdf-modal-body {
        flex-grow: 1;
        background: #f1f5f9;
        position: relative;
    }

    .pdf-iframe {
        width: 100%;
        height: 100%;
        border: none;
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
                    
                    <div style="margin-bottom: 12px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Target Anggaran:</span>
                        <span class="budget-value" style="display: block; font-size: 1.25rem; white-space: nowrap;">Rp {{ number_format($report->revenue_target, 0, ',', '.') }}</span>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Realisasi Sektor:</span>
                        <span class="budget-value realization-value" style="display: block; font-size: 1.6rem; line-height: 1.2; white-space: nowrap;">Rp {{ number_format($report->revenue_realization, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <span>Persentase Realisasi</span>
                        <span>{{ $revPercent }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $revPercent }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Belanja Card -->
            <div class="budget-card card-spending">
                <div>
                    <div class="card-header-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    <h3>BELANJA / PENGELUARAN</h3>
                    
                    <div style="margin-bottom: 12px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Pagu Anggaran:</span>
                        <span class="budget-value" style="display: block; font-size: 1.25rem; white-space: nowrap;">Rp {{ number_format($report->spending_target, 0, ',', '.') }}</span>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Realisasi Sektor:</span>
                        <span class="budget-value realization-value" style="display: block; font-size: 1.6rem; line-height: 1.2; white-space: nowrap;">Rp {{ number_format($report->spending_realization, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <span>Persentase Penyerapan</span>
                        <span>{{ $spendPercent }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $spendPercent }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Pembiayaan Card -->
            <div class="budget-card card-financing">
                <div>
                    <div class="card-header-icon"><i class="fa-solid fa-money-bill-transfer"></i></div>
                    <h3>PEMBIAYAAN DESA</h3>
                    
                    <div style="margin-bottom: 12px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Penerimaan Target:</span>
                        <span class="budget-value" style="display: block; font-size: 1.25rem; white-space: nowrap;">Rp {{ number_format($report->financing_target, 0, ',', '.') }}</span>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <span class="budget-label" style="display: block; margin-bottom: 4px;">Realisasi Sektor:</span>
                        <span class="budget-value realization-value" style="display: block; font-size: 1.6rem; line-height: 1.2; white-space: nowrap;">Rp {{ number_format($report->financing_realization, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="progress-wrapper">
                    <div class="progress-info">
                        <span>Persentase Realisasi</span>
                        <span>{{ $finPercent }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $finPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SILPA Realisasi Box -->
        <div class="silpa-box">
            <div class="silpa-text">
                <h3>Sisa Lebih Pembiayaan Anggaran (SILPA) Tahun {{ $report->year }}</h3>
                <p>Formula Penghitungan: (Realisasi Pendapatan + Realisasi Pembiayaan) &minus; Realisasi Belanja</p>
            </div>
            <div class="silpa-amount">
                Rp {{ number_format($silpa, 0, ',', '.') }}
            </div>
        </div>

        <!-- Section Navigation Tabs -->
        <div class="tabs-nav">
            <button class="tab-btn active" data-tab="tab-poster">
                <i class="fa-solid fa-image"></i> Infografis APBDes
            </button>
            <button class="tab-btn" data-tab="tab-budget">
                <i class="fa-solid fa-chart-column"></i> Anggaran & Realisasi
            </button>
            <button class="tab-btn" data-tab="tab-development">
                <i class="fa-solid fa-building-flag"></i> Pembangunan & Proyek Fisik
            </button>
            <button class="tab-btn" data-tab="tab-asset">
                <i class="fa-solid fa-boxes-stacked"></i> Aset & Inventaris Desa
            </button>
            <button class="tab-btn" data-tab="tab-reports">
                <i class="fa-solid fa-folder-closed"></i> Arsip Dokumen Perencanaan
            </button>
        </div>

        <!-- Tab Panes Content -->
        
        <!-- Tab 1: Infografis APBDes -->
        <div id="tab-poster" class="tab-pane active">
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

        <!-- Tab 2: Anggaran & Realisasi (PDFs) -->
        <div id="tab-budget" class="tab-pane">
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

        <!-- Tab 3: Pembangunan & Proyek Fisik -->
        <div id="tab-development" class="tab-pane">
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

        <!-- Tab 4: Aset & Inventaris Desa -->
        <div id="tab-asset" class="tab-pane">
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

        <!-- Tab 5: Arsip Dokumen Perencanaan -->
        <div id="tab-reports" class="tab-pane">
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
</div>

<!-- Embedded PDF Lightbox Modal -->
<div id="pdf-viewer-modal" class="pdf-modal">
    <div class="pdf-modal-container">
        <div class="pdf-modal-header">
            <h3 id="modal-doc-title" class="pdf-modal-title">Lihat Dokumen</h3>
            <button type="button" onclick="closePdfModal()" class="pdf-modal-close" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdf-iframe-viewer" class="pdf-iframe" src=""></iframe>
        </div>
    </div>
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

    // --- PDF PREVIEW LIGHTBOX ---
    const modal = document.getElementById('pdf-viewer-modal');
    const modalTitle = document.getElementById('modal-doc-title');
    const modalIframe = document.getElementById('pdf-iframe-viewer');
    const previewButtons = document.querySelectorAll('.btn-preview-pdf');

    previewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const title = this.getAttribute('data-title');

            modalTitle.textContent = title;
            // Append #toolbar=1 to instruct native browser PDF viewer to render toolbar
            modalIframe.src = url + '#toolbar=1';

            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Stop background scrolling

            // Force repaint/reflow of iframe to fix Chrome/Edge PDF rendering modal bug
            setTimeout(() => {
                modalIframe.style.width = '99%';
                setTimeout(() => {
                    modalIframe.style.width = '100%';
                }, 50);
            }, 100);
        });
    });
});

function closePdfModal() {
    const modal = document.getElementById('pdf-viewer-modal');
    const modalIframe = document.getElementById('pdf-iframe-viewer');
    
    modal.classList.remove('active');
    modalIframe.src = ''; // Clear source to stop loading/performance footprint
    document.body.style.overflow = ''; // Restore scrolling
}

// Close PDF modal on pressing Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePdfModal();
        closePosterModal();
    }
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
