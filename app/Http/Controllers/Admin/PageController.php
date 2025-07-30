<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::with('site')
            ->latest()
            ->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sites = Site::where('is_active', true)->get();
        $selectedSiteId = $request->get('site_id');
        
        $templates = [
            'default' => 'Default Template',
            'about' => 'About Page',
            'contact' => 'Contact Page',
            'services' => 'Services Page',
            'portfolio' => 'Portfolio Page',
            'landing' => 'Landing Page'
        ];

        return view('admin.pages.create', compact('sites', 'selectedSiteId', 'templates'));
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
                Rule::unique('pages')->where(function ($query) use ($request) {
                    return $query->where('site_id', $request->site_id);
                })
            ],
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:300',
            'featured_image' => 'nullable|url|max:500',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'template' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'site_id' => 'required|exists:sites,id',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store the file in public/uploads/images
            $file->move(public_path('uploads/images'), $filename);
            $validated['featured_image'] = asset('uploads/images/' . $filename);
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug uniqueness within site
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (Page::where('site_id', $validated['site_id'])
                   ->where('slug', $validated['slug'])
                   ->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['is_published'] = $request->boolean('is_published');
        
        // Handle status based on is_published
        $validated['status'] = $validated['is_published'] ? 'published' : 'draft';
        
        // Set published_at if publishing
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remove the virtual is_published from validated data since it's not a database field
        unset($validated['is_published']);

        // Remove featured_image_file from validated data
        unset($validated['featured_image_file']);

        $page = Page::create($validated);

        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load('site');
        
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $sites = Site::where('is_active', true)->get();
        
        $templates = [
            'default' => 'Default Template',
            'about' => 'About Page',
            'contact' => 'Contact Page',
            'services' => 'Services Page',
            'portfolio' => 'Portfolio Page',
            'landing' => 'Landing Page'
        ];

        $page->load('site');

        return view('admin.pages.edit', compact('page', 'sites', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-]*$/',
                Rule::unique('pages')->where(function ($query) use ($request) {
                    return $query->where('site_id', $request->site_id);
                })->ignore($page->id)
            ],
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:300',
            'featured_image' => 'nullable|url|max:500',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'template' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'site_id' => 'required|exists:sites,id',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image_file')) {
            // Delete old image if it exists and is not a URL
            if ($page->featured_image && !filter_var($page->featured_image, FILTER_VALIDATE_URL)) {
                $oldImagePath = str_replace(asset(''), '', $page->featured_image);
                if (file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            } elseif ($page->featured_image && str_contains($page->featured_image, 'uploads/images/')) {
                $oldImageName = basename($page->featured_image);
                if (file_exists(public_path('uploads/images/' . $oldImageName))) {
                    unlink(public_path('uploads/images/' . $oldImageName));
                }
            }

            $file = $request->file('featured_image_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store the file in public/uploads/images
            $file->move(public_path('uploads/images'), $filename);
            $validated['featured_image'] = asset('uploads/images/' . $filename);
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug uniqueness within site (excluding current page)
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (Page::where('site_id', $validated['site_id'])
                   ->where('slug', $validated['slug'])
                   ->where('id', '!=', $page->id)
                   ->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['is_published'] = $request->boolean('is_published');
        
        // Handle status based on is_published
        $validated['status'] = $validated['is_published'] ? 'published' : 'draft';
        
        // Set published_at if publishing for the first time
        if ($validated['is_published'] && !$page->published_at && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remove the virtual is_published from validated data since it's not a database field
        unset($validated['is_published']);

        // Remove featured_image_file from validated data
        unset($validated['featured_image_file']);

        $page->update($validated);

        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
