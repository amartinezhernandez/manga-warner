<?php

declare(strict_types=1);

namespace App\MangaContentContext\Application\Command\ChapterFound;

use App\MangaContentContext\Domain\Aggregate\Series;
use App\MangaContentContext\Domain\Repository\SeriesRepository;
use App\MangaContentContext\Domain\Repository\SubscriptionRepository;
use App\MangaContentContext\Domain\Service\Client\SeriesMessagingMessagingClient;
use App\Shared\Application\Command\CommandHandler;

final class ChapterFoundCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly SeriesMessagingMessagingClient $client,
        private readonly SeriesRepository $seriesRepository,
        private readonly SubscriptionRepository $subscriptionRepository,
    ) {
    }

    public function __invoke(ChapterFoundCommand $command)
    {
        $series = $this->seriesRepository->ofId($command->seriesId());

        if (null === $series) {
            return;
        }

        // Check if already warned
        if (null !== $series->lastChapter() && $series->lastChapter() >= $command->chapter()) {
            return;
        }

        $series->updateLastChapter($command->chapter());

        $this->warnSubscribers($series, $command);
    }

    private function warnSubscribers(Series $series, ChapterFoundCommand $command): void
    {
        $subscribers = $this->subscriptionRepository->allBySeriesId($series->id());

        foreach ($subscribers as $subscriber) {
            $this->client->warnNewChapter($series->name(), $command->chapter(), $command->url(), $subscriber->chatId());
        }
    }
}