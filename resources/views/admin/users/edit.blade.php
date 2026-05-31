@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Edit User</h4>
        <p class="text-muted small mb-0">Editing account for {{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Full Name</label>
                <input type="text" id="name" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email Address</label>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label fw-medium">Role</label>
                <select id="role" name="role" class="form-select">
                    <option value="user"  {{ $user->role == 'user'  ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <hr>
            <p class="text-muted small">Leave password fields blank to keep the current password.</p>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="password" class="form-label fw-medium">New Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control" placeholder="Min. 8 characters">
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control">
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-1"></i>Save Changes
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
        </form>
    </div>
</div>
@endsection
