@extends('layouts.admin-basic')

@section('title', 'View Site Setting')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $siteSetting->label }}</h1>
            <p class="text-gray-600 mt-2">
                Setting for {{ $siteSetting->site->name }}
                • Created {{ $siteSetting->created_at->format('M j, Y') }}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.site-settings.edit', $siteSetting) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit Setting
            </a>
            <a href="{{ route('admin.site-settings.index', ['site_id' => $siteSetting->site_id]) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Back to Settings
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Setting Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Setting Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Key</dt>
                        <dd class="text-sm text-gray-900 mt-1 font-mono bg-gray-50 px-3 py-2 rounded">{{ $siteSetting->key }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Type</dt>
                        <dd class="text-sm text-gray-900 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($siteSetting->type) }}
                            </span>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Status</dt>
                        <dd class="text-sm text-gray-900 mt-1">
                            @if($siteSetting->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i>Inactive
                                </span>
                            @endif
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Sort Order</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $siteSetting->sort_order }}</dd>
                    </div>
                </div>
            </div>

            <!-- Current Value -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Value</h3>
                
                @if($siteSetting->type === 'boolean')
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $siteSetting->value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas {{ $siteSetting->value ? 'fa-check' : 'fa-times' }} mr-2"></i>
                            {{ $siteSetting->value ? 'True' : 'False' }}
                        </span>
                    </div>
                @elseif($siteSetting->type === 'url')
                    <div class="break-all">
                        <a href="{{ $siteSetting->value }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-800 underline">
                            {{ $siteSetting->value }}
                        </a>
                    </div>
                @elseif($siteSetting->type === 'email')
                    <div class="break-all">
                        <a href="mailto:{{ $siteSetting->value }}" 
                           class="text-blue-600 hover:text-blue-800 underline">
                            {{ $siteSetting->value }}
                        </a>
                    </div>
                @elseif($siteSetting->type === 'textarea')
                    <div class="bg-gray-50 rounded-lg p-4 whitespace-pre-wrap">{{ $siteSetting->value }}</div>
                @else
                    <div class="bg-gray-50 rounded-lg p-4 break-all">{{ $siteSetting->value }}</div>
                @endif
                
                @if(!$siteSetting->value)
                    <div class="text-gray-500 italic">No value set</div>
                @endif
            </div>

            <!-- Description -->
            @if($siteSetting->description)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $siteSetting->description }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.site-settings.edit', $siteSetting) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Edit Setting
                    </a>
                    
                    <!-- Quick Toggle for Boolean -->
                    @if($siteSetting->type === 'boolean')
                    <form action="{{ route('admin.site-settings.update', $siteSetting) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="site_id" value="{{ $siteSetting->site_id }}">
                        <input type="hidden" name="key" value="{{ $siteSetting->key }}">
                        <input type="hidden" name="label" value="{{ $siteSetting->label }}">
                        <input type="hidden" name="type" value="{{ $siteSetting->type }}">
                        <input type="hidden" name="description" value="{{ $siteSetting->description }}">
                        <input type="hidden" name="sort_order" value="{{ $siteSetting->sort_order }}">
                        <input type="hidden" name="is_active" value="{{ $siteSetting->is_active ? 1 : 0 }}">
                        <input type="hidden" name="value" value="{{ $siteSetting->value ? 0 : 1 }}">
                        
                        <button type="submit" 
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                            <i class="fas fa-toggle-{{ $siteSetting->value ? 'off' : 'on' }} mr-2"></i>
                            {{ $siteSetting->value ? 'Disable' : 'Enable' }}
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.site-settings.destroy', $siteSetting) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this setting? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>Delete Setting
                        </button>
                    </form>
                </div>
            </div>

            <!-- Setting Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Setting Information</h3>
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Site</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $siteSetting->site->name }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Created</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $siteSetting->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Last Updated</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $siteSetting->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>
                </div>
            </div>

            <!-- Usage Example -->
            <div class="bg-blue-50 rounded-lg p-6 mt-6">
                <h4 class="text-sm font-medium text-blue-900 mb-2">Usage Example</h4>
                <div class="text-sm text-blue-700">
                    <p class="mb-2">In Blade templates:</p>
                    <code class="bg-blue-100 px-2 py-1 rounded text-xs">
                        {{ '{' }}{{ '{' }} \App\Models\SiteSetting::get('{{ $siteSetting->key }}', {{ $siteSetting->site_id }}) {{ '}' }}{{ '}' }}
                    </code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
