<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tipografia -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('assets/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/sketchbook-gallery.js') }}" defer></script>
    <script src="{{ asset('js/comments.js') }}" defer></script>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #ffffff;">

    <!-- WRAPPER cinza-claro arredondado -->
    <div class="dashboard-wrapper">

        <!-- NAVBAR universal -->
<header class="dash-navbar">
    <div class="navbar-brand">
        <a href="{{ url('/dashboard') }}">
            <img src="{{ asset('images/moodx.png') }}" alt="mood.x logo" style="height: 24px;">
        </a>
    </div>

    <!-- Botões (apenas desktop) -->
    <div class="navbar-actions">
        <a href="#" class="btn btn-black">My Creative Studios ▾</a>
        <a href="#" class="btn btn-black">+ new project</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-black">Logout</button>
        </form>
<img src="{{ auth()->user()->profile?->avatar ? asset('storage/' . auth()->user()->profile->avatar) : 'https://t4.ftcdn.net/jpg/01/86/29/31/360_F_186293166_P4yk3uXQBDapbDFlR17ivpM6B1ux0fHG.jpg' }}"
     alt="Avatar"
     class="avatar">
    </div>

    <!-- Ícone hamburguer (mobile only) -->
    <div class="hamburger" onclick="toggleMobileMenu()">☰</div>
</header>

<!-- Menu mobile -->
<div id="mobile-menu" class="mobile-menu">
    <a href="#">My Profile</a>
    <a href="#">+ New Project</a>
    <a href="#">My Creative Studio</a>
    <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit" class="btn-mobile">Logout</button>
    </form>
</div>

<!-- MENU DROPDOWN PARA MOBILE -->
<div id="mobileMenu" class="mobile-menu hidden">
    <a href="#">My Profile</a>
    <a href="#">New Project</a>
    <a href="#">My Creative Studio</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-mobile">Logout</button>
    </form>
</div>



        {{-- CONTEÚDO ESPECÍFICO DE CADA PÁGINA --}}
        <div class="dashboard-content">
            @yield('content')
        </div>

    </div>

</body>
</html>
