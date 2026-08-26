<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegulationCategory;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class RegulationCategoryController extends Controller
{
    public function index()
    {
        $categories = RegulationCategory::orderBy('id', 'asc')->get();
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.regulations.categories.index', compact('categories', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regulation_categories,name',
        ]);

        RegulationCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.regulations.categories.index')->with('success', 'Kategori peraturan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = RegulationCategory::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.regulations.categories.edit', compact('category', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $category = RegulationCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:regulation_categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.regulations.categories.index')->with('success', 'Kategori peraturan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = RegulationCategory::findOrFail($id);

        // Prevent deletion if category still has regulations associated
        if ($category->regulations()->count() > 0) {
            return redirect()->route('admin.regulations.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data peraturan di dalamnya.');
        }

        $category->delete();

        return redirect()->route('admin.regulations.categories.index')->with('success', 'Kategori peraturan berhasil dihapus.');
    }
}
