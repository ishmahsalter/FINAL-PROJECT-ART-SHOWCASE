<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Challenge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'curator_id',
        'title',
        'slug',
        'description',
        'rules',
        'theme',
        'banner_image',
        'start_date',
        'end_date',
        'status',
        'is_featured',
        'prize_pool',
        'prize',
        'participants_count',
        'submissions_count',
        'winners_count',
        'is_approved',
        'is_draft',
    ];

    protected $attributes = [
        'status' => 'upcoming',
        'is_featured' => false,
        'is_approved' => true,
        'is_draft' => false,
        'participants_count' => 0,
        'submissions_count' => 0,
        'winners_count' => 0,
        'prize' => null,
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'is_draft' => 'boolean',
            'prize_pool' => 'integer',
            'participants_count' => 'integer',
            'submissions_count' => 'integer',
            'winners_count' => 'integer',
        ];
    }

    // TAMBAH PROPERTY APPENDS untuk accessor
    protected $appends = [
        'display_status',
        'dashboard_status',
        'is_visible_to_public',
        'formatted_end_date',
        'short_end_date',
        'remaining_time',
        'image_url',
        'deadline',
        'is_active',
        'is_ended',
        'is_upcoming'
    ];

    // Relationships
    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class)->orderBy('rank');
    }

    // Helper methods
    public function isUpcoming()
    {
        return $this->status === 'upcoming' && Carbon::now()->lt($this->start_date);
    }

    public function isActive()
    {
        return $this->status === 'active' && Carbon::now()->between($this->start_date, $this->end_date);
    }

    public function isCompleted()
    {
        return $this->status === 'completed' || Carbon::now()->gt($this->end_date);
    }

    // NEW: Alias untuk compatibility dengan kode lama
    public function isEnded()
    {
        return $this->isCompleted();
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isFeatured()
    {
        return $this->is_featured;
    }

    public function isApproved()
    {
        return $this->is_approved;
    }

    public function isDraft()
    {
        return $this->is_draft;
    }

    // NEW: Check jika challenge butuh pemenang
    public function needsWinnersSelection()
    {
        return $this->isCompleted() && $this->winners()->count() === 0;
    }

    public function hasUserSubmitted($userId)
    {
        return $this->submissions()->where('user_id', $userId)->exists();
    }

    public function getUserSubmission($userId)
    {
        return $this->submissions()->where('user_id', $userId)->first();
    }

    // NEW: Get top winners
    public function getTopWinners($limit = 3)
    {
        return $this->winners()
            ->with(['user', 'submission.artwork'])
            ->orderBy('rank')
            ->limit($limit)
            ->get();
    }

    // NEW: Check if submission is winner
    public function isSubmissionWinner($submissionId)
    {
        return $this->winners()->where('submission_id', $submissionId)->exists();
    }

    // NEW: Get submission rank
    public function getSubmissionRank($submissionId)
    {
        $winner = $this->winners()->where('submission_id', $submissionId)->first();
        return $winner ? $winner->rank : null;
    }

    // Scopes
    public function scopeUpcoming($query)
    {   
        return $query->where('status', 'upcoming')
            ->where('is_approved', true)
            ->where('is_draft', false)
            ->where('start_date', '>', Carbon::now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('is_approved', true)
            ->where('is_draft', false)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now());
    }

    public function scopeCompleted($query)
    {
        return $query->where(function($q) {
                $q->where('status', 'completed')
                  ->orWhere('end_date', '<', Carbon::now());
            })
            ->where('is_approved', true)
            ->where('is_draft', false);
    }

    // NEW: Scope untuk challenge yang butuh pemenang
    public function scopeWhereNeedsWinners($query)
    {
        return $query->where(function($q) {
                $q->where('status', 'completed')
                  ->orWhere('end_date', '<', Carbon::now());
            })
            ->whereDoesntHave('winners')
            ->where('is_approved', true)
            ->where('is_draft', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->where('is_approved', true)
            ->where('is_draft', false);
    }

    public function scopePublic($query)
    {
        return $query->where('is_approved', true)
            ->where('is_draft', false)
            ->whereIn('status', ['upcoming', 'active', 'completed']);
    }

    // Compatibility scopes dengan controller
    public function scopeWhereDeadline($query, $operator, $date = null)
    {
        return $query->where('end_date', $operator, $date ?? Carbon::now());
    }

    public function scopeWhereHasSubmissions($query)
    {
        return $query->whereHas('submissions');
    }

    public function scopeWhereDoesntHaveWinners($query)
    {
        return $query->whereDoesntHave('winners');
    }

    // ACCESSOR BARU yang ditambahkan:
    public function getIsActiveAttribute()
    {
        return $this->isActive();
    }

    public function getIsEndedAttribute()
    {
        return $this->isCompleted();
    }

    public function getIsUpcomingAttribute()
    {
        return $this->isUpcoming();
    }

    public function getIsVisibleToPublicAttribute()
    {
        return $this->is_approved 
            && !$this->is_draft 
            && !$this->isCancelled()
            && !$this->trashed()
            && in_array($this->status, ['upcoming', 'active', 'completed']);
    }

    // Accessors untuk compatibility
    public function getPrizeAttribute($value)
    {
        // Jika ada nilai di database, gunakan itu
        if (!empty($value)) {
            return $value;
        }
        
        // Jika tidak ada, gunakan prize_pool atau default
        if ($this->prize_pool) {
            return '$' . number_format($this->prize_pool);
        }
        return 'Featured Spot';
    }

    public function getDeadlineAttribute()
    {
        return $this->end_date;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->banner_image) {
            return asset('images/default-challenge-banner.jpg');
        }
        
        if (str_starts_with($this->banner_image, 'http')) {
            return $this->banner_image;
        }
        
        return Storage::url($this->banner_image);
    }

    // Display status yang lebih user-friendly
    public function getDisplayStatusAttribute()
    {
        if ($this->is_draft) {
            return 'Draft';
        }
        
        if (!$this->is_approved) {
            return 'Pending Approval';
        }
        
        return match($this->status) {
            'upcoming' => 'Upcoming',
            'active' => 'Active',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    // NEW: Status untuk dashboard
    public function getDashboardStatusAttribute()
    {
        if ($this->is_draft) return 'Draft';
        if (!$this->is_approved) return 'Pending';
        
        if ($this->isActive()) return 'Active';
        if ($this->isCompleted()) return 'Ended';
        if ($this->isUpcoming()) return 'Upcoming';
        
        return ucfirst($this->status);
    }

    public function canSubmit($userId = null)
    {
        if (!$this->isActive() || $this->isCancelled() || !$this->is_approved || $this->is_draft) {
            return false;
        }

        if ($userId && $this->hasUserSubmitted($userId)) {
            return false;
        }

        return true;
    }

    public function isSubmissionOpen()
    {
        return $this->isActive() 
            && $this->is_approved 
            && !$this->is_draft
            && Carbon::now()->lt($this->end_date);
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('M d, Y') : null;
    }

    public function getShortEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('M d') : null;
    }

    public function getRemainingTimeAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        $now = Carbon::now();
        $end = Carbon::parse($this->end_date);

        if ($now->gte($end)) {
            return 'Expired';
        }

        $diff = $now->diff($end);

        if ($diff->days > 30) {
            return $diff->m . ' months ' . $diff->d . ' days';
        } elseif ($diff->days > 0) {
            return $diff->days . ' days';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hours';
        } else {
            return $diff->i . ' minutes';
        }
    }

    // Relationship untuk participants
    public function participants()
    {
        return $this->hasManyThrough(
            User::class,
            Submission::class,
            'challenge_id',
            'id',
            'id',
            'user_id'
        );
    }

    // Hitung submissions count yang sesuai dengan kebutuhan
    public function getValidSubmissionsCountAttribute()
    {
        return $this->submissions()->where('status', '!=', 'draft')->count();
    }

    // Get active submissions
    public function getActiveSubmissionsAttribute()
    {
        return $this->submissions()->whereIn('status', ['pending', 'approved'])->get();
    }

    // NEW METHOD: Untuk dashboard curator (compatibility)
    public function getEndedChallengesWithoutWinners()
    {
        return self::where('curator_id', $this->curator_id)
            ->where('end_date', '<', Carbon::now())
            ->whereDoesntHave('winners')
            ->count();
    }

    // NEW METHOD: Untuk route binding dengan slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Boot method untuk generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($challenge) {
            if (empty($challenge->slug)) {
                $challenge->slug = \Str::slug($challenge->title);
            }
        });

        static::updating(function ($challenge) {
            if ($challenge->isDirty('title')) {
                $challenge->slug = \Str::slug($challenge->title);
            }
        });
    }
}