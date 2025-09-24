@extends('layout')

@section('content')
<div class="container mt-5">
    <h3 class="text-center">Login Toko Online</h3>
    <form method="POST" action="{{ url('/login') }}" class="mt-4">
        @csrf
        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
</div>
@endsection
