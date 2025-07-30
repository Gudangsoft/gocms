<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::withCount(['articles', 'pages', 'categories'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('admin.sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'domain' => 'required|unique:sites,domain',
            'subdomain' => 'nullable|unique:sites,subdomain',
            'description' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048', // 2MB max
        ]);

        $logoPath = null;
        $faviconPath = null;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Handle favicon upload (if provided)
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
        }

        Site::create([
            'name' => $request->name,
            'domain' => $request->domain,
            'subdomain' => $request->subdomain,
            'description' => $request->description,
            'logo' => $logoPath,
            'favicon' => $faviconPath,
            'settings' => [
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ],
            'theme_settings' => [
                'primary_color' => $request->primary_color ?? '#3B82F6',
                'secondary_color' => $request->secondary_color ?? '#10B981',
                'font_family' => $request->font_family ?? 'Inter',
            ],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sites.index')
                        ->with('success', 'Site created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        $site->loadCount(['articles', 'pages', 'categories']);
        $recentArticles = $site->articles()->latest()->take(5)->get();
        $recentPages = $site->pages()->latest()->take(5)->get();
        
        return view('admin.sites.show', compact('site', 'recentArticles', 'recentPages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('admin.sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $request->validate([
            'name' => 'required|max:255',
            'domain' => 'required|unique:sites,domain,' . $site->id,
            'subdomain' => 'nullable|unique:sites,subdomain,' . $site->id,
            'description' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048', // 2MB max
        ]);

        $logoPath = $site->logo;
        $faviconPath = $site->favicon;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($site->logo && \Storage::disk('public')->exists($site->logo)) {
                \Storage::disk('public')->delete($site->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($site->favicon && \Storage::disk('public')->exists($site->favicon)) {
                \Storage::disk('public')->delete($site->favicon);
            }
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
        }

        $site->update([
            'name' => $request->name,
            'domain' => $request->domain,
            'subdomain' => $request->subdomain,
            'description' => $request->description,
            'logo' => $logoPath,
            'favicon' => $faviconPath,
            'settings' => [
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ],
            'theme_settings' => [
                'primary_color' => $request->primary_color ?? '#3B82F6',
                'secondary_color' => $request->secondary_color ?? '#10B981',
                'font_family' => $request->font_family ?? 'Inter',
            ],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.sites.index')
                        ->with('success', 'Site updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        
        return redirect()->route('admin.sites.index')
                        ->with('success', 'Site deleted successfully.');
    }
}
