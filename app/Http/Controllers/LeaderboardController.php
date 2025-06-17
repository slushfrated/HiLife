<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::with(['achievements' => function($q) {
            $q->whereNotNull('unlocked_at')->orderByDesc('pivot_unlocked_at')->limit(3);
        }])->orderBy('level', 'desc')->orderBy('exp', 'desc')->get();
        $currentUser = null;
        if (auth()->check()) {
            $currentUser = User::with(['achievements' => function($q) {
                $q->whereNotNull('unlocked_at')->orderByDesc('pivot_unlocked_at')->limit(3);
            }])->find(auth()->id());
        }
        return view('leaderboard.index', compact('users', 'currentUser'));
    }
} 