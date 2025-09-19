<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 25rem;">
        <h3 class="text-center mb-3">Register</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
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
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Register</button>
        </form>
        <div class="mt-3 text-center">
            Sudah punya akun? <a href="{{ route('login.form') }}">Login</a>
        </div>
    </div>
</body>
</html>
