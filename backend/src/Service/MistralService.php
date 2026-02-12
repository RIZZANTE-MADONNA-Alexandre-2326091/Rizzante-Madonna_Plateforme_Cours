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

    public function generateQcm(string $paragraph, int $nbQuestions): array
    {
        $instruction = "{$nbQuestions} questions à choix multiples (QCM) avec 4 options par question ou questions de type Vrai/Faux.";

        $prompt = <<<PROMPT
        À partir du paragraphe suivant, génère {$instruction}
        
        Paragraphe: "{$paragraph}"

        Format attendu (JSON strict) :
        [
          {
            "question": "Texte de la question",
            "options": ["choix A", "choix B", "choix C", "choix D"],
            "reponse": "La bonne réponse" OU ["Bonne réponse 1", "Bonne réponse 2", ...]
          }
        ]
        (Pour les choix multiples, plusieurs peuvent être justes, ou une seule, mais jamais que des des réponses justes ou aucune)
        (Pour le vrai/faux, les options doivent être ["Vrai", "Faux"])
        PROMPT;

        try {
            $response = $this->httpClient->request('POST', self::MISTRAL_API_URL, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->mistralApiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model' => 'mistral-small-latest',
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                    'temperature' => 0.2, // Plus bas pour plus de rigueur sur le format
                    'response_format' => ['type' => 'json_object'] // Force le format JSON si supporté
                ],
            ]);

            $data = $response->toArray();
            $content = $data['choices'][0]['message']['content'];

            // Petit nettoyage au cas où Mistral ajoute du Markdown
            $content = str_replace(['```json', '```'], '', $content);

            return json_decode($content, true);

        } catch (\Exception $e) {
            throw new \RuntimeException('Erreur API Mistral : ' . $e->getMessage());
        }
    }
}
