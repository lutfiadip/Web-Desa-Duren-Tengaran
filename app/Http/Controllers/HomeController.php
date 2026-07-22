<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VillageProfile;
use App\Models\DemographicStatistic;
use App\Models\Umkm;
use App\Models\News;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first();
        
        // Mengambil statistik demografi
        $demografi = new \stdClass();
        $demografi->total_penduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        $demografi->rt = DemographicStatistic::where('label', 'Rukun Tetangga')->first();
        $demografi->rw = DemographicStatistic::where('label', 'Rukun Warga')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        // Mengambil 3 UMKM unggulan terbaru yang dipublish
        $umkms = Umkm::where('status', 'published')
                     ->where('is_featured', true)
                     ->latest()
                     ->take(3)
                     ->get();

        // Mengambil 3 berita terbaru
        $news = News::with('category')
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->take(3)
                    ->get();

        // Mengambil 4 galeri terbaru
        $galleries = Gallery::latest()->take(4)->get();

        return view('welcome', compact('profile', 'demografi', 'umkms', 'news', 'galleries'));
    }

    public function profile()
    {
        $profile = VillageProfile::first();
        
        // Mengambil statistik demografi
        $demografi = new \stdClass();
        $demografi->total_penduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        $demografi->rt = DemographicStatistic::where('label', 'Rukun Tetangga')->first();
        $demografi->rw = DemographicStatistic::where('label', 'Rukun Warga')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        return view('profile', compact('profile', 'demografi'));
    }
}
