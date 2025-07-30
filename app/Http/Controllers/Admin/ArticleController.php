<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Site;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['site', 'category', 'user']);
        
        // Filter by status
        if ($request->has('status') && in_array($request->status, ['draft', 'published'])) {
            $query->where('status', $request->status);
        }
        
        // Filter by site
        if ($request->has('site_id') && $request->site_id) {
            $query->where('site_id', $request->site_id);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        
        $articles = $query->latest()->paginate(15);
        $sites = Site::where('is_active', true)->get();
        
        return view('admin.articles.index', compact('articles', 'sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sites = Site::where('is_active', true)->get();
        $selectedSiteId = $request->get('site_id');
        
        // Get categories for selected site, or empty collection if no site selected
        $categories = $selectedSiteId 
            ? Category::where('site_id', $selectedSiteId)->get() 
            : collect();

        return view('admin.articles.create', compact('sites', 'categories', 'selectedSiteId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-]*$/',
                Rule::unique('articles')->where(function ($query) use ($request) {
                    return $query->where('site_id', $request->site_id);
                })
            ],
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:300',
            'featured_image' => 'nullable|url|max:500',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'site_id' => 'required|exists:sites,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filename);
            $validated['featured_image'] = '/uploads/images/' . $filename;
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug uniqueness within site
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (Article::where('site_id', $validated['site_id'])
                      ->where('slug', $validated['slug'])
                      ->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Set published_at if publishing
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }
        
        // Add current user as author
        $validated['user_id'] = auth()->id();
        
        // Remove the file input from validated data since it's not a model field
        unset($validated['featured_image_file']);

        $article = Article::create($validated);

        return redirect()
            ->route('admin.articles.show', $article)
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['site', 'category', 'user']);
        
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $sites = Site::where('is_active', true)->get();
        $categories = Category::where('site_id', $article->site_id)->get();
        
        $article->load(['site', 'category']);

        return view('admin.articles.edit', compact('article', 'sites', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-]*$/',
                Rule::unique('articles')->where(function ($query) use ($request) {
                    return $query->where('site_id', $request->site_id);
                })->ignore($article->id)
            ],
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:500',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'site_id' => 'required|exists:sites,id',
            'category_id' => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('featured_image_file')) {
            // Delete old image if it exists and is a local file
            if ($article->featured_image && str_starts_with($article->featured_image, '/uploads/')) {
                $oldImagePath = public_path($article->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filename);
            $validated['featured_image'] = '/uploads/images/' . $filename;
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug uniqueness within site (excluding current article)
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (Article::where('site_id', $validated['site_id'])
                      ->where('slug', $validated['slug'])
                      ->where('id', '!=', $article->id)
                      ->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['is_published'] = $request->boolean('is_published');
        
        // Handle status based on is_published
        $validated['status'] = $validated['is_published'] ? 'published' : 'draft';
        
        // Set published_at if publishing for the first time
        if ($validated['is_published'] && !$article->published_at && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            // If unpublishing, clear published_at if no specific date is set
            if (empty($validated['published_at'])) {
                $validated['published_at'] = null;
            }
        }

        // Remove the virtual is_published from validated data since it's not a database field
        unset($validated['is_published']);
        
        // Remove the file input from validated data since it's not a model field
        unset($validated['featured_image_file']);

        $article->update($validated);

        return redirect()
            ->route('admin.articles.show', $article)
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Get categories for a specific site (AJAX endpoint)
     */
    public function getCategories(Site $site)
    {
        $categories = $site->categories()->get(['id', 'name']);
        
        return response()->json($categories);
    }
}
