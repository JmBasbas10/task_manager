@extends('layouts.app')
@section('title', 'My Tasks')

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-clipboard2-check"></i></div>
                <div><div class="fs-4 fw-bold lh-1">{{ $stats['total'] }}</div><div class="text-muted small">Total</div></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-circle"></i></div>
                <div><div class="fs-4 fw-bold lh-1">{{ $stats['todo'] }}</div><div class="text-muted small">To Do</div></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-arrow-clockwise"></i></div>
                <div><div class="fs-4 fw-bold lh-1">{{ $stats['in_progress'] }}</div><div class="text-muted small">In Progress</div></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check2-circle"></i></div>
                <div><div class="fs-4 fw-bold lh-1">{{ $stats['done'] }}</div><div class="text-muted small">Done</div></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-exclamation-circle"></i></div>
                <div><div class="fs-4 fw-bold lh-1">{{ $stats['overdue'] }}</div><div class="text-muted small">Overdue</div></div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
@if($stats['total'] > 0)
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Task Status Overview</h6>
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Tasks by Priority</h6>
                <canvas id="priorityChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Filters + Table --}}
<div class="card table-card shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <form action="{{ route('tasks.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search tasks…" value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="todo"        {{ request('status') === 'todo'        ? 'selected' : '' }}>To Do</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Done</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="priority" class="form-select form-select-sm">
                    <option value="">All Priorities</option>
                    <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="col-auto ms-md-auto">
                <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm px-3">
                    <i class="bi bi-plus-lg me-1"></i>New Task
                </a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($tasks->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No tasks found</h5>
                <p class="text-muted small">
                    @if(request()->hasAny(['search','status','priority']))
                        Try adjusting your filters.
                    @else
                        Get started by creating your first task.
                    @endif
                </p>
                @if(!request()->hasAny(['search','status','priority']))
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Create Task
                    </a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr class="{{ $task->isOverdue() ? 'table-danger bg-opacity-25' : '' }}">
                            <td class="ps-4">
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none fw-medium text-dark">
                                    {{ $task->title }}
                                </a>
                                @if($task->isOverdue())
                                    <span class="badge bg-danger ms-1 small">Overdue</span>
                                @endif
                                @if($task->description)
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">{{ $task->description }}</div>
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
                                @php
                                    $sColor = ['todo' => 'secondary', 'in_progress' => 'primary', 'done' => 'success'][$task->status];
                                    $sLabel = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'][$task->status];
                                @endphp
                                <span class="badge bg-{{ $sColor }}">{{ $sLabel }}</span>
                            </td>
                            <td>
                                @if($task->due_date)
                                    <span class="{{ $task->isOverdue() ? 'text-danger fw-medium' : 'text-muted' }} small">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $task->due_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                          onsubmit="return confirm('Delete this task?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($tasks->hasPages())
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <small class="text-muted">
                        Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
                    </small>
                    {{ $tasks->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection

@section('scripts')
@if($stats['total'] > 0)
<script>
    // Status Doughnut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['To Do', 'In Progress', 'Done'],
            datasets: [{
                data: [{{ $stats['todo'] }}, {{ $stats['in_progress'] }}, {{ $stats['done'] }}],
                backgroundColor: ['#6c757d', '#0d6efd', '#198754'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Priority Bar Chart
    new Chart(document.getElementById('priorityChart'), {
        type: 'bar',
        data: {
            labels: ['Low', 'Medium', 'High'],
            datasets: [{
                label: 'Tasks',
                data: [{{ $stats['low'] }}, {{ $stats['medium'] }}, {{ $stats['high'] }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endif
@endsection
