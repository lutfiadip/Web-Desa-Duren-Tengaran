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
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'document_titles.*' => 'nullable|string|max:255',
            'document_files.*' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->except(['document_titles', 'document_files']);
        $data['slug'] = Str::slug($request->title);
        
        // Ensure unique slug
        if (PublicService::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        $public_service = PublicService::create($data);

        // Handle multiple documents upload
        if ($request->has('document_titles') && $request->hasFile('document_files')) {
            $titles = $request->input('document_titles');
            $files = $request->file('document_files');

            foreach ($files as $index => $file) {
                if ($file && isset($titles[$index])) {
                    $filename = time() . '_' . uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/documents'), $filename);
                    
                    $public_service->documents()->create([
                        'title' => $titles[$index] ?: 'Formulir Layanan',
                        'file_path' => 'uploads/documents/' . $filename,
                    ]);
                }
            }
        }

        return redirect()->route('admin.public-services.index')->with('success', 'Layanan publik berhasil ditambahkan.');
    }

    public function edit(PublicService $public_service)
    {
        // Eager load documents relation
        $public_service->load('documents');
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
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'document_titles.*' => 'nullable|string|max:255',
            'document_files.*' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->except(['document_titles', 'document_files', 'delete_documents', 'existing_document_titles']);
        $data['slug'] = Str::slug($request->title);
        
        if (PublicService::where('slug', $data['slug'])->where('id', '!=', $public_service->id)->exists()) {
            $data['slug'] = $data['slug'] . '-' . time();
        }
        
        $data['is_active'] = $request->has('is_active');

        $public_service->update($data);

        // 1. Handle deletion of existing documents
        if ($request->has('delete_documents')) {
            $deleteIds = $request->input('delete_documents');
            $documentsToDelete = $public_service->documents()->whereIn('id', $deleteIds)->get();
            foreach ($documentsToDelete as $doc) {
                if ($doc->file_path && file_exists(public_path($doc->file_path))) {
                    @unlink(public_path($doc->file_path));
                }
                $doc->delete();
            }
        }

        // 2. Handle editing of existing document titles
        if ($request->has('existing_document_titles')) {
            foreach ($request->input('existing_document_titles') as $docId => $title) {
                $public_service->documents()->where('id', $docId)->update([
                    'title' => $title ?: 'Formulir Layanan',
                ]);
            }
        }

        // 3. Handle adding new documents
        if ($request->has('document_titles') && $request->hasFile('document_files')) {
            $titles = $request->input('document_titles');
            $files = $request->file('document_files');

            foreach ($files as $index => $file) {
                if ($file && isset($titles[$index])) {
                    $filename = time() . '_' . uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/documents'), $filename);
                    
                    $public_service->documents()->create([
                        'title' => $titles[$index] ?: 'Formulir Layanan',
                        'file_path' => 'uploads/documents/' . $filename,
                    ]);
                }
            }
        }

        return redirect()->route('admin.public-services.index')->with('success', 'Layanan publik berhasil diperbarui.');
    }

    public function destroy(PublicService $public_service)
    {
        // Delete all related files from storage/uploads
        foreach ($public_service->documents as $doc) {
            if ($doc->file_path && file_exists(public_path($doc->file_path))) {
                @unlink(public_path($doc->file_path));
            }
        }

        $public_service->delete();

        return redirect()->route('admin.public-services.index')->with('success', 'Layanan publik berhasil dihapus.');
    }
}
