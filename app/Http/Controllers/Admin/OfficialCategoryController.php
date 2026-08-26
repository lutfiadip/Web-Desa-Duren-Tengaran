<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficialCategory;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class OfficialCategoryController extends Controller
{
    public function index()
    {
        $categories = OfficialCategory::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.officials.categories.index', compact('categories', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:official_categories,name',
        ]);

        $maxOrder = OfficialCategory::max('sort_order') ?? 0;

        OfficialCategory::create([
            'name' => $request->name,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.officials.categories.index')->with('success', 'Kategori perangkat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = OfficialCategory::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.officials.categories.edit', compact('category', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $category = OfficialCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:official_categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.officials.categories.index')->with('success', 'Kategori perangkat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = OfficialCategory::findOrFail($id);

        // Prevent deletion if category still has officials associated
        if ($category->officials()->count() > 0) {
            return redirect()->route('admin.officials.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data perangkat di dalamnya.');
        }

        $category->delete();

        return redirect()->route('admin.officials.categories.index')->with('success', 'Kategori perangkat berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        if (is_array($order)) {
            foreach ($order as $index => $id) {
                OfficialCategory::where('id', $id)->update(['sort_order' => $index + 1]);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 400);
    }
}
