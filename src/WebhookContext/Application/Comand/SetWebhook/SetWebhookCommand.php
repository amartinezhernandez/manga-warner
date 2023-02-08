<?php

declare(strict_types=1);

namespace App\WebhookContext\Application\Comand\SetWebhook;

use App\Shared\Application\Command\Command;

final class SetWebhookCommand implements Command
{
    public function __construct(private readonly string $url)
    {
    }

    public function url(): string
    {
        return $this->url;
    }
}