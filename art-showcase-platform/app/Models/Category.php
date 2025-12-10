<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the artworks for the category.
     */
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }
    
    /**
     * Get the artworks count.
     */
    public function getArtworksCountAttribute()
    {
        return $this->artworks()->count();
    }
}