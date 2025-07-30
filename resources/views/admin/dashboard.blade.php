@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600">Welcome back! Here's what's happening with your CMS.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <i class="fas fa-globe text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Sites</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_sites'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
                <i class="fas fa-newspaper text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Published Articles</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['published_articles'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100">
                <i class="fas fa-edit text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Draft Articles</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['draft_articles'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100">
                <i class="fas fa-tags text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Categories</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Articles -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Articles</h2>
        </div>
        <div class="p-6">
            @if($recentArticles->count() > 0)
                <div class="space-y-4">
                    @foreach($recentArticles as $article)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $article->title }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $article->category->name ?? 'Uncategorized' }} • {{ $article->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No articles found.</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('admin.articles.create') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg hover:from-blue-100 hover:to-indigo-100 transition-all duration-200 group">
                    <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-plus text-blue-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Create New Article</p>
                        <p class="text-sm text-gray-500">Write and publish new content</p>
                    </div>
                </a>

                <a href="{{ route('admin.categories.create') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg hover:from-green-100 hover:to-emerald-100 transition-all duration-200 group">
                    <div class="p-2 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-tag text-green-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Add Category</p>
                        <p class="text-sm text-gray-500">Organize your content better</p>
                    </div>
                </a>

                <a href="{{ route('admin.sites.create') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg hover:from-purple-100 hover:to-pink-100 transition-all duration-200 group">
                    <div class="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                        <i class="fas fa-globe-americas text-purple-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Create New Site</p>
                        <p class="text-sm text-gray-500">Expand your multi-site network</p>
                    </div>
                </a>

                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg hover:from-gray-100 hover:to-slate-100 transition-all duration-200 group">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-gray-200 transition-colors">
                        <i class="fas fa-list text-gray-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Manage All Articles</p>
                        <p class="text-sm text-gray-500">View, edit, and organize content</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
