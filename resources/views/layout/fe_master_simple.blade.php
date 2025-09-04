<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">



    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/change-password.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- JS -->
    <script src="{{ asset('assets/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/register.js') }}" defer></script> {{-- JS do formulário --}}




</head>
<body>

<div class="page-container">
    <div class="custom-rectangle">


        @yield('content') <!-- conteúdo da view entra aqui -->
    </div>
</div>



</body>
</html>
