@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

@section('content')
    <div class="dashboard-wrapper">
        <div class="projects-section">

            {{-- Se for partilhado mostra o nome do criador --}}

            <h2 class="projects-title">
                @if(optional($sketchbookEntries->first()->sketchbook->user)->id !== auth()->id())
                    {{ $sketchbookEntries->first()->sketchbook->user->name }}
                @endif
            </h2>

            {{-- nome do sketchbook --}}

            <h2 class="projects-title">{{ $sketchbookEntries->first()->sketchbook->title ?? '' }}</h2>


            {{-- cards das entries do sketchbook --}}

            <div class="projects-grid">
                @foreach ($sketchbookEntries as $entry)
                    <div class="project-card" data-entry-id="{{ $entry->id }}">
                        <img src="{{ $entry->content_url }}" alt="{{ $entry->content_text }}" class="project-image">
                        <div class="project-overlay">
                            <div class="project-name">{{ $entry->content_text }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>




    {{-- abrir modal --}}

    @foreach ($sketchbookEntries as $entry)
    <!-- Modal Principal -->
<div id="modal-{{ $entry->id }}" class="modal hidden">
    <div class="modal-content">

        <!-- Botão para fechar modal -->
        <span class="modal-close" onclick="closeModal()">&times;</span>

        <!-- Conteúdo -->
        <div class="modal-inner">

            <!-- Lado Esquerdo - imagem -->
            <div class="modal-image-section">
                <img src="{{ $entry->content_url }}" alt="Imagem da publicação" />
            </div>

            <!-- Lado direito: Detalhes + Comentários -->
            <div class="modal-details">

                <!-- Div pai para controlar o alinhamento vertical -->
                <div class="modal-details-wrapper">

                    <!-- Bloco fixo de informações -->
                    <div class="modal-info">
                        <h3 id="modal-title" class="modal-title">Nome do Projeto</h3>
                        <p class="description-title">Description</p>
                        <p id="modal-description" class="description-text">
                            Texto da descrição do projeto selecionado.
                        </p>
                        <div class="meta">
                            <div><strong>Added</strong> <span class="meta-light" id="modal-added">...</span></div>
                            <div><strong>By</strong> <span id="modal-author">...</span></div>
                        </div>
                        <div class="modal-actions">
                            <button class="share-btn">
                                <img src="{{ asset('images/icons/share_icon.png') }}" alt="Share">
                                Share
                            </button>
                        </div>
                    </div>

                    <!-- Lista de comentários com scroll -->
                    <div class="modal-comments">
                        <h4>Comments</h4>
                        <div id="commentList" class="comment-list">
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
                        </div>
                    </div>


            </div>

                    <!-- Formulário de comentários no fundo -->
            <form method="POST" action="{{ route('comments.store', $entry->id) }}" class="add-comment" data-entry-id="{{ $entry->id }}">
            @csrf
                <input type="text" name="comentario" placeholder="Adiciona um comentário…" class="flex-1 px-2 py-1"/>
                <button type="submit" class="px-2 py-1 bg-blue-600 rounded text-white">Publicar</button>
            </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Mini-Modal de imagem (Dentro do Modal Principal) -->
<div id="imageOverlay" class="image-overlay hidden">
    <div class="image-overlay-content">
        <span class="close-overlay" onclick="closeImageOverlay()">&times;</span>
        <img id="overlay-image" src="" alt="Imagem ampliada">
    </div>
</div>

@endforeach
@endsection
