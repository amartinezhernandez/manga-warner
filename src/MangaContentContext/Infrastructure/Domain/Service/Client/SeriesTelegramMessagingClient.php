<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Domain\Service\Client;

use App\MangaContentContext\Domain\Aggregate\Series;
use App\MangaContentContext\Domain\Service\Client\SeriesMessagingMessagingClient;
use App\Shared\Infrastructure\Domain\Service\Client\Telegram\TelegramMessagingClient;

final class SeriesTelegramMessagingClient extends TelegramMessagingClient implements SeriesMessagingMessagingClient
{
    public function warnNewChapter(Series $series, int $chapter, string $url): bool
    {
        $message = "Chapter *{$chapter}* for *{$series->name()}* released!. Link: {$url}";

        return $this->sendMessage($message);
    }
}