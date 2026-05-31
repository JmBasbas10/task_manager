@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">My Profile</h4>
        <p class="text-muted small mb-0">Manage your account information</p>
    </div>
    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Tasks
    </a>
</div>

<div class="row g-4">
    {{-- Avatar Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center" style="border-radius: 12px;">
            <div class="card-body p-4">
                {{-- Avatar Display --}}
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                         class="rounded-circle mb-3 border"
                         style="width: 100px; height: 100px; object-fit: cover;"
                         alt="Profile Picture">
                @else
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle"
                         style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                <p class="text-muted small">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'primary' }} mb-3">
                    {{ ucfirst($user->role) }}
                </span>

                {{-- Avatar Upload --}}
                <hr>
                <p class="text-muted small mb-2">Update profile picture</p>
                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm @error('avatar') is-invalid @enderror"
                               accept="image/*" required>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-upload me-1"></i>Upload Photo
                    </button>
                </form>

                <hr>
                <div class="d-flex justify-content-around text-center">
                    <div>
                        <div class="fw-bold fs-5">{{ $user->tasks()->count() }}</div>
                        <div class="text-muted small">Total</div>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $user->tasks()->where('status', 'done')->count() }}</div>
                        <div class="text-muted small">Done</div>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $user->tasks()->where('status', 'in_progress')->count() }}</div>
                        <div class="text-muted small">Active</div>
                    </div>
                </div>
                <hr>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar3 me-1"></i>
                    Member since {{ $user->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-8 d-flex flex-column gap-4">
        {{-- Update Profile --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1">Profile Information</h6>
                <p class="text-muted small mb-4">Update your name and email address.</p>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Full Name</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium">Email Address</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i>Save Changes
                    </button>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1">Change Password</h6>
                <p class="text-muted small mb-4">Make sure to use a strong password.</p>

                @if($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-danger py-2 small">
                        {{ $errors->first('current_password') ?: $errors->first('password') }}
                    </div>
                @endif

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-medium">Current Password</label>
                        <input type="password" id="current_password" name="current_password"
                               class="form-control" placeholder="Enter current password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">New Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control" placeholder="Min. 8 characters">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" placeholder="Re-enter new password">
                    </div>

                    <button type="submit" class="btn btn-warning px-4">
                        <i class="bi bi-shield-lock me-1"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
