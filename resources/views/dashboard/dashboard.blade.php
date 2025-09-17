@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

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
            <div class="projects-grid">
                @foreach ($sketchbooksShared as $sketchbook)
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
@endsection
