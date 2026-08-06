<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('galleryable_type', VillageProfile::class)
            ->latest()
            ->paginate(12);

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $profile = VillageProfile::first();
        $profileId = $profile ? $profile->id : 1;

        $data = [
            'galleryable_type' => VillageProfile::class,
            'galleryable_id' => $profileId,
            'caption' => $request->caption,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $data['image'] = 'uploads/gallery/' . $filename;
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $data = [
            'caption' => $request->caption,
        ];

        if ($request->hasFile('image')) {
            // Delete old file
            if ($gallery->image && !str_starts_with($gallery->image, 'http') && file_exists(public_path($gallery->image))) {
                @unlink(public_path($gallery->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $data['image'] = 'uploads/gallery/' . $filename;
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && !str_starts_with($gallery->image, 'http') && file_exists(public_path($gallery->image))) {
            @unlink(public_path($gallery->image));
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
