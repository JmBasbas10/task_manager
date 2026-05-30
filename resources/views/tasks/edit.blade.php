@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Edit Task</h4>
        <p class="text-muted small mb-0">Update the task details</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-eye me-1"></i>View
        </a>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        @include('tasks._form', ['task' => $task])
    </div>
</div>
@endsection
