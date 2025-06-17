<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\TitleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth', 'has.name'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();
        if ($user->last_streak_date !== $today && $user->last_streak_date !== $yesterday) {
            if ($user->current_streak !== 0) {
                $user->current_streak = 0;
                $user->save();
            }
        }
        $tasks = Auth::user()->tasks()->where('is_completed', false)->latest()->get();
        $recentCompleted = null;
        if (session('just_completed_task')) {
            $recentCompleted = Auth::user()->tasks()->where('is_completed', true)->latest('updated_at')->first();
            session()->forget('just_completed_task');
        }
        return view('dashboard', compact('tasks', 'recentCompleted'));
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme');
    Route::get('/profile/{user}', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/title', [ProfileController::class, 'updateTitle'])->name('profile.updateTitle');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/set-name', [\App\Http\Controllers\NameDecisionController::class, 'show'])->name('set-name.form');
    Route::post('/set-name', [\App\Http\Controllers\NameDecisionController::class, 'store'])->name('set-name.store');
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::get('/quests', [\App\Http\Controllers\TaskController::class, 'quests'])->name('quests');
    Route::post('/notes/update', [NoteController::class, 'update'])->name('notes.update');
    Route::get('/leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements');
    Route::post('/tasks/{task}/complete', [\App\Http\Controllers\TaskController::class, 'complete'])->name('tasks.complete');
    Route::post('/achievements/{achievement}/claim', [AchievementController::class, 'claim'])->name('achievements.claim');
    Route::post('/profile/title/select', [TitleController::class, 'select'])->name('profile.title.select');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('dashboard', compact('tasks'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
});

require __DIR__.'/auth.php';
