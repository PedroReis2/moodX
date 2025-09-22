@extends('layout.fe_master')

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@section('title', 'Your Profile')

@section('content')
<div class="register-page container-fluid">
    <div class="header-container mx-auto" style="max-width: 1062px; position: relative;">

        <!-- Logo -->
        <div class="layout-logo">
            <img src="{{ asset('images/logo.png') }}" class="logo-img raise-up" alt="Logo">
        </div>

        <!-- Título -->
        <div class="title-outside">
            <h1 class="page-title">YOUR PROFILE</h1>
        </div>

        <!-- Botão de fechar -->
        <div class="close-button-container">
            <a href="{{ url('dashboard') }}" class="close-button">
                <i class="fa-solid fa-xmark"></i>
            </a>
        </div>

        <div class="white-rectangle mx-auto">
            <div class="row align-items-center w-100">
                <!-- Coluna esquerda: foto de perfil -->
                <div class="col-12 col-md-5 d-flex flex-column align-items-center mb-4 mb-md-0">
                    <div class="profile-pic-wrapper">
                        <div class="circle">
                            <img
                                id="profilePreview"
                                class="profile-pic"
                                src="{{ auth()->user()->profile?->avatar ? asset('storage/' . auth()->user()->profile->avatar) : 'https://t4.ftcdn.net/jpg/01/86/29/31/360_F_186293166_P4yk3uXQBDapbDFlR17ivpM6B1ux0fHG.jpg' }}"
                                alt="Profile Picture">
                        </div>
                        <div class="p-image" onclick="document.getElementById('profileImageInput').click();">
                            <i class="fa fa-camera upload-button"></i>
                        </div>
                    </div>
                </div>

                <!-- Coluna direita: formulário -->
                <div class="col-12 col-md-7">
                    <div class="form-column">
                        <form class="create_account_form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="file" name="profile_image" id="profileImageInput" style="display:none;" accept="image/*" onchange="previewImage(event)" />

                            <!-- Hidden inputs para enviar valores mesmo sendo readonly -->
                            <input type="hidden" name="first_name" value="{{ auth()->user()->first_name }}">
                            <input type="hidden" name="last_name" value="{{ auth()->user()->last_name }}">
                            <input type="hidden" name="name" value="{{ auth()->user()->name }}">

                            <div class="form-floating">
                                <input type="text" class="form-control" id="firstname" placeholder="{{ auth()->user()->first_name }}" disabled>
                            </div>

                            <div class="form-floating">
                                <input type="text" class="form-control" id="lastname" placeholder="{{ auth()->user()->last_name }}" disabled>
                            </div>

                            <div class="form-floating">
                                <input type="text" class="form-control" id="username" placeholder="{{ auth()->user()->name }}" disabled>
                            </div>

                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="{{ auth()->user()->email }}" value="{{ old('email', auth()->user()->email) }}">
                            </div>

                            <div class="form-floating">
                                <input type="date" class="form-control" id="birthday" name="birth_date"
                                       value="{{ old('birth_date', auth()->user()->profile?->birth_date ? \Carbon\Carbon::parse(auth()->user()->profile->birth_date)->format('Y-m-d') : '') }}">
                            </div>

                            <div class="form-floating mb-2">
                                <a href="{{ route('change-password') }}" class="change-password-link" style="display:inline-block;">
                                    Change password
                                </a>
                            </div>

                            <div class="form-floating" style="display: flex; justify-content: flex-end;">
                                <button type="submit" class="button button_wide">Save changes</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
