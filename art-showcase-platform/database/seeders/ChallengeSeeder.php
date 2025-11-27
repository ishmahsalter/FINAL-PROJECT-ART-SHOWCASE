<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
                'prize' => '$500 cash prize + Featured on homepage',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'status' => 'active',
            ],
            [
                'title' => 'Character Design Contest',
                'description' => 'Design an original character for our upcoming game!',
                'rules' => 'Original character design only. Include character backstory. Full body illustration required.',
                'prize' => '$1000 + Your character in our game',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(25),
                'status' => 'active',
            ],
            [
                'title' => 'Pixel Art Jam',
                'description' => 'Create stunning pixel art in limited color palette',
                'rules' => '32x32 or 64x64 pixels only. Maximum 16 colors. Original work only.',
                'prize' => '$250 + Art supplies bundle',
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(5),
                'status' => 'ended',
            ],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create(array_merge($challenge, [
                'curator_id' => $curator->id,
            ]));
        }
    }
}