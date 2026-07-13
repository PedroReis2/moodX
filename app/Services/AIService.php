<?php

namespace App\Services;

use GuzzleHttp\Client;

class AIService
{
    protected Client $client;
    protected string $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.openai.key');
    }

    /**
     * Envia mensagens para a API ChatGPT e retorna a resposta da AI
     *
     * @param array $messages Estrutura: [['role' => 'user'|'system', 'content' => 'texto']]
     * @return string|null
     */
    public function sendMessage(array $messages): ?string
    {

            // Mock de teste local
    //return "Resposta de teste sem chamar a API";


        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ],
        ]);

        $body = json_decode($response->getBody(), true);

        return $body['choices'][0]['message']['content'] ?? null;
    }

    public function generateImage(string $prompt, int $size = 512): ?string
{
    $response = $this->client->post('https://api.openai.com/v1/images/generations', [
        'headers' => [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'model' => 'gpt-image-1',
            'prompt' => $prompt,
            'size' => "{$size}x{$size}", // 256, 512 ou 1024
        ],
    ]);

    $body = json_decode($response->getBody(), true);

    // Retorna a URL da primeira imagem gerada
    return $body['data'][0]['url'] ?? null;
}
}
