<?php
// database/seeders/CollectionSeeder.php - UPDATE

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'active')->limit(5)->get();
        $artworks = Artwork::limit(20)->get();

        if ($users->isEmpty() || $artworks->isEmpty()) {
            echo "⚠️  Need users and artworks first!\n";
            return;
        }

        echo "Creating collections...\n";

        foreach ($users as $user) {
            for ($i = 1; $i <= rand(2, 3); $i++) {
                $name = "Collection {$i} by " . $user->display_name;
                
                $collection = Collection::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . Str::random(4),
                    'description' => "A personal collection by " . $user->display_name,
                    'is_public' => rand(0, 1),
                    'cover_image' => $artworks->random()->image_path,
                    'artworks_count' => 0,
                    'views_count' => rand(0, 50),
                ]);
                
                // Gunakan DB facade langsung untuk menghindari eloquent pluralization
                $selectedArtworks = $artworks->random(rand(3, 6));
                
                foreach ($selectedArtworks as $artwork) {
                    DB::table('collection_artwork')->insert([
                        'collection_id' => $collection->id,
                        'artwork_id' => $artwork->id,
                        'order' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                // Update count
                $collection->artworks_count = DB::table('collection_artwork')
                    ->where('collection_id', $collection->id)
                    ->count();
                $collection->save();
                
                echo "✅ Created: {$collection->name}\n";
            }
        }
        
        echo "📚 CollectionSeeder completed. Total: " . Collection::count() . " collections\n";
    }
}