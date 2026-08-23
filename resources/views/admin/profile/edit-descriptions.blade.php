@extends('admin.layouts.admin')

@section('title', 'Teks & Deskripsi Halaman')

@section('styles')
<style>
    .accordion-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .accordion-item {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        border-color: rgba(37, 99, 235, 0.2);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    .accordion-header {
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        user-select: none;
        background: #fff;
        transition: background-color 0.2s ease;
    }

    .accordion-header:hover {
        background-color: #f8fafc;
    }

    .accordion-header h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
    }

    .accordion-header h4 i {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    .btn-toggle-expand {
        background: none;
        border: none;
        color: #64748b;
        font-size: 0.9rem;
        cursor: pointer;
        padding: 5px;
        transition: transform 0.3s ease;
    }

    .accordion-item.expanded .btn-toggle-expand {
        transform: rotate(180deg);
    }

    .accordion-item.expanded .accordion-header {
        border-bottom: 1px solid var(--border-color);
        background-color: #f8fafc;
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 20px;
    }

    .accordion-item.expanded .accordion-content {
        max-height: 500px;
        padding: 20px;
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

            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                Atur teks deskripsi (subjudul) yang akan muncul di bawah judul utama pada banner masing-masing halaman. Klik pada judul halaman untuk membuka kolom pengisian.
            </p>

            <div class="accordion-container" style="margin-bottom: 24px;">
                <!-- 1. Halaman Profil Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-landmark" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Profil Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="profile_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="profile_page_description" name="profile_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman profil desa...">{{ old('profile_page_description', $profile->profile_page_description ?? 'Mengenal lebih dekat mengenai Desa ' . ($profile->village_name ?? 'Duren Tengaran') . '.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Halaman UMKM & Produk Unggulan -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-store" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman UMKM & Produk Unggulan
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="umkm_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="umkm_page_description" name="umkm_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman UMKM...">{{ old('umkm_page_description', $profile->umkm_page_description ?? 'Temukan berbagai produk unggulan dan potensi UMKM masyarakat Desa Duren Tengaran.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. Halaman Pariwisata -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-map" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Pariwisata
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="tourism_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="tourism_page_description" name="tourism_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman pariwisata...">{{ old('tourism_page_description', $profile->tourism_page_description ?? 'Jelajahi keindahan alam dan potensi wisata yang ada di Desa Duren Tengaran.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 4. Halaman Berita Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-newspaper" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Berita Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="news_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="news_page_description" name="news_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman berita desa...">{{ old('news_page_description', $profile->news_page_description ?? 'Ikuti terus berita dan informasi terbaru seputar kegiatan di Desa Duren Tengaran.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Halaman Aparatur Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-users" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Aparatur Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="officials_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="officials_page_description" name="officials_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman aparatur desa...">{{ old('officials_page_description', $profile->officials_page_description ?? 'Susunan perangkat desa yang bertugas melayani masyarakat Desa Duren Tengaran.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 6. Halaman Peraturan Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-gavel" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Peraturan Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="regulations_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="regulations_page_description" name="regulations_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman peraturan desa...">{{ old('regulations_page_description', $profile->regulations_page_description ?? 'Dokumen resmi dan produk hukum yang berlaku di Desa Duren Tengaran.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 7. Halaman Lembaga Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-sitemap" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Lembaga Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="institutions_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="institutions_page_description" name="institutions_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman lembaga desa...">{{ old('institutions_page_description', $profile->institutions_page_description ?? 'Informasi mengenai berbagai lembaga kemasyarakatan yang ada di Desa Duren Tengaran.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 8. Halaman Pertanian & Perkebunan -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-wheat-awn" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Pertanian & Perkebunan
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="agriculture_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="agriculture_page_description" name="agriculture_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman pertanian...">{{ old('agriculture_page_description', $profile->agriculture_page_description ?? 'Potensi dan komoditas unggulan sektor pertanian dan perkebunan Desa Duren.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 9. Halaman Organisasi Masyarakat (Ormas) -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-people-group" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Organisasi Masyarakat (Ormas)
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="organizations_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="organizations_page_description" name="organizations_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman organisasi masyarakat...">{{ old('organizations_page_description', $profile->organizations_page_description ?? 'Mengenal berbagai organisasi sosial, keagamaan, olahraga, dan kepemudaan yang aktif bergerak di tengah masyarakat secara swadaya.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 10. Halaman Pengumuman Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-bullhorn" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Pengumuman Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="announcements_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="announcements_page_description" name="announcements_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman pengumuman desa...">{{ old('announcements_page_description', $profile->announcements_page_description ?? 'Informasi penting, edaran resmi, dan agenda terbaru mengenai pelayanan publik serta kemasyarakatan.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 11. Halaman Panduan Layanan Publik -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-file-invoice" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Panduan Layanan Publik
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="public_services_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="public_services_page_description" name="public_services_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman panduan layanan publik...">{{ old('public_services_page_description', $profile->public_services_page_description ?? 'Informasi dan persyaratan untuk berbagai layanan administrasi kependudukan dan kemasyarakatan.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 12. Halaman Galeri Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-images" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Galeri Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="gallery_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="gallery_page_description" name="gallery_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman galeri dokumentasi...">{{ old('gallery_page_description', $profile->gallery_page_description ?? 'Dokumentasi foto berbagai kegiatan sosial, pembangunan sarana prasarana, keagamaan, kebudayaan, serta potensi pariwisata.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 13. Halaman Statistik Penduduk -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-chart-line" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Statistik Penduduk
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="statistics_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="statistics_page_description" name="statistics_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman statistik kependudukan...">{{ old('statistics_page_description', $profile->statistics_page_description ?? 'Visualisasi data demografi penduduk secara transparan berdasarkan data kependudukan resmi semester dan tahun terbaru.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 14. Halaman Kontak Desa -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>
                            <i class="fa-solid fa-address-book" style="color: var(--primary-light); margin-right: 10px;"></i>
                            Halaman Kontak Desa
                        </h4>
                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group" style="margin: 0;">
                            <label for="contact_page_description" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block;">Deskripsi Banner Halaman</label>
                            <textarea id="contact_page_description" name="contact_page_description" class="form-control" rows="2"
                                placeholder="Masukkan deskripsi halaman kontak resmi...">{{ old('contact_page_description', $profile->contact_page_description ?? 'Pemerintah berkomitmen melayani kebutuhan informasi dan administrasi masyarakat. Silakan hubungi kami melalui saluran informasi resmi.') }}</textarea>
                        </div>
                    </div>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionItems = document.querySelectorAll('.accordion-item');
        accordionItems.forEach(item => {
            const header = item.querySelector('.accordion-header');
            if (header) {
                header.addEventListener('click', function(e) {
                    // Prevent action if clicked inside form inputs
                    if (e.target.closest('input') || e.target.closest('textarea')) {
                        return;
                    }

                    const isExpanded = item.classList.contains('expanded');
                    
                    // Collapse all others for a cleaner accordion layout
                    accordionItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('expanded');
                        }
                    });
                    
                    if (isExpanded) {
                        item.classList.remove('expanded');
                    } else {
                        item.classList.add('expanded');
                    }
                });
            }
        });
    });
</script>
@endsection
