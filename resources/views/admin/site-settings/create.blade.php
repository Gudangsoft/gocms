@extends('layouts.admin-basic')

@section('title', 'Add Site Setting')tends('layouts.admin')

@section('title', 'Create Site Setting')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create Site Setting</h1>
            <p class="text-gray-600 mt-2">Add a new configuration setting for your site</p>
        </div>
        <a href="{{ route('admin.site-settings.index', ['site_id' => $selectedSiteId]) }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to Settings
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.site-settings.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Site Selection -->
                    <div>
                        <label for="site_id" class="block text-sm font-medium text-gray-700 mb-2">Site *</label>
                        <select name="site_id" id="site_id" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select a site</option>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}" {{ old('site_id', $selectedSiteId) == $site->id ? 'selected' : '' }}>
                                    {{ $site->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('site_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Key -->
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700 mb-2">Key *</label>
                        <input type="text" 
                               name="key" 
                               id="key"
                               value="{{ old('key') }}"
                               placeholder="e.g., copyright_text, company_name"
                               required
                               pattern="[a-z0-9_]+"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Use lowercase letters, numbers, and underscores only. Must be unique per site.</p>
                        @error('key')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Label -->
                    <div>
                        <label for="label" class="block text-sm font-medium text-gray-700 mb-2">Label *</label>
                        <input type="text" 
                               name="label" 
                               id="label"
                               value="{{ old('label') }}"
                               placeholder="e.g., Copyright Text, Company Name"
                               required
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Human-readable name for this setting.</p>
                        @error('label')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                        <select name="type" id="type" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="toggleValueField()">
                            <option value="">Select type</option>
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Boolean</option>
                            <option value="date" {{ old('type') == 'date' ? 'selected' : '' }}>Date</option>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL</option>
                            <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Value -->
                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                        
                        <!-- Text Input -->
                        <input type="text" 
                               name="value" 
                               id="value_text"
                               value="{{ old('value') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        
                        <!-- Textarea -->
                        <textarea name="value" 
                                  id="value_textarea"
                                  rows="4"
                                  style="display: none;"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('value') }}</textarea>
                        
                        <!-- Boolean -->
                        <div id="value_boolean" style="display: none;" class="flex items-center">
                            <input type="hidden" name="value" value="0">
                            <input type="checkbox" 
                                   name="value" 
                                   id="value_checkbox"
                                   value="1"
                                   {{ old('value') ? 'checked' : '' }}
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="value_checkbox" class="ml-2 text-sm text-gray-700">Enable this setting</label>
                        </div>
                        
                        @error('value')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" 
                                  id="description"
                                  rows="3"
                                  placeholder="Optional description for this setting"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-6 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Setting Options</h3>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <input type="number" 
                                   name="sort_order" 
                                   id="sort_order"
                                   value="{{ old('sort_order', 0) }}"
                                   min="0"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Lower numbers appear first in lists.</p>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input id="is_active" 
                                           name="is_active" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-gray-700">Active</label>
                                    <p class="text-gray-500">Make this setting available for use</p>
                                </div>
                            </div>
                        </div>

                        <!-- Common Setting Examples -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Common Settings</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div><strong>copyright_text:</strong> © 2025 Company Name</div>
                                <div><strong>company_name:</strong> Your Company</div>
                                <div><strong>footer_text:</strong> Additional footer content</div>
                                <div><strong>contact_email:</strong> info@example.com</div>
                                <div><strong>site_logo:</strong> URL to logo image</div>
                                <div><strong>maintenance_mode:</strong> boolean</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-8">
                <a href="{{ route('admin.site-settings.index', ['site_id' => $selectedSiteId]) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                    <i class="fas fa-save mr-2"></i>Create Setting
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleValueField() {
    const type = document.getElementById('type').value;
    const textInput = document.getElementById('value_text');
    const textareaInput = document.getElementById('value_textarea');
    const booleanInput = document.getElementById('value_boolean');
    
    // Hide all inputs
    textInput.style.display = 'none';
    textInput.disabled = true;
    textareaInput.style.display = 'none';
    textareaInput.disabled = true;
    booleanInput.style.display = 'none';
    
    // Show appropriate input based on type
    if (type === 'textarea') {
        textareaInput.style.display = 'block';
        textareaInput.disabled = false;
    } else if (type === 'boolean') {
        booleanInput.style.display = 'block';
    } else {
        textInput.style.display = 'block';
        textInput.disabled = false;
        
        // Set input type based on selection
        if (type === 'date') {
            textInput.type = 'date';
        } else if (type === 'url') {
            textInput.type = 'url';
        } else if (type === 'email') {
            textInput.type = 'email';
        } else {
            textInput.type = 'text';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleValueField();
});

// Auto-generate key from label
document.getElementById('label').addEventListener('input', function() {
    const keyField = document.getElementById('key');
    if (!keyField.value) {
        keyField.value = this.value.toLowerCase()
                                   .replace(/[^a-z0-9\s]/g, '')
                                   .replace(/\s+/g, '_');
    }
});
</script>
@endsection
