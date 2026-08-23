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
            'is_featured' => 'required|boolean',
        ]);

        $profile = VillageProfile::first();
        $profileId = $profile ? $profile->id : 1;

        $data = [
            'galleryable_type' => VillageProfile::class,
            'galleryable_id' => $profileId,
            'caption' => $request->caption,
            'is_featured' => $request->is_featured,
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
            'is_featured' => 'required|boolean',
        ]);

        $data = [
            'caption' => $request->caption,
            'is_featured' => $request->is_featured,
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

    public function deletePhoto(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'id' => 'required|integer',
            'photo' => 'required|string',
        ]);

        $modelName = $request->input('model');
        $id = $request->input('id');
        $photo = $request->input('photo');

        // Resolve model class
        $modelClass = match($modelName) {
            'tourism' => \App\Models\TouristAttraction::class,
            'umkm' => \App\Models\Umkm::class,
            'culture' => \App\Models\Culture::class,
            'commodity' => \App\Models\AgricultureCommodity::class,
            default => null
        };

        if (!$modelClass) {
            return response()->json(['success' => false, 'message' => 'Tipe modul tidak valid.'], 400);
        }

        $model = $modelClass::find($id);
        if (!$model) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
        }

        // Handle gallery structure
        $gallery = $model->gallery;
        if (is_string($gallery)) {
            $gallery = json_decode($gallery, true) ?? [];
        }

        if (!is_array($gallery)) {
            $gallery = [];
        }

        // Search and remove the photo
        $index = array_search($photo, $gallery);
        if ($index !== false) {
            unset($gallery[$index]);
            $gallery = array_values($gallery); // re-index

            // Delete physical file
            if (!str_starts_with($photo, 'http') && file_exists(public_path($photo))) {
                @unlink(public_path($photo));
            }

            // Save back
            if ($modelName === 'commodity') {
                $model->gallery = json_encode($gallery);
            } else {
                $model->gallery = $gallery;
            }
            $model->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Foto tidak ditemukan dalam galeri.'], 404);
    }
}
