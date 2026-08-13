@extends('admin.layouts.admin')

@section('title', 'Sunting Halaman Beranda')

@section('styles')
<style>
    .sortable-sections {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 30px;
    }

    .sortable-item {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
        overflow: hidden;
    }

    .sortable-item.dragging {
        opacity: 0.5;
        border: 2px dashed var(--primary-light);
    }

    .sortable-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        background: #f8fafc;
        border-bottom: 1px solid transparent;
        cursor: grab;
        user-select: none;
    }

    .sortable-header:active {
        cursor: grabbing;
    }

    .sortable-header h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .drag-handle {
        color: #94a3b8;
        margin-right: 15px;
        font-size: 1.1rem;
        cursor: grab;
    }

    .section-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-toggle-expand {
        background: none;
        border: none;
        color: #64748b;
        font-size: 1rem;
        cursor: pointer;
        padding: 5px;
        transition: transform 0.3s ease;
    }

    .sortable-item.expanded .btn-toggle-expand {
        transform: rotate(180deg);
    }

    .sortable-item.expanded .sortable-header {
        border-bottom-color: var(--border-color);
    }

    .sortable-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 20px;
    }

    .sortable-item.expanded .sortable-content {
        max-height: 2000px;
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
            <li style="color: var(--text-dark); font-weight: 600;">Pengaturan Beranda</li>
        </ol>
    </nav>

    <div style="max-width: 800px; margin: 0 auto;">


        <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 1. GAMBAR LATAR (HEADER UTAMA) - PALING ATAS -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header" style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                        <i class="fa-solid fa-image"></i> Gambar Latar (Header Utama)
                    </h3>
                </div>
                <div style="padding: 0 10px 10px 10px;">
                    <div class="form-group">
                        <label for="hero_bg_image">Gambar Latar (Beranda)</label>
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
            </div>

            <!-- 2. TATA LETAK & BAGIAN DRAG & DROP -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header" style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin: 0;">
                        <i class="fa-solid fa-layer-group"></i> Tata Letak & Publikasi Bagian Halaman Beranda
                    </h3>
                </div>
                
                <div style="padding: 0 10px 10px 10px;">
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px; line-height: 1.5; background: #eff6ff; border: 1px solid #bfdbfe; padding: 12px 16px; border-radius: var(--radius-md);">
                        <i class="fa-solid fa-circle-info" style="color: var(--primary-light); margin-right: 5px;"></i>
                        Tarik dan lepaskan <strong>(Drag & Drop)</strong> bagian di bawah ini untuk mengurutkan posisinya di beranda depan. Anda juga dapat mempublikasikan/menyembunyikan bagian tersebut menggunakan switch toggle.
                    </p>

                    <!-- Hidden order input -->
                    <input type="hidden" id="homepage_sections_order" name="homepage_sections_order" value="{{ $profile->homepage_sections_order }}">

                    @php
                        $defaultOrder = ['about', 'potency', 'umkm', 'tourism', 'news', 'gallery'];
                        $sections = ($profile && $profile->homepage_sections_order) 
                            ? explode(',', $profile->homepage_sections_order) 
                            : $defaultOrder;
                            
                        foreach($defaultOrder as $sec) {
                            if(!in_array($sec, $sections)) {
                                $sections[] = $sec;
                            }
                        }
                    @endphp

                    <div class="sortable-sections" id="sortable-homepage-sections">
                        @foreach($sections as $section)
                            @if($section === 'about')
                                <!-- BAGIAN 1: Selamat Datang / Tentang Desa -->
                                <div class="sortable-item" data-section-id="about" id="section-about">
                                    <div class="sortable-header">
                                        <h4>
                                            <i class="fa-solid fa-grip-vertical drag-handle"></i>
                                            <i class="fa-solid fa-house-chimney" style="color: var(--primary-light);"></i>
                                            Bagian Selamat Datang / Tentang Desa
                                        </h4>
                                        <div class="section-actions">
                                            <label class="switch" style="margin: 0;" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="global-publish-toggle" data-key="publish_about" {{ ($profile->publish_about ?? true) ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <button type="button" class="btn-toggle-expand" style="cursor: pointer;"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="sortable-content">
                                        <div class="form-group" style="margin-bottom: 20px;">
                                            <label for="about_subtitle">Subjudul Tentang Desa (Beranda)</label>
                                            <input type="text" id="about_subtitle" name="about_subtitle" class="form-control" value="{{ old('about_subtitle', $profile->about_subtitle ?? 'TENTANG DESA') }}" placeholder="Contoh: TENTANG DESA">
                                        </div>

                                        <div class="form-group" style="margin-bottom: 20px;">
                                            <label for="about_text">Deskripsi Tentang Desa (Beranda)</label>
                                            <textarea id="about_text" name="about_text" class="form-control"
                                                style="min-height: 150px; font-size: 0.95rem; line-height: 1.6;"
                                                placeholder="Tuliskan deskripsi singkat profil desa untuk ditampilkan di halaman beranda...">{{ old('about_text', $profile->about_text) }}</textarea>
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
                                </div>
                            @elseif($section === 'potency')
                                <!-- BAGIAN 2: Potensi Desa -->
                                <div class="sortable-item" data-section-id="potency" id="section-potency">
                                    <div class="sortable-header">
                                        <h4>
                                            <i class="fa-solid fa-grip-vertical drag-handle"></i>
                                            <i class="fa-solid fa-wheat-awn" style="color: var(--primary-light);"></i>
                                            Bagian Potensi Desa
                                        </h4>
                                        <div class="section-actions">
                                            <label class="switch" style="margin: 0;" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="global-publish-toggle" data-key="show_potency_on_home" {{ ($profile->show_potency_on_home ?? true) ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <button type="button" class="btn-toggle-expand" style="cursor: pointer;"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="sortable-content">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                            <div class="form-group">
                                                <label for="potency_subtitle">Subjudul Potensi Desa (Beranda)</label>
                                                <input type="text" id="potency_subtitle" name="potency_subtitle" class="form-control" value="{{ old('potency_subtitle', $profile->potency_subtitle ?? 'Potensi Desa') }}" placeholder="Contoh: Potensi Desa">
                                            </div>
                                            <div class="form-group">
                                                <label for="potency_title">Judul Utama Potensi Desa (Beranda)</label>
                                                <input type="text" id="potency_title" name="potency_title" class="form-control" value="{{ old('potency_title', $profile->potency_title ?? 'Kekayaan & Komoditas Unggulan') }}" placeholder="Contoh: Kekayaan & Komoditas Unggulan">
                                            </div>
                                        </div>

                                        <div style="border-top: 1px solid var(--border-color); padding-top: 15px;">
                                            <h5 style="margin: 0 0 15px 0; font-size: 0.9rem; font-weight: 700; color: var(--text-dark);">Deskripsi Singkat Kotak Potensi</h5>
                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                                <div class="form-group">
                                                    <label for="potency_agriculture_desc">Deskripsi Pertanian</label>
                                                    <input type="text" id="potency_agriculture_desc" name="potency_agriculture_desc" class="form-control" value="{{ old('potency_agriculture_desc', $profile->potency_agriculture_desc ?? 'Lahan subur dengan komoditas unggulan padi dan palawija.') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="potency_animal_husbandry_desc">Deskripsi Peternakan</label>
                                                    <input type="text" id="potency_animal_husbandry_desc" name="potency_animal_husbandry_desc" class="form-control" value="{{ old('potency_animal_husbandry_desc', $profile->potency_animal_husbandry_desc ?? 'Pusat pengembangan hewan ternak seperti sapi dan kambing.') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="potency_umkm_desc">Deskripsi UMKM</label>
                                                    <input type="text" id="potency_umkm_desc" name="potency_umkm_desc" class="form-control" value="{{ old('potency_umkm_desc', $profile->potency_umkm_desc ?? 'Produk kerajinan dan makanan khas hasil karya warga desa.') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="potency_tourism_desc">Deskripsi Pariwisata</label>
                                                    <input type="text" id="potency_tourism_desc" name="potency_tourism_desc" class="form-control" value="{{ old('potency_tourism_desc', $profile->potency_tourism_desc ?? 'Pesona alam asri yang menarik bagi wisatawan lokal.') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($section === 'umkm')
                                <!-- BAGIAN 3: Produk Lokal -->
                                <div class="sortable-item" data-section-id="umkm" id="section-umkm">
                                    <div class="sortable-header">
                                        <h4>
                                            <i class="fa-solid fa-grip-vertical drag-handle"></i>
                                            <i class="fa-solid fa-shop" style="color: var(--primary-light);"></i>
                                            Bagian Produk Lokal (UMKM)
                                        </h4>
                                        <div class="section-actions">
                                            <label class="switch" style="margin: 0;" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="global-publish-toggle" data-key="show_umkm_on_home" {{ ($profile->show_umkm_on_home ?? true) ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <button type="button" class="btn-toggle-expand" style="cursor: pointer;"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="sortable-content">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div class="form-group">
                                                <label for="umkm_subtitle">Subjudul Bagian UMKM (Beranda)</label>
                                                <input type="text" id="umkm_subtitle" name="umkm_subtitle" class="form-control" value="{{ old('umkm_subtitle', $profile->umkm_subtitle ?? 'Produk Lokal') }}" placeholder="Contoh: Produk Lokal">
                                            </div>
                                            <div class="form-group">
                                                <label for="umkm_title">Judul Utama Bagian UMKM (Beranda)</label>
                                                <input type="text" id="umkm_title" name="umkm_title" class="form-control" value="{{ old('umkm_title', $profile->umkm_title ?? 'UMKM Unggulan Desa') }}" placeholder="Contoh: UMKM Unggulan Desa">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($section === 'tourism')
                                <!-- BAGIAN Pariwisata -->
                                <div class="sortable-item" data-section-id="tourism" id="section-tourism">
                                    <div class="sortable-header">
                                        <h4>
                                            <i class="fa-solid fa-grip-vertical drag-handle"></i>
                                            <i class="fa-solid fa-map-location-dot" style="color: var(--primary-light);"></i>
                                            Bagian Pariwisata & Budaya
                                        </h4>
                                        <div class="section-actions">
                                            <label class="switch" style="margin: 0;" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="global-publish-toggle" data-key="show_tourism_on_home" {{ ($profile->show_tourism_on_home ?? true) ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <button type="button" class="btn-toggle-expand" style="cursor: pointer;"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="sortable-content">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div class="form-group">
                                                <label for="tourism_subtitle">Subjudul Bagian Pariwisata (Beranda)</label>
                                                <input type="text" id="tourism_subtitle" name="tourism_subtitle" class="form-control" value="{{ old('tourism_subtitle', $profile->tourism_subtitle ?? 'Destinasi Wisata') }}" placeholder="Contoh: Destinasi Wisata">
                                            </div>
                                            <div class="form-group">
                                                <label for="tourism_title">Judul Utama Bagian Pariwisata (Beranda)</label>
                                                <input type="text" id="tourism_title" name="tourism_title" class="form-control" value="{{ old('tourism_title', $profile->tourism_title ?? 'Pariwisata & Budaya Desa') }}" placeholder="Contoh: Pariwisata & Budaya Desa">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($section === 'news')
                                <!-- BAGIAN 4: Kabar Terkini -->
                                <div class="sortable-item" data-section-id="news" id="section-news">
                                    <div class="sortable-header">
                                        <h4>
                                            <i class="fa-solid fa-grip-vertical drag-handle"></i>
                                            <i class="fa-solid fa-newspaper" style="color: var(--primary-light);"></i>
                                            Bagian Kabar Terkini (Berita)
                                        </h4>
                                        <div class="section-actions">
                                            <label class="switch" style="margin: 0;" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="global-publish-toggle" data-key="show_news_on_home" {{ ($profile->show_news_on_home ?? true) ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <button type="button" class="btn-toggle-expand" style="cursor: pointer;"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="sortable-content">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div class="form-group">
                                                <label for="news_subtitle">Subjudul Bagian Berita (Beranda)</label>
                                                <input type="text" id="news_subtitle" name="news_subtitle" class="form-control" value="{{ old('news_subtitle', $profile->news_subtitle ?? 'Kabar Terkini') }}" placeholder="Contoh: Kabar Terkini">
                                            </div>
                                            <div class="form-group">
                                                <label for="news_title">Judul Utama Bagian Berita (Beranda)</label>
                                                <input type="text" id="news_title" name="news_title" class="form-control" value="{{ old('news_title', $profile->news_title ?? 'Berita & Pengumuman') }}" placeholder="Contoh: Berita & Pengumuman">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($section === 'gallery')
                                <!-- BAGIAN 5: Pesona Desa -->
                                <div class="sortable-item" data-section-id="gallery" id="section-gallery">
                                    <div class="sortable-header">
                                        <h4>
                                            <i class="fa-solid fa-grip-vertical drag-handle"></i>
                                            <i class="fa-solid fa-images" style="color: var(--primary-light);"></i>
                                            Bagian Pesona Desa (Galeri)
                                        </h4>
                                        <div class="section-actions">
                                            <label class="switch" style="margin: 0;" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="global-publish-toggle" data-key="show_gallery_on_home" {{ ($profile->show_gallery_on_home ?? true) ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <button type="button" class="btn-toggle-expand" style="cursor: pointer;"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="sortable-content">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div class="form-group">
                                                <label for="gallery_subtitle">Subjudul Bagian Galeri (Beranda)</label>
                                                <input type="text" id="gallery_subtitle" name="gallery_subtitle" class="form-control" value="{{ old('gallery_subtitle', $profile->gallery_subtitle ?? 'Pesona Desa') }}" placeholder="Contoh: Pesona Desa">
                                            </div>
                                            <div class="form-group">
                                                <label for="gallery_title">Judul Utama Bagian Galeri (Beranda)</label>
                                                <input type="text" id="gallery_title" name="gallery_title" class="form-control" value="{{ old('gallery_title', $profile->gallery_title ?? 'Galeri Desa') }}" placeholder="Contoh: Galeri Desa">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- SIMPAN BUTTON -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px; margin-bottom: 40px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                    <i class="fa-solid fa-circle-check"></i> Simpan Pengaturan Beranda
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Expand / Collapse sortable content
        const sortableItems = document.querySelectorAll('.sortable-item');
        sortableItems.forEach(item => {
            const header = item.querySelector('.sortable-header');
            const toggleBtn = item.querySelector('.btn-toggle-expand');
            
            if (header && toggleBtn) {
                header.addEventListener('click', function(e) {
                    // Prevent expand/collapse if click is on switch or input
                    if (e.target.closest('.switch') || e.target.closest('input') || e.target.closest('.slider')) {
                        return;
                    }
                    
                    const isExpanded = item.classList.contains('expanded');
                    
                    // Collapse all others
                    sortableItems.forEach(otherItem => {
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

        // 2. Drag and Drop Sorting functionality
        const list = document.getElementById('sortable-homepage-sections');
        const items = list.querySelectorAll('.sortable-item');
        const orderInput = document.getElementById('homepage_sections_order');
        let dragSrcEl = null;

        function handleDragStart(e) {
            this.classList.add('dragging');
            dragSrcEl = this;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.dataTransfer.dropEffect = 'move';
            return false;
        }

        function handleDragEnter(e) {
            this.classList.add('drag-over');
        }

        function handleDragLeave(e) {
            this.classList.remove('drag-over');
        }

        function handleDrop(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            }

            if (dragSrcEl !== this) {
                const itemsArr = Array.from(list.querySelectorAll('.sortable-item'));
                const srcIndex = itemsArr.indexOf(dragSrcEl);
                const targetIndex = itemsArr.indexOf(this);

                if (srcIndex < targetIndex) {
                    this.parentNode.insertBefore(dragSrcEl, this.nextSibling);
                } else {
                    this.parentNode.insertBefore(dragSrcEl, this);
                }
                
                updateOrder();
            }
            return false;
        }

        function handleDragEnd(e) {
            items.forEach(item => {
                item.classList.remove('dragging');
                item.classList.remove('drag-over');
            });
        }

        function updateOrder() {
            const updatedItems = list.querySelectorAll('.sortable-item');
            const order = Array.from(updatedItems).map(item => item.getAttribute('data-section-id'));
            orderInput.value = order.join(',');
        }

        items.forEach(item => {
            // Make header draggable
            const header = item.querySelector('.sortable-header');
            if (header) {
                item.setAttribute('draggable', 'true');
            }
            
            item.addEventListener('dragstart', handleDragStart, false);
            item.addEventListener('dragenter', handleDragEnter, false);
            item.addEventListener('dragover', handleDragOver, false);
            item.addEventListener('dragleave', handleDragLeave, false);
            item.addEventListener('drop', handleDrop, false);
            item.addEventListener('dragend', handleDragEnd, false);
        });

        // Initialize order
        updateOrder();
    });
</script>
@endsection