@extends('layout.fe_master')

@section('title', 'Registo')

@section('content')

<div class="register-page">
    <h1 class="page-title">CREATE ACCOUNT</h1>
</div>

<div class="white-rectangle">
    <div class="content-row">
        <!-- Coluna esquerda: círculo da imagem -->
        <div class="profile-column">
            <div class="circle">
                <img id="profilePreview" class="profile-pic" src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg">
            </div>
            <div class="p-image" onclick="document.getElementById('profileImageInput').click();">
                <i class="fa fa-camera upload-button"></i>
            </div>
        </div>

        <!-- Coluna direita: formulário -->
        <div class="create_account_screen">
            <form method="POST" action="{{ route('store_user') }}" class="create_account_form" enctype="multipart/form-data">
                @csrf
                <input type="file" name="profile_image" id="profileImageInput" style="display:none;" accept="images/*" onchange="previewImage(event)" />

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="firstname" placeholder="firstname" name="first_name">
                    <label for="firstname">First Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="lastname" placeholder="lastname" name="last_name">
                    <label for="lastname">Last Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" placeholder="username" name="name">
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" required>
                    <label for="birthday">Birthday Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="button-container">
                    <button type="submit" class="button button_wide">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
