<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\OfficialCategory;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    public function index(Request $request)
    {
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
        $parentOfficials = Official::orderBy('name')->get();
        return view('admin.officials.create', compact('categories', 'parentOfficials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:official_categories,id',
            'parent_id' => 'nullable|exists:officials,id',
            'nip' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'category_id', 'parent_id', 'nip', 'sort_order', 'status']);

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
        $parentOfficials = Official::where('id', '!=', $official->id)->orderBy('name')->get();
        return view('admin.officials.edit', compact('official', 'categories', 'parentOfficials'));
    }

    public function update(Request $request, Official $official)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:official_categories,id',
            'parent_id' => 'nullable|exists:officials,id|different:id',
            'nip' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'category_id', 'parent_id', 'nip', 'sort_order', 'status']);

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
