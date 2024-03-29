<?php

declare(strict_types=1);

namespace App\WebhookContext\Infrastructure\Client\Telegram;

use App\Shared\Infrastructure\Domain\Service\Client\Telegram\TelegramMessagingClient;
use App\WebhookContext\Domain\Client\Telegram\TelegramWebhookClient as TelegramWebhookClientInterface;
use App\WebhookContext\Domain\Exception\WebhookErrorException;

final class TelegramWebhookClient extends TelegramMessagingClient implements TelegramWebhookClientInterface
{
    /** @throws WebhookErrorException */
    public function setWebhook(string $webhook): void
    {
        $response = $this->sendRequest('/setWebhook', 'GET', [
            'url' => $webhook
        ]);

        if (!$this->isSuccessful($response)) {
            throw WebhookErrorException::empty();
        }
    }
}
