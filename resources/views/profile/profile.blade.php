@extends('layout.fe_master')

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
            <a href="{{ url('/') }}" class="close-button">
                <i class="fa-solid fa-xmark"></i>
            </a>
        </div>

    <div class="white-rectangle mx-auto">
        <div class="row align-items-center w-100">
            <!-- Coluna esquerda: foto de perfil -->
            <div class="col-12 col-md-5 d-flex flex-column align-items-center mb-4 mb-md-0">
                <div class="profile-pic-wrapper">
                    <div class="circle">
                        <img class="profile-pic"
                             src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg"
                             alt="Profile Picture">
                    </div>
                    <div class="p-image">
                        <i class="fa fa-camera upload-button"></i>
                        <input class="file-upload" type="file" accept="image/*"/>
                    </div>
                </div>
            </div>

            <!-- Coluna direita: formulário -->
            <div class="col-12 col-md-7">
                <div class="form-column">
                    <form class="create_account_form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-floating">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>

                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>

                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>

                        </div>

                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>

                        </div>

                        <div class="form-floating">
                            <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" required>

                        </div>

                       <div class="form-floating mb-2">
                          <a href="{{ route('change-password') }}" class="change-password-link" style="display:inline-block;">
                                Change password</a>
                        </div>


   <!-- Botão alinhado à direita, dentro de container com mesma largura dos campos -->
    <div class="form-floating" style="display: flex; justify-content: flex-end;">
        <button type="submit" class="button button_wide">Save changes</button>
    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
