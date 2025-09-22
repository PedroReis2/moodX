<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <!-- Tipografia -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS do Bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  {{-- JS --}}
  <script src="{{ asset('js/admin.js') }}" defer></script>



</head>
<body style="font-family: 'Inter', sans-serif; background-color: #ffffff;">

  <div class="dashboard-wrapper">

    <!-- NAVBAR universal -->
    <header class="dash-navbar">
      <div class="navbar-brand">
        <img src="{{ asset('images/moodx.png') }}" alt="mood.x logo" style="height: 24px;">
      </div>

      <div class="navbar-actions">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-black">Logout</button>
        </form>



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
    </header>

    <!-- CONTEÚDO ESPECÍFICO DE CADA PÁGINA -->
    <div class="dashboard-content">
      @yield('content')
    </div>

  </div>


</body>
</html>
