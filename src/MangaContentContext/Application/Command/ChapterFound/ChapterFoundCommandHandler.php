<?php

declare(strict_types=1);

namespace App\MangaContentContext\Application\Command\ChapterFound;

use App\MangaContentContext\Domain\Repository\SeriesRepository;
use App\MangaContentContext\Domain\Service\Client\SeriesMessagingMessagingClient;
use App\Shared\Application\Command\CommandHandler;

final class ChapterFoundCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly SeriesMessagingMessagingClient $client,
        private readonly SeriesRepository $seriesRepository,
    ) {
    }

    public function __invoke(ChapterFoundCommand $command)
    {
        $series = $this->seriesRepository->ofId($command->seriesId());

        $this->client->warnNewChapter($series, $command->chapter(), $command->url());
    }
}