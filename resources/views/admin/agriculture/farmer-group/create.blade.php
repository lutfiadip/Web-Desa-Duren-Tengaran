@extends('admin.layouts.admin')

@section('title', 'Tambah Kelompok Tani')

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
                <a href="{{ route('admin.agriculture.index', ['tab' => 'farmer-groups']) }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Pertanian & Peternakan
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Tambah Kelompok Tani</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 600px;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-people-roof" style="color: var(--primary-light);"></i> Tambah Kelompok Tani
            </h2>
            <a href="{{ route('admin.agriculture.index', ['tab' => 'farmer-groups']) }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.agriculture.farmer-group.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Kelompok Tani <span style="color: red;">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Kelompok Tani Lestari I" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sector">Sektor Usaha <span style="color: red;">*</span></label>
                <input type="text" name="sector" id="sector" class="form-control @error('sector') is-invalid @enderror" value="{{ old('sector') }}" placeholder="Contoh: Hortikultura, Padi & Palawija, Peternakan Sapi" required>
                @error('sector')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dusun">Wilayah / Dusun <span style="color: red;">*</span></label>
                <input type="text" name="dusun" id="dusun" class="form-control @error('dusun') is-invalid @enderror" value="{{ old('dusun') }}" placeholder="Contoh: Dusun Krajan, Dusun Babadan" required>
                @error('dusun')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Status Keaktifan <span style="color: red;">*</span></label>
                <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 25px; border-top: 1px solid var(--border-color); padding-top: 15px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan Kelompok Tani
                </button>
            </div>
        </form>
    </div>
@endsection
