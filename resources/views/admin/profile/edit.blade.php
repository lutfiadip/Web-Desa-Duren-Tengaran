@extends('admin.layouts.admin')

@section('title', 'Sunting Profil Desa')

@section('content')
    <div class="card" style="max-width: 1000px; margin: 0 auto;">
        <div class="card-header">
            <h2>Identitas & Profil Desa Duren</h2>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- KELOMPOK 1: INFORMASI UMUM -->
            <h3
                style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <i class="fa-solid fa-circle-info"></i> Informasi Dasar Desa
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="village_name">Nama Desa</label>
                    <input type="text" id="village_name" name="village_name" class="form-control"
                        value="{{ old('village_name', $profile->village_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="office_hours">Jam Operasional Kantor</label>
                    <input type="text" id="office_hours" name="office_hours" class="form-control"
                        value="{{ old('office_hours', $profile->office_hours) }}"
                        placeholder="Contoh: Senin - Jumat (08.00 - 15.30 WIB)">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="logo">Logo</label>
                    @if($profile->logo)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset($profile->logo) }}" alt="Logo Desa" style="height: 60px; object-fit: contain;">
                        </div>
                    @endif
                    <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="hero_bg_image">Gambar Latar Beranda</label>
                    @if($profile->hero_bg_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset($profile->hero_bg_image) }}" alt="Hero Background"
                                style="height: 60px; width: 120px; object-fit: cover; border-radius: 4px;">
                        </div>
                    @endif
                    <input type="file" id="hero_bg_image" name="hero_bg_image" class="form-control" accept="image/*">
                </div>
            </div>

            <!-- KELOMPOK 2: KEPALA DESA -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-user-tie"></i> Profil Kepala Desa
                </h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Sambutan:</span>
                    <label class="switch">
                        <input type="checkbox" name="publish_headman_greeting" value="1" {{ old('publish_headman_greeting', $profile->publish_headman_greeting) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="headman_name">Nama Kepala Desa</label>
                    <input type="text" id="headman_name" name="headman_name" class="form-control"
                        value="{{ old('headman_name', $profile->headman_name) }}"
                        placeholder="Nama Kepala Desa Beserta Gelar">
                </div>

                <div class="form-group">
                    <label for="headman_photo">Foto Kepala Desa</label>
                    @if($profile->headman_photo)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset($profile->headman_photo) }}" alt="Foto Kades"
                                style="height: 60px; width: 60px; object-fit: cover; border-radius: 50%;">
                        </div>
                    @endif
                    <input type="file" id="headman_photo" name="headman_photo" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label for="headman_greeting">Kata Sambutan Kepala Desa</label>
                <textarea id="headman_greeting" name="headman_greeting" class="form-control" style="min-height: 120px;"
                    placeholder="Tuliskan sambutan resmi Kepala Desa untuk pengunjung website...">{{ old('headman_greeting', $profile->headman_greeting) }}</textarea>
            </div>

            <!-- KELOMPOK 3: SEJARAH DESA -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Sejarah Desa
                </h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Sejarah:</span>
                    <label class="switch">
                        <input type="checkbox" name="publish_history" value="1" {{ old('publish_history', $profile->publish_history) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div class="form-group">
                    <label for="history">Sejarah Singkat Desa</label>
                    <textarea id="history" name="history" class="form-control"
                        style="min-height: 150px;">{{ old('history', $profile->history) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="history_image">Foto Sejarah Desa</label>
                    @if($profile->history_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset($profile->history_image) }}" alt="Foto Sejarah Desa"
                                style="height: 100px; width: 150px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                        </div>
                    @endif
                    <input type="file" id="history_image" name="history_image" class="form-control" accept="image/*">
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB.</span>
                </div>
            </div>

            <!-- KELOMPOK 4: VISI & MISI DESA -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-bullseye"></i> Visi & Misi Desa
                </h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Visi Misi:</span>
                    <label class="switch">
                        <input type="checkbox" name="publish_vision_mission" value="1" {{ old('publish_vision_mission', $profile->publish_vision_mission) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="vision">Visi Desa</label>
                <textarea id="vision" name="vision" class="form-control" style="min-height: 80px;"
                    placeholder="Visi pembangunan jangka panjang desa...">{{ old('vision', $profile->vision) }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label for="mission">Misi Desa (Gunakan baris baru untuk setiap poin misi)</label>
                <textarea id="mission" name="mission" class="form-control" style="min-height: 120px;"
                    placeholder="Misi 1. ...&#10;Misi 2. ...">{{ old('mission', $profile->mission) }}</textarea>
            </div>

            <!-- KELOMPOK 5: DESKRIPSI & FOTO TENTANG DESA (BERANDA) -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-house-chimney"></i> Deskripsi & Foto Beranda (Tentang Desa)
                </h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Tentang Desa:</span>
                    <label class="switch">
                        <input type="checkbox" name="publish_about" value="1" {{ old('publish_about', $profile->publish_about) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div class="form-group">
                    <label for="about_text">Deskripsi Tentang Desa (Beranda)</label>
                    <textarea id="about_text" name="about_text" class="form-control" style="min-height: 100px;"
                        placeholder="Deskripsi singkat tentang desa untuk halaman depan...">{{ old('about_text', $profile->about_text ?? 'Desa Duren merupakan salah satu desa di Kecamatan Tengaran, Kabupaten Semarang yang memiliki potensi besar di bidang pertanian, peternakan, dan pariwisata. Dengan semangat gotong royong, berkembang menuju masyarakat sejahtera, dan berdaya saing.') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="about_image">Foto Balai Desa / Kantor Desa (Beranda)</label>
                    @if($profile->about_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset($profile->about_image) }}" alt="Foto Kantor Desa"
                                style="height: 60px; width: 100px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                        </div>
                    @endif
                    <input type="file" id="about_image" name="about_image" class="form-control" accept="image/*">
                </div>
            </div>

            <!-- KELOMPOK 6: KONTAK & MEDIA SOSIAL -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-address-book"></i> Kontak & Media Sosial Resmi
                </h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Peta & Geografis:</span>
                    <label class="switch">
                        <input type="checkbox" name="publish_geographics" value="1" {{ old('publish_geographics', $profile->publish_geographics) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="phone">No. Telepon / Fax</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ old('phone', $profile->phone) }}">
                </div>

                <div class="form-group">
                    <label for="email">Email Resmi Desa</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', $profile->email) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat Kantor Kepala Desa</label>
                <textarea id="address" name="address" class="form-control"
                    style="min-height: 80px;">{{ old('address', $profile->address) }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="facebook">Username/Link Facebook</label>
                    <input type="text" id="facebook" name="facebook" class="form-control"
                        value="{{ old('facebook', $profile->facebook) }}" placeholder="Contoh: # atau url halaman">
                </div>

                <div class="form-group">
                    <label for="instagram">Username/Link Instagram</label>
                    <input type="text" id="instagram" name="instagram" class="form-control"
                        value="{{ old('instagram', $profile->instagram) }}" placeholder="Contoh: @desa.duren">
                </div>

                <div class="form-group">
                    <label for="youtube">Username/Link YouTube</label>
                    <input type="text" id="youtube" name="youtube" class="form-control"
                        value="{{ old('youtube', $profile->youtube) }}" placeholder="Contoh: @durentengaran">
                </div>
            </div>

            <div class="form-group">
                <label for="google_maps_url">Link Google Maps</label>
                <input type="text" id="google_maps_url" name="google_maps_url" class="form-control"
                    value="{{ old('google_maps_url', $profile->google_maps_url) }}"
                    placeholder="Masukkan link maps embed...">
            </div>

            <!-- KELOMPOK 7: STRUKTUR ORGANISASI -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-sitemap"></i> Struktur Organisasi
                </h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish Struktur Organisasi:</span>
                    <label class="switch">
                        <input type="checkbox" name="publish_organization_structure" value="1" {{ old('publish_organization_structure', $profile->publish_organization_structure) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="organization_structure_image">Bagan Struktur Organisasi Pemerintah Desa (Gambar)</label>
                @if($profile->organization_structure_image)
                    <div style="margin-bottom: 15px;">
                        <img src="{{ asset($profile->organization_structure_image) }}" alt="Struktur Organisasi"
                            style="max-height: 250px; max-width: 100%; border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                    </div>
                @endif
                <input type="file" id="organization_structure_image" name="organization_structure_image"
                    class="form-control" accept="image/*">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file:
                    2 MB.</span>
            </div>

            <!-- KELOMPOK 8: HALAMAN LAINNYA (TANPA KELOLA MANUAL) -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                    <i class="fa-solid fa-cubes"></i> Publikasi Halaman Tambahan
                </h3>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div class="form-group" style="display: flex; align-items: center; justify-content: space-between; background-color: #f8fafc; padding: 15px; border: 1px solid var(--border-color); border-radius: var(--radius-md); margin: 0;">
                    <div>
                        <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 2px; display: block;">Halaman Pertanian & Peternakan</label>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block; line-height: 1.3;">Tampilkan potensi komoditas pertanian dan peternakan di website.</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="publish_agriculture" value="1" {{ old('publish_agriculture', $profile->publish_agriculture) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="form-group" style="display: flex; align-items: center; justify-content: space-between; background-color: #f8fafc; padding: 15px; border: 1px solid var(--border-color); border-radius: var(--radius-md); margin: 0;">
                    <div>
                        <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 2px; display: block;">Halaman Lembaga & Organisasi</label>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block; line-height: 1.3;">Tampilkan informasi lembaga kemasyarakatan di website.</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="publish_institutions" value="1" {{ old('publish_institutions', $profile->publish_institutions) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div
                style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                    <i class="fa-solid fa-circle-check"></i> Simpan Profil Desa
                </button>
            </div>
        </form>
    </div>
@endsection