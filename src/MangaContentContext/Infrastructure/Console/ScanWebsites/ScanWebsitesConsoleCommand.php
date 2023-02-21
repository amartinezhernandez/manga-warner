<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Console\ScanWebsites;

use App\MangaContentContext\Application\Command\ChapterFound\ChapterFoundCommand;
use App\MangaContentContext\Domain\Aggregate\Series;
use App\MangaContentContext\Infrastructure\Domain\Repository\DoctrineSeriesRepository;
use App\MangaContentContext\Infrastructure\Domain\Repository\DoctrineWebsiteRepository;
use App\Shared\Infrastructure\Service\Feed\RssFeedService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'scan:websites',
    hidden: false
)]
final class ScanWebsitesConsoleCommand extends Command
{
    public function __construct(
        private readonly DoctrineWebsiteRepository $websiteRepository,
        private readonly DoctrineSeriesRepository $seriesRepository,
        private readonly RssFeedService $feedService,
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('scan:websites');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $websites = $this->websiteRepository->all();
        $allSeries = $this->seriesRepository->all();
        unset($allSeries[0]);
        foreach ($websites as $website) {
            $feedItems = $this->feedService->scan($website);

            foreach ($allSeries as $series) {
                $matches = $this->match($series, $feedItems);
                foreach ($matches as $match) {
                    $this->messageBus->dispatch(new ChapterFoundCommand(
                        $series->id(),
                        $match['chapter'],
                        $match['date'],
                        $match['link'],
                    ));
                }
            }
        }

        return Command::SUCCESS;
    }

    /**
     * @param Series $series
     * @param array<array{title: string, link: string, date: string}> $feedItems
     * @return array
     */
    private function match(Series $series, array $feedItems): array
    {
        return array_filter($feedItems, function ($item) use ($series) {
            return str_contains($item['link'], $series->slug());
        });
    }
}