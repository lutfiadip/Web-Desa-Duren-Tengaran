@extends('admin.layouts.admin')

@section('title', 'Sunting Halaman Beranda')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Pengaturan Halaman Beranda (Homepage)</h2>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Aktifkan Halaman:</span>
                <label class="switch">
                    <input type="checkbox" class="global-publish-toggle" data-key="publish_about" {{ ($profile->publish_about ?? true) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin: 20px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data" style="padding: 24px;">
            @csrf
            @method('PUT')

            <!-- HERO BACKGROUND -->
            <div style="margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 15px;">
                    <i class="fa-solid fa-image"></i> Gambar Latar Hero (Header Utama)
                </h3>
                <div class="form-group">
                    <label for="hero_bg_image">Gambar Latar Hero (Beranda)</label>
                    @if($profile->hero_bg_image)
                        <div style="margin-bottom: 15px;">
                            <img src="{{ asset($profile->hero_bg_image) }}" alt="Hero Background"
                                style="max-height: 200px; width: auto; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        </div>
                    @endif
                    <input type="file" id="hero_bg_image" name="hero_bg_image" class="form-control" accept="image/*">
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB. Gambar ini akan menjadi latar belakang banner utama di halaman beranda.</span>
                </div>
            </div>

            <!-- TENTANG DESA SECTION -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 15px;">
                    <i class="fa-solid fa-house-chimney"></i> Bagian Selamat Datang / Tentang Desa
                </h3>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="about_text">Deskripsi Tentang Desa (Beranda)</label>
                    <textarea id="about_text" name="about_text" class="form-control" style="min-height: 150px; font-size: 0.95rem; line-height: 1.6;"
                        placeholder="Tuliskan deskripsi singkat profil desa untuk ditampilkan di halaman beranda..." required>{{ old('about_text', $profile->about_text) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="about_image">Foto Balai Desa / Kantor Desa (Beranda)</label>
                    @if($profile->about_image)
                        <div style="margin-bottom: 15px;">
                            <img src="{{ asset($profile->about_image) }}" alt="Foto Kantor Desa"
                                style="max-height: 200px; width: auto; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        </div>
                    @endif
                    <input type="file" id="about_image" name="about_image" class="form-control" accept="image/*">
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB. Foto ini ditampilkan di samping deskripsi Tentang Desa.</span>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                    <i class="fa-solid fa-circle-check"></i> Simpan Pengaturan Beranda
                </button>
            </div>
        </form>
    </div>
@endsection
