<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\OfficialCategory;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    public function updateStructure(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();

        $request->validate([
            'organization_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_organization_structure' => 'nullable|boolean',
        ]);

        $data = [];
        $data['publish_organization_structure'] = $request->has('publish_organization_structure');

        if ($request->hasFile('organization_structure_image')) {
            if ($profile->organization_structure_image && file_exists(public_path($profile->organization_structure_image))) {
                @unlink(public_path($profile->organization_structure_image));
            }

            $file = $request->file('organization_structure_image');
            $filename = 'org_struct_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['organization_structure_image'] = 'uploads/profile/' . $filename;
        }

        if ($profile->exists) {
            $profile->update($data);
        } else {
            $profile->fill($data)->save();
        }

        return redirect()->route('admin.officials.index')->with('success', 'Struktur Organisasi berhasil diperbarui.');
    }

    public function index(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        $query = Official::with(['category', 'parent']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('position', 'like', '%' . $request->search . '%');
        }

        $officials = $query->orderBy('sort_order')->paginate(10);
        return view('admin.officials.index', compact('officials'));
    }

    public function create()
    {
        $categories = OfficialCategory::orderBy('sort_order')->get();
        return view('admin.officials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:official_categories,id',
            'nip' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'category_id', 'nip', 'sort_order', 'status']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/officials'), $filename);
            $data['photo'] = 'uploads/officials/' . $filename;
        }

        Official::create($data);

        return redirect()->route('admin.officials.index')->with('success', 'Perangkat Desa berhasil ditambahkan.');
    }

    public function edit(Official $official)
    {
        $categories = OfficialCategory::orderBy('sort_order')->get();
        return view('admin.officials.edit', compact('official', 'categories'));
    }

    public function update(Request $request, Official $official)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:official_categories,id',
            'nip' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'category_id', 'nip', 'sort_order', 'status']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('photo')) {
            if ($official->photo && file_exists(public_path($official->photo))) {
                @unlink(public_path($official->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/officials'), $filename);
            $data['photo'] = 'uploads/officials/' . $filename;
        }

        $official->update($data);

        return redirect()->route('admin.officials.index')->with('success', 'Perangkat Desa berhasil diperbarui.');
    }

    public function destroy(Official $official)
    {
        if ($official->photo && file_exists(public_path($official->photo))) {
            @unlink(public_path($official->photo));
        }

        $official->delete();

        return redirect()->route('admin.officials.index')->with('success', 'Perangkat Desa berhasil dihapus.');
    }
}
