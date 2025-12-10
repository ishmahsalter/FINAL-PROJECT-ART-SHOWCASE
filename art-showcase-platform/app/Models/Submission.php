<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_id',
        'artwork_id',
        'description',
        'status',
        'feedback',
        'score',
        'winner_rank',
    ];

    protected $casts = [
        'score' => 'integer',
        'winner_rank' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }
}