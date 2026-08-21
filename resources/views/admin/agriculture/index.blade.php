@extends('admin.layouts.admin')

@section('title', 'Kelola Pertanian & Peternakan')

@section('styles')
<style>
    .tab-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 12px;
    }
    .tab-btn {
        padding: 10px 20px;
        border-radius: var(--radius-md);
        background: #f1f5f9;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tab-btn:hover {
        background: #e2e8f0;
        color: var(--text-dark);
    }
    .tab-btn.active {
        background: var(--primary-light);
        color: #fff;
        border-color: var(--primary-light);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
@endsection

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
            <li style="color: var(--text-dark); font-weight: 600;">Pertanian & Peternakan</li>
        </ol>
    </nav>

    <!-- Header Card with Publish Toggle -->
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="font-size: 1.2rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                    <i class="fa-solid fa-wheat-awn" style="color: var(--primary-light);"></i> Kelola Pertanian & Peternakan
                </h2>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 4px 0 0 0;">Kelola profil pertanian, statistik lahan, kelompok tani, dan komoditas unggulan desa.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Halaman:</span>
                <label class="switch">
                    <input type="checkbox" class="global-publish-toggle" data-key="publish_agriculture" {{ ($profile->publish_agriculture ?? true) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>



    <!-- Tab Navigation -->
    <div class="tab-nav">
        <a href="?tab=profile" class="tab-btn {{ $activeTab === 'profile' ? 'active' : '' }}">
            <i class="fa-solid fa-id-card"></i> Profil Banner
        </a>
        <a href="?tab=land-statistics" class="tab-btn {{ $activeTab === 'land-statistics' ? 'active' : '' }}">
            <i class="fa-solid fa-chart-area"></i> Statistik Lahan
        </a>
        <a href="?tab=farmer-groups" class="tab-btn {{ $activeTab === 'farmer-groups' ? 'active' : '' }}">
            <i class="fa-solid fa-people-roof"></i> Kelompok Tani
        </a>
        <a href="?tab=commodities" class="tab-btn {{ $activeTab === 'commodities' ? 'active' : '' }}">
            <i class="fa-solid fa-leaf"></i> Komoditas
        </a>
    </div>

    <!-- Tab Content 1: Profil Banner -->
    <div class="tab-content {{ $activeTab === 'profile' ? 'active' : '' }}">
        <div class="card">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Edit Profil Banner Pertanian</h3>
            </div>
            
            <form action="{{ route('admin.agriculture.update-profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Judul Banner <span style="color: red;">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $agriProfile->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subtitle">Sub-Judul Banner</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $agriProfile->subtitle) }}">
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description_1">Deskripsi Utama <span style="color: red;">*</span></label>
                    <textarea name="description_1" id="description_1" rows="5" class="form-control @error('description_1') is-invalid @enderror">{{ old('description_1', $agriProfile->description_1) }}</textarea>
                    @error('description_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description_2">Deskripsi Pendukung (Paragraf Kedua)</label>
                    <textarea name="description_2" id="description_2" rows="5" class="form-control @error('description_2') is-invalid @enderror">{{ old('description_2', $agriProfile->description_2) }}</textarea>
                    @error('description_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 25px; border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab Content 2: Statistik Lahan -->
    <div class="tab-content {{ $activeTab === 'land-statistics' ? 'active' : '' }}">
        <div class="card">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Daftar Statistik Lahan</h3>
                <a href="{{ route('admin.agriculture.land.create') }}" class="btn btn-primary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-plus"></i> Tambah Data Lahan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="80">Urutan</th>
                            <th>Label / Jenis Lahan</th>
                            <th>Luas Lahan</th>
                            <th>Icon</th>
                            <th width="150" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($landStats as $land)
                            <tr>
                                <td><span class="badge" style="background-color: #f1f5f9; color: var(--text-dark);">#{{ $land->sort_order }}</span></td>
                                <td style="font-weight: bold; color: var(--text-dark);">{{ $land->label }}</td>
                                <td>{{ number_format($land->area, 2) }} {{ $land->unit }}</td>
                                <td>
                                    @if($land->icon)
                                        <i class="{{ $land->icon }}" style="color: var(--primary-light); font-size: 1.2rem;"></i> <code style="margin-left: 5px;">{{ $land->icon }}</code>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="{{ route('admin.agriculture.land.edit', $land->id) }}" class="btn btn-secondary btn-sm" title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.agriculture.land.destroy', $land->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Belum ada data statistik lahan. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Content 3: Kelompok Tani -->
    <div class="tab-content {{ $activeTab === 'farmer-groups' ? 'active' : '' }}">
        <div class="card">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Daftar Kelompok Tani</h3>
                <a href="{{ route('admin.agriculture.farmer-group.create') }}" class="btn btn-primary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-plus"></i> Tambah Kelompok Tani
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Kelompok</th>
                            <th>Sektor Usaha</th>
                            <th>Wilayah / Dusun</th>
                            <th>Status Keaktifan</th>
                            <th width="150" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($farmerGroups as $group)
                            <tr>
                                <td style="font-weight: bold; color: var(--text-dark);">{{ $group->name }}</td>
                                <td>{{ $group->sector }}</td>
                                <td>{{ $group->dusun }}</td>
                                <td>
                                    @if($group->is_active)
                                        <span class="badge" style="background-color: #dcfce7; color: #15803d;"><i class="fa-solid fa-circle-check"></i> Aktif</span>
                                    @else
                                        <span class="badge" style="background-color: #fee2e2; color: #b91c1c;"><i class="fa-solid fa-circle-xmark"></i> Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="{{ route('admin.agriculture.farmer-group.edit', $group->id) }}" class="btn btn-secondary btn-sm" title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.agriculture.farmer-group.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Belum ada data kelompok tani. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Content 4: Komoditas -->
    <div class="tab-content {{ $activeTab === 'commodities' ? 'active' : '' }}">
        <div class="card">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Daftar Komoditas Pertanian & Peternakan</h3>
                <a href="{{ route('admin.agriculture.commodity.create') }}" class="btn btn-primary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-plus"></i> Tambah Komoditas
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="70">Foto</th>
                            <th>Judul Komoditas</th>
                            <th>Kategori</th>
                            <th>Skala Produksi</th>
                            <th>Status</th>
                            <th width="150" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commodities as $commodity)
                            <tr>
                                <td>
                                    @if($commodity->thumbnail)
                                        <img src="{{ asset($commodity->thumbnail) }}" alt="Commodity Thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                                    @else
                                        <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.8rem;">No Pic</div>
                                    @endif
                                </td>
                                <td style="font-weight: bold; color: var(--text-dark);">
                                    {{ $commodity->title }}
                                    @if($commodity->is_featured)
                                        <i class="fa-solid fa-star" style="color: #f59e0b; margin-left: 4px;" title="Komoditas Unggulan"></i>
                                    @endif
                                </td>
                                <td><span class="badge" style="background-color: #eff6ff; color: var(--primary-light);">{{ $commodity->category }}</span></td>
                                <td>{{ $commodity->production_scale ?? '-' }}</td>
                                <td>
                                    @if($commodity->status === 'published')
                                        <span class="badge" style="background-color: #dcfce7; color: #15803d;">Dipublikasi</span>
                                    @else
                                        <span class="badge" style="background-color: #f1f5f9; color: var(--text-muted);">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="{{ route('admin.agriculture.commodity.edit', $commodity->id) }}" class="btn btn-secondary btn-sm" title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.agriculture.commodity.destroy', $commodity->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komoditas ini?')">
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
                                <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Belum ada data komoditas. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
