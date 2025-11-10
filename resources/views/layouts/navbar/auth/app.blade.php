<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('argon/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('argon/assets/img/favicon.png') }}">
    <title>Toko Online</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Argon CSS -->
    <link href="{{ asset('argon/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('argon/assets/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="{{ $class ?? '' }}">
    {{-- BAGIAN TAMPILAN UNTUK GUEST (belum login) --}}
    @guest
        @yield('content')
    @endguest

    {{-- BAGIAN UNTUK USER LOGIN --}}
    @auth
        @if (in_array(request()->route()->getName(), ['login', 'register', 'sign-in-static', 'sign-up-static']))
            {{-- Halaman login/register tanpa sidebar --}}
            @yield('content')
        @else
            {{-- Background header --}}
            <div class="min-height-300 bg-primary position-absolute w-100"></div>

            {{-- Sidebar --}}
            @if (auth()->user()->role === 'admin')

            @include('layouts.navbar.auth.sidenav')
            @endif

            {{-- Main content --}}
            <main class="main-content border-radius-lg">
                {{-- Navbar --}}
                @include('layouts.navbar.auth.topnav')

                {{-- Konten utama halaman --}}
                <div class="container-fluid py-4">
                    @yield('content')
                </div>
            </main>

            {{-- Plugin tambahan (optional) --}}
            @include('components.fixed-plugin')
        @endif
    @endauth

    <!-- Core JS -->
    <script src="{{ asset('argon/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = { damping: '0.5' }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Argon JS -->
    <script src="{{ asset('argon/assets/js/argon-dashboard.js') }}"></script>
    @stack('js')
</body>

</html>
