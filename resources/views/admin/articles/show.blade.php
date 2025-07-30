@extends('layouts.admin')

@section('title', 'View Article')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $article->title }}</h1>
            <p class="text-gray-600 mt-2">
                Created {{ $article->created_at->format('M j, Y') }} 
                @if($article->published_at)
                    • Published {{ $article->published_at->format('M j, Y') }}
                @endif
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.articles.edit', $article) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit Article
            </a>
            <a href="{{ route('admin.articles.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Back to Articles
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Article Meta -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Status</h3>
                        @if($article->status === 'published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Published
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>Draft
                            </span>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Views</h3>
                        <p class="text-sm text-gray-900">{{ number_format($article->views_count) }} views</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Site</h3>
                        <p class="text-sm text-gray-900">{{ $article->site->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Category</h3>
                        <p class="text-sm text-gray-900">{{ $article->category->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h3>
                <div class="aspect-video rounded-lg overflow-hidden bg-gray-100">
                    <img src="{{ Storage::url($article->featured_image) }}" 
                         alt="{{ $article->title }}"
                         class="w-full h-full object-cover">
                </div>
            </div>
            @endif

            <!-- Excerpt -->
            @if($article->excerpt)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Excerpt</h3>
                <p class="text-gray-700 leading-relaxed">{{ $article->excerpt }}</p>
            </div>
            @endif

            <!-- Content -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Content</h3>
                <div class="prose max-w-none">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Edit Article
                    </a>
                    
                    @if($article->status === 'published')
                        <a href="{{ url('/article/' . $article->slug) }}" 
                           target="_blank"
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-2"></i>View Live
                        </a>
                    @endif
                    
                    <form action="{{ route('admin.articles.destroy', $article) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>Delete Article
                        </button>
                    </form>
                </div>
            </div>

            <!-- Article Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Article Details</h3>
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Slug</dt>
                        <dd class="text-sm text-gray-900 mt-1 font-mono">{{ $article->slug }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Created</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $article->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Last Updated</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $article->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    
                    @if($article->published_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Published</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $article->published_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-700">Author</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $article->user->name }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
