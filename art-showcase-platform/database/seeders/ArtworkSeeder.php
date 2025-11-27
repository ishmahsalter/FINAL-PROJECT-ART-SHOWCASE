<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role', 'member')->get();
        $categories = Category::all();

        $artworks = [
            ['title' => 'Sunset Dreams', 'description' => 'A vibrant digital illustration of a dreamy sunset landscape', 'tags' => ['landscape', 'sunset', 'digital']],
            ['title' => 'Cyber Warrior', 'description' => 'Futuristic character design with cyberpunk aesthetics', 'tags' => ['character', 'cyberpunk', 'scifi']],
            ['title' => 'Mountain Peak', 'description' => 'Stunning photograph of mountain peaks at dawn', 'tags' => ['photography', 'nature', 'mountains']],
            ['title' => 'Modern UI Kit', 'description' => 'Clean and minimal UI design system', 'tags' => ['ui', 'design', 'minimal']],
            ['title' => 'Pixel Adventure', 'description' => 'Retro pixel art game scene', 'tags' => ['pixel', 'game', 'retro']],
            ['title' => 'Abstract Geometry', 'description' => '3D geometric shapes with gradient colors', 'tags' => ['3d', 'abstract', 'geometry']],
            ['title' => 'Brand Identity', 'description' => 'Complete brand identity design for a coffee shop', 'tags' => ['branding', 'logo', 'identity']],
            ['title' => 'Character Concept', 'description' => 'Fantasy character design exploration', 'tags' => ['character', 'fantasy', 'concept']],
            ['title' => 'City Lights', 'description' => 'Night photography of urban cityscape', 'tags' => ['photography', 'city', 'night']],
            ['title' => 'Animated Logo', 'description' => 'Smooth logo animation for brand presentation', 'tags' => ['animation', 'logo', 'motion']],
            ['title' => 'Isometric City', 'description' => 'Colorful isometric city illustration', 'tags' => ['isometric', 'city', 'illustration']],
            ['title' => 'Portrait Study', 'description' => 'Digital portrait painting practice', 'tags' => ['portrait', 'painting', 'study']],
            ['title' => 'Web Interface', 'description' => 'Modern web app interface design', 'tags' => ['web', 'interface', 'ui']],
            ['title' => '3D Product', 'description' => 'Realistic product render for e-commerce', 'tags' => ['3d', 'product', 'render']],
            ['title' => 'Space Explorer', 'description' => 'Sci-fi spaceship concept art', 'tags' => ['scifi', 'space', 'concept']],
            ['title' => 'Vintage Poster', 'description' => 'Retro-style event poster design', 'tags' => ['poster', 'vintage', 'retro']],
            ['title' => 'Nature Macro', 'description' => 'Close-up photography of nature details', 'tags' => ['photography', 'macro', 'nature']],
            ['title' => 'Game Assets', 'description' => 'Complete 2D game asset pack', 'tags' => ['game', '2d', 'assets']],
            ['title' => 'Typography Art', 'description' => 'Creative lettering and typography composition', 'tags' => ['typography', 'lettering', 'art']],
            ['title' => 'Minimalist Scene', 'description' => 'Simple and clean 3D scene', 'tags' => ['3d', 'minimal', 'scene']],
        ];

        foreach ($artworks as $index => $artwork) {
            Artwork::create([
                'user_id' => $members->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $artwork['title'],
                'description' => $artwork['description'],
                'image_path' => 'artworks/sample-' . ($index + 1) . '.jpg', // Placeholder
                'tags' => $artwork['tags'],
                'view_count' => rand(10, 500),
            ]);
        }
    }
}