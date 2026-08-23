<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'globalSearch'])->name('search');
Route::get('/profil', [HomeController::class, 'profile'])->name('profile');
Route::get('/pemerintahan/perangkat', [HomeController::class, 'officials'])->name('officials');
Route::get('/pemerintahan/peraturan', [HomeController::class, 'regulations'])->name('regulations');
Route::get('/wisata-budaya', [HomeController::class, 'tourism'])->name('tourism');
Route::get('/potensi/pertanian-peternakan', [HomeController::class, 'agriculture'])->name('potensi.agriculture');
Route::get('/potensi/pertanian-peternakan/{slug}', [HomeController::class, 'agricultureDetail'])->name('potensi.agriculture.detail');
Route::get('/umkm', [HomeController::class, 'umkm'])->name('umkm');
Route::get('/umkm/{slug}', [HomeController::class, 'umkmDetail'])->name('umkm.detail');
Route::get('/wisata/{slug}', [HomeController::class, 'tourismDetail'])->name('tourism.detail');
Route::get('/budaya/{slug}', [HomeController::class, 'cultureDetail'])->name('culture.detail');
Route::get('/lembaga', [HomeController::class, 'institutions'])->name('institutions');
Route::get('/lembaga/{slug}', [HomeController::class, 'institutionDetail'])->name('institution.detail');
Route::get('/organisasi', [HomeController::class, 'organizations'])->name('organizations');
Route::get('/organisasi/{slug}', [HomeController::class, 'organizationDetail'])->name('organization.detail');
Route::get('/berita', [HomeController::class, 'news'])->name('news');
Route::get('/berita/{slug}', [HomeController::class, 'newsDetail'])->name('news.detail');
Route::get('/pengumuman', [HomeController::class, 'announcements'])->name('announcements');
Route::get('/pengumuman/{slug}', [HomeController::class, 'announcementDetail'])->name('announcements.detail');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::get('/statistik', [HomeController::class, 'statistics'])->name('statistics');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/layanan-publik', [HomeController::class, 'publicServices'])->name('public_services');
Route::get('/layanan-publik/{slug}', [HomeController::class, 'publicServiceDetail'])->name('public_services.detail');

// Admin Authentication Routes
Route::get('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard & CRUD Routes
Route::middleware([App\Http\Middleware\AdminAuth::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Homepage Settings
    Route::get('/homepage/edit', [App\Http\Controllers\Admin\ProfileController::class, 'editHomepage'])->name('homepage.edit');
    Route::put('/homepage/update', [App\Http\Controllers\Admin\ProfileController::class, 'updateHomepage'])->name('homepage.update');

    // Profile Settings
    Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-setting', [App\Http\Controllers\Admin\ProfileController::class, 'updateSetting'])->name('profile.update-setting');
    
    // Profile Sub-pages Settings
    Route::get('/profile/identity', [App\Http\Controllers\Admin\ProfileController::class, 'editIdentity'])->name('profile.edit-identity');
    Route::put('/profile/identity', [App\Http\Controllers\Admin\ProfileController::class, 'updateIdentity'])->name('profile.update-identity');
    
    Route::get('/profile/layout', [App\Http\Controllers\Admin\ProfileController::class, 'editLayout'])->name('profile.edit-layout');
    Route::put('/profile/layout', [App\Http\Controllers\Admin\ProfileController::class, 'updateLayout'])->name('profile.update-layout');
    
    Route::get('/profile/contact', [App\Http\Controllers\Admin\ProfileController::class, 'editContact'])->name('profile.edit-contact');
    Route::put('/profile/contact', [App\Http\Controllers\Admin\ProfileController::class, 'updateContact'])->name('profile.update-contact');

    Route::get('/profile/descriptions', [App\Http\Controllers\Admin\ProfileController::class, 'editDescriptions'])->name('profile.edit-descriptions');
    Route::put('/profile/descriptions', [App\Http\Controllers\Admin\ProfileController::class, 'updateDescriptions'])->name('profile.update-descriptions');
    
    Route::resource('regulations/categories', App\Http\Controllers\Admin\RegulationCategoryController::class)->names('regulations.categories')->except(['show']);
    Route::resource('regulations', App\Http\Controllers\Admin\RegulationController::class)->except(['show']);
    
    Route::post('news/upload-image', [App\Http\Controllers\Admin\NewsController::class, 'uploadImage'])->name('news.upload-image');
    Route::resource('news/categories', App\Http\Controllers\Admin\NewsCategoryController::class)->names('news.categories')->except(['show']);
    Route::resource('news', App\Http\Controllers\Admin\NewsController::class)->except(['show']);
    Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class)->except(['show']);
    
    Route::post('officials/categories/reorder', [App\Http\Controllers\Admin\OfficialCategoryController::class, 'reorder'])->name('officials.categories.reorder');
    Route::resource('officials/categories', App\Http\Controllers\Admin\OfficialCategoryController::class)->names('officials.categories')->except(['show']);
    Route::post('officials/structure', [App\Http\Controllers\Admin\OfficialController::class, 'updateStructure'])->name('officials.structure.update');
    Route::resource('officials', App\Http\Controllers\Admin\OfficialController::class)->except(['show']);
    Route::resource('umkm/categories', App\Http\Controllers\Admin\UmkmCategoryController::class)->names('umkm.categories')->except(['show']);
    Route::resource('umkm', App\Http\Controllers\Admin\UmkmController::class)->except(['show']);
    Route::resource('tourism', App\Http\Controllers\Admin\TourismController::class)->except(['show']);
    Route::resource('culture', App\Http\Controllers\Admin\CultureController::class)->except(['show']);
    Route::resource('gallery', App\Http\Controllers\Admin\GalleryController::class)->except(['show']);
    Route::post('gallery/delete-photo', [App\Http\Controllers\Admin\GalleryController::class, 'deletePhoto'])->name('gallery.delete-photo');
    
    // Public Services
    Route::resource('public-services', App\Http\Controllers\Admin\PublicServiceController::class)->except(['show']);

    // Admin Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    
    // Statistics Management
    Route::get('/statistics', [App\Http\Controllers\Admin\StatisticController::class, 'index'])->name('statistics.index');
    Route::post('/statistics/types/reorder', [App\Http\Controllers\Admin\StatisticController::class, 'reorderTypes'])->name('statistics.types.reorder');
    Route::resource('statistics/types', App\Http\Controllers\Admin\StatisticTypeController::class)->names('statistics.types')->except(['show']);
    Route::get('/statistics/{type_id}/manage', [App\Http\Controllers\Admin\StatisticController::class, 'manage'])->name('statistics.manage');
    Route::post('/statistics/{type_id}/manage', [App\Http\Controllers\Admin\StatisticController::class, 'saveManage'])->name('statistics.save-manage');

    // Agriculture & Livestock Management
    Route::get('/agriculture', [App\Http\Controllers\Admin\AgricultureController::class, 'index'])->name('agriculture.index');
    Route::put('/agriculture/profile', [App\Http\Controllers\Admin\AgricultureController::class, 'updateProfile'])->name('agriculture.update-profile');
    Route::resource('agriculture/categories', App\Http\Controllers\Admin\CommodityCategoryController::class)->names('agriculture.categories')->except(['show']);
    
    Route::get('/agriculture/land-statistic/create', [App\Http\Controllers\Admin\AgricultureController::class, 'createLand'])->name('agriculture.land.create');
    Route::post('/agriculture/land-statistic', [App\Http\Controllers\Admin\AgricultureController::class, 'storeLand'])->name('agriculture.land.store');
    Route::get('/agriculture/land-statistic/{land}/edit', [App\Http\Controllers\Admin\AgricultureController::class, 'editLand'])->name('agriculture.land.edit');
    Route::put('/agriculture/land-statistic/{land}', [App\Http\Controllers\Admin\AgricultureController::class, 'updateLand'])->name('agriculture.land.update');
    Route::delete('/agriculture/land-statistic/{land}', [App\Http\Controllers\Admin\AgricultureController::class, 'destroyLand'])->name('agriculture.land.destroy');
    
    Route::get('/agriculture/farmer-group/create', [App\Http\Controllers\Admin\AgricultureController::class, 'createFarmerGroup'])->name('agriculture.farmer-group.create');
    Route::post('/agriculture/farmer-group', [App\Http\Controllers\Admin\AgricultureController::class, 'storeFarmerGroup'])->name('agriculture.farmer-group.store');
    Route::get('/agriculture/farmer-group/{group}/edit', [App\Http\Controllers\Admin\AgricultureController::class, 'editFarmerGroup'])->name('agriculture.farmer-group.edit');
    Route::put('/agriculture/farmer-group/{group}', [App\Http\Controllers\Admin\AgricultureController::class, 'updateFarmerGroup'])->name('agriculture.farmer-group.update');
    Route::delete('/agriculture/farmer-group/{group}', [App\Http\Controllers\Admin\AgricultureController::class, 'destroyFarmerGroup'])->name('agriculture.farmer-group.destroy');
    
    Route::get('/agriculture/commodity/create', [App\Http\Controllers\Admin\AgricultureController::class, 'createCommodity'])->name('agriculture.commodity.create');
    Route::post('/agriculture/commodity', [App\Http\Controllers\Admin\AgricultureController::class, 'storeCommodity'])->name('agriculture.commodity.store');
    Route::get('/agriculture/commodity/{commodity}/edit', [App\Http\Controllers\Admin\AgricultureController::class, 'editCommodity'])->name('agriculture.commodity.edit');
    Route::put('/agriculture/commodity/{commodity}', [App\Http\Controllers\Admin\AgricultureController::class, 'updateCommodity'])->name('agriculture.commodity.update');
    Route::delete('/agriculture/commodity/{commodity}', [App\Http\Controllers\Admin\AgricultureController::class, 'destroyCommodity'])->name('agriculture.commodity.destroy');

    // Community Institutions (Lembaga & Organisasi) Management
    Route::get('/institutions', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'index'])->name('institutions.index');
    Route::get('/institutions/create', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'create'])->name('institutions.create');
    Route::post('/institutions', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'store'])->name('institutions.store');
    Route::get('/institutions/{institution}/edit', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'edit'])->name('institutions.edit');
    Route::put('/institutions/{institution}', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'update'])->name('institutions.update');
    Route::delete('/institutions/{institution}', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'destroy'])->name('institutions.destroy');

    Route::get('/organizations', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'indexOrg'])->name('organizations.index');
    Route::get('/organizations/create', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'createOrg'])->name('organizations.create');
    Route::post('/organizations', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'storeOrg'])->name('organizations.store');
    Route::get('/organizations/{institution}/edit', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'editOrg'])->name('organizations.edit');
    Route::put('/organizations/{institution}', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'updateOrg'])->name('organizations.update');
    Route::delete('/organizations/{institution}', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'destroyOrg'])->name('organizations.destroy');

    // Members Sub-resource
    Route::get('/institutions/{institution}/members', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'membersIndex'])->name('institutions.members.index');
    Route::post('/institutions/{institution}/members', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'storeMember'])->name('institutions.members.store');
    Route::delete('/institutions/members/{member}', [App\Http\Controllers\Admin\CommunityInstitutionController::class, 'destroyMember'])->name('institutions.members.destroy');

    // Facilities (Sarana & Prasarana)
    Route::get('/facilities', [App\Http\Controllers\Admin\FacilityController::class, 'index'])->name('facilities.index');
    Route::post('/facilities/category', [App\Http\Controllers\Admin\FacilityController::class, 'storeCategory'])->name('facilities.category.store');
    Route::put('/facilities/category/{category}', [App\Http\Controllers\Admin\FacilityController::class, 'updateCategory'])->name('facilities.category.update');
    Route::delete('/facilities/category/{category}', [App\Http\Controllers\Admin\FacilityController::class, 'destroyCategory'])->name('facilities.category.destroy');
    Route::post('/facilities', [App\Http\Controllers\Admin\FacilityController::class, 'store'])->name('facilities.store');
    Route::put('/facilities/{facility}', [App\Http\Controllers\Admin\FacilityController::class, 'update'])->name('facilities.update');
    Route::delete('/facilities/{facility}', [App\Http\Controllers\Admin\FacilityController::class, 'destroy'])->name('facilities.destroy');
});




