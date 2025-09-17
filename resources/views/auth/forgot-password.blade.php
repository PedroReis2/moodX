@extends("layout.fe_master_simple")

@section("content")

<!-- imagens no topo -->
<div class="rectangle-header-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Header Logo" class="rectangle-logo">
</div>
<div class="rectangle-header-slogan">
    <img src="{{ asset('images/slogan.png') }}" alt="Header Slogan" class="rectangle-slogan">
</div>

<div class="form-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-floating-login mb-1">
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            <label for="email"></label>
        </div>

        <div class="button-container">
            <button type="submit" class="button button_wide">Recover password</button>
        </div>
    </form>
</div>

@endsection
