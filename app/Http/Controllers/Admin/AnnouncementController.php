<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg|max:5120',
            'is_active' => 'required|boolean',
            'is_alert' => 'required|boolean',
            'expired_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'content', 'is_active', 'is_alert', 'expired_at']);
        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/announcements'), $filename);
            $data['document_file'] = 'uploads/announcements/' . $filename;
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg|max:5120',
            'is_active' => 'required|boolean',
            'is_alert' => 'required|boolean',
            'expired_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'content', 'is_active', 'is_alert', 'expired_at']);
        
        // Regenerate slug if title changes
        if ($announcement->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('document_file')) {
            // Delete old file if exists
            if ($announcement->document_file && File::exists(public_path($announcement->document_file))) {
                File::delete(public_path($announcement->document_file));
            }

            $file = $request->file('document_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/announcements'), $filename);
            $data['document_file'] = 'uploads/announcements/' . $filename;
        }

        // Handle file deletion request
        if ($request->boolean('delete_document') && !$request->hasFile('document_file')) {
            if ($announcement->document_file && File::exists(public_path($announcement->document_file))) {
                File::delete(public_path($announcement->document_file));
            }
            $data['document_file'] = null;
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->document_file && File::exists(public_path($announcement->document_file))) {
            File::delete(public_path($announcement->document_file));
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
