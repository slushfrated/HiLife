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
} 