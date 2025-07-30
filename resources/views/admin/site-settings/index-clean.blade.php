<!DOCTYPE html>
<html>
<head>
    <title>Site Settings - GO CMS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white p-4">
            <div class="container mx-auto">
                <h1 class="text-xl font-bold">GO CMS Admin - Site Settings</h1>
            </div>
        </nav>

        <!-- Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-6">Site Settings Management</h2>
                
                <!-- Actions -->
                <div class="mb-6">
                    <a href="{{ route('admin.site-settings.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        ➕ Add New Setting
                    </a>
                </div>

                <!-- Settings Table -->
                @if($settings && count($settings) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Label</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Key</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Value</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Type</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $setting)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">{{ $setting->id }}</td>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">{{ $setting->label }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <code class="bg-gray-100 px-1 rounded">{{ $setting->key }}</code>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ Str::limit($setting->value, 100) }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $setting->type }}</span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.site-settings.show', $setting) }}" 
                                               class="text-green-600 hover:underline text-sm">View</a>
                                            <a href="{{ route('admin.site-settings.edit', $setting) }}" 
                                               class="text-blue-600 hover:underline text-sm">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded">
                        <p class="font-medium">No settings found</p>
                        <p class="text-sm">Start by creating your first site setting.</p>
                    </div>
                @endif

                <!-- Summary -->
                <div class="mt-8 p-4 bg-blue-50 rounded">
                    <h3 class="font-semibold text-blue-900 mb-2">System Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Total Settings:</span> 
                            <strong>{{ count($settings) }}</strong>
                        </div>
                        <div>
                            <span class="text-blue-700">Sites Available:</span> 
                            <strong>{{ count($sites) }}</strong>
                        </div>
                        <div>
                            <span class="text-blue-700">Current Site ID:</span> 
                            <strong>{{ $selectedSiteId }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
