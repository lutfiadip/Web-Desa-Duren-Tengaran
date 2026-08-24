@extends('admin.layouts.admin')

@section('title', 'Kelola Akuntabilitas & Transparansi')

@section('content')
<!-- Visibility & Settings Card -->
<div class="card" style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin-bottom: 4px;">Pengaturan Publikasi Halaman</h2>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Tentukan apakah halaman publik "Akuntabilitas & Transparansi" dapat diakses oleh warga.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 10px 20px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
            <span style="font-weight: 700; font-size: 0.95rem; color: var(--text-dark);">Status Publikasi:</span>
            <label class="switch">
                <input type="checkbox" class="global-publish-toggle" data-key="publish_transparency" {{ ($profile->publish_transparency ?? true) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Daftar Tahun Anggaran</h2>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.transparency.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Tahun Anggaran
            </a>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 100px;">Tahun</th>
                    <th>Ringkasan Anggaran (Rp)</th>
                    <th>Poster APBDes</th>
                    <th>Dokumen Terlampir</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $item)
                    <tr>
                        <td>
                            <div style="font-weight: 800; font-size: 1.15rem; color: var(--primary);">{{ $item->year }}</div>
                        </td>
                        <td>
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; font-size: 0.85rem;">
                                <div>
                                    <span style="font-weight: 600; color: #15803d; display: block;">Pendapatan:</span>
                                    Target: <strong>{{ number_format($item->revenue_target, 0, ',', '.') }}</strong><br>
                                    Realisasi: <strong>{{ number_format($item->revenue_realization, 0, ',', '.') }}</strong>
                                </div>
                                <div>
                                    <span style="font-weight: 600; color: #b91c1c; display: block;">Belanja:</span>
                                    Target: <strong>{{ number_format($item->spending_target, 0, ',', '.') }}</strong><br>
                                    Realisasi: <strong>{{ number_format($item->spending_realization, 0, ',', '.') }}</strong>
                                </div>
                                <div>
                                    <span style="font-weight: 600; color: #475569; display: block;">Pembiayaan:</span>
                                    Target: <strong>{{ number_format($item->financing_target, 0, ',', '.') }}</strong><br>
                                    Realisasi: <strong>{{ number_format($item->financing_realization, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($item->apbdes_poster)
                                <a href="{{ asset($item->apbdes_poster) }}" target="_blank" style="display: block; width: 60px; height: 40px; border-radius: 4px; overflow: hidden; border: 1px solid var(--border-color);">
                                    <img src="{{ asset($item->apbdes_poster) }}" alt="Poster" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                            @else
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Tidak ada poster</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.85rem;">
                                @php $docCount = $item->documents()->count(); @endphp
                                <span class="badge {{ $docCount > 0 ? 'badge-success' : 'badge-secondary' }}">
                                    <i class="fa-solid fa-file-pdf"></i> {{ $docCount }} Dokumen
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($item->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-warning">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: center;">
                                <a href="{{ route('admin.transparency.edit', $item->id) }}" class="btn-icon edit" title="Sunting">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.transparency.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data tahun anggaran {{ $item->year }} ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Hapus" style="background: none; cursor: pointer; border: none; padding: 0;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.5;"></i>
                            Belum ada data tahun anggaran transparansi. Silakan klik tombol "Tambah Tahun Anggaran" untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reports->hasPages())
        <div class="pagination-wrapper">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
