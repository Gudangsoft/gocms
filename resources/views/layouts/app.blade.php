<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name'))</title>
    
    @hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'],
                    },
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        GO CMS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition duration-200 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('articles.index') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition duration-200 {{ request()->routeIs('articles.*') ? 'text-blue-600' : '' }}">
                        Artikel
                    </a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition duration-200">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" 
                            class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600" 
                            x-data="{ open: false }" 
                            @click="open = !open">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-bold mb-4">{{ \App\Models\SiteSetting::get('company_name', 1, 'GO CMS') }}</h3>
                    <p class="text-gray-300 mb-4">
                        {{ \App\Models\SiteSetting::get('footer_text', 1, 'Sistem manajemen konten modern untuk mengelola multiple website dengan mudah dan efisien.') }}
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-200">Beranda</a></li>
                        <li><a href="{{ route('articles.index') }}" class="text-gray-300 hover:text-white transition duration-200">Artikel</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Admin</h4>
                    <ul class="space-y-2">
                        @auth
                            <li><a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition duration-200">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition duration-200">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition duration-200">Register</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">{{ \App\Models\SiteSetting::get('copyright_text', 1, '© ' . date('Y') . ' GO CMS. All rights reserved.') }}</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
