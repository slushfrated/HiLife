<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $allAchievements = Achievement::all();
        $userAchievements = auth()->user()->achievements->keyBy('id');
        $completedQuests = auth()->user()->tasks()->where('is_completed', true)->count();
        $userLevel = auth()->user()->level;

        return view('achievements.index', compact('allAchievements', 'userAchievements', 'completedQuests', 'userLevel'));
    }

    public function claim(Request $request, Achievement $achievement)
    {
        $user = $request->user();
        $pivot = $user->achievements()->where('achievement_id', $achievement->id)->first()?->pivot;
        if (!$pivot || $pivot->claimed_at) {
            session()->flash('warning', 'You have already claimed this achievement!');
            return redirect()->back();
        }
        // Mark as claimed
        $user->achievements()->updateExistingPivot($achievement->id, [
            'claimed_at' => now()
        ]);

        $rewards = [];
        // Unlock Avatar Frame
        $frame = \App\Models\AvatarFrame::where('achievement_id', $achievement->id)->first();
        if ($frame && !$user->unlockedFrames()->where('avatar_frame_id', $frame->id)->exists()) {
            $user->unlockedFrames()->attach($frame->id);
            $rewards['frame'] = $frame;
        }
        // Unlock Theme
        $theme = \App\Models\Theme::where('unlock_requirement', 'Unlock by completing ' . $achievement->name)->first();
        if ($theme && !$user->themes()->where('theme_id', $theme->id)->exists()) {
            $user->themes()->attach($theme->id);
            $rewards['theme'] = $theme;
        }
        // Pass rewards to session for modal
        if (!empty($rewards)) {
            session()->flash('rewards', $rewards);
        session()->flash('success', 'Achievement claimed: ' . $achievement->name . '!');
        } else {
            session()->flash('info', 'Achievement claimed, but no new rewards to unlock.');
        }
        return redirect()->back();
    }
} 