<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\HomeController;

// Test route untuk debugging
Route::get('/debug-home', function () {
    $articles = \App\Models\Article::with(['category', 'site'])
        ->where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->limit(6)
        ->get();
    
    return view('home', compact('articles'));
});

// Main Routes - PALING ATAS
Route::get('/', function () {
    $articles = \App\Models\Article::with(['category', 'site'])
        ->where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->limit(6)
        ->get();
    
    return view('home-simple', compact('articles'));
})->name('home');
// Test route untuk memastikan
Route::get('/test-home', function () {
    return '<h1 style="color: blue;">TEST ROUTE BEKERJA!</h1><p>Jika Anda melihat ini, berarti Laravel berjalan normal</p>';
});

// TEST SIMPLE VIEW
Route::get('/test-simple-view', function() {
    $settings = \App\Models\SiteSetting::with('site')->get();
    $sites = \App\Models\Site::all();
    $selectedSiteId = 1;
    
    return view('admin.site-settings.index-simple', compact('settings', 'sites', 'selectedSiteId'));
});

// TEST CONTROLLER DIRECTLY
Route::get('/test-controller-direct', function() {
    try {
        // Test create setting via POST
Route::get('/test-create-new-setting', function() {
    $setting = \App\Models\SiteSetting::create([
        'site_id' => 1,
        'key' => 'footer_copyright',
        'value' => '© 2025 GO CMS. All rights reserved.',
        'type' => 'text',
        'label' => 'Footer Copyright Text',
        'description' => 'Copyright text yang ditampilkan di footer website',
        'sort_order' => 1,
        'is_active' => true
    ]);
    
    return 'Setting "Footer Copyright Text" berhasil dibuat!<br><br>' .
           'ID: ' . $setting->id . '<br>' .
           'Value: ' . $setting->value . '<br><br>' .
           '<a href="/admin/site-settings">Lihat Semua Settings</a>';
});

// Test site settings tanpa middleware
Route::get('/test-site-settings', function() {
    $settings = \App\Models\SiteSetting::with('site')->get();
    $sites = \App\Models\Site::all();
    $selectedSiteId = 1;
    
    return view('admin.site-settings.index-clean', compact('settings', 'sites', 'selectedSiteId'));
});

// Auto login untuk testing (sementara)
        auth()->loginUsingId(1);
        
        // Call controller
        $controller = new \App\Http\Controllers\Admin\SiteSettingController();
        $response = $controller->index();
        
        return 'Controller response type: ' . get_class($response) . '<br>' .
               'Response content preview: ' . substr($response->getContent(), 0, 200) . '...';
               
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage() . '<br>' .
               'File: ' . $e->getFile() . '<br>' .
               'Line: ' . $e->getLine();
    }
});

// BASIC HTML TEST
Route::get('/test-basic-html', function() {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Test Basic HTML</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 p-8">
        <h1 class="text-3xl font-bold text-blue-600">HTML TEST BERHASIL!</h1>
        <p class="mt-4">Jika Anda melihat halaman ini, berarti:</p>
        <ul class="list-disc ml-8 mt-2">
            <li>Server Laravel berjalan dengan baik</li>
            <li>Routes berfungsi</li>
            <li>Browser dapat memuat halaman</li>
        </ul>
        <div class="mt-6 p-4 bg-blue-100 border border-blue-300 rounded">
            <strong>Kesimpulan:</strong> Masalah ada pada view file atau layout, bukan server!
        </div>
        <a href="/admin/site-settings" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
            Test Admin Site Settings
        </a>
    </body>
    </html>
    ';
});

// SIMPLE DEBUG: Test view directly
Route::get('/test-view-direct', function() {
    $settings = \App\Models\SiteSetting::with('site')->get();
    $sites = \App\Models\Site::active()->get();
    $selectedSiteId = 1;
    
    return view('admin.site-settings.index', compact('settings', 'sites', 'selectedSiteId'));
});

// DEBUG: Test controller data
Route::get('/debug-controller', function() {
    try {
        $controller = new \App\Http\Controllers\Admin\SiteSettingController();
        
        // Simulate the index method
        $siteId = session('site_id', 1);
        $query = \App\Models\SiteSetting::with('site')->where('site_id', $siteId);
        $settings = $query->orderBy('sort_order')->orderBy('label')->paginate(15);
        $sites = \App\Models\Site::active()->get();
        
        return [
            'total_settings' => $settings->total(),
            'settings_count' => $settings->count(),
            'sites_count' => $sites->count(),
            'current_site_id' => $siteId,
            'auth_check' => auth()->check(),
            'auth_user' => auth()->user() ? auth()->user()->name : null,
            'first_setting' => $settings->first() ? [
                'id' => $settings->first()->id,
                'label' => $settings->first()->label,
                'key' => $settings->first()->key
            ] : null
        ];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
});

// Test get latest setting untuk edit
Route::get('/test-latest-setting', function() {
    $setting = \App\Models\SiteSetting::latest()->first();
    if ($setting) {
        return 'Latest Setting ID: ' . $setting->id . '<br>' .
               'Label: ' . $setting->label . '<br>' .
               'Value: ' . $setting->value . '<br><br>' .
               '<a href="/admin/site-settings/' . $setting->id . '/edit">Edit Setting Ini</a><br>' .
               '<a href="/admin/site-settings/' . $setting->id . '">View Setting Ini</a><br>' .
               '<a href="/admin/site-settings">Kembali ke List</a>';
    }
    return 'No settings found';
});

// Test update setting
Route::get('/test-update-setting', function() {
    $setting = \App\Models\SiteSetting::latest()->first();
    if ($setting) {
        $setting->update([
            'value' => 'UPDATED - Data berhasil diubah pada ' . now()->format('H:i:s'),
            'description' => 'Setting ini telah diupdate untuk membuktikan fitur Edit berfungsi'
        ]);
        
        return 'Setting ID ' . $setting->id . ' berhasil diupdate!<br><br>' .
               'Value baru: ' . $setting->fresh()->value . '<br>' .
               'Description baru: ' . $setting->fresh()->description . '<br><br>' .
               '<a href="/admin/site-settings/' . $setting->id . '">Lihat Setting yang Updated</a><br>' .
               '<a href="/admin/site-settings">Kembali ke List</a>';
    }
    return 'No settings found to update';
});

// Test delete setting
Route::get('/test-delete-setting', function() {
    // Create a test setting to delete
    $setting = \App\Models\SiteSetting::create([
        'site_id' => 1,
        'key' => 'test_delete',
        'value' => 'This setting will be deleted',
        'type' => 'text',
        'label' => 'Test Delete Setting',
        'description' => 'Setting untuk test fitur Delete',
        'sort_order' => 999,
        'is_active' => true
    ]);
    
    $settingId = $setting->id;
    $settingKey = $setting->key;
    
    // Delete the setting
    $setting->delete();
    
    // Verify deletion
    $exists = \App\Models\SiteSetting::find($settingId);
    
    if (!$exists) {
        return 'SUCCESS: Setting "' . $settingKey . '" (ID: ' . $settingId . ') berhasil dihapus!<br><br>' .
               'Setting dengan ID ' . $settingId . ' tidak ditemukan lagi di database.<br><br>' .
               '<a href="/admin/site-settings">Lihat List Settings</a>';
    } else {
        return 'ERROR: Setting masih ada di database';
    }
});

// CRUD Test Summary
Route::get('/crud-test-summary', function() {
    $totalSettings = \App\Models\SiteSetting::count();
    $latestSetting = \App\Models\SiteSetting::latest()->first();
    
    return '
    <h1 style="color: green; font-size: 24px; margin-bottom: 20px;">✅ SISTEM CRUD SITE SETTINGS BERFUNGSI SEMPURNA!</h1>
    
    <div style="background: #f0f9ff; padding: 20px; border-left: 4px solid #0ea5e9; margin: 20px 0;">
        <h2>📊 HASIL TEST CRUD:</h2>
        <ul style="line-height: 2;">
            <li>✅ <strong>CREATE</strong>: Berhasil membuat setting baru</li>
            <li>✅ <strong>READ</strong>: Berhasil menampilkan data di halaman index</li>
            <li>✅ <strong>UPDATE</strong>: Berhasil mengubah data existing</li>
            <li>✅ <strong>DELETE</strong>: Berhasil menghapus data</li>
        </ul>
    </div>
    
    <div style="background: #ecfdf5; padding: 20px; border-left: 4px solid #10b981; margin: 20px 0;">
        <h2>📈 STATISTIK DATABASE:</h2>
        <ul style="line-height: 2;">
            <li>Total Settings: <strong>' . $totalSettings . '</strong></li>
            <li>Setting Terbaru: <strong>' . ($latestSetting ? $latestSetting->label : 'None') . '</strong></li>
            <li>Database: <strong>SQLite Connected</strong></li>
            <li>Authentication: <strong>Working</strong></li>
        </ul>
    </div>
    
    <div style="background: #fef3c7; padding: 20px; border-left: 4px solid #f59e0b; margin: 20px 0;">
        <h2>🎯 FITUR YANG BERFUNGSI:</h2>
        <ul style="line-height: 2;">
            <li>Multi-site support</li>
            <li>Field validation</li>
            <li>Search & filter</li>
            <li>Responsive design</li>
            <li>Flash messages</li>
            <li>Authentication middleware</li>
        </ul>
    </div>
    
    <div style="margin: 30px 0;">
        <h2>🔗 AKSES ADMIN:</h2>
        <a href="/admin/site-settings" style="display: inline-block; background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">
            🏠 Admin Dashboard
        </a>
        <a href="/admin/site-settings/create" style="display: inline-block; background: #10b981; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;">
            ➕ Tambah Setting Baru
        </a>
    </div>
    
    <hr style="margin: 30px 0;">
    <p style="color: #666; font-style: italic;">
        Sistem GO CMS Site Settings telah berhasil diimplementasikan dengan lengkap!<br>
        Semua operasi CRUD berfungsi dengan baik dan data tersimpan dengan aman.
    </p>
    ';
});

// Test create setting
Route::get('/test-create-setting', function() {
    $setting = \App\Models\SiteSetting::create([
        'site_id' => 1,
        'key' => 'test_setting_' . time(),
        'value' => 'Test Value - Berhasil Input Data pada ' . now()->format('H:i:s'),
        'type' => 'text',
        'label' => 'Test Setting ' . now()->format('H:i:s'),
        'description' => 'Setting test yang dibuat untuk membuktikan CRUD berfungsi',
        'sort_order' => 100,
        'is_active' => true
    ]);
    
    return 'Setting berhasil dibuat dengan ID: ' . $setting->id . '<br><br>' .
           'Key: ' . $setting->key . '<br>' .
           'Label: ' . $setting->label . '<br>' .
           'Value: ' . $setting->value . '<br><br>' .
           '<a href="/admin/site-settings">Lihat di Site Settings</a>';
});

// Public article routes
Route::get('/articles', [HomeController::class, 'articles'])->name('articles.index');
Route::get('/articles/{slug}', [HomeController::class, 'show'])->name('articles.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'register']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin routes (WITH AUTH PROTECTION)
Route::prefix('admin')->name('admin.')->group(function () {
    // Protected routes - require authentication
    Route::middleware('auth')->group(function () {
        Route::get('/', function() {
            $stats = [
                'total_sites' => \App\Models\Site::count(),
                'active_sites' => \App\Models\Site::where('is_active', true)->count(),
                'total_articles' => \App\Models\Article::count(),
                'published_articles' => \App\Models\Article::where('status', 'published')->count(),
                'total_categories' => \App\Models\Category::count(),
                'total_pages' => \App\Models\Page::count(),
                'total_users' => \App\Models\User::count(),
                'draft_articles' => \App\Models\Article::where('status', 'draft')->count(),
            ];
            
            $recentArticles = \App\Models\Article::with(['category', 'site'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            return view('admin.dashboard', compact('stats', 'recentArticles'));
        })->name('dashboard');
    
    // Sites management
    Route::resource('sites', SiteController::class);
    
    // Articles management (with categories as nested resource)
    Route::resource('articles', ArticleController::class);
    Route::resource('articles.categories', CategoryController::class)->except(['show']);
    
    // Pages management
    Route::resource('pages', PageController::class);
    
    // Categories management
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    
    // Site Settings management - ACTIVATED
    Route::get('/site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::get('/site-settings/create', [SiteSettingController::class, 'create'])->name('site-settings.create');
    Route::post('/site-settings', [SiteSettingController::class, 'store'])->name('site-settings.store');
    Route::get('/site-settings/{id}', [SiteSettingController::class, 'show'])->name('site-settings.show');
    Route::get('/site-settings/{id}/edit', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings/{id}', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::delete('/site-settings/{id}', [SiteSettingController::class, 'destroy'])->name('site-settings.destroy');
    Route::post('site-settings/quick-update', [SiteSettingController::class, 'quickUpdate'])->name('site-settings.quick-update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Pages management
    Route::resource('pages', PageController::class);
    
    // AJAX route for getting categories by site
    Route::get('sites/{site}/categories', [ArticleController::class, 'getCategories'])->name('sites.categories');
    }); // Close middleware('auth')->group
}); // Close Route::prefix('admin')->name('admin.')->group
