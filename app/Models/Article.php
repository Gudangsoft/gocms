<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'site_id',
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'gallery',
        'meta_data',
        'meta_title',
        'meta_description',
        'status',
        'is_featured',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'gallery' => 'array',
        'meta_data' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Virtual attribute for is_published (maps to status field)
    protected $appends = ['is_published'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForSite($query, $siteId)
    {
        return $query->where('site_id', $siteId);
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return Str::limit(strip_tags($this->content), 150);
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
