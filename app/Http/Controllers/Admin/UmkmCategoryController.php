<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmCategory;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class UmkmCategoryController extends Controller
{
    public function index()
    {
        $categories = UmkmCategory::orderBy('name')->get();
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.umkm.categories.index', compact('categories', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:umkm_categories,name',
        ]);

        UmkmCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.umkm.categories.index')->with('success', 'Kategori UMKM berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = UmkmCategory::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.umkm.categories.edit', compact('category', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $category = UmkmCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:umkm_categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.umkm.categories.index')->with('success', 'Kategori UMKM berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = UmkmCategory::findOrFail($id);

        // Prevent deletion if category still has UMKM products associated
        if ($category->umkms()->count() > 0) {
            return redirect()->route('admin.umkm.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk UMKM di dalamnya.');
        }

        $category->delete();

        return redirect()->route('admin.umkm.categories.index')->with('success', 'Kategori UMKM berhasil dihapus.');
    }
}
