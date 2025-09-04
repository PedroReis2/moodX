@extends("layouts.fe_master")

@section("content")

    <h1>Ola aqui podes adicionar novos utilizadores</h1>

    <form method="POST" action="{{route('store_user')}}">
        @csrf
  <div class="mb-3">
    <label for="exampleInputNome1" class="form-label">Nome</label>
    <input type="name" class="form-control" name="name" id="name">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
