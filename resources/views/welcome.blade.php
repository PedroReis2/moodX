@extends("layout.fe_master_simple")

@section("content")

    <!-- imagens no topo -->
    <div class="rectangle-header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Header Logo" class="rectangle-logo">
    </div>
    <div class="rectangle-header-slogan">
        <img src="{{ asset('images/slogan.png') }}" alt="Header Slogan" class="rectangle-slogan">
    </div>

    <!-- formulário com botões mantendo estilo original -->
    <div class="form-container">
        <div class="form-floating-welcome mb-1">
            <a href="{{ route('register') }}" class="form-control">
                Create Account
            </a>
        </div>

        <div class="form-floating-welcome2 mb-1">
            <a href="{{ route('login') }}" class="form-control">
                Login
            </a>
        </div>

        <div class="button-container">
            <a href="{{ route('forgot-password') }}" class="change-password-link">
                Recover Account
            </a>
        </div>
    </div>

@endsection
