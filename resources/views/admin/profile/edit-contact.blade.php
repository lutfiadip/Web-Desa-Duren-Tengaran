@extends('admin.layouts.admin')

@section('title', 'Kontak & Media Sosial Resmi')

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
            <li style="color: var(--text-dark); font-weight: 600;">Kontak & Media Sosial</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-share-nodes" style="color: var(--primary-light);"></i> Kontak & Media Sosial Resmi (Footer)
            </h2>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>



        <form action="{{ route('admin.profile.update-contact') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="phone">No. Telepon / Fax</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="{{ old('phone', $profile->phone) }}" placeholder="Contoh: (0298) 123456">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="email">Email Resmi Desa</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $profile->email) }}" placeholder="Contoh: info@desaduren.go.id">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="address">Alamat Kantor Kepala Desa</label>
                    <textarea id="address" name="address" class="form-control"
                        style="min-height: 80px;" placeholder="Tuliskan alamat lengkap kantor kepala desa...">{{ old('address', $profile->address) }}</textarea>
                </div>

                <h3 style="font-size: 1rem; font-weight: 800; color: var(--primary-light); margin: 25px 0 15px 0; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                    <i class="fa-solid fa-hashtag"></i> Tautan Media Sosial Resmi
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="facebook">Facebook</label>
                        <input type="text" id="facebook" name="facebook" class="form-control"
                            value="{{ old('facebook', $profile->facebook) }}" placeholder="Contoh: desa.duren atau URL">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram" class="form-control"
                            value="{{ old('instagram', $profile->instagram) }}" placeholder="Contoh: @desa.duren atau URL">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="youtube">YouTube</label>
                        <input type="text" id="youtube" name="youtube" class="form-control"
                            value="{{ old('youtube', $profile->youtube) }}" placeholder="Contoh: @durentengaran atau URL">
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 0.95rem;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kontak & Medsos
                </button>
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary" style="padding: 12px 20px;">Batal</a>
            </div>
        </form>
    </div>
@endsection
