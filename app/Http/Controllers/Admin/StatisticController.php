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
        $gender = PopulationStatistic::where('type', 'gender')->orderBy('year', 'desc')->orderBy('semester', 'desc')->first();
        $age = PopulationStatistic::where('type', 'age')->orderBy('year', 'desc')->orderBy('semester', 'desc')->first();
        $kk = PopulationStatistic::where('type', 'family_card')->orderBy('year', 'desc')->orderBy('semester', 'desc')->first();

        return view('admin.statistics.index', compact('gender', 'age', 'kk'));
    }

    public function edit($type)
    {
        if (!in_array($type, ['gender', 'age', 'family_card'])) {
            abort(404);
        }

        $statistic = PopulationStatistic::with('details')->where('type', $type)->orderBy('year', 'desc')->orderBy('semester', 'desc')->first();

        // If none exists, create a new empty one
        if (!$statistic) {
            $statistic = PopulationStatistic::create([
                'type' => $type,
                'semester' => 2,
                'year' => date('Y'),
                'source' => 'DKB Semester II ' . date('Y')
            ]);
            
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
            
            $statistic->load('details');
        }

        return view('admin.statistics.edit', compact('statistic', 'type'));
    }

    public function update(Request $request, $type)
    {
        if (!in_array($type, ['gender', 'age', 'family_card'])) {
            abort(404);
        }

        $statistic = PopulationStatistic::where('type', $type)->orderBy('year', 'desc')->orderBy('semester', 'desc')->first();
        if (!$statistic) {
            abort(404);
        }

        $request->validate([
            'semester' => 'required|integer|min:1|max:2',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'source' => 'required|string|max:255',
            'details' => 'required|array',
            'details.*.male' => 'required|integer|min:0',
            'details.*.female' => 'required|integer|min:0',
        ]);

        $statistic->update([
            'semester' => $request->semester,
            'year' => $request->year,
            'source' => $request->source,
        ]);

        foreach ($request->details as $detailId => $values) {
            $detail = PopulationStatisticDetail::where('statistic_id', $statistic->id)->where('id', $detailId)->first();
            if ($detail) {
                $detail->update([
                    'male_total' => $values['male'],
                    'female_total' => $values['female'],
                ]);
            }
        }

        // Recalculate percentages
        $details = PopulationStatisticDetail::where('statistic_id', $statistic->id)->get();
        
        if ($type === 'age') {
            $genderStat = PopulationStatistic::where('type', 'gender')->orderBy('year', 'desc')->orderBy('semester', 'desc')->first();
            $totalPop = 0;
            if ($genderStat && $genderStat->details->first()) {
                $totalPop = $genderStat->details->first()->male_total + $genderStat->details->first()->female_total;
            } else {
                $totalPop = $details->sum(function($d) { return $d->male_total + $d->female_total; });
            }
            
            if ($totalPop > 0) {
                foreach ($details as $d) {
                    $d->percentage = round((($d->male_total + $d->female_total) / $totalPop) * 100, 2);
                    $d->save();
                }
            }
        } elseif ($type === 'family_card') {
            $totalKK = $details->sum(function($d) { return $d->male_total + $d->female_total; });
            if ($totalKK > 0) {
                foreach ($details as $d) {
                    $d->percentage = round((($d->male_total + $d->female_total) / $totalKK) * 100, 2);
                    $d->save();
                }
            }
        } else {
            foreach ($details as $d) {
                $d->percentage = 100.00;
                $d->save();
            }
        }

        return redirect()->route('admin.statistics.index')->with('success', 'Statistik kependudukan berhasil diperbarui.');
    }
}
