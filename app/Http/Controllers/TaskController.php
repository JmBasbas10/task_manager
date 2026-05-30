<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->tasks()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(10)->withQueryString();

        $user   = Auth::user();
        $stats  = [
            'total'       => $user->tasks()->count(),
            'todo'        => $user->tasks()->where('status', 'todo')->count(),
            'in_progress' => $user->tasks()->where('status', 'in_progress')->count(),
            'done'        => $user->tasks()->where('status', 'done')->count(),
            'overdue'     => $user->tasks()
                                ->where('status', '!=', 'done')
                                ->whereNotNull('due_date')
                                ->whereDate('due_date', '<', now())
                                ->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:todo,in_progress,done'],
            'priority'    => ['required', 'in:low,medium,high'],
            'due_date'    => ['nullable', 'date'],
        ]);

        Auth::user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $this->checkOwnership($task);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->checkOwnership($task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->checkOwnership($task);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:todo,in_progress,done'],
            'priority'    => ['required', 'in:low,medium,high'],
            'due_date'    => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->checkOwnership($task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->checkOwnership($task);
        $request->validate(['status' => ['required', 'in:todo,in_progress,done']]);
        $task->update(['status' => $request->status]);
        return back()->with('success', 'Status updated.');
    }

    private function checkOwnership(Task $task): void
    {
        abort_if($task->user_id !== Auth::id(), 403);
    }
}
