@extends('admin.layouts.admin')

@section('title', 'Sunting Profil Desa')

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
        border: 2px dashed var(--primary);
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
    <div class="card" style="max-width: 1000px; margin: 0 auto;">
        <div class="card-header">
            <h2>Sunting Profil & Urutan Bagian Halaman</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin: 20px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" style="padding: 24px;">
            @csrf
            @method('PUT')

            <!-- KELOMPOK 1: INFORMASI UMUM -->
            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 30px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-top: 0;">
                    <i class="fa-solid fa-circle-info"></i> Identitas & Informasi Dasar Desa
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
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
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset($profile->logo) }}" alt="Logo Desa" style="height: 60px; object-fit: contain;">
                        </div>
                    @endif
                    <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                </div>
            </div>

            <!-- DRAGGABLE SORTABLE SECTIONS CONTAINER -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 5px;">
                    <i class="fa-solid fa-arrows-up-down-left-right"></i> Tata Letak & Bagian Halaman Profil
                </h3>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 20px; line-height: 1.4;">
                    <i class="fa-solid fa-circle-info"></i> Tarik dan lepaskan <strong>(Drag & Drop)</strong> bagian di bawah ini untuk mengurutkan posisinya di halaman profil depan. Klik judul bagian untuk menampilkan/mengedit isian formnya.
                </p>

                <input type="hidden" id="profile_sections_order" name="profile_sections_order" value="{{ $profile->profile_sections_order }}">

                <div class="sortable-sections" id="sortable-profile-sections">
                    @foreach($sectionsOrder as $section)
                        @if($section === 'detail_wilayah')
                            <!-- BAGIAN: Detail Wilayah & Geografis -->
                            <div class="sortable-item" data-section-id="detail_wilayah" draggable="true">
                                <div class="sortable-header">
                                    <h4>
                                        <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                        <i class="fa-solid fa-map-location-dot"></i> Detail Wilayah & Geografis
                                    </h4>
                                    <div class="section-actions">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish:</span>
                                        <label class="switch">
                                            <input type="checkbox" name="publish_village_detail" value="1" {{ old('publish_village_detail', $profile->publish_village_detail ?? true) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="sortable-content">
                                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" id="kecamatan" name="kecamatan" class="form-control"
                                                value="{{ old('kecamatan', $villageDetail->kecamatan ?? '') }}" placeholder="Kecamatan">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="kabupaten">Kabupaten</label>
                                            <input type="text" id="kabupaten" name="kabupaten" class="form-control"
                                                value="{{ old('kabupaten', $villageDetail->kabupaten ?? '') }}" placeholder="Kabupaten">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" id="provinsi" name="provinsi" class="form-control"
                                                value="{{ old('provinsi', $villageDetail->provinsi ?? '') }}" placeholder="Provinsi">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="zip_code">Kode Pos</label>
                                            <input type="text" id="zip_code" name="zip_code" class="form-control"
                                                value="{{ old('zip_code', $villageDetail->zip_code ?? '') }}" placeholder="Kode Pos">
                                        </div>
                                    </div>

                                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px; margin-top: 20px;">
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="area_size">Luas Wilayah (Ha)</label>
                                            <input type="number" id="area_size" name="area_size" class="form-control"
                                                value="{{ old('area_size', $demografi->luas_wilayah->male_count ?? 0) }}" min="0" placeholder="Luas Wilayah (Ha)">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="population_count">Jumlah Penduduk (Jiwa)</label>
                                            <input type="number" id="population_count" name="population_count" class="form-control"
                                                value="{{ old('population_count', ($demografi->total_penduduk->male_count ?? 0) + ($demografi->total_penduduk->female_count ?? 0)) }}" min="0" placeholder="Jumlah Penduduk (Jiwa)">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="dusun_count">Jumlah Dusun</label>
                                            <input type="number" id="dusun_count" name="dusun_count" class="form-control"
                                                value="{{ old('dusun_count', $villageDetail->dusun_count ?? 0) }}" min="0" placeholder="Jumlah Dusun">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="rw_count">Jumlah RW</label>
                                            <input type="number" id="rw_count" name="rw_count" class="form-control"
                                                value="{{ old('rw_count', $villageDetail->rw_count ?? 0) }}" min="0" placeholder="Jumlah RW">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="rt_count">Jumlah RT</label>
                                            <input type="number" id="rt_count" name="rt_count" class="form-control"
                                                value="{{ old('rt_count', $villageDetail->rt_count ?? 0) }}" min="0" placeholder="Jumlah RT">
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 0; margin-top: 20px;">
                                        <label for="village_detail_image">Foto Profil / Detail Desa (Sebelah Kanan Tabel)</label>
                                        @if($profile->village_detail_image)
                                            <div style="margin-bottom: 10px;">
                                                <img src="{{ asset($profile->village_detail_image) }}" alt="Foto Profil Desa"
                                                    style="height: 100px; max-width: 100%; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                                            </div>
                                        @endif
                                        <input type="file" id="village_detail_image" name="village_detail_image" class="form-control" accept="image/*">
                                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB. Gambar ini akan tampil di sebelah kanan tabel profil desa.</span>
                                    </div>
                                </div>
                            </div>
                        @elseif($section === 'sambutan_kades')
                            <!-- BAGIAN: Sambutan Kepala Desa -->
                            <div class="sortable-item" data-section-id="sambutan_kades" draggable="true">
                                <div class="sortable-header">
                                    <h4>
                                        <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                        <i class="fa-solid fa-user-tie"></i> Sambutan Kepala Desa
                                    </h4>
                                    <div class="section-actions">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish:</span>
                                        <label class="switch">
                                            <input type="checkbox" name="publish_headman_greeting" value="1" {{ old('publish_headman_greeting', $profile->publish_headman_greeting) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="sortable-content">
                                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="headman_name">Nama Kepala Desa</label>
                                            <input type="text" id="headman_name" name="headman_name" class="form-control"
                                                value="{{ old('headman_name', $profile->headman_name) }}"
                                                placeholder="Nama Kepala Desa Beserta Gelar">
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
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
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="headman_greeting">Kata Sambutan Kepala Desa</label>
                                        <textarea id="headman_greeting" name="headman_greeting" class="form-control" style="min-height: 120px;"
                                            placeholder="Tuliskan sambutan resmi Kepala Desa untuk pengunjung website...">{{ old('headman_greeting', $profile->headman_greeting) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @elseif($section === 'sejarah')
                            <!-- BAGIAN: Sejarah Desa -->
                            <div class="sortable-item" data-section-id="sejarah" draggable="true">
                                <div class="sortable-header">
                                    <h4>
                                        <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                        <i class="fa-solid fa-clock-rotate-left"></i> Sejarah Desa
                                    </h4>
                                    <div class="section-actions">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish:</span>
                                        <label class="switch">
                                            <input type="checkbox" name="publish_history" value="1" {{ old('publish_history', $profile->publish_history) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="sortable-content">
                                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 0;">
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label for="history">Sejarah Singkat Desa</label>
                                            <textarea id="history" name="history" class="form-control"
                                                style="min-height: 150px;">{{ old('history', $profile->history) }}</textarea>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">
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
                                </div>
                            </div>
                        @elseif($section === 'visi_misi')
                            <!-- BAGIAN: Visi & Misi Desa -->
                            <div class="sortable-item" data-section-id="visi_misi" draggable="true">
                                <div class="sortable-header">
                                    <h4>
                                        <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                        <i class="fa-solid fa-bullseye"></i> Visi & Misi Desa
                                    </h4>
                                    <div class="section-actions">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish:</span>
                                        <label class="switch">
                                            <input type="checkbox" name="publish_vision_mission" value="1" {{ old('publish_vision_mission', $profile->publish_vision_mission) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="sortable-content">
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label for="vision">Visi Desa</label>
                                        <textarea id="vision" name="vision" class="form-control" style="min-height: 80px;"
                                            placeholder="Visi pembangunan jangka panjang desa...">{{ old('vision', $profile->vision) }}</textarea>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="mission">Misi Desa (Gunakan baris baru untuk setiap poin misi)</label>
                                        <textarea id="mission" name="mission" class="form-control" style="min-height: 120px;"
                                            placeholder="Misi 1. ...&#10;Misi 2. ...">{{ old('mission', $profile->mission) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @elseif($section === 'struktur_organisasi')
                            <!-- BAGIAN: Struktur Organisasi -->
                            <div class="sortable-item" data-section-id="struktur_organisasi" draggable="true">
                                <div class="sortable-header">
                                    <h4>
                                        <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                        <i class="fa-solid fa-sitemap"></i> Struktur Organisasi
                                    </h4>
                                    <div class="section-actions">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish:</span>
                                        <label class="switch">
                                            <input type="checkbox" name="publish_organization_structure" value="1" {{ old('publish_organization_structure', $profile->publish_organization_structure) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="sortable-content">
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="organization_structure_image">Bagan Struktur Organisasi Pemerintah Desa (Gambar)</label>
                                        @if($profile->organization_structure_image)
                                            <div style="margin-bottom: 15px;">
                                                <img src="{{ asset($profile->organization_structure_image) }}" alt="Struktur Organisasi"
                                                    style="max-height: 250px; max-width: 100%; border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                                            </div>
                                        @endif
                                        <input type="file" id="organization_structure_image" name="organization_structure_image"
                                            class="form-control" accept="image/*">
                                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal file: 2 MB.</span>
                                    </div>
                                </div>
                            </div>
                        @elseif($section === 'geografis_dusun')
                            <!-- BAGIAN: Geografis & Wilayah Dusun -->
                            <div class="sortable-item" data-section-id="geografis_dusun" draggable="true">
                                <div class="sortable-header">
                                    <h4>
                                        <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                        <i class="fa-solid fa-map"></i> Geografis & Peta Wilayah Dusun
                                    </h4>
                                    <div class="section-actions">
                                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">Publish:</span>
                                        <label class="switch">
                                            <input type="checkbox" name="publish_geographics" value="1" {{ old('publish_geographics', $profile->publish_geographics) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <button type="button" class="btn-toggle-expand"><i class="fa-solid fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="sortable-content">
                                    <div class="form-group" style="margin-bottom: 25px;">
                                        <label for="google_maps_url">Link Google Maps (Peta Utama Desa)</label>
                                        <input type="text" id="google_maps_url" name="google_maps_url" class="form-control"
                                            value="{{ old('google_maps_url', $profile->google_maps_url) }}"
                                            placeholder="Masukkan link Google Maps (https://www.google.com/maps/embed?...)">
                                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">
                                            Peta ini akan digunakan sebagai Google Maps interaktif utama di halaman profil desa.
                                        </span>
                                    </div>

                                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--primary-light); margin-top: 25px; margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 5px;">
                                        <i class="fa-solid fa-map-pin"></i> Link Google Maps Per Dusun
                                    </h4>

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                        <div class="form-group">
                                            <label for="map_miri">Peta Dusun Miri</label>
                                            <input type="text" id="map_miri" name="map_miri" class="form-control"
                                                value="{{ old('map_miri', $profile->map_miri) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_dukuh">Peta Dusun Dukuh</label>
                                            <input type="text" id="map_dukuh" name="map_dukuh" class="form-control"
                                                value="{{ old('map_dukuh', $profile->map_dukuh) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_krajan">Peta Dusun Krajan</label>
                                            <input type="text" id="map_krajan" name="map_krajan" class="form-control"
                                                value="{{ old('map_krajan', $profile->map_krajan) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_babadan">Peta Dusun Babadan</label>
                                            <input type="text" id="map_babadan" name="map_babadan" class="form-control"
                                                value="{{ old('map_babadan', $profile->map_babadan) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_ngepringan">Peta Dusun Ngepringan</label>
                                            <input type="text" id="map_ngepringan" name="map_ngepringan" class="form-control"
                                                value="{{ old('map_ngepringan', $profile->map_ngepringan) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_tanubayu">Peta Dusun Tanubayu</label>
                                            <input type="text" id="map_tanubayu" name="map_tanubayu" class="form-control"
                                                value="{{ old('map_tanubayu', $profile->map_tanubayu) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_gading">Peta Dusun Gading</label>
                                            <input type="text" id="map_gading" name="map_gading" class="form-control"
                                                value="{{ old('map_gading', $profile->map_gading) }}" placeholder="Link Google Maps">
                                        </div>

                                        <div class="form-group">
                                            <label for="map_karangwuni">Peta Dusun Karangwuni</label>
                                            <input type="text" id="map_karangwuni" name="map_karangwuni" class="form-control"
                                                value="{{ old('map_karangwuni', $profile->map_karangwuni) }}" placeholder="Link Google Maps">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- KELOMPOK 6: KONTAK & MEDIA SOSIAL -->
            <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 30px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-top: 0;">
                    <i class="fa-solid fa-address-book"></i> Kontak & Media Sosial Resmi (Ditampilkan pada Footer)
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="phone">No. Telepon / Fax</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="{{ old('phone', $profile->phone) }}">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="email">Email Resmi Desa</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $profile->email) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="address">Alamat Kantor Kepala Desa</label>
                    <textarea id="address" name="address" class="form-control"
                        style="min-height: 80px;">{{ old('address', $profile->address) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="facebook">Username/Link Facebook</label>
                        <input type="text" id="facebook" name="facebook" class="form-control"
                            value="{{ old('facebook', $profile->facebook) }}" placeholder="Contoh: # atau url halaman">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="instagram">Username/Link Instagram</label>
                        <input type="text" id="instagram" name="instagram" class="form-control"
                            value="{{ old('instagram', $profile->instagram) }}" placeholder="Contoh: @desa.duren">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="youtube">Username/Link YouTube</label>
                        <input type="text" id="youtube" name="youtube" class="form-control"
                            value="{{ old('youtube', $profile->youtube) }}" placeholder="Contoh: @durentengaran">
                    </div>
                </div>
            </div>

            <!-- PUBLIKASI HALAMAN TAMBAHAN -->
            <div style="background-color: #fff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; margin-bottom: 30px;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-top: 0;">
                    <i class="fa-solid fa-cubes"></i> Publikasi Halaman Tambahan (Menu Utama)
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
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
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                    <i class="fa-solid fa-circle-check"></i> Simpan Profil Desa
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const list = document.getElementById('sortable-profile-sections');
        const items = list.querySelectorAll('.sortable-item');
        const orderInput = document.getElementById('profile_sections_order');

        // 1. Accordion functionality (Toggle Expand/Collapse)
        items.forEach(item => {
            const header = item.querySelector('.sortable-header');
            
            header.addEventListener('click', function(e) {
                // Prevent accordion toggle when clicking on drag handle, switches or inputs
                if (e.target.closest('.drag-handle') || e.target.closest('.switch') || e.target.closest('input') || e.target.closest('.slider')) {
                    return;
                }
                
                const isExpanded = item.classList.contains('expanded');
                
                // Toggle clicked item
                if (isExpanded) {
                    item.classList.remove('expanded');
                } else {
                    item.classList.add('expanded');
                }
            });
        });

        // 2. Drag and Drop Sorting functionality
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