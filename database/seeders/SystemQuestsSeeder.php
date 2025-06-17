<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SystemQuestsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'title' => 'Make your bed',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Do light stretching',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Do short workout',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Prepare a nutritious meal',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Respond to emails/messages',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Finish one thing that you\'ve been procrastinating on',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Journaling',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Eat a balanced lunch',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Go outside for fresh air',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Clean your room',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Clean your house',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Organize your stuff',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Spend time on a hobby outside of studies/work',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Drink 8 cups of water',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Write a small personal win',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Read for 10-30 minutes',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Watch or listen to something inspiring',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Learn something new (facts, words, skills)',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Meditate for 10 minutes - 1 hour',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Do a self reflection at night',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Take a relaxing shower/bath',
                'description' => null,
                'source' => 'system',
                'user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
} 