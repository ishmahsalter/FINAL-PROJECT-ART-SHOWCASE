<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Digital Illustration', 'description' => 'Digital drawings and paintings'],
            ['name' => 'Photography', 'description' => 'Photography and photo editing'],
            ['name' => '3D Art', 'description' => '3D modeling and rendering'],
            ['name' => 'UI/UX Design', 'description' => 'User interface and experience design'],
            ['name' => 'Graphic Design', 'description' => 'Logos, posters, and branding'],
            ['name' => 'Animation', 'description' => '2D and 3D animation'],
            ['name' => 'Character Design', 'description' => 'Character concepts and art'],
            ['name' => 'Pixel Art', 'description' => 'Retro and pixel-style artwork'],
            ['name' => 'Concept Art', 'description' => 'Game and film concept art'],
            ['name' => 'Typography', 'description' => 'Lettering and type design'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}