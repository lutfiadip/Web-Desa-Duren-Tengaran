@extends('admin.layouts.admin')

@section('title', 'Kelola Perangkat Desa')

@section('content')
<!-- Toggle Publikasi Halaman -->
<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fa-solid fa-globe" style="color: var(--primary-light);"></i> Status Publikasi Halaman Perangkat Desa
            </h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Tentukan apakah Halaman Perangkat Desa & Staf dipublikasikan secara umum di website.</p>
        </div>
        <label class="switch">
            <input type="checkbox" class="global-publish-toggle" data-key="publish_officials" {{ ($profile->publish_officials ?? true) ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Daftar Perangkat Desa & Staf</h2>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('admin.officials.categories.index') }}" class="btn btn-secondary" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-tags"></i> Kelola Kategori
            </a>
            <a href="{{ route('admin.officials.create') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-plus"></i> Tambah Perangkat Baru
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.officials.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau jabatan..." value="{{ request('search') }}" style="max-width: 300px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.officials.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- Officials Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Foto</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>NIP</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($officials as $item)
                    <tr>
                        <td>
                            @if($item->photo)
                                <img src="{{ asset($item->photo) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border-color);">
                            @else
                                <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #64748b;"><i class="fa-solid fa-user"></i></div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $item->name }}</div>
                            @if($item->parent)
                                <div style="font-size: 0.8rem; color: var(--text-muted);">Bawahan dari: {{ $item->parent->name }}</div>
                            @endif
                        </td>
                        <td style="font-weight: 600;">
                            {{ $item->position }}
                        </td>
                        <td>
                            {{ $item->nip ?? '-' }}
                        </td>
                        <td>
                            {{ $item->sort_order }}
                        </td>
                        <td>
                            @if($item->status)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: center;">
                                <a href="{{ route('admin.officials.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.officials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat desa ini?')">
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
                            Belum ada data perangkat desa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($officials->hasPages())
        <div class="pagination-wrapper">
            {{ $officials->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
