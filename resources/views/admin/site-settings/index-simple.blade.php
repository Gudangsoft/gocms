<!DOCTYPE html>
<html>
<head>
    <title>Site Settings - Simple</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold text-blue-600 mb-6">Site Settings - BERHASIL!</h1>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Data Settings:</h2>
        
        @if($settings && count($settings) > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Label</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Key</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Value</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $setting)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $setting->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $setting->label }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $setting->key }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ Str::limit($setting->value, 50) }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ route('admin.site-settings.edit', $setting) }}" 
                                   class="text-blue-600 hover:underline mr-2">Edit</a>
                                <a href="{{ route('admin.site-settings.show', $setting) }}" 
                                   class="text-green-600 hover:underline">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                Tidak ada data settings ditemukan.
            </div>
        @endif
        
        <div class="mt-6">
            <a href="{{ route('admin.site-settings.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Tambah Setting Baru
            </a>
        </div>
    </div>
    
    <div class="mt-8 p-4 bg-green-100 border border-green-400 rounded">
        <h3 class="font-semibold text-green-800">Status:</h3>
        <ul class="text-green-700 mt-2">
            <li>✅ View file berhasil dimuat</li>
            <li>✅ Data settings: {{ count($settings ?? []) }} items</li>
            <li>✅ Sites: {{ count($sites ?? []) }} items</li>
            <li>✅ Selected Site ID: {{ $selectedSiteId ?? 'undefined' }}</li>
        </ul>
    </div>
</body>
</html>
