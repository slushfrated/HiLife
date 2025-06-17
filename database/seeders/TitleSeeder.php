<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Title;
use App\Models\Achievement;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            [
                'name' => 'Quest Master',
                'description' => 'A title earned by completing 100 quests',
                'color' => '#FFD700', // Gold color
                'achievement_id' => Achievement::where('name', 'Quest Master')->first()?->id
            ],
            [
                'name' => 'Quest Creator',
                'description' => 'A title earned by creating 5 quests',
                'color' => '#4CAF50', // Green color
                'achievement_id' => Achievement::where('name', 'Quest Creator')->first()?->id
            ],
            [
                'name' => 'Consistent Achiever',
                'description' => 'A title earned by maintaining a 3-day streak',
                'color' => '#FF7043', // Orange color
                'achievement_id' => Achievement::where('name', 'Consistent Achiever')->first()?->id
            ],
            [
                'name' => 'Level Up!',
                'description' => 'A title earned by reaching level 2',
                'color' => '#7ed957', // Green/level up color
                'achievement_id' => Achievement::where('name', 'Level Up!')->first()?->id
            ]
        ];

        foreach ($titles as $title) {
            Title::updateOrCreate(
                ['name' => $title['name']],
                $title
            );
        }
    }
} 