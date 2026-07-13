{{-- resources/views/conversations/index.blade.php --}}
@extends('layout.app')

@section('content')
<h1>Minhas Conversas</h1>
<a href="{{ route('conversations.create') }}">Nova Conversa</a>
<ul>
    @foreach($conversations as $conversation)
        <li>
            <a href="{{ route('conversations.show', $conversation) }}">
                {{ $conversation->title ?? 'Sem título' }}
                ({{ $conversation->messages()->count() }} mensagens)
            </a>
        </li>
    @endforeach
</ul>
@endsection
