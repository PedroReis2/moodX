@extends("layout.fe_master")

@section("content")

<form method="POST" action="{{ route('two-factor.login') }}">
    @csrf
    <label>Authentication Code</label>
    <input type="text" name="code" required autofocus>
    <label>Recovery Code</label>
    <input type="text" name="recovery_code">
    <button type="submit">Login</button>
</form>

@endsection
