<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::orderBy('level', 'desc')->orderBy('exp', 'desc')->get();
        return view('leaderboard.index', compact('users'));
    }
} 