@extends('layout.fe_dashboard_master_3')

@section('title', 'Dashboard — mood.x')

@section('content')
<div class="dashboard-wrapper">
    <div class="projects-section">
<!-- Barra de pesquisa alinhada à direita -->
        <div class="search-bar-wrapper">
            <input id="searchInput" type="text" placeholder="Search by username"
                   class="search-bar-input">
        </div>

        @foreach ($sketchbooksShared as $userName => $userSketchbooks)
            @php
                $normalizedUserName = iconv('UTF-8', 'ASCII//TRANSLIT', strtolower($userName));
                //serve para normalizar o nome do utilizador (remover acentos e caracteres especiais)
            @endphp
            <div class="user-section" data-username="{{ $normalizedUserName }}">
                <h2 class="projects-title-teacher">{{ $userName }}</h2>
                <div class="projects-grid">
                    @foreach ($userSketchbooks as $sketchbook)
                        <a href="{{ route('sketchbookEntry', $sketchbook->id) }}" class="project-card">
                            <img src="{{ $sketchbook->image }}" alt="{{ $sketchbook->title }}" class="project-image">
                            <div class="project-overlay">
                                <div class="project-name">{{ $sketchbook->title }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const search = this.value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    document.querySelectorAll('.user-section').forEach(section => {
        section.style.display = section.dataset.username.includes(search) ? '' : 'none';
    });
});
</script>
@endsection
