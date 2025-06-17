<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('quests');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0|max:59'
        ]);

        $duration = null;
        if ($request->filled('duration_hours') || $request->filled('duration_minutes')) {
            $duration = ($request->duration_hours ?? 0) * 60 + ($request->duration_minutes ?? 0);
        }

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'duration_minutes' => $duration,
            'priority' => $request->priority,
            'source' => 'user'
        ]);

        // Update achievements after adding a quest
        $user = auth()->user();
        $achievement = $user->checkAndUnlockAchievements();
        if ($achievement) {
            session(['achievement_unlocked' => [
                'name' => $achievement->name,
                'description' => $achievement->description,
                'icon' => $achievement->icon
            ]]);
        }

        return redirect()->back()->with('success', 'Quest created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorizeTask($task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        // Handle quest completion
        if ($request->has('is_completed')) {
            if (!$task->is_completed) {
                $task->is_completed = true;
                $task->completed_at = now();
                $task->save();
                // Add EXP for completing a task
                $user = Auth::user();
                $user->addExp(50); // 50 EXP per completed task
                $user->refresh();
                $this->updateUserStreak($user);
                $achievement = $user->checkAndUnlockAchievements();
                if ($achievement) {
                    session(['achievement_unlocked' => [
                        'name' => $achievement->name,
                        'description' => $achievement->description,
                        'icon' => $achievement->icon
                    ]]);
                }
                session()->flash('just_completed_task', true);
                session()->flash('just_completed_task_id', $task->id);
            }
            $redirect = $request->input('redirect_to') === 'quests' ? route('quests') : route('dashboard');
            return redirect($redirect)->with('quest_notification', ['message' => 'Quest completed!', 'color' => '#8fc97a']);
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0|max:59',
            'priority' => 'required|in:low,medium,high'
        ];

        $validated = $request->validate($rules);

        $duration = null;
        if ($request->filled('duration_hours') || $request->filled('duration_minutes')) {
            $duration = ($request->duration_hours ?? 0) * 60 + ($request->duration_minutes ?? 0);
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'],
            'due_time' => $validated['due_time'] ?? null,
            'duration_minutes' => $duration,
            'priority' => $validated['priority'],
        ]);

        $redirect = $request->input('redirect_to') === 'quests' ? route('quests') : route('dashboard');
        return redirect($redirect)->with('quest_notification', ['message' => 'Task updated!', 'color' => '#7aa2f7']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        $redirect = request('redirect_to') === 'quests' ? route('quests') : route('dashboard');
        return redirect($redirect)->with('quest_notification', ['message' => 'Quest deleted!', 'color' => '#e74c3c']);
    }

    /**
     * Ensure the task belongs to the authenticated user.
     */
    protected function authorizeTask(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
    }

    public function quests()
    {
        $activeTasks = Auth::user()->tasks()
            ->where('is_completed', false)
            ->orderBy('due_date')
            ->orderBy('due_time')
            ->get();
        $completedTasks = Auth::user()->tasks()
            ->where('is_completed', true)
            ->latest('completed_at')
            ->get();
        return view('tasks.quests', compact('activeTasks', 'completedTasks'));
    }

    public function complete(Task $task)
    {
        $this->authorizeTask($task);
        if (!$task->is_completed) {
            $task->is_completed = true;
            $task->completed_at = now();
            $task->save();
            // Add EXP for completing a task
            $user = Auth::user();
            $user->addExp(50); // 50 EXP per completed task
            $user->refresh();
            $this->updateUserStreak($user);
            $achievement = $user->checkAndUnlockAchievements();
            if ($achievement) {
                session(['achievement_unlocked' => [
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'icon' => $achievement->icon
                ]]);
            }
            session()->flash('just_completed_task', true);
            session()->flash('just_completed_task_id', $task->id);
        }
        return redirect()->route('dashboard')->with('quest_notification', ['message' => 'Quest completed!', 'color' => '#8fc97a']);
    }

    /**
     * Update user's streak.
     */
    private function updateUserStreak($user)
    {
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();
        if ($user->last_streak_date === $today) {
            return;
        }
        if ($user->last_streak_date === $yesterday) {
            $user->current_streak += 1;
        } else {
            $user->current_streak = 1;
        }
        $user->last_streak_date = $today;
        if ($user->current_streak > $user->longest_streak) {
            $user->longest_streak = $user->current_streak;
        }
        $user->save();
    }
}
