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
        'current_theme_id',
        'profile_picture',
        'current_title_achievement_id',
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
            ->withPivot('unlocked_at', 'progress', 'claimed_at')
            ->withTimestamps();
    }

    public function titles()
    {
        return $this->belongsToMany(Title::class, 'user_titles')
            ->withPivot('is_selected')
            ->withTimestamps();
    }

    public function currentTitleAchievement()
    {
        return $this->belongsTo(Achievement::class, 'current_title_achievement_id');
    }

    public function checkAndUnlockAchievements()
    {
        // Quest achievements
        $completedQuests = $this->tasks()->where('is_completed', true)->count();
        $totalQuests = $this->tasks()->count();
        $questAchievements = \App\Models\Achievement::where('type', 'quests')->get();
        
        foreach ($questAchievements as $achievement) {
            $progress = $completedQuests;
            $alreadyUnlocked = $this->achievements()->where('achievement_id', $achievement->id)->exists();
            if (!$alreadyUnlocked && $progress >= $achievement->target) {
                $this->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                    'progress' => $progress
                ]);
                return $achievement;
            } else if ($alreadyUnlocked) {
                $this->achievements()->updateExistingPivot($achievement->id, [
                    'progress' => $progress
                ]);
            }
        }
        
        // Level achievements
        $levelAchievements = \App\Models\Achievement::where('type', 'level')->get();
        foreach ($levelAchievements as $achievement) {
            $progress = $this->level;
            $alreadyUnlocked = $this->achievements()->where('achievement_id', $achievement->id)->exists();
            if (!$alreadyUnlocked && $progress >= $achievement->target) {
                $this->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                    'progress' => $progress
                ]);
                return $achievement;
            } elseif ($alreadyUnlocked) {
                $this->achievements()->updateExistingPivot($achievement->id, [
                    'progress' => $progress
                ]);
            }
        }

        // Streak achievements
        $streakAchievements = \App\Models\Achievement::where('type', 'streak')->get();
        foreach ($streakAchievements as $achievement) {
            $progress = $this->current_streak;
            $alreadyUnlocked = $this->achievements()->where('achievement_id', $achievement->id)->exists();
            if (!$alreadyUnlocked && $progress >= $achievement->target) {
                $this->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                    'progress' => $progress
                ]);
                return $achievement;
            } else if ($alreadyUnlocked) {
                $this->achievements()->updateExistingPivot($achievement->id, [
                    'progress' => $progress
                ]);
            }
        }

        return null;
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'current_theme_id');
    }

    public function themes()
    {
        return $this->belongsToMany(\App\Models\Theme::class, 'user_themes', 'user_id', 'theme_id')->withTimestamps();
    }

    public function unlockedFrames()
    {
        return $this->belongsToMany(\App\Models\AvatarFrame::class, 'user_avatar_frames')->withTimestamps();
    }

    public function currentFrame()
    {
        return $this->belongsTo(\App\Models\AvatarFrame::class, 'avatar_frame');
    }

    // Helper to persist achievement notification across multiple requests
    public static function persistAchievementNotification($user) {
        $pivot = $user->achievements()->whereNotNull('unlocked_at')->latest('pivot_unlocked_at')->first()?->pivot;
        if ($pivot) {
            $achievement = $user->achievements()->find($pivot->achievement_id);
            if ($achievement) {
                session(['achievement_unlocked' => [
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'icon' => $achievement->icon
                ]]);
            }
        }
    }
}
