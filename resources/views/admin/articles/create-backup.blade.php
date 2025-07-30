@extends('layouts.admin')

@section('title', 'Create New Article')
@section('page-title', 'Create New Article')

@section('content')
<div class="max-w-7xl">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Article Content</h3>
                        
                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Article Title</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('title') border-red-300 @enderror" 
                                   placeholder="Enter article title">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700">URL Slug</label>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   value="{{ old('slug') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('slug') border-red-300 @enderror" 
                                   placeholder="article-url-slug">
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-6">
                            <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                            <textarea name="excerpt" 
                                      id="excerpt" 
                                      rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('excerpt') border-red-300 @enderror" 
                                      placeholder="Brief description of the article">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <div id="quill-editor" style="height: 300px;"></div>
                            <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Publish Settings</h3>
                        
                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('status') border-red-300 @enderror">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site -->
                        <div class="mb-4">
                            <label for="site_id" class="block text-sm font-medium text-gray-700">Site</label>
                            <select name="site_id" id="site_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('site_id') border-red-300 @enderror">
                                <option value="">Select Site</option>
                                @foreach(\App\Models\Site::all() as $site)
                                    <option value="{{ $site->id }}" {{ old('site_id', $selectedSiteId) == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                                @endforeach
                            </select>
                            @error('site_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('category_id') border-red-300 @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Featured -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured" 
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    Featured Article
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Featured Image</h3>
                        
                        <div class="mb-4">
                            <label for="featured_image_file" class="block text-sm font-medium text-gray-700">Upload Image</label>
                            <input type="file" 
                                   name="featured_image_file" 
                                   id="featured_image_file" 
                                   accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="text-center text-gray-500 text-sm mb-4">OR</div>

                        <div class="mb-4">
                            <label for="featured_image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                            <input type="url" 
                                   name="featured_image_url" 
                                   id="featured_image_url" 
                                   value="{{ old('featured_image') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                   placeholder="https://example.com/image.jpg">
                        </div>

                        <div id="image_preview" class="hidden">
                            <img id="preview_img" src="" alt="Preview" class="w-full h-32 object-cover rounded">
                        </div>

                        <input type="hidden" name="featured_image" id="featured_image" value="{{ old('featured_image') }}">
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex flex-col space-y-3">
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i>
                                Create Article
                            </button>
                            <a href="{{ route('admin.articles.index') }}" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<!-- Quill.js Editor Integration -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
// Initialize Quill editor
const quill = new Quill('#quill-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean']
        ]
    },
    placeholder: 'Write your article content here...'
});

// Set initial content if available
const existingContent = document.getElementById('content').value;
if (existingContent) {
    quill.root.innerHTML = existingContent;
}

// Update hidden textarea on form submit
quill.on('text-change', function() {
    document.getElementById('content').value = quill.root.innerHTML;
});

// Generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
});

// Image preview handling
const fileInput = document.getElementById('featured_image_file');
const urlInput = document.getElementById('featured_image_url');
const hiddenInput = document.getElementById('featured_image');
const preview = document.getElementById('image_preview');
const previewImg = document.getElementById('preview_img');

// File input handler
fileInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            hiddenInput.value = e.target.result;
            urlInput.value = '';
        };
        reader.readAsDataURL(file);
    }
});

// URL input handler
urlInput.addEventListener('input', function() {
    const url = this.value;
    if (url) {
        previewImg.src = url;
        preview.classList.remove('hidden');
        hiddenInput.value = url;
        fileInput.value = '';
    } else {
        preview.classList.add('hidden');
        hiddenInput.value = '';
    }
});
</script>
@endpush
@endsection
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
                                       value="{{ old('slug') }}"
                                       class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('slug') border-red-300 @enderror" 
                                       placeholder="article-url-slug">
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
                                          style="display: none;">{{ old('content') }}</textarea>
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
                                      placeholder="Brief summary of the article...">{{ old('excerpt') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Used for article previews and meta descriptions</p>
                            @error('excerpt')
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
                                    <option value="{{ $site->id }}" {{ old('site_id', $selectedSiteId) == $site->id ? 'selected' : '' }}>
                                        {{ $site->name }} ({{ $site->domain }})
                                    </option>
                                @endforeach
                            </select>
                            @error('site_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Selection -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id" 
                                    id="category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('category_id') border-red-300 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Published Date -->
                        <div class="mb-4">
                            <label for="published_at" class="block text-sm font-medium text-gray-700">Publish Date</label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   id="published_at" 
                                   value="{{ old('published_at') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('published_at') border-red-300 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to publish immediately</p>
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <!-- Hidden field to ensure is_published is always sent -->
                                    <input type="hidden" name="is_published" value="0">
                                    <input id="is_published" 
                                           name="is_published" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_published', '1') ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_published" class="font-medium text-gray-700">Published</label>
                                    <p class="text-gray-500">Make this article publicly visible</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-2">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Create Article
                            </button>
                            <a href="{{ route('admin.articles.index') }}" 
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
                            <label class="block text-sm font-medium text-gray-700">Upload Image File</label>
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
                                   value="{{ old('featured_image') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('featured_image') border-red-300 @enderror" 
                                   placeholder="https://example.com/image.jpg">
                            <p class="mt-1 text-sm text-gray-500">Enter the URL of your featured image</p>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hidden input to store the final image path/URL -->
                        <input type="hidden" name="featured_image" id="featured_image" value="{{ old('featured_image') }}">
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
    placeholder: 'Write your article content here...'
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

// Dynamic category loading based on site selection
document.getElementById('site_id').addEventListener('change', function() {
    const siteId = this.value;
    const categorySelect = document.getElementById('category_id');
    
    // Clear existing options
    categorySelect.innerHTML = '<option value="">Select a category</option>';
    
    if (siteId) {
        fetch(`/admin/sites/${siteId}/categories`)
            .then(response => response.json())
            .then(categories => {
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading categories:', error);
            });
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

// Dynamic category loading based on selected site
document.getElementById('site_id').addEventListener('change', function() {
    const siteId = this.value;
    const categorySelect = document.getElementById('category_id');
    
    // Clear current categories
    categorySelect.innerHTML = '<option value="">Loading categories...</option>';
    
    if (siteId) {
        // Fetch categories for selected site
        fetch(`/admin/sites/${siteId}/categories`)
            .then(response => response.json())
            .then(categories => {
                categorySelect.innerHTML = '<option value="">Select Category</option>';
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading categories:', error);
                categorySelect.innerHTML = '<option value="">Error loading categories</option>';
            });
    } else {
        categorySelect.innerHTML = '<option value="">Select Site first</option>';
    }
});
</script>
@endsection
