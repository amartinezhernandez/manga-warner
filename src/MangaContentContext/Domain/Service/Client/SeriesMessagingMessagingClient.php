<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Service\Client;

use App\Shared\Domain\Service\Client\MessagingClient;

interface SeriesMessagingMessagingClient extends MessagingClient
{
    public function warnNewChapter(string $name, int $chapter, string $url, string $chatId): bool;
}