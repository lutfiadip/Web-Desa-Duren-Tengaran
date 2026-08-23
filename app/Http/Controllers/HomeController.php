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
use App\Models\PopulationStatistic;
use App\Models\PopulationStatisticType;
use App\Models\PublicService;
use App\Models\Announcement;


class HomeController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();
        
        // Mengambil statistik jenis kelamin untuk total penduduk di widget beranda
        $genderType = PopulationStatisticType::where('slug', 'gender')->first();
        $populationGender = null;
        if ($genderType) {
            $populationGender = PopulationStatistic::with('details')
                ->where('statistic_type_id', $genderType->id)
                ->where('is_published', true)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
                
            if ($populationGender) {
                // Attach dynamic total for the frontend widget
                foreach ($populationGender->details as $d) {
                    $d->total = $d->male_total + $d->female_total;
                }
            }
        }

        // Mengambil statistik demografi
        $demografi = new \stdClass();
        
        $maleCount = 0;
        $femaleCount = 0;
        if ($populationGender) {
            $maleCount = $populationGender->details->sum('male_total');
            $femaleCount = $populationGender->details->sum('female_total');
        }
        
        $demografi->total_penduduk = (object)[
            'male_count' => $maleCount,
            'female_count' => $femaleCount
        ];
        
        $demografi->rt = DemographicStatistic::where('label', 'Rukun Tetangga')->first();
        $demografi->rw = DemographicStatistic::where('label', 'Rukun Warga')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        // Mengambil 3 UMKM unggulan terbaru yang dipublish
        $umkms = Umkm::where('status', 'published')
                     ->where('is_featured', true)
                     ->latest()
                     ->take(3)
                     ->get();

        // Mengambil 3 Wisata terbaru/unggulan
        $tourisms = TouristAttraction::where('status', 'published')
                     ->orderBy('is_featured', 'desc')
                     ->latest()
                     ->take(3)
                     ->get();

        // Mengambil 3 Budaya terbaru/unggulan
        $cultures = Culture::where('status', 'published')
                     ->orderBy('is_featured', 'desc')
                     ->latest()
                     ->take(3)
                     ->get();

        // Mengambil 3 berita terbaru
        $news = News::with('category')
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->take(3)
                    ->get();

        // Mengambil galeri unggulan terbaru (maksimal 9), dengan fallback galeri terbaru jika belum ada yang unggulan
        $galleries = Gallery::where('is_featured', true)->latest()->take(9)->get();
        if ($galleries->isEmpty()) {
            $galleries = Gallery::latest()->take(9)->get();
        }

        $defaultOrder = [
            'about',
            'potency',
            'umkm',
            'tourism',
            'news',
            'gallery'
        ];
        
        $sectionsOrder = ($profile && $profile->homepage_sections_order)
            ? explode(',', $profile->homepage_sections_order)
            : $defaultOrder;
            
        foreach ($defaultOrder as $sec) {
            if (!in_array($sec, $sectionsOrder)) {
                $sectionsOrder[] = $sec;
            }
        }

        // Mengambil 3 pengumuman terbaru yang aktif
        $announcements = Announcement::active()->latest()->take(3)->get();

        return view('welcome', compact('profile', 'demografi', 'umkms', 'tourisms', 'cultures', 'news', 'announcements', 'galleries', 'villageDetail', 'populationGender', 'sectionsOrder'));
    }

    public function globalSearch(Request $request)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $query = $request->input('search');
        
        $results = [
            'news' => collect(),
            'umkm' => collect(),
            'tourism' => collect(),
            'public_services' => collect(),
            'cultures' => collect()
        ];

        if (!empty($query)) {
            if ($profile->publish_news ?? true) {
                $results['news'] = News::where('status', 'published')
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', '%' . $query . '%')
                          ->orWhere('content', 'LIKE', '%' . $query . '%');
                    })->limit(10)->get();
            }

            if ($profile->publish_umkm ?? true) {
                $results['umkm'] = Umkm::where('status', 'published')
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', '%' . $query . '%')
                          ->orWhere('description', 'LIKE', '%' . $query . '%');
                    })->limit(10)->get();
            }

            if ($profile->publish_tourism ?? true) {
                $results['tourism'] = TouristAttraction::where('status', 'published')
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', '%' . $query . '%')
                          ->orWhere('description', 'LIKE', '%' . $query . '%');
                    })->limit(10)->get();
            }

            $results['public_services'] = PublicService::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', '%' . $query . '%')
                      ->orWhere('description', 'LIKE', '%' . $query . '%');
                })->limit(10)->get();

            if ($profile->publish_culture ?? true) {
                $results['cultures'] = Culture::where('status', 'published')
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', '%' . $query . '%')
                          ->orWhere('description', 'LIKE', '%' . $query . '%');
                    })->limit(10)->get();
            }
        }

        return view('search', compact('profile', 'villageDetail', 'results', 'query'));
    }

    public function profile()
    {
        $profile = VillageProfile::first();
        if ($profile && !$profile->publish_profile) {
            return redirect()->route('home')->with('error', 'Halaman Profil Desa saat ini sedang dinonaktifkan.');
        }
        $villageDetail = VillageDetail::first();
        
        // Mengambil statistik demografi
        $demografi = new \stdClass();
        
        $genderType = PopulationStatisticType::where('slug', 'gender')->first();
        $maleCount = 0;
        $femaleCount = 0;
        if ($genderType) {
            $populationGender = PopulationStatistic::with('details')
                ->where('statistic_type_id', $genderType->id)
                ->where('is_published', true)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
                
            if ($populationGender) {
                $maleCount = $populationGender->details->sum('male_total');
                $femaleCount = $populationGender->details->sum('female_total');
            }
        }
        
        $demografi->total_penduduk = (object)[
            'male_count' => $maleCount,
            'female_count' => $femaleCount
        ];
        
        $demografi->rt = DemographicStatistic::where('label', 'Rukun Tetangga')->first();
        $demografi->rw = DemographicStatistic::where('label', 'Rukun Warga')->first();
        $demografi->luas_wilayah = DemographicStatistic::where('label', 'Luas Wilayah')->first();

        $defaultOrder = [
            'detail_wilayah',
            'sambutan_kades',
            'visi_misi',
            'sejarah',
            'struktur_organisasi',
            'geografis_dusun',
            'sarana_prasarana'
        ];
        
        $sectionsOrder = ($profile && $profile->profile_sections_order)
            ? explode(',', $profile->profile_sections_order)
            : $defaultOrder;
            
        foreach ($defaultOrder as $sec) {
            if (!in_array($sec, $sectionsOrder)) {
                $sectionsOrder[] = $sec;
            }
        }

        // Fetch facilities for the new section
        $facilityCategories = \App\Models\FacilityCategory::with('facilities')->orderBy('order')->get();

        return view('profile', compact('profile', 'demografi', 'villageDetail', 'sectionsOrder', 'facilityCategories'));
    }

    public function officials()
    {
        $profile = VillageProfile::first();
        if ($profile && !$profile->publish_officials) {
            return redirect()->route('home')->with('error', 'Halaman Perangkat Desa saat ini sedang dinonaktifkan.');
        }
        $villageDetail = VillageDetail::first();

        // Get categories ordered by sort_order with active officials
        $categories = \App\Models\OfficialCategory::with(['officials' => function($query) {
            $query->where('status', true)->orderBy('sort_order');
        }])->orderBy('sort_order')->get()->filter(function($category) {
            return $category->officials->isNotEmpty();
        });

        return view('officials', compact('profile', 'villageDetail', 'categories'));
    }

    public function regulations()
    {
        $profile = VillageProfile::first();
        if ($profile && !$profile->publish_regulations) {
            return redirect()->route('home')->with('error', 'Halaman Peraturan Desa saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_tourism && !$profile->publish_culture) {
            return redirect()->route('home')->with('error', 'Halaman Wisata dan Budaya saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_tourism) {
            return redirect()->route('home')->with('error', 'Halaman Detail Wisata saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !($profile->publish_culture ?? $profile->publish_tourism ?? true)) {
            return redirect()->route('home')->with('error', 'Halaman Detail Budaya saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_umkm) {
            return redirect()->route('home')->with('error', 'Halaman UMKM Desa saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_umkm) {
            return redirect()->route('home')->with('error', 'Halaman Detail UMKM saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_agriculture) {
            return redirect()->route('home')->with('error', 'Halaman Pertanian & Peternakan saat ini sedang dinonaktifkan.');
        }
        $villageDetail = VillageDetail::first();

        $agriProfile = AgricultureProfile::first();
        $landStats = LandStatistic::orderBy('sort_order')->get();
        $farmerGroups = FarmerGroup::all();
        $commodities = AgricultureCommodity::where('status', 'published')
            ->orderBy('is_featured', 'desc')
            ->latest()
            ->get();

        return view('agriculture', compact('profile', 'villageDetail', 'agriProfile', 'landStats', 'farmerGroups', 'commodities'));
    }

    public function agricultureDetail($slug)
    {
        $profile = VillageProfile::first();
        if ($profile && !$profile->publish_agriculture) {
            return redirect()->route('home')->with('error', 'Halaman Detail Komoditas saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_institutions) {
            return redirect()->route('home')->with('error', 'Halaman Kelembagaan saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_institutions) {
            return redirect()->route('home')->with('error', 'Halaman Detail Lembaga saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_institutions) {
            return redirect()->route('home')->with('error', 'Halaman Organisasi Kemasyarakatan saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_institutions) {
            return redirect()->route('home')->with('error', 'Halaman Detail Organisasi saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_news) {
            return redirect()->route('home')->with('error', 'Halaman Berita Desa saat ini sedang dinonaktifkan.');
        }
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
        if ($profile && !$profile->publish_news) {
            return redirect()->route('home')->with('error', 'Halaman Detail Berita saat ini sedang dinonaktifkan.');
        }
        $villageDetail = VillageDetail::first();

        $article = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count
        $article->increment('views');

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

    public function statistics()
    {
        $profile = VillageProfile::first();
        if ($profile && !$profile->publish_statistics) {
            return redirect()->route('home')->with('error', 'Halaman Statistik Penduduk saat ini sedang dinonaktifkan.');
        }
        $villageDetail = VillageDetail::first();

        // Fetch all active statistic types sorted by display_order
        $statisticTypes = PopulationStatisticType::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $statisticsData = [];
        foreach ($statisticTypes as $type) {
            $latestStat = PopulationStatistic::with('details')
                ->where('statistic_type_id', $type->id)
                ->where('is_published', true)
                ->orderBy('year', 'desc')
                ->orderBy('semester', 'desc')
                ->first();
                
            if ($latestStat) {
                // Calculate dynamic totals and percentages
                $details = $latestStat->details;
                $sumTotal = $details->sum(function($d) {
                    return $d->male_total + $d->female_total;
                });
                
                foreach ($details as $d) {
                    $d->total = $d->male_total + $d->female_total;
                    $d->percentage = $sumTotal > 0 ? round(($d->total / $sumTotal) * 100, 2) : 0;
                }
                
                $statisticsData[] = [
                    'type' => $type,
                    'statistic' => $latestStat,
                    'details' => $details,
                    'total_male' => $details->sum('male_total'),
                    'total_female' => $details->sum('female_total'),
                    'grand_total' => $sumTotal
                ];
            }
        }

        return view('statistics', compact('profile', 'villageDetail', 'statisticsData'));
    }

    public function publicServices()
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();
        
        $services = PublicService::where('is_active', true)->orderBy('created_at', 'desc')->paginate(12);
        
        return view('public_services', compact('profile', 'villageDetail', 'services'));
    }

    public function publicServiceDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();
        
        $service = PublicService::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        return view('public_service_detail', compact('profile', 'villageDetail', 'service'));
    }

    public function gallery()
    {
        $profile = VillageProfile::first();

        $villageDetail = VillageDetail::first();
        
        // Fetch all galleries paginated (12 items per page)
        $galleries = \App\Models\Gallery::latest()->paginate(12);
        
        return view('gallery', compact('profile', 'villageDetail', 'galleries'));
    }

    public function announcements(Request $request)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $query = Announcement::active();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $announcements = $query->latest()->paginate(10);

        return view('announcements', compact('profile', 'villageDetail', 'announcements'));
    }

    public function announcementDetail($slug)
    {
        $profile = VillageProfile::first();
        $villageDetail = VillageDetail::first();

        $announcement = Announcement::where('slug', $slug)->active()->firstOrFail();

        return view('announcement-detail', compact('profile', 'villageDetail', 'announcement'));
    }
}
