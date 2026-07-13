{{-- resources/views/conversations/create.blade.php --}}
@extends('layout.app')

@section('content')
<h1>Criar Nova Conversa</h1>
<form method="POST" action="{{ route('conversations.store') }}">
    @csrf
    <label for="title">Título (opcional)</label>
    <input id="title" type="text" name="title" value="{{ old('title') }}">
    <button type="submit">Criar</button>
</form>
<a href="{{ route('conversations.index') }}">Voltar</a>
@endsection
