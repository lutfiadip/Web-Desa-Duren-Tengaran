<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::orderBy('id', 'asc')->get();
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.news.categories.index', compact('categories', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name',
        ]);

        NewsCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.news.categories.index')->with('success', 'Kategori Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = NewsCategory::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.news.categories.edit', compact('category', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $category = NewsCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.news.categories.index')->with('success', 'Kategori Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = NewsCategory::findOrFail($id);

        // Prevent deletion if category still has news associated
        if ($category->news()->count() > 0) {
            return redirect()->route('admin.news.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki Berita di dalamnya.');
        }

        $category->delete();

        return redirect()->route('admin.news.categories.index')->with('success', 'Kategori Berita berhasil dihapus.');
    }
}
