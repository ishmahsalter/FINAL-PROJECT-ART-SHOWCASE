<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'artwork_id',
        'user_id',
        'winner_rank',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    // Relationships
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isWinner()
    {
        return !is_null($this->winner_rank);
    }

    public function getWinnerBadge()
    {
        return match($this->winner_rank) {
            1 => '🥇 1st Place',
            2 => '🥈 2nd Place',
            3 => '🥉 3rd Place',
            default => null,
        };
    }
}