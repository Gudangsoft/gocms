<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'subdomain',
        'description',
        'logo',
        'favicon',
        'settings',
        'theme_settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'theme_settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function getFullDomainAttribute(): string
    {
        if ($this->subdomain) {
            return $this->subdomain . '.' . $this->domain;
        }
        return $this->domain;
    }
}
