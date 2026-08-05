<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
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
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'about_text' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'history_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_headman_greeting' => 'nullable|boolean',
            'publish_vision_mission' => 'nullable|boolean',
            'publish_history' => 'nullable|boolean',
            'publish_organization_structure' => 'nullable|boolean',
            'publish_geographics' => 'nullable|boolean',
            'publish_about' => 'nullable|boolean',
            'publish_statistics' => 'nullable|boolean',
            'publish_officials' => 'nullable|boolean',
            'publish_regulations' => 'nullable|boolean',
            'publish_news' => 'nullable|boolean',
            'publish_tourism' => 'nullable|boolean',
            'publish_umkm' => 'nullable|boolean',
            'publish_agriculture' => 'nullable|boolean',
            'publish_institutions' => 'nullable|boolean',
        ]);

        $data = $request->except(['logo', 'headman_photo', 'organization_structure_image', 'hero_bg_image', 'about_image', 'history_image']);

        $profileToggleFields = [
            'publish_headman_greeting',
            'publish_vision_mission',
            'publish_history',
            'publish_organization_structure',
            'publish_geographics',
            'publish_about',
            'publish_agriculture',
            'publish_institutions',
        ];

        foreach ($profileToggleFields as $toggleField) {
            $data[$toggleField] = $request->has($toggleField) ? true : false;
        }

        // Upload images
        $imageFields = ['logo', 'headman_photo', 'organization_structure_image', 'hero_bg_image', 'about_image', 'history_image'];
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

        return redirect()->route('admin.profile.edit')->with('success', 'Profil Desa berhasil diperbarui.');
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
        ];

        if (in_array($key, $allowedKeys)) {
            $profile->$key = $value;
            $profile->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Kunci tidak diperbolehkan.'], 400);
    }
}
