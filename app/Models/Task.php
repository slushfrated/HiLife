<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'is_completed', 'completed_at', 'source', 'deadline', 'priority', 'exp', 'due_date', 'due_time', 'duration_minutes'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'due_date' => 'date',
        'due_time' => 'datetime',
        'duration_minutes' => 'integer',
        'completed_at' => 'datetime'
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
        $randomQuests = $systemQuests->count() > 0 ? $systemQuests->random(min(3, $systemQuests->count())) : collect();
        foreach ($randomQuests as $quest) {
            self::create([
                'title' => $quest->title,
                'description' => $quest->description,
                'user_id' => $user->id,
                'source' => 'system',
                'deadline' => $quest->deadline,
                'is_completed' => false,
                'completed_at' => null
            ]);
        }
    }

    public function getFormattedDueDateAttribute()
    {
        if (!$this->due_date) {
            return 'No due date';
        }
        if ($this->due_time) {
            return $this->due_date->format('M d, Y') . ' at ' . $this->due_time->format('g:i A');
        }
        return $this->due_date->format('M d, Y');
    }

    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) return null;
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
        }
        return $minutes . 'm';
    }
}
