<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        DB::table('themes')->insert([
            [
                'name' => 'Classic',
                'description' => 'The default warm and friendly theme.',
                'primary_color' => '#b8860b',
                'secondary_color' => '#fdf6d8',
                'background_color' => '#a07a4b',
                'text_color' => '#4b3a2f',
                'achievement_text_color' => '#3a2c1a',
                'preview_image' => null,
                'unlock_requirement' => 'Default',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Night Owl',
                'description' => 'A dark theme for late-night questing.',
                'primary_color' => '#4f8cff',
                'secondary_color' => '#232946',
                'background_color' => '#121629',
                'text_color' => '#eaeaea',
                'achievement_text_color' => '#fff',
                'preview_image' => null,
                'unlock_requirement' => 'Unlock by completing Quest Novice',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Monochrome',
                'description' => 'A modern grayscale theme with green highlights.',
                'primary_color' => '#8fc97a',
                'secondary_color' => '#e0e0e0',
                'background_color' => '#d3d3d3',
                'text_color' => '#222',
                'achievement_text_color' => '#222',
                'preview_image' => null,
                'unlock_requirement' => 'Unlock by completing Quest Master',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
} 