<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Http\Controllers\NoteController;

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
});

Route::middleware(['auth'])->group(function () {
    Route::get('/set-name', [\App\Http\Controllers\NameDecisionController::class, 'show'])->name('name.decision');
    Route::post('/set-name', [\App\Http\Controllers\NameDecisionController::class, 'store'])->name('name.decision.store');
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::get('/quests', [\App\Http\Controllers\TaskController::class, 'quests'])->name('quests');
    Route::post('/notes/update', [NoteController::class, 'update'])->name('notes.update');
});

require __DIR__.'/auth.php';
