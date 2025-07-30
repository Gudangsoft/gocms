<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteSettingController;

// Auto login untuk testing (sementara)
Route::get('/auto-login', function() {
    auth()->loginUsingId(1);
    return redirect('/admin');
});

// Main Routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (dengan auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('site-settings', SiteSettingController::class);
});

// Authentication Routes
require __DIR__.'/auth.php';
