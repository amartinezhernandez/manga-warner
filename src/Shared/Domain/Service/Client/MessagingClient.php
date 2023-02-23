<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service\Client;

interface MessagingClient
{
    public function sendMessage(string $message, string $chatId): bool;
}