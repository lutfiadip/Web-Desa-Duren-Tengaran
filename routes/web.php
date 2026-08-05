<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
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
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::get('/statistik', [HomeController::class, 'statistics'])->name('statistics');

// Admin Authentication Routes
Route::get('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard & CRUD Routes
Route::middleware([App\Http\Middleware\AdminAuth::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-setting', [App\Http\Controllers\Admin\ProfileController::class, 'updateSetting'])->name('profile.update-setting');
    
    Route::resource('news', App\Http\Controllers\Admin\NewsController::class)->except(['show']);
    Route::resource('regulations', App\Http\Controllers\Admin\RegulationController::class)->except(['show']);
    Route::resource('officials', App\Http\Controllers\Admin\OfficialController::class)->except(['show']);
    Route::resource('umkm', App\Http\Controllers\Admin\UmkmController::class)->except(['show']);
    Route::resource('tourism', App\Http\Controllers\Admin\TourismController::class)->except(['show']);
    Route::resource('culture', App\Http\Controllers\Admin\CultureController::class)->except(['show']);
    
    // Statistics Management
    Route::get('/statistics', [App\Http\Controllers\Admin\StatisticController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/{type}/edit', [App\Http\Controllers\Admin\StatisticController::class, 'edit'])->name('statistics.edit');
    Route::put('/statistics/{type}', [App\Http\Controllers\Admin\StatisticController::class, 'update'])->name('statistics.update');
});




