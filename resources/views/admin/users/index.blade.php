@extends('layouts.app')
@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">User Management</h4>
        <p class="text-muted small mb-0">Manage all registered users</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Add User
    </a>
</div>

<div class="card table-card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tasks</th>
                        <th>Joined</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->avatar)
                                    <img src="{{ asset($user->avatar) }}"
                                         class="rounded-circle" style="width:32px;height:32px;object-fit:cover;" alt="">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle fw-bold"
                                         style="width:32px;height:32px;font-size:.85rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="fw-medium">{{ $user->name }}</span>
                                @if($user->id === Auth::id())
                                    <span class="badge bg-secondary small">You</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-muted small">{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $user->tasks_count }}</span></td>
                        <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== Auth::id() && $user->role !== 'admin')
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                                    onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}', 'Delete user {{ addslashes($user->name) }}? All their tasks will also be deleted.')">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                <small class="text-muted">Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users</small>
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
