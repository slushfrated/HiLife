<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::firstOrCreate([
            'name' => 'First Quest Complete',
        ], [
            'description' => 'Complete your first quest.',
            'icon' => 'first-quest.png',
            'type' => 'quests',
            'target' => 1
        ]);
        Achievement::firstOrCreate([
            'name' => 'Quest Novice',
        ], [
            'description' => 'Complete 10 quests.',
            'icon' => 'quest-novice.png',
            'type' => 'quests',
            'target' => 10
        ]);
        Achievement::firstOrCreate([
            'name' => 'Quest Master',
        ], [
            'description' => 'Complete 100 quests.',
            'icon' => 'quest-master.png',
            'type' => 'quests',
            'target' => 100
        ]);
        Achievement::firstOrCreate([
            'name' => 'Level Up!',
        ], [
            'description' => 'Reach level 2.',
            'icon' => 'level-up.png',
            'type' => 'level',
            'target' => 2
        ]);
        Achievement::firstOrCreate([
            'name' => 'Veteran',
        ], [
            'description' => 'Reach level 10.',
            'icon' => 'veteran.png',
            'type' => 'level',
            'target' => 10
        ]);
        Achievement::firstOrCreate([
            'name' => '7-Day Streak',
        ], [
            'description' => 'Maintain a streak for 7 days in a row.',
            'icon' => 'fire.png',
            'type' => 'streak',
            'target' => 7
        ]);
    }
}
