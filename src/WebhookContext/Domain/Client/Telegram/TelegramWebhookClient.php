<?php

declare(strict_types=1);

namespace App\WebhookContext\Domain\Client\Telegram;

interface TelegramWebhookClient
{
    public function setWebhook(string $webhook): void;
}