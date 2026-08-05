@extends('admin.layouts.admin')

@section('title', 'Kelola Berita Desa')

@section('content')
<!-- Toggle Publikasi Halaman -->
<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fa-solid fa-globe" style="color: var(--primary-light);"></i> Status Publikasi Halaman Berita Desa
            </h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">Tentukan apakah Halaman Berita Desa dipublikasikan secara umum di website.</p>
        </div>
        <label class="switch">
            <input type="checkbox" class="global-publish-toggle" data-key="publish_news" {{ ($profile->publish_news ?? true) ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Daftar Berita Desa</h2>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Berita Baru
        </a>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 20px;">
        <form action="{{ route('admin.news.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="{{ request('search') }}" style="max-width: 300px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- News Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Cover</th>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Rilis</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr>
                        <td>
                            @if($item->featured_image)
                                <img src="{{ asset($item->featured_image) }}" alt="Cover" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                            @else
                                <div style="width: 60px; height: 45px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: #64748b;">No Img</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $item->title }}</div>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">slug: {{ $item->slug }}</span>
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $item->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            @if($item->status === 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->published_at ? $item->published_at : '-' }}
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: center;">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
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
                            Belum ada data berita.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($news->hasPages())
        <div class="pagination-wrapper">
            {{ $news->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
