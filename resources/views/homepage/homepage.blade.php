@extends('layout.fe_master_simple')

@section('title', 'Registo')

@section('content')


    <div class="white-rectangle-homepage">

            <!-- formulário -->
            <div class="create_account_screen">
                <form class="create_account_form">
                    <div class="form-floating-homepage1 mb-3">
                        <input type="text" class="form-control" id="firstname" placeholder="Create Account">
                        <label for="firstname"></label>
                    </div>
                    <div class="form-floating-homepage2 mb-3">
                        <input type="text" class="form-control" id="lastname" placeholder="Login">
                        <label for="lastname"></label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
