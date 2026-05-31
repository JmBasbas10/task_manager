@extends('layouts.app')
@section('title', 'My Tasks')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>My Tasks</h4>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">+ Add Task</a>
</div>

{{-- Summary --}}
<div class="row mb-3">
    <div class="col">
        <div class="card text-center">
            <div class="card-body py-2">
                <strong>{{ $stats['total'] }}</strong><br><small class="text-muted">Total</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center">
            <div class="card-body py-2">
                <strong>{{ $stats['todo'] }}</strong><br><small class="text-muted">To Do</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center">
            <div class="card-body py-2">
                <strong>{{ $stats['in_progress'] }}</strong><br><small class="text-muted">In Progress</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center">
            <div class="card-body py-2">
                <strong>{{ $stats['done'] }}</strong><br><small class="text-muted">Done</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-center border-danger">
            <div class="card-body py-2">
                <strong class="text-danger">{{ $stats['overdue'] }}</strong><br><small class="text-muted">Overdue</small>
            </div>
        </div>
    </div>
</div>

{{-- Filters --}}
<form action="{{ route('tasks.index') }}" method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control form-control-sm"
               placeholder="Search by title..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select form-select-sm">
            <option value="">All Status</option>
            <option value="todo"        {{ request('status') == 'todo'        ? 'selected' : '' }}>To Do</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="done"        {{ request('status') == 'done'        ? 'selected' : '' }}>Done</option>
        </select>
    </div>
    <div class="col-md-2">
        <select name="priority" class="form-select form-select-sm">
            <option value="">All Priority</option>
            <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
    </div>
</form>

{{-- Task Table --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        @if($tasks->isEmpty())
            <div class="text-center py-5 text-muted">
                <p>No tasks found.</p>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">Create your first task</a>
            </div>
        @else
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr class="{{ $task->isOverdue() ? 'table-danger' : '' }}">
                        <td>
                            {{ $task->title }}
                            @if($task->isOverdue())
                                <span class="badge bg-danger ms-1">Overdue</span>
                            @endif
                            @if($task->description)
                                <br><small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($task->priority == 'high')
                                <span class="badge bg-danger">High</span>
                            @elseif($task->priority == 'medium')
                                <span class="badge bg-warning text-dark">Medium</span>
                            @else
                                <span class="badge bg-success">Low</span>
                            @endif
                        </td>
                        <td>
                            @if($task->status == 'done')
                                <span class="badge bg-success">Done</span>
                            @elseif($task->status == 'in_progress')
                                <span class="badge bg-primary">In Progress</span>
                            @else
                                <span class="badge bg-secondary">To Do</span>
                            @endif
                        </td>
                        <td>
                            {{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}
                        </td>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($tasks->hasPages())
                <div class="p-3">
                    {{ $tasks->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @endif
    </div>
</div>

<div class="mt-2 text-muted small">
    Showing {{ $tasks->count() }} of {{ $tasks->total() }} tasks
</div>
@endsection
