<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GO CMS - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-blue-600">GO CMS</div>
                <div class="space-x-4">
                    <a href="/admin" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-cog mr-1"></i>Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">
                <span class="text-blue-600">GO</span> CMS
            </h1>
            <p class="text-xl text-gray-600 mb-8">Modern Multi-Site Content Management System</p>
            <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
        </div>

        <!-- Latest Articles Section -->
        @if(isset($articles) && $articles->count() > 0)
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Latest Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                    @if($article->featured_image)
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-4xl"></i>
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $article->category->name ?? 'Uncategorized' }}
                            </span>
                            <span class="text-gray-500 text-sm ml-2">
                                {{ $article->site->name ?? 'Main Site' }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600 transition">
                            {{ $article->title }}
                        </h3>
                        
                        <p class="text-gray-600 mb-4">
                            {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                            </span>
                            <a href="/articles/{{ $article->slug }}" class="text-blue-600 font-medium hover:text-blue-800">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-center py-16">
            <div class="text-gray-400 text-6xl mb-4">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No articles yet</h3>
            <p class="text-gray-500 mb-6">Start by creating your first article in the admin panel</p>
            <a href="/admin" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>
                Go to Admin
            </a>
        </div>
        @endif

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

        <!-- Action Buttons -->
        <div class="text-center">
            <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
                <a href="/admin" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Admin Dashboard
                </a>
                <a href="/admin/articles" class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-300 shadow-lg">
                    <i class="fas fa-newspaper mr-2"></i>
                    Manage Articles
                </a>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-16 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">System Status</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ \App\Models\Site::count() }}</div>
                    <div class="text-gray-600 mt-2">Sites</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ \App\Models\Article::where('status', 'published')->count() }}</div>
                    <div class="text-gray-600 mt-2">Published Articles</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ \App\Models\Category::count() }}</div>
                    <div class="text-gray-600 mt-2">Categories</div>
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
            <p>&copy; 2025 GO CMS. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
