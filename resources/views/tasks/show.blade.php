@extends('layouts.app')
@section('title', $task->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Task Details</h4>
        <p class="text-muted small mb-0">Viewing task #{{ $task->id }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-2">{{ $task->title }}</h3>

                @php
                    $sColor = ['todo' => 'secondary', 'in_progress' => 'primary', 'done' => 'success'][$task->status];
                    $sLabel = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'][$task->status];
                    $pColor = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger'][$task->priority];
                @endphp

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-{{ $sColor }} fs-6 px-3 py-2">{{ $sLabel }}</span>
                    <span class="badge bg-{{ $pColor }} fs-6 px-3 py-2 {{ $task->priority == 'medium' ? 'text-dark' : '' }}">
                        {{ ucfirst($task->priority) }} Priority
                    </span>
                    @if($task->isOverdue())
                        <span class="badge bg-danger fs-6 px-3 py-2">
                            <i class="bi bi-exclamation-circle me-1"></i>Overdue
                        </span>
                    @endif
                </div>

                <h6 class="text-muted text-uppercase small fw-bold mb-2">Description</h6>
                <p class="lh-lg mb-0">
                    {{ $task->description ?? 'No description provided.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Meta info --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Details</h6>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar3 text-muted"></i>
                        <span class="text-muted small">Due Date</span>
                        <span class="ms-auto fw-medium small {{ $task->isOverdue() ? 'text-danger' : '' }}">
                            {{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}
                        </span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock text-muted"></i>
                        <span class="text-muted small">Created</span>
                        <span class="ms-auto fw-medium small">{{ $task->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-muted"></i>
                        <span class="text-muted small">Updated</span>
                        <span class="ms-auto fw-medium small">{{ $task->updated_at->diffForHumans() }}</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Quick status change --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Change Status</h6>
                <div class="d-flex flex-column gap-2">
                    @foreach(['todo' => ['To Do', 'secondary'], 'in_progress' => ['In Progress', 'primary'], 'done' => ['Done', 'success']] as $val => [$label, $color])
                        <form action="{{ route('tasks.status', $task) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $val }}">
                            <button type="submit"
                                class="btn btn-{{ $task->status === $val ? $color : 'outline-'.$color }} btn-sm w-100 text-start"
                                {{ $task->status === $val ? 'disabled' : '' }}>
                                <i class="bi bi-{{ $val === 'todo' ? 'circle' : ($val === 'in_progress' ? 'arrow-clockwise' : 'check2-circle') }} me-2"></i>
                                {{ $label }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="card border-0 shadow-sm border border-danger border-opacity-25" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="text-danger text-uppercase small fw-bold mb-3">Danger Zone</h6>
                <button type="button" class="btn btn-outline-danger btn-sm w-100"
                    onclick="confirmDelete('{{ route('tasks.destroy', $task) }}', 'Permanently delete &quot;{{ addslashes($task->title) }}&quot;? This cannot be undone.')">
                    <i class="bi bi-trash me-1"></i>Delete This Task
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
