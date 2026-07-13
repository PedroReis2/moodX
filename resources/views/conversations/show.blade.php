{{-- resources/views/conversations/show.blade.php --}}
@extends('layout.app')

@section('content')
<h1>{{ $conversation->title ?? 'Sem título' }}</h1>
<a href="{{ route('conversations.index') }}">Voltar</a>

<div style="border:1px solid #ccc; padding:10px; margin-top:20px;">
    @foreach($conversation->messages as $message)
        <div style="margin-bottom:10px;">
            <strong>{{ ucfirst($message->role) }}:</strong>
            @if(Str::endsWith($message->content, ['.png', '.jpg', '.jpeg']))
                <div>
                    <img src="{{ asset($message->content) }}" alt="IA Image" style="max-width:300px;">
                </div>
            @else
                <p>{{ $message->content }}</p>
            @endif
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route('messages.store', $conversation) }}" style="margin-top:20px;">
    @csrf
    <textarea name="content" rows="3" placeholder="Escreve aqui..." required></textarea>
    <button type="submit">Enviar</button>
</form>
@endsection
