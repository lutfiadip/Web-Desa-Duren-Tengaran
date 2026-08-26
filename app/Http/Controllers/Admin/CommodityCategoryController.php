<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommodityCategory;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommodityCategoryController extends Controller
{
    public function index()
    {
        $categories = CommodityCategory::orderBy('id', 'asc')->get();
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.categories.index', compact('categories', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:commodity_categories,name',
        ]);

        CommodityCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.agriculture.categories.index')->with('success', 'Kategori komoditas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = CommodityCategory::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.categories.edit', compact('category', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $category = CommodityCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:commodity_categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.agriculture.categories.index')->with('success', 'Kategori komoditas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = CommodityCategory::findOrFail($id);

        // Prevent deletion if category still has commodities associated
        if ($category->commodities()->count() > 0) {
            return redirect()->route('admin.agriculture.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data komoditas di dalamnya.');
        }

        $category->delete();

        return redirect()->route('admin.agriculture.categories.index')->with('success', 'Kategori komoditas berhasil dihapus.');
    }
}
