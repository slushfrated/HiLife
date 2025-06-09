<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'is_completed', 'completed_at', 'source', 'deadline', 'priority', 'exp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function assignSystemQuestsToUser($user)
    {
        $systemQuests = self::where('source', 'system')->whereNull('user_id')->get();
        // Delete previous system quests for this user (shouldn't be any on new user, but safe)
        self::where('user_id', $user->id)->where('source', 'system')->delete();
        $randomQuests = $systemQuests->count() > 0 ? $systemQuests->random(min(4, $systemQuests->count())) : collect();
        foreach ($randomQuests as $quest) {
            self::create([
                'title' => $quest->title,
                'description' => $quest->description,
                'user_id' => $user->id,
                'source' => 'system',
                'deadline' => $quest->deadline,
            ]);
        }
    }
}
