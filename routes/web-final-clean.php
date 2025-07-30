<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\PageController;

// Homepage Route - TAMPILAN BAGUS
Route::get('/', function () {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GO CMS - Modern Content Management</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    </head>
    <body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <!-- Hero Section -->
        <div class="container mx-auto px-4 py-16">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">
                    <span class="text-blue-600">GO</span> CMS
                </h1>
                <p class="text-xl text-gray-600 mb-8">Modern Multi-Site Content Management System</p>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Multi-Site</h3>
                    <p class="text-gray-600">Kelola multiple website dari satu dashboard admin yang powerful</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-green-600 text-3xl mb-4">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Content Editor</h3>
                    <p class="text-gray-600">Rich text editor dengan fitur lengkap untuk membuat konten yang menarik</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-purple-600 text-3xl mb-4">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Responsive</h3>
                    <p class="text-gray-600">Tampilan optimal di semua device - desktop, tablet, dan mobile</p>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center">
                <a href="/admin" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Masuk ke Admin Dashboard
                </a>
            </div>

            <!-- Stats Section -->
            <div class="mt-16 bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">System Status</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">✓</div>
                        <div class="text-gray-600 mt-2">Laravel 12</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">✓</div>
                        <div class="text-gray-600 mt-2">Database Connected</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">✓</div>
                        <div class="text-gray-600 mt-2">Multi-Site Ready</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-indigo-600">✓</div>
                        <div class="text-gray-600 mt-2">CMS Active</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4 text-center">
                <p>© 2025 GO CMS. All rights reserved.</p>
            </div>
        </footer>
    </body>
    </html>
    ';
});

// Admin routes (TANPA AUTH UNTUK TESTING)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function() {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <title>GO CMS Admin Dashboard</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        </head>
        <body class="bg-gray-100">
            <nav class="bg-blue-600 text-white p-4">
                <div class="container mx-auto flex justify-between items-center">
                    <h1 class="text-xl font-bold">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        GO CMS Admin
                    </h1>
                    <div class="space-x-4">
                        <a href="/" class="hover:underline">
                            <i class="fas fa-home mr-1"></i>
                            Home
                        </a>
                        <a href="/admin/articles" class="hover:underline">
                            <i class="fas fa-newspaper mr-1"></i>
                            Articles
                        </a>
                        <a href="/admin/categories" class="hover:underline">
                            <i class="fas fa-tags mr-1"></i>
                            Categories
                        </a>
                        <a href="/admin/sites" class="hover:underline">
                            <i class="fas fa-globe mr-1"></i>
                            Sites
                        </a>
                    </div>
                </div>
            </nav>

            <div class="container mx-auto px-4 py-8">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h2>
                    <p class="text-gray-600">Welcome to GO CMS Admin Panel</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-globe text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">Sites</h3>
                                <p class="text-2xl font-bold text-blue-600">Active</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-newspaper text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">Articles</h3>
                                <p class="text-2xl font-bold text-green-600">Ready</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-tags text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">Categories</h3>
                                <p class="text-2xl font-bold text-purple-600">Available</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-cog text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">System</h3>
                                <p class="text-2xl font-bold text-indigo-600">Online</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="/admin/articles/create" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <i class="fas fa-plus-circle text-blue-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-800">Create New Article</span>
                        </a>
                        <a href="/admin/categories/create" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <i class="fas fa-tag text-green-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-800">Add Category</span>
                        </a>
                        <a href="/admin/sites/create" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <i class="fas fa-globe-americas text-purple-600 text-xl mr-3"></i>
                            <span class="font-medium text-gray-800">New Site</span>
                        </a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ';
    })->name('dashboard');
    
    // Sites management
    Route::resource('sites', SiteController::class);
    
    // Articles management (with categories as nested resource)
    Route::resource('articles', ArticleController::class);
    Route::resource('articles.categories', CategoryController::class)->except(['show']);
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Pages management
    Route::resource('pages', PageController::class);
    
    // AJAX route for getting categories by site
    Route::get('sites/{site}/categories', [ArticleController::class, 'getCategories'])->name('sites.categories');
});
