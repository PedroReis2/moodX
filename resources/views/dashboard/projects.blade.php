@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

@section('content')
    <div class="dashboard-wrapper">
        <div class="projects-section">
            <h2 class="projects-title">
                @if(optional($sketchbookEntries->first()->sketchbook->user)->id !== auth()->id())
                    {{ $sketchbookEntries->first()->sketchbook->user->name }}
                @endif
            </h2>
            <h2 class="projects-title">{{ $sketchbookEntries->first()->sketchbook->title ?? '' }}</h2>
            <div class="projects-grid">
                @foreach ($sketchbookEntries as $sketchbook)
                    <a href="" class="project-card">
                        <img src="{{ $sketchbook->content_url }}" alt="{{ $sketchbook->content_text }}" class="project-image">
                        <div class="project-overlay">
                            <div class="project-name">{{ $sketchbook->content_text }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
