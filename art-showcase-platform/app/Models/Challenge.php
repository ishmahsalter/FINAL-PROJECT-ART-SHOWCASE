<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_id',
        'title',
        'description',
        'rules',
        'prize',
        'banner_image',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

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
        return $this->submissions()->whereNotNull('winner_rank')->orderBy('winner_rank');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active' 
            && Carbon::now()->between($this->start_date, $this->end_date);
    }

    public function isEnded()
    {
        return $this->status === 'ended' || Carbon::now()->gt($this->end_date);
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function hasUserSubmitted($userId)
    {
        return $this->submissions()->where('user_id', $userId)->exists();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now());
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended')
            ->orWhere('end_date', '<', Carbon::now());
    }
}