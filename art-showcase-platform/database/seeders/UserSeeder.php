<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin - SESUAIKAN DENGAN KOLOM YANG ADA
        User::create([
            'name' => 'Admin User',
            'display_name' => 'Admin',
            'email' => 'admin@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'bio' => 'Platform administrator',
            'profile_image' => 'https://ui-avatars.com/api/?name=Admin+User',
            'external_links' => json_encode([]),
            'email_verified_at' => now(),
        ]);

        // Active Curator
        User::create([
            'name' => 'Sarah Johnson',
            'display_name' => 'ArtEvents Co',
            'email' => 'curator@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => 'curator',
            'status' => 'active',
            'bio' => 'Organizing creative challenges and events',
            'profile_image' => 'https://ui-avatars.com/api/?name=...',
            'external_links' => json_encode([
                'instagram' => 'https://instagram.com/artevents',
                'twitter' => 'https://twitter.com/artevents',
                'behance' => 'https://behance.net/artevents'
            ]),
            'email_verified_at' => now(),
        ]);

        // Pending Curator
        User::create([
            'name' => 'Mike Wilson',
            'display_name' => 'Creative Hub',
            'email' => 'pending@artshowcase.com',
            'password' => Hash::make('password'),
            'role' => 'curator',
            'status' => 'pending',
            'bio' => 'Waiting for approval',
            'profile_image' => 'https://ui-avatars.com/api/?name=Mike+Wilson',
            'external_links' => json_encode([]),
            'email_verified_at' => null,
        ]);

        // Members
        $members = [
            [
                'name' => 'Alice Cooper',
                'display_name' => 'AliceArt',
                'email' => 'alice@example.com',
                'bio' => 'Digital illustrator and character designer',
                'profile_image' => 'https://ui-avatars.com/api/?name=Alice+Cooper',
                'external_links' => json_encode([
                    'behance' => 'https://behance.net/aliceart',
                    'instagram' => 'https://instagram.com/aliceart',
                    'artstation' => 'https://artstation.com/aliceart'
                ]),
            ],
            [
                'name' => 'Bob Martinez',
                'display_name' => 'BobTheCreator',
                'email' => 'bob@example.com',
                'bio' => '3D artist and animator',
                'profile_image' => 'https://ui-avatars.com/api/?name=Bob+Martinez',
                'external_links' => json_encode([
                    'artstation' => 'https://artstation.com/bobthecreator',
                    'instagram' => 'https://instagram.com/bobcreator'
                ]),
            ],
            [
                'name' => 'Charlie Davis',
                'display_name' => 'PixelCharlie',
                'email' => 'charlie@example.com',
                'bio' => 'Pixel art enthusiast and game designer',
                'profile_image' => 'https://ui-avatars.com/api/?name=Charlie+Davis',
                'external_links' => json_encode([
                    'website' => 'https://pixelcharlie.com'
                ]),
            ],
            [
                'name' => 'Diana Prince',
                'display_name' => 'DesignByDiana',
                'email' => 'diana@example.com',
                'bio' => 'UI/UX designer with a passion for clean aesthetics',
                'profile_image' => 'https://ui-avatars.com/api/?name=Diana+Prince',
                'external_links' => json_encode([
                    'dribbble' => 'https://dribbble.com/designbydiana',
                    'linkedin' => 'https://linkedin.com/in/dianaprince'
                ]),
            ],
            [
                'name' => 'Eric Thompson',
                'display_name' => 'EricPhotography',
                'email' => 'eric@example.com',
                'bio' => 'Landscape and portrait photographer',
                'profile_image' => 'https://ui-avatars.com/api/?name=Eric+Thompson',
                'external_links' => json_encode([
                    'instagram' => 'https://instagram.com/ericphoto',
                    '500px' => 'https://500px.com/ericthompson'
                ]),
            ],
        ];

        foreach ($members as $member) {
            User::create(array_merge($member, [
                'password' => Hash::make('password'),
                'role' => 'member',
                'status' => 'active',
                'email_verified_at' => now(),
            ]));
        }

        // Tambah beberapa user dummy
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => fake()->name(),
                'display_name' => fake()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'member',
                'status' => 'active',
                'bio' => fake()->paragraph(),
                'profile_image' => 'https://ui-avatars.com/api/?name=' . urlencode(fake()->name()),
                'external_links' => json_encode([]),
                'email_verified_at' => now(),
            ]);
        }
    }
}