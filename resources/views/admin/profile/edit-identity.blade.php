@extends('admin.layouts.admin')

@section('title', 'Identitas & Informasi Dasar Desa')

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
                <a href="{{ route('admin.profile.edit') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Profil Desa
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Identitas & Informasi Dasar</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-id-card" style="color: var(--primary-light);"></i> Identitas & Informasi Dasar Desa
            </h2>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin: 0 0 20px 0; position: static; min-width: auto; max-width: none; box-shadow: none;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update-identity') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="village_name">Nama Desa</label>
                        <input type="text" id="village_name" name="village_name" class="form-control"
                            value="{{ old('village_name', $profile->village_name) }}" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="office_hours">Jam Operasional Kantor</label>
                        <input type="text" id="office_hours" name="office_hours" class="form-control"
                            value="{{ old('office_hours', $profile->office_hours) }}"
                            placeholder="Contoh: Senin - Jumat (08.00 - 15.30 WIB)">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="logo">Logo Desa</label>
                    @if($profile->logo)
                        <div style="margin-bottom: 12px;">
                            <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Logo saat ini:</span>
                            <img src="{{ asset($profile->logo) }}" alt="Logo Desa" style="height: 80px; object-fit: contain; border: 1px solid var(--border-color); padding: 5px; border-radius: var(--radius-md); background: #fff;">
                        </div>
                    @endif
                    <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB. Format: JPEG, PNG, JPG, GIF, SVG, WebP.</span>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 0.95rem;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary" style="padding: 12px 20px;">Batal</a>
            </div>
        </form>
    </div>
@endsection
