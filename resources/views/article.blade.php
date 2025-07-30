@extends('layouts.app')

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: Str::limit(strip_tags($article->excerpt ?: $article->content), 160))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Article Header -->
    <div class="bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('articles.index') }}" class="hover:text-blue-600">Artikel</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900">{{ $article->title }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Article Meta -->
            <div class="mb-6">
                <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                        {{ $article->category->name }}
                    </span>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $article->published_at->format('d F Y') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($article->views_count) }} views
                    </div>
                    @if($article->user)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $article->user->name }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Article Title -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            <!-- Article Excerpt -->
            @if($article->excerpt)
            <div class="text-xl text-gray-600 mb-8 leading-relaxed">
                {{ $article->excerpt }}
            </div>
            @endif
        </div>
    </div>

    <!-- Article Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <article class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <!-- Featured Image -->
            @if($article->featured_image)
            <div class="mb-8">
                <img src="{{ $article->featured_image }}" 
                     alt="{{ $article->title }}"
                     class="w-full h-auto rounded-lg shadow-md">
            </div>
            @endif

            <!-- Article Content -->
            <div class="prose prose-lg max-w-none">
                {!! $article->content !!}
            </div>

            <!-- Article Tags/Categories -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">Kategori:</span>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                        {{ $article->category->name }}
                    </span>
                </div>
            </div>
        </article>

        <!-- Related Articles -->
        @if($relatedArticles->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($relatedArticles as $related)
                <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                    @if($related->featured_image)
                    <div class="h-40 bg-gray-200 overflow-hidden">
                        <img src="{{ $related->featured_image }}" 
                             alt="{{ $related->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                {{ $related->category->name }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $related->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('articles.show', $related->slug) }}" 
                               class="hover:text-blue-600 transition duration-200">
                                {{ $related->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                            {{ Str::limit(strip_tags($related->excerpt ?: $related->content), 100) }}
                        </p>
                        
                        <a href="{{ route('articles.show', $related->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <div class="flex justify-between items-center">
            <a href="{{ route('articles.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200">
                ← Kembali ke Artikel
            </a>
            
            <div class="flex gap-2">
                <!-- Share buttons could go here -->
                <button class="bg-blue-100 hover:bg-blue-200 text-blue-800 p-2 rounded-lg transition duration-200" title="Share">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Prose styles for article content */
.prose {
    color: #374151;
    max-width: none;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #111827;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose h1 { font-size: 2.25rem; }
.prose h2 { font-size: 1.875rem; }
.prose h3 { font-size: 1.5rem; }
.prose h4 { font-size: 1.25rem; }

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.75;
}

.prose ul, .prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose blockquote {
    border-left: 4px solid #3B82F6;
    padding-left: 1rem;
    font-style: italic;
    color: #6B7280;
    margin: 1.5rem 0;
}

.prose a {
    color: #3B82F6;
    text-decoration: underline;
}

.prose a:hover {
    color: #1D4ED8;
}

.prose img {
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.prose code {
    background-color: #F3F4F6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.prose pre {
    background-color: #1F2937;
    color: #F9FAFB;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
