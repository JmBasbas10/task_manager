@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<h4 class="fw-bold mb-1">Welcome back</h4>
<p class="text-muted small mb-4">Sign in to your account to continue</p>

@if($errors->any())
    <div class="alert alert-danger py-2 small">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ $errors->first() }}
    </div>
@endif

<form action="{{ route('login') }}" method="POST" novalidate>
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label fw-medium">Email address</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-envelope text-muted"></i>
            </span>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                   placeholder="you@example.com" autofocus required>
        </div>
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label for="password" class="form-label fw-medium mb-0">Password</label>
        </div>
        <div class="input-group mt-1">
            <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-lock text-muted"></i>
            </span>
            <input type="password" id="password" name="password"
                   class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                   placeholder="••••••••" required>
        </div>
    </div>

    <div class="mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label text-muted small" for="remember">Remember me</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
        <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
    </button>
</form>

<hr class="my-4">
<p class="text-center text-muted small mb-0">
    Don't have an account?
    <a href="{{ route('register') }}" class="fw-medium text-decoration-none">Create one</a>
</p>
@endsection
