<?php

declare(strict_types=1);

namespace App\WebhookContext\Application\Comand\SetWebhook;

use App\Shared\Application\Command\CommandHandler;
use App\WebhookContext\Domain\Client\Telegram\TelegramWebhookClient;

final class SetWebhookCommandHandler implements CommandHandler
{
    public function __construct(private readonly TelegramWebhookClient $telegramWebhookClient)
    {
    }

    public function __invoke(SetWebhookCommand $command)
    {
        $this->telegramWebhookClient->setWebhook($command->url());
    }
}