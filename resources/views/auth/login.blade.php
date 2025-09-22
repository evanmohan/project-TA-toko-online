@extends('layout')

@section('content')
<h3>Login</h3>
@if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
<form method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary">Login</button>
    <a href="{{ route('register') }}">Register</a>
</form>
@endsection
