<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'exp',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function note()
    {
        return $this->hasOne(Note::class);
    }

    public function addExp($amount)
    {
        $this->exp += $amount;
        
        // Level up if enough EXP
        $expNeeded = $this->level * 100; // 100 EXP per level
        if ($this->exp >= $expNeeded) {
            $this->level++;
            $this->exp -= $expNeeded;
        }
        
        $this->save();
    }

    public function getExpProgress()
    {
        $expNeeded = $this->level * 100;
        return ($this->exp / $expNeeded) * 100;
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class)
            ->withPivot('unlocked_at', 'progress')
            ->withTimestamps();
    }

    public function checkAndUnlockAchievements()
    {
        // Quest achievements
        $completedQuests = $this->tasks()->where('is_completed', true)->count();
        $questAchievements = \App\Models\Achievement::where('type', 'quests')->get();
        foreach ($questAchievements as $achievement) {
            $alreadyUnlocked = $this->achievements()->where('achievement_id', $achievement->id)->exists();
            if (!$alreadyUnlocked && $completedQuests >= $achievement->target) {
                $this->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                    'progress' => $completedQuests
                ]);
            } elseif ($alreadyUnlocked) {
                // Optionally update progress
                $this->achievements()->updateExistingPivot($achievement->id, [
                    'progress' => $completedQuests
                ]);
            }
        }
        // Level achievements
        $levelAchievements = \App\Models\Achievement::where('type', 'level')->get();
        foreach ($levelAchievements as $achievement) {
            $alreadyUnlocked = $this->achievements()->where('achievement_id', $achievement->id)->exists();
            if (!$alreadyUnlocked && $this->level >= $achievement->target) {
                $this->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                    'progress' => $this->level
                ]);
            } elseif ($alreadyUnlocked) {
                // Optionally update progress
                $this->achievements()->updateExistingPivot($achievement->id, [
                    'progress' => $this->level
                ]);
            }
        }
    }
}
