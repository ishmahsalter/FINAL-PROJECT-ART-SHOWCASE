<?php
// database/seeders/ArtworkSeeder.php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role', 'member')->get();
        if ($members->isEmpty()) {
            echo "❌ No member users found!\n";
            return;
        }
        
        $categories = Category::all();
        if ($categories->isEmpty()) {
            echo "❌ No categories found!\n";
            return;
        }
        
        // Cek apakah ada challenges
        $challenges = Challenge::all();

        $artworks = [
            [
                'title' => 'Sunset Dreams', 
                'description' => 'A vibrant digital illustration of a dreamy sunset landscape',
                'media' => 'Digital Painting, Photoshop'
            ],
            [
                'title' => 'Cyber Warrior', 
                'description' => 'Futuristic character design with cyberpunk aesthetics',
                'media' => '3D Modeling, Blender, Substance Painter'
            ],
            [
                'title' => 'Mountain Peak', 
                'description' => 'Stunning photograph of mountain peaks at dawn',
                'media' => 'Photography, Lightroom'
            ],
            [
                'title' => 'Modern UI Kit', 
                'description' => 'Clean and minimal UI design system',
                'media' => 'Figma, Illustrator'
            ],
            [
                'title' => 'Pixel Adventure', 
                'description' => 'Retro pixel art game scene',
                'media' => 'Pixel Art, Aseprite'
            ],
            [
                'title' => 'Abstract Geometry', 
                'description' => '3D geometric shapes with gradient colors',
                'media' => 'Cinema 4D, Octane Render'
            ],
            [
                'title' => 'Brand Identity', 
                'description' => 'Complete brand identity design for a coffee shop',
                'media' => 'Illustrator, InDesign'
            ],
            [
                'title' => 'Character Concept', 
                'description' => 'Fantasy character design exploration',
                'media' => 'Procreate, Photoshop'
            ],
            [
                'title' => 'City Lights', 
                'description' => 'Night photography of urban cityscape',
                'media' => 'Photography, Long Exposure'
            ],
            [
                'title' => 'Animated Logo', 
                'description' => 'Smooth logo animation for brand presentation',
                'media' => 'After Effects, Lottie'
            ],
        ];

        foreach ($artworks as $index => $artwork) {
            try {
                Artwork::create([
                    'user_id' => $members->random()->id,
                    'category_id' => $categories->random()->id,
                    'challenge_id' => $challenges->isNotEmpty() ? $challenges->random()->id : null,
                    'title' => $artwork['title'],
                    'slug' => Str::slug($artwork['title']) . '-' . Str::random(6),
                    'description' => $artwork['description'],
                    'media_used' => $artwork['media'],
                    'image_path' => 'artworks/sample-' . ($index + 1) . '.jpg',
                    'views_count' => rand(10, 500),
                    'likes_count' => rand(0, 100),
                    'comments_count' => rand(0, 30),
                    'favorites_count' => rand(0, 50),
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
                
                echo "✅ Created: {$artwork['title']}\n";
            } catch (\Exception $e) {
                echo "❌ Error creating {$artwork['title']}: " . $e->getMessage() . "\n";
            }
        }
        
        echo "🎨 Artwork seeder completed! Total: " . Artwork::count() . " artworks\n";
    }
}