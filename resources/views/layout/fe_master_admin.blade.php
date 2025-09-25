<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tipografia -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS e Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">


    <!-- JS -->
    <script src="{{ asset('assets/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>
<body>

    <!-- Wrapper principal -->
    <div class="dashboard-wrapper">

        <!-- Navbar do Admin -->
        <header class="dash-navbar">
            <div class="navbar-brand">
                <a href="{{ url('/dashboard-admin') }}">
                    <img src="{{ asset('images/moodx.png') }}" alt="mood.x logo" style="height: 24px;">
                </a>
            </div>

            <div class="navbar-actions">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-black">Logout</button>
                </form>
            </div>

            <!-- Ícone hamburguer mobile -->
            <div class="hamburger" onclick="toggleMobileMenu()">☰</div>
        </header>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="mobile-menu">
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn-mobile">Logout</button>
            </form>
        </div>

        <!-- Conteúdo da página -->
        <div class="dashboard-content">
            @yield('content')
        </div>

    </div>

    @stack('scripts')
</body>
</html>
