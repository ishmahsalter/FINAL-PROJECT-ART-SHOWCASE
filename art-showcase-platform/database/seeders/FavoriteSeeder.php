<?php
// database/seeders/FavoriteSeeder.php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'active')->get();
        $artworks = Artwork::all();

        foreach ($artworks as $artwork) {
            $favoriteCount = rand(0, 12);
            $favoriters = $users->where('id', '!=', $artwork->user_id)
                                ->random(min($favoriteCount, $users->count() - 1));
            
            foreach ($favoriters as $favoriter) {
                Favorite::firstOrCreate([
                    'user_id' => $favoriter->id,
                    'artwork_id' => $artwork->id,
                ]);
            }
            
            // Update artwork favorites count
            $artwork->favorites_count = $artwork->favorites()->count();
            $artwork->save();
        }
        
        echo "⭐ FavoriteSeeder: Created " . Favorite::count() . " favorites\n";
    }
}