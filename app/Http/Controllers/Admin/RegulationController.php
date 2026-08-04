<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulation;
use App\Models\RegulationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegulationController extends Controller
{
    public function index(Request $request)
    {
        $query = Regulation::with('category');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('number', 'like', '%' . $request->search . '%');
        }

        $regulations = $query->latest()->paginate(10);
        return view('admin.regulations.index', compact('regulations'));
    }

    public function create()
    {
        $categories = RegulationCategory::all();
        return view('admin.regulations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:regulation_categories,id',
            'number' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,zip|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only(['title', 'category_id', 'number', 'year', 'description', 'status']);
        $data['user_id'] = Auth::id() ?? 1;
        $data['published_at'] = $request->status === 'published' ? now() : null;

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/regulations'), $filename);
            $data['document_file'] = 'uploads/regulations/' . $filename;
        }

        Regulation::create($data);

        return redirect()->route('admin.regulations.index')->with('success', 'Peraturan berhasil ditambahkan.');
    }

    public function edit(Regulation $regulation)
    {
        $categories = RegulationCategory::all();
        return view('admin.regulations.edit', compact('regulation', 'categories'));
    }

    public function update(Request $request, Regulation $regulation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:regulation_categories,id',
            'number' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only(['title', 'category_id', 'number', 'year', 'description', 'status']);
        
        if ($request->status === 'published' && !$regulation->published_at) {
            $data['published_at'] = now();
        } elseif ($request->status === 'draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('document_file')) {
            if ($regulation->document_file && file_exists(public_path($regulation->document_file))) {
                @unlink(public_path($regulation->document_file));
            }

            $file = $request->file('document_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/regulations'), $filename);
            $data['document_file'] = 'uploads/regulations/' . $filename;
        }

        $regulation->update($data);

        return redirect()->route('admin.regulations.index')->with('success', 'Peraturan berhasil diperbarui.');
    }

    public function destroy(Regulation $regulation)
    {
        if ($regulation->document_file && file_exists(public_path($regulation->document_file))) {
            @unlink(public_path($regulation->document_file));
        }

        $regulation->delete();

        return redirect()->route('admin.regulations.index')->with('success', 'Peraturan berhasil dihapus.');
    }
}
