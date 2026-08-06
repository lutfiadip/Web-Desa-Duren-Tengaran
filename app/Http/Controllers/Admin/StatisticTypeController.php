<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopulationStatisticType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatisticTypeController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.statistics.index');
    }

    public function create()
    {
        return view('admin.statistics.types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $slugSource = $request->filled('slug') ? $request->slug : $request->name;
        $slug = Str::slug($slugSource);

        // Ensure unique slug
        $originalSlug = $slug;
        $count = 1;
        while (PopulationStatisticType::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Get max display order
        $maxOrder = PopulationStatisticType::max('display_order') ?? 0;

        PopulationStatisticType::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'display_order' => $maxOrder + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.statistics.index')->with('success', 'Jenis statistik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $type = PopulationStatisticType::findOrFail($id);
        return view('admin.statistics.types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = PopulationStatisticType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $slugSource = $request->filled('slug') ? $request->slug : $request->name;
        $slug = Str::slug($slugSource);

        // Ensure unique slug
        $originalSlug = $slug;
        $count = 1;
        while (PopulationStatisticType::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $type->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.statistics.index')->with('success', 'Jenis statistik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $type = PopulationStatisticType::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.statistics.index')->with('success', 'Jenis statistik berhasil dihapus.');
    }
}
