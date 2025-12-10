<?php
// database/seeders/CommentSeeder.php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'active')->get();
        $artworks = Artwork::all();

        $comments = [
            "Amazing work! Love the colors.",
            "The details are incredible!",
            "This is inspiring!",
            "Great concept and execution.",
            "The lighting is perfect!",
            "Would love to see more of your work.",
            "What software did you use?",
            "The composition is fantastic.",
            "This deserves more attention!",
            "So creative! Keep it up!",
            "The textures are well done.",
            "I really like your style.",
            "This tells a great story.",
            "The mood is captured perfectly.",
            "Technical skills on point!",
        ];

        foreach ($artworks as $artwork) {
            $commentCount = rand(1, 8);
            $commenters = $users->random($commentCount);
            
            foreach ($commenters as $index => $commenter) {
                $comment = Comment::create([
                    'user_id' => $commenter->id,
                    'artwork_id' => $artwork->id,
                    'content' => $comments[array_rand($comments)],
                    'created_at' => now()->subDays(rand(0, 10))->subHours(rand(0, 23)),
                ]);
                
                // 30% chance untuk reply
                if ($index > 0 && rand(1, 100) <= 30) {
                    Comment::create([
                        'user_id' => $artwork->user_id, // Artwork owner replies
                        'artwork_id' => $artwork->id,
                        'parent_id' => $comment->id,
                        'content' => 'Thank you for your feedback!',
                        'created_at' => $comment->created_at->addHours(rand(1, 5)),
                    ]);
                }
            }
            
            // Update artwork comments count
            $artwork->comments_count = $artwork->comments()->count();
            $artwork->save();
        }
        
        echo "💬 CommentSeeder: Created " . Comment::count() . " comments\n";
    }
}