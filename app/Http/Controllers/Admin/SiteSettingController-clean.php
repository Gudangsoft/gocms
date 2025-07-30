<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::with('site')->orderBy('sort_order')->orderBy('label')->get();
        $sites = Site::all();
        $selectedSiteId = 1;

        return view('admin.site-settings.index-clean', compact('settings', 'sites', 'selectedSiteId'));
    }

    public function create()
    {
        $sites = Site::all();
        return view('admin.site-settings.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'type' => 'required|in:text,textarea,select,number,boolean,json',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        SiteSetting::create($validated);

        return redirect()->route('admin.site-settings.index')
                         ->with('success', 'Site setting created successfully.');
    }

    public function show(SiteSetting $siteSetting)
    {
        return view('admin.site-settings.show', compact('siteSetting'));
    }

    public function edit(SiteSetting $siteSetting)
    {
        $sites = Site::all();
        return view('admin.site-settings.edit', compact('siteSetting', 'sites'));
    }

    public function update(Request $request, SiteSetting $siteSetting)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'type' => 'required|in:text,textarea,select,number,boolean,json',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $siteSetting->update($validated);

        return redirect()->route('admin.site-settings.index')
                         ->with('success', 'Site setting updated successfully.');
    }

    public function destroy(SiteSetting $siteSetting)
    {
        $siteSetting->delete();

        return redirect()->route('admin.site-settings.index')
                         ->with('success', 'Site setting deleted successfully.');
    }
}
