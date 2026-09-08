<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Moodboard — mood.x</title>
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/creative-dna-view.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>
<body>
    <div id="moodboard-select-root" data-user-name="{{ auth()->user()->name }}"></div>
</body>
</html>