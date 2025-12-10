<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $curator = User::where('role', 'curator')->where('status', 'active')->first();

        $challenges = [
            [
                'title' => 'Summer Vibes Art Challenge',
                'description' => 'Create artwork that captures the essence of summer!',
                'rules' => 'Must be original artwork. Any medium accepted. Must include summer theme.',
                'theme' => 'Summer',
                'prize_pool' => 500,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'title' => 'Character Design Contest',
                'description' => 'Design an original character for our upcoming game!',
                'rules' => 'Original character design only. Include character backstory. Full body illustration required.',
                'theme' => 'Character Design',
                'prize_pool' => 1000,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(25),
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'title' => 'Pixel Art Jam',
                'description' => 'Create stunning pixel art in limited color palette',
                'rules' => '32x32 or 64x64 pixels only. Maximum 16 colors. Original work only.',
                'theme' => 'Pixel Art',
                'prize_pool' => 250,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(5),
                'status' => 'completed',
                'is_featured' => false,
            ],
        ];

        foreach ($challenges as $index => $challenge) {  // PERBAIKAN: tambah $index di sini
            Challenge::create(array_merge($challenge, [
                'curator_id' => $curator->id,
                'slug' => Str::slug($challenge['title']),
                'banner_image' => 'https://picsum.photos/1200/400?random=' . ($index + 100), // Sekarang $index ada
                'participants_count' => rand(10, 100),
                'submissions_count' => rand(5, 50),
            ]));
        }
    }
}