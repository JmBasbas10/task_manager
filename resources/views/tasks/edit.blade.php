@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Edit Task</h4>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @include('tasks._form', ['task' => $task])
    </div>
</div>
@endsection
