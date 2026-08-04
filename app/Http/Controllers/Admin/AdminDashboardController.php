<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Regulation;
use App\Models\Official;
use App\Models\Umkm;
use App\Models\TouristAttraction;
use App\Models\Culture;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'news' => News::count(),
            'regulations' => Regulation::count(),
            'officials' => Official::count(),
            'umkm' => Umkm::count(),
            'tourism' => TouristAttraction::count(),
            'culture' => Culture::count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
