@extends('layouts.auth')
@section('title', 'Register')
@section('subtitle', 'Create a new account')

@section('content')
<h5 class="mb-3">Register</h5>

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name') }}" required autofocus>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control"
               value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Create Account</button>
</form>

<hr>
<p class="text-center mb-0">
    Already have an account? <a href="{{ route('login') }}">Login here</a>
</p>
@endsection
