<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopulationStatistic;
use App\Models\PopulationStatisticDetail;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $isFiltered = request()->has('year') && request()->has('semester');
        $year = request('year');
        $semester = request('semester');

        if ($isFiltered) {
            $gender = PopulationStatistic::where('type', 'gender')
                ->where('year', $year)
                ->where('semester', $semester)
                ->first();
                
            $age = PopulationStatistic::where('type', 'age')
                ->where('year', $year)
                ->where('semester', $semester)
                ->first();
                
            $kk = PopulationStatistic::where('type', 'family_card')
                ->where('year', $year)
                ->where('semester', $semester)
                ->first();
        } else {
            $gender = PopulationStatistic::where('type', 'gender')
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
                
            $age = PopulationStatistic::where('type', 'age')
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
                
            $kk = PopulationStatistic::where('type', 'family_card')
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();

            // Set the dropdown default indicators based on the latest record
            $latest = PopulationStatistic::orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
            
            $year = $latest ? $latest->year : date('Y');
            $semester = $latest ? $latest->semester : 2;
        }

        // Get filter years range
        $dbYears = PopulationStatistic::pluck('year')->unique()->toArray();
        $currentYear = intval(date('Y'));
        
        $mergeYears = [$currentYear - 2, $currentYear - 1, $currentYear, $currentYear + 1, $currentYear + 2];
        if ($year) {
            $mergeYears[] = intval($year);
        }
        
        $filterYears = array_unique(array_merge($mergeYears, $dbYears));
        sort($filterYears);

        return view('admin.statistics.index', compact('gender', 'age', 'kk', 'year', 'semester', 'filterYears', 'isFiltered'));
    }

    public function edit($type)
    {
        if (!in_array($type, ['gender', 'age', 'family_card'])) {
            abort(404);
        }

        // Get requested year and semester or default to latest in DB
        $year = request('year');
        $semester = request('semester');

        if (!$year || !$semester) {
            $latest = PopulationStatistic::where('type', $type)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
            
            $year = $latest ? $latest->year : date('Y');
            $semester = $latest ? $latest->semester : 2;
        }

        $statistic = PopulationStatistic::with('details')
            ->where('type', $type)
            ->where('year', $year)
            ->where('semester', $semester)
            ->first();

        // If none exists, create a new one copying structure from the latest template
        if (!$statistic) {
            $statistic = PopulationStatistic::create([
                'type' => $type,
                'semester' => $semester,
                'year' => $year,
                'source' => 'DKB Semester ' . ($semester == 1 ? 'I' : 'II') . ' ' . $year
            ]);

            // Find a template statistic to copy detail labels from
            $template = PopulationStatistic::with('details')
                ->where('type', $type)
                ->where('id', '!=', $statistic->id)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();

            if ($template && $template->details->count() > 0) {
                foreach ($template->details as $d) {
                    PopulationStatisticDetail::create([
                        'statistic_id' => $statistic->id,
                        'label' => $d->label,
                        'male_total' => 0,
                        'female_total' => 0,
                        'display_order' => $d->display_order
                    ]);
                }
            } else {
                if ($type === 'gender') {
                    PopulationStatisticDetail::create([
                        'statistic_id' => $statistic->id,
                        'label' => 'Total Penduduk',
                        'male_total' => 0,
                        'female_total' => 0,
                        'display_order' => 1
                    ]);
                } elseif ($type === 'age') {
                    $ageGroups = ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75+'];
                    foreach ($ageGroups as $index => $label) {
                        PopulationStatisticDetail::create([
                            'statistic_id' => $statistic->id,
                            'label' => $label,
                            'male_total' => 0,
                            'female_total' => 0,
                            'display_order' => $index + 1
                        ]);
                    }
                } elseif ($type === 'family_card') {
                    PopulationStatisticDetail::create([
                        'statistic_id' => $statistic->id,
                        'label' => 'Sudah Memiliki KK',
                        'male_total' => 0,
                        'female_total' => 0,
                        'display_order' => 1
                    ]);
                    PopulationStatisticDetail::create([
                        'statistic_id' => $statistic->id,
                        'label' => 'Belum Memiliki KK',
                        'male_total' => 0,
                        'female_total' => 0,
                        'display_order' => 2
                    ]);
                }
            }
            
            $statistic->load('details');
        }

        return view('admin.statistics.edit', compact('statistic', 'type'));
    }

    public function update(Request $request, $type)
    {
        if (!in_array($type, ['gender', 'age', 'family_card'])) {
            abort(404);
        }

        $request->validate([
            'semester' => 'required|integer|min:1|max:2',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'source' => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
            'details' => 'required|array',
            'details.*.label' => 'required|string|max:255',
            'details.*.male' => 'required|integer|min:0',
            'details.*.female' => 'required|integer|min:0',
        ]);

        $statistic = PopulationStatistic::where('type', $type)
            ->where('year', $request->year)
            ->where('semester', $request->semester)
            ->first();

        if (!$statistic) {
            $statistic = PopulationStatistic::create([
                'type' => $type,
                'semester' => $request->semester,
                'year' => $request->year,
                'source' => $request->source,
            ]);
        }

        $updateData = [
            'source' => $request->source,
        ];

        if ($request->hasFile('pdf_file')) {
            // Delete old PDF file if exists
            if ($statistic->pdf_file && file_exists(public_path($statistic->pdf_file))) {
                @unlink(public_path($statistic->pdf_file));
            }

            $file = $request->file('pdf_file');
            $filename = 'statistic_pdf_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/statistics'), $filename);
            $updateData['pdf_file'] = 'uploads/statistics/' . $filename;
        }

        $statistic->update($updateData);

        $submittedIds = [];
        $index = 1;

        foreach ($request->details as $detailData) {
            $detailId = $detailData['id'] ?? null;
            $detail = null;

            if ($detailId) {
                $detail = PopulationStatisticDetail::where('statistic_id', $statistic->id)->find($detailId);
            }

            $male = intval($detailData['male']);
            $female = intval($detailData['female']);
            $total = $male + $female;

            $data = [
                'label' => $detailData['label'],
                'male_total' => $male,
                'female_total' => $female,
                'total' => $total,
                'display_order' => $index++,
            ];

            if ($detail) {
                $detail->update($data);
                $submittedIds[] = $detail->id;
            } else {
                $newDetail = PopulationStatisticDetail::create(array_merge($data, [
                    'statistic_id' => $statistic->id
                ]));
                $submittedIds[] = $newDetail->id;
            }
        }

        // Delete details that were not submitted (only for age groups)
        if ($type === 'age') {
            PopulationStatisticDetail::where('statistic_id', $statistic->id)
                ->whereNotIn('id', $submittedIds)
                ->delete();
        }

        // Recalculate percentages
        $details = PopulationStatisticDetail::where('statistic_id', $statistic->id)->get();
        $sumOfTotals = $details->sum('total');

        if ($type === 'gender') {
            foreach ($details as $d) {
                $d->percentage = 100.00;
                $d->save();
            }
        } else {
            if ($sumOfTotals > 0) {
                foreach ($details as $d) {
                    $d->percentage = round(($d->total / $sumOfTotals) * 100, 2);
                    $d->save();
                }
            } else {
                foreach ($details as $d) {
                    $d->percentage = 0.00;
                    $d->save();
                }
            }
        }

        // Force parent model's updated_at timestamp to update
        $statistic->touch();

        return redirect()->route('admin.statistics.index')->with('success', 'Statistik kependudukan berhasil diperbarui.');
    }
}
