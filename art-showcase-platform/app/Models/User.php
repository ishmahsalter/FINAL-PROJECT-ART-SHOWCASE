<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tambah constant untuk status
    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_BANNED = 'banned';
    
    // Constant untuk role
    const ROLE_ADMIN = 'admin';
    const ROLE_CURATOR = 'curator';
    const ROLE_MEMBER = 'member';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'display_name',
        'bio',
        'profile_image',
        'external_links',
        'avatar_url',       // Tambah ini
        'cover_image_url',  // Tambah ini
        'website',          // Tambah ini
        'social_links',     // Tambah ini
        'username',         // Tambah ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'followers_count',
        'following_count',
        'artworks_count',
        'is_followed_by_auth'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'external_links' => 'array',
            'social_links' => 'array',  // Tambah ini
        ];
    }

    // === RELATIONSHIPS ===
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class, 'curator_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    // Follow System
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    // === ACCESSORS ===
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }

    public function getArtworksCountAttribute()
    {
        return $this->artworks()->count();
    }

    public function getIsFollowedByAuthAttribute()
    {
        if (!auth()->check()) {
            return false;
        }
        return $this->followers()->where('follower_id', auth()->id())->exists();
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        if ($this->avatar_url) {
            return $this->avatar_url;
        }
        // Default avatar berdasarkan initial
        $initial = strtoupper(substr($this->name, 0, 1));
        $colors = ['#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899'];
        $color = $colors[ord($initial) % count($colors)];
        
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . 
               "&color=FFFFFF&background=" . substr($color, 1) . 
               "&size=200&bold=true&font-size=0.8";
    }

    public function getDisplayNameAttribute()
    {
        return $this->attributes['display_name'] ?? $this->name;
    }

    // === HELPER METHODS - ROLE ===
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMember()
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function isCurator()
    {
        return $this->role === self::ROLE_CURATOR;
    }

    // === HELPER METHODS - STATUS ===
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isSuspended()
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    public function isBanned()
    {
        return $this->status === self::STATUS_BANNED;
    }

    public function isFollowing($userId)
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    // === SCOPE QUERIES ===
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', self::STATUS_SUSPENDED);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', self::STATUS_BANNED);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeCurators($query)
    {
        return $query->where('role', self::ROLE_CURATOR);
    }

    public function scopeMembers($query)
    {
        return $query->where('role', self::ROLE_MEMBER);
    }

    // === STATIC METHODS ===
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SUSPENDED => 'Suspended',
            self::STATUS_BANNED => 'Banned',
        ];
    }

    public static function getRoles()
    {
        return [
            self::ROLE_MEMBER => 'Member',
            self::ROLE_CURATOR => 'Curator',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    // === PERMISSION CHECKS ===
    public function canAccessAdminPanel()
    {
        return $this->isActive() && $this->isAdmin();
    }

    public function canAccessCuratorPanel()
    {
        return $this->isActive() && $this->isCurator();
    }

    public function canUploadArtwork()
    {
        return $this->isActive() && ($this->isMember() || $this->isCurator());
    }

    public function canCreateChallenge()
    {
        return $this->isActive() && $this->isCurator();
    }

    public function canFollow()
    {
        return $this->isActive() && $this->isMember();
    }

    public function canCreateCollection()
    {
        return $this->isActive() && $this->isMember();
    }

    // === FOLLOW SYSTEM METHODS ===
    public function follow($userId)
    {
        if ($this->id === $userId) {
            return false; // Can't follow yourself
        }

        if (!$this->isFollowing($userId)) {
            $this->following()->attach($userId);
            return true;
        }
        
        return false;
    }

    public function unfollow($userId)
    {
        $this->following()->detach($userId);
        return true;
    }

    public function toggleFollow($userId)
    {
        if ($this->isFollowing($userId)) {
            return $this->unfollow($userId);
        } else {
            return $this->follow($userId);
        }
    }

    // === CUSTOM QUERIES ===
    public function scopePopular($query, $limit = 10)
    {
        return $query->whereHas('followers')
                    ->withCount('followers')
                    ->orderBy('followers_count', 'desc')
                    ->limit($limit);
    }

    public function scopeWithMostArtworks($query, $limit = 10)
    {
        return $query->whereHas('artworks')
                    ->withCount('artworks')
                    ->orderBy('artworks_count', 'desc')
                    ->limit($limit);
    }

    public function scopeSuggestedForUser($query, $userId, $limit = 5)
    {
        return $query->where('id', '!=', $userId)
                    ->whereNotIn('id', function($query) use ($userId) {
                        $query->select('following_id')
                              ->from('follows')
                              ->where('follower_id', $userId);
                    })
                    ->where('status', self::STATUS_ACTIVE)
                    ->where('role', self::ROLE_MEMBER)
                    ->withCount(['artworks', 'followers'])
                    ->orderByRaw('RAND()')
                    ->limit($limit);
    }
}