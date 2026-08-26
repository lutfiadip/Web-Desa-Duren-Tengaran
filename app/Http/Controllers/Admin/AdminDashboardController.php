<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Regulation;
use App\Models\Official;
use App\Models\Umkm;
use App\Models\TouristAttraction;
use App\Models\Culture;
use App\Models\Announcement;
use App\Models\Facility;
use App\Models\CommunityInstitution;
use App\Models\AgricultureCommodity;
use App\Models\PublicService;
use App\Models\Gallery;

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
            'announcements' => Announcement::count(),
            'facilities' => Facility::count(),
            'institutions' => CommunityInstitution::count(),
            'agriculture' => AgricultureCommodity::count(),
            'services' => PublicService::count(),
            'gallery' => Gallery::count(),
        ];

        $recentNews = News::latest()->take(3)->get()->map(function($item) {
            return [
                'type' => 'news',
                'title' => $item->title,
                'time' => $item->created_at,
                'icon' => 'fa-newspaper',
                'color' => '#2563eb',
                'bg' => '#eff6ff'
            ];
        });

        $recentRegs = Regulation::latest()->take(3)->get()->map(function($item) {
            return [
                'type' => 'regulation',
                'title' => $item->title,
                'time' => $item->created_at,
                'icon' => 'fa-gavel',
                'color' => '#d97706',
                'bg' => '#fef3c7'
            ];
        });

        $recentUmkm = Umkm::latest()->take(3)->get()->map(function($item) {
            return [
                'type' => 'umkm',
                'title' => $item->name,
                'time' => $item->created_at,
                'icon' => 'fa-store',
                'color' => '#9333ea',
                'bg' => '#faf5ff'
            ];
        });

        $recentActivities = collect()
            ->concat($recentNews)
            ->concat($recentRegs)
            ->concat($recentUmkm)
            ->sortByDesc('time')
            ->take(5);

        return view('admin.dashboard', compact('counts', 'recentActivities'));
    }
}
