<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Domain\Repository;

use App\MangaContentContext\Domain\Aggregate\Series;
use App\MangaContentContext\Domain\Repository\SeriesRepository;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Domain\Repository\DoctrineRepository;

/** @extends DoctrineRepository<Series> */
final class DoctrineSeriesRepository extends DoctrineRepository implements SeriesRepository
{
    /** @return Series[] */
    public function all(): array
    {
        return $this->repository()->findAll();
    }

    public function ofId(Uuid $uuid): ?Series
    {
        return $this->repository()->findOneBy([
            'id' => $uuid->id(),
        ]);
    }


    protected function entityClass(): string
    {
        return Series::class;
    }
}