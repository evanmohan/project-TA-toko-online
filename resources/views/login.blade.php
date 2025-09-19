<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 25rem;">
        <h3 class="text-center mb-3">Login</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <button class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-3 text-center">
            Belum punya akun? <a href="{{ route('register.form') }}">Register</a>
        </div>
    </div>
</body>
</html>
