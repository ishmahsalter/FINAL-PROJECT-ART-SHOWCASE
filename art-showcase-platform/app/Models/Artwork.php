<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Artwork extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'challenge_id',
        'title',
        'slug',
        'description',
        'media_used',
        'image_path',
        'image_url',
        'thumbnail_url',
        'tags',
        'views',
        'views_count',
        'like_count',
        'favorite_count',
        'comment_count',
        'report_count',
        'likes_count',
        'favorites_count',
        'comments_count',
        'visibility',
        'status',
        'is_featured',
        'is_approved',
        'published_at',
        'additional_images', // Tambahkan ini
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
        'views_count' => 'integer',
        'like_count' => 'integer',
        'favorite_count' => 'integer',
        'comment_count' => 'integer',
        'report_count' => 'integer',
        'likes_count' => 'integer',
        'favorites_count' => 'integer',
        'comments_count' => 'integer',
        'additional_images' => 'array', // Tambahkan casting untuk additional_images
    ];

    protected $appends = [
        'full_image_url', 
        'full_thumbnail_url',
        'additional_images_urls' // Tambahkan accessor ini
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Accessor untuk full image URL
     */
    public function getFullImageUrlAttribute()
    {
        // Priority 1: Gunakan image_url dari database jika ada
        if (!empty($this->image_url)) {
            return $this->image_url;
        }
        
        // Priority 2: Generate dari image_path
        if (!empty($this->image_path)) {
            return Storage::url($this->image_path);
        }
        
        return null;
    }

    /**
     * Accessor untuk full thumbnail URL
     */
    public function getFullThumbnailUrlAttribute()
    {
        // Priority 1: Gunakan thumbnail_url dari database jika ada
        if (!empty($this->thumbnail_url)) {
            return $this->thumbnail_url;
        }
        
        // Priority 2: Fallback ke image URL
        return $this->full_image_url;
    }

    /**
     * Accessor untuk additional images URLs
     */
    public function getAdditionalImagesUrlsAttribute()
    {
        if (!$this->additional_images || !is_array($this->additional_images)) {
            return [];
        }
        
        $urls = [];
        foreach ($this->additional_images as $image) {
            if (!empty($image)) {
                $urls[] = Storage::url($image);
            }
        }
        
        return $urls;
    }

    /**
     * Cek apakah memiliki additional images
     */
    public function hasAdditionalImages(): bool
    {
        if (!$this->additional_images || !is_array($this->additional_images)) {
            return false;
        }
        
        // Filter array untuk menghapus nilai null/empty
        $filteredImages = array_filter($this->additional_images);
        
        return count($filteredImages) > 0;
    }

    /**
     * Accessor untuk tags array
     */
    public function getTagsArrayAttribute()
    {
        if (is_array($this->tags)) {
            return $this->tags;
        }
        
        if (is_string($this->tags) && !empty($this->tags)) {
            return json_decode($this->tags, true) ?? [];
        }
        
        return [];
    }

    /**
     * Accessor untuk likes_count (compatibility)
     */
    public function getLikesCountAttribute()
    {
        return $this->attributes['like_count'] ?? 0;
    }

    /**
     * Accessor untuk favorites_count (compatibility)
     */
    public function getFavoritesCountAttribute()
    {
        return $this->attributes['favorite_count'] ?? 0;
    }

    /**
     * Accessor untuk comments_count (compatibility)
     */
    public function getCommentsCountAttribute()
    {
        return $this->attributes['comment_count'] ?? 0;
    }

    /**
     * Cek apakah artwork published
     */
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && 
               $this->is_approved && 
               $this->published_at !== null;
    }

    /**
     * Cek apakah artwork visible untuk user
     */
    public function isVisibleTo($userId = null)
    {
        if ($this->visibility === 'public') {
            return true;
        }
        
        if ($this->visibility === 'private') {
            return $userId && $this->user_id == $userId;
        }
        
        // Unlisted - visible via direct link
        return true;
    }

    /**
     * Scopes
     */
    public function scopePublic($query)
    {
        return $query->where('status', 'published')
                    ->where('visibility', 'public')
                    ->where('is_approved', true)
                    ->whereNotNull('published_at');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('is_approved', true)
                    ->whereNotNull('published_at');
    }

    public function scopeVisibleTo($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('visibility', 'public')
              ->orWhere('visibility', 'unlisted')
              ->orWhere(function($q2) use ($userId) {
                  $q2->where('visibility', 'private')
                     ->where('user_id', $userId);
              });
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->orderByDesc('like_count');
    }

    public function scopeTrending($query)
    {
        return $query->orderByDesc('views');
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Increment views dengan safety check
     */
    public function incrementViews($userId = null)
    {
        // Jangan increment jika user adalah pemilik
        if ($userId && $this->user_id == $userId) {
            return;
        }
        
        $this->increment('views');
        $this->increment('views_count');
    }
    
    /**
     * Setelah create/update, sync compatibility columns
     */
    protected static function booted()
    {
        static::saved(function ($artwork) {
            // Sync compatibility columns
            if ($artwork->isDirty('like_count')) {
                $artwork->likes_count = $artwork->like_count;
            }
            if ($artwork->isDirty('favorite_count')) {
                $artwork->favorites_count = $artwork->favorite_count;
            }
            if ($artwork->isDirty('comment_count')) {
                $artwork->comments_count = $artwork->comment_count;
            }
        });
    }
}