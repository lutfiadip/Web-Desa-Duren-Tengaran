@extends('admin.layouts.admin')

@section('title', 'Kelola Kebudayaan Desa')

@section('content')
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
                    <th>Unggulan</th>
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
                            <div style="font-weight: 700; color: var(--text-dark);">{{ $item->title }}</div>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Kontak: {{ $item->contact ?? '-' }}</span>
                        </td>
                        <td>
                            {{ $item->location }}
                        </td>
                        <td>
                            {{ Str::limit($item->implementation_time, 50) }}
                        </td>
                        <td>
                            @if($item->is_featured)
                                <span class="badge badge-success" style="background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;"><i class="fa-solid fa-star"></i> Unggulan</span>
                            @else
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Biasa</span>
                            @endif
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
