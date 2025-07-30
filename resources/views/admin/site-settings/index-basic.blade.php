<!DOCTYPE html>
<html>
<head>
    <title>Site Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white p-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">GO CMS Admin</h1>
            <div class="space-x-4">
                <a href="/admin" class="hover:bg-blue-700 px-3 py-2 rounded">Dashboard</a>
                <a href="/admin/sites" class="hover:bg-blue-700 px-3 py-2 rounded">Sites</a>
                <a href="/admin/site-settings" class="bg-blue-800 px-3 py-2 rounded">Settings</a>
                <a href="/admin/articles" class="hover:bg-blue-700 px-3 py-2 rounded">Articles</a>
                <a href="/admin/categories" class="hover:bg-blue-700 px-3 py-2 rounded">Categories</a>
                <a href="/admin/pages" class="hover:bg-blue-700 px-3 py-2 rounded">Pages</a>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Site Settings</h1>
                <p class="text-gray-600 mt-2">Manage site configuration and customization options</p>
            </div>
            <div>
                <a href="{{ route('admin.site-settings.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                    Add Setting
                </a>
            </div>
        </div>
        
        <!-- Site Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.site-settings.index') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="site_id" class="block text-sm font-medium text-gray-700 mb-2">Filter by Site</label>
                    <select name="site_id" id="site_id" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            onchange="this.form.submit()">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ $selectedSiteId == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search settings..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="pt-6">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Filter
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Settings Table -->
        @if($settings->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Setting</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($settings as $setting)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $setting->label }}</div>
                                        <div class="text-sm text-gray-500 font-mono">{{ $setting->key }}</div>
                                        @if($setting->description)
                                            <div class="text-xs text-gray-400 mt-1">{{ $setting->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($setting->type === 'boolean')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $setting->value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $setting->value ? 'True' : 'False' }}
                                            </span>
                                        @elseif($setting->type === 'url')
                                            <a href="{{ $setting->value }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                {{ Str::limit($setting->value, 30) }}
                                            </a>
                                        @else
                                            <div class="text-sm text-gray-900">{{ Str::limit($setting->value, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($setting->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $setting->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $setting->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.site-settings.show', $setting) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('admin.site-settings.edit', $setting) }}" 
                                               class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.site-settings.destroy', $setting) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white shadow sm:rounded-md p-6">
                <div class="text-center py-12">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No settings found</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first site setting.</p>
                    <a href="{{ route('admin.site-settings.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium">
                        Add Setting
                    </a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
