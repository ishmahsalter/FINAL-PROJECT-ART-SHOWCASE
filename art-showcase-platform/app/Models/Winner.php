<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'submission_id',
        'user_id',
        'awarded_by',
        'rank',
        'prize_amount',
        'notes',
        'awarded_at',
        'is_featured',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}