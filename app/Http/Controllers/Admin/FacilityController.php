<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityCategory;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $categories = FacilityCategory::orderBy('order')->get();
        return view('admin.facilities.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $maxOrder = FacilityCategory::max('order') ?? 0;

        FacilityCategory::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Kategori sarana berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, FacilityCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        return redirect()->back()->with('success', 'Kategori sarana berhasil diperbarui.');
    }

    public function destroyCategory(FacilityCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori sarana berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:facility_categories,id',
            'name' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'details' => 'nullable|array',
            'details.*' => 'nullable|string|max:255',
        ]);

        $maxOrder = Facility::where('category_id', $request->category_id)->max('order') ?? 0;

        $details = $request->input('details', []);
        $details = array_filter($details, function($val) {
            return $val !== null && trim($val) !== '';
        });

        Facility::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'description' => !empty($details) ? json_encode(array_values($details)) : null,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Data sarana berhasil ditambahkan.');
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'details' => 'nullable|array',
            'details.*' => 'nullable|string|max:255',
        ]);

        $details = $request->input('details', []);
        $details = array_filter($details, function($val) {
            return $val !== null && trim($val) !== '';
        });

        $facility->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'description' => !empty($details) ? json_encode(array_values($details)) : null,
        ]);

        return redirect()->back()->with('success', 'Data sarana berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->back()->with('success', 'Data sarana berhasil dihapus.');
    }
}
