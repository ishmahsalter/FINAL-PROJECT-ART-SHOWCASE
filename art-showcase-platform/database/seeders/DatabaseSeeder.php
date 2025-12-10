<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // URUTAN: parent -> child
        $this->call([
            UserSeeder::class,        // 1. Users (dibutuhkan semua)
            CategorySeeder::class,    // 2. Categories (dibutuhkan artworks)
            ChallengeSeeder::class,   // 3. Challenges (optional untuk artworks)
            ArtworkSeeder::class,     // 4. Artworks (dibutuhkan likes, comments, favorites)
            LikeSeeder::class,        // 5. Likes (butuh user & artwork)
            CommentSeeder::class,     // 6. Comments (butuh user & artwork)
            FavoriteSeeder::class,    // 7. Favorites (butuh user & artwork)
            FollowSeeder::class,      // 8. Follows (butuh user & user)
            CollectionSeeder::class,  // 9. Collections (butuh user)
            // SubmissionSeeder::class, // Jika ada (butuh challenge & user)
        ]);
    }
}