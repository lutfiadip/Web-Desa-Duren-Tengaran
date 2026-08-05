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
        $villageDetail = VillageDetail::first() ?? new VillageDetail();
        
        $demografi = new \stdClass();
        $demografi->total_penduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        $defaultOrder = [
            'detail_wilayah',
            'sambutan_kades',
            'visi_misi',
            'sejarah',
            'struktur_organisasi',
            'geografis_dusun'
        ];
        
        $sectionsOrder = $profile->profile_sections_order 
            ? explode(',', $profile->profile_sections_order) 
            : $defaultOrder;
            
        foreach ($defaultOrder as $sec) {
            if (!in_array($sec, $sectionsOrder)) {
                $sectionsOrder[] = $sec;
            }
        }

        return view('admin.profile.edit', compact('profile', 'villageDetail', 'demografi', 'sectionsOrder'));
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

        $request->validate([
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'about_text' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_about' => 'nullable|boolean',
        ]);

        $data = $request->except(['hero_bg_image', 'about_image']);

        $data['publish_about'] = $request->has('publish_about') ? true : false;

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
        ];

        if (in_array($key, $allowedKeys)) {
            $profile->$key = $value;
            $profile->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Kunci tidak diperbolehkan.'], 400);
    }
}
