<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Site;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get the current site (you can modify this logic based on your multi-site setup)
        $currentSite = Site::where('is_active', true)->first();
        
        // Get popular articles (published articles ordered by views)
        $popularArticles = Article::published()
            ->where('site_id', $currentSite->id ?? 1)
            ->orderBy('views_count', 'desc')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->with(['category', 'site'])
            ->get();

        return view('home', compact('popularArticles', 'currentSite'));
    }

    public function articles(Request $request)
    {
        // Get the current site
        $currentSite = Site::where('is_active', true)->first();
        
        // Get all published articles with pagination
        $articles = Article::published()
            ->where('site_id', $currentSite->id ?? 1)
            ->orderBy('published_at', 'desc')
            ->with(['category', 'site', 'user'])
            ->paginate(12); // 12 articles per page

        return view('articles', compact('articles', 'currentSite'));
    }

    public function show($slug)
    {
        // Get the current site
        $currentSite = Site::where('is_active', true)->first();
        
        // Find article by slug
        $article = Article::published()
            ->where('site_id', $currentSite->id ?? 1)
            ->where('slug', $slug)
            ->with(['category', 'site', 'user'])
            ->firstOrFail();

        // Increment views count
        $article->increment('views_count');

        // Get related articles
        $relatedArticles = Article::published()
            ->where('site_id', $currentSite->id ?? 1)
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->with(['category'])
            ->get();

        return view('article', compact('article', 'relatedArticles', 'currentSite'));
    }
}
