<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Creative DNA — mood.x</title>
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/creative-dna-view.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    {{-- Preamble do React (necessário para react-refresh em dev) --}}
    @viteReactRefresh
    @vite(['resources/js/app.js'])
</head>

<body>
    <div
        id="creative-dna-view"
        data-user-name="{{ auth()->user()->name }}"
        data-is-professor="{{ auth()->user()->role_id === 2 ? '1' : '0' }}"
    ></div>
</body>

</html>
