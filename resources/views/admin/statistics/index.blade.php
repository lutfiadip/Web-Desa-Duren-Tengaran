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
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">Manajemen Statistik Penduduk</h1>
            <p style="color: var(--text-muted); font-size: 1rem;">Kelola visualisasi data kependudukan dan demografi Desa Duren.</p>
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
                    <p style="color: var(--text-muted); text-align: center; margin: 40px 0;">Belum ada data diinput.</p>
                @endif
            </div>
            <div class="card-footer-action">
                <a href="{{ route('admin.statistics.edit', 'gender') }}" class="btn-manage">
                    <i class="fa-solid fa-pen-to-square"></i> Sunting Data
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
                    <p style="color: var(--text-muted); text-align: center; margin: 40px 0;">Belum ada data diinput.</p>
                @endif
            </div>
            <div class="card-footer-action">
                <a href="{{ route('admin.statistics.edit', 'age') }}" class="btn-manage">
                    <i class="fa-solid fa-pen-to-square"></i> Sunting Data
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
                    <p style="color: var(--text-muted); text-align: center; margin: 40px 0;">Belum ada data diinput.</p>
                @endif
            </div>
            <div class="card-footer-action">
                <a href="{{ route('admin.statistics.edit', 'family_card') }}" class="btn-manage">
                    <i class="fa-solid fa-pen-to-square"></i> Sunting Data
                </a>
            </div>
        </div>
    </div>
@endsection
