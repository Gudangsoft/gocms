<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'site_id',
        'user_id',
        'title',
        'slug',
        'content',
        'template',
        'page_settings',
        'meta_title',
        'meta_description',
        'status',
        'is_homepage',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'page_settings' => 'array',
        'is_homepage' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Virtual attribute for is_published (maps to status field)
    protected $appends = ['is_published'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeForSite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }

    // Accessor for is_published (virtual attribute)
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published';
    }

    // Mutator for is_published (virtual attribute)
    public function setIsPublishedAttribute($value)
    {
        $this->attributes['status'] = $value ? 'published' : 'draft';
        
        // Set published_at when publishing
        if ($value && !$this->published_at) {
            $this->attributes['published_at'] = now();
        }
    }
}
