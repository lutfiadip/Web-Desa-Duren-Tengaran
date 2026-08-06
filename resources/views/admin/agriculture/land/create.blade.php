@extends('admin.layouts.admin')

@section('title', 'Tambah Statistik Lahan')

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
            <li>
                <a href="{{ route('admin.agriculture.index', ['tab' => 'land-statistics']) }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Pertanian & Peternakan
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Tambah Statistik Lahan</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 600px;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-chart-area" style="color: var(--primary-light);"></i> Tambah Statistik Lahan
            </h2>
            <a href="{{ route('admin.agriculture.index', ['tab' => 'land-statistics']) }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('agriculture.land.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="label">Label / Jenis Lahan <span style="color: red;">*</span></label>
                <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}" placeholder="Contoh: Sawah Irigasi, Tanah Kering" required>
                @error('label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label for="area">Luas Lahan <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="area" id="area" class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}" placeholder="Contoh: 150.5" required>
                    @error('area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit">Satuan <span style="color: red;">*</span></label>
                    <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', 'Ha') }}" required>
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="icon">Icon FontAwesome</label>
                <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', 'fa-solid fa-wheat-awn') }}" placeholder="Contoh: fa-solid fa-wheat-awn">
                <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Masukkan class FontAwesome 6, contoh: <code>fa-solid fa-tree</code> atau <code>fa-solid fa-cow</code>.</span>
                @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sort_order">Urutan Tampilan <span style="color: red;">*</span></label>
                <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" required>
                @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 25px; border-top: 1px solid var(--border-color); padding-top: 15px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
@endsection
