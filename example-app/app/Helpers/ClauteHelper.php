<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Exception;

class ClauteHelper
{
    private string $apiKey;
    private string $baseUrl = 'https://api.anthropic.com/v1/messages';
    private string $model = 'claude-3-haiku-latest';

    public function __construct()
    {
        $this->apiKey = env('ANTHROPIC_API_KEY');
        
        if (!$this->apiKey) {
            throw new Exception('Anthropic API key not found in environment variables');
        }
    }
    /**
     * Send a message to Claude and get the response
     *
     * @param string $message User's input message
     * @param array $options Additional options for the API call
     * @return array Response from Claude
     */
    public function sendMessage(string $message, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => $options['model'] ?? $this->model,
                'max_tokens' => $options['max_tokens'] ?? 4096,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message,
                    ]
                ],
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception('API request failed: ' . $response->body());
        } catch (Exception $e) {
            throw new Exception('Failed to communicate with Claude API: ' . $e->getMessage());
        }
    }
}