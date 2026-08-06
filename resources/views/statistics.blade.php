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
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 40px;
        align-items: center;
    }

    @media (max-width: 991px) {
        .chart-content-grid {
            grid-template-columns: 1fr;
        }
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
</style>
@endsection

@section('content')
    @php
        // Try to identify standard categories for summary cards
        $genderStat = collect($statisticsData)->first(fn($item) => $item['type']->slug === 'gender');
        $kkStat = collect($statisticsData)->first(fn($item) => $item['type']->slug === 'family_card');
        
        // Find if there is any PDF available to download
        $anyPdf = collect($statisticsData)->first(fn($item) => !empty($item['statistic']->pdf_file));
        $pdfPath = $anyPdf ? $anyPdf['statistic']->pdf_file : null;
    @endphp

    <!-- HERO HEADER -->
    <section class="stats-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Statistik Penduduk</span>
        </nav>
        <h1>Statistik Penduduk</h1>
        <p>Visualisasi data demografi penduduk Desa Duren secara transparan berdasarkan data kependudukan resmi semester dan tahun terbaru.</p>
        
        @if($pdfPath)
            <div style="margin-top: 25px;">
                <a href="{{ asset($pdfPath) }}" target="_blank" class="btn-pdf-download" style="display: inline-flex; align-items: center; gap: 10px; background-color: #ef4444; color: #fff; padding: 12px 24px; border-radius: 50px; font-weight: 700; text-decoration: none; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4); transition: all 0.3s ease;">
                    <i class="fa-solid fa-file-pdf" style="font-size: 1.2rem;"></i> Unduh Dokumen PDF Asli
                </a>
            </div>
        @endif
    </section>

    <!-- STATS CONTAINER -->
    <div class="stats-container">

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
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div class="summary-info">
                            <h3>Laki-Laki</h3>
                            <div class="val">{{ number_format($genderStat['total_male'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Perempuan -->
                    <div class="summary-card">
                        <div class="summary-icon rose">
                            <i class="fa-solid fa-user-dress"></i>
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

            <!-- CHART GRID -->
            <div class="chart-grid">
                @foreach($statisticsData as $item)
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">
                                <h2>Statistik {{ $item['type']->name }}</h2>
                                <p>{{ $item['type']->description ?? 'Visualisasi data ' . strtolower($item['type']->name) . ' Desa Duren.' }}</p>
                            </div>
                            <div class="chart-source">
                                <i class="fa-solid fa-database"></i> Sumber: {{ $item['statistic']->source ?? 'Data Desa' }}
                            </div>
                        </div>

                        <div class="chart-content-grid">
                            <!-- Left: Chart -->
                            <div class="chart-wrapper">
                                <div id="chart-{{ $item['type']->slug }}"></div>
                            </div>
                            
                            <!-- Right: Table Data -->
                            <div style="overflow-x: auto; background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
                                <h4 style="margin-top: 0; margin-bottom: 15px; font-size: 0.95rem; font-weight: 800; color: var(--text-dark); border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                                    Tabel Rincian Data
                                </h4>
                                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid var(--border-color); font-weight: 800; color: var(--text-dark);">
                                            <th style="padding: 8px 4px;">Kategori</th>
                                            <th style="padding: 8px 4px; text-align: right;">L-L</th>
                                            <th style="padding: 8px 4px; text-align: right;">P-R</th>
                                            <th style="padding: 8px 4px; text-align: right;">Total</th>
                                            <th style="padding: 8px 4px; text-align: right;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item['details'] as $detail)
                                            <tr style="border-bottom: 1px solid var(--border-color);">
                                                <td style="padding: 8px 4px; font-weight: 700; color: var(--text-dark);">{{ $detail->label }}</td>
                                                <td style="padding: 8px 4px; text-align: right;">{{ number_format($detail->male_total, 0, ',', '.') }}</td>
                                                <td style="padding: 8px 4px; text-align: right;">{{ number_format($detail->female_total, 0, ',', '.') }}</td>
                                                <td style="padding: 8px 4px; text-align: right; font-weight: 700; color: var(--primary);">{{ number_format($detail->total, 0, ',', '.') }}</td>
                                                <td style="padding: 8px 4px; text-align: right; font-weight: 600; color: var(--text-muted);">{{ $detail->percentage }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr style="border-top: 2px solid var(--border-color); font-weight: 800; background-color: #f1f5f9; color: var(--text-dark);">
                                            <td style="padding: 8px 4px;">TOTAL</td>
                                            <td style="padding: 8px 4px; text-align: right;">{{ number_format($item['total_male'], 0, ',', '.') }}</td>
                                            <td style="padding: 8px 4px; text-align: right;">{{ number_format($item['total_female'], 0, ',', '.') }}</td>
                                            <td style="padding: 8px 4px; text-align: right; color: var(--primary);">{{ number_format($item['grand_total'], 0, ',', '.') }}</td>
                                            <td style="padding: 8px 4px; text-align: right;">100%</td>
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
                <p>Silakan hubungi administrator desa atau aktifkan modul jenis statistik kependudukan di dashboard admin.</p>
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

        });
    </script>
@endif
@endsection
