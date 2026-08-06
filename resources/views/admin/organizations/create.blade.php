@extends('admin.layouts.admin')

@section('title', 'Tambah Organisasi Baru')

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
                <a href="{{ route('admin.organizations.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Organisasi Kemasyarakatan
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Tambah Organisasi</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-plus-circle" style="color: var(--primary-light);"></i> Tambah Organisasi Baru
            </h2>
            <a href="{{ route('admin.organizations.index') }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nama Organisasi <span style="color: red;">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Nahdlatul Ulama (NU) Ranting Duren" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="logo">Logo Resmi Organisasi</label>
                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Format: JPG, JPEG, PNG, WEBP (Maks: 2MB).</span>
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Profil / Deskripsi Singkat <span style="color: red;">*</span></label>
                <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Jelaskan profil singkat, kegiatan, dan fokus kemasyarakatan organisasi ini..." required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="vision">Visi Organisasi</label>
                <textarea name="vision" id="vision" rows="3" class="form-control @error('vision') is-invalid @enderror" placeholder="Tulis visi organisasi jika ada...">{{ old('vision') }}</textarea>
                @error('vision')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="mission">Misi Organisasi</label>
                <textarea name="mission" id="mission" rows="4" class="form-control @error('mission') is-invalid @enderror" placeholder="Tulis poin-poin misi organisasi jika ada...">{{ old('mission') }}</textarea>
                @error('mission')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="contact">Nomor Kontak / WhatsApp</label>
                    <input type="text" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" placeholder="Contoh: 0812-3456-7890">
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Resmi Organisasi</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Contoh: ormas@duren.desa.id">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status Publikasi</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                    <label class="switch">
                        <input type="checkbox" name="status" value="published" {{ old('status', 'published') == 'published' ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan Organisasi
                </button>
            </div>
        </form>
    </div>
@endsection
