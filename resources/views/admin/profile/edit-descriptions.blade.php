@extends('admin.layouts.admin')

@section('title', 'Teks & Deskripsi Halaman')

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
            <li style="color: var(--text-dark); font-weight: 600;">Teks & Deskripsi Halaman</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-align-left" style="color: var(--primary-light);"></i> Teks & Deskripsi Halaman
            </h2>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.profile.update-descriptions') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 24px;">
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                    Atur teks deskripsi (subjudul) yang akan muncul di bawah judul utama pada banner masing-masing halaman.
                </p>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="profile_page_description">Halaman Profil Desa</label>
                    <textarea id="profile_page_description" name="profile_page_description" class="form-control" rows="2"
                        placeholder="Masukkan mengenal lebih dekat mengenai Desa Duren Tengaran....">{{ old('profile_page_description', $profile->profile_page_description ?? 'Mengenal lebih dekat mengenai Desa ' . ($profile->village_name ?? 'Duren Tengaran') . '.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="umkm_page_description">Halaman UMKM & Produk Unggulan</label>
                    <textarea id="umkm_page_description" name="umkm_page_description" class="form-control" rows="2"
                        placeholder="Masukkan temukan berbagai produk unggulan dan potensi UMKM masyarakat Desa Duren Tengaran....">{{ old('umkm_page_description', $profile->umkm_page_description ?? 'Temukan berbagai produk unggulan dan potensi UMKM masyarakat Desa Duren Tengaran.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="tourism_page_description">Halaman Pariwisata</label>
                    <textarea id="tourism_page_description" name="tourism_page_description" class="form-control" rows="2"
                        placeholder="Masukkan jelajahi keindahan alam dan potensi wisata yang ada di Desa Duren Tengaran....">{{ old('tourism_page_description', $profile->tourism_page_description ?? 'Jelajahi keindahan alam dan potensi wisata yang ada di Desa Duren Tengaran.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="news_page_description">Halaman Berita Desa</label>
                    <textarea id="news_page_description" name="news_page_description" class="form-control" rows="2"
                        placeholder="Masukkan ikuti terus berita dan informasi terbaru seputar kegiatan di Desa Duren Tengaran....">{{ old('news_page_description', $profile->news_page_description ?? 'Ikuti terus berita dan informasi terbaru seputar kegiatan di Desa Duren Tengaran.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="officials_page_description">Halaman Aparatur Desa</label>
                    <textarea id="officials_page_description" name="officials_page_description" class="form-control" rows="2"
                        placeholder="Masukkan susunan perangkat desa yang bertugas melayani masyarakat Desa Duren Tengaran....">{{ old('officials_page_description', $profile->officials_page_description ?? 'Susunan perangkat desa yang bertugas melayani masyarakat Desa Duren Tengaran.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="regulations_page_description">Halaman Peraturan Desa</label>
                    <textarea id="regulations_page_description" name="regulations_page_description" class="form-control" rows="2"
                        placeholder="Masukkan dokumen resmi dan produk hukum yang berlaku di Desa Duren Tengaran....">{{ old('regulations_page_description', $profile->regulations_page_description ?? 'Dokumen resmi dan produk hukum yang berlaku di Desa Duren Tengaran.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="institutions_page_description">Halaman Lembaga Desa</label>
                    <textarea id="institutions_page_description" name="institutions_page_description" class="form-control" rows="2"
                        placeholder="Masukkan informasi mengenai berbagai lembaga kemasyarakatan yang ada di Desa Duren Tengaran....">{{ old('institutions_page_description', $profile->institutions_page_description ?? 'Informasi mengenai berbagai lembaga kemasyarakatan yang ada di Desa Duren Tengaran.') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="agriculture_page_description">Halaman Pertanian & Perkebunan</label>
                    <textarea id="agriculture_page_description" name="agriculture_page_description" class="form-control" rows="2"
                        placeholder="Masukkan potensi dan komoditas unggulan sektor pertanian dan perkebunan Desa Duren Tengaran....">{{ old('agriculture_page_description', $profile->agriculture_page_description ?? 'Potensi dan komoditas unggulan sektor pertanian dan perkebunan Desa Duren Tengaran.') }}</textarea>
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
