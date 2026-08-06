@extends('admin.layouts.admin')

@section('title', 'Sunting Lembaga')

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
                <a href="{{ route('admin.institutions.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Lembaga Kemasyarakatan Desa (LKD)
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Sunting Lembaga</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-edit" style="color: var(--primary-light);"></i> Sunting Lembaga: {{ $institution->name }}
            </h2>
            <a href="{{ route('admin.institutions.index') }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.institutions.update', $institution->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lembaga <span style="color: red;">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $institution->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="logo">Logo Resmi Lembaga</label>
                @if($institution->logo)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ Str::startsWith($institution->logo, 'http') ? $institution->logo : asset($institution->logo) }}" alt="Logo" style="max-width: 100px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 4px;">
                    </div>
                @endif
                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Biarkan kosong jika tidak ingin mengubah logo. Format: JPG, JPEG, PNG, WEBP (Maks: 2MB).</span>
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Profil / Deskripsi Singkat <span style="color: red;">*</span></label>
                <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $institution->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="vision">Visi Lembaga</label>
                <textarea name="vision" id="vision" rows="3" class="form-control @error('vision') is-invalid @enderror" placeholder="Tulis visi lembaga jika ada...">{{ old('vision', $institution->vision) }}</textarea>
                @error('vision')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="mission">Misi Lembaga</label>
                <textarea name="mission" id="mission" rows="4" class="form-control @error('mission') is-invalid @enderror" placeholder="Tulis poin-poin misi lembaga jika ada...">{{ old('mission', $institution->mission) }}</textarea>
                @error('mission')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="contact">Nomor Kontak / WhatsApp</label>
                    <input type="text" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $institution->contact) }}" placeholder="Contoh: 0812-3456-7890">
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Resmi Lembaga</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $institution->email) }}" placeholder="Contoh: pkk@duren.desa.id">
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
                        <input type="checkbox" name="status" value="published" {{ old('status', $institution->status) == 'published' ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
                </div>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Perbarui Lembaga
                </button>
            </div>
        </form>
    </div>
@endsection
