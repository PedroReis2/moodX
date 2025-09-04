@extends("layout.fe_master")

@section("content")

    <h1>Recuperar pass</h1>

    <form method="POST" action="{{route('password.email')}}">
        @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <button type="submit" class="btn btn-primary">Recuperar</button>
</form>

@endsection
