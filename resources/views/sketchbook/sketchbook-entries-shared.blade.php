{{-- galeria --}}




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






{{-- modal --}}

{{-- info user --}}
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





{{-- comentarios --}}



            <div class="comments-list">
                @foreach ($entry->comments as $comment)
                    <article class="comment">
                        <img src="{{ $comment->user->profile->avatar ? asset('storage/' . $comment->user->profile->avatar) : 'https://t4.ftcdn.net/jpg/01/86/29/31/360_F_186293166_P4yk3uXQBDapbDFlR17ivpM6B1ux0fHG.jpg' }}" alt="Avatar" />
                        <div>
                            <strong>{{ $comment->user->name ?? '...' }}</strong>
                            <p>{{ $comment->comment }}</p>
                            <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</time>
                        </div>
                    </article>
                @endforeach
            </div>








            {{-- novo comentario --}}








            <form method="POST" action="{{ route('comments.store', $entry->id) }}" class="add-comment" data-entry-id="{{ $entry->id }}">
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
