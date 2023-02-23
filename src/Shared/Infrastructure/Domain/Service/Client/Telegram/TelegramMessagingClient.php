<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Domain\Service\Client\Telegram;

use App\Shared\Domain\Service\Client\MessagingClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TelegramMessagingClient implements MessagingClient
{
    public function __construct(
        protected readonly HttpClientInterface $client,
        protected readonly string $botApiKey,
    ) {
    }

    public function sendMessage(string $message, string $chatId): bool
    {
        $response = $this->sendRequest('/sendMessage', 'GET', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'markdown'
        ]);

        return $this->isSuccessful($response);
    }

    protected function sendRequest(string $url, string $method, ?array $query = null, ?array $body = null): ResponseInterface
    {
        $options = [];

        if (null !== $query) {
            $options['query'] = $query;
        }

        if (null !== $body) {
            $options['body'] = $body;
        }

        return $this->client->request($method, "/bot$this->botApiKey$url", $options);
    }

    protected function isSuccessful(ResponseInterface $response): bool
    {
        $body = $response->toArray(false);

        return $response->getStatusCode() === Response::HTTP_OK && $body['ok'] === true;
    }
}
