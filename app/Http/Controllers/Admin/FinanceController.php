<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinanceReport;
use App\Models\FinanceDocument;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinanceController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        $reports = FinanceReport::orderBy('year', 'desc')->paginate(10);
        return view('admin.finance.index', compact('reports', 'profile'));
    }

    public function create()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.finance.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|unique:finance_reports,year',
            'revenue_target' => 'required|numeric|min:0',
            'revenue_realization' => 'required|numeric|min:0',
            'revenue_pad' => 'nullable|numeric|min:0',
            'revenue_add' => 'nullable|numeric|min:0',
            'revenue_dd' => 'nullable|numeric|min:0',
            'revenue_pbh' => 'nullable|numeric|min:0',
            'spending_target' => 'required|numeric|min:0',
            'spending_realization' => 'required|numeric|min:0',
            'spending_pemerintahan' => 'nullable|numeric|min:0',
            'spending_pembangunan' => 'nullable|numeric|min:0',
            'spending_pembinaan' => 'nullable|numeric|min:0',
            'spending_pemberdayaan' => 'nullable|numeric|min:0',
            'spending_penanggulangan' => 'nullable|numeric|min:0',
            'financing_target' => 'required|numeric|min:0',
            'financing_realization' => 'required|numeric|min:0',
            'apbdes_poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'document_titles.*' => 'nullable|string|max:255',
            'document_files.*' => 'nullable|file|mimes:pdf|max:10240',
            'document_categories.*' => 'required|string|in:budget,development,asset,report',
        ]);

        $data = $request->except(['document_titles', 'document_files', 'document_categories']);
        $data['is_active'] = $request->has('is_active');

        // Handle APBDes Poster Upload
        if ($request->hasFile('apbdes_poster')) {
            $file = $request->file('apbdes_poster');
            $filename = time() . '_' . uniqid() . '_apbdes_poster.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/finance'), $filename);
            $data['apbdes_poster'] = 'uploads/finance/' . $filename;
        }

        $report = FinanceReport::create($data);

        // Handle Multiple Documents Upload
        if ($request->has('document_titles') && $request->hasFile('document_files')) {
            $titles = $request->input('document_titles');
            $files = $request->file('document_files');
            $categories = $request->input('document_categories');

            foreach ($files as $index => $file) {
                if ($file && isset($titles[$index]) && isset($categories[$index])) {
                    $filename = time() . '_' . uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/finance'), $filename);

                    $report->documents()->create([
                        'title' => $titles[$index] ?: 'Dokumen Transparansi',
                        'file_path' => 'uploads/finance/' . $filename,
                        'category' => $categories[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.transparency.index')->with('success', 'Tahun anggaran transparansi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $report = FinanceReport::findOrFail($id);
        $report->load('documents');
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.finance.edit', compact('report', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $report = FinanceReport::findOrFail($id);

        $request->validate([
            'year' => 'required|integer|unique:finance_reports,year,' . $id,
            'revenue_target' => 'required|numeric|min:0',
            'revenue_realization' => 'required|numeric|min:0',
            'revenue_pad' => 'nullable|numeric|min:0',
            'revenue_add' => 'nullable|numeric|min:0',
            'revenue_dd' => 'nullable|numeric|min:0',
            'revenue_pbh' => 'nullable|numeric|min:0',
            'spending_target' => 'required|numeric|min:0',
            'spending_realization' => 'required|numeric|min:0',
            'spending_pemerintahan' => 'nullable|numeric|min:0',
            'spending_pembangunan' => 'nullable|numeric|min:0',
            'spending_pembinaan' => 'nullable|numeric|min:0',
            'spending_pemberdayaan' => 'nullable|numeric|min:0',
            'spending_penanggulangan' => 'nullable|numeric|min:0',
            'financing_target' => 'required|numeric|min:0',
            'financing_realization' => 'required|numeric|min:0',
            'apbdes_poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'existing_document_titles.*' => 'nullable|string|max:255',
            'existing_document_categories.*' => 'required|string|in:budget,development,asset,report',
            'document_titles.*' => 'nullable|string|max:255',
            'document_files.*' => 'nullable|file|mimes:pdf|max:10240',
            'document_categories.*' => 'required|string|in:budget,development,asset,report',
        ]);

        $data = $request->except(['document_titles', 'document_files', 'document_categories', 'delete_documents', 'existing_document_titles', 'existing_document_categories']);
        $data['is_active'] = $request->has('is_active');

        // Handle APBDes Poster Upload
        if ($request->hasFile('apbdes_poster')) {
            // Delete old poster if exists
            if ($report->apbdes_poster && file_exists(public_path($report->apbdes_poster))) {
                @unlink(public_path($report->apbdes_poster));
            }

            $file = $request->file('apbdes_poster');
            $filename = time() . '_' . uniqid() . '_apbdes_poster.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/finance'), $filename);
            $data['apbdes_poster'] = 'uploads/finance/' . $filename;
        }

        $report->update($data);

        // 1. Handle deletion of existing documents
        if ($request->has('delete_documents')) {
            $deleteIds = $request->input('delete_documents');
            $documentsToDelete = $report->documents()->whereIn('id', $deleteIds)->get();
            foreach ($documentsToDelete as $doc) {
                if ($doc->file_path && file_exists(public_path($doc->file_path))) {
                    @unlink(public_path($doc->file_path));
                }
                $doc->delete();
            }
        }

        // 2. Handle editing of existing document titles/categories
        if ($request->has('existing_document_titles')) {
            $existingCategories = $request->input('existing_document_categories');
            foreach ($request->input('existing_document_titles') as $docId => $title) {
                $report->documents()->where('id', $docId)->update([
                    'title' => $title ?: 'Dokumen Transparansi',
                    'category' => $existingCategories[$docId] ?? 'budget',
                ]);
            }
        }

        // 3. Handle adding new documents
        if ($request->has('document_titles') && $request->hasFile('document_files')) {
            $titles = $request->input('document_titles');
            $files = $request->file('document_files');
            $categories = $request->input('document_categories');

            foreach ($files as $index => $file) {
                if ($file && isset($titles[$index]) && isset($categories[$index])) {
                    $filename = time() . '_' . uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/finance'), $filename);

                    $report->documents()->create([
                        'title' => $titles[$index] ?: 'Dokumen Transparansi',
                        'file_path' => 'uploads/finance/' . $filename,
                        'category' => $categories[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.transparency.index')->with('success', 'Tahun anggaran transparansi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $report = FinanceReport::findOrFail($id);

        // Delete poster file
        if ($report->apbdes_poster && file_exists(public_path($report->apbdes_poster))) {
            @unlink(public_path($report->apbdes_poster));
        }

        // Delete all document files
        foreach ($report->documents as $doc) {
            if ($doc->file_path && file_exists(public_path($doc->file_path))) {
                @unlink(public_path($doc->file_path));
            }
        }

        $report->delete();

        return redirect()->route('admin.transparency.index')->with('success', 'Tahun anggaran transparansi berhasil dihapus.');
    }
}
