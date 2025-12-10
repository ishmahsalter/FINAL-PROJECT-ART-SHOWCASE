<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'status',
        'admin_note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who made the report.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the reported content (polymorphic).
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Scope for pending reports.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    /**
     * Scope for resolved reports.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }
    
    /**
     * Scope for dismissed reports.
     */
    public function scopeDismissed($query)
    {
        return $query->where('status', 'dismissed');
    }
    
    /**
     * Get the display name for reportable type.
     */
    public function getReportableTypeNameAttribute(): string
    {
        return match($this->reportable_type) {
            'App\Models\Artwork' => 'Artwork',
            'App\Models\Comment' => 'Comment',
            default => 'Unknown',
        };
    }
}