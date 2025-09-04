@extends("layouts.fe_master")

@section("content")

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Confirm Password</button>
</form>

@endsection
