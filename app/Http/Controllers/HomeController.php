<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VillageProfile;
use App\Models\DemographicStatistic;
use App\Models\Umkm;
use App\Models\UmkmCategory;
use App\Models\News;
use App\Models\Gallery;
use App\Models\VillageDetail;
use App\Models\OfficialCategory;
use App\Models\Official;
use App\Models\RegulationCategory;
use App\Models\Regulation;
use App\Models\TouristAttraction;
use App\Models\Culture;
use App\Models\AgricultureProfile;
use App\Models\LandStatistic;
use App\Models\FarmerGroup;
use App\Models\AgricultureCommodity;
use App\Models\CommunityInstitutionCategory;
use App\Models\CommunityInstitution;
use App\Models\CommunityInstitutionMember;
use App\Models\NewsCategory;


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

    public function tourism()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $attractions = TouristAttraction::where('status', 'published')
            ->orderBy('is_featured', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        $cultures = Culture::where('status', 'published')
            ->orderBy('is_featured', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        return view('tourism', compact('profile', 'villageDetail', 'attractions', 'cultures'));
    }

    public function tourismDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $attraction = TouristAttraction::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Mengambil wisata lainnya untuk rekomendasi
        $otherAttractions = TouristAttraction::where('id', '!=', $attraction->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('tourism-detail', compact('profile', 'villageDetail', 'attraction', 'otherAttractions'));
    }

    public function cultureDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $culture = Culture::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Mengambil kebudayaan lainnya untuk rekomendasi
        $otherCultures = Culture::where('id', '!=', $culture->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('culture-detail', compact('profile', 'villageDetail', 'culture', 'otherCultures'));
    }

    public function umkm()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $umkms = Umkm::with('category')
            ->where('status', 'published')
            ->latest()
            ->get();

        $categories = UmkmCategory::all();

        return view('umkm', compact('profile', 'villageDetail', 'umkms', 'categories'));
    }

    public function umkmDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $umkm = Umkm::with('category')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Mengambil UMKM lainnya untuk rekomendasi
        $otherUmkms = Umkm::where('id', '!=', $umkm->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('umkm-detail', compact('profile', 'villageDetail', 'umkm', 'otherUmkms'));
    }

    public function agriculture()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $agriProfile = AgricultureProfile::first();
        $landStats = LandStatistic::orderBy('sort_order')->get();
        $farmerGroups = FarmerGroup::all();
        $commodities = AgricultureCommodity::where('status', 'published')->get();

        return view('agriculture', compact('profile', 'villageDetail', 'agriProfile', 'landStats', 'farmerGroups', 'commodities'));
    }

    public function agricultureDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $commodity = AgricultureCommodity::where('slug', $slug)->where('status', 'published')->firstOrFail();

        // Mengambil komoditas lainnya untuk rekomendasi
        $otherCommodities = AgricultureCommodity::where('id', '!=', $commodity->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('agriculture-detail', compact('profile', 'villageDetail', 'commodity', 'otherCommodities'));
    }

    public function institutions()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $categories = CommunityInstitutionCategory::where('name', 'LIKE', '%Lembaga Kemasyarakatan%')
            ->with(['institutions' => function($query) {
                $query->where('status', 'published');
            }])->get();

        return view('institutions', compact('profile', 'villageDetail', 'categories'));
    }

    public function institutionDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $institution = CommunityInstitution::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $members = CommunityInstitutionMember::where('institution_id', $institution->id)
            ->orderBy('sort_order')
            ->get();

        return view('institution-detail', compact('profile', 'villageDetail', 'institution', 'members'));
    }

    public function organizations()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $categories = CommunityInstitutionCategory::where('name', 'LIKE', '%Organisasi Kemasyarakatan%')
            ->with(['institutions' => function($query) {
                $query->where('status', 'published');
            }])->get();

        return view('organizations', compact('profile', 'villageDetail', 'categories'));
    }

    public function organizationDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $institution = CommunityInstitution::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $members = CommunityInstitutionMember::where('institution_id', $institution->id)
            ->orderBy('sort_order')
            ->get();

        return view('organization-detail', compact('profile', 'villageDetail', 'institution', 'members'));
    }

    public function news(Request $request)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $query = News::where('status', 'published')->with('category')->orderBy('published_at', 'desc');

        // Search text
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('content', 'LIKE', '%' . $search . '%');
            });
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $news = $query->paginate(6)->withQueryString();
        $categories = NewsCategory::all();

        return view('news', compact('profile', 'villageDetail', 'news', 'categories'));
    }

    public function newsDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $article = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // 3 newest other published news
        $recentNews = News::where('id', '!=', $article->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $categories = NewsCategory::all();

        return view('news-detail', compact('profile', 'villageDetail', 'article', 'recentNews', 'categories'));
    }

    public function contact()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();
        return view('contact', compact('profile', 'villageDetail'));
    }
}

