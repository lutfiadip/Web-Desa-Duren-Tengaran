<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CultureController extends Controller
{
    public function index(Request $request)
    {
        $query = Culture::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $cultures = $query->latest()->paginate(10);
        return view('admin.culture.index', compact('cultures'));
    }

    public function create()
    {
        return view('admin.culture.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'location' => 'required|string|max:255',
            'implementation_time' => 'required|string|max:255',
            'contact' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'description', 'location', 'implementation_time',
            'contact', 'status', 'is_featured'
        ]);

        $data['user_id'] = Auth::id() ?? 1;
        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/culture'), $filename);
            $data['thumbnail'] = 'uploads/culture/' . $filename;
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/culture'), $filename);
                $gallery[] = 'uploads/culture/' . $filename;
            }
        }
        $data['gallery'] = $gallery;

        Culture::create($data);

        return redirect()->route('admin.culture.index')->with('success', 'Kebudayaan berhasil ditambahkan.');
    }

    public function edit(Culture $culture)
    {
        return view('admin.culture.edit', compact('culture'));
    }

    public function update(Request $request, Culture $culture)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'location' => 'required|string|max:255',
            'implementation_time' => 'required|string|max:255',
            'contact' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'description', 'location', 'implementation_time',
            'contact', 'status', 'is_featured'
        ]);

        if ($culture->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('thumbnail')) {
            if ($culture->thumbnail && file_exists(public_path($culture->thumbnail))) {
                @unlink(public_path($culture->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/culture'), $filename);
            $data['thumbnail'] = 'uploads/culture/' . $filename;
        }

        $gallery = $culture->gallery ?? [];
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
                $file->move(public_path('uploads/culture'), $filename);
                $gallery[] = 'uploads/culture/' . $filename;
            }
        }
        $data['gallery'] = $gallery;

        $culture->update($data);

        return redirect()->route('admin.culture.index')->with('success', 'Kebudayaan berhasil diperbarui.');
    }

    public function destroy(Culture $culture)
    {
        if ($culture->thumbnail && file_exists(public_path($culture->thumbnail))) {
            @unlink(public_path($culture->thumbnail));
        }

        if (is_array($culture->gallery)) {
            foreach ($culture->gallery as $gPath) {
                if (file_exists(public_path($gPath))) {
                    @unlink(public_path($gPath));
                }
            }
        }

        $culture->delete();

        return redirect()->route('admin.culture.index')->with('success', 'Kebudayaan berhasil dihapus.');
    }
}
