<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use App\Models\VillageDetail;
use App\Models\DemographicStatistic;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = VillageProfile::first();
        if (!$profile) {
            $profile = new VillageProfile();
        }

         $request->validate([
            'village_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'headman_name' => 'nullable|string|max:255',
            'headman_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'headman_greeting' => 'nullable|string',
            'history' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|string',
            'office_hours' => 'nullable|string|max:255',
            'organization_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'history_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_headman_greeting' => 'nullable|boolean',
            'publish_vision_mission' => 'nullable|boolean',
            'publish_history' => 'nullable|boolean',
            'publish_organization_structure' => 'nullable|boolean',
            'publish_geographics' => 'nullable|boolean',
            'publish_statistics' => 'nullable|boolean',
            'publish_officials' => 'nullable|boolean',
            'publish_regulations' => 'nullable|boolean',
            'publish_news' => 'nullable|boolean',
            'publish_tourism' => 'nullable|boolean',
            'publish_umkm' => 'nullable|boolean',
            'publish_agriculture' => 'nullable|boolean',
            'publish_institutions' => 'nullable|boolean',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'area_size' => 'nullable|integer|min:0',
            'population_count' => 'nullable|integer|min:0',
            'dusun_count' => 'nullable|integer|min:0',
            'rw_count' => 'nullable|integer|min:0',
            'rt_count' => 'nullable|integer|min:0',
            'publish_village_detail' => 'nullable|boolean',
            'village_detail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'profile_sections_order' => 'nullable|string',
            'map_miri' => 'nullable|string',
            'map_dukuh' => 'nullable|string',
            'map_krajan' => 'nullable|string',
            'map_babadan' => 'nullable|string',
            'map_ngepringan' => 'nullable|string',
            'map_tanubayu' => 'nullable|string',
            'map_gading' => 'nullable|string',
            'map_karangwuni' => 'nullable|string',
        ]);

        $data = $request->except([
            'logo', 'headman_photo', 'organization_structure_image', 'history_image', 'village_detail_image',
            'kecamatan', 'kabupaten', 'provinsi', 'zip_code', 'area_size', 'population_count', 'dusun_count', 'rw_count', 'rt_count'
        ]);

        $profileToggleFields = [
            'publish_headman_greeting',
            'publish_vision_mission',
            'publish_history',
            'publish_organization_structure',
            'publish_geographics',
            'publish_agriculture',
            'publish_institutions',
            'publish_village_detail',
        ];

        foreach ($profileToggleFields as $toggleField) {
            $data[$toggleField] = $request->has($toggleField) ? true : false;
        }

        // Upload images
        $imageFields = ['logo', 'headman_photo', 'organization_structure_image', 'history_image', 'village_detail_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image
                if ($profile->$field && file_exists(public_path($profile->$field))) {
                    @unlink(public_path($profile->$field));
                }

                $file = $request->file($field);
                $filename = $field . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profile'), $filename);
                $data[$field] = 'uploads/profile/' . $filename;
            }
        }

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        // Update VillageDetail
        $villageDetail = VillageDetail::first();
        if (!$villageDetail) {
            $villageDetail = new VillageDetail();
        }
        $villageDetail->fill([
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'zip_code' => $request->zip_code,
            'dusun_count' => intval($request->dusun_count),
            'rt_count' => intval($request->rt_count),
            'rw_count' => intval($request->rw_count),
        ])->save();

        // Update DemographicStatistic: Total Penduduk
        $totalPenduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        if ($totalPenduduk) {
            $total = intval($request->population_count);
            $male = intval($total / 2);
            $female = $total - $male;
            $totalPenduduk->update([
                'male_count' => $male,
                'female_count' => $female
            ]);
        }

        // Update DemographicStatistic: Luas Wilayah
        $luasWilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();
        if ($luasWilayah) {
            $luasWilayah->update([
                'male_count' => intval($request->area_size)
            ]);
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Profil Desa berhasil diperbarui.');
    }

    public function editHomepage()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.homepage.edit', compact('profile'));
    }

    public function updateHomepage(Request $request)
    {
        $profile = VillageProfile::first();
        if (!$profile) {
            $profile = new VillageProfile();
        }

        $messages = [
            'hero_bg_image.max' => 'Ukuran gambar background utama (hero) maksimal 2MB (2048 KB).',
            'hero_bg_image.image' => 'File background utama harus berupa gambar.',
            'hero_bg_image.mimes' => 'Format gambar background utama harus jpeg, png, jpg, gif, svg, atau webp.',
            'about_image.max' => 'Ukuran gambar profil desa maksimal 2MB (2048 KB).',
            'about_image.image' => 'File profil desa harus berupa gambar.',
            'about_image.mimes' => 'Format gambar profil desa harus jpeg, png, jpg, atau webp.',
        ];

        $request->validate([
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'about_text' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'homepage_sections_order' => 'nullable|string',
            'about_subtitle' => 'nullable|string|max:255',
            'umkm_title' => 'nullable|string|max:255',
            'umkm_subtitle' => 'nullable|string|max:255',
            'tourism_title' => 'nullable|string|max:255',
            'tourism_subtitle' => 'nullable|string|max:255',
            'news_title' => 'nullable|string|max:255',
            'news_subtitle' => 'nullable|string|max:255',
            'gallery_title' => 'nullable|string|max:255',
            'gallery_subtitle' => 'nullable|string|max:255',
            'show_potency_on_home' => 'boolean',
            'show_umkm_on_home' => 'boolean',
            'show_news_on_home' => 'boolean',
            'show_gallery_on_home' => 'boolean',
        ], $messages);

        $data = $request->only([
            'about_text', 'homepage_sections_order', 'about_subtitle',
            'umkm_title', 'umkm_subtitle',
            'tourism_title', 'tourism_subtitle',
            'news_title', 'news_subtitle',
            'gallery_title', 'gallery_subtitle'
        ]);

        // Upload images
        $imageFields = ['hero_bg_image', 'about_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image
                if ($profile->$field && file_exists(public_path($profile->$field))) {
                    @unlink(public_path($profile->$field));
                }

                $file = $request->file($field);
                $filename = $field . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profile'), $filename);
                $data[$field] = 'uploads/profile/' . $filename;
            }
        }

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        return redirect()->route('admin.homepage.edit')->with('success', 'Pengaturan Beranda berhasil diperbarui.');
    }

    public function updateSetting(Request $request)
    {
        $profile = VillageProfile::first();
        if (!$profile) {
            $profile = new VillageProfile();
        }

        $key = $request->input('key');
        $value = $request->input('value') == '1' ? true : false;

        $allowedKeys = [
            'publish_headman_greeting',
            'publish_vision_mission',
            'publish_history',
            'publish_organization_structure',
            'publish_geographics',
            'publish_about',
            'publish_statistics',
            'publish_officials',
            'publish_regulations',
            'publish_news',
            'publish_tourism',
            'publish_umkm',
            'publish_agriculture',
            'publish_institutions',
            'publish_village_detail',
            'publish_profile',
            'publish_facilities',
            'show_potency_on_home',
            'show_umkm_on_home',
            'show_tourism_on_home',
            'show_news_on_home',
            'show_gallery_on_home',
        ];

        if (in_array($key, $allowedKeys)) {
            $profile->$key = $value;
            $profile->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Kunci tidak diperbolehkan.'], 400);
    }

    public function editIdentity()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.profile.edit-identity', compact('profile'));
    }

    public function updateIdentity(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();

        $request->validate([
            'village_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'office_hours' => 'nullable|string|max:255',
            'video_url' => 'nullable|string',
        ]);

        $data = $request->only(['village_name', 'office_hours', 'video_url']);

        if ($request->hasFile('logo')) {
            if ($profile->logo && file_exists(public_path($profile->logo))) {
                @unlink(public_path($profile->logo));
            }

            $file = $request->file('logo');
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['logo'] = 'uploads/profile/' . $filename;
        }

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        return redirect()->route('admin.profile.edit-identity')->with('success', 'Identitas Desa berhasil diperbarui.');
    }

    public function editLayout()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        $villageDetail = VillageDetail::first() ?? new VillageDetail();
        
        $demografi = new \stdClass();
        $demografi->total_penduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        $defaultOrder = [
            'detail_wilayah',
            'sambutan_kades',
            'visi_misi',
            'sejarah',
            'geografis_dusun',
            'sarana_prasarana'
        ];
        
        $sectionsOrder = $profile->profile_sections_order 
            ? explode(',', $profile->profile_sections_order) 
            : $defaultOrder;
            
        foreach ($defaultOrder as $sec) {
            if (!in_array($sec, $sectionsOrder)) {
                $sectionsOrder[] = $sec;
            }
        }

        $facilityCategories = \App\Models\FacilityCategory::with('facilities')->orderBy('order')->get();

        return view('admin.profile.edit-layout', compact('profile', 'villageDetail', 'demografi', 'sectionsOrder', 'facilityCategories'));
    }

    public function updateLayout(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();

        $request->validate([
            'headman_name' => 'nullable|string|max:255',
            'headman_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'headman_greeting' => 'nullable|string',
            'history' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'google_maps_url' => 'nullable|string',
            'history_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_headman_greeting' => 'nullable|boolean',
            'publish_vision_mission' => 'nullable|boolean',
            'publish_history' => 'nullable|boolean',
            'publish_geographics' => 'nullable|boolean',
            'publish_facilities' => 'nullable|boolean',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'area_size' => 'nullable|integer|min:0',
            'population_count' => 'nullable|integer|min:0',
            'dusun_count' => 'nullable|integer|min:0',
            'rw_count' => 'nullable|integer|min:0',
            'rt_count' => 'nullable|integer|min:0',
            'north_boundary' => 'nullable|string|max:255',
            'south_boundary' => 'nullable|string|max:255',
            'east_boundary' => 'nullable|string|max:255',
            'west_boundary' => 'nullable|string|max:255',
            'publish_village_detail' => 'nullable|boolean',
            'village_detail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'profile_sections_order' => 'nullable|string',
            'map_miri' => 'nullable|string',
            'map_dukuh' => 'nullable|string',
            'map_krajan' => 'nullable|string',
            'map_babadan' => 'nullable|string',
            'map_ngepringan' => 'nullable|string',
            'map_tanubayu' => 'nullable|string',
            'map_gading' => 'nullable|string',
            'map_karangwuni' => 'nullable|string',
        ]);

        $data = $request->except([
            'headman_photo', 'organization_structure_image', 'history_image', 'village_detail_image',
            'kecamatan', 'kabupaten', 'provinsi', 'zip_code', 'area_size', 'population_count', 'dusun_count', 'rw_count', 'rt_count',
            'north_boundary', 'south_boundary', 'east_boundary', 'west_boundary'
        ]);

        $profileToggleFields = [
            'publish_headman_greeting',
            'publish_vision_mission',
            'publish_history',
            'publish_organization_structure',
            'publish_geographics',
            'publish_village_detail',
            'publish_facilities',
        ];

        foreach ($profileToggleFields as $toggleField) {
            $data[$toggleField] = $request->has($toggleField) ? true : false;
        }

        // Upload images
        $imageFields = ['headman_photo', 'organization_structure_image', 'history_image', 'village_detail_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($profile->$field && file_exists(public_path($profile->$field))) {
                    @unlink(public_path($profile->$field));
                }

                $file = $request->file($field);
                $filename = $field . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profile'), $filename);
                $data[$field] = 'uploads/profile/' . $filename;
            }
        }

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        // Update VillageDetail
        $villageDetail = VillageDetail::first() ?? new VillageDetail();
        $villageDetail->fill([
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'zip_code' => $request->zip_code,
            'dusun_count' => intval($request->dusun_count),
            'rt_count' => intval($request->rt_count),
            'rw_count' => intval($request->rw_count),
            'north_boundary' => $request->north_boundary,
            'south_boundary' => $request->south_boundary,
            'east_boundary' => $request->east_boundary,
            'west_boundary' => $request->west_boundary,
        ])->save();

        // Update DemographicStatistic: Total Penduduk
        $totalPenduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        if ($totalPenduduk) {
            $total = intval($request->population_count);
            $male = intval($total / 2);
            $female = $total - $male;
            $totalPenduduk->update([
                'male_count' => $male,
                'female_count' => $female
            ]);
        }

        // Update DemographicStatistic: Luas Wilayah
        $luasWilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();
        if ($luasWilayah) {
            $luasWilayah->update([
                'male_count' => intval($request->area_size)
            ]);
        }

        return redirect()->route('admin.profile.edit-layout')->with('success', 'Tata Letak & Bagian Halaman Profil berhasil diperbarui.');
    }

    public function editContact()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.profile.edit-contact', compact('profile'));
    }

    public function updateContact(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();

        $request->validate([
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'office_maps_url' => 'nullable|string',
        ]);

        $data = $request->only(['phone', 'email', 'address', 'facebook', 'instagram', 'youtube', 'office_maps_url']);

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        return redirect()->route('admin.profile.edit-contact')->with('success', 'Kontak & Media Sosial Resmi berhasil diperbarui.');
    }

    public function editDescriptions()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.profile.edit-descriptions', compact('profile'));
    }

    public function updateDescriptions(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();

        $request->validate([
            'profile_page_description' => 'nullable|string|max:1000',
            'umkm_page_description' => 'nullable|string|max:1000',
            'tourism_page_description' => 'nullable|string|max:1000',
            'news_page_description' => 'nullable|string|max:1000',
            'officials_page_description' => 'nullable|string|max:1000',
            'regulations_page_description' => 'nullable|string|max:1000',
            'institutions_page_description' => 'nullable|string|max:1000',
            'agriculture_page_description' => 'nullable|string|max:1000',
        ]);

        $data = $request->only([
            'profile_page_description',
            'umkm_page_description',
            'tourism_page_description',
            'news_page_description',
            'officials_page_description',
            'regulations_page_description',
            'institutions_page_description',
            'agriculture_page_description',
        ]);

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        return redirect()->route('admin.profile.edit-descriptions')->with('success', 'Teks & Deskripsi Halaman berhasil diperbarui.');
    }
}
