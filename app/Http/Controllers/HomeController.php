<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VillageProfile;
use App\Models\DemographicStatistic;
use App\Models\Umkm;
use App\Models\News;
use App\Models\Gallery;
use App\Models\VillageDetail;
use App\Models\OfficialCategory;
use App\Models\Official;
use App\Models\RegulationCategory;
use App\Models\Regulation;

class HomeController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();
        
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

        return view('welcome', compact('profile', 'demografi', 'umkms', 'news', 'galleries', 'villageDetail'));
    }

    public function profile()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();
        
        // Mengambil statistik demografi
        $demografi = new \stdClass();
        $demografi->total_penduduk = DemographicStatistic::where('label', 'Total Penduduk')->first();
        $demografi->rt = DemographicStatistic::where('label', 'Rukun Tetangga')->first();
        $demografi->rw = DemographicStatistic::where('label', 'Rukun Warga')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        return view('profile', compact('profile', 'demografi', 'villageDetail'));
    }

    public function officials()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        // Get officials grouped by hierarchy
        $kades = Official::where('position', 'Kepala Desa')->first();
        $sekdes = Official::where('position', 'Sekretaris Desa')->first();
        
        // Staff/Kaur/Kasi (sort_order between 3 and 8)
        $staff = Official::whereIn('sort_order', [3, 4, 5, 6, 7, 8])->orderBy('sort_order')->get();
        
        // Kewilayahan/Kadus (sort_order >= 9)
        $kadus = Official::where('sort_order', '>=', 9)->orderBy('sort_order')->get();

        return view('officials', compact('profile', 'villageDetail', 'kades', 'sekdes', 'staff', 'kadus'));
    }

    public function regulations()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        // Get all published regulations
        $regulations = Regulation::with('category')
            ->where('status', 'published')
            ->orderBy('year', 'desc')
            ->orderBy('number', 'asc')
            ->get();

        // Get all categories for filter
        $categories = RegulationCategory::all();

        return view('regulations', compact('profile', 'villageDetail', 'regulations', 'categories'));
    }
}
