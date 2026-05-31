@extends('layouts.app')
@section('title', $task->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Task Details</h4>
    <div>
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5>{{ $task->title }}</h5>

        @php
            $statusLabels   = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
            $statusColors   = ['todo' => 'secondary', 'in_progress' => 'primary', 'done' => 'success'];
            $priorityColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger'];
        @endphp

        <span class="badge bg-{{ $statusColors[$task->status] }}">
            {{ $statusLabels[$task->status] }}
        </span>
        <span class="badge bg-{{ $priorityColors[$task->priority] }} {{ $task->priority == 'medium' ? 'text-dark' : '' }}">
            {{ ucfirst($task->priority) }} Priority
        </span>
        @if($task->isOverdue())
            <span class="badge bg-danger">Overdue</span>
        @endif

        <hr>

        <p><strong>Description:</strong><br>
            {{ $task->description ?? 'No description provided.' }}
        </p>

        <p><strong>Due Date:</strong>
            {{ $task->due_date ? $task->due_date->format('F d, Y') : 'No due date set' }}
        </p>

        <p class="text-muted small mb-0">
            Created: {{ $task->created_at->format('M d, Y') }} &nbsp;|&nbsp;
            Last updated: {{ $task->updated_at->diffForHumans() }}
        </p>
    </div>
</div>

{{-- Quick Status Change --}}
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6>Change Status</h6>
        <div class="d-flex gap-2">
            @foreach(['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $val => $label)
                <form action="{{ route('tasks.status', $task) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $val }}">
                    <button type="submit"
                            class="btn btn-sm {{ $task->status == $val ? 'btn-dark' : 'btn-outline-secondary' }}"
                            {{ $task->status == $val ? 'disabled' : '' }}>
                        {{ $label }}
                    </button>
                </form>
            @endforeach
        </div>
    </div>
</div>

{{-- Delete --}}
<div class="card border-danger shadow-sm">
    <div class="card-body">
        <h6 class="text-danger">Delete Task</h6>
        <p class="text-muted small">This action cannot be undone.</p>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this task?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete Task</button>
        </form>
    </div>
</div>
@endsection
