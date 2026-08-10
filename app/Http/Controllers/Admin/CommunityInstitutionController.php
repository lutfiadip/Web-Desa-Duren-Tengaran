<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use App\Models\CommunityInstitution;
use App\Models\CommunityInstitutionCategory;
use App\Models\CommunityInstitutionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CommunityInstitutionController extends Controller
{
    private function getCategory($type)
    {
        if ($type === 'lkd') {
            return CommunityInstitutionCategory::firstOrCreate(
                ['name' => 'Lembaga Kemasyarakatan Desa (LKD)']
            );
        } else {
            return CommunityInstitutionCategory::firstOrCreate(
                ['name' => 'Organisasi Kemasyarakatan']
            );
        }
    }

    // ==========================================
    // LEMBAGA KEMASYARAKATAN (LKD)
    // ==========================================

    public function index(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        $category = $this->getCategory('lkd');
        
        $query = CommunityInstitution::where('category_id', $category->id);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $institutions = $query->latest()->paginate(10);
        return view('admin.institutions.index', compact('institutions', 'profile'));
    }

    public function create()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.institutions.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $category = $this->getCategory('lkd');
        $data = $request->only(['name', 'description', 'vision', 'mission', 'contact', 'email', 'address']);
        $data['status'] = $request->has('status') ? 'published' : 'draft';
        $data['category_id'] = $category->id;
        $data['user_id'] = Auth::id() ?? 1;
        $data['slug'] = Str::slug($request->name) . '-' . rand(1000, 9999);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/institutions'), $filename);
            $data['logo'] = 'uploads/institutions/' . $filename;
        }

        CommunityInstitution::create($data);

        return redirect()->route('admin.institutions.index')->with('success', 'Lembaga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $institution = CommunityInstitution::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.institutions.edit', compact('institution', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $institution = CommunityInstitution::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'vision', 'mission', 'contact', 'email', 'address']);
        $data['status'] = $request->has('status') ? 'published' : 'draft';

        if ($institution->name !== $request->name) {
            $data['slug'] = Str::slug($request->name) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('logo')) {
            if ($institution->logo && file_exists(public_path($institution->logo))) {
                @unlink(public_path($institution->logo));
            }
            $file = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/institutions'), $filename);
            $data['logo'] = 'uploads/institutions/' . $filename;
        }

        $institution->update($data);

        return redirect()->route('admin.institutions.index')->with('success', 'Lembaga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $institution = CommunityInstitution::findOrFail($id);

        if ($institution->logo && file_exists(public_path($institution->logo))) {
            @unlink(public_path($institution->logo));
        }

        // Delete all member photos from disk
        foreach ($institution->members as $member) {
            if ($member->photo && file_exists(public_path($member->photo))) {
                @unlink(public_path($member->photo));
            }
        }

        $institution->delete();

        return redirect()->route('admin.institutions.index')->with('success', 'Lembaga berhasil dihapus.');
    }

    // ==========================================
    // ORGANISASI KEMASYARAKATAN (ORMAS)
    // ==========================================

    public function indexOrg(Request $request)
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        $category = $this->getCategory('ormas');
        
        $query = CommunityInstitution::where('category_id', $category->id);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $institutions = $query->latest()->paginate(10);
        return view('admin.organizations.index', compact('institutions', 'profile'));
    }

    public function createOrg()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.organizations.create', compact('profile'));
    }

    public function storeOrg(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $category = $this->getCategory('ormas');
        $data = $request->only(['name', 'description', 'vision', 'mission', 'contact', 'email', 'address']);
        $data['status'] = $request->has('status') ? 'published' : 'draft';
        $data['category_id'] = $category->id;
        $data['user_id'] = Auth::id() ?? 1;
        $data['slug'] = Str::slug($request->name) . '-' . rand(1000, 9999);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/institutions'), $filename);
            $data['logo'] = 'uploads/institutions/' . $filename;
        }

        CommunityInstitution::create($data);

        return redirect()->route('admin.organizations.index')->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function editOrg($id)
    {
        $institution = CommunityInstitution::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.organizations.edit', compact('institution', 'profile'));
    }

    public function updateOrg(Request $request, $id)
    {
        $institution = CommunityInstitution::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'vision', 'mission', 'contact', 'email', 'address']);
        $data['status'] = $request->has('status') ? 'published' : 'draft';

        if ($institution->name !== $request->name) {
            $data['slug'] = Str::slug($request->name) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('logo')) {
            if ($institution->logo && file_exists(public_path($institution->logo))) {
                @unlink(public_path($institution->logo));
            }
            $file = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/institutions'), $filename);
            $data['logo'] = 'uploads/institutions/' . $filename;
        }

        $institution->update($data);

        return redirect()->route('admin.organizations.index')->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroyOrg($id)
    {
        $institution = CommunityInstitution::findOrFail($id);

        if ($institution->logo && file_exists(public_path($institution->logo))) {
            @unlink(public_path($institution->logo));
        }

        // Delete all member photos from disk
        foreach ($institution->members as $member) {
            if ($member->photo && file_exists(public_path($member->photo))) {
                @unlink(public_path($member->photo));
            }
        }

        $institution->delete();

        return redirect()->route('admin.organizations.index')->with('success', 'Organisasi berhasil dihapus.');
    }

    // ==========================================
    // MEMBERS OF INSTITUTION/ORGANIZATION
    // ==========================================

    public function membersIndex($institution_id)
    {
        $institution = CommunityInstitution::with('members')->findOrFail($institution_id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.institutions.members', compact('institution', 'profile'));
    }

    public function storeMember(Request $request, $institution_id)
    {
        $institution = CommunityInstitution::findOrFail($institution_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'sort_order' => 'required|integer',
        ]);

        $data = $request->only(['name', 'position', 'sort_order']);
        $data['institution_id'] = $institution->id;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/institutions/members'), $filename);
            $data['photo'] = 'uploads/institutions/members/' . $filename;
        }

        CommunityInstitutionMember::create($data);

        return redirect()->back()->with('success', 'Anggota kepengurusan berhasil ditambahkan.');
    }

    public function destroyMember($id)
    {
        $member = CommunityInstitutionMember::findOrFail($id);

        if ($member->photo && file_exists(public_path($member->photo))) {
            @unlink(public_path($member->photo));
        }

        $member->delete();

        return redirect()->back()->with('success', 'Anggota kepengurusan berhasil dihapus.');
    }
}
