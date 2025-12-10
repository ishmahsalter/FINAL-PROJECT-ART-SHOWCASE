<?php
// database/seeders/FollowSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'active')->get();

        foreach ($users as $user) {
            $followCount = rand(0, min(8, $users->count() - 1));
            $followings = $users->where('id', '!=', $user->id)
                                ->random($followCount);
            
            foreach ($followings as $following) {
                try {
                    $user->followings()->attach($following->id, [
                        'created_at' => now()->subDays(rand(0, 90)),
                    ]);
                } catch (\Exception $e) {
                    // Ignore duplicate follows
                }
            }
            
            // Update user followers count jika ada kolom
            if (\Schema::hasColumn('users', 'followers_count')) {
                $user->followers_count = $user->followers()->count();
                $user->following_count = $user->followings()->count();
                $user->save();
            }
        }
        
        echo "👥 FollowSeeder: Created follows\n";
    }
}