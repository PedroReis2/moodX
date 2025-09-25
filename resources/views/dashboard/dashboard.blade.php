@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

{{-- @php
    dd($sketchbooks);
@endphp --}}

@section('content')
    <div class="dashboard-wrapper">
        <div class="projects-section">
            <h2 class="projects-title">My Projects</h2>
            <div class="projects-grid">
                @foreach ($sketchbooks as $sketchbook)
                    <a href="{{ route('sketchbookEntry', $sketchbook->id) }}" class="project-card">
                        <img src="{{ $sketchbook->image }}" alt="{{ $sketchbook->title }}" class="project-image">
                        <div class="project-overlay">
                            <div class="project-name">{{ $sketchbook->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="dashboard-wrapper">
        <div class="projects-section">
            <h2 class="projects-title">Shared Projects</h2>
            <div class="mb-6">
                <input id="searchInput" type="text" placeholder="Search by username"
                       class="border border-gray-300 rounded px-3 py-2 w-64">
            </div>

@foreach ($sketchbooksShared as $userName => $userSketchbooks)
    @if($userName !== auth()->user()->name)
        @php
            $normalizedUserName = iconv('UTF-8', 'ASCII//TRANSLIT', strtolower($userName));
        @endphp
        <div class="user-section" data-username="{{ $normalizedUserName }}">
            <h3 class="projects-title-teacher" style="margin-bottom: 1rem;">{{ $userName }}</h3>
            <div class="projects-grid">
                @foreach ($userSketchbooks as $sketchbook)
                    <a href="{{ route('sketchbookEntryShared', $sketchbook->id) }}" class="project-card">
                        <img src="{{ $sketchbook->image }}" alt="{{ $sketchbook->title }}" class="project-image">
                        <div class="project-overlay">
                            <div class="project-name">{{ $sketchbook->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
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
