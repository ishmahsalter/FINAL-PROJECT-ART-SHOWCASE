<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'artwork_id',
        'comment', // INI MASIH 'comment' - biarin sesuai database
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
    
    // Accessor untuk kompatibilitas dengan controller
    public function getContentAttribute()
    {
        return $this->comment;
    }
}