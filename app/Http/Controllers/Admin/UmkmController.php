<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\UmkmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::with('category');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->search . '%');
        }

        $umkms = $query->latest()->paginate(10);
        return view('admin.umkm.index', compact('umkms'));
    }

    public function create()
    {
        $categories = UmkmCategory::orderBy('id', 'asc')->get();
        return view('admin.umkm.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:umkm_categories,id',
            'owner_name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'address' => 'required|string',
            'whatsapp' => 'nullable|string|max:50',
            'instagram' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'operating_hours' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'category_id', 'owner_name', 'description', 'address',
            'whatsapp', 'instagram', 'facebook', 'operating_hours', 'google_maps_url',
            'status', 'is_featured'
        ]);

        $data['user_id'] = Auth::id() ?? 1;
        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/umkm'), $filename);
            $data['thumbnail'] = 'uploads/umkm/' . $filename;
        }

        // Upload gallery
        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/umkm'), $filename);
                $gallery[] = 'uploads/umkm/' . $filename;
            }
        }
        $data['gallery'] = $gallery;

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm)
    {
        $categories = UmkmCategory::orderBy('id', 'asc')->get();
        return view('admin.umkm.edit', compact('umkm', 'categories'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:umkm_categories,id',
            'owner_name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'address' => 'required|string',
            'whatsapp' => 'nullable|string|max:50',
            'instagram' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'operating_hours' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'category_id', 'owner_name', 'description', 'address',
            'whatsapp', 'instagram', 'facebook', 'operating_hours', 'google_maps_url',
            'status', 'is_featured'
        ]);

        if ($umkm->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        }

        // Update thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($umkm->thumbnail && file_exists(public_path($umkm->thumbnail))) {
                @unlink(public_path($umkm->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/umkm'), $filename);
            $data['thumbnail'] = 'uploads/umkm/' . $filename;
        }

        // Update gallery
        $gallery = $umkm->gallery ?? [];
        
        // If user wants to clear gallery or replace it, we handle new files
        if ($request->hasFile('gallery_files')) {
            // Delete old gallery files from disk if user uploads new ones
            if ($request->boolean('replace_gallery') && is_array($gallery)) {
                foreach ($gallery as $gPath) {
                    if (file_exists(public_path($gPath))) {
                        @unlink(public_path($gPath));
                    }
                }
                $gallery = [];
            }

            foreach ($request->file('gallery_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/umkm'), $filename);
                $gallery[] = 'uploads/umkm/' . $filename;
            }
        }
        
        $data['gallery'] = $gallery;

        $umkm->update($data);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm)
    {
        if ($umkm->thumbnail && file_exists(public_path($umkm->thumbnail))) {
            @unlink(public_path($umkm->thumbnail));
        }

        if (is_array($umkm->gallery)) {
            foreach ($umkm->gallery as $gPath) {
                if (file_exists(public_path($gPath))) {
                    @unlink(public_path($gPath));
                }
            }
        }

        $umkm->delete();

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dihapus.');
    }
}
