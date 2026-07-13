<?php
// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $request->validate([
            'content' => 'required|string',
        ]);

        // Guardar mensagem do user
        $conversation->messages()->create([
            'role' => 'user',
            'content' => $request->content,
        ]);

        $mensagem = strtolower($request->content);
        $aiResponse = '';

        if (Str::contains($mensagem, ['imagem', 'image', 'img', 'gera', 'cria', 'imge', 'make'])) {
            // Geração de imagem com OpenAI
$response = Http::withToken(config('services.openai.key'))
    ->post('https://api.openai.com/v1/images/generations', [
        'model' => 'gpt-image-1',
        'prompt' => $request->content,
        'size' => '1024x1024',
        'n' => 1, // número de imagens
    ])
    ->json();

$base64 = $response['data'][0]['b64_json'] ?? null;

if ($base64) {
    $image = base64_decode($base64);
    $filename = uniqid('img_') . '.png';
    Storage::disk('public')->put('chat_images/' . $filename, $image);
    $aiResponse = '/storage/chat_images/' . $filename;
} else {
    $aiResponse = 'Erro ao gerar imagem.';
}

        } else {
            // Chat normal
            $history = $conversation->messages()->get(['role', 'content'])->map(function ($msg) {
                return [
                    'role' => $msg->role,
                    'content' => $msg->content,
                ];
            })->toArray();

            $response = Http::withToken(config('services.openai.key'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => $history,
                ])
                ->json();

            $aiResponse = $response['choices'][0]['message']['content'] ?? 'Erro na resposta.';
        }

        // Guardar resposta da AI
        $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $aiResponse,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }
}
