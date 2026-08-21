@extends('admin.layouts.admin')

@section('title', 'Kelola Kebudayaan Desa')

@section('content')
<!-- Toggle Publikasi Halaman -->
<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fa-solid fa-globe" style="color: var(--primary-light);"></i> Status Publikasi Halaman Kebudayaan
            </h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Tentukan apakah Halaman Kebudayaan Desa dipublikasikan secara umum di website.</p>
        </div>
        <label class="switch">
            <input type="checkbox" class="global-publish-toggle" data-key="publish_culture" {{ ($profile->publish_culture ?? true) ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Daftar Seni dan Kebudayaan Desa</h2>
        <a href="{{ route('admin.culture.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Budaya Baru
        </a>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.culture.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama budaya..." value="{{ request('search') }}" style="max-width: 300px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.culture.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- Culture Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Thumbnail</th>
                    <th>Nama Seni / Budaya</th>
                    <th>Lokasi/Tempat Pentas</th>
                    <th>Waktu Pelaksanaan</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cultures as $item)
                    <tr>
                        <td>
                            @if($item->thumbnail)
                                <img src="{{ asset($item->thumbnail) }}" alt="Thumb" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                            @else
                                <div style="width: 60px; height: 45px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: #64748b;">No Img</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-dark);">
                                {{ $item->title }}
                                @if($item->is_featured)
                                    <i class="fa-solid fa-star" style="color: #f59e0b; margin-left: 4px;" title="Seni Budaya Unggulan"></i>
                                @endif
                            </div>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Kontak: {{ $item->contact ?? '-' }}</span>
                        </td>
                        <td>
                            {{ $item->location }}
                        </td>
                        <td>
                            {{ Str::limit($item->implementation_time, 50) }}
                        </td>
                        <td>
                            @if($item->status === 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: center;">
                                <a href="{{ route('admin.culture.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.culture.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data budaya ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Hapus" style="background: none; cursor: pointer;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                            <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            Belum ada data seni dan budaya desa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($cultures->hasPages())
        <div class="pagination-wrapper">
            {{ $cultures->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
