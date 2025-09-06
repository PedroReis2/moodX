{{-- <html lang="en">
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
    <h1 class="text-4xl font-bold text-center text-white mb-2">Sketchbooks Entries</h1>

<div class="gallery-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($sketchbookEntries as $sketchbook)
        <a href="{{ route('sketchbookView', $sketchbook->id) }}">
            <div class="gallery-item zoom rounded-lg overflow-hidden h-64 relative">
                <img src="{{ $sketchbook->content_url }}" alt="Nature" class="gallery-img">
                <div class="gallery-title">{{ $sketchbook->content_text }}</div>
            </div>
        </a>
    @endforeach
</div>

  </div>
  <script src="script.js"></script>
</body>
</html> --}}


<html lang="pt-PT">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sketchbook Gallery</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,cyrillic' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/sketchbook-gallery.css') }}">
<script src="{{ asset('assets/bootstrap.js') }}" defer></script>
<script src="{{ asset('js/sketchbook-gallery.js') }}" defer></script>
</head>
<body class="bg-gray-900 min-h-screen py-12 px-4 sm:px-6 lg:px-8">

<div class="max-w-7xl mx-auto">
    <h1 class="text-4xl font-bold text-center text-white mb-6">Sketchbooks Entries</h1>

    <div class="gallery-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($sketchbookEntries as $entry)
            <div class="gallery-item cursor-pointer rounded-lg overflow-hidden h-64 relative"
                 data-entry-id="{{ $entry->id }}">
                @if($entry->content_type === 'image')
                    <img src="{{ $entry->content_url }}" alt="Imagem" class="gallery-img">
                @elseif($entry->content_type === 'text')
                    <div class="p-4 text-white">{{ $entry->content_text }}</div>
                @elseif($entry->content_type === 'video')
                    <video src="{{ $entry->content_url }}" class="w-full h-full object-cover"></video>
                @endif
            </div>
        @endforeach
    </div>
</div>

@foreach ($sketchbookEntries as $entry)
<div class="modal-backdrop" id="modal-{{ $entry->id }}">
    <div class="modal-container">
        <section class="modal-media">
            @if($entry->content_type === 'image')
                <img src="{{ $entry->content_url }}" alt="Imagem da publicação" />
            @elseif($entry->content_type === 'text')
                <p class="p-4">{{ $entry->content_text }}</p>
            @elseif($entry->content_type === 'video')
                <video controls>
                    <source src="{{ $entry->content_url }}" type="video/mp4">
                </video>
            @endif
            <p class="p-4">{{ $entry->content_text }}</p>
        </section>

        <aside class="modal-comments">
            <header>
                <img src="{{ $entry->sketchbook->user->avatar ?? 'https://i.pravatar.cc/64' }}" alt="Avatar" />
                <div>
                    <strong>{{ $entry->sketchbook->user->name ?? 'Desconhecido' }}</strong>
                    <span>{{ $entry->sketchbook->location ?? 'Porto' }}</span>
                </div>
                <button id="btn-close-modal" type="button" class="close-modal ml-auto">Fechar</button>
            </header>

            <div class="comments-list">
                @foreach ($entry->comments as $comment)
                    <article class="comment">
                        <img src="{{ $comment->user->avatar ?? 'https://i.pravatar.cc/64' }}" alt="Avatar" />
                        <div>
                            <strong>{{ $comment->user->name ?? 'Anon' }}</strong>
                            <p>{{ $comment->comment }}</p>
                            <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</time>
                        </div>
                    </article>
                @endforeach
            </div>

            <form method="POST" action="{{ route('comments.store', $entry->id) }}" class="add-comment">
                @csrf
                <input type="text" name="comentario" placeholder="Adiciona um comentário…" class="flex-1 px-2 py-1"/>
                <button type="submit" class="px-2 py-1 bg-blue-600 rounded text-white">Publicar</button>
            </form>
        </aside>
    </div>
</div>
@endforeach

</body>
</html>
