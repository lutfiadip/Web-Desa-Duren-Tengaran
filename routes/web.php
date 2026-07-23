<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profile'])->name('profile');
Route::get('/pemerintahan/perangkat', [HomeController::class, 'officials'])->name('officials');
Route::get('/pemerintahan/peraturan', [HomeController::class, 'regulations'])->name('regulations');
