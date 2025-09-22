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
            <h1 class="page-title">CREATE ACCOUNT</h1>
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
                             src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg"
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
                    <form class="create_account_form" method="POST" action="{{ route('store_user') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="profile_image" id="profileImageInput" style="display:none;" accept="image/*" onchange="previewImage(event)" />

                        <div class="form-floating">
                            <input type="text" class="form-control" id="firstname" name="first_name"
                                   placeholder="First Name" value="{{ old('first_name') }}" required>
                            @error('firstname')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="lastname" name="last_name"
                                   placeholder="Last Name" value="{{ old('last_name') }}" required>
                            @error('lastname')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="date" class="form-control" id="birthday" name="birthday"
                                   placeholder="Birthday" value="{{ old('birthday') }}" required>
                            @error('birthday')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                            @error('password_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="button button_wide">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
