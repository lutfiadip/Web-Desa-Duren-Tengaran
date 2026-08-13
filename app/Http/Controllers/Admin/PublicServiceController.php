<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublicServiceController extends Controller
{
    public function index()
    {
        $services = PublicService::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.public_services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.public_services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'service_flow' => 'nullable|string',
            'disclaimer' => 'nullable|string',
            'processing_time' => 'nullable|string|max:255',
            'service_cost' => 'nullable|string|max:255',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('document_file');
        $data['slug'] = Str::slug($request->title);
        
        // Ensure unique slug
        if (PublicService::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents'), $filename);
            $data['document_file'] = 'uploads/documents/' . $filename;
        }

        PublicService::create($data);

        return redirect()->route('admin.public-services.index')->with('success', 'Layanan publik berhasil ditambahkan.');
    }

    public function edit(PublicService $public_service)
    {
        return view('admin.public_services.edit', compact('public_service'));
    }

    public function update(Request $request, PublicService $public_service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'service_flow' => 'nullable|string',
            'disclaimer' => 'nullable|string',
            'processing_time' => 'nullable|string|max:255',
            'service_cost' => 'nullable|string|max:255',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('document_file');
        $data['slug'] = Str::slug($request->title);
        
        if (PublicService::where('slug', $data['slug'])->where('id', '!=', $public_service->id)->exists()) {
            $data['slug'] = $data['slug'] . '-' . time();
        }
        
        // Handling checkbox which might not be in request if unchecked
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('document_file')) {
            // Delete old file
            if ($public_service->document_file && file_exists(public_path($public_service->document_file))) {
                unlink(public_path($public_service->document_file));
            }
            $file = $request->file('document_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents'), $filename);
            $data['document_file'] = 'uploads/documents/' . $filename;
        }

        $public_service->update($data);

        return redirect()->route('admin.public-services.index')->with('success', 'Layanan publik berhasil diperbarui.');
    }

    public function destroy(PublicService $public_service)
    {
        if ($public_service->document_file && file_exists(public_path($public_service->document_file))) {
            unlink(public_path($public_service->document_file));
        }
        $public_service->delete();

        return redirect()->route('admin.public-services.index')->with('success', 'Layanan publik berhasil dihapus.');
    }
}
