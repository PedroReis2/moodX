<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard — mood.x</title>

    {{-- CSS já usado nas páginas principais da app --}}
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/classes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">

    {{-- Preamble do React necessário em desenvolvimento --}}
    @viteReactRefresh

    {{-- Bundle principal do React --}}
    @vite(['resources/js/app.js'])
</head>

<body>
    {{-- Root onde o React vai montar o dashboard admin --}}
    <div id="admin-dashboard-root" data-user-name="{{ auth()->user()->name }}"></div>
</body>

</html>
