<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Domain\Service\Client;

use App\MangaContentContext\Domain\Service\Client\SeriesMessagingMessagingClient;
use App\Shared\Infrastructure\Domain\Service\Client\Telegram\TelegramMessagingClient;

final class SeriesTelegramMessagingClient extends TelegramMessagingClient implements SeriesMessagingMessagingClient
{
    public function warnNewChapter(string $name, int $chapter, string $url, string $chatId): bool
    {
        return $this->sendMessage(
            sprintf(
                'Chapter *%s* for *%s* released!. Link: %s',
                $chapter,
                $name,
                $url,
            ),
            $chatId,
        );
    }
}