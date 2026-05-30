@extends('layouts.auth')
@section('title', 'Register')

@section('content')
<h4 class="fw-bold mb-1">Create your account</h4>
<p class="text-muted small mb-4">Join TaskFlow and start managing your tasks</p>

@if($errors->any())
    <div class="alert alert-danger py-2 small">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ $errors->first() }}
    </div>
@endif

<form action="{{ route('register') }}" method="POST" novalidate>
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label fw-medium">Full name</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-person text-muted"></i>
            </span>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}"
                   class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                   placeholder="John Doe" autofocus required>
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-medium">Email address</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-envelope text-muted"></i>
            </span>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                   placeholder="you@example.com" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-medium">Password</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-lock text-muted"></i>
            </span>
            <input type="password" id="password" name="password"
                   class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                   placeholder="Min. 8 characters" required>
        </div>
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-medium">Confirm password</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-lock-fill text-muted"></i>
            </span>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control border-start-0 ps-0"
                   placeholder="Re-enter password" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
        <i class="bi bi-person-plus me-1"></i>Create Account
    </button>
</form>

<hr class="my-4">
<p class="text-center text-muted small mb-0">
    Already have an account?
    <a href="{{ route('login') }}" class="fw-medium text-decoration-none">Sign in</a>
</p>
@endsection
