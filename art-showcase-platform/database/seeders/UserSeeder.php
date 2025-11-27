<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'display_name' => 'Admin',
            'bio' => 'Platform administrator',
        ]);

        // Active Curator
        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'curator@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => 'curator',
            'status' => 'active',
            'display_name' => 'ArtEvents Co',
            'bio' => 'Organizing creative challenges and events',
            'external_links' => json_encode([
                'website' => 'https://artevents.com',
                'instagram' => 'https://instagram.com/artevents'
            ]),
        ]);

        // Pending Curator
        User::create([
            'name' => 'Mike Wilson',
            'email' => 'pending@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => 'curator',
            'status' => 'pending',
            'display_name' => 'Creative Hub',
            'bio' => 'Waiting for approval',
        ]);

        // Members
        $members = [
            [
                'name' => 'Alice Cooper',
                'email' => 'alice@example.com',
                'display_name' => 'AliceArt',
                'bio' => 'Digital illustrator and character designer',
                'external_links' => json_encode([
                    'behance' => 'https://behance.net/aliceart',
                    'instagram' => 'https://instagram.com/aliceart'
                ]),
            ],
            [
                'name' => 'Bob Martinez',
                'email' => 'bob@example.com',
                'display_name' => 'BobTheCreator',
                'bio' => '3D artist and animator',
                'external_links' => json_encode([
                    'artstation' => 'https://artstation.com/bobthecreator'
                ]),
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie@example.com',
                'display_name' => 'PixelCharlie',
                'bio' => 'Pixel art enthusiast and game designer',
            ],
            [
                'name' => 'Diana Prince',
                'email' => 'diana@example.com',
                'display_name' => 'DesignByDiana',
                'bio' => 'UI/UX designer with a passion for clean aesthetics',
            ],
            [
                'name' => 'Eric Thompson',
                'email' => 'eric@example.com',
                'display_name' => 'EricPhotography',
                'bio' => 'Landscape and portrait photographer',
            ],
        ];

        foreach ($members as $member) {
            User::create(array_merge($member, [
                'password' => Hash::make('password'),
                'role' => 'member',
                'status' => 'active',
            ]));
        }
    }
}