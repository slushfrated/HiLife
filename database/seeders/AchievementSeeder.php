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
            'name' => 'Rookie',
        ], [
            'description' => 'Complete your first quest.',
            'icon' => 'checkmark',
            'type' => 'quests',
            'target' => 1
        ]);
        Achievement::firstOrCreate([
            'name' => 'Quest Novice',
        ], [
            'description' => 'Complete 10 quests.',
            'icon' => 'bronze-medal',
            'type' => 'quests',
            'target' => 10
        ]);
        Achievement::firstOrCreate([
            'name' => 'Quest Master',
        ], [
            'description' => 'Complete 25 quests.',
            'icon' => 'trophy',
            'type' => 'quests',
            'target' => 25
        ]);
        Achievement::firstOrCreate([
            'name' => 'Rising Star',
        ], [
            'description' => 'Reach level 2.',
            'icon' => 'arrow-up',
            'type' => 'level',
            'target' => 2
        ]);
        Achievement::firstOrCreate([
            'name' => 'Veteran',
        ], [
            'description' => 'Reach level 10.',
            'icon' => 'shield',
            'type' => 'level',
            'target' => 10
        ]);
        Achievement::firstOrCreate([
            'name' => 'Streak Keeper',
        ], [
            'description' => 'Maintain a streak for 7 days in a row.',
            'icon' => 'fire',
            'type' => 'streak',
            'target' => 7
        ]);
    }
}
