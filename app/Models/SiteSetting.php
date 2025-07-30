<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_id',
        'key',
        'value',
        'type',
        'label',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForSite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }

    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    // Helper method to get setting value by key for a site
    public static function get($key, $siteId = null, $default = null)
    {
        if (!$siteId) {
            $siteId = 1; // Default site
        }

        $setting = static::where('site_id', $siteId)
                         ->where('key', $key)
                         ->where('is_active', true)
                         ->first();

        return $setting ? $setting->value : $default;
    }

    // Helper method to set setting value
    public static function set($key, $value, $siteId = null)
    {
        if (!$siteId) {
            $siteId = 1; // Default site
        }

        return static::updateOrCreate(
            ['site_id' => $siteId, 'key' => $key],
            ['value' => $value]
        );
    }
}
