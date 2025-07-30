<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Navigation Header -->
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
                <a href="/admin" class="hover:underline">
                    <i class="fas fa-tachometer-alt mr-1"></i>
                    Dashboard
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
                <a href="/admin/site-settings" class="hover:underline">
                    <i class="fas fa-cog mr-1"></i>
                    Settings
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        @if(isset($pageTitle) || View::hasSection('page-title'))
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                @yield('page-title', $pageTitle ?? '')
            </h2>
        </div>
        @endif

        <!-- Flash messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
