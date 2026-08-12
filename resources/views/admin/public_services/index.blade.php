@extends('admin.layouts.admin')

@section('title', 'Layanan Publik')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Panduan Layanan Publik</h2>
        <a href="{{ route('admin.public-services.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Layanan
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Dokumen</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--text-dark);">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-primary"></i> 
                            @endif
                            {{ $service->title }}
                        </div>
                    </td>
                    <td>
                        @if($service->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        @if($service->document_file)
                            <a href="{{ asset($service->document_file) }}" target="_blank" class="btn btn-secondary" style="padding: 4px 8px; font-size: 0.8rem;">
                                <i class="fa-solid fa-download"></i> Unduh
                            </a>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.public-services.edit', $service) }}" class="btn-icon edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.public-services.destroy', $service) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                        Belum ada panduan layanan publik yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($services->hasPages())
    <div class="pagination-wrapper">
        {{ $services->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection
