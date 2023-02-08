<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Client\Telegram;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class TelegramClient
{
    public function __construct(private readonly HttpClientInterface $client, private readonly string $botApiKey)
    {
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
