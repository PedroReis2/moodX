@extends("layout.fe_master_simple")

@section("content")

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

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

        <div class="form-floating-login mb-1">
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            <label for="password"></label>
        </div>

        <div class="button-container">
    <button type="submit" class="button button_wide">Login</button>
</div>

<div class="forgot-password-container">
    <a href="{{ url('/forgot-password') }}" class="change-password-link">
        Forgot password?
    </a>
</div>

    </form>
</div>

@endsection
