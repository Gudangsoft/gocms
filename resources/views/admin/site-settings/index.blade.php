<!DOCTYPE html>
<html>
<head>
    <title>Site Settings - GO CMS</title>
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

    <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Site Settings</h1>
            <p class="text-gray-600 mt-2">Manage site configuration and customization options</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.site-settings.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                <i class="fas fa-plus mr-2"></i>Add Setting
            </a>
        </div>
    </div>

    <!-- Site Filter -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
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
        </form>
    </div>

    <!-- Settings List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($settings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Key / Label
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Value
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Site
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($settings as $setting)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $setting->label }}</div>
                                        <div class="text-sm text-gray-500 font-mono">{{ $setting->key }}</div>
                                        @if($setting->description)
                                            <div class="text-xs text-gray-400 mt-1">{{ $setting->description }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        @if($setting->type === 'boolean')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $setting->value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $setting->value ? 'True' : 'False' }}
                                            </span>
                                        @elseif($setting->type === 'url')
                                            <a href="{{ $setting->value }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                {{ Str::limit($setting->value, 30) }}
                                            </a>
                                        @else
                                            {{ Str::limit($setting->value, 50) }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($setting->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $setting->site->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($setting->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-pause-circle mr-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.site-settings.show', $setting) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.site-settings.edit', $setting) }}" 
                                           class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.site-settings.destroy', $setting) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this setting?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $settings->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fas fa-cog text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Settings Found</h3>
                <p class="text-gray-500 mb-6">
                    @if($selectedSiteId)
                        No settings found for the selected site.
                    @else
                        Get started by creating your first site setting.
                    @endif
                </p>
                <a href="{{ route('admin.site-settings.create', ['site_id' => $selectedSiteId]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Add First Setting
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Settings Panel for Common Settings -->
    @if($selectedSiteId)
    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Settings</h3>
            <p class="text-sm text-gray-500">Common settings for quick editing</p>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.site-settings.quick-update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="site_id" value="{{ $selectedSiteId }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="copyright_text" class="block text-sm font-medium text-gray-700 mb-1">Copyright Text</label>
                        <input type="text" 
                               name="settings[0][value]" 
                               value="{{ \App\Models\SiteSetting::get('copyright_text', $selectedSiteId, '© 2025 GO CMS. All rights reserved.') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <input type="hidden" name="settings[0][key]" value="copyright_text">
                    </div>
                    
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input type="text" 
                               name="settings[1][value]" 
                               value="{{ \App\Models\SiteSetting::get('company_name', $selectedSiteId, 'GO CMS') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <input type="hidden" name="settings[1][key]" value="company_name">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="footer_text" class="block text-sm font-medium text-gray-700 mb-1">Footer Text</label>
                        <textarea name="settings[2][value]" 
                                  rows="3"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ \App\Models\SiteSetting::get('footer_text', $selectedSiteId, 'Powered by GO CMS - Multi-Site Content Management System') }}</textarea>
                        <input type="hidden" name="settings[2][key]" value="footer_text">
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update Quick Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
</body>
</html>
