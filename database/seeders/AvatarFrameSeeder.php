<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvatarFrame;
use App\Models\Achievement;

class AvatarFrameSeeder extends Seeder
{
    public function run(): void
    {
        $frames = [
            [
                'name' => 'Gold Champion',
                'image_path' => 'frames/gold.png',
                'description' => 'Reward for completing First Quest',
                'achievement_id' => Achievement::where('name', 'First Quest Complete')->first()?->id
            ],
            [
                'name' => 'Fire Champion',
                'image_path' => 'frames/fire-flame.png',
                'description' => 'Reward for completing Streak Keeper',
                'achievement_id' => Achievement::where('name', 'Streak Keeper')->first()?->id
            ],
            [
                'name' => 'Moon and Stars',
                'image_path' => 'frames/moon-and-stars.png',
                'description' => 'Reward for completing Veteran',
                'achievement_id' => Achievement::where('name', 'Veteran')->first()?->id
            ],
            [
                'name' => 'Neon',
                'image_path' => 'frames/neon.png',
                'description' => 'Reward for completing Rising Star',
                'achievement_id' => Achievement::where('name', 'Rising Star')->first()?->id
            ]
        ];

        foreach ($frames as $frame) {
            AvatarFrame::updateOrCreate(
                ['name' => $frame['name']],
                $frame
            );
        }
    }
} 