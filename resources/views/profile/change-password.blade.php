@extends('layout.fe_master')

@section('title', 'Registo')

@section('content')
<div class="register-page">

    <h1 class="page-title">PASSWORD CHANGES</h1> <!-- título fora do retângulo -->
</div>

    <div class="white-rectangle">

            <!-- formulário -->
            <div class="create_account_screen">
                <form class="create_account_form">
                    <div class="form-floating-pass mb-3">
                        <input type="text" class="form-control" id="firstname" placeholder="Current Password">
                        <label for="firstname"></label>
                    </div>
                    <div class="form-floating-pass mb-3">
                        <input type="text" class="form-control" id="lastname" placeholder="New Password">
                        <label for="lastname"></label>
                    </div>
                    <div class="form-floating-pass mb-3">
                        <input type="text" class="form-control" id="username" placeholder="Confirm New Password">
                        <label for="username"></label>
                    </div>
                    <div class="button-container">
                        <button type="submit" class="button button_wide">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
