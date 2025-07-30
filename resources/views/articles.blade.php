@extends('layouts.app')

@section('title', 'Artikel - ' . ($currentSite->name ?? 'GO CMS'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Semua Artikel
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Jelajahi koleksi artikel lengkap kami dari berbagai kategori menarik
                </p>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($articles->count() > 0)
            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @foreach($articles as $article)
                <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    @if($article->featured_image)
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        <img src="{{ $article->featured_image }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <!-- Category and Views -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $article->category->name }}
                            </span>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($article->views_count) }}
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">
                            <a href="{{ route('articles.show', $article->slug) }}" 
                               class="hover:text-blue-600 transition duration-200">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($article->excerpt ?: $article->content), 100) }}
                        </p>

                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-sm">
                            <div class="text-gray-500">
                                <div class="font-medium text-gray-700">{{ $article->user->name ?? 'Admin' }}</div>
                                <div>{{ $article->published_at->format('M d, Y') }}</div>
                            </div>
                            <a href="{{ route('articles.show', $article->slug) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Baca →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $articles->links('pagination::tailwind') }}
            </div>

        @else
            <!-- No Articles -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Artikel</h3>
                    <p class="text-gray-600">
                        Saat ini belum ada artikel yang dipublikasikan. Silakan kembali lagi nanti!
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Custom styles for line clamping */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
