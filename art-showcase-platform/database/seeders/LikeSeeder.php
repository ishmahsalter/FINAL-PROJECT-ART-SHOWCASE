<?php
// database/seeders/LikeSeeder.php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'active')->get();
        $artworks = Artwork::all();

        foreach ($artworks as $artwork) {
            $likeCount = rand(0, 15);
            $likers = $users->where('id', '!=', $artwork->user_id)
                            ->random(min($likeCount, $users->count() - 1));
            
            foreach ($likers as $liker) {
                $artwork->likes()->firstOrCreate([
                    'user_id' => $liker->id,
                ]);
            }
            
            // Update artwork likes count
            $artwork->likes_count = $artwork->likes()->count();
            $artwork->save();
        }
        
        echo "❤️ LikeSeeder: Created " . \App\Models\Like::count() . " likes\n";
    }
}