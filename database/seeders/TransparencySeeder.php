<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinanceReport;
use App\Models\FinanceDocument;

class TransparencySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tahun Anggaran 2026
        $report2026 = FinanceReport::updateOrCreate(
            ['year' => 2026],
            [
                'revenue_target' => 1850000000.00,
                'revenue_realization' => 1480000000.00,
                'spending_target' => 1820000000.00,
                'spending_realization' => 1250000000.00,
                'financing_target' => 30000000.00,
                'financing_realization' => 30000000.00,
                'apbdes_poster' => 'https://images.unsplash.com/photo-1543185377-b75371a2943b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ]
        );

        // Documents for 2026
        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2026->id,
                'title' => 'Laporan Realisasi APBDes Semester I Tahun 2026',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'budget',
            ]
        );

        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2026->id,
                'title' => 'Laporan Realisasi Pembangunan Jembatan Miri',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'development',
            ]
        );

        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2026->id,
                'title' => 'Daftar Aset & Inventaris Milik Desa 2026',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'asset',
            ]
        );

        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2026->id,
                'title' => 'Rencana Kerja Pemerintah Desa (RKPDes) 2026',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'report',
            ]
        );

        // 2. Tahun Anggaran 2025
        $report2025 = FinanceReport::updateOrCreate(
            ['year' => 2025],
            [
                'revenue_target' => 1650000000.00,
                'revenue_realization' => 1650000000.00,
                'spending_target' => 1600000000.00,
                'spending_realization' => 1580000000.00,
                'financing_target' => 10000000.00,
                'financing_realization' => 10000000.00,
                'apbdes_poster' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ]
        );

        // Documents for 2025
        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2025->id,
                'title' => 'Laporan Pertanggungjawaban Realisasi APBDes Akhir Tahun 2025',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'budget',
            ]
        );

        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2025->id,
                'title' => 'Laporan Hasil Pembangunan Rabat Beton Jalan Dusun',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'development',
            ]
        );

        FinanceDocument::updateOrCreate(
            [
                'finance_report_id' => $report2025->id,
                'title' => 'Rencana Pembangunan Jangka Menengah Desa (RPJMDes) 2020-2026',
            ],
            [
                'file_path' => 'uploads/finance/placeholder.pdf',
                'category' => 'report',
            ]
        );
    }
}
