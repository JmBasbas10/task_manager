@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>My Profile</h4>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>

<div class="row">
    {{-- Account Info --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">Account Information</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <p class="text-muted small">Member since {{ $user->created_at->format('F d, Y') }}</p>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">Change Password</div>
            <div class="card-body">
                @if(session('password_success'))
                    <div class="alert alert-success">{{ session('password_success') }}</div>
                @endif

                @if($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-danger">
                        {{ $errors->first('current_password') ?: $errors->first('password') }}
                    </div>
                @endif

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" id="password"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Task Summary --}}
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">Task Summary</div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col">
                        <h4>{{ $user->tasks()->count() }}</h4>
                        <p class="text-muted mb-0">Total Tasks</p>
                    </div>
                    <div class="col">
                        <h4>{{ $user->tasks()->where('status', 'done')->count() }}</h4>
                        <p class="text-muted mb-0">Completed</p>
                    </div>
                    <div class="col">
                        <h4>{{ $user->tasks()->where('status', 'in_progress')->count() }}</h4>
                        <p class="text-muted mb-0">In Progress</p>
                    </div>
                    <div class="col">
                        <h4>{{ $user->tasks()->where('status', 'todo')->count() }}</h4>
                        <p class="text-muted mb-0">To Do</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
