<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Domain\Repository;

use App\MangaContentContext\Domain\Aggregate\Series;
use App\Shared\Infrastructure\Domain\Repository\DoctrineRepository;

final class DoctrineSeriesRepository extends DoctrineRepository
{
    /** @return Series[] */
    public function all(): array
    {
        return $this->repository()->findAll();
    }

    protected function entityClass(): string
    {
        return Series::class;
    }
}