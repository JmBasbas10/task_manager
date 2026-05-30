@extends('layouts.app')
@section('title', 'New Task')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Create New Task</h4>
        <p class="text-muted small mb-0">Fill in the details below</p>
    </div>
    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Tasks
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        @include('tasks._form')
    </div>
</div>
@endsection
