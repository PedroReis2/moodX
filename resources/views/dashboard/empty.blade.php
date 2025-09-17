@extends('layout.fe_dashboard_master')

@section('title', 'Dashboard — mood.x')

@section('content')
    <div class="dash-empty-container">
        <div class="empty-state">
            <img src="{{ asset('images/icons/noProjects.png') }}" alt="No Projects" class="empty-icon">
            <h2 class="empty-title">No Project</h2>
            <p class="empty-sub">Create a new fashion story today.</p>
            <a href="#" class="cta-empty">+ Create a new Project</a>
        </div>
    </div>
@endsection
