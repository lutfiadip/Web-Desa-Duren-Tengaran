@extends('layouts.app')

@section('title', 'Statistik Penduduk - Pemerintah Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .stats-hero {
        background: linear-gradient(180deg, rgba(30, 58, 138, 0.9) 0%, rgba(30, 58, 138, 0.7) 100%),
                    url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
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
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
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
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
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
    }

    .chart-title p {
        font-size: 0.95rem;
        color: var(--text-muted);
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

    .chart-wrapper {
        min-height: 380px;
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
</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="stats-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Statistik Penduduk</span>
        </nav>
        <h1>Statistik Penduduk</h1>
        <p>Visualisasi data demografi penduduk Desa Duren secara transparan berdasarkan data kependudukan resmi semester dan tahun terbaru.</p>
        
        @if(($gender && $gender->pdf_file) || ($age && $age->pdf_file) || ($kk && $kk->pdf_file))
            @php
                $pdfPath = ($gender && $gender->pdf_file) ? $gender->pdf_file : (($age && $age->pdf_file) ? $age->pdf_file : $kk->pdf_file);
            @endphp
            <div style="margin-top: 25px;">
                <a href="{{ asset($pdfPath) }}" target="_blank" class="btn-pdf-download" style="display: inline-flex; align-items: center; gap: 10px; background-color: #ef4444; color: #fff; padding: 12px 24px; border-radius: 50px; font-weight: 700; text-decoration: none; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4); transition: all 0.3s ease;">
                    <i class="fa-solid fa-file-pdf" style="font-size: 1.2rem;"></i> Unduh Dokumen PDF Asli
                </a>
            </div>
        @endif
    </section>

    <!-- STATS CONTAINER -->
    <div class="stats-container">

        @if($gender && $gender->details->count() > 0)
            <!-- SUMMARY SECTION -->
            <div class="summary-section">
                <!-- Total Penduduk -->
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="summary-info">
                        <h3>Total Penduduk</h3>
                        <div class="val">{{ number_format($gender->details->first()->total, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Laki-laki -->
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="summary-info">
                        <h3>Laki-Laki</h3>
                        <div class="val">{{ number_format($gender->details->first()->male_total, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Perempuan -->
                <div class="summary-card">
                    <div class="summary-icon rose">
                        <i class="fa-solid fa-user-dress"></i>
                    </div>
                    <div class="summary-info">
                        <h3>Perempuan</h3>
                        <div class="val">{{ number_format($gender->details->first()->female_total, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Kepala Keluarga -->
                @if($kk && $kk->details->count() > 0)
                    <div class="summary-card">
                        <div class="summary-icon amber">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div class="summary-info">
                            <h3>Total Kepala Keluarga</h3>
                            <div class="val">
                                {{ number_format($kk->details->where('label', 'Sudah Memiliki KK')->first()->total ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- CHART GRID -->
            <div class="chart-grid">
                
                <!-- 1. CHART JENIS KELAMIN -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">
                            <h2>Statistik Jenis Kelamin</h2>
                            <p>Perbandingan jumlah penduduk Laki-laki dan Perempuan.</p>
                        </div>
                        <div class="chart-source">
                            <i class="fa-solid fa-database"></i> Sumber: {{ $gender->source ?? 'Data Desa' }}
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <div id="chart-gender"></div>
                    </div>
                </div>

                <!-- 2. CHART KELOMPOK UMUR -->
                @if($age && $age->details->count() > 0)
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">
                                <h2>Statistik Kelompok Umur</h2>
                                <p>Rincian populasi berdasarkan rentang kelompok umur dan jenis kelamin.</p>
                            </div>
                            <div class="chart-source">
                                <i class="fa-solid fa-database"></i> Sumber: {{ $age->source ?? 'Data Desa' }}
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <div id="chart-age"></div>
                        </div>
                    </div>
                @endif

                <!-- 3. CHART KEPEMILIKAN KK -->
                @if($kk && $kk->details->count() > 0)
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">
                                <h2>Statistik Kepemilikan KK</h2>
                                <p>Status kepemilikan Kartu Keluarga (KK) penduduk berdasarkan gender kepala keluarga.</p>
                            </div>
                            <div class="chart-source">
                                <i class="fa-solid fa-database"></i> Sumber: {{ $kk->source ?? 'Data Desa' }}
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <div id="chart-kk"></div>
                        </div>
                    </div>
                @endif

            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="empty-state">
                <i class="fa-solid fa-chart-pie"></i>
                <h3>Data Statistik Belum Tersedia</h3>
                <p>Silakan hubungi administrator desa atau jalankan database seeder untuk mengisi data statistik kependudukan.</p>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
@if($gender && $gender->details->count() > 0)
    <!-- Load ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Konfigurasi Font & Warna Global
            const fontName = 'Plus Jakarta Sans, sans-serif';
            const colors = {
                male: '#2563eb', // Royal Blue
                female: '#f43f5e', // Rose Pink
                total: '#1e293b' // Dark Charcoal
            };

            // ==========================================
            // 1. CHART JENIS KELAMIN (Horizontal Bar)
            // ==========================================
            const genderOptions = {
                series: [{
                    name: 'Jumlah Penduduk',
                    data: [
                        {{ $gender->details->first()->male_total ?? 0 }},
                        {{ $gender->details->first()->female_total ?? 0 }}
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: fontName
                },
                plotOptions: {
                    bar: {
                        barHeight: '60%',
                        distributed: true,
                        horizontal: true,
                        borderRadius: 8,
                        dataLabels: {
                            position: 'right'
                        }
                    }
                },
                colors: [colors.male, colors.female],
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: {
                        colors: ['#fff'],
                        fontWeight: '700',
                        fontSize: '13px'
                    },
                    formatter: function (val) {
                        return val.toLocaleString('id-ID') + ' Jiwa';
                    },
                    offsetX: 0
                },
                stroke: {
                    width: 0
                },
                grid: {
                    borderColor: '#f1f5f9',
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } }
                },
                xaxis: {
                    categories: ['Laki-laki', 'Perempuan'],
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '12px',
                            fontWeight: '600'
                        },
                        formatter: function (val) {
                            return val.toLocaleString('id-ID');
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#1e293b',
                            fontSize: '14px',
                            fontWeight: '700'
                        }
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return val.toLocaleString('id-ID') + ' Jiwa';
                        }
                    }
                },
                legend: {
                    show: false
                }
            };

            const genderChart = new ApexCharts(document.querySelector("#chart-gender"), genderOptions);
            genderChart.render();


            // ==========================================
            // 2. CHART KELOMPOK UMUR (Grouped Horizontal Bar)
            // ==========================================
            @if($age && $age->details->count() > 0)
                const ageCategories = @json($age->details->pluck('label'));
                const ageMaleData = @json($age->details->pluck('male_total'));
                const ageFemaleData = @json($age->details->pluck('female_total'));

                const ageOptions = {
                    series: [
                        {
                            name: 'Laki-laki',
                            data: ageMaleData
                        },
                        {
                            name: 'Perempuan',
                            data: ageFemaleData
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 550,
                        stacked: false,
                        toolbar: { show: false },
                        fontFamily: fontName
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            barHeight: '75%',
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: [colors.male, colors.female],
                    dataLabels: {
                        enabled: false // Matikan data label agar chart tidak bertumpuk padat di mobile
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
                        categories: ageCategories,
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

                const ageChart = new ApexCharts(document.querySelector("#chart-age"), ageOptions);
                ageChart.render();
            @endif


            // ==========================================
            // 3. CHART KEPEMILIKAN KK (Grouped Horizontal Bar)
            // ==========================================
            @if($kk && $kk->details->count() > 0)
                const kkCategories = @json($kk->details->pluck('label'));
                const kkMaleData = @json($kk->details->pluck('male_total'));
                const kkFemaleData = @json($kk->details->pluck('female_total'));

                const kkOptions = {
                    series: [
                        {
                            name: 'Kepala Keluarga Laki-laki',
                            data: kkMaleData
                        },
                        {
                            name: 'Kepala Keluarga Perempuan',
                            data: kkFemaleData
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 280,
                        stacked: false,
                        toolbar: { show: false },
                        fontFamily: fontName
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            barHeight: '60%',
                            borderRadius: 6,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: [colors.male, colors.female],
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '11px',
                            fontWeight: '700',
                            colors: ['#334155']
                        },
                        formatter: function (val) {
                            return val.toLocaleString('id-ID') + ' KK';
                        },
                        offsetX: 35
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
                        categories: kkCategories,
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
                            style: {
                                colors: '#1e293b',
                                fontSize: '13px',
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
                                return val.toLocaleString('id-ID') + ' Kepala Keluarga';
                            }
                        }
                    }
                };

                const kkChart = new ApexCharts(document.querySelector("#chart-kk"), kkOptions);
                kkChart.render();
            @endif

        });
    </script>
@endif
@endsection
