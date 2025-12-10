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
        'views_count',
        'like_count',
        'favorite_count',
        'comment_count',
        'report_count',
        'visibility',
        'status',
        'is_featured',
        'is_approved',
        'published_at',
        'additional_images',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'like_count' => 'integer',
        'favorite_count' => 'integer',
        'comment_count' => 'integer',
        'report_count' => 'integer',
        'additional_images' => 'array',
    ];

    protected $appends = [
        'full_image_url', 
        'full_thumbnail_url',
        'additional_images_urls',
        'likes_count',
        'favorites_count',
        'comments_count',
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

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
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
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Check if artwork is liked by a user
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Gunakan eager loading untuk efisiensi
        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('user_id', $user->id);
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if artwork is favorited by a user
     */
    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Gunakan eager loading untuk efisiensi
        if ($this->relationLoaded('favorites')) {
            return $this->favorites->contains('user_id', $user->id);
        }

        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    /**
     * Accessor untuk full image URL
     */
    public function getFullImageUrlAttribute(): ?string
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
    public function getFullThumbnailUrlAttribute(): ?string
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
    public function getAdditionalImagesUrlsAttribute(): array
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
        
        $filteredImages = array_filter($this->additional_images);
        return count($filteredImages) > 0;
    }

    /**
     * Accessor untuk tags array
     */
    public function getTagsArrayAttribute(): array
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
    public function getLikesCountAttribute(): int
    {
        return $this->attributes['like_count'] ?? 0;
    }

    /**
     * Accessor untuk favorites_count (compatibility)
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->attributes['favorite_count'] ?? 0;
    }

    /**
     * Accessor untuk comments_count (compatibility)
     */
    public function getCommentsCountAttribute(): int
    {
        return $this->attributes['comment_count'] ?? 0;
    }

    /**
     * Accessor untuk views (alias untuk views_count)
     */
    public function getViewsAttribute(): int
    {
        return $this->attributes['views_count'] ?? 0;
    }

    /**
     * Cek apakah artwork published
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published' && 
               $this->is_approved && 
               $this->published_at !== null;
    }

    /**
     * Cek apakah artwork visible untuk user
     */
    public function isVisibleTo(?User $user = null): bool
    {
        $userId = $user ? $user->id : null;
        
        if ($this->visibility === 'public') {
            return true;
        }
        
        if ($this->visibility === 'private') {
            return $userId && $this->user_id == $userId;
        }
        
        // Unlisted - visible via direct link
        if ($this->visibility === 'unlisted') {
            return true;
        }
        
        return false;
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
        return $query->orderByDesc('views_count');
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeMostCommented($query)
    {
        return $query->orderByDesc('comment_count');
    }

    public function scopeMostLiked($query)
    {
        return $query->orderByDesc('like_count');
    }

    /**
     * Increment views dengan safety check
     */
    public function incrementViews($userId = null): void
    {
        // Jangan increment jika user adalah pemilik
        if ($userId && $this->user_id == $userId) {
            return;
        }
        
        $this->increment('views_count');
    }

    /**
     * Increment like count
     */
    public function incrementLikes(): void
    {
        $this->increment('like_count');
    }

    /**
     * Decrement like count
     */
    public function decrementLikes(): void
    {
        $this->decrement('like_count');
    }

    /**
     * Increment favorite count
     */
    public function incrementFavorites(): void
    {
        $this->increment('favorite_count');
    }

    /**
     * Decrement favorite count
     */
    public function decrementFavorites(): void
    {
        $this->decrement('favorite_count');
    }

    /**
     * Increment comment count
     */
    public function incrementComments(): void
    {
        $this->increment('comment_count');
    }

    /**
     * Decrement comment count
     */
    public function decrementComments(): void
    {
        $this->decrement('comment_count');
    }

    /**
     * Publish artwork
     */
    public function publish(): bool
    {
        $this->status = 'published';
        $this->is_approved = true;
        $this->published_at = now();
        
        return $this->save();
    }

    /**
     * Unpublish artwork
     */
    public function unpublish(): bool
    {
        $this->status = 'draft';
        
        return $this->save();
    }

    /**
     * Set featured status
     */
    public function setFeatured(bool $featured): bool
    {
        $this->is_featured = $featured;
        
        return $this->save();
    }

    /**
     * Format untuk API response
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->full_image_url,
            'thumbnail_url' => $this->full_thumbnail_url,
            'user' => $this->user ? [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'display_name' => $this->user->display_name,
                'profile_image' => $this->user->profile_image_url,
            ] : null,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'stats' => [
                'views' => $this->views_count,
                'likes' => $this->like_count,
                'favorites' => $this->favorite_count,
                'comments' => $this->comment_count,
            ],
            'is_liked' => $this->isLikedBy(auth()->user()),
            'is_favorited' => $this->isFavoritedBy(auth()->user()),
            'created_at' => $this->created_at->toIso8601String(),
            'published_at' => $this->published_at ? $this->published_at->toIso8601String() : null,
        ];
    }
}