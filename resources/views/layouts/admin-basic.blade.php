<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Admin') - GO CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">GO CMS Admin</h1>
            <div class="space-x-4">
                <a href="/admin" class="hover:underline">Dashboard</a>
                <a href="/admin/sites" class="hover:underline">Sites</a>
                <a href="/admin/site-settings" class="hover:underline">Settings</a>
                <a href="/admin/articles" class="hover:underline">Articles</a>
                <a href="/admin/categories" class="hover:underline">Categories</a>
                <a href="/admin/pages" class="hover:underline">Pages</a>
            </div>
        </div>
    </nav>
    
    <main class="container mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>
</body>
</html>
