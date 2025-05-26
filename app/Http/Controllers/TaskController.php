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
        $tasks = Auth::user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);
        $task = Auth::user()->tasks()->create($validated);
        return redirect()->route('dashboard')->with('success', 'Task created!');
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
        \Log::info('Update method hit');
        \Log::info('Before validation', $request->all());
        $this->authorizeTask($task);
        // Only validate fields that are present
        $rules = [];
        if ($request->has('title')) {
            $rules['title'] = 'required|string|max:255';
        }
        if ($request->has('description')) {
            $rules['description'] = 'nullable|string';
        }
        if ($request->has('is_completed')) {
            $rules['is_completed'] = 'sometimes|boolean';
        }
        $validated = $request->validate($rules);
        \Log::info('Validated:', $validated);
        \Log::info('Task before:', $task->toArray());
        if (isset($validated['is_completed']) && $validated['is_completed'] && !$task->is_completed) {
            if ($task->source === 'system') {
                $taskId = $task->id;
                $taskTitle = $task->title;
                $user = Auth::user();
                $user->checkAndUnlockAchievements();
                $task->delete();
                session()->flash('just_completed_system_task_id', $taskId);
                session()->flash('just_completed_system_task_title', $taskTitle);
                return redirect()->route('quests')->with('success', 'System quest completed!');
            } else {
                $validated['completed_at'] = now();
                $task->is_completed = true;
                $task->save();
                // Add EXP for completing a task
                $user = Auth::user();
                $user->addExp(50); // 50 EXP per completed task
                $user->refresh(); // Refresh user data
                $user->checkAndUnlockAchievements();
            }
        }
        $task->update($validated);
        \Log::info('Task after:', $task->fresh()->toArray());
        \Log::info('User EXP:', ['exp' => Auth::user()->exp, 'level' => Auth::user()->level]);
        if ($request->is_completed) {
            session()->flash('just_completed_task', true);
            session()->flash('just_completed_task_id', $task->id);
        }
        // Redirect to the correct page
        $referer = $request->headers->get('referer');
        if ($referer && str_contains($referer, '/quests')) {
            return redirect()->route('quests')->with('success', 'Task updated!');
        }
        return redirect()->route('dashboard')->with('success', 'Task updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();
        return redirect()->route('quests')->with('success', 'Task deleted!');
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
            ->where(function($query) {
                $query->where('is_completed', false)
                    ->orWhere(function($q) {
                        $q->where('is_completed', true)
                          ->where('completed_at', '>=', now()->subSeconds(5));
                    });
            })
            ->latest()
            ->get();
        $completedTasks = Auth::user()->tasks()
            ->where('is_completed', true)
            ->where('completed_at', '<', now()->subSeconds(5))
            ->latest('completed_at')
            ->get();
        return view('tasks.quests', compact('activeTasks', 'completedTasks'));
    }
}
