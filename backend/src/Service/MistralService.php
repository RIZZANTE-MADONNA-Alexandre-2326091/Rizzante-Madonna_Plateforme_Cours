<?php

namespace App\Service;

use RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class MistralService
{
    private const MISTRAL_API_URL = 'https://api.mistral.ai/v1/chat/completions';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $mistralApiKey
    ) {}

    public function generateTrueFalseQcm(string $paragraph): array
    {
        $prompt = <<<PROMPT
        À partir du paragraphe suivant, génère 5 questions de type Vrai/Faux
        Paragraphe:
        {$paragraph}

        Format attendu (JSON uniquement):
        Question et Réponse(s)
        PROMPT;
        try {
            $response = $this->httpClient->request('POST', self::MISTRAL_API_URL, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->mistralApiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'mistral-small-latest',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.3,
                ],
            ]);

            $data = $response->toArray(false);

            if (!isset($data['choices'][0]['message']['content'])) {
                throw new RuntimeException('Réponse Mistral invalide');
            }

            $content = $data['choices'][0]['message']['content'];

            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new RuntimeException('JSON invalide retourné par Mistral');
            }

            return $decoded;

        } catch (
        TransportExceptionInterface |
        ClientExceptionInterface |
        ServerExceptionInterface $e
        ) {
            throw new \RuntimeException(
                'Erreur lors de l’appel à l’API Mistral : ' . $e->getMessage()
            );
        }

    }
}
