@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

{{-- @php
    dd($sketchbookEntries->map(function($entry) {
        return [
            'entry_id' => $entry->id,
            'sketchbook_id' => $entry->sketchbook->id ?? 'null',
            'user_id' => $entry->sketchbook->user->id ?? 'null',
            'user_name' => $entry->sketchbook->user->name ?? 'null'
        ];
    }));
@endphp --}}

@section('content')
<div class="dashboard-wrapper">
    <div class="projects-section">

        {{-- Se houver entradas no sketchbook --}}
        @if($sketchbookEntries->isNotEmpty())
            @php
                $groupedEntries = $sketchbookEntries->groupBy('sketchbook.user.id');
            @endphp

            @foreach($groupedEntries as $userId => $userEntries)
                {{-- Nome do criador (se não for o próprio user) --}}
                <h2 class="projects-title">
                    @if(optional($userEntries->first()->sketchbook->user)->id !== auth()->id())
                        {{ $userEntries->first()->sketchbook->user->name }}
                    @endif
                </h2>

                {{-- Nome do sketchbook --}}
                <h2 class="projects-title">{{ $userEntries->first()->sketchbook->title ?? '' }}</h2>

                {{-- Grelha de entradas --}}
                <div class="projects-grid">
                    @foreach ($userEntries as $entry)
                        <a href="javascript:void(0)"
                           class="project-card"
                           onclick="openModal({{ $entry->id }})">
                            <img src="{{ $entry->content_url }}" alt="{{ $entry->content_text }}" class="project-image">
                            <div class="project-overlay">
                                <div class="project-name">{{ $entry->content_text }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        @else
            {{-- Estado vazio se não houver projetos --}}
            <div class="dash-empty-container">
                <div class="empty-state">
                    <img src="{{ asset('images/icons/empty_icon.png') }}" class="empty-icon" alt="">
                    <p class="empty-title">No Projects Yet</p>
                    <p class="empty-sub">Start creating and your projects will appear here.</p>
                    <a href="{{ route('create.project') }}" class="cta-empty">Create Project</a>
                </div>
            </div>
        @endif

    </div>
</div>

{{-- Modais para cada entry --}}
@foreach ($sketchbookEntries as $entry)
<div id="modal-{{ $entry->id }}" class="modal hidden">
    <div class="modal-content">
        {{-- Botão de fechar --}}
        <span class="modal-close" onclick="closeModal({{ $entry->id }})">&times;</span>

        <div class="modal-inner">
            {{-- Lado Esquerdo: Imagem --}}
            <div class="modal-image-section">
                <img src="{{ $entry->content_url }}" alt="Imagem da publicação" />
            </div>

            {{-- Lado Direito: Detalhes e Comentários --}}
            <div class="modal-details">
                <div class="modal-details-wrapper">
                    <div class="modal-info">
                        <h3 class="modal-title">{{ $entry->content_text }}</h3>
                        @if($entry->description)
                            <p class="description-title">Description</p>
                            <p class="description-text">{{ $entry->description }}</p>
                        @endif
                        <div class="meta">
                            <div><strong>Added</strong> <span class="meta-light">{{ $entry->created_at->format('d M Y') }}</span></div>
                            <div><strong>By</strong> <span>{{ optional($entry->sketchbook->user)->name ?? 'Unknown' }}</span></div>
                        </div>
                        <div class="modal-actions">
                            <button class="share-btn">
                                <img src="{{ asset('images/icons/share_icon.png') }}" alt="Share">
                                Share
                            </button>
                        </div>
                    </div>

                    {{-- Comentários --}}
                    <div class="modal-comments">
                        <h4>Comments</h4>
                        <div class="comment-list">
                            @forelse ($entry->comments as $comment)
                                <article class="comment">
                                    <img src="{{ optional(optional($comment->user)->profile)->avatar
                                        ? asset('storage/' . $comment->user->profile->avatar)
                                        : 'https://t4.ftcdn.net/jpg/01/86/29/31/360_F_186293166_P4yk3uXQBDapbDFlR17ivpM6B1ux0fHG.jpg' }}"
                                         class="comment-avatar" alt="Avatar">
                                    <div class="comment-content">
                                        <div class="comment-username">{{ optional($comment->user)->name ?? 'Anon' }}</div>
                                        <div class="comment-text">{{ $comment->comment }}</div>
                                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </article>
                            @empty
                                <p>No comments yet. Be the first!</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Formulário de Comentários --}}
                    <form method="POST" action="{{ route('comments.store', $entry->id) }}" class="comment-form">
                        @csrf
                        <textarea name="comentario" class="comment-input" placeholder="Add a comment..."></textarea>
                        <button type="submit" class="comment-button">Add comment</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // Fecha modal ao clicar fora do conteúdo
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endpush
