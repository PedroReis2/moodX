@extends("layout.fe_master_simple")

@section("content")

{{-- Página "Reset Password" em React --}}
<div id="reset-password-root"
     data-token="{{ request()->route('token') }}"
     data-email="{{ request('email', '') }}"></div>

@endsection
