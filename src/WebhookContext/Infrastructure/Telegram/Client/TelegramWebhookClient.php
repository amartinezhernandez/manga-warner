<?php

declare(strict_types=1);

namespace App\WebhookContext\Infrastructure\Telegram\Client;

final class TelegramWebhookClient extends TelegramClient
{
    public function setWebhook(string $webhook): bool
    {
        $response = $this->sendRequest('/setWebhook', 'GET', [
            'url' => $webhook
        ]);

        return $this->isSuccessful($response);
    }
}
