<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Service\Client;

use App\MangaContentContext\Domain\Aggregate\Series;
use App\Shared\Domain\Service\Client\MessagingClient;

interface SeriesMessagingMessagingClient extends MessagingClient
{
    public function warnNewChapter(Series $series, int $chapter, string $url): bool;
}