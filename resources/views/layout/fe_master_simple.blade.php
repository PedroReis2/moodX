<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>



    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">


    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master-simple.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-minimal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-minimal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forgot-password-minimal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset-password-minimal.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- JS -->
    <script src="{{ asset('assets/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    {{-- Preamble do React (necessário para react-refresh em dev) --}}
    @viteReactRefresh
    @vite(['resources/js/app.js'])

</head>
<body>

    <div class="page-container">
        <div class="white-rectangle">
            @yield('content')
        </div>
    </div>

</body>
</html>
