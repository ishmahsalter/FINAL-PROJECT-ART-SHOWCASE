<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'artwork_id',
        'parent_id',
        'content',
        'like_count',
        'edited_at',
    ];

    protected $casts = [
        'edited_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Check if comment is liked by a user
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Scope for top-level comments (no parent)
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for replies
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }
}