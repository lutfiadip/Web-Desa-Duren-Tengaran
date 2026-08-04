<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristAttraction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TourismController extends Controller
{
    public function index(Request $request)
    {
        $query = TouristAttraction::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tourisms = $query->latest()->paginate(10);
        return view('admin.tourism.index', compact('tourisms'));
    }

    public function create()
    {
        return view('admin.tourism.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'address' => 'required|string',
            'google_maps_url' => 'nullable|url',
            'operating_hours' => 'nullable|string|max:255',
            'ticket_price' => 'required|integer|min:0',
            'contact' => 'nullable|string|max:100',
            'facilities' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'description', 'address', 'google_maps_url', 'operating_hours',
            'ticket_price', 'contact', 'facilities', 'status', 'is_featured'
        ]);

        $data['user_id'] = Auth::id() ?? 1;
        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tourism'), $filename);
            $data['thumbnail'] = 'uploads/tourism/' . $filename;
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/tourism'), $filename);
                $gallery[] = 'uploads/tourism/' . $filename;
            }
        }
        $data['gallery'] = $gallery;

        TouristAttraction::create($data);

        return redirect()->route('admin.tourism.index')->with('success', 'Wisata berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tourism = TouristAttraction::findOrFail($id);
        return view('admin.tourism.edit', compact('tourism'));
    }

    public function update(Request $request, $id)
    {
        $tourism = TouristAttraction::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'address' => 'required|string',
            'google_maps_url' => 'nullable|url',
            'operating_hours' => 'nullable|string|max:255',
            'ticket_price' => 'required|integer|min:0',
            'contact' => 'nullable|string|max:100',
            'facilities' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'description', 'address', 'google_maps_url', 'operating_hours',
            'ticket_price', 'contact', 'facilities', 'status', 'is_featured'
        ]);

        if ($tourism->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('thumbnail')) {
            if ($tourism->thumbnail && file_exists(public_path($tourism->thumbnail))) {
                @unlink(public_path($tourism->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tourism'), $filename);
            $data['thumbnail'] = 'uploads/tourism/' . $filename;
        }

        $gallery = $tourism->gallery ?? [];
        if ($request->hasFile('gallery_files')) {
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
                $file->move(public_path('uploads/tourism'), $filename);
                $gallery[] = 'uploads/tourism/' . $filename;
            }
        }
        $data['gallery'] = $gallery;

        $tourism->update($data);

        return redirect()->route('admin.tourism.index')->with('success', 'Wisata berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tourism = TouristAttraction::findOrFail($id);

        if ($tourism->thumbnail && file_exists(public_path($tourism->thumbnail))) {
            @unlink(public_path($tourism->thumbnail));
        }

        if (is_array($tourism->gallery)) {
            foreach ($tourism->gallery as $gPath) {
                if (file_exists(public_path($gPath))) {
                    @unlink(public_path($gPath));
                }
            }
        }

        $tourism->delete();

        return redirect()->route('admin.tourism.index')->with('success', 'Wisata berhasil dihapus.');
    }
}
