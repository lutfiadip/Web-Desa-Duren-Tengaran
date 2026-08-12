@extends('admin.layouts.admin')

@section('title', 'Manajemen Statistik Penduduk')

@section('styles')
<style>
    .sortable-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .sortable-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background-color: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
    }

    .sortable-row.dragging {
        opacity: 0.5;
        border: 1px dashed var(--primary-light);
        background-color: #f8fafc;
    }

    .sortable-row.drag-over {
        border-top: 2px solid var(--primary-light);
    }

    .row-drag-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .drag-handle {
        color: var(--text-muted);
        cursor: grab;
        padding: 5px;
        font-size: 1.1rem;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    .type-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .type-details h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .type-details p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .type-slug {
        font-family: monospace;
        font-size: 0.75rem;
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        color: #475569;
        display: inline-block;
        width: fit-content;
    }

    .row-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-manage-stats {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background-color: var(--primary-light);
        color: var(--white);
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: var(--radius-md);
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-manage-stats:hover {
        background-color: var(--primary);
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-active {
        background-color: #dcfce7;
        color: #15803d;
    }

    .badge-inactive {
        background-color: #fee2e2;
        color: #b91c1c;
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

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">Manajemen Statistik Penduduk</h1>
            <p style="color: var(--text-muted); font-size: 1rem;">Kelola jenis visualisasi data kependudukan dan urutan penampilannya.</p>
        </div>
        <a href="{{ route('admin.statistics.types.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; font-weight: 700; font-size: 0.9rem;">
            <i class="fa-solid fa-plus"></i> Tambah Jenis Statistik
        </a>
    </div>



    <div class="card" style="padding: 30px; background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div class="sortable-list" id="sortable-statistic-types">
            @forelse($types as $type)
                <div class="sortable-row" data-type-id="{{ $type->id }}" style="padding-left: 20px;">
                    <div class="row-drag-info">
                        <div class="type-details">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <h3>{{ $type->name }}</h3>
                                <span class="badge-status {{ $type->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $type->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            @if($type->description)
                                <p>{{ $type->description }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row-actions">
                        <a href="{{ route('admin.statistics.manage', $type->id) }}" class="btn-manage-stats">
                            <i class="fa-solid fa-sliders"></i> Kelola Statistik
                        </a>
                        <a href="{{ route('admin.statistics.types.edit', $type->id) }}" class="btn btn-secondary" style="padding: 8px 12px; font-size: 0.85rem;" title="Sunting">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.statistics.types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis statistik ini? Semua data statistik dan kategorinya akan dihapus permanen.')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; padding: 8px 12px; font-size: 0.85rem; border-radius: var(--radius-md); cursor: pointer;" title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
                    <i class="fa-solid fa-chart-pie" style="font-size: 3rem; margin-bottom: 15px; color: #cbd5e1;"></i>
                    <p style="margin: 0; font-size: 1.1rem; font-weight: 600;">Belum ada jenis statistik ditambahkan.</p>
                    <p style="margin-top: 5px; font-size: 0.9rem;">Silakan tambahkan jenis statistik baru untuk memulai.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection


