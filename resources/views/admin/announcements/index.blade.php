@extends('admin.layouts.admin')

@section('title', 'Kelola Pengumuman Desa')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Pengumuman Desa</h2>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Pengumuman Baru
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.announcements.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci pencarian..." value="{{ request('search') }}" style="max-width: 300px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Announcements Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul Pengumuman</th>
                    <th>Berkas Lampiran</th>
                    <th>Alert Beranda</th>
                    <th>Status</th>
                    <th>Masa Berlaku</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $item)
                    <tr>
                        <td>
                            <div style="font-weight: 700;">{{ $item->title }}</div>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">slug: {{ $item->slug }}</span>
                        </td>
                        <td>
                            @if($item->document_file)
                                <a href="{{ asset($item->document_file) }}" target="_blank" class="btn btn-secondary" style="padding: 4px 8px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat Berkas
                                </a>
                            @else
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_alert)
                                <span class="badge badge-success"><i class="fa-solid fa-bullhorn"></i> Aktif (Alert)</span>
                            @else
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Biasa</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-warning">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if($item->expired_at)
                                @if(\Carbon\Carbon::parse($item->expired_at)->isPast() && !\Carbon\Carbon::parse($item->expired_at)->isToday())
                                    <span style="color: #ef4444; font-weight: 600;" title="Sudah Kedaluwarsa">
                                        {{ \Carbon\Carbon::parse($item->expired_at)->translatedFormat('d F Y') }} (Kedaluwarsa)
                                    </span>
                                @else
                                    <span>{{ \Carbon\Carbon::parse($item->expired_at)->translatedFormat('d F Y') }}</span>
                                @endif
                            @else
                                <span style="color: var(--text-muted);">Selamanya</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: center;">
                                <a href="{{ route('admin.announcements.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
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
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Data pengumuman belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $announcements->links() }}
    </div>
</div>
@endsection
