@extends('layout.fe_master')

@section('title', 'Registo')

@section('content')
<div class="register-page">

    <h1 class="page-title">YOUR PROFILE</h1> <!-- título fora do retângulo -->
</div>

    <div class="white-rectangle">
        <div class="content-row">
            <!-- Coluna esquerda: círculo da imagem -->
            <div class="profile-column">
                <div class="circle">
                 <img class="profile-pic" src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg">
             </div>

        <div class="p-image">
          <i class="fa fa-camera upload-button"></i>
              <input class="file-upload" type="file" accept="image/*"/>
              </div>
            </div>


            <!-- Coluna direita: formulário -->
            <div class="create_account_screen">
                <form class="create_account_form">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstname" placeholder="firstname">
                        <label for="firstname">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastname" placeholder="lastname">
                        <label for="lastname">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" placeholder="username">
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" required>
                        <label for="birthday">Birthday Date</label>
                    </div>
                    <div class="button-container">
    <!-- Link clicável para mudar a senha -->
    <a href="{{ route('change-password') }}" class="change-password-link">Change password</a>
                    <div class="button-container">
                        <button type="submit" class="button button_wide">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
