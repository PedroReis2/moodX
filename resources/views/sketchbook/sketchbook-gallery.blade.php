<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hover Effect Gallery</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
      <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/test1.css') }}">

    <!-- JS -->
    <script src="{{ asset('assets/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/test1.js') }}" defer></script>

</head>



<body class="bg-gray-900 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <h1 class="text-4xl font-bold text-center text-white mb-2">Sketchbooks</h1>

<div class="gallery-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($sketchbooks as $sketchbook)
        <a href="{{ route('sketchbookEntry', $sketchbook->id) }}">
            <div class="gallery-item zoom rounded-lg overflow-hidden h-64 relative">
                <img src="{{ $sketchbook->image }}" alt="Nature" class="gallery-img">
                <div class="gallery-title">{{ $sketchbook->title }}</div>
            </div>
        </a>
    @endforeach
</div>

  </div>
  <script src="script.js"></script>
</body>
</html>
