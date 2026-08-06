@extends('admin.layouts.admin')

@section('title', 'Kelola Organisasi Kemasyarakatan')

@section('content')
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 25px; font-size: 0.9rem;">
        <ol style="list-style: none; padding: 0; display: flex; gap: 8px; align-items: center; color: var(--text-muted); margin: 0;">
            <li>
                <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Organisasi Kemasyarakatan</li>
        </ol>
    </nav>

    <!-- Header Card with Publish Toggle -->
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="font-size: 1.2rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                    <i class="fa-solid fa-people-group" style="color: var(--primary-light);"></i> Kelola Organisasi Kemasyarakatan
                </h2>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 4px 0 0 0;">Kelola profil, visi misi, dan kepengurusan organisasi masyarakat desa.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Status Publikasi Halaman:</span>
                <label class="switch">
                    <input type="checkbox" class="global-publish-toggle" data-key="publish_institutions" {{ ($profile->publish_institutions ?? true) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Daftar Organisasi Kemasyarakatan</h3>
            <div style="display: flex; gap: 10px; align-items: center;">
                <form action="{{ route('admin.organizations.index') }}" method="GET" style="display: flex; gap: 5px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari organisasi..." value="{{ request('search') }}" style="padding: 6px 12px; font-size: 0.85rem; height: auto; width: 180px;">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fa-solid fa-search"></i></button>
                </form>
                <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-plus"></i> Tambah Organisasi
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="70">Logo</th>
                        <th>Nama Organisasi</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="200" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($institutions as $inst)
                        <tr>
                            <td>
                                @if($inst->logo)
                                    <img src="{{ Str::startsWith($inst->logo, 'http') ? $inst->logo : asset($inst->logo) }}" alt="Logo" style="width: 45px; height: 45px; object-fit: contain; border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 2px;">
                                @else
                                    <div style="width: 45px; height: 45px; background: #e2e8f0; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.75rem; font-weight: 700;">ORMAS</div>
                                @endif
                            </td>
                            <td style="font-weight: bold; color: var(--text-dark);">
                                {{ $inst->name }}
                            </td>
                            <td>{{ $inst->contact ?? '-' }}</td>
                            <td>{{ $inst->email ?? '-' }}</td>
                            <td>
                                @if($inst->status === 'published')
                                    <span class="badge" style="background-color: #dcfce7; color: #15803d;">Dipublikasi</span>
                                @else
                                    <span class="badge" style="background-color: #f1f5f9; color: var(--text-muted);">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route('admin.organizations.edit', $inst->id) }}" class="btn btn-secondary btn-sm" title="Edit Profil">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.institutions.members.index', $inst->id) }}" class="btn btn-primary btn-sm" title="Kelola Anggota" style="background-color: var(--primary-light); border-color: var(--primary-light);">
                                        <i class="fa-solid fa-users-gear"></i> Anggota
                                    </a>
                                    <form action="{{ route('admin.organizations.destroy', $inst->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus organisasi ini? Semua data anggota di dalamnya juga akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                Belum ada data organisasi. Silakan tambah data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($institutions->hasPages())
            <div style="margin-top: 20px;">
                {{ $institutions->links() }}
            </div>
        @endif
    </div>
@endsection
