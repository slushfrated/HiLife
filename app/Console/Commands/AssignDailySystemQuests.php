<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class AssignDailySystemQuests extends Command
{
    protected $signature = 'quests:assign-daily-system';
    protected $description = 'Assign 4 random system quests to each user every day, resetting previous system quests.';

    public function handle()
    {
        $systemQuests = Task::where('source', 'system')->whereNull('user_id')->get();
        $users = User::all();
        foreach ($users as $user) {
            // Delete previous system quests for this user
            Task::where('user_id', $user->id)->where('source', 'system')->delete();
            // Pick 4 random system quests
            $randomQuests = $systemQuests->random(min(3, $systemQuests->count()));
            foreach ($randomQuests as $quest) {
                Task::create([
                    'title' => $quest->title,
                    'description' => $quest->description,
                    'user_id' => $user->id,
                    'source' => 'system',
                ]);
            }
        }
        $this->info('Assigned 3 random system quests to each user.');
    }
} 