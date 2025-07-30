<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sites' => Site::count(),
            'total_articles' => Article::count(),
            'total_categories' => Category::count(),
            'total_pages' => Page::count(),
            'total_users' => User::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'active_sites' => Site::where('is_active', true)->count(),
        ];

        $recent_articles = Article::with(['site', 'category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $recent_pages = Page::with(['site', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_articles', 'recent_pages'));
    }
}
