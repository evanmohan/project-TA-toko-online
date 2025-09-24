<!DOCTYPE html>
<html>
<head>
    <title>Toko Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <a href="{{ route('admin.dashboard') }}">toko online</a>
        @auth
        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        @endauth
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
