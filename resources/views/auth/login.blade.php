@extends("layouts.fe_master")

@section("content")

    <h1>Login</h1>

    <form method="POST" action="{{route('login')}}">
        @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
  Esqueceu se da pass? Clique <a href="{{route("password.request")}}">aqui</a>
</form>

@endsection
