<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'cover_image',
        'is_public',
        'artworks_count',
        'views_count'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'social_links' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // PERBAIKI INI: ganti 'collection_artworks' dengan 'collection_artwork'
    public function artworks()
    {
        return $this->belongsToMany(Artwork::class, 'collection_artwork')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderByPivot('order', 'asc');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}