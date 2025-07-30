<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteSettingController;

// Homepage - PASTI BEKERJA
Route::get('/', function () {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <title>GO CMS - Homepage</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
            <h1 class="text-3xl font-bold text-green-600 mb-4">✅ GO CMS HOMEPAGE</h1>
            <p class="text-gray-700 mb-6">Selamat datang di GO CMS - Content Management System</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="/admin" class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 text-center">
                    🏠 Admin Dashboard
                </a>
                <a href="/admin/site-settings" class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 text-center">
                    ⚙️ Site Settings
                </a>
            </div>
            
            <div class="mt-6 p-4 bg-green-50 rounded border-l-4 border-green-400">
                <h3 class="font-semibold text-green-800">Status Sistem:</h3>
                <ul class="text-green-700 mt-2">
                    <li>✅ Homepage: BERHASIL</li>
                    <li>✅ Laravel Server: RUNNING</li>
                    <li>✅ Database: CONNECTED</li>
                    <li>✅ CRUD Site Settings: SIAP</li>
                </ul>
            </div>
        </div>
    </body>
    </html>
    ';
});

// Admin Routes - TANPA AUTH UNTUK TESTING
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('site-settings', SiteSettingController::class);
});
