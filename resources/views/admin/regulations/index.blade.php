@extends('admin.layouts.admin')

@section('title', 'Kelola Peraturan Desa')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Peraturan & Regulasi Desa</h2>
        <a href="{{ route('admin.regulations.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Peraturan Baru
        </a>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.regulations.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor atau judul peraturan..." value="{{ request('search') }}" style="max-width: 300px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.regulations.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- Regulations Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nomor & Tahun</th>
                    <th>Judul Peraturan</th>
                    <th>Kategori</th>
                    <th>Dokumen</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($regulations as $item)
                    <tr>
                        <td style="font-weight: 700;">
                            No. {{ $item->number }} Tahun {{ $item->year }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-dark);">{{ $item->title }}</div>
                            @if($item->description)
                                <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 3px;">{{ Str::limit($item->description, 100) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $item->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            @if($item->document_file)
                                <a href="{{ asset($item->document_file) }}" target="_blank" class="btn btn-secondary" style="padding: 5px 12px; font-size: 0.8rem; border-radius: var(--radius-md);">
                                    <i class="fa-solid fa-file-pdf" style="color: #ef4444; margin-right: 5px;"></i> Unduh
                                </a>
                            @else
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Tidak ada file</span>
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
                                <a href="{{ route('admin.regulations.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.regulations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peraturan ini?')">
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
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                            <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            Belum ada data peraturan desa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($regulations->hasPages())
        <div class="pagination-wrapper">
            {{ $regulations->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
