<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopulationStatistic;
use App\Models\PopulationStatisticDetail;
use App\Models\PopulationStatisticType;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $types = PopulationStatisticType::orderBy('display_order')->get();
        
        // Load village profile toggle status
        $profile = VillageProfile::first();

        return view('admin.statistics.index', compact('types', 'profile'));
    }

    public function reorderTypes(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:population_statistic_types,id',
        ]);

        foreach ($request->order as $index => $id) {
            PopulationStatisticType::where('id', $id)->update([
                'display_order' => $index + 1
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function manage(Request $request, $type_id)
    {
        $type = PopulationStatisticType::findOrFail($type_id);
        
        $year = $request->query('year');
        $semester = $request->query('semester');

        if (!$year || !$semester) {
            $latest = PopulationStatistic::where('statistic_type_id', $type->id)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
            
            $year = $latest ? $latest->year : date('Y');
            $semester = $latest ? $latest->semester : 2;
        }

        $year = intval($year);
        $semester = intval($semester);

        $statistic = PopulationStatistic::with('details')
            ->where('statistic_type_id', $type->id)
            ->where('year', $year)
            ->where('semester', $semester)
            ->first();

        $isNew = false;
        
        // If not found, prepare a temporary unsaved instance
        if (!$statistic) {
            $isNew = true;
            $statistic = new PopulationStatistic([
                'statistic_type_id' => $type->id,
                'year' => $year,
                'semester' => $semester,
                'source' => 'DKB Semester ' . ($semester == 1 ? 'I' : 'II') . ' ' . $year,
                'is_published' => true,
            ]);
            
            // Try to find the latest populated statistic to copy categories/labels from as a template
            $template = PopulationStatistic::where('statistic_type_id', $type->id)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
                
            if ($template) {
                $details = [];
                foreach ($template->details as $d) {
                    $details[] = new PopulationStatisticDetail([
                        'label' => $d->label,
                        'male_total' => 0,
                        'female_total' => 0,
                        'display_order' => $d->display_order,
                    ]);
                }
                $statistic->setRelation('details', collect($details));
            } else {
                $statistic->setRelation('details', collect([]));
            }
        }

        // Years range for period filter dropdown
        $dbYears = PopulationStatistic::pluck('year')->map(fn($y) => intval($y))->unique()->toArray();
        $currentYear = intval(date('Y'));
        
        $mergeYears = [$currentYear - 2, $currentYear - 1, $currentYear, $currentYear + 1, $currentYear + 2];
        if ($year) {
            $mergeYears[] = $year;
        }
        
        $filterYears = array_unique(array_merge($mergeYears, $dbYears));
        rsort($filterYears);

        // Fetch all distinct saved periods for this statistic type to show indicators
        $savedPeriods = PopulationStatistic::where('statistic_type_id', $type->id)
            ->select('year', 'semester')
            ->get()
            ->map(fn($p) => $p->year . '-' . $p->semester)
            ->toArray();

        return view('admin.statistics.manage', compact('type', 'statistic', 'year', 'semester', 'filterYears', 'isNew', 'savedPeriods'));
    }

    public function saveManage(Request $request, $type_id)
    {
        $type = PopulationStatisticType::findOrFail($type_id);

        $request->validate([
            'year' => 'required|integer|min:1900|max:2100',
            'semester' => 'required|integer|in:1,2',
            'source' => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
            'notes' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'show_gender_percentage' => 'nullable|boolean',
            'categories' => 'required|array|min:1',
            'categories.*.label' => 'required|string|max:255',
            'categories.*.male' => 'required|integer|min:0',
            'categories.*.female' => 'required|integer|min:0',
        ]);

        $type->update([
            'show_gender_percentage' => $request->has('show_gender_percentage')
        ]);

        $statistic = PopulationStatistic::where('statistic_type_id', $type->id)
            ->where('year', $request->year)
            ->where('semester', $request->semester)
            ->first();

        if (!$statistic) {
            $statistic = PopulationStatistic::create([
                'statistic_type_id' => $type->id,
                'year' => $request->year,
                'semester' => $request->semester,
                'source' => $request->source,
                'notes' => $request->notes,
                'is_published' => $request->has('is_published'),
                'published_at' => $request->has('is_published') ? now() : null,
            ]);
        } else {
            $updateData = [
                'source' => $request->source,
                'notes' => $request->notes,
                'is_published' => $request->has('is_published'),
            ];

            if ($request->has('is_published')) {
                if (!$statistic->is_published) {
                    $updateData['published_at'] = now();
                }
            } else {
                $updateData['published_at'] = null;
            }

            $statistic->update($updateData);
        }

        // Upload PDF if present
        if ($request->hasFile('pdf_file')) {
            if ($statistic->pdf_file && file_exists(public_path($statistic->pdf_file))) {
                @unlink(public_path($statistic->pdf_file));
            }

            $file = $request->file('pdf_file');
            $filename = 'statistic_pdf_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/statistics'), $filename);
            $statistic->update([
                'pdf_file' => 'uploads/statistics/' . $filename
            ]);
        }

        // Delete old details and recreate in correct display order
        PopulationStatisticDetail::where('statistic_id', $statistic->id)->delete();

        foreach ($request->categories as $index => $catData) {
            PopulationStatisticDetail::create([
                'statistic_id' => $statistic->id,
                'label' => $catData['label'],
                'male_total' => intval($catData['male']),
                'female_total' => intval($catData['female']),
                'display_order' => $index + 1,
            ]);
        }

        $statistic->touch();

        return redirect()->route('admin.statistics.manage', [
            'type_id' => $type->id,
            'year' => $statistic->year,
            'semester' => $statistic->semester
        ])->with('success', 'Statistik kependudukan periode Semester ' . ($statistic->semester == 1 ? 'I (Ganjil)' : 'II (Genap)') . ' ' . $statistic->year . ' berhasil disimpan.');
    }
}
