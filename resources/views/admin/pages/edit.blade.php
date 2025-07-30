@extends('layouts.admin')

@section('title', 'Edit Page: ' . $page->title)
@section('page-title', 'Edit Page')

@section('content')
<div class="max-w-7xl">
    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Page Content</h3>
                        
                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Page Title</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $page->title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('title') border-red-300 @enderror" 
                                   placeholder="Enter page title">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700">URL Slug</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    /
                                </span>
                                <input type="text" 
                                       name="slug" 
                                       id="slug" 
                                       value="{{ old('slug', $page->slug) }}"
                                       class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('slug') border-red-300 @enderror" 
                                       placeholder="page-url-slug">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <div class="mt-1">
                                <div id="quill-editor" style="height: 400px;" class="rounded-md border-gray-300 @error('content') border-red-300 @enderror"></div>
                                <textarea name="content" 
                                          id="content" 
                                          style="display: none;">{{ old('content', $page->content) }}</textarea>
                            </div>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                            <textarea name="excerpt" 
                                      id="excerpt" 
                                      rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('excerpt') border-red-300 @enderror" 
                                      placeholder="Brief description of the page...">{{ old('excerpt', $page->excerpt) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Used for meta descriptions and previews</p>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">SEO Settings</h3>
                        
                        <!-- Meta Title -->
                        <div class="mb-6">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                            <input type="text" 
                                   name="meta_title" 
                                   id="meta_title" 
                                   value="{{ old('meta_title', $page->meta_title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('meta_title') border-red-300 @enderror" 
                                   placeholder="SEO optimized title">
                            @error('meta_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('meta_description') border-red-300 @enderror" 
                                      placeholder="Description for search engines...">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Options -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Publish</h3>
                        
                        <!-- Site Selection -->
                        <div class="mb-4">
                            <label for="site_id" class="block text-sm font-medium text-gray-700">Site</label>
                            <select name="site_id" 
                                    id="site_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('site_id') border-red-300 @enderror">
                                <option value="">Select a site</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}" {{ old('site_id', $page->site_id) == $site->id ? 'selected' : '' }}>
                                        {{ $site->name }} ({{ $site->domain }})
                                    </option>
                                @endforeach
                            </select>
                            @error('site_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="is_published" 
                                           name="is_published" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_published" class="font-medium text-gray-700">Published</label>
                                    <p class="text-gray-500">Make this page publicly visible</p>
                                </div>
                            </div>
                        </div>

                        <!-- Template -->
                        <div class="mb-6">
                            <label for="template" class="block text-sm font-medium text-gray-700">Template</label>
                            <select name="template" 
                                    id="template" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('template') border-red-300 @enderror">
                                @foreach($templates as $value => $label)
                                    <option value="{{ $value }}" {{ old('template', $page->template) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('template')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-2">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Page
                            </button>
                            <a href="{{ route('admin.pages.show', $page) }}" 
                               class="w-full inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Featured Image</h3>
                        
                        <!-- Current Image Display -->
                        @if($page->featured_image)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                            <div class="relative">
                                <img src="{{ $page->featured_image }}" alt="Current featured image" class="h-32 w-full object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-200 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-sm opacity-0 hover:opacity-100 transition-opacity duration-200">Click tabs below to change</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Image Upload Tabs -->
                        <div class="mb-4">
                            <nav class="flex space-x-4" aria-label="Tabs">
                                <button type="button" id="upload-tab" class="bg-blue-100 text-blue-700 px-3 py-2 font-medium text-sm rounded-md">
                                    Upload File
                                </button>
                                <button type="button" id="url-tab" class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
                                    Enter URL
                                </button>
                            </nav>
                        </div>

                        <!-- File Upload Section -->
                        <div id="upload-section" class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Upload New Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="featured_image_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="featured_image_file" name="featured_image_file" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            <div id="file-preview" class="mt-3 hidden">
                                <img id="preview-image" class="h-32 w-full object-cover rounded-lg" src="" alt="Preview">
                                <p id="file-name" class="mt-2 text-sm text-gray-600"></p>
                            </div>
                            @error('featured_image_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- URL Input Section -->
                        <div id="url-section" class="hidden">
                            <label for="featured_image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                            <input type="url" 
                                   name="featured_image_url" 
                                   id="featured_image_url" 
                                   value="{{ old('featured_image', $page->featured_image) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('featured_image') border-red-300 @enderror" 
                                   placeholder="https://example.com/image.jpg">
                            <p class="mt-1 text-sm text-gray-500">Enter the URL of your featured image</p>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hidden input to store the final image path/URL -->
                        <input type="hidden" name="featured_image" id="featured_image" value="{{ old('featured_image', $page->featured_image) }}">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Quill.js Editor Integration (Free & Modern) -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
// Initialize Quill editor
const quill = new Quill('#quill-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['clean']
        ]
    },
    placeholder: 'Write your page content here...'
});

// Set initial content if available
const initialContent = document.getElementById('content').value;
if (initialContent) {
    quill.root.innerHTML = initialContent;
}

// Update hidden textarea when content changes
quill.on('text-change', function() {
    document.getElementById('content').value = quill.root.innerHTML;
});

// Update hidden textarea before form submission
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('content').value = quill.root.innerHTML;
});

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .trim('-'); // Remove leading/trailing hyphens
    
    if (!document.getElementById('slug').value) {
        document.getElementById('slug').value = slug;
    }
});

// Featured Image Tabs and File Upload
const uploadTab = document.getElementById('upload-tab');
const urlTab = document.getElementById('url-tab');
const uploadSection = document.getElementById('upload-section');
const urlSection = document.getElementById('url-section');
const fileInput = document.getElementById('featured_image_file');
const urlInput = document.getElementById('featured_image_url');
const hiddenInput = document.getElementById('featured_image');
const filePreview = document.getElementById('file-preview');
const previewImage = document.getElementById('preview-image');
const fileName = document.getElementById('file-name');

// Tab switching
uploadTab.addEventListener('click', function() {
    uploadTab.classList.add('bg-blue-100', 'text-blue-700');
    uploadTab.classList.remove('text-gray-500', 'hover:text-gray-700');
    urlTab.classList.remove('bg-blue-100', 'text-blue-700');
    urlTab.classList.add('text-gray-500', 'hover:text-gray-700');
    
    uploadSection.classList.remove('hidden');
    urlSection.classList.add('hidden');
    
    // Clear URL input when switching to upload
    urlInput.value = '';
});

urlTab.addEventListener('click', function() {
    urlTab.classList.add('bg-blue-100', 'text-blue-700');
    urlTab.classList.remove('text-gray-500', 'hover:text-gray-700');
    uploadTab.classList.remove('bg-blue-100', 'text-blue-700');
    uploadTab.classList.add('text-gray-500', 'hover:text-gray-700');
    
    urlSection.classList.remove('hidden');
    uploadSection.classList.add('hidden');
    
    // Clear file input when switching to URL
    fileInput.value = '';
    filePreview.classList.add('hidden');
});

// File upload preview
fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            fileName.textContent = file.name;
            filePreview.classList.remove('hidden');
            
            // Set the hidden input value (you might want to handle actual file upload here)
            hiddenInput.value = 'uploaded:' + file.name; // Placeholder - implement actual upload
        };
        reader.readAsDataURL(file);
    } else {
        filePreview.classList.add('hidden');
        hiddenInput.value = '';
    }
});

// URL input handler
urlInput.addEventListener('input', function() {
    hiddenInput.value = this.value;
});
</script>
@endsection
