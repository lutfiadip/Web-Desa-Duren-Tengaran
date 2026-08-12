<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use App\Models\AgricultureProfile;
use App\Models\LandStatistic;
use App\Models\FarmerGroup;
use App\Models\AgricultureCommodity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgricultureController extends Controller
{
    public function index(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        $agriProfile = AgricultureProfile::firstOrCreate([]);
        $landStats = LandStatistic::orderBy('sort_order')->get();
        $farmerGroups = FarmerGroup::all();
        $commodities = AgricultureCommodity::latest()->get();
        $activeTab = $request->query('tab', 'profile');

        return view('admin.agriculture.index', compact(
            'profile', 'agriProfile', 'landStats', 'farmerGroups', 'commodities', 'activeTab'
        ));
    }

    public function updateProfile(Request $request)
    {
        $agriProfile = AgricultureProfile::firstOrCreate([]);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description_1' => 'nullable|string',
            'description_2' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'subtitle', 'description_1', 'description_2']);

        $agriProfile->update($data);

        return redirect()->route('admin.agriculture.index', ['tab' => 'profile'])->with('success', 'Profil pertanian desa berhasil diperbarui.');
    }

    // --- LAND STATISTICS ---
    public function createLand()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.land.create', compact('profile'));
    }

    public function storeLand(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
        ]);

        LandStatistic::create($request->all());

        return redirect()->route('admin.agriculture.index', ['tab' => 'land-statistics'])->with('success', 'Statistik lahan berhasil ditambahkan.');
    }

    public function editLand($id)
    {
        $land = LandStatistic::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.land.edit', compact('land', 'profile'));
    }

    public function updateLand(Request $request, $id)
    {
        $land = LandStatistic::findOrFail($id);
        $request->validate([
            'label' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'required|integer',
        ]);

        $land->update($request->all());

        return redirect()->route('admin.agriculture.index', ['tab' => 'land-statistics'])->with('success', 'Statistik lahan berhasil diperbarui.');
    }

    public function destroyLand($id)
    {
        $land = LandStatistic::findOrFail($id);
        $land->delete();
        return redirect()->route('admin.agriculture.index', ['tab' => 'land-statistics'])->with('success', 'Statistik lahan berhasil dihapus.');
    }

    // --- FARMER GROUPS ---
    public function createFarmerGroup()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.farmer-group.create', compact('profile'));
    }

    public function storeFarmerGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'dusun' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        FarmerGroup::create($request->all());

        return redirect()->route('admin.agriculture.index', ['tab' => 'farmer-groups'])->with('success', 'Kelompok tani berhasil ditambahkan.');
    }

    public function editFarmerGroup($id)
    {
        $group = FarmerGroup::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.farmer-group.edit', compact('group', 'profile'));
    }

    public function updateFarmerGroup(Request $request, $id)
    {
        $group = FarmerGroup::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'dusun' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $group->update($request->all());

        return redirect()->route('admin.agriculture.index', ['tab' => 'farmer-groups'])->with('success', 'Kelompok tani berhasil diperbarui.');
    }

    public function destroyFarmerGroup($id)
    {
        $group = FarmerGroup::findOrFail($id);
        $group->delete();
        return redirect()->route('admin.agriculture.index', ['tab' => 'farmer-groups'])->with('success', 'Kelompok tani berhasil dihapus.');
    }

    // --- COMMODITIES ---
    public function createCommodity()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.commodity.create', compact('profile'));
    }

    public function storeCommodity(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'production_scale' => 'nullable|string|max:255',
            'harvest_time' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'category', 'description', 'production_scale',
            'harvest_time', 'address', 'contact', 'google_maps_url',
            'is_featured'
        ]);

        $data['status'] = $request->has('status') ? 'published' : 'draft';

        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/agriculture'), $filename);
            $data['thumbnail'] = 'uploads/agriculture/' . $filename;
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/agriculture'), $filename);
                $gallery[] = 'uploads/agriculture/' . $filename;
            }
        }
        $data['gallery'] = json_encode($gallery);

        AgricultureCommodity::create($data);

        return redirect()->route('admin.agriculture.index', ['tab' => 'commodities'])->with('success', 'Komoditas berhasil ditambahkan.');
    }

    public function editCommodity($id)
    {
        $commodity = AgricultureCommodity::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.agriculture.commodity.edit', compact('commodity', 'profile'));
    }

    public function updateCommodity(Request $request, $id)
    {
        $commodity = AgricultureCommodity::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'production_scale' => 'nullable|string|max:255',
            'harvest_time' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'is_featured' => 'required|boolean',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only([
            'title', 'category', 'description', 'production_scale',
            'harvest_time', 'address', 'contact', 'google_maps_url',
            'is_featured'
        ]);

        $data['status'] = $request->has('status') ? 'published' : 'draft';

        if ($commodity->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('thumbnail')) {
            if ($commodity->thumbnail && file_exists(public_path($commodity->thumbnail))) {
                @unlink(public_path($commodity->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/agriculture'), $filename);
            $data['thumbnail'] = 'uploads/agriculture/' . $filename;
        }

        $existingGallery = is_string($commodity->gallery) ? json_decode($commodity->gallery, true) : ($commodity->gallery ?? []);
        if (!is_array($existingGallery)) {
            $existingGallery = [];
        }

        if ($request->hasFile('gallery_files')) {
            if ($request->boolean('replace_gallery')) {
                foreach ($existingGallery as $gPath) {
                    if (file_exists(public_path($gPath))) {
                        @unlink(public_path($gPath));
                    }
                }
                $existingGallery = [];
            }

            foreach ($request->file('gallery_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/agriculture'), $filename);
                $existingGallery[] = 'uploads/agriculture/' . $filename;
            }
        }
        $data['gallery'] = json_encode($existingGallery);

        $commodity->update($data);

        return redirect()->route('admin.agriculture.index', ['tab' => 'commodities'])->with('success', 'Komoditas berhasil diperbarui.');
    }

    public function destroyCommodity($id)
    {
        $commodity = AgricultureCommodity::findOrFail($id);

        if ($commodity->thumbnail && file_exists(public_path($commodity->thumbnail))) {
            @unlink(public_path($commodity->thumbnail));
        }

        $gallery = is_string($commodity->gallery) ? json_decode($commodity->gallery, true) : ($commodity->gallery ?? []);
        if (is_array($gallery)) {
            foreach ($gallery as $gPath) {
                if (file_exists(public_path($gPath))) {
                    @unlink(public_path($gPath));
                }
            }
        }

        $commodity->delete();

        return redirect()->route('admin.agriculture.index', ['tab' => 'commodities'])->with('success', 'Komoditas berhasil dihapus.');
    }
}
