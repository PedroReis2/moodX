@extends('layout.fe_master')

@section('title', 'Create Account')

@section('content')
<div class="register-page container-fluid">
    <div class="header-container mx-auto" style="max-width: 1062px; position: relative;">

        <!-- Logo -->
        <div class="layout-logo">
            <img src="{{ asset('images/logo.png') }}" class="logo-img raise-up" alt="Logo">
        </div>

        <!-- Título -->
        <div class="title-outside">
            <h1 class="page-title">PASSWORD CHANGES</h1>
        </div>

        <!-- Botão de fechar -->
        <div class="close-button-container">
            <a href="{{ url('/') }}" class="close-button">
                <i class="fa-solid fa-xmark"></i>
            </a>
        </div>

    <div class="white-form-rectangle">
        <div class="create_account_screen">
            <form class="create_account_form" method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="form-floating-pass">
                    <input type="password" class="form-control" id="current-password" placeholder="Current Password" name="current_password" required>
                    <label for="current-password"></label>
                </div>
                <div class="form-floating-pass">
                    <input type="password" class="form-control" id="new-password" placeholder="New Password" name="password" required>
                    <label for="new-password"></label>
                </div>
                <div class="form-floating-pass">
                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm New Password" name="password_confirmation" required>
                    <label for="confirm-password"></label>
                </div>
                <div class="button-container">
    <button type="button" class="button button_wide" onclick="window.location='{{ url('/login') }}'">
        Save changes
    </button>
</div>
            </form>
        </div>
    </div>
</div>
@endsection
