@extends('admin.layouts.admin')

@section('title', 'Kelola UMKM Desa')

@section('content')
<!-- Toggle Publikasi Halaman -->
<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fa-solid fa-globe" style="color: var(--primary-light);"></i> Status Publikasi Halaman UMKM
            </h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Tentukan apakah Halaman UMKM Desa dipublikasikan secara umum di website.</p>
        </div>
        <label class="switch">
            <input type="checkbox" class="global-publish-toggle" data-key="publish_umkm" {{ ($profile->publish_umkm ?? true) ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Daftar Usaha Mikro Kecil Menengah (UMKM)</h2>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('admin.umkm.categories.index') }}" class="btn btn-secondary" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-tags"></i> Kelola Kategori
            </a>
            <a href="{{ route('admin.umkm.create') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-plus"></i> Daftarkan UMKM Baru
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.umkm.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama usaha atau pemilik..." value="{{ request('search') }}" style="max-width: 300px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- UMKM Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Thumbnail</th>
                    <th>Nama Usaha</th>
                    <th>Nama Pemilik</th>
                    <th>Kategori</th>
                    <th>WhatsApp</th>
                    <th>Unggulan</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($umkms as $item)
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
                            <span style="font-size: 0.8rem; color: var(--text-muted);">{{ Str::limit($item->address, 50) }}</span>
                        </td>
                        <td>
                            {{ $item->owner_name }}
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $item->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            @if($item->whatsapp)
                                <a href="https://wa.me/{{ $item->whatsapp }}" target="_blank" style="color: #25d366; font-weight: 700; text-decoration: none;">
                                    <i class="fa-brands fa-whatsapp"></i> {{ $item->whatsapp }}
                                </a>
                            @else
                                -
                            @endif
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
                                <a href="{{ route('admin.umkm.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data UMKM ini?')">
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
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                            <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            Belum ada data UMKM desa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($umkms->hasPages())
        <div class="pagination-wrapper">
            {{ $umkms->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
