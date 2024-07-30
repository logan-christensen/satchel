<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{

    public string $model = 'meta-llama/llama-3.1-8b-instruct:free';
    public array $messages = [];

    public function __construct(?string $model = null, ?array $messages = null)
    {
        if ($model) {
            $this->model = $model;
        }

        if ($messages) {
            $this->messages = $messages;
        }
    }

    public function getHeaders(): array
    {
        return [
            "HTTP-Referer" => config('app.url'), // Optional, for including your app on openrouter.ai rankings.
            "X-Title" => config('app.name'), // Optional. Shows in rankings on openrouter.ai.
            "Content-Type" => "application/json"
        ];
    }

    public function getResponse(): AiService
    {
        $openRouterApiKey = env('OPENROUTER_API_KEY');

        $response = Http::withToken($openRouterApiKey)
            ->withHeaders($this->getHeaders())
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $this->model,
                'messages' => $this->messages,
            ]);
        $aiResponse = $response->json()['choices'][0]['message'];
        $this->addMessage($aiResponse['content'], $aiResponse['role']);
        return $this;
    }

    public function addMessage(string $message, string $role = 'user'): AiService
    {
        $this->messages[] = [
            'role' => $role,
            'content' => $message,
        ];
        return $this;
    }

    public function getLastMessage(): string
    {
        return end($this->messages)['content'];
    }

}
