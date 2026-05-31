@extends('layouts.app')
@section('title', $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">User Details</h4>
        <p class="text-muted small mb-0">Viewing account #{{ $user->id }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body p-4">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                         class="rounded-circle mb-3 border"
                         style="width:100px;height:100px;object-fit:cover;" alt="">
                @else
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle"
                         style="width:100px;height:100px;font-size:2.5rem;font-weight:700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                    {{ ucfirst($user->role) }}
                </span>
                <hr>
                <div class="d-flex justify-content-around">
                    <div><div class="fw-bold fs-5">{{ $tasks->count() }}</div><div class="text-muted small">Total Tasks</div></div>
                    <div><div class="fw-bold fs-5">{{ $tasks->where('status', 'done')->count() }}</div><div class="text-muted small">Done</div></div>
                </div>
                <hr>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar3 me-1"></i>Joined {{ $user->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 fw-bold">Tasks by this user</div>
            <div class="card-body p-0">
                @if($tasks->isEmpty())
                    <div class="text-center py-4 text-muted">No tasks yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Title</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $task->title }}</td>
                                    <td>
                                        @if($task->priority == 'high') <span class="badge bg-danger">High</span>
                                        @elseif($task->priority == 'medium') <span class="badge bg-warning text-dark">Medium</span>
                                        @else <span class="badge bg-success">Low</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $sColor = ['todo'=>'secondary','in_progress'=>'primary','done'=>'success'][$task->status]; $sLabel = ['todo'=>'To Do','in_progress'=>'In Progress','done'=>'Done'][$task->status]; @endphp
                                        <span class="badge bg-{{ $sColor }}">{{ $sLabel }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
