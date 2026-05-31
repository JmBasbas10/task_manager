@extends('layouts.auth')
@section('title', 'Login')
@section('subtitle', 'Sign in to your account')

@section('content')
<h5 class="mb-3">Login</h5>

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control"
               value="{{ old('email') }}" required autofocus>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>

<hr>
<p class="text-center mb-0">
    Don't have an account? <a href="{{ route('register') }}">Register here</a>
</p>
@endsection
