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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
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
            'organization_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'about_text' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['logo', 'headman_photo', 'organization_structure_image', 'hero_bg_image', 'about_image']);

        // Upload images
        $imageFields = ['logo', 'headman_photo', 'organization_structure_image', 'hero_bg_image', 'about_image'];
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
}
